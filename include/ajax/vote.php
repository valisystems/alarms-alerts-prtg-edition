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

$vote = strip_tags(smartsql($_POST['vote']));
$voteid = $_POST['voteid'];
$commid = $_POST['votecommentid'];
$table = $_POST['votetable'];

// Narrow down search, only three charactars and more
if (is_numeric($voteid) && ($vote == 'up' || $vote == 'down')) {

$jakdb->query('SHOW TABLES LIKE "'.smartsql($table).'"');
if ($jakdb->affected_rows == 1) {

$result = jak_save_vote($vote, $voteid, $table, $commid);

echo $_POST['vote'];

}

}

?>