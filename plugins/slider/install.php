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
	<title>Installation - Slider Plugin</title>
	<meta charset="utf-8">
	<meta name="author" content="CLARICOM (http://www.claricom.ca)" />
	<link rel="stylesheet" href="../../css/stylesheet.css" type="text/css" media="screen" />
</head>
<body>

<div class="container">
<div class="row">
<div class="col-md-12">
<h3>Installation - Slider Plugin</h3>

<?php if (isset($_POST['install'])) {
 
$jakdb->query('INSERT INTO '.DB_PREFIX.'plugins (`id`, `name`, `description`, `active`, `access`, `pluginorder`, `pluginpath`, `phpcode`, `phpcodeadmin`, `managenavhtml`, `usergroup`, `uninstallfile`, `pluginversion`, `time`) VALUES (NULL, "Slider", "Run your own Layer Slider.", 1, 1, 4, "slider", "", "if ($page == \'slider\') {
        require_once APP_PATH.\'plugins/slider/admin/slider.php\';
        $JAK_PROVED = 1;
        $checkp = 1;
     }", "../plugins/slider/admin/template/lsnav.php", "1", "uninstall.php", "1.0", NOW())');

// now get the plugin id for futher use
$sqls = 'SELECT id FROM '.DB_PREFIX.'plugins WHERE name = "Slider"';
$results = $jakdb->query($sqls);
$rows = $results->fetch_assoc();

if ($rows['id']) {	

$adminlang = 'if (file_exists(APP_PATH.\'plugins/slider/admin/lang/\'.$site_language.\'.ini\')) {
    $tlls = parse_ini_file(APP_PATH.\'plugins/slider/admin/lang/\'.$site_language.\'.ini\', true);
} else {
    $tlls = parse_ini_file(APP_PATH.\'plugins/slider/admin/lang/en.ini\', true);
}';

// Connect to pages/news
$pages = 'if ($pg[\'pluginid\'] == JAK_PLUGIN_SLIDER) {
include_once APP_PATH.\'plugins/slider/admin/template/ls_connect.php\';
}';

$sqlinsert = 'if (!isset($defaults[\'jak_showslider\'])) {
	$lsl = 0;
} else {
	$lsl = $defaults[\'jak_showslider\'];
}

$insert .= \'showslider = \"\'.smartsql($lsl).\'\",\';';

$getslider = '$JAK_GET_SLIDER = jak_get_page_info(DB_PREFIX.\'slider\', \'\');';

// Eval code for display connect
$get_fqconnect = 'if ($pg[\'pluginid\'] == $jakplugins->getIDfromName(\'Slider\') && $loadslider && $loadsliderontop) {
include_once APP_PATH.\'plugins/slider/template/pages_news.php\';
}';

$loadcss = 'if ($row[\'showslider\']) { 

$loadslider = false;

$resultls = $jakdb->query(\'SELECT id, lslogo, lslogolink, lsontop, lsresponsive, lsloops, lsfloops, lsavideo, lsyvprev, lsanimatef, lswidth, lsheight, lstheme, lspause, lstransition, lstransitionout, lsdirection, autostart, imgpreload, naviprevnext, navibutton, pausehover FROM \'.DB_PREFIX.\'slider WHERE id = \"\'.smartsql($row[\'showslider\']).\'\" AND active = 1 AND (permission = 0 OR permission = \"\'.smartsql(JAK_USERGROUPID).\'\")\');
$rowls = $resultls->fetch_assoc();

if ($rowls) {
	$loadslider = true;
} }';

$jakdb->query('INSERT INTO '.DB_PREFIX.'pluginhooks (`id`, `hook_name`, `name`, `phpcode`, `widgetcode`, `product`, `active`, `exorder`, `pluginid`, `time`) VALUES (NULL, "php_admin_lang", "Slider Admin Language", "'.$adminlang.'", "", "slider", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_admin_page_news", "Slider Admin - Page/News", "'.$pages.'", "", "slider", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "tpl_admin_page_news_new", "Slider Admin - Page/News - New", "plugins/slider/admin/template/ls_connect_new.php", "", "slider", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_admin_pages_sql", "Slider Pages SQL", "'.$sqlinsert.'", "", "slider", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_admin_news_sql", "Slider News SQL", "'.$sqlinsert.'", "", "slider", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_admin_pages_news_info", "Slider Pages/News Info", "'.$getslider.'", "", "slider", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "tpl_page_news_grid", "Slider Pages/News Display", "'.$get_fqconnect.'", "", "slider", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_pages_news", "Slider Pages/News CSS", "'.$loadcss.'", "", "slider", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "tpl_between_head", "Slider CSS", "plugins/slider/template/cssheader.php", "", "slider", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_footer_end", "Slider JavaScript", "plugins/slider/template/jsfooter.php", "", "slider", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_below_header", "Slider OnTop", "plugins/slider/template/ontop.php", "", "slider", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "tpl_sidebar", "Slider", "plugins/slider/template/sidebar.php", "plugins/slider/admin/template/sidebar.php", "slider", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "php_admin_widgets_sql", "Slider Widgets", "", "", "slider", 1, 1, "'.$rows['id'].'", NOW())');

// Pages/News alter Table
$jakdb->query('ALTER TABLE '.DB_PREFIX.'pages ADD showslider INT(11) UNSIGNED NOT NULL DEFAULT 0 AFTER showcontact');
$jakdb->query('ALTER TABLE '.DB_PREFIX.'news ADD showslider INT(11) UNSIGNED NOT NULL DEFAULT 0 AFTER showcontact');

$jakdb->query('CREATE TABLE IF NOT EXISTS '.DB_PREFIX.'slider (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `lswidth` varchar(10) DEFAULT NULL,
  `lsheight` varchar(10) DEFAULT NULL,
  `lslogo` varchar(255) DEFAULT NULL,
  `lslogolink` varchar(255) DEFAULT NULL,
  `lsontop` tinyint(1) NOT NULL DEFAULT 0,
  `lsresponsive` tinyint(1) NOT NULL DEFAULT 1,
  `lsloops` smallint(2) NOT NULL DEFAULT 0,
  `lsfloops` tinyint(1) NOT NULL DEFAULT 0,
  `lsavideo` tinyint(1) NOT NULL DEFAULT 0,
  `lsyvprev` varchar(255) DEFAULT \'maxresdefault.jpg\',
  `lsanimatef` tinyint(1) NOT NULL DEFAULT 0,
  `lstheme` varchar(25) DEFAULT NULL,
  `lspause` smallint(5) NOT NULL DEFAULT 0,
  `lstransition` varchar(25) DEFAULT NULL,
  `lstransitionout` varchar(25) DEFAULT NULL,
  `lsdirection` varchar(25) DEFAULT NULL,
  `autostart` tinyint(1) NOT NULL DEFAULT 1,
  `imgpreload` tinyint(1) NOT NULL DEFAULT 1,
  `naviprevnext` tinyint(1) NOT NULL DEFAULT 1,
  `navibutton` tinyint(1) NOT NULL DEFAULT 1,
  `pausehover` tinyint(1) NOT NULL DEFAULT 1,
  `permission` mediumtext,
  `active` smallint(1) unsigned NOT NULL DEFAULT 1,
  `time` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1');

$jakdb->query('CREATE TABLE IF NOT EXISTS '.DB_PREFIX.'slider_layers (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lsid` int(11) unsigned NOT NULL DEFAULT 0,
  `lsdeep` varchar(100) DEFAULT NULL,
  `lsstyle` varchar(100) DEFAULT NULL,
  `lsposition` varchar(255) DEFAULT NULL,
  `lsmove` varchar(255) DEFAULT NULL,
  `lslink` varchar(100) DEFAULT NULL,
  `lspath` mediumtext,
  `slide2d` varchar(255) DEFAULT NULL,
  `slide3d` varchar(255) DEFAULT NULL,
  `timeshift` varchar(6) DEFAULT NULL,
  `slidedirection` varchar(25) DEFAULT NULL,
  `imgdirection` varchar(25) DEFAULT NULL,
  `slidedelay` varchar(25) DEFAULT NULL,
  `durationin` varchar(25) DEFAULT NULL,
  `durationout` varchar(25) DEFAULT NULL,
  `easingin` varchar(25) DEFAULT NULL,
  `easingout` varchar(25) DEFAULT NULL,
  `delayin` varchar(25) DEFAULT NULL,
  `delayout` varchar(25) DEFAULT NULL,
  `parallaxin` varchar(25) DEFAULT NULL,
  `parallaxout` varchar(25) DEFAULT NULL,
  `layer` int(11) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `lsid` (`lsid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1');

$succesfully = 1;

?>
<div class="alert alert-success">Plugin installed successfully</div>
<?php } else { 

$result = $jakdb->query('DELETE FROM '.DB_PREFIX.'plugins WHERE name = "Slider"');

?>
<div class="alert alert-success">Plugin installation failed.</div>
<form name="company" method="post" action="uninstall.php" enctype="multipart/form-data">
<button type="submit" name="redirect" class="btn btn-danger btn-block">Uninstall Plugin</button>
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