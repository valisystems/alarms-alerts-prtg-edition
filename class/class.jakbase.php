<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

include_once 'class.rewrite.php';

class JAK_base
{
	private $data = array();
	private $usraccesspl = array();
	private $case;
	private $jakvar;
	private $jakvar1;
	protected $table = '', $itemid = '', $select = '', $where = '', $dseo = '';
	
	// This constructor can be used for all classes:
	
	public function __construct(array $options){
			
			foreach($options as $k=>$v){
				if(isset($this->$k)){
					$this->$k = $v;
				}
			}
	}
	
	public static function jakCleanurl($str, $options = array()) {
			
			$defaults = array(
				'delimiter' => '-',
				'limit' => null,
				'lowercase' => true,
				'replacements' => array(),
				'transliterate' => true,
			);
			
			// Merge options
			$options = array_merge($defaults, $options);
			
			$char_map = array(
				// Latin
				'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C', 
				'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 
				'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O', 
				'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH', 
				'ß' => 'ss', 
				'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c', 
				'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 
				'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o', 
				'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th', 
				'ÿ' => 'y',
		
				// Latin symbols
				'©' => '(c)',
		
				// Greek
				'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
				'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
				'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
				'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
				'Ϋ' => 'Y',
				'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
				'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
				'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
				'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
				'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',
		
				// Turkish
				'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
				'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g', 
		
				// Russian
				'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
				'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
				'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
				'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
				'Я' => 'Ya',
				'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
				'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
				'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
				'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
				'я' => 'ya',
		
				// Ukrainian
				'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
				'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
		
				// Czech
				'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U', 
				'Ž' => 'Z', 
				'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
				'ž' => 'z', 
		
				// Polish
				'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z', 
				'Ż' => 'Z', 
				'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
				'ż' => 'z',
		
				// Latvian
				'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N', 
				'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
				'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
				'š' => 's', 'ū' => 'u', 'ž' => 'z'
			);
			
			// Make custom replacements
			if (!empty($options['replacements'])) {
				$str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
			}
			
			// Transliterate characters to ASCII
			if ($options['transliterate']) {
				$str = str_replace(array_keys($char_map), $char_map, $str);
			}
			
			// Replace non-alphanumeric characters with our delimiter
			$str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
			
			// Remove duplicate delimiters
			$str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);
			
			// Truncate slug to max. characters
			$str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');
			
			// Remove delimiter from ends
			$str = trim($str, $options['delimiter']);
			
