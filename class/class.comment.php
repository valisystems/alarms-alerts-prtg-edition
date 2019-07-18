<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

class JAK_comment
{
	private $data = array();
	
	// Get the lang into the class
	
	public function __construct($table, $where, $id, $var, $ptime, $pdate, $timeago, $limit = "", $sqlwhere = "", $nested = false) {
		/*
		/	The constructor
		*/
		
		global $jakdb;
		$getID = $jakdata = array();
		$result = $jakdb->query('SELECT t1.*, t2.picture, t2.lastactivity FROM '.$table.' AS t1 LEFT JOIN '.DB_PREFIX.'user AS t2 ON (t2.id = t1.userid) WHERE t1.'.$where.' = "'.smartsql($id).'"'.$sqlwhere.' AND ((t1.approve = 1 AND t1.trash = 0) OR (t1.approve = 0 AND t1.trash = 0 AND t1.session = "'.smartsql(session_id()).'")) ORDER BY time ASC '.$limit);
		
		while ($row = $result->fetch_assoc()) {
				
				$row['created'] = JAK_base::jakTimesince($row['time'], $ptime, $pdate, $timeago);
				
				if (strtotime($row['lastactivity']) >= (time() - 1800)) {
					$row["uonstat"] = 1;
				} else {
					$row["uonstat"] = 0;
				}
				
				if (!empty($row['web'])) {
					$row['username'] = '<a href="'.$row['web'].'">'.$row['username'].'</a>';
				} else {
					$row['username'] = $row['username'];
				}
				
				// Sanitize the message
				$row["message"] = jak_secure_site($row['message']);
				
				// There should be always a varname in categories and check if seo is valid
				$row["parseurl1"] = JAK_rewrite::jakParseurl($var, 'del', $row['id'], $row['userid']);
				$row["parseurl2"] = JAK_rewrite::jakParseurl($var, 'ep', $row['id'], $row['userid']);
				$row["parseurl3"] = JAK_rewrite::jakParseurl($var, 'trash', $row['id'], $row['userid']);
				$row["parseurl4"] = JAK_rewrite::jakParseurl($var, 'report', $row['id']);
				
		        // collect each record into $jakdata
		        $jakdata[] = $row;
		        
		        // Do we have nested comments
		        if ($nested) $getID[] = $row["id"];
		        
		    }
		    
		// now we go nested because we have a reply
		if ($nested && !empty($getID)) {
			$resnes = $jakdb->query('SELECT t1.*, t2.picture, t2.lastactivity FROM '.$table.' AS t1 LEFT JOIN '.DB_PREFIX.'user AS t2 ON (t2.id = t1.userid) WHERE t1.commentid IN ('.join(",", $getID).') AND ((t1.approve = 1 AND t1.trash = 0) OR (t1.approve = 0 AND t1.trash = 0 AND t1.session = "'.smartsql(session_id()).'")) ORDER BY time ASC');
			
			while ($nes = $resnes->fetch_assoc()) {
					
					$nes['created'] = JAK_base::jakTimesince($nes['time'], $ptime, $pdate, $timeago);
					
					if (strtotime($nes['lastactivity']) >= (time() - 1800)) {
						$nes["uonstat"] = 1;
					} else {
						$nes["uonstat"] = 0;
					}
					
					if (!empty($nes['web'])) {
						$nes['username'] = '<a href="'.$nes['web'].'">'.$nes['username'].'</a>';
					} else {
						$nes['username'] = $nes['username'];
					}
					
					// Sanitize the message
					$nes["message"] = jak_secure_site($nes['message']);
					
					// There should be always a varname in categories and check if seo is valid
					$nes["parseurl1"] = JAK_rewrite::jakParseurl($var, 'del', $nes['id'], $nes['userid']);
					$nes["parseurl2"] = JAK_rewrite::jakParseurl($var, 'ep', $nes['id'], $id);
					$nes["parseurl3"] = JAK_rewrite::jakParseurl($var, 'trash', $nes['id'], $id);
					$nes["parseurl4"] = JAK_rewrite::jakParseurl($var, 'report', $nes['id']);
					
			        // collect each record into $jakdata
			        $jakdata[] = $nes;
			        
			    }
		}
		
		$this->data = $jakdata;
	}
	
	public function get_comments()
	{
		
		// Setting up an alias, so we don't have to write $this->data every time:
		$d = &$this->data;
		
		return $d;
		
	}
	
