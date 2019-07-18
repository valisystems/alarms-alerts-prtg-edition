<?php
/*===============================================*\
|| ############################################# ||
|| # Claricom.ca                               # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 Claricom All Rights Reserved ||
|| ############################################# ||
\*===============================================*/
define("DS", DIRECTORY_SEPARATOR);
// Check if the file is accessed only via index.php if not stop the script from running
if (!defined('JAK_ADMIN_PREVENT_ACCESS')) die('You cannot access this file directly.');

// Check if the user has access to this file
if (!JAK_USERID || !$jakuser->jakModuleaccess(JAK_USERID,JAK_ACCESSDEVICE)) jak_redirect(BASE_URL);

// All the tables we need for this plugin
$jaktable = DB_PREFIX.'tts';
// Include the functions
include_once("../plugins/tts/functions.php");

//JAK_PLUGIN_TTS

// Now start with the plugin use a switch to access all pages
switch ($page1) {

	case 'files':
		include '/../classes/class.tts.php';
		$ttsObj = new TTS();

        $PAGE_TITLE = 'TTS Files';
        switch ($page2) {
            case 'txt':
                $PAGE_CONTENT = 'Text Files';
                $JAK_FILES = $ttsObj->tts_files('..'.DS.'_files'.DS.'text_files'.DS);
                // Download all file in zip folder
	        	if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST["action"] == 'download_zip')
	        	{
	        		$ttsObj->zipLocalFile('..'.DS.'_files'.DS.'text_files'.DS, $JAK_FILES);
	        	}
                $plugin_template = 'plugins/tts/admin/template/files.php';
            break;
            case 'wav':
                $PAGE_CONTENT = 'WAV Files';
                $JAK_FILES = $ttsObj->FtpWavFiles($jkv, $jkv['ttsftpfldname']."/", $list=true, $download=false);
                
                // Download all file in zip folder
	        	if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST["action"] == 'download_zip')
	        	{
	        		$ttsObj->ftpZipFiles($jkv, $jkv['ttsftpfldname']."/", $JAK_FILES);
	        	}

	        	if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST["action"] == 'selected_download_zip')
	        	{
	        		if (!empty($_POST['tts_selected_wav_file']))
		        		$ttsObj->ftpZipFiles($jkv, $jkv['ttsftpfldname']."/", $_POST['tts_selected_wav_file'], $JAK_FILES);
	        	}
                
                // Convert Single File
	        	if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST["action"] == 'download')
	        	{
	        		$file_content= $ttsObj->FtpWavFiles($jkv, $jkv['ttsftpfldname']."/". $_POST["filename"], false, true);
	        		header('Content-Disposition: attachment; filename=' . $_POST["filename"]);
	                header('Content-Type: audio/wav');
	                header('Content-Length: ' . strlen($file_content));
	                header('Connection: close');
	                echo $file_content;
	                exit;
	        	}
                $plugin_template = 'plugins/tts/admin/template/wav_files.php';

            break;
            default:
            	jak_redirect(BASE_URL.'index.php?p=tts&sp=files&ssp=txt');
            break;
        }
		
	break; // END of catch file CASE

	case 'ajax':
		include '/../classes/class.tts.php';
		$ttsObj = new TTS();

		if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
        	// delete single file
        	if ($_POST["action"] == 'del' && !empty($_POST["filename"]))
        	{
        		switch ($page2) {
	        		case 'txt':
	        			$ttsObj->DeleteLocalFiles(APP_PATH.'_files'.DS.'text_files'.DS, $_POST["filename"]);
	        		break;
	        		case 'wav':
	        			$ttsObj->FtpDeleteFile($jkv, $_POST["filename"]);
	        		break;
	        	}
        	}

        	// single selected files
        	if ($_POST["action"] == 'convert')
        	{
        		if (!empty($_POST['filename'])) 
        		{
				    $ttsObj->uploadTxtFiles($jkv, "../_files/text_files/", $_POST['filename']);
        		}
        	}

        	// checkbox selected files
        	if ($_POST["action"] == 'ConvertselectedFiles')
        	{
        		if (!empty($_POST['selectedfilename'])) 
        		{
        			$convert_files = $_POST['selectedfilename'];
				    $ttsObj->uploadTxtFiles($jkv, "../_files/text_files/", $convert_files);
        		}
        	}

        }
		$plugin_template = 'plugins/tts/admin/template/json.php';
	break;

	// not been used
	case 'zip':
		if (!empty($_POST))
		{
			include '/../classes/class.zip.php';
			$folder_name = APP_PATH."_files/".$_POST["folder_name"];
    		$zip_name = $_POST["folder_name"] . '.zip';
		    
		    $za = new BZipArchive;
		    $res = $za->open($zip_name, ZipArchive::CREATE);
		    if($res === TRUE) 
		    {
		        $za->addDir($folder_name, basename($folder_name));
		        $za->close();
		    }
		    else 
		    { 
		        echo 'Could not create a zip archive';
		    }

	    	// Download zip
	        ob_get_clean();
	        header("Pragma: public");
	        header("Expires: 0");
	        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	        header("Cache-Control: private", false);
	        header("Content-Type: application/zip");
	        header("Content-Disposition: attachment; filename=" . basename($zip_name) . ";" );
	        header("Content-Transfer-Encoding: binary");
	        header("Content-Length: " . filesize($zip_name));
	        readfile($zip_name);

	        @unlink($zip_name);
        }
        $plugin_template = 'plugins/tts/admin/template/zip.php';
	break;

	case 'download':
		if (!empty($_POST))
		{
			include '/../classes/class.zip.php';
			
			$folder_name = APP_PATH."_files/".$_POST["folder_name"];
    		$zip_name = $_POST["folder_name"] . '.zip';
		    
		    $za = new BZipArchive;
		    $res = $za->open($zip_name, ZipArchive::CREATE);
		    if($res === TRUE) 
		    {
		        $za->addDir($folder_name, basename($folder_name));
		        $za->close();
		    }
		    else 
		    { 
		        echo 'Could not create a zip archive';
		    }

		    	// download zip
		        ob_get_clean();
		        header("Pragma: public");
		        header("Expires: 0");
		        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		        header("Cache-Control: private", false);
		        header("Content-Type: application/zip");
		        header("Content-Disposition: attachment; filename=" . basename($zip_name) . ";" );
		        header("Content-Transfer-Encoding: binary");
		        header("Content-Length: " . filesize($zip_name));
		        readfile($zip_name);
        }
        //jak_redirect(BASE_URL.'index.php?p=tts&sp=files');
	break;

	case 'settings':

		include '/../classes/class.tts.php';
		$ttsObj = new TTS();
	
		$JAK_SETTING = jak_get_setting('tts');
		
		// Get the special vars for multi language support
		$JAK_FORM_DATA["title"] = $jkv["ttstitle"];
		$JAK_FORM_DATA["content"] = $jkv["ttsdesc"];

		// Title and Description
		$SECTION_TITLE = $tltts["tts"]["n"].' - '.$tl["menu"]["m2"];
		$SECTION_DESC = $tl["cmdesc"]["d2"];

		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$defaults = $_POST;
			$defaults['ttsdesc'] = $defaults['jak_lcontent'];
			if (empty($defaults['ttstitle']))
		        $errors['e1'] = $tl['error']['e2'];
		    if (empty($defaults['ttsftpfldname']))
		        $errors['e3'] = "Please provide wav folder name";

		    if (count($errors) == 0)
		    {
		    	if (!empty($defaults['ttsftpfldname']))
		    	{
		    		$ttsObj->createFile(APP_PATH."_files/text_files/", 'ems2wav', "ems", 
									(!empty($jkv['ttsftpfldname']) ? $jkv['ttsftpfldname']: "random_noname")
								);
		    	}
			    $result = $ttsObj->ttsSettings($defaults);
			    if (!$result)
					jak_redirect(BASE_URL.'index.php?p=tts&sp=settings&ssp=e');
				else
			    	jak_redirect(BASE_URL.'index.php?p=tts&sp=settings&ssp=s');
			}
			else
			{
				$errors['e'] = $tl['error']['e'];
		    	$errors = $errors;
			}
		}
		// Call the template
		$plugin_template = 'plugins/tts/admin/template/setting.php';
	break;

	default:
		include '/../classes/class.tts.php';
		$ttsObj = new TTS();

		if (empty($jkv['ttsftpfldname']))
		        $errors['e1'] = "Please enter Wav Folder name in settings.";
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			if (empty($_FILES['csv']['name']))
		        $errors['e2'] = "Please upload CSV file.";

			if (count($errors) == 0 && !empty($_FILES['csv']['name']))
			{
				$csv_arr = $ttsObj->csv_to_array($_FILES);
			    if (!empty($csv_arr))
			    {
			    	foreach ($csv_arr as $data)
					{
						$txt_file_name  = (preg_replace('/\s+/', '_', trim($data["rooms"]))) ;
					    $ttsObj->createFile(APP_PATH."_files/text_files/", $txt_file_name, "txt", $data["text"]);
					}
					if ($_POST['convert_now']) {
						$ttsObj->uploadTxtFiles($jkv, "../_files/text_files/");
					}
					
					jak_redirect(BASE_URL.'index.php?p=tts&sp=files&ssp=txt');
			    }
			}
			else
			{
				$errors['e'] = $tl['error']['e'];
			}

		}
		$plugin_template = 'plugins/tts/admin/template/csv_upload.php';
	break;
}