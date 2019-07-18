<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Get the data per array devices
function jak_get_devices($limit,$jakvar1,$table) {

	$sqlwhere = '';
	//if (!empty($jakvar1)) $sqlwhere = 'WHERE catid = '.smartsql($jakvar1).' ';

	global $jakdb;
	$jakdata = array();
    $result = $jakdb->query('SELECT * FROM '.$table.' '.$sqlwhere.' ORDER BY event_type ASC '.$limit);
    while ($row = $result->fetch_assoc()) {
            // collect each record into $_data
            $jakdata[] = $row;
        }

    return $jakdata;
}

function jak_deviceExist($data)
{
    global $jakdb;
    $stmt = $jakdb->query('SELECT * FROM ' . DB_PREFIX . 'device WHERE device_id = "' . $data["jak_device_id"] . '" AND base_name = "' . $data["jak_base_name"].'"; ');
    $row = $stmt->fetch_assoc();
    if($row)
    {
        return $row;
    }
    return false;
}

function jak_changeEventType($action, $data)
{
    $query ='';
    if ($action == 'singleAlarm' && !empty($data['device_id']) && !empty($data['basename']) )
    {
        $query = "UPDATE " . DB_PREFIX . "device SET event_type='".smartsql($data['event_type'])."' WHERE base_name = '" .$data['basename']. "' AND device_id = '" . $data['device_id'] . "';" ;
    }
    elseif ($action == 'cancelAll') {
        $query = "UPDATE " . DB_PREFIX . "device SET event_type='".smartsql($data['event_type']). "';" ;
    }
    global $jakdb;
    $result = $jakdb->query($query);
    if($result)
    {
        return $result;
    }
    return false;
}

// Get the setting variable as well the default variable as array
function jak_get_device_setting_by_key($group, $key)
{
    global $jakdb;
    $setting = array();
    $result = $jakdb->query('SELECT varname, value, defaultvalue FROM '.DB_PREFIX.'setting WHERE groupname = "'.smartsql($group).'"');
    while ($row = $result->fetch_assoc()) {

        foreach ($row as $k=> $value)
        {
            if ($value == $key)
            {
                return $row['value'] ;
            }
        }
        $setting[] = $row;
    }
    return $setting;
}

// get local device files
function jak_get_device_files($directory, $exempt = array('.','..','.ds_store','.svn','preview.jpg','index.html','js','css','img','_cache'),&$files = array())
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
                        'name' => $resource,
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
function jak_get_catch_dirs($directory, $exempt = array('.','..','.ds_store','.svn', 'single_files','css','img','_cache'))
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

function jak_delete_file_dir($path)
{
    chmod($path, 0777);
    if (is_dir($path))
    {
        array_map('unlink', glob("$path/*.*"));
        rmdir($path);
    }
    else {
        @unlink($path);
    }
}

