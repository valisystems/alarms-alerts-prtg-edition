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
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["title"]["t12"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><select name="jak_catid" class="form-control">
	<option value="0"<?php if ($JAK_FORM_DATA["catid"] == '0') { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g19"];?></option>
	<?php if (isset($JAK_CAT) && is_array($JAK_CAT)) foreach($JAK_CAT as $z) { ?><option value="<?php echo $z["id"];?>" <?php if ($z["id"] == $JAK_FORM_DATA["catid"]) { ?>selected="selected"<?php } ?>><?php echo $z["name"];?></option><?php } ?>
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
	<td><?php echo $tl["page"]["p8"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_showdate" value="1"<?php if ($JAK_FORM_DATA["showdate"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_showdate" value="0"<?php if ($JAK_FORM_DATA["showdate"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tl["general"]["g87"];?></td>
	<td>
	<div class="input-group">
		<input type="text" name="jak_img" id="jak_img" class="form-control" value="<?php echo $JAK_FORM_DATA["previmg"]; ?>" />
		<span class="input-group-btn">
		  <a class="btn btn-info ifManager" type="button" href="../js/editor/plugins/filemanager/dialog.php?type=1&subfolder=&editor=mce_0&lang=eng&fldr=&field_id=jak_img"><?php echo $tl["general"]["g69"];?></a>
		</span>
	</div><!-- /input-group -->
	</td>
</tr>
<tr>
	<td><?php echo $tl["general"]["g87"];?></td>
	<td>
	<div class="input-group">
		<input type="text" name="jak_mimg" id="jak_mimg" class="form-control" value="<?php echo $JAK_FORM_DATA["img"]; ?>" />
		<span class="input-group-btn">
		  <a class="btn btn-info ifManager" type="button" href="../js/editor/plugins/filemanager/dialog.php?type=1&subfolder=&editor=mce_0&lang=eng&fldr=&field_id=jak_mimg"><?php echo $tl["general"]["g69"];?></a>
		</span>
	</div><!-- /input-group -->
	</td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m9"];?></td>
	<td>
	<div class="input-group">
		<input type="text" name="jak_file" id="jak_file" class="form-control" value="<?php echo $JAK_FORM_DATA["digital_file"]; ?>" />
		<span class="input-group-btn">
		  <a class="btn btn-info ifManager" type="button" href="../js/editor/plugins/filemanager/dialog.php?type=2&subfolder=&editor=mce_0&lang=eng&fldr=&field_id=jak_file"><?php echo $tl["general"]["g69"];?></a>
		</span>
	</div><!-- /input-group -->
	</td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m94"];?></td>
	<td><select name="jak_usergroup" class="form-control">
	<option value="0"><?php echo $tl["cform"]["c18"];?></option>
	<?php if (isset($JAK_USERGROUP_ALL) && is_array($JAK_USERGROUP_ALL)) foreach($JAK_USERGROUP_ALL as $v) { if ($v["id"] != "1") { ?><option value="<?php echo $v["id"];?>"<?php if ($v["id"] == $JAK_FORM_DATA["usergroup"]) { ?> selected="selected"<?php } ?>><?php echo $v["name"];?></option><?php } } ?>
	</select></td>
</tr>
<tr>
	<td><?php echo $tl["general"]["g42"];?></td>
	<td><input type="checkbox" name="jak_update_time" /></td>
</tr>
<tr>
	<td><?php echo $tl["general"]["g73"].' '.$tl["general"]["g56"];?></td>
	<td><input type="checkbox" name="jak_delete_hits" /></td>
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
	<td><?php echo $tlec["shop"]["m15"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e2"])) echo " has-error";?>">
	<input type="text" class="form-control" name="jak_price" value="<?php echo $JAK_FORM_DATA["price"]; ?>" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m46"];?></td>
	<td><input type="text" class="form-control" name="jak_sale" value="<?php echo $JAK_FORM_DATA["sale"]; ?>" /></td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m10"];?></td>
	<td>
	<div class="input-group">
	  <input type="text" name="jak_weight" class="form-control" value="<?php echo $JAK_FORM_DATA["product_weight"]; ?>">
	  <span class="input-group-addon"><?php echo $tlec["shop"]["m70"];?></span>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m43"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_stock" value="1"<?php if ($JAK_FORM_DATA["stock"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_stock" value="0"<?php if ($JAK_FORM_DATA["stock"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m45"];?> <a class="cms-help" data-content="<?php echo $tlec["shop"]["m68"];?>" href="javascript:void(0)" data-original-title="<?php echo $tl["title"]["t21"];?>"><i class="fa fa-question-circle"></i></a></td>
	<td>
	
	<input type="text" class="form-control" name="jak_poption" value="<?php echo $JAK_FORM_DATA["product_options"]; ?>" />
	
	</td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m45"];?> (2) <a class="cms-help" data-content="<?php echo $tlec["shop"]["m68"];?>" href="javascript:void(0)" data-original-title="<?php echo $tl["title"]["t21"];?>"><i class="fa fa-question-circle"></i></a></td>
	<td>
	
	<input type="text" class="form-control" name="jak_poption1" value="<?php echo $JAK_FORM_DATA["product_options1"]; ?>" />
	
	</td>
	
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m45"];?> (3) <a class="cms-help" data-content="<?php echo $tlec["shop"]["m68"];?>" href="javascript:void(0)" data-original-title="<?php echo $tl["title"]["t21"];?>"><i class="fa fa-question-circle"></i></a></td>
	<td>
	
	<input type="text" class="form-control" name="jak_poption2" value="<?php echo $JAK_FORM_DATA["product_options2"]; ?>" />
	
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
    <h3 class="box-title"><?php echo $tl["title"]["t31"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><input type="text" name="jak_tags" id="jak_tags" class="tags" value="" /></td>
</tr>
<?php if ($JAK_TAGLIST) { ?>
<tr>
	<td>
	<div class="form-group">
	<label for="tags"><?php echo $tl["general"]["g27"];?></label>
	<div class="controls">
		<?php echo $JAK_TAGLIST;?>
	</div>
	</div>
	</td>
</tr>
<?php } ?>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
<?php } ?>

<?php include_once APP_PATH."admin/template/editor_edit.php";?>

<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["user"]["u6"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table table-striped">
<tr>
	<td>
	<?php if ($jkv["adv_editor"]) { ?>
	<p><a href="../js/editor/plugins/filemanager/dialog.php?type=0&editor=mce_0&lang=eng&fldr=&field_id=htmleditor2" class="btn btn-default btn-xs ifManager"><i class="fa fa-files-o"></i></a></p>
	<div id="htmleditor2"></div>
	<textarea name="jak_content2" class="form-control hidden" id="jak_editor2"><?php echo jak_edit_safe_userpost(htmlspecialchars($JAK_FORM_DATA["specs"]));?></textarea>
		<?php } else { ?>
	<textarea name="jak_content2" class="form-control jakEditor" id="jakEditor2" rows="40"><?php echo jak_edit_safe_userpost($JAK_FORM_DATA["specs"]);?></textarea>
	<?php } ?>
	</td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
<input type="hidden" name="jak_oldcatid" value="<?php echo $JAK_FORM_DATA["catid"];?>" />
</form>

<?php if ($jkv["adv_editor"]) { ?>
<script src="js/ace/ace.js" type="text/javascript"></script>
<script type="text/javascript">

var htmlACE = ace.edit("htmleditor");
htmlACE.setTheme("ace/theme/chrome");
htmlACE.session.setMode("ace/mode/html");
texthtml = $("#jak_editor").val();
htmlACE.session.setValue(texthtml);

var htmlACE2 = ace.edit("htmleditor2");
htmlACE2.setTheme("ace/theme/chrome");
htmlACE2.session.setMode("ace/mode/html");
texthtml2 = $("#jak_editor2").val();
htmlACE2.session.setValue(texthtml2);

function responsive_filemanager_callback(field_id) {
	
	if (field_id == "htmleditor" || field_id == "htmleditor2") {
		
		// get the path for the ace file
		var acefile = jQuery('#'+field_id).val();
		
		if (field_id == "htmleditor2") {
			htmlACE2.insert(acefile);
		} else {
			htmlACE.insert(acefile);
		}
	}
}

$('form').submit(function() {
	$("#jak_editor").val(htmlACE.getValue());
	$("#jak_editor2").val(htmlACE2.getValue());
});
</script>
<?php } ?>

<script type="text/javascript">
$(document).ready(function() {
	$('#jak_tags').tagsInput({
	   defaultText:'<?php echo $tl["general"]["g83"];?>',
	   taglimit: 10
	});
	$('#jak_tags_tag').alphanumeric({nocaps:true});
});
</script>
		
<?php include_once APP_PATH.'admin/template/footer.php';?>