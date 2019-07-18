<?php if ($jkv["rf_active"] && isset($JAK_SHOW_R_FORM)) { ?>
<div class="row">
	<div class="col-md-6">
		<?php if (!JAK_USERID) { ?>
		<div class="basic-login">
		<?php if ($errorsC || $errorsA) { ?>
			<div class="alert alert-danger fade in">
			  <button type="button" class="close" data-dismiss="alert">&times;</button>
			
			<?php if (isset($errorsC["e3"])) echo $errorsC["e3"];
			if (isset($errorsC["e4"])) echo $errorsC["e4"];
			if (isset($errorsC["e5"])) echo $errorsC["e5"];
			if (isset($errorsC["e1"])) echo $errorsC["e1"];
			if (isset($errorsC["e2"])) echo $errorsC["e2"];
			
			if (isset($errorsA) && is_array($errorsA)) foreach($errorsA as $i) { echo $i; }
			
			?>
		</div>
		<?php } else if (isset($_SESSION["rf_msg_sent"]) && $_SESSION["rf_msg_sent"] == 1) { ?>
			<div class="alert alert-success fade in">
			  <?php echo $jkv["rf_welcome"];?>
			</div>
		<?php } if (!isset($_SESSION["rf_msg_sent"]) || isset($_SESSION["rf_msg_sent"]) && $_SESSION["rf_msg_sent"] != 1) { ?>
		
			<h3><?php echo $tl["general"]["g57"];?></h3>
			<form method="post" class="cFrom" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data">
			<?php if ($jkv["rf_simple"]) { ?>
				<div class="form-group<?php if (isset($errorsC["e3"])) echo " has-error";?>">
				    <label class="control-label" for="username"><?php echo $tl["login"]["l1"];?> <i class="fa fa-star"></i></label>
				      <input type="text" name="username" id="username" class="form-control" value="<?php if (isset($_REQUEST["username"])) echo $_REQUEST["username"];?>" placeholder="<?php echo $tl["login"]["l1"];?>">
				  </div>
				 <div class="form-group<?php if ($errorsC["e4"]) echo " has-error";?>">
				     <label class="control-label" for="email"><?php echo $tl["contact"]["c2"];?> <i class="fa fa-star"></i></label>
				       <input type="email" name="email" id="email" class="form-control" value="<?php if (isset($_REQUEST["email"])) echo $_REQUEST["email"];?>" placeholder="<?php echo $tl["contact"]["c2"];?>">
				 </div>
			<?php } else { echo $JAK_SHOW_R_FORM; } ?>
			
				<div class="well well-sm">
					<?php echo $tl["contact"]["n"];?> <?php echo $tl["contact"]["n1"];?> <i class="fa fa-star"></i> <?php echo $tl["contact"]["n2"];?>
				</div>
				<button type="submit" id="formsubmit" name="registerF" class="btn btn-primary pull-right"><?php echo $tl["contact"]["s"];?></button>
				<div class="clearfix"></div>
			</form>
		<?php } ?></div><?php } ?>
		
		<?php if (JAK_USERID) { ?>
		<h3><?php echo sprintf($tl["general"]["g8"], $JAK_USERNAME);?></h3>
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
		<!-- End Testimonial -->			   
		<?php } ?>
		</div>
		<div class="col-md-6">
			<div class="basic-login">
				<?php if (!JAK_USERID) { ?>
				
				<h3><?php echo $tl["general"]["g146"];?></h3>
						<?php if ($errorlo) { ?>
						<div class="alert alert-danger">
							<?php if (isset($errorlo["e"])) echo $errorlo["e"];?>
						</div>
						<?php } ?>
							<form role="form" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
							<div class="form-group<?php if (isset($errorlo)) echo " error";?>">
							    <label class="control-label" for="username"><?php echo $tl["login"]["l22"];?></label>
								<input type="text" class="form-control" name="jakU" id="username" value="<?php if (isset($_REQUEST["jakU"])) echo $_REQUEST["jakU"];?>" placeholder="<?php echo $tl["login"]["l22"];?>">
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
					<p><a href="<?php echo $P_USR_LOGOUT;?>" class="btn btn-danger btn-block"><?php echo $tl["title"]["t6"];?></a></p>
				<?php } ?>
		</div>
	</div>
</div>

<?php if (!JAK_USERID) { ?>	
<script type="text/javascript">
$(document).ready(function() {
	
	<?php if ($jkv["hvm"]) { ?>
		jQuery(document).ready(function() {
			jQuery(".cFrom").append('<input type="hidden" name="<?php echo $random_name;?>" value="<?php echo $random_value;?>" />');
		});
	<?php } ?>
	
	$('.check_password').keyup(function() {
	  passwordStrength($(this).val());
	});
});
</script>
<?php } } ?>