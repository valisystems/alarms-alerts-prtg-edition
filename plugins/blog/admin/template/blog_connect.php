<?php if ($pg["pluginid"] == JAK_PLUGIN_BLOG) { ?>

<li class="jakcontent">
		<div class="form-group">
		<label class="control-label"><?php echo $tlblog["blog"]["d27"];?></label>
		<div class="row">
		<div class="col-md-6">
		      <select name="jak_showblogorder" class="form-control">
		      <option value="ASC"<?php if (isset($JAK_FORM_DATA["showblogorder"]) && $JAK_FORM_DATA["showblogorder"] == "ASC") { ?> selected="selected"<?php } else { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g90"];?></option>
		      <option value="DESC"<?php if (isset($JAK_FORM_DATA["showblogorder"]) && $JAK_FORM_DATA["showblogorder"] == "DESC") { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g91"];?></option>
		      </select>
		      </div>
		      <div class="col-md-6">
		      <select name="jak_showblogmany" class="form-control">
		      <?php for ($i = 0; $i <= 10; $i++) { ?>
		      <option value="<?php echo $i ?>"<?php if (isset($JAK_FORM_DATA["showblogmany"]) && $JAK_FORM_DATA["showblogmany"] == $i) { ?> selected="selected"<?php } ?>><?php echo $i; ?></option>
		      <?php } ?>
		      </select>
		      </div>
		      </div>
		  </div>
		  
		  <div class="form-group">
		      <label class="control-label"><?php echo $tl["general"]["g68"];?></label>
		      	<select name="jak_showblog[]" multiple="multiple" class="form-control">
		      	<option value="0"<?php if (isset($JAK_FORM_DATA["showblog"]) && $JAK_FORM_DATA["showblog"] == 0) { ?> selected="selected"<?php } ?>><?php echo $tl["cform"]["c18"];?></option>
		      	<?php if (isset($JAK_GET_BLOG) && is_array($JAK_GET_BLOG)) foreach($JAK_GET_BLOG as $fq) { ?>
		      	<option value="<?php echo $fq["id"];?>"<?php if (isset($JAK_FORM_DATA["showblog"]) && $JAK_FORM_DATA["showblog"] == $fq["id"]) { ?> selected="selected"<?php } ?>><?php echo $fq["title"];?></option>
		      	<?php } ?>
		      	</select>
		    </div>

		<div class="actions">
		
			<input type="hidden" name="corder[]" class="corder" value="<?php echo $pg["orderid"];?>" /> <input type="hidden" name="real_id[]" value="<?php echo $pg["id"];?>" />
		
		</div>
	</li>

<?php $blog_exist = 1; } ?> 

