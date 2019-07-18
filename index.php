<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// prevent direct php access
define('JAK_PREVENT_ACCESS', 1);

if (!file_exists('config.php')) die('[index.php] config.php not exist');
require_once 'config.php';

// Now check if there is more then one language
$page = ($tempp ? jak_input_filter($tempp) : '');
$page1 = ($tempp1 ? jak_input_filter($tempp1) : '');
$page2 = ($tempp2 ? jak_input_filter($tempp2) : '');
$page3 = ($tempp3 ? jak_input_filter($tempp3) : '');
$page4 = ($tempp4 ? jak_input_filter($tempp4) : '');
$page5 = ($tempp5 ? jak_input_filter($tempp5) : '');
$page6 = ($tempp5 ? jak_input_filter($tempp6) : '');

// Import the language file
if ($jkv["lang"] != $site_language && file_exists(APP_PATH.'admin/lang/'.$site_language.'.ini')) {
    $tl = parse_ini_file(APP_PATH.'lang/'.$site_language.'.ini', true);
} else {
    $tl = parse_ini_file(APP_PATH.'lang/'.$jkv["lang"].'.ini', true);
}

// If Referer Zero go to the session url
if (!isset($_SERVER['HTTP_REFERER'])) {
	if (isset($_SESSION['jak_lastURL'])) {
    	$_SERVER['HTTP_REFERER'] = $_SESSION['jak_lastURL'];
    } else {
    	$_SERVER['HTTP_REFERER'] = BASE_URL;
    }
}

// Assign Pages to template
define('JAK_PAGINATE_ADMIN', 0);

// Parse stuff we use more then once
define('JAK_PARSE_ERROR', html_entity_decode(JAK_rewrite::jakParseurl('error', 'mysql', '', '', '')));
define('JAK_PARSE_SUCCESS', html_entity_decode(JAK_rewrite::jakParseurl('success', '', '', '', '')));

// First load the language from the hook
$hooklang = $jakhooks->jakGethook("php_lang");
if ($hooklang) foreach($hooklang as $hlang)
{
	eval($hlang['phpcode']);
}

// Call the hooks per name
$JAK_HOOK_HEAD_TOP = $jakhooks->jakGethook("tpl_between_head");
$JAK_HOOK_BODY_TOP = $jakhooks->jakGethook("tpl_body_top");
$JAK_HOOK_HEADER = $jakhooks->jakGethook("tpl_header");
$JAK_HOOK_BELOW_HEADER = $jakhooks->jakGethook("tpl_below_header");
$JAK_HOOK_PAGE = $jakhooks->jakGethook("tpl_page");
$JAK_HOOK_SIDEBAR = $jakhooks->jakGethook("tpl_sidebar");
$JAK_HOOK_BELOW_CONTENT = $jakhooks->jakGethook("tpl_below_content");
$JAK_HOOK_FOOTER = $jakhooks->jakGethook("tpl_footer");
$JAK_HOOK_FOOTER_WIDGET = $jakhooks->jakGethook("tpl_footer_widgets");
$JAK_HOOK_FOOTER_END = $jakhooks->jakGethook("tpl_footer_end");

// Get the php hook for index top
$indexhook = $jakhooks->jakGethook("php_index_top");
if ($indexhook) { foreach($indexhook as $it) {
	eval($it['phpcode']);
}
}

// Define the avatarpath in the settings
define('JAK_USERRPATH_BASE', BASE_URL.JAK_FILES_DIRECTORY.'/userfiles');

// User is logged in #else not
if (JAK_USERID) {
	define('JAK_USERGROUPID', $jakuser->getVar("usergroupid"));
	$JAK_USERNAME_LINK = strtolower($jakuser->getVar("username"));
	$JAK_USERNAME = $jakuser->getVar("username");
    $P_USR_LOGOUT = JAK_rewrite::jakParseurl('logout', '', '', '', '');
    // Get the avatar for once
    $JAK_USER_AVATAR = JAK_USERRPATH_BASE.$jakuser->getVar("picture");
    
    // does the user have admin access
    if ($jakuser->jakAdminaccess($jakuser->getVar("usergroupid"))) {
    	define('JAK_ASACCESS', true);
    } else {
    	define('JAK_ASACCESS', false);
    }
    
} else {
	define('JAK_USERGROUPID', 1);
	$JAK_USERNAME = false;
	define('JAK_ASACCESS', false);
	
}

