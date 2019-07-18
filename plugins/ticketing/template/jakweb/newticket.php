<?php include_once APP_PATH.'template/'.$jkv["sitestyle"].'/header.php';?>
		
<?php if (JAK_ASACCESS) $apedit = BASE_URL.'admin/index.php?p=ticketing&amp;sp=setting';?>

<div class="jak-post jak-single-post">
<?php if ($errors) { ?>
<div class="alert alert-danger">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<?php if (isset($errors["e"])) echo $errors["e"];
  if (isset($errors["e1"])) echo $errors["e1"];
  if (isset($errors["e2"])) echo $errors["e2"];
  if (isset($errors["e3"])) echo $errors["e3"];
  if (isset($errors["e4"])) echo $errors["e4"];
  if (isset($errors["e5"])) echo $errors["e5"];
  if (isset($errors["e6"])) echo $errors["e6"];?>
</div>
<?php } ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data">
<?php if (!JAK_USERID) { ?>
<div class="form-group<?php if (isset($errors["e1"])) echo " has-error";?>">
	<label class="control-label" for="jak_name"><?php echo $tlt["st"]["t24"];?></label>
	<input type="text" name="jak_name" id="jak_name" class="form-control" value="<?php if (isset($_REQUEST["jak_name"])) echo $_REQUEST["jak_name"];?>" placeholder="<?php echo $tl["contact"]["c1"];?>" />
</div>
<div class="form-group<?php if (isset($errors["e4"])) echo " has-error";?>">
	<input class="control-label" type="text" name="jak_email" class="form-control" value="<?php if (isset($_REQUEST["jak_email"])) echo $_REQUEST["jak_email"];?>" placeholder="<?php echo $tl["contact"]["c2"];?>" />
</div>
<?php } ?>
<div class="form-group<?php if (isset($errors["e"])) echo " has-error";?>">
	<label class="control-label" for="jak_title"><?php echo $tlt["st"]["t3"];?></label>
	<input type="text" name="jak_title" id="jak_title" class="form-control" value="<?php if (isset($_REQUEST["jak_title"])) echo $_REQUEST["jak_title"];?>" />
