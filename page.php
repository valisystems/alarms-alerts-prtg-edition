<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Check if the file is accessed only via index.php if not stop the script from running
if (!defined('JAK_PREVENT_ACCESS')) die('No direct access!');

// Get the important database table
$jaktable = DB_PREFIX.'pages';

// Get the database stuff
$row = $jakdb->queryRow('SELECT * FROM '.$jaktable.' WHERE id = "'.smartsql($pageid).'"');

// Check if the page is not active and we are not an admin then we redirect
if ($row['active'] != 1 && !JAK_ASACCESS) jak_redirect(JAK_rewrite::jakParseurl($tl['link']['l3'], $tl['link']['l1'], '', '', ''));

// Now let's check the hits cookie
if (!jak_cookie_voted_hits($jaktable, $row['id'], 'hits')) {

	jak_write_vote_hits_cookie($jaktable, $row['id'], 'hits');
	
	// Update hits each time
	JAK_base::jakUpdatehits($row['id'],$jaktable);
}

$PAGE_ID = $row['id'];
$PAGE_TITLE = $row['title'];
$PAGE_CONTENT = $row['content'];
$PAGE_SHOWTITLE = $row['showtitle'];
$SHOWDATE = $row['showdate'];
$SHOWTAGS = $row['showtags'];
$SHOWSOCIALBUTTON = $row['socialbutton'];
$SHOWVOTE = $row['showvote'];
$PAGE_ACTIVE = $row['active'];
$PAGE_PASSWORD = $row['password'];
$JAK_HEADER_CSS = $row['page_css'];
$JAK_FOOTER_JAVASCRIPT = $row['page_javascript'];
$jkv["sidebar_location_tpl"] = ($row['sidebar'] ? "left" : "right");
$JAK_HEATMAPLOC = "page_".$row['id'];
 
$PAGE_LOGIN_FORM = $row['showlogin'];
$PAGE_TIME = JAK_base::jakTimesince($row['time'], $jkv["dateformat"], $jkv["timeformat"], $tl['general']['g56']);
$PAGE_TIME_HTML5 = date("Y-m-d", strtotime($row['time']));

if (JAK_USERID) {
	$PAGE_CONTENT = jak_render_string($PAGE_CONTENT, array('members' => JAK_USERID));
} else {
	$PAGE_CONTENT = jak_render_string($PAGE_CONTENT, array('notmembers' => 0));
}

// We do not show the navbar
if ($row['shownav'] == 0) $JAK_SHOW_NAVBAR = false;

// We do not show the footer
if ($row['showfooter'] == 0) $JAK_SHOW_FOOTER = false;

// Display contact form if whish so and do the caching
$JAK_SHOW_C_FORM = false;
if ($row['showcontact'] != 0) {
	$JAK_SHOW_C_FORM = jak_create_contact_form($row['showcontact'], $tl['cmsg']['c12']);
	$JAK_SHOW_C_FORM_NAME = jak_contact_form_title($row['showcontact']);
}
	
// Get news if news id is > 0
$JAK_NEWS_IN_CONTENT = false;
if (!empty($row['shownews'])) {

	// Now let's check if we display news with second option
	$shownewsarray = explode(":", $row['shownews']);
	
	if (is_array($shownewsarray) && in_array("ASC", $shownewsarray) || in_array("DESC", $shownewsarray)) {
			
		$JAK_NEWS_IN_CONTENT = jak_get_news('LIMIT '.$shownewsarray[1], '', JAK_PLUGIN_VAR_NEWS, $shownewsarray[0], $jkv["newsdateformat"], $jkv["newstimeformat"], $tl['general']['g56']);
		
	} else {

		$JAK_NEWS_IN_CONTENT = jak_get_news('', $row['shownews'], JAK_PLUGIN_VAR_NEWS, 'ASC', $jkv["newsdateformat"], $jkv["newstimeformat"], $tl['general']['g56']);
	}
	
	// Set news load to false
	$newsloadonce = false;
}
	
// Get the likes
$PLUGIN_LIKE_ID = 999;
// get the rating permission
$USR_CAN_RATE = $jakusergroup->getVar("canrate");

// Get the php hook for display stuff in pages
$hookpages = $jakhooks->jakGethook("php_pages_news");
if ($hookpages) foreach($hookpages as $hpag) {
	eval($hpag["phpcode"]);
}
  	
// Get the sort orders for the grid
$JAK_PAGE_GRID = $JAK_HOOK_SIDE_GRID = array();
$grid = $jakdb->query('SELECT id, pluginid, hookid, whatid, orderid FROM '.DB_PREFIX.'pagesgrid WHERE pageid = "'.$row['id'].'" ORDER BY orderid ASC');
while ($grow = $grid->fetch_assoc()) {
	// Load the main grid
   	if ($grow["pluginid"] && !$grow["hookid"]) $JAK_PAGE_GRID[] = $grow;
    // Load the side grid
    if ($grow["hookid"]) $JAK_HOOK_SIDE_GRID[] = $grow;
}
	  	
// Get the tags for this page
$JAK_TAGLIST = JAK_tags::jakGettaglist($row['id'], 0, JAK_PLUGIN_VAR_TAGS);

// Get hooks from page and news grid
$JAK_HOOK_PAGE_GRID = $jakhooks->jakGethook("tpl_page_news_grid");

// Get the url session
$_SESSION['jak_lastURL'] = JAK_rewrite::jakParseurl($page, $page1, $page2, '', '');

// AJAX Search
$AJAX_SEARCH_PLUGIN_WHERE = $jaktable;
$AJAX_SEARCH_PLUGIN_URL = 'include/ajax/page.php';
$AJAX_SEARCH_PLUGIN_SEO =  0;

// Now get the new meta keywords and description maker
$keytags = '';
if ($JAK_TAGLIST) {
	$keytags = preg_split('/\s+/', strip_tags($JAK_TAGLIST));
	$keytags = ','.implode(',', $keytags);
}
$PAGE_KEYWORDS = str_replace(" ", "", JAK_Base::jakCleanurl($row['title']).$keytags.($jkv["metakey"] ? ",".$jkv["metakey"] : ""));

// SEO from the category content if available
if (!empty($ca['content'])) {
	$PAGE_DESCRIPTION = jak_cut_text($ca['content'], 155, '');
} else {
	$PAGE_DESCRIPTION = jak_cut_text($row['content'], 155, '');
}
	
// Load the template
$template = 'page.php';

?>