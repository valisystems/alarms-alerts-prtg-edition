<?php if ($pg["pluginid"] == JAK_PLUGIN_TICKETING) { ?>

<li class="jakcontent">
	<div class="form-group">
		<label class="control-label"><?php echo $tlt["st"]["m"];?></label>
		<div class="row">
			<div class="col-md-6">
		    	<select name="jak_showstorder" class="form-control">
		      	<option value="ASC"<?php if (isset($JAK_FORM_DATA["showstorder"]) && $JAK_FORM_DATA["showstorder"] == "ASC") { ?> selected="selected"<?php } else { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g90"];?></option>
		      	<option value="DESC"<?php if (isset($JAK_FORM_DATA["showstorder"]) && $JAK_FORM_DATA["showstorder"] == "DESC") { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g91"];?></option>
		      	</select>
		    </div>
		   	<div class="col-md-6">
		    	<select name="jak_showstmany" class="form-control">
		      	<?php for ($i = 0; $i <= 10; $i++) { ?>
		      	<option value="<?php echo $i ?>"<?php if (isset($JAK_FORM_DATA["showstmany"]) && $JAK_FORM_DATA["showstmany"] == $i) { ?> selected="selected"<?php } ?>><?php echo $i; ?></option>
		      	<?php } ?>
		     	 </select>
		  	</div>
		</div>
	</div>
		  <div class="form-group">
		      <label class="control-label"><?php echo $tl["general"]["g68"];?></label>
		      	<select name="jak_showst[]" multiple="multiple" class="form-control">
		      	<option value="0"<?php if (isset($JAK_FORM_DATA["showticketing"]) && $JAK_FORM_DATA["showticketing"] == 0) { ?> selected="selected"<?php } ?>><?php echo $tl["cform"]["c18"];?></option>
		      	<?php if (isset($JAK_GET_TICKETING) && is_array($JAK_GET_TICKETING)) foreach($JAK_GET_TICKETING as $st) { ?>
		      	<option value="<?php echo $st["id"];?>"<?php if (isset($JAK_FORM_DATA["showticketing"]) && $JAK_FORM_DATA["showticketing"] == $st["id"]) { ?> selected="selected"<?php } ?>><?php echo $st["title"];?></option>
		      	<?php } ?>
		      	</select>
		  </div>

		<div class="actions">
		
			<input type="hidden" name="corder[]" class="corder" value="<?php echo $pg["orderid"];?>" /> <input type="hidden" name="real_id[]" value="<?php echo $pg["id"];?>" />
		
		</div>
	</li>

<?php $st_exist = 1; } ?> 

