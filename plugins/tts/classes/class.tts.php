<?php

/**
* []
*/
class TTS
{
	public $conn;
    public $sftp;
	public function __construct()
	{
		global $jakdb;
		$this->conn = $jakdb;
        include_once('SFTP/SFTP.php');
	}

	public function ttsSettings($data)
	{
		$fields = [ "ttstitle", "ttsdesc", "ttsdateformat", "ttstimeformat", 
					"ttscancreate", "ttscanedit", "ttscandelete",
					"ttsftphost", "ttsftpport", "ttsftpusername", "ttsftppassword", "ttsftpfldname"];
		
		$mysql_query = 'UPDATE '.DB_PREFIX.'setting SET value = CASE varname ';

		foreach ($data as $k => $value)
		{
			if (in_array($k, $fields))
				$mysql_query .= 'WHEN "'.$k.'" THEN "'.smartsql($value).'" ';
		}

        $mysql_query .= "END WHERE varname IN ( ";
        $last_field = end($fields);
        foreach ($fields as $field)
        {
            if ($last_field == $field) 
                $mysql_query .=  '"'. $field . '" ';
            else
                $mysql_query .=  '"'. $field . '", ';
        }
        $mysql_query .= " ) ";

        $result = $this->conn->query($mysql_query);
        return $result;
	}

	public function csv_to_array($files)
	{
		$room_text = [];
		//add did from csv file
	    if(!empty($files) )
	    {
	        $name = $files['csv']['name'];
	        $type = $files['csv']['type'];
	        $tmpName = $files['csv']['tmp_name'];

	        // check the file is a csv
	        if($type == 'text/csv' || $type == "application/vnd.ms-excel" || $type == "application/octet-stream")
	        {
	            $header = null;
	            if(($handle = fopen($tmpName, 'r')) !== FALSE)
	            {
	                while(($row = fgetcsv($handle, 1000, ',')) !== FALSE)
	                {
	                    if (!$header) {
	                      $header = $row;
	                    }
	                    else {
	                        // remove empty row
	                        if (!empty(array_filter($row)) ) {
	                            $room_text[] = array_combine($header, $row);
	                        }

	                    }
	                }
	                fclose($handle);
	            }
	        }
	    }
	    return $room_text;
	}

	public function createFile($path, $filename, $file_ext ,$data)
	{
		if (file_exists($path . $filename . '.' . $file_ext))
			@unlink($path . $filename . '.' . $file_ext);
		
	    if (!$fp = fopen($path . $filename . '.' . $file_ext, 'x+'))
	        exit('Failed to create file:' . $filename);

	    fwrite($fp, $data);
	    fclose($fp);
	}

    // convert single txt file
    public function wavSingleFile($settings, $txt_path, $wav_path, $download = false)
    {
        if ( !empty($settings["ttsftphost"]) && !empty($settings["ttsftpusername"]) && !empty($settings["ttsftppassword"]) )
        {
            $this->sftp = new SFTP($settings["ttsftphost"], $settings["ttsftpusername"], $settings["ttsftppassword"], $settings["ttsftpport"]);
            if (!$this->sftp->connect())
                throw new Exception("Ftp Connection error");

            if (!empty($txt_path))
            {
                $filebasename = basename($txt_path);
                $f_name='';
                $f_name = 'TXT/'.$filebasename;
                
                if($this->sftp->put($txt_path, $f_name, FTP_BINARY))
                {
                    $txt_name = str_replace(".txt", ".wav", $filebasename);
                    // Download wav files
                    if ($download)
                    {
                        sleep(2);
                        if (file_exists($wav_path.$txt_name))
                            @unlink($wav_path.$txt_name);

                        $f = $this->sftp->get("WAV".DS.$txt_name, $wav_path.$txt_name, FTP_BINARY);
                        if ($f)
                            $this->sftp->delete("WAV".DS.$txt_name);
                    }
                }
            }
            return str_replace("text", "wav", $txt_path);
        }
    }
    
