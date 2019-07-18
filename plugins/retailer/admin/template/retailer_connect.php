<?php if ($pg["pluginid"] == JAK_PLUGIN_RETAILER) { ?>

<li class="jakcontent">
		<div class="form-group">
		    <label class="control-label"><?php echo $tlre["retailer"]["d27"];?></label>
		    <div class="row">
		    <div class="col-md-6">
		      <select name="jak_showretailerorder" class="form-control">
		      <option value="ASC"<?php if (isset($JAK_FORM_DATA["showretailerorder"]) && $JAK_FORM_DATA["showretailerorder"] == "ASC") { ?> selected="selected"<?php } else { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g90"];?></option>
		      <option value="DESC"<?php if (isset($JAK_FORM_DATA["showretailerorder"]) && $JAK_FORM_DATA["showretailerorder"] == "DESC") { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g91"];?></option>
		      </select>
		      </div>
		      <div class="col-md-6">
		      <select name="jak_showretailermany" class="form-control">
		      <?php for ($i = 0; $i <= 10; $i++) { ?>
		      <option value="<?php echo $i ?>"<?php if (isset($JAK_FORM_DATA["showretailermany"]) && $JAK_FORM_DATA["showretailermany"] == $i) { ?> selected="selected"<?php } ?>><?php echo $i; ?></option>
		      <?php } ?>
		      </select>
		      </div>
		    </div>
		  </div>
		  
		  <div class="form-group">
		      <label class="control-label"><?php echo $tl["general"]["g68"];?></label>
		      	<select name="jak_showretailer[]" multiple="multiple" class="form-control">
		      	<option value="0"<?php if (isset($JAK_FORM_DATA["showretailer"]) && $JAK_FORM_DATA["showretailer"] == 0) { ?> selected="selected"<?php } ?>><?php echo $tl["cform"]["c18"];?></option>
		      	<?php if (isset($JAK_GET_RETAILER) && is_array($JAK_GET_RETAILER)) foreach($JAK_GET_RETAILER as $ret) { ?>
		      	<option value="<?php echo $ret["id"];?>"<?php if (isset($JAK_FORM_DATA["showretailer"]) && $JAK_FORM_DATA["showretailer"] == $ret["id"]) { ?> selected="selected"<?php } ?>><?php echo $ret["title"];?></option>
		      	<?php } ?>
		      	</select>
		    </div>

		<div class="actions">
		
			<input type="hidden" name="corder[]" class="corder" value="<?php echo $pg["orderid"];?>" /> <input type="hidden" name="real_id[]" value="<?php echo $pg["id"];?>" />
		
		</div>
	</li>

<?php $retailer_exist = 1; } ?> 

