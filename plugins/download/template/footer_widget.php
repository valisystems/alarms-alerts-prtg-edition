<?php 

if (JAK_PLUGIN_ACCESS_DOWNLOAD) {

// Functions we need for this plugin
include_once APP_PATH.'plugins/download/functions.php';

$JAK_DOWNLOAD_FW = jak_get_download('LIMIT 3', $jkv["downloadorder"], '', '', $jkv["downloadurl"], $tl['general']['g56']);

 if (isset($JAK_DOWNLOAD_FW) && is_array($JAK_DOWNLOAD_FW)) { ?>

		<h3><?php echo JAK_PLUGIN_NAME_DOWNLOAD;?></h3>
		<ul class="nav nav-pills nav-stacked">
		<?php foreach($JAK_DOWNLOAD_FW as $dfw) { ?>
		<li><a href="<?php echo $dfw["parseurl"];?>"><?php echo $dfw["title"];?></a></li>
		<?php } ?>
		</ul>
		
<?php } } ?>