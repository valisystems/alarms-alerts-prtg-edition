<?php if ($jkv["showloginside"]) { ?>
<aside class="sidebar">
<?php if (!JAK_USERID) { ?>
<?php if (isset($_SESSION['password_recover'])) {

	echo '<div class="alert alert-success"><h4>'.$tl['login']['l7'].'</h4></div>';

} ?>
		<div class="loginF">
		<h4><?php echo $tl["general"]["g146"];?></h4>
		<?php if ($errorlo) { ?>
		<div class="alert alert-danger">
			<?php if (isset($errorlo["e"])) echo $errorlo["e"];?>
		</div>
		<?php } ?>
		<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
			<div class="form-group<?php if (isset($errorlo["e"])) echo " has-error";?>">
			    <label class="control-label" for="username"><?php echo $tl["login"]["l1"];?></label>
				<input type="text" class="form-control" name="jakU" id="username" value="<?php if (isset($_REQUEST["jakU"])) echo $_REQUEST["jakU"];?>" placeholder="<?php echo $tl["login"]["l1"];?>" />
			</div>
			<div class="form-group<?php if (isset($errorlo["e"])) echo " has-error";?>">
			    <label class="control-label" for="password"><?php echo $tl["login"]["l2"];?></label>
				<input type="password" class="form-control" name="jakP" id="password" placeholder="<?php echo $tl["login"]["l2"];?>" />
			</div>
			<div class="checkbox">
				<label>
			    	<input type="checkbox" name="lcookies" value="1"> <?php echo $tl["general"]["g7"];?>
			    </label>
			</div>
			<button type="submit" name="login" class="btn btn-success btn-block"><?php echo $tl["general"]["g146"];?></button>
		</form>
		</div>
		
		<h4><?php echo $tl["title"]["t14"];?></h4>
		<div class="forgotP">
		<?php if ($errorfp) { ?><div class="alert alert-danger"><?php if (isset($errorfp["e"])) echo $errorfp["e"];?></div><?php } ?>
		<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
			<div class="form-group<?php if (isset($errorfp["e"])) echo " error";?>">
			    <label class="control-label" for="email"><?php echo $tl["login"]["l5"];?></label>
					<input type="email" class="form-control" name="jakE" id="email" class="form-control" placeholder="<?php echo $tl["login"]["l5"];?>" />
			</div>
		<button type="submit" name="forgotP" class="btn btn-warning btn-block"><?php echo $tl["general"]["g178"];?></button>
		<div class="clearfix"></div>
		</form>
		</div>
		
		<?php } else { ?>
		<h4><?php echo sprintf($JAK_USERNAME, $tl["general"]["g8"]);?></h4>
		<p><a href="<?php echo $P_USR_LOGOUT;?>" class="btn btn-danger pull-right"><?php echo $tl["title"]["t6"];?></a></p>
		<div class="clearfix"></div>
		<?php } ?>
</aside>
<?php } ?>