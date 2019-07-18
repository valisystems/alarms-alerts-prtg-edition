<?php if ($JAK_GROWL_SHOW) { ?>
<script src="<?php echo BASE_URL;?>plugins/growl/js/gritter.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('head').append('<link rel="stylesheet" href="<?php echo BASE_URL;?>plugins/growl/css/style.css?=<?php echo $jkv["updatetime"];?>" type="text/css" />');
});
</script>
<?php

if (is_array($JAK_ALL_GROWL)) foreach ($JAK_ALL_GROWL as $suball) { if (($suball['startdate'] == 0 || $suball['startdate'] <= time()) && ($suball['enddate'] == 0 || $suball['enddate'] >= time()) && (jak_get_access(JAK_USERGROUPID, $suball['permission']) || $suball['permission'] == 0)) { ?>
    
    	<script type="text/javascript">
    	$(document).ready(function() {
    	<?php if ($suball['remember']) { ?>
    		if (!getCookie('growl_<?php echo $suball['id'];?>')) {
    	<?php } ?>
    			var allgrowl = $.gritter.add({
    				// (string | mandatory) the heading of the notification
    				title: <?php echo json_encode(base64_decode($suball['title']));?>,
    				// (string | mandatory) the text inside the notification
    				text: <?php echo json_encode(base64_decode($suball['content']));?>,
    				// (string | optional) the image to display on the left
    				<?php if ($suball['previmg']) { ?>
    				image: '<?php echo $suball['previmg'];?>',
    				<?php } ?>
    				// (bool | optional) if you want it to fade out on its own or just sit there
    				sticky: <?php echo ($suball['sticky'] ? 'true' : 'false');?>, 
    				// (int | optional) the time you want it to be alive for before fading out (milliseconds)
    				time: <?php echo $suball['duration'];?>
    				// (string | optional) the class name you want to apply directly to the notification for custom styling
    				<?php if (!$suball['color']) { ?>
    				,class_name: 'gritter-light'
    				<?php } ?>
    			    // (function | optional) function called before it opens
    			    <?php if ($suball['remember']) { ?>   
    				// (function | optional) function called after it closes
    				,after_close: function(){
    					setCookie('growl_<?php echo $suball['id'];?>', 1, <?php echo $suball['remembertime'];?>);
    				}
    				<?php } ?>
    			});
    	<?php if ($suball['remember']) { ?>
    		}
    	<?php } ?>
    	});
    			$.extend($.gritter.options, { 
    			        position: '<?php echo $suball['position'];?>',
    			        fade_in_speed: 'medium', // how fast notifications fade in (string or int)
    			        fade_out_speed: 500 // how fast the notices fade out
    			});
    	</script>
   
    <?php } }

// Let's check if there is a valid Page array
if (!$page1 && is_array($JAK_PAGE_GROWL) && array_key_exists($PAGE_ID, $JAK_PAGE_GROWL)) foreach ($JAK_PAGE_GROWL as $subp) { if (($subp['startdate'] == 0 || $subp['startdate'] <= time()) && ($subp['enddate'] == 0 || $subp['enddate'] >= time()) && $subp['pageid'] == $PAGE_ID && (jak_get_access(JAK_USERGROUPID, $subp['permission']) || $subp['permission'] == 0)) { ?>
     
     	<script type="text/javascript">
     	$(document).ready(function() {
     	<?php if ($subp['remember']) { ?>
     		if (!getCookie('growl_<?php echo $subp['id'];?>')) {
     	<?php } ?>
     			var pagegrowl = $.gritter.add({
     				// (string | mandatory) the heading of the notification
     				title: <?php echo json_encode(base64_decode($subp['title']));?>,
     				// (string | mandatory) the text inside the notification
     				text: <?php echo json_encode(base64_decode($subp['content']));?>,
     				// (string | optional) the image to display on the left
     				<?php if ($subp['previmg']) { ?>
     				image: '<?php echo $subp['previmg'];?>',
     				<?php } ?>
     				// (bool | optional) if you want it to fade out on its own or just sit there
     				sticky: <?php echo ($subp['sticky'] ? 'true' : 'false');?>, 
     				// (int | optional) the time you want it to be alive for before fading out (milliseconds)
     				time: <?php echo $subp['duration'];?>
     				// (string | optional) the class name you want to apply directly to the notification for custom styling
     				<?php if (!$subp['color']) { ?>
     				,class_name: 'gritter-light'
     				<?php } ?>
     			    // (function | optional) function called before it opens
     			    <?php if ($subp['remember']) { ?>   
     				// (function | optional) function called after it closes
     				,after_close: function(){
     					setCookie('growl_<?php echo $subp['id'];?>', 1, <?php echo $subp['remembertime'];?>);
     				}
     				<?php } ?>
     			});
     	<?php if ($subp['remember']) { ?>
     		}
     	<?php } ?>
     	});
     			$.extend($.gritter.options, { 
     			        position: '<?php echo $subp['position'];?>',
     			        fade_in_speed: 'medium', // how fast notifications fade in (string or int)
     			        fade_out_speed: 500 // how fast the notices fade out
     			});
     	</script>
    
     <?php }
}

