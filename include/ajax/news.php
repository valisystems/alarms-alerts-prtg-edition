<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

if (!file_exists('../../config.php')) die('ajax/[vote.php] config.php not exist');
require_once '../../config.php';

if (!file_exists('../../class/class.search.php')) die('ajax/[page.php] class.search.php not exist');
include_once '../../class/class.search.php';

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) die("Nothing to see here");

$SearchInput = strip_tags(smartsql($_GET['q']));

// Narrow down search, only three charactars and more
if (strlen($SearchInput) >= 3) {
$url = $_GET['url'];
$urldetail = $_GET['url_detail'];

// Standard search for all pages
$news = new JAK_search($SearchInput); 
$news->jakSettable("news", ''); // array for pages and cat
$news->jakAndor("OR"); // We do an OR so it will search thru title and content and display one of them
$news->jakFieldactive("active"); // Only if the page is active
$news->jakFieldtitle("title");
$news->jakFieldcut("content"); // The content will be cuted to fit nicely
$news->jakFieldstosearch(array('title','content')); // This fields will be searched
$news->jakFieldstoselect("id, title".", content"); // This will be the output for the template, packed in a array

$newsarray = $news->set_result($urldetail, 'a', $_GET['seo']);
        	
if (isset($newsarray) && is_array($newsarray)) {
	JAK_search::search_cloud($SearchInput);
	foreach($newsarray as $row) {
		
		// Now display the countries
		$text .= '
		<div class="ajaxsResult">
			<h4><a href="'.$url.str_replace(BASE_URL, '', $row['parseurl']).'">'.$row['title'].'</a></h4>
			<p>'.$row['content'].'</p>
		</div>
		';
	} }

echo $text;

}

?>