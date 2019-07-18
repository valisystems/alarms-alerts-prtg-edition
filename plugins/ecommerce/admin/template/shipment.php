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
<?php } if (isset($JAK_SHIPPING) && is_array($JAK_SHIPPING)) { ?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<div class="box">
<div class="box-body no-padding">
<table class="table table-striped">
<thead>
<tr>
<th>#</th>
<th><?php echo $tl["page"]["p"];?></th>
<th><?php echo $tlec["shop"]["m51"];?></th>
<th><?php echo $tl["page"]["p2"];?></th>
<th><?php echo $tlec["shop"]["m15"];?></th>
<th>-</th>
<th>-</th>
<th>-</th>
</tr>
</thead>
<?php foreach($JAK_SHIPPING as $v) { ?>
<tr>
<td><?php echo $v["id"];?><input type="hidden" name="real_ms_id[]" value="<?php echo $v["id"];?>" /></td>
<td><a href="index.php?p=shop&amp;sp=ecshipping&amp;ssp=edit&amp;sssp=<?php echo $v["id"];?>"><?php echo $v["title"];?></a></td>
<td style="width:200px"><?php echo $v["name"];?></td>
<td style="width:200px"><?php echo $v["time"]; ?></td>
<td style="width:100px"><?php echo $v["price"];?></td>
<td><a href="index.php?p=shop&amp;sp=ecshipping&amp;ssp=lock&amp;sssp=<?php echo $v["id"];?>"><i class="fa fa-<?php if ($v["status"] == 0) { ?>lock<?php } else { ?>check<?php } ?>"></i></a></td>
<td><a href="index.php?p=shop&amp;sp=ecshipping&amp;ssp=edit&amp;sssp=<?php echo $v["id"];?>" class="btn btn-default btn-xs"><i class="fa fa-edit"></i></a></td>
<td><a href="index.php?p=shop&amp;sp=ecshipping&amp;ssp=delete&amp;sssp=<?php echo $v["id"];?>" class="btn btn-default btn-xs" onclick="if(!confirm('<?php echo $tlec["shop"]["al"];?>'))return false;"><i class="fa fa-trash-o"></i></a></td>
</tr>
<?php } ?>
</table>
</div>
</div>
<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
<div class="clearfix"></div>
</form>

<?php } else { ?>

<div class="alert alert-info">
 	<?php echo $tl["errorpage"]["data"];?>
</div>
	
<?php } ?>

<div class="icon_legend">
<h3><?php echo $tl["icons"]["i"];?></h3>
<i title="<?php echo $tl["icons"]["i6"];?>" class="fa fa-check"></i>
<i title="<?php echo $tl["icons"]["i5"];?>" class="fa fa-lock"></i>
<i title="<?php echo $tl["icons"]["i2"];?>" class="fa fa-edit"></i>
<i title="<?php echo $tl["icons"]["i1"];?>" class="fa fa-trash-o"></i>
</div>
		
<?php include_once APP_PATH.'admin/template/footer.php';?>