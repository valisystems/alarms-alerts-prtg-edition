<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Redirect to something...
function jak_redirect($url, $code = 302) {
    header('Location: '.$url, true, $code);
    exit();
}

// Secure the site and display videos
function jak_secure_site($input)
{
    $input = stripslashes($input);
    $youtube = strpos($input, 'youtube.com');
    $youtube2 = strpos($input, 'youtu.be');
    $vimeo = strpos($input, 'vimeo.com');
    
    // Check if there is a url in the text
    if (!empty($youtube) || !empty($youtube2) || !empty($vimeo)) {
    
	    // The Regular Expression filter
	    $reg_exUrl = '/(http\:\/\/www\.youtube\.com\/watch\?v=\w{11})/';
	    $reg_exUrl2 = '(http://youtu.be/[-|~_0-9A-Za-z]+)';
	    $reg_exUrlv = '/(http\:\/\/(www\.vimeo|vimeo)\.com\/[0-9]{8})/';
	    
	    preg_match($reg_exUrl, $input, $url);
	    
	    if (isset($url[0])) {
	    
		    $flurl = JAK_rewrite::jakVideourlparser($url[0], 'site');
		    
		    // make the urls hyper links
		    $input = preg_replace($reg_exUrl, '<figure><iframe class="v_player" src="'.$flurl.'" frameborder="0"></iframe></figure><p class="clearfix"></p>', $input);
		    
		}
	    	
	    preg_match($reg_exUrl2, $input, $url2);
	    
	    if (isset($url2[0])) {
	    	
		    $flurl2 = JAK_rewrite::jakVideourlparser($url2[0], 'site');
		    	
		    // make the urls hyper links
		    $input = preg_replace($reg_exUrl2, '<figure><iframe class="v_player" src="'.$flurl2.'" frameborder="0"></iframe></figure><p class="clearfix"></p>', $input);
		    
		}
	    	
	    preg_match($reg_exUrlv, $input, $vurl);
	    
	    if (isset($vurl[0])) {
	    	
		    $flurlv = JAK_rewrite::jakVideourlparser($vurl[0], 'site');
		    	
		    // make the urls hyper links
		    $input = preg_replace($reg_exUrlv, '<figure><iframe class="v_player" src="'.$flurlv.'" frameborder="0"></iframe></figure><p class="clearfix"></p>', $input);
		    
		}
    
    }
    
    return $input;
}

// Filter inputs
function jak_input_filter($value) {
	$value = filter_var($value, FILTER_SANITIZE_STRING);
	return preg_replace("/[^0-9 _,.@\-\p{L}]/u", '', $value);
}

// Get a secure mysql input
function smartsql($value)
{
	global $jakdb;
	if (get_magic_quotes_gpc()) {
		$value = stripslashes($value);
	}
    if (!is_int($value)) {
        $value = $jakdb->real_escape_string($value);
    }
    
    return $value;
}

// Search for lang files in the admin folder, only choose .ini files.
function jak_get_lang_files() {

$langdir = APP_PATH.'lang/';

if ($handle = opendir($langdir)) {

    /* This is the correct way to loop over the directory. */
    while (false !== ($file = readdir($handle))) {
    $showini = substr($file, strrpos($file, '.'));
    if ($file != '.' && $file != '..' && $showini == '.ini') {
    
    	$getlang[] = substr($file, 0, -4);
    
    }
    }
	return $getlang;
    closedir($handle);
}
}

// Detect Mobile Browser in a simple way to display videos in html5 or video/template not available message
function jak_find_browser($useragent, $wap)
{

	$ifmobile = preg_match('/android|avantgo|blackberry|blazer|compal|elaine|fennec|hiptop|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile|o2|opera m(ob|in)i|palm( os)?|p(ixi|re)\/|plucker|pocket|psp|smartphone|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce; (iemobile|ppc)|xiino/i', $useragent);
	
	$ifmobileM = preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i', substr($useragent,0,4));
	
	if ($ifmobile || $ifmobileM || isset($wap)) {
		return true;
	} else {
		return false;
	}
}

// Check if userid can have access to the forum, blog, gallery etc.
function jak_get_access($jakvar,$jakvar1) {
	$usergrouparray = explode(',', $jakvar1);
	if (in_array($jakvar, $usergrouparray) || $jakvar == 3) {
		return true;
	}
}

