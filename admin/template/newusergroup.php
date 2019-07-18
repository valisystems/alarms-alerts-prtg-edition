<?php include "header.php";?>

<?php if ($page2 == "e") { ?>
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
		  if (isset($errors["e2"])) echo $errors["e2"];?>
</div>
<?php } ?>

<div class="row">
  <div class="col-md-12">
	<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
		<div class="form-group">
		<label for="groupbase"><?php echo $tl["general"]["g61"];?></label>
		<div class="input-group">
		    <select name="jak_groupbase" id="groupbase" class="form-control">
		    <?php if (isset($JAK_USERGROUP_ALL) && is_array($JAK_USERGROUP_ALL)) foreach($JAK_USERGROUP_ALL as $z) { if ($z["id"] != '1') { ?><option value="<?php echo $z["id"];?>"<?php if (isset($_REQUEST['jak_groupbase']) && $z["id"] == $_REQUEST['jak_groupbase']) { ?> selected="selected"<?php } ?>><?php echo $z["name"];?></option><?php } } ?>
		    </select>
		    <span class="input-group-btn">
		    	<button class="btn btn-info" name="create" type="submit"><?php echo $tl["general"]["g20"];?></button>
		    </span>
		</div><!-- /input-group -->
		</div>
	</form>
	</div>
</div>

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
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["user"]["u6"];?></td>
	<td><?php include_once "editorlight_new.php";?></td>
</tr>
<tr>
	<td><?php echo $tl["user"]["u37"];?></td>
	<td>
	<div class="radio">
	<label>
	<input type="radio" name="jak_advs" value="1"<?php if (isset($_REQUEST["jak_advs"]) && $_REQUEST["jak_advs"] == '1') { ?> checked="checked"<?php } if (isset($JAK_FORM_DATA["advsearch"]) && $JAK_FORM_DATA["advsearch"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label>
	</div>
	<div class="radio">
	<label>
	<input type="radio" name="jak_advs" value="0"<?php if (isset($_REQUEST["jak_advs"]) && $_REQUEST["jak_advs"] == '0') { ?> checked="checked"<?php } if (isset($JAK_FORM_DATA["advsearch"]) && $JAK_FORM_DATA["advsearch"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
	</label>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["user"]["u11"];?></td>
	<td>
	<div class="radio">
	<label>
	<input type="radio" name="jak_rate" value="1"<?php if (isset($_REQUEST["jak_rate"]) && $_REQUEST["jak_rate"] == '1') { ?> checked="checked"<?php } if (isset($JAK_FORM_DATA["canrate"]) && $JAK_FORM_DATA["canrate"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
	</label>
	</div>
	<div class="radio">
	<label>
	<input type="radio" name="jak_rate" value="0"<?php if (isset($_REQUEST["jak_rate"]) && $_REQUEST["jak_rate"] == '0') { ?> checked="checked"<?php } if (isset($JAK_FORM_DATA["canrate"]) && $JAK_FORM_DATA["canrate"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
	</label>
	</div>
	</td>
</tr>
</table>
</div>
	<div class="box-footer">
		<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
<?php if (JAK_TAGS) { ?>
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["user"]["u40"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table table-striped">
<tr>
	<td>
	<div class="radio">
	<label>
	<input type="radio" name="jak_tags" value="1"<?php if (isset($_REQUEST["jak_tags"]) && $_REQUEST["jak_tags"] == '1') { ?> checked="checked"<?php } if (isset($JAK_FORM_DATA["tags"]) && $JAK_FORM_DATA["tags"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
	</label>
	</div>
	<div class="radio">
	<label>
	<input type="radio" name="jak_tags" value="0"<?php if (isset($_REQUEST["jak_tags"]) && $_REQUEST["jak_tags"] == '0') { ?> checked="checked"<?php } if (isset($JAK_FORM_DATA["tags"]) && $JAK_FORM_DATA["tags"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
	</label>
	</div>
	</td>
</tr>
</table>
</div>
	<div class="box-footer">
		<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
<?php } if (isset($JAK_HOOK_ADMIN_USERGROUP) && is_array($JAK_HOOK_ADMIN_USERGROUP)) foreach($JAK_HOOK_ADMIN_USERGROUP as $hs) { include_once APP_PATH.$hs['phpcode']; } ?>
</form>
		
<?php include "footer.php";?>