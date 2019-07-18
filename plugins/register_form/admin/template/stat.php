<?php 

	$resrf = $jakdb->query('SELECT COUNT(*) as totalM FROM '.DB_PREFIX.'user');
	$rwresrf = $resrf->fetch_assoc();
	
	$resrf1 = $jakdb->query('SELECT COUNT(*) as totalMW FROM '.DB_PREFIX.'user WHERE time > DATE_SUB(CURDATE(), INTERVAL 1 WEEK)');
	$rwresrf1 = $resrf1->fetch_assoc();
	
	$resrf2 = $jakdb->query('SELECT COUNT(*) as totalMM FROM '.DB_PREFIX.'user WHERE time > DATE_SUB(CURDATE(), INTERVAL 4 WEEK)');
	$rwresrf2 = $resrf2->fetch_assoc();

?>

<div class="box">
  <div class="box-header">
  	<i class="fa fa-users"></i>
    <h3 class="box-title"><?php echo $lrf["register"]["s"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body no-padding">
<table class="table table-striped">
<tr>
	<td><?php echo $lrf["register"]["s1"];?></td>
	<td><?php echo $rwresrf['totalM'];?></td>
</tr>
<tr>
	<td><?php echo $lrf["register"]["s2"];?></td>
	<td><?php echo $rwresrf1['totalMW'];?></td>
</tr>
<tr>
	<td><?php echo $lrf["register"]["s3"];?></td>
	<td><?php echo $rwresrf2['totalMM'];?></td>
</tr>
</table>
</div>
</div>