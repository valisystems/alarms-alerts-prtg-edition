<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Check if the file is accessed only via index.php if not stop the script from running
if (!defined('JAK_ADMIN_PREVENT_ACCESS')) die('You cannot access this file directly.');

// Check if the user has access to this file
if (!JAK_USERID || !JAK_SUPERADMINACCESS) jak_redirect(BASE_URL);

$templateurl = jak_get_setting('setting');
$jaktable = DB_PREFIX.'setting';

$result = $jakdb->query('SELECT value FROM '.$jaktable.' WHERE groupname = "setting" && varname = "sitestyle" LIMIT 1');
$row = $result->fetch_assoc();

$JAK_FILE_SUCCESS = $JAK_FILE_ERROR = $JAK_FILEURL = $JAK_FILECONTENT = "";
$defaults = $_POST;

function jak_get_template_files($directory,$exempt = array('.','..','.ds_store','.svn','preview.jpg','index.html','js','css','img','_cache'),&$files = array()) { 
        $handle = opendir($directory); 
        while(false !== ($resource = readdir($handle))) { 
            if(!in_array(strtolower($resource),$exempt)) { 
                if(is_dir($directory.$resource.'/')) {
                    array_merge($files, getFiles($directory.$resource.'/',$exempt,$files)); 
                } else {
                	if (is_writable($directory.'/'.$resource)) {
                    	$files[] = array('path' => $directory.'/'.$resource,'name' => $resource);
                    }
                }
            } 
        } 
        closedir($handle); 
        return $files; 
    }

