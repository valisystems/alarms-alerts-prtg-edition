<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tlcdr["cdr"]["u"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
		<table class="table table-striped">
			<tr>
				<td><?php echo $tlcdr["cdr"]["u1"];?></td>
				<td><div class="radio"><label><input type="radio" name="jak_cdr" value="1"<?php if ($JAK_FORM_DATA["cdr"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
				<div class="radio"><label><input type="radio" name="jak_cdr" value="0"<?php if ($JAK_FORM_DATA["cdr"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
			</tr>
			<tr>
				<td><?php echo $tlcdr["cdr"]["u2"];?></td>
				<td><div class="radio"><label><input type="radio" name="jak_cdrpost" value="1"<?php if ($JAK_FORM_DATA["cdrpost"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
				<div class="radio"><label><input type="radio" name="jak_cdrpost" value="0"<?php if ($JAK_FORM_DATA["cdrpost"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
			</tr>
			<tr>
				<td><?php echo $tlcdr["cdr"]["u3"];?></td>
				<td><div class="radio"><label><input type="radio" name="jak_cdrpostapprove" value="0"<?php if ($JAK_FORM_DATA["cdrpostapprove"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
				<div class="radio"><label><input type="radio" name="jak_cdrpostapprove" value="1"<?php if ($JAK_FORM_DATA["cdrpostapprove"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
			</tr>
			<tr>
				<td><?php echo $tlcdr["cdr"]["u4"];?></td>
				<td><div class="radio"><label><input type="radio" name="jak_cdrpostdelete" value="1"<?php if ($JAK_FORM_DATA["cdrpostdelete"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
				<div class="radio"><label><input type="radio" name="jak_cdrpostdelete" value="0"<?php if ($JAK_FORM_DATA["cdrpostdelete"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
			</tr>
		</table>
	</div>
	<div class="box-footer">
		<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>