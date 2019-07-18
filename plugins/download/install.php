<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

if (!file_exists('../../config.php')) die('[index.php] config.php not found');
require_once '../../config.php';

// Check if the file is accessed only from a admin if not stop the script from running
if (!JAK_USERID) die('You cannot access this file directly.');

// Not logged in sorry
if(!$jakuser->jakAdminaccess($jakuser->getVar("usergroupid"))) die('You cannot access this file directly.');

// Set successfully to zero
$succesfully = 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Installation - Download Plugin</title>
	<meta charset="utf-8">
	<meta name="author" content="CLARICOM (http://www.claricom.ca)" />
	<link rel="stylesheet" href="../../css/stylesheet.css" type="text/css" media="screen" />
</head>
<body>

<div class="container">
<div class="row">
<div class="col-md-12">
<h3>Installation - Download Plugin</h3>

<?php if (isset($_POST['install'])) {
 
$jakdb->query('INSERT INTO '.DB_PREFIX.'plugins (`id`, `name`, `description`, `active`, `access`, `pluginorder`, `pluginpath`, `phpcode`, `phpcodeadmin`, `sidenavhtml`, `usergroup`, `uninstallfile`, `pluginversion`, `time`) VALUES (NULL, "Download", "Run your own download database, let user download direct from your server or link.", 1, '.JAK_USERID.', 4, "download", "require_once APP_PATH.\'plugins/download/download.php\';", "if ($page == \'download\') {
        require_once APP_PATH.\'plugins/download/admin/download.php\';
           $JAK_PROVED = 1;
           $checkp = 1;
        }", "../plugins/download/admin/template/downloadnav.php", "download", "uninstall.php", "1.1", NOW())');

// now get the plugin id for futher use
$results = $jakdb->query('SELECT id FROM '.DB_PREFIX.'plugins WHERE name = "Download"');
$rows = $results->fetch_assoc();

if ($rows['id']) {

// Insert php code
$insertphpcode = 'if (isset($defaults[\'jak_download\'])) {
	$insert .= \'download = \"\'.$defaults[\'jak_download\'].\'\", downloadcan = \"\'.$defaults[\'jak_candownload\'].\'\", downloadpost = \"\'.$defaults[\'jak_downloadpost\'].\'\", downloadpostapprove = \"\'.$defaults[\'jak_downloadpostapprove\'].\'\", downloadpostdelete = \"\'.$defaults[\'jak_downloadpostdelete\'].\'\", downloadrate = \"\'.$defaults[\'jak_downloadrate\'].\'\", downloadmoderate = \"\'.$defaults[\'jak_downloadmoderate\'].\'\",\'; }';
	

$adminlang = 'if (file_exists(APP_PATH.\'plugins/download/admin/lang/\'.$site_language.\'.ini\')) {
    $tld = parse_ini_file(APP_PATH.\'plugins/download/admin/lang/\'.$site_language.\'.ini\', true);
} else {
    $tld = parse_ini_file(APP_PATH.\'plugins/download/admin/lang/en.ini\', true);
}';

$sitelang = 'if (file_exists(APP_PATH.\'plugins/download/lang/\'.$site_language.\'.ini\')) {
    $tld = parse_ini_file(APP_PATH.\'plugins/download/lang/\'.$site_language.\'.ini\', true);
} else {
    $tld = parse_ini_file(APP_PATH.\'plugins/download/lang/en.ini\', true);
}';

$sitephpsearch = '$download = new JAK_search($SearchInput); 
        	$download->jakSettable(\'download\',\"\");
        	$download->jakAndor(\"OR\");
        	$download->jakFieldactive(\"active\");
        	$download->jakFieldtitle(\"title\");
        	$download->jakFieldcut(\"content\");
        	$download->jakFieldstosearch(array(\"title\",\"content\"));
        	$download->jakFieldstoselect(\"id, title, content\");
        	
        	// Load the array into template
        	$JAK_SEARCH_RESULT_DOWNLOAD = $download->set_result(JAK_PLUGIN_VAR_DOWNLOAD, \'f\', $jkv[\"downloadurl\"]);';

$sitephptag = 'if ($row[\'pluginid\'] == JAK_PLUGIN_ID_DOWNLOAD) {
$downloadtagData[] = JAK_tags::jakTagsql(\"download\", $row[\'itemid\'], \"id, title, content\", \"content\", JAK_PLUGIN_VAR_DOWNLOAD, \"f\", $jkv[\"downloadurl\"]);
$JAK_TAG_DOWNLOAD_DATA = $downloadtagData;
}';

$sitephpsitemap = 'include_once APP_PATH.\'plugins/download/functions.php\';

$JAK_DOWNLOAD_ALL = jak_get_download(\'\', $jkv[\"downloadorder\"], \'\', \'\', $jkv[\"downloadrss\"], $jkv[\"downloadurl\"], $tl[\'general\'][\'g56\']);
$PAGE_TITLE = JAK_PLUGIN_NAME_DOWNLOAD;';

// Fulltext search query
$sqlfull = '$jakdb->query(\'ALTER TABLE \'.DB_PREFIX.\'download ADD FULLTEXT(`title`, `content`)\');';
$sqlfullremove = '$jakdb->query(\'ALTER TABLE \'.DB_PREFIX.\'download DROP INDEX `title`\');';

// Connect to pages/news
$pages = 'if ($pg[\'pluginid\'] == JAK_PLUGIN_DOWNLOAD) {

include_once APP_PATH.\'plugins/download/admin/template/dl_connect.php\';

}';

$sqlinsert = 'if (!isset($defaults[\'jak_showdl\'])) {
	$dl = 0;
} else if (in_array(0, $defaults[\'jak_showdl\'])) {
	$dl = 0;
} else {
	$dl = join(\',\', $defaults[\'jak_showdl\']);
}

if (empty($dl) && !empty($defaults[\'jak_showdlmany\'])) {
	$insert .= \'showdownload = \"\'.$defaults[\'jak_showdlorder\'].\':\'.$defaults[\'jak_showdlmany\'].\'\",\';
} else if (!empty($dl)) {
	$insert .= \'showdownload = \"\'.$dl.\'\",\';
} else {
  	$insert .= \'showdownload = NULL,\';
}';

$getdl = '$JAK_GET_DOWNLOAD = jak_get_page_info(DB_PREFIX.\'download\', \'\');

if ($JAK_FORM_DATA) {

$showdlarray = explode(\":\", $JAK_FORM_DATA[\'showdownload\']);

if (is_array($showdlarray) && in_array(\"ASC\", $showdlarray) || in_array(\"DESC\", $showdlarray)) {

		$JAK_FORM_DATA[\'showdlorder\'] = $showdlarray[0];
		$JAK_FORM_DATA[\'showdlmany\'] = $showdlarray[1];
	
} }';

// Eval code for display connect
$get_dlconnect = 'if (JAK_PLUGIN_ACCESS_DOWNLOAD && $pg[\'pluginid\'] == JAK_PLUGIN_ID_DOWNLOAD && !empty($row[\'showdownload\'])) {
include_once APP_PATH.\'plugins/download/template/\'.$jkv[\"sitestyle\"].\'/page_news.php\';}';

$adminphpdelete = '$jakdb->query(\'UPDATE \'.DB_PREFIX.\'downloadcomments SET userid = 0 WHERE userid = \'.$page2.\'\');';
					
$adminphprename = '$jakdb->query(\'UPDATE \'.DB_PREFIX.\'downloadcomments SET username = \"\'.smartsql($defaults[\'jak_username\']).\'\" WHERE userid = \'.smartsql($page2).\'\');';
					
$adminphpmassdel = '$jakdb->query(\'UPDATE \'.DB_PREFIX.\'downloadcomments SET userid = 0 WHERE userid = \'.$locked);';

$sitephprss = 'if ($page1 == JAK_PLUGIN_VAR_DOWNLOAD) {
	
	if ($jkv[\"downloadrss\"]) {
		$sql = \'SELECT id, title, content, time FROM \'.DB_PREFIX.\'download WHERE active = 1 ORDER BY time DESC LIMIT \'.$jkv[\"downloadrss\"];
		$sURL = JAK_PLUGIN_VAR_DOWNLOAD;
		$sURL1 = \'a\';
		$what = 1;
		$seowhat = $jkv[\"downloadurl\"];
		
		$JAK_RSS_DESCRIPTION = jak_cut_text($jkv[\"downloaddesc\"], $jkv[\"shortmsg\"], \'…\');
		
	} else {
		jak_redirect(BASE_URL);
	}
	
}';

$jakdb->query('INSERT INTO '.DB_PREFIX.'pluginhooks (`id`, `hook_name`, `name`, `phpcode`, `product`, `active`, `exorder`, `pluginid`, `time`) VALUES (NULL, "php_admin_usergroup", "Download Usergroup", "'.$insertphpcode.'", "download", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "php_admin_lang", "Download Admin Language", "'.$adminlang.'", "download", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "php_lang", "Download Site Language", "'.$sitelang.'", "download", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "php_search", "Download Search PHP", "'.$sitephpsearch.'", "download", 1, 8, "'.$rows['id'].'", NOW()), (NULL, "php_rss", "Download RSS PHP", "'.$sitephprss.'", "download", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_tags", "Download Tags PHP", "'.$sitephptag.'", "download", 1, 8, "'.$rows['id'].'", NOW()), (NULL, "php_sitemap", "Download Sitemap PHP", "'.$sitephpsitemap.'", "download", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_between_head", "Download CSS", "plugins/download/template/cssheader.php", "download", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_admin_usergroup", "Download Usergroup New", "plugins/download/admin/template/usergroup_new.php", "download", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_admin_usergroup_edit", "Download Usergroup Edit", "plugins/download/admin/template/usergroup_edit.php", "download", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_tags", "Download Tags", "plugins/download/template/tag.php", "download", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_sitemap", "Download Sitemap", "plugins/download/template/sitemap.php", "download", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_sidebar", "Download Sidebar Categories", "plugins/download/template/downloadsidebar.php", "download", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "php_admin_fulltext_add", "Download Full Text Search", "'.$sqlfull.'", "download", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_admin_fulltext_remove", "Download Remove Full Text Search", "'.$sqlfullremove.'", "download", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "tpl_admin_page_news", "Download Admin - Page/News", "'.$pages.'", "download", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "tpl_admin_page_news_new", "Download Admin - Page/News - New", "plugins/download/admin/template/dl_connect_new.php", "download", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_admin_pages_sql", "Download Pages SQL", "'.$sqlinsert.'", "download", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_admin_news_sql", "Download News SQL", "'.$sqlinsert.'", "download", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_admin_pages_news_info", "Download Pages/News Info", "'.$getdl.'", "download", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "tpl_page_news_grid", "Download Pages/News Display", "'.$get_dlconnect.'", "download", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "tpl_search", "Download Search", "plugins/download/template/search.php", "download", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_admin_user_delete", "Download Delete User", "'.$adminphpdelete.'", "download", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_admin_user_rename", "Download Rename User", "'.$adminphprename.'", "download", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_admin_user_delete_mass", "Download Delete User Mass", "'.$adminphpmassdel.'", "download", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "tpl_footer_widgets", "Download - 3 Latest Files", "plugins/download/template/footer_widget.php", "download", 1, 3, "'.$rows['id'].'", NOW()), (NULL, "tpl_footer_widgets", "Download - Show Categories", "plugins/download/template/footer_widget1.php", "download", 1, 3, "'.$rows['id'].'", NOW())');

// Insert tables into settings
$jakdb->query('INSERT INTO '.DB_PREFIX.'setting (`varname`, `groupname`, `value`, `defaultvalue`, `optioncode`, `datatype`, `product`) VALUES ("downloadtitle", "download", NULL, NULL, "input", "free", "download"), ("downloaddesc", "download", NULL, NULL, "textarea", "free", "download"), ("downloademail", "download", NULL, NULL, "input", "free", "download"), ("downloaddateformat", "download", "d.m.Y", "d.m.Y", "input", "free", "download"), ("downloadtimeformat", "download", ": h:i A", ": h:i A", "input", "free", "download"), ("downloadurl", "download", 0, 0, "yesno", "boolean", "download"), ("downloadmaxpost", "download", 2000, 2000, "input", "boolean", "download"), ("downloadpagemid", "download", 3, 3, "yesno", "number", "download"), ("downloadpageitem", "download", 4, 4, "yesno", "number", "download"), ("downloadpath", "download", NULL, NULL, "input", "free", "download"), ("downloadorder", "download", "id ASC", "", "input", "free", "download"), ("downloadtwitter", "download", "", "", "input", "free", "download"), ("download_css", "download", "", "", "textarea", "free", "download"), ("download_javascript", "download", "", "", "textarea", "free", "download"), ("downloadrss", "download", 5, 5, "select", "number", "download")');

// Insert into usergroup
$jakdb->query('ALTER TABLE '.DB_PREFIX.'usergroup ADD `download` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `advsearch`, ADD `downloadcan` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `download`, ADD `downloadpost` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `download`, ADD `downloadpostdelete` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `downloadpost`, ADD `downloadpostapprove` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `downloadpostdelete`, ADD `downloadrate` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `downloadpostdelete`, ADD `downloadmoderate` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `downloadrate`');

// Pages/News alter Table
$jakdb->query('ALTER TABLE '.DB_PREFIX.'pages ADD showdownload varchar(100) DEFAULT NULL AFTER showcontact');
$jakdb->query('ALTER TABLE '.DB_PREFIX.'news ADD showdownload varchar(100) DEFAULT NULL AFTER showcontact');
$jakdb->query('ALTER TABLE '.DB_PREFIX.'pagesgrid ADD fileid INT(11) UNSIGNED NOT NULL DEFAULT 0 AFTER newsid');

// Insert Category
$jakdb->query('INSERT INTO '.DB_PREFIX.'categories (`id`, `name`, `varname`, `catimg`, `showmenu`, `showfooter`, `catorder`, `catparent`, `pageid`, `activeplugin`, `pluginid`) VALUES (NULL, "Download", "download", NULL, 1, 0, 5, 0, 0, 1, "'.$rows['id'].'")');

$jakdb->query('CREATE TABLE IF NOT EXISTS '.DB_PREFIX.'download (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `catid` int(11) unsigned NOT NULL DEFAULT 0,
  `candownload` VARCHAR(100) NOT NULL DEFAULT 0,
  `title` varchar(255) DEFAULT NULL,
  `content` mediumtext,
  `dl_css` text,
  `dl_javascript` text,
  `sidebar` smallint(1) UNSIGNED NOT NULL DEFAULT 1,
  `file` varchar(255) DEFAULT NULL,
  `extfile` varchar(255) DEFAULT NULL,
  `countdl` int(10) unsigned NOT NULL DEFAULT 0,
  `previmg` varchar(255) DEFAULT NULL,
  `showtitle` smallint(1) unsigned NOT NULL DEFAULT 1,
  `active` smallint(1) unsigned NOT NULL DEFAULT 1,
  `showcontact` int(11) unsigned NOT NULL DEFAULT 0,
  `showdate` smallint(1) unsigned NOT NULL DEFAULT 0,
  `comments` smallint(1) unsigned NOT NULL DEFAULT 0,
  `ftshare` smallint(1) unsigned NOT NULL DEFAULT 0,
  `socialbutton` smallint(1) unsigned NOT NULL DEFAULT 0,
  `hits` int(10) unsigned NOT NULL DEFAULT 0,
  `showvote` smallint(1) unsigned NOT NULL DEFAULT 0,
  `password` char(64) DEFAULT NULL,
  `time` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',
  PRIMARY KEY (`id`),
  KEY `catid` (`catid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');

$jakdb->query('CREATE TABLE IF NOT EXISTS '.DB_PREFIX.'downloadcategories (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `varname` varchar(100) DEFAULT NULL,
  `catimg` varchar(255) DEFAULT NULL,
  `content` mediumtext,
  `permission` mediumtext,
  `catorder` int(11) unsigned NOT NULL DEFAULT 1,
  `catparent` int(11) unsigned NOT NULL DEFAULT 0,
  `active` smallint(1) unsigned NOT NULL DEFAULT 1,
  `count` int(11) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `catorder` (`catorder`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');

$jakdb->query('CREATE TABLE IF NOT EXISTS '.DB_PREFIX.'downloadcomments (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fileid` int(11) unsigned NOT NULL DEFAULT 0,
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
  KEY `fileid` (`fileid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1');

$jakdb->query('CREATE TABLE '.DB_PREFIX.'downloadhistory (
	`id` BIGINT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`fileid` INT(11) UNSIGNED NOT NULL DEFAULT 0,
	`userid` INT(11) UNSIGNED NOT NULL DEFAULT 0,
	`email` VARCHAR(255) NOT NULL,
	`filename` VARCHAR(255) NOT NULL,
	`ip` CHAR(15) NOT NULL,
	`time` DATETIME NOT NULL DEFAULT \'0000-00-00 00:00:00\',
	PRIMARY KEY (`id`),
	KEY `fileid` (`fileid`)
) ENGINE = MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1');

// Full text search is activated we do so for the download table as well
if ($jkv["fulltextsearch"]) {
	$jakdb->query('ALTER TABLE '.DB_PREFIX.'download ADD FULLTEXT(`title`, `content`)');
}

$succesfully = 1;

?>
<div class="alert alert-success">Plugin installed successfully</div>
<?php } else { 

$result = $jakdb->query('DELETE FROM '.DB_PREFIX.'plugins WHERE name = "Download"');

?>
<div class="alert alert-danger">Plugin install failed.</div>
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