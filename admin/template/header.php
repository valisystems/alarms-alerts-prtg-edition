<!DOCTYPE html>
<html lang="<?php echo $site_language;?>">
<head>
	<meta charset="utf-8">
	<title><?php if ($page) echo ucwords($page).' - ';?>ACP - <?php echo $jkv["title"];?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
	<meta name="description" content="CMS,Adminpanel,CLARICOM" />
	<meta name="keywords" content="Your premium CMS from CLARICOM HTML5/CSS3" />
	<meta name="author" content="CLARICOM (http://www.claricom.ca)" />
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
	
	<!--[if lt IE 9]>
	<script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	 <![endif]-->
	 
	 <!-- Import all hooks for in between head -->
	 <?php if (isset($JAK_HOOK_HEAD_ADMIN) && is_array($JAK_HOOK_HEAD_ADMIN)) foreach($JAK_HOOK_HEAD_ADMIN as $headt) { include_once APP_PATH.$headt['phpcode']; } ?>
</head>
<body class="skin-blue<?php if (!$JAK_PROVED) echo " login-page";?>">
<?php if ($JAK_PROVED) { ?>
  <div class="wrapper">
  	<header class="main-header">
  	        <!-- Logo -->
  	        <a class="logo" href="<?php echo BASE_URL_ORIG;?>"><?php echo $jkv["title"];?></a>
  	        <!-- Header Navbar: style can be found in header.less -->
  	        <nav class="navbar navbar-static-top">
  	          <!-- Sidebar toggle button-->
  	          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
  	            <span class="sr-only">Toggle navigation</span>
  	          </a>
  	          <div class="navbar-custom-menu">
  	            <ul class="nav navbar-nav">
  	            	<li class="dropdown">
  	            		<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-home"></i><span class="hidden-xs hidden-sm"> <?php echo $tl["menu"]["mh"];?> <b class="caret"></b></span></a>
  	            		<ul class="dropdown-menu">
  	            		  <li><a href="<?php echo BASE_URL_ADMIN;?>"><?php echo $tl["menu"]["mh"];?></a></li>
  	            		  <li><a href="index.php?p=site"><?php echo $tl["cmenu"]["c1"];?></a></li>
  	            		  <li><a href="index.php?p=logs"><?php echo $tl["cmenu"]["c48"];?></a></li>
  	            		  <li><a href="index.php?p=searchlog"><?php echo $tl["cmenu"]["c49"];?></a></li>
  	            		</ul> 
  	            	</li>
  	            	<?php if ($JAK_MODULEM) { ?>
  	            	<li><a href="index.php?p=page"><i class="fa fa-file-text-o"></i><span class="hidden-xs hidden-sm"> <?php echo $tl["menu"]["m7"];?></span></a></li>
  	            	<li><a href="index.php?p=categories"><i class="fa fa-list"></i><span class="hidden-xs hidden-sm"> <?php echo $tl["menu"]["m5"];?></span></a></li>
  	            	<?php } if ($JAK_MODULES) { ?>
  	            	<li><a href="index.php?p=setting"><i class="fa fa-cogs"></i><span class="hidden-xs hidden-sm"> <?php echo $tl["general"]["g5"];?></span></a></li>
  	            	<?php } ?>
  	            	<li><a class="wIframe" data-title='CMS - FAQ' href="https://www.claricom.ca/faq"><i class="fa fa-ambulance"></i><span class="hidden-xs hidden-sm"> <?php echo $tl["title"]["t21"];?></span></a></li>
  	              
  	              <!-- User Account: style can be found in dropdown.less -->
  	              <li class="dropdown user user-menu">
  	                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
  	                  <img src="<?php echo BASE_URL_ORIG.basename(JAK_FILES_DIRECTORY).'/userfiles/'.$jakuser->getVar("picture");?>" class="user-image" alt="User Image">
  	                  <span class="hidden-xs"><?php echo $jakuser->getVar("name");?></span>
  	                </a>
  	                <ul class="dropdown-menu">
  	                  <!-- User image -->
  	                  <li class="user-header">
  	                    <img src="<?php echo BASE_URL_ORIG.basename(JAK_FILES_DIRECTORY).'/userfiles/'.$jakuser->getVar("picture");?>" class="img-circle" alt="User Image">
  	                    <p>
  	                      <?php echo $JAK_WELCOME_NAME;?>
  	                      <small><?php echo sprintf($tl["user"]["u18"],$jakuser->getVar("time"));?></small>
  	                    </p>
  	                  </li>
  	                  <!-- Menu Footer-->
  	                  <li class="user-footer">
  	                    <div class="pull-left">
  	                      <a href="index.php?p=user&amp;sp=edit&amp;ssp=<?php echo JAK_USERID;?>" class="btn btn-default btn-flat"><?php echo $tl["general"]["g77"];?></a>
  	                    </div>
  	                    <div class="pull-right">
  	                      <a href="index.php?p=logout" onclick="if(!confirm('<?php echo $tl["logout"]["l2"];?>'))return false;" class="btn btn-default btn-flat"><?php echo $tl["logout"]["l"];?></a>
  	                    </div>
  	                  </li>
  	                </ul>
  	              </li>
  	              
  	            </ul>
  	          </div>
  	        </nav>
  	      </header>
  	      
  	      <!-- Left side column. contains sidebar -->
  	      <aside class="main-sidebar">
  	        <!-- sidebar: style -->
  	        <section class="sidebar">
  	        	<?php include_once APP_PATH.'admin/template/navbar.php';?>
  	        </section>
  	       </aside>
  	       
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<section class="content-header">
	  <h1><?php echo $SECTION_TITLE;?>
	    <small><?php echo $SECTION_DESC;?></small>
	  </h1>
	</section>
	
	<!-- Main content -->
	<section class="content">
<?php } else { ?>
<div class="container">
	<div class="col-md-12">
<?php } ?>