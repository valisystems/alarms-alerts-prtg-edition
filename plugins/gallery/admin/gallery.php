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
if (!JAK_USERID || !$jakuser->jakModuleaccess(JAK_USERID,JAK_ACCESSGALLERY)) jak_redirect(BASE_URL);

// All the tables we need for this plugin
$jaktable = DB_PREFIX.'gallery';
$jaktable1 = DB_PREFIX.'gallerycategories';
$jaktable2 = DB_PREFIX.'gallerycomments';
$jaktable3 = DB_PREFIX.'contactform';
$jaktable4 = DB_PREFIX.'pagesgrid';
$jaktable5 = DB_PREFIX.'pluginhooks';

// Get the upload path
$JAK_UPLOAD_PATH_BASE = '../plugins/gallery/upload';

// Get all the functions, well not many
include_once("../plugins/gallery/admin/include/functions.php");

// Now start with the plugin use a switch to access all pages
switch ($page1) {

	// Create new gallery
	case 'new':
		
		// Get all categories
		$JAK_CAT = jak_get_cat_info($jaktable1, 0);
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['catsave'])) {
		    
		    $defaults = $_POST;
		    
		    if (jak_row_exist($defaults['jak_catid'],$jaktable1)) {
		    	jak_redirect(BASE_URL.'index.php?p=gallery&sp=new&ssp='.$defaults['jak_catid']);
		   	} else {
		   		jak_redirect(BASE_URL.'index.php?p=error&sp=not-exist');
			}
		}
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['oldfashion'])) {
		$defaults = $_POST;
	
		// Include the thumbnail maker
		include_once '../include/functions_thumb.php';
		
		$countoption = $_FILES['photoupload']['name'];
		        
		        for($i = 0; $i < count($countoption); $i++) {
		        
		        	$filename = $_FILES['photoupload']['name'][$i]; // original filename
		        	$jak_xtension = explode(".", $filename);
		        	$jak_xtension = end($jak_xtension);
		        	
		        	if ($jak_xtension == "jpg" || $jak_xtension == "jpeg" || $jak_xtension == "png" || $jak_xtension == "gif") {
		        	
		        	if ($_FILES['photoupload']['name'][$i] != '') {
		            	$tempFile = $_FILES['photoupload']['tmp_name'][$i];
		            	$origName = substr($_FILES['photoupload']['name'][$i], 0, -4);
		            	$name_space = strtolower($_FILES['photoupload']['name'][$i]);
		                $middle_name = str_replace(" ", "_", $name_space);
		                $middle_name = str_replace(".jpeg", ".jpg", $name_space);
		                $glnrrand = rand(100000, 999999);
		                $origPhoto = str_replace(".", "_o_" . $glnrrand . ".", $middle_name);
		                $bigPhoto = str_replace(".", "_" . $glnrrand . ".", $middle_name);
		                $smallPhoto = str_replace(".", "_t.", $bigPhoto);
		            	    
		             	$targetPath = $JAK_UPLOAD_PATH_BASE.'/'.$defaults['jak_catid_new'].'/';
		             	$targetPathWdouble = $JAK_UPLOAD_PATH_BASE.'/watermark/';
		             	$targetPathW =  str_replace("//","/",$targetPathWdouble);
		            	$targetFile =  str_replace("//","/",$targetPath).$origPhoto;
		            	$origPath = '/'.$defaults['jak_catid_new'].'/';
		            	$origPathW = '/watermark/';
		            	$dbSmall = $origPath.$smallPhoto;
		            	if (!$jkv["gallerywatermark"]) {
		            		$dbBig = $origPath.$bigPhoto;
		            	} else {
		            		$dbBig = $origPathW.$bigPhoto;
		            	}
		            	$dbOrig = $origPath.$origPhoto;
		            
		            // Create Directory in the gallery folder
		            if (!is_dir($targetPath)) {
		            	mkdir($targetPath, 0777);
		                copy($JAK_UPLOAD_PATH_BASE."/index.html", $targetPath."/index.html");
		            }
		            
		            // Move file and create thumb     
		            move_uploaded_file($tempFile, $targetFile);
		            
		            // Now check if we have to rotate
		            switch (strtolower(substr($targetFile, -3))) {
		                case "jpg":
		                
		                	// We have a jpg, read the exif if possible
		                	$image = imagecreatefromjpeg($targetFile);  
		                	
		                	$exif = exif_read_data($targetFile);
		                	if (!empty($exif['Orientation'])) {
		                	    switch($exif['Orientation']) {
		                	        case 8:
		                	            $rotate = imagerotate($image,90,0);
		                	            break;
		                	        case 3:
		                	            $rotate = imagerotate($image,180,0);
		                	            break;
		                	        case 6:
		                	            $rotate = imagerotate($image,-90,0);
		                	            break;
		                	    }
		                	    
		                	    if ($rotate) {
		                    	    imagejpeg($rotate, $targetFile);
		                    	    imagedestroy($rotate);
		                    	}
		                    	imagedestroy($image);
		                	}
		                	
		                	// Save the GPS Cordinate
		                	if ($exif["GPSLatitude"]) {
		                		$latitude = jak_create_gps($exif["GPSLatitude"], $exif['GPSLatitudeRef']);
		                		$longitude = jak_create_gps($exif["GPSLongitude"], $exif['GPSLongitudeRef']);
		                	}
		                	
		                break;
		            }
		                 
		            // Check if watermark exist
		            if ($jkv["gallerywatermark"]) {
		            	create_thumbnail($targetPath, $targetFile, $smallPhoto, $jkv["gallerythumbw"], $jkv["gallerythumbh"], $jkv["galleryimgquality"]);
		                create_thumbnail_watermark($targetPathW, $targetFile, $bigPhoto, $jkv["galleryw"], $jkv["galleryh"], $jkv["galleryimgquality"], $jkv["gallerywmposition"], $jkv["gallerywatermark"]);	
		            } else {
		                create_thumbnail($targetPath, $targetFile, $smallPhoto, $jkv["gallerythumbw"], $jkv["gallerythumbh"], $jkv["galleryimgquality"]);
		                create_thumbnail($targetPath, $targetFile, $bigPhoto, $jkv["galleryw"], $jkv["galleryh"], $jkv["galleryimgquality"]);
		            }
		                 
		            // SQL insert
		                $result = $jakdb->query('INSERT INTO '.$jaktable.' VALUES (NULL, "'.smartsql($defaults['jak_catid_new']).'", "'.$dbSmall.'", "'.$dbBig.'", "'.$dbOrig.'", "'.JAK_USERID.'", "'.$origName.'", "", "", 2, 1, "'.$longitude.'", "'.$latitude.'", NOW())');
		            	
		            	if ($defaults['jak_catid_new'] != 0) {
			            	$jakdb->query('UPDATE '.$jaktable1.' SET count = count + 1 WHERE id = "'.smartsql($defaults['jak_catid_new']));
		            	}
		         }
		      }
		}
		
		if (!$result) {
			jak_redirect(BASE_URL.'index.php?p=gallery&sp=new&ssp='.$defaults['jak_catid_new'].'&sssp=e');
		} else {
		    jak_redirect(BASE_URL.'index.php?p=gallery&sp=new&ssp='.$defaults['jak_catid_new'].'&sssp=s');
		}
		
		}
		
		// Call the gallery upload settings
		$JAK_IMG_SIZE = ($jkv["galleryimgsize"] * 1024);
		
		// Title and Description
		$SECTION_TITLE = $tlgal["gallery"]["m2"];
		$SECTION_DESC = "";
		
		// Call the template
		$plugin_template = 'plugins/gallery/admin/template/newgallery.php';
		
	break;

	case 'categories':
	
		// Additional DB field information
		$jakfield = 'catparent';
		$jakfield1 = 'varname';
		 
		 switch ($page2) {
		 	case 'lock':
		 	
			 	$result = $jakdb->query('UPDATE '.$jaktable1.' SET active = IF (active = 1, 0, 1) WHERE id = "'.smartsql($page3).'"');
		        	
		    if (!$result) {
		    	jak_redirect(BASE_URL.'index.php?p=gallery&sp=categories&ssp=e');
			} else {
			
				JAK_tags::jaklocktags($page3, JAK_PLUGIN_GALLERY);
				
		        jak_redirect(BASE_URL.'index.php?p=gallery&sp=categories&ssp=s');
		    }
		 	
		 	break;
		    case 'delete':
		
			if (jak_row_exist($page3,$jaktable1) && !jak_field_not_exist($page3,$jaktable1,$jakfield)) {
			
				$result = $jakdb->query('DELETE FROM '.$jaktable1.' WHERE id = "'.smartsql($page3).'"');
		
			if (!$result) {
		    	jak_redirect(BASE_URL.'index.php?p=gallery&sp=categories&ssp=e');
			} else {
			
				JAK_tags::jakDeletetags($page3, JAK_PLUGIN_GALLERY);
				
		        jak_redirect(BASE_URL.'index.php?p=gallery&sp=categories&ssp=s');
		    }
		    
			} else {
		    	jak_redirect(BASE_URL.'index.php?p=gallery&sp=categories&ssp=eca');
			}
			break;
		    case 'edit':
		
			if (jak_row_exist($page3,$jaktable1)) {
		
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
		
		    if (empty($defaults['jak_name'])) {
		        $errors['e1'] = $tl['error']['e12'];
		    }
		    
		    if (jak_field_not_exist_id($defaults['jak_varname'],$page3,$jaktable1,$jakfield1)) {
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
		
			$result = $jakdb->query('UPDATE '.$jaktable1.' SET 
			name = "'.smartsql($defaults['jak_name']).'",
			varname = "'.smartsql($defaults['jak_varname']).'",
			content = "'.smartsql($defaults['jak_lcontent']).'",
			permission = "'.smartsql($permission).'",
			uploadc = "'.smartsql($defaults['jak_uploadc']).'",
			active = "'.smartsql($defaults['jak_active']).'",
			'.$insert.'
			comments = "'.smartsql($defaults['jak_comment']).'",
			showvote = "'.smartsql($defaults['jak_vote']).'",
			socialbutton = "'.smartsql($defaults['jak_social']).'"
			WHERE id = "'.smartsql($page3).'"');
			
			if (!$result) {
				jak_redirect(BASE_URL.'index.php?p=gallery&sp=categories&ssp=edit&sssp='.$page3.'&ssssp=e');
			} else {
				
				// Create Tags if the module is active
				if (!empty($defaults['jak_tags'])) {
					// check if tag does not exist and insert in cloud
					JAK_tags::jakBuildcloud($defaults['jak_tags'],smartsql($page3), JAK_PLUGIN_GALLERY);
					// insert tag for normal use
					JAK_tags::jakInsertags($defaults['jak_tags'],smartsql($page3), JAK_PLUGIN_GALLERY, 1);
					
				}
				
			    jak_redirect(BASE_URL.'index.php?p=gallery&sp=categories&ssp=edit&sssp='.$page3.'&ssssp=s');
			}
		
		 	} else {
		    
		   	$errors['e'] = $tl['error']['e'];
		    $errors = $errors;
		    }
			}
			
			if (JAK_TAGS) {
				$JAK_TAGLIST = jak_get_tags($page3, JAK_PLUGIN_GALLERY);
			}
		
			$JAK_FORM_DATA = jak_get_data($page3, $jaktable1);
			$JAK_USERGROUP = jak_get_usergroup_all('usergroup');
			
			// Title and Description
			$SECTION_TITLE = $tlgal["gallery"]["m"].' - '.$tl["cmenu"]["c6"];
			$SECTION_DESC = $tl["cmdesc"]["d6"];
			
			$plugin_template = 'plugins/gallery/admin/template/editgallerycat.php';
		
			} else {
		   		jak_redirect(BASE_URL.'index.php?p=gallery&sp=categories&ssp=ene');
			}
			
			break;
			case 'watermark':
			
				if (is_numeric($page3)) {
					
					// just to ignore timout
					ignore_user_abort(true);
					set_time_limit(0);
				
					// Include the thumbnail maker
					include_once '../include/functions_thumb.php';
				    
				    $result = $jakdb->query('SELECT id, catid, paththumb, pathbig, original FROM '.$jaktable.' WHERE catid = "'.smartsql($page3).'"');
					while ($row = $result->fetch_assoc()) {
					
						// Delete Files
						if (is_file($JAK_UPLOAD_PATH_BASE . $row['pathbig'])) {
							unlink($JAK_UPLOAD_PATH_BASE . $row['pathbig']);
						}
						    
						if (is_file($JAK_UPLOAD_PATH_BASE . $row['paththumb'])) {
							unlink($JAK_UPLOAD_PATH_BASE . $row['paththumb']);
						}
						    
						// Define the path to the darkside
						$targetPathWd = $JAK_UPLOAD_PATH_BASE.'/watermark/';
					    $targetPathW =  str_replace("//","/",$targetPathWd);
					    
					    $targetPathO = $JAK_UPLOAD_PATH_BASE.'/'.$page3;
					    $targetPath = str_replace("//","/",$targetPathO);
					    
					    // Get the original photo from the filesystem
					    $targetFiled =  $JAK_UPLOAD_PATH_BASE.'/'.$row['original'];
					    $targetFile =  str_replace("//","/",$targetFiled);
						    
					    // Rename the original file to the end result
					    $bigPhotoc = str_replace("_o_", "_", $row['original']);
					    $bigPhoto =  str_replace("/".$row['catid']."/", "", $bigPhotoc);
					    $smallPhotoc = str_replace(".", "_t.", $bigPhoto);
					    $smallPhoto =  str_replace("/".$row['catid']."/", "", $smallPhotoc);
					    
					    if ($jkv["gallerywatermark"] && !strpos($row['pathbig'], 'watermark')) {
					    
					    	$watermarkpathf = '/watermark/'.$bigPhoto;
					    
					    	$jakdb->query('UPDATE '.$jaktable.' SET pathbig = "'.smartsql($watermarkpathf).'" WHERE id = "'.smartsql($row['id']).'"');
					    	
					    }
					    
					    // Check if watermark exist
					    if ($jkv["gallerywatermark"]) {
					    	create_thumbnail($targetPath, $targetFile, $smallPhoto, $jkv["gallerythumbw"], $jkv["gallerythumbh"], $jkv["galleryimgquality"]);
					        create_thumbnail_watermark($targetPathW, $targetFile, $bigPhoto, $jkv["galleryw"], $jkv["galleryh"], $jkv["galleryimgquality"], $jkv["gallerywmposition"], $jkv["gallerywatermark"]);	
					    } else {
					        create_thumbnail($targetPath, $targetFile, $smallPhoto, $jkv["gallerythumbw"], $jkv["gallerythumbh"], $jkv["galleryimgquality"]);
					        create_thumbnail($targetPath, $targetFile, $bigPhoto, $jkv["galleryw"], $jkv["galleryh"], $jkv["galleryimgquality"]);
					    }
				    
				}
				
					jak_redirect(BASE_URL.'index.php?p=gallery&sp=categories&ssp=s');
				} else {
					jak_redirect(BASE_URL.'index.php?p=gallery&sp=categories&ssp=ene');
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
				$SECTION_TITLE = $tlgal["gallery"]["m"].' - '.$tl["menu"]["m5"];
				$SECTION_DESC = $tl["cmdesc"]["d5"];
								  
				// Call the template
				$plugin_template = 'plugins/gallery/admin/template/gallerycat.php';
			}
	break;
	// Create new gallery categories
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
		    
		    if (!isset($defaults['jak_uploadc'])) {
		    	$catupload = 1;
		    } else {
		    	$catupload = $defaults['jak_uploadc'];
		    }
		    
		    if (!isset($defaults['jak_active'])) {
		    	$catactive = 1;
		    	$tagactive = 1;
		    } else {
		    	$catactive = $defaults['jak_active'];
		    	$tagactive = $defaults['jak_active'];
		    }
		    
		    if (!isset($defaults['jak_permission'])) {
		    	$permission = 0;
		    } else {
		    	$permission = join(',', $defaults['jak_permission']);
		    }
		    
		    if (isset($defaults['jak_comment'])) {
		    	$comment = $defaults['jak_comment'];
		    } else {
		    	$comment = 1;
		    }
		    
		    if (isset($defaults['jak_vote'])) {
		    	$vote = $defaults['jak_vote'];
		    } else {
		    	$vote = 0;
		    }
		    
		    if (isset($defaults['jak_social'])) {
		    	$social = $defaults['jak_social'];
		    } else {
		    	$social = 0;
		    }
		    
		    if (!empty($defaults['jak_img'])) {
		    	$insert = 'catimg = "'.smartsql($defaults['jak_img']).'",';
		    }
		    
			$result = $jakdb->query('INSERT INTO '.$jaktable1.' SET 
			name = "'.smartsql($defaults['jak_name']).'",
			varname = "'.smartsql($defaults['jak_varname']).'",
			content = "'.smartsql($defaults['jak_lcontent']).'",
			permission = "'.smartsql($permission).'",
			uploadc = "'.smartsql($catupload).'",
			active = "'.smartsql($catactive).'",
			'.$insert.'
			comments = "'.smartsql($comment).'",
			showvote = "'.smartsql($vote).'",
			socialbutton = "'.smartsql($social).'",
			catparent = 0');
			
			$rowid = $jakdb->jak_last_id();
			
			if (!$result) {
			    jak_redirect(BASE_URL.'index.php?p=gallery&sp=newcategory&ssp=e');
			} else {
				
				// Create Tags if the module is active
				if (!empty($defaults['jak_tags'])) {
							// check if tag does not exist and insert in cloud
					        JAK_tags::jakBuildcloud($defaults['jak_tags'], $rowid, JAK_PLUGIN_GALLERY);
					        // insert tag for normal use
					        JAK_tags::jakInsertags($defaults['jak_tags'], $rowid, JAK_PLUGIN_GALLERY, $tagactive);
					        
				}
				
			    jak_redirect(BASE_URL.'index.php?p=gallery&sp=categories&ssp=edit&sssp='.$rowid.'&ssssp=s');
			}
		
		 } else {
		    
		   	$errors['e'] = $tl['error']['e'];
		    $errors = $errors;
		    }
		}
		
		// Title and Description
		$SECTION_TITLE = $tlgal["gallery"]["m"].' - '.$tl["cmenu"]["c4"];
		$SECTION_DESC = $tl["cmdesc"]["d8"];
		
		// Call the template
		$plugin_template = 'plugins/gallery/admin/template/newgallerycat.php';
		
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
			$pages->jak_where = 'index.php?p=gallery&sp=comment';
			$pages->paginate();
			$JAK_PAGINATE = $pages->display_pages();
			
			// Get the comments
			$JAK_GALLERYCOM_ALL = jak_get_gallery_comments($pages->limit,'','');
		}
		
		// Get the photos
		$JAK_GALLERY_ALL = jak_get_gallerys('', '', $jaktable);
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $defaults = $_POST;
		    
		    if (isset($defaults['approve'])) {
		    
		    $lockuser = $defaults['jak_delete_comment'];
		
		        for ($i = 0; $i < count($lockuser); $i++) {
		            $locked = $lockuser[$i];
		            
		        	$result = $jakdb->query('UPDATE '.$jaktable2.' SET approve = IF (approve = 1, 0, 1), session = NULL WHERE id = "'.smartsql($locked).'"');
		        }
		  
		 	if (!$result) {
		 		jak_redirect(BASE_URL.'index.php?p=gallery&sp=comment&ssp=e');
		 	} else {
		 	    jak_redirect(BASE_URL.'index.php?p=gallery&sp=comment&ssp=s');
		 	}
		    
		    }
		    
		    if (isset($defaults['delete'])) {
		    
		    $lockuser = $defaults['jak_delete_comment'];
		
		        for ($i = 0; $i < count($lockuser); $i++) {
		            $locked = $lockuser[$i];
		            
		            $result = $jakdb->query('DELETE FROM '.$jaktable2.' WHERE id = "'.smartsql($locked).'"');
		        	
		        }
		  
		 	if (!$result) {
		 		jak_redirect(BASE_URL.'index.php?p=gallery&sp=comment&ssp=e');
		 	} else {
		 	    jak_redirect(BASE_URL.'index.php?p=gallery&sp=comment&ssp=s');
		 	}
		    
		    }
		
		 }
		 
		 switch ($page2) {
		 	case 'approval':
		        $JAK_GALLERYCOM_APPROVE = jak_get_gallery_comments($pages->limit,'approve','');
		        
		        // Title and Description
		        $SECTION_TITLE = $tlgal["gallery"]["d20"];
		        $SECTION_DESC = $tlgal["gallery"]["t2"];
		        
		        // Get the template
		        $plugin_template = 'plugins/gallery/admin/template/gallerycomment.php';
		 	 	break;
		 	case 'sort':
		 		if ($page3 == 'gallery') {
		 			$bu = 'galleryid';
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
		       	$pages->jak_where = 'index.php?p=gallery&sp=comment&ssp=sort&sssp='.$page3.'&ssssp='.$page4;
		       	$pages->paginate();
		       	$JAK_PAGINATE_SORT = $pages->display_pages();
		        $JAK_GALLERYCOM_SORT = jak_get_gallery_comments($pages->limit, $page4, $bu);
		        
		        // Title and Description
		        $SECTION_TITLE = $tlgal["gallery"]["d19"];
		        $SECTION_DESC = $tlgal["gallery"]["t2"];
		        
		        // Get the template
		        $plugin_template = 'plugins/gallery/admin/template/gallerycommentsort.php';
		 	} else {
		 		jak_redirect(BASE_URL.'index.php?p=gallery&sp=comment&ssp=ene');
		    }
		 	break;
		 	case 'approve':
		 	
		        if (jak_row_exist($page3, $jaktable2)) {
		        
		        	$result = $jakdb->query('UPDATE '.$jaktable2.' SET approve = IF (approve = 1, 0, 1), session = NULL WHERE id = "'.smartsql($page3).'"');
		        	
					if (!$result) {
				    	jak_redirect(BASE_URL.'index.php?p=gallery&sp=comment&ssp=e');
					} else {
				        jak_redirect(BASE_URL.'index.php?p=gallery&sp=comment&ssp=s');
		    		}
		    
				} else {
				   	jak_redirect(BASE_URL.'index.php?p=gallery&sp=comment&ssp=ene');
				}
				
		    break;
		    case 'delete':
		        if (jak_row_exist($page3, $jaktable2)) {
		        
		        	$result = $jakdb->query('DELETE FROM '.$jaktable2.' WHERE id = "'.smartsql($page3).'"');
		        	
			if (!$result) {
		    	jak_redirect(BASE_URL.'index.php?p=gallery&sp=comment&ssp=e');
			} else {
		        jak_redirect(BASE_URL.'index.php?p=gallery&sp=comment&ssp=s');
		    }
		    
		} else {
		   	jak_redirect(BASE_URL.'index.php?p=gallery&sp=comment&ssp=ene');
		}
		break;
		default:
			
			// Title and Description
			$SECTION_TITLE = $tlgal["gallery"]["d19"];
			$SECTION_DESC = $tlgal["gallery"]["t2"];
			
			// Call the template
			$plugin_template = 'plugins/gallery/admin/template/gallerycomment.php';
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
		    $galleryorder = $defaults['jak_showgalleryordern'].' '.$defaults['jak_showgalleryorder'];
		    
		    // Do the dirty work in mysql
		    $result = $jakdb->query('UPDATE '.DB_PREFIX.'setting SET value = CASE varname
		    	WHEN "gallerytitle" THEN "'.smartsql($defaults['jak_title']).'"
		    	WHEN "gallerydesc" THEN "'.smartsql($defaults['jak_lcontent']).'"
		        WHEN "galleryemail" THEN "'.smartsql($defaults['jak_email']).'"
		        WHEN "galleryorder" THEN "'.smartsql($galleryorder).'"
		        WHEN "galleryhlimit" THEN "'.smartsql($defaults['jak_gallerylimit']).'"
		        WHEN "galleryopenattached" THEN "'.smartsql($defaults['jak_lightbox']).'"
		        WHEN "gallerydateformat" THEN "'.smartsql($defaults['jak_date']).'"
		        WHEN "gallerytimeformat" THEN "'.smartsql($defaults['jak_time']).'"
		        WHEN "galleryurl" THEN "'.smartsql($defaults['jak_galleryurl']).'"
		        WHEN "gallerymaxpost" THEN "'.smartsql($defaults['jak_maxpost']).'"
		        WHEN "galleryrss" THEN "'.smartsql($defaults['jak_rssitem']).'"
		        WHEN "gallerypagemid" THEN "'.smartsql($defaults['jak_mid']).'"
		        WHEN "gallerypageitem" THEN "'.smartsql($defaults['jak_item']).'"
		        WHEN "galleryimgsize" THEN "'.smartsql($defaults['jak_imagebyte']).'"
		        WHEN "gallerythumbw" THEN "'.smartsql($defaults['jak_imagetw']).'"
		        WHEN "gallerythumbh" THEN "'.smartsql($defaults['jak_imageth']).'"
		        WHEN "galleryw" THEN "'.smartsql($defaults['jak_imagew']).'"
		        WHEN "galleryh" THEN "'.smartsql($defaults['jak_imageh']).'"
		        WHEN "galleryimgquality" THEN "'.smartsql($defaults['jak_quality']).'"
		        WHEN "gallerywatermark" THEN "'.smartsql($defaults['jak_watermark']).'"
		        WHEN "gallerywmposition" THEN "'.smartsql($defaults['jak_position']).'"
		    END
				WHERE varname IN ("gallerytitle","gallerydesc","galleryemail","galleryorder","galleryhlimit","galleryopenattached","gallerydateformat","gallerytimeformat","galleryurl","gallerymaxpost","gallerypagemid","gallerypageitem","galleryrss", "galleryimgsize", "gallerythumbw", "gallerythumbh", "galleryw", "galleryh", "galleryimgquality", "gallerywatermark", "gallerywmposition")');
				
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
				
						$jakdb->query('INSERT INTO '.$jaktable4.' SET plugin = "'.smartsql(JAK_PLUGIN_GALLERY).'", hookid = "'.smartsql($key).'", pluginid = "'.smartsql($pdoith[$key]).'", whatid = "'.smartsql($whatid).'", orderid = "'.smartsql($exorder).'"');
					
					}
				
				}
			
			}
			
			// Now check if all the sidebar a deselct and hooks exist, if so delete all associated to this page
			$result = $jakdb->query('SELECT id FROM '.$jaktable4.' WHERE plugin = "'.smartsql(JAK_PLUGIN_GALLERY).'" AND hookid != 0');
				$row = $result->fetch_assoc();
			
			if (isset($defaults['jak_hookshow_new']) && !is_array($defaults['jak_hookshow_new']) && $row['id'] && !is_array($defaults['jak_hookshow'])) {
			
				$jakdb->query('DELETE FROM '.$jaktable4.' WHERE plugin = "'.smartsql(JAK_PLUGIN_GALLERY).'" AND hookid != 0');
			
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
				$jakdb->query('DELETE FROM '.$jaktable2.' WHERE plugin = "'.smartsql(JAK_PLUGIN_GALLERY).'" AND galleryid = 0 AND hookid != 0');
			}
				
			if (!$result) {
				jak_redirect(BASE_URL.'index.php?p=gallery&sp=setting&ssp=e');
			} else {
		        jak_redirect(BASE_URL.'index.php?p=gallery&sp=setting&ssp=s');
		    }
		    } else {
		    
		   	$errors['e'] = $tl['error']['e'];
		    $errors = $errors;
		    }
		}
		
		// Get the sort orders for the grid
		$grid = $jakdb->query('SELECT id, hookid, whatid, orderid FROM '.$jaktable4.' WHERE plugin = "'.smartsql(JAK_PLUGIN_GALLERY).'" AND galleryid = 0 ORDER BY orderid ASC');
		while ($grow = $grid->fetch_assoc()) {
		        // collect each record into $_data
		        $JAK_PAGE_GRID[] = $grow;
		}
		
		// Get the sidebar templates
		$result = $jakdb->query('SELECT id, name, widgetcode, exorder, pluginid FROM '.$jaktable5.' WHERE hook_name = "tpl_sidebar" AND active = 1 ORDER BY exorder ASC');
		while ($row = $result->fetch_assoc()) {
			$JAK_HOOKS[] = $row;
		}
		
		// Now let's check how to display the order
		$showgalleryarray = explode(" ", $jkv["galleryorder"]);
		
		if (is_array($showgalleryarray) && in_array("ASC", $showgalleryarray) || in_array("DESC", $showgalleryarray)) {
		
				$showgallerywhat = $showgalleryarray[0];
				$showgalleryorder = $showgalleryarray[1];
			
		}
		
		$JAK_SETTING = jak_get_setting('gallery');
		
		// Get the special vars for multi language support
		$JAK_FORM_DATA["title"] = $jkv["gallerytitle"];
		$JAK_FORM_DATA["content"] = $jkv["gallerydesc"];
		
		// Title and Description
		$SECTION_TITLE = $tlgal["gallery"]["d"];
		$SECTION_DESC = $tl["cmdesc"]["d2"];
		
		// Call the template
		$plugin_template = 'plugins/gallery/admin/template/gallerysetting.php';
		
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
		 		jak_redirect(BASE_URL.'index.php?p=gallery&sp=trash&ssp=e');
		 	} else {
		 	    jak_redirect(BASE_URL.'index.php?p=gallery&sp=trash&ssp=s');
		 	}
		    
		    }
		    
		    if (isset($defaults['delete'])) {
		    
		    $deltrash = $defaults['jak_delete_trash'];
		
		        for ($i = 0; $i < count($deltrash); $i++) {
		            $trash = $deltrash[$i];
		            
		            $result = $jakdb->query('DELETE FROM '.$jaktable2.' WHERE id = "'.smartsql($trash).'"');     	
		        }
		  
		 	if (!$result) {
		 		jak_redirect(BASE_URL.'index.php?p=gallery&sp=trash&ssp=e');
		 	} else {
		 	    jak_redirect(BASE_URL.'index.php?p=gallery&sp=trash&ssp=s');
		 	}
		    
		    }
		
		 }
		
		$result = $jakdb->query('SELECT * FROM '.$jaktable2.' WHERE trash = 1 ORDER BY id DESC');
		while ($row = $result->fetch_assoc()) {
		        // collect each record into $_data
		        $JAK_TRASH_ALL[] = $row;
		    }
		
		// Title and Description
		$SECTION_TITLE = $tlgal["gallery"]["d18"];
		$SECTION_DESC = $tlgal["gallery"]["d19"].' - '.$tlgal["gallery"]["m"];
		
		// Get the template, same from the user
		$plugin_template = 'plugins/gallery/admin/template/trash.php';
	break;
	default:
		
		// Important Smarty stuff
		$JAK_CAT = jak_get_cat_info($jaktable1, 0);
		$JAK_CONTACT_FORMS = jak_get_page_info($jaktable3, '');
		 
		 switch ($page1) {
		 	case 'showcat':
		 	
		 		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		 		        $defaults = $_POST;
		 		        
		 		        if (isset($defaults['real_photo_id'])) {
		 		        
		 		                $newphotoname = $defaults['phname'];
		 		                $photoid = $defaults['real_photo_id'];
		 		                $realid = implode(',', $defaults['real_photo_id']);
		 		                $phname = array_combine($photoid, $newphotoname);
		 		            	
		 		            	// Update names
		 		            	$updatesqli = '';
		 		            	foreach ($phname as $ki => $iname) {
		 		            		$updatesqli .= sprintf("WHEN %d THEN '%s' ", $ki, $iname);
		 		            	}
		 		                
		 		                $result = $jakdb->query('UPDATE '.$jaktable.' SET title = CASE id
		 		                '.$updatesqli.'
		 		                END
		 		                WHERE id IN ('.$realid.')');
		 		                
		 		                if (!$result) {
		 							jak_redirect(BASE_URL.'index.php?p=gallery&sp=showcat&ssp='.$page2.'&sssp=e');
		 						} else {
		 							jak_redirect(BASE_URL.'index.php?p=gallery&sp=showcat&ssp='.$page2.'&sssp=s');
		 		    			}
		 		    	}   
		 		  }
		       	
		        $JAK_GALLERY_SORT = jak_get_gallerys('', $page2, $jaktable);
		        
		        // Title and Description
		        $SECTION_TITLE = $tlgal["gallery"]["m1"];
		        $SECTION_DESC = $tlgal["gallery"]["t"];
		        
		        // Get the template, same from the user
		        $plugin_template = 'plugins/gallery/admin/template/gallerycatsort.php';
		        
		 	
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
		 	    	
		 	    JAK_tags::jaklocktags($page2,JAK_PLUGIN_GALLERY);
		 	    	
			 	if (!$result) {
			 		jak_redirect(BASE_URL.'index.php?p=gallery&sp=e');
			 	} else {
			 	    jak_redirect(BASE_URL.'index.php?p=gallery&sp=s');
			 	}
		 		
		 		break;
		case 'delete':
		
			if (jak_row_exist($page2, $jaktable)) {
		        
		    	$result = $jakdb->query('SELECT catid, paththumb, pathbig, original FROM '.$jaktable.' WHERE id = "'.smartsql($page2).'"');
				$row = $result->fetch_assoc();
		        	
		        $jakdb->query('UPDATE '.$jaktable1.' SET count = count - 1 WHERE id = "'.smartsql($row['catid']).'"');
		        
		        $jakdb->query('DELETE FROM '.$jaktable2.' WHERE galleryid = "'.smartsql($page2).'"');
					
				$result = $jakdb->query('DELETE FROM '.$jaktable.' WHERE id = "'.smartsql($page2).'"');
		
			if (!$result) {
		    	jak_redirect(BASE_URL.'index.php?p=gallery&sp=e');
		        
			} else {
				
		        if (is_file($JAK_UPLOAD_PATH_BASE . $row['paththumb'])) {
		            unlink($JAK_UPLOAD_PATH_BASE . $row['paththumb']);
		        }
		        if (is_file($JAK_UPLOAD_PATH_BASE . $row['pathbig'])) {
		            unlink($JAK_UPLOAD_PATH_BASE . $row['pathbig']);
		        }
		            
		        if (is_file($JAK_UPLOAD_PATH_BASE . $row['original'])) {
		        	unlink($JAK_UPLOAD_PATH_BASE . $row['original']);
		        }
				
		        jak_redirect(BASE_URL.'index.php?p=gallery&sp=s');
		    }
		    
			} else {
		   		jak_redirect(BASE_URL.'index.php?p=gallery&sp=ene');
			}
		
		break;
		case 'edit':
		
		if (is_numeric($page2) && jak_row_exist($page2, $jaktable)) {
		
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $defaults = $_POST;
		    
		    // Delete the comments
		    if (!empty($defaults['jak_delete_comment'])) {
		    		$jakdb->query('DELETE FROM '.$jaktable2.' WHERE galleryid = "'.smartsql($page2).'"');	
		    }
		    
		    // Delete the likes
		    if (!empty($defaults['jak_delete_rate'])) {
		    	$jakdb->query('DELETE FROM '.DB_PREFIX.'like_counter WHERE btnid = "'.smartsql($page2).'" AND locid = "'.smartsql(JAK_PLUGIN_GALLERY).'"');
		    	$jakdb->query('DELETE FROM '.DB_PREFIX.'like_client WHERE btnid = "'.smartsql($page2).'" AND locid = "'.smartsql(JAK_PLUGIN_GALLERY).'"');
		    }
		    
		    // Delete the hits
		    if (!empty($defaults['jak_delete_hits'])) {
		    	$jakdb->query('UPDATE '.$jaktable.' SET hits = 1 WHERE id = "'.smartsql($page2).'"');
		    }
		
		    if (empty($defaults['jak_title'])) {
		        $errors['e1'] = $tl['error']['e2'];
		    }
		    
		    // Create new watermark
		    if (!empty($defaults['jak_new_watermark'])) {
		        
		       	$result = $jakdb->query('SELECT catid, paththumb, pathbig, original FROM '.$jaktable.' WHERE id = "'.smartsql($page2).'"');
		        $row = $result->fetch_assoc();
		        	
		        $filepathW = $JAK_UPLOAD_PATH_BASE.$row['pathbig'];
		        $filepathW =  str_replace("/".$row['catid']."/", "/watermark/",$filepathW);
				$filepathWDB =  str_replace("/".$row['catid']."/", "/watermark/",$row['pathbig']);
		        
		        $result3 = $jakdb->query('UPDATE '.$jaktable.' SET pathbig = "'.smartsql($filepathWDB).'" WHERE id = "'.smartsql($row['id']).'"');
		        
		        if ($filepathW && $result3) {
		        	$removedouble =  str_replace("//","/",$filepathW);
		        }
		        
		        if (!file_exists($removedouble)) {
		        
		        	// Include the thumbnail maker
		        	include_once '../include/functions_thumb.php';
		        	
		        	// Define the path to the darkside
		        	$targetPathWd = $JAK_UPLOAD_PATH_BASE.'/watermark/';
		        	$targetPathW =  str_replace("//","/",$targetPathWd);
		        	
		        	// Get the original photo from the filesystem
		        	$targetFiled =  $JAK_UPLOAD_PATH_BASE.$row['original'];
		        	$targetFile =  str_replace("//","/",$targetFiled);
		        	
		        	// Rename the original file to the end result
		        	$bigPhotoc = str_replace("_o_", "_", $row['original']);
		        	$bigPhoto =  str_replace("/".$row['catid']."/", "",$bigPhotoc);
		        			
		        	create_thumbnail_watermark($targetPathW, $targetFile, $bigPhoto, $jkv["galleryw"], $jkv["galleryh"], $jkv["galleryimgquality"], $jkv["gallerywmposition"], $jkv["gallerywatermark"]);
		        }
		    }
		    
		    if (count($errors) == 0) {
		    
		    if (!empty($defaults['jak_update_time'])) {
		    	$insert .= 'time = NOW(),';
		    }
		    
		    if ($defaults['jak_catid'] != 0 || $defaults['jak_catid'] != $defaults['jak_oldcatid']) {
		        	// Create directory if not exist
		        	$targetPath = $JAK_UPLOAD_PATH_BASE.'/'.$defaults['jak_catid'].'/';
		        	if (!is_dir($targetPath)) {
		        		mkdir($targetPath, 0777);
		        	    copy($JAK_UPLOAD_PATH_BASE."/index.html", $targetPath."/index.html");
		        	}
		        	
		        	$result = $jakdb->query('SELECT catid, paththumb, pathbig, original FROM '.$jaktable.' WHERE id = "'.smartsql($page2).'"');
		        	$row = $result->fetch_assoc();
		        	
		        	// set the new cat id for the database and move
		        	$smalli = str_replace("/".$row['catid']."/", "/".$defaults['jak_catid']."/", $row['paththumb']);
		        	$smallidb = str_replace("/".$row['catid']."/", "/".$defaults['jak_catid']."/", $row['paththumb']);
		        	if (!$jkv["gallerywatermark"]) {
		        		$bigi = str_replace("/".$row['catid']."/", "/".$defaults['jak_catid']."/", $row['pathbig']);
		        		$bigidb = str_replace("/".$row['catid']."/", "/".$defaults['jak_catid']."/", $row['pathbig']);
		        	}
		        	$origi = str_replace("/".$row['catid']."/", "/".$defaults['jak_catid']."/", $row['original']);
		        	$origidb = str_replace("/".$row['catid']."/", "/".$defaults['jak_catid']."/", $row['original']);
		        	// remove double forward slashes
		        	$smalli =  str_replace("//","/",$JAK_UPLOAD_PATH_BASE.$smalli);
		        	if (!$jkv["gallerywatermark"]) {
		        		$bigi =  str_replace("//","/",$JAK_UPLOAD_PATH_BASE.$bigi);
		        	}
		        	$origi =  str_replace("//","/",$JAK_UPLOAD_PATH_BASE.$origi);
		        	// Orig path
		        	$smallpi =  str_replace("//","/",$JAK_UPLOAD_PATH_BASE.$row['paththumb']);
		        	if (!$jkv["gallerywatermark"]) {
		        		$bigpi =  str_replace("//","/",$JAK_UPLOAD_PATH_BASE.$row['pathbig']);
		        	}
		        	$origpi =  str_replace("//","/",$JAK_UPLOAD_PATH_BASE.$row['original']);
		        	// now move the files
		        	$movefiles[] = rename($smallpi, $smalli);
		        	if (!$jkv["gallerywatermark"]) {
		        		$movefiles[] = rename($bigpi, $bigi);
		        	}
		        	$movefiles[] = rename($origpi, $origi);
		        	// now errors update db
		        	$sqlset = '';
		        	if (!$jkv["gallerywatermark"]) {
		        	$sqlset = ', pathbig = "'.smartsql($bigidb).'"';
		        	}
		        	if ($movefiles) {
		        		$jakdb->query('UPDATE '.$jaktable.' SET paththumb = "'.smartsql($smallidb).'"'.$sqlset.', original = "'.smartsql($origidb).'" WHERE id = "'.smartsql($page2).'"');
		        	}
		        }
		    
			    $result = $jakdb->query('UPDATE '.$jaktable.' SET 
			    catid = "'.smartsql($defaults['jak_catid']).'",
			    '.$insert.'
			    title = "'.smartsql($defaults['jak_title']).'",
			    content = "'.smartsql($defaults['jak_content']).'"
			    WHERE id = "'.smartsql($page2).'"');
		    
			    if ($defaults['jak_catid'] != 0 || $defaults['jak_catid'] != $defaults['jak_oldcatid']) {
			    
			    	$jakdb->query('UPDATE '.$jaktable1.' SET count = count - 1 WHERE id = "'.smartsql($defaults['jak_oldcatid']).'"');
			    	$jakdb->query('UPDATE '.$jaktable1.' SET count = count + 1 WHERE id = "'.smartsql($defaults['jak_catid']).'"');
			    	
			    }
		
		if (!$result) {
		   	jak_redirect(BASE_URL.'index.php?p=gallery&sp=edit&ssp='.$page2.'&sssp=e');
		} else {
			jak_redirect(BASE_URL.'index.php?p=gallery&sp=edit&ssp='.$page2.'&sssp=s');
		}
			    
		 } else {
		    
		   	$errors['e'] = $tl['error']['e'];
		    $errors = $errors;
		    }
		}
		
		$JAK_FORM_DATA = jak_get_data($page2, $jaktable);
		
		// Title and Description
		$SECTION_TITLE = $tlgal["gallery"]["m3"];
		$SECTION_DESC = "";
		
		$plugin_template = 'plugins/gallery/admin/template/editgallery.php';
		
		} else {
		   	jak_redirect(BASE_URL.'index.php?p=gallery&sp=ene');
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
		 		$pages->jak_where = 'index.php?p=gallery&sp=sort&ssp='.$page2.'&sssp='.$page3;
		 		$pages->paginate();
		 		$JAK_PAGINATE = $pages->display_pages();
		 	}
		 	
		 	$result = $jakdb->query('SELECT * FROM '.$jaktable.' ORDER BY '.$page2.' '.$page3.' '.$pages->limit);
		 	while ($row = $result->fetch_assoc()) {
		 	    $galleryarray[] = $row;
		 	}
		 	
		 	$JAK_GALLERY_ALL = $galleryarray;
		 	
		 	// Call the template
		 	$plugin_template = 'plugins/gallery/admin/template/gallery.php';
		 		
		break;
		default:
		
			// Let's go on with the script
			if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['jak_delete_gallery'])) {
			    $defaults = $_POST;
			    
			    if (isset($defaults['move'])) {
			    
			    $jakmove = $defaults['jak_delete_gallery'];
			    $jakcatid = $defaults['jak_catid'];
			    
			    // Create directory if not exist
			    $targetPath = $JAK_UPLOAD_PATH_BASE.'/'.$jakcatid.'/';
			    if (!is_dir($targetPath)) {
			    	mkdir($targetPath, 0777);
			        copy($JAK_UPLOAD_PATH_BASE."/index.html", $targetPath."/index.html");
			    }
			
			        for ($i = 0; $i < count($jakmove); $i++) {
			            $move = $jakmove[$i];
			            
			            $result = $jakdb->query('SELECT catid, paththumb, pathbig, original FROM '.$jaktable.' WHERE id = "'.smartsql($move).'"');
			            $row = $result->fetch_assoc();
			            
			            if ($row['catd'] != $jakcatid) {
			            
						$result1 = $jakdb->query('UPDATE '.$jaktable1.' SET count = count - 1 WHERE id = "'.smartsql($row['catid']).'"');
						
						$result2 = $jakdb->query('UPDATE '.$jaktable1.' SET count = count + 1 WHERE id = "'.smartsql($jakcatid).'"');
						
						$result3 = $jakdb->query('UPDATE '.$jaktable.' SET catid = "'.smartsql($jakcatid).'" WHERE id = "'.smartsql($move).'"');
						
						// set the new cat id for the database and move
						$smalli = str_replace("/".$row['catid']."/", "/".$jakcatid."/", $row['paththumb']);
						$smallidb = str_replace("/".$row['catid']."/", "/".$jakcatid."/", $row['paththumb']);
						if (!$jkv["gallerywatermark"]) {
							$bigi = str_replace("/".$row['catid']."/", "/".$jakcatid."/", $row['pathbig']);
							$bigidb = str_replace("/".$row['catid']."/", "/".$jakcatid."/", $row['pathbig']);
						}
						$origi = str_replace("/".$row['catid']."/", "/".$jakcatid."/", $row['original']);
						$origidb = str_replace("/".$row['catid']."/", "/".$jakcatid."/", $row['original']);
						// remove double forward slashes
						$smalli =  str_replace("//","/",$JAK_UPLOAD_PATH_BASE.$smalli);
						if (!$jkv["gallerywatermark"]) {
							$bigi =  str_replace("//","/",$JAK_UPLOAD_PATH_BASE.$bigi);
						}
						$origi =  str_replace("//","/",$JAK_UPLOAD_PATH_BASE.$origi);
						// Orig path
						$smallpi =  str_replace("//","/",$JAK_UPLOAD_PATH_BASE.$row['paththumb']);
						if (!$jkv["gallerywatermark"]) {
							$bigpi =  str_replace("//","/",$JAK_UPLOAD_PATH_BASE.$row['pathbig']);
						}
						$origpi =  str_replace("//","/",$JAK_UPLOAD_PATH_BASE.$row['original']);
						// now move the files
						$movefiles[] = rename($smallpi, $smalli);
						if (!$jkv["gallerywatermark"]) {
							$movefiles[] = rename($bigpi, $bigi);
						}
						$movefiles[] = rename($origpi, $origi);
						
						// now errors update db
						$sqlset = '';
						if (!$jkv["gallerywatermark"]) {
						$sqlset = ', pathbig = "'.smartsql($bigidb).'"';
						}
						
						if ($movefiles) {
							$jakdb->query('UPDATE '.$jaktable.' SET paththumb = "'.smartsql($smallidb).'"'.$sqlset.', original = "'.smartsql($origidb).'" WHERE id = "'.smartsql($move).'"');
						}
						
						}
			        }
			  
			 	if (!$result) {
					jak_redirect(BASE_URL.'index.php?p=gallery&sp=e');
				} else {
			        jak_redirect(BASE_URL.'index.php?p=gallery&sp=s');
			    }
			    
			    }
			    
			    if (isset($defaults['delete'])) {
			    
			    $delphoto = $defaults['jak_delete_gallery'];
			
			        for ($i = 0; $i < count($delphoto); $i++) {
			            $jakdelphoto = $delphoto[$i];
			            
			            $result = $jakdb->query('SELECT catid, paththumb, pathbig, original FROM '.$jaktable.' WHERE id = "'.smartsql($jakdelphoto).'"');
			            $row = $result->fetch_assoc();
			            	
			            $jakdb->query('UPDATE '.$jaktable1.' SET count = count - 1 WHERE id = "'.smartsql($row['catid']).'"');
			            
			            $jakdb->query('DELETE FROM '.$jaktable2.' WHERE galleryid = "'.smartsql($jakdelphoto).'"');
			            $result = $jakdb->query('DELETE FROM '.$jaktable.' WHERE id = "'.smartsql($jakdelphoto).'"');
			        	
			        	// Delete Files
						if (is_file($JAK_UPLOAD_PATH_BASE . $row['paththumb'])) {
						    unlink($JAK_UPLOAD_PATH_BASE . $row['paththumb']);
						}
						
						if (is_file($JAK_UPLOAD_PATH_BASE . $row['pathbig'])) {
						    unlink($JAK_UPLOAD_PATH_BASE . $row['pathbig']);
						}
						    
						if (is_file($JAK_UPLOAD_PATH_BASE . $row['original'])) {
							unlink($JAK_UPLOAD_PATH_BASE . $row['original']);
						}
			            
			        }
			  
			 	if (!$result) {
					jak_redirect(BASE_URL.'index.php?p=gallery&sp=e');
				} else {
			        jak_redirect(BASE_URL.'index.php?p=gallery&sp=s');
			    }
			    
			    }
			
			 }
			
			// get all gallerys out
			$getTotal = jak_get_total($jaktable, '', '', '');
			
			if ($getTotal != 0) {
				// Paginator
				$pages = new JAK_Paginator;
				$pages->items_total = $getTotal;
				$pages->mid_range = $jkv["adminpagemid"];
				$pages->items_per_page = $jkv["adminpageitem"];
				$pages->jak_get_page = $page1;
				$pages->jak_where = 'index.php?p=gallery';
				$pages->paginate();
				$JAK_PAGINATE = $pages->display_pages();
				
				// Get the photos
				$JAK_GALLERY_ALL = jak_get_gallerys($pages->limit, '', $jaktable);
			
			}
			
			// Title and Description
			$SECTION_TITLE = $tlgal["gallery"]["m1"];
			$SECTION_DESC = $tlgal["gallery"]["t"];
			
			// Call the template
			$plugin_template = 'plugins/gallery/admin/template/gallery.php';
		}
}
?>