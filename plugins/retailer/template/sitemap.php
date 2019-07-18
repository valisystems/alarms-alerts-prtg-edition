<?php if (JAK_PLUGIN_ACCESS_RETAILER && $JAK_RETAILER_ALL) { ?>
<h3><?php echo JAK_PLUGIN_NAME_RETAILER;?></h3>
<?php if (isset($JAK_RETAILER_ALL) && is_array($JAK_RETAILER_ALL)) { ?>
<ul>
<?php foreach($JAK_RETAILER_ALL as $ret) { ?>
<li><a href="<?php echo $ret["parseurl"];?>"><?php echo $ret["title"];?></a></li>
<?php } ?>
</ul>
<?php } } ?>