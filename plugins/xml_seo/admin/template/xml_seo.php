<?php include_once APP_PATH.'admin/template/header.php';?>

<?php if (isset($xml_result)) { ?>
<div class="alert alert-success">Sitemap created</div>
<div class="alert alert-warning">Your sitemap: <?php echo BASE_URL_ORIG;?>plugins/xml_seo/files/sitemap.xml</div>
<div class="alert alert-info"><?php echo $xml_result;?></div>
<?php } else { ?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<button type="submit" name="save" class="btn btn-block btn-primary">Create Sitemap</button>
</form>
<?php } ?>
		
<?php include_once APP_PATH.'admin/template/footer.php';?>