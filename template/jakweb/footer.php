<?php if ($JAK_SHOW_NAVBAR) { ?>
</div><!--/col-->

<!-- Sidebar if right -->
<?php if (!empty($JAK_HOOK_SIDE_GRID) && $jkv["sidebar_location_tpl"] == "right") { include_once APP_PATH.'template/jakweb/sidebar.php'; } ?>

</div><!--/row-->

</div><!--/.container-->
</div><!-- section -->

<!-- Import templates below header -->
<?php } if ($JAK_SHOW_FOOTER) { if (isset($JAK_HOOK_BELOW_CONTENT) && is_array($JAK_HOOK_BELOW_CONTENT)) foreach($JAK_HOOK_BELOW_CONTENT as $bcontent) { include_once APP_PATH.$bcontent['phpcode']; } ?>

<!-- Call to Action Bar -->
<div class="section section-white<?php if (!$jkv["sectionshow_jakweb_tpl"]) echo ' hidden';?>" id="footer-section">
	<div class="container">
		<div class="row">
			<div class="col-md-4" id="section-content">
				<?php if (is_numeric($jkv["bcontent1_jakweb_tpl"])) {   
					if (isset($JAK_HOOK_FOOTER_WIDGET) && is_array($JAK_HOOK_FOOTER_WIDGET)) foreach($JAK_HOOK_FOOTER_WIDGET as $hfw) {
					if ($hfw["id"] == $jkv["bcontent1_jakweb_tpl"]) {
						include_once $hfw["phpcode"];
				} } } else { echo $jkv["bcontent1_jakweb_tpl"];}?>
			</div>
			<div class="col-md-4" id="section-content2">
				<?php if (is_numeric($jkv["bcontent2_jakweb_tpl"])) { 
					if (isset($JAK_HOOK_FOOTER_WIDGET) && is_array($JAK_HOOK_FOOTER_WIDGET)) foreach($JAK_HOOK_FOOTER_WIDGET as $hfw1) {
					if ($hfw1["id"] == $jkv["bcontent2_jakweb_tpl"]) {
						include_once $hfw1["phpcode"];
				} } } else { echo $jkv["bcontent2_jakweb_tpl"];}?>
			</div>
			<div class="col-md-4" id="section-content3">
				<?php if (is_numeric($jkv["bcontent3_jakweb_tpl"])) { 
					if (isset($JAK_HOOK_FOOTER_WIDGET) && is_array($JAK_HOOK_FOOTER_WIDGET)) foreach($JAK_HOOK_FOOTER_WIDGET as $hfw2) {
					if ($hfw2["id"] == $jkv["bcontent3_jakweb_tpl"]) {
						include_once $hfw2["phpcode"];
				} } } else { echo $jkv["bcontent3_jakweb_tpl"];}?>
			</div>
		</div>
	</div>
</div>
<!-- End Call to Action Bar -->
<?php } if ($JAK_SHOW_FOOTER && JAK_ASACCESS && $jkv["styleswitcher_tpl"]) { ?>
<!-- Footer -->
<div class="footer<?php if (!$jkv["footer_jakweb_tpl"]) echo ' hidden';?>">
	<div class="container">
    	<div class="row">
    		<div class="col-footer col-md-4">
    			<span id="footer-content3"><?php echo $jkv["fcont3_jakweb_tpl"];?></span>
    			<?php echo jak_build_menu(0, $mfooter, $page, 'no-list-style footer-navigate-section', '', '', '', JAK_ASACCESS);?>
    		</div>
    		
    		<div class="col-footer col-md-4">
    			<span id="footer-content"><?php echo $jkv["fcont_jakweb_tpl"];?></span>
    		</div>
    		<div class="col-footer col-md-4">
    			<span class="footer-content2"><?php echo $jkv["fcont2_jakweb_tpl"];?></span>
    			<?php if ($apedit) { ?>
    			<a class="btn btn-default" title="<?php echo $tl["general"]["g"];?>" href="<?php echo $apedit;?>"><i class="fa fa-pencil"></i></a>
    			<?php if ($qapedit) { ?><a class="btn btn-default quickedit" title="<?php echo $tl["general"]["g176"];?>" href="<?php echo $qapedit;?>"><i class="fa fa-edit"></i></a>
    			<?php } } if ($jkv["printme"] && $printme) { ?>
    			<a class="btn btn-default" id="jakprint" href="#"><i class="fa fa-print"></i></a>
    			<?php } if ($JAK_RSS_DISPLAY) { ?>
    			<a class="btn btn-default" href="<?php echo $P_RSS_LINK;?>"><i class="fa fa-rss"></i></a>
    			<?php } if ($jkv["heatmap"] && JAK_ASACCESS) { ?>
    			<a class="btn btn-default" href="javascript:void(0)" id="dispheatmap"><i class="fa fa-bar-chart"></i></a>
    			<?php } ?>
    		</div>
    	</div>
    	<div class="row">
    		<div class="col-md-12">
    			<div class="footer-copyright"><?php echo $jkv["copyright"];?></div>
    		</div>
    	</div>
    </div>
</div>
<!-- Footer -->
<div class="footer footer-small<?php if ($jkv["footer_jakweb_tpl"]) echo ' hidden';?>">
	<div class="container">
    	<div class="row">
    		<div class="col-footer col-md-10">
    			<?php echo jak_build_menu(0, $mfooter, $page, 'no-list-style footer-navigate-section', '', '', '', JAK_ASACCESS);?>
    		</div>
    		
    		<div class="col-footer col-md-2">
    			<span class="footer-content2"><?php echo $jkv["fcont2_jakweb_tpl"];?></span>
    			<?php if ($apedit) { ?>
    			<a class="btn btn-default btn-xs" title="<?php echo $tl["general"]["g"];?>" href="<?php echo $apedit;?>"><i class="fa fa-pencil"></i></a>
    			<?php if ($qapedit) { ?><a class="btn btn-default btn-xs quickedit" title="<?php echo $tl["general"]["g176"];?>" href="<?php echo $qapedit;?>"><i class="fa fa-edit"></i></a>
    			<?php } } if ($jkv["printme"] && $printme) { ?>
    			<a class="btn btn-default btn-xs" id="jakprint" href="#"><i class="fa fa-print"></i></a>
    			<?php } if ($JAK_RSS_DISPLAY) { ?>
    			<a class="btn btn-default btn-xs" href="<?php echo $P_RSS_LINK;?>"><i class="fa fa-rss"></i></a>
    			<?php } if ($jkv["heatmap"] && JAK_ASACCESS) { ?>
    			<a class="btn btn-default" href="javascript:void(0)" id="dispheatmap"><i class="fa fa-bar-chart"></i></a>
    			<?php } ?>
    		</div>
    	</div>
    	<div class="row">
    		<div class="col-md-12">
    			<div class="footer-copyright"><?php echo $jkv["copyright"];?></div>
    		</div>
    	</div>
    </div>
</div>
<?php } else { if ($JAK_SHOW_FOOTER) { if ($jkv["footer_jakweb_tpl"]) { ?>
<!-- Footer -->
<div class="footer">
	<div class="container">
    	<div class="row">
    		<div class="col-footer col-md-4">
    			<?php echo $jkv["fcont3_jakweb_tpl"];?>
    			<?php echo jak_build_menu(0, $mfooter, $page, 'no-list-style footer-navigate-section', '', '', '', JAK_ASACCESS);?>
    		</div>
    		
    		<div class="col-footer col-md-4">
    			<?php echo $jkv["fcont_jakweb_tpl"];?>
    		</div>
    		<div class="col-footer col-md-4">
    			<?php echo $jkv["fcont2_jakweb_tpl"];?>
    			<?php if ($apedit) { ?>
    			<a class="btn btn-default" title="<?php echo $tl["general"]["g"];?>" href="<?php echo $apedit;?>"><i class="fa fa-pencil"></i></a>
    			<?php if ($qapedit) { ?><a class="btn btn-default quickedit" title="<?php echo $tl["general"]["g176"];?>" href="<?php echo $qapedit;?>"><i class="fa fa-edit"></i></a>
    			<?php } } if ($jkv["printme"] && isset($printme)) { ?>
    			<a class="btn btn-default" id="jakprint" href="#"><i class="fa fa-print"></i></a>
    			<?php } if (isset($JAK_RSS_DISPLAY)) { ?>
    			<a class="btn btn-default" href="<?php echo $P_RSS_LINK;?>"><i class="fa fa-rss"></i></a>
    			<?php } if ($jkv["heatmap"] && JAK_ASACCESS) { ?>
    			<a class="btn btn-default" href="javascript:void(0)" id="dispheatmap"><i class="fa fa-bar-chart"></i></a>
    			<?php } ?>
    		</div>
    	</div>
    	<div class="row">
    		<div class="col-md-12">
    			<div class="footer-copyright"><?php echo $jkv["copyright"];?></div>
    		</div>
    	</div>
    </div>
</div>
<?php } else { ?>
<!-- Footer -->
<div class="footer footer-small">
	<div class="container">
    	<div class="row">
    		<div class="col-footer col-md-10">
    			<?php echo jak_build_menu(0, $mfooter, $page, 'no-list-style footer-navigate-section', '', '', '', JAK_ASACCESS);?>
    		</div>
    		
    		<div class="col-footer col-md-2">
    			<?php echo $jkv["fcont2_jakweb_tpl"];?>
    			<?php if ($apedit) { ?>
    			<a class="btn btn-default btn-xs" title="<?php echo $tl["general"]["g"];?>" href="<?php echo $apedit;?>"><i class="fa fa-pencil"></i></a>
    			<?php if ($qapedit) { ?><a class="btn btn-default btn-xs quickedit" title="<?php echo $tl["general"]["g176"];?>" href="<?php echo $qapedit;?>"><i class="fa fa-edit"></i></a>
    			<?php } } if ($jkv["printme"] && isset($printme)) { ?>
    			<a class="btn btn-default btn-xs" id="jakprint" href="#"><i class="fa fa-print"></i></a>
    			<?php } if (isset($JAK_RSS_DISPLAY)) { ?>
    			<a class="btn btn-default btn-xs" href="<?php echo $P_RSS_LINK;?>"><i class="fa fa-rss"></i></a>
    			<?php } if ($jkv["heatmap"] && JAK_ASACCESS) { ?>
    			<a class="btn btn-default" href="javascript:void(0)" id="dispheatmap"><i class="fa fa-bar-chart"></i></a>
    			<?php } ?>
    		</div>
    	</div>
    	<div class="row">
    		<div class="col-md-12">
    			<div class="footer-copyright"><?php echo $jkv["copyright"];?></div>
    		</div>
    	</div>
    </div>
</div>
<?php } } } if (!$JAK_SHOW_FOOTER) { ?>
<div class="hidden-footer-manage">
<?php if ($apedit) { ?>
<a class="btn btn-default btn-xs" title="<?php echo $tl["general"]["g"];?>" href="<?php echo $apedit;?>"><i class="fa fa-pencil"></i></a>
<?php if ($qapedit) { ?><a class="btn btn-default btn-xs quickedit" title="<?php echo $tl["general"]["g176"];?>" href="<?php echo $qapedit;?>"><i class="fa fa-edit"></i></a>
<?php } } ?>
</div>
<?php } if ($JAK_SHOW_NAVBAR) { ?>

</div><!-- sb-site -->

<div class="sb-slidebar sb-left">
<?php include_once APP_PATH.'template/jakweb/navbar_mobile.php';?>
</div>

<!-- Scroll to top -->
<a id="toTop" href="<?php echo $tl["link"]["l13"];?>"><?php echo $tl["title"]["t4"];?></a>

<!-- Style Manager -->
<?php } if (JAK_ASACCESS && $jkv["styleswitcher_tpl"]) include_once APP_PATH.'template/jakweb/styleswitcher.php';?>

