<?php include_once APP_PATH.'template/jakweb/header.php';?>
		
		<!-- Show alert messages, url to edit and quick edit -->
		<?php if (!$PAGE_ACTIVE) { ?>
		<div class="alert alert-danger">
			<?php echo $tl["errorpage"]["ep"];?>	
		</div>
		<?php } if (JAK_ASACCESS) { 
			if ($jkv["printme"]) $printme = 1;
			$apedit = BASE_URL.'admin/index.php?p=page&amp;sp=edit&amp;id='.$PAGE_ID;
			$qapedit = BASE_URL.'admin/index.php?p=page&amp;sp=quickedit&amp;id='.$PAGE_ID;
		} if ($jkv["printme"]) { ?>
		
		<div id="printdiv">
		
		<?php } if ($PAGE_SHOWTITLE && $JAK_SHOW_NAVBAR) { ?>
			
			<!-- Heading / Title -->
			<h1><?php echo $PAGE_TITLE;?></h1>
		
		<?php } ?>
		        
		        <?php if ($PAGE_PASSWORD && !JAK_ASACCESS && $PAGE_PASSWORD != $_SESSION['pagesecurehash'.$PAGE_ID]) { if ($errorpp) { ?>
		        	
		        	<!-- Show password error -->
			        <div class="alert alert-danger fade in">
			          <button type="button" class="close" data-dismiss="alert">×</button>
			          	<h4><?php echo $errorpp["e"];?></h4>
			        </div>
		        
		        <?php } ?>
		        	
		        	<!-- Show password form -->
					<form class="form-inline" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
					<div class="input-group">
					      <input type="password" name="pagepass" class="form-control" value="" placeholder="<?php echo $tl["general"]["g29"]; ?>" />
					      <span class="input-group-btn">
					        <button class="btn btn-default" name="pageprotect" type="submit"><?php echo $tl["general"]["g83"];?></button>
					      </span>
					    </div>
					<input type="hidden" name="pagesec" value="<?php echo $PAGE_ID;?>" />
					
					</form>

		        <?php } else { if (isset($JAK_HOOK_PAGE) && is_array($JAK_HOOK_PAGE)) foreach($JAK_HOOK_PAGE as $hpage) { include_once APP_PATH.$hpage["phpcode"]; } 
		        
		        // Load Grid
		        if (isset($JAK_PAGE_GRID) && is_array($JAK_PAGE_GRID)) foreach($JAK_PAGE_GRID as $pg) { 
		        
		        // Show Content
		        if ($pg["pluginid"] == '9999') { echo $PAGE_CONTENT; }
		        
		        // Show Contact form
		        if ($pg["pluginid"] == '9997' && $JAK_SHOW_C_FORM) { include_once APP_PATH.'template/jakweb/contact.php'; }
		        
		        // Load News
		        if ($pg["pluginid"] == '9998' && $JAK_NEWS_IN_CONTENT) { if (isset($JAK_NEWS_IN_CONTENT) && is_array($JAK_NEWS_IN_CONTENT)) { ?>
		        
		        <h2><?php echo $jkv["newstitle"];?></h2>
		        
		        <div class="row">
		        
		        <!-- Show news -->
		        <?php foreach($JAK_NEWS_IN_CONTENT as $n) { ?>
		        
		        	<div class="col-md-3 col-sm-6">
		        		<div class="service-wrapper">
		        			<?php if ($n["previmg"]) { ?>
		        				<a href="<?php echo $n["parseurl"];?>"><img src="<?php echo BASE_URL.$n["previmg"];?>" alt="news" class="img-responsive"></a>
		        			<?php } ?>
		        			<h3><a href="<?php echo $n["parseurl"];?>"><?php echo $n["title"];?></a></h3>
		        			<p><?php echo $n["contentshort"];?></p>
		        		</div>
		        	</div>
		        
		        <?php } ?>
		        
		       	</div>
		       		
		       		<hr>
		        
		        <?php } } if (isset($JAK_HOOK_PAGE_GRID) && is_array($JAK_HOOK_PAGE_GRID)) foreach($JAK_HOOK_PAGE_GRID as $hpagegrid) { eval($hpagegrid["phpcode"]); } } ?>
		    
		    <!-- Show login form -->
		    <?php if ($PAGE_LOGIN_FORM) { include_once APP_PATH.'template/jakweb/loginpage.php'; } ?>
		    
		    <!-- Show vote result -->
		    <?php if ($SHOWVOTE && $USR_CAN_RATE) { include_once APP_PATH.'template/jakweb/voteresult.php'; } ?>
		    
		    <!-- Show date, social buttons and tag list -->
		    <?php if ($SHOWDATE || $SHOWSOCIALBUTTON || ($JAK_TAGLIST && $SHOWTAGS)) { ?>
			<div class="well well-sm">
				<div class="row">
				<?php if ($SHOWSOCIALBUTTON) { ?>
				<div class="col-md-4">
					<?php include_once APP_PATH.'template/jakweb/socialbutton.php';?>
				</div>
				<?php } if ($JAK_TAGLIST && $SHOWTAGS) { ?>
				<div class="col-md-5">
					<i class="fa fa-tags"></i> <?php echo $JAK_TAGLIST;?>
				</div>
				<?php } if ($SHOWDATE) { ?>
				<div class="col-md-3">
					<i class="fa fa-clock-o"></i> <time datetime="<?php echo $PAGE_TIME_HTML5;?>"><?php echo $PAGE_TIME;?></time>
				</div>
				<?php } ?>
				</div>
			</div>
			<?php } } if ($jkv["printme"]) { ?>
		    
		</div>
		
<?php } include_once APP_PATH.'template/jakweb/footer.php';?>