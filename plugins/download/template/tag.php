<?php if (JAK_PLUGIN_ACCESS_TAGS && isset($JAK_TAG_DOWNLOAD_DATA) && is_array($JAK_TAG_DOWNLOAD_DATA)) foreach($JAK_TAG_DOWNLOAD_DATA as $dl) { $count++; ?>

<div class="col-md-3 col-sm-6">
	<div class="service-wrapper">
		<i class="fa fa-floppy-o fa-4x"></i>
		<h3><a href="<?php echo $dl["parseurl"];?>"><?php echo $dl["title"];?></a></h3>
		<p><?php echo $dl["content"];?></p>
		<a href="<?php echo $dl["parseurl"];?>" class="btn btn-primary"><?php echo $tl["general"]["g3"];?></a>
	</div>
</div>

<?php } ?>