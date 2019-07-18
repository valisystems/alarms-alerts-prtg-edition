<?php include_once APP_PATH.'admin/template/header.php';?>

<ul class="breadcrumb">
  <li><a href="index.php?p=gallery"><?php echo $tlgal["gallery"]["m"];?></a></li>
  <li class="active"><?php echo $tlgal["gallery"]["m3"];?></li>
</ul>

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

<div class="page-header">
	<div class="btn-group pull-right">
		<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $tl["menu"]["m15"];?>
		    <span class="caret"></span>
		</a>
	  <ul class="dropdown-menu">
	    <li><a href="index.php?p=gallery"><?php echo $tlgal["gallery"]["m1"];?></a></li>
	    <li><a href="index.php?p=gallery&amp;sp=new"><?php echo $tlgal["gallery"]["m2"];?></a></li>
	    <li><a href="index.php?p=gallery&amp;sp=edit&amp;ssp=<?php echo $page2;?>"><?php echo $tlgal["gallery"]["m3"];?></a></li>
	  </ul>
	</div>
  <h1><?php echo $tlgal["gallery"]["m3"];?></h1>
</div>

<?php if ($errors) { ?>
<div class="alert alert-danger fade in">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<?php if (isset($errors["e"])) echo $errors["e"];
		  if (isset($errors["e1"])) echo $errors["e1"];
		  if (isset($errors["e2"])) echo $errors["e2"];?>
</div>
<?php } ?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["title"]["t12"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table">
<tr>
	<td><?php echo $tl["page"]["p1"];?></td>
	<td>
	
	<select name="jak_catid" class="form-control">
	
	<option value="0"<?php if ($JAK_FORM_DATA["catid"] == 0) { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g24"];?></option>
	<?php if (isset($JAK_CAT) && is_array($JAK_CAT)) foreach($JAK_CAT as $z) { ?>
	
	<option value="<?php echo $z["id"];?>"<?php if ($z["id"] == $JAK_FORM_DATA["catid"]) { ?> selected="selected"<?php } ?>><?php echo $z["name"];?></option>
	
	<?php } ?>
	</select>
	
	</td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="catsave" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>

<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["title"]["t13"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table">
<tr>
	<td><?php echo $tlgal["gallery"]["d8"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e1"])) echo " has-error";?>">
		<input class="form-control" type="text" name="jak_title" value="<?php echo $JAK_FORM_DATA["title"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["general"]["g86"];?></td>
	<td><input type="checkbox" name="jak_delete_rate" /></td>
</tr>
<tr>
	<td><?php echo $tlgal["gallery"]["d26"];?></td>
	<td><input type="checkbox" name="jak_delete_comment" /></td>
</tr>
<tr>
	<td><?php echo $tl["general"]["g73"].' '.$tl["general"]["g56"];?></td>
	<td><input type="checkbox" name="jak_delete_hits" /></td>
</tr>
<tr>
	<td><?php echo $tl["general"]["g42"];?></td>
	<td><input type="checkbox" name="jak_update_time" /></td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="catsave" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>

<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tlgal["gallery"]["d29"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table">
<tr>
	<td><img src="<?php echo BASE_URL_ORIG.$JAK_UPLOAD_PATH_BASE.$JAK_FORM_DATA["pathbig"];?>" alt="<?php echo $JAK_FORM_DATA["title"];?>" /></td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="catsave" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>

<?php include_once APP_PATH."admin/template/editor_edit.php";?>

<input type="hidden" name="jak_oldcatid" value="<?php echo $JAK_FORM_DATA["catid"];?>" />
</form>

<?php if ($jkv["adv_editor"]) { ?>
<script src="js/ace/ace.js" type="text/javascript"></script>
<?php } ?>
<script type="text/javascript">

<?php if ($jkv["adv_editor"]) { ?>
var htmlACE = ace.edit("htmleditor");
htmlACE.setTheme("ace/theme/chrome");
htmlACE.session.setMode("ace/mode/html");
texthtml = $("#jak_editor").val();
htmlACE.session.setValue(texthtml);
<?php } ?>

$(document).ready(function() {
	$('#jak_tags').tagsInput({
	   defaultText:'<?php echo $tl["general"]["g83"];?>',
	   taglimit: 10
	});
	$('#jak_tags_tag').alphanumeric({nocaps:true});
});

<?php if ($jkv["adv_editor"]) { ?>
function responsive_filemanager_callback(field_id) {
	
	if (field_id == "htmleditor") {
		// get the path for the ace file
		var acefile = jQuery('#'+field_id).val();
		htmlACE.insert(acefile);
	}
}

$('form').submit(function() {
	$("#jak_editor").val(htmlACE.getValue());
});
<?php } ?>
</script>
		
<?php include_once APP_PATH.'admin/template/footer.php';?>