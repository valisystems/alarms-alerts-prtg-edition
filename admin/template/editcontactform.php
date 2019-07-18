<?php include "header.php";?>

<?php if ($page3 == "s") { ?>
<div class="alert alert-success fade in">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <?php echo $tl["general"]["g7"];?>
</div>
<?php } if ($page3 == "e") { ?>
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
		  if (isset($errors["e2"])) echo $errors["e2"];
		  if (isset($errors["e3"])) echo $errors["e3"];?>
</div>
<?php } ?>

<form role="form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["title"]["t14"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
    <table class="table table-striped">
    <tr>
    	<td><?php echo $tl["cform"]["c2"];?></td>
    	<td>
    	<?php include_once "title_edit.php";?>
    	</td>
    </tr>
    <tr>
    	<td><?php echo $tl["page"]["p3"];?></td>
    	<td>
    	<div class="radio">
    	<label>
    	<input type="radio" name="jak_showtitle" value="1"<?php if ($JAK_FORM_DATA["showtitle"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
    	</label>
    	</div>
    	<div class="radio">
    	<label>
    	<input type="radio" name="jak_showtitle" value="0"<?php if ($JAK_FORM_DATA["showtitle"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
    	</label>
    	</div>
    	</td>
    </tr>
    <tr>
    	<td><?php echo $tl["cform"]["c20"];?></td>
    	<td>
    	<div class="form-group<?php if (isset($errors["e3"])) echo " has-error";?>">
    		<input type="text" name="jak_email" class="form-control" value="<?php echo $JAK_FORM_DATA["email"];?>" placeholder="email@domain.com,email1@domain.com,email2@domain.com" />
    	</div>
    	</td>
    </tr>
    <tr>
    	<td><?php echo $tl["cform"]["c3"];?></td>
    	<td><?php include_once "editorlight_edit.php";?></td>
    </tr>
    </table>
    </div>
    	<div class="box-footer">
    	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
    	</div>
    </div>
    
    <div class="box box-default">
      <div class="box-header with-border">
      <i class="fa fa-plus-square"></i>
        <h3 class="box-title"><?php echo $tl["cform"]["c15"];?></h3>
      </div><!-- /.box-header -->
    <div class="box-body">
    
    <ul class="cform_drag">
    	<li id="cform_drag" class="ui-state-highlight big-drag">
    		<div class="row">
    		<div class="col-md-3">
    		<div class="form-group">
    		    	<?php echo $tl["cform"]["c6"];?> <input type="text" class="form-control jakread" readonly="readonly" name="jak_option[]" value="" />
    		 </div>
    		 </div>
    		 <div class="col-md-2">
    		 <div class="form-group">
    		 	<?php echo $tl["cform"]["c9"];?> <select name="jak_optionmandatory[]" class="form-control"><option value="0"><?php echo $tl["general"]["g19"];?></option><option value="1"><?php echo $tl["general"]["g18"];?></option><option value="2"><?php echo $tl["cform"]["c16"];?></option><option value="3"><?php echo $tl["cform"]["c17"];?></option></select>
    		 </div>
    		 </div>
    		 <div class="col-md-2">
    		 	<div class="form-group">
    		 	<?php echo $tl["cform"]["c7"];?> <select name="jak_optiontype[]" class="form-control">
    		 	<option value="1"><?php echo $tl["cform"]["c10"];?></option>
    		 	<option value="2"><?php echo $tl["cform"]["c11"];?></option>
    		 	<option value="3"><?php echo $tl["cform"]["c12"];?></option>
    		 	<option value="4"><?php echo $tl["cform"]["c13"];?></option>
    		 	<option value="5"><?php echo $tl["cform"]["c14"];?></option>
    		 	<option value="6"><?php echo $tl["cform"]["c19"];?></option>
    		 	<option value="7"><?php echo $tl["cform"]["c23"];?></option>
    		 	</select>
    		 	</div>
    		 </div>
    		 <div class="col-md-4">
    		    	<?php echo $tl["cform"]["c8"];?> <input type="text" name="jak_options[]" class="form-control jakread" readonly="readonly" value="female,male" />
    		 </div>
    		 <input type="hidden" name="jak_optionsort[]" class="cforder-orig" value="" />
    		 </div>
    	</li>
    </ul>
    
    <div class="callout callout-info">
    	<i class="fa fa-arrow-up"></i> <?php echo $tl["cform"]["c21"];?> <i class="fa fa-arrow-down"></i>
    </div>
    
    <ul id="cform_sort">
    
    <?php if (isset($JAK_CONTACTOPTION_ALL) && is_array($JAK_CONTACTOPTION_ALL)) foreach($JAK_CONTACTOPTION_ALL as $o) { ?>
    
    	<li class="jakcform">
    		<div class="row">
    			<div class="col-md-3">
    			<div class="form-group">
    		    	<?php echo $tl["cform"]["c6"];?> <input type="text" class="form-control" name="jak_option_old[]" value="<?php echo $o["name"];?>" />
    			</div>
    		</div>
    		<div class="col-md-2">
    			<div class="form-group">
    		    <?php echo $tl["cform"]["c9"];?> <select name="jak_optionmandatory_old[]" class="form-control"><option value="0"<?php if ($o["mandatory"] == 0) { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g19"];?></option><option value="1"<?php if ($o["mandatory"] == 1) { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g18"];?></option><option value="2"<?php if ($o["mandatory"] == 2) { ?> selected="selected"<?php } ?>><?php echo $tl["cform"]["c16"];?></option><option value="3"<?php if ($o["mandatory"] == 3) { ?> selected="selected"<?php } ?>><?php echo $tl["cform"]["c17"];?></option></select>
    		    </div>
    		</div>
    		<div class="col-md-2">
    			<div class="form-group">
    		    	<?php echo $tl["cform"]["c7"];?> <select name="jak_optiontype_old[]" class="form-control">
    		    	<option value="1"<?php if ($o["typeid"] == 1) { ?> selected="selected"<?php } ?>><?php echo $tl["cform"]["c10"];?></option>
    		    	<option value="2"<?php if ($o["typeid"] == 2) { ?> selected="selected"<?php } ?>><?php echo $tl["cform"]["c11"];?></option>
    		    	<option value="3"<?php if ($o["typeid"] == 3) { ?> selected="selected"<?php } ?>><?php echo $tl["cform"]["c12"];?></option>
    		    	<option value="4"<?php if ($o["typeid"] == 4) { ?> selected="selected"<?php } ?>><?php echo $tl["cform"]["c13"];?></option>
    		    	<option value="5"<?php if ($o["typeid"] == 5) { ?> selected="selected"<?php } ?>><?php echo $tl["cform"]["c14"];?></option>
    		    	<option value="6"<?php if ($o["typeid"] == 6) { ?> selected="selected"<?php } ?>><?php echo $tl["cform"]["c19"];?></option>
    		    	<option value="7"<?php if ($o["typeid"] == 7) { ?> selected="selected"<?php } ?>><?php echo $tl["cform"]["c23"];?></option>
    		    	</select>
    		    	
    		    </div>
    		 </div>
    		 <div class="col-md-4">
    		 	<?php echo $tl["cform"]["c8"];?> <input type="text" name="jak_options_old[]" value="<?php echo $o["options"];?>" class="form-control" />
    		 </div>
    		 <div class="col-md-1">
    		 	<div class="checkbox">
    		    	<label>
    		    		<input type="checkbox" name="jak_sod[]" value="<?php echo $o["id"];?>" /> <i class="fa fa-trash-o"></i>
    		    	</label>
    		    </div>
    		 </div>
    		 	<input type="hidden" name="jak_optionsort_old[]" class="cforder" value="<?php echo $o["forder"];?>" />
    		 	<input type="hidden" name="jak_optionid[]" value="<?php echo $o["id"];?>" />
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
		
<?php include "footer.php";?>