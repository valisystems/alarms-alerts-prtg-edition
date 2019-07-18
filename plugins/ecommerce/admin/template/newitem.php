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
		  if (isset($errors["e3"])) echo $errors["e3"];?>
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
	<option value="0"<?php if (!$page1) { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g19"];?></option>
	<?php if (isset($JAK_CAT) && is_array($JAK_CAT)) foreach($JAK_CAT as $v) { ?>
	
	<option value="<?php echo $v["id"];?>"<?php if ($v["id"] == $page2) { ?> selected="selected"<?php } ?>><?php echo $v["name"];?></option>
	
	<?php } ?>
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
	<?php include_once APP_PATH."admin/template/title_new.php";?>
	</td>
</tr>
<tr>
	<td><?php echo $tl["page"]["p8"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_showdate" value="1"<?php if (isset($_REQUEST["jak_showdate"]) && $_REQUEST["jak_showdate"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_showdate" value="0"<?php if (isset($_REQUEST["jak_showdate"]) && $_REQUEST["jak_showdate"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tl["general"]["g87"];?></td>
	<td>
	<div class="input-group">
		<input type="text" name="jak_img" id="jak_img" class="form-control" value="<?php if (isset($_REQUEST["jak_img"])) echo $_REQUEST["jak_img"]; ?>" />
		<span class="input-group-btn">
		  <a class="btn btn-info ifManager" type="button" href="../js/editor/plugins/filemanager/dialog.php?type=1&subfolder=&editor=mce_0&lang=eng&fldr=&field_id=jak_img"><?php echo $tl["general"]["g69"];?></a>
		</span>
	</div><!-- /input-group -->
	</td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m16"];?></td>
	<td>
	<div class="input-group">
		<input type="text" name="jak_mimg" id="jak_mimg" class="form-control" value="<?php if (isset($_REQUEST["jak_mimg"])) echo $_REQUEST["jak_mimg"]; ?>" />
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
		<input type="text" name="jak_file" id="jak_file" class="form-control" value="<?php if (isset($_REQUEST["jak_file"])) echo $_REQUEST["jak_file"]; ?>" />
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
	<?php if (isset($JAK_USERGROUP_ALL) && is_array($JAK_USERGROUP_ALL)) foreach($JAK_USERGROUP_ALL as $v) { if ($v["id"] != "1") { ?><option value="<?php echo $v["id"];?>"<?php if ($v["id"] == $_REQUEST["jak_usergroup"]) { ?> selected="selected"<?php } ?>><?php echo $v["name"];?></option><?php } } ?>
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
	    <h3 class="box-title"><?php echo $tlec["shop"]["m14"];?></h3>
	  </div><!-- /.box-header -->
	  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><?php echo $tlec["shop"]["m15"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e3"])) echo " has-error";?>">
		<input type="text" name="jak_price" class="form-control" value="<?php if (isset($_REQUEST["jak_price"])) echo $_REQUEST["jak_price"]; ?>" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m46"];?></td>
	<td><input type="text" name="jak_sale" class="form-control" value="<?php if (isset($_REQUEST["jak_sale"])) echo $_REQUEST["jak_sale"]; ?>" /></td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m10"];?></td>
	<td>
	<div class="input-group">
	  <input type="text" name="jak_weight" class="form-control" value="<?php if (isset($_REQUEST["jak_weight"])) echo $_REQUEST["jak_weight"]; ?>">
	  <span class="input-group-addon"><?php echo $tlec["shop"]["m70"];?></span>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m43"];?></td>
	<td>
	<div class="radio"><label><input type="radio" name="jak_stock" value="1"<?php if (isset($_REQUEST["jak_stock"]) && $_REQUEST["jak_stock"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_stock" value="0"<?php if (isset($_REQUEST["jak_stock"]) && $_REQUEST["jak_stock"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m45"];?> <a class="cms-help" data-content="<?php echo $tlec["shop"]["m68"];?>" href="javascript:void(0)" data-original-title="<?php echo $tl["title"]["t21"];?>"><i class="fa fa-question-circle"></i></a></td>
	<td>
	
	<input type="text" class="form-control" name="jak_poption" value="<?php if (isset($_REQUEST["jak_poption"])) echo $_REQUEST["jak_poption"]; ?>" />
	
	</td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m45"];?> (2) <a class="cms-help" data-content="<?php echo $tlec["shop"]["m68"];?>" href="javascript:void(0)" data-original-title="<?php echo $tl["title"]["t21"];?>"><i class="fa fa-question-circle"></i></a></td>
	<td>
	
	<input type="text" class="form-control" name="jak_poption1" value="<?php if (isset($_REQUEST["jak_poption1"])) echo $_REQUEST["jak_poption1"]; ?>" />
	
	</td>
	
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m45"];?> (3) <a class="cms-help" data-content="<?php echo $tlec["shop"]["m68"];?>" href="javascript:void(0)" data-original-title="<?php echo $tl["title"]["t21"];?>"><i class="fa fa-question-circle"></i></a></td>
	<td>
	
	<input type="text" class="form-control" name="jak_poption2" value="<?php if (isset($_REQUEST["jak_poption2"])) echo $_REQUEST["jak_poption2"]; ?>" />
	
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
	<td><input type="text" name="jak_tags" id="jak_tags" class="tags" value="<?php if (isset($_REQUEST["jak_tags"])) echo $_REQUEST["jak_tags"];?>" /></td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
<?php } ?>

<?php include_once APP_PATH."admin/template/editor_new.php";?>

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
	<textarea name="jak_content2" class="form-control hidden" id="jak_editor2"><?php if (isset($_REQUEST["jak_content2"])) echo jak_edit_safe_userpost(htmlspecialchars($_REQUEST["jak_content2"]));?></textarea>
		<?php } else { ?>
	<textarea name="jak_content2" class="form-control jakEditor" id="jakEditor2" rows="40"><?php if (isset($_REQUEST["jak_content2"])) echo jak_edit_safe_userpost($_REQUEST["jak_content2"]);?></textarea>
	<?php } ?>
	</td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
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