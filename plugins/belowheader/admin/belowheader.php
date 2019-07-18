<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Check if the file is accessed only via index.php if not stop the script from running
if(!defined('JAK_ADMIN_PREVENT_ACCESS')) die('You cannot access this file directly.');

// Check if the user has access to this file
if (!JAK_USERID || !$jakuser->jakModuleaccess(JAK_USERID, JAK_ACCESSBELOWHEADER)) jak_redirect(BASE_URL);

// All the tables we need for this plugin
$jaktable = DB_PREFIX.'belowheader';
$jaktable1 = DB_PREFIX.'pages';
$jaktable2 = DB_PREFIX.'news';

// Get all the functions, well not many
function jak_get_belowheader() {
	
	global $jakdb;
	$jakdata = array();
    $result = $jakdb->query('SELECT * FROM '.DB_PREFIX.'belowheader ORDER BY id DESC');
    while ($row = $result->fetch_assoc()) {
            // collect each record into $_data
            $jakdata[] = $row;
        }
        
    return $jakdata;
}

// Now start with the plugin use a switch to access all pages
switch ($page1) {

	// Create new belowheader
	case 'newbh':
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $defaults = $_POST;
		    
		    if (empty($defaults['jak_title'])) {
		        $errors['e1'] = $tl['error']['e2'];
		    }
		
		    if (count($errors) == 0) {
		    
		    if (!isset($defaults['jak_permission'])) {
		    	$permission = 0;
		    } else {
		    	$permission = join(',', $defaults['jak_permission']);
		    }
		    
		    if (!isset($defaults['jak_pageid'])) {
		    	$pageid = 0;
		    } else {
		    	$pageid = join(',', $defaults['jak_pageid']);
		    }
		    
		    if (!isset($defaults['jak_newsid'])) {
		    	$newsid = 0;
		    } else {
		    	$newsid = join(',', $defaults['jak_newsid']);
		    }
		    
		    // Do the dirty work in mysql
		    $result = $jakdb->query('INSERT INTO '.$jaktable.' SET 
		    pageid = "'.smartsql($pageid).'",
		    newsid = "'.smartsql($newsid).'",
		    newsmain = "'.smartsql($defaults['jak_mainnews']).'",
		    tags = "'.smartsql($defaults['jak_tags']).'",
		    search = "'.smartsql($defaults['jak_search']).'",
		    sitemap = "'.smartsql($defaults['jak_sitemap']).'",
		    title = "'.smartsql($defaults['jak_title']).'",
		    content = "'.smartsql($defaults['jak_content']).'",
		    content_below = "'.smartsql($defaults['jak_contentb']).'",
		    permission = "'.smartsql($permission).'",
		    time = NOW()');
		    
		    $rowid = $jakdb->jak_last_id();
		    				
			if (!$result) {
				jak_redirect(BASE_URL.'index.php?p=belowheader&sp=newbh&ssp=e');
			} else {
				jak_redirect(BASE_URL.'index.php?p=belowheader&sp=edit&ssp='.$rowid.'&sssp=s');
		    }
		    } else {
		    
		   	$errors['e'] = $tl['error']['e'];
		    $errors = $errors;
		    }
		}
		
		// Get all usergroup's
		$JAK_USERGROUP = jak_get_usergroup_all('usergroup');
		
		// Pages and News
		$JAK_PAGES = jak_get_page_info($jaktable1, '');
		$JAK_NEWS = jak_get_page_info($jaktable2, '');
		
		// Title and Description
		$SECTION_TITLE = $tlbh["bh"]["m1"];
		$SECTION_DESC = $tlbh["bh"]["t"];
		
		// Call the template
		$plugin_template = 'plugins/belowheader/admin/template/newbh.php';
		
	break;
	default:
		
		 switch ($page1) {
		    case 'delete':
		        if (is_numeric($page2) && jak_row_exist($page2, $jaktable)) {
							        	
		        	// Delete the Content
		        	$result = $jakdb->query('DELETE FROM '.$jaktable.' WHERE id = "'.smartsql($page2).'"');
		
		if (!$result) {
		    	jak_redirect(BASE_URL.'index.php?p=belowheader&sp=e');
			} else {
		        jak_redirect(BASE_URL.'index.php?p=belowheader&sp=s');
		    }
		    
		} else {
		   	jak_redirect(BASE_URL.'index.php?p=belowheader&sp=ene');
		}
		break;
		case 'lock':
			
			$result = $jakdb->query('UPDATE '.$jaktable.' SET active = IF (active = 1, 0, 1) WHERE id = '.smartsql($page2));
		    	
			if (!$result) {
				jak_redirect(BASE_URL.'index.php?p=belowheader&sp=e');
			} else {
		    	jak_redirect(BASE_URL.'index.php?p=belowheader&sp=s');
			}
			
		break;
		case 'edit':
		
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			    $defaults = $_POST;
			    
			    if (empty($defaults['jak_title'])) {
			        $errors['e1'] = $tl['error']['e2'];
			    }
			
			    if (count($errors) == 0) {
			    
			    if (!isset($defaults['jak_permission'])) {
			    	$permission = 0;
			    } else {
			    	$permission = join(',', $defaults['jak_permission']);
			    }
			    
			    if (!isset($defaults['jak_pageid'])) {
			    	$pageid = 0;
			    } else {
			    	$pageid = join(',', $defaults['jak_pageid']);
			    }
			    
			    if (!isset($defaults['jak_newsid'])) {
			    	$newsid = 0;
			    } else {
			    	$newsid = join(',', $defaults['jak_newsid']);
			    }
			    
			    // Do the dirty work in mysql
			    $result = $jakdb->query('UPDATE '.$jaktable.' SET 
			    pageid = "'.smartsql($pageid).'",
			    newsid = "'.smartsql($newsid).'",
			    newsmain = "'.smartsql($defaults['jak_mainnews']).'",
			    tags = "'.smartsql($defaults['jak_tags']).'",
			    search = "'.smartsql($defaults['jak_search']).'",
			    sitemap = "'.smartsql($defaults['jak_sitemap']).'",
			    title = "'.smartsql($defaults['jak_title']).'",
			    content = "'.smartsql($defaults['jak_content']).'",
			    content_below = "'.smartsql($defaults['jak_contentb']).'",
			    permission = "'.smartsql($permission).'",
			    time = NOW() WHERE id = "'.smartsql($page2).'"');
			    				
				if (!$result) {
					jak_redirect(BASE_URL.'index.php?p=belowheader&sp=edit&ssp='.$page2.'&sssp=e');
				} else {
			        jak_redirect(BASE_URL.'index.php?p=belowheader&sp=edit&ssp='.$page2.'&sssp=s');
			    }
			    } else {
			    	$errors['e'] = $tl['error']['e'];
			    	$errors = $errors;
			    }
			}
			
			// Get all usergroup's
			$JAK_USERGROUP = jak_get_usergroup_all('usergroup');
			
			// Pages and News
			$JAK_PAGES = jak_get_page_info($jaktable1, '');
			$JAK_NEWS = jak_get_page_info($jaktable2, '');
			
			// Get the data
			$JAK_FORM_DATA = jak_get_data($page2, $jaktable);
			
			// Title and Description
			$SECTION_TITLE = $tlbh["bh"]["m2"];
			$SECTION_DESC = $tlbh["bh"]["t1"];
			
			// Call the template
			$plugin_template = 'plugins/belowheader/admin/template/editbh.php';
		
		break;
		default:
		
			// Hello we have a post request
			if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['jak_delete_belowheader'])) {
			    $defaults = $_POST;
			    
			    if (isset($defaults['delete'])) {
			    
			    $lockuser = $defaults['jak_delete_belowheader'];
			
			        for ($i = 0; $i < count($lockuser); $i++) {
			            $locked = $lockuser[$i];
						
						$result = $jakdb->query('DELETE FROM '.$jaktable.' WHERE id = "'.smartsql($locked).'"');
			        }
			  
			 	if (!$result) {
					jak_redirect(BASE_URL.'index.php?p=belowheader&sp=e');
				} else {
			        jak_redirect(BASE_URL.'index.php?p=belowheader&sp=s');
			    }
			    
			    }
			    
			    if (isset($defaults['lock'])) {
			        
			        $lockuser = $defaults['jak_delete_belowheader'];
			    
			            for ($i = 0; $i < count($lockuser); $i++) {
			                $locked = $lockuser[$i];
			                
			                // Delete the pics associated with the Nivo Slider
			                $result = $jakdb->query('UPDATE '.$jaktable.' SET active = IF (active = 1, 0, 1) WHERE id = "'.smartsql($locked).'"');
			            }
			      
			     	if (!$result) {
			    		jak_redirect(BASE_URL.'index.php?p=belowheader&sp=e');
			    	} else {
			            jak_redirect(BASE_URL.'index.php?p=belowheader&sp=s');
			        }
			        
			        }
			
			 }
							
			$JAK_BELOWHEADER_ALL = jak_get_belowheader();
			
			// Title and Description
			$SECTION_TITLE = $tlbh["bh"]["m"];
			$SECTION_DESC = $tlbh["bh"]["t"];
			
			// Call the template
			$plugin_template = 'plugins/belowheader/admin/template/bh.php';
		}
}
?>