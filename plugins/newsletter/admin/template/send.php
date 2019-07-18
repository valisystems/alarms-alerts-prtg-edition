<?php include_once APP_PATH.'admin/template/header.php';?>

<?php if ($page3 == "s") { ?>
<div class="alert alert-success fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?php echo $tl["general"]["g7"];?>
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
<?php } ?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>" enctype="multipart/form-data">
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tlnl["nletter"]["d25"];?> <a class="cms-help" data-content="<?php echo $tl["help"]["h"];?>" href="javascript:void(0)" data-original-title="<?php echo $tl["title"]["t21"];?>"><i class="fa fa-question-circle"></i></a></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><select name="jak_nlgroup[]" multiple="multiple" class="form-control">
	<option value="0"<?php if ($_REQUEST["jak_nlgroup"] == '0') { ?> selected="selected"<?php } ?>><?php echo $tl["cform"]["c18"];?></option>
	<?php if (isset($JAK_USERGROUP_ALL) && is_array($JAK_USERGROUP_ALL)) foreach($JAK_USERGROUP_ALL as $v) { ?><option value="<?php echo $v["id"];?>"<?php if ($v["id"] == $_REQUEST["jak_nlgroup"]) { ?> selected="selected"<?php } ?>><?php echo $v["name"];?></option><?php } ?>
	</select></td>
</tr>
</table>
</div>
</div>
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tlnl["nletter"]["d26"];?> <a class="cms-help" data-content="<?php echo $tl["help"]["h"];?>" href="javascript:void(0)" data-original-title="<?php echo $tl["title"]["t21"];?>"><i class="fa fa-question-circle"></i></a></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><select name="jak_cmsgroup[]" multiple="multiple" class="form-control">
	<option value="0"<?php if ($_REQUEST["jak_cmsgroup"] == '0') { ?> selected="selected"<?php } ?>><?php echo $tl["cform"]["c18"];?></option>
	<?php if (isset($JAK_USERGROUP_CMS) && is_array($JAK_USERGROUP_CMS)) foreach($JAK_USERGROUP_CMS as $c) { ?><option value="<?php echo $c["id"];?>"<?php if ($c["id"] == $_REQUEST["jak_cmsgroup"]) { ?> selected="selected"<?php } ?>><?php echo $c["name"];?></option><?php } ?>
	</select></td>
</tr>
</table>
</div>
</div>
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tlnl["nletter"]["m"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><?php echo $tlnl["nletter"]["d27"];?></td>
	<td><input type="checkbox" name="jak_send" value="1" /></td>
</tr>
</table>
</div>
	<div class="box-footer">
		<span id="loader" style="display: none;"><img src="../../img/loader.gif" alt="loader" width="16" height="11" /></span>
	  	<button type="submit" name="save" id="sendNL" class="btn btn-primary pull-right"><?php echo $tl["general"]["g39"];?></button>
	</div>
</div>
</form>

<!-- JavaScript to disable send button and show loading.gif image -->
<script type="text/javascript">
	$(document).ready(function(){
	    // onclick
			$("input:submit").click(function() {
				$("#loader").show();
				$('#sendNL').val("<?php echo $tlnl["nletter"]["d31"];?>");
				$('#sendNL').attr("disabled", "disabled");
				$('.jak_form').submit();
			});
	});
</script>
		
<?php include_once APP_PATH.'admin/template/footer.php';?>