<?php include_once APP_PATH.'plugins/device/functions.php';

	$showdlarray = explode(":", $row['showdownload']);
	
	if (is_array($showdlarray) && in_array("ASC", $showdlarray) || in_array("DESC", $showdlarray)) {
	
		$JAK_DOWNLOAD = jak_get_download('LIMIT '.$showdlarray[1], 't1.id '.$showdlarray[0], '', 't1.id', $jkv["downloadurl"], $tl['general']['g56']);
		
	} else {

		$JAK_DOWNLOAD = jak_get_download('', 't1.id ASC', $row['showdownload'], 't1.id', $jkv["downloadurl"], $tl['general']['g56']);
	}

?>

<hr>
<h2><?php echo $tld["dload"]["d11"].JAK_PLUGIN_NAME_DOWNLOAD;?></h2>

<?php if (isset($JAK_DOWNLOAD) && is_array($JAK_DOWNLOAD)) foreach($JAK_DOWNLOAD as $d) { ?>

	<?php if ($d["previmg"]) { ?>
	<div class="row">
		<div class="col-md-2">
		     <a href="<?php echo $d["parseurl"];?>"><img src="<?php echo BASE_URL.$d["previmg"];?>" alt="download-thumbnail" /></a>
		</div>
		<div class="col-md-10">
	<?php } ?>
		
		<h3><a href="<?php echo $d["parseurl"];?>"><?php echo $d["title"];?></a></h3>
		    <p><?php echo $d["contentshort"];?></p>
	
	<?php if ($d["previmg"]) echo "</div></div><hr>"; } else { echo "<hr>"; } ?>