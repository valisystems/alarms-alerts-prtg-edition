<?php 

if (JAK_PLUGIN_ACCESS_TICKETING) {

if (!defined('JAK_TICKETMODERATE')) define('JAK_TICKETMODERATE', $jakusergroup->getVar("ticketmoderate"));

// Functions we need for this plugin
include_once APP_PATH.'plugins/ticketing/functions.php';

$JAK_TICKET_FW = jak_get_ticket('LIMIT 3', $jkv["ticketorder"], '', '', $jkv["ticketurl"], $tl['general']['g56']);

 if (isset($JAK_TICKET_FW) && is_array($JAK_TICKET_FW)) { ?>

		<h3><?php echo JAK_PLUGIN_NAME_TICKETING;?></h3>
		<ul class="nav nav-pills nav-stacked">
		<?php foreach($JAK_TICKET_FW as $fti) { ?>
		<li><a href="<?php echo $fti["parseurl"];?>"><?php echo $fti["title"];?></a></li>
		<?php } ?>
		</ul>
		
<?php } } ?>