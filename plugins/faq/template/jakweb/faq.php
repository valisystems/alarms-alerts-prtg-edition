<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/header.php';?>

<?php if (JAK_ASACCESS) $apedit = BASE_URL.'admin/index.php?p=faq&amp;sp=setting';?>
		
<div class="row">
	<div class="col-md-12 faq-wrapper">
		<div class="panel-group" id="accordion2">
			<?php if ($PAGE_CONTENT) echo $PAGE_CONTENT;?>
			<?php if (isset($JAK_FAQ_ALL) && is_array($JAK_FAQ_ALL)) foreach($JAK_FAQ_ALL as $v) { ?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse<?php echo $v["id"];?>"><i class="fa fa-eye"></i></a>
						<a href="<?php echo $v["parseurl"];?>"><?php echo $v["title"];?></a>
				</div>
				<div id="collapse<?php echo $v["id"];?>" class="accordion-body collapse">
					<div class="accordion-inner">
						<div class="answer"><?php echo $tlf["faq"]["d3"];?></div>
						<p><?php echo $v["contentshort"];?></p>
						<div class="pull-right">
						<?php if (JAK_ASACCESS) { ?>
						<a href="<?php echo BASE_URL;?>admin/index.php?p=faq&amp;sp=edit&amp;id=<?php echo $v["id"];?>" title="<?php echo $tl["general"]["g"];?>" class="btn btn-default btn-xs jaktip"><i class="fa fa-pencil"></i></a>
						<a class="btn btn-default btn-xs jaktip quickedit" href="<?php echo BASE_URL;?>admin/index.php?p=faq&amp;sp=quickedit&amp;id=<?php echo $v["id"];?>" title="<?php echo $tl["general"]["g176"];?>"><i class="fa fa-edit"></i></a>
						
						<?php } ?>
						<a href="<?php echo $v["parseurl"];?>" class="btn btn-primary btn-xs"><?php echo $tl["general"]["g3"];?></a>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</div>

<?php if ($JAK_PAGINATE) echo $JAK_PAGINATE;?>
		
<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/footer.php';?>