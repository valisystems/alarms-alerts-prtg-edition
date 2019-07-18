<?php include_once APP_PATH.'admin/template/header.php';?>


<div class="box">
<div class="box-body no-padding">
<?php if (isset($JAK_STAT_DATA) && is_array($JAK_STAT_DATA)) foreach($JAK_STAT_DATA as $v) { ?>
<div style="float: left;border-bottom: 1px solid #e8e8e8;margin-bottom: 5px;">

<div style="float: left;background: #f4f4f4;border: 2px solid #cecdcd;border-radius: 5px;padding: 10px;text-align: center;margin: 5px;width: 155px;">

<h2 style="font-size: 15px;margin-bottom: 5px;"><?php echo $JAK_FORM_DATA["title"];?></h2>
<p><?php echo $tlnl["nletter"]["d33"].$v["total"];?></p>
<p><?php echo $tlnl["nletter"]["d34"].$v["notsent"];?></p>
<p><?php echo $tlnl["nletter"]["d4"].': '.$v["time"];?></p>

</div>

<div style="float: left;background: #f4f4f4;border: 2px solid #cecdcd;border-radius: 5px;padding: 10px;text-align: center;margin: 5px;width: 155px;">

<h2 style="font-size: 15px;margin-bottom: 5px;"><?php echo $tlnl["nletter"]["d35"];?></h2>
<p><?php echo $v["nlgroup"];?></p>

</div>

<div style="float: left;background: #f4f4f4;border: 2px solid #cecdcd;border-radius: 5px;padding: 10px;text-align: center;margin: 5px;width: 155px;">

<h2 style="font-size: 15px;margin-bottom: 5px;"><?php echo $tlnl["nletter"]["d36"];?></h2>
<p><?php echo $v["nluser"];?></p>

</div>

<div style="float: left;background: #f4f4f4;border: 2px solid #cecdcd;border-radius: 5px;padding: 10px;text-align: center;margin: 5px;width: 155px;">

<h2 style="font-size: 15px;margin-bottom: 5px;"><?php echo $tlnl["nletter"]["d37"];?></h2>
<p><?php echo $v["cmsgroup"];?></p>

</div>

<div style="float: left;background: #f4f4f4;border: 2px solid #cecdcd;border-radius: 5px;padding: 10px;text-align: center;margin: 5px;width: 155px;">

<h2 style="font-size: 15px;margin-bottom: 5px;"><?php echo $tlnl["nletter"]["d38"];?></h2>
<p><?php echo $v["cmsuser"];?></p>

</div>

</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>

<!-- JavaScript to disable send button and show loading.gif image -->
<script type="text/javascript">
	$(document).ready(function(){
	    // onclick
			$("#sendNl").click(function() {
				$("#loader").show();
				$('#sendNL').val("<?php echo $tlnl["nletter"]["d31"];?>");
				$('#sendNL').attr("disabled", true);
			});
	});
</script>
		
<?php include_once APP_PATH.'admin/template/footer.php';?>