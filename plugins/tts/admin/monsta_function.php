<?php


function saveFtpDetailsCookie()
{
    
    if ($_POST["login"] == 1) {
        
        if ($_POST["login_save"] == 1) {
            
            $s = 31536000; // seconds in a year
            setcookie("ftp_ssl", $_POST["ftp_ssl"], time() + $s, '/', null, null, true);
            setcookie("ftp_host", trim($_POST["ftp_host"]), time() + $s, '/', null, null, true);
            setcookie("ftp_user", trim($_POST["ftp_user"]), time() + $s, '/', null, null, true);
            setcookie("ftp_pass", trim($_POST["ftp_pass"]), time() + $s, '/', null, null, true);
            setcookie("ftp_port", trim($_POST["ftp_port"]), time() + $s, '/', null, null, true);
            setcookie("ftp_pasv", $_POST["ftp_pasv"], time() + $s, '/', null, null, true);
            setcookie("interface", $_POST["interface"], time() + $s, '/', null, null, true);
            setcookie("login_save", $_POST["login_save"], time() + $s, '/', null, null, true);
            setcookie("ip_check", $_POST["ip_check"], time() + $s, '/', null, null, true);
            
        } else {
            
            setcookie("ftp_ssl", "", time() - 3600);
            setcookie("ftp_host", "", time() - 3600);
            setcookie("ftp_user", "", time() - 3600);
            setcookie("ftp_pass", "", time() - 3600);
            setcookie("ftp_port", "", time() - 3600);
            setcookie("ftp_pasv", "", time() - 3600);
            setcookie("interface", "", time() - 3600);
            setcookie("login_save", "", time() - 3600);
            setcookie("ip_check", "", time() - 3600);
        }
    }
}


function attemptLogin()
{
    
    global $conn_id;
    global $ftpHost;
    global $ftpPort;
    global $ftpMode;
    global $ftpSSL;
    global $ftpDir;
    
    if (connectFTP(0) == 1 && $_POST["login"] != 1)
    {
        // Check for hijacked session with IP check
        if ($_SESSION["ip_check"] == 1)
        {            
            if ($_SERVER['REMOTE_ADDR'] == $_SESSION["user_ip"]) {
                $_SESSION["loggedin"] = 1;
            } else {
                $_SESSION["errors"] = "Your IP address conflicts with the session IP";
                sessionExpired("Your IP address conflicts with the session IP");
                logOut();
            }
            
        } else {
            $_SESSION["loggedin"] = 1;
        }

    } else {
        
        if ($_POST["login"] == 1) {
            
            // Check for login errors
            if (checkLoginErrors() == 1) {
                
                $_SESSION["login_error"] = "Error! Please complete all the marked fields";
                displayLoginForm(1);
                
            } else {
                
                $_SESSION["ftp_host"] = $ftpHost;
                $_SESSION["ftp_port"] = $ftpPort;
                $_SESSION["ftp_pasv"] = $ftpMode;
                $_SESSION["ftp_ssl"]  = $ftpSSL;
                
                
                $_SESSION["ftp_user"]  = trim($_POST["ftp_user"]);
                $_SESSION["ftp_pass"]  = trim($_POST["ftp_pass"]);
                $_SESSION["interface"] = empty($_POST["interface"])?"":"adv";
                $_SESSION["ip_check"]  = $_POST["ip_check"];
                
                if (connectFTP(1) == 1) {
                    
                    $_SESSION["loggedin"] = 1;
                    
                    // Save user's IP address
                    $_SESSION["user_ip"] = $_SERVER['REMOTE_ADDR'];
                    
                    // Set platform
                    getPlatform();
                    
                    // Change dir if one set
                    if ($ftpDir != "") {
                        if (@ftp_chdir($conn_id, $ftpDir)) {
                            $_SESSION["dir_current"] = $ftpDir;
                        } else {
                            if (@ftp_chdir($conn_id, "~" . $ftpDir))
                                $_SESSION["dir_current"] = "~" . $ftpDir;
                        }
                    }
                    
                } else {
                    displayLoginForm(1);
                }
            }
            
        } else {
            displayLoginForm(0);
        }
    }
}



