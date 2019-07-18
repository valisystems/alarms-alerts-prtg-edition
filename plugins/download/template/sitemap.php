<?php if (JAK_PLUGIN_ACCESS_DOWNLOAD && $JAK_DOWNLOAD_ALL) { ?>
<h3><?php echo JAK_PLUGIN_NAME_DOWNLOAD;?></h3>
<?php if (isset($JAK_DOWNLOAD_ALL) && is_array($JAK_DOWNLOAD_ALL)) { ?>
<ul>
<?php foreach($JAK_DOWNLOAD_ALL as $dla) { ?>
<li><a href="<?php echo $dla["parseurl"];?>"><?php echo $dla["title"];?></a></li>
<?php } ?>
</ul>
<?php } } ?>