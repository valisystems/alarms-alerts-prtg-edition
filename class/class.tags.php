<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

class JAK_tags
{
	private $jakvar;
	private $jakvar1;
	protected $table = '', $varname = '', $seo = '', $plugin = '';
	
	// This constructor can be used for all classes:
	
	public function __construct(array $options){
			
			foreach($options as $k=>$v){
				if(isset($this->$k)){
					$this->$k = $v;
				}
			}
	}
	
	public static function jakGettagcloud($varname, $table, $limit, $maxsize, $minsize)
	{
		
		    // Pull in tag data
		    global $jakdb;
		    $result = $jakdb->query('SELECT * FROM '.DB_PREFIX.$table.' GROUP BY tag ORDER BY count DESC LIMIT '.smartsql($limit));
		    while($row = $result->fetch_assoc()) {
		    	$cloud[$row['tag']] = $row['count'];
		    }
		    
		    if (isset($cloud)) {
		    	ksort($cloud);
		    	$tags = $cloud;
		    }
		    
		    if (isset($tags)) {
		
		    	$minimum_count = min(array_values($tags));
		    	$maximum_count = max(array_values($tags));
		    	$spread = $maximum_count - $minimum_count;
		
		    	if($spread == 0) {
		        	$spread = 1;
		    	}
				
				$my_colours = array("success","primary","warning","info");
		    	$cloud_html = '';
		    	$cloud_tags = array(); // create an array to hold tag code
		    	foreach ($tags as $tag => $count) {
		    		shuffle($my_colours);
		        	$size = $minsize + ($count - $minimum_count) 
		            * ($maxsize - $minsize) / $spread;
		        		$cloud_tags[] = '<a style="font-size:'.floor($size).'px" class="btn btn-'.$my_colours[0].'" href="'.JAK_rewrite::jakParseurl($varname, JAK_base::jakCleanurl($tag), '', '', '').'">'.htmlspecialchars(stripslashes($tag)).'</a>';
		    	}
		    	$cloud_html = join("\n", $cloud_tags) . "\n";
		    	return $cloud_html;
			}
	}
	
	public static function jakGettagcloudlimited($url, $slug1, $items, $pluginid, $table, $limit, $maxsize, $minsize)
	{
		
		    // Pull in tag data
		    global $jakdb;
		    $result = $jakdb->query('SELECT tag FROM '.DB_PREFIX.$table.' WHERE itemid IN('.join(",", $items).') AND pluginid = "'.smartsql($pluginid).'" AND active = 1 GROUP BY tag ORDER BY tag DESC LIMIT '.smartsql($limit));
		    while($row = $result->fetch_assoc()) {
		    	$tags[] = '<a class="label label-default" href="'.JAK_rewrite::jakParseurl($url, $slug1, JAK_base::jakCleanurl($row['tag'])).'">'.$row['tag'].'</a>';
		    }
		    
		    if (!empty($tags)) {
		    	$taglist = join(" ", $tags);
		    	return $taglist;
		    } else {
		    	return false;
		    }
	}
	
	public static function jakGettaglist($jakvar,$jakvar1,$where)
	{
		
		global $jakdb;
		$result = $jakdb->query('SELECT tag FROM '.DB_PREFIX.'tags WHERE itemid = "'.smartsql($jakvar).'" AND pluginid = "'.smartsql($jakvar1).'" AND active = 1 ORDER BY id DESC');
		
		while($row = $result->fetch_assoc()) {
			$tags[] = '<a class="label label-default" href="'.JAK_rewrite::jakParseurl($where, JAK_base::jakCleanurl($row['tag']), '', '', '').'">'.$row['tag'].'</a>';
		}
		
		if (!empty($tags)) {
			$taglist = join(" ", $tags);
			return $taglist;
		} else {
			return false;
		}
	}
	
	public function jakPlugintag($allcat)
	{
		
		foreach($allcat as $c)
		{
			if ($c['pluginid'] == 3)
				$case = $c['pagename'];
				
		}
		
		return $case;
	
	}
	
