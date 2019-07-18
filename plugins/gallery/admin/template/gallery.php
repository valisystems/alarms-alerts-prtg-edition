<?php include_once APP_PATH.'admin/template/header.php';?>

<?php if ($page1 == "s") { ?>
<div class="alert alert-success fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?php echo $tl["general"]["g7"];?>
</div>
<?php } if ($page1 == "e" || $page1 == "ene") { ?>
<div class="alert alert-danger fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <h4><?php echo ($page1 == "e" ? $tl["errorpage"]["sql"] : $tl["errorpage"]["not"]);?></h4>
</div>
<?php } ?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<?php if (isset($JAK_GALLERY_ALL)) { ?>
<div class="input-group">
	<select name="jak_catid" class="form-control">
	<?php if (isset($JAK_CAT) && is_array($JAK_CAT)) foreach($JAK_CAT as $z) { ?><option value="<?php echo $z["id"];?>"><?php echo $z["name"];?></option><?php } ?>
	</select>
	<span class="input-group-btn">
		<button type="submit" name="move" class="btn btn-warning"><?php echo $tl["general"]["g35"];?></button>
	</span>
</div>
<hr>
<?php } ?>

<div class="box">
<div class="box-body no-padding">
<div class="table-responsive">
<table class="table table-striped table-hover">
<thead>
<tr>
<th>#</th>
<th><input type="checkbox" id="jak_delete_all" /></th>
<th><?php echo $tlgal["gallery"]["d8"];?></th>
<th><?php echo $tl["page"]["p1"];?></th>
<th><?php echo $tl["page"]["p2"];?></th>
<th><?php echo $tl["general"]["g56"];?></th>
<th><button type="submit" name="lock" id="button_lock" class="btn btn-default btn-xs"><i class="fa fa-lock"></i></button></th>
<th></th>
<th><button type="submit" name="delete" id="button_delete" class="btn btn-danger btn-xs" onclick="if(!confirm('<?php echo $tlgal["gallery"]["al"];?>'))return false;"><i class="fa fa-trash-o"></i></button></th>
</tr>
</thead>
<?php if (isset($JAK_GALLERY_ALL) && is_array($JAK_GALLERY_ALL)) foreach($JAK_GALLERY_ALL as $v) { ?>
<tr>
<td><?php echo $v["id"];?></td>
<td><input type="checkbox" name="jak_delete_gallery[]" class="highlight" value="<?php echo $v["id"];?>" /></td>
<td><a href="index.php?p=gallery&amp;sp=edit&amp;ssp=<?php echo $v["id"];?>"><img src="<?php echo BASE_URL_ORIG.$JAK_UPLOAD_PATH_BASE.$v["paththumb"];?>" alt="<?php echo $v["title"];?>" class="img-thumbnail img-responsive" /></a></td>
<td><?php if ($v["catid"] != '0') { if (isset($JAK_CAT) && is_array($JAK_CAT)) foreach($JAK_CAT as $z) { if ($z["id"] == $v["catid"]) { ?><a href="index.php?p=gallery&amp;sp=showcat&amp;ssp=<?php echo $z["id"];?>"><?php echo $z["name"];?></a> <?php } } } else { ?><?php echo $tl["general"]["g24"];?><?php } ?></td>
<td><?php echo $v["time"]; ?></td>
<td><?php echo $v["hits"];?></td>
<td><a href="index.php?p=gallery&amp;sp=lock&amp;ssp=<?php echo $v["id"];?>" class="btn btn-default btn-xs"><i class="fa fa-<?php if ($v["active"] == 0) { ?>lock<?php } else { ?>check<?php } ?>"></i></a></td>
<td><a href="index.php?p=gallery&amp;sp=edit&amp;ssp=<?php echo $v["id"];?>" class="btn btn-default btn-xs"><i class="fa fa-edit"></i></a></td>
<td><a href="index.php?p=gallery&amp;sp=delete&amp;ssp=<?php echo $v["id"];?>" class="btn btn-default btn-xs" onclick="if(!confirm('<?php echo $tlgal["gallery"]["al"];?>'))return false;"><i class="fa fa-trash-o"></i></a></td>
</tr>
<?php } ?>
</table>
</div>
</div>
</div>
</form>

<div class="icon_legend">
<h3><?php echo $tl["icons"]["i"];?></h3>
<i title="<?php echo $tl["icons"]["i6"];?>" class="fa fa-check"></i>
<i title="<?php echo $tl["icons"]["i5"];?>" class="fa fa-lock"></i>
<i title="<?php echo $tl["icons"]["i2"];?>" class="fa fa-edit"></i>
<i title="<?php echo $tl["icons"]["i1"];?>" class="fa fa-trash-o"></i>
</div>

<?php if ($JAK_PAGINATE) { echo $JAK_PAGINATE; } ?>

<!-- JavaScript for select all -->
<script type="text/javascript">
		$(document).ready(function()
		{
			$("#jak_delete_all").click(function() {
				var checked_status = this.checked;
				$(".highlight").each(function()
				{
					this.checked = checked_status;
				});
			});				
		});
</script>
		
<?php include_once APP_PATH.'admin/template/footer.php';?>