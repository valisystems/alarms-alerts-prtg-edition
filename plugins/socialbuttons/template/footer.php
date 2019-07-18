<script type="text/javascript" src="<?php echo BASE_URL;?>plugins/socialbuttons/js/socialbuttons.js"></script>
<script type="text/javascript">

$(document).ready(function() {
	
	$.dpSocialBar({
		items: {
			<?php if ($jkv["sb_twitter"]) { $sb_twitter = explode('::', $jkv["sb_twitter"]);?>
				twitter: { url: '<?php echo $sb_twitter[0];?>', text: '<?php echo $sb_twitter[1];?>' },
			<?php } if ($jkv["sb_facebook"]) { $sb_facebook = explode('::', $jkv["sb_facebook"]);?>
				facebook: { url: '<?php echo $sb_facebook[0];?>', text: '<?php echo $sb_facebook[1];?>' },
			<?php } if ($jkv["sb_google"]) { $sb_google = explode('::', $jkv["sb_google"]);?>
				google: { url: '<?php echo $sb_google[0];?>', text: '<?php echo $sb_google[1];?>' },
			<?php } if ($jkv["sb_skype"]) { $sb_skype = explode('::', $jkv["sb_skype"]);?>
				skype: { url: '<?php echo $sb_skype[0];?>', text: '<?php echo $sb_skype[1];?>' },
			<?php } if ($jkv["sb_youtube"]) { $sb_youtube = explode('::', $jkv["sb_youtube"]);?>
				youtube: { url: '<?php echo $sb_youtube[0];?>', text: '<?php echo $sb_youtube[1];?>' },
			<?php } if ($jkv["sb_vimeo"]) { $sb_vimeo = explode('::', $jkv["sb_vimeo"]);?>
				vimeo: { url: '<?php echo $sb_vimeo[0];?>', text: '<?php echo $sb_vimeo[1];?>' },
			<?php } if ($jkv["sb_linkedin"]) { $sb_linkedin = explode('::', $jkv["sb_linkedin"]);?>
				linkedin: { url: '<?php echo $sb_linkedin[0];?>', text: '<?php echo $sb_linkedin[1];?>' },
			<?php } if ($jkv["sb_flicker"]) { $sb_flicker = explode('::', $jkv["sb_flicker"]);?>
				flickr: { url: '<?php echo $sb_flicker[0];?>', text: '<?php echo $sb_flicker[1];?>' },
			<?php } if ($jkv["sb_orkut"]) { $sb_orkut = explode('::', $jkv["sb_orkut"]);?>
				orkut: { url: '<?php echo $sb_orkut[0];?>', text: '<?php echo $sb_orkut[1];?>' },
			<?php } if ($jkv["sb_myspace"]) { $sb_myspace = explode('::', $jkv["sb_myspace"]);?>
				myspace: { url: '<?php echo $sb_myspace[0];?>', text: '<?php echo $sb_myspace[1];?>' },
			<?php } if ($jkv["sb_digg"]) { $sb_digg = explode('::', $jkv["sb_digg"]);?>
				digg: { url: '<?php echo $sb_digg[0];?>', text: '<?php echo $sb_digg[1];?>' },
			<?php } if ($jkv["sb_lastfm"]) { $sb_lastfm = explode('::', $jkv["sb_lastfm"]);?>
				lastfm: { url: '<?php echo $sb_lastfm[0];?>', text: '<?php echo $sb_lastfm[1];?>' },
			<?php } if ($jkv["sb_delicious"]) { $sb_delicious = explode('::', $jkv["sb_delicious"]);?>
				delicious: { url: '<?php echo $sb_delicious[0];?>', text: '<?php echo $sb_delicious[1];?>' },
			<?php } if ($jkv["sb_tumbler"]) { $sb_tumbler = explode('::', $jkv["sb_tumbler"]);?>
				tumblr: { url: '<?php echo $sb_tumbler[0];?>', text: '<?php echo $sb_tumbler[1];?>' },
			<?php } if ($jkv["sb_picasa"]) { $sb_picasa = explode('::', $jkv["sb_picasa"]);?>
				picasa: { url: '<?php echo $sb_picasa[0];?>', text: '<?php echo $sb_picasa[1];?>' },
			<?php } if ($jkv["sb_reddit"]) { $sb_reddit = explode('::', $jkv["sb_reddit"]);?>
				reddit: { url: '<?php echo $sb_reddit[0];?>', text: '<?php echo $sb_reddit[1];?>' },
			<?php } if ($jkv["sb_technorati"]) { $sb_technorati = explode('::', $jkv["sb_technorati"]);?>
				technorati: { url: '<?php echo $sb_technorati[0];?>', text: '<?php echo $sb_technorati[1];?>' },
			<?php } if ($jkv["sb_rss"]) { $sb_rss = explode('::', $jkv["sb_rss"]);?>
				rss: { url: '<?php echo $sb_rss[0];?>', text: '<?php echo $sb_rss[1];?>' },
			<?php } if ($jkv["sb_contact"]) { $sb_contact = explode('::', $jkv["sb_contact"]);?>
				contact: { url: '<?php echo $sb_contact[0];?>', text: '<?php echo $sb_contact[1];?>' },
			<?php } if ($jkv["sb_website"]) { $sb_web = explode('::', $jkv["sb_website"]);?>
				website: { url: '<?php echo $sb_web[0];?>', text: '<?php echo $sb_web[1];?>' }
			<?php } ?>
		},
		show: <?php echo $jkv["sb_show"];?>,
		move: <?php echo $jkv["sb_move"];?>,
		position: "<?php echo $jkv["sb_position"];?>",
		skin: "<?php echo $jkv["sb_skin"];?>"
	});
	
});

</script>