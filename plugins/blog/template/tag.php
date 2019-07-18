<?php if (JAK_PLUGIN_ACCESS_TAGS && isset($JAK_TAG_BLOG_DATA) && is_array($JAK_TAG_BLOG_DATA)) foreach($JAK_TAG_BLOG_DATA as $bl) { $count++; ?>

<div class="col-md-3 col-sm-6">
	<div class="service-wrapper">
		<i class="fa fa-commenting fa-4x"></i>
		<h3><a href="<?php echo $bl["parseurl"];?>"><?php echo $bl["title"];?></a></h3>
		<p><?php echo $bl["content"];?></p>
		<a href="<?php echo $bl["parseurl"];?>" class="btn btn-primary"><?php echo $tl["general"]["g3"];?></a>
	</div>
</div>

<?php } ?>