<!-- Custom JS igrid -->
<script type="text/javascript" src="<?php echo BASE_URL;?>template/jakweb/js/jakweb.js?=<?php echo $jkv["updatetime"];?>"></script>

<?php if ($jkv["printme"]) { ?>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/jakprint.js?=<?php echo $jkv["updatetime"];?>"></script>

<script type="text/javascript">
$(document).ready(function() {
	
	$("#jakprint").click(function(e) {
		e.preventDefault();
		$('div#printdiv').printElement();
	});
	
});
</script>
<?php } ?>

<script type="text/javascript">
	jakWeb.jak_lang = "<?php echo $site_language;?>";
	jakWeb.jak_url = "<?php echo BASE_URL;?>";
	jakWeb.jak_url_orig = "<?php echo BASE_URL;?>";
	jakWeb.jak_search_link = "<?php echo $JAK_SEARCH_LINK;?>";
	jakWeb.jakrequest_uri = "<?php echo JAK_PARSE_REQUEST;?>";
	jakWeb.jak_quickedit = "<?php echo $tl["general"]["g176"];?>";
	
	<?php if (isset($_SESSION["infomsg"])) { ?>
	$.notify({icon: 'fa fa-info-circle', message: '<?php echo $_SESSION["infomsg"];?>'}, {type: 'info'});
	<?php } if (isset($_SESSION["successmsg"])) { ?>
	$.notify({icon: 'fa fa-check-square-o', message: '<?php echo $_SESSION["successmsg"];?>'}, {type: 'success'});
	<?php } if (isset($_SESSION["errormsg"])) { ?>
	$.notify({icon: 'fa fa-exclamation-triangle', message: '<?php echo $_SESSION["errormsg"];?>'}, {type: 'danger'});
	<?php } ?>
	
	<?php if (isset($SHOWVOTE) && isset($PLUGIN_LIKE_ID)) { ?>
	$(document).ready(function() {
		getLikeCounter(<?php echo $PAGE_ID;?>, <?php echo $PLUGIN_LIKE_ID;?>);	
	});
	<?php } ?>
	
