<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Check if the file is accessed only via index.php if not stop the script from running
if(!defined('JAK_PREVENT_ACCESS')) die($tl['error']['nda']);

// Include the comment class file
require_once APP_PATH.'class/class.comment.php';

// Functions we need for this plugin
include_once 'functions.php';

$jaktable = DB_PREFIX.'download';
$jaktable1 = DB_PREFIX.'downloadcategories';
$jaktable2 = DB_PREFIX.'downloadcomments';
$jaktable3 = DB_PREFIX.'downloadhistory';

$CHECK_USR_SESSION = session_id();

// Get the important template stuff
$JAK_SEARCH_WHERE = JAK_PLUGIN_VAR_DOWNLOAD;
$JAK_SEARCH_LINK = JAK_PLUGIN_VAR_DOWNLOAD;

// Heatmap
$JAK_HEATMAPLOC = JAK_PLUGIN_VAR_DOWNLOAD;

// Wright the Usergroup permission into define and for template
define('JAK_DOWNLOADPOST', $jakusergroup->getVar("downloadpost"));
define('JAK_DOWNLOADCAN', $jakusergroup->getVar("downloadcan"));
define('JAK_DOWNLOADPOSTDELETE', $jakusergroup->getVar("downloadpostdelete"));
define('JAK_DOWNLOADPOSTAPPROVE', $jakusergroup->getVar("downloadpostapprove"));
define('JAK_DOWNLOADRATE', $jakusergroup->getVar("downloadrate"));
define('JAK_DOWNLOADMODERATE', $jakusergroup->getVar("downloadmoderate"));

// AJAX Search
$AJAX_SEARCH_PLUGIN_WHERE = $jaktable;
$AJAX_SEARCH_PLUGIN_URL = 'plugins/download/ajaxsearch.php';
$AJAX_SEARCH_PLUGIN_SEO =  $jkv["downloadurl"];

// Get the rss if active
if ($jkv["downloadrss"]) {
	$JAK_RSS_DISPLAY = 1;
	$P_RSS_LINK = JAK_rewrite::jakParseurl('rss.xml', JAK_PLUGIN_VAR_DOWNLOAD, '', '', '');
}

// Parse links once if needed a lot of time
$backtodl = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_DOWNLOAD, '', '', '', '');

// Template Call
$JAK_TPL_PLUG_T = JAK_PLUGIN_NAME_DOWNLOAD;
$JAK_TPL_PLUG_URL = $backtodl;

