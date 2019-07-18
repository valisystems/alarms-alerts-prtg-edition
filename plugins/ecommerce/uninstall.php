<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

if (!file_exists('../../config.php')) die('[uninstall.php] config.php not found');
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
	<title>Uninstallation - E-Commerce Plugin</title>
	<meta charset="utf-8">
	<meta name="author" content="CLARICOM (http://www.claricom.ca)" />
	<link rel="stylesheet" href="../../css/stylesheet.css" type="text/css" media="screen" />
</head>
<body>

<div class="container">
<div class="row">
<div class="col-md-12">
<h3>Uninstallation - E-Commerce Plugin</h3>

<!-- Let's do the uninstall -->
<?php if (isset($_POST['uninstall'])) {

// now get the plugin id for futher use
$results = $jakdb->query('SELECT id FROM '.DB_PREFIX.'plugins WHERE name = "Ecommerce"');
$rows = $results->fetch_assoc();

if ($rows) {
 
$jakdb->query('DELETE FROM '.DB_PREFIX.'plugins WHERE name = "Ecommerce"');

$resultsp = $jakdb->query('SELECT id FROM '.DB_PREFIX.'pluginhooks WHERE product = "shop"');
	while ($rowsp = $resultsp->fetch_assoc()) {

		$jakdb->query('DELETE FROM '.DB_PREFIX.'pagesgrid WHERE hookid = '.$rowsp['id']);
	}

$jakdb->query('DELETE FROM '.DB_PREFIX.'pluginhooks WHERE product = "shop"');

$jakdb->query('DELETE FROM '.DB_PREFIX.'setting WHERE product = "shop"');

$jakdb->query('DELETE FROM '.DB_PREFIX.'categories WHERE pluginid = '.$rows['id']);

$jakdb->query('ALTER TABLE '.DB_PREFIX.'usergroup DROP `shop`');
$jakdb->query('ALTER TABLE '.DB_PREFIX.'pagesgrid DROP shopid');

// Clean up database
$jakdb->query('DROP TABLE '.DB_PREFIX.'shop, '.DB_PREFIX.'shop_order, '.DB_PREFIX.'shop_order_details, '.DB_PREFIX.'shop_shipping, '.DB_PREFIX.'shop_payment_ipn, '.DB_PREFIX.'shop_payment, '.DB_PREFIX.'shop_coupon, '.DB_PREFIX.'shop_country, '.DB_PREFIX.'shopping_cart, '.DB_PREFIX.'shopcategories');

$succesfully = 1;

}

?>
<div class="alert alert-success">Plugin uninstalled successfully</div>
<?php } ?>

<?php if (!$succesfully) { ?>
<form name="company" method="post" action="uninstall.php" enctype="multipart/form-data">
<button type="submit" name="uninstall" class="btn btn-danger btn-block">Uninstall Plugin</button>
</form>
<?php } ?>

</div>
</div>


</div><!-- #container -->
</body>
</html>