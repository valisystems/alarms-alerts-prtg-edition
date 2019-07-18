<?php if (isset($JAK_SEARCH_RESULT_GALLERY) && is_array($JAK_SEARCH_RESULT_GALLERY)) foreach($JAK_SEARCH_RESULT_GALLERY as $gal) { $count++; ?>

<div class="col-md-3 col-sm-6">
	<div class="service-wrapper">
		<i class="fa fa-picture-o fa-4x"></i>
		<h3><a href="<?php echo $gal["parseurl"];?>"><?php echo $gal["title"];?></a></h3>
		<p><?php echo $gal["content"];?></p>
		<a href="<?php echo $gal["parseurl"];?>" class="btn btn-primary"><?php echo $tl["general"]["g3"];?></a>
	</div>
</div>

<?php } ?>