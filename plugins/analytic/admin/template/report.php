<?php include_once APP_PATH.'admin/template/header.php';?>

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

<!-- Graph filter (Stat box) -->
<form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<div class="row">

    <div class="col-lg-2 col-xs-6">
        <div class="form-group">
            <select class="form-control" name="account">
                <?php foreach ($accounts as $account){
                    if (!empty($JAK_FORM_DATA["account"]) && $JAK_FORM_DATA["account"] == $account["account"])
                        echo "<option value='".$account['account']."' selected='selected' >" . $account["name"] . "</option>";
                    else
                        echo "<option value='".$account['account']."' >" . $account["name"] . "</option>";
                } ?>
            </select>
        </div>
    </div><!-- ./col -->

    <div class="col-lg-2 col-xs-6">
        <div class="datepicker1 form-group">
            <input type="text" name="start_date"  placeholder="Start Date"
                    class="form-control"
                    value="<?= !empty($JAK_FORM_DATA["start_date"]) ? $JAK_FORM_DATA["start_date"] : "" ;?>" 
            />
        </div>
    </div><!-- ./col -->

    <div class="col-lg-2 col-xs-6">
        <div class="datepicker2 form-group">
            <input type="text" name="end_date" placeholder="End Date"
                class=" form-control" 
                value="<?php if(isset($JAK_FORM_DATA["end_date"])) echo $JAK_FORM_DATA["end_date"];?>"
            /> 
        </div>
    </div><!-- ./col -->

    <div class="col-lg-2 col-xs-6">
        <button type="submit" name="graph" class="btn btn-primary">Submit</button>
    </div><!-- ./col -->

</div><!-- /.row -->
</form>

<?php
if ($graphData["graph_data"]) {
    ?>
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3 id="num_accounts">
                    <?= gmdate("H:i:s", $graphData["per_day"]['max_missed_rings']); ?>
                </h3>
                <p>Maximum missed call ring time (approx).</p>
            </div>
                <div class="icon">
                    <i class="fa fa-phone-square"></i>
                </div>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner">
                <h3 id="num_alerts"><?= gmdate("H:i:s", $graphData["per_day"]['min_missed_rings']); ?></h3>
                <p>Minimum missed call ring time (approx).</p>
              </div>
              <div class="icon">
                <i class="fa fa-phone"></i>
              </div>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3 id="num_no_alerts"><?= gmdate("H:i:s", $graphData["per_day"]['max_answered_rings']); ?></h3>
                    <p>Maximum answer call ring time (approx).</p>
                </div>
                <div class="icon">
                    <i class="fa fa-phone"></i>
                </div>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- Small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3 id="num_devices"><?= gmdate("H:i:s", $graphData["per_day"]['min_answered_rings']);  ?></h3>
                    <p>Minimum answer call ring time (approx).</p>
                </div>
                <div class="icon">
                    <i class="fa fa-phone-square"></i>
                </div>
            </div>
        </div><!-- ./col -->
    </div><!-- /.row -->

<br/>

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <i class="fa fa-line-chart"></i>
                    <h3 class="box-title">Call data Statistic</h3>
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                    <div id="chart_total" class="charts"></div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="/plugins/analytic/js/highcharts.min.js"></script>
    <script type="text/javascript" src="chart/exporting.js"></script>
    <script type="text/javascript">
        //http://jsfiddle.net/gh/get/jquery/1.9.1/highslide-software/highcharts.com/tree/master/samples/highcharts/demo/spline-irregular-time/
        $('#chart_total').highcharts({
            chart: {
                type: 'spline'
            },
            title: 'Calls',
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: { // don't display the dummy year
                    month: '%e. %b',
                    year: '%b'
                },
                title: {
                    text: 'Date'
                }
            },
            yAxis: {
                title:{
                  text: 'Calls'
                },
                min: 0
            },
            tooltip: {
                headerFormat: '<b>{series.name}</b><br>',
                pointFormat: '{point.x:%b, %e} - {point.y} calls'
            },
            plotOptions: {
                spline: {
                    marker: {
                        enabled: true
                    }
                }
            },
            series: <?=json_encode($graphData["graph_data"]);?>
        });
    </script>
    <?php
}
?>

<link rel="stylesheet"  href="/plugins/analytic/css/daterangepicker.css" />
<script type="text/javascript" src="/plugins/analytic/js/moment.js"></script>
<script type="text/javascript" src="/plugins/analytic/js/daterangepicker.js"></script>
<script type="text/javascript">
$(document).ready(function() {

    var dateFormat = {

        ranges: {

            Today: [new Date, new Date],

            Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],

            "Last 7 Days": [moment().subtract(6, "days"), new Date],

            "Last 30 Days": [moment().subtract(29, "days"), new Date],

            "This Month": [moment().startOf("month"), moment().endOf("month")],

            "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]

        },
        opens: "left",
        locale: {
            format: "YYYY-MM-DD"
        },
        // startDate: moment().startOf("month"),
        // endDate: moment().endOf("month")
    };

    if ($(".datepicker1"))
    {
        $(".datepicker1").daterangepicker(dateFormat, function(from, to, label){
            $(".datepicker1 input").val(from.format("MMMM D, YYYY"));
            $(".datepicker2 input").val(to.format("MMMM D, YYYY"));
        });

        $(".datepicker2").daterangepicker(dateFormat, function(from, to, label){
            $(".datepicker1 input").val(from.format("MMMM D, YYYY"));
            $(".datepicker2 input").val(to.format("MMMM D, YYYY"));
        });
    }


});
</script>

<form method="POST" action="/admin/index.php?p=analytic&amp;sp=accts&amp;ssp=filter">
    <input type="hidden" name="account" value="<?= !empty($JAK_FORM_DATA["account"]) ? $JAK_FORM_DATA["account"] : "" ;?>" >
    <input type="hidden" name="start_date" value="<?= !empty($JAK_FORM_DATA["start_date"]) ? $JAK_FORM_DATA["start_date"] : "" ;?>" >
    <input type="hidden" name="end_date" value="<?= !empty($JAK_FORM_DATA["end_date"]) ? $JAK_FORM_DATA["end_date"] : "" ;?>" >
    <button type="submit" class="btn btn-primary pull-right">Detail Report</button>
</form>

<?php include_once APP_PATH.'admin/template/footer.php';?>
