<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

if (!file_exists('../../../config.php')) die('ajax/[addtocart.php] config.php not exist');
require_once '../../../config.php';

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) die("Nothing to see here");

if (!$_POST['id'] && !is_numeric($_POST['id'])) die("There is no such product!");

$jakdb->query('DELETE FROM '.DB_PREFIX.'shopping_cart WHERE session = "'.smartsql($_SESSION['shopping_cart']).'"');

echo json_encode(array('status' => 1));

?>