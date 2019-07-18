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

    <div class="tab-pane active" id="analyticSett1">

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
                                        <input type="text" name="analytic_title" class="form-control" value="<?php echo $jkv["analytic_title"];?>" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                              <td><?php echo $tl["page"]["p5"];?></td>
                              <td>
                                <textarea name="jak_lcontent" class="form-control" id="jak_editor_light"><?php echo jak_edit_safe_userpost(htmlspecialchars($JAK_FORM_DATA["content"]));?></textarea>
                              </td>
                            </tr>
                            <tr>
                              <td><?php echo $tl["setting"]["s4"];?></td>
                              <td>
                              <div class="form-group">
                                <input type="text" name="analytic_dateformat" class="form-control" value="<?php echo $jkv["analytic_dateformat"];?>" />
                              </div>
                              </td>
                            </tr>
                            <tr>
                              <td><?php echo $tl["setting"]["s5"];?></td>
                              <td>
                              <div class="form-group">
                                <input type="text" name="analytic_timeformat" class="form-control" value="<?php echo $jkv["analytic_timeformat"];?>" />
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
                        <h3 class="box-title">PBX Settings</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                      <table class="table table-striped">
                            
                            <tr>
                                <td><?= $tlanalytic["analytic"]["s11"]?></td>
                                <td>
                                <div class="form-group<?php if (isset($errors["e2"])) echo " has-error";?>">
                                    <input class="form-control" type="text" name="analytic_pbxhost" value="<?php echo $jkv["analytic_pbxhost"];?>" />
                                </div>
                                </td>
                            </tr>
                            <tr>
                                <td><?= $tlanalytic["analytic"]["s12"]?></td>
                                <td>
                                <div class="form-group">
                                    <input class="form-control" type="text" name="analytic_pbxport" value="<?php echo $jkv["analytic_pbxport"];?>" />
                                </div>
                                </td>
                            </tr>
                            <tr>
                                <td><?= $tlanalytic["analytic"]["s13"]?></td>
                                <td>
                                <div class="form-group<?php if (isset($errors["e3"])) echo " has-error";?>">
                                    <input class="form-control" type="text" name="analytic_pbxusername" value="<?php echo $jkv["analytic_pbxusername"];?>" />
                                </div>
                                </td>
                            </tr>
                            <tr>
                                <td><?= $tlanalytic["analytic"]["s14"]?></td>
                                <td>
                                <div class="form-group<?php if (isset($errors["e4"])) echo " has-error";?>">
                                    <input class="form-control" type="password" name="analytic_pbxpassword" value="<?php echo $jkv["analytic_pbxpassword"];?>" />
                                </div>
                                </td>
                            </tr>
                            <tr>
                              <td>Frontend Password</td>
                              <td>
                                <div class="form-group">
                                      <input class="form-control" type="password" name="analytic_frontpassword" value="<?php echo $jkv["analytic_frontpassword"];?>" />
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

        </div> <!-- End of first row -->
    </div>
</form>

<?php include_once APP_PATH.'admin/template/footer.php';?>