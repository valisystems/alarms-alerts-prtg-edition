<?php if (JAK_PLUGIN_ACCESS_FAQ) {

$JAK_FAQ_CAT = JAK_Base::jakGetcatmix(JAK_PLUGIN_VAR_FAQ, '', DB_PREFIX.'faqcategories', JAK_USERGROUPID, $jkv["faqurl"]);

if ($JAK_FAQ_CAT) { ?>
<aside class="sidebar">

		<h4><?php echo JAK_PLUGIN_NAME_FAQ.' '.$tlf["faq"]["d8"];?></h4>
		<ul class="categories">
		<?php if (isset($JAK_FAQ_CAT) && is_array($JAK_FAQ_CAT)) foreach($JAK_FAQ_CAT as $c) { ?>
		<?php if ($c["catparent"] == 0) { ?>
		<li><a href="<?php echo $c["parseurl"];?>" title="<?php echo strip_tags($c["content"]);?>"><?php if ($c["catimg"]) { ?><i class="fa <?php echo $c["catimg"];?> fa-fw"></i> <?php } echo $c["name"];?></a> (<?php echo $c["count"];?>)
		<ul>
		<?php if (isset($JAK_FAQ_CAT) && is_array($JAK_FAQ_CAT)) foreach($JAK_FAQ_CAT as $c1) { ?>
		<?php if ($c1["catparent"] != '0' && $c1["catparent"] == $c["id"]) { ?>
		<li><a href="<?php echo $c1["parseurl"];?>" title="<?php echo strip_tags($c1["content"]);?>"><?php if ($c1["catimg"]) { ?><i class="fa <?php echo $c1["catimg"];?> fa-fw"></i> <?php } echo $c1["name"];?></a> (<?php echo $c1["count"];?>)</li>
		<?php } } ?>
		</ul>
		</li>
		<?php } } ?>
		</ul>
	<hr>
</aside>
<?php  } } ?>