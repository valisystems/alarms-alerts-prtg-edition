<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

if (!file_exists('../../config.php')) die('ajax/[catorder.php] config.php not exist');
require_once '../../config.php';

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || !$jakuser->jakAdminaccess($jakuser->getVar("usergroupid"))) die("Nothing to see here");

$content_array = array("status" => 0, "rcontent" => "");

if (!is_numeric($_POST['id']) && !is_array($_POST['positions'])) die("There is no such content!");

$key_value = $_POST['positions'];
$updateVals = array();
foreach($key_value as $k=>$v)
{
	$strVals[] = 'WHEN '.(int)$v.' THEN '.((int)$k+1).PHP_EOL;
}

if(!$strVals) die("0");

// We are using the CASE SQL operator to update the categories positions en masse:
$result = $jakdb->query('UPDATE '.DB_PREFIX.'shop SET ecorder = CASE id
				'.join($strVals).'
				ELSE ecorder
				END');

if (!$result) die("0");

echo "1";
?>
