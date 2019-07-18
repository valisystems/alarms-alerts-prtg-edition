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
		  if (isset($errors["e2"])) echo $errors["e2"];?>
</div>
<?php } ?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">

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
	<input type="radio" name="jak_showtitle" value="0"<?php if ((isset($_REQUEST["showtitle"]) && $_REQUEST["showtitle"] == '0') || !isset($_REQUEST["showtitle"])) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
	</label>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["page"]["p14"];?></td>
	<td>
	<div class="radio">
	<label>
	<input type="radio" name="jak_shownav" value="1"<?php if ((isset($_REQUEST["jak_shownav"]) && $_REQUEST["jak_shownav"] == '1') || !isset($_REQUEST["jak_shownav"])) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
	</label>
	</div>
	<div class="radio">
	<label>
	<input type="radio" name="jak_shownav" value="0"<?php if (isset($_REQUEST["jak_shownav"]) && $_REQUEST["jak_shownav"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
	</label>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["page"]["p15"];?></td>
	<td>
	<div class="radio">
	<label>
	<input type="radio" name="jak_showfooter" value="1"<?php if ((isset($_REQUEST["jak_showfooter"]) && $_REQUEST["jak_showfooter"] == '1') || !isset($_REQUEST["jak_showfooter"])) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
	</label>
	</div>
	<div class="radio">
	<label>
	<input type="radio" name="jak_showfooter" value="0"<?php if (isset($_REQUEST["jak_showfooter"]) && $_REQUEST["jak_showfooter"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
	</label>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["page"]["p8"];?></td>
	<td>
	<div class="radio">
	<label>
	<input type="radio" name="jak_showdate" value="1"<?php if (isset($_REQUEST["jak_showdate"]) && $_REQUEST["jak_showdate"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
	</label>
	</div>
	<div class="radio">
	<label>
	<input type="radio" name="jak_showdate" value="0"<?php if ((isset($_REQUEST["jak_showdate"]) && $_REQUEST["jak_showdate"] == '0') || !isset($_REQUEST["jak_showdate"])) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
	</label>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["general"]["g124"];?></td>
	<td>
	<div class="radio">
	<label>
	<input type="radio" name="jak_sidebar" value="1"<?php if (isset($_REQUEST["jak_sidebar"]) && $_REQUEST["jak_sidebar"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g125"];?>
	</label>
	</div>
	<div class="radio">
	<label>
	<input type="radio" name="jak_sidebar" value="0"<?php if ((isset($_REQUEST["jak_sidebar"]) && $_REQUEST["jak_sidebar"] == '0') || !isset($_REQUEST["jak_sidebar"])) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g126"];?>
	</label>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["page"]["p9"];?></td>
	<td>
	<div class="radio">
	<label>
	<input type="radio" name="jak_social" value="1"<?php if (isset($_REQUEST["jak_social"]) && $_REQUEST["jak_social"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
	</label>
	</div>
	<div class="radio">
	<label>
	<input type="radio" name="jak_social" value="0"<?php if ((isset($_REQUEST["jak_social"]) && $_REQUEST["jak_social"] == '0') || !isset($_REQUEST["jak_social"])) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
	</label>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["general"]["g85"];?></td>
	<td>
	<div class="radio">
	<label>
	<input type="radio" name="jak_vote" value="1"<?php if (isset($_REQUEST["jak_vote"]) && $_REQUEST["jak_vote"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
	</label>
	</div>
	<div class="radio">
	<label>
	<input type="radio" name="jak_vote" value="0"<?php if ((isset($_REQUEST["jak_vote"]) && $_REQUEST["jak_vote"] == '0') || !isset($_REQUEST["jak_vote"])) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
	</label>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["page"]["p13"];?></td>
	<td>
	<div class="radio">
	<label>
	<input type="radio" name="jak_showtags" value="1"<?php if (isset($_REQUEST["jak_showtags"]) && $_REQUEST["jak_showtags"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
	</label>
	</div>
	<div class="radio">
	<label>
	<input type="radio" name="jak_showtags" value="0"<?php if ((isset($_REQUEST["jak_showtags"]) && $_REQUEST["jak_showtags"] == '0') || !isset($_REQUEST["jak_showtags"])) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
	</label>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["page"]["p10"];?></td>
	<td>
	<div class="radio">
	<label>
	<input type="radio" name="jak_showlogin" value="1"<?php if (isset($_REQUEST["jak_showlogin"]) && $_REQUEST["jak_showlogin"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
	</label>
	</div>
	<div class="radio">
	<label>
	<input type="radio" name="jak_showlogin" value="0"<?php if ((isset($_REQUEST["jak_showlogin"]) && $_REQUEST["jak_showlogin"] == '0') || !isset($_REQUEST["jak_showlogin"])) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
	</label>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["page"]["p11"];?></td>
	<td><input type="text" name="jak_password" value="<?php if (isset($_REQUEST["jak_password"])) echo $_REQUEST["jak_password"];?>" class="form-control" /></td>
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
	<option value="0"<?php if (!$page1) { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g24"];?></option>
	<?php if (isset($JAK_CAT_NOTUSED) && is_array($JAK_CAT_NOTUSED)) foreach($JAK_CAT_NOTUSED as $v) { ?><option value="<?php echo $v["id"];?>"<?php if ($v["id"] == $page2 || isset($_REQUEST["jak_catid"]) && $_REQUEST["jak_catid"] == $v["id"]) { ?> selected="selected"<?php } ?>><?php echo $v["name"];?></option><?php } ?>
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
	<td><input type="text" name="jak_tags" id="jak_tags" class="tags form-control" value="<?php if (isset($_REQUEST["jak_tags"])) echo $_REQUEST["jak_tags"]; ?>" /></td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
<?php } ?>
</div>
</div>

<?php include_once "editor_new.php";?>

</div>
<div class="tab-pane" id="cmsPage2">
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["general"]["g53"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
	<a href="../js/editor/plugins/filemanager/dialog.php?type=2&editor=mce_0&lang=eng&fldr=&field_id=csseditor" class="ifManager"><?php echo $tl["general"]["g69"];?></a> <a href="javascript:;" id="addCssBlock"><?php echo $tl["general"]["g101"];?></a><br />
		<div id="csseditor"></div>
		<textarea name="jak_css" id="jak_css" class="hidden"><?php if (isset($_REQUEST["jak_css"])) echo $_REQUEST["jak_css"];?></textarea>
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
	<textarea name="jak_javascript" id="jak_javascript" class="hidden"><?php if (isset($_REQUEST["jak_javascript"])) echo $_REQUEST["jak_javascript"];?></textarea>
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
	
	<li class="jakcontent">
		<div class="text"><?php echo $tl["page"]["p4"];?></div>
		<div class="actions">
		
			<input type="hidden" name="corder_new[]" class="corder" value="1" /> <input type="hidden" name="real_plugin_id[]" value="9999" />
		
		</div>
	</li>
	
	<?php if (isset($JAK_CONTACT_FORMS) && is_array($JAK_CONTACT_FORMS)) { ?>
	
	<li class="jakcontent">
		<div class="form-group">
		    <label><?php echo $tl["page"]["p7"];?></label>
		      <select name="jak_showcontact" class="form-control">
		      <option value="0"<?php if (isset($_REQUEST["jak_showcontact"]) && $_REQUEST["jak_showcontact"] == '0') { ?> selected="selected"<?php } ?>><?php echo $tl["cform"]["c18"];?></option>
		      <?php foreach($JAK_CONTACT_FORMS as $cf) { ?><option value="<?php echo $cf["id"];?>"<?php if (isset($_REQUEST["jak_showcontact"]) && $cf["id"] == $_REQUEST["jak_showcontact"]) { ?> selected="selected"<?php } ?>><?php echo $cf["title"];?></option><?php } ?>
		      </select>
		  </div>
		<div class="actions">
		
			<input type="hidden" name="corder_new[]" class="corder" value="2" /> <input type="hidden" name="real_plugin_id[]" value="9997" />
		
		</div>
	</li>
	
	<?php } ?>
	
	<li class="jakcontent">
		<div class="form-group">
		    <label><?php echo $tl["title"]["t20"];?></label>
		    <div class="row">
		    <div class="col-md-6">
		      <select name="jak_shownewsorder" class="form-control">
		      <option value="ASC"<?php if (isset($_REQUEST["jak_shownewsorder"]) && $_REQUEST["jak_shownewsorder"] == "ASC") { ?> selected="selected"<?php } else { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g90"];?></option>
		      <option value="DESC"<?php if (isset($_REQUEST["jak_shownewsorder"]) && $_REQUEST["jak_shownewsorder"] == "DESC") { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g91"];?></option>
		      </select>
		     </div>
		     <div class="col-md-6">
		      <select name="jak_shownewsmany" class="form-control">
		      <?php for ($i = 0; $i <= 10; $i++) { ?>
		      <option value="<?php echo $i ?>"<?php if (isset($_REQUEST["jak_shownewsmany"]) && $_REQUEST["jak_shownewsmany"] == $i) { ?> selected="selected"<?php } ?>><?php echo $i; ?></option>
		      <?php } ?>
		      </select>
		    </div>
		  </div>
		 </div>
		  
		  <div class="form-group">
		      <label><?php echo $tl["general"]["g68"];?></label>
		      	<select name="jak_shownews[]" multiple="multiple" class="form-control">
		      	<option value="0"<?php if (isset($_REQUEST["jak_shownews"]) && $_REQUEST["jak_shownews"] && in_array(0, $_REQUEST["jak_shownews"])) { ?> selected="selected"<?php } else { ?> selected="selected"<?php } ?>><?php echo $tl["cform"]["c18"];?></option>
		      	<?php if (isset($JAK_GET_NEWS) && is_array($JAK_GET_NEWS)) foreach($JAK_GET_NEWS as $gn) { ?>
		      	<option value="<?php echo $gn["id"];?>"<?php if (isset($_REQUEST["jak_shownews"]) && $_REQUEST["jak_shownews"] && in_array($gn["id"], $_REQUEST["jak_shownews"])) { ?> selected="selected"<?php } ?>><?php echo $gn["title"];?></option>
		      	<?php } ?>
		      	</select>
		    </div>
		<div class="actions">
		
			<input type="hidden" name="corder_new[]" class="corder" value="3" /> <input type="hidden" name="real_plugin_id[]" value="9998" />
		
		</div>
	</li>
	
	<?php if (isset($JAK_HOOK_ADMIN_PAGE_NEW) && is_array($JAK_HOOK_ADMIN_PAGE_NEW)) foreach($JAK_HOOK_ADMIN_PAGE_NEW as $hspn) { include_once APP_PATH.$hspn["phpcode"]; } ?>
	
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
		<?php include "sidebar_widget_new.php";?>
	</div>
		<div class="box-footer">
		  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
		</div>
	</div>
	
	</div>
</div>	
</div>
</div>
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
	
	$('#cmsTab a').click(function(e) {
	  e.preventDefault();
	  $(this).tab('show');
	});
	
	$("#addCssBlock").click(function() {
		
		cssACE.insert(insert_cssblock());
	
	});
	$("#addJavascriptBlock").click(function() {
		
		jsACE.insert(insert_javascript());
	
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