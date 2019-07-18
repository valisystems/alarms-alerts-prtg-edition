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
	<title>Installation - Support Ticket Plugin</title>
	<meta charset="utf-8">
	<meta name="author" content="JAKWEB (http://www.jakweb.ch)" />
	<link rel="stylesheet" href="../../css/stylesheet.css" type="text/css" media="screen" />
</head>
<body>

<div class="container">
<div class="row">
<div class="col-md-12">
<h3>Installation - Support Ticket Plugin</h3>

<?php if (isset($_POST['install'])) {

$jakdb->query('INSERT INTO '.DB_PREFIX.'plugins (`id`, `name`, `description`, `active`, `access`, `pluginorder`, `pluginpath`, `phpcode`, `phpcodeadmin`, `sidenavhtml`, `usergroup`, `uninstallfile`, `pluginversion`, `time`) VALUES (NULL, "Ticketing", "Professional Support Ticketing System", 1, '.JAK_USERID.', 4, "ticketing", "require_once APP_PATH.\'plugins/ticketing/s_ticket.php\';", "if ($page == \'ticketing\') {
        require_once APP_PATH.\'plugins/ticketing/admin/s_ticket.php\';
           $JAK_PROVED = 1;
           $checkp = 1;
        }", "../plugins/ticketing/admin/template/ticketnav.php", "ticket", "uninstall.php", "1.0", NOW())');

// now get the plugin id for futher use
$results = $jakdb->query('SELECT id FROM '.DB_PREFIX.'plugins WHERE name = "Ticketing"');
$rows = $results->fetch_assoc();

if ($rows['id']) {

// Insert php code
$insertphpcode = 'if (isset($defaults[\'jak_ticket\'])) {
	$insert .= \'ticket = \"\'.$defaults[\'jak_ticket\'].\'\", ticketpost = \"\'.$defaults[\'jak_ticketpost\'].\'\", ticketpostapprove = \"\'.$defaults[\'jak_ticketpostapprove\'].\'\", ticketpostdelete = \"\'.$defaults[\'jak_ticketpostdelete\'].\'\", ticketrate = \"\'.$defaults[\'jak_ticketrate\'].\'\", ticketmoderate = \"\'.$defaults[\'jak_ticketmoderate\'].\'\",\'; }';
	
$adminlang = 'if (file_exists(APP_PATH.\'plugins/ticketing/admin/lang/\'.$site_language.\'.ini\')) {
    $tlt = parse_ini_file(APP_PATH.\'plugins/ticketing/admin/lang/\'.$site_language.\'.ini\', true);
} else {
    $tlt = parse_ini_file(APP_PATH.\'plugins/ticketing/admin/lang/en.ini\', true);
}';

$sitelang = 'if (file_exists(APP_PATH.\'plugins/ticketing/lang/\'.$site_language.\'.ini\')) {
    $tlt = parse_ini_file(APP_PATH.\'plugins/ticketing/lang/\'.$site_language.\'.ini\', true);
} else {
    $tlt = parse_ini_file(APP_PATH.\'plugins/ticketing/lang/en.ini\', true);
}';

$sitephpsearch = '$ticket = new JAK_search($SearchInput); 
        	$ticket->jakSettable(\'tickets\',\"\");
        	$ticket->jakAndor(\"OR\");
        	$ticket->jakFieldactive(\"stprivate = 0 AND active\");
        	$ticket->jakFieldtitle(\"title\");
        	$ticket->jakFieldcut(\"content\");
        	$ticket->jakFieldstosearch(array(\'title\', \'content\'));
        	$ticket->jakFieldstoselect(\"id, title, content\");
        	
        	// Load the array into template
        	$JAK_SEARCH_RESULT_TICKET = $ticket->set_result(JAK_PLUGIN_VAR_TICKETING, \'t\', $jkv[\"ticketurl\"]);';

$sitephprss = 'if ($page1 == JAK_PLUGIN_VAR_TICKETING) {
	
	if ($jkv[\"ticketrss\"]) {
		$sql = \'SELECT id, title, content, time FROM \'.DB_PREFIX.\'tickets WHERE active = 1 AND stprivate = 0 ORDER BY time DESC LIMIT \'.$jkv[\"ticketrss\"];
		$sURL = JAK_PLUGIN_VAR_TICKETING;
		$sURL1 = \'t\';
		$what = 1;
		$seowhat = $jkv[\"ticketurl\"];
		
		$JAK_RSS_DESCRIPTION = jak_cut_text($jkv[\"ticketdesc\"], $jkv[\"shortmsg\"], \'…\');
		
	} else {
		jak_redirect(BASE_URL);
	}
	
}';

$sitephptag = 'if ($row[\'pluginid\'] == JAK_PLUGIN_ID_TICKETING) {
$tickettagData[] = JAK_tags::jakTagsql(\"tickets\", $row[\'itemid\'], \"id, title, content\", \"content\", JAK_PLUGIN_VAR_TICKETING, \"t\", $jkv[\"ticketurl\"]);
$JAK_TAG_TICKET_DATA = $tickettagData;
}';

$sitephpsitemap = 'include_once APP_PATH.\'plugins/ticketing/functions.php\';

define(\'JAK_TICKETMODERATE\', $jakusergroup->getVar(\"ticketmoderate\"));

$JAK_TICKET_ALL = jak_get_ticket(\'\', $jkv[\"ticketorder\"], \'\', \'\', $jkv[\"ticketurl\"], $tl[\'general\'][\'g56\']);
$PAGE_TITLE = JAK_PLUGIN_NAME_TICKETING;';

// Connect to pages/news
$pages = 'if ($pg[\'pluginid\'] == JAK_PLUGIN_TICKETING) {

include_once APP_PATH.\'plugins/ticketing/admin/template/st_connect.php\';

}';

$sqlinsert = 'if (!isset($defaults[\'jak_showst\'])) {
	$st = 0;
} else if (in_array(0, $defaults[\'jak_showst\'])) {
	$st = 0;
} else {
	$st = join(\',\', $defaults[\'jak_showst\']);
}

if (empty($st) && !empty($defaults[\'jak_showstmany\'])) {
	$insert .= \'showticketing = \"\'.$defaults[\'jak_showstorder\'].\':\'.$defaults[\'jak_showstmany\'].\'\",\';
} else if (!empty($st)) {
	$insert .= \'showticketing = \"\'.$st.\'\",\';
} else {
  	$insert .= \'showticketing = NULL,\';
}';

$getst = '$JAK_GET_TICKETING = jak_get_page_info(DB_PREFIX.\'tickets\', \'\');

if ($JAK_FORM_DATA) {

$showstarray = explode(\":\", $JAK_FORM_DATA[\'showticketing\']);

if (is_array($showstarray) && in_array(\"ASC\", $showstarray) || in_array(\"DESC\", $showstarray)) {

		$JAK_FORM_DATA[\'showstorder\'] = $showstarray[0];
		$JAK_FORM_DATA[\'showstmany\'] = $showstarray[1];
	
} }';

// Eval because of the foreach
$tpl_connect = 'if (JAK_PLUGIN_ACCESS_TICKETING && $pg[\'pluginid\'] == JAK_PLUGIN_ID_TICKETING && !empty($row[\'showticketing\'])) {
include_once APP_PATH.\'plugins/ticketing/template/\'.$jkv[\"sitestyle\"].\'/page_news.php\';}';

$adminphpdelete = '$jakdb->query(\'UPDATE \'.DB_PREFIX.\'ticketcomments SET userid = 0 WHERE userid = \'.$page2.\'\');';
					
$adminphprename = '$jakdb->query(\'UPDATE \'.DB_PREFIX.\'ticketcomments SET username = \"\'.smartsql($defaults[\'jak_username\']).\'\" WHERE userid = \'.smartsql($page2).\'\');';
					
$adminphpmassdel = '$jakdb->query(\'UPDATE \'.DB_PREFIX.\'ticketcomments SET userid = 0 WHERE userid = \'.$locked.\'\');';

// Fulltext search query
$sqlfull = '$jakdb->query(\'ALTER TABLE \'.DB_PREFIX.\'tickets ADD FULLTEXT(`title`, `content`)\');';
$sqlfullremove = '$jakdb->query(\'ALTER TABLE \'.DB_PREFIX.\'tickets DROP INDEX `title`\');';

$jakdb->query('INSERT INTO '.DB_PREFIX.'pluginhooks (`id`, `hook_name`, `name`, `phpcode`, `product`, `active`, `exorder`, `pluginid`, `time`) VALUES (NULL, "php_admin_usergroup", "Ticketing Usergroup", "'.$insertphpcode.'", "ticketing", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "php_admin_lang", "Ticketing Admin Language", "'.$adminlang.'", "ticketing", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "php_lang", "Ticketing Site Language", "'.$sitelang.'", "ticketing", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "php_search", "Ticketing Search PHP", "'.$sitephpsearch.'", "ticketing", 1, 8, "'.$rows['id'].'", NOW()), (NULL, "php_rss", "Support Ticket RSS PHP", "'.$sitephprss.'", "ticketing", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_tags", "Ticketing Tags PHP", "'.$sitephptag.'", "ticketing", 1, 8, "'.$rows['id'].'", NOW()), (NULL, "php_sitemap", "Ticketing Sitemap PHP", "'.$sitephpsitemap.'", "ticketing", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_between_head", "Ticketing CSS", "plugins/ticketing/template/cssheader.php", "ticketing", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_admin_usergroup", "Ticketing Usergroup New", "plugins/ticketing/admin/template/usergroup_new.php", "ticketing", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_admin_usergroup_edit", "Ticketing Usergroup Edit", "plugins/ticketing/admin/template/usergroup_edit.php", "ticketing", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_tags", "Ticketing Tags", "plugins/ticketing/template/tag.php", "ticketing", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_sitemap", "Ticketing Sitemap", "plugins/ticketing/template/sitemap.php", "ticketing", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_sidebar", "Ticketing Sidebar Categories", "plugins/ticketing/template/ticketsidebar.php", "ticketing", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "php_admin_fulltext_add", "Ticketing Full Text Search", "'.$sqlfull.'", "ticketing", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_admin_fulltext_remove", "Ticketing Remove Full Text Search", "'.$sqlfullremove.'", "ticketing", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "tpl_search", "Ticketing Search", "plugins/ticketing/template/search.php", "ticketing", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "tpl_admin_page_news", "Ticketing Admin - Page/News", "'.$pages.'", "ticketing", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "tpl_admin_page_news_new", "Ticketing Admin - Page/News - New", "plugins/ticketing/admin/template/st_connect_new.php", "ticketing", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_admin_pages_sql", "Ticketing Pages SQL", "'.$sqlinsert.'", "ticketing", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_admin_news_sql", "Ticketing News SQL", "'.$sqlinsert.'", "ticketing", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_admin_pages_news_info", "Ticketing Pages/News Info", "'.$getst.'", "ticketing", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "tpl_page_news_grid", "Ticketing Pages/News Display", "'.$tpl_connect.'", "ticketing", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_admin_user_delete", "Ticketing Delete User", "'.$adminphpdelete.'", "ticketing", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_admin_user_rename", "Ticketing Rename User", "'.$adminphprename.'", "ticketing", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_admin_user_delete_mass", "Ticketing Delete User Mass", "'.$adminphpmassdel.'", "ticketing", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "tpl_footer_widgets", "Ticketing - 3 Latest Tickets", "plugins/ticketing/template/footer_widget.php", "ticketing", 1, 3, "'.$rows['id'].'", NOW())');

// Insert tables into settings
$jakdb->query('INSERT INTO '.DB_PREFIX.'setting (`varname`, `groupname`, `value`, `defaultvalue`, `optioncode`, `datatype`, `product`) VALUES ("tickettitle", "ticket", "Support Tickets", NULL, "input", "free", "ticketing"), ("ticketdesc", "ticket", "Support and Bug Ticketing", NULL, "textarea", "free", "ticketing"),  ("ticketemail", "ticket", NULL, NULL, "input", "free", "ticketing"), ("ticketdateformat", "ticket", "d.m.Y", "d.m.Y", "input", "free", "ticketing"), ("tickettimeformat", "ticket", ": h:i A", ": h:i A", "input", "free", "ticketing"), ("ticketurl", "ticket", 0, 0, "yesno", "boolean", "ticketing"), ("ticketmaxpost", "ticket", 2000, 2000, "input", "boolean", "ticketing"), ("ticketshortmsg", "ticket", 80, 80, "number", "select", "ticketing"), ("ticketpagemid", "ticket", 3, 3, "yesno", "number", "ticketing"), ("ticketpageitem", "ticket", 4, 4, "yesno", "number", "ticketing"), ("ticketpath", "ticket", NULL, NULL, "input", "free", "ticketing"), ("ticketorder", "ticket", "id ASC", "", "input", "free", "ticketing"), ("ticketrss", "ticket", 5, 5, "number", "select", "ticketing"), ("ticketgvote", "ticket", 1, 1, "yesno", "boolean", "ticketing"), ("ticketgsocial", "ticket", 1, 1, "yesno", "boolean", "ticketing")');

// Insert into usergroup
$jakdb->query('ALTER TABLE '.DB_PREFIX.'usergroup ADD `ticket` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `advsearch`, ADD `ticketpost` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `ticket`, ADD `ticketpostdelete` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `ticketpost`, ADD `ticketpostapprove` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `ticketpostdelete`, ADD `ticketrate` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `ticketpostdelete`, ADD `ticketmoderate` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `ticketrate`');

// Pages/News alter Table
$jakdb->query('ALTER TABLE '.DB_PREFIX.'pages ADD showticketing varchar(100) DEFAULT NULL AFTER showcontact');
$jakdb->query('ALTER TABLE '.DB_PREFIX.'news ADD showticketing varchar(100) DEFAULT NULL AFTER showcontact');
$jakdb->query('ALTER TABLE '.DB_PREFIX.'pagesgrid ADD ticketid INT(11) UNSIGNED NOT NULL DEFAULT 0 AFTER newsid');

// Insert Category
$jakdb->query('INSERT INTO '.DB_PREFIX.'categories (`id`, `name`, `varname`, `catimg`, `showmenu`, `showfooter`, `catorder`, `catparent`, `pageid`, `activeplugin`, `pluginid`) VALUES (NULL, "Support", "support", NULL, 1, 0, 5, 0, 0, 1, "'.$rows['id'].'")');

$jakdb->query('CREATE TABLE IF NOT EXISTS '.DB_PREFIX.'tickets (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `catid` int(11) unsigned NOT NULL DEFAULT 0,
  `typeticket` int(11) unsigned NOT NULL DEFAULT 1,
  `title` varchar(100) DEFAULT NULL,
  `content` text,
  `priority` smallint(1) unsigned NOT NULL DEFAULT 5,
  `status` smallint(1) unsigned NOT NULL DEFAULT 1,
  `resolution` smallint(1) unsigned NOT NULL DEFAULT 5,
  `attachment` varchar(255) DEFAULT NULL,
  `userid` int(11) unsigned NOT NULL DEFAULT 0,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `active` smallint(1) unsigned NOT NULL DEFAULT 1,
  `comments` smallint(1) unsigned NOT NULL DEFAULT 0,
  `stprivate` smallint(1) unsigned NOT NULL DEFAULT 0,
  `socialbutton` smallint(1) unsigned NOT NULL DEFAULT 0,
  `hits` int(10) unsigned NOT NULL DEFAULT 0,
  `showvote` smallint(1) unsigned NOT NULL DEFAULT 0,
  `session` varchar(32) DEFAULT NULL,
  `time` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',
  PRIMARY KEY (`id`),
  KEY `catid` (`catid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');

$jakdb->query('CREATE TABLE IF NOT EXISTS '.DB_PREFIX.'ticketcategories (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `varname` varchar(100) DEFAULT NULL,
  `catimg` varchar(255) DEFAULT NULL,
  `content` mediumtext,
  `permission` mediumtext,
  `catorder` int(11) unsigned NOT NULL,
  `catparent` int(11) unsigned NOT NULL DEFAULT 0,
  `active` smallint(1) unsigned NOT NULL DEFAULT 1,
  `count` int(11) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `catorder` (`catorder`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');

$jakdb->query('CREATE TABLE IF NOT EXISTS '.DB_PREFIX.'ticketcomments (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticketid` int(11) unsigned NOT NULL DEFAULT 0,
  `commentid` int(11) unsigned NOT NULL DEFAULT 0,
  `userid` int(11) NOT NULL DEFAULT 0,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `web` varchar(255) DEFAULT NULL,
  `message` text,
  `approve` smallint(1) unsigned NOT NULL DEFAULT 0,
  `trash` smallint(1) unsigned NOT NULL DEFAULT 0,
  `votes` int(10) NOT NULL DEFAULT 0,
  `time` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',
  `session` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `trackid` (`ticketid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1');

$jakdb->query('CREATE TABLE '.DB_PREFIX.'ticketoptions (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `img` varchar(255) NOT NULL,
  `optorder` int(11) unsigned NOT NULL,
  `time` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',
  PRIMARY KEY (`id`),
  KEY `optorder` (`optorder`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');

// Full text search is activated we do so for the ticketing table as well
if ($jkv["fulltextsearch"]) {
	$jakdb->query('ALTER TABLE '.DB_PREFIX.'tickets ADD FULLTEXT(`title`, `content`)');
}

$succesfully = 1;

?>
<div class="alert alert-success">Plugin installed successfully</div>
<?php } else { 

$result = $jakdb->query('DELETE FROM '.DB_PREFIX.'plugins WHERE name = "Ticketing"');

?>
<div class="alert alert-success">Plugin install failed, could not determine the plugin id.</div>
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