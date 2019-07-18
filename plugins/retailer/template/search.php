<?php if (isset($JAK_SEARCH_RESULT_RETAILER) && is_array($JAK_SEARCH_RESULT_RETAILER)) foreach($JAK_SEARCH_RESULT_RETAILER as $ret) { $count++; ?>

<div class="col-md-3 col-sm-6">
	<div class="service-wrapper">
		<i class="fa fa-map-marker fa-4x"></i>
		<h3><a href="<?php echo $ret["parseurl"];?>"><?php echo $ret["title"];?></a></h3>
		<p><?php echo $ret["content"];?></p>
		<a href="<?php echo $ret["parseurl"];?>" class="btn btn-primary"><?php echo $tl["general"]["g3"];?></a>
	</div>
</div>

<?php } ?>