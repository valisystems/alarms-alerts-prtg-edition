<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Check if the file is accessed only via index.php if not stop the script from running
if(!defined('JAK_PREVENT_ACCESS')) die('No direct access!');

// Get the database table
$jaktable = DB_PREFIX.'news';

// parse url
$backtonews = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_NEWS, '', '', '', '');

// AJAX Search
$AJAX_SEARCH_PLUGIN_WHERE = $jaktable;
$AJAX_SEARCH_PLUGIN_URL = 'include/ajax/news.php';
$AJAX_SEARCH_PLUGIN_SEO =  1;
$JAK_SEARCH_LINK = JAK_PLUGIN_VAR_NEWS;

// The new parsing method for url and passing it to template
$P_NEWS_URL = $backtonews;

// Template Call
$JAK_TPL_PLUG_T = JAK_PLUGIN_NAME_NEWS;
$JAK_TPL_PLUG_URL = $backtonews;

// Get the CSS and Javascript into the page
$JAK_HEADER_CSS = $jkv["news_css"];
$JAK_FOOTER_JAVASCRIPT = $jkv["news_javascript"];

switch ($page1) {

	case 'a':
		
		if (is_numeric($page2)) {
		
			$page2 = filter_var($page2, FILTER_SANITIZE_NUMBER_INT);
			
			// Now perform the query
			$result = $jakdb->query('SELECT * FROM '.$jaktable.' WHERE ((startdate = 0 OR startdate <= '.time().') AND (enddate = 0 OR enddate >= '.time().')) AND (FIND_IN_SET('.JAK_USERGROUPID.',permission) OR permission = 0) AND id = '.smartsql($page2));
			
			if ($jakdb->affected_rows == 0) jak_redirect($backtonews);
			
			$row = $result->fetch_assoc();
			
			// News is not active redirect to offline news
			if ($row['active'] != 1 && !JAK_ASACCESS) {
				jak_redirect(JAK_rewrite::jakParseurl($tl['link']['l3'], $tl['errornews']['non'], '', '', ''));
			// Everything works fine, display the news!	
			} else {
			
				// Now let's check the hits cookie
				if (!jak_cookie_voted_hits($jaktable, $row['id'], 'hits')) {
				
					jak_write_vote_hits_cookie($jaktable, $row['id'], 'hits');
					
					// Update hits each time
					JAK_base::jakUpdatehits($row['id'],$jaktable);
				}
			
				$PAGE_ID = $row['id'];
				$PAGE_TITLE = $row['title'];
				$PAGE_CONTENT = jak_secure_site($row['content']);
				$JAK_HEADER_CSS = $row['news_css'];
				$JAK_FOOTER_JAVASCRIPT = $row['news_javascript'];
				$jkv["sidebar_location_tpl"] = ($row['sidebar'] ? "left" : "right");
				$SHOWTITLE = $row['showtitle'];
				$SHOWDATE = $row['showdate'];
				$SHOWSOCIALBUTTON = $row['socialbutton'];
				$SHOWVOTE = $row['showvote'];
				$PAGE_ACTIVE = $row['active'];
				$PAGE_HITS = $row['hits'];
				$PAGE_TIME = JAK_base::jakTimesince($row['time'], $jkv["newsdateformat"], $jkv["newstimeformat"], $tl['general']['g56']);
				$PAGE_TIME_HTML5 = date("Y-m-d", strtotime($row['time']));
				$JAK_HEATMAPLOC = "news_".$row['id'];
				
				// Display contact form if whish so and do the caching
				$JAK_SHOW_C_FORM = false;
				if ($row['showcontact'] != 0) {
					$JAK_SHOW_C_FORM = jak_create_contact_form($row['showcontact'], $tl['cmsg']['c12']);
					$JAK_SHOW_C_FORM_NAME = jak_contact_form_title($row['showcontact']);
					
				}
		
		// Get the likes
		$PLUGIN_LIKE_ID = 1;
		// get the rating permission
		$USR_CAN_RATE = $jakusergroup->getVar("canrate");
		
		// Inject some code for news
		$hna = $jakhooks->jakGethook("php_pages_news");
		if ($hna) { foreach($hna as $c)
		{
			eval($c["phpcode"]);
		}
		}
		
		// Get the sort orders for the grid
		$JAK_HOOK_SIDE_GRID = $JAK_PAGE_GRID = false;
		$grid = $jakdb->query('SELECT id, pluginid, hookid, whatid, orderid FROM '.DB_PREFIX.'pagesgrid WHERE newsid = "'.$row['id'].'" ORDER BY orderid ASC');
		while ($grow = $grid->fetch_assoc()) {
		        // collect each record into $newsgrid
		        if ($grow["pluginid"] && !$grow["hookid"]) {
		        	$JAK_PAGE_GRID[] = $grow;
		        }
		        
		        if ($grow["hookid"]) {
		        	$JAK_HOOK_SIDE_GRID[] = $grow;
		        }
		}
		
		// Show Tags
		$JAK_TAGLIST = JAK_tags::jakGettaglist($page2, JAK_PLUGIN_ID_NEWS, JAK_PLUGIN_VAR_TAGS);
		
		// Page Nav
		$nextp = jak_next_page($page2, 'title', $jaktable, 'id', '', '', 'active');
		if ($nextp) {
			$JAK_NAV_NEXT = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_NEWS, 'a', $nextp['id'], JAK_base::jakCleanurl($nextp['title']), '');
			$JAK_NAV_NEXT_TITLE = $nextp['title'];
		}
		
		$prevp = jak_previous_page($page2, 'title', $jaktable, 'id', '', '', 'active');
		if ($prevp) {
			$JAK_NAV_PREV = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_NEWS, 'a', $prevp['id'], JAK_base::jakCleanurl($prevp['title']), '');
			$JAK_NAV_PREV_TITLE = $prevp['title'];
		}
		
		$JAK_HOOK_NEWS_GRID = $jakhooks->jakGethook("tpl_page_news_grid");
		
		// Get the url session
		$_SESSION['jak_lastURL'] = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_NEWS, $page1, $page2, $page3, '');
		
		}
		
		// Now get the new meta keywords and description maker
		$keytags = '';
		if ($JAK_TAGLIST) {
			$keytags = preg_split('/\s+/', strip_tags($JAK_TAGLIST));
			$keytags = ','.implode(',', $keytags);
		}
		$PAGE_KEYWORDS = str_replace(" ", "", JAK_Base::jakCleanurl($PAGE_TITLE).$keytags.($jkv["metakey"] ? ",".$jkv["metakey"] : ""));
		$PAGE_DESCRIPTION = jak_cut_text($PAGE_CONTENT, 155, '');
		
		// Fire the template
		$template = 'newsart.php';
		
		} else {
			jak_redirect($backtonews);
		}
	
	break;
	default:
	
		$newsloadonce = false;
		
		$getTotal = jak_get_total($jaktable, 1, 'active', '');
		
			if ($getTotal != 0) {
			// Paginator
				$news = new JAK_Paginator;
				$news->items_total = $getTotal;
				$news->mid_range = $jkv["newspagemid"];
				$news->items_per_page = $jkv["newspageitem"];
				$news->jak_get_page = $page1;
				$news->jak_where = $backtonews;
				$news->jak_prevtext = $tl["general"]["g171"];
				$news->jak_nexttext = $tl["general"]["g172"];
				$news->paginate();
				
				$JAK_PAGINATE = $news->display_pages();
				
				// Display the news
				$JAK_NEWS_ALL = jak_get_news($news->limit, '', JAK_PLUGIN_VAR_NEWS, 'ASC', $jkv["newsdateformat"], $jkv["newstimeformat"], $tl['general']['g56']);
			}
			
			// Check if we have a language and display the right stuff
			$PAGE_TITLE = $jkv["newstitle"];
			$PAGE_CONTENT = $jkv["newsdesc"];
			
			$JAK_HEATMAPLOC = JAK_PLUGIN_VAR_NEWS;
			
			$JAK_HOOK_NEWS = $jakhooks->jakGethook("tpl_news");
			
			$PAGE_SHOWTITLE = 1;
			
			// Get the url session
			$_SESSION['jak_lastURL'] = $backtonews;
			
			// Get the sort orders for the grid
			$grid = $jakdb->query('SELECT id, hookid, pluginid, whatid, orderid FROM '.DB_PREFIX.'pagesgrid WHERE plugin = '.JAK_PLUGIN_ID_NEWS.' ORDER BY orderid ASC');
			while ($grow = $grid->fetch_assoc()) {
			        // collect each record into $pagegrid
			        	$JAK_HOOK_SIDE_GRID[] = $grow;
			}
			
			// Now get the new meta keywords and description maker
			if (isset($JAK_NEWS_ALL) && is_array($JAK_NEWS_ALL)) foreach($JAK_NEWS_ALL as $v) $seokeywords[] = JAK_Base::jakCleanurl($v['title']);
			
			$keylist = "";
			if (!empty($seokeywords)) $keylist = join(",", $seokeywords);
			
			$PAGE_KEYWORDS = str_replace(" ", "", JAK_Base::jakCleanurl($PAGE_TITLE).($keylist ? ",".$keylist : "").($jkv["metakey"] ? ",".$jkv["metakey"] : ""));
			$PAGE_DESCRIPTION = jak_cut_text($PAGE_CONTENT, 155, '');
			
			// get the standard template
			$template = 'news.php';
}
?>