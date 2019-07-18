<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Get the general settings out the database
$resultbh = $jakdb->query('SELECT pageid, newsid, newsmain, tags, search, sitemap, content, content_below, permission FROM '.DB_PREFIX.'belowheader WHERE active = 1');
    while ($rowbh = $resultbh->fetch_assoc()) {
    	// collect each record into a define
    	
    	$content = base64_encode($rowbh["content"]);
    	$content_below = base64_encode($rowbh["content_below"]);
    	
    	// Get the pages in a array
    	if ($rowbh['pageid'] != 0 && !is_numeric($rowbh['pageid'])) {
    		
    		$pagearray = explode(',', $rowbh['pageid']);
    		
    		for ($i = 0; $i < count($pagearray); $i++) {
    		
    			$JAK_PAGE_BELOW_HEADER[$pagearray[$i]] = array('pageid' => $pagearray[$i], 'content' => $content, 'content_below' => $content_below, 'permission' => $rowbh['permission']);
    		
    		}
    	
    	}
    	
    	if (is_numeric($rowbh['pageid'])) {
    	
    		$JAK_PAGE_BELOW_HEADER[$rowbh['pageid']] = array('pageid' => $rowbh['pageid'], 'content' => $content, 'content_below' => $content_below, 'permission' => $rowbh['permission']);
    	}
    	
    	
    	// Get the news in a array
    	if ($rowbh['newsid'] != 0 && !is_numeric($rowbh['newsid'])) {
    		
    		$newsarray = explode(',', $rowbh['newsid']);
    		
    		for ($i = 0; $i < count($newsarray); $i++) {
    		
    			$JAK_NEWS_BELOW_HEADER[$newsarray[$i]] = array('newsid' => $newsarray[$i], 'content' => $content, 'content_below' => $content_below, 'permission' => $rowbh['permission']);
    		
    		}
    	
    	}
    	
    	if ($rowbh['newsid'] != 0 && is_numeric($rowbh['newsid'])) {
    	
    		$JAK_NEWS_BELOW_HEADER[$rowbh['newsid']] = array('newsid' => $rowbh['newsid'],'content' => $content, 'content_below' => $content_below, 'permission' => $rowbh['permission']);
    	}
    	
    	// Check if we display the content on the news main page
    	if ($rowbh['newsmain'] != 0 && is_numeric($rowbh['newsmain'])) {
    	
    		$JAK_NEWSMAIN_BELOW_HEADER[] = array('newsmain' => 1, 'content' => $content, 'content_below' => $content_below, 'permission' => $rowbh['permission']);
    	}
    	
    	// Check if we display the content on the news main page
    	if ($rowbh['tags'] != 0 && is_numeric($rowbh['tags'])) {
    	
    		$JAK_TAGS_BELOW_HEADER[] = array('tags' => 1, 'content' => $content, 'content_below' => $content_below, 'permission' => $rowbh['permission']);
    	}
    	
    	// Check if we display the content on the news main page
    	if ($rowbh['search'] != 0 && is_numeric($rowbh['search'])) {
    	
    		$JAK_SEARCH_BELOW_HEADER[] = array('search' => 1, 'content' => $content, 'content_below' => $content_below, 'permission' => $rowbh['permission']);
    	}
    	
    	// Check if we display the content on the news main page
    	if ($rowbh['sitemap'] != 0 && is_numeric($rowbh['sitemap'])) {
    	
    		$JAK_SITEMAP_BELOW_HEADER[] = array('sitemap' => 1, 'content' => $content, 'content_below' => $content_below, 'permission' => $rowbh['permission']);
    	}
    	
    }

// Now we have a cache file let's display the content if the user has permission.

// Let's check if there is a valid Page array
if (!$page1 && isset($PAGE_ID) && isset($JAK_PAGE_BELOW_HEADER) && is_array($JAK_PAGE_BELOW_HEADER) && array_key_exists($PAGE_ID, $JAK_PAGE_BELOW_HEADER)) {

 foreach ($JAK_PAGE_BELOW_HEADER as $subp) {
    if ($subp['pageid'] == $PAGE_ID && (jak_get_access(JAK_USERGROUPID, $subp['permission']) || $subp['permission'] == 0)) {
    
    	$bh_top = jak_secure_site($subp['content']);
    
    	if (!$bh_top) $bh_top = $subp['content'];
    	
    	echo jak_secure_site(base64_decode($bh_top));
        
        
    }
}

}

