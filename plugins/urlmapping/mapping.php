<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Get the database stuff from the url mapping
$umrow = $jakdb->queryRow('SELECT urlnew, redirect FROM '.DB_PREFIX.'urlmapping WHERE urlold = "'.smartsql($_SERVER['REQUEST_URI']).'" AND active = 1 LIMIT 1');
if ($jakdb->affected_rows === 1) {
	jak_redirect($umrow["urlnew"], $umrow["redirect"]);
}
?>