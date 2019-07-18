<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Get blog(s) out the database
function jak_get_ticket($limit, $order, $where, $table_row, $ext_seo, $timeago) {
	
	global $jakdb;
	global $jkv;
	
	if (is_numeric($where)) {
		$sqlin = ' '.$table_row.' = "'.$where.'" AND t1.active = 1 AND';
	} elseif (!is_numeric($where) && !empty($where)) {
		$sqlin = ' '.$table_row.' IN('.$where.') AND t1.active = 1 AND';
	} else {
		$sqlin = ' t1.catid != 0 AND t1.active = 1 AND';
	}
	
	if (JAK_TICKETMODERATE) {
		$sqlw = 't1.stprivate = 0 OR t1.stprivate = 1';
	} elseif (JAK_USERID) {
		$sqlw = 't1.stprivate = 0 OR (t1.stprivate = 1 AND t1.userid = '.JAK_USERID.')';
	} else {
		$sqlw = 't1.stprivate = 0';
	}

    $result = $jakdb->query('SELECT t1.id, t1.catid, t1.title, t1.content, t1.time, t1.status, t1.comments, t1.hits, t1.userid, t1.username, t1.stprivate, t3.name, t3.img FROM '.DB_PREFIX.'tickets AS t1 LEFT JOIN '.DB_PREFIX.'ticketcategories AS t2 ON (t1.catid = t2.id) LEFT JOIN '.DB_PREFIX.'ticketoptions AS t3 ON (t1.typeticket = t3.id) WHERE ('.$sqlw.') AND'.$sqlin.' (FIND_IN_SET('.JAK_USERGROUPID.', t2.permission) OR t2.permission = 0) GROUP BY t1.id ORDER BY '.$order.' '.$limit);
    while ($row = $result->fetch_assoc()) {
    	$getTime = JAK_Base::jakTimesince($row['time'], $jkv["ticketdateformat"], $jkv["tickettimeformat"], $timeago);
    	
    	// Write content in short format with full words
    	$shortmsg = jak_cut_text($row['content'], $jkv["ticketshortmsg"], '...');
    	
    	// There should be always a varname in categories and check if seo is valid
    	$seo = "";
    	if ($ext_seo) {
    		$seo = JAK_base::jakCleanurl($row['title']);
    	}
    	$parseurl = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_TICKETING, 't', $row['id'], $seo, '');
    	
    	// collect each record into $jakdata
    	$jakdata[] = array('id' => $row['id'], 'catid' => $row['catid'], 'title' => $row['title'], 'content' => jak_secure_site($row['content']), 'contentshort' => $shortmsg, 'created' => $getTime, 'status' => $row['status'], 'stprivate' => $row['stprivate'], 'comments' => $row['comments'], 'hits' => $row['hits'], 'userid' => $row['userid'], 'username' => $row['username'], 'name' => $row['name'], 'img' => $row['img'], 'parseurl' => $parseurl);
    }
        
        
    return $jakdata;
}

// Get total from a table limited to permission
function jak_get_total_permission_st() {
	
	if (JAK_TICKETMODERATE) {
		$sqlw = 't1.stprivate = 0 OR t1.stprivate = 1';
	} elseif (JAK_USERID) {
		$sqlw = 't1.stprivate = 0 OR (t1.stprivate = 1 AND t1.userid = '.JAK_USERID.')';
	} else {
		$sqlw = 't1.stprivate = 0';
	}
		
	global $jakdb;
	$row = $jakdb->queryRow('SELECT COUNT(t1.id) AS total FROM '.DB_PREFIX.'tickets as t1 LEFT JOIN '.DB_PREFIX.'ticketcategories as t2 ON (t1.catid = t2.id) WHERE (t1.active = 1 AND t2.active = 1) AND (('.$sqlw.') AND ('.JAK_USERGROUPID.' IN(t2.permission) OR t1.catid = t2.id AND t2.permission = 0))');
	
	if ($row['total']) {
		$jaktotal = $row['total'];
	}
		
	return $jaktotal;
}
?>