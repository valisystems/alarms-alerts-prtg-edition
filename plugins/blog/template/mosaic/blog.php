<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/header.php';?>

<?php if (JAK_ASACCESS) $apedit = BASE_URL.'admin/index.php?p=blog&amp;sp=setting';?>
	
<?php if ($PAGE_CONTENT) echo $PAGE_CONTENT;?>
		
<div class="row">	
<?php if (isset($JAK_BLOG_ALL) && is_array($JAK_BLOG_ALL)) foreach($JAK_BLOG_ALL as $v) { ?>
	<!-- Post -->
	<div class="col-md-4 col-sm-6">
		<div class="jak-post">
			<!-- Post Info -->
			<div class="post-info">
				<div class="info-details">
					<?php if ($v["showdate"]) { ?><i class="fa fa-clock-o"></i> <?php echo $v["created"];?> <?php } ?><i class="fa fa-eye"></i> <?php echo $tl["general"]["g13"].$v["hits"];?>
				</div>
			</div>
			<!-- End Post Info -->
			<!-- Post Image -->
			<a href="<?php echo $v["parseurl"];?>"><img src="<?php echo BASE_URL.$v["previmg"];?>" alt="blog-preview" class="post-image img-responsive"></a>
			<!-- End Post Image -->
			<!-- Post Title & Summary -->
			<div class="post-title">
				<h3 class="text-color"><span><a href="<?php echo $v["parseurl"];?>"><?php echo jak_cut_text($v["title"],30,"");?></a></span></h3>
			</div>
			<div class="post-summary">
				<p><?php echo $v["contentshort"];?></p>
			</div>
			<!-- End Post Title & Summary -->
			<div class="post-more">
				<a href="<?php echo $v["parseurl"];?>" class="btn btn-color btn-sm"><i class="fa fa-book"></i> <?php echo $tl["general"]["g3"];?></a>
				<?php if (JAK_ASACCESS) { ?>
				
					<a href="<?php echo BASE_URL;?>admin/index.php?p=blog&amp;sp=edit&amp;id=<?php echo $v["id"];?>" title="<?php echo $tl["general"]["g"];?>" class="btn btn-default btn-sm jaktip"><i class="fa fa-pencil"></i></a>
					
					<a class="btn btn-default btn-sm jaktip quickedit" href="<?php echo BASE_URL;?>admin/index.php?p=blog&amp;sp=quickedit&amp;id=<?php echo $v["id"];?>" title="<?php echo $tl["general"]["g176"];?>"><i class="fa fa-edit"></i></a>
				
				<?php } ?>
			</div>
		</div>
	</div>
	<!-- End Post -->
<?php } ?>		
</div>
		
<?php if ($JAK_PAGINATE) echo $JAK_PAGINATE;?>
		
<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/footer.php';?>