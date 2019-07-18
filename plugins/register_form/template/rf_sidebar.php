<?php if ($jkv["showloginside"]) { ?>
<aside class="sidebar">
<?php if (!JAK_USERID) { if (isset($_SESSION['password_recover'])) {

	echo '<div class="alert alert-success"><h4>'.$tl['login']['l7'].'</h4></div>';

} ?>

		<h4><?php echo $tl["general"]["g146"];?></h4>
		<?php if (isset($errorlo) && !empty($errorlo)) { ?>
		<div class="alert alert-danger">
			<?php if (isset($errorlo["e"])) echo $errorlo["e"];?>
		</div>
		<?php } ?>
		<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
			<div class="form-group<?php if (isset($errorlo["e"])) echo " has-error";?>">
			    <label class="control-label" for="username"><?php echo $tl["login"]["l1"];?></label>
					<input type="text" name="jakU" id="username" class="form-control" value="<?php if (isset($_REQUEST["jakU"])) echo $_REQUEST["jakU"];?>" placeholder="<?php echo $tl["login"]["l1"];?>" />
			</div>
			<div class="form-group<?php if (isset($errorlo["e"])) echo " has-error";?>">
			    <label class="control-label" for="password"><?php echo $tl["login"]["l2"];?></label>
					<input type="password" name="jakP" id="password" class="form-control" value="" placeholder="<?php echo $tl["login"]["l2"];?>" />
			</div>
			<div class="form-group">
			      <div class="checkbox">
			      <label>
			        <input type="checkbox" name="lcookies" value="1"> <?php echo $tl["general"]["g7"];?>
			      </label>
			      </div>
			      <button type="submit" name="login" class="btn btn-success pull-right"><?php echo $tl["general"]["g146"];?></button>
			      <div class="clearfix"></div>
			</div>
		</form>
		<h4><?php echo $tl["title"]["t14"];?></h4>
		<?php if (isset($errorfp) && !empty($errorfp)) { ?><div class="alert alert-danger"><?php if (isset($errorfp["e"])) echo $errorfp["e"];?></div><?php } ?>
		<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
			<div class="form-group<?php if (isset($errorfp["e"])) echo " has-error";?>">
			    <label class="control-label" for="email"><?php echo $tl["login"]["l5"];?></label>
					<input type="email" name="jakE" id="email" class="form-control" value="" placeholder="<?php echo $tl["login"]["l5"];?>" />
			</div>
		<button type="submit" name="forgotP" class="btn btn-warning pull-right"><?php echo $tl["general"]["g178"];?></button>
		<div class="clearfix"></div>
		</form>
		
		<?php } else { ?>
		<h4><?php echo str_replace("%s", $JAK_USERNAME, $tl["general"]["g8"]);?></h4>
		<div class="about">
			<!-- Author Photo -->
			<div class="author-photo">
				<img src="<?php echo BASE_URL.JAK_FILES_DIRECTORY.'/userfiles'.$jakuser->getVar("picture");?>" alt="avatar">
			</div>
			<div class="about-bubble">
				<blockquote>
		    		<!-- Author Info -->
		    		<cite class="author-info">
		    			- <?php echo $tl["contact"]["c1"];?>: <?php echo $jakuser->getVar("name");?><br>
		    			- <?php echo $tl["contact"]["c2"];?>: <?php echo $jakuser->getVar("email");?>
		    		</cite>
		    	</blockquote>
		    	<div class="sprite arrow-speech-bubble"></div>
		    </div>
		</div>
		<p><a href="<?php echo $P_USR_LOGOUT;?>" class="btn btn-danger pull-right"><?php echo $tl["title"]["t6"];?></a></p>
		<div class="clearfix"></div>
		<?php } ?>
</aside>
<?php } ?>