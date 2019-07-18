<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) die("Nothing to see here");

if (!$_POST['id'] && is_numeric($_POST['id'])) die("There is no such product!");

if (!file_exists('../../../config.php')) die('ajax/[qtips.php] config.php not exist');
require_once '../../../config.php';

if (!file_exists('../class/currency_converter.php')) die('ajax/[addtocart.php] currency_converter.php not exist');
require_once '../class/currency_converter.php';

$result = $jakdb->query('SELECT id, title, content, price, sale, stock, previmg, product_options, product_options1, product_options2, showdate, time FROM '.DB_PREFIX.'shop WHERE id = "'.smartsql($_POST['id']).'" AND active = 1');
$row = $result->fetch_assoc();

if(!$row) die("There is no such product!");

// Now let's check the vote and hits cookie
if (!jak_cookie_voted_hits(DB_PREFIX.'shop', $row['id'], 'hits')) {

	jak_write_vote_hits_cookie(DB_PREFIX.'shop', $row['id'], 'hits');
	
	// Update hits each time
	JAK_base::jakUpdatehits($row['id'], DB_PREFIX.'shop');
}

// Import the language file
if (file_exists(APP_PATH.'plugins/ecommerce/lang/'.$site_language.'.ini')) {
    $tlec = parse_ini_file(APP_PATH.'plugins/ecommerce/lang/'.$site_language.'.ini', true);
} else {
    $tlec = parse_ini_file(APP_PATH.'plugins/ecommerce/lang/en.ini', true);
}

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

// Item is in stock
if ($row['stock'] == 1) {
	$instock = $tlec['shop']['m56'];
} else {
	$instock = $tlec['shop']['m57'];
}

// Uh, we got some different currency then standard, well we need to change
if ($_SESSION['ECOMMERCE_CURRENCY'] != $jkv["e_currency"]) {

	$convert = new JAK_CurrencyC();
		
	$row['price'] = $convert->Convert($row['price'], $_SESSION['ECOMMERCE_CURRENCY']);

}

// Load time if wish so
if ($row['showdate']) {
$PAGE_TIME = date($jkv["shopdateformat"].$jkv["shoptimeformat"], strtotime($row['time']));
$PAGE_TIME_HTML5 = date("Y-m-d", strtotime($row['time']));
$showdate = '<p>'.$tlec["shop"]["m47"].'<time datetime="'.$PAGE_TIME_HTML5.'" pubdate>'.$PAGE_TIME.'</time></p>';
}

$PAGE_TITLE = $row['title'];
$PAGE_CONTENT = jak_secure_site($row['content']);

// Finally output the stuff
$content = ' <div class="item-description"><figure><img src="'.$imge.'" alt="'.$title.'" class="img-responsive"></figure><h3>'.$PAGE_TITLE.'</h3>'.$showdate.''.$PAGE_CONTENT.'<p>'.$tlec["shop"]["m46"].'<strong>'.$instock.'</strong></p><p><strong>'.$tlec["shop"]["m"].'<span class="pprice_'.$row["id"].'">'.$row['price'].'</span>&nbsp;'.$_SESSION['ECOMMERCE_CURRENCY'].'</strong></p></div>';

die(json_encode(array("title" => $PAGE_TITLE, "content" => $content)));
?>
