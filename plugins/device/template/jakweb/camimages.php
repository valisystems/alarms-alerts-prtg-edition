<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/header.php';?>

<script type="text/javascript">
	var camHost = "<?= $camurl; ?>";
	var auth = "<?= $basic_auth; ?>";
</script>

<script type="text/javascript" src="<?= BASE_URL ?>plugins/device/js/cam.js"></script>

<?php if ($cams)
{
?>
<div class="row">
<?php
	$count = count($cams);
	foreach ($cams as $k => $v)
	{
	?>
	  <div class="col-sm-6 col-md-4">
	    <div class="thumbnail">

	      <img src="<?= $v["image"] ?>" alt="<?= $v['name']?>">
	      <div class="caption">
	        <h3><?= $v['name'] . ' - ' . $v['id']?></h3>
	        <p>
	        	<a href="#" data-video="<?= $v['id'] ?>" class="btn btn-default getVideo" role="button">Video</a>
	        	<a href="/index.php?p=device&amp;sp=cam&amp;ssp=<?= $v['id']?>"class="btn btn-default" role="button">Slide</a>
	        </p>
	      </div>
	    </div>
	  </div>
	<?php
	}
?>
</div>
<?php
}
else {
	echo '<h3>' . $error["e1"] . '</h3>';
}
?>

<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/footer.php';?>

