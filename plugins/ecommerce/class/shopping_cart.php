<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

class Shopping_Cart {

	protected $value, $session, $option = '', $modal_option = '';

	function startTheCart()
	{
	
		/* Check if user has items in the shopping cart */
		if(isset($_COOKIE['shopping_cart']) && !isset($_SESSION['shopping_cart'])) {
		   $_SESSION['shopping_cart'] = $_COOKIE['shopping_cart'];
		}
	
		if (isset($_SESSION['shopping_cart'])) {
		
			return true;
		
		} else {
		
			if (!isset($_COOKIE['shopping_cart'])) {
				setcookie("shopping_cart", session_id(), time() + 86400, JAK_COOKIE_PATH);
			}
		
			return $_SESSION['shopping_cart'] = session_id();
		
		}
	
	}
	
	public static function getCart($sessionid, $lang) {
		
		global $jakdb;
		
		$result = $jakdb->query('SELECT t1.id, t1.shopid, t1.cartid, t1.product_option, t1.price, t1.currency, t1.weight, t2.title, t2.previmg, t2.sale, t2.stock FROM '.DB_PREFIX.'shopping_cart AS t1 LEFT JOIN '.DB_PREFIX.'shop AS t2 ON(t1.shopid = t2.id) WHERE session = "'.smartsql($sessionid).'"');
		
		while ($row = $result->fetch_assoc()) {
		
			$woption = $cid = $brspace = '';
			
			// Import the language file
			if (file_exists(APP_PATH.'plugins/ecommerce/lang/'.$lang.'.ini')) {
			    $tlec = parse_ini_file(APP_PATH.'plugins/ecommerce/lang/'.$lang.'.ini', true);
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
				$tlec["shop"]["m"] = $tlec["shop"]["m31"];
			}
			
			// Set the currency if not standard.
			$_SESSION['ECOMMERCE_CURRENCY'] = $row['currency'];
			
			// If optionlist do some cosmetic
			if ($row['product_option']) $brspace = '<br>';
			    
			$cart[] = array('status' => 1, 'id' => $row['cartid'], 'price' => $row['price'], 'txt' => '<figure class="product-inbasket" id="pib_'.$row['cartid'].'">
			  	<img src="'.$imge.'" alt="'.$row['title'].'" />
			    <h5><span id="'.$row['cartid'].'_count"></span> x '.$row['title'].'</h5>
			    <p>'.$row['product_option'].$brspace.$tlec["shop"]["m"].$row['price'].'&nbsp;'.$_SESSION['ECOMMERCE_CURRENCY'].'<br /><a href="#" onclick="itemremove(\''.$row['cartid'].'\');return false;" class="btn btn-danger btn-xs sremove"><i class="fa fa-times"></i></a></p></figure>');
		
		}
		
		if (isset($cart) && is_array($cart)) { 
		
			return $cart;
			
		} else { 
		
			return array('status' => 0);
		}
	}
	
	public static function updateCart($sessionid) {
		
		global $jakdb;
		$result = $jakdb->query('SELECT id, price, currency FROM '.DB_PREFIX.'shopping_cart WHERE session = "'.smartsql($sessionid).'"');
		
		$convert = new JAK_CurrencyC();
		
		while ($row = $result->fetch_assoc()) {
		
			if ($row['currency'] != $_SESSION['ECOMMERCE_CURRENCY']) {
			
				if ($row['currency'] == $jkv["e_currency"]) {
				
					$row['price'] = $convert->Convert($row['price'], $_SESSION['ECOMMERCE_CURRENCY']);
				
				} else if ($_SESSION['ECOMMERCE_CURRENCY'] == $jkv["e_currency"] && $row['currency'] != $jkv["e_currency"]) {
				
					$row['price'] = $convert->reConvert($row['price'], $row['currency']);	
				
				} else {
					
					// convert currency back and then recalculate again.
					$standard_price = $convert->reConvert($row['price'], $row['currency']);	
					
					$row['price'] = $convert->Convert($standard_price, $_SESSION['ECOMMERCE_CURRENCY']);
					
				}
				
			}
			
			$jakdb->query('UPDATE '.DB_PREFIX.'shopping_cart SET price = "'.$row['price'].'", currency = "'.smartsql($_SESSION['ECOMMERCE_CURRENCY']).'" WHERE id = "'.$row['id'].'"');
		
		}
		
		return true;
			
	}
	
	function writeInto($value, $option, $cartid, $price, $weight) {
	
		if (is_numeric($value) && jak_row_exist($value, DB_PREFIX.'shop')) {
			
			// Insert into to shop
			global $jakdb;
			$jakdb->query('INSERT INTO '.DB_PREFIX.'shopping_cart SET 
			shopid = "'.$value.'",
			cartid = "'.$cartid.'",
			product_option = "'.smartsql($option).'",
			price = "'.$price.'",
			currency = "'.smartsql($_SESSION['ECOMMERCE_CURRENCY']).'",
			weight = "'.$weight.'",
			session = "'.smartsql($_SESSION['shopping_cart']).'",
			time = NOW()');
			
			return true;
		}
	
	}
	
	function getCountry($countryid = 0) {
	
		global $jakdb;
		
		$country_list = "";
		$result = $jakdb->query('SELECT id, name FROM '.DB_PREFIX.'shop_country LIMIT 240');
		while ($row = $result->fetch_assoc()) {
		
			$select = '';
		
			if ($countryid == $row['id']) { $select = ' selected="selected" '; }
		
			$country_list .= '<option value="'.$row['id'].'"'.$select.'>'.$row['name'].'</option>';
		}
		
		return $country_list;
	
	}

}
?>