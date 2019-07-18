<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tlf["faq"]["d"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><?php echo $tlf["faq"]["d1"];?></td>
	<td>
	<div class="radio"><label><input type="radio" name="jak_faq" value="1"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_faq"] == '1') { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["faq"] == '1') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_faq" value="0"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_faq"] == '0') { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["faq"] == '0') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlf["faq"]["d2"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_faqpost" value="1"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_faqpost"] == '1') { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["faqpost"] == '1') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_faqpost" value="0"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_faqpost"] =='0') { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["faqpost"] =='0') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlf["faq"]["d3"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_faqpostapprove" value="0"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_faqpostapprove"] =='0') { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["faqpostapprove"] =='0') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_faqpostapprove" value="1"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_faqpostapprove"] == '1') { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["faqpostapprove"] == '1') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlf["faq"]["d4"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_faqpostdelete" value="1"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_faqpostdelete"] =='1') { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["faqpostdelete"] =='1') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_faqpostdelete" value="0"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_faqpostdelete"] == '0') { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["faqpostdelete"] == '0') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlf["faq"]["d5"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_faqrate" value="1"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_faqrate"] =='1') { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["faqrate"] =='1') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_faqrate" value="0"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_faqrate"] =='0') { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["faqrate"] =='0') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlf["faq"]["d6"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_faqmoderate" value="1"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_faqmoderate"] =='1') { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["faqmoderate"] =='1') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_faqmoderate" value="0"<?php if (!$JAK_FORM_DATA) { if ($_REQUEST["jak_faqmoderate"] =='0') { ?> checked="checked"<?php } } else { if ($JAK_FORM_DATA["faqmoderate"] =='0') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
</table>
</div>
	<div class="box-footer">
		<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>