<?php include_once APP_PATH.'template/jakweb/header.php';?>

	<div class="page-header">
				
		<!-- Heading -->
		<h1><?php echo $tl["title"]["t10"];?></h1>
				
		<?php echo $tl["errorpage"]["ep"];?>
	
	</div>
	
	<?php if ($USR_IP_BLOCKED) { ?>
	<div class="alert alert-info">
		<p><?php echo$USR_IP_BLOCKED;?></p>
	</div>
	<?php } ?>
		
<?php include_once APP_PATH.'template/jakweb/footer.php';?>