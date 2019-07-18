<?php include_once APP_PATH.'admin/template/header.php';?>

<?php if ($page2 == "s") { ?>
<div class="alert alert-success fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?php echo $tl["general"]["g7"];?>
</div>
<?php } if ($page2 == "e") { ?>
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
		  if (isset($errors["e4"])) echo $errors["e4"];
		  if (isset($errors["e5"])) echo $errors["e5"];
		  if (isset($errors["e6"])) echo $errors["e6"];?>
</div>
<?php } ?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<ul class="nav nav-tabs" id="cmsTab">
	<li class="active"><a href="#shopSett1"><?php echo $tl["menu"]["m2"];?></a></li>
	<li><a href="#shopSett2"><?php echo $tl["general"]["g89"];?></a></li>
</ul>

<div class="tab-content">
<div class="tab-pane active fade in" id="shopSett1">
	<div class="box box-primary">
	  <div class="box-header with-border">
	    <h3 class="box-title"><?php echo $tl["title"]["t4"];?></h3>
	  </div><!-- /.box-header -->
	  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><?php echo $tl["page"]["p"];?></td>
	<td>
	<?php include APP_PATH."admin/template/title_edit.php";?>
	</td>
</tr>
<tr>
	<td><?php echo $tl["page"]["p5"];?></td>
	<td>
	<?php include APP_PATH."admin/template/editorlight_edit.php";?>
	</td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m18"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e2"])) echo " has-error";?>">
		<input class="form-control" type="text" name="jak_email" value="<?php echo $jkv["shopemail"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m58"].' '.$tlec["shop"]["m37"];?></td>
	<td><input class="form-control" type="text" name="jak_address" value="<?php echo $jkv["e_shop_address"];?>" /></td>
