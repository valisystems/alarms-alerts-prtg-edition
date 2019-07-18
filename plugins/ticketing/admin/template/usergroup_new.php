<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tlt["st"]["d"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><?php echo $tlt["st"]["d1"];?></td>
	<td>
	<div class="radio"><label><input type="radio" name="jak_ticket" value="1"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_ticket"] == '1') { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["ticket"] == '1') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g18"];?>
	</label></div>
	<div class="radio"><label>
	<input type="radio" name="jak_ticket" value="0"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_ticket"] == '0') { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["ticket"] == '0') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g19"];?>
	</label></div></td>
</tr>
<tr>
	<td><?php echo $tlt["st"]["d2"];?></td>
	<td>
	<div class="radio"><label><input type="radio" name="jak_ticketpost" value="1"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_ticketpost"] =='1') { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["ticketpost"] =='1') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g18"];?></label></div><div class="radio"><label><input type="radio" name="jak_ticketpost" value="0"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_ticketpost"] =='0') { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["ticketpost"] =='0') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlt["st"]["d3"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_ticketpostapprove" value="0"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_ticketpostapprove"] == 0) { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["ticketpostapprove"] =='0') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g18"];?></label></div><div class="radio"><label><input type="radio" name="jak_ticketpostapprove" value="1"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_ticketpostapprove"] =='1') { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["ticketpostapprove"] =='1') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlt["st"]["d4"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_ticketpostdelete" value="1"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_ticketpostdelete"] == 1) { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["ticketpostdelete"] == 1) { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g18"];?></label></div><div class="radio"><label><input type="radio" name="jak_ticketpostdelete" value="0"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_ticketpostdelete"] == 0) { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["ticketpostdelete"] == 0) { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlt["st"]["d5"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_ticketrate" value="1"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_ticketrate"] =='1') { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["ticketrate"] =='1') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g18"];?></label></div><div class="radio"><label><input type="radio" name="jak_ticketrate" value="0"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_ticketrate"] =='0') { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["ticketrate"] =='0') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlt["st"]["d6"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_ticketmoderate" value="1"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_ticketmoderate"] =='1') { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["ticketmoderate"] =='1') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g18"];?></label></div><div class="radio"><label><input type="radio" name="jak_ticketmoderate" value="0"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_ticketmoderate"] =='0') { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["ticketmoderate"] =='0') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
</table>
</div>
	<div class="box-footer">
		<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>