<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/header.php';?>
		
<?php if (JAK_ASACCESS) $apedit = BASE_URL.'admin/index.php?p=download&amp;sp=setting';?>
		
<?php if ($PAGE_CONTENT) echo $PAGE_CONTENT;?>

<div class="row">
<?php if (isset($JAK_DOWNLOAD_ALL) && is_array($JAK_DOWNLOAD_ALL)) foreach($JAK_DOWNLOAD_ALL as $v) { ?>
	<div class="col-md-4 col-sm-6">
		<div class="zoom-item">
			<div class="zoom-image">
				<a href="<?php echo $v["parseurl"];?>"><img src="<?php echo $v["previmg"];?>" alt="download-preview" /></a>
			</div>
			<div class="zoom-info">
				<ul>
					<li class="zoom-project-name"><a href="<?php echo $v["parseurl"];?>"><?php echo $v["title"];?></a></li>
					<li><?php echo $v["contentshort"];?></li>
					<li class="read-more">
						<a href="<?php echo $v["parseurl"];?>" class="btn btn-primary"><?php echo $tl["general"]["g3"];?></a>
						<?php if (JAK_ASACCESS) { ?>
						<a class="btn btn-default jaktip" href="<?php echo BASE_URL;?>admin/index.php?p=download&amp;sp=edit&amp;id=<?php echo $v["id"];?>" title="<?php echo $tl["general"]["g"];?>"><i class="fa fa-pencil"></i></a>
						<a class="btn btn-default jaktip quickedit" href="<?php echo BASE_URL;?>admin/index.php?p=download&amp;sp=quickedit&amp;id=<?php echo $v["id"];?>" title="<?php echo $tl["general"]["g176"];?>"><i class="fa fa-edit"></i></a>
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