// Get the setting variable as well the default variable as array
function jak_get_setting($group) 
{
	global $jakdb;
	$setting = array();
    $result = $jakdb->query('SELECT varname, value, defaultvalue FROM '.DB_PREFIX.'setting WHERE groupname = "'.smartsql($group).'"');
    while ($row = $result->fetch_assoc()) {
        $setting[] = $row;
    }
    return $setting;
}

// Get total from a table
function jak_get_total($jakvar, $jakvar1, $jakvar2, $jakvar3)
{
	if (empty($jakvar1) && !empty($jakvar3)) {
		$sqlwhere = ' WHERE '.$jakvar3.' = 1';
	} elseif (!empty($jakvar1) && !empty($jakvar3)) {
		$sqlwhere = ' WHERE '.$jakvar2.' = "'.smartsql($jakvar1).'" AND '.$jakvar3.' = 1';
	} elseif (!empty($jakvar1) && empty($jakvar3)) {
		$sqlwhere = ' WHERE '.$jakvar2.' = "'.smartsql($jakvar1).'"';
	} else {
		$sqlwhere = '';
	}
	
	global $jakdb;
	$row = $jakdb->queryRow('SELECT COUNT(*) as totalAll FROM '.$jakvar.$sqlwhere.'');
		
	return $row['totalAll'];
}

// Get the data only per ID (e.g. edit single user, edit category)
function jak_get_data($id, $table) {
		
	global $jakdb;
	$setting = array();
    $result = $jakdb->query('SELECT * FROM '.$table.' WHERE id = "'.smartsql($id).'"');
    while ($row = $result->fetch_assoc()) {
        // collect each record into $jakdata
        $jakdata = $row;
    }
    return $jakdata;
}

// Check if row exist with custom field
function jak_field_not_exist($check, $table, $field) {
	global $jakdb;
	$result = $jakdb->query('SELECT id FROM '.$table.' WHERE LOWER('.$field.') = "'.smartsql($check).'" LIMIT 1');
	if ($jakdb->affected_rows === 1) {
		return true;
	} else {
		return false;
	}
}

// Check if row exist
function jak_row_exist($id, $table) {
	global $jakdb;
	$result = $jakdb->query('SELECT id FROM '.$table.' WHERE id = "'.smartsql($id).'" LIMIT 1');
    if ($jakdb->affected_rows === 1) {
        return true;
    } else {
        return false;
    }
}

// Check give access to delete or approve
function jak_give_right($id, $extrainfo, $table, $extrafield) {
	global $jakdb;
	$jakdb->query('SELECT id FROM '.$table.' WHERE id = '.smartsql($id).' AND '.$extrafield.' = "'.smartsql($extrainfo).'"');
	if ($jakdb->affected_rows === 1) {
		return true;
	} else {
		return false;
	}
}

// Check if row exist and user has permission to see it!
function jak_row_permission($jakvar,$jakvar1,$jakvar2) {
	global $jakdb;
	$result = $jakdb->query('SELECT permission FROM '.$jakvar1.' WHERE id = "'.smartsql($jakvar).'" LIMIT 1');
	if ($jakdb->affected_rows === 1) {
		$row = $result->fetch_assoc();
		if (jak_get_access($jakvar2,$row['permission']) || $row['permission'] == 0) {
			return true;
		}
	} else {
		return false;
	}
}

// Check if catid exist
function jak_get_id_name($jakvar,$jakvar1,$jakvar2,$jakvar3) {
	$sqlwhere = '';	
	global $jakdb;
	$result = $jakdb->query('SELECT id FROM '.$jakvar2.' WHERE '.$jakvar1.' = "'.smartsql($jakvar).'"'.$sqlwhere.' LIMIT 1');
    if ($jakdb->affected_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['id'];
	} else {
		return false;
	}
}

