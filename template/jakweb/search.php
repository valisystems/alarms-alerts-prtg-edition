<?php include_once APP_PATH.'template/jakweb/header.php';?>

	<?php if (!$jkv["searchform"]) { ?>
		<div class="alert alert-danger">
			<?php echo $tl["errorpage"]["ep"];?>	
		</div>
	<?php } if (isset($PAGE_TITLE)) echo '<h2 class="first-child text-color">'.$PAGE_TITLE .'</h2>'; if (isset($PAGE_CONTENT)) echo $PAGE_CONTENT;?>
	
	<form role="form" action="<?php echo $P_SEAERCH_LINK;?>" method="post">
		<div class="input-group">
			<input type="text" name="jakSH" id="Jajaxs" class="form-control input-lg" placeholder="<?php echo $tl["search"]["s"]; if ($jkv["fulltextsearch"]) echo $tl["search"]["s5"];?>">
		      <span class="input-group-btn">
		        <button type="submit" class="btn btn-primary btn-lg" name="search" id="JajaxSubmitSearch"><?php echo $tl["general"]["g83"];?></button>
		      </span>
		 </div><!-- /input-group -->
	  <?php if (isset($JAK_HOOK_SEARCH_SIDEBAR) && is_array($JAK_HOOK_SEARCH_SIDEBAR)) foreach($JAK_HOOK_SEARCH_SIDEBAR as $hss) { include_once APP_PATH.$hss['phpcode']; } ?>
	</form>
	
	<?php if ($JAK_SEARCH_CLOUD) { ?><hr><div class="well well-sm"><?php echo $JAK_SEARCH_CLOUD;?></div><?php } ?>
		
	<?php if ($errors) { ?>
	<hr>
		<div class="alert alert-danger fade in">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<?php if (isset($errors["e1"])) echo $errors["e1"];
				  if (isset($errors["e2"])) echo $errors["e2"];
				  if (isset($errors["e"])) echo $errors["e"];?>
		</div>
	<?php } if (isset($JAK_SEARCH_USED)) { ?>
		
		<h3><?php echo $tl["search"]["s4"];?><strong> <?php echo $JAK_SEARCH_WORD_RESULT;?></strong></h3>
		
		<div class="row">
		
		<?php $count = 0; if (isset($JAK_SEARCH_RESULT) && is_array($JAK_SEARCH_RESULT)) foreach($JAK_SEARCH_RESULT as $v) { $count++; ?>
		
		<div class="col-md-3 col-sm-6">
			<div class="service-wrapper">
				<i class="fa fa-file-text-o fa-4x"></i>
				<h3><a href="<?php echo $v["parseurl"];?>"><?php echo $v["title"];?></a></h3>
				<p><?php echo $v["content"];?></p>
				<a href="<?php echo $v["parseurl"];?>" class="btn btn-primary"><?php echo $tl["general"]["g3"];?></a>
			</div>
		</div>
		
		<?php } if (isset($JAK_SEARCH_RESULT_NEWS) && is_array($JAK_SEARCH_RESULT_NEWS)) foreach($JAK_SEARCH_RESULT_NEWS as $n) { $count++; ?>
		
		<div class="col-md-3 col-sm-6">
			<div class="service-wrapper">
				<i class="fa fa-newspaper-o fa-4x"></i>
				<h3><a href="<?php echo $n["parseurl"];?>"><?php echo $n["title"];?></a></h3>
				<p><?php echo $n["content"];?></p>
				<a href="<?php echo $n["parseurl"];?>" class="btn btn-primary"><?php echo $tl["general"]["g3"];?></a>
			</div>
		</div>
		
		<?php } if (isset($JAK_HOOK_SEARCH) && is_array($JAK_HOOK_SEARCH)) foreach($JAK_HOOK_SEARCH as $hs) { include_once APP_PATH.$hs["phpcode"]; } ?>
		
		</div>
		
		<?php if (isset($count)) { ?>
		
		<div class="alert alert-info">
			<?php echo str_replace("%s", $count, $tl["general"]["g159"]);?>
		</div>
		
		<?php } else { ?>
		
		<div class="alert alert-danger">
			<?php echo $tl["general"]["g158"];?>	
		</div>
		
		<?php } } ?>
		
<script type="text/javascript">
$(document).ready(function(){
		
	$('#searchi').alphanumeric({nocaps:false, allow:' -+*'});
	
});
</script>

<?php include_once APP_PATH.'template/jakweb/footer.php';?>