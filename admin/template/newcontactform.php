<?php include "header.php";?>

<?php if ($page2 == "e") { ?>
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
    	<?php include_once "title_new.php";?>
    	</td>
    </tr>
    <tr>
    	<td><?php echo $tl["page"]["p3"];?></td>
    	<td>
    	<div class="radio">
    	<label>
    	<input type="radio" name="jak_showtitle" value="1"<?php if (isset($_REQUEST["showtitle"]) && $_REQUEST["showtitle"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
    	</label>
    	</div>
    	<div class="radio">
    	<label>
    	<input type="radio" name="jak_showtitle" value="0"<?php if (isset($_REQUEST["showtitle"]) && $_REQUEST["showtitle"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
    	</label>
    	</div>
    	</td>
    </tr>
    <tr>
    	<td><?php echo $tl["cform"]["c20"];?></td>
    	<td>
    	<div class="form-group<?php if (isset($errors["e1"])) echo " has-error";?>">
    		<input class="form-control" type="text" name="jak_email" value="<?php if (isset($_REQUEST["jak_email"])) echo $_REQUEST["jak_email"]; ?>" placeholder="email@domain.com,email1@domain.com,email2@domain.com" />
    	</div>
    	</td>
    </tr>
    <tr>
    	<td><?php echo $tl["cform"]["c3"];?></td>
    	<td><?php include_once "editorlight_new.php";?></td>
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
        <h3 class="box-title"><?php echo $tl["cform"]["c"];?></h3>
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
    		    <div class="col-md-5">
    		    	<div class="form-group">
    		    		<?php echo $tl["cform"]["c8"];?> <input type="text" class="form-control jakread" readonly="readonly" name="jak_options[]" value="female,male" />
    		    	</div>
    		    </div>
    		    <input type="hidden" name="jak_optionsort[]" class="cforder-orig" value="" />
    		</div>	
    	</li>
    </ul>
    
    <div class="callout callout-info">
    	<i class="fa fa-arrow-up"></i> <?php echo $tl["cform"]["c21"];?> <i class="fa fa-arrow-down"></i>
    </div>
    
    <ul id="cform_sort">
    	<li class="jakcform">
    		<div class="row">
    			<div class="col-md-3">
    				<div class="form-group">
    		    	<?php echo $tl["cform"]["c6"];?> <input type="text" class="form-control" name="jak_option[]" value="" />
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
    		    <div class="col-md-5">
    		    	<div class="form-group">
    		    	<?php echo $tl["cform"]["c8"];?> <input type="text" class="form-control" name="jak_options[]" value="" />
    		    	<input type="hidden" name="jak_optionsort[]" class="cforder" value="" />
    		   		</div>
    		   	</div>
    		  </div>
    	</li>
    </ul>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
</form>
		
<?php include "footer.php";?>