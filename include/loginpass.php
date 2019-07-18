<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Reset vars
$errorlo = $errorfp = $errorpp = array();

// Login user
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['jakU'])) {

    $username = smartsql($_POST['jakU']);
    $userpass = smartsql($_POST['jakP']);
    $cookies = false;
    if (isset($_POST['lcookies'])) $cookies = true;
    
    // Security fix
    $valid_agent = filter_var($_SERVER['HTTP_USER_AGENT'], FILTER_SANITIZE_STRING);
    $valid_ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP);
    
    // Write the log file each time someone tries to login before
    $jakuserlogin->jakWriteloginlog(filter_var($username, FILTER_SANITIZE_STRING), $_SERVER['REQUEST_URI'], $valid_ip, $valid_agent, 0);
    	     
    $user_check = $jakuserlogin->jakCheckuserdata($username, $userpass);
    if ($user_check == true) {

        // Now login in the user
        $jakuserlogin->jakLogin($user_check, $userpass, $cookies);
        
        // Write the log file each time someone login after to show success
        $jakuserlogin->jakWriteloginlog($user_check, '', $valid_ip, '', 1);
        
        // success
        $_SESSION["infomsg"] = $tl["general"]["s"];
        
        if (isset($_POST['home']) && $_POST['home']) {
        	jak_redirect(BASE_URL);
        } else {
        	jak_redirect($_SERVER['HTTP_REFERER']);
        }

   } else {
        $errors['e'] = '<i class="fa fa-exclamation-triangle"></i> '.$tl['error']['l'];
        $errorlo = $errors;
   }
        
 }
 
 // Forgot password
 if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['forgotP'])) {
 	$defaults = $_POST;
 
 	if (!filter_var($defaults['jakE'], FILTER_VALIDATE_EMAIL)) {
 	    $errors['e'] = $tl['error']['e1'];
 	}
 	
 	// transform user email
     $femail = filter_var($defaults['jakE'], FILTER_SANITIZE_EMAIL);
     $fwhen = time();
 	
 	// Check if this user exist
     $user_check = $jakuserlogin->jakForgotpassword($femail, $fwhen);
     
     if (!isset($errors['e']) && !$user_check) {
         $errors['e'] = $tl['error']['e19'];
     }
     
     if (count($errors) == 0) {
     
     	$body = sprintf($tl['login']['l18'], $user_check, '<a href="'.(JAK_USE_APACHE ? substr(BASE_URL, 0, -1) : BASE_URL).html_entity_decode(JAK_rewrite::jakParseurl('forgot-password', $fwhen, '', '', '')).'">'.(JAK_USE_APACHE ? substr(BASE_URL, 0, -1) : BASE_URL).html_entity_decode(JAK_rewrite::jakParseurl('forgot-password', $fwhen, '', '', '')).'</a>', $jkv["title"]);
     	
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
     	
     	$mail->SetFrom($jkv["email"], $jkv["title"]);
     	$mail->AddAddress($femail, $user_check);
     	$mail->Subject = $jkv["title"].' - '.$tl['login']['l17'];
     	$mail->MsgHTML($body);
     	$mail->AltBody = strip_tags($body);
     	
     	if ($mail->Send()) {
     		$_SESSION["infomsg"] = $tl["login"]["l7"];
     		jak_redirect($_SERVER['HTTP_REFERER']);  	
     	}
 
     } else {
         $errorfp = $errors;
     }
}

// Gain access to page
 if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['pageprotect'])) {
 	$defaults = $_POST;
 	
 	$passcrypt = hash_hmac('sha256', $defaults['pagepass'], DB_PASS_HASH);
 
 	if (!is_numeric($defaults['pagesec'])) {
 	    jak_redirect(BASE_URL);
 	}
 	
 	// Get password crypted
 	$passcrypt = hash_hmac('sha256', $defaults['pagepass'], DB_PASS_HASH);
 	
 	// Check if the password is correct
    $page_check = JAK_base::jakCheckprotectedArea($passcrypt, 'pages', $defaults['pagesec']);
     
    if (!$page_check) {
    	$errors['e'] = $tl['error']['e28'];
    }
     
    if (count($errors) == 0) {
     	
     	$_SESSION['pagesecurehash'.$defaults['pagesec']] = $passcrypt;
	    jak_redirect($_SERVER['HTTP_REFERER']);
	     
    } else {
        $errorpp = $errors;
    }
}
?>