// Pagination/Date/template/plugin reset
$JAK_PAGINATE = $SHOWDATE = $apedit = $qapedit = $printme = $keylist = $seop = $seo = $seoc = $USR_CAN_RATE = $JAK_HEADER_CSS = $JAK_SEARCH_LINK = $JAK_ADD_MENU_SB = $JAK_HOOK_SIDE_GRID = $JAK_UFORM_EXTRA = $JAK_HEATMAPLOC = $PAGE_TITLE = $PAGE_CONTENT = $PAGE_KEYWORDS = $PAGE_DESCRIPTION = $P_RSS_LINK = $JAK_TPL_PLUG_T = $JAK_TPL_PLUG_URL = false;

// Errors, Seo
$errors = $seokeywords = $usraccesspl = array();

// RSS
$JAK_RSS_DISPLAY = 0;

// Reset Prev/Next
$JAK_NAV_NEXT = $JAK_NAV_NEXT_TITLE = $JAK_NAV_PREV = $JAK_NAV_PREV_TITLE = $JAK_PAGE_OFFLINE = false;

// Something that needs to be true by standard
$JAK_SHOW_NAVBAR = $JAK_SHOW_FOOTER = $newsloadonce = true;

// Include post functionality
include_once 'include/loginpass.php';

// Current session for template
define('CUR_SESSION', session_id());

// Include contact post file if needed.
if ($jkv["contactform"]) include_once 'include/contact.php';

if ($jkv["robots"] == 0) {
	$jk_robots = 'index, nofollow';
} else {
	$jk_robots = 'index, follow';
}
define('JAK_TEMPLATE', $jkv["sitestyle"]);
define('JAK_SEARCH', $jkv["searchform"]);
define('JAK_CONTACT_FORM', $jkv["contactform"]);

// Get all the active categories available in the db
$jakcategories = JAK_base::jakGetallcategories();

// Let's check if News are active
define('JAK_NEWS_ACTIVE', $jakplugins->getPHPcodeid(1, "active"));

// Now check if tags/ads are active, this is global, if you don't use tags, you will safe a lot of queries
define('JAK_TAGS', $jakplugins->getPHPcodeid(3, "active"));
// if Tags are active
if (JAK_TAGS) {
	// Get the tag before all others, because of the url
	define('JAK_USER_TAGS', $jakusergroup->getVar("tags"));
} else {
	// Get the tag before all others, because of the url
	define('JAK_USER_TAGS', 0);
}

// User can use search and use tags
define('JAK_USER_SEARCH', $jakusergroup->getVar("advsearch"));

// Get the users ip address
$ipa = get_ip_address();

// Check if the ip or range is blocked, if so redirect to offline page with a message
$USR_IP_BLOCKED = false;
if ($jkv["ip_block"]) {
	$blockedips = explode(',', $jkv["ip_block"]);
	// Do we have a range
	if (is_array($blockedips)) foreach ($blockedips as $bip) {
		$blockedrange = explode(':', $bip);
		
		$remote = ip2long($ipa);
		
		if (!empty($blockedrange) && is_array($blockedrange) && isset($blockedrange[0]) && isset($blockedrange[1])) {
		
			$network = ip2long($blockedrange[0]);
			$mask = ip2long($blockedrange[1]);
			
			if (($remote & $mask) == $network) {
			    $USR_IP_BLOCKED = $tl['error']['e22'];
			}	
		}
		
		// Check if we have single IP's
		if ($remote == $bip) {
		    $USR_IP_BLOCKED = $tl['error']['e22'];
		}
		
	}
	// Now let's check if we have another match
	if (in_array($ipa, $blockedips)) {
		$USR_IP_BLOCKED = $tl['error']['e22'];
	}
}

