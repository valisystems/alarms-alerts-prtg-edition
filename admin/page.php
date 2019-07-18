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
if (!JAK_USERID || !$JAK_MODULEM) jak_redirect(BASE_URL);

// All the tables we need for this plugin
$jaktable = DB_PREFIX.'pages';
$jaktable1 = DB_PREFIX.'categories';
$jaktable2 = DB_PREFIX.'contactform';
$jaktable3 = DB_PREFIX.'pagesgrid';
$jaktable4 = DB_PREFIX.'news';
$jaktable5 = DB_PREFIX.'pluginhooks';
$jaktable6 = DB_PREFIX.'backup_content';

$JAK_HOOK_ADMIN_PAGE = $jakhooks->jakGethook("tpl_admin_page_news");
$JAK_HOOK_ADMIN_PAGE_NEW = $jakhooks->jakGethook("tpl_admin_page_news_new");

$insert = $updatesql = "";

// Now start with the plugin use a switch to access all pages
switch ($page1) {

	// Create new page
	case 'newpage':
		
		// Important template stuff
		$JAK_CONTACT_FORMS = jak_get_page_info($jaktable2, '');
		$JAK_GET_NEWS = jak_get_page_info($jaktable4, '');
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $defaults = $_POST;
		    
		    if (isset($defaults['save'])) {
		
		    if (empty($defaults['jak_title'])) {
		        $errors['e1'] = $tl['error']['e2'];
		    }
		    
		    // Now do the dirty stuff in mysql
		    if (count($errors) == 0) {
		    
		    if (empty($defaults['jak_shownews'])) {
		    	$news = 0;
		    } elseif (is_array($defaults['jak_shownews']) && in_array(0, $defaults['jak_shownews'])) {
		    	$news = 0;
		    } else {
		    	$news = join(',', $defaults['jak_shownews']);
		    }
		    
		    if (empty($news) && !empty($defaults['jak_shownewsmany'])) {
		    	$news = $defaults['jak_shownewsorder'].':'.$defaults['jak_shownewsmany'];
		    }
		    
		    // The new password encrypt with hash_hmac
		    if ($defaults['jak_password']) {
		    	$passcrypt = hash_hmac('sha256', $defaults['jak_password'], DB_PASS_HASH);
		    	$insert .= 'password = "'.$passcrypt.'",';
		    }
		    
		    // Get the php hook for display stuff in pages
		    $hookpage = $jakhooks->jakGethook("php_admin_pages_sql");
		    if ($hookpage) { foreach($hookpage as $hpag)
		    {
		    	eval($hpag['phpcode']);
		    }
		    }
		
			$result = $jakdb->query('INSERT INTO '.$jaktable.' SET 
			catid = '.smartsql($defaults['jak_catid']).',
			title = "'.smartsql($defaults['jak_title']).'",
			content = "'.smartsql($defaults['jak_content']).'",
			page_css = "'.smartsql($defaults['jak_css']).'",
			page_javascript = "'.smartsql($defaults['jak_javascript']).'",
			sidebar = "'.smartsql($defaults['jak_sidebar']).'",
			shownav = "'.smartsql($defaults['jak_shownav']).'",
			showfooter = "'.smartsql($defaults['jak_showfooter']).'",
			showtitle = "'.smartsql($defaults['jak_showtitle']).'",
			showcontact = "'.smartsql($defaults['jak_showcontact']).'",
			shownews = "'.smartsql($news).'",
			showdate = "'.smartsql($defaults['jak_showdate']).'",
			showtags = "'.smartsql($defaults['jak_showtags']).'",
			showlogin = "'.smartsql($defaults['jak_showlogin']).'",
			socialbutton = "'.smartsql($defaults['jak_social']).'",
			showvote = "'.smartsql($defaults['jak_vote']).'",
			'.$insert.'
			time = NOW()');
		
			$rowid = $jakdb->jak_last_id();
		
			// Save order for extra stuff
			$exorder = $defaults['corder_new'];
			$pluginid = $defaults['real_plugin_id'];
			$doit = array_combine($pluginid, $exorder);
			
			foreach ($doit as $key => $exorder) {
			
				$jakdb->query('INSERT INTO '.$jaktable3.' SET pageid = "'.smartsql($rowid).'", pluginid = "'.smartsql($key).'", orderid = "'.smartsql($exorder).'"');
			
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
					
					$jakdb->query('INSERT INTO '.$jaktable3.' SET pageid = "'.smartsql($rowid).'", hookid = "'.smartsql($key).'", pluginid = "'.smartsql($pdoith[$key]).'", whatid = "'.smartsql($whatid).'", orderid = "'.smartsql($exorder).'"');
				
				}
			
			}
			
			}
		
			// Set tag active to zero
			$tagactive = 0;
			
			if ($defaults['jak_catid'] != '0') {
				$jakdb->query('UPDATE '.$jaktable1.' SET pageid = "'.smartsql($rowid).'" WHERE id = "'.smartsql($defaults['jak_catid']).'"');
				
				// Set tag active, well to active
				$tagactive = 1;
			}
		
			if (!$result) {
		    	jak_redirect(BASE_URL.'index.php?p=page&sp=newpage&ssp=e');
			} else {
		
		// Create Tags if the module is active
		if (!empty($defaults['jak_tags'])) {
				// check if tag does not exist and insert in cloud
			       JAK_tags::jakBuildcloud($defaults['jak_tags'], $rowid, 0);
			       // insert tag for normal use
			        JAK_tags::jakInsertags($defaults['jak_tags'], $rowid, 0, $tagactive);
		}
		        jak_redirect(BASE_URL.'index.php?p=page&sp=edit&ssp='.$rowid.'&sssp=s');
		    }
		 } else {
		   	$errors['e'] = $tl['error']['e'];
		    $errors = $errors;
		   }
		}
		}
		
		$JAK_CAT_NOTUSED = jak_get_cat_notused();
		
		// Get the sidebar templates
		$result = $jakdb->query('SELECT id, name, widgetcode, exorder, pluginid FROM '.$jaktable5.' WHERE hook_name = "tpl_sidebar" AND active = 1 ORDER BY exorder ASC');
		while ($row = $result->fetch_assoc()) {
			$JAK_HOOKS[] = $row;
		}
		
		// Get the php hook for display stuff in pages
		$JAK_FORM_DATA = '';
		$hookpagei = $jakhooks->jakGethook("php_admin_pages_news_info");
		if ($hookpagei) {
			foreach($hookpagei as $hpagi) {
				eval($hpagi['phpcode']);
			}
		}
		
		// Title and Description
		$SECTION_TITLE = $tl["cmenu"]["c5"];
		$SECTION_DESC = $tl["cmdesc"]["d10"];
		
		// Call the template
		$template = 'newpage.php';
		
	break;
	default:
	
		// Important template stuff
		$JAK_CAT = jak_get_cat_info($jaktable1, 1);
		$JAK_CONTACT_FORMS = jak_get_page_info($jaktable2, '');
	 
	 	switch ($page1) {
	 	case 'lock':
	 	
	 		$result = $jakdb->query('UPDATE '.$jaktable.' SET active = IF (active = 1, 0, 1) WHERE id = "'.smartsql($page2).'"');
	     	
	     	JAK_tags::jakLocktags($page2, 0);
	     	
			 if (!$result) {
			 	jak_redirect(BASE_URL.'index.php?p=page&sp=e');
			 } else {
			     jak_redirect(BASE_URL.'index.php?p=page&sp=s');
			 }
	 	
	 	break;
	 	case 'sort':
	 	
	 	 	// getNumber
	 	 	$getTotal = jak_get_total($jaktable,'','','');
	 	 	
	 	 	// Now if total run paginator
	 	 	if ($getTotal != 0) {
	 	 		// Paginator
	 	 		$pages = new JAK_Paginator;
	 	 		$pages->items_total = $getTotal;
	 	 		$pages->mid_range = $jkv["adminpagemid"];
	 	 		$pages->items_per_page = $jkv["adminpageitem"];
	 	 		$pages->jak_get_page = $page4;
	 	 		$pages->jak_where = 'index.php?p=page&sp=sort&ssp='.$page2.'&sssp='.$page3;
	 	 		$pages->paginate();
	 	 		$JAK_PAGINATE = $pages->display_pages();
	 	 	}
	 	 	
	 	 	$result = $jakdb->query('SELECT * FROM '.$jaktable.' ORDER BY '.$page2.' '.$page3.' '.$pages->limit);
	 	 	while ($row = $result->fetch_assoc()) {
	 	 	    $pagearray[] = $row;
	 	 	}
	 	 	
	 	 	$JAK_PAGE_ALL = $pagearray;
	 	 	
	 	 	// Title and Description
	 	 	$SECTION_TITLE = $tl["icons"]["i4"];
	 	 	$SECTION_DESC = $tl["cmdesc"]["d10"];
	 	 	
	 	 	// Call the template
	 	 	$template = 'pages.php';
	 	 		
	 	break;
	    case 'delete':
	        if (is_numeric($page2) && jak_row_exist($page2,$jaktable)) {
	
				$result = $jakdb->query('DELETE FROM '.$jaktable.' WHERE id = "'.smartsql($page2).'"');
				$jakdb->query('UPDATE '.$jaktable1.' SET pageid = 0 WHERE pageid = "'.smartsql($page2).'"');
				$jakdb->query('DELETE FROM '.$jaktable3.' WHERE pageid = "'.smartsql($page2).'"');
		
				if (!$result) {
				    jak_redirect(BASE_URL.'index.php?p=page&sp=e');
				} else {
					JAK_tags::jakDeletetags($page2, 0);
						
				        jak_redirect(BASE_URL.'index.php?p=page&ssp=s');
				    }
				    
			} else {
			   	jak_redirect(BASE_URL.'index.php?p=page&sp=ene');
			}
		break;
		case 'edit':
		
		if (is_numeric($page2) && jak_row_exist($page2,$jaktable)) {
		
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
		    	$jakdb->query('DELETE FROM '.DB_PREFIX.'like_counter WHERE btnid = "'.smartsql($page2).'" AND locid = 999');
		    	$jakdb->query('DELETE FROM '.DB_PREFIX.'like_client WHERE btnid = "'.smartsql($page2).'" AND locid = 999');
		    }
		    
		    // Delete the password
		    if (!empty($defaults['jak_delete_password'])) {
		    	$jakdb->query('UPDATE '.$jaktable.' SET password = NULL WHERE id = "'.smartsql($page2).'"');
		    }
		    
		    // Delete the hits
		    if (!empty($defaults['jak_delete_hits'])) {
		    	$jakdb->query('UPDATE '.$jaktable.' SET hits = 1 WHERE id = "'.smartsql($page2).'"');
		    }
		
		    if (empty($defaults['jak_title'])) {
		        $errors['e1'] = $tl['error']['e2'];
		    }
		    
		    // Now do the dirty stuff
		    if (count($errors) == 0) {
		    
		    	// Update time
		    	if (!empty($defaults['jak_update_time'])) {
		    		$insert .= 'time = NOW(),';
		    	}
		    	
		    	if (empty($defaults['jak_shownews'])) {
		    		$news = 0;
		    	} elseif (is_array($defaults['jak_shownews']) && in_array(0, $defaults['jak_shownews'])) {
		    		$news = 0;
		    	} else {
		    		$news = join(',', $defaults['jak_shownews']);
		    	}
		    	
		    	if (empty($news) && !empty($defaults['jak_shownewsmany'])) {
		    		$news = $defaults['jak_shownewsorder'].':'.$defaults['jak_shownewsmany'];
		    	}
		    	
		    	// The new password encrypt with hash_hmac
		    	if ($defaults['jak_password']) {
		    		$insert .= 'password = "'.hash_hmac('sha256', $defaults['jak_password'], DB_PASS_HASH).'",';
		    	}
		    	
		    	// Get the php hook for display stuff in pages
		    	$hookpage = $jakhooks->jakGethook("php_admin_pages_sql");
		    	if ($hookpage) { foreach($hookpage as $hpag)
		    	{
		    		eval($hpag['phpcode']);
		    	}
		    	}
		    	
		    	// Get the old content first
		    	$rowsb = $jakdb->queryRow('SELECT content FROM '.$jaktable.' WHERE id = "'.smartsql($page2).'"');
		    		
		    	// Insert the content into the backup table
		    	$jakdb->query('INSERT INTO '.$jaktable6.' SET 
		    	pageid = "'.smartsql($page2).'",
		    	content = "'.smartsql($rowsb['content']).'",
		    	time = NOW()');
		
				$result = $jakdb->query('UPDATE '.$jaktable.' SET 
				catid = "'.smartsql($defaults['jak_catid']).'",
				title = "'.smartsql($defaults['jak_title']).'",
				content = "'.smartsql($defaults['jak_content']).'",
				page_css = "'.smartsql($defaults['jak_css']).'",
				page_javascript = "'.smartsql($defaults['jak_javascript']).'",
				sidebar = "'.smartsql($defaults['jak_sidebar']).'",
				shownav = "'.smartsql($defaults['jak_shownav']).'",
				showfooter = "'.smartsql($defaults['jak_showfooter']).'",
				showtitle = "'.smartsql($defaults['jak_showtitle']).'",
				showcontact = "'.smartsql($defaults['jak_showcontact']).'",
				shownews = "'.smartsql($news).'",
				showdate = "'.smartsql($defaults['jak_showdate']).'",
				showtags = "'.smartsql($defaults['jak_showtags']).'",
				showlogin = "'.smartsql($defaults['jak_showlogin']).'",
				socialbutton = "'.smartsql($defaults['jak_social']).'",
				'.$insert.'
				showvote = "'.smartsql($defaults['jak_vote']).'"
				WHERE id = "'.smartsql($page2).'"');
		
		// Insert new stuff first if exist order for extra stuff
		if (isset($defaults['real_plugin_id'])) {
			$exorder = $defaults['corder_new'];
			$pluginid = $defaults['real_plugin_id'];
			$doit = array_combine($pluginid, $exorder);
			
			foreach ($doit as $key => $exorder) {
			
				$jakdb->query('INSERT INTO '.$jaktable3.' SET pageid = "'.smartsql($page2).'", pluginid = "'.smartsql($key).'", orderid = "'.smartsql($exorder).'"');
			
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
			
					$jakdb->query('INSERT INTO '.$jaktable3.' SET pageid = "'.smartsql($page2).'", hookid = "'.smartsql($key).'", pluginid = "'.smartsql($pdoith[$key]).'", whatid = "'.smartsql($whatid).'", orderid = "'.smartsql($exorder).'"');
				
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
		
		$jakdb->query('UPDATE '.$jaktable3.' SET orderid = CASE id
		'.$updatesql.'
		END
		WHERE id IN ('.$realid.')');
		
		// Now check if all the sidebar a deselct and hooks exist, if so delete all associated to this page
		$result = $jakdb->query('SELECT id FROM '.$jaktable3.' WHERE pageid = "'.smartsql($page2).'" AND hookid != 0');
		$row = $result->fetch_assoc();
		
		if (isset($defaults['jak_hookshow_new']) && !is_array($defaults['jak_hookshow_new']) && $row['id'] && !is_array($defaults['jak_hookshow'])) {
		
			$jakdb->query('DELETE FROM '.$jaktable3.' WHERE pageid = "'.smartsql($page2).'" AND hookid != 0');
		
		}
		
		// Save order or delete for extra sidebar widget
		if (isset($defaults['jak_hookshow']) && is_array($defaults['jak_hookshow'])) {
		
			$exorder = $defaults['horder'];
			$hookid = $defaults['real_hook_id'];
			$hookrealid = implode(',', $defaults['real_hook_id']);
			$doith = array_combine($hookid, $exorder);
			
			foreach ($doith as $key => $exorder) {
			
				// Get the real what id
				$result = $jakdb->query('SELECT pluginid FROM '.$jaktable3.' WHERE id = "'.smartsql($key).'" AND hookid != 0');
				$row = $result->fetch_assoc();
				
				$whatid = 0;
				if (isset($defaults['whatid_'.$row["pluginid"]])) $whatid = $defaults['whatid_'.$row["pluginid"]];
				
				if (in_array($key, $defaults['jak_hookshow'])) {
					$updatesql .= sprintf("WHEN %d THEN %d ", $key, $exorder);
					$updatesql1 .= sprintf("WHEN %d THEN %d ", $key, $whatid);
					
				} else {
					$jakdb->query('DELETE FROM '.$jaktable3.' WHERE id = "'.smartsql($key).'"');
				}
			}
			
			$jakdb->query('UPDATE '.$jaktable3.' SET orderid = CASE id
			'.$updatesql.'
			END
			WHERE id IN ('.$hookrealid.')');
			
			$jakdb->query('UPDATE '.$jaktable3.' SET whatid = CASE id
			'.$updatesql1.'
			END
			WHERE id IN ('.$hookrealid.')');
		
		}
		
		// Set tag active to zero
		$tagactive = 0;
		
		if ($defaults['jak_oldcatid'] != 0) $tagactive = 1;
		
		if ($defaults['jak_catid'] != $defaults['jak_oldcatid']) {
			
			if ($defaults['jak_catid'] == 0) {
			
				$jakdb->query('UPDATE '.$jaktable1.' SET pageid = 0 WHERE id = "'.smartsql($defaults['jak_oldcatid']).'"');
				
			} else {
			
				$jakdb->query('UPDATE '.$jaktable1.' SET pageid = 0 WHERE id = "'.smartsql($defaults['jak_oldcatid']).'"');
				$jakdb->query('UPDATE '.$jaktable1.' SET pageid = "'.smartsql($page2).'" WHERE id = "'.smartsql($defaults['jak_catid']).'"');
				
			}
			
			// Set tag active, well to active
			$tagactive = 1;
		}
		
		if (!$result) {
		    jak_redirect(BASE_URL.'index.php?p=page&sp=edit&ssp='.$page2.'&sssp=e');
		} else {
				
		// Create Tags if the module is active
		if (!empty($defaults['jak_tags'])) {
			// check if tag does not exist and insert in cloud
			JAK_tags::jakBuildcloud($defaults['jak_tags'], smartsql($page2), 0);
			// insert tag for normal use
			JAK_tags::jakInsertags($defaults['jak_tags'], smartsql($page2), 0, $tagactive);
		}
		        jak_redirect(BASE_URL.'index.php?p=page&sp=edit&ssp='.$page2.'&sssp=s');
		    }
			    
		 } else {
		    
		   	$errors['e'] = $tl['error']['e'];
		    $errors = $errors;
		    }
		}
		
		$JAK_FORM_DATA = jak_get_data($page2,$jaktable);
		$JAK_GET_NEWS = jak_get_page_info($jaktable4, '');
		$JAK_CAT_NOTUSED = jak_get_cat_notused();
		
		
		// Now let's check if we display news with second option
		$shownewsarray = explode(":", $JAK_FORM_DATA['shownews']);
		
		if (is_array($shownewsarray) && in_array("ASC", $shownewsarray) || in_array("DESC", $shownewsarray)) {
		
				$JAK_FORM_DATA['shownewsorder'] = $shownewsarray[0];
				$JAK_FORM_DATA['shownewsmany'] = $shownewsarray[1];
			
		}
		
		// Get the tags
		if (JAK_TAGS) $JAK_TAGLIST = jak_get_tags($page2,0);
		
		// Get the sort orders for the grid
		$grid = $jakdb->query('SELECT id, pluginid, hookid, whatid, orderid FROM '.$jaktable3.' WHERE pageid = "'.smartsql($page2).'" ORDER BY orderid ASC');
		while ($grow = $grid->fetch_assoc()) {
		        // collect each record into $_data
		        $JAK_PAGE_GRID[] = $grow;
		}
		
		// Get the sidebar templates
		$result = $jakdb->query('SELECT id, name, widgetcode, exorder, pluginid FROM '.$jaktable5.' WHERE hook_name = "tpl_sidebar" AND active = 1 ORDER BY exorder ASC');
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
		
		// First we delete the old records, older then 30 days
		$jakdb->query('DELETE FROM '.$jaktable6.' WHERE pageid = "'.smartsql($page2).'" AND DATEDIFF(CURDATE(), time) > 30');
		
		// Get the backup content
		$resultbp = $jakdb->query('SELECT id, time FROM '.$jaktable6.' WHERE pageid = "'.smartsql($page2).'" ORDER BY id DESC LIMIT 10');
		while ($rowbp = $resultbp->fetch_assoc()) {
			// collect each record into $_data
		    $JAK_PAGE_BACKUP[] = $rowbp;
		}
		
		// Title and Description
		$SECTION_TITLE = $tl["cmenu"]["c7"];
		$SECTION_DESC = $tl["cmdesc"]["d10"];
		
		// Call the template
		$template = 'editpage.php';
		
		} else {
		   	jak_redirect(BASE_URL.'index.php?p=page&sp=ene');
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
		    		jak_redirect(BASE_URL.'index.php?p=page&sp=quickedit&ssp='.$page2.'&sssp=e');
				} else {
		        	jak_redirect(BASE_URL.'index.php?p=page&sp=quickedit&ssp='.$page2.'&sssp=s');
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
				   	jak_redirect(BASE_URL.'index.php?p=page&sp=ene');
				}
		break;
		default:
			
			// Do we have a post access
			if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['jak_delete_page'])) {
				$defaults = $_POST;
				    
				if (isset($defaults['lock'])) {
				    
				    $lockuser = $defaults['jak_delete_page'];
				
				    for ($i = 0; $i < count($lockuser); $i++) {
				    	$locked = $lockuser[$i];
				      	$result = $jakdb->query('UPDATE '.$jaktable.' SET active = IF (active = 1, 0, 1) WHERE id = "'.smartsql($locked).'"');
				    }
				  
				 	if (!$result) {
						jak_redirect(BASE_URL.'index.php?p=page&sp=e');
					} else {
				        jak_redirect(BASE_URL.'index.php?p=page&sp=s');
				    }
				    
				 }
				    
				 if (isset($defaults['delete'])) {
				    
				    $lockuser = $defaults['jak_delete_page'];
				
				    for ($i = 0; $i < count($lockuser); $i++) {
				        $locked = $lockuser[$i];
				    	$result = $jakdb->query('DELETE FROM '.$jaktable.' WHERE id = "'.smartsql($locked).'"');
				    	$result1 = $jakdb->query('UPDATE '.$jaktable1.' SET pageid = 0 WHERE pageid = "'.smartsql($locked).'"');
				    	JAK_tags::jakDeletetags($locked, 0);
				    }
				  
				 	if (!$result) {
						jak_redirect(BASE_URL.'index.php?p=page&sp=e');
					} else {
				        jak_redirect(BASE_URL.'index.php?p=page&sp=s');
				    }
				    
				    }
				
				 }
			
			$getTotal = jak_get_total($jaktable,'','','');
			if ($getTotal != 0) {
			
				// Paginator
				$pages = new JAK_Paginator;
				$pages->items_total = $getTotal;
				$pages->mid_range = $jkv["adminpagemid"];
				$pages->items_per_page = $jkv["adminpageitem"];
				$pages->jak_get_page = $page1;
				$pages->jak_where = 'index.php?p=page';
				$pages->paginate();
				$JAK_PAGINATE = $pages->display_pages();
			
				// Ouput all pages, well with paginate of course
				$JAK_PAGE_ALL = jak_get_page_info($jaktable, $pages->limit);
			}
			
			// Title and Description
			$SECTION_TITLE = $tl["menu"]["m7"];
			$SECTION_DESC = $tl["menu"]["m4"].' '.$tl["menu"]["m7"];
				 	
			// Call the template
			$template = 'pages.php';
		}
	}
?>