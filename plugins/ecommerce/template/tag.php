<?php if (JAK_PLUGIN_ACCESS_TAGS && isset($JAK_TAG_ECOMMERCE_DATA) && is_array($JAK_TAG_ECOMMERCE_DATA)) foreach($JAK_TAG_ECOMMERCE_DATA as $eco) { $count++; ?>

<div class="col-md-3 col-sm-6">
	<div class="service-wrapper">
		<i class="fa fa-shopping-cart fa-4x"></i>
		<h3><a href="<?php echo $eco["parseurl"];?>"><?php echo $eco["title"];?></a></h3>
		<p><?php echo $eco["content"];?></p>
		<a href="<?php echo $eco["parseurl"];?>" class="btn btn-primary"><?php echo $tl["general"]["g3"];?></a>
	</div>
</div>

<?php } ?>