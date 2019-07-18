<?php include_once APP_PATH.'admin/template/header.php';?>

<?php
	if (JAK_ASACCESS) $apedit = BASE_URL.'admin/index.php?p=cdr';
?>


<div class="row">
    <div class="col-md-7">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Converter all Text files to WAV Files</h3>
            </div><!-- /.box-header -->

            <form method="POST" action="<?= BASE_URL.'index.php?p=cdr&amp;sp=zip'; ?>" >

                <div class="box-body">
                    <table>
                        <thead>
                            <tr>
                                <th><label>Select text file folder</label></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select name="folder_name" class="form-control">
                                        <option value="text_files">Text file folder</option>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="box-footer">
                    <button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
                </div>

            </form>
        </div>
    </div>
</div>



<?php include_once APP_PATH.'admin/template/footer.php';?>