// Finally get the captcha if wish so
if ($jkv["hvm"]) {
	
	if (isset($_SESSION['jak_captcha'])) {
		
		$human_captcha = explode(':#:', $_SESSION['jak_captcha']);
		
		$random_name = $human_captcha[0];
		$random_value = $human_captcha[1];

	} else {
		
		$random_name = rand();
		$random_value = rand();
		
		$_SESSION['jak_captcha'] = $random_name.':#:'.$random_value;
		
	}

}

// If the site is set to offline, well go there... :)
if ($jkv["offline"] == 1 && !JAK_ASACCESS || $USR_IP_BLOCKED) {
$JAK_PAGE_OFFLINE = true;
	if ($jkv["offline_page"]) {
		foreach($jakcategories as $ca) {
			if ($ca['id'] == $jkv["offline_page"] && !empty($ca['pageid'])) {
				$offlinepage = $ca['pageid'];
				break;
			}
		}
	} else {
		$page = 'offline';
	}
}

// Now get all defines out from the plugins before we start with pages
foreach($jakcategories as $ca) {

	if (!empty($ca['pluginid'])) {
		
		// Get the array first so we can use it in the plugins
		if ($jakusergroup->getVar($jakplugins->getPHPcodeid($ca['pluginid'], "usergroup")) == 1 || $jakplugins->getPHPcodeid($ca['pluginid'], "usergroup") == 1) {
			$usraccesspl[] = $jakplugins->getPHPcodeid($ca['pluginid'], "id");
		}
			
		$plugName = strtoupper($jakplugins->getPHPcodeid($ca['pluginid'],"name"));
			
		// Define the varname for further use
		define('JAK_PLUGIN_VAR_'.$plugName, $ca['pagename']);
			
		// Define the id for further use
		define('JAK_PLUGIN_ID_'.$plugName, $jakplugins->getPHPcodeid($ca['pluginid'], "id"));
			
		// Define the name for further use
		define('JAK_PLUGIN_NAME_'.$plugName, $ca['name']);
			
		// Define the access for further use
		if ($jakplugins->getPHPcodeid($ca['pluginid'], "usergroup") == 1) {
			define('JAK_PLUGIN_ACCESS_'.$plugName, $jakplugins->getPHPcodeid($ca['pluginid'], "usergroup"));
		} else {
			define('JAK_PLUGIN_ACCESS_'.$plugName, $jakusergroup->getVar($jakplugins->getPHPcodeid($ca['pluginid'], "usergroup")));
		}
		
	}
}

