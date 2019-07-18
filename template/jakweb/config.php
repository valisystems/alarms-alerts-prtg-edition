<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

/* ### CONFIG FILE ### */

// Add Custom Stylesheet to tinyMCE Editor
if (isset($jkv["color_jakweb_tpl"]) && $jkv["color_jakweb_tpl"] == "dark") {
	$tpl_customcss = "template/jakweb/css/screendark.css";
} else {
	$tpl_customcss = "template/jakweb/css/screen.css";
}