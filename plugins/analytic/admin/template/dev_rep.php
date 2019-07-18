<?php include_once APP_PATH.'admin/template/header.php';?>

<link rel="stylesheet"  href="/plugins/analytic/css/jquery.dataTables.min.css" />
<link rel="stylesheet"  href="/plugins/analytic/css/buttons.dataTables.min.css" />
<link rel="stylesheet"  href="/plugins/analytic/css/daterangepicker.css" />

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
            <select class="form-control" id="base_name" name="base_name">
                <option value=''>-- Select Basename --</option>
                <?php foreach ($devices_arr as $k => $device) {
                    if (!empty($JAK_FORM_DATA["base_name"]) && $JAK_FORM_DATA["base_name"] == $k)
                        echo "<option value='".$k."' selected='selected' >" . $device . "</option>";
                    else
                        echo "<option value='".$k."' >" . $device . "</option>";
                } ?>
            </select>
        </div>
    </div><!-- ./col -->

    <div class="col-lg-2 col-xs-6">
        <div class="form-group">
            <select class="form-control" id="device_id" name="device_id">
                <option value=''>-- Select device --</option>
				<?php if(!empty($sensors)){ 
					foreach ($sensors as $k => $sensor) {
                    if (!empty($JAK_FORM_DATA["device_id"]) && $JAK_FORM_DATA["device_id"] == $k)
                        echo "<option value='".$k."' selected='selected' >" . $sensor . "</option>";
                    else
                        echo "<option value='".$k."' >" . $sensor . "</option>";
                } }?>
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
        <div class="form-group">
            <select class="form-control" name="graph_type">
            	<option>Select Graph Type</option>
            	<option value="response" <?php if(isset($JAK_FORM_DATA["graph_type"]) && $JAK_FORM_DATA["graph_type"] =="response" ) echo "selected='selected'" ?> >Response Time</option>
            	<option value="total" <?php if(isset($JAK_FORM_DATA["graph_type"]) && $JAK_FORM_DATA["graph_type"] =="total" ) echo "selected='selected'" ?> >Total Alarms</option>
            </select> 
        </div>
    </div><!-- ./col -->

    <div class="col-lg-2 col-xs-6">
        <button type="submit" name="graph" class="btn btn-primary">Submit</button>
    </div><!-- ./col -->

</div><!-- /.row -->
</form>

<!-- *************  Graph  *************** -->
<script type="text/javascript" src="/plugins/analytic/js/highcharts.min.js"></script>
<script type="text/javascript" src="chart/exporting.js"></script>
<?php
if ($total_alarm_graph) {
    ?>
    <div class="row">
	    <div class="col-md-12">
	        <div class="box">
	            <div class="box-header">
	                <i class="fa fa-line-chart"></i>
	            <h3 class="box-title">Total Alarms</h3>
	            </div><!-- /.box-header -->
	            <div class="box-body no-padding">
	                <div id="total_alarm_graph" class="charts"></div>
	            </div>
	        </div>
	    </div>
	</div>
    <script type="text/javascript">
        //http://jsfiddle.net/gh/get/jquery/1.9.1/highslide-software/highcharts.com/tree/master/samples/highcharts/demo/spline-irregular-time/
        $("#total_alarm_graph").highcharts({
            chart: {
                type: 'spline'
            },
            title: 'Total Alarms',
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
                  text: 'Total Alarms'
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
            series: <?=json_encode($total_alarm_graph);?>
        });
        
    </script>
    <?php
}

