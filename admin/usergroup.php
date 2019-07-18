<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Check if the file is accessed only via index.php if not stop the script from running
if (!defined('JAK_ADMIN_PREVENT_ACCESS')) die('You cannot access this file directly.');

// Check if the user has access to this file
if (!JAK_USERID || !$JAK_MODULES) jak_redirect(BASE_URL);

// All the tables we need for this plugin
$jaktable = DB_PREFIX.'usergroup';
$jaktable1 = DB_PREFIX.'user';
$jakfield = 'username';

// Reset vars
$insert = "";

// Important template stuff
$JAK_USERGROUP_ALL = jak_get_usergroup_all('usergroup');

// Call the hooks per name for the template
$JAK_HOOK_ADMIN_USERGROUP_EDIT = $jakhooks->jakGethook("tpl_admin_usergroup_edit");
// for the new template
$JAK_HOOK_ADMIN_USERGROUP = $jakhooks->jakGethook("tpl_admin_usergroup");

// Now start with the plugin use a switch to access all pages
switch ($page1) {

	// Create new user group
	case 'newgroup':
	
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $defaults = $_POST;
		    
		    if (isset($defaults['create'])) {
		        
		        $JAK_FORM_DATA = jak_get_data($defaults['jak_groupbase'],$jaktable);
		        
		        // Get the data for the editor light
		        $_REQUEST["jak_lcontent"] = $JAK_FORM_DATA["description"];
		        
		    }
		    
		    if (isset($defaults['save'])) {
		
		    if (empty($defaults['jak_name'])) {
		        $errors['e1'] = $tl['error']['e7'];
		    }
		    
		    if (jak_field_not_exist($defaults['jak_name'], $jaktable, "name")) {
		        $errors['e2'] = str_replace("%s", $defaults['jak_name'], $tl['error']['e40']);
		    }
		        
		    if (count($errors) == 0) {
		    
		    // Tag Settings
		    if (isset($defaults['jak_tags'])) $insert .= 'tags = "'.smartsql($defaults['jak_tags']).'",';
		    
		    // Get the php hook for index top
		    $getinserthook = $jakhooks->jakGethook("php_admin_usergroup");
		    if ($getinserthook)
		    foreach($getinserthook as $it)
		    {
		    	eval($it['phpcode']);
		    } 
		
		
			$result = $jakdb->query('INSERT INTO '.$jaktable.' SET 
			name = "'.smartsql($defaults['jak_name']).'",
			description = "'.smartsql($defaults['jak_lcontent']).'",
			advsearch = "'.smartsql($defaults['jak_advs']).'",
			'.$insert.'
			canrate = "'.smartsql($defaults['jak_rate']).'"');
			
			$rowid = $jakdb->jak_last_id();
		
		if (!$result) {
		    	jak_redirect(BASE_URL.'index.php?p=usergroup&sp=newgroup&ssp=e');
			} else {
		        jak_redirect(BASE_URL.'index.php?p=usergroup&sp=edit&ssp='.$rowid.'&sssp=s');
		    }
		 } else {
		    
		   	$errors['e'] = $tl['error']['e'];
		    $errors = $errors;
		    }
		    
		  }
		}
		
		// Title and Description
		$SECTION_TITLE = $tl["cmenu"]["c11"];
		$SECTION_DESC = $tl["cmdesc"]["d15"];
		
		// Call the template
		$template = 'newusergroup.php';
		
	break;
	default:

		if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($page1)) {
		    $defaults = $_POST;
		        
		    if (isset($defaults['delete'])) {
		    
		    $lockuser = $defaults['jak_delete_usergroup'];
		    $grouparray = explode(',', '1,2,3,4');
		
		        for ($i = 0; $i < count($lockuser); $i++) {
		            $locked = $lockuser[$i];
		            
		            if (!in_array($locked, $grouparray)) {
		        	$result = $jakdb->query('DELETE FROM '.$jaktable.' WHERE id = "'.smartsql($locked).'"');
					}
		        }
		  
		 	if (!$result) {
				jak_redirect(BASE_URL.'index.php?p=usergroup&sp=e');
			} else {
		        jak_redirect(BASE_URL.'index.php?p=usergroup&sp=s');
		    }
		    
		    }
		
		    
		 }
		 
		 switch ($page1) {
		 	case 'user':
		 		 
		 		if (jak_row_exist($page2,$jaktable)) {
			 		$getTotal = jak_get_total($jaktable1,$page2,'usergroupid','');
			 		if ($getTotal != 0) {
				        // Paginator
				       	$pages = new JAK_Paginator;
						$pages->items_total = $getTotal;
				       	$pages->mid_range = $jkv["adminpagemid"];
				       	$pages->items_per_page = $jkv["adminpageitem"];
				       	$pages->jak_get_page = $page3;
				       	$pages->jak_where = 'index.php?p=usergroup&sp=user&ssp='.$page2;
				       	$pages->paginate();
				       	$JAK_PAGINATE = $pages->display_pages();
			       	}
			        $JAK_USER_ALL = jak_get_user_all('user',$pages->limit, $page2);
			        
			        // Title and Description
			        $SECTION_TITLE = $tl["menu"]["m3"];
			        $SECTION_DESC = str_replace("%s", $tl["menu"]["m3"], $tl["cmdesc"]['d3']);
			        
			        // Get the template, same from the user
			        $template = 'user.php';
		 	} else {
		 		jak_redirect(BASE_URL.'index.php?p=usergroup&sp=ene');
		    }
		 	break;
		    case 'delete':
		        if ($page2 > 4) {
		
					$result = $jakdb->query('DELETE FROM '.$jaktable.' WHERE id = "'.smartsql($page2).'"');
					
					if (!$result) {
					    jak_redirect(BASE_URL.'index.php?p=usergroup&sp=e');
					} else {
						jak_redirect(BASE_URL.'index.php?p=usergroup&sp=s');
					}
					    
				} else {
					jak_redirect(BASE_URL.'index.php?p=usergroup&sp=edn');
				}
		
	break;
	case 'edit':
	
		if (jak_row_exist($page2,$jaktable)) {
		
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $defaults = $_POST;
		
		    if (empty($defaults['jak_name'])) {
		        $errors['e1'] = $tl['error']['e7'];
		    }
		    		        
		    if (count($errors) == 0) {
		    
		    // Tag Settings
		    if (isset($defaults['jak_tags'])) $insert .= 'tags = "'.$defaults['jak_tags'].'",';
		    
		    // Get the php hook for index top
		    $getinserthook = $jakhooks->jakGethook("php_admin_usergroup");
		    if ($getinserthook)
		    foreach($getinserthook as $it)
		    {
		    	eval($it['phpcode']);
		    }
		
		
			$result = $jakdb->query('UPDATE '.$jaktable.' SET 
			name = "'.smartsql($defaults['jak_name']).'",
			description = "'.smartsql($defaults['jak_lcontent']).'",
			advsearch = "'.smartsql($defaults['jak_advs']).'",
			'.$insert.'
			canrate = "'.smartsql($defaults['jak_rate']).'"
			WHERE id = "'.smartsql($page2).'"');
		
			if (!$result) {
		    	jak_redirect(BASE_URL.'index.php?p=usergroup&sp=edit&ssp='.$page2.'&sssp=e');
			} else {
		        jak_redirect(BASE_URL.'index.php?p=usergroup&sp=edit&ssp='.$page2.'&sssp=s');
		    }
		 } else {
		    
		   	$errors['e'] = $tl['error']['e'];
		    $errors = $errors;
		    }
		}
		
		// Title and Description
		$SECTION_TITLE = $tl["cmenu"]["c12"];
		$SECTION_DESC = $tl["cmdesc"]["d14"];
		
		$JAK_FORM_DATA = jak_get_data($page2,$jaktable);
		$JAK_FORM_DATA["content"] = $JAK_FORM_DATA["description"];
		$template = 'editusergroup.php';
		
		} else {
		   	jak_redirect(BASE_URL.'index.php?p=usergroup&sp=ene');
		}
		
		break;
		default:
		
			// Title and Description
			$SECTION_TITLE = $tl["menu"]["m9"];
			$SECTION_DESC = $tl["cmdesc"]["d14"];
		
			// Call the template
			$template = 'usergroup.php';
			
		}
}
?>