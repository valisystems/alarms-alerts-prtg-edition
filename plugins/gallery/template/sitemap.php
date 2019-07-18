<?php if (JAK_PLUGIN_ACCESS_GALLERY && $JAK_GALLERY_ALL) { ?>
<h3><?php echo JAK_PLUGIN_NAME_GALLERY;?></h3>
<?php if (isset($JAK_GALLERY_ALL) && is_array($JAK_GALLERY_ALL)) { ?>
<ul>
<?php foreach($JAK_GALLERY_ALL as $gal) { ?>
<li><a href="<?php echo $gal["parseurl"];?>"><?php echo $gal["title"];?></a></li>
<?php } ?>
</ul>
<?php } } ?>