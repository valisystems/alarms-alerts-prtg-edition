<?php if ($jkv["adv_editor"]) { ?>
<p><a href="../js/editor/plugins/filemanager/dialog.php?type=0&editor=mce_0&lang=eng&fldr=&field_id=htmleditorlight" class="btn btn-default btn-xs ifManager"><i class="fa fa-files-o"></i></a></p>
<div id="htmleditorlight"></div>
<textarea name="jak_lcontent" class="form-control hidden" id="jak_editor_light"><?php echo jak_edit_safe_userpost(htmlspecialchars($JAK_FORM_DATA["content"]));?></textarea>
<?php } else { ?>
<textarea name="jak_lcontent" class="jakEditorLight" id="jakEditor" rows="40"><?php echo jak_edit_safe_userpost($JAK_FORM_DATA["content"]);?></textarea>
<?php } ?>

<?php if ($jkv["adv_editor"]) { ?>
<script src="js/ace/ace.js" type="text/javascript"></script>
<script type="text/javascript">

var htmlelACE = ace.edit("htmleditorlight");
htmlelACE.setTheme("ace/theme/chrome");
htmlelACE.session.setMode("ace/mode/html");
texthtmlel = $("#jak_editor_light").val();
htmlelACE.session.setValue(texthtmlel);

function responsive_filemanager_callback(field_id) {
	
	if (field_id == "htmleditorlight") {
		
		// get the path for the ace file
		var acefile = jQuery('#'+field_id).val();
		htmlelACE.insert(acefile);
	}
}

$('form').submit(function() {
	$("#jak_editor_light").val(htmlelACE.getValue());
});
</script>
<?php } ?>