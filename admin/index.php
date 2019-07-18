<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// prevent direct php access
define('JAK_ADMIN_PREVENT_ACCESS', 1);

// Access not allowed
$JAK_PROVED = false;

if (!file_exists('config.php')) die('[index.php] config.php not found');
require_once 'config.php';

// Now check if there is more then one language
$page = ($temppa ? jak_input_filter($temppa) : '');
$page1 = ($temppa1 ? jak_input_filter($temppa1) : '');
$page2 = ($temppa2 ? jak_input_filter($temppa2) : '');
$page3 = ($temppa3 ? jak_input_filter($temppa3) : '');
$page4 = ($temppa4 ? jak_input_filter($temppa4) : '');
$page5 = ($temppa5 ? jak_input_filter($temppa5) : '');
$page6 = ($temppa5 ? jak_input_filter($temppa6) : '');

// Only the SuperAdmin in the config file see everything
if (JAK_USERID && $jakuser->jakSuperadminaccess(JAK_USERID)) {
	define('JAK_SUPERADMINACCESS', true);
} else {
	define('JAK_SUPERADMINACCESS', false);
}

// Get the redirect into a sessions for better login handler
if ($page && $page != '404') $_SESSION['JAKRedirect'] = $_SERVER['REQUEST_URI'];

// All other user will be redirect to the homepage, nothing else to do for this people
if (JAK_USERID && !JAK_ADMINACCESS) jak_redirect(BASE_URL_ORIG);

if ($jkv["lang"] != $site_language && file_exists(APP_PATH.'admin/lang/'.$site_language.'.ini')) {
    $tl = parse_ini_file(APP_PATH.'admin/lang/'.$site_language.'.ini', true);
} else {
    $tl = parse_ini_file(APP_PATH.'admin/lang/'.$jkv["lang"].'.ini', true);
    $site_language = $jkv["lang"];
}

// We need the template folder, title, author and lang as template variable
$JAK_CONTACT_FORM = $jkv["contactform"];
define('JAK_PAGINATE_ADMIN', 1);

// First check if the user is logged in
if (JAK_USERID) {

	// Get all the Plugins
	$jakplugins = new JAK_plugins(2, '');
	
	// Get all the Hooks
	$jakhooks = new JAK_hooks(1, '');
	
	// First load the language from the hook
	$hookadminlang = $jakhooks->jakGethook("php_admin_lang");
	if ($hookadminlang) foreach($hookadminlang as $halang) {
		eval($halang['phpcode']);
	}
	
	// Get the admin head hook for implementing css or other stuff belongs into the head section
	$JAK_HOOK_HEAD_ADMIN = $jakhooks->jakGethook("tpl_admin_head");
	$JAK_HOOK_FOOTER_ADMIN = $jakhooks->jakGethook("tpl_admin_footer");
	
	// Get all plugins out the databse
	$JAK_PLUGINS = $jakplugins->jakGetarray();
	$JAK_PLUGINS_TOPNAV = $jakplugins->jakAdmintopnav();
	$JAK_PLUGINS_MANAGENAV = $jakplugins->jakAdminmanagenav();
	// We need the tags if active right in the beginning
	define('JAK_TAGS', $jakplugins->getPHPcodeid(3, "active"));
	
	// Show links in template only the user have access
	$JAK_MODULES = $jakuser->jakModuleaccess(JAK_USERID, $jkv["accessgeneral"]);
	$JAK_MODULEM = $jakuser->jakModuleaccess(JAK_USERID, $jkv["accessmanage"]);
	
	// Get the name from the user for the welcome message
	$JAK_WELCOME_NAME = $jakuser->getVar("name");
}

// Now get the forgot password link into the right shape
$P_FORGOT_PASS_ADMIN = JAK_rewrite::jakParseurl('forgot', '', '', '', '');

// We do not need code highlighting
$CODE_HIGHLIGHT = $JAK_PAGINATE = false;

// Errors
$errors = array();

