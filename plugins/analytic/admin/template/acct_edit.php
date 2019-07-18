<?php include_once APP_PATH.'admin/template/header.php';?>

<?php if ($page4 == "s") { ?>
<div class="alert alert-success fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?php echo $tl["general"]["g7"];?>
</div>
<?php } if ($page4 == "e") { ?>
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

<a class="btn btn-primary pull-right" href="/admin/index.php?p=analytic&amp;sp=accts">Back to Accounts</a>
<div class="clearfix"></div>
<form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">

        <div class="row">
            <div class="col-md-7">
                <div class="box box-primary">
                	  <div class="box-header with-border">
                	    <h3 class="box-title"><?php echo $tl["title"]["t13"];?></h3>
                	  </div><!-- /.box-header -->
                	  <div class="box-body">
                        <table class="table table-striped">
                            <tr>
                                <td>ID</td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="id" readonly="readonly" class="form-control" value="<?php if(isset($JAK_FORM_DATA["id"])) echo $JAK_FORM_DATA["id"];?>" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Domain</td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="domain" class="form-control" readonly="readonly" value="<?php if(isset($JAK_FORM_DATA["domain"])) echo $JAK_FORM_DATA["domain"];?>" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Account</td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="account" class="form-control" readonly="readonly" value="<?php if(isset($JAK_FORM_DATA["account"])) echo $JAK_FORM_DATA["account"];?>" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td>
                                    <div class="form-group<?php if (isset($errors["e1"])) echo " has-error";?>">
                                        <input type="text" name="name" class="form-control" value="<?php if(isset($JAK_FORM_DATA["name"])) echo $JAK_FORM_DATA["name"];?>" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="description" class="form-control" value="<?php if(isset($JAK_FORM_DATA["description"])) echo $JAK_FORM_DATA["description"];?>" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Type</td>
                                <td>
                                    <div class="form-group<?php if (isset($errors["e2"])) echo " has-error";?>">
                                        <input type="text" name="type" class="form-control" value="<?php if(isset($JAK_FORM_DATA["type"])) echo $JAK_FORM_DATA["type"];?>" />
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                	<div class="box-footer">
                	  	<button type="submit" class="btn btn-primary pull-right">
                            <?php echo $tl["general"]["g20"];?>
                        </button>
                	</div>
            </div>
        </div>
    </div>

</form>

<script type="text/javascript">

    $(document).ready(function() {

    	$('#cmsTab a').click(function (e) {
    	  e.preventDefault();
    	});

        $('form').submit(function() {
        });

    });
    
</script>

<?php include_once APP_PATH.'admin/template/footer.php';?>