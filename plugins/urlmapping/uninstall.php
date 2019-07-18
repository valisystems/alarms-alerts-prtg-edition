<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// We do need the config file
if (!file_exists('../../config.php')) die('[install.php] config.php not found');
require_once '../../config.php';

// Check if the file is accessed only from a admin if not stop the script from running
if (!JAK_USERID) die('You cannot access this file directly.');

// not an admin, see ya!
if(!$jakuser->jakAdminaccess($jakuser->getVar("usergroupid"))) die('You cannot access this file directly.');


// Set successfully to zero
$succesfully = 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Uninstallation - UrlMapping Plugin</title>
	<meta charset="utf-8">
	<meta name="author" content="JAKWEB (http://www.jakweb.ch)" />
	<link rel="stylesheet" href="../../css/stylesheet.css" type="text/css" media="screen" />
</head>
<body>

<div class="container">
<div class="row">
<div class="col-md-12">
<h3>Installation - UrlMapping Plugin</h3>

<!-- Let's do the uninstall -->
<?php if (isset($_POST['uninstall'])) {

// now get the plugin id for futher use
$rows = $jakdb->queryRow('SELECT id FROM '.DB_PREFIX.'plugins WHERE name = "UrlMapping"');

if ($rows) {
 
	$jakdb->query('DELETE FROM '.DB_PREFIX.'plugins WHERE name = "UrlMapping"');
	$jakdb->query('DELETE FROM '.DB_PREFIX.'pluginhooks WHERE product = "urlmapping"');
	$jakdb->query('DROP TABLE '.DB_PREFIX.'urlmapping');

}

$succesfully = 1;

?>
<div class="alert alert-success">Plugin uninstalled successfully</div>
<?php } ?>

<?php if (!$succesfully) { ?>
<form name="company" method="post" action="uninstall.php" enctype="multipart/form-data">
<button type="submit" name="uninstall" class="btn btn-danger btn-block">Uninstall Plugin</button>
</form>
<?php } ?>

</div>
</div>


</div><!-- #container -->
</body>
</html>