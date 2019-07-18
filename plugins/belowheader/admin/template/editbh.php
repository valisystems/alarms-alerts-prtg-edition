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
		  if (isset($errors["e2"])) echo $errors["e2"];
		  if (isset($errors["e3"])) echo $errors["e3"];
		  if (isset($errors["e4"])) echo $errors["e4"];?>
</div>
<?php } ?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<div class="row">
<div class="col-md-6">
	<div class="box box-primary">
		  <div class="box-header with-border">
		    <h3 class="box-title"><?php echo $tlbh["bh"]["d"];?></h3>
		  </div><!-- /.box-header -->
		  <div class="box-body">
	<table class="table table-striped">
	<tr>
		<td><div class="form-group<?php if (isset($errors["e1"])) echo " has-error";?>">
			<input class="form-control" type="text" name="jak_title" value="<?php echo $JAK_FORM_DATA["title"];?>" />
		</div></td>
	</tr>
	</table>
	</div>
		<div class="box-footer">
		  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
		</div>
	</div>
	<div class="box box-primary">
	  <div class="box-header with-border">
	    <h3 class="box-title"><?php echo $tlbh["bh"]["d2"];?></h3>
	  </div><!-- /.box-header -->
	  <div class="box-body">
	<table class="table table-striped">
	<tr>
		<td>
		
		<select name="jak_pageid[]" multiple="multiple" class="form-control">
		
		<option value="0"<?php if ($JAK_FORM_DATA["pageid"] == 0) { ?> selected="selected"<?php } ?>><?php echo $tl["cform"]["c18"];?></option>
		<?php if (isset($JAK_PAGES) && is_array($JAK_PAGES)) foreach($JAK_PAGES as $z) { ?>
		
		<option value="<?php echo $z["id"];?>"<?php if (in_array($z["id"], explode(',', $JAK_FORM_DATA["pageid"]))) { ?> selected="selected"<?php } ?>><?php echo $z["title"];?></option>
		
		<?php } ?>
		</select>
		
		</td>
	</tr>
	</table>
	</div>
		<div class="box-footer">
		  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
		</div>
	</div>
	<div class="box box-danger">
		  <div class="box-header with-border">
		    <h3 class="box-title"><?php echo $tl["general"]["g88"];?>  <a class="cms-help" data-content="<?php echo $tl["help"]["h"];?>" href="javascript:void(0)" data-original-title="<?php echo $tl["title"]["t21"];?>"><i class="fa fa-question-circle"></i></a></h3>
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
<div class="col-md-6">

	<div class="box box-primary">
	  <div class="box-header with-border">
	    <h3 class="box-title"><?php echo $tlbh["bh"]["d3"];?></h3>
	  </div><!-- /.box-header -->
	  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><?php echo $tl["menu"]["m8"];?></td>
	<td>
	
	<select name="jak_newsid[]" multiple="multiple" class="form-control">
	
	<option value="0"<?php if ($JAK_FORM_DATA["newsid"] == 0) { ?> selected="selected"<?php } ?>><?php echo $tl["cform"]["c18"];?></option>
	
	<?php if (isset($JAK_NEWS) && is_array($JAK_NEWS)) foreach($JAK_NEWS as $n) { ?>
	<option value="<?php echo $n["id"];?>"<?php if (in_array($n["id"], explode(',', $JAK_FORM_DATA["newsid"]))) { ?> selected="selected"<?php } ?>><?php echo $n["title"];?></option>
	<?php } ?>
	
	</select>
	
	</td>
</tr>
<tr>
	<td><?php echo $tlbh["bh"]["d4"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_mainnews" value="1"<?php if ($JAK_FORM_DATA["newsmain"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_mainnews" value="0"<?php if ($JAK_FORM_DATA["newsmain"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<?php if (JAK_TAGS) { ?>
<tr>
	<td><?php echo $tlbh["bh"]["d5"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_tags" value="1"<?php if ($JAK_FORM_DATA["tags"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_tags" value="0"<?php if ($JAK_FORM_DATA["tags"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<?php } ?>
<tr>
	<td><?php echo $tlbh["bh"]["d6"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_search" value="1"<?php if ($JAK_FORM_DATA["search"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_search" value="0"<?php if ($JAK_FORM_DATA["search"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlbh["bh"]["d7"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_sitemap" value="1"<?php if ($JAK_FORM_DATA["sitemap"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_sitemap" value="0"<?php if ($JAK_FORM_DATA["sitemap"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>

</div>
</div>	

<?php $tl["title"]["t14"] = $tlbh["bh"]["d1"];?>

<?php include_once APP_PATH."admin/template/editor_edit.php";?>

<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tlbh["bh"]["d8"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table table-striped">
<thead>
<?php if (isset($JAK_PAGE_BACKUP) && is_array($JAK_PAGE_BACKUP)) { ?>
<tr>
<th><div class="form-group">
    <label class="control-label"><?php echo $tl["general"]["g103"];?></label>
    <div class="controls">
    <select name="restorcontent" id="restorcontent" class="form-control"><option value="0"><?php echo $tl["general"]["g99"];?></option><?php foreach($JAK_PAGE_BACKUP as $pb) { ?><option value="<?php echo $pb['id'];?>"><?php echo $pb['time'];?></option><?php } ?></select><span id="loader"><img src="../../img/loader.gif" alt="loader" width="16" height="11" /></span>
    </div>
   	</div>
</th>
</tr>
<?php } ?>
</thead>
<tr>
	<td>
	<?php if ($jkv["adv_editor"]) { ?>
	<p><a href="../js/editor/plugins/filemanager/dialog.php?type=0&editor=mce_0&lang=eng&fldr=&field_id=htmleditor2" class="btn btn-default btn-xs ifManager"><i class="fa fa-files-o"></i></a></p>
	<div id="htmleditor2"></div>
	<textarea name="jak_contentb" class="form-control hidden" id="jak_editor2"><?php echo jak_edit_safe_userpost(htmlspecialchars($JAK_FORM_DATA["content_below"]));?></textarea>
	<?php } else { ?>
	<textarea name="jak_contentb" class="form-control jakEditor" id="jakEditor2" rows="40"><?php echo jak_edit_safe_userpost($JAK_FORM_DATA["content_below"]);?></textarea>
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
	
	// get the path for the ace file
	var acefile = jQuery('#'+field_id).val();
	
	if (field_id == "htmleditor") {
		htmlACE.insert(acefile);
	} else if (field_id == "htmleditor2") {
		htmlACE2.insert(acefile);	
	}
}

$('form').submit(function() {
	$("#jak_editor").val(htmlACE.getValue());
	$("#jak_editor2").val(htmlACE2.getValue());
});
</script>
<?php } ?>
		
<?php include_once APP_PATH.'admin/template/footer.php';?>