// Get News out the database
function jak_get_news($jakvar, $where, $plname, $order, $datef, $timef, $timeago) {
	if (!empty($jakvar)) {
		$sqlin = 'active = 1 ORDER BY newsorder '.$order.' ';
	} else if (empty($jakvar) && is_numeric($where)) {
		$sqlin = 'id = '.$where.' AND active = 1 ORDER BY newsorder ASC';
	} else if (empty($jakvar) && !is_numeric($where)) {
		$sqlin = 'id IN('.$where.') AND active = 1 ORDER BY newsorder ASC';
	} else {
		$sqlin = 'active = 1 ORDER BY newsorder ASC LIMIT 1';
	}
	
	global $jakdb;
	global $jkv;
	$jakdata = array();
    $result = $jakdb->query('SELECT * FROM '.DB_PREFIX.'news WHERE ((startdate = 0 OR startdate <= '.time().') AND (enddate = 0 OR enddate >= '.time().')) AND (FIND_IN_SET('.JAK_USERGROUPID.',permission) OR permission = 0) AND '.$sqlin.$jakvar);
    while ($row = $result->fetch_assoc()) {
    
    	$PAGE_TITLE = $row['title'];
    	$PAGE_CONTENT = $row['content'];
    
    	// Write content in short format with full words
    	$shortmsg = jak_cut_text($PAGE_CONTENT, $jkv["shortmsg"], '...');
    		
    	// Parse url for user link
    	$parseurl = JAK_rewrite::jakParseurl($plname, 'a', $row['id'], JAK_base::jakCleanurl($PAGE_TITLE), '');
    		
       	// collect each record into $jakdata
        $jakdata[] = array('id' => $row['id'], 'title' => jak_secure_site($PAGE_TITLE), 'content' => jak_secure_site($PAGE_CONTENT), 'showtitle' => $row['showtitle'], 'showcontact' => $row['showcontact'], 'showdate' => $row['showdate'], 'showhits' => $row['showhits'], 'created' => JAK_base::jakTimesince($row['time'], $datef, $timef, $timeago), 'titleurl' => JAK_base::jakCleanurl($row['title']), 'hits' => $row['hits'], 'previmg' => $row['previmg'], 'contentshort' => $shortmsg, 'parseurl' => $parseurl);
        
    }
        
    if (!empty($jakdata)) return $jakdata;
}

function jak_next_page($page, $title, $table, $id, $where, $where2, $approve) {
	
	$second = $third = $fourth = $fifth = $jakdata = false;
	
	if (!empty($title)) {
		$second = ' ,'.$title;
	}
	if (!empty($where)) {
		$third = $where;
	}
	if (!empty($where2)) {
		$fourth = $where2;
	}
	if (!empty($approve)) {
		$fifth = ' AND '.$approve.' = 1';
	}
	global $jakdb;
	$result = $jakdb->query('SELECT id'.$second.' FROM '.$table.' WHERE '.$id.' > '.smartsql($page).$third.$fourth.$fifth.' ORDER BY id ASC LIMIT 1');
	if ($jakdb->affected_rows > 0) {
		$jakdata = $result->fetch_assoc();
	    return $jakdata;
	} else
	    return false;
}

function jak_previous_page($page, $title, $table, $id, $where, $where2, $approve) {

	$second = $third = $fourth = $fifth = $jakdata = false;
	
	if (!empty($title)) {
		$second = ' ,'.$title;
	}
	if (!empty($where)) {
		$third = $where;
	}
	if (!empty($where2)) {
		$fourth = $where2;
	}
	if (!empty($approve)) {
		$fifth = ' AND '.$approve.' = 1';
	}
	global $jakdb;
	$result = $jakdb->query('SELECT id'.$second.' FROM '.$table.' WHERE '.$id.' < '.smartsql($page).$third.$fourth.$fifth.' ORDER BY id DESC LIMIT 1');
	if ($jakdb->affected_rows > 0) {
	    $jakdata = $result->fetch_assoc();
	    return $jakdata;
	} else
	    return false;

}

