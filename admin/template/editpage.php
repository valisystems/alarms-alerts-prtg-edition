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
		  if (isset($errors["e2"])) echo $errors["e2"];?>
</div>
<?php } ?>

<form class="inline-form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">

<ul class="nav nav-tabs" id="cmsTab">
	<li class="active"><a href="#cmsPage1"><?php echo $tl["page"]["p4"];?></a></li>
	<li><a href="#cmsPage2"><?php echo $tl["general"]["g53"];?></a></li>
	<li><a href="#cmsPage3"><?php echo $tl["general"]["g100"];?></a></li>
	<li><a href="#cmsPage4"><?php echo $tl["general"]["g121"];?></a></li>
</ul>

<div class="tab-content">
<div class="tab-pane active" id="cmsPage1">
<div class="row">
<div class="col-md-8">
<div class="box box-primary">
	  <div class="box-header with-border">
	    <h3 class="box-title"><?php echo $tl["title"]["t13"];?></h3>
	  </div><!-- /.box-header -->
	  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><?php echo $tl["page"]["p"];?></td>
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
	<td><?php echo $tl["page"]["p10"];?></td>
	<td>
	<div class="radio">
	<label>
	<input type="radio" name="jak_showlogin" value="1"<?php if ($JAK_FORM_DATA["showlogin"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
	</label>
	</div>
	<div class="radio">
	<label>
	<input type="radio" name="jak_showlogin" value="0"<?php if ($JAK_FORM_DATA["showlogin"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
	</label>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["page"]["p14"];?></td>
	<td>
	<div class="radio">
	<label>
	<input type="radio" name="jak_shownav" value="1"<?php if ($JAK_FORM_DATA["shownav"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
	</label>
	</div>
	<div class="radio">
	<label>
	<input type="radio" name="jak_shownav" value="0"<?php if ($JAK_FORM_DATA["shownav"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
	</label>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["page"]["p15"];?></td>
	<td>
	<div class="radio">
	<label>
	<input type="radio" name="jak_showfooter" value="1"<?php if ($JAK_FORM_DATA["showfooter"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
	</label>
	</div>
	<div class="radio">
	<label>
	<input type="radio" name="jak_showfooter" value="0"<?php if ($JAK_FORM_DATA["showfooter"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
	</label>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["page"]["p8"];?></td>
	<td>
	<div class="radio">
	<label>
	<input type="radio" name="jak_showdate" value="1"<?php if ($JAK_FORM_DATA["showdate"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
	</label>
	</div>
	<div class="radio">
	<label>
	<input type="radio" name="jak_showdate" value="0"<?php if ($JAK_FORM_DATA["showdate"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
	</label>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["page"]["p9"];?></td>
	<td>
	<div class="radio">
	<label>
	<input type="radio" name="jak_social" value="1"<?php if ($JAK_FORM_DATA["socialbutton"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
	</label>
	</div>
	<div class="radio">
	<label>
	<input type="radio" name="jak_social" value="0"<?php if ($JAK_FORM_DATA["socialbutton"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
	</label>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["general"]["g85"];?></td>
	<td>
	<div class="radio">
	<label>
	<input type="radio" name="jak_vote" value="1"<?php if ($JAK_FORM_DATA["showvote"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
	</label>
	</div>
	<div class="radio">
	<label>
	<input type="radio" name="jak_vote" value="0"<?php if ($JAK_FORM_DATA["showvote"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
	</label>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["page"]["p13"];?></td>
	<td>
	<div class="radio">
	<label>
	<input type="radio" name="jak_showtags" value="1"<?php if ($JAK_FORM_DATA["showtags"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
	</label>
	</div>
	<div class="radio">
	<label>
	<input type="radio" name="jak_showtags" value="0"<?php if ($JAK_FORM_DATA["showtags"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
	</label>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["general"]["g124"];?></td>
	<td>
	<div class="radio">
	<label>
	<input type="radio" name="jak_sidebar" value="1"<?php if ($JAK_FORM_DATA["sidebar"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g125"];?>
	</label>
	</div>
	<div class="radio">
	<label>
	<input type="radio" name="jak_sidebar" value="0"<?php if ($JAK_FORM_DATA["sidebar"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g126"];?>
	</label>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["page"]["p11"];?></td>
	<td><input type="text" name="jak_password" class="form-control" /></td>
</tr>
<?php if ($JAK_FORM_DATA["password"]) { ?>
<tr>
	<td><?php echo $tl["page"]["p12"];?></td>
	<td><input type="checkbox" name="jak_delete_password" /></td>
</tr>
<?php } ?>
<tr>
	<td><?php echo $tl["general"]["g86"];?></td>
	<td><input type="checkbox" name="jak_delete_rate" /></td>
</tr>
<tr>
	<td><?php echo $tl["general"]["g73"].' '.$tl["general"]["g56"];?></td>
	<td><input type="checkbox" name="jak_delete_hits" /></td>
</tr>
<tr>
	<td><?php echo $tl["general"]["g42"];?></td>
	<td><input type="checkbox" name="jak_update_time" /></td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
</div>
<div class="col-md-4">
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["title"]["t12"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><select name="jak_catid" class="form-control">
	<option value="0"<?php if ($JAK_FORM_DATA["catid"] == '0') { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g24"];?></option>
	<?php if (isset($JAK_CAT_NOTUSED) && is_array($JAK_CAT_NOTUSED)) foreach($JAK_CAT_NOTUSED as $v) { ?><option value="<?php echo $v["id"];?>"<?php if ($v["id"] == $JAK_FORM_DATA["catid"]) { ?> selected="selected"<?php } ?>><?php echo $v["name"];?></option><?php } ?>
	<?php if (isset($JAK_CAT) && is_array($JAK_CAT)) foreach($JAK_CAT as $z) { if ($z["id"] == $JAK_FORM_DATA["catid"]) { ?><option value="<?php echo $z["id"];?>" selected="selected"><?php echo $z["name"];?></option><?php } } ?>
	</select></td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
<?php if (JAK_TAGS) { ?>
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["title"]["t31"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><input type="text" name="jak_tags" id="jak_tags" class="tags form-control" value="" /></td>
</tr>

<?php if ($JAK_TAGLIST) { ?>

<tr>
	<td>
	<div class="form-group">
	<label for="tags"><?php echo $tl["general"]["g27"];?></label>
	<div class="controls">
		<?php echo $JAK_TAGLIST;?>
	</div>
	</div>
	</td>
</tr>

<?php } ?>

</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
<?php } ?>

</div>
</div>

<?php include_once "editor_edit.php";?>

</div>
<div class="tab-pane" id="cmsPage2">
	<div class="box box-primary">
  	<div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["general"]["g53"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
	<a href="../js/editor/plugins/filemanager/dialog.php?type=2&editor=mce_0&lang=eng&fldr=&field_id=csseditor" class="ifManager"><?php echo $tl["general"]["g69"];?></a> <a href="javascript:;" id="addCssBlock"><?php echo $tl["general"]["g101"];?></a><br />
		<div id="csseditor"></div>
		<textarea name="jak_css" id="jak_css" class="form-control hidden"><?php echo $JAK_FORM_DATA["page_css"];?></textarea>
	</div>
		<div class="box-footer">
		  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
		</div>
	</div>
</div>
<div class="tab-pane" id="cmsPage3">
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["general"]["g100"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
	<a href="../js/editor/plugins/filemanager/dialog.php?type=2&editor=mce_0&lang=eng&fldr=&field_id=javaeditor" class="ifManager"><?php echo $tl["general"]["g69"];?></a> <a href="javascript:;" id="addJavascriptBlock"><?php echo $tl["general"]["g102"];?></a><br />
		<div id="javaeditor"></div>
		<textarea name="jak_javascript" id="jak_javascript" class="form-control hidden"><?php echo $JAK_FORM_DATA["page_javascript"];?></textarea>
	</div>
		<div class="box-footer">
		  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
		</div>
	</div>
</div>
<div class="tab-pane" id="cmsPage4">
<div class="row">
<div class="col-md-6">
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["page"]["p4"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
  
	<!-- Moving stuff -->
	<ul class="jak_content_move">
	
	<?php if (isset($JAK_PAGE_GRID) && is_array($JAK_PAGE_GRID)) foreach($JAK_PAGE_GRID as $pg) { 
	
	if ($pg["pluginid"] != 0) {
	
	if ($pg["pluginid"] == '9999') { ?>
	
	<li class="jakcontent">
		<div class="text"><?php echo $tl["page"]["p4"];?></div>
		<div class="actions">
		
			<input type="hidden" name="corder[]" class="corder" value="<?php echo $pg["orderid"];?>" /> <input type="hidden" name="real_id[]" value="<?php echo $pg["id"];?>" />
		
		</div>
	</li>
	
	<?php } if ($pg["pluginid"] == '9997' && $JAK_CONTACT_FORM) { ?>
	
	<li class="jakcontent">
		<div class="form-group">
		    <label><?php echo $tl["page"]["p7"];?></label>
		      <select name="jak_showcontact" class="form-control">
		      <option value="0"<?php if (isset($JAK_FORM_DATA["showcontact"]) && $JAK_FORM_DATA["showcontact"] == '0') { ?> selected="selected"<?php } ?>><?php echo $tl["cform"]["c18"];?></option>
		      <?php if (isset($JAK_CONTACT_FORMS) && is_array($JAK_CONTACT_FORMS)) foreach($JAK_CONTACT_FORMS as $cf) { ?><option value="<?php echo $cf["id"];?>"<?php if (isset($JAK_FORM_DATA["showcontact"]) && $cf["id"] == $JAK_FORM_DATA["showcontact"]) { ?> selected="selected"<?php } ?>><?php echo $cf["title"];?></option><?php } ?>
		      </select>
		  </div>
		<div class="actions">
		
			<input type="hidden" name="corder[]" class="corder" value="<?php echo $pg["orderid"];?>" /> <input type="hidden" name="real_id[]" value="<?php echo $pg["id"];?>" />
		
		</div>
	</li>
	
	<?php } if ($pg["pluginid"] == '9998') { ?>
	
	<li class="jakcontent">
		<div class="form-group">
		    <label><?php echo $tl["title"]["t20"];?></label>
		    <div class="row">
		    <div class="col-md-6">
		      <select name="jak_shownewsorder" class="form-control">
		      <option value="ASC"<?php if (isset($JAK_FORM_DATA["shownewsorder"]) && $JAK_FORM_DATA["shownewsorder"] == "ASC") { ?> selected="selected"<?php } else { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g90"];?></option>
		      <option value="DESC"<?php if (isset($JAK_FORM_DATA["shownewsorder"]) && $JAK_FORM_DATA["shownewsorder"] == "DESC") { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g91"];?></option>
		      </select>
		      </div>
		      <div class="col-md-6">
		      <select name="jak_shownewsmany" class="form-control">
		      <?php for ($i = 0; $i <= 10; $i++) { ?>
		      <option value="<?php echo $i ?>"<?php if (isset($JAK_FORM_DATA["shownewsmany"]) && $JAK_FORM_DATA["shownewsmany"] == $i) { ?> selected="selected"<?php } ?>><?php echo $i; ?></option>
		      <?php } ?>
		      </select>
		    </div>
		  </div>
		 </div>
		  
		  <div class="form-group">
		      <label><?php echo $tl["general"]["g68"];?></label>
		      	<select name="jak_shownews[]" multiple="multiple" class="form-control">
		      	<option value="0"<?php if (isset($JAK_FORM_DATA["shownews"]) && $JAK_FORM_DATA["shownews"] == 0) { ?> selected="selected"<?php } ?>><?php echo $tl["cform"]["c18"];?></option>
		      	<?php if (isset($JAK_GET_NEWS) && is_array($JAK_GET_NEWS)) foreach($JAK_GET_NEWS as $gn) { ?>
		      	<option value="<?php echo $gn["id"];?>"<?php if (isset($JAK_FORM_DATA["shownews"]) && $JAK_FORM_DATA["shownews"] == $gn["id"]) { ?> selected="selected"<?php } ?>><?php echo $gn["title"];?></option>
		      	<?php } ?>
		      	</select>
		    </div>

		<div class="actions">
		
			<input type="hidden" name="corder[]" class="corder" value="<?php echo $pg["orderid"];?>" /> <input type="hidden" name="real_id[]" value="<?php echo $pg["id"];?>" />
		
		</div>
	</li>
	
	<?php } 
	
	if (isset($JAK_HOOK_ADMIN_PAGE) && is_array($JAK_HOOK_ADMIN_PAGE)) foreach($JAK_HOOK_ADMIN_PAGE as $hsp) {
	
	eval($hsp["phpcode"]); 
	
	}
	
	}
	}
	
	if (isset($JAK_HOOK_ADMIN_PAGE_NEW) && is_array($JAK_HOOK_ADMIN_PAGE_NEW)) foreach($JAK_HOOK_ADMIN_PAGE_NEW as $hspn) {
	
	include_once APP_PATH.$hspn["phpcode"]; 
	
	}
	
	?>
	
	</ul>
	
	<!-- END Moving Stuff -->
	
	</div>
		<div class="box-footer">
		  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
		</div>
	</div>
	
	</div>
	<div class="col-md-6">
	
	<div class="box box-primary">
	  <div class="box-header with-border">
	    <h3 class="box-title"><?php echo $tl["general"]["g89"];?></h3>
	  </div><!-- /.box-header -->
	  <div class="box-body">
		<?php include "sidebar_widget.php";?>
		</div>
		<div class="box-footer">
		  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
		</div>
	</div>
	</div>
</div>
</div>
</div>
<input type="hidden" name="jak_oldcatid" value="<?php echo $JAK_FORM_DATA["catid"];?>" />
</form>

<script src="js/ace/ace.js" type="text/javascript"></script>
<script type="text/javascript">

<?php if ($jkv["adv_editor"]) { ?>
var htmlACE = ace.edit("htmleditor");
htmlACE.setTheme("ace/theme/chrome");
htmlACE.session.setMode("ace/mode/html");
texthtml = $("#jak_editor").val();
htmlACE.session.setValue(texthtml);
<?php } ?>

var jsACE = ace.edit("javaeditor");
jsACE.setTheme("ace/theme/chrome");
jsACE.session.setMode("ace/mode/html");
textjs = $("#jak_javascript").val();
jsACE.session.setValue(textjs);

var cssACE = ace.edit("csseditor");
cssACE.setTheme("ace/theme/chrome");
cssACE.session.setMode("ace/mode/html");
textcss = $("#jak_css").val();
cssACE.session.setValue(textcss);

$(document).ready(function() {
	    
	$('#jak_tags').tagsInput({
	   defaultText:'<?php echo $tl["general"]["g83"];?>',
	   taglimit: 10
	});
	$('#jak_tags_tag').alphanumeric({nocaps:true});
	
	$('#cmsTab a').click(function (e) {
	  e.preventDefault();
	  $(this).tab('show');
	});
	
	$("#addCssBlock").click(function() {
		
		cssACE.insert(insert_cssblock());
	
	});
	$("#addJavascriptBlock").click(function() {
		
		jsACE.insert(insert_javascript());
	
	});
	
	$("#restorcontent").change(function()
	{
		if ($(this).val() != 0) {
			if(!confirm('<?php echo $tl["general"]["restore"];?>')) { 
				$("#restorcontent").val(0);
				return false;
			} else {
				restoreContent('pageid', <?php echo $page2;?>, <?php echo $jkv["adv_editor"];?>, $(this).val());
			}
		}
	});
});

function responsive_filemanager_callback(field_id) {
	
	if (field_id == "csseditor" || field_id == "javaeditor" || field_id == "htmleditor") {
		
		// get the path for the ace file
		var acefile = jQuery('#'+field_id).val();
		
		if (field_id == "csseditor") {
			cssACE.insert('<link rel="stylesheet" href="'+acefile+'" type="text/css" />');
		} else if (field_id == "javaeditor") {
			jsACE.insert('<script src="'+acefile+'"><\/script>');
		} else {
			htmlACE.insert(acefile);
		}
	}
}

$('form').submit(function() {
	$("#jak_css").val(cssACE.getValue());
	$("#jak_javascript").val(jsACE.getValue());
	<?php if ($jkv["adv_editor"]) { ?>
	$("#jak_editor").val(htmlACE.getValue());
	<?php } ?>
});
</script>
		
<?php include "footer.php";?>