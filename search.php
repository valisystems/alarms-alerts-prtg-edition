<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Check if the file is accessed only via index.php if not stop the script from running
if(!defined('JAK_PREVENT_ACCESS')) die('No direct access!');

// Call the hooks per name
$JAK_HOOK_SEARCH = $jakhooks->jakGethook("tpl_search");

// Reset vars
$JAK_SEARCH_WORD_RESULT = $JAK_SEARCH_CLOUD = $SearchInput = false;

// Include the class
include_once 'class/class.search.php';

// Now do the dirty work with the post vars
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['jakSH']) || !empty($page1)) {

    $defaults = $_POST;
    
    if (isset($_POST['jakSH'])) {
	
	    if (empty($page1) && $defaults['jakSH'] == '' || $defaults['jakSH'] == $tl['search']['s']) {
	        $errors['e1'] = $tl['search']['s1'];
	    }
	
	    if (empty($page1) && strlen($defaults['jakSH']) < '3') {
	        $errors['e2'] = $tl['search']['s2'];
	    }
	    
	}

    if (count($errors) > 0) {
        $errors['e'] = $tl['search']['s3'];
        $errors = $errors;
    } else {
    
    		if (!empty($page1)) {
    			$SearchInput = filter_var($page1, FILTER_SANITIZE_STRING);
    		} else {
    			$SearchInput = filter_var($defaults['jakSH'], FILTER_SANITIZE_STRING);
    		}
        	$SearchInput = strtolower(smartsql($SearchInput));
	        	
	        // Load the hooks with the php code for search
	        $hooktags = $jakhooks->jakGethook("php_search");
	        if ($hooktags) foreach($hooktags as $th) {
	        	eval($th["phpcode"]);
	        }
	                	 
        	// Standard search for all pages
        	$pages = new JAK_search($SearchInput); 
        	$pages->jakSettable(array('1' => 'pages', '2' => 'categories'),"t1.catid = t2.id"); // array for pages and cat
        	$pages->jakAndor("OR"); // We do an OR so it will search thru title and content and display one of them
        	$pages->jakFieldactive("active"); // Only if the page is active
        	$pages->jakFieldcut("content"); // The content will be cuted to fit nicely
        	$pages->jakFieldstosearch(array('t1.title','t1.content')); // This fields will be searched
        	$pages->jakFieldstoselect("t2.varname, t1.title".", t1.content".", t2.catorder, t2.catparent"); // This will be the output for the template, packed in a array
        	
        	// Load the page array into template
        	$JAK_SEARCH_RESULT = $pages->set_result('', '', ''); // Now result the search and pack it into the array
        	
        	if (JAK_NEWS_ACTIVE) {
	        	// Standard search for all news
	        	$news = new JAK_search($SearchInput); 
	        	$news->jakSettable("news", ''); // array for pages and cat
	        	$news->jakAndor("OR"); // We do an OR so it will search thru title and content and display one of them
	        	$news->jakFieldactive("active"); // Only if the page is active
	        	$news->jakFieldtitle("title");
	        	$news->jakFieldcut("content"); // The content will be cuted to fit nicely
	        	$news->jakFieldstosearch(array('title','content')); // This fields will be searched
	        	$news->jakFieldstoselect("id, title".", content"); // This will be the output for the template, packed in a array
	        	
	        	$JAK_SEARCH_RESULT_NEWS = $news->set_result(JAK_PLUGIN_VAR_NEWS, 'a', 1);
	        }
        	
        	// Fire the search for the template
        	$JAK_SEARCH_USED = true;
        	
        	if ((is_array($JAK_SEARCH_RESULT) || is_array($JAK_SEARCH_RESULT_NEWS)) && !$page1) {
        		JAK_search::search_cloud($SearchInput);
        	}
        	
        }
    }


// Always tell the searchword
$JAK_SEARCH_WORD_RESULT = $SearchInput;
$JAK_SEARCH_CLOUD = JAK_tags::jakGettagcloud('search', 'searchlog', $jkv["taglimit"], $jkv["tagmaxfont"], $jkv["tagminfont"]);

// Check if we have a language and display the right stuff
$PAGE_TITLE = $jkv["searchtitle"];
$PAGE_CONTENT = $jkv["searchdesc"];

// Page Title
$PAGE_SHOWTITLE = 1;

// Get the sort orders for the grid
$JAK_HOOK_SIDE_GRID = false;
$grid = $jakdb->query('SELECT id, hookid, pluginid, whatid, orderid FROM '.DB_PREFIX.'pagesgrid WHERE plugin = 999999 ORDER BY orderid ASC');
while ($grow = $grid->fetch_assoc()) {
        // collect each record into $pagegrid
        	$JAK_HOOK_SIDE_GRID[] = $grow;
}

// Now get the new meta keywords and description maker
$PAGE_KEYWORDS = str_replace(" ", "", JAK_Base::jakCleanurl($tl["search"]["s"]).($JAK_SEARCH_CLOUD ? ",".strip_tags($JAK_SEARCH_CLOUD) : "").($jkv["metakey"] ? ",".$jkv["metakey"] : ""));
$PAGE_DESCRIPTION = $jkv["metadesc"];

// Call the template
$template = 'search.php';
?>