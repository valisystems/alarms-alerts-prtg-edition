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
if (!JAK_USERID) jak_redirect(BASE_URL);

// If not super admin...
if (!JAK_SUPERADMINACCESS) jak_redirect(BASE_URL_ORIG);

$success = $errors = false;

include_once('dbbackup/class.dbie.php');

$dbimpexp = new dbimpexp();

// Flag to select step
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $defaults = $_POST;

// Execute Optinos
if (isset($defaults['download'])) {

    $dbimpexp->addValue('download_path', '')->addValue('download', true)->addValue('file_name', JAK_base::jakCleanurl($jkv["title"]).'-'.date("y_m_d", time()).'.xml')->export();
}

if (isset($defaults['import'])) {
    
    	$xmlfiledb = $_FILES['uploaddb']['tmp_name'];
    	
    	$filename = $_FILES['uploaddb']['name']; // original filename
    	$tmpf = explode(".", $filename);
    	$jak_xtension = end($tmpf);
    	
    	if ($xmlfiledb && $jak_xtension == "xml") {
    	
    		$dbimpexp->addValue('import_path', $xmlfiledb)->import();
    		
    		$success['s'] = $tl['general']['g111'];
    		$success = $success;
    		
    	} else {
    		
    		$errors['e'] = $tl['error']['e39'];
    		$errors = $errors;
    	
    	}
}

if (isset($defaults['optimize'])) {
	
	$dbimpexp->optimize();
	
	$success['s'] = $tl['general']['g113'];
	$success = $success;

}

}

// Title and Description
$SECTION_TITLE = $tl["menu"]["m28"];
$SECTION_DESC = $tl["general"]["g106"];

// Call the template
$template = 'maintenance.php';

?>