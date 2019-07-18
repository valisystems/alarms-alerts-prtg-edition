<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Check if the file is accessed only via index.php if not stop the script from running
if (!defined('JAK_ADMIN_PREVENT_ACCESS')) die('You cannot access this file directly.');

// Check if the user has access to this file
if (!JAK_USERID || !$jakuser->jakModuleaccess(JAK_USERID, JAK_ACCESSNEWS)) jak_redirect(BASE_URL);

// All the tables we need for this plugin
$jaktable = DB_PREFIX.'news';
$jaktable1 = DB_PREFIX.'contactform';
$jaktable2 = DB_PREFIX.'pagesgrid';
$jaktable3 = DB_PREFIX.'pluginhooks';

$insert = false;

// Call the hooks per name for the template
$JAK_HOOK_ADMIN_PAGE = $jakhooks->jakGethook("tpl_admin_page_news");
$JAK_HOOK_ADMIN_PAGE_NEW = $jakhooks->jakGethook("tpl_admin_page_news_new");

// Now start with the plugin use a switch to access all pages
switch ($page1) {

	// Create new blog
	case 'new':
	
		// Important template Stuff
		$JAK_CONTACT_FORMS = jak_get_page_info($jaktable1, '');
	
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		        $defaults = $_POST;
		
		    if (empty($defaults['jak_title'])) $errors['e1'] = $tl['error']['e2'];
		    
		    if (!empty($defaults['jak_datefrom'])) {
		    	$finalfrom = strtotime($defaults['jak_datefrom']);
		    }
		    
		    if (!empty($defaults['jak_dateto'])) {
		    	$finalto = strtotime($defaults['jak_dateto']);
		    }
		    
		    if (isset($finalto) && isset($finalfrom) && $finalto < $finalfrom) {
		    	$errors['e2'] = $tl['error']['e28'];
		    }
		    
		    // Now do the dirty stuff in mysql
		    if (count($errors) == 0) {
		    
		    // Write some standard vars if empty
		    if (!isset($defaults['jak_showcontact'])) $defaults['jak_showcontact'] = 0;
		    
		    if (!isset($defaults['jak_showtitle'])) $defaults['jak_showtitle'] = 0;
		    
		    if (!isset($defaults['jak_showdate'])) $defaults['jak_showdate'] = 0;
		    
		    if (!isset($defaults['jak_social'])) $defaults['jak_social'] = 0;
		    
		    if (empty($defaults['jak_img'])) $defaults['jak_img'] = '';
		    
		    // save the time if available
		    if (isset($finalfrom)) {
		    	$insert .= 'startdate = "'.smartsql($finalfrom).'",';
		    }
		    
		    if (isset($finalto)) {
		    	$insert .= 'enddate = "'.smartsql($finalto).'",';
		    }
		    
		    if (!isset($defaults['jak_permission'])) {
		    	$permission = 0;
		    } else {
		    	$permission = join(',', $defaults['jak_permission']);
		    }
		    
		    // Get the php hook for display stuff in pages
		    $hooknews = $jakhooks->jakGethook("php_admin_news_sql");
		    if ($hooknews) { foreach($hooknews as $hne)
		    {
		    	eval($hne['phpcode']);
		    }
		    }
		
			$result = $jakdb->query('INSERT INTO '.$jaktable.' SET 
			title = "'.smartsql($defaults['jak_title']).'",
			content = "'.smartsql($defaults['jak_content']).'",
			news_css = "'.smartsql($defaults['jak_css']).'",
			news_javascript = "'.smartsql($defaults['jak_javascript']).'",
			sidebar = "'.smartsql($defaults['jak_sidebar']).'",
			previmg = "'.$defaults['jak_img'].'",
			showtitle = "'.smartsql($defaults['jak_showtitle']).'",
			showcontact = "'.smartsql($defaults['jak_showcontact']).'",
			showdate = "'.$defaults['jak_showdate'].'",
			showhits = "'.$defaults['jak_showhits'].'",
			socialbutton = "'.$defaults['jak_social'].'",
			showvote = "'.$defaults['jak_vote'].'",
			newsorder = 1,
			time = NOW(),
			permission = "'.smartsql($permission).'",
			'.$insert.'
			active = 1');
			
			$rowid = $jakdb->jak_last_id();
			
			// Save order for extra stuff
			$exorder = $defaults['corder_new'];
			$pluginid = $defaults['real_plugin_id'];
			$realid = implode(',', $defaults['real_plugin_id']);
			$doit = array_combine($pluginid, $exorder);
			
			foreach ($doit as $key => $exorder) {
			
				$jakdb->query('INSERT INTO '.$jaktable2.' SET newsid = "'.$rowid.'", pluginid = "'.$key.'", orderid = "'.smartsql($exorder).'"');
			
			}
			
			// Save order for sidebar widget
			if (isset($defaults['jak_hookshow']) && is_array($defaults['jak_hookshow'])) {
			$exorder = $defaults['horder'];
			$hookid = $defaults['real_hook_id'];
			$plugind = $defaults['sreal_plugin_id'];
			$doith = array_combine($hookid, $exorder);
			$pdoith = array_combine($hookid, $plugind);
			
			foreach ($doith as $key => $exorder) {
			
				if (in_array($key, $defaults['jak_hookshow'])) {
				
					// Get the real what id
					$whatid = 0;
					if (isset($defaults['whatid_'.$pdoith[$key]])) $whatid = $defaults['whatid_'.$pdoith[$key]];
			
					$jakdb->query('INSERT INTO '.$jaktable2.' SET newsid = "'.$rowid.'", hookid = "'.smartsql($key).'", pluginid = "'.smartsql($pdoith[$key]).'", whatid = "'.smartsql($whatid).'", orderid = "'.smartsql($exorder).'", plugin = 1');
				
				}
			
			}
			
			}
		
			if (!$result) {
		    	jak_redirect(BASE_URL.'index.php?p=news&sp=new&ssp=e');
			} else {
				
				// Create Tags if the module is active
				if (!empty($defaults['jak_tags'])) {
					// check if tag does not exist and insert in cloud
			        JAK_tags::jakBuildcloud($defaults['jak_tags'], $rowid, 1);
			        // insert tag for normal use
			        JAK_tags::jakInsertags($defaults['jak_tags'], $rowid, 1, 1);
			        

		}		
		        jak_redirect(BASE_URL.'index.php?p=news&sp=edit&ssp='.$rowid.'&sssp=s');
		    }
		 } else {
		    
		   	$errors['e'] = $tl['error']['e'];
		    $errors = $errors;
		    }
		}
		
		// Get the sidebar templates
		$result = $jakdb->query('SELECT id, name, widgetcode, exorder, pluginid FROM '.$jaktable3.' WHERE hook_name = "tpl_sidebar" AND active = 1 ORDER BY exorder ASC');
		while ($row = $result->fetch_assoc()) {
			$JAK_HOOKS[] = $row;
		}
		
		// Get active sidebar widgets
		$grid = $jakdb->query('SELECT hookid FROM '.$jaktable2.' WHERE plugin = 1 ORDER BY orderid ASC');
		while ($grow = $grid->fetch_assoc()) {
		        // collect each record into $_data
		        $JAK_ACTIVE_GRID[] = $grow;
		}
		
		// Get the php hook for display stuff in pages
		$JAK_FORM_DATA = '';
		$hookpagei = $jakhooks->jakGethook("php_admin_pages_news_info");
		if ($hookpagei) { foreach($hookpagei as $hpagi)
		{
			eval($hpagi['phpcode']);
		}
		}
		
		// Get all usergroup's
		$JAK_USERGROUP = jak_get_usergroup_all('usergroup');
		
		// Title and Description
		$SECTION_TITLE = $tl["cmenu"]["c8"];
		$SECTION_DESC = $tl["cmdesc"]["d12"];
		
		// Call the template
		$template = 'newnews.php';
	
	break;
	case 'setting':
	
		// Important template Stuff
		$JAK_SETTING = jak_get_setting('news');
		
		// Let's go on with the script
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $defaults = $_POST;
		    
		    if (empty($defaults['jak_date'])) { $errors['e1'] = $tl['error']['e4']; }
		    
		    if (!is_numeric($defaults['jak_item'])) { $errors['e2'] = $tl['error']['e15']; }
		    
		    if (!is_numeric($defaults['jak_mid'])) { $errors['e3'] = $tl['error']['e15']; }
		
		    if (count($errors) == 0) {
		    
		    // Do the dirty work in mysql
		    
		    $result = $jakdb->query('UPDATE '.DB_PREFIX.'setting SET value = CASE varname
		    	WHEN "newstitle" THEN "'.smartsql($defaults['jak_title']).'"
		    	WHEN "newsdesc" THEN "'.smartsql($defaults['jak_lcontent']).'"
		    	WHEN "newsdateformat" THEN "'.smartsql($defaults['jak_date']).'"
		    	WHEN "newstimeformat" THEN "'.smartsql($defaults['jak_time']).'"
		    	WHEN "newspagemid" THEN "'.smartsql($defaults['jak_mid']).'"
		    	WHEN "newspageitem" THEN "'.smartsql($defaults['jak_item']).'"
		    	WHEN "news_css" THEN "'.smartsql($defaults['jak_css']).'"
		    	WHEN "news_javascript" THEN "'.smartsql($defaults['jak_javascript']).'"     
		    END
				WHERE varname IN ("newstitle","newsdesc", "newsdateformat", "newstimeformat", "newspagemid", "newspageitem","news_css","news_javascript")');
				
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
						
						$jakdb->query('INSERT INTO '.$jaktable2.' SET plugin = 1, hookid = "'.smartsql($key).'", pluginid = "'.smartsql($pdoith[$key]).'", whatid = "'.smartsql($whatid).'", orderid = "'.smartsql($exorder).'"');
					
					}
				
				}
			
			}
			
			// Now check if all the sidebar a deselct and hooks exist, if so delete all associated to this page
			$row = $jakdb->queryRow('SELECT id FROM '.$jaktable2.' WHERE plugin = 1 AND hookid != 0');
			
			if (isset($defaults['jak_hookshow_new']) && !is_array($defaults['jak_hookshow_new']) && $row['id'] && !is_array($defaults['jak_hookshow'])) {
			
				$jakdb->query('DELETE FROM '.$jaktable2.' WHERE plugin = 1 AND hookid != 0');
			
			}
				
			// Save order or delete for extra sidebar widget
			if (isset($defaults['jak_hookshow']) && is_array($defaults['jak_hookshow'])) {
			
				$exorder = $defaults['horder'];
				$hookid = $defaults['real_hook_id'];
				$hookrealid = implode(',', $defaults['real_hook_id']);
				$doith = array_combine($hookid, $exorder);
				
				// Reset update
				$updatesql = $updatesql1 = "";
				
				// Run the foreach for the hooks
				foreach ($doith as $key => $exorder) {
				
					// Get the real what id
					$row = $jakdb->queryRow('SELECT pluginid FROM '.$jaktable2.' WHERE id = "'.smartsql($key).'" AND hookid != 0');
					
					// Get the whatid
					$whatid = 0;
					if (isset($defaults['whatid_'.$row["pluginid"]])) $whatid = $defaults['whatid_'.$row["pluginid"]];
						
						if (in_array($key, $defaults['jak_hookshow'])) {
							$updatesql .= sprintf("WHEN %d THEN %d ", $key, $exorder);
							$updatesql1 .= sprintf("WHEN %d THEN %d ", $key, $whatid);
							
						} else {
							$jakdb->query('DELETE FROM '.$jaktable2.' WHERE id = "'.smartsql($key).'"');
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
			
			} else {
				$jakdb->query('DELETE FROM '.$jaktable2.' WHERE plugin = 1 AND newsid = 0 AND hookid != 0');
			}
				
			if (!$result) {
				jak_redirect(BASE_URL.'index.php?p=news&sp=setting&ssp=e');
			} else {
		        jak_redirect(BASE_URL.'index.php?p=news&sp=setting&ssp=s');
		    }
		    } else {
		    
		   	$errors['e'] = $tl['error']['e'];
		    $errors = $errors;
		    }
		}
		
		// Get the sort orders for the grid
		$grid = $jakdb->query('SELECT id, hookid, whatid, orderid FROM '.$jaktable2.' WHERE plugin = 1 ORDER BY orderid ASC');
		while ($grow = $grid->fetch_assoc()) {
		        // collect each record into $_data
		        $JAK_PAGE_GRID[] = $grow;
		}
		
		// Get the sidebar templates
		$result = $jakdb->query('SELECT id, name, widgetcode, exorder, pluginid FROM '.$jaktable3.' WHERE hook_name = "tpl_sidebar" AND active = 1 ORDER BY exorder ASC');
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
		$JAK_FORM_DATA["title"] = $jkv["newstitle"];
		$JAK_FORM_DATA["content"] = $jkv["newsdesc"];
		
		// Title and Description
		$SECTION_TITLE = $tl["menu"]["m2"];
		$SECTION_DESC = $tl["cmdesc"]["d37"];
		
		// Call the template
		$template = 'newssetting.php';
		
	break;
	default:
		
		// Important template Stuff
		$JAK_CONTACT_FORMS = jak_get_page_info($jaktable1, '');

		switch ($page1) {
    	case 'lock':
	        if (is_numeric($page2) && jak_row_exist($page2,$jaktable)) {
	                
		    	$result = $jakdb->query('UPDATE '.$jaktable.' SET active = IF (active = 1, 0, 1) WHERE id = "'.smartsql($page2).'"');
	  		
	  			JAK_tags::jakLocktags($page2, 1);
	  		
	 		if (!$result) {
				jak_redirect(BASE_URL.'index.php?p=news&sp=e');
			} else {
	        	jak_redirect(BASE_URL.'index.php?p=news&sp=s');
	    	}
	    
	    	} else {
		   		jak_redirect(BASE_URL.'index.php?p=news&sp=ene');
			}
        break;
    	case 'delete':
	        if (is_numeric($page2) && jak_row_exist($page2,$jaktable)) {
	
				$result = $jakdb->query('DELETE FROM '.$jaktable.' WHERE id = "'.smartsql($page2).'"');
	
			if (!$result) {
		    	jak_redirect(BASE_URL.'index.php?p=news&sp=e');
			} else {
				JAK_tags::jakDeletetags($page2, 1);

				
		        jak_redirect(BASE_URL.'index.php?p=news&sp=s');
	    	}
			} else {
	    		jak_redirect(BASE_URL.'index.php?p=news&sp=ene');
			}
        break;
    	case 'edit':
	        if (jak_row_exist($page2,$jaktable)) {
	
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	    	$defaults = $_POST;
	    
		    // Delete the tags
		    if (!empty($defaults['jak_tagdelete'])) {
		    $tags = $defaults['jak_tagdelete'];
		
		        for ($i = 0; $i < count($tags); $i++) {
		            $tag = $tags[$i];
		            
		            JAK_tags::jakDeleteonetag($tag);
		            
		        }

		    }
		    
		    // Delete the likes
		    if (!empty($defaults['jak_delete_rate'])) {
		    	$jakdb->query('DELETE FROM '.DB_PREFIX.'like_counter WHERE btnid = "'.smartsql($page2).'" AND locid = 1');
		    	$jakdb->query('DELETE FROM '.DB_PREFIX.'like_client WHERE btnid = "'.smartsql($page2).'" AND locid = 1');
		    }
		    
		    // Delete the hits
		    if (!empty($defaults['jak_delete_hits'])) {
		    	$jakdb->query('UPDATE '.$jaktable.' SET hits = 1 WHERE id = "'.smartsql($page2).'"');
		    }
	
		    if (empty($defaults['jak_title'])) {
		        $errors['e1'] = $tl['error']['e2'];
		    }
		    
		    if (!empty($defaults['jak_datefrom'])) {
		    	$finalfrom = strtotime($defaults['jak_datefrom']);
		    }
		    
		    if (!empty($defaults['jak_dateto'])) {
		    	$finalto = strtotime($defaults['jak_dateto']);
		    }
		    
		    if (isset($finalto) && isset($finalfrom) && $finalto < $finalfrom) {
		    	$errors['e2'] = $tl['error']['e28'];
		    }
		    
		    // Now do the dirty stuff in mysql       
		    if (count($errors) == 0) {
		    
		    if (empty($defaults['jak_img'])) $defaults['jak_img'] = '';
		    
		    // Update time
		    if (!empty($defaults['jak_update_time'])) {
		    	$insert .= 'time = NOW(),';
		    }
		    
		    // save the time if available
		    if (isset($finalfrom)) {
		    	$insert .= 'startdate = "'.smartsql($finalfrom).'",';
		    }
		    
		    if (isset($finalto)) {
		    	$insert .= 'enddate = "'.smartsql($finalto).'",';
		    }
		    
		    if (!isset($defaults['jak_permission'])) {
		    	$permission = 0;
		    } else {
		    	$permission = join(',', $defaults['jak_permission']);
		    }
		    
		    // Get the php hook for display stuff in pages
		    $hooknews = $jakhooks->jakGethook("php_admin_news_sql");
		    if ($hooknews) {
		    foreach($hooknews as $hne)
		    {
		    	eval($hne['phpcode']);
		    }
		    }
		
			$result = $jakdb->query('UPDATE '.$jaktable.' SET 
			title = "'.smartsql($defaults['jak_title']).'",
			content = "'.smartsql($defaults['jak_content']).'",
			news_css = "'.smartsql($defaults['jak_css']).'",
			news_javascript = "'.smartsql($defaults['jak_javascript']).'",
			sidebar = "'.smartsql($defaults['jak_sidebar']).'",
			previmg = "'.smartsql($defaults['jak_img']).'",
			showtitle = "'.smartsql($defaults['jak_showtitle']).'",
			showcontact = "'.smartsql($defaults['jak_showcontact']).'",
			showdate = "'.smartsql($defaults['jak_showdate']).'",
			showhits = "'.smartsql($defaults['jak_showhits']).'",
			socialbutton = "'.smartsql($defaults['jak_social']).'",
			'.$insert.'
			permission = "'.smartsql($permission).'",
			showvote = "'.smartsql($defaults['jak_vote']).'"
			WHERE id = "'.smartsql($page2).'"');
			
			// Insert new stuff first if exist order for extra stuff
			if (isset($defaults['real_plugin_id'])) {
				$exorder = $defaults['corder_new'];
				$pluginid = $defaults['real_plugin_id'];
				$doit = array_combine($pluginid, $exorder);
				
				foreach ($doit as $key => $exorder) {
				
					$jakdb->query('INSERT INTO '.$jaktable2.' SET newsid = "'.$page2.'", pluginid = "'.$key.'", orderid = "'.smartsql($exorder).'"');
				
				}
			
			}
			
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
						
						$jakdb->query('INSERT INTO '.$jaktable2.' SET newsid = "'.$page2.'", hookid = "'.smartsql($key).'", pluginid = "'.smartsql($pdoith[$key]).'", whatid = "'.smartsql($whatid).'", orderid = "'.smartsql($exorder).'", plugin = 1');
					
					}
				
				}
			
			}
			
			// Save order for extra stuff
			$exorder = $defaults['corder'];
			$pluginid = $defaults['real_id'];
			$realid = implode(',', $defaults['real_id']);
			$doit = array_combine($pluginid, $exorder);
			
			foreach ($doit as $key => $exorder) {
				$updatesql .= sprintf("WHEN %d THEN %d ", $key, $exorder);
			}
			
			$jakdb->query('UPDATE '.$jaktable2.' SET orderid = CASE id
			'.$updatesql.'
			END
			WHERE id IN ('.$realid.')');
			
			// Now check if all the sidebar a deselct and hooks exist, if so delete all associated to this page
			$result = $jakdb->query('SELECT id FROM '.$jaktable2.' WHERE newsid = "'.smartsql($page2).'" AND hookid != 0');
				$row = $result->fetch_assoc();
			
			if (isset($defaults['jak_hookshow_new']) && !is_array($defaults['jak_hookshow_new']) && $row['id'] && !is_array($defaults['jak_hookshow'])) {
			
				$jakdb->query('DELETE FROM '.$jaktable2.' WHERE newsid = "'.smartsql($page2).'" AND hookid != 0');
			
			}
			
			// Save order or delete for extra sidebar widget
			if (isset($defaults['jak_hookshow']) && is_array($defaults['jak_hookshow'])) {
			
				$exorder = $defaults['horder'];
				$hookid = $defaults['real_hook_id'];
				$hookrealid = implode(',', $defaults['real_hook_id']);
				$doith = array_combine($hookid, $exorder);
				
				// Reset update
				$updatesql = $updatesql1 = "";
				
				// Run the foreach for the hooks
				foreach ($doith as $key => $exorder) {
					
					// Get the real what id
					$result = $jakdb->query('SELECT pluginid FROM '.$jaktable2.' WHERE id = "'.smartsql($key).'" AND hookid != 0');
					$row = $result->fetch_assoc();
						
					// Get the whatid
					$whatid = 0;
					if (isset($defaults['whatid_'.$row["pluginid"]])) $whatid = $defaults['whatid_'.$row["pluginid"]];
						
						if (in_array($key, $defaults['jak_hookshow'])) {
							$updatesql .= sprintf("WHEN %d THEN %d ", $key, $exorder);
							$updatesql1 .= sprintf("WHEN %d THEN %d ", $key, $whatid);
							
						} else {
							$jakdb->query('DELETE FROM '.$jaktable2.' WHERE id = "'.smartsql($key).'"');
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
	    		jak_redirect(BASE_URL.'index.php?p=news&sp=edit&ssp='.$page2.'&sssp=e');
			} else {
			
			// Set tag active to zero
			$tagactive = 0;
			
			if ($defaults['jak_active'] != 0) {
				
				// Set tag active, well to active
				$tagactive = 1;
				
			}
		
			// Create Tags if the module is active
			if (!empty($defaults['jak_tags'])) {
				// check if tag does not exist and insert in cloud
		        JAK_tags::jakBuildcloud($defaults['jak_tags'], smartsql($page2), 1);
		        // insert tag for normal use
		        JAK_tags::jakInsertags($defaults['jak_tags'], smartsql($page2), 1, $tagactive);

			}

			
	        	jak_redirect(BASE_URL.'index.php?p=news&sp=edit&ssp='.$page2.'&sssp=s');
	    	}
	 		} else {
	    
		   	$errors['e'] = $tl['error']['e'];
		    $errors = $errors;
		    }
			}
	
			$JAK_FORM_DATA = jak_get_data($page2,$jaktable);
			if (JAK_TAGS) $JAK_TAGLIST = jak_get_tags($page2, 1);
			
			// Get the sort orders for the grid
			$grid = $jakdb->query('SELECT id, pluginid, hookid, whatid, orderid FROM '.$jaktable2.' WHERE newsid = "'.smartsql($page2).'" ORDER BY orderid ASC');
			while ($grow = $grid->fetch_assoc()) {
			        // collect each record into $_data
			        $JAK_PAGE_GRID[] = $grow;
			}
			
			// Get the sidebar templates
			$result = $jakdb->query('SELECT id, name, widgetcode, exorder, pluginid FROM '.$jaktable3.' WHERE hook_name = "tpl_sidebar" AND active = 1 ORDER BY exorder ASC');
			while ($row = $result->fetch_assoc()) {
				$JAK_HOOKS[] = $row;
			}
			
			// Get the php hook for display stuff in pages
			$hookpagei = $jakhooks->jakGethook("php_admin_pages_news_info");
			if ($hookpagei) { foreach($hookpagei as $hpagi)
			{
				eval($hpagi['phpcode']);
			}
			}
			
			// Get all usergroup's
			$JAK_USERGROUP = jak_get_usergroup_all('usergroup');
			
			// Title and Description
			$SECTION_TITLE = $tl["cmenu"]["c9"];
			$SECTION_DESC = $tl["cmdesc"]["d12"];
			
			$template = 'editnews.php';
			
			} else {
			   	jak_redirect(BASE_URL.'index.php?p=news&sp=ene');
			}
		break;
		case 'quickedit':
		        if (jak_row_exist($page2,$jaktable)) {
		
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    	$defaults = $_POST;
		
			    if (empty($defaults['jak_title'])) {
			        $errors['e1'] = $tl['error']['e2'];
			    }
			    
			    // Now do the dirty stuff in mysql       
			    if (count($errors) == 0) {
			
				$result = $jakdb->query('UPDATE '.$jaktable.' SET 
				title = "'.smartsql($defaults['jak_title']).'",
				content = "'.smartsql($defaults['jak_lcontent']).'"
				WHERE id = "'.smartsql($page2).'"');
		
				if (!$result) {
		    		jak_redirect(BASE_URL.'index.php?p=news&sp=quickedit&ssp='.$page2.'&sssp=e');
				} else {
		        	jak_redirect(BASE_URL.'index.php?p=news&sp=quickedit&ssp='.$page2.'&sssp=s');
		    	}
		 		} else {
		    
			   	$errors['e'] = $tl['error']['e'];
			    $errors = $errors;
			    }
				}
				
				// Get the data
				$JAK_FORM_DATA = jak_get_data($page2,$jaktable);
				
				$template = 'quickedit.php';
				
				} else {
				   	jak_redirect(BASE_URL.'index.php?p=news&sp=ene');
				}
		break;
		default:
			
			// Get total news
			$getTotal = jak_get_total($jaktable,'','','');
			if ($getTotal != 0) {
			
				// Paginator
				$pages = new JAK_Paginator;
				$pages->items_total = $getTotal;
				$pages->mid_range = $jkv["adminpagemid"];
				$pages->items_per_page = $jkv["adminpageitem"];
				$pages->jak_get_page = $page1;
				$pages->jak_where = 'index.php?p=news';
				$pages->paginate();
				$JAK_PAGINATE = $pages->display_pages();
				
				// Call the news with paginate
				$JAK_NEWS = jak_get_news_info($pages->limit);
			}
			
			// Title and Description
			$SECTION_TITLE = $tl["menu"]["m8"];
			$SECTION_DESC = $tl["cmdesc"]["d11"];
			    
			// Call the template
			$template = 'news.php';
		}
}
?>