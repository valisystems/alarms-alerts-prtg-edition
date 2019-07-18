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
if (!JAK_USERID || !$jakuser->jakModuleaccess(JAK_USERID,JAK_ACCESSTICKETING)) jak_redirect(BASE_URL);

// All the tables we need for this plugin
$jaktable = DB_PREFIX.'tickets';
$jaktable1 = DB_PREFIX.'ticketcategories';
$jaktable2 = DB_PREFIX.'ticketcomments';
$jaktable3 = DB_PREFIX.'pagesgrid';
$jaktable4 = DB_PREFIX.'pluginhooks';
$jaktable5 = DB_PREFIX.'ticketoptions';

// Get all the functions, well not many
include_once("../plugins/ticketing/admin/include/functions.php");

$uploadthis = false;

// Now start with the plugin use a switch to access all pages
switch ($page1) {

	// Create new st
	case 'new':
		
		// Get the important template stuff
		$JAK_CAT = jak_get_cat_info($jaktable1, 0);
		    
		$CMS_TICKET_OPTIONS = jak_get_st_options();
		
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $defaults = $_POST;
		    
		    if (isset($defaults['save'])) {
		
		    if (empty($defaults['jak_title'])) {
		        $errors['e1'] = $tl['error']['e2'];
		    }
		    
		    if (empty($defaults['jak_type'])) {
		        $errors['e2'] = $tlt['st']['e3'];
		    }
		    
		    if (!empty($_FILES['jak_attach']['name'])) {
		    		
		    			if ($_FILES['jak_attach']['name'] != '') {
		    			
		    			$filename = $_FILES['jak_attach']['name']; // original filename
		    			$tmpf = explode(".", $filename);
		    			$jak_xtension = end($tmpf);
		    			
		    			if ($jak_xtension == "jpg" || $jak_xtension == "jpeg" || $jak_xtension == "png" || $jak_xtension == "gif") {
		    			
		    			if ($_FILES['jak_attach']['size'] <= 500000) {
		    			
		    				$uploadthis = 1;
		    			                 		
		    			   } else {
		    			   	$errors['e3'] = $tlt['st']['e2'];
		    			   }
		    			                
		    			   } else {
		    			   	$errors['e3'] = $tlt['st']['e1'];
		    			   }
		    			                
		    			   } else {
		    			   	$errors['e3'] = $tlt['st']['e'];
		    			}
		    }
		    
		if (count($errors) == 0) {
			
			// Ok no errors now check if we have to upload the file
			if ($uploadthis) {
			
				 $tempFile = $_FILES['jak_attach']['tmp_name'];
				 $origName = substr($_FILES['jak_attach']['name'], 0, -4);
				 $name_space = strtolower($_FILES['jak_attach']['name']);
				 $middle_name = str_replace(" ", "_", $name_space);
				 $middle_name = str_replace(".jpeg", ".jpg", $name_space);
				 $glnrrand = time();
				 $bigPhoto = str_replace(".", "_" . $glnrrand . ".", $middle_name);
				 $smallPhoto = str_replace(".", "_t.", $bigPhoto);
				 
				 $targetPath = $jkv["ticketpath"];
				 $targetFiled = $targetPath .'/'. $bigPhoto; 	    
				 $targetFile =  str_replace('//','/', $targetFiled);
				 $dbSmall = $smallPhoto;
				 $dbBig = $bigPhoto;
				         
				require_once '../include/functions_thumb.php';
				
				// Move file and create thumb     
				move_uploaded_file($tempFile,$targetFile);
				              
				create_thumbnail($targetPath, $targetFile, $smallPhoto, 200, 150, 80);
				create_thumbnail($targetPath, $targetFile, $bigPhoto, 600, 450, 80);
				
				$insert .= 'attachment = "'.smartsql($dbSmall).'",';
			
			}
			
			if (isset($defaults['jak_comment'])) {
				$comment = $defaults['jak_comment'];
			} else {
				$comment = '0';
			}
			
			if (isset($defaults['jak_private'])) {
				$stprivate = $defaults['jak_private'];
			} else {
				$stprivate = '0';
			}
			
			if (isset($defaults['jak_social'])) {
				$stsoc = $defaults['jak_social'];
			} else {
				$stsoc = '0';
			}
			
			if (isset($defaults['jak_vote'])) {
				$showvote = $defaults['jak_vote'];
			} else {
				$showvote = '0';
			}
		    
		    $result = $jakdb->query('INSERT INTO '.$jaktable.' SET 
		    catid = "'.smartsql($defaults['jak_catid']).'",
		    typeticket = "'.smartsql($defaults['jak_type']).'",
		    title = "'.smartsql($defaults['jak_title']).'",
		    content = "'.smartsql($defaults['jak_content']).'",
		    priority = "'.smartsql($defaults['jak_priority']).'",
		    status = "'.smartsql($defaults['jak_status']).'",
		    resolution = "'.smartsql($defaults['jak_resolution']).'",
		    userid = "'.smartsql(JAK_USERID).'",
		    username = "'.smartsql($jakuser->getVar("username")).'",
		    comments = "'.smartsql($comment).'",
		    stprivate = "'.smartsql($stprivate).'",
		    showvote = "'.smartsql($showvote).'",
		    socialbutton = "'.smartsql($stsoc).'",
		    '.$insert.'
		    time = NOW()');
			
			// Get the id
			$rowid = $jakdb->jak_last_id();
			
			// Set tag active to zero
			$tagactive = 0;
		
			if ($defaults['jak_catid'] != 0) {
		
				$result1 = $jakdb->query('UPDATE '.$jaktable1.' SET count = count + 1 WHERE id = "'.smartsql($defaults['jak_catid']).'"');
				
				// Set tag active, well to active
				$tagactive = 1;
			
			}
		
			if (!$result) {
		    	jak_redirect(BASE_URL.'index.php?p=ticketing&sp=new&ssp=e');
			} else {
		
		// Create Tags if the module is active
		if (!empty($defaults['jak_tags'])) {
			// check if tag does not exist and insert in cloud
			JAK_tags::jakBuildcloud($defaults['jak_tags'], $rowid, JAK_PLUGIN_TICKETING);
			// insert tag for normal use
			JAK_tags::jakInsertags($defaults['jak_tags'], $rowid, JAK_PLUGIN_TICKETING, $tagactive);
		}
		
		        jak_redirect(BASE_URL.'index.php?p=ticketing&sp=edit&ssp='.$rowid.'&sssp=s');
		    }
		 } else {
		    
		   	$errors['e'] = $tl['error']['e'];
		    $errors = $errors;
		    }
		}
		}
		
		// Title and Description
		$SECTION_TITLE = $tlt["st"]["m2"];
		$SECTION_DESC = $tlt["st"]["t1"];
		
		// Call the template
		$plugin_template = 'plugins/ticketing/admin/template/newticket.php';
	
	break;
	case 'categories':
	
		// Additional DB field information
		$jakfield = 'catparent';
		$jakfield1 = 'varname';
		 
		 switch ($page2) {
		 	case 'lock':
		 	
		 		$result = $jakdb->query('UPDATE '.$jaktable1.' SET active = IF (active = 1, 0, 1) WHERE id = "'.smartsql($page3).'"');
		        	
		    if (!$result) {
		    	jak_redirect(BASE_URL.'index.php?p=ticketing&sp=categories&ssp=e');
			} else {
		        jak_redirect(BASE_URL.'index.php?p=ticketing&sp=categories&ssp=s');
		    }
		 	
		 	break;
		    case 'delete':
		
			if (jak_row_exist($page3, $jaktable1) && !jak_field_not_exist($page3, $jaktable1, $jakfield)) {
			
				$result = $jakdb->query('DELETE FROM '.$jaktable1.' WHERE id = "'.smartsql($page3).'"');
		
			if (!$result) {
		    	jak_redirect(BASE_URL.'index.php?p=ticketing&sp=categories&ssp=e');
			} else {
				jak_redirect(BASE_URL.'index.php?p=ticketing&sp=categories&ssp=s');
		    }
		    
			} else {
		    	jak_redirect(BASE_URL.'index.php?p=ticketing&sp=categories&ssp=eca');
			}
			break;
		    case 'edit':
		
			if (jak_row_exist($page3,$jaktable1)) {
		
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $defaults = $_POST;
		
		    if (empty($defaults['jak_name'])) {
		        $errors['e1'] = $tl['error']['e12'];
		    }
		    
		    if (jak_field_not_exist_id($defaults['jak_varname'],$page3, $jaktable1, $jakfield1)) {
		        $errors['e2'] = $tl['error']['e13'];
		    }
		    
		    if (empty($defaults['jak_varname']) || !preg_match('/^([a-z-_0-9]||[-_])+$/', $defaults['jak_varname'])) {
		        $errors['e3'] = $tl['error']['e14'];
		    }
		    
		    if (isset($defaults['jak_catparent'])) {
		    	$catparent = $defaults['jak_catparent'];
		    } else {
		    	$catparent = '0';
		    }
		    
		    if (!isset($defaults['jak_permission'])) {
		    	$permission = 0;
		    } elseif (in_array(0, $defaults['jak_permission'])) {
		    	$permission = 0;
		    } else {
		    	$permission = join(',', $defaults['jak_permission']);
		    }
		        
		    if (count($errors) == 0) {
		    
		    if (!empty($defaults['jak_img'])) {
		    	$insert = 'catimg = "'.smartsql($defaults['jak_img']).'",';
		    } else {
		    	$insert = 'catimg = NULL,';
		    }
		
			$result = $jakdb->query('UPDATE '.$jaktable1.' SET 
			name = "'.smartsql($defaults['jak_name']).'",
			varname = "'.smartsql($defaults['jak_varname']).'",
			content = "'.smartsql($defaults['jak_lcontent']).'",
			permission = "'.smartsql($permission).'",
			'.$insert.'
			active = "'.smartsql($defaults['jak_active']).'"
			WHERE id = "'.smartsql($page3).'"');
		
			if (!$result) {
		    	jak_redirect(BASE_URL.'index.php?p=ticketing&sp=categories&ssp=edit&sssp='.$page3.'&ssssp=e');
			} else {
		        jak_redirect(BASE_URL.'index.php?p=ticketing&sp=categories&ssp=edit&sssp='.$page3.'&ssssp=s');
		    }
		 	} else {
		    
		   	$errors['e'] = $tl['error']['e'];
		    $errors = $errors;
		    }
			}
		
			$JAK_FORM_DATA = jak_get_data($page3,$jaktable1);
			$JAK_USERGROUP = jak_get_usergroup_all('usergroup');
			
			// Title and Description
			$SECTION_TITLE = $tlt["st"]["m"].' - '.$tl["cmenu"]["c6"];
			$SECTION_DESC = $tl["cmdesc"]["d6"];
			
			// Call the template
			$plugin_template = 'plugins/ticketing/admin/template/editticketcat.php';
		
			} else {
		   		jak_redirect(BASE_URL.'index.php?p=ticketing&sp=categories&ssp=ene');
			}
			break;
			default:
				
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				
					$count = 1;
					
					foreach ($_POST['menuItem'] as $k => $v) {
					
						if (!is_numeric($v)) $v = 0;
						
						$result = $jakdb->query('UPDATE '.$jaktable1.' SET catparent = "'.smartsql($v).'", catorder = "'.smartsql($count).'" WHERE id = "'.smartsql($k).'"');
						
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
							jak_redirect(BASE_URL.'index.php?p=b2b&sp=categories');
						}
					} else {
						/* Outputtng the success messages */
						if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
							header('Cache-Control: no-cache');
							die(json_encode(array("status" => 0, "html" => $tl["errorpage"]["sql"])));
						} else {
							// redirect back to home
							$_SESSION["errormsg"] = $tl["errorpage"]["sql"];
							jak_redirect(BASE_URL.'index.php?p=b2b&sp=categories');
						}
					}
					
				}
				
				// get the menu
				$result = $jakdb->query('SELECT * FROM '.$jaktable1.' ORDER BY catparent, catorder, name');
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
				
				// Title and Description
				$SECTION_TITLE = $tlt["st"]["m"].' - '.$tl["menu"]["m5"];
				$SECTION_DESC = $tl["cmdesc"]["d5"];
				
				// Call the template
				$plugin_template = 'plugins/ticketing/admin/template/ticketcat.php';
			}
	break;
	// Create new st categories
	case 'newcategory':
	
		// Additional DB Stuff
		$jakfield = 'varname';
	
		// Load all cats and get the usergroup information
		$JAK_USERGROUP = jak_get_usergroup_all('usergroup');
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $defaults = $_POST;
		
		    if (empty($defaults['jak_name'])) {
		        $errors['e1'] = $tl['error']['e12'];
		    }
		    
		    if (jak_field_not_exist($defaults['jak_varname'], $jaktable1, $jakfield)) {
		        $errors['e2'] = $tl['error']['e13'];
		    }
		    
		    if (empty($defaults['jak_varname']) || !preg_match('/^([a-z-_0-9]||[-_])+$/', $defaults['jak_varname'])) {
		        $errors['e3'] = $tl['error']['e14'];
		    }
		        
		    if (count($errors) == 0) {
		    
		    if (!isset($defaults['jak_active'])) {
		    	$catactive = 1;
		    } else {
		    	$catactive = $defaults['jak_active'];
		    }
		    
		    if (!isset($defaults['jak_permission'])) {
		    	$permission = 0;
		    } else {
		    	$permission = join(',', $defaults['jak_permission']);
		    }
		    
		    if (!empty($defaults['jak_img'])) {
		    	$insert = 'catimg = "'.smartsql($defaults['jak_img']).'",';
		    }
		    
			$result = $jakdb->query('INSERT INTO '.$jaktable1.' SET 
			name = "'.smartsql($defaults['jak_name']).'",
			varname = "'.smartsql($defaults['jak_varname']).'",
			content = "'.smartsql($defaults['jak_lcontent']).'",
			permission = "'.smartsql($permission).'",
			active = "'.smartsql($catactive).'",
			'.$insert.'
			catparent = 0');
			
			$rowid = $jakdb->jak_last_id();
		
			if (!$result) {
		    	jak_redirect(BASE_URL.'index.php?p=ticketing&sp=newcategory&ssp=e');
			} else {
		        jak_redirect(BASE_URL.'index.php?p=ticketing&sp=categories&ssp=edit&sssp='.$rowid.'&ssssp=s');
		    }
		 } else {
		    
		   	$errors['e'] = $tl['error']['e'];
		    $errors = $errors;
		    }
		}
		
		// Title and Description
		$SECTION_TITLE = $tlt["st"]["m"].' - '.$tl["cmenu"]["c4"];
		$SECTION_DESC = $tl["cmdesc"]["d8"];
		
		// Call the template
		$plugin_template = 'plugins/ticketing/admin/template/newticketcat.php';
		
	break;
	case 'options':
	
		switch ($page2) {
	
		case 'new':
		        	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		            $defaults = $_POST;
		            
		            if (empty($defaults['jak_name'])) {
		                $errors['e'] = $tl['error']['e2'];
		            }
		            
		            if (count($errors) == 0) {
		            
		            if (!empty($defaults['jak_img'])) {
		            	$insert = ', img = "'.smartsql($defaults['jak_img']).'"';
		            }
		            
		        
		        $result = $jakdb->query('INSERT INTO '.$jaktable5.' SET name = "'.smartsql($defaults['jak_name']).'", time = NOW()'.$insert);
		        
		        $rowid = $jakdb->jak_last_id();
		        
		        	if (!$result) {
		            	jak_redirect(BASE_URL.'index.php?p=ticketing&sp=options&ssp=new&sssp=e');
		        	} else {
		                jak_redirect(BASE_URL.'index.php?p=ticketing&sp=options&ssp=edit&sssp='.$rowid.'&ssssp=s');
		            }
		        	    
		         } else {
		            
		            $errors = $errors;
		            }
		        }
		        
		        // Title and Description
		        $SECTION_TITLE = $tlt["st"]["d36"];
		        $SECTION_DESC = "";
		        
		        // Call the template
		        $plugin_template = 'plugins/ticketing/admin/template/newticketoption.php';
		        
		        
		    break;
		    case 'delete':
		    	
		    	if (jak_row_exist($page3, $jaktable5)) {
		    	        
		    		$result = $jakdb->query('DELETE FROM '.$jaktable5.' WHERE id = "'.smartsql($page3).'"');
		    	        	
		    	if (!$result) {
		    	    	jak_redirect(BASE_URL.'index.php?p=ticketing&sp=options&&ssp=e');
		    		} else {
		    		jak_redirect(BASE_URL.'index.php?p=ticketing&sp=options&&ssp=s');
		    	    }
		    	    
		    	} else {
		    	   	jak_redirect(BASE_URL.'index.php?p=ticketing&sp=options&&ssp=ene');
		    	}
		    	
		    break;
		    case 'edit':
		    
		    	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    	    $defaults = $_POST;
		    	
		    	    if (empty($defaults['jak_name'])) {
		    	        $errors['e'] = $tl['error']['e2'];
		    	    }
		    	    
		    	if (count($errors) == 0) {
		    	    
		    	    if (!empty($defaults['jak_img'])) {
		    	    	$insert = ', img = "'.$defaults['jak_img'].'"';
		    	    }
		    	
		    		$result = $jakdb->query('UPDATE '.$jaktable5.' SET 
		    		name = "'.smartsql($defaults['jak_name']).'",
		    		time = NOW()
		    		'.$insert.'
		    		WHERE id = '.smartsql($page3));
		    	
		    		if (!$result) {
		    	    	jak_redirect(BASE_URL.'index.php?p=ticketing&sp=options&ssp=edit&sssp='.$page3.'&ssssp=e');
		    		} else {
		    		jak_redirect(BASE_URL.'index.php?p=ticketing&sp=options&ssp=edit&sssp='.$page3.'&ssssp=s');
		    	    }
		    	 	} else {
		    	 	
		    	    $errors = $errors;
		    	    
		    	    }
		    		}
		    	
		    		$JAK_FORM_DATA = jak_get_data($page3, $jaktable5);
		    		
		    		// Title and Description
		    		$SECTION_TITLE = $tlt["st"]["m3"];
		    		$SECTION_DESC = "";
		    		
		    		// Call the template
		    		$plugin_template = 'plugins/ticketing/admin/template/newticketoption.php';
		    	    
		    	    
		    break;
			default:
			
				$CMS_TICKET_OPTIONS = jak_get_st_options();
				
				// Title and Description
				$SECTION_TITLE = $tlt["st"]["d35"];
				$SECTION_DESC = "";
				
				// Call the template
				$plugin_template = 'plugins/ticketing/admin/template/ticketoption.php';
		}
		
		
	break;
	case 'comment':
	
		$JAK_TICKET_ALL = jak_get_sts('','','',$jaktable);
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $defaults = $_POST;
		    
		    if (isset($defaults['approve'])) {
		    
		    $lockuser = $defaults['jak_delete_comment'];
		
		        for ($i = 0; $i < count($lockuser); $i++) {
		            $locked = $lockuser[$i];
		            
		        	$result = $jakdb->query('UPDATE '.$jaktable2.' SET approve = IF (approve = 1, 0, 1), session = NULL WHERE id = "'.smartsql($locked).'"');
		        }
		  
		 	if (!$result) {
				jak_redirect(BASE_URL.'index.php?p=ticketing&sp=comment&ssp=e');
			} else {
		        jak_redirect(BASE_URL.'index.php?p=ticketing&sp=comment&ssp=s');
		    }
		    
		    }
		    
		    if (isset($defaults['delete'])) {
		    
		    $lockuser = $defaults['jak_delete_comment'];
		
		        for ($i = 0; $i < count($lockuser); $i++) {
		            $locked = $lockuser[$i];
		            
		            $result = $jakdb->query('DELETE FROM '.$jaktable2.' WHERE id = "'.smartsql($locked).'"');
		        	
		        }
		  
		 	if (!$result) {
				jak_redirect(BASE_URL.'index.php?p=ticketing&sp=comment&ssp=e');
			} else {
		        jak_redirect(BASE_URL.'index.php?p=ticketing&sp=comment&ssp=s');
		    }
		    
		    }
		
		 }
		 
		 switch ($page2) {
		 	case 'approval':
		 	
		        $JAK_TICKETCOM_ALL = jak_get_st_comments($st->limit, 'approve', '');
		        
		        // Title and Description
		        $SECTION_TITLE = $tlt["st"]["d33"];
		        $SECTION_DESC = $tlt["st"]["t1"];
		        
		        // Call the template
		        $plugin_template = 'plugins/ticketing/admin/template/ticketcomment.php';
		        
		 	 	break;
		 	case 'sort':
		 		if ($page3 == 'ticketid') {
		 			$bu = 'ticketid';
		 		} elseif ($page3 == 'user') {
		 			$bu = 'userid';
		 		} else {
		 			jak_redirect(BASE_URL);
		 		}
		 		$getTotal = jak_get_total($jaktable2, $page4, $bu, '');
		 		if ($getTotal != 0) {
		 		
			        // Paginator
			       	$st = new JAK_Paginator;
					$st->items_total = $getTotal;
			       	$st->mid_range = $jkv["adminpagemid"];
			       	$st->items_per_page = $jkv["adminpageitem"];
			       	$st->jak_get_page = $page5;
			       	$st->jak_where = 'index.php?p=ticketing&sp=comment&ssp=sort&sssp='.$page3.'&ssssp='.$page4;
			       	$st->paginate();
			       	$JAK_PAGINATE_SORT = $st->display_pages();
			        $JAK_TICKETCOM_SORT = jak_get_st_comments($st->limit, $page4, $bu);
			        
			    // Title and Description
			    $SECTION_TITLE = $tlt["st"]["d40"];
			    $SECTION_DESC = $tlt["st"]["t2"];
		        
		        // Call the template
		        $plugin_template = 'plugins/ticketing/admin/template/ticketcommentsort.php';
		        
		 	} else {
		 		jak_redirect(BASE_URL.'index.php?p=ticketing&sp=comment&ssp=ene');
		    }
		    
		 break;
		 case 'approve':
		 	
		 	if (jak_row_exist($page3,$jaktable2)) {
		        
		    	$result = $jakdb->query('UPDATE '.$jaktable2.' SET approve = IF (approve = 1, 0, 1), session = NULL WHERE id = "'.smartsql($page3).'"');
		        	
			if (!$result) {
		    	jak_redirect(BASE_URL.'index.php?p=ticketing&sp=comment&ssp=e');
			} else {
		        jak_redirect(BASE_URL.'index.php?p=ticketing&sp=comment&ssp=s');
		    }
		    
			} else {
		    	jak_redirect(BASE_URL.'index.php?p=ticketing&sp=comment&ssp=ene');
			}
		 break;
		 case 'delete':
		 
		 	if (jak_row_exist($page3,$jaktable2)) {
		        
		    	$result = $jakdb->query('DELETE FROM '.$jaktable2.' WHERE id = "'.smartsql($page3).'"');
		        	
			if (!$result) {
		    	jak_redirect(BASE_URL.'index.php?p=ticketing&sp=comment&ssp=e');
			} else {
		        jak_redirect(BASE_URL.'index.php?p=ticketing&sp=comment&ssp=s');
		    }
		    
			} else {
		    	jak_redirect(BASE_URL.'index.php?p=ticketing&sp=comment&ssp=ene');
			}
			
		break;
		default:
			
			$getTotal = jak_get_total($jaktable2, '', '', '');
			
			if ($getTotal != 0) {
				
				// Paginator
				$st = new JAK_Paginator;
				$st->items_total = $getTotal;
				$st->mid_range = $jkv["adminpagemid"];
				$st->items_per_page = $jkv["adminpageitem"];
				$st->jak_get_page = $page2;
				$st->jak_where = 'index.php?p=ticketing&sp=comment';
				$st->paginate();
				$JAK_PAGINATE = $st->display_pages();
				
			}
				
			$JAK_TICKETCOM_ALL = jak_get_st_comments($st->limit, '', '');
			
			// Title and Description
			$SECTION_TITLE = $tlt["st"]["d11"];
			$SECTION_DESC = $tlt["st"]["t2"];
			
			// Call the template
			$plugin_template = 'plugins/ticketing/admin/template/ticketcomment.php';
		}
		
	break;
	case 'setting':
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $defaults = $_POST;
		    
		    if (!is_numeric($defaults['jak_maxpost'])) {
		        $errors['e1'] = $tl['error']['e15'];
		    }
		    
		    if (!empty($defaults['jak_email'])) {
		    if (!filter_var($defaults['jak_email'], FILTER_VALIDATE_EMAIL)) {
		        $errors['e2'] = $tl['error']['e3'];
		    }
		    }
		
		    if (empty($defaults['jak_date'])) {
		        $errors['e3'] = $tl['error']['e4'];
		    }
		    
		    if (!is_numeric($defaults['jak_item'])) {
		        $errors['e5'] = $tl['error']['e15'];
		    }
		    
		    if (!is_numeric($defaults['jak_mid'])) {
		        $errors['e5'] = $tl['error']['e15'];
		    }
		    
		    if (!empty($defaults['jak_path'])) {
		       	if (!is_dir($defaults['jak_path'])) {
		       		$errors['e6'] = $tl['error']['e22'];
		       	}
		    }
		    
		    if (!is_numeric($defaults['jak_rssitem'])) {
		        $errors['e7'] = $tl['error']['e15'];
		    }
		
		    if (count($errors) == 0) {
		    
		    // Get th order into the right format
		    $storder = $defaults['jak_showstordern'].' '.$defaults['jak_showstorder'];
		    
		    // Do the dirty work in mysql
		    $result = $jakdb->query('UPDATE '.DB_PREFIX.'setting SET value = CASE varname
		    	WHEN "tickettitle" THEN "'.smartsql($defaults['jak_title']).'"
		    	WHEN "ticketdesc" THEN "'.smartsql($defaults['jak_lcontent']).'"
		        WHEN "ticketemail" THEN "'.smartsql($defaults['jak_email']).'"
		        WHEN "ticketorder" THEN "'.smartsql($storder).'"
		        WHEN "ticketdateformat" THEN "'.smartsql($defaults['jak_date']).'"
		        WHEN "tickettimeformat" THEN "'.smartsql($defaults['jak_time']).'"
		        WHEN "ticketurl" THEN "'.smartsql($defaults['jak_ticketurl']).'"
		        WHEN "ticketpath" THEN "'.smartsql($defaults['jak_path']).'"
		        WHEN "ticketrss" THEN "'.smartsql($defaults['jak_rssitem']).'"
		        WHEN "ticketgvote" THEN "'.smartsql($defaults['jak_vote']).'"
		        WHEN "ticketgsocial" THEN "'.smartsql($defaults['jak_social']).'"
		        WHEN "ticketmaxpost" THEN "'.smartsql($defaults['jak_maxpost']).'"
		        WHEN "ticketshortmsg" THEN "'.smartsql($defaults['jak_shortmsg']).'"
		        WHEN "ticketpagemid" THEN "'.smartsql($defaults['jak_mid']).'"
		        WHEN "ticketpageitem" THEN "'.smartsql($defaults['jak_item']).'"
		    END
		    	WHERE varname IN ("tickettitle", "ticketdesc", "ticketemail", "ticketorder", "ticketdateformat", "tickettimeformat", "ticketurl","ticketmaxpost", "ticketshortmsg", "ticketpagemid", "ticketpageitem", "ticketpath", "ticketrss", "ticketgvote", "ticketgsocial")');
			
			// Save order for sidebar widget
			if (isset($defaults['jak_hookshow_new']) && is_array($defaults['jak_hookshow_new'])) {
				
				$exorder = $defaults['horder_new'];
				$hookid = $defaults['real_hook_id_new'];
				$plugind = $defaults['sreal_plugin_id_new'];
				$doith = array_combine($hookid, $exorder);
				$pdoith = array_combine($hookid, $plugind);
				
				foreach ($doith as $key => $exorder) {
				
					if (in_array($key, $defaults['jak_hookshow_new'])) {
					
						// Get the real what id
						$whatid = 0;
						if (isset($defaults['whatid_'.$pdoith[$key]])) $whatid = $defaults['whatid_'.$pdoith[$key]];
				
						$jakdb->query('INSERT INTO '.$jaktable3.' SET plugin = "'.smartsql(JAK_PLUGIN_TICKETING).'", hookid = "'.smartsql($key).'", pluginid = "'.smartsql($pdoith[$key]).'", whatid = "'.smartsql($whatid).'", orderid = "'.smartsql($exorder).'"');
					
					}
				
				}
			
			}
			
			// Now check if all the sidebar a deselct and hooks exist, if so delete all associated to this page
			$result = $jakdb->query('SELECT id FROM '.$jaktable3.' WHERE plugin = '.JAK_PLUGIN_TICKETING.' AND hookid != 0');
				$row = $result->fetch_assoc();
			
			if (isset($defaults['jak_hookshow_new']) && !is_array($defaults['jak_hookshow_new']) && $row['id'] && !is_array($defaults['jak_hookshow'])) {
			
				$jakdb->query('DELETE FROM '.$jaktable3.' WHERE plugin = "'.smartsql(JAK_PLUGIN_TICKETING).'" AND ticketid = 0 AND hookid != 0');
			
			}
				
			// Save order or delete for extra sidebar widget
			if (isset($defaults['jak_hookshow']) && is_array($defaults['jak_hookshow'])) {
			
				$exorder = $defaults['horder'];
				$hookid = $defaults['real_hook_id'];
				$hookrealid = implode(',', $defaults['real_hook_id']);
				$doith = array_combine($hookid, $exorder);
				
				// Reset update
				$updatesql = $updatesql1 = "";
				
				// Run the foreach for the hooks
				foreach ($doith as $key => $exorder) {
					
					// Get the real what id
					$result = $jakdb->query('SELECT pluginid FROM '.$jaktable3.' WHERE id = "'.smartsql($key).'" AND hookid != 0');
					$row = $result->fetch_assoc();
						
					// Get the whatid
					$whatid = 0;
					if (isset($defaults['whatid_'.$row["pluginid"]])) $whatid = $defaults['whatid_'.$row["pluginid"]];
						
						if (in_array($key, $defaults['jak_hookshow'])) {
							$updatesql .= sprintf("WHEN %d THEN %d ", $key, $exorder);
							$updatesql1 .= sprintf("WHEN %d THEN %d ", $key, $whatid);
							
						} else {
							$jakdb->query('DELETE FROM '.$jaktable3.' WHERE id = "'.smartsql($key).'"');
						}
					}
					
					$jakdb->query('UPDATE '.$jaktable3.' SET orderid = CASE id
					'.$updatesql.'
					END
					WHERE id IN ('.$hookrealid.')');
					
					$jakdb->query('UPDATE '.$jaktable3.' SET whatid = CASE id
					'.$updatesql1.'
					END
					WHERE id IN ('.$hookrealid.')');
			
			} else {
				$jakdb->query('DELETE FROM '.$jaktable2.' WHERE plugin = "'.smartsql(JAK_PLUGIN_TICKETING).'" AND ticketid = 0 AND hookid != 0');
			}
				
			if (!$result) {
				jak_redirect(BASE_URL.'index.php?p=ticketing&sp=setting&ssp=e');
			} else {
		        jak_redirect(BASE_URL.'index.php?p=ticketing&sp=setting&ssp=s');
		    }
		    } else {
		    
		   	$errors['e'] = $tl['error']['e'];
		    $errors = $errors;
		    }
		}
		
		$JAK_SETTING = jak_get_setting('ticket');
		
		// Get the sort orders for the grid
		$grid = $jakdb->query('SELECT id, hookid, whatid, orderid FROM '.$jaktable3.' WHERE plugin = "'.smartsql(JAK_PLUGIN_TICKETING).'" ORDER BY orderid ASC');
		while ($grow = $grid->fetch_assoc()) {
		        // collect each record into $_data
		        $JAK_PAGE_GRID[] = $grow;
		}
		
		// Get the sidebar templates
		$result = $jakdb->query('SELECT id, name, widgetcode, exorder, pluginid FROM '.$jaktable4.' WHERE hook_name = "tpl_sidebar" AND active = 1 ORDER BY exorder ASC');
		while ($row = $result->fetch_assoc()) {
			$JAK_HOOKS[] = $row;
		}
		
		// Now let's check how to display the order
		$showstarray = explode(" ", $jkv["ticketorder"]);
		
		if (is_array($showstarray) && in_array("ASC", $showstarray) || in_array("DESC", $showstarray)) {
		
				$JAK_SETTING['showstwhat'] = $showstarray[0];
				$JAK_SETTING['showstorder'] = $showstarray[1];
			
		}
		
		// Get the special vars for multi language support
		$JAK_FORM_DATA["title"] = $jkv["tickettitle"];
		$JAK_FORM_DATA["content"] = $jkv["ticketdesc"];
		
		// Title and Description
		$SECTION_TITLE = $tlt["st"]["m"].' - '.$tl["menu"]["m2"];
		$SECTION_DESC = $tl["cmdesc"]["d2"];
		
		// Call the template
		$plugin_template = 'plugins/ticketing/admin/template/ticketsetting.php';
		
	break;
	case 'trash':
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $defaults = $_POST;
		    
		    if (isset($defaults['untrash'])) {
		    
			    $deltrash = $defaults['jak_delete_trash'];
			    
			    for ($i = 0; $i < count($deltrash); $i++) {
			    	$trash = $deltrash[$i];
			        $result = $jakdb->query('UPDATE '.$jaktable2.' SET trash = IF (trash = 1, 0, 1) WHERE id = "'.smartsql($trash).'"');
			    }
			  
			 	if (!$result) {
					jak_redirect(BASE_URL.'index.php?p=ticketing&sp=trash&ssp=e');
				} else {
			        jak_redirect(BASE_URL.'index.php?p=ticketing&sp=trash&ssp=s');
			    }
		    
		    }
		    
		    if (isset($defaults['delete'])) {
		    
			    $deltrash = $defaults['jak_delete_trash'];
			
			        for ($i = 0; $i < count($deltrash); $i++) {
			            $trash = $deltrash[$i];
			            $result = $jakdb->query('DELETE FROM '.$jaktable2.' WHERE id = "'.smartsql($trash).'"');     	
			        }
			  
			 	if (!$result) {
					jak_redirect(BASE_URL.'index.php?p=ticketing&sp=trash&ssp=e');
				} else {
			        jak_redirect(BASE_URL.'index.php?p=ticketing&sp=trash&ssp=s');
			    }
		    
		    }
		
		 }
		
		$result = $jakdb->query('SELECT * FROM '.$jaktable2.' WHERE trash = 1 ORDER BY id DESC');
		while ($row = $result->fetch_assoc()) {
		        // collect each record into $_data
		        $JAK_TRASH_ALL[] = $row;
		    }
		    
		// Title and Description
		$SECTION_TITLE = $tlt["st"]["d10"];
		$SECTION_DESC = $tlt["st"]["d11"].' - '.$tlt["st"]["m"];
		
		// Get the template, same from the user
		$plugin_template = 'plugins/ticketing/admin/template/trash.php';
	break;
	case 'quickedit':
	        if (jak_row_exist($page2,$jaktable)) {
	
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	    	$defaults = $_POST;
	
		    if (empty($defaults['jak_title'])) {
		        $errors['e1'] = $tl['error']['e2'];
		    }
		    
			    // Now do the dirty stuff in mysql       
			    if (count($errors) == 0) {
			
					$result = $jakdb->query('UPDATE '.$jaktable.' SET 
					title = "'.smartsql($defaults['jak_title']).'",
					content = "'.smartsql($defaults['jak_lcontent']).'"
					WHERE id = "'.smartsql($page2).'"');
			
					if (!$result) {
			    		jak_redirect(BASE_URL.'index.php?p=ticketing&sp=quickedit&ssp='.$page2.'&sssp=e');
					} else {
			        	jak_redirect(BASE_URL.'index.php?p=ticketing&sp=quickedit&ssp='.$page2.'&sssp=s');
			    	}
		 		} else {
		    
				   	$errors['e'] = $tl['error']['e'];
				    $errors = $errors;
				}
			}
			
			// Get the data
			$JAK_FORM_DATA = jak_get_data($page2,$jaktable);
			
			$template = 'quickedit.php';
			
			} else {
			   	jak_redirect(BASE_URL.'index.php?p=ticketing&sp=ene');
			}
	break;
	default:
		
		// Important Smarty stuff
		$JAK_CAT = jak_get_cat_info($jaktable1, 0);
		 
		 switch ($page1) {
		 	case 'showcat':
		 		
		 		$getTotal = jak_get_total($jaktable,$page2,'catid','');
		 		
		 		if ($getTotal != 0) {
		 		
			        // Paginator
			       	$st = new JAK_Paginator;
					$st->items_total = $getTotal;
			       	$st->mid_range = $jkv["adminpagemid"];
			       	$st->items_per_page = $jkv["adminpageitem"];
			       	$st->jak_get_page = $page3;
			       	$st->jak_where = 'index.php?p=ticketing&sp=showcat&ssp='.$page2;
			       	$st->paginate();
			       	$JAK_PAGINATE_SORT = $st->display_pages();
			       	
			        $JAK_TICKET_ALL = jak_get_sts($st->limit, $page2, 'catid', $jaktable);
			        
			        // Title and Description
			        $SECTION_TITLE = $tlt["st"]["m1"];
			        $SECTION_DESC = $tlt["st"]["t"];
			        
			        // Call the template
			        $plugin_template = 'plugins/ticketing/admin/template/ticket.php';
		        
		 		} else {
		 			jak_redirect(BASE_URL.'index.php?p=ticketing&sp=ene');
		    	}
		 	break;
		 	case 'useronly':
		 		
		 		$getTotal = jak_get_total($jaktable,$page2,'userid','');
		 		
		 		if ($getTotal != 0) {
		 		
			 	    // Paginator
			 	   	$st = new JAK_Paginator;
			 		$st->items_total = $getTotal;
			 	   	$st->mid_range = $jkv["adminpagemid"];
			 	   	$st->items_per_page = $jkv["adminpageitem"];
			 	   	$st->jak_get_page = $page3;
			 	   	$st->jak_where = 'index.php?p=ticketing&sp=useronly&ssp='.$page2;
			 	   	$st->paginate();
			 	   	$JAK_PAGINATE_SORT = $st->display_pages();
			 	   	
			 	    $JAK_TICKET_ALL = jak_get_sts($st->limit, $page2, 'userid', $jaktable);
			 	    
			 	    // Title and Description
			 	    $SECTION_TITLE = $tlt["st"]["m1"];
			 	    $SECTION_DESC = $tlt["st"]["t"];
			 	    
			 	    // Call the template
			 	    $plugin_template = 'plugins/ticketing/admin/template/ticket.php';
		 	    
		 		} else {
		 			jak_redirect(BASE_URL.'index.php?p=ticketing&sp=ene');
		 		}
		 	break;
		 	case 'lock':
		 	
		 		$result2 = $jakdb->query('SELECT catid, active FROM '.$jaktable.' WHERE id = "'.smartsql($page2).'"');
		 		$row2 = $result2->fetch_assoc();
		 		
		 		if ($row2['active'] == 1) {
		 			$result1 = $jakdb->query('UPDATE '.$jaktable1.' SET count = count - 1 WHERE id = "'.smartsql($row2['catid']).'"');
		 		} else {
		 			$result1 = $jakdb->query('UPDATE '.$jaktable1.' SET count = count + 1 WHERE id = "'.smartsql($row2['catid']).'"');
		 		}
		 		
		 		$result = $jakdb->query('UPDATE '.$jaktable.' SET active = IF (active = 1, 0, 1), session = NULL WHERE id = "'.smartsql($page2).'"');
		 	    	
		 	    JAK_tags::jaklocktags($page2,JAK_PLUGIN_TICKETING);
		 	    	
		 	if (!$result) {
		 		jak_redirect(BASE_URL.'index.php?p=ticketing&sp=e');
		 	} else {
		 	    jak_redirect(BASE_URL.'index.php?p=ticketing&sp=s');
		 	}
		 		
		 	break;
		    case 'delete':
		        if (is_numeric($page2) && jak_row_exist($page2,$jaktable)) {
		        
		        	$result2 = $jakdb->query('SELECT catid, attachment FROM '.$jaktable.' WHERE id = "'.smartsql($page2).'"');
					$row2 = $result2->fetch_assoc();
					
					// Delete attachment
					if (!empty($row2['attachment'])) {
					
						$jakdir = $jkv["ticketpath"];
						$filesmalld = $jakdir.'/'.$row2['attachment'];
						$filebig = str_replace("_t.", ".", $row2['attachment']);
						$filebigd = $jakdir.'/'.$filebig;
						
						$filesmallp =  str_replace("//","/",$filesmalld);
						$filebigp =  str_replace("//","/",$filebigd);
						
						if (is_file($filesmallp)) {
						    unlink($filesmallp);
						}
						
						if (is_file($filebigp)) {
						    unlink($filebigp);
						}
					}
		        	
		        	$jakdb->query('UPDATE '.$jaktable1.' SET count = count - 1 WHERE id = "'.smartsql($row2['catid']).'"');
					
					$jakdb->query('DELETE FROM '.$jaktable2.' WHERE ticketid = "'.smartsql($page2).'"');
					
					$result = $jakdb->query('DELETE FROM '.$jaktable.' WHERE id = "'.smartsql($page2).'"');
		
			if (!$result) {
		    	jak_redirect(BASE_URL.'index.php?p=ticketing&sp=e');
			} else {
			
				JAK_tags::jakDeletetags($page2, JAK_PLUGIN_TICKETING);
				
		        jak_redirect(BASE_URL.'index.php?p=ticketing&sp=s');
		    }
		    
		} else {
		   	jak_redirect(BASE_URL.'index.php?p=ticketing&sp=ene');
		}
		break;
		case 'edit':
		
		if (is_numeric($page2) && jak_row_exist($page2,$jaktable)) {
		
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $defaults = $_POST;
		    
		    // Delete the tags
		    if (!empty($defaults['jak_tagdelete'])) {
		    $tags = $defaults['jak_tagdelete'];
		
		        for ($i = 0; $i < count($tags); $i++) {
		            $tag = $tags[$i];
		            
		            JAK_tags::jakDeleteonetag($tag);
		        }
		    }
		    
		    // Delete the comments
		    if (!empty($defaults['jak_delete_comment'])) {
		    	$jakdb->query('DELETE FROM '.$jaktable2.' WHERE stid = "'.smartsql($page2).'"');
		    }
		    
		    // Delete the likes
		    if (!empty($defaults['jak_delete_rate'])) {
		    	$jakdb->query('DELETE FROM '.DB_PREFIX.'like_counter WHERE btnid = "'.smartsql($page2).'" AND locid = "'.smartsql(JAK_PLUGIN_TICKETING).'"');
		    	$jakdb->query('DELETE FROM '.DB_PREFIX.'like_client WHERE btnid = "'.smartsql($page2).'" AND locid = "'.smartsql(JAK_PLUGIN_TICKETING).'"');
		    }
		    
		    // Delete attachment
		    if (!empty($defaults['jak_delete_attach'])) {
		    	$jakdir = $jkv["ticketpath"];
		    	$filesmalld = $jakdir.'/'.$defaults['jak_filename'];
		    	$filebig = str_replace("_t.", ".", $defaults['jak_filename']);
		    	$filebigd = $jakdir.'/'.$filebig;
		    	
		    	$filesmallp =  str_replace("//","/",$filesmalld);
		    	$filebigp =  str_replace("//","/",$filebigd);
		    	
		    	if (is_file($filesmallp)) {
		    	    unlink($filesmallp);
		    	}
		    	
		    	if (is_file($filebigp)) {
		    	    unlink($filebigp);
		    	}
		    	
		    	// Set the path to zero in the db
		    	$insert = 'attachment = NULL,';
		    }
		
		    if (empty($defaults['jak_title'])) {
		        $errors['e1'] = $tl['error']['e2'];
		    }
		    
		    if (!empty($_FILES['jak_attach']['name'])) {
		    		
		    			if ($_FILES['jak_attach']['name'] != '') {
		    			
		    			$filename = $_FILES['jak_attach']['name']; // original filename
		    			$tmpf = explode(".", $filename);
		    			$jak_xtension = end($tmpf);
		    			
		    			if ($jak_xtension == "jpg" || $jak_xtension == "jpeg" || $jak_xtension == "png" || $jak_xtension == "gif") {
		    			
		    			if ($_FILES['jak_attach']['size'] <= 500000) {
		    			
		    				$uploadthis = 1;
		    			                 		
		    			   } else {
		    			   	$errors['e3'] = $tlt['st']['e2'];
		    			   }
		    			                
		    			   } else {
		    			   	$errors['e3'] = $tlt['st']['e1'];
		    			   }
		    			                
		    			   } else {
		    			   	$errors['e3'] = $tlt['st']['e'];
		    			}
		    }
		    
		    if (count($errors) == 0) {
		    
		    if (!empty($defaults['jak_update_time'])) {
		    	$insert .= 'time = NOW(),';
		    }
		    
		    // Ok no errors now check if we have to upload the file
		    if ($uploadthis) {
		    
		    	if (!empty($defaults['jak_filename'])) {
		    		$jakdir = $jkv["ticketpath"];
		    		$filesmalld = $jakdir.'/'.$defaults['jak_filename'];
		    		$filebig = str_replace("_t.", ".", $defaults['jak_filename']);
		    		$filebigd = $jakdir.'/'.$filebig;
		    		$filesmallp =  str_replace("//","/",$filesmalld);
		    		$filebigp =  str_replace("//","/",$filebigd);
		    		
		    		if (is_file($filesmallp)) {
		    		    unlink($filesmallp);
		    		}
		    		
		    		if (is_file($filebigp)) {
		    		    unlink($filebigp);
		    		}
		    	}
		    
		    	 $tempFile = $_FILES['jak_attach']['tmp_name'];
		    	 $origName = substr($_FILES['jak_attach']['name'], 0, -4);
		    	 $name_space = strtolower($_FILES['jak_attach']['name']);
		    	 $middle_name = str_replace(" ", "_", $name_space);
		    	 $middle_name = str_replace(".jpeg", ".jpg", $name_space);
		    	 $glnrrand = time();
		    	 $bigPhoto = str_replace(".", "_" . $glnrrand . ".", $middle_name);
		    	 $smallPhoto = str_replace(".", "_t.", $bigPhoto);
		    	 
		    	 $targetPath = $jkv["ticketpath"];
		    	 $targetFiled = $targetPath .'/'. $bigPhoto; 	    
		    	 $targetFile =  str_replace('//','/', $targetFiled);
		    	 $dbSmall = $smallPhoto;
		    	 $dbBig = $bigPhoto;
		    	         
		    	require_once '../include/functions_thumb.php';
		    	
		    	// Move file and create thumb     
		    	move_uploaded_file($tempFile,$targetFile);
		    	              
		    	create_thumbnail($targetPath, $targetFile, $smallPhoto, 200, 150, 80);
		    	create_thumbnail($targetPath, $targetFile, $bigPhoto, 600, 450, 80);
		    	
		    	$insert .= 'attachment = "'.smartsql($dbSmall).'",';
		    
		    }
		
			$result = $jakdb->query('UPDATE '.$jaktable.' SET 
			catid = "'.smartsql($defaults['jak_catid']).'",
			typeticket = "'.smartsql($defaults['jak_type']).'",
			title = "'.smartsql($defaults['jak_title']).'",
			content = "'.smartsql($defaults['jak_content']).'",
			priority = "'.smartsql($defaults['jak_priority']).'",
			status = "'.smartsql($defaults['jak_status']).'",
			resolution = "'.smartsql($defaults['jak_resolution']).'",
			comments = "'.smartsql($defaults['jak_comment']).'",
			stprivate = "'.smartsql($defaults['jak_private']).'",
			showvote = "'.smartsql($defaults['jak_vote']).'",
			'.$insert.'
			socialbutton = "'.smartsql($defaults['jak_social']).'"
			WHERE id = "'.smartsql($page2).'"');
		
		// Set tag active to zero
		$tagactive = 0;
		
		if ($defaults['jak_oldcatid'] != 0) {
			// Set tag active, well to active
			$tagactive = 1;
		}
		
		if ($defaults['jak_catid'] != 0 || $defaults['jak_catid'] != $defaults['jak_oldcatid']) {
			$jakdb->query('UPDATE '.$jaktable1.' SET count = count - 1 WHERE id = "'.smartsql($defaults['jak_oldcatid']).'"');
			$jakdb->query('UPDATE '.$jaktable1.' SET count = count + 1 WHERE id = "'.smartsql($defaults['jak_catid']).'"');
		
			// Set tag active, well to active
			$tagactive = 1;
		}
		
			if (!$result) {
		    	jak_redirect(BASE_URL.'index.php?p=ticketing&sp=edit&ssp='.$page2.'&sssp=e');
			} else {
				
		// Create Tags if the module is active
		if (!empty($defaults['jak_tags'])) {
			// check if tag does not exist and insert in cloud
			JAK_tags::jakBuildcloud($defaults['jak_tags'], smartsql($page2), JAK_PLUGIN_TICKETING);
			// insert tag for normal use
			JAK_tags::jakInsertags($defaults['jak_tags'], smartsql($page2), JAK_PLUGIN_TICKETING, $tagactive);
		}
		
		        jak_redirect(BASE_URL.'index.php?p=ticketing&sp=edit&ssp='.$page2.'&sssp=s');
		    }
			    
		 } else {
		    
		   	$errors['e'] = $tl['error']['e'];
		    $errors = $errors;
		    }
		}
		
		$JAK_FORM_DATA = jak_get_data($page2, $jaktable);
		
		if (JAK_TAGS) {
			$JAK_TAGLIST = jak_get_tags($page2, JAK_PLUGIN_TICKETING);
		}
		
		$CMS_TICKET_OPTIONS = jak_get_st_options();
		
		// Title and Description
		$SECTION_TITLE = $tlt["st"]["m3"];
		$SECTION_DESC = $tlt["st"]["t1"];
		
		// Call the template
		$plugin_template = 'plugins/ticketing/admin/template/editticket.php';
		
		} else {
		   	jak_redirect(BASE_URL.'index.php?p=ticketing&sp=ene');
		}
		break;
		case 'email':
		
			if ($page3) {
		 	
		 		if (jak_row_exist($page3, DB_PREFIX.'user')) {
		 			
		 			$sql = 'SELECT email, username FROM '.DB_PREFIX.'user WHERE id = "'.smartsql($page3).'"';
		 			
		 		} else {
		 			jak_redirect(BASE_URL.'index.php?p=ticketing&sp=ene');
		 		}
		 	
		 	} else {
		 	
		 		$sql = 'SELECT email, username FROM '.$jaktable.' WHERE id = "'.smartsql($page2).'"';
		 		
		 	}
		 	
		 	if ($sql) {
		 			
		 		$result = $jakdb->query($sql);
		 		$row = $result->fetch_assoc();
		 			
		 		$mail = new PHPMailer(); // defaults to using php "mail()"
		 		$body = file_get_contents('../plugins/ticketing/admin/ticket_solved.html');
		 		$body = str_ireplace("[\]",'',$body);
		 		
		 		if ($jkv["ticketemail"]) {
		 			$mail->SetFrom($jkv["ticketemail"], $jkv["tickettitle"]);
		 		} else {
		 			$mail->SetFrom($jkv["email"], $jkv["tickettitle"]);
		 		}
		 		
				$address = $row['email'];
	 			$mail->AddAddress($address, utf8_decode($row['username']));
	 			$mail->Subject = $jkv["title"].' - '.$jkv["tickettitle"].' - '.$tlt['st']['d39'].$page2.')';
	 			$mail->AltBody = $tlt['st']['d39'].$page2.')';
	 			$mail->MsgHTML($body);
	 			$mail->Send(); // Send email without any warnings
		 			
		 			if ($result) {
		 				jak_redirect(BASE_URL.'index.php?p=ticketing&sp=s');
		 			}
		 			
		 	} else {
		 		jak_redirect(BASE_URL.'index.php?p=ticketing&sp=ene');
		 	}
		 		
		break;
		case 'sort':
		
		 	// getNumber
		 	$getTotal = jak_get_total($jaktable,'','','');
		 	
		 	// Now if total run paginator
		 	if ($getTotal != 0) {
		 		// Paginator
		 		$pages = new JAK_Paginator;
		 		$pages->items_total = $getTotal;
		 		$pages->mid_range = $jkv["adminpagemid"];
		 		$pages->items_per_page = $jkv["adminpageitem"];
		 		$pages->jak_get_page = $page4;
		 		$pages->jak_where = 'index.php?p=faq&sp=sort&ssp='.$page2.'&sssp='.$page3;
		 		$pages->paginate();
		 		$JAK_PAGINATE = $pages->display_pages();
		 	}
		 	
		 	$result = $jakdb->query('SELECT * FROM '.$jaktable.' ORDER BY '.$page2.' '.$page3.' '.$pages->limit);
		 	while ($row = $result->fetch_assoc()) {
		 	    $JAK_TICKET_ALL[] = $row;
		 	}
		 	
		 	// Title and Description
		 	$SECTION_TITLE = $tlt["st"]["m1"];
		 	$SECTION_DESC = $tlt["st"]["t"];
		 	
		 	// Call the template
		 	$plugin_template = 'plugins/ticketing/admin/template/ticket.php';
		 		
		break;
		default:
		
			// Hello we have a post request
			if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['jak_delete_st'])) {
			    $defaults = $_POST;
			    
			    if (isset($defaults['lock'])) {
			    
			    $lockuser = $defaults['jak_delete_st'];
			
			        for ($i = 0; $i < count($lockuser); $i++) {
			            $locked = $lockuser[$i];
			            
			            $result2 = $jakdb->query('SELECT catid, active FROM '.$jaktable.' WHERE id = "'.smartsql($locked).'"');
						$row2 = $result2->fetch_assoc();
						
						if ($row2['active'] == 1) {
							$result1 = $jakdb->query('UPDATE '.$jaktable1.' SET count = count - 1 WHERE id = "'.smartsql($row2['catid']).'"');
						} else {
							$result1 = $jakdb->query('UPDATE '.$jaktable1.' SET count = count + 1 WHERE id = "'.smartsql($row2['catid']).'"');	
						}
			            
			        	$result = $jakdb->query('UPDATE '.$jaktable.' SET active = IF (active = 1, 0, 1), session = NULL WHERE id = "'.smartsql($locked).'"');
			        	
			        	JAK_tags::jaklocktags($locked,JAK_PLUGIN_TICKETING);
			        }
			  
			 	if (!$result) {
					jak_redirect(BASE_URL.'index.php?p=ticketing&sp=e');
				} else {
			        jak_redirect(BASE_URL.'index.php?p=ticketing&sp=s');
			    }
			    
			    }
			    
			    if (isset($defaults['delete'])) {
			    
			    $lockuser = $defaults['jak_delete_st'];
			
			        for ($i = 0; $i < count($lockuser); $i++) {
			            $locked = $lockuser[$i];
			            
			            $result2 = $jakdb->query('SELECT catid, attachment FROM '.$jaktable.' WHERE id = "'.smartsql($locked).'"');
						$row2 = $result2->fetch_assoc();
						
						// Delete attachment
						if (!empty($row2['attachment'])) {
							$jakdir = $jkv["ticketpath"];
							$filesmalld = $jakdir.'/'.$row2['attachment'];
							$filebig = str_replace("_t.", ".", $row2['attachment']);
							$filebigd = $jakdir.'/'.$filebig;
							
							$filesmallp =  str_replace("//","/",$filesmalld);
							$filebigp =  str_replace("//","/",$filebigd);
							
							if (is_file($filesmallp)) {
							    unlink($filesmallp);
							}
							
							if (is_file($filebigp)) {
							    unlink($filebigp);
							}
						}
			        	
			        	$result1 = $jakdb->query('UPDATE '.$jaktable1.' SET count = count - 1 WHERE id = "'.smartsql($row2['catid']).'"');
						$result3 = $jakdb->query('DELETE FROM '.$jaktable2.' WHERE ticketid = "'.smartsql($locked).'"');
						$result = $jakdb->query('DELETE FROM '.$jaktable.' WHERE id = "'.smartsql($locked).'"');
			        	
			        	JAK_tags::jakDeletetags($locked, JAK_PLUGIN_TICKETING);
			        }
			  
			 	if (!$result) {
					jak_redirect(BASE_URL.'index.php?p=ticketing&sp=e');
				} else {
			        jak_redirect(BASE_URL.'index.php?p=ticketing&sp=s');
			    }
			    
			    }
			
			 }
			
			// get all sts out
			$getTotal = jak_get_total($jaktable, '', '', '');
			
			if ($getTotal != 0) {
				// Paginator
				$st = new JAK_Paginator;
				$st->items_total = $getTotal;
				$st->mid_range = $jkv["adminpagemid"];
				$st->items_per_page = $jkv["adminpageitem"];
				$st->jak_get_page = $page1;
				$st->jak_where = 'index.php?p=ticketing';
				$st->paginate();
				$JAK_PAGINATE = $st->display_pages();
				
				$JAK_TICKET_ALL = jak_get_sts($st->limit, '','', $jaktable);
			}
			
			
			// Title and Description
			$SECTION_TITLE = $tlt["st"]["m1"];
			$SECTION_DESC = $tlt["st"]["t"];
			
			// Call the template
			$plugin_template = 'plugins/ticketing/admin/template/ticket.php';
		}
}
?>