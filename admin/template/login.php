<?php include "header.php";?>

<div class="login-title">
	<h1><?php echo $jkv["title"];?> <small><?php echo $tl["login"]["l3"];?></small></h1>
</div>

<div class="form-signin">
<div class="loginF">
<?php if ($ErrLogin) { ?>
<div class="alert alert-danger lost-pwd">
<?php echo $tl["error"]["f"];?>
</div>
<?php } ?>
<form role="form" id="login_form" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
<div class="form-group has-feedback">
  <input type="text" name="username" class="form-control" id="username" placeholder="<?php echo $tl["login"]["l1"].' '.$tl["general"]["g92"].' '.$tl["login"]["l5"];?>">
  <span class="fa fa-user form-control-feedback"></span>
</div>
<div class="form-group has-feedback">
  <input type="password" name="password" class="form-control" id="password" placeholder="<?php echo $tl["login"]["l2"];?>">
  <span class="fa fa-key form-control-feedback"></span>
</div>
<div class="checkbox">
	<label>
        <input type="checkbox" name="lcookies"> <?php echo $tl["login"]["l4"];?>
    </label>
</div>
      <input type="hidden" name="action" value="login" />
      <button type="submit" name="logID" class="btn btn-primary btn-block"><?php echo $tl["login"]["l3"];?></button>
</form>

</div>

<div class="forgotP hide">
<?php if ($errorfp) { ?><div class="alert alert-danger"><?php echo $errorfp["e"];?></div><?php } ?>
<h4><?php echo $tl["general"]["g47"];?></h4>
<form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post">
<div class="form-group has-feedback">
	<label for="email" class="sr-only"><?php echo $tl["login"]["l5"];?></label>
  	<input type="text" name="jakE" class="form-control" id="email" placeholder="<?php echo $tl["login"]["l5"];?>">
  	<span class="fa fa-envelope-o form-control-feedback"></span>
</div>
<button type="submit" name="forgotP" class="btn btn-info btn-block"><?php echo $tl["general"]["g39"];?></button>
</form>
<hr>
<div class="btn btn-warning btn-block lost-pwd"><i class="fa fa-lightbulb-o"></i> <?php echo $tl["general"]["g71"];?></div>
</div>
</div>

<script type="text/javascript">

$(document).ready(function() {
	
	// Switch buttons from "Log In | Register" to "Close Panel" on click
	$(".lost-pwd").click(function(e) {
		e.preventDefault();
		$(this).fadeOut();
		$(".loginF").slideToggle();
		$(".forgotP").toggleClass("hide");
	});
	
	<?php if ($errorfp) { ?>
		$(".loginF").hide();
		$(".forgotP").removeClass("hide");
		$(".forgotP").addClass("shake");
	<?php } if ($ErrLogin) { ?>
		$(".loginF").addClass("shake");
	<?php } ?>
		
});

</script>

<?php include "footer.php";?>