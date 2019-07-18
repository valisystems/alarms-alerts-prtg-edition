<div class="box box-primary">
  <div class="box-header with-border">
	<h3 class="box-title"><?php echo $tltts["tts"]["u"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
		<table class="table table-striped">
			<tr>
				<td><?php echo $tltts["tts"]["u1"];?></td>
				<td><div class="radio"><label><input type="radio" name="jak_tts" value="1"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_tts"] == '1') { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["tts"] == '1') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
				<div class="radio"><label><input type="radio" name="jak_tts" value="0"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_tts"] == '0') { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["tts"] == '0') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
			</tr>
			<tr>
				<td><?php echo $tltts["tts"]["u2"];?></td>
				<td><div class="radio"><label><input type="radio" name="jak_ttspost" value="1"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_ttspost"] == '1') { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["ttspost"] == '1') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
				<div class="radio"><label><input type="radio" name="jak_ttspost" value="0"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_ttspost"] =='0') { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["ttspost"] =='0') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
			</tr>
			<tr>
				<td><?php echo $tltts["tts"]["u3"];?></td>
				<td><div class="radio"><label><input type="radio" name="jak_ttspostapprove" value="0"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_ttspostapprove"] =='0') { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["ttspostapprove"] =='0') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
				<div class="radio"><label><input type="radio" name="jak_ttspostapprove" value="1"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_ttspostapprove"] == '1') { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["ttspostapprove"] == '1') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
			</tr>
			<tr>
				<td><?php echo $tltts["tts"]["u4"];?></td>
				<td><div class="radio"><label><input type="radio" name="jak_ttspostdelete" value="1"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_ttspostdelete"] =='1') { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["ttspostdelete"] =='1') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
				<div class="radio"><label><input type="radio" name="jak_ttspostdelete" value="0"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_ttspostdelete"] == '0') { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["ttspostdelete"] == '0') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
			</tr>
		</table>
	</div>
	<div class="box-footer">
		<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>