<?php if (JAK_PLUGIN_ACCESS_FAQ && $JAK_FAQ_ALL) { ?>
<h3><?php echo JAK_PLUGIN_NAME_FAQ;?></h3>
<?php if (isset($JAK_FAQ_ALL) && is_array($JAK_FAQ_ALL)) { ?>
<ul>
<?php foreach($JAK_FAQ_ALL as $dla) { ?>
<li><a href="<?php echo $dla["parseurl"];?>"><?php echo $dla["title"];?></a></li>
<?php } ?>
</ul>
<?php } } ?>