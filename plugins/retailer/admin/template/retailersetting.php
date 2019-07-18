<?php include_once APP_PATH.'admin/template/header.php';?>

<?php if ($page2 == "s") { ?>
<div class="alert alert-success fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?php echo $tl["general"]["g7"];?>
</div>
<?php } if ($page2 == "e") { ?>
<div class="alert alert-error fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?php echo $tl["errorpage"]["sql"];?>
</div>
<?php } ?>

<?php if ($errors) { ?>
<div class="alert alert-error fade in">
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
	<li class="active"><a href="#retSett1"><?php echo $tl["menu"]["m2"];?></a></li>
	<li><a href="#retSett2"><?php echo $tl["general"]["g53"];?></a></li>
	<li><a href="#retSett3"><?php echo $tl["general"]["g100"];?></a></li>
	<li><a href="#retSett4"><?php echo $tl["general"]["g89"];?></a></li>
</ul>

<div class="tab-content">
<div class="tab-pane active" id="retSett1">

<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["title"]["t4"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">

<table class="table table-striped">
<tr>
	<td><?php echo $tl["page"]["p"];?></td>
	<td><?php include_once APP_PATH."admin/template/title_edit.php";?></td>
</tr>
<tr>
	<td><?php echo $tl["page"]["p5"];?></td>
	<td><?php include_once APP_PATH."admin/template/editorlight_edit.php";?></td>
</tr>
<tr>
	<td><?php echo $tlre["retailer"]["d16"];?></td>
	<td>
	<div class="form-group<?php if ($errors["e2"]) echo " error";?>">
		<input class="form-control" type="text" name="jak_email" value="<?php echo $jkv["retaileremail"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tlre["retailer"]["d15"];?></td>
	<td>
	<div class="row">
	<div class="col-md-6">
	<select name="jak_showretailerordern" class="form-control">
	<option value="id"<?php if ($JAK_SETTING['showretailerwhat'] == "id") { ?> selected="selected"<?php } else { ?> selected="selected"<?php } ?>><?php echo $tlre["retailer"]["d22"];?></option>
	<option value="title"<?php if ($JAK_SETTING['showretailerwhat'] == "title") { ?> selected="selected"<?php } ?>><?php echo $tlre["retailer"]["d8"];?></option>
	<option value="time"<?php if ($JAK_SETTING['showretailerwhat'] == "time") { ?> selected="selected"<?php } ?>><?php echo $tlre["retailer"]["d24"];?></option>
	<option value="hits"<?php if ($JAK_SETTING['showretailerwhat'] == "hits") { ?> selected="selected"<?php } ?>><?php echo $tlre["retailer"]["d25"];?></option>
	</select>
	</div>
	<div class="col-md-6">
	<select name="jak_showretailerorder" class="form-control">
	<option value="ASC"<?php if ($JAK_SETTING['showretailerorder'] == "ASC") { ?> selected="selected"<?php } else { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g90"];?></option>
	<option value="DESC"<?php if ($JAK_SETTING['showretailerorder'] == "DESC") { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g91"];?></option>
	</select>
	</div>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tlre["retailer"]["d14"];?></td>
	<td><input type="text" class="form-control" name="jak_maxpost" value="<?php echo $jkv["retailermaxpost"];?>" /></td>
</tr>
<tr>
	<td><?php echo $tl["setting"]["s4"];?></td>
	<td>
	<div class="form-group<?php if ($errors["e3"]) echo " error";?>">
		<input type="text" class="form-control" name="jak_date" value="<?php echo $jkv["retailerdateformat"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["setting"]["s5"];?></td>
	<td>
	<div class="form-group<?php if ($errors["e4"]) echo " error";?>">
		<input type="text" class="form-control" name="jak_time" value="<?php echo $jkv["retailertimeformat"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tlre["retailer"]["d7"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_retailerurl" value="1"<?php if ($jkv["retailerurl"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_retailerurl" value="0"<?php if ($jkv["retailerurl"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tl["general"]["g40"];?> / <?php echo $tl["general"]["g41"];?></td>
	<td>
	<div class="form-group<?php if ($errors["e7"]) echo " error";?>">
		<input type="text" name="jak_rssitem" class="form-control" value="<?php echo $jkv["retailerrss"];?>" />
	</div>
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
	    <h3 class="box-title"><?php echo $tlre["retailer"]["q6"];?></h3>
	  </div><!-- /.box-header -->
	  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><?php echo $tlre["retailer"]["d29"];?></td>
	<td>
	<div class="form-group">
		<input type="text" name="jak_apikey" class="form-control" value="<?php echo $jkv["retailermapkey"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tlre["retailer"]["q10"];?></td>
	<td>
	
	<select name="jak_maptype" class="form-control">
	
		<option value="ROADMAP"<?php if ($jkv["retailermapstyle"] == 'ROADMAP') { echo ' selected="selected"'; } ?>>RoadMap</option>
		
		<option value="SATELLITE"<?php if ($jkv["retailermapstyle"] == 'SATELLITE') { echo ' selected="selected"'; } ?>>Satellite</option>
		
		<option value="HYBRID"<?php if ($jkv["retailermapstyle"] == 'HYBRID') { echo ' selected="selected"'; } ?>>Hybrid</option>
		
		<option value="TERRAIN"<?php if ($jkv["retailermapstyle"] == 'TERRAIN') { echo ' selected="selected"'; } ?>>Terrain</option>
	
	</select>
	
	</td>
</tr>
<tr>
	<td><?php echo $tlre["retailer"]["q7"];?></td>
	<td>
	
	<select name="jak_zoom" class="form-control">
	
	<?php for($i = 1; $i < 22; $i++) { ?>
	
		<option value="<?php echo $i;?>"<?php if ($jkv["retailerzoom"] == $i) echo ' selected="selected"';?>><?php echo $i;?></option>
	
	<?php } ?>
	
	</select>
	
	</td>
</tr>
<tr>
	<td><?php echo $tlre["retailer"]["q4"];?></td>
	<td><input class="form-control" type="text" name="jak_latitude" value="<?php echo $jkv["retailerlat"];?>" /></td>
</tr>
<tr>
	<td><?php echo $tlre["retailer"]["q3"];?></td>
	<td><input class="form-control" type="text" name="jak_longitude" value="<?php echo $jkv["retailerlng"];?>" /></td>
</tr>
<tr>
	<td><?php echo $tlre["retailer"]["q11"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_retailershowmap" value="1"<?php if ($jkv["retailershowmap"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_retailershowmap" value="0"<?php if ($jkv["retailershowmap"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlre["retailer"]["q12"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_retailerloc" value="1"<?php if ($jkv["retailerlocation"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_retailerloc" value="0"<?php if ($jkv["retailerlocation"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
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
<table class="table table-responsive">
<tr>
	<td><?php echo $tl["setting"]["s11"];?></td>
	<td><div class="form-group<?php if ($errors["e5"]) echo " error";?>"><input type="text" class="form-control" name="jak_mid" value="<?php echo $jkv["retailerpagemid"];?>" /></div></td>
</tr>
<tr>
	<td><?php echo $tl["setting"]["s12"];?></td>
	<td><div class="form-group<?php if ($errors["e5"]) echo " error";?>"><input type="text" class="form-control" name="jak_item" value="<?php echo $jkv["retailerpageitem"];?>" /></div></td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
</div>

<div class="tab-pane" id="retSett2">
	<div class="box box-primary">
	  <div class="box-header with-border">
	    <h3 class="box-title"><?php echo $tl["general"]["g53"];?></h3>
	  </div><!-- /.box-header -->
	  <div class="box-body">
	  <a href="../../../../js/editor/plugins/filemanager/dialog.php?type=2&editor=mce_0&lang=eng&fldr=&field_id=csseditor" class="ifManager"><?php echo $tl["general"]["g69"];?></a> <a href="javascript:;" id="addCssBlock"><?php echo $tl["general"]["g101"];?></a><br />
	  <div id="csseditor"></div>
		<textarea name="jak_css" class="form-control hidden" id="jak_css" rows="20"><?php echo $jkv["retailer_css"];?></textarea>
	</div>
		<div class="box-footer">
		  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
		</div>
	</div>
</div>

<div class="tab-pane" id="retSett3">
	<div class="box box-primary">
	<div class="box-header with-border">
	  <h3 class="box-title"><?php echo $tl["general"]["g100"];?></h3>
	</div><!-- /.box-header -->
	<div class="box-body">
	<a href="../../../../js/editor/plugins/filemanager/dialog.php?type=2&editor=mce_0&lang=eng&fldr=&field_id=javaeditor" class="ifManager"><?php echo $tl["general"]["g69"];?></a> <a href="javascript:;" id="addJavascriptBlock"><?php echo $tl["general"]["g102"];?></a><br />
	<div id="javaeditor"></div>
		<textarea name="jak_javascript" class="form-control hidden" id="jak_javascript" rows="20"><?php echo $jkv["retailer_javascript"];?></textarea>
	</div>
		<div class="box-footer">
		  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
		</div>
	</div>
</div>

<div class="tab-pane" id="retSett4">
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

<script src="js/ace/ace.js" type="text/javascript"></script>
<script type="text/javascript">

var jsACE = ace.edit("javaeditor");
jsACE.setTheme("ace/theme/chrome");
jsACE.session.setMode("ace/mode/html");
textjs = $("#jak_javascript").val();
jsACE.session.setValue(textjs);

var cssACE = ace.edit("csseditor");
cssACE.setTheme("ace/theme/chrome");
cssACE.session.setMode("ace/mode/html");
textcss = $("#jak_css").val();
cssACE.session.setValue(textcss);

$(document).ready(function() {
	
	$('#cmsTab a').click(function (e) {
	  e.preventDefault();
	  $(this).tab('show');
	});
	
	$("#addCssBlock").click(function() {
		
		cssACE.insert(insert_cssblock());
	
	});
	$("#addJavascriptBlock").click(function() {
		
		jsACE.insert(insert_javascript());
	
	});
});

function responsive_filemanager_callback(field_id) {
	
	if (field_id == "csseditor" || field_id == "javaeditor") {
		
		// get the path for the ace file
		var acefile = jQuery('#'+field_id).val();
		
		if (field_id == "csseditor") {
			cssACE.insert('<link rel="stylesheet" href="'+acefile+'" type="text/css" />');
		} else if (field_id == "javaeditor") {
			jsACE.insert('<script src="'+acefile+'"><\/script>');
		}
	}
}

$('form').submit(function() {
	$("#jak_css").val(cssACE.getValue());
	$("#jak_javascript").val(jsACE.getValue());
});
</script>
		
<?php include_once APP_PATH.'admin/template/footer.php';?>