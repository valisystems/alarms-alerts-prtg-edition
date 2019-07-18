<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Get gallery(s) out the database
function jak_get_gallery($limit, $order, $where, $table_row, $ext_seo, $timeago) 
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
	
	if (empty($order)) {
		$order = 't1.picorder ASC';
	}
	
	$jakdata = array();
    $result = $jakdb->query('SELECT t1.id, t1.catid, t1.title, t1.paththumb, t1.pathbig, t1.hits, t1.time FROM '.DB_PREFIX.'gallery AS t1 LEFT JOIN '.DB_PREFIX.'gallerycategories AS t2 ON (t2.id IN(t1.catid)) WHERE '.$sqlin.' (FIND_IN_SET('.JAK_USERGROUPID.',t2.permission) OR t2.permission = 0) GROUP BY t1.id ORDER BY '.$order.' '.$limit);
    while ($row = $result->fetch_assoc()) {
    
    		$getTime = JAK_Base::jakTimesince($row['time'], $jkv["gallerydateformat"], $jkv["gallerytimeformat"], $timeago);
    		
    		// There should be always a varname in categories and check if seo is valid
    		$seo = "";
    		if ($ext_seo) $seo = JAK_base::jakCleanurl($row['title']);
    		
    		// Get the url
    		$parseurl = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_GALLERY, 'p', $row['id'], $seo);
    		
            // collect each record into $jakdata
            $jakdata[] = array('id' => $row['id'], 'catid' => $row['catid'], 'title' => $row['title'], 'paththumb' => $row['paththumb'], 'pathbig' => $row["pathbig"], 'created' => $getTime, 'hits' => $row['hits'], 'parseurl' => $parseurl);
           }
        
    return $jakdata;
}
?>