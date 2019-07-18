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
	<title>Installation - Newsletter Plugin</title>
	<meta charset="utf-8">
	<meta name="author" content="JAKWEB (http://www.jakweb.ch)" />
	<link rel="stylesheet" href="../../css/stylesheet.css" type="text/css" media="screen" />
</head>
<body>

<div class="container">
<div class="row">
<div class="col-md-12">
<h3>Installation - Newsletter Plugin</h3>

<?php if (isset($_POST['install'])) {
 
$jakdb->query('INSERT INTO '.DB_PREFIX.'plugins (`id`, `name`, `description`, `active`, `access`, `pluginorder`, `pluginpath`, `phpcode`, `phpcodeadmin`, `sidenavhtml`, `usergroup`, `uninstallfile`, `pluginversion`, `time`) VALUES (NULL, "Newsletter", "Run your own newsletter database, let user newsletter direct from your server or link.", 1, '.JAK_USERID.', 4, "newsletter", "require_once APP_PATH.\'plugins/newsletter/newsletter.php\';", "if ($page == \'newsletter\') {
        require_once APP_PATH.\'plugins/newsletter/admin/newsletter.php\';
           $JAK_PROVED = 1;
           $checkp = 1;
        }", "../plugins/newsletter/admin/template/newsletternav.php", "newsletter", "uninstall.php", "1.0", NOW())');

// now get the plugin id for futher use
$results = $jakdb->query('SELECT id FROM '.DB_PREFIX.'plugins WHERE name = "Newsletter"');
$rows = $results->fetch_assoc();

if ($rows['id']) {

// Insert php code
$insertphpcode = 'if (isset($defaults[\'jak_newsletter\'])) {
	$insert .= \'newsletter = \"\'.$defaults[\'jak_newsletter\'].\'\",\'; }';
	

$adminlang = 'if (file_exists(APP_PATH.\'plugins/newsletter/admin/lang/\'.$site_language.\'.ini\')) {
    $tlnl = parse_ini_file(APP_PATH.\'plugins/newsletter/admin/lang/\'.$site_language.\'.ini\', true);
} else {
    $tlnl = parse_ini_file(APP_PATH.\'plugins/newsletter/admin/lang/en.ini\', true);
}';

$sitelang = 'if (file_exists(APP_PATH.\'plugins/newsletter/lang/\'.$site_language.\'.ini\')) {
    $tlnl = parse_ini_file(APP_PATH.\'plugins/newsletter/lang/\'.$site_language.\'.ini\', true);
} else {
    $tlnl = parse_ini_file(APP_PATH.\'plugins/newsletter/lang/en.ini\', true);
}';

$jakdb->query('INSERT INTO '.DB_PREFIX.'pluginhooks (`id`, `hook_name`, `name`, `phpcode`, `product`, `active`, `exorder`, `pluginid`, `time`) VALUES (NULL, "php_admin_usergroup", "Newsletter Usergroup", "'.$insertphpcode.'", "newsletter", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "php_admin_lang", "Newsletter Admin Language", "'.$adminlang.'", "newsletter", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "php_lang", "Newsletter Site Language", "'.$sitelang.'", "newsletter", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_admin_usergroup", "Newsletter Usergroup New", "plugins/newsletter/admin/template/usergroup_new.php", "newsletter", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_admin_usergroup_edit", "Newsletter Usergroup Edit", "plugins/newsletter/admin/template/usergroup_edit.php", "newsletter", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_sidebar", "Newsletter SignUp", "plugins/newsletter/template/newslettersidebar.php", "newsletter", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_footer_widgets", "Footer - Newsletter Form", "plugins/newsletter/template/footer_widget.php", "newsletter", 1, 3, "'.$rows['id'].'", NOW())');

// Insert tables into settings
$jakdb->query('INSERT INTO '.DB_PREFIX.'setting (`varname`, `groupname`, `value`, `defaultvalue`, `optioncode`, `datatype`, `product`) VALUES ("nlsmtp_mail", "newsletter", 0, 0, "yesno", "boolean", "newsletter"), ("nlsmtpport", "newsletter", 25, 25, "input", "number", "newsletter"), ("nlsmtphost", "newsletter", "", "", "input", "free", "newsletter"), ("nlsmtp_auth", "newsletter", 0, 0, "yesno", "boolean", "newsletter"), ("nlsmtp_prefix", "newsletter", "", "", "input", "free", "newsletter"), ("nlsmtp_alive", "newsletter", 0, 0, "yesno", "boolean", "newsletter"), ("nlemail", "newsletter", "", "", "input", "free", "newsletter"), ("nlsmtpusername", "newsletter", "", "", "input", "free", "newsletter"), ("nlsmtppassword", "newsletter", "", "", "input", "free", "newsletter"), ("nlthankyou", "newsletter", "Thank you for your interest in our service.", "thank you", "input", "free", "newsletter"), ("nlsignoff", "newsletter", "Your email address will be removed from our Newsletter after successful entering your email address.", "removed", "input", "free", "newsletter"), ("nltitle", "newsletter", "Newsletter", "title", "input", "free", "newsletter")');

// Insert into usergroup
$jakdb->query('ALTER TABLE '.DB_PREFIX.'usergroup ADD `newsletter` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `advsearch`');

// Member Newsletter
$jakdb->query('ALTER TABLE '.DB_PREFIX.'user ADD `newsletter` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 1 AFTER `lastactivity`');

// Insert Category
$jakdb->query('INSERT INTO '.DB_PREFIX.'categories (`id`, `name`, `varname`, `catimg`, `showmenu`, `showfooter`, `catorder`, `catparent`, `pageid`, `activeplugin`, `pluginid`) VALUES (NULL, "Newsletter", "newsletter", NULL, 0, 0, 8, 0, 0, 1, "'.$rows['id'].'")');

$jakdb->query('CREATE TABLE IF NOT EXISTS '.DB_PREFIX.'newsletter (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `content` text,
  `showdate` smallint(1) unsigned NOT NULL DEFAULT 0,
  `sent` smallint(1) NOT NULL DEFAULT 0,
  `senttime` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',
  `time` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',
  `fullview` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');

$jakdb->query('CREATE TABLE IF NOT EXISTS '.DB_PREFIX.'newslettergroup (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` mediumtext,
  `time` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2');

$jakdb->query('INSERT INTO '.DB_PREFIX.'newslettergroup VALUES(1, "Standard", "Standard Usergroup for Newsletter", NOW())');

$jakdb->query('CREATE TABLE IF NOT EXISTS '.DB_PREFIX.'newsletteruser (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usergroupid` int(11) unsigned NOT NULL DEFAULT 1,
  `email` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `time` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',
  `delcode` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `groupid` (`usergroupid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');

$jakdb->query('CREATE TABLE IF NOT EXISTS '.DB_PREFIX.'newsletterstat (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nlid` int(11) unsigned NOT NULL DEFAULT 0,
  `senttotal` int(10) unsigned NOT NULL,
  `notsent` varchar(512) DEFAULT NULL,
  `notsentcms` varchar(512) DEFAULT NULL,
  `notsenttotal` int(10) unsigned NOT NULL,
  `nlgroup` varchar(255) DEFAULT NULL,
  `cmsgroup` varchar(255) DEFAULT NULL,
  `time` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');

$succesfully = 1;

?>
<div class="alert alert-success">Plugin installed successfully</div>
<?php } else { 

$result = $jakdb->query('DELETE FROM '.DB_PREFIX.'plugins WHERE name = "Newsletter"');

?>
<div class="alert alert-danger">Plugin installation failed.</div>
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