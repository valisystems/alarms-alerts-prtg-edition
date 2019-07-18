<?php if (!isset($retailer_exist)) { ?>

<li class="jakcontent">
	<div class="form-group">
	    <label class="control-label"><?php echo $tlre["retailer"]["d27"];?></label>
	    <div class="row">
	    <div class="col-md-6">
	      <select name="jak_showretailerorder" class="form-control">
	      <option value="ASC"<?php if (isset($_REQUEST["jak_showretailerorder"]) && $_REQUEST["jak_showretailerorder"] == "ASC") { ?> selected="selected"<?php } else { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g90"];?></option>
	      <option value="DESC"<?php if (isset($_REQUEST["jak_showretailerorder"]) && $_REQUEST["jak_showretailerorder"] == "DESC") { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g91"];?></option>
	      </select>
	      </div>
	      <div class="col-md-6">
	      <select name="jak_showretailermany" class="form-control">
	      <?php for ($i = 0; $i <= 10; $i++) { ?>
	      <option value="<?php echo $i ?>"<?php if (isset($_REQUEST["jak_showretailermany"]) && $_REQUEST["jak_showretailermany"] == $i) { ?> selected="selected"<?php } ?>><?php echo $i; ?></option>
	      <?php } ?>
	      </select>
	      </div>
	    </div>
	  </div>
	  
	  <div class="form-group">
	      <label class="control-label"><?php echo $tl["general"]["g68"];?></label>
	      	<select name="jak_showretailer[]" multiple="multiple" class="form-control">
	      	<option value="0"<?php if (isset($_REQUEST["jak_showretailer"]) && $_REQUEST["jak_showretailer"] && in_array(0, $_REQUEST["jak_showretailer"])) { ?> selected="selected"<?php } else { ?> selected="selected"<?php } ?>><?php echo $tl["cform"]["c18"];?></option>
	      	<?php if (isset($JAK_GET_RETAILER) && is_array($JAK_GET_RETAILER)) foreach($JAK_GET_RETAILER as $ret) { ?>
	      	<option value="<?php echo $ret["id"];?>"<?php if (isset($_REQUEST["jak_showretailer"]) && $_REQUEST["jak_showretailer"] && in_array($ret["id"], $_REQUEST["jak_showretailer"])) { ?> selected="selected"<?php } ?>><?php echo $ret["title"];?></option>
	      	<?php } ?>
	      	</select>
	    </div>
	<div class="actions">
	
		<input type="hidden" name="corder_new[]" class="corder" value="3" /> <input type="hidden" name="real_plugin_id[]" value="<?php echo JAK_PLUGIN_RETAILER;?>" />
	
	</div>
</li>

<?php } ?>