<?php if ($pg["pluginid"] == JAK_PLUGIN_DOWNLOAD) { ?>

<li class="jakcontent">
		<div class="form-group">
		    <label class="control-label"><?php echo $tld["dload"]["d27"];?></label>
		    <div class="row">
		    <div class="col-md-6">
		      <select name="jak_showdlorder" class="form-control">
		      <option value="ASC"<?php if (isset($JAK_FORM_DATA["showdlorder"]) && $JAK_FORM_DATA["showdlorder"] == "ASC") { ?> selected="selected"<?php } else { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g90"];?></option>
		      <option value="DESC"<?php if (isset($JAK_FORM_DATA["showdlorder"]) && $JAK_FORM_DATA["showdlorder"] == "DESC") { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g91"];?></option>
		      </select>
		     </div>
		     <div class="col-md-6">
		      <select name="jak_showdlmany" class="form-control">
		      <?php for ($i = 0; $i <= 10; $i++) { ?>
		      <option value="<?php echo $i ?>"<?php if (isset($JAK_FORM_DATA["showdlmany"]) && $JAK_FORM_DATA["showdlmany"] == $i) { ?> selected="selected"<?php } ?>><?php echo $i; ?></option>
		      <?php } ?>
		      </select>
		    </div>
		  </div>
		 </div>
		  
		  <div class="form-group">
		      <label class="control-label"><?php echo $tl["general"]["g68"];?></label>
		      	<select name="jak_showdl[]" multiple="multiple" class="form-control">
		      	<option value="0"<?php if (isset($JAK_FORM_DATA["showdownload"]) && $JAK_FORM_DATA["showdownload"] == 0) { ?> selected="selected"<?php } ?>><?php echo $tl["cform"]["c18"];?></option>
		      	<?php if (isset($JAK_GET_DOWNLOAD) && is_array($JAK_GET_DOWNLOAD)) foreach($JAK_GET_DOWNLOAD as $dl) { ?>
		      	<option value="<?php echo $dl["id"];?>"<?php if (isset($JAK_FORM_DATA["showdownload"]) && $JAK_FORM_DATA["showdownload"] == $dl["id"]) { ?> selected="selected"<?php } ?>><?php echo $dl["title"];?></option>
		      	<?php } ?>
		      	</select>
		    </div>

		<div class="actions">
		
			<input type="hidden" name="corder[]" class="corder" value="<?php echo $pg["orderid"];?>" /> <input type="hidden" name="real_id[]" value="<?php echo $pg["id"];?>" />
		
		</div>
	</li>

<?php $dl_exist = 1; } ?> 

