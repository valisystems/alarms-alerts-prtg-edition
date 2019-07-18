<?php include_once APP_PATH.'admin/template/header.php';?>

<?php if ($page2 == "s") { ?>
<div class="alert alert-success fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?php echo $tl["general"]["g7"];?>
</div>
<?php } if ($page2 == "e") { ?>
<div class="alert alert-danger fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?php echo $tl["errorpage"]["sql"];?>
</div>
<?php } ?>

<?php if ($errors) { ?>
<div class="alert alert-danger fade in">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<?php if (isset($errors["e"])) echo $errors["e"];
		  if (isset($errors["e1"])) echo $errors["e1"];
		  if (isset($errors["e2"])) echo $errors["e2"];
		  if (isset($errors["e3"])) echo $errors["e3"];
		  if (isset($errors["e4"])) echo $errors["e4"];?>
</div>
<?php } if ($success) { ?>
<div class="alert alert-success fade in">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<?php echo $success["e"];?>
</div>
<?php } ?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["title"]["t4"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><?php echo $tl["page"]["p"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e1"])) echo " has-error";?>">
		<input class="form-control" type="text" name="jak_title" value="<?php if (isset($JAK_SETTING) && is_array($JAK_SETTING)) foreach($JAK_SETTING as $v) { if ($v["varname"] == 'nltitle') { echo $v["value"]; } } ?>" />
	</div></td>
</tr>
<tr>
	<td><?php echo $tlnl["nletter"]["d13"];?></td>
	<td><textarea class="jakEditorLight" id="jakEditor" rows="4" name="jak_description"><?php if (isset($JAK_SETTING) && is_array($JAK_SETTING)) foreach($JAK_SETTING as $v) { if ($v["varname"] == 'nlsignoff') { echo $v["value"]; } } ?></textarea></td>
</tr>
<tr>
	<td><?php echo $tlnl["nletter"]["d14"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e2"])) echo " has-error";?>">
		<input class="form-control" type="text" name="jak_thankyou" value="<?php if (isset($JAK_SETTING) && is_array($JAK_SETTING)) foreach($JAK_SETTING as $v) { if ($v["varname"] == 'nlthankyou') { echo $v["value"]; } } ?>" />
	</div></td>
</tr>
<tr>
	<td><?php echo $tlnl["nletter"]["d28"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e4"])) echo " has-error";?>">
		<input type="text" name="jak_email" class="form-control" value="<?php if (isset($JAK_SETTING) && is_array($JAK_SETTING)) foreach($JAK_SETTING as $v) { if ($v["varname"] == 'nlemail') { echo $v["value"]; } } ?>" placeholder="<?php echo $tl["setting"]["s"];?>" />
	</div></td>
</tr>
<tr>
	<td><?php echo $tlnl["nletter"]["d15"];?></td>
	<td>
	<div class="radio"><label><input type="radio" name="jak_smpt" value="0"<?php if (isset($JAK_SETTING) && is_array($JAK_SETTING)) foreach($JAK_SETTING as $v) { if ($v["varname"] == 'nlsmtp_mail' && $v["value"] == '0') { ?> checked="checked"<?php } } ?> /> <?php echo $tlnl["nletter"]["d16"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_smpt" value="1"<?php if (isset($JAK_SETTING) && is_array($JAK_SETTING)) foreach($JAK_SETTING as $v) { if ($v["varname"] == 'nlsmtp_mail' && $v["value"] == '1') { ?> checked="checked"<?php } } ?> /> <?php echo $tlnl["nletter"]["d17"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlnl["nletter"]["d18"];?></td>
	<td><input type="text" class="form-control" name="jak_host" value="<?php if (isset($JAK_SETTING) && is_array($JAK_SETTING)) foreach($JAK_SETTING as $v) { if ($v["varname"] == 'nlsmtphost') { echo $v["value"]; } } ?>" /></td>
</tr>
<tr>
	<td><?php echo $tlnl["nletter"]["d19"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e3"])) echo " has-error";?>">
		<input type="text" class="form-control" name="jak_port" value="<?php if (isset($JAK_SETTING) && is_array($JAK_SETTING)) foreach($JAK_SETTING as $v) { if ($v["varname"] == 'nlsmtpport') { echo $v["value"]; } } ?>" placeholder="25" />
	</div></td>
</tr>
<tr>
	<td><?php echo $tlnl["nletter"]["d29"];?></td>
	<td>
	<div class="radio"><label><input type="radio" name="jak_alive" value="0"<?php if (isset($JAK_SETTING) && is_array($JAK_SETTING)) foreach($JAK_SETTING as $v) { if ($v["varname"] == 'nlsmtp_alive' && $v["value"] == '0') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g19"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_alive" value="1"<?php if (isset($JAK_SETTING) && is_array($JAK_SETTING)) foreach($JAK_SETTING as $v) { if ($v["varname"] == 'nlsmtp_alive' && $v["value"] == '1') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g18"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlnl["nletter"]["d30"];?></td>
	<td>
	<div class="radio"><label><input type="radio" name="jak_auth" value="0"<?php if (isset($JAK_SETTING) && is_array($JAK_SETTING)) foreach($JAK_SETTING as $v) { if ($v["varname"] == 'nlsmtp_auth' && $v["value"] == '0') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g19"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_auth" value="1"<?php if (isset($JAK_SETTING) && is_array($JAK_SETTING)) foreach($JAK_SETTING as $v) { if ($v["varname"] == 'nlsmtp_auth' && $v["value"] == '1') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g18"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlnl["nletter"]["d39"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e3"])) echo " has-error";?>">
		<input type="text" class="form-control" name="jak_prefix" value="<?php if (isset($JAK_SETTING) && is_array($JAK_SETTING)) foreach($JAK_SETTING as $v) { if ($v["varname"] == 'nlsmtp_prefix') { echo $v["value"]; } } ?>" placeholder="ssl/true/false" />
	</div></td>
</tr>
<tr>
	<td><?php echo $tl["login"]["l1"];?></td>
	<td><input type="text" class="form-control" name="jak_username" value="<?php if (isset($JAK_SETTING) && is_array($JAK_SETTING)) foreach($JAK_SETTING as $v) { if ($v["varname"] == 'nlsmtpusername') { echo base64_decode($v["value"]); } } ?>" /></td>
</tr>
<tr>
	<td><?php echo $tl["login"]["l2"];?></td>
	<td><input type="text" class="form-control" name="jak_password" value="<?php if (isset($JAK_SETTING) && is_array($JAK_SETTING)) foreach($JAK_SETTING as $v) { if ($v["varname"] == 'nlsmtppassword') { echo base64_decode($v["value"]); } } ?>" /></td>
</tr>
<tr>
	<td><?php echo $tlnl["nletter"]["d41"];?></td>
	<td><input type="submit" name="testMail" class="btn btn-success" id="sendTM" value="<?php echo $tlnl["nletter"]["d42"];?>" /> <span id="loader" style="display: none;"><img src="../../img/loader.gif" alt="loader" width="16" height="11" /></span></td>
</tr>
</table> 
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
</form>

<!-- JavaScript to disable send button and show loading.gif image -->
<script type="text/javascript">
	$(document).ready(function(){
	    // onclick
			$("#sendTM").click(function() {
				$("#loader").show();
				$('#sendTM').val("<?php echo $tlnl["nletter"]["d31"];?>");
				$('#sendTM').attr("disabled", "disabled");
				$('.jak_form').submit();
			});
	});
</script>
		
<?php include_once APP_PATH.'admin/template/footer.php';?>