switch ($page1) {
	case 'cssedit':
		
		$cssdir = '../template/'.$row['value'].'/css';
		
		if (!is_writable($cssdir)) {
			$JAK_FILE_ERROR = 1;
		}
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($defaults['edit'])) {
		    
		    $openfile = fopen($defaults['jak_file_edit'], 'r');
		    $filecontent = @fread($openfile, filesize($defaults['jak_file_edit']));
		    $displaycontent = preg_replace('</textarea>', 'JAK-DO-NOT-EDIT-TEXTAREA', $filecontent);
		    $JAK_FILECONTENT = $displaycontent;
		    $JAK_FILEURL = $defaults['jak_file_edit'];
		    
		    fclose($openfile);
		    
		}
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($defaults['reset'])) {
		    
		    jak_redirect(BASE_URL.'index.php?p=template&sp=cssedit');
		    
		}
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($defaults['save'])) {
		    
		    if (is_writable($defaults['jak_file'])) {
		    $openfedit = fopen($defaults['jak_file'], "w+");
		    $datasave = $defaults['jak_filecontent'];
		    $datasave = preg_replace('<JAK-DO-NOT-EDIT-TEXTAREA>', '/textarea', $datasave);
		    $datasave = stripslashes($datasave);
		    if (fwrite($openfedit,$datasave)) {
		    	$JAK_FILE_SUCCESS = 1;
		    }
		    } else {
		    	$JAK_FILE_ERROR = 1;
		    }
		    
		    fclose($openfedit);
		    
		}
		
		$JAK_GET_TEMPLATE_FILES = jak_get_template_files($cssdir);
		
		// Title and Description
		$SECTION_TITLE = $tl["general"]["g53"];
		$SECTION_DESC = $tl["cmdesc"]["d44"];
		
		// Ace Mode
		$acemode = 'css';
		
		// Call the template
		$template = 'editfiles.php';
		
	break;
	case 'langedit':
		
		$langdir = '../lang';
		
		if (!is_writable($langdir)) {
			$JAK_FILE_ERROR = 1;
		}
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($defaults['edit'])) {
		    
		    $openfile = fopen($defaults['jak_file_edit'], 'r');
		    $filecontent = @fread($openfile, filesize($defaults['jak_file_edit']));
		    $displaycontent = preg_replace('</textarea>', 'JAK-DO-NOT-EDIT-TEXTAREA', $filecontent);
		    $JAK_FILECONTENT = $displaycontent;
		    $JAK_FILEURL = $defaults['jak_file_edit'];
		    
		    fclose($openfile);
		    
		}
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($defaults['reset'])) {
		    
		    jak_redirect(BASE_URL.'index.php?p=template&sp=langedit');
		    
		}
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($defaults['save'])) {
		    
		    if (is_writable($defaults['jak_file'])) {
		    $openfedit = fopen($defaults['jak_file'], "w+");
		    $datasave = $defaults['jak_filecontent'];
		    $datasave = preg_replace('<JAK-DO-NOT-EDIT-TEXTAREA>', '/textarea', $datasave);
		    $datasave = stripslashes($datasave);
		    if (fwrite($openfedit,$datasave)) {
		    	$JAK_FILE_SUCCESS = 1;
		    }
		    } else {
		    	$JAK_FILE_ERROR = 1;
		    }
		    
		    fclose($openfedit);
		    
		}
		
		$JAK_GET_TEMPLATE_FILES = jak_get_template_files($langdir);
		
		// Title and Description
		$SECTION_TITLE = $tl["cmenu"]["c54"];
		$SECTION_DESC = $tl["cmdesc"]["d44"];
		
		// Ace Mode
		$acemode = 'ini';
		
		// Call the template
		$template = 'editfiles.php';
		
	break;
	case 'edit-files':
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($defaults['edit'])) {
		    
		    $openfile = fopen($defaults['jak_file_edit'], 'r');
		    $filecontent = @fread($openfile, filesize($defaults['jak_file_edit']));
		    $displaycontent = preg_replace('</textarea>', 'JAK-DO-NOT-EDIT-TEXTAREA', $filecontent);
		    $JAK_FILECONTENT = $displaycontent;
		    $JAK_FILEURL = $defaults['jak_file_edit'];
		    
		    fclose($openfile);
		    
		}
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($defaults['reset'])) {
		    
		    jak_redirect(BASE_URL.'index.php?p=template&sp=edit-files');
		    
		}
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($defaults['save'])) {
		    
		    if (is_writable($defaults['jak_file'])) {
		    $openfedit = fopen($defaults['jak_file'], "w+");
		    $datasave = $defaults['jak_filecontent'];
		    $datasave = preg_replace('<JAK-DO-NOT-EDIT-TEXTAREA>', '/textarea', $datasave);
		    $datasave = stripslashes($datasave);
		    if (fwrite($openfedit,$datasave)) {
		    	$JAK_FILE_SUCCESS = 1;
		    }
		    } else {
		    	$JAK_FILE_ERROR = 1;
		    }
		    
		    fclose($openfedit);
		    
		}
		
		$filedir = '../template/'.$row['value'];
		
		if (!is_writable($filedir)) {
			$JAK_FILE_ERROR = 1;
		}
		
		// Get the importartant files into template
		$JAK_GET_TEMPLATE_FILES = jak_get_template_files($filedir);
		
		// Title and Description
		$SECTION_TITLE = $tl["general"]["g52"];
		$SECTION_DESC = $tl["cmdesc"]["d44"];
		
		// Ace Mode
		$acemode = 'php';
	
		// Call the template
		$template = 'editfiles.php';
		
	break;
	case 'active':
				
		 	$result = $jakdb->query('UPDATE '.$jaktable.' SET value = IF (value = 1, 0, 1) WHERE varname = "styleswitcher_tpl" && groupname = "'.smartsql($page2).'"');
		 	    	
		 	if (!$result) {
		 		jak_redirect(BASE_URL.'index.php?p=template&sp=e');
		 	} else {
		 	    jak_redirect(BASE_URL.'index.php?p=template&sp=s');
		 	}
	
	break;
	default:
	
		// Get the settings
		$JAK_SETTING = jak_get_setting('setting');
	
		// Let's go on with the script
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $defaults = $_POST;
		    
		    // Do the dirty work in mysql
		    $result = $jakdb->query('UPDATE '.DB_PREFIX.'setting SET value = CASE varname
		        WHEN "sitestyle" THEN "'.smartsql($defaults['save']).'"
		    END
				WHERE varname IN ("sitestyle")');
				
			if (!$result) {
				jak_redirect(BASE_URL.'index.php?p=template&sp=e');
			} else {		
		        jak_redirect(BASE_URL.'index.php?p=template&sp=s');
		    }
		}
		
		// Get all styles in the directory
		$site_style_files = jak_get_site_style('../template/');
		
		// Title and Description
		$SECTION_TITLE = $tl["menu"]["m23"];
		$SECTION_DESC = $tl["cmdesc"]["d44"];
		
		// Call the template
		$template = 'template.php';
}
?>