<?php 

if (JAK_PLUGIN_ACCESS_BLOG) {

$JAK_BLOG_CAT = JAK_Base::jakGetcatmix(JAK_PLUGIN_VAR_BLOG, '', DB_PREFIX.'blogcategories', JAK_USERGROUPID, $jkv["blogurl"]);

if ($JAK_BLOG_CAT) { ?>

		<h3><?php echo JAK_PLUGIN_NAME_BLOG.' '.$tlblog["blog"]["d8"];?></h3>
		<ul class="nav nav-pills nav-stacked">
		<?php if (isset($JAK_BLOG_CAT) && is_array($JAK_BLOG_CAT)) foreach($JAK_BLOG_CAT as $c) { ?>
		<li><a href="<?php echo $c["parseurl"];?>"><?php if ($c["catimg"]) { ?><img src="<?php echo BASE_URL.$c["catimg"];?>" alt="sideimg" /><?php } echo $c["name"];?> (<?php echo $c["count"];?>)</a>
		</li>
		<?php } ?>
		</ul>
		
<?php } } ?>