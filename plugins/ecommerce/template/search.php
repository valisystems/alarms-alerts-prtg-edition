<?php if (isset($JAK_SEARCH_RESULT_ECOMMERCE) && is_array($JAK_SEARCH_RESULT_ECOMMERCE)) foreach($JAK_SEARCH_RESULT_ECOMMERCE as $eco) { $count++; ?>

<div class="col-md-3 col-sm-6">
	<div class="service-wrapper">
		<i class="fa fa-shopping-cart fa-4x"></i>
		<h3><a href="<?php echo $eco["parseurl"];?>"><?php echo $eco["title"];?></a></h3>
		<p><?php echo $eco["content"];?></p>
		<a href="<?php echo $eco["parseurl"];?>" class="btn btn-primary"><?php echo $tl["general"]["g3"];?></a>
	</div>
</div>

<?php } ?>