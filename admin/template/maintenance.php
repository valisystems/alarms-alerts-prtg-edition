<?php include_once APP_PATH.'admin/template/header.php';?>

<?php if ($success) { ?>
<div class="alert alert-success fade in">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <?php if (isset($success["s"])) echo $success["s"];?>
</div>
<?php } if ($errors) { ?>
<div class="alert alert-danger fade in">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <?php if (isset($errors["e"])) echo $errors["e"];?>
</div>
<?php } ?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data">
<div class="box">
<div class="box-body no-padding">
<table class="table table-striped">
<thead>
<tr>
<th class="content-title" colspan="2"><?php echo $tl["general"]["g106"];?></th>
</tr>
</thead>
<tr>
	<td><?php echo $tl["general"]["g112"];?></td>
	<td><button type="submit" name="optimize" class="btn btn-success"><?php echo $tl["general"]["g112"];?></button></td>
</tr>
<tr>
	<td><?php echo $tl["general"]["g107"];?></td>
	<td><button type="submit" name="download" class="btn btn-info"><?php echo $tl["general"]["g109"];?></button></td>
</tr>
<tr>
	<td><?php echo $tl["general"]["g108"];?></td>
	<td>
	<div class="fileinput fileinput-new" data-provides="fileinput">
	  <span class="btn btn-default btn-file"><span class="fileinput-new"><?php echo $tl["general"]["g133"];?></span><span class="fileinput-exists"><?php echo $tl["general"]["g131"];?></span><input type="file" name="uploaddb" accept=".xml"></span>
	  <span class="fileinput-filename"></span>
	  <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
	</div>
	<button type="submit" name="import" class="btn btn-warning" onclick="if(!confirm('<?php echo $tl["error"]["e35"];?>'))return false;"><?php echo $tl["general"]["g110"];?></button>
	
	</td>
</tr>
</table>
</div>
</div>

<div class="box box-success">
  	<div class="box-header with-border">
  		<i class="fa fa-server"></i>
    	<h3 class="box-title"><?php echo $tl["general"]["g136"];?></h3>
  	</div><!-- /.box-header -->
  	<div class="box-body">
	<p><?php echo sprintf($tl["general"]["gv"], $jkv["version"]);?></p>
	<?php include_once('include/cms_update.php');?>
	</div>
</div>

</form>

<script type="text/javascript">
	jakCMS.main_url = "<?php echo BASE_URL;?>";
	jakCMS.main_lang = "<?php echo $jkv["lang"];?>";
	jakCMS.jakrequest_uri = "<?php echo JAK_PARSE_REQUEST;?>";
</script>

<?php include_once APP_PATH.'admin/template/footer.php';?>