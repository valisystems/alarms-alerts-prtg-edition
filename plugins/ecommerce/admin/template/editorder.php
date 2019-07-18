<?php include_once APP_PATH.'admin/template/header.php';?>

<?php if ($page4 == "s") { ?>
<div class="alert alert-success fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?php echo $tl["general"]["g7"];?>
</div>
<?php } if ($page4 == "e") { ?>
<div class="alert alert-danger fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?php echo $tl["errorpage"]["sql"];?>
</div>
<?php } ?>

<?php if ($errors) { ?>
<div class="alert alert-danger fade in">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<?php if (isset($errors["e"])) echo $errors["e"];
		  if (isset($errors["e1"])) echo $errors["e1"];
		  if (isset($errors["e2"])) echo $errors["e2"];?>
</div>
<?php } ?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tlec["shop"]["m2"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><?php echo $tlec["shop"]["m41"];?></td>
	<td><input type="text" class="form-control" name="jak_ordernr" value="<?php echo $JAK_FORM_DATA["ordernumber"];?>" /></td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m71"];?></td>
	<td>
	
	<select name="jak_payment" class="form-control">
		<option value="0"<?php if ($JAK_FORM_DATA["paid_method"] == 0) { ?> selected="selected"<?php } ?>><?php echo $tl['general']['g59'];?></option>
		<?php if (isset($JAK_PAYMENT_ALL) && is_array($JAK_PAYMENT_ALL)) foreach($JAK_PAYMENT_ALL as $v) { ?>
		<option value="<?php echo $v["id"];?>"<?php if ($v["id"] == $JAK_FORM_DATA["paid_method"]) { ?> selected="selected"<?php } ?>><?php echo $v["title"];?></option>
	<?php } ?>
	</select>
	
	</td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m15"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e2"])) echo " has-error";?>">
		<input class="form-control" type="text" name="jak_price" value="<?php echo $JAK_FORM_DATA["total_price"];?>" />
	</div></td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m55"];?></td>
	<td><input type="text" class="form-control" name="jak_tax" value="<?php echo $JAK_FORM_DATA["tax"];?>" /></td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m56"];?></td>
	<td><input type="text" class="form-control" name="jak_shipping" value="<?php echo $JAK_FORM_DATA["shipping"];?>" /></td>
</tr>
<tr>
	<td class="go"><?php echo $tlec["shop"]["m81"];?></td>
	<td><select name="jak_freeshipping" class="form-control"><option value="1"<?php if ($JAK_FORM_DATA["freeshipping"] == 1) { ?> selected="selected"<?php } ?>> <?php echo $tl["general"]["g19"];?></option><option value="0"<?php if ($JAK_FORM_DATA["freeshipping"] == 0) { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g18"];?></option></select></td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m11"];?></td>
	<td><input type="text" class="form-control" name="jak_currency" value="<?php echo $JAK_FORM_DATA["currency"];?>" /></td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["m40"];?></td>
	<td><input type="text" class="form-control" name="jak_userid" value="<?php echo $JAK_FORM_DATA["userid"];?>" /></td>
</tr>
<tr>
	<td><?php echo $tl["user"]["u2"];?></td>
	<td><input type="text" class="form-control" name="jak_username" value="<?php echo $JAK_FORM_DATA["username"];?>" /></td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["a"];?></td>
	<td><input type="text" class="form-control" name="jak_company" value="<?php echo $JAK_FORM_DATA["company"];?>" /></td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["a1"];?></td>
	<td><input type="text" class="form-control" name="jak_name" value="<?php echo $JAK_FORM_DATA["name"];?>" /></td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["a2"];?></td>
	<td><input type="text" class="form-control" name="jak_address" value="<?php echo $JAK_FORM_DATA["address"];?>" /></td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["a3"];?></td>
	<td><input type="text" class="form-control" name="jak_city" value="<?php echo $JAK_FORM_DATA["city"];?>" /></td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["a4"];?></td>
	<td><input type="text" class="form-control" name="jak_zip" value="<?php echo $JAK_FORM_DATA["zip_code"];?>" /></td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["a5"];?></td>
	<td><select name="jak_country" class="form-control">
	<option value="0"<?php if (!$JAK_FORM_DATA["country"]) { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g19"].' '.$tlec["shop"]["m51"];?></option>
	<?php echo $JAK_COUNTRY;?>
	</select></td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["a6"];?></td>
	<td><input type="text" class="form-control" name="jak_phone" value="<?php echo $JAK_FORM_DATA["phone"];?>" /></td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["a7"];?></td>
	<td><input type="text" class="form-control" name="jak_email" value="<?php echo $JAK_FORM_DATA["email"];?>" /></td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["a8"].$tlec["shop"]["a"];?></td>
	<td><input type="text" class="form-control" name="jak_sh_company" value="<?php echo $JAK_FORM_DATA["sh_company"];?>" /></td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["a8"].$tlec["shop"]["a1"];?></td>
	<td><input type="text" class="form-control" name="jak_sh_name" value="<?php echo $JAK_FORM_DATA["sh_name"];?>" /></td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["a8"].$tlec["shop"]["a2"];?></td>
	<td><input type="text" class="form-control" name="jak_sh_address" value="<?php echo $JAK_FORM_DATA["sh_address"];?>" /></td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["a8"].$tlec["shop"]["a3"];?></td>
	<td><input type="text" class="form-control" name="jak_sh_city" value="<?php echo $JAK_FORM_DATA["sh_city"];?>" /></td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["a8"].$tlec["shop"]["a4"];?></td>
	<td><input type="text" class="form-control" name="jak_sh_zip" value="<?php echo $JAK_FORM_DATA["sh_zip_code"];?>" /></td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["a8"].$tlec["shop"]["a5"];?></td>
	<td><select name="jak_sh_country" class="form-control">
	<option value="0"<?php if (!$JAK_FORM_DATA["sh_country"]) { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g19"].' '.$tlec["shop"]["m51"];?></option>
	<?php echo $JAK_SHCOUNTRY;?>
	</select></td>
</tr>
<tr>
	<td><?php echo $tlec["shop"]["a8"].$tlec["shop"]["a6"];?></td>
	<td><input type="text" class="form-control" name="jak_sh_phone" value="<?php echo $JAK_FORM_DATA["sh_phone"];?>" /></td>
</tr>
</table>
</div>
<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
	<div class="box box-primary">
	  <div class="box-header with-border">
	    <h3 class="box-title"><?php echo $tlec["shop"]["m31"];?></h3>
	  </div><!-- /.box-header -->
	  <div class="box-body">
<table class="table table-striped">
<?php if (isset($jak_ordered) && is_array($jak_ordered)) foreach($jak_ordered as $jo) { ?>

<tr><td><?php echo $jo["total_item"];?> x <?php echo $jo["title"].' '.$jo["product_option"];?> <span><strong><?php echo $tlec['shop']['m15'].'</strong>: '.$jo["price"].'&nbsp;'.$JAK_FORM_DATA["currency"]; if ($jo["coupon_price"] != "0.00" && $jo["price"] != $jo["coupon_price"]) { echo ' ('.$tlec["shop"]["m86"].$jo["coupon_price"].'&nbsp;'.$JAK_FORM_DATA["currency"].')';}?></span></td></tr>
<?php } ?>

</table>
</div>
</div>
</form>

<?php include_once APP_PATH.'admin/template/footer.php';?>