			return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
	
	}
	
	public static function jakunCleanurl($jakvar) {
	
		$jakvar = strip_tags($jakvar);
		$jakvar = strtolower($jakvar);
		$crepl = array("ä","ö","ü","Ä","Ü","Ö","é","à","è","ô");
		$cfin = array('au','oe','ue','au','oe','ue','e','a','e','o');
		$jakvar = str_replace($cfin, $crepl, $jakvar);	
		return $jakvar;
	
	}
	
	public static function pluralize($count, $text, $plural) { 
	    return $count . ( ( $count == 1 ) ? ( " $text" ) : ( " ${plural}" ) );
	}
	
	public static function jakTimesince($mysqlstamp, $date, $time, $lang) {
		
		global $jkv;
		
		$today = time(); /* Current unix time  */
		$unixtime = strtotime($mysqlstamp);
		$since = $today - $unixtime;
	
		if ($jkv["time_ago_show"] && $since < 900000) {
		
			$lang = explode(",", $lang);
			// Parse custom date format similar to original question
			$replydate = new DateTime($mysqlstamp);
			
			// Calculate DateInterval (www.php.net/manual/en/class.dateinterval.php)
			$diff = $replydate->diff(new DateTime());
			
			if ($diff->m >= 1) {
				return date($date.$time, $mysqlstamp);
			}
			
			    if ($v = $diff->d >= 1) {
			    	$timeago = JAK_base::pluralize($diff->d, $lang[0], $lang[4]);
			    } elseif ($v = $diff->h >= 1) {
			    	$timeago = JAK_base::pluralize($diff->h, $lang[1], $lang[5]);
			    } elseif ($v = $diff->i >= 1) {
			   		$timeago = JAK_base::pluralize($diff->i, $lang[2], $lang[6]);
			   	} else {
			    	$timeago = JAK_base::pluralize($diff->s, $lang[3], $lang[7]);
			    }
			    
			return sprintf($lang[8],$timeago);
		
		} else {
			return date($date.$time, $unixtime);
		}
	
	}
	
	public static function jakGetallcategories() {
		
		global $jakdb;
		$result = $jakdb->query('SELECT id, name, varname, exturl, catimg, content, showmenu, showfooter, catparent, catorder, pageid, activeplugin, permission, pluginid FROM '.DB_PREFIX.'categories WHERE ((pageid > 0 AND activeplugin = 1) OR (pageid = 0 AND pluginid > 0) OR (exturl != "" AND pageid = 0 AND pluginid = 0)) ORDER BY catorder ASC');
		
		while ($row = $result->fetch_assoc()) {
		
			$permission = explode(',', $row['permission']);
			
			if (in_array(JAK_USERGROUPID, $permission) || $row['permission'] == 0) {
			
				if ($row['catorder'] == 1 && $row['showmenu'] == 1 && $row['catparent'] == 0) {
					$parseurl = JAK_rewrite::jakParseurl('', '', '', '', '');
				} else if ($row['varname'] && !$row['exturl']) {
					$parseurl = JAK_rewrite::jakParseurl($row['varname'], '', '', '', '');
				} else if ($row['exturl']) {
					$parseurl = $row['exturl'];
				} else {
					$parseurl = JAK_rewrite::jakParseurl('', '', '', '', '');
				}
					
				$jakdata[] = array('id' => $row['id'], 'name' => $row['name'], 'varname' => $parseurl, 'pagename' => $row['varname'], 'content' => $row['content'], 'showmenu' => $row['showmenu'], 'showfooter' => $row['showfooter'], 'catorder' => $row['catorder'], 'catimg' => $row['catimg'], 'catparent' => $row['catparent'], 'activeplugin' => $row['activeplugin'], 'pluginid' => $row['pluginid'], 'pageid' => $row['pageid']);
		    }
		    
		}
		    
		return $jakdata;
		
	}
	
	public static function jakGetcatmix($where, $where1, $table, $usergroup, $dseo) {
		
		$jakdata = array();
		global $jakdb;
		$result = $jakdb->query('SELECT * FROM '.$table.' WHERE active = 1 ORDER BY catorder ASC');
		while ($row = $result->fetch_assoc()) {
		
			if (jak_get_access($usergroup, $row['permission']) || $row['permission'] == 0) {
				
				// There should be always a varname in categories and check if seo is valid
				$seo = '';
				if ($dseo) {
					$seo = $row['varname'];
				}
				
				$row['parseurl'] = JAK_rewrite::jakParseurl($where, 'c', $row['id'], $seo, '');
				
				if ($where1) {
					$row['parseurl1'] = JAK_rewrite::jakParseurl($where1, $where, $row['id'], '', '');
				}
				
				// collect each record into $jakdata
				$jakdata[] = $row;
				
			}
		}      
		      
		  return $jakdata;
	}
	
	public static function jakCatdisplay($jakvar, $usraccesspl, $catarray) {
	
		$case = array();
		if (isset($catarray) && !empty($catarray)) foreach($catarray as $c) {
			if ($c['pluginid'] == 0 || in_array($c['pluginid'], $usraccesspl))
				$case[] = $c;
		}
		
		return $case;
	
	}
	
	public static function jakCatpluginvar($id, $catarray) {
	
		$getc = $catarray;
		
		foreach($getc as $c)
		{
			if ($c['id'] == $id)
				$case = $c['pagename'];
				
		}
		
		return $case;
	
	}
	
	public static function jakUpdatehits($jakvar,$jakvar1) {
		
		global $jakdb;
		$result = $jakdb->query('UPDATE '.$jakvar1.' SET hits = hits + 1 WHERE id = "'.smartsql($jakvar).'"');
	
	}
	
	public static function jakSessiontimelimit() {
		
		// Start the session
		session_start();
		
		// Set new after 10 minutes
		$inactive = 600;
		
		// check to see if $_SESSION['timeout'] is set
		if(isset($_SESSION['timeout']) ) {
			$session_life = time() - $_SESSION['timeout'];
			
			if($session_life > $inactive) { 
				
				$loadnew = false;
				
				// Write the session timeout new, because the 10 minutes are over
				$_SESSION['timeout'] = time();
			} else {
				
				$loadnew = true;
			} 
		} else {
		
			// Write the session timeout new
			$_SESSION['timeout'] = time();
		
		}
		
		return $loadnew;
	}
	
	public static function jakCheckprotectedArea($pass, $table, $id) {
	
		global $jakdb;
		$jakdb->query('SELECT id FROM '.DB_PREFIX.$table.' WHERE password = "'.$pass.'" AND id = '.$id.' AND active = 1');
		if ($jakdb->affected_rows > 0) {
			return true;
		} else {
			return false;
		}
			
	}

}
?>