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
	<td>
	<?php include_once APP_PATH."admin/template/cat_new.php";?>
	</td>
</tr>
<tr>
	<td><?php echo $tl["cat"]["c5"];?></td>
	<td>
	<div class="form-group<?php if ($errors["e2"] || $errors["e3"]) echo " has-error";?>">
		<input type="text" name="jak_varname" id="jak_varname" class="form-control" value="<?php if (isset($_REQUEST["jak_varname"])) echo $_REQUEST["jak_varname"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["page"]["p5"];?></td>
	<td>
	<?php include_once APP_PATH."admin/template/editorlight_new.php";?>
	</td>
</tr>
<tr>
	<td><?php echo $tlgal["gallery"]["d19"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_comment" value="1"<?php if (isset($_REQUEST["jak_comment"]) && $_REQUEST["jak_comment"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_comment" value="0"<?php if (isset($_REQUEST["jak_comment"]) && $_REQUEST["jak_comment"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tl["general"]["g85"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_vote" value="1"<?php if (isset($_REQUEST["jak_vote"]) && $_REQUEST["jak_vote"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_vote" value="0"<?php if (isset($_REQUEST["jak_vote"]) && $_REQUEST["jak_vote"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tl["page"]["p9"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_social" value="1"<?php if (isset($_REQUEST["jak_social"]) && $_REQUEST["jak_social"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_social" value="0"<?php if (isset($_REQUEST["jak_social"]) && $_REQUEST["jak_social"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlgal["gallery"]["d32"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_uploadc" value="1"<?php if (isset($_REQUEST["jak_uploadc"]) && $_REQUEST["jak_uploadc"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_uploadc" value="0"<?php if (isset($_REQUEST["jak_uploadc"]) && $_REQUEST["jak_uploadc"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlgal["gallery"]["d21"];?></td>
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
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
</div>
<div class="col-md-4">
<?php if (JAK_TAGS) { ?>
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["title"]["t31"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table">
<tr>
	<td><input type="text" name="jak_tags" id="jak_tags" class="tags" value="<?php if (isset($_REQUEST["jak_tags"])) echo $_REQUEST["jak_tags"];?>" /></td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
<?php } ?>
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
	$('#jak_tags').tagsInput({
	defaultText:'<?php echo $tl["general"]["g83"];?>',
	taglimit: 10
	});
	$('#jak_tags_tag').alphanumeric({nocaps:true});
	$('#jak_img').iconpicker();
});
</script>
		
<?php include_once APP_PATH.'admin/template/footer.php';?>