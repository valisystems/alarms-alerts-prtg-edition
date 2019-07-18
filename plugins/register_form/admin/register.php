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
if (!JAK_USERID || !$jakuser->jakModuleaccess(JAK_USERID,JAK_ACCESSREGISTER_FORM)) jak_redirect(BASE_URL);

// All the tables we need for this plugin
$jaktable = DB_PREFIX.'registeroptions';
$jaktable1 = DB_PREFIX.'user';
$jaktable2 = DB_PREFIX.'pagesgrid';
$jaktable3 = DB_PREFIX.'pluginhooks';

// Now start with the plugin use a switch to access all pages
switch ($page1) {

	// Create new contactform
	case 'settings':
	
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $defaults = $_POST;
	
		$result = $jakdb->query('UPDATE '.DB_PREFIX.'setting SET value = CASE varname
		    WHEN "rf_title" THEN "'.smartsql($defaults['jak_title']).'"
		    WHEN "rf_active" THEN '.$defaults['jak_register'].'
		    WHEN "rf_simple" THEN '.$defaults['jak_simple'].'
		    WHEN "rf_confirm" THEN "'.smartsql($defaults['jak_usrapprove']).'"
		    WHEN "rf_redirect" THEN '.$defaults['jak_redirect'].'
		    WHEN "rf_usergroup" THEN '.$defaults['jak_usergroup'].'
		    WHEN "rf_welcome" THEN "'.smartsql($defaults['jak_lcontent']).'"
		END
			WHERE varname IN ("rf_title", "rf_active", "rf_simple", "rf_confirm", "rf_redirect", "rf_usergroup", "rf_welcome")');
		
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
			
					$jakdb->query('INSERT INTO '.$jaktable2.' SET plugin = '.JAK_PLUGIN_REGISTER_FORM.', hookid = "'.smartsql($key).'", pluginid = "'.smartsql($pdoith[$key]).'", whatid = "'.smartsql($whatid).'", orderid = "'.smartsql($exorder).'"');
				
				}
			
			}
		
		}
		
		// Now check if all the sidebar a deselected and hooks exist, if so delete all associated to this page
		$result = $jakdb->query('SELECT id FROM '.$jaktable2.' WHERE plugin = '.JAK_PLUGIN_REGISTER_FORM.' AND hookid != 0');
			$row = $result->fetch_assoc();
		
		if (isset($defaults['jak_hookshow_new']) && !is_array($defaults['jak_hookshow_new']) && $row['id'] && !is_array($defaults['jak_hookshow'])) {
		
			$jakdb->query('DELETE FROM '.$jaktable2.' WHERE plugin = '.JAK_PLUGIN_REGISTER_FORM.' AND hookid != 0');
		
		}
			
		// Save order or delete for extra sidebar widget
		if (isset($defaults['jak_hookshow']) && is_array($defaults['jak_hookshow'])) {
		
			$exorder = $defaults['horder'];
			$hookid = $defaults['real_hook_id'];
			$hookrealid = implode(',', $defaults['real_hook_id']);
			$doith = array_combine($hookid, $exorder);
			
			foreach ($doith as $key => $exorder) {
				
				// Get the real what id
				$result = $jakdb->query('SELECT pluginid FROM '.$jaktable2.' WHERE id = "'.smartsql($key).'" AND hookid != 0');
				$row = $result->fetch_assoc();
					
				$whatid = 0;
				if (isset($defaults['whatid_'.$row["pluginid"]])) $whatid = $defaults['whatid_'.$row["pluginid"]];
					
				if (in_array($key, $defaults['jak_hookshow'])) {
					$updatesql .= sprintf("WHEN %d THEN %d ", $key, $exorder);
					$updatesql1 .= sprintf("WHEN %d THEN %d ", $key, $whatid);
						
				} else {
					$jakdb->query('DELETE FROM '.$jaktable2.' WHERE id = '.$key);
				}
			}
				
			$jakdb->query('UPDATE '.$jaktable2.' SET orderid = CASE id
				'.$updatesql.'
				END
				WHERE id IN ('.$hookrealid.')');
				
			$jakdb->query('UPDATE '.$jaktable2.' SET whatid = CASE id
				'.$updatesql1.'
				END
				WHERE id IN ('.$hookrealid.')');
		
		}
		
		if (!$result) {
			jak_redirect(BASE_URL.'index.php?p=register-form&sp=settings&ssp=e');
		} else {		
		    jak_redirect(BASE_URL.'index.php?p=register-form&sp=settings&ssp=s');
		}
		
		}
		
		// Get the sort orders for the grid
		$grid = $jakdb->query('SELECT id, hookid, whatid, orderid FROM '.$jaktable2.' WHERE plugin = '.JAK_PLUGIN_REGISTER_FORM.' ORDER BY orderid ASC');
		while ($grow = $grid->fetch_assoc()) {
		        // collect each record into $_data
		        $JAK_PAGE_GRID[] = $grow;
		}
		
		// Get the sidebar templates
		$result = $jakdb->query('SELECT id, name, widgetcode, exorder, pluginid FROM '.$jaktable3.' WHERE hook_name = "tpl_sidebar" AND active = 1 ORDER BY exorder ASC');
		while ($row = $result->fetch_assoc()) {
			$JAK_HOOKS[] = $row;
		}
		
		$JAK_USERGROUP_ALL = jak_get_usergroup_all('usergroup');
		$JAK_SETTING = jak_get_setting('register_form');
		$JAK_CAT = jak_get_cat_info(DB_PREFIX.'categories', 0);
		
		// Get the special vars for multi language support
		$JAK_FORM_DATA["title"] = $jkv["rf_title"];
		$JAK_FORM_DATA["content"] = $jkv["rf_welcome"];
		
		// Title and Description
		$SECTION_TITLE = $lrf["register"]["r6"];
		$SECTION_DESC = "";
		
		// Call the template
		$plugin_template = 'plugins/register_form/admin/template/settings.php';
	
	break;
	default:
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $defaults = $_POST;
		   		
		   	// Write new options
		   	$countoption = $defaults['jak_option'];
		   		
		   	for ($u = 0; $u < count($countoption); $u++) {
		   	       $name = $countoption[$u];
		   	       
		   	       if (!empty($name)) {
		   	       
		   	       $sqloptions = '';
		   	       if (!empty($defaults['jak_options'][$u]) && $defaults['jak_optiontype'][$u] >= 3) {
		   	       	$sqloptions = smartsql(trim($defaults['jak_options'][$u]));
		   	       }
		   	       
		   	       if ($defaults['jak_optiontype'][$u] >= 3 && $defaults['jak_optionmandatory'][$u] > 0) {
		   	       	$sqlmand = 1;
		   	       } else { 
		   	       	$sqlmand = $defaults['jak_optionmandatory'][$u];
		   	       }
		   	       
		   	       $jakdb->query('INSERT INTO '.$jaktable.' SET
		   	       name = "'.smartsql($name).'",
		   	       typeid = "'.smartsql($defaults['jak_optiontype'][$u]).'",
		   	       options = "'.$sqloptions.'",
		   	       showregister = 1,
		   	       mandatory = "'.smartsql($sqlmand).'",
		   	       forder = "'.smartsql($defaults['jak_optionsort'][$u]).'"');
		   	       
		   	       $rowid = $jakdb->jak_last_id();
		   	       
		   	       // Insert a new field into user table, so the option will be available
		   	       $jakdb->query('ALTER TABLE '.$jaktable1.' ADD '.strtolower(preg_replace("/[^a-zA-Z0-9]+/", "", $name)).'_'.$rowid.' VARCHAR(100) NULL AFTER picture');
		   	       
		   	   	}
		   	}
		   		
		   	// Delete the options
		   	if (!empty($defaults['jak_sod'])) {
		   	    $odel = $defaults['jak_sod'];
		   	
		   	    for ($i = 0; $i < count($odel); $i++) {
		   	    	$optiondel = $odel[$i];
		   	    	
		   	    	$result = $jakdb->query('SELECT name FROM '.$jaktable.' WHERE id = '.$optiondel);
		   	    	while ($row = $result->fetch_assoc()) {
		   	    		
		   	    		// Delete the user table option
		   	    		if ($optiondel > 3) {
		   	    			$jakdb->query('ALTER TABLE '.$jaktable1.' DROP '.strtolower(preg_replace("/[^a-zA-Z0-9]+/", "", $row['name'])).'_'.$optiondel);
		   	    		}
		   	    		
		   	    	}
		   	         
		   	        // Now finally delete the option    
		   	    	$jakdb->query('DELETE FROM '.$jaktable.' WHERE id = '.$optiondel);
		   	    	
		   		}
		   		}
			
			// Edit options
			$countoption_old = $defaults['jak_option_old'];
		
		        for ($i = 0; $i < count($countoption_old); $i++) {
		            $name_old = $countoption_old[$i];
		            
		            if ($defaults['jak_optiontype_old'][$i] >= 3 && $defaults['jak_optionmandatory_old'][$i] > 0) {
		            	$sqlmand = 1;
		            } else { 
		            	$sqlmand = $defaults['jak_optionmandatory_old'][$i];
		            }
		            
		            // Do we show the fields in the register form
		            $showregister = 0;
		            if ($defaults['jak_showregister'][$i] == 1) $showregister = 1;
		            
		            // Username, email and password we show always
		            if ($defaults['jak_optionid'][$i] <= 3) $showregister = 1;
		            
		            $result = $jakdb->query('UPDATE '.$jaktable.' SET
		            name = "'.smartsql(trim($name_old)).'",
		            typeid = "'.smartsql($defaults['jak_optiontype_old'][$i]).'",
		            options = "'.smartsql(trim($defaults['jak_options_old'][$i])).'",
		            showregister = "'.smartsql($showregister).'",
		            mandatory = "'.smartsql($sqlmand).'",
		            forder = "'.smartsql($defaults['jak_optionsort_old'][$i]).'"
		            WHERE id = "'.smartsql($defaults['jak_optionid'][$i]).'"');
		            
		            if ($result && $defaults['jak_optionid'][$i] > 3 && $defaults['jak_option_name_old'][$i] != $name_old) {
		            
		            	$jakdb->query('ALTER TABLE '.$jaktable1.' DROP '.strtolower(preg_replace("/[^a-zA-Z0-9]+/", "", $defaults['jak_option_name_old'][$i])).'_'.$defaults['jak_optionid'][$i]);
		            	
		            	if ($defaults['jak_optiontype_old'][$i] == 2) {
		            	
		            		$jakdb->query('ALTER TABLE '.$jaktable1.' ADD '.strtolower(preg_replace("/[^a-zA-Z0-9]+/", "", $name_old)).'_'.$defaults['jak_optionid'][$i].' VARCHAR(100) NULL AFTER picture');
		            	
		            	} else {
		            		$jakdb->query('ALTER TABLE '.$jaktable1.' ADD '.strtolower(preg_replace("/[^a-zA-Z0-9]+/", "", $name_old)).'_'.$defaults['jak_optionid'][$i].' VARCHAR(100) NULL AFTER picture');
		            	}
		            	
		            	
		            }
		        }
			
		    jak_redirect(BASE_URL.'index.php?p=register-form&sp=s');
		}
		
		// Get contact options
		$result = $jakdb->query('SELECT * FROM '.$jaktable.' ORDER BY forder ASC');
		while ($row = $result->fetch_assoc()) {
			// collect each record into $_data
		    $JAK_REGISTEROPTION_ALL[] = $row;
		}
		
		// Title and Description
		$SECTION_TITLE = $lrf["register"]["r"];
		$SECTION_DESC = $lrf["register"]["r2"];
		
		$plugin_template = 'plugins/register_form/admin/template/rfcreate.php';
}
?>