// db insert
$insert = $updatesql = $updatesql1 = '';

// Set page to zero, first.
$checkp = 0;

// Define http referrer
if (!isset($_SERVER['HTTP_REFERER'])) $_SERVER['HTTP_REFERER'] = '';

// Now run the php code from the plugin section only when we logged in
if (JAK_USERID) {

	// Run the hook admin index top for sidebar widgets
	// Admin index hook
	$hookadminit = $jakhooks->jakGethook("php_admin_index_top");
	if ($hookadminit) foreach($hookadminit as $hait) {
		eval($hait['phpcode']);
	}
	
	$pluginadminphp = $jakplugins->jakAdminindex();
	if ($pluginadminphp) foreach($pluginadminphp as $pl) {
		// Page name upper case
		$plname = strtoupper($pl['name']);
		
		// define the plugin id first
		define('JAK_PLUGIN_'.$plname, $pl['id']);
		
		// Get the access out into define
		define('JAK_ACCESS'.$plname, $pl['access']);
			
		// then load the php code
		eval($pl['phpcode']);
	}
}

// home
    if ($page == '') {
        #show login page only if the admin is not logged in
        #else show homepage
        if (!JAK_USERID) {
            require_once 'login.php';
        } else {
        	require_once 'include/serverconfig.php';
        	$JAK_SETTING = jak_get_setting('version');
        	$JAK_PROVED = 1;
        	$JAK_PAGE_ACTIVE = 1;
            $html_title = $tl['login']['l'];
                        
        	// Admin index hook
        	$hookadmini = $jakhooks->jakGethook("php_admin_index");
        	if ($hookadmini)
        	foreach($hookadmini as $hai)
        	{
        		eval($hai['phpcode']);
        	}
        	// Admin index template
        	$JAK_HOOK_ADMIN_INDEX = $jakhooks->jakGethook("tpl_admin_index");
        	
        	// Get the to-do list
        	require "../class/class.todo.php";
        	// Select all the todos, ordered by position:
        	$todo = $jakdb->query('SELECT * FROM '.DB_PREFIX.'todo_list ORDER BY `position` ASC');
        	
        	// to-do is an array and get the while
        	$todos = array();
        	while ($rowtd = $todo->fetch_assoc()) {
        		$todos[] = new JAK_ToDo($rowtd);
        	}
        	
        	// Get the stats
        	$JAK_COUNTS = $jakdb->queryRow('SELECT 
        		(SELECT COUNT(*) FROM '.DB_PREFIX.'pages WHERE active = 1) AS pageCtotal,
        		(SELECT COUNT(*) FROM '.DB_PREFIX.'user) AS userCtotal,
        		(SELECT COUNT(*) FROM '.DB_PREFIX.'tags) AS tagsCtotal,
        			(SELECT COUNT(*) FROM '.DB_PREFIX.'plugins) AS pluginCtotal,
        			(SELECT COUNT(*) FROM '.DB_PREFIX.'pluginhooks) AS hookCtotal,
        			(SELECT COUNT(*) FROM '.DB_PREFIX.'searchlog) AS searchClog');
        	
        	// Get the page hits
        	$result = $jakdb->query('SELECT title, hits FROM '.DB_PREFIX.'pages ORDER BY hits DESC LIMIT 10');
        	
        	// Iterate through the rows
        	$totalhits = 0;
        	while ($row = $result->fetch_assoc()) {	
        		
        		$pageCdata[] = "['".$row['title']."', ".$row['hits']."]";
        		$totalhits += $row["hits"];
        	}
        	
        	if ($pageCdata) $pageCdata = join(", ", $pageCdata);
        	
        	// Title and Description
        	$SECTION_TITLE = $tl["menu"]["mh"];
        	$SECTION_DESC = $tl["cmdesc"]["d"];
        	
        	// include the template
        	$template = 'index.php';
        }
        $checkp = 1;
       	}
   if ($page == 'logout') {
        $checkp = 1;
        if (!JAK_USERID) {
            jak_redirect(BASE_URL);
        }
        if (JAK_USERID) {
            $jakuserlogin->jakLogout(JAK_USERID);
            jak_redirect(BASE_URL);
        }
    }
    if ($page == '404') {
        if (!JAK_USERID) {
            jak_redirect(BASE_URL);
        }
        // Go to the 404 Page
        $JAK_PROVED = 1;
        $html_title = '404 / ' . $jkv["title"];
        
        // Title and Description
        $SECTION_TITLE = "404";
        $SECTION_DESC = $jkv["title"];
        
        $template = '404.php';
        $checkp = 1;
    }
    if ($page == 'site') {
        require_once 'site.php';
        $JAK_PROVED = 1;
        $JAK_PAGE_ACTIVE = 1;
        $checkp = 1;
    }
    if ($page == 'logs') {
        require_once 'logs.php';
        $JAK_PROVED = 1;
        $JAK_PAGE_ACTIVE = 1;
        $checkp = 1;
    }
    if ($page == 'searchlog') {
        require_once 'searchlog.php';
        $JAK_PROVED = 1;
        $JAK_PAGE_ACTIVE = 1;
        $checkp = 1;
    }
    if ($page == 'setting') {
        require_once 'setting.php';
        $JAK_PROVED = 1;
        $JAK_PAGE_ACTIVE = 1;
        $checkp = 1;
    } 
    if ($page == 'user') {
        require_once 'user.php';
        $JAK_PROVED = 1;
        $JAK_PAGE_ACTIVE = 1;
        $checkp = 1;
    }
    if ($page == 'categories') {
        require_once 'categories.php';
        $JAK_PROVED = 1;
        $JAK_PAGE_ACTIVE1 = 1;
        $checkp = 1;
    }     
    if ($page == 'page') {
        require_once 'page.php';
        $JAK_PROVED = 1;
        $JAK_PAGE_ACTIVE1 = 1;
        $checkp = 1;
    }
    if ($page == 'contactform') {
        require_once 'contactform.php';
        $JAK_PROVED = 1;
        $JAK_PAGE_ACTIVE1 = 1;
        $checkp = 1;
    }
    if ($page == 'sitemap') {
        require_once 'sitemap.php';
        $JAK_PROVED = 1;
        $JAK_PAGE_ACTIVE1 = 1;
        $checkp = 1;
    }
    if ($page == 'searchsetting') {
        require_once 'searchsetting.php';
        $JAK_PROVED = 1;
        $JAK_PAGE_ACTIVE1 = 1;
        $checkp = 1;
    }
    if ($page == 'plugins') {
        require_once 'plugins.php';
        $JAK_PROVED = 1;
        $JAK_PAGE_ACTIVE = 1;
        $checkp = 1;
    }
    if ($page == 'template') {
        require_once 'template.php';
        $JAK_PROVED = 1;
        $JAK_PAGE_ACTIVE = 1;
        $checkp = 1;
    }
    if ($page == 'usergroup') {
        require_once 'usergroup.php';
        $JAK_PROVED = 1;
        $JAK_PAGE_ACTIVE = 1;
        $checkp = 1;
    }
    if ($page == 'maintenance') {
        require_once 'maintenance.php';
        $JAK_PROVED = 1;
        $JAK_PAGE_ACTIVE = 1;
        $checkp = 1;
    }
     
// if page not found
if ($checkp == 0) jak_redirect(BASE_URL.'index.php?p=404');

if (isset($template) && $template != '') {
	include_once APP_PATH.'admin/template/'.$template;
}

// Get the plugin template
if (isset($plugin_template) && $plugin_template != '') {
	
	include_once APP_PATH.$plugin_template;
}

// Reset success and errors session for next use
unset($_SESSION["successmsg"]);
unset($_SESSION["errormsg"]);
unset($_SESSION["infomsg"]);
    
// Finally close all db connections
$jakdb->jak_close();
?>