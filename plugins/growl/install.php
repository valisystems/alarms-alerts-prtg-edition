<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Get the config file
if (!file_exists('../../config.php')) die('[install.php] config.php not found');
require_once '../../config.php';

// Check if the file is accessed only from a admin if not stop the script from running
if (!JAK_USERID) die('You cannot access this file directly.');

// Not logged in and not admin, sorry...
if (!$jakuser->jakAdminaccess($jakuser->getVar("usergroupid"))) die('You cannot access this file directly.');

// Set successfully to zero
$succesfully = 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Installation - Growl</title>
	<meta charset="utf-8">
	<meta name="author" content="CLARICOM (http://www.claricom.ca)" />
	<link rel="stylesheet" href="../../css/stylesheet.css" type="text/css" media="screen" />
</head>
<body>

<div class="container">
<div class="row">
<div class="col-md-12">
<h3>Installation - Growl</h3>

<!-- Check if the plugin is already installed -->
<?php $jakdb->query('SELECT id FROM '.DB_PREFIX.'plugins WHERE name = "Growl"');
if ($jakdb->affected_rows > 0) { ?>

<div class="alert alert-info">Plugin is already installed!!!</div>

<!-- Plugin is not installed let's display the installation script -->
<?php } else { ?>

<!-- The installation button is hit -->
<?php if (isset($_POST['install'])) {
 
$jakdb->query('INSERT INTO '.DB_PREFIX.'plugins (`id`, `name`, `description`, `active`, `access`, `pluginorder`, `pluginpath`, `phpcode`, `phpcodeadmin`, `managenavhtml`, `usergroup`, `uninstallfile`, `pluginversion`, `time`) VALUES (NULL, "Growl", "Growl for your CMS.", 1, '.JAK_USERID.', 4, "growl", "", "if ($page == \'growl\') {
        require_once APP_PATH.\'plugins/growl/admin/growl.php\';
        $JAK_PROVED = 1;
        $checkp = 1;
     }", "../plugins/growl/admin/template/nav.php", "1", "uninstall.php", "1.0", NOW())');

// now get the plugin id for futher use
$results = $jakdb->query('SELECT id FROM '.DB_PREFIX.'plugins WHERE name = "Growl"');
$rows = $results->fetch_assoc();

if ($rows['id']) {

$adminlang = 'if (file_exists(APP_PATH.\'plugins/growl/admin/lang/\'.$site_language.\'.ini\')) {
    $tlgwl = parse_ini_file(APP_PATH.\'plugins/growl/admin/lang/\'.$site_language.\'.ini\', true);
} else {
    $tlgwl = parse_ini_file(APP_PATH.\'plugins/growl/admin/lang/en.ini\', true);
}';

// The file who does the job
$growlheader = 'plugins/growl/template/header.php';
$growlfooter = 'plugins/growl/template/footer.php';

$jakdb->query('INSERT INTO '.DB_PREFIX.'pluginhooks (`id`, `hook_name`, `name`, `phpcode`, `product`, `active`, `exorder`, `pluginid`, `time`) VALUES (NULL, "php_admin_lang", "Growl Admin Language", "'.$adminlang.'", "growl", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_between_head", "Growl CSS", "'.$growlheader.'", "growl", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "tpl_footer_end", "Growl Javascript", "'.$growlfooter.'", "growl", 1, 1, "'.$rows['id'].'", NOW())');

$jakdb->query('CREATE TABLE IF NOT EXISTS '.DB_PREFIX.'growl (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `everywhere` smallint(1) unsigned NOT NULL DEFAULT 0,
  `pageid` varchar(100) DEFAULT NULL,
  `newsid` varchar(100) DEFAULT NULL,
  `newsmain` smallint(1) unsigned NOT NULL DEFAULT 0,
  `tags` smallint(1) unsigned NOT NULL DEFAULT 0,
  `search` smallint(1) unsigned NOT NULL DEFAULT 0,
  `sitemap` smallint(1) unsigned NOT NULL DEFAULT 0,
  `title` varchar(255) DEFAULT NULL,
  `previmg` varchar(255) DEFAULT NULL,
  `content` mediumtext,
  `duration` smallint(5) unsigned NOT NULL DEFAULT 5000,
  `position` varchar(100) DEFAULT NULL,
  `color` smallint(1) unsigned NOT NULL DEFAULT 1,
  `sticky` smallint(1) unsigned NOT NULL DEFAULT 1,
  `remember` smallint(1) unsigned NOT NULL DEFAULT 1,
  `remembertime` smallint(2) unsigned NOT NULL DEFAULT 1,
  `permission` varchar(100) DEFAULT NULL,
  `startdate` INT(10) UNSIGNED NOT NULL DEFAULT 0,
  `enddate` INT(10) UNSIGNED NOT NULL DEFAULT 0,
  `active` smallint(1) unsigned NOT NULL DEFAULT 1,
  `time` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',
  PRIMARY KEY (`id`),
  KEY `pageid` (`pageid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1');

$succesfully = 1;

?>
<div class="alert alert-success">Plugin installed successfully</div>
<?php } else { 

$result = $jakdb->query('DELETE FROM '.DB_PREFIX.'plugins WHERE name = "Growl"');

?>
<div class="alert alert-danger">Plugin install failed, could not determine the plugin id.</div>
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