<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/


// Protected url names
function jak_varname_blocked($jakvar) {
	$blocked = 'user,usergroup,admin,cmsfiles,css,class,img,include,js,lang,pics_gallery,ftp,plugin,profilepicture,template,userfiles,videofiles,search,suche,'.JAK_FILES_DIRECTORY;
	$blockarray = explode(',', $blocked);
	// check if userid is protected in the config.php
	if (in_array($jakvar, $blockarray)) {
		return true;
	}
}

// Get the usergroup per array with no limit
function jak_clean_comment($jakvar) {
	
	$input = strip_tags(stripslashes($jakvar));
	      
    return $input;
}

// Get the not used Categories out the database
function jak_get_cat_notused() {
    global $jakdb;
    $categories = array();
    $result = $jakdb->query('SELECT id, name FROM '.DB_PREFIX.'categories'.' WHERE pageid = 0 AND pluginid = 0 AND exturl = ""');
    while ($row = $result->fetch_assoc()) {
        $categories[] = array('id' => $row['id'], 'name' => $row['name']);
    }
    if (!empty($categories)) return $categories;
}

// Get the categories per array with no limit
function jak_get_cat_info($jakvar,$jakvar1) {
	global $jakdb;
	
	$sqlwhere = '';
	if (!empty($jakvar1)) $sqlwhere = ' WHERE activeplugin = 1';
	
	$jakdata = array();
    $result = $jakdb->query('SELECT * FROM '.$jakvar.$sqlwhere.' ORDER BY catorder ASC');
    while ($row = $result->fetch_assoc()) {
            // collect each record into $_data
            $jakdata[] = $row;
        }        
    if (isset($jakdata)) return $jakdata;
}

// Get the usergroup per array with no limit
function jak_get_usergroup_all($jakvar) {
	global $jakdb;
	$jakdata = array();
    $result = $jakdb->query('SELECT id, name, description FROM '.DB_PREFIX.$jakvar.' ORDER BY id ASC');
    while ($row = $result->fetch_assoc()) {
            // collect each record into $_data
            $jakdata[] = $row;
        }        
    return $jakdata;
}

// Get the data per array for page,newsletter with limit
function jak_get_page_info($jakvar,$jakvar1) {
	global $jakdb;
	$jakdata = array();
    $result = $jakdb->query('SELECT * FROM '.$jakvar.' ORDER BY id DESC '.$jakvar1);
    while ($row = $result->fetch_assoc()) {
            // collect each record into $_data
            $jakdata[] = $row;
        }
        
    if (!empty($jakdata)) return $jakdata;
}

// Get the data per array for news with limit
function jak_get_news_info($jakvar) 
{
	global $jakdb;
	$jakdata = array();
    $result = $jakdb->query('SELECT * FROM '.DB_PREFIX.'news'.' ORDER BY newsorder ASC '.$jakvar);
    while ($row = $result->fetch_assoc()) {
            // collect each record into $jakdata
            $jakdata[] = $row;
        }
        
    return $jakdata;
}

// Get the data per array for event comments with limit
function jak_get_tag($limit,$id,$plugin,$order) {

	$sqlwhere = '';
	$pluginname = '<i class="fa fa-file-text-o"></i>';
	if (!empty($id)) $sqlwhere = ' WHERE pluginid = "'.smartsql($id).'"';
	
	$ordersql = ' ORDER BY tag ASC ';
	if (!empty($order)) $ordersql = ' ORDER BY '.$order.' ';
	
	global $jakdb;
	$jakdata = array();
    $result = $jakdb->query('SELECT id, tag, pluginid, active FROM '.DB_PREFIX.'tags'.$sqlwhere.$ordersql.$limit);
    while ($row = $result->fetch_assoc()) {
    
    	foreach($plugin as $p) {
    		if ($p['id'] == $row['pluginid']) $pluginname = $p['name'];
    	}
    	
        // collect each record into $_data
        $jakdata[] = array('id' => $row['id'], 'tag' => $row['tag'], 'active' => $row['active'], 'pluginid' => $row['pluginid'], 'plugin' => $pluginname);
    }

    return $jakdata;
}

