<?php if (!isset($gallery_exist)) { ?>

<li class="jakcontent">
	
	<div class="form-group">
	    <label class="control-label"><?php echo $tlgal["gallery"]["d27"];?></label>
	    <div class="row">
	    <div class="col-md-6">
	      <select name="jak_showgalleryorder" class="form-control">
	      <option value="ASC"<?php if (isset($_REQUEST["jak_showgalleryorder"]) && $_REQUEST["jak_showgalleryorder"] == "ASC") { ?> selected="selected"<?php } else { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g90"];?></option>
	      <option value="DESC"<?php if (isset($_REQUEST["jak_showgalleryorder"]) && $_REQUEST["jak_showgalleryorder"] == "DESC") { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g91"];?></option>
	      </select>
	      </div>
	      <div class="col-md-6">
	      <select name="jak_showgallerymany" class="form-control">
	      <?php for ($i = 0; $i <= 10; $i++) { ?>
	      <option value="<?php echo $i ?>"<?php if (isset($_REQUEST["jak_shownewsmany"]) && $_REQUEST["jak_shownewsmany"] == $i) { ?> selected="selected"<?php } ?>><?php echo $i; ?></option>
	      <?php } ?>
	      </select>
	    </div>
	    </div>
	  </div>
	  
	  <div class="form-group">
	      <label class="control-label"><?php echo $tl["general"]["g68"];?></label>
	      	<select name="jak_showgallery[]" multiple="multiple" class="form-control">
	      	<option value="0"<?php if (isset($_REQUEST["jak_showgallery"]) && $_REQUEST["jak_showgallery"] && in_array(0, $_REQUEST["jak_showgallery"])) { ?> selected="selected"<?php } else { ?> selected="selected"<?php } ?>><?php echo $tl["cform"]["c18"];?></option>
	      	<?php if (isset($JAK_GET_GALLERY) && is_array($JAK_GET_GALLERY)) foreach($JAK_GET_GALLERY as $gal) { ?>
	      	<option value="<?php echo $gal["id"];?>"<?php if (isset($_REQUEST["jak_showgallery"]) && $_REQUEST["jak_showgallery"] && in_array($gal["id"], $_REQUEST["jak_showgallery"])) { ?> selected="selected"<?php } ?>><?php echo $gal["title"];?></option>
	      	<?php } ?>
	      	</select>
	    </div>
	<div class="actions">
	
		<input type="hidden" name="corder_new[]" class="corder" value="3" size="3" /> <input type="hidden" name="real_plugin_id[]" value="<?php echo JAK_PLUGIN_GALLERY;?>" />
	
	</div>
</li>

<?php } ?>