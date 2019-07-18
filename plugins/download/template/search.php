<?php if (isset($JAK_SEARCH_RESULT_DOWNLOAD) && is_array($JAK_SEARCH_RESULT_DOWNLOAD)) foreach($JAK_SEARCH_RESULT_DOWNLOAD as $dl) { $count++; ?>

<div class="col-md-3 col-sm-6">
	<div class="service-wrapper">
		<i class="fa fa-floppy-o fa-4x"></i>
		<h3><a href="<?php echo $dl["parseurl"];?>"><?php echo $dl["title"];?></a></h3>
		<p><?php echo $dl["content"];?></p>
		<a href="<?php echo $dl["parseurl"];?>" class="btn btn-primary"><?php echo $tl["general"]["g3"];?></a>
	</div>
</div>

<?php } ?>