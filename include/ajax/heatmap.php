<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

if (!file_exists('../../config.php')) die('ajax/[clickstat.php] config.php not exist');
require_once '../../config.php';

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) die("Nothing to see here");

if (isset($_POST['l']) && is_numeric($_POST['x']) && is_numeric($_POST['y'])) {
	
	$result = $jakdb->query('INSERT INTO '.DB_PREFIX.'clickstat SET xaxis = "'.smartsql($_POST['x']).'", yaxis = "'.smartsql($_POST['y']).'", location = "'.smartsql($_POST['l']).'"');
	
}

if ($jakuser->jakAdminaccess($jakuser->getVar("usergroupid"))) {
    
if (isset($_GET['l'])) {
	
	$result = $jakdb->query('SELECT xaxis, yaxis FROM '.DB_PREFIX.'clickstat WHERE location = "'.smartsql($_GET['l']).'" ORDER BY id DESC LIMIT 300');
	
	if ($jakdb->affected_rows > 0) {
		
		$jakoutput = '<div id="heatmap-container">';
	
	while ($row = $result->fetch_assoc()) {
	        // collect each record into $jakdata
	        $jakoutput .= sprintf('<div style="left:%spx;top:%spx"></div>', $row['xaxis'] - 10, $row['yaxis'] - 10);
	    }
	    
	    $jakoutput .= '</div>'; 
          
	} 
     
    echo $jakoutput; 
}

} else {

	echo false;
}

?>