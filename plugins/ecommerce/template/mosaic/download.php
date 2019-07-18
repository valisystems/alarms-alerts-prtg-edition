<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/header.php';?>

<div class="row">
	<div class="col-md-12">
		<div class="alert alert-info"><?php echo $tlec["shop"]["m58"];?></div>
		<form role="form" id="download_form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
			<input type="submit" name="download" class="btn btn-success" value="<?php echo $tlec["shop"]["m59"];?>" />
		</form>
	</div>
</div>

<?php if ($countdown) { ?>

<script type="text/javascript">

	$(function(){
	  var count = 3;
	  
	  countdown = setInterval(function(){
	    
	    if (count == 0) {
	     	$('#download_form').submit();
	    }
	    
	    count--;
	  }, 1000);
	  
	});

</script>

<?php } include_once APP_PATH.'template/'.$jkv["sitestyle"].'/footer.php';?>