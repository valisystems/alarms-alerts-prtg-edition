<?php if ($pg["pluginid"] == JAK_PLUGIN_GALLERY) { ?>

<li class="jakcontent">

	<div class="form-group">
			    <label class="control-label"><?php echo $tlgal["gallery"]["d27"];?></label>
			    <div class="row">
			    <div class="col-md-6">
			      <select name="jak_showgalleryorder" class="form-control">
			      <option value="ASC"<?php if (isset($JAK_FORM_DATA["showgalleryorder"]) && $JAK_FORM_DATA["showgalleryorder"] == "ASC") { ?> selected="selected"<?php } else { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g90"];?></option>
			      <option value="DESC"<?php if (isset($JAK_FORM_DATA["showgalleryorder"]) && $JAK_FORM_DATA["showgalleryorder"] == "DESC") { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g91"];?></option>
			      </select>
			      </div>
			      <div class="col-md-6">
			      <select name="jak_showgallerymany" class="form-control">
			      <?php for ($i = 0; $i <= 10; $i++) { ?>
			      <option value="<?php echo $i ?>"<?php if (isset($JAK_FORM_DATA["showgallerymany"]) && $JAK_FORM_DATA["showgallerymany"] == $i) { ?> selected="selected"<?php } ?>><?php echo $i; ?></option>
			      <?php } ?>
			      </select>
			      </div>
			    </div>
			  </div>
			  
			  <div class="form-group">
			      <label class="control-label"><?php echo $tl["general"]["g68"];?></label>
			      	<select name="jak_showgallery[]" multiple="multiple" class="form-control">
			      	<option value="0"<?php if (isset($JAK_FORM_DATA["showgallery"]) && $JAK_FORM_DATA["showgallery"] == 0) { ?> selected="selected"<?php } ?>><?php echo $tl["cform"]["c18"];?></option>
			      	<?php if (isset($JAK_GET_GALLERY) && is_array($JAK_GET_GALLERY)) foreach($JAK_GET_GALLERY as $gal) { ?>
			      	<option value="<?php echo $gal["id"];?>"<?php if (isset($JAK_FORM_DATA["showgallery"]) && $JAK_FORM_DATA["showgallery"] == $gal["id"]) { ?> selected="selected"<?php } ?>><?php echo $gal["title"];?></option>
			      	<?php } ?>
			      	</select>
			    </div>
	
			<div class="actions">
	
		<input type="hidden" name="corder[]" class="corder" value="<?php echo $pg["orderid"];?>" /> <input type="hidden" name="real_id[]" value="<?php echo $pg["id"];?>" />
	
	</div>
</li>

<?php $gallery_exist = 1; } ?> 

