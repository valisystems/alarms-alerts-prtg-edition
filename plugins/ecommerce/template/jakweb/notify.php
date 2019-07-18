<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/header.php';?>

<div class="row">
	<div class="col-md-6">
	<?php if ($ecprice) { ?>
	
	<h2><?php echo $tlec["shop"]["m14"];?></h2>
		
	<div class="well well-sm"><?php echo $tlec["shop"]["m"].$ecprice.'&nbsp;'.$eccurrency;?></div>
		
	    <p>
	    <?php if ($page3 != 10) { ?>
	    	<h3><?php echo $tlec["shop"]["m14"];?></h3>
	    <?php } echo $ecfield.'<br />'.$ecfield1;?>
	    </p>
	    <?php if ($page3 == 10) { ?>
	    <!-- Stripe Payment -->
	    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	    <script
	        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
	        data-key="<?php echo $stripe_key[1];?>"
	        data-image="/plugins/ecommerce/img/stripe_logo.png"
	        data-name="<?php echo $jkv["e_title"];?>"
	        data-description="<?php echo $tlec["shop"]["m"].$ecprice.'&nbsp;'.$eccurrency;?>"
	        data-amount="<?php echo $stripe_amount;?>">
	      </script>
	    </form>
	    <?php } if ($page3 != 10) { ?>
	    <p><?php echo $tlec["shop"]["m7"].'<strong>'.$_SESSION['ECOMMERCE_ORDNR'].'</strong>';?></p>
	
	<?php } } ?>
	</div>
	<div class="col-md-6">
		<div class="well well-sm"><?php echo $jkv["e_thanks"];?></div>
		<?php echo $PAGE_CONTENT;?>
	</div>
</div>
		
<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/footer.php';?>