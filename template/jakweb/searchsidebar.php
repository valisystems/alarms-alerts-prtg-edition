<?php if (JAK_SEARCH && JAK_USER_SEARCH && $page != 'search') { ?>
<aside class="sidebar">
		<h4><?php echo $tl["title"]["t2"];?></h4>
		
		<form id="ajaxsearchForm" action="<?php echo $P_SEAERCH_LINK;?>" method="post">
			<div class="input-group">
			      <input type="text" name="jakSH" id="Jajaxs" class="form-control" placeholder="<?php echo $tl["search"]["s"]; if ($jkv["fulltextsearch"]) echo $tl["search"]["s5"];?>">
			      <span class="input-group-btn">
			        <button type="submit" class="btn btn-primary" name="search" id="JajaxSubmitSearch"><?php echo $tl["general"]["g83"];?></button>
			      </span>
			 </div><!-- /input-group -->
		  <?php if ($jkv["ajaxsearch"] && $AJAX_SEARCH_PLUGIN_URL) { ?>
		  	<input type="hidden" name="SearchWhere[]" value="<?php echo $AJAX_SEARCH_PLUGIN_WHERE;?>" />
		  <?php } ?>
		</form>
		
		<?php if ($jkv["ajaxsearch"] && $AJAX_SEARCH_PLUGIN_URL) { ?>
		<div class="row">
			<div class="col-xs-5">
				<div class="hideAdvSearchResult"><a class="btn btn-default btn-xs" href="<?php echo $P_SEAERCH_LINK;?>"><i class="fa fa-search"></i> <?php echo $tl["search"]["s9"];?></a></div>
			</div>
			<div class="col-xs-5">
				<div class="hideSearchResult"><a class="btn btn-warning btn-xs" href="javascript:void(0)"><i class="fa fa-remove"></i> <?php echo $tl["search"]["s8"];?></a></div>
			</div>
			<div class="col-xs-2">
				<div class="loadSearchResult"><i class="fa fa-spinner fa-pulse"></i></div>
			</div>
		</div>
		<?php } if (isset($JAK_HOOK_SEARCH_SIDEBAR) && is_array($JAK_HOOK_SEARCH_SIDEBAR)) foreach($JAK_HOOK_SEARCH_SIDEBAR as $hss) { include_once $hss; } ?>
		
		<!-- AJAX Search Result -->
		<div id="ajaxsearchR"></div>
		
		<hr>
		
</aside>

<?php if ($jkv["ajaxsearch"] && $AJAX_SEARCH_PLUGIN_URL) { ?>

<script type="text/javascript">
$(document).ready(function(){
	
	$('#ajaxsearchForm').ajaxSearch({apiURL: '<?php echo BASE_URL.$AJAX_SEARCH_PLUGIN_URL;?>', msg: '<?php echo $tl["general"]["g158"];?>', seo: <?php echo $AJAX_SEARCH_PLUGIN_SEO;?>});
	
	$('#Jajaxs').alphanumeric({nocaps:false, allow:' +*'});
	$('.hideAdvSearchResult').fadeIn();
	
});
</script>

<?php } } ?>