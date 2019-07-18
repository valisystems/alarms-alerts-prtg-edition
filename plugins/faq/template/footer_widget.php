<?php 

if (JAK_PLUGIN_ACCESS_FAQ) {

// Functions we need for this plugin
include_once APP_PATH.'plugins/faq/functions.php';

$JAK_FAQ_FW = jak_get_faq('LIMIT 3', $jkv["faqorder"], '', '', $jkv["faqurl"], $tl['general']['g56']);

 if (isset($JAK_FAQ_FW) && is_array($JAK_FAQ_FW)) { ?>

		<h3><?php echo JAK_PLUGIN_NAME_FAQ;?></h3>
		<ul class="nav nav-pills nav-stacked">
		<?php foreach($JAK_FAQ_FW as $dfw) { ?>
		<li><a href="<?php echo $dfw["parseurl"];?>"><?php echo $dfw["title"];?></a></li>
		<?php } ?>
		</ul>
		
<?php } } ?>