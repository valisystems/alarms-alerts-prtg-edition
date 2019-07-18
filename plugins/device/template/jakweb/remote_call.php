<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/header.php';?>

<div class="row">
	<div class="col-md-6">
		<form id="remote-call" method="POST" >
			<div class="form-group">
				<label>PBX URL</label>
				<input type="text" name="pbx_url" placeholder="http://173.231.102.81" required class="form-control"/>
			</div>
			
			<div class="form-group">
				<label>Extension</label>
				<input type="text" name="user" placeholder="100@localhost" required class="form-control" />
			</div>
			
			<div class="form-group">
				<label>Extension Password</label>
				<input type="password" name="password" placeholder="password" required class="form-control" />
			</div>
			
			<div class="form-group">
				<label>Destination</label>
				<input type="text" name="dest"  required class="form-control" />
			</div>
			
			<input type="submit" name="submit" class="btn btn-default" />
		</form>
	</div>
	
</div>
<!--
<a href=":8080/test/url">testurl</a>

<script type="text/javascript">
	// delegate event for performance, and save attaching a million events to each anchor
	document.addEventListener('click', function(event) {
	  var target = event.target;
	  if (target.tagName.toLowerCase() == 'a')
	  {
	      var port = target.getAttribute('href').match(/^:(\d+)(.*)/);
	      if (port)
	      {
	         target.href = port[2];
	         target.port = port[1];
	      }
	  }
	}, false);
</script>
-->
<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/footer.php';?>
