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

<div class="box box-default">
  <div class="box-header with-border">
  <i class="fa fa-shopping-cart"></i>
    <h3 class="box-title"><?php echo $tlec["shop"]["m52"];?></h3>
  </div><!-- /.box-header -->
<div class="box-body">

<ul class="jak_cat_move">
<?php if (isset($JAK_ECOMMERCE_ALL) && is_array($JAK_ECOMMERCE_ALL)) foreach($JAK_ECOMMERCE_ALL as $v) { ?>

<li id="cat-<?php echo $v["id"];?>" class="jakcat">
	<div class="text">#<?php echo $v["id"];?> <a href="index.php?p=shop&amp;sp=edit&amp;ssp=<?php echo $v["id"];?>"><?php echo $v["title"];?></a> <input type="hidden" name="corder[]" class="corder" value="<?php echo $v["ecorder"];?>" /><input type="hidden" name="real_ms_id[]" value="<?php echo $v["id"];?>" /></div>
	<div class="show"><?php echo $tl["page"]["p2"];?>: <?php echo $v["time"];?> | <?php echo $tl["general"]["g56"];?>: <?php echo $v["hits"];?></div>
	<div class="actions">
	
		<a href="index.php?p=shop&amp;sp=lock&amp;ssp=<?php echo $v["id"];?>" class="btn btn-default btn-xs"><i class="fa fa-<?php if ($v["active"] == 0) { ?>lock<?php } else { ?>check<?php } ?>"></i></a>
		<a href="index.php?p=shop&amp;sp=edit&amp;ssp=<?php echo $v["id"];?>" class="btn btn-default btn-xs"><i class="fa fa-edit"></i></a>
		<a href="index.php?p=shop&amp;sp=delete&amp;ssp=<?php echo $v["id"];?>" class="btn btn-default btn-xs" onclick="if(!confirm('<?php echo $tlec["shop"]["al"];?>'))return false;"><i class="fa fa-trash-o"></i></a>
	
	</div>
</li>

<?php } ?>
</ul>

</div>
</div>

<div class="icon_legend">
<h3><?php echo $tl["icons"]["i"];?></h3>
<i title="<?php echo $tl["icons"]["i6"];?>" class="fa fa-check"></i>
<i title="<?php echo $tl["icons"]["i5"];?>" class="fa fa-lock"></i>
<i title="<?php echo $tl["icons"]["i2"];?>" class="fa fa-edit"></i>
<i title="<?php echo $tl["icons"]["i1"];?>" class="fa fa-trash-o"></i>
</div>

<script src="../plugins/ecommerce/js/shoporder.js" type="text/javascript"></script>
		
<?php include_once APP_PATH.'admin/template/footer.php';?>