<?php
/*===============================================*\
|| ############################################# ||
|| # Claricom.ca                               # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 Claricom All Rights Reserved ||
|| ############################################# ||
\*===============================================*/

// Check if the file is accessed only via index.php if not stop the script from running
if (!defined('JAK_ADMIN_PREVENT_ACCESS')) die('You cannot access this file directly.');

// Check if the user has access to this file
if (!JAK_USERID || !$jakuser->jakModuleaccess(JAK_USERID,JAK_ACCESSDEVICE)) jak_redirect(BASE_URL);

// All the tables we need for this plugin
$jaktable = DB_PREFIX.'cdr';
// Include the functions
include_once("../plugins/tts/functions.php");

//JAK_PLUGIN_CDR
include '/../classes/class.cdr.php';
$cdrObj = new CDR();

// Now start with the plugin use a switch to access all pages
switch ($page1) {

	case 'insert':
		if (file_get_contents("php://input"))
		{
			$data = json_decode(file_get_contents("php://input"), true);
			if($data["call-data-record"])
			{
				unset($data["call-data-record"]);
				$cdrObj->insert($data);
			}
		}
	break; // END of catch file CASE
	
	case 'settings':

		$JAK_SETTING = jak_get_setting('cdr');
		
		// Get the special vars for multi language support
		$JAK_FORM_DATA["title"] = $jkv["cdrtitle"];
		$JAK_FORM_DATA["content"] = $jkv["cdrdesc"];

		// Title and Description
		$SECTION_TITLE = $tlcdr["cdr"]["n"].' - '.$tl["menu"]["m2"];
		$SECTION_DESC = $tl["cmdesc"]["d2"];

		// Call the template
		$plugin_template = 'plugins/cdr/admin/template/setting.php';
	break;

	default:
		// Hello we have a post request
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['jak_delete_cdr']))
		{
		    $defaults = $_POST;
		    
		    if (isset($defaults['delete']))
		    {
		    
		    	$lockuser = $defaults['jak_delete_cdr'];
		
		        for ($i = 0; $i < count($lockuser); $i++)
		        {
		            $locked = $lockuser[$i];
					$result = $jakdb->query('DELETE FROM '.$jaktable.' WHERE id = "'.smartsql($locked).'"');
		        }
		  
			 	if (!$result) {
					jak_redirect(BASE_URL.'index.php?p=cdr&sp=e');
				} else {
			        jak_redirect(BASE_URL.'index.php?p=cdr&sp=s');
			    }
		    }
		}

		$sort = !empty($_GET["sort"]) ? $_GET["sort"] : 'id';
		$order = !empty($_GET["order"]) ? $_GET["order"] : 'DESC';
		$page_number = !empty($_GET["page"]) ? $_GET["page"] : 0;

		// get all downloads out
		$getTotal = jak_get_total($jaktable,'','','');

		if ($getTotal != 0)
		{
			// Paginator
			$pages = new JAK_Paginator;
			$pages->items_total = $getTotal;
			$pages->mid_range = $jkv["adminpagemid"];
			$pages->items_per_page = $jkv["adminpageitem"];
			$pages->jak_get_page = $page_number;
			$pages->jak_where = 'index.php?p=cdr&sort='.$sort.'&order='.$order;
			$pages->paginate();
			$JAK_PAGINATE = $pages->display_pages();
		}
		$cdrListing = $cdrObj->getCdrs($jaktable, $sort, $order, $pages->limit);

		$PAGE_CONTENT = "CDR Listing";
		
        $plugin_template = 'plugins/cdr/admin/template/cdr.php';
	break;
}