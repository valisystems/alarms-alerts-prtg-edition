<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Check if the file is accessed only via index.php if not stop the script from running
if (!defined('JAK_ADMIN_PREVENT_ACCESS')) die('You cannot access this file directly.');

// Check if the user has access to this file
if (!JAK_USERID || !$JAK_MODULES) jak_redirect(BASE_URL);

// All the tables we need for this plugin
$jaktable = DB_PREFIX.'searchlog';

$JAK_SEARCHLOG_ALL = "";

// Important template Stuff
$getTotal = jak_get_total($jaktable, '', '', '');
if ($getTotal != 0) {
	// Paginator
	$pages = new JAK_Paginator;
	$pages->items_total = $getTotal;
	$pages->mid_range = $jkv["adminpagemid"];
	$pages->items_per_page = $jkv["adminpageitem"];
	$pages->jak_get_page = $page1;
	$pages->jak_where = 'index.php?p=searchlog';
	$pages->paginate();
	$JAK_PAGINATE = $pages->display_pages();
	
	$JAK_SEARCHLOG_ALL = jak_get_page_info($jaktable, $pages->limit, '');
}

// Let's go on with the script
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $defaults = $_POST;
    
    if (isset($defaults['delete'])) {
    
    $lockuser = $defaults['jak_delete_search'];

        for ($i = 0; $i < count($lockuser); $i++) {
            $locked = $lockuser[$i];
            
        	$result = $jakdb->query('DELETE FROM '.$jaktable.' WHERE id = "'.smartsql($locked).'"');
        	
        }
  
 	if (!$result) {
		jak_redirect(BASE_URL.'index.php?p=searchlog&sp=e');
	} else {
        jak_redirect(BASE_URL.'index.php?p=searchlog&sp=s');
    }
    
    }

    
 }
 
 switch ($page1) {
    case 'delete':
        $result = $jakdb->query('DELETE FROM '.$jaktable.' WHERE id = "'.smartsql($page2).'"');
		
	if (!$result) {
    	jak_redirect(BASE_URL.'index.php?p=searchlog&sp=e');
	} else {
        jak_redirect(BASE_URL.'index.php?p=searchlog&sp=s');
    } 
   	break;
   	case 'truncate':
   	    $result = $jakdb->query('TRUNCATE '.$jaktable);
   		
   	if (!$result) {
   		jak_redirect(BASE_URL.'index.php?p=searchlog&sp=e');
   	} else {
   	    jak_redirect(BASE_URL.'index.php?p=searchlog&sp=s');
   	} 
   	break;
	default:
		
		// Title and Description
		$SECTION_TITLE = $tl["cmenu"]["c49"];
		$SECTION_DESC = $tl["cmdesc"]["d45"];
		
		// Call the template
		$template = 'searchlog.php';
	}
?>