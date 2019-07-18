<?php include_once APP_PATH.'admin/template/header.php';?>

<?php if ($page2 == "s") { ?>
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

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<div class="row">
<div class="col-md-7">
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["title"]["t13"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><?php echo $tlec["shop"]["m92"];?></td>
	<td>
	<?php include_once APP_PATH."admin/template/title_new.php";?>
	</td>
</tr>
<tr>
	<td><?php echo $tl["page"]["p5"];?></td>
	<td><textarea class="jakEditorLight form-control" id="jakEditor" rows="4" name="jak_description"><?php if (isset($_REQUEST["jak_description"])) echo $_REQUEST["jak_description"];?></textarea></td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m88"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e2"])) echo " has-error";?>">
		<input type="text" class="form-control" name="jak_code" value="<?php if (isset($_REQUEST["jak_code"])) echo $_REQUEST["jak_code"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m87"];?></td>
	<td><select name="jak_type" class="form-control"><option value="1"<?php if (isset($_REQUEST["jak_type"]) && $_REQUEST["jak_type"] == 1) { ?> selected="selected"<?php } ?>><?php echo $tlec["shop"]["m89"];?></option><option value="2"<?php if (isset($_REQUEST["jak_type"]) && $_REQUEST["jak_type"] == 2) { ?> selected="selected"<?php } ?>><?php echo $tlec["shop"]["m90"];?></option></select></td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m80"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e3"])) echo " has-error";?>">
		<input type="text" name="jak_discount" class="form-control" value="<?php if (isset($_REQUEST["jak_discount"])) echo $_REQUEST["jak_discount"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m81"];?></td>
	<td><select name="jak_freeshipping" class="form-control"><option value="1"<?php if (isset($_REQUEST["jak_freeshipping"]) && $_REQUEST["jak_freeshipping"] == 1) { ?> selected="selected"<?php } ?>> <?php echo $tl["general"]["g18"];?></option><option value="0"<?php if (isset($_REQUEST["jak_freeshipping"]) && $_REQUEST["jak_freeshipping"] == 0) { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g19"];?></option></select></td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m82"];?></td>
	<td>
	<div class="form-group<?php if ($errors["e5"] || $errors["e6"]) echo " has-error";?>">
	<div class="row">
	<div class="col-md-6">
		<input type="text" name="jak_total" class="form-control" value="<?php if (isset($_REQUEST["jak_total"])) echo $_REQUEST["jak_total"];?>" size="4">
	</div>
	<div class="col-md-6">
	<input class="form-control" type="text" name="jak_used" value="<?php if (isset($_REQUEST["jak_used"])) echo $_REQUEST["jak_used"];?>" size="4" />
	</div>
	</div>
	</div>
	</td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
</div>
<div class="col-md-5">
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tlec["shop"]["m84"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table table-striped">
<tr>
	<td>
	<div class="form-group<?php if (isset($errors["e2"])) echo " has-error";?>">
		<label for="datepickerFrom"><?php echo $tlec["shop"]["m84"];?></label>
		<input type="text" name="jak_datefrom" id="datepickerFrom" class="form-control" value="<?php if (isset($_REQUEST["jak_datefrom"])) echo $_REQUEST["jak_datefrom"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td>
	<div class="form-group<?php if (isset($errors["e2"])) echo " has-error";?>">
	<label for="datepickerTo"><?php echo $tlec["shop"]["m85"];?></label>
	<input type="text" name="jak_dateto" id="datepickerTo" class="form-control" value="<?php if (isset($_REQUEST["jak_dateto"])) echo $_REQUEST["jak_dateto"];?>" />
	</div>
	</td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tlec["shop"]["m91"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table table-striped">
<tr>
	<td>
	
	<select name="jak_products[]" multiple="multiple" class="form-control">
	<option value="0"<?php if (isset($_REQUEST["jak_products"]) && in_array(0, $_REQUEST["jak_products"])) { ?> selected="selected"<?php } else { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g84"];?></option>
	<?php if (isset($JAK_PRODUCTS_CHOOSE) && is_array($JAK_PRODUCTS_CHOOSE)) foreach($JAK_PRODUCTS_CHOOSE as $z) { ?>
	<option value="<?php echo $z["id"];?>"<?php if (isset($_REQUEST["jak_products"]) && in_array($z["id"], $_REQUEST["jak_products"])) { ?> selected="selected"<?php } ?>><?php echo $z["title"];?></option>
	<?php } ?>
	</select>
	
	</td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
<div class="box box-danger">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["general"]["g88"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table table-striped">
<tr>
	<td>
	
	<select name="jak_permission[]" multiple="multiple" class="form-control">
	<option value="0"<?php if (isset($_REQUEST["jak_permission"]) && in_array(0, $_REQUEST["jak_permission"])) { ?> selected="selected"<?php } else { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g84"];?></option>
	<?php if (isset($JAK_USERGROUP) && is_array($JAK_USERGROUP)) foreach($JAK_USERGROUP as $v) { ?>
	<option value="<?php echo $v["id"];?>"<?php if (isset($_REQUEST["jak_permission"]) && in_array($v["id"], $_REQUEST["jak_permission"])) { ?> selected="selected"<?php } ?>><?php echo $v["name"];?></option>
	<?php } ?>
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
</div>
</form>

<script type="text/javascript">
$(document).ready(function(){
	$("#datepickerFrom, #datepickerTo").datetimepicker({format: 'yyyy-mm-dd hh:ii', autoclose: true, startDate: new Date()});
});
</script>
		
<?php include_once APP_PATH.'admin/template/footer.php';?>