<?php if (!isset($dl_exist)) { ?>

<li class="jakcontent">
	<div class="form-group">
	    <label class="control-label"><?php echo $tld["dload"]["d27"];?></label>
	    <div class="row">
	    <div class="col-md-6">
	      <select name="jak_showdlorder" class="form-control">
	      <option value="ASC"<?php if (isset($_REQUEST["jak_showdlorder"]) && $_REQUEST["jak_showdlorder"] == "ASC") { ?> selected="selected"<?php } else { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g90"];?></option>
	      <option value="DESC"<?php if (isset($_REQUEST["jak_showdlorder"]) && $_REQUEST["jak_showdlorder"] == "DESC") { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g91"];?></option>
	      </select>
	     </div>
	     <div class="col-md-6">
	      <select name="jak_showdlmany" class="form-control">
	      <?php for ($i = 0; $i <= 10; $i++) { ?>
	      <option value="<?php echo $i ?>"<?php if (isset($_REQUEST["jak_showdlmany"]) && $_REQUEST["jak_showdlmany"] == $i) { ?> selected="selected"<?php } ?>><?php echo $i; ?></option>
	      <?php } ?>
	      </select>
	    </div>
	  </div>
	 </div>
	  
	  <div class="form-group">
	      <label class="control-label"><?php echo $tl["general"]["g68"];?></label>
	      	<select name="jak_showdl[]" multiple="multiple" class="form-control">
	      	<option value="0"<?php if (isset($_REQUEST["jak_showdl"]) && $_REQUEST["jak_showdl"] && in_array(0, $_REQUEST["jak_showdl"])) { ?> selected="selected"<?php } else { ?> selected="selected"<?php } ?>><?php echo $tl["cform"]["c18"];?></option>
	      	<?php if (isset($JAK_GET_DOWNLOAD) && is_array($JAK_GET_DOWNLOAD)) foreach($JAK_GET_DOWNLOAD as $dl) { ?>
	      	<option value="<?php echo $dl["id"];?>"<?php if (isset($_REQUEST["jak_showdl"]) && $_REQUEST["jak_showdl"] && in_array($dl["id"], $_REQUEST["jak_showdl"])) { ?> selected="selected"<?php } ?>><?php echo $dl["title"];?></option>
	      	<?php } ?>
	      	</select>
	    </div>
	<div class="actions">
	
		<input type="hidden" name="corder_new[]" class="corder" value="3" /> <input type="hidden" name="real_plugin_id[]" value="<?php echo JAK_PLUGIN_DOWNLOAD;?>" />
	
	</div>
</li>

<?php } ?>