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


if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) die("Nothing to see here");

$csCode = strip_tags($_POST['coupon']);

if (!preg_match('/^([0-9]||[a-z]||[A-Z])+$/', $csCode)) die(json_encode(array("status" => 0, "html" => '<div class="alert-danger alert-link">'.$_POST['shopmsg2'].'</div>')));
	
if ($_POST['action'] == "checkC") {	
			
	// Get the coupons out the database
	$result = $jakdb->query('SELECT type, discount, freeshipping, products, usergroup FROM '.DB_PREFIX.'shop_coupon WHERE code = "'.smartsql($csCode).'" AND status = 1 AND (datestart < "'.time().'" AND dateend > "'.time().'" OR datestart = 0 AND dateend = 0) AND used < total LIMIT 1');
	
	if ($jakdb->affected_rows > 0) {
	
		$row = $result->fetch_assoc();
	
		if ($row['usergroup'] != 0) {
			$sqlusergrouparray = explode(',', $row['usergroup']);
			$checkthru = in_array($usergroupid, $sqlusergrouparray);
		} else {
			$checkthru = true;
		}
			
		if ($checkthru && (!empty($row['discount']) || $row['freeshipping'] == 1)) {
		
			// Let's check if there is any product in the discount
			if ($row['products'] == 0) {
				$sqlwhere = '';
			} elseif (is_numeric($row['products'])) {
				$sqlwhere = ' AND t1.shopid = '.$row['products'].'';
			} else {
				$sqlwhere = ' AND t1.shopid IN('.$row['products'].')';
			}
			
			$result1 = $jakdb->query('SELECT t1.shopid, t2.title, t1.price FROM '.DB_PREFIX.'shopping_cart AS t1 LEFT JOIN '.DB_PREFIX.'shop AS t2 ON(t1.shopid = t2.id) WHERE t1.session = "'.smartsql($_SESSION['shopping_cart']).'"'.$sqlwhere);
			
			if ($jakdb->affected_rows > 0) {
		
				if ($row['freeshipping'] == 1) {
					$fsT = $_POST['shopmsg1'];
				}
				// Check discount type (type1 = percentage)
				if ($row['type'] == 1) {
					$dtT = '%';
					
					while ($row1 = $result1->fetch_assoc()) {
					
						// Get the discount before taxes
						$totalD = $row1['price'] / 100 * $row['discount'];
						
						// Discount total
						$discT += $totalD;
						
						$totalB = $row1['price'] - round($totalD, 1);
						
						// Shop taxes, well start counting
						if ($jkv["e_taxes"]) {
							$taxTotal = $totalB / 100 * $jkv["e_taxes"];
							$totalB = $totalB + round($taxTotal, 1);
						}
						
						$sumT += $totalB;
					}
					    
				} else {
				
					while ($row1 = $result1->fetch_assoc()) {
					
						$discT += $row['discount'];
					
						// Get the discount before taxes
						$totalB = $row1['price'] - $row['discount'];
						
						// Shop taxes, well start counting
						if ($jkv["e_taxes"]) {
							$taxTotal = $totalB / 100 * $jkv["e_taxes"];
							$totalB = $totalB + round($taxTotal, 1);
						}
						
						$sumT += $totalB;
					}
					    
				}
				die(json_encode(array("status" => 1, "html" => '<div class="alert-success alert-link">'.sprintf($_POST['shopmsg'],$row['discount'].$dtT).'</div>', "total" => number_format($sumT, 2, '.', ''), "discount" => number_format($discT, 2, '.', '').' '.$_SESSION['ECOMMERCE_CURRENCY'], "shipping" => $fsT)));
			}
		}
	}
}
die(json_encode(array("status" => 0, "html" => '<div class="alert-danger alert-link">'.$_POST['shopmsg2'].'</div>')));

?>