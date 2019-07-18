<?php include_once APP_PATH.'template/jakweb/header.php';?>

	<?php if ($PAGE_TITLE) { ?>
		<!-- Heading -->
		<h1><?php echo $PAGE_TITLE;?></h1>
	<?php } ?>
	<?php echo $PAGE_CONTENT;?>
		
		<div class="sitemap">
			<?php if (isset($JAK_CAT_SITE) && is_array($JAK_CAT_SITE)) { ?>
			<ul>
			<?php foreach($JAK_CAT_SITE as $v) { if ($v["catparent"] == '0') { ?>
			
			<li><a href="<?php echo $v["varname"];?>"><?php echo $v["name"];?></a>
			
			<?php if (isset($v["catexist"])) { ?>
			
			<ul>
			
			<?php if (isset($JAK_CAT_SITE) && is_array($JAK_CAT_SITE)) foreach($JAK_CAT_SITE as $z) { 
			
			if ($z["catparent"] != '0' && $z["catparent2"] == '0' && $z["catparent"] == $v["id"]) { ?>
			
			<li><a href="<?php echo $z["varname"];?>"><?php echo $z["name"];?></a>
			
			<?php if (isset($z["catexist2"])) { ?>
			
			<ul>
			
			<?php if (isset($JAK_CAT_SITE) && is_array($JAK_CAT_SITE)) foreach($JAK_CAT_SITE as $o) { 
			
			if ($o["catparent"] != '0' && $o["catparent2"] != '0' && $o["catparent"] == $v["id"] && $o["catparent2"] == $z["id"]) { ?>
			
			<li><a href="<?php echo $o["varname"];?>"><?php echo $o["name"];?></a></li>
			
			<?php } } ?>
			</ul>
			<?php } ?>
			</li>
			<?php } } ?>
			</ul>
			</li>
			<?php } else { ?>
			</li>
			<?php } } } ?>
			</ul>
			<?php } ?>
	
			<?php if (isset($JAK_HOOK_SITEMAP) && is_array($JAK_HOOK_SITEMAP)) foreach($JAK_HOOK_SITEMAP as $hs) { include_once APP_PATH.$hs['phpcode']; } ?>
			</p>
		</div>

<?php include_once APP_PATH.'template/jakweb/footer.php';?>