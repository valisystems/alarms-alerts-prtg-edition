<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Check if the file is accessed only via index.php if not stop the script from running
if (!defined('JAK_ADMIN_PREVENT_ACCESS')) die('You cannot access this file directly.');

// Check if the user has access to this file
if (!JAK_USERID || !$jakuser->jakModuleaccess(JAK_USERID, $jkv["accessmanage"])) jak_redirect(BASE_URL);

require_once('class/xml.sitemap.generator.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $defaults = $_POST;

// Create sitemap for pages
$result = $jakdb->query('SELECT varname FROM '.DB_PREFIX.'categories WHERE pageid != 0 OR pluginid > 0');

while ($row = $result->fetch_assoc()) {
	
	$parseurl = JAK_rewrite::jakParseurl($row['varname'], '', '', '', '');
		
	// collect each record into $jakdata
	$entries[] =  new xml_sitemap_entry(str_replace(BASE_URL, '', html_entity_decode($parseurl)), '1.0', 'monthly');
}

// Create sitemap for news
$result = $jakdb->query('SELECT varname FROM '.DB_PREFIX.'categories WHERE pluginid = 1');
$row = $result->fetch_assoc();

$result1 = $jakdb->query('SELECT id, title FROM '.DB_PREFIX.'news WHERE active = 1');

while ($row1 = $result1->fetch_assoc()) {
	
	$parseurl = JAK_rewrite::jakParseurl($row['varname'], $row1['id'], JAK_base::jakCleanurl($row1['title']), '', '');
		
	// collect each record into $jakdata
	$entries[] =  new xml_sitemap_entry(str_replace(BASE_URL, '', html_entity_decode($parseurl)), '1.0', 'weekly');
}

// Create sitemap for tags
$result = $jakdb->query('SELECT varname FROM '.DB_PREFIX.'categories WHERE pluginid = 3');
$row = $result->fetch_assoc();

$result1 = $jakdb->query('SELECT tag FROM '.DB_PREFIX.'tags WHERE active = 1 GROUP BY tag');

while ($row1 = $result1->fetch_assoc()) {
	
	$parseurl = JAK_rewrite::jakParseurl($row['varname'], $row1['tag'], '', '', '');
		
	// collect each record into $jakdata
	$entries[] =  new xml_sitemap_entry(str_replace(BASE_URL, '', html_entity_decode($parseurl)), '1.0', 'weekly');
}

// Create sitemap for download
// now get the plugin id for further use
$results = $jakdb->query('SELECT id FROM '.DB_PREFIX.'plugins WHERE name = "Download"');
$rows = $results->fetch_assoc();

if ($rows) {

$result = $jakdb->query('SELECT varname FROM '.DB_PREFIX.'categories WHERE pluginid = '.$rows['id']);
$row = $result->fetch_assoc();

$result1 = $jakdb->query('SELECT id, title FROM '.DB_PREFIX.'download WHERE active = 1 && catid != 0');

while ($row1 = $result1->fetch_assoc()) {

	if ($jkv["downloadurl"]) {
		$seo = JAK_base::jakCleanurl($row1['title']);
	}
	
	$parseurl = JAK_rewrite::jakParseurl($row['varname'], 'f', $row1['id'], $seo, '', '');
		
	// collect each record into $jakdata
	$entries[] =  new xml_sitemap_entry(str_replace(BASE_URL, '', html_entity_decode($parseurl)), '1.0', 'weekly');
}

$JAK_DOWNLOAD_CAT = JAK_Base::jakGetcatmix($row['varname'], '', DB_PREFIX.'downloadcategories', 0, $jkv["downloadurl"]);

if (isset($JAK_DOWNLOAD_CAT) && is_array($JAK_DOWNLOAD_CAT)) foreach($JAK_DOWNLOAD_CAT as $c) { 

	$entries[] = new xml_sitemap_entry(str_replace(BASE_URL, '', html_entity_decode($c["parseurl"])), '1.0', 'monthly');

}
}

// Create sitemap for shop
// now get the plugin id for further use
$results = $jakdb->query('SELECT id FROM '.DB_PREFIX.'plugins WHERE name = "Ecommerce"');
$rows = $results->fetch_assoc();

if ($rows) {

$result = $jakdb->query('SELECT varname FROM '.DB_PREFIX.'categories WHERE pluginid = '.$rows['id']);
$row = $result->fetch_assoc();

$result1 = $jakdb->query('SELECT id, title FROM '.DB_PREFIX.'shop WHERE active = 1 && catid != 0');

while ($row1 = $result1->fetch_assoc()) {

	if ($jkv["shopurl"]) {
		$seo = JAK_base::jakCleanurl($row1['title']);
	}
	
	$parseurl = JAK_rewrite::jakParseurl($row['varname'], 'i', $row1['id'], $seo, '', '');
		
	// collect each record into $jakdata
	$entries[] =  new xml_sitemap_entry(str_replace(BASE_URL, '', html_entity_decode($parseurl)), '1.0', 'weekly');
}

$JAK_DOWNLOAD_CAT = JAK_Base::jakGetcatmix($row['varname'], '', DB_PREFIX.'shopcategories', 0, $jkv["shopurl"]);

if (isset($JAK_DOWNLOAD_CAT) && is_array($JAK_DOWNLOAD_CAT)) foreach($JAK_DOWNLOAD_CAT as $c) { 

	$entries[] = new xml_sitemap_entry(str_replace(BASE_URL, '', html_entity_decode($c["parseurl"])), '1.0', 'monthly');

}
}

// Create sitemap for Ticketing
// now get the plugin id for further use
$results = $jakdb->query('SELECT id FROM '.DB_PREFIX.'plugins WHERE name = "Ticketing"');
$rows = $results->fetch_assoc();

if ($rows) {

$result = $jakdb->query('SELECT varname FROM '.DB_PREFIX.'categories WHERE pluginid = '.$rows['id']);
$row = $result->fetch_assoc();

$result1 = $jakdb->query('SELECT id, title FROM '.DB_PREFIX.'tickets WHERE active = 1 && catid != 0');

while ($row1 = $result1->fetch_assoc()) {

	if ($jkv["ticketurl"]) {
		$seo = JAK_base::jakCleanurl($row1['title']);
	}
	
	$parseurl = JAK_rewrite::jakParseurl($row['varname'], 't', $row1['id'], $seo, '', '');
		
	// collect each record into $jakdata
	$entries[] =  new xml_sitemap_entry(str_replace(BASE_URL, '', html_entity_decode($parseurl)), '1.0', 'weekly');
}

$JAK_TICKET_CAT = JAK_Base::jakGetcatmix($row['varname'], '', DB_PREFIX.'ticketcategories', 0, $jkv["ticketurl"]);

if (isset($JAK_TICKET_CAT) && is_array($JAK_TICKET_CAT)) foreach($JAK_TICKET_CAT as $c) { 

	$entries[] = new xml_sitemap_entry(str_replace(BASE_URL, '', html_entity_decode($c["parseurl"])), '1.0', 'monthly');

}
}

// Create sitemap for FAQ
// now get the plugin id for further use
$results = $jakdb->query('SELECT id FROM '.DB_PREFIX.'plugins WHERE name = "FAQ"');
$rows = $results->fetch_assoc();

if ($rows) {

$result = $jakdb->query('SELECT varname FROM '.DB_PREFIX.'categories WHERE pluginid = '.$rows['id']);
$row = $result->fetch_assoc();

$result1 = $jakdb->query('SELECT id, title FROM '.DB_PREFIX.'faq WHERE active = 1 && catid != 0');

while ($row1 = $result1->fetch_assoc()) {

	if ($jkv["faqurl"]) {
		$seo = JAK_base::jakCleanurl($row1['title']);
	}
	
	$parseurl = JAK_rewrite::jakParseurl($row['varname'], 'a', $row1['id'], $seo, '', '');
		
	// collect each record into $jakdata
	$entries[] =  new xml_sitemap_entry(str_replace(BASE_URL, '', html_entity_decode($parseurl)), '1.0', 'weekly');
}
$JAK_FAQ_CAT = JAK_Base::jakGetcatmix($row['varname'], '', DB_PREFIX.'faqcategories', 0, $jkv["faqurl"]);

if (isset($JAK_FAQ_CAT) && is_array($JAK_FAQ_CAT)) foreach($JAK_FAQ_CAT as $c) { 

	$entries[] = new xml_sitemap_entry(str_replace(BASE_URL, '', html_entity_decode($c["parseurl"])), '1.0', 'monthly');

}
}

// Create sitemap for Blog
// now get the plugin id for further use
$results = $jakdb->query('SELECT id FROM '.DB_PREFIX.'plugins WHERE name = "Blog"');
$rows = $results->fetch_assoc();

if ($rows) {

$result = $jakdb->query('SELECT varname FROM '.DB_PREFIX.'categories WHERE pluginid = '.$rows['id']);
$row = $result->fetch_assoc();

$result1 = $jakdb->query('SELECT id, title FROM '.DB_PREFIX.'blog WHERE active = 1 && catid != 0');

while ($row1 = $result1->fetch_assoc()) {

	if ($jkv["blogurl"]) {
		$seo = JAK_base::jakCleanurl($row1['title']);
	}
	
	$parseurl = JAK_rewrite::jakParseurl($row['varname'], 'a', $row1['id'], $seo, '', '');
		
	// collect each record into $jakdata
	$entries[] =  new xml_sitemap_entry(str_replace(BASE_URL, '', html_entity_decode($parseurl)), '1.0', 'weekly');
}

$JAK_BLOG_CAT = JAK_Base::jakGetcatmix($row['varname'], '', DB_PREFIX.'blogcategories', 0, $jkv["blogurl"]);

if (isset($JAK_BLOG_CAT) && is_array($JAK_BLOG_CAT)) foreach($JAK_BLOG_CAT as $c) { 

	$entries[] = new xml_sitemap_entry(str_replace(BASE_URL, '', html_entity_decode($c["parseurl"])), '1.0', 'monthly');

}
}

// Create sitemap for B2B Marketplace
// now get the plugin id for further use
$results = $jakdb->query('SELECT id FROM '.DB_PREFIX.'plugins WHERE name = "MarketPlace"');
$rows = $results->fetch_assoc();

if ($rows) {

$result = $jakdb->query('SELECT varname FROM '.DB_PREFIX.'categories WHERE pluginid = '.$rows['id']);
$row = $result->fetch_assoc();

$result1 = $jakdb->query('SELECT id, title FROM '.DB_PREFIX.'b2b_item WHERE active = 1 && catid != 0');

while ($row1 = $result1->fetch_assoc()) {

	if ($jkv["b2b_url"]) {
		$seo = JAK_base::jakCleanurl($row1['title']);
	}
	
	$parseurl = JAK_rewrite::jakParseurl($row['varname'], 'i', $row1['id'], $seo, '', '');
		
	// collect each record into $jakdata
	$entries[] =  new xml_sitemap_entry(str_replace(BASE_URL, '', html_entity_decode($parseurl)), '1.0', 'weekly');
}

$JAK_B2B_CAT = JAK_Base::jakGetcatmix($row['varname'], '', DB_PREFIX.'b2b_categories', 0, $jkv["b2b_url"]);

if (isset($JAK_B2B_CAT) && is_array($JAK_B2B_CAT)) foreach($JAK_B2B_CAT as $c) { 

	$entries[] = new xml_sitemap_entry(str_replace(BASE_URL, '', html_entity_decode($c["parseurl"])), '1.0', 'monthly');

}
}

if ($jkv["sitehttps"]) {
	$newURL = str_replace("https://", "", (JAK_USE_APACHE ? substr(BASE_URL_ORIG, 0, -1) : BASE_URL_ORIG));
} else {
	$newURL = str_replace("http://", "", (JAK_USE_APACHE ? substr(BASE_URL_ORIG, 0, -1) : BASE_URL_ORIG));
}

$conf = new xml_sitemap_generator_config;
$conf->setDomain($newURL);
$conf->setPath(APP_PATH.'plugins/xml_seo/files/');
$conf->setFilename('sitemap.xml');
$conf->setEntries($entries);

$generator = new xml_sitemap_generator($conf);

$xml_result = $generator->write();

}

// Title and Description
$SECTION_TITLE = "XML Sitemap";
$SECTION_DESC = "XML Sitemap for Google/Yahoo/Bing and Co.";

// Call the template
$plugin_template = 'plugins/xml_seo/admin/template/xml_seo.php';
?>