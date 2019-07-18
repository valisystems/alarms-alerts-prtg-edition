<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/header.php';?>
				
	<!-- Heading -->
	<h2 class="first-child text-color"><?php echo $PAGE_TITLE;?></h1>
	<?php echo $PAGE_CONTENT;?>
		
	<article>
		
		<h3 class="text-color"><?php echo $tlnl["nletter"]["d"];?></h3>
		
		<?php if ($errorsnl) { ?>
		
		<div class="alert alert-danger fade in">
		  <button type="button" class="close" data-dismiss="alert">×</button>
		  <h4><?php echo $errorsnl["e"];?></h4>
		</div>
		
		<?php } ?>
		
			<?php if ($NL_MEMBER) { if (!JAK_USERID) { if (isset($_SESSION['password_recover'])) {
				
					echo '<div class="alert alert-success">'.$tl['login']['l7'].'</div>';
				
				} ?>
						<div class="loginF">
						<h4><?php echo $tl["general"]["g146"];?></h4>
						<?php if ($errorlo) { ?><div class="status-failure"><?php echo $errorlo["e"];?></div><?php } ?>
						<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
							<div class="form-group<?php if ($errorlo) echo " has-error";?>">
							<input type="text" name="jakU" id="username" maxlength="20" class="form-control" value="" placeholder="<?php echo $tl["login"]["l1"];?>" />
							</div>
							<div class="form-group<?php if ($errorlo) echo " has-error";?>">
							<input type="password" name="jakP" id="password" maxlength="18" class="form-control" value="" placeholder="<?php echo $tl["login"]["l2"];?>" />
							</div>
							<div class="form-group<?php if ($errornl) echo " has-error";?>">
							    <label class="control-label" for="lcookies"><?php echo $tl["general"]["g7"];?></label>
							    <div class="controls">
									<input type="radio" name="lcookies" value="1" /> <?php echo $tl["general"]["g98"];?> <input type="radio" name="lcookies" value="0" checked="checked" />
								</div>
							</div>
						<button type="submit" name="login" class="btn btn-default"><?php echo $tl["general"]["g83"];?></button>
						</form>
						<?php if ($errorlo) { ?>
						<a class="lost-pwd" href="<?php echo $JAK_FORGOT_PASS_LINK;?>"><?php echo $tl["error"]["f"];?></a>
						<?php } ?>
						</div>
						<div class="forgotP">
						<h4><?php echo $tl["title"]["t14"];?></h4>
						<?php if ($errorfp) { ?><div class="status-failure"><?php echo $errorfp["e"];?></div><?php } ?>
						<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
							<div class="form-group<?php if ($errorfp) echo " has-error";?>">
								<input type="text" name="jakE" id="email" class="form-control" value="" placeholder="<?php echo $tl["login"]["l5"];?>" />
							</div>
						<button type="submit" name="forgotP" class="btn btn-default"><?php echo $tl["general"]["g83"];?></button>
						</form>
						<a class="lost-pwd" href="#"><?php echo $tl["title"]["t16"];?></a>
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
							<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
							
							<?php if ($row['newsletter'] == 1) { ?>
								<input type="submit" name="nlOff" class="button" value="<?php echo $tlnl["nletter"]["d1"];?>" />
							<?php } else { ?>
								<input type="submit" name="nlOn" class="button" value="<?php echo $tlnl["nletter"]["d3"];?>" />
							<?php } ?>	
							
							</form>
			
			<?php } } else { ?>
		
			    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
			    	<div class="form-group<?php if ($errorsnl) echo " has-error";?>">
			    	    <label class="control-label" for="nlEmail"><?php echo $tl["contact"]["c2"];?></label>
			    	    <div class="controls">
			    			<input type="text" class="form-control" name="nlEmail" id="nlEmail" value="" placeholder="<?php echo $tl["contact"]["c2"];?>" />
			    		</div>
			    	</div>
			    	<button type="submit" name="nlOff" class="btn btn-default"><?php echo $tl["general"]["g10"];?></button>
			    </form>
		    
		    <?php } ?>
		
		</article>
		
<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/footer.php';?>