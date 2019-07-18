<?php include "header.php";?>

<?php if ($page1 == "s") { ?>
<div class="alert alert-success fade in">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <?php echo $tl["general"]["g7"];?>
</div>
<?php } if ($page1 == "e" || $page1 == "ene") { ?>
<div class="alert alert-danger fade in">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <?php echo ($page1 == "e" ? $tl["errorpage"]["sql"] : $tl["errorpage"]["not"]);?>
</div>
<?php } ?>

<?php  if (isset($JAK_NEWS) && is_array($JAK_NEWS)) { ?>
<div class="box box-default">
  <div class="box-header with-border">
  <i class="fa fa-file-text-o"></i>
    <h3 class="box-title"><?php echo $tl["menu"]["m8"];?></h3>
  </div><!-- /.box-header -->
<div class="box-body">
<ul class="jak_news_move">
<?php foreach($JAK_NEWS as $v) { ?>

<li id="news-<?php echo $v["id"];?>" class="jaknews">
	<div class="text">#<?php echo $v["id"];?> <a href="index.php?p=news&amp;sp=edit&amp;ssp=<?php echo $v["id"];?>"><?php echo $v["title"];?></a></div>
	<div class="show"><?php echo $tl["news"]["n1"].': '.$v["time"].' | '.$tl["general"]["g56"].': '.$v["hits"]; ?></div>
	<div class="actions">
	
		<a class="btn btn-default btn-xs" href="index.php?p=news&amp;sp=lock&amp;ssp=<?php echo $v["id"];?>"><i class="fa fa-<?php if ($v["active"] == '0') { ?>lock<?php } else { ?>check<?php } ?>"></i></a>
		<a class="btn btn-default btn-xs" href="index.php?p=news&amp;sp=edit&amp;ssp=<?php echo $v["id"];?>"><i class="fa fa-edit"></i></a>
		<a class="btn btn-default btn-xs" href="index.php?p=news&amp;sp=delete&amp;ssp=<?php echo $v["id"];?>" onclick="if(!confirm('<?php echo $tl["news"]["d"];?>'))return false;"><i class="fa fa-trash-o"></i></a>
	
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

<?php if ($JAK_PAGINATE) { echo $JAK_PAGINATE; } } else { ?>

<div class="alert alert-info">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
 	<?php echo $tl["errorpage"]["data"];?>
</div>

<?php } ?>	

<script src="js/newsorder.js" type="text/javascript"></script>
		
<?php include "footer.php";?>