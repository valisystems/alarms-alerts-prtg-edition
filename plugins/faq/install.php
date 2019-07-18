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
	<title>Installation - FAQ Plugin</title>
	<meta charset="utf-8">
	<meta name="author" content="CLARICOM (http://www.claricom.ca)" />
	<link rel="stylesheet" href="../../css/stylesheet.css" type="text/css" media="screen" />
</head>
<body>

<div class="container">
<div class="row">
<div class="col-md-12">
<h3>Installation - FAQ Plugin</h3>

<?php if (isset($_POST['install'])) {
 
$jakdb->query('INSERT INTO '.DB_PREFIX.'plugins (`id`, `name`, `description`, `active`, `access`, `pluginorder`, `pluginpath`, `phpcode`, `phpcodeadmin`, `sidenavhtml`, `usergroup`, `uninstallfile`, `pluginversion`, `time`) VALUES (NULL, "FAQ", "Run your own faq database.", 1, '.JAK_USERID.', 4, "faq", "require_once APP_PATH.\'plugins/faq/faq.php\';", "if ($page == \'faq\') {
        require_once APP_PATH.\'plugins/faq/admin/faq.php\';
           $JAK_PROVED = 1;
           $checkp = 1;
        }", "../plugins/faq/admin/template/faqnav.php", "faq", "uninstall.php", "1.0", NOW())');

// now get the plugin id for futher use
$results = $jakdb->query('SELECT id FROM '.DB_PREFIX.'plugins WHERE name = "FAQ"');
$rows = $results->fetch_assoc();

if ($rows['id']) {

// Insert php code
$insertphpcode = 'if (isset($defaults[\'jak_faq\'])) {
	$insert .= \'faq = \"\'.$defaults[\'jak_faq\'].\'\", faqpost = \"\'.$defaults[\'jak_faqpost\'].\'\", faqpostapprove = \"\'.$defaults[\'jak_faqpostapprove\'].\'\", faqpostdelete = \"\'.$defaults[\'jak_faqpostdelete\'].\'\", faqrate = \"\'.$defaults[\'jak_faqrate\'].\'\", faqmoderate = \"\'.$defaults[\'jak_faqmoderate\'].\'\",\'; }';
	

$adminlang = 'if (file_exists(APP_PATH.\'plugins/faq/admin/lang/\'.$site_language.\'.ini\')) {
    $tlf = parse_ini_file(APP_PATH.\'plugins/faq/admin/lang/\'.$site_language.\'.ini\', true);
} else {
    $tlf = parse_ini_file(APP_PATH.\'plugins/faq/admin/lang/en.ini\', true);
}';

$sitelang = 'if (file_exists(APP_PATH.\'plugins/faq/lang/\'.$site_language.\'.ini\')) {
    $tlf = parse_ini_file(APP_PATH.\'plugins/faq/lang/\'.$site_language.\'.ini\', true);
} else {
    $tlf = parse_ini_file(APP_PATH.\'plugins/faq/lang/en.ini\', true);
}';

$sitephpsearch = '$faq = new JAK_search($SearchInput); 
        	$faq->jakSettable(\'faq\',\"\");
        	$faq->jakAndor(\"OR\");
        	$faq->jakFieldactive(\"active\");
        	$faq->jakFieldtitle(\"title\");
        	$faq->jakFieldcut(\"content\");
        	$faq->jakFieldstosearch(array(\'title\',\'content\'));
        	$faq->jakFieldstoselect(\"id, title, content\");
        	
        	// Load the array into template
        	$JAK_SEARCH_RESULT_FAQ = $faq->set_result(JAK_PLUGIN_VAR_FAQ, \'a\', $jkv[\"faqurl\"]);';
        	
$sitephprss = 'if ($page1 == JAK_PLUGIN_VAR_FAQ) {
	
	if ($jkv[\"faqrss\"]) {
		$sql = \'SELECT id, title, content, time FROM \'.DB_PREFIX.\'faq WHERE active = 1 ORDER BY time DESC LIMIT \'.$jkv[\"faqrss\"];
		$sURL = JAK_PLUGIN_VAR_FAQ;
		$sURL1 = \'a\';
		$what = 1;
		$seowhat = $jkv[\"faqurl\"];
		
		$JAK_RSS_DESCRIPTION = jak_cut_text($jkv[\"faqdesc\"], $jkv[\"shortmsg\"], \'…\');
		
	} else {
		jak_redirect(BASE_URL);
	}
	
}';

$sitephptag = 'if ($row[\'pluginid\'] == JAK_PLUGIN_ID_FAQ) {
$faqtagData[] = JAK_tags::jakTagsql(\"faq\", $row[\'itemid\'], \"id, title, content\", \"content\", JAK_PLUGIN_VAR_FAQ, \"a\", $jkv[\"faqurl\"]);
$JAK_TAG_FAQ_DATA = $faqtagData;
}';

$sitephpsitemap = 'include_once APP_PATH.\'plugins/faq/functions.php\';

$JAK_FAQ_ALL = jak_get_faq(\'\', $jkv[\"faqorder\"], \'\', \'\', $jkv[\"faqurl\"], $tl[\'general\'][\'g56\']);
$PAGE_TITLE = JAK_PLUGIN_NAME_FAQ;';

// Fulltext search query
$sqlfull = '$jakdb->query(\'ALTER TABLE \'.DB_PREFIX.\'faq ADD FULLTEXT(`title`, `content`)\');';
$sqlfullremove = '$jakdb->query(\'ALTER TABLE \'.DB_PREFIX.\'faq DROP INDEX `title`\');';

// Connect to pages/news
$pages = 'if ($pg[\'pluginid\'] == JAK_PLUGIN_FAQ) {

include_once APP_PATH.\'plugins/faq/admin/template/faq_connect.php\';

}';

$sqlinsert = 'if (!isset($defaults[\'jak_showfaq\'])) {
	$fq = 0;
} else if (in_array(0, $defaults[\'jak_showfaq\'])) {
	$fq = 0;
} else {
	$fq = join(\',\', $defaults[\'jak_showfaq\']);
}

if (empty($fq) && !empty($defaults[\'jak_showfaqmany\'])) {
	$insert .= \'showfaq = \"\'.$defaults[\'jak_showfaqorder\'].\':\'.$defaults[\'jak_showfaqmany\'].\'\",\';
} else if (!empty($fq)) {
	$insert .= \'showfaq = \"\'.$fq.\'\",\';
} else {
  	$insert .= \'showfaq = NULL,\';
}';

$getfaq = '$JAK_GET_FAQ = jak_get_page_info(DB_PREFIX.\'faq\', \'\');

if ($JAK_FORM_DATA) {

$showfaqarray = explode(\":\", $JAK_FORM_DATA[\'showfaq\']);

if (is_array($showfaqarray) && in_array(\"ASC\", $showfaqarray) || in_array(\"DESC\", $showfaqarray)) {

		$JAK_FORM_DATA[\'showfaqorder\'] = $showfaqarray[0];
		$JAK_FORM_DATA[\'showfaqmany\'] = $showfaqarray[1];
	
} }';

// Eval code for display connect
$get_fqconnect = 'if ($pg[\'pluginid\'] == JAK_PLUGIN_ID_FAQ && JAK_PLUGIN_ID_FAQ && !empty($row[\'showfaq\'])) {
include_once APP_PATH.\'plugins/faq/template/\'.$jkv[\"sitestyle\"].\'/page_news.php\';}';

$adminphpdelete = '$jakdb->query(\'UPDATE \'.DB_PREFIX.\'faqcomments SET userid = 0 WHERE userid = \'.$page2.\'\');';
					
$adminphprename = '$jakdb->query(\'UPDATE \'.DB_PREFIX.\'faqcomments SET username = \"\'.smartsql($defaults[\'jak_username\']).\'\" WHERE userid = \'.smartsql($page2).\'\');';
					
$adminphpmassdel = '$jakdb->query(\'UPDATE \'.DB_PREFIX.\'faqcomments SET userid = 0 WHERE userid = \'.$locked);';

$jakdb->query('INSERT INTO '.DB_PREFIX.'pluginhooks (`id`, `hook_name`, `name`, `phpcode`, `product`, `active`, `exorder`, `pluginid`, `time`) VALUES (NULL, "php_admin_usergroup", "Faq Usergroup", "'.$insertphpcode.'", "faq", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "php_admin_lang", "Faq Admin Language", "'.$adminlang.'", "faq", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "php_lang", "Faq Site Language", "'.$sitelang.'", "faq", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "php_search", "Faq Search PHP", "'.$sitephpsearch.'", "faq", 1, 8, "'.$rows['id'].'", NOW()), (NULL, "php_rss", "FAQ RSS PHP", "'.$sitephprss.'", "faq", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_tags", "Faq Tags PHP", "'.$sitephptag.'", "faq", 1, 8, "'.$rows['id'].'", NOW()), (NULL, "php_sitemap", "Faq Sitemap PHP", "'.$sitephpsitemap.'", "faq", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_between_head", "Faq CSS", "plugins/faq/template/cssheader.php", "faq", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_admin_usergroup", "Faq Usergroup New", "plugins/faq/admin/template/usergroup_new.php", "faq", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_admin_usergroup_edit", "Faq Usergroup Edit", "plugins/faq/admin/template/usergroup_edit.php", "faq", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_tags", "Faq Tags", "plugins/faq/template/tag.php", "faq", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_sitemap", "Faq Sitemap", "plugins/faq/template/sitemap.php", "faq", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_sidebar", "Faq Sidebar Categories", "plugins/faq/template/faqsidebar.php", "faq", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "php_admin_fulltext_add", "Faq Full Text Search", "'.$sqlfull.'", "faq", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_admin_fulltext_remove", "Faq Remove Full Text Search", "'.$sqlfullremove.'", "faq", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "tpl_admin_page_news", "Faq Admin - Page/News", "'.$pages.'", "faq", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "tpl_admin_page_news_new", "Faq Admin - Page/News - New", "plugins/faq/admin/template/faq_connect_new.php", "faq", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_admin_pages_sql", "Faq Pages SQL", "'.$sqlinsert.'", "faq", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_admin_news_sql", "Faq News SQL", "'.$sqlinsert.'", "faq", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_admin_pages_news_info", "Faq Pages/News Info", "'.$getfaq.'", "faq", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "tpl_page_news_grid", "Faq Pages/News Display", "'.$get_fqconnect.'", "faq", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "tpl_search", "Faq Search", "plugins/faq/template/search.php", "faq", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_admin_user_delete", "FAQ Delete User", "'.$adminphpdelete.'", "faq", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_admin_user_rename", "FAQ Rename User", "'.$adminphprename.'", "faq", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_admin_user_delete_mass", "FAQ Delete User Mass", "'.$adminphpmassdel.'", "faq", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "tpl_footer_widgets", "FAQ - 3 Latest Entries", "plugins/faq/template/footer_widget.php", "faq", 1, 3, "'.$rows['id'].'", NOW())');

// Insert tables into settings
$jakdb->query('INSERT INTO '.DB_PREFIX.'setting (`varname`, `groupname`, `value`, `defaultvalue`, `optioncode`, `datatype`, `product`) VALUES ("faqtitle", "faq", NULL, NULL, "input", "free", "faq"), ("faqdesc", "faq", NULL, NULL, "textarea", "free", "faq"), ("faqemail", "faq", NULL, NULL, "input", "free", "faq"), ("faqdateformat", "faq", "d.m.Y", "d.m.Y", "input", "free", "faq"), ("faqtimeformat", "faq", ": h:i A", ": h:i A", "input", "free", "faq"), ("faqurl", "faq", 0, 0, "yesno", "boolean", "faq"), ("faqmaxpost", "faq", 2000, 2000, "input", "boolean", "faq"), ("faqpagemid", "faq", 3, 3, "yesno", "number", "faq"), ("faqpageitem", "faq", 4, 4, "yesno", "number", "faq"), ("faqorder", "faq", "id ASC", "", "input", "free", "faq"), ("faqrss", "faq", 5, 5, "select", "number", "faq"), ("faqhlimit", "faq", 5, 5, "select", "number", "faq")');

// Insert into usergroup
$jakdb->query('ALTER TABLE '.DB_PREFIX.'usergroup ADD `faq` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `advsearch`, ADD `faqpost` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `faq`, ADD `faqpostdelete` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `faqpost`, ADD `faqpostapprove` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `faqpostdelete`, ADD `faqrate` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `faqpostdelete`, ADD `faqmoderate` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `faqrate`');

// Pages/News alter Table
$jakdb->query('ALTER TABLE '.DB_PREFIX.'pages ADD showfaq varchar(100) DEFAULT NULL AFTER showcontact');
$jakdb->query('ALTER TABLE '.DB_PREFIX.'news ADD showfaq varchar(100) DEFAULT NULL AFTER showcontact');
$jakdb->query('ALTER TABLE '.DB_PREFIX.'pagesgrid ADD faqid INT(11) UNSIGNED NOT NULL DEFAULT 0 AFTER newsid');

// Insert Category
$jakdb->query('INSERT INTO '.DB_PREFIX.'categories (`id`, `name`, `varname`, `catimg`, `showmenu`, `showfooter`, `catorder`, `catparent`, `pageid`, `activeplugin`, `pluginid`) VALUES (NULL, "FAQ", "faq", NULL, 1, 0, 5, 0, 0, 1, "'.$rows['id'].'")');

$jakdb->query('CREATE TABLE IF NOT EXISTS '.DB_PREFIX.'faq (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `catid` int(11) unsigned NOT NULL DEFAULT 0,
  `title` varchar(255) DEFAULT NULL,
  `content` mediumtext,
  `previmg` varchar(255) DEFAULT NULL,
  `showtitle` smallint(1) unsigned NOT NULL DEFAULT 1,
  `active` smallint(1) unsigned NOT NULL DEFAULT 1,
  `showcontact` int(11) unsigned NOT NULL DEFAULT 0,
  `showdate` smallint(1) unsigned NOT NULL DEFAULT 0,
  `comments` smallint(1) unsigned NOT NULL DEFAULT 0,
  `socialbutton` smallint(1) unsigned NOT NULL DEFAULT 0,
  `hits` int(10) unsigned NOT NULL DEFAULT 0,
  `showvote` smallint(1) unsigned NOT NULL DEFAULT 0,
  `time` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',
  PRIMARY KEY (`id`),
  KEY `catid` (`catid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');

$jakdb->query('CREATE TABLE IF NOT EXISTS '.DB_PREFIX.'faqcategories (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `varname` varchar(255) DEFAULT NULL,
  `catimg` varchar(255) DEFAULT NULL,
  `content` mediumtext,
  `permission` mediumtext,
  `catorder` int(11) unsigned NOT NULL DEFAULT 1,
  `catparent` int(11) unsigned NOT NULL DEFAULT 0,
  `active` smallint(1) unsigned NOT NULL DEFAULT 1,
  `count` int(11) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `catorder` (`catorder`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');

$jakdb->query('CREATE TABLE IF NOT EXISTS '.DB_PREFIX.'faqcomments (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `faqid` int(11) unsigned NOT NULL DEFAULT 0,
  `userid` int(11) NOT NULL DEFAULT 0,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `web` varchar(255) DEFAULT NULL,
  `message` text,
  `approve` smallint(1) unsigned NOT NULL DEFAULT 0,
  `trash` smallint(1) unsigned NOT NULL DEFAULT 0,
  `time` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',
  `session` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `faqid` (`faqid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1');

// Full text search is activated we do so for the faq table as well
if ($jkv["fulltextsearch"]) {
	$jakdb->query('ALTER TABLE '.DB_PREFIX.'faq ADD FULLTEXT(`title`, `content`)');
}

$succesfully = 1;

?>
<div class="alert alert-success">Plugin installed successfully</div>
<?php } else { 

$result = $jakdb->query('DELETE FROM '.DB_PREFIX.'plugins WHERE name = "Faq"');

?>
<div class="alert alert-success">Plugin install failed, could not determine the plugin id.</div>
<form name="company" method="post" action="uninstall.php" enctype="multipart/form-data">
<div class="form-actions">
<button type="submit" name="redirect" class="btn btn-primary pull-right">Back to Plugins</button>
</div>
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