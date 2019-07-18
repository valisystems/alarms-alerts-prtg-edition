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
if (!JAK_USERID || !$jakuser->jakModuleaccess(JAK_USERID, JAK_ACCESSECOMMERCE)) jak_redirect(BASE_URL);

// All the tables we need for this plugin
$jaktable = DB_PREFIX.'shop';
$jaktable1 = DB_PREFIX.'shop_order';
$jaktable2 = DB_PREFIX.'pagesgrid';
$jaktable3 = DB_PREFIX.'pluginhooks';
$jaktable4 = DB_PREFIX.'shop_payment';
$jaktable5 = DB_PREFIX.'shop_payment_ipn';
$jaktable7 = DB_PREFIX.'shop_shipping';
$jaktable8 = DB_PREFIX.'shop_order_details';
$jaktable9 = DB_PREFIX.'shopcategories';
$jaktable10 = DB_PREFIX.'shop_coupon';

// Include the functions
include_once("../plugins/ecommerce/admin/include/functions.php");

// Now start with the plugin use a switch to access all pages
switch ($page1) {

	// Create new shop
	case 'new':
		
		// Get the important template stuff
		$JAK_CAT = jak_get_cat_info($jaktable9, 0);
				
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $defaults = $_POST;
		    
		    if (isset($defaults['save'])) {
		
		    if (empty($defaults['jak_title'])) {
		        $errors['e1'] = $tl['error']['e2'];
		    }
		    
		    if ($defaults['jak_price'] == '') {
		        $errors['e3'] = $tlec['shop']['e'];
		    }
		    
		    if (isset($defaults['jak_showdate'])) {
		    	$showdate = $defaults['jak_showdate'];
		    } else {
		    	$showdate = '0';
		    }
		    
		    if (count($errors) == 0) {
		    
		    if (!empty($defaults['jak_img'])) {
		    	$insert .= 'previmg = "'.smartsql($defaults['jak_img']).'",';
		    }
		    
		    if (!empty($defaults['jak_mimg'])) {
		    	$insert .= 'img = "'.smartsql($defaults['jak_mimg']).'",';
		    }
		    
		    if (!empty($defaults['jak_file'])) {
		    	$insert .= 'digital_file = "'.smartsql($defaults['jak_file']).'",';
		    }
		
		$result = $jakdb->query('INSERT INTO '.$jaktable.' SET 
		catid = "'.smartsql($defaults['jak_catid']).'",
		title = "'.smartsql($defaults['jak_title']).'",
		content = "'.smartsql($defaults['jak_content']).'",
		specs = "'.smartsql($defaults['jak_content2']).'",
		showdate = "'.smartsql($showdate).'",
		price = "'.smartsql($defaults['jak_price']).'",
		sale = "'.smartsql($defaults['jak_sale']).'",
		product_weight = "'.smartsql($defaults['jak_weight']).'",
		stock = "'.smartsql($defaults['jak_stock']).'",
		product_options = "'.smartsql($defaults['jak_poption']).'",
		product_options1 = "'.smartsql($defaults['jak_poption1']).'",
		product_options2 = "'.smartsql($defaults['jak_poption2']).'",
		'.$insert.'
		usergroup = "'.smartsql($defaults['jak_usergroup']).'",
		time = NOW()');
		
		$rowid = $jakdb->jak_last_id();
		
		if ($defaults['jak_catid'] != 0) {
		
			$jakdb->query('UPDATE '.$jaktable9.' SET count = count + 1 WHERE id = "'.smartsql($defaults['jak_catid']).'"');			
		}
		
		// Set tag active, well to active
		$tagactive = 1;
		
		if (!$result) {
		    jak_redirect(BASE_URL.'index.php?p=shop&sp=new&ssp=e');
		} else {
			
			// Create Tags if the module is active
			if (!empty($defaults['jak_tags'])) {
						// check if tag does not exist and insert in cloud
				        JAK_tags::jakBuildcloud($defaults['jak_tags'],$rowid,JAK_PLUGIN_ECOMMERCE);
				        // insert tag for normal use
				        JAK_tags::jakInsertags($defaults['jak_tags'],$rowid,JAK_PLUGIN_ECOMMERCE, $tagactive);
				        
			}
		
		    jak_redirect(BASE_URL.'index.php?p=shop&sp=edit&ssp='.$rowid.'&sssp=s');
		 }
		 } else {
		    
		   	$errors['e'] = $tl['error']['e'];
		    $errors = $errors;
		    }
		}
		}
		
		// Get the usergroups
		$JAK_USERGROUP_ALL = jak_get_usergroup_all('usergroup');
		
		// Title and Description
		$SECTION_TITLE = $tlec["shop"]["m4"];
		$SECTION_DESC = $tlec["shop"]["m"];
		
		// Call the template
		$plugin_template = 'plugins/ecommerce/admin/template/newitem.php';
	
	break;
	case 'categories':
	
		// Additional DB field information
		$jakfield = 'catparent';
		$jakfield1 = 'varname';
		 
		 switch ($page2) {
		 	
		    case 'delete':
		
			if (jak_row_exist($page3,$jaktable9) && !jak_field_not_exist($page3,$jaktable9,$jakfield)) {
			
				$result = $jakdb->query('DELETE FROM '.$jaktable9.' WHERE id = "'.smartsql($page3).'"');
		
			if (!$result) {
				jak_redirect(BASE_URL.'index.php?p=shop&sp=categories&ssp=e');
			} else {
			    jak_redirect(BASE_URL.'index.php?p=shop&sp=categories&ssp=s');
			}
		    
			} else {
		   		jak_redirect(BASE_URL.'index.php?p=shop&sp=categories&ssp=eca');
			}
			break;
			case 'lock':
					
					$result = $jakdb->query('UPDATE '.$jaktable9.' SET active = IF (active = 1, 0, 1) WHERE id = "'.smartsql($page3).'"');
				    	
			 	if (!$result) {
			 		jak_redirect(BASE_URL.'index.php?p=shop&sp=categories&ssp=e');
			 	} else {
			 		jak_redirect(BASE_URL.'index.php?p=shop&sp=categories&ssp=s');
			 	}
					
			break;
		    case 'edit':
		
			if (jak_row_exist($page3,$jaktable9)) {
		
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $defaults = $_POST;
		
		    if (empty($defaults['jak_name'])) {
		        $errors['e1'] = $tl['error']['e12'];
		    }
		    
		    if (jak_field_not_exist_id($defaults['jak_varname'], $page3, $jaktable9, $jakfield1)) {
		        $errors['e2'] = $tl['error']['e13'];
		    }
		    
		    if (empty($defaults['jak_varname']) || !preg_match('/^([a-z-_0-9]||[-_])+$/', $defaults['jak_varname'])) {
		        $errors['e3'] = $tl['error']['e14'];
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
		
			$result = $jakdb->query('UPDATE '.$jaktable9.' SET 
			name = "'.smartsql($defaults['jak_name']).'",
			varname = "'.smartsql($defaults['jak_varname']).'",
			'.$insert.'
			permission = "'.smartsql($permission).'"
			WHERE id = "'.smartsql($page3).'"');
		
			if (!$result) {
				jak_redirect(BASE_URL.'index.php?p=shop&sp=categories&ssp=edit&sssp='.$page3.'&ssssp=e');
			} else {
			    jak_redirect(BASE_URL.'index.php?p=shop&sp=categories&ssp=edit&sssp='.$page3.'&ssssp=s');
			}
		 	} else {
		    
		   	$errors['e'] = $tl['error']['e'];
		    $errors = $errors;
		    }
			}
		
			$JAK_FORM_DATA = jak_get_data($page3,$jaktable9);
			$JAK_USERGROUP = jak_get_usergroup_all('usergroup');
			
			// Title and Description
			$SECTION_TITLE = $tlec["shop"]["m"].' - '.$tl["cmenu"]["c6"];
			$SECTION_DESC = $tl["cmdesc"]["d6"];
			
			$plugin_template = 'plugins/ecommerce/admin/template/editshopcat.php';
		
			} else {
		   		jak_redirect(BASE_URL.'index.php?p=shop&sp=categories&ssp=ene');
			}
			break;
			default:
			
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				
					$count = 1;
					
					foreach ($_POST['menuItem'] as $k => $v) {
					
						if (!is_numeric($v)) $v = 0;
						
						$result = $jakdb->query('UPDATE '.$jaktable9.' SET catparent = "'.smartsql($v).'", catorder = "'.smartsql($count).'" WHERE id = "'.smartsql($k).'"');
						
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
				$result = $jakdb->query('SELECT * FROM '.$jaktable9.' ORDER BY catparent, catorder, name');
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
				$SECTION_TITLE = $tlec["shop"]["m"].' - '.$tl["menu"]["m5"];
				$SECTION_DESC = $tl["cmdesc"]["d5"];
				  
				// Call the template
				$plugin_template = 'plugins/ecommerce/admin/template/shopcat.php';
			}
	break;
	// Create new shop categories
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
		    
		    if (jak_field_not_exist($defaults['jak_varname'], $jaktable9, $jakfield)) {
		        $errors['e2'] = $tl['error']['e13'];
		    }
		    
		    if (empty($defaults['jak_varname']) || !preg_match('/^([a-z-_0-9]||[-_])+$/', $defaults['jak_varname'])) {
		        $errors['e3'] = $tl['error']['e14'];
		    }
		        
		    if (count($errors) == 0) {
		    
		    if (!isset($defaults['jak_permission'])) {
		    	$permission = 0;
		    } else {
		    	$permission = join(',', $defaults['jak_permission']);
		    }
		    
		    if (!empty($defaults['jak_img'])) {
		    	$insert = 'catimg = "'.$defaults['jak_img'].'",';
		    }
		    
			$result = $jakdb->query('INSERT INTO '.$jaktable9.' SET 
			name = "'.smartsql($defaults['jak_name']).'",
			varname = "'.smartsql($defaults['jak_varname']).'",
			permission = "'.smartsql($permission).'",
			'.$insert.'
			catparent = 0');
		
			$rowid = $jakdb->jak_last_id();
			
			if (!$result) {
				    jak_redirect(BASE_URL.'index.php?p=shop&sp=newcategory&ssp=e');
			} else {
				    jak_redirect(BASE_URL.'index.php?p=shop&sp=categories&ssp=edit&sssp='.$rowid.'&ssssp=s');
			}
			
		 } else {
		   	$errors['e'] = $tl['error']['e'];
		    $errors = $errors;
		    }
		}
		
		// Title and Description
		$SECTION_TITLE = $tlec["shop"]["m"].' - '.$tl["cmenu"]["c4"];
		$SECTION_DESC = $tl["cmdesc"]["d8"];
		
		// Call the template
		$plugin_template = 'plugins/ecommerce/admin/template/newshopcat.php';
		
	break;
	case 'coupons':
	
		switch ($page2) {
			case 'new':
				
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				    $defaults = $_POST;
				
				    if (empty($defaults['jak_title'])) {
				            $errors['e1'] = $tl['error']['e2'];
				        }
				        
				        if (empty($defaults['jak_code']) || !preg_match('/^([0-9]||[a-z]||[A-Z])+$/', $defaults['jak_code'])) {
				            $errors['e2'] = $tl['error']['e36'];
				        }
				        
				        if (empty($defaults['jak_discount']) || !preg_match('/^([0-9]||[.])+$/', $defaults['jak_discount'])) {
				            $errors['e3'] = $tl['error']['e15'];
				        }
				        
				        if (!isset($defaults['jak_products'])) {
				        	$products = 0;
				       	} elseif (in_array(0, $defaults['jak_products'])) {
				       		$products = 0;
				        } else {
				        	$products = join(',', $defaults['jak_products']);
				        }
				        
				        if (!isset($defaults['jak_permission'])) {
				        	$usergroups = 0;
				        } elseif (in_array(0, $defaults['jak_permission'])) {
				        	$usergroups = 0;
				        } else {
				        	$usergroups = join(',', $defaults['jak_permission']);
				        }
				        
				        if (!empty($defaults['jak_datefrom'])) {
				        	$finalfrom = strtotime($defaults['jak_datefrom']);
				        }
				        
				        if (!empty($defaults['jak_dateto'])) {
				        	$finalto = strtotime($defaults['jak_dateto']);
				        }
				        
				        if ($finalto < $finalfrom) {
				        	$errors['e4'] = $tl['error']['e28'];
				        }
				        	
				        if (!is_numeric($defaults['jak_total'])) {
				            $errors['e5'] = $tl['error']['e15'];
				        }
				        
				        if (!is_numeric($defaults['jak_used'])) {
				            $errors['e6'] = $tl['error']['e15'];
				        }
				        
				        if (count($errors) == 0) {
				        
				    
					    $result = $jakdb->query('INSERT INTO '.$jaktable10.' SET 
					    title = "'.smartsql($defaults['jak_title']).'",
					    description = "'.smartsql($defaults['jak_description']).'",
					    code = "'.smartsql($defaults['jak_code']).'",
					    type = "'.smartsql($defaults['jak_type']).'",
					    discount = "'.smartsql($defaults['jak_discount']).'",
					    freeshipping = "'.smartsql($defaults['jak_freeshipping']).'",
					    datestart = "'.smartsql($finalfrom).'",
					    dateend = "'.smartsql($finalto).'",
					    total = "'.smartsql($defaults['jak_total']).'",
					    used = "'.smartsql($defaults['jak_used']).'",
					    products = "'.smartsql($products).'",
					    usergroup = "'.smartsql($usergroups).'"');
					    
					    $rowid = $jakdb->jak_last_id();
					
						if (!$result) {
							jak_redirect(BASE_URL.'index.php?p=shop&sp=coupons&ssp=new&sssp=e');
						} else {
							jak_redirect(BASE_URL.'index.php?p=shop&sp=coupons&ssp=edit&sssp='.$rowid.'&ssssp=s');
						}
					    
				 	} else {
					   	$errors['e'] = $tl['error']['e'];
					    $errors = $errors;
				    }
				}
				
				$JAK_USERGROUP = jak_get_usergroup_all('usergroup');
				$JAK_PRODUCTS_CHOOSE = jak_get_shop($jaktable, '');
				
				// Title and Description
				$SECTION_TITLE = $tlec["shop"]["m78"];
				$SECTION_DESC = "";
				
				// Call the template
				$plugin_template = 'plugins/ecommerce/admin/template/newcoupon.php';
				
			break;
		 	case 'lock':
		 		
		 		$result = $jakdb->query('UPDATE '.$jaktable10.' SET status = IF (status = 1, 0, 1) WHERE id = "'.smartsql($page3).'"');
		 	    	
			 	if (!$result) {
			 		jak_redirect(BASE_URL.'index.php?p=shop&sp=coupons&ssp=e');
			 	} else {
			 		jak_redirect(BASE_URL.'index.php?p=shop&sp=coupons&ssp=s');
			 	}
		 		
			break;
			case 'delete':
				if (is_numeric($page3) && jak_row_exist($page3,$jaktable10)) {
					$result = $jakdb->query('DELETE FROM '.$jaktable10.' WHERE id = "'.smartsql($page3).'"');
			
				if (!$result) {
					jak_redirect(BASE_URL.'index.php?p=shop&sp=coupons&ssp=e');
				} else {
					jak_redirect(BASE_URL.'index.php?p=shop&sp=coupons&ssp=s');
				}
			    
			} else {
			   	jak_redirect(BASE_URL.'index.php?p=shop&sp=coupons&ssp=ene');
			}
			break;
		case 'edit':
			if (is_numeric($page3) && jak_row_exist($page3,$jaktable10)) {
		
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $defaults = $_POST;
		
		    if (empty($defaults['jak_title'])) {
		        $errors['e1'] = $tl['error']['e2'];
		    }
		    
		    if (empty($defaults['jak_code']) || !preg_match('/^([0-9]||[a-z]||[A-Z])+$/', $defaults['jak_code'])) {
		        $errors['e2'] = $tl['error']['e36'];
		    }
		    
		    if (empty($defaults['jak_discount']) || !preg_match('/^([0-9]||[.])+$/', $defaults['jak_discount'])) {
		        $errors['e3'] = $tl['error']['e15'];
		    }
		    
		    if (!isset($defaults['jak_products'])) {
		    	$products = 0;
		    } elseif (in_array(0, $defaults['jak_products'])) {
		    	$products = 0;
		    } else {
		    	$products = join(',', $defaults['jak_products']);
		    }
		    
		    if (!isset($defaults['jak_permission'])) {
		    	$usergroups = 0;
		    } elseif (in_array(0, $defaults['jak_permission'])) {
		    	$usergroups = 0;
		    } else {
		    	$usergroups = join(',', $defaults['jak_permission']);
		    }
		    
		    if (!empty($defaults['jak_datefrom'])) {
		    	$finalfrom = strtotime($defaults['jak_datefrom']);
		    }
		    
		    if (!empty($defaults['jak_dateto'])) {
		    	$finalto = strtotime($defaults['jak_dateto']);
		    }
		    
		    if ($finalto < $finalfrom) {
		    	$errors['e4'] = $tl['error']['e28'];
		    }
		    	
		    if (!is_numeric($defaults['jak_total'])) {
		        $errors['e5'] = $tl['error']['e15'];
		    }
		    
		    if (!is_numeric($defaults['jak_used'])) {
		        $errors['e6'] = $tl['error']['e15'];
		    }
		    
		    if (count($errors) == 0) {
		
				$result = $jakdb->query('UPDATE '.$jaktable10.' SET 
				title = "'.smartsql($defaults['jak_title']).'",
				description = "'.smartsql($defaults['jak_description']).'",
				code = "'.smartsql($defaults['jak_code']).'",
				type = "'.smartsql($defaults['jak_type']).'",
				discount = "'.smartsql($defaults['jak_discount']).'",
				freeshipping = "'.smartsql($defaults['jak_freeshipping']).'",
				datestart = "'.smartsql($finalfrom).'",
				dateend = "'.smartsql($finalto).'",
				total = "'.smartsql($defaults['jak_total']).'",
				used = "'.smartsql($defaults['jak_used']).'",
				products = "'.smartsql($products).'",
				usergroup = "'.smartsql($usergroups).'"
				WHERE id = "'.smartsql($page3).'"');
			
				if (!$result) {
					jak_redirect(BASE_URL.'index.php?p=shop&sp=coupons&ssp=edit&sssp='.$page3.'&ssssp=e');
				} else {
					jak_redirect(BASE_URL.'index.php?p=shop&sp=coupons&ssp=edit&sssp='.$page3.'&ssssp=s');
				}
			    
		 	} else {
			   	$errors['e'] = $tl['error']['e'];
			    $errors = $errors;
		    }
		}
		
		$JAK_FORM_DATA = jak_get_data($page3, $jaktable10);
		$JAK_USERGROUP = jak_get_usergroup_all('usergroup');
		$JAK_PRODUCTS_CHOOSE = jak_get_shop($jaktable, '');
		
		// Title and Description
		$SECTION_TITLE = $tlec["shop"]["m83"];
		$SECTION_DESC = "";
		
		// Call the template
		$plugin_template = 'plugins/ecommerce/admin/template/editcoupon.php';
		
		} else {
		   	jak_redirect(BASE_URL.'index.php?p=shop&sp=coupons&ssp=ene');
		}
		break;
		default:  
	
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['jak_delete_coupon'])) {
		    $defaults = $_POST;
		    
		    if (isset($defaults['lock'])) {
		    
		    $lockuser = $defaults['jak_delete_coupon'];
		
		        for ($i = 0; $i < count($lockuser); $i++) {
		            $locked = $lockuser[$i];
		            
		        	$result = $jakdb->query('UPDATE '.$jaktable10.' SET status = IF (status = 1, 0, 1) WHERE id = "'.smartsql($locked).'"');
		        }
		  
		 	if (!$result) {
				jak_redirect(BASE_URL.'index.php?p=shop&sp=coupons&ssp=e');
			} else {
		        jak_redirect(BASE_URL.'index.php?p=shop&sp=coupons&ssp=s');
		    }
		    
		    }
		    
		    if (isset($defaults['delete'])) {
		    
		    $lockuser = $defaults['jak_delete_coupon'];
		
		        for ($i = 0; $i < count($lockuser); $i++) {
		            $locked = $lockuser[$i];
					
					$result = $jakdb->query('DELETE FROM '.$jaktable10.' WHERE id = "'.smartsql($locked).'"');
		        	
		        }
		  
		 	if (!$result) {
				jak_redirect(BASE_URL.'index.php?p=shop&sp=coupons&ssp=e');
			} else {
		        jak_redirect(BASE_URL.'index.php?p=shop&sp=coupons&ssp=s');
		    }
		    
		    }
		
		 }
	
		$getTotal = jak_get_total($jaktable10, '', '', '');
		if ($getTotal != 0) {
		// Paginator
			$pages = new JAK_Paginator;
			$pages->items_total = $getTotal;
			$pages->mid_range = $jkv["adminpagemid"];
			$pages->items_per_page = $jkv["adminpageitem"];
			$pages->jak_get_page = $page2;
			$pages->jak_where = 'index.php?p=shop&sp=coupons';
			$pages->paginate();
			$JAK_PAGINATE = $pages->display_pages();
		}
		$JAK_SHOPCOUPON_ALL = jak_get_page_info($jaktable10, $pages->limit);
		
		// Title and Description
		$SECTION_TITLE = $tlec["shop"]["m77"];
		$SECTION_DESC = $tlec["shop"]["m7"];
		
		// Call the template
		$plugin_template = 'plugins/ecommerce/admin/template/coupons.php';
		
		}
	
	break;
	case 'ecpayment':
	
		// Important Smarty Stuff
		$JAK_PAYMENT_ALL = jak_get_payment($jaktable4, '', '');
		
		switch ($page2) {
		 
		case 'lock':
			
			$result = $jakdb->query('UPDATE '.$jaktable4.' SET status = IF (status = 1, 0, 1) WHERE id = "'.smartsql($page3).'"');
		    	
			if (!$result) {
				jak_redirect(BASE_URL.'index.php?p=shop&sp=ecpayment&ssp=e');
			} else {
		    	jak_redirect(BASE_URL.'index.php?p=shop&sp=ecpayment&ssp=s');
			}
			
		break;
		case 'edit';
		
			if (jak_row_exist($page3, $jaktable4)) {
		
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $defaults = $_POST;
		
		    if (empty($defaults['jak_field'])) {
		        $errors['e1'] = $tl['error']['e2'];
		    }
		    
		    if (empty($defaults['jak_lcontent'])) {
		        $errors['e2'] = $tl['error']['e32'];
		    }
		        
		    if (count($errors) == 0) {
		    
		    if (!empty($defaults['jak_field2'])) {
		    	$insert .= 'field2 = "'.smartsql($defaults['jak_field2']).'",';
		    }
		
			$result = $jakdb->query('UPDATE '.$jaktable4.' SET 
			field = "'.smartsql($defaults['jak_field']).'",
			field1 = "'.smartsql($defaults['jak_lcontent']).'",
			'.$insert.'
			fees = "'.smartsql($defaults['jak_fees']).'"
			WHERE id = "'.smartsql($page3).'"');
			
			if (!$result) {
				jak_redirect(BASE_URL.'index.php?p=shop&sp=ecpayment&ssp=edit&sssp='.$page3.'&ssssp=e');
			} else {
				jak_redirect(BASE_URL.'index.php?p=shop&sp=ecpayment&ssp=edit&sssp='.$page3.'&ssssp=s');
			}
			
		 } else {
		    $errors = $errors;
		 }
		}
		
		$JAK_FORM_DATA = jak_get_data($page3, $jaktable4);
		
		$JAK_FORM_DATA["content"] = $JAK_FORM_DATA["field1"];
		
		// Title and Description
		$SECTION_TITLE = $tlec["shop"]["m23"];
		$SECTION_DESC = "";
		
		$plugin_template = 'plugins/ecommerce/admin/template/editpayment.php';
		
		} else {
		   	jak_redirect(BASE_URL.'index.php?p=shop&sp=ecpayment&ssp=ene');
		}
		break;
		default:
		
			// Title and Description
			$SECTION_TITLE = $tlec["shop"]["m2"];
			$SECTION_DESC = "";
			
			// Call the template
			$plugin_template = 'plugins/ecommerce/admin/template/payment.php';
	}	
	break;
	case 'orders':
		
		switch ($page2) {
		
			case 'edit':
			
				if (is_numeric($page3) && jak_row_exist($page3, $jaktable1)) {
				
					if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				    $defaults = $_POST;
				
				    if (empty($defaults['jak_ordernr'])) {
				        $errors['e1'] = $tl['error']['e2'];
				    }
				    
				    if ($defaults['jak_price'] == '') {
				        $errors['e2'] = $tlec['shop']['e'];
				    }
				    
				    if (count($errors) == 0) {
				    
				
					$result = $jakdb->query('UPDATE '.$jaktable1.' SET 
					paid_method = '.$defaults['jak_payment'].',
					total_price = "'.smartsql($defaults['jak_price']).'",
					tax = "'.smartsql($defaults['jak_tax']).'",
					shipping = "'.smartsql($defaults['jak_shipping']).'",
					freeshipping = '.$defaults['jak_freeshipping'].',
					currency = "'.smartsql($defaults['jak_currency']).'",
					userid = "'.smartsql($defaults['jak_userid']).'",
					username = "'.smartsql($defaults['jak_username']).'",
					company = "'.smartsql($defaults['jak_company']).'",
					name = "'.smartsql($defaults['jak_name']).'",
					address = "'.smartsql($defaults['jak_address']).'",
					zip_code = "'.smartsql($defaults['jak_zip']).'",
					city = "'.smartsql($defaults['jak_city']).'",
					country = "'.smartsql($defaults['jak_country']).'",
					phone = "'.smartsql($defaults['jak_phone']).'",
					email = "'.smartsql($defaults['jak_email']).'",
					sh_company = "'.smartsql($defaults['jak_sh_company']).'",
					sh_name = "'.smartsql($defaults['jak_sh_name']).'",
					sh_address = "'.smartsql($defaults['jak_sh_address']).'",
					sh_zip_code = "'.smartsql($defaults['jak_sh_zip']).'",
					sh_city = "'.smartsql($defaults['jak_sh_city']).'",
					sh_country = "'.smartsql($defaults['jak_sh_country']).'",
					sh_phone = "'.smartsql($defaults['jak_sh_phone']).'",
					ordernumber = "'.smartsql($defaults['jak_ordernr']).'"
					WHERE id = "'.smartsql($page3).'"');
				
					if (!$result) {
						jak_redirect(BASE_URL.'index.php?p=shop&sp=orders&ssp=edit&sssp='.$page3.'&ssssp=e');
					} else {
						jak_redirect(BASE_URL.'index.php?p=shop&sp=orders&ssp=edit&sssp='.$page3.'&ssssp=s');
					}
					    
				 } else {
				   	$errors['e'] = $tl['error']['e'];
				    $errors = $errors;
				    }
				}
				
				$JAK_FORM_DATA = jak_get_data($page3, $jaktable1);
				
				$result_option = $jakdb->query('SELECT COUNT(id) AS total_item, title, product_option, price, coupon_price FROM '.$jaktable8.' WHERE orderid = '.$JAK_FORM_DATA['id'].' GROUP BY shopid, product_option ORDER BY price ASC');
				
				while ($row_option = $result_option->fetch_assoc()) {
				
					$row_option['price'] = $row_option['total_item'] * $row_option['price'];
					
					$row_option['price'] = number_format($row_option['price'], 2, '.', '');
					
				    $jak_ordered[] = array('title' => $row_option['title'], 'product_option' => $row_option['product_option'], 'price' => $row_option['price'], 'coupon_price' => number_format($row_option['coupon_price'], 2, '.', ''), 'total_item' => $row_option['total_item']);
				}
				
				// Get the right Country
				$JAK_COUNTRY = getCountry($JAK_FORM_DATA['country'], '');
				$JAK_SHCOUNTRY = getCountry($JAK_FORM_DATA['sh_country'], '');
				
				// Get the payment modules
				$JAK_PAYMENT_ALL = jak_get_payment($jaktable4, '', '');
				
				// Title and Description
				$SECTION_TITLE = $tlec["shop"]["m42"];
				$SECTION_DESC = "";
								
				$plugin_template = 'plugins/ecommerce/admin/template/editorder.php';
				
				} else {
				   	jak_redirect(BASE_URL.'index.php?p=shop&sp=orders&ssp=ene');
				}
			
			break;
		 	case 'paid':
		 		
		 		if (is_numeric($page3) && jak_row_exist($page3, $jaktable1)) {
		 		
		 			if ($page4) {
		 				
		 				$sql = 'UPDATE '.$jaktable1.' SET paid = 0, paidtime = NULL WHERE id = "'.smartsql($page3).'"';
		 			
		 			} else {
		 				
		 				$sql = 'UPDATE '.$jaktable1.' SET paid = 1, paidtime = NOW() WHERE id = "'.smartsql($page3).'"';
		 				
		 			}
		 			
		 		$result = $jakdb->query($sql);
		 	        	
		 		if (!$result) {
		 	    	jak_redirect(BASE_URL.'index.php?p=shop&sp=orders&ssp=e');
		 		} else {
		 	        jak_redirect(BASE_URL.'index.php?p=shop&sp=orders&ssp=s');
		 	    }
		 	    
		 		} else {
		 	   		jak_redirect(BASE_URL.'index.php?p=shop&sp=orders&ssp=ene');
		 		}
		 	
		 break;
		 case 'isbooked':
		 		
		 		if (is_numeric($page3) && jak_row_exist($page3, $jaktable1)) {
		 		
		 		if ($page4) {
		 				
		 			$sql = 'UPDATE '.$jaktable1.' SET order_booked = 0 WHERE id = "'.smartsql($page3).'"';
		 			
		 		} else {
		 			
		 			$sql = 'UPDATE '.$jaktable1.' SET order_booked = 1 WHERE id = "'.smartsql($page3).'"';
		 		
		 		}
		 		
		 		$result = $jakdb->query($sql);
		 	        	
		 		if (!$result) {
		 			jak_redirect(BASE_URL.'index.php?p=shop&sp=orders&ssp=orders-paid&sssp=e');
		 		} else {
		 		    jak_redirect(BASE_URL.'index.php?p=shop&sp=orders&ssp=orders-paid&sssp=s');
		 		}
		 	    
		 		} else {
		 	   		jak_redirect(BASE_URL.'index.php?p=shop&sp=orders&ssp=ene');
		 		}
		 	
		 break;
		 case 'email':
		 	
		 		if (jak_row_exist($page3, $jaktable1)) {
		 			
		 			$result = $jakdb->query('SELECT email, name FROM '.$jaktable1.' WHERE id = '.smartsql($page3));
		 			$row = $result->fetch_assoc();
		 			
		 			$mail = new PHPMailer(); // defaults to using php "mail()"
		 			$body = file_get_contents('../plugins/ecommerce/payment.html');
		 			$body = str_ireplace("[\]",'',$body);
		 			$mail->SetFrom($jkv["email"], $jkv["title"]);
		 			$address = $row['email'];
		 			$mail->AddAddress($address, utf8_decode($row['name']));
		 			$mail->Subject = $jkv["title"].' - '.$tlec['shop']['m38'];
		 			$mail->AltBody = $tlec['shop']['m39'];
		 			$mail->MsgHTML($body);
		 			
		 			if ($mail->Send()) {
		 				jak_redirect(BASE_URL.'index.php?p=shop&sp=orders&ssp=s');
		 			}
		 		} else {
		 		   	jak_redirect(BASE_URL.'index.php?p=shop&sp=orders&ssp=ene');
		 		}
		 		
		break;
		case 'digital':
		
			if (jak_row_exist($page3, $jaktable1)) {
			
				$send_email = 0;
			
				$result = $jakdb->query('SELECT email, name, ordernumber FROM '.$jaktable1.' WHERE id = '.smartsql($page3));
				$row = $result->fetch_assoc();
			
				$result_option = $jakdb->query('SELECT t2.title, t2.digital_file, t2.id FROM '.$jaktable8.' AS t1 LEFT JOIN '.$jaktable.' AS t2 ON (t1.shopid = t2.id) WHERE t1.orderid = "'.smartsql($page3).'" AND t2.digital_file != "" GROUP BY t1.shopid LIMIT 1');
				
				if ($jakdb->affected_rows > 0) {
				
					$row_option = $result_option->fetch_assoc();
				
					$shopid = time();
					
					$jakdb->query('UPDATE '.$jaktable1.' SET 
					downloadid = "'.$shopid.'",
					downloadtime = ADDDATE(NOW(), INTERVAL 7 DAY)
					WHERE id = "'.smartsql($page3).'"');
					
					// Get the current shop url
					$resultc = $jakdb->query('SELECT varname FROM '.DB_PREFIX.'categories WHERE pluginid = '.JAK_PLUGIN_ECOMMERCE);
					$rowc = $resultc->fetch_assoc();
						
					// Create shop link
					$shop_link = '<p>'.$jkv["e_shop_download_b"].' <a href="'.(JAK_USE_APACHE ? substr(BASE_URL_ORIG, 0, -1) : BASE_URL_ORIG).JAK_rewrite::jakParseurl($rowc['varname'], 'dl', $row['ordernumber'], $row_option['id'], $shopid).'">'.$jkv["e_shop_download_bt"].'</a></p>';

					$body = '<body style="margin:10px;">
					<div style="width:750px; font-family: \'Droid Serif\', Helvetica, Arial, sans-serif; font-size: 14px;">
					<div align="center"><img src="'.BASE_URL_ORIG.'plugins/ecommerce/img/header.jpg" style="height: 90px; width: 750px"></div>
					<p>
					'.$jkv["e_shop_download"].'
					</p>
					'.$shop_link.'
					<p>'.$jkv["title"].'</p>
					</div>
					</body>';
					
				    $mail = new PHPMailer(); // defaults to using php "mail()"
				    $body = str_ireplace("[\]",'',$body);
				  	$mail->SetFrom($jkv["email"], $jkv["title"]);
				    $mail->AddAddress($row['email'], $row['name']);
				    $mail->Subject = $jkv["title"].' - '.$tl['shop']['m9'].' - '.$row_option['title'];
				    $mail->AltBody = $tl['shop']['m39'];
				    $mail->MsgHTML($body);
				    $mail->Send(); // Send email without any warnings
				    
				    $send_email = 1;
				    
				}
				
				if ($send_email) {
					jak_redirect(BASE_URL.'index.php?p=shop&sp=orders&ssp=s');
				} else {
					jak_redirect(BASE_URL.'index.php?p=shop&sp=orders&ssp=ene');
				}
			
			} else {
			   	jak_redirect(BASE_URL.'index.php?p=shop&sp=orders&ssp=ene');
			}
		
		break;
		case 'delete':
			
			if (jak_row_exist($page3, $jaktable1)) {
			
		    	$result = $jakdb->query('DELETE FROM '.$jaktable1.' WHERE id = "'.smartsql($page3).'"');
				
				$jakdb->query('DELETE FROM '.$jaktable8.' WHERE orderid = "'.smartsql($page3).'"');
		        	
				if (!$result) {
		    		jak_redirect(BASE_URL.'index.php?p=shop&sp=orders&ssp=e');
				} else {
		        	jak_redirect(BASE_URL.'index.php?p=shop&sp=orders&ssp=s');
		    	}
		    
			} else {
		   		jak_redirect(BASE_URL.'index.php?p=shop&sp=orders&ssp=ene');
			}
		break;
		case 'invoice':
		
			if (is_numeric($page3)) {
			
				$result = $jakdb->query('SELECT * FROM '.$jaktable1.' WHERE id = "'.smartsql($page3).'"');
				$row = $result->fetch_assoc();
				
				$result_option = $jakdb->query('SELECT COUNT(id) AS total_item, title, product_option, price, coupon_price FROM '.$jaktable8.' WHERE orderid = '.$row['id'].' GROUP BY product_option, shopid ORDER BY price ASC');
				
				while ($row_option = $result_option->fetch_assoc()) {
				
					$row_option['price'] = $row_option['total_item'] * $row_option['price'];
					
				    $jak_ordered[] = array('title' => $row_option['title'], 'product_option' => $row_option['product_option'], 'price' => number_format($row_option['price'], 2, '.', ''), 'coupon_price' => number_format($row_option['coupon_price'], 2, '.', ''), 'total_item' => $row_option['total_item']);
				}
				
				// Get the right Country
				$JAK_COUNTRY = getCountry('', $row['country']);
				$JAK_SHCOUNTRY = getCountry('', $row['sh_country']);
		
				// Call the template
				$plugin_template = 'plugins/ecommerce/admin/template/invoice.php';
			
			} else {
				jak_redirect(BASE_URL.'index.php?p=shop&sp=orders&ssp=ene');
			}
		
		break;
		case 'booked':
		
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			    $defaults = $_POST;
			    
			    if (isset($defaults['delete'])) {
			    
			    	$lockuser = $defaults['jak_delete_order'];
			
			        for ($i = 0; $i < count($lockuser); $i++) {
			            $locked = $lockuser[$i];
			            $result = $jakdb->query('DELETE FROM '.$jaktable1.' WHERE id = "'.smartsql($locked).'"');
			        	
			        }
			  
				 	if (!$result) {
						jak_redirect(BASE_URL.'index.php?p=shop&sp=orders&ssp=booked&sssp=e');
					} else {
				        jak_redirect(BASE_URL.'index.php?p=shop&sp=orders&ssp=booked&sssp=s');
				    }
			    
			    }
			    
			    if (isset($defaults['allbooked'])) {
			        
			        $lockuser = $defaults['jak_delete_order'];
			    
			            for ($i = 0; $i < count($lockuser); $i++) {
			                $locked = $lockuser[$i];
			                
			                $result = $jakdb->query('UPDATE '.$jaktable1.' SET order_booked = IF (order_booked = 1, 0, 1) WHERE id = "'.smartsql($locked).'"');
			            	
			            }
			      
			     	if (!$result) {
			    		jak_redirect(BASE_URL.'index.php?p=shop&sp=orders&ssp=booked&sssp=e');
			    	} else {
			            jak_redirect(BASE_URL.'index.php?p=shop&sp=orders&ssp=booked&sssp=s');
			        }
			        
			   	}
			    
			    if (isset($defaults['search'])) {
			    
			        if (strlen($defaults['jakSH']) < '1') {
			            $errors['e1'] = $tlec['shop']['s1'];
			        }
			    
			        if (count($errors) > 0) {
			        
			        	$errors['e'] = $tlec['shop']['s2'].'<br />';
			            
			        } else {
			        
			            $secureIn = smartsql($defaults['jakSH']);
			            $SEARCH_WORD = $secureIn;
			            $JAK_ORDERS = jak_shop_search($secureIn);
			            
			        }
			        }
			
			 } else {
			
			$getTotal = jak_get_total($jaktable1, 1, 'order_booked', 'paid');
			
			if ($getTotal != 0) {
				// Paginator
				$pages = new JAK_Paginator;
				$pages->items_total = $getTotal;
				$pages->mid_range = $jkv["adminpagemid"];
				$pages->items_per_page = $jkv["adminpageitem"];
				$pages->jak_get_page = $page3;
				$pages->jak_where = 'index.php?p=shop&sp=orders&ssp=booked';
				$pages->paginate();
				
				$JAK_PAGINATE = $pages->display_pages();
			}
			
			$JAK_ORDERS = jak_get_shop_orders($pages->limit, 1, 'order_booked', 1);
			
			}
			
			// Get the shop statistic
			$resultst1 = $jakdb->query('SELECT MONTHNAME(paidtime) AS mtime, MONTH(paidtime) AS ptime, YEAR(paidtime) AS ytime FROM '.$jaktable1.' WHERE paid = 1 GROUP BY mtime, ytime ORDER BY id DESC LIMIT 12');
			if ($jakdb->affected_rows > 0) {
			while ($rowst1 = $resultst1->fetch_assoc()) {
			        
			        // get the days in one table
			        $arraymonth[] = $rowst1['mtime'].' '.$rowst1['ytime'];
			        $arraymonthnumber[] = $rowst1['ptime'].$rowst1['ytime'];
			    }
			    
			    $arraymonth = array_unique($arraymonth);
			    $arraymonthnumber = array_unique($arraymonthnumber);
			}
			
			// Get the feedback statistic
			$resultst12 = $jakdb->query('SELECT SUM(total_price) AS earning, MONTH(paidtime) AS ptime, YEAR(paidtime) AS ytime FROM '.$jaktable1.' WHERE paid = 1 AND currency = "'.smartsql($jkv["e_currency"]).'" GROUP BY ptime, ytime ORDER BY id DESC LIMIT 12');
			if ($jakdb->affected_rows > 0) {
			while ($rowst12 = $resultst12->fetch_assoc()) { 
			        
			        // get the days in one table
			        $fostat2p[] = $rowst12['ptime'].$rowst12['ytime'];
			        $fostat2[] = $rowst12['earning'];
			    }
			    
			    $fostat2 = array_combine($fostat2p,$fostat2);
			}
			
			if ($jkv["e_currency1"]) {
				
				// Currency Two
				$currency_two = explode('/', $jkv["e_currency1"]);
				
				// Get the feedback statistic
				$resultst13 = $jakdb->query('SELECT SUM(total_price) AS earning, MONTH(paidtime) AS ptime, YEAR(paidtime) AS ytime FROM '.$jaktable1.' WHERE paid = 1 AND currency = "'.smartsql($currency_two[0]).'" GROUP BY ptime, ytime ORDER BY id DESC LIMIT 12');
				if ($jakdb->affected_rows > 0) {
				while ($rowst13 = $resultst13->fetch_assoc()) {
				        
				        // get the days in one table
				        $fostat21p[] = $rowst13['ptime'].$rowst13['ytime'];
				        $fostat21[] = $rowst13['earning'];
				    }
				    
				    $fostat21 = array_combine($fostat21p,$fostat21);
				}
			}
			
			// Create a array with all three currency
			if ($jkv["e_currency2"]) {	
					
				// Currency Three
				$currency_three = explode('/', $jkv["e_currency2"]);
				
				// Get the feedback statistic
				$resultst14 = $jakdb->query('SELECT SUM(total_price) AS earning, MONTH(paidtime) AS ptime, YEAR(paidtime) AS ytime FROM '.$jaktable1.' WHERE paid = 1 AND currency = "'.smartsql($currency_three[0]).'" GROUP BY ptime, ytime ORDER BY id DESC LIMIT 12');
				if ($jakdb->affected_rows > 0) {
				while ($rowst14 = $resultst14->fetch_assoc()) { 
				        
				        // get the days in one table
				        $fostat22p[] = $rowst14['ptime'].$rowst14['ytime'];
				        $fostat22[] = $rowst14['earning'];
				    }
				    
				    $fostat22 = array_combine($fostat22p,$fostat22);
				}
				
			}
			
			$fostat2f = $fostat21f = $fostat22f = array();
			$stat2total = $stat3total = '';
			
			// Sanitize the data
			if (!empty($arraymonth) && !empty($arraymonthnumber)) {
				
				foreach ($arraymonthnumber as $m) {	
					
					if (array_key_exists($m, $fostat2)) {
						
						$fostat2f[] = $fostat2[$m];
						
					} else {
					
						$fostat2f[] = '0';
					}
				
				}
			
				// Total
				$stat1total = join(", ", $fostat2f);
				// Month
				$stat1month = join("', '", $arraymonth);
				
				if (!empty($fostat21) && is_array($fostat21)) {
				
					foreach ($arraymonthnumber as $m) {	
						
						if (array_key_exists($m, $fostat21)) {
							
							$fostat21f[] = $fostat21[$m];
							
						} else {
						
							$fostat21f[] = '0';
						}
					
					}
				
					$stat2total = join(", ", $fostat21f);
					
				}
				
				if (!empty($fostat22) && is_array($fostat22)) {
				
					foreach ($arraymonthnumber as $m) {	
						
						if (array_key_exists($m, $fostat22)) {
							
							$fostat22f[] = $fostat22[$m];
							
						} else {
						
							$fostat22f[] = '0';
						}
					
					}
					
					$stat3total = join(", ", $fostat22f);
					
				}
			}
			
			// Title and Description
			$SECTION_TITLE = $tlec["shop"]["m59"];
			$SECTION_DESC = "";
			
			// Call the template
			$plugin_template = 'plugins/ecommerce/admin/template/orders.php';
		
		break;
		case 'orders-paid':
		
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			    $defaults = $_POST;
			    
			    if (isset($defaults['delete'])) {
			    
			    	$lockuser = $defaults['jak_delete_order'];
			
			        for ($i = 0; $i < count($lockuser); $i++) {
			            $locked = $lockuser[$i];
			            $result = $jakdb->query('DELETE FROM '.$jaktable1.' WHERE id = "'.smartsql($locked).'"');
			        }
			  
				 	if (!$result) {
						jak_redirect(BASE_URL.'index.php?p=shop&sp=orders&ssp=orders-paid&sssp=e');
					} else {
				        jak_redirect(BASE_URL.'index.php?p=shop&sp=orders&ssp=orders-paid&sssp=s');
				    }
			    
			    }
			    
				if (isset($defaults['allbooked'])) {
			    
			    	$lockuser = $defaults['jak_delete_order'];
			
			        for ($i = 0; $i < count($lockuser); $i++) {
			            $locked = $lockuser[$i];
			            
			            $result = $jakdb->query('UPDATE '.$jaktable1.' SET order_booked = IF (order_booked = 1, 0, 1) WHERE id = "'.smartsql($locked).'"');
			        	
			        }
			  
				 	if (!$result) {
						jak_redirect(BASE_URL.'index.php?p=shop&sp=orders&ssp=orders-paid&sssp=e');
					} else {
				        jak_redirect(BASE_URL.'index.php?p=shop&sp=orders&ssp=orders-paid&sssp=s');
				    }
			    
			    }
			    
			    if (isset($defaults['search'])) {
			    
			        if (strlen($defaults['jakSH']) < '1') {
			            $errors['e1'] = $tlec['shop']['s1'];
			        }
			    
			        if (count($errors) > 0) {
			        
			        	$errors['e'] = $tlec['shop']['s2'].'<br />';
			            
			        } else {
			        
			            $secureIn = smartsql($defaults['jakSH']);
			            $SEARCH_WORD = $secureIn;
			            $JAK_ORDERS = jak_shop_search($secureIn);
			            
			        }
			        }
			
			 } else {
			
			$result = $jakdb->query('SELECT COUNT(*) as totalAll FROM '.$jaktable1.' WHERE order_booked = 0 AND paid = 1');
			$row = $result->fetch_assoc();
			
			if ($row['totalAll'] != 0) {
				// Paginator
				$pages = new JAK_Paginator;
				$pages->items_total = $row['totalAll'];
				$pages->mid_range = $jkv["adminpagemid"];
				$pages->items_per_page = $jkv["adminpageitem"];
				$pages->jak_get_page = $page3;
				$pages->jak_where = 'index.php?p=shop&sp=orders&ssp=orders-paid';
				$pages->paginate();
				
				$JAK_PAGINATE = $pages->display_pages();
			}
			
			$JAK_ORDERS = jak_get_shop_orders($pages->limit, 0, 'order_booked', 1);
			
			}
			
			// Title and Description
			$SECTION_TITLE = $tlec["shop"]["m67"];
			$SECTION_DESC = "";
			
			// Call the template
			$plugin_template = 'plugins/ecommerce/admin/template/orders.php';
		
		break;
		default:
		
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			    $defaults = $_POST;
			    
			    if (isset($defaults['delete'])) {
			    
			    $lockuser = $defaults['jak_delete_order'];
			
			        for ($i = 0; $i < count($lockuser); $i++) {
			            $locked = $lockuser[$i];
			            
			            $sql = 'DELETE FROM '.$jaktable1.' WHERE id = "'.smartsql($locked).'"';
						$result = $jakdb->query($sql);
			        	
			        }
			  
			 	if (!$result) {
					jak_redirect(BASE_URL.'index.php?p=shop&sp=orders&ssp=e');
				} else {
			        jak_redirect(BASE_URL.'index.php?p=shop&sp=orders&ssp=s');
			    }
			    
			    }
			    
			    if (isset($defaults['allbooked'])) {
			        
			        $lockuser = $defaults['jak_delete_order'];
			    
			            for ($i = 0; $i < count($lockuser); $i++) {
			                $locked = $lockuser[$i];
			                
			                $result = $jakdb->query('UPDATE '.$jaktable1.' SET order_booked = IF (order_booked = 1, 0, 1) WHERE id = "'.smartsql($locked).'"');
			            	
			            }
			      
			     	if (!$result) {
			    		jak_redirect(BASE_URL.'index.php?p=shop&sp=orders&ssp=e');
			    	} else {
			            jak_redirect(BASE_URL.'index.php?p=shop&sp=orders&ssp=s');
			        }
			        
			        }
			    
			    if (isset($defaults['search'])) {
			    
			        if (strlen($defaults['jakSH']) < '1') {
			            $errors['e1'] = $tlec['shop']['s1'];
			        }
			    
			        if (count($errors) > 0) {
			        
			        	$errors['e'] = $tlec['shop']['s2'].'<br />';
			            
			        } else {
			        
			            $secureIn = smartsql($defaults['jakSH']);
			            $SEARCH_WORD = $secureIn;
			            $JAK_ORDERS = jak_shop_search($secureIn);
			            
			        }
			        }
			
			 } else {
			
			$result = $jakdb->query('SELECT COUNT(*) as totalAll FROM '.$jaktable1.' WHERE order_booked = 0 AND paid = 0');
			$row = $result->fetch_assoc();
			
			if ($row['totalAll'] != 0) {
				// Paginator
				$pages = new JAK_Paginator;
				$pages->items_total = $row['totalAll'];
				$pages->mid_range = $jkv["adminpagemid"];
				$pages->items_per_page = $jkv["adminpageitem"];
				$pages->jak_get_page = $page2;
				$pages->jak_where = 'index.php?p=shop&sp=orders';
				$pages->paginate();
				
				$JAK_PAGINATE = $pages->display_pages();
			}
			
			$JAK_ORDERS = jak_get_shop_orders($pages->limit, 0, 'order_booked', 0);
			
			}
			
			// Title and Description
			$SECTION_TITLE = $tlec["shop"]["m31"];
			$SECTION_DESC = "";
			
			// Call the template
			$plugin_template = 'plugins/ecommerce/admin/template/orders.php';
		
		}
		
	break;
	case 'ecshipping':
		
		switch ($page2) {
		
			case 'new':
			
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				    $defaults = $_POST;
				
				    if (empty($defaults['jak_title'])) {
				        $errors['e1'] = $tl['error']['e2'];
				    }
				    
				    if ($defaults['jak_price'] == '') {
				        $errors['e2'] = $tlec['shop']['e'].'<br />';
				    }
				    
				    if (empty($defaults['jak_country'])) {
				        $errors['e3'] = $tlec['shop']['e1'];
				    }
				    
				    if (count($errors) == 0) {
				    
				    if (!empty($defaults['jak_img'])) {
				    	$insert .= 'deliveryimg = "'.smartsql($defaults['jak_img']).'",';
				    }
				
					$result = $jakdb->query('INSERT INTO '.$jaktable7.' SET 
					title = "'.smartsql($defaults['jak_title']).'",
					country = "'.smartsql($defaults['jak_country']).'",
					est_shipping = "'.smartsql($defaults['jak_estship']).'",
					price = "'.smartsql($defaults['jak_price']).'",
					handling = "'.smartsql($defaults['jak_handling']).'",
					weightfrom = "'.smartsql($defaults['jak_weight']).'",
					weightto = "'.smartsql($defaults['jak_weightto']).'",
					'.$insert.'
					time = NOW()');
					
					$rowid = $jakdb->jak_last_id();
					
					if (!$result) {
						jak_redirect(BASE_URL.'index.php?p=shop&sp=ecshipping&ssp=new&sssp=e');
					} else {
						jak_redirect(BASE_URL.'index.php?p=shop&sp=ecshipping&ssp=edit&sssp='.$rowid.'&ssssp=s');
					}
					    
				 } else {
				   	$errors['e'] = $tl['error']['e'];
				    $errors = $errors;
				    }
				}
				
				// Get the country list
				$JAK_COUNTRY = getCountry($jkv["e_country"], '');
				
				// Title and Description
				$SECTION_TITLE = $tlec["shop"]["m47"];
				$SECTION_DESC = "";
				
				$plugin_template = 'plugins/ecommerce/admin/template/newshipment.php';
			
			break;
			case 'edit':
			
				if (is_numeric($page3) && jak_row_exist($page3, $jaktable7)) {
				
					if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				    $defaults = $_POST;
				
				    if (empty($defaults['jak_title'])) {
				        $errors['e1'] = $tl['error']['e2'];
				    }
				    
				    if ($defaults['jak_price'] == '') {
				        $errors['e2'] = $tlec['shop']['e'];
				    }
				    
				    if (empty($defaults['jak_country'])) {
				        $errors['e3'] = $tlec['shop']['e1'];
				    }
				    
				    if (count($errors) == 0) {
				    
				    if (!empty($defaults['jak_img'])) {
				    	$insert .= 'deliveryimg = "'.smartsql($defaults['jak_img']).'",';
				    } else {
				    	$insert .= 'deliveryimg = NULL,';
				    }
				
					$result = $jakdb->query('UPDATE '.$jaktable7.' SET 
					title = "'.smartsql($defaults['jak_title']).'",
					country = "'.smartsql($defaults['jak_country']).'",
					est_shipping = "'.smartsql($defaults['jak_estship']).'",
					price = "'.smartsql($defaults['jak_price']).'",
					handling = "'.smartsql($defaults['jak_handling']).'",
					weightfrom = "'.smartsql($defaults['jak_weight']).'",
					weightto = "'.smartsql($defaults['jak_weightto']).'",
					'.$insert.'
					time = NOW()
					WHERE id = "'.smartsql($page3).'"');
					
					if (!$result) {
						jak_redirect(BASE_URL.'index.php?p=shop&sp=ecshipping&ssp=edit&sssp='.$page3.'&ssssp=e');
					} else {
						jak_redirect(BASE_URL.'index.php?p=shop&sp=ecshipping&ssp=edit&sssp='.$page3.'&ssssp=s');
					}
					    
				 } else {
				    
				   	$errors['e'] = $tl['error']['e'];
				    $errors = $errors;
				    }
				}
				
				$JAK_FORM_DATA = jak_get_data($page3, $jaktable7);
				
				// Get the country list
				$JAK_COUNTRY = getCountry($JAK_FORM_DATA['country'], '');
				
				// Title and Description
				$SECTION_TITLE = $tlec["shop"]["m48"];
				$SECTION_DESC = "";
								
				$plugin_template = 'plugins/ecommerce/admin/template/editshipment.php';
				
				} else {
				    
				   	jak_redirect(BASE_URL.'index.php?p=shop&sp=ecshipping&ssp=ene');
				}
			
		break;
		case 'lock';
		
			if (is_numeric($page3) && jak_row_exist($page3, $jaktable7)) {
		
			$result = $jakdb->query('UPDATE '.$jaktable7.' SET status = IF (status = 1, 0, 1) WHERE id = "'.smartsql($page3).'"');
			    	
			if (!$result) {
				jak_redirect(BASE_URL.'index.php?p=shop&sp=ecshipping&ssp=e');
			} else {
			    jak_redirect(BASE_URL.'index.php?p=shop&sp=ecshipping&ssp=s');
			}
			
			} else {
			   	jak_redirect(BASE_URL.'index.php?p=shop&sp=ecshipping&ssp=ene');
			}
		
		break;
		case 'delete';
		
			if (is_numeric($page3) && jak_row_exist($page3, $jaktable7)) {
		
			$result = $jakdb->query('DELETE FROM '.$jaktable7.' WHERE id = "'.smartsql($page3).'"');
			    	
			if (!$result) {
				jak_redirect(BASE_URL.'index.php?p=shop&sp=ecshipping&ssp=e');
			} else {
			    jak_redirect(BASE_URL.'index.php?p=shop&sp=ecshipping&ssp=s');
			}
			
			} else {
			   	jak_redirect(BASE_URL.'index.php?p=shop&sp=ecshipping&ssp=ene');
			}
		
		break;
		default:
			
			// Get all shippings
			$sql = 'SELECT t1.id, t1.title, t1.price, t1.time, t2.name, t1.status FROM '.$jaktable7.' AS t1 LEFT JOIN '.DB_PREFIX.'shop_country AS t2 ON (t1.country = t2.id) ORDER BY t1.title ASC';
			$result = $jakdb->query($sql);
			while ($row = $result->fetch_assoc()) {
			        // collect each record into $_data
			        $JAK_SHIPPING[] = $row;
			    }
			
			// Title and Description
			$SECTION_TITLE = $tlec["shop"]["m48"];
			$SECTION_DESC = "";
			
			// Call the template
			$plugin_template = 'plugins/ecommerce/admin/template/shipment.php';
		
		}
		
	break;
	case 'ecsetting':
	
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $defaults = $_POST;
		
		if (empty($defaults['jak_date'])) {
		    $errors['e3'] = $tl['error']['e4'];
		}
		
		if (!is_numeric($defaults['jak_rssitem'])) {
		    $errors['e7'] = $tl['error']['e15'];
		}
		
		if (count($errors) == 0) {
	
		$result = $jakdb->query('UPDATE '.DB_PREFIX.'setting SET value = CASE varname
		    WHEN "e_title" THEN "'.smartsql($defaults['jak_title']).'"
		    WHEN "e_desc" THEN "'.smartsql($defaults['jak_lcontent']).'"
		    WHEN "e_thanks" THEN "'.smartsql($defaults['jak_thankyou']).'"
		    WHEN "shopemail" THEN "'.smartsql($defaults['jak_email']).'"
		    WHEN "shopdateformat" THEN "'.smartsql($defaults['jak_date']).'"
		    WHEN "shoptimeformat" THEN "'.smartsql($defaults['jak_time']).'"
		    WHEN "shopurl" THEN "'.smartsql($defaults['jak_shopurl']).'"
		    WHEN "e_productopen" THEN "'.smartsql($defaults['jak_itemopen']).'"
		    WHEN "e_agreement" THEN "'.smartsql($defaults['jak_wcatid']).'"
		    WHEN "shopcheckout" THEN "'.smartsql($defaults['jak_checkout']).'"
		    WHEN "shoprss" THEN "'.smartsql($defaults['jak_rssitem']).'"
		    WHEN "e_currency" THEN "'.smartsql($defaults['jak_currency']).'"
		    WHEN "e_currency1" THEN "'.smartsql($defaults['jak_currency1']).'"
		    WHEN "e_currency2" THEN "'.smartsql($defaults['jak_currency2']).'"
		    WHEN "e_shop_download" THEN "'.smartsql($defaults['jak_download']).'"
		    WHEN "e_shop_download_b" THEN "'.smartsql($defaults['jak_download_b']).'"
		    WHEN "e_shop_download_bt" THEN "'.smartsql($defaults['jak_download_bt']).'"
		    WHEN "e_taxes" THEN "'.smartsql($defaults['jak_taxes']).'"
		    WHEN "shoppagemid" THEN "'.smartsql($defaults['jak_mid']).'"
		    WHEN "shoppageitem" THEN "'.smartsql($defaults['jak_item']).'"
		    WHEN "e_shop_address" THEN "'.smartsql($defaults['jak_address']).'"
		    WHEN "e_country" THEN "'.smartsql($defaults['jak_country']).'"
		END
			WHERE varname IN ("e_title", "e_desc", "e_thanks", "shopemail", "shopdateformat", "shoptimeformat", "shopurl", "e_productopen", "e_agreement", "shopcheckout", "shoprss", "e_currency", "e_currency1", "e_currency2", "e_shop_download", "e_shop_download_b", "e_shop_download_bt", "e_taxes", "shoppagemid", "shoppageitem", "e_shop_address", "e_country")');
		
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
			
					$jakdb->query('INSERT INTO '.$jaktable2.' SET plugin = "'.smartsql(JAK_PLUGIN_ECOMMERCE).'", hookid = "'.smartsql($key).'", pluginid = "'.smartsql($pdoith[$key]).'", whatid = "'.smartsql($whatid).'", orderid = "'.smartsql($exorder).'"');
				
				}
			
			}
		
		}
		
		// Now check if all the sidebar a deselct and hooks exist, if so delete all associated to this page
		$row = $jakdb->queryRow('SELECT id FROM '.$jaktable2.' WHERE plugin = "'.smartsql(JAK_PLUGIN_ECOMMERCE).'" AND hookid != 0');
		
		if (isset($defaults['jak_hookshow_new']) && !is_array($defaults['jak_hookshow_new']) && $row['id'] && !is_array($defaults['jak_hookshow'])) {
		
			$jakdb->query('DELETE FROM '.$jaktable2.' WHERE plugin = "'.smartsql(JAK_PLUGIN_ECOMMERCE).'" AND shopid = 0 AND hookid != 0');
		
		}
			
		// Save order or delete for extra sidebar widget
		if (isset($defaults['jak_hookshow']) && is_array($defaults['jak_hookshow'])) {
		
			$exorder = $defaults['horder'];
			$hookid = $defaults['real_hook_id'];
			$hookrealid = implode(',', $defaults['real_hook_id']);
			$doith = array_combine($hookid, $exorder);
			
			foreach ($doith as $key => $exorder) {
				
				// Get the real what id
				$row = $jakdb->queryRow('SELECT pluginid FROM '.$jaktable2.' WHERE id = "'.smartsql($key).'" AND hookid != 0');
					
				$whatid = 0;
				if (isset($defaults['whatid_'.$row["pluginid"]])) $whatid = $defaults['whatid_'.$row["pluginid"]];
					
					if (in_array($key, $defaults['jak_hookshow'])) {
						$updatesql .= sprintf("WHEN %d THEN %d ", $key, $exorder);
						$updatesql1 .= sprintf("WHEN %d THEN %d ", $key, $whatid);
						
					} else {
						$jakdb->query('DELETE FROM '.$jaktable2.' WHERE id = "'.smartsql($key).'"');
					}
				}
				
				$jakdb->query('UPDATE '.$jaktable2.' SET orderid = CASE id
				'.$updatesql.'
				END
				WHERE id IN ('.$hookrealid.')');
				
				$jakdb->query('UPDATE '.$jaktable2.' SET whatid = CASE id
				'.$updatesql1.'
				END
				WHERE id IN ('.$hookrealid.')');
		
		} else {
			$jakdb->query('DELETE FROM '.$jaktable2.' WHERE plugin = "'.smartsql(JAK_PLUGIN_ECOMMERCE).'" AND shopid = 0 AND hookid != 0');
		}
		
		if (!$result) {
			jak_redirect(BASE_URL.'index.php?p=shop&sp=ecsetting&ssp=e');
		} else {		
		    jak_redirect(BASE_URL.'index.php?p=shop&sp=ecsetting&ssp=s');
		}
		
		} else {
		
			$errors['e'] = $tl['error']['e'];
			$errors = $errors;
		}
		
		}
		
		// Get the sort orders for the grid
		$grid = $jakdb->query('SELECT id, hookid, whatid, orderid FROM '.$jaktable2.' WHERE plugin = "'.smartsql(JAK_PLUGIN_ECOMMERCE).'" ORDER BY orderid ASC');
		while ($grow = $grid->fetch_assoc()) {
		        // collect each record into $_data
		        $JAK_PAGE_GRID[] = $grow;
		}
		
		// Get the sidebar templates
		$result = $jakdb->query('SELECT id, name, widgetcode, exorder, pluginid FROM '.$jaktable3.' WHERE hook_name = "tpl_sidebar" AND active = 1 ORDER BY exorder ASC');
		while ($row = $result->fetch_assoc()) {
			$JAK_HOOKS[] = $row;
		}
		
		$JAK_USERGROUP_ALL = jak_get_usergroup_all('usergroup');
		$JAK_SETTING = jak_get_setting('shop');
		$JAK_CAT = jak_get_cat_info(DB_PREFIX.'categories', 0);
		$JAK_COUNTRY = getCountry($jkv["e_country"], '');
		
		// Get the special vars for multi language support
		$JAK_FORM_DATA["title"] = $jkv["e_title"];
		$JAK_FORM_DATA["content"] = $jkv["e_desc"];
		
		// Title and Description
		$SECTION_TITLE = $tlec["shop"]["m"];
		$SECTION_DESC = $tl["cmdesc"]["d2"];
		
		// Call the template
		$plugin_template = 'plugins/ecommerce/admin/template/ecsettings.php';
	
	break;
	default:
	
		switch ($page1) {
		
			case 'edit':
			
				if (is_numeric($page2) && jak_row_exist($page2,$jaktable)) {
				
					if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				    $defaults = $_POST;
				
				    if (empty($defaults['jak_title'])) {
				        $errors['e1'] = $tl['error']['e2'];
				    }
				    
				    if ($defaults['jak_price'] == '') {
				        $errors['e2'] = $tlec['shop']['e'];
				    }
				    
				    if (count($errors) == 0) {
				    
				    // Delete the tags
				        if (!empty($defaults['jak_tagdelete'])) {
				        $tags = $defaults['jak_tagdelete'];
				    
				            for ($i = 0; $i < count($tags); $i++) {
				                $tag = $tags[$i];
				                
				                JAK_tags::jakDeleteonetag($tag);
				                
				            }
				        }
				    
				    if (!empty($defaults['jak_update_time'])) {
				    	$insert .= 'time = NOW(),';
				    }
				    
				    // Delete the hits
				    if (!empty($defaults['jak_delete_hits'])) {
				    	$jakdb->query('UPDATE '.$jaktable.' SET hits = 1 WHERE id = "'.smartsql($page2).'"');
				    }
				    
				    if (!empty($defaults['jak_img'])) {
				    	$insert .= 'previmg = "'.smartsql($defaults['jak_img']).'",';
				    } else {
				    	$insert .= 'previmg = NULL,';
				    }
				    
				    if (!empty($defaults['jak_mimg'])) {
				    	$insert .= 'img = "'.smartsql($defaults['jak_mimg']).'",';
				    } else {
				    	$insert .= 'img = NULL,';
				    }
				    
				    if (!empty($defaults['jak_file'])) {
				    	$insert .= 'digital_file = "'.smartsql($defaults['jak_file']).'",';
				    } else {
				    	$insert .= 'digital_file = NULL,';
				    }
				
				$result = $jakdb->query('UPDATE '.$jaktable.' SET 
				catid = "'.$defaults['jak_catid'].'",
				title = "'.smartsql($defaults['jak_title']).'",
				content = "'.smartsql($defaults['jak_content']).'",
				specs = "'.smartsql($defaults['jak_content2']).'",
				showdate = "'.smartsql($defaults['jak_showdate']).'",
				price = "'.smartsql($defaults['jak_price']).'",
				sale = "'.smartsql($defaults['jak_sale']).'",
				product_weight = "'.smartsql($defaults['jak_weight']).'",
				stock = "'.smartsql($defaults['jak_stock']).'",
				'.$insert.'
				usergroup = "'.smartsql($defaults['jak_usergroup']).'",
				product_options = "'.smartsql($defaults['jak_poption']).'",
				product_options1 = "'.smartsql($defaults['jak_poption1']).'",
				product_options2 = "'.smartsql($defaults['jak_poption2']).'"
				WHERE id = "'.smartsql($page2).'"');
				
				// Category
				if ($defaults['jak_catid'] != 0 || $defaults['jak_catid'] != $defaults['jak_oldcatid']) {
					$jakdb->query('UPDATE '.$jaktable9.' SET count = count - 1 WHERE id = "'.smartsql($defaults['jak_oldcatid']).'"');
					$jakdb->query('UPDATE '.$jaktable9.' SET count = count + 1 WHERE id = "'.smartsql($defaults['jak_catid']).'"');
				}
				
				// Set tag active, well to active
				$tagactive = 1;
				
					if (!$result) {
				    	jak_redirect(BASE_URL.'index.php?p=shop&sp=&sp=edit&ssp='.$page2.'&sssp=e');
					} else {
					
						// Create Tags if the module is active
						if (!empty($defaults['jak_tags'])) {
							// check if tag does not exist and insert in cloud
							JAK_tags::jakBuildcloud($defaults['jak_tags'],smartsql($page2),JAK_PLUGIN_ECOMMERCE);
							// insert tag for normal use
							JAK_tags::jakInsertags($defaults['jak_tags'],smartsql($page2),JAK_PLUGIN_ECOMMERCE, $tagactive);
						}
						
				        jak_redirect(BASE_URL.'index.php?p=shop&sp=&sp=edit&ssp='.$page2.'&sssp=s');
				    }
					    
				 } else {
				    
				   	$errors['e'] = $tl['error']['e'];
				    $errors = $errors;
				    }
				}
				
				$JAK_FORM_DATA = jak_get_data($page2, $jaktable);
				$JAK_CAT = jak_get_cat_info($jaktable9, 0);
				
				if (JAK_TAGS) {
					$JAK_TAGLIST = jak_get_tags($page2, JAK_PLUGIN_ECOMMERCE);
				}
				
				// Get the usergroups
				$JAK_USERGROUP_ALL = jak_get_usergroup_all('usergroup');
				
				// Title and Description
				$SECTION_TITLE = $tlec["shop"]["m30"];
				$SECTION_DESC = $tlec["shop"]["m91"];
				
				$plugin_template = 'plugins/ecommerce/admin/template/edititem.php';
				
				} else {
				   	jak_redirect(BASE_URL.'index.php?p=shop&sp=&sp=ene');
				}
				
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
			    		jak_redirect(BASE_URL.'index.php?p=shop&sp=quickedit&ssp='.$page2.'&sssp=e');
					} else {
			        	jak_redirect(BASE_URL.'index.php?p=shop&sp=quickedit&ssp='.$page2.'&sssp=s');
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
					   	jak_redirect(BASE_URL.'index.php?p=shop&sp=ene');
					}
			break;
			case 'delete':
				
				if (is_numeric($page2) && jak_row_exist($page2,$jaktable)) {
				
					$result2 = $jakdb->query('SELECT catid FROM '.$jaktable.' WHERE id = "'.smartsql($page2).'"');
					$row2 = $result2->fetch_assoc();
					
					if (is_numeric($row2['catid'])) {
								
						$jakdb->query('UPDATE '.$jaktable9.' SET count = count - 1 WHERE id = "'.smartsql($row2['catid']).'"');
									
					}
							
					$result = $jakdb->query('DELETE FROM '.$jaktable.' WHERE id = "'.smartsql($page2).'"');    	
				
				if (!$result) {
				    	jak_redirect(BASE_URL.'index.php?p=shop&sp=&sp=e');
					} else {
					
						JAK_tags::jakDeletetags($page2, JAK_PLUGIN_ECOMMERCE);
						
				        jak_redirect(BASE_URL.'index.php?p=shop&sp=&sp=s');
				    }
				    
				} else {
				   jak_redirect(BASE_URL.'index.php?p=shop&sp=&sp=ene');
				}
				
			break;
			case 'lock':
			
					$result2 = $jakdb->query('SELECT catid, active FROM '.$jaktable.' WHERE id = "'.smartsql($page2).'"');
					$row2 = $result2->fetch_assoc();
					
					if (is_numeric($row2['catid'])) {
					
						if ($row2['active'] == 1) {
							$jakdb->query('UPDATE '.$jaktable9.' SET count = count - 1 WHERE id = "'.smartsql($row2['catid']).'"');
						} else {
							$jakdb->query('UPDATE '.$jaktable9.' SET count = count + 1 WHERE id = "'.smartsql($row2['catid']).'"');
						}
						
					}
					
					$result = $jakdb->query('UPDATE '.$jaktable.' SET active = IF (active = 1, 0, 1) WHERE id = "'.smartsql($page2).'"');
					
					JAK_tags::jakLocktags($page2, JAK_PLUGIN_ECOMMERCE);
				    	
				if (!$result) {
					jak_redirect(BASE_URL.'index.php?p=shop&sp=&sp=e');
				} else {
				    jak_redirect(BASE_URL.'index.php?p=shop&sp=&sp=s');
				}
				
			break;
			default:
				
				$JAK_ECOMMERCE_ALL = jak_get_shop($jaktable, '');
				$JAK_CAT = jak_get_cat_info($jaktable9, 0);
				
				// Title and Description
				$SECTION_TITLE = $tlec["shop"]["m52"];
				$SECTION_DESC = $tlec["shop"]["m7"];
				
				// Call the template
				$plugin_template = 'plugins/ecommerce/admin/template/shop.php';
	}

}
?>