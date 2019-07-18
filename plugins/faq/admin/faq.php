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
if (!JAK_USERID || !$jakuser->jakModuleaccess(JAK_USERID,JAK_ACCESSFAQ)) jak_redirect(BASE_URL);

// All the tables we need for this plugin
$jaktable = DB_PREFIX.'faq';
$jaktable1 = DB_PREFIX.'faqcategories';
$jaktable2 = DB_PREFIX.'faqcomments';
$jaktable3 = DB_PREFIX.'contactform';
$jaktable4 = DB_PREFIX.'pagesgrid';
$jaktable5 = DB_PREFIX.'pluginhooks';

// Get all the functions, well not many
include_once("../plugins/faq/admin/include/functions.php");

// Now start with the plugin use a switch to access all pages
switch ($page1) {

	// Create new faq
	case 'new':
		
		// Get the important template stuff
		$JAK_CAT = jak_get_cat_info($jaktable1, 0);
		$JAK_CONTACT_FORMS = jak_get_page_info($jaktable3, '');
				
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $defaults = $_POST;
		    
		    if (isset($defaults['save'])) {
		
		    if (empty($defaults['jak_title'])) {
		        $errors['e1'] = $tl['error']['e2'];
		    }
		    
		    if (isset($defaults['jak_showtitle'])) {
		    	$showtitle = $defaults['jak_showtitle'];
		    } else {
		    	$showtitle = '0';
		    }
		    
		    if (isset($defaults['jak_showdate'])) {
		    	$showdate = $defaults['jak_showdate'];
		    } else {
		    	$showdate = '0';
		    }
		    
		    if (isset($defaults['jak_comment'])) {
		    	$comment = $defaults['jak_comment'];
		    } else {
		    	$comment = '0';
		    }
		    
		    if (isset($defaults['jak_showcontact'])) {
		    	$jakcon = $defaults['jak_showcontact'];
		    } else {
		    	$jakcon = '0';
		    }
		    
		    if (count($errors) == 0) {
		    
		    if (!empty($defaults['jak_img'])) {
		    	$insert .= 'previmg = "'.smartsql($defaults['jak_img']).'",';
		    }
		    
		    if (!isset($defaults['jak_social'])) $defaults['jak_social'] = 0;
		
		$result = $jakdb->query('INSERT INTO '.$jaktable.' SET 
		catid = "'.smartsql($defaults['jak_catid']).'",
		title = "'.smartsql($defaults['jak_title']).'",
		content = "'.smartsql($defaults['jak_content']).'",
		showtitle = "'.smartsql($showtitle).'",
		showdate = "'.smartsql($showdate).'",
		showcontact = "'.smartsql($jakcon).'",
		comments = "'.smartsql($comment).'",
		showvote = "'.smartsql($defaults['jak_vote']).'",
		socialbutton = "'.smartsql($defaults['jak_social']).'",
		'.$insert.'
		time = NOW()');
		
		$rowid = $jakdb->jak_last_id();
		
		// Set tag active to zero
		$tagactive = 0;
		
		if ($defaults['jak_catid'] != 0) {
		
			$result1 = $jakdb->query('UPDATE '.$jaktable1.' SET count = count + 1 WHERE id = "'.smartsql($defaults['jak_catid']).'"');
			// Set tag active, well to active
			$tagactive = 1;
			
		}
		
		// Save order for sidebar widget
		if (isset($defaults['jak_hookshow']) && is_array($defaults['jak_hookshow'])) {
			
			$exorder = $defaults['horder'];
			$hookid = $defaults['real_hook_id'];
			$plugind = $defaults['sreal_plugin_id'];
			$doith = array_combine($hookid, $exorder);
			$pdoith = array_combine($hookid, $plugind);
		
		foreach ($doith as $key => $exorder) {
		
			if (in_array($key, $defaults['jak_hookshow'])) {
			
				// Get the real what id
				$whatid = 0;
				if (isset($defaults['whatid_'.$pdoith[$key]])) $whatid = $defaults['whatid_'.$pdoith[$key]];
		
				$jakdb->query('INSERT INTO '.$jaktable4.' SET faqid = "'.$rowid.'", hookid = "'.smartsql($key).'", pluginid = "'.smartsql($pdoith[$key]).'", whatid = "'.smartsql($whatid).'", orderid = "'.smartsql($exorder).'", plugin = '.JAK_PLUGIN_FAQ);
			
			}
		
		}
		
		}
		
		if (!$result) {
		    	jak_redirect(BASE_URL.'index.php?p=faq&sp=new&ssp=e');
			} else {
		
		// Create Tags if the module is active
		if (!empty($defaults['jak_tags'])) {
					// check if tag does not exist and insert in cloud
			        JAK_tags::jakBuildcloud($defaults['jak_tags'],$rowid,JAK_PLUGIN_FAQ);
			        // insert tag for normal use
			        JAK_tags::jakInsertags($defaults['jak_tags'],$rowid,JAK_PLUGIN_FAQ, $tagactive);
			        
		}
		        jak_redirect(BASE_URL.'index.php?p=faq&sp=edit&ssp='.$rowid.'&sssp=s');
		    }
		 } else {
		    
		   	$errors['e'] = $tl['error']['e'];
		    $errors = $errors;
		    }
		}
		}
		
		// Get the sidebar templates
		$result = $jakdb->query('SELECT id, name, widgetcode, exorder, pluginid FROM '.$jaktable5.' WHERE hook_name = "tpl_sidebar" AND active = 1 ORDER BY exorder ASC');
		while ($row = $result->fetch_assoc()) {
			$JAK_HOOKS[] = $row;
		}
		
		// Get active sidebar widgets
		$grid = $jakdb->query('SELECT hookid FROM '.$jaktable4.' WHERE plugin = '.JAK_PLUGIN_FAQ.' ORDER BY orderid ASC');
		while ($grow = $grid->fetch_assoc()) {
			// collect each record into $_data
		    $JAK_ACTIVE_GRID[] = $grow;
		}
		
		// Title and Description
		$SECTION_TITLE = $tlf["faq"]["m2"];
		$SECTION_DESC = $tlf["faq"]["t1"];
		
		// Call the template
		$plugin_template = 'plugins/faq/admin/template/newfaq.php';
	
	break;
	case 'categories':
	
		// Additional DB field information
		$jakfield = 'catparent';
		$jakfield1 = 'varname';
		 
		 switch ($page2) {
		 	case 'lock':
		 	
		 		$result = $jakdb->query('UPDATE '.$jaktable1.' SET active = IF (active = 1, 0, 1) WHERE id = "'.smartsql($page3).'"');
		        	
			    if (!$result) {
			    	jak_redirect(BASE_URL.'index.php?p=faq&sp=categories&ssp=e');
				} else {
			        jak_redirect(BASE_URL.'index.php?p=faq&sp=categories&ssp=s');
			    }
		 	
		 	break;
		    case 'delete':
		
			if (jak_row_exist($page3,$jaktable1) && !jak_field_not_exist($page3,$jaktable1,$jakfield)) {
			
				$result = $jakdb->query('DELETE FROM '.$jaktable1.' WHERE id = "'.smartsql($page3).'"');
		
			if (!$result) {
				jak_redirect(BASE_URL.'index.php?p=faq&sp=categories&ssp=e');
			} else {
			    jak_redirect(BASE_URL.'index.php?p=faq&sp=categories&ssp=s');
			}
		    
			} else {
		    	jak_redirect(BASE_URL.'index.php?p=faq&sp=categories&ssp=eca');
			}
			
			break;
		    case 'edit':
		
			if (jak_row_exist($page3,$jaktable1)) {
		
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $defaults = $_POST;
		
		    if (empty($defaults['jak_name'])) {
		        $errors['e1'] = $tl['error']['e12'];
		    }
		    
		    if (jak_field_not_exist_id($defaults['jak_varname'],$page3,$jaktable1,$jakfield1)) {
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
		    	$insert .= 'catimg = "'.smartsql($defaults['jak_img']).'",';
		    } else {
		    	$insert .= 'catimg = NULL,';
		    }
		
			$result = $jakdb->query('UPDATE '.$jaktable1.' SET 
			name = "'.smartsql($defaults['jak_name']).'",
			varname = "'.smartsql($defaults['jak_varname']).'",
			content = "'.smartsql($defaults['jak_lcontent']).'",
			permission = "'.smartsql($permission).'",
			'.$insert.'
			active = "'.smartsql($defaults['jak_active']).'"
			WHERE id = '.smartsql($page3));
		
			if (!$result) {
				jak_redirect(BASE_URL.'index.php?p=faq&sp=categories&ssp=edit&sssp='.$page3.'&ssssp=e');
			} else {
			    jak_redirect(BASE_URL.'index.php?p=faq&sp=categories&ssp=edit&sssp='.$page3.'&ssssp=s');
			}
		 	} else {
		    
		   	$errors['e'] = $tl['error']['e'];
		    $errors = $errors;
		    }
			}
		
			$JAK_FORM_DATA = jak_get_data($page3,$jaktable1);
			$JAK_USERGROUP = jak_get_usergroup_all('usergroup');
			
			// Title and Description
			$SECTION_TITLE = $tl["cmenu"]["c6"];
			$SECTION_DESC = $tl["cmdesc"]["d6"];
			
			$plugin_template = 'plugins/faq/admin/template/editfaqcat.php';
		
			} else {
		    	jak_redirect(BASE_URL.'index.php?p=faq&sp=categories&ssp=ene');
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
				$SECTION_TITLE = $tlf["faq"]["m"].' - '.$tl["menu"]["m5"];
				$SECTION_DESC = "";
				
				// Call the template
				$plugin_template = 'plugins/faq/admin/template/faqcat.php';
			}
	break;
	// Create new faq categories
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
		    
		    if (jak_field_not_exist($defaults['jak_varname'],$jaktable1,$jakfield)) {
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
		    	$insert = 'catimg = "'.$defaults['jak_img'].'",';
		    }
		    
			$result = $jakdb->query('INSERT INTO '.$jaktable1.' SET 
			name = "'.smartsql($defaults['jak_name']).'",
			varname = "'.smartsql($defaults['jak_varname']).'",
			content = "'.smartsql($defaults['jak_lcontent']).'",
			permission = "'.smartsql($permission).'",
			active = "'.$catactive.'",
			'.$insert.'
			catparent = "'.$defaults['jak_catparent'].'"');
			
			$rowid = $jakdb->jak_last_id();
		
			if (!$result) {
			    jak_redirect(BASE_URL.'index.php?p=faq&sp=newcategory&ssp=e');
			} else {
			    jak_redirect(BASE_URL.'index.php?p=faq&sp=categories&ssp=edit&sssp='.$rowid.'&ssssp=s');
			}
		 } else {
		    
		   	$errors['e'] = $tl['error']['e'];
		    $errors = $errors;
		    }
		}
		
		// Title and Description
		$SECTION_TITLE = $tlf["faq"]["m"].' - '.$tl["cmenu"]["c4"];
		$SECTION_DESC = $tl["cmdesc"]["d8"];
		
		// Call the template
		$plugin_template = 'plugins/faq/admin/template/newfaqcat.php';
		
	break;
	case 'comment';
		
		$getTotal = jak_get_total($jaktable2, '', '', '');
		if ($getTotal != 0) {
			// Paginator
			$pages = new JAK_Paginator;
			$pages->items_total = $getTotal;
			$pages->mid_range = $jkv["adminpagemid"];
			$pages->items_per_page = $jkv["adminpageitem"];
			$pages->jak_get_page = $page2;
			$pages->jak_where = 'index.php?p=faq&sp=comment';
			$pages->paginate();
			$JAK_PAGINATE = $pages->display_pages();
			
			// Get the comments
			$JAK_FAQCOM_ALL = jak_get_faq_comments($pages->limit,'','');
		}
		
		// Get the faq's
		$JAK_FAQ_ALL = jak_get_faqs('', '', $jaktable);
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $defaults = $_POST;
		    
		    if (isset($defaults['approve'])) {
		    
		    	$lockuser = $defaults['jak_delete_comment'];
		
		        for ($i = 0; $i < count($lockuser); $i++) {
		            $locked = $lockuser[$i];
		        	$result = $jakdb->query('UPDATE '.$jaktable2.' SET approve = IF (approve = 1, 0, 1), session = NULL WHERE id = "'.smartsql($locked).'"');
		        }
		  
			 	if (!$result) {
			 		jak_redirect(BASE_URL.'index.php?p=faq&sp=comment&ssp=e');
			 	} else {
			 	    jak_redirect(BASE_URL.'index.php?p=faq&sp=comment&ssp=s');
			 	}
		    
		    }
		    
		    if (isset($defaults['delete'])) {
		    
		    	$lockuser = $defaults['jak_delete_comment'];
		
		        for ($i = 0; $i < count($lockuser); $i++) {
		            $locked = $lockuser[$i];
		            $result = $jakdb->query('DELETE FROM '.$jaktable2.' WHERE id = "'.smartsql($locked).'"');
		        }
		  
			 	if (!$result) {
			 		jak_redirect(BASE_URL.'index.php?p=faq&sp=comment&ssp=e');
			 	} else {
			 	    jak_redirect(BASE_URL.'index.php?p=faq&sp=comment&ssp=s');
			 	}
		    
		    }
		
		 }
		 
		 switch ($page2) {
		 	case 'approval':
		        $JAK_FAQCOM_ALL = jak_get_faq_comments($pages->limit,'approve','');
		        
		        // Title and Description
		        $SECTION_TITLE = $tlf["faq"]["d20"];
		        $SECTION_DESC = $tlf["faq"]["t2"];
		        
		        // Get the template
		        $plugin_template = 'plugins/faq/admin/template/faqcomment.php';
		 	 	break;
		 	case 'sort':
		 		if ($page3 == 'faq') {
		 			$bu = 'faqid';
		 		} elseif ($page3 == 'user') {
		 			$bu = 'userid';
		 		} else {
		 			jak_redirect(BASE_URL);
		 		}
		 		$getTotal = jak_get_total($jaktable2, $page4, $bu, '');
		 		if ($getTotal != 0) {
		        // Paginator
		       	$pages = new JAK_Paginator;
				$pages->items_total = $getTotal;
		       	$pages->mid_range = $jkv["adminpagemid"];
		       	$pages->items_per_page = $jkv["adminpageitem"];
		       	$pages->jak_get_page = $page5;
		       	$pages->jak_where = 'index.php?p=faq&sp=comment&ssp=sort&sssp='.$page3.'&ssssp='.$page4;
		       	$pages->paginate();
		       	$JAK_PAGINATE_SORT = $pages->display_pages();
		        $JAK_FAQCOM_SORT = jak_get_faq_comments($pages->limit, $page4, $bu);
		        
		        // Title and Description
		        $SECTION_TITLE = $tlf["faq"]["d20"];
		        $SECTION_DESC = $tlf["faq"]["t2"];
		        
		        // Get the template
		        $plugin_template = 'plugins/faq/admin/template/faqcommentsort.php';
		 	} else {
		 		jak_redirect(BASE_URL.'index.php?p=faq&sp=comment&ssp=ene');
		    }
		 	break;
		 	case 'approve':
		 	
		        if (jak_row_exist($page3, $jaktable2)) {
		        
		        	$sql = 'UPDATE '.$jaktable2.' SET approve = IF (approve = 1, 0, 1), session = NULL WHERE id = '.$page3;
		        	$result = $jakdb->query($sql);
		        	
					if (!$result) {
						jak_redirect(BASE_URL.'index.php?p=faq&sp=comment&ssp=e');
					} else {
						jak_redirect(BASE_URL.'index.php?p=faq&sp=comment&ssp=s');
					}
					
				} else {
					jak_redirect(BASE_URL.'index.php?p=faq&sp=comment&ssp=ene');
				}
				
		    break;
		    case 'delete':
		        if (jak_row_exist($page3, $jaktable2)) {
		        
		        	$sql = 'DELETE FROM '.$jaktable2.' WHERE id = '.smartsql($page3).'';
					$result = $jakdb->query($sql);
		        	
				if (!$result) {
				    	jak_redirect(BASE_URL.'index.php?p=faq&sp=comment&ssp=e');
					} else {
				        jak_redirect(BASE_URL.'index.php?p=faq&sp=comment&ssp=s');
				    }
				
				} else {
						jak_redirect(BASE_URL.'index.php?p=faq&sp=comment&ssp=ene');
				}
		break;
		default:
			
			// Title and Description
			$SECTION_TITLE = $tlf["faq"]["d19"];
			$SECTION_DESC = $tlf["faq"]["t2"];
			
			// Call the template
			$plugin_template = 'plugins/faq/admin/template/faqcomment.php';
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
		    
		   if (!is_numeric($defaults['jak_rssitem'])) {
		       $errors['e7'] = $tl['error']['e15'];
		   }
		
		    if (count($errors) == 0) {
		    
		    // Get th order into the right format
		    $faqorder = $defaults['jak_showfaqordern'].' '.$defaults['jak_showfaqorder'];
		    
		    // Do the dirty work in mysql
		    $sql = 'UPDATE '.DB_PREFIX.'setting SET value = CASE varname
		    	WHEN "faqtitle" THEN "'.smartsql($defaults['jak_title']).'"
		    	WHEN "faqdesc" THEN "'.smartsql($defaults['jak_lcontent']).'"
		        WHEN "faqemail" THEN "'.smartsql($defaults['jak_email']).'"
		        WHEN "faqorder" THEN "'.$faqorder.'"
		        WHEN "faqdateformat" THEN "'.smartsql($defaults['jak_date']).'"
		        WHEN "faqtimeformat" THEN "'.smartsql($defaults['jak_time']).'"
		        WHEN "faqurl" THEN '.$defaults['jak_faqurl'].'
		        WHEN "faqmaxpost" THEN '.$defaults['jak_maxpost'].'
		        WHEN "faqrss" THEN "'.smartsql($defaults['jak_rssitem']).'"
		        WHEN "faqpagemid" THEN "'.smartsql($defaults['jak_mid']).'"
		        WHEN "faqpageitem" THEN "'.smartsql($defaults['jak_item']).'"
		    END
				WHERE varname IN ("faqtitle","faqdesc","faqemail","faqorder","faqdateformat","faqtimeformat","faqurl","faqmaxpost","faqpagemid","faqpageitem","faqrss")';
				$result = $jakdb->query($sql);
				
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
				
						$jakdb->query('INSERT INTO '.$jaktable4.' SET plugin = '.JAK_PLUGIN_FAQ.', hookid = "'.smartsql($key).'", pluginid = "'.smartsql($pdoith[$key]).'", whatid = "'.smartsql($whatid).'", orderid = "'.smartsql($exorder).'"');
					
					}
				
				}
			
			}
			
			// Now check if all the sidebar a deselct and hooks exist, if so delete all associated to this page
			$result = $jakdb->query('SELECT id FROM '.$jaktable4.' WHERE plugin = '.JAK_PLUGIN_FAQ.' AND hookid != 0');
				$row = $result->fetch_assoc();
			
			if (isset($defaults['jak_hookshow_new']) && !is_array($defaults['jak_hookshow_new']) && $row['id'] && !is_array($defaults['jak_hookshow'])) {
			
				$jakdb->query('DELETE FROM '.$jaktable4.' WHERE plugin = '.JAK_PLUGIN_FAQ.' AND faqid = 0 AND hookid != 0');
			
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
					$result = $jakdb->query('SELECT pluginid FROM '.$jaktable4.' WHERE id = "'.smartsql($key).'" AND hookid != 0');
					$row = $result->fetch_assoc();
						
					// Get the whatid
					$whatid = 0;
					if (isset($defaults['whatid_'.$row["pluginid"]])) $whatid = $defaults['whatid_'.$row["pluginid"]];
						
						if (in_array($key, $defaults['jak_hookshow'])) {
							$updatesql .= sprintf("WHEN %d THEN %d ", $key, $exorder);
							$updatesql1 .= sprintf("WHEN %d THEN %d ", $key, $whatid);
							
						} else {
							$jakdb->query('DELETE FROM '.$jaktable4.' WHERE id = "'.smartsql($key).'"');
						}
					}
					
					$jakdb->query('UPDATE '.$jaktable4.' SET orderid = CASE id
					'.$updatesql.'
					END
					WHERE id IN ('.$hookrealid.')');
					
					$jakdb->query('UPDATE '.$jaktable4.' SET whatid = CASE id
					'.$updatesql1.'
					END
					WHERE id IN ('.$hookrealid.')');
			
			} else {
				$jakdb->query('DELETE FROM '.$jaktable2.' WHERE plugin = "'.smartsql(JAK_PLUGIN_FAQ).'" AND faqid = 0 AND hookid != 0');
			}
				
			if (!$result) {
				jak_redirect(BASE_URL.'index.php?p=faq&sp=setting&ssp=e');
			} else {
			    jak_redirect(BASE_URL.'index.php?p=faq&sp=setting&ssp=s');
			}
		    } else {
		    
		   	$errors['e'] = $tl['error']['e'];
		    $errors = $errors;
		    }
		}
		
		$JAK_SETTING = jak_get_setting('faq');
		
		// Get the sort orders for the grid
		$JAK_PAGE_GRID = array();
		$grid = $jakdb->query('SELECT id, hookid, whatid, orderid FROM '.$jaktable4.' WHERE plugin = '.JAK_PLUGIN_FAQ.' AND faqid = 0 ORDER BY orderid ASC');
		while ($grow = $grid->fetch_assoc()) {
		        // collect each record into $_data
		        $JAK_PAGE_GRID[] = $grow;
		}
		
		// Get the sidebar templates
		$JAK_HOOKS = array();
		$result = $jakdb->query('SELECT id, name, widgetcode, exorder, pluginid FROM '.$jaktable5.' WHERE hook_name = "tpl_sidebar" AND active = 1 ORDER BY exorder ASC');
		while ($row = $result->fetch_assoc()) {
			$JAK_HOOKS[] = $row;
		}
		
		
		// Now let's check how to display the order
		$showfaqarray = explode(" ", $jkv["faqorder"]);
		
		if (is_array($showfaqarray) && in_array("ASC", $showfaqarray) || in_array("DESC", $showfaqarray)) {
		
				$JAK_SETTING['showfaqwhat'] = $showfaqarray[0];
				$JAK_SETTING['showfaqorder'] = $showfaqarray[1];
			
		}
		
		// Get the special vars for multi language support
		$JAK_FORM_DATA["title"] = $jkv["faqtitle"];
		$JAK_FORM_DATA["content"] = $jkv["faqdesc"];
		
		// Title and Description
		$SECTION_TITLE = $tlf["faq"]["m"].' - '.$tl["menu"]["m2"];
		$SECTION_DESC = $tl["cmdesc"]["d2"];
		
		// Call the template
		$plugin_template = 'plugins/faq/admin/template/faqsetting.php';
		
	break;
	case 'trash':
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $defaults = $_POST;
		    
		    if (isset($defaults['untrash'])) {
		    
		    $deltrash = $defaults['jak_delete_trash'];
		    
		            for ($i = 0; $i < count($deltrash); $i++) {
		                $trash = $deltrash[$i];
		            
		        	$sql = 'UPDATE '.$jaktable2.' SET trash = IF (trash = 1, 0, 1) WHERE id = "'.$trash.'"';
		        	$result = $jakdb->query($sql);
		        }
		  
		 	if (!$result) {
		 		jak_redirect(BASE_URL.'index.php?p=faq&sp=trash&ssp=e');
		 	} else {
		 	    jak_redirect(BASE_URL.'index.php?p=faq&sp=trash&ssp=s');
		 	}
		    
		    }
		    
		    if (isset($defaults['delete'])) {
		    
		    $deltrash = $defaults['jak_delete_trash'];
		
		        for ($i = 0; $i < count($deltrash); $i++) {
		            $trash = $deltrash[$i];
		            
		            
		            $sql = 'DELETE FROM '.$jaktable2.' WHERE id = '.$trash.'';
		            $result = $jakdb->query($sql);      	
		        }
		  
		 	if (!$result) {
		 		jak_redirect(BASE_URL.'index.php?p=faq&sp=trash&ssp=e');
		 	} else {
		 	    jak_redirect(BASE_URL.'index.php?p=faq&sp=trash&ssp=s');
		 	}
		    
		    }
		
		 }
		
		$sql = 'SELECT * FROM '.$jaktable2.' WHERE trash = 1 ORDER BY id DESC';
		$result = $jakdb->query($sql);
		while ($row = $result->fetch_assoc()) {
		        // collect each record into $_data
		        $JAK_TRASH_ALL[] = $row;
		    }
		
		// Title and Description
		$SECTION_TITLE = $tlf["faq"]["d18"];
		$SECTION_DESC = $tlf["faq"]["t2"];
		
		// Get the template, same from the user
		$plugin_template = 'plugins/faq/admin/template/trash.php';
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
	    		jak_redirect(BASE_URL.'index.php?p=faq&sp=quickedit&ssp='.$page2.'&sssp=e');
			} else {
				
	        	jak_redirect(BASE_URL.'index.php?p=faq&sp=quickedit&ssp='.$page2.'&sssp=s');
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
			   	jak_redirect(BASE_URL.'index.php?p=faq&sp=ene');
			}
	break;
	default:
		
		// Important Smarty stuff
		$JAK_CAT = jak_get_cat_info($jaktable1, 0);
		$JAK_CONTACT_FORMS = jak_get_page_info($jaktable3, '');
		 
		 switch ($page1) {
		 	case 'showcat':
		 		$getTotal = jak_get_total($jaktable,$page2,'catid','');
		 		if ($getTotal != 0) {
		        // Paginator
		       	$pages = new JAK_Paginator;
				$pages->items_total = $getTotal;
		       	$pages->mid_range = $jkv["adminpagemid"];
		       	$pages->items_per_page = $jkv["adminpageitem"];
		       	$pages->jak_get_page = $page3;
		       	$pages->jak_where = 'index.php?p=faq&sp=showcat&ssp='.$page2;
		       	$pages->paginate();
		       	$JAK_PAGINATE_SORT = $pages->display_pages();
		        $JAK_FAQ_SORT = jak_get_faqs($pages->limit,$page2,$jaktable);
		        
		        // Title and Description
		        $SECTION_TITLE = $tlf["faq"]["m1"];
		        $SECTION_DESC = $tlf["faq"]["t"];
		        
		        // Get the template
		        $plugin_template = 'plugins/faq/admin/template/faqcatsort.php';
		 	} else {
		 		jak_redirect(BASE_URL.'index.php?p=faq&sp=ene');
		    }
		 	break;
		 	case 'lock':
		 	
		 		$result2 = $jakdb->query('SELECT catid, active FROM '.$jaktable.' WHERE id = "'.smartsql($page2).'"');
		 		$row2 = $result2->fetch_assoc();
		 		
		 		if ($row2['active'] == 1) {
		 			$jakdb->query('UPDATE '.$jaktable1.' SET count = count - 1 WHERE id = "'.smartsql($row2['catid']).'"');
		 		} else {
		 			$jakdb->query('UPDATE '.$jaktable1.' SET count = count + 1 WHERE id = "'.smartsql($row2['catid']).'"');
		 		}
		 		
		 		$result = $jakdb->query('UPDATE '.$jaktable.' SET active = IF (active = 1, 0, 1) WHERE id = "'.smartsql($page2).'"');
		 		
		 	    JAK_tags::jaklocktags($page2,JAK_PLUGIN_FAQ);
		 	    	
		 	if (!$result) {
		 		jak_redirect(BASE_URL.'index.php?p=faq&sp=e');
		 	} else {
		 	    jak_redirect(BASE_URL.'index.php?p=faq&sp=s');
		 	}
		 		
		 break;
		 case 'delete':
		 	if (is_numeric($page2) && jak_row_exist($page2,$jaktable)) {
		        
		        	$result2 = $jakdb->query('SELECT catid FROM '.$jaktable.' WHERE id = "'.smartsql($page2).'"');
					$row2 = $result2->fetch_assoc();
		        	
		        	$jakdb->query('UPDATE '.$jaktable1.' SET count = count - 1 WHERE id = "'.smartsql($row2['catid']).'"');
					$jakdb->query('DELETE FROM '.$jaktable2.' WHERE faqid = "'.smartsql($page2).'"');
					
					$result = $jakdb->query('DELETE FROM '.$jaktable.' WHERE id = "'.smartsql($page2).'"');
		
			if (!$result) {
		    	jak_redirect(BASE_URL.'index.php?p=faq&sp=e');
			} else {
				JAK_tags::jakDeletetags($page2, JAK_PLUGIN_FAQ);
				
		        jak_redirect(BASE_URL.'index.php?p=faq&sp=s');
		    }
		    
		} else {
		   	jak_redirect(BASE_URL.'index.php?p=faq&sp=ene');
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
		    		$jakdb->query('DELETE FROM '.$jaktable2.' WHERE faqid = "'.smartsql($page2).'"');	
		    }
		    
		    // Delete the likes
		    if (!empty($defaults['jak_delete_rate'])) {
		    	$jakdb->query('DELETE FROM '.DB_PREFIX.'like_counter WHERE btnid = "'.smartsql($page2).'" AND locid = "'.smartsql(JAK_PLUGIN_FAQ).'"');
		    	$jakdb->query('DELETE FROM '.DB_PREFIX.'like_client WHERE btnid = "'.smartsql($page2).'" AND locid = "'.smartsql(JAK_PLUGIN_FAQ).'"');
		    }
		    
		    // Delete the hits
		    if (!empty($defaults['jak_delete_hits'])) {
		    	$jakdb->query('UPDATE '.$jaktable.' SET hits = 1 WHERE id = "'.smartsql($page2).'"');
		    }
		
		    if (empty($defaults['jak_title'])) {
		        $errors['e1'] = $tl['error']['e2'];
		    }
		    
		    if (count($errors) == 0) {
		    
		    if (!empty($defaults['jak_update_time'])) {
		    	$insert .= 'time = NOW(),';
		    }
		    
		    if (!empty($defaults['jak_img'])) {
		    	$insert .= 'previmg = "'.smartsql($defaults['jak_img']).'",';
		    } else {
		    	$insert .= 'previmg = NULL,';
		    }
		
		$result = $jakdb->query('UPDATE '.$jaktable.' SET 
		catid = "'.$defaults['jak_catid'].'",
		title = "'.smartsql($defaults['jak_title']).'",
		content = "'.smartsql($defaults['jak_content']).'",
		showtitle = "'.smartsql($defaults['jak_showtitle']).'",
		showcontact = "'.smartsql($defaults['jak_showcontact']).'",
		showdate = "'.smartsql($defaults['jak_showdate']).'",
		comments = "'.smartsql($defaults['jak_comment']).'",
		'.$insert.'
		showvote = "'.smartsql($defaults['jak_vote']).'",
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
			
					$jakdb->query('INSERT INTO '.$jaktable4.' SET faqid = "'.$page2.'", hookid = "'.smartsql($key).'", pluginid = "'.smartsql($pdoith[$key]).'", whatid = "'.smartsql($whatid).'", orderid = "'.smartsql($exorder).'", plugin = '.JAK_PLUGIN_FAQ);
				
				}
			
			}
		
		}
		
		// Now check if all the sidebar a deselct and hooks exist, if so delete all associated to this page
		$result = $jakdb->query('SELECT id FROM '.$jaktable4.' WHERE faqid = "'.smartsql($page2).'" AND hookid != 0');
		$row = $result->fetch_assoc();
		
		if (isset($defaults['jak_hookshow_new']) && !is_array($defaults['jak_hookshow_new']) && $row['id'] && !is_array($defaults['jak_hookshow'])) {
		
			$jakdb->query('DELETE FROM '.$jaktable4.' WHERE faqid = "'.smartsql($page2).'" AND hookid != 0');
		
		}
		
		// Save order or delete for extra sidebar widget
		if (isset($defaults['jak_hookshow']) && is_array($defaults['jak_hookshow'])) {
		
			$exorder = $defaults['horder'];
			$hookid = $defaults['real_hook_id'];
			$hookrealid = implode(',', $defaults['real_hook_id']);
			$doith = array_combine($hookid, $exorder);
			
			foreach ($doith as $key => $exorder) {
				
				// Get the real what id
				$result = $jakdb->query('SELECT pluginid FROM '.$jaktable4.' WHERE id = "'.smartsql($key).'" AND hookid != 0');
				$row = $result->fetch_assoc();
					
				$whatid = 0;
				if (isset($defaults['whatid_'.$row["pluginid"]])) $whatid = $defaults['whatid_'.$row["pluginid"]];
					
					if (in_array($key, $defaults['jak_hookshow'])) {
						$updatesql .= sprintf("WHEN %d THEN %d ", $key, $exorder);
						$updatesql1 .= sprintf("WHEN %d THEN %d ", $key, $whatid);
						
					} else {
						$jakdb->query('DELETE FROM '.$jaktable4.' WHERE id = "'.smartsql($key).'"');
					}
				}
				
				$jakdb->query('UPDATE '.$jaktable4.' SET orderid = CASE id
				'.$updatesql.'
				END
				WHERE id IN ('.$hookrealid.')');
				
				$jakdb->query('UPDATE '.$jaktable4.' SET whatid = CASE id
				'.$updatesql1.'
				END
				WHERE id IN ('.$hookrealid.')');
		
		}
		
			if (!$result) {
		    	jak_redirect(BASE_URL.'index.php?p=faq&sp=edit&ssp='.$page2.'&sssp=e');
			} else {
				
		// Create Tags if the module is active
		if (!empty($defaults['jak_tags'])) {
			// check if tag does not exist and insert in cloud
			JAK_tags::jakBuildcloud($defaults['jak_tags'],smartsql($page2),JAK_PLUGIN_FAQ);
			// insert tag for normal use
			JAK_tags::jakInsertags($defaults['jak_tags'],smartsql($page2),JAK_PLUGIN_FAQ, $tagactive);
			
		}
		        jak_redirect(BASE_URL.'index.php?p=faq&sp=edit&ssp='.$page2.'&sssp=s');
		    }
			    
		 } else {
		    
		   	$errors['e'] = $tl['error']['e'];
		    $errors = $errors;
		    }
		}
		
		$JAK_FORM_DATA = jak_get_data($page2, $jaktable);
		if (JAK_TAGS) {
			$JAK_TAGLIST = jak_get_tags($page2, JAK_PLUGIN_FAQ);
		}
		
		// Get the sort orders for the grid
		$grid = $jakdb->query('SELECT id, pluginid, hookid, whatid, orderid FROM '.$jaktable4.' WHERE faqid = "'.smartsql($page2).'" ORDER BY orderid ASC');
		while ($grow = $grid->fetch_assoc()) {
		        // collect each record into $_data
		        $JAK_PAGE_GRID[] = $grow;
		}
		
		// Get the sidebar templates
		$result = $jakdb->query('SELECT id, name, widgetcode, exorder, pluginid FROM '.$jaktable5.' WHERE hook_name = "tpl_sidebar" AND active = 1 ORDER BY exorder ASC');
		while ($row = $result->fetch_assoc()) {
			$JAK_HOOKS[] = $row;
		}
		
		// Title and Description
		$SECTION_TITLE = $tlf["faq"]["m1"];
		$SECTION_DESC = $tlf["faq"]["t3"];
		
		$plugin_template = 'plugins/faq/admin/template/editfaq.php';
		
		} else {
		   	jak_redirect(BASE_URL.'index.php?p=faq&sp=ene');
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
		 	    $faqarray[] = $row;
		 	}
		 	
		 	$JAK_FAQ_ALL = $faqarray;
		 	
		 	// Call the template
		 	$plugin_template = 'plugins/faq/admin/template/faq.php';
		 		
		break;
		default:
		
			// Hello we have a post request
			if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['jak_delete_faq'])) {
			    $defaults = $_POST;
			    
			    if (isset($defaults['lock'])) {
			    
			    $lockuser = $defaults['jak_delete_faq'];
			
			        for ($i = 0; $i < count($lockuser); $i++) {
			            $locked = $lockuser[$i];
			            
			            $result2 = $jakdb->query('SELECT catid, active FROM '.$jaktable.' WHERE id = "'.smartsql($locked).'"');
						$row2 = $result2->fetch_assoc();
						
						if ($row2['active'] == 1) {
							$result1 = $jakdb->query('UPDATE '.$jaktable1.' SET count = count - 1 WHERE id = "'.smartsql($row2['catid']).'"');
						} else {
							$result1 = $jakdb->query('UPDATE '.$jaktable1.' SET count = count + 1 WHERE id = "'.smartsql($row2['catid']).'"');
						}
			            
			        	$result = $jakdb->query('UPDATE '.$jaktable.' SET active = IF (active = 1, 0, 1) WHERE id = "'.smartsql($locked).'"');
			        	
			        	JAK_tags::jaklocktags($locked,JAK_PLUGIN_FAQ);
			        }
			  
			 	if (!$result) {
					jak_redirect(BASE_URL.'index.php?p=faq&sp=e');
				} else {
			        jak_redirect(BASE_URL.'index.php?p=faq&sp=s');
			    }
			    
			    }
			    
			    if (isset($defaults['delete'])) {
			    
			    $lockuser = $defaults['jak_delete_faq'];
			
			        for ($i = 0; $i < count($lockuser); $i++) {
			            $locked = $lockuser[$i];
			            
			            $result2 = $jakdb->query('SELECT catid FROM '.$jaktable.' WHERE id = "'.smartsql($locked).'"');
						$row2 = $result2->fetch_assoc();
			        	
			        	$result1 = $jakdb->query('UPDATE '.$jaktable1.' SET count = count - 1 WHERE id = "'.smartsql($row2['catid']).'"');
						$result3 = $jakdb->query('DELETE FROM '.$jaktable2.' WHERE faqid = "'.smartsql($locked).'"');
						$result = $jakdb->query('DELETE FROM '.$jaktable.' WHERE id = "'.smartsql($locked).'"');
			        	
			        	JAK_tags::jakDeletetags($locked,JAK_PLUGIN_FAQ);
			        }
			  
			 	if (!$result) {
					jak_redirect(BASE_URL.'index.php?p=faq&sp=e');
				} else {
			        jak_redirect(BASE_URL.'index.php?p=faq&sp=s');
			    }
			    
			    }
			
			 }
			
			// get all faqs out
			$getTotal = jak_get_total($jaktable,'','','');
			
			if ($getTotal != 0) {
				// Paginator
				$pages = new JAK_Paginator;
				$pages->items_total = $getTotal;
				$pages->mid_range = $jkv["adminpagemid"];
				$pages->items_per_page = $jkv["adminpageitem"];
				$pages->jak_get_page = $page1;
				$pages->jak_where = 'index.php?p=faq';
				$pages->paginate();
				$JAK_PAGINATE = $pages->display_pages();
				}
			$JAK_FAQ_ALL = jak_get_faqs($pages->limit, '', $jaktable);
			
			// Title and Description
			$SECTION_TITLE = $tlf["faq"]["m1"];
			$SECTION_DESC = $tlf["faq"]["t"];
			
			// Call the template
			$plugin_template = 'plugins/faq/admin/template/faq.php';
		}
}
?>