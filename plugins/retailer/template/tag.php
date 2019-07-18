<?php if (JAK_PLUGIN_ACCESS_TAGS && isset($JAK_TAG_RETAILER_DATA) && is_array($JAK_TAG_RETAILER_DATA)) foreach($JAK_TAG_RETAILER_DATA as $ret) { $count++; ?>

<div class="col-md-3 col-sm-6">
	<div class="service-wrapper">
		<i class="fa fa-map-marker fa-4x"></i>
		<h3><a href="<?php echo $ret["parseurl"];?>"><?php echo $ret["title"];?></a></h3>
		<p><?php echo $ret["content"];?></p>
		<a href="<?php echo $ret["parseurl"];?>" class="btn btn-primary"><?php echo $tl["general"]["g3"];?></a>
	</div>
</div>

<?php } ?>