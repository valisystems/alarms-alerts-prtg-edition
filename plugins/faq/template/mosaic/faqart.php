<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/header.php';?>

<?php if (JAK_ASACCESS) $apedit = BASE_URL.'admin/index.php?p=faq&amp;sp=edit&amp;id='.$PAGE_ID; $qapedit = BASE_URL.'admin/index.php?p=faq&amp;sp=quickedit&amp;id='.$PAGE_ID; if ($jkv["printme"]) $printme = 1;?>
		
<div id="printdiv">
	<h2 class="first-child text-color hidden-xs"><?php echo $PAGE_TITLE;?></h2>
	<div class="row">
		<div class="col-md-6">
			<?php if ($SHOWDATE) { ?><i class="fa fa-clock-o"></i> <?php echo $PAGE_TIME;?> <?php } ?><i class="fa fa-eye"></i> <?php echo $FAQ_HITS;?>
		</div>
		<div class="col-md-6">
		<?php if ($JAK_TAGLIST) { ?>
			<i class="fa fa-tags"></i> <?php echo $JAK_TAGLIST;?>
		<?php } ?>
		</div>
	</div>
	<hr>
	<?php echo $PAGE_CONTENT;?>
</div>

<?php if ($JAK_SHOW_C_FORM) { include_once APP_PATH.'template/'.$jkv["sitestyle"].'/contact.php'; } ?>
			
<!-- Show date, socialbuttons and tag list -->
<?php if ($SHOWSOCIALBUTTON || (JAK_FAQRATE && $SHOWVOTE && $USR_CAN_RATE)) { ?>
<div class="row">
	<div class="col-md-6">
	<?php if (JAK_FAQRATE && $SHOWVOTE && $USR_CAN_RATE) { include_once APP_PATH.'template/'.$jkv["sitestyle"].'/voteresult.php'; } ?>
	</div>
	<div class="col-md-6">
	<?php if ($SHOWSOCIALBUTTON) include_once APP_PATH.'template/'.$jkv["sitestyle"].'/socialbutton.php';?>
	</div>
</div>
<?php } ?>
				
<?php if (JAK_FAQPOST && $JAK_COMMENT_FORM) { ?>
<!-- Comments -->
<div class="post-coments">
	<h4><?php echo $tlf["faq"]["d10"];?> (<span id="cComT"><?php echo $JAK_COMMENTS_TOTAL;?></span>)</h4>
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
					<?php if (JAK_FAQMODERATE) { ?>
					<a href="<?php echo $v["parseurl1"];?>" class="btn btn-default btn-xs"><i class="fa fa-trash-o"></i></a>
					<?php } if (JAK_USERID && JAK_FAQPOSTDELETE && $v["userid"] == JAK_USERID || JAK_FAQMODERATE) { ?>
					<a href="<?php echo $v["parseurl2"];?>" class="btn btn-default btn-xs commedit"><i class="fa fa-pencil"></i></a>
					<?php } if (JAK_USERID && JAK_FAQPOSTDELETE && $v["userid"] == JAK_USERID || JAK_FAQMODERATE) { ?>
					<a href="<?php echo $v["parseurl3"];?>" class="btn btn-default btn-xs"><i class="fa fa-ban"></i></a>
					<?php } ?>
				</div>
			</div>
		</li>
	<?php } ?>
		<li id="insertPost"></li>
	</ul>
	
	<!-- Show Comment Editor if set so -->
	<?php if (JAK_FAQPOST && $JAK_COMMENT_FORM) { include_once APP_PATH.'template/'.$jkv["sitestyle"].'/userform.php'; } ?>
	
</div>
<!-- End Comments -->
<?php } ?>

<ul class="pager">
<?php if ($JAK_NAV_PREV) { ?>
	<li class="previous"><a href="<?php echo $JAK_NAV_PREV;?>"><i class="fa fa-arrow-left"></i> <?php echo $JAK_NAV_PREV_TITLE;?></a></li>
<?php } if ($JAK_NAV_NEXT) { ?>
	<li class="next"><a href="<?php echo $JAK_NAV_NEXT;?>"><?php echo $JAK_NAV_NEXT_TITLE;?> <i class="fa fa-arrow-right"></i></a></li>
<?php } ?>
</ul>
		
<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/footer.php';?>