</tr>
<tr>
	<td><?php echo $tl["setting"]["s4"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e3"])) echo " has-error";?>">
		<input type="text" name="jak_date" class="form-control" value="<?php echo $jkv["shopdateformat"];?>" />
	</div></td>
</tr>
<tr>
	<td><?php echo $tl["setting"]["s5"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e4"])) echo " has-error";?>">
	<input type="text" name="jak_time" class="form-control" value="<?php echo $jkv["shoptimeformat"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m17"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_shopurl" value="1"<?php if ($jkv["shopurl"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_shopurl" value="0"<?php if ($jkv["shopurl"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m69"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_itemopen" value="1"<?php if ($jkv["e_productopen"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_itemopen" value="0"<?php if ($jkv["e_productopen"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m97"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_checkout" value="1"<?php if ($jkv["shopcheckout"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tlec["shop"]["m98"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_checkout" value="2"<?php if ($jkv["shopcheckout"] == 2) { ?> checked="checked"<?php } ?> /> <?php echo $tlec["shop"]["m99"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_checkout" value="3"<?php if ($jkv["shopcheckout"] == 3) { ?> checked="checked"<?php } ?> /> <?php echo $tlec["shop"]["m100"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tl["general"]["g40"];?> / <?php echo $tl["general"]["g41"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e7"])) echo " has-error";?>">
		<input type="text" name="jak_rssitem" class="form-control" value="<?php echo $jkv["shoprss"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m53"];?></td>
	<td><select name="jak_wcatid" class="form-control">
	<option value="0"<?php if (!$jkv["e_agreement"]) { ?> selected="selected"<?php } ?>><?php echo $tl["title"]["t12"];?></option>
	<?php if (isset($JAK_CAT) && is_array($JAK_CAT)) foreach($JAK_CAT as $c) { if ($c["pluginid"] == '0' && $c["pageid"] > '0') { ?><option value="<?php echo $c["id"];?>"<?php if (isset($JAK_SETTING) && is_array($JAK_SETTING)) foreach($JAK_SETTING as $v) { if ($jkv["e_agreement"] == $c["id"]) { ?> selected="selected"<?php } } ?>><?php echo $c["name"];?></option><?php } } ?>
	</select></td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
	<div class="box box-primary">
	  <div class="box-header with-border">
	    <h3 class="box-title"><?php echo $tlec["shop"]["m8"];?></h3>
	  </div><!-- /.box-header -->
	  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><?php echo $tlec["shop"]["m20"];?></td>
	<td>
	<div class="input-group">
	  <input type="text" name="jak_taxes" class="form-control" value="<?php echo $jkv["e_taxes"];?>">
	  <span class="input-group-addon">&#37;</span>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m60"];?></td>
	<td><select name="jak_country" class="form-control">
	<option value="0"<?php if (!$jkv["e_country"]) { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g19"].' '.$tlec["shop"]["m51"];?></option>
	<?php echo $JAK_COUNTRY;?>
	</select></td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m11"];?></td>
	<td><input type="text" name="jak_currency" class="form-control" value="<?php echo $jkv["e_currency"];?>" /></td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m12"];?> <a class="cms-help" data-content="<?php echo $tlec["shop"]["m13"];?>" href="javascript:void(0)" data-original-title="<?php echo $tl["title"]["t21"];?>"><i class="fa fa-question-circle"></i></a></td>
	<td><input type="text" name="jak_currency1" class="form-control" value="<?php echo $jkv["e_currency1"];?>" /></td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m12"];?> <a class="cms-help" data-content="<?php echo $tlec["shop"]["m13"];?>" href="javascript:void(0)" data-original-title="<?php echo $tl["title"]["t21"];?>"><i class="fa fa-question-circle"></i></a></td>
	<td><input type="text" name="jak_currency2" class="form-control" value="<?php echo $jkv["e_currency2"];?>" /></td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
	<div class="box box-primary">
	  <div class="box-header with-border">
	    <h3 class="box-title"><?php echo $tlec["shop"]["m75"];?></h3>
	  </div><!-- /.box-header -->
	  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><?php echo $tlec["shop"]["m72"];?></td>
	<td><input class="form-control" type="text" name="jak_download" value="<?php echo $jkv["e_shop_download"];?>" /></td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m73"];?></td>
	<td><input class="form-control" type="text" name="jak_download_b" value="<?php echo $jkv["e_shop_download_b"];?>" /></td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m74"];?></td>
	<td><input class="form-control" type="text" name="jak_download_bt" value="<?php echo $jkv["e_shop_download_bt"];?>" /></td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
	<div class="box box-primary">
	  <div class="box-header with-border">
	    <h3 class="box-title"><?php echo $tlec["shop"]["m5"];?></h3>
	  </div><!-- /.box-header -->
	  <div class="box-body">
<table class="table table-striped">
<tr>
	<td>
		<?php if ($jkv["adv_editor"]) { ?>
		<p><a href="../js/editor/plugins/filemanager/dialog.php?type=0&editor=mce_0&lang=eng&fldr=&field_id=csseditor" class="btn btn-default btn-xs ifManager"><i class="fa fa-files-o"></i></a></p>
		<div id="csseditor"></div>
		<textarea name="jak_thankyou" class="form-control hidden" id="jak_editor_ty"><?php echo jak_edit_safe_userpost(htmlspecialchars($jkv["e_thanks"]));?></textarea>
		<?php } else { ?>
		<textarea name="jak_thankyou" class="jakEditorLight" rows="4"><?php echo jak_edit_safe_userpost($jkv["e_thanks"]);?></textarea>
		<?php } ?>
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
	    <h3 class="box-title"><?php echo $tl["title"]["t29"];?></h3>
	  </div><!-- /.box-header -->
	  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><?php echo $tl["setting"]["s11"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e5"])) echo " has-error";?>">
	<input type="text" name="jak_mid" class="form-control" value="<?php echo $jkv["shoppagemid"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["setting"]["s12"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e5"])) echo " has-error";?>">
	<input type="text" name="jak_item" class="form-control" value="<?php echo $jkv["shoppageitem"];?>" />
	</div>
	</td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
</div>
<div class="tab-pane" id="shopSett2">
	<div class="box box-primary">
	  <div class="box-header with-border">
	    <h3 class="box-title"><?php echo $tl["general"]["g89"];?></h3>
	  </div><!-- /.box-header -->
	  <div class="box-body">
			<?php include APP_PATH."admin/template/sidebar_widget.php";?>
	</div>
		<div class="box-footer">
		  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
		</div>
	</div>
</div>
</div>
</form>

<script type="text/javascript">
<?php if ($jkv["adv_editor"]) { ?>

var htmltyACE = ace.edit("csseditor");
htmltyACE.setTheme("ace/theme/chrome");
htmltyACE.session.setMode("ace/mode/html");
texthtmlty = $("#jak_editor_ty").val();
htmltyACE.session.setValue(texthtmlty);

function responsive_filemanager_callback(field_id) {
	
	if (field_id == "csseditor") {
		
		// get the path for the ace file
		var acefile = jQuery('#'+field_id).val();
		htmltyACE.insert(acefile);
	}
}

$('form').submit(function() {
	$("#jak_editor_ty").val(htmltyACE.getValue());
});
<?php } ?>
$(document).ready(function() {	
	$('#cmsTab a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
	});
});
</script>
		
<?php include_once APP_PATH.'admin/template/footer.php';?>