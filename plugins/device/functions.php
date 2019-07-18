<?php

/*===============================================*\
|| ############################################## ||
|| # claricom.ca                                 #||
|| # ------------------------------------------- #||
|| # Copyright 2016 CLARICOM All Rights Reserved #||
|| ############################################## ||
\*===============================================*/

// Get News out the database
function jak_get_device($jakvar, $where, $plname, $order, $datef, $timef, $timeago) {
	if (!empty($jakvar)) {
		$sqlin = ' ORDER BY time '.$order.' ';
	} else if (empty($jakvar) && is_numeric($where)) {
		$sqlin = 'id = '.$where.' ORDER BY time ASC';
	} else if (empty($jakvar) && !is_numeric($where)) {
		$sqlin = 'id IN('.$where.') ORDER BY time ASC';
	} else {
		$sqlin = ' ORDER BY event_type ASC LIMIT 1';
	}

	global $jakdb;
	global $jkv;
	$jakdata = [];
    $result = $jakdb->query('SELECT * FROM '.DB_PREFIX.'device');
    while ($row = $result->fetch_assoc()) {
		$jakdata[] = $row;
    }

    if (!empty($jakdata)) return $jakdata;
}

// Get total from a table
function jak_get_device_total($jakvar)
{
	global $jakdb;
	$row = $jakdb->queryRow('SELECT COUNT(*) as totalAll FROM ' . $jakvar);
	return $row['totalAll'];
}

function jak_next_device_page($page, $title, $table, $id, $jakvar4, $jakvar5, $approve) {

	$second = $third = $fourth = $jakdata = false;

	if (!empty($title)) {
		$second = ' ,'.$title;
	}
	if (!empty($jakvar4)) {
		$third = ' AND '.$jakvar4.' = "'.smartsql($jakvar5).'"';
	}
	if (!empty($approve)) {
		$fourth = ' AND '.$approve.' = 1';
	}
	global $jakdb;
	$result = $jakdb->query('SELECT id'.$second.' FROM '.$table.' WHERE '.$id.' > '.smartsql($page).$third.$fourth.' ORDER BY id ASC LIMIT 1');
	if ($jakdb->affected_rows > 0) {
		$jakdata = $result->fetch_assoc();
	    return $jakdata;
	} else
	    return false;
}

function jak_previous_device_page($page, $title, $table, $id, $jakvar4, $jakvar5, $approve) {

	$second = $third = $fourth = $jakdata = false;

	if (!empty($title)) {
		$second = ' ,'.$title;
	}
	if (!empty($jakvar4)) {
		$third = ' AND '.$jakvar4.' = "'.smartsql($jakvar5).'"';
	}
	if (!empty($approve)) {
		$fourth = ' AND '.$approve.' = 1';
	}
	global $jakdb;
	$result = $jakdb->query('SELECT id'.$second.' FROM '.$table.' WHERE '.$id.' < '.smartsql($page).$third.$fourth.' ORDER BY id DESC LIMIT 1');
	if ($jakdb->affected_rows > 0) {
	    $jakdata = $result->fetch_assoc();
	    return $jakdata;
	} else
	    return false;

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
                'date' => date("F d Y H:i:s.", filemtime($directory . $v)),
                'path' => $directory.$v,
                'type' => filetype($directory . $v)
            ];
        }
    }
    return $dirs;
}

function jak_devices_password_protected($postData, $password)
{
    $passcrypt = hash_hmac('sha256', $postData['pagepass'], DB_PASS_HASH);
    if ($passcrypt == $password)
    {
        $_SESSION['pagesecurehash'.$postData['action']] = $passcrypt;
        return TRUE;
    }
    else
    {
         return FALSE;
    }
}

?>