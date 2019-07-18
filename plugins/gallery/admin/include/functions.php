<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Get the data per array for gallerys
function jak_get_gallerys($limit, $cid, $table) {

	$sqlwhere = '';
	if (!empty($cid)) $sqlwhere = 'WHERE catid = "'.smartsql($cid).'" ';
	
	global $jakdb;
	$jakdata = array();
    $result = $jakdb->query('SELECT * FROM '.$table.' '.$sqlwhere.'ORDER BY picorder ASC '.$limit);
    while ($row = $result->fetch_assoc()) {
            // collect each record into $_data
            $jakdata[] = $row;
        }
        
    return $jakdata;
}

// Get the gallery comments
function jak_get_gallery_comments($limit,$jakvar1,$jakvar2) 
{
	if ($jakvar1 == 'approve') {
		$sqlwhere = 'WHERE approve = 0 AND trash = 0 ';
	} elseif ($jakvar2 == 'galleryid') {
		$sqlwhere = 'WHERE galleryid = '.smartsql($jakvar1).' AND trash = 0 ';
	} elseif ($jakvar2 == 'userid') {
		$sqlwhere = 'WHERE userid = '.smartsql($jakvar1).' AND trash = 0 ';
	} else {
		$sqlwhere = 'WHERE trash = 0 ';
	}
	
	global $jakdb;
	$jakdata = array();
    $result = $jakdb->query('SELECT * FROM '.DB_PREFIX.'gallerycomments '.$sqlwhere.'ORDER BY time DESC '.$limit);
    while ($row = $result->fetch_assoc()) {
            // collect each record into $_data
            $jakdata[] = $row;
        }

    return $jakdata;
}

// Menu builder function, parentId 0 is the root
function jak_build_menu_gallery($parent, $menu, $lang, $class = "", $id = "")
{
   $html = "";
   if (isset($menu['parents'][$parent])) {
      $html .= "
      <ul".$class.$id.">\n";
       foreach ($menu['parents'][$parent] as $itemId) {
          if (!isset($menu['parents'][$itemId])) {
          	$html .= '<li id="menuItem_'.$menu["items"][$itemId]["id"].'" class="jakcat">
          		<div>
          		<span class="text">#'.$menu["items"][$itemId]["id"].' <a href="index.php?p=gallery&amp;sp=categories&amp;ssp=edit&amp;sssp='.$menu["items"][$itemId]["id"].'">'.$menu["items"][$itemId]["name"].'</a></span>
          		<span class="actions">
          			<a href="index.php?p=gallery&amp;sp=categories&amp;ssp=lock&amp;sssp='.$menu["items"][$itemId]["id"].'" class="btn btn-default btn-xs"><i class="fa fa-'.($menu["items"][$itemId]["active"] == 0 ? 'lock' : 'check').'"></i></a> 
          			<a href="index.php?p=gallery&amp;sp=new&amp;ssp='.$menu["items"][$itemId]["id"].'" class="btn btn-default btn-xs"><i class="fa fa-sticky-note-o"></i></a>
          			<a href="index.php?p=gallery&amp;sp=categories&amp;ssp=watermark&amp;sssp='.$menu["items"][$itemId]["id"].'" class="btn btn-default btn-xs watermark"><i class="fa fa-picture-o"></i></a>
          			<a href="index.php?p=gallery&amp;sp=categories&amp;ssp=edit&amp;sssp='.$menu["items"][$itemId]["id"].'" class="btn btn-default btn-xs"><i class="fa fa-edit"></i></a>
          			<a href="index.php?p=gallery&amp;sp=categories&amp;ssp=delete&amp;sssp='.$menu["items"][$itemId]["id"].'" class="btn btn-danger btn-xs" onclick="if(!confirm('.$lang.'))return false;"><i class="fa fa-trash-o"></i></a>	
          		</span></div></li>';
          }
          if (isset($menu['parents'][$itemId])) {
          	$html .= '<li id="menuItem_'.$menu["items"][$itemId]["id"].'" class="jakcat">
          		<div>
          		<span class="text">#'.$menu["items"][$itemId]["id"].' <a href="index.php?p=gallery&amp;sp=categories&amp;ssp=edit&amp;sssp='.$menu["items"][$itemId]["id"].'">'.$menu["items"][$itemId]["name"].'</a></span>
          		<span class="actions">
          			<a href="index.php?p=gallery&amp;sp=categories&amp;ssp=lock&amp;sssp='.$menu["items"][$itemId]["id"].'" class="btn btn-default btn-xs"><i class="fa fa-'.($menu["items"][$itemId]["active"] == 0 ? 'lock' : 'check').'"></i></a> 
          				<a href="index.php?p=gallery&amp;sp=new&amp;ssp='.$menu["items"][$itemId]["id"].'" class="btn btn-default btn-xs"><i class="fa fa-sticky-note-o"></i></a>
          				<a href="index.php?p=gallery&amp;sp=categories&amp;ssp=watermark&amp;sssp='.$menu["items"][$itemId]["id"].'" class="btn btn-default btn-xs watermark"><i class="fa fa-picture-o"></i></a>
          				<a href="index.php?p=gallery&amp;sp=categories&amp;ssp=edit&amp;sssp='.$menu["items"][$itemId]["id"].'" class="btn btn-default btn-xs"><i class="fa fa-edit"></i></a>
          				<a href="index.php?p=gallery&amp;sp=categories&amp;ssp=delete&amp;sssp='.$menu["items"][$itemId]["id"].'" class="btn btn-danger btn-xs" onclick="if(!confirm('.$lang.'))return false;"><i class="fa fa-trash-o"></i></a>	
          		</span>
          		</div>';
             $html .= jak_build_menu_gallery($itemId, $menu, $lang);
             $html .= "</li> \n";
          }
       }
       $html .= "</ul> \n";
   }
   return $html;
}
?>