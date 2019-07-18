<?php include "header.php";?>

<?php if ($page3 == "s") { ?>
<div class="alert alert-success fade in">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <?php echo $tl["general"]["g7"];?>
</div>
<?php } if ($page3 == "e") { ?>
<div class="alert alert-danger fade in">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <?php echo $tl["errorpage"]["sql"];?>
</div>
<?php } ?>

<?php if ($errors) { ?>
<div class="alert alert-danger fade in">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<?php if (isset($errors["e"])) echo $errors["e"];
		  if (isset($errors["e1"])) echo $errors["e1"];
		  if (isset($errors["e2"])) echo $errors["e2"];
		  if (isset($errors["e3"])) echo $errors["e3"];
		  if (isset($errors["e4"])) echo $errors["e4"];?>
</div>
<?php } ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data">
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["title"]["t7"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
  	<div class="table-responsive">
<table class="table table-striped">
<tr>
	<td><?php echo $tl["user"]["u"];?></td>
	<td>
	<div class="form-group">
		<input type="text" name="jak_name" class="form-control" value="<?php echo $JAK_FORM_DATA["name"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["user"]["u1"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e2"])) echo " has-error";?>">
		<input type="text" name="jak_email" class="form-control" value="<?php echo $JAK_FORM_DATA["email"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["user"]["u2"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e1"])) echo " has-error";?>">
		<input class="form-control" type="text" name="jak_username" value="<?php echo $JAK_FORM_DATA["username"];?>" /><input type="hidden" name="jak_username_old" value="<?php echo $JAK_FORM_DATA["username"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["menu"]["m9"];?></td>
	<td><select name="jak_usergroup" class="form-control">
	<?php if (isset($JAK_USERGROUP_ALL) && is_array($JAK_USERGROUP_ALL)) foreach($JAK_USERGROUP_ALL as $v) { if ($v["id"] != "1") { ?><option value="<?php echo $v["id"];?>"<?php if ($v["id"] == $JAK_FORM_DATA["usergroupid"]) { ?> selected="selected"<?php } ?>><?php echo $v["name"];?></option><?php } } ?>
	</select></td>
</tr>
<tr>
	<td><?php echo $tl["user"]["u8"];?></td>
	<td><input type="text" name="jak_backtime" id="datepicker" class="form-control" value="<?php echo $JAK_FORM_DATA["backtime"];?>" /></td>
</tr>
<tr>
	<td><?php echo $tl["user"]["u7"];?></td>
	<td><select name="jak_usergroupback" class="form-control">
		<option value="0"><?php echo $tl["general"]["g99"];?></option>
	<?php if (isset($JAK_USERGROUP_ALL) && is_array($JAK_USERGROUP_ALL)) foreach($JAK_USERGROUP_ALL as $v) { if ($v["id"] != "1") { ?><option value="<?php echo $v["id"];?>"<?php if ($v["id"] == $JAK_FORM_DATA["backtogroup"]) { ?> selected="selected"<?php } ?>><?php echo $v["name"];?></option><?php } } ?>
	</select></td>
</tr>
<tr>
	<td><?php echo $tl["user"]["u3"];?></td>
	<td>
	<div class="radio">
	<label>
	<input type="radio" name="jak_access" value="1"<?php if ($JAK_FORM_DATA["access"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
	</label>
	</div>
	<div class="radio">
	<label>
	<input type="radio" name="jak_access" value="0"<?php if ($JAK_FORM_DATA["access"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
	</label>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["user"]["u10"];?></td>
	<td>
	<div class="fileinput fileinput-new" data-provides="fileinput">
	  <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
	  <img src="<?php echo BASE_URL_ORIG.basename(JAK_FILES_DIRECTORY).'/userfiles/'.$JAK_FORM_DATA["picture"];?>" alt="avatar" class="img-polaroid" />
	  </div>
	  <div>
	    <span class="btn btn-default btn-file"><span class="fileinput-new"><?php echo $tl["general"]["g132"];?></span><span class="fileinput-exists"><?php echo $tl["general"]["g131"];?></span><input type="file" name="uploadpp" accept="image/*"></span>
	    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput"><?php echo $tl["general"]["g130"];?></a>
	  </div>
	</div>
	</td>
</tr>
<?php if ($JAK_FORM_DATA["picture"] != "/standard.png") { ?>
<tr>
	<td><?php echo $tl["user"]["u46"];?></td>
	<td><input type="checkbox" name="jak_delete_avatar" /></td>
</tr>
<?php } ?>
</table>
</div>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
<?php if (isset($JAK_HOOK_ADMIN_USER_EDIT) && is_array($JAK_HOOK_ADMIN_USER_EDIT)) foreach($JAK_HOOK_ADMIN_USER_EDIT as $hsue) { include_once APP_PATH.$hsue['phpcode']; } if ($extrafields) { ?>
<div class="box box-primary">
	  <div class="box-header with-border">
	    <h3 class="box-title"><?php echo $tl["general"]["g114"];?></h3>
	  </div><!-- /.box-header -->
	  <div class="box-body">
<table class="table table-striped">
<?php echo $extrafields;?>
</table>
	</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
<?php } ?>
	<div class="box box-primary">
	  <div class="box-header with-border">
	    <h3 class="box-title"><?php echo $tl["title"]["t8"];?></h3>
	  </div><!-- /.box-header -->
	  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><?php echo $tl["user"]["u4"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e5"]) || isset($errors["e6"])) echo " has-error";?>">
		<input class="form-control" type="text" name="jak_password" id="check_password" value="" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["user"]["u5"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e5"]) || isset($errors["e6"])) echo " has-error";?>">
		<input class="form-control" type="text" name="jak_confirm_password" value="" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["user"]["u12"];?></td>
	<td>
	<div class="progress">
	  <div id="jak_pstrength" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
	</div>
	</td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
</form>

<script type="text/javascript">
$(document).ready(function(){
	$("#datepicker").datetimepicker({format: 'yyyy-mm-dd', minView: 2, autoclose: true, startDate: new Date()});
	$('#check_password').keyup(function() {
	  passwordStrength($(this).val());
	});
});
</script>

<?php include "footer.php";?>