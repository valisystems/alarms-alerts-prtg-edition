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
        ?>
    </div>
<?php } ?>

<div class="row">
    <div class="col-sm-2">

        <form method="POST" action="<?= $_SERVER['REQUEST_URI']; ?>"> 
            <input type="hidden" name="action" value="clear_all_accounts" />
            <button class="btn btn-default" type="submit" data-toggle="tooltip" title="Download all files in zip folder">
                <i class="fa fa-trash"></i> Clear all accounts
            </button>
        </form>

    </div>
</div>
<br/>

<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"></h3>
            </div><!-- /.box-header -->

            <form method="POST" action="<?= $_SERVER['REQUEST_URI']; ?>">
                <input type="hidden" name="action" value="syn_accounts" />
                <div class="box-body">

                    <table class="table table-striped">
                        <tr>
                            <td><label>Domain</label></td>
                            <td>
                                <div class="form-group<?php if (isset($errors["e1"])) echo " has-error";?>">
                                    <input class="form-control" value="localhost" type="text" name="domain" />
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Type</td>
                            <td>
                                <div class="form-group<?php if (isset($errors["e1"])) echo " has-error";?>">
                                    <select name="type" class="form-control">
                                        <option value="extensions">Extensions</option>
                                        <option value="hunts">Ring Groups</option>
                                        <option value="attendants">Attendants</option>
                                    </select> 
                                </div>
                            </td>
                        </tr>
                    </table>

                </div>

                <div class="box-footer">
                    <button type="submit" name="save" class="btn btn-primary pull-right">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php include_once APP_PATH.'admin/template/footer.php';?>
