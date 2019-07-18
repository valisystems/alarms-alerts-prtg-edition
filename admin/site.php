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

// Let's go on with the script
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $defaults = $_POST;

    if ($defaults['jak_online'] == '1' && empty($defaults['jak_offpage'])) {
        $errors['e1'] = $tl['error']['e1'];
    }
    
    if (empty($defaults['jak_title'])) {
        $errors['e2'] = $tl['error']['e2'];
    }

    if (count($errors) == 0) {
    
	    // Do the dirty work in mysql
	    $result = $jakdb->query('UPDATE '.DB_PREFIX.'setting SET value = CASE varname
	        WHEN "offline" THEN '.$defaults['jak_online'].'
	        WHEN "offline_page" THEN "'.smartsql($defaults['jak_offpage']).'"
	        WHEN "notfound_page" THEN "'.smartsql($defaults['jak_pagenotfound']).'"
	        WHEN "title" THEN "'.smartsql($defaults['jak_title']).'"
	        WHEN "metadesc" THEN "'.smartsql($defaults['jak_description']).'"
	        WHEN "metakey" THEN "'.smartsql($defaults['jak_keywords']).'"
	        WHEN "metaauthor" THEN "'.smartsql($defaults['jak_author']).'"
	        WHEN "robots" THEN '.$defaults['jak_robots'].'
	        WHEN "copyright" THEN "'.smartsql($defaults['jak_copy']).'"
	    END
			WHERE varname IN ("offline","offline_page","notfound_page","title","metadesc","metakey","metaauthor","robots","copyright")');
		
		if (!$result) {
			jak_redirect(BASE_URL.'index.php?p=site&sp=e');
		} else {
	        jak_redirect(BASE_URL.'index.php?p=site&sp=s');
	    }
    
    } else {
    
	   	$errors['e'] = $tl['error']['e'];
	    $errors = $errors;
	    
    }
}

// Offline page categories
$JAK_CAT = jak_get_cat_info(DB_PREFIX.'categories', 0);

// Title and Description
$SECTION_TITLE = $tl["cmenu"]["c1"];
$SECTION_DESC = $tl["cmdesc"]["d1"];

// Call the template
$template = 'site.php';
?>