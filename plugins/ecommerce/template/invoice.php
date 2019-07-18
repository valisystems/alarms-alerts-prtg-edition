<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $jkv["title"].' - '.$jkv["e_title"];?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- General Stylesheet with custom modifications -->
    <link rel="stylesheet" href="<?php echo BASE_URL;?>css/stylesheet.css?=<?php echo $jkv["updatetime"];?>" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo BASE_URL;?>admin/css/admin.css?=<?php echo $jkv["updatetime"];?>" type="text/css" media="screen" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="wrapper">
      <!-- Main content -->
      <section class="invoice">
        <!-- title row -->
        <div class="row">
          <div class="col-xs-12">
            <h2 class="page-header">
              <i class="fa fa-globe"></i> <?php echo $jkv["title"].' - '.$tlec["shop"]["m79"];?>
              <small class="pull-right"><?php echo $tlec["shop"]["m80"];?>: <?php echo date($jkv["shopdateformat"].$jkv["shoptimeformat"], strtotime($row["time"]));?></small>
            </h2>
          </div><!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
          <div class="col-sm-4 invoice-col">
            <h4><?php echo $tlec["shop"]["m42"];?></h4>
            <address>
              <?php echo $jkv["e_shop_address"];?>
            </address>
          </div><!-- /.col -->
          <div class="col-sm-4 invoice-col">
            <h4><?php echo $tlec["shop"]["m1"];?></h4>
            <address>
              <?php if ($row["company"]) { echo $row["company"].'<br />'; } echo $row["name"].'<br />'.$row["address"].'<br />'.$row["city"].' '.$row["zip_code"].'<br />'.$JAK_COUNTRY;?>
            </address>
          </div><!-- /.col -->
          <div class="col-sm-4 invoice-col">
            <h4><?php echo $tlec["shop"]["m81"];?></h4>
            <address>
              <?php if ($row['sh_name']) { if ($row["sh_company"]) { echo $row["sh_company"].'<br />'; } echo $row["sh_name"].'<br />'.$row["sh_address"].'<br />'.$row["sh_city"].' '.$row["sh_zip_code"].'<br />'.$JAK_SHCOUNTRY;
              
              } else {
              
              if ($row["company"]) { echo $row["company"].'<br />'; } echo $row["name"].'<br />'.$row["address"].'<br />'.$row["city"].' '.$row["zip_code"].'<br />'.$JAK_COUNTRY;
              
              } ?>
            </address>
          </div><!-- /.col -->
        </div><!-- /.row -->

        <!-- Table row -->
        <div class="row">
          <div class="col-xs-12 table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th><?php echo $tlec["shop"]["m83"];?></th>
                  <th><?php echo $tlec["shop"]["m82"];?></th>
                  <th><?php echo $tlec["shop"]["m84"];?></th>
                </tr>
              </thead>
              <tbody>
              <?php if (isset($jak_ordered) && is_array($jak_ordered)) foreach($jak_ordered as $jo) { ?>
              
              <tr<?php if (!$row["paid"] == 1) { ?> class="unpaid"<?php } ?>>
              	<td><?php echo $jo["total_item"];?> x </td>
              	<td><?php echo $jo["title"];?><?php if ($jo["product_option"]) { echo '&nbsp;('. $jo["product_option"] .')&nbsp;'; } ?></td>
              	<td><span><?php echo $jo["price"];?>&nbsp;<?php echo $row["currency"]; if ($jo["coupon_price"] != "0.00" && $jo["price"] != $jo["coupon_price"]) { echo ' ('.$tlec["shop"]["m86"].$jo["coupon_price"].'&nbsp;'.$row["currency"].')';}?></span></td>
              </tr>
              
              <?php } ?>
              </tbody>
            </table>
          </div><!-- /.col -->
        </div><!-- /.row -->

        <div class="row">
          <!-- accepted payments column -->
          <div class="col-xs-6">
          <p class="lead"><?php echo $jkv["e_title"];?></p>
            <div class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
              <?php echo $jkv["e_thanks"];?>
            </div>
          </div><!-- /.col -->
          <div class="col-xs-6">
            <p class="lead"><b><?php echo $tlec["shop"]["m76"].'</b>: '.$row["ordernumber"];?></p>
            <div class="table-responsive">
              <table class="table">
                <tr>
                  <th><?php echo $tlec["shop"]["m85"];?></th>
                  <td><?php echo $row["tax"];?>&nbsp;<?php echo $row["currency"];?></td>
                </tr>
                <tr>
                  <th><?php echo $tlec["shop"]["m86"];?>:</th>
                  <td><?php if ($row["freeshipping"]) { echo $tl["shop"]["m81"]; } else { echo $row["shipping"].' '.$row["currency"];}?></td>
                </tr>
                <tr>
                  <th><?php echo $tlec["shop"]["m2"];?></th>
                  <td><?php echo $row["total_price"];?>&nbsp;<?php echo $row["currency"];?></td>
                </tr>
              </table>
            </div>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </section><!-- /.content -->
    </div><!-- ./wrapper -->
  </body>
</html>