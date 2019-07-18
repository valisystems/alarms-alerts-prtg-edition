<!DOCTYPE html>
<html>
<head>
	<title> Device Status </title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>  
	<script src="js/device_status.js"></script>
 </head>
<body>
<div class="container">
<button type="button" data-toggle="modal" data-target="#create-device">
	<span class="glyphicon glyphicon-plus"></span>
</button>

<?php 
	include('classes/device.php');
	$deviceObj = new Device();
		//$deviceObj->deleteByDeviceId('AB001800');
		if($deviceObj->getList())
		{
			?>
			<table class="table">
					<thead>
						<tr>
							<th>BaseName</th>
							<th>DeviceID</th>
							<th>DeviceType</th>
							<th>EventType</th>
							<th>AntennaInt</th>
							<th>PendantRxLevel</th>
							<th>LowBattery</th>
							<th>TimeStamp</th>
							<th>Action</th>
						</tr>
					<thead>
					<tbody>
					<?php
					foreach($deviceObj->getList() as $device)
					{
						?>
							<tr>
								<td><?= $device["BaseName"]?></td>
								<td><?= $device["DeviceID"]?></td>
								<td><?= $device["DeviceType"]?></td>
								<td><?= $device["EventType"]?></td>
								<td><?= $device["AntennaInt"]?></td>
								<td><?= $device["PendantRxLevel"]?></td>
								<td><?= $device["LowBattery"]?></td>
								<td><?= $device["TimeStamp"]?></td>
								<td>
									<button class="editButton" type="button" id='<?=$device["DeviceID"]?>' >
											<span class="glyphicon glyphicon-pencil"></span>
									</button>
									<button class="deleteButton" type="button" id='<?=$device["DeviceID"]?>' >
											<span class="glyphicon glyphicon-trash"></span>
									</button>
								</td>
							</tr>
						<?php
					}
					?>
				</tbody>
			</table>
			<?php
		}
		else
		{
			echo 'No device Found';
		}
		?>


<!-- Create form -->

<div class="modal fade" id="create-device" role="dialog" aria-labeledby="CreateDevice">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4>Create device</h4>
			</div>
			<div class="modal-body">
				<?php echo $deviceObj->createForm(); ?>
			
			</div>
		</div>
	</div>
</div>
<!-- end of create modal --> 


<!-- Edit Modal-->
    
</div>
</body>
</html> 