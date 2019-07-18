<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/header.php';?>

<?php if (JAK_ASACCESS) $apedit = BASE_URL.'/index.php?p=device';?>


<?php 	if ($PAGE_PASSWORD && !JAK_ASACCESS && $PAGE_PASSWORD != $_SESSION['pagesecurehashpasswordProtected'])
		{
			if ($errorpp){ 
				?>
		        	
			<!-- Show password error -->
		    <div class="alert alert-danger fade in">
		      <button type="button" class="close" data-dismiss="alert">×</button>
		      	<h4><?php echo $errorpp["e"];?></h4>
		    </div>
			<?php } ?>
	
			<!-- Show password form -->
			<form class="form-inline" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
			<div class="input-group">
			      <input type="password" name="pagepass" class="form-control" value="" placeholder="<?php echo $tl["general"]["g29"]; ?>" />
			      <span class="input-group-btn">
			        <button class="btn btn-default" name="protected" type="submit"><?php echo $tl["general"]["g83"];?></button>
			      </span>
			    </div>
			<input type="hidden" name="action" value="passwordProtected" />
			
			</form>

<?php 	}
		else
		{
		?>
			
			<?php if ($PAGE_CONTENT) echo $PAGE_CONTENT;?>
			<link type="text/css" rel="stylesheet" href="<?= BASE_URL ?>plugins/device/css/jquery.dataTables.min.css" />
			

			<script type="text/javascript" src="<?= BASE_URL ?>plugins/device/js/device.js"></script>
			<script type="text/javascript" src="<?= BASE_URL ?>plugins/device/js/jquery.dataTables.min.js"></script>

			<link rel="stylesheet" type="text/css" href="../plugins/device/css/bootstrap-switch.css" />
			<script type="text/javascript" src="../plugins/device/js/bootstrap-switch.js"></script>
			
			<?php if (JAK_ASACCESS || $VISITOR_PERMISSIONS['create'] ) { ?>
			<button type="button" class="createButton btn btn-primary">
				Add Device <span class="fa fa-plus"></span>
			</button>
			<?php } ?>

			<button type="button" class="btn disabled btn-<?php echo !empty($jkv["devicediscover"]) ? 'danger' : 'success' ?>">
			    <?php echo !empty($jkv["devicediscover"]) ? 'Discovery Mode ON' : 'Discovery Mode OFF' ?>
			</button>
			
			<a class="btn btn-default" target="_blank" href="http://<?= $_SERVER['SERVER_NAME'] . ':' .$_SERVER['SERVER_PORT'] . '/index.php?p=device&sp=prtg&action=all'?>">
				PRTG Status link
			</a>
			<button id="prtg_status_url" onclick="copyToClipboard('#prtg_status_url')" 
	        data-text = "http://<?= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT']?>/index.php?p=device&amp;sp=prtg&amp;action=all"
	        type="button" class="btn btn-default">PRTG Device Status Copy
	        </button>
			
			<input type="checkbox" name="reloadCB" id="reloadCB"> Auto Refresh (15s)
			<br/><br/>

			<?php if (isset($JAK_DEVICE_ALL) && is_array($JAK_DEVICE_ALL)) { ?>

					<table id="deviceDataTable" >
						<thead>
						<tr>
							<th>Device ID</th>
							<th>Base Name</th>
							<th>Device Type</th>
							<th>Event Type</th>
							<th>Low Battery</th>
							<th>Last Prompted</th>
							<th>Alarm</th>
							<th>Status text</th>
							<th>Action</th>
						</tr>
						</thead>
						<tbody>
						<?php if (isset($JAK_DEVICE_ALL) && is_array($JAK_DEVICE_ALL)) foreach($JAK_DEVICE_ALL as $v) { ?>
							<tr>
								<td><?= $v["device_id"];?><?php if ($v["password"]) { ?><i class="fa fa-key"></i><?php } ?></td>
								<td><?= $v["base_name"];?></td>
								<td><?= $v["device_type"];?></td>
								<td id="<?= $v["base_name"] ?>-<?= $v["device_id"] ?>"><?= $v["event_type"];?></td>
								<td><?= $v["low_battery"]; ?></td>
								<td><?= $v["last_prompted"];?></td>
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
									<input type="text" readonly="readonly" onFocus="this.select();this.focus()" value='<?= json_encode($prtg_status_text); ?>' />
									
			                    </td>

								<td>
									<?php if (JAK_ASACCESS || $VISITOR_PERMISSIONS['edit']) { ?>
										<button class="editButton btn btn-default btn-sm" type="button" data-id='<?=$v["id"]?>' data-deviceid='<?=$v["device_id"]?>' data-basename='<?=$v["base_name"]?>' >
												<span class="fa fa-pencil"></span>
										</button>
									<?php }
										if (JAK_ASACCESS || $VISITOR_PERMISSIONS['delete']) {
									 ?>
										<button class="deleteButton btn btn-default btn-sm" type="button" data-id='<?=$v["id"]?>' data-deviceid='<?=$v["device_id"]?>' data-basename='<?=$v["base_name"]?>' >
												<span class="fa fa-trash"></span>
										</button>
									<?php } ?>
								</td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
			<?php }
		}
		?>


<?php //if ($JAK_PAGINATE) echo $JAK_PAGINATE; ?>

<script type="text/javascript">
	$(document).ready(function(){
		if ($('#deviceDataTable').length)
		{
			$('#deviceDataTable').DataTable({
				"aLengthMenu": [[24, 50, 75, -1], [24, 50, 75, "All"]],
				"aaSorting": [[7,'asc']],
				"iDisplayLength": <?= $jkv["devicepageitem"]?>
			});	
		}
    	$('[data-toggle="popover"]').popover()
    	$(".prtg_url").click(function(){
    	    var input_value = $(this).parent('td').find('input').val();
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(input_value).select();
            document.execCommand("copy");
            $temp.remove();
    	});
	
	});

	function copyToClipboard(element) {
	    var $temp = $("<input>");
	    $("body").append($temp);
	    var copytext = $(element).data('text');
	    $temp.val(copytext).select();
	    document.execCommand("copy");
	    $temp.remove();
	}
</script>



<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/footer.php';?>
