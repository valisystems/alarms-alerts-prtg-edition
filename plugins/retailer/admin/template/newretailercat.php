<?php include_once APP_PATH.'admin/template/header.php';?>

<?php if ($page2 == "e") { ?>
<div class="alert alert-error fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?php echo $tl["errorpage"]["sql"];?>
</div>
<?php } ?>

<?php if ($errors) { ?>
<div class="alert alert-error fade in">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<?php if (isset($errors["e"])) echo $errors["e"];
		  if (isset($errors["e1"])) echo $errors["e1"];
		  if (isset($errors["e2"])) echo $errors["e2"];
		  if (isset($errors["e3"])) echo $errors["e3"];
		  if (isset($errors["e4"])) echo $errors["e4"];?>
</div>
<?php } ?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<div class="row">
<div class="col-md-8">
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["title"]["t11"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><?php echo $tl["cat"]["c4"];?></td>
	<td><?php include_once APP_PATH."admin/template/cat_new.php";?></td>
</tr>
<tr>
	<td><?php echo $tl["cat"]["c5"];?></td>
	<td>
	<div class="form-group<?php if ($errors["e2"] || $errors["e3"]) echo " error";?>">
		<input type="text" name="jak_varname" id="jak_varname" class="form-control" value="<?php if (isset($_REQUEST["jak_varname"])) echo $_REQUEST["jak_varname"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["page"]["p5"];?></td>
	<td><?php include_once APP_PATH."admin/template/editorlight_new.php";?></td>
</tr>
<tr>
	<td><?php echo $tlre["retailer"]["d21"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_active" value="1"<?php if (isset($_REQUEST["jak_active"]) && $_REQUEST["jak_active"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_active" value="0"<?php if (isset($_REQUEST["jak_active"]) && $_REQUEST["jak_active"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tl["general"]["g87"];?></td>
	<td>
	<div class="input-group">
		<input type="text" name="jak_img" id="jak_img" data-placement="topRight" class="form-control" value="<?php if (isset($_REQUEST["jak_img"])) echo $_REQUEST["jak_img"];?>">
		<span class="input-group-addon"></span>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tlre["retailer"]["q13"];?></td>
	<td>
	
	<select name="jak_markerc" class="form-control">
	
		<option value="red"<?php if (isset($_REQUEST["jak_markerc"]) && $_REQUEST["jak_markerc"] == 'red') { echo ' selected="selected"'; } ?>><?php echo $tlre["retailer"]["q14"];?></option>
		<option value="blue"<?php if (isset($_REQUEST["jak_markerc"]) && $_REQUEST["jak_markerc"] == 'blue') { echo ' selected="selected"'; } ?>><?php echo $tlre["retailer"]["q15"];?></option>
		<option value="green"<?php if (isset($_REQUEST["jak_markerc"]) && $_REQUEST["jak_markerc"] == 'green') { echo ' selected="selected"'; } ?>><?php echo $tlre["retailer"]["q17"];?></option>
		<option value="pink"<?php if (isset($_REQUEST["jak_markerc"]) && $_REQUEST["jak_markerc"] == 'pink') { echo ' selected="selected"'; } ?>><?php echo $tlre["retailer"]["q18"];?></option>
		<option value="purple"<?php if (isset($_REQUEST["jak_markerc"]) && $_REQUEST["jak_markerc"] == 'purple') { echo ' selected="selected"'; } ?>><?php echo $tlre["retailer"]["q19"];?></option>
		<option value="magenta"<?php if (isset($_REQUEST["jak_markerc"]) && $_REQUEST["markercolor"] == 'magenta') { echo ' selected="selected"'; } ?>><?php echo $tlre["retailer"]["q16"];?></option>
		<option value="orange"<?php if (isset($_REQUEST["jak_markerc"]) && $_REQUEST["jak_markerc"] == 'orange') { echo ' selected="selected"'; } ?>><?php echo $tlre["retailer"]["q22"];?></option>
		<option value="turquoise"<?php if (isset($_REQUEST["jak_markerc"]) && $_REQUEST["jak_markerc"] == 'turquoise') { echo ' selected="selected"'; } ?>><?php echo $tlre["retailer"]["q23"];?></option>
		<option value="gold"<?php if (isset($_REQUEST["jak_markerc"]) && $_REQUEST["jak_markerc"] == 'gold') { echo ' selected="selected"'; } ?>><?php echo $tlre["retailer"]["q24"];?></option>
		<option value="black"<?php if (isset($_REQUEST["jak_markerc"]) && $_REQUEST["jak_markerc"] == 'black') { echo ' selected="selected"'; } ?>><?php echo $tlre["retailer"]["q20"];?></option>
		<option value="white"<?php if (isset($_REQUEST["jak_markerc"]) && $_REQUEST["jak_markerc"] == 'white') { echo ' selected="selected"'; } ?>><?php echo $tlre["retailer"]["q21"];?></option>
	
	</select>
	
	</td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>

</div>
<div class="col-md-4">
	<div class="box box-danger">
	  <div class="box-header with-border">
	    <h3 class="box-title"><?php echo $tl["general"]["g88"];?> <a class="cms-help" data-content="<?php echo $tl["help"]["h"];?>" href="javascript:void(0)" data-original-title="<?php echo $tl["title"]["t21"];?>"><i class="fa fa-question-circle"></i></a></h3>
	  </div><!-- /.box-header -->
	  <div class="box-body">
<table class="table">
<tr>
	<td><select name="jak_permission[]" multiple="multiple" class="form-control">
	<option value="0"<?php if (isset($_REQUEST["jak_permission"]) && $_REQUEST["jak_permission"] == '0') { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g84"];?></option>
	<?php if (isset($JAK_USERGROUP) && is_array($JAK_USERGROUP)) foreach($JAK_USERGROUP as $v) { ?><option value="<?php echo $v["id"];?>"<?php if (isset($_REQUEST["jak_permission"]) && $v["id"] == $_REQUEST["jak_permission"]) { ?> selected="selected"<?php } ?>><?php echo $v["name"];?></option><?php } ?>
	</select></td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
</div>
</div>
</form>

<script src="js/slug.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#jak_name").keyup(function(){
		// Checked, copy values
		$("#jak_varname").val(jakSlug($("#jak_name").val()));
	});
	$('#jak_img').iconpicker();
});
</script>
		
<?php include_once APP_PATH.'admin/template/footer.php';?>