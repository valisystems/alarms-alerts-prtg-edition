<?php

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 6 May 1980 03:10:00 GMT");

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

if (!file_exists('../../config.php')) die('ajax/[like_update.php] config.php not exist');
require_once '../../config.php';

if (!$jakusergroup->getVar("canrate")) die(json_encode(array("status" => 0)));

if (is_numeric($_GET['aid']) && is_numeric($_GET['locid']) && is_numeric($_GET['feelid'])) {

	// Write the feel id once
	$blike = $blove = $brofl = $bsmile = $bwow = $bsad = $bangry = 0;
	$sqlupdate = '';
	
	// Get the users ip address
	$ipa = get_ip_address();

	if (JAK_USERID) {
		$result = $jakdb->query('SELECT id, status FROM '.DB_PREFIX.'like_client WHERE btnid = "'.smartsql($_GET['aid']).'" AND locid = "'.smartsql($_GET['locid']).'" AND userid = "'.smartsql(JAK_USERID).'"');
	} else {
		$result = $jakdb->query('SELECT id, status FROM '.DB_PREFIX.'like_client WHERE btnid = "'.smartsql($_GET['aid']).'" AND locid = "'.smartsql($_GET['locid']).'" AND (sessionid = "'.smartsql(session_id()).'" OR ip = "'.smartsql($ipa).'")');
	}
	
	// We want a healthy website so in case something went wrong we just like the page
	if ($_GET['feelid'] == 7) {
		$bangry = 1;
		$sqlupdate = 'bangry = bangry + 1';
	} elseif ($_GET['feelid'] == 6) {
		$bsad = 1;
		$sqlupdate = 'bsad = bsad + 1';
	} elseif ($_GET['feelid'] == 5) {
		$bwow = 1;
		$sqlupdate = 'bwow = bwow + 1';
	} elseif ($_GET['feelid'] == 4) {
		$bsmile = 1;
		$sqlupdate = 'bsmile = bsmile + 1';
	} elseif ($_GET['feelid'] == 3) {
		$brofl = 1;
		$sqlupdate = 'brofl = brofl + 1';
	} elseif ($_GET['feelid'] == 2) {
		$blove = 1;
		$sqlupdate = 'blove = blove + 1';
	} else {
		$blike = 1;
		$sqlupdate = 'blike = blike + 1';
	}
	
	
	// We have no entry start writting
	if ($jakdb->affected_rows == 0) {
		
		$sqlclient = '';
		if (JAK_USERID) {
			$sqlclient = ', userid = "'.smartsql(JAK_USERID).'", username = "'.smartsql($jakuser->getVar("username")).'", email = "'.smartsql($jakuser->getVar("email")).'"';
		}
		
		// Insert the result into the record client table, because that is a first time voter.
		$jakdb->query('INSERT INTO '.DB_PREFIX.'like_client SET btnid = "'.smartsql($_GET['aid']).'", locid = "'.smartsql($_GET['locid']).'"'.$sqlclient.', sessionid = "'.smartsql(session_id()).'", ip = "'.smartsql($ipa).'", status = "'.smartsql($_GET['feelid']).'", time = NOW()');
		
		// Now update the result table
		$jakdb->query('UPDATE '.DB_PREFIX.'like_counter SET '.smartsql($sqlupdate).', lastentered = NOW() WHERE btnid = "'.smartsql($_GET['aid']).'" AND locid = "'.smartsql($_GET['locid']).'" LIMIT 1');
		
		if ($jakdb->affected_rows == 0) {
			
			$jakdb->query('INSERT INTO '.DB_PREFIX.'like_counter (btnid, locid, blike, blove, brofl, bsmile, bwow, bsad, bangry, firstcreated, lastentered) VALUES("'.smartsql($_GET['aid']).'", "'.smartsql($_GET['locid']).'", "'.smartsql($blike).'", "'.smartsql($blove).'", "'.smartsql($brofl).'", "'.smartsql($bsmile).'", "'.smartsql($bwow).'", "'.smartsql($bsad).'", "'.smartsql($bangry).'", NOW(), NOW())');
		
		}
		
		die(json_encode(array("status" => 1)));
	} else {
		
		// Now there is a button clicked already, let's subtract it from the result.
		$row = $result->fetch_assoc();
		
		// if we have the same vote, we do nothing
		if ($row['status'] == $_GET['feelid']) {
			
			die(json_encode(array("status" => 0)));
		} else {
			
			// We remove the old feel and place the new one
			if (JAK_USERID) {
				$jakdb->query('UPDATE '.DB_PREFIX.'like_client SET status = "'.smartsql($_GET['feelid']).'" WHERE btnid = "'.smartsql($_GET['aid']).'" AND locid = "'.smartsql($_GET['locid']).'" AND userid = "'.smartsql(JAK_USERID).'"');
			} else {
				$jakdb->query('UPDATE '.DB_PREFIX.'like_client SET status = "'.smartsql($_GET['feelid']).'" WHERE btnid = "'.smartsql($_GET['aid']).'" AND locid = "'.smartsql($_GET['locid']).'" AND (sessionid = "'.smartsql(session_id()).'" OR ip = "'.smartsql($ipa).'")');
			}
			
			// We remove the old feel and place the new one
			if ($row['status'] == 7) {
				$sqlupdate2 = 'bangry = bangry - 1';
			} elseif ($row['status'] == 6) {
				$sqlupdate2 = 'bsad = bsad - 1';
			} elseif ($row['status'] == 5) {
				$sqlupdate2 = 'bwow = bwow - 1';
			} elseif ($row['status'] == 4) {
				$sqlupdate2 = 'bsmile = bsmile - 1';
			} elseif ($row['status'] == 3) {
				$sqlupdate2 = 'brofl = brofl - 1';
			} elseif ($row['status'] == 2) {
				$sqlupdate2 = 'blove = blove - 1';
			} else {
				$sqlupdate2 = 'blike = blike - 1';
			}
			
			$jakdb->query('UPDATE '.DB_PREFIX.'like_counter SET '.smartsql($sqlupdate).', '.smartsql($sqlupdate2).' WHERE btnid = "'.smartsql($_GET['aid']).'" AND locid = "'.smartsql($_GET['locid']).'"');
		
			die(json_encode(array("status" => 1)));
		}
	}
		
} else {
	die(json_encode(array("status" => 0)));
}
?>