function checkLoginErrors()
{
    
    global $ftpHost;
    
    // Check for blank fields
    if ($ftpHost == "") {
        if ($_POST["ftp_host"] == "" || trim($_POST["ftp_user"]) == "" || trim($_POST["ftp_pass"]) == "" || trim($_POST["ftp_port"]) == "")
            return 1;
        else
            return 0;
    }
    
    if ($ftpHost != "") {
        if (trim($_POST["ftp_user"]) == "" || trim($_POST["ftp_pass"]) == "")
            return 1;
        else
            return 0;
    }
}

function connectFTP($posted)
{
    
    global $conn_id;
    global $lockOutTime;
    
    if ($_SESSION["ftp_host"] != "" && $_SESSION["ftp_port"] != "" && $_SESSION["ftp_user"] != "" && $_SESSION["ftp_pass"] != "") {
        
        // Connect
        if ($_SESSION["ftp_ssl"] == 1)
            $conn_id = @ftp_ssl_connect($_SESSION["ftp_host"], $_SESSION["ftp_port"]) or $connectFail = 1;
        else
            $conn_id = @ftp_connect($_SESSION["ftp_host"], $_SESSION["ftp_port"]) or $connectFail = 1;
        
        if ($connectFail == 1) {
            $_SESSION["login_error"] = "Error! Couldn't connect to FTP host";
            return 0;
        } else {
            
            // Check for lockout
            $date_now = date("YmdHis");
            if ($_SESSION["login_lockout"] == "" || ($_SESSION["login_lockout"] > 0 && $date_now > $_SESSION["login_lockout"])) {
                
                // Authenticate
                if (@ftp_login($conn_id, $_SESSION["ftp_user"], $_SESSION["ftp_pass"])) {
                    
                    if ($_SESSION["ftp_pasv"] == 1)
                        @ftp_pasv($conn_id, true);
                    
                    $_SESSION["loggedin"]    = 1;
                    $_SESSION["login_fails"] = 0;
                    
                    return 1;
                    
                } else {
                    
                    $_SESSION["login_error"] = "Error! Couldn't authenticate your login";
                    
                    // Count the failed login attempts (if form posted)
                    if ($posted == 1) {
                        
                        $_SESSION["login_fails"]++;
                        
                        // Lock user for 5 minutes if 3 failed attempts
                        if ($_SESSION["login_fails"] >= 3)
                            $_SESSION["login_lockout"] = date("YmdHis") + ($lockOutTime * 60);
                    }
                    
                    return 0;
                }
            }
        }
    } else {
        return 0;
    }
}


function getFtpRawList($folder_path)
{

    // Because ftp_rawlist() doesn't support folders with spaces in
    // their names, it is neccessary to first change into the directory.
    global $conn_id;
    
    $isError = 0;
    
    if (!@ftp_chdir($conn_id, $folder_path)) {
        if (checkFirstCharTilde($folder_path) == 1) {
            if (!@ftp_chdir($conn_id, replaceTilde($folder_path))) {
                recordFileError("folder", replaceTilde($folder_path), "Unable to access [folder]");
                $isError = 1;
            }
        } else {
            recordFileError("folder", $folder_path, "Unable to access [folder]");
            $isError = 1;
        }
    }

    if ($isError == 0)
        return ftp_rawlist($conn_id, ".");
}



function downloadFile()
{
    global $conn_id;
    
    $isError = 0;
    
    $file      = quotesUnescape($_GET["dl"]);
    $file_name = getFileFromPath($file);
    $fp1       = createTempFileName($file_name);
    $fp2       = $file;
    
    ensureFtpConnActive();
    
    // Download the file
    if (!@ftp_get($conn_id, $fp1, $fp2, FTP_BINARY)) {
        if (checkFirstCharTilde($fp2) == 1) {
            if (!@ftp_get($conn_id, $fp1, replaceTilde($fp2), FTP_BINARY)) {
                recordFileError("file", quotesEscape($file, "s"), "Server error downloading [file]");
                $isError = 1;
            }
        } else {
            recordFileError("file", quotesEscape($file, "s"), "Server error downloading [file]");
            $isError = 1;
        }
    }
    
    if ($isError == 0) {
        
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"" . quotesEscape($file_name, "d") . "\""); // quotes required for spacing in filename
        header("Content-Length: " . filesize($fp1));
        
        flush();
        
        $fp = @fopen($fp1, "r");
        while (!feof($fp)) {
            echo @fread($fp, 65536);
            @flush();
        }
        @fclose($fp);
    }
    
    // Delete tmp file
    unlink($fp1);
}