    // Convert list files from txt folder
    public function wavConverter($settings, $txt_path, $wav_path, $download = true)
    {
        if ( !empty($settings["ttsftphost"]) && !empty($settings["ttsftpusername"]) && !empty($settings["ttsftppassword"]) )
        {
            $this->sftp = new SFTP($settings["ttsftphost"], $settings["ttsftpusername"], $settings["ttsftppassword"], $settings["ttsftpport"]);
            if (!$this->sftp->connect())
                throw new Exception("Ftp Connection error");

            //$this->sftp->put("../_files/text_files/room1.txt", "TXT/room1.txt", FTP_BINARY);
            //$this->sftp->put("../_files/text_files/room2.txt", "TXT/room2.txt", FTP_BINARY);
            //$this->sftp->get("WAV".DS."room1.wav", $wav_path."room1.wav", FTP_BINARY);
            
            $txt_files = $this->tts_files($txt_path);
            $upload_txts = []; // array of all the filename sent to ftp server
            if (!empty($txt_files))
            {
                foreach ($txt_files as $k => $file)
                {
                    // $k is att1 and $val["name"]
                    if (!empty($file["name"]) && !empty($file["path"]) )
                    {
                        $f_name='';
                        $f_name = 'TXT/'.$file["name"];
                        
                        if($this->sftp->put($file["path"], $f_name, FTP_BINARY))
                        {
                            $upload_txts[$k] = str_replace(".txt", ".wav", $file["name"]);
                        }
                    }
                    else
                    {
                        // if not text file
                    }
                }
            }
            // Download wav files
            if (!empty($upload_txts) && $download == true)
            {
                sort($upload_txts);
                sleep(5);
                foreach($upload_txts as $txt_name)
                {
                    $f='';
                    $f = $this->sftp->get("WAV".DS.$txt_name, $wav_path.$txt_name, FTP_BINARY);
                    if ($f)
                        $this->sftp->delete("WAV".DS.$txt_name);
                }
            }
            return str_replace("text", "wav", $txt_path);
        }
    }

    // Upload txt files
    public function uploadTxtFiles($settings, $txt_path, $selected_files = null)
    {
        if ( !empty($settings["ttsftphost"]) && !empty($settings["ttsftpusername"]) && !empty($settings["ttsftppassword"]) )
        {
            $this->sftp = new SFTP($settings["ttsftphost"], $settings["ttsftpusername"], $settings["ttsftppassword"], $settings["ttsftpport"]);
            if (!$this->sftp->connect())
                throw new Exception("Ftp Connection error");

            $upload_txts = []; // array of all the filename sent to ftp server
            // Selected text files
            if (!empty($selected_files) )
            {
                if ( is_array($selected_files))
                {
                    foreach ($selected_files as $selected_file)
                    {
                        if (file_exists($txt_path.$selected_file))
                        {
                            if($this->sftp->put($txt_path.$selected_file, 'TXT/'.$selected_file, FTP_BINARY))
                            {
                                $upload_txts[$k] = str_replace(".txt", ".wav", $file["name"]);
                            }
                        }
                    }
                }
                else
                {
                    if (file_exists($txt_path.$selected_files))
                    {
                        if($this->sftp->put($txt_path.$selected_files, 'TXT/'.$selected_files, FTP_BINARY))
                        {
                            $upload_txts[$k] = str_replace(".txt", ".wav", $file["name"]);
                        }
                    }
                }
                
            }
            
            if (empty($selected_files))
            {
                // upload all files
                $txt_files = $this->tts_files($txt_path);
                if (!empty($txt_files))
                {
                    foreach ($txt_files as $k => $file)
                    {
                        // $k is att1 and $val["name"]
                        if (!empty($file["name"]) && !empty($file["path"]) && $file["name"] != "ems2wav.ems" )
                        {
                            $f_name='';
                            $f_name = 'TXT/'.$file["name"];
                            
                            if($this->sftp->put($file["path"], $f_name, FTP_BINARY))
                            {
                                $upload_txts[$k] = str_replace(".txt", ".wav", $file["name"]);
                            }
                        }
                        else
                        {
                            // if not text file
                        }
                    }
                }
            }
            $this->sftp->put($txt_path."ems2wav.ems", "ems2wav.ems", FTP_BINARY);
            return $upload_txts;
        }
    }

