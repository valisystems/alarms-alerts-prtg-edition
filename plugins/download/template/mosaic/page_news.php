<?php include_once APP_PATH.'plugins/download/functions.php';

	$showdlarray = explode(":", $row['showdownload']);
	
	if (is_array($showdlarray) && in_array("ASC", $showdlarray) || in_array("DESC", $showdlarray)) {
	
		$JAK_DOWNLOAD = jak_get_download('LIMIT '.$showdlarray[1], 't1.id '.$showdlarray[0], '', 't1.id', $jkv["downloadurl"], $tl['general']['g56']);
		
	} else {

		$JAK_DOWNLOAD = jak_get_download('', 't1.id ASC', $row['showdownload'], 't1.id', $jkv["downloadurl"], $tl['general']['g56']);
	}

?>

<hr>
<h3 class="text-color"><?php echo $tld["dload"]["d11"].JAK_PLUGIN_NAME_DOWNLOAD;?></h3>
<div class="row">
<?php if (isset($JAK_DOWNLOAD) && is_array($JAK_DOWNLOAD)) foreach($JAK_DOWNLOAD as $d) { ?>
	<!-- Post -->
	<div class="col-md-4 col-sm-6">
		<div class="jak-post">
			<!-- Post Image -->
			<div class="jak-post-mask">
			<a href="<?php echo $d["parseurl"];?>"><img src="<?php echo BASE_URL.$d["previmg"];?>" alt="blog-preview" class="post-image img-responsive">
			<div class="mask">
				 <?php if ($d["showdate"]) { ?><i class="fa fa-clock-o"></i> <?php echo $d["created"];?> <?php } ?><span class="pull-right"><i class="fa fa-eye"></i> <?php echo $tl["general"]["g13"].$d["hits"];?></span>
			 </div>
			</a>
			</div>
			<!-- End Post Image -->
			<!-- Post Title & Summary -->
			<div class="post-title">
				<h3 class="text-color"><span><a href="<?php echo $d["parseurl"];?>"><?php echo jak_cut_text($d["title"],30,"");?></a></span></h3>
			</div>
			<div class="post-summary">
				<p><?php echo $d["contentshort"];?></p>
			</div>
			<!-- End Post Title & Summary -->
			<div class="post-more">
				<a href="<?php echo $d["parseurl"];?>" class="btn btn-color btn-sm"><i class="fa fa-download"></i> <?php echo $tld["dload"]["d2"];?></a>
				<?php if (JAK_ASACCESS) { ?>
				
					<a href="<?php echo BASE_URL;?>admin/index.php?p=download&amp;sp=edit&amp;id=<?php echo $d["id"];?>" title="<?php echo $tl["general"]["g"];?>" class="btn btn-default btn-sm jaktip"><i class="fa fa-pencil"></i></a>
					
					<a class="btn btn-default btn-sm jaktip quickedit" href="<?php echo BASE_URL;?>admin/index.php?p=download&amp;sp=quickedit&amp;id=<?php echo $d["id"];?>" title="<?php echo $tl["general"]["g176"];?>"><i class="fa fa-edit"></i></a>
				
				<?php } ?>
			</div>
		</div>
	</div>
	<!-- End Post -->
<?php } ?>
</div>