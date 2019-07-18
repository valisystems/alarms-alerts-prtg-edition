<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Check if the file is accessed only via index.php if not stop the script from running
if(!defined('JAK_PREVENT_ACCESS')) die('You cannot access this file directly.');

// Get the mysql tables
$jaktable = DB_PREFIX.'shop';
$jaktable1 = DB_PREFIX.'shop_payment';
$jaktable2 = DB_PREFIX.'shop_order';
$jaktable3 = DB_PREFIX.'user';
$jaktable4 = DB_PREFIX.'shop_shipping';
$jaktable5 = DB_PREFIX.'shop_order_details';
$jaktable6 = DB_PREFIX.'shopping_cart';
$jaktable7 = DB_PREFIX.'shopcategories';

// AJAX Search
$AJAX_SEARCH_PLUGIN_WHERE = $jaktable;
$AJAX_SEARCH_PLUGIN_URL = 'plugins/ecommerce/ajaxsearch.php';
$AJAX_SEARCH_PLUGIN_SEO =  $jkv["shopurl"];

// Get the important template stuff
$JAK_SEARCH_WHERE = JAK_PLUGIN_VAR_ECOMMERCE;
$JAK_SEARCH_LINK = JAK_PLUGIN_VAR_ECOMMERCE;

// Heatmap
$JAK_HEATMAPLOC = JAK_PLUGIN_VAR_ECOMMERCE;

// Pay
$JAK_GO_PAY = $JAK_CHECKOUT_TOTAL = false;

// parse url
$backtoshop = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_ECOMMERCE, '', '', '', '');
$shopcheckout = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_ECOMMERCE, 'checkout', '', '', '');
$shopdashboard = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_ECOMMERCE, 'dashboard', '', '', '');

// Template Call
$JAK_TPL_PLUG_T = JAK_PLUGIN_NAME_ECOMMERCE;
$JAK_TPL_PLUG_URL = $backtoshop;

// Import all classes
include_once 'class/shopping_cart.php';
include_once 'class/currency_converter.php';
include_once 'functions.php';

// Start the shopping cart
$shopping_cart = new Shopping_Cart();
$shopping_cart->startTheCart();

// get the shopping cart currency
if (isset($_SESSION['shopping_cart'])) {
	$resultscc = $jakdb->query('SELECT currency FROM '.DB_PREFIX.'shopping_cart WHERE session = "'.smartsql($_SESSION["shopping_cart"]).'"');
	// Set the currency if not standard.
	if ($jakdb->affected_rows > 0) {
		$scc = $resultscc->fetch_assoc();
		$_SESSION['ECOMMERCE_CURRENCY'] = $scc['currency'];
	}
}

// Start the Currency Converter
$convert = new JAK_CurrencyC();

// The new Shop Currency exchange
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['currency'])) {
	
	if ($convert->CheckCurrency($_POST['currency'])) {
	
		$_SESSION['ECOMMERCE_CURRENCY'] = $_POST['currency'];
	
	} else {
	
		$_SESSION['ECOMMERCE_CURRENCY'] = $jkv["e_currency"];
	}
	
	$shopping_cart->updateCart($_SESSION["shopping_cart"]);
	jak_redirect($_SERVER['HTTP_REFERER']);
}

if (!isset($_SESSION['ECOMMERCE_CURRENCY'])) {

	$_SESSION['ECOMMERCE_CURRENCY'] = $jkv["e_currency"];
}

$jkv["e_currency"] = $_SESSION['ECOMMERCE_CURRENCY'];
$E_CURRENCY_CHOOSE = $convert->CurrencyChoose();

// The new Shop Currency exchange
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['refresh'])) {
	
	if (isset($_POST["cartid"])) {
		
	// Now let's check if we have some new quantities.
	foreach ($_POST["cartid"] as $k) {
	
		$newq = $_POST["newquant_".$k];
		$oldq = $_POST["oldquant_".$k];
		$specid = $_POST["specid_".$k];
	
		if ($newq != $oldq) {
			
			if ($newq > $oldq) {
				
				$multi = $jakdb->queryRow('SELECT * FROM '.DB_PREFIX.'shopping_cart WHERE id = "'.smartsql($k).'" AND session = "'.smartsql($_SESSION['shopping_cart']).'" LIMIT 1');
				
				$newq = $newq - $oldq;
				
				for ($i = 1; $i <= $newq; $i++) {
				    $jakdb->query('INSERT INTO '.DB_PREFIX.'shopping_cart SET 
				    shopid = "'.smartsql($multi["shopid"]).'",
				    cartid = "'.smartsql($multi["cartid"]).'",
				   	product_option = "'.smartsql($multi["product_option"]).'",
				    price = "'.smartsql($multi["price"]).'",
				    currency = "'.smartsql($multi["currency"]).'",
				    weight = "'.smartsql($multi["weight"]).'",
				    session = "'.smartsql($_SESSION['shopping_cart']).'",
				    time = NOW()');
				}
			
			} else {
				
				$newq = $oldq - $newq;
				for ($i = 1; $i <= $newq; $i++) {
					$jakdb->query('DELETE FROM '.DB_PREFIX.'shopping_cart WHERE cartid = "'.smartsql($specid).'" AND session = "'.smartsql($_SESSION['shopping_cart']).'" LIMIT 1');
				}
			}
		
		}
		
	}
	
	}
	
	// Finally redirect back to checkout
	jak_redirect(html_entity_decode(JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_ECOMMERCE, 'checkout', '', '', '')));
	
}

// Get the rss if active
if ($jkv["shoprss"]) {
	$JAK_RSS_DISPLAY = 1;
	$P_RSS_LINK = JAK_rewrite::jakParseurl('rss.xml', JAK_PLUGIN_VAR_ECOMMERCE, '', '', '');
}

