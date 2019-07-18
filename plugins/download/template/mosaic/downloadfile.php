<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/header.php';?>
		
<?php if (JAK_ASACCESS) $apedit = BASE_URL.'admin/index.php?p=download&amp;sp=edit&amp;id='.$PAGE_ID; if ($jkv["printme"]) $printme = 1; $qapedit = BASE_URL.'admin/index.php?p=download&amp;sp=quickedit&amp;id='.$PAGE_ID; if ($DL_PASSWORD && !JAK_ASACCESS && $DL_PASSWORD != $_SESSION['dlsecurehash'.$PAGE_ID]) { ?>

<?php if ($errorpp) { ?>
		
<div class="alert alert-danger fade in">
<button type="button" class="close" data-dismiss="alert">×</button>
<?php echo $errorpp["e"];?>
</div>
		
<?php } ?>
		
<form role="form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
		
<input type="password" name="dlpass" class="form-control" value="" placeholder="<?php echo $tl["general"]["g29"]; ?>" />
<input type="hidden" name="dlsec" value="<?php echo $PAGE_ID;?>" />
<button type="submit" name="dlprotect" class="btn btn-primary"><?php echo $tl["general"]["g10"];?></button>
		
</form>

<?php } else { ?>
		
<div id="printdiv">
	<div class="row">
		<!-- Image Column -->
		<div class="col-sm-6">
			<img src="<?php echo $SHOWIMG;?>" alt="jak-download-preview" class="img-thumbnail img-responsive">
		</div>
		<!-- End Image Column -->
		<!-- Project Info Column -->
		<div class="col-sm-6">
			<h3 class="first-child text-color"><?php echo $PAGE_TITLE;?></h3>
			<p class="text-muted"><?php if ($SHOWDATE) { ?><i class="fa fa-clock-o"></i> <?php echo $PAGE_TIME.'<br>'; } ?><i class="fa fa-download"></i> <?php echo $DL_DOWNLOADS;?></p>
			
			<?php if (JAK_DOWNLOADRATE && $SHOWVOTE && $USR_CAN_RATE) { include_once APP_PATH.'template/'.$jkv["sitestyle"].'/voteresult.php'; } ?>

			<?php if ($SHOWSOCIALBUTTON) include_once APP_PATH.'template/'.$jkv["sitestyle"].'/socialbutton.php';?>
		</div>
		<!-- End Project Info Column -->
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">
		<?php echo $PAGE_CONTENT;?>
		</div>
	</div>
</div>

<?php if ($DL_FILE_BUTTON) { ?>
<div class="well">
	<div class="row">
	<?php if ($FT_SHARE) { ?>
		<div class="col-sm-8">
			<p><?php echo $tld["dload"]["d3"];?>
			<p><a href="javascript:void(0)" id="tweetLink" class="btn btn-info"><i class="fa fa-twitter fa-2x"></i></a> <a href="javascript:void(0)" id="faceLink" class="btn btn-primary"><i class="fa fa-facebook fa-2x"></i></a></p>
	       	<?php echo $tld["dload"]["d6"];?></p>
	    </div>
	    <div class="col-sm-4">
	       <p><a href="#" class="dclick"><?php echo $tld["dload"]["d2"];?></a></p>
	    </div>
	    <?php } else { ?>
	    
	    <div class="col-sm-8">
	    	<p><strong><?php echo $tld["dload"]["d2"];?></strong></p>
	    	<p><?php echo $tld["dload"]["d7"];?></p>
	    </div>
	    <div class="col-sm-4">
	    	<p><a class="dclick active" href="<?php echo $DL_LINK;?>"><?php echo $tld["dload"]["d2"];?></a></p>
	    </div>
	<?php } ?>
	</div>
</div>
<?php } ?>

<?php if ($JAK_SHOW_C_FORM) { include_once APP_PATH.'template/'.$jkv["sitestyle"].'/contact.php'; } ?>

<?php if (JAK_DOWNLOADPOST && $JAK_COMMENT_FORM) { ?>
<hr>
<!-- Comments -->
<div class="post-coments">
	<h4><?php echo $tlblog["blog"]["d10"];?> (<span id="cComT"><?php echo $JAK_COMMENTS_TOTAL;?></span>)</h4>
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
					<?php if (JAK_BLOGMODERATE) { ?>
					<a href="<?php echo $v["parseurl1"];?>" class="btn btn-default btn-xs"><i class="fa fa-trash-o"></i></a>
					<?php } if (JAK_USERID && JAK_BLOGPOSTDELETE && $v["userid"] == JAK_USERID || JAK_BLOGMODERATE) { ?>
					<a href="<?php echo $v["parseurl2"];?>" class="btn btn-default btn-xs commedit"><i class="fa fa-pencil"></i></a>
					<?php } if (JAK_USERID && JAK_BLOGPOSTDELETE && $v["userid"] == JAK_USERID || JAK_BLOGMODERATE) { ?>
					<a href="<?php echo $v["parseurl3"];?>" class="btn btn-default btn-xs"><i class="fa fa-ban"></i></a>
					<?php } ?>
				</div>
			</div>
		</li>
	<?php } ?>
		<li id="insertPost"></li>
	</ul>
</div>
<!-- End Comments -->

<!-- Show Comment Editor if set so -->
<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/userform.php';?>

<?php } ?>
		
