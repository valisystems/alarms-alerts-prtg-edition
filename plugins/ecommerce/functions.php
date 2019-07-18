<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Get blog(s) out the database
function jak_get_shop($ext_seo) 
{
	global $jakdb;
	
    $result = $jakdb->query('SELECT t1.id, t1.title FROM '.DB_PREFIX.'shop AS t1 WHERE active = 1 ORDER BY ecorder ASC');
    while ($row = $result->fetch_assoc()) {
    		
    		// There should be always a varname in categories and check if seo is valid
    		$seo = "";
    		if ($ext_seo) {
    			$seo = JAK_base::jakCleanurl($row['title']);
    		}
    		$parseurl = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_ECOMMERCE, 'i', $row['id'], $seo, '');
    		
            // collect each record into $jakdata
            $jakdata[] = array('id' => $row['id'], 'title' => $row['title'], 'parseurl' => $parseurl);
           }
        
        
    return $jakdata;
}
// Check coupon code and usergroup and permission
function jak_shop_coupon_check($code, $usergroup) {
		global $jakdb;
		// Get SQL
		$result = $jakdb->query('SELECT type, discount, freeshipping, usergroup, products FROM '.DB_PREFIX.'shop_coupon WHERE code = "'.smartsql($code).'" AND status = 1 AND (datestart < "'.time().'" AND dateend > "'.time().'" OR datestart = 0 AND dateend = 0) AND used < total LIMIT 1');
        $row = $result->fetch_assoc();
        
        // Now do the dirty work
        if ($row['usergroup'] == 0) {
        	$checkthru = true;
        } else {
        	$sqlusergrouparray = explode(',', $row['usergroup']);
        	$checkthru = in_array($usergroup, $sqlusergrouparray);
        }
        
	    if ($jakdb->affected_rows > 0 && $checkthru) {
	    	return true;
	    } else {
	    	return false;
	    }
        
}

function getCountryInvoice($selected, $where) {

	global $jakdb;
	
	$sqlwhere = $country_list = '';
	if ($where) $sqlwhere = ' WHERE id = '.$where.'';
	
	$result = $jakdb->query('SELECT id, name FROM '.DB_PREFIX.'shop_country'.$sqlwhere.' LIMIT 240');
	while ($row = $result->fetch_assoc()) {
	
		$select = '';
		if ($selected == $row['id']) $select = ' selected="selected" ';
		
		if (!$where) {
			$country_list .= '<option value="'.$row['id'].'"'.$select.'>'.$row['name'].'</option>';
		} else {
			$country_list = $row['name'];
		}
	}
	
	return $country_list;

}
?>