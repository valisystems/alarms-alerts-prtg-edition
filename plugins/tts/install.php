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
	<title>Installation - TTS Plugin</title>
	<meta charset="utf-8">
	<meta name="author" content="claricom (http://www.claricom.ca)" />
	<link rel="stylesheet" href="../../css/stylesheet.css" type="text/css" media="screen" />
</head>
<body>

<div class="container">
<div class="row">
<div class="col-md-12">
<h3>Installation - TTS Plugin by Claricom.</h3>

<?php 
	if (isset($_POST['install']))
	{

		$jakdb->query('INSERT INTO '.DB_PREFIX.'plugins (`id`, `name`, `description`, `active`, `access`, `pluginorder`, `pluginpath`, `phpcode`, `phpcodeadmin`, `sidenavhtml`, `usergroup`, `uninstallfile`, `pluginversion`, `time`) 
			VALUES
			(NULL, "TTS", "Run your own tts.", 1, '.JAK_USERID.', 4, "tts", "require_once APP_PATH.\'plugins/tts/tts.php\';",
				"if ($page == \'tts\') {
        			require_once APP_PATH.\'plugins/tts/admin/admin_tts.php\';
           			$JAK_PROVED = 1;
           			$checkp = 1;
        		}",
        	"../plugins/tts/admin/template/ttsnav.php", "tts", "uninstall.php", "1.0", NOW())');

		// now get the plugin id for futher use
		$results = $jakdb->query('SELECT id FROM '.DB_PREFIX.'plugins WHERE name = "TTS"');
		$rows = $results->fetch_assoc();

		if ($rows['id'])
		{
			// Insert php code
		    $insertphpcode = 'if (isset($defaults[\'jak_tts\'])) {
		    	$insert .= \'tts = \"\'.$defaults[\'jak_tts\'].\'\",
		    				ttspost = \"\'.$defaults[\'jak_ttspost\'].\'\",
		    				ttspostapprove = \"\'.$defaults[\'jak_ttspostapprove\'].\'\",
		    				ttspostdelete = \"\'.$defaults[\'jak_ttspostdelete\'].\'\",\';
		    				}';

		   	$adminlang = 'if (file_exists(APP_PATH.\'plugins/tts/admin/lang/\'.$site_language.\'.ini\')) {
		        $tltts = parse_ini_file(APP_PATH.\'plugins/tts/admin/lang/\'.$site_language.\'.ini\', true);
		    } else {
		        $tltts = parse_ini_file(APP_PATH.\'plugins/tts/admin/lang/en.ini\', true);
		    }';

		    $sitelang = 'if (file_exists(APP_PATH.\'plugins/tts/lang/\'.$site_language.\'.ini\')) {
		        $tltts = parse_ini_file(APP_PATH.\'plugins/tts/lang/\'.$site_language.\'.ini\', true);
		    } else {
		        $tltts = parse_ini_file(APP_PATH.\'plugins/tts/lang/en.ini\', true);
		    }';
		
			$jakdb->query('INSERT INTO '.DB_PREFIX.'pluginhooks (`id`, `hook_name`, `name`, `phpcode`, `product`, `active`, `exorder`, `pluginid`, `time`) VALUES
	    				(NULL, "php_admin_usergroup", "TTS Usergroup", "'.$insertphpcode.'", "tts", 1, 4, "'.$rows['id'].'", NOW()),
	    				(NULL, "php_admin_lang", "TTS Admin Language", "'.$adminlang.'", "tts", 1, 4, "'.$rows['id'].'", NOW()),
	    				(NULL, "php_lang", "TTS Site Language", "'.$sitelang.'", "tts", 1, 4, "'.$rows['id'].'", NOW()),
	    				(NULL, "tpl_between_head", "TTS CSS", "plugins/tts/template/cssheader.php", "tts", 1, 4, "'.$rows['id'].'", NOW()),
	    				(NULL, "tpl_admin_usergroup", "TTS Usergroup New", "plugins/tts/admin/template/usergroup_new.php", "tts", 1, 4, "'.$rows['id'].'", NOW()),
	    				(NULL, "tpl_admin_usergroup_edit", "TTS Usergroup Edit", "plugins/tts/admin/template/usergroup_edit.php", "tts", 1, 4, "'.$rows['id'].'", NOW()),
	    				(NULL, "tpl_search", "TTS Search", "plugins/tts/template/search.php", "tts", 1, 1, "'.$rows['id'].'", NOW())'
	    		);



		    // Insert tables into settings
		    $jakdb->query('INSERT INTO '.DB_PREFIX.'setting (`varname`, `groupname`, `value`, `defaultvalue`, `optioncode`, `datatype`, `product`) VALUES
		    				("ttstitle", "tts", NULL, NULL, "input", "free", "tts"),
		    				("ttsdesc", "tts", NULL, NULL, "textarea", "free", "tts"),
		    				("ttsdateformat", "tts", "d.m.Y", "d.m.Y", "input", "free", "tts"),
		    				("ttstimeformat", "tts", ": h:i A", ": h:i A", "input", "free", "tts"),

		    				("ttscancreate", "tts", 0, 0, "yesno", "boolean", "tts"),
		    				("ttscanedit", "tts", 0, 0, "yesno", "boolean", "tts"),
		    				("ttscandelete", "tts", 0, 0, "yesno", "boolean", "tts"),

		    				("ttsftphost", "tts", NULL, NULL, "input", "free", "tts"),
		    				("ttsftpport", "tts", NULL, NULL, "input", "free", "tts"),
		    				("ttsftpusername", "tts", NULL, NULL, "input", "free", "tts"),
		    				("ttsftppassword", "tts", NULL, NULL, "input", "free", "tts"),
		    				("ttsftpfldname", "tts", NULL, NULL, "input", "free", "tts")

		    			');

		    // Insert into usergroup
		    $jakdb->query('ALTER TABLE '.DB_PREFIX.'usergroup
		    				ADD `tts` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `advsearch`,
		    				ADD `ttspost` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `tts`,
		    				ADD `ttspostdelete` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `ttspost`,
		    				ADD `ttspostapprove` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `ttspostdelete`');

		    $jakdb->query('CREATE TABLE IF NOT EXISTS '.DB_PREFIX.'tts (
		      `id` int(11) NOT NULL AUTO_INCREMENT,
		      `user_id` char(64) DEFAULT NULL,
		      `csv_file` varchar(64) DEFAULT NULL,
		      `txt_folder` varchar(64) DEFAULT NULL,
		      `wav_folder` varchar(64) DEFAULT NULL,
		      `time` datetime NULL DEFAULT \'0000-00-00 00:00:00\',
		      PRIMARY KEY (`id`)
		    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');

		    // Create folder in _files for files
		    if (!file_exists(APP_PATH.'_files/text_files')) {
		        mkdir(APP_PATH.'_files/text_files', 0775, true);
		    }
		    $succesfully = 1;

		    ?>
		    <div class="alert alert-success">Plugin installed successfully</div>
		    <?php
	    }
	    else
	    {
	        $result = $jakdb->query('DELETE FROM '.DB_PREFIX.'plugins WHERE name = "TTS"');
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