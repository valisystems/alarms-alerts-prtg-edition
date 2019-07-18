<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

if (!file_exists('../../config.php')) die('[install.php] config.php not found');
require_once '../../config.php';

// Check if the file is accessed only from a admin if not stop the script from running
if (!JAK_USERID) die('You cannot access this file directly.');

if (!$jakuser->jakAdminaccess($jakuser->getVar("usergroupid"))) die('You cannot access this file directly.');

// Set successfully to zero
$succesfully = 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Uninstallation - Register Form</title>
	<meta charset="utf-8">
	<meta name="author" content="JAKCMS (http://www.jakcms.com)" />
	<link rel="stylesheet" href="../../css/stylesheet.css" type="text/css" media="screen" />
</head>
<body>

<div class="container">
<div class="row">
<div class="col-md-12">
<h3>Uninstallation - Register Form</h3>

<!-- Let's do the uninstall -->
<?php if (isset($_POST['uninstall'])) {

// now get the plugin id for futher use
$results = $jakdb->query('SELECT id FROM '.DB_PREFIX.'plugins WHERE name = "register_form"');
$rows = $results->fetch_assoc();

if ($rows) {
 
$jakdb->query('DELETE FROM '.DB_PREFIX.'plugins WHERE name = "register_form"');

$resultsp = $jakdb->query('SELECT id FROM '.DB_PREFIX.'pluginhooks WHERE product = "registerf"');
	while ($rowsp = $resultsp->fetch_assoc()) {

		$jakdb->query('DELETE FROM '.DB_PREFIX.'pagesgrid WHERE hookid = '.$rowsp['id']);
	}

$jakdb->query('DELETE FROM '.DB_PREFIX.'pluginhooks WHERE product = "registerf"');

$jakdb->query('DELETE FROM '.DB_PREFIX.'setting WHERE product = "registerf"');

$jakdb->query('DELETE FROM '.DB_PREFIX.'pagesgrid WHERE pluginid = '.$rows['id']);
$jakdb->query('DELETE FROM '.DB_PREFIX.'pagesgrid WHERE plugin = '.$rows['id']);

$jakdb->query('DELETE FROM '.DB_PREFIX.'categories WHERE pluginid = '.$rows['id']);

// Clean up database
$jakdb->query('ALTER TABLE '.DB_PREFIX.'pages DROP showregister');
$jakdb->query('ALTER TABLE '.DB_PREFIX.'news DROP showregister');
$jakdb->query('UPDATE '.DB_PREFIX.'pluginhooks SET active = 1 WHERE id = 3');
$jakdb->query('DROP TABLE '.DB_PREFIX.'registeroptions');

$succesfully = 1;

}

?>
<div class="alert alert-success">Plugin uninstalled successfully</div>
<?php } ?>

<?php if (!$succesfully) { ?>
<form name="company" method="post" action="uninstall.php" enctype="multipart/form-data">
<div class="form-actions">
<button type="submit" name="uninstall" class="btn btn-primary btn-block">UnInstall Plugin</button>
</div>
</form>
<?php } ?>


</div>
</div>


</div>
</body>
</html>