    // Download txt files
    public function FtpWavFiles($settings, $path, $list=true, $download=false)
    {
        if ( !empty($settings["ttsftphost"]) && !empty($settings["ttsftpusername"]) && !empty($settings["ttsftppassword"]) )
        {
            $this->sftp = new SFTP($settings["ttsftphost"], $settings["ttsftpusername"], $settings["ttsftppassword"], $settings["ttsftpport"]);
            if (!$this->sftp->connect())
                throw new Exception("Ftp Connection error");

            if ($list && !$download)
                return $this->sftp->ls($path);

            if (!$list && $download)
            {
                $file_basename = basename($path);
                ob_start();
                $f = $this->sftp->get($path, "php://output", FTP_BINARY);
                $file_data = ob_get_contents();
                ob_end_clean();
                return $file_data;
            }
        }
    }

    public function DeleteLocalFiles($path, $files)
    {
        if (!empty($path) && !empty($files))
        {
            if (is_array($files))
            {
                foreach ($files as $file)
                {
                    if (file_exists($path.$file))
                        @unlink($path.$file);
                }
            }
            else
            {
                if (file_exists($path.$files))
                    @unlink($path.$files);
            }
        }
    }

    public function FtpDeleteFile($settings, $filename)
    {
        if ( !empty($settings["ttsftphost"]) && !empty($settings["ttsftpusername"]) && !empty($settings["ttsftppassword"]) )
        {
            $this->sftp = new SFTP($settings["ttsftphost"], $settings["ttsftpusername"], 
                                $settings["ttsftppassword"], $settings["ttsftpport"]
                            );
            if (!$this->sftp->connect())
                throw new Exception("Ftp Connection error");

            if (!empty($filename)) 
            {
                if (is_array($filename))
                {
                    foreach ($filename as $key => $f)
                    {
                        $this->sftp->delete( $settings["ttsftpfldname"]."/".$f);
                    }
                }
                else
                {
                    $this->sftp->delete( $settings["ttsftpfldname"]."/".$filename);
                }
            }
        }
    }

    public function ftpZipFolder($settings, $dir_source)
    {
        if ( !empty($settings["ttsftphost"]) && !empty($settings["ttsftpusername"]) && !empty($settings["ttsftppassword"]) )
        {
            $this->sftp = new SFTP($settings["ttsftphost"], $settings["ttsftpusername"], 
                                $settings["ttsftppassword"], $settings["ttsftpport"]
                            );
            if (!$this->sftp->connect())
                throw new Exception("Ftp Connection error");

            $dir_exists = $this->sftp->cd($dir_source);
            if ($dir_exists)
            {
                # code...
            }
        }
    }

