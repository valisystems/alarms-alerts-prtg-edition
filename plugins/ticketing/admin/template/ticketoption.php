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

<div class="box box-default">
  <div class="box-header with-border">
  <i class="fa fa-ticket"></i>
    <h3 class="box-title"><?php echo $tlt["st"]["d17"];?></h3>
  </div><!-- /.box-header -->
<div class="box-body">
<ul class="jak_cat_move">
<?php if (isset($CMS_TICKET_OPTIONS) && is_array($CMS_TICKET_OPTIONS)) foreach($CMS_TICKET_OPTIONS as $v) { ?>

<li id="opt-<?php echo $v["id"];?>" class="jakcat">
	<div class="text">#<?php echo $v["id"];?> <a href="index.php?p=ticketing&amp;sp=options&amp;ssp=edit&amp;sssp=<?php echo $v["id"];?>"><?php echo $v["name"];?></a></div>
	<div class="actions">
		
		<a href="index.php?p=ticketing&amp;sp=options&amp;ssp=edit&amp;sssp=<?php echo $v["id"];?>" class="btn btn-default btn-xs"><i class="fa fa-edit"></i></a>
		<a href="index.php?p=ticketing&amp;sp=options&amp;ssp=delete&amp;sssp=<?php echo $v["id"];?>" class="btn btn-default btn-xs" onclick="if(!confirm('<?php echo $tl["cat"]["al"];?>'))return false;"><i class="fa fa-trash-o"></i></a>
	
	</div>
</li>

<?php } ?>
</ul>
</div>
</div>

<div class="icon_legend">
<h3><?php echo $tl["icons"]["i"];?></h3>
<i title="<?php echo $tl["icons"]["i2"];?>" class="fa fa-edit"></i>
<i title="<?php echo $tl["icons"]["i1"];?>" class="fa fa-trash-o"></i>
</div>

<script src="../plugins/ticketing/js/optionorder.js" type="text/javascript"></script>
		
<?php include_once APP_PATH.'admin/template/footer.php';?>