<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php if ($page) echo ucwords($page).' - ';?>ACP - <?php echo $jkv["title"];?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="CMS,Adminpanel,CMS,CLARICOM" />
	<meta name="keywords" content="Your premium CMS from CLARICOM HTML5/CSS3" />
	<meta name="author" content="CLARICOM (http://www.claricom.ca, http://www.claricom.ca)" />
	<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
	
	<!-- General Stylesheet with custom modifications -->
	<link rel="stylesheet" href="../css/stylesheet.css?=<?php echo $jkv["updatetime"];?>" type="text/css" media="screen" />
	<link rel="stylesheet" href="css/admin.css?=<?php echo $jkv["updatetime"];?>" type="text/css" media="screen" />
	
	<?php if (!$jkv["langdirection"]) { ?>
	<!-- RTL Support -->
	<link rel="stylesheet" href="css/rtl/screen.css?=<?php echo $jkv["updatetime"];?>" type="text/css" media="screen" />
	<!-- End RTL Support -->
	<?php } ?>
	
	<!--js-->
	
	<script src="../js/jquery.js?=<?php echo $jkv["updatetime"];?>"></script>
	<script type="text/javascript" src="../js/functions.js?=<?php echo $jkv["updatetime"];?>"></script>
	<script type="text/javascript" src="js/cms.js?=<?php echo $jkv["updatetime"];?>"></script>
	
	<!-- Import all hooks for in between head -->
	<?php if (isset($JAK_HOOK_HEAD_ADMIN) && is_array($JAK_HOOK_HEAD_ADMIN)) foreach($JAK_HOOK_HEAD_ADMIN as $headt) { include_once APP_PATH.$headt['phpcode']; } ?>
	
	<!--[if lt IE 9]>
	<script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	 <![endif]-->
	
</head>
<body>

<div class="container">
	<div class="row">
       	<div class="col-md-12">
       		<section class="content-header">
       		  <h1><?php echo $tl["general"]["g135"];?></h1>
       		</section>