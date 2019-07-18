<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/header.php';?>


<div class="row">
<div class="col-md-12">
	<?php if ($PAGE_CONTENT) echo $PAGE_CONTENT;?>
	
	<?php if (JAK_TICKETPOST) { ?>
	<a class="btn btn-color" href="<?php echo $P_TICKET_N;?>"><i class="fa fa-ticket"></i> <?php echo $tlt["st"]["t36"];?></a>
	<?php } ?>
</div>
</div>
	
<div class="row">
	<?php if (isset($JAK_TICKET_ALL) && is_array($JAK_TICKET_ALL)) foreach($JAK_TICKET_ALL as $v) { ?>
	<div class="col-md-4 col-sm-6">
		<div class="service-wrapper">
			<i class="fa <?php echo $v["img"];?> fa-5x"></i>
			<h3><a title="<?php echo $tlt["st"]["t10"].$v["id"].' '.$tlt["st"]["t4"]; if ($v["status"] == 0) { echo $tlt["st"]["t7"]; } else { echo $tlt["st"]["t8"]; } ?>" href="<?php echo $v["parseurl"];?>"><?php echo $v["title"];?></a></h3>
			<p><?php echo $v["contentshort"];?></p>
				<i class="fa fa-info-circle"></i> <?php echo $tlt["st"]["t10"].$v["id"].' '.$tlt["st"]["t4"]; if ($v["status"] == 0) { echo '<span class="label label-warning">'.$tlt["st"]["t7"].'</span>'; } else { echo '<span class="label label-success">'.$tlt["st"]["t8"].'</span>'; } ?><br>
				<i class="fa fa-clock-o"></i> <?php echo $v["created"];?><p>
				<hr><a href="<?php echo $v["parseurl"];?>" class="btn btn-color btn-sm"><?php echo $tl["general"]["g3"];?></a><?php if (JAK_ASACCESS) { ?> <a href="<?php echo BASE_URL;?>admin/index.php?p=ticketing&amp;sp=edit&amp;id=<?php echo $v["id"];?>" title="<?php echo $tl["general"]["g"];?>" class="btn btn-default btn-sm jaktip"><i class="fa fa-pencil"></i></a> <a class="btn btn-default btn-sm jaktip quickedit" href="<?php echo BASE_URL;?>admin/index.php?p=ticketing&amp;sp=quickedit&amp;id=<?php echo $v["id"];?>" title="<?php echo $tl["general"]["g176"];?>"><i class="fa fa-edit"></i></a><?php } ?>
				</p>
		</div>
	</div>
	<?php } ?>
</div>
		
<?php if (isset($JAK_ST_OPT)) { ?>

<h4><?php echo $tlt["st"]["d1"];?></h4>

<ul class="nav nav-pills">
<?php } if (isset($JAK_ST_OPT) && is_array($JAK_ST_OPT)) foreach($JAK_ST_OPT as $sto) { ?>
	<li><a href="<?php echo $sto["parseurl"];?>" title="<?php echo $sto["name"];?>" class="jaktip"><i class="fa <?php echo $sto["img"];?> fa-2x"></i></a></li>
<?php } ?>
</ul>

<?php if ($JAK_PAGINATE) echo $JAK_PAGINATE;?>
		
<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/footer.php';?>