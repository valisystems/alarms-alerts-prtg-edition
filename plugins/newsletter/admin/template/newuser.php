<?php include_once APP_PATH.'admin/template/header.php';?>

<?php if ($page3 == "e") { ?>
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
<?php } ?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>" enctype="multipart/form-data">
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["general"]["g67"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><?php echo $tl["user"]["u"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e1"])) echo " has-error";?>"><input type="text" name="jak_name" class="form-control" value="<?php if (isset($_REQUEST["jak_name"])) echo $_REQUEST["jak_name"];?>" /></div></td>
</tr>
<tr>
	<td><?php echo $tl["user"]["u1"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e2"])) echo " has-error";?>"><input type="text" name="jak_email" class="form-control" value="<?php if (isset($_REQUEST["jak_name"])) echo $_REQUEST["jak_email"];?>" /></div></td>
</tr>
<tr>
	<td><?php echo $tl["menu"]["m9"];?></td>
	<td><select name="jak_usergroup" class="form-control">
	<?php if (isset($JAK_USERGROUP_ALL) && is_array($JAK_USERGROUP_ALL)) foreach($JAK_USERGROUP_ALL as $v) { ?><option value="<?php echo $v["id"];?>"<?php if (isset($_REQUEST["jak_usergroup"]) && $v["id"] == $_REQUEST["jak_usergroup"]) { ?> selected="selected"<?php } ?>><?php echo $v["name"];?></option><?php } ?>
	</select></td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tlnl["nletter"]["d20"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><?php echo $tlnl["nletter"]["d21"];?></td>
	<td>
	<div class="fileinput fileinput-new" data-provides="fileinput">
	  <span class="btn btn-default btn-file"><span class="fileinput-new"><?php echo $tl["general"]["g133"];?></span><span class="fileinput-exists"><?php echo $tl["general"]["g131"];?></span><input type="file" name="jak_file" accept=".csv"></span>
	  <span class="fileinput-filename"></span>
	  <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tlnl["nletter"]["d22"];?></td>
	<td><input type="text" class="form-control" name="jak_delimiter" value="<?php if (isset($_REQUEST["jak_delimiter"])) echo $_REQUEST["jak_delimiter"];?>" placeholder="," /></td>
</tr>
<tr>
	<td><?php echo $tlnl["nletter"]["d23"];?></td>
	<td><input type="text" class="form-control" name="jak_start" value="<?php if (isset($_REQUEST["jak_start"])) echo $_REQUEST["jak_start"];?>" placeholder="1" /></td>
</tr>
<tr>
	<td><?php echo $tl["menu"]["m9"];?></td>
	<td><select name="jak_usergroupcsv" class="form-control">
	<?php if (isset($JAK_USERGROUP_ALL) && is_array($JAK_USERGROUP_ALL)) foreach($JAK_USERGROUP_ALL as $v) { ?><option value="<?php echo $v["id"];?>"<?php if (isset($_REQUEST["jak_usergroupcsv"]) && $v["id"] == $_REQUEST["jak_usergroupcsv"]) { ?> selected="selected"<?php } ?>><?php echo $v["name"];?></option><?php } ?>
	</select></td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
</form>
		
<?php include_once APP_PATH.'admin/template/footer.php';?>