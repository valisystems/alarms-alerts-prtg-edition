<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 JAKWEB All Rights Reserved # ||
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
	<title>Uninstallation - OpenURL</title>
	<meta charset="utf-8">
	<meta name="author" content="JAKWEB (http://www.jakweb.ch)" />
	<link rel="stylesheet" href="../../css/stylesheet.css" type="text/css" media="screen" />
</head>
<body>

<div class="container">
<div class="row">
<div class="col-md-12">
<h3>Uninstallation - OpenURL</h3>

<!-- Let's do the uninstall -->
<?php if (isset($_POST['uninstall'])) {
 
$jakdb->query('DELETE FROM '.DB_PREFIX.'plugins WHERE name = "openurl_blank"');

$jakdb->query('DELETE FROM '.DB_PREFIX.'pluginhooks WHERE product = "openurlb"');

$succesfully = 1;

?>
<div class="alert alert-success fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <h4>Plugin uninstalled successfully.</h4>
</div>

<?php }  if (!$succesfully) { ?>
<form name="company" method="post" action="uninstall.php">
<button type="submit" name="uninstall" class="btn btn-danger btn-block">UnInstall Plugin</button>
</form>
<?php } ?>

</div>
</div>

</div><!-- #container -->
</body>
</html>