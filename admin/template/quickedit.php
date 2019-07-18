<?php include "quickheader.php";?>

<?php if ($page3 == "s") { ?>
<div class="alert alert-success fade in">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <?php echo $tl["general"]["g7"];?>
</div>
<?php } if ($page3 == "e") { ?>
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
		  if (isset($errors["e2"])) echo $errors["e2"];?>
</div>
<?php } ?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">

<table class="table table-striped">
<thead>
<tr>
<th colspan="2"><?php echo $tl["title"]["t13"];?></th>
</tr>
</thead>
<tr>
	<td><?php echo $tl["page"]["p"];?></td>
	<td>
	<?php include_once "title_edit.php";?>
	</td>
</tr>
</table>

<?php include_once "editorlight_edit.php";?>

<hr>

<button type="submit" name="save" class="btn btn-primary"><?php echo $tl["general"]["g20"];?></button>

</form>
		
<?php include "quickfooter.php";?>