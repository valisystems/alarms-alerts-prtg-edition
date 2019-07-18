<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Check if the file is accessed only via index.php if not stop the script from running
if (!defined('JAK_PREVENT_ACCESS')) die($tl['error']['nda']);

// Include the comment class file
require_once 'class/class.comment.php';

// Functions we need for this plugin
include_once 'functions.php';

$jaktable = DB_PREFIX.'retailer';
$jaktable1 = DB_PREFIX.'retailercategories';
$jaktable2 = DB_PREFIX.'retailercomments';

$CHECK_USR_SESSION = session_id();

// Get the important template stuff
$JAK_SEARCH_WHERE = JAK_PLUGIN_VAR_RETAILER;
$JAK_SEARCH_LINK = JAK_PLUGIN_VAR_RETAILER;

// Heatmap
$JAK_HEATMAPLOC = JAK_PLUGIN_VAR_RETAILER;

// Wright the Usergroup permission into define and for template
define('JAK_RETAILERPOST', $jakusergroup->getVar("retailerpost"));
define('JAK_RETAILERPOSTDELETE', $jakusergroup->getVar("retailerpostdelete"));
define('JAK_RETAILERPOSTAPPROVE', $jakusergroup->getVar("retailerpostapprove"));
define('JAK_RETAILERRATE', $jakusergroup->getVar("retailerrate"));
define('JAK_RETAILERMODERATE', $jakusergroup->getVar("retailermoderate"));

// AJAX Search
$AJAX_SEARCH_PLUGIN_WHERE = $jaktable;
$AJAX_SEARCH_PLUGIN_URL = 'plugins/retailer/ajaxsearch.php';
$AJAX_SEARCH_PLUGIN_SEO =  $jkv["retailerurl"];

// Get the rss if active
if ($jkv["retailerrss"]) {
	$JAK_RSS_DISPLAY = 1;
	$P_RSS_LINK = JAK_rewrite::jakParseurl('rss.xml', JAK_PLUGIN_VAR_RETAILER, '', '', '');
}

// Parse links once if needed a lot of time
$backtoretailer = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_RETAILER, '', '', '', '');

// Template Call
$JAK_TPL_PLUG_T = JAK_PLUGIN_NAME_RETAILER;
$JAK_TPL_PLUG_URL = $backtoretailer;

