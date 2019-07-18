<?php include "header.php";?>

<?php if ($JAK_FILE_SUCCESS) { ?>
<div class="alert alert-success fade in">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <?php echo $tl["general"]["g7"];?>
</div>
<?php } ?>

<?php if ($JAK_FILE_ERROR) { ?>
<div class="alert alert-danger fade in">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<?php echo $tl["error"]["e37"];?></div>
<?php } else { ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["general"]["g50"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table table-striped">
<tr>
	<td>
	<label for="jak_file_edit"><?php echo $tl["general"]["g51"];?></label>
	<select name="jak_file_edit" id="jak_file_edit" class="form-control"<?php if ($JAK_FILECONTENT) { ?> disabled="disabled"<?php } ?>>
	<?php if (isset($JAK_GET_TEMPLATE_FILES) && is_array($JAK_GET_TEMPLATE_FILES)) foreach($JAK_GET_TEMPLATE_FILES as $f) { ?><option value="<?php echo $f["path"];?>"<?php if ($JAK_FILEURL == $f["path"]) { ?> selected="selected"<?php } ?>><?php echo $f["name"];?></option><?php } ?>
	</select></td>
</tr>
<?php if ($JAK_FILECONTENT) { ?>
<tr>
	<td>
	<label for="jak_filecontent"><?php echo $tl["general"]["g54"];?></label>
	<div id="htmleditor"></div>
	<textarea name="jak_filecontent" id="jak_filecontent" class="form-control hidden"><?php echo $JAK_FILECONTENT;?></textarea>
	</td>
</tr>
<?php } ?>
</table>
</div>
</div>

<div class="form-actions">
<?php if ($JAK_GET_TEMPLATE_FILES) { ?>
<?php if ($JAK_FILEURL) { ?>
<button type="submit" name="reset" class="btn btn-success"><?php echo $tl["general"]["g72"];?></button>
<?php } if (!$JAK_FILECONTENT) { ?>
<button type="submit" name="edit" class="btn btn-primary pull-right"><?php echo $tl["general"]["g77"];?></button>
<?php } else { ?>
<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
<?php } } ?>
</div>

<input type="hidden" name="jak_file" value="<?php echo $JAK_FILEURL;?>" />
</form>
<?php } if ($JAK_FILECONTENT) { ?>
<script src="js/ace/ace.js" type="text/javascript"></script>
<script type="text/javascript">

var htmlefACE = ace.edit("htmleditor");
htmlefACE.setTheme("ace/theme/chrome");
htmlefACE.session.setMode("ace/mode/<?php echo $acemode;?>");
texthtmlef = $("#jak_filecontent").val();
htmlefACE.session.setValue(texthtmlef);

$('form').submit(function() {
	$("#jak_filecontent").val(htmlefACE.getValue());
});
</script>
<?php } include "footer.php";?>