switch ($page1) {
	case 'c':
	
			if (is_numeric($page2) && jak_row_permission($page2,$jaktable1,JAK_USERGROUPID)) {
			
			$getTotal = jak_get_total($jaktable, $page2, 'catid', 'active');
			
			if ($jkv["downloadurl"]) {
				$getWhere = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_DOWNLOAD, $page1, $page2, $page3, '');
				$getPage = $page4;
			} else {
				$getWhere = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_DOWNLOAD, $page1, $page2, '', '');
				$getPage = $page3;
			}
		
			if ($getTotal != 0) {
			
				// Paginator
				$dlc = new JAK_Paginator;
				$dlc->items_total = $getTotal;
				$dlc->mid_range = $jkv["downloadpagemid"];
				$dlc->items_per_page = $jkv["downloadpageitem"];
				$dlc->jak_get_page = $getPage;
				$dlc->jak_where = $getWhere;
				$dlc->jak_prevtext = $tl["general"]["g171"];
				$dlc->jak_nexttext = $tl["general"]["g172"];
				$dlc->paginate();
				$JAK_PAGINATE = $dlc->display_pages();
				
				$JAK_DOWNLOAD_ALL = jak_get_download($dlc->limit, $jkv["downloadorder"], $page2, 't1.catid', $jkv["downloadurl"], $tl['general']['g56']);
			}
			
			// Get the download categories
			$row = $jakdb->queryRow('SELECT name, content FROM '.$jaktable1.' WHERE id = "'.smartsql($page2).'" LIMIT 1');
			
			$PAGE_TITLE = JAK_PLUGIN_NAME_DOWNLOAD.' - '.$row['name'];
			$PAGE_CONTENT = $row['content'];
			
			// Get the sort orders for the grid
			$JAK_HOOK_SIDE_GRID = false;
			$grid = $jakdb->query('SELECT id, hookid, pluginid, whatid, orderid FROM '.DB_PREFIX.'pagesgrid WHERE plugin = "'.smartsql(JAK_PLUGIN_ID_DOWNLOAD).'" AND fileid = 0 ORDER BY orderid ASC');
			while ($grow = $grid->fetch_assoc()) {
			        // collect each record into $pagegrid
			        	$JAK_HOOK_SIDE_GRID[] = $grow;
			}
			
			// Get the url session
			$_SESSION['jak_lastURL'] = $getWhere;
			
			// Now get the new meta keywords and description maker
			if (isset($JAK_DOWNLOAD_ALL) && is_array($JAK_DOWNLOAD_ALL)) foreach($JAK_DOWNLOAD_ALL as $kv) $seokeywords[] = JAK_Base::jakCleanurl($kv['title']);
			
			if (!empty($seokeywords)) $keylist = join(",", $seokeywords);
			
			$PAGE_KEYWORDS = str_replace(" ", "", JAK_Base::jakCleanurl($PAGE_TITLE).($keylist ? ",".$keylist : "").($jkv["metakey"] ? ",".$jkv["metakey"] : ""));
			$PAGE_DESCRIPTION = jak_cut_text($PAGE_CONTENT, 155, '');
			
			// Get the CSS and Javascript into the page
			$JAK_HEADER_CSS = $jkv["download_css"];
			$JAK_FOOTER_JAVASCRIPT = $jkv["download_javascript"];
	
			// get the standard template
			$plugin_template = 'plugins/download/template/'.$jkv["sitestyle"].'/download.php';
			
			} else {
				jak_redirect($backtodl);
			}
		
	break;
	case 'f':
	
		if (is_numeric($page2) && jak_row_exist($page2, $jaktable)) {
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['userPost'])) {
		
			$arr = array();
			
			$validates = JAK_comment::validate_form($arr, $jkv["downloadmaxpost"], $tl['error']['e'], $tl['error']['e1'], $tld['dload']['e3'], $tl['error']['e2'], $tld['dload']['e1'], $tld['dload']['e2'], $tl['error']['e10']);
			
			if ($validates)
			{
				/* Everything is OK, insert to database: */
				
				define('BASE_URL_IMG', BASE_URL);
				
				$cleanusername = smartsql($arr['co_name']);
				$cleanuserpostB = htmlspecialchars_decode(jak_clean_safe_userpost($arr['userpost']));
				
				// the new session check for displaying messages to user even if not approved
				$sqlset = 0;
				if (!JAK_DOWNLOADPOSTAPPROVE) {
					$sqlset = session_id();
				}
				
				if (JAK_USERID) {
					
					$sql = $jakdb->query('INSERT INTO '.$jaktable2.' VALUES (NULL, "'.$page2.'", "'.JAK_USERID.'", "'.$cleanusername.'", NULL, NULL, "'.smartsql($cleanuserpostB).'", "'.JAK_DOWNLOADPOSTAPPROVE.'", 0, NOW(), "'.$sqlset.'")');
					
					$arr['id'] = $jakdb->jak_last_id();
				
				} else {
					
					// Additional Fields
					$cleanemail = filter_var($arr['co_email'], FILTER_SANITIZE_EMAIL);
					$cleanurl = filter_var($arr['co_url'], FILTER_SANITIZE_URL);
					
					$jakdb->query('INSERT INTO '.$jaktable2.' VALUES (NULL, "'.$page2.'", 0, "'.$cleanusername.'", "'.$cleanemail.'", "'.$cleanurl.'", "'.smartsql($cleanuserpostB).'", "'.JAK_DOWNLOADPOSTAPPROVE.'", 0, NOW(), "'.$sqlset.'")');
					
					$arr['id'] = $jakdb->jak_last_id();

				}
				
				// Send an email to the owner if wish so
				if ($jkv["downloademail"] && !JAK_DOWNLOADMODERATE) {
				
					$mail = new PHPMailer(); // defaults to using php "mail()"
					$body = str_ireplace("[\]",'',$tld['dload']['d5'].' '.(JAK_USE_APACHE ? substr(BASE_URL, 0, -1) : BASE_URL).JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_DOWNLOAD, 'f', $page2, '', '').'<br>'.$tld['dload']['g6'].' '.BASE_URL.'admin/index.php?p=download&sb=comment&ssb=approval&sssb=go".');
					$mail->SetFrom($jkv["email"], $jkv["title"]);
					$mail->AddAddress($jkv["downloademail"], $cleanusername);
					$mail->Subject = $jkv["title"].' - '.$tld['dload']['g5'];
					$mail->MsgHTML($body);
					$mail->Send(); // Send email without any warnings
				}
				
				$arr['created'] = JAK_Base::jakTimesince(time(), $jkv["downloaddateformat"], $jkv["downloadtimeformat"], $tl['general']['g56']);
				
				/*
				/	The data in $arr is escaped for the mysql query,
				/	but we need the unescaped variables, so we apply,
				/	stripslashes to all the elements in the array:
				/*/
			
				/* Outputting the markup of the just-inserted comment: */
				if (isset($arr['jakajax']) && $arr['jakajax'] == "yes") {
					$acajax = new JAK_comment($jaktable2, 'id', $arr['id'], JAK_PLUGIN_VAR_DOWNLOAD, $jkv["downloaddateformat"], $jkv["downloadtimeformat"], $tl['general']['g56']);
					
					header('Cache-Control: no-cache');
					die(json_encode(array('status' => 1, 'html' => $acajax->get_commentajax($tl['general']['g102'], $tld['dload']['g3'], $tld['dload']['g4']))));
					
				} else {
					jak_redirect(JAK_PARSE_SUCCESS);
				}
			
			} else {
				/* Outputtng the error messages */
				if (isset($arr['jakajax']) && $arr['jakajax'] == "yes") {
					header('Cache-Control: no-cache');
					die('{"status":0, "errors":'.json_encode($arr).'}');
				} else {
				
					$errors = $arr;
				}
			}
		
		}
		
		// Gain access to page
		 if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['dlprotect'])) {
		 	$defaults = $_POST;
		 	
		 	$passcrypt = hash_hmac('sha256', $defaults['dlpass'], DB_PASS_HASH);
		 
		 	if (!is_numeric($defaults['dlsec'])) {
		 	    jak_redirect($backtodl);
		 	}
		 	
		 	// Get password crypted
		 	$passcrypt = hash_hmac('sha256', $defaults['dlpass'], DB_PASS_HASH);
		 	
		 	// Check if the password is correct
		    $dl_check = JAK_base::jakCheckprotectedArea($passcrypt, 'download', $defaults['dlsec']);
		     
		    if (!$dl_check) {
		    	$errors['e'] = $tl['error']['e28'];
		    }
		     
		    if (count($errors) == 0) {
		     	
		     	$_SESSION['dlsecurehash'.$defaults['dlsec']] = $passcrypt;
			    jak_redirect($_SERVER['HTTP_REFERER']);
			     
		    } else {
		        $errorpp = $errors;
		    }
		}
		
		$result = $jakdb->query('SELECT * FROM '.$jaktable.' WHERE id = "'.smartsql($page2).'" LIMIT 1');
		$row = $result->fetch_assoc();
		
		if ($row['active'] != 1) {
			jak_redirect(JAK_rewrite::jakParseurl('offline'));
		} else {
		
		if (!jak_row_permission($row['catid'],$jaktable1,JAK_USERGROUPID)) {
			jak_redirect($backtodl);
		} else {
		
			// Now let's check the vote and hits cookie
			if (!jak_cookie_voted_hits($jaktable, $row['id'], 'hits')) {
			
				jak_write_vote_hits_cookie($jaktable, $row['id'], 'hits');
				
				// Update hits each time
				JAK_base::jakUpdatehits($row['id'],$jaktable);
			}
			
			// Now output the data
			$PAGE_ID = $row['id'];
			$PAGE_TITLE = $row['title'];
			$PAGE_CONTENT = jak_secure_site($row['content']);
			$SHOWTITLE = $row['showtitle'];
			$SHOWIMG = $row['previmg'];
			$SHOWDATE = $row['showdate'];
			$FT_SHARE = $row['ftshare'];
			$SHOWVOTE = $row['showvote'];
			$SHOWSOCIALBUTTON = $row['socialbutton'];
			$DL_HITS = $row['hits'];
			$DL_DOWNLOADS = $row['countdl'];
			$DL_PASSWORD = $row['password'];
			$JAK_HEADER_CSS = $row['dl_css'];
			$JAK_FOOTER_JAVASCRIPT = $row['dl_javascript'];
			$jkv["sidebar_location_tpl"] = ($row['sidebar'] ? "left" : "right");
			$DL_LINK = html_entity_decode(JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_DOWNLOAD, 'dl', $row['id'], '', ''));
			
			$PAGE_TIME = JAK_Base::jakTimesince($row['time'], $jkv["downloaddateformat"], $jkv["downloadtimeformat"], $tl['general']['g56']);
			$PAGE_TIME_HTML5 = date("Y-m-d", strtotime($row['time']));
		
		// Set download to false
		$DL_FILE_BUTTON = false;
			
		// fix the download if allowed to
		if (JAK_DOWNLOADCAN && $row['candownload'] == 0 || jak_get_access(JAK_USERGROUPID, $row['candownload'])) {
		
			$DL_FILE_BUTTON = true;
		}
		
		// Display contact form if whish so and do the caching
		$JAK_SHOW_C_FORM = false;
		if ($row['showcontact'] != 0) {
			$JAK_SHOW_C_FORM = jak_create_contact_form($row['showcontact'], $tl['cmsg']['c12']);
			$JAK_SHOW_C_FORM_NAME = jak_contact_form_title($row['showcontact']);
		}		
		
		// Get the url session
		$_SESSION['jak_lastURL'] = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_DOWNLOAD, $page1, $page2, $page3, '');
		$_SESSION['jak_thisFileID'] = $row['id'];
		
		}
		
		// Get the comments if wish so
		if ($row['comments'] == 1) {
			$ac = new JAK_comment($jaktable2, 'fileid', $page2, JAK_PLUGIN_VAR_DOWNLOAD, $jkv["downloaddateformat"], $jkv["downloadtimeformat"], $tl['general']['g56']);
			
			$JAK_COMMENTS = $ac->get_comments();
			$JAK_COMMENTS_TOTAL = $ac->get_total();
			$JAK_COMMENT_FORM = true;
			
		} else {
		
			$JAK_COMMENTS_TOTAL = 0;
			$JAK_COMMENT_FORM = false;
			
		}
		
		// Get the likes
		$PLUGIN_LIKE_ID = JAK_PLUGIN_ID_DOWNLOAD;
		$USR_CAN_RATE = $jakusergroup->getVar("downloadrate");
		
		// Get the sort orders for the grid
		$grid = $jakdb->query('SELECT id, hookid, pluginid, whatid, orderid FROM '.DB_PREFIX.'pagesgrid WHERE fileid = "'.smartsql($row['id']).'" ORDER BY orderid ASC');
		while ($grow = $grid->fetch_assoc()) {
		        
		        // the sidebar grid
		       $JAK_HOOK_SIDE_GRID[] = $grow;
		        
		}
		
		// Show Tags
		$JAK_TAGLIST = JAK_tags::jakGettaglist($page2, JAK_PLUGIN_ID_DOWNLOAD, JAK_PLUGIN_VAR_TAGS);
		
		// Page Nav
		$nextp = jak_next_page($page2, 'title', $jaktable, 'id', ' AND catid = "'.smartsql($row["catid"]).'"', '', 'active');
		if ($nextp) {
			
			if ($jkv["downloadurl"]) {
				$seo = JAK_base::jakCleanurl($nextp['title']);
			}
			
			$JAK_NAV_NEXT = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_DOWNLOAD, 'f', $nextp['id'], $seo, '');
			$JAK_NAV_NEXT_TITLE = addslashes($nextp['title']);
		}
		
		$prevp = jak_previous_page($page2, 'title', $jaktable, 'id', ' AND catid = "'.smartsql($row["catid"]).'"', '', 'active');
		if ($prevp) {
			
			if ($jkv["downloadurl"]) {
				$seop = JAK_base::jakCleanurl($prevp['title']);
			}
			
			$JAK_NAV_PREV = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_DOWNLOAD, 'f', $prevp['id'], $seop, '');
			$JAK_NAV_PREV_TITLE = addslashes($prevp['title']);
		}
		
		}
		} else {
			jak_redirect($backtodl);
		}
		
		// Now get the new meta keywords and description maker
		$keytags = '';
		if ($JAK_TAGLIST) {
			$keytags = preg_split('/\s+/', strip_tags($JAK_TAGLIST));
			$keytags = ','.implode(',', $keytags);
		}
		$PAGE_KEYWORDS = str_replace(" ", "", JAK_Base::jakCleanurl($PAGE_TITLE).$keytags.($jkv["metakey"] ? ",".$jkv["metakey"] : ""));
		$PAGE_DESCRIPTION = jak_cut_text($PAGE_CONTENT, 155, '');
		
		// get the standard template
		$plugin_template = 'plugins/download/template/'.$jkv["sitestyle"].'/downloadfile.php';
	
	break;
	case 'del';
	
		if (is_numeric($page2) && is_numeric($page3) && jak_row_exist($page2,$jaktable2)) {
		
			if (JAK_DOWNLOADMODERATE) {
			
			$result = $jakdb->query('DELETE FROM '.$jaktable2.' WHERE id = "'.smartsql($page2).'"');
			
			if (!$result) {
				jak_redirect(JAK_PARSE_ERROR);
			} else {
			    jak_redirect(JAK_PARSE_SUCCESS);
			}
			
			} else {
				jak_redirect($backtodl);
			}
		
		} else {
			jak_redirect($backtodl);
		}
	
	break;
	case 'ep':
	
		if($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['userpost']) && isset($_POST['name']) && isset($_POST['editpost'])) {
			$defaults = $_POST;
							
				if (empty($defaults['userpost'])) {
				    $errors['e'] = $tl['error']['e2'];
				}
				
				if (strlen($defaults['userpost']) > $jkv["downloadmaxpost"]) {
					$countI = strlen($defaults['userpost']);
				    $errors['e'] = $tld['dload']['e1'].$jkv["downloadmaxpost"].' '.$tld['dload']['e2'].$countI;
				}
				
				if (is_numeric($page2) && count($errors) == 0 && jak_row_exist($page2, $jaktable2)) {
				
					define('BASE_URL_IMG', BASE_URL);
					
					$cleanpost = htmlspecialchars_decode(jak_clean_safe_userpost($defaults['userpost']));
				
					$result = $jakdb->query('UPDATE '.$jaktable2.' SET username = "'.smartsql($defaults['username']).'", web = "'.smartsql($defaults['web']).'", message = "'.smartsql($cleanpost).'" WHERE id = "'.smartsql($page2).'"');
				
				if (!$result) {
					jak_redirect(html_entity_decode(JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_DOWNLOAD, 'ep', $page2, $page3, 'e')));
				} else {
				    jak_redirect(html_entity_decode(JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_DOWNLOAD, 'ep', $page2, $page3, 's')));
				}
				
				} else {
				   $errors = $errors;
				}
			
		}
	
		if (is_numeric($page2) && is_numeric($page3) && jak_row_exist($page2, $jaktable2)) {
		
			if (JAK_USERID && JAK_DOWNLOADDELETE && jak_give_right($page2, JAK_USERID, $jaktable2, 'userid') || JAK_DOWNLOADMODERATE) {
			
			$result = $jakdb->query('SELECT username, web, message FROM '.$jaktable2.' WHERE id = "'.smartsql($page2).'" LIMIT 1');
			$row = $result->fetch_assoc();
			
			$RUNAME = $row['username'];
			$RWEB = $row['web'];
			$RCONT = jak_edit_safe_userpost($row['message']);
			
			// get the standard template
			$template = 'editpost.php';
			
		} else {
			jak_redirect($backtodl);
		}
		
		} else {
			jak_redirect($backtodl);
		}
	break;
	case 'trash':
		if (is_numeric($page2) && is_numeric($page3) && jak_row_exist($page2, $jaktable2)) {
		
			if (JAK_USERID && JAK_DOWNLOADPOSTDELETE && jak_give_right($page2,JAK_USERID,$jaktable2,'userid') || JAK_DOWNLOADMODERATE) {
			
			$result = $jakdb->query('UPDATE '.$jaktable2.' SET trash = 1 WHERE id = "'.smartsql($page2).'"');
			
			if (!$result) {
				jak_redirect(JAK_PARSE_ERROR);
			} else {
			    jak_redirect(JAK_PARSE_SUCCESS);
			}
			
			} else {
				jak_redirect($backtodl);
			}
		
		} else {
			jak_redirect($backtodl);
		}
	break;
	case 'dl':
	
		if ($_SESSION['jak_thisFileID'] == $page2 && is_numeric($page2) && jak_row_exist($page2,$jaktable)) {
		
		// Get the file
		$row = $jakdb->queryRow('SELECT candownload, catid, file, extfile, active FROM '.$jaktable.' WHERE id = "'.smartsql($page2).'" LIMIT 1');
		
		// Not active back to download
		if ($row['active'] != 1) jak_redirect($backtodl);
		
		// No access back to downloads
		if (!JAK_DOWNLOADCAN) jak_redirect($backtodl);
		
		// No access to the file
		if ($row['candownload'] != 0 && !jak_get_access(JAK_USERGROUPID, $row['candownload'])) jak_redirect($backtodl);
		
		
		$dluserid = 0;
		$dlemail = "guest";
		if (JAK_USERID) {
			$dluserid = JAK_USERID;
			$dlemail = $jakuser->getVar("email");
		}
		
		$jakdb->query('INSERT INTO '.$jaktable3.' VALUES (NULL, "'.$page2.'", "'.smartsql($dluserid).'", "'.smartsql($dlemail).'", "'.smartsql($row['file']).'", "'.smartsql($ipa).'", NOW())');
		
		if (!empty($row['extfile'])) {
			
			// Go external
			$jakdb->query('UPDATE '.$jaktable.' SET countdl = countdl + 1 WHERE id = "'.smartsql($page2).'"');
			jak_redirect($row['extfile']);
		
		} else {
			
			$dlfile = $jkv["downloadpath"].'/'.$row['file'];
			$dlfile =  str_replace("//","/",$dlfile);
			
				if (file_exists($dlfile)) {
			    	header('Content-Description: File Transfer');
			    	header('Content-Type: application/octet-stream');
			    	header('Content-Disposition: attachment; filename='.basename($dlfile));
			    	header('Content-Transfer-Encoding: binary');
			    	header('Expires: 0');
				    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			    	header('Pragma: public');
			    	header('Content-Length: ' . filesize($dlfile));
			    	ob_clean();
			    	flush();
			    	readfile($dlfile);
				} else {
					jak_redirect($backtodl);
				}
				
			$jakdb->query('UPDATE '.$jaktable.' SET countdl = countdl + 1 WHERE id = "'.smartsql($page2).'"');
				
		}
		
		} else {
			jak_redirect($backtodl);
		}
		
	break;
	default:
	
		$getTotal = jak_get_total_permission_dl();
		
			if ($getTotal != 0) {
			// Paginator
				$dl = new JAK_Paginator;
				$dl->items_total = $getTotal;
				$dl->mid_range = $jkv["downloadpagemid"];
				$dl->items_per_page = $jkv["downloadpageitem"];
				$dl->jak_get_page = $page1;
				$dl->jak_where = $backtodl;
				$dl->jak_prevtext = $tl["general"]["g171"];
				$dl->jak_nexttext = $tl["general"]["g172"];
				$dl->paginate();
				
				// Pagination
				$JAK_PAGINATE = $dl->display_pages();
				
				// Get all files
				$JAK_DOWNLOAD_ALL = jak_get_download($dl->limit, $jkv["downloadorder"], '', '', $jkv["downloadurl"], $tl['general']['g56']);
				
			}
			
			// Check if we have a language and display the right stuff
			$PAGE_TITLE = $jkv["downloadtitle"];
			$PAGE_CONTENT = $jkv["downloaddesc"];
			
			// Get the url session
			$_SESSION['jak_lastURL'] = $backtodl;
			
			// Get the sort orders for the grid
			$JAK_HOOK_SIDE_GRID = false;
			$grid = $jakdb->query('SELECT id, hookid, pluginid, whatid, orderid FROM '.DB_PREFIX.'pagesgrid WHERE plugin = "'.smartsql(JAK_PLUGIN_ID_DOWNLOAD).'" AND fileid = 0 ORDER BY orderid ASC');
			while ($grow = $grid->fetch_assoc()) {
			        // collect each record into $pagegrid
			        	$JAK_HOOK_SIDE_GRID[] = $grow;
			}
			
			// Now get the new meta keywords and description maker
			if (isset($JAK_DOWNLOAD_ALL) && is_array($JAK_DOWNLOAD_ALL)) foreach($JAK_DOWNLOAD_ALL as $kv) $seokeywords[] = JAK_Base::jakCleanurl($kv['title']);
			
			if (!empty($seokeywords)) $keylist = join(",", $seokeywords);
			
			$PAGE_KEYWORDS = str_replace(" ", "", JAK_Base::jakCleanurl($PAGE_TITLE).($keylist ? ",".$keylist : "").($jkv["metakey"] ? ",".$jkv["metakey"] : ""));
			// SEO from the category content if available
			if (!empty($ca['content'])) {
				$PAGE_DESCRIPTION = jak_cut_text($ca['content'], 155, '');
			} else {
				$PAGE_DESCRIPTION = jak_cut_text($PAGE_CONTENT, 155, '');
			}
			
			// Get the CSS and Javascript into the page
			$JAK_HEADER_CSS = $jkv["download_css"];
			$JAK_FOOTER_JAVASCRIPT = $jkv["download_javascript"];
			
			// get the standard template
			$plugin_template = 'plugins/download/template/'.$jkv["sitestyle"].'/download.php';	

}
?>