<?php include_once APP_PATH.'admin/template/header.php';?>

<?php if ($page1 == "s") { ?>
<div class="alert alert-success fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?php echo $tl["general"]["g7"];?>
</div>
<?php } if ($page1 == "e" || $page1 == "ene") { ?>
<div class="alert alert-danger fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?php echo ($page1 == "e" ? $tl["errorpage"]["sql"] : $tl["errorpage"]["not"]);?>
</div>
<?php } ?>

<?php if ($errors) { ?>
<div class="alert alert-danger fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?php if (isset($errors["e"])) echo $errors["e"];
		  if (isset($errors["e1"])) echo $errors["e1"];
		  if (isset($errors["e2"])) echo $errors["e2"];
		  if (isset($errors["e3"])) echo $errors["e3"];?>
 </div>
<?php } ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<div class="box box-default">
  <div class="box-header with-border">
  <i class="fa fa-plus-square"></i>
    <h3 class="box-title"><?php echo $lrf["register"]["r2"];?></h3>
  </div><!-- /.box-header -->
<div class="box-body">
<ul class="cform_drag">
	<li id="cform_drag" class="ui-state-highlight big-drag">
		    <div class="row">
		    	<div class="col-md-4">
		    	<?php echo $tl["cform"]["c6"];?> <input type="text" class="form-control jakread" readonly="readonly" name="jak_option[]">
		    	</div>
		    	<div class="col-md-2">
		    	<?php echo $tl["cform"]["c7"];?> <select name="jak_optiontype[]" class="form-control">
		    	<option value="1"><?php echo $tl["cform"]["c10"];?></option>
		    	<option value="2"><?php echo $tl["cform"]["c11"];?></option>
		    	<option value="3"><?php echo $tl["cform"]["c12"];?></option>
		    	<option value="4"><?php echo $tl["cform"]["c13"];?></option>
		    	</select>
		    	</div>
		    	<div class="col-md-3">
		    	<?php echo $tl["cform"]["c8"];?> <input type="text" class="form-control jakread" readonly="readonly" value="female,male" name="jak_options[]">
		    	</div>
		    	<div class="col-md-2">
		    	<?php echo $tl["cform"]["c9"];?> <select name="jak_optionmandatory[]" class="form-control">
		    	<option value="0"><?php echo $tl["general"]["g19"];?></option>
		    	<option value="1"><?php echo $tl["general"]["g18"];?></option>
		    	<option value="2"><?php echo $tl["cform"]["c16"];?></option>
		    	<option value="3"><?php echo $tl["cform"]["c17"];?></option>
		    	<option value="4"><?php echo $lrf["register"]["r11"];?></option>
		    	<option value="5"><?php echo $lrf["register"]["r13"];?></option>
		    	</select>
		    	<input type="hidden" name="jak_optionsort[]" class="cforder-orig" value="" />
		    	</div>	
		    </div>
	</li>
</ul>

<div class="callout callout-info">
	<i class="fa fa-arrow-up"></i> <?php echo $tl["cform"]["c21"];?> <i class="fa fa-arrow-down"></i>
</div>

<ul id="cform_sort">

<?php if (isset($JAK_REGISTEROPTION_ALL) && is_array($JAK_REGISTEROPTION_ALL)) foreach($JAK_REGISTEROPTION_ALL as $o) { ?>

	<li class="jakcform">
		<div class="row">
		    <div class="col-md-3">
		    	<?php echo $tl["cform"]["c6"];?> <input type="text" class="form-control" name="jak_option_old[]" value="<?php echo $o["name"];?>">
		    </div>
		    <div class="col-md-2">
		    	<?php echo $tl["cform"]["c7"];?> <select name="jak_optiontype_old[]" class="form-control">
		    	<option value="1"<?php if ($o["typeid"] == 1) { ?> selected="selected"<?php } ?>><?php echo $tl["cform"]["c10"];?></option>
		    	<option value="2"<?php if ($o["typeid"] == 2) { ?> selected="selected"<?php } ?>><?php echo $tl["cform"]["c11"];?></option>
		    	<option value="3"<?php if ($o["typeid"] == 3) { ?> selected="selected"<?php } ?>><?php echo $tl["cform"]["c12"];?></option>
		    	<option value="4"<?php if ($o["typeid"] == 4) { ?> selected="selected"<?php } ?>><?php echo $tl["cform"]["c13"];?></option>
		    	</select>
		    </div>
		    <div class="col-md-3">
		    	<?php echo $tl["cform"]["c8"];?> <input type="text" name="jak_options_old[]" class="form-control" value="<?php echo $o["options"];?>" placeholder="<?php echo $lrf["register"]["r14"];?>">
		    </div>
		    <div class="col-md-2">
		    	<?php echo $tl["cform"]["c9"];?> <select name="jak_optionmandatory_old[]" class="form-control">
		    	<option value="0"<?php if ($o["mandatory"] == 0) { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g19"];?></option>
		    	<option value="1"<?php if ($o["mandatory"] == 1) { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g18"];?></option>
		    	<option value="2"<?php if ($o["mandatory"] == 2) { ?> selected="selected"<?php } ?>><?php echo $tl["cform"]["c16"];?></option>
		    	<option value="3"<?php if ($o["mandatory"] == 3) { ?> selected="selected"<?php } ?>><?php echo $tl["cform"]["c17"];?></option>
		    	<option value="4"<?php if ($o["mandatory"] == 4) { ?> selected="selected"<?php } ?>><?php echo $lrf["register"]["r11"];?></option>
		    	<option value="5"<?php if ($o["mandatory"] == 5) { ?> selected="selected"<?php } ?>><?php echo $lrf["register"]["r13"];?></option>
		    	</select>
		    </div>
		    <div class="col-md-1">
		    	<i class="fa fa-user-plus"></i> <select name="jak_showregister[]" class="form-control">
		    	<option value="0"<?php if ($o["showregister"] == 0) { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g19"];?></option>
		    	<option value="1"<?php if ($o["showregister"] == 1) { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g18"];?></option>
		    	</select>
		    </div>
		    <div class="col-md-1">
		    	<?php if ($o["id"] > 3) { ?>
		    	<div class="checkbox">
		    		<label>
		    			<input type="checkbox" name="jak_sod[]" value="<?php echo $o["id"];?>"> <i class="fa fa-trash-o"></i>
		    		</label> 
		    	</div>
		    	<?php } ?>
		    	<input type="hidden" name="jak_option_name_old[]" value="<?php echo $o["name"];?>" />
		    	<input type="hidden" name="jak_optionsort_old[]" class="cforder" value="<?php echo $o["forder"];?>" />
		    	<input type="hidden" name="jak_optionid[]" value="<?php echo $o["id"];?>" />
		    </div>
		</div>
	</li>

<?php } ?>

 </ul>

</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>

</form>
		
<?php include_once APP_PATH.'admin/template/footer.php';?>