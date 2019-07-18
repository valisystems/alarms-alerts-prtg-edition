<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

if (!file_exists('../../config.php')) die('[index.php] config.php not found');
require_once '../../config.php';

// Check if the file is accessed only from a admin if not stop the script from running
if (!JAK_USERID) die('You cannot access this file directly.');

// Not logged in sorry
if(!$jakuser->jakAdminaccess($jakuser->getVar("usergroupid"))) die('You cannot access this file directly.');

// Set successfully to zero
$succesfully = 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Update - Download Plugin</title>
	<meta charset="utf-8">
	<meta name="author" content="CLARICOM (http://www.claricom.ca)" />
	<link rel="stylesheet" href="../../css/stylesheet.css" type="text/css" media="screen" />
</head>
<body>

<div class="container">
<div class="row">
<div class="col-md-12">
<h3>Update - Download Plugin</h3>

<!-- Check if the plugin is already installed -->
<?php $jakdb->query('SELECT id FROM '.DB_PREFIX.'plugins WHERE name = "Download"');
if ($jakdb->affected_rows == 0) { $succesfully = 1; ?>

<div class="alert alert-danger">Plugin is not installed!!!</div>

<!-- Plugin is not installed let's display the installation script -->
<?php } else { ?>

<?php $result = $jakdb->query('SELECT id, pluginversion FROM '.DB_PREFIX.'plugins WHERE name = "Download"');
$row = $result->fetch_assoc();
if ($row['pluginversion'] == "1.1") { $succesfully = 1; $jakdb->query('UPDATE '.DB_PREFIX.'plugins SET time = NOW() WHERE name = "Download"'); ?>

<div class="alert alert-info">Plugin is already up to date!</div>

<!-- Plugin is not installed let's display the installation script -->
<?php } else { ?>

<!-- The installation button is hit -->
<?php if (isset($_POST['install'])) {

$jakdb->query('CREATE TABLE '.DB_PREFIX.'downloadhistory (
	`id` BIGINT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`fileid` INT(11) UNSIGNED NOT NULL DEFAULT 0,
	`userid` INT(11) UNSIGNED NOT NULL DEFAULT 0,
	`email` VARCHAR(255) NOT NULL,
	`filename` VARCHAR(255) NOT NULL,
	`ip` CHAR(15) NOT NULL,
	`time` DATETIME NOT NULL DEFAULT \'0000-00-00 00:00:00\',
	PRIMARY KEY (`id`),
	KEY `fileid` (`fileid`)
) ENGINE = MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1');

$jakdb->query('UPDATE '.DB_PREFIX.'plugins SET pluginversion = "1.1", time = NOW() WHERE name = "Download"');

$succesfully = 1;

?>
<div class="alert alert-success">Plugin updated successfully</div>
<?php } } ?>

<?php if (!$succesfully) { ?>
<form name="company" method="post" action="update.php" enctype="multipart/form-data">
<button type="submit" name="install" class="btn btn-primary btn-block">Update Plugin</button>
</form>
<?php } } ?>

</div>
</div>


</div><!-- #container -->
</body>
</html>