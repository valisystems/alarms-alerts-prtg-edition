<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Check if the file is accessed only via index.php if not stop the script from running
if(!defined('JAK_ADMIN_PREVENT_ACCESS')) die('You cannot access this file directly.');

// Check if the user has access to this file
if (!JAK_USERID || !$jakuser->jakModuleaccess(JAK_USERID, JAK_ACCESSSLIDER)) jak_redirect(BASE_URL);

// All the tables we need for this plugin
$jaktable = DB_PREFIX.'slider';
$jaktable1 = DB_PREFIX.'slider_layers';

// Get all the functions, well not many
function jak_get_slider() {
	
	global $jakdb;
	$jakdata = array();
    $result = $jakdb->query('SELECT * FROM '.DB_PREFIX.'slider ORDER BY id DESC');
    while ($row = $result->fetch_assoc()) {
    	// collect each record into $_data
        $jakdata[] = $row;
    }
        
    return $jakdata;
}

function jak_get_slider_layers($jakvar,$jakvar1) {
	global $jakdb;
	$jakdata = array();
    $result = $jakdb->query('SELECT * FROM '.$jakvar.' WHERE lsid = "'.smartsql($jakvar1).'" ORDER BY id ASC');
    while ($row = $result->fetch_assoc()) {
    	// collect each record into $_data
        $jakdata[] = $row;
    }
    return $jakdata;
}

function jak_get_themes($styledir) {

if ($handle = opendir($styledir)) {

    /* This is the correct way to loop over the directory. */
    while (false !== ($template = readdir($handle))) {
    if ($template != '.' && $template != '..' && is_dir($styledir.'/'.$template) ) {
	    $getstyle[] = $template;
	    
    }
    }
	return $getstyle;
	clearstatcache();
    closedir($handle);
}
}

