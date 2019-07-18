<?php if (isset($loadslider) || isset($loadsliderside)) { ?>

<script type="text/javascript" src="<?php echo BASE_URL;?>plugins/slider/js/slider.js"></script>
<script type="text/javascript">
$(document).ready(function() {

<?php if (isset($loadslider)) { ?>

	$('#slider').layerSlider({
	 
	    autoStart           : <?php echo $rowls['autostart'];?>,
	    responsive          : <?php echo $rowls['lsresponsive'];?>,
	    sublayerContainer   : 0,
	    firstLayer          : 1,
	    twoWaySlideshow     : false,
	    keybNav             : true,
	    imgPreload          : <?php echo $rowls['imgpreload'];?>,
	    navPrevNext         : <?php echo $rowls['naviprevnext'];?>,
	    navStartStop        : <?php echo $rowls['navibutton'];?>,
	    navButtons          : <?php echo $rowls['navibutton'];?>,
	    skin                : '<?php echo $rowls['lstheme'];?>',
	    skinsPath           : '/plugins/slider/skins/',
	    pauseOnHover        : <?php echo $rowls['pausehover'];?>,
	    globalBGColor       : 'transparent',
	    globalBGImage       : false,
	    animateFirstLayer   : <?php echo $rowls['lsanimatef'];?>,
	    yourLogo            : <?php echo ($rowls['lslogo'] ? "'".$rowls['lslogo']."'" : 'false');?>,
	    yourLogoStyle       : 'position: absolute; z-index: 1001; left: 10px; top: 10px;',
	    yourLogoLink        : <?php echo ($rowls['lslogolink'] ? "'".$rowls['lslogolink']."'" : 'false');?>,
	    yourLogoTarget      : '_blank',
	    loops               : <?php echo $rowls['lsloops'];?>,
	    forceLoopNum        : <?php echo $rowls['lsfloops'];?>,
	    autoPlayVideos      : <?php echo $rowls['lsavideo'];?>,
	    autoPauseSlideshow  : 'auto',
	    youtubePreview      : '<?php echo $rowls['lsyvprev'];?>',
	 
	    // you can change this settings separately by layers or sublayers with using html style attribute
	 
	    slideDirection      : '<?php echo $rowls['lsdirection'];?>',
	    slideDelay          : <?php echo $rowls['lspause'];?>,
	    parallaxIn          : .45,
	    parallaxOut         : .45,
	    durationIn          : 1500,
	    durationOut         : 1500,
	    easingIn            : '<?php echo $rowls['lstransition'];?>',
	    easingOut           : '<?php echo $rowls['lstransitionout'];?>',
	    delayIn             : 0,
	    delayOut            : 0
	 
	});

<?php } if (isset($loadsliderside)) { ?>
		
	$('#sliderside').layerSlider({
	 
	    autoStart           : <?php echo $rsls['autostart'];?>,
	    responsive          : <?php echo $rsls['lsresponsive'];?>,
	    sublayerContainer   : 0,
	    firstLayer          : 1,
	    twoWaySlideshow     : false,
	    keybNav             : true,
	    imgPreload          : <?php echo $rsls['imgpreload'];?>,
	    navPrevNext         : <?php echo $rsls['naviprevnext'];?>,
	    navStartStop        : <?php echo $rsls['navibutton'];?>,
	    navButtons          : <?php echo $rsls['navibutton'];?>,
	    skin                : '<?php echo $rsls['lstheme'];?>',
	    skinsPath           : '/plugins/slider/skins/',
	    pauseOnHover        : <?php echo $rsls['pausehover'];?>,
	    globalBGColor       : 'transparent',
	    globalBGImage       : false,
	    animateFirstLayer   : <?php echo $rsls['lsanimatef'];?>,
	    yourLogo            : <?php echo ($rsls['lslogo'] ? "'".$rsls['lslogo']."'" : 'false');?>,
	    yourLogoStyle       : 'position: absolute; z-index: 1001; left: 10px; top: 10px;',
	    yourLogoLink        : <?php echo ($rsls['lslogolink'] ? "'".$rsls['lslogolink']."'" : 'false');?>,
	    yourLogoTarget      : '_blank',
	    loops               : <?php echo $rsls['lsloops'];?>,
	    forceLoopNum        : <?php echo $rsls['lsfloops'];?>,
	    autoPlayVideos      : <?php echo $rsls['lsavideo'];?>,
	    autoPauseSlideshow  : 'auto',
	    youtubePreview      : '<?php echo $rsls['lsyvprev'];?>',
	 
	    // you can change this settings separately by layers or sublayers with using html style attribute
	 
	    slideDirection      : '<?php echo $rsls['lsdirection'];?>',
	    slideDelay          : <?php echo $rsls['lspause'];?>,
	    parallaxIn          : .45,
	    parallaxOut         : .45,
	    durationIn          : 1500,
	    durationOut         : 1500,
	    easingIn            : '<?php echo $rsls['lstransition'];?>',
	    easingOut           : '<?php echo $rsls['lstransitionout'];?>',
	    delayIn             : 0,
	    delayOut            : 0
	 
	});
		
<?php } ?>
});
</script>
<?php } ?>