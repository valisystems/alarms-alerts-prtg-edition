<?php include_once APP_PATH.'template/jakweb/header.php';?>
		
		<?php if ($PAGE_ACTIVE) { ?>
			<div class="alert alert-danger">
				<?php echo $tl["errorpage"]["ep"];?>	
			</div>
		
		<?php } echo $PAGE_CONTENT;?>
		
<?php include_once APP_PATH.'template/jakweb/footer.php';?>