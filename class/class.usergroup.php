<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

class JAK_usergroup
{
	private $data;
	private $jakvar = 0;
	
	public function __construct($row)
	{
		/*
		/	The constructor
		*/
		
		$this->data = $row;
	}
	
	function getVar($jakvar)
	{
		// Setting up an alias, so we don't have to write $this->data every time:
		$d = $this->data;
		
		if (!empty($d[$jakvar])) return $d[$jakvar];
		
	}

}
?>