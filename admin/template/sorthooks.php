<?php include "header.php";?>

<?php if ($page2 == "s") { ?>
<div class="alert alert-success fade in">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <?php echo $tl["general"]["g7"];?>
</div>
<?php } if ($page2 == "e" || $page2 == "edn") { ?>
<div class="alert alert-danger fade in">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <h4><?php echo ($page2 == "e" ? $tl["errorpage"]["sql"] : $tl["errorpage"]["plugin"]);?></h4>
</div>
<?php } ?>

<div class="btn-group pull-right">
	<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $tl["menu"]["m27"];?>
	    <span class="caret"></span>
	</a>
  <ul class="dropdown-menu">
  	<?php if (isset($JAK_HOOK_LOCATIONS) && is_array($JAK_HOOK_LOCATIONS)) foreach($JAK_HOOK_LOCATIONS as $h) { ?>
  	<li><a href="index.php?p=plugins&sp=sorthooks&ssp=<?php echo $h;?>"><?php echo $h;?></a></li>
  	<?php } ?>
  </ul>
</div>

<?php if (isset($JAK_HOOKS) && is_array($JAK_HOOKS)) { ?>

<div class="box">
<div class="box-body">
<ul class="jak_hooks_move">
<?php foreach($JAK_HOOKS as $v) { ?>

<li id="hook-<?php echo $v["id"];?>" class="jakhooks">
	<div class="text">#<?php echo $v["id"];?> <a href="index.php?p=plugins&amp;sp=hooks&amp;ssp=edit&amp;sssp=<?php echo $v["id"];?>"><?php echo $v["name"];?></a></div>
	<div class="show"><?php echo $tl["hook"]["h1"];?>: <a href="index.php?p=plugins&amp;sp=sorthooks&amp;ssp=<?php echo $v["hook_name"];?>"><?php echo $v["hook_name"];?></a> | <?php echo $tl["tag"]["t1"].':'; if ($v["pluginid"] != '0') { ?> <a href="index.php?p=plugins&amp;sp=sorthooks&amp;ssp=<?php echo $v["pluginid"];?>"><?php echo $v["pluginname"];?></a><?php } else { echo ' -'; } ?></div>
	<div class="actions">
	
		<a class="btn btn-default btn-xs" href="index.php?p=plugins&amp;sp=hooks&amp;ssp=lock&amp;sssp=<?php echo $v["id"];?>"><i class="fa fa-<?php if ($v["active"] == 0) { ?>lock<?php } else { ?>check<?php } ?>"></i></a>
		<a class="btn btn-default btn-xs" href="index.php?p=plugins&amp;sp=hooks&amp;ssp=edit&amp;sssp=<?php echo $v["id"];?>"><i class="fa fa-edit"></i></a>
		<?php if ($v["id"] > 5 ) {?><a class="btn btn-default btn-xs" href="index.php?p=plugins&amp;sp=hooks&amp;ssp=delete&amp;sssp=<?php echo $v["id"];?>" onclick="if(!confirm('<?php echo $tl["hook"]["al"];?>'))return false;"><i class="fa fa-trash-o"></i></a><?php } ?>
	
	</div>
</li>

<?php } ?>
</ul>
</div>
</div>

<?php } else { ?>

<div class="alert alert-info">
 	<?php echo $tl["errorpage"]["data"];?>
</div>

<?php } ?>

<div class="icon_legend">
<h3><?php echo $tl["icons"]["i"];?></h3>
<i title="<?php echo $tl["icons"]["i6"];?>" class="fa fa-check"></i>
<i title="<?php echo $tl["icons"]["i5"];?>" class="fa fa-lock"></i>
<i title="<?php echo $tl["icons"]["i2"];?>" class="fa fa-edit"></i>
<i title="<?php echo $tl["icons"]["i1"];?>" class="fa fa-trash-o"></i>
</div>	

<script src="js/hookorder.js" type="text/javascript"></script>
		
<?php include "footer.php";?>