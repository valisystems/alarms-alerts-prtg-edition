<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Include the config file...
if (!file_exists('../../config.php')) die('[uninstall.php] config.php not found');
require_once '../../config.php';

// If not logged in...
if (!JAK_USERID) die('You cannot access this file directly.');

// If not an admin...
if (!$jakuser->jakAdminaccess($jakuser->getVar("usergroupid"))) die('You cannot access this file directly.');

// Set successfully to zero
$succesfully = 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Uninstallation - Blog Plugin</title>
	<meta charset="utf-8">
	<meta name="author" content="CLARICOM (http://www.claricom.ca)" />
	<link rel="stylesheet" href="../../css/stylesheet.css" type="text/css" media="screen" />
</head>
<body>

<div class="container">
<div class="row">
<div class="col-md-12">
<h3>Uninstallation - Blog Plugin</h3>

<!-- Let's do the uninstall -->
<?php if (isset($_POST['uninstall'])) {

// now get the plugin id for futher use
$results = $jakdb->query('SELECT id FROM '.DB_PREFIX.'plugins WHERE name = "Blog"');
$rows = $results->fetch_assoc();

if ($rows) {
 
$jakdb->query('DELETE FROM '.DB_PREFIX.'plugins WHERE name = "Blog"');

$jakdb->query('DELETE FROM '.DB_PREFIX.'pagesgrid WHERE plugin = "'.smartsql($rows['id']).'"');

$jakdb->query('DELETE FROM '.DB_PREFIX.'pagesgrid WHERE pluginid = "'.smartsql($rows['id']).'"');

$jakdb->query('DELETE FROM '.DB_PREFIX.'pluginhooks WHERE product = "blog"');

$jakdb->query('DELETE FROM '.DB_PREFIX.'setting WHERE product = "blog"');

$jakdb->query('ALTER TABLE '.DB_PREFIX.'usergroup DROP `blog`, DROP `blogpost`, DROP `blogpostdelete`, DROP `blogpostapprove`, DROP `blograte`, DROP `blogmoderate`');

$jakdb->query('DROP TABLE '.DB_PREFIX.'blog, '.DB_PREFIX.'blogcategories, '.DB_PREFIX.'blogcomments');

$jakdb->query('DELETE FROM '.DB_PREFIX.'categories WHERE pluginid = "'.smartsql($rows['id']));

$jakdb->query('ALTER TABLE '.DB_PREFIX.'pages DROP showblog');
$jakdb->query('ALTER TABLE '.DB_PREFIX.'news DROP showblog');
$jakdb->query('ALTER TABLE '.DB_PREFIX.'pagesgrid DROP blogid');

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