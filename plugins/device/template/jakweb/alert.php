<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/header.php';?>

<?php if ($errors) { ?>
    <div class="alert alert-danger fade in">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <?php foreach ($errors as $k => $error) echo $error; ?>
    </div>
<?php } ?>



<div class="row">
    <div class="col-md-6">
        <form id="remote-call" method="GET" >
            <input type="hidden" name="p" value="device" />
            <input type="hidden" name="sp" value="alert" />
            <div class="form-group">
                <label>Hunt group Account</label>
                <input type="text" name="acc" required class="form-control" value="<?php if(isset($_REQUEST["acc"])) echo $_REQUEST["acc"];?>" />
            </div>

            <div class="form-group">
                <label>Call From</label>
                <input type="text" name="dest" required class="form-control" value="<?php if(isset($_REQUEST["dest"])) echo $_REQUEST["dest"];?>" />
            </div>

            <button type="submit" class="btn btn-default" >Submit</button>
        </form>
    </div>

</div>



<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/footer.php';?>
