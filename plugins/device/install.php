<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Include the config file...
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
	<title>Installation - Device Plugin</title>
	<meta charset="utf-8">
	<meta name="author" content="claricom (http://www.claricom.ca)" />
	<link rel="stylesheet" href="../../css/stylesheet.css" type="text/css" media="screen" />
</head>
<body>

<div class="container">
<div class="row">
<div class="col-md-12">
<h3>Installation - Device Plugin by Claricom.</h3>

<?php if (isset($_POST['install'])) {

$jakdb->query('INSERT INTO '.DB_PREFIX.'plugins (`id`, `name`, `description`, `active`, `access`, `pluginorder`, `pluginpath`, `phpcode`, `phpcodeadmin`, `sidenavhtml`, `usergroup`, `uninstallfile`, `pluginversion`, `time`) VALUES
		(NULL, "Device", "Run your own device.", 1, '.JAK_USERID.', 4, "device", "require_once APP_PATH.\'plugins/device/device.php\';",
			"if ($page == \'device\') {
        		require_once APP_PATH.\'plugins/device/admin/admin_device.php\';
           			$JAK_PROVED = 1;
           			$checkp = 1;
        	}", "../plugins/device/admin/template/devicenav.php", "device", "uninstall.php", "1.0", NOW())');

// now get the plugin id for futher use
$results = $jakdb->query('SELECT id FROM '.DB_PREFIX.'plugins WHERE name = "Device"');
$rows = $results->fetch_assoc();

if ($rows['id']) {

    // Insert php code
    $insertphpcode = 'if (isset($defaults[\'jak_device\'])) {
    	$insert .= \'device = \"\'.$defaults[\'jak_device\'].\'\",
    				devicepost = \"\'.$defaults[\'jak_devicepost\'].\'\",
    				devicepostapprove = \"\'.$defaults[\'jak_devicepostapprove\'].\'\",
    				devicepostdelete = \"\'.$defaults[\'jak_devicepostdelete\'].\'\",\';
    				}';


    $adminlang = 'if (file_exists(APP_PATH.\'plugins/device/admin/lang/\'.$site_language.\'.ini\')) {
        $tldev = parse_ini_file(APP_PATH.\'plugins/device/admin/lang/\'.$site_language.\'.ini\', true);
    } else {
        $tldev = parse_ini_file(APP_PATH.\'plugins/device/admin/lang/en.ini\', true);
    }';

    $sitelang = 'if (file_exists(APP_PATH.\'plugins/device/lang/\'.$site_language.\'.ini\')) {
        $tldev = parse_ini_file(APP_PATH.\'plugins/device/lang/\'.$site_language.\'.ini\', true);
    } else {
        $tldev = parse_ini_file(APP_PATH.\'plugins/device/lang/en.ini\', true);
    }';

    $sitephpsearch = '$device = new JAK_search($SearchInput);
            	$device->jakSettable(\'device\',\"\");
            	$device->jakAndor(\"OR\");
            	$device->jakFieldtitle(\"device_id\");
            	$device->jakFieldcut(\"\");
            	$device->jakFieldstosearch(array(\"device_id\", \"base_name\",  \"device_type\"));
            	$device->jakFieldstoselect(\"id, device_id, base_name, device_type\");

            	// Load the array into template
            	$JAK_SEARCH_RESULT_DEVICE = $device->set_result(JAK_PLUGIN_VAR_DEVICE, \'p\', $jkv[\"deviceurl\"]);';

    $sitephprss = 'if ($page1 == JAK_PLUGIN_VAR_DEVICE) {

    	if ($jkv[\"devicerss\"]) {
    		$sql = \'SELECT id, base_name as BaseName, device_id as DeviceID, device_type as DeviceType, time_stamp as TimeStamp FROM \'.DB_PREFIX.\'device
    				ORDER BY time DESC LIMIT \'.$jkv[\"devicerss\"];
    		$sURL = JAK_PLUGIN_VAR_DEVICE;
    		$sURL1 = \'p\';
    		$what = 1;
    		$seowhat = $jkv[\"deviceurl\"];

    		$JAK_RSS_DESCRIPTION = jak_cut_text($jkv[\"devicedesc\"], JAK_SHORTMSG, \'...\');

    	} else {
    		jak_redirect(BASE_URL);
    	}

    }';

    // Fulltext search query
    $sqlfull = '$jakdb->query(\'ALTER TABLE \'.DB_PREFIX.\'device ADD FULLTEXT(`device_id`, `base_name`)\');';
    $sqlfullremove = '$jakdb->query(\'ALTER TABLE \'.DB_PREFIX.\'device DROP INDEX `device_id`\');';

    $getdevice = '$JAK_GET_DEVICE = jak_get_page_info(DB_PREFIX.\'device\', \'\');';

    $jakdb->query('INSERT INTO '.DB_PREFIX.'pluginhooks (`id`, `hook_name`, `name`, `phpcode`, `product`, `active`, `exorder`, `pluginid`, `time`) VALUES
    				(NULL, "php_admin_usergroup", "Device Usergroup", "'.$insertphpcode.'", "device", 1, 4, "'.$rows['id'].'", NOW()),
    				(NULL, "php_admin_lang", "Device Admin Language", "'.$adminlang.'", "device", 1, 4, "'.$rows['id'].'", NOW()),
    				(NULL, "php_lang", "Device Site Language", "'.$sitelang.'", "device", 1, 4, "'.$rows['id'].'", NOW()),
    				(NULL, "php_search", "Device Search PHP", "'.$sitephpsearch.'", "device", 1, 8, "'.$rows['id'].'", NOW()),
    				(NULL, "php_rss", "Device RSS PHP", "'.$sitephprss.'", "device", 1, 1, "'.$rows['id'].'", NOW()),
    				(NULL, "tpl_between_head", "Device CSS", "plugins/device/template/cssheader.php", "device", 1, 4, "'.$rows['id'].'", NOW()),
    				(NULL, "tpl_admin_usergroup", "Device Usergroup New", "plugins/device/admin/template/usergroup_new.php", "device", 1, 4, "'.$rows['id'].'", NOW()),
    				(NULL, "tpl_admin_usergroup_edit", "Device Usergroup Edit", "plugins/device/admin/template/usergroup_edit.php", "device", 1, 4, "'.$rows['id'].'", NOW()),
    				(NULL, "php_admin_fulltext_add", "Device Full Text Search", "'.$sqlfull.'", "device", 1, 1, "'.$rows['id'].'", NOW()),
    				(NULL, "php_admin_fulltext_remove", "Device Remove Full Text Search", "'.$sqlfullremove.'", "device", 1, 1, "'.$rows['id'].'", NOW()),
    				(NULL, "php_admin_pages_news_info", "Device Pages/News Info", "'.$getdevice.'", "device", 1, 1, "'.$rows['id'].'", NOW()),
    				(NULL, "tpl_search", "Device Search", "plugins/device/template/search.php", "device", 1, 1, "'.$rows['id'].'", NOW())');

    // Insert tables into settings
    $jakdb->query('INSERT INTO '.DB_PREFIX.'setting (`varname`, `groupname`, `value`, `defaultvalue`, `optioncode`, `datatype`, `product`) VALUES
    				("devicetitle", "device", NULL, NULL, "input", "free", "device"),
    				("devicedesc", "device", NULL, NULL, "textarea", "free", "device"),
    				("devicedateformat", "device", "d.m.Y", "d.m.Y", "input", "free", "device"),
    				("devicetimeformat", "device", ": h:i A", ": h:i A", "input", "free", "device"),

    				("devicediscover", "device", 0, 0, "yesno", "boolean", "device"),
    				("deviceftcancreate", "device", 0, 0, "yesno", "boolean", "device"),
    				("deviceftcanedit", "device", 0, 0, "yesno", "boolean", "device"),
    				("deviceftcandelete", "device", 0, 0, "yesno", "boolean", "device"),
    				("devicelistpassword", "device", NULL, NULL, "input", "free", "device"),
    				("deviceauthkey", "device", NULL, NULL, "input", "free", "device"),

    				("devicepbxhost", "device", NULL, NULL, "input", "free", "device"),
    				("devicepbxusername", "device", NULL, NULL, "input", "free", "device"),
    				("devicepassword", "device", NULL, NULL, "input", "free", "device"),
    				("devicepbx_default_ext", "device", NULL, NULL, "input", "free", "device"),
    				("devicepbx_ext_pass", "device", NULL, NULL, "input", "free", "device"),
    				("devicealertemail", "device", 0, 0, "yesno", "boolean", "device"),
    				("deviceemail", "device", NULL, NULL, "input", "free", "device"),

    				("deviceemailhost", "device", NULL, NULL, "input", "free", "device"),
    				("deviceemailport", "device", NULL, NULL, "input", "free", "device"),
    				("deviceemailserverprefix", "device", NULL, NULL, "input", "free", "device"),
    				("deviceemailusername", "device", NULL, NULL, "input", "free", "device"),
    				("deviceemailpassword", "device", NULL, NULL, "input", "free", "device"),

    				("devicesmshost", "device", NULL, NULL, "input", "free", "device"),
    				("devicesmsnumber", "device", NULL, NULL, "input", "free", "device"),

    				("devicecamhost", "device", NULL, NULL, "input", "free", "device"),
                    ("devicecamport", "device", NULL, NULL, "input", "free", "device"),
    				("devicecamusername", "device", NULL, NULL, "input", "free", "device"),
    				("devicecampassword", "device", NULL, NULL, "input", "free", "device"),

					("devicecatchsinglefile", "device", 0, 0, "yesno", "boolean", "device"),

					("deviceurl", "device", 0, 0, "yesno", "boolean", "device"),
    				("devicemaxpost", "device", 2000, 2000, "input", "boolean", "device"),
    				("devicepagemid", "device", 5, 5, "yesno", "number", "device"),
    				("devicepageitem", "device", 24, 24, "yesno", "number", "device"),

    				("devicerss", "device", 5, 5, "number", "select", "device"),
    				("device_css", "device", "", "", "textarea", "free", "device"),
    				("device_javascript", "device", "", "", "textarea", "free", "device")
    				');

    // Insert into usergroup
    $jakdb->query('ALTER TABLE '.DB_PREFIX.'usergroup
    				ADD `device` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `advsearch`,
    				ADD `devicepost` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `device`,
    				ADD `devicepostdelete` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `devicepost`,
    				ADD `devicepostapprove` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `devicepostdelete`');

    // Pages/News alter Table
    $jakdb->query('ALTER TABLE '.DB_PREFIX.'pagesgrid ADD deviceid INT(11) UNSIGNED NOT NULL DEFAULT 0 AFTER newsid');

    // Insert Category
    $jakdb->query('INSERT INTO '.DB_PREFIX.'categories (`id`, `name`, `varname`, `catimg`, `showmenu`, `showfooter`, `catorder`, `catparent`, `pageid`, `activeplugin`, `pluginid`) VALUES
    				(NULL, "Device", "device", NULL, 1, 0, 5, 0, 0, 1, "'.$rows['id'].'")');

    $jakdb->query('CREATE TABLE IF NOT EXISTS '.DB_PREFIX.'device (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `dev_css` text,
      `dev_javascript` text,
      `sidebar` smallint(1) UNSIGNED NULL DEFAULT 1,
      `password` char(64) DEFAULT NULL,
      `base_name` varchar(64) DEFAULT NULL,
      `device_id` varchar(64) DEFAULT NULL,
      `device_type` varchar(64) DEFAULT NULL,
      `event_type` varchar(64) DEFAULT NULL,
      `antenna_int` varchar(64) DEFAULT NULL,
      `pendant_rx_level` varchar(64) DEFAULT NULL,
      `low_battery` varchar(32) DEFAULT NULL,
      `time_stamp` varchar(64) DEFAULT NULL,
	  `last_prompted` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      `prtg_url` varchar(255) DEFAULT NULL,
      `time` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');

    // Create folder in _files for files
    if (!file_exists(APP_PATH.'_files/catch')) {
        mkdir(APP_PATH.'_files/catch', 0775, true);
        mkdir(APP_PATH.'_files/catch/single_files', 0775, true);
    }


    // Full text search is activated we do so for the device table as well
    if ($jkv["fulltextsearch"]) {
    	$jakdb->query('ALTER TABLE '.DB_PREFIX.'device ADD FULLTEXT(`device_id`)');
    }

    $succesfully = 1;

    ?>
    <div class="alert alert-success">Plugin installed successfully</div>
    <?php
    }
    else
    {
        $result = $jakdb->query('DELETE FROM '.DB_PREFIX.'plugins WHERE name = "Device"');
        ?>
        <div class="alert alert-danger">Plugin installation failed.</div>
        <form name="company" method="post" action="uninstall.php" enctype="multipart/form-data">
            <button type="submit" name="redirect" class="btn btn-danger pull-right">Uninstall Plugin</button>
        </form>
        <?php
    }
} ?>

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