if (!empty($response_time_graph))
	{
	?>

	<div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <i class="fa fa-line-chart"></i>
                    <h3 class="box-title">Response Time</h3>
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                    <div id="response_time_graph" class="charts"></div>
                </div>
            </div>
        </div>
    </div>

	<script type="text/javascript">
		 function secondsTimeSpanToHMS(s) {
		    var h = Math.floor(s / 3600); //Get whole hours
		    s -= h * 3600;
		    var m = Math.floor(s / 60); //Get remaining minutes
		    s -= m * 60;
		    return h + ":" + (m < 10 ? '0' + m : m) + ":" + (s < 10 ? '0' + s : s); //zero padding on minutes and seconds
		}
	    //http://jsfiddle.net/gh/get/jquery/1.9.1/highslide-software/highcharts.com/tree/master/samples/highcharts/demo/spline-irregular-time/
	    $('#response_time_graph').highcharts({
	        chart: {
	            type: 'spline'
	        },
	        title: 'Response Duration',
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
	                text: 'Time'
	            },
	            type: 'datetime',
	            dateTimeLabelFormats: { //force all formats to be hour:minute:second
	                second: '%H:%M:%S',
	                minute: '%H:%M:%S',
	                hour: '%H:%M:%S',
	                day: '%H:%M:%S',
	                week: '%H:%M:%S',
	                month: '%H:%M:%S',
	                year: '%H:%M:%S'
	            },
	            min: 0
	        },
	        plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true,
                        formatter: function(){
                            if( this.series.index == 0 ) {
                                return secondsTimeSpanToHMS(this.y/1000) ;
                            } else {
                                return this.y;
                            }
                        }
                    },
                    enableMouseTracking: false
                }
            },
	        tooltip: {
	            formatter: function() {
	                    return  '<b>' + this.series.name +'</b><br/>' +
	                        Highcharts.dateFormat('%e, %b',new Date(this.x))
	                    + ' - ' + secondsTimeSpanToHMS(this.y/1000);
	                }
	        },
	        series: <?=json_encode($response_time_graph);?>
	    });
	</script>
	<?php
	}
?>
<!-- ************* End of  Graph  *************** -->

<!-- ************* Table Data ************** -->
<script type="text/javascript" src="/plugins/analytic/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/plugins/analytic/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="/plugins/analytic/js/jszip.min.js"></script>
<script type="text/javascript" src="/plugins/analytic/js/pdfmake.min.js"></script>
<script type="text/javascript" src="/plugins/analytic/js/vfs_fonts.js"></script>
<script type="text/javascript" src="/plugins/analytic/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="/plugins/analytic/js/buttons.print.min.js"></script>

<?php if(!empty($report)){?>

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body no-padding">
                    <table id="device_report" class="table">
                        <thead>
                            <tr class='warning'>
                                <th>Base Name - Device ID</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Response Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($report as $row)
                            {
                                ?>
                                <tr>
                                    <td><?= $row["base_name"]; ?> - <?= $row["device_id"]; ?></td>
                                    <td>
                                    	<?php 
                                    		$start_datetime = new DateTime($row["starttime"]); 
                                    		echo $start_datetime->format("F d, Y H:i:s");
                                    	?>
                                    </td>
                                    <td>
                                    	<?php
                                    		$end_datetime = new DateTime($row["endtime"]); 
                                    		echo $end_datetime->format("F d, Y H:i:s");
                                    	?>
                                    </td>
                                    <td>
                                    	<?php
                                    		$s_date = new DateTime($row["starttime"]);
                                    		$interval = $s_date->diff(new DateTime($row["endtime"]));
                                    		if ($since_start->d != NULL)
												echo $interval->format("%R%a days");
											else
												echo $interval->format("%H:%I:%S");
                                    	?>

                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
    $(document).ready(function() {
        $('#device_report').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excel', 'pdf'
            ]
        });
    });
    </script>
<?php }
else
{
	?>
	<div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning" role="alert">
                <strong>Info!</strong> No result found.
            </div>
        </div>
    </div>
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
	
	
        $("#base_name").change(function(){
            var data =  {
                            "action": "sensors",
                            "basename": $(this).val()
                        };
            $.ajax({
                type: 'POST',
                datatype:'json',
                url: '/admin/index.php/?p=analytic&sp=ajax',
                data: data,
                success: function(sensors) {
                    $('#device_id').find('option').remove();
                    if (sensors)
                    {
                        $('#device_id').append('<option value="">-- Select device --</option>');
                        $.each(jQuery.parseJSON(sensors), function(key, value) {
                            $('#device_id').append($("<option></option>").attr("value",key).text(value)); 
                        });
                    }
                    else{
                        $('#device_id').append('<option value="">-- No devices found --</option>');
                    }
                    
                    
                },
                error:function(msg){
                    console.log(msg);
                }
            });
                
        });

});
</script>

<?php include_once APP_PATH.'admin/template/footer.php';?>
