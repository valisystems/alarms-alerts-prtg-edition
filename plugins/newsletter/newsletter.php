<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Check if the file is accessed only via index.php if not stop the script from running
if(!defined('JAK_PREVENT_ACCESS')) die($tl['error']['nda']);

$jaktable = DB_PREFIX.'newsletter';
$jaktable1 = DB_PREFIX.'newslettergroup';
$jaktable2 = DB_PREFIX.'newsletteruser';
$jaktable3 = DB_PREFIX.'user';

// Wright the Usergroup permission into define and for template
define('JAK_NEWSLETTER', $jakusergroup->getVar("newsletter"));

// Parse links once if needed a lot of time
$backtonl = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_NEWSLETTER, '', '', '', '');

// Heatmap
$JAK_HEATMAPLOC = JAK_PLUGIN_VAR_NEWSLETTER;

switch ($page1) {
	case 'signup':
		
		// Check the contact page and fire errors or emails
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $defaults = $_POST;
			// Create Session, so contact form can only used once
		    $_SESSION['jak_nl_sent'] = -1;
			// Errors in Array
		    $errorsnl = array();
		    
		    if ($defaults['nlUser'] == '') {
		    	$errorsnl['nlUser'] = $tl['error']['e'].'<br />';
		    }
		    
		    if ($defaults['nlEmail'] == '' || !filter_var($defaults['nlEmail'], FILTER_VALIDATE_EMAIL)) {
		    	$errorsnl['nlEmail'] = $tl['error']['e1'].'<br />';
		    }
		    
		    if (jak_field_not_exist($defaults['nlEmail'], $jaktable2, 'email')) {
		    	$errorsnl['nlEmail'] = $tlnl['nletter']['e1'];
		    }
		
		    if (count($errorsnl) > 0) {
		    	
		    	/* Outputtng the error messages */
		    	if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
		    	
		    		header('Cache-Control: no-cache');
		    		die('{"status":0, "errors":'.json_encode($errorsnl).'}');
		    		
		    	} else {
		    	
		    		$_SESSION['jak_nl_errors'] = $errorsnl;
		    		jak_redirect($_SERVER['HTTP_REFERER']);
		    	}
		    	
		    } else {
		    	
		    	// Destroy error session
		    	unset($_SESSION['jak_nl_errors']);
		    	
		    	// Create random number
		    	$random = substr(number_format(time() * rand(), 0, '', ''), 0, 10);
		    
		    	// Insert user into database
		    	$result = $jakdb->query('INSERT INTO '.$jaktable2.' SET name = "'.smartsql($defaults['nlUser']).'", email = "'.smartsql($defaults['nlEmail']).'", delcode = "'.$random.'", time = NOW()');
		        
		        if ($result) {
		        	
		        	// Ajax Request
		        	if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
		        		
		        		$_SESSION['jak_nl_sent'] = 1;
		        		$_SESSION['jak_thankyou_nl'] = JAK_NLTHANKYOU;
		        	
		        		header('Cache-Control: no-cache');
		        		die(json_encode(array('status' => 1, 'html' => JAK_NLTHANKYOU)));
		        		
		        	} else {
		        	
			            $_SESSION['jak_nl_sent'] = 1;
			            $_SESSION['jak_thankyou_nl'] = JAK_NLTHANKYOU;
			            jak_redirect($_SERVER['HTTP_REFERER']);
		            
		            }
		        }
		    }
		} else {
			jak_redirect(BASE_URL);
		}
		
	break;
	case 'fv':
	
		if (is_numeric($page2) && is_numeric($page3) && jak_field_not_exist($page3, $jaktable, 'fullview')) {
		
			// Get the data from the newsletter
			$result = $jakdb->query('SELECT content FROM '.$jaktable.' WHERE id = '.smartsql($page2));
			$row = $result->fetch_assoc();
			
			// Just the content
			$cssAtt = array('{myweburl}', '{mywebname}', '{browserversion}', '{unsubscribe}', '{username}', '{fullname}', '{useremail}');
			$cssUrl   = array(BASE_URL, $jkv["title"], '', '', $tlnl['nletter']['d5'], $tlnl['nletter']['d5'], '');
			$PAGE_CONTENT = str_replace($cssAtt, $cssUrl, $row['content']);
			
			// get the standard template without header just the newsletter
			$plugin_template = 'plugins/newsletter/template/'.$jkv["sitestyle"].'/newsletter.php';
			
		} else {
			jak_redirect(BASE_URL);
		}
		
	break;
	case 'nlo':
	
		if (is_numeric($page2) && jak_field_not_exist($page2, $jaktable2, 'delcode')) {
		
			if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nlOff'])) {
			    $defaults = $_POST;
			
			if ($defaults['nlEmail'] == '' || !filter_var($defaults['nlEmail'], FILTER_VALIDATE_EMAIL)) {
		    	$errors['e'] = $tl['error']['e1'];
		    	$email_blank = true;
			}
			
			if (!$email_blank && !jak_field_not_exist($defaults['nlEmail'], $jaktable2, 'email')) {
				$errors['e'] = $tlnl['nletter']['e'];
			}
		
			if (count($errors) == 0) {
				$cleanemail = filter_var($defaults['nlEmail'], FILTER_SANITIZE_EMAIL);
				
				$result = $jakdb->query('DELETE FROM '.$jaktable2.' WHERE email = "'.smartsql($cleanemail).'" AND delcode = "'.smartsql($page2).'"');
		
				if (!$result) {
					jak_redirect(JAK_PARSE_ERROR);
				} else {
					jak_redirect(JAK_PARSE_SUCCESS);		
				}
		
			} else {
				$errorsnl = $errors;
			}
		
		}
		
		// content and title
		$PAGE_TITLE = JAK_NLTITLE;
		$PAGE_CONTENT = JAK_NLSIGNOFF;
		$NL_MEMBER = false;
		
		// get the standard template
		$plugin_template = 'plugins/newsletter/template/'.$jkv["sitestyle"].'/nloff.php';	
		
		} else {
			jak_redirect(BASE_URL);
		}
		
	break;
	case 'nlom':
		
		if (is_numeric($page2) && jak_field_not_exist($page2, $jaktable3, 'id')) {
		
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			
			if (isset($_POST['nlOff'])) {
			    $defaults = $_POST;
			
			if ($page2 != JAK_USERID) {
		    	$errors['e'] = $tlnl['nletter']['e2'];
			}
		
			if (count($errors) == 0 && JAK_USERID) {
				
				$result = $jakdb->query('UPDATE '.$jaktable3.' SET newsletter = 0 WHERE id = '.smartsql(JAK_USERID));
		
				if (!$result) {
					jak_redirect(JAK_PARSE_ERROR);
				} else {
					jak_redirect(JAK_PARSE_SUCCESS);		
				}
		
			} else {
				$errorsnl = $errors;
			}
			
			}
			
			if (isset($_POST['nlOn'])) {
				    $defaults = $_POST;
				
				if ($page2 != JAK_USERID) {
			    	$errors['e'] = $tlnl['nletter']['e2'];
				}
			
				if (count($errors) == 0 && JAK_USERID) {
					
					$result = $jakdb->query('UPDATE '.$jaktable3.' SET newsletter = 1 WHERE id = '.smartsql(JAK_USERID));
			
					if (!$result) {
						jak_redirect(JAK_PARSE_ERROR);
					} else {
						jak_redirect(JAK_PARSE_SUCCESS);		
					}
			
				} else {
					$errorsnl = $errors;
				}
				
				}
		
		}
		
		// content and title
		$PAGE_TITLE = JAK_NLTITLE;
		$PAGE_CONTENT = $tlnl['nletter']['d2'];
		$NL_MEMBER = true;
		$row['newsletter'] = 1;
		
		if (JAK_USERID) {
		
			// Get the newsletter status from the newsletter
			$result = $jakdb->query('SELECT newsletter FROM '.$jaktable3.' WHERE id = '.smartsql(JAK_USERID));
			$row = $result->fetch_assoc();
		
		}
		
		// get the standard template
		$plugin_template = 'plugins/newsletter/template/'.$jkv["sitestyle"].'/nloff.php';
		
		} else {
			jak_redirect(BASE_URL);
		}
		
	break;
	default:
		jak_redirect(BASE_URL);
}
?>