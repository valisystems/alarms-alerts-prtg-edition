<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/header.php';?>
		
<?php if (JAK_ASACCESS) $apedit = BASE_URL.'admin/index.php?p=shop&amp;sp=edit&amp;id='.$PAGE_ID; $qapedit = BASE_URL.'admin/index.php?p=shop&amp;sp=quickedit&amp;id='.$PAGE_ID; if ($jkv["printme"]) $printme = 1;?>

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

<hr>
		
<div id="printdiv">

<div class="row">
	<!-- Product Image & Available Colors -->
	<div class="col-sm-6">
		<div class="product-image-large">
			<div class="shop-product" id="p_<?php echo $row["id"];?>">
			<?php if ($row['previmg']) { ?>
			<a href="<?php echo $row["img"];?>" class="lightbox">
			<?php } ?>
			<img class="product-image" src="<?php echo $row["previmg"];?>" alt="product thumbnail" id="p_<?php echo $row["id"];?>" />
			<?php if ($row['previmg']) { ?>
			</a>
			<?php } ?>
			</div>
		</div>
		
	</div>
	<!-- End Product Image & Available Colors -->
	<!-- Product Summary & Options -->
	<div class="col-sm-6 product-details">
		<h4><?php echo $PAGE_TITLE;?></h4>
		<p>
		<div class="price">
			<?php if (isset($row["onsale"])) { echo $tlec["shop"]["m31"]; } else { echo $tlec["shop"]["m"]; } echo '<span class="pprice_'.$row["id"].'">'.$row["price"].'</span>&nbsp;'.$jkv["e_currency"];?>
		</div>
		</p>
		<p><?php echo $tlec["shop"]["m46"].'<strong>'.$instock;?></strong></p>
		<p><?php echo $PAGE_CONTENT_SHORT;?></p>
		<div class="row">
		<div class="col-sm-4">
		<?php if ($row['product_options']) { ?>
		<div class="form-group">
		<select name="product-option" class="product-option form-control" id="po_<?php echo $row["id"];?>">
			<option value=""><?php echo $tlec["shop"]["m54"];?></option>
			<?php $poptarray = explode(',', $row['product_options']); for ($i = 0; $i < count($poptarray); $i++) { 
			
				$optearray = explode('::', $poptarray[$i]);
				
				if ($_SESSION['ECOMMERCE_CURRENCY'] != $jkv["e_currency"] && $optearray[1] != "0.00") {
				
					$optearray[1] = $convert->Convert($optearray[1], $_SESSION['ECOMMERCE_CURRENCY']);
				}
			
			?>
			
			<option value="<?php echo $poptarray[$i];?>"><?php echo $optearray[0]; if ($optearray[1] != "0.00") { echo ' ('.$optearray[1].'&nbsp;'.$jkv["e_currency"].')'; }?></option>
			
			<?php } ?>
		</select>
		</div>
		<input type="hidden" name="pop_<?php echo $row["id"];?>" id="pop_<?php echo $row["id"];?>" value="" />
		<?php } ?>
		</div>
		<div class="col-sm-4">
		<?php if ($row['product_options'] && $row['product_options1']) { ?>
		<div class="form-group">
		<select name="product-option1" class="product-option1 form-control" id="po1_<?php echo $row["id"];?>">
			<option value=""><?php echo $tlec["shop"]["m54"];?></option>
			
			<?php $poptarray1 = explode(',', $row['product_options1']); for ($i = 0; $i < count($poptarray1); $i++) { 
			
				$optearray1 = explode('::', $poptarray1[$i]);
				
				if ($_SESSION['ECOMMERCE_CURRENCY'] != $jkv["e_currency"] && $optearray[1] != "0.00") {
				
					$optearray1[1] = $convert->Convert($optearray1[1], $_SESSION['ECOMMERCE_CURRENCY']);
				}
			
			?>
			
			<option value="<?php echo $poptarray1[$i];?>"><?php echo $optearray1[0]; if ($optearray1[1] != "0.00") { echo ' ('.$optearray1[1].'&nbsp;'.$jkv["e_currency"].')'; }?></option>
			
			<?php } ?>
		</select>
		</div>
		<input type="hidden" name="pop1_<?php echo $row["id"];?>" id="pop1_<?php echo $row["id"];?>" value="" />
		<?php } ?>
		</div>
		<div class="col-sm-4">
		<?php if ($row['product_options'] && $row['product_options1'] && $row['product_options2']) { ?>
		<div class="form-group">
		<select name="product-option2" id="po2_<?php echo $row["id"];?>" class="product-option2 form-control">
			<option value=""><?php echo $tlec["shop"]["m54"];?></option>
			<?php $poptarray2 = explode(',', $row['product_options2']); for ($i = 0; $i < count($poptarray2); $i++) { 
			
				$optearray2 = explode('::', $poptarray2[$i]);
				
				if ($_SESSION['ECOMMERCE_CURRENCY'] != $jkv["e_currency"] && $optearray[1] != "0.00") {
				
					$optearray2[1] = $convert->Convert($optearray2[1], $_SESSION['ECOMMERCE_CURRENCY']);
				}
			
			?>
			
			<option value="<?php echo $poptarray2[$i];?>"><?php echo $optearray2[0]; if ($optearray2[1] != "0.00") { echo ' ('.$optearray2[1].'&nbsp;'.$jkv["e_currency"].')'; }?></option>
			
			<?php } ?>
		</select>
		</div>
		<input type="hidden" name="pop2_<?php echo $row["id"];?>" id="pop2_<?php echo $row["id"];?>" value="" />
		<?php } ?>
		</div>
		</div>
		<p><a href="#" class="btn btn-primary pull-right" onclick="addlist(<?php echo $row['id'];?>);return false;"><i class="fa fa-shopping-cart"></i> <?php echo $tlec["shop"]["m67"];?></a></p>
		<div class="clearfix"></div>
	</div>
	<!-- End Product Summary & Options -->
	
	<!-- Full Description & Specification -->
	<div class="col-sm-12">
		<div class="tabbable">
			<!-- Tabs -->
			<ul class="nav nav-tabs product-details-nav">
				<li class="active"><a href="#tab1" data-toggle="tab"><?php echo $tlec["shop"]["m34"];?></a></li>
				<?php if ($PAGE_SPECS) { ?>
				<li><a href="#tab2" data-toggle="tab"><?php echo $tlec["shop"]["m32"];?></a></li>
				<?php } ?>
			</ul>
			<!-- Tab Content (Full Description) -->
			<div class="tab-content product-detail-info">
				<div class="tab-pane active" id="tab1">
					<h4><?php echo $PAGE_TITLE;?></h4>
					<?php echo $PAGE_CONTENT;?>
				</div>
				<?php if ($PAGE_SPECS) { ?>
				<!-- Tab Content (Specification) -->
				<div class="tab-pane" id="tab2">
					<?php echo $PAGE_SPECS;?>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<!-- End Full Description & Specification -->
</div>

</div>
		
<ul class="pager">
<?php if ($JAK_NAV_PREV) { ?>
	<li class="previous"><a href="<?php echo $JAK_NAV_PREV;?>"><i class="fa fa-arrow-left"></i> <?php echo $JAK_NAV_PREV_TITLE;?></a></li>
<?php } if ($JAK_NAV_NEXT) { ?>
	<li class="next"><a href="<?php echo $JAK_NAV_NEXT;?>"><?php echo $JAK_NAV_NEXT_TITLE;?> <i class="fa fa-arrow-right"></i></a></li>
<?php } ?>
</ul>

<script type="text/javascript">
	jakWeb.jak_msg_shop3 = "loadcart";
</script>
		
<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/footer.php';?>