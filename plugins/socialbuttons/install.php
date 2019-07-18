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

if(!$jakuser->jakAdminaccess($jakuser->getVar("usergroupid"))) die('You cannot access this file directly.');

// Set successfully to zero
$succesfully = 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Installation - Social Buttons</title>
	<meta charset="utf-8">
	<meta name="author" content="CLARICOM CMS (http://www.claricom.ca)" />
	<link rel="stylesheet" href="../../css/stylesheet.css" type="text/css" media="screen" />
</head>
<body>

<div class="container">
<div class="row">
<div class="col-md-12">
<h3>Installation - Social Buttons</h3>

<!-- Check if the plugin is already installed -->
<?php $jakdb->query('SELECT id FROM '.DB_PREFIX.'plugins WHERE name = "socialbuttons"');
if ($jakdb->affected_rows > 0) { ?>

<div class="alert alert-info">Plugin is already installed!!!</div>

<!-- Plugin is not installed let's display the installation script -->
<?php } else { ?>

<!-- The installation button is hit -->
<?php if (isset($_POST['install'])) {
 
$jakdb->query('INSERT INTO '.DB_PREFIX.'plugins (`id`, `name`, `description`, `active`, `access`, `pluginorder`, `pluginpath`, `phpcode`, `phpcodeadmin`, `sidenavhtml`, `usergroup`, `uninstallfile`, `pluginversion`, `time`) VALUES (NULL, "SocialButtons", "Social Buttons connect with millions of people.", 1, '.JAK_USERID.', 4, "socialbuttons", NULL, NULL, NULL, 1, "uninstall.php", "1.0", NOW())');

// now get the plugin id for futher use
$results = $jakdb->query('SELECT id FROM '.DB_PREFIX.'plugins WHERE name = "socialbuttons"');
$rows = $results->fetch_assoc();

if ($rows['id']) {

$adminlang = 'if (file_exists(APP_PATH.\'plugins/socialbuttons/admin/lang/\'.$site_language.\'.ini\')) {
    $tlsb = parse_ini_file(APP_PATH.\'plugins/socialbuttons/admin/lang/\'.$site_language.\'.ini\', true);
} else {
    $tlsb = parse_ini_file(APP_PATH.\'plugins/socialbuttons/admin/lang/en.ini\', true);
}';

// Insert php code
$insertphpcode = '
$jakdb->query(\'UPDATE \'.DB_PREFIX.\'setting SET value = CASE varname
    WHEN \"sb_twitter\" THEN \"\'.smartsql($defaults[\'sb_twitter\']).\'\"
    WHEN \"sb_facebook\" THEN \"\'.smartsql($defaults[\'sb_facebook\']).\'\"
    WHEN \"sb_google\" THEN \"\'.smartsql($defaults[\'sb_google\']).\'\"
    WHEN \"sb_linkedin\" THEN \"\'.smartsql($defaults[\'sb_linkedin\']).\'\"
    WHEN \"sb_flicker\" THEN \"\'.smartsql($defaults[\'sb_flicker\']).\'\"
    WHEN \"sb_skype\" THEN \"\'.smartsql($defaults[\'sb_skype\']).\'\"
    WHEN \"sb_youtube\" THEN \"\'.smartsql($defaults[\'sb_youtube\']).\'\"
    WHEN \"sb_vimeo\" THEN \"\'.smartsql($defaults[\'sb_vimeo\']).\'\"
    WHEN \"sb_orkut\" THEN \"\'.smartsql($defaults[\'sb_orkut\']).\'\"
    WHEN \"sb_myspace\" THEN \"\'.smartsql($defaults[\'sb_myspace\']).\'\"
    WHEN \"sb_digg\" THEN \"\'.smartsql($defaults[\'sb_digg\']).\'\"
    WHEN \"sb_lastfm\" THEN \"\'.smartsql($defaults[\'sb_lastfm\']).\'\"
    WHEN \"sb_delicious\" THEN \"\'.smartsql($defaults[\'sb_delicious\']).\'\"
    WHEN \"sb_tumbler\" THEN \"\'.smartsql($defaults[\'sb_tumbler\']).\'\"
    WHEN \"sb_picasa\" THEN \"\'.smartsql($defaults[\'sb_picasa\']).\'\"
    WHEN \"sb_reddit\" THEN \"\'.smartsql($defaults[\'sb_reddit\']).\'\"
    WHEN \"sb_technorati\" THEN \"\'.smartsql($defaults[\'sb_technorati\']).\'\"
    WHEN \"sb_rss\" THEN \"\'.smartsql($defaults[\'sb_rss\']).\'\"
    WHEN \"sb_contact\" THEN \"\'.smartsql($defaults[\'sb_contact\']).\'\"
    WHEN \"sb_website\" THEN \"\'.smartsql($defaults[\'sb_website\']).\'\"
    WHEN \"sb_position\" THEN \"\'.smartsql($defaults[\'sb_position\']).\'\"
    WHEN \"sb_skin\" THEN \"\'.smartsql($defaults[\'sb_skin\']).\'\"
    WHEN \"sb_show\" THEN \"\'.smartsql($defaults[\'sb_show\']).\'\"
    WHEN \"sb_move\" THEN \"\'.smartsql($defaults[\'sb_move\']).\'\"
END
	WHERE varname IN (\"sb_twitter\", \"sb_facebook\", \"sb_google\", \"sb_linkedin\", \"sb_flicker\", \"sb_skype\", \"sb_youtube\", \"sb_vimeo\", \"sb_orkut\", \"sb_myspace\", \"sb_digg\", \"sb_lastfm\", \"sb_delicious\", \"sb_tumbler\", \"sb_picasa\", \"sb_reddit\", \"sb_technorati\", \"sb_rss\", \"sb_contact\", \"sb_website\", \"sb_position\", \"sb_skin\", \"sb_show\", \"sb_move\")\');';

$jakdb->query('INSERT INTO '.DB_PREFIX.'pluginhooks (`id`, `hook_name`, `name`, `phpcode`, `product`, `active`, `exorder`, `pluginid`, `time`) VALUES (NULL, "php_admin_setting_post", "SocialButton Settings", "'.$insertphpcode.'", "socialbuttons", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_admin_setting", "SocialButton Settings Template", "plugins/socialbuttons/admin/template/setting.php", "socialbuttons", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "php_admin_lang", "SocialButton Admin Language", "'.$adminlang.'", "socialbuttons", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_between_head", "SocialButton CSS", "plugins/socialbuttons/template/header.php", "socialbuttons", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_footer_end", "SocialButton JavaScript", "plugins/socialbuttons/template/footer.php", "socialbuttons", 1, 4, "'.$rows['id'].'", NOW())');

// Insert tables into settings
$jakdb->query('INSERT INTO '.DB_PREFIX.'setting (`varname`, `groupname`, `value`, `defaultvalue`, `optioncode`, `datatype`, `product`) VALUES ("sb_twitter", "setting", NULL, NULL, "input", "free", "socialbuttons"), ("sb_facebook", "setting", NULL, NULL, "input", "free", "socialbuttons"), ("sb_linkedin", "setting", NULL, NULL, "input", "free", "socialbuttons"), ("sb_flicker", "setting", NULL, NULL, "input", "free", "socialbuttons"), ("sb_skype", "setting", NULL, NULL, "input", "free", "socialbuttons"), ("sb_rss", "setting", NULL, NULL, "input", "free", "socialbuttons"), ("sb_google", "setting", NULL, NULL, "input", "free", "socialbuttons"), ("sb_contact", "setting", NULL, NULL, "input", "free", "socialbuttons"), ("sb_youtube", "setting", NULL, NULL, "input", "free", "socialbuttons"), ("sb_orkut", "setting", NULL, NULL, "input", "free", "socialbuttons"), ("sb_myspace", "setting", NULL, NULL, "input", "free", "socialbuttons"), ("sb_digg", "setting", NULL, NULL, "input", "free", "socialbuttons"), ("sb_lastfm", "setting", NULL, NULL, "input", "free", "socialbuttons"), ("sb_delicious", "setting", NULL, NULL, "input", "free", "socialbuttons"), ("sb_tumbler", "setting", NULL, NULL, "input", "free", "socialbuttons"), ("sb_picasa", "setting", NULL, NULL, "input", "free", "socialbuttons"), ("sb_vimeo", "setting", NULL, NULL, "input", "free", "socialbuttons"), ("sb_reddit", "setting", NULL, NULL, "input", "free", "socialbuttons"), ("sb_technorati", "setting", NULL, NULL, "input", "free", "socialbuttons"), ("sb_website", "setting", NULL, NULL, "input", "free", "socialbuttons"), ("sb_position", "setting", "left", "left", "input", "free", "socialbuttons"), ("sb_skin", "setting", "clear", "clear", "input", "free", "socialbuttons"), ("sb_show", "setting", 6, 6, "select", "number", "socialbuttons"), ("sb_move", "setting", 3, 3, "select", "number", "socialbuttons")');

$succesfully = 1;

?>
<div class="alert alert-success">Plugin installed successfully</div>
<?php } else { 

// something went wrong delete the plugin
$result = $jakdb->query('DELETE FROM '.DB_PREFIX.'plugins WHERE name = "socialbuttons"');

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