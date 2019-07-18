<?php if (JAK_PLUGIN_ACCESS_BLOG && $JAK_BLOG_ALL) { ?>
<h3><?php echo JAK_PLUGIN_NAME_BLOG;?></h3>
<?php if (isset($JAK_BLOG_ALL) && is_array($JAK_BLOG_ALL)) { ?>
<ul>
<?php foreach($JAK_BLOG_ALL as $bl) { ?>
<li><a href="<?php echo $bl["parseurl"];?>"><?php echo $bl["title"];?></a></li>
<?php } ?>
</ul>
<?php } } ?>