<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/header.php';?>

<?php if (JAK_ASACCESS) $apedit = BASE_URL.'admin/index.php?p=gallery&amp;sp=edit&amp;id='.$PAGE_ID; if ($jkv["printme"]) $printme = 1;?>
		
<ul class="breadcrumb" id="ice">
  <li><a href="<?php echo $backtogallery;?>"><?php echo JAK_PLUGIN_NAME_GALLERY;?></a></li>
  <li><a href="<?php echo $parse_category;?>"><?php echo $name_category;?></a></li>
  <li class="active"><?php echo $PAGE_TITLE;?></li>
</ul>
		
<div id="printdiv">
	<div class="row">
		<div class="col-xs-1">
		<?php if ($JAK_NAV_PREV) { ?>
			<a class="btn btn-default" href="<?php echo $JAK_NAV_PREV;?>"><i class="fa fa-arrow-left"></i></a>
		<?php } ?>
		</div>
		<div class="col-xs-10 text-center">
			<img src="<?php echo BASE_URL.$JAK_UPLOAD_PATH_BASE.$BIGFILE;?>" alt="<?php echo $PAGE_TITLE;?>" class="img-responsive img-thumbnail" />
		</div>
		<div class="col-xs-1">
		<?php if ($JAK_NAV_NEXT) { ?>
			<a class="btn btn-default" href="<?php echo $JAK_NAV_NEXT;?>"><i class="fa fa-arrow-right"></i></a>
		<?php } ?>
		</div>
	</div>
	
	<?php if ($PAGE_CONTENT) echo '<hr>'.$PAGE_CONTENT;?>
</div>

<hr>
<!-- Show date, socialbuttons and tag list -->
<div class="row">
	<div class="col-md-2">
		<i class="fa fa-users"></i> <span id="dcount"><?php echo $GALLERY_HITS;?></span>
	</div>
	<div class="col-md-2">
		<i class="fa fa-clock-o"></i> <time datetime="<?php echo $PAGE_TIME_HTML5;?>"><?php echo $PAGE_TIME;?></time>
	</div>
	<?php if ($JAK_TAGLIST) { ?>
	<div class="col-md-4">
		<i class="fa fa-tags"></i> <?php echo $JAK_TAGLIST;?>
	</div>
	<?php } ?>
	<div class="col-md-4">
	<?php if ($SHOWSOCIALBUTTON) include_once APP_PATH.'template/'.$jkv["sitestyle"].'/socialbutton.php';?>
	</div>
</div>

<?php if (JAK_GALLERYRATE && $SHOWVOTE && $USR_CAN_RATE) { include_once APP_PATH.'template/'.$jkv["sitestyle"].'/voteresult.php'; } ?>

<?php if (JAK_GALLERYPOST && $JAK_COMMENT_FORM) { ?>
<hr>
<!-- Comments -->
<div class="post-coments">
	<h4><?php echo $tlgal["gallery"]["d10"];?> (<span id="cComT"><?php echo $JAK_COMMENTS_TOTAL;?></span>)</h4>
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
					<?php if (JAK_GALLERYMODERATE) { ?>
					<a href="<?php echo $v["parseurl1"];?>" class="btn btn-default btn-xs"><i class="fa fa-trash-o"></i></a>
					<?php } if (JAK_USERID && JAK_GALLERYPOSTDELETE && $v["userid"] == JAK_USERID || JAK_GALLERYMODERATE) { ?>
					<a href="<?php echo $v["parseurl2"];?>" class="btn btn-default btn-xs commedit"><i class="fa fa-pencil"></i></a>
					<?php } if (JAK_USERID && JAK_GALLERYPOSTDELETE && $v["userid"] == JAK_USERID || JAK_GALLERYMODERATE) { ?>
					<a href="<?php echo $v["parseurl3"];?>" class="btn btn-default btn-xs"><i class="fa fa-ban"></i></a>
					<?php } ?>
				</div>
			</div>
		</li>
	<?php } ?>
		<li id="insertPost"></li>
	</ul>
	
	<!-- Show Comment Editor if set so -->
	<?php if (JAK_GALLERYPOST && $JAK_COMMENT_FORM) { include_once APP_PATH.'template/'.$jkv["sitestyle"].'/userform.php'; } ?>
	
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