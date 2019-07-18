<?php

/*===============================================*\
|| ############################################# ||
|| # claricom.ca                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 Claricom All Rights Reserved # ||
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
	<title>Uninstallation - Device Plugin</title>
	<meta charset="utf-8">
	<meta name="author" content="Claricom (http://www.claricom.ca)" />
	<link rel="stylesheet" href="../../css/stylesheet.css" type="text/css" media="screen" />
</head>
<body>

    <div class="container">
        <div class="row">
        	<div class="col-md-12">
            <h3>Uninstallation - Device Plugin</h3>

            <!-- Let's do the uninstall -->
            <?php if (isset($_POST['uninstall']))
            {
                // now get the plugin id for futher use
                $results = $jakdb->query('SELECT id FROM '.DB_PREFIX.'plugins WHERE name = "Device"');
                $rows = $results->fetch_assoc();

                if ($rows)
                {
                    $jakdb->query('DELETE FROM '.DB_PREFIX.'plugins WHERE name = "Device"');

                    $jakdb->query('DELETE FROM '.DB_PREFIX.'pagesgrid WHERE plugin = "'.smartsql($rows['id']).'"');

                    $jakdb->query('DELETE FROM '.DB_PREFIX.'pagesgrid WHERE pluginid = "'.smartsql($rows['id']).'"');

                    $jakdb->query('DELETE FROM '.DB_PREFIX.'pluginhooks WHERE product = "device"');

                    $jakdb->query('DELETE FROM '.DB_PREFIX.'setting WHERE product = "device"');

                    $jakdb->query('ALTER TABLE '.DB_PREFIX.'usergroup
                    				DROP `device`, DROP `devicepost`, DROP `devicepostdelete`,
                    				DROP `devicepostapprove`');

                    $jakdb->query('DROP TABLE '.DB_PREFIX.'device');

                    $jakdb->query('DELETE FROM '.DB_PREFIX.'categories WHERE pluginid = '.smartsql($rows['id']));

                    $jakdb->query('ALTER TABLE '.DB_PREFIX.'pagesgrid DROP deviceid');

                    // Delete sensors and catch folder
                    if (file_exists('_files/catch')) {
                        rmdir('_files/catch');
                    }

                }
                $succesfully = 1;
                ?>
                <div class="alert alert-success">Plugin uninstalled successfully</div>
                <?php
            }
            if (!$succesfully)
            {
                ?>
                <form name="company" method="post" action="uninstall.php" enctype="multipart/form-data">
                    <button type="submit" name="uninstall" class="btn btn-danger btn-block">Uninstall Plugin</button>
                </form>
                <?php
            } ?>

        	</div>
    	</div>

    </div><!-- #container -->
</body>
</html>