<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/header.php';?>
		
	<?php if (JAK_ASACCESS) $apedit = BASE_URL.'admin/index.php?p=retailer&amp;sp=edit&amp;id='.$PAGE_ID; $qapedit = BASE_URL.'admin/index.php?p=retailer&amp;sp=quickedit&amp;id='.$PAGE_ID; if ($jkv["printme"]) $printme = 1;?>
		
		<div id="printdiv">
			
			<div class="row">
				<!-- Image Column -->
				<div class="col-sm-6">
					<div class="zoom-item">
						<div class="zoom-image">
							<img src="<?php echo $RETAILER_IMG;?>" alt="<?php echo $PAGE_TITLE;?>">
						</div>
						
					</div>
					<?php if ($RETAILER_IMG2) {?>
						<a href="<?php echo $RETAILER_IMG2;?>" data-lightbox="g"><img src="<?php echo $RETAILER_IMG2;?>" alt="img2" width="150" /></a>
					<?php } if ($RETAILER_IMG3) {?>
						<a href="<?php echo $RETAILER_IMG3;?>" data-lightbox="g"><img src="<?php echo $RETAILER_IMG3;?>" alt="img3" width="150" /></a>
					<?php } ?>
				</div>
				<!-- End Image Column -->
				<!-- Project Info Column -->
				<div class="zoom-item-description col-sm-6">
					<h3><?php echo $PAGE_TITLE;?></h3>
					<?php echo $PAGE_CONTENT;?>
					
					<h4><?php echo $tlre['retailer']['g13'];?></h4>
					<p><?php echo $RETAILER_ADDRESS;?></p>
					<ul class="no-list-style">
						<?php if ($RETAILER_PHONE) { ?>
						<li><b><?php echo $tlre['retailer']['g16'].':</b> '.$RETAILER_PHONE;?></li>
						<?php } if ($RETAILER_FAX) { ?>
						<li><b><?php echo $tlre['retailer']['g17'].':</b> '.$RETAILER_FAX;?></li>
						<?php } if ($RETAILER_EMAIL) { ?>
						<li><a href="mailto:<?php echo $RETAILER_EMAIL;?>"><?php echo $RETAILER_EMAIL;?></a></li>
						<?php } if ($RETAILER_WEBURL) { ?>
						<li class="zoom-visit-btn"><a href="<?php echo $RETAILER_WEBURL;?>" class="btn"><?php echo $tlre['retailer']['d6'];?></a></li>
						<?php } ?>
					</ul>
				</div>
				<!-- End Project Info Column -->
			</div>
			
			<div class="jak-post jak-single-post">
			
			<!-- Show date, socialbuttons and tag list -->
			<div class="well well-sm">
				<div class="row">
				<div class="col-md-2">
				<?php if ($SHOWHITS) { ?>
					<i class="fa fa-eye"></i> <?php echo $RETAILER_HITS;?>
				<?php } ?>
				</div>
				
				<div class="col-md-4">
				<?php if ($SHOWDATE) { ?>
					<i class="fa fa-clock-o"></i> <time datetime="<?php echo $PAGE_TIME_HTML5;?>"><?php echo $PAGE_TIME;?></time>
				<?php } ?>
				</div>
				<div class="col-md-3">
					<a href="#" id="showMap"><i class="fa fa-map-o"></i>  <?php echo $tlre['retailer']['g10'];?></a>
				</div>
				<div class="col-md-3">
					<a href="#" id="showDirection"><i class="fa fa-road"></i> <?php echo $tlre['retailer']['g12'];?></a>
				</div>
			</div>
			</div>
			
			<div id="canvas_map"></div>
			<div class="directions">
				<p><img src="<?php echo BASE_URL;?>plugins/retailer/img/customer-loc.png" alt="your-position" /> <?php echo $tlre['retailer']['g15'];?><br /><img src="<?php echo BASE_URL;?>plugins/retailer/img/customer-ret.png" alt="retailer-position" /> <?php echo $RETAILER_ADDRESS_MAP;?></p>
			<div id="directionsPanel"></div>
			</div>
				

		<?php if ($JAK_SHOW_C_FORM) { include_once APP_PATH.'template/'.$jkv["sitestyle"].'/contact.php'; } ?>
			    
		<?php if ($JAK_TAGLIST || $SHOWSOCIALBUTTON) { ?>
		<!-- tag list -->
		<div class="well well-sm">
			<div class="row">
				<div class="col-md-6">
					<?php if ($SHOWSOCIALBUTTON) { ?>
						<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/socialbutton.php';?>
					<?php } ?>
				</div>
				<div class="col-md-6">
					<?php if ($JAK_TAGLIST) { ?>
						<i class="fa fa-tags"></i> <?php echo $JAK_TAGLIST;?>
					<?php } ?>
				</div>
			</div>
		</div>
		<?php } ?>
			
		<?php if (JAK_RETAILERRATE && $SHOWVOTE && $USR_CAN_RATE) { include_once APP_PATH.'template/'.$jkv["sitestyle"].'/voteresult.php'; } ?>
		
		<?php if (JAK_RETAILERPOST && $JAK_COMMENT_FORM) { ?>
		<!-- Comments -->
		<div class="post-coments">
			<h4><?php echo $tlre["retailer"]["d10"];?> (<span id="cComT"><?php echo $JAK_COMMENTS_TOTAL;?></span>)</h4>
			<ul class="post-comments">
			<?php if (isset($JAK_COMMENTS) && is_array($JAK_COMMENTS)) foreach($JAK_COMMENTS as $v) { ?>
				<li>
					<div class="comment-wrapper">
						<div class="comment-author"><img src="<?php if ($v["userid"] != 0) { echo BASE_URL.JAK_FILES_DIRECTORY.'/userfiles'.$v["picture"]; } else { echo BASE_URL.JAK_FILES_DIRECTORY.'/userfiles'.'/standard.png'; }?>" alt="avatar" /> <?php echo $v["username"];?></div>
						<?php if ($CHECK_USR_SESSION == $v["session"]) { ?>
						<div class="alert alert-info"><?php echo $tl["general"]["g103"];?></div>
						<?php } ?>
						<div class="com">
							<?php echo $v["message"];?>
						</div>
						
						<!-- Comment Controls -->
						<div class="comment-actions">
							<span class="comment-date"><?php echo $v["created"];?></span>
							<?php if (JAK_RETAILERMODERATE) { ?>
							<a href="<?php echo $v["parseurl1"];?>" class="btn btn-default btn-xs"><i class="fa fa-trash-o"></i></a>
							<?php } if (JAK_USERID && JAK_RETAILERPOSTDELETE && $v["userid"] == JAK_USERID || JAK_RETAILERMODERATE) { ?>
							<a href="<?php echo $v["parseurl2"];?>" class="btn btn-default btn-xs commedit"><i class="fa fa-pencil"></i></a>
							<?php } if (JAK_USERID && JAK_RETAILERPOSTDELETE && $v["userid"] == JAK_USERID || JAK_RETAILERMODERATE) { ?>
							<a href="<?php echo $v["parseurl3"];?>" class="btn btn-default btn-xs"><i class="fa fa-ban"></i></a>
							<?php } ?>
						</div>
					</div>
				</li>
			<?php } ?>
				<li id="insertPost"></li>
			</ul>
			
			<!-- Show Comment Editor if set so -->
			<?php if (JAK_RETAILERPOST && $JAK_COMMENT_FORM) { include_once APP_PATH.'template/'.$jkv["sitestyle"].'/userform.php'; } ?>
			
		</div>
		<!-- End Comments -->
		<?php } ?>
		</div>
	</div>
		
		<ul class="pager">
		<?php if ($JAK_NAV_PREV) { ?>
			<li class="previous"><a href="<?php echo $JAK_NAV_PREV;?>"><i class="fa fa-arrow-left"></i> <?php echo $JAK_NAV_PREV_TITLE;?></a></li>
		<?php } if ($JAK_NAV_NEXT) { ?>
			<li class="next"><a href="<?php echo $JAK_NAV_NEXT;?>"><?php echo $JAK_NAV_NEXT_TITLE;?> <i class="fa fa-arrow-right"></i></a></li>
		<?php } ?>
		</ul>
		
<?php  include_once APP_PATH.'template/'.$jkv["sitestyle"].'/footer.php';?>