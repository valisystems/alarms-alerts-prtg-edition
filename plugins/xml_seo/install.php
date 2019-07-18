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
	<title>Installation - Create a Sitemap for Search Engines</title>
	<meta charset="utf-8">
	<meta name="author" content="JAKWEB (http://www.jakweb.ch)" />
	<link rel="stylesheet" href="../../css/stylesheet.css" type="text/css" media="screen" />
</head>
<body>

<div class="container">
<div class="row">
<div class="col-md-12">
<h3>Installation - Create a Sitemap for Search Engines</h3>

<!-- Check if the plugin is already installed -->
<?php $jakdb->query('SELECT id FROM '.DB_PREFIX.'plugins WHERE name = "XML_SEO"');
if ($jakdb->affected_rows > 0) { ?>

<div class="alert alert-info">Plugin is already installed!!!</div>

<!-- Plugin is not installed let's display the installation script -->
<?php } else { ?>

<!-- The installation button is hit -->
<?php if (isset($_POST['install'])) {

$jakdb->query('INSERT INTO '.DB_PREFIX.'plugins (`id`, `name`, `description`, `active`, `access`, `pluginorder`, `pluginpath`, `phpcode`, `phpcodeadmin`, `managenavhtml`, `usergroup`, `uninstallfile`, `pluginversion`, `time`) VALUES (NULL, "XML_SEO", "XML Sitemap for better SEO.", 1, '.JAK_USERID.', 4, "xml_seo", "NULL", "if ($page == \'xml_seo\') {
        require_once APP_PATH.\'plugins/xml_seo/admin/xml_seo.php\';
           $JAK_PROVED = 1;
           $checkp = 1;
        }", "../plugins/xml_seo/admin/template/xml_seonav.php", "NULL", "uninstall.php", "1.0", NOW())');

// now get the plugin id for futher use
$results = $jakdb->query('SELECT id FROM '.DB_PREFIX.'plugins WHERE name = "XML_SEO"');
$rows = $results->fetch_assoc();

if ($rows['id']) {

$succesfully = 1;

?>
<div class="alert alert-success">Plugin installed successfully</div>
<?php } else { 

$result = $jakdb->query('DELETE FROM '.DB_PREFIX.'plugins WHERE name = "xml_seo"');

?>
<div class="alert alert-danger">Plugin installation failed.</div>
<?php } } ?>

<?php if (!$succesfully) { ?>
<form name="company" method="post" action="install.php" enctype="multipart/form-data">
<button type="submit" name="install" class="btn btn-primary btn-block">Install Plugin</button>
</form>
<?php } } ?>

</div>
</div>


</div><!-- #container -->
</body>
</html>