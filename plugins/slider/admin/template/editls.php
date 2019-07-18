<?php include_once APP_PATH.'admin/template/header.php';?>

<?php if ($page3 == "s") { ?>
<div class="alert alert-success fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?php echo $tl["general"]["g7"];?>
</div>
<?php } if ($page3 == "e") { ?>
<div class="alert alert-danger fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?php echo $tl["errorpage"]["sql"];?>
</div>
<?php } ?>

<?php if ($errors) { ?>
<div class="alert alert-danger fade in">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<?php if (isset($errors["e"])) echo $errors["e"];
		  if (isset($errors["e1"])) echo $errors["e1"];
		  if (isset($errors["e2"])) echo $errors["e2"];
		  if (isset($errors["e3"])) echo $errors["e3"];
		  if (isset($errors["e4"])) echo $errors["e4"];?>
</div>
<?php } ?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">

<ul class="nav nav-tabs" id="cmsTab">
		<li class="active"><a href="#style_tabs-1"><?php echo $tl["page"]["p4"];?></a></li>
		<li><a href="#style_tabs-2"><?php echo $tl["general"]["g77"];?></a></li>
		<li><a href="#style_tabs-3"><?php echo $tlls["ls"]["d49"];?></a></li>
</ul>

<div class="tab-content">
<div class="tab-pane active" id="style_tabs-1">
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["title"]["t13"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table">
<tr>
	<td><?php echo $tlls["ls"]["d8"];?></td>
	<td><div class="form-group<?php if (isset($errors["e1"])) echo " has-error";?>">
		<input class="form-control" type="text" name="jak_title" value="<?php echo $JAK_FORM_DATA["title"];?>" />
	</div></td>
</tr>
<tr>
	<td><?php echo $tlls["ls"]["d9"];?></td>
	<td>
	<div class="input-group<?php if (isset($errors["e2"])) echo " has-error";?>"><input type="text" name="jak_lswidth" class="form-control" value="<?php echo $JAK_FORM_DATA["lswidth"] ?>" />
	<span class="input-group-addon">px / &#37;</span>
	</div></td>
</tr>
<tr>
	<td><?php echo $tlls["ls"]["d10"];?></td>
	<td>
	<div class="input-group<?php if (isset($errors["e3"])) echo " has-error";?>"><input type="text" name="jak_lsheight" class="form-control" value="<?php echo $JAK_FORM_DATA["lsheight"] ?>" />
	<span class="input-group-addon">px / &#37;</span>
	</div></td>
</tr>
<tr>
	<td><?php echo $tlls["ls"]["d23"];?></td>
	<td>
	<div class="input-group">
		<input type="text" name="jak_logod" id="jak_logod" class="form-control" value="<?php echo $JAK_FORM_DATA["lslogo"]; ?>" />
		<span class="input-group-btn">
		  <a class="btn btn-info ifManager" type="button" href="../js/editor/plugins/filemanager/dialog.php?type=1&subfolder=&editor=mce_0&lang=eng&fldr=&field_id=jak_logod"><?php echo $tl["general"]["g69"];?></a>
		</span>
	</div><!-- /input-group -->
	</td>
</tr>
<tr>
	<td><?php echo $tlls["ls"]["d7"];?></td>
	<td>
	<div class="input-group">
		<input type="text" name="jak_logolink" id="jak_logolink" class="form-control" value="<?php echo $JAK_FORM_DATA["lslogolink"]; ?>" />
		<span class="input-group-btn">
		  <a class="btn btn-info ifManager" type="button" href="../js/editor/plugins/filemanager/dialog.php?type=1&subfolder=&editor=mce_0&lang=eng&fldr=&field_id=jak_logolink"><?php echo $tl["general"]["g69"];?></a>
		</span>
	</div><!-- /input-group -->
	</td>
</tr>
<tr>
	<td><?php echo $tlls["ls"]["d1"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_animatef" value="1"<?php if ($JAK_FORM_DATA["lsanimatef"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_animatef" value="0"<?php if ($JAK_FORM_DATA["lsanimatef"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlls["ls"]["d6"];?></td>
	<td>
	
	<div class="row">
		<?php if (isset($theme_files) && is_array($theme_files)) foreach($theme_files as $l) { ?>
			<div class="col-sm-3 col-md-3">
				<div class="thumbnail">
				<img src="<?php echo BASE_URL_ORIG;?>plugins/slider/skins/<?php echo $l;?>/preview.jpg" alt="<?php echo $l;?>" width="100" height="100" />
				<div class="caption">
			
				<div class="radio"><label><input type="radio" name="jak_theme" value="<?php echo $l;?>"<?php if ($JAK_FORM_DATA["lstheme"] == $l) { ?> checked="checked"<?php } ?> /> <?php echo $l;?></label></div>
	
			</div>
			</div>
			</div>
		<?php } ?>
	 </div>
	
	</td>
</tr>
<tr>
	<td><?php echo $tlls["ls"]["d3"];?></td>
	<td><select name="jak_transition" class="form-control">
	<option value="swing"<?php if ($JAK_FORM_DATA["lstransition"] == 'swing') { ?> selected="selected"<?php } ?>>Swing</option>
	<option value="easeInQuad"<?php if ($JAK_FORM_DATA["lstransition"] == 'easeInQuad') { ?> selected="selected"<?php } ?>>easeInQuad</option>
	<option value="easeOutQuad"<?php if ($JAK_FORM_DATA["lstransition"] == 'easeOutQuad') { ?> selected="selected"<?php } ?>>easeOutQuad</option>
	<option value="easeInOutQuad"<?php if ($JAK_FORM_DATA["lstransition"] == 'easeInOutQuad') { ?> selected="selected"<?php } ?>>easeInOutQuad</option>
	<option value="easeInCubic"<?php if ($JAK_FORM_DATA["lstransition"] == 'easeInCubic') { ?> selected="selected"<?php } ?>>easeInCubic</option>
	<option value="easeOutCubic"<?php if ($JAK_FORM_DATA["lstransition"] == 'easeOutCubic') { ?> selected="selected"<?php } ?>>easeOutCubic</option>
	<option value="easeInOutCubic"<?php if ($JAK_FORM_DATA["lstransition"] == 'easeInOutCubic') { ?> selected="selected"<?php } ?>>easeInOutCubic</option>
	<option value="easeInQuart"<?php if ($JAK_FORM_DATA["lstransition"] == 'easeInQuart') { ?> selected="selected"<?php } ?>>easeInQuart</option>
	<option value="easeOutQuart"<?php if ($JAK_FORM_DATA["lstransition"] == 'easeOutQuart') { ?> selected="selected"<?php } ?>>easeOutQuart</option>
	<option value="easeInOutQuart"<?php if ($JAK_FORM_DATA["lstransition"] == 'easeInOutQuart') { ?> selected="selected"<?php } ?>>easeInOutQuart</option>
	<option value="easeInQuint"<?php if ($JAK_FORM_DATA["lstransition"] == 'easeInQuint') { ?> selected="selected"<?php } ?>>easeInQuint</option>
	<option value="easeOutQuint"<?php if ($JAK_FORM_DATA["lstransition"] == 'easeOutQuint') { ?> selected="selected"<?php } ?>>easeOutQuint</option>
	<option value="easeInOutQuint"<?php if ($JAK_FORM_DATA["lstransition"] == 'easeInOutQuint') { ?> selected="selected"<?php } ?>>easeInOutQuint</option>
	<option value="easeInSine"<?php if ($JAK_FORM_DATA["lstransition"] == 'easeInSine') { ?> selected="selected"<?php } ?>>easeInSine</option>
	<option value="easeOutSine"<?php if ($JAK_FORM_DATA["lstransition"] == 'easeOutSine') { ?> selected="selected"<?php } ?>>easeOutSine</option>
	<option value="easeInOutSine"<?php if ($JAK_FORM_DATA["lstransition"] == 'easeInOutSine') { ?> selected="selected"<?php } ?>>easeInOutSine</option>
	<option value="easeInExpo"<?php if ($JAK_FORM_DATA["lstransition"] == 'easeInExpo') { ?> selected="selected"<?php } ?>>easeInExpo</option>
	<option value="easeOutExpo"<?php if ($JAK_FORM_DATA["lstransition"] == 'easeOutExpo') { ?> selected="selected"<?php } ?>>easeOutExpo</option>
	<option value="easeInOutExpo"<?php if ($JAK_FORM_DATA["lstransition"] == 'easeInOutExpo') { ?> selected="selected"<?php } ?>>easeInOutExpo</option>
	<option value="easeInCirc"<?php if ($JAK_FORM_DATA["lstransition"] == 'easeInCirc') { ?> selected="selected"<?php } ?>>easeInCirc</option>
	<option value="easeOutCirc"<?php if ($JAK_FORM_DATA["lstransition"] == 'easeOutCirc') { ?> selected="selected"<?php } ?>>easeOutCirc</option>
	<option value="easeInOutCirc"<?php if ($JAK_FORM_DATA["lstransition"] == 'easeInOutCirc') { ?> selected="selected"<?php } ?>>easeInOutCirc</option>
	<option value="easeInElastic"<?php if ($JAK_FORM_DATA["lstransition"] == 'easeInElastic') { ?> selected="selected"<?php } ?>>easeInElastic</option>
	<option value="easeOutElastic"<?php if ($JAK_FORM_DATA["lstransition"] == 'easeOutElastic') { ?> selected="selected"<?php } ?>>easeOutElastic</option>
	<option value="easeInOutElastic"<?php if ($JAK_FORM_DATA["lstransition"] == 'easeInOutElastic') { ?> selected="selected"<?php } ?>>easeInOutElastic</option>
	<option value="easeInBack"<?php if ($JAK_FORM_DATA["lstransition"] == 'easeInBack') { ?> selected="selected"<?php } ?>>easeInBack</option>
	<option value="easeOutBack"<?php if ($JAK_FORM_DATA["lstransition"] == 'easeOutBack') { ?> selected="selected"<?php } ?>>easeOutBack</option>
	<option value="easeInOutBack"<?php if ($JAK_FORM_DATA["lstransition"] == 'easeInOutBack') { ?> selected="selected"<?php } ?>>easeInOutBack</option>
	<option value="easeInBounce"<?php if ($JAK_FORM_DATA["lstransition"] == 'easeInBounce') { ?> selected="selected"<?php } ?>>easeInBounce</option>
	<option value="easeOutBounce"<?php if ($JAK_FORM_DATA["lstransition"] == 'easeOutBounce') { ?> selected="selected"<?php } ?>>easeOutBounce</option>
	<option value="easeInOutBounce"<?php if ($JAK_FORM_DATA["lstransition"] == 'easeInOutBounce') { ?> selected="selected"<?php } ?>>easeInOutBounce</option>
	</select></td>
</tr>
<tr>
	<td><?php echo $tlls["ls"]["d2"];?></td>
	<td><select name="jak_transition_out" class="form-control">
	<option value="swing"<?php if ($JAK_FORM_DATA["lstransitionout"] == 'swing') { ?> selected="selected"<?php } ?>>Swing</option>
	<option value="easeInQuad"<?php if ($JAK_FORM_DATA["lstransitionout"] == 'easeInQuad') { ?> selected="selected"<?php } ?>>easeInQuad</option>
	<option value="easeOutQuad"<?php if ($JAK_FORM_DATA["lstransitionout"] == 'easeOutQuad') { ?> selected="selected"<?php } ?>>easeOutQuad</option>
	<option value="easeInOutQuad"<?php if ($JAK_FORM_DATA["lstransitionout"] == 'easeInOutQuad') { ?> selected="selected"<?php } ?>>easeInOutQuad</option>
	<option value="easeInCubic"<?php if ($JAK_FORM_DATA["lstransitionout"] == 'easeInCubic') { ?> selected="selected"<?php } ?>>easeInCubic</option>
	<option value="easeOutCubic"<?php if ($JAK_FORM_DATA["lstransitionout"] == 'easeOutCubic') { ?> selected="selected"<?php } ?>>easeOutCubic</option>
	<option value="easeInOutCubic"<?php if ($JAK_FORM_DATA["lstransitionout"] == 'easeInOutCubic') { ?> selected="selected"<?php } ?>>easeInOutCubic</option>
	<option value="easeInQuart"<?php if ($JAK_FORM_DATA["lstransitionout"] == 'easeInQuart') { ?> selected="selected"<?php } ?>>easeInQuart</option>
	<option value="easeOutQuart"<?php if ($JAK_FORM_DATA["lstransitionout"] == 'easeOutQuart') { ?> selected="selected"<?php } ?>>easeOutQuart</option>
	<option value="easeInOutQuart"<?php if ($JAK_FORM_DATA["lstransitionout"] == 'easeInOutQuart') { ?> selected="selected"<?php } ?>>easeInOutQuart</option>
	<option value="easeInQuint"<?php if ($JAK_FORM_DATA["lstransitionout"] == 'easeInQuint') { ?> selected="selected"<?php } ?>>easeInQuint</option>
	<option value="easeOutQuint"<?php if ($JAK_FORM_DATA["lstransitionout"] == 'easeOutQuint') { ?> selected="selected"<?php } ?>>easeOutQuint</option>
	<option value="easeInOutQuint"<?php if ($JAK_FORM_DATA["lstransitionout"] == 'easeInOutQuint') { ?> selected="selected"<?php } ?>>easeInOutQuint</option>
	<option value="easeInSine"<?php if ($JAK_FORM_DATA["lstransitionout"] == 'easeInSine') { ?> selected="selected"<?php } ?>>easeInSine</option>
	<option value="easeOutSine"<?php if ($JAK_FORM_DATA["lstransitionout"] == 'easeOutSine') { ?> selected="selected"<?php } ?>>easeOutSine</option>
	<option value="easeInOutSine"<?php if ($JAK_FORM_DATA["lstransitionout"] == 'easeInOutSine') { ?> selected="selected"<?php } ?>>easeInOutSine</option>
	<option value="easeInExpo"<?php if ($JAK_FORM_DATA["lstransitionout"] == 'easeInExpo') { ?> selected="selected"<?php } ?>>easeInExpo</option>
	<option value="easeOutExpo"<?php if ($JAK_FORM_DATA["lstransitionout"] == 'easeOutExpo') { ?> selected="selected"<?php } ?>>easeOutExpo</option>
	<option value="easeInOutExpo"<?php if ($JAK_FORM_DATA["lstransitionout"] == 'easeInOutExpo') { ?> selected="selected"<?php } ?>>easeInOutExpo</option>
	<option value="easeInCirc"<?php if ($JAK_FORM_DATA["lstransitionout"] == 'easeInCirc') { ?> selected="selected"<?php } ?>>easeInCirc</option>
	<option value="easeOutCirc"<?php if ($JAK_FORM_DATA["lstransitionout"] == 'easeOutCirc') { ?> selected="selected"<?php } ?>>easeOutCirc</option>
	<option value="easeInOutCirc"<?php if ($JAK_FORM_DATA["lstransitionout"] == 'easeInOutCirc') { ?> selected="selected"<?php } ?>>easeInOutCirc</option>
	<option value="easeInElastic"<?php if ($JAK_FORM_DATA["lstransitionout"] == 'easeInElastic') { ?> selected="selected"<?php } ?>>easeInElastic</option>
	<option value="easeOutElastic"<?php if ($JAK_FORM_DATA["lstransitionout"] == 'easeOutElastic') { ?> selected="selected"<?php } ?>>easeOutElastic</option>
	<option value="easeInOutElastic"<?php if ($JAK_FORM_DATA["lstransitionout"] == 'easeInOutElastic') { ?> selected="selected"<?php } ?>>easeInOutElastic</option>
	<option value="easeInBack"<?php if ($JAK_FORM_DATA["lstransitionout"] == 'easeInBack') { ?> selected="selected"<?php } ?>>easeInBack</option>
	<option value="easeOutBack"<?php if ($JAK_FORM_DATA["lstransitionout"] == 'easeOutBack') { ?> selected="selected"<?php } ?>>easeOutBack</option>
	<option value="easeInOutBack"<?php if ($JAK_FORM_DATA["lstransitionout"] == 'easeInOutBack') { ?> selected="selected"<?php } ?>>easeInOutBack</option>
	<option value="easeInBounce"<?php if ($JAK_FORM_DATA["lstransitionout"] == 'easeInBounce') { ?> selected="selected"<?php } ?>>easeInBounce</option>
	<option value="easeOutBounce"<?php if ($JAK_FORM_DATA["lstransitionout"] == 'easeOutBounce') { ?> selected="selected"<?php } ?>>easeOutBounce</option>
	<option value="easeInOutBounce"<?php if ($JAK_FORM_DATA["lstransitionout"] == 'easeInOutBounce') { ?> selected="selected"<?php } ?>>easeInOutBounce</option>
	</select></td>
</tr>
<tr>
	<td><?php echo $tlls["ls"]["d16"];?></td>
	<td><select name="jak_direction" class="form-control">
	<option value="top"<?php if ($JAK_FORM_DATA["lsdirection"] == "top") { ?> selected="selected"<?php } ?>><?php echo $tlls["ls"]["d17"];?></option>
	<option value="left"<?php if ($JAK_FORM_DATA["lsdirection"] == "left") { ?> selected="selected"<?php } ?>><?php echo $tlls["ls"]["d18"];?></option>
	<option value="bottom"<?php if ($JAK_FORM_DATA["lsdirection"] == "bottom") { ?> selected="selected"<?php } ?>><?php echo $tlls["ls"]["d19"];?></option>
	<option value="right"<?php if ($JAK_FORM_DATA["lsdirection"] == "right") { ?> selected="selected"<?php } ?>><?php echo $tlls["ls"]["d20"];?></option>
	</select></td>
</tr>
<tr>
	<td><?php echo $tlls["ls"]["d5"];?></td>
	<td><select name="jak_pause" class="form-control">
	<?php for($ou=200; $ou<=20000; $ou += 200) { ?>
	<option value="<?php echo $ou;?>"<?php if ($JAK_FORM_DATA["lspause"] == $ou) { ?> selected="selected"<?php } ?>><?php echo $ou;?></option>
	<?php } ?>
	</select></td>
</tr>
<tr>
	<td><?php echo $tlls["ls"]["d50"];?> <a class="cms-help" data-content="<?php echo $tlls["ls"]["h"];?>" href="javascript:void(0)" data-original-title="<?php echo $tl["title"]["t21"];?>"><i class="fa fa-question-circle"></i></a></td>
	<td>
	<div class="radio"><label>
	<input type="radio" name="jak_ontop" value="1"<?php if ($JAK_FORM_DATA["lsontop"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
	</label></div>
	<div class="radio"><label>
	<input type="radio" name="jak_ontop" value="0"<?php if ($JAK_FORM_DATA["lsontop"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
	</label></div>
	</td>
</tr>
<tr>
	<td><?php echo $tlls["ls"]["d42"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_responsive" value="1"<?php if ($JAK_FORM_DATA["lsresponsive"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_responsive" value="0"<?php if ($JAK_FORM_DATA["lsresponsive"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlls["ls"]["d24"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_autostart" value="1"<?php if ($JAK_FORM_DATA["autostart"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_autostart" value="0"<?php if ($JAK_FORM_DATA["autostart"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlls["ls"]["d21"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_navbutton" value="1"<?php if ($JAK_FORM_DATA["navibutton"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_navbutton" value="0"<?php if ($JAK_FORM_DATA["navibutton"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlls["ls"]["d22"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_buttonnext" value="1"<?php if ($JAK_FORM_DATA["naviprevnext"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_buttonnext" value="0"<?php if ($JAK_FORM_DATA["naviprevnext"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlls["ls"]["d25"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_preload" value="1"<?php if ($JAK_FORM_DATA["imgpreload"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_preload" value="0"<?php if ($JAK_FORM_DATA["imgpreload"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlls["ls"]["d36"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_mhover" value="1"<?php if ($JAK_FORM_DATA["pausehover"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_mhover" value="0"<?php if ($JAK_FORM_DATA["pausehover"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlls["ls"]["d37"];?></td>
	<td><select name="jak_loops" class="form-control">
	<option value="0"<?php if ($JAK_FORM_DATA["lsloops"] == 0) { ?> selected="selected"<?php } ?>>0 (<?php echo $tlls["ls"]["d41"];?>)</option>
	<?php for ($i = 1; $i <= 99; $i++) { ?>
	<option value="<?php echo $i ?>"<?php if ($JAK_FORM_DATA["lsloops"] == $i) { ?> selected="selected"<?php } ?>><?php echo $i; ?></option>
	<?php } ?>
	</select></td>
</tr>
<tr>
	<td><?php echo $tlls["ls"]["d38"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_floops" value="1"<?php if ($JAK_FORM_DATA["lsfloops"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_floops" value="0"<?php if ($JAK_FORM_DATA["lsfloops"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlls["ls"]["d39"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_autov" value="1"<?php if ($JAK_FORM_DATA["lsavideo"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_autov" value="0"<?php if ($JAK_FORM_DATA["lsavideo"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlls["ls"]["d40"];?></td>
	<td><select name="jak_prevv" class="form-control">
	<option value="maxresdefault.jpg"<?php if ($JAK_FORM_DATA["lsyvprev"] == "maxresdefault.jpg") { ?> selected="selected"<?php } ?>>maxresdefault.jpg</option>
	<option value="hqdefault.jpg"<?php if ($JAK_FORM_DATA["lsyvprev"] == "hqdefault.jpg") { ?> selected="selected"<?php } ?>>hqdefault.jpg</option>
	<option value="mqdefault.jpg"<?php if ($JAK_FORM_DATA["lsyvprev"] == "mqdefault.jpg") { ?> selected="selected"<?php } ?>>mqdefault.jpg</option>
	<option value="default.jpg"<?php if ($JAK_FORM_DATA["lsyvprev"] == "default.jpg") { ?> selected="selected"<?php } ?>>default.jpg</option>
	</select></td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>	

<div class="box box-danger">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["general"]["g88"];?> <a class="cms-help" data-content="<?php echo $tl["help"]["h"];?>" href="javascript:void(0)" data-original-title="<?php echo $tl["title"]["t21"];?>"><i class="fa fa-question-circle"></i></a></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table">
<tr>
	<td><select name="jak_permission[]" multiple="multiple" class="form-control">
	<option value="0"<?php if ($JAK_FORM_DATA["permission"] == '0') { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g84"];?></option>
	<?php if (isset($JAK_USERGROUP) && is_array($JAK_USERGROUP)) foreach($JAK_USERGROUP as $v) { ?><option value="<?php echo $v["id"];?>"<?php if (in_array($v["id"], explode(',', $JAK_FORM_DATA["permission"]))) { ?> selected="selected"<?php } ?>><?php echo $v["name"];?></option><?php } ?>
	</select></td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>

</div>
<div class="tab-pane" id="style_tabs-2">

<?php if (isset($JAK_SLIDER_PICS) && is_array($JAK_SLIDER_PICS)) $count = 0; foreach($JAK_SLIDER_PICS as $p) { if ($p['layer'] == 0) { $count++;?>

<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tlls["ls"]["d11"].' - '.$count;?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table">
<tr>
	<td><?php echo $tlls["ls"]["d33"];?></td>
	<td><input type="checkbox" name="jak_activel[]" value="1" checked="checked" /></td>
</tr>
<tr>
	<td><?php echo $tlls["ls"]["d34"];?></td>
	<td><input type="checkbox" name="jak_sod[]" value="<?php echo $p["id"];?>" /><input type="hidden" name="jak_layerid[]" value="<?php echo $p["id"];?>" /></td>
</tr>
<tr>
	<td><?php echo $tlls["ls"]["d43"];?></td>
	<td>
	<div class="input-group">
	<input type="text" name="jak_2d_l[]" class="form-control" value="<?php echo $p["slide2d"];?>">
	<span class="input-group-addon"><a class="lsHelp" href="../plugins/slider/admin/doc/index.html#slide-transitions"><i class="fa fa-question-circle"></i></a></span>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tlls["ls"]["d44"];?></td>
	<td>
	<div class="input-group">
	<input type="text" name="jak_3d_l[]" class="form-control" value="<?php echo $p["slide3d"];?>">
	<span class="input-group-addon"><a class="lsHelp" href="../plugins/slider/admin/doc/index.html#slide-transitions"><i class="fa fa-question-circle"></i></a></span>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tlls["ls"]["d45"];?></td>
	<td>
	<div class="input-group">
	<input type="text" name="jak_ts_l[]" class="form-control" value="<?php echo $p["timeshift"];?>">
	<span class="input-group-addon"><a class="lsHelp" href="../plugins/slider/admin/doc/index.html#configuring-slides"><i class="fa fa-question-circle"></i></a></span>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tlls["ls"]["d51"];?></td>
	<td>
	<div class="input-group">
	<input type="text" name="jak_deep_l[]" class="form-control" value="<?php echo $p["lsdeep"];?>">
	<span class="input-group-addon"><a class="lsHelp" href="../plugins/slider/admin/doc/index.html#deep-linking-slides"><i class="fa fa-question-circle"></i></a></span>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tlls["ls"]["d3"];?></td>
	<td><select name="jak_transition_l[]" class="form-control">
	<option value=""<?php if ($p['easingin'] == '') { ?> selected="selected"<?php } ?>><?php echo $tl['cform']['c18'];?></option>
	<option value="swing"<?php if ($p['easingin'] =='swing') { ?> selected="selected"<?php } ?>>Swing</option>
	<option value="easeInQuad"<?php if ($p['easingin'] =='easeInQuad') { ?> selected="selected"<?php } ?>>easeInQuad</option>
	<option value="easeOutQuad"<?php if ($p['easingin'] =='easeOutQuad') { ?> selected="selected"<?php } ?>>easeOutQuad</option>
	<option value="easeInOutQuad"<?php if ($p['easingin'] =='easeInOutQuad') { ?> selected="selected"<?php } ?>>easeInOutQuad</option>
	<option value="easeInCubic"<?php if ($p['easingin'] =='easeInCubic') { ?> selected="selected"<?php } ?>>easeInCubic</option>
	<option value="easeOutCubic"<?php if ($p['easingin'] =='easeOutCubic') { ?> selected="selected"<?php } ?>>easeOutCubic</option>
	<option value="easeInOutCubic"<?php if ($p['easingin'] =='easeInOutCubic') { ?> selected="selected"<?php } ?>>easeInOutCubic</option>
	<option value="easeInQuart"<?php if ($p['easingin'] =='easeInQuart') { ?> selected="selected"<?php } ?>>easeInQuart</option>
	<option value="easeOutQuart"<?php if ($p['easingin'] =='easeOutQuart') { ?> selected="selected"<?php } ?>>easeOutQuart</option>
	<option value="easeInOutQuart"<?php if ($p['easingin'] =='easeInOutQuart') { ?> selected="selected"<?php } ?>>easeInOutQuart</option>
	<option value="easeInQuint"<?php if ($p['easingin'] =='easeInQuint') { ?> selected="selected"<?php } ?>>easeInQuint</option>
	<option value="easeInOutQuint"<?php if ($p['easingin'] =='easeInOutQuint') { ?> selected="selected"<?php } ?>>easeInOutQuint</option>
	<option value="easeInSine"<?php if ($p['easingin'] =='easeInSine') { ?> selected="selected"<?php } ?>>easeInSine</option>
	<option value="easeOutSine"<?php if ($p['easingin'] =='easeOutSine') { ?> selected="selected"<?php } ?>>easeOutSine</option>
	<option value="easeInOutSine"<?php if ($p['easingin'] =='easeInOutSine') { ?> selected="selected"<?php } ?>>easeInOutSine</option>
	<option value="easeInExpo"<?php if ($p['easingin'] =='easeInExpo') { ?> selected="selected"<?php } ?>>easeInExpo</option>
	<option value="easeOutExpo"<?php if ($p['easingin'] =='easeOutExpo') { ?> selected="selected"<?php } ?>>easeOutExpo</option>
	<option value="easeInOutExpo"<?php if ($p['easingin'] =='easeInOutExpo') { ?> selected="selected"<?php } ?>>easeInOutExpo</option>
	<option value="easeInCirc"<?php if ($p['easingin'] =='easeInCirc') { ?> selected="selected"<?php } ?>>easeInCirc</option>
	<option value="easeOutCirc"<?php if ($p['easingin'] =='easeOutCirc') { ?> selected="selected"<?php } ?>>easeOutCirc</option>
	<option value="easeInOutCirc"<?php if ($p['easingin'] =='easeInOutCirc') { ?> selected="selected"<?php } ?>>easeInOutCirc</option>
	<option value="easeInElastic"<?php if ($p['easingin'] =='easeInElastic') { ?> selected="selected"<?php } ?>>easeInElastic</option>
	<option value="easeInOutElastic"<?php if ($p['easingin'] =='easeInOutElastic') { ?> selected="selected"<?php } ?>>easeInOutElastic</option>
	<option value="easeInBack"<?php if ($p['easingin'] =='easeInBack') { ?> selected="selected"<?php } ?>>easeInBack</option>
	<option value="easeOutBack"<?php if ($p['easingin'] =='easeOutBack') { ?> selected="selected"<?php } ?>>easeOutBack</option>
	<option value="easeInOutBack"<?php if ($p['easingin'] =='easeInOutBack') { ?> selected="selected"<?php } ?>>easeInOutBack</option>
	<option value="easeInBounce"<?php if ($p['easingin'] =='easeInBounce') { ?> selected="selected"<?php } ?>>easeInBounce</option>
	<option value="easeOutBounce"<?php if ($p['easingin'] =='easeOutBounce') { ?> selected="selected"<?php } ?>>easeOutBounce</option>
	<option value="easeInOutBounce"<?php if ($p['easingin'] =='easeInOutBounce') { ?> selected="selected"<?php } ?>>easeInOutBounce</option>
	</select></td>
</tr>
<tr>
	<td><?php echo $tlls["ls"]["d2"];?></td>
	<td><select name="jak_transition_out_l[]" class="form-control">
	<option value=""<?php if ($p['easingout'] == '') { ?> selected="selected"<?php } ?>><?php echo $tl['cform']['c18'];?></option>
	<option value="swing"<?php if ($p['easingout'] == 'swing') { ?> selected="selected"<?php } ?>>Swing</option>
	<option value="easeInQuad"<?php if ($p['easingout'] == 'easeInQuad') { ?> selected="selected"<?php } ?>>easeInQuad</option>
	<option value="easeOutQuad"<?php if ($p['easingout'] == 'easeOutQuad') { ?> selected="selected"<?php } ?>>easeOutQuad</option>
	<option value="easeInOutQuad"<?php if ($p['easingout'] == 'easeInOutQuad') { ?> selected="selected"<?php } ?>>easeInOutQuad</option>
	<option value="easeInCubic"<?php if ($p['easingout'] == 'easeInCubic') { ?> selected="selected"<?php } ?>>easeInCubic</option>
	<option value="easeOutCubic"<?php if ($p['easingout'] == 'easeOutCubic') { ?> selected="selected"<?php } ?>>easeOutCubic</option>
	<option value="easeInOutCubic"<?php if ($p['easingout'] == 'easeInOutCubic') { ?> selected="selected"<?php } ?>>easeInOutCubic</option>
	<option value="easeInQuart"<?php if ($p['easingout'] == 'easeInQuart') { ?> selected="selected"<?php } ?>>easeInQuart</option>
	<option value="easeOutQuart"<?php if ($p['easingout'] == 'easeOutQuart') { ?> selected="selected"<?php } ?>>easeOutQuart</option>
	<option value="easeInOutQuart"<?php if ($p['easingout'] == 'easeInOutQuart') { ?> selected="selected"<?php } ?>>easeInOutQuart</option>
	<option value="easeInQuint"<?php if ($p['easingout'] == 'easeInQuint') { ?> selected="selected"<?php } ?>>easeInQuint</option>
	<option value="easeInOutQuint"<?php if ($p['easingout'] == 'easeInOutQuint') { ?> selected="selected"<?php } ?>>easeInOutQuint</option>
	<option value="easeInSine"<?php if ($p['easingout'] == 'easeInSine') { ?> selected="selected"<?php } ?>>easeInSine</option>
	<option value="easeOutSine"<?php if ($p['easingout'] == 'easeOutSine') { ?> selected="selected"<?php } ?>>easeOutSine</option>
	<option value="easeInOutSine"<?php if ($p['easingout'] == 'easeInOutSine') { ?> selected="selected"<?php } ?>>easeInOutSine</option>
	<option value="easeInExpo"<?php if ($p['easingout'] == 'easeInExpo') { ?> selected="selected"<?php } ?>>easeInExpo</option>
	<option value="easeOutExpo"<?php if ($p['easingout'] == 'easeOutExpo') { ?> selected="selected"<?php } ?>>easeOutExpo</option>
	<option value="easeInOutExpo"<?php if ($p['easingout'] == 'easeInOutExpo') { ?> selected="selected"<?php } ?>>easeInOutExpo</option>
	<option value="easeInCirc"<?php if ($p['easingout'] == 'easeInCirc') { ?> selected="selected"<?php } ?>>easeInCirc</option>
	<option value="easeOutCirc"<?php if ($p['easingout'] == 'easeOutCirc') { ?> selected="selected"<?php } ?>>easeOutCirc</option>
	<option value="easeInOutCirc"<?php if ($p['easingout'] == 'easeInOutCirc') { ?> selected="selected"<?php } ?>>easeInOutCirc</option>
	<option value="easeInElastic"<?php if ($p['easingout'] == 'easeInElastic') { ?> selected="selected"<?php } ?>>easeInElastic</option>
	<option value="easeInOutElastic"<?php if ($p['easingout'] == 'easeInOutElastic') { ?> selected="selected"<?php } ?>>easeInOutElastic</option>
	<option value="easeInBack"<?php if ($p['easingout'] == 'easeInBack') { ?> selected="selected"<?php } ?>>easeInBack</option>
	<option value="easeOutBack"<?php if ($p['easingout'] == 'easeOutBack') { ?> selected="selected"<?php } ?>>easeOutBack</option>
	<option value="easeInOutBack"<?php if ($p['easingout'] == 'easeInOutBack') { ?> selected="selected"<?php } ?>>easeInOutBack</option>
	<option value="easeInBounce"<?php if ($p['easingout'] == 'easeInBounce') { ?> selected="selected"<?php } ?>>easeInBounce</option>
	<option value="easeOutBounce"<?php if ($p['easingout'] == 'easeOutBounce') { ?> selected="selected"<?php } ?>>easeOutBounce</option>
	<option value="easeInOutBounce"<?php if ($p['easingout'] == 'easeInOutBounce') { ?> selected="selected"<?php } ?>>easeInOutBounce</option>
	</select></td>
</tr>
<tr>
	<td><?php echo $tlls["ls"]["d16"];?></td>
	<td><select name="jak_direction_l[]" class="form-control">
	<option value=""<?php if ($p['slidedirection'] == '') { ?> selected="selected"<?php } ?>><?php echo $tl['cform']['c18'];?></option>
	<option value="top"<?php if ($p['slidedirection'] == "top") { ?> selected="selected"<?php } ?>><?php echo $tlls["ls"]["d17"];?></option>
	<option value="left"<?php if ($p['slidedirection'] == "left") { ?> selected="selected"<?php } ?>><?php echo $tlls["ls"]["d18"];?></option>
	<option value="bottom"<?php if ($p['slidedirection'] == "bottom") { ?> selected="selected"<?php } ?>><?php echo $tlls["ls"]["d19"];?></option>
	<option value="right"<?php if ($p['slidedirection'] == "right") { ?> selected="selected"<?php } ?>><?php echo $tlls["ls"]["d20"];?></option>
	</select></td>
</tr>

<tr>
	<td><?php echo $tlls["ls"]["d5"];?></td>
	<td><select name="jak_pause_l[]" class="form-control">
	<option value=""<?php if ($p['slidedelay'] == '') { ?> selected="selected"<?php } ?>><?php echo $tl['cform']['c18'];?></option>
	<?php for($ous=200; $ous<=20000; $ous += 200) { ?>
	<option value="<?php echo $ous;?>"<?php if ($p['slidedelay'] == $ous) { ?> selected="selected"<?php } ?>><?php echo $ous;?></option>
	<?php } ?>
	</select></td>
</tr>

<tr>
	<td><?php echo $tlls["ls"]["d27"];?></td>
	<td><select name="jak_durationin_l[]" class="form-control">
	<option value=""<?php if ($p['durationin'] == '') { ?> selected="selected"<?php } ?>><?php echo $tl['cform']['c18'];?></option>
	<option value="50"<?php if ($p['durationin'] == 50) { ?> selected="selected"<?php } ?>>50</option>
	<option value="100"<?php if ($p['durationin'] == 100) { ?> selected="selected"<?php } ?>>100</option>
	<option value="500"<?php if ($p['durationin'] == 500) { ?> selected="selected"<?php } ?>>500</option>
	<option value="1000"<?php if ($p['durationin'] == 1000) { ?> selected="selected"<?php } ?>>1000</option>
	<option value="2000"<?php if ($p['durationin'] == 2000) { ?> selected="selected"<?php } ?>>2000</option>
	<option value="3000"<?php if ($p['durationin'] == 3000) { ?> selected="selected"<?php } ?>>3000</option>
	<option value="4000"<?php if ($p['durationin'] == 4000) { ?> selected="selected"<?php } ?>>4000</option>
	<option value="5000"<?php if ($p['durationin'] == 5000) { ?> selected="selected"<?php } ?>>5000</option>
	<option value="6000"<?php if ($p['durationin'] == 6000) { ?> selected="selected"<?php } ?>>6000</option>
	<option value="7000"<?php if ($p['durationin'] == 7000) { ?> selected="selected"<?php } ?>>7000</option>
	<option value="8000"<?php if ($p['durationin'] == 8000) { ?> selected="selected"<?php } ?>>8000</option>
	<option value="9000"<?php if ($p['durationin'] == 9000) { ?> selected="selected"<?php } ?>>9000</option>
	</select></td>
</tr>

<tr>
	<td><?php echo $tlls["ls"]["d28"];?></td>
	<td><select name="jak_duration_l[]" class="form-control">
	<option value=""<?php if ($p['durationout'] == '') { ?> selected="selected"<?php } ?>><?php echo $tl['cform']['c18'];?></option>
	<option value="50"<?php if ($p['durationout'] == 50) { ?> selected="selected"<?php } ?>>50</option>
	<option value="100"<?php if ($p['durationout'] == 100) { ?> selected="selected"<?php } ?>>100</option>
	<option value="500"<?php if ($p['durationout'] == 500) { ?> selected="selected"<?php } ?>>500</option>
	<option value="1000"<?php if ($p['durationout'] == 1000) { ?> selected="selected"<?php } ?>>1000</option>
	<option value="2000"<?php if ($p['durationout'] == 2000) { ?> selected="selected"<?php } ?>>2000</option>
	<option value="3000"<?php if ($p['durationout'] == 3000) { ?> selected="selected"<?php } ?>>3000</option>
	<option value="4000"<?php if ($p['durationout'] == 4000) { ?> selected="selected"<?php } ?>>4000</option>
	<option value="5000"<?php if ($p['durationout'] == 5000) { ?> selected="selected"<?php } ?>>5000</option>
	<option value="6000"<?php if ($p['durationout'] == 6000) { ?> selected="selected"<?php } ?>>6000</option>
	<option value="7000"<?php if ($p['durationout'] == 7000) { ?> selected="selected"<?php } ?>>7000</option>
	<option value="8000"<?php if ($p['durationout'] == 8000) { ?> selected="selected"<?php } ?>>8000</option>
	<option value="9000"<?php if ($p['durationout'] == 9000) { ?> selected="selected"<?php } ?>>9000</option>
	</select></td>
</tr>

<tr>
	<td><?php echo $tlls["ls"]["d29"];?></td>
	<td><select name="jak_delay_l[]" class="form-control">
	<option value=""<?php if ($p['delayin'] == '') { ?> selected="selected"<?php } ?>><?php echo $tl['cform']['c18'];?></option>
	<option value="50"<?php if ($p['delayin'] == 50) { ?> selected="selected"<?php } ?>>50</option>
	<option value="100"<?php if ($p['delayin'] == 100) { ?> selected="selected"<?php } ?>>100</option>
	<option value="500"<?php if ($p['delayin'] == 500) { ?> selected="selected"<?php } ?>>500</option>
	<option value="1000"<?php if ($p['delayin'] == 1000) { ?> selected="selected"<?php } ?>>1000</option>
	<option value="2000"<?php if ($p['delayin'] == 2000) { ?> selected="selected"<?php } ?>>2000</option>
	<option value="3000"<?php if ($p['delayin'] == 3000) { ?> selected="selected"<?php } ?>>3000</option>
	<option value="4000"<?php if ($p['delayin'] == 4000) { ?> selected="selected"<?php } ?>>4000</option>
	<option value="5000"<?php if ($p['delayin'] == 5000) { ?> selected="selected"<?php } ?>>5000</option>
	<option value="6000"<?php if ($p['delayin'] == 6000) { ?> selected="selected"<?php } ?>>6000</option>
	<option value="7000"<?php if ($p['delayin'] == 7000) { ?> selected="selected"<?php } ?>>7000</option>
	<option value="8000"<?php if ($p['delayin'] == 8000) { ?> selected="selected"<?php } ?>>8000</option>
	<option value="9000"<?php if ($p['delayin'] == 9000) { ?> selected="selected"<?php } ?>>9000</option>
	</select></td>
</tr>

<tr>
	<td><?php echo $tlls["ls"]["d30"];?></td>
	<td><select name="jak_delayout_l[]" class="form-control">
	<option value=""<?php if ($p['delayout'] == '') { ?> selected="selected"<?php } ?>><?php echo $tl['cform']['c18'];?></option>
	<option value="50"<?php if ($p['delayout'] == 50) { ?> selected="selected"<?php } ?>>50</option>
	<option value="100"<?php if ($p['delayout'] == 100) { ?> selected="selected"<?php } ?>>100</option>
	<option value="500"<?php if ($p['delayout'] == 500) { ?> selected="selected"<?php } ?>>500</option>
	<option value="1000"<?php if ($p['delayout'] == 1000) { ?> selected="selected"<?php } ?>>1000</option>
	<option value="2000"<?php if ($p['delayout'] == 2000) { ?> selected="selected"<?php } ?>>2000</option>
	<option value="3000"<?php if ($p['delayout'] == 3000) { ?> selected="selected"<?php } ?>>3000</option>
	<option value="4000"<?php if ($p['delayout'] == 4000) { ?> selected="selected"<?php } ?>>4000</option>
	<option value="5000"<?php if ($p['delayout'] == 5000) { ?> selected="selected"<?php } ?>>5000</option>
	<option value="6000"<?php if ($p['delayout'] == 6000) { ?> selected="selected"<?php } ?>>6000</option>
	<option value="7000"<?php if ($p['delayout'] == 7000) { ?> selected="selected"<?php } ?>>7000</option>
	<option value="8000"<?php if ($p['delayout'] == 8000) { ?> selected="selected"<?php } ?>>8000</option>
	<option value="9000"<?php if ($p['delayout'] == 9000) { ?> selected="selected"<?php } ?>>9000</option>
	</select></td>
</tr>
</table>
	</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>

<?php if (isset($JAK_SLIDER_PICS) && is_array($JAK_SLIDER_PICS)) foreach($JAK_SLIDER_PICS as $ps) { if ($ps['layer'] != 0 && $p['id'] == $ps['layer']) { ?>

<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tlls["ls"]["d26"].' - '.$count;?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">

<table class="table table-striped">
<thead>
<tr>
	<th colspan="7"><?php echo $tlls["ls"]["d35"];?></th>
	<th><input type="checkbox" name="jak_sodsl[]" value="<?php echo $ps["id"];?>" /><input type="hidden" name="jak_sublayerid[]" value="<?php echo $ps["id"];?>" /></th>
</tr>
</thead>
<tr>
	<td colspan="8"><?php echo $tlls["ls"]["d12"];?><br /><div class="input-group"><input type="text" class="form-control" name="jak_path[]" id="jak_path<?php echo $ps['id'];?>" value="<?php echo $ps['lspath'];?>">
	<span class="input-group-addon"><a href="../js/editor/plugins/filemanager/dialog.php?type=1&editor=mce_0&lang=eng&fldr=&field_id=jak_path<?php echo $ps['id'];?>" class="ifManager"><i class="fa fa-picture-o"></i></a></span>
	<span class="input-group-addon"><a href="../js/editor/plugins/filemanager/dialog.php?type=2&editor=mce_0&lang=eng&fldr=&field_id=jak_path<?php echo $ps['id'];?>" class="ifManager"><i class="fa fa-file"></i></a></span></div>
	</td>
</tr>
<tr>
	<td colspan="2"><?php echo $tlls["ls"]["d16"];?><br /><select name="jak_directionu[]" class="form-control">
	<option value=""><?php echo $tl['cform']['c18'];?></option>
	<option value="top"<?php if ($ps['imgdirection'] == 'top') { ?> selected="selected"<?php } ?>><?php echo $tlls["ls"]["d17"];?></option>
	<option value="left"<?php if ($ps['imgdirection'] == 'left') { ?> selected="selected"<?php } ?>><?php echo $tlls["ls"]["d18"];?></option>
	<option value="bottom"<?php if ($ps['imgdirection'] == 'bottom') { ?> selected="selected"<?php } ?>><?php echo $tlls["ls"]["d19"];?></option>
	<option value="right"<?php if ($ps['imgdirection'] == 'right') { ?> selected="selected"<?php } ?>><?php echo $tlls["ls"]["d20"];?></option>
	</select></td>
	<td colspan="3"><?php echo $tlls["ls"]["d13"];?><br /><input type="text" name="jak_link[]" value="<?php echo $ps['lslink'];?>"  class="form-control" /></td>
	<td><?php echo $tlls["ls"]["d14"];?><br /><input type="text" name="jak_style[]" value="<?php echo $ps['lsstyle'];?>" class="form-control" /></td>
	<td><?php echo $tlls["ls"]["d31"];?><br /><input type="text" name="jak_parallax[]" value="<?php echo $ps['parallaxin'];?>" class="form-control" /></td>
	<td><?php echo $tlls["ls"]["d32"];?><br /><input type="text" name="jak_parallaxout[]" value="<?php echo $ps['parallaxout'];?>" class="form-control" /></td>
</tr>
<tr>
	<td colspan="4">
	<?php echo $tlls["ls"]["d48"];?><br>
	<div class="input-group">
	<input type="text" name="jak_pos[]" class="form-control" value="<?php echo $ps['lsposition'];?>">
	<span class="input-group-addon"><a class="lsHelp" href="../plugins/slider/admin/doc/index.html#positioning-layers"><i class="fa fa-question-circle"></i></a></span>
	</div>
	</td>
	<td colspan="4">
	<?php echo $tlls["ls"]["d46"];?><br>
	<div class="input-group">
	<input type="text" name="jak_move[]" class="form-control" value="<?php echo $ps['lsmove'];?>">
	<span class="input-group-addon"><a class="lsHelp" href="../plugins/slider/admin/doc/index.html#layer-transitions"><i class="fa fa-question-circle"></i></a></span>
	</div>
	</td>
</tr>
<tr>
	
		<td><?php echo $tlls["ls"]["d3"];?><br /><select name="jak_transition_ls[]" class="form-control">
		<option value=""<?php if ($ps['easingin'] == '') { ?> selected="selected"<?php } ?>><?php echo $tl['cform']['c18'];?></option>
		<option value="swing"<?php if ($ps['easingin'] == 'swing') { ?> selected="selected"<?php } ?>>Swing</option>
		<option value="easeInQuad"<?php if ($ps['easingin'] == 'easeInQuad') { ?> selected="selected"<?php } ?>>easeInQuad</option>
		<option value="easeOutQuad"<?php if ($ps['easingin'] == 'easeOutQuad') { ?> selected="selected"<?php } ?>>easeOutQuad</option>
		<option value="easeInOutQuad"<?php if ($ps['easingin'] == 'easeInOutQuad') { ?> selected="selected"<?php } ?>>easeInOutQuad</option>
		<option value="easeInCubic"<?php if ($ps['easingin'] == 'easeInCubic') { ?> selected="selected"<?php } ?>>easeInCubic</option>
		<option value="easeOutCubic"<?php if ($ps['easingin'] == 'easeOutCubic') { ?> selected="selected"<?php } ?>>easeOutCubic</option>
		<option value="easeInOutCubic"<?php if ($ps['easingin'] == 'easeInOutCubic') { ?> selected="selected"<?php } ?>>easeInOutCubic</option>
		<option value="easeInQuart"<?php if ($ps['easingin'] == 'easeInQuart') { ?> selected="selected"<?php } ?>>easeInQuart</option>
		<option value="easeOutQuart"<?php if ($ps['easingin'] == 'easeOutQuart') { ?> selected="selected"<?php } ?>>easeOutQuart</option>
		<option value="easeInOutQuart"<?php if ($ps['easingin'] == 'easeInOutQuart') { ?> selected="selected"<?php } ?>>easeInOutQuart</option>
		<option value="easeInQuint"<?php if ($ps['easingin'] == 'easeInQuint') { ?> selected="selected"<?php } ?>>easeInQuint</option>
		<option value="easeInOutQuint"<?php if ($ps['easingin'] == 'easeInOutQuint') { ?> selected="selected"<?php } ?>>easeInOutQuint</option>
		<option value="easeInSine"<?php if ($ps['easingin'] == 'easeInSine') { ?> selected="selected"<?php } ?>>easeInSine</option>
		<option value="easeOutSine"<?php if ($ps['easingin'] == 'easeOutSine') { ?> selected="selected"<?php } ?>>easeOutSine</option>
		<option value="easeInOutSine"<?php if ($ps['easingin'] == 'easeInOutSine') { ?> selected="selected"<?php } ?>>easeInOutSine</option>
		<option value="easeInExpo"<?php if ($ps['easingin'] == 'easeInExpo') { ?> selected="selected"<?php } ?>>easeInExpo</option>
		<option value="easeOutExpo"<?php if ($ps['easingin'] == 'easeOutExpo') { ?> selected="selected"<?php } ?>>easeOutExpo</option>
		<option value="easeInOutExpo"<?php if ($ps['easingin'] == 'easeInOutExpo') { ?> selected="selected"<?php } ?>>easeInOutExpo</option>
		<option value="easeInCirc"<?php if ($ps['easingin'] == 'easeInCirc') { ?> selected="selected"<?php } ?>>easeInCirc</option>
		<option value="easeOutCirc"<?php if ($ps['easingin'] == 'easeOutCirc') { ?> selected="selected"<?php } ?>>easeOutCirc</option>
		<option value="easeInOutCirc"<?php if ($ps['easingin'] == 'easeInOutCirc') { ?> selected="selected"<?php } ?>>easeInOutCirc</option>
		<option value="easeInElastic"<?php if ($ps['easingin'] == 'easeInElastic') { ?> selected="selected"<?php } ?>>easeInElastic</option>
		<option value="easeInOutElastic"<?php if ($ps['easingin'] == 'easeInOutElastic') { ?> selected="selected"<?php } ?>>easeInOutElastic</option>
		<option value="easeInBack"<?php if ($ps['easingin'] == 'easeInBack') { ?> selected="selected"<?php } ?>>easeInBack</option>
		<option value="easeOutBack"<?php if ($ps['easingin'] == 'easeOutBack') { ?> selected="selected"<?php } ?>>easeOutBack</option>
		<option value="easeInOutBack"<?php if ($ps['easingin'] == 'easeInOutBack') { ?> selected="selected"<?php } ?>>easeInOutBack</option>
		<option value="easeInBounce"<?php if ($ps['easingin'] == 'easeInBounce') { ?> selected="selected"<?php } ?>>easeInBounce</option>
		<option value="easeOutBounce"<?php if ($ps['easingin'] == 'easeOutBounce') { ?> selected="selected"<?php } ?>>easeOutBounce</option>
		<option value="easeInOutBounce"<?php if ($ps['easingin'] == 'easeInOutBounce') { ?> selected="selected"<?php } ?>>easeInOutBounce</option>
		</select></td>
	
		<td><?php echo $tlls["ls"]["d2"];?><br /><select name="jak_transition_out_ls[]" class="form-control">
		<option value=""<?php if ($ps['easingout'] == '') { ?> selected="selected"<?php } ?>><?php echo $tl['cform']['c18'];?></option>
		<option value="swing"<?php if ($ps['easingout'] == 'swing') { ?> selected="selected"<?php } ?>>Swing</option>
		<option value="easeInQuad"<?php if ($ps['easingout'] == 'easeInQuad') { ?> selected="selected"<?php } ?>>easeInQuad</option>
		<option value="easeOutQuad"<?php if ($ps['easingout'] == 'easeOutQuad') { ?> selected="selected"<?php } ?>>easeOutQuad</option>
		<option value="easeInOutQuad"<?php if ($ps['easingout'] == 'easeInOutQuad') { ?> selected="selected"<?php } ?>>easeInOutQuad</option>
		<option value="easeInCubic"<?php if ($ps['easingout'] == 'easeInCubic') { ?> selected="selected"<?php } ?>>easeInCubic</option>
		<option value="easeOutCubic"<?php if ($ps['easingout'] == 'easeOutCubic') { ?> selected="selected"<?php } ?>>easeOutCubic</option>
		<option value="easeInOutCubic"<?php if ($ps['easingout'] == 'easeInOutCubic') { ?> selected="selected"<?php } ?>>easeInOutCubic</option>
		<option value="easeInQuart"<?php if ($ps['easingout'] == 'easeInQuart') { ?> selected="selected"<?php } ?>>easeInQuart</option>
		<option value="easeOutQuart"<?php if ($ps['easingout'] == 'easeOutQuart') { ?> selected="selected"<?php } ?>>easeOutQuart</option>
		<option value="easeInOutQuart"<?php if ($ps['easingout'] == 'easeInOutQuart') { ?> selected="selected"<?php } ?>>easeInOutQuart</option>
		<option value="easeInQuint"<?php if ($ps['easingout'] == 'easeInQuint') { ?> selected="selected"<?php } ?>>easeInQuint</option>
		<option value="easeInOutQuint"<?php if ($ps['easingout'] == 'easeInOutQuint') { ?> selected="selected"<?php } ?>>easeInOutQuint</option>
		<option value="easeInSine"<?php if ($ps['easingout'] == 'easeInSine') { ?> selected="selected"<?php } ?>>easeInSine</option>
		<option value="easeOutSine"<?php if ($ps['easingout'] == 'easeOutSine') { ?> selected="selected"<?php } ?>>easeOutSine</option>
		<option value="easeInOutSine"<?php if ($ps['easingout'] == 'easeInOutSine') { ?> selected="selected"<?php } ?>>easeInOutSine</option>
		<option value="easeInExpo"<?php if ($ps['easingout'] == 'easeInExpo') { ?> selected="selected"<?php } ?>>easeInExpo</option>
		<option value="easeOutExpo"<?php if ($ps['easingout'] == 'easeOutExpo') { ?> selected="selected"<?php } ?>>easeOutExpo</option>
		<option value="easeInOutExpo"<?php if ($ps['easingout'] == 'easeInOutExpo') { ?> selected="selected"<?php } ?>>easeInOutExpo</option>
		<option value="easeInCirc"<?php if ($ps['easingout'] == 'easeInCirc') { ?> selected="selected"<?php } ?>>easeInCirc</option>
		<option value="easeOutCirc"<?php if ($ps['easingout'] == 'easeOutCirc') { ?> selected="selected"<?php } ?>>easeOutCirc</option>
		<option value="easeInOutCirc"<?php if ($ps['easingout'] == 'easeInOutCirc') { ?> selected="selected"<?php } ?>>easeInOutCirc</option>
		<option value="easeInElastic"<?php if ($ps['easingout'] == 'easeInElastic') { ?> selected="selected"<?php } ?>>easeInElastic</option>
		<option value="easeInOutElastic"<?php if ($ps['easingout'] == 'easeInOutElastic') { ?> selected="selected"<?php } ?>>easeInOutElastic</option>
		<option value="easeInBack"<?php if ($ps['easingout'] == 'easeInBack') { ?> selected="selected"<?php } ?>>easeInBack</option>
		<option value="easeOutBack"<?php if ($ps['easingout'] == 'easeOutBack') { ?> selected="selected"<?php } ?>>easeOutBack</option>
		<option value="easeInOutBack"<?php if ($ps['easingout'] == 'easeInOutBack') { ?> selected="selected"<?php } ?>>easeInOutBack</option>
		<option value="easeInBounce"<?php if ($ps['easingout'] == 'easeInBounce') { ?> selected="selected"<?php } ?>>easeInBounce</option>
		<option value="easeOutBounce"<?php if ($ps['easingout'] == 'easeOutBounce') { ?> selected="selected"<?php } ?>>easeOutBounce</option>
		<option value="easeInOutBounce"<?php if ($ps['easingout'] == 'easeInOutBounce') { ?> selected="selected"<?php } ?>>easeInOutBounce</option>
		</select></td>

	<td colspan="2"><?php echo $tlls["ls"]["d27"];?><br /><select name="jak_duration_ls[]" class="form-control">
	<option value=""<?php if ($ps['durationin'] == '') { ?> selected="selected"<?php } ?>><?php echo $tl['cform']['c18'];?></option>
	
	<?php for ($y=100; $y<=2000; $y += 100) { ?>
		<option value="<?php echo $y;?>"<?php if ($ps['durationin'] == $y) { ?> selected="selected"<?php } ?>><?php echo $y;?></option>
	<?php } ?>
	
	<option value="3000"<?php if ($ps['durationin'] == 3000) { ?> selected="selected"<?php } ?>>3000</option>
	<option value="4000"<?php if ($ps['durationin'] == 4000) { ?> selected="selected"<?php } ?>>4000</option>
	<option value="5000"<?php if ($ps['durationin'] == 5000) { ?> selected="selected"<?php } ?>>5000</option>
	<option value="6000"<?php if ($ps['durationin'] == 6000) { ?> selected="selected"<?php } ?>>6000</option>
	<option value="7000"<?php if ($ps['durationin'] == 7000) { ?> selected="selected"<?php } ?>>7000</option>
	<option value="8000"<?php if ($ps['durationin'] == 8000) { ?> selected="selected"<?php } ?>>8000</option>
	<option value="9000"<?php if ($ps['durationin'] == 9000) { ?> selected="selected"<?php } ?>>9000</option>
	</select></td>

	<td colspan="2"><?php echo $tlls["ls"]["d28"];?><br /><select name="jak_durationout_ls[]" class="form-control">
	<option value=""<?php if ($ps['durationout'] == '') { ?> selected="selected"<?php } ?>><?php echo $tl['cform']['c18'];?></option>
	<option value="50"<?php if ($ps['durationout'] == 50) { ?> selected="selected"<?php } ?>>50</option>
	<option value="100"<?php if ($ps['durationout'] == 100) { ?> selected="selected"<?php } ?>>100</option>
	<option value="500"<?php if ($ps['durationout'] == 500) { ?> selected="selected"<?php } ?>>500</option>
	<option value="1000"<?php if ($ps['durationout'] == 1000) { ?> selected="selected"<?php } ?>>1000</option>
	<option value="2000"<?php if ($ps['durationout'] == 2000) { ?> selected="selected"<?php } ?>>2000</option>
	<option value="3000"<?php if ($ps['durationout'] == 3000) { ?> selected="selected"<?php } ?>>3000</option>
	<option value="4000"<?php if ($ps['durationout'] == 4000) { ?> selected="selected"<?php } ?>>4000</option>
	<option value="5000"<?php if ($ps['durationout'] == 5000) { ?> selected="selected"<?php } ?>>5000</option>
	<option value="6000"<?php if ($ps['durationout'] == 6000) { ?> selected="selected"<?php } ?>>6000</option>
	<option value="7000"<?php if ($ps['durationout'] == 7000) { ?> selected="selected"<?php } ?>>7000</option>
	<option value="8000"<?php if ($ps['durationout'] == 8000) { ?> selected="selected"<?php } ?>>8000</option>
	<option value="9000"<?php if ($ps['durationout'] == 9000) { ?> selected="selected"<?php } ?>>9000</option>
	</select></td>

	<td><?php echo $tlls["ls"]["d29"];?><br /><select name="jak_delay_ls[]" class="form-control">
	<option value=""<?php if ($ps['delayin'] == '') { ?> selected="selected"<?php } ?>><?php echo $tl['cform']['c18'];?></option>
	
	<?php for ($y=100; $y<=2000; $y += 100) { ?>
		<option value="<?php echo $y;?>"<?php if ($ps['delayin'] == $y) { ?> selected="selected"<?php } ?>><?php echo $y;?></option>
	<?php } ?>
	
	<option value="3000"<?php if ($ps['delayin'] == 3000) { ?> selected="selected"<?php } ?>>3000</option>
	<option value="4000"<?php if ($ps['delayin'] == 4000) { ?> selected="selected"<?php } ?>>4000</option>
	<option value="5000"<?php if ($ps['delayin'] == 5000) { ?> selected="selected"<?php } ?>>5000</option>
	<option value="6000"<?php if ($ps['delayin'] == 6000) { ?> selected="selected"<?php } ?>>6000</option>
	<option value="7000"<?php if ($ps['delayin'] == 7000) { ?> selected="selected"<?php } ?>>7000</option>
	<option value="8000"<?php if ($ps['delayin'] == 8000) { ?> selected="selected"<?php } ?>>8000</option>
	<option value="9000"<?php if ($ps['delayin'] == 9000) { ?> selected="selected"<?php } ?>>9000</option>
	</select></td>

	<td><?php echo $tlls["ls"]["d30"];?><br /><select name="jak_delayout_ls[]" class="form-control">
	<option value=""<?php if ($ps['delayout'] == '') { ?> selected="selected"<?php } ?>><?php echo $tl['cform']['c18'];?></option>
	
	<?php for ($y=100; $y<=2000; $y += 100) { ?>
		<option value="<?php echo $y;?>"<?php if ($ps['delayout'] == $y) { ?> selected="selected"<?php } ?>><?php echo $y;?></option>
	<?php } ?>
	
	<option value="3000"<?php if ($ps['delayout'] == 3000) { ?> selected="selected"<?php } ?>>3000</option>
	<option value="4000"<?php if ($ps['delayout'] == 4000) { ?> selected="selected"<?php } ?>>4000</option>
	<option value="5000"<?php if ($ps['delayout'] == 5000) { ?> selected="selected"<?php } ?>>5000</option>
	<option value="6000"<?php if ($ps['delayout'] == 6000) { ?> selected="selected"<?php } ?>>6000</option>
	<option value="7000"<?php if ($ps['delayout'] == 7000) { ?> selected="selected"<?php } ?>>7000</option>
	<option value="8000"<?php if ($ps['delayout'] == 8000) { ?> selected="selected"<?php } ?>>8000</option>
	<option value="9000"<?php if ($ps['delayout'] == 9000) { ?> selected="selected"<?php } ?>>9000</option>
	</select></td>

</tr>
</table>

</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>

<?php } } ?>

<?php for ($o = 1; $o < 6; $o++) { ?>

<input type="hidden" name="jak_newadd[]" value="<?php echo $p['id'];?>" />

<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Add</h3>
  </div><!-- /.box-header -->
  <div class="box-body">

<table class="table">
<tr>
	<td colspan="8"><?php echo $tlls["ls"]["d12"];?><br /><div class="input-group"><input type="text" class="form-control" name="jak_pathna[]" id="jak_pathna<?php echo $p['id'].$o;?>">
	<span class="input-group-addon"><a href="../js/editor/plugins/filemanager/dialog.php?type=1&editor=mce_0&lang=eng&fldr=&field_id=jak_pathna<?php echo $p['id'].$o;?>" class="ifManager"><i class="fa fa-picture-o"></i></a></span>
	<span class="input-group-addon"><a href="../js/editor/plugins/filemanager/dialog.php?type=2&editor=mce_0&lang=eng&fldr=&field_id=jak_pathna<?php echo $p['id'].$o;?>" class="ifManager"><i class="fa fa-file"></i></a></span></div>
	</td>
</tr>
<tr>
	<td colspan="2"><?php echo $tlls["ls"]["d16"];?><br /><select name="jak_directionna[]" class="form-control">
	<option value=""><?php echo $tl['cform']['c18'];?></option>
	<option value="top"><?php echo $tlls["ls"]["d17"];?></option>
	<option value="left"><?php echo $tlls["ls"]["d18"];?></option>
	<option value="bottom"><?php echo $tlls["ls"]["d19"];?></option>
	<option value="right"><?php echo $tlls["ls"]["d20"];?></option>
	</select></td>
	<td colspan="3"><?php echo $tlls["ls"]["d13"];?><br /><input type="text" name="jak_linkna[]" value=""  class="form-control" /></td>
	<td><?php echo $tlls["ls"]["d14"];?><br /><input type="text" name="jak_stylena[]" value="" class="form-control" /></td>
	<td><?php echo $tlls["ls"]["d31"];?><br /><input type="text" name="jak_parallaxna[]" value="" class="form-control" /></td>
	<td><?php echo $tlls["ls"]["d32"];?><br /><input type="text" name="jak_parallaxoutna[]" value="" class="form-control" /></td>
</tr>
<tr>
	<td colspan="4">
	<?php echo $tlls["ls"]["d48"];?><br>
	<div class="input-group">
	<input type="text" name="jak_posna[]" class="form-control">
	<span class="input-group-addon"><a class="lsHelp" href="../plugins/slider/admin/doc/index.html#positioning-layers"><i class="fa fa-question-circle"></i></a></span>
	</div>
	</td>
	<td colspan="4">
	<?php echo $tlls["ls"]["d46"];?><br>
	<div class="input-group">
	<input type="text" name="jak_movena[]" class="form-control">
	<span class="input-group-addon"><a class="lsHelp" href="../plugins/slider/admin/doc/index.html#layer-transitions"><i class="fa fa-question-circle"></i></a></span>
	</div>
	</td>
</tr>
<tr>
	
		<td><?php echo $tlls["ls"]["d3"];?><br /><select name="jak_transition_lsna[]" class="form-control">
		<option value=""><?php echo $tl['cform']['c18'];?></option>
		<option value="swing">Swing</option>
		<option value="easeInQuad">easeInQuad</option>
		<option value="easeOutQuad">easeOutQuad</option>
		<option value="easeInOutQuad">easeInOutQuad</option>
		<option value="easeInCubic">easeInCubic</option>
		<option value="easeOutCubic">easeOutCubic</option>
		<option value="easeInOutCubic">easeInOutCubic</option>
		<option value="easeInQuart">easeInQuart</option>
		<option value="easeOutQuart">easeOutQuart</option>
		<option value="easeInOutQuart">easeInOutQuart</option>
		<option value="easeInQuint">easeInQuint</option>
		<option value="easeInOutQuint">easeInOutQuint</option>
		<option value="easeInSine">easeInSine</option>
		<option value="easeOutSine">easeOutSine</option>
		<option value="easeInOutSine">easeInOutSine</option>
		<option value="easeInExpo">easeInExpo</option>
		<option value="easeOutExpo">easeOutExpo</option>
		<option value="easeInOutExpo">easeInOutExpo</option>
		<option value="easeInCirc">easeInCirc</option>
		<option value="easeOutCirc">easeOutCirc</option>
		<option value="easeInOutCirc">easeInOutCirc</option>
		<option value="easeInElastic">easeInElastic</option>
		<option value="easeInOutElastic">easeInOutElastic</option>
		<option value="easeInBack">easeInBack</option>
		<option value="easeOutBack">easeOutBack</option>
		<option value="easeInOutBack">easeInOutBack</option>
		<option value="easeInBounce">easeInBounce</option>
		<option value="easeOutBounce">easeOutBounce</option>
		<option value="easeInOutBounce">easeInOutBounce</option>
		</select></td>
	
		<td><?php echo $tlls["ls"]["d2"];?><br /><select name="jak_transition_out_lsna[]" class="form-control">
		<option value=""><?php echo $tl['cform']['c18'];?></option>
		<option value="swing">Swing</option>
		<option value="easeInQuad">easeInQuad</option>
		<option value="easeOutQuad">easeOutQuad</option>
		<option value="easeInOutQuad">easeInOutQuad</option>
		<option value="easeInCubic">easeInCubic</option>
		<option value="easeOutCubic">easeOutCubic</option>
		<option value="easeInOutCubic">easeInOutCubic</option>
		<option value="easeInQuart">easeInQuart</option>
		<option value="easeOutQuart">easeOutQuart</option>
		<option value="easeInOutQuart">easeInOutQuart</option>
		<option value="easeInQuint">easeInQuint</option>
		<option value="easeInOutQuint">easeInOutQuint</option>
		<option value="easeInSine">easeInSine</option>
		<option value="easeOutSine">easeOutSine</option>
		<option value="easeInOutSine">easeInOutSine</option>
		<option value="easeInExpo">easeInExpo</option>
		<option value="easeOutExpo">easeOutExpo</option>
		<option value="easeInOutExpo">easeInOutExpo</option>
		<option value="easeInCirc">easeInCirc</option>
		<option value="easeOutCirc">easeOutCirc</option>
		<option value="easeInOutCirc">easeInOutCirc</option>
		<option value="easeInElastic">easeInElastic</option>
		<option value="easeInOutElastic">easeInOutElastic</option>
		<option value="easeInBack">easeInBack</option>
		<option value="easeOutBack">easeOutBack</option>
		<option value="easeInOutBack">easeInOutBack</option>
		<option value="easeInBounce">easeInBounce</option>
		<option value="easeOutBounce">easeOutBounce</option>
		<option value="easeInOutBounce">easeInOutBounce</option>
		</select></td>

	<td colspan="2"><?php echo $tlls["ls"]["d27"];?><br /><select name="jak_duration_lsna[]" class="form-control">
	<option value=""><?php echo $tl['cform']['c18'];?></option>
	
	<?php for ($z=100; $z<=2000; $z += 100) { ?>
		<option value="<?php echo $z;?>"><?php echo $z;?></option>
	<?php } ?>
	
	<option value="3000">3000</option>
	<option value="4000">4000</option>
	<option value="5000">5000</option>
	<option value="6000">6000</option>
	<option value="7000">7000</option>
	<option value="8000">8000</option>
	<option value="9000">9000</option>
	</select></td>

	<td colspan="2"><?php echo $tlls["ls"]["d28"];?><br /><select name="jak_durationout_lsna[]" class="form-control">
	<option value=""><?php echo $tl['cform']['c18'];?></option>
	
	<?php for ($z=100; $z<=2000; $z += 100) { ?>
		<option value="<?php echo $z;?>"><?php echo $z;?></option>
	<?php } ?>
	
	<option value="3000">3000</option>
	<option value="4000">4000</option>
	<option value="5000">5000</option>
	<option value="6000">6000</option>
	<option value="7000">7000</option>
	<option value="8000">8000</option>
	<option value="9000">9000</option>
	</select></td>

	<td><?php echo $tlls["ls"]["d29"];?><br /><select name="jak_delay_lsna[]" class="form-control">
	<option value=""><?php echo $tl['cform']['c18'];?></option>
	
	<?php for ($z=100; $z<=2000; $z += 100) { ?>
		<option value="<?php echo $z;?>"><?php echo $z;?></option>
	<?php } ?>
	
	<option value="3000">3000</option>
	<option value="4000">4000</option>
	<option value="5000">5000</option>
	<option value="6000">6000</option>
	<option value="7000">7000</option>
	<option value="8000">8000</option>
	<option value="9000">9000</option>
	</select></td>

	<td><?php echo $tlls["ls"]["d30"];?><br /><select name="jak_delayout_lsna[]" class="form-control">
	<option value=""><?php echo $tl['cform']['c18'];?></option>
	
	<?php for ($z=100; $z<=2000; $z += 100) { ?>
		<option value="<?php echo $z;?>"><?php echo $z;?></option>
	<?php } ?>
	
	<option value="3000">3000</option>
	<option value="4000">4000</option>
	<option value="5000">5000</option>
	<option value="6000">6000</option>
	<option value="7000">7000</option>
	<option value="8000">8000</option>
	<option value="9000">9000</option>
	</select></td>

</tr>
</table>

</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>

<?php } } } ?>

</div>
<div class="tab-pane" id="style_tabs-3">

<?php $newcount = 10 - $count; if ($newcount != 0) for ($u = $count + 1; $u < 11; $u++) {  ?>

<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tlls["ls"]["d11"].' - '.$u;?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">

<table class="table table-striped">
<tr>
	<td><?php echo $tlls["ls"]["d33"];?></td>
	<td><input type="checkbox" name="jak_activeln[]" value="1" /></td>
</tr>
<tr>
	<td><?php echo $tlls["ls"]["d43"];?></td>
	<td>
	<div class="input-group">
	<input type="text" name="jak_2d_ln[]" class="form-control">
	<span class="input-group-addon"><a class="lsHelp" href="../plugins/slider/admin/doc/index.html#slide-transitions"><i class="fa fa-question-circle"></i></a></span>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tlls["ls"]["d44"];?></td>
	<td>
	<div class="input-group">
	<input type="text" name="jak_3d_ln[]" class="form-control">
	<span class="input-group-addon"><a class="lsHelp" href="../plugins/slider/admin/doc/index.html#slide-transitions"><i class="fa fa-question-circle"></i></a></span>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tlls["ls"]["d45"];?></td>
	<td>
	<div class="input-group">
	<input type="text" name="jak_ts_ln[]" class="form-control">
	<span class="input-group-addon"><a class="lsHelp" href="../plugins/slider/admin/doc/index.html#configuring-slides"><i class="fa fa-question-circle"></i></a></span>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tlls["ls"]["d51"];?></td>
	<td>
	<div class="input-group">
	<input type="text" name="jak_deep_ln[]" class="form-control">
	<span class="input-group-addon"><a class="lsHelp" href="../plugins/slider/admin/doc/index.html#deep-linking-slides"><i class="fa fa-question-circle"></i></a></span>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tlls["ls"]["d3"];?></td>
	<td><select name="jak_transition_ln[]" class="form-control">
	<option value=""><?php echo $tl['cform']['c18'];?></option>
	<option value="swing">Swing</option>
	<option value="easeInQuad">easeInQuad</option>
	<option value="easeOutQuad">easeOutQuad</option>
	<option value="easeInOutQuad">easeInOutQuad</option>
	<option value="easeInCubic">easeInCubic</option>
	<option value="easeOutCubic">easeOutCubic</option>
	<option value="easeInOutCubic">easeInOutCubic</option>
	<option value="easeInQuart">easeInQuart</option>
	<option value="easeOutQuart">easeOutQuart</option>
	<option value="easeInOutQuart">easeInOutQuart</option>
	<option value="easeInQuint">easeInQuint</option>
	<option value="easeInOutQuint">easeInOutQuint</option>
	<option value="easeInSine">easeInSine</option>
	<option value="easeOutSine">easeOutSine</option>
	<option value="easeInOutSine">easeInOutSine</option>
	<option value="easeInExpo">easeInExpo</option>
	<option value="easeOutExpo">easeOutExpo</option>
	<option value="easeInOutExpo">easeInOutExpo</option>
	<option value="easeInCirc">easeInCirc</option>
	<option value="easeOutCirc">easeOutCirc</option>
	<option value="easeInOutCirc">easeInOutCirc</option>
	<option value="easeInElastic">easeInElastic</option>
	<option value="easeInOutElastic">easeInOutElastic</option>
	<option value="easeInBack">easeInBack</option>
	<option value="easeOutBack">easeOutBack</option>
	<option value="easeInOutBack">easeInOutBack</option>
	<option value="easeInBounce">easeInBounce</option>
	<option value="easeOutBounce">easeOutBounce</option>
	<option value="easeInOutBounce">easeInOutBounce</option>
	</select></td>
</tr>
<tr>
	<td><?php echo $tlls["ls"]["d2"];?></td>
	<td><select name="jak_transition_out_ln[]" class="form-control">
	<option value=""><?php echo $tl['cform']['c18'];?></option>
	<option value="swing">Swing</option>
	<option value="easeInQuad">easeInQuad</option>
	<option value="easeOutQuad">easeOutQuad</option>
	<option value="easeInOutQuad">easeInOutQuad</option>
	<option value="easeInCubic">easeInCubic</option>
	<option value="easeOutCubic">easeOutCubic</option>
	<option value="easeInOutCubic">easeInOutCubic</option>
	<option value="easeInQuart">easeInQuart</option>
	<option value="easeOutQuart">easeOutQuart</option>
	<option value="easeInOutQuart">easeInOutQuart</option>
	<option value="easeInQuint">easeInQuint</option>
	<option value="easeInOutQuint">easeInOutQuint</option>
	<option value="easeInSine">easeInSine</option>
	<option value="easeOutSine">easeOutSine</option>
	<option value="easeInOutSine">easeInOutSine</option>
	<option value="easeInExpo">easeInExpo</option>
	<option value="easeOutExpo">easeOutExpo</option>
	<option value="easeInOutExpo">easeInOutExpo</option>
	<option value="easeInCirc">easeInCirc</option>
	<option value="easeOutCirc">easeOutCirc</option>
	<option value="easeInOutCirc">easeInOutCirc</option>
	<option value="easeInElastic">easeInElastic</option>
	<option value="easeInOutElastic">easeInOutElastic</option>
	<option value="easeInBack">easeInBack</option>
	<option value="easeOutBack">easeOutBack</option>
	<option value="easeInOutBack">easeInOutBack</option>
	<option value="easeInBounce">easeInBounce</option>
	<option value="easeOutBounce">easeOutBounce</option>
	<option value="easeInOutBounce">easeInOutBounce</option>
	</select></td>
</tr>
<tr>
	<td><?php echo $tlls["ls"]["d16"];?></td>
	<td><select name="jak_direction_ln[]" class="form-control">
	<option value=""><?php echo $tl['cform']['c18'];?></option>
	<option value="top"><?php echo $tlls["ls"]["d17"];?></option>
	<option value="left"><?php echo $tlls["ls"]["d18"];?></option>
	<option value="bottom"><?php echo $tlls["ls"]["d19"];?></option>
	<option value="right"><?php echo $tlls["ls"]["d20"];?></option>
	</select></td>
</tr>

<tr>
	<td><?php echo $tlls["ls"]["d5"];?></td>
	<td><select name="jak_pause_ln[]" class="form-control">
	<option value=""><?php echo $tl['cform']['c18'];?></option>
	<?php for($res=200; $res<=20000; $res += 200) { ?>
	<option value="<?php echo $res;?>"><?php echo $res;?></option>
	<?php } ?>
	</select></td>
</tr>

<tr>
	<td><?php echo $tlls["ls"]["d27"];?></td>
	<td><select name="jak_durationin_ln[]" class="form-control">
	<option value=""><?php echo $tl['cform']['c18'];?></option>
	
	<?php for ($z=100; $z<=2000; $z += 100) { ?>
		<option value="<?php echo $z;?>"><?php echo $z;?></option>
	<?php } ?>
	
	<option value="3000">3000</option>
	<option value="4000">4000</option>
	<option value="5000">5000</option>
	<option value="6000">6000</option>
	<option value="7000">7000</option>
	<option value="8000">8000</option>
	<option value="9000">9000</option>
	</select></td>
</tr>

<tr>
	<td><?php echo $tlls["ls"]["d28"];?></td>
	<td><select name="jak_duration_ln[]" class="form-control">
	<option value=""><?php echo $tl['cform']['c18'];?></option>
	
	<?php for ($z=100; $z<=2000; $z += 100) { ?>
		<option value="<?php echo $z;?>"><?php echo $z;?></option>
	<?php } ?>
	
	<option value="3000">3000</option>
	<option value="4000">4000</option>
	<option value="5000">5000</option>
	<option value="6000">6000</option>
	<option value="7000">7000</option>
	<option value="8000">8000</option>
	<option value="9000">9000</option>
	</select></td>
</tr>

<tr>
	<td><?php echo $tlls["ls"]["d29"];?></td>
	<td><select name="jak_delay_l[]" class="form-control">
	<option value=""><?php echo $tl['cform']['c18'];?></option>
	
	<?php for ($z=100; $z<=2000; $z += 100) { ?>
		<option value="<?php echo $z;?>"><?php echo $z;?></option>
	<?php } ?>
	
	<option value="3000">3000</option>
	<option value="4000">4000</option>
	<option value="5000">5000</option>
	<option value="6000">6000</option>
	<option value="7000">7000</option>
	<option value="8000">8000</option>
	<option value="9000">9000</option>
	</select></td>
</tr>

<tr>
	<td><?php echo $tlls["ls"]["d30"];?></td>
	<td><select name="jak_delayout_ln[]" class="form-control">
	<option value=""><?php echo $tl['cform']['c18'];?></option>
	
	<?php for ($z=100; $z<=2000; $z += 100) { ?>
		<option value="<?php echo $z;?>"><?php echo $z;?></option>
	<?php } ?>
	
	<option value="3000">3000</option>
	<option value="4000">4000</option>
	<option value="5000">5000</option>
	<option value="6000">6000</option>
	<option value="7000">7000</option>
	<option value="8000">8000</option>
	<option value="9000">9000</option>
	</select></td>
</tr>
</table>

</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>

<?php for ($o = 1; $o < 11; $o++) {  ?>

<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tlls["ls"]["d26"].' - '.$u.' / '.$o;?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">

<table class="table table-striped">
<tr>
	<td colspan="8"><?php echo $tlls["ls"]["d12"];?><br /><div class="input-group"><input type="text" class="form-control" name="jak_pathn[]" id="jak_pathn<?php echo $u.$o;?>">
	<span class="input-group-addon"><a href="../js/editor/plugins/filemanager/dialog.php?type=1&editor=mce_0&lang=eng&fldr=&field_id=jak_pathn<?php echo $u.$o;?>" class="ifManager"><i class="fa fa-picture-o"></i></a></span>
	<span class="input-group-addon"><a href="../js/editor/plugins/filemanager/dialog.php?type=2&editor=mce_0&lang=eng&fldr=&field_id=jak_pathn<?php echo $u.$o;?>" class="ifManager"><i class="fa fa-file"></i></a></span></div>
	</td>
</tr>
<tr>
	<td colspan="2"><?php echo $tlls["ls"]["d16"];?><br /><select name="jak_directionn[]" class="form-control">
	<option value=""><?php echo $tl['cform']['c18'];?></option>
	<option value="top"><?php echo $tlls["ls"]["d17"];?></option>
	<option value="left"><?php echo $tlls["ls"]["d18"];?></option>
	<option value="bottom"><?php echo $tlls["ls"]["d19"];?></option>
	<option value="right"><?php echo $tlls["ls"]["d20"];?></option>
	</select></td>
	<td colspan="3"><?php echo $tlls["ls"]["d13"];?><br /><input type="text" name="jak_linkn[]"<?php if ($o == 1) { echo ' readonly="readonly" placeholder="---"'; }?> value=""  class="form-control" /></td>
	<td><?php echo $tlls["ls"]["d14"];?><br /><input type="text" name="jak_stylen[]" value="" class="form-control" /></td>
	<td><?php echo $tlls["ls"]["d31"];?><br /><input type="text" name="jak_parallaxn[]" value="" class="form-control" /></td>
	<td><?php echo $tlls["ls"]["d32"];?><br /><input type="text" name="jak_parallaxoutn[]" value="" class="form-control" /></td>
</tr>
<tr>
	<td colspan="4">
	<?php echo $tlls["ls"]["d48"];?><br>
	<div class="input-group">
	<input type="text" name="jak_posn[]" class="form-control">
	<span class="input-group-addon"><a class="lsHelp" href="../plugins/slider/admin/doc/index.html#positioning-layers"><i class="fa fa-question-circle"></i></a></span>
	</div>
	</td>
	<td colspan="4">
	<?php echo $tlls["ls"]["d46"];?><br>
	<div class="input-group">
	<input type="text" name="jak_moven[]" class="form-control">
	<span class="input-group-addon"><a class="lsHelp" href="../plugins/slider/admin/doc/index.html#layer-transitions"><i class="fa fa-question-circle"></i></a></span>
	</div>
	</td>
</tr>
<tr>
	
		<td><?php echo $tlls["ls"]["d3"];?><br /><select name="jak_transition_lsn[]" class="form-control">
		<option value=""><?php echo $tl['cform']['c18'];?></option>
		<option value="swing">Swing</option>
		<option value="easeInQuad">easeInQuad</option>
		<option value="easeOutQuad">easeOutQuad</option>
		<option value="easeInOutQuad">easeInOutQuad</option>
		<option value="easeInCubic">easeInCubic</option>
		<option value="easeOutCubic">easeOutCubic</option>
		<option value="easeInOutCubic">easeInOutCubic</option>
		<option value="easeInQuart">easeInQuart</option>
		<option value="easeOutQuart">easeOutQuart</option>
		<option value="easeInOutQuart">easeInOutQuart</option>
		<option value="easeInQuint">easeInQuint</option>
		<option value="easeInOutQuint">easeInOutQuint</option>
		<option value="easeInSine">easeInSine</option>
		<option value="easeOutSine">easeOutSine</option>
		<option value="easeInOutSine">easeInOutSine</option>
		<option value="easeInExpo">easeInExpo</option>
		<option value="easeOutExpo">easeOutExpo</option>
		<option value="easeInOutExpo">easeInOutExpo</option>
		<option value="easeInCirc">easeInCirc</option>
		<option value="easeOutCirc">easeOutCirc</option>
		<option value="easeInOutCirc">easeInOutCirc</option>
		<option value="easeInElastic">easeInElastic</option>
		<option value="easeInOutElastic">easeInOutElastic</option>
		<option value="easeInBack">easeInBack</option>
		<option value="easeOutBack">easeOutBack</option>
		<option value="easeInOutBack">easeInOutBack</option>
		<option value="easeInBounce">easeInBounce</option>
		<option value="easeOutBounce">easeOutBounce</option>
		<option value="easeInOutBounce">easeInOutBounce</option>
		</select></td>
	
		<td><?php echo $tlls["ls"]["d2"];?><br /><select name="jak_transition_out_lsn[]" class="form-control">
		<option value=""><?php echo $tl['cform']['c18'];?></option>
		<option value="swing">Swing</option>
		<option value="easeInQuad">easeInQuad</option>
		<option value="easeOutQuad">easeOutQuad</option>
		<option value="easeInOutQuad">easeInOutQuad</option>
		<option value="easeInCubic">easeInCubic</option>
		<option value="easeOutCubic">easeOutCubic</option>
		<option value="easeInOutCubic">easeInOutCubic</option>
		<option value="easeInQuart">easeInQuart</option>
		<option value="easeOutQuart">easeOutQuart</option>
		<option value="easeInOutQuart">easeInOutQuart</option>
		<option value="easeInQuint">easeInQuint</option>
		<option value="easeInOutQuint">easeInOutQuint</option>
		<option value="easeInSine">easeInSine</option>
		<option value="easeOutSine">easeOutSine</option>
		<option value="easeInOutSine">easeInOutSine</option>
		<option value="easeInExpo">easeInExpo</option>
		<option value="easeOutExpo">easeOutExpo</option>
		<option value="easeInOutExpo">easeInOutExpo</option>
		<option value="easeInCirc">easeInCirc</option>
		<option value="easeOutCirc">easeOutCirc</option>
		<option value="easeInOutCirc">easeInOutCirc</option>
		<option value="easeInElastic">easeInElastic</option>
		<option value="easeInOutElastic">easeInOutElastic</option>
		<option value="easeInBack">easeInBack</option>
		<option value="easeOutBack">easeOutBack</option>
		<option value="easeInOutBack">easeInOutBack</option>
		<option value="easeInBounce">easeInBounce</option>
		<option value="easeOutBounce">easeOutBounce</option>
		<option value="easeInOutBounce">easeInOutBounce</option>
		</select></td>

	<td colspan="2"><?php echo $tlls["ls"]["d27"];?><br /><select name="jak_duration_lsn[]" class="form-control">
	<option value=""><?php echo $tl['cform']['c18'];?></option>
	
	<?php for ($z=100; $z<=2000; $z += 100) { ?>
		<option value="<?php echo $z;?>"><?php echo $z;?></option>
	<?php } ?>
	
	<option value="3000">3000</option>
	<option value="4000">4000</option>
	<option value="5000">5000</option>
	<option value="6000">6000</option>
	<option value="7000">7000</option>
	<option value="8000">8000</option>
	<option value="9000">9000</option>
	</select></td>

	<td colspan="2"><?php echo $tlls["ls"]["d28"];?><br /><select name="jak_durationout_lsn[]" class="form-control">
	<option value=""><?php echo $tl['cform']['c18'];?></option>
	
	<?php for ($z=100; $z<=2000; $z += 100) { ?>
		<option value="<?php echo $z;?>"><?php echo $z;?></option>
	<?php } ?>
	
	<option value="3000">3000</option>
	<option value="4000">4000</option>
	<option value="5000">5000</option>
	<option value="6000">6000</option>
	<option value="7000">7000</option>
	<option value="8000">8000</option>
	<option value="9000">9000</option>
	</select></td>

	<td><?php echo $tlls["ls"]["d29"];?><br /><select name="jak_delay_lsn[]" class="form-control">
	<option value=""><?php echo $tl['cform']['c18'];?></option>
	
	<?php for ($z=100; $z<=2000; $z += 100) { ?>
		<option value="<?php echo $z;?>"><?php echo $z;?></option>
	<?php } ?>
	
	<option value="3000">3000</option>
	<option value="4000">4000</option>
	<option value="5000">5000</option>
	<option value="6000">6000</option>
	<option value="7000">7000</option>
	<option value="8000">8000</option>
	<option value="9000">9000</option>
	</select></td>

	<td><?php echo $tlls["ls"]["d30"];?><br /><select name="jak_delayout_lsn[]" class="form-control">
	<option value=""><?php echo $tl['cform']['c18'];?></option>
	
	<?php for ($z=100; $z<=2000; $z += 100) { ?>
		<option value="<?php echo $z;?>"><?php echo $z;?></option>
	<?php } ?>
	
	<option value="3000">3000</option>
	<option value="4000">4000</option>
	<option value="5000">5000</option>
	<option value="6000">6000</option>
	<option value="7000">7000</option>
	<option value="8000">8000</option>
	<option value="9000">9000</option>
	</select></td>

</tr>
</table>

</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>

<?php } } ?>

</div>

</form>

<script type="text/javascript">
		$(document).ready(function() {
			$('#cmsTab a').click(function (e) {
			  e.preventDefault();
			  $(this).tab('show');
			});
			
			$('.lsHelp').on('click', function(e) {
				e.preventDefault();
				frameSrcH = $(this).attr("href");
				$('#JAKModalLabel').html("<?php echo $tlls["ls"]["d47"];?>");
				$('#JAKModal').on('show.bs.modal', function () {
				  	$('#JAKModal .modal-body').html('<iframe src="'+frameSrcH+'" width="100%" height="500" frameborder="0">');
				});
				$('#JAKModal').on('hidden.bs.modal', function() {
					$('#JAKModal .modal-body').html("");
				});
				$('#JAKModal').modal({show:true});
			});
		});
</script>
		
<?php include_once APP_PATH.'admin/template/footer.php';?>