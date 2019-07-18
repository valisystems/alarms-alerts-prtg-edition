<?php if ($JAK_PROVED) { ?>
</section><!--Main Content -->

</div><!-- Content Wrapper -->

<footer class="main-footer">
  <div class="pull-right hidden-xs">
    <?php echo sprintf($tl["general"]["gv"], $jkv["version"]);?>
  </div>
  <strong>Copyright 2015 - <?php echo date('Y');?> by <a href="http://www.claricom.ca">Claricom</a>.</strong> All rights reserved.
</footer>

</div><!-- Wrapper -->

<?php } else { ?>
</div>
</div>
<?php } ?>

<script type="text/javascript">
	jakWeb.jak_url_orig = "<?php echo BASE_URL_ORIG;?>";
	jakWeb.jak_url = "<?php echo BASE_URL_ADMIN;?>";
	jakWeb.jak_path = "<?php echo BASE_PATH_ORIG;?>";
	jakWeb.jak_lang = "<?php echo $site_language;?>";
	jakWeb.jak_template = "<?php echo $jkv["sitestyle"];?>";
	
	<?php if (isset($_SESSION["infomsg"])) { ?>
	$.notify({icon: 'fa fa-info-circle', message: '<?php echo $_SESSION["infomsg"];?>'}, {type: 'info'});
	<?php } if (isset($_SESSION["successmsg"])) { ?>
	$.notify({icon: 'fa fa-check-square-o', message: '<?php echo $_SESSION["successmsg"];?>'}, {type: 'success'});
	<?php } if (isset($_SESSION["errormsg"])) { ?>
	$.notify({icon: 'fa fa-exclamation-triangle', message: '<?php echo $_SESSION["errormsg"];?>'}, {type: 'danger'});
	<?php } ?>

</script>

<?php if ($JAK_PROVED) { ?>
<script type="text/javascript" src="../js/editor/tinymce.min.js"></script>
<?php include_once('js/editor.php');}?>

<!-- Import all hooks for footer just before /body -->
<?php if (isset($JAK_HOOK_FOOTER_ADMIN) && is_array($JAK_HOOK_FOOTER_ADMIN)) foreach($JAK_HOOK_FOOTER_ADMIN as $foota) { include_once APP_PATH.$foota["phpcode"]; } ?>

<!-- Modal -->
<div class="modal fade" id="JAKModal" tabindex="-1" role="dialog" aria-labelledby="JAKModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="JAKModalLabel"></h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $tl["general"]["g129"];?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
	
</body>
</html>