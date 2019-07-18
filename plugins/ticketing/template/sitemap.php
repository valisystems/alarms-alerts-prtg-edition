<?php if (JAK_PLUGIN_ACCESS_TICKETING && $JAK_TICKET_ALL) { ?>
<h3><?php echo JAK_PLUGIN_NAME_TICKETING;?></h3>
<?php if (isset($JAK_TICKET_ALL) && is_array($JAK_TICKET_ALL)) { ?>
<ul>
<?php foreach($JAK_TICKET_ALL as $ti) { ?>
<li><a href="<?php echo $ti["parseurl"];?>"><?php echo $ti["title"];?></a></li>
<?php } ?>
</ul>
<?php } } ?>