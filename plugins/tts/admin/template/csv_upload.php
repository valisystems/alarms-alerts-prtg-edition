<?php include_once APP_PATH.'admin/template/header.php';?>

<?php
	if (JAK_ASACCESS) $apedit = BASE_URL.'admin/index.php?p=tts';
?>

<?php if ($errors) { ?>
    <div class="alert alert-danger fade in">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <?php if (isset($errors["e"])) echo $errors["e"];
              if (isset($errors["e1"])) echo $errors["e1"];
              if (isset($errors["e2"])) echo $errors["e2"];
              if (isset($errors["e3"])) echo $errors["e3"];
        ?>
    </div>
<?php } ?>

    <h4>Converter all Text files to WAV Files</h4>
    
    <div id="dvData">
        <table>
            <tr>
                <td>rooms</td>
                <td>text</td>
            </tr>
            <tr>
                <td>room1</td>
                <td>Hello, this is room one.</td>
            </tr>
            <tr>
                <td>room2</td>
                <td>Hello, this is room two.</td>
            </tr>
        </table>
    </div>
    
<br/>

<div class="row">
    <div class="col-md-7">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Upload CSV File</h3>
                <p>Please select 'Convert now' - 'Yes' only if files are less than 10.</p>
            </div><!-- /.box-header -->

            <form method="POST" action="<?= BASE_URL.'index.php?p=tts'; ?>" enctype="multipart/form-data">
                <div class="box-body">


                    <table class="table table-striped">
                      <tr>
                              <td><label>Upload CSV</label></td>
                              <td>
                                  <div class="form-group<?php if (isset($errors["e1"])) echo " has-error";?>">
                                        <input type="file" name="csv"/> 
                                    </div>
                                </td>
                            </tr>
                            <tr>
                              <td>Convert now</td>
                              <td>
                                    <div class="radio">
                                       <label>
                                           <input type="radio" name="convert_now" value="1"<?php if ($jkv["convert_now"] == 1) { ?> checked="checked"<?php } ?> /> Yes
                                       </label>
                                    </div>
                                    <div class="radio">
                                       <label>
                                           <input type="radio" name="convert_now" value="0"<?php if ($jkv["convert_now"] == 0) { ?> checked="checked"<?php } ?> /> No
                                       </label>
                                    </div>
                                </td>
                            </tr>

                      </table>

                </div>

                <div class="box-footer">
                    <button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<a class="btn btn-warning export" href="plugins/tts/csv.csv"><i class="fa fa-download"></i>Sample file</a>

<script type="text/javascript">
$(document).ready(function () {

    function exportTableToCSV($table, filename)
    {
        var $rows = $table.find('tr:has(td)'),

        // Temporary delimiter characters unlikely to be typed by keyboard
        // This is to avoid accidentally splitting the actual contents
        tmpColDelim = String.fromCharCode(11), // vertical tab character
        tmpRowDelim = String.fromCharCode(0), // null character

        // actual delimiter characters for CSV format
        colDelim = ',',
        rowDelim = '\r\n',

        // Grab text from table into CSV formatted string
        csv =  $rows.map(function (i, row) {
            var $row = $(row),
                $cols = $row.find('td');

            return $cols.map(function (j, col) {
                var $col = $(col),
                    text = $col.text();

                return text.replace(/"/g, '""'); // escape double quotes

            }).get().join(tmpColDelim);

        }).get().join(tmpRowDelim)
            .split(tmpRowDelim).join(rowDelim)
            .split(tmpColDelim).join(colDelim),

        // Data URI
        csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

        $(this)
            .attr({
            'download': filename,
                'href': csvData,
                'target': '_blank'
        });
    }

    // This must be a hyperlink
    $(".export").on('click', function (event) {
        // CSV
        exportTableToCSV.apply(this, [$('#dvData>table'), 'sample.csv']);
        
        // IF CSV, don't do event.preventDefault() or return false
        // We actually need this to be a typical hyperlink
    });
});

</script>

<?php include_once APP_PATH.'admin/template/footer.php';?>
