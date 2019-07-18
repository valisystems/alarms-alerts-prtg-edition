<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/header.php';?>
<link rel="stylesheet" type="text/css" href="/plugins/analytic/css/style.css">

<?php if (JAK_ASACCESS) $apedit = BASE_URL.'/index.php?p=device';?>


<h3><?= $SECTION_TITLE ?></h3>
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

<hr/>
<form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<div class="row">

    <div class="col-lg-2 col-xs-6">
        <div class="form-group">
            <select class="form-control" name="account">
                <?php 
                foreach ($accounts as $account)
                {
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
            <input type="text" id="start_date_2" name="start_date"  placeholder="Start Date"
                    class="form-control"
                    value="<?= !empty($JAK_FORM_DATA["start_date"]) ? $JAK_FORM_DATA["start_date"] : "" ;?>" 
            />
        </div>
    </div><!-- ./col -->

    <div class="col-lg-2 col-xs-6">
        <div class="datepicker2 form-group">
            <input type="text" id="end_date_2" name="end_date" placeholder="End Date"
                class="form-control" 
                value="<?php if(isset($JAK_FORM_DATA["end_date"])) echo $JAK_FORM_DATA["end_date"];?>"
            /> 
        </div>
    </div><!-- ./col -->

    <div class="col-lg-2 col-xs-6">
        <div class="form-group">
            <select class="form-control" name="call_type">
                <option value="">Select call type</option>
                <option value="missed" <?php if ($JAK_FORM_DATA['call_type'] == 'missed') echo ' selected="selected"' ; ?> >Missed Calls</option>
                <option value="answered" <?php if ($JAK_FORM_DATA['call_type'] == 'answered') echo ' selected="selected"' ; ?>>Answered Calls</option>
            </select>
        </div>
    </div><!-- ./col -->

    <div class="col-lg-2 col-xs-6">
        <button type="submit" name="table" class="btn btn-primary">Submit</button>
    </div><!-- ./col -->

</div><!-- /.row -->
</form>


<script type="text/javascript" src="/plugins/analytic/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/plugins/analytic/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="/plugins/analytic/js/jszip.min.js"></script>
<script type="text/javascript" src="/plugins/analytic/js/pdfmake.min.js"></script>
<script type="text/javascript" src="/plugins/analytic/js/vfs_fonts.js"></script>
<script type="text/javascript" src="/plugins/analytic/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="/plugins/analytic/js/buttons.print.min.js"></script>

<?php if(!empty($table_data)){?>

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body no-padding">
                    <table id="cdrFilter" class="table">
                        <thead>
                            <tr class='warning'>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Duration</th>
                                <th>Ring Duration</th>
                                <?php
                                    if ($JAK_FORM_DATA["call_type"] == "missed")
                                        echo "<th>Miss call detail</th>";
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Turing UTC dates to CMS timezone
                            $CastDate = new CastDate(null, 'UTC', $jkv["timezoneserver"]);
                            foreach ($table_data as $row)
                            {
                                ?>
                                <tr>
                                    <td><?= $CastDate->cast($row["timestart"], 'date_time'); ?></td>
                                    <td><?= $CastDate->cast($row["timeend"], 'date_time'); ?></td>
                                    <td><?= gmdate("H:i:s", $row["duration"]); ?></td>
                                    <td><?= gmdate("H:i:s", $row["ringduration"]); ?></td>
                                    <?php
                                    if ( $JAK_FORM_DATA["call_type"] == "missed" && 
                                        empty($row["timeconnect"]) && 
                                        $row["timeconnect"] == null
                                        )
                                    {
                                        if (empty($row["ringduration"]))
                                        {
                                            echo "<td>Call cut by caller.</td>";
                                        }
                                        elseif ($row["ringduration"] != 0)
                                        {
                                            echo "<td>Call cut by receiver.</td>";
                                        }
                                    }
                                    ?>
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
        $('#cdrFilter').DataTable( {
            pageLength : 50,
			aaSorting: [[0,'desc']],
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

<script type="text/javascript" src="/plugins/analytic/js/moment.js"></script>
<script type="text/javascript" src="/plugins/analytic/js/daterangepicker.js"></script>
<script type="text/javascript">
$(document).ready(function() {

    var dateFormat = {
        todayHighlight: false,
        todayBtn:  'linked',

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



<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/footer.php';?>