	public static function jakInsertags($tags,$itemid,$module,$active)
	{
		
		$striptags = strip_tags($tags);
		$smalltags = strtolower($striptags);
		$tagarray = explode(' ', $smalltags);
			
		for ($i = 0; $i < count($tagarray); $i++) {
			$tag = $tagarray[$i];
			$tag = trim($tag);
			$urlTAG = JAK_base::jakCleanurl($tag);
				
			// check if tag exist
			global $jakdb;
			$jakdb->query('SELECT id FROM '.DB_PREFIX.'tags WHERE tag = "'.smartsql($urlTAG).'" AND itemid = "'.smartsql($itemid).'" AND pluginid = "'.smartsql($module).'" LIMIT 1');
				
		    if ($jakdb->affected_rows != 1) {
		        
				// insert data
		        $jakdb->query('INSERT INTO '.DB_PREFIX.'tags VALUES (NULL,"'.smartsql($urlTAG).'","'.smartsql($itemid).'","'.smartsql($module).'", "'.$active.'")');
			}
		}
	}
	
	public static function jakBuildcloud($tags,$itemid,$module)
	{
	
		$striptags = strip_tags($tags);
		$smalltags = strtolower($striptags);
		$tagarray = explode(' ', $smalltags);
			
		for ($i = 0; $i < count($tagarray); $i++) {
			
			$tag = $tagarray[$i];
			$tag = trim($tag);
			$urlTAG = JAK_base::jakCleanurl($tag);
				
			// check if tag exist
			global $jakdb;
			$jakdb->query('SELECT id FROM '.DB_PREFIX.'tags WHERE tag = "'.smartsql($urlTAG).'" AND itemid = "'.smartsql($itemid).'" AND pluginid = "'.smartsql($module).'" LIMIT 1');
			
			// If tag not exist
		    if ($jakdb->affected_rows != 1) {
		    
		        $result = $jakdb->query('SELECT id FROM '.DB_PREFIX.'tagcloud WHERE tag = "'.smartsql($urlTAG).'" LIMIT 1');
		        $tagID = $result->fetch_assoc();
		        
		        if ($jakdb->affected_rows > 0) {
		       		// update counter
		        	$jakdb->query('UPDATE '.DB_PREFIX.'tagcloud SET count = count + 1 WHERE id = "'.$tagID['id'].'"');
		
		        } else {
		        
		       	// insert complete tag
		        $jakdb->query('INSERT INTO '.DB_PREFIX.'tagcloud SET tag = "'.smartsql($urlTAG).'"');
				}
			}
		}
	}
	
	public static function jakTagsql($table, $itemid, $select, $cuttext, $plugin, $link, $seo) {
	
		$shorty = '';
		global $jakdb;
		global $jkv;
		
		if ($table == "gallerycategories") {
			$result = $jakdb->query('SELECT '.$select.' FROM '.DB_PREFIX.$table.' WHERE id = "'.smartsql($itemid).'" LIMIT 1');
		} else {
			$result = $jakdb->query('SELECT '.$select.' FROM '.DB_PREFIX.$table.' WHERE id = "'.smartsql($itemid).'" LIMIT 1');
		}
		$row = $result->fetch_assoc();
		if ($jakdb->affected_rows > 0) {
		
			if ($cuttext) {
				$shorty = jak_cut_text($row[$cuttext],$jkv["shortmsg"],'...');
			}
			
			if ($table == "gallerycategories") {
				$title = $row['name'];
			} else {
				$title = $row['title'];
			}
			
			// There should be always a varname in categories and check if seo is valid
			if ($seo && $row['title']) {
				$seo = JAK_base::jakCleanurl($row['title']);
			}
			$parseurl = JAK_rewrite::jakParseurl($plugin, $link, $row['id'], $seo, '');
			$jakdata = array('parseurl' => $parseurl, 'title' => $title, 'content' => $shorty);
		}
		
		return $jakdata;
	
	}
	
	public static function jakLocktag($id) {
	
		global $jakdb;
		$row = $jakdb->queryRow('SELECT tag, active FROM '.DB_PREFIX.'tags WHERE id = "'.smartsql($id).'"');
			
		// Get the count number
		$count = $jakdb->queryRow('SELECT count FROM '.DB_PREFIX.'tagcloud WHERE tag = "'.smartsql($row['tag']).'" LIMIT 1');
		
		if ($row['active'] == 1) {
		
		    if ($count['count'] <= '1') {
				$jakdb->query('DELETE FROM '.DB_PREFIX.'tagcloud WHERE tag = "'.smartsql($row['tag']).'"');
			} else {
				$jakdb->query('UPDATE '.DB_PREFIX.'tagcloud SET count = count - 1 WHERE tag = "'.smartsql($row['tag']).'"');
			}
		} else {
		
			if ($jakdb->affected_rows == 0) {
				$jakdb->query('INSERT INTO '.DB_PREFIX.'tagcloud SET tag = "'.smartsql($row['tag']).'"');
			} else {
				$jakdb->query('UPDATE '.DB_PREFIX.'tagcloud SET count = count + 1 WHERE tag = "'.smartsql($row['tag']).'"');
			}
		}
		
		$jakdb->query('UPDATE '.DB_PREFIX.'tags SET active = IF (active = 1, 0, 1) WHERE id = "'.smartsql($id).'"');
		   
	}
	
