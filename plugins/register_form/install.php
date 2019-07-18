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
	<title>Installation - Register Form</title>
	<meta charset="utf-8">
	<meta name="author" content="CLARICOM (http://www.claricom.ca)" />
	<link rel="stylesheet" href="../../css/stylesheet.css" type="text/css" media="screen" />
</head>
<body>

<div class="container">
<div class="row">
<div class="col-md-12">
<h3>Installation - Register Form</h3>

<!-- Check if the plugin is already installed -->
<?php $jakdb->query('SELECT id FROM '.DB_PREFIX.'plugins WHERE name = "register_form"');
if ($jakdb->affected_rows > 0) { ?>

<div class="alert alert-success fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <h4>Plugin is already installed!!!</h4>
</div>

<!-- Plugin is not installed let's display the installation script -->
<?php } else { ?>

<!-- The installation button is hit -->
<?php if (isset($_POST['install'])) {
 
$jakdb->query('INSERT INTO '.DB_PREFIX.'plugins (`id`, `name`, `description`, `active`, `access`, `pluginorder`, `pluginpath`, `phpcode`, `phpcodeadmin`, `sidenavhtml`, `managenavhtml`, `usergroup`, `uninstallfile`, `pluginversion`, `time`) VALUES (NULL, "register_form", "Create a register form and connect it to any page you like", 1, '.JAK_USERID.', 4, "register_form", "require_once APP_PATH.\'plugins/register_form/register.php\';", "if ($page == \'register-form\') {
        require_once APP_PATH.\'plugins/register_form/admin/register.php\';
        $JAK_PROVED = 1;
        $checkp = 1;
     }", "", "../plugins/register_form/admin/template/registerfnav.php", 1, "uninstall.php", "1.0", NOW())');

// now get the plugin id for futher use
$results = $jakdb->query('SELECT id FROM '.DB_PREFIX.'plugins WHERE name = "register_form"');
$rows = $results->fetch_assoc();

if ($rows['id']) {

$adminlang = 'if (file_exists(APP_PATH.\'plugins/register_form/admin/lang/\'.$site_language.\'.ini\')) {
    $lrf = parse_ini_file(APP_PATH.\'plugins/register_form/admin/lang/\'.$site_language.\'.ini\', true);
} else {
    $lrf = parse_ini_file(APP_PATH.\'plugins/register_form/admin/lang/en.ini\', true);
}';

$pn_include = 'if ($row[\'showregister\'] == 1) {
	include_once APP_PATH.\'plugins/register_form/rf_createform.php\';
	$JAK_SHOW_R_FORM = jak_create_register_form($tl[\'cmsg\'][\'c12\'], \'\', true);
}';

$pages = 'if ($pg[\'pluginid\'] == JAK_PLUGIN_REGISTER_FORM) {

include_once APP_PATH.\'plugins/register_form/admin/template/rf_connect.php\';

}';

$sqlinsert = '$insert .= \'showregister = \"\'.smartsql($defaults[\'jak_rfconnect\']).\'\",\';';

$index_page = 'include_once APP_PATH.\'plugins/register_form/rf_post.php\';if ($page == \'rf_ual\') {
if (is_numeric($page1) && is_numeric($page2) && jak_row_exist($page1, DB_PREFIX.\'user\') && jak_field_not_exist($page2, DB_PREFIX.\'user\', \'activatenr\')) {

		// Generate new idhash
		$nidhash = JAK_userlogin::generateRandID();
		
		$result = $jakdb->query(\'UPDATE \'.DB_PREFIX.\'user SET session = \"\'.smartsql(session_id()).\'\", idhash = \"\'.smartsql($nidhash).\'\", lastactivity = NOW(), access = access - 1, activatenr = 0 WHERE id = \"\'.smartsql($page1).\'\" AND activatenr = \"\'.smartsql($page2).\'\"\');
		
		$_SESSION[\'username\'] = $page3;
		$_SESSION[\'idhash\'] = $nidhash;
	
if (!$result) {
	jak_redirect(JAK_PARSE_ERROR);
} else {

	// Get the agreement page details!
	foreach ($jakcategories as $sap) {
			
			if ($jkv[\"rf_redirect\"] == $sap[\'id\']) {
				$register_redirect = JAK_rewrite::jakParseurl($sap[\'pagename\'], \'\', \'\', \'\', \'\');
			}
		
	}
	
	if (isset($register_redirect)) {
		$register_redirect = $register_redirect;
	} else {
		$register_redirect = BASE_URL;
	}

	$userlink = BASE_URL.\'admin/index.php?p=user&sp=edit&ssp=\'.$page1;

	$admail = new PHPMailer();
	$adlinkmessage = $tl[\'login\'][\'l16\'].$userlink;
	$adbody = str_ireplace(\"[\]\", \'\',$adlinkmessage);
	$admail->SetFrom($jkv[\"email\"], $jkv[\"title\"]);
	$admail->AddAddress($jkv[\"email\"], $jkv[\"title\"]);
	$admail->Subject = $jkv[\"title\"].\' - \'.$tl[\'login\'][\'l11\'];
	$admail->MsgHTML($adbody);
	$admail->Send(); // Send email without any warnings
	
	jak_redirect($register_redirect);
}
	
} else {
	$_SESSION[\"infomsg\"] = $tl[\"login\"][\"l14\"];
	jak_redirect(BASE_URL);
}
}';

// Insert code into index.php
$insertadminindex = 'plugins/register_form/admin/template/stat.php';

$jakdb->query('INSERT INTO '.DB_PREFIX.'pluginhooks (`id`, `hook_name`, `name`, `phpcode`, `product`, `active`, `exorder`, `pluginid`, `time`) VALUES (NULL, "tpl_admin_page_news", "Register Form Admin - Page/News", "'.$pages.'", "registerf", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "tpl_admin_page_news_new", "Register Form Admin - Page/News - New", "plugins/register_form/admin/template/rf_connect_new.php", "registerf", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "tpl_sidebar", "Profile/Login Form Sidebar", "plugins/register_form/template/rf_sidebar.php", "registerf", 1, 5, "'.$rows['id'].'", NOW()), (NULL, "tpl_footer_widgets", "Profile/Login Form Footer Widget", "plugins/register_form/template/footer_widget.php", "registerf", 1, 2, "'.$rows['id'].'", NOW()), (NULL, "php_admin_pages_sql", "Profile/Login Form SQL", "'.$sqlinsert.'", "registerf", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_admin_news_sql", "Profile/Login Form SQL", "'.$sqlinsert.'", "registerf", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_admin_lang", "Register Form Admin Language", "'.$adminlang.'", "registerf", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_pages_news", "Register Form Pages/News", "'.$pn_include.'", "registerf", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "tpl_page_news_grid", "Register Form TPL - Pages/News", "include_once APP_PATH.\'plugins/register_form/template/rf_registerform.php\';", "registerf", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_index_page", "Register User Validate", "'.$index_page.'", "registerf", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "tpl_admin_index", "Register Statistics Admin", "'.$insertadminindex.'", "registerf", 1, 1, "'.$rows['id'].'", NOW())');

// Insert tables into settings
$jakdb->query('INSERT INTO '.DB_PREFIX.'setting (`varname`, `groupname`, `value`, `defaultvalue`, `optioncode`, `datatype`, `product`) VALUES ("rf_title", "register_form", NULL, NULL, "input", "free", "registerf"), ("rf_active", "register_form", 1, 1, "yesno", "boolean", "registerf"), ("rf_simple", "register_form", 1, 1, "yesno", "boolean", "registerf"), ("rf_message", "register_form", NULL, NULL, "textarea", "free", "registerf"), ("rf_confirm", "register_form", 1, 1, "select", "boolean", "registerf"), ("rf_welcome", "register_form", NULL, NULL, "textarea", "free", "registerf"), ("rf_usergroup", "register_form", 2, 2, "select", "number", "registerf"), ("rf_redirect", "register_form", NULL, NULL, "number", "select", "registerf")');

// Write into categories
$jakdb->query('INSERT INTO '.DB_PREFIX.'categories (`id`, `name`, `varname`, `catimg`, `showmenu`, `showfooter`, `catorder`, `catparent`, `pageid`, `permission`, `activeplugin`, `pluginid`) VALUES (NULL, "Edit Profile", "edit-profile", NULL, 1, 0, 5, 0, 0, "2,3,4", 1, "'.$rows['id'].'")');

// Prepare the tables
$jakdb->query('ALTER TABLE '.DB_PREFIX.'pages ADD showregister SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER showcontact');
$jakdb->query('ALTER TABLE '.DB_PREFIX.'news ADD showregister SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER showcontact');
$jakdb->query('UPDATE '.DB_PREFIX.'pluginhooks SET active = 0 WHERE id = 3');

$jakdb->query('CREATE TABLE '.DB_PREFIX.'registeroptions (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `typeid` smallint(2) unsigned NOT NULL DEFAULT 1,
  `options` text,
  `showregister` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `mandatory` tinyint(1) unsigned NOT NULL DEFAULT 1,
  `forder` int(11) unsigned NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');

$jakdb->query('INSERT INTO '.DB_PREFIX.'registeroptions (`id`, `name`, `typeid`, `options`, `showregister`, `mandatory`, `forder`) VALUES (NULL, \'Username\', 1, NULL, 1, 1, 1), (NULL, \'Email\', 1, NULL, 1, 3, 2), (NULL, \'Password\', 1, NULL, 1, 1, 3)');

$succesfully = 1;

?>
<div class="alert alert-success">Plugin installed successfully</div>
<?php } else { 

$result = $jakdb->query('DELETE FROM '.DB_PREFIX.'plugins WHERE name = "register_form"');

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


</div>

</body>
</html>