// Menu builder function, parentId 0 is the root
function jak_build_menu($parent, $menu, $active, $mainclass, $dropdown, $dropclass, $subclass, $admin)
{
   $html = '';
   if (isset($menu['parents'][$parent]))
   {
      $html .= '<ul class="'.$mainclass.'">';
       foreach ($menu['parents'][$parent] as $itemId) {
          if (!isset($menu['parents'][$itemId])) {
          	 $html .= '<li'.($active == $menu["items"][$itemId]["pagename"] ? ' class="active"' : '').'><a href="'.$menu["items"][$itemId]["varname"].'">'.($menu["items"][$itemId]["catimg"] ? '<i class="fa '.$menu["items"][$itemId]["catimg"].'"></i> ' : '').$menu["items"][$itemId]["name"].'</a></li>';
          }
          if (isset($menu['parents'][$itemId])) {
             $html .= '<li'.($active == $menu["items"][$itemId]["pagename"] ? ($dropdown ? ' class="active '.$dropdown.'"' : '') : ($dropdown ? ' class="'.$dropdown.'"' : '')).'><a href="'.$menu["items"][$itemId]["varname"].'">'.($menu["items"][$itemId]["catimg"] ? '<i class="fa '.$menu["items"][$itemId]["catimg"].'"></i> ' : '').$menu["items"][$itemId]["name"].'</a>';
             $html .= jak_build_menu($itemId, $menu, $active, $dropclass, $subclass, $dropclass, $subclass, $admin);
             $html .= '</li>';
          }
       }
       if ($admin) {
       		$html .= '<li><a href="'.BASE_URL.'admin/">Admin</a></li>';
       }
       $html .= '</ul>';
   }
   return $html;
}

