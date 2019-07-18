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
	<?php echo $errors["e1"].$errors["e2"].$errors["e3"].$errors["e4"].$errors["e5"].$errors["e6"].$errors["e7"].$errors["e8"];?>
</div>
<?php } ?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">

<ul class="nav nav-tabs" id="cmsTab">
	<li class="active"><a href="#gallSett1"><?php echo $tl["menu"]["m2"];?></a></li>
	<li><a href="#gallSett2"><?php echo $tl["general"]["g89"];?></a></li>
</ul>

<div class="tab-content">
<div class="tab-pane active" id="gallSett1">

<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["title"]["t4"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
  
<table class="table table-striped">
<tr>
	<td><?php echo $tl["page"]["p"];?></td>
	<td>
	<?php include_once APP_PATH."admin/template/title_edit.php";?>
	</td>
</tr>
<tr>
	<td><?php echo $tl["page"]["p5"];?></td>
	<td>
	<?php include_once APP_PATH."admin/template/editorlight_edit.php";?>
	</td>
</tr>
<tr>
	<td><?php echo $tlgal["gallery"]["d16"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e2"])) echo " has-error";?>">
		<input class="form-control" type="text" name="jak_email" value="<?php echo $jkv["galleryemail"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tlgal["gallery"]["d15"];?></td>
	<td>
	<div class="row">
	<div class="col-md-6">
	<select name="jak_showgalleryordern" class="form-control">
	<option value="id"<?php if ($showgallerywhat == "id") { ?> selected="selected"<?php } else { ?> selected="selected"<?php } ?>><?php echo $tlgal["gallery"]["d22"];?></option>
	<option value="title"<?php if ($showgallerywhat == "title") { ?> selected="selected"<?php } ?>><?php echo $tlgal["gallery"]["d8"];?></option>
	<option value="time"<?php if ($showgallerywhat == "time") { ?> selected="selected"<?php } ?>><?php echo $tlgal["gallery"]["d24"];?></option>
	<option value="hits"<?php if ($showgallerywhat == "hits") { ?> selected="selected"<?php } ?>><?php echo $tlgal["gallery"]["d25"];?></option>
	</select>
	</div>
	<div class="col-md-6">
	<select name="jak_showgalleryorder" class="form-control">
	<option value="ASC"<?php if ($showgalleryorder == "ASC") { ?> selected="selected"<?php } else { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g90"];?></option>
	<option value="DESC"<?php if ($showgalleryorder == "DESC") { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g91"];?></option>
	</select>
	</div>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["general"]["g58"];?></td>
	<td>
	
	<select name="jak_gallerylimit" class="form-control">
	
	<?php for ($i = 0; $i <= 50; $i++) { ?>
	<option value="<?php echo $i;?>"<?php if (isset($JAK_SETTING) && is_array($JAK_SETTING)) foreach($JAK_SETTING as $v) { if ($jkv["galleryhlimit"] == $i) { ?> selected="selected"<?php } } ?>><?php echo $i; ?></option>
	<?php } ?>
	
	</select>
	
	</td>
</tr>
<tr>
	<td><?php echo $tlgal["gallery"]["d30"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_lightbox" value="1"<?php if (isset($JAK_SETTING) && is_array($JAK_SETTING)) foreach($JAK_SETTING as $v) { if ($jkv["galleryopenattached"] == '1') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_lightbox" value="0"<?php if (isset($JAK_SETTING) && is_array($JAK_SETTING)) foreach($JAK_SETTING as $v) { if ($jkv["galleryopenattached"] == '0') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tlgal["gallery"]["d14"];?></td>
	<td><input type="text" name="jak_maxpost" class="form-control" value="<?php if (isset($JAK_SETTING) && is_array($JAK_SETTING)) foreach($JAK_SETTING as $v) { if ($v["varname"] == 'gallerymaxpost') { echo $v["value"]; } } ?>" /></td>
</tr>
<tr>
	<td><?php echo $tl["setting"]["s4"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e3"])) echo " has-error";?>">
		<input type="text" name="jak_date" class="form-control" value="<?php echo $jkv["gallerydateformat"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["setting"]["s5"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e4"])) echo " has-error";?>">
		<input type="text" name="jak_time" class="form-control" value="<?php echo $jkv["gallerytimeformat"];?>" /></td>
</tr>
<tr>
	<td><?php echo $tlgal["gallery"]["d7"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_galleryurl" value="1"<?php if (isset($JAK_SETTING) && is_array($JAK_SETTING)) foreach($JAK_SETTING as $v) { if ($v["varname"] == 'galleryurl' && $v["value"] == '1') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_galleryurl" value="0"<?php if (isset($JAK_SETTING) && is_array($JAK_SETTING)) foreach($JAK_SETTING as $v) { if ($v["varname"] == 'galleryurl' && $v["value"] == '0') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
<tr>
	<td><?php echo $tl["general"]["g40"];?> / <?php echo $tl["general"]["g41"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e7"])) echo " has-error";?>">
	<input type="text" name="jak_rssitem" class="form-control" value="<?php echo $jkv["galleryrss"];?>" />
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
	    <h3 class="box-title"><?php echo $tlgal["gallery"]["d13"];?></h3>
	  </div><!-- /.box-header -->
	  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><?php echo $tlgal["gallery"]["s9"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e4"])) echo " has-error";?>">
		<input type="text" name="jak_imagebyte" class="form-control" value="<?php echo $jkv["galleryimgsize"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tlgal["gallery"]["s1"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e5"])) echo " has-error";?>">
		<input type="text" name="jak_imagetw" class="form-control" value="<?php echo $jkv["gallerythumbw"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tlgal["gallery"]["s2"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e5"])) echo " has-error";?>">
		<input type="text" name="jak_imageth" class="form-control" value="<?php echo $jkv["gallerythumbh"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tlgal["gallery"]["s3"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e7"])) echo " has-error";?>">
		<input type="text" name="jak_imagew" class="form-control" value="<?php echo $jkv["galleryw"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tlgal["gallery"]["s4"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e8"])) echo " has-error";?>">
		<input type="text" name="jak_imageh" class="form-control" value="<?php echo $jkv["galleryh"]?>" />
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
	    <h3 class="box-title"><?php echo $tlgal["gallery"]["s5"];?></h3>
	  </div><!-- /.box-header -->
	  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><?php echo $tlgal["gallery"]["s6"];?></td>
	<td><?php if (isset($JAK_SETTING) && is_array($JAK_SETTING)) foreach($JAK_SETTING as $v) { if ($v["varname"] == 'galleryimgquality') { ?>
	<select name="jak_quality" class="form-control">
	<option value="50"<?php if ($v["value"] == '50') { ?> selected="selected"<?php } ?>>50</option>
	<option value="55"<?php if ($v["value"] == '55') { ?> selected="selected"<?php } ?>>55</option>
	<option value="60"<?php if ($v["value"] == '60') { ?> selected="selected"<?php } ?>>60</option>
	<option value="65"<?php if ($v["value"] == '65') { ?> selected="selected"<?php } ?>>65</option>
	<option value="70"<?php if ($v["value"] == '70') { ?> selected="selected"<?php } ?>>70</option>
	<option value="75"<?php if ($v["value"] == '75') { ?> selected="selected"<?php } ?>>75</option>
	<option value="80"<?php if ($v["value"] == '80') { ?> selected="selected"<?php } ?>>80</option>
	<option value="85"<?php if ($v["value"] == '85') { ?> selected="selected"<?php } ?>>85</option>
	<option value="90"<?php if ($v["value"] == '90') { ?> selected="selected"<?php } ?>>90</option>
	<option value="95"<?php if ($v["value"] == '95') { ?> selected="selected"<?php } ?>>95</option>
	<option value="100"<?php if ($v["value"] == '100') { ?> selected="selected"<?php } ?>>100</option>
	</select><?php } } ?></td>
