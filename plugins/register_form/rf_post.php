<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Reset some vars
$errorsA = $errorsC = array();

// Check the register page and fire errors or emails
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['registerF'])) {
    $defaults = $_POST;
	// Create Session, so contact form can only used once
    $_SESSION['rf_msg_sent'] = -1;
    // User table
    $jaktable = DB_PREFIX.'user';
    // spam check
    $spamcheck = true;
    
    if (!JAK_USERID && $jkv["hvm"] && isset($_SESSION['jak_captcha'])) {
    		
    	$human_captcha = explode(':#:', $_SESSION['jak_captcha']);
    		
    	if (isset($defaults[$human_captcha[0]]) && ($defaults[$human_captcha[0]] == '' || $defaults[$human_captcha[0]] != $human_captcha[1])) {
    		$errorsA['human'] = $tl['error']['e10'].'<br />';
    	}
    }
    
    // Decode the list for security reasons
    $declist = base64_decode($defaults['optlist']);
    $declistname = $defaults['optlistname'];
    $declistmand = base64_decode($defaults['optlistmandatory']);
    $declisttype = base64_decode($defaults['optlisttype']);
    
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
    
    	// First we check username and email
    	if ($formarray[$i] == 1) {
    	
    		if (empty($defaults[$formarray[$i]])) {
    		    $errors['e3'] = $tl['error']['e14'].'<br />';
    		}
    		
    		if (!preg_match('/^([a-zA-Z0-9\-_])+$/', $defaults[$formarray[$i]])) {
    			$errors['e3'] = $tl['error']['e15'].'<br />';
    		}
    		
    		if (jak_field_not_exist(strtolower($defaults[$formarray[$i]]),$jaktable, 'username')) {
    		    $errors['e3'] = $tl['error']['e16'].'<br />';
    		}
    		
    		if ($jkv["username_block"]) {
    			$blockusrname = explode(',', $jkv["username_block"]);
	    		if (in_array(strtolower($defaults[$formarray[$i]]), $blockusrname)) {
	    			$errors['e3'] = $tl['error']['e25'].'<br />';
	    		}
	    	}
    		
    		$username = $defaults[$formarray[$i]];
    	
    	}
    	
    	// Check email if it is double - error
    	if ($formarray[$i] == 2) {
    		
    		// Check if email address is valid
    		if (!filter_var($defaults[$formarray[$i]], FILTER_VALIDATE_EMAIL)) {
    		    $errors['e4'] = $tl['error']['e1'].'<br />';
    		}
    		
    		// Check if email address has been blocked
    		if ($jkv["email_block"]) {
    			$blockede = explode(',', $jkv["email_block"]);
    			if (in_array($defaults[$formarray[$i]], $blockede) || in_array(strrchr($defaults[$formarray[$i]], "@"), $blockede)) {
    				$errors['e4'] = $tl['error']['e21'].'<br />';
    			}
    		}
    		
    		// Check if email address is double
    		if (jak_field_not_exist(filter_var($defaults[$formarray[$i]], FILTER_SANITIZE_EMAIL), $jaktable, 'email')) {
    		    	$errors['e4'] = $tl['error']['e38'].'<br />';
    		}
    		
    		$email = $defaults[$formarray[$i]];
    	
    	}
    	
    	// Check the password
    	if ($formarray[$i] == 3) {
    	
    		if (strlen($defaults[$formarray[$i]]) <= '7') {
    			$errors['e5'] = $tl['error']['e18'].'<br />';
    		}
    		
    		$password = $defaults[$formarray[$i]];
    	
    	}
    	
    	// Now check the rest of the fields
    	if ($formarray[$i] > 3) {
    	if ($formmandarray[$i] == 1) {
    		if ($formtype[$i] <= 3) {
	    		if ($defaults[$formarray[$i]] == '') {
	    		    $errorsA[$i] = $tl['error']['e11'].' ('.$formnamearray[$i].')<br />';
	    		}
	    	} elseif ($formtype[$i] == 4) {
	    		if ($defaults[$formnamearray[$i]] == '') {
	    		    $errorsA[$i] = $tl['error']['e11'].' ('.$formnamearray[$i].')<br />';
	    		}
    		} 
    	} elseif ($formmandarray[$i] == 2) {
    		if (!is_numeric($defaults[$formarray[$i]])) {
    		    $errorsA[$i] = $tl['error']['e13'].' ('.$formnamearray[$i].')<br />';
    		}
    	} elseif ($formmandarray[$i] == 3) {
    		if ($defaults[$formarray[$i]] == '' || !filter_var($defaults[$formarray[$i]], FILTER_VALIDATE_EMAIL)) {
    		    $errorsA[$i] = $tl['error']['e1'].' ('.$formnamearray[$i].')<br />';
    		}
    	} elseif ($formmandarray[$i] == 5) {
    		// Check if value does not exist
    		if ($defaults[$formarray[$i]] == ''|| jak_field_not_exist(filter_var($defaults[$formarray[$i]], FILTER_SANITIZE_EMAIL), $jaktable, strtolower(preg_replace("/[^a-zA-Z0-9]+/", "", $formnamearray[$i])).'_'.$formarray[$i])) {
    		    	$errorsA[$i] = sprintf($tl['error']['e17'],$formnamearray[$i]).'<br />';
    		}
    	}
    	}
    	
    	if (count($errorsA) == 0) {
    	
    	if ($formarray[$i] > 3) {
    	
    	if ($formmandarray[$i] == 3) {
    		$listEmail = $defaults[$formarray[$i]];
    	}
    	
    	$insert = '';
    	if ($formtype[$i] <= 3) {
    		$insert .= strtolower(preg_replace("/[^a-zA-Z0-9]+/", "", $formnamearray[$i])).'_'.$formarray[$i].' = "'.$defaults[$formarray[$i]].'",';
    	} else {
    		$insert .= strtolower(preg_replace("/[^a-zA-Z0-9]+/", "", $formnamearray[$i])).'_'.$formarray[$i].' = "'.$defaults[$formnamearray[$i]].'",';
    	}
    	
    	}
    	
    	}
    }
    
    if ($jkv["rf_simple"] && $spamcheck) {
    
    		if (empty($defaults['username'])) {
    		    $errors['e3'] = $tl['error']['e14'].'<br />';
    		}
    		
    		if (!preg_match('/^([a-zA-Z0-9\-_])+$/', $defaults['username'])) {
    			$errors['e3'] = $tl['error']['e15'].'<br />';
    		}
    		
    		if (jak_field_not_exist(strtolower($defaults['username']),$jaktable, 'username')) {
    		    $errors['e3'] = $tl['error']['e16'].'<br />';
    		}
    		
    		$username = $defaults['username'];
    	
    		if (!filter_var($defaults['email'], FILTER_VALIDATE_EMAIL)) {
    		    $errors['e4'] = $tl['error']['e1'].'<br />';
    		}
    		
    		// Check if email address has been blocked
    		if ($jkv["email_block"]) {
    			$blockede = explode(',', $jkv["email_block"]);
    			if (in_array($defaults['email'], $blockede) || in_array(strrchr($defaults['email'], "@"), $blockede)) {
    				$errors['e4'] = $tl['error']['e21'].'<br />';
    			}
    		}
    		
    		if (jak_field_not_exist(filter_var($defaults['email'], FILTER_SANITIZE_EMAIL), $jaktable, 'email')) {
    		    	$errors['e4'] = $tl['error']['e38'].'<br />';
    		}
    		
    		$email = $defaults['email'];
    
    }

    if (count($errorsA) > 0 || count($errors) > 0) {
        $errorsA = $errorsA;
        $errorsC = $errors;
    } else {
    
    	if (!isset($_SESSION['rf_thankyou_msg'])) {
    	
    		if ($jkv["rf_simple"]) $password = jak_password_creator();
    		    		
    		// The new password encrypt with hash_hmac
    		$passcrypt = hash_hmac('sha256', $password, DB_PASS_HASH);
    		$sqlupdatepass = 'password = "'.$passcrypt.'",';
    		    
    		$safeusername = filter_var($username, FILTER_SANITIZE_STRING);
    		$safeemail = filter_var($email, FILTER_SANITIZE_EMAIL);
    		    
    		if ($jkv["rf_confirm"] > 1) {
    			$getuniquecode = time();
    		    $insert .= 'activatenr = "'.$getuniquecode.'",';
    		}
    		
    		$result = $jakdb->query('INSERT INTO '.$jaktable.' SET 
    		username = "'.smartsql($safeusername).'",
    		name = "'.smartsql($safeusername).'",
    		email = "'.smartsql($safeemail).'",
    		usergroupid = "'.smartsql($jkv["rf_usergroup"]).'",
    		'.$sqlupdatepass.'
    		'.$insert.'
    		access = "'.smartsql($jkv["rf_confirm"]).'",
    		time = NOW()');
    		
    		$row['id'] = $jakdb->jak_last_id();
    		
    		if (!$result) {
    		    	jak_redirect(JAK_PARSE_ERROR);
    			} else {
    			
    			$newuserpath = JAK_FILES_DIRECTORY.'/userfiles'.'/'.$row['id'];
    			
    			if (!is_dir($newuserpath)) {
    			                @mkdir($newuserpath, 0777);
    			                @copy(JAK_FILES_DIRECTORY.'/userfiles'."/index.html", $newuserpath."/index.html");
    			}
    			
    			if ($jkv["rf_confirm"] == 2 || $jkv["rf_confirm"] == 3) {
    			
    				$confirmlink = '<br><strong>'.$tl['login']['l11'].':</strong> <a href="'.(JAK_USE_APACHE ? substr(BASE_URL, 0, -1) : BASE_URL).JAK_rewrite::jakParseurl('rf_ual', $row['id'], $getuniquecode, $safeusername, '').'">'.(JAK_USE_APACHE ? substr(BASE_URL, 0, -1) : BASE_URL).JAK_rewrite::jakParseurl('rf_ual', $row['id'], $getuniquecode, $safeusername, '').'</a>';
    				
    				if ($jkv["rf_simple"]) $confirmlink .= '<br /><strong>'.$tl['login']['l2'].':</strong> '.$password;
    			
    				$mail = new PHPMailer(); // defaults to using php "mail()"
    				$linkmessage = $jkv["rf_welcome"].$confirmlink;
    				$body = str_ireplace("[\]",'',$linkmessage);
    				
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
    					$mail->SetFrom($jkv["email"]);
    				
    				} else {
    					$mail->SetFrom($jkv["email"], $jkv["title"]);
    				}
    				$mail->AddAddress($safeemail, $safeusername);
    				$mail->Subject = $jkv["title"].' - '.$tl['login']['l11'];
    				$mail->MsgHTML($body);
    				$mail->Send(); // Send email without any warnings
    				
    				
    				if ($jkv["rf_confirm"] == 3) {
    				
    					$admail = new PHPMailer();
    					$adlinkmessage = $tl['login']['l11'].$safeusername;
    					$adbody = str_ireplace("[\]",'',$adlinkmessage);
    					
    					// We go for SMTP
    					if ($jkv["smtp_or_mail"]) {
    					
    						$admail->IsSMTP(); // telling the class to use SMTP
    						$admail->Host = $jkv["smtp_host"];
    						$admail->SMTPAuth = ($jkv["smtp_auth"] ? true : false); // enable SMTP authentication
    						$admail->SMTPSecure = $jkv["smtp_prefix"]; // sets the prefix to the server
    						$admail->SMTPKeepAlive = ($jkv["smtp_alive"] ? true : false); // SMTP connection will not close after each email sent
    						$admail->Port = $jkv["smtp_port"]; // set the SMTP port for the GMAIL server
    						$admail->Username = $jkv["smtp_user"]; // SMTP account username
    						$admail->Password = $jkv["smtp_password"]; // SMTP account password
    						$admail->SetFrom($jkv["email"]);
    					
    					} else {
    						$admail->SetFrom($jkv["email"], $jkv["title"]);
    					}
    					
    					$admail->AddAddress($jkv["email"], $jkv["title"]);
    					$admail->Subject = $jkv["title"].' - '.$tl['login']['l11'];
    					$admail->MsgHTML($adbody);
    					$admail->Send(); // Send email without any warnings
    					
    				}
    			
    			} else {
    			
    				if ($jkv["rf_simple"]) $confirmlink .= '<br /><strong>'.$tl['login']['l2'].':</strong> '.$password;
    			
    				$mail = new PHPMailer(); // defaults to using php "mail()"
    				$body = str_ireplace("[\]",'',$jkv["rf_welcome"].$confirmlink);
    				
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
    					$mail->SetFrom($jkv["email"]);
    				
    				} else {
    					$mail->SetFrom($jkv["email"], $jkv["title"]);
    				}
    				$mail->AddAddress($safeemail, $safeusername);
    				$mail->Subject = $jkv["title"].' - '.$tl['login']['l11'];
    				$mail->MsgHTML($body);
    				$mail->Send(); // Send email without any warnings
    				
    			}
    			
    				$_SESSION['rf_msg_sent'] = 1;
    				jak_redirect($_SERVER['HTTP_REFERER']);
    		    }
    		    
    	}
    }
}
?>