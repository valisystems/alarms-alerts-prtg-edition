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
                                        <input type="text" name="jak_title" class="form-control" value="<?php echo $jkv["cdrtitle"];?>" />
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
                                    <input type="text" name="jak_date" class="form-control" value="<?php echo $jkv["cdrdateformat"];?>" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $tl["setting"]["s5"];?></td>
                                <td>
                                <div class="form-group">
                                    <input type="text" name="jak_time" class="form-control" value="<?php echo $jkv["cdrtimeformat"];?>" />
                                </div>
                                </td>
                            </tr>
                            <tr>
                                <td>CDR insert url</td>
                                <td>http://<?= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT']?>/index.php?p=cdr&amp;sp=insert</td>
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
                                <td><?= $tlcdr["cdr"]["s8"]?></td>
                                <td>
                                    <div class="radio">
                                       <label>
                                           <input type="radio" name="jak_cancreate" value="1"<?php if ($jkv["cdrcancreate"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
                                       </label>
                                    </div>
                                    <div class="radio">
                                       <label>
                                           <input type="radio" name="jak_cancreate" value="0"<?php if ($jkv["cdrcancreate"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
                                       </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><?= $tlcdr["cdr"]["s9"]?></td>
                                <td>
                                    <div class="radio">
                                       <label>
                                           <input type="radio" name="jak_canedit" value="1"<?php if ($jkv["cdrcanedit"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
                                       </label>
                                    </div>
                                    <div class="radio">
                                       <label>
                                           <input type="radio" name="jak_canedit" value="0"<?php if ($jkv["ttsftcanedit"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
                                       </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><?= $tlcdr["cdr"]["s10"]?></td>
                                <td>
                                    <div class="radio">
                                       <label>
                                           <input type="radio" name="jak_candelete" value="1"<?php if ($jkv["cdrcandelete"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
                                       </label>
                                    </div>
                                    <div class="radio">
                                       <label>
                                           <input type="radio" name="jak_candelete" value="0"<?php if ($jkv["cdrcandelete"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
                                       </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><?= $tlcdr["cdr"]["s11"]?></td>
                                <td>
                                <div class="form-group<?php if (isset($errors["e3"])) echo " has-error";?>">
                                    <input class="form-control" type="text" name="jak_ftphost" value="<?php echo $jkv["cdrftphost"];?>" />
                                </div>
                                </td>
                            </tr>
                            <tr>
                                <td><?= $tlcdr["cdr"]["s12"]?></td>
                                <td>
                                <div class="form-group<?php if (isset($errors["e3"])) echo " has-error";?>">
                                    <input class="form-control" type="text" name="jak_ftpport" value="<?php echo $jkv["cdrftpport"];?>" />
                                </div>
                                </td>
                            </tr>
                            <tr>
                                <td><?= $tlcdr["cdr"]["s13"]?></td>
                                <td>
                                <div class="form-group<?php if (isset($errors["e3"])) echo " has-error";?>">
                                    <input class="form-control" type="text" name="jak_ftpusername" value="<?php echo $jkv["cdrftpusername"];?>" />
                                </div>
                                </td>
                            </tr>
                            <tr>
                                <td><?= $tlcdr["cdr"]["s14"]?></td>
                                <td>
                                <div class="form-group<?php if (isset($errors["e3"])) echo " has-error";?>">
                                    <input class="form-control" type="text" name="jak_ftppassword" value="<?php echo $jkv["cdrftppassword"];?>" />
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
