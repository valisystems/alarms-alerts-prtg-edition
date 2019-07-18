<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/header.php';?>

<?php if ($JAK_GO_PAY) { ?>

	<div class="alert alert-info">
	  <h4><?php echo $tlec["shop"]["m25"];?></h4>
	  <p><img src="<?php echo BASE_URL;?>img/loading.gif" alt="loading" /></p>
	  <p><?php echo $JAK_GO_PAY;?></p>
	</div>
	
	<script type="text/javascript">
		$(document).ready(function(){ 
			setTimeout(function(){
				$('#gateway_form').submit(); 
			}, 3000);
			
		});
	</script>
			
<?php } else { ?>

<?php if ($errors) { ?>
<div class="alert alert-danger">
	<button type="button" class="close" data-dismiss="alert">×</button>
    <?php if (isset($errors["e"])) echo $errors["e"];
    	  if (isset($errors["e1"])) echo $errors["e1"];
    	  if (isset($errors["e2"])) echo $errors["e2"];
    	  if (isset($errors["e3"])) echo $errors["e3"];
    	  if (isset($errors["e4"])) echo $errors["e4"];
    	  if (isset($errors["e5"])) echo $errors["e5"];
    	  if (isset($errors["e6"])) echo $errors["e6"];
    	  if (isset($errors["e7"])) echo $errors["e7"];
    	  if (isset($errors["e8"])) echo $errors["e8"];
    	  if (isset($errors["e9"])) echo $errors["e9"];?>
</div>
<?php } ?>
<div class="row">
	<div class="col-md-12">
		<!-- Action Buttons -->
		<div class="pull-right">
			<?php if ($E_CURRENCY_CHOOSE) { ?>
				<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
					<div class="input-group">
					<select name="currency" class="form-control">
					<?php if (isset($E_CURRENCY_CHOOSE) && is_array($E_CURRENCY_CHOOSE)) foreach($E_CURRENCY_CHOOSE as $c) { ?>
					<option value="<?php echo $c;?>"<?php if ($c == $jkv["e_currency"]) { ?> selected="selected"<?php } ?>><?php echo $c;?></option>
					<?php } ?>
					</select>
					<span class="input-group-btn">
					<button type="submit" name="currency" class="btn btn-default"><?php echo $tl["general"]["g10"];?></button>
					</span>
					</div>
				</form>
				
			<?php } ?>
			<form role="form" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
			<button type="submit" name="refresh" class="btn btn-color"><i class="fa fa-refresh"></i> <?php echo $tlec["shop"]["m19"];?></button>
			
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<!-- Shopping Cart Items -->
		<table class="shopping-cart">
			<?php if (isset($JAK_ECOMMERCE_CART) && is_array($JAK_ECOMMERCE_CART)) foreach($JAK_ECOMMERCE_CART as $v) { ?>
			<!-- Shopping Cart Item -->
			<tr>
				<!-- Shopping Cart Item Image -->
				<td class="image"><img src="<?php echo $v["previmg"];?>" alt="<?php echo $v["title"];?>"></td>
				<!-- Shopping Cart Item Description & Features -->
				<td>
					<div class="cart-item-title"><?php echo $v["title"];?></div>
					<div class="feature"><?php echo $v["product_option"];?></div>
				</td>
				<!-- Shopping Cart Item Quantity -->
				<td class="quantity">
					<input class="form-control input-sm input-micro" type="text" name="newquant_<?php echo $v["id"];?>" value="<?php echo $v["total"];?>" maxlength="3">
					<input type="hidden" name="oldquant_<?php echo $v["id"];?>" value="<?php echo $v["total"];?>">
					<input type="hidden" name="specid_<?php echo $v["id"];?>" value="<?php echo $v["cartid"];?>">
					<input type="hidden" name="cartid[]" value="<?php echo $v["id"];?>">
				</td>
				<!-- Shopping Cart Item Price -->
				<td class="price"><?php echo ($v['sale'] != "0.00" ? $tlec["shop"]["m31"] : "");?> <?php echo $v["price"];?> <?php echo $jkv["e_currency"];?></td>
				<!-- Shopping Cart Item Actions -->
				<td class="actions">
					<a href="<?php echo htmlspecialchars(JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_ECOMMERCE, 'rc', $v["cartid"]));?>" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></a>
				</td>
			</tr>
			<!-- End Shopping Cart Item -->
			<?php } else { ?>
			<tr>
				<td><?php echo $tlec["shop"]["m50"];?></td>
			</tr>
			<?php } ?>
			</form>
		</table>
		<!-- End Shopping Cart Items -->
	</div>
</div>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
<div class="row">
	<!-- Promotion Code -->
	<div class="col-md-3 col-md-offset-0 col-sm-6 col-sm-offset-6">
		<div class="cart-promo-code">
			<h6><i class="fa fa-gift"></i> <?php echo $tlec["shop"]["m61"];?> <i id="cLoading" class="fa fa-spinner fa-pulse"></i></h6>
			<div class="input-group">
				<input class="form-control input-sm" id="jak_shcode" name="jak_shcode" type="text">
				<span class="input-group-btn">
					<button class="btn btn-sm btn-color" type="submit" name="checkC" id="jak_checkC"><?php echo $tlec["shop"]["m62"];?></button>
				</span>
			</div>
			<div class="statusC"></div>
		</div>
	</div>
	<!-- Shipment Options -->
	<div class="col-md-3 col-md-offset-0 col-sm-6 col-sm-offset-6">
		<div class="cart-shippment-options">
			<h6><i class="fa fa-truck"></i> <?php echo $tlec["shop"]["m36"];?> <a href="javascript:void(0)" class="jaktip" title="<?php if (isset($shipping_option) && is_array($shipping_option)) { echo $tlec["shop"]["m37"]; } else { echo $tlec["shop"]["m48"];}?>"><i class="fa fa-question-circle"></i></a></h6>
			<?php if (isset($shipping_option) && is_array($shipping_option)) { ?>
				<div class="input-append">
					<select class="form-control input-sm" name="shipping_option" id="shipping-option">
				    <option value="0" id="shipping-remove"><?php echo $tl["cmsg"]["c12"];?></option>
				    <?php foreach($shipping_option as $po) { echo $po["select"]; } ?>
				    </select>
				</div>
			<?php } ?>
		</div>
	</div>
	
	<!-- Shopping Cart Totals -->
	<div class="col-md-6 col-md-offset-0 col-sm-6 col-sm-offset-6">
		<table class="cart-totals">
			<tr>
				<td><b><?php echo $tlec["shop"]["m3"];?></b></td>
				<td><span id="shipping-handling"></span> <span id="shipping-currency" class="c-hidden"><?php echo $jkv["e_currency"];?></span></td>
			</tr>
			<tr>
				<td><b><?php echo $tlec["shop"]["m60"];?></b></td>
				<td><div id="statusCT"></div></td>
			</tr>
			<tr class="cart-grand-total">
				<td><b><?php echo $tlec["shop"]["m2"];?></b></td>
				<td><b><span id="total-amount"><?php echo number_format($JAK_CHECKOUT_TOTAL, 2, '.', '');?></span> <?php echo $jkv["e_currency"];?> <span id="show-tax">(<?php echo $tlec["shop"]["m49"];?> <?php echo $jkv["e_taxes"];?>%)</span></b></td>
			</tr>
		</table>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<h3><?php echo $tlec["shop"]["m1"];?></h3>
		
		<?php if ($jkv["shopcheckout"] != 2) { ?>
		<div class="form-group">
		<label class="control-label" for="company"><?php echo $tlec["shop"]["m21"];?></label>
			<input type="text" name="company" class="form-control" value="<?php if (isset($_POST["company"])) echo $_POST["company"];?>" placeholder="<?php echo $tlec["shop"]["m21"];?>">
		</div>
		<?php } ?>
		<div class="form-group">
		<label class="control-label" for="name"><?php echo $tlec["shop"]["m39"];?> <i class="fa fa-star"></i></label>
			<input type="text" name="name" class="form-control" value="<?php if (isset($_POST["name"])) echo $_POST["name"];?>" placeholder="<?php echo $tlec["shop"]["m39"];?>" />
		</div>
		<?php if ($jkv["shopcheckout"] != 2) { ?>
		<div class="form-group">
		<label class="control-label" for="phone"><?php echo $tlec["shop"]["m40"];?> <i class="fa fa-star"></i></label>
			<input type="text" name="phone" class="form-control" value="<?php if (isset($_POST["phone"])) echo $_POST["phone"];?>" placeholder="<?php echo $tlec["shop"]["m40"];?>" />
		</div>
		<?php } ?>
		<div class="form-group<?php if (isset($errors["e2"])) echo " has-error";?>">
		<label class="control-label" for="email"><?php echo $tlec["shop"]["m41"];?> <i class="fa fa-star"></i></label>
		    <input type="email" name="email" class="form-control" value="<?php if (isset($checkout_email) && !isset($_POST["email"])) echo $checkout_email; if (isset($_POST["email"])) echo $_POST["email"];?>" placeholder="<?php echo $tlec["shop"]["m41"];?>" />
		</div>
		<?php if (!JAK_USERID && $jkv["rf_welcome"]) { ?>
		<div class="form-group<?php if (isset($errors["e9"])) echo " has-error";?>">
		    <label class="control-label" for="username"><?php echo $tl["login"]["l1"];?> <i class="fa fa-star"></i></label>
		      <input type="text" name="username" class="form-control" id="username" value="<?php if (isset($_POST["username"])) echo $_POST["username"];?>" placeholder="<?php echo $tl["login"]["l1"];?>" />
		</div>
		<?php } if ($jkv["shopcheckout"] != 2) { ?>
		<div class="form-group">
		<label class="control-label" for="address"><?php echo $tlec["shop"]["m42"];?> <i class="fa fa-star"></i></label>
		<div class="controls">
			<input type="text" name="address" class="form-control" value="<?php if (isset($_POST["address"])) echo $_POST["address"];?>" placeholder="<?php echo $tlec["shop"]["m42"];?>" />
		</div>
		</div>
		<div class="form-group">
		<label class="control-label" for="city"><?php echo $tlec["shop"]["m43"];?> <i class="fa fa-star"></i></label>
			<div class="row">
			<div class="col-md-6">
			<input type="text" name="city" class="form-control" value="<?php if (isset($_POST["city"])) echo $_POST["city"];?>" placeholder="<?php echo $tlec["shop"]["m43"];?>">
			</div>
			<div class="col-md-6">
			<input type="text" name="postal" class="form-control" class="postal" value="<?php if (isset($_POST["postal"])) echo $_POST["postal"];?>" placeholder="<?php echo $tlec["shop"]["m44"];?>">
			</div>
			</div>
		</div>
		<?php } ?>
		<div class="form-group">
		<label class="control-label" for="country"><?php echo $tlec["shop"]["m45"];?> <i class="fa fa-star"></i></label>
			<select name="country" id="country-tax" class="form-control">
				<option value="0"><?php echo $tl["cmsg"]["c12"];?></option>
				<?php echo $getcountry;?>
			</select>
		</div>
		<div class="well well-sm">
			<?php echo $tl["contact"]["n"];?> <?php echo $tl["contact"]["n1"];?> <i class="fa fa-star"></i> <?php echo $tl["contact"]["n2"];?>
		</div>
		
		<!-- Shipping -->
		<?php if ($jkv["shopcheckout"] == 1) { ?>
		<div class="checkbox"><label><input type="checkbox" id="show-shipping" name="show-shipping" /> <?php echo $tlec["shop"]["m33"];?></label></div>
		
		<div id="shipping-form" class="shipping-form">
		
		<div class="form-group">
		<label class="control-label" for="sh_company"><?php echo $tlec["shop"]["m21"];?></label>
			<input type="text" name="sh_company" class="form-control" value="<?php if (isset($_POST["sh_company"])) echo $_POST["sh_company"];?>" placeholder="<?php echo $tlec["shop"]["m21"];?>" />
		</div>
		<div class="form-group">
		<label class="control-label" for="sh_name"><?php echo $tlec["shop"]["m39"];?> <i class="fa fa-star"></i></label>
			<input type="text" name="sh_name" class="form-control" value="<?php if (isset($_POST["sh_name"])) echo $_POST["sh_name"];?>" placeholder="<?php echo $tlec["shop"]["m39"];?>" />
		</div>
		<div class="form-group">
		<label class="control-label" for="sh_phone"><?php echo $tlec["shop"]["m40"];?> <i class="fa fa-star"></i></label>
			<input type="text" name="sh_phone" class="form-control" value="<?php if (isset($_POST["address"])) echo $_POST["sh_phone"];?>" placeholder="<?php echo $tlec["shop"]["m40"];?>" />
		</div>
		<div class="form-group">
		<label class="control-label" for="sh_email"><?php echo $tlec["shop"]["m41"];?> <i class="fa fa-star"></i></label>
		    <input type="input" name="sh_email" class="form-control" value="<?php if (isset($_POST["sh_email"])) echo $_POST["sh_email"];?>" placeholder="<?php echo $tlec["shop"]["m41"];?>" />
		</div>
		<div class="form-group">
		<label class="control-label" for="sh_address"><?php echo $tlec["shop"]["m42"];?> <i class="fa fa-star"></i></label>
			<input type="text" name="sh_address" class="form-control" value="<?php if (isset($_POST["sh_address"])) echo $_POST["sh_address"];?>" placeholder="<?php echo $tlec["shop"]["m42"];?>" />
		</div>
		<div class="form-group">
		<label class="control-label" for="sh_city"><?php echo $tlec["shop"]["m43"];?> <i class="fa fa-star"></i></label>
			<div class="row">
			<div class="col-md-6">
			<input type="text" name="sh_city" class="form-control" value="<?php if (isset($_POST["sh_city"])) echo $_POST["sh_city"];?>" placeholder="<?php echo $tlec["shop"]["m43"];?>">
			</div>
			<div class="col-md-6">
			<input type="text" name="sh_postal" class="form-control" value="<?php if (isset($_POST["sh_postal"])) echo $_POST["sh_postal"];?>" placeholder="<?php echo $tlec["shop"]["m44"];?>">
			</div>
			</div>
		</div>
		<div class="form-group">
		<label class="control-label" for="sh_country"><?php echo $tlec["shop"]["m45"];?> <i class="fa fa-star"></i></label>
			<select name="sh_country" id="sh_country-tax" class="form-control">
				<option value="0"><?php echo $tl["cmsg"]["c12"];?></option>
				<?php echo $getcountry;?>
			</select>
		</div>
		<div class="well well-sm">
			<?php echo $tl["contact"]["n"];?> <?php echo $tl["contact"]["n1"];?> <i class="fa fa-star"></i> <?php echo $tl["contact"]["n2"];?>
		</div>
		
		</div>
		
		<?php } ?>
		
		 <input type="hidden" name="checkout" value="1" />
		 <!-- Action Buttons -->
		 <div class="pull-right">
		 	<div class="well well-sm">
		 	<div class="checkbox"><label><input type="checkbox" name="jak_agree" value="1"> <i class="fa fa-hand-paper-o"></i> <?php echo $tlec["shop"]["m22"];?> (<a href="<?php echo $AGREEMENT_URL;?>" class="lagree"><?php echo $AGREEMENT_NAME;?></a>)</label></div>
		 	</div>
		 	<?php if (isset($JAK_ECOMMERCE_CART) && isset($payment_option) && is_array($payment_option)) foreach($payment_option as $po) { echo $po["paybtn"]; } ?>
		 </div>
		 <div class="clearfix"></div>
		 
		 </form>
		   
	</div>
<div class="col-md-6">

<?php if (!JAK_USERID) { ?>
<?php if (isset($_SESSION['password_recover'])) {

	echo '<div class="alert alert-success"><h4>'.$tl['login']['l7'].'</h4></div>';

} ?>

<h3><?php echo $tl["general"]["g146"];?></h3>
		<?php if (isset($errorlo) && !empty($errorlo)) { ?>
		<div class="alert alert-danger">
			<?php if (isset($errorlo["e"])) echo $errorlo["e"];?>
		</div>
		<?php } ?>
			<form role="form" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
			<div class="form-group<?php if (isset($errorlo)) echo " error";?>">
			    <label class="control-label" for="username"><?php echo $tl["login"]["l1"];?></label>
				<input type="text" class="form-control" name="jakU" id="username" value="<?php if (isset($_REQUEST["jakU"])) echo $_REQUEST["jakU"];?>" placeholder="<?php echo $tl["login"]["l1"];?>">
			</div>
			<div class="form-group<?php if (isset($errorlo)) echo " error";?>">
			    <label class="control-label" for="password"><?php echo $tl["login"]["l2"];?></label>
				<input type="password" class="form-control" name="jakP" id="password" placeholder="<?php echo $tl["login"]["l2"];?>">
			</div>
			<div class="checkbox">
				<label>
			    	<input type="checkbox" name="lcookies" value="1"> <?php echo $tl["general"]["g7"];?>
			    </label>
			</div>
			<button type="submit" name="login" class="btn btn-primary btn-block"><?php echo $tl["general"]["g146"];?></button>
			</form>

		<hr>
		<form role="form" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
		<h3><?php echo $tl["title"]["t14"];?></h3>
		<?php if (isset($errorfp) && !empty($errorfp)) { ?><div class="alert alert-danger"><?php if (isset($errorfp["e"])) echo $errorfp["e"];?></div><?php } ?>
			<div class="form-group<?php if (isset($errorfp)) echo " error";?>">
			    <label class="control-label" for="email"><?php echo $tl["login"]["l5"];?></label>
					<input type="email" class="form-control" name="jakE" id="email" class="form-control" placeholder="<?php echo $tl["login"]["l5"];?>">
			</div>
		<button type="submit" name="forgotP" class="btn btn-info btn-block"><?php echo $tl["general"]["g178"];?></button>
		</form>
		
<?php } else { ?>
	<h3><?php echo sprintf($tl["general"]["g8"], $JAK_USERNAME);?></h3>
	<p><a href="<?php echo $P_USR_LOGOUT;?>" class="btn btn-danger btn-block"><?php echo $tl["title"]["t6"];?></a></p>
<?php } ?>
			    
</div>
</div>
			    
<?php } ?>

<script type="text/javascript">
	jakWeb.jak_country = "<?php echo $jkv["e_country"];?>";
	jakWeb.jak_msg_shop = "<?php echo $tlec["shop"]["m63"];?>";
	jakWeb.jak_msg_shop1 = "<?php echo $tlec["shop"]["m64"];?>";
	jakWeb.jak_msg_shop2 = "<?php echo $tlec["shop"]["e8"];?>";
	jakWeb.jak_msg_shop3 = "checkout";

$(document).ready(function() {
	
	$('.lagree').on('click', function(e) {
		e.preventDefault();
		frameSrc = $(this).attr("href");
		$('#JAKModalLabel').html("<?php echo $AGREEMENT_NAME;?>");
		$('#JAKModal').on('show.bs.modal', function () {
		  	$('#JAKModal .modal-body').html('<iframe src="'+frameSrc+'" width="100%" height="400" frameborder="0">');
		});
		$('#JAKModal').on('hidden.bs.modal', function() {
			$('#JAKModal .modal-body').html("");
		});
		$('#JAKModal').modal({show:true});
	});
	
});
</script>

<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/footer.php';?>