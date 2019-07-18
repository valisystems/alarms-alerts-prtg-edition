<?php include "header.php";?>

<?php if ($page2 == "s") { ?>
<div class="alert alert-success fade in">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <?php echo $tl["general"]["g7"];?>
</div>
<?php } if ($page2 == "e") { ?>
<div class="alert alert-danger fade in">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <?php echo $tl["errorpage"]["sql"];?>
</div>
<?php } ?>

<?php if ($errors) { ?>
<div class="alert alert-danger fade in">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<?php if (isset($errors["e"])) echo $errors["e"];
		  if (isset($errors["e1"])) echo $errors["e1"];
		  if (isset($errors["e2"])) echo $errors["e2"];
		  if (isset($errors["e3"])) echo $errors["e3"];?>
</div>
<?php } ?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">

<ul class="nav nav-tabs" id="cmsTab">
	<li class="active"><a href="#style_tabs-1"><?php echo $tl["page"]["p4"];?></a></li>
	<li><a href="#style_tabs-2"><?php echo $tl["general"]["g53"];?></a></li>
	<li><a href="#style_tabs-3"><?php echo $tl["general"]["g100"];?></a></li>
	<li><a href="#style_tabs-4"><?php echo $tl["general"]["g121"];?></a></li>
</ul>

<div class="tab-content">
<div class="tab-pane active" id="style_tabs-1">
<div class="row">
	<div class="col-md-8">
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["title"]["t4"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><?php echo $tl["page"]["p"];?></td>
	<td>
	<?php include_once "title_edit.php";?>
	</td>
</tr>
<tr>
	<td><?php echo $tl["page"]["p5"];?></td>
	<td><?php include_once "editorlight_edit.php";?></td>
</tr>
<tr>
	<td><?php echo $tl["setting"]["s4"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e1"])) echo " has-error";?>">
		<input class="form-control" type="text" name="jak_date" value="<?php echo $jkv["newsdateformat"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["setting"]["s5"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e3"])) echo " has-error";?>">
		<input class="form-control" type="text" name="jak_time" value="<?php echo $jkv["newstimeformat"];?>" />
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
<div class="col-md-4">
	<div class="box box-primary">
	  <div class="box-header with-border">
	    <h3 class="box-title"><?php echo $tl["title"]["t29"];?></h3>
	  </div><!-- /.box-header -->
	  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><?php echo $tl["setting"]["s11"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e2"])) echo " has-error";?>">
		<input class="form-control" type="text" name="jak_mid" value="<?php echo $jkv["newspagemid"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["setting"]["s12"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e3"])) echo " has-error";?>">
		<input class="form-control" type="text" name="jak_item" value="<?php echo $jkv["newspageitem"];?>" />
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
</div>

</div>
<div class="tab-pane" id="style_tabs-2">
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["general"]["g53"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
	<a href="../js/editor/plugins/filemanager/dialog.php?type=2&editor=mce_0&lang=eng&fldr=&field_id=csseditor" class="ifManager"><?php echo $tl["general"]["g69"];?></a> <a href="javascript:;" id="addCssBlock"><?php echo $tl["general"]["g101"];?></a><br />
	<div id="csseditor"></div>
		<textarea name="jak_css" class="form-control hidden" id="jak_css" rows="20"><?php echo $jkv["news_css"];?></textarea>
	</div>
		<div class="box-footer">
		  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
		</div>
	</div>
</div>
<div class="tab-pane" id="style_tabs-3">
<div class="box box-primary">
<div class="box-header with-border">
  <h3 class="box-title"><?php echo $tl["general"]["g100"];?></h3>
</div><!-- /.box-header -->
<div class="box-body">
	<a href="../js/editor/plugins/filemanager/dialog.php?type=2&editor=mce_0&lang=eng&fldr=&field_id=javaeditor" class="ifManager"><?php echo $tl["general"]["g69"];?></a> <a href="javascript:;" id="addJavascriptBlock"><?php echo $tl["general"]["g102"];?></a><br />
	<div id="javaeditor"></div>
		<textarea name="jak_javascript" class="form-control hidden" id="jak_javascript" rows="20"><?php echo $jkv["news_javascript"];?></textarea>
	</div>
		<div class="box-footer">
		  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
		</div>
	</div>
</div>
<div class="tab-pane" id="style_tabs-4">
<div class="box box-primary">
<div class="box-header with-border">
  <h3 class="box-title"><?php echo $tl["general"]["g89"];?></h3>
</div><!-- /.box-header -->
<div class="box-body">
	<?php include "sidebar_widget.php";?>
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
		
<?php include "footer.php";?>