function jak_build_comments($parent, $comm, $mainclass, $access, $session, $approve, $reply, $permission, $table, $report, $status)
{
   $html = '';
   if (isset($comm['subcomm'][$parent])) {
   	  
   	  $html .= '<ul'.($mainclass ? ' class="'.$mainclass.'"' : "").'>';
   	  foreach ($comm['subcomm'][$parent] as $comID) {
   	     if (!isset($comm['subcomm'][$comID])) {
   	     	 $html .= '<li><div class="comment-wrapper"><div class="comment-author"><img src="'.($comm["comm"][$comID]["userid"] != 0 ? BASE_URL.JAK_FILES_DIRECTORY.'/userfiles'.$comm["comm"][$comID]["picture"] : BASE_URL.JAK_FILES_DIRECTORY.'/userfiles'.'/standard.png').'" alt="avatar" /> '.$comm["comm"][$comID]["username"].'</div>
   	     	 			'.(($comm["comm"][$comID]["approve"] == 0 && !empty($comm["comm"][$comID]["session"]) && $session == $comm["comm"][$comID]["session"]) ? '<div class="alert alert-info">'.$approve.'</div>' : "").'
   	     	 			<div class="com">
   	     	 				'.$comm["comm"][$comID]["message"].'
   	     	 			</div>
   	     	 			<!-- Comment Controls -->
   	     	 			<div class="comment-actions">
   	     	 				<span class="comment-date">'.$comm["comm"][$comID]["created"].'</span>
   	     	 				<a href="javascript:void(0);" data-cvote="up" data-id="'.$comm["comm"][$comID]["id"].'" data-table="'.$table.'" class="jak-cvote"><i class="fa fa-thumbs-up"></i></a>
   	     	 				<a href="javascript:void(0);" data-cvote="down" data-id="'.$comm["comm"][$comID]["id"].'" data-table="'.$table.'" class="jak-cvote"><i class="fa fa-thumbs-down"></i></a>
   	     	 				<!-- Votes -->
   	     	 				<span id="jak-cvotec'.$comm["comm"][$comID]["id"].'" class="label label-'.jak_comment_votes($comm["comm"][$comID]["votes"]).'">'.$comm["comm"][$comID]["votes"].'</span>
   	     	 				'.($permission && $status && !$comm["comm"][$comID]["commentid"] ? '<a href="javascript:void(0);" data-id="'.$comm["comm"][$comID]["id"].'" class="btn btn-xs btn-primary comment-reply-btn jak-creply"><i class="fa fa-share-alt"></i> '.$reply.'</a>' : '').'
   	     	 				'.($access ? '<a href="'.$comm["comm"][$comID]["parseurl1"].'" class="btn btn-default btn-xs"><i class="fa fa-trash-o"></i></a>
   	     	 				<a href="'.$comm["comm"][$comID]["parseurl2"].'" class="btn btn-default btn-xs commedit"><i class="fa fa-pencil"></i></a>
   	     	 				<a href="'.$comm["comm"][$comID]["parseurl3"].'" class="btn btn-default btn-xs"><i class="fa fa-ban"></i></a>' : "").($report && $comm["comm"][$comID]["report"] == 0 ? ' <a href="'.$comm["comm"][$comID]["parseurl4"].'" class="btn btn-xs btn-warning commedit"><i class="fa fa-exclamation-triangle"></i></a>' : "").'
   	     	 			</div>
   	     	 		</div></li>';
   	     	 	if (!$comm["comm"][$comID]["commentid"]) {
   	     	 		$html .= '<li><ul><li id="insertPost_'.$comm["comm"][$comID]["id"].'"></li></ul></li>';
   	     	 	}
   	     }
   	     if (isset($comm['subcomm'][$comID])) {
   	        $html .= '<li><div class="comment-wrapper">
   	        	 			<div class="comment-author"><img src="'.($comm["comm"][$comID]["userid"] != 0 ? BASE_URL.JAK_FILES_DIRECTORY.'/userfiles'.$comm["comm"][$comID]["picture"] : BASE_URL.JAK_FILES_DIRECTORY.'/userfiles'.'/standard.png').'" alt="avatar" /> '.$comm["comm"][$comID]["username"].'</div>
   	        	 			'.(($comm["comm"][$comID]["approve"] == 0 && !empty($comm["comm"][$comID]["session"]) && $session == $comm["comm"][$comID]["session"]) ? '<div class="alert alert-info">'.$approve.'</div>' : "").'
   	        	 			<div class="com">
   	        	 				'.$comm["comm"][$comID]["message"].'
   	        	 			</div>
   	        	 			<!-- Comment Controls -->
   	        	 			<div class="comment-actions">
   	        	 				<span class="comment-date">'.$comm["comm"][$comID]["created"].'</span>
   	        	 				<a href="javascript:void(0);" data-cvote="up" data-id="'.$comm["comm"][$comID]["id"].'" data-table="'.$table.'" class="jak-cvote"><i class="fa fa-thumbs-up"></i></a>
   	        	 				<a href="javascript:void(0);" data-cvote="down" data-id="'.$comm["comm"][$comID]["id"].'" data-table="'.$table.'" class="jak-cvote"><i class="fa fa-thumbs-down"></i></a>
   	        	 				<!-- Votes -->
   	        	 				<span id="jak-cvotec'.$comm["comm"][$comID]["id"].'" class="label label-'.jak_comment_votes($comm["comm"][$comID]["votes"]).'">'.$comm["comm"][$comID]["votes"].'</span>
   	        	 				'.($permission && $status && !$comm["comm"][$comID]["commentid"] ? '<a href="javascript:void(0);" data-id="'.$comm["comm"][$comID]["id"].'" class="btn btn-xs btn-primary comment-reply-btn jak-creply"><i class="fa fa-share-alt"></i> '.$reply.'</a>' : '').'
   	        	 				'.($access ? '<a href="'.$comm["comm"][$comID]["parseurl1"].'" class="btn btn-default btn-xs"><i class="fa fa-trash-o"></i></a>
   	        	 				<a href="'.$comm["comm"][$comID]["parseurl2"].'" class="btn btn-default btn-xs commedit"><i class="fa fa-pencil"></i></a>
   	        	 				<a href="'.$comm["comm"][$comID]["parseurl3"].'" class="btn btn-default btn-xs"><i class="fa fa-ban"></i></a>' : "").($report && $comm["comm"][$comID]["report"] == 0 ? ' <a href="'.$comm["comm"][$comID]["parseurl4"].'" class="btn btn-xs btn-warning commedit"><i class="fa fa-exclamation-triangle"></i></a>' : "").'
   	        	 			</div>
   	        	 		</div></li><li>';
   	        $html .= jak_build_comments($comID, $comm, "", $access, $session, $approve, $reply, $permission, $table, $report, $status);
   	        $html .= '</li>';
   	        if (!$comm["comm"][$comID]["commentid"]) {
   	       		$html .= '<li><ul><li id="insertPost_'.$comm["comm"][$comID]["id"].'"></li></ul></li>';
   	        }
   	     }
   	  }
      
      $html .= '</ul>';
   }
   
   return $html;
}

// only full words
function jak_cut_text($text,$limit,$jakvar2) {
	
	// empty limit
	if (empty($limit)) $limit = 160;
    $text = trim($text);
    $text = strip_tags($text);
    $text = str_replace(array("\r","\n",'"'), "", $text);
    $txtl = strlen($text);
    if($txtl > $limit) {
        for($i=1;$text[$limit-$i]!=" ";$i++) {
            if($i == $limit) {
                return substr($text,0,$limit).$jakvar2;
            }
        }
        $jakdata = substr($text,0,$limit-$i+1).$jakvar2;
    } else {
    	$jakdata = $text;
    }
    return $jakdata;
}

