<?php include_once APP_PATH.'template/jakweb/header.php';?>
		
		<?php if (!$PAGE_ACTIVE) { ?>
		<div class="alert alert-danger">
			<?php echo $tl["errorpage"]["ep"];?>	
		</div>
		<?php } if (JAK_ASACCESS) { 
			$apedit = BASE_URL.'admin/index.php?p=news&amp;sp=edit&amp;id='.$PAGE_ID;
			$qapedit = BASE_URL.'admin/index.php?p=news&amp;sp=quickedit&amp;id='.$PAGE_ID;	
		} ?>
		
		<?php if ($SHOWTITLE) { ?>
			<!-- Heading -->
			<h1><?php echo $PAGE_TITLE;?></h1>
		<?php } ?>
			
			<?php echo $PAGE_CONTENT;?>
			    
			<?php if (isset($JAK_HOOK_PAGE) && is_array($JAK_HOOK_PAGE)) foreach($JAK_HOOK_PAGE as $hpage) { include_once APP_PATH.$hpage["phpcode"]; }
			    
			if (isset($JAK_PAGE_GRID) && is_array($JAK_PAGE_GRID)) foreach($JAK_PAGE_GRID as $pg) { 
			    
			// Load contact form
			if ($pg["pluginid"] == '9997' && $JAK_SHOW_C_FORM) { include_once APP_PATH.'template/jakweb/contact.php'; }
			    
			// Load News Grid
			if (isset($JAK_HOOK_NEWS_GRID) && is_array($JAK_HOOK_NEWS_GRID)) foreach($JAK_HOOK_NEWS_GRID as $hpagegrid) { eval($hpagegrid["phpcode"]); } } ?>
			
			<?php if ($SHOWVOTE && $USR_CAN_RATE) { include_once APP_PATH.'template/jakweb/voteresult.php'; } ?>
			
			<!-- Show date, socialbuttons and tag list -->
			<?php if ($SHOWDATE || $JAK_TAGLIST) { ?>
			<div class="well well-sm">
				<div class="row">
				
				<div class="col-md-6">
					<?php if ($JAK_TAGLIST) { ?>
					<i class="fa fa-tags"></i> <?php echo $JAK_TAGLIST;?>
					<?php } ?>
				</div>
				<div class="col-md-3">
					<i class="fa fa-users"></i> <?php echo $tl["general"]["g13"].$PAGE_HITS;?>
				</div>
				<div class="col-md-3">
					<?php if ($SHOWDATE) { ?>
					<i class="fa fa-clock-o"></i> <time datetime="<?php echo $PAGE_TIME_HTML5;?>"><?php echo $PAGE_TIME;?></time>
					<?php } ?>
				</div>
				</div>
			</div>
			<?php } ?>
			
			<?php if ($SHOWSOCIALBUTTON) { ?>
			<div class="well well-sm">
					<?php include_once APP_PATH.'template/jakweb/socialbutton.php';?>
			</div>
			<?php } ?>
		
		<hr>
		
		<ul class="pager">
		<?php if ($JAK_NAV_PREV) { ?>
			<li class="previous"><a href="<?php echo $JAK_NAV_PREV;?>"><i class="fa fa-arrow-left"></i> <?php echo $JAK_NAV_PREV_TITLE;?></a></li>
		<?php } if ($JAK_NAV_NEXT) { ?>
			<li class="next"><a href="<?php echo $JAK_NAV_NEXT;?>"><?php echo $JAK_NAV_NEXT_TITLE;?> <i class="fa fa-arrow-right"></i></a></li>
		<?php } ?>
		</ul>

<?php include_once APP_PATH.'template/jakweb/footer.php';?>