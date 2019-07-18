<?php 

if (JAK_PLUGIN_ACCESS_BLOG) {

// Functions we need for this plugin
include_once APP_PATH.'plugins/blog/functions.php';

$JAK_BLOG_FW = jak_get_blog('LIMIT 3', $jkv["blogorder"], '', '', $jkv["blogurl"], $tl['general']['g56']);

 if (isset($JAK_BLOG_FW) && is_array($JAK_BLOG_FW)) { ?>

		<h3><?php echo JAK_PLUGIN_NAME_BLOG;?></h3>
		<ul class="nav nav-pills nav-stacked">
		<?php foreach($JAK_BLOG_FW as $bfw) { ?>
		<li><a href="<?php echo $bfw["parseurl"];?>"><?php echo $bfw["title"];?></a></li>
		<?php } ?>
		</ul>
		
<?php } } ?>