<ul class="pager">
<?php if ($JAK_NAV_PREV) { ?>
	<li class="previous"><a href="<?php echo $JAK_NAV_PREV;?>"><i class="fa fa-arrow-left"></i> <?php echo $JAK_NAV_PREV_TITLE;?></a></li>
<?php } if ($JAK_NAV_NEXT) { ?>
	<li class="next"><a href="<?php echo $JAK_NAV_NEXT;?>"><?php echo $JAK_NAV_NEXT_TITLE;?> <i class="fa fa-arrow-right"></i></a></li>
<?php } ?>
</ul>

<?php } ?>
		
<?php if ($FT_SHARE) { ?>
<script type="text/javascript" src="<?php echo BASE_URL;?>plugins/download/js/jquery.tweetfaceAction.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	// Using our tweetAction plugin. For a complete list with supported
	// parameters, refer to http://dev.twitter.com/pages/intents#tweet-intent
	
	$('#tweetLink').tweetAction({
		text:		"<?php echo $PAGE_TITLE.' - '.$jkv["title"];?>",
		url:		'<?php echo BASE_URL.JAK_PARSE_REQUEST;?>',
		via:		'<?php echo $jkv["downloadtwitter"];?>',
		related:	'<?php echo $jkv["downloadtwitter"];?>'
	},function(){
		
		// When the user closes the pop-up window:
		
		$('a.dclick')
				.addClass('active')
				.attr('href','<?php echo $DL_LINK;?>');
				
		
		$('.dclick').click(function(){
		
				var countSpan = $('#dcount').text();
				var newSpan = parseInt(countSpan) + 1;
				
				$('#dcount').html(newSpan);
				$('#dcount').slideDown(500);
		});

	});
	
	$('#faceLink').faceAction({
			url: '<?php echo BASE_URL.JAK_PARSE_REQUEST;?>'
		},function(){
			
			// When the user closes the pop-up window:
			
			$('a.dclick')
					.addClass('active')
					.attr('href','<?php echo $DL_LINK;?>');
					
					
			$('.dclick').click(function(){
			
					var countSpan = $('#dcount').text();
					var newSpan = parseInt(countSpan) + 1;
					
					$('#dcount').html(newSpan);
					$('#dcount').slideDown(500);
			});
	
		});
	
});
</script>

<?php } else { ?>

<script type="text/javascript">
$(document).ready(function(){
	/* This code is executed after the DOM has been completely loaded */

	$('.dclick').click(function(){

		var countSpan = $('#dcount').text();
		var newSpan = parseInt(countSpan) + 1;
		
		$('#dcount').html(newSpan);
		$('#dcount').slideDown(500);
	});
});
</script>

<?php } ?>

<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/footer.php';?>