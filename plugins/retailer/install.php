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
	<title>Installation - Retailer Plugin</title>
	<meta charset="utf-8">
	<meta name="author" content="CLARICOM (http://www.claricom.ca)" />
	<link rel="stylesheet" href="../../css/stylesheet.css" type="text/css" media="screen" />
</head>
<body>

<div class="container">
<div class="row">
<div class="col-md-12">
<h3>Installation - Retailer Plugin</h3>

<?php if (isset($_POST['install'])) {
 
$jakdb->query('INSERT INTO '.DB_PREFIX.'plugins (`id`, `name`, `description`, `active`, `access`, `pluginorder`, `pluginpath`, `phpcode`, `phpcodeadmin`, `sidenavhtml`, `usergroup`, `uninstallfile`, `pluginversion`, `time`) VALUES (NULL, "Retailer", "Run your own Retailer database.", 1, '.JAK_USERID.', 4, "retailer", "require_once APP_PATH.\'plugins/retailer/retailer.php\';", "if ($page == \'retailer\') {
        require_once APP_PATH.\'plugins/retailer/admin/retailer.php\';
           $JAK_PROVED = 1;
           $checkp = 1;
        }", "../plugins/retailer/admin/template/retailernav.php", "retailer", "uninstall.php", "1.0", NOW())');

// now get the plugin id for futher use
$results = $jakdb->query('SELECT id FROM '.DB_PREFIX.'plugins WHERE name = "Retailer"');
$rows = $results->fetch_assoc();

if ($rows['id']) {

// Insert php code
$insertphpcode = 'if (isset($defaults[\'jak_retailer\'])) {
	$insert .= \'retailer = \"\'.$defaults[\'jak_retailer\'].\'\", retailerpost = \"\'.$defaults[\'jak_retailerpost\'].\'\", retailerpostapprove = \"\'.$defaults[\'jak_retailerpostapprove\'].\'\", retailerpostdelete = \"\'.$defaults[\'jak_retailerpostdelete\'].\'\", retailerrate = \"\'.$defaults[\'jak_retailerrate\'].\'\", retailermoderate = \"\'.$defaults[\'jak_retailermoderate\'].\'\",\'; }';
	

$adminlang = 'if (file_exists(APP_PATH.\'plugins/retailer/admin/lang/\'.$site_language.\'.ini\')) {
    $tlre = parse_ini_file(APP_PATH.\'plugins/retailer/admin/lang/\'.$site_language.\'.ini\', true);
} else {
    $tlre = parse_ini_file(APP_PATH.\'plugins/retailer/admin/lang/en.ini\', true);
}';

$sitelang = 'if (file_exists(APP_PATH.\'plugins/retailer/lang/\'.$site_language.\'.ini\')) {
    $tlre = parse_ini_file(APP_PATH.\'plugins/retailer/lang/\'.$site_language.\'.ini\', true);
} else {
    $tlre = parse_ini_file(APP_PATH.\'plugins/retailer/lang/en.ini\', true);
}';

$sitephpsearch = '$retailer = new JAK_search($SearchInput); 
        	$retailer->jakSettable(\'retailer\',\"\");
        	$retailer->jakAndor(\"OR\");
        	$retailer->jakFieldactive(\"active\");
        	$retailer->jakFieldtitle(\"title\");
        	$retailer->jakFieldcut(\"content\");
        	$retailer->jakFieldstosearch(array(\'title\',\'content\'));
        	$retailer->jakFieldstoselect(\"id, title, content\");
        	
        	// Load the array into template
        	$JAK_SEARCH_RESULT_RETAILER = $retailer->set_result(JAK_PLUGIN_VAR_RETAILER, \'r\', $jkv[\"retailerurl\"]);';
        	
$sitephprss = 'if ($page1 == JAK_PLUGIN_VAR_RETAILER) {
	
	if ($jkv[\"retailerrss\"]) {
		$sql = \'SELECT id, title, content, time FROM \'.DB_PREFIX.\'retailer WHERE active = 1 ORDER BY time DESC LIMIT \'.$jkv[\"retailerrss\"];
		$sURL = JAK_PLUGIN_VAR_RETAILER;
		$sURL1 = \'r\';
		$what = 1;
		$seowhat = $jkv[\"retailerurl\"];
		
		$JAK_RSS_DESCRIPTION = jak_cut_text($jkv[\"retailerdesc\"], JAK_SHORTMSG, \'…\');
		
	} else {
		jak_redirect(BASE_URL);
	}
	
}';

$sitephptag = 'if ($row[\'pluginid\'] == JAK_PLUGIN_ID_RETAILER) {
$retailertagData[] = JAK_tags::jakTagsql(\"retailer\", $row[\'itemid\'], \"id, title, content\", \"content\", JAK_PLUGIN_VAR_RETAILER, \"r\", $jkv[\"retailerurl\"]);
$JAK_TAG_RETAILER_DATA = $retailertagData;
}';

$sitephpsitemap = 'include_once APP_PATH.\'plugins/retailer/functions.php\';

$JAK_RETAILER_ALL = jak_get_retailer(\'\', $jkv[\"retailerorder\"], \'\', \'\', $jkv[\"retailerurl\"], $tl[\'general\'][\'g56\']);
$PAGE_TITLE = JAK_PLUGIN_NAME_RETAILER;';

// Fulltext search query
$sqlfull = '$jakdb->query(\'ALTER TABLE \'.DB_PREFIX.\'retailer ADD FULLTEXT(`title`, `content`)\');';
$sqlfullremove = '$jakdb->query(\'ALTER TABLE \'.DB_PREFIX.\'retailer DROP INDEX `title`\');';

// Connect to pages/news
$pages = 'if ($pg[\'pluginid\'] == JAK_PLUGIN_RETAILER) {

include_once APP_PATH.\'plugins/retailer/admin/template/retailer_connect.php\';

}';

$sqlinsert = 'if (!isset($defaults[\'jak_showretailer\'])) {
	$fq = 0;
} else if (in_array(0, $defaults[\'jak_showretailer\'])) {
	$fq = 0;
} else {
	$fq = join(\',\', $defaults[\'jak_showretailer\']);
}

if (empty($fq) && !empty($defaults[\'jak_showretailermany\'])) {
	$insert .= \'showretailer = \"\'.$defaults[\'jak_showretailerorder\'].\':\'.$defaults[\'jak_showretailermany\'].\'\",\';
} else if (!empty($fq)) {
	$insert .= \'showretailer = \"\'.$fq.\'\",\';
} else {
  	$insert .= \'showretailer = NULL,\';
}';

$getretailer = '$JAK_GET_RETAILER = jak_get_page_info(DB_PREFIX.\'retailer\', \'\');

if ($JAK_FORM_DATA) {

$showretailerarray = explode(\":\", $JAK_FORM_DATA[\'showretailer\']);

if (is_array($showretailerarray) && in_array(\"ASC\", $showretailerarray) || in_array(\"DESC\", $showretailerarray)) {

		$JAK_FORM_DATA[\'showretailerorder\'] = $showretailerarray[0];
		$JAK_FORM_DATA[\'showretailermany\'] = $showretailerarray[1];
	
} }';

// Eval code for display connect
$get_fqconnect = 'if (JAK_PLUGIN_ACCESS_RETAILER && $pg[\'pluginid\'] == JAK_PLUGIN_ID_RETAILER && !empty($row[\'showretailer\'])) {
include_once APP_PATH.\'plugins/retailer/template/\'.$jkv[\"sitestyle\"].\'/pages_news.php\';}';

$adminphpdelete = '$jakdb->query(\'UPDATE \'.DB_PREFIX.\'retailercomments SET userid = 0 WHERE userid = \'.$page2.\'\');';
					
$adminphprename = '$jakdb->query(\'UPDATE \'.DB_PREFIX.\'retailercomments SET username = \"\'.smartsql($defaults[\'jak_username\']).\'\" WHERE userid = \'.smartsql($page2).\'\');';
					
$adminphpmassdel = '$jakdb->query(\'UPDATE \'.DB_PREFIX.\'retailercomments SET userid = 0 WHERE userid = \'.$page2.\'\');';

$jakdb->query('INSERT INTO '.DB_PREFIX.'pluginhooks (`id`, `hook_name`, `name`, `phpcode`, `product`, `active`, `exorder`, `pluginid`, `time`) VALUES (NULL, "php_admin_usergroup", "Retailer Usergroup", "'.$insertphpcode.'", "retailer", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "php_admin_lang", "Retailer Admin Language", "'.$adminlang.'", "retailer", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "php_lang", "Retailer Site Language", "'.$sitelang.'", "retailer", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "php_search", "Retailer Search PHP", "'.$sitephpsearch.'", "retailer", 1, 8, "'.$rows['id'].'", NOW()), (NULL, "php_rss", "Retailer RSS PHP", "'.$sitephprss.'", "retailer", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_tags", "Retailer Tags PHP", "'.$sitephptag.'", "retailer", 1, 8, "'.$rows['id'].'", NOW()), (NULL, "php_sitemap", "Retailer Sitemap PHP", "'.$sitephpsitemap.'", "retailer", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_between_head", "Retailer CSS", "plugins/retailer/template/cssheader.php", "retailer", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_admin_usergroup", "Retailer Usergroup New", "plugins/retailer/admin/template/usergroup_new.php", "retailer", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_admin_usergroup_edit", "Retailer Usergroup Edit", "plugins/retailer/admin/template/usergroup_edit.php", "retailer", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_tags", "Retailer Tags TPL", "plugins/retailer/template/tag.php", "retailer", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_sitemap", "Retailer Sitemap TPL", "plugins/retailer/template/sitemap.php", "retailer", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_sidebar", "Retailer Sidebar Categories TPL", "plugins/retailer/template/retailersidebar.php", "retailer", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "php_admin_fulltext_add", "Retailer Full Text Search", "'.$sqlfull.'", "retailer", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_admin_fulltext_remove", "Retailer Remove Full Text Search", "'.$sqlfullremove.'", "retailer", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "tpl_admin_page_news", "Retailer Admin - Page/News", "'.$pages.'", "retailer", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "tpl_admin_page_news_new", "Retailer Admin - Page/News - New", "plugins/retailer/admin/template/retailer_connect_new.php", "retailer", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_admin_pages_sql", "Retailer Pages SQL", "'.$sqlinsert.'", "retailer", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_admin_news_sql", "Retailer News SQL", "'.$sqlinsert.'", "retailer", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_admin_pages_news_info", "Retailer Pages/News Info", "'.$getretailer.'", "retailer", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "tpl_page_news_grid", "Retailer Pages/News Display", "'.$get_fqconnect.'", "retailer", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "tpl_search", "Retailer Search TPL", "plugins/retailer/template/search.php", "retailer", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_admin_user_delete", "Retailer Delete User", "'.$adminphpdelete.'", "retailer", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_admin_user_rename", "Retailer Rename User", "'.$adminphprename.'", "retailer", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_admin_user_delete_mass", "Retailer Delete User Mass", "'.$adminphpmassdel.'", "retailer", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "tpl_admin_head", "Retailer Admin - CSS", "plugins/retailer/admin/template/csshead.php", "retailer", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "tpl_footer_end", "Retailer - JS", "plugins/retailer/template/jsfooter.php", "retailer", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "tpl_footer_widgets", "Retailer - 5 Latest Entries", "plugins/retailer/template/footer_widget.php", "retailer", 1, 3, "'.$row['id'].'", NOW()), (NULL, "tpl_footer_widgets", "Retailer - Show Categories", "plugins/retailer/template/footer_widget1.php", "retailer", 1, 3, "'.$row['id'].'", NOW())');

// Insert tables into settings
$jakdb->query('INSERT INTO '.DB_PREFIX.'setting (`varname`, `groupname`, `value`, `defaultvalue`, `optioncode`, `datatype`, `product`) VALUES ("retailertitle", "retailer", NULL, NULL, "input", "free", "retailer"), ("retailerdesc", "retailer", NULL, NULL, "textarea", "free", "retailer"), ("retaileremail", "retailer", NULL, NULL, "input", "free", "retailer"), ("retailerdateformat", "retailer", "d.m.Y", "d.m.Y", "input", "free", "retailer"), ("retailertimeformat", "retailer", ": h:i A", ": h:i A", "input", "free", "retailer"), ("retailerurl", "retailer", 0, 0, "yesno", "boolean", "retailer"), ("retailermaxpost", "retailer", 2000, 2000, "input", "boolean", "retailer"), ("retailerpagemid", "retailer", 3, 3, "yesno", "number", "retailer"), ("retailerpageitem", "retailer", 4, 4, "yesno", "number", "retailer"), ("retailerorder", "retailer", "id ASC", "", "input", "free", "retailer"), ("retailerrss", "retailer", 5, 5, "number", "select", "retailer"), ("retailerlat", "retailer", "4", "4", "input", "free", "retailer"), ("retailerlng", "retailer", "10", "10", "input", "free", "retailer"), ("retailerzoom", "retailer", 10, 10, "select", "number", "retailer"), ("retailermapstyle", "retailer", "ROADMAP", "ROADMAP", "select", "free", "retailer"), ("retailershowmap", "retailer", 1, 1, "yesno", "boolean", "retailer"), ("retailerlocation", "retailer", 1, 1, "yesno", "boolean", "retailer"), ("retailer_css", "retailer", "", "", "textarea", "free", "retailer"), ("retailer_javascript", "retailer", "", "", "textarea", "free", "retailer"), ("retailermapkey", "retailer", "", "", "input", "free", "retailer")');

// Insert into usergroup
$jakdb->query('ALTER TABLE '.DB_PREFIX.'usergroup ADD `retailer` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `advsearch`, ADD `retailerpost` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `retailer`, ADD `retailerpostdelete` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `retailerpost`, ADD `retailerpostapprove` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `retailerpostdelete`, ADD `retailerrate` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `retailerpostdelete`, ADD `retailermoderate` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `retailerrate`');

// Pages/News alter Table
$jakdb->query('ALTER TABLE '.DB_PREFIX.'pages ADD showretailer varchar(100) DEFAULT NULL AFTER showcontact');
$jakdb->query('ALTER TABLE '.DB_PREFIX.'news ADD showretailer varchar(100) DEFAULT NULL AFTER showcontact');
$jakdb->query('ALTER TABLE '.DB_PREFIX.'pagesgrid ADD retailerid INT(11) UNSIGNED NOT NULL DEFAULT 0 AFTER newsid');

// Insert Category
$jakdb->query('INSERT INTO '.DB_PREFIX.'categories (`id`, `name`, `varname`, `catimg`, `showmenu`, `showfooter`, `catorder`, `catparent`, `pageid`, `activeplugin`, `pluginid`) VALUES (NULL, "Retailer", "retailer", NULL, 1, 0, 5, 0, 0, 1, "'.$rows['id'].'")');

$jakdb->query('CREATE TABLE IF NOT EXISTS '.DB_PREFIX.'retailer (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `catid` varchar(100) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` mediumtext,
  `content_css` text NULL,
  `content_javascript` text NULL,
  `sidebar` smallint(1) UNSIGNED NOT NULL DEFAULT 1,
  `shortcontent` varchar(255) DEFAULT NULL,
  `previmg` varchar(255) DEFAULT NULL,
  `previmg2` varchar(255) DEFAULT NULL,
  `previmg3` varchar(255) DEFAULT NULL,
  `address` mediumtext,
  `phone` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `weburl` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `showtitle` smallint(1) unsigned NOT NULL DEFAULT 1,
  `showhits` smallint(1) unsigned NOT NULL DEFAULT 1,
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

$jakdb->query('CREATE TABLE IF NOT EXISTS '.DB_PREFIX.'retailercategories (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `varname` varchar(100) DEFAULT NULL,
  `catimg` varchar(255) DEFAULT NULL,
  `markercolor` varchar(25) DEFAULT NULL,
  `content` mediumtext,
  `permission` mediumtext,
  `catorder` int(11) unsigned NOT NULL DEFAULT 1,
  `catparent` int(11) unsigned NOT NULL DEFAULT 0,
  `active` smallint(1) unsigned NOT NULL DEFAULT 1,
  `count` int(11) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `catorder` (`catorder`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');

$jakdb->query('CREATE TABLE IF NOT EXISTS '.DB_PREFIX.'retailercomments (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `retailerid` int(11) unsigned NOT NULL DEFAULT 0,
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
  KEY `retailerid` (`retailerid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1');

// Full text search is activated we do so for the retailer table as well
if ($jkv["fulltextsearch"]) {
	$jakdb->query('ALTER TABLE '.DB_PREFIX.'retailer ADD FULLTEXT(`title`, `content`)');
}

$succesfully = 1;

?>
<div class="alert alert-success">Plugin installed successfully</div>
<?php } else { 

$result = $jakdb->query('DELETE FROM '.DB_PREFIX.'plugins WHERE name = "Retailer"');

?>
<div class="status-ok">Plugin install failed, could not determine the plugin id.</div>
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