<?php include_once APP_PATH.'admin/template/header.php';?>

<link rel="stylesheet" type="text/css" href="../plugins/device/css/bootstrap-switch.css" />
<script type="text/javascript" src="../plugins/device/js/bootstrap-switch.js"></script>
<script type="text/javascript" src="../plugins/device/js/admin.device.js"></script>

<?php if ($page1 == "s") { ?>
    <div class="alert alert-success fade in">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <?php echo $tl["general"]["g7"];?>
    </div>
<?php } if ($page1 == "e" || $page1 == "ene") { ?>
    <div class="alert alert-danger fade in">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <?php echo ($page1 == "e" ? $tl["errorpage"]["sql"] : $tl["errorpage"]["not"]);?>
    </div>
<?php } ?>



<div class="row">
    <div class="col-xs-2">
        <button class="btn btn-default selecteddevicesButton" data-toggle="tooltip" data-btnaction="selecteddevicesButton" title="Apply default config.">
            <i class="fa fa-exchange"></i> Create Default Config Files
        </button>
    </div>
    <div class="col-sm-2">
        <button class="btn btn-default" name="cancel-all" id="cancel-all" >
            <i class="fa fa-times"></i> Cancel All Alarms
        </button>
    </div>
    <div class="col-sm-2">
        <button id="prtg_status_url" onclick="copyToClipboard('#prtg_status_url')" 
        data-text = "http://<?= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT']?>/index.php?p=device&amp;sp=prtg&amp;action=all"
        type="button" class="btn btn-default">PRTG Device Status Copy
        </button>
    </div>
	<div class="col-sm-3">
        <input type="checkbox" name="reloadCB" id="reloadCB"> Auto Refresh (15s)
    </div>
