<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Check if the file is accessed only via index.php if not stop the script from running
if(!defined('JAK_PREVENT_ACCESS')) die('No direct file access!');

// Include the comment class file
require_once 'class/class.comment.php';

// Functions we need for this plugin
include_once 'functions.php';

$jaktable = DB_PREFIX.'faq';
$jaktable1 = DB_PREFIX.'faqcategories';
$jaktable2 = DB_PREFIX.'faqcomments';

$CHECK_USR_SESSION = session_id();

// Get the important template stuff
$JAK_SEARCH_WHERE = JAK_PLUGIN_VAR_FAQ;
$JAK_SEARCH_LINK = JAK_PLUGIN_VAR_FAQ;

// Heatmap
$JAK_HEATMAPLOC = JAK_PLUGIN_VAR_FAQ;

// Wright the Usergroup permission into define and for template
define('JAK_FAQPOST', $jakusergroup->getVar("faqpost"));
define('JAK_FAQPOSTDELETE', $jakusergroup->getVar("faqpostdelete"));
define('JAK_FAQPOSTAPPROVE', $jakusergroup->getVar("faqpostapprove"));
define('JAK_FAQRATE', $jakusergroup->getVar("faqrate"));
define('JAK_FAQMODERATE', $jakusergroup->getVar("faqmoderate"));

// AJAX Search
$AJAX_SEARCH_PLUGIN_WHERE = $jaktable;
$AJAX_SEARCH_PLUGIN_URL = 'plugins/faq/ajaxsearch.php';
$AJAX_SEARCH_PLUGIN_SEO =  $jkv["faqurl"];

// Get the rss if active
if ($jkv["faqrss"]) {
	$JAK_RSS_DISPLAY = 1;
	$P_RSS_LINK = JAK_rewrite::jakParseurl('rss.xml', JAK_PLUGIN_VAR_FAQ, '', '', '');
}

// Parse links once if needed a lot of time
$backtofaq = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_FAQ, '', '', '', '');

// Template Call
$JAK_TPL_PLUG_T = JAK_PLUGIN_NAME_FAQ;
$JAK_TPL_PLUG_URL = $backtofaq;

