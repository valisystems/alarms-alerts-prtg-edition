<?php if (JAK_PLUGIN_ACCESS_TICKETING && isset($JAK_TAG_TICKET_DATA) && is_array($JAK_TAG_TICKET_DATA)) foreach($JAK_TAG_TICKET_DATA as $ti) { $count++; ?>

<div class="col-md-3 col-sm-6">
	<div class="service-wrapper">
		<i class="fa fa-ticket fa-4x"></i>
		<h3><a href="<?php echo $ti["parseurl"];?>"><?php echo $ti["title"];?></a></h3>
		<p><?php echo $ti["content"];?></p>
		<a href="<?php echo $ti["parseurl"];?>" class="btn btn-primary"><?php echo $tl["general"]["g3"];?></a>
	</div>
</div>

<?php } ?>