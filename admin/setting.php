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
if (!JAK_USERID || !$JAK_MODULES) jak_redirect(BASE_URL);

// Important DB Tables
$jaktable = DB_PREFIX.'categories';
$jaktable1 = DB_PREFIX.'clickstat';

// reset
$success = array();

// Important template Stuff
$JAK_SETTING = jak_get_setting('setting');

// Get the php hook for setting top before language control
$getsettinghook = $jakhooks->jakGethook("php_admin_setting");
if ($getsettinghook) foreach($getsettinghook as $sh)
{
	eval($sh['phpcode']);
}

// Call the hooks per name for setting template
$JAK_HOOK_ADMIN_SETTING_EDIT = $jakhooks->jakGethook("tpl_admin_setting");

if ($page1 == "trunheat") {

	$result = $jakdb->query('TRUNCATE '.$jaktable1);
		
	jak_redirect(BASE_URL.'index.php?p=setting&sp=s');

}

// Let's go on with the script
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $defaults = $_POST;
    
    if (isset($defaults['save'])) {
    
    // Get the php hook for setting top before language control
    $getsettingpost = $jakhooks->jakGethook("php_admin_setting_post");
    if ($getsettingpost) foreach($getsettingpost as $shp) {
    	eval($shp['phpcode']);
    }
    
    if ($defaults['jak_email'] == '' || !filter_var($defaults['jak_email'], FILTER_VALIDATE_EMAIL)) { 
    	$errors['e1'] = $tl['error']['e3'];
    }
    
    if ($defaults['jak_lang'] == '') { $errors['e6'] = $tl['error']['e29']; }

    if (empty($defaults['jak_date'])) { $errors['e2'] = $tl['error']['e4']; }
    
    if (!is_numeric($defaults['jak_shortmsg'])) { $errors['e3'] = $tl['error']['e15']; }
    
    if (!is_numeric($defaults['jak_item'])) { $errors['e4'] = $tl['error']['e15']; }
    
    if (!is_numeric($defaults['jak_mid'])) { $errors['e4'] = $tl['error']['e15']; }
    
    if (!is_numeric($defaults['jak_rssitem'])) { $errors['e5'] = $tl['error']['e15']; }
    
    if (!is_numeric($defaults['jak_avatwidth']) || !is_numeric($defaults['jak_avatheight'])) { $errors['e7'] = $tl['error']['e15']; }

    if (count($errors) == 0) {
    
    // Do the dirty work in mysql
    $result = $jakdb->query('UPDATE '.DB_PREFIX.'setting SET value = CASE varname
        WHEN "email" THEN "'.smartsql($defaults['jak_email']).'"
        WHEN "sitehttps" THEN "'.smartsql($defaults['jak_shttp']).'"
        WHEN "lang" THEN "'.smartsql($defaults['jak_lang']).'"
        WHEN "langdirection" THEN "'.smartsql($defaults['jak_langd']).'"
        WHEN "showloginside" THEN "'.smartsql($defaults['jak_loginside']).'"
        WHEN "useravatwidth" THEN "'.smartsql($defaults['jak_avatwidth']).'"
        WHEN "useravatheight" THEN "'.smartsql($defaults['jak_avatheight']).'"
        WHEN "printme" THEN "'.smartsql($defaults['jak_sprint']).'"
        WHEN "shortmsg" THEN "'.smartsql($defaults['jak_shortmsg']).'"
        WHEN "dateformat" THEN "'.smartsql($defaults['jak_date']).'"
        WHEN "timeformat" THEN "'.smartsql($defaults['jak_time']).'"
        WHEN "time_ago_show" THEN "'.smartsql($defaults['jak_time_ago']).'"
        WHEN "hvm" THEN "'.smartsql($defaults['jak_hvm']).'"
        WHEN "adv_editor" THEN "'.smartsql($defaults['jak_editor']).'"
        WHEN "usr_smilies" THEN "'.smartsql($defaults['jak_smilies']).'"
        WHEN "timezoneserver" THEN "'.smartsql($defaults['jak_timezone_server']).'"
        WHEN "contactform" THEN "'.smartsql($defaults['jak_contact']).'"
        WHEN "shownews" THEN "'.smartsql($defaults['jak_shownews']).'"
        WHEN "rss" THEN "'.smartsql($defaults['jak_rss']).'"
        WHEN "rssitem" THEN "'.smartsql($defaults['jak_rssitem']).'"
        WHEN "adminpagemid" THEN "'.smartsql($defaults['jak_mid']).'"
        WHEN "adminpageitem" THEN "'.smartsql($defaults['jak_item']).'"
        WHEN "ip_block" THEN "'.smartsql($defaults['ip_block']).'"
        WHEN "email_block" THEN "'.smartsql($defaults['email_block']).'"
        WHEN "username_block" THEN "'.smartsql($defaults['username_block']).'"
        WHEN "analytics" THEN "'.smartsql($defaults['jak_analytics']).'"
        WHEN "heatmap" THEN "'.smartsql($defaults['jak_heatmap']).'"
        WHEN "smtp_or_mail" THEN "'.smartsql($defaults['jak_smpt']).'"
        WHEN "smtp_host" THEN "'.smartsql($defaults['jak_host']).'"
        WHEN "smtp_port" THEN "'.smartsql($defaults['jak_port']).'"
        WHEN "smtp_alive" THEN "'.smartsql($defaults['jak_alive']).'"
        WHEN "smtp_auth" THEN "'.smartsql($defaults['jak_auth']).'"
        WHEN "smtp_prefix" THEN "'.smartsql($defaults['jak_prefix']).'"
        WHEN "smtp_user" THEN "'.smartsql($defaults['jak_smtpusername']).'"
        WHEN "smtp_password" THEN "'.smartsql($defaults['jak_smtppassword']).'"
    END
    	WHERE varname IN ("email","sitehttps","lang","langdirection","showloginside","loginside","useravatwidth","useravatheight","userpath","printme","shortmsg","dateformat","timeformat","time_ago_show","timezoneserver","hvm","adv_editor","usr_smilies","contactform","shownews","rss","rssitem","adminpagemid","adminpageitem","ip_block","email_block","username_block","analytics","heatmap","smtp_or_mail","smtp_host","smtp_port","smtp_alive","smtp_auth","smtp_prefix","smtp_user","smtp_password")');
		
	if (!$result) {
		jak_redirect(BASE_URL.'index.php?p=setting&sp=e');
	} else {		
        jak_redirect(BASE_URL.'index.php?p=setting&sp=s');
    }
    } else {
    
   	$errors['e'] = $tl['error']['e'];
    $errors = $errors;
    }
    
    } else {
    
    	// Do the dirty work in mysql
    	$jakdb->query('UPDATE '.DB_PREFIX.'setting SET value = CASE varname
    	    WHEN "smtp_or_mail" THEN "'.smartsql($defaults['jak_smpt']).'"
    	    WHEN "smtp_host" THEN "'.smartsql($defaults['jak_host']).'"
    	    WHEN "smtp_port" THEN "'.smartsql($defaults['jak_port']).'"
    	    WHEN "smtp_alive" THEN "'.smartsql($defaults['jak_alive']).'"
    	    WHEN "smtp_auth" THEN "'.smartsql($defaults['jak_auth']).'"
    	    WHEN "smtp_prefix" THEN "'.smartsql($defaults['jak_prefix']).'"
    	    WHEN "smtp_user" THEN "'.smartsql($defaults['jak_smtpusername']).'"
    	    WHEN "smtp_password" THEN "'.smartsql($defaults['jak_smtppassword']).'"
    	END
    		WHERE varname IN ("smtp_or_mail","smtp_host","smtp_port","smtp_alive","smtp_auth","smtp_prefix","smtp_user","smtp_password")');
    	
    	$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
    
    	// Send email the smpt way or else the mail way
    	if ($jkv["smtp_or_mail"]) {
    		
    		try {
        		$mail->IsSMTP(); // telling the class to use SMTP
        		$mail->Host = $jkv["smtp_host"];
        		$mail->SMTPAuth = ($jkv["smtp_auth"] ? true : false); // enable SMTP authentication
        		$mail->SMTPSecure = $jkv["smtp_prefix"]; // sets the prefix to the server
        		$mail->SMTPKeepAlive = ($jkv["smtp_alive"] ? true : false); // SMTP connection will not close after each email sent
        		$mail->Port = $jkv["smtp_port"]; // set the SMTP port for the GMAIL server
        		$mail->Username = $jkv["smtp_user"]; // SMTP account username
        		$mail->Password = $jkv["smtp_password"];        // SMTP account password
        		$mail->SetFrom($jkv["email"], $jkv["title"]);
        		$mail->AddReplyTo($jkv["email"], $jkv["title"]);
        		$mail->AddAddress($jkv["email"], $jkv["title"]);
        		$mail->AltBody = "SMTP Mail"; // optional, comment out and test
        		$mail->Subject = $tl["setting"]["s43"];
        		$mail->MsgHTML(sprintf($tl["setting"]["s44"], 'SMTP'));
        		$mail->Send();
        		$success['e'] = sprintf($tl["setting"]["s44"], 'SMTP');
        	} catch (phpmailerException $e) {
    	    	$errors['e'] = $e->errorMessage(); //Pretty error messages from PHPMailer
        	} catch (Exception $e) {
        		$errors['e'] = $e->getMessage(); //Boring error messages from anything else!
        	}
    		
    	} else {
    	
    		try {
        		$mail->SetFrom($jkv["email"], $jkv["title"]);
        		$mail->AddReplyTo($jkv["email"], $jkv["title"]);
        		$mail->AddAddress($jkv["email"], $jkv["title"]);
        		$mail->AltBody = "PHP Mail()"; // optional, comment out and test
        		$mail->Subject = $tl["setting"]["s43"];
        		$mail->MsgHTML(sprintf($tl["setting"]["s44"], 'PHP Mail()'));
        		$mail->Send();
        		$success['e'] = sprintf($tl["setting"]["s44"], 'PHP Mail()');
    		} catch (phpmailerException $e) {
    			$errors['e'] = $e->errorMessage(); //Pretty error messages from PHPMailer
    		} catch (Exception $e) {
    		  	$errors['e'] = $e->getMessage(); //Boring error messages from anything else!
    		}
    	
    	}
    	
    }
}

// Call the settings function
$acp_lang_files = jak_get_lang_files(true);
$lang_files = jak_get_lang_files(false);

// Title and Description
$SECTION_TITLE = $tl["menu"]["m2"];
$SECTION_DESC = $tl["cmdesc"]["d2"];

// Call the template
$template = 'setting.php';
?>