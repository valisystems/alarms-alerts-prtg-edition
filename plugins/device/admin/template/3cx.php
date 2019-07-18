<?php include_once APP_PATH.'admin/template/header.php';?>

	<script type="text/javascript" language="javascript" src="../plugins/device/js/3cx_url.js"></script>
	<form class="form-horizontal">
		<fieldset>
		<!-- Form Name -->
		<legend>3cx Urls</legend>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="from">Address</label>  
		  <div class="col-md-4">
			<input id="address" name="address" type="text" placeholder="https://localhost:5001" class="form-control input-md" required="">
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="from">Call From</label>  
		  <div class="col-md-4">
		  <input id="from" name="from" type="text" placeholder="200" class="form-control input-md" required="">
			<span class="help-block">This extension will be used for setting button too.</span>  
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="pin">Extension Password</label>  
		  <div class="col-md-4">
		  <input id="pin" name="pin" type="text" placeholder="123456789" class="form-control input-md" required="">
			
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="to">Call To</label>  
		  <div class="col-md-4">
		  <input id="to" name="to" type="text" placeholder="800" class="form-control input-md" required="">
			
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="pbxpass">3cx Admin password</label>  
		  <div class="col-md-4">
		  <input id="pbxpass" name="pbxpass" type="text" placeholder="e.g admin" class="form-control input-md">
		  <span class="help-block">Pbx admin password</span>  
		  </div>
		</div>

		<!-- Button (Double) -->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="button1id">Extension Settings</label>
		  <div class="col-md-8">
			<button name="button1id" data-type2="enable_external_calls" data-type="upd_ext" class="btn btn-success url_button">Enable External Calls</button>
			<button name="button2id" data-type2="disable_external_calls" data-type="upd_ext" class="btn btn-danger url_button">Disable External Calls</button>
		  </div>
		</div>

		<!-- Button (Double) -->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="button1id">Extension Settings</label>
		  <div class="col-md-8">
			<button name="button1id" data-type2="enable_extension" data-type="upd_ext" class="btn btn-success url_button">Enable Extension</button>
			<button name="button2id" data-type2="disable_extension" data-type="upd_ext" class="btn btn-danger url_button">Disable Extension</button>
		  </div>
		</div>

		<!-- Button (Double) -->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="button1id">Extension Settings</label>
		  <div class="col-md-8">
			<button name="button1id" data-type2="enable_recording" data-type="upd_ext" class="btn btn-success url_button">Enable Recordings</button>
			<button name="button2id" data-type2="disable_recording" data-type="upd_ext" class="btn btn-danger url_button">Disable Recordings</button>
		  </div>
		</div>

		<!-- Button -->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="singlebutton">Generate Call</label>
		  <div class="col-md-4">
			<button name="call_url" data-type="make_call" class="btn btn-primary url_button">Call Url</button>
		  </div>
		</div>

		</fieldset>
		</form>

	
<?php include_once APP_PATH.'admin/template/footer.php';?>

