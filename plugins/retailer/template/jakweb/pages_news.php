<?php include_once APP_PATH.'plugins/retailer/functions.php';

	$showretailerarray = explode(":", $row['showretailer']);
	
	if (is_array($showretailerarray) && in_array("ASC", $showretailerarray) || in_array("DESC", $showretailerarray)) {
	
		$JAK_RETAILER = jak_get_retailer('LIMIT '.$showretailerarray[1], 't1.id '.$showretailerarray[0], '', 't1.id', $jkv["retailerurl"], $tl["general"]["g56"]);
		
	} else {

		$JAK_RETAILER = jak_get_retailer('', 't1.id ASC', $row['showretailer'], 't1.id', $jkv["retailerurl"], $tl["general"]["g56"]);
	}

?>

<h3><?php echo JAK_PLUGIN_NAME_RETAILER;?></h3>
<div class="row">
<?php if (isset($JAK_RETAILER) && is_array($JAK_RETAILER)) foreach($JAK_RETAILER as $ret) { ?>

<!-- Post -->
<div class="col-md-3 col-sm-6">
	<div class="jak-post">
		<!-- Post Info -->
		<div class="post-info">
			<div class="post-date">
				<div class="date"><?php echo $ret["created"];?></div>
			</div>
			<div class="post-comments-count">
				<i class="fa fa-eye"></i> <?php echo $tl["general"]["g13"].$ret["hits"];?>
			</div>
		</div>
		<!-- End Post Info -->
		<!-- Post Image -->
		<a href="<?php echo $ret["parseurl"];?>"><img src="<?php echo BASE_URL.$ret["previmg"];?>" alt="retailer-preview" class="post-image img-responsive"></a>
		<!-- End Post Image -->
		<!-- Post Title & Summary -->
		<div class="post-title">
			<h3><a href="<?php echo $ret["parseurl"];?>"><?php echo jak_cut_text($ret["title"],20,"");?></a></h3>
		</div>
		<div class="post-summary">
			<p><?php echo $ret["contentshort"];?></p>
		</div>
		<!-- End Post Title & Summary -->
		<div class="post-more">
			<a href="<?php echo $ret["parseurl"];?>" class="btn btn-small"><?php echo $tl["general"]["g3"];?></a>
			<?php if (JAK_ASACCESS) { ?>
			
				<a href="<?php echo BASE_URL;?>admin/index.php?p=retailer&amp;sp=edit&amp;id=<?php echo $ret["id"];?>" title="<?php echo $tl["general"]["g"];?>" class="btn btn-default jaktip"><i class="fa fa-pencil"></i></a>
				
				<a class="btn btn-default jaktip quickedit" href="<?php echo BASE_URL;?>admin/index.php?p=retailer&amp;sp=quickedit&amp;id=<?php echo $ret["id"];?>" title="<?php echo $tl["general"]["g176"];?>"><i class="fa fa-edit"></i></a>
			
			<?php } ?>
		</div>
	</div>
</div>
<!-- End Post -->

<?php } ?>
</div>