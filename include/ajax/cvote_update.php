<?php

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 6 May 1980 03:10:00 GMT");

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

if (!file_exists('../../config.php')) die('ajax/[like_update.php] config.php not exist');
require_once '../../config.php';

if (!$jakusergroup->getVar("canrate")) die(json_encode(array("status" => 0)));

if (is_numeric($_GET['vid'])) {

	if (isset($_GET['vote']) && ($_GET['vote'] == "up" || $_GET['vote'] == "down")) {
	
		$votesql = 'votes + 1';
		if ($_GET['vote'] == "down") {
			$votesql = 'votes - 1';
		}

		// Now update the result table
		$result = $jakdb->query('UPDATE '.$_GET['ctable'].' SET votes = '.smartsql($votesql).' WHERE id = "'.smartsql($_GET['vid']).'" LIMIT 1');
		
		die(json_encode(array("status" => 1)));
		
	}
	
	die(json_encode(array("status" => 0)));

} else {
	die(json_encode(array("status" => 0)));
}
?>