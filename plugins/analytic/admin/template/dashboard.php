<?php include_once APP_PATH.'admin/template/header.php';?>


<!-- Small boxes (Stat box) -->
<div class="row">
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-aqua">
      <div class="inner">
        <h3 id="num_accounts">0</h3>
        <p>Total PBX Accounts</p>
      </div>
      <div class="icon">
        <i class="fa fa-users"></i>
      </div>
      <a href="index.php?p=analytic&amp;sp=accts" class="small-box-footer"><?php echo $tl["stat"]["s6"];?> <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div><!-- ./col -->
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-red">
      <div class="inner">
        <h3 id="num_alerts">0</h3>
        <p>Alarms</p>
      </div>
      <div class="icon">
        <i class="fa fa-bell-o"></i>
      </div>
      <a href="index.php?p=device" class="small-box-footer"><?php echo $tl["stat"]["s6"];?> <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div><!-- ./col -->
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-green">
      <div class="inner">
        <h3 id="num_no_alerts">0</h3>
        <p>Devices</p>
      </div>
      <div class="icon">
        <i class="fa fa-plug"></i>
      </div>
      <a href="index.php?p=device" class="small-box-footer"><?php echo $tl["stat"]["s6"];?> <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div><!-- ./col -->
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-yellow">
      <div class="inner">
        <h3 id="num_devices">0</h3>
        <p>Total Devices</p>
      </div>
      <div class="icon">
        <i class="fa fa-flash"></i>
      </div>
      <a href="index.php?p=device" class="small-box-footer"><?php echo $tl["stat"]["s6"];?> <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div><!-- ./col -->
</div><!-- /.row -->

<div class="row">
<form method="POST">
    <div class="col-lg-2 col-xs-6">
        <div class="start_date form-group">
            <input type="text" name="start_date"  placeholder="Start Date"
                    class="datepicker form-control"
                    value="<?= !empty($JAK_FORM_DATA["start_date"]) ? $JAK_FORM_DATA["start_date"] : "" ;?>" 
            />
        </div>
    </div>
    <div class="col-lg-2 col-xs-6">
        <div class="end_date form-group">
            <input type="text" name="end_date" placeholder="End Date"
                class="datepicker form-control" 
                value="<?php if(isset($JAK_FORM_DATA["end_date"])) echo $JAK_FORM_DATA["end_date"];?>"
            /> 
        </div>
    </div>
    <div class="col-lg-2 col-xs-6">
        <button type="submit" name="save" class="btn btn-primary">Submit</button>
    </div>
</form>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header">
                <i class="fa fa-line-chart"></i>
            <h3 class="box-title">Devices Statistic</h3>
            </div><!-- /.box-header -->
            <div class="box-body no-padding">
                <div id="chart_total" class="charts"></div>
            </div>
        </div>
    </div>
</div>


<?php
if ($g_data) {
    ?>
    <script type="text/javascript" src="/plugins/analytic/js/highcharts.min.js"></script>
    <script type="text/javascript" src="chart/exporting.js"></script>
    <script type="text/javascript">
    function totalAlerts(element, data){
            //http://jsfiddle.net/gh/get/jquery/1.9.1/highslide-software/highcharts.com/tree/master/samples/highcharts/demo/spline-irregular-time/
            $(element).highcharts({
                chart: {
                    type: 'spline'
                },
                title: 'Number of Alerts',
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
                      text: 'Number of Alerts'
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
                series: data
            });
        }
        totalAlerts('#chart_total', <?=json_encode($g_data);?>)
    </script>
    <?php
}
?>

<link rel="stylesheet"  href="/plugins/analytic/css/daterangepicker.css" />
<script type="text/javascript" src="/plugins/analytic/js/moment.js"></script>
<script type="text/javascript" src="/plugins/analytic/js/daterangepicker.js"></script>
<script type="text/javascript">
$(document).ready(function() {

    getdevicestate();
    setInterval(function(){
        getdevicestate()
    }, 4000);
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

    if ($(".start_date"))
    {
        $(".start_date").daterangepicker(dateFormat, function(from, to, label){
            $(".start_date input").val(from.format("MMMM D, YYYY"));
            $(".end_date input").val(to.format("MMMM D, YYYY"));
        });

        $(".end_date").daterangepicker(dateFormat, function(from, to, label){
            $(".start_date input").val(from.format("MMMM D, YYYY"));
            $(".end_date input").val(to.format("MMMM D, YYYY"));
        });
    }

});

function getdevicestate()
{
    $.get("/admin/index.php/?p=analytic&sp=ajax&sssp=get", function (data) {
        if (data)
        {
            var obj = JSON.parse(data);
            $("#num_accounts").html(obj.pbx_accounts);
            $("#num_alerts").html(obj.alerts);
            $("#num_no_alerts").html(obj.noalerts);
            $("#num_devices").html(obj.devices);
        }
    });
}

</script>

<?php include_once APP_PATH.'admin/template/footer.php';?>