function downloadFiles()
{

    $conn_id = @ftp_connect($_SESSION["ftp_host"], $_SESSION["ftp_port"]) or $connectFail = 1;
    @ftp_login($conn_id, $_SESSION["ftp_user"], $_SESSION["ftp_pass"]);

    global $conn_id;
    global $serverTmp;
    global $downloadFileAr;

    clipboard_files();
    
    $downloadFileAr = array();
    $unlinkFileAr = array();
  
    // Folders
    foreach ($_SESSION["clipboard_folders"] as $folder) {
        
        $folder = urldecode($folder);
        $folder_name = getFileFromPath($folder);
        $dir_source = getParentDir($folder);
        
        downloadFolder($folder_name, $dir_source);
    }
    
    // Files
    foreach ($_SESSION["FTP_clipboard_files"] as $file) {
        $downloadFileAr[] = urldecode($file);
    }
    
    // Download and zip each file
    if (sizeof($downloadFileAr) > 1) {
        
        $zip_file_name   = "tts_ftp_".date("Y_m_d_H_i_s").".zip";
        $zip_file        = createTempFileName($zip_file_name);
        $zip             = new ZipArchive();
        $zip->open($zip_file, ZipArchive::CREATE);
    
        foreach ($downloadFileAr as $file) {
    
            $file_name = getFileFromPath($file);
            $fp1       = createTempFileName($file_name);
            $fp2       = $file;
            
            $unlinkFileAr[] = $fp1;
            
            $isError = 0;
            
            ensureFtpConnActive();
        
            // Download file to client server
            if (!@ftp_get($conn_id, $fp1, $fp2, FTP_BINARY)) {
               if (checkFirstCharTilde($fp2) == 1) {
                   if (!@ftp_get($conn_id, $fp1, replaceTilde($fp2), FTP_BINARY)) {
                        recordFileError("file", $file_name, "Server error downloading [file]");
                        $isError = 1;
                   }
               } else {
                   recordFileError("file", $file_name, "Server error downloading [file]");
                   $isError = 1;
               }
            }
    
            if ($isError == 0) {
    
                // Remove the current folder path
                $file_path = str_replace($_SESSION["dir_current"]."/","",$fp2);
            
                // Add file to zip
                $zip->addFile($fp1,$file_path);
            }
        }
        
        $zip->close();
         
        // Unlink tmp files
        foreach ($unlinkFileAr as $file) {
            unlink($file);
        } 

        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"".$zip_file_name."\"");
        header("Content-Length: " . filesize($zip_file));

        flush();
        
        $fp = @fopen($zip_file, "r");
        while (!feof($fp)) {
            echo @fread($fp, 65536);
            @flush();
        }
        @fclose($fp);

        // Delete tmp file
        unlink($zip_file);
      
    }
    
    // Download just one file
    if (sizeof($downloadFileAr) == 1) {
        $_GET["dl"] = $downloadFileAr[0];
        downloadFile();
    }
   
    $_SESSION["clipboard_folders"] = array();
    $_SESSION["clipboard_files"]   = array();
}

