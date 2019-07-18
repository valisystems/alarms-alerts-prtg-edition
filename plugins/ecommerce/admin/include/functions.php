<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

function jak_get_shop($table, $limit) {
	
	global $jakdb;
	$jakdata = array();
    $result = $jakdb->query('SELECT * FROM '.$table.' ORDER BY ecorder ASC '.$limit);
    while ($row = $result->fetch_assoc()) {
            // collect each record into $_data
            $jakdata[] = $row;
        }
        
    return $jakdata;
}

// Get the data per id
function jak_get_payment($table, $id, $status) {
	
	$sqlw = '';
	if ($id) $sqlw = ' WHERE id = '.smartsql($id).'';
	if ($status) $sqlw = ' WHERE status = 1';
	
	global $jakdb;
	$jakdata = array();
    $result = $jakdb->query('SELECT * FROM '.$table.$sqlw.' ORDER BY msporder ASC');
    while ($row = $result->fetch_assoc()) {
            // collect each record into $_data
            $jakdata[] = array('id' => $row['id'], 'title' => $row['title'], 'field' => $row['field'], 'field1' => $row['field1'], 'field2' => $row['field2'], 'field3' => $row['field3'], 'fees' => $row['fees'], 'status' => $row['status'], 'msporder' => $row['msporder']);
        }

    return $jakdata;
}

function jak_get_shop_orders($limit, $search_term, $check_row, $paid) {
	
	$sqlwhere = '';
	if (!empty($check_row)) $sqlwhere = 'WHERE '.$check_row.' = "'.smartsql($search_term).'" AND paid = "'.smartsql($paid).'" ';
	
	global $jakdb;
	$jakdata = array();
    $result = $jakdb->query('SELECT id, paid_method, paidtime, time, ordernumber, paid, paidtime, order_booked FROM '.DB_PREFIX.'shop_order '.$sqlwhere.'ORDER BY time DESC '.$limit);
    while ($row = $result->fetch_assoc()) {
    
    	if (!empty($row['paidtime'])) {
    		$paidtime = $row['paidtime'];
    	} else {
    		$paidtime = '';
    	}
    	
        $jakdata[] = array('id' => $row['id'], 'paid_method' => $row['paid_method'], 'ordertime' => $row['time'], 'ordernumber' => $row['ordernumber'], 'paid' => $row['paid'], 'paidtime' => $row['paidtime'], 'booked' => $row['order_booked']);
    }
    return $jakdata;
}

function getCountry($selected, $where) {

	global $jakdb;
	
	$sqlwhere = $country_list = '';
	if ($where) $sqlwhere = ' WHERE id = '.$where.'';
	
	$result = $jakdb->query('SELECT id, name FROM '.DB_PREFIX.'shop_country'.$sqlwhere.' LIMIT 240');
	while ($row = $result->fetch_assoc()) {
	
		$select = '';
		if ($selected == $row['id']) $select = ' selected="selected" ';
		
		if (!$where) {
			$country_list .= '<option value="'.$row['id'].'"'.$select.'>'.$row['name'].'</option>';
		} else {
			$country_list = $row['name'];
		}
	}
	
	return $country_list;

}

// Get all user out the database limited with the paginator
function jak_shop_search($jakvar) {
	
	$jakdata = array();
	global $jakdb;
    $result = $jakdb->query('SELECT id, paid_method, email paidtime, time, ordernumber, paid, paidtime, order_booked FROM '.DB_PREFIX.'shop_order WHERE email like "%'.$jakvar.'%" OR name like "%'.$jakvar.'%" OR ordernumber like "%'.$jakvar.'%" ORDER BY id ASC LIMIT 10');
     while ($row = $result->fetch_assoc()) {
            // collect each record into $_data
            $jakdata[] = array('id' => $row['id'], 'paid_method' => $row['paid_method'], 'ordertime' => $row['time'], 'ordernumber' => $row['ordernumber'], 'paid' => $row['paid'], 'paidtime' => $row['paidtime'], 'booked' => $row['order_booked']);
        }
        
    return $jakdata;
}

// Menu builder function, parentId 0 is the root
function jak_build_menu_shop($parent, $menu, $lang, $class = "", $id = "")
{
   $html = "";
   if (isset($menu['parents'][$parent])) {
      $html .= "
      <ul".$class.$id.">\n";
       foreach ($menu['parents'][$parent] as $itemId) {
          if (!isset($menu['parents'][$itemId])) {
          	$html .= '<li id="menuItem_'.$menu["items"][$itemId]["id"].'" class="jakcat">
          		<div>
          		<span class="text">#'.$menu["items"][$itemId]["id"].' <a href="index.php?p=shop&amp;sp=categories&amp;ssp=edit&amp;sssp='.$menu["items"][$itemId]["id"].'">'.$menu["items"][$itemId]["name"].'</a></span>
          		<span class="actions">
          			<a href="index.php?p=shop&amp;sp=categories&amp;ssp=lock&amp;sssp='.$menu["items"][$itemId]["id"].'" class="btn btn-default btn-xs"><i class="fa fa-'.($menu["items"][$itemId]["active"] == 0 ? 'lock' : 'check').'"></i></a> 
          			<a href="index.php?p=shop&amp;sp=new&amp;ssp='.$menu["items"][$itemId]["id"].'" class="btn btn-default btn-xs"><i class="fa fa-sticky-note-o"></i></a>
          			<a href="index.php?p=shop&amp;sp=categories&amp;ssp=edit&amp;sssp='.$menu["items"][$itemId]["id"].'" class="btn btn-default btn-xs"><i class="fa fa-edit"></i></a>
          			<a href="index.php?p=shop&amp;sp=categories&amp;ssp=delete&amp;sssp='.$menu["items"][$itemId]["id"].'" class="btn btn-danger btn-xs" onclick="if(!confirm('.$lang.'))return false;"><i class="fa fa-trash-o"></i></a>	
          		</span></div></li>';
          }
          if (isset($menu['parents'][$itemId])) {
          	$html .= '<li id="menuItem_'.$menu["items"][$itemId]["id"].'" class="jakcat">
          		<div>
          		<span class="text">#'.$menu["items"][$itemId]["id"].' <a href="index.php?p=shop&amp;sp=categories&amp;ssp=edit&amp;sssp='.$menu["items"][$itemId]["id"].'">'.$menu["items"][$itemId]["name"].'</a></span>
          		<span class="actions">
          			<a href="index.php?p=shop&amp;sp=categories&amp;ssp=lock&amp;sssp='.$menu["items"][$itemId]["id"].'" class="btn btn-default btn-xs"><i class="fa fa-'.($menu["items"][$itemId]["active"] == 0 ? 'lock' : 'check').'"></i></a> 
          				<a href="index.php?p=shop&amp;sp=new&amp;ssp='.$menu["items"][$itemId]["id"].'" class="btn btn-default btn-xs"><i class="fa fa-sticky-note-o"></i></a>
          				<a href="index.php?p=shop&amp;sp=categories&amp;ssp=edit&amp;sssp='.$menu["items"][$itemId]["id"].'" class="btn btn-default btn-xs"><i class="fa fa-edit"></i></a>
          				<a href="index.php?p=shop&amp;sp=categories&amp;ssp=delete&amp;sssp='.$menu["items"][$itemId]["id"].'" class="btn btn-danger btn-xs" onclick="if(!confirm('.$lang.'))return false;"><i class="fa fa-trash-o"></i></a>	
          		</span>
          		</div>';
             $html .= jak_build_menu_shop($itemId, $menu, $lang);
             $html .= "</li> \n";
          }
       }
       $html .= "</ul> \n";
   }
   return $html;
}
?>