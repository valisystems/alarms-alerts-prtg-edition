<?php if ($pg["pluginid"] == JAK_PLUGIN_SLIDER) {

// We run the queries for the widgets only if we need to
$hookadminws = $jakhooks->jakGethook("php_admin_widgets_sql");
if ($hookadminws) {
	foreach($hookadminws as $hasq) {
		eval($hasq['phpcode']);
	}
}
?>

<li class="jakcontent">
	
	<div class="form-group">
	    <label class="control-label"><?php echo $tlls["ls"]["m"];?></label>
	    <select name="jak_showslider" class="form-control">
	<option value="0"<?php if ($JAK_FORM_DATA["showslider"] == '0') { ?> selected="selected"<?php } ?>><?php echo $tl["cform"]["c18"];?></option>
	<?php if (isset($JAK_GET_SLIDER) && is_array($JAK_GET_SLIDER)) foreach($JAK_GET_SLIDER as $las) { ?><option value="<?php echo $las["id"];?>"<?php if ($las["id"] == $JAK_FORM_DATA["showslider"]) { ?> selected="selected"<?php } ?>><?php echo $las["title"];?></option><?php } ?>
	</select>
	</div>
	
	<div class="actions">
	
		<input type="hidden" name="corder[]" class="corder" value="<?php echo $pg["orderid"];?>" size="2" maxlength="2" /> <input type="hidden" name="real_id[]" value="<?php echo $pg["id"];?>" />
	
	</div>
</li>

<?php $slider_exist = 1; } ?> 

