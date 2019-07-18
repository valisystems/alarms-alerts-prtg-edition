<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/header.php';?>
		
<?php if ($errors_rf || $errorsA) { ?>

	<div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<?php if (isset($errors_rf["e"])) echo $errors_rf["e"];
		if (isset($errors_rf["e1"])) echo $errors_rf["e1"];
		if (isset($errors_rf["e2"])) echo $errors_rf["e2"];
		if (isset($errors_rf["e3"])) echo $errors_rf["e3"];
		if (isset($errors_rf["e4"])) echo $errors_rf["e4"];
		if (isset($errors_rf["e5"])) echo $errors_rf["e5"];?>

<?php if (isset($errorsA) && is_array($errorsA)) foreach($errorsA as $i) { echo $i; } ?>

	</div>

<?php } ?>

<div class="row">
	
	<div class="col-md-6">
		<h2 class="first-child text-color"><?php echo $tl["login"]["l12"];?></h2>
				
		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data">
			
			<div class="fileinput fileinput-new" data-provides="fileinput">
			  <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
			  	<img src="<?php echo BASE_URL.JAK_FILES_DIRECTORY.'/userfiles'.$jakuser->getVar("picture");?>" alt="avatar">
			  </div>
			  <div>
			    <span class="btn btn-default btn-file"><span class="fileinput-new"><?php echo $tl["login"]["l12"];?></span><span class="fileinput-exists"><?php echo $tl["general"]["g180"];?></span><input type="file" name="uploadpp" accept="image/*"></span>
			    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput"><?php echo $tl["general"]["g179"];?></a>
			  </div>
			</div>
			
			<button type="submit" name="avatarR" class="btn btn-color"><?php echo $tl["general"]["g10"];?></button>
			<hr>
			<h3 class="text-color"><?php echo $tl["general"]["g181"];?></h3>
			<div class="row text-center">
				<div class="col-xs-2">
					<img src="../<?php echo JAK_FILES_DIRECTORY;?>/userfiles/standard.png" class="img-responsive" alt="standard avatar" />
					<div class="radio"><label><input type="radio" name="avatar" value="/standard.png"<?php if ($jakuser->getVar("picture") == "/standard.png") { ?> checked="checked"<?php } ?> /></label></div>
				</div>
				<div class="col-xs-2">
					<img src="../<?php echo JAK_FILES_DIRECTORY;?>/userfiles/avatar.png" class="img-responsive" alt="avatar" />
					<div class="radio"><label><input type="radio" name="avatar" value="/avatar.png"<?php if ($jakuser->getVar("picture") == "/avatar.png") { ?> checked="checked"<?php } ?> /></label></div>
				</div>
				<div class="col-xs-2">
					<img src="../<?php echo JAK_FILES_DIRECTORY;?>/userfiles/avatar2.png" class="img-responsive" alt="avatar2" />
					<div class="radio"><label><input type="radio" name="avatar" value="/avatar2.png"<?php if ($jakuser->getVar("picture") == "/avatar2.png") { ?> checked="checked"<?php } ?> /></label></div>
				</div>
				<div class="col-xs-2">
					<img src="../<?php echo JAK_FILES_DIRECTORY;?>/userfiles/avatar3.png" class="img-responsive" alt="avatar3" />
					<div class="radio"><label><input type="radio" name="avatar" value="/avatar3.png"<?php if ($jakuser->getVar("picture") == "/avatar3.png") { ?> checked="checked"<?php } ?> /></label></div>
				</div>
				<div class="col-xs-2">
					<img src="../<?php echo JAK_FILES_DIRECTORY;?>/userfiles/avatar4.png" class="img-responsive" alt="avatar4" />
					<div class="radio"><label><input type="radio" name="avatar" value="/avatar4.png"<?php if ($jakuser->getVar("picture") == "/avatar4.png") { ?> checked="checked"<?php } ?> /></label></div>
				</div>
			</div>
				
			<button type="submit" name="avatarS" class="btn btn-color"><?php echo $tl["general"]["g10"];?></button>
				
		</form>
				
	</div>
	
	<div class="col-md-6">
		<h2 class="first-child text-color"><?php echo $tl["login"]["l13"];?></h2>
		
		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data">
			<div class="form-group">
			    <label class="control-label" for="name"><?php echo $tl["contact"]["c1"];?></label>
			      <input type="text" name="name" id="name" class="form-control" value="<?php echo $jakuser->getVar("name");?>">
			  </div>
			 <div class="form-group<?php if (isset($errors_rfs["e1"])) echo " has-error";?>">
			     <label class="control-label" for="email"><?php echo $tl["contact"]["c2"];?> <i class="fa fa-star"></i></label>
			       <input type="email" name="email" id="email" class="form-control" value="<?php echo $jakuser->getVar("email");?>">
			   </div>
		
		<?php echo $regform;?>
		
		<div class="well well-sm">
			<?php echo $tl["contact"]["n"];?> <?php echo $tl["contact"]["n1"];?> <i class="fa fa-star"></i> <?php echo $tl["contact"]["n2"];?>
		</div>
		
		<button type="submit" name="stuffR" class="btn btn-color"><?php echo $tl["general"]["g10"];?></button>
		
		</form>
				
	</div>
		
</div>

<hr>

<div class="row">
	
	<div class="col-md-12">
		<h2 class="first-child text-color"><?php echo $tl["login"]["l8"];?></h2>
		
		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data">
			<div class="form-group<?php if (isset($errors_rfp["e5"])) echo " has-error";?>">
			    <label class="control-label" for="passold"><?php echo $tl["login"]["l2"];?></label>
			      <input type="password" name="passold" id="passold" class="form-control" value="">
			  </div>
			 <div class="form-group<?php if (isset($errors_rfp["e1"])) echo " has-error";?>">
			     <label class="control-label" for="check_password"><?php echo $tl["login"]["l6"];?></label>
			       <input type="password" name="passnew" id="check_password" class="form-control" value="">
			   </div>
			 <div class="form-group<?php if (isset($errors_rfp["e1"])) echo " has-error";?>">
			      <label class="control-label" for="passnewc"><?php echo $tl["login"]["l9"];?></label>
			        <input type="password" name="passnewc" id="passnewc" class="form-control" value="">
			 </div>
			 <hr>
			<div class="progress progress-striped active">
					<div id="jak_pstrength" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
			</div>
		
			<button type="submit" name="email_passR" class="btn btn-color"><?php echo $tl["general"]["g10"];?></button>
		</form>
				
	</div>
		
</div>

<hr>

<script type="text/javascript">
$(document).ready(function(){
	$('#check_password').keyup(function() {
	  passwordStrength($(this).val());
	});
});
</script>
		
<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/footer.php';?>