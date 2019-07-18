<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Get faq(s) out the database
function jak_get_faq($limit, $order, $where, $table_row, $ext_seo, $timeago) 
{
	global $jakdb;
	global $jkv;
	
	if (is_numeric($where)) {
		$sqlin = ''.$table_row.' = "'.smartsql($where).'" AND t1.active = 1 AND';
	} elseif (!is_numeric($where) && !empty($where)) {
		$sqlin = ''.$table_row.' IN('.$where.') AND t1.active = 1 AND';
	} else {
		$sqlin = 't1.catid != 0 AND t1.active = 1 AND';
	}

    $result = $jakdb->query('SELECT t1.*, COUNT(t3.id) AS total FROM '.DB_PREFIX.'faq AS t1 LEFT JOIN '.DB_PREFIX.'faqcategories AS t2 ON (t1.catid = t2.id) LEFT JOIN '.DB_PREFIX.'faqcomments AS t3 ON (t1.id = t3.faqid AND t3.approve = 1) WHERE '.$sqlin.' (FIND_IN_SET('.JAK_USERGROUPID.',t2.permission) OR t2.permission = 0) GROUP BY t1.id ORDER BY '.$order.' '.$limit);
    while ($row = $result->fetch_assoc()) {
    	
    	// Write content in short format with full words
    	$shortmsg = jak_cut_text($row['content'], $jkv["shortmsg"], '...');
    	
    	// There should be always a varname in categories and check if seo is valid
    	$seo = "";
    	if ($ext_seo) {
    		$seo = JAK_base::jakCleanurl($row['title']);
    	}
    			
    	// Parse url for user link
    	$parseurl = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_FAQ, 'a', $row['id'], $seo, '');
    
    		
    	$getTime = JAK_Base::jakTimesince($row['time'], $jkv["faqdateformat"], $jkv["faqtimeformat"], $timeago);
    		
            // collect each record into $jakdata
            $jakdata[] = array('id' => $row['id'], 'catid' => $row['catid'], 'title' => $row['title'], 'content' => jak_secure_site($row['content']), 'contentshort' => $shortmsg, 'showtitle' => $row['showtitle'], 'showcontact' => $row['showcontact'], 'showdate' => $row['showdate'], 'created' => $getTime, 'comments' => $row['comments'], 'hits' => $row['hits'], 'totalcom' => $row['total'], 'previmg' => $row['previmg'], 'parseurl' => $parseurl);
           }
        
        
    return $jakdata;
}

// Get total from a table limited to permission
function jak_get_total_permission_faq()
{
		global $jakdb;
		$result = $jakdb->query('SELECT COUNT(t1.id) AS total FROM '.DB_PREFIX.'faq as t1 LEFT JOIN '.DB_PREFIX.'faqcategories as t2 ON (t1.catid = t2.id) WHERE (t1.active = 1 AND t2.active = 1) AND (FIND_IN_SET('.JAK_USERGROUPID.',t2.permission) OR t1.catid = t2.id AND t2.permission = 0)');
		$row = $result->fetch_assoc();
		
		if ($row['total']) {
			$jaktotal = $row['total'];
		}
		
		return $jaktotal;
}
?>