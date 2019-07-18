<?php if (JAK_SEARCH && JAK_USER_SEARCH) { ?>
		<h3><?php echo $tl["title"]["t2"];?></h3>
		
		<form class="form-search" action="<?php echo $P_SEAERCH_LINK;?>" method="post">
		  <div class="input-group">
		    <input type="text" name="jakSH" id="Jajaxs" class="form-control search-query" placeholder="<?php echo $tl["search"]["s"]; if ($jkv["fulltextsearch"]) echo $tl["search"]["s5"];?>">
		    <span class="input-group-btn">
		    	<button type="submit" class="btn btn-default" name="search"><?php echo $tl["general"]["g83"];?></button>
		    </span>
		  </div>
		
		</form>
		
<?php if (isset($JAK_HOOK_SEARCH_SIDEBAR) && is_array($JAK_HOOK_SEARCH_SIDEBAR)) foreach($JAK_HOOK_SEARCH_SIDEBAR as $hss) { include_once $hss; } } ?>