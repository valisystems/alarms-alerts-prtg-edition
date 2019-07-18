<?php

include_once APP_PATH.'plugins/faq/functions.php';

	$showfaqarray = explode(":", $row['showfaq']);
	
	if (is_array($showfaqarray) && in_array("ASC", $showfaqarray) || in_array("DESC", $showfaqarray)) {
	
		$JAK_FAQ = jak_get_faq('LIMIT '.$showfaqarray[1], 't1.id '.$showfaqarray[0], '', 't1.id', $jkv["faqurl"], $tl['general']['g56']);
		
	} else {

		$JAK_FAQ = jak_get_faq('', 't1.id ASC', $row['showfaq'], 't1.id', $jkv["faqurl"], $tl['general']['g56']);
	}

?>

<hr>
<h2><?php echo JAK_PLUGIN_NAME_FAQ;?></h2>

<div class="row">
	<div class="col-md-12 faq-wrapper">
		<div class="panel-group" id="accordion2">
			<?php if (isset($JAK_FAQ) && is_array($JAK_FAQ)) foreach($JAK_FAQ as $f) { ?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<a href="<?php echo $f["parseurl"];?>"><i class="fa fa-eye"></i></a> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse<?php echo $f["id"];?>">
						<?php echo $f["title"];?>
					</a>
				</div>
				<div id="collapse<?php echo $f["id"];?>" class="accordion-body collapse">
					<div class="accordion-inner">
						<div class="answer"><?php echo $tlf["faq"]["d3"];?></div>
						<p><?php echo $f["contentshort"];?></p>
						<div class="pull-right">
						<?php if (JAK_ASACCESS) { ?>
						<a href="<?php echo BASE_URL;?>admin/index.php?p=faq&amp;sp=edit&amp;id=<?php echo $f["id"];?>" title="<?php echo $tl["general"]["g"];?>" class="btn btn-default btn-xs jaktip"><i class="fa fa-pencil"></i></a>
						<a class="btn btn-default btn-xs jaktip quickedit" href="<?php echo BASE_URL;?>admin/index.php?p=faq&amp;sp=quickedit&amp;id=<?php echo $f["id"];?>" title="<?php echo $tl["general"]["g176"];?>"><i class="fa fa-edit"></i></a>
						
						<?php } ?>
						<a href="<?php echo $f["parseurl"];?>" class="btn btn-primary btn-xs"><?php echo $tl["general"]["g3"];?></a>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</div>