switch ($page1) {
	case 'c':
	
			if (is_numeric($page2) && jak_row_permission($page2,$jaktable1,JAK_USERGROUPID)) {
			
			$getTotal = jak_get_total($jaktable, $page2, 'catid', 'active');
			
			if ($jkv["faqurl"]) {
				$getWhere = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_FAQ, $page1, $page2, $page3, '');
				$getPage = $page4;
			} else {
				$getWhere = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_FAQ, $page1, $page2, '', '');
				$getPage = $page3;
			}
		
			if ($getTotal != 0) {
			
			// Paginator
				$faqc = new JAK_Paginator;
				$faqc->items_total = $getTotal;
				$faqc->mid_range = $jkv["faqpagemid"];
				$faqc->items_per_page = $jkv["faqpageitem"];
				$faqc->jak_get_page = $getPage;
				$faqc->jak_where = $getWhere;
				$faqc->jak_prevtext = $tl["general"]["g171"];
				$faqc->jak_nexttext = $tl["general"]["g172"];
				$faqc->paginate();
				$JAK_PAGINATE = $faqc->display_pages();
				}
				
			$JAK_FAQ_ALL = jak_get_faq($faqc->limit, $jkv["faqorder"], $page2, 't1.catid', $jkv["faqurl"], $tl['general']['g56']);
			
			$result = $jakdb->query('SELECT name'.', content'.' FROM '.$jaktable1.' WHERE id = "'.smartsql($page2).'" LIMIT 1');
			$row = $result->fetch_assoc();
			
			$PAGE_TITLE = JAK_PLUGIN_NAME_FAQ.' - '.$row['name'];
			$PAGE_CONTENT = $row['content'];
			
			// Get the sort orders for the grid
			$JAK_HOOK_SIDE_GRID = false;
			$grid = $jakdb->query('SELECT id, hookid, pluginid, whatid, orderid FROM '.DB_PREFIX.'pagesgrid WHERE plugin = '.JAK_PLUGIN_ID_FAQ.' AND faqid = 0 ORDER BY orderid ASC');
			while ($grow = $grid->fetch_assoc()) {
			        // collect each record into $pagegrid
			        	$JAK_HOOK_SIDE_GRID[] = $grow;
			}
			
			// Get the url session
			$_SESSION['jak_lastURL'] = $getWhere;
			
			// Now get the new meta keywords and description maker
			if (isset($JAK_FAQ_ALL) && is_array($JAK_FAQ_ALL)) foreach($JAK_FAQ_ALL as $kv) $seokeywords[] = JAK_Base::jakCleanurl($kv['title']);
			
			if (!empty($seokeywords)) $keylist = join(",", $seokeywords);
			
			$PAGE_KEYWORDS = str_replace(" ", "", JAK_Base::jakCleanurl($PAGE_TITLE).($keylist ? ",".$keylist : "").($jkv["metakey"] ? ",".$jkv["metakey"] : ""));
			$PAGE_DESCRIPTION = jak_cut_text($PAGE_CONTENT, 155, '');
			
			// get the standard template
			$plugin_template = 'plugins/faq/template/'.$jkv["sitestyle"].'/faq.php';
			
			} else {
				jak_redirect($backtofaq);
			}
		
	break;
	case 'a':
	
		if (is_numeric($page2) && jak_row_exist($page2, $jaktable)) {
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['userPost'])) {
		
			$arr = array();
			
			$validates = JAK_comment::validate_form($arr, $jkv["faqmaxpost"], $tl['error']['e'], $tl['error']['e1'], $tlf['faq']['e3'], $tl['error']['e2'], $tlf['faq']['e1'], $tlf['faq']['e2'], $tl['error']['e10']);
			
			if($validates)
			{
				/* Everything is OK, insert to database: */
				
				define('BASE_URL_IMG', BASE_URL);
				
				$cleanusername = smartsql($arr['co_name']);
				$cleanuserpostB = htmlspecialchars_decode(jak_clean_safe_userpost($arr['userpost']));
				
				// the new session check for displaying messages to user even if not approved
				$sqlset = 0;
				if (!JAK_FAQPOSTAPPROVE) {
					$sqlset = session_id();
				}
				
				if (JAK_USERID) {
					
					$sql = $jakdb->query('INSERT INTO '.$jaktable2.' VALUES (NULL, "'.$page2.'", "'.JAK_USERID.'", "'.$cleanusername.'", NULL, NULL, "'.smartsql($cleanuserpostB).'", "'.JAK_FAQPOSTAPPROVE.'", 0, NOW(), "'.$sqlset.'")');
					
					$arr['id'] = $jakdb->jak_last_id();
				
				} else {
					
					// Additional Fields
					$cleanemail = filter_var($arr['co_email'], FILTER_SANITIZE_EMAIL);
					$cleanurl = filter_var($arr['co_url'], FILTER_SANITIZE_URL);
					
					$jakdb->query('INSERT INTO '.$jaktable2.' VALUES (NULL, "'.$page2.'", 0, "'.$cleanusername.'", "'.$cleanemail.'", "'.$cleanurl.'", "'.smartsql($cleanuserpostB).'", "'.JAK_FAQPOSTAPPROVE.'", 0, NOW(), "'.$sqlset.'")');
					
					$arr['id'] = $jakdb->jak_last_id();

				}
				
				// Send an email to the owner if wish so
				if ($jkv["faqemail"] && !JAK_FAQMODERATE) {
				
					$mail = new PHPMailer(); // defaults to using php "mail()"
					$body = str_ireplace("[\]",'',$tlf['faq']['d5'].' '.(JAK_USE_APACHE ? substr(BASE_URL, 0, -1) : BASE_URL).JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_FAQ, 'a', $page2, '', '').'<br>'.$tlf['faq']['g6'].' '.BASE_URL.'admin/index.php?p=faq&sb=comment&ssb=approval&sssb=go".');
					$mail->SetFrom($jkv["email"], $jkv["title"]);
					$mail->AddAddress($jkv["faqemail"], $cleanusername);
					$mail->Subject = $jkv["title"].' - '.$tlf['faq']['g5'];
					$mail->MsgHTML($body);
					$mail->Send(); // Send email without any warnings
				}
				
				$arr['created'] = JAK_Base::jakTimesince(time(), $jkv["faqdateformat"], $jkv["faqtimeformat"], $tl['general']['g56']);
				
				/*
				/	The data in $arr is escaped for the mysql query,
				/	but we need the unescaped variables, so we apply,
				/	stripslashes to all the elements in the array:
				/*/
			
				/* Outputting the markup of the just-inserted comment: */
				if (isset($arr['jakajax']) && $arr['jakajax'] == "yes") {
					
					$acajax = new JAK_comment($jaktable2, 'id', $arr['id'], JAK_PLUGIN_VAR_FAQ, $jkv["faqdateformat"], $jkv["faqtimeformat"], $tl['general']['g56']);
					
					header('Cache-Control: no-cache');
					die(json_encode(array('status' => 1, 'html' => $acajax->get_commentajax($tl['general']['g102'], $tlf['faq']['g3'], $tlf['faq']['g4']))));
					
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
		
		$result = $jakdb->query('SELECT * FROM '.$jaktable.' WHERE id = "'.smartsql($page2).'" LIMIT 1');
		$row = $result->fetch_assoc();
		
		if ($row['active'] != 1) {
			jak_redirect(JAK_rewrite::jakParseurl('offline'));
		} else {
		
		if (!jak_row_permission($row['catid'],$jaktable1,JAK_USERGROUPID)) {
			jak_redirect($backtofaq);
		} else {
		
			// Now let's check the hits cookie
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
			$SHOWDATE = $row['showdate'];
			$SHOWVOTE = $row['showvote'];
			$SHOWCOMMENTFORM = $row['comments'];
			$SHOWSOCIALBUTTON = $row['socialbutton'];
			$FAQ_HITS = $row['hits'];
			
			$PAGE_TIME = JAK_Base::jakTimesince($row['time'], $jkv["faqdateformat"], $jkv["faqtimeformat"], $tl['general']['g56']);
			$PAGE_TIME_HTML5 = date("Y-m-d", strtotime($row['time']));
		
		// Display contact form if whish so and do the caching
		$JAK_SHOW_C_FORM = false;
		if ($row['showcontact'] != 0) {
			$JAK_SHOW_C_FORM = jak_create_contact_form($row['showcontact'], $tl['cmsg']['c12']);
			$JAK_SHOW_C_FORM_NAME = jak_contact_form_title($row['showcontact']);
		}		
		
		// Get the url session
		$_SESSION['jak_lastURL'] = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_FAQ, $page1, $page2, $page3, '');
		
		}
		
		// Get the comments if wish so
		if ($row['comments'] == 1) {
			$ac = new JAK_comment($jaktable2, 'faqid', $page2, JAK_PLUGIN_VAR_FAQ, $jkv["faqdateformat"], $jkv["faqtimeformat"], $tl['general']['g56']);
			
			$JAK_COMMENTS = $ac->get_comments();
			$JAK_COMMENTS_TOTAL = $ac->get_total();
			$JAK_COMMENT_FORM = true;
			
		} else {
		
			$JAK_COMMENTS_TOTAL = 0;
			$JAK_COMMENT_FORM = false;
			
		}
		
		// Get the likes
		$PLUGIN_LIKE_ID = JAK_PLUGIN_ID_FAQ;
		$USR_CAN_RATE = $jakusergroup->getVar("faqrate");
		
		// Get the sort orders for the grid
		$grid = $jakdb->query('SELECT id, hookid, pluginid, whatid, orderid FROM '.DB_PREFIX.'pagesgrid WHERE faqid = "'.$row['id'].'" ORDER BY orderid ASC');
		while ($grow = $grid->fetch_assoc()) {
		        
		        // the sidebar grid
		        if ($grow["hookid"]) {
		        	$JAK_HOOK_SIDE_GRID[] = $grow;
		        }
		}
		
		// Show Tags
		$JAK_TAGLIST = JAK_tags::jakGettaglist($page2, JAK_PLUGIN_ID_FAQ, JAK_PLUGIN_VAR_TAGS);
		
		// Page Nav
		$nextp = jak_next_page($page2, 'title', $jaktable, 'id', ' AND catid = "'.smartsql($row["catid"]).'"', '', 'active');
		if ($nextp) {
			
			if ($jkv["faqurl"]) {
				$seo = JAK_base::jakCleanurl($nextp['title']);
			}
			
			$JAK_NAV_NEXT = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_FAQ, 'a', $nextp['id'], $seo, '');
			$JAK_NAV_NEXT_TITLE = addslashes($nextp['title']);
		}
		
		$prevp = jak_previous_page($page2, 'title', $jaktable, 'id', ' AND catid = "'.smartsql($row["catid"]).'"', '', 'active');
		if ($prevp) {
			
			if ($jkv["faqurl"]) {
				$seop = JAK_base::jakCleanurl($prevp['title']);
			}
			
			$JAK_NAV_PREV = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_FAQ, 'a', $prevp['id'], $seop, '');
			$JAK_NAV_PREV_TITLE = addslashes($prevp['title']);
		}
		
		}
		} else {
			jak_redirect($backtofaq);
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
		$plugin_template = 'plugins/faq/template/'.$jkv["sitestyle"].'/faqart.php';
			
	break;
	case 'del';
	
		if (is_numeric($page2) && is_numeric($page3) && jak_row_exist($page2,$jaktable2)) {
		
			if (JAK_FAQMODERATE) {
			
			$result = $jakdb->query('DELETE FROM '.$jaktable2.' WHERE id = "'.smartsql($page2).'"');
			
			if (!$result) {
				jak_redirect(JAK_PARSE_ERROR);
			} else {
			    jak_redirect(JAK_PARSE_SUCCESS);
			}
			
			} else {
				jak_redirect($backtofaq);
			}
		
		} else {
			jak_redirect($backtofaq);
		}
	
	break;
	case 'ep':
	
		if($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['userpost']) && isset($_POST['name']) && isset($_POST['editpost'])) {
			$defaults = $_POST;
							
				if (empty($defaults['userpost'])) {
				    $errors['e'] = $tl['error']['e2'];
				}
				
				if (strlen($defaults['userpost']) > $jkv["faqmaxpost"]) {
					$countI = strlen($defaults['userpost']);
				    $errors['e'] = $tlf['faq']['e1'].$jkv["faqmaxpost"].' '.$tlf['faq']['e2'].$countI;
				}
				
				if (is_numeric($page2) && count($errors) == 0 && jak_row_exist($page2, $jaktable2)) {
				
					define('BASE_URL_IMG', BASE_URL);
					
					$cleanpost = htmlspecialchars_decode(jak_clean_safe_userpost($defaults['userpost']));
				
					$result = $jakdb->query('UPDATE '.$jaktable2.' SET username = "'.smartsql($defaults['username']).'", web = "'.smartsql($defaults['web']).'", message = "'.smartsql($cleanpost).'" WHERE id = "'.smartsql($page2).'"');
				
				if (!$result) {
					jak_redirect(html_entity_decode(JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_FAQ, 'ep', $page2, $page3, 'e')));
				} else {
				    jak_redirect(html_entity_decode(JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_FAQ, 'ep', $page2, $page3, 's')));
				}
				
				} else {
				   $errors = $errors;
				}
			
		}
	
		if (is_numeric($page2) && is_numeric($page3) && jak_row_exist($page2, $jaktable2)) {
		
			if (JAK_USERID && JAK_FAQDELETE && jak_give_right($page2, JAK_USERID, $jaktable2, 'userid') || JAK_FAQMODERATE) {
			
			$result = $jakdb->query('SELECT username, web, message FROM '.$jaktable2.' WHERE id = "'.smartsql($page2).'" LIMIT 1');
			$row = $result->fetch_assoc();
			
			$RUNAME = $row['username'];
			$RWEB = $row['web'];
			$RCONT = jak_edit_safe_userpost($row['message']);
			
			// get the standard template
			$template = 'editpost.php';
			
		} else {
			jak_redirect($backtofaq);
		}
		
		} else {
			jak_redirect($backtofaq);
		}
	break;
	case 'trash':
		if (is_numeric($page2) && is_numeric($page3) && jak_row_exist($page2, $jaktable2)) {
		
			if (JAK_USERID && JAK_FAQPOSTDELETE && jak_give_right($page2,JAK_USERID,$jaktable2,'userid') || JAK_FAQMODERATE) {
			
			$result = $jakdb->query('UPDATE '.$jaktable2.' SET trash = 1 WHERE id = "'.smartsql($page2).'"');
			
			if (!$result) {
				jak_redirect(JAK_PARSE_ERROR);
			} else {
			    jak_redirect(JAK_PARSE_SUCCESS);
			}
			
			} else {
				jak_redirect($backtofaq);
			}
		
		} else {
			jak_redirect($backtofaq);
		}
	break;
	default:
			
		$getTotal = jak_get_total_permission_faq();
			
		if ($getTotal != 0) {
			// Paginator
			$faq = new JAK_Paginator;
			$faq->items_total = $getTotal;
			$faq->mid_range = $jkv["faqpagemid"];
			$faq->items_per_page = $jkv["faqpageitem"];
			$faq->jak_get_page = $page1;
			$faq->jak_where = $backtofaq;
			$faq->jak_prevtext = $tl["general"]["g171"];
			$faq->jak_nexttext = $tl["general"]["g172"];
			$faq->paginate();
			
			// Pagination
			$JAK_PAGINATE = $faq->display_pages();
			
			// Get all FAQ articles
			$JAK_FAQ_ALL = jak_get_faq($faq->limit, $jkv["faqorder"], '', '', $jkv["faqurl"], $tl['general']['g56']);
					
		}
				
		// Check if we have a language and display the right stuff
		$PAGE_TITLE = $jkv["faqtitle"];
		$PAGE_CONTENT = $jkv["faqdesc"];
			
		// Get the url session
		$_SESSION['jak_lastURL'] = $backtofaq;
			
		// Get the sort orders for the grid
		$grid = $jakdb->query('SELECT id, hookid, pluginid, whatid, orderid FROM '.DB_PREFIX.'pagesgrid WHERE plugin = '.JAK_PLUGIN_ID_FAQ.' AND faqid = 0 ORDER BY orderid ASC');
		while ($grow = $grid->fetch_assoc()) {
			// collect each record into $pagegrid
			$JAK_HOOK_SIDE_GRID[] = $grow;
		}
			
		// Now get the new meta keywords and description maker
		if (isset($JAK_FAQ_ALL) && is_array($JAK_FAQ_ALL)) foreach($JAK_FAQ_ALL as $kv) $seokeywords[] = JAK_Base::jakCleanurl($kv['title']);
			
		if (!empty($seokeywords)) $keylist = join(",", $seokeywords);
			
		$PAGE_KEYWORDS = str_replace(" ", "", JAK_Base::jakCleanurl($PAGE_TITLE).($keylist ? ",".$keylist : "").($jkv["metakey"] ? ",".$jkv["metakey"] : ""));
		// SEO from the category content if available
		if (!empty($ca['content'])) {
			$PAGE_DESCRIPTION = jak_cut_text($ca['content'], 155, '');
		} else {
			$PAGE_DESCRIPTION = jak_cut_text($PAGE_CONTENT, 155, '');
		}
			
		// get the standard template
		$plugin_template = 'plugins/faq/template/'.$jkv["sitestyle"].'/faq.php';

}
?>