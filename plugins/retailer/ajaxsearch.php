<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

if (!file_exists('../../config.php')) die('plugins/retailer/[ajaxsearch.php] config.php not exist');
require_once '../../config.php';

if (!file_exists('../../class/class.search.php')) die('ajaxsearch/[retailer.php] class.search.php not exist');
include_once '../../class/class.search.php';

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) die("Nothing to see here");

$SearchInput = strip_tags(smartsql(strtolower($_GET['q'])));

// Narrow down search, only three charactars and more
if (strlen($SearchInput) >= 3 ) {
$url = $_GET['url'];
$urldetail = $_GET['url_detail'];

$retailer = new JAK_search($SearchInput); 
$retailer->jakSettable('retailer', "");
$retailer->jakAndor("OR");
$retailer->jakFieldactive("active");
$retailer->jakFieldtitle("title");
$retailer->jakFieldcut("content");
$retailer->jakFieldstosearch(array('title','content'));
$retailer->jakFieldstoselect("id, title, content");

$retailerarray = $retailer->set_result($urldetail, 'r', $_GET['seo']);
        	
if (isset($retailerarray) && is_array($retailerarray)) {
JAK_search::search_cloud($SearchInput);
$text = '';
foreach($retailerarray as $row) {
	
	// Now display the countries
	$text .= '
	<div class="ajaxsResult">
		<h4><a href="'.(JAK_USE_APACHE ? substr($url, 0, -1) : $url).str_replace(BASE_URL, '', $row['parseurl']).'">'.$row['title'].'</a></h4>
		<p>'.$row['content'].'</p>
	</div>
	';
} }

echo $text;

}

?>