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

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
</form>

<div class="box">
    <div class="box-body no-padding">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo $tlanalytic["analytic"]["a"];?>
                            <a class="btn btn-warning btn-xs" href="index.php?p=analytic&amp;sp=accts&amp;sort=account&amp;order=DESC">
                                <i class="fa fa-arrow-up"></i>
                            </a>
                            <a class="btn btn-success btn-xs" href="index.php?p=analytic&amp;sp=accts&amp;sort=account&amp;order=ASC">
                                <i class="fa fa-arrow-down"></i>
                            </a>
                        </th>
                        <th><?php echo $tlanalytic["analytic"]["ath"];?></th>
                        <th><?php echo $tlanalytic["analytic"]["ath2"];?></th>
                        <th>Reporting</th>
                        <th><i class="fa fa-edit fa-lg"></i></th>
                        <th><i class="fa fa-trash-o fa-lg"></i></th>
                    </tr>
                </thead>
                <?php if (isset($JAK_Account_All) && is_array($JAK_Account_All)) foreach($JAK_Account_All as $v) { ?>
                    <tr>
                        <td><?php echo $v["id"];?></td>
                        <td>
                            <a href="index.php?p=analytic&amp;sp=accts&amp;ssp=edit&amp;sssp=<?php echo $v["id"];?>">
                                <?php echo $v["account"];?></a>
                        </td>
                        <td><?php echo $v["name"];?></td>
                        <td><?php echo $v["type"];?></td>
                        <td>
                            <a href="index.php?p=analytic&amp;sp=accts&amp;ssp=rep&amp;sssp=<?php echo $v["id"];?>" class="btn btn-default btn-xs">
                                <i class="fa fa-flag"></i> Report
                            </a>
                        </td>
                        <td>
                            <a href="index.php?p=analytic&amp;sp=accts&amp;ssp=edit&amp;sssp=<?php echo $v["id"];?>" class="btn btn-default btn-sm">
                                <i class="fa fa-edit"></i>
                            </a>
                        </td>
                        <td>
                            <button class="btn btn-default btn-sm deleteFileButton" data-toggle="tooltip" title="Delete" data-acct="<?= $v["id"]; ?>">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>

<?php if ($JAK_PAGINATE) { echo $JAK_PAGINATE; } ?>

<!-- JavaScript for select all -->
<script type="text/javascript">
	$(document).ready(function()
    {

        // Delete button
        $(".deleteFileButton").click(function(){
            var data =  {
                            "action": "del",
                            "id": $(this).data('acct')
                        };
            if(confirm('Are you sure you want to delete this account?'))
            {
                $.ajax({
                    type: 'POST',
                    datatype:'json',
                    url: '/admin/index.php/?p=analytic&sp=ajax',
                    data: data,
                    success: function(msg) {
                        //console.log(data);
                       alert('Account deleted successfully.');
                    },
                    error:function(msg){
                        alert('Error');
                    }
                });
                location.reload();
            }
            return false;
        });

	});
</script>

<?php include_once APP_PATH.'admin/template/footer.php';?>