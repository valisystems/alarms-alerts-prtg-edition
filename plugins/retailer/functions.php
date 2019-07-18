<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Get retailer(s) out the database
function jak_get_retailer($limit, $order, $where, $table_row, $ext_seo, $timeago) 
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

    $result = $jakdb->query('SELECT t1.id, t1.catid, t1.title, t1.content, t1.shortcontent, t1.showtitle, t1.showcontact, t1.showdate, t1.showhits, t1.time, t1.comments, t1.hits, t1.previmg, t2.varname, COUNT(t3.id) AS total FROM '.DB_PREFIX.'retailer AS t1 LEFT JOIN '.DB_PREFIX.'retailercategories AS t2 ON (t1.catid = t2.id) LEFT JOIN '.DB_PREFIX.'retailercomments AS t3 ON (t1.id = t3.retailerid AND t3.approve = 1) WHERE '.$sqlin.' (FIND_IN_SET('.JAK_USERGROUPID.',t2.permission) OR t2.permission = 0) GROUP BY t1.id ORDER BY '.$order.' '.$limit);
    while ($row = $result->fetch_assoc()) {
    
    		$getTime = JAK_Base::jakTimesince($row['time'], $jkv["retailerdateformat"], $jkv["retailertimeformat"], $timeago);
    		
    		// There should be always a varname in categories and check if seo is valid
    		$seo = "";
    		if ($ext_seo) {
    			$seo = JAK_base::jakCleanurl($row['title']);
    		}
    		$parseurl = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_RETAILER, 'r', $row['id'], $seo, '');
    		
            // collect each record into $jakdata
            $jakdata[] = array('id' => $row['id'], 'catid' => $row['catid'], 'title' => $row['title'], 'content' => jak_secure_site($row['content']), 'contentshort' => strip_tags($row['shortcontent']), 'showtitle' => $row['showtitle'], 'showcontact' => $row['showcontact'], 'showdate' => $row['showdate'], 'showhits' => $row['showhits'], 'created' => $getTime, 'comments' => $row['comments'], 'hits' => $row['hits'], 'totalcom' => $row['total'], 'previmg' => $row['previmg'], 'parseurl' => $parseurl, 'catname' => $row['varname']);
           }
        
        
    return $jakdata;
}

// Encode email for no spam
function encode_email($e)
{
  	for ($i = 0; $i < strlen($e); $i++) { $output .= '&#'.ord($e[$i]).';'; }
  	if (isset($output)) return $output;
}
?>