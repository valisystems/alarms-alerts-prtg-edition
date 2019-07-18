<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["title"]["t14"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table table-striped">
<thead>
<?php if (isset($JAK_PAGE_BACKUP) && is_array($JAK_PAGE_BACKUP)) { ?>
<tr>
<th><div class="form-group">
    <label><?php echo $tl["general"]["g103"];?></label>
    <select name="restorcontent" id="restorcontent" class="form-control"><option value="0"><?php echo $tl["general"]["g99"];?></option><?php foreach($JAK_PAGE_BACKUP as $pb) { ?><option value="<?php echo $pb['id'];?>"><?php echo $pb['time'];?></option><?php } ?></select><span class="loader"><i class="fa fa-spinner fa-pulse"></i></span>
   	</div>
</th>
</tr>
<?php } ?>
</thead>
<tr>
	<td>
		<?php if ($jkv["adv_editor"]) { ?>
		<p><a href="../js/editor/plugins/filemanager/dialog.php?type=0&editor=mce_0&lang=eng&fldr=&field_id=htmleditor" class="btn btn-default btn-xs ifManager"><i class="fa fa-files-o"></i></a></p>
		<div id="htmleditor"></div>
		<textarea name="jak_content" class="form-control hidden" id="jak_editor"><?php echo jak_edit_safe_userpost(htmlspecialchars($JAK_FORM_DATA["content"]));?></textarea>
		<?php } else { ?>
		<textarea name="jak_content" class="form-control jakEditor" id="jakEditor" rows="40"><?php echo jak_edit_safe_userpost($JAK_FORM_DATA["content"]);?></textarea>
		<?php } ?>
	</td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>