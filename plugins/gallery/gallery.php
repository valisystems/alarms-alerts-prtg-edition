<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Check if the file is accessed only via index.php if not stop the script from running
if (!defined('JAK_PREVENT_ACCESS')) die('No direct file access!');

// Include the comment class file
require_once 'class/class.comment.php';

// Functions we need for this plugin
include_once 'functions.php';

$jaktable = DB_PREFIX.'gallery';
$jaktable1 = DB_PREFIX.'gallerycategories';
$jaktable2 = DB_PREFIX.'gallerycomments';

$CHECK_USR_SESSION = session_id();

// Get the important template stuff
$JAK_SEARCH_WHERE = JAK_PLUGIN_VAR_GALLERY;
$JAK_SEARCH_LINK = JAK_PLUGIN_VAR_GALLERY;

// Heatmap
$JAK_HEATMAPLOC = JAK_PLUGIN_VAR_GALLERY;

// Wright the Usergroup permission into define and for template
define('JAK_GALLERYPOST', $jakusergroup->getVar("gallerypost"));
define('JAK_GALLERYPOSTDELETE', $jakusergroup->getVar("gallerypostdelete"));
define('JAK_GALLERYPOSTAPPROVE', $jakusergroup->getVar("gallerypostapprove"));
define('JAK_GALLERYRATE', $jakusergroup->getVar("galleryrate"));
define('JAK_GALLERYUPLOAD', $jakusergroup->getVar("galleryupload"));
define('JAK_GALLERYMODERATE', $jakusergroup->getVar("gallerymoderate"));

// AJAX Search
$AJAX_SEARCH_PLUGIN_WHERE = $jaktable;
$AJAX_SEARCH_PLUGIN_URL = 'plugins/gallery/ajaxsearch.php';
$AJAX_SEARCH_PLUGIN_SEO =  $jkv["galleryurl"];

// Get the rss if active
if ($jkv["galleryrss"]) {
	$JAK_RSS_DISPLAY = 1;
	$P_RSS_LINK = JAK_rewrite::jakParseurl('rss.xml', JAK_PLUGIN_VAR_GALLERY, '', '', '');
}

// Get the upload path
$JAK_UPLOAD_PATH_BASE = 'plugins/gallery/upload';

// Parse links once if needed a lot of time
$backtogallery = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_GALLERY, '', '', '', '');

// Template Call
$JAK_TPL_PLUG_T = JAK_PLUGIN_NAME_GALLERY;
$JAK_TPL_PLUG_URL = $backtogallery;

// Get the sort orders for the grid
$grid = $jakdb->query('SELECT id, hookid, orderid FROM '.DB_PREFIX.'pagesgrid WHERE plugin = '.JAK_PLUGIN_ID_GALLERY.' ORDER BY orderid ASC');
while ($grow = $grid->fetch_assoc()) {
        // collect each record into $pagegrid
        	$JAK_HOOK_SIDE_GRID[] = $grow;
}

