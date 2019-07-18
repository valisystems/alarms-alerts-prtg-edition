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
include_once ('authorize.php');

// Create an instance of the authorize.net library
$myAuthorize = new Authorize();

// Log the IPN results
$myAuthorize->ipnLog = TRUE;

// First get the paypal address out, if exist keep going
global $jakdb;
$result = $jakdb->query('SELECT field1, field2 FROM '.DB_PREFIX.'shoppayment WHERE id = 6 AND status = 1 LIMIT 1');
$row = $result->fetch_assoc();

// Specify your authorize login and secret
$myAuthorize->setUserInfo(base64_decode($row['field1']), base64_decode($row['field2']));

// Enable test mode if needed
//$myAuthorize->enableTestMode();

// Check validity and write down it
if ($myAuthorize->validateIpn())
{   

	$txn_id = $myAuthorize->ipnData['x_trans_id'];
    $payer_email = $myAuthorize->ipnData['x_email'];
    $payment_amount = $myAuthorize->ipnData['x_amount'];
    $custom = base64_decode($myAuthorize->ipnData['x_invoice_num']);
    
    // Explode custom field with order number and orderid
    $customA = explode(":#:", $custom);
    
    // check that payment_amount/payment_currency are correct
    global $jakdb;
    
    // process payment
    $result = $jakdb->query('INSERT INTO '.DB_PREFIX.'shop_payment_ipn SET 
    ordernr = "'.smartsql($customA[1]).'",
    time = NOW(),
    status = "paid",
    amount = "'.smartsql($payment_amount).'",
    currency = "'.smartsql($_SESSION['ECOMMERCE_CURRENCY']).'",
    txn_id = "'.smartsql($txn_id).'",
    receiver_email = "'.smartsql($receiver_email).'",
    payer_email = "'.smartsql($payer_email).'",
    paid_with = "Authorize"');
    
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
       		$maila->Subject = $jkv["e_title"].' - Authorize Success';
       		$maila->Body = 'There is a new payment thru Authorize, order number: '.$customA[1].' - '.$payment_amount.' - '.JAK_SHOPCURRENCY.' - '.$txn_id.' - '.$payer_email;
       		$maila->Send(); // Send email without any warnings
       		
       		// Send Email to customer
       		$mail = new PHPMailer(); // defaults to using php "mail()"
       		$body = str_ireplace("[\]", '', $jkv["e_thanks"].'<p>Order Number:'.$customA[1].'</p>');
       		$mail->SetFrom($jkv["shopemail"], $jkv["e_title"]);
       		$mail->AddAddress($payer_email, $customer);
       		$mail->Subject = $jkv["title"].' - Payment approved / Bezahlung erhalten';
       		$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
       		$mail->MsgHTML($body);
       		$mail->Send(); // Send email without any warnings
       		
       		// Now let's update the usergroup
       		$rowu = $jakdb->queryRow('SELECT t2.id, t2.usergroup FROM '.DB_PREFIX.'shop_order_details AS t1 LEFT JOIN '.DB_PREFIX.'shop AS t2 ON (t1.shopid = t2.id) WHERE t1.orderid = "'.smartsql($row1['id']).'" AND t2.usergroup != 0 GROUP BY t1.shopid LIMIT 1');
       		
       		if ($jakdb->affected_rows === 1) {
       			
       			$jakdb->query('UPDATE '.DB_PREFIX.'user SET 
       				usergroupid = "'.smartsql($rowu["usergroup"]).'",
       				WHERE id = "'.smartsql($row1['userid']).'"');
       		
       		}
       		
       		// Now let's send the digital files if there are any
       		$row_option = $jakdb->queryRow('SELECT t2.title, t2.digital_file, t2.id FROM '.DB_PREFIX.'shop_order_details AS t1 LEFT JOIN '.DB_PREFIX.'shop AS t2 ON (t1.shopid = t2.id) WHERE t1.orderid = "'.smartsql($row1['id']).'" AND t2.digital_file != "" GROUP BY t1.shopid LIMIT 1');
       		
       		// we have a digital file
       		if ($jakdb->affected_rows === 1) {
       							
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
       				$maila1->Subject = $jkv["e_title"].' - Authorize Success - Digital File(s) Download';
       				$maila1->Body = 'Link has been sent...';
       				$maila1->Send(); // Send email without any warnings
       			
       			}
       			    
       		}
       		
       	} else {
       	
       		// log for manual investigation amount is not the same
       		$mail = new PHPMailer(); // defaults to using php "mail()"
       		$mail->SetFrom($payer_email, $payer_email);
       		$mail->AddAddress($jkv["shopemail"], $jkv["e_title"]);
       		$mail->Subject = $jkv["e_title"].' - Authorize Success, but...';
       		$mail->Body = 'There is a new payment thru Authorize, order number: '.$customA[1].' - '.$payment_amount.' - '.JAK_SHOPCURRENCY.' - '.$txn_id.' - '.$payer_email.' But the amount was paid is not the same amount was ordered, please check in the shopping order details';
       		$mail->Send(); // Send email without any warnings
       	
       	}
       	
       	// Finally Delete the shopping Cart
       	$jakdb->query('DELETE FROM '.DB_PREFIX.'shopping_cart WHERE session = "'.smartsql($customA[2]).'"');
       	
    }
        
} else {

	// log for manual investigation
	$mail = new PHPMailer(); // defaults to using php "mail()"
	$mail->SetFrom($payer_email, 'Authorize HTTP error');
	$mail->AddAddress($jkv["shopemail"], $jkv["title"]);
	$mail->Subject = $jkv["title"].' - Authorize HTTP error';
	$mail->Body = 'There is an error with Authorize, please check the text file.';
}