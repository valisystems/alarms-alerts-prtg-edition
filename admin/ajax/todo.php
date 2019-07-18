<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

if (!file_exists('../../config.php')) die('ajax/[todo.php] config.php not exist');
require_once '../../config.php';

require "../../class/class.todo.php";

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || !$jakuser->jakAdminaccess($jakuser->getVar("usergroupid"))) die("Nothing to see here");

if (isset($_GET['id'])) $id = (int)$_GET['id'];

try {

	switch($_GET['action']) {
		case 'delete':
			Jak_ToDo::delete($id);
			break;
			
		case 'rearrange':
			Jak_ToDo::rearrange($_GET['positions']);
			break;
			
		case 'edit':
			Jak_ToDo::edit($id,$_GET['text']);
			break;
			
		case 'done':
			Jak_ToDo::done($id);
			break;
			
		case 'admin':
			Jak_ToDo::done($id);
			break;
			
		case 'new':
			Jak_ToDo::createNew($_GET['text']);
			break;
	}

}
catch(Exception $e){
//	echo $e->getMessage();
	die("0");
}
die("1");
?>