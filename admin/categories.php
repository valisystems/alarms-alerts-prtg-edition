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
if (!JAK_USERID || !$JAK_MODULEM) jak_redirect(BASE_URL);

// All the tables we need for this plugin
$jaktable = DB_PREFIX.'categories';

// Now start with the plugin use a switch to access all pages
switch ($page1) {

	case 'newcat':
		
		// Additional DB Information
		$jakfield = 'varname';
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $defaults = $_POST;
		
		    if (empty($defaults['jak_name'])) {
		        $errors['e1'] = $tl['error']['e12'];
		    }
		    
		    if (jak_field_not_exist($defaults['jak_varname'],$jaktable,$jakfield) || jak_varname_blocked($defaults['jak_varname'])) {
		        $errors['e2'] = $tl['error']['e13'];
		    }
		    
		    if (empty($defaults['jak_varname']) || !preg_match('/^([a-z-_0-9]||[-_])+$/', $defaults['jak_varname'])) {
		        $errors['e3'] = $tl['error']['e14'];
		    }
		        
		    if (count($errors) == 0) {
		    
		    if (!isset($defaults['jak_menu'])) {
		    	$menu = 0;
		    } else {
		    	$menu = $defaults['jak_menu'];
		    }
		    if (!isset($defaults['jak_footer'])) {
		    	$footer = 0;
		    } else {
		    	$footer = $defaults['jak_footer'];
		    }
		    
		    if (!isset($defaults['jak_permission'])) {
		    	$permission = 0;
		    } else {
		    	$permission = join(',', $defaults['jak_permission']);
		    }
		    
		    $catimg = '';
		    if (!empty($defaults['jak_img'])) {
		    	$catimg = 'catimg = "'.smartsql($defaults['jak_img']).'",';
		    }
		
			$result = $jakdb->query('INSERT INTO '.$jaktable.' SET 
			name = "'.smartsql($defaults['jak_name']).'",
			varname = "'.smartsql($defaults['jak_varname']).'",
			exturl = "'.smartsql($defaults['jak_url']).'",
			content = "'.smartsql($defaults['jak_lcontent']).'",
			showmenu = "'.smartsql($menu).'",
			showfooter = "'.smartsql($footer).'",
			'.$catimg.'
			permission = "'.smartsql($permission).'",
			catorder = 2');
			
			$rowid = $jakdb->jak_last_id();
		
			if (!$result) {
		    	jak_redirect(BASE_URL.'index.php?p=categories&sp=newcat&ssp=e');;
			} else {
		        jak_redirect(BASE_URL.'index.php?p=categories&sp=edit&ssp='.$rowid.'&sssp=s');
		    }
		 } else {
		    
		   	$errors['e'] = $tl['error']['e'];
		    $errors = $errors;
		    }
		}
		
		// Get all usergroup's
		$JAK_USERGROUP = jak_get_usergroup_all('usergroup');
		
		// Title and Description
		$SECTION_TITLE = $tl["cmenu"]["c4"];
		$SECTION_DESC = $tl["cmdesc"]["d8"];
		
		// Call the template
		$template = 'newcat.php';
		
	break;
	default:
	
		// Additional DB Information
		$jakfield = 'catparent';
		$jakfield1 = 'varname';
		$jakfield2 = 'catparent2';
 
 	switch ($page1) {
 	case 'delete':

		if (jak_row_exist($page2,$jaktable) && $page2 != 1) {
		
			$result = $jakdb->query('SELECT catparent, pluginid FROM '.$jaktable.' WHERE id = "'.smartsql($page2).'" LIMIT 1');
			$row = $result->fetch_assoc();
			
			if ($row['pluginid'] == 0) {
			
			// Finally delete the category
			$result = $jakdb->query('DELETE FROM '.$jaktable.' WHERE id = "'.smartsql($page2).'"');
		
			if (!$result) {
		    	jak_redirect(BASE_URL.'index.php?p=categories&sp=e');
			} else {
		        jak_redirect(BASE_URL.'index.php?p=categories&sp=s');
		    }
		    
		} else {
			jak_redirect(BASE_URL.'index.php?p=categories&sp=epc');
		}
		
		} elseif ($page1 == 'delete' && $page2 == 1) {
			jak_redirect(BASE_URL.'index.php?p=categories&sp=ech');
		} else {
			jak_redirect(BASE_URL.'index.php?p=error&sp=ene');
		}
		
	break;
	case 'edit':
			
			if (jak_row_exist($page2,$jaktable)) {
	
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			    $defaults = $_POST;
			
			    if (empty($defaults['jak_name'])) {
			        $errors['e1'] = $tl['error']['e12'];
			    }
			    
			    if (empty($defaults['jak_varname']) || !preg_match('/^([a-z-_0-9]||[-_])+$/', $defaults['jak_varname'])) {
			        $errors['e3'] = $tl['error']['e14'];
			    }
			    
			    if (jak_field_not_exist_id($defaults['jak_varname'],$page2,$jaktable,$jakfield1) || jak_varname_blocked($defaults['jak_varname'])) {
			        $errors['e2'] = $tl['error']['e13'];
			    }
			        
			    if (count($errors) == 0) {
			    
			    if (!isset($defaults['jak_permission'])) {
			    	$permission = 0;
			    } else {
			    	$permission = join(',', $defaults['jak_permission']);
			    }   
			    
			    if (!empty($defaults['jak_img'])) {
			    	$insert .= 'catimg = "'.smartsql($defaults['jak_img']).'",';
			    } else {
			    	$insert .= 'catimg = NULL,';
			    }
			
				$result = $jakdb->query('UPDATE '.$jaktable.' SET 
				name = "'.smartsql($defaults['jak_name']).'",
				varname = "'.smartsql($defaults['jak_varname']).'",
				exturl = "'.smartsql($defaults['jak_url']).'",
				content = "'.smartsql($defaults['jak_lcontent']).'",
				showmenu = "'.smartsql($defaults['jak_menu']).'",
				showfooter = "'.smartsql($defaults['jak_footer']).'",
				'.$insert.'
				permission = "'.smartsql($permission).'"
				WHERE id = "'.smartsql($page2).'"');
			
				if (!$result) {
			    	jak_redirect(BASE_URL.'index.php?p=categories&sp=edit&ssp='.$page2.'&sssp=e');
				} else {
			        jak_redirect(BASE_URL.'index.php?p=categories&sp=edit&ssp='.$page2.'&sssp=s');
			    }
			 } else {
			   	$errors['e'] = $tl['error']['e'];
			    $errors = $errors;
			 }
	}
	
	// Get the data
	$JAK_FORM_DATA = jak_get_data($page2,$jaktable);
	
	// Get all usergroup's
	$JAK_USERGROUP = jak_get_usergroup_all('usergroup');
	
	// Title and Description
	$SECTION_TITLE = $tl["cmenu"]["c6"];
	$SECTION_DESC = $tl["cmdesc"]["d6"];
	
	$template = 'editcat.php';
	
	} else {
	   	jak_redirect(BASE_URL.'index.php?p=error&sp=cat-not-exist');
	}
	
	break;
	default:
	
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		
			$count = 1;
			
			if (isset($_POST['menuItem'])) foreach ($_POST['menuItem'] as $k => $v) {
			
				if (!is_numeric($v)) $v = 0;
				
				$result = $jakdb->query('UPDATE '.DB_PREFIX.'categories SET catparent = "'.smartsql($v).'", catorder = "'.smartsql($count).'" WHERE id = "'.smartsql($k).'"');
				
				$count++;
				
			}
			
			if ($result) {
				/* Outputtng the success messages */
				if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
					header('Cache-Control: no-cache');
					die(json_encode(array("status" => 1, "html" => $tl["general"]["g7"])));
				} else {
					// redirect back to home
					$_SESSION["successmsg"] = $tl["general"]["g7"];
					jak_redirect(BASE_URL.'index.php?p=categories');
				}
			} else {
				/* Outputtng the success messages */
				if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
					header('Cache-Control: no-cache');
					die(json_encode(array("status" => 0, "html" => $tl["errorpage"]["sql"])));
				} else {
					// redirect back to home
					$_SESSION["errormsg"] = $tl["errorpage"]["sql"];
					jak_redirect(BASE_URL.'index.php?p=categories');
				}
			}
			
		}
	
		// Title and Description
		$SECTION_TITLE = $tl["menu"]["m5"];
		$SECTION_DESC = $tl["cmdesc"]["d5"];
		
		// get the menu
		$result = $jakdb->query('SELECT * FROM '.$jaktable.' WHERE showmenu = 1 OR (showmenu = 1 && showfooter = 1) ORDER BY catparent, catorder, name');
		// Create a multidimensional array to conatin a list of items and parents
		$mheader = array(
		    'items' => array(),
		    'parents' => array()
		);
		// Builds the array lists with data from the menu table
		while ($items = $result->fetch_assoc())
		{
		    // Creates entry into items array with current menu item id ie. $menu['items'][1]
		    $mheader['items'][$items['id']] = $items;
		    // Creates entry into parents array. Parents array contains a list of all items with children
		    $mheader['parents'][$items['catparent']][] = $items['id'];
		}
		
		// get the menu
		$result = $jakdb->query('SELECT * FROM '.$jaktable.' WHERE showfooter = 1 ORDER BY catparent, catorder, name');
		// Create a multidimensional array to conatin a list of items and parents
		$mfooter = array(
		    'items' => array(),
		    'parents' => array()
		);
		// Builds the array lists with data from the menu table
		while ($items = $result->fetch_assoc())
		{
		    // Creates entry into items array with current menu item id ie. $menu['items'][1]
		    $mfooter['items'][$items['id']] = $items;
		    // Creates entry into parents array. Parents array contains a list of all items with children
		    $mfooter['parents'][$items['catparent']][] = $items['id'];
		}
		
		// get the menu
		$ucatblank = "";
		$result = $jakdb->query('SELECT * FROM '.$jaktable.' WHERE showmenu = 0 && showfooter = 0 ORDER BY catparent, catorder, name');
		while ($catblank = $result->fetch_assoc()) {
			
			$ucatblank .= '<li class="list-group-item jakcat">
					<div>
					<div class="text">#'.$catblank["id"].' <a href="index.php?p=categories&amp;sp=edit&amp;ssp='.$catblank["id"].'">'.$catblank["name"].'</a></div>
					<div class="actions">
						'.($catblank["pluginid"] == 0 && $catblank["pageid"] == 0 && $catblank["exturl"] == '' ? '<a class="btn btn-default btn-xs" href="index.php?p=page&amp;sp=newpage&amp;ssp='.$catblank["id"].'"><i class="fa fa-sticky-note-o"></i></a>' : '').' 
						'.($catblank["pluginid"] == 0 && $catblank["pageid"] == 1 && $catblank["exturl"] == '' ? '<a class="btn btn-default btn-xs" href="index.php?p=page&amp;sp=edit&amp;ssp='.$catblank["pageid"].'"><i class="fa fa-pencil"></i></a>' : '').'
						'.($catblank["pluginid"] > 0 && $catblank["exturl"] == '' ? '<i class="fa fa-eyedropper"></i>' : '').'
						'.($catblank["exturl"] != '' ? '<i class="fa fa-link"></i>' : '').'
						
						<a class="btn btn-default btn-xs" href="index.php?p=categories&amp;sp=edit&amp;ssp='.$catblank["id"].'"><i class="fa fa-edit"></i></a>
						'.($catblank["pluginid"] == 0 && $catblank["id"] != 1 ? '<a class="btn btn-danger btn-xs" href="index.php?p=categories&amp;sp=delete&amp;ssp='.$catblank["id"].'" onclick="if(!confirm('.$tl["cat"]["al"].'))return false;"><i class="fa fa-trash-o" ></i></a>' : '').'	
					</div></div></li>';
		    
		}
		
		// Call the template
		$template = 'categories.php';
	}
}
?>