</div>
<div class="row">
	<div class="col-md-4">
		<div class="form-group<?php if (isset($errors["e2"])) echo " has-error";?>">
			<label class="control-label" for="jak_type"><?php echo $tlt["st"]["t5"];?></label>
			<select name="jak_type" id="jak_type" class="form-control">
			<option value="0"<?php if (!isset($_REQUEST["jak_type"])) { ?> selected="selected"<?php } ?>><?php echo $tlt["st"]["t19"];?></option>
			<?php if (isset($JAK_ST_OPT) && is_array($JAK_ST_OPT)) foreach($JAK_ST_OPT as $sto) { ?>
			<option value="<?php echo $sto["id"];?>"<?php if (isset($_REQUEST["jak_type"]) && $_REQUEST["jak_type"] == $sto["id"]) { ?> selected="selected"<?php } ?>> <?php echo $sto["name"];?></option>
			<?php } ?>
			</select>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group<?php if (isset($errors["e6"])) echo " has-error";?>">
			<label class="control-label" for="jak_catid"><?php echo $tlt["st"]["t35"];?></label>
			<select name="jak_catid" id="jak_catid" class="form-control">
			<option value="0"<?php if (!isset($_REQUEST["jak_catid"])) { ?> selected="selected"<?php } ?>><?php echo $tlt["st"]["t19"];?></option>
			<?php if (isset($JAK_TICKET_CAT) && is_array($JAK_TICKET_CAT)) foreach($JAK_TICKET_CAT as $tc) { ?>
			<option value="<?php echo $tc["id"];?>"<?php if (isset($_REQUEST["jak_catid"]) && $tc["id"] == $_REQUEST["jak_catid"]) { ?> selected="selected"<?php } ?>><?php echo $tc["name"];?></option>
			<?php } ?>
			</select>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
		    <label class="control-label" for="jak_private"><?php echo $tlt["st"]["t21"];?></label>
		    <select name="jak_private" id="jak_private" class="form-control">
		    <option value="0"<?php if (isset($_REQUEST["jak_private"]) && $_REQUEST["jak_private"] == '0') { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g98"];?></option>
		    <option value="1"<?php if (isset($_REQUEST["jak_private"]) && $_REQUEST["jak_private"] == '1') { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g97"];?></option>
		    </select>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-4">
		<div class="form-group">
		    <label class="control-label" for="jak_status"><?php echo $tlt["st"]["t28"];?></label>
		    <select name="jak_status" id="jak_status" class="form-control">
		    <option value="0"<?php if (isset($_REQUEST["jak_status"]) && $_REQUEST["jak_status"] == '0') { ?> selected="selected"<?php } ?>><?php echo $tlt["st"]["t7"];?></option>
		    <option value="1"<?php if (isset($_REQUEST["jak_status"]) && $_REQUEST["jak_status"] == '1') { ?> selected="selected"<?php } ?>><?php echo $tlt["st"]["t8"];?></option>
		    </select>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
		    <label class="control-label" for="jak_priority"><?php echo $tlt["st"]["t31"];?></label>
		    <select name="jak_priority" id="jak_priority" class="form-control">
		    <option value="1"<?php if (isset($_REQUEST["jak_priority"]) && $_REQUEST["jak_priority"] == '1') { ?> selected="selected"<?php } ?>>1 (<?php echo $tlt["st"]["t29"];?>)</option>
		    <option value="2"<?php if (isset($_REQUEST["jak_priority"]) && $_REQUEST["jak_priority"] == '2') { ?> selected="selected"<?php } ?>>2</option>
		    <option value="3"<?php if (isset($_REQUEST["jak_priority"]) && $_REQUEST["jak_priority"] == '3') { ?> selected="selected"<?php } ?>>3</option>
		    <option value="4"<?php if (isset($_REQUEST["jak_priority"]) && $_REQUEST["jak_priority"] == '4') { ?> selected="selected"<?php } ?>>4</option>
		    <option value="5"<?php if (isset($_REQUEST["jak_priority"]) && $_REQUEST["jak_priority"] == '5') { ?> selected="selected"<?php } ?>>5 (<?php echo $tlt["st"]["t30"];?>)</option>
		    </select>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
		    <label class="control-label" for="jak_resolution"><?php echo $tlt["st"]["t32"];?></label>
		    <select name="jak_resolution" id="jak_resolution" class="form-control">
		    <option value="0"<?php if (isset($_REQUEST["jak_resolution"]) && $_REQUEST["jak_resolution"] == '0') { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g98"];?></option>
		    <option value="1"<?php if (isset($_REQUEST["jak_resolution"]) && $_REQUEST["jak_resolution"] == '1') { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g97"];?></option>
		    </select>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<?php if (JAK_USER_TAGS) { ?>
		<div class="form-group">
			<label class="control-label" for="jak_tags"><?php echo $tlt["st"]["t33"];?></label>
			<input type="text" name="jak_tags" id="jak_tags" class="form-control" value="<?php if (isset($_REQUEST["jak_tags"])) echo $_REQUEST["jak_tags"];?>" />
		</div>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#jak_tags').tagsInput({
				   defaultText:'<?php echo $tlt["st"]["t6"];?>',
				   taglimit: 5,
				   placeholderColor:'#000'
				});
				$('#jak_tags_tag').alphanumeric({nocaps:true});
			});
		</script>
		<?php } ?>
	</div>
	<div class="col-md-6">
		<?php if ($jkv["ticketpath"]) { ?>
		<div class="form-group">
		    <label class="control-label" for="jak_uploadpticket"><?php echo $tlt["st"]["t20"];?></label>
			<input type="file" name="jak_uploadpticket" id="jak_uploadpticket" accept="image/*" />
		</div>
		<?php } ?>
	</div>
</div>
<div class="form-group<?php if (isset($errors["e5"])) echo " has-error";?>">
<label class="control-label" for="userpost"><?php echo $tlt["st"]["t16"];?></label>
<textarea name="userpost" class="form-control userpost" id="userpost" rows="10"><?php if (isset($_REQUEST["userpost"])) echo jak_edit_safe_userpost($_REQUEST["userpost"]); ?></textarea>
</div>
<?php if (JAK_USERID) { ?>
<input type="hidden" name="jak_name" value="<?php echo $JAK_USERNAME;?>" />
<?php } ?>
<button type="submit" name="subticket" class="btn btn-primary btn-block"><?php echo $tl["general"]["g10"];?></button>
</form>
</div>

<script type="text/javascript">
	jakWeb.jak_lang = "<?php echo $site_language;?>";
</script>

<script type="text/javascript" src="<?php echo BASE_URL;?>js/editor/tinymce.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/usreditor.js"></script>

<?php if ($jkv["hvm"]) { ?>
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery(".cFrom").append('<input type="hidden" name="<?php echo $random_name;?>" value="<?php echo $random_value;?>" />');
	});
</script>

<?php } include_once APP_PATH.'template/'.$jkv["sitestyle"].'/footer.php';?>