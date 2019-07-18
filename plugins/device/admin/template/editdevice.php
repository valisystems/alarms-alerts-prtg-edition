<?php include_once APP_PATH.'admin/template/header.php';?>

<?php if ($page3 == "s") { ?>
<div class="alert alert-success fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?php echo $tl["general"]["g7"];?>
</div>
<?php } if ($page3 == "e") { ?>
<div class="alert alert-danger fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?php echo $tl["errorpage"]["sql"];?>
</div>
<?php } ?>

<?php if ($errors) { ?>
<div class="alert alert-danger fade in">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<?php if (isset($errors["e"])) echo $errors["e"];
		  if (isset($errors["e2"])) echo $errors["e2"];
		  if (isset($errors["e3"])) echo $errors["e3"];
		  if (isset($errors["e4"])) echo $errors["e4"];
		  if (isset($errors["e5"])) echo $errors["e5"];
	?>
</div>
<?php } ?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">

    <ul class="nav nav-tabs" id="cmsTab">
    	<li class="active"><a href="#deviceArt1"><?php echo $tl["page"]["p4"];?></a></li>
    	<li><a href="#deviceArt2"><?php echo $tl["general"]["g53"];?></a></li>
    	<li><a href="#deviceArt3"><?php echo $tl["general"]["g100"];?></a></li>
    	<li><a href="#deviceArt4"><?php echo $tl["general"]["g89"];?></a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="deviceArt1">
                <div class="row">
                    <div class="col-md-7">
                        <div class="box box-primary">
                        	  <div class="box-header with-border">
                        	    <h3 class="box-title"><?php echo $tl["title"]["t13"];?></h3>
                        	  </div><!-- /.box-header -->
                        	  <div class="box-body">
                                <table class="table table-striped">
                                    <tr>
                                        <td>Device ID</td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="jak_device_id" readonly="readonly" class="form-control" value="<?php if(isset($JAK_FORM_DATA["device_id"])) echo $JAK_FORM_DATA["device_id"];?>" />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Base Name</td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="jak_base_name" class="form-control" readonly="readonly" value="<?php if(isset($JAK_FORM_DATA["base_name"])) echo $JAK_FORM_DATA["base_name"];?>" />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Device Type</td>
                                        <td>
                                            <div class="form-group<?php if (isset($errors["e1"])) echo " has-error";?>">
                                                <input type="text" name="jak_device_type" class="form-control" value="<?php if(isset($JAK_FORM_DATA["device_type"])) echo $JAK_FORM_DATA["device_type"];?>" />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Event Type</td>
                                        <td>
                                            <div class="form-group<?php if (isset($errors["e1"])) echo " has-error";?>">
                                                <input type="text" name="jak_event_type" class="form-control" value="<?php if(isset($JAK_FORM_DATA["event_type"])) echo $JAK_FORM_DATA["event_type"];?>" />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Antenna Int</td>
                                        <td>
                                            <div class="form-group<?php if (isset($errors["e1"])) echo " has-error";?>">
                                                <input type="text" name="jak_antenna_int" class="form-control" value="<?php if(isset($JAK_FORM_DATA["antenna_int"])) echo $JAK_FORM_DATA["antenna_int"];?>" />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Pendant RX Level</td>
                                        <td>
                                            <div class="form-group<?php if (isset($errors["e1"])) echo " has-error";?>">
                                                <input type="text" name="jak_pendant_rx_level" class="form-control" value="<?php if(isset($JAK_FORM_DATA["pendant_rx_level"])) echo $JAK_FORM_DATA["pendant_rx_level"];?>" />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Low Battery</td>
                                        <td>
                                            <div class="form-group<?php if (isset($errors["e1"])) echo " has-error";?>">
                                                <input type="text" name="jak_low_battery" class="form-control" value="<?php if(isset($JAK_FORM_DATA["low_battery"])) echo $JAK_FORM_DATA["low_battery"];?>" />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Time Stamp</td>
                                        <td>
                                            <div class="form-group<?php if (isset($errors["e1"])) echo " has-error";?>">
                                                <input type="text" name="jak_time_stamp" class="form-control" value="<?php if(isset($JAK_FORM_DATA["time_stamp"])) echo $JAK_FORM_DATA["time_stamp"];?>" />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                    	<td><?php echo $tl["general"]["g124"];?></td>
                                    	<td>
                                    	<div class="radio"><label>
                                    	<input type="radio" name="jak_sidebar" value="1"<?php if ($JAK_FORM_DATA["sidebar"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g125"];?>
                                    	</label></div>
                                    	<div class="radio"><label>
                                    	<input type="radio" name="jak_sidebar" value="0"<?php if ($JAK_FORM_DATA["sidebar"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g126"];?>
                                    	</label></div>
                                    	</td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $tl["page"]["p11"];?></td>
                                        <td>
                                            <input type="text" name="jak_password" class="form-control" value="<?php if(isset($_REQUEST["jak_password"])) echo $_REQUEST["jak_password"];?>" />
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        	<div class="box-footer">
                        	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
                        	</div>
                    </div>
                </div>
            </div>

        </div>

        <div class="tab-pane" id="deviceArt2">
        	<div class="box box-primary">
            	<div class="box-header with-border">
            	   <h3 class="box-title"><?php echo $tl["general"]["g53"];?></h3>
            	</div><!-- /.box-header -->
            	<div class="box-body">
                	<a href="../js/editor/plugins/filemanager/dialog.php?type=2&editor=mce_0&lang=eng&fldr=&field_id=csseditor" class="ifManager"><?php echo $tl["general"]["g69"];?></a> <a href="javascript:;" id="addCssBlock"><?php echo $tl["general"]["g101"];?></a><br />
                	<div id="csseditor"></div>
                	<textarea name="jak_css" id="jak_css" class="hidden"><?php echo $JAK_FORM_DATA["device_css"];?></textarea>
                </div>
            	<div class="box-footer">
            	   <button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
            	</div>
            </div>
        </div>
        <div class="tab-pane" id="deviceArt3">
            <div class="box box-primary">
        	   <div class="box-header with-border">
        	       <h3 class="box-title"><?php echo $tl["general"]["g100"];?></h3>
        	   </div><!-- /.box-header -->
               <div class="box-body">
        	        <a href="../js/editor/plugins/filemanager/dialog.php?type=2&editor=mce_0&lang=eng&fldr=&field_id=javaeditor" class="ifManager"><?php echo $tl["general"]["g69"];?></a> <a href="javascript:;" id="addJavascriptBlock"><?php echo $tl["general"]["g102"];?></a><br />
        	  	    <div id="javaeditor"></div>
        	  	    <textarea name="jak_javascript" id="jak_javascript" class="hidden"><?php echo $JAK_FORM_DATA["device_javascript"];?></textarea>
        	   </div>
        	   <div class="box-footer">
        	       <button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
        	   </div>
        	</div>
        </div>
        <div class="tab-pane" id="deviceArt4">
        	<div class="box box-primary">
        	   <div class="box-header with-border">
        	       <h3 class="box-title"><?php echo $tl["general"]["g89"];?></h3>
        	   </div><!-- /.box-header -->
        	   <div class="box-body">
        			<?php include APP_PATH."admin/template/sidebar_widget.php";?>
        	   </div>
        	   <div class="box-footer">
        	       <button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
        	   </div>
        	</div>
        </div>
    </div>
</form>

<script src="js/ace/ace.js" type="text/javascript"></script>
<script type="text/javascript">

if($("#htmleditor").length)
{

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

}


    $(document).ready(function() {

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

    	$("#datepickerFrom, #datepickerTo").datetimepicker({format: 'yyyy-mm-dd hh:ii', autoclose: true, startDate: new Date()});
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

<?php include_once APP_PATH.'admin/template/footer.php';?>