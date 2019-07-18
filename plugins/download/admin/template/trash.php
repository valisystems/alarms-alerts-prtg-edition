<?php include_once APP_PATH.'admin/template/header.php';?>

<?php if ($page4 == "s") { ?>
<div class="alert alert-success fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?php echo $tl["general"]["g7"];?>
</div>
<?php } if ($page4 == "e") { ?>
<div class="alert alert-danger fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?php echo $tl["errorpage"]["sql"];?>
</div>
<?php } ?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<div class="box">
<div class="box-body no-padding">
<table class="table table-striped">
<thead>
<tr>
<th>#</th>
<th><input type="checkbox" id="jak_delete_all" /></th>
<th><?php echo $tl["page"]["p4"];?></th>
<th><?php echo $tl["login"]["l1"];?></th>
<th><button type="submit" name="untrash" id="button_lock" class="btn btn-default btn-xs" onclick="if(!confirm('<?php echo $tld["dload"]["ap"];?>'))return false;"><i class="fa fa-check"></i></button></th>
<th><button type="submit" name="delete" id="button_delete" class="btn btn-danger btn-xs" onclick="if(!confirm('<?php echo $tld["dload"]["co"];?>'))return false;"><i class="fa fa-trash-o"></i></button></th>
</tr>
</thead>
<?php if (isset($JAK_TRASH_ALL) && is_array($JAK_TRASH_ALL)) foreach($JAK_TRASH_ALL as $v) { ?>
<tr>
<td><?php echo $v["id"];?></td>
<td><input type="checkbox" name="jak_delete_trash[]" class="highlight" value="<?php echo $v["id"];?>" /></td>
<td><?php echo jak_clean_comment($v["message"]);?></td>
<td><?php if ($v["userid"] == '0') { echo $tl["general"]["g28"]; } else { if ($page1 != 'user') { ?><a href="index.php?p=user&amp;sp=edit&amp;ssp=<?php echo $v["userid"];?>"><?php echo $v["username"];?></a><?php } else { echo $v["username"]; } } ?></td>
<td></td>
<td></td>
</tr>
<?php } ?>
</table>
</div>
</div>
</form>

<div class="icon_legend">
<h3><?php echo $tl["icons"]["i"];?></h3>
<i title="<?php echo $tl["icons"]["i6"];?>" class="fa fa-check"></i>
<i title="<?php echo $tl["icons"]["i5"];?>" class="fa fa-lock"></i>
<i title="<?php echo $tl["icons"]["i1"];?>" class="fa fa-trash-o"></i>
</div>

<?php if ($JAK_PAGINATE) echo $JAK_PAGINATE;?>

<!-- JavaScript for select all -->

<script type="text/javascript">
$(document).ready(function() {
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