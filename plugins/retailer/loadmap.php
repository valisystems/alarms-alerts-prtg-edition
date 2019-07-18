<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

if (!file_exists('../../config.php')) die('[clubmap.php] config.php not exist');
require_once '../../config.php';

if ($_GET["url"]) {

$url = $_GET["url"];
$eurl = $_GET["eurl"];
$catid = smartsql($_GET["catid"]);
$seo = $sqlwhere = '';

// Start XML file, create parent node
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

global $jakdb;
// Search the rows in the markers table
if (is_numeric($catid)) {
	$sqlwhere = 't1.catid = '.$catid.' AND ';

}


$result = $jakdb->query(sprintf('SELECT t1.id, t1.title, t1.address, t1.previmg, t1.latitude, t1.longitude, t2.markercolor FROM '.DB_PREFIX.'retailer AS t1 LEFT JOIN '.DB_PREFIX.'retailercategories AS t2 ON (t1.catid = t2.id) WHERE '.$sqlwhere.'t1.active = 1 ORDER BY t1.id LIMIT 0 , 100'));


header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each
while ($row = $result->fetch_assoc()) {

	if ($eurl) {
		$seo = JAK_base::jakCleanurl($row['title']);
	}

	// Get the right url
	$parseurl = JAK_rewrite::jakParseurl($url, 'r', $row['id'], $seo, '');
	$parseurl = str_replace('plugins/retailer/', '', $parseurl);
	
	// Create the markers
  	$node = $dom->createElement("marker");
  	$newnode = $parnode->appendChild($node);
  	$newnode->setAttribute("name", $row['title']);
  	$newnode->setAttribute("url", $parseurl);
  	$newnode->setAttribute("address", str_replace(", ", "<br />", $row['address']));
  	$newnode->setAttribute("previmg", $row['previmg']);
  	$newnode->setAttribute("lat", $row['latitude']);
  	$newnode->setAttribute("lng", $row['longitude']);
  	$newnode->setAttribute("color", $row['markercolor']);
}

echo $dom->saveXML();

}
?>