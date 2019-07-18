<?php include_once APP_PATH.'plugins/ticketing/functions.php';

define('JAK_TICKETMODERATE', $jakusergroup->getVar("ticketmoderate"));

	$showstarray = explode(":", $row['showticketing']);
	
	if (is_array($showstarray) && in_array("ASC", $showstarray) || in_array("DESC", $showstarray)) {
	
		$JAK_TICKETING = jak_get_ticket('LIMIT '.$showstarray[1], 't1.id '.$showstarray[0], '', 't1.id', $jkv["ticketurl"], $tl['general']['g56']);
		
	} else {

		$JAK_TICKETING = jak_get_ticket('', 't1.id ASC', $row['showticketing'], 't1.id', $jkv["ticketurl"], $tl['general']['g56']);
		
	}

?>

<h2><?php echo $tlt["st"]["t43"].JAK_PLUGIN_NAME_TICKETING;?></h2>
<div class="row">
	<?php if (isset($JAK_TICKETING) && is_array($JAK_TICKETING)) foreach($JAK_TICKETING as $st) { ?>
	<div class="col-md-4 col-sm-6">
		<div class="service-wrapper">
			<i class="fa <?php echo $st["img"];?> fa-5x"></i>
			<h3><a title="<?php echo $tlt["st"]["t10"].$st["id"].' '.$tlt["st"]["t4"]; if ($st["status"] == 0) { echo $tlt["st"]["t7"]; } else { echo $tlt["st"]["t8"]; } ?>" href="<?php echo $st["parseurl"];?>"><?php echo $st["title"];?></a></h3>
			<p><?php echo $st["contentshort"];?></p>
				<i class="fa fa-info-circle"></i> <?php echo $tlt["st"]["t10"].$st["id"].' '.$tlt["st"]["t4"]; if ($st["status"] == 0) { echo '<span class="label label-warning">'.$tlt["st"]["t7"].'</span>'; } else { echo '<span class="label label-success">'.$tlt["st"]["t8"].'</span>'; } ?><br>
				<i class="fa fa-clock-o"></i> <?php echo $st["created"];?><p>
				<hr><a href="<?php echo $st["parseurl"];?>" class="btn btn-primary"><?php echo $tl["general"]["g3"];?></a><?php if (JAK_ASACCESS) { ?> <a href="<?php echo BASE_URL;?>admin/index.php?p=ticketing&amp;sp=edit&amp;id=<?php echo $st["id"];?>" title="<?php echo $tl["general"]["g"];?>" class="btn btn-default jaktip"><i class="fa fa-pencil"></i></a> <a class="btn btn-default jaktip quickedit" href="<?php echo BASE_URL;?>admin/index.php?p=ticketing&amp;sp=quickedit&amp;id=<?php echo $st["id"];?>" title="<?php echo $tl["general"]["g176"];?>"><i class="fa fa-edit"></i></a><?php } ?>
				</p>
		</div>
	</div>
	<?php } ?>
</div>