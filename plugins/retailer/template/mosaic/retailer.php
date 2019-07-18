<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/header.php';?>

	<?php if (JAK_ASACCESS) $apedit = BASE_URL.'admin/index.php?p=retailer&amp;sp=setting';?>
		
	<?php if ($jkv["retailershowmap"]) { ?>
	<div class="row">
	<div class="col-md-8">
		<h3><?php echo $tlre['retailer']['g9'];?></h3>
		<div class="well well-sm"><div id="map_canvas"></div></div>
	</div>
	<div class="col-md-4">
		<h3><?php echo $tlre['retailer']['d2'];?></h3>
		<div class="list-group retailers" id="retailer_list"></div>
	</div>
	</div>
	<?php } ?>
	
	<hr>
	
	<div class="row">
	<?php if (isset($JAK_RETAILER_ALL) && is_array($JAK_RETAILER_ALL)) foreach($JAK_RETAILER_ALL as $v) { ?>
		<div class="col-md-4 col-sm-6">
			<div class="zoom-item">
				<div class="zoom-image">
					<a href="<?php echo $v["parseurl"];?>"><img src="<?php echo $v["previmg"];?>" alt="retailer-preview" /></a>
				</div>
				<div class="zoom-info-fade">
					<ul>
						<li class="zoom-project-name"><a href="<?php echo $v["parseurl"];?>"><?php echo $v["title"];?></a></li>
						<li><?php echo $v["contentshort"];?></li>
						<li class="read-more">
							<a href="<?php echo $v["parseurl"];?>" class="btn btn-color btn-sm"><?php echo $tl["general"]["g3"];?></a>
							<?php if (JAK_ASACCESS) { ?>
							<a class="btn btn-default btn-sm jaktip" href="<?php echo BASE_URL;?>admin/index.php?p=retailer&amp;sp=edit&amp;id=<?php echo $v["id"];?>" title="<?php echo $tl["general"]["g"];?>"><i class="fa fa-pencil"></i></a>
							<a class="btn btn-default btn-sm jaktip quickedit" href="<?php echo BASE_URL;?>admin/index.php?p=retailer&amp;sp=quickedit&amp;id=<?php echo $v["id"];?>" title="<?php echo $tl["general"]["g176"];?>"><i class="fa fa-edit"></i></a>
							<?php } ?>
						</li>
					</ul>
				</div>
			</div>
		</div>
	<?php } ?>
	</div>
		
<?php if ($JAK_PAGINATE) echo $JAK_PAGINATE;?>
		
<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/footer.php';?>