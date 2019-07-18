<?php if (JAK_PLUGIN_ACCESS_NEWSLETTER && $shownewsletter_form == false) { 

// get the right url
$NL_SUBMIT_LINK = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_NEWSLETTER, 'signup', '', '', '');

?>

<h3><?php echo JAK_NLTITLE;?></h3>
<div id="nl_msg" class="alert alert-success" style="display: none;"></div>
<?php if ($_SESSION['jak_nl_errors']) { ?><div class="alert alert-danger"><?php echo $_SESSION['jak_nl_errors']["nlUser"].$_SESSION['jak_nl_errors']["nlEmail"];?></div>
<?php } if ($_SESSION["jak_nl_sent"] == 1) { ?>
<div class="alert alert-success"><?php echo $_SESSION['jak_thankyou_nl'];?></div>
<?php } else { ?>
<form id="nlSubmit" action="<?php echo $NL_SUBMIT_LINK;?>" method="post">
	<div class="form-group<?php if ($errornl) echo " has-error";?>">
	    <label class="control-label" for="nlUser"><?php echo $tl["contact"]["c1"];?></label>
	    <div class="controls">
			<input type="text" name="nlUser" id="nlUser" value="<?php echo $_REQUEST["nlUser"];?>" placeholder="<?php echo $tl["contact"]["c1"];?>" />
		</div>
	</div>
	<div class="form-group<?php if ($errornl) echo " has-error";?>">
	    <label class="control-label" for="nlEmail"><?php echo $tl["login"]["l5"];?></label>
	    <div class="controls">
			<input type="text" name="nlEmail" id="nlEmail" value="<?php echo $_REQUEST["nlUser"];?>" placeholder="<?php echo $tl["login"]["l5"];?>" />
		</div>
	</div>
	
<button type="submit" name="newsletter" id="formsubmit" class="btn btn-default"><?php echo $tl["general"]["g10"];?></button>
</form>
<?php } ?>
		
<script src="<?php echo BASE_URL;?>plugins/newsletter/js/nlform.js?=<?php echo $jkv["updatetime"];?>" type="text/javascript"></script>

<script type="text/javascript">

	jakWeb.jak_submit = "<?php echo $tl["general"]["g10"];?>";
	jakWeb.jak_submitwait = "<?php echo $tl['general']['g99'];?>";
	nlCMS.nlcms_url = "<?php echo (JAK_USE_APACHE ? substr($NL_SUBMIT_LINK, 1) : $NL_SUBMIT_LINK);?>";

</script>

<?php } ?>