</script>

<?php if ($jkv["heatmap"] && JAK_ASACCESS) { ?>

	<script src="<?php echo BASE_URL;?>js/heatmap.js" type="text/javascript"></script>

	<script type="text/javascript">
	
		jakWeb.jak_heatmap = "<?php echo $JAK_HEATMAPLOC;?>";
	
			$(document).saveClicks(); 
		
		    $('#dispheatmap').click(function() {
		        $.displayClicks();
		        $('#heatmap-overlay').click(function() {
		             $.removeClicks();
		             $(document).saveClicks();
		        });
		        $(document).stopSaveClicks();
		        return false;
		    });
	
	</script>

<?php } if (isset($JAK_HOOK_FOOTER_END) && is_array($JAK_HOOK_FOOTER_END)) foreach($JAK_HOOK_FOOTER_END as $hfootere) { include_once APP_PATH.$hfootere['phpcode']; } echo $jkv["analytics"]; if (isset($JAK_FOOTER_JAVASCRIPT)) echo $JAK_FOOTER_JAVASCRIPT;?>

<?php if (JAK_ASACCESS && $jkv["styleswitcher_tpl"]) { ?>
<script type="text/javascript" src="<?php echo BASE_URL;?>template/jakweb/js/stylechanger.js?=<?php echo $jkv["updatetime"];?>"></script>
<?php } ?>

<!-- Modal -->
<div class="modal fade" id="JAKModal" tabindex="-1" role="dialog" aria-labelledby="JAKModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="JAKModalLabel">&nbsp;</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $tl["general"]["g177"];?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</body>
</html>