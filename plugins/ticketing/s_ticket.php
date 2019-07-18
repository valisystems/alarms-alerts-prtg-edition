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

$jaktable = DB_PREFIX.'tickets';
$jaktable1 = DB_PREFIX.'ticketcategories';
$jaktable2 = DB_PREFIX.'ticketcomments';
$jaktable3 = DB_PREFIX.'ticketoptions';

$CHECK_USR_SESSION = session_id();

// Get the important template stuff
$JAK_SEARCH_WHERE = JAK_PLUGIN_VAR_TICKETING;
$JAK_SEARCH_LINK = JAK_PLUGIN_VAR_TICKETING;

// Heatmap
$JAK_HEATMAPLOC = JAK_PLUGIN_VAR_TICKETING;

// Wright the Usergroup permission into define and for template
define('JAK_TICKETPOST', $jakusergroup->getVar("ticketpost"));
define('JAK_TICKETPOSTDELETE', $jakusergroup->getVar("ticketpostdelete"));
define('JAK_TICKETPOSTAPPROVE', $jakusergroup->getVar("ticketpostapprove"));
define('JAK_TICKETRATE', $jakusergroup->getVar("ticketrate"));
define('JAK_TICKETMODERATE', $jakusergroup->getVar("ticketmoderate"));

// AJAX Search
$AJAX_SEARCH_PLUGIN_WHERE = $jaktable;
$AJAX_SEARCH_PLUGIN_URL = 'plugins/ticketing/ajaxsearch.php';
$AJAX_SEARCH_PLUGIN_SEO =  $jkv["ticketurl"];

// Parse links once if needed a lot of time
$backtoticket = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_TICKETING, '', '', '', '');
$P_TICKET_N = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_TICKETING, 'n', '', '', '');

// Template Call
$JAK_TPL_PLUG_T = JAK_PLUGIN_NAME_TICKETING;
$JAK_TPL_PLUG_URL = $backtoticket;

// Get the rss if active
if ($jkv["ticketrss"]) {
	$JAK_RSS_DISPLAY = 1;
	$P_RSS_LINK = JAK_rewrite::jakParseurl('rss.xml', JAK_PLUGIN_VAR_TICKETING, '', '', '');
}

// Get the general settings out the database
$result = $jakdb->query('SELECT id, name, img FROM '.$jaktable3.' ORDER BY optorder ASC');

    while ($row = $result->fetch_assoc()) {
    
    	// Parse URL
    	$parseurl = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_TICKETING, 's', $row['id'], '', '');
    	
    	$JAK_ST_OPT[] = array('id' => $row['id'], 'name' => $row['name'], 'img' => $row['img'], 'parseurl' => $parseurl);
    }
    
// Get the sort orders for the grid
$grid = $jakdb->query('SELECT id, hookid, pluginid, whatid, orderid FROM '.DB_PREFIX.'pagesgrid WHERE plugin = '.JAK_PLUGIN_ID_TICKETING.' ORDER BY orderid ASC');

while ($grow = $grid->fetch_assoc()) {
        // collect each record into $pagegrid
        	$JAK_HOOK_SIDE_GRID[] = $grow;
}

