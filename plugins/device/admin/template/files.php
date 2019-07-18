<?php include_once APP_PATH.'admin/template/header.php';?>


<?php
	if (JAK_ASACCESS) $apedit = BASE_URL.'admin/index.php?p=device&amp;sp=cfiles';
?>

<a class="btn btn-info " type="button" href="index.php?p=device&amp;sp=files&amp;ssp=sfcatch">
    Single Catch Files
</a>

<a class="btn btn-info" type="button" href="index.php?p=device&amp;sp=files&amp;ssp=mfcatch">
    Multifolder Catch
</a>


<h3><?= $PAGE_CONTENT;  ?></h3>

<table class="table">
    <thead>
        <tr>
            <td>File name</td>
            <td>Date</td>
            <td>Type</td>
            <td>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($JAK_CATCH_FILES)) foreach($JAK_CATCH_FILES as $v) { ?>
            <tr>
                <td>
                    <a target="_blank" href="<?=  $v["path"]; ?>">
                        <?=  $v["name"]; ?>
                    </a>
                </td>
                <td><?= $v['date']?></td>
                <td><?= $v['type']?></td>
                <td>
                    <a class="btn btn-default" type="button" href="<?=  $v["path"]; ?>">
                        <i class="fa fa-eye"></i>
                    </a>
                    <button class="btn btn-default deleteFileButton" data-filepath="<?= $v["path"]; ?>">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
        <?php }
            else
            {
                echo "<h3>Please check the path.</h3>";
            }
        ?>
    </tbody>
</table>


<script type="text/javascript" charset="utf-8">
    // Delete button
    $(".deleteFileButton").click(function(){
        var data =  {
                        "action": "del",
                        "filepath": $(this).data('filepath')
                    };
        if(confirm('Are you sure you want to delete this row?'))
        {
            $.ajax({
                type: 'POST',
                datatype:'json',
                url: '/admin/index.php/?p=device&sp=<?= $page1 ?>',
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
</script>


<?php include_once APP_PATH.'admin/template/footer.php';?>