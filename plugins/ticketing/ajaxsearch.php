<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

if (!file_exists('../../config.php')) {
    die('plugins/ticketing/[ajaxsearch.php] config.php not exist');
}
require_once '../../config.php';

if (!file_exists('../../class/class.search.php')) {
    die('ajaxsearch/[ticketing.php] class.search.php not exist');
}

include_once '../../class/class.search.php';

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) die("Nothing to see here");

$SearchInput = strip_tags(smartsql(strtolower($_GET['q'])));

// Narrow down search, only three charactars and more
if (is_numeric($SearchInput)) { 
$url = $_GET['url'];
$urldetail = $_GET['url_detail'];

// First get the total bug or request
$result = $jakdb->query('SELECT id, title, content FROM '.DB_PREFIX.'tickets WHERE (id = "'.smartsql($SearchInput).'" AND active = 1 AND stprivate = 0) OR (id = "'.smartsql($SearchInput).'" AND userid = "'.JAK_USERID.'")');
$row = $result->fetch_assoc();

if ($row) {

if ($_GET['seo']) {

	$parseurl = JAK_rewrite::jakParseurl($urldetail, 't', $row["id"], JAK_base::jakCleanurl($row["title"]), '');

} else {

	$parseurl = JAK_rewrite::jakParseurl($urldetail, 't', $row["id"], '', '');

}

// Now display the countries
$text = '
<div class="ajaxsResult">
	<h4><a href="'.str_replace('plugins/ticketing/', '', $parseurl).'">'.$row['title'].'</a></h4>
	<p>'.strip_tags($row['content']).'</p>
</div>
';

echo $text;

}

} else if (!is_numeric($SearchInput) && strlen($SearchInput) >= 3) {
$url = $_GET['url'];
$urldetail = $_GET['url_detail'];

$st = new JAK_search($SearchInput); 
$st->jakSettable('tickets', "");
$st->jakAndor("OR");
$st->jakFieldactive("stprivate = 0 AND active");
$st->jakFieldtitle("title");
$st->jakFieldcut("content");
$st->jakFieldstosearch(array('title', 'content'));
$st->jakFieldstoselect("id, title, content");

$starray = $st->set_result($urldetail, 't', $_GET['seo']);
        	
if (isset($starray) && is_array($starray)) {
JAK_search::search_cloud($SearchInput);
$text = '';
foreach($starray as $row) {
	
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