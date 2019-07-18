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
if (!JAK_USERID || !$jakuser->jakModuleaccess(JAK_USERID,JAK_ACCESSNEWSLETTER)) jak_redirect(BASE_URL);

// All the tables we need for this plugin
$success = array(); // put the error in a array
$jaktable = DB_PREFIX.'newsletter';
$jaktable1 = DB_PREFIX.'newslettergroup';
$jaktable2 = DB_PREFIX.'newsletteruser';
$jaktable3 = DB_PREFIX.'newsletterstat';

// Get newsletter skins
function jak_get_themes($styledir) {

if ($handle = opendir($styledir)) {

    /* This is the correct way to loop over the directory. */
    while (false !== ($template = readdir($handle))) {
    if ($template != '.' && $template != '..' && is_dir($styledir.'/'.$template) ) {
	    $getstyle[] = $template;
	    
    }
    }
	return $getstyle;
	clearstatcache();
    closedir($handle);
}
}

// Now start with the plugin use a switch to access all pages
switch ($page1) {

	// Create new newsletter
	case 'new':
				
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $defaults = $_POST;
		    
		    if (isset($defaults['save'])) {
		
		    if (empty($defaults['jak_title'])) {
		        $errors['e1'] = $tl['error']['e2'];
		    }
		    
		    if (isset($defaults['jak_showdate'])) {
		    	$showdate = $defaults['jak_showdate'];
		    } else {
		    	$showdate = '0';
		    }
		    
		    if (count($errors) == 0) {
		    
		    	$random = substr(number_format(time() * rand(), 0, '', ''), 0, 10);
		
				$result = $jakdb->query('INSERT INTO '.$jaktable.' SET 
				title = "'.smartsql($defaults['jak_title']).'",
				content = "'.smartsql($defaults['jak_content']).'",
				showdate = "'.smartsql($showdate).'",
				time = NOW(),
				fullview = "'.smartsql($random).'"');
				
				$rowid = $jakdb->jak_last_id();
		
			if (!$result) {
			    jak_redirect(BASE_URL.'index.php?p=newsletter&sp=new&ssp=e');
			} else {
		        jak_redirect(BASE_URL.'index.php?p=newsletter&sp=edit&ssp='.$rowid.'&sssp=s');
		    }
		    
		 } else {
		   	$errors['e'] = $tl['error']['e'];
		    $errors = $errors;
		    }
		}
		}
		
		// Get all styles in the directory
		$theme_files = jak_get_themes('../plugins/newsletter/skins/');
		
		// Title and Description
		$SECTION_TITLE = $tlnl["nletter"]["m2"];
		$SECTION_DESC = $tlnl["nletter"]["t1"];
		
		// Call the template
		$plugin_template = 'plugins/newsletter/admin/template/new.php';
	
	break;
	case 'preview':
	
		if (is_numeric($page2) && jak_row_exist($page2,$jaktable)) {
		
			// Get the newsletter
			$JAK_FORM_DATA = jak_get_data($page2, $jaktable);
			
			// Call the template
			$plugin_template = 'plugins/newsletter/admin/template/preview.php';
		
		} else {
		   	jak_redirect(BASE_URL.'index.php?p=newsletter&sp=new&ssp=ene');
		}
		
	break;
	case 'stat':
	
		if (is_numeric($page2) && jak_row_exist($page2,$jaktable3)) {
		
			$result = $jakdb->query('SELECT senttotal, notsent, notsentcms, notsenttotal, nlgroup, cmsgroup, time FROM '.$jaktable3.' WHERE nlid = "'.smartsql($page2).'" ORDER BY time DESC LIMIT 5');
			while ($row = $result->fetch_assoc()) {
			
				// Reset all
				$nlgroup = '';
				$nluser = '';
				$cmsgroup = '';
				$cmsuser = '';
			
				// Get the newsletter groups
				if ($row["nlgroup"]) {
					$result1 = $jakdb->query('SELECT id, name FROM '.$jaktable1.' WHERE id IN('.$row["nlgroup"].')');
					while ($row1 = $result1->fetch_assoc()) {
					
						$nlgroup[] = '<a href="index.php?p=newsletter&amp;sp=usergroup&amp;ssp=edit&amp;sssp='.$row1["id"].'">'.$row1['name'].'</a>';
					
					}
					
					if (!empty($nlgroup)) $nlgroup = join(", ", $nlgroup);
				}
				
				// Get the newsletter user not sent
				if ($row["notsent"]) {
					$result2 = $jakdb->query('SELECT id, email, name FROM '.$jaktable2.' WHERE id IN('.$row["notsent"].')');
					while ($row2 = $result2->fetch_assoc()) {
					
						$nluser[] = '<a href="index.php?p=newsletter&amp;sp=user&amp;ssp=edit&amp;sssp='.$row2["id"].'">'.$row2["name"].' ('.$row2["email"].')</a> <a href="index.php?p=newsletter&amp;sp=user&amp;ssp=delete&amp;sssp='.$row2["id"].'" onclick="if(!confirm(\''.$tl["user"]["al"].'\'))return false;" class="btn btn-default btn-xs"><i class="fa fa-trash-o"></i></a>';
					
					}
					
					if (!empty($nluser)) $nluser = join(", ", $nluser);
				}
				
				// Get the cms groups
				if ($row["cmsgroup"]) {
					$result3 = $jakdb->query('SELECT id, name FROM '.DB_PREFIX.'usergroup WHERE id IN('.$row["cmsgroup"].')');
					while ($row3 = $result3->fetch_assoc()) {
					
						$cmsgroup[] = '<a href="index.php?p=usergroup&amp;sp=edit&amp;ssp="'.$row3["id"].'>'.$row3['name'].'</a>';
					
					}
					
					if (!empty($cmsgroup)) $cmsgroup = join(", ", $cmsgroup);
				}
				
				// Get the cms user not sent
				if ($row["notsentcms"]) {
					$result4 = $jakdb->query('SELECT id, username, email FROM '.DB_PREFIX.'user WHERE id IN('.$row["notsentcms"].')');
					while ($row4 = $result4->fetch_assoc()) {
					
						$cmsuser[] = '<a href="index.php?p=user&amp;sp=edit&amp;ssp="'.$row4["id"].'>'.$row4["name"].'('.$row4["email"].')</a>';
					
					}
					
					if (!empty($cmsuser)) $cmsuser = join(", ", $cmsuser);
				}
				
			    $jakdata[] = array('total' => $row['senttotal'], 'notsent' => $row['notsenttotal'], 'time' => $row['time'], 'nlgroup' => $nlgroup, 'nluser' => $nluser, 'cmsgroup' => $cmsgroup, 'cmsuser' => $cmsuser);
			}
		
			// Get the newsletter
			$JAK_STAT_DATA = $jakdata;
			
			// Get the newsletter
			$JAK_FORM_DATA = jak_get_data($page2, $jaktable);
			
			// Title and Description
			$SECTION_TITLE = $tlnl["nletter"]["d10"];
			$SECTION_DESC = $tlnl["nletter"]["t6"];
		
			// Call the template
			$plugin_template = 'plugins/newsletter/admin/template/stat.php';
		
		} else {
		   	jak_redirect(BASE_URL.'index.php?p=newsletter&sp=new&ssp=ene');
		}
		
	break;
	case 'send':
	
		if (is_numeric($page2) && jak_row_exist($page2,$jaktable)) {
		
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				$defaults = $_POST;
				
				if (empty($defaults['jak_nlgroup']) && empty($defaults['jak_cmsgroup'])) {
				    $errors['e1'] = $tlnl['nletter']['e2'];
				}
				
				if (empty($defaults['jak_send'])) {
				    $errors['e2'] = $tlnl['nletter']['e3'];
				}
				
				if (count($errors) == 0) {
				
				// Get the newsletter
				$result = $jakdb->query('SELECT id, title, content, fullview FROM '.$jaktable.' WHERE id = "'.smartsql($page2).'"');
				if ($jakdb->affected_rows > 0) {
					$row = $result->fetch_assoc();
				    
				    // Get the title/subject
				    $subject = $row['title'];
				    
				    // Get the cat var name
				    $resultc = $jakdb->query('SELECT varname FROM '.DB_PREFIX.'categories WHERE pluginid = '.JAK_PLUGIN_NEWSLETTER);
				    $rowc = $resultc->fetch_assoc();
				    
				    // Get the browserversion
				    $fullversion = (JAK_USE_APACHE ? substr(BASE_URL_ORIG, 0, -1) : BASE_URL_ORIG).html_entity_decode(JAK_rewrite::jakParseurl($rowc['varname'], 'fv', $row['id'], $row['fullview'], ''));
				    
				    // Set vars to zero
				    $countNL = 0;
				    $notsNL = 0;
				    $countnsNL = 0;
				    
				    // start the mail client
				    $mail = new PHPMailer();
				
				// Send email the smpt way or else the mail way
				if ($jkv["nlsmtp_mail"]) {
				
					$mail->IsSMTP(); // telling the class to use SMTP
					$mail->Host = $jkv["nlsmtphost"];
					$mail->SMTPAuth = ($jkv["nlsmtp_auth"] ? true : false); // enable SMTP authentication
					$mail->SMTPSecure = $jkv["nlsmtp_prefix"]; // sets the prefix to the server
					$mail->SMTPKeepAlive = ($jkv["nlsmtp_alive"] ? true : false); // SMTP connection will not close after each email sent
					$mail->Port = $jkv["nlsmtpport"]; // set the SMTP port for the GMAIL server
					$mail->Username = base64_decode($jkv["nlsmtpusername"]); // SMTP account username
					$mail->Password = base64_decode($jkv["nlsmtppassword"]);        // SMTP account password
					$mail->SetFrom($jkv["nlemail"], $jkv["title"]);
					$mail->AddReplyTo($jkv["nlemail"], $jkv["title"]);
					$mail->AltBody = $tlnl["nletter"]["d40"]; // optional, comment out and test
					$mail->Subject = $subject;
					
				} else {
				
					$mail->SetFrom($jkv["nlemail"], $jkv["title"]);
					$mail->AddReplyTo($jkv["nlemail"], $jkv["title"]);
					$mail->AltBody = $tlnl["nletter"]["d40"]; // optional, comment out and test
					$mail->Subject = $subject;
				
				}
				
				if (!empty($defaults['jak_nlgroup'])) {
					$nlgroup = $defaults['jak_nlgroup'];
				
				for ($i = 0; $i < count($nlgroup); $i++) {
				     $lettergroup = $nlgroup[$i];
				     
				     // Get the group into an array
				     $lgroup[] = $lettergroup;
				     
				     $result1 = $jakdb->query('SELECT id, name, email, delcode FROM '.$jaktable2.' WHERE usergroupid = "'.$lettergroup.'"');
				         	
				     while ($row1 = $result1->fetch_assoc()) {
				     
				     	// Get the delete code for each user
				     	$unsubscribe = (JAK_USE_APACHE ? substr(BASE_URL_ORIG, 0, -1) : BASE_URL_ORIG).html_entity_decode(JAK_rewrite::jakParseurl($rowc['varname'], 'nlo', $row1['delcode'], '', ''));
				     	
				     	// Change fake vars into real ones.
				     	$cssAtt = array('{myweburl}', '{mywebname}', '{browserversion}', '{unsubscribe}', '{username}', '{fullname}', '{useremail}');
				     	$cssUrl   = array(BASE_URL_ORIG, $jkv["title"], $fullversion, $unsubscribe, $row1['name'], $row1['name'], $row1['email']);
				     	$nlcontent = str_replace($cssAtt, $cssUrl, $row['content']);
				     	
				     	// Get the body into the right format
				     	$body = str_ireplace("[\]", '', $nlcontent);
					    
					    $mail->MsgHTML($body);
					    $mail->AddAddress($row1["email"], $row1["name"]);
					    
					      if(!$mail->Send()) {
					      	$countnsNL++;
					      	$notsNL[] = $row1['id'];
					      } else {
					      	$countNL++;
					        $newslettersent = 1;
					      }
					      
					      // Clear all addresses and attachments for next loop
					      $mail->ClearAddresses();
				     }
				}
				}
				
				if (!empty($defaults['jak_cmsgroup'])) {
					$usergroup = $defaults['jak_cmsgroup'];
				
				for ($i = 0; $i < count($usergroup); $i++) {
				     $ugroup = $usergroup[$i];
				     
				     // Get the groups into an array
				     $cmsgroup[] = $ugroup;
				          
				     $result2 = $jakdb->query('SELECT id, username, name, email FROM '.DB_PREFIX.'user WHERE usergroupid = "'.smartsql($ugroup).'" AND newsletter != 0');
				              	
				     while ($row2 = $result2->fetch_assoc()) {
				     
				     	// Get the delete code for each user
				     	$unsubscribe = (JAK_USE_APACHE ? substr(BASE_URL_ORIG, 0, -1) : BASE_URL_ORIG).html_entity_decode(JAK_rewrite::jakParseurl($rowc['varname'], 'nlom', $row2['id'], '', ''));
				     	
				     	// Change fake vars into real ones.
				     	$cssAtt = array('{myweburl}', '{mywebname}', '{browserversion}', '{unsubscribe}', '{username}', '{fullname}', '{useremail}');
				     	$cssUrl   = array(BASE_URL_ORIG, $jkv["title"], $fullversion, $unsubscribe, $row2['username'], $row2['name'], $row2['email']);
				     	$nlcontent = str_replace($cssAtt, $cssUrl, $row['content']);
				     	
				     	// Get the body into the right format
				     	$body = str_ireplace("[\]", '', $nlcontent);
				        
				        $mail->MsgHTML($body);
				        $mail->AddAddress($row2["email"], $row2["username"]);
				        
				          if(!$mail->Send()) {
				          	echo "Mailer Error: " . $mail->ErrorInfo;
				          	$countnsNL++;
				          	$notsNLu[] = $row2['id'];
				          } else {
				          	$countNL++;
				            $sUMail = 1;
				          }
				          
				          // Clear all addresses and attachments for next loop
				          $mail->ClearAddresses();
				     }
				     }
				     }
				
				if ($sUMail || $newslettersent) {
					$_SESSION['newsletter_sent_admin'] = 1;
					
					// Update newsletter to sent
					$jakdb->query('UPDATE '.$jaktable.' SET sent = 1, senttime = NOW() WHERE id = "'.smartsql($page2).'"');
					
					// Write statistic file
					if (!empty($notsNL)) $notsNL = join(",", $notsNL);
					if (!empty($notsNLu)) $notsNLu = join(",", $notsNLu);
					if (!empty($lgroup)) $lgroup = join(",", $lgroup);
					if (!empty($cmsgroup)) $cmsgroup = join(",", $cmsgroup);
					
					// write into stat db
					$jakdb->query('INSERT INTO '.$jaktable3.' SET 
					nlid = "'.smartsql($row["id"]).'",
					senttotal = "'.smartsql($countNL).'",
					notsent = "'.smartsql($notsNL).'",
					notsentcms = "'.smartsql($notsNLu).'",
					notsenttotal = "'.smartsql($countnsNL).'",
					nlgroup = "'.smartsql($lgroup).'",
					cmsgroup = "'.smartsql($cmsgroup).'",
					time = NOW()');
					
					// Now redirect to the success page
					jak_redirect(BASE_URL.'index.php?p=newsletter&sp=send&ssp='.$page2.'&sssp=s');
				}
				
				}
				
				} else {
				   $errors['e'] = $tl['error']['e'];
				   $errors = $errors;
				}
				
			}
			
			// Get usergroups newsletter
			$JAK_USERGROUP_ALL = jak_get_usergroup_all('newslettergroup');
			
			// Get usergroups cms
			$JAK_USERGROUP_CMS = jak_get_usergroup_all('usergroup');
			
			// Title and Description
			$SECTION_TITLE = $tlnl["nletter"]["d7"];
			$SECTION_DESC = $tlnl["nletter"]["t5"];
			
			// Call the template
			$plugin_template = 'plugins/newsletter/admin/template/send.php';
		
		} else {
		   	jak_redirect(BASE_URL.'index.php?p=newsletter&sp=ene');
		}
	
	break;
	case 'user':
	
		switch ($page2) {
		
		case 'newuser':
		
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			    $defaults = $_POST;
			    
			    if ($defaults['jak_name']) {
			
				    if (empty($defaults['jak_name'])) {
				        $errors['e1'] = $tl['error']['e7'];
				    }
				    
				    if ($defaults['jak_email'] == '' || !filter_var($defaults['jak_email'], FILTER_VALIDATE_EMAIL)) {
				        $errors['e2'] = $tl['error']['e3'];
				    }
				    
				    if (jak_field_not_exist(strtolower($defaults['jak_email']),$jaktable2, 'email')) {
				        $errors['e2'] = $tlnl['nletter']['e4'];
				    }
				    
				    if (count($errors) == 0) {
				
						$result = $jakdb->query('INSERT INTO '.$jaktable2.' SET 
						name = "'.smartsql($defaults['jak_name']).'",
						email = "'.smartsql($defaults['jak_email']).'",
						usergroupid = "'.smartsql($defaults['jak_usergroup']).'",
						delcode = '.time().',
						time = NOW()');
						
						$rowid = $jakdb->jak_last_id();
						
						if (!$result) {
						    jak_redirect(BASE_URL.'index.php?p=newsletter&sp=user&ssp=newuser&sssp=e');
						} else {
						    jak_redirect(BASE_URL.'index.php?p=newsletter&sp=user&ssp=edit&sssp='.$rowid.'&ssssp=s');
						}
					
					}
				
				}
				
				if (!empty($_FILES['jak_file']['name'])) {
				
					$filename = $_FILES['jak_file']['name']; // original filename
					$tempFile = $_FILES['jak_file']['tmp_name'];
					$tmpf = explode(".", $filename);
					$jak_xtension = end($tmpf);
					
					if ($jak_xtension != "csv") {
						$errors['e3'] = $tlnl['nletter']['e'];
					}
				
					if (empty($defaults['jak_delimiter'])) {
					    $errors['e4'] = $tlnl['nletter']['e1'];
					}
					
					if (count($errors) == 0) {
						
						// We start with one
						$row = 1;
						// Now we open the uploaded file and start with the process
						if (($handle = fopen($targetFile, "r")) !== FALSE) {
						    while (($data = fgetcsv($handle, 1000, $defaults['jak_delimiter'])) !== FALSE) {
					     
						        if ($defaults['jak_start'] < $row) {
						        
						        	$random = substr(number_format(time() * rand(), 0, '', ''), 0, 10);
						            $csvI[] = '(NULL, '.$defaults['jak_usergroupcsv'].', "'.$data[1].'", "'.$data[0].'", NOW(), '.$random.')';
						            
						        }
						        $row++;
						    }
						    fclose($handle);
						}
						
						if (!empty($csvI)) $csvI = join(",", $csvI);
						
						$result = $jakdb->query('INSERT INTO '.$jaktable2.' VALUES '.$csvI);
						
						if (!$result) {
						    jak_redirect(BASE_URL.'index.php?p=newsletter&sp=user&ssp=newuser&sssp=e');
						} else {
						
							// Now we delete the temp csv file from the cache directory
							if (is_file($targetFile)) unlink($targetFile);
							
						    jak_redirect(BASE_URL.'index.php?p=newsletter&sp=user&ssp=s');
						}
						
					}			
				
				}
				
				if (count($errors) != 0) {
			   		$errors['e'] = $tl['error']['e'];
			    	$errors = $errors;
			    }
			}
			
			// Get the usergroups
			$JAK_USERGROUP_ALL = jak_get_usergroup_all('newslettergroup');
			
			// Title and Description
			$SECTION_TITLE = $tlnl["nletter"]["m"].' - '.$tl["cmenu"]["c2"];
			$SECTION_DESC = $tl["cmdesc"]["d4"];
			
			// Call the template
			$plugin_template = 'plugins/newsletter/admin/template/newuser.php';
		
		break;
		case 'edit':
		
			if (jak_row_exist($page3, $jaktable2)) {
			
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$defaults = $_POST;
					    
					if (empty($defaults['jak_name'])) {
						$errors['e1'] = $tl['error']['e7'];
					}
					        
					if ($defaults['jak_email'] == '' || !filter_var($defaults['jak_email'], FILTER_VALIDATE_EMAIL)) {
					    $errors['e2'] = $tl['error']['e3'];
					}
					        
					if (count($errors) == 0) {
							    
						$result = $jakdb->query('UPDATE '.$jaktable2.' SET 
						name = "'.smartsql($defaults['jak_name']).'",
						email = "'.smartsql($defaults['jak_email']).'",
						usergroupid = "'.smartsql($defaults['jak_usergroup']).'",
						delcode = '.time().',
						time = NOW()
						WHERE id = '.$page3);
					
						if (!$result) {
							jak_redirect(BASE_URL.'index.php?p=newsletter&sp=user&ssp=edit&sssp='.$page3.'&ssssp=e');
						} else {
							jak_redirect(BASE_URL.'index.php?p=newsletter&sp=user&ssp=edit&sssp='.$page3.'&ssssp=s');
						}
				    
			 			} else {
			    
						   	$errors['e'] = $tl['error']['e'];
						    $errors = $errors;
			    		}
					}
			
					$JAK_FORM_DATA = jak_get_data($page3, $jaktable2);
			
					} else {
					   	jak_redirect(BASE_URL.'index.php?p=newsletter&sp=user&ssp=ene');
					}
		
			// Get the usergroups
			$JAK_USERGROUP_ALL = jak_get_usergroup_all('newslettergroup');
			
			// Title and Description
			$SECTION_TITLE = $tlnl["nletter"]["m"].' - '.$tl["cmenu"]["c3"];
			$SECTION_DESC = $tlnl["nletter"]["t7"];
			
			// Call the template
			$plugin_template = 'plugins/newsletter/admin/template/edituser.php';
		
		break;
		case 'delete':
		
			// Check if user exists and can be deleted
			if (jak_row_exist($page3, $jaktable2)) {
			        
					// Now check how many languages are installed and do the dirty work
					$result = $jakdb->query('DELETE FROM '.$jaktable2.' WHERE id = "'.smartsql($page3).'"');
			
				if (!$result) {
			    	jak_redirect(BASE_URL.'index.php?p=newsletter&sp=user&ssp=e');
				} else {
			        jak_redirect(BASE_URL.'index.php?p=newsletter&sp=user&ssp=s');
			    }
			    
			} else {
			   	jak_redirect(BASE_URL.'index.php?p=newsletter&sp=user&ssp=ene');
			}
		
		break;
		case 'group':
		
			// Important template stuff
			$getTotal = jak_get_total($jaktable2, $page3, 'usergroupid', '');
			if ($getTotal != 0) {
			
				// Paginator
				$pages = new JAK_Paginator;
				$pages->items_total = $getTotal;
				$pages->mid_range = $jkv["adminpagemid"];
				$pages->items_per_page = $jkv["adminpageitem"];
				$pages->jak_get_page = $page1;
				$pages->jak_where = 'index.php?p=newsletter&amp;sp=user&amp;ssp=group';
				$pages->paginate();
				$JAK_PAGINATE = $pages->display_pages();
				}
				
				$result = $jakdb->query('SELECT * FROM '.$jaktable2.' WHERE usergroupid = "'.smartsql($page3).'" '.$pages->limit);
				while ($row = $result->fetch_assoc()) {
				    $user[] = array('id' => $row['id'], 'usergroupid' => $row['usergroupid'], 'username' => $row['username'], 'email' => $row['email'], 'name' => $row['name']);
				}
				
			$JAK_USER_ALL = $user;
			$JAK_USERGROUP_ALL = jak_get_usergroup_all('newslettergroup');
			
			// Title and Description
			$SECTION_TITLE = $tlnl["nletter"]["m"].' - '.$tl["cmenu"]["c3"];
			$SECTION_DESC = $tlnl["nletter"]["t7"];
			
			// Call the template
			$plugin_template = 'plugins/newsletter/admin/template/user.php';
			
		break;
		default:
	
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['jak_delete_user'])) {
			$defaults = $_POST;
			    
			if (isset($defaults['move'])) {
			        
				$jakmove = $defaults['jak_delete_user'];
			    $jakgrid = $defaults['jak_group'];
			        
				for ($i = 0; $i < count($jakmove); $i++) {
			    	$move = $jakmove[$i];
			    	$result = $jakdb->query('UPDATE '.$jaktable2.' SET usergroupid = '.$jakgrid.' WHERE id = "'.smartsql($move).'"');
			    }
			      
			    if (!$result) {
			    	jak_redirect(BASE_URL.'index.php?p=newsletter&sp=user&ssp=e');
			    } else {
			        jak_redirect(BASE_URL.'index.php?p=newsletter&sp=user&ssp=s');
			    }
			        
			 }
			    
			 if (isset($defaults['delete'])) {
			    
			    $lockuser = $defaults['jak_delete_user'];
			
			    for ($i = 0; $i < count($lockuser); $i++) {
			    	$locked = $lockuser[$i];
			        	$jakdb->query('DELETE FROM '.$jaktable2.' WHERE id = "'.smartsql($locked).'"');
					$result = 1;
			    }
			  
			 	if (!$result) {
					jak_redirect(BASE_URL.'index.php?p=newsletter&sp=user&ssp=e');
				} else {
			        jak_redirect(BASE_URL.'index.php?p=newsletter&sp=user&ssp=s');
			    }
			    
			    }
			
			    
			 }
		
			// Important template stuff
			$getTotal = jak_get_total($jaktable2, '', '', '');
			if ($getTotal != 0) {
			
				// Paginator
				$pages = new JAK_Paginator;
				$pages->items_total = $getTotal;
				$pages->mid_range = $jkv["adminpagemid"];
				$pages->items_per_page = $jkv["adminpageitem"];
				$pages->jak_get_page = $page2;
				$pages->jak_where = 'index.php?p=newsletter&amp;sp=user';
				$pages->paginate();
				$JAK_PAGINATE = $pages->display_pages();
				
				$result = $jakdb->query('SELECT * FROM '.$jaktable2.' '.$pages->limit);
				while ($row = $result->fetch_assoc()) {
				    $JAK_USER_ALL[] = array('id' => $row['id'], 'usergroupid' => $row['usergroupid'], 'email' => $row['email'], 'name' => $row['name']);
				}
			
			}
			
			$JAK_USERGROUP_ALL = jak_get_usergroup_all('newslettergroup');
			
			// Title and Description
			$SECTION_TITLE = $tlnl["nletter"]["m"].' - '.$tl["cmenu"]["c2"];
			$SECTION_DESC = $tlnl["nletter"]["t2"];
			
			// Call the template
			$plugin_template = 'plugins/newsletter/admin/template/user.php';
			
		}
		
	break;
	case 'usergroup':
	
		switch ($page2) {
		
			case 'new':
			
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				    $defaults = $_POST;
				
				    if (empty($defaults['jak_name'])) {
				        $errors['e1'] = $tl['error']['e7'];
				    }
				        
				    if (count($errors) == 0) {
				
						$result = $jakdb->query('INSERT INTO '.$jaktable1.' SET 
						name = "'.smartsql($defaults['jak_name']).'",
						description = "'.smartsql($defaults['jak_desc']).'",
						time = NOW()');
						
						$rowid = $jakdb->jak_last_id();
						
						if (!$result) {
						    jak_redirect(BASE_URL.'index.php?p=newsletter&sp=usergroup&ssp=new&sssp=e');
						} else {
						    jak_redirect(BASE_URL.'index.php?p=newsletter&sp=usergroup&ssp=edit&sssp='.$rowid.'&ssssp=s');
						}
				
				 } else {
				   	$errors['e'] = $tl['error']['e'];
				    $errors = $errors;
				 }
				}
				
				// Title and Description
				$SECTION_TITLE = $tlnl["nletter"]["m"].' - '.$tl["cmenu"]["c11"];
				$SECTION_DESC = $tl["cmdesc"]["d15"];
				
				// Call the template
				$plugin_template = 'plugins/newsletter/admin/template/newgroup.php';
			
			break;
			case 'edit':
			
				if (jak_row_exist($page3, $jaktable1)) {
				
					if ($_SERVER['REQUEST_METHOD'] == 'POST') {
						$defaults = $_POST;
						    
						if (empty($defaults['jak_name'])) {
							$errors['e1'] = $tl['error']['e7'];
						}
						        						        
						if (count($errors) == 0) {
								    
							$result = $jakdb->query('UPDATE '.$jaktable1.' SET 
							name = "'.smartsql($defaults['jak_name']).'",
							description = "'.smartsql($defaults['jak_desc']).'",
							time = NOW()
							WHERE id = "'.smartsql($page3).'"');
						
							if (!$result) {
								jak_redirect(BASE_URL.'index.php?p=newsletter&sp=usergroup&ssp=edit&sssp='.$page3.'&ssssp=e');
							} else {
								jak_redirect(BASE_URL.'index.php?p=newsletter&sp=usergroup&ssp=edit&sssp='.$page3.'&ssssp=s');
							}
					    
				 			} else {
				    
							   	$errors['e'] = $tl['error']['e'];
							    $errors = $errors;
				    		}
						}
				
						$JAK_FORM_DATA = jak_get_data($page3, $jaktable1);
				
						} else {
						   	jak_redirect(BASE_URL.'index.php?p=newsletter&sp=usergroup&ssp=ene');
						}
						
				// Title and Description
				$SECTION_TITLE = $tlnl["nletter"]["m"].' - '.$tl["cmenu"]["c12"];
				$SECTION_DESC = $tlnl["nletter"]["t8"];
			
				// Call the template
				$plugin_template = 'plugins/newsletter/admin/template/editgroup.php';
				
			break;
			case 'delete':
				
				// Check if user exists and can be deleted
				if (jak_row_exist($page3, $jaktable1)) {
				        
				        if ($page3 != 1) {
							// Now check how many languages are installed and do the dirty work
							$result = $jakdb->query('DELETE FROM '.$jaktable1.' WHERE id = "'.smartsql($page3).'"');
						} else {
							jak_redirect(BASE_URL.'index.php?p=newsletter&sp=usergroup&ssp=edn');
						}
				
					if (!$result) {
				    	jak_redirect(BASE_URL.'index.php?p=newsletter&sp=usergroup&ssp=e');
					} else {
				        jak_redirect(BASE_URL.'index.php?p=newsletter&sp=usergroup&ssp=s');
				    }
				    
				} else {
				   	jak_redirect(BASE_URL.'index.php?p=newsletter&sp=usergroup&ssp=ene');
				}
				
			break;
			default:
			
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			    $defaults = $_POST;
			    
			    if (isset($defaults['delete'])) {
			
			    if (empty($defaults['jak_name'])) {
			        $errors['e1'] = $tl['error']['e7'];
			    }
			        
			    if (count($errors) == 0) {
			
					$result = $jakdb->query('UPDATE '.$jaktable1.' SET 
					name = "'.smartsql($defaults['jak_name']).'",
					description = "'.smartsql($defaults['jak_desc']).'",
					time = NOW()
					WHERE id = '.$page3);
			
				if (!$result) {
			    	jak_redirect(BASE_URL.'index.php?p=newsletter&sp=usergroup&ssp=e');
				} else {
			        jak_redirect(BASE_URL.'index.php?p=newsletter&sp=usergroup&ssp=s');
			    }
			 } else {
			   	$errors['e'] = $tl['error']['e'];
			    $errors = $errors;
			 }
			 
			 }
			 
			 if (isset($defaults['delete'])) {
			     
			     $lockuser = $defaults['jak_delete_usergroup'];
			 
			         for ($i = 0; $i < count($lockuser); $i++) {
			             $locked = $lockuser[$i];
			             
			            if ($locked != 1) {
			         		$result = $jakdb->query('DELETE FROM '.$jaktable1.' WHERE id = "'.smartsql($locked).'"');
			 			}
			         }
			   
			  	if (!$result) {
			 		jak_redirect(BASE_URL.'index.php?p=newsletter&sp=usergroup&ssp=e');
			 	} else {
			         jak_redirect(BASE_URL.'index.php?p=newsletter&sp=usergroup&ssp=s');
			    }
			     
			}
			 
			 
			}
			
			$JAK_USERGROUP_ALL = jak_get_usergroup_all('newslettergroup');
			
			// Title and Description
			$SECTION_TITLE = $tlnl["nletter"]["m"].' - '.$tl["menu"]["m9"];
			$SECTION_DESC = $tlnl["nletter"]["t3"];
			
			// Call the template
			$plugin_template = 'plugins/newsletter/admin/template/usergroup.php';
		}
	
	break;
	case 'settings':
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $defaults = $_POST;
		    
		    if (isset($defaults['save'])) {
		    
		    if (empty($defaults['jak_title'])) {
		        $errors['e1'] = $tl['error']['e2'];
		    }
		    
		    if (empty($defaults['jak_thankyou'])) {
		        $errors['e2'] = $tl['error']['e6'];
		    }
		    
		    if (!empty($defaults['jak_port']) && !is_numeric($defaults['jak_port'])) {
		        $errors['e3'] = $tl['error']['e15'];
		    }
		    
		    if (!filter_var($defaults['jak_email'], FILTER_VALIDATE_EMAIL)) { 
		    	$errors['e4'] = $tl['error']['e3'];
		    }
		
		    if (count($errors) == 0) {
		    
		    // Do the dirty work in mysql
		    $result = $jakdb->query('UPDATE '.DB_PREFIX.'setting SET value = CASE varname
		    	WHEN "nltitle" THEN "'.smartsql($defaults['jak_title']).'"
		    	WHEN "nlsignoff" THEN "'.smartsql($defaults['jak_description']).'"
		        WHEN "nlthankyou" THEN "'.smartsql($defaults['jak_thankyou']).'"
		        WHEN "nlemail" THEN "'.smartsql($defaults['jak_email']).'"
		        WHEN "nlsmtp_mail" THEN "'.smartsql($defaults['jak_smpt']).'"
		        WHEN "nlsmtphost" THEN "'.smartsql($defaults['jak_host']).'"
		        WHEN "nlsmtpport" THEN "'.smartsql($defaults['jak_port']).'"
		        WHEN "nlsmtp_alive" THEN "'.smartsql($defaults['jak_alive']).'"
		        WHEN "nlsmtp_auth" THEN "'.smartsql($defaults['jak_auth']).'"
		        WHEN "nlsmtp_prefix" THEN "'.smartsql($defaults['jak_prefix']).'"
		        WHEN "nlsmtpusername" THEN "'.base64_encode($defaults['jak_username']).'"
		        WHEN "nlsmtppassword" THEN "'.base64_encode($defaults['jak_password']).'"
		    END
				WHERE varname IN ("nltitle","nlsignoff","nlthankyou","nlemail","nlsmtp_mail","nlsmtphost","nlsmtpport","nlsmtp_alive","nlsmtp_auth","nlsmtp_prefix","nlsmtpusername","nlsmtppassword")');
				
			if (!$result) {
				jak_redirect(BASE_URL.'index.php?p=newsletter&sp=settings&ssp=e');
			} else {
		        jak_redirect(BASE_URL.'index.php?p=newsletter&sp=settings&ssp=s');
		    }
		    } else {
			   	$errors['e'] = $tl['error']['e'];
			    $errors = $errors;
		    }
		    
		    } else {
		    
		    	$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
		    
		    	// Send email the smpt way or else the mail way
		    	if ($jkv["nlsmtp_mail"]) {
		    		
		    		try {
			    		$mail->IsSMTP(); // telling the class to use SMTP
			    		$mail->Host = $jkv["nlsmtphost"];
			    		$mail->SMTPAuth = ($jkv["nlsmtp_auth"] ? true : false); // enable SMTP authentication
			    		$mail->SMTPSecure = $jkv["nlsmtp_prefix"]; // sets the prefix to the server
			    		$mail->SMTPKeepAlive = ($jkv["nlsmtp_alive"] ? true : false); // SMTP connection will not close after each email sent
			    		$mail->Port = $jkv["nlsmtpport"]; // set the SMTP port for the GMAIL server
			    		$mail->Username = base64_decode($jkv["nlsmtpusername"]); // SMTP account username
			    		$mail->Password = base64_decode($jkv["nlsmtppassword"]);        // SMTP account password
			    		$mail->SetFrom($jkv["nlemail"], $jkv["title"]);
			    		$mail->AddReplyTo($jkv["nlemail"], $jkv["title"]);
			    		$mail->AddAddress($jkv["nlemail"], $jkv["title"]);
			    		$mail->AltBody = $tlnl["nletter"]["d40"]; // optional, comment out and test
			    		$mail->Subject = $tlnl["nletter"]["d42"];
			    		$mail->MsgHTML($tlnl["nletter"]["d43"].'SMTP.');
			    		$mail->Send();
			    		$success['e'] = $tlnl["nletter"]["d43"].'SMTP.';
			    	} catch (phpmailerException $e) {
				    	$errors['e'] = $e->errorMessage(); //Pretty error messages from PHPMailer
			    	} catch (Exception $e) {
			    		$errors['e'] = $e->getMessage(); //Boring error messages from anything else!
			    	}
		    		
		    	} else {
		    	
		    		try {
			    		$mail->SetFrom($jkv["nlemail"], $jkv["title"]);
			    		$mail->AddReplyTo($jkv["nlemail"], $jkv["title"]);
			    		$mail->AddAddress($jkv["nlemail"], $jkv["title"]);
			    		$mail->AltBody = $tlnl["nletter"]["d40"]; // optional, comment out and test
			    		$mail->Subject = $tlnl["nletter"]["d42"];
			    		$mail->MsgHTML($tlnl["nletter"]["d43"].'Mail().');
			    		$mail->Send();
			    		$success['e'] = $tlnl["nletter"]["d43"].'Mail().';
		    		} catch (phpmailerException $e) {
		    			$errors['e'] = $e->errorMessage(); //Pretty error messages from PHPMailer
		    		} catch (Exception $e) {
		    		  	$errors['e'] = $e->getMessage(); //Boring error messages from anything else!
		    		}
		    	
		    	}
		    
		    }
		}
		
		// Get the newsletter settings
		$JAK_SETTING = jak_get_setting('newsletter');
		
		// Title and Description
		$SECTION_TITLE = $tlnl["nletter"]["m"].' - '.$tl["menu"]["m2"];
		$SECTION_DESC = $tl["cmdesc"]["d2"];
		
		// Call the template
		$plugin_template = 'plugins/newsletter/admin/template/settings.php';
		
	break;
	default:
		 
		 switch ($page1) {
		    case 'delete':
		    
		        if (is_numeric($page2) && jak_row_exist($page2,$jaktable)) {
					
					$result = $jakdb->query('DELETE FROM '.$jaktable.' WHERE id = "'.smartsql($page2).'"');
		
					if (!$result) {
				    	jak_redirect(BASE_URL.'index.php?p=newsletter&sp=e');
					} else {
				        jak_redirect(BASE_URL.'index.php?p=newsletter&sp=s');
				    }
		    
				} else {
		   			jak_redirect(BASE_URL.'index.php?p=newsletter&sp=ene');
				}
		break;
		case 'edit':
		
			if (is_numeric($page2) && jak_row_exist($page2,$jaktable)) {
		
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			    $defaults = $_POST;
			
			    if (empty($defaults['jak_title'])) {
			        $errors['e1'] = $tl['error']['e2'];
			    }
		    
				if (count($errors) == 0) {
		
					$result = $jakdb->query('UPDATE '.$jaktable.' SET 
					title = "'.smartsql($defaults['jak_title']).'",
					content = "'.smartsql($defaults['jak_content']).'",
					showdate = "'.smartsql($defaults['jak_showdate']).'",
					time = NOW()
					WHERE id = "'.smartsql($page2).'"');
				
					if (!$result) {
				    	jak_redirect(BASE_URL.'index.php?p=newsletter&sp=edit&ssp='.$page2.'&sssp=e');
					} else {
						jak_redirect(BASE_URL.'index.php?p=newsletter&sp=edit&ssp='.$page2.'&sssp=s');
				    }
			    
		 		} else {
				   	$errors['e'] = $tl['error']['e'];
				    $errors = $errors;
		    	}
			}
		
		// Get the newsletter
		$JAK_FORM_DATA = jak_get_data($page2, $jaktable);
		
		// Get the cat var name
		$resultc = $jakdb->query('SELECT varname FROM '.DB_PREFIX.'categories WHERE pluginid = "'.smartsql(JAK_PLUGIN_NEWSLETTER).'"');
		$rowc = $resultc->fetch_assoc();
		
		// Title and Description
		$SECTION_TITLE = $tlnl["nletter"]["m3"];
		$SECTION_DESC = $tlnl["nletter"]["t3"];
		
		// Call the template
		$plugin_template = 'plugins/newsletter/admin/template/edit.php';
		
		} else {
		   	jak_redirect(BASE_URL.'index.php?p=newsletter&sp=ene');
		}
		break;
		default:
		
			// Hello we have a post request
			if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['jak_delete_newsletter'])) {
			    $defaults = $_POST;
			    
			    if (isset($defaults['delete'])) {
			    
			    $lockuser = $defaults['jak_delete_newsletter'];
			
			        for ($i = 0; $i < count($lockuser); $i++) {
			            $locked = $lockuser[$i];
						$result = $jakdb->query('DELETE FROM '.$jaktable.' WHERE id = "'.smartsql($locked).'"');
			        }
			  
			 	if (!$result) {
					jak_redirect(BASE_URL.'index.php?p=newsletter&sp=e');
				} else {
			        jak_redirect(BASE_URL.'index.php?p=newsletter&sp=s');
			    }
			    
			    }
			
			 }
			
			// get all newsletters out
			$getTotal = jak_get_total($jaktable,'','','');
			
			if ($getTotal != 0) {
				// Paginator
				$nletter = new JAK_Paginator;
				$nletter->items_total = $getTotal;
				$nletter->mid_range = $jkv["adminpagemid"];
				$nletter->items_per_page = $jkv["adminpageitem"];
				$nletter->jak_get_page = $page1;
				$nletter->jak_where = 'index.php?p=newsletter';
				$nletter->paginate();
				$JAK_PAGINATE = $nletter->display_pages();
			}
			
			// Title and Description
			$SECTION_TITLE = $tlnl["nletter"]["m1"];
			$SECTION_DESC = $tlnl["nletter"]["t"];
			
			// Newsletter	
			$JAK_NEWSLETTER_ALL = jak_get_page_info($jaktable, $nletter->limit);
			
			// Call the template
			$plugin_template = 'plugins/newsletter/admin/template/newsletter.php';
	}
}
?>