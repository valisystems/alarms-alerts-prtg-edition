<?php 

if (JAK_PLUGIN_ACCESS_GALLERY) {

if (!$JAK_GALLERY) include_once APP_PATH.'plugins/gallery/functions.php';

// Functions we need for this plugin

$JAK_GALLERY_FOOTER = jak_get_gallery('LIMIT 10', '', '', '', $jkv["galleryurl"], $tl['general']['g56']);

if (isset($JAK_GALLERY_FOOTER) && is_array($JAK_GALLERY_FOOTER)) {

if ($jkv["gallerythumbw"] > 120) { ?>

<h3><?php echo JAK_PLUGIN_NAME_GALLERY;?></h3>
<div class="row" style="height: <?php echo $jkv["gallerythumbh"] + 20;?>px;">
	<div id="gallery_plugin_rotator" class="col-xs-12">
	<?php foreach($JAK_GALLERY_FOOTER as $galfw) { ?>
	<a href="<?php echo $galfw["parseurl"];?>"><img src="<?php echo BASE_URL;?>plugins/gallery/upload<?php echo $galfw["paththumb"];?>" class="img-thumbnail img-responsive" alt="<?php echo $galfw["title"];?>" /></a>
	<?php } ?>
	</div>
</div>


<?php } else {

$JAK_GALLERY_FOOTER1 = array_slice($JAK_GALLERY_FOOTER, 0, 4);
$JAK_GALLERY_FOOTER2 = array_slice($JAK_GALLERY_FOOTER, 5, 9);

?>

<h3><?php echo JAK_PLUGIN_NAME_GALLERY;?></h3>
<div class="row" style="height: <?php echo $jkv["gallerythumbh"] + 20;?>px;">
	<div id="gallery_plugin_rotator" class="col-xs-6">
	<?php foreach($JAK_GALLERY_FOOTER1 as $galfw) { ?>
	<a href="<?php echo $galfw["parseurl"];?>"><img src="<?php echo BASE_URL;?>plugins/gallery/upload<?php echo $galfw["paththumb"];?>" class="img-thumbnail img-responsive" alt="<?php echo $galfw["title"];?>" /></a>
	<?php } ?>
	</div>

	<div id="gallery_plugin_rotator2" class="col-xs-6">
	<?php foreach($JAK_GALLERY_FOOTER2 as $galfw2) { ?>
	<a href="<?php echo $galfw2["parseurl"];?>"><img src="<?php echo BASE_URL;?>plugins/gallery/upload<?php echo $galfw2["paththumb"];?>" class="img-thumbnail img-responsive" alt="<?php echo $galfw2["title"];?>" /></a>
	<?php } ?>
	</div>
</div>

<?php } ?>
		
<script src="<?php echo BASE_URL;?>plugins/gallery/js/cycle.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('#gallery_plugin_rotator').cycle({ 
	    fx:     'fade', 
	    speed:  'fast', 
	    timeout: 5000
	});
	$('#gallery_plugin_rotator2').cycle({ 
	    fx:     'fade', 
	    speed:  'fast', 
	    timeout: 6000
	});
});
</script>
		
<?php } } ?>