// Render strings from content
function jak_render_string($str, $parms) {
    // if
    $str = preg_replace_callback('/{{if (?P<name>\w+)}}(?P<inner>.*?){{endif}}/is', function($match) use ($parms) {
        if( isset($parms[$match['name']])) {
            // recursive
            return jak_render_string($match['inner'], $parms);
        }
    }, $str);
    return $str;
}

function jak_write_vote_hits_cookie($table, $id, $cookie) {
	if (isset($_COOKIE[$cookie])) {

	$cookiearray = explode(',', $_COOKIE[$cookie]);
		
	if (in_array($table.'-'.$id, $cookiearray)) {
		$getCORE = $_COOKIE[$cookie];
	} else {
		$getCORE = $_COOKIE[$cookie].','.$table.'-'.$id;
	}
	
	} else {
		$getCORE = $table.'-'.$id;
	}
	
		return setcookie($cookie, $getCORE, time() + 60 * 60 * 24, JAK_COOKIE_PATH);
}

function jak_cookie_voted_hits($table, $id, $cookie) {

	if (isset($_COOKIE[$cookie])) {
	
		$cookiearray = explode(',', $_COOKIE[$cookie]);
			
		if (in_array($table.'-'.$id, $cookiearray)) {
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}

}

// Get a clean and secure post from user
function jak_clean_safe_userpost($input) {

	// Trim text
	$input = trim($input);
	
	// keep going and remove dirty code
	include_once 'htmlawed.php';
	
	if (get_magic_quotes_gpc()) $input = stripslashes($input);
	
	// now we convert the code stuff into code blocks
	$input = preg_replace_callback('/<pre><code>(.*?)<\/code><\/pre>/imsu', 'jak_precode', $input);
	  
	$allowedhtml = array('safe' => 1, 'elements'=>'em, p, br, img, ul, li, ol, a, strong, pre, code', 'deny_attribute'=>'class, title, id, style, on*','comment'=>1, 'cdata' => 1, 'valid_xhtml' => 1, 'make_tag_strict' => 1);
	$allowedatr = '';
	$input = htmLawed($input, $allowedhtml, $allowedatr);
	global $jkv;
	if ($jkv["usr_smilies"]) {
	
		require_once APP_PATH.'class/class.smileyparser.php';	
		
		// More dirty custom work and smiley parser
		$smileyparser = new JAK_smiley(); 
		$input = $smileyparser->parseSmileytext($input);
	}
	
	// Now return the input
	if ($input) {	
    	return $input;
    } else {
    	return false;
    }
}

function jak_edit_safe_userpost($input) {
	
	// now we convert the code stuff into code blocks
	$input = preg_replace_callback('/<pre><code>(.*?)<\/code><\/pre>/imsu', 'jak_editcode', $input);
	
	$input = stripslashes($input);
	
	return $input;
	
}

// Get comments votes 
function jak_comment_votes($votes) {
		
		if (isset($votes) && $votes != 0) {
			if ($votes < 0) {
				return 'danger';
			} else {
				return 'success';
			}
		} else {
			return 'default';
		}
}

// Get the real IP Address
function get_ip_address() {
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
                    return $ip;
                }
            }
        }
    }
    
    return 0;
}

// Password generator
function jak_password_creator($length = 8) {
	return substr(md5(rand().rand()), 0, $length);
}

// encrypt email address (prevent spam)
function jak_encode_email($e) {
	for ($i = 0; $i < strlen($e); $i++) { $output .= '&#'.ord($e[$i]).';'; }
	return $output;
}

// Get the referrer
function selfURL() {

	$referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $_SERVER['PHP_SELF'];
	
	$referrer = filter_var($referrer, FILTER_VALIDATE_URL);
    
    return $referrer;  
}
function jak_precode($matches) {
	return str_replace($matches[1],htmlentities($matches[1]),$matches[0]);
}
function jak_editcode($matches) {
	return str_replace($matches[1],htmlspecialchars($matches[1]),$matches[0]);
}
?>