switch ($page1) {
	case 'c':
	
			if (is_numeric($page2) && jak_row_permission($page2, $jaktable1, JAK_USERGROUPID)) {
			
			if (JAK_TICKETMODERATE) {
				$sqlw = 'stprivate = 0 OR stprivate = 1';
			} elseif (JAK_USERID) {
				$sqlw = 'stprivate = 0 OR (stprivate = 1 AND userid = '.JAK_USERID.')';
			} else {
				$sqlw = 'stprivate = 0';
			}
				
				// First get the total bug or request
				$result = $jakdb->query('SELECT COUNT(*) as totalAll FROM '.$jaktable.' WHERE ('.$sqlw.') AND catid = "'.smartsql($page2).'" AND active = 1');
				$row = $result->fetch_assoc();
				
				$getTotal = $row['totalAll'];
				
				
				if ($jkv["ticketurl"]) {
						$getWhere = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_TICKETING, $page1, $page2, $page3, '');
					$getPage = $page4;
				} else {
						$getWhere = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_TICKETING, $page1, $page2, '', '');
					$getPage = $page3;
				}
			
				if ($getTotal != 0) {
				
					// Paginator
					$st = new JAK_Paginator;
					$st->items_total = $getTotal;
					$st->mid_range = $jkv["ticketpagemid"];
					$st->items_per_page = $jkv["ticketpageitem"];
					$st->jak_get_page = $getPage;
					$st->jak_where = $getWhere;
					$st->jak_prevtext = $tl["general"]["g171"];
					$st->jak_nexttext = $tl["general"]["g172"];
					$st->paginate();
					$JAK_PAGINATE = $st->display_pages();
					
					$JAK_TICKET_ALL = jak_get_ticket($st->limit, $jkv["ticketorder"], $page2, 't1.catid', $jkv["ticketurl"], $tl['general']['g56']);
					
				}
				
				$result = $jakdb->query('SELECT name'.', content'.' FROM '.$jaktable1.' WHERE id = "'.smartsql($page2).'" LIMIT 1');
				$row = $result->fetch_assoc();
				
				$PAGE_TITLE = JAK_PLUGIN_NAME_TICKETING.' - '.$row['name'];
				$PAGE_CONTENT = $row['content'];
				
				// Get the url session
				$_SESSION['jak_lastURL'] = $getWhere;
				
				// Now get the new meta keywords and description maker
				if (isset($JAK_TICKET_ALL) && is_array($JAK_TICKET_ALL)) foreach($JAK_TICKET_ALL as $kv) $seokeywords[] = JAK_Base::jakCleanurl($kv['title']);
				
				if (!empty($seokeywords)) $keylist = join(",", $seokeywords);
				
				$PAGE_KEYWORDS = str_replace(" ", "", JAK_Base::jakCleanurl($PAGE_TITLE).($keylist ? ",".$keylist : "").($jkv["metakey"] ? ",".$jkv["metakey"] : ""));
				$PAGE_DESCRIPTION = jak_cut_text($PAGE_CONTENT, 155, '');
				
				// get the standard template
				$plugin_template = 'plugins/ticketing/template/'.$jkv["sitestyle"].'/ticket.php';
			
			} else {
				jak_redirect($backtoticket);
			}
		
	break;
	case 's';
	
		if (is_numeric($page2)) {
			
			if (JAK_TICKETMODERATE) {
				$sqlw = 'stprivate = 0 OR stprivate = 1';
			} elseif (JAK_USERID) {
				$sqlw = 'stprivate = 0 OR (stprivate = 1 AND userid = '.JAK_USERID.')';
			} else {
				$sqlw = 'stprivate = 0';
			}
			
			// First get the total bug or request
			$result = $jakdb->query('SELECT COUNT(*) as totalAll FROM '.$jaktable.' WHERE ('.$sqlw.') AND active = 1 AND typeticket = "'.smartsql($page2).'"');
			$row = $result->fetch_assoc();
			
			$getTotal = $row['totalAll'];
			
			
			$getWhere = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_TICKETING, $page1, $page2, '', '');
			$getPage = $page3;
		
			if ($getTotal != 0) {
			
				// Paginator
				$st = new JAK_Paginator;
				$st->items_total = $getTotal;
				$st->mid_range = $jkv["ticketpagemid"];
				$st->items_per_page = $jkv["ticketpageitem"];
				$st->jak_get_page = $getPage;
				$st->jak_where = $getWhere;
				$st->jak_prevtext = $tl["general"]["g171"];
				$st->jak_nexttext = $tl["general"]["g172"];
				$st->paginate();
				$JAK_PAGINATE = $st->display_pages();
				
				$JAK_TICKET_ALL = jak_get_ticket($st->limit, $jkv["ticketorder"], $page2, 't1.typeticket', $jkv["ticketurl"], $tl['general']['g56']);
				
			}
			
			$PAGE_CONTENT = $jkv["ticketdesc"];
			$PAGE_TITLE = $jkv["tickettitle"];
			
			// Get the url session
			$_SESSION['jak_lastURL'] = $getWhere;
			
			// Now get the new meta keywords and description maker
			if (isset($JAK_TICKET_ALL) && is_array($JAK_TICKET_ALL)) foreach($JAK_TICKET_ALL as $kv) $seokeywords[] = JAK_Base::jakCleanurl($kv['title']);
			
			if (!empty($seokeywords)) $keylist = join(",", $seokeywords);
			
			$PAGE_KEYWORDS = str_replace(" ", "", JAK_Base::jakCleanurl($PAGE_TITLE).($keylist ? ",".$keylist : "").($jkv["metakey"] ? ",".$jkv["metakey"] : ""));
			$PAGE_DESCRIPTION = jak_cut_text($PAGE_CONTENT, 155, '');
			
			// get the standard template
			$plugin_template = 'plugins/ticketing/template/'.$jkv["sitestyle"].'/ticket.php';
			
			} else {
				jak_redirect($backtoticket);
			}
			
	break;
	case 't':
	
		if (is_numeric($page2) && jak_row_exist($page2,$jaktable)) {
		
		// Save the comments via AJAX, if not possible do it with normal post
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['admin_mod_ticket'])) {
		
			if (JAK_ASACCESS || JAK_TICKETMODERATE) {
				
				$ticket_mod = $_POST['admin_mod_ticket'];
				$ticketupdate = '';
				// We are closing
				if ($ticket_mod == 1) {
					$ticketupdate = ' SET status = 1, resolution = 1';
				} elseif ($ticket_mod == 2) {
					$ticketupdate = ' SET status = 1, resolution = 0';
				// We are opening
				} elseif ($ticket_mod == 3) {
					$ticketupdate = ' SET status = 0, resolution = 1';
				} elseif ($ticket_mod == 4) {
					$ticketupdate = ' SET status = 0, resolution = 0';
				}
				
				if (!empty($ticketupdate)) {
					$jakdb->query('UPDATE '.$jaktable.$ticketupdate.' WHERE id = "'.smartsql($page2).'"');
					jak_redirect(JAK_PARSE_SUCCESS);
				}
			}
			
			// Nothing to do here and probably some silly try
			jak_redirect($backtoticket);
		}
		
		// Save the comments via AJAX, if not possible do it with normal post
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['userPost'])) {
		
			$arr = array();
			
			$validates = JAK_comment::validate_form($arr, $jkv["ticketmaxpost"], $tl['error']['e'], $tl['error']['e1'], $tl['error']['e21'], $tl['error']['e2'], $tlt['st']['e5'], $tlt['st']['e6'], $tl['error']['e10']);
			
			if ($validates) {
				/* Everything is OK, insert to database: */
				
				define('BASE_URL_IMG', BASE_URL);
				
				// Sanitize Stuff
				$cleanusername = smartsql($arr['co_name']);
				$cleanuserpostB = htmlspecialchars_decode(jak_clean_safe_userpost($arr['userpost']));
				
				// is this an answer of another comment
				$quotemsg = 0;
				if (isset($arr['comanswerid']) && $arr['comanswerid'] > 0) $quotemsg = $arr['comanswerid'];
				
				// the new session check for displaying messages to user even if not approved
				$sqlset = 0;
				if (!JAK_TICKETPOSTAPPROVE) {
					$sqlset = session_id();
				}
				
				if (JAK_USERID) {
					
					$jakdb->query('INSERT INTO '.$jaktable2.' VALUES (NULL, "'.smartsql($page2).'", "'.smartsql($quotemsg).'", "'.smartsql(JAK_USERID).'", "'.$cleanusername.'", NULL, NULL, "'.smartsql($cleanuserpostB).'", "'.smartsql(JAK_TICKETPOSTAPPROVE).'", 0, 0, NOW(), "'.smartsql($sqlset).'")');
					
					$arr['id'] = $jakdb->jak_last_id();
				
				} else {
					
					// Additional Fields
					$cleanemail = filter_var($arr['co_email'], FILTER_SANITIZE_EMAIL);
					$cleanurl = filter_var($arr['co_url'], FILTER_SANITIZE_URL);
					
					$jakdb->query('INSERT INTO '.$jaktable2.' VALUES (NULL, "'.smartsql($page2).'", "'.smartsql($quotemsg).'", 0, "'.$cleanusername.'", "'.smartsql($cleanemail).'", "'.smartsql($cleanurl).'", "'.smartsql($cleanuserpostB).'", "'.smartsql(JAK_TICKETPOSTAPPROVE).'", 0, 0, NOW(), "'.smartsql($sqlset).'")');
					
					$arr['id'] = $jakdb->jak_last_id();

				}
				
				// Send an email to the owner if wish so
				if ($jkv["ticketemail"]) {
				
				// Send an email to the creator of the ticket so he knows there is a new answer.
				$rowte = $jakdb->queryRow('SELECT title, t1.email AS ticket_email, t1.userid, t1.username, t2.email AS user_email FROM '.$jaktable.' AS t1 LEFT JOIN '.DB_PREFIX.'user AS t2 ON(t1.userid = t2.id) WHERE (t1.id = '.smartsql($page2).') AND t1.active = 1');
				
				// Get the ticket title for seo
				if ($jkv["ticketurl"]) {
					$seo = JAK_base::jakCleanurl($rowte['title']);
				}
				
				if (!empty($rowte['ticket_email'])) $rowte['user_email'] = $rowte['ticket_email'];
				
				if (!empty($rowte['user_email']) && ($rowte['userid'] != JAK_USERID)) {
				
					$mailt = new PHPMailer(); // defaults to using php "mail()"
					$bodyt = str_ireplace("[\]", '', $cleanusername.' '.$tlt['st']['t44'].' '.(JAK_USE_APACHE ? substr(BASE_URL, 0, -1) : BASE_URL).html_entity_decode(JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_TICKETING, 't', $page2, $seo)));
					$mailt->SetFrom($jkv["ticketemail"], JAK_PLUGIN_NAME_TICKETING);
					$mailt->AddAddress($rowte['user_email'], $rowte['username']);
					$mailt->Subject = $jkv["title"].' - '.JAK_PLUGIN_NAME_TICKETING;
					$mailt->MsgHTML($bodyt);
					$mailt->Send(); // Send email without any warnings
					
				}
				
					if (!JAK_TICKETMODERATE) {
				
						$mail = new PHPMailer(); // defaults to using php "mail()"
						$body = str_ireplace("[\]", '', $tlt['st']['t38'].' '.(JAK_USE_APACHE ? substr(BASE_URL, 0, -1) : BASE_URL).html_entity_decode(JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_TICKETING, 't', $page2, $seo)).'<br>'.$tlt['st']['g6'].' '.BASE_URL.'admin/index.php?p=ticketing&sb=comment&ssb=approval&sssb=go".');
						$mail->SetFrom($jkv["email"], $jkv["title"]);
						$mail->AddAddress($jkv["ticketemail"], JAK_PLUGIN_NAME_TICKETING);
						$mail->Subject = $jkv["title"].' - '.JAK_PLUGIN_NAME_TICKETING;
						$mail->MsgHTML($body);
						$mail->Send(); // Send email without any warnings
						
					}
				}
				
				$arr['created'] = JAK_Base::jakTimesince(time(), $jkv["ticketdateformat"], $jkv["tickettimeformat"], $tl['general']['g56']);
				
				/*
				/	The data in $arr is escaped for the mysql query,
				/	but we need the unescaped variables, so we apply,
				/	stripslashes to all the elements in the array:
				/*/
			
				/* Outputting the markup of the just-inserted comment: */
				if (isset($arr['jakajax']) && $arr['jakajax'] == "yes") {
					
					$acajax = new JAK_comment($jaktable2, 'id', $arr['id'], JAK_PLUGIN_VAR_TICKETING, $jkv["ticketdateformat"], $jkv["tickettimeformat"], $tl['general']['g56']);
					
					header('Cache-Control: no-cache');
					die(json_encode(array('status' => 1, 'html' => $acajax->get_commentajax($tl['general']['g102'], $tlt['st']['g3'], $tlt['st']['g4']))));
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
		
		// Get the ticket informations
		$row = $jakdb->queryRow('SELECT t1.*, t2.name AS catname, t3.name AS toption FROM '.$jaktable.' AS t1 LEFT JOIN '.$jaktable1.' AS t2 ON (t1.catid = t2.id) LEFT JOIN '.$jaktable3.' AS t3 ON (t1.typeticket = t3.id) WHERE t1.id = "'.smartsql($page2).'" LIMIT 1');
		
		// Redirect if is not active or private and no access
		if ($row['active'] != 1 && $row['session'] != session_id()) {
			jak_redirect($backtoticket);
		}
		
		// Redirect if it is private and now access
		if (!JAK_TICKETMODERATE && $row["stprivate"] == 1 && $row["userid"] != JAK_USERID) {
			jak_redirect($backtoticket);
		}
		
		// Redirect if there is no access from the category
		if (!jak_row_permission($row['catid'], $jaktable1, JAK_USERGROUPID)) {
			jak_redirect($backtoticket);
		}
			
			// Now let's check the hits cookie
			if (!jak_cookie_voted_hits($jaktable, $row['id'], 'hits')) {
			
				jak_write_vote_hits_cookie($jaktable, $row['id'], 'hits');
				
				// Update hits each time
				JAK_base::jakUpdatehits($row['id'],$jaktable);
			}
			
			$PAGE_ID = $row['id'];
			$PAGE_TITLE = $row['title'];
			$TICKET_TITLE = $row['title'];
			$PAGE_CONTENT = jak_secure_site($row['content']);
			$PAGE_SHOWTITLE = 1;
			$PAGE_EDITOR = 1;
			$PAGE_SHOWDATE = 1;
			$PAGE_ACTIVE = $row['active'];
			$SHOWVOTE = $row['showvote'];
			$SHOWSOCIALBUTTON = $row['socialbutton'];
			$TICKER_COMMENT = $row['comments'];
			
			$PAGE_TIME = JAK_Base::jakTimesince($row['time'], $jkv["ticketdateformat"], $jkv["tickettimeformat"], $tl['general']['g56']);
		
		if ($row['status'] != 1) {
			$TICKER_STATUS = '<span class="label label-warning">'.$tlt['st']['t7'].'</span>';
		} else {
			$TICKER_STATUS = '<span class="label label-success">'.$tlt['st']['t8'].'</span>';
		}
		
		if ($row['resolution'] != 1) {
			$TICKER_RESO = '<span class="label label-danger">'.$tl["general"]["g98"].'</span>';
		} else {
			$TICKER_RESO = '<span class="label label-success">'.$tl["general"]["g97"].'</span>';
		}
		
		$TICKER_ATTACH = $TICKER_ATTACH_BIG = '';
		if (!empty($row['attachment'])) {
			
			// Get path
			$trackerpath = basename($jkv["ticketpath"]);
			$filebig = str_replace("_t.", ".", $row['attachment']);
			
			$filesmalld = BASE_URL.'plugins/ticketing/'.$trackerpath.'/'.$row['attachment'];
			$filebigd = BASE_URL.'plugins/ticketing/'.$trackerpath.'/'.$filebig;
			
			$filesmallp =  str_replace("//","/",$filesmalld);
			$filebigp =  str_replace("//","/",$filebigd);
			
			$TICKER_ATTACH = $filesmallp;
			$TICKER_ATTACH_BIG = $filebigp;
		
		}
		
		// Get the url session
		$_SESSION['jak_lastURL'] = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_TICKETING, $page1, $page2, $page3, '');
		
		// Get the comments if wish so
		if ($TICKER_COMMENT == 1) {
			
			$ac = new JAK_comment($jaktable2, 'ticketid', $page2, JAK_PLUGIN_VAR_TICKETING, $jkv["ticketdateformat"], $jkv["tickettimeformat"], $tl['general']['g56'], "", ' AND t1.commentid = 0', true);
			
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

			$JAK_COMMENTS_TOTAL = $ac->get_total();
			$JAK_COMMENT_FORM = true;
			
		} else {
		
			$JAK_COMMENTS_TOTAL = 0;
			$JAK_COMMENT_FORM = false;
			
		}
		
		// Get the likes
		$PLUGIN_LIKE_ID = JAK_PLUGIN_ID_TICKETING;
		$USR_CAN_RATE = $jakusergroup->getVar("ticketrate");
		
		// Show Tags
		$JAK_TAGLIST = JAK_tags::jakGettaglist($page2, JAK_PLUGIN_ID_TICKETING, JAK_PLUGIN_VAR_TAGS);
		
		// Page Nav
		$nextp = jak_next_page($page2, 'title', $jaktable, 'id', ' AND stprivate = 0', ' AND catid = "'.smartsql($row["catid"]).'"', 'active');
		if ($nextp) {
			
			if ($jkv["ticketurl"]) {
				$seo = JAK_base::jakCleanurl($nextp['title']);
			}
			
			$JAK_NAV_NEXT = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_TICKETING, 't', $nextp['id'], $seo, '');
			$JAK_NAV_NEXT_TITLE = $nextp['title'];
		}
		
		$prevp = jak_previous_page($page2, 'title', $jaktable, 'id', ' AND stprivate = 0', ' AND catid = "'.smartsql($row["catid"]).'"', 'active');
		if ($prevp) {
			
			if ($jkv["ticketurl"]) {
				$seop = JAK_base::jakCleanurl($prevp['title']);
			}
			
			$JAK_NAV_PREV = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_TICKETING, 't', $prevp['id'], $seop, '');
			$JAK_NAV_PREV_TITLE = $prevp['title'];
		}
		
		} else {
			jak_redirect($backtoticket);
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
		$plugin_template = 'plugins/ticketing/template/'.$jkv["sitestyle"].'/ticketart.php';
	
	break;
	case 'n':
		
		if (JAK_TICKETPOST) {
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['subticket'])) {
		    $defaults = $_POST;
		    
		    $uploadthis = 0;
		    
		    if (!JAK_USERID) {
		    	
		    	if ($jkv["hvm"]) {
		    		
		    		$human_captcha = explode(':#:', $_SESSION['jak_captcha']);
		    		
		    		if ($defaults[$human_captcha[0]] == '' || $defaults[$human_captcha[0]] != $human_captcha[1]) {
		    			$errorsA['human'] = $tl['error']['e10'].'<br />';
		    		}
		    	}
		    	   
		    }
		    
		    if (empty($defaults['jak_name'])) {
		        $errors['e1'] = $tl['error']['e'].'<br />';
		    }
		    
		    if (isset($defaults['jak_email'])) {
		    	if ($defaults['jak_email'] == '' || !filter_var($defaults['jak_email'], FILTER_VALIDATE_EMAIL)) {
		        	$errors['e4'] = $tl['error']['e1'].'<br />';
		    	}
		    	
		    	if ($jkv["email_block"]) {
		    		$blockede = explode(',', $jkv["email_block"]);
		    		if (in_array($defaults['jak_email'], $blockede) || in_array(strrchr($defaults['jak_email'], "@"), $blockede)) {
		    			$errors['e4'] = $tl['error']['e21'].'<br />';
		    		}
		    	}
		    }
		    
		    if (!is_numeric($defaults['jak_catid']) || empty($defaults['jak_catid'])) {
		        $errors['e6'] = $tlt['st']['e4'].'<br />';
		    }
		
		    if (empty($defaults['jak_title'])) {
		        $errors['e'] = $tlt['st']['e8'].'<br />';
		    }
		    
		    if (empty($defaults['jak_type'])) {
		        $errors['e2'] = $tlt['st']['e3'].'<br />';
		    }
		    
		    if (empty($defaults['userpost'])) {
		        $errors['e5'] = $tl['error']['e2'].'<br />';
		    }
		    
		    if (!empty($_FILES['jak_uploadpticket']['name'])) {
		    		
		    			if ($_FILES['jak_uploadpticket']['name'] != '') {
		    			
		    			$filename = $_FILES['jak_uploadpticket']['name']; // original filename
		    			$temp = explode(".", $filename);
		    			$jak_xtension = end($temp);
		    			
		    			if ($jak_xtension == "jpg" || $jak_xtension == "jpeg" || $jak_xtension == "png" || $jak_xtension == "gif") {
		    			
		    			if ($_FILES['jak_uploadpticket']['size'] <= 500000) {
		    			
		    				$uploadthis = 1;
		    			                 		
		    			   } else {
		    			   	$errors['e3'] = $tlt['st']['e2'].'<br />';
		    			   }
		    			                
		    			   } else {
		    			   	$errors['e3'] = $tlt['st']['e1'].'<br />';
		    			   }
		    			                
		    			   } else {
		    			   	$errors['e3'] = $tlt['st']['e'].'<br />';
		    			}
		    }
		    
		if (count($errors) == 0) {
			
			$insert = '';
			if (isset($defaults['jak_email'])) {
				
				$insert .= 'email = "'.filter_var($defaults['email'], FILTER_SANITIZE_EMAIL).'",';
				
			}
			
			// Ok no errors now check if we have to upload the file
			if ($uploadthis) {
			
				 $tempFile = $_FILES['jak_uploadpticket']['tmp_name'];
				 $origName = $_FILES['jak_uploadpticket']['name'];
				 $jak_xtension = str_replace("jpeg", "jpg", $jak_xtension);
				 $glnrrand = time().rand(10, 1000);
				 $bigPhoto = "ticket_".$glnrrand.".".$jak_xtension;
				 $smallPhoto = str_replace(".", "_t.", $bigPhoto);
				 
				 $targetPath = $jkv["ticketpath"];
				 $targetFiled = $targetPath .'/'. $bigPhoto; 	    
				 $targetFile =  str_replace('//','/', $targetFiled);
				 $dbSmall = $smallPhoto;
				 $dbBig = $bigPhoto;
				         
				require_once APP_PATH.'include/functions_thumb.php';
				
				// Move file and create thumb     
				move_uploaded_file($tempFile,$targetFile);
				              
				create_thumbnail($targetPath, $targetFile, $smallPhoto, 200, 150, 80);
				create_thumbnail($targetPath, $targetFile, $bigPhoto, 600, 450, 80);
				
				$insert .= 'attachment = "'.smartsql($dbSmall).'",';
			
			}
			
			// Set tag active to zero
			$tagactive = 0;
			
			if (!JAK_TICKETPOSTAPPROVE) {
				$insert .= 'active = 0, session = "'.smartsql(session_id()).'",';
			}
			
			$insert .= 'comments = 1,';
			
			define('BASE_URL_IMG', BASE_URL);
			
			$titleT = filter_var($defaults['jak_title'], FILTER_SANITIZE_STRING);
			$titleT = trim($titleT);
			$cleanuserpostT = htmlspecialchars_decode(jak_clean_safe_userpost($defaults['userpost']));
			// Remove the new line characters that are left
			$cleanuserpostT = str_replace(array(chr(10), chr(13)), '', $cleanuserpostT);
		    
		    $result = $jakdb->query('INSERT INTO '.$jaktable.' SET 
		    catid = "'.smartsql($defaults['jak_catid']).'",
		    typeticket = "'.smartsql($defaults['jak_type']).'",
		    title = "'.smartsql($titleT).'",
		    content = "'.smartsql($cleanuserpostT).'",
		    priority = "'.smartsql($defaults['jak_priority']).'",
		    status = "'.smartsql($defaults['jak_status']).'",
		    resolution = "'.smartsql($defaults['jak_resolution']).'",
		    stprivate = "'.smartsql($defaults['jak_private']).'",
		    socialbutton = "'.smartsql($jkv["ticketgsocial"]).'",
		    showvote = "'.smartsql($jkv["ticketgvote"]).'",
		    userid = "'.smartsql(JAK_USERID).'",
		    username = "'.smartsql($jakuser->getVar("username")).'",
		    '.$insert.'
		    time = NOW()');
		
			$row['id'] = $jakdb->jak_last_id();
		
			if ($defaults['jak_catid'] != 0) {
		
				$jakdb->query('UPDATE '.$jaktable1.' SET count = count + 1 WHERE id = "'.smartsql($defaults['jak_catid']).'"');
				
				if (JAK_TICKETPOSTAPPROVE) {
				
					// Set Tag active to 1
					$tagactive = 1;
				
				}
			
			}
		
			if (!$result) {
		    	jak_redirect(JAK_PARSE_ERROR);
			} else {
		
				// Create Tags if the module is active
				if (!empty($defaults['jak_tags'])) {
					// check if tag does not exist and insert in cloud
					JAK_tags::jakBuildcloud($defaults['jak_tags'], $row['id'], JAK_PLUGIN_ID_TICKETING);
					// insert tag for normal use
					JAK_tags::jakInsertags($defaults['jak_tags'], $row['id'], JAK_PLUGIN_ID_TICKETING, $tagactive);
				}
				
				// if tracker url for better seo
				if ($jkv["ticketurl"]) {
					$seo = JAK_base::jakCleanurl($titleT);
				}
				
				$parseurl = html_entity_decode(JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_TICKETING, 't', $row['id'], $seo, ''));
				
				// Send an email to the owner if wish so
				if ($jkv["ticketemail"] && !JAK_TICKETMODERATE) {
				
					$mail = new PHPMailer(); // defaults to using php "mail()"
					$body = str_ireplace("[\]",'',$tlt['st']['t38'].' '.(JAK_USE_APACHE ? substr(BASE_URL, 0, -1) : BASE_URL).$parseurl.'.');
					$mail->SetFrom($jkv["email"], $jkv["title"]);
					$mail->AddAddress($jkv["ticketemail"], JAK_PLUGIN_NAME_TICKETING);
					$mail->Subject = $jkv["title"].' - '.JAK_PLUGIN_NAME_TICKETING;
					$mail->MsgHTML($body);
					$mail->Send(); // Send email without any warnings
				}
		
		        jak_redirect($parseurl);
		    }
		 } else {
		    
		    $errors = $errors;
		    }
		}
		
		$PAGE_TITLE = $tlt["st"]["t1"];
		$PAGE_CONTENT = $jkv["ticketdesc"];
		
		// Get the url session
		$_SESSION['jak_lastURL'] = $backtoticket;
		
		$JAK_TICKET_CAT = JAK_Base::jakGetcatmix(JAK_PLUGIN_VAR_TICKETING, '', DB_PREFIX.'ticketcategories', JAK_USERGROUPID, $jkv["ticketurl"]);
		
		// get the standard template
		$plugin_template = 'plugins/ticketing/template/'.$jkv["sitestyle"].'/newticket.php';
		
		
		} else {
			jak_redirect($backtoticket);
		}
		
	break;
	case 'del';
	
		if (is_numeric($page2) && is_numeric($page3) && jak_row_exist($page2,$jaktable2)) {
		
			if (JAK_TICKETMODERATE) {
			
				$result = $jakdb->query('DELETE FROM '.$jaktable2.' WHERE id = "'.smartsql($page2).'"');
			
			if (!$result) {
				jak_redirect(JAK_PARSE_ERROR);
			} else {
			    jak_redirect(JAK_PARSE_SUCCESS);
			}
			
			} else {
				jak_redirect($backtoticket);
			}
		
		} else {
			jak_redirect($backtoticket);
		}
	
	break;
	case 'ep':
	
		if($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['userpost']) && isset($_POST['name']) && isset($_POST['editpost'])) {
			$defaults = $_POST;
							
				if (empty($defaults['userpost'])) {
				    $errors['e'] = $tl['error']['e2'];
				}
				
				if (strlen($defaults['userpost']) > $jkv["ticketmaxpost"]) {
					$countI = strlen($defaults['userpost']);
				    $errors['e'] = $tlt['st']['e5'].$jkv["ticketmaxpost"].' '.$tlt['st']['e6'].$countI;
				}
				
				if (is_numeric($page2) && count($errors) == 0 && jak_row_exist($page2, $jaktable2)) {
				
					define('BASE_URL_IMG', BASE_URL);
					
					$cleanpost = htmlspecialchars_decode(jak_clean_safe_userpost($defaults['userpost']));
				
					$result = $jakdb->query('UPDATE '.$jaktable2.' SET username = "'.smartsql($defaults['username']).'", web = "'.smartsql($defaults['web']).'", message = "'.smartsql($cleanpost).'" WHERE id = "'.smartsql($page2).'"');
				
				if (!$result) {
					jak_redirect(html_entity_decode(JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_TICKETING, 'ep', $page2, $page3, 'e')));
				} else {
				    jak_redirect(html_entity_decode(JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_TICKETING, 'ep', $page2, $page3, 's')));
				}
				
				} else {
				   $errors = $errors;
				   }
			
		}
	
		if (is_numeric($page2) && is_numeric($page3) && jak_row_exist($page2, $jaktable2)) {
		
			if (JAK_TICKETMODERATE) {
			
			$row = $jakdb->queryRow('SELECT username, web, message FROM '.$jaktable2.' WHERE id = "'.smartsql($page2).'" LIMIT 1');
			
			$RUNAME = $row['username'];
			$RWEB = $row['web'];
			$RCONT = jak_edit_safe_userpost($row['message']);
			
			// get the standard template
			$template = 'editpost.php';
			
		} else {
			jak_redirect($backtoticket);
		}
		
		} else {
			jak_redirect($backtoticket);
		}
	break;
	case 'trash':
	
		if (is_numeric($page2) && is_numeric($page3) && jak_row_exist($page2, $jaktable2)) {
		
			if (JAK_USERID && JAK_TICKETPOSTDELETE && jak_give_right($page2, JAK_USERID, $jaktable2, 'userid') || JAK_TICKETMODERATE) {
			
			$result = $jakdb->query('UPDATE '.$jaktable2.' SET trash = 1 WHERE id = "'.smartsql($page2).'"');
			
			if (!$result) {
				jak_redirect(JAK_PARSE_ERROR);
			} else {
			    jak_redirect(JAK_PARSE_SUCCESS);
			}
			
			} else {
				jak_redirect($backtoticket);
			}
		
		} else {
			jak_redirect($backtoticket);
		}
		
	break;
	default:
	
		$getTotal = jak_get_total_permission_st();
		
			if ($getTotal != 0) {
			// Paginator
				$st = new JAK_Paginator;
				$st->items_total = $getTotal;
				$st->mid_range = $jkv["ticketpagemid"];
				$st->items_per_page = $jkv["ticketpageitem"];
				$st->jak_get_page = $page1;
				$st->jak_where = $backtoticket;
				$st->jak_prevtext = $tl["general"]["g171"];
				$st->jak_nexttext = $tl["general"]["g172"];
				$st->paginate();
				
				// Pagination
				$JAK_PAGINATE = $st->display_pages();
				
				// Get all tickets
				$JAK_TICKET_ALL = jak_get_ticket($st->limit, $jkv["ticketorder"], '', '', $jkv["ticketurl"], $tl['general']['g56']);
				
			}
			
			// Check if we have a language and display the right stuff
			$PAGE_TITLE = $jkv["tickettitle"];
			$PAGE_CONTENT = $jkv["ticketdesc"];
			
			// Get the url session
			$_SESSION['jak_lastURL'] = $backtoticket;
			
			// Now get the new meta keywords and description maker
			if (isset($JAK_TICKET_ALL) && is_array($JAK_TICKET_ALL)) foreach($JAK_TICKET_ALL as $kv) $seokeywords[] = JAK_Base::jakCleanurl($kv['title']);
			
			if (!empty($seokeywords)) $keylist = join(",", $seokeywords);
			
			$PAGE_KEYWORDS = str_replace(" ", "", JAK_Base::jakCleanurl($PAGE_TITLE).($keylist ? ",".$keylist : "").($jkv["metakey"] ? ",".$jkv["metakey"] : ""));
			// SEO from the category content if available
			if (!empty($ca['content'])) {
				$PAGE_DESCRIPTION = jak_cut_text($ca['content'], 155, '');
			} else {
				$PAGE_DESCRIPTION = jak_cut_text($PAGE_CONTENT, 155, '');
			}
			
			// get the standard template
			$plugin_template = 'plugins/ticketing/template/'.$jkv["sitestyle"].'/ticket.php';
			
}
?>