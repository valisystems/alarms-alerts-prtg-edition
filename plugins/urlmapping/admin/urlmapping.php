<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Check if the file is accessed only via index.php if not stop the script from running
if(!defined('JAK_ADMIN_PREVENT_ACCESS')) die('You cannot access this file directly.');

// Check if the user has access to this file
if (!JAK_USERID || !$jakuser->jakModuleaccess(JAK_USERID, JAK_ACCESSURLMAPPING)) jak_redirect(BASE_URL);

// All the tables we need for this plugin
$jaktable = DB_PREFIX.'urlmapping';

// Now start with the plugin use a switch to access all pages
switch ($page1) {

	// Create new urlmapping
	case 'new':
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $defaults = $_POST;
		    
		    if (empty($defaults['jak_oldurl'])) {
		        $errors['e1'] = $tlum['um']['e'];
		    }
		    
		    if (empty($defaults['jak_newurl'])) {
		        $errors['e2'] = $tlum['um']['e'];
		    }
		
		    if (count($errors) == 0) {
		    
		    // Do the dirty work in mysql
		    $result = $jakdb->query('INSERT INTO '.$jaktable.' SET 
		    urlold = "'.smartsql($defaults['jak_oldurl']).'",
		    urlnew = "'.smartsql($defaults['jak_newurl']).'",
		    redirect = "'.smartsql($defaults['jak_redirect']).'",
		    time = NOW()');
		    
		    $rowid = $jakdb->jak_last_id();
		    				
			if (!$result) {
				jak_redirect(BASE_URL.'index.php?p=urlmapping&sp=newbh&ssp=e');
			} else {
				jak_redirect(BASE_URL.'index.php?p=urlmapping&sp=edit&ssp='.$rowid.'&sssp=s');
		    }
		    } else {
		    
		   	$errors['e'] = $tl['error']['e'];
		    $errors = $errors;
		    }
		}
		
		// Title and Description
		$SECTION_TITLE = $tlum["um"]["m1"];
		$SECTION_DESC = $tlum["um"]["t"];
		
		// Call the template
		$plugin_template = 'plugins/urlmapping/admin/template/new.php';
		
	break;
	default:
		
		 switch ($page1) {
		 	case 'delete':
		        if (is_numeric($page2) && jak_row_exist($page2, $jaktable)) {
							        	
		        	// Delete the Content
		        	$result = $jakdb->query('DELETE FROM '.$jaktable.' WHERE id = "'.smartsql($page2).'"');
		
					if (!$result) {
				    	jak_redirect(BASE_URL.'index.php?p=urlmapping&sp=e');
					} else {
				        jak_redirect(BASE_URL.'index.php?p=urlmapping&sp=s');
				    }
				    
				} else {
				   	jak_redirect(BASE_URL.'index.php?p=urlmapping&sp=ene');
				}
		break;
		case 'lock':
			
			$result = $jakdb->query('UPDATE '.$jaktable.' SET active = IF (active = 1, 0, 1) WHERE id = '.smartsql($page2));
		    	
			if (!$result) {
				jak_redirect(BASE_URL.'index.php?p=urlmapping&sp=e');
			} else {
		    	jak_redirect(BASE_URL.'index.php?p=urlmapping&sp=s');
			}
			
		break;
		case 'edit':
		
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			    $defaults = $_POST;
			    
				if (empty($defaults['jak_oldurl'])) {
			        $errors['e1'] = $tlum['um']['e'];
			    }
			    
			    if (empty($defaults['jak_newurl'])) {
			        $errors['e2'] = $tlum['um']['e'];
			    }
			
			    if (count($errors) == 0) {
			    
				    // Do the dirty work in mysql
				    $result = $jakdb->query('UPDATE '.$jaktable.' SET 
				    urlold = "'.smartsql($defaults['jak_oldurl']).'",
				    urlnew = "'.smartsql($defaults['jak_newurl']).'",
				    redirect = "'.smartsql($defaults['jak_redirect']).'",
				    time = NOW()
				    WHERE id = "'.smartsql($page2).'"');
				    				
					if (!$result) {
						jak_redirect(BASE_URL.'index.php?p=urlmapping&sp=edit&ssp='.$page2.'&sssp=e');
					} else {
				        jak_redirect(BASE_URL.'index.php?p=urlmapping&sp=edit&ssp='.$page2.'&sssp=s');
				    }
				    
			    } else {
			    	$errors['e'] = $tl['error']['e'];
			    	$errors = $errors;
			    }
			}
			
			// Get the data
			$JAK_FORM_DATA = jak_get_data($page2, $jaktable);
			
			// Title and Description
			$SECTION_TITLE = $tlum["um"]["m2"];
			$SECTION_DESC = $tlum["um"]["t1"];
			
			// Call the template
			$plugin_template = 'plugins/urlmapping/admin/template/edit.php';
		
		break;
		default:
		
			// Hello we have a post request
			if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['jak_delete_urlmapping'])) {
			    $defaults = $_POST;
			    
			    if (isset($defaults['delete'])) {
			    
			    $lockuser = $defaults['jak_delete_urlmapping'];
			
			        for ($i = 0; $i < count($lockuser); $i++) {
			            $locked = $lockuser[$i];
						$result = $jakdb->query('DELETE FROM '.$jaktable.' WHERE id = "'.smartsql($locked).'"');
			        }
			  
			 	if (!$result) {
					jak_redirect(BASE_URL.'index.php?p=urlmapping&sp=e');
				} else {
			        jak_redirect(BASE_URL.'index.php?p=urlmapping&sp=s');
			    }
			    
			    }
			    
			    if (isset($defaults['lock'])) {
			        
			        $lockuser = $defaults['jak_delete_urlmapping'];
			    
			            for ($i = 0; $i < count($lockuser); $i++) {
			                $locked = $lockuser[$i];
			                
			                // Delete the pics associated with the Nivo Slider
			                $result = $jakdb->query('UPDATE '.$jaktable.' SET active = IF (active = 1, 0, 1) WHERE id = "'.smartsql($locked).'"');
			            }
			      
			     	if (!$result) {
			    		jak_redirect(BASE_URL.'index.php?p=urlmapping&sp=e');
			    	} else {
			            jak_redirect(BASE_URL.'index.php?p=urlmapping&sp=s');
			        }
			        
			        }
			
			 }
			 
			 // Get all
			 $result = $jakdb->query('SELECT * FROM '.DB_PREFIX.'urlmapping ORDER BY id DESC');
			 while ($row = $result->fetch_assoc()) {
			         // collect each record into $_data
			         $JAK_UM_ALL[] = $row;
			     }
			
			// Title and Description
			$SECTION_TITLE = $tlum["um"]["m"];
			$SECTION_DESC = $tlum["um"]["t"];
			
			// Call the template
			$plugin_template = 'plugins/urlmapping/admin/template/mapping.php';
		}
}
?>