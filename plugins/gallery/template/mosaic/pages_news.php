<?php include_once APP_PATH.'plugins/gallery/functions.php';

	$showgalleryarray = explode(":", $row['showgallery']);
	
	if (is_array($showgalleryarray) && in_array("ASC", $showgalleryarray) || in_array("DESC", $showgalleryarray)) {
	
		$JAK_GALLERY = jak_get_gallery('LIMIT '.$showgalleryarray[1], 't1.id '.$showgalleryarray[0], $showgalleryarray[2], 't1.catid', $jkv["galleryurl"], $tl['general']['g56']);
		
	} else {

		$JAK_GALLERY = jak_get_gallery('', 't1.id ASC', $row['showgallery'], 't1.id', $jkv["galleryurl"], $tl['general']['g56']);
	}
	
	$gallery_link = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_GALLERY, '', '', '', '');

?>

<hr>
<h3 class="text-color"><?php echo JAK_PLUGIN_NAME_GALLERY;?></h3>

<?php if (isset($JAK_GALLERY) && is_array($JAK_GALLERY)) { foreach($JAK_GALLERY as $gal) { ?>

	<?php if ($gal["paththumb"]) { ?>
		<figure style="float: left;margin: 0 10px 15px 0;clear: none;text-align:center;">
		    <p><a<?php if (JAK_GALLERYOPENATTACHED) { ?> class="lightbox" href="<?php echo BASE_URL.'plugins/gallery/upload'.$gal["pathbig"];?>"<?php } else { ?> href="<?php echo $gal["parseurl"];?>"<?php } ?>><img src="<?php echo BASE_URL.'plugins/gallery/upload'.$gal["paththumb"];?>" class="img-rounded" alt="gallery-thumbnail" /></a></p>
		    <?php if (JAK_GALLERYOPENATTACHED) { ?>
		    <p><a class="btn btn-info btn-xs" href="<?php echo $gal["parseurl"];?>"><?php echo $tlgal["gallery"]["d12"];?></a></p>
		    <?php } ?>
		</figure>
	<?php } ?>

<?php } ?>

<div class="clearfix"></div><div class="well well-sm"><a href="<?php echo $gallery_link;?>"><?php echo $tlgal["gallery"]["d11"];?></a></div><hr>

<?php } ?>