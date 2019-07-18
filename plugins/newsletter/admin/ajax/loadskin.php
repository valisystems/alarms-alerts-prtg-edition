<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Get the config file
if (!file_exists('../../../../config.php')) die('ajax/[qtips.php] config.php not exist');
require_once '../../../../config.php';

// if not ajax and not an admin, die.
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || !$jakuser->jakAdminaccess($jakuser->getVar("usergroupid"))) die("Nothing to see here");

// empty array
$content_array = array("status" => 0, "rcontent" => "");

// if no skin url, die.
if (empty($_POST['skinUrl'])) die("There is no such theme!");

// Get the content
$skinContent = file_get_contents('../../'.$_POST['skinUrl']);

// if no content, die.
if(!$skinContent) die("There is no such content!");

// Now let's start with the dirty change of the content

// Clean Base URL straight to the skin
$cleanBU = str_replace('admin/ajax/', '', BASE_URL).dirname($_POST['skinUrl']).'/';

// now add base url to all src/background/href
$cssAtt = array('background="', "url('", 'src="');
$cssUrl   = array('background="'.$cleanBU, "url('".$cleanBU, 'src="'.$cleanBU);
$skinContent = str_replace($cssAtt, $cssUrl, $skinContent);

// create the array
$content_array = array("status" => 1, "rcontent" => $skinContent);

// Echo as json
echo json_encode($content_array);
?>
