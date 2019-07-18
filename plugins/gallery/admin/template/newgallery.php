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
		  if (isset($errors["e3"])) echo $errors["e3"];?>
</div>
<?php } if ($JAK_CAT) { ?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["title"]["t12"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table">
<tr>
	<td><select name="jak_catid" class="form-control">
	<?php if (isset($JAK_CAT) && is_array($JAK_CAT)) foreach($JAK_CAT as $v) { ?><option value="<?php echo $v["id"];?>"<?php if ($v["id"] == $page2) { ?> selected="selected"<?php } ?>><?php echo $v["name"];?></option><?php } ?>
	</select></td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="catsave" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
</form>

<?php if ($page2) { ?>

<form method="post" class="dropzone" id="GalleryDropzone" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data">
<?php if ($errors) { ?>
	<div class="validation-failure">
		<?php if (isset($errors["e"])) echo $errors["e"];?>
	</div>
<?php } ?>
<div class="fallback">
	<input type="file" name="photoupload[]" accept="image/*" multiple />


<div class="form-actions">
<button type="submit" name="oldfashion" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
</div>
</div>
<input type="hidden" value="<?php echo $page2;?>" name="jak_catid_new" />

</form>

<?php } } else { ?>
<div class="alert alert-info">
<?php echo $tl["cmdesc"]["d8"];?>
</div>
<?php } ?>



<script type="text/javascript">
		$('head').append('<link rel="stylesheet" href="..\/plugins\/gallery\/css\/dropzone.css">');
</script>

<script type="text/javascript" src="../plugins/gallery/js/dropzone.js"></script>

<script type="text/javascript">
    $(document).ready(function(){

    	<?php if ($page2) { ?>
    		
    		//dropzone config
    		Dropzone.options.GalleryDropzone = {
    		    dictResponseError: "SERVER ERROR",
    		    paramName: "Filedata", // The name that will be used to transfer the file
    		    acceptedFiles: "image/*",
    		    url: "../plugins/gallery/uploader.php"
    		    
    		};
    	
    	<?php } ?>
    	
    });
</script>

<?php include_once APP_PATH.'admin/template/footer.php';?>