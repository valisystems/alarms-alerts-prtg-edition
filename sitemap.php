<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Check if the file is accessed only via index.php if not stop the script from running
if(!defined('JAK_PREVENT_ACCESS')) die('No direct access!');

// Call the hooks per name
$JAK_HOOK_SITEMAP = $jakhooks->jakGethook("tpl_sitemap");

// Get the url session
$_SESSION['jak_lastURL'] = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_SITEMAP, '', '', '', '');

// Get the php hook for tags
$hooksitemap = $jakhooks->jakGethook("php_sitemap");
if ($hooksitemap) {
	foreach($hooksitemap as $th) {
		eval($th['phpcode']);
	}
}

// Check if we have a language and display the right stuff
$PAGE_TITLE = $jkv["sitemaptitle"];
$PAGE_CONTENT = $jkv["sitemapdesc"];

// Page Title
$PAGE_SHOWTITLE = 1;

// Get the sort orders for the grid
$JAK_HOOK_SIDE_GRID = false;
$grid = $jakdb->query('SELECT id, hookid, pluginid, whatid, orderid FROM '.DB_PREFIX.'pagesgrid WHERE plugin = '.JAK_PLUGIN_ID_SITEMAP.' ORDER BY orderid ASC');
while ($grow = $grid->fetch_assoc()) {
	// collect each record into $pagegrid
    $JAK_HOOK_SIDE_GRID[] = $grow;
}

// Now get the new meta keywords and description maker
$PAGE_KEYWORDS = str_replace(" ", "", JAK_Base::jakCleanurl(JAK_PLUGIN_NAME_SITEMAP).($jkv["metakey"] ? ",".$jkv["metakey"] : ""));
$PAGE_DESCRIPTION = $jkv["metadesc"];

// get the standard template
$template = 'sitemap.php';
?>