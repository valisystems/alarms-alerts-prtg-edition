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

    <div class="tab-pane active" id="ttsSett1">

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
                                        <input type="text" name="ttstitle" class="form-control" value="<?php echo $jkv["ttstitle"];?>" />
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
                                <input type="text" name="ttsdateformat" class="form-control" value="<?php echo $jkv["ttsdateformat"];?>" />
                              </div>
                              </td>
                            </tr>
                            <tr>
                              <td><?php echo $tl["setting"]["s5"];?></td>
                              <td>
                              <div class="form-group">
                                <input type="text" name="ttstimeformat" class="form-control" value="<?php echo $jkv["ttstimeformat"];?>" />
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
                                <td><?= $tltts["tts"]["s8"]?></td>
                                <td>
                                    <div class="radio">
                                       <label>
                                           <input type="radio" name="ttscancreate" value="1"<?php if ($jkv["ttscancreate"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
                                       </label>
                                    </div>
                                    <div class="radio">
                                       <label>
                                           <input type="radio" name="ttscancreate" value="0"<?php if ($jkv["ttscancreate"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
                                       </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><?= $tltts["tts"]["s9"]?></td>
                                <td>
                                    <div class="radio">
                                       <label>
                                           <input type="radio" name="ttscanedit" value="1"<?php if ($jkv["ttscanedit"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
                                       </label>
                                    </div>
                                    <div class="radio">
                                       <label>
                                           <input type="radio" name="ttscanedit" value="0"<?php if ($jkv["ttscanedit"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
                                       </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><?= $tltts["tts"]["s10"]?></td>
                                <td>
                                    <div class="radio">
                                       <label>
                                           <input type="radio" name="ttscandelete" value="1"<?php if ($jkv["ttscandelete"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
                                       </label>
                                    </div>
                                    <div class="radio">
                                       <label>
                                           <input type="radio" name="ttscandelete" value="0"<?php if ($jkv["ttscandelete"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
                                       </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><?= $tltts["tts"]["s11"]?></td>
                                <td>
                                <div class="form-group<?php if (isset($errors["e3"])) echo " has-error";?>">
                                    <input class="form-control" type="text" name="ttsftphost" value="<?php echo $jkv["ttsftphost"];?>" />
                                </div>
                                </td>
                            </tr>
                            <tr>
                                <td><?= $tltts["tts"]["s12"]?></td>
                                <td>
                                <div class="form-group<?php if (isset($errors["e3"])) echo " has-error";?>">
                                    <input class="form-control" type="text" name="ttsftpport" value="<?php echo $jkv["ttsftpport"];?>" />
                                </div>
                                </td>
                            </tr>
                            <tr>
                                <td><?= $tltts["tts"]["s13"]?></td>
                                <td>
                                <div class="form-group<?php if (isset($errors["e3"])) echo " has-error";?>">
                                    <input class="form-control" type="text" name="ttsftpusername" value="<?php echo $jkv["ttsftpusername"];?>" />
                                </div>
                                </td>
                            </tr>
                            <tr>
                                <td><?= $tltts["tts"]["s14"]?></td>
                                <td>
                                <div class="form-group<?php if (isset($errors["e3"])) echo " has-error";?>">
                                    <input class="form-control" type="password" name="ttsftppassword" value="<?php echo $jkv["ttsftppassword"];?>" />
                                </div>
                                </td>
                            </tr>
                            <tr>
                                <td>FTP Wav Folder name (no space)</td>
                                <td>
                                <div class="form-group<?php if (isset($errors["e3"])) echo " has-error";?>">
                                    <input class="form-control" type="text" name="ttsftpfldname" value="<?php echo $jkv["ttsftpfldname"];?>" />
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