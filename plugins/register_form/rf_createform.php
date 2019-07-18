<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

function jak_create_register_form($jakvar1, $limit, $register = false) {

	// Now get all the options from the choosen form and create the form in html include all the javascript options
	global $jakdb;
	global $jakuser;
	
	$sqlwhere = $jakdata = '';
	if ($limit) $sqlwhere = 'WHERE id > '.$limit.' ';
	if ($register) $sqlwhere .= ($sqlwhere ? $sqlwhere.'AND showregister = 1' : 'WHERE showregister = 1 ');
	
	$result = $jakdb->query('SELECT * FROM '.DB_PREFIX.'registeroptions '.$sqlwhere.'ORDER BY forder ASC');
	while ($row = $result->fetch_assoc()) {
		
		// Reset each var the while goes thru
		$optarray = '';
		$optarrayradio = '';
		$selectopt = '';
		$radioopt = '';
		$optionsel = '';
		$optioncheck = '';
		$cmeter = '';
		$cmeterdiv = '';
		
		// Start with the form
		if ($row['typeid'] == 1) {
			
			$mandatory = '';
			if ($row['mandatory']) $mandatory = ' <i class="fa fa-star"></i>';
			
			if ($row['mandatory'] == 4) {
				$cmeter = ' class="check_password"';
				$cmeterdiv = '<div class="form-group"><label class="control-label">'.$tl["login"]["l4"].' <i class="fa fa-star"></i></label><div class="progress progress-striped active">
				  <div id="jak_pstrength" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
				</div></div>';
			}
			
			$jakdata .= '<div class="form-group"><label class="control-label" for="'.$row['id'].'">'.$row['name'].$mandatory.'</label><div class="controls"><input type="text" class="form-control" name="'.$row['id'].'"'.$cmeter.' value="'.(JAK_USERID ? $jakuser->getVar(strtolower(preg_replace("/[^a-zA-Z0-9]+/", "", $row['name']).'_'.$row['id'])) : "").'" placeholder="'.$row['name'].'" /></div></div>'.$cmeterdiv;	
		}
		
		if ($row['typeid'] == 2) {
			
			$mandatory = '';
			if ($row['mandatory']) $mandatory = ' <i class="fa fa-star"></i>';
			
			$jakdata .= '<div class="form-group"><label class="control-label" for="'.$row['id'].'">'.$row['name'].$mandatory.'</label><div class="controls"><textarea name="'.$row['id'].'" class="form-control'.$cmeter.'">'.(JAK_USERID ? $jakuser->getVar(strtolower(preg_replace("/[^a-zA-Z0-9]+/", "", $row['name']).'_'.$row['id'])) : "").'</textarea></div></div>';	
		}
		
		if ($row['typeid'] == 3) {
			
			$mandatory = '';
			if ($row['mandatory']) $mandatory = ' <i class="fa fa-star"></i>';
			
			$optarray = explode(',', $row['options']);
			
			for ($i = 0; $i < count($optarray); $i++) {
			
				$selectopt .= '<option value="'.$optarray[$i].'"'.(JAK_USERID && strtolower(preg_replace("/[^a-zA-Z0-9]+/", "", $row['name'])).'_'.$row['id'] == $optarray[$i] ? ' selected="selected"' : "").'>'.$optarray[$i].'</option>';
			}
			
			$jakdata .= '<div class="form-group"><label class="control-label" for="'.$row['id'].'">'.$row['name'].$mandatory.'</label><select name="'.$row['id'].'" class="form-control"><option value="">'.$jakvar1.'</option>'.$selectopt.'</select></div>';	
		}
		
		if ($row['typeid'] == 4) {
			
			$mandatory = '';
			if ($row['mandatory']) $mandatory = ' <i class="fa fa-star"></i>';
			
			$optarrayradio = explode(',', $row['options']);
			
			for ($i = 0; $i < count($optarrayradio); $i++) {
				
				$radioopt .= '<div class="radio"><label><input type="radio" name="'.$row['name'].'" value="'.$optarrayradio[$i].'"'.(JAK_USERID && $jakuser->getVar(strtolower(preg_replace("/[^a-zA-Z0-9]+/", "", $row['name'])).'_'.$row['id']) == $optarrayradio[$i] ? ' checked="checked"' : "").'> '.$optarrayradio[$i].'</label></div>';
			}
			
			$jakdata .= '<div class="form-group"><label class="control-label" for="'.$row['name'].'">'.$row['name'].$mandatory.'</label>'.$radioopt.'</div>';	
		}
		
		$alloptionid[] = $row['id'];
		$alloptionnames[] = $row['name'];
		$alloptionmandatory[] = $row['mandatory'];
		$alloptiontype[] = $row['typeid'];
		
	}
			// Get all options id in one list to recheck after in php
			if (!empty($alloptionid)) {
				$optlist = join(",", $alloptionid);
			}
			
			// Get all options names in one list to recheck after in php
			if (!empty($alloptionnames)) {
				$optlistname = join(",", $alloptionnames);
			}
			
			// Get all mandatory fields in one list to recheck after in php
			if (!empty($alloptionmandatory)) {
				$optlistmandatory = join(",", $alloptionmandatory);
			}
			
			// Get all options types in one list to recheck after in php
			if (!empty($alloptiontype)) {
				$optlisttype = join(",", $alloptiontype);
			}
			
			$jakdata .= '<input type="hidden" name="optlist" value="'.base64_encode($optlist).'" />';
			$jakdata .= '<input type="hidden" name="optlistname" value="'.$optlistname.'" />';
			$jakdata .= '<input type="hidden" name="optlistmandatory" value="'.base64_encode($optlistmandatory).'" />';
			$jakdata .= '<input type="hidden" name="optlisttype" value="'.base64_encode($optlisttype).'" />';
	
	return $jakdata;
}
?>