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

$jaktable = DB_PREFIX.'tags';
$jaktable1 = DB_PREFIX.'pages';
$jaktable2 = DB_PREFIX.'categories';
$jaktable3 = 'news';

// Call the hooks per name
$JAK_HOOK_TAGS = $jakhooks->jakGethook("tpl_tags");
$PAGE_SHOWTITLE = 1;

// AJAX Search
$AJAX_SEARCH_PLUGIN_WHERE = $jaktable1;
$AJAX_SEARCH_PLUGIN_URL = 'include/ajax/page.php';
$AJAX_SEARCH_PLUGIN_SEO =  0;

$swaplang = JAK_PLUGIN_ID_TAGS;

if (empty($page1)) {
	$PAGE_TITLE = JAK_PLUGIN_NAME_TAGS;
	$PAGE_CONTENT = $jkv["tagdesc"];
	$JAK_NO_TAG_DATA = $tl['errorpage']['ct'];
} else {
	
	// Clean the tag if someone is funny and tries to type something weird
	$cleanTag = filter_var($page1, FILTER_SANITIZE_STRING);
	
	// let's check if the tag exists
		$result = $jakdb->query('SELECT SQL_CALC_FOUND_ROWS itemid, pluginid FROM '.$jaktable.' WHERE tag = "'.smartsql($cleanTag).'"');
		if ($result) {
		    while ($row = $result->fetch_assoc()) {
		    
		    	if ($row['pluginid'] > 0 && $row['pluginid'] != 1 && in_array($row['pluginid'], $usraccesspl)) {
		    		
		    		// Get the php hook for tags
		    		$hooktags = $jakhooks->jakGethook("php_tags");
		    		if ($hooktags) {
		    			foreach($hooktags as $th) {
		    				eval($th["phpcode"]);
		    			}
		    		}
		    	
		    	} elseif ($row['pluginid'] == 0) {
		    	
		    		$result2 = $jakdb->query('SELECT t1.varname, t2.title'.', t2.content'.' FROM '.$jaktable2.' AS t1 LEFT JOIN '.$jaktable1.' AS t2 ON t1.id = t2.catid WHERE t2.id = "'.smartsql($row['itemid']).'" AND t2.active = 1 LIMIT 1');
		    		$row2 = $result2->fetch_assoc();
		    		
		    		if ($jakdb->affected_rows > 0) {
		    			$getStriped = jak_cut_text($row2['content'],$jkv["shortmsg"],'...');
		    		
		    			$parseurl = JAK_rewrite::jakParseurl($row2['varname'], '', '', '', '');
		    		
		    			$pageData[] = array('parseurl' => $parseurl, 'title' => $row2['title'], 'content' => $getStriped);
		    			$JAK_TAG_PAGE_DATA = $pageData;
		    		}
		    		// Get the news data
		    	} elseif ($row['pluginid'] == 1) {
		    		$newstagData[] = JAK_tags::jakTagsql($jaktable3, $row['itemid'], "id, title".", content", "content", JAK_PLUGIN_VAR_NEWS, 'a', 1);
		    		$JAK_TAG_NEWS_DATA = $newstagData;
		        } else {
		        	// No Tag Data in the while
		        	$JAK_NO_TAG_DATA = $tl['errorpage']['nt'];
		       	}
		        
		        }
		// Post the page title
		$PAGE_TITLE = strtoupper($page1).' - '.$jkv["tagtitle"];
		$PAGE_CONTENT = $jkv["tagdesc"];
	} else {
		// No tag data at all
		$JAK_NO_TAG_DATA = $tl['errorpage']['nt'];
	}
}

// Get the sort orders for the grid
$JAK_HOOK_SIDE_GRID = false;
$grid = $jakdb->query('SELECT id, hookid, pluginid, whatid, orderid FROM '.DB_PREFIX.'pagesgrid WHERE plugin = '.JAK_PLUGIN_ID_TAGS.' ORDER BY orderid ASC');
while ($grow = $grid->fetch_assoc()) {
        // collect each record into $pagegrid
        	$JAK_HOOK_SIDE_GRID[] = $grow;
}

// Now get the new meta keywords and description maker
$PAGE_KEYWORDS = str_replace(" ", "", JAK_Base::jakCleanurl(JAK_PLUGIN_NAME_TAGS).($jkv["metakey"] ? ",".$jkv["metakey"] : ""));
$PAGE_DESCRIPTION = $jkv["metadesc"];

// get the standard template
$template = 'tags.php';
?>