// Let's check if there is a valid News array
if ($backtonews && is_array($JAK_NEWS_GROWL) && array_key_exists($PAGE_ID, $JAK_NEWS_GROWL)) foreach ($JAK_NEWS_GROWL as $subn) { if (($subn['startdate'] == 0 || $subn['startdate'] <= time()) && ($subn['enddate'] == 0 || $subn['enddate'] >= time()) && $subn['newsid'] == $PAGE_ID && (jak_get_access(JAK_USERGROUPID, $subn['permission']) || $subn['permission'] == 0)) { ?>
     
     	<script type="text/javascript">
     	$(document).ready(function() {
     	<?php if ($subn['remember']) { ?>
     		if (!getCookie('growl_<?php echo $subn['id'];?>')) {
     	<?php } ?>
     			var newsgrowl = $.gritter.add({
     				// (string | mandatory) the heading of the notification
     				title: <?php echo json_encode(base64_decode($subn['title']));?>,
     				// (string | mandatory) the text inside the notification
     				text: <?php echo json_encode(base64_decode($subn['content']));?>,
     				// (string | optional) the image to display on the left
     				<?php if ($subn['previmg']) { ?>
     				image: '<?php echo $subn['previmg'];?>',
     				<?php } ?>
     				// (bool | optional) if you want it to fade out on its own or just sit there
     				sticky: <?php echo ($subn['sticky'] ? 'true' : 'false');?>, 
     				// (int | optional) the time you want it to be alive for before fading out (milliseconds)
     				time: <?php echo $subn['duration'];?>
     				// (string | optional) the class name you want to apply directly to the notification for custom styling
     				<?php if (!$subn['color']) { ?>
     				,class_name: 'gritter-light'
     				<?php } ?>
     			    // (function | optional) function called before it opens
     			    <?php if ($subn['remember']) { ?>   
     				// (function | optional) function called after it closes
     				,after_close: function(){
     					setCookie('growl_<?php echo $subn['id'];?>', 1, <?php echo $subn['remembertime'];?>);
     				}
     				<?php } ?>
     			});
     	<?php if ($subn['remember']) { ?>
     		}
     	<?php } ?>
     	});
     			$.extend($.gritter.options, { 
     			        position: '<?php echo $subn['position'];?>',
     			        fade_in_speed: 'medium', // how fast notifications fade in (string or int)
     			        fade_out_speed: 500 // how fast the notices fade out
     			});
     	</script>
    
     <?php }
}

