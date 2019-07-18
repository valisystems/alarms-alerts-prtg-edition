<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tlre["retailer"]["d"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><?php echo $tlre["retailer"]["d1"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_retailer" value="1"<?php if ($JAK_FORM_DATA["retailer"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_retailer" value="0"<?php if ($JAK_FORM_DATA["retailer"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlre["retailer"]["d2"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_retailerpost" value="1"<?php if ($JAK_FORM_DATA["retailerpost"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_retailerpost" value="0"<?php if ($JAK_FORM_DATA["retailerpost"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlre["retailer"]["d3"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_retailerpostapprove" value="0"<?php if ($JAK_FORM_DATA["retailerpostapprove"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_retailerpostapprove" value="1"<?php if ($JAK_FORM_DATA["retailerpostapprove"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlre["retailer"]["d4"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_retailerpostdelete" value="1"<?php if ($JAK_FORM_DATA["retailerpostdelete"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_retailerpostdelete" value="0"<?php if ($JAK_FORM_DATA["retailerpostdelete"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlre["retailer"]["d5"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_retailerrate" value="1"<?php if ($JAK_FORM_DATA["retailerrate"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_retailerrate" value="0"<?php if ($JAK_FORM_DATA["retailerrate"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlre["retailer"]["d6"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_retailermoderate" value="1"<?php if ($JAK_FORM_DATA["retailermoderate"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_retailermoderate" value="0"<?php if ($JAK_FORM_DATA["retailermoderate"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
</table>
</div>
	<div class="box-footer">
		<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>