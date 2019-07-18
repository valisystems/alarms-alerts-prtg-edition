<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/header.php';?>

<?php if ($JAK_SHOP_CAT) { if (isset($JAK_SHOP_CAT) && is_array($JAK_SHOP_CAT)) foreach($JAK_SHOP_CAT as $carray) { 

$catexistid = false;
if ($carray["catparent"] != 0)
	$catexistid = array('catparent' => $carray["catparent"]);
		
} ?>

<nav class="navbar navbar-<?php echo $jkv["navbarbw_mosaic_tpl"];?>" role="navigation">
	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#shop-nav" aria-expanded="false">
	        <span class="sr-only">Toggle navigation</span>
	        <i class="fa fa-bars"></i>
	      </button>
	      <div class="collapse navbar-collapse" id="shop-nav">
			<ul class="nav navbar-nav shop-nav nav-main">
			<li<?php if ($page3 == "") echo ' class="active"';?>><a href="<?php echo $backtoshop;?>" name="all"><?php echo $tlec["shop"]["m52"];?></a></li>

<?php if (isset($JAK_SHOP_CAT) && is_array($JAK_SHOP_CAT)) foreach($JAK_SHOP_CAT as $mv) { if ($mv["catparent"] == '0') { ?>

<li<?php if (!empty($page3) && $page3 == $mv["varname"]) echo ' class="active"';?>><a href="<?php echo $mv['parseurl'];?>" name="<?php echo $mv["varname"];?>"><?php if ($mv["catimg"]) { ?><i class="fa <?php echo $mv["catimg"];?> fa-fw"></i> <?php } ?><?php echo $mv["name"];?></a>

<?php if (is_array($catexistid) && in_array($mv['id'], $catexistid)) { ?>

<ul>

<?php if (isset($JAK_SHOP_CAT) && is_array($JAK_SHOP_CAT)) foreach($JAK_SHOP_CAT as $mz) {

if ($mz["catparent"] != '0' && $mz["catparent"] == $mv["id"]) { 

?>
 
<li<?php if (!empty($page3) && $page3 == $mz["varname"])  echo ' class="active"';?>><a href="<?php echo $mz['parseurl'];?>" name="<?php echo $mz["varname"];?>"><?php if ($mz["catimg"]) { ?><i class="fa <?php echo $mz["catimg"];?> fa-fw"></i> <?php } echo $mz["name"];?></a></li>
<?php } } ?>
</ul>
</li>
<?php } else { ?>
</li>

<?php } } } ?>

</ul>
<ul class="nav navbar-nav nav-main navbar-right">
	<li><a href="<?php echo $shopdashboard;?>"><i class="fa fa-shopping-bag"></i> <?php echo $tlec["shop"]["m71"];?></a></li>
</ul>
</div>
</nav>

<?php } ?>

<div class="shop-mosaic-items">
<p><?php echo $tlec['shop']['m72'];?></p>

<?php if (isset($JAK_ORDERS) && !empty($JAK_ORDERS)) { ?>
<table class="table table-striped table-hover">
<thead>
<tr>
<th><?php echo $tlec["shop"]["m76"];?></th>
<th><?php echo $tlec["shop"]["m77"];?></th>
<th><?php echo $tlec["shop"]["m78"];?></th>
<th><?php echo $tlec["shop"]["m79"];?></th>
<th><?php echo $tlec["shop"]["m78"];?></th>
</tr>
</thead>
<?php foreach($JAK_ORDERS as $v) { ?>
<tr>
<td><?php echo $v["ordernumber"];?></td>
<td><?php echo $v["ordertime"]; ?></td>
<td><?php if ($v["paidtime"] != "0000-00-00 00:00:00") { echo $v["paidtime"]; } else { echo '-'; } ?></td>
<td><?php echo ($v["paid"] == 1 ? '<a href="'.$v["invoice"].'" class="quickedit"><i class="fa fa-file"></i></a>' : '-');?> <?php echo ($v["paid"] == 1 ? '<a href="'.$v["invoice"].'"><i class="fa fa-print"></i></a>' : '-');?></td>
<td><i class="fa fa-<?php if ($v["paid"] == 0) { ?>exclamation-circle<?php } else { ?>check-circle<?php } ?>"></i></td>
</tr>
<?php } ?>
</table>
<?php } else { ?>
<div class="alert alert-info"><?php echo sprintf($tlec['shop']['m74'],'<a href="'.$backtoshop.'">'.$tlec["shop"]["m75"].'</a>');?></div>
<?php } ?>
</div>
		
<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/footer.php';?>