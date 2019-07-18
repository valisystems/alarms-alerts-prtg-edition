<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

if (!file_exists('../../../config.php')) {
    die('[ipn.php] config.php not exist');
}
require_once '../../../config.php';

// Include the paypal library
include_once ('twoco.php');

// Create an instance of the authorize.net library
$my2CO = new TwoCo();

// Log the IPN results
$my2CO->ipnLog = TRUE;

// First get the paypal address out, if exist keep going
global $jakdb;
$result = $jakdb->query('SELECT field1, field2 FROM '.DB_PREFIX.'shoppayment WHERE id = 5 AND status = 1 LIMIT 1');
$row = $result->fetch_assoc();

// Specify your authorize login and secret
$my2CO->setSecret(base64_decode($row['field2']));

// Enable test mode if needed
//$my2CO->enableTestMode();

// Check validity and write down it
if ($my2CO->validateIpn())
{
    
    $item_name = base64_decode($my2CO->ipnData['custom']);
    $payment_currency = $my2CO->ipnData['tco_currency'];
    $payment_status = $my2CO->ipnData['invoice_status'];
    $txn_id = $my2CO->ipnData['vendor_order_id'];
    $payment_amount = $my2CO->ipnData['total'];
    $payer_email = $my2CO->ipnData['vendor_id'];
    $custom = base64_decode($my2CO->ipnData['order_number']);
    
    $customA = explode(":#:", $item_name);
    
    // check that payment_amount/payment_currency are correct
    global $jakdb;
    
    // process payment
    $result = $jakdb->query('INSERT INTO '.DB_PREFIX.'shop_payment_ipn SET 
    ordernr = "'.smartsql($customA[1]).'",
    time = NOW(),
    status = "'.smartsql($payment_status).'",
    amount = "'.smartsql($payment_amount).'",
    currency = "'.smartsql($payment_currency).'",
    txn_id = "'.smartsql($txn_id).'",
    receiver_email = "'.smartsql($receiver_email).'",
    payer_email = "'.smartsql($payer_email).'",
    paid_with = "2CheckOut"');
    
    // check that txn_id has not been previously processed
    $jakdb->query('SELECT id FROM '.DB_PREFIX.'shop_payment_ipn WHERE txn_id = "'.smartsql($txn_id).'"');
    if ($jakdb->affected_rows == 1) {
    
    	// Select price and item
    	$result1 = $jakdb->query('SELECT id, total_price, email, name, userid FROM '.DB_PREFIX.'shop_order WHERE id = "'.smartsql($customA[0]).'" AND ordernumber = "'.smartsql($customA[1]).'"');
    	$row1 = $result1->fetch_assoc();
    		
    if ($row1['total_price'] == $payment_amount) {
    
    	$sendmail = 1;
    	
    	$jakdb->query('UPDATE '.DB_PREFIX.'shop_order SET paid = 1, paidtime = NOW() WHERE id = "'.smartsql($row1['id']).'"');
    	
    }
           
    // Send email to customer if everything is paid
       if ($sendmail) {
       
       		// Send email to administrator
       		// log for manual investigation
       		$maila = new PHPMailer(); // defaults to using php "mail()"
       		$maila->SetFrom($payer_email, $payer_email);
       		$maila->AddAddress($jkv["shopemail"], $jkv["e_title"]);
       		$maila->Subject = $jkv["e_title"].' - 2Checkout Success';
       		$maila->Body = 'There is a new payment thru 2Checkout, order number: '.$customA[1].' - '.$item_name.' - '.$payment_status.' - '.$payment_amount.' - '.$payment_currency.' - '.$txn_id.' - '.$payer_email;
       		$maila->Send(); // Send email without any warnings
       		
       		// Send Email to customer
       		$mail = new PHPMailer(); // defaults to using php "mail()"
       		$body = str_ireplace("[\]", '', $jkv["e_thanks"].'<p>Order Number:'.$customA[1].'</p>');
       		$mail->SetFrom($jkv["shopemail"], $jkv["e_title"]);
       		$mail->AddAddress($payer_email, $customer);
       		$mail->Subject = $jkv["title"].' - Payment approved';
       		$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
       		$mail->MsgHTML($body);
       		$mail->Send(); // Send email without any warnings
       		
       		// Now let's update the usergroup
       		$result_ugroup = $jakdb->query('SELECT t2.id, t2.usergroup FROM '.DB_PREFIX.'shop_order_details AS t1 LEFT JOIN '.DB_PREFIX.'shop AS t2 ON (t1.shopid = t2.id) WHERE t1.orderid = "'.$row1['id'].'" AND t2.usergroup != 0 GROUP BY t1.shopid LIMIT 1');
       		
       		if ($jakdb->affected_rows > 0) {
       		
       			$rowu = $result_ugroup->fetch_assoc();
       			
       			$jakdb->query('UPDATE '.DB_PREFIX.'user SET 
       				usergroupid = "'.smartsql($rowu["usergroup"]).'",
       				WHERE id = "'.smartsql($row1['userid']).'"');
       		
       		}
       		
       		// Now let's send the digital files if there are any
       		$result_option = $jakdb->query('SELECT t2.title, t2.digital_file, t2.id FROM '.DB_PREFIX.'shop_order_details AS t1 LEFT JOIN '.DB_PREFIX.'shop AS t2 ON (t1.shopid = t2.id) WHERE t1.orderid = "'.$row1['id'].'" AND t2.digital_file != "" GROUP BY t1.shopid LIMIT 1');
       		
       		// we have a digital file
       		if ($jakdb->affected_rows > 0) {
       						
       			$row_option = $result_option->fetch_assoc();
       							
       			$downloadid = time();
       								
       			$jakdb->query('UPDATE '.DB_PREFIX.'shop_order SET 
       				downloadid = "'.smartsql($downloadid).'",
       				downloadtime = ADDDATE(NOW(), INTERVAL 7 DAY)
       				WHERE id = "'.smartsql($row1['id']).'"');
       									
       			// Create download link
       			$download_link = '<p>'.$jkv["e_shop_download_b"].' <a href="'.(JAK_USE_APACHE ? substr(str_replace('plugins/ecommerce/payment/', '', BASE_URL), 0, -1) : str_replace('plugins/ecommerce/payment/', '', BASE_URL)).JAK_rewrite::jakParseurl($customA[3], 'dl', $customA[1], $row_option['id'], $downloadid).'">'.$jkv["e_shop_download_bt"].'</a></p>';
       			
       			$body = '<body style="margin:10px;">
       			<div style="width:750px; font-family: \'Droid Serif\', Helvetica, Arial, sans-serif; font-size: 14px;">
       			<div align="center"><img src="'.str_replace('payment/', '', BASE_URL).'img/header.jpg" style="height: 90px; width: 750px"></div>
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
       			
       			$mailf->AddAddress($row1['email'], $row1['name']);
       			$mailf->Subject = $jkv["title"].' - Digital File(s) - '.$row_option['title'];
       			$mailf->AltBody = 'To view the message, please use an HTML compatible email viewer!';
       			$mailf->MsgHTML($bodyf);
       			
       			if ($mailf->Send()) {
       			
       				$maila1 = new PHPMailer(); // defaults to using php "mail()"
       				$maila1->SetFrom($jkv["shopemail"], $jkv["e_title"]);
       				$maila1->AddReplyTo($row1['email'], $row1['name']);
       				$maila1->AddAddress($jkv["shopemail"], $jkv["e_title"]);
       				$maila1->Subject = $jkv["e_title"].' - 2CheckOut Success - Digital File(s)';
       				$maila1->Body = 'File(s) has been sent...';
       				$maila1->Send(); // Send email without any warnings
       			
       			}
       			    
       		}
       		
       	} else {
       	
       		// log for manual investigation amount is not the same
       		$mail = new PHPMailer(); // defaults to using php "mail()"
       		$mail->SetFrom($payer_email, $payer_email);
       		$mail->AddAddress($jkv["shopemail"], JAK_e_TITLE);
       		$mail->Subject = $jkv["title"].' - 2Checkout Success, but...';
       		$mail->Body = 'There is a new payment thru 2Checkout, order number: '.$customA[1].' - '.$item_name.' - '.$payment_status.' - '.$payment_amount.' - '.$payment_currency.' - '.$txn_id.' - '.$payer_email.' But the amount was paid is not the same amount was ordered, please check in the shopping order details';
       		$mail->Send(); // Send email without any warnings
       	
       	}
       	
       	// Finally Delete the shopping Cart
       	$jakdb->query('DELETE FROM '.DB_PREFIX.'shopping_cart WHERE session = "'.smartsql($customA[2]).'"');
       	
    }

} else {
	
	// log for manual investigation
	$mail = new PHPMailer(); // defaults to using php "mail()"
	$mail->SetFrom($payer_email, '2CheckOut HTTP error');
	$mail->AddAddress($jkv["shopemail"], $jkv["title"]);
	$mail->Subject = $jkv["title"].' - 2CheckOut HTTP error';
	$mail->Body = 'There is an error with 2CheckOut, please check the text file.';
	
    file_put_contents('2co.txt', "FAILURE\n\n" . $my2CO->ipnData);
}
?>