// Set the check page to 0
$JAK_CHECK_PAGE = 0;

	// Include all the pages
	foreach($jakcategories as $ca) {
	
		if ($ca['pluginid'] == 0 || $JAK_PAGE_OFFLINE && isset($offlinepage)) {
				
			if ((empty($page) && $ca['catorder'] == 1 && $ca['catparent'] == 0 && $ca['showmenu'] == 1) || ($page == $ca['pagename'])) {
				
				// What information should we load
				if ($JAK_PAGE_OFFLINE && isset($offlinepage)) {
					$pageid = $offlinepage;
				} elseif ($ca['pageid'] > 0) {
					$pageid = $ca['pageid'];
				} else	{
					jak_redirect(JAK_rewrite::jakParseurl('404', '', '', '', ''));
				}
				
				// Include the page php file	
				require_once 'page.php';
				$JAK_CHECK_PAGE = 1;
								   	
				// Get the rss if active
				if ($jkv["rss"]) {
				   	$JAK_RSS_DISPLAY = 1;
				   	$P_RSS_LINK = JAK_rewrite::jakParseurl('rss.xml', '', '', '', '');
				}
				break;
			}
		}

		// Call the plugins if page is not the one
		if ($ca['pluginid'] > 0 && ($jakusergroup->getVar($jakplugins->getPHPcodeid($ca['pluginid'], "usergroup")) == 1 || $jakplugins->getPHPcodeid($ca['pluginid'], "usergroup") == 1)) {
				
			if ((!$page && $ca['catorder'] == 1 && $ca['showmenu'] == 1) || ($page == $ca['pagename'])) {
					
				// include the php site
				eval($jakplugins->getPHPcodeid($ca['pluginid'],"phpcode"));
					
				// Page exist please go on
				$JAK_CHECK_PAGE = 1;
				
				// Load standard if nothing has been found
				if (!$page && $ca['catorder'] == 1) $page = $ca['pagename'];
				break;
					
			}
		}
	}
	
     // Logout
     if ($page == 'logout') {
     	if (!JAK_USERID) {
     		$_SESSION["errormsg"] = $tl["errorpage"]["sql"];
     	    jak_redirect(BASE_URL);
     	}
         if (JAK_USERID) {
             $jakuserlogin->jakLogout(JAK_USERID);
             $_SESSION["infomsg"] = $tl["general"]["s"];
             jak_redirect($_SERVER['HTTP_REFERER']);
         }
     }
    
    // Search
    if ($page == 'search') {
     	if (!$jkv["searchform"] || !JAK_USER_SEARCH) {
     	    jak_redirect(BASE_URL);
     	}
     	// Get the url session
     	$_SESSION['jak_lastURL'] = JAK_rewrite::jakParseurl('search', '', '', '', '');
        require_once 'search.php';
        $PAGE_SHOWTITLE = 1;
        $JAK_CHECK_PAGE = 1;
    }
    // Get the success page
    if ($page == 'success') {
    	$PAGE_TITLE = $tl['general']['s'].' ';
        $template = 'success.php';
        $JAK_CHECK_PAGE = 1;
        $PAGE_SHOWTITLE = 1;
    }
    // Get the error page
    if ($page == 'error') {
    	$PAGE_TITLE = $tl['title']['t12'].' ';
    	$PAGE_CONTENT = $tl['errorpage']['not'];
        $template = 'standard.php';
        $JAK_CHECK_PAGE = 1;
        $PAGE_SHOWTITLE = 1;
    }
    // Get the rss feautures
    if ($page == 'rss.xml') {
    	require_once 'rss.php';
        $JAK_CHECK_PAGE = 1;
    }
   	// Get the 404 page
   	if ($page == '404') {
   		if ($jkv["notfound_page"] != 0) {
   			foreach($jakcategories as $ca) {
   				if ($ca['id'] == $jkv["notfound_page"] && !empty($ca['pageid'])) {
   					$pageid = $ca['pageid'];
   					break;
   				}
   			}
   			// Include the page php file	
   			require_once 'page.php';
   		} else {
   	    	$PAGE_TITLE = '404 '.$tl['error']['e4'];
   	    	$template = '404.php';
   	    }
   	    $JAK_CHECK_PAGE = 1;
   	    $PAGE_SHOWTITLE = 1;
   	}
   	// offline
   	if ($page == 'offline') {
   		$PAGE_TITLE = $tl['title']['t10'].' ';
   	   	$template = 'offline.php';
   	    $JAK_CHECK_PAGE = 1;
   	    $PAGE_SHOWTITLE = 1;
   	}
   	
   	// forgot password
   	if ($page == 'forgot-password') {
   	
   		if (JAK_USERID || !is_numeric($page1) || !$jakuserlogin->jakForgotactive($page1)) jak_redirect(BASE_URL);
   		
   		// Check the forgot code
   		$row = $jakdb->queryRow('SELECT id, name, email FROM '.DB_PREFIX.'user WHERE forgot = "'.smartsql($page1).'" LIMIT 1');
   		
   		$password = jak_password_creator();
   		$passcrypt = hash_hmac('sha256', $password, DB_PASS_HASH);
   		
   		$result = $jakdb->query('UPDATE '.DB_PREFIX.'user SET 
   		password = "'.smartsql($passcrypt).'"
   		WHERE id = "'.smartsql($row["id"]).'"');
   		
   		if (!$result) {
   			
   			$_SESSION["errormsg"] = $tl["errorpage"]["sql"];
   			// redirect back to home
   			jak_redirect(BASE_URL);
   			   
   		} else {
   		
   			$body = sprintf($tl['login']['l20'], $row["name"], $password, $jkv["title"]);
   		
   			$mail = new PHPMailer(); // defaults to using php "mail()"
   			$mail->SetFrom($jkv["email"], $jkv["title"]);
   			$mail->AddAddress($row["email"], $row["name"]);
   			$mail->Subject = $jkv["title"].' - '.$tl['login']['l19'];
   			$mail->MsgHTML($body);
   			$mail->AltBody = strip_tags($body);
   			
   			if ($mail->Send()) {
   				$_SESSION["infomsg"] = $tl["login"]["l21"];
   				jak_redirect(BASE_URL);  	
   			}
   			
   		}
   		
   		$_SESSION["errormsg"] = $tl["errorpage"]["sql"];
   		jak_redirect(BASE_URL);
   	}
   	
// Get the php hook for index page
$hookip = $jakhooks->jakGethook("php_index_page");
if ($hookip) foreach($hookip as $hip) {
	eval($hip['phpcode']);
}

// if page not found 404
if ($JAK_CHECK_PAGE == 0) jak_redirect(JAK_rewrite::jakParseurl('404', '', '', '', ''));

// Get the categories with usergroup rights
$JAK_CAT_SITE = JAK_base::jakCatdisplay(JAK_USERGROUPID, $usraccesspl, $jakcategories);

// Get the header navigation
$mheader = array(
    'items' => array(),
    'parents' => array()
);
// Builds the array lists with data from the menu table
foreach ($JAK_CAT_SITE as $items) {
	
	if ($items["showmenu"] == 1 OR ($items["showmenu"] == 1 && $items["showfooter"] == 1)) {
		// Creates entry into items array with current menu item id ie. $menu['items'][1]
	    $mheader['items'][$items['id']] = $items;
	    // Creates entry into parents array. Parents array contains a list of all items with children
	    $mheader['parents'][$items['catparent']][] = $items['id'];
	}
}

// Get the footer navigation
$mfooter = array(
    'items' => array(),
    'parents' => array()
);
// Builds the array lists with data from the menu table
foreach ($JAK_CAT_SITE as $itemf) {
	
	if ($itemf["showfooter"] == 1) {
		// Creates entry into items array with current menu item id ie. $menu['items'][1]
	    $mfooter['items'][$itemf['id']] = $itemf;
	    // Creates entry into parents array. Parents array contains a list of all items with children
	    $mfooter['parents'][$itemf['catparent']][] = $itemf['id'];
	}
}

// Get News out the database, if not already in the page
if (JAK_NEWS_ACTIVE && $newsloadonce && $jkv["shownews"]) {
	$JAK_GET_NEWS_SORTED = jak_get_news('LIMIT '.$jkv["shownews"], '', JAK_PLUGIN_VAR_NEWS, 'ASC', $jkv["newsdateformat"], $jkv["newstimeformat"], $tl['general']['g56']);
}

// We have tags
if (JAK_TAGS) $JAK_GET_TAG_CLOUD = JAK_tags::jakGettagcloud(JAK_PLUGIN_VAR_TAGS, 'tagcloud', $jkv["taglimit"], $jkv["tagmaxfont"], $jkv["tagminfont"]);

// SEARCH, NEWS and Mobile/Web LINK
$P_SEAERCH_LINK = JAK_rewrite::jakParseurl('search', '', '', '', '');
if (JAK_NEWS_ACTIVE) $P_NEWS_LINK = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_NEWS, '', '', '', '');

// Get the php hook for index bottom
$hookib = $jakhooks->jakGethook("php_index_bottom");
if ($hookib) foreach($hookib as $hib) {
	eval($hib['phpcode']);
}

// Should we show the date
if ($SHOWDATE == '1') define('SHOWDATE', 1);
    
// Check if there is tag and the user can see it
if (!JAK_TAGS && !JAK_USER_TAGS) $JAK_TAGLIST = false;

// Get the template normal or mobile
if (isset($jkv["sitestyle"]) && !empty($jkv["sitestyle"]) && isset($template) && $template != '') {
	include_once APP_PATH.'template/'.$jkv["sitestyle"].'/'.$template;
// Get the plugin template	
} elseif (isset($plugin_template) && $plugin_template != '') {
	include_once APP_PATH.$plugin_template;
// No template available
} else {
	include_once APP_PATH.'notemplate.html';
}

// Reset success and errors session for next use
unset($_SESSION["successmsg"]);
unset($_SESSION["errormsg"]);
unset($_SESSION["infomsg"]);

// Finally close all db connections
$jakdb->jak_close();
?>