<?php include_once APP_PATH.'admin/template/header.php';?>

<?php if ($page2 == "e") { ?>
<div class="alert alert-danger fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?php echo $tl["errorpage"]["sql"];?>
</div>
<?php } ?>

<?php if ($errors) { ?>
<div class="alert alert-danger fade in">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<?php if (isset($errors["e"])) echo $errors["e"];
		  if (isset($errors["e1"])) echo $errors["e1"];?>
</div>
<?php } ?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["title"]["t18"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><?php echo $tl["user"]["u"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e1"])) echo " has-error";?>">
		<input type="text" name="jak_name" class="form-control" value="<?php if (!isset($JAK_FORM_DATA["name"]) && isset($_REQUEST["jak_name"])) { echo $_REQUEST["jak_name"]; } elseif (isset($JAK_FORM_DATA["name"])) { ?><?php echo $JAK_FORM_DATA["name"]; } ?>" />
	</div></td>
</tr>
<tr>
	<td><?php echo $tl["user"]["u6"];?></td>
	<td><textarea class="jakEditorLight" id="jakEditor" rows="4" name="jak_desc"><?php if (!isset($JAK_FORM_DATA["description"]) && isset($_REQUEST["jak_desc"])) { echo $_REQUEST["jak_desc"]; } elseif (isset($JAK_FORM_DATA["description"])) { ?><?php echo $JAK_FORM_DATA["description"]; } ?></textarea></td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
</form>
		
<?php include_once APP_PATH.'admin/template/footer.php';?>