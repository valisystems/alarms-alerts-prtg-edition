<?php if (isset($JAK_SEARCH_RESULT_BLOG) && is_array($JAK_SEARCH_RESULT_BLOG)) foreach($JAK_SEARCH_RESULT_BLOG as $bl) { $count++; ?>

<div class="col-md-3 col-sm-6">
	<div class="service-wrapper">
		<i class="fa fa-commenting fa-4x"></i>
		<h3><a href="<?php echo $bl["parseurl"];?>"><?php echo $bl["title"];?></a></h3>
		<p><?php echo $bl["content"];?></p>
		<a href="<?php echo $bl["parseurl"];?>" class="btn btn-primary"><?php echo $tl["general"]["g3"];?></a>
	</div>
</div>

<?php } ?>