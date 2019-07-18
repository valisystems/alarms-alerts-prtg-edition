<?php

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
	<title>Installation - CDR Plugin</title>
	<meta charset="utf-8">
	<meta name="author" content="claricom (http://www.claricom.ca)" />
	<link rel="stylesheet" href="../../css/stylesheet.css" type="text/css" media="screen" />
</head>
<body>

<div class="container">
<div class="row">
<div class="col-md-12">
<h3>Installation - CDR Plugin by Claricom.</h3>

<?php 
	if (isset($_POST['install']))
	{

		$jakdb->query('INSERT INTO '.DB_PREFIX.'plugins (`id`, `name`, `description`, `active`, `access`, `pluginorder`, `pluginpath`, `phpcode`, `phpcodeadmin`, `sidenavhtml`, `usergroup`, `uninstallfile`, `pluginversion`, `time`) 
			VALUES
			(NULL, "CDR", "Run your own cdr.", 1, '.JAK_USERID.', 4, "cdr", "require_once APP_PATH.\'plugins/cdr/cdr.php\';",
				"if ($page == \'cdr\') {
        			require_once APP_PATH.\'plugins/cdr/admin/admin_cdr.php\';
           			$JAK_PROVED = 1;
           			$checkp = 1;
        		}",
        	"../plugins/cdr/admin/template/cdrnav.php", "cdr", "uninstall.php", "1.0", NOW())');

		// now get the plugin id for futher use
		$results = $jakdb->query('SELECT id FROM '.DB_PREFIX.'plugins WHERE name = "CDR"');
		$rows = $results->fetch_assoc();

		if ($rows['id'])
		{
			// Insert php code
		    $insertphpcode = 'if (isset($defaults[\'jak_cdr\'])) {
		    	$insert .= \'cdr = \"\'.$defaults[\'jak_cdr\'].\'\",
		    				cdrpost = \"\'.$defaults[\'jak_cdrpost\'].\'\",
		    				cdrpostapprove = \"\'.$defaults[\'jak_cdrpostapprove\'].\'\",
		    				cdrpostdelete = \"\'.$defaults[\'jak_cdrpostdelete\'].\'\",\';
		    				}';

		   	$adminlang = 'if (file_exists(APP_PATH.\'plugins/cdr/admin/lang/\'.$site_language.\'.ini\')) {
		        $tlcdr = parse_ini_file(APP_PATH.\'plugins/cdr/admin/lang/\'.$site_language.\'.ini\', true);
		    } else {
		        $tlcdr = parse_ini_file(APP_PATH.\'plugins/cdr/admin/lang/en.ini\', true);
		    }';

		    $sitelang = 'if (file_exists(APP_PATH.\'plugins/cdr/lang/\'.$site_language.\'.ini\')) {
		        $tlcdr = parse_ini_file(APP_PATH.\'plugins/cdr/lang/\'.$site_language.\'.ini\', true);
		    } else {
		        $tlcdr = parse_ini_file(APP_PATH.\'plugins/cdr/lang/en.ini\', true);
		    }';
		
			$jakdb->query('INSERT INTO '.DB_PREFIX.'pluginhooks (`id`, `hook_name`, `name`, `phpcode`, `product`, `active`, `exorder`, `pluginid`, `time`) VALUES
	    				(NULL, "php_admin_usergroup", "CDR Usergroup", "'.$insertphpcode.'", "cdr", 1, 4, "'.$rows['id'].'", NOW()),
	    				(NULL, "php_admin_lang", "CDR Admin Language", "'.$adminlang.'", "cdr", 1, 4, "'.$rows['id'].'", NOW()),
	    				(NULL, "php_lang", "CDR Site Language", "'.$sitelang.'", "cdr", 1, 4, "'.$rows['id'].'", NOW()),
	    				(NULL, "tpl_between_head", "CDR CSS", "plugins/cdr/template/cssheader.php", "cdr", 1, 4, "'.$rows['id'].'", NOW()),
	    				(NULL, "tpl_admin_usergroup", "CDR Usergroup New", "plugins/cdr/admin/template/usergroup_new.php", "cdr", 1, 4, "'.$rows['id'].'", NOW()),
	    				(NULL, "tpl_admin_usergroup_edit", "CDR Usergroup Edit", "plugins/cdr/admin/template/usergroup_edit.php", "cdr", 1, 4, "'.$rows['id'].'", NOW()),
	    				(NULL, "tpl_search", "CDR Search", "plugins/cdr/template/search.php", "cdr", 1, 1, "'.$rows['id'].'", NOW())'
	    		);



		    // Insert tables into settings
		    $jakdb->query('INSERT INTO '.DB_PREFIX.'setting (`varname`, `groupname`, `value`, `defaultvalue`, `optioncode`, `datatype`, `product`) VALUES
		    				("cdrtitle", "cdr", NULL, NULL, "input", "free", "cdr"),
		    				("cdrdesc", "cdr", NULL, NULL, "textarea", "free", "cdr"),
		    				("cdrdateformat", "cdr", "d.m.Y", "d.m.Y", "input", "free", "cdr"),
		    				("cdrtimeformat", "cdr", ": h:i A", ": h:i A", "input", "free", "cdr"),

		    				("cdrcancreate", "cdr", 0, 0, "yesno", "boolean", "cdr"),
		    				("cdrcanedit", "cdr", 0, 0, "yesno", "boolean", "cdr"),
		    				("cdrcandelete", "cdr", 0, 0, "yesno", "boolean", "cdr"),

		    				("cdrftphost", "cdr", NULL, NULL, "input", "free", "cdr"),
		    				("cdrftpport", "cdr", NULL, NULL, "input", "free", "cdr"),
		    				("cdrftpusername", "cdr", NULL, NULL, "input", "free", "cdr"),
		    				("cdrftppassword", "cdr", NULL, NULL, "input", "free", "cdr")

		    			');

		    // Insert into usergroup
		    $jakdb->query('ALTER TABLE '.DB_PREFIX.'usergroup
		    				ADD `cdr` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `advsearch`,
		    				ADD `cdrpost` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `cdr`,
		    				ADD `cdrpostdelete` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `cdrpost`,
		    				ADD `cdrpostapprove` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `cdrpostdelete`');

		    // Insert Category
    		$jakdb->query('INSERT INTO '.DB_PREFIX.'categories (`id`, `name`, `varname`, `catimg`, `showmenu`, `showfooter`, `catorder`, `catparent`, `pageid`, `activeplugin`, `pluginid`) VALUES
    				(NULL, "CDR", "cdr", NULL, 1, 0, 5, 0, 0, 1, "'.$rows['id'].'")');

		    $jakdb->query('CREATE TABLE IF NOT EXISTS '.DB_PREFIX.'cdr (
					`id` INT(11) NOT NULL AUTO_INCREMENT,
					`timestart` DATETIME NULL DEFAULT NULL,
					`timeconnected` VARCHAR(50) NULL DEFAULT NULL,
					`timeend` DATETIME NULL DEFAULT NULL,
					`domain` VARCHAR(255) NULL DEFAULT NULL,
					`durationhhmmss` VARCHAR(10) NULL DEFAULT NULL,
					`duration` INT(11) NULL DEFAULT NULL,
					`type` VARCHAR(10) NULL DEFAULT NULL,
					`cost` VARCHAR(10) NULL DEFAULT NULL,
					`direction` VARCHAR(4) NULL DEFAULT NULL,
					`ltime` DATETIME NULL DEFAULT NULL,
					`remoteparty` VARCHAR(255) NULL DEFAULT NULL,
					`localparty` VARCHAR(255) NULL DEFAULT NULL,
					`cid_from` VARCHAR(255) NULL DEFAULT NULL,
					`cid_to` VARCHAR(255) NULL DEFAULT NULL,
					`extension` VARCHAR(255) NULL DEFAULT NULL,
					`trunkname` VARCHAR(255) NULL DEFAULT NULL,
					`trunkid` INT(11) NULL DEFAULT NULL,
					`cmc` VARCHAR(20) NULL DEFAULT NULL,
					`recordlocation` VARCHAR(255) NULL DEFAULT NULL,
					`primarycallid` VARCHAR(255) NULL DEFAULT NULL,
					`idleduration` INT(11) NULL DEFAULT NULL,
					`ringduration` INT(11) NULL DEFAULT NULL,
					`holdduration` INT(11) NULL DEFAULT NULL,
					`ivrduration` INT(11) NULL DEFAULT NULL,
					`accountnumber` VARCHAR(20) NULL DEFAULT NULL,
					`ipadr` VARCHAR(40) NULL DEFAULT NULL,
					`sys` VARCHAR(16) NULL DEFAULT NULL,
					`callid` VARCHAR(255) NULL DEFAULT NULL,
					`intl_call` VARCHAR(64) NULL DEFAULT NULL,
					PRIMARY KEY (`id`)
		    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');

		    $succesfully = 1;

		    ?>
		    <div class="alert alert-success">Plugin installed successfully</div>
		    <?php
	    }
	    else
	    {
	        $result = $jakdb->query('DELETE FROM '.DB_PREFIX.'plugins WHERE name = "CDR"');
	        ?>
	        <div class="alert alert-danger">Plugin installation failed.</div>
	        <form name="company" method="post" action="uninstall.php" enctype="multipart/form-data">
	            <button type="submit" name="redirect" class="btn btn-danger pull-right">Uninstall Plugin</button>
	        </form>
	        <?php
	    }

}
if (!$succesfully)
	{ ?>
		<form name="company" method="post" action="install.php" enctype="multipart/form-data">
		<button type="submit" name="install" class="btn btn-primary btn-block">Install Plugin</button>
		</form>
		<?php 
	}
?>

</div>
</div>

</div><!-- #container -->
</body>
</html>