<?php if (!isset($rf_exist)) { ?>

<li class="jakcontent">
	<div class="form-group">
	    <label class="control-label"><?php echo $lrf["register"]["r"];?></label>
	<div class="radio"><label><input type="radio" name="jak_rfconnect" value="1"<?php if ((isset($_REQUEST["jak_rfconnect"]) && $_REQUEST["jak_rfconnect"]) == '1' || (isset($JAK_FORM_DATA["showregister"]) && $JAK_FORM_DATA["showregister"] == '1')) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
	</label></div>
	<div class="radio"><label>
	<input type="radio" name="jak_rfconnect" value="0"<?php if ((isset($_REQUEST["jak_rfconnect"]) && $_REQUEST["jak_rfconnect"] != '1') || (isset($JAK_FORM_DATA["showregister"]) && $JAK_FORM_DATA["showregister"] != '1') || !isset($_REQUEST["jak_rfconnect"])) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
	</label>
	</div>
	</div>
	<div class="actions">
	
		<input type="hidden" name="corder_new[]" class="corder" value="3" /> <input type="hidden" name="real_plugin_id[]" value="<?php echo JAK_PLUGIN_REGISTER_FORM;?>" />
	
	</div>
</li>

<?php } ?>