<!DOCTYPE html>
<html lang="<?php echo $site_language;?>">
<head>
	<meta charset="utf-8">
	<title>Edit Post</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta name="author" content="<?php echo $jkv["metaauthor"];?>" />
	<meta name="robots" content="<?php echo $jkv["robots"];?>" />
	
	<link rel="stylesheet" href="<?php echo BASE_URL;?>css/stylesheet.css?=<?php echo $jkv["updatetime"];?>" type="text/css" />
	<link rel="stylesheet" href="<?php echo BASE_URL;?>template/jakweb/css/screen.css?=<?php echo $jkv["updatetime"];?>" type="text/css" />
	
	<?php if ($jkv["fontg_jakweb_tpl"] != "NonGoogle") { ?>
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=<?php echo $jkv["fontg_jakweb_tpl"];?>:regular,italic,bold,bolditalic" type="text/css" />
	<?php } ?>
	
	<style type="text/css">
		h1, h2, h3, h4, h5, h6 { font-family:<?php if ($jkv["fontg_jakweb_tpl"] != "NonGoogle") echo '"'.str_replace("+", " ", $jkv["fontg_jakweb_tpl"]).'", '; echo $jkv["font_jakweb_tpl"];?>; }
	</style>
	<style id="cFontStyles" type="text/css">
		body, code, input[type="text"], textarea { font-family:<?php echo $jkv["font_jakweb_tpl"];?>; }
	</style>
	
	<?php if (!$jkv["langdirection"]) { ?>
	<!-- RTL Support -->
	<link rel="stylesheet" href="<?php echo BASE_URL;?>template/jakweb/css/rtlscreen.css?=<?php echo $jkv["updatetime"];?>" type="text/css" media="screen" />
	<!-- End RTL Support -->
	<?php } ?>
	
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	
</head>
<body>

<div class="section">

<div class="container">
	<div class="col-md-12">
	
		<?php if ($page4 == "s") { ?>
		<div class="alert alert-success fade in">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		  <?php echo $tl["general"]["s"];?>
		</div>
		<?php } if ($page4 == "e") { ?>
		<div class="alert alert-danger fade in">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		  <?php echo $tl["errorpage"]["not"];?>
		</div>
		<?php } ?>
		        
		<form role="form" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
		
		<div class="form-group">
			<label><?php echo $tl["contact"]["c1"];?> <i class="fa fa-star"></i></label>
			<input type="text" name="username" class="form-control" value="<?php echo $RUNAME;?>">
		</div>
		
		<div class="form-group">
			<label><?php echo $tl["contact"]["c17"];?></label>
			<input type="text" name="web" class="form-control" value="<?php echo $RWEB;?>">
		</div>
		
		<div class="form-group">
			<label><?php echo $tl["cmsg"]["c7"];?> <i class="fa fa-star"></i></label>
			<textarea name="userpost" id="userpost" class="form-control userpost" rows="10"><?php echo $RCONT;?></textarea>
		</div>
		
		<button type="submit" name="editpost" class="btn btn-primary"><?php echo $tl["general"]["g10"];?></button>
				        	
		<input type="hidden" name="name" value="<?php echo $JAK_USERNAME;?>" />
		</form>
		
	</div>
</div>

</div>

<script src="<?php echo BASE_URL;?>js/jquery.js?=<?php echo $jkv["updatetime"];?>"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/functions.js?=<?php echo $jkv["updatetime"];?>"></script>

<script type="text/javascript">
	jakWeb.jak_lang = "<?php echo $site_language;?>";
</script>

<script type="text/javascript" src="<?php echo BASE_URL;?>js/post.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/editor/tinymce.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/usreditor.js"></script>

</body>
</html>