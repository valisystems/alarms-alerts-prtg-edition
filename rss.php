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

$jaktable = 'pages';
$jaktable1 = 'categories';

// reset urlsep
$urlsep = false;
$specialurl = array();

// Now do the dirty work!
if (empty($page1)) {

$sql = 'SELECT t1.*, t2.varname FROM '.DB_PREFIX.$jaktable.' AS t1 LEFT JOIN '.DB_PREFIX.$jaktable1.' AS t2 ON (t1.catid = t2.id) WHERE t1.active = 1 AND t1.catid != 0 AND t2.pluginid = 0 ORDER BY t1.time DESC LIMIT '.$jkv["rssitem"];
		
		$what = 0;
		$seowhat = 0;
		
		$JAK_RSS_DESCRIPTION = $jkv["metadesc"];
}

// Get the php hook for rss after all and with if statemant
$hookrss = $jakhooks->jakGethook("php_rss");
if ($hookrss) { foreach($hookrss as $hrss)
	{
		eval($hrss["phpcode"]);
	}
}

if (!empty($sql)) {

$result = $jakdb->query($sql);
while($row = $result->fetch_assoc()) {

	$PAGE_TITLE = $row['title'];
	$PAGE_CONTENT = $row['content'];
	
	$Name = htmlspecialchars($PAGE_TITLE);
	
	if ($what == 1) {
		$whatweask = $row['id'];
	} elseif (!empty($what)) {
		$whatweask = $what;
	} else {
		if ($row['varname']) $whatweask = $row['varname'];
	}
	
	if ($row['content']) {
		$getStriped = jak_cut_text($PAGE_CONTENT, $jkv["shortmsg"], '...');
	} else {
		$getStriped = jak_cut_text($PAGE_TITLE, $jkv["shortmsg"], '...');
	}
	
	$getStripedT = str_replace('&nbsp;',"",$getStriped);
	
	// get the new seo title in here, where it works!
	if ($seowhat) {
		$seo = JAK_base::jakCleanurl($PAGE_TITLE);
	}
		
	if (isset($sURL) && !empty($sURL) && !is_array($urlsep)) {
		$parseurl = JAK_rewrite::jakParseurl($sURL, $sURL1, $whatweask, $seo, '');
	} elseif (is_array($urlsep)) {
		$slurl = false;
		$specialurl =  false;
		foreach ($urlsep as $r) {
			if (is_numeric($r)) {
				$specialurl[] = $row[$r];
			} else {
				$specialurl[] = JAK_base::jakCleanurl($row[$r]);
			}
		}
		
		if ($specialurl) $slurl = join("-", $specialurl);
		
		$parseurl = JAK_rewrite::jakParseurl($sURL, $slurl, '', '', '');
	} else {
		$parseurl = JAK_rewrite::jakParseurl($whatweask, '', '', '', '');
	}
	
	$parseurl = str_replace("//", "/", BASE_URL.$parseurl);
	
	$JAK_GET_RSS_ITEM[] = array('link' => $parseurl, 'title' => $Name, 'description' => trim($getStripedT), 'created' => date("r", strtotime($row['time'])));
}

$JAK_RSS_TITLE = $jkv["title"].' - RSS';
$JAK_RSS_DATE = date(DATE_RFC2822);

// get the standard template
$template = 'rss.php';

} else {
	jak_redirect(BASE_URL);
}
?>