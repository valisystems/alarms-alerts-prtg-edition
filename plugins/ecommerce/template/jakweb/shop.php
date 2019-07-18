<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/header.php';?>
		
<?php if ($PAGE_TITLE) echo $PAGE_CONTENT;?>

<?php if ($E_CURRENCY_CHOOSE) { ?>
<h4><?php echo $tlec["shop"]["m24"];?></h4>
<form role="form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">

<select name="currency" class="form-control">
<?php if (isset($E_CURRENCY_CHOOSE) && is_array($E_CURRENCY_CHOOSE)) foreach($E_CURRENCY_CHOOSE as $c) { ?>
<option value="<?php echo $c;?>"<?php if ($c == $jkv["e_currency"]) { ?> selected="selected"<?php } ?>><?php echo $c;?></option>
<?php } ?>
</select>

<button type="submit" class="btn btn-default"><?php echo $tl["general"]["g10"];?></button>
</form>
<?php } ?>

<?php if ($JAK_PAGINATE) echo $JAK_PAGINATE;?>

<?php if ($JAK_SHOP_CAT) { if (isset($JAK_SHOP_CAT) && is_array($JAK_SHOP_CAT)) foreach($JAK_SHOP_CAT as $carray) { 

$catexistid = false;
if ($carray["catparent"] != 0)
	$catexistid = array('catparent' => $carray["catparent"]);
		
} ?>

<nav class="navbar navbar-default" role="navigation">
	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#shop-nav" aria-expanded="false">
	        <span class="sr-only">Toggle navigation</span>
	        <i class="fa fa-bars"></i>
	      </button>
	      <div class="collapse navbar-collapse" id="shop-nav">
			<ul class="nav navbar-nav shop-nav">
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
<?php if (JAK_USERID) { ?>
<ul class="nav navbar-nav navbar-right">
	<li><a href="<?php echo $shopdashboard;?>"><i class="fa fa-shopping-bag"></i> <?php echo $tlec["shop"]["m71"];?></a></li>
</ul>
<?php } ?>
</div>
</nav>

<?php } ?>

<div class="drag-cart drop-here" id="shopping-cart">
	<div class="row">
		<div class="col-md-2">
			<h4><?php echo $tlec["shop"]["m26"];?></h4>

			<div class="basket-icons">
				<i id="scart" class="fa fa-shopping-cart fa-5x"></i>
				<i id="basket-loader" class="fa fa-spinner fa-pulse"></i>
			</div>

			<div id="total">
				<p><?php echo $tlec["shop"]["m"];?><span id="total-amount"></span> <?php echo $jkv["e_currency"];?></p>
				<p><a href="<?php echo $shopcheckout;?>" class="btn btn-warning"><i class="fa fa-check-square-o"></i> <?php echo $tlec["shop"]["m29"];?></a></p>
			</div>
		</div>
		<div class="col-md-9">
			<div id="drag-product-info"><?php echo $tlec["shop"]["m27"];?></div>
			<div id="item-list" class="item-list"></div>
		</div>
		<div class="col-md-1">
			<a href="#" id="trash"><i class="fa fa-trash-o fa-3x"></i></a>
		</div>
	</div>
</div>

