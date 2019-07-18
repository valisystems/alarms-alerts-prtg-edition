<?php include "header.php";?>

<?php if ($page2 == "e") { ?>
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
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["title"]["t13"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><?php echo $tl["hook"]["h"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e1"])) echo " has-error";?>">
		<input type="text" name="jak_name" class="form-control" value="<?php if (isset($_REQUEST["jak_showhook"])) echo $_REQUEST["jak_name"]; ?>" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["hook"]["h2"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e2"])) echo " has-error";?>">
	<select name="jak_hook" class="form-control">
	<option value="0"<?php if (isset($_REQUEST["jak_showhook"]) && $_REQUEST["jak_showhook"] == '0') { ?> selected="selected"<?php } ?>><?php echo $tl["hook"]["h6"];?></option>
	<?php if (isset($JAK_HOOK_LOCATIONS) && is_array($JAK_HOOK_LOCATIONS)) foreach($JAK_HOOK_LOCATIONS as $h) { ?><option value="<?php echo $h;?>"<?php if (isset($_REQUEST["jak_showhook"]) && $h == $_REQUEST["jak_hook"]) { ?> selected="selected"<?php } ?>><?php echo $h;?></option><?php } ?>
	</select>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["hook"]["h3"];?></td>
	<td><select name="jak_plugin" class="form-control">
	<option value="0"<?php if (isset($_REQUEST["jak_showhook"]) && $_REQUEST["jak_plugin"] == '0') { ?> selected="selected"<?php } ?>><?php echo $tl["cform"]["c18"];?></option>
	<?php if (isset($JAK_PLUGINS) && is_array($JAK_PLUGINS)) foreach($JAK_PLUGINS as $p) { ?><option value="<?php echo $p["id"];?>"<?php if (isset($_REQUEST["jak_showhook"]) && $p["id"] == $_REQUEST["jak_plugin"]) { ?> selected="selected"<?php } ?>><?php echo $p["name"];?></option><?php } ?>
	</select></td>
</tr>
<tr>
	<td><?php echo $tl["hook"]["h4"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e3"])) echo " has-error";?>">
	<input type="text" name="jak_exorder" class="form-control" value="<?php if (isset($_REQUEST["jak_exorder)"])) { echo $_REQUEST["jak_exorder"]; } else { ?>4<?php } ?>" maxlength="5" />
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
	    <h3 class="box-title"><?php echo $tl["hook"]["h5"];?></h3>
	  </div><!-- /.box-header -->
	  <div class="box-body">

	<div id="htmleditor"></div>
	<textarea name="jak_phpcode" id="jak_phpcode" class="form-control hidden"><?php if (isset($_REQUEST["jak_phpcode"])) echo $_REQUEST["jak_phpcode"]; ?></textarea>
	
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
</form>

<script src="js/ace/ace.js" type="text/javascript"></script>
<script type="text/javascript">

var htmlefACE = ace.edit("htmleditor");
htmlefACE.setTheme("ace/theme/chrome");
htmlefACE.session.setMode({path:"ace/mode/php", inline:true});
texthtmlef = $("#jak_phpcode").val();
htmlefACE.session.setValue(texthtmlef);

$('form').submit(function() {
	$("#jak_phpcode").val(htmlefACE.getValue());
});
</script>
		
<?php include "footer.php";?>