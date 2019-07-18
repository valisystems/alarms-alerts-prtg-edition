<?php include_once APP_PATH.'admin/template/header.php';?>

<?php if ($page2 == "s") { ?>
<div class="alert alert-success fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?php echo $tl["general"]["g7"];?>
</div>
<?php } if ($page2 == "e" || $page2 == "ene") { ?>
<div class="alert alert-danger fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?php echo ($page2 == "e" ? $tl["errorpage"]["sql"] : $tl["errorpage"]["not"]);?>
</div>
<?php } ?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<div class="box">
<div class="box-body no-padding">
<table class="table table-striped table-hover">
<thead>
<tr>
<th>#</th>
<th><input type="checkbox" id="jak_delete_all" /></th>
<th><?php echo $tl["page"]["p"];?></th>
<th><?php echo $tlec["shop"]["m79"];?></th>
<th><?php echo $tlec["shop"]["m80"];?></th>
<th><?php echo $tlec["shop"]["m81"];?></th>
<th><?php echo $tlec["shop"]["m82"];?></th>
<th><button type="submit" name="lock" id="button_lock" class="btn btn-default btn-xs"><i class="fa fa-lock"></i></button></th>
<th></th>
<th><button type="submit" name="delete" id="button_delete" class="btn btn-danger btn-xs" onclick="if(!confirm('<?php echo $tlec["shop"]["coup"];?>'))return false;"><i class="fa fa-trash-o"></i></button></th>
</tr>
</thead>
<?php if (isset($JAK_SHOPCOUPON_ALL) && is_array($JAK_SHOPCOUPON_ALL)) foreach($JAK_SHOPCOUPON_ALL as $v) { ?>
<tr>
<td><?php echo $v["id"];?></td>
<td><input type="checkbox" name="jak_delete_coupon[]" class="highlight" value="<?php echo $v["id"];?>" /></td>
<td><a href="index.php?p=shop&sp=coupons&ssp=edit&sssp=<?php echo $v["id"];?>"><?php echo $v["title"];?></a></td>
<td><?php echo $v["code"];?></td>
<td><?php echo $v["discount"];?>&nbsp;<?php if ($v["type"] == 1) { ?>%<?php } else { ?><?php echo $jkv["e_currency"];?><?php } ?></td>
<td><i class="fa fa-<?php if ($v["freeshipping"] == 0) { ?>lock<?php } else { ?>check<?php } ?>"></i></a></td>
<td><?php echo $v["total"].' / '.$v["used"];?></td>
<td><a href="index.php?p=shop&sp=coupons&ssp=lock&sssp=<?php echo $v["id"];?>"><i class="fa fa-<?php if ($v["status"] == 0) { ?>lock<?php } else { ?>check<?php } ?>"></i></a></td>
<td><a href="index.php?p=shop&sp=coupons&ssp=edit&sssp=<?php echo $v["id"];?>"><i class="fa fa-edit"></i></a></td>
<td><a href="index.php?p=shop&sp=coupons&ssp=delete&sssp=<?php echo $v["id"];?>" onclick="if(!confirm('<?php echo $tlec["shop"]["coup"];?>'))return false;"><i class="fa fa-trash-o"></i></a></td>
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
<i title="<?php echo $tl["icons"]["i2"];?>" class="fa fa-edit"></i>
<i title="<?php echo $tl["icons"]["i1"];?>" class="fa fa-trash-o"></i>
</div>

<?php if ($JAK_PAGINATE) echo $JAK_PAGINATE;?>

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