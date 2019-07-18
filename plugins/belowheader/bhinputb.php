<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Now we have a cache file let's display the content if the user has permission.

// Let's check if there is a valid Page array
if (!$page1 && isset($PAGE_ID) && isset($JAK_PAGE_BELOW_HEADER) && is_array($JAK_PAGE_BELOW_HEADER) && array_key_exists($PAGE_ID, $JAK_PAGE_BELOW_HEADER)) {

 foreach ($JAK_PAGE_BELOW_HEADER as $subp) {
    if ($subp['pageid'] == $PAGE_ID && (jak_get_access(JAK_USERGROUPID, $subp['permission']) || $subp['permission'] == 0)) {
    	
    	$bh_top = jak_secure_site($subp['content_below']);
    	
    	if (!$bh_top) $bh_top = $subp['content_below'];
    		
    	echo jak_secure_site(base64_decode($bh_top));
        
        
    }
}

}

// Let's check if there is a valid News array
if (isset($backtonews) && isset($PAGE_ID) && isset($JAK_NEWS_BELOW_HEADER) && is_array($JAK_NEWS_BELOW_HEADER) && array_key_exists($PAGE_ID, $JAK_NEWS_BELOW_HEADER)) {

 foreach ($JAK_NEWS_BELOW_HEADER as $subn) {
    if ($subn['newsid'] == $PAGE_ID && (jak_get_access(JAK_USERGROUPID, $subn['permission']) || $subn['permission'] == 0)) {
    	
    	$bh_top = jak_secure_site($subn['content_below']);
    	
    	if (!$bh_top) $bh_top = $subn['content_below'];
    		
    	echo jak_secure_site(base64_decode($bh_top));
        
        
    }
}

}

// Let's check if there is a valid News Main array
if (isset($backtonews) && !$page1 && isset($JAK_NEWSMAIN_BELOW_HEADER) && is_array($JAK_NEWSMAIN_BELOW_HEADER)) {

 foreach ($JAK_NEWSMAIN_BELOW_HEADER as $submn) {
 
    if ($submn['newsmain'] == 1 && (jak_get_access(JAK_USERGROUPID, $submn['permission']) || $submn['permission'] == 0)) {
    	
    	$bh_top = jak_secure_site($submn['content_below']);
    	
    	if (!$bh_top) $bh_top = $submn['content_below'];
    		
    	echo jak_secure_site(base64_decode($bh_top));
        
        
    }
}

}

// Let's check if there is a valid Tags array and if the user has access to tags
if ($page == JAK_PLUGIN_VAR_TAGS && isset($JAK_TAGS_BELOW_HEADER) && is_array($JAK_TAGS_BELOW_HEADER) && JAK_USER_TAGS) {

 foreach ($JAK_TAGS_BELOW_HEADER as $subt) {
 
    if ($subt['tags'] == 1 && (jak_get_access(JAK_USERGROUPID, $subt['permission']) || $subt['permission'] == 0)) {
    	
    	$bh_top = jak_secure_site($subt['content_below']);
    	
    	if (!$bh_top) $bh_top = $subt['content_below'];
    		
    	echo jak_secure_site(base64_decode($bh_top));
        
        
    }
}

}

// Let's check if there is a valid Search array
if ($page == 'search' && isset($JAK_SEARCH_BELOW_HEADER) && is_array($JAK_SEARCH_BELOW_HEADER)) {

 foreach ($JAK_SEARCH_BELOW_HEADER as $subs) {
 
    if ($subs['search'] == 1 && (jak_get_access(JAK_USERGROUPID, $subs['permission']) || $subs['permission'] == 0)) {
    	
    	$bh_top = jak_secure_site($subs['content_below']);
    	
    	if (!$bh_top) $bh_top = $subs['content_below'];
    		
    	echo jak_secure_site(base64_decode($bh_top));
        
        
    }
}

}

// Let's check if there is a valid Sitemap array
if ($page == JAK_PLUGIN_VAR_SITEMAP && isset($JAK_SITEMAP_BELOW_HEADER) && is_array($JAK_SITEMAP_BELOW_HEADER)) {

 foreach ($JAK_SITEMAP_BELOW_HEADER as $subsit) {
 
    if ($subsit['sitemap'] == 1 && (jak_get_access(JAK_USERGROUPID, $subsit['permission']) || $subsit['permission'] == 0)) {
    	
    	$bh_top = jak_secure_site($subsit['content_below']);
    	
    	if (!$bh_top) $bh_top = $subsit['content_below'];
    		
    	echo jak_secure_site(base64_decode($bh_top));
        
        
    }
}

}
?>