</div>
<br/>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
    <div class="box">
        <div class="box-body no-padding">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><input type="checkbox" id="device_selected_all" /></th>
                            <th><?php echo $tldev["device"]["th"];?>
                                <a class="btn btn-warning btn-xs" href="index.php?p=device&amp;sp=sort&amp;ssp=base_name&amp;sssp=DESC">
                                    <i class="fa fa-arrow-up"></i>
                                </a>
                                <a class="btn btn-success btn-xs" href="index.php?p=device&amp;sp=sort&amp;ssp=base_name&amp;sssp=ASC">
                                    <i class="fa fa-arrow-down"></i>
                                </a>
                            </th>
                            <th><?php echo $tldev["device"]["th1"];?></th>
                            <th><?php echo $tldev["device"]["th2"];?></th>
                            <th><?php echo $tldev["device"]["th3"];?></th>
                            <th><?php echo $tldev["device"]["th4"];?></th>
							<th>Status text</th>
                            <th><i class="fa fa-cog"></i></th>
                            <th><i class="fa fa-edit"></i></th>
                            <th><button type="submit" name="delete" id="button_delete" class="btn btn-danger btn-xs" onclick="if(!confirm('<?php echo $tldev["device"]["al"];?>'))return false;">
                                <i class="fa fa-trash-o"></i></button>
                            </th>
                        </tr>
                    </thead>
                    <?php if (isset($JAK_DEVICE_ALL) && is_array($JAK_DEVICE_ALL)) foreach($JAK_DEVICE_ALL as $v) { ?>
                        <tr>
                            <td><?php echo $v["id"];?></td>
                            <td>
                                <input type="checkbox" name="selected_device_for_config[]" class="highlight" value="<?= $v["id"]; ?>" />
                            </td>
                            <td>
                                <a href="index.php?p=device&amp;sp=edit&amp;ssp=<?php echo $v["id"];?>">
                                    <?php echo $v["base_name"];?>
                                </a>
                            </td>
                            <td><?php echo $v["device_id"]; ?></td>
                            <td><?php echo $v["device_type"];?></td>
                            <td id="<?= $v["base_name"] ?>-<?= $v["device_id"] ?>"><?php echo $v["event_type"];?></td>
                            <td>
                                <input type="checkbox" name="alarm" data-basename='<?= $v["base_name"] ?>' data-device='<?= $v["device_id"] ?>' <?= ($v["event_type"] == 'Alarm')? 'checked' : ''; ?> class="cancel-single" />
                            </td>
							<td>
								<?php 
								$prtg_status_text = [ 
									'base_name' => $v["base_name"],
									'device_id' => $v["device_id"],
									'status' => $v["event_type"]
								];
								?>
								<input   type="hidden"  value='<?= json_encode($prtg_status_text); ?>' />
								<button class="prtg_url" type="button" class="btn btn-default btn-sm">Copy text</button>
							</td>
                            <td>
                                <button class="configButton btn btn-default btn-sm" type="button" data-id='<?=$v["id"]?>' data-deviceid='<?=$v["device_id"]?>' data-basename='<?=$v["base_name"]?>' data-devicetype='<?=$v["device_type"]?>' >
                                        <span class="fa fa-cog"></span>
                                </button>
                            </td>
                            <td>
                                <?php if (JAK_ASACCESS) { ?>
                                <a href="index.php?p=device&amp;sp=edit&amp;ssp=<?php echo $v["id"];?>" class="btn btn-default btn-xs">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if (JAK_ASACCESS) { ?>
                                <a href="index.php?p=device&amp;sp=delete&amp;ssp=<?php echo $v["id"];?>" class="btn btn-default btn-xs" onclick="if(!confirm('<?php echo $tldev["device"]["al"];?>'))return false;">
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
</form>

<div class="icon_legend">
    <h3><?php echo $tl["icons"]["i"];?></h3>
    <i title="<?php echo $tl["icons"]["i4"];?>" class="fa fa-sort"></i>
    <i title="<?php echo $tl["icons"]["i6"];?>" class="fa fa-check"></i>
    <i title="<?php echo $tl["icons"]["i5"];?>" class="fa fa-lock"></i>
    <i title="<?php echo $tl["icons"]["i2"];?>" class="fa fa-edit"></i>
    <i title="<?php echo $tl["icons"]["i1"];?>" class="fa fa-trash-o"></i>
</div>

<?php if ($JAK_PAGINATE) { echo $JAK_PAGINATE; } ?>

<!-- JavaScript for select all -->
<script type="text/javascript">
	$(document).ready(function()
    {
        $("#device_selected_all").click(function() {
                var checked_status = this.checked;
                $(".highlight").each(function()
                {
                    this.checked = checked_status;
                });
        });
        $(".highlight").click(function() {}); 

            // Cancel all alarms button
            $('#cancel-all').click(function(){

                if(confirm('Are you sure you want to cancel all alarm ?'))
                {
                    $.ajax({
                        type: 'POST',
                        datatype:'json',
                        url: '/admin/index.php?p=device&sp=ajax',
                        data: {
                            'action':'cancelAll',
                            'event_type':'Normal'
                        },
                        success: function(msg) {
                            //console.log(data);
                            alert('All alarms been cancelled.');
                        },
                        error:function(msg){
                            alert('Error');
                        }
                    });
                    location.reload();
                }
                return false;
            });


            // Single device
            $('.cancel-single').bootstrapSwitch({
                size:"small",
                onSwitchChange: function(e, state) {
                    e.preventDefault();
                    var basename = $(this).data('basename');
                    var device_id = $(this).data('device');
                    var alarm ;
                    if (state){
                        alarm = 'Alarm';
                    }
                    else{
                        alarm = 'Normal';
                    }

                    $.ajax({
                        type: 'POST',
                        datatype:'json',
                        url: '/admin/index.php?p=device&sp=ajax',
                        data: {
                            'action':'singleAlarm',
                            'device_id':device_id,
                            'basename': basename,
                            'event_type':alarm
                        },
                        success: function(data) {
                            alert('Device event state: ' + alarm );
                            $('#'+basename+'-'+device_id).html(alarm); 
                        },
                        error:function(msg){
                            alert('ERROR');
                        }
                    });   
                }
            });
			
            // Selected button
            $(".selecteddevicesButton").click(function(){

                if(confirm('Are you sure you want to create config files?'))
                {
                    var selected_devices=[];
                    $('[name="selected_device_for_config[]"]').each(function () {
                        if (this.checked)
                        {
                            selected_devices.push($(this).val());
                        }
                    });
                    if (selected_devices != 0)
                    {
                        var data =  {
                                "action": $('.selecteddevicesButton').data('btnaction'),
                                "selecteddevices": selected_devices
                            };
                        $.ajax({
                            type: 'POST',
                            datatype:'json',
                            url: '/admin/index.php/?p=device&sp=ajax&ssp=configdevices',
                            data: data,
                            success: function(msg) {
                                //console.log(data);
                               alert('Default file created.');
                            },
                            error:function(msg){
                                alert('Error');
                            }
                        });
                        //location.reload();
                    }
                }
                return false;
            });

			// copy link
			$(".prtg_url").click(function(){
				var input_value = $(this).parent('td').find('input').val();
				var $temp = $("<input>");
				$("body").append($temp);
				$temp.val(input_value).select();
				document.execCommand("copy");
				$temp.remove();
			});
			
			if (window.location.hash=="#autoreload") {
                reloading=setTimeout("window.location.reload();", 15000);
                document.getElementById("reloadCB").checked=true;
            }
            var reloadBth = $('#reloadCB').bootstrapSwitch({
                onSwitchChange: function(e, state) {
                    
                    if (state) {
                        window.location.replace("#autoreload");
                        reloading=setTimeout("window.location.reload();", 15000);
                    } else {
                        window.location.replace("");
                        clearTimeout(reloading);
                    }
                }
            });

	});
	
	var reloading;

function copyToClipboard(element) {
    var $temp = $("<input>");
    $("body").append($temp);
    var copytext = $(element).data('text');
    $temp.val(copytext).select();
    document.execCommand("copy");
    $temp.remove();
}
</script>

<?php include_once APP_PATH.'admin/template/footer.php';?>
