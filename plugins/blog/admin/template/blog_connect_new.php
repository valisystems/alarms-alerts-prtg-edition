<?php if (!isset($blog_exist)) { ?>

<li class="jakcontent">
	<div class="form-group">
	<label class="control-label"><?php echo $tlblog["blog"]["d27"];?></label>
	<div class="row">
	<div class="col-md-6">
	      <select name="jak_showblogorder" class="form-control">
	      <option value="ASC"<?php if (isset($_REQUEST["jak_showblogorder"]) && $_REQUEST["jak_showblogorder"] == "ASC") { ?> selected="selected"<?php } else { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g90"];?></option>
	      <option value="DESC"<?php if (isset($_REQUEST["jak_showblogorder"]) && $_REQUEST["jak_showblogorder"] == "DESC") { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g91"];?></option>
	      </select>
	      </div>
	      <div class="col-md-6">
	      <select name="jak_showblogmany" class="form-control">
	      <?php for ($i = 0; $i <= 10; $i++) { ?>
	      <option value="<?php echo $i ?>"<?php if (isset($_REQUEST["jak_showblogmany"]) && $_REQUEST["jak_showblogmany"] == $i) { ?> selected="selected"<?php } ?>><?php echo $i; ?></option>
	      <?php } ?>
	      </select>
	      </div>
	      </div>
	  </div>
	  
	  <div class="form-group">
	      <label class="control-label"><?php echo $tl["general"]["g68"];?></label>
	      	<select name="jak_showblog[]" multiple="multiple" class="form-control">
	      	<option value="0"<?php if (isset($_REQUEST["jak_showblog"]) && $_REQUEST["jak_showblog"] && in_array(0, $_REQUEST["jak_showblog"])) { ?> selected="selected"<?php } else { ?> selected="selected"<?php } ?>><?php echo $tl["cform"]["c18"];?></option>
	      	<?php if (isset($JAK_GET_BLOG) && is_array($JAK_GET_BLOG)) foreach($JAK_GET_BLOG as $bl) { ?>
	      	<option value="<?php echo $bl["id"];?>"<?php if (isset($_REQUEST["jak_showblog"]) && $_REQUEST["jak_showblog"] && in_array($bl["id"], $_REQUEST["jak_showblog"])) { ?> selected="selected"<?php } ?>><?php echo $bl["title"];?></option>
	      	<?php } ?>
	      	</select>
	    </div>
	<div class="actions">
	
		<input type="hidden" name="corder_new[]" class="corder" value="3" /> <input type="hidden" name="real_plugin_id[]" value="<?php echo JAK_PLUGIN_BLOG;?>" />
	
	</div>
</li>

<?php } ?>