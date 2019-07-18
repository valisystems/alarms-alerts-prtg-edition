<?php if (JAK_PLUGIN_ACCESS_ECOMMERCE && $JAK_ECOMMERCE_ALL) { ?>
<h3><?php echo JAK_PLUGIN_NAME_ECOMMERCE;?></h3>
<?php if (isset($JAK_ECOMMERCE_ALL) && is_array($JAK_ECOMMERCE_ALL)) { ?>
<ul>
<?php foreach($JAK_ECOMMERCE_ALL as $eco) { ?>
<li><a href="<?php echo $eco["parseurl"];?>"><?php echo $eco["title"];?></a></li>
<?php } ?>
</ul>
<?php } } ?>