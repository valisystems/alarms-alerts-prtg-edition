<?php include_once APP_PATH.'admin/template/header.php';?>

<?php if ($page2 == "e") { ?>
<div class="alert alert-danger fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?php echo $tl["errorpage"]["sql"];?>
</div>
<?php } ?>

<?php if ($errors) { ?>
<div class="alert alert-danger fade in">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<?php if (isset($errors["e"])) echo $errors["e"];
		  if (isset($errors["e1"])) echo $errors["e1"];?>
</div>
<?php } ?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["title"]["t13"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><?php echo $tlnl["nletter"]["d8"];?></td>
	<td><div class="form-group<?php if (isset($errors["e1"])) echo " has-error";?>">
		<input type="text" name="jak_title" class="form-control" value="<?php if (isset($_REQUEST["jak_title"])) echo $_REQUEST["jak_title"];?>" />
	</div></td>
</tr>
<tr>
	<td><?php echo $tl["page"]["p8"];?></td>
	<td><div class="radio"><label><input type="radio" name="jak_showdate" value="1"<?php if (isset($_REQUEST["jak_showdate"]) && $_REQUEST["jak_showdate"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_showdate" value="0"<?php if (isset($_REQUEST["jak_showdate"]) && $_REQUEST["jak_showdate"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
	<div class="box box-primary">
	  <div class="box-header with-border">
	    <h3 class="box-title"><?php echo $tlnl["nletter"]["d1"];?> <span id="loader"><img src="../../img/loader.gif" alt="loader" width="16" height="11" style="display: none;" /></span></h3>
	  </div><!-- /.box-header -->
	  <div class="box-body">
<table class="table table-striped">
<tr>
	<td>
	
		<div class="row">
		<?php if (isset($theme_files) && is_array($theme_files)) foreach($theme_files as $l) { ?>
		  <div class="col-sm-4 col-md-2">
		    <div class="thumbnail" style="text-align: center;">
		      <a class="nlprev" href="../plugins/newsletter/skins/<?php echo $l;?>/full_width.html"><img src="../plugins/newsletter/skins/<?php echo $l;?>/preview.jpg" alt="<?php echo $l;?>" width="100" height="100" /></a>
		      <div class="caption">
		        <img class="nlTheme" id="skins/<?php echo $l;?>/left_sidebar.html" src="../plugins/newsletter/admin/img/preview_theme_left.png" alt="left" width="29" height="31" style="border: none;margin-right: 2px;cursor: pointer;" />
		        <img class="nlTheme" id="skins/<?php echo $l;?>/full_width.html" src="../plugins/newsletter/admin/img/preview_theme_center.png" alt="center" width="29" height="31" style="border: none;margin-right: 2px;cursor: pointer;" />
		        <img class="nlTheme" id="skins/<?php echo $l;?>/right_sidebar.html" src="../plugins/newsletter/admin/img/preview_theme_right.png" alt="right" width="29" height="31" style="border: none;cursor: pointer;" />
		      </div>
		    </div>
		  </div>
		  <?php } ?>
		</div>
	
	</td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
	<div class="box box-primary">
	  <div class="box-header with-border">
	    <h3 class="box-title"><?php echo $tl["title"]["t14"];?></h3>
	  </div><!-- /.box-header -->
	  <div class="box-body">
<table class="table table-striped">
<tr>
	<td>{myweburl} {mywebname} {browserversion} {unsubscribe} {username} {fullname} {useremail}</td>
</tr>
<tr>
	<td><textarea name="jak_content" class="form-control jakEditorF" id="nlpost" rows="40"><?php if (isset($_REQUEST["jak_content"])) echo $_REQUEST["jak_content"];?></textarea></td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
</form>

<script type="text/javascript">
		$(document).ready(function() {
			
			$('.nlprev').on('click', function(e) {
				e.preventDefault();
				frameSrc = $(this).attr("href");
				$('#JAKModalLabel').html("FileManager");
				$('#JAKModal').on('show.bs.modal', function () {
				  	$('#JAKModal .modal-body').html('<iframe src="'+frameSrc+'" width="100%" height="400" frameborder="0">');
				});
				$('#JAKModal').on('hidden.bs.modal', function() {
					$('#JAKModal .modal-body').html("");
				});
				$('#JAKModal').modal({show:true});
			});
			
			$(".nlTheme").click(function() {
			
				if(!confirm('<?php echo $tlnl["nletter"]["skin"];?>')) return false;
				
				$.ajax({
				type: "POST",
				url: '../plugins/newsletter/admin/ajax/loadskin.php',
				data: "skinUrl="+$(this).attr("id"),
				dataType: 'json',
				beforeSend: function(x){$('#loader').show();},
				success: function(msg){
					
					$('#loader').hide();
					
					if(parseInt(msg.status)!=1)
					{
						return false;
					
					} else {
						
						tinymce.activeEditor.insertContent(msg.rcontent);
					}
					
				}
				});
				
			});
		});
</script>
		
<?php include_once APP_PATH.'admin/template/footer.php';?>