// Search for style files in the site folder, only choose folders.
function jak_get_site_style($styledir) {

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

// Get all user out the database limited with the paginator
function jak_get_user_all($jakvar,$jakvar1,$jakvar2) {

	$sqlwhere = '';
	if (!empty($jakvar2)) $sqlwhere = 'AND usergroupid = '.smartsql($jakvar2).' ';
	
	global $jakdb;
	$user = array();
    $result = $jakdb->query('SELECT id, usergroupid, username, email, access FROM '.DB_PREFIX.$jakvar.' WHERE access <= 1 '.$sqlwhere.$jakvar1);
    while ($row = $result->fetch_assoc()) {
        $user[] = array('id' => $row['id'], 'usergroupid' => $row['usergroupid'], 'username' => $row['username'], 'email' => $row['email'], 'access' => $row['access']);
    }
    
    return $user;
}

// Get all user out the database limited with the paginator
function jak_admin_search($jakvar,$jakvar1,$jakvar2) {

	$sqlwhere = '';
	if ($jakvar2 == 'user') {
		$sqlwhere = ' WHERE id like "%'.$jakvar.'%" OR username like "%'.$jakvar.'%" OR name like "%'.$jakvar.'%" OR email like "%'.$jakvar.'%"';
	} elseif ($jakvar2 == 'newsletter') {
		$sqlwhere = ' WHERE id like "%'.$jakvar.'%" or email like "%'.$jakvar.'%"';
	}
	global $jakdb;
	$jakdata = array();
    $result = $jakdb->query('SELECT * FROM '.$jakvar1.$sqlwhere.' ORDER BY id ASC LIMIT 5');
    while ($row = $result->fetch_assoc()) {
    	// collect each record into $_data
        $jakdata[] = $row;
    }
        
    return $jakdata;
}

// Check if user exist and it is possible to delete ## (config.php)
function jak_user_exist_deletable($jakvar)
{
	global $jakdb;
	$useridarray = explode(',', JAK_SUPERADMIN);
	// check if userid is protected in the config.php
	if (in_array($jakvar, $useridarray)) {
	       return false;
	} else {
		$result = $jakdb->query('SELECT id FROM '.DB_PREFIX.'user WHERE id = "'.smartsql($jakvar).'" LIMIT 1');
	    if ($jakdb->affected_rows > 0) return true;
	}
}

// Check if row exist with id
function jak_field_not_exist_id($jakvar,$jakvar1,$jakvar2,$jakvar3)
{
		global $jakdb;
		$result = $jakdb->query('SELECT id FROM '.$jakvar2.' WHERE id != "'.smartsql($jakvar1).'" AND '.$jakvar3.' = "'.smartsql($jakvar).'" LIMIT 1');
        if ($jakdb->affected_rows > 0) {
        return true;
}
}

// Get started with the tag system

// Get tags per id
function jak_get_tags($jakvar,$jakvar1) {

	global $jakdb;
	$tags = array();
    $result = $jakdb->query('SELECT id, tag FROM '.DB_PREFIX.'tags'.' WHERE itemid = '.smartsql($jakvar).' AND pluginid = '.$jakvar1.' ORDER BY `id` DESC');
    while ($row = $result->fetch_assoc()) {
        $tags[] = '<label class="checkbox-inline"><input type="checkbox" name="jak_tagdelete[]" value="'.$row['id'].'" /> '.$row['tag'].'</label>';
    }
    
    if (!empty($tags)) {
    	$taglist = join("", $tags);
    	return $taglist;
    } else {
   		return false;
    }
}

// Tag cloud data
function jak_tag_data_admin() {

	global $jakdb;
	$cloud = array();
  	$result = $jakdb->query('SELECT * FROM '.DB_PREFIX.'tagcloud'.' GROUP BY tag ORDER BY count DESC');
  	while($row = $result->fetch_assoc()) {
    	$cloud[$row['tag']] = $row['count'];
  	}
  	if (!empty($cloud)) {
  		ksort($cloud);
		return $cloud;
	}
}

// Create tag cloud
function jak_admin_tag_cloud() {

    // Default font sizes
    $min_font_size = 12;
    $max_font_size = 30;
    $cloud_html = '';

    // Pull in tag data
    $tags = jak_tag_data_admin();
	if ($tags) {
	    $minimum_count = min(array_values($tags));
	    $maximum_count = max(array_values($tags));
	    $spread = $maximum_count - $minimum_count;
	
	    if($spread == 0) {
	        $spread = 1;
	    }
	
	    $cloud_tags = array(); // create an array to hold tag code
	    foreach ($tags as $tag => $count) {
	        $size = $min_font_size + ($count - $minimum_count) 
	            * ($max_font_size - $min_font_size) / $spread;
	        $cloud_tags[] = '<span class="label label-default" style="line-height:2;font-size: '.floor($size) .'px;' 
	            . '" class="tagcloud">' 
	            . htmlspecialchars(stripslashes($tag)) . ' <a href="index.php?p=tags&sp=cloud&ssp=delete&sssp='.$tag.'" onclick="if(!confirm(\'Delete this Tag?\'))return false;"><i class="fa fa-trash-o"></i></a></span>';
	    }
    	$cloud_html = join(" ", $cloud_tags);
    }
    return $cloud_html;
}

// Get contact options
function jak_get_contact_options($jakvar,$jakvar1) {

	global $jakdb;
	$jakdata = array();
    $result = $jakdb->query('SELECT * FROM '.$jakvar.' WHERE formid = "'.smartsql($jakvar1).'" ORDER BY forder ASC');
    while ($row = $result->fetch_assoc()) {
            // collect each record into $_data
            $jakdata[] = $row;
        }
    return $jakdata;
}

// Get contact options
function jak_get_new_stuff($jakvar,$jakvar1) 
{
	if ($jakvar1 == 1) {
		$sqlwhere = ' WHERE session = "" AND access = 0';
	} else {
		$sqlwhere = ' WHERE approve = 0 AND session != ""';
	}
	
	global $jakdb;
    $row = $jakdb->queryRow('SELECT COUNT(id) as totalAll FROM '.DB_PREFIX.$jakvar.$sqlwhere.' ORDER BY time DESC');
    return $row['totalAll'];
}

// Load the version from CMS
function jak_load_xml_from_url($jakvar) {
    return simplexml_load_string(jak_load_file_from_url($jakvar));
}

function jak_load_file_from_url($jakvar) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $jakvar);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_REFERER, BASE_URL);
    $str = curl_exec($curl);
    curl_close($curl);
    return $str;
}

