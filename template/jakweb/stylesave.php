<?php // Save the form

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

if (!file_exists('../../config.php')) die('ajax/[qtips.php] config.php not exist');
require_once '../../config.php';

if(!$jakuser->jakAdminaccess($jakuser->getVar("usergroupid"))) die('You cannot access this file directly.');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

// Let's check what we display on footer
if (is_numeric($_POST["cb1"])) {
	$cb1 = $_POST["cb1"];
} elseif ($_POST["cb1"] == "ct") {
	$cb1 = smartsql($_POST['content1']);
} else {
	$cb1 = 0;
}

if (is_numeric($_POST["cb2"])) {
	$cb2 = $_POST["cb2"];
} elseif ($_POST["cb2"] == "ct") {
	$cb2 = smartsql($_POST['content2']);
} else {
	$cb2 = 0;
}

if (is_numeric($_POST["cb3"])) {
	$cb3 = $_POST["cb3"];
} elseif ($_POST["cb3"] == "ct") {
	$cb3 = smartsql($_POST['content3']);
} else {
	$cb3 = 0;
}

$result = $jakdb->query('UPDATE '.DB_PREFIX.'setting SET value = CASE varname
	WHEN "navbarstyle_jakweb_tpl" THEN "'.smartsql($_POST['navbarstyle']).'"
	WHEN "navbarcolor_jakweb_tpl" THEN "'.smartsql($_POST['nav_color']).'"
	WHEN "navbarlinkcolor_jakweb_tpl" THEN "'.smartsql($_POST['nav_link_color']).'"
	WHEN "navbarcolorlinkbg_jakweb_tpl" THEN "'.smartsql($_POST['nav_linkbg_color']).'"
	WHEN "navbarcolorsubmenu_jakweb_tpl" THEN "'.smartsql($_POST['nav_links_color']).'"
	WHEN "logo_jakweb_tpl" THEN "'.smartsql($_POST['logo']).'"
	
	WHEN "style_jakweb_tpl" THEN "'.smartsql($_POST['tplstyle']).'"
	WHEN "boxpattern_jakweb_tpl" THEN "'.smartsql($_POST['patternboxed']).'"
	WHEN "boxbg_jakweb_tpl" THEN "'.smartsql($_POST['tplboxbgcolor']).'"
	WHEN "color_jakweb_tpl" THEN "'.smartsql($_POST['tplcolor']).'"
	WHEN "font_jakweb_tpl" THEN "'.smartsql($_POST['cFont']).'"
	WHEN "fontg_jakweb_tpl" THEN "'.smartsql($_POST['gFont']).'"
	WHEN "sidebar_location_tpl" THEN "'.smartsql($_POST['tplsidebar']).'"
	
    WHEN "theme_jakweb_tpl" THEN "'.smartsql($_POST['theme']).'"
    WHEN "pattern_jakweb_tpl" THEN "'.smartsql($_POST['pattern']).'"
    WHEN "mainbg_jakweb_tpl" THEN "'.smartsql($_POST['maingbg_color']).'"
    
    WHEN "bcontent1_jakweb_tpl" THEN "'.$cb1.'"
    WHEN "bcontent2_jakweb_tpl" THEN "'.$cb2.'"
    WHEN "bcontent3_jakweb_tpl" THEN "'.$cb3.'"
    WHEN "sectionbg_jakweb_tpl" THEN "'.smartsql($_POST['section_color']).'"
    WHEN "sectiontc_jakweb_tpl" THEN "'.smartsql($_POST['section_title_color']).'"
    WHEN "sectionshow_jakweb_tpl" THEN "'.smartsql($_POST['hide_section']).'"
    
    WHEN "footer_jakweb_tpl" THEN "'.smartsql($_POST['footer']).'"
    WHEN "fcont_jakweb_tpl" THEN "'.smartsql($_POST['footercontent']).'"
    WHEN "fcont2_jakweb_tpl" THEN "'.smartsql($_POST['footercontent2']).'"
    WHEN "fcont3_jakweb_tpl" THEN "'.smartsql($_POST['footercontent3']).'"
    WHEN "footerc_jakweb_tpl" THEN "'.smartsql($_POST['footer_color']).'"
    WHEN "footerct_jakweb_tpl" THEN "'.smartsql($_POST['footer_title_color']).'"
    WHEN "footercte_jakweb_tpl" THEN "'.smartsql($_POST['footer_text_color']).'"
    
END
	WHERE varname IN ("navbarstyle_jakweb_tpl", "navbarcolor_jakweb_tpl", "navbarlinkcolor_jakweb_tpl", "navbarcolorlinkbg_jakweb_tpl", "navbarcolorsubmenu_jakweb_tpl", "logo_jakweb_tpl", "style_jakweb_tpl", "boxpattern_jakweb_tpl", "boxbg_jakweb_tpl", "color_jakweb_tpl", "font_jakweb_tpl", "fontg_jakweb_tpl", "sidebar_location_tpl", "theme_jakweb_tpl", "pattern_jakweb_tpl", "mainbg_jakweb_tpl", "bcontent1_jakweb_tpl", "bcontent2_jakweb_tpl", "bcontent3_jakweb_tpl", "sectionbg_jakweb_tpl", "sectiontc_jakweb_tpl", "sectionshow_jakweb_tpl", "footer_jakweb_tpl", "fcont_jakweb_tpl", "fcont2_jakweb_tpl", "fcont3_jakweb_tpl", "footerc_jakweb_tpl", "footerct_jakweb_tpl", "footercte_jakweb_tpl")');
	
	if ($result) {
	
		// Ajax Request
		if (isset($_POST['jakajax']) && $_POST['jakajax'] == "yes") {
			header('Cache-Control: no-cache');
			die(json_encode(array('status' => 1, 'html' => '<div class="alert alert-success">Successful</div>')));
		} else {
		    jak_redirect($_SERVER['HTTP_REFERER']);
		}
		
	}

}

?>