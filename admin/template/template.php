<?php include "header.php";?>

<?php if ($page1 == "s") { ?>
<div class="alert alert-success fade in">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <?php echo $tl["general"]["g7"];?>
</div>
<?php } if ($page1 == "e") { ?>
<div class="alert alert-danger fade in">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <?php echo $tl["errorpage"]["sql"];?>
</div>
<?php } ?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">	
<div class="row">
<?php if (isset($site_style_files) && is_array($site_style_files)) foreach($site_style_files as $l) {

if (isset($jkv["cms_tpl"])) { 
	$template_addon = true;
} else {
	$template_addon = false;
}

?>

<div class="col-sm-6 col-md-3">
  <div class="thumbnail">
    <img src="../template/<?php echo $l;?>/preview.jpg" alt="<?php echo $l;?>" />
    <div class="caption">
      <h3><?php echo $l;?><?php if ($jkv["sitestyle"] == $l) echo ' <i class="fa fa-check"></i>'; ?></h3>
      <p>
      
      	<?php if ($jkv["sitestyle"] != $l && !$template_addon) { ?> 
      	<button value="<?php echo $l;?>" name="save" class="btn btn-primary"><?php echo $tl["title"]["t16"];?></button>
      	<?php } elseif ($jkv["sitestyle"] == $l && file_exists('../template/'.$l.'/install.php') && !$template_addon) { ?>
      	
      	<a class="btn btn-success btn-sm tempInst" href="../template/<?php echo $l;?>/install.php"><?php echo $tl["general"]["g93"];?></a>
      	<a class="btn btn-info btn-sm tempSett" href="../template/<?php echo $l;?>/help.html"><?php echo $tl["title"]["t21"];?></a>
      	
      	<?php } elseif ($jkv["sitestyle"] == $l && file_exists('../template/'.$l.'/uninstall.php') && $template_addon) { if (file_exists('../template/'.$l.'/styleswitcher.php')) { ?>
      	<a class="btn btn-<?php if ($jkv["styleswitcher_tpl"]) { echo 'success'; } else { echo 'default';}?> btn-sm" href="index.php?p=template&amp;sp=active&amp;ssp=<?php echo $l;?>"><i class="fa fa-css3"></i> <?php echo $tl["style"]["s2"];?></a> <?php } ?><a class="btn btn-danger btn-sm tempInst" href="../template/<?php echo $l;?>/uninstall.php"><i class="fa fa-remove"></i> <?php echo $tl["general"]["g94"];?></a>
      	
      	<?php } else { ?>
      	<div class="progress">
      	  <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
      	    <?php echo str_replace("%s", $jkv["sitestyle"], $tl["style"]["s1"]);?>
      	  </div>
      	</div>
      	<?php } ?>
      	
      </p>
    </div>
  </div>
</div>
	
<?php } ?>
</div>
</form>


<script type="text/javascript">
	$(document).ready(function(){
	
		$('.tempSett').on('click', function(e) {
			e.preventDefault();
			frameSrc = $(this).attr("href");
			$('#JAKModalLabel').html("<?php echo ucwords($page);?>");
			$('#JAKModal').on('show.bs.modal', function () {
			  	$('<iframe src="'+frameSrc+'" width="100%" height="400px" frameborder="0">').appendTo('.modal-body');
			});
			$('#JAKModal').on('hidden.bs.modal', function() {
			  	window.location.reload();
			});
			$('#JAKModal').modal({show:true});
		});
		
		$('.tempInst').on('click', function(e) {
			e.preventDefault();
			frameSrc = $(this).attr("href");
			$('#JAKModalLabel').html("<?php echo ucwords($page);?>");
			$('#JAKModal').on('show.bs.modal', function () {
			  	$('<iframe src="'+frameSrc+'" width="100%" height="100%" frameborder="0">').appendTo('.modal-body');
			});
			$('#JAKModal').on('hidden.bs.modal', function() {
			  	window.location.reload();
			});
			$('#JAKModal').modal({show:true});
		});
	});
</script>
		
<?php include "footer.php";?>