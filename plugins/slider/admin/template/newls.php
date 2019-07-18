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
		<li class="active"><a href="#style_tabs-11"><?php echo $tl["page"]["p4"];?></a></li>
		<li><a href="#style_tabs-1">1</a></li>
		<li><a href="#style_tabs-2">2</a></li>
		<li><a href="#style_tabs-3">3</a></li>
		<li><a href="#style_tabs-4">4</a></li>
		<li><a href="#style_tabs-5">5</a></li>
		<li><a href="#style_tabs-6">6</a></li>
		<li><a href="#style_tabs-7">7</a></li>
		<li><a href="#style_tabs-8">8</a></li>
		<li><a href="#style_tabs-9">9</a></li>
		<li><a href="#style_tabs-10">10</a></li>
	</ul>
<div class="tab-content">
<div class="tab-pane active" id="style_tabs-11">
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["title"]["t13"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
		<table class="table">
		<tr>
			<td><?php echo $tlls["ls"]["d8"];?></td>
			<td>
			<div class="form-group<?php if (isset($errors["e1"])) echo " has-error";?>">
				<input type="text" name="jak_title" class="form-control" value="<?php if (isset($_REQUEST["jak_title"])) echo $_REQUEST["jak_title"];?>" />
			</div></td>
		</tr>
		<tr>
			<td><?php echo $tlls["ls"]["d9"];?></td>
			<td>
			<div class="input-group<?php if (isset($errors["e3"])) echo " has-error";?>">
			<input type="text" name="jak_lswidth" class="form-control" value="<?php if (isset($_REQUEST["jak_lswidth"])) echo $_REQUEST["jak_lswidth"] ?>" class="form-control" />
			<span class="input-group-addon">px / &#37;</span>
			</div>
			</td>
		</tr>
		<tr>
			<td><?php echo $tlls["ls"]["d10"];?></td>
			<td>
			<div class="input-group<?php if (isset($errors["e3"])) echo " has-error";?>"><input type="text" name="jak_lsheight" value="<?php if (isset($_REQUEST["jak_lsheight"])) echo $_REQUEST["jak_lsheight"] ?>" class="form-control" />
			<span class="input-group-addon">px / &#37;</span>
			</div>
			</td>
		</tr>
		<tr>
			<td><?php echo $tlls["ls"]["d23"];?></td>
			<td>
			<div class="input-group">
				<input type="text" name="jak_logod" id="jak_logod" class="form-control" value="<?php if (isset($_REQUEST["jak_logod"])) echo $_REQUEST["jak_logod"]; ?>" />
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
				<input type="text" name="jak_logolink" id="jak_logolink" class="form-control" value="<?php if (isset($_REQUEST["jak_logolink"])) echo $_REQUEST["jak_logolink"]; ?>" />
				<span class="input-group-btn">
				  <a class="btn btn-info ifManager" type="button" href="../js/editor/plugins/filemanager/dialog.php?type=1&subfolder=&editor=mce_0&lang=eng&fldr=&field_id=jak_logolink"><?php echo $tl["general"]["g69"];?></a>
				</span>
			</div><!-- /input-group -->
			</td>
		</tr>
		<tr>
			<td><?php echo $tlls["ls"]["d1"];?></td>
			<td><div class="radio"><label><input type="radio" name="jak_animatef" value="1"<?php if (isset($_REQUEST["jak_animatef"]) && $_REQUEST["jak_animatef"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
			<div class="radio"><label><input type="radio" name="jak_animatef" value="0"<?php if (isset($_REQUEST["jak_animatef"]) && $_REQUEST["jak_animatef"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
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
				
						<div class="radio">
						<label>
						<input type="radio" name="jak_theme" value="<?php echo $l;?>"<?php if (isset($_REQUEST["jak_theme"]) && $_REQUEST["jak_theme"] == $l) { ?> checked="checked"<?php } ?> /> <?php echo $l;?>
						</label>
						</div>
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
			<option value="swing"<?php if (isset($_REQUEST["jak_transition"]) && $_REQUEST["jak_transition"] == 'swing') { ?> selected="selected"<?php } ?>>Swing</option>
			<option value="easeInQuad"<?php if (isset($_REQUEST["jak_transition"]) && $_REQUEST["jak_transition"] == 'easeInQuad') { ?> selected="selected"<?php } ?>>easeInQuad</option>
			<option value="easeOutQuad"<?php if (isset($_REQUEST["jak_transition"]) && $_REQUEST["jak_transition"] == 'easeOutQuad') { ?> selected="selected"<?php } ?>>easeOutQuad</option>
			<option value="easeInOutQuad"<?php if (isset($_REQUEST["jak_transition"]) && $_REQUEST["jak_transition"] == 'easeInOutQuad') { ?> selected="selected"<?php } ?>>easeInOutQuad</option>
			<option value="easeInCubic"<?php if (isset($_REQUEST["jak_transition"]) && $_REQUEST["jak_transition"] == 'easeInCubic') { ?> selected="selected"<?php } ?>>easeInCubic</option>
			<option value="easeOutCubic"<?php if (isset($_REQUEST["jak_transition"]) && $_REQUEST["jak_transition"] == 'easeOutCubic') { ?> selected="selected"<?php } ?>>easeOutCubic</option>
			<option value="easeInOutCubic"<?php if (isset($_REQUEST["jak_transition"]) && $_REQUEST["jak_transition"] == 'easeInOutCubic') { ?> selected="selected"<?php } ?>>easeInOutCubic</option>
			<option value="easeInQuart"<?php if (isset($_REQUEST["jak_transition"]) && $_REQUEST["jak_transition"] == 'easeInQuart') { ?> selected="selected"<?php } ?>>easeInQuart</option>
			<option value="easeOutQuart"<?php if (isset($_REQUEST["jak_transition"]) && $_REQUEST["jak_transition"] == 'easeOutQuart') { ?> selected="selected"<?php } ?>>easeOutQuart</option>
			<option value="easeInOutQuart"<?php if (isset($_REQUEST["jak_transition"]) && $_REQUEST["jak_transition"] == 'easeInOutQuart') { ?> selected="selected"<?php } ?>>easeInOutQuart</option>
			<option value="easeInQuint"<?php if (isset($_REQUEST["jak_transition"]) && $_REQUEST["jak_transition"] == 'easeInQuint') { ?> selected="selected"<?php } ?>>easeInQuint</option>
			<option value="easeInOutQuint"<?php if (isset($_REQUEST["jak_transition"]) && $_REQUEST["jak_transition"] == 'easeInOutQuint') { ?> selected="selected"<?php } ?>>easeInOutQuint</option>
			<option value="easeInSine"<?php if (isset($_REQUEST["jak_transition"]) && $_REQUEST["jak_transition"] == 'easeInSine') { ?> selected="selected"<?php } ?>>easeInSine</option>
			<option value="easeOutSine"<?php if (isset($_REQUEST["jak_transition"]) && $_REQUEST["jak_transition"] == 'easeOutSine') { ?> selected="selected"<?php } ?>>easeOutSine</option>
			<option value="easeInOutSine"<?php if (isset($_REQUEST["jak_transition"]) && $_REQUEST["jak_transition"] == 'easeInOutSine') { ?> selected="selected"<?php } ?>>easeInOutSine</option>
			<option value="easeInExpo"<?php if (isset($_REQUEST["jak_transition"]) && $_REQUEST["jak_transition"] == 'easeInExpo') { ?> selected="selected"<?php } ?>>easeInExpo</option>
			<option value="easeOutExpo"<?php if (isset($_REQUEST["jak_transition"]) && $_REQUEST["jak_transition"] == 'easeOutExpo') { ?> selected="selected"<?php } ?>>easeOutExpo</option>
			<option value="easeInOutExpo"<?php if (isset($_REQUEST["jak_transition"]) && $_REQUEST["jak_transition"] == 'easeInOutExpo') { ?> selected="selected"<?php } ?>>easeInOutExpo</option>
			<option value="easeInCirc"<?php if (isset($_REQUEST["jak_transition"]) && $_REQUEST["jak_transition"] == 'easeInCirc') { ?> selected="selected"<?php } ?>>easeInCirc</option>
			<option value="easeOutCirc"<?php if (isset($_REQUEST["jak_transition"]) && $_REQUEST["jak_transition"] == 'easeOutCirc') { ?> selected="selected"<?php } ?>>easeOutCirc</option>
			<option value="easeInOutCirc"<?php if (isset($_REQUEST["jak_transition"]) && $_REQUEST["jak_transition"] == 'easeInOutCirc') { ?> selected="selected"<?php } ?>>easeInOutCirc</option>
			<option value="easeInElastic"<?php if (isset($_REQUEST["jak_transition"]) && $_REQUEST["jak_transition"] == 'easeInElastic') { ?> selected="selected"<?php } ?>>easeInElastic</option>
			<option value="easeInOutElastic"<?php if (isset($_REQUEST["jak_transition"]) && $_REQUEST["jak_transition"] == 'easeInOutElastic') { ?> selected="selected"<?php } ?>>easeInOutElastic</option>
			<option value="easeInBack"<?php if (isset($_REQUEST["jak_transition"]) && $_REQUEST["jak_transition"] == 'easeInBack') { ?> selected="selected"<?php } ?>>easeInBack</option>
			<option value="easeOutBack"<?php if (isset($_REQUEST["jak_transition"]) && $_REQUEST["jak_transition"] == 'easeOutBack') { ?> selected="selected"<?php } ?>>easeOutBack</option>
			<option value="easeInOutBack"<?php if (isset($_REQUEST["jak_transition"]) && $_REQUEST["jak_transition"] == 'easeInOutBack') { ?> selected="selected"<?php } ?>>easeInOutBack</option>
			<option value="easeInBounce"<?php if (isset($_REQUEST["jak_transition"]) && $_REQUEST["jak_transition"] == 'easeInBounce') { ?> selected="selected"<?php } ?>>easeInBounce</option>
			<option value="easeOutBounce"<?php if (isset($_REQUEST["jak_transition"]) && $_REQUEST["jak_transition"] == 'easeOutBounce') { ?> selected="selected"<?php } ?>>easeOutBounce</option>
			<option value="easeInOutBounce"<?php if (isset($_REQUEST["jak_transition"]) && $_REQUEST["jak_transition"] == 'easeInOutBounce') { ?> selected="selected"<?php } ?>>easeInOutBounce</option>
			</select></td>
		</tr>
		<tr>
			<td><?php echo $tlls["ls"]["d2"];?></td>
			<td><select name="jak_transition_out" class="form-control">
			<option value="swing"<?php if (isset($_REQUEST["jak_transition_out"]) && $_REQUEST["jak_transition_out"] == 'swing') { ?> selected="selected"<?php } ?>>Swing</option>
			<option value="easeInQuad"<?php if (isset($_REQUEST["jak_transition_out"]) && $_REQUEST["jak_transition_out"] == 'easeInQuad') { ?> selected="selected"<?php } ?>>easeInQuad</option>
			<option value="easeOutQuad"<?php if (isset($_REQUEST["jak_transition_out"]) && $_REQUEST["jak_transition_out"] == 'easeOutQuad') { ?> selected="selected"<?php } ?>>easeOutQuad</option>
			<option value="easeInOutQuad"<?php if (isset($_REQUEST["jak_transition_out"]) && $_REQUEST["jak_transition_out"] == 'easeInOutQuad') { ?> selected="selected"<?php } ?>>easeInOutQuad</option>
			<option value="easeInCubic"<?php if (isset($_REQUEST["jak_transition_out"]) && $_REQUEST["jak_transition_out"] == 'easeInCubic') { ?> selected="selected"<?php } ?>>easeInCubic</option>
			<option value="easeOutCubic"<?php if (isset($_REQUEST["jak_transition_out"]) && $_REQUEST["jak_transition_out"] == 'easeOutCubic') { ?> selected="selected"<?php } ?>>easeOutCubic</option>
			<option value="easeInOutCubic"<?php if (isset($_REQUEST["jak_transition_out"]) && $_REQUEST["jak_transition_out"] == 'easeInOutCubic') { ?> selected="selected"<?php } ?>>easeInOutCubic</option>
			<option value="easeInQuart"<?php if (isset($_REQUEST["jak_transition_out"]) && $_REQUEST["jak_transition_out"] == 'easeInQuart') { ?> selected="selected"<?php } ?>>easeInQuart</option>
			<option value="easeOutQuart"<?php if (isset($_REQUEST["jak_transition_out"]) && $_REQUEST["jak_transition_out"] == 'easeOutQuart') { ?> selected="selected"<?php } ?>>easeOutQuart</option>
			<option value="easeInOutQuart"<?php if (isset($_REQUEST["jak_transition_out"]) && $_REQUEST["jak_transition_out"] == 'easeInOutQuart') { ?> selected="selected"<?php } ?>>easeInOutQuart</option>
			<option value="easeInQuint"<?php if (isset($_REQUEST["jak_transition_out"]) && $_REQUEST["jak_transition_out"] == 'easeInQuint') { ?> selected="selected"<?php } ?>>easeInQuint</option>
			<option value="easeInOutQuint"<?php if (isset($_REQUEST["jak_transition_out"]) && $_REQUEST["jak_transition_out"] == 'easeInOutQuint') { ?> selected="selected"<?php } ?>>easeInOutQuint</option>
			<option value="easeInSine"<?php if (isset($_REQUEST["jak_transition_out"]) && $_REQUEST["jak_transition_out"] == 'easeInSine') { ?> selected="selected"<?php } ?>>easeInSine</option>
			<option value="easeOutSine"<?php if (isset($_REQUEST["jak_transition_out"]) && $_REQUEST["jak_transition_out"] == 'easeOutSine') { ?> selected="selected"<?php } ?>>easeOutSine</option>
			<option value="easeInOutSine"<?php if (isset($_REQUEST["jak_transition_out"]) && $_REQUEST["jak_transition_out"] == 'easeInOutSine') { ?> selected="selected"<?php } ?>>easeInOutSine</option>
			<option value="easeInExpo"<?php if (isset($_REQUEST["jak_transition_out"]) && $_REQUEST["jak_transition_out"] == 'easeInExpo') { ?> selected="selected"<?php } ?>>easeInExpo</option>
			<option value="easeOutExpo"<?php if (isset($_REQUEST["jak_transition_out"]) && $_REQUEST["jak_transition_out"] == 'easeOutExpo') { ?> selected="selected"<?php } ?>>easeOutExpo</option>
			<option value="easeInOutExpo"<?php if (isset($_REQUEST["jak_transition_out"]) && $_REQUEST["jak_transition_out"] == 'easeInOutExpo') { ?> selected="selected"<?php } ?>>easeInOutExpo</option>
			<option value="easeInCirc"<?php if (isset($_REQUEST["jak_transition_out"]) && $_REQUEST["jak_transition_out"] == 'easeInCirc') { ?> selected="selected"<?php } ?>>easeInCirc</option>
			<option value="easeOutCirc"<?php if (isset($_REQUEST["jak_transition_out"]) && $_REQUEST["jak_transition_out"] == 'easeOutCirc') { ?> selected="selected"<?php } ?>>easeOutCirc</option>
			<option value="easeInOutCirc"<?php if (isset($_REQUEST["jak_transition_out"]) && $_REQUEST["jak_transition_out"] == 'easeInOutCirc') { ?> selected="selected"<?php } ?>>easeInOutCirc</option>
			<option value="easeInElastic"<?php if (isset($_REQUEST["jak_transition_out"]) && $_REQUEST["jak_transition_out"] == 'easeInElastic') { ?> selected="selected"<?php } ?>>easeInElastic</option>
			<option value="easeInOutElastic"<?php if (isset($_REQUEST["jak_transition_out"]) && $_REQUEST["jak_transition_out"] == 'easeInOutElastic') { ?> selected="selected"<?php } ?>>easeInOutElastic</option>
			<option value="easeInBack"<?php if (isset($_REQUEST["jak_transition_out"]) && $_REQUEST["jak_transition_out"] == 'easeInBack') { ?> selected="selected"<?php } ?>>easeInBack</option>
			<option value="easeOutBack"<?php if (isset($_REQUEST["jak_transition_out"]) && $_REQUEST["jak_transition_out"] == 'easeOutBack') { ?> selected="selected"<?php } ?>>easeOutBack</option>
			<option value="easeInOutBack"<?php if (isset($_REQUEST["jak_transition_out"]) && $_REQUEST["jak_transition_out"] == 'easeInOutBack') { ?> selected="selected"<?php } ?>>easeInOutBack</option>
			<option value="easeInBounce"<?php if (isset($_REQUEST["jak_transition_out"]) && $_REQUEST["jak_transition_out"] == 'easeInBounce') { ?> selected="selected"<?php } ?>>easeInBounce</option>
			<option value="easeOutBounce"<?php if (isset($_REQUEST["jak_transition_out"]) && $_REQUEST["jak_transition_out"] == 'easeOutBounce') { ?> selected="selected"<?php } ?>>easeOutBounce</option>
			<option value="easeInOutBounce"<?php if (isset($_REQUEST["jak_transition_out"]) && $_REQUEST["jak_transition_out"] == 'easeInOutBounce') { ?> selected="selected"<?php } ?>>easeInOutBounce</option>
			</select></td>
		</tr>
		<tr>
			<td><?php echo $tlls["ls"]["d16"];?></td>
			<td><select name="jak_direction" class="form-control">
			<option value="top"<?php if (isset($_REQUEST["jak_direction"]) && $_REQUEST["jak_direction"] == "top") { ?> selected="selected"<?php } ?>><?php echo $tlls["ls"]["d17"];?></option>
			<option value="left"<?php if (isset($_REQUEST["jak_direction"]) && $_REQUEST["jak_direction"] == "left") { ?> selected="selected"<?php } ?>><?php echo $tlls["ls"]["d18"];?></option>
			<option value="bottom"<?php if (isset($_REQUEST["jak_direction"]) && $_REQUEST["jak_direction"] == "bottom") { ?> selected="selected"<?php } ?>><?php echo $tlls["ls"]["d19"];?></option>
			<option value="right"<?php if (isset($_REQUEST["jak_direction"]) && $_REQUEST["jak_direction"] == "right") { ?> selected="selected"<?php } ?>><?php echo $tlls["ls"]["d20"];?></option>
			</select></td>
		</tr>
		<tr>
			<td><?php echo $tlls["ls"]["d5"];?></td>
			<td><select name="jak_pause" class="form-control">
			<?php for($i=200; $i<=20000; $i += 200) { ?>
			<option value="<?php echo $i;?>"<?php if (isset($_REQUEST["jak_pause"]) && $_REQUEST["jak_pause"] == $i) { ?> selected="selected"<?php } ?>><?php echo $i;?></option>
			<?php } ?>
			</select></td>
		</tr>
		<tr>
			<td><?php echo $tlls["ls"]["d50"];?> <a class="cms-help" data-content="<?php echo $tlls["ls"]["h"];?>" href="javascript:void(0)" data-original-title="<?php echo $tl["title"]["t21"];?>"><i class="fa fa-question-circle"></i></a></td>
			<td>
			<div class="radio"><label>
			<input type="radio" name="jak_ontop" value="1"<?php if (isset($_REQUEST["jak_ontop"]) && $_REQUEST["jak_ontop"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
			</label></div>
			<div class="radio"><label>
			<input type="radio" name="jak_ontop" value="0"<?php if (isset($_REQUEST["jak_ontop"]) && $_REQUEST["jak_ontop"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
			</label></div>
			</td>
		</tr>
		<tr>
			<td><?php echo $tlls["ls"]["d42"];?></td>
			<td><div class="radio"><label><input type="radio" name="jak_responsive" value="1"<?php if (isset($_REQUEST["jak_responsive"]) && $_REQUEST["jak_responsive"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
			<div class="radio"><label><input type="radio" name="jak_responsive" value="0"<?php if (isset($_REQUEST["jak_responsive"]) && $_REQUEST["jak_responsive"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
		</tr>
		<tr>
			<td><?php echo $tlls["ls"]["d24"];?></td>
			<td><div class="radio"><label><input type="radio" name="jak_autostart" value="1"<?php if (isset($_REQUEST["jak_autostart"]) && $_REQUEST["jak_autostart"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
			<div class="radio"><label><input type="radio" name="jak_autostart" value="0"<?php if (isset($_REQUEST["jak_autostart"]) && $_REQUEST["jak_autostart"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
		</tr>
		<tr>
			<td><?php echo $tlls["ls"]["d21"];?></td>
			<td><div class="radio"><label><input type="radio" name="jak_navbutton" value="1"<?php if (isset($_REQUEST["jak_navbutton"]) && $_REQUEST["jak_navbutton"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
			<div class="radio"><label><input type="radio" name="jak_navbutton" value="0"<?php if (isset($_REQUEST["jak_navbutton"]) && $_REQUEST["jak_navbutton"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
		</tr>
		<tr>
			<td><?php echo $tlls["ls"]["d22"];?></td>
			<td><div class="radio"><label><input type="radio" name="jak_buttonnext" value="1"<?php if (isset($_REQUEST["jak_buttonnext"]) && $_REQUEST["jak_buttonnext"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
			<div class="radio"><label><input type="radio" name="jak_buttonnext" value="0"<?php if (isset($_REQUEST["jak_buttonnext"]) && $_REQUEST["jak_buttonnext"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
		</tr>
		<tr>
			<td><?php echo $tlls["ls"]["d25"];?></td>
			<td><div class="radio"><label><input type="radio" name="jak_preload" value="1"<?php if (isset($_REQUEST["jak_preload"]) && $_REQUEST["jak_preload"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
			<div class="radio"><label><input type="radio" name="jak_preload" value="0"<?php if (isset($_REQUEST["jak_preload"]) && $_REQUEST["jak_preload"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
		</tr>
		<tr>
			<td><?php echo $tlls["ls"]["d36"];?></td>
			<td><div class="radio"><label><input type="radio" name="jak_mhover" value="1"<?php if (isset($_REQUEST["jak_mhover"]) && $_REQUEST["jak_mhover"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
			<div class="radio"><label><input type="radio" name="jak_mhover" value="0"<?php if (isset($_REQUEST["jak_mhover"]) && $_REQUEST["jak_mhover"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
		</tr>
		<tr>
			<td><?php echo $tlls["ls"]["d37"];?></td>
			<td><select name="jak_loops" class="form-control">
			<option value="0"<?php if (isset($_REQUEST["jak_loops"]) && $_REQUEST["jak_loops"] == 0) { ?> selected="selected"<?php } ?>>0 (<?php echo $tlls["ls"]["d41"];?>)</option>
			<?php for ($i = 1; $i <= 99; $i++) { ?>
			<option value="<?php echo $i ?>"<?php if (isset($_REQUEST["jak_loops"]) && $_REQUEST["jak_loops"] == $i) { ?> selected="selected"<?php } ?>><?php echo $i; ?></option>
			<?php } ?>
			</select></td>
		</tr>
		<tr>
			<td><?php echo $tlls["ls"]["d38"];?></td>
			<td><div class="radio"><label><input type="radio" name="jak_floops" value="1"<?php if (isset($_REQUEST["jak_floops"]) && $_REQUEST["jak_floops"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
			<div class="radio"><label><input type="radio" name="jak_floops" value="0"<?php if (isset($_REQUEST["jak_floops"]) && $_REQUEST["jak_floops"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
		</tr>
		<tr>
			<td><?php echo $tlls["ls"]["d39"];?></td>
			<td><div class="radio"><label><input type="radio" name="jak_autov" value="1"<?php if (isset($_REQUEST["jak_autov"]) && $_REQUEST["jak_autov"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
			<div class="radio"><label><input type="radio" name="jak_autov" value="0"<?php if (isset($_REQUEST["jak_autov"]) && $_REQUEST["jak_autov"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
		</tr>
		<tr>
			<td><?php echo $tlls["ls"]["d40"];?></td>
			<td><select name="jak_prevv" class="form-control">
			<option value="maxresdefault.jpg"<?php if (isset($_REQUEST["jak_prevv"]) && $_REQUEST["jak_prevv"] == "maxresdefault.jpg") { ?> selected="selected"<?php } ?>>maxresdefault.jpg</option>
			<option value="hqdefault.jpg"<?php if (isset($_REQUEST["jak_prevv"]) && $_REQUEST["jak_prevv"] == "hqdefault.jpg") { ?> selected="selected"<?php } ?>>hqdefault.jpg</option>
			<option value="mqdefault.jpg"<?php if (isset($_REQUEST["jak_prevv"]) && $_REQUEST["jak_prevv"] == "mqdefault.jpg") { ?> selected="selected"<?php } ?>>mqdefault.jpg</option>
			<option value="default.jpg"<?php if (isset($_REQUEST["jak_prevv"]) && $_REQUEST["jak_prevv"] == "default.jpg") { ?> selected="selected"<?php } ?>>default.jpg</option>
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
		<option value="0"<?php if (isset($_REQUEST["jak_permission"]) && in_array(0, $_REQUEST["jak_permission"])) { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g84"];?></option>
		<?php if (isset($JAK_USERGROUP) && is_array($JAK_USERGROUP)) foreach($JAK_USERGROUP as $v) { ?><option value="<?php echo $v["id"];?>"<?php if (isset($_REQUEST["jak_permission"]) && in_array($v["id"], $_REQUEST["jak_permission"])) { ?> selected="selected"<?php } ?>><?php echo $v["name"];?></option><?php } ?>
		</select></td>
	</tr>
	</table>
	</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>

</div>

<?php for ($i = 1; $i < 21; $i++) {  ?>

<div class="tab-pane" id="style_tabs-<?php echo $i;?>">

<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tlls["ls"]["d11"].' - ',$i;?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table">
<tr>
	<td><?php echo $tlls["ls"]["d33"];?></td>
	<td><input type="checkbox" name="jak_activel[]" value="1" /><input type="hidden" name="jak_layerid[]" value="<?php echo $i;?>" /></td>
</tr>
<tr>
	<td><?php echo $tlls["ls"]["d43"];?></td>
	<td>
	<div class="input-group">
	<input type="text" name="jak_2d[]" class="form-control">
	<span class="input-group-addon"><a class="lsHelp" href="../plugins/slider/admin/doc/index.html#slide-transitions"><i class="fa fa-question-circle"></i></a></span>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tlls["ls"]["d44"];?></td>
	<td>
	<div class="input-group">
	<input type="text" name="jak_3d[]" class="form-control">
	<span class="input-group-addon"><a class="lsHelp" href="../plugins/slider/admin/doc/index.html#slide-transitions"><i class="fa fa-question-circle"></i></a></span>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tlls["ls"]["d45"];?></td>
	<td>
	<div class="input-group">
	<input type="text" name="jak_ts[]" class="form-control">
	<span class="input-group-addon"><a class="lsHelp" href="../plugins/slider/admin/doc/index.html#configuring-slides"><i class="fa fa-question-circle"></i></a></span>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tlls["ls"]["d51"];?></td>
	<td>
	<div class="input-group">
	<input type="text" name="jak_deep[]" class="form-control">
	<span class="input-group-addon"><a class="lsHelp" href="../plugins/slider/admin/doc/index.html#deep-linking-slides"><i class="fa fa-question-circle"></i></a></span>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tlls["ls"]["d3"];?></td>
	<td><select name="jak_transition_l[]" class="form-control">
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
	<option value="easeOutSine">>easeOutSine</option>
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
	<td><select name="jak_transition_out_l[]" class="form-control">
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
	<td><select name="jak_direction_l[]" class="form-control">
	<option value=""><?php echo $tl['cform']['c18'];?></option>
	<option value="top"><?php echo $tlls["ls"]["d17"];?></option>
	<option value="left"><?php echo $tlls["ls"]["d18"];?></option>
	<option value="bottom"><?php echo $tlls["ls"]["d19"];?></option>
	<option value="right"><?php echo $tlls["ls"]["d20"];?></option>
	</select></td>
</tr>

<tr>
	<td><?php echo $tlls["ls"]["d5"];?></td>
	<td><select name="jak_pause_l[]" class="form-control">
	<option value=""><?php echo $tl['cform']['c18'];?></option>
	<?php for($o=200; $o<=20000; $o += 200) { ?>
	<option value="<?php echo $o;?>"><?php echo $o;?></option>
	<?php } ?>
	</select></td>
</tr>

<tr>
	<td><?php echo $tlls["ls"]["d27"];?></td>
	<td><select name="jak_durationin_l[]" class="form-control">
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
	<td><select name="jak_duration_l[]" class="form-control">
	<option value=""><?php echo $tl['cform']['c18'];?></option>
	
	<?php for ($z=100; $z<=2000; $z += 100) { ?>
		<option value="<?php echo $z;?>"><?php echo $z;?></option>
	<?php } ?>
	
	<option value="2000">2000</option>
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
	<td><select name="jak_delayout_l[]" class="form-control">
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

<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tlls["ls"]["d26"].' - '.$i.' / '.$o;?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">

<table class="table table-striped">
<tr>
	<td colspan="8"><?php echo $tlls["ls"]["d12"];?><br /><div class="input-group"><input type="text" class="form-control" name="jak_path<?php echo $i;?>[]" id="jak_path<?php echo $i.$o;?>"><span class="input-group-addon"><a href="../js/editor/plugins/filemanager/dialog.php?type=1&editor=mce_0&lang=eng&fldr=&field_id=jak_path<?php echo $i.$o;?>" class="ifManager"><i class="fa fa-picture-o"></i></a></span>
	<span class="input-group-addon"><a href="../js/editor/plugins/filemanager/dialog.php?type=2&editor=mce_0&lang=eng&fldr=&field_id=jak_path<?php echo $i.$o;?>" class="ifManager"><i class="fa fa-file"></i></a></span></div>
	</td>
</tr>
<tr>
	<td colspan="2"><?php echo $tlls["ls"]["d16"];?><br /><select name="jak_direction_ls<?php echo $i;?>[]" class="form-control">
	<option value=""><?php echo $tl['cform']['c18'];?></option>
	<option value="top"><?php echo $tlls["ls"]["d17"];?></option>
	<option value="left"><?php echo $tlls["ls"]["d18"];?></option>
	<option value="bottom"><?php echo $tlls["ls"]["d19"];?></option>
	<option value="right"><?php echo $tlls["ls"]["d20"];?></option>
	</select></td>
	<td colspan="3"><?php echo $tlls["ls"]["d13"];?><br /><input type="text" name="jak_link<?php echo $i;?>[]"<?php if ($o == 1) { echo ' readonly="readonly" placeholder="---"'; }?> class="form-control" /></td>
	<td><?php echo $tlls["ls"]["d14"];?><br /><input type="text" name="jak_style<?php echo $i;?>[]" class="form-control" /></td>
	<td><?php echo $tlls["ls"]["d31"];?><br /><input type="text" name="jak_parallax<?php echo $i;?>[]" class="form-control" /></td>
	<td><?php echo $tlls["ls"]["d32"];?><br /><input type="text" name="jak_parallaxout<?php echo $i;?>[]" class="form-control" /></td>
</tr>
<tr>
	<td colspan="4">
	<?php echo $tlls["ls"]["d48"];?><br>
	<div class="input-group">
	<input type="text" name="jak_pos<?php echo $i;?>[]" class="form-control">
	<span class="input-group-addon"><a class="lsHelp" href="../plugins/slider/admin/doc/index.html#positioning-layers"><i class="fa fa-question-circle"></i></a></span>
	</div>
	</td>
	<td colspan="4">
	<?php echo $tlls["ls"]["d46"];?><br>
	<div class="input-group">
	<input type="text" name="jak_move<?php echo $i;?>[]" class="form-control">
	<span class="input-group-addon"><a class="lsHelp" href="../plugins/slider/admin/doc/index.html#layer-transitions"><i class="fa fa-question-circle"></i></a></span>
	</div>
	</td>
</tr>
<tr>
	
		<td><?php echo $tlls["ls"]["d3"];?><br /><select name="jak_transition_ls<?php echo $i;?>[]" class="form-control">
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
	
		<td><?php echo $tlls["ls"]["d2"];?><br /><select name="jak_transition_out_ls<?php echo $i;?>[]" class="form-control">
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

	<td colspan="2"><?php echo $tlls["ls"]["d27"];?><br /><select name="jak_duration_ls<?php echo $i;?>[]" class="form-control">
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

	<td colspan="2"><?php echo $tlls["ls"]["d28"];?><br /><select name="jak_durationout_ls<?php echo $i;?>[]" class="form-control">
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

	<td><?php echo $tlls["ls"]["d29"];?><br /><select name="jak_delay_ls<?php echo $i;?>[]" class="form-control">
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

	<td><?php echo $tlls["ls"]["d30"];?><br /><select name="jak_delayout_ls<?php echo $i;?>[]" class="form-control">
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

<?php } ?>

</div>

<?php } ?>

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