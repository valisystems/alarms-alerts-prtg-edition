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
		  if (isset($errors["e3"])) echo $errors["e3"];?>
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
	<?php include_once "cat_edit.php";?>	
	</td>
</tr>
<tr>
	<td><?php echo $tl["cat"]["c5"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e2"]) || isset($errors["e3"])) echo " has-error";?>">
		<input type="text" name="jak_varname" id="jak_varname" class="form-control" value="<?php echo $JAK_FORM_DATA["varname"]; ?>" />
	</div>
	</td>
</tr>
<?php if ($JAK_FORM_DATA["pluginid"] > 0) { ?>
<input type="hidden" name="jak_url" value="" />
<?php } else { ?>
<tr>
	<td><?php echo $tl["cat"]["c13"];?> <a href="javascript:void(0)" class="cms-help" data-content="<?php echo $tl["help"]["h1"];?>" data-original-title="<?php echo $tl["title"]["t21"];?>"><i class="fa fa-question-circle"></i></a></td>
	<td><input type="text" name="jak_url" class="form-control" value="<?php echo $JAK_FORM_DATA["exturl"];?>" /></td>
</tr>
<?php } ?>
<tr>
	<td><?php echo $tl["site"]["s3"];?></td>
	<td><?php include_once "editorlight_edit.php";?></td>
</tr>
<tr>
	<td><?php echo $tl["cat"]["c6"];?></td>
	<td>
	<div class="radio">
	<label>
	<input type="radio" name="jak_menu" value="1"<?php if ($JAK_FORM_DATA["showmenu"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
	</label>
	</div>
	<div class="radio">
	<label>
	<input type="radio" name="jak_menu" value="0"<?php if ($JAK_FORM_DATA["showmenu"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
	</label>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["cat"]["c7"];?></td>
	<td>
	<div class="radio">
	<label>
	<input type="radio" name="jak_footer" value="1"<?php if ($JAK_FORM_DATA["showfooter"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
	</label>
	</div>
	<div class="radio">
	<label>
	<input type="radio" name="jak_footer" value="0"<?php if ($JAK_FORM_DATA["showfooter"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
	</label>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["general"]["g87"];?></td>
	<td>
	<div class="input-group">
		<input type="text" name="jak_img" id="jak_img" data-placement="topRight" class="form-control" value="<?php echo $JAK_FORM_DATA["catimg"];?>">
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
	<div class="box box-danger">
	  <div class="box-header with-border">
	    <h3 class="box-title"><?php echo $tl["general"]["g88"];?> <a href="javascript:void(0)" class="cms-help" data-content="<?php echo $tl["help"]["h"];?>" data-original-title="<?php echo $tl["title"]["t21"];?>"><i class="fa fa-question-circle"></i></a></h3>
	  </div><!-- /.box-header -->
	  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><select name="jak_permission[]" multiple="multiple" class="form-control">
	<option value="0"<?php if ($JAK_FORM_DATA["permission"] == '0') { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g84"];?></option>
	<?php if (isset($JAK_USERGROUP) && is_array($JAK_USERGROUP)) foreach($JAK_USERGROUP as $v) { ?><option value="<?php echo $v["id"];?>"<?php if (in_array($v["id"], explode(',', $JAK_FORM_DATA["permission"]))) { ?> selected="selected"<?php } ?>><?php echo $v["name"];?></option><?php } ?>
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
		
<?php include "footer.php";?>