switch ($page1) {
	case 'c':
	
			if (is_numeric($page2) && jak_row_permission($page2,$jaktable1,JAK_USERGROUPID)) {
			
			$getTotal = jak_get_total($jaktable, $page2, 'catid', 'active');
			
			if ($jkv["retailerurl"]) {
				$getWhere = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_RETAILER, $page1, $page2, $page3, '');
				$getPage = $page4;
			} else {
				$getWhere = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_RETAILER, $page1, $page2, '', '');
				$getPage = $page3;
			}
		
			if ($getTotal != 0) {
			
			// Paginator
				$retailerc = new JAK_Paginator;
				$retailerc->items_total = $getTotal;
				$retailerc->mid_range = $jkv["retailerpagemid"];
				$retailerc->items_per_page = $jkv["retailerpageitem"];
				$retailerc->jak_get_page = $getPage;
				$retailerc->jak_where = $getWhere;
				$retailerc->jak_prevtext = $tl["general"]["g171"];
				$retailerc->jak_nexttext = $tl["general"]["g172"];
				$retailerc->paginate();
				$JAK_PAGINATE = $retailerc->display_pages();
				}
				
			$JAK_RETAILER_ALL = jak_get_retailer($retailerc->limit, $jkv["retailerorder"], $page2, 't1.catid', $jkv["retailerurl"], $tl["general"]["g56"]);
			
			$result = $jakdb->query('SELECT name, content FROM '.$jaktable1.' WHERE id = "'.smartsql($page2).'" LIMIT 1');
			$row = $result->fetch_assoc();
			
			$PAGE_TITLE = JAK_PLUGIN_NAME_RETAILER.' - '.$row['name'];
			$PAGE_CONTENT = $row['content'];
			
			// Get the sort orders for the grid
			$grid = $jakdb->query('SELECT id, hookid, orderid FROM '.DB_PREFIX.'pagesgrid WHERE plugin = '.JAK_PLUGIN_ID_RETAILER.' AND retailerid = 0 ORDER BY orderid ASC');
			while ($grow = $grid->fetch_assoc()) {
			        // collect each record into $pagegrid
			        	$JAK_HOOK_SIDE_GRID[] = $grow;
			}
			
			// Get the url session
			$_SESSION['jak_lastURL'] = $getWhere;
			
			// Now get the new meta keywords and description maker
			if (isset($JAK_RETAILER_ALL) && is_array($JAK_RETAILER_ALL)) foreach($JAK_RETAILER_ALL as $kv) $seokeywords[] = JAK_Base::jakCleanurl($kv['title']);
			
			if (!empty($seokeywords)) $keylist = join(",", $seokeywords);
			
			$PAGE_KEYWORDS = str_replace(" ", "", JAK_Base::jakCleanurl($row['name']).($keylist ? ",".$keylist : "").($jkv["metakey"] ? ",".$jkv["metakey"] : ""));
			$PAGE_DESCRIPTION = jak_cut_text($row['description'], 155, '');
			
			// Get the CSS and Javascript into the page
			$JAK_HEADER_CSS = $jkv["retailer_css"];
			$JAK_FOOTER_JAVASCRIPT = $jkv["retailer_javascript"];
			
			// get the standard template
			$plugin_template = 'plugins/retailer/template/'.$jkv["sitestyle"].'/retailer.php';
			
			} else {
				jak_redirect($backtoretailer);
			}
		
	break;
	case 'r':
	
		if (is_numeric($page2) && jak_row_exist($page2, $jaktable)) {
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['userPost'])) {
		
			$arr = array();
			
			$validates = JAK_comment::validate_form($arr, $jkv["retailermaxpost"], $tl['error']['e'], $tl['error']['e1'], $tlre['retailer']['e3'], $tl['error']['e2'], $tlre['retailer']['e1'], $tlre['retailer']['e2'], $tl['error']['e10']);
			
			if($validates)
			{
				/* Everything is OK, insert to database: */
				
				define('BASE_URL_IMG', BASE_URL);
				
				$cleanusername = smartsql($arr['co_name']);
				$cleanuserpostB = htmlspecialchars_decode(jak_clean_safe_userpost($arr['userpost']));
				
				// the new session check for displaying messages to user even if not approved
				$sqlset = 0;
				if (!JAK_RETAILERPOSTAPPROVE) {
					$sqlset = session_id();
				}
				
				if (JAK_USERID) {
					
					$sql = $jakdb->query('INSERT INTO '.$jaktable2.' VALUES (NULL, "'.$page2.'", "'.JAK_USERID.'", "'.$cleanusername.'", NULL, NULL, "'.smartsql($cleanuserpostB).'", "'.JAK_RETAILERPOSTAPPROVE.'", 0, NOW(), "'.$sqlset.'")');
					
					$arr['id'] = $jakdb->jak_last_id();
				
				} else {
					
					// Additional Fields
					$cleanemail = filter_var($arr['co_email'], FILTER_SANITIZE_EMAIL);
					$cleanurl = filter_var($arr['co_url'], FILTER_SANITIZE_URL);
					
					$jakdb->query('INSERT INTO '.$jaktable2.' VALUES (NULL, "'.$page2.'", 0, "'.$cleanusername.'", "'.$cleanemail.'", "'.$cleanurl.'", "'.smartsql($cleanuserpostB).'", "'.JAK_RETAILERPOSTAPPROVE.'", 0, NOW(), "'.$sqlset.'")');
					
					$arr['id'] = $jakdb->jak_last_id();

				}
				
				// Send an email to the owner if wish so
				if ($jkv["retaileremail"] && !JAK_RETAILERMODERATE) {
				
					$mail = new PHPMailer(); // defaults to using php "mail()"
					$body = str_ireplace("[\]",'',$tlre['retailer']['d5'].(JAK_USE_APACHE ? substr(BASE_URL, 0, -1) : BASE_URL).JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_RETAILER, 'r', $page2, '', '').'<br>'.$tlre['retailer']['g6'].' '.BASE_URL.'admin/index.php?p=retailer&sb=comment&ssb=approval&sssb=go".');
					$mail->SetFrom($jkv["email"], $jkv["title"]);
					$mail->AddAddress($jkv["retaileremail"], $cleanusername);
					$mail->Subject = $jkv["title"].' - '.$tlre['retailer']['g5'];
					$mail->MsgHTML($body);
					$mail->Send(); // Send email without any warnings
				}
				
				$arr['created'] = JAK_Base::jakTimesince(time(), $jkv["retailerdateformat"], $jkv["retailertimeformat"], $tl['general']['g56']);
			
				/* Outputting the markup of the just-inserted comment: */
				if (isset($arr['jakajax']) && $arr['jakajax'] == "yes") {
					
					$acajax = new JAK_comment($jaktable2, 'id', $arr['id'], JAK_PLUGIN_VAR_RETAILER, $jkv["retailerdateformat"], $jkv["retailertimeformat"], $tl['general']['g56']);
					
					header('Cache-Control: no-cache');
					die(json_encode(array('status' => 1, 'html' => $acajax->get_commentajax($tlre['retailer']['g2'], $tlre['retailer']['g3'], $tlre['retailer']['g4']))));
					
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
			jak_redirect($backtoretailer);
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
			$SHOWHITS = $row['showhits'];
			$SHOWVOTE = $row['showvote'];
			$JAK_COMMENT_FORM = $row['comments'];
			$SHOWSOCIALBUTTON = $row['socialbutton'];
			$RETAILER_HITS = $row['hits'];
			$RETAILER_IMG = $row['previmg'];
			$RETAILER_IMG2 = $row['previmg2'];
			$RETAILER_IMG3 = $row['previmg3'];
			$RETAILER_ADDRESS = str_replace(", ", "<br />", $row['address']);
			$RETAILER_ADDRESS_MAP = $row['address'];
			$RETAILER_PHONE = $row['phone'];
			$RETAILER_FAX = $row['fax'];
			$RETAILER_WEBURL = $row['weburl'];
			$RETAILER_EMAIL = encode_email($row['email']);
			$RETAILER_LAT = $row['latitude'];
			$RETAILER_LNG = $row['longitude'];
			$JAK_HEADER_CSS = $row['content_css'];
			$JAK_FOOTER_JAVASCRIPT = $row['content_javascript'];
			$jkv["sidebar_location_tpl"] = ($row['sidebar'] ? "left" : "right");
			
			$PAGE_TIME = JAK_Base::jakTimesince($row['time'], $jkv["retailerdateformat"], $jkv["retailertimeformat"], $tl['general']['g56']);
			$PAGE_TIME_HTML5 = date("Y-m-d", strtotime($row['time']));
		
		// Display contact form if whish so and do the caching
		$JAK_SHOW_C_FORM = false;
		if ($row['showcontact'] != 0) {
			$JAK_SHOW_C_FORM = jak_create_contact_form($row['showcontact'], $tl['cmsg']['c12']);
			$JAK_SHOW_C_FORM_NAME = jak_contact_form_title($row['showcontact']);
		}		
		
		// Get the url session
		$_SESSION['jak_lastURL'] = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_RETAILER, $page1, $page2, $page3, '');
		
		}
		
		// Get the comments if wish so
		if ($row['comments'] == 1) {
			$ac = new JAK_comment($jaktable2, 'retailerid', $page2, JAK_PLUGIN_VAR_RETAILER, $jkv["retailerdateformat"], $jkv["retailertimeformat"], $tl['general']['g56']);
			
			$JAK_COMMENTS = $ac->get_comments();
			$JAK_COMMENTS_TOTAL = $ac->get_total();
			$JAK_COMMENT_FORM = true;
			
		} else {
		
			$JAK_COMMENTS_TOTAL = 0;
			$JAK_COMMENT_FORM = false;
			
		}
		
		// Get the likes
		$PLUGIN_LIKE_ID = JAK_PLUGIN_ID_RETAILER;
		$USR_CAN_RATE = $jakusergroup->getVar("retailerrate");
		
		// Get the sort orders for the grid
		$grid = $jakdb->query('SELECT id, hookid, pluginid, whatid, orderid FROM '.DB_PREFIX.'pagesgrid WHERE retailerid = "'.$row['id'].'" ORDER BY orderid ASC');
		while ($grow = $grid->fetch_assoc()) {
		        
		        // the sidebar grid
		        if ($grow["hookid"]) {
		        	$JAK_HOOK_SIDE_GRID[] = $grow;
		        }
		}
		
		// Show Tags
		$JAK_TAGLIST = JAK_tags::jakGettaglist($page2, JAK_PLUGIN_ID_RETAILER, JAK_PLUGIN_VAR_TAGS);
		
		// Page Nav
		$nextp = jak_next_page($page2, 'title', $jaktable, 'id', ' AND catid != 0', '', 'active');
		if ($nextp) {
			
			if ($jkv["retailerurl"]) {
				$seo = JAK_base::jakCleanurl($nextp['title']);
			}
			
			$JAK_NAV_NEXT = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_RETAILER, 'r', $nextp['id'], $seo, '');
			$JAK_NAV_NEXT_TITLE = $nextp['title'];
		}
		
		$prevp = jak_previous_page($page2, 'title', $jaktable, 'id', ' AND catid != 0', '', 'active');
		if ($prevp) {
			
			if ($jkv["retailerurl"]) {
				$seop = JAK_base::jakCleanurl($prevp['title']);
			}
			
			$JAK_NAV_PREV = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_RETAILER, 'r', $prevp['id'], $seop, '');
			$JAK_NAV_PREV_TITLE = $prevp['title'];
		}
		
		// Get the categories into a list
		$resultc = $jakdb->query('SELECT id, name, varname FROM '.$jaktable1.' WHERE id IN('.$row['catid'].') ORDER BY id ASC');
			while($rowc = $resultc->fetch_assoc()) {
			
				if ($jkv["retailerurl"]) {
					$seoc = JAK_base::jakCleanurl($rowc['varname']);
				}
			
		    	$catids[] = '<a class="catlist" href="'.JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_RETAILER, 'c', $rowc['id'], $seoc, '', '').'">'.$rowc['name'].'</a>';
		}
		
		if (!empty($catids)) {
			$RETAILER_CATLIST = join(" ", $catids);
		}
		
		}
		} else {
			jak_redirect($backtoretailer);
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
		$plugin_template = 'plugins/retailer/template/'.$jkv["sitestyle"].'/retailerart.php';
			
	break;
	case 'del';
	
		if (is_numeric($page2) && is_numeric($page3) && jak_row_exist($page2,$jaktable2)) {
		
			if (JAK_RETAILERMODERATE) {
			
			$result = $jakdb->query('DELETE FROM '.$jaktable2.' WHERE id = "'.smartsql($page2).'"');
			
			if (!$result) {
				jak_redirect(JAK_PARSE_ERROR);
			} else {
			    jak_redirect(JAK_PARSE_SUCCESS);
			}
			
			} else {
				jak_redirect($backtoretailer);
			}
		
		} else {
			jak_redirect($backtoretailer);
		}
	
	break;
	case 'ep':
	
		if($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['userpost']) && isset($_POST['name']) && isset($_POST['editpost'])) {
			$defaults = $_POST;
							
				if (empty($defaults['userpost'])) {
				    $errors['e'] = $tl['error']['e2'];
				}
				
				if (strlen($defaults['userpost']) > $jkv["retailermaxpost"]) {
					$countI = strlen($defaults['userpost']);
				    $errors['e'] = $tlre['retailer']['e1'].$jkv["retailermaxpost"].' '.$tlre['retailer']['e2'].$countI;
				}
				
				if (is_numeric($page2) && count($errors) == 0 && jak_row_exist($page2, $jaktable2)) {
				
					define('BASE_URL_IMG', BASE_URL);
					
					$cleanpost = htmlspecialchars_decode(jak_clean_safe_userpost($defaults['userpost']));
				
					$result = $jakdb->query('UPDATE '.$jaktable2.' SET username = "'.smartsql($defaults['username']).'", web = "'.smartsql($defaults['web']).'", message = "'.smartsql($cleanpost).'" WHERE id = "'.smartsql($page2).'"');
								
				if (!$result) {
					jak_redirect(html_entity_decode(JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_RETAILER, 'ep', $page2, $page3, 'e')));
				} else {
				    jak_redirect(html_entity_decode(JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_RETAILER, 'ep', $page2, $page3, 's')));
				}
				
				} else {
				   $errors = $errors;
				}
			
		}
	
		if (is_numeric($page2) && is_numeric($page3) && jak_row_exist($page2, $jaktable2)) {
		
			if (JAK_USERID && JAK_RETAILERDELETE && jak_give_right($page2, JAK_USERID, $jaktable2, 'userid') || JAK_RETAILERMODERATE) {
			
			$result = $jakdb->query('SELECT username, message, web FROM '.$jaktable2.' WHERE id = "'.smartsql($page2).'" LIMIT 1');
			$row = $result->fetch_assoc();
			
			$RUNAME = $row['username'];
			$RWEB = $row['web'];
			$RCONT = jak_edit_safe_userpost($row['message']);
			
			// get the standard template
			$template = 'editpost.php';
			
		} else {
			jak_redirect($backtoretailer);
		}
		
		} else {
			jak_redirect($backtoretailer);
		}
	break;
	case 'trash':
		if (is_numeric($page2) && is_numeric($page3) && jak_row_exist($page2, $jaktable2)) {
		
			if (JAK_USERID && JAK_RETAILERPOSTDELETE && jak_give_right($page2,JAK_USERID,$jaktable2,'userid') || JAK_RETAILERMODERATE) {
			
			$result = $jakdb->query('UPDATE '.$jaktable2.' SET trash = 1 WHERE id = "'.smartsql($page2).'"');
			
			if (!$result) {
				jak_redirect(JAK_PARSE_ERROR);
			} else {
			    jak_redirect(JAK_PARSE_SUCCESS);
			}
			
			} else {
				jak_redirect($backtoretailer);
			}
		
		} else {
			jak_redirect($backtoretailer);
		}
	break;
	default:		
			
		$getTotal = jak_get_total($jaktable, '', '', 'active');
			
		if ($getTotal != 0) {
			
			// Paginator
			$retailerc = new JAK_Paginator;
			$retailerc->items_total = $getTotal;
			$retailerc->mid_range = $jkv["retailerpagemid"];
			$retailerc->items_per_page = $jkv["retailerpageitem"];
			$retailerc->jak_get_page = $page1;
			$retailerc->jak_where = $backtoretailer;
			$retailerc->jak_prevtext = $tl["general"]["g171"];
			$retailerc->jak_nexttext = $tl["general"]["g172"];
			$retailerc->paginate();
			$JAK_PAGINATE = $retailerc->display_pages();
			
			// Get the retailers
			$JAK_RETAILER_ALL = jak_get_retailer($retailerc->limit, $jkv["retailerorder"], '', '', $jkv["retailerurl"], $tl["general"]["g56"]);
			
		}
		
		// Get all categories
		$JAK_RETAILER_CAT = JAK_Base::jakGetcatmix(JAK_PLUGIN_VAR_RETAILER, '', $jaktable1, JAK_USERGROUPID, $jkv["retailerurl"]);
			
		$PAGE_TITLE = $jkv["retailertitle"];
		$PAGE_CONTENT = $jkv["retailerdesc"];
			
		// Get the url session
		$_SESSION['jak_lastURL'] = $backtoretailer;
			
		// Get the sort orders for the grid
		$grid = $jakdb->query('SELECT id, hookid, orderid FROM '.DB_PREFIX.'pagesgrid WHERE plugin = '.JAK_PLUGIN_ID_RETAILER.' AND retailerid = 0 ORDER BY orderid ASC');
		while ($grow = $grid->fetch_assoc()) {
			// collect each record into $pagegrid
			$JAK_HOOK_SIDE_GRID[] = $grow;
		}
			
		// Now get the new meta keywords and description maker
		if (isset($JAK_RETAILER_ALL) && is_array($JAK_RETAILER_ALL)) foreach($JAK_RETAILER_ALL as $kv) $seokeywords[] = JAK_Base::jakCleanurl($kv['title']);
		
		if (!empty($seokeywords)) $keylist = join(",", $seokeywords);
		
		$PAGE_KEYWORDS = str_replace(" ", "", JAK_Base::jakCleanurl($PAGE_TITLE).($keylist ? ",".$keylist : "").($jkv["metakey"] ? ",".$jkv["metakey"] : ""));
		// SEO from the category content if available
		if (!empty($ca['content'])) {
			$PAGE_DESCRIPTION = jak_cut_text($ca['content'], 155, '');
		} else {
			$PAGE_DESCRIPTION = jak_cut_text($PAGE_CONTENT, 155, '');
		}
		
		// Get the CSS and Javascript into the page
		$JAK_HEADER_CSS = $jkv["retailer_css"];
		$JAK_FOOTER_JAVASCRIPT = $jkv["retailer_javascript"];
		
		// get the standard template
		$plugin_template = 'plugins/retailer/template/'.$jkv["sitestyle"].'/retailer.php';
}
?>