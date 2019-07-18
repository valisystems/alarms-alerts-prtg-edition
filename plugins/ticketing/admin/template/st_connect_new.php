<?php if (!isset($st_exist)) { ?>

<li class="jakcontent">
<div class="form-group">
    <label class="control-label"><?php echo $tlt["st"]["m"];?></label>
	<div class="row">
		<div class="col-md-6">
	      <select name="jak_showstorder" class="form-control">
	      <option value="ASC"<?php if (isset($_REQUEST["jak_showstorder"]) && $_REQUEST["jak_showstorder"] == "ASC") { ?> selected="selected"<?php } else { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g90"];?></option>
	      <option value="DESC"<?php if (isset($_REQUEST["jak_showstorder"]) && $_REQUEST["jak_showstorder"] == "DESC") { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g91"];?></option>
	      </select>
	    </div>
	    <div class="col-md-6">
	      <select name="jak_showstmany" class="form-control">
	      <?php for ($i = 0; $i <= 10; $i++) { ?>
	      <option value="<?php echo $i ?>"<?php if (isset($_REQUEST["jak_showstmany"]) && $_REQUEST["jak_showstmany"] == $i) { ?> selected="selected"<?php } ?>><?php echo $i; ?></option>
	      <?php } ?>
	      </select>
	    </div>
	 </div>
</div>
	  
	  <div class="form-group">
	      <label class="control-label"><?php echo $tl["general"]["g68"];?></label>
	      	<select name="jak_showst[]" multiple="multiple" class="form-control">
	      	<option value="0"<?php if (isset($_REQUEST["jak_showst"]) && $_REQUEST["jak_showst"] && in_array(0, $_REQUEST["jak_showst"])) { ?> selected="selected"<?php } else { ?> selected="selected"<?php } ?>><?php echo $tl["cform"]["c18"];?></option>
	      	<?php if (isset($JAK_GET_TICKETING) && is_array($JAK_GET_TICKETING)) foreach($JAK_GET_TICKETING as $ti) { ?>
	      	<option value="<?php echo $ti["id"];?>"<?php if (isset($_REQUEST["jak_showst"]) && $_REQUEST["jak_showst"] && in_array($ti["id"], $_REQUEST["jak_showst"])) { ?> selected="selected"<?php } ?>><?php echo $ti["title"];?></option>
	      	<?php } ?>
	      	</select>
	    </div>
	<div class="actions">
	
		<input type="hidden" name="corder_new[]" class="corder" value="3" /> <input type="hidden" name="real_plugin_id[]" value="<?php echo JAK_PLUGIN_TICKETING;?>" />
	
	</div>
</li>

<?php } ?>