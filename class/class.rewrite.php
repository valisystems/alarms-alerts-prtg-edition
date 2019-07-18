<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

class JAK_rewrite
{

	private $url_seg;
	private $data = array();
	
	// This constructor can be used for all classes:
	
	public function __construct($url){
			
			$this->url = $url;
	}
	
	function jakGetseg($var) {
	
		if (JAK_USE_APACHE) {
		
			$url = str_replace(_APP_MAIN_DIR, '', $this->url);
			$_tmp = explode('?', $url);
			$url = $_tmp[0];
			
			if ($url = explode('/', $url)) {
			    foreach ($url as $d) {
			        if ($d) {
			            $data[] = $d;
			        }
			    }
			}
			
			if (!empty($data[$var])) $url_seg = $data[$var];
		
		} else {
	
			// get the url and parse it
			$parseurl = parse_url($this->url);
			
			// get only the query
			$parameters = $parseurl["query"];
			parse_str($parameters, $data);
			
			// Now we have to set the array to basic keys
			if (!empty($data)) foreach($data as $d) {
				$data[] = $d;
			}
		
			if (!empty($data[$var])) $url_seg = $data[$var];
		}
		
		if (!empty($url_seg)) return $url_seg;
	}
	
	public function jakGetsegAdmin($var)
	{
	
			// get the url and parse it
			$parseurl = parse_url($this->url);
			
			if (!empty($parseurl["query"])) {
				// get only the query
				$parameters = $parseurl["query"];
				parse_str($parameters, $data);
				
				// Now we have to set the array to basic keys
				foreach($data as $d) {
					$data[] = $d;
				}
				
				if (!empty($data[$var])) return $data[$var];
		
			}
	}
	
	public static function jakParseurl($var, $var1 = '', $var2 = '', $var3 = '', $var4 = '', $var5 = '')
	{
	
		// Set v to zero
		$v = $v1 = $v2 = $v3 = $v4 = $v5 = '';
		
		// Check if is/not apache and create url
		if (!JAK_USE_APACHE) {
				
			if ($var1) {
				$v = '&amp;sp='.htmlspecialchars($var1);
			}
			if ($var2) {
				$v1 = '&amp;ssp='.htmlspecialchars($var2);
			}
			if ($var3) {
				$v2 = '&amp;sssp='.htmlspecialchars($var3);
			}
			
			if ($var4) {
				$v3 = '&amp;ssssp='.htmlspecialchars($var4);
			}
			
			if ($var5) {
				$v4 = '&amp;sssssp='.htmlspecialchars($var5);
			}
			
			// if not apache add some stuff to the url
			if ($var) {
				$var = 'index.php?p='.htmlspecialchars($var);
			} else {
				$var = '/';
			}
			
			// Now se the var for none apache
			$varname = $var.$v.$v1.$v2.$v3.$v4;
		
		} else {
					
			if ($var1) {
				$v = '/'.$var1;
			}
			if ($var2) {
				$v1 = '/'.$var2;
			}
			if ($var3) {
				$v2 = '/'.$var3;
			}
			if ($var4) {
				$v3 = '/'.$var4;
			}
			if ($var5) {
				$v4 = '/'.$var5;
			}
			
			// if not apache add some stuff to the url
			$var = $var;
				
			// Now se the var for none apache
			$varname = '/'.htmlspecialchars($var.$v.$v1.$v2.$v3.$v4);
				
		}
		
		if (!empty($varname)) return $varname;
		
	}
	
	public static function jakParseurlpaginate($var) {
	
		$varname = '';
		
		if ($var != 1) {
			// Check if is/not apache and create url
			if (!JAK_USE_APACHE && $var) {
				// Now se the var for none apache
				$varname = '&amp;page='.$var;
			} elseif (JAK_PAGINATE_ADMIN) {
				// Now se the var for admin
				$varname = '&amp;page='.$var;
			} else {
				// Now se the var for seo apache
				$varname = '/'.$var;
			}
		}
		
		return $varname;
	
	}
	
	public function jakRealrequest() {
		$r = str_replace(_APP_MAIN_DIR, '', $this->url);
		return $r;
	}
	
	public static function jakVideourlparser($url, $where)
	{
		
		// Parse URL
		$purl = parse_url($url);
		
		// Find host
		$host = $purl['host'];
		
		// Check if youtube
		if ($host == 'www.youtube.com') {
		
			if (preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $url, $match)) {
			$vid = $match[1];
			
				if ($where == 'admin') {
					return 'http://www.youtube.com/v/'.$vid;
				} else {
					return 'http://www.youtube.com/embed/'.$vid;
				}
			
			} else {
				
				return $url;
			}
		
		// Check the new video url	
		} else if ($host == 'youtu.be') {
		
			if (preg_match('/http:\/\/youtu\.be\/(.*)/i', $url, $match)) {
			$vid = $match[1];
			
				if ($where == 'admin') {
					return 'http://www.youtube.com/v/'.$vid;
				} else {
					return 'http://www.youtube.com/embed/'.$vid;
				}
			
			} else {
				
				return $url;
			}
		
		// Check if Vimeo
		} else if ($host == 'vimeo.com' || $host == 'www.vimeo.com') {
		
			if (preg_match('~^http://(?:www\.)?vimeo\.com/(?:clip:)?(\d+)~', $url, $match)) {
			$vid = $match[1];
			
				if ($where == 'admin') {
					return 'http://vimeo.com/moogaloop.swf?clip_id='.$vid;
				} else {
					return 'http://player.vimeo.com/video/'.$vid.'?portrait=0';
				}
			
			} else {
				
				return $url;
			}
		
		// Nothing just return the url    
		} else {
		
			return $url;
			
		}
		
	}
}
?>