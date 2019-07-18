<?php if (!isset($slider_exist)) {

// We run the queries for the widgets only if we need to
$hookadminws = $jakhooks->jakGethook("php_admin_widgets_sql");
if ($hookadminws)
foreach($hookadminws as $hasq)
{
	eval($hasq['phpcode']);
}

?>

<li class="jakcontent">

	<div class="form-group">
	    <label class="control-label"><?php echo $tlls["ls"]["m"];?></label>
	    <select name="jak_showslider" class="form-control">
	<option value="0"<?php if (isset($_REQUEST["jak_showslider"]) && $_REQUEST["jak_showslider"] == '0' || !isset($_REQUEST["jak_showslider"])) { ?> selected="selected"<?php } ?>><?php echo $tl["cform"]["c18"];?></option>
	<?php if (isset($JAK_GET_SLIDER) && is_array($JAK_GET_SLIDER)) foreach($JAK_GET_SLIDER as $las) { ?><option value="<?php echo $las["id"];?>"<?php if (isset($_REQUEST["jak_showslider"]) && $las["id"] == $_REQUEST["jak_showslider"]) { ?> selected="selected"<?php } ?>><?php echo $las["title"];?></option><?php } ?>
		</select>
	</div>
	
	<div class="actions">
	
		<input type="hidden" name="corder_new[]" class="corder" value="2" size="2" maxlength="2" /> <input type="hidden" name="real_plugin_id[]" value="<?php echo JAK_PLUGIN_SLIDER;?>" />
	
	</div>
</li>

<?php } ?>