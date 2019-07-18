<?php if ($jkv["showloginside"]) { if (!JAK_USERID) { ?>
<?php if (isset($_SESSION['password_recover'])) {

	echo '<div class="alert alert-success"><h4>'.$tl['login']['l7'].'</h4></div>';

} ?>
		<div class="loginF">
		<h3><?php echo $tl["general"]["g146"];?></h3>
		<?php if ($errorlo) { ?>
		<div class="alert alert-info">
			<a class="lost-pwd" href="<?php echo $JAK_FORGOT_PASS_LINK;?>"><i class="fa fa-share-alt"></i> <?php echo $tl["error"]["f"];?></a>
		</div>
		<?php } if ($errorlo) { ?>
		<div class="alert alert-danger">
			<?php echo $errorlo["e"];?>
		</div>
		<?php } ?>
		<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
			<div class="form-group<?php if ($errorlo) echo " has-error";?>">
			    <label class="control-label" for="username"><?php echo $tl["login"]["l1"];?></label>
			    <input type="text" name="jakU" id="username" class="form-control" value="<?php echo $_REQUEST["jakU"];?>" placeholder="<?php echo $tl["login"]["l1"];?>" />
			</div>
			<div class="form-group<?php if ($errorlo) echo " has-error";?>">
			    <label class="control-label" for="password"><?php echo $tl["login"]["l2"];?></label>
				<input type="password" name="jakP" id="password" class="form-control" value="" placeholder="<?php echo $tl["login"]["l2"];?>" />
			</div>
			<div class="checkbox">
				<label><input type="checkbox" name="lcookies" value="1"> <?php echo $tl["general"]["g7"];?></label>
			</div>
			<button type="submit" name="login" class="btn btn-success btn-block"><?php echo $tl["general"]["g146"];?></button>
		</form>
		</div>
		<div class="forgotP">
		<h3><?php echo $tl["title"]["t14"];?></h3>
		<div class="alert alert-warning">
			<a class="lost-pwd" href="#"><i class="fa fa-lightbulb-o"></i> <?php echo $tl["title"]["t16"];?></a>
		</div>
		<?php if ($errorfp) { ?><div class="alert alert-danger"><?php echo $errorfp["e"];?></div><?php } ?>
		<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
			<div class="form-group<?php if ($errorfp) echo " has-error";?>">
			    <label class="control-label" for="email"><?php echo $tl["login"]["l5"];?></label>
				<input type="text" name="jakE" id="email" class="form-control" value="" placeholder="<?php echo $tl["login"]["l5"];?>" />
			</div>
		<button type="submit" name="forgotP" class="btn btn-info btn-block"><?php echo $tl["general"]["g178"];?></button>
		</form>
		</div>
		
		<script type="text/javascript">
		
		$(document).ready(function() {
			
			// Switch buttons from "Log In | Register" to "Close Panel" on click
			$(".lost-pwd").click(function(e) {
				e.preventDefault();
				$(".loginF").slideToggle();
				$(".forgotP").slideToggle();
			});
			
			<?php if ($errorfp) { ?>
				$(".loginF").hide();
				$(".forgotP").show();
			<?php } ?>
				
		});
		
		</script>
		
		<?php } else { ?>
		<h3><?php echo str_replace("%s", $JAK_USERNAME, $tl["general"]["g8"]);?></h3>
		<p><a href="<?php echo $P_USR_LOGOUT;?>" class="btn btn-danger btn-block"><?php echo $tl["title"]["t6"];?></a></p>
		<?php } } ?>