// Menu builder function, parentId 0 is the root
function jak_build_menu_download($parent, $menu, $lang, $class = "", $id = "")
{
   $html = "";
   if (isset($menu['parents'][$parent])) {
      $html .= "
      <ul".$class.$id.">\n";
       foreach ($menu['parents'][$parent] as $itemId) {
          if (!isset($menu['parents'][$itemId])) {
          	$html .= '<li id="menuItem_'.$menu["items"][$itemId]["id"].'" class="jakcat">
          		<div>
          		<span class="text">#'.$menu["items"][$itemId]["id"].' <a href="index.php?p=download&amp;sp=categories&amp;ssp=edit&amp;sssp='.$menu["items"][$itemId]["id"].'">'.$menu["items"][$itemId]["name"].'</a></span>
          		<span class="actions">
          			<a href="index.php?p=download&amp;sp=categories&amp;ssp=lock&amp;sssp='.$menu["items"][$itemId]["id"].'" class="btn btn-default btn-xs"><i class="fa fa-'.($menu["items"][$itemId]["active"] == 0 ? 'lock' : 'check').'"></i></a>
          			<a href="index.php?p=download&amp;sp=new&amp;ssp='.$menu["items"][$itemId]["id"].'" class="btn btn-default btn-xs"><i class="fa fa-sticky-note-o"></i></a>
          			<a href="index.php?p=download&amp;sp=categories&amp;ssp=edit&amp;sssp='.$menu["items"][$itemId]["id"].'" class="btn btn-default btn-xs"><i class="fa fa-edit"></i></a>
          			<a href="index.php?p=download&amp;sp=categories&amp;ssp=delete&amp;sssp='.$menu["items"][$itemId]["id"].'" class="btn btn-danger btn-xs" onclick="if(!confirm('.$lang.'))return false;"><i class="fa fa-trash-o"></i></a>
          		</span></div></li>';
          }
          if (isset($menu['parents'][$itemId])) {
          	$html .= '<li id="menuItem_'.$menu["items"][$itemId]["id"].'" class="jakcat">
          		<div>
          		<span class="text">#'.$menu["items"][$itemId]["id"].' <a href="index.php?p=download&amp;sp=categories&amp;ssp=edit&amp;sssp='.$menu["items"][$itemId]["id"].'">'.$menu["items"][$itemId]["name"].'</a></span>
          		<span class="actions">
          			<a href="index.php?p=download&amp;sp=categories&amp;ssp=lock&amp;sssp='.$menu["items"][$itemId]["id"].'" class="btn btn-default btn-xs"><i class="fa fa-'.($menu["items"][$itemId]["active"] == 0 ? 'lock' : 'check').'"></i></a>
          				<a href="index.php?p=download&amp;sp=new&amp;ssp='.$menu["items"][$itemId]["id"].'" class="btn btn-default btn-xs"><i class="fa fa-sticky-note-o"></i></a>
          				<a href="index.php?p=download&amp;sp=categories&amp;ssp=edit&amp;sssp='.$menu["items"][$itemId]["id"].'" class="btn btn-default btn-xs"><i class="fa fa-edit"></i></a>
          				<a href="index.php?p=download&amp;sp=categories&amp;ssp=delete&amp;sssp='.$menu["items"][$itemId]["id"].'" class="btn btn-danger btn-xs" onclick="if(!confirm('.$lang.'))return false;"><i class="fa fa-trash-o"></i></a>
          		</span>
          		</div>';
             $html .= jak_build_menu_download($itemId, $menu, $lang);
             $html .= "</li> \n";
          }
       }
       $html .= "</ul> \n";
   }
   return $html;
}

// create mysql sensor query file to use in prtg
function jak_generate_query_file($path, $data)
{
	chmod($path, 0775);
    $filename = 'single_device_' . $data['jak_base_name'] . '_' . $data['jak_device_id'] . '.sql';
    if (!file_exists($path . $filename))
    {
	    $handle = fopen($path . $filename, 'a') or die('Cannot open file:  ' . $path . $filename);
	    $data = 'SELECT device_id,
	            CASE
	                WHEN event_type = "Normal" THEN 0
	                WHEN event_type = "Alarm" THEN 1
	                ELSE 0
	            END as event_type
	        FROM
	            device
	        WHERE
	            device_id = "' . $data['jak_device_id'] . '"
	            AND base_name = "'. $data['jak_base_name'] . '";';
	    @fwrite($handle, $data);
	    fclose($handle);
	}
    return $path.$filename;
}


function ftpFilework($settings, $file = null, $data, $action)
{
    include_once('SFTP.php');
    // set SFTP object, use host, username and password
    $ftp = new SFTP($settings["deviceprtgftphost"], $settings["deviceprtgftpuser"], $settings["deviceprtgftppassword"]);
    if($ftp->connect())
    {
        if ($action == 'put' && !empty($file))
        {
            $filename = 'single_device_' . $data['jak_base_name'] . '_' . $data['jak_device_id'] . '.sql';
            if($ftp->put($file, $filename))
            {
                print "Filed uploaded";
            }
        }

        if ($action == 'del')
        {
            $filename = 'single_device_' . $data['base_name'] . '_' . $data['device_id'] . '.sql';
            // delete file "remote.php"
            $ftp->delete($filename);
        }

    }
}


?>