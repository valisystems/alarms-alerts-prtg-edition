<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Get blog(s) out the database
function jak_get_download($limit, $order, $where, $table_row, $ext_seo, $timeago) 
{
	global $jakdb;
	global $jkv;
	
	if (is_numeric($where)) {
		$sqlin = ''.$table_row.' = "'.$where.'" AND t1.active = 1 AND';
	} elseif (!is_numeric($where) && !empty($where)) {
		$sqlin = ''.$table_row.' IN('.$where.') AND t1.active = 1 AND';
	} else {
		$sqlin = 't1.catid != 0 AND t1.active = 1 AND';
	}

    $result = $jakdb->query('SELECT t1.*, COUNT(t3.id) AS total FROM '.DB_PREFIX.'download AS t1 LEFT JOIN '.DB_PREFIX.'downloadcategories AS t2 ON (t1.catid = t2.id) LEFT JOIN '.DB_PREFIX.'downloadcomments AS t3 ON (t1.id = t3.fileid AND t3.approve = 1) WHERE '.$sqlin.' (FIND_IN_SET('.JAK_USERGROUPID.',t2.permission) OR t2.permission = 0) GROUP BY t1.id ORDER BY '.$order.' '.$limit);
    while ($row = $result->fetch_assoc()) {
    
    	$getTime = JAK_Base::jakTimesince($row['time'], $jkv["downloaddateformat"], $jkv["downloadtimeformat"], $timeago);
    		
    	// Write content in short format with full words
    	$shortmsg = jak_cut_text($row['content'],$jkv["shortmsg"],'...');
    		
    	// There should be always a varname in categories and check if seo is valid
    	$seo = "";
    	if ($ext_seo) {
    		$seo = JAK_base::jakCleanurl($row['title']);
    	}
    	
    	$parseurl = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_DOWNLOAD, 'f', $row['id'], $seo, '');
    		
        // collect each record into $jakdata
        $jakdata[] = array('id' => $row['id'], 'catid' => $row['catid'], 'title' => $row['title'], 'content' => jak_secure_site($row['content']), 'contentshort' => $shortmsg, 'showtitle' => $row['showtitle'], 'showcontact' => $row['showcontact'], 'showdate' => $row['showdate'], 'created' => $getTime, 'comments' => $row['comments'], 'hits' => $row['hits'], 'totalcom' => $row['total'], 'previmg' => $row['previmg'], 'parseurl' => $parseurl);
    }
        
        
    return $jakdata;
}

// Get total from a table limited to permission
function jak_get_total_permission_dl()
{
		global $jakdb;
		$jaktotal = 0;
		$result = $jakdb->query('SELECT COUNT(t1.id) AS total FROM '.DB_PREFIX.'download as t1 LEFT JOIN '.DB_PREFIX.'downloadcategories as t2 ON (t1.catid = t2.id) WHERE (t1.active = 1 AND t2.active = 1) AND (FIND_IN_SET('.JAK_USERGROUPID.',t2.permission) OR t1.catid = t2.id AND t2.permission = 0)');
		$row = $result->fetch_assoc();
		
		if ($row['total']) {
			$jaktotal = $row['total'];
		}
		
		return $jaktotal;
}
?>