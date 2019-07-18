<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Check the contact page and fire errors or emails
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['contactF'])) {
    $defaults = $_POST;
    $errorsA = false;
	// Errors in Array
    $errorsA = array();
    
    // empty list form
    $listForm = '';
    
    // Check for spam first if wish so
    if (!JAK_USERID) {
    	
    	if ($jkv["hvm"]) {
    		$human_captcha = explode(':#:', $_SESSION['jak_captcha']);
    		if (isset($defaults[$human_captcha[0]]) && ($defaults[$human_captcha[0]] == '' || $defaults[$human_captcha[0]] != $human_captcha[1])) {
    			$errorsA['human'] = $tl['error']['e10'].'<br />';
    		}
    	}
    	   
    }
    
    // Decode the list for security reasons
    $declist = filter_var(base64_decode($defaults['optlist']), FILTER_SANITIZE_STRING);
    $declistname = filter_var($defaults['optlistname'], FILTER_SANITIZE_STRING);
    $declistmand = filter_var(base64_decode($defaults['optlistmandatory']), FILTER_SANITIZE_STRING);
    $declisttype = filter_var(base64_decode($defaults['optlisttype']), FILTER_SANITIZE_STRING);
    
    // Get the list of used optionsid
    $formarray = explode(',', $declist);
    // Get the names out the list
    $formnamearray = explode(',', $declistname);
    // Get the mandatory out the list
    $formmandarray = explode(',', $declistmand);
    // Get the types out the list
    $formtype = explode(',', $declisttype);
    
    // Now run thru the whole form options to get some errors or send the form after with phpmail
    for ($i = 0; $i < count($formarray); $i++) {
    	
    	if ($formmandarray[$i] == 1) {
    	
    		if ($formtype[$i] <= 3) {
	    		if ($defaults[$formarray[$i]] == '') {
	    		    $errorsA[$formarray[$i]] = $tl['error']['e11'].' ('.$formnamearray[$i].')<br />';
	    		}
	    		
	    	} elseif ($formtype[$i] == 4) {
	    		if ($defaults[JAK_Base::jakCleanurl($formnamearray[$i])] == '') {
	    		    $errorsA[JAK_Base::jakCleanurl($formnamearray[$i])] = $tl['error']['e11'].' ('.$formnamearray[$i].')<br />';
	    		}
	    		
    		} elseif ($formtype[$i] == 5) {
    			// Get the types out the list
    			$allext = explode(',', $defaults['ext_'.$formarray[$i]]);
    			// Get the filename and split it for further tests
    			$filename = $_FILES[$formarray[$i]]['name']; // original filename
    			$tmpf = explode(".", $filename);
    			$jak_xtension = end($tmpf);
    			if ($filename == '') {
    			    $errorsA[$formarray[$i]] = $tl['error']['e11'].' ('.$formnamearray[$i].')<br />';
    			}
    			if ($filename != '' && !in_array($jak_xtension, $allext)) {
    			    $errorsA[$formarray[$i]] = $tl['error']['e12'].' ('.$defaults['ext_'.$formarray[$i]].')<br />';
    			}
    			if (in_array($jak_xtension, $allext) && $_FILES[$formarray[$i]]['size'] >= 1000000) {
    				$errorsA[$formarray[$i]] = $tl['error']['e37'].' ('.$filename.')<br />';
    			}
    			
    		} elseif ($formtype[$i] == 6) {
    			if ($defaults[JAK_Base::jakCleanurl($formnamearray[$i])] == '') {
    			    $errorsA[JAK_Base::jakCleanurl($formnamearray[$i])] = $tl['error']['e11'].' ('.$formnamearray[$i].')<br />';
    			}
    			
    		}
    			
    		} elseif ($formmandarray[$i] == 2) {
    			if (!is_numeric($defaults[$formarray[$i]])) {
    		    	$errorsA[$formarray[$i]] = $tl['error']['e13'].' ('.$formnamearray[$i].')<br />';
    			}
    			
    		} elseif ($formmandarray[$i] == 3) {
    			
    			if ($jkv["email_block"]) {
    				$blockede = explode(',', $jkv["email_block"]);
    				if (in_array($defaults[$formarray[$i]], $blockede) || in_array(strrchr($defaults[$formarray[$i]], "@"), $blockede)) {
    					$errorsA[$formarray[$i]] = $tl['error']['e21'].' ('.$formnamearray[$i].')<br />';
    				}
    			}
    			
    			if ($defaults[$formarray[$i]] == '' || !filter_var($defaults[$formarray[$i]], FILTER_VALIDATE_EMAIL)) {
    		    	$errorsA[$formarray[$i]] = $tl['error']['e1'].' ('.$formnamearray[$i].')<br />';
    			}
    		}
    	
    	if (count($errorsA) == 0) {
    	
    	if ($formmandarray[$i] == 3) {
    		$listEmail = filter_var($defaults[$formarray[$i]], FILTER_SANITIZE_EMAIL);
    	}	
    	
    	if ($formtype[$i] <= 3) {
    		$listForm .= $formnamearray[$i].': '.$defaults[$formarray[$i]].'<br />';
    	} elseif ($formtype[$i] == 4 && !empty($defaults[JAK_Base::jakCleanurl($formnamearray[$i])])) {
    		$listForm .= $formnamearray[$i].': '.$defaults[JAK_Base::jakCleanurl($formnamearray[$i])].'<br />';
    	} elseif ($formtype[$i] == 6 && !empty($defaults[JAK_Base::jakCleanurl($formnamearray[$i])])) {
    		$listForm .= $formnamearray[$i].': '.join(', ', $defaults[JAK_Base::jakCleanurl($formnamearray[$i])]).'<br />';
    	} else {
    		if ($_FILES[$formarray[$i]]['tmp_name']) {
	    		$tempFile = $_FILES[$formarray[$i]]['tmp_name'];
	    		$origName = substr($_FILES[$formarray[$i]]['name'], 0, -4);
	    		$name_space = strtolower($_FILES[$formarray[$i]]['name']);
	    		$middle_name = str_replace(" ", "_", $name_space);
	    		$glnrrand = rand(10, 99);
	    		$file = str_replace(".", "_" . $glnrrand . ".", $middle_name);
	    		$targetPath = JAK_FILES_DIRECTORY.'/formattachment/';
	    		$targetFile =  str_replace('//','/',$targetPath).$file;
	    		move_uploaded_file($tempFile,$targetFile);
	    		// Now get all in a list and send it!
	    		$listForm .= 'Attachment: ('.BASE_URL.$targetFile.')<br />';
	    	}
    	}
    	
    	}
    }

    if (count($errorsA) > 0) {
    	
    	/* Outputtng the error messages */
    	if (isset($defaults['jakajax']) && $defaults['jakajax'] == "yes") {
    		header('Cache-Control: no-cache');
    		die('{"status":0, "errors":'.json_encode($errorsA).'}');
    	} else {
    		$errorsA = $errorsA;
    	}
    	
    } else {
    
    	if (isset($listEmail)) {
    		$replypossible = $listEmail;
    	} else {
    		$replypossible = $jkv["email"];
    	}
    	
    	if (isset($listForm)) {
    	
    	// Check if email address exist
    	global $jakdb;
    	$row = $jakdb->queryRow('SELECT content, email FROM '.DB_PREFIX.'contactform WHERE id = "'.smartsql($defaults['formid']).'" LIMIT 1');
    	
    	// Start the phpmailer
        $mail = new PHPMailer(); // defaults to using php "mail()"
        
        // We go for SMTP
        if ($jkv["smtp_or_mail"]) {
        
        	$mail->IsSMTP(); // telling the class to use SMTP
        	$mail->Host = $jkv["smtp_host"];
        	$mail->SMTPAuth = ($jkv["smtp_auth"] ? true : false); // enable SMTP authentication
        	$mail->SMTPSecure = $jkv["smtp_prefix"]; // sets the prefix to the server
        	$mail->SMTPKeepAlive = ($jkv["smtp_alive"] ? true : false); // SMTP connection will not close after each email sent
        	$mail->Port = $jkv["smtp_port"]; // set the SMTP port for the GMAIL server
        	$mail->Username = $jkv["smtp_user"]; // SMTP account username
        	$mail->Password = $jkv["smtp_password"]; // SMTP account password
        
        }
        
        $mail->SetFrom($replypossible);
        $mail->AddAddress($jkv["email"]);
        
        // Yes it does, send it to following address
        if ($row['email']) {
        	$emailarray = explode(',', $row['email']);
        	
        	if (is_array($emailarray)) foreach($emailarray as $ea) { $mail->AddCC($ea); } 
        	
        }
        $mail->Subject = $jkv["title"];
        $mail->MsgHTML($listForm);
        
        if ($mail->Send()) {
        	
        	// Ajax Request
        	if (isset($defaults['jakajax']) && $defaults['jakajax'] == "yes") {
        		
        		$_SESSION['jak_thankyou_msg'] = $row['content'];
        	
        		header('Cache-Control: no-cache');
        		die(json_encode(array('status' => 1, 'html' => $_SESSION['jak_thankyou_msg'])));
        		
        	} else {
        	
	            $_SESSION['jak_thankyou_msg'] = $row['content'];
	            jak_redirect($_SERVER['HTTP_REFERER']);
            
            }
        }
    	}
    }
}