	public static function jakLocktags($jakvar,$jakvar1) {
	
		global $jakdb;
		$result = $jakdb->query('SELECT tag, active FROM '.DB_PREFIX.'tags WHERE itemid = "'.smartsql($jakvar).'" AND pluginid = "'.smartsql($jakvar1).'"');
		while ($row = $result->fetch_assoc()) {
			
			// Get the count number
		    $count = $jakdb->queryRow('SELECT count FROM '.DB_PREFIX.'tagcloud WHERE tag = "'.smartsql($row['tag']).'" LIMIT 1');
		    
			if ($row['active'] == 1) {
			
			    if ($count['count'] <= '1') {
					$jakdb->query('DELETE FROM '.DB_PREFIX.'tagcloud WHERE tag = "'.smartsql($row['tag']).'"');
				} else {
					$jakdb->query('UPDATE '.DB_PREFIX.'tagcloud SET count = count - 1 WHERE tag = "'.smartsql($row['tag']).'"');
				}
			} else {
			
				if ($jakdb->affected_rows == 0) {
					$jakdb->query('INSERT INTO '.DB_PREFIX.'tagcloud SET tag = "'.smartsql($row['tag']).'"');
				} else {
					$jakdb->query('UPDATE '.DB_PREFIX.'tagcloud SET count = count + 1 WHERE tag = "'.smartsql($row['tag']).'"');
				}
			}
		}
		
		$jakdb->query('UPDATE '.DB_PREFIX.'tags SET active = IF (active = 1, 0, 1) WHERE itemid = "'.smartsql($jakvar).'" AND pluginid = "'.smartsql($jakvar1).'"');
		   
	}
	
	public static function jakDeletetags($jakvar,$jakvar1) {
	
		global $jakdb;
		$result = $jakdb->query('SELECT tag FROM '.DB_PREFIX.'tags WHERE itemid = "'.smartsql($jakvar).'" AND pluginid = "'.smartsql($jakvar1).'"');
		while ($row = $result->fetch_assoc()) {
		    
			// Get the count number
			$count = $jakdb->queryRow('SELECT count FROM '.DB_PREFIX.'tagcloud WHERE tag = "'.smartsql($row['tag']).'" LIMIT 1');
		       
			if ($count['count'] <= '1') {
				$jakdb->query('DELETE FROM '.DB_PREFIX.'tagcloud WHERE tag = "'.smartsql($row['tag']).'"');
			} else {
				$jakdb->query('UPDATE '.DB_PREFIX.'tagcloud SET count = count - 1 WHERE tag = "'.smartsql($row['tag']).'"');
			}
		}
		
		$jakdb->query('DELETE FROM '.DB_PREFIX.'tags WHERE itemid = "'.smartsql($jakvar).'" AND pluginid = "'.smartsql($jakvar1).'"');
	}
	
	public static function jakDeleteonetag($tag)
	{
		
		global $jakdb;
		$result = $jakdb->query('SELECT tag FROM '.DB_PREFIX.'tags WHERE id = '.smartsql($tag).' LIMIT 1');
	    $tagname = $result->fetch_assoc();
	       
	    $result1 = $jakdb->query('SELECT count FROM '.DB_PREFIX.'tagcloud WHERE tag = "'.$tagname['tag'].'" LIMIT 1');
	    $count = $result1->fetch_assoc();
	       
	    if ($count['count'] <= '1') {
	    
			$jakdb->query('DELETE FROM '.DB_PREFIX.'tagcloud WHERE tag = "'.$tagname['tag'].'"');
	
		} else {
	
			$jakdb->query('UPDATE '.DB_PREFIX.'tagcloud SET count = count - 1 WHERE tag = "'.$tagname['tag'].'"');
	
		}
	            
	    	$jakdb->query('DELETE FROM '.DB_PREFIX.'tags WHERE id = '.smartsql($tag).'');
	}

}
?>