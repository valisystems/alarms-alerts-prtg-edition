<?php include_once APP_PATH.'admin/template/header.php';?>

<?php if ($page2 == "s") { ?>
<div class="alert alert-success fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?php echo $tl["general"]["g7"];?>
</div>
<?php } if ($page2 == "e") { ?>
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
    		  if (isset($errors["e2"])) echo $errors["e2"];
    		  if (isset($errors["e3"])) echo $errors["e3"];
    		  if (isset($errors["e4"])) echo $errors["e4"];
    		  if (isset($errors["e5"])) echo $errors["e5"];
    		  if (isset($errors["e6"])) echo $errors["e6"];
    		  if (isset($errors["e7"])) echo $errors["e7"];
    		  if (isset($errors["e8"])) echo $errors["e8"];
        ?>
    </div>
<?php } ?>

<form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">

    <ul class="nav nav-tabs" id="cmsTab">
    	<li class="active"><a href="#deviceSett1"><?php echo $tl["menu"]["m2"];?></a></li>
    	<li><a href="#deviceSett2"><?php echo $tl["general"]["g53"];?></a></li>
    	<li><a href="#deviceSett3"><?php echo $tl["general"]["g100"];?></a></li>
    	<li><a href="#deviceSett4"><?php echo $tl["general"]["g89"];?></a></li>
    </ul>

    <div class="tab-content">

        <div class="tab-pane active" id="deviceSett1">

        	<div class="row">
            <div class="col-md-7">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">General Settings</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                    	<table class="table table-striped">
                			<tr>
                            	<td><?php echo $tl["page"]["p"];?></td>
                            	<td>
                                	<div class="form-group<?php if (isset($errors["e1"])) echo " has-error";?>">
                                        <input type="text" name="jak_title" class="form-control" value="<?php echo $jkv["devicetitle"];?>" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                            	<td><?php echo $tl["page"]["p5"];?></td>
                            	<td><?php include_once APP_PATH."admin/template/editorlight_edit.php";?></td>
                            </tr>
                            <tr>
                            	<td><?php echo $tl["setting"]["s4"];?></td>
                            	<td>
                            	<div class="form-group">
                            		<input type="text" name="jak_date" class="form-control" value="<?php echo $jkv["devicedateformat"];?>" />
                            	</div>
                            	</td>
                            </tr>
                            <tr>
                            	<td><?php echo $tl["setting"]["s5"];?></td>
                            	<td>
                            	<div class="form-group">
                            		<input type="text" name="jak_time" class="form-control" value="<?php echo $jkv["devicetimeformat"];?>" />
                            	</div>
                            	</td>
                            </tr>

                    	</table>
                    </div>
                    <div class="box-footer">
                        <button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Permission Settings</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                    	<table class="table table-striped">
                    		<tr>
                                <td><?= $tldev["device"]["s7"]?></td>
                                <td>
                                    <div class="radio">
                                       <label>
                                           <input type="radio" name="jak_devicediscover" value="1"<?php if ($jkv["devicediscover"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
                                       </label>
                                    </div>
                                    <div class="radio">
                                       <label>
                                           <input type="radio" name="jak_devicediscover" value="0"<?php if ($jkv["devicediscover"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
                                       </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><?= $tldev["device"]["s8"]?></td>
                                <td>
                                    <div class="radio">
                                       <label>
                                           <input type="radio" name="jak_ftcancreate" value="1"<?php if ($jkv["deviceftcancreate"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
                                       </label>
                                    </div>
                                    <div class="radio">
                                       <label>
                                           <input type="radio" name="jak_ftcancreate" value="0"<?php if ($jkv["deviceftcancreate"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
                                       </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><?= $tldev["device"]["s9"]?></td>
                                <td>
                                    <div class="radio">
                                       <label>
                                           <input type="radio" name="jak_ftcanedit" value="1"<?php if ($jkv["deviceftcanedit"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
                                       </label>
                                    </div>
                                    <div class="radio">
                                       <label>
                                           <input type="radio" name="jak_ftcanedit" value="0"<?php if ($jkv["deviceftcanedit"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
                                       </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><?= $tldev["device"]["s10"]?></td>
                                <td>
                                    <div class="radio">
                                       <label>
                                           <input type="radio" name="jak_ftcandelete" value="1"<?php if ($jkv["deviceftcandelete"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
                                       </label>
                                    </div>
                                    <div class="radio">
                                       <label>
                                           <input type="radio" name="jak_ftcandelete" value="0"<?php if ($jkv["deviceftcandelete"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
                                       </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><?= $tldev["device"]["s4"]?></td>
                                <td>
	                                <div class="form-group">
	                                    <input class="form-control" type="password" name="jak_listpassword" value="<?php echo $jkv["devicelistpassword"];?>" />
	                                </div>
                                </td>
                            </tr>
                            <tr>
                                <td><?= $tldev["device"]["s11"]?></td>
                                <td>
                                <div class="form-group<?php if (isset($errors["e3"])) echo " has-error";?>">
                                    <input class="form-control" type="text" name="jak_authkey" value="<?php echo $jkv["deviceauthkey"];?>" />
                                </div>
                                </td>
                            </tr>
                            <tr>
                            	<td>URL for json Call</td>
                            	<td>
                            		<span>http://<?= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT']?>/index.php?p=device&amp;sp=ajax&ssp=signalupdate&auth=[authkey]</span>
                                </td>
                            </tr>
                    	</table>
                    </div>
                    <div class="box-footer">
                        <button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
                    </div>
                </div>
            </div>

       </div> <!-- End of first row -->

        	<div class="row">
            <div class="col-md-7">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">PRTG Settings</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-striped">
                           <tr>
                                <td>Status Link for single device</td>
                                <td>
                                    Example: /index.php?p=device&sp=prtg&action=query&basename=0000100&deviceid=2012
                                </td>
                            </tr>
							<tr>
                                <td>Status Link for all devices</td>
                                <td>
                                    Example: /index.php?p=device&sp=prtg&action=all
                                </td>
                            </tr>
							<tr>
                                <td>Status Text format</td>
                                <td>
                                    Example: {"base_name":"Dome_62AE56","device_id":"62AE56A1","status":"Normal"}
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="box-footer">
                        <button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
                    </div>
                </div>
            </div> <!-- END of permission col -->

            <div class="col-md-5">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Alert Call Settings</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-striped">
                            <tr>
                                <td>PBX Host</td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="jak_pbxhost" value="<?php echo $jkv["devicepbxhost"];?>" placeholder="173.231.102.81" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Username and Password</td>
                                <td>
                                	<div class="row">
                                		<div class="col-md-6">
                                			<input class="form-control" type="text" name="jak_pbxusername" value="<?php echo $jkv["devicepbxusername"];?>" />
                                		</div>
                                		<div class="col-md-6">
                                			<input class="form-control" type="text" name="jak_pbxpassword" value="<?php echo $jkv["devicepbxpassword"];?>" />
                                		</div>
                                	</div>
                                </td>
                            </tr>
                            <tr>
                                <td>Default Extension</td>
                                <td>
                                	<div class="row">
                                		<div class="col-md-6">
                                			<input class="form-control" type="text" name="jak_default_ext" value="<?php echo $jkv["devicepbx_default_ext"];?>" placeholder="100@localhost" />
                                		</div>
                                		<div class="col-md-6">
                                			<input class="form-control" type="text" name="jak_ext_pass" value="<?php echo $jkv["devicepbx_ext_pass"];?>" />
                                		</div>
                                	</div>
                                </td>
                            </tr>
                            <!--<tr>
                                <td>Send Email</td>
                                <td>
                                    <div class="radio">
                                       <label>
                                           <input type="radio" name="jak_alertemail" value="1"<?php if ($jkv["devicealertemail"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
                                       </label>
                                    </div>
                                    <div class="radio">
                                       <label>
                                           <input type="radio" name="jak_alertemail" value="0"<?php if ($jkv["devicealertemail"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
                                       </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                            	<td><?php echo $tldev["device"]["d7"];?></td>
                            	<td>
                            	<div class="form-group<?php if (isset($errors["e2"])) echo " has-error";?>">
                            		<input class="form-control" type="text" name="jak_email" value="<?php echo $jkv["deviceemail"];?>" />
                            	</div>
                            	</td>
                            </tr>-->
                            <tr>
                                <td>Trigger URL</td>
                                <td>http://<?= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT']?>/index.php?p=device&sp=alert&acc=1500@localhost&dest=200
                                	<?php echo !empty($alert_URL) ? $alert_URL : '';  ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="box-footer">
                        <button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
                    </div>
                </div>

            </div> <!-- END of Alert col -->
        </div> <!-- End of permission and prtg and alert call settings ROW -->
<!--
        <div class="row">
        	<div class="col-md-7">

                <!-- Email settings >
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Email STMP Settings</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-striped">
                            <tr>
                                <td>Email Host</td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="jak_emailhost" value="<?php echo $jkv["deviceemailhost"];?>" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Port</td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="jak_emailport" value="<?php echo $jkv["deviceemailport"];?>" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Server Perfix</td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="jak_emailserverprefix" placeholder="ssl/tls" value="<?php echo $jkv["deviceemailserverprefix"];?>" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Username and Password</td>
                                <td>
                                	<div class="row">
                                		<div class="col-md-6">
                                			<input class="form-control" type="text" name="jak_emailusername" value="<?php echo $jkv["deviceemailusername"];?>" />
                                		</div>
                                		<div class="col-md-6">
                                			<input class="form-control" type="text" name="jak_emailpassword" value="<?php echo $jkv["deviceemailpassword"];?>" />
                                		</div>
                                	</div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="box-footer">
                        <button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
                    </div>
                </div><!-- END of email settins ->
        	</div>

        	<div class="col-md-5">
                <!-- SMS settings ->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">SMS Settings</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-striped">
                            <tr>
                                <td>SMS Host</td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="jak_smshost" value="<?php echo $jkv["devicesmshost"];?>" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Number</td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="jak_smsnumber"  value="<?php echo $jkv["devicesmsnumber"];?>" />
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="box-footer">
                        <button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
                    </div>
                </div><!-- ENd of SMS settins ->
        	</div>

        </div> <!-- End of SMS row -->

       <div class="row">
        	<div class="col-md-7">
        		<div class="box box-primary">
	                  <div class="box-header with-border">
	                    <h3 class="box-title">Camera Settings</h3>
	                  </div><!-- /.box-header -->
	                  <div class="box-body">
	                        <table class="table table-striped">
                        		<tr>
                        			<td>CAM Host</td>
                        			<td>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input class="form-control" type="text" name="jak_camhost"  value="<?php echo $jkv["devicecamhost"];?>" placeholder="http://videomaximum.com"/>
                                            </div>
                                            <div class="col-md-4">
                                                <input class="form-control" type="text" name="jak_camport"  value="<?php echo str_replace(":", "", $jkv["devicecamport"]);?>" placeholder="9786"/>
                                            </div>
                                        </div>
                                    </td>
                        		</tr>
                        		<tr>
                        			<td>CAM Username and password</td>
                        			<td>
                        				<div class="row">
	                                		<div class="col-md-6">
	                                			<input class="form-control" type="text" name="jak_camusername" value="<?php echo $jkv["devicecamusername"];?>" />
	                                		</div>
	                                		<div class="col-md-6">
	                                			<input class="form-control" type="text" name="jak_campassword" value="<?php echo $jkv["devicecampassword"];?>" />
	                                		</div>
	                                	</div>
                                	</td>
                        		</tr>
	                            <tr>
	                            	<td>URL</td>
	                            	<td>http://<?= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT']?>/index.php?p=device&sp=cam</td>
	                            </tr>
	                        </table>
	                </div>
	            	<div class="box-footer">
	            	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	            	</div>
        	</div>
        	<div class="col-md-5">

        	</div>
        </div>
        </div>

		<div class="row">
			<div class="col-md-7">
				<div class="box box-primary">
	                  <div class="box-header with-border">
	                    <h3 class="box-title">Catch Settings</h3>
	                  </div><!-- /.box-header -->
	                  <div class="box-body">
	                        <table class="table table-striped">
                        		<tr>
                        			<td>Directory (<a href="/admin/index.php?p=device&sp=files">Files</a>)</td>
                        			<td>_files/catch/</td>
                        		</tr>
                                <tr>
                                    <td>Catch (<a href="/index.php?p=device&sp=catch" target="_blank">Files</a>)</td>
                                    <td>Data</td>
                                </tr>
                        		<tr>
	                            	<td>Single File</td>
	                            	<td>
	                            	    <div class="radio">
	                            	       <label>
	                            	           <input type="radio" name="jak_catchsinglefile" value="1"<?php if ($jkv["devicecatchsinglefile"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
	                            	       </label>
	                            	    </div>
	                            	    <div class="radio">
	                            	       <label>
	                            	           <input type="radio" name="jak_catchsinglefile" value="0"<?php if ($jkv["devicecatchsinglefile"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
	                            	       </label>
	                            	    </div>
	                            	</td>
	                            </tr>
	                            <tr>
	                            	<td>URL</td>
	                            	<td>http://<?= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT']?>/index.php?p=device&sp=catch</td>
	                            </tr>
	                            <!-- <tr>
	                            	<td><?php echo $tldev["device"]["d6"];?></td>
	                            	<td>
	                            	    <div class="radio">
	                            	       <label>
	                            	           <input type="radio" name="jak_deviceurl" value="1"<?php if ($jkv["deviceurl"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
	                            	       </label>
	                            	    </div>
	                            	    <div class="radio">
	                            	       <label>
	                            	           <input type="radio" name="jak_deviceurl" value="0"<?php if ($jkv["deviceurl"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
	                            	       </label>
	                            	    </div>
	                            	</td>
	                            </tr> -->
	                        </table>
	                </div>
	            	<div class="box-footer">
	            	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	            	</div>
	            </div>
			</div><!-- END of catch setting col -->
			<div class="col-md-5">
				<div class="box box-primary">
	            	  <div class="box-header with-border">
	            	    <h3 class="box-title"><?php echo $tl["title"]["t29"];?></h3>
	            	  </div><!-- /.box-header -->
	            	  <div class="box-body">
						 <table class="table table-striped">
							<tr>
								<td>MAX post</td>
								<td>
								<div class="form-group<?php if (isset($errors["e5"])) echo " has-error";?>">
									<input type="text" name="jak_maxpost" class="form-control" value="<?php echo $jkv["devicemaxpost"];?>" />
								</div>
								</td>
							</tr>
							<tr>
								<td><?php echo $tl["setting"]["s11"];?></td>
								<td>
								<div class="form-group<?php if (isset($errors["e6"])) echo " has-error";?>">
									<input type="text" name="jak_rss" class="form-control" value="<?php echo $jkv["devicerss"];?>" />
								</div>
								</td>
							</tr>
							<tr>
								<td><?php echo $tl["setting"]["s11"];?></td>
								<td>
								<div class="form-group<?php if (isset($errors["e7"])) echo " has-error";?>">
									<input type="text" name="jak_mid"  class="form-control" value="<?php echo $jkv["devicepagemid"];?>" />
								</div>
								</td>
							</tr>
							<tr>
								<td><?php echo $tl["setting"]["s12"];?></td>
								<td>
								<div class="form-group<?php if (isset($errors["e8"])) echo " has-error";?>">
									<input type="text" name="jak_item" class="form-control" value="<?php echo $jkv["devicepageitem"];?>" />
								</div>
								</td>
							</tr>
						</table>
					</div>
					<div class="box-footer">
					  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
					</div>
				</div>
			</div><!-- END paginator of col -->
		</div><!-- END of ROW -->

	</div><!-- end of deviceSett1 -->
	<div class="tab-pane" id="deviceSett2">
		<div class="box box-primary">
		  <div class="box-header with-border">
		    <h3 class="box-title"><?php echo $tl["general"]["g53"];?></h3>
		  </div><!-- /.box-header -->
		  <div class="box-body">
		  <a href="../js/editor/plugins/filemanager/dialog.php?type=2&editor=mce_0&lang=eng&fldr=&field_id=csseditor" class="ifManager"><?php echo $tl["general"]["g69"];?></a> <a href="javascript:;" id="addCssBlock"><?php echo $tl["general"]["g101"];?></a><br />
		  	<div id="csseditor"></div>
			<textarea name="jak_css" class="form-control hidden" id="jak_css" rows="20"><?php echo $jkv["device_css"];?></textarea>
		</div>
			<div class="box-footer">
			  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
			</div>
		</div>
	</div>

	<div class="tab-pane" id="deviceSett3">
		<div class="box box-primary">
		  <div class="box-header with-border">
		    <h3 class="box-title"><?php echo $tl["general"]["g100"];?></h3>
		  </div><!-- /.box-header -->
		  <div class="box-body">
		  	<a href="../js/editor/plugins/filemanager/dialog.php?type=2&editor=mce_0&lang=eng&fldr=&field_id=javaeditor" class="ifManager"><?php echo $tl["general"]["g69"];?></a> <a href="javascript:;" id="addJavascriptBlock"><?php echo $tl["general"]["g102"];?></a><br />
		  	<div id="javaeditor"></div>
				<textarea name="jak_javascript" class="form-control hidden" id="jak_javascript" rows="20"><?php echo $jkv["device_javascript"];?></textarea>
		  </div>
			<div class="box-footer">
			  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
			</div>
		</div>
	</div>

	<div class="tab-pane" id="deviceSett4">
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


	</div> <!-- END of tab-content -->
</form>


<script src="js/ace/ace.js" type="text/javascript"></script>
<script type="text/javascript">

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


});

function responsive_filemanager_callback(field_id) {

	if (field_id == "csseditor" || field_id == "javaeditor") {

		// get the path for the ace file
		var acefile = jQuery('#'+field_id).val();

		if (field_id == "csseditor") {
			cssACE.insert('<link rel="stylesheet" href="'+acefile+'" type="text/css" />');
		} else if (field_id == "javaeditor") {
			jsACE.insert('<script src="'+acefile+'"><\/script>');
		}
	}
}

$('form').submit(function() {
	$("#jak_css").val(cssACE.getValue());
	$("#jak_javascript").val(jsACE.getValue());
});
</script>

<?php include_once APP_PATH.'admin/template/footer.php';?>