// Let's check if there is a valid News Main array
if ($backtonews && !$page1 && is_array($JAK_NEWSMAIN_GROWL)) foreach ($JAK_NEWSMAIN_GROWL as $submn) { if (($submn['startdate'] == 0 || $submn['startdate'] <= time()) && ($submn['enddate'] == 0 || $submn['enddate'] >= time()) && $submn['newsmain'] == 1 && (jak_get_access(JAK_USERGROUPID, $submn['permission']) || $submn['permission'] == 0)) { ?>
     
     	<script type="text/javascript">
     	$(document).ready(function() {
     	<?php if ($submn['remember']) { ?>
     		if (!getCookie('growl_<?php echo $submn['id'];?>')) {
     	<?php } ?>
     			var newsmaingrowl = $.gritter.add({
     				// (string | mandatory) the heading of the notification
     				title: <?php echo json_encode(base64_decode($submn['title']));?>,
     				// (string | mandatory) the text inside the notification
     				text: <?php echo json_encode(base64_decode($submn['content']));?>,
     				// (string | optional) the image to display on the left
     				<?php if ($submn['previmg']) { ?>
     				image: '<?php echo $submn['previmg'];?>',
     				<?php } ?>
     				// (bool | optional) if you want it to fade out on its own or just sit there
     				sticky: <?php echo ($submn['sticky'] ? 'true' : 'false');?>, 
     				// (int | optional) the time you want it to be alive for before fading out (milliseconds)
     				time: <?php echo $submn['duration'];?>
     				// (string | optional) the class name you want to apply directly to the notification for custom styling
     				<?php if (!$submn['color']) { ?>
     				,class_name: 'gritter-light'
     				<?php } ?>
     			    // (function | optional) function called before it opens
     			    <?php if ($submn['remember']) { ?>   
     				// (function | optional) function called after it closes
     				,after_close: function(){
     					setCookie('growl_<?php echo $submn['id'];?>', 1, <?php echo $submn['remembertime'];?>);
     				}
     				<?php } ?>
     			});
     	<?php if ($submn['remember']) { ?>
     		}
     	<?php } ?>
     	});
     			$.extend($.gritter.options, { 
     			        position: '<?php echo $submn['position'];?>',
     			        fade_in_speed: 'medium', // how fast notifications fade in (string or int)
     			        fade_out_speed: 500 // how fast the notices fade out
     			});
     	</script>
    
     <?php }
}

// Let's check if there is a valid Tags array and if the user has access to tags
if ($page == JAK_PLUGIN_VAR_TAGS && is_array($JAK_TAGS_GROWL) && JAK_USER_TAGS) foreach ($JAK_TAGS_GROWL as $subt) { if (($subt['startdate'] == 0 || $subt['startdate'] <= time()) && ($subt['enddate'] == 0 || $subt['enddate'] >= time()) && $subt['tags'] == 1 && (jak_get_access(JAK_USERGROUPID, $subt['permission']) || $subt['permission'] == 0)) { ?>
     
     	<script type="text/javascript">
     	$(document).ready(function() {
     	<?php if ($subt['remember']) { ?>
     		if (!getCookie('growl_<?php echo $subt['id'];?>')) {
     	<?php } ?>
     			var tagsgrowl = $.gritter.add({
     				// (string | mandatory) the heading of the notification
     				title: <?php echo json_encode(base64_decode($subt['title']));?>,
     				// (string | mandatory) the text inside the notification
     				text: <?php echo json_encode(base64_decode($subt['content']));?>,
     				// (string | optional) the image to display on the left
     				<?php if ($subt['previmg']) { ?>
     				image: '<?php echo $subt['previmg'];?>',
     				<?php } ?>
     				// (bool | optional) if you want it to fade out on its own or just sit there
     				sticky: <?php echo ($subt['sticky'] ? 'true' : 'false');?>, 
     				// (int | optional) the time you want it to be alive for before fading out (milliseconds)
     				time: <?php echo $subt['duration'];?>
     				// (string | optional) the class name you want to apply directly to the notification for custom styling
     				<?php if (!$subt['color']) { ?>
     				,class_name: 'gritter-light'
     				<?php } ?>
     			    // (function | optional) function called before it opens
     			    <?php if ($subt['remember']) { ?>   
     				// (function | optional) function called after it closes
     				,after_close: function(){
     					setCookie('growl_<?php echo $subt['id'];?>', 1, <?php echo $subt['remembertime'];?>);
     				}
     				<?php } ?>
     			});
     	<?php if ($subt['remember']) { ?>
     		}
     	<?php } ?>
     	});
     			$.extend($.gritter.options, { 
     			        position: '<?php echo $subt['position'];?>',
     			        fade_in_speed: 'medium', // how fast notifications fade in (string or int)
     			        fade_out_speed: 500 // how fast the notices fade out
     			});
     	</script>
    
     <?php }
}

