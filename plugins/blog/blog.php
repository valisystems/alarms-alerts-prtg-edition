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

$jaktable = DB_PREFIX.'blog';
$jaktable1 = DB_PREFIX.'blogcategories';
$jaktable2 = DB_PREFIX.'blogcomments';

$CHECK_USR_SESSION = session_id();

// Get the important template stuff
$JAK_SEARCH_WHERE = JAK_PLUGIN_VAR_BLOG;
$JAK_SEARCH_LINK = JAK_PLUGIN_VAR_BLOG;

// Heatmap
$JAK_HEATMAPLOC = JAK_PLUGIN_VAR_BLOG;

// Wright the Usergroup permission into define and for template
define('JAK_BLOGPOST', $jakusergroup->getVar("blogpost"));
define('JAK_BLOGPOSTDELETE', $jakusergroup->getVar("blogpostdelete"));
define('JAK_BLOGPOSTAPPROVE', $jakusergroup->getVar("blogpostapprove"));
define('JAK_BLOGRATE', $jakusergroup->getVar("blograte"));
define('JAK_BLOGMODERATE', $jakusergroup->getVar("blogmoderate"));

// AJAX Search
$AJAX_SEARCH_PLUGIN_WHERE = $jaktable;
$AJAX_SEARCH_PLUGIN_URL = 'plugins/blog/ajaxsearch.php';
$AJAX_SEARCH_PLUGIN_SEO =  $jkv["blogurl"];

// Get the rss if active
if ($jkv["blogrss"]) {
	$JAK_RSS_DISPLAY = 1;
	$P_RSS_LINK = JAK_rewrite::jakParseurl('rss.xml', JAK_PLUGIN_VAR_BLOG, '', '', '');
}

// Parse links once if needed a lot of time
$backtoblog = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_BLOG, '', '', '', '');

// Template Call
$JAK_TPL_PLUG_T = JAK_PLUGIN_NAME_BLOG;
$JAK_TPL_PLUG_URL = $backtoblog;

