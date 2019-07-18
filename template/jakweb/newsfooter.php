<?php if ($JAK_GET_NEWS_SORTED) { ?>
		<h3><?php echo JAK_PLUGIN_NAME_NEWS;?></h3>
		<ul class="nav nav-pills nav-stacked">
		<?php if (isset($JAK_GET_NEWS_SORTED) && is_array($JAK_GET_NEWS_SORTED)) foreach($JAK_GET_NEWS_SORTED as $n) { ?>
		<li><a href="<?php echo $n["parseurl"];?>" title="<?php echo $n["contentshort"];?>"><?php echo $n["title"];?> <?php if ($n["showdate"]) echo " (".$n["created"].")";?></a></li>
		<?php } ?>
		</ul>	
<?php } ?>