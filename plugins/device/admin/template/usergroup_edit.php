<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tldev["device"]["u"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
		<table class="table table-striped">
			<tr>
				<td><?php echo $tldev["device"]["u1"];?></td>
				<td><div class="radio"><label><input type="radio" name="jak_device" value="1"<?php if ($JAK_FORM_DATA["device"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
				<div class="radio"><label><input type="radio" name="jak_device" value="0"<?php if ($JAK_FORM_DATA["device"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
			</tr>
			<tr>
				<td><?php echo $tldev["device"]["u2"];?></td>
				<td><div class="radio"><label><input type="radio" name="jak_devicepost" value="1"<?php if ($JAK_FORM_DATA["devicepost"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
				<div class="radio"><label><input type="radio" name="jak_devicepost" value="0"<?php if ($JAK_FORM_DATA["devicepost"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
			</tr>
			<tr>
				<td><?php echo $tldev["device"]["u3"];?></td>
				<td><div class="radio"><label><input type="radio" name="jak_devicepostapprove" value="0"<?php if ($JAK_FORM_DATA["devicepostapprove"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
				<div class="radio"><label><input type="radio" name="jak_devicepostapprove" value="1"<?php if ($JAK_FORM_DATA["devicepostapprove"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
			</tr>
			<tr>
				<td><?php echo $tldev["device"]["u4"];?></td>
				<td><div class="radio"><label><input type="radio" name="jak_devicepostdelete" value="1"<?php if ($JAK_FORM_DATA["devicepostdelete"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
				<div class="radio"><label><input type="radio" name="jak_devicepostdelete" value="0"<?php if ($JAK_FORM_DATA["devicepostdelete"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
			</tr>
		</table>
	</div>
	<div class="box-footer">
		<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>