// Let's check if there is a valid Search array
if ($page == $tl['link']['l2'] && is_array($JAK_SEARCH_GROWL)) foreach ($JAK_SEARCH_GROWL as $subs) { if (($subs['startdate'] == 0 || $subs['startdate'] <= time()) && ($subs['enddate'] == 0 || $subs['enddate'] >= time()) && $subs['search'] == 1 && (jak_get_access(JAK_USERGROUPID, $subs['permission']) || $subs['permission'] == 0)) { ?>
     
     	<script type="text/javascript">
     	$(document).ready(function() {
     	<?php if ($subs['remember']) { ?>
     		if (!getCookie('growl_<?php echo $subs['id'];?>')) {
     	<?php } ?>
     			var searchgrowl = $.gritter.add({
     				// (string | mandatory) the heading of the notification
     				title: <?php echo json_encode(base64_decode($subs['title']));?>,
     				// (string | mandatory) the text inside the notification
     				text: <?php echo json_encode(base64_decode($subs['content']));?>,
     				// (string | optional) the image to display on the left
     				<?php if ($subs['previmg']) { ?>
     				image: '<?php echo $subs['previmg'];?>',
     				<?php } ?>
     				// (bool | optional) if you want it to fade out on its own or just sit there
     				sticky: <?php echo ($subs['sticky'] ? 'true' : 'false');?>, 
     				// (int | optional) the time you want it to be alive for before fading out (milliseconds)
     				time: <?php echo $subs['duration'];?>
     				// (string | optional) the class name you want to apply directly to the notification for custom styling
     				<?php if (!$subs['color']) { ?>
     				,class_name: 'gritter-light'
     				<?php } ?>
     			    // (function | optional) function called before it opens
     			    <?php if ($subs['remember']) { ?>   
     				// (function | optional) function called after it closes
     				,after_close: function(){
     					setCookie('growl_<?php echo $subs['id'];?>', 1, <?php echo $subs['remembertime'];?>);
     				}
     				<?php } ?>
     			});
     	<?php if ($subs['remember']) { ?>
     		}
     	<?php } ?>
     	});
     			$.extend($.gritter.options, { 
     			        position: '<?php echo $subs['position'];?>',
     			        fade_in_speed: 'medium', // how fast notifications fade in (string or int)
     			        fade_out_speed: 500 // how fast the notices fade out
     			});
     	</script>
    
     <?php }
}

// Let's check if there is a valid Sitemap array
if ($page == JAK_PLUGIN_VAR_SITEMAP && is_array($JAK_SITEMAP_GROWL)) foreach ($JAK_SITEMAP_GROWL as $subsit) { if (($subsit['startdate'] == 0 || $subsit['startdate'] <= time()) && ($subsit['enddate'] == 0 || $subsit['enddate'] >= time()) && $subsit['sitemap'] == 1 && (jak_get_access(JAK_USERGROUPID, $subsit['permission']) || $subsit['permission'] == 0)) { ?>
     
     	<script type="text/javascript">
     	$(document).ready(function() {
     	<?php if ($subsit['remember']) { ?>
     		if (!getCookie('growl_<?php echo $subsit['id'];?>')) {
     	<?php } ?>
     			var sitemapgrowl = $.gritter.add({
     				// (string | mandatory) the heading of the notification
     				title: <?php echo json_encode(base64_decode($subsit['title']));?>,
     				// (string | mandatory) the text inside the notification
     				text: <?php echo json_encode(base64_decode($subsit['content']));?>,
     				// (string | optional) the image to display on the left
     				<?php if ($subsit['previmg']) { ?>
     				image: '<?php echo $subsit['previmg'];?>',
     				<?php } ?>
     				// (bool | optional) if you want it to fade out on its own or just sit there
     				sticky: <?php echo ($subsit['sticky'] ? 'true' : 'false');?>, 
     				// (int | optional) the time you want it to be alive for before fading out (milliseconds)
     				time: <?php echo $subsit['duration'];?>
     				// (string | optional) the class name you want to apply directly to the notification for custom styling
     				<?php if (!$subsit['color']) { ?>
     				,class_name: 'gritter-light'
     				<?php } ?>
     			    // (function | optional) function called before it opens
     			    <?php if ($subsit['remember']) { ?>   
     				// (function | optional) function called after it closes
     				,after_close: function(){
     					setCookie('growl_<?php echo $subsit['id'];?>', 1, <?php echo $subsit['remembertime'];?>);
     				}
     				<?php } ?>
     			});
     	<?php if ($subsit['remember']) { ?>
     		}
     	<?php } ?>
     	});
     			$.extend($.gritter.options, { 
     			        position: '<?php echo $subsit['position'];?>',
     			        fade_in_speed: 'medium', // how fast notifications fade in (string or int)
     			        fade_out_speed: 500 // how fast the notices fade out
     			});
     	</script>
    
     <?php }
}

}
?>