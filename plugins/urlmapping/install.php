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
if (!$jakuser->jakAdminaccess($jakuser->getVar("usergroupid"))) die('You cannot access this file directly.');

// Set successfully to zero
$succesfully = 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Installation - URL Mapping Plugin</title>
	<meta charset="utf-8">
	<meta name="author" content="CMS (http://www.jakweb.ch)" />
	<link rel="stylesheet" href="../../css/stylesheet.css" type="text/css" media="screen" />
</head>
<body>

<div class="container">
<div class="row">
<div class="col-md-12">
<h3>Installation - URL Mapping Plugin</h3>

<?php if (isset($_POST['install'])) {
 
$jakdb->query('INSERT INTO '.DB_PREFIX.'plugins (`id`, `name`, `description`, `active`, `access`, `pluginorder`, `pluginpath`, `phpcode`, `phpcodeadmin`, `managenavhtml`, `usergroup`, `uninstallfile`, `pluginversion`, `time`) VALUES (NULL, "UrlMapping", "URL Mapping the smart way.", 1, '.JAK_USERID.', 4, "urlmapping", "", "if ($page == \'urlmapping\') {
        require_once APP_PATH.\'plugins/urlmapping/admin/urlmapping.php\';
        $JAK_PROVED = 1;
        $checkp = 1;
     }", "../plugins/urlmapping/admin/template/nav.php", "1", "uninstall.php", "1.0", NOW())');

// now get the plugin id for futher use
$rows = $jakdb->queryRow('SELECT id FROM '.DB_PREFIX.'plugins WHERE name = "UrlMapping"');

if ($rows['id']) {	

$adminlang = 'if (file_exists(APP_PATH.\'plugins/urlmapping/admin/lang/\'.$site_language.\'.ini\')) {
    $tlum = parse_ini_file(APP_PATH.\'plugins/urlmapping/admin/lang/\'.$site_language.\'.ini\', true);
} else {
    $tlum = parse_ini_file(APP_PATH.\'plugins/urlmapping/admin/lang/en.ini\', true);
}';

// The file who does the job
$index_top = 'include_once APP_PATH.\'plugins/urlmapping/mapping.php\';';

$jakdb->query('INSERT INTO '.DB_PREFIX.'pluginhooks (`id`, `hook_name`, `name`, `phpcode`, `product`, `active`, `exorder`, `pluginid`, `time`) VALUES (NULL, "php_admin_lang", "BelowHeader Admin Language", "'.$adminlang.'", "urlmapping", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "php_index_top", "URL Mappling Index", "'.$index_top.'", "urlmapping", 1, 1, "'.$rows['id'].'", NOW())');

$jakdb->query('CREATE TABLE IF NOT EXISTS '.DB_PREFIX.'urlmapping (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `urlold` varchar(255) DEFAULT NULL,
  `urlnew` varchar(255) DEFAULT NULL,
  `redirect` smallint(3) unsigned NOT NULL DEFAULT 0,
  `active` smallint(1) unsigned NOT NULL DEFAULT 1,
  `time` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',
  PRIMARY KEY (`id`),
  KEY `urlold` (`urlold`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1');

$succesfully = 1;

?>
<div class="alert alert-success">Plugin installed successfully</div>
<?php } else { 

$result = $jakdb->query('DELETE FROM '.DB_PREFIX.'plugins WHERE name = "UrlMapping"');

?>
<div class="alert alert-success">Plugin install failed, could not determine the plugin id.</div>
<form name="company" method="post" action="uninstall.php" enctype="multipart/form-data">
<button type="submit" name="redirect" class="btn btn-danger pull-right">Uninstall Plugin</button>
</form>
<?php } } ?>

<?php if (!$succesfully) { ?>
<form name="company" method="post" action="install.php" enctype="multipart/form-data">
<button type="submit" name="install" class="btn btn-primary btn-block">Install Plugin</button>
</form>
<?php } ?>

</div>
</div>


</div><!-- #container -->
</body>
</html>