switch ($page1) {
	case 'c':
	
			if (is_numeric($page2) && jak_row_permission($page2,$jaktable1,JAK_USERGROUPID)) {
			
			if ($jkv["blogurl"]) {
				$getWhere = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_BLOG, $page1, $page2, $page3, '');
				$getPage = $page4;
			} else {
				$getWhere = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_BLOG, $page1, $page2, '', '');
				$getPage = $page3;
			}
			
			$resultgt = $jakdb->query('SELECT COUNT(*) as totalAll FROM '.$jaktable.' WHERE ((startdate = 0 OR startdate <= '.time().') AND (enddate = 0 || enddate >= '.time().')) AND catid IN('.smartsql($page2).') AND active = 1');
			$getTotal = $resultgt->fetch_assoc();
		
			if ($getTotal["totalAll"] != 0) {
			
			// Paginator
				$blogc = new JAK_Paginator;
				$blogc->items_total = $getTotal["totalAll"];
				$blogc->mid_range = $jkv["blogpagemid"];
				$blogc->items_per_page = $jkv["blogpageitem"];
				$blogc->jak_get_page = $getPage;
				$blogc->jak_where = $getWhere;
				$blogc->jak_prevtext = $tl["general"]["g171"];
				$blogc->jak_nexttext = $tl["general"]["g172"];
				$blogc->paginate();
				$JAK_PAGINATE = $blogc->display_pages();
				}
				
			$JAK_BLOG_ALL = jak_get_blog($blogc->limit, $jkv["blogorder"], $page2, 't1.catid', $jkv["blogurl"], $tl['general']['g56']);
			
			$row = $jakdb->queryRow('SELECT name, content FROM '.$jaktable1.' WHERE id = "'.smartsql($page2).'" LIMIT 1');
			
			$PAGE_TITLE = JAK_PLUGIN_NAME_BLOG.' - '.$row['name'];
			$PAGE_CONTENT = $row['content'];
			
			// Get the sort orders for the grid
			$JAK_HOOK_SIDE_GRID = false;
			$grid = $jakdb->query('SELECT id, hookid, pluginid, whatid, orderid FROM '.DB_PREFIX.'pagesgrid WHERE plugin = '.JAK_PLUGIN_ID_BLOG.' AND blogid = 0 ORDER BY orderid ASC');
			while ($grow = $grid->fetch_assoc()) {
			        // collect each record into $pagegrid
			        	$JAK_HOOK_SIDE_GRID[] = $grow;
			}
			
			// Get the url session
			$_SESSION['jak_lastURL'] = $getWhere;
			
			// Now get the new meta keywords and description maker
			if (isset($JAK_BLOG_ALL) && is_array($JAK_BLOG_ALL)) foreach($JAK_BLOG_ALL as $kv) $seokeywords[] = JAK_Base::jakCleanurl($kv['title']);
			
			if (!empty($seokeywords)) $keylist = join(",", $seokeywords);
			
			$PAGE_KEYWORDS = str_replace(" ", "", JAK_Base::jakCleanurl($row['name']).($keylist ? ",".$keylist : "").($jkv["metakey"] ? ",".$jkv["metakey"] : ""));
			$PAGE_DESCRIPTION = jak_cut_text($row['content'], 155, '');
			
			$JAK_HEADER_CSS = $jkv["blog_css"];
			$JAK_FOOTER_JAVASCRIPT = $jkv["blog_javascript"];
			
			// get the standard template
			$plugin_template = 'plugins/blog/template/'.$jkv["sitestyle"].'/blog.php';
			
			} else {
				jak_redirect($backtoblog);
			}
		
	break;
	case 'a':
	
		if (is_numeric($page2) && jak_row_exist($page2, $jaktable)) {
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['userPost'])) {
		
			$arr = array();
			
			$validates = JAK_comment::validate_form($arr, $jkv["blogmaxpost"], $tl['error']['e'], $tl['error']['e1'], $tlblog['blog']['e3'], $tl['error']['e2'], $tlblog['blog']['e1'], $tlblog['blog']['e2'], $tl['error']['e10']);
			
			if ($validates) {
				/* Everything is OK, insert to database: */
				
				define('BASE_URL_IMG', BASE_URL);
				
				$cleanusername = smartsql($arr['co_name']);
				$cleanuserpostB = htmlspecialchars_decode(jak_clean_safe_userpost($arr['userpost']));
				
				// is this an answer of another comment
				$quotemsg = 0;
				if (isset($arr['comanswerid']) && $arr['comanswerid'] > 0) $quotemsg = $arr['comanswerid'];
				
				// the new session check for displaying messages to user even if not approved
				$sqlset = 0;
				if (!JAK_BLOGPOSTAPPROVE) {
					$sqlset = session_id();
				}
				
				if (JAK_USERID) {
					
					$sql = $jakdb->query('INSERT INTO '.$jaktable2.' VALUES (NULL, "'.$page2.'", "'.smartsql($quotemsg).'", "'.smartsql(JAK_USERID).'", "'.$cleanusername.'", NULL, NULL, "'.smartsql($cleanuserpostB).'", "'.smartsql(JAK_BLOGPOSTAPPROVE).'", 0, 0, NOW(), "'.smartsql($sqlset).'")');
					
					$arr['id'] = $jakdb->jak_last_id();
				
				} else {
					
					// Additional Fields
					$cleanemail = filter_var($arr['co_email'], FILTER_SANITIZE_EMAIL);
					$cleanurl = filter_var($arr['co_url'], FILTER_SANITIZE_URL);
					
					$jakdb->query('INSERT INTO '.$jaktable2.' VALUES (NULL, "'.$page2.'", "'.smartsql($quotemsg).'", 0, "'.$cleanusername.'", "'.smartsql($cleanemail).'", "'.smartsql($cleanurl).'", "'.smartsql($cleanuserpostB).'", "'.smartsql(JAK_BLOGPOSTAPPROVE).'", 0, 0, NOW(), "'.smartsql($sqlset).'")');
					
					$arr['id'] = $jakdb->jak_last_id();

				}
				
				// Send an email to the owner if wish so
				if ($jkv["blogemail"] && !JAK_BLOGMODERATE) {
				
					$mail = new PHPMailer(); // defaults to using php "mail()"
					$body = str_ireplace("[\]",'',$tlblog['blog']['d5'].' '.(JAK_USE_APACHE ? substr(BASE_URL, 0, -1) : BASE_URL).JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_BLOG, 'a', $page2, '', '').'<br>'.$tlblog['blog']['g6'].' '.BASE_URL.'admin/index.php?p=blog&sb=blogcomment&ssb=approval&sssb=go".');
					$mail->SetFrom($jkv["email"], $jkv["title"]);
					$mail->AddAddress($jkv["blogemail"], $cleanusername);
					$mail->Subject = $jkv["title"].' - '.$tlblog['blog']['g5'];
					$mail->MsgHTML($body);
					$mail->Send(); // Send email without any warnings
				}
				
				$arr['created'] = JAK_Base::jakTimesince(time(), $jkv["blogdateformat"], $jkv["blogtimeformat"], $tl['general']['g56']);
				
				/*
				/	The data in $arr is escaped for the mysql query,
				/	but we need the unescaped variables, so we apply,
				/	stripslashes to all the elements in the array:
				/*/
			
				/* Outputting the markup of the just-inserted comment: */
				if (isset($arr['jakajax']) && $arr['jakajax'] == "yes") {
					$acajax = new JAK_comment($jaktable2, 'id', $arr['id'], JAK_PLUGIN_VAR_BLOG, $jkv["blogdateformat"], $jkv["blogtimeformat"], $tl['general']['g56']);
					
					header('Cache-Control: no-cache');
					die(json_encode(array('status' => 1, 'html' => $acajax->get_commentajax($tl['general']['g102'], $tlblog['blog']['g3'], $tlblog['blog']['g4']))));
					
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
		
		$result = $jakdb->query('SELECT * FROM '.$jaktable.' WHERE ((startdate = 0 OR startdate <= '.time().') AND (enddate = 0 || enddate >= '.time().')) AND id = "'.smartsql($page2).'" LIMIT 1');
		$row = $result->fetch_assoc();
		
		if ($row['active'] != 1) {
		
			jak_redirect(JAK_rewrite::jakParseurl('offline'));
			
		} else {
		
		if (!jak_row_permission($row['catid'],$jaktable1,JAK_USERGROUPID)) {
			jak_redirect($backtoblog);
			
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
			$SHOWIMG = $row['previmg'];
			$SHOWDATE = $row['showdate'];
			$SHOWVOTE = $row['showvote'];
			$SHOWSOCIALBUTTON = $row['socialbutton'];
			$BLOG_HITS = $row['hits'];
			$JAK_HEADER_CSS = $row['blog_css'];
			$JAK_FOOTER_JAVASCRIPT = $row['blog_javascript'];
			$jkv["sidebar_location_tpl"] = ($row['sidebar'] ? "left" : "right");
			
			$PAGE_TIME = JAK_Base::jakTimesince($row['time'], $jkv["blogdateformat"], $jkv["blogtimeformat"], $tl['general']['g56']);
			$PAGE_TIME_HTML5 = date("Y-m-d", strtotime($row['time']));
		
		// Display contact form if whish so and do the caching
		$JAK_SHOW_C_FORM = false;
		if ($row['showcontact'] != 0) {
			$JAK_SHOW_C_FORM = jak_create_contact_form($row['showcontact'], $tl['cmsg']['c12']);
			$JAK_SHOW_C_FORM_NAME = jak_contact_form_title($row['showcontact']);
		}		
		
		// Get the url session
		$_SESSION['jak_lastURL'] = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_BLOG, $page1, $page2, $page3, '');
		
		}
		
		// Get the comments if wish so
		if ($row['comments'] == 1) {
			
			$ac = new JAK_comment($jaktable2, 'blogid', $page2, JAK_PLUGIN_VAR_BLOG, $jkv["blogdateformat"], $jkv["blogtimeformat"], $tl['general']['g56'], "", ' AND t1.commentid = 0', true);
			
			$comments_naked = $ac->get_comments();
			
			// Get the header navigation
			$JAK_COMMENTS = array(
			    'comm' => array(),
			    'subcomm' => array()
			);
			// Builds the array lists with data from the menu table
			if (isset($comments_naked)) foreach ($comments_naked as $comm) {
				// Creates entry into items array with current menu item id ie. $menu['items'][1]
				$JAK_COMMENTS['comm'][$comm['id']] = $comm;
				// Creates entry into parents array. Parents array contains a list of all items with children
				$JAK_COMMENTS['subcomm'][$comm['commentid']][] = $comm['id'];
			}
			
			// $ac = new JAK_comment($jaktable2, 'blogid', $page2, JAK_PLUGIN_VAR_BLOG, $jkv["blogdateformat"], $jkv["blogtimeformat"], $tl['general']['g56']);
			
			// $JAK_COMMENTS = $ac->get_comments();
			$JAK_COMMENTS_TOTAL = $ac->get_total();
			$JAK_COMMENT_FORM = true;
			
		} else {
		
			$JAK_COMMENTS_TOTAL = 0;
			$JAK_COMMENT_FORM = false;
			
		}
		
		// Get the likes
		$PLUGIN_LIKE_ID = JAK_PLUGIN_ID_BLOG;
		$USR_CAN_RATE = $jakusergroup->getVar("blograte");
		
		// Get the sort orders for the grid
		$grid = $jakdb->query('SELECT id, hookid, pluginid, whatid, orderid FROM '.DB_PREFIX.'pagesgrid WHERE blogid = "'.$row['id'].'" ORDER BY orderid ASC');
		while ($grow = $grid->fetch_assoc()) {
		        
		        // the sidebar grid
		        if ($grow["hookid"]) {
		        	$JAK_HOOK_SIDE_GRID[] = $grow;
		        }
		}
		
		// Show Tags
		$JAK_TAGLIST = JAK_tags::jakGettaglist($page2, JAK_PLUGIN_ID_BLOG, JAK_PLUGIN_VAR_TAGS);
		
		// Page Nav
		$nextp = jak_next_page($page2, 'title', $jaktable, 'id', ' AND catid != 0', '', 'active');
		if ($nextp) {
			
			if ($jkv["blogurl"]) {
				$seo = JAK_base::jakCleanurl($nextp['title']);
			}
			
			$JAK_NAV_NEXT = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_BLOG, 'a', $nextp['id'], $seo, '');
			$JAK_NAV_NEXT_TITLE = $nextp['title'];
		}
		
		$prevp = jak_previous_page($page2, 'title', $jaktable, 'id', ' AND catid != 0', '', 'active');
		if ($prevp) {
			
			if ($jkv["blogurl"]) {
				$seop = JAK_base::jakCleanurl($prevp['title']);
			}
			
			$JAK_NAV_PREV = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_BLOG, 'a', $prevp['id'], $seop, '');
			$JAK_NAV_PREV_TITLE = $prevp['title'];
		}
		
		// Get the categories into a list
		$resultc = $jakdb->query('SELECT id, name'.', varname FROM '.$jaktable1.' WHERE id IN('.$row['catid'].') ORDER BY id ASC');
			while($rowc = $resultc->fetch_assoc()) {
			
				if ($jkv["blogurl"]) {
					$seoc = JAK_base::jakCleanurl($rowc['varname']);
				}
			
		    	$catids[] = '<a class="label label-default" href="'.JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_BLOG, 'c', $rowc['id'], $seoc, '', '').'">'.$rowc['name'].'</a>';
		}
		
		if (!empty($catids)) {
			$BLOG_CATLIST = join(" ", $catids);
		}
		
		}
		} else {
			jak_redirect($backtoblog);
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
		$plugin_template = 'plugins/blog/template/'.$jkv["sitestyle"].'/blogart.php';
			
	break;
	case 'del';
	
		if (is_numeric($page2) && jak_row_exist($page2,$jaktable2) && JAK_BLOGMODERATE) {
			
			$result = $jakdb->query('DELETE FROM '.$jaktable2.' WHERE id = "'.smartsql($page2).'"');
			
			if (!$result) {
				jak_redirect(JAK_PARSE_ERROR);
			} else {
			    jak_redirect(JAK_PARSE_SUCCESS);
			}
		
		} else {
			jak_redirect($backtoblog);
		}
	
	break;
	case 'ep':
	
		if($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['userpost']) && isset($_POST['name']) && isset($_POST['editpost'])) {
			$defaults = $_POST;
							
				if (empty($defaults['userpost'])) {
				    $errors['e'] = $tl['error']['e2'];
				}
				
				if (strlen($defaults['userpost']) > $jkv["blogmaxpost"]) {
					$countI = strlen($defaults['userpost']);
				    $errors['e'] = $tlblog['blog']['e1'].$jkv["blogmaxpost"].' '.$tlblog['blog']['e2'].$countI;
				}
				
				if (is_numeric($page2) && count($errors) == 0 && jak_row_exist($page2, $jaktable2)) {
				
					define('BASE_URL_IMG', BASE_URL);
					
					$cleanpost = htmlspecialchars_decode(jak_clean_safe_userpost($defaults['userpost']));
				
					$result = $jakdb->query('UPDATE '.$jaktable2.' SET username = "'.smartsql($defaults['username']).'", web = "'.smartsql($defaults['web']).'", message = "'.smartsql($cleanpost).'" WHERE id = "'.smartsql($page2).'"');
								
				if (!$result) {
					jak_redirect(html_entity_decode(JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_BLOG, 'ep', $page2, $page3, 'e')));
				} else {
				    jak_redirect(html_entity_decode(JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_BLOG, 'ep', $page2, $page3, 's')));
				}
				
				} else {
				   $errors = $errors;
				}
			
		}
	
		if (is_numeric($page2) && jak_row_exist($page2, $jaktable2)) {
		
			if (JAK_USERID && JAK_BLOGDELETE && jak_give_right($page2, JAK_USERID, $jaktable2, 'userid') || JAK_BLOGMODERATE) {
			
			$result = $jakdb->query('SELECT username, message, web FROM '.$jaktable2.' WHERE id = "'.smartsql($page2).'" LIMIT 1');
			$row = $result->fetch_assoc();
			
			$RUNAME = $row['username'];
			$RWEB = $row['web'];
			$RCONT = jak_edit_safe_userpost($row['message']);
			
			// get the standard template
			$template = 'editpost.php';
			
		} else {
			jak_redirect($backtoblog);
		}
		
		} else {
			jak_redirect($backtoblog);
		}
	break;
	case 'trash':
		if (is_numeric($page2) && jak_row_exist($page2, $jaktable2)) {
		
			if (JAK_USERID && JAK_BLOGDELETE && jak_give_right($page2, JAK_USERID, $jaktable2, 'userid') || JAK_BLOGMODERATE) {
			
			$result = $jakdb->query('UPDATE '.$jaktable2.' SET trash = 1 WHERE id = "'.smartsql($page2).'"');
			
			if (!$result) {
				jak_redirect(JAK_PARSE_ERROR);
			} else {
			    jak_redirect(JAK_PARSE_SUCCESS);
			}
			
			} else {
				jak_redirect($backtoblog);
			}
		
		} else {
			jak_redirect($backtoblog);
		}
	break;
	default:
	
		$getTotal = jak_get_total_permission_blog();
		
			if ($getTotal != 0) {
			// Paginator
				$blog = new JAK_Paginator;
				$blog->items_total = $getTotal;
				$blog->mid_range = $jkv["blogpagemid"];
				$blog->items_per_page = $jkv["blogpageitem"];
				$blog->jak_get_page = $page1;
				$blog->jak_where = $backtoblog;
				$blog->jak_prevtext = $tl["general"]["g171"];
				$blog->jak_nexttext = $tl["general"]["g172"];
				$blog->paginate();
				
				// Pagination
				$JAK_PAGINATE = $blog->display_pages();
				// Get all blogs
				$JAK_BLOG_ALL = jak_get_blog($blog->limit, $jkv["blogorder"], '', '', $jkv["blogurl"], $tl['general']['g56']);
				
			}
			
			// Get the categories	
			$JAK_BLOG_CAT = JAK_Base::jakGetcatmix(JAK_PLUGIN_VAR_BLOG, '', $jaktable1, JAK_USERGROUPID, $jkv["blogurl"]);
						
			// Check if we have a language and display the right stuff
			$PAGE_TITLE = $jkv["blogtitle"];
			$PAGE_CONTENT = $jkv["blogdesc"];
			
			// Get the url session
			$_SESSION['jak_lastURL'] = $backtoblog;
			
			// Get the sort orders for the grid
			$JAK_HOOK_SIDE_GRID = false;
			$grid = $jakdb->query('SELECT id, hookid, pluginid, whatid, orderid FROM '.DB_PREFIX.'pagesgrid WHERE plugin = '.JAK_PLUGIN_ID_BLOG.' AND blogid = 0 ORDER BY orderid ASC');
			while ($grow = $grid->fetch_assoc()) {
			        // collect each record into $pagegrid
			        	$JAK_HOOK_SIDE_GRID[] = $grow;
			}
			
			// Now get the new meta keywords and description maker
			if (isset($JAK_BLOG_ALL) && is_array($JAK_BLOG_ALL)) foreach($JAK_BLOG_ALL as $kv) $seokeywords[] = JAK_Base::jakCleanurl($kv['title']);
			
			if (!empty($seokeywords)) $keylist = join(",", $seokeywords);
			
			$PAGE_KEYWORDS = str_replace(" ", "", JAK_Base::jakCleanurl($PAGE_TITLE).($keylist ? ",".$keylist : "").($jkv["metakey"] ? ",".$jkv["metakey"] : ""));
			// SEO from the category content if available
			if (!empty($ca['content'])) {
				$PAGE_DESCRIPTION = jak_cut_text($ca['content'], 155, '');
			} else {
				$PAGE_DESCRIPTION = jak_cut_text($PAGE_CONTENT, 155, '');
			}
			
			// Get the CSS and Javascript into the page
			$JAK_HEADER_CSS = $jkv["blog_css"];
			$JAK_FOOTER_JAVASCRIPT = $jkv["blog_javascript"];
			
			// get the standard template
			$plugin_template = 'plugins/blog/template/'.$jkv["sitestyle"].'/blog.php';
}
?>