<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Check if the file is accessed only via index.php if not stop the script from running
if (!defined('JAK_ADMIN_PREVENT_ACCESS')) die('You cannot access this file directly.');

// Check if the user has access to this file
if (!JAK_USERID || !$JAK_MODULES) jak_redirect(BASE_URL);

// All the tables we need for this plugin
$jaktable = DB_PREFIX.'pagesgrid';
$jaktable2 = DB_PREFIX.'pluginhooks';

// Important template Stuff
$JAK_SETTING = jak_get_setting('sitemap');

// Let's go on with the script
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $defaults = $_POST;
    
    // Do the dirty work in mysql
    
    $result = $jakdb->query('UPDATE '.DB_PREFIX.'setting SET value = CASE varname
    	WHEN "sitemaptitle" THEN "'.smartsql($defaults['jak_title']).'"
    	WHEN "sitemapdesc" THEN "'.smartsql($defaults['jak_lcontent']).'"       
    END
		WHERE varname IN ("sitemaptitle", "sitemapdesc")');
		
	// Save order for sidebar widget
	if (isset($defaults['jak_hookshow_new']) && is_array($defaults['jak_hookshow_new'])) {
	
		$exorder = $defaults['horder_new'];
		$hookid = $defaults['real_hook_id_new'];
		$plugind = $defaults['sreal_plugin_id_new'];
		$doith = array_combine($hookid, $exorder);
		$pdoith = array_combine($hookid, $plugind);
		
		foreach ($doith as $key => $exorder) {
		
			if (in_array($key, $defaults['jak_hookshow_new'])) {
			
				// Get the real what id
				$whatid = 0;
				if (isset($defaults['whatid_'.$pdoith[$key]])) $whatid = $defaults['whatid_'.$pdoith[$key]];
		
				$jakdb->query('INSERT INTO '.$jaktable.' SET plugin = 2, hookid = "'.smartsql($key).'", pluginid = "'.smartsql($pdoith[$key]).'", whatid = "'.smartsql($whatid).'", orderid = "'.smartsql($exorder).'"');
			
			}
		
		}
	
	}
	
	// Now check if all the sidebar a deselct and hooks exist, if so delete all associated to this page
	$result = $jakdb->query('SELECT id FROM '.$jaktable.' WHERE plugin = 2 AND hookid != 0');
		$row = $result->fetch_assoc();
	
	if (isset($defaults['jak_hookshow_new']) && !is_array($defaults['jak_hookshow_new']) && $row['id'] && !is_array($defaults['jak_hookshow'])) {
	
		$jakdb->query('DELETE FROM '.$jaktable.' WHERE plugin = 2 AND hookid != 0');
	
	}
		
	// Save order or delete for extra sidebar widget
	if (isset($defaults['jak_hookshow']) && is_array($defaults['jak_hookshow'])) {
	
		$exorder = $defaults['horder'];
		$hookid = $defaults['real_hook_id'];
		$hookrealid = implode(',', $defaults['real_hook_id']);
		$doith = array_combine($hookid, $exorder);
		
		foreach ($doith as $key => $exorder) {
			
			// Get the real what id
			$result = $jakdb->query('SELECT pluginid FROM '.$jaktable.' WHERE id = "'.smartsql($key).'" AND hookid != 0');
			$row = $result->fetch_assoc();
			
			$whatid = 0;
			if (isset($defaults['whatid_'.$row["pluginid"]])) $whatid = $defaults['whatid_'.$row["pluginid"]];
				
			if (in_array($key, $defaults['jak_hookshow'])) {
				$updatesql .= sprintf("WHEN %d THEN %d ", $key, $exorder);
				$updatesql1 .= sprintf("WHEN %d THEN %d ", $key, $whatid);
					
			} else {
				$jakdb->query('DELETE FROM '.$jaktable.' WHERE id = '.$key);
			}
		}
			
		$jakdb->query('UPDATE '.$jaktable.' SET orderid = CASE id
			'.$updatesql.'
			END
			WHERE id IN ('.$hookrealid.')');
			
		$jakdb->query('UPDATE '.$jaktable.' SET whatid = CASE id
			'.$updatesql1.'
			END
			WHERE id IN ('.$hookrealid.')');
	
	}
		
	if (!$result) {
		jak_redirect(BASE_URL.'index.php?p=sitemap&sp=e');
	} else {
        jak_redirect(BASE_URL.'index.php?p=sitemap&sp=s');
    }
}

// Get the sort orders for the grid
$grid = $jakdb->query('SELECT id, hookid, whatid, orderid FROM '.$jaktable.' WHERE plugin = 2 ORDER BY orderid ASC');
while ($grow = $grid->fetch_assoc()) {
        // collect each record into $_data
        $JAK_PAGE_GRID[] = $grow;
}

// Get the sidebar templates
$result = $jakdb->query('SELECT id, name, widgetcode, exorder, pluginid FROM '.$jaktable2.' WHERE hook_name = "tpl_sidebar" AND active = 1 ORDER BY exorder ASC');
while ($row = $result->fetch_assoc()) {
	$JAK_HOOKS[] = $row;
}

// Get the php hook for display stuff in pages
$JAK_FORM_DATA = '';
$hookpagei = $jakhooks->jakGethook("php_admin_pages_news_info");
if ($hookpagei) { foreach($hookpagei as $hpagi)
{
	eval($hpagi['phpcode']);
}
}

// Get the special vars for multi language support
$JAK_FORM_DATA["title"] = $jkv["sitemaptitle"];
$JAK_FORM_DATA["content"] = $jkv["sitemapdesc"];

// Title and Description
$SECTION_TITLE = $tl["menu"]["m16"];
$SECTION_DESC = "";

// Call the template
$template = 'sitemapsetting.php';
?>