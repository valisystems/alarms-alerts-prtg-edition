<?php

/**
 * Skrill Class
 *
 * Integrate the Skrill payment gateway in your site using this easy
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

class Skrill extends PaymentGateway
{

    /**
	 * Initialize the Skrill gateway
	 *
	 * @param none
	 * @return void
	 */
	public function __construct()
	{
        parent::__construct();

        // Some default values of the class
		$this->gatewayUrl = 'https://www.moneybookers.com/app/payment.pl';
		$this->ipnLogFile = 'skrill.ipn_results.log';
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
	    $this->gatewayUrl = 'http://www.moneybookers.com/app/test_payment.pl';
	}
	
	/**
		 * Validate the IPN notification
		 *
		 * @param none
		 * @return boolean
		 */
		public function validateIpn()
		{
			// parse the skrill URL
			$urlParsed = parse_url($this->gatewayUrl);
	
			// Not much to do with moneybookers
		}
}
