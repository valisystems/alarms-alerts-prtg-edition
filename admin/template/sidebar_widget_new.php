<?php 

// We run the queries for the widgets only if we need to
$hookadminws = $jakhooks->jakGethook("php_admin_widgets_sql");
if ($hookadminws)
foreach($hookadminws as $hasq)
{
	eval($hasq['phpcode']);
}

?>

<!-- Moving stuff -->
<ul class="jak_widget_move">
<?php if (isset($JAK_HOOKS) && is_array($JAK_HOOKS)) foreach($JAK_HOOKS as $v) { ?>

<li id="widget-<?php echo $v["id"];?>" class="jakwidget">
	<div class="form-group">
	<div class="checkbox">
	<label>
	<input type="checkbox" name="jak_hookshow[]" value="<?php echo $v["id"];?>"<?php if (isset($JAK_ACTIVE_GRID) && is_array($JAK_ACTIVE_GRID)) foreach($JAK_ACTIVE_GRID as $ag) { if ($ag["hookid"] == $v["id"]) echo ' checked="checked"';}?> /> <a href="index.php?p=plugins&amp;sp=hooks&amp;ssp=edit&amp;sssp=<?php echo $v["id"];?>"><?php echo $v["name"];?></a>
	</label>
	</div>
	</div>
	<div class="actions">
	
		<?php if (!empty($v["widgetcode"])) include_once APP_PATH.$v["widgetcode"];?>
	
		<input type="hidden" name="horder[]" class="sorder" value="<?php echo $v["exorder"];?>" /> <input type="hidden" name="real_hook_id[]" value="<?php echo $v["id"];?>" /> <input type="hidden" name="sreal_plugin_id[]" value="<?php echo $v["pluginid"];?>" />
	
	</div>
</li>

<?php } ?>
</ul>