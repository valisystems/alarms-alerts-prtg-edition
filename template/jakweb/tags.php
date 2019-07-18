<?php include_once APP_PATH.'template/jakweb/header.php';?>

	<?php if (isset($PAGE_CONTENT)) echo $PAGE_CONTENT;?>
	
	<?php if (isset($JAK_GET_TAG_CLOUD)) { echo '<div class="well well-sm">'.$JAK_GET_TAG_CLOUD.'</div>';?>
				
		<?php if (isset($JAK_NO_TAG_DATA)) { ?>
		
		<div class="alert alert-info">
		  <?php echo $JAK_NO_TAG_DATA;?>
		</div>
		
		<?php } } ?>
		
		<div class="row">
		
		<?php $count = 0; if (isset($JAK_TAG_PAGE_DATA) && is_array($JAK_TAG_PAGE_DATA)) foreach($JAK_TAG_PAGE_DATA as $p) { $count++; ?>
		
		<div class="col-md-3 col-sm-6">
			<div class="service-wrapper">
				<i class="fa fa-file-text-o fa-4x"></i>
				<h3><a href="<?php echo $p["parseurl"];?>"><?php echo $p["title"];?></a></h3>
				<p><?php echo $p["content"];?></p>
				<a href="<?php echo $p["parseurl"];?>" class="btn btn-primary"><?php echo $tl["general"]["g3"];?></a>
			</div>
		</div>
		
		<?php } if (isset($JAK_TAG_NEWS_DATA) && is_array($JAK_TAG_NEWS_DATA)) foreach($JAK_TAG_NEWS_DATA as $n) { $count++; ?>
		
		<div class="col-md-3 col-sm-6">
			<div class="service-wrapper">
				<i class="fa fa-newspaper-o fa-4x"></i>
				<h3><a href="<?php echo $n["parseurl"];?>"><?php echo $n["title"];?></a></h3>
				<p><?php echo $n["content"];?></p>
				<a href="<?php echo $n["parseurl"];?>" class="btn btn-primary"><?php echo $tl["general"]["g3"];?></a>
			</div>
		</div>
		
		<?php } if (isset($JAK_HOOK_TAGS) && is_array($JAK_HOOK_TAGS)) foreach($JAK_HOOK_TAGS as $ht) { include_once APP_PATH.$ht['phpcode']; } ?>
		
		</div>
		
		<?php if (isset($count)) { ?>
		
		<div class="alert alert-info">
			<?php echo str_replace("%s", $count, $tl["general"]["g159"]);?>
		</div>
		
		<?php } else { ?>
		
		<div class="alert alert-danger">
			<?php echo $tl["general"]["g158"];?>	
		</div>
		
		<?php } ?>
		
<?php include_once APP_PATH.'template/jakweb/footer.php';?>