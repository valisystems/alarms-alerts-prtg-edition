<?php include "header.php";?>

<?php if ($page1 == "s") { ?>
<div class="alert alert-success fade in">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <?php echo $tl["general"]["g7"];?>
</div>
<?php } if ($page1 == "e") { ?>
<div class="alert alert-danger fade in">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <?php echo $tl["errorpage"]["sql"];?>
</div>
<?php } ?>

<?php if ($errors) { ?>
<div class="alert alert-danger fade in">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<?php if (isset($errors["e"])) echo $errors["e"];
		  if (isset($errors["e1"])) echo $errors["e1"];
		  if (isset($errors["e2"])) echo $errors["e2"];?>
</div>
<?php } ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<div class="row">
	<div class="col-md-6">
		<div class="box box-primary">
		  <div class="box-header with-border">
		    <h3 class="box-title"><?php echo $tl["title"]["t2"];?></h3>
		  </div><!-- /.box-header -->
		  <div class="box-body">
		  
		  	<div class="form-group">
		  		<label for="siteonline"><?php echo $tl["site"]["s"];?></label>
				<div class="radio"><label><input type="radio" name="jak_online" id="siteonline" value="1"<?php if ($jkv["offline"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label>
				</div>
				<div class="radio"><label><input type="radio" name="jak_online" value="0"<?php if ($jkv["offline"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label>
				</div>
			</div>
			<div class="form-group">
				<label for="jak_offpage"><?php echo $tl["site"]["s1"];?></label>
				<select name="jak_offpage" class="form-control">
				<option value="0"<?php if ($jkv["offline_page"] == 0) { ?> selected="selected"<?php } ?>><?php echo $tl["title"]["t12"];?></option>
				<?php if (isset($JAK_CAT) && is_array($JAK_CAT)) foreach($JAK_CAT as $c) { if ($c["pluginid"] == '0' && $c["pageid"] > '0') { ?><option value="<?php echo $c["id"];?>"<?php if ($jkv["offline_page"] == $c["id"]) { ?> selected="selected"<?php } ?>><?php echo $c["name"];?></option><?php } } ?>
				</select>
			</div>
			<div class="form-group">
				<label for="jak_pagenotfound"><?php echo $tl["site"]["s7"];?></label>
				<select name="jak_pagenotfound" class="form-control">
				<option value="0"<?php if ($jkv["notfound_page"] == 0) { ?> selected="selected"<?php } ?>><?php echo $tl["title"]["t12"];?></option>
				<?php if (isset($JAK_CAT) && is_array($JAK_CAT)) foreach($JAK_CAT as $nf) { if ($nf["pluginid"] == '0' && $nf["pageid"] > '0') { ?><option value="<?php echo $nf["id"];?>"<?php if ($jkv["notfound_page"] == $nf["id"]) { ?> selected="selected"<?php } ?>><?php echo $nf["name"];?></option><?php } } ?>
				</select>
			</div>
		
			
		</div>
		<div class="box-footer">
		  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
		  </div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="box box-primary">
		  <div class="box-header with-border">
		    <h3 class="box-title"><?php echo $tl["title"]["t3"];?></h3>
		  </div><!-- /.box-header -->
		  <div class="box-body">
		  	<div class="form-group<?php if (isset($errors["e2"])) echo " has-error";?>">
		  		<label for="sitetitle"><?php echo $tl["site"]["s2"];?></label>
		  		<input type="text" name="jak_title" id="sitetitle" class="form-control" value="<?php echo $jkv["title"];?>" />
		  	</div>
		  	
		  	<div class="form-group">
		  		<label for="metadesc"><?php echo $tl["site"]["s3"];?></label>
		  		<input type="text" name="jak_description" id="metadesc" class="form-control" value="<?php echo $jkv["metadesc"];?>" />
		  	</div>
		  	
		  	<div class="form-group">
		  			<label for="metakey"><?php echo $tl["site"]["s4"];?></label>
		  			<input type="text" name="jak_keywords" id="metakey" class="form-control" value="<?php echo $jkv["metakey"];?>" />
		  		</div>
		  		
		  	<div class="form-group">
		  			<label for="metaauthor"><?php echo $tl["site"]["s5"];?></label>
		  			<input type="text" name="jak_author" id="metaauthor" class="form-control" value="<?php echo $jkv["metaauthor"];?>" />
		  		</div>
		  		
		  	<div class="form-group">
		  			<label for="robots"><?php echo $tl["site"]["s6"];?></label>
		  			<div class="radio">
		  			<label>
		  			<input type="radio" name="jak_robots" id="robots" value="1"<?php if ($jkv["robots"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
		  			</label>
		  			</div>
		  			<div class="radio">
		  			<label>
		  			<input type="radio" name="jak_robots" value="0"<?php if ($jkv["robots"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
		  			</label>
		  			</div>
		  		</div>
		  		
		  	<div class="form-group">
		  		<label for="copyright"><?php echo $tl["setting"]["s3"];?></label>
		  		<input type="text" name="jak_copy" id="copyright" class="form-control" value="<?php echo $jkv["copyright"];?>" />
		  	</div>
		  	
		  </div>
		  <div class="box-footer">
		  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
		  </div>
		</div>
	</div>
</div>
</form>
		
<?php include "footer.php";?>