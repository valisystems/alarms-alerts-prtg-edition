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
	<li class="active"><a href="#faqSett1"><?php echo $tl["menu"]["m2"];?></a></li>
	<li><a href="#faqSett2"><?php echo $tl["general"]["g89"];?></a></li>
</ul>

<div class="tab-content">
<div class="tab-pane active" id="faqSett1">

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
	<td><?php echo $tlf["faq"]["d16"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e2"])) echo " has-error";?>">
		<input class="form-control" type="text" name="jak_email" value="<?php echo $jkv["faqemail"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tlf["faq"]["d15"];?></td>
	<td>
	<div class="row">
	<div class="col-md-6">
	<select name="jak_showfaqordern" class="form-control">
	<option value="id"<?php if ($JAK_SETTING['showfaqwhat'] == "id") { ?> selected="selected"<?php } else { ?> selected="selected"<?php } ?>><?php echo $tlf["faq"]["d22"];?></option>
	<option value="title"<?php if ($JAK_SETTING['showfaqwhat'] == "title") { ?> selected="selected"<?php } ?>><?php echo $tlf["faq"]["d8"];?></option>
	<option value="time"<?php if ($JAK_SETTING['showfaqwhat'] == "time") { ?> selected="selected"<?php } ?>><?php echo $tlf["faq"]["d24"];?></option>
	<option value="hits"<?php if ($JAK_SETTING['showfaqwhat'] == "hits") { ?> selected="selected"<?php } ?>><?php echo $tlf["faq"]["d25"];?></option>
	</select>
	</div>
	<div class="col-md-6">
	<select name="jak_showfaqorder" class="form-control">
	<option value="ASC"<?php if ($JAK_SETTING['showfaqorder'] == "ASC") { ?> selected="selected"<?php } else { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g90"];?></option>
	<option value="DESC"<?php if ($JAK_SETTING['showfaqorder'] == "DESC") { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g91"];?></option>
	</select>
	</div>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tlf["faq"]["d14"];?></td>
	<td><input type="text" name="jak_maxpost" class="form-control" value="<?php echo $jkv["faqmaxpost"];?>" /></td>
</tr>
<tr>
	<td><?php echo $tl["setting"]["s4"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e3"])) echo " has-error";?>">
		<input type="text" name="jak_date" class="form-control" value="<?php echo $jkv["faqdateformat"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["setting"]["s5"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e4"])) echo " has-error";?>">
		<input type="text" name="jak_time" class="form-control" value="<?php echo $jkv["faqtimeformat"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tlf["faq"]["d7"];?></td>
	<td>
	<div class="radio"><label>
		<input type="radio" name="jak_faqurl" value="0"<?php if ($jkv["faqurl"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
	</label></div>
	<div class="radio"><label>
		<input type="radio" name="jak_faqurl" value="1"<?php if ($jkv["faqurl"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
	</label></div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["general"]["g40"];?> / <?php echo $tl["general"]["g41"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e7"])) echo " has-error";?>">
		<input type="text" class="form-control" name="jak_rssitem" value="<?php echo $jkv["faqrss"];?>" />
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
	<div class="form-group<?php if (isset($errors["e5"])) echo " has-error";?>">
		<input type="text" name="jak_mid" class="form-control" value="<?php echo $jkv["faqpagemid"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["setting"]["s12"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e5"])) echo " has-error";?>">
		<input type="text" name="jak_item" class="form-control" value="<?php echo $jkv["faqpageitem"];?>" />
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
<div class="tab-pane" id="faqSett2">
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