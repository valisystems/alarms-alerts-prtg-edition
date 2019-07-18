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
	<title>Installation - Gallery Plugin</title>
	<meta charset="utf-8">
	<meta name="author" content="CLARICOM (http://www.claricom.ca)" />
	<link rel="stylesheet" href="../../css/stylesheet.css" type="text/css" media="screen" />
</head>
<body>

<div class="container">
<div class="row">
<div class="col-md-12">
<h3>Installation - Gallery Plugin</h3>

<?php if (isset($_POST['install'])) {
 
$jakdb->query('INSERT INTO '.DB_PREFIX.'plugins (`id`, `name`, `description`, `active`, `access`, `pluginorder`, `pluginpath`, `phpcode`, `phpcodeadmin`, `sidenavhtml`, `usergroup`, `uninstallfile`, `pluginversion`, `time`) VALUES (NULL, "Gallery", "Run your own gallery.", 1, '.JAK_USERID.', 4, "gallery", "require_once APP_PATH.\'plugins/gallery/gallery.php\';", "if ($page == \'gallery\') {
        require_once APP_PATH.\'plugins/gallery/admin/gallery.php\';
           $JAK_PROVED = 1;
           $checkp = 1;
        }", "../plugins/gallery/admin/template/gallerynav.php", "gallery", "uninstall.php", "1.0", NOW())');

// now get the plugin id for futher use
$results = $jakdb->query('SELECT id FROM '.DB_PREFIX.'plugins WHERE name = "Gallery"');
$rows = $results->fetch_assoc();

if ($rows['id']) {

// Insert php code
$insertphpcode = 'if (isset($defaults[\'jak_gallery\'])) {
	$insert .= \'gallery = \"\'.$defaults[\'jak_gallery\'].\'\", gallerypost = \"\'.$defaults[\'jak_gallerypost\'].\'\", gallerypostapprove = \"\'.$defaults[\'jak_gallerypostapprove\'].\'\", gallerypostdelete = \"\'.$defaults[\'jak_gallerypostdelete\'].\'\", galleryrate = \"\'.$defaults[\'jak_galleryrate\'].\'\", galleryupload = \"\'.$defaults[\'jak_galleryupload\'].\'\", gallerymoderate = \"\'.$defaults[\'jak_gallerymoderate\'].\'\",\'; }';
	

$adminlang = 'if (file_exists(APP_PATH.\'plugins/gallery/admin/lang/\'.$site_language.\'.ini\')) {
    $tlgal = parse_ini_file(APP_PATH.\'plugins/gallery/admin/lang/\'.$site_language.\'.ini\', true);
} else {
    $tlgal = parse_ini_file(APP_PATH.\'plugins/gallery/admin/lang/en.ini\', true);
}';

$sitelang = 'if (file_exists(APP_PATH.\'plugins/gallery/lang/\'.$site_language.\'.ini\')) {
    $tlgal = parse_ini_file(APP_PATH.\'plugins/gallery/lang/\'.$site_language.\'.ini\', true);
} else {
    $tlgal = parse_ini_file(APP_PATH.\'plugins/gallery/lang/en.ini\', true);
}';

$sitephpsearch = '$gallery = new JAK_search($SearchInput); 
        	$gallery->jakSettable(\'gallery\',\"\");
        	$gallery->jakAndor(\"OR\");
        	$gallery->jakFieldactive(\"active\");
        	$gallery->jakFieldtitle(\"title\");
        	$gallery->jakFieldcut(\"\");
        	$gallery->jakFieldstosearch(array(\'title\'));
        	$gallery->jakFieldstoselect(\"id, title\");
        	
        	// Load the array into template
        	$JAK_SEARCH_RESULT_GALLERY = $gallery->set_result(JAK_PLUGIN_VAR_GALLERY, \'p\', $jkv[\"galleryurl\"]);';
        	
$sitephprss = 'if ($page1 == JAK_PLUGIN_VAR_GALLERY) {
	
	if ($jkv[\"galleryrss\"]) {
		$sql = \'SELECT t1.id, t1.title as title, t1.time, t2.description as content FROM \'.DB_PREFIX.\'gallery AS t1 LEFT JOIN \'.DB_PREFIX.\'gallerycategories AS t2 ON (t1.catid = t2.id) WHERE t1.active = 1 ORDER BY t1.time DESC LIMIT \'.$jkv[\"galleryrss\"];
		$sURL = JAK_PLUGIN_VAR_GALLERY;
		$sURL1 = \'p\';
		$what = 1;
		$seowhat = $jkv[\"galleryurl\"];
		
		$JAK_RSS_DESCRIPTION = jak_cut_text($jkv[\"gallerydesc\"], JAK_SHORTMSG, \'...\');
		
	} else {
		jak_redirect(BASE_URL);
	}
	
}';

$sitephptag = 'if ($row[\'pluginid\'] == JAK_PLUGIN_ID_GALLERY) {
$gallerytagData[] = JAK_tags::jakTagsql(\"gallerycategories\", $row[\'itemid\'], \"id, name, content\", \"content\", JAK_PLUGIN_VAR_GALLERY, \"p\", $jkv[\"galleryurl\"]);
$JAK_TAG_GALLERY_DATA = $gallerytagData;
}';

$sitephpsitemap = 'include_once APP_PATH.\'plugins/gallery/functions.php\';

$JAK_GALLERY_ALL = jak_get_gallery(\'\', $jkv[\"galleryorder\"], \'\', \'\', $jkv[\"galleryurl\"], $tl[\'general\'][\'g56\']);
$PAGE_TITLE = JAK_PLUGIN_NAME_GALLERY;';

// Fulltext search query
$sqlfull = '$jakdb->query(\'ALTER TABLE \'.DB_PREFIX.\'gallery ADD FULLTEXT(`title`)\');';
$sqlfullremove = '$jakdb->query(\'ALTER TABLE \'.DB_PREFIX.\'gallery DROP INDEX `title`\');';

// Connect to pages/news
$pages = 'if ($pg[\'pluginid\'] == JAK_PLUGIN_GALLERY) {

include_once APP_PATH.\'plugins/gallery/admin/template/gallery_connect.php\';

}';

$sqlinsert = 'if (!isset($defaults[\'jak_showgallery\'])) {
	$gal = 0;
} else if (in_array(0, $defaults[\'jak_showgallery\'])) {
	$gal = 0;
} else {
	$gal = join(\',\', $defaults[\'jak_showgallery\']);
}

if (empty($gal) && !empty($defaults[\'jak_showgallerymany\'])) {
	$insert .= \'showgallery = \"\'.$defaults[\'jak_showgalleryorder\'].\':\'.$defaults[\'jak_showgallerymany\'].\':\'.$defaults[\'jak_showgallerycat\'].\'\",\';
} else if (!empty($gal)) {
	$insert .= \'showgallery = \"\'.$gal.\'\",\';
} else {
  	$insert .= \'showgallery = NULL,\';
}';

$getgallery = '$JAK_GET_GALLERY = jak_get_page_info(DB_PREFIX.\'gallery\', \'\');
$JAK_GET_GALLERY_CAT = jak_get_page_info(DB_PREFIX.\'gallerycategories\', \'\');

if ($JAK_FORM_DATA) {

$showgalleryarray = explode(\":\", $JAK_FORM_DATA[\'showgallery\']);

if (is_array($showgalleryarray) && in_array(\"ASC\", $showgalleryarray) || in_array(\"DESC\", $showgalleryarray)) {

		$JAK_FORM_DATA[\'showgalleryorder\'] = $showgalleryarray[0];
		$JAK_FORM_DATA[\'showgallerymany\'] = $showgalleryarray[1];
		$JAK_FORM_DATA[\'showgallerycat\'] = $showgalleryarray[2];
	
} }';

// Eval code for display connect
$get_fqconnect = 'if (JAK_PLUGIN_ACCESS_GALLERY && $pg[\'pluginid\'] == JAK_PLUGIN_ID_GALLERY && !empty($row[\'showgallery\'])) {
include_once APP_PATH.\'plugins/gallery/template/\'.$jkv[\"sitestyle\"].\'/pages_news.php\';}';

$adminphpdelete = '$jakdb->query(\'UPDATE \'.DB_PREFIX.\'gallerycomments SET userid = 0 WHERE userid = \'.$page2.\'\');';
					
$adminphprename = '$jakdb->query(\'UPDATE \'.DB_PREFIX.\'gallerycomments SET username = \"\'.smartsql($defaults[\'jak_username\']).\'\" WHERE userid = \'.smartsql($page2).\'\');';
					
$adminphpmassdel = '$jakdb->query(\'UPDATE \'.DB_PREFIX.\'gallerycomments SET userid = 0 WHERE userid = \'.$locked.\'\');';

$jakdb->query('INSERT INTO '.DB_PREFIX.'pluginhooks (`id`, `hook_name`, `name`, `phpcode`, `product`, `active`, `exorder`, `pluginid`, `time`) VALUES (NULL, "php_admin_usergroup", "Gallery Usergroup", "'.$insertphpcode.'", "gallery", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "php_admin_lang", "Gallery Admin Language", "'.$adminlang.'", "gallery", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "php_lang", "Gallery Site Language", "'.$sitelang.'", "gallery", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "php_search", "Gallery Search PHP", "'.$sitephpsearch.'", "gallery", 1, 8, "'.$rows['id'].'", NOW()), (NULL, "php_rss", "Gallery RSS PHP", "'.$sitephprss.'", "gallery", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_tags", "Gallery Tags PHP", "'.$sitephptag.'", "gallery", 1, 8, "'.$rows['id'].'", NOW()), (NULL, "php_sitemap", "Gallery Sitemap PHP", "'.$sitephpsitemap.'", "gallery", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_between_head", "Gallery CSS", "plugins/gallery/template/cssheader.php", "gallery", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_admin_usergroup", "Gallery Usergroup New", "plugins/gallery/admin/template/usergroup_new.php", "gallery", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_admin_usergroup_edit", "Gallery Usergroup Edit", "plugins/gallery/admin/template/usergroup_edit.php", "gallery", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_tags", "Gallery Tags", "plugins/gallery/template/tag.php", "gallery", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_sitemap", "Gallery Sitemap", "plugins/gallery/template/sitemap.php", "gallery", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_sidebar", "Gallery Sidebar Categories", "plugins/gallery/template/gallerysidebar.php", "gallery", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "php_admin_fulltext_add", "Gallery Full Text Search", "'.$sqlfull.'", "gallery", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_admin_fulltext_remove", "Gallery Remove Full Text Search", "'.$sqlfullremove.'", "gallery", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "tpl_admin_page_news", "Gallery Admin - Page/News", "'.$pages.'", "gallery", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "tpl_admin_page_news_new", "Gallery Admin - Page/News - New", "plugins/gallery/admin/template/gallery_connect_new.php", "gallery", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_admin_pages_sql", "Gallery Pages SQL", "'.$sqlinsert.'", "gallery", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_admin_news_sql", "Gallery News SQL", "'.$sqlinsert.'", "gallery", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_admin_pages_news_info", "Gallery Pages/News Info", "'.$getgallery.'", "gallery", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "tpl_page_news_grid", "Gallery Pages/News Display", "'.$get_fqconnect.'", "gallery", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "tpl_search", "Gallery Search", "plugins/gallery/template/search.php", "gallery", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_admin_user_delete", "Gallery Delete User", "'.$adminphpdelete.'", "gallery", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_admin_user_rename", "GALLERY Rename User", "'.$adminphprename.'", "gallery", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_admin_user_delete_mass", "Gallery Delete User Mass", "'.$adminphpmassdel.'", "gallery", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "tpl_footer_widgets", "Gallery - 10 Latest Photos", "plugins/gallery/template/footer_widget.php", "gallery", 1, 3, "'.$rows['id'].'", NOW())');

// Insert tables into settings
$jakdb->query('INSERT INTO '.DB_PREFIX.'setting (`varname`, `groupname`, `value`, `defaultvalue`, `optioncode`, `datatype`, `product`) VALUES ("gallerytitle", "gallery", NULL, NULL, "input", "free", "gallery"), ("gallerydesc", "gallery", NULL, NULL, "textarea", "free", "gallery"), ("galleryemail", "gallery", NULL, NULL, "input", "free", "gallery"), ("gallerydateformat", "gallery", "d.m.Y", "d.m.Y", "input", "free", "gallery"), ("gallerytimeformat", "gallery", ": h:i A", ": h:i A", "input", "free", "gallery"), ("galleryurl", "gallery", 0, 0, "yesno", "boolean", "gallery"), ("gallerymaxpost", "gallery", 2000, 2000, "input", "boolean", "gallery"), ("gallerypagemid", "gallery", 5, 5, "yesno", "number", "gallery"), ("gallerypageitem", "gallery", 24, 24, "yesno", "number", "gallery"), ("galleryorder", "gallery", "id ASC", "", "input", "free", "gallery"), ("galleryrss", "gallery", 5, 5, "number", "select", "gallery"), ("gallerythumbw", "gallery", "120", "120", "input", "number", "gallery"), ("gallerythumbh", "gallery", "90", "90", "input", "number", "gallery"), ("galleryw", "gallery", "600", "600", "input", "number", "gallery"), ("galleryh", "gallery", "450", "450", "input", "number", "gallery"), ("galleryimgquality", "gallery", "75", "75", "select", "number", "gallery"), ("gallerywatermark", "gallery", "", "img/watermark/wm.png", "input", "free", "gallery"), ("gallerywmposition", "gallery", "3", "9", "radio", "number", "gallery"), ("galleryimgsize", "gallery", "2", "2", "input", "number", "gallery"), ("galleryhlimit", "gallery", "12", "12", "select", "number", "gallery"), ("galleryopenattached", "gallery", "1", "1", "yesno", "boolean", "gallery")');

// Insert into usergroup
$jakdb->query('ALTER TABLE '.DB_PREFIX.'usergroup ADD `gallery` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `advsearch`, ADD `gallerypost` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `gallery`, ADD `gallerypostdelete` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `gallerypost`, ADD `gallerypostapprove` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `gallerypostdelete`, ADD `galleryrate` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `gallerypostdelete`, ADD `gallerymoderate` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `galleryrate`, ADD `galleryupload` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `gallerymoderate');

// Pages/News alter Table
$jakdb->query('ALTER TABLE '.DB_PREFIX.'pages ADD showgallery varchar(100) DEFAULT NULL AFTER showcontact');
$jakdb->query('ALTER TABLE '.DB_PREFIX.'news ADD showgallery varchar(100) DEFAULT NULL AFTER showcontact');
$jakdb->query('ALTER TABLE '.DB_PREFIX.'pagesgrid ADD galleryid INT(11) UNSIGNED NOT NULL DEFAULT 0 AFTER newsid');

// Insert Category
$jakdb->query('INSERT INTO '.DB_PREFIX.'categories (`id`, `name`, `varname`, `catimg`, `showmenu`, `showfooter`, `catorder`, `catparent`, `pageid`, `activeplugin`, `pluginid`) VALUES (NULL, "Gallery", "gallery", NULL, 1, 0, 5, 0, 0, 1, "'.$rows['id'].'")');

$jakdb->query('CREATE TABLE IF NOT EXISTS '.DB_PREFIX.'gallery (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `catid` int(11) NOT NULL DEFAULT 0,
  `paththumb` varchar(255) DEFAULT NULL,
  `pathbig` varchar(255) DEFAULT NULL,
  `original` varchar(255) DEFAULT NULL,
  `userid` int(11) NOT NULL DEFAULT 0,
  `title` varchar(255) DEFAULT NULL,
  `content` mediumtext,
  `hits` int(10) unsigned NOT NULL DEFAULT 0,
  `picorder` int(11) unsigned NOT NULL DEFAULT 1,
  `active` smallint(1) unsigned NOT NULL DEFAULT 1,
  `longitude` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `time` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',
  PRIMARY KEY (`id`),
  KEY `catid` (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');

$jakdb->query('CREATE TABLE IF NOT EXISTS '.DB_PREFIX.'gallerycategories (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `varname` varchar(255) DEFAULT NULL,
  `catimg` varchar(255) DEFAULT NULL,
  `content` mediumtext,
  `permission` text,
  `catorder` int(11) unsigned NOT NULL DEFAULT 1,
  `catparent` int(11) unsigned NOT NULL DEFAULT 0,
  `comments` smallint(1) unsigned NOT NULL DEFAULT 1,
  `showvote` smallint(1) unsigned NOT NULL DEFAULT 0,
  `socialbutton` smallint(1) unsigned NOT NULL DEFAULT 1,
  `active` smallint(1) unsigned NOT NULL DEFAULT 1,
  `uploadc` smallint(1) unsigned NOT NULL DEFAULT 0,
  `count` int(11) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `catorder` (`catorder`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');

$jakdb->query('CREATE TABLE IF NOT EXISTS '.DB_PREFIX.'gallerycomments (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `galleryid` int(11) unsigned NOT NULL DEFAULT 0,
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
  KEY `galleryid` (`galleryid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1');

// Full text search is activated we do so for the gallery table as well
if ($jkv["fulltextsearch"]) {
	$jakdb->query('ALTER TABLE '.DB_PREFIX.'gallery ADD FULLTEXT(`title`)');
}

$succesfully = 1;

?>
<div class="alert alert-success">Plugin installed successfully</div>
<?php } else { 

$result = $jakdb->query('DELETE FROM '.DB_PREFIX.'plugins WHERE name = "Gallery"');

?>
<div class="alert alert-danger">Plugin installation failed.</div>
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