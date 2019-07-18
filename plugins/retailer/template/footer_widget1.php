<?php 

if (JAK_PLUGIN_ACCESS_RETAILER) {

$JAK_RETAILER_CAT = JAK_Base::jakGetcatmix(JAK_PLUGIN_VAR_RETAILER, '', DB_PREFIX.'retailercategories', JAK_USERGROUPID, $jkv["retailerurl"]);

if ($JAK_RETAILER_CAT) {  } ?>
	<?php if (isset($JAK_RETAILER_CAT) && is_array($JAK_RETAILER_CAT)) foreach($JAK_RETAILER_CAT as $carray) { 
		
		$catexistid = array($carray["catparent"]);
		
	} ?>

		<h3><?php echo JAK_PLUGIN_NAME_RETAILER.' '.$tld["dload"]["d8"];?></h3>
		<ul class="nav nav-pills nav-stacked">
		<?php if (isset($JAK_RETAILER_CAT) && is_array($JAK_RETAILER_CAT)) foreach($JAK_RETAILER_CAT as $c) { ?>
		<?php if ($c["catparent"] == 0) { ?>
		<li><a href="<?php echo $c["parseurl"];?>"><?php if ($c["catimg"]) { ?><img src="<?php echo BASE_URL.$c["catimg"];?>" alt="sideimg" /><?php } echo $c["name"];?> (<?php echo $c["count"];?>)</a>
		<?php if ($catexistid) { ?>
		<ul class="nav nav-pills nav-stacked">
		<?php if (isset($JAK_RETAILER_CAT) && is_array($JAK_RETAILER_CAT)) foreach($JAK_RETAILER_CAT as $c1) { ?>
		<?php if ($c1["catparent"] != '0' && $c1["catparent"] == $c["id"]) { ?>
		<li><a href="<?php echo $c1["parseurl"];?>"><?php if ($c1["catimg"]) { ?><img src="<?php echo BASE_URL.$c1["catimg"];?>" alt="sideimg" /> <?php } echo $c1["name"];?> (<?php echo $c1["count"];?>)</a></li>
		<?php } } ?>
		</ul>
		</li>
		<?php } } ?>
		</ul>
		
<?php } } ?>