<?php include_once APP_PATH.'admin/template/header.php';?>

<?php if ($page2 == "e") { ?>
<div class="alert alert-danger fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?php echo $tl["errorpage"]["sql"];?>
</div>
<?php } ?>

<?php if ($errors) { ?>
<div class="alert alert-danger fade in">
	<button type="button" class="close" data-dismiss="alert">×</button>
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
	    <h3 class="box-title"><?php echo $tl["page"]["p"];?></h3>
	  </div><!-- /.box-header -->
	  <div class="box-body">
	<table class="table table-striped">
	<tr>
		<td><?php echo $tlgwl["growl"]["d"];?></td>
		<td>
		<?php include_once APP_PATH."admin/template/title_new.php";?>
		</td>
	</tr>
	<tr>
		<td><?php echo $tl["general"]["g87"];?></td>
		<td>
		<div class="input-group">
			<input type="text" name="jak_img" id="jak_img" class="form-control" value="<?php if (isset($_REQUEST["jak_img"])) echo $_REQUEST["jak_img"];?>" />
			<span class="input-group-btn">
			  <a class="btn btn-info ifManager" type="button" href="../js/editor/plugins/filemanager/dialog.php?type=1&subfolder=&editor=mce_0&lang=eng&fldr=&field_id=jak_img"><?php echo $tl["general"]["g69"];?></a>
			</span>
		</div><!-- /input-group -->
		</td>
	</tr>
	</table>
	</div>
		<div class="box-footer">
		  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
		</div>
	</div>
	
	<div class="box box-default">
	  <div class="box-header with-border">
	    <h3 class="box-title"><?php echo $tl["news"]["n4"];?></h3>
	  </div><!-- /.box-header -->
	  <div class="box-body">
	<table class="table table-striped">
	<tr>
		<td><?php echo $tlgwl["growl"]["d23"];?></td>
		<td>
		
		<div class="form-group<?php if (isset($errors["e2"])) echo " has-error";?>">
		<input type="text" name="jak_datefrom" id="datepickerFrom" class="form-control" value="<?php if (isset($_REQUEST["jak_datefrom"])) echo $_REQUEST["jak_datefrom"];?>" />
		</div>
		
		</td>
	</tr>
	<tr>
		<td><?php echo $tlgwl["growl"]["d24"];?></td>
		<td>
		
		<div class="form-group<?php if (isset($errors["e2"])) echo " has-error";?>">
		<input type="text" name="jak_dateto" id="datepickerTo" class="form-control" value="<?php if (isset($_REQUEST["jak_dateto"])) echo $_REQUEST["jak_dateto"];?>" />
		</div>
		
		</td>
	</tr>
	</table>
	</div>
		<div class="box-footer">
		  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
		</div>
	</div>


		<div class="box box-default">
			  <div class="box-header with-border">
			    <h3 class="box-title"><?php echo $tlgwl["growl"]["d9"];?></h3>
			  </div><!-- /.box-header -->
			  <div class="box-body">
		<table class="table table-striped">
		<tr>
			<td><?php echo $tlgwl["growl"]["d8"];?></td>
			<td>
			<div class="radio"><label>
				<input type="radio" name="jak_all" value="1"<?php if (isset($_REQUEST["jak_all"]) && $_REQUEST["jak_all"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
			</label></div>
			<div class="radio"><label>
				<input type="radio" name="jak_all" value="0"<?php if ((isset($_REQUEST["jak_all"]) && $_REQUEST["jak_all"] == '0') || !isset($_REQUEST["jak_all"])) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
			</label></div>
			</td>
		</tr>
		<tr>
			<td><?php echo $tlgwl["growl"]["d10"];?></td>
			<td>
			<div class="radio"><label>
				<input type="radio" name="jak_cookies" value="1"<?php if (isset($_REQUEST["jak_cookies"]) && $_REQUEST["jak_cookies"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
			</label></div>
			<div class="radio"><label>
				<input type="radio" name="jak_cookies" value="0"<?php if ((isset($_REQUEST["jak_cookies"]) && $_REQUEST["jak_cookies"] == '0') || !isset($_REQUEST["jak_cookies"])) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
			</label></div>
			</td>
		</tr>
		<tr>
			<td><?php echo $tlgwl["growl"]["d22"];?></td>
			<td><select name="jak_cookiestime" class="form-control">
			<?php for ($i = 1; $i <= 99; $i++) { ?>
			<option value="<?php echo $i ?>"<?php if (isset($_REQUEST["jak_cookiestime"]) && $_REQUEST["jak_cookiestime"] == $i) { ?> selected="selected"<?php } ?>><?php echo $i; ?></option>
			<?php } ?>
			</select></td>
		</tr>
		<tr>
			<td><?php echo $tlgwl["growl"]["d11"];?></td>
			<td><select name="jak_dur" class="form-control">
			<option value="3000"<?php if (isset($_REQUEST["jak_dur"]) && $_REQUEST["jak_dur"] == 3000) { ?> selected="selected"<?php } ?>>3</option>
			<option value="4000"<?php if (isset($_REQUEST["jak_dur"]) && $_REQUEST["jak_dur"] == 4000) { ?> selected="selected"<?php } ?>>4</option>
			<option value="5000"<?php if (isset($_REQUEST["jak_dur"]) && $_REQUEST["jak_dur"] == 5000) { ?> selected="selected"<?php } ?>>5</option>
			<option value="6000"<?php if (isset($_REQUEST["jak_dur"]) && $_REQUEST["jak_dur"] == 6000) { ?> selected="selected"<?php } ?>>6</option>
			<option value="7000"<?php if (isset($_REQUEST["jak_dur"]) && $_REQUEST["jak_dur"] == 7000) { ?> selected="selected"<?php } ?>>7</option>
			<option value="8000"<?php if (isset($_REQUEST["jak_dur"]) && $_REQUEST["jak_dur"] == 8000) { ?> selected="selected"<?php } ?>>8</option>
			<option value="9000"<?php if (isset($_REQUEST["jak_dur"]) && $_REQUEST["jak_dur"] == 9000) { ?> selected="selected"<?php } ?>>9</option>
			</select></td>
		</tr>
		<tr>
			<td><?php echo $tlgwl["growl"]["d12"];?></td>
			<td>
			<div class="radio"><label>
				<input type="radio" name="jak_sticky" value="1"<?php if ((isset($_REQUEST["jak_sticky"]) && $_REQUEST["jak_sticky"] == '1') || !isset($_REQUEST["jak_sticky"])) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
			</label></div>
			<div class="radio"><label>
				<input type="radio" name="jak_sticky" value="0"<?php if (isset($_REQUEST["jak_sticky"]) && $_REQUEST["jak_sticky"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
			</label></div>
			</td>
		</tr>
		<tr>
			<td><?php echo $tlgwl["growl"]["d13"];?></td>
			<td><select name="jak_class" class="form-control">
			<option value="top-right"<?php if (isset($_REQUEST["jak_class"]) && $_REQUEST["jak_class"] == "top-right") { ?> selected="selected"<?php } ?>><?php echo $tlgwl["growl"]["d16"];?></option>
			<option value="top-left"<?php if (isset($_REQUEST["jak_class"]) && $_REQUEST["jak_class"] == "top-left") { ?> selected="selected"<?php } ?>><?php echo $tlgwl["growl"]["d14"];?></option>
			<option value="center"<?php if (isset($_REQUEST["jak_class"]) && $_REQUEST["jak_class"] == "center") { ?> selected="selected"<?php } ?>><?php echo $tlgwl["growl"]["d15"];?></option>
			<option value="bottom-left"<?php if (isset($_REQUEST["jak_class"]) && $_REQUEST["jak_class"] == "bottom-left") { ?> selected="selected"<?php } ?>><?php echo $tlgwl["growl"]["d17"];?></option>
			<option value="bottom-right"<?php if (isset($_REQUEST["jak_class"]) && $_REQUEST["jak_class"] == "bottom-right") { ?> selected="selected"<?php } ?>><?php echo $tlgwl["growl"]["d18"];?></option>
			</select></td>
		</tr>
		<tr>
			<td><?php echo $tlgwl["growl"]["d19"];?></td>
			<td>
			<div class="radio"><label>
				<input type="radio" name="jak_color" value="1"<?php if ((isset($_REQUEST["jak_color"]) && $_REQUEST["jak_color"] == '1') || !isset($_REQUEST["jak_color"])) { ?> checked="checked"<?php } ?> /> <?php echo $tlgwl["growl"]["d20"];?>
			</label></div>
			<div class="radio"><label>
				<input type="radio" name="jak_color" value="0"<?php if (isset($_REQUEST["jak_color"]) && $_REQUEST["jak_color"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tlgwl["growl"]["d21"];?>
			</label></div>
			</td>
		</tr>
		</table>
		</div>
			<div class="box-footer">
			  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
			</div>
		</div>
		
	</div>
	<div class="col-md-6">
	
		<div class="box box-info">
		  <div class="box-header with-border">
		    <h3 class="box-title"><?php echo $tlgwl["growl"]["d2"];?> <a class="cms-help" data-content="<?php echo $tl["help"]["h"];?>" href="javascript:void(0)" data-original-title="<?php echo $tl["title"]["t21"];?>"><i class="fa fa-question-circle"></i></a></h3>
		  </div><!-- /.box-header -->
		  <div class="box-body">
		<table class="table">
		<tr>
			<td>
			
			<select name="jak_pageid[]" multiple="multiple" class="form-control">
			
			<option value="0"<?php if (isset($_REQUEST["jak_pageid"]) && $_REQUEST["jak_pageid"] == '0') { ?> selected="selected"<?php } ?>><?php echo $tl["cform"]["c18"];?></option>
			
			<?php if (isset($JAK_PAGES) && is_array($JAK_PAGES)) foreach($JAK_PAGES as $v) { ?>
			
			<option value="<?php echo $v["id"];?>"><?php echo $v["title"];?></option>
			
			<?php } ?>
			</select>
			
			</td>
		</tr>
		</table>
		</div>
			<div class="box-footer">
			  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
			</div>
		</div>
		
		<div class="box box-info">
		  <div class="box-header with-border">
		    <h3 class="box-title"><?php echo $tlgwl["growl"]["d3"];?> <a class="cms-help" data-content="<?php echo $tl["help"]["h"];?>" href="javascript:void(0)" data-original-title="<?php echo $tl["title"]["t21"];?>"><i class="fa fa-question-circle"></i></a></h3>
		  </div><!-- /.box-header -->
		  <div class="box-body">
		<table class="table table-striped">
		<tr>
			<td colspan="2">
			
			<select name="jak_newsid[]" multiple="multiple" class="form-control">
			
			<option value="0"<?php if (isset($_REQUEST["jak_newsid"]) && $_REQUEST["jak_newsid"] == '0') { ?> selected="selected"<?php } ?>><?php echo $tl["cform"]["c18"];?></option>
			
			<?php if (isset($JAK_NEWS) && is_array($JAK_NEWS)) foreach($JAK_NEWS as $n) { ?>
			
			<option value="<?php echo $n["id"];?>"><?php echo $n["title"];?></option>
			
			<?php } ?>
			</select>
			
			</td>
		</tr>
		<tr>
			<td><?php echo $tlgwl["growl"]["d4"];?></td>
			<td>
			<div class="radio"><label>
				<input type="radio" name="jak_mainnews" value="1"<?php if (isset($_REQUEST["jak_mainnews"]) && $_REQUEST["jak_mainnews"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
			</label></div>
			<div class="radio"><label>
				<input type="radio" name="jak_mainnews" value="0"<?php if ((isset($_REQUEST["jak_mainnews"]) && $_REQUEST["jak_mainnews"] == '0') || !isset($_REQUEST["jak_mainnews"])) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
			</label></div>
			</td>
		</tr>
		<?php if (JAK_TAGS) { ?>
		<tr>
			<td><?php echo $tlgwl["growl"]["d5"];?></td>
			<td>
			<div class="radio"><label>
				<input type="radio" name="jak_tags" value="1"<?php if (isset($_REQUEST["jak_tags"]) && $_REQUEST["jak_tags"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
			</label></div>
			<div class="radio"><label>
				<input type="radio" name="jak_tags" value="0"<?php if ((isset($_REQUEST["jak_tags"]) && $_REQUEST["jak_tags"] == '0') || !isset($_REQUEST["jak_tags"])) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
			</label></div></td>
		</tr>
		<?php } ?>
		<tr>
			<td><?php echo $tlgwl["growl"]["d6"];?></td>
			<td>
			<div class="radio"><label>
				<input type="radio" name="jak_search" value="1"<?php if (isset($_REQUEST["jak_search"]) && $_REQUEST["jak_search"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
			</label></div>
			<div class="radio"><label>
				<input type="radio" name="jak_search" value="0"<?php if ((isset($_REQUEST["jak_search"]) && $_REQUEST["jak_search"] == '0') || !isset($_REQUEST["jak_search"])) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
			</label></div>
			</td>
		</tr>
		<tr>
			<td><?php echo $tlgwl["growl"]["d7"];?></td>
			<td>
			<div class="radio"><label>
				<input type="radio" name="jak_sitemap" value="1"<?php if (isset($_REQUEST["jak_sitemap"]) && $_REQUEST["jak_sitemap"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
			</label></div>
			<div class="radio"><label>
				<input type="radio" name="jak_sitemap" value="0"<?php if ((isset($_REQUEST["jak_sitemap"]) && $_REQUEST["jak_sitemap"] == '0') || !isset($_REQUEST["jak_sitemap"])) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
			</label></div>
			</td>
		</tr>
		</table>
		</div>
			<div class="box-footer">
			  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
			</div>
		</div>
		
		<div class="box box-danger">
		  <div class="box-header with-border">
		    <h3 class="box-title"><?php echo $tl["general"]["g88"];?> <a class="cms-help" data-content="<?php echo $tl["help"]["h"];?>" href="javascript:void(0)" data-original-title="<?php echo $tl["title"]["t21"];?>"><i class="fa fa-question-circle"></i></a></h3>
		  </div><!-- /.box-header -->
		  <div class="box-body">
		<table class="table">
		<tr>
			<td valign="top"><?php echo $tl["general"]["g88"];?></td>
			<td><select name="jak_permission[]" multiple="multiple" class="form-control">
			<option value="0"<?php if (isset($_REQUEST["jak_permission"]) && $_REQUEST["jak_permission"] == '0') { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g84"];?></option>
			<?php if (isset($JAK_USERGROUP) && is_array($JAK_USERGROUP)) foreach($JAK_USERGROUP as $v) { ?><option value="<?php echo $v["id"];?>"<?php if (isset($_REQUEST["jak_permission"]) && $v["id"] == $_REQUEST["jak_permission"]) { ?> selected="selected"<?php } ?>><?php echo $v["name"];?></option><?php } ?>
			</select></td>
		</tr>
		</table>
		</div>
			<div class="box-footer">
			  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
			</div>
		</div>
	</div>
</div>



<?php include_once APP_PATH."admin/template/editor_new.php";?>

</form>

<?php if ($jkv["adv_editor"]) { ?>
<script src="js/ace/ace.js" type="text/javascript"></script>
<script type="text/javascript">

var htmlACE = ace.edit("htmleditor");
htmlACE.setTheme("ace/theme/chrome");
htmlACE.session.setMode("ace/mode/html");
texthtml = $("#jak_editor").val();
htmlACE.session.setValue(texthtml);
		
function responsive_filemanager_callback(field_id) {
	
	if (field_id == "htmleditor") {
		// get the path for the ace file
		var acefile = jQuery('#'+field_id).val();
		htmlACE.insert(acefile);
	}
}

$('form').submit(function() {
	$("#jak_editor").val(htmlACE.getValue());
});
</script>
<?php } ?>

<script type="text/javascript">
$(document).ready(function() {
	$("#datepickerFrom, #datepickerTo").datetimepicker({format: 'yyyy-mm-dd hh:ii', autoclose: true, startDate: new Date()});
});
</script>
		
<?php include_once APP_PATH.'admin/template/footer.php';?>