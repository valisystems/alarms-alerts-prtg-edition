<?php 

if (JAK_PLUGIN_ACCESS_RETAILER) {

// Functions we need for this plugin
include_once APP_PATH.'plugins/retailer/functions.php';

$JAK_RETAILER_FW = jak_get_retailer('LIMIT 5', $jkv["retailerorder"], '', '', $jkv["retailerurl"], $tl["general"]["g56"]);

 if (isset($JAK_RETAILER_FW) && is_array($JAK_RETAILER_FW)) { ?>

		<h3><?php echo JAK_PLUGIN_NAME_RETAILER;?></h3>
		<ul class="nav nav-pills nav-stacked">
		<?php foreach($JAK_RETAILER_FW as $dfw) { ?>
		<li><a href="<?php echo $dfw["parseurl"];?>"><?php echo $dfw["title"];?></a></li>
		<?php } ?>
		</ul>
		
<?php } } ?>