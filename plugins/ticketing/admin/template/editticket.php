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

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data">
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["title"]["t12"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><?php echo $tl["page"]["p1"];?></td>
	<td><select name="jak_catid" class="form-control">
	<option value="0"<?php if ($JAK_FORM_DATA["catid"] == '0') { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g24"];?></option>
	<?php if (isset($JAK_CAT) && is_array($JAK_CAT)) foreach($JAK_CAT as $z) { ?><option value="<?php echo $z["id"];?>" <?php if ($z["id"] == $JAK_FORM_DATA["catid"]) { ?>selected="selected"<?php } ?>><?php echo $z["name"];?></option><?php } ?>
	</select></td>
</tr>
<tr>
	<td><?php echo $tlt["st"]["d35"];?></td>
	<td>
	
	<?php if (isset($CMS_TICKET_OPTIONS) && is_array($CMS_TICKET_OPTIONS)) foreach($CMS_TICKET_OPTIONS as $sto) { ?>
	
		<div class="radio"><label><input type="radio" name="jak_type" value="<?php echo $sto["id"];?>"<?php if ($JAK_FORM_DATA["typeticket"] == $sto["id"]) { ?> checked="checked"<?php } ?> /> <?php echo $sto["name"];?></label></div>
		
	<?php } ?>
	
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
	<td><?php echo $tlt["st"]["d8"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e1"])) echo " has-error";?>">
		<input type="text" name="jak_title" class="form-control" value="<?php echo $JAK_FORM_DATA["title"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tlt["st"]["d18"];?></td>
	<td><select name="jak_status" class="form-control">
	<option value="0"<?php if ($JAK_FORM_DATA["status"] == '0') { ?> selected="selected"<?php } ?>><?php echo $tlt["st"]["d19"];?></option>
	<option value="1"<?php if ($JAK_FORM_DATA["status"] == '1') { ?> selected="selected"<?php } ?>><?php echo $tlt["st"]["d20"];?></option>
	</select></td>
</tr>
<tr>
	<td><?php echo $tlt["st"]["d21"];?></td>
	<td><select name="jak_priority" class="form-control">
	<option value="1"<?php if ($JAK_FORM_DATA["priority"] == '1') { ?> selected="selected"<?php } ?>>1 (<?php echo $tlt["st"]["d22"];?>)</option>
	<option value="2"<?php if ($JAK_FORM_DATA["priority"] == '2') { ?> selected="selected"<?php } ?>>2</option>
	<option value="3"<?php if ($JAK_FORM_DATA["priority"] == '3') { ?> selected="selected"<?php } ?>>3</option>
	<option value="4"<?php if ($JAK_FORM_DATA["priority"] == '4') { ?> selected="selected"<?php } ?>>4</option>
	<option value="5"<?php if ($JAK_FORM_DATA["priority"] == '5') { ?> selected="selected"<?php } ?>>5 (<?php echo $tlt["st"]["d23"];?>)</option>
	</select></td>
</tr>
<tr>
	<td><?php echo $tlt["st"]["d24"];?></td>
	<td><select name="jak_resolution" class="form-control">
	<option value="0"<?php if ($JAK_FORM_DATA["resolution"] == '0') { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g19"];?></option>
	<option value="1"<?php if ($JAK_FORM_DATA["resolution"] == '1') { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g18"];?></option>
	</select></td>
</tr>
<tr>
	<td><?php echo $tlt["st"]["d16"];?></td>
	<td>
	
	<?php if ($jkv["ticketpath"]) { ?>
	
	<div class="fileinput fileinput-new" data-provides="fileinput">
	  <span class="btn btn-default btn-file"><span class="fileinput-new"><?php echo $tl["general"]["g133"];?></span><span class="fileinput-exists"><?php echo $tl["general"]["g131"];?></span><input type="file" name="jak_attach"></span>
	  <span class="fileinput-filename"></span>
	  <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
	</div>
	
	<?php } else { echo '<div class="alert alert-info">'.$tl["error"]["e21"].'</div>'; } ?>
	
	</td>
</tr>
<?php if ($JAK_FORM_DATA["attachment"]) { ?>
<tr>
	<td><?php echo $tlt["st"]["d27"];?></td>
	<td><input type="checkbox" name="jak_delete_attach" />
	<input type="hidden" name="jak_filename" value="<?php echo $JAK_FORM_DATA["attachment"];?>" />
	</td>
</tr>
<?php } ?>
<tr>
	<td><?php echo $tlt["st"]["d34"];?></td>
	<td>
	<div class="radio"><label><input type="radio" name="jak_private" value="1"<?php if ($JAK_FORM_DATA["stprivate"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_private" value="0"<?php if ($JAK_FORM_DATA["stprivate"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlt["st"]["d11"];?></td>
	<td>
	<div class="radio"><label><input type="radio" name="jak_comment" value="1"<?php if ($JAK_FORM_DATA["comments"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_comment" value="0"<?php if ($JAK_FORM_DATA["comments"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tl["general"]["g85"];?></td>
	<td>
	<div class="radio"><label><input type="radio" name="jak_vote" value="1"<?php if ($JAK_FORM_DATA["showvote"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_vote" value="0"<?php if ($JAK_FORM_DATA["showvote"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tl["page"]["p9"];?></td>
	<td>
	<div class="radio"><label><input type="radio" name="jak_social" value="1"<?php if ($JAK_FORM_DATA["socialbutton"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_social" value="0"<?php if ($JAK_FORM_DATA["socialbutton"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tl["general"]["g86"];?></td>
	<td><input type="checkbox" name="jak_delete_rate" /></td>
</tr>
<tr>
	<td><?php echo $tlt["st"]["d38"];?></td>
	<td><input type="checkbox" name="jak_delete_comment" /></td>
</tr>
<tr>
	<td><?php echo $tl["general"]["g42"];?></td>
	<td><input type="checkbox" name="jak_update_time" /></td>
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
<?php } include_once APP_PATH."admin/template/editor_edit.php";?>

<input type="hidden" name="jak_oldcatid" value="<?php echo $JAK_FORM_DATA["catid"];?>" />
</form>

<?php if ($jkv["adv_editor"]) { ?>
<script src="js/ace/ace.js" type="text/javascript"></script>
<?php } ?>
<script type="text/javascript">

<?php if ($jkv["adv_editor"]) { ?>
var htmlACE = ace.edit("htmleditor");
htmlACE.setTheme("ace/theme/chrome");
htmlACE.session.setMode("ace/mode/html");
texthtml = $("#jak_editor").val();
htmlACE.session.setValue(texthtml);
<?php } ?>

$(document).ready(function() {
	$('#jak_tags').tagsInput({
	   defaultText:'<?php echo $tl["general"]["g83"];?>',
	   taglimit: 10
	});
	$('#jak_tags_tag').alphanumeric({nocaps:true});
});

<?php if ($jkv["adv_editor"]) { ?>
function responsive_filemanager_callback(field_id) {
	
	if (field_id == "htmleditor") {
		// get the path for the ace file
		var acefile = jQuery('#'+field_id).val();
		htmlACE.insert(acefile);
	}
}

$('form').submit(function() {
	$("#jak_editor").val(htmlACE.getValue());
});
<?php } ?>
</script>
		
<?php include_once APP_PATH.'admin/template/footer.php';?>