	public function get_commentajax($lang, $lang1, $lang2) {
		
		foreach($this->data as $d) {
		
		if ($d['userid'] && $d['picture']) {
			
			$avatar = '<img src="'.BASE_URL.JAK_FILES_DIRECTORY.'/userfiles/'.$d['picture'].'" alt="avatar" />';
		} else {
			
			$avatar = '<img src="'.BASE_URL.JAK_FILES_DIRECTORY.'/userfiles/standard.png" alt="avatar" />';
		}
		
		$approve = "";
		if ($d['session']) {
			$approve = '<div class="alert alert-info">'.$lang2.'</div>';
		}
		
		return '<div class="comment-wrapper">
			<div class="comment-author">'.$avatar.' '.$d['username'].'</div>
			'.$approve.'<div class="com">'.stripslashes($d['message']).'</div>
			
			<!-- Comment Controls -->
			<div class="comment-actions">
				<span class="comment-date">'.$d['created'].'</span>
			</div>
		</div>';
		
		}
	
	}
	
	public function get_total() {
		// Setting up an alias, so we don't have to write $this->data every time:
		$d = $this->data;
		
		if ($d) {
		
			foreach($d as $t)
			{
				$total[] = $t['id'];
			}
		
			// get the total user in one var.
			$total = count($total, COUNT_RECURSIVE);
		
		} else {
		
			$total = 0;
		
		}
		
		return $total;
	}
	
	public static function validate_form(&$arr, $maxpost, $ename, $eemail, $eurl, $epost, $emaxpost, $emaxpost1, $ehuman) {
		/*
		/	This method is used to validate the data sent via AJAX.
		/
		/	It return true/false depending on whether the data is valid, and populates
		/	the $arr array passed as a paremter (notice the ampersand above) with
		/	either the valid input data, or the error messages.
		*/
		
		global $jkv;
		$errors = array();
		$data	= array();
		
		// Using the filter with a custom callback function:
		if (!($data['co_name'] = filter_input(INPUT_POST, 'co_name', FILTER_CALLBACK, array('options'=>'JAK_comment::validate_text')))) {
			$errors['co_name'] = $ename.'<br />';
		}
		
		if (!JAK_USERID) {
		if (!($data['co_email'] = filter_input(INPUT_POST, 'co_email', FILTER_VALIDATE_EMAIL))) {
		    $errors['co_email'] = $eemail.'<br />';
		}
		
		if (filter_input(INPUT_POST , 'co_url')) {
		   if (!($data['co_url'] = filter_input(INPUT_POST, 'co_url', FILTER_VALIDATE_URL))) {
		       $errors['co_url'] = $eurl.'<br />';
		   }
		}
		}
		
		// Using the filter with a custom callback function:
		if (!($data['userpost'] = filter_input(INPUT_POST, 'userpost', FILTER_CALLBACK, array('options'=>'JAK_comment::validate_text')))) {
			$errors['userpost'] = $epost.'<br />';
		}
		
		// Extra id for b2b plugin for example.
		if (filter_input(INPUT_POST , 'uformextraid')) {
		   $data['uformextraid'] = filter_input(INPUT_POST , 'uformextraid');
		}
		
		// Subcomments
		if (filter_input(INPUT_POST , 'comanswerid')) {
		   $data['comanswerid'] = filter_input(INPUT_POST , 'comanswerid');
		}
		
		$data['jakajax'] = "no";
		if (filter_input(INPUT_POST , 'jakajax')) {
		   $data['jakajax'] = filter_input(INPUT_POST , 'jakajax');
		}
		
		// Count comment charactars
		if (!empty($maxpost)) {
			$countI = strlen($data['userpost']);
		
			if ($countI > $maxpost) {
		    	$errors['userpost'] = $emaxpost.$maxpost.' '.$emaxpost1.$countI;
			}
		}
		
		// Check for spam if whish so
		if (!JAK_USERID) {
			if ($jkv["hvm"]) {
				$human_captcha = explode(':#:', $_SESSION['jak_captcha']);
				if (isset($arr[$human_captcha[0]]) && ($arr[$human_captcha[0]] == '' || $arr[$human_captcha[0]] != $human_captcha[1])) {
					$errors['co_human'] = $ehuman.'<br />';
				}
			}
		}
		
		if (!empty($errors)) {
			
			// Now let's check if we have an ajax request.
			$errors['jakajax'] = "no";
			if ($data['jakajax'] == "yes") {
			   $errors['jakajax'] = "yes";
			}
			
			// If there are errors, copy the $errors array to $arr:
			$arr = $errors;
			return false;
		}
		
		// If the data is valid, sanitize all the data and copy it to $arr:
		
		foreach($data as $k=>$v) {
			$arr[$k] = smartsql($v);
		}
		
		// Ensure that the email is lower case:
		
		if (isset($arr['co_email'])) $arr['co_email'] = strtolower(trim($arr['co_email']));
		
		return true;
		
	}

	private static function validate_text($str)
	{
		/*
		/	This method is used internally as a FILTER_CALLBACK
		*/
		
		if (mb_strlen($str, 'utf8') < 1) return false;
			
		$str = htmlspecialchars($str);
		
		// Remove the new line characters that are left
		$str = str_replace(array(chr(10), chr(13)), '', $str); 
		
		return $str;
	}

}
?>