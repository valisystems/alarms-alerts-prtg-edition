<?php include_once APP_PATH.'admin/template/header.php';?>

<?php 
    if ($page1 == "s") 
    { 
        ?>
        <div class="alert alert-success fade in">
            <button type="button" class="close" data-dismiss="alert">×</button>
                <?php echo $tl["general"]["g7"];?>
        </div>
        <?php 
    } 
    if ($page1 == "e" || $page1 == "ene") 
    {
        ?>
        <div class="alert alert-danger fade in">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <h4><?php echo ($page1 == "e" ? $tl["errorpage"]["sql"] : $tl["errorpage"]["not"]);?></h4>
        </div>
        <?php 
    }
?>

<h3><?= $PAGE_CONTENT;  ?></h3>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
    <div class="box">
        <div class="box-body no-padding">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>
                                Time Start 
                                <a class="btn btn-warning btn-xs" href="index.php?p=cdr&amp;sort=timestart&amp;order=DESC">
                                <i class="fa fa-arrow-up"></i>
                                </a> 
                                <a class="btn btn-success btn-xs" href="index.php?p=cdr&amp;sort=timestart&amp;order=ASC"><i class="fa fa-arrow-down"></i></a></th>
                            <th>Direction</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Type</th>
							<th>Ring Duration</th>
                            <th>Duration <a class="btn btn-warning btn-xs" href="index.php?p=cdr&amp;sort=durationhhmmss&amp;order=DESC"><i class="fa fa-arrow-up"></i></a> <a class="btn btn-success btn-xs" href="index.php?p=cdr&amp;sort=durationhhmmss&amp;order=ASC"><i class="fa fa-arrow-down"></i></a>
                            </th>
                            <th>
                                <button type="submit" name="delete" id="button_delete" class="btn btn-danger btn-xs" onclick="if(!confirm('Are you sure?'))return false;"><i class="fa fa-trash-o"></i></button>
                            </th>
                        </tr>
                    </thead>
                    <?php if (isset($cdrListing) && is_array($cdrListing)) foreach($cdrListing as $v) { ?>
                    <tr>
                        <td><?php echo $v["id"];?></td>
                        <td><?= $v["timestart"] ?></td>
                        <td>
                            <?php
                                if($v["direction"] == "I")
                                {
                                    echo "<img src='/plugins/cdr/images/door_in.png' alt='Incoming' />";
                                }
                                elseif($v["direction"] == "O")
                                {
                                    echo "<img src='/plugins/cdr/images/door_out.png' alt='Outgoing' />";
                                }
                                else
                                {
                                    echo $v["direction"];
                                }
                            ?>
                        </td>
                        <td><?= formatSip($v["cid_from"]) ?></td>
                        <td><?= formatSip($v["cid_to"]) ?></td>
                        <td><?= $v["type"] ?></td>
                        <td>
							<?= (!empty($cdr["ringduration"]) ? gmdate('H:i:s', $cdr["ringduration"]) : '0'); ?>
						</td>
                        <td><?php echo $v["durationhhmmss"];?></td>
                        <td>
                            <a href="index.php?p=cdr&amp;sp=delete&amp;ssp=<?php echo $v["id"];?>" class="btn btn-default btn-xs" onclick="if(!confirm('<?php echo $tld["dload"]["al"];?>'))return false;"><i class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</form>

<?php

if ($JAK_PAGINATE) echo $JAK_PAGINATE;

function formatSip($sip)
{
    $output = '';
    $exp_lvl1 = explode('@', $sip);
    $output .= str_replace('<sip:', '', @$exp_lvl1[0]);
    return $output;
}
?>

<!-- JavaScript for select all -->
<script type="text/javascript">
    $(document).ready(function()
    {
                    
    });
</script>

<?php include_once APP_PATH.'admin/template/footer.php';?>