function downloadFolder($folder, $dir_source)
{
    
    $conn_id = @ftp_connect($_SESSION["ftp_host"], $_SESSION["ftp_port"]) or $connectFail = 1;
    global $downloadFileAr;
    global $showDotFiles;

    $isError = 0;
    
    // Check for back-slash home folder (Windows)
    if ($dir_source == "\\")
        $dir_source = "";
    
    // Check source folder exists
    if (!@ftp_chdir($conn_id, $dir_source . "/" . $folder)) {
        if (checkFirstCharTilde($dir_source) == 1) {
            if (!@ftp_chdir($conn_id, replaceTilde($dir_source) . "/" . $folder)) {
                recordFileError("folder", tidyFolderPath($dir_source, $folder), "Unable to access [folder]");
                $isError = 1;
            }
        } else {
            recordFileError("folder", tidyFolderPath($dir_source, $folder), "Unable to access [folder]");
            $isError = 1;
        }
    }
    
    if ($isError == 0) {
        
        // Go through array of files/folders
        $ftp_rawlist = getFtpRawList($dir_source . "/" . $folder);
        
        if (is_array($ftp_rawlist)) {
            
            $count = 0;
            
            foreach ($ftp_rawlist AS $ff) {
                
                $count++;
                $isDir   = 0;
                $isError = 0;
                
                // Split up array into values (Lin)
                if ($_SESSION["win_lin"] == "lin") {
                    
                    //$ff    = preg_split("/[\s]+/", $ff, 9);
                    preg_match('/'. str_repeat('([^\s]+)\s+',7) . '([^\s]+) (.+)/', $ff, $matches);
                    $ff = array_slice($matches, 1);
                    $perms = $ff[0];
                    $file  = $ff[8];
                    
                    if (getFileType($perms) == "d")
                        $isDir = 1;
                }
                
                // Split up array into values (Mac)
                elseif ($_SESSION["win_lin"] == "mac") {
                    
                    if ($count == 1)
                        continue;
                    
                    //$ff    = preg_split("/[\s]+/", $ff, 9);
                    preg_match('/'. str_repeat('([^\s]+)\s+',7) . '([^\s]+) (.+)/', $ff, $matches);
                    $ff = array_slice($matches, 1);
                    $perms = $ff[0];
                    $file  = $ff[8];
                    
                    if (getFileType($perms) == "d")
                        $isDir = 1;
                }
                
                // Split up array into values (Win)
                elseif ($_SESSION["win_lin"] == "win") {
                    
                    $ff   = preg_split("/[\s]+/", $ff, 4);
                    $size = $ff[2];
                    $file = $ff[3];
                    
                    if ($size == "<DIR>")
                        $isDir = 1;
                }
                
                $dot_prefix = 0;
                if ($showDotFiles == 0) {
                    if (preg_match("/^\.+/", $file))
                        $dot_prefix = 1;
                }
                
                if ($file != "." && $file != ".." && $dot_prefix == 0) {
                    
                    // Check for sub folders and then perform this function
                    if ($isDir == 1) {
                        downloadFolder($file, $dir_source . "/" . $folder);
                    } else {
                        $downloadFileAr[] = $dir_source . "/" . $folder . "/" . $file;
                    }
                }
            }
        }
    }
}

function clipboard_files()
{ 
    // Recreate arrays
    $folderArray = recreateFileFolderArrays("folder");
    $fileArray   = recreateFileFolderArrays("file");
    
    // Reset cut session var
    $_SESSION["clipboard_folders"] = array();
    $_SESSION["clipboard_files"]   = array();
    
    // Folders
    foreach ($folderArray AS $folder) {
        $_SESSION["clipboard_folders"][] = quotesUnescape($folder);
    }
    
    // Files
    foreach ($fileArray AS $file) {
        $_SESSION["clipboard_files"][] = quotesUnescape($file);
    }
}

function recreateFileFolderArrays($type)
{
    $arrayNew = array();
    
    if ($_POST["fileSingle"] != "" || $_POST["folderSingle"] != "") {
        
        // Single file/folder
        if ($type == "file" && $_POST["fileSingle"] != "") {
            $file       = quotesUnescape($_POST["fileSingle"]);
            $arrayNew[] = $file;
        }
        if ($type == "folder" && $_POST["folderSingle"] != "")
            $arrayNew[] = quotesUnescape($_POST["folderSingle"]);
        
    } else {
        
        // Array file/folder
        if ($type == "file")
            $array = $_POST["fileAction"];
        if ($type == "folder")
            $array = $_POST["folderAction"];
        
        if (is_array($array)) {
            
            foreach ($array AS $file) {
                
                $file = quotesUnescape($file);
                
                if ($file != "")
                    $arrayNew[] = $file;
            }
        }
    }
    
    return $arrayNew;
}