switch ($page1) {
	case 'c':
	
			if (is_numeric($page2) && jak_row_permission($page2, $jaktable1, JAK_USERGROUPID)) {
			
			$getTotal = jak_get_total($jaktable, $page2, 'catid', 'active');
			
			if ($jkv["galleryurl"]) {
				$getWhere = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_GALLERY, $page1, $page2, $page3, '');
				$getPage = $page4;
			} else {
				$getWhere = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_GALLERY, $page1, $page2, '', '');
				$getPage = $page3;
			}
		
			if ($getTotal != 0) {
			
			// Paginator
				$galleryc = new JAK_Paginator;
				$galleryc->items_total = $getTotal;
				$galleryc->mid_range = $jkv["gallerypagemid"];
				$galleryc->items_per_page = $jkv["gallerypageitem"];
				$galleryc->jak_get_page = $getPage;
				$galleryc->jak_where = $getWhere;
				$galleryc->jak_prevtext = $tl["general"]["g171"];
				$galleryc->jak_nexttext = $tl["general"]["g172"];
				$galleryc->paginate();
				$JAK_PAGINATE = $galleryc->display_pages();
			
				// Get the photos
				$JAK_GALLERY_ALL = jak_get_gallery($galleryc->limit, '', $page2, 't1.catid', $jkv["galleryurl"], $tl['general']['g56'], $tl['general']['g56']);
			}
			
			$result = $jakdb->query('SELECT name, content, uploadc FROM '.$jaktable1.' WHERE id = "'.smartsql($page2).'" LIMIT 1');
			$row = $result->fetch_assoc();
			
			$PAGE_TITLE = $tlgal['gallery']['d9'].$row['name'];
			$PAGE_CONTENT = $row['content'];
			
			// Now check if we can upload photos
			if ($row['uploadc'] && JAK_GALLERYUPLOAD) {
				$usrpupload = true;
			} else {
				$usrpupload = false;
			}
			
			// Get the url session
			$_SESSION['jak_lastURL'] = $getWhere;
			
			// Get all categories
			$JAK_GALLERY_CAT = JAK_Base::jakGetcatmix(JAK_PLUGIN_VAR_GALLERY, '', $jaktable1, JAK_USERGROUPID, $jkv["galleryurl"]);
			
			// Now get the new meta keywords and description maker
			if (isset($JAK_GALLERY_ALL) && is_array($JAK_GALLERY_ALL)) foreach($JAK_GALLERY_ALL as $kv) $seokeywords[] = JAK_Base::jakCleanurl($kv['title']);
			
			if (!empty($seokeywords)) $keylist = join(",", $seokeywords);
			
			$PAGE_KEYWORDS = str_replace(" ", "", JAK_Base::jakCleanurl($PAGE_TITLE).($keylist ? ",".$keylist : "").($jkv["metakey"] ? ",".$jkv["metakey"] : ""));
			$PAGE_DESCRIPTION = jak_cut_text($PAGE_CONTENT, 155, '');
			
			// get the standard template
			$plugin_template = 'plugins/gallery/template/'.$jkv["sitestyle"].'/gallery.php';
			
			} else {
				jak_redirect($backtogallery);
			}
		
	break;
	case 'p':
	
		if (is_numeric($page2) && jak_row_exist($page2, $jaktable)) {
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['userPost'])) {
		
			$arr = array();
			
			$validates = JAK_comment::validate_form($arr, $jkv["gallerymaxpost"], $tl['error']['e'], $tl['error']['e1'], $tlgal['gallery']['e3'], $tl['error']['e2'], $tlgal['gallery']['e1'], $tlgal['gallery']['e2'], $tl['error']['e10']);
			
			if($validates)
			{
				/* Everything is OK, insert to database: */
				
				define('BASE_URL_IMG', BASE_URL);
				
				$cleanusername = smartsql($arr['co_name']);
				$cleanuserpostB = htmlspecialchars_decode(jak_clean_safe_userpost($arr['userpost']));
				
				// the new session check for displaying messages to user even if not approved
				$sqlset = 0;
				if (!JAK_GALLERYPOSTAPPROVE) {
					$sqlset = session_id();
				}
				
				if (JAK_USERID) {
					
					$sql = $jakdb->query('INSERT INTO '.$jaktable2.' VALUES (NULL, "'.$page2.'", "'.JAK_USERID.'", "'.$cleanusername.'", NULL, NULL, "'.smartsql($cleanuserpostB).'", "'.JAK_GALLERYPOSTAPPROVE.'", 0, NOW(), "'.$sqlset.'")');
					
					$arr['id'] = $jakdb->jak_last_id();
				
				} else {
					
					// Additional Fields
					$cleanemail = filter_var($arr['co_email'], FILTER_SANITIZE_EMAIL);
					$cleanurl = filter_var($arr['co_url'], FILTER_SANITIZE_URL);
					
					$jakdb->query('INSERT INTO '.$jaktable2.' VALUES (NULL, "'.$page2.'", 0, "'.$cleanusername.'", "'.$cleanemail.'", "'.$cleanurl.'", "'.smartsql($cleanuserpostB).'", "'.JAK_GALLERYPOSTAPPROVE.'", 0, NOW(), "'.$sqlset.'")');
					
					$arr['id'] = $jakdb->jak_last_id();

				}
				
				// Send an email to the owner if wish so
				if ($jkv["galleryemail"] && !JAK_GALLERYMODERATE) {
				
					$mail = new PHPMailer(); // defaults to using php "mail()"
					$body = str_ireplace("[\]",'',$tlgal['gallery']['d5'].' '.(JAK_USE_APACHE ? substr(BASE_URL, 0, -1) : BASE_URL).JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_GALLERY, 'p', $page2, '', '').'<br>'.$tlgal['gallery']['g6'].' '.BASE_URL.'admin/index.php?p=gallery&sb=comment&ssb=approval&sssb=go".');
					$mail->SetFrom($jkv["email"], $jkv["title"]);
					$mail->AddAddress($jkv["galleryemail"], $cleanusername);
					$mail->Subject = $jkv["title"].' - '.$tlgal['gallery']['g5'];
					$mail->MsgHTML($body);
					$mail->Send(); // Send email without any warnings
				}
				
				$arr['created'] = JAK_Base::jakTimesince(time(), $jkv["gallerydateformat"], $jkv["gallerytimeformat"], $tl['general']['g56']);
			
				/* Outputting the markup of the just-inserted comment: */
				if (isset($arr['jakajax']) && $arr['jakajax'] == "yes") {
					
					$acajax = new JAK_comment($jaktable2, 'id', $arr['id'], JAK_PLUGIN_VAR_GALLERY, $jkv["gallerydateformat"], $jkv["gallerytimeformat"], $tl['general']['g56']);
					
					header('Cache-Control: no-cache');
					die(json_encode(array('status' => 1, 'html' => $acajax->get_commentajax($tl['general']['g102'], $tlgal['gallery']['g3'], $tlgal['gallery']['g4']))));
					
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
			jak_redirect($backtogallery);
		} else {
		
			// Now let's check the hits cookie
			if (!jak_cookie_voted_hits($jaktable, $row['id'], 'hits')) {
			
				jak_write_vote_hits_cookie($jaktable, $row['id'], 'hits');
				
				// Update hits each time
				JAK_base::jakUpdatehits($row['id'],$jaktable);
			}
			
			$result1 = $jakdb->query('SELECT name, varname, showvote, comments, socialbutton FROM '.$jaktable1.' WHERE id = "'.smartsql($row['catid']).'" LIMIT 1');
			$row1 = $result1->fetch_assoc();
			
			// Now output the data
			$PAGE_ID = $row['id'];
			$PAGE_UID = $row['userid'];
			$PAGE_TITLE = $row['title'];
			$PAGE_CONTENT = $row['content'];
			$SHOWTITLE = 1;
			$BIGFILE = $row['pathbig'];
			$SHOWVOTE = $row1['showvote'];
			$SHOWSOCIALBUTTON = $row1['socialbutton'];
			$GALLERY_HITS = $row['hits'];
			
			$PAGE_TIME = JAK_Base::jakTimesince($row['time'], $jkv["gallerydateformat"], $jkv["gallerytimeformat"], $tl['general']['g56']);
		
		// Get the url session
		$_SESSION['jak_lastURL'] = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_GALLERY, $page1, $page2, $page3, '');
		
		}
		
		// Get the category url
		$seoc = '';
		if ($jkv["galleryurl"]) {
			$seoc = $row1['varname'];
		}
		$parse_category = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_GALLERY, 'c', $row['catid'], $seoc, '');
		$name_category = $row1["name"];
		
		// Get the comments if wish so
		if ($row1['comments'] == 1) {
			$ac = new JAK_comment($jaktable2, 'galleryid', $page2, JAK_PLUGIN_VAR_GALLERY, $jkv["gallerydateformat"], $jkv["gallerytimeformat"], $tl['general']['g56']);
			
			$JAK_COMMENTS = $ac->get_comments();
			$JAK_COMMENTS_TOTAL = $ac->get_total();
			$JAK_COMMENT_FORM = true;
			
		} else {
		
			$JAK_COMMENTS_TOTAL = 0;
			$JAK_COMMENT_FORM = false;
			
		}
		
		// Get the likes
		$PLUGIN_LIKE_ID = JAK_PLUGIN_ID_GALLERY;
		$USR_CAN_RATE = $jakusergroup->getVar("galleryrate");
		
		// Show Tags
		$JAK_TAGLIST = JAK_tags::jakGettaglist($row['catid'], JAK_PLUGIN_ID_GALLERY, JAK_PLUGIN_VAR_TAGS);
		
		// Page Nav
		$nextp = jak_next_page($page2, 'title', $jaktable, 'id', ' AND catid = "'.smartsql($row["catid"]).'"', '', 'active');
		if ($nextp) {
			
			if ($jkv["galleryurl"]) {
				$seo = JAK_base::jakCleanurl($nextp['title']);
			}
			
			$JAK_NAV_NEXT = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_GALLERY, 'p', $nextp['id'], $seo, '#ice');
			$JAK_NAV_NEXT_TITLE = $nextp['title'];
		}
		
		$prevp = jak_previous_page($page2, 'title', $jaktable, 'id', ' AND catid = "'.smartsql($row["catid"]).'"', '', 'active');
		if ($prevp) {
			
			if ($jkv["galleryurl"]) {
				$seop = JAK_base::jakCleanurl($prevp['title']);
			}
			
			$JAK_NAV_PREV = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_GALLERY, 'p', $prevp['id'], $seop, '#ice');
			$JAK_NAV_PREV_TITLE = $prevp['title'];
		}
		
		}
		
		} else {
			jak_redirect($backtogallery);
		}
		
		// Now get the new meta keywords and description maker
		$keytags = '';
		if ($JAK_TAGLIST) {
			$keytags = preg_split('/\s+/', strip_tags($JAK_TAGLIST));
			$keytags = ','.implode(',', $keytags);
		}
		$PAGE_KEYWORDS = str_replace(" ", "", JAK_Base::jakCleanurl($row['title']).$keytags.($jkv["metakey"] ? ",".$jkv["metakey"] : ""));
		$PAGE_DESCRIPTION = jak_cut_text($row['content'], 155, '');
		
		// get the standard template
		$plugin_template = 'plugins/gallery/template/'.$jkv["sitestyle"].'/galleryart.php';
			
	break;
	case 'del';
	
		if (is_numeric($page2) && is_numeric($page3) && jak_row_exist($page2,$jaktable2)) {
		
			if (JAK_GALLERYMODERATE) {
			
			$result = $jakdb->query('DELETE FROM '.$jaktable2.' WHERE id = "'.smartsql($page2).'"');
			
			if (!$result) {
				jak_redirect(JAK_PARSE_ERROR);
			} else {
			    jak_redirect(JAK_PARSE_SUCCESS);
			}
			
			} else {
				jak_redirect($backtogallery);
			}
		
		} else {
			jak_redirect($backtogallery);
		}
	
	break;
	case 'ep':
	
		if($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['userpost']) && isset($_POST['name']) && isset($_POST['editpost'])) {
			$defaults = $_POST;
							
				if (empty($defaults['userpost'])) {
				    $errors['e'] = $tl['error']['e2'];
				}
				
				if (strlen($defaults['userpost']) > $jkv["gallerymaxpost"]) {
					$countI = strlen($defaults['userpost']);
				    $errors['e'] = $tlgal['gallery']['e1'].$jkv["gallerymaxpost"].' '.$tlgal['gallery']['e2'].$countI;
				}
				
				if (is_numeric($page2) && count($errors) == 0 && jak_row_exist($page2, $jaktable2)) {
				
					define('BASE_URL_IMG', BASE_URL);
					
					$cleanpost = htmlspecialchars_decode(jak_clean_safe_userpost($defaults['userpost']));
				
					$result = $jakdb->query('UPDATE '.$jaktable2.' SET username = "'.smartsql($defaults['username']).'", web = "'.smartsql($defaults['web']).'", message = "'.smartsql($cleanpost).'" WHERE id = "'.smartsql($page2).'"');
								
				if (!$result) {
					jak_redirect(html_entity_decode(JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_GALLERY, 'ep', $page2, $page3, 'e')));
				} else {
				    jak_redirect(html_entity_decode(JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_GALLERY, 'ep', $page2, $page3, 's')));
				}
				
				} else {
				   $errors = $errors;
				   }
			
		}
	
		if (is_numeric($page2) && is_numeric($page3) && jak_row_exist($page2, $jaktable2)) {
		
			if (JAK_USERID && JAK_GALLERYDELETE && jak_give_right($page2, JAK_USERID, $jaktable2, 'userid') || JAK_GALLERYMODERATE) {
			
			$result = $jakdb->query('SELECT username, message, web FROM '.$jaktable2.' WHERE id = "'.smartsql($page2).'" LIMIT 1');
			$row = $result->fetch_assoc();
			
			$RUNAME = $row['username'];
			$RWEB = $row['web'];
			$RCONT = jak_edit_safe_userpost($row['message']);
			
			// get the standard template
			$template = 'editpost.php';
			
		} else {
			jak_redirect($backtogallery);
		}
		
		} else {
			jak_redirect($backtogallery);
		}
	break;
	case 'trash':
		if (is_numeric($page2) && is_numeric($page3) && jak_row_exist($page2, $jaktable2)) {
		
			if (JAK_USERID && JAK_GALLERYPOSTDELETE && jak_give_right($page2,JAK_USERID,$jaktable2,'userid') || JAK_GALLERYMODERATE) {
			
			$result = $jakdb->query('UPDATE '.$jaktable2.' SET trash = 1 WHERE id = "'.smartsql($page2).'"');
			
			if (!$result) {
				jak_redirect(JAK_PARSE_ERROR);
			} else {
			    jak_redirect(JAK_PARSE_SUCCESS);
			}
			
			} else {
				jak_redirect($backtogallery);
			}
		
		} else {
			jak_redirect($backtogallery);
		}
	break;
	default:
				
		$JAK_GALLERY_ALL = jak_get_gallery('LIMIT '.$jkv["galleryhlimit"], $jkv["galleryorder"], '', '', $jkv["galleryurl"], $tl['general']['g56']);
		$JAK_GALLERY_CAT = JAK_Base::jakGetcatmix(JAK_PLUGIN_VAR_GALLERY, '', $jaktable1, JAK_USERGROUPID, $jkv["galleryurl"]);
		
		$PAGE_TITLE = $jkv["gallerytitle"];
		$PAGE_CONTENT = $jkv["gallerydesc"];
		
		// Get the url session
		$_SESSION['jak_lastURL'] = $backtogallery;
		
		// Get the sort orders for the grid
		$grid = $jakdb->query('SELECT id, hookid, orderid FROM '.DB_PREFIX.'pagesgrid WHERE plugin = '.JAK_PLUGIN_ID_GALLERY.' AND galleryid = 0 ORDER BY orderid ASC');
		while ($grow = $grid->fetch_assoc()) {
			// collect each record into $pagegrid
		    $JAK_HOOK_SIDE_GRID[] = $grow;
		}
		
		// Now get the new meta keywords and description maker
		if (isset($JAK_GALLERY_ALL) && is_array($JAK_GALLERY_ALL)) foreach($JAK_GALLERY_ALL as $kv) $seokeywords[] = JAK_Base::jakCleanurl($kv['title']);
		
		if (!empty($seokeywords)) $keylist = join(",", $seokeywords);
		
		$PAGE_KEYWORDS = str_replace(" ", "", JAK_Base::jakCleanurl($PAGE_TITLE).($keylist ? ",".$keylist : "").($jkv["metakey"] ? ",".$jkv["metakey"] : ""));
		// SEO from the category content if available
		if (!empty($ca['content'])) {
			$PAGE_DESCRIPTION = jak_cut_text($ca['content'], 155, '');
		} else {
			$PAGE_DESCRIPTION = jak_cut_text($PAGE_CONTENT, 155, '');
		}
		
		// get the standard template
		$plugin_template = 'plugins/gallery/template/'.$jkv["sitestyle"].'/gallery.php';
}
?>