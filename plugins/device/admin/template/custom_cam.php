<?php include_once APP_PATH.'admin/template/header.php';?>

<?php if(!empty($credentials)) { ?>
<script type="text/javascript">
    var cam_credentials = <?=  json_encode($credentials) ?>;
</script>
<?php  } ?>
<script type="text/javascript" language="javascript" src="../plugins/device/js/cust_cam.js"></script>

<?php

//login in form
if ($login_form)
{
    ?>
    <form class="form-horizontal" method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
        <input type="hidden" name="action" value="loginAction" />
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="from">Server</label>
            <div class="col-md-4">
                <input id="address" name="server" type="text" placeholder="http://videomaximum.myvnc.com" value="<?= $jkv["devicecamhost"]; ?>" class="form-control input-md" required="">
            </div>
        </div>

        <div class="form-group">
          <label class="col-md-4 control-label" for="from">Port</label>
            <div class="col-md-4">
                <input id="address" name="port" type="text" placeholder="9786" value="<?php echo str_replace(":", "", $jkv["devicecamport"]);?>" class="form-control input-md" required="">
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="from">Username</label>
          <div class="col-md-4">
            <input id="address" name="username" type="text" value="<?= $jkv["devicecamusername"]; ?>" class="form-control input-md" required="">
          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="from">Password</label>
          <div class="col-md-4">
            <input id="address" name="password" type="text" value="<?= $jkv["devicecampassword"]; ?>" class="form-control input-md" required="">
          </div>
        </div>

        <!-- Button -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="singlebutton"></label>
          <div class="col-md-4">
            <button name="submit"  class="btn btn-primary url_button">Submit</button>
          </div>
        </div>

    </form>
    <?php
}
// end of login form
?>

<?php
// Cam images
if ($cam_images) {

    if ($cam_images)
        {
            ?>
            <div class="row">
            <?php
                $count = count($cam_images);
                foreach ($cam_images as $k => $v)
                {
                ?>
                  <div class="col-sm-6 col-md-4">
                    <div class="thumbnail">

                      <img src="<?= $v["image"] ?>" alt="<?= $v['name']?>">
                      <div class="caption">
                        <h3><?= $v['name'] . ' - ' . $v['id']?></h3>
                        <p>
                            <a href="#" data-camid="<?= $v['id'] ?>" class="btn btn-default flashCode" role="button">Generate Flash Code</a>
                            <a href="#" data-camid="<?= $v['id'] ?>" class="btn btn-default htmlCode" role="button">Generate Html Code</a>
                        </p>
                      </div>
                    </div>
                  </div>
                <?php
                }
            ?>
            </div>
            <?php
        }
    else
    {
        echo '<h3>No camera found.</h3>';
    }

}
// end Cam images
?>

<?php
// flash Code generate
if ($generate_flash_code)
    {
    ?>
    <form class="form-horizontal" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
        <input type="hidden" name="action" value="login" />
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="from">Name</label>
          <div class="col-md-4">
            <input id="address" name="name" type="text" class="form-control input-md" required="">
          </div>
        </div>
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="from">FPS</label>
          <div class="col-md-4">
            <input id="address" name="fps" type="text" value="8"  class="form-control input-md" required="">
          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="from">Quality</label>
          <div class="col-md-4">
            <input id="address" name="quality" type="text" value="60" class="form-control input-md" required="">
          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="from">Resolution</label>
          <div class="col-md-4">
            <input id="address" name="res_1" type="text" class="form-control input-md">
          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="from">Sound</label>
          <div class="col-md-4">
            <input id="address" name="sound" type="checkbox" class="form-control input-md" >
          </div>
        </div>
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="from">Autoplay</label>
          <div class="col-md-4">
            <input id="address" name="autoplay" type="checkbox" class="form-control input-md">
          </div>
        </div>
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="from">PTZ</label>
          <div class="col-md-4">
            <input id="address" name="ptz" type="checkbox" class="form-control input-md" >
          </div>
        </div>

        <!-- Button -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="singlebutton">Generate Call</label>
          <div class="col-md-4">
            <button name="call_url" data-type="make_call" class="btn btn-primary url_button">Submit</button>
          </div>
        </div>

    </form>

    <?php
    }
// End of flash Code generate
?>


<?php include_once APP_PATH.'admin/template/footer.php';?>