function jak_contact_form_title($jakvar)
{
	// Now get all the options from the choosen form and create the form in html include all the javascript options
	global $jakdb;
	$result = $jakdb->query('SELECT title'.', showtitle FROM '.DB_PREFIX.'contactform WHERE id = "'.$jakvar.'" LIMIT 1');
	$row = $result->fetch_assoc();
	
	return array("title" => $row['title'], "showtitle" => $row['showtitle']);
}
	

function jak_create_contact_form($formid,$jakvar1) {

	
	$jakdata = '';
	
	// Reset each var the while goes thru
	$optarray = $optarrayradio = $selectopt = $radioopt = $optionsel = $optioncheck = $checkopt = '';
	
	// Now get all the options from the choosen form and create the form in html include all the javascript options
	global $jakdb;
	$result = $jakdb->query('SELECT * FROM '.DB_PREFIX.'contactoptions WHERE formid = "'.smartsql($formid).'" ORDER BY forder ASC');
	while ($row = $result->fetch_assoc()) {
		
		// Start with the form
		if ($row['typeid'] == 1) {
			if ($row['mandatory']) {
				$mandatory = ' <i class="fa fa-star"></i>';
			} else {
				$mandatory = '';
			}
			
			$jakdata .= '<div class="form-group"><label class="control-label" for="'.$row['id'].'">'.$row['name'].$mandatory.'</label><input type="text" name="'.$row['id'].'" id="'.$row['id'].'" class="form-control" value="'.(isset($_POST[$row['id']]) ? $_POST[$row['id']] : '').'" placeholder="'.$row['name'].'" /></div>';	
		}
		
		if ($row['typeid'] == 2) {
			if ($row['mandatory']) {
				$mandatory = ' <i class="fa fa-star"></i>';
			} else {
				$mandatory = '';
			}
			
			$jakdata .= '<div class="form-group"><label class="control-label" for="'.$row['id'].'">'.$row['name'].$mandatory.'</label><textarea name="'.$row['id'].'" id="'.$row['id'].'" class="form-control" rows="5">'.(isset($_POST[$row['id']]) ? $_POST[$row['id']] : '').'</textarea></div>';
		}
		
		if ($row['typeid'] == 3) {
			if ($row['mandatory']) {
				$mandatory = ' <i class="fa fa-star"></i>';
			} else {
				$mandatory = '';
			}
			
			$optarray = explode(',', $row['options']);
			
			for ($i = 0; $i < count($optarray); $i++) {
			
				$selectopt .= '<option value="'.$optarray[$i].'"'.($_POST[$row['id']] == $optarray[$i] ? ' selected="selected' : "").'>'.$optarray[$i].'</option>';
			}
			
			$jakdata .= '<div class="form-group"><label class="control-label" for="'.$row['id'].'">'.$row['name'].$mandatory.'</label><select name="'.$row['id'].'" id="'.$row['id'].'" class="form-control"><option value="">'.$jakvar1.'</option>'.$selectopt.'</select></div>';	
		}
		
		if ($row['typeid'] == 4) {
			if ($row['mandatory']) {
				$mandatory = ' <i class="fa fa-star"></i>';
			} else {
				$mandatory = '';
			}
			
			$optarrayradio = explode(',', $row['options']);
			
			$cleanName = JAK_Base::jakCleanurl($row['name']);
			
			for ($i = 0; $i < count($optarrayradio); $i++) {
				
				if ($i ==0) {
					$radioopt .= '<div class="radio"><label><input type="radio" name="'.$cleanName.'" id="'.$cleanName.'" value="'.$optarrayradio[$i].'"'.($_POST[$cleanName] == $optarrayradio[$i] ? ' checked="checked"' : "").'> '.$optarrayradio[$i].' </label></div>';
				} else {
					$radioopt .= '<div class="radio"><label><input type="radio" name="'.$cleanName.'" value="'.$optarrayradio[$i].'"'.($_POST[$cleanName] == $optarrayradio[$i] ? ' checked="checked"' : "").'> '.$optarrayradio[$i].'</label></div>';
				}
			}
			
			$jakdata .= '<div class="form-group"><label class="control-label" for="'.$cleanName.'">'.$row['name'].$mandatory.'</label>'.$radioopt.'</div>';	
		}
		
		if ($row['typeid'] == 5) {
			if ($row['mandatory']) {
				$mandatory = ' <i class="fa fa-star"></i>';
			} else {
				$mandatory = '';
			}
			
			$jakdata .= '<div class="form-group"><label class="control-label" for="'.$row['id'].'">'.$row['name'].$mandatory.' ('.$row['options'].')</label><input type="file" title="'.$row['mandatory'].'" name="'.$row['id'].'" /></div>';
			
			$jakdata .= '<input type="hidden" name="ext_'.$row['id'].'" value="'.$row['options'].'" /><input type="hidden" name="MAX_FILE_SIZE" value="1000000" />';
		}
		
		if ($row['typeid'] == 6) {
			if ($row['mandatory']) {
				$mandatory = ' <i class="fa fa-star"></i>';
			} else {
				$mandatory = '';
			}
			
			$optarray = explode(',', $row['options']);
			
			for ($i = 0; $i < count($optarray); $i++) {
			
				if ($i) {
				
					$getridc = JAK_Base::jakCleanurl($row['name'].'_'.$i);
						
				} else {
					$getridc = JAK_Base::jakCleanurl($row['name']);
				}
				
					$cleanName = JAK_Base::jakCleanurl($row['name']);
			
					$checkopt .= '<div class="checkbox"><label><input type="checkbox" name="'.$cleanName.'[]" id="'.$getridc.'" value="'.$optarray[$i].'"'.(is_array($_POST[$row['name']]) && in_array($optarray[$i], $_POST[$cleanName]) ? ' checked="checked"' : "").'> '.$optarray[$i].'</label></div>';
					
			}
			
			$jakdata .= '<div class="form-group"><label class="control-label" for="'.$cleanName.'">'.$row['name'].$mandatory.'</label>'.$checkopt.'</div>';
			
		}
		
		if ($row['typeid'] == 7) {

			
			$jakdata .= $row['name'];
			
		}
		
		$alloptionid[] = $row['id'];
		$alloptionnames[] = $row['name'];
		$alloptionmandatory[] = $row['mandatory'];
		$alloptiontype[] = $row['typeid'];
		
	}
			// Get all options id in one list to recheck after in php
			if (!empty($alloptionid)) {
				$optlist = join(",", $alloptionid);
			}
			
			// Get all options names in one list to recheck after in php
			if (!empty($alloptionnames)) {
				$optlistname = join(",", $alloptionnames);
			}
			
			// Get all mandatory fields in one list to recheck after in php
			if (!empty($alloptionmandatory)) {
				$optlistmandatory = join(",", $alloptionmandatory);
			}
			
			// Get all options types in one list to recheck after in php
			if (!empty($alloptiontype)) {
				$optlisttype = join(",", $alloptiontype);
			}
			
			$jakdata .= '<input type="hidden" name="optlist" value="'.base64_encode($optlist).'" />';
			$jakdata .= '<input type="hidden" name="optlistname" value="'.$optlistname.'" />';
			$jakdata .= '<input type="hidden" name="optlistmandatory" value="'.base64_encode($optlistmandatory).'" />';
			$jakdata .= '<input type="hidden" name="optlisttype" value="'.base64_encode($optlisttype).'" />';
			$jakdata .= '<input type="hidden" name="formid" value="'.$formid.'" />';
	
	return $jakdata;
}

?>