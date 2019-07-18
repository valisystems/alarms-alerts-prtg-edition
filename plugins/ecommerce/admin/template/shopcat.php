<?php include_once APP_PATH.'admin/template/header.php';?>

<?php if ($page2 == "s") { ?>
<div class="alert alert-success fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?php echo $tl["general"]["g7"];?>
</div>
<?php } if ($page2 == "e" || $page2 == "epc" || $page2 == "ech" || $page2 == "ene") { ?>
<div class="alert alert-danger fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?php if ($page2 == "e") { $tl["errorpage"]["sql"]; } elseif ($page2 == "epc") { echo $tl["errorpage"]["pluginc"]; } elseif ($page2 == "ene") { echo $tl["errorpage"]["not"]; } else { echo $tl["errorpage"]["cat"]; } ?>
</div>
<?php } ?>

<div class="box box-default">
  <div class="box-header with-border">
  <i class="fa fa-bars"></i>
    <h3 class="box-title"><?php echo $tl["menu"]["m5"];?></h3>
  </div><!-- /.box-header -->
	<div class="box-body">
	
	<?php echo jak_build_menu_shop(0, $mheader, $tl["cat"]["al"], ' class="sortable jak_cat_move"', ' id="mheader"');?>
	
	</div>
	<div class="box-footer">
		<button type="submit" data-menu="mheader" name="save" class="btn btn-primary pull-right save-menu-plugin"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>

<div class="icon_legend">
<h3><?php echo $tl["icons"]["i"];?></h3>
<i title="<?php echo $tl["icons"]["i7"];?>" class="fa fa-folder-plus"></i>
<i title="<?php echo $tl["icons"]["i6"];?>" class="fa fa-check"></i>
<i title="<?php echo $tl["icons"]["i5"];?>" class="fa fa-lock"></i>
<i title="<?php echo $tlec["shop"]["m76"];?>" class="fa fa-sticky-note-o"></i>
<i title="<?php echo $tl["icons"]["i2"];?>" class="fa fa-edit"></i>
<i title="<?php echo $tl["icons"]["i1"];?>" class="fa fa-trash-o"></i>
</div>

<script src="js/catorder.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function() {
	$(".sortable").nestedSortable({maxLevels: 2});
	
	$(".save-menu-plugin").on("click", function() {
		mlist = $(this).data("menu");
		serialized = $("#"+mlist).nestedSortable("serialize");
		
		/* Sending the form fileds to any post request: */
		var request = $.ajax({
		  url: "index.php?p=shop&amp;sp=categories",
		  type: "POST",
		  data: serialized,
		  dataType: "json",
		  cache: false
		});
		request.done(function(data) {
			if (data.status == 1) {
				$("#"+mlist+" li").animate({backgroundColor: '#c9ffc9'}, 100).animate({backgroundColor: '#F9F9F9'}, 1000);
				$.notify({icon: 'fa fa-check-square-o', message: data.html}, {type: 'success'});
			} else {
				$("#"+mlist+" li").animate({backgroundColor: '#ffc9c9'}, 100).animate({backgroundColor: '#F9F9F9'}, 1000);
				$.notify({icon: 'fa fa-exclamation-triangle', message: data.html}, {type: 'danger'});
			}
		});
	});
	
});
</script>
		
<?php include_once APP_PATH.'admin/template/footer.php';?>