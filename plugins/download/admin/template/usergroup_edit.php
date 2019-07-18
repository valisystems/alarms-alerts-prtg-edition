<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tld["dload"]["d"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><?php echo $tld["dload"]["d1"];?></td>
	<td>
	<div class="radio"><label><input type="radio" name="jak_download" value="1"<?php if ($JAK_FORM_DATA["download"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div><div class="radio"><label><input type="radio" name="jak_download" value="0"<?php if ($JAK_FORM_DATA["download"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tld["dload"]["d29"];?></td>
	<td>
	<div class="radio"><label><input type="radio" name="jak_candownload" value="1"<?php if ($JAK_FORM_DATA["downloadcan"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div><div class="radio"><label><input type="radio" name="jak_candownload" value="0"<?php if ($JAK_FORM_DATA["downloadcan"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tld["dload"]["d2"];?></td>
	<td>
	<div class="radio"><label><input type="radio" name="jak_downloadpost" value="1"<?php if ($JAK_FORM_DATA["downloadpost"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div><div class="radio"><label><input type="radio" name="jak_downloadpost" value="0"<?php if ($JAK_FORM_DATA["downloadpost"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tld["dload"]["d3"];?></td>
	<td>
	<div class="radio"><label><input type="radio" name="jak_downloadpostapprove" value="0"<?php if ($JAK_FORM_DATA["downloadpostapprove"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div><div class="radio"><label><input type="radio" name="jak_downloadpostapprove" value="1"<?php if ($JAK_FORM_DATA["downloadpostapprove"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tld["dload"]["d4"];?></td>
	<td>
	<div class="radio"><label><input type="radio" name="jak_downloadpostdelete" value="1"<?php if ($JAK_FORM_DATA["downloadpostdelete"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div><div class="radio"><label><input type="radio" name="jak_downloadpostdelete" value="0"<?php if ($JAK_FORM_DATA["downloadpostdelete"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tld["dload"]["d5"];?></td>
	<td>
	<div class="radio"><label><input type="radio" name="jak_downloadrate" value="1"<?php if ($JAK_FORM_DATA["downloadrate"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div><div class="radio"><label><input type="radio" name="jak_downloadrate" value="0"<?php if ($JAK_FORM_DATA["downloadrate"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tld["dload"]["d6"];?></td>
	<td>
	<div class="radio"><label><input type="radio" name="jak_downloadmoderate" value="1"<?php if ($JAK_FORM_DATA["downloadmoderate"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div><div class="radio"><label><input type="radio" name="jak_downloadmoderate" value="0"<?php if ($JAK_FORM_DATA["downloadmoderate"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
</table>
</div>
	<div class="box-footer">
		<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>