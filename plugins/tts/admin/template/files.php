<?php include_once APP_PATH.'admin/template/header.php';

    if (JAK_ASACCESS) $apedit = BASE_URL.'admin/index.php?p=tts&amp;sp=files';
?>

<ul class="nav nav-tabs">
    <li class="<?php echo (!empty($page2) && $page2 =='txt' ? 'active': '' ) ?>">
        <a href="index.php?p=tts&amp;sp=files&amp;ssp=txt"> Text Files </a>
    </li>
    <li class="<?php echo (!empty($page2) && $page2 =='wav' ? 'active': '' ) ?>">
        <a href="index.php?p=tts&amp;sp=files&amp;ssp=wav"> Wav Files </a>
    </li>
</ul>

<h3><?= $PAGE_CONTENT;  ?></h3>

<div class="row">
    <div class="col-xs-2">
        <button class="btn btn-default selectedFileButton" data-toggle="tooltip" data-btnaction="ConvertselectedFiles" title="Convert Selected Files"">
            <i class="fa fa-exchange"></i> Convert Selected Files
        </button>
    </div>
    <div class="col-sm-2">
        <button class="btn btn-default delete_selected_files" data-toggle="tooltip" title="Delete Selected Files"">
            <i class="fa fa-trash"></i> Delete Selected Files
        </button>
    </div>
    <div class="col-sm-2">
        <form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>"> 
            <input type="hidden" name="action" value="download_zip" />
            <button class="btn btn-default" type="submit" data-toggle="tooltip" title="Download all files in zip folder">
                <i class="fa fa-file-archive-o"></i> Download Zip
            </button>
        </form>
    </div>
</div>


<table class="table">
    <thead>
        <tr>
            <th><input type="checkbox" id="tts_selected_all" /></th>
            <th>File name</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $i=0; if (!empty($JAK_FILES)) foreach($JAK_FILES as $v) { ?>
            <tr>
                <td>
                    <input type="checkbox" name="tts_selected_file[]" class="highlight" value="<?= $v["name"]; ?>" />
                </td>
                <td>
                    <a target="_blank" href="<?=  $v["path"]; ?>">
                        <?=  $v["name"]; ?>
                    </a>
                </td>
                <td><?= $v['date']?></td>
                <td>
                    <?php if($page2 == 'txt'){ ?>
                    <button class="btn btn-default convertFileButton" data-toggle="tooltip" title="Convert" data-filename="<?= $v["name"]; ?>">
                        <i class="fa fa-exchange"></i>
                    </button>
                    <?php } ?>
                    <a class="btn btn-default" target="_blank" data-toggle="tooltip" title="View" type="button" href="<?=  $v["path"]; ?>">
                        <i class="fa fa-eye"></i>
                    </a>
                    <button class="btn btn-default deleteFileButton" data-toggle="tooltip" title="Delete" data-filename="<?= $v["name"]; ?>">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
        <?php $i++; }
            else
            {
                echo "<h3>Please check the path.</h3>";
            }
        ?>
    </tbody>
</table>


<script type="text/javascript" charset="utf-8">
$(document).ready(function(){

    $('[data-toggle="tooltip"]').tooltip();

    $("#tts_selected_all").click(function() {
            var checked_status = this.checked;
            $(".highlight").each(function()
            {
                this.checked = checked_status;
            });
    });
    $(".highlight").click(function() {}); 

    // Delete button
    $(".convertFileButton").click(function(){
        var data =  {
                        "action": "convert",
                        "filename": $(this).data('filename')
                    };
        if(confirm('Are you sure you want to convert file?'))
        {
            $.ajax({
                type: 'POST',
                datatype:'json',
                url: '/admin/index.php/?p=tts&sp=ajax&ssp=<?= $page2 ?>',
                data: data,
                success: function(msg) {
                    //console.log(data);
                   alert('File converted successfully');
                },
                error:function(msg){
                    alert('Error');
                }
            });
            location.reload();
        }
        return false;
    });

    // Selected button
    $(".selectedFileButton").click(function(){

        if(confirm('Are you sure you want to convert selected files?'))
        {
            var selected_text_files=[];
            $('[name="tts_selected_file[]"]').each(function () {
                if (this.checked)
                {
                    selected_text_files.push($(this).val());
                }
            });
            if (selected_text_files != 0)
            {
                var data =  {
                        "action": $('.selectedFileButton').data('btnaction'),
                        "selectedfilename": selected_text_files
                    };
                $.ajax({
                    type: 'POST',
                    datatype:'json',
                    url: '/admin/index.php/?p=tts&sp=ajax&ssp=<?= $page2 ?>',
                    data: data,
                    success: function(msg) {
                        //console.log(data);
                       alert('Files converted successfully');
                    },
                    error:function(msg){
                        alert('Error');
                    }
                });
                location.reload();
            }
        }
        return false;
    });

    // Delete button
    $(".deleteFileButton").click(function(){
        var data =  {
                        "action": "del",
                        "filename": $(this).data('filename')
                    };
        if(confirm('Are you sure you want to delete this row?'))
        {
            $.ajax({
                type: 'POST',
                datatype:'json',
                url: '/admin/index.php/?p=tts&sp=ajax&ssp=<?= $page2 ?>',
                data: data,
                success: function(msg) {
                    //console.log(data);
                   alert('File delete successfully');
                },
                error:function(msg){
                    alert('Error');
                }
            });
            location.reload();
        }
        return false;
    });


    // Delete selected files button
    $(".delete_selected_files").click(function(){

        if(confirm('Are you sure you want to delete selected files?'))
        {
            var del_selected_text_files=[];
            $('[name="tts_selected_file[]"]').each(function () {
                if (this.checked)
                    del_selected_text_files.push($(this).val());
            });

            if (del_selected_text_files != 0)
            {
                var data =  {
                        "action": "del",
                        "filename": del_selected_text_files
                    };
                $.ajax({
                    type: 'POST',
                    datatype:'json',
                    url: '/admin/index.php/?p=tts&sp=ajax&ssp=<?= $page2 ?>',
                    data: data,
                    success: function(msg) {
                        //console.log(data);
                       alert('Files deleted successfully');
                    },
                    error:function(msg){
                        alert('Error');
                    }
                });
                location.reload();
            }
        }
        return false;
    });

    // Delete button
    $(".downloadZipButton").click(function(){
        var data =  {
                        "folder_name": $(this).data('foldername')
                    };
        if(confirm('Are you sure you want to delete this row?'))
        {
            $.ajax({
                type: 'POST',
                datatype:'json',
                url: '/admin/index.php/?p=tts&sp=download',
                data: data,
                success: function(msg) {
                    //console.log(data);
                   alert('File Downloaded successfully');
                },
                error:function(msg){
                    alert('Error');
                }
            });
            //location.reload();
        }
        return false;
    });
});
</script>


<?php include_once APP_PATH.'admin/template/footer.php';?>