// Parse the xml into an array
function jak_objectsIntoArray($arrObjData, $arrSkipIndices = array())
{
    $arrData = array();
    
    // if input is object, convert into array
    if (is_object($arrObjData)) {
        $arrObjData = get_object_vars($arrObjData);
    }
    
    if (is_array($arrObjData)) {
        foreach ($arrObjData as $index => $value) {
            if (is_object($value) || is_array($value)) {
                $value = objectsIntoArray($value, $arrSkipIndices); // recursive call
            }
            if (in_array($index, $arrSkipIndices)) {
                continue;
            }
            $arrData[$index] = $value;
        }
    }
    return $arrData;
}

// Menu builder function, parentId 0 is the root
function jak_build_menu_admin($parent, $menu, $lang, $class = "", $id = "")
{
   $html = "";
   if (isset($menu['parents'][$parent])) {
      $html .= "
      <ul".$class.$id.">\n";
       foreach ($menu['parents'][$parent] as $itemId) {
          if (!isset($menu['parents'][$itemId])) {
          	$html .= '<li id="menuItem_'.$menu["items"][$itemId]["id"].'" class="jakcat">
          		<div>
          		<span class="text">#'.$menu["items"][$itemId]["id"].' <a href="index.php?p=categories&amp;sp=edit&amp;ssp='.$menu["items"][$itemId]["id"].'">'.$menu["items"][$itemId]["name"].'</a></span>
          		<span class="actions">
          			'.($menu["items"][$itemId]["pluginid"] == 0 && $menu["items"][$itemId]["pageid"] == 0 && $menu["items"][$itemId]["exturl"] == '' ? '<a class="btn btn-default btn-xs" href="index.php?p=page&amp;sp=newpage&amp;ssp='.$menu["items"][$itemId]["id"].'"><i class="fa fa-sticky-note-o"></i></a>' : '').' 
          			'.($menu["items"][$itemId]["pluginid"] == 0 && $menu["items"][$itemId]["pageid"] != 0 && $menu["items"][$itemId]["exturl"] == '' ? '<a class="btn btn-default btn-xs" href="index.php?p=page&amp;sp=edit&amp;ssp='.$menu["items"][$itemId]["pageid"].'"><i class="fa fa-pencil"></i></a>' : '').'
          			'.($menu["items"][$itemId]["pluginid"] > 0 && $menu["items"][$itemId]["exturl"] == '' ? '<a class="btn btn-info btn-xs" href="javascript:void(0)"><i class="fa fa-eyedropper"></i></a>' : '').'
          			'.($menu["items"][$itemId]["exturl"] != '' ? '<i class="fa fa-link"></i>' : '').'
          			
          			<a class="btn btn-default btn-xs" href="index.php?p=categories&amp;sp=edit&amp;ssp='.$menu["items"][$itemId]["id"].'"><i class="fa fa-edit"></i></a>
          			'.($menu["items"][$itemId]["pluginid"] == 0 && $menu["items"][$itemId]["id"] != 1 ? '<a class="btn btn-danger btn-xs" href="index.php?p=categories&amp;sp=delete&amp;ssp='.$menu["items"][$itemId]["id"].'" onclick="if(!confirm('.$lang.'))return false;"><i class="fa fa-trash-o" ></i></a>' : '').'	
          		</span></div></li>';
          }
          if (isset($menu['parents'][$itemId])) {
          	$html .= '<li id="menuItem_'.$menu["items"][$itemId]["id"].'" class="jakcat">
          		<div>
          		<span class="text">#'.$menu["items"][$itemId]["id"].' <a href="index.php?p=categories&amp;sp=edit&amp;ssp='.$menu["items"][$itemId]["id"].'">'.$menu["items"][$itemId]["name"].'</a></span>
          		<span class="actions">
          			'.($menu["items"][$itemId]["pluginid"] == 0 && $menu["items"][$itemId]["pageid"] == 0 && $menu["items"][$itemId]["exturl"] == '' ? '<a class="btn btn-default btn-xs" href="index.php?p=page&amp;sp=newpage&amp;ssp='.$menu["items"][$itemId]["id"].'"><i class="fa fa-sticky-note-o"></i></a>' : '').' 
          			'.($menu["items"][$itemId]["pluginid"] == 0 && $menu["items"][$itemId]["pageid"] != 0 && $menu["items"][$itemId]["exturl"] == '' ? '<a class="btn btn-default btn-xs" href="index.php?p=page&amp;sp=edit&amp;ssp='.$menu["items"][$itemId]["pageid"].'"><i class="fa fa-pencil"></i></a>' : '').'
          			'.($menu["items"][$itemId]["pluginid"] > 0 && $menu["items"][$itemId]["exturl"] == '' ? '<i class="fa fa-eyedropper"></i>' : '').'
          			'.($menu["items"][$itemId]["exturl"] != '' ? '<i class="fa fa-link"></i>' : '').'
          			
          			<a class="btn btn-default btn-xs" href="index.php?p=categories&amp;sp=edit&amp;ssp='.$menu["items"][$itemId]["id"].'"><i class="fa fa-edit"></i></a>
          			'.($menu["items"][$itemId]["pluginid"] == 0 && $menu["items"][$itemId]["id"] != 1 ? '<a class="btn btn-danger btn-xs" href="index.php?p=categories&amp;sp=delete&amp;ssp='.$menu["items"][$itemId]["id"].'" onclick="if(!confirm('.$lang.'))return false;"><i class="fa fa-trash-o" ></i></a>' : '').'	
          		</span>
          		</div>';
             $html .= jak_build_menu_admin($itemId, $menu, $lang);
             $html .= "</li> \n";
          }
       }
       $html .= "</ul> \n";
   }
   return $html;
}
?>