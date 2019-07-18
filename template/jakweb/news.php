<?php include_once APP_PATH.'template/jakweb/header.php';?>

<?php if ($PAGE_CONTENT) echo $PAGE_CONTENT;?>

<?php if (isset($JAK_HOOK_NEWS) && is_array($JAK_HOOK_NEWS)) foreach($JAK_HOOK_NEWS as $n) { include_once APP_PATH.$n['phpcode']; } ?>

<div class="row">
		
<?php if (isset($JAK_NEWS_ALL) && is_array($JAK_NEWS_ALL)) foreach($JAK_NEWS_ALL as $v) { ?>
	<!-- Post -->
	<div class="col-md-4 col-sm-6">
		<div class="jak-post">
			<!-- Post Info -->
			<div class="post-info">
				<div class="post-date">
					<div class="date"><?php echo $v["created"];?></div>
				</div>
				<div class="post-comments-count">
					<i class="fa fa-eye"></i> <?php echo $tl["general"]["g13"].$v["hits"];?>
				</div>
			</div>
			<!-- End Post Info -->
			<!-- Post Image -->
			<a href="<?php echo $v["parseurl"];?>"><img src="<?php echo BASE_URL.$v["previmg"];?>" alt="news-preview" class="post-image img-responsive"></a>
			<!-- End Post Image -->
			<!-- Post Title & Summary -->
			<div class="post-title">
				<h3><a href="<?php echo $v["parseurl"];?>"><?php echo jak_cut_text($v["title"],30,"");?></a></h3>
			</div>
			<div class="post-summary">
				<p><?php echo $v["contentshort"];?></p>
			</div>
			<!-- End Post Title & Summary -->
			<div class="post-more">
				<a href="<?php echo $v["parseurl"];?>" class="btn btn-primary btn-small"><?php echo $tl["general"]["g3"];?></a>
				<?php if (JAK_ASACCESS) { ?>
				
					<a href="<?php echo BASE_URL;?>admin/index.php?p=news&amp;sp=edit&amp;id=<?php echo $v["id"];?>" title="<?php echo $tl["general"]["g"];?>" class="btn btn-default jaktip"><i class="fa fa-pencil"></i></a>
					
					<a class="btn btn-default jaktip quickedit" href="<?php echo BASE_URL;?>admin/index.php?p=news&amp;sp=quickedit&amp;id=<?php echo $v["id"];?>" title="<?php echo $tl["general"]["g176"];?>"><i class="fa fa-edit"></i></a>
				
				<?php } ?>
			</div>
		</div>
	</div>
	<!-- End Post -->
<?php } ?>
				
</div>

<?php if ($JAK_PAGINATE) echo $JAK_PAGINATE;?>
		
<?php include_once APP_PATH.'template/jakweb/footer.php';?>