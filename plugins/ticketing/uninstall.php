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
	<title>Uninstallation - Support Ticket Plugin</title>
	<meta charset="utf-8">
	<meta name="author" content="JAKWEB (http://www.jakweb.ch)" />
	<link rel="stylesheet" href="../../css/stylesheet.css" type="text/css" media="screen" />
</head>
<body>

<div class="container">
<div class="row">
<div class="col-md-12">
<h3>Uninstallation - Support Ticket Plugin</h3>

<!-- Let's do the uninstall -->
<?php if (isset($_POST['uninstall'])) {

// now get the plugin id for futher use
$results = $jakdb->query('SELECT id FROM '.DB_PREFIX.'plugins WHERE name = "Ticketing"');
$rows = $results->fetch_assoc();

if ($rows) {
 
$jakdb->query('DELETE FROM '.DB_PREFIX.'plugins WHERE name = "Ticketing"');

$jakdb->query('DELETE FROM '.DB_PREFIX.'pagesgrid WHERE plugin = "'.smartsql($rows['id']).'"');

$jakdb->query('DELETE FROM '.DB_PREFIX.'pagesgrid WHERE pluginid = "'.smartsql($rows['id']).'"');

$jakdb->query('DELETE FROM '.DB_PREFIX.'pluginhooks WHERE product = "ticketing"');

$jakdb->query('DELETE FROM '.DB_PREFIX.'setting WHERE product = "ticketing"');

$jakdb->query('ALTER TABLE '.DB_PREFIX.'usergroup DROP `ticket`, DROP `ticketpost`, DROP `ticketpostdelete`, DROP `ticketpostapprove`, DROP `ticketrate`, DROP `ticketmoderate`');

$jakdb->query('DROP TABLE '.DB_PREFIX.'tickets, '.DB_PREFIX.'ticketcategories, '.DB_PREFIX.'ticketcomments, '.DB_PREFIX.'ticketoptions');

$jakdb->query('DELETE FROM '.DB_PREFIX.'categories WHERE pluginid = '.smartsql($rows['id']));

$jakdb->query('ALTER TABLE '.DB_PREFIX.'pages DROP showticketing');
$jakdb->query('ALTER TABLE '.DB_PREFIX.'news DROP showticketing');
$jakdb->query('ALTER TABLE '.DB_PREFIX.'pagesgrid DROP ticketid');

// Now delete all tags
$result = $jakdb->query('SELECT tag FROM '.DB_PREFIX.'tags WHERE pluginid = "'.smartsql($rows['id']).'"');
    while ($row = $result->fetch_assoc()) {
	    $result1 = $jakdb->query('SELECT count FROM '.DB_PREFIX.'tagcloud WHERE tag = "'.smartsql($row['tag']).'" LIMIT 1');
	    $count = $result1->fetch_assoc();
       
    if ($count['count'] <= '1') {
		$jakdb->query('DELETE FROM tagcloud WHERE tag = "'.smartsql($row['tag']).'"');
	} else {
		$jakdb->query('UPDATE tagcloud SET count = count - 1 WHERE tag = "'.smartsql($row['tag']).'"');

	}
	}
            
       $jakdb->query('DELETE FROM '.DB_PREFIX.'tags WHERE pluginid = "'.smartsql($rows['id']).'"');
       
}

$succesfully = 1;

?>

<div class="alert alert-success">Plugin uninstalled successfully</div>

<?php } if (!$succesfully) { ?>
<form name="company" method="post" action="uninstall.php" enctype="multipart/form-data">
<button type="submit" name="uninstall" class="btn btn-danger btn-block">Uninstall Plugin</button>
</form>
<?php } ?>

</div>
</div>


</div><!-- #container -->
</body>
</html>