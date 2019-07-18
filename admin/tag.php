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
if (!JAK_USERID || !$jakuser->jakModuleaccess(JAK_USERID, JAK_ACCESSTAGS)) jak_redirect(BASE_URL);

// All the tables we need for this plugin
$jaktable = DB_PREFIX.'tags';
$jaktable1 = DB_PREFIX.'tagcloud';
$jaktable2 = DB_PREFIX.'pagesgrid';
$jaktable3 = DB_PREFIX.'pluginhooks';

// Now start with the plugin use a switch to access all pages
switch ($page1) {

	// Get the tag cloud
	case 'cloud':
	
		// Important template Stuff
		$JAK_TAGCLOUD = jak_admin_tag_cloud();
		
		switch ($page2) {
		    case 'delete':
		    
		        if (jak_field_not_exist($page3,$jaktable1,'tag')) {

		       		$result = $jakdb->query('DELETE FROM '.$jaktable1.' WHERE tag = "'.smartsql($page3).'"');
		        	$result1 = $jakdb->query('DELETE FROM '.$jaktable.' WHERE tag = "'.smartsql($page3).'"');
		        			
			        if (!$result || !$result1) {
			            jak_redirect(BASE_URL.'index.php?p=tags&sp=cloud&ssp=e');
			        } else {
			            jak_redirect(BASE_URL.'index.php?p=tags&sp=cloud&ssp=s');
			        }
		        
		    	} else {
		   			jak_redirect(BASE_URL.'index.php?p=tags&sp=cloud&ssp=ene');
				}
				
			break;
			default:
				define('TAG_DELETE_CLOUD', $tl['tag']['al']);
				
				// Title and Description
				$SECTION_TITLE = $tl["menu"]["m20"];
				$SECTION_DESC = $tl["cmdesc"]["d38"];
				
				// Call the template
				$template = 'tagcloud.php';
			}
			
	break;
	case 'setting':
	
		// Important template Stuff
		$JAK_SETTING = jak_get_setting('tags');
		
		// Let's go on with the script
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $defaults = $_POST;
		    
		    if (!is_numeric($defaults['jak_limit'])) {
		        $errors['e1'] = $tl['error']['e15'];
		    }
		    
		    if (!is_numeric($defaults['jak_min'])) {
		        $errors['e2'] = $tl['error']['e15'];
		    }
		    
		    if (!is_numeric($defaults['jak_max'])) {
		        $errors['e3'] = $tl['error']['e15'];
		    }
		
		    if (count($errors) == 0) {
		    
		    // Do the dirty work in mysql
		    
		    $result = $jakdb->query('UPDATE '.DB_PREFIX.'setting SET value = CASE varname
		    	WHEN "tagtitle" THEN "'.smartsql($defaults['jak_title']).'"
		    	WHEN "tagdesc" THEN "'.smartsql($defaults['jak_lcontent']).'"
		    	WHEN "taglimit" THEN "'.smartsql($defaults['jak_limit']).'"
		        WHEN "tagminfont" THEN "'.smartsql($defaults['jak_min']).'"
		        WHEN "tagmaxfont" THEN "'.smartsql($defaults['jak_max']).'"        
		    END
				WHERE varname IN ("tagtitle", "tagdesc", "taglimit", "tagminfont", "tagmaxfont")');
				
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
				
						$jakdb->query('INSERT INTO '.$jaktable2.' SET plugin = 3, hookid = "'.smartsql($key).'", pluginid = "'.smartsql($pdoith[$key]).'", whatid = "'.smartsql($whatid).'", orderid = "'.smartsql($exorder).'"');
					
					}
				
				}
			
			}
			
			// Now check if all the sidebar a deselct and hooks exist, if so delete all associated to this page
			$result = $jakdb->query('SELECT id FROM '.$jaktable2.' WHERE plugin = 3 AND hookid != 0');
				$row = $result->fetch_assoc();
			
			if (isset($defaults['jak_hookshow_new']) && !is_array($defaults['jak_hookshow_new']) && $row['id'] && !is_array($defaults['jak_hookshow'])) {
			
				$jakdb->query('DELETE FROM '.$jaktable2.' WHERE plugin = 3 AND hookid != 0');
			
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
				jak_redirect(BASE_URL.'index.php?p=tags&sp=setting&ssp=e');
			} else {
		        jak_redirect(BASE_URL.'index.php?p=tags&sp=setting&ssp=s');
		    }
		    } else {
		    
		   	$errors['e'] = $tl['error']['e'];
		    $errors = $errors;
		    }
		}
		
		// Get the sort orders for the grid
		$grid = $jakdb->query('SELECT id, hookid, whatid, orderid FROM '.$jaktable2.' WHERE plugin = 3 ORDER BY orderid ASC');
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
		if ($hookpagei) {
			foreach($hookpagei as $hpagi) {
				eval($hpagi['phpcode']);
			}
		}
		
		// Get the special vars for quick editors support
		$JAK_FORM_DATA["title"] = $jkv["tagtitle"];
		$JAK_FORM_DATA["content"] = $jkv["tagdesc"];
		
		// Title and Description
		$SECTION_TITLE = $tl["menu"]["m2"];
		$SECTION_DESC = $tl["cmdesc"]["d39"];
		
		// Call the template
		$template = 'tagsetting.php';
		
	break;
	default:
		
		// Let's go on with the script
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $defaults = $_POST;
		    
		    if (isset($defaults['delete'])) {
		    
		    	$tags = $defaults['jak_delete_tag'];
		
		        for ($i = 0; $i < count($tags); $i++) {
		            $tag = $tags[$i];
					JAK_tags::jakDeleteonetag($tag);	
		        }
				
		        jak_redirect(BASE_URL.'index.php?p=tags&sp=s');
		    
		    }
		 }
		 
		switch ($page1) {
			case 'sort':
			
		  		if ($page2 == 'pluginid') {
		 			$bu = 'pluginid';
		 			
		 			$getTotal = jak_get_total($jaktable,$page3,$bu,'');
		 			
		 			// Paginator
		 			if ($getTotal != 0) {
		 			
		 				$tags = new JAK_Paginator;
		 				$tags->items_total = $getTotal;
		 				$tags->mid_range = $jkv["adminpagemid"];
		 				$tags->items_per_page = $jkv["adminpageitem"];
		 				$tags->jak_get_page = $page4;
		 				$tags->jak_where = 'index.php?p=tags&sp=sort&ssp='.$page2.'&sssp='.$page3;
		 				$tags->paginate();
		 				$JAK_PAGINATE = $tags->display_pages();
		 					
		 				$JAK_TAG_ALL = jak_get_tag($tags->limit,$page3,$jakplugins->jakAdmintag(),false);
		 				
		 			}
		 			
		 		} elseif ($page2 == 'tag') {
		 			
		 			$getTotal = jak_get_total($jaktable,'','','');
		 			
		 			$sortoder = 'tag ASC';
		 			if ($page3 == 'DESC') $sortoder = 'tag DESC';
		 			
		 			// Paginator
		 			if ($getTotal != 0) {
		 				
		 				$tags = new JAK_Paginator;
		 				$tags->items_total = $getTotal;
		 				$tags->mid_range = $jkv["adminpagemid"];
		 				$tags->items_per_page = $jkv["adminpageitem"];
		 				$tags->jak_get_page = $page4;
		 				$tags->jak_where = 'index.php?p=tags&sp=sort&ssp='.$page2.'&sssp='.$page3;
		 				$tags->paginate();
		 				$JAK_PAGINATE = $tags->display_pages();
		 					
		 				$JAK_TAG_ALL = jak_get_tag($tags->limit,false,$jakplugins->jakAdmintag(),$sortoder);
		 				
		 			}	
		 				
		 		} else {
		 			jak_redirect(BASE_URL.'index.php?p=tags');
		 		}
		 		
		 		// Title and Description
		 		$SECTION_TITLE = $tl["menu"]["t"];
		 		$SECTION_DESC = $tl["cmdesc"]["d38"];
		 			
		 		// Get the template, same from the pm but modified... :)
		 		$template = 'tag.php';
		 	
		break;
		case 'lock':
			
			if (is_numeric($page2)) {
		 	
		 		JAK_tags::jakLocktag($page2);
		 		
		 		jak_redirect(BASE_URL.'index.php?p=tags&sp=s');
		 	
			} else {
			   	jak_redirect(BASE_URL.'index.php?p=tags&sp=ene');
			}
			
		break;
		case 'delete':
		    if (jak_row_exist($page2,$jaktable)) {
		        	
		    	JAK_tags::jakDeleteonetag($page2);
		        			
		        jak_redirect(BASE_URL.'index.php?p=tags&sp=s');
		    
			} else {
			   	jak_redirect(BASE_URL.'index.php?p=tags&sp=ene');
			}
		break;
		default:
			
			// Important template Stuff
			$getTotal = jak_get_total($jaktable,'','','');
			// Paginator
			if ($getTotal != 0) {
				$tags = new JAK_Paginator;
				$tags->items_total = $getTotal;
				$tags->mid_range = $jkv["adminpagemid"];
				$tags->items_per_page = $jkv["adminpageitem"];
				$tags->jak_get_page = $page1;
				$tags->jak_where = 'index.php?p=tags';
				$tags->paginate();
				$JAK_PAGINATE = $tags->display_pages();
			
				$JAK_TAG_ALL = jak_get_tag($tags->limit,false,$jakplugins->jakAdmintag(),false);
			}
			
			// Title and Description
			$SECTION_TITLE = $tl["menu"]["t"];
			$SECTION_DESC = $tl["cmdesc"]["d38"];
			 
			// Call the template
			$template = 'tag.php';
		}
}
?>