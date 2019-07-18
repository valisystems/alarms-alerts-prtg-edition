<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

if (!file_exists('../../config.php')) die('plugins/faq/[ajaxsearch.php] config.php not exist');
require_once '../../config.php';

if (!file_exists('../../class/class.search.php')) die('ajaxsearch/[faq.php] class.search.php not exist');
include_once '../../class/class.search.php';

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) die("Nothing to see here");

$SearchInput = strip_tags(smartsql(strtolower($_GET['q'])));

// Narrow down search, only three charactars and more
if (strlen($SearchInput) >= 3 ) {
$url = $_GET['url'];
$urldetail = $_GET['url_detail'];

$faq = new JAK_search($SearchInput); 
$faq->jakSettable('faq', "");
$faq->jakAndor("OR");
$faq->jakFieldactive("active");
$faq->jakFieldtitle("title");
$faq->jakFieldcut("content");
$faq->jakFieldstosearch(array('title','content'));
$faq->jakFieldstoselect("id, title, content");

$faqarray = $faq->set_result($urldetail, 'a', $_GET['seo']);
        	
if (isset($faqarray) && is_array($faqarray)) {
JAK_search::search_cloud($SearchInput);
$text = '';
foreach($faqarray as $row) {
	
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