</tr>
<tr>
	<td><?php echo $tlgal["gallery"]["s7"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e9"])) echo " has-error";?>">
		<input type="text" name="jak_watermark" class="form-control" value="<?php echo $jkv["gallerywatermark"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tlgal["gallery"]["s8"];?></td>
	<td><?php if (isset($JAK_SETTING) && is_array($JAK_SETTING)) foreach($JAK_SETTING as $v) { if ($v["varname"] == 'gallerywmposition') { ?><table style="background: #f5f5f5 url('../plugins/gallery/img/watermark.jpg') no-repeat left center;width:400px;height:174px;text-align: center;">
<tr>
	<td><input type="radio" value="1" name="jak_position"<?php if ($v["value"] == '1') { ?> checked="checked"<?php } ?> /></td>
	<td><input type="radio" value="2" name="jak_position"<?php if ($v["value"] == '2') { ?> checked="checked"<?php } ?> /></td>
	<td><input type="radio" value="3" name="jak_position"<?php if ($v["value"] == '3') { ?> checked="checked"<?php } ?> /></td>
</tr>
<tr>
	<td><input type="radio" value="4" name="jak_position"<?php if ($v["value"] == '4') { ?> checked="checked"<?php } ?> /></td>
	<td><input type="radio" value="5" name="jak_position"<?php if ($v["value"] == '5') { ?> checked="checked"<?php } ?> /></td>
	<td><input type="radio" value="6" name="jak_position"<?php if ($v["value"] == '6') { ?> checked="checked"<?php } ?> /></td>
</tr>
<tr>
	<td><input type="radio" value="7" name="jak_position"<?php if ($v["value"] == '7') { ?> checked="checked"<?php } ?> /></td>
	<td><input type="radio" value="8" name="jak_position"<?php if ($v["value"] == '8') { ?> checked="checked"<?php } ?> /></td>
	<td><input type="radio" value="9" name="jak_position"<?php if ($v["value"] == '9') { ?> checked="checked"<?php } ?> /></td>
</tr>
</table><?php } } ?></td>
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
		<input type="text" name="jak_mid" class="form-control" value="<?php echo $jkv["gallerypagemid"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["setting"]["s12"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e5"])) echo " has-error";?>">
		<input type="text" name="jak_item" class="form-control" value="<?php echo $jkv["gallerypageitem"];?>" />
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
<div class="tab-pane" id="gallSett2">
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
		$(document).ready(function()
		{	
			$('#cmsTab a').click(function (e) {
			  e.preventDefault();
			  $(this).tab('show');
			});
		});
</script>
		
<?php include_once APP_PATH.'admin/template/footer.php';?>