if (!isset($backtonews)) $backtonews = false;

// Let's check if there is a valid News array
if ($backtonews && isset($PAGE_ID) && isset($JAK_NEWS_BELOW_HEADER) && is_array($JAK_NEWS_BELOW_HEADER) && array_key_exists($PAGE_ID, $JAK_NEWS_BELOW_HEADER)) {

 foreach ($JAK_NEWS_BELOW_HEADER as $subn) {
    if ($subn['newsid'] == $PAGE_ID && (jak_get_access(JAK_USERGROUPID, $subn['permission']) || $subn['permission'] == 0)) {
    
    	$bh_top = jak_secure_site($subn['content']);
    	
    	if (!$bh_top) $bh_top = $subn['content'];
    		
    	echo jak_secure_site(base64_decode($bh_top)); 
        
    }
}

}

// Let's check if there is a valid News Main array
if ($backtonews && !$page1 && isset($JAK_NEWSMAIN_BELOW_HEADER) && is_array($JAK_NEWSMAIN_BELOW_HEADER)) {

 foreach ($JAK_NEWSMAIN_BELOW_HEADER as $submn) {
 
    if ($submn['newsmain'] == 1 && (jak_get_access(JAK_USERGROUPID, $submn['permission']) || $submn['permission'] == 0)) {
    	
    	$bh_top = jak_secure_site($submn['content']);
    	
    	if (!$bh_top) $bh_top = $submn['content'];
    		
    	echo jak_secure_site(base64_decode($bh_top));
        
        
    }
}

}

// Let's check if there is a valid Tags array and if the user has access to tags
if ($page == JAK_PLUGIN_VAR_TAGS && isset($JAK_TAGS_BELOW_HEADER) && is_array($JAK_TAGS_BELOW_HEADER) && JAK_USER_TAGS) {

 foreach ($JAK_TAGS_BELOW_HEADER as $subt) {
 
    if ($subt['tags'] == 1 && (jak_get_access(JAK_USERGROUPID, $subt['permission']) || $subt['permission'] == 0)) {
    	
    	$bh_top = jak_secure_site($subt['content']);
    	
    	if (!$bh_top) $bh_top = $subt['content'];
    		
    	echo jak_secure_site(base64_decode($bh_top));
        
        
    }
}

}

// Let's check if there is a valid Search array
if ($page == 'search' && isset($JAK_SEARCH_BELOW_HEADER) && is_array($JAK_SEARCH_BELOW_HEADER)) {

 foreach ($JAK_SEARCH_BELOW_HEADER as $subs) {
 
    if ($subs['search'] == 1 && (jak_get_access(JAK_USERGROUPID, $subs['permission']) || $subs['permission'] == 0)) {
    	
    	$bh_top = jak_secure_site($subs['content']);
    	
    	if (!$bh_top) $bh_top = $subs['content'];
    		
    	echo jak_secure_site(base64_decode($bh_top));
        
        
    }
}

}

// Let's check if there is a valid Sitemap array
if ($page == JAK_PLUGIN_VAR_SITEMAP && isset($JAK_SITEMAP_BELOW_HEADER) && is_array($JAK_SITEMAP_BELOW_HEADER)) {

 foreach ($JAK_SITEMAP_BELOW_HEADER as $subsit) {
 
    if ($subsit['sitemap'] == 1 && (jak_get_access(JAK_USERGROUPID, $subsit['permission']) || $subsit['permission'] == 0)) {
    	
    	$bh_top = jak_secure_site($subsit['content']);
    	
    	if (!$bh_top) $bh_top = $subsit['content'];
    		
    	echo jak_secure_site(base64_decode($bh_top));
        
        
    }
}

}
?>