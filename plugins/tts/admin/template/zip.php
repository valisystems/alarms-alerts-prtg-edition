<?php include_once APP_PATH.'admin/template/header.php';?>

<?php
	if (JAK_ASACCESS) $apedit = BASE_URL.'admin/index.php?p=tts';
?>


<div class="row">
    <div class="col-md-7">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Download Files in zip</h3>
            </div><!-- /.box-header -->

            <form method="POST" action="<?= BASE_URL.'index.php?p=tts&amp;sp=zip'; ?>" >

                <div class="box-body">
                    <table>
                        <thead>
                            <tr>
                                <th><label>Select folder</label></th>
                                <th>&nbsp;Download</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select name="folder_name" class="form-control">
                                        <option value="text_files">Text file folder</option>
                                        <option value="wav_files">Wav file folder</option>
                                    </select>
                                </td>
                                <td style="text-align:center;">
                                    <button type="submit" name="save" data-toggle="tooltip" title="Download" class="btn btn-primary ">
                                        <i class="fa fa-download"></i>  
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="box-footer">
                    
                </div>

            </form>
        </div>
    </div>
</div>
<script type="text/javascript" charset="utf-8">
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>


<?php include_once APP_PATH.'admin/template/footer.php';?>