<div class="row">
	<?php if (isset($JAK_ECOMMERCE_ALL) && is_array($JAK_ECOMMERCE_ALL)) foreach($JAK_ECOMMERCE_ALL as $v) { ?>
	<div id="qs-shop">
	<div class="col-sm-4" data-id="id-<?php echo $v['id'];?>" data-type="<?php echo $v["catname"];?>">
		<div class="shop-item shop-product" id="p_<?php echo $v["id"];?>">
			<div class="image">
				<?php if ($v['img']) { ?>
				<a href="<?php echo $v["img"];?>" class="lightbox">
				<?php } ?>
				<img class="product-image" src="<?php echo $v["previmg"];?>" alt="product thumbnail">
				<?php if ($v['img']) { ?>
				</a>
				<?php } ?>
			</div>
			<div class="title">
				<h3><a<?php if ($jkv["e_productopen"]) { echo ' class="product-info"'; } ?> id="<?php echo $v["id"];?>" href="<?php echo $v['parseurl'];?>"><?php echo $v["title"];?></a></h3>
			</div>
			<div class="price">
				<p><?php if ($v["onsale"]) { echo $tlec["shop"]["m31"]; } else { echo $tlec["shop"]["m"]; } echo '<span class="pprice_'.$v["id"].'">'.$v["price"].'</span>&nbsp;'.$jkv["e_currency"];?></p>
			</div>
			<div class="actions">
				<div class="row">
					<div class="col-xs-4">
				<?php if ($v['product_options']) { ?>
				<div class="form-group">
				<select name="product-option" id="po_<?php echo $v["id"];?>" class="product-option form-control input-sm">
					<option value=""><?php echo $tlec["shop"]["m54"];?></option>
					<?php $poptarray = explode(',', $v['product_options']); for ($i = 0; $i < count($poptarray); $i++) { 
					
						$optearray = explode('::', $poptarray[$i]);
						
						if ($_SESSION['ECOMMERCE_CURRENCY'] != $jkv["e_currency"] && $optearray[1] != "0.00") {
						
							$optearray[1] = $convert->Convert($optearray[1], $_SESSION['ECOMMERCE_CURRENCY']);
						}
					
					?>
					
					<option value="<?php echo $optearray[0].'::'.$optearray[1].'::'.$optearray[2];?>"><?php echo $optearray[0]; if ($optearray[1] != "0.00") { echo ' ('.$optearray[1].'&nbsp;'.$jkv["e_currency"].')'; }?></option>
					
					<?php } ?>
				</select>
				</div>
				<input type="hidden" name="pop_<?php echo $v["id"];?>" id="pop_<?php echo $v["id"];?>" value="" />
				<?php } ?>
				</div>
				<div class="col-xs-4">
				<?php if ($v['product_options'] && $v['product_options1']) { ?>
				<div class="form-group">
				<select name="product-option1" id="po1_<?php echo $v["id"];?>" class="product-option1 form-control input-sm">
					<option value=""><?php echo $tlec["shop"]["m54"];?></option>
					
					<?php $poptarray1 = explode(',', $v['product_options1']); for ($i = 0; $i < count($poptarray1); $i++) { 
					
						$optearray1 = explode('::', $poptarray1[$i]);
						
						if ($_SESSION['ECOMMERCE_CURRENCY'] != $jkv["e_currency"] && $optearray[1] != "0.00") {
						
							$optearray1[1] = $convert->Convert($optearray1[1], $_SESSION['ECOMMERCE_CURRENCY']);
						}
					
					?>
					
					<option value="<?php echo $optearray1[0].'::'.$optearray1[1].'::'.$optearray1[2];?>"><?php echo $optearray1[0]; if ($optearray1[1] != "0.00") { echo ' ('.$optearray1[1].'&nbsp;'.$jkv["e_currency"].')'; }?></option>
					
					<?php } ?>
				</select>
				</div>
				<input type="hidden" name="pop1_<?php echo $v["id"];?>" id="pop1_<?php echo $v["id"];?>" value="" />
				<?php } ?>
				</div>
				<div class="col-xs-4">
				<?php if ($v['product_options'] && $v['product_options1'] && $v['product_options2']) { ?>
				<div class="form-group">
				<select name="product-option2" id="po2_<?php echo $v["id"];?>" class="product-option2 form-control input-sm">
					<option value=""><?php echo $tlec["shop"]["m54"];?></option>
					<?php $poptarray2 = explode(',', $v['product_options2']); for ($i = 0; $i < count($poptarray2); $i++) { 
					
						$optearray2 = explode('::', $poptarray2[$i]);
						
						if ($_SESSION['ECOMMERCE_CURRENCY'] != $jkv["e_currency"] && $optearray[1] != "0.00") {
						
							$optearray2[1] = $convert->Convert($optearray2[1], $_SESSION['ECOMMERCE_CURRENCY']);
						}
					
					?>
					
					<option value="<?php echo $optearray2[0].'::'.$optearray2[1].'::'.$optearray2[2];?>"><?php echo $optearray2[0]; if ($optearray2[1] != "0.00") { echo ' ('.$optearray2[1].'&nbsp;'.$jkv["e_currency"].')'; }?></option>
					
					<?php } ?>
				</select>
				</div>
				<input type="hidden" name="pop2_<?php echo $v["id"];?>" id="pop2_<?php echo $v["id"];?>" value="" />
				<?php } ?>
				</div>
				</div>
				<a href="javascript:void(0)" class="btn btn-primary" onclick="addlist(<?php echo $v['id'];?>);return false;"><i class="fa fa-shopping-cart"></i> <?php echo $tlec["shop"]["m67"];?></a><?php if (JAK_ASACCESS) { ?> <a class="btn btn-primary jaktip quickedit" href="<?php echo BASE_URL;?>admin/index.php?p=shop&amp;sp=quickedit&amp;id=<?php echo $v["id"];?>" title="<?php echo $tl["general"]["g176"];?>"><i class="fa fa-edit"></i></a><?php } ?> <a data-id="<?php echo $v["id"];?>" href="<?php echo $v['parseurl'];?>" class="btn btn-info<?php if ($jkv["e_productopen"]) echo ' product-info';?>"><i class="fa fa-info-circle"></i></a>
			</div>
		</div>
		</div>
	</div>
	<?php } ?>
</div>

<script type="text/javascript">
	jakWeb.jak_msg_shop3 = "loadcart";
</script>
		
<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/footer.php';?>