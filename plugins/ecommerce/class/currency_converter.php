<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

class JAK_CurrencyC {

	var $exchange_rates = array();
	
	function CurrencyConverter() {
	
		global $jkv;
	
		$currency_array = array('1' => $jkv["e_currency"]);
		
		if ($jkv["e_currency1"]) {
			
			// Currency Two
			$currency_two = explode('/', $jkv["e_currency1"]);
			
			$currency_array1 = array($currency_two[1] => $currency_two[0]);
			
			$this->exchange_rates = @array_merge($currency_array, $currency_array1);
		}
		
		// Create a array with all three currency
		if ($jkv["e_currency2"]) {	
				
			// Currency Three
			$currency_three = explode('/', $jkv["e_currency2"]);
			
			$currency_array2 = array($currency_three[1] => $currency_three[0]);
			
			$this->exchange_rates = @array_merge($currency_array, $currency_array1, $currency_array2);
			
		}
	
	}


	function Convert($amount = 1, $to, $decimals = 2)
	{
		
		$keyto = array_search($to, $this->exchange_rates);
		
		if ($keyto) {
		
			$price = $amount*$keyto;
			
			return(number_format(round($price, 2), $decimals, '.', ''));
			
		} else {
			return false;
		}
	}
	
	function reConvert($amount = 1, $to, $decimals = 2)
	{
		
		$keyto = array_search($to, $this->exchange_rates);
		
		if ($keyto) {
		
			$price = $amount/$keyto;
			
			return(number_format(round($price, 2), $decimals, '.', ''));
			
		} else {
			return false;
		}
	}
	
	function CheckCurrency($input)
	{
		
		if (in_array($input, $this->exchange_rates)) {
			
			return true;
		} else {
		
			return false;
		}
	
	}
	
	function CurrencyChoose()
	{
		
		$d = $this->exchange_rates;
		
		if (is_array($d) && count($d) > 1) {
			
			return array_values($d);
		} else {
		
			return false;
		}
	
	}

}
?>