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

if(!$jakuser->jakAdminaccess($jakuser->getVar("usergroupid"))) die('You cannot access this file directly.');

// Set successfully to zero
$succesfully = 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Installation - OpenURL</title>
	<meta charset="utf-8">
	<meta name="author" content="JAKWEB (http://www.jakweb.ch)" />
	<link rel="stylesheet" href="../../css/stylesheet.css" type="text/css" media="screen" />
</head>
<body>

<div class="container">
<div class="row">
<div class="col-md-12">
<h3>Installation - OpenURL</h3>

<!-- Check if the plugin is already installed -->
<?php $jakdb->query('SELECT id FROM '.DB_PREFIX.'plugins WHERE name = "openurl_blank"');
if ($jakdb->affected_rows > 0) { ?>

<div class="alert alert-success fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <h4>Plugin is already installed!!!</h4>
</div>

<!-- Plugin is not installed let's display the installation script -->
<?php } else { ?>

<!-- The installation button is hit -->
<?php if (isset($_POST['install'])) {
 
$jakdb->query('INSERT INTO '.DB_PREFIX.'plugins (`id`, `name`, `description`, `active`, `access`, `pluginorder`, `pluginpath`, `phpcode`, `phpcodeadmin`, `sidenavhtml`, `usergroup`, `uninstallfile`, `pluginversion`, `time`) VALUES (NULL, "openurl_blank", "Open all external links in a new window/tab.", 1, '.JAK_USERID.', 1, "openurl_blank", NULL, NULL, NULL, NULL, "uninstall.php", "1.0", NOW())');

// now get the plugin id for futher use
$results = $jakdb->query('SELECT id FROM '.DB_PREFIX.'plugins WHERE name = "openurl_blank"');
$rows = $results->fetch_assoc();

if ($rows['id']) {

$jakdb->query('INSERT INTO '.DB_PREFIX.'pluginhooks (`id`, `hook_name`, `name`, `phpcode`, `product`, `active`, `exorder`, `pluginid`, `time`) VALUES (NULL, "tpl_between_head", "Open URL jQuery", "plugins/openurl_blank/openurlhead.php", "openurlb", 1, 1, "'.$rows['id'].'", NOW())');

$succesfully = 1;

?>
<div class="alert alert-success fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <h4>Plugin installed successfully.</h4>
</div>
<?php } else { 

$result = $jakdb->query('DELETE FROM '.DB_PREFIX.'plugins WHERE name = "openurl_blank"');

?>

<div class="alert alert-danger fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <h4>Plugin installation failed.</h4>
</div>

<?php } } if (!$succesfully) { ?>
<form name="company" method="post" action="install.php">
<button type="submit" name="install" class="btn btn-success btn-block">Install Plugin</button>
</form>
<?php } } ?>

</div>
</div>

</div>

</body>
</html>