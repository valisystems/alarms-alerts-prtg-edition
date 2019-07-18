<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tlblog["blog"]["d"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><?php echo $tlblog["blog"]["d1"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_blog" value="1"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_blog"] == '1') { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["blog"] == '1') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_blog" value="0"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_blog"] == '0') { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["blog"] == '0') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlblog["blog"]["d2"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_blogpost" value="1"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_blogpost"] == '1') { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["blogpost"] == '1') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_blogpost" value="0"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_blogpost"] =='0') { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["blogpost"] =='0') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlblog["blog"]["d3"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_blogpostapprove" value="0"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_blogpostapprove"] =='0') { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["blogpostapprove"] =='0') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_blogpostapprove" value="1"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_blogpostapprove"] == '1') { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["blogpostapprove"] == '1') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlblog["blog"]["d4"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_blogpostdelete" value="1"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_blogpostdelete"] =='1') { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["blogpostdelete"] =='1') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_blogpostdelete" value="0"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_blogpostdelete"] == '0') { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["blogpostdelete"] == '0') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlblog["blog"]["d5"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_blograte" value="1"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_blograte"] =='1') { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["blograte"] =='1') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_blograte" value="0"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_blograte"] =='0') { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["blograte"] =='0') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlblog["blog"]["d6"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_blogmoderate" value="1"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_blogmoderate"] =='1') { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["blogmoderate"] =='1') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_blogmoderate" value="0"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_blogmoderate"] =='0') { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["blogmoderate"] =='0') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
</table>
</div>
	<div class="box-footer">
		<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>