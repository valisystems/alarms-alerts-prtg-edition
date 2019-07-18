<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

if (!file_exists('../../config.php')) die('ajax/[qtips.php] config.php not exist');
require_once '../../config.php';

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || !$jakuser->jakAdminaccess($jakuser->getVar("usergroupid"))) die("Nothing to see here");

$content_array = array("status" => 0, "rcontent" => "");

if (!is_numeric($_POST['backupid']) && !is_numeric($_POST['contentid'])) die("There is no such content!");

$row = $jakdb->queryRow('SELECT content FROM '.DB_PREFIX.'backup_content WHERE id = "'.smartsql($_POST['contentid']).'" AND '.$_POST['fid'].' = "'.smartsql($_POST['backupid']).'"');

if (!$row) die("There is no such content!");
die(json_encode(array("status" => 1, "rcontent" => $row['content'])));
?>
