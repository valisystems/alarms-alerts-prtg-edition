<?php include "header.php";?>

<?php if ($page1 == "s") { ?>
<div class="alert alert-success fade in">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <?php echo $tl["general"]["g7"];?>
</div>
<?php } if ($page1 == "e") { ?>
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
	<li class="active"><a href="#style_tabs-1"><?php echo $tl["menu"]["m2"];?></a></li>
	<li><a href="#style_tabs-2"><?php echo $tl["general"]["g89"];?></a></li>
</ul>

<div class="tab-content">
<div class="tab-pane active" id="style_tabs-1">
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
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["title"]["t5"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><?php echo $tl["setting"]["s6"];?></td>
	<td>
	<div class="radio">
		<label>
	<input type="radio" name="jak_search" value="1"<?php if ($jkv["searchform"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
	</label>
	</div>
	<div class="radio">
	<label>
	<input type="radio" name="jak_search" value="0"<?php if ($jkv["searchform"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
	</label>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["setting"]["s38"];?></td>
	<td>
	<div class="radio">
	<label>
	<input type="radio" name="jak_ajaxsearch" value="1"<?php if ($jkv["ajaxsearch"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
	</label>
	</div>
	<div class="radio">
	<label>
	<input type="radio" name="jak_ajaxsearch" value="0"<?php if ($jkv["ajaxsearch"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
	</label>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["setting"]["s37"];?></td>
	<td>
	<div class="radio">
	<label>
	<input type="radio" name="jak_fullsearch" value="1"<?php if ($jkv["fulltextsearch"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
	</label>
	</div>
	<div class="radio">
	<label>
	<input type="radio" name="jak_fullsearch" value="0"<?php if ($jkv["fulltextsearch"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
	</label>
	</div>
	<input type="hidden" name="jak_fullsearchold" value="<?php echo $jkv["fulltextsearch"];?>" />
	</td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>

</div>
<div class="tab-pane" id="style_tabs-2">
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["general"]["g89"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
			<?php include 'sidebar_widget.php';?>
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
		
<?php include "footer.php";?>