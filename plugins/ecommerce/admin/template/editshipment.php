<?php include_once APP_PATH.'admin/template/header.php';?>

<?php if ($page4 == "s") { ?>
<div class="alert alert-success fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?php echo $tl["general"]["g7"];?>
</div>
<?php } if ($page4 == "e") { ?>
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
		  if (isset($errors["e3"])) echo $errors["e3"];?>
</div>
<?php } ?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["title"]["t13"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><?php echo $tl["page"]["p"];?></td>
	<td>
	<?php include_once APP_PATH."admin/template/title_edit.php";?>
	</td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m51"];?></td>
	<td><select name="jak_country" class="form-control">
	<?php echo $JAK_COUNTRY;?>
	</select></td>
</tr>
<tr>
	<td><?php echo $tl["general"]["g87"];?></td>
	<td>
	<div class="input-group">
		<input type="text" name="jak_img" id="jak_img" class="form-control" value="<?php echo $JAK_FORM_DATA["jak_img"]; ?>" />
		<span class="input-group-btn">
		  <a class="btn btn-info ifManager" type="button" href="../js/editor/plugins/filemanager/dialog.php?type=1&subfolder=&editor=mce_0&lang=eng&fldr=&field_id=jak_img"><?php echo $tl["general"]["g69"];?></a>
		</span>
	</div><!-- /input-group -->
	</td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
	<div class="box box-primary">
	  <div class="box-header with-border">
	    <h3 class="box-title"><?php echo $tlec["shop"]["m14"];?></h3>
	  </div><!-- /.box-header -->
	  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><?php echo $tlec["shop"]["m54"];?></td>
	<td><input type="text" name="jak_estship" class="form-control" value="<?php echo $JAK_FORM_DATA["est_shipping"]; ?>" /></td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m15"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e3"])) echo " has-error";?>">
	<input type="text" name="jak_price" class="form-control" value="<?php echo $JAK_FORM_DATA["price"]; ?>" />
	</div></td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m49"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e3"])) echo " has-error";?>">
	<input type="text" name="jak_handling" class="form-control" value="<?php echo $JAK_FORM_DATA["handling"]; ?>" />
	</div></td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m50"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e1"])) echo " has-error";?>">
	<div class="row">
	<div class="col-md-6">
		<div class="input-group">
		  <input type="text" name="jak_weight" class="form-control" value="<?php echo $JAK_FORM_DATA["weightfrom"]; ?>">
		  <span class="input-group-addon"><?php echo $tlec["shop"]["m70"];?></span>
		</div>
	</div>
	<div class="col-md-6">
	<div class="input-group">
	  <input type="text" name="jak_weightto" class="form-control" value="<?php echo $JAK_FORM_DATA["weightto"]; ?>">
	  <span class="input-group-addon"><?php echo $tlec["shop"]["m70"];?></span>
	</div>
	</div>
	</div></td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
</form>
		
<?php include_once APP_PATH.'admin/template/footer.php';?>