    // Check permission of php temp folder
    public function ftpZipFiles($settings, $ftppath, $files, $cross_check_file=null)
    {
        if ( !empty($settings["ttsftphost"]) && !empty($settings["ttsftpusername"]) && !empty($settings["ttsftppassword"]) )
        {
            $this->sftp = new SFTP($settings["ttsftphost"], $settings["ttsftpusername"], 
                                $settings["ttsftppassword"], $settings["ttsftpport"]
                            );
            if (!$this->sftp->connect())
                throw new Exception("Ftp Connection error");
                
            // Download and zip each file
            if (!empty($files)) {
               
                // Attempt to get a $serverTmp var if not set by user
                $serverTmp = ini_get('upload_tmp_dir') ? ini_get('upload_tmp_dir') : sys_get_temp_dir();
                $unlinkFileAr=[];

                $zip_file_name   = "tts_wav_".date("Y_m_d_H_i_s").".zip";
                $zip_file        = tempnam($serverTmp, $zip_file_name);
                $zip             = new ZipArchive();
                $zip->open($zip_file, ZipArchive::CREATE);

                foreach ($files as $file) 
                {
                    if (!empty($cross_check_file))
                    {
                        if (in_array($file, $cross_check_file))
                        {
                            $local_file  = tempnam($serverTmp, $file);
                            $remote_file = $ftppath.$file;
                            // Download file to client server
                            $f = $this->sftp->get($remote_file, $local_file, FTP_BINARY);
                            if ($f)
                            {
                                $unlinkFileAr[] = $local_file;
                                // Add file to zip
                                $zip->addFile($local_file, $file);
                            }
                        }
                        else
                        {
                            //File doesn't exist on server
                        }
                    }
                    else
                    {
                        $local_file  = tempnam($serverTmp, $file);
                        $remote_file = $ftppath.$file;
                        // Download file to client server
                        $f = $this->sftp->get($remote_file, $local_file, FTP_BINARY);
                        if ($f)
                        {
                            $unlinkFileAr[] = $local_file;
                            // Add file to zip
                            $zip->addFile($local_file, $file);
                        }   
                    }
                }
                $zip->close();

                // Unlink tmp files
                foreach ($unlinkFileAr as $file) {
                    @unlink($file);
                }

                //ob_flush();
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
                //ob_end_flush();
                // Delete tmp file
                unlink($zip_file);
              
            }
        }
        
    }

    public function zipLocalFile($path, $files)
    {
        // Download and zip each file
        if (!empty($files)) 
        {   
            // Attempt to get a $serverTmp var if not set by user
            $serverTmp = ini_get('upload_tmp_dir') ? ini_get('upload_tmp_dir') : sys_get_temp_dir();

            $zip_file_name   = "tts_text_".date("Y_m_d_H_i_s").".zip";
            $zip_file        = tempnam($serverTmp, $zip_file_name);
            $zip             = new ZipArchive();
            $zip->open($zip_file, ZipArchive::CREATE);

            foreach ($files as $file) 
            {
                $fullPath_file = $path.$file['name'];
                if (file_exists($fullPath_file))
                {
                    // Add file to zip
                    $zip->addFile($fullPath_file, $file['name']);
                }            
            }
            $zip->close();

            //ob_flush();
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
            //ob_end_flush();
            // Delete tmp file
            unlink($zip_file);
        }
    }

	public function tts_files($directory, $exempt = array('.','ems2wav.ems','..','.ds_store','.svn','preview.jpg','index.html','js','css','img','_cache'), &$files = array())
	{
	    if (empty($directory) || !file_exists($directory)) {
	        return [];
	    }
	    $handle = opendir($directory);
	    while(false !== ($resource = readdir($handle))) {
	        if(!in_array(strtolower($resource),$exempt)) {
	            if(is_dir($directory.$resource)) {
                    array_merge($files, getFiles($directory.$resource,$exempt,$files));
	            } else {
	                if (is_writable($directory.$resource)) {
	                    $files[] = array(
	                        'path' => $directory . $resource,
	                        'name' => trim($resource),
	                        'date' => date("F d Y H:i:s.", filemtime($directory . $resource)),
	                        'type' => filetype($directory . $resource)
	                    );
	                }
	            }
	        }
	    }
	    closedir($handle);
	    return $files;
	}

	// get local device files
	public function tts_dirs($directory, $exempt = array('.','..','.ds_store','.svn', 'single_files','css','img','_cache'))
	{
	    if (empty($directory) || !file_exists($directory)) {
	        return [];
	    }
	    $dirs=[];
	    foreach (scandir($directory) as $k => $v) {
	        if (is_dir($directory.$v) && !in_array($v, $exempt))
	        {
	            $dirs[] =[
	                'name' => $v,
	                'date' => date("F d Y H:i:s.", filemtime($directory.$v)),
	                'path' => $directory.$v,
	                'type' => filetype($directory . $v)
	            ];
	        }
	    }
	    return $dirs;
	}
	
}