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
	<title>Installation - Analytic Plugin</title>
	<meta charset="utf-8">
	<meta name="author" content="claricom (http://www.claricom.ca)" />
	<link rel="stylesheet" href="../../css/stylesheet.css" type="text/css" media="screen" />
</head>
<body>

<div class="container">
<div class="row">
<div class="col-md-12">
<h3>Installation - Analytic Plugin by Claricom.</h3>

<?php 
	if (isset($_POST['install']))
	{
		$jakdb->query('INSERT INTO '.DB_PREFIX.'plugins (`id`, `name`, `description`, `active`, `access`, `pluginorder`, `pluginpath`, `phpcode`, `phpcodeadmin`, `sidenavhtml`, `usergroup`, `uninstallfile`, `pluginversion`, `time`) 
			VALUES
			(NULL, "Analytic", "Run your own Analytic.", 1, '.JAK_USERID.', 4, "analytic", "require_once APP_PATH.\'plugins/Analytic/analytic.php\';",
				"if ($page == \'analytic\') {
        			require_once APP_PATH.\'plugins/analytic/admin/analytic_admin.php\';
           			$JAK_PROVED = 1;
           			$checkp = 1;
        		}",
        	"../plugins/analytic/admin/template/analytic_nav.php", "analytic", "uninstall.php", "1.1", NOW())');

		// now get the plugin id for futher use
		$results = $jakdb->query('SELECT id FROM '.DB_PREFIX.'plugins WHERE name = "Analytic"');
		$rows = $results->fetch_assoc();

		if ($rows['id'])
		{
			// Insert Category
			$jakdb->query('INSERT INTO '.DB_PREFIX.'categories (`id`, `name`, `varname`, `catimg`, `showmenu`, `showfooter`, `catorder`, `catparent`, `pageid`, `activeplugin`, `pluginid`) VALUES
				(NULL, "Analytic", "analytic", NULL, 1, 0, 5, 0, 0, 1, "' . $rows['id'] . '")');

			// Insert php code
    		$insertphpcode = 'if (isset($defaults[\'jak_analytic\'])) {
    				$insert .= \'analytic = \"\'.$defaults[\'jak_analytic\'].\'\",
    					analyticpost = \"\'.$defaults[\'jak_analyticpost\'].\'\",\';
    				}';
			
		   	$adminlang = 'if (file_exists(APP_PATH.\'plugins/analytic/admin/lang/\'.$site_language.\'.ini\')) {
		        	$tlanalytic = parse_ini_file(APP_PATH.\'plugins/analytic/admin/lang/\'.$site_language.\'.ini\', true);
		    	} else {
		        	$tlanalytic = parse_ini_file(APP_PATH.\'plugins/analytic/admin/lang/en.ini\', true);
		    	}';

		    $sitelang = 'if (file_exists(APP_PATH.\'plugins/analytic/lang/\'.$site_language.\'.ini\')) {
		        	$tlanalytic = parse_ini_file(APP_PATH.\'plugins/analytic/lang/\'.$site_language.\'.ini\', true);
		    	} else {
		        	$tlanalytic = parse_ini_file(APP_PATH.\'plugins/analytic/lang/en.ini\', true);
		    	}';
		
			$jakdb->query('INSERT INTO '.DB_PREFIX.'pluginhooks (`id`, `hook_name`, `name`, `phpcode`, `product`, `active`, `exorder`, `pluginid`, `time`) VALUES
	    				(NULL, "php_admin_usergroup", "Analytic Usergroup", "'.$insertphpcode.'", "analytic", 1, 4, "'.$rows['id'].'", NOW()),
	    				(NULL, "php_admin_lang", "Analytic Admin Language", "'.$adminlang.'", "analytic", 1, 4, "'.$rows['id'].'", NOW()),
	    				(NULL, "php_lang", "Analytic Site Language", "'.$sitelang.'", "analytic", 1, 4, "'.$rows['id'].'", NOW()),
	    				(NULL, "tpl_admin_usergroup", "Analytic Usergroup New", "plugins/analytic/admin/template/usergroup_new.php", "analytic", 1, 4, "'.$rows['id'].'", NOW()),
    					(NULL, "tpl_admin_usergroup_edit", "Analytic Usergroup Edit", "plugins/analytic/admin/template/usergroup_edit.php", "analytic", 1, 4, "'.$rows['id'].'", NOW()),
	    				(NULL, "tpl_between_head", "Analytic CSS", "plugins/analytic/template/cssheader.php", "analytic", 1, 4, "'.$rows['id'].'", NOW()),
	    				(NULL, "tpl_search", "Analytic Search", "plugins/analytic/template/search.php", "analytic", 1, 1, "'.$rows['id'].'", NOW())'
	    		);

			// Insert into usergroup
			$jakdb->query('ALTER TABLE '.DB_PREFIX.'usergroup
				ADD `analytic` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `devicepostdelete`,
				ADD `analyticpost` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `analytic`');

		    // Insert tables into settings
		    $jakdb->query('INSERT INTO '.DB_PREFIX.'setting (`varname`, `groupname`, `value`, `defaultvalue`, `optioncode`, `datatype`, `product`) VALUES
		    		("analytic_title", "analytic", NULL, NULL, "input", "free", "analytic"),
		    		("analytic_desc", "analytic", NULL, NULL, "textarea", "free", "analytic"),
		    		("analytic_dateformat", "analytic", "d.m.Y", "d.m.Y", "input", "free", "analytic"),
		    		("analytic_timeformat", "analytic", ": h:i A", ": h:i A", "input", "free", "analytic"),

		    		("analytic_pbxhost", "analytic", NULL, NULL, "input", "free", "analytic"),
		    		("analytic_pbxport", "analytic", NULL, NULL, "input", "free", "analytic"),
		    		("analytic_pbxusername", "analytic", NULL, NULL, "input", "free", "analytic"),
		    		("analytic_pbxpassword", "analytic", NULL, NULL, "input", "free", "analytic"),
		    		("analytic_frontpassword", "analytic", NULL, NULL, "input", "free", "analytic")
		    ');

		    $jakdb->query('CREATE TABLE IF NOT EXISTS '.DB_PREFIX.'analytic_account (
		    	`id` int(10) NOT NULL AUTO_INCREMENT,
		    	`domain` varchar(64) DEFAULT NULL,
		    	`account` varchar(64) DEFAULT NULL,
		    	`name` varchar(64) DEFAULT NULL,
		    	`description` TEXT NULL,
		    	`type` varchar(64) DEFAULT NULL,
		    	`created_date` datetime NULL DEFAULT \'0000-00-00 00:00:00\',
		    	`updated_date` datetime NULL DEFAULT \'0000-00-00 00:00:00\',
		    	PRIMARY KEY (`id`)
		    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');

		    // Device Alert record
		    $jakdb->query('CREATE TABLE IF NOT EXISTS '.DB_PREFIX.'alarm_trigger (
		        `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		        `base_name` VARCHAR(64) NOT NULL,
		        `device_id` VARCHAR(64) NOT NULL,
		        `starttime` DATETIME NOT NULL,
		        `endtime` DATETIME NOT NULL DEFAULT "0000-00-00 00:00:00",
		        PRIMARY KEY (`id`)
		    )ENGINE=MyISAM DEFAULT CHARSET=utf8 ');

		    // Alarm insert trigger
	    	$jakdb->query('CREATE TRIGGER '.DB_PREFIX.'device_after_insert AFTER INSERT ON '.DB_PREFIX.'device 
	        FOR EACH ROW BEGIN
	            IF NEW.event_type = "Alarm" THEN
	                INSERT INTO cms_alarm_trigger (base_name, device_id, starttime) 
	                VALUES (NEW.base_name, NEW.device_id, CURRENT_TIMESTAMP);
	            END IF;
	        END');

	        // Alarm update trigger
		    $jakdb->query('CREATE TRIGGER '.DB_PREFIX.'device_after_update AFTER UPDATE ON '.DB_PREFIX.'device
		        FOR EACH ROW BEGIN
		            IF NEW.event_type = "Alarm" THEN
		                INSERT INTO cms_alarm_trigger (base_name, device_id, starttime) 
		                VALUES (OLD.base_name, OLD.device_id, CURRENT_TIMESTAMP);         
		            END IF;

		            IF NEW.event_type = "Normal" THEN
		                UPDATE cms_alarm_trigger
		                    SET endtime=CURRENT_TIMESTAMP
		                WHERE base_name=OLD.base_name 
		                    AND device_id=OLD.device_id
		                AND endtime="0000-00-00 00:00:00";
		            END IF;
		    	END
		    ');

		    // Delete trigger
		    $jakdb->query(' CREATE TRIGGER '.DB_PREFIX.'device_after_delete AFTER DELETE ON '.DB_PREFIX.'device
		    	FOR EACH ROW BEGIN
					DELETE FROM cms_alarm_trigger 
					WHERE base_name=OLD.base_name
					AND device_id=OLD.device_id;
				END
		    ');

		    $succesfully = 1;

		    ?>
		    <div class="alert alert-success">Plugin installed successfully</div>
		    <?php
	    }
	    else
	    {
	        $result = $jakdb->query('DELETE FROM '.DB_PREFIX.'plugins WHERE name = "Analytic"');
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