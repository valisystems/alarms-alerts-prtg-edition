<?php include_once APP_PATH.'plugins/blog/functions.php';

	$showblogarray = explode(":", $row['showblog']);
	
	if (is_array($showblogarray) && in_array("ASC", $showblogarray) || in_array("DESC", $showblogarray)) {
	
		$JAK_BLOG = jak_get_blog('LIMIT '.$showblogarray[1], 't1.id '.$showblogarray[0], '', 't1.id', $jkv["blogurl"], $tl['general']['g56']);
		
	} else {

		$JAK_BLOG = jak_get_blog('', 't1.id ASC', $row['showblog'], 't1.id', $jkv["blogurl"], $tl['general']['g56']);
	}

?>

<h3><?php echo $tlblog["blog"]["d3"];?></h3>
<div class="row">
<?php if (isset($JAK_BLOG) && is_array($JAK_BLOG)) foreach($JAK_BLOG as $bl) { ?>

<!-- Post -->
<div class="col-md-3 col-sm-6">
	<div class="jak-post">
		<!-- Post Info -->
		<div class="post-info">
			<div class="post-date">
				<div class="date"><?php echo $bl["created"];?></div>
			</div>
			<div class="post-comments-count">
				<i class="fa fa-eye"></i> <?php echo $tl["general"]["g13"].$bl["hits"];?>
			</div>
		</div>
		<!-- End Post Info -->
		<!-- Post Image -->
		<a href="<?php echo $bl["parseurl"];?>"><img src="<?php echo BASE_URL.$bl["previmg"];?>" alt="blog-preview" class="post-image img-responsive"></a>
		<!-- End Post Image -->
		<!-- Post Title & Summary -->
		<div class="post-title">
			<h3><a href="<?php echo $bl["parseurl"];?>"><?php echo jak_cut_text($bl["title"],20,"");?></a></h3>
		</div>
		<div class="post-summary">
			<p><?php echo $bl["contentshort"];?></p>
		</div>
		<!-- End Post Title & Summary -->
		<div class="post-more">
			<a href="<?php echo $bl["parseurl"];?>" class="btn btn-primary btn-small"><?php echo $tl["general"]["g3"];?></a>
			<?php if (JAK_ASACCESS) { ?>
			
				<a href="<?php echo BASE_URL;?>admin/index.php?p=blog&amp;sp=edit&amp;id=<?php echo $bl["id"];?>" title="<?php echo $tl["general"]["g"];?>" class="btn btn-default jaktip"><i class="fa fa-pencil"></i></a>
				
				<a class="btn btn-default jaktip quickedit" href="<?php echo BASE_URL;?>admin/index.php?p=blog&amp;sp=quickedit&amp;id=<?php echo $bl["id"];?>" title="<?php echo $tl["general"]["g176"];?>"><i class="fa fa-edit"></i></a>
			
			<?php } ?>
		</div>
	</div>
</div>
<!-- End Post -->

<?php } ?>
</div>