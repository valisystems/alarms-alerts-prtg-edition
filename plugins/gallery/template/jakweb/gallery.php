<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/header.php';?>
		
		<?php if (JAK_ASACCESS) $apedit = BASE_URL.'admin/index.php?p=gallery&amp;sp=setting';?>
		
		<?php if ($PAGE_CONTENT) echo $PAGE_CONTENT;?>
		
		<?php if ($JAK_GALLERY_CAT) { if (isset($JAK_GALLERY_CAT) && is_array($JAK_GALLERY_CAT)) foreach($JAK_GALLERY_CAT as $carray) { 
		
		if ($carray["catparent"] != 0)
			$catexistid = array('catparent' => $carray["catparent"]);
				
		} ?>
		
		<nav class="navbar navbar-default" role="navigation">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#gallery-nav" aria-expanded="false">
			        <span class="sr-only">Toggle navigation</span>
			        <i class="fa fa-bars"></i>
			      </button>
			<div class="collapse navbar-collapse" id="gallery-nav">
				<ul class="nav navbar-nav gallery-nav">
				
				<li<?php if ($page2 == '' && $page3 == '') echo ' class="active"';?>><a href="<?php echo $backtogallery;?>" name="all"><?php echo $tlgal["gallery"]["d"];?></a></li>
		
		<?php if (isset($JAK_GALLERY_CAT) && is_array($JAK_GALLERY_CAT)) foreach($JAK_GALLERY_CAT as $mv) { if ($mv["catparent"] == '0') { ?>
		
		<li<?php if ($page2 != '' && $page2 == $mv["id"] && $mv["catorder"] == 1) echo ' class="active"';?>><a href="<?php echo $mv['parseurl'];?>" name="<?php echo $mv["varname"];?>"><?php if ($mv["catimg"]) { ?><i class="fa <?php echo $mv["catimg"];?>"></i> <?php } echo $mv["name"];?></a>
		
		<?php if (isset($catexistid) && is_array($catexistid) && in_array($mv['id'], $catexistid)) { ?>
		
		<ul>
		
		<?php if (isset($JAK_GALLERY_CAT) && is_array($JAK_GALLERY_CAT)) foreach($JAK_GALLERY_CAT as $mz) {
		
		if ($mz["catparent"] != '0' && $mz["catparent"] == $mv["id"]) { 
		
		?>
		 
		<li><a href="<?php echo $mz['parseurl'];?>" name="<?php echo $mz["varname"];?>"><?php if ($mz["catimg"]) { ?><i class="fa <?php echo $mz["catimg"];?>"></i> <?php } echo $mz["name"];?></a></li>
		<?php } } ?>
		</ul>
		</li>
		<?php } else { ?>
		</li>
		
		<?php } } } ?>
		
		</ul>
		</div>
		</nav>

		<?php } if (isset($JAK_GALLERY_ALL) && is_array($JAK_GALLERY_ALL)) foreach($JAK_GALLERY_ALL as $v) { ?>
		
			<?php if ($v["paththumb"]) { ?>
				<figure class="thumb" title="<?php echo sprintf($tlgal["gallery"]["d4"], $v["created"]);?>">
				    <a <?php if ($jkv["galleryopenattached"]) { echo 'href="'.BASE_URL.$JAK_UPLOAD_PATH_BASE.$v["pathbig"].'" data-lightbox="g"'; } else { echo 'href="'.$v["parseurl"].'"';}?>><img src="<?php echo BASE_URL.$JAK_UPLOAD_PATH_BASE.$v["paththumb"];?>" class="img-thumbnail" alt="<?php echo $v["title"];?>" /></a>
				    <?php if ($jkv["galleryopenattached"]) { ?>
				    <a href="<?php echo $v["parseurl"];?>" class="btn btn-xs btn-default img-open"><i class="fa fa-eye"></i></a>
				    <?php } ?>
				</figure>
			<?php } ?>
		
		<?php } ?>
		<div class="clearfix"></div>
		<?php if (!empty($page2) && $usrpupload) { ?>
		
		<hr>
		<form class="dropzone" id="cUploadDrop">
		  <div class="fallback">
		    <input name="file" type="file" multiple />
		  </div>
		  <input type="hidden" name="catid" value="<?php echo $page2;?>" />
		</form>
		
		<script type="text/javascript">
				$('head').append('<link rel="stylesheet" href="\/plugins\/gallery\/css\/dropzone.css">');
		</script>
		
		<script type="text/javascript" src="/plugins/gallery/js/dropzone.js"></script>
		
		<script type="text/javascript">
			//dropzone config
			Dropzone.options.cUploadDrop = {
			    dictResponseError: "SERVER ERROR",
			    paramName: "Filedata", // The name that will be used to transfer the file
			    maxFilesize: <?php echo $jkv["galleryimgsize"];?>,
			    maxFiles: 5,
			    acceptedFiles: "image/*",
			    url: "/plugins/gallery/uploaderc.php",
			    init: function () {
			        this.on("complete", function (file) {
			          if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
			            //location.reload();
			          }
			        });
			      }
			    
			};
		</script>
		
		<div class="clearfix"></div>
		
		<?php } if ($JAK_PAGINATE) echo $JAK_PAGINATE;?>
		
		<script type="text/javascript">$(document).ready(function(){var instanceG=$('a[data-lightbox="g"]').imageLightbox();});</script>
		
<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/footer.php';?>