<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

if (!file_exists('../../../config.php')) die('ajax/[addtocart.php] config.php not exist');
require_once '../../../config.php';

require_once '../class/shopping_cart.php';

if (!file_exists('../class/currency_converter.php')) die('ajax/[addtocart.php] currency_converter.php not exist');
require_once '../class/currency_converter.php';


if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) die("Nothing to see here");

if (!$_POST['id'] && !is_numeric($_POST['id'])) die("There is no such product!");

// Get the item
$row = $jakdb->queryRow('SELECT id, title, content, price, sale, stock, product_weight, previmg FROM '.DB_PREFIX.'shop WHERE id = "'.smartsql($_POST['id']).'" AND active = 1');

if(!$row) die("There is no such product!");

// Import the language file
if (file_exists(APP_PATH.'plugins/ecommerce/lang/'.$site_language.'.ini')) {
    $tlec = parse_ini_file(APP_PATH.'plugins/ecommerce/lang/'.$site_language.'.ini', true);
} else {
    $tlec = parse_ini_file(APP_PATH.'plugins/ecommerce/lang/en.ini', true);
}

$product_title = $row['title'];

// Reset some vars
$cid = $cid1 = $cid2 = $optionlist = $woption = $woption1 = $woption2 = $optpr = $optpr1 = $optpr2 = $optweight = $optweight1 = $optweight2 = '';

// Run Option 1
if (isset($_POST['popt']) && strpos($_POST['popt'], '::')) {

	$optearray = explode('::', $_POST['popt']);
	
	// Display Option Name
	$woption = $optearray[0];
	// Option Name
	$cid = JAK_base::jakCleanurl($optearray[0]);
	// Option Price
	$optpr = $optearray[1];
	// Option Weight
	$optweight = $optearray[2];

}

// Run Option 2
if (isset($_POST['popt1']) && strpos($_POST['popt1'], '::')) {

	$optearray1 = explode('::', $_POST['popt1']);
	
	// Display Option Name
	$woption1 = ' '.$optearray1[0];
	// Option Name
	$cid1 = JAK_base::jakCleanurl($optearray1[0]);
	// Option Price
	$optpr1 = $optearray1[1];
	// Option Weight
	$optweight1 = $optearray1[2];

}


// Run Option 3
if (isset($_POST['popt2']) && strpos($_POST['popt2'], '::')) {

	$optearray2 = explode('::', $_POST['popt2']);
	
	// Display Option Name
	$woption2 = ' '.$optearray2[0];
	// Option Name
	$cid2 = JAK_base::jakCleanurl($optearray2[0]);
	// Option Price
	$optpr2 = $optearray2[1];
	// Option Weight
	$optweight2 = $optearray2[2];

}

// Rewrite path once for the image
$real_base = str_replace('plugins/ecommerce/ajax/', '', BASE_URL);

// Image is available so display it or go standard
if ($row['previmg']) {
	$imge = $row['previmg'];
} else {
	$imge = $real_base.'plugins/ecommerce/img/no_product_photo.png';
}

// Sale is active overwrite price to save some vars
if ($row['sale'] != "0.00") {
	$row['price'] = $row['sale'];
	$tlec["shop"]["m"] = $tlec["shop"]["m31"];
}

// Options have some weight differents!
if ($row['product_weight'] || isset($optweight) || isset($optweight1) || isset($optweight2)) {

	if (isset($optweight)) $row['product_weight'] += floatval($optweight);
	
	if (isset($optweight1)) $row['product_weight'] += floatval($optweight1);
	
	if (isset($optweight2)) $row['product_weight'] += floatval($optweight2);
	
	$weight = number_format($row['product_weight'], 3, '.', '');

}

// Uh, we got some different currency then standard, well we need to change
if (isset($_SESSION['ECOMMERCE_CURRENCY']) && $_SESSION['ECOMMERCE_CURRENCY'] != $jkv["e_currency"]) {

	$convert = new JAK_CurrencyC();
		
	$row['price'] = $convert->Convert($row['price'], $_SESSION['ECOMMERCE_CURRENCY']);
	
	if (isset($optpr) || isset($optpr1) || isset($optpr2)) {
	
		if (isset($optpr)) $row['price'] += floatval($optpr);
		
		if (isset($optpr1)) $row['price'] += floatval($optpr1);
		
		if (isset($optpr2)) $row['price'] += floatval($optpr2);
		
		$row['price'] = number_format($row['price'], 2, '.', '');
	
	}

} else {

	if (isset($optpr) || isset($optpr1) || isset($optpr2)) {
	
		if (isset($optpr2)) $row['price'] += floatval($optpr);
		
		if (isset($optpr2)) $row['price'] += floatval($optpr1);
		
		if (isset($optpr2)) $row['price'] += floatval($optpr2);
		
		$row['price'] = number_format($row['price'], 2, '.', '');
	
	}
	
}

// Make the option look nice
if (isset($woption) || isset($woption1) || isset($woption2)) {

	$optarray = $woption.$woption1.$woption2;
	$optarray = trim($optarray);
	$optarray = explode(" ", $optarray);
	$comma_separated = join(",", $optarray);

	$optionlist = 'Option(s): '.$comma_separated;

}

// If optionlist do some cosmetic
if (isset($optionlist)) $brspace = '<br />';

// Start the shopping cart
$shopping_cart = new Shopping_Cart();
$shopping_cart->writeInto($row['id'], $optionlist, $row['id'].$cid.$cid1.$cid2, $row['price'], $weight);

die(json_encode(array('status' => 1, 'id' => $row['id'].$cid.$cid1.$cid2, 'price' => $row['price'], 'title' => $product_title, 'txt' => '<figure class="product-inbasket" id="pib_'.$row['id'].$cid.$cid1.$cid2.'">
  	<img src="'.$imge.'" alt="'.$product_title.'">
    <h5><span id="'.$row['id'].$cid.$cid1.$cid2.'_count"></span> x '.$product_title.'</h5>
    <p>'.$optionlist.$brspace.$tlec["shop"]["m"].$row['price'].'&nbsp;'.$_SESSION['ECOMMERCE_CURRENCY'].'<br /><a href="#" onclick="itemremove(\''.$row['id'].$cid.$cid1.$cid2.'\');return false;" class="btn btn-danger btn-xs sremove"><i class="fa fa-times"></i></a></p></figure>')));
?>