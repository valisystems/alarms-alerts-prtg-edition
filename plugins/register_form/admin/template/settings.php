<?php include_once APP_PATH.'admin/template/header.php';?>

<?php if ($page2 == "s") { ?>
<div class="alert alert-success fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?php echo $tl["general"]["g7"];?>
</div>
<?php } if ($page2 == "e" || $page1 == "ene") { ?>
<div class="alert alert-danger fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?php echo ($page1 == "e" ? $tl["errorpage"]["sql"] : $tl["errorpage"]["not"]);?>
</div>
<?php } ?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<ul class="nav nav-tabs" id="cmsTab">
	<li class="active"><a href="#style_tabs-1"><?php echo $tl["menu"]["m2"];?></a></li>
	<li><a href="#style_tabs-2"><?php echo $tl["general"]["g89"];?></a></li>
</ul>

<div class="tab-content">
<div class="tab-pane active" id="style_tabs-1">
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["page"]["p"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table table-striped">
<tr>
	<td>
	<?php include APP_PATH."admin/template/title_edit.php";?>
	</td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $lrf["register"]["r6"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><?php echo $lrf["register"]["r3"];?></td>
	<td>
	<div class="radio"><label>
		<input type="radio" name="jak_register" value="1"<?php if ($jkv["rf_active"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
	</label></div>
	<div class="radio"><label>
		<input type="radio" name="jak_register" value="0"<?php if ($jkv["rf_active"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
	</label></div></td>
</tr>
<tr>
	<td><?php echo $lrf["register"]["r12"];?></td>
	<td>
	<div class="radio"><label>
		<input type="radio" name="jak_simple" value="1"<?php if ($jkv["rf_simple"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
	</label></div>
	<div class="radio"><label>
		<input type="radio" name="jak_simple" value="0"<?php if ($jkv["rf_simple"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
	</label></div></td>
</tr>
<tr>
	<td><?php echo $lrf["register"]["r4"];?></td>
	<td>
	<div class="radio"><label>
		<input type="radio" name="jak_usrapprove" value="1"<?php if ($jkv["rf_confirm"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
	</label></div>
	<div class="radio"><label>
		<input type="radio" name="jak_usrapprove" value="2"<?php if ($jkv["rf_confirm"] == '2') { ?> checked="checked"<?php } ?> /> <?php echo $lrf["register"]["r7"];?>
	</label></div>
	<div class="radio"><label>
		<input type="radio" name="jak_usrapprove" value="3"<?php if ($jkv["rf_confirm"] == '3') { ?> checked="checked"<?php } ?> /> <?php echo $lrf["register"]["r8"];?>
	</label></div>
	</td>
</tr>
<tr>
	<td><?php echo $lrf["register"]["r10"];?></td>
	<td><select name="jak_redirect" class="form-control">
	<option value="0"><?php echo $tl["title"]["t12"];?></option>
	<?php if (isset($JAK_CAT) && is_array($JAK_CAT)) foreach($JAK_CAT as $c) { ?><option value="<?php echo $c["id"];?>"<?php if (isset($JAK_SETTING) && is_array($JAK_SETTING)) foreach($JAK_SETTING as $z) { if ($z["varname"] == 'rf_redirect' && $c["id"] == $z["value"]) { ?> selected="selected"<?php } } ?>><?php echo $c["name"];?></option><?php } ?>
	</select></td>
</tr>
<tr>
	<td><?php echo $lrf["register"]["r9"];?></td>
	<td><select name="jak_usergroup" class="form-control">
	<?php if (isset($JAK_USERGROUP_ALL) && is_array($JAK_USERGROUP_ALL)) foreach($JAK_USERGROUP_ALL as $v) { if ($v["id"] != '1') { ?><option value="<?php echo $v["id"];?>"<?php if (isset($JAK_SETTING) && is_array($JAK_SETTING)) foreach($JAK_SETTING as $z) { if ($z["varname"] == 'rf_usergroup' && $v["id"] == $z["value"]) { ?> selected="selected"<?php } } ?>><?php echo $v["name"];?></option><?php } } ?>
	</select></td>
</tr>
<tr>
	<td><?php echo $lrf["register"]["r5"];?></td>
	<td><?php include APP_PATH."admin/template/editorlight_edit.php";?></td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>

</div>
<div class="tab-pane" id="style_tabs-2">
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["general"]["g89"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
			<?php include APP_PATH.'admin/template/sidebar_widget.php';?>
		</div>
			<div class="box-footer">
			  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
			</div>
		</div>
</div>
</div>
</form>

<script type="text/javascript">
		$(document).ready(function()
		{	
			$('#cmsTab a').click(function (e) {
			  e.preventDefault();
			  $(this).tab('show');
			});
		});
</script>
		
<?php include_once APP_PATH.'admin/template/footer.php';?>