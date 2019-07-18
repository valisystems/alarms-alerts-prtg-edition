<?php if (JAK_PLUGIN_ACCESS_TAGS && isset($JAK_TAG_GALLERY_DATA) && is_array($JAK_TAG_GALLERY_DATA)) foreach($JAK_TAG_GALLERY_DATA as $gal) { $count++; ?>

<div class="col-md-3 col-sm-6">
	<div class="service-wrapper">
		<i class="fa fa-picture-o fa-4x"></i>
		<h3><a href="<?php echo $gal["parseurl"];?>"><?php echo $gal["title"];?></a></h3>
		<p><?php echo $gal["content"];?></p>
		<a href="<?php echo $gal["parseurl"];?>" class="btn btn-primary"><?php echo $tl["general"]["g3"];?></a>
	</div>
</div>

<?php } ?>