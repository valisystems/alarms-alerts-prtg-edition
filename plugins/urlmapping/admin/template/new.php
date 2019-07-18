<?php include_once APP_PATH.'admin/template/header.php';?>

<?php if ($page3 == "s") { ?>
<div class="alert alert-success fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?php echo $tl["general"]["g7"];?>
</div>
<?php } if ($page3 == "e") { ?>
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
		  if (isset($errors["e2"])) echo $errors["e2"];?>
</div>
<?php } ?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<div class="row">
<div class="col-md-6">
	<div class="box box-danger">
		  <div class="box-header with-border">
		    <h3 class="box-title"><?php echo $tlum["um"]["d"];?></h3>
		  </div><!-- /.box-header -->
		  <div class="box-body">
		<div class="form-group<?php if (isset($errors["e1"])) echo " has-error";?>">
			<input class="form-control" type="text" name="jak_oldurl" value="<?php if (isset($_REQUEST["jak_oldurl"])) echo $_REQUEST["jak_oldurl"];?>" />
		</div>
	</div>
		<div class="box-footer">
		  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
		</div>
	</div>
	
</div>
<div class="col-md-6">

	<div class="box box-success">
		  <div class="box-header with-border">
		    <h3 class="box-title"><?php echo $tlum["um"]["d1"];?></h3>
		  </div><!-- /.box-header -->
		 	<div class="box-body">
				<div class="form-group<?php if (isset($errors["e1"])) echo " has-error";?>">
					<input class="form-control" type="text" name="jak_newurl" value="<?php if (isset($_REQUEST["jak_newurl"])) echo $_REQUEST["jak_newurl"];?>" />
				</div>
			</div>
		<div class="box-footer">
		  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
		</div>
	</div>

</div>
</div>

<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tlum["um"]["d2"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
	<div class="form-group">
		<select name="jak_redirect" class="form-control">
		
		<option value="301"<?php if (isset($_REQUEST["jak_redirect"]) && $_REQUEST["jak_redirect"] == '301') { ?> selected="selected"<?php } ?>><?php echo $tlum["um"]["d3"];?></option>
		<option value="302"<?php if (isset($_REQUEST["jak_redirect"]) && $_REQUEST["jak_redirect"] == '302') { ?> selected="selected"<?php } ?>><?php echo $tlum["um"]["d4"];?></option>
		
		</select>
		</div>
	</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>

</form>
		
<?php include_once APP_PATH.'admin/template/footer.php';?>