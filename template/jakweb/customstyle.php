<?php if ($jkv["color_jakweb_tpl"] == "dark") { ?>
<link rel="stylesheet" href="<?php echo BASE_URL;?>template/jakweb/css/screendark.css?=<?php echo $jkv["updatetime"];?>" id="tpljakweb" type="text/css" />
<?php } else { ?>
<link rel="stylesheet" href="<?php echo BASE_URL;?>template/jakweb/css/screen.css?=<?php echo $jkv["updatetime"];?>" id="tpljakweb" type="text/css" />
<?php } ?>

<?php if ($jkv["theme_jakweb_tpl"]) { ?>
<link rel="stylesheet" href="<?php echo BASE_URL;?>template/jakweb/css/themes/<?php echo $jkv["theme_jakweb_tpl"];?>.css?=<?php echo $jkv["updatetime"];?>" type="text/css" class="sctheme" />
<?php } ?>

<?php if ($jkv["fontg_jakweb_tpl"] != "NonGoogle") { ?>
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=<?php echo $jkv["fontg_jakweb_tpl"];?>:regular,italic,bold,bolditalic" type="text/css" />
<?php } ?>

<style type="text/css">
	h1, h2, h3, h4, h5, h6 { font-family:<?php if ($jkv["fontg_jakweb_tpl"] != "NonGoogle") echo '"'.str_replace("+", " ", $jkv["fontg_jakweb_tpl"]).'", '; echo $jkv["font_jakweb_tpl"];?>; }
	body, code, input[type="text"], textarea { font-family:<?php echo $jkv["font_jakweb_tpl"];?>; }
	
	<?php if ($jkv["mainbg_jakweb_tpl"]) { ?>
	body, #sb-site {
		background-image: none;
		background-color: <?php echo $jkv["mainbg_jakweb_tpl"];?>;
	}
	<?php } if (!$jkv["mainbg_jakweb_tpl"] && $jkv["pattern_jakweb_tpl"]) { ?>
	body, #sb-site {
		background-image: url("<?php echo BASE_URL;?>template/jakweb/img/patterns/<?php echo $jkv["pattern_jakweb_tpl"];?>.png");
	}
	<?php } if (!$jkv["navbarstyle_jakweb_tpl"]) { ?>
		#sb-site {
			margin-top: 0;
		}
		.navbar {
			margin-bottom: 0;
		}
	<?php } if ($jkv["boxpattern_jakweb_tpl"]) { ?>
	.boxed-layout {
		background-image: url("<?php echo BASE_URL;?>template/jakweb/img/patterns/<?php echo $jkv["boxpattern_jakweb_tpl"];?>.png");
	}
	<?php } if ($jkv["boxbg_jakweb_tpl"]) { ?>
	.boxed-layout {
		background: <?php echo $jkv["boxbg_jakweb_tpl"];?>;
	}
	<?php } if ($jkv["navbarcolor_jakweb_tpl"]) { ?>
	.navbar {
		background: <?php echo $jkv["navbarcolor_jakweb_tpl"];?>;
	}
	<?php } if ($jkv["navbarlinkcolor_jakweb_tpl"]) { ?>
	.navbar a {
		color: <?php echo $jkv["navbarlinkcolor_jakweb_tpl"];?> !important;
	}
	<?php } if ($jkv["navbarcolorlinkbg_jakweb_tpl"]) { ?>
	.navbar-default .navbar-nav > .active > a, ul.nav-main ul.dropdown-menu li:hover > a {
		background: <?php echo $jkv["navbarcolorlinkbg_jakweb_tpl"];?>;
	}
	<?php } if ($jkv["navbarcolorsubmenu_jakweb_tpl"]) { ?>
	ul.nav-main ul.dropdown-menu {
		background: <?php echo $jkv["navbarcolorsubmenu_jakweb_tpl"];?>;
	}
	<?php } if ($jkv["sectionbg_jakweb_tpl"]) { ?>
	.section-white {
		background: <?php echo $jkv["sectionbg_jakweb_tpl"];?>;
	}
	<?php } if ($jkv["sectiontc_jakweb_tpl"]) { ?>
	.section-white h3 {
		background: <?php echo $jkv["sectiontc_jakweb_tpl"];?>;
	}
	<?php } if ($jkv["footerc_jakweb_tpl"]) { ?>
	.footer {
		background: <?php echo $jkv["footerc_jakweb_tpl"];?>;
	}
	<?php } if ($jkv["footercte_jakweb_tpl"]) { ?>
	.footer {
		color: <?php echo $jkv["footercte_jakweb_tpl"];?>;
	}
	<?php } if ($jkv["footerct_jakweb_tpl"]) { ?>
	.footer h3 {
		color: <?php echo $jkv["footerct_jakweb_tpl"];?>;
	}
	<?php } ?>
	
</style>