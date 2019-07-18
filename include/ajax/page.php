<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

if (!file_exists('../../config.php')) die('ajax/[page.php] config.php not exist');
require_once '../../config.php';

if (!file_exists('../../class/class.search.php')) die('ajax/[page.php] class.search.php not exist');
include_once '../../class/class.search.php';

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) die("Nothing to see here");

$SearchInput = strip_tags(smartsql($_GET['q']));

// Narrow down search, only three charactars and more
if (strlen($SearchInput) >= 3) {
$url = $_GET['url'];
$urldetail = $_GET['url_detail'];

// Standard search for all pages
$pages = new JAK_search($SearchInput); 
$pages->jakSettable(array('1' => 'pages', '2' => 'categories'),"t1.catid = t2.id"); // array for pages and cat
$pages->jakAndor("OR"); // We do an OR so it will search thru title and content and display one of them
$pages->jakFieldactive("active"); // Only if the page is active
$pages->jakFieldcut("t1.content"); // The content will be cuted to fit nicely
$pages->jakFieldstosearch(array('t1.title','t1.content')); // This fields will be searched
$pages->jakFieldstoselect("t2.varname, t1.title".", t1.content".", catorder, catparent"); // This will be the output for the template, packed in a array

$pagearray = $pages->set_result('', '', '');
        	
if (isset($pagearray) && is_array($pagearray)) {
	JAK_search::search_cloud($SearchInput);
	foreach($pagearray as $row) {
		
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