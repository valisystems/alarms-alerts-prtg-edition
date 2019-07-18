<?php include_once APP_PATH.'admin/template/header.php';?>

<?php if ($page2 == "e") { ?>
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
		  if (isset($errors["e3"])) echo $errors["e3"];?>
</div>
<?php } ?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">

<ul class="nav nav-tabs" id="cmsTab">
	<li class="active"><a href="#retArt1"><?php echo $tl["page"]["p4"];?></a></li>
	<li><a href="#retArt2"><?php echo $tl["general"]["g53"];?></a></li>
	<li><a href="#retArt3"><?php echo $tl["general"]["g100"];?></a></li>
	<li><a href="#retArt4"><?php echo $tl["general"]["g89"];?></a></li>
</ul>

<div class="tab-content">
<div class="tab-pane active" id="retArt1">
<div class="row">
<div class="col-md-6">
	<div class="box box-primary">
	  <div class="box-header with-border">
	    <h3 class="box-title"><?php echo $tl["title"]["t13"];?></h3>
	  </div><!-- /.box-header -->
	  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><?php echo $tlre["retailer"]["d8"];?></td>
	<td><?php include_once APP_PATH."admin/template/title_new.php";?></td>
</tr>
<tr>
	<td><?php echo $tl["page"]["p3"];?></td>
	<td><div class="radio"><label>
		<input type="radio" name="jak_showtitle" value="1"<?php if (isset($_REQUEST["jak_showtitle"]) && $_REQUEST["jak_showtitle"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label>
		<input type="radio" name="jak_showtitle" value="0"<?php if (isset($_REQUEST["jak_showtitle"]) && $_REQUEST["jak_showtitle"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
	</label></div></td>
</tr>
<?php if (isset($JAK_CONTACT_FORMS) && is_array($JAK_CONTACT_FORMS)) { ?>
<tr>
	<td><?php echo $tl["page"]["p7"];?></td>
	<td><select name="jak_showcontact" size="1" class="form-control">
	<option value="0"<?php if (isset($_REQUEST["jak_showcontact"]) && $_REQUEST["jak_showcontact"] == '0') { ?> selected="selected"<?php } ?>><?php echo $tl["cform"]["c18"];?></option>
	<?php foreach($JAK_CONTACT_FORMS as $cf) { ?><option value="<?php echo $cf["id"];?>"<?php if (isset($_REQUEST["jak_showcontact"]) && $cf["id"] == $_REQUEST["jak_showcontact"]) { ?> selected="selected"<?php } ?>><?php echo $cf["title"];?></option><?php } ?>
	</select></td>
</tr>
<?php } ?>
<tr>
	<td><?php echo $tl["page"]["p8"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_showdate" value="1"<?php if (isset($_REQUEST["jak_showdate"]) && $_REQUEST["jak_showdate"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_showdate" value="0"<?php if (isset($_REQUEST["jak_showdate"]) && $_REQUEST["jak_showdate"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlre["retailer"]["q25"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_showhits" value="1"<?php if (isset($_REQUEST["jak_showhits"]) && $_REQUEST["jak_showhits"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_showhits" value="0"<?php if (isset($_REQUEST["jak_showhits"]) && $_REQUEST["jak_showhits"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlre["retailer"]["d19"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_comment" value="1"<?php if (isset($_REQUEST["jak_comment"]) && $_REQUEST["jak_comment"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_comment" value="0"<?php if (isset($_REQUEST["jak_comment"]) && $_REQUEST["jak_comment"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tl["general"]["g85"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_vote" value="1"<?php if (isset($_REQUEST["jak_vote"]) && $_REQUEST["jak_vote"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_vote" value="0"<?php if (isset($_REQUEST["jak_vote"]) && $_REQUEST["jak_vote"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tl["page"]["p9"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_social" value="1"<?php if (isset($_REQUEST["jak_social"]) && $_REQUEST["jak_social"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_social" value="0"<?php if (isset($_REQUEST["jak_social"]) && $_REQUEST["jak_social"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tl["general"]["g124"];?></td>
	<td>
	<div class="radio"><label>
	<input type="radio" name="jak_sidebar" value="1"<?php if (isset($_REQUEST["jak_sidebar"]) && $_REQUEST["jak_sidebar"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g125"];?>
	</label></div>
	<div class="radio"><label>
	<input type="radio" name="jak_sidebar" value="0"<?php if (isset($_REQUEST["jak_sidebar"]) && $_REQUEST["jak_sidebar"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g126"];?>
	</label>
	</td>
</tr>
<tr>
	<td><?php echo $tl["general"]["g87"];?></td>
	<td>
	<div class="input-group">
		<input type="text" name="jak_img" id="jak_img" class="form-control" value="<?php if (isset($_REQUEST["jak_img"])) echo $_REQUEST["jak_img"];?>" />
		<span class="input-group-btn">
		  <a class="btn btn-info ifManager" type="button" href="../js/editor/plugins/filemanager/dialog.php?type=1&subfolder=&editor=mce_0&lang=eng&fldr=&field_id=jak_img"><?php echo $tl["general"]["g69"];?></a>
		</span>
	</div><!-- /input-group -->
	</td>
</tr>
<tr>
	<td><?php echo $tlre["retailer"]["d10"];?></td>
	<td>
	<div class="input-group">
		<input type="text" name="jak_imgs" id="jak_imgs" class="form-control" value="<?php if (isset($_REQUEST["jak_imgs"])) echo $_REQUEST["jak_imgs"]; ?>" />
		<span class="input-group-btn">
		  <a class="btn btn-info ifManager" type="button" href="../js/editor/plugins/filemanager/dialog.php?type=1&subfolder=&editor=mce_0&lang=eng&fldr=&field_id=jak_imgs"><?php echo $tl["general"]["g69"];?></a>
		</span>
	</div><!-- /input-group -->
	</td>
</tr>
<tr>
	<td><?php echo $tlre["retailer"]["d11"];?></td>
	<td>
	<div class="input-group">
		<input type="text" name="jak_imgb" id="jak_imgb" class="form-control" value="<?php if (isset($_REQUEST["jak_imgb"])) echo $_REQUEST["jak_imgb"]; ?>" />
		<span class="input-group-btn">
		  <a class="btn btn-info ifManager" type="button" href="../js/editor/plugins/filemanager/dialog.php?type=1&subfolder=&editor=mce_0&lang=eng&fldr=&field_id=jak_imgb"><?php echo $tl["general"]["g69"];?></a>
		</span>
	</div><!-- /input-group -->
	</td>
</tr>
<tr>
	<td><?php echo $tlre["retailer"]["d17"];?></td>
	<td><input class="form-control" type="text" name="jak_shortcontent" value="<?php if (isset($_REQUEST["jak_shortcontent"])) echo $_REQUEST["jak_shortcontent"];?>" maxlength="255" /></td>
</tr>
<tr>
	<td><?php echo $tlre["retailer"]["q"];?></td>
	<td><input type="text" class="form-control" name="jak_address" id="address" value="<?php if (isset($_REQUEST["jak_address"])) echo $_REQUEST["jak_address"];?>" /></td>
</tr>
<tr>
	<td><?php echo $tlre["retailer"]["q1"];?></td>
	<td><input type="text" class="form-control" name="jak_phone" value="<?php if (isset($_REQUEST["jak_phone"])) echo $_REQUEST["jak_phone"];?>" /></td>
</tr>
<tr>
	<td><?php echo $tlre["retailer"]["q2"];?></td>
	<td><input type="text" class="form-control" name="jak_fax" value="<?php if (isset($_REQUEST["jak_fax"])) echo $_REQUEST["jak_fax"];?>" /></td>
</tr>
<tr>
	<td><?php echo $tl["user"]["u1"];?></td>
	<td><input type="text" class="form-control" name="jak_email" value="<?php if (isset($_REQUEST["jak_email"])) echo $_REQUEST["jak_email"];?>" /></td>
</tr>
<tr>
	<td><?php echo $tlre["retailer"]["q9"];?></td>
	<td><input class="form-control" type="text" name="jak_weburl" value="<?php if (isset($_REQUEST["jak_weburl"])) echo $_REQUEST["jak_weburl"];?>" /></td>
</tr>
<tr>
	<td><?php echo $tlre["retailer"]["q3"];?></td>
	<td><input type="text" class="form-control" name="jak_longitude" id="longitude" value="<?php if (isset($_REQUEST["jak_longitude"])) echo $_REQUEST["jak_longitude"];?>" /></td>
</tr>
<tr>
	<td><?php echo $tlre["retailer"]["q4"];?></td>
	<td><input type="text" class="form-control" name="jak_latitude" id="latitude" value="<?php if (isset($_REQUEST["jak_latitude"])) echo $_REQUEST["jak_latitude"];?>" /></td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
</div>
<div class="col-md-6">
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["title"]["t12"];?> <a class="cms-help" data-content="<?php echo $tl["help"]["h"];?>" href="javascript:void(0)" data-original-title="<?php echo $tl["title"]["t21"];?>"><i class="fa fa-question-circle"></i></a></h3>
  </div><!-- /.box-header -->
  <div class="box-body">

<table class="table">
<tr>
	<td>
	
	<select name="jak_catid[]" multiple="multiple" class="form-control">
	
	<option value="0"<?php if (isset($_REQUEST["jak_catid"]) && $_REQUEST["jak_catid"] == '0') { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g24"];?></option>
	
	<?php if (isset($JAK_CAT) && is_array($JAK_CAT)) foreach($JAK_CAT as $v) { ?>
	
	<option value="<?php echo $v["id"];?>"<?php if ($v["id"] == $page2) { ?> selected="selected"<?php } ?>><?php echo $v["name"];?></option>
	
	<?php } ?>
	</select>
	
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
	    <h3 class="box-title"><?php echo $tlre["retailer"]["q5"];?></h3>
	  </div><!-- /.box-header -->
	  <div class="box-body">
		<div id="map_canvas"></div>
	</div>
		<div class="box-footer">
		  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
		</div>
</div>
<?php if (JAK_TAGS) { ?>
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["title"]["t31"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table">
<tr>
	<td><input type="text" name="jak_tags" id="jak_tags" class="tags" value="<?php if (isset($_REQUEST["jak_tags"])) echo $_REQUEST["jak_tags"];?>" /></td>
</tr>
</table>
</div>
		<div class="box-footer">
		  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
		</div>
</div>
<?php } ?>

</div>
</div>

<?php include_once APP_PATH."admin/template/editor_new.php";?>

</div>
<div class="tab-pane" id="retArt2">
	<div class="box box-primary">
	  <div class="box-header with-border">
	    <h3 class="box-title"><?php echo $tl["general"]["g53"];?></h3>
	  </div><!-- /.box-header -->
	  <div class="box-body">
	  	<a href="../js/editor/plugins/filemanager/dialog.php?type=2&editor=mce_0&lang=eng&fldr=&field_id=csseditor" class="ifManager"><?php echo $tl["general"]["g69"];?></a> <a href="javascript:;" id="addCssBlock"><?php echo $tl["general"]["g101"];?></a><br />
	  		<div id="csseditor"></div>
	  		<textarea name="jak_css" id="jak_css" class="hidden"><?php if (isset($_REQUEST["jak_css"])) echo $_REQUEST["jak_css"];?></textarea>
	</div>
		<div class="box-footer">
		  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
		</div>
	</div>
</div>
<div class="tab-pane" id="retArt3">
	<div class="box box-primary">
	  <div class="box-header with-border">
	    <h3 class="box-title"><?php echo $tl["general"]["g100"];?></h3>
	  </div><!-- /.box-header -->
	  <div class="box-body">
	  	<a href="../js/editor/plugins/filemanager/dialog.php?type=2&editor=mce_0&lang=eng&fldr=&field_id=javaeditor" class="ifManager"><?php echo $tl["general"]["g69"];?></a> <a href="javascript:;" id="addJavascriptBlock"><?php echo $tl["general"]["g102"];?></a><br />
	  	<div id="javaeditor"></div>
	  	<textarea name="jak_javascript" id="jak_javascript" class="hidden"><?php if (isset($_REQUEST["jak_javascript"])) echo $_REQUEST["jak_javascript"];?></textarea>
		</div>
		<div class="box-footer">
		  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
		</div>
	</div>	
</div>

<div class="tab-pane" id="retArt4">

	<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["general"]["g89"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
			<?php include APP_PATH.'admin/template/sidebar_widget_new.php';?>
		</div>
			<div class="box-footer">
			  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
			</div>
		</div>

</div>
</div>
</form>


<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="../plugins/retailer/js/jquery-ui-min.js"></script>
<script type="text/javascript" src="../plugins/retailer/js/googleapi.js"></script>
<script src="js/ace/ace.js" type="text/javascript"></script>
<script type="text/javascript">

<?php if ($jkv["adv_editor"]) { ?>
var htmlACE = ace.edit("htmleditor");
htmlACE.setTheme("ace/theme/chrome");
htmlACE.session.setMode("ace/mode/html");
texthtml = $("#jak_editor").val();
htmlACE.session.setValue(texthtml);
<?php } ?>

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
	    
	$('#jak_tags').tagsInput({
	   defaultText:'<?php echo $tl["general"]["g83"];?>',
	   taglimit: 10
	});
	$('#jak_tags_tag').alphanumeric({nocaps:true});
	
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
	
	$("#datepickerFrom, #datepickerTo").datetimepicker({format: 'yyyy-mm-dd hh:ii', autoclose: true, startDate: new Date()});
});

function responsive_filemanager_callback(field_id) {
	
	if (field_id == "csseditor" || field_id == "javaeditor" || field_id == "htmleditor") {
		
		// get the path for the ace file
		var acefile = jQuery('#'+field_id).val();
		
		if (field_id == "csseditor") {
			cssACE.insert('<link rel="stylesheet" href="'+acefile+'" type="text/css" />');
		} else if (field_id == "javaeditor") {
			jsACE.insert('<script src="'+acefile+'"><\/script>');
		} else {
			htmlACE.insert(acefile);
		}
	}
}

$('form').submit(function() {
	$("#jak_css").val(cssACE.getValue());
	$("#jak_javascript").val(jsACE.getValue());
	<?php if ($jkv["adv_editor"]) { ?>
	$("#jak_editor").val(htmlACE.getValue());
	<?php } ?>
});
</script>
		
<?php include_once APP_PATH.'admin/template/footer.php';?>