// Now start with the plugin use a switch to access all pages
switch ($page1) {

	// Create new slider
	case 'new':
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $defaults = $_POST;
		    
		    if (empty($defaults['jak_title'])) {
		        $errors['e1'] = $tl['error']['e2'];
		    }
		    
		    if (empty($defaults['jak_lswidth'])) {
		        $errors['e2'] = $tl['error']['e15'];
		    }
		    
		    if (empty($defaults['jak_lsheight'])) {
		        $errors['e3'] = $tl['error']['e15'];
		    }
		
		    if (count($errors) == 0) {
		    
		    if (!isset($defaults['jak_permission'])) {
		    	$permission = 0;
		    } else {
		    	$permission = join(',', $defaults['jak_permission']);
		    }
		    
		    // Do the dirty work in mysql
		    $result = $jakdb->query('INSERT INTO '.$jaktable.' SET 
		    title = "'.smartsql($defaults['jak_title']).'",
		    lswidth = "'.smartsql($defaults['jak_lswidth']).'",
		    lsheight = "'.smartsql($defaults['jak_lsheight']).'",
		    lslogo = "'.smartsql($defaults['jak_logod']).'",
		    lslogolink = "'.smartsql($defaults['jak_logolink']).'",
		    lsontop = "'.smartsql($defaults['jak_ontop']).'",
		    lsresponsive = "'.smartsql($defaults['jak_responsive']).'",
		    lsloops = "'.smartsql($defaults['jak_loops']).'",
		    lsfloops = "'.smartsql($defaults['jak_floops']).'",
		    lsavideo = "'.smartsql($defaults['jak_autov']).'",
		    lsyvprev = "'.smartsql($defaults['jak_prevv']).'",
		    lsanimatef = "'.smartsql($defaults['jak_animatef']).'",
		    lstheme = "'.smartsql($defaults['jak_theme']).'",
		    lspause = "'.smartsql($defaults['jak_pause']).'",
		    lstransition = "'.smartsql($defaults['jak_transition']).'",
		    lstransitionout = "'.smartsql($defaults['jak_transition_out']).'",
		    lsdirection = "'.smartsql($defaults['jak_direction']).'",
		    autostart = "'.smartsql($defaults['jak_autostart']).'",
		    imgpreload = "'.smartsql($defaults['jak_preload']).'",
		    naviprevnext = "'.smartsql($defaults['jak_buttonnext']).'",
		    navibutton = "'.smartsql($defaults['jak_navbutton']).'",
		    pausehover = "'.smartsql($defaults['jak_mhover']).'",
		    permission = "'.smartsql($permission).'",
		    time = NOW()');
		    	
		    $rowid = $jakdb->jak_last_id();
		    	
		    $countoption = $defaults['jak_activel'];
		    
		    for ($i = 0; $i < count($countoption); $i++) {
		    
		    	$activel = $countoption[$i];
		    
		    	if (!empty($activel)) {
		        
			        $jakdb->query('INSERT INTO '.$jaktable1.' SET 
			        lsid = '.smartsql($rowid).',
			        slidedirection = "'.smartsql($defaults['jak_direction_l'][$i]).'",
			        slidedelay = "'.smartsql($defaults['jak_pause_l'][$i]).'",
			        durationin = "'.smartsql($defaults['jak_durationin_l'][$i]).'",
			        durationout = "'.smartsql($defaults['jak_duration_l'][$i]).'",
			        slide2d = "'.smartsql($defaults['jak_2d'][$i]).'",
			        slide3d = "'.smartsql($defaults['jak_3d'][$i]).'",
			        timeshift = "'.smartsql($defaults['jak_ts'][$i]).'",
			        lsdeep = "'.smartsql($defaults['jak_deep'][$i]).'",
			        easingin = "'.smartsql($defaults['jak_transition_l'][$i]).'",
			        easingout = "'.smartsql($defaults['jak_transition_out_l'][$i]).'",
			        delayin = "'.smartsql($defaults['jak_delay_l'][$i]).'",
			        delayout = "'.smartsql($defaults['jak_delayout_l'][$i]).'"');
			        
			        $lqid = $jakdb->jak_last_id();
		        
		        	$countoptionl = $defaults['jak_path'.$defaults['jak_layerid'][$i].''];
		        
		        	for ($o = 0; $o < count($countoptionl); $o++) {
		        
				        $path = $countoptionl[$o];
				                
				        if (!empty($path)) {
				            
				            $jakdb->query('INSERT INTO '.$jaktable1.' SET 
				            lsid = '.smartsql($rowid).',
				            lspath = "'.smartsql(trim($path)).'",
				            imgdirection = "'.smartsql($defaults['jak_direction_ls'.$defaults['jak_layerid'][$i].''][$o]).'",
				            lslink = "'.smartsql(trim($defaults['jak_link'.$defaults['jak_layerid'][$i].''][$o])).'",
				            lsstyle = "'.smartsql(trim($defaults['jak_style'.$defaults['jak_layerid'][$i].''][$o])).'",
				            lsposition = "'.smartsql(trim($defaults['jak_pos'.$defaults['jak_layerid'][$i].''][$o])).'",
				            lsmove = "'.smartsql(trim($defaults['jak_move'.$defaults['jak_layerid'][$i].''][$o])).'",
				            parallaxin = "'.smartsql($defaults['jak_parallax'.$defaults['jak_layerid'][$i].''][$o]).'",
				            parallaxout = "'.smartsql($defaults['jak_parallaxout'.$defaults['jak_layerid'][$i].''][$o]).'",
				            durationin = "'.smartsql($defaults['jak_duration_ls'.$defaults['jak_layerid'][$i].''][$o]).'",
				            durationout = "'.smartsql($defaults['jak_durationout_ls'.$defaults['jak_layerid'][$i].''][$o]).'",
				            easingin = "'.smartsql($defaults['jak_transition_ls'.$defaults['jak_layerid'][$i].''][$o]).'",
				            easingout = "'.smartsql($defaults['jak_transition_out_ls'.$defaults['jak_layerid'][$i].''][$o]).'",
				            delayin = "'.smartsql($defaults['jak_delay_ls'.$defaults['jak_layerid'][$i].''][$o]).'",
				            delayout = "'.smartsql($defaults['jak_delayout_ls'.$defaults['jak_layerid'][$i].''][$o]).'",
				            layer = "'.$lqid.'"');
				                
				        }
		        
		        }
		        
		        }
		    }
		    				
			if (!$result) {
				jak_redirect(BASE_URL.'index.php?p=slider&sp=new&ssp=e');
			} else {
			    jak_redirect(BASE_URL.'index.php?p=slider&sp=edit&ssp='.$rowid.'&sssp=s');
			}
		    } else {
		    
		   	$errors['e'] = $tl['error']['e'];
		    $errors = $errors;
		    }
		}
		
		// Get all styles in the directory
		$theme_files = jak_get_themes('../plugins/slider/skins/');
		
		// Get all usergroup's
		$JAK_USERGROUP = jak_get_usergroup_all('usergroup');
		
		// Title and Description
		$SECTION_TITLE = $tlls["ls"]["m1"];
		$SECTION_DESC = $tlls["ls"]["t1"];
		
		// Call the template
		$plugin_template = 'plugins/slider/admin/template/newls.php';
		
	break;
	default:
		
		 switch ($page1) {
		    case 'delete':
		        if (is_numeric($page2) && jak_row_exist($page2, $jaktable)) {
					
					// Delete the pics associated with the Nivo Slider
					$jakdb->query('DELETE FROM '.$jaktable1.' WHERE lsid = "'.smartsql($page2).'"');
		        	
		        	// Delete the Nivo Slider
		        	$result = $jakdb->query('DELETE FROM '.$jaktable.' WHERE id = "'.smartsql($page2).'"');
		
		if (!$result) {
		    	jak_redirect(BASE_URL.'index.php?p=slider&sp=e');
			} else {
		       	jak_redirect(BASE_URL.'index.php?p=slider&sp=s');
		    }
		    
		} else {
		   	jak_redirect(BASE_URL.'index.php?p=slider&sp=ene');
		}
		break;
		case 'lock':
			
			$result = $jakdb->query('UPDATE '.$jaktable.' SET active = IF (active = 1, 0, 1) WHERE id = "'.smartsql($page2).'"');
		    	
			if (!$result) {
				jak_redirect(BASE_URL.'index.php?p=slider&sp=e');
			} else {			
		    	jak_redirect(BASE_URL.'index.php?p=slider&sp=s');
			}
			
		break;
		case 'edit':
		
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			    $defaults = $_POST;
			    
			    // Delete the options
			    if (!empty($defaults['jak_sod'])) {
			        $odel = $defaults['jak_sod'];
			    
			        for ($i = 0; $i < count($odel); $i++) {
			        	$optiondel = $odel[$i];
			                
			        	$jakdb->query('DELETE FROM '.$jaktable1.' WHERE id = "'.$optiondel.'" OR layer = "'.$optiondel.'"');
			    	}
			    }
			    
			    // Delete the options
			    if (!empty($defaults['jak_sodsl'])) {
			        $odels = $defaults['jak_sodsl'];
			    
			        for ($i = 0; $i < count($odels); $i++) {
			        	$optiondels = $odels[$i];
			                
			        	$jakdb->query('DELETE FROM '.$jaktable1.' WHERE id = "'.$optiondels.'"');
			    	}
			    }
			    
			    if (empty($defaults['jak_title'])) {
			        $errors['e1'] = $tl['error']['e2'];
			    }
			    
			    if (empty($defaults['jak_lswidth'])) {
			        $errors['e2'] = $tl['error']['e15'];
			    }
			    
			    if (empty($defaults['jak_lsheight'])) {
			        $errors['e3'] = $tl['error']['e15'];
			    }
			
			    if (count($errors) == 0) {
			    
			    if (!isset($defaults['jak_permission'])) {
			    	$permission = 0;
			    } else {
			    	$permission = join(',', $defaults['jak_permission']);
			    }
			    
			    // Do the dirty work in mysql
			    $result = $jakdb->query('UPDATE '.$jaktable.' SET 
			    title = "'.smartsql($defaults['jak_title']).'",
			    lswidth = "'.smartsql($defaults['jak_lswidth']).'",
			    lsheight = "'.smartsql($defaults['jak_lsheight']).'",
			    lslogo = "'.smartsql($defaults['jak_logod']).'",
			    lslogolink = "'.smartsql($defaults['jak_logolink']).'",
			    lsontop = "'.smartsql($defaults['jak_ontop']).'",
			    lsresponsive = "'.smartsql($defaults['jak_responsive']).'",
			    lsloops = "'.smartsql($defaults['jak_loops']).'",
			    lsfloops = "'.smartsql($defaults['jak_floops']).'",
			    lsavideo = "'.smartsql($defaults['jak_autov']).'",
			    lsyvprev = "'.smartsql($defaults['jak_prevv']).'",
			    lsanimatef = "'.smartsql($defaults['jak_animatef']).'",
			    lstheme = "'.smartsql($defaults['jak_theme']).'",
			    lspause = "'.smartsql($defaults['jak_pause']).'",
			    lstransition = "'.smartsql($defaults['jak_transition']).'",
			    lstransitionout = "'.smartsql($defaults['jak_transition_out']).'",
			    lsdirection = "'.smartsql($defaults['jak_direction']).'",
			    autostart = "'.smartsql($defaults['jak_autostart']).'",
			    imgpreload = "'.smartsql($defaults['jak_preload']).'",
			    naviprevnext = "'.smartsql($defaults['jak_buttonnext']).'",
			    navibutton = "'.smartsql($defaults['jak_navbutton']).'",
			    pausehover = "'.smartsql($defaults['jak_mhover']).'",
			    permission = "'.smartsql($permission).'",
			    time = NOW() WHERE id = "'.smartsql($page2).'"');
			    
			    
			    // Update the current stuff
			    $countoption = $defaults['jak_activel'];
			    
			    for ($i = 0; $i < count($countoption); $i++) {
			    
			    	$activel = $countoption[$i];
			    
			    	if (!empty($activel)) {
			        
			            $jakdb->query('UPDATE '.$jaktable1.' SET 
			            lsid = '.smartsql($page2).',
			            slidedirection = "'.smartsql($defaults['jak_direction_l'][$i]).'",
			            slidedelay = "'.smartsql($defaults['jak_pause_l'][$i]).'",
			            slide2d = "'.smartsql($defaults['jak_2d_l'][$i]).'",
			            slide3d = "'.smartsql($defaults['jak_3d_l'][$i]).'",
			            timeshift = "'.smartsql($defaults['jak_ts_l'][$i]).'",
			            lsdeep = "'.smartsql($defaults['jak_deep_l'][$i]).'",
			            durationin = "'.smartsql($defaults['jak_durationin_l'][$i]).'",
			            durationout = "'.smartsql($defaults['jak_duration_l'][$i]).'",
			            easingin = "'.smartsql($defaults['jak_transition_l'][$i]).'",
			            easingout = "'.smartsql($defaults['jak_transition_out_l'][$i]).'",
			            delayin = "'.smartsql($defaults['jak_delay_l'][$i]).'",
			            delayout = "'.smartsql(trim($defaults['jak_delayout_l'][$i])).'"
			            WHERE lsid = "'.smartsql($page2).'" AND id = "'.$defaults['jak_layerid'][$i].'"');
			        
			        	$countoptionl = $defaults['jak_path'];
			        
			        	for ($o = 0; $o < count($countoptionl); $o++) {
			        
			    	        $path = $countoptionl[$o];
			    	                
			    	        if (!empty($path)) {
			    	            
			    	            $jakdb->query('UPDATE '.$jaktable1.' SET 
			    	            lsid = '.smartsql($page2).',
			    	            lspath = "'.smartsql(trim($path)).'",
			    	            imgdirection = "'.smartsql($defaults['jak_directionu'][$o]).'",
			    	            lslink = "'.smartsql(trim($defaults['jak_link'][$o])).'",
			    	            lsstyle = "'.smartsql(trim($defaults['jak_style'][$o])).'",
			    	            lsposition = "'.smartsql(trim($defaults['jak_pos'][$o])).'",
			    	            lsmove = "'.smartsql(trim($defaults['jak_move'][$o])).'",
			    	            parallaxin = "'.smartsql($defaults['jak_parallax'][$o]).'",
			    	            parallaxout = "'.smartsql($defaults['jak_parallaxout'][$o]).'",
			    	            durationin = "'.smartsql($defaults['jak_duration_ls'][$o]).'",
			    	            durationout = "'.smartsql($defaults['jak_durationout_ls'][$o]).'",
			    	            easingin = "'.smartsql($defaults['jak_transition_ls'][$o]).'",
			    	            easingout = "'.smartsql($defaults['jak_transition_out_ls'][$o]).'",
			    	            delayin = "'.smartsql($defaults['jak_delay_ls'][$o]).'",
			    	            delayout = "'.smartsql($defaults['jak_delayout_ls'][$o]).'"
			    	            WHERE lsid = "'.smartsql($page2).'" AND id = "'.$defaults['jak_sublayerid'][$o].'"');
			    	                
			    	        }
			        
			        }
			        
			        }
			    }
			    
			    // ADD new if wish so
			    $countoptionla = $defaults['jak_pathna'];
			    
			    	for ($o = 0; $o < count($countoptionla); $o++) {
			    
			            $patha = $countoptionla[$o];
			                    
			            if (!empty($patha)) {
			                
			                $jakdb->query('INSERT INTO '.$jaktable1.' SET 
			                lsid = '.smartsql($page2).',
			                lspath = "'.smartsql(trim($patha)).'",
			                imgdirection = "'.smartsql($defaults['jak_directionna'][$o]).'",
			                lslink = "'.smartsql(trim($defaults['jak_linkna'][$o])).'",
			                lsstyle = "'.smartsql(trim($defaults['jak_stylena'][$o])).'",
			                lsposition = "'.smartsql(trim($defaults['jak_posna'][$o])).'",
			                lsmove = "'.smartsql(trim($defaults['jak_movena'][$o])).'",
			                parallaxin = "'.smartsql($defaults['jak_parallaxna'][$o]).'",
			                parallaxout = "'.smartsql($defaults['jak_parallaxoutna'][$o]).'",
			                durationin = "'.smartsql($defaults['jak_duration_lsna'][$o]).'",
			                durationout = "'.smartsql($defaults['jak_durationout_lsna'][$o]).'",
			                easingin = "'.smartsql($defaults['jak_transition_lsna'][$o]).'",
			                easingout = "'.smartsql($defaults['jak_transition_out_lsna'][$o]).'",
			                delayin = "'.smartsql($defaults['jak_delay_lsna'][$o]).'",
			                delayout = "'.smartsql($defaults['jak_delayout_lsna'][$o]).'",
			                layer = "'.smartsql($defaults['jak_newadd'][$o]).'"');
			                    
			            }
			    
			    }
			    				    
			    // Insert new if wish so
			    $countoption = $defaults['jak_activeln'];
			    
			    for ($i = 0; $i < count($countoption); $i++) {
			    
			    	$activel = $countoption[$i];
			    
			    	if (!empty($activel)) {
			        
			            $jakdb->query('INSERT INTO '.$jaktable1.' SET 
			            lsid = '.smartsql($page2).',
			            slidedirection = "'.smartsql($defaults['jak_direction_ln'][$i]).'",
			            slidedelay = "'.smartsql($defaults['jak_pause_ln'][$i]).'",
			            slide2d = "'.smartsql($defaults['jak_2d_ln'][$i]).'",
			            slide3d = "'.smartsql($defaults['jak_3d_ln'][$i]).'",
			            timeshift = "'.smartsql($defaults['jak_ts_ln'][$i]).'",
			            lsdeep = "'.smartsql($defaults['jak_deep_ln'][$i]).'",
			            durationin = "'.smartsql($defaults['jak_durationin_ln'][$i]).'",
			            durationout = "'.smartsql($defaults['jak_duration_ln'][$i]).'",
			            easingin = "'.smartsql($defaults['jak_transition_ln'][$i]).'",
			            easingout = "'.smartsql($defaults['jak_transition_out_ln'][$i]).'",
			            delayin = "'.smartsql($defaults['jak_delay_ln'][$i]).'",
			            delayout = "'.smartsql(trim($defaults['jak_delayout_ln'][$i])).'"');
			            
			            $lqid = $jakdb->jak_last_id();
			        
			        	$countoptionl = $defaults['jak_pathn'];
			        
			        	for ($o = 0; $o < count($countoptionl); $o++) {
			        
			    	        $path = $countoptionl[$o];
			    	                
			    	        if (!empty($path)) {
			    	            
			    	            $jakdb->query('INSERT INTO '.$jaktable1.' SET 
			    	            lsid = '.smartsql($page2).',
			    	            lspath = "'.smartsql(trim($path)).'",
			    	            imgdirection = "'.smartsql($defaults['jak_directionn'][$o]).'",
			    	            lslink = "'.smartsql(trim($defaults['jak_linkn'][$o])).'",
			    	            lsstyle = "'.smartsql(trim($defaults['jak_stylen'][$o])).'",
			    	            lsposition = "'.smartsql(trim($defaults['jak_posn'][$o])).'",
			    	            lsmove = "'.smartsql(trim($defaults['jak_moven'][$o])).'",
			    	            parallaxin = "'.smartsql($defaults['jak_parallaxn'][$o]).'",
			    	            parallaxout = "'.smartsql($defaults['jak_parallaxoutn'][$o]).'",
			    	            durationin = "'.smartsql($defaults['jak_duration_lsn'][$o]).'",
			    	            durationout = "'.smartsql($defaults['jak_durationout_lsn'][$o]).'",
			    	            easingin = "'.smartsql($defaults['jak_transition_lsn'][$o]).'",
			    	            easingout = "'.smartsql($defaults['jak_transition_out_lsn'][$o]).'",
			    	            delayin = "'.smartsql($defaults['jak_delay_lsn'][$o]).'",
			    	            delayout = "'.smartsql($defaults['jak_delayout_lsn'][$o]).'",
			    	            layer = "'.$lqid.'"');
			    	                
			    	        }
			        
			        }
			        
			        }
			    }
			    				
				if (!$result) {
					jak_redirect(BASE_URL.'index.php?p=slider&sp=edit&ssp='.$page2.'&sssp=e');
				} else {
			        jak_redirect(BASE_URL.'index.php?p=slider&sp=edit&ssp='.$page2.'&sssp=s');
			    }
			    } else {
			    
			   	$errors['e'] = $tl['error']['e'];
			    $errors = $errors;
			    }
			}
			
			// Get all styles in the directory
			$theme_files = jak_get_themes('../plugins/slider/skins/');
			
			// Get all usergroup's
			$JAK_USERGROUP = jak_get_usergroup_all('usergroup');
			
			// Get the data
			$JAK_FORM_DATA = jak_get_data($page2, $jaktable);
			$JAK_SLIDER_PICS = jak_get_slider_layers($jaktable1, $page2);
			
			// Title and Description
			$SECTION_TITLE = $tlls["ls"]["m2"];
			$SECTION_DESC = $tlls["ls"]["t2"];
			
			// Call the template
			$plugin_template = 'plugins/slider/admin/template/editls.php';
		
		break;
		default:
		
			// Hello we have a post request
			if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['jak_delete_slider'])) {
			    $defaults = $_POST;
			    
			    if (isset($defaults['delete'])) {
			    
			    $lockuser = $defaults['jak_delete_slider'];
			
			        for ($i = 0; $i < count($lockuser); $i++) {
			            $locked = $lockuser[$i];
			            
			            // Delete the pics associated with the Nivo Slider
			            $jakdb->query('DELETE FROM '.$jaktable1.' WHERE lsid = "'.$locked.'"');
						
						$result = $jakdb->query('DELETE FROM '.$jaktable.' WHERE id = "'.smartsql($locked).'"');
			        }
			  
			 	if (!$result) {
					jak_redirect(BASE_URL.'index.php?p=slider&sp=e');
				} else {
			        jak_redirect(BASE_URL.'index.php?p=slider&sp=s');
			    }
			    
			    }
			    
			    if (isset($defaults['lock'])) {
			        
			        $lockuser = $defaults['jak_delete_slider'];
			    
			            for ($i = 0; $i < count($lockuser); $i++) {
			                $locked = $lockuser[$i];
			                
			                // Delete the pics associated with the Nivo Slider
			                $result = $jakdb->query('UPDATE '.$jaktable.' SET active = IF (active = 1, 0, 1) WHERE id = "'.smartsql($locked).'"');
			            }
			      
			     	if (!$result) {
			    		jak_redirect(BASE_URL.'index.php?p=slider&sp=e');
			    	} else {
			            jak_redirect(BASE_URL.'index.php?p=slider&sp=s');
			        }
			        
			        }
			
			 }
							
			$JAK_SLIDER_ALL = jak_get_slider();
			
			// Title and Description
			$SECTION_TITLE = $tlls["ls"]["m"];
			$SECTION_DESC = $tlls["ls"]["t"];
			
			// Call the template
			$plugin_template = 'plugins/slider/admin/template/ls.php';

		}
}
?>