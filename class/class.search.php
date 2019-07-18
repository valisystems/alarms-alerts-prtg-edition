<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

class JAK_search 
{
	protected $table = '', $keyword = '', $groupme = '', $fields = '', $andor = '', $select = '', $plugin = '', $link = '', $dseo = '';
	
	
    public function __construct($keyword) 
    { 
        // filter the keywords
        $this->keyword = $this->id = '';
        if (isset($keyword)) {
        	$filtered = filter_var($keyword, FILTER_SANITIZE_STRING);
        	$this->keyword = strtolower($filtered);
        }
    }
    
    function jakSettable($table, $on) 
    { 
        // Set the table to search trhu but also check if there is more then one!
        if (is_array($table)) {
        	foreach($table as $k => $t)
        		{
        			$tablearray[] = DB_PREFIX.$t.' AS t'.$k.'';
        		}
        	$missingon = join(" LEFT JOIN ".$this->andor." ", $tablearray);
        	$this->table = $missingon.' ON '.$on;
        } else {
        
        	$this->table = DB_PREFIX.$table;
        }
    }
    
    function jakAndor($andor) 
    { 
        // Set if the search should AND/OR
        $this->andor = '';
        if (isset($andor)) $this->andor = $andor;
        
    }
    
    function jakFieldstoselect($select) 
    { 
        // What fields should we select
        $this->select = '';
        if (isset($select)) $this->select = $select;
    }
    
    function jakFieldtitle($seotitle) 
    { 
        // What fields should we select
        $this->title = '';
        if (isset($seotitle)) $this->title = $seotitle;
        
    }
    
    function jakFieldcontent($content) 
    { 
        // What fields should we select
        $this->content = '';
        if (isset($content)) $this->content = $content;

    }
    
    function jakFieldcut($cutme) 
    { 
        // What fields should we select
        $this->cutme = '';
        if (isset($cutme)) $this->cutme = $cutme;
        
    }
    
    function jakFieldactive($active) 
    { 
        // What fields should we check if this article is active or approved
        $this->active = '';
        if (isset($active)) $this->active = ' AND '.$active.' = 1';
        
    }
    
    function jakFieldid($id) 
    { 
        // What fields should we check if this article is active or approved
        if (isset($id)) $this->id = ' AND '.$id;
        
    }
    
    function jakSearchlimit($limited)
    {
    	// Get the limit for this search
    	$this->limited = '';
    	if (isset($limited)) $this->limited = $limited;

    }
    
    function jakTablegroup($groupme)
    {
    	// Get the groups for this search
    	$this->groupme = '';
    	if (isset($groupme)) $this->groupme = ' GROUP BY '.$groupme;
    }
    
    function jakFieldstosearch($fields) {
    
    	global $jkv;
    	
    	// Check if mysql full text search is enabled
    	if ($jkv["fulltextsearch"]) {
    			
    		$this->fields = 'MATCH('.implode(',', $fields).') AGAINST("'.$this->keyword.'" IN BOOLEAN MODE)'.$this->active;
    	
    	} else {
    	
	    	// Write the where clause
	    	$search = array();
	    	if (isset($fields)) foreach($fields as $f) {
	   			$search[] = 'LOWER('.$f.') LIKE "%'.$this->keyword.'%"';
	   		}
	   		
   			$this->fields = join(" ".$this->andor." ", $search);
   		
   		}
    }
     
    function set_result($plugin, $link, $dseo) {
    
        // do the dirty work in in mysql    
        global $jakdb;
        global $jkv;
        
        $this->found = array();
        
        // Catch the limit if not set, we set it to 10
        if (!isset($this->limited)) $this->limited = 10;
        
        // SQL Querie(s)
        $result = $jakdb->query('SELECT '.$this->select.' FROM '.$this->table.' WHERE '.$this->fields.$this->active.$this->id.$this->groupme.' LIMIT '.$this->limited);
        while ($row = $result->fetch_assoc()) {
        		$wseo = $shorty = $title = '';
        	
        		// cut me $this->cut
        		if (isset($this->content)) $shorty = $row[$this->content];
        		if (isset($this->cutme)) $shorty = jak_cut_text($row[$this->cutme],$jkv["shortmsg"],'...');
            	
            	// Get the title
            	if (isset($this->title)) $title = $row[$this->title];
            	if (isset($row["title"])) $title = $row["title"];
            	
            	// get the title for better seo, if there is a title
            	if ($dseo && $this->title) $wseo = JAK_base::jakCleanurl($title);
       			
       			// Get the url
       			if (isset($row['catorder']) && $row['catorder'] == 1 && isset($row['catparent']) && $row['catparent'] == 0) {
       				$parseurl = BASE_URL;
       			} elseif (isset($row['varname']) && !$plugin && isset($row['id'])) {
       				$parseurl = JAK_rewrite::jakParseurl($row['varname'], $link, $row['id'], $wseo, '');
       			} elseif (isset($row['id']) && isset($plugin)) {
       				$parseurl = JAK_rewrite::jakParseurl($plugin, $link, $row['id'], $wseo, '');
       			} else {
       				$parseurl = '';
       			}
            	
            	if (!empty($parseurl)) $this->found[] = array('parseurl' => $parseurl, 'title' => $title, 'content' => $shorty);
            	 
            }
            
        return $this->found; 
    }
    
    public static function search_cloud($searchterm)
    {
    	
    	global $jakdb;
    	// save the search term into the database for further use
    	$results = $jakdb->query('SELECT id FROM '.DB_PREFIX.'searchlog WHERE tag = "'.$searchterm.'"');
    	if ($jakdb->affected_rows > 0) {
    	    $rows = $results->fetch_assoc();
    	    $jakdb->query('UPDATE '.DB_PREFIX.'searchlog SET count = count + 1 WHERE id = "'.smartsql($rows['id']).'"');
    	} else {
    	    $jakdb->query('INSERT INTO '.DB_PREFIX.'searchlog SET tag = "'.smartsql($searchterm).'", time = NOW()');
    	}
    
    }
}
?>