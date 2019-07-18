<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

if (!file_exists('../../config.php')) die('[install.php] config.php not found');
require_once '../../config.php';

// Check if the file is accessed only from a admin if not stop the script from running
if (!JAK_USERID) die('You cannot access this file directly.');

if (!$jakuser->jakAdminaccess($jakuser->getVar("usergroupid"))) die('You cannot access this file directly.');

// Set successfully to zero
$succesfully = 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Installation - E-Commerce Plugin</title>
	<meta charset="utf-8">
	<meta name="author" content="JAKWEB (http://www.jakweb.ch)" />
	<link rel="stylesheet" href="../../css/stylesheet.css" type="text/css" media="screen" />
</head>
<body>

<div class="container">
<div class="row">
<div class="col-md-12">
<h3>Installation - E-Commerce Plugin</h3>

<!-- Check if the plugin is already installed -->
<?php $jakdb->query('SELECT id FROM '.DB_PREFIX.'plugins WHERE name = "Ecommerce"');
if ($jakdb->affected_rows > 0) { ?>

<div class="alert alert-info">Plugin is already installed!!!</div>

<!-- Plugin is not installed let's display the installation script -->
<?php } else { ?>

<!-- The installation button is hit -->
<?php if (isset($_POST['install'])) {
 
$jakdb->query('INSERT INTO '.DB_PREFIX.'plugins (`id`, `name`, `description`, `active`, `access`, `pluginorder`, `pluginpath`, `phpcode`, `phpcodeadmin`, `sidenavhtml`, `usergroup`, `uninstallfile`, `pluginversion`, `time`) VALUES (NULL, "Ecommerce", "Modern and simple AJAX Shop, sell products has never been easier.", 1, '.JAK_USERID.', 4, "ecommerce", "require_once APP_PATH.\'plugins/ecommerce/shop.php\';", "if ($page == \'shop\') {
        require_once APP_PATH.\'plugins/ecommerce/admin/shop.php\';
        $JAK_PROVED = 1;
        $checkp = 1;
     }", "../plugins/ecommerce/admin/template/shopnav.php", "shop", "uninstall.php", "1.0", NOW())');

// now get the plugin id for futher use
$results = $jakdb->query('SELECT id FROM '.DB_PREFIX.'plugins WHERE name = "Ecommerce"');
$rows = $results->fetch_assoc();

if ($rows['id']) {

$adminlang = 'if (file_exists(APP_PATH.\'plugins/ecommerce/admin/lang/\'.$site_language.\'.ini\')) {
    $tlec = parse_ini_file(APP_PATH.\'plugins/ecommerce/admin/lang/\'.$site_language.\'.ini\', true);
} else {
    $tlec = parse_ini_file(APP_PATH.\'plugins/ecommerce/admin/lang/en.ini\', true);
}';

$sitelang = 'if (file_exists(APP_PATH.\'plugins/ecommerce/lang/\'.$site_language.\'.ini\')) {
    $tlec = parse_ini_file(APP_PATH.\'plugins/ecommerce/lang/\'.$site_language.\'.ini\', true);
} else {
    $tlec = parse_ini_file(APP_PATH.\'plugins/ecommerce/lang/en.ini\', true);
}';

$sitephpsearch = '$shop = new JAK_search($SearchInput); 
        	$shop->jakSettable(\'shop\',\"\");
        	$shop->jakAndor(\"OR\");
        	$shop->jakFieldactive(\"active\");
        	$shop->jakFieldtitle(\"title\");
        	$shop->jakFieldcut(\"content\");
        	$shop->jakFieldstosearch(array(\'title\',\'content\'));
        	$shop->jakFieldstoselect(\"id, title, content\");
        	
        	// Load the array into template
        	$JAK_SEARCH_RESULT_ECOMMERCE = $shop->set_result(JAK_PLUGIN_VAR_ECOMMERCE, \'i\', $jkv[\"shopurl\"]);';

$sitephptag = 'if ($row[\'pluginid\'] == JAK_PLUGIN_ID_ECOMMERCE) {
$shoptagData[] = JAK_tags::jakTagsql(\"shop\", $row[\'itemid\'], \"id, title, content\", \"content\", JAK_PLUGIN_VAR_ECOMMERCE, \"i\", $jkv[\"shopurl\"]);
$JAK_TAG_ECOMMERCE_DATA = $shoptagData;
}';

$sitephpsitemap = 'include_once APP_PATH.\'plugins/ecommerce/functions.php\';

$JAK_ECOMMERCE_ALL = jak_get_shop($jkv[\"shopurl\"]);
$PAGE_TITLE = JAK_PLUGIN_NAME_ECOMMERCE;';

// Fulltext search query
$sqlfull = '$jakdb->query(\'ALTER TABLE \'.DB_PREFIX.\'shop ADD FULLTEXT(`title`, `content`)\');';
$sqlfullremove = '$jakdb->query(\'ALTER TABLE \'.DB_PREFIX.\'shop DROP INDEX `title`\');';

// Insert php code
$insertphpcode = 'if (isset($defaults[\'jak_shop\'])) {
	$insert .= \'shop = \"\'.$defaults[\'jak_shop\'].\'\",\'; }';
        	
$sitephprss = 'if ($page1 == JAK_PLUGIN_VAR_ECOMMERCE) {
	
	if ($jkv[\"shoprss\"]) {
		$sql = \'SELECT id, title, content, time FROM \'.DB_PREFIX.\'shop WHERE active = 1 ORDER BY time DESC LIMIT \'.$jkv[\"shoprss\"];
		$sURL = JAK_PLUGIN_VAR_ECOMMERCE;
		$sURL1 = \'\';
		$what = 1;
		$seowhat = $jkv[\"shopurl\"];
		
		$JAK_RSS_DESCRIPTION = jak_cut_text($jkv[\"e_desc\"], $jkv[\"shortmsg\"], \'…\');
		
	} else {
		jak_redirect(BASE_URL);
	}
	
}';

// Insert into hooks
$jakdb->query('INSERT INTO '.DB_PREFIX.'pluginhooks (`id`, `hook_name`, `name`, `phpcode`, `product`, `active`, `exorder`, `pluginid`, `time`) VALUES (NULL, "php_admin_lang", "Ecommerce Admin Language", "'.$adminlang.'", "shop", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_lang", "Ecommerce Site Language", "'.$sitelang.'", "shop", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "php_admin_usergroup", "Ecommerce Usergroup", "'.$insertphpcode.'", "shop", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "php_search", "Ecommerce Search PHP", "'.$sitephpsearch.'", "shop", 1, 8, "'.$rows['id'].'", NOW()), (NULL, "tpl_admin_usergroup", "Ecommerce Usergroup New", "plugins/ecommerce/admin/template/usergroup_new.php", "shop", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_admin_usergroup_edit", "Ecommerce Usergroup Edit", "plugins/ecommerce/admin/template/usergroup_edit.php", "shop", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_between_head", "E-Commerce CSS", "plugins/ecommerce/template/header.php", "shop", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_footer_end", "E-Commerce JS", "plugins/ecommerce/template/footer.php", "shop", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "php_search", "Ecommerce Search PHP", "'.$sitephpsearch.'", "shop", 1, 8, "'.$rows['id'].'", NOW()), (NULL, "php_rss", "Ecommerce RSS PHP", "'.$sitephprss.'", "shop", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_tags", "Ecommerce Tags PHP", "'.$sitephptag.'", "shop", 1, 8, "'.$rows['id'].'", NOW()), (NULL, "php_sitemap", "Ecommerce Sitemap PHP", "'.$sitephpsitemap.'", "shop", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_tags", "Ecommerce Tags TPL", "plugins/ecommerce/template/tag.php", "shop", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "tpl_sitemap", "Ecommerce Sitemap TPL", "plugins/ecommerce/template/sitemap.php", "shop", 1, 4, "'.$rows['id'].'", NOW()), (NULL, "php_admin_fulltext_add", "Ecommerce Full Text Search", "'.$sqlfull.'", "shop", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "php_admin_fulltext_remove", "Ecommerce Remove Full Text Search", "'.$sqlfullremove.'", "shop", 1, 1, "'.$rows['id'].'", NOW()), (NULL, "tpl_search", "Ecommerce Search TPL", "plugins/ecommerce/template/search.php", "shop", 1, 1, "'.$rows['id'].'", NOW())');

// Insert tables into settings
$jakdb->query('INSERT INTO '.DB_PREFIX.'setting (`varname`, `groupname`, `value`, `defaultvalue`, `optioncode`, `datatype`, `product`) VALUES ("e_title", "shop", NULL, NULL, "input", "free", "shop"), ("e_desc", "shop", "", "", "textarea", "free", "shop"), ("e_thanks", "shop", NULL, NULL, "textarea", "free", "shop"), ("e_currency", "shop", "CHF", "CHF", "input", "free", "shop"), ("e_currency1", "shop", "", "", "input", "free", "shop"), ("e_currency2", "shop", "", "", "input", "free", "shop"), ("e_taxes", "shop", "", "", "input", "free", "shop"), ("shopemail", "shop", NULL, NULL, "input", "free", "shop"), ("shopdateformat", "shop", "d.m.Y", "d.m.Y", "input", "free", "shop"), ("shoptimeformat", "shop", ": h:i A", ": h:i A", "input", "free", "shop"), ("shopurl", "shop", 0, 0, "yesno", "boolean", "shop"), ("shoprss", "shop", 5, 5, "number", "select", "shop"), ("e_http", "shop", 0, 0, "yesno", "boolean", "shop"), ("e_agreement", "shop", NULL, NULL, "number", "select", "shop"), ("shoppagemid", "shop", 3, 3, "input", "number", "shop"), ("shoppageitem", "shop", 4, 4, "input", "number", "shop"), ("e_shop_address", "shop", NULL, NULL, "input", "free", "shop"), ("e_country", "shop", 0, 0, "number", "select", "shop"), ("e_productopen", "shop", 1, 1, "yesno", "boolean", "shop"), ("shopcheckout", "shop", 1, 1, "input", "number", "shop"), ("e_shop_download", "shop", "Please download your purchased digital good(s) with the provided link below.", NULL, "input", "free", "shop"), ("e_shop_download_b", "shop", "Please download your file(s) within 7 days:", NULL, "input", "free", "shop"), ("e_shop_download_bt", "shop", "Download Now", NULL, "input", "free", "shop")');

// Write into categories
$jakdb->query('INSERT INTO '.DB_PREFIX.'categories (`id`, `name`, `varname`, `catimg`, `showmenu`, `showfooter`, `catorder`, `catparent`, `pageid`, `permission`, `activeplugin`, `pluginid`) VALUES (NULL, "Shop", "shop", NULL, 1, 0, 5, 0, 0, 0, 1, "'.$rows['id'].'")');

// Insert into usergroup
$jakdb->query('ALTER TABLE '.DB_PREFIX.'usergroup ADD `shop` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `advsearch`');
$jakdb->query('ALTER TABLE '.DB_PREFIX.'pagesgrid ADD shopid INT(11) UNSIGNED NOT NULL DEFAULT 0 AFTER newsid');

$jakdb->query('CREATE TABLE IF NOT EXISTS '.DB_PREFIX.'shop (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `catid` int(11) unsigned NOT NULL DEFAULT 0,
  `title` varchar(255) DEFAULT NULL,
  `content` mediumtext,
  `specs` mediumtext,
  `price` float(10,2) DEFAULT NULL,
  `sale` float(10,2) DEFAULT NULL,
  `product_weight` float(10,3) DEFAULT NULL,
  `stock` smallint(1) NOT NULL DEFAULT 1,
  `product_options` varchar(255) DEFAULT NULL,
  `product_options1` varchar(255) DEFAULT NULL,
  `product_options2` varchar(255) DEFAULT NULL,
  `previmg` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `digital_file` varchar(255) DEFAULT NULL,
  `usergroup` int(11) unsigned NOT NULL DEFAULT 0,
  `active` smallint(1) unsigned NOT NULL DEFAULT 1,
  `showdate` smallint(1) unsigned NOT NULL DEFAULT 0,
  `hits` int(10) unsigned NOT NULL DEFAULT 0,
  `time` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',
  `ecorder` int(11) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `catid` (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');

$jakdb->query('CREATE TABLE IF NOT EXISTS '.DB_PREFIX.'shop_order (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `paid_method` smallint(2) unsigned NOT NULL DEFAULT 0,
  `total_price` float(10,2) DEFAULT NULL,
  `discount` float(10,2) DEFAULT NULL,
  `tax` float(10,2) DEFAULT NULL,
  `shipping` float(10,2) DEFAULT NULL,
  `freeshipping` smallint(1) unsigned NOT NULL DEFAULT 0,
  `currency` varchar(5) DEFAULT NULL,
  `userid` int(11) unsigned NOT NULL DEFAULT 0,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `country` int(3) unsigned NOT NULL DEFAULT 0,
  `city` varchar(100) DEFAULT NULL,
  `zip_code` varchar(100) DEFAULT NULL,
  `sh_name` varchar(100) DEFAULT NULL,
  `sh_company` varchar(100) DEFAULT NULL,
  `sh_address` varchar(255) DEFAULT NULL,
  `sh_country` int(3) unsigned NOT NULL DEFAULT 0,
  `sh_city` varchar(100) DEFAULT NULL,
  `sh_zip_code` varchar(100) DEFAULT NULL,
  `sh_phone` varchar(100) DEFAULT NULL,
  `paidtime` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',
  `paid` smallint(1) unsigned NOT NULL DEFAULT 0,
  `order_booked` smallint(1) unsigned NOT NULL DEFAULT 0,
  `time` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',
  `ordernumber` varchar(20) DEFAULT NULL,
  `downloadid` INT(10) UNSIGNED NOT NULL DEFAULT 0,
  `downloadtime` DATETIME NOT NULL DEFAULT \'0000-00-00 00:00:00\',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');

$jakdb->query('CREATE TABLE IF NOT EXISTS '.DB_PREFIX.'shopcategories (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `varname` varchar(255) DEFAULT NULL,
  `catimg` varchar(255) DEFAULT NULL,
  `permission` mediumtext,
  `catorder` int(11) unsigned NOT NULL DEFAULT 1,
  `catparent` int(11) unsigned NOT NULL DEFAULT 0,
  `active` smallint(1) unsigned NOT NULL DEFAULT 1,
  `count` int(11) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `catorder` (`catorder`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');

$jakdb->query('CREATE TABLE IF NOT EXISTS '.DB_PREFIX.'shop_order_details (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderid` int(11) unsigned NOT NULL DEFAULT 0,
  `shopid` int(11) unsigned NOT NULL DEFAULT 0,
  `title` varchar(255) DEFAULT NULL,
  `product_option` varchar(100) DEFAULT NULL,
  `price` float(10,2) DEFAULT NULL,
  `coupon_price` float(10,2) DEFAULT NULL,
  `weight` float(10,3) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orderid` (`orderid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');

$jakdb->query('CREATE TABLE IF NOT EXISTS '.DB_PREFIX.'shopping_cart (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shopid` int(11) unsigned NOT NULL DEFAULT 0,
  `cartid` varchar(100) DEFAULT NULL,
  `product_option` varchar(255) DEFAULT NULL,
  `price` float(10,2) DEFAULT NULL,
  `currency` varchar(5) DEFAULT NULL,
  `weight` float(10,3) DEFAULT NULL,
  `session` varchar(32) DEFAULT NULL,
  `time` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');

$jakdb->query('CREATE TABLE IF NOT EXISTS '.DB_PREFIX.'shop_shipping (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `deliveryimg` varchar(255) DEFAULT NULL,
  `est_shipping` varchar(20) DEFAULT NULL,
  `price` float(10,2) DEFAULT NULL,
  `handling` float(10,2) DEFAULT NULL,
  `weightfrom` float(10,3) DEFAULT NULL,
  `weightto` float(10,3) DEFAULT NULL,
  `country` int(3) unsigned NOT NULL DEFAULT 0,
  `status` smallint(1) unsigned NOT NULL DEFAULT 1,
  `time` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');

$jakdb->query('CREATE TABLE IF NOT EXISTS '.DB_PREFIX.'shop_payment_ipn (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ordernr` varchar(20) DEFAULT NULL,
  `status` varchar(250) DEFAULT NULL,
  `amount` varchar(250) DEFAULT NULL,
  `currency` varchar(250) DEFAULT NULL,
  `txn_id` varchar(250) DEFAULT NULL,
  `receiver_email` varchar(250) DEFAULT NULL,
  `payer_email` varchar(250) DEFAULT NULL,
  `paid_with` varchar(250) DEFAULT NULL,
  `time` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');

$jakdb->query('CREATE TABLE IF NOT EXISTS '.DB_PREFIX.'shop_payment (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `field` text,
  `field1` text,
  `field2` text,
  `field3` text,
  `fees` smallint(2) unsigned NOT NULL DEFAULT 0,
  `status` smallint(1) unsigned NOT NULL DEFAULT 0,
  `msporder` int(11) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=7');

$jakdb->query("INSERT INTO ".DB_PREFIX."shop_payment (`id`, `title`, `field`, `field1`, `field2`, `field3`, `status`, `msporder`) VALUES
(1, 'Bank Transfer', 'Bank Transfer Swiss', '', NULL, NULL, 0, 1),
(2, 'Cheque / Money Order', 'Cheque / Money Order', '', NULL, NULL, 0, 2),
(3, 'Paypal', 'Paypal', '', NULL, NULL, 0, 3),
(4, '2CheckOut', '2CheckOut', '', '', NULL, 0, 4),
(5, 'Authorize.net', 'Authorize.net', '', '', NULL, 0, 5),
(6, 'Cash on Delivery', 'Cash on Delivery', '', NULL, NULL, 0, 8),
(7, 'Pickup', 'Pickup', '', NULL, NULL, 0, 9),
(8, 'Payza', 'Payza', '', NULL, NULL, 0, 6),
(9, 'Skrill (Moneybookers)', 'Skrill', '', NULL, NULL, 0, 7),
(10, 'Stripe', 'Credit Card', '', NULL, NULL, 0, 10)");

$jakdb->query('CREATE TABLE IF NOT EXISTS '.DB_PREFIX.'shop_coupon (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `code` varchar(255) DEFAULT NULL,
  `type` smallint(1) unsigned NOT NULL DEFAULT 0,
  `discount` float(10,2) DEFAULT NULL,
  `freeshipping` smallint(1) unsigned NOT NULL DEFAULT 0,
  `datestart` int(10) unsigned NOT NULL DEFAULT 0,
  `dateend` int(10) unsigned NOT NULL DEFAULT 0,
  `total` int(11) unsigned NOT NULL DEFAULT 0,
  `used` int(11) unsigned NOT NULL DEFAULT 0,
  `products` mediumtext,
  `usergroup` mediumtext,
  `status` smallint(1) unsigned NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');

$jakdb->query('CREATE TABLE '.DB_PREFIX.'shop_country (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  `iso_code_2` varchar(2) DEFAULT NULL,
  `iso_code_3` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=240');

$jakdb->query("INSERT INTO ".DB_PREFIX."shop_country VALUES
(1, 'Afghanistan', 'AF', 'AFG'),
(2, 'Albania', 'AL', 'ALB'),
(3, 'Algeria', 'DZ', 'DZA'),
(4, 'American Samoa', 'AS', 'ASM'),
(5, 'Andorra', 'AD', 'AND'),
(6, 'Angola', 'AO', 'AGO'),
(7, 'Anguilla', 'AI', 'AIA'),
(8, 'Antarctica', 'AQ', 'ATA'),
(9, 'Antigua and Barbuda', 'AG', 'ATG'),
(10, 'Argentina', 'AR', 'ARG'),
(11, 'Armenia', 'AM', 'ARM'),
(12, 'Aruba', 'AW', 'ABW'),
(13, 'Australia', 'AU', 'AUS'),
(14, 'Austria', 'AT', 'AUT'),
(15, 'Azerbaijan', 'AZ', 'AZE'),
(16, 'Bahamas', 'BS', 'BHS'),
(17, 'Bahrain', 'BH', 'BHR'),
(18, 'Bangladesh', 'BD', 'BGD'),
(19, 'Barbados', 'BB', 'BRB'),
(20, 'Belarus', 'BY', 'BLR'),
(21, 'Belgium', 'BE', 'BEL'),
(22, 'Belize', 'BZ', 'BLZ'),
(23, 'Benin', 'BJ', 'BEN'),
(24, 'Bermuda', 'BM', 'BMU'),
(25, 'Bhutan', 'BT', 'BTN'),
(26, 'Bolivia', 'BO', 'BOL'),
(27, 'Bosnia and Herzegowina', 'BA', 'BIH'),
(28, 'Botswana', 'BW', 'BWA'),
(29, 'Bouvet Island', 'BV', 'BVT'),
(30, 'Brazil', 'BR', 'BRA'),
(31, 'British Indian Ocean Territory', 'IO', 'IOT'),
(32, 'Brunei Darussalam', 'BN', 'BRN'),
(33, 'Bulgaria', 'BG', 'BGR'),
(34, 'Burkina Faso', 'BF', 'BFA'),
(35, 'Burundi', 'BI', 'BDI'),
(36, 'Cambodia', 'KH', 'KHM'),
(37, 'Cameroon', 'CM', 'CMR'),
(38, 'Canada', 'CA', 'CAN'),
(39, 'Cape Verde', 'CV', 'CPV'),
(40, 'Cayman Islands', 'KY', 'CYM'),
(41, 'Central African Republic', 'CF', 'CAF'),
(42, 'Chad', 'TD', 'TCD'),
(43, 'Chile', 'CL', 'CHL'),
(44, 'China', 'CN', 'CHN'),
(45, 'Christmas Island', 'CX', 'CXR'),
(46, 'Cocos (Keeling) Islands', 'CC', 'CCK'),
(47, 'Colombia', 'CO', 'COL'),
(48, 'Comoros', 'KM', 'COM'),
(49, 'Congo', 'CG', 'COG'),
(50, 'Cook Islands', 'CK', 'COK'),
(51, 'Costa Rica', 'CR', 'CRI'),
(52, 'Cote D''Ivoire', 'CI', 'CIV'),
(53, 'Croatia', 'HR', 'HRV'),
(54, 'Cuba', 'CU', 'CUB'),
(55, 'Cyprus', 'CY', 'CYP'),
(56, 'Czech Republic', 'CZ', 'CZE'),
(57, 'Denmark', 'DK', 'DNK'),
(58, 'Djibouti', 'DJ', 'DJI'),
(59, 'Dominica', 'DM', 'DMA'),
(60, 'Dominican Republic', 'DO', 'DOM'),
(61, 'East Timor', 'TP', 'TMP'),
(62, 'Ecuador', 'EC', 'ECU'),
(63, 'Egypt', 'EG', 'EGY'),
(64, 'El Salvador', 'SV', 'SLV'),
(65, 'Equatorial Guinea', 'GQ', 'GNQ'),
(66, 'Eritrea', 'ER', 'ERI'),
(67, 'Estonia', 'EE', 'EST'),
(68, 'Ethiopia', 'ET', 'ETH'),
(69, 'Falkland Islands (Malvinas)', 'FK', 'FLK'),
(70, 'Faroe Islands', 'FO', 'FRO'),
(71, 'Fiji', 'FJ', 'FJI'),
(72, 'Finland', 'FI', 'FIN'),
(73, 'France', 'FR', 'FRA'),
(74, 'France, Metropolitan', 'FX', 'FXX'),
(75, 'French Guiana', 'GF', 'GUF'),
(76, 'French Polynesia', 'PF', 'PYF'),
(77, 'French Southern Territories', 'TF', 'ATF'),
(78, 'Gabon', 'GA', 'GAB'),
(79, 'Gambia', 'GM', 'GMB'),
(80, 'Georgia', 'GE', 'GEO'),
(81, 'Germany', 'DE', 'DEU'),
(82, 'Ghana', 'GH', 'GHA'),
(83, 'Gibraltar', 'GI', 'GIB'),
(84, 'Greece', 'GR', 'GRC'),
(85, 'Greenland', 'GL', 'GRL'),
(86, 'Grenada', 'GD', 'GRD'),
(87, 'Guadeloupe', 'GP', 'GLP'),
(88, 'Guam', 'GU', 'GUM'),
(89, 'Guatemala', 'GT', 'GTM'),
(90, 'Guinea', 'GN', 'GIN'),
(91, 'Guinea-bissau', 'GW', 'GNB'),
(92, 'Guyana', 'GY', 'GUY'),
(93, 'Haiti', 'HT', 'HTI'),
(94, 'Heard and Mc Donald Islands', 'HM', 'HMD'),
(95, 'Honduras', 'HN', 'HND'),
(96, 'Hong Kong', 'HK', 'HKG'),
(97, 'Hungary', 'HU', 'HUN'),
(98, 'Iceland', 'IS', 'ISL'),
(99, 'India', 'IN', 'IND'),
(100, 'Indonesia', 'ID', 'IDN'),
(101, 'Iran (Islamic Republic of)', 'IR', 'IRN'),
(102, 'Iraq', 'IQ', 'IRQ'),
(103, 'Ireland', 'IE', 'IRL'),
(104, 'Israel', 'IL', 'ISR'),
(105, 'Italy', 'IT', 'ITA'),
(106, 'Jamaica', 'JM', 'JAM'),
(107, 'Japan', 'JP', 'JPN'),
(108, 'Jordan', 'JO', 'JOR'),
(109, 'Kazakhstan', 'KZ', 'KAZ'),
(110, 'Kenya', 'KE', 'KEN'),
(111, 'Kiribati', 'KI', 'KIR'),
(112, 'North Korea', 'KP', 'PRK'),
(113, 'Korea, Republic of', 'KR', 'KOR'),
(114, 'Kuwait', 'KW', 'KWT'),
(115, 'Kyrgyzstan', 'KG', 'KGZ'),
(116, 'Lao People''s Democratic Republic', 'LA', 'LAO'),
(117, 'Latvia', 'LV', 'LVA'),
(118, 'Lebanon', 'LB', 'LBN'),
(119, 'Lesotho', 'LS', 'LSO'),
(120, 'Liberia', 'LR', 'LBR'),
(121, 'Libyan Arab Jamahiriya', 'LY', 'LBY'),
(122, 'Liechtenstein', 'LI', 'LIE'),
(123, 'Lithuania', 'LT', 'LTU'),
(124, 'Luxembourg', 'LU', 'LUX'),
(125, 'Macau', 'MO', 'MAC'),
(126, 'Macedonia', 'MK', 'MKD'),
(127, 'Madagascar', 'MG', 'MDG'),
(128, 'Malawi', 'MW', 'MWI'),
(129, 'Malaysia', 'MY', 'MYS'),
(130, 'Maldives', 'MV', 'MDV'),
(131, 'Mali', 'ML', 'MLI'),
(132, 'Malta', 'MT', 'MLT'),
(133, 'Marshall Islands', 'MH', 'MHL'),
(134, 'Martinique', 'MQ', 'MTQ'),
(135, 'Mauritania', 'MR', 'MRT'),
(136, 'Mauritius', 'MU', 'MUS'),
(137, 'Mayotte', 'YT', 'MYT'),
(138, 'Mexico', 'MX', 'MEX'),
(139, 'Micronesia, Federated States of', 'FM', 'FSM'),
(140, 'Moldova, Republic of', 'MD', 'MDA'),
(141, 'Monaco', 'MC', 'MCO'),
(142, 'Mongolia', 'MN', 'MNG'),
(143, 'Montserrat', 'MS', 'MSR'),
(144, 'Morocco', 'MA', 'MAR'),
(145, 'Mozambique', 'MZ', 'MOZ'),
(146, 'Myanmar', 'MM', 'MMR'),
(147, 'Namibia', 'NA', 'NAM'),
(148, 'Nauru', 'NR', 'NRU'),
(149, 'Nepal', 'NP', 'NPL'),
(150, 'Netherlands', 'NL', 'NLD'),
(151, 'Netherlands Antilles', 'AN', 'ANT'),
(152, 'New Caledonia', 'NC', 'NCL'),
(153, 'New Zealand', 'NZ', 'NZL'),
(154, 'Nicaragua', 'NI', 'NIC'),
(155, 'Niger', 'NE', 'NER'),
(156, 'Nigeria', 'NG', 'NGA'),
(157, 'Niue', 'NU', 'NIU'),
(158, 'Norfolk Island', 'NF', 'NFK'),
(159, 'Northern Mariana Islands', 'MP', 'MNP'),
(160, 'Norway', 'NO', 'NOR'),
(161, 'Oman', 'OM', 'OMN'),
(162, 'Pakistan', 'PK', 'PAK'),
(163, 'Palau', 'PW', 'PLW'),
(164, 'Panama', 'PA', 'PAN'),
(165, 'Papua New Guinea', 'PG', 'PNG'),
(166, 'Paraguay', 'PY', 'PRY'),
(167, 'Peru', 'PE', 'PER'),
(168, 'Philippines', 'PH', 'PHL'),
(169, 'Pitcairn', 'PN', 'PCN'),
(170, 'Poland', 'PL', 'POL'),
(171, 'Portugal', 'PT', 'PRT'),
(172, 'Puerto Rico', 'PR', 'PRI'),
(173, 'Qatar', 'QA', 'QAT'),
(174, 'Reunion', 'RE', 'REU'),
(175, 'Romania', 'RO', 'ROM'),
(176, 'Russian Federation', 'RU', 'RUS'),
(177, 'Rwanda', 'RW', 'RWA'),
(178, 'Saint Kitts and Nevis', 'KN', 'KNA'),
(179, 'Saint Lucia', 'LC', 'LCA'),
(180, 'Saint Vincent and the Grenadines', 'VC', 'VCT'),
(181, 'Samoa', 'WS', 'WSM'),
(182, 'San Marino', 'SM', 'SMR'),
(183, 'Sao Tome and Principe', 'ST', 'STP'),
(184, 'Saudi Arabia', 'SA', 'SAU'),
(185, 'Senegal', 'SN', 'SEN'),
(186, 'Seychelles', 'SC', 'SYC'),
(187, 'Sierra Leone', 'SL', 'SLE'),
(188, 'Singapore', 'SG', 'SGP'),
(189, 'Slovakia (Slovak Republic)', 'SK', 'SVK'),
(190, 'Slovenia', 'SI', 'SVN'),
(191, 'Solomon Islands', 'SB', 'SLB'),
(192, 'Somalia', 'SO', 'SOM'),
(193, 'South Africa', 'ZA', 'ZAF'),
(194, 'South Georgia and South Sandwich Islands', 'GS', 'SGS'),
(195, 'Spain', 'ES', 'ESP'),
(196, 'Sri Lanka', 'LK', 'LKA'),
(197, 'St. Helena', 'SH', 'SHN'),
(198, 'St. Pierre and Miquelon', 'PM', 'SPM'),
(199, 'Sudan', 'SD', 'SDN'),
(200, 'Suriname', 'SR', 'SUR'),
(201, 'Svalbard and Jan Mayen Islands', 'SJ', 'SJM'),
(202, 'Swaziland', 'SZ', 'SWZ'),
(203, 'Sweden', 'SE', 'SWE'),
(204, 'Switzerland', 'CH', 'CHE'),
(205, 'Syrian Arab Republic', 'SY', 'SYR'),
(206, 'Taiwan', 'TW', 'TWN'),
(207, 'Tajikistan', 'TJ', 'TJK'),
(208, 'Tanzania, United Republic of', 'TZ', 'TZA'),
(209, 'Thailand', 'TH', 'THA'),
(210, 'Togo', 'TG', 'TGO'),
(211, 'Tokelau', 'TK', 'TKL'),
(212, 'Tonga', 'TO', 'TON'),
(213, 'Trinidad and Tobago', 'TT', 'TTO'),
(214, 'Tunisia', 'TN', 'TUN'),
(215, 'Turkey', 'TR', 'TUR'),
(216, 'Turkmenistan', 'TM', 'TKM'),
(217, 'Turks and Caicos Islands', 'TC', 'TCA'),
(218, 'Tuvalu', 'TV', 'TUV'),
(219, 'Uganda', 'UG', 'UGA'),
(220, 'Ukraine', 'UA', 'UKR'),
(221, 'United Arab Emirates', 'AE', 'ARE'),
(222, 'United Kingdom', 'GB', 'GBR'),
(223, 'United States', 'US', 'USA'),
(224, 'United States Minor Outlying Islands', 'UM', 'UMI'),
(225, 'Uruguay', 'UY', 'URY'),
(226, 'Uzbekistan', 'UZ', 'UZB'),
(227, 'Vanuatu', 'VU', 'VUT'),
(228, 'Vatican City State (Holy See)', 'VA', 'VAT'),
(229, 'Venezuela', 'VE', 'VEN'),
(230, 'Viet Nam', 'VN', 'VNM'),
(231, 'Virgin Islands (British)', 'VG', 'VGB'),
(232, 'Virgin Islands (U.S.)', 'VI', 'VIR'),
(233, 'Wallis and Futuna Islands', 'WF', 'WLF'),
(234, 'Western Sahara', 'EH', 'ESH'),
(235, 'Yemen', 'YE', 'YEM'),
(236, 'Yugoslavia', 'YU', 'YUG'),
(237, 'Zaire', 'ZR', 'ZAR'),
(238, 'Zambia', 'ZM', 'ZMB'),
(239, 'Zimbabwe', 'ZW', 'ZWE'),
(999, 'Worldwide', 'WW', 'WWE')");

$succesfully = 1;

// Full text search is activated we do so for the blog table as well
if ($jkv["fulltextsearch"]) {
	$jakdb->query('ALTER TABLE '.DB_PREFIX.'shop ADD FULLTEXT(`title`, `content`)');
}

?>
<div class="alert alert-success">Plugin installed successfully</div>
<?php } else { 

$result = $jakdb->query('DELETE FROM '.DB_PREFIX.'plugins WHERE name = "Ecommerce"');

?>
<div class="alert alert-danger">Plugin installation failed.</div>
<?php } } ?>

<?php if (!$succesfully) { ?>
<form name="company" method="post" action="install.php" enctype="multipart/form-data">
<button type="submit" name="install" class="btn btn-primary btn-block">Install Plugin</button>
</form>
<?php } } ?>

</div>
</div>


</div><!-- #container -->
</body>
</html>