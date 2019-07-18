<?php

/**
 * Payza Class
 *
 * Integrate the Payza payment gateway in your site using this easy
 * to use library. Just see the example code to know how you should
 * proceed. Btw, this library does not support the recurring payment
 * system. If you need that, drop me a note and I will send to you.
 *
 * @package		Payment Gateway
 * @category	Library
 * @author      Jerome Kaegi
 * @link        http://www.claricom.ca
 */

include_once ('PaymentGateway.php');

class Payza extends PaymentGateway
{

    /**
	 * Initialize the Paypal gateway
	 *
	 * @param none
	 * @return void
	 */
	public function __construct()
	{
        parent::__construct();

        // Some default values of the class
		$this->gatewayUrl = 'https://secure.payza.com/checkout';
		$this->ipnLogFile = 'payza.ipn_results.log';
		
	}

    /**
     * Enables the test mode
     *
     * @param none
     * @return none
     */
    public function enableTestMode()
    {
        $this->testMode = TRUE;
        $this->gatewayUrl = 'https://www.sandbox.payza.com';
    }
    
    /**
    	 * Validate the IPN notification
    	 *
    	 * @param none
    	 * @return boolean
    	 */
    	public function validateIpn()
    	{
    	
    		//The value is the url address of IPN V2 handler and the identifier of the token string 
    		define("IPN_V2_HANDLER", "https://secure.payza.com/ipn2.ashx");
    		define("TOKEN_IDENTIFIER", "token=");
    			
    		// get the token from Alertpay
    		$token = urlencode($_POST['token']);
    		
    		//preappend the identifier string "token=" 
    		$token = TOKEN_IDENTIFIER.$token;
    			
    		/**
    		 * 
    			 * Sends the URL encoded TOKEN string to the Alertpay's IPN handler
    			 * using cURL and retrieves the response.
    			 * 
    			 * variable $response holds the response string from the Alertpay's IPN V2.
    		*/
    			
    		$response = false;
    			
    		$ch = curl_init();
    		
    		curl_setopt($ch, CURLOPT_URL, IPN_V2_HANDLER);
    		curl_setopt($ch, CURLOPT_POST, true);
    		curl_setopt($ch, CURLOPT_POSTFIELDS, $token);
    		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    		curl_setopt($ch, CURLOPT_HEADER, false);
    		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    		
    		$response = curl_exec($ch);
    		
    		return $response;
    		
    		curl_close($ch);
    	}
}