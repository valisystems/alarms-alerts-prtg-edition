<?php

/*===============================================*\
|| ############################################# ||
|| # Claricom.ca                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Check if the file is accessed only via index.php if not stop the script from running
if(!defined('JAK_PREVENT_ACCESS')) die('No direct access!');

// Functions we need for this plugin
include_once 'functions.php';

// Get the database table
$jaktable = DB_PREFIX.'cdr';

// Get the CSS and Javascript into the page
$JAK_HEADER_CSS = $jkv["dev_css"];
$JAK_FOOTER_JAVASCRIPT = $jkv["dev_javascript"];

// p is $page and sp is page1
switch ($page1)
{
	case 'insert':
		include 'classes/class.cdr.php';
		$cdrObj = new CDR();
		if (file_get_contents("php://input"))
		{
			$data = json_decode(file_get_contents("php://input"), true);
			if($data["call-data-record"])
			{
				unset($data["call-data-record"]);
				$cdrObj->insert($data);
			}
		}
		$plugin_template = 'plugins/cdr/template/'.$jkv["sitestyle"].'/json.php';
	break;

	default:
		include 'classes/class.cdr.php';
		$cdrObj = new CDR();

		$PAGE_CONTENT = "CDR Listing";

		$cdrListing = $cdrObj->getAll();
		$plugin_template = 'plugins/cdr/template/'.$jkv["sitestyle"].'/cdr.php';
	break;
}

