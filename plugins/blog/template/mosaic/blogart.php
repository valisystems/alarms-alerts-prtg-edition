<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/header.php';?>
		
		<?php if (JAK_ASACCESS) $apedit = BASE_URL.'admin/index.php?p=blog&amp;sp=edit&amp;id='.$PAGE_ID; $qapedit = BASE_URL.'admin/index.php?p=blog&amp;sp=quickedit&amp;id='.$PAGE_ID; if ($jkv["printme"]) $printme = 1;?>
		
		<div id="printdiv" class="blog-p">
		
			<div class="blog-p-body">
				<h2 class="first-child text-color hidden-xs"><?php echo $PAGE_TITLE;?></h2>
				<div class="row">
					<div class="col-sm-6">
						<p class="text-muted"><i class="fa fa-hand-o-right"></i> <?php echo $BLOG_CATLIST;?><br><?php if ($SHOWDATE) { ?><i class="fa fa-clock-o"></i> <?php echo $PAGE_TIME;?><br><?php } ?><i class="fa fa-eye"></i> <?php echo $BLOG_HITS;?></p>
					</div>
					<div class="col-sm-6">
						<!-- Show date, social buttons and tag list -->
						<?php if ($SHOWSOCIALBUTTON) include_once APP_PATH.'template/'.$jkv["sitestyle"].'/socialbutton.php';?>
						<?php if ($JAK_TAGLIST) { ?>
							<i class="fa fa-tags"></i> <?php echo $JAK_TAGLIST;?>
						<?php } ?>
					</div>
				</div>
				<hr>
				<?php echo $PAGE_CONTENT;?>
				<!-- <img src="<?php echo BASE_URL.$SHOWIMG;?>" alt="jak-preview" class="post-image img-responsive"> -->
			</div>
			<?php if ($JAK_SHOW_C_FORM) { include_once APP_PATH.'template/'.$jkv["sitestyle"].'/contact.php'; } ?>
			
			<?php if (JAK_BLOGRATE && $SHOWVOTE && $USR_CAN_RATE) { include_once APP_PATH.'template/'.$jkv["sitestyle"].'/voteresult.php'; } ?>
			<hr>
			<?php if (JAK_BLOGPOST && $JAK_COMMENT_FORM) { ?>
			<!-- Comments -->
			<h4><?php echo $tlblog["blog"]["d10"];?> (<span id="cComT"><?php echo $JAK_COMMENTS_TOTAL;?></span>)</h4>
			<div class="post-coments">
				<?php if (isset($JAK_COMMENTS)) {
					echo jak_build_comments(0, $JAK_COMMENTS, 'post-comments', JAK_BLOGMODERATE, $CHECK_USR_SESSION, $tl["general"]["g103"], $tlblog["blog"]["g9"], JAK_BLOGPOST, $jaktable2, false, true);
				} else { ?>
					<div class="alert alert-info" id="comments-blank"><?php echo $tlblog["blog"]["g10"];?></div>
				<?php } ?>
				
				<!-- Show Comment Editor if set so -->
				<?php if (JAK_BLOGPOST) { ?>
				<ul class="post-comments">
					<li id="insertPost"></li>
				</ul>
				<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/userform.php'; } ?>
				
			</div>
			<!-- End Comments -->
			<?php } ?>
		</div>
		<!-- End Print Post -->
		
		<ul class="pager">
		<?php if ($JAK_NAV_PREV) { ?>
			<li class="previous"><a href="<?php echo $JAK_NAV_PREV;?>"><i class="fa fa-arrow-left"></i> <?php echo $JAK_NAV_PREV_TITLE;?></a></li>
		<?php } if ($JAK_NAV_NEXT) { ?>
			<li class="next"><a href="<?php echo $JAK_NAV_NEXT;?>"><?php echo $JAK_NAV_NEXT_TITLE;?> <i class="fa fa-arrow-right"></i></a></li>
		<?php } ?>
		</ul>
		
<script src="<?php echo BASE_URL;?>js/comments.js?=<?php echo $jkv["updatetime"];?>" type="text/javascript"></script>
		
<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/footer.php';?>