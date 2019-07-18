<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["title"]["t14"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
  	<?php if ($jkv["adv_editor"]) { ?>
  	<p><a href="../js/editor/plugins/filemanager/dialog.php?type=0&editor=mce_0&lang=eng&fldr=&field_id=htmleditor" class="btn btn-default btn-xs ifManager"><i class="fa fa-files-o"></i></a></p>
  	<div id="htmleditor"></div>
  	<textarea name="jak_content" class="form-control hidden" id="jak_editor"><?php if (isset($_REQUEST["jak_content"])) echo jak_edit_safe_userpost(htmlspecialchars($_REQUEST["jak_content"]));?></textarea>
  	<?php } else { ?>
	<textarea name="jak_content" class="form-control jakEditor" id="jakEditor" rows="40"><?php if (isset($_REQUEST["jak_content"])) echo jak_edit_safe_userpost($_REQUEST["jak_content"]);?></textarea>
	<?php } ?>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>