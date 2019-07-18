<?php

header('Content-Type: text/event-stream');
header("Cache-Control: no-cache");
header("Expires: Sat, 6 May 1998 03:10:00 GMT");

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

if (!file_exists('../../config.php')) die('ajax/[like_results.php] config.php not exist');
require_once '../../config.php';

if (isset($_GET['aid']) && is_numeric($_GET['aid'])) {

	$result = $jakdb->query('SELECT * FROM '.DB_PREFIX.'like_counter WHERE btnid = "'.smartsql($_GET['aid']).'" AND locid = "'.smartsql($_GET['locid']).'"');
	
	if ($jakdb->affected_rows > 0) {
	
		$row = $result->fetch_assoc();
		
		$lb = "";
		
		if ($row["blike"]) {
			$lb = '<span><img src="/img/like/like_btn.png" alt="like button" /> <b class="label label-default">'.$row["blike"].'</b></span>';
		}
		if ($row["blove"]) {
			$lb .= '<span><img src="/img/like/love_btn.png" alt="love button" /> <b class="label label-default">'.$row["blove"].'</b></span>';
		}
		if ($row["brofl"]) {
			$lb .= '<span><img src="/img/like/funny_btn.png" alt="funny button" /> <b class="label label-default">'.$row["brofl"].'</b></span>';
		}
		if ($row["bsmile"]) {
			$lb .= '<span><img src="/img/like/smile_btn.png" alt="smile button" /> <b class="label label-default">'.$row["bsmile"].'</b></span>';
		}
		if ($row["bwow"]) {
			$lb .= '<span><img src="/img/like/what_btn.png" alt="what button" /> <b class="label label-default">'.$row["bwow"].'</b></span>';
		}
		if ($row["bsad"]) {
			$lb .= '<span><img src="/img/like/cry_btn.png" alt="sad button" /> <b class="label label-default">'.$row["bsad"].'</b></span>';
		}
		if ($row["bangry"]) {
			$lb .= '<span><img src="/img/like/angry_btn.png" alt="angry button" /> <b class="label label-default">'.$row["bangry"].'</b></span>';
		}
		
		die(json_encode(array("status" => true, "content" => $lb)));
			
	} else {
		die(json_encode(array("status" => false)));
	}
} else {
	die(json_encode(array("status" => false)));
}
?>