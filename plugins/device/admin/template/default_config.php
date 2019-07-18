<?php include_once APP_PATH.'admin/template/header.php';?>

<?php if ($page2 == "s") { ?>
    <div class="alert alert-success fade in">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <?php echo $tl["general"]["g7"];?>
    </div>
<?php } if ($page2 == "e" || $page2 == "ene") { ?>
    <div class="alert alert-danger fade in">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <?php echo ($page1 == "e" ? $tl["errorpage"]["sql"] : $tl["errorpage"]["not"]);?>
    </div>
<?php } ?>

    <div class="box">
        <div class="box-body no-padding">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Device Type</th>
                            <th>Config file type</th>
                            <th><i class="fa fa-edit"></i></th>
                            <th><button type="submit" name="delete" id="button_delete" class="btn btn-danger btn-xs" onclick="if(!confirm('<?php echo $tldev["device"]["al"];?>'))return false;">
                                <i class="fa fa-trash-o"></i></button>
                            </th>
                        </tr>
                    </thead>
                    <?php if (!empty($configs) ) foreach($configs as $v) { ?>
                        <tr>
                            <td><?php echo $v["id"];?></td>
                            <td>
                                <a href="index.php?p=device&amp;sp=default_config&amp;ssp=edit&amp;sssp=<?php echo $v["id"];?>">
                                    <?php echo $v["device_type"];?>
                                </a>
                            </td>
                            <td><?php echo $v["config_file_type"]; ?></td>

                            <td>
                                <?php if (JAK_ASACCESS) { ?>
                                <a href="index.php?p=device&amp;sp=default_config&amp;ssp=edit&amp;sssp=<?php echo $v["id"];?>" class="btn btn-default btn-xs">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if (JAK_ASACCESS) { ?>
                                <a href="index.php?p=device&amp;sp=default_config&amp;ssp=del&amp;sssp==<?php echo $v["id"];?>" class="btn btn-default btn-xs" onclick="if(!confirm('<?php echo 'Are you sure you want to delete?';?>'))return false;">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>


<!-- JavaScript for select all -->
<script type="text/javascript">
    $(document).ready(function()
    {
        

    });
</script>

<?php include_once APP_PATH.'admin/template/footer.php';?>
