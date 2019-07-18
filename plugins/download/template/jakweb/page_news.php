<?php include_once APP_PATH.'plugins/download/functions.php';

	$showdlarray = explode(":", $row['showdownload']);
	
	if (is_array($showdlarray) && in_array("ASC", $showdlarray) || in_array("DESC", $showdlarray)) {
	
		$JAK_DOWNLOAD = jak_get_download('LIMIT '.$showdlarray[1], 't1.id '.$showdlarray[0], '', 't1.id', $jkv["downloadurl"], $tl['general']['g56']);
		
	} else {

		$JAK_DOWNLOAD = jak_get_download('', 't1.id ASC', $row['showdownload'], 't1.id', $jkv["downloadurl"], $tl['general']['g56']);
	}

?>

<h2><?php echo $tld["dload"]["d11"].JAK_PLUGIN_NAME_DOWNLOAD;?></h2>
<div class="row">
<?php if (isset($JAK_DOWNLOAD) && is_array($JAK_DOWNLOAD)) foreach($JAK_DOWNLOAD as $d) { ?>
	<div class="col-md-4 col-sm-6">
		<div class="zoom-item">
			<div class="zoom-image">
				<a href="<?php echo $d["parseurl"];?>"><img src="<?php echo $d["previmg"];?>" alt="download-preview" /></a>
			</div>
			<div class="zoom-info">
				<ul>
					<li class="zoom-project-name"><a href="<?php echo $d["parseurl"];?>"><?php echo $d["title"];?></a></li>
					<li><?php echo $d["contentshort"];?></li>
					<li class="read-more">
						<a href="<?php echo $d["parseurl"];?>" class="btn btn-primary"><?php echo $tl["general"]["g3"];?></a>
						<?php if (JAK_ASACCESS) { ?>
						<a class="btn btn-default jaktip" href="<?php echo BASE_URL;?>admin/index.php?p=download&amp;sp=edit&amp;id=<?php echo $d["id"];?>" title="<?php echo $tl["general"]["g"];?>"><i class="fa fa-pencil"></i></a>
						<a class="btn btn-default jaktip quickedit" href="<?php echo BASE_URL;?>admin/index.php?p=download&amp;sp=quickedit&amp;id=<?php echo $d["id"];?>" title="<?php echo $tl["general"]["g176"];?>"><i class="fa fa-edit"></i></a>
						<?php } ?>
					</li>
				</ul>
			</div>
		</div>
	</div>
<?php } ?>
</div>