switch ($page1) {

	case 'rc':
	
		$jakdb->query('DELETE FROM '.DB_PREFIX.'shopping_cart WHERE cartid = "'.smartsql($page2).'" AND session = "'.smartsql($_SESSION['shopping_cart']).'"');
		
		jak_redirect(html_entity_decode(JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_ECOMMERCE, 'checkout', '', '', '')));
	
	break;

	case 'c':
	
			if (is_numeric($page2) && jak_row_permission($page2, $jaktable7, JAK_USERGROUPID)) {
			
			$JAK_ECOMMERCE_ALL = false;
			$getTotal = jak_get_total($jaktable, $page2, 'catid', 'active');
					
					if ($getTotal != 0) {
					
					if ($jkv["shopurl"]) {
						$getWhere = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_ECOMMERCE, $page1, $page2, $page3, '');
						$getPage = $page4;
					} else {
						$getWhere = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_ECOMMERCE, $page1, $page2, '', '');
						$getPage = $page3;
					}
						
						// Paginator
						$ecitem = new JAK_Paginator;
						$ecitem->items_total = $getTotal;
						$ecitem->mid_range = $jkv["shoppagemid"];
						$ecitem->items_per_page = $jkv["shoppageitem"];
						$ecitem->jak_get_page = $getPage;
						$ecitem->jak_where = $getWhere;
						$ecitem->jak_prevtext = $tl["general"]["g171"];
						$ecitem->jak_nexttext = $tl["general"]["g172"];
						$ecitem->paginate();
						$JAK_PAGINATE = $ecitem->display_pages();
						
					
					
					$resultc = $jakdb->query('SELECT name'.' FROM '.$jaktable7.' WHERE id = "'.smartsql($page2).'" LIMIT 1');
					$rowc = $resultc->fetch_assoc();
			
					$result = $jakdb->query('SELECT t1.id, t1.catid, t1.title, t1.previmg, t1.img, t1.price, t1.sale, t1.product_options, t1.product_options1, t1.product_options2, t2.varname FROM '.$jaktable.' AS t1 LEFT JOIN '.$jaktable7.' AS t2 ON (t1.catid = t2.id) WHERE t1.catid = "'.smartsql($page2).'" AND t1.active = 1 ORDER BY t1.ecorder ASC '.$ecitem->limit);
					while ($row = $result->fetch_assoc()) {
					
						$seo = '';
						$onsale = 0;
						
						$shop_option = $row['product_options'];
						$shop_option2 = $row['product_options1'];
						$shop_option3 = $row['product_options2'];
						
						if (!$shop_option) {
							$shop_option = $row['product_options'];
						}
						
						if (!$shop_option2) {
							$shop_option2 = $row['product_options1'];
						}
						
						if (!$shop_option3) {
							$shop_option3 = $row['product_options2'];
						}
					
						if ($jkv["shopurl"]) {
							$seo = JAK_base::jakCleanurl($row['title']);
						}
							
							if ($row['sale'] != "0.00") $onsale = 1;
							
							if ($_SESSION['ECOMMERCE_CURRENCY'] != $jkv["e_currency"]) {
							
								$row['price'] = $convert->Convert($row['price'], $_SESSION['ECOMMERCE_CURRENCY']);
								if ($onsale) $row['sale'] = $convert->Convert($row['sale'], $_SESSION['ECOMMERCE_CURRENCY']);
							}
							
							$imge = '/plugins/ecommerce/img/no_product_photo.png';
							if ($row['previmg']) $imge = $row['previmg'];
							
							$catname = 'all';
							if ($row['catid']) $catname = $row['varname'];
							
							// There should be always a varname in categories and check if seo is valid
							$parseurl = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_ECOMMERCE, 'i', $row['id'], $seo, '');
							
					        // collect each record into $jakdata
					        $JAK_ECOMMERCE_ALL[] = array('id' => $row['id'], 'title' => $row['title'], 'previmg' => $imge, 'img' => $row['img'], 'parseurl' => $parseurl, 'price' => $row['price'], 'sale' => $row['sale'], 'product_options' => $shop_option, 'product_options1' => $shop_option2, 'product_options2' => $shop_option3, 'onsale' => $onsale, 'catname' => $row['varname'], 'parseurl' => $parseurl);
					    }
					    
					}
					
					$PAGE_TITLE = $jkv["e_title"].' - '.$rowc['name'];
					$PAGE_CONTENT = "";
					
					$PAGE_SHOWTITLE = 1;
					
					$JAK_HOOK_SIDE_GRID = false;
					// Get the sort orders for the grid
					$grid = $jakdb->query('SELECT id, hookid, pluginid, whatid, orderid FROM '.DB_PREFIX.'pagesgrid WHERE plugin = '.JAK_PLUGIN_ID_ECOMMERCE.' ORDER BY orderid ASC');
					while ($grow = $grid->fetch_assoc()) {
					        // collect each record into $pagegrid
					        	$JAK_HOOK_SIDE_GRID[] = $grow;
					}
					
					$JAK_SHOP_CAT = JAK_Base::jakGetcatmix(JAK_PLUGIN_VAR_ECOMMERCE, '', $jaktable7, JAK_USERGROUPID, $jkv["shopurl"]);
					
					// Now get the new meta keywords and description maker
					$PAGE_KEYWORDS = str_replace(" ", "", JAK_Base::jakCleanurl($PAGE_TITLE).(JAK_PLUGIN_VAR_ECOMMERCE ? ",".JAK_PLUGIN_VAR_ECOMMERCE : "").($jkv["metakey"] ? ",".$jkv["metakey"] : ""));
					$PAGE_DESCRIPTION = jak_cut_text($PAGE_CONTENT, 155, '');
					
					// get the standard template
					$plugin_template = 'plugins/ecommerce/template/'.$jkv["sitestyle"].'/shop.php';
			
			} else {
				jak_redirect($backtoshop);
			}
		
	break;
	case 'i':
		
			if (is_numeric($page2) && jak_row_exist($page2, $jaktable)) {
			
			// Get the item
			$row = $jakdb->queryRow('SELECT * FROM '.$jaktable.' WHERE id = "'.smartsql($page2).'" LIMIT 1');
			
			if ($row['active'] != 1) {
				jak_redirect(JAK_rewrite::jakParseurl('offline'));
			} else {
			
			if ($row['catid'] != 0 && !jak_row_permission($row['catid'], $jaktable7, JAK_USERGROUPID)) {
				jak_redirect($backtoshop);
			} else {
			
				// Now let's check the vote and hits cookie
				if (!jak_cookie_voted_hits($jaktable, $row['id'], 'hits')) {
				
					jak_write_vote_hits_cookie($jaktable, $row['id'], 'hits');
					
					// Update hits each time
					JAK_base::jakUpdatehits($row['id'],$jaktable);
				}
				
				// Now output the data
				$PAGE_ID = $row['id'];
				$PAGE_TITLE = $row['title'];
				$PAGE_CONTENT = jak_secure_site($row['content']);
				$PAGE_SPECS = jak_secure_site($row['specs']);
				$PAGE_CONTENT_SHORT = jak_cut_text($row['content'], $jkv["shortmsg"], '...');
				$SHOWDATE = $row['showdate'];
				$SHOP_HITS = $row['hits'];
				
				$PAGE_TIME = JAK_Base::jakTimesince($row['time'], $jkv["shopdateformat"], $jkv["shoptimeformat"], $tl['general']['g56']);
				$PAGE_TIME_HTML5 = date("Y-m-d", strtotime($row['time']));
				
				$onsale = 0;
				if ($row['sale'] != "0.00") $onsale = 1;
				
				$instock = $tlec['shop']['m57'];
				if ($row['stock'] == 1) $instock = $tlec['shop']['m56'];
				
				if ($_SESSION['ECOMMERCE_CURRENCY'] != $jkv["e_currency"]) {
				
					$row['price'] = $convert->Convert($row['price'], $_SESSION['ECOMMERCE_CURRENCY']);
					if ($onsale) $row['sale'] = $convert->Convert($row['sale'], $_SESSION['ECOMMERCE_CURRENCY']);
				}
				
				// We have no image
				if (empty($row['previmg'])) $row['previmg'] = '/plugins/ecommerce/img/no_product_photo.png';
			
			// Get the url session
			$_SESSION['jak_lastURL'] = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_ECOMMERCE, $page1, $page2, $page3, '');
			
			// Show Tags
			$JAK_TAGLIST = JAK_tags::jakGettaglist($page2, JAK_PLUGIN_ID_ECOMMERCE, JAK_PLUGIN_VAR_TAGS);
			
			// Page Nav
			$nextp = jak_next_page($page2, 'title', $jaktable, 'id', '', '', 'active');
			if ($nextp) {
				
				if ($jkv["shopurl"]) {
					$seo = JAK_base::jakCleanurl($nextp['title']);
				}
				
				$JAK_NAV_NEXT = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_ECOMMERCE, 'i', $nextp['id'], $seo, '');
				$JAK_NAV_NEXT_TITLE = addslashes($nextp['title']);
			}
			
			$prevp = jak_previous_page($page2, 'title', $jaktable, 'id', '', '', 'active');
			if ($prevp) {
				
				if ($jkv["shopurl"]) {
					$seop = JAK_base::jakCleanurl($prevp['title']);
				}
				
				$JAK_NAV_PREV = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_ECOMMERCE, 'i', $prevp['id'], $seop, '');
				$JAK_NAV_PREV_TITLE = addslashes($prevp['title']);
			}
			
			// Get the sort orders for the grid
			$grid = $jakdb->query('SELECT id, hookid, pluginid, whatid, orderid FROM '.DB_PREFIX.'pagesgrid WHERE plugin = '.JAK_PLUGIN_ID_ECOMMERCE.' ORDER BY orderid ASC');
			while ($grow = $grid->fetch_assoc()) {
			        // collect each record into $pagegrid
			        	$JAK_HOOK_SIDE_GRID[] = $grow;
			}
			
			}
			
			}
			} else {
				jak_redirect($backtoshop);
			}
			
			// Now get the new meta keywords and description maker
			$keytags = '';
			if ($JAK_TAGLIST) {
				$keytags = preg_split('/\s+/', strip_tags($JAK_TAGLIST));
				$keytags = ','.implode(',', $keytags);
			}
			$PAGE_KEYWORDS = str_replace(" ", "", JAK_Base::jakCleanurl($row['title']).$keytags.($jkv["metakey"] ? ",".$jkv["metakey"] : ""));
			$PAGE_DESCRIPTION = jak_cut_text($row['content'], 155, '');
			
			// get the standard template
			$plugin_template = 'plugins/ecommerce/template/'.$jkv["sitestyle"].'/shopitem.php';

				
	break;
	// Checkout
	case 'checkout':
	
		// Checkout and do the payment options		    
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['checkout'])) {
			$defaults = $_POST;
			
			if (empty($defaults['jak_agree'])) {
			    $errors['e'] = $tlec['shop']['e'].'<br />';
			}
			
			if (empty($defaults['name'])) {
			    $errors['e1'] = $tl['error']['e'].'<br />';
			}
			
			if ($jkv["shopcheckout"] != 2) {
			
				if (empty($defaults['phone'])) {
				    $errors['e3'] = $tlec['shop']['e5'].'<br />';
				}
				
				if (empty($defaults['address'])) {
				    $errors['e4'] = $tlec['shop']['e1'].'<br />';
				}
				
				if (empty($defaults['city'])) {
				    $errors['e5'] = $tlec['shop']['e2'].'<br />';
				}
				
				if (empty($defaults['postal'])) {
				    $errors['e6'] = $tlec['shop']['e3'].'<br />';
				}
			
			}
			
			if (empty($defaults['country'])) {
			    $errors['e7'] = $tlec['shop']['e4'].'<br />';
			}
			
			if (isset($defaults['shipping_option']) && empty($defaults['shipping_option'])) {
				$errors['e8'] = $tlec['shop']['e6'].'<br />';
			}
			
			if (!JAK_USERID) {
				
					// First we check username and email   	
			   		if (empty($defaults['username'])) {
			   		    $errors['e9'] = $tl['error']['e14'].'<br />';
			   		}
			   		
			   		if (!preg_match('/^([a-zA-Z0-9\-_])+$/', $defaults['username'])) {
			   			$errors['e9'] = $tl['error']['e15'].'<br />';
			   		}
			   		
			   		if (jak_field_not_exist(strtolower($defaults['username']),$jaktable3, 'username')) {
			   		    $errors['e9'] = $tl['error']['e16'].'<br />';
			   		}
			   		
			   		$username = $defaults['username'];
			
			   	
			   		// Check email if it is double - error
			   		if (!filter_var($defaults['email'], FILTER_VALIDATE_EMAIL)) {
			   		    $errors['e2'] = $tl['error']['e1'].'<br />';
			   		}
			   		
			   		// Check if email address has been blocked
			   		if ($jkv["email_block"]) {
			   			$blockede = explode(',', $jkv["email_block"]);
			   			if (in_array($defaults['email'], $blockede) || in_array(strrchr($defaults['email'], "@"), $blockede)) {
			   				$errors['e2'] = $tl['error']['e21'].'<br />';
			   			}
			   		}
			   		
			   		if (jak_field_not_exist(filter_var($defaults['email'], FILTER_SANITIZE_EMAIL), $jaktable3, 'email')) {
			   		    	$errors['e2'] = $tl['error']['e38'].'<br />';
			   		}
			   		
			   		$email = $defaults['email'];
					
			} else {
					
					if (empty($defaults['email']) || !filter_var($defaults['email'], FILTER_VALIDATE_EMAIL)) {
					    $errors['e2'] = $tl['error']['e1'].'<br />';
					}
					
			}
			
			// Check coupon code
			if (!empty($defaults['jak_shcode']) && !preg_match('/^([0-9]||[a-z]||[A-Z])+$/', $defaults['jak_shcode']) || !empty($defaults['jak_shcode']) && !jak_shop_coupon_check($defaults['jak_shcode'], JAK_USERGROUPID)) {
			    $errors['e9'] = $tlec['shop']['e8'].'<br />';
			}
			
		if (count($errors) == 0) {
			
			$insert = '';
			// Create the user acount because this is a premium order.
			if (!JAK_USERID && isset($jkv["rf_welcome"])) {
			
				$password = jak_password_creator();
				    		
				// The new password encrypt with hash_hmac
				$passcrypt = hash_hmac('sha256', $password, DB_PASS_HASH);
				$sqlupdatepass = 'password = "'.$passcrypt.'",';
				
				$safename = filter_var($defaults['name'], FILTER_SANITIZE_STRING);
				$safeusername = filter_var($username, FILTER_SANITIZE_STRING);
				$safeemail = filter_var($email, FILTER_SANITIZE_EMAIL);
				
				$insertu = '';
				if ($jkv["rf_confirm"] > 1) {
					$getuniquecode = time();
				    $insertu .= 'activatenr = "'.$getuniquecode.'",';
				}
				
				$resultru = $jakdb->query('INSERT INTO '.$jaktable3.' SET 
				username = "'.smartsql($safeusername).'",
				name = "'.smartsql($safename).'",
				email = "'.smartsql($safeemail).'",
				usergroupid = 2,
				'.$sqlupdatepass.'
				'.$insertu.'
				access = "'.smartsql($jkv["rf_confirm"]).'",
				time = NOW()');
				
				$newuid = $jakdb->jak_last_id();
				
				if ($resultru) {
					
					// Insert the userid into the order table
					$insert .= 'userid = "'.$newuid.'",username = "'.$safeusername.'",';
				
					$newuserpath = JAK_FILES_DIRECTORY.'/userfiles/'.$newuid;
					
					if (!is_dir($newuserpath)) {
					                @mkdir($newuserpath, 0777);
					                @copy(JAK_FILES_DIRECTORY."/index.html", $newuserpath."/index.html");
					}
					
					if ($jkv["rf_confirm"] == 2 || $jkv["rf_confirm"] == 3) {
					
						$confirmlink = '<h3>'.$tl['login']['l11'].'</h3><p><strong>'.$tl['login']['l1'].':</strong> <a href="'.(JAK_USE_APACHE ? substr(BASE_URL, 0, -1) : BASE_URL).JAK_rewrite::jakParseurl('rf_ual', $newuid, $getuniquecode, $safeusername, '').'">'.(JAK_USE_APACHE ? substr(BASE_URL, 0, -1) : BASE_URL).JAK_rewrite::jakParseurl('rf_ual', $newuid, $getuniquecode, $safeusername, '').'</a>';
						
						$confirmlink .= '<br><strong>'.$tl['login']['l2'].':</strong> '.$password.'</p>';
					
						$mail = new PHPMailer(); // defaults to using php "mail()"
						$linkmessage = $jkv["rf_welcome"].$confirmlink;
						$body = str_ireplace("[\]",'',$linkmessage);
						$mail->SetFrom($jkv["email"], $jkv["title"]);
						$mail->AddAddress($safeemail, $safeusername);
						$mail->Subject = $jkv["title"].' - '.$tl['login']['l11'];
						$mail->MsgHTML($body);
						$mail->Send(); // Send email without any warnings
						
						
						if ($jkv["rf_confirm"] == 3) {
						
							$admail = new PHPMailer();
							$adlinkmessage = $tl['login']['l11'].$safeusername;
							$adbody = str_ireplace("[\]",'',$adlinkmessage);
							$admail->SetFrom($jkv["email"], $jkv["title"]);
							$admail->AddAddress($jkv["email"], $jkv["title"]);
							$admail->Subject = $jkv["title"].' - '.$tl['login']['l11'];
							$admail->MsgHTML($adbody);
							$admail->Send(); // Send email without any warnings
							
						}
					
					} else {
					
						$confirmlink .= '<br><strong>'.$tl['login']['l2'].':</strong> '.$password;
					
						$mail = new PHPMailer(); // defaults to using php "mail()"
						$body = str_ireplace("[\]",'',$jkv["rf_welcome"].$confirmlink);
						$mail->SetFrom($jkv["email"], $jkv["title"]);
						$mail->AddAddress($safeemail, $safeusername);
						$mail->Subject = $jkv["title"].' - '.$tl['login']['l11'];
						$mail->MsgHTML($body);
						$mail->Send(); // Send email without any warnings
						
					}
				}
			}
			
			$shipping_price = false;
			$payment_id = explode(":#:", $defaults['paymethod']);
			if (isset($defaults['shipping_option'])) $shipping_price = explode(":#:", $defaults['shipping_option']);
			$safeemail = filter_var($defaults['email'], FILTER_SANITIZE_EMAIL);
			$safename = filter_var($defaults['name'], FILTER_SANITIZE_STRING);
			$safecountry = filter_var($defaults['country'], FILTER_SANITIZE_STRING);
			
			$safecompany = $safeaddress = $safezip = $safecity = '';
			// We collect address
			if ($jkv["shopcheckout"] != 2) {
				$safecompany = filter_var($defaults['company'], FILTER_SANITIZE_STRING);
				$safeaddress = filter_var($defaults['address'], FILTER_SANITIZE_STRING);
				$safezip = filter_var($defaults['postal'], FILTER_SANITIZE_STRING);
				$safecity = filter_var($defaults['city'], FILTER_SANITIZE_STRING);
			}
			
			// Create ordernumber
			$writeuid = '';
			if (JAK_USERID) {
				$writeuid = '-'.JAK_USERID;
			} elseif (isset($newuid)) {
				$writeuid = '-'.$newuid;
			}
			$ordernumber = 'O-'.mt_rand().$writeuid;
			$_SESSION['ECOMMERCE_ORDNR'] = $ordernumber;
			
			// Get the total price
			$row = $jakdb->queryRow('SELECT SUM(t1.price) AS total_price FROM '.$jaktable6.' AS t1 WHERE t1.session = "'.smartsql($_SESSION['shopping_cart']).'"');
			
			$total_price = $row['total_price'];
			
			// Calculate the shop taxes
			$taxSumC = 0.00;
			if ($jkv["e_taxes"] && $jkv["e_country"] == $safecountry) {
				$taxTotal = $total_price / 100 * $jkv["e_taxes"];
				$taxSumC = round($taxTotal, 1);
				$total_price += $taxSumC;
			}
			
			// Calculate the shop fees
			if ($payment_id[0]) {
				$feeTotal = $total_price / 100 * $payment_id[0];
				$feeSumC = round($feeTotal, 1);
				$total_price += $feeSumC;
			}
			
			if ($payment_id[1] != 7) {
			
				$total_price += $shipping_price[0];
				$shipping_p = $shipping_price[0];
			} else {
			
				$shipping_p = 0;
			}
			
			// two decimals
			$total_price = number_format($total_price, 2, '.', '');
			
			// We have a logged in user
			if (JAK_USERID) {
				$insert .= 'userid = "'.smartsql(JAK_USERID).'",username = "'.smartsql($JAK_USERNAME).'",';
			}
			
			// We have shipping
			if (isset($defaults['show-shipping'])) {
			
				$sh_safeemail = filter_var($defaults['sh_email'], FILTER_SANITIZE_EMAIL);
				
				$insert .= 'sh_name = "'.smartsql($defaults['sh_name']).'",
				sh_company = "'.smartsql($defaults['sh_company']).'",
				sh_address = "'.smartsql($defaults['sh_address']).'",
				sh_country = "'.smartsql($defaults['sh_country']).'",
				sh_city = "'.smartsql($defaults['sh_city']).'",
				sh_zip_code = "'.smartsql($defaults['sh_postal']).'",
				sh_email = "'.smartsql($sh_safeemail).'",
				sh_phone = "'.smartsql($defaults['sh_phone']).'",';
			
			}
			
			$jakdb->query('INSERT INTO '.$jaktable2.' SET 
			paid_method = "'.smartsql($payment_id[1]).'",
			total_price = "'.smartsql($total_price).'",
			tax = "'.smartsql($taxSumC).'",
			shipping = "'.smartsql($shipping_p).'",
			currency = "'.smartsql($_SESSION['ECOMMERCE_CURRENCY']).'",
			name = "'.smartsql($safename).'",
			company = "'.smartsql($safecompany).'",
			address = "'.smartsql($safeaddress).'",
			country = "'.smartsql($safecountry).'",
			city = "'.smartsql($safecity).'",
			zip_code = "'.smartsql($safezip).'",
			email = "'.smartsql($safeemail).'",
			phone = "'.smartsql($defaults['phone']).'",
			'.$insert.'
			time = NOW(),
			ordernumber = "'.smartsql($ordernumber).'"');
			
			$orderid = $jakdb->jak_last_id();
			
			// Zero all results
			$disc_diff = 0.00;
			$freeshipping = $discount_total = false;
			$couponID = 0;
			
			// Let's start with getting out all of the data and insert into the order table!
			$result = $jakdb->query('SELECT t1.price, t1.weight, t1.product_option, t2.id, t2.title, t2.previmg FROM '.$jaktable6.' AS t1 LEFT JOIN '.DB_PREFIX.'shop AS t2 ON(t1.shopid = t2.id) WHERE t1.session = "'.smartsql($_SESSION['shopping_cart']).'"');
			while ($row = $result->fetch_assoc()) {
				
				// Reset discount price
				$disc_price = 0.00;
				
				// get the discount if there is any.
				if (!empty($defaults['jak_shcode'])) {
				
					$rowc = $jakdb->queryRow('SELECT id, type, discount, freeshipping FROM '.DB_PREFIX.'shop_coupon WHERE code = "'.smartsql($defaults['jak_shcode']).'" AND (FIND_IN_SET('.$row['id'].', products) OR products = 0) AND status = 1 AND (datestart < "'.time().'" AND dateend > "'.time().'" OR datestart = 0 AND dateend = 0) AND used < total LIMIT 1');
					
					if ($jakdb->affected_rows === 1) {
				
						// Check discount type (type1 = percentage)
						if ($rowc['type'] == 1) {
							// Get the discount before taxes
							$totalD = $row['price'] / 100 * $rowc['discount'];
							$disc_price = $row['price'] - number_format(round($totalD, 1), 2, '.', '');
								
						} else {
							// Get the discount before taxes
							$disc_price = $row['price'] - $rowc['discount'];
								
							
						}
						
						if ($rowc['freeshipping'] == 1) {
							$freeshipping = true;
						}
						
					}
					
				}
				
				$jakdb->query('INSERT INTO '.$jaktable5.' SET 
				orderid = "'.smartsql($orderid).'",
				shopid = "'.smartsql($row['id']).'",
				title = "'.smartsql($row['title']).'",
				product_option = "'.smartsql($row['product_option']).'",
				price = "'.smartsql($row['price']).'",
				coupon_price = "'.smartsql($disc_price).'",
				weight = "'.smartsql($row['weight']).'"'); 
				
				// Get the discount total
				$discount_total += $disc_price;
				
				// Get the id into a var
				if (isset($rowc["id"])) $couponID = $rowc["id"];
							
			}
			
			// Now update the total order db
			if ($discount_total || $freeshipping) {
			
				if ($discount_total) {
				
					$disc_diff = $total_price - $discount_total;
					$total_price = $total_price - $disc_diff;
					
					// Calculate the shop taxes
					if ($jkv["e_taxes"] && $jkv["e_country"] == $safecountry) {
						$taxTotal = $total_price / 100 * $jkv["e_taxes"];
						$taxSumC = round($taxTotal, 1);
						$total_price += $taxSumC;
						
						// total diff
						$taxTotald = $disc_diff / 100 * $jkv["e_taxes"];
						$taxSumCd = round($taxTotald, 1);
						$disc_diff += $taxSumCd;
					}
					
					// Calculate the shop fees
					if ($payment_id[0]) {
						$feeTotal = $total_price / 100 * $payment_id[0];
						$feeSumC = round($feeTotal, 1);
						$total_price += $feeSumC;
						
						// Total diff fees
						$feeTotald = $disc_diff / 100 * $payment_id[0];
						$feeSumCd = round($feeTotald, 1);
						$disc_diff += $feeSumCd;
					}
					
					if ($payment_id[1] != 7) {
					
					if (!$freeshipping) {
						// Add shipping to the new total
						$total_price += $shipping_price[0];
						$shipping_p = $shipping_price[0];
						
						// total diff with shipping
						$coupon_total += $shipping_price[0];
					}
						
					} else {
					
						$shipping_p = 0;
					}
					
					// two decimals
					$total_price = number_format($total_price, 2, '.', '');
					$disc_diff = number_format($disc_diff, 2, '.', '');
					
					$insertc = 'total_price = "'.$total_price.'", discount = "'.$disc_diff.'"';
					
				}
				
				if ($freeshipping) {
					$insertf = ($insertc ? ', freeshipping = 1' : 'freeshipping = 1');
				}
				
				// Update the order table
				$jakdb->query('UPDATE '.$jaktable2.' SET 
				'.$insertc.'
				'.$insertf.'
				WHERE id = '.$orderid);
				
				// Update the coupon table
				if ($couponID) $jakdb->query('UPDATE '.DB_PREFIX.'shop_coupon SET used = used + 1 WHERE id = '.$couponID);
			
			}
			
			// Now get the payment information
			$result_p = $jakdb->query('SELECT field1, field2, field3 FROM '.$jaktable1.' WHERE id = "'.smartsql($payment_id[1]).'" AND status = 1');
			$row_p = $result_p->fetch_assoc();
			
			// Now we start with the payment option, this goes from  1 - 7
			switch($payment_id[1]) {
			
				// Cheque / Money Order
				case 2:
				
					// Send the email with bank details
					$mail = new PHPMailer(); // defaults to using php "mail()"
					$body = str_ireplace("[\]", '', $jkv["e_thanks"].'<br />'.$tlec['shop']['m13'].'<br /><br /><strong>'.$tlec['shop']['m'].'</strong>'.$total_price.' '.$_SESSION['ECOMMERCE_CURRENCY'].'<br /><br />'.$tlec['shop']['m9'].$row_p['field1'].'<br />'.$tlec['shop']['m7'].$ordernumber);
					$mail->SetFrom($jkv["email"], $jkv["title"]);
					$mail->AddAddress($safeemail, $safename);
					$mail->Subject = $jkv["title"].' - '.JAK_PLUGIN_NAME_ECOMMERCE;
					$mail->MsgHTML($body);
					$mail->Send(); // Send email without any warnings
					
					// Send an email to the owner if wish so
					if ($jkv["shopemail"]) {
					
						$maila = new PHPMailer(); // defaults to using php "mail()"
						$bodya = str_ireplace("[\]",'',$tlec['shop']['m13'].'<br /><br /><strong>'.$tlec['shop']['m'].'</strong>'.$total_price.' '.$_SESSION['ECOMMERCE_CURRENCY'].'<br /><br />'.$tlec['shop']['m9'].$row_p['field1'].'<br />'.$tlec['shop']['m7'].$ordernumber);
						$maila->SetFrom($jkv["shopemail"], $jkv["e_title"]);
						$maila->AddReplyTo($safeemail, $safename);
						$maila->AddAddress($jkv["shopemail"], $jkv["e_title"]);
						$maila->Subject = $jkv["title"].' - '.JAK_PLUGIN_NAME_ECOMMERCE.' - '.$tlec['shop']['m53'];
						$maila->MsgHTML($bodya);
						$maila->Send(); // Send email without any warnings
					}
					
					// Finally Delete the shopping Cart
					$jakdb->query('DELETE FROM '.$jaktable6.' WHERE session = "'.smartsql($_SESSION['shopping_cart']).'"');
					
					jak_redirect(html_entity_decode(JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_ECOMMERCE, 'd', $ordernumber, '2', '')));
						
				break;
				// Paypal
				case 3:
				
					// Now we go with thru paypal and verify the payment
					
					// Include the paypal library
					include_once ('plugins/ecommerce/payment/paypal.php');
					
					// Create an instance of the paypal library
					$myPaypal = new Paypal();
					
					// Specify your paypal email
					$myPaypal->addField('business', $row_p['field1']);
					
					// Specify the currency
					$myPaypal->addField('currency_code', $_SESSION['ECOMMERCE_CURRENCY']);
					
					// Specify the url where paypal will send the user on success/failure
					$myPaypal->addField('return', JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_ECOMMERCE, 'success', '', '', ''));
					$myPaypal->addField('cancel_return', JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_ECOMMERCE, 'error', '', '', ''));
					
					// Specify the url where paypal will send the IPN
					$myPaypal->addField('notify_url', BASE_URL.'plugins/ecommerce/payment/paypal_ipn.php');
					
					// Specify the product information
					$myPaypal->addField('item_name', $jkv["e_title"]);
					$myPaypal->addField('amount', $total_price);
					
					// Specify any custom value
					$myPaypal->addField('custom', base64_encode($orderid.':#:'.$ordernumber.':#:'.$_SESSION['shopping_cart'].':#:'.JAK_PLUGIN_VAR_ECOMMERCE));
					
					// Enable test mode if needed
					//$myPaypal->enableTestMode();
					
					$JAK_GO_PAY = $myPaypal->submitPayment($tlec['shop']['m5']);
				 
				break;
				// 2Checkout
				case 4:
					
					// Include the twoco library
					include_once ('plugins/ecommerce/payment/twoco.php');
						
					// Create an instance of the authorize.net library
					$my2CO = new TwoCo();
						
					// Specify your 2CheckOut vendor id
					$my2CO->addField('sid', $row_p['field1']);
						
					// Specify the order information
					$my2CO->addField('cart_order_id', base64_encode($orderid));
					$my2CO->addField('total', $total_price);
						
					// Specify the url where authorize.net will send the IPN
					$my2CO->addField('x_Receipt_Link_URL', BASE_URL.'plugins/ecommerce/payment/twoco_ipn.php');
					$my2CO->addField('tco_currency', $_SESSION['ECOMMERCE_CURRENCY']);
					$my2CO->addField('custom', base64_encode($orderid.':#:'.$ordernumber.':#:'.$_SESSION['shopping_cart'].':#:'.JAK_PLUGIN_VAR_ECOMMERCE));
						
					// Enable test mode if needed
					//$my2CO->enableTestMode();
						
					$JAK_GO_PAY = $myPaypal->submitPayment($tlec['shop']['m5']);
												
				break;
				
				// Authorize.net
				case 5:
				
					// Include the authorize library
					include_once ('plugins/ecommerce/payment/authorize.php');
					
					// Create an instance of the authorize.net library
					$myAuthorize = new Authorize();
					
					// Specify your authorize.net login and secret
					$myAuthorize->setUserInfo($row_p['field1'], $row_p['field2']);
					
					// Specify the url where authorize.net will send the user on success/failure
					$myAuthorize->addField('x_Receipt_Link_URL', JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_ECOMMERCE, 'success', '', '', ''));
					
					// Specify the url where authorize.net will send the IPN
					$myAuthorize->addField('x_Relay_URL', BASE_URL.'plugins/ecommerce/payment/authorize_ipn.php');
					
					// Specify the product information
					$myAuthorize->addField('x_Description', $jkv["e_title"]);
					$myAuthorize->addField('x_Amount', $total_price);
					$myAuthorize->addField('x_Invoice_num', base64_encode($orderid.':#:'.$ordernumber.':#:'.$_SESSION['shopping_cart'].':#:'.JAK_PLUGIN_VAR_ECOMMERCE));
					$myAuthorize->addField('x_Cust_ID', JAK_USERID);
					
					// Enable test mode if needed
					//$myAuthorize->enableTestMode();
					
					$JAK_GO_PAY = $myPaypal->submitPayment($tlec['shop']['m5']);
					
				break;
				// Cheque or Cash
				case 6:
					
					// Send the email with bank details
					$mail = new PHPMailer(); // defaults to using php "mail()"
					$body = str_ireplace("[\]", '', $jkv["e_thanks"].'<br />'.$tlec['shop']['m13'].'<br /><br /><strong>'.$tlec['shop']['m'].'</strong>'.$total_price.' '.$_SESSION['ECOMMERCE_CURRENCY'].'<br /><br />'.$row_p['field1'].'<br />'.$tlec['shop']['m7'].$ordernumber);
					$mail->SetFrom($jkv["email"], $jkv["title"]);
					$mail->AddAddress($safeemail, $safename);
					$mail->Subject = $jkv["title"].' - '.JAK_PLUGIN_NAME_ECOMMERCE;
					$mail->MsgHTML($body);
					$mail->Send(); // Send email without any warnings
					
					// Send an email to the owner if wish so
					if ($jkv["shopemail"]) {
					
						$maila = new PHPMailer(); // defaults to using php "mail()"
						$bodya = str_ireplace("[\]", '', $tlec['shop']['m13'].'<br /><br /><strong>'.$tlec['shop']['m'].'</strong>'.$total_price.' '.$_SESSION['ECOMMERCE_CURRENCY'].'<br /><br />'.$row_p['field1'].'<br />'.$tlec['shop']['m7'].$ordernumber);
						$maila->SetFrom($jkv["shopemail"], $jkv["e_title"]);
						$maila->AddAddress($jkv["shopemail"], $safename);
						$maila->Subject = $jkv["title"].' - '.JAK_PLUGIN_NAME_ECOMMERCE.' - '.$tlec['shop']['m53'];
						$maila->MsgHTML($bodya);
						$maila->Send(); // Send email without any warnings
						
					}
					
					// Finally Delete the shopping Cart
					$jakdb->query('DELETE FROM '.$jaktable6.' WHERE session = "'.smartsql($_SESSION['shopping_cart']).'"');
					
					jak_redirect(html_entity_decode(JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_ECOMMERCE, 'd', $ordernumber, '1', '')));
					
				break;
				// Pickup
				case 7:
					
					// Send the email with bank details
					$mail = new PHPMailer(); // defaults to using php "mail()"
					$body = str_ireplace("[\]", '', $jkv["e_thanks"].'<br />'.$tlec['shop']['m51'].'<br /><br /><strong>'.$tlec['shop']['m'].'</strong>'.$total_price.' '.$_SESSION['ECOMMERCE_CURRENCY'].'<br /><br />'.$row_p['field1'].'<br />'.$tlec['shop']['m7'].$ordernumber);
					$mail->SetFrom($jkv["email"], $jkv["title"]);
					$mail->AddAddress($safeemail, $safename);
					$mail->Subject = $jkv["title"].' - '.JAK_PLUGIN_NAME_ECOMMERCE;
					$mail->MsgHTML($body);
					$mail->Send(); // Send email without any warnings
					
					// Send an email to the owner if wish so
					if ($jkv["shopemail"]) {
					
						$maila = new PHPMailer(); // defaults to using php "mail()"
						$bodya = str_ireplace("[\]", '', $tlec['shop']['m51'].'<br /><br /><strong>'.$tlec['shop']['m'].'</strong>'.$total_price.' '.$_SESSION['ECOMMERCE_CURRENCY'].'<br /><br />'.$row_p['field1'].'<br />'.$tlec['shop']['m7'].$ordernumber);
						$maila->SetFrom($jkv["shopemail"], $jkv["e_title"]);
						$maila->AddAddress($jkv["shopemail"], $safename);
						$maila->Subject = $jkv["title"].' - '.JAK_PLUGIN_NAME_ECOMMERCE.' - '.$tlec['shop']['m53'];
						$maila->MsgHTML($bodya);
						$maila->Send(); // Send email without any warnings
						
					}
					
					// Finally Delete the shopping Cart
					$jakdb->query('DELETE FROM '.$jaktable6.' WHERE session = "'.smartsql($_SESSION['shopping_cart']).'"');
					
					jak_redirect(html_entity_decode(JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_ECOMMERCE, 'd', $ordernumber, '1', '')));
					
				break;
				// Payza
				case 8:
				
					// Now we go with thru paypal and verify the payment
					
					// Include the paypal library
					include_once ('plugins/ecommerce/payment/payza.php');
					
					// Create an instance of the paypal library
					$myPayza = new AlertPay();
					
					// Specify your paypal email
					$myPayza->addField('ap_merchant', $row_p['field1']);
					
					// Specify purchase type
					$myPayza->addField('ap_purchasetype', 'item-goods');
					
					// Specify the product information
					$myPayza->addField('ap_itemname', $jkv["title"].' - '.$jkv["e_title"]);
					$myPayza->addField('ap_amount', $total_price);
					
					// Specify the currency
					$myPayza->addField('ap_currency', $_SESSION['ECOMMERCE_CURRENCY']);
					
					// Specify the url where paypal will send the user on success/failure
					$myPayza->addField('ap_returnurl', JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_ECOMMERCE, 'success', '', '', ''));
					$myPayza->addField('ap_cancelurl', JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_ECOMMERCE, 'error', '', '', ''));
					
					// Specify the url where paypal will send the IPN
					$myPayza->addField('ap_alerturl', BASE_URL.'plugins/ecommerce/payment/alertpay_ipn.php');
					$myPayza->addField('ap_ipnversion', '2');
					
					// Specify any custom value
					$myPayza->addField('apc_1', base64_encode($orderid.':#:'.$ordernumber.':#:'.$_SESSION['shopping_cart'].':#:'.JAK_PLUGIN_VAR_ECOMMERCE));
					
					// Enable test mode if needed
					//$myPayza->enableTestMode();
					
					$JAK_GO_PAY = $myPayza->submitPayment($tlec['shop']['m5']);
				 
				break;
				// Skrill (Moneybookers
				case 9:
				
					// Now we go with thru paypal and verify the payment
					
					// Include the paypal library
					include_once ('plugins/ecommerce/payment/skrill.php');
					
					// Create an instance of the paypal library
					$mySkrill = new Paypal();
					
					// Specify your paypal email
					$mySkrill->addField('pay_to_email', $row_p['field1']);
					
					// Specify purchase type
					$mySkrill->addField('language', JAK_LANG);
					
					// Specify the currency
					$mySkrill->addField('currency', $_SESSION['ECOMMERCE_CURRENCY']);
					
					// Specify the url where paypal will send the user on success/failure
					$mySkrill->addField('return_url', JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_ECOMMERCE, 'success', '', '', ''));
					$mySkrill->addField('cancel_url', JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_ECOMMERCE, 'error', '', '', ''));
					
					// Specify the url where paypal will send the IPN
					$mySkrill->addField('status_url', BASE_URL.'plugins/ecommerce/payment/skrill_ipn.php');
					
					// Specify the product information
					$mySkrill->addField('detail1_description', $jkv["e_title"]);
					$mySkrill->addField('amount', $total_price);
					
					// Specify any custom value
					$mySkrill->addField('transaction_id', $ordernumber);
					
					$mySkrill->addField('merchant_fields', 'order_nr, session_id, shop_url');
					$mySkrill->addField('order_nr', $orderid);
					$mySkrill->addField('session_id', $_SESSION['shopping_cart']);
					$mySkrill->addField('shop_url', JAK_PLUGIN_VAR_ECOMMERCE);
					
					// Enable test mode if needed
					//$mySkrill->enableTestMode();
					
					$JAK_GO_PAY = $mySkrill->submitPayment($tlec['shop']['m5']);
				 
				break;
				// Stripe
				case 10:
				
					$url_to_pay = (JAK_USE_APACHE ? substr(BASE_URL, 0, -1) : BASE_URL).JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_ECOMMERCE, 'd', $ordernumber, '10', '');
				
					// Send the email with the checkout page to pay (also later)
					$mail = new PHPMailer(); // defaults to using php "mail()"
					$body = str_ireplace("[\]", '', $jkv["e_thanks"].'<br />'.$tlec['shop']['m8'].'<br /><br /><strong>'.$tlec['shop']['m'].'</strong>'.$total_price.' '.$_SESSION['ECOMMERCE_CURRENCY'].'<br /><br />'.$tlec['shop']['m9'].$row_p['field1'].'<br />'.$tlec['shop']['m70'].$url_to_pay.'<br />'.$tlec['shop']['m7'].$ordernumber);
					$mail->SetFrom($jkv["email"], $jkv["title"]);
					$mail->AddAddress($safeemail, $safename);
					$mail->Subject = $jkv["title"].' - '.JAK_PLUGIN_NAME_ECOMMERCE;
					$mail->MsgHTML($body);
					$mail->Send(); // Send email without any warnings
					
					// Send an email to the owner if wish so
					if ($jkv["shopemail"]) {
					
						$maila = new PHPMailer(); // defaults to using php "mail()"
						$bodya = str_ireplace("[\]", '', $tlec['shop']['m8'].'<br /><br /><strong>'.$tlec['shop']['m'].'</strong>'.$total_price.' '.$_SESSION['ECOMMERCE_CURRENCY'].'<br /><br />'.$tlec['shop']['m9'].$row_p['field1'].'<br />'.$tlec['shop']['m70'].$url_to_pay.'<br />'.$tlec['shop']['m7'].$ordernumber);
						$maila->SetFrom($jkv["shopemail"], $jkv["e_title"]);
						$maila->AddReplyTo($safeemail, $safename);
						$maila->AddAddress($jkv["shopemail"], $jkv["e_title"]);
						$maila->Subject = $jkv["title"].' - '.JAK_PLUGIN_NAME_ECOMMERCE.' - '.$tlec['shop']['m53'];
						$maila->MsgHTML($bodya);
						$maila->Send(); // Send email without any warnings
						
					}
					
					// Finally Delete the shopping Cart
					$jakdb->query('DELETE FROM '.$jaktable6.' WHERE session = "'.smartsql($_SESSION['shopping_cart']).'"');
					
					jak_redirect(html_entity_decode(JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_ECOMMERCE, 'd', $ordernumber, '10', '')));
				 
				break;
				// Default is always bank transfer
				default:
				
					// Send the email with bank details
					$mail = new PHPMailer(); // defaults to using php "mail()"
					$body = str_ireplace("[\]", '', $jkv["e_thanks"].'<br />'.$tlec['shop']['m8'].'<br /><br /><strong>'.$tlec['shop']['m'].'</strong>'.$total_price.' '.$_SESSION['ECOMMERCE_CURRENCY'].'<br /><br />'.$tlec['shop']['m9'].$row_p['field1'].'<br />'.$tlec['shop']['m7'].$ordernumber);
					$mail->SetFrom($jkv["email"], $jkv["title"]);
					$mail->AddAddress($safeemail, $safename);
					$mail->Subject = $jkv["title"].' - '.JAK_PLUGIN_NAME_ECOMMERCE;
					$mail->MsgHTML($body);
					$mail->Send(); // Send email without any warnings
					
					// Send an email to the owner if wish so
					if ($jkv["shopemail"]) {
					
						$maila = new PHPMailer(); // defaults to using php "mail()"
						$bodya = str_ireplace("[\]", '', $tlec['shop']['m8'].'<br /><br /><strong>'.$tlec['shop']['m'].'</strong>'.$total_price.' '.$_SESSION['ECOMMERCE_CURRENCY'].'<br /><br />'.$tls['shop']['m9'].$row_p['field1'].'<br />'.$tlec['shop']['m7'].$ordernumber);
						$maila->SetFrom($jkv["shopemail"], $jkv["e_title"]);
						$maila->AddReplyTo($safeemail, $safename);
						$maila->AddAddress($jkv["shopemail"], $jkv["e_title"]);
						$maila->Subject = $jkv["title"].' - '.JAK_PLUGIN_NAME_ECOMMERCE.' - '.$tlec['shop']['m53'];
						$maila->MsgHTML($bodya);
						$maila->Send(); // Send email without any warnings
						
					}
					
					// Finally Delete the shopping Cart
					$jakdb->query('DELETE FROM '.$jaktable6.' WHERE session = "'.smartsql($_SESSION['shopping_cart']).'"');
					
					jak_redirect(html_entity_decode(JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_ECOMMERCE, 'd', $ordernumber, '1', '')));
			}
		
		} else {
			$errors = $errors;
		}
		
		}
		
		$PAGE_TITLE = $tlec['shop']['m29'];
		
		// Get Email Address if registered
		if (JAK_USERID) {
		
			$checkout_email = $jakuser->getVar("email");
		}
		
		// Get Country list for tax
		$usr_country = false;
		if (isset($_POST['country'])) $usr_country = $_POST['country'];
		$getcountry = $shopping_cart->getCountry($usr_country);
		
		// Get the agreement page details!
		foreach ($jakcategories as $sap) {
				
				if ($jkv["e_agreement"] == $sap['id']) {
				
					$AGREEMENT_NAME = $sap["name"];
					$AGREEMENT_URL = JAK_rewrite::jakParseurl($sap["pagename"], '', '', '', '');
				
				}
			
		}
		
		// Get the Payment Details
		$result = $jakdb->query('SELECT id, field, fees FROM '.$jaktable1.' WHERE status = 1 ORDER BY msporder ASC');
		while ($row = $result->fetch_assoc()) {
		
			$fees = '';
			if ($row['fees']) {
				
				$fees = ' ('.$tlec['shop']['m23'].$row['fees'].'%)';
			
			}
			    
			$payment_option[] = array('paybtn' => ' <button type="submit" name="paymethod" value="'.$row['fees'].':#:'.$row['id'].'" class="btn btn-primary">'.$row['field'].$fees.'</button>');
		
		}
		
		$result = $jakdb->query('SELECT SUM(weight) AS total_weight FROM '.DB_PREFIX.'shopping_cart WHERE session = "'.smartsql($_SESSION['shopping_cart']).'"');
		$row = $result->fetch_assoc();
		
		// Get the Shipping Details
		$result = $jakdb->query('SELECT t1.id, t1.title, t1.deliveryimg, t1.est_shipping, t1.price, t1.handling, t2.name FROM '.$jaktable4.' AS t1 LEFT JOIN '.DB_PREFIX.'shop_country AS t2 ON (t1.country = t2.id) WHERE status = 1 AND (weightfrom <= "'.$row['total_weight'].'" AND weightto >= "'.$row['total_weight'].'") OR (weightfrom = 0.000 AND weightto = 0.000)');
		while ($row = $result->fetch_assoc()) {
		
			$ship_title = $row['title'];
		
			$finalprice = $row['price'] + $row['handling'];
			
			if ($_SESSION['ECOMMERCE_CURRENCY'] != $jkv["e_currency"]) {
			
				$finalprice = $convert->Convert($finalprice, $_SESSION['ECOMMERCE_CURRENCY']);
				
			}
			    
			$shipping_option[] = array('select' => '<option value="'.$finalprice.':#:'.$row['est_shipping'].'" />'.$row['name'].' - '.$ship_title.' ('.$tlec['shop']['m'].$finalprice.' '.$_SESSION['ECOMMERCE_CURRENCY'].')');
		
		}
		
		// Finally get the items from the shopping cart		
		$result = $jakdb->query('SELECT COUNT(*) AS total, t1.id, t1.shopid, t1.cartid, t1.product_option, t1.price, t1.currency, t1.weight, t2.title, t2.previmg, t2.sale, t2.stock FROM '.DB_PREFIX.'shopping_cart AS t1 LEFT JOIN '.DB_PREFIX.'shop AS t2 ON(t1.shopid = t2.id) WHERE session = "'.smartsql($_SESSION["shopping_cart"]).'" GROUP BY t1.cartid');
		
		while ($row = $result->fetch_assoc()) {
			
			// Image is available so display it or go standard
			if (empty($row['previmg'])) $row['previmg'] = BASE_URL.'plugins/ecommerce/img/no_product_photo.png';
			
			// Set the currency if not standard.
			$_SESSION['ECOMMERCE_CURRENCY'] = $row['currency'];
			
			// If optionlist do some cosmetic
			if ($row['product_option']) $brspace = '<br>';
			    
			$JAK_ECOMMERCE_CART[] = $row;
			
			$total = $row["price"] * $row["total"];
			
			$JAK_CHECKOUT_TOTAL += $total;
		
		}
		
		// Get the url session
		$_SESSION['jak_lastURL'] = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_ECOMMERCE, 'checkout', '', '', '');
		
		// Fire the template
		$plugin_template = 'plugins/ecommerce/template/'.$jkv["sitestyle"].'/checkout.php';
	
	break;
	case 'd':
	
		if (is_numeric($page3) && jak_field_not_exist($page2, $jaktable2, 'ordernumber')) {
		
			// First get the information from the order out, if exist keep going
			$row = $jakdb->queryRow('SELECT id, total_price, currency, email, name, userid FROM '.$jaktable2.' WHERE ordernumber = "'.smartsql($page2).'"');
			
			$row_p = $jakdb->queryRow('SELECT field, field1, field2 FROM '.$jaktable1.' WHERE id = "'.smartsql($page3).'"');
			
			if ($jakdb->affected_rows > 0) {
			
			$ecfield = $row_p['field'];
			$ecfield1 = $row_p['field1'];
			$ecprice = $row['total_price'];
			$eccurrency = $row['currency'];
			
			
			if ($page3 == 2) {
				$PAGE_TITLE = $tlec['shop']['m10'];
				$PAGE_CONTENT = $tlec['shop']['m13'];
			} elseif ($page3 == 10) {
				$PAGE_TITLE = $tlec['shop']['m68'];
				$PAGE_CONTENT = $tlec['shop']['m69'];
				
				// Get the keys
				$stripe_key = explode(":#:", $row_p['field2']);
				
				require_once('plugins/ecommerce/payment/stripe/Stripe.php');
				 
				$stripe = array(
				  'secret_key'      => $stripe_key[0],
				  'publishable_key' => $stripe_key[1]
				);
				 
				\Stripe\Stripe::setApiKey($stripe['secret_key']);
				
				// get the currency for stripe
				$stripe_amount = $ecprice * 100;
				
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				
					$token  = $_POST['stripeToken'];
					
					try {
						$charge = \Stripe\Charge::create(array(
						  "amount" => $stripe_amount, // amount in cents, again
						  "currency" => $row['currency'],
						  "card" => $token,
						  "description" => $row['email'])
						);
					
					// Now we forward the client.
					$jakdb->query('UPDATE '.$jaktable2.' SET paid = 1, paidtime = NOW() WHERE id = "'.smartsql($row['id']).'"');
					
					// Send email to administrator
					// log for manual investigation
					$maila = new PHPMailer(); // defaults to using php "mail()"
					$maila->SetFrom($row['email'], $row['name']);
					$maila->AddAddress($jkv["shopemail"], $jkv["e_title"]);
					$maila->Subject = $jkv["e_title"].' - Stripe Success';
					$maila->Body = 'There is a new payment thru Stripe, order number: '.$page2.' - Paid Stripe - '.$ecprice.' - '.$eccurrency.' - '.$row['email'];
					$maila->Send(); // Send email without any warnings
					
					// Send Email to customer
					$mail = new PHPMailer(); // defaults to using php "mail()"
						$body = str_ireplace("[\]", '', $jkv["e_thanks"].'<p>Order Number:'.$page2.'</p>');
					$mail->SetFrom($jkv["shopemail"], $jkv["e_title"]);
					$mail->AddAddress($row['email'], $row['name']);
					$mail->Subject = $jkv["title"].' - Payment approved';
					$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
					$mail->MsgHTML($body);
					$mail->Send(); // Send email without any warnings
					
					// Now let's update the usergroup
					$rowu = $jakdb->queryRow('SELECT t2.id, t2.usergroup FROM '.DB_PREFIX.'shop_order_details AS t1 LEFT JOIN '.DB_PREFIX.'shop AS t2 ON (t1.shopid = t2.id) WHERE t1.orderid = "'.smartsql($row['id']).'" AND t2.usergroup != 0 GROUP BY t1.shopid LIMIT 1');
					
					if ($jakdb->affected_rows === 1) {
						
						$jakdb->query('UPDATE '.DB_PREFIX.'user SET usergroupid = "'.smartsql($rowu["usergroup"]).'" WHERE id = "'.smartsql($row['userid']).'"');
					
					}
					
					// Now let's send the digital files if there are any
					$row_option = $jakdb->queryRow('SELECT t2.title, t2.digital_file, t2.id FROM '.DB_PREFIX.'shop_order_details AS t1 LEFT JOIN '.DB_PREFIX.'shop AS t2 ON (t1.shopid = t2.id) WHERE t1.orderid = "'.smartsql($row['id']).'" AND t2.digital_file != "" GROUP BY t1.shopid LIMIT 1');
					
					// we have a digital file
					if ($jakdb->affected_rows === 1) {
										
						$downloadid = time();
											
						$jakdb->query('UPDATE '.DB_PREFIX.'shop_order SET 
						downloadid = "'.smartsql($downloadid).'",
						downloadtime = ADDDATE(NOW(), INTERVAL 7 DAY)
						WHERE id = "'.smartsql($row['id']).'"');
												
						// Create download link
						$download_link = '<p>'.$jkv["e_shop_download_b"].' <a href="'.(JAK_USE_APACHE ? substr(BASE_URL, 0, -1) : BASE_URL).JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_ECOMMERCE, 'dl', $page2, $row_option['id'], $downloadid).'">'.$jkv["e_shop_download_bt"].'</a></p>';
						
						$body = '<body style="margin:10px;">
						<div style="width:750px; font-family: \'Droid Serif\', Helvetica, Arial, sans-serif; font-size: 14px;">
						<div align="center"><img src="'.(JAK_USE_APACHE ? substr(BASE_URL, 0, -1) : BASE_URL).'/plugins/ecommerce/img/header.jpg" style="height: 90px; width: 750px"></div>
						<p>
						'.$jkv["e_shop_download"].'
						</p>
						'.$download_link.'
						<p>'.$jkv["title"].'</p>
						</div>
						</body>';
											
						$mailf = new PHPMailer(); // defaults to using php "mail()"
						$bodyf = str_ireplace("[\]",'',$body);
						
						if ($jkv["shopemail"]) {
						   	$mailf->SetFrom($jkv["shopemail"], $jkv["e_title"]);
						} else {
							$mailf->SetFrom($jkv["email"], $jkv["title"]);
						}
						
						$mailf->AddAddress($row['email'], $row['name']);
						$mailf->Subject = $jkv["title"].' - Digital File(s) - '.$row_option['title'];
						$mailf->AltBody = 'To view the message, please use an HTML compatible email viewer!';
						$mailf->MsgHTML($bodyf);
						
						if ($mailf->Send()) {
						
							$maila1 = new PHPMailer(); // defaults to using php "mail()"
							$maila1->SetFrom($jkv["shopemail"], $jkv["e_title"]);
							$maila1->AddReplyTo($row['email'], $row['name']);
							$maila1->AddAddress($jkv["shopemail"], $jkv["e_title"]);
							$maila1->Subject = $jkv["e_title"].' - PAYPAL Success - Digital File(s)';
							$maila1->Body = 'Link has been sent...';
							$maila1->Send(); // Send email without any warnings
						
						}
						    
					}
					
					jak_redirect(html_entity_decode(JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_ECOMMERCE, 'success', '', '', '')));
					
					} catch(\Stripe\Error\Card $e) {
						jak_redirect(html_entity_decode(JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_ECOMMERCE, 'error', '', '', '')));
					}
					
				}
				
			} else {
				$PAGE_TITLE = $tlec['shop']['m12'];
				$PAGE_CONTENT = $tlec['shop']['m8'];
			}
			
			// get the standard template
			$plugin_template = 'plugins/ecommerce/template/'.$jkv["sitestyle"].'/notify.php';
			
		} else {
			jak_redirect(BASE_URL);
		}
		
		} else {
			jak_redirect(BASE_URL);
		}
	
	break;
	case 'error':
		
		$PAGE_TITLE = $tlec['shop']['m15'];
		$PAGE_CONTENT = $tlec['shop']['m16'];
				
		// get the standard template
		$plugin_template = 'plugins/ecommerce/template/'.$jkv["sitestyle"].'/notify.php';
		
	break;
	case 'success':
		
		$PAGE_TITLE = $tlec['shop']['m17'];
		$PAGE_CONTENT = $tlec['shop']['m18'];
				
		// get the standard template
		$plugin_template = 'plugins/ecommerce/template/'.$jkv["sitestyle"].'/notify.php';
		
	break;
	case 'dl':
		
		if (!is_numeric($page3) && !is_numeric($page4)) jak_redirect($backtoshop);
		
		// stop the countdown
		$countdown = true;
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		
		// stop the countdown
		$countdown = false;
		
		// check if this product exist
		if (jak_row_exist($page3, $jaktable)) {
		
		$result = $jakdb->query('SELECT t3.title, t3.digital_file FROM '.$jaktable2.' AS t1 LEFT JOIN '.$jaktable5.' AS t2 ON (t1.id = t2.orderid) LEFT JOIN '.$jaktable.' AS t3 ON (t2.shopid = t3.id) WHERE t1.downloadid = "'.smartsql($page4).'" AND t1.downloadtime >= NOW() GROUP BY t2.shopid');
		
		if ($jakdb->affected_rows > 0) {
		
			// We sabotage the cache directory for temporaring saving the file! :)
			$zipFile = APP_PATH.JAK_FILES_DIRECTORY.'/digital_goods_'.time().'.zip';
			
			// Start the ZipArchive
			$zip = new ZipArchive;
			
			// This is a feature we do need, turn it off otherwise it won't work!
			ini_set('zlib.output_compression', 'Off');
			
			if ($zip->open($zipFile, ZIPARCHIVE::CREATE) === TRUE) {
			
				$zip->addFromString('index.html', $jkv["title"]);
		
				while ($row = $result->fetch_assoc()) {
				
					// get the directory, we use the name
					$dlfolder = JAK_base::jakCleanurl($row['title']);
					
						if($zip->addEmptyDir($dlfolder)) {
							if (file_exists($row['digital_file'])) {
								// Add files to the zip archive
								$zip->addFile($row['digital_file'], $dlfolder.'/'.basename($row['digital_file']));
						}
					}
				}
			
			}
			
			// Close the zipArchive
			$zip->close();
			
			if (file_exists($zipFile)) {
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename='.basename($zipFile));
				header('Content-Transfer-Encoding: binary');
				header('Expires: 0');
			    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Pragma: public');
				header('Content-Length: ' . filesize($zipFile));
				readfile($zipFile);
				if (file_exists($zipFile)) unlink($zipFile);
			}
				
		} else {
			jak_redirect($backtoshop);
		}
		
		} else {
			jak_redirect($backtoshop);
		}
		
		}
		
		$PAGE_TITLE = $tlec['shop']['m59'];
		
		// Get the url session
		$_SESSION['jak_lastURL'] = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_ECOMMERCE, '', '', '', '');
		
		// get the standard template
		$plugin_template = 'plugins/ecommerce/template/'.$jkv["sitestyle"].'/download.php';
		
	break;
	case 'dashboard':
	
		if (JAK_USERID) {
		
			$JAK_ORDERS = array();
			$result = $jakdb->query('SELECT id, paidtime, time, ordernumber, paid, paidtime FROM '.$jaktable2.' WHERE userid = "'.smartsql(JAK_USERID).'" ORDER BY time DESC');
			while ($row = $result->fetch_assoc()) {
			
				if (!empty($row['paidtime'])) {
					$paidtime = $row['paidtime'];
				} else {
					$paidtime = '';
				}
				
				// Get the invoice url
				$invoiceurl = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_ECOMMERCE, 'invoice', JAK_USERID, $row["id"]);
				
			    $JAK_ORDERS[] = array('id' => $row['id'], 'ordertime' => $row['time'], 'ordernumber' => $row['ordernumber'], 'paid' => $row['paid'], 'paidtime' => $row['paidtime'], 'invoice' => $invoiceurl);
			}
			
			// Get the navbar
			$JAK_SHOP_CAT = JAK_Base::jakGetcatmix(JAK_PLUGIN_VAR_ECOMMERCE, '', $jaktable7, JAK_USERGROUPID, $jkv["shopurl"]);
		
			// Check if we have a language and display the right stuff
			$PAGE_TITLE = $tlec['shop']['m71'];
			
			// Get the url session
			$_SESSION['jak_lastURL'] = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_ECOMMERCE, 'dashboard', '', '', '');
			
			$JAK_FOOTER_JAVASCRIPT = '<script type="text/javascript">
			jakWeb.jak_quickedit = "'.$tlec["shop"]["m79"].'";
			</script>';
		
			// get the standard template
			$plugin_template = 'plugins/ecommerce/template/'.$jkv["sitestyle"].'/dashboard.php';
		
		} else {
			jak_redirect($backtoshop);
		}
		
	break;
	case 'invoice':
	
		if (JAK_USERID && is_numeric($page2) && JAK_USERID == $page2) {
		
			$row = $jakdb->queryRow('SELECT * FROM '.$jaktable2.' WHERE id = "'.smartsql($page3).'"');
			
			if ($row["userid"] == JAK_USERID && $row["paid"] == 1) {
			
				$result_option = $jakdb->query('SELECT COUNT(id) AS total_item, title, product_option, price, coupon_price FROM '.$jaktable5.' WHERE orderid = '.$row['id'].' GROUP BY product_option, shopid ORDER BY price ASC');
				
				while ($row_option = $result_option->fetch_assoc()) {
				
					$row_option['price'] = $row_option['total_item'] * $row_option['price'];
					
				    $jak_ordered[] = array('title' => $row_option['title'], 'product_option' => $row_option['product_option'], 'price' => number_format($row_option['price'], 2, '.', ''), 'coupon_price' => number_format($row_option['coupon_price'], 2, '.', ''), 'total_item' => $row_option['total_item']);
				}
				
				// Get the right Country
				$JAK_COUNTRY = getCountryInvoice('', $row['country']);
				$JAK_SHCOUNTRY = getCountryInvoice('', $row['sh_country']);
		
				// Call the template
				$plugin_template = 'plugins/ecommerce/template/invoice.php';
				
			} else {
				jak_redirect($backtoshop);
			}
		
		} else {
			jak_redirect($backtoshop);
		}
	
	break;
	default:
	
			$getTotal = jak_get_total($jaktable, '', '', 'active');
			
			if ($getTotal != 0) {
				
				// Paginator
				$ecitem = new JAK_Paginator;
				$ecitem->items_total = $getTotal;
				$ecitem->mid_range = $jkv["shoppagemid"];
				$ecitem->items_per_page = $jkv["shoppageitem"];
				$ecitem->jak_get_page = $page1;
				$ecitem->jak_where = $backtoshop;
				$ecitem->jak_prevtext = $tl["general"]["g171"];
				$ecitem->jak_nexttext = $tl["general"]["g172"];
				$ecitem->paginate();
				$JAK_PAGINATE = $ecitem->display_pages();
	
				$result = $jakdb->query('SELECT t1.id, t1.catid, t1.title, t1.previmg, t1.img, t1.price, t1.sale, t1.product_options, t1.product_options1, t1.product_options2, t2.varname FROM '.$jaktable.' AS t1 LEFT JOIN '.$jaktable7.' AS t2 ON (t1.catid = t2.id) WHERE t1.active = 1 ORDER BY t1.ecorder ASC '.$ecitem->limit);
				while ($row = $result->fetch_assoc()) {
				
					$seo = '';
					$onsale = 0;
					
					$shop_option = $row['product_options'];
					$shop_option2 = $row['product_options1'];
					$shop_option3 = $row['product_options2'];
					
					if (!$shop_option) {
						$shop_option = $row['product_options'];
					}
					
					if (!$shop_option2) {
						$shop_option2 = $row['product_options1'];
					}
					
					if (!$shop_option3) {
						$shop_option3 = $row['product_options2'];
					}
				
					if ($jkv["shopurl"]) {
						$seo = JAK_base::jakCleanurl($row['title']);
					}
						
					if ($row['sale'] != "0.00") $onsale = 1;
					
					if ($_SESSION['ECOMMERCE_CURRENCY'] != $jkv["e_currency"]) {
					
						$row['price'] = $convert->Convert($row['price'], $_SESSION['ECOMMERCE_CURRENCY']);
						if ($onsale) $row['sale'] = $convert->Convert($row['sale'], $_SESSION['ECOMMERCE_CURRENCY']);
					}
					
					$imge = '/plugins/ecommerce/img/no_product_photo.png';
					if ($row['previmg']) $imge = $row['previmg'];
					
					$catname = 'all';
					if ($row['catid']) $catname = $row['varname'];
					
					// There should be always a varname in categories and check if seo is valid
					$parseurl = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_ECOMMERCE, 'i', $row['id'], $seo, '');
					
					$seokeywords[] = JAK_Base::jakCleanurl($row['title']);
					
					// collect each record into $jakdata
					$JAK_ECOMMERCE_ALL[] = array('id' => $row['id'], 'title' => $row['title'], 'previmg' => $imge, 'img' => $row['img'], 'parseurl' => $parseurl, 'price' => $row['price'], 'sale' => $row['sale'], 'product_options' => $shop_option, 'product_options1' => $shop_option2, 'product_options2' => $shop_option3, 'onsale' => $onsale, 'catname' => $row['varname']);
				}
				
			}
			
			// Check if we have a language and display the right stuff
			$PAGE_TITLE = $jkv["e_title"];
			$PAGE_CONTENT = $jkv["e_desc"];
			
			$PAGE_SHOWTITLE = 1;
			
			// Get the sort orders for the grid
			$grid = $jakdb->query('SELECT id, hookid, pluginid, whatid, orderid FROM '.DB_PREFIX.'pagesgrid WHERE plugin = '.JAK_PLUGIN_ID_ECOMMERCE.' ORDER BY orderid ASC');
			while ($grow = $grid->fetch_assoc()) {
			        // collect each record into $pagegrid
			        	$JAK_HOOK_SIDE_GRID[] = $grow;
			}
			
			$JAK_SHOP_CAT = JAK_Base::jakGetcatmix(JAK_PLUGIN_VAR_ECOMMERCE, '', $jaktable7, JAK_USERGROUPID, $jkv["shopurl"]);
			
			// Now get the new meta keywords and description maker
			if (!empty($seokeywords)) $keylist = join(",", $seokeywords);
			
			$PAGE_KEYWORDS = str_replace(" ", "", JAK_Base::jakCleanurl($PAGE_TITLE).($keylist ? ",".$keylist : "").($jkv["metakey"] ? ",".$jkv["metakey"] : ""));
			// SEO from the category content if available
			if (!empty($ca['content'])) {
				$PAGE_DESCRIPTION = jak_cut_text($ca['content'], 155, '');
			} else {
				$PAGE_DESCRIPTION = jak_cut_text($PAGE_CONTENT, 155, '');
			}
			
			// get the standard template
			$plugin_template = 'plugins/ecommerce/template/'.$jkv["sitestyle"].'/shop.php';
			
}
?>