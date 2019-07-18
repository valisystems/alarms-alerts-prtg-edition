<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/header.php';?>

<?php if (JAK_ASACCESS) $apedit = BASE_URL.'admin/index.php?p=ticketing&amp;sp=edit&amp;id='.$PAGE_ID; $qapedit = BASE_URL.'admin/index.php?p=ticketing&amp;sp=quickedit&amp;id='.$PAGE_ID;?>

<div id="printdiv">
	<h2 class="first-child text-color hidden-xs"><?php if (isset($JAK_ST_OPT) && is_array($JAK_ST_OPT)) foreach($JAK_ST_OPT as $sto) { if ($sto["id"] == $row['typeticket'] && $sto["img"]) { ?><a href="<?php echo $sto["parseurl"];?>" title="<?php echo $sto["name"];?>"><i class="fa <?php echo $sto["img"];?>"></i></a>
			<?php } } ?> <?php echo $TICKET_TITLE;?></h2>
			<i class="fa fa-clock-o"></i> <?php echo $PAGE_TIME;?> <i class="fa fa-eye"></i> <?php echo $row['hits'];?><br>
			<strong><?php echo $tlt["st"]["t35"];?>:</strong> <span class="label label-default"><?php echo $row["catname"];?></span> <strong><?php echo $tlt["st"]["t14"];?>:</strong> <span class="label label-default"><?php echo $row["toption"];?></span>
			<?php echo '<strong>'.$tlt["st"]["t28"].':</strong> '.$TICKER_STATUS;?> <?php echo '<strong>'.$tlt["st"]["t32"].':</strong> '.$TICKER_RESO;?> <?php echo '<strong>'.$tlt["st"]["t17"].'</strong>'.(JAK_ASACCESS ? '<a href="'.BASE_URL.'admin/index.php?p=user&sp=edit&ssp='.$row["userid"].'">'.$row["username"].'</a>' : $row["username"]);?>
	
	<hr>
			
	<?php echo $PAGE_CONTENT;?>
</div>
			
<?php if ($TICKER_ATTACH) { ?>
    
<p><a class="lightbox" href="<?php echo $TICKER_ATTACH_BIG;?>"><img src="<?php echo $TICKER_ATTACH;?>" alt="<?php echo $sto["name"];?> thumbnail"></a></p>
    
<?php } ?>
			
<?php if (JAK_TICKETRATE && $SHOWVOTE && $USR_CAN_RATE) { include_once APP_PATH.'template/'.$jkv["sitestyle"].'/voteresult.php'; } ?>
			
<!-- Show date, socialbuttons and tag list -->
<?php if ($SHOWSOCIALBUTTON || $JAK_TAGLIST) { ?>
<div class="row">
		<?php if ($SHOWSOCIALBUTTON) { ?>
		<div class="col-md-6">
			<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/socialbutton.php';?>
		</div>
		<?php } if ($JAK_TAGLIST) { ?>
		<div class="col-md-6">
			<i class="fa fa-tags"></i> <?php echo $JAK_TAGLIST;?>
		</div>
		<?php } ?>
</div>
<?php } if (JAK_ASACCESS || JAK_TICKETMODERATE) { ?>
<p>
	<form method="post" id="admin_co_ticket" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
		<label for="admin_mod_ticket"><?php echo $tlt["st"]["d7"];?></label>
		<select class="form-control" id="admin_mod_ticket" name="admin_mod_ticket">
			<option value="0"><?php echo $tl["cmsg"]["c12"];?></option>
			<option value="1"><?php echo $tlt["st"]["d3"];?></option>
			<option value="2"><?php echo $tlt["st"]["d4"];?></option>
			<option value="3"><?php echo $tlt["st"]["d5"];?></option>
			<option value="4"><?php echo $tlt["st"]["d6"];?></option>
		</select>
	</form>
</p>
<?php } ?>
		
<?php if (JAK_TICKETPOST && $JAK_COMMENT_FORM) { ?>
<hr>
<!-- Comments -->
<h4><?php echo $tlt["st"]["d10"];?> (<span id="cComT"><?php echo $JAK_COMMENTS_TOTAL;?></span>)</h4>
<div class="post-coments">
	<?php if (isset($JAK_COMMENTS)) {
		echo jak_build_comments(0, $JAK_COMMENTS, 'post-comments', JAK_TICKETMODERATE, $CHECK_USR_SESSION, $tl["general"]["g103"], $tlt["st"]["g9"], JAK_TICKETPOST, $jaktable2, false, !$row['status']);
	} else { ?>
		<div class="alert alert-info" id="comments-blank"><?php echo $tlt["st"]["g10"];?></div>
	<?php } ?>
	
	<!-- Show Comment Editor if set so -->
	<?php if (JAK_TICKETPOST && $TICKER_COMMENT && $row['status'] != 1) { ?>
	<ul class="post-comments">
		<li id="insertPost"></li>
	</ul>
	<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/userform.php';?>
	
	<?php if (JAK_ASACCESS || JAK_TICKETMODERATE) { ?>
	<hr>
		<label for="insert_url_form"><?php echo $tlt["st"]["d8"];?></label>
		<select class="form-control" id="insert_url_form" name="insert_url_form">
			<option value="0"><?php echo $tl["cmsg"]["c12"];?></option>
			<?php foreach ($jakcategories as $ufi) { ?>
			<option value="<?php echo $ufi["varname"];?>"><?php echo $ufi["name"];?></option>
			<?php } ?>
		</select>
	<?php } } ?>
	
</div>
<!-- End Comments -->
<?php } else { ?>
<div class="alert alert-info"><?php echo $tlt["st"]["d2"];?></div>
<?php } ?>
<!-- End Blog Post -->

<ul class="pager">
<?php if ($JAK_NAV_PREV) { ?>
	<li class="previous"><a href="<?php echo $JAK_NAV_PREV;?>"><i class="fa fa-arrow-left"></i> <?php echo $JAK_NAV_PREV_TITLE;?></a></li>
<?php } if ($JAK_NAV_NEXT) { ?>
	<li class="next"><a href="<?php echo $JAK_NAV_NEXT;?>"><?php echo $JAK_NAV_NEXT_TITLE;?> <i class="fa fa-arrow-right"></i></a></li>
<?php } ?>
</ul>

<script src="<?php echo BASE_URL;?>js/comments.js?=<?php echo $jkv["updatetime"];?>" type="text/javascript"></script>

<?php if (JAK_ASACCESS || JAK_TICKETMODERATE) { ?>
<script type="text/javascript">
// Mod for tickets
$(document).on("change", "#admin_mod_ticket", function() {
	$("#admin_co_ticket").submit();
});
// Add site url to ticket answer
$(document).on("change", "#insert_url_form", function() {
	var cms_url_add = $(this).val();
	tinymce.activeEditor.insertContent("<?php echo (JAK_USE_APACHE ? substr(BASE_URL, 0, -1) : BASE_URL);?>"+cms_url_add);
	$(this).val(0);
});
</script>

<?php } include_once APP_PATH.'template/'.$jkv["sitestyle"].'/footer.php';?>