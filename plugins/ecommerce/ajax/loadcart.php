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

if (!$_POST['id'] && !is_numeric($_POST['id']) && !isset($_SESSION["shopping_cart"]) && !empty($_SESSION["shopping_cart"])) die("Your Shopping Cart is emtpy!");

$cart_array = Shopping_Cart::getCart($_SESSION["shopping_cart"], $site_language);

die(json_encode($cart_array));
?>