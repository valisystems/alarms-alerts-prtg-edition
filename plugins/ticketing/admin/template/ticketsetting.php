<?php include_once APP_PATH.'admin/template/header.php';?>

<?php if ($page2 == "s") { ?>
<div class="alert alert-success fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?php echo $tl["general"]["g7"];?>
</div>
<?php } if ($page2 == "e") { ?>
<div class="alert alert-danger fade in">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?php echo $tl["errorpage"]["sql"];?>
</div>
<?php } ?>

<?php if ($errors) { ?>
<div class="alert alert-danger fade in">
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

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">

<ul class="nav nav-tabs" id="cmsTab">
	<li class="active"><a href="#ticketSett1"><?php echo $tl["menu"]["m2"];?></a></li>
	<li><a href="#ticketSett2"><?php echo $tl["general"]["g89"];?></a></li>
</ul>

<div class="tab-content">
<div class="tab-pane active" id="ticketSett1">

<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tl["title"]["t4"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
  
<table class="table table-striped">
<tr>
	<td><?php echo $tlt["st"]["d7"];?></td>
	<td>
	<?php include_once APP_PATH."admin/template/title_edit.php";?>
	</td>
</tr>
<tr>
	<td><?php echo $tl["user"]["u6"];?></td>
	<td>
	<?php include_once APP_PATH."admin/template/editorlight_edit.php";?>
	</td>
</tr>
<tr>
	<td><?php echo $tlt["st"]["d15"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e2"])) echo " has-error";?>">
		<input type="text" name="jak_email" class="form-control" value="<?php echo $jkv["ticketemail"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tlt["st"]["d12"];?></td>
	<td>
	<div class="row">
	<div class="col-md-6">
	<select name="jak_showstordern" class="form-control">
	<option value="id"<?php if ($JAK_SETTING['showstwhat'] == "id") { ?> selected="selected"<?php } else { ?> selected="selected"<?php } ?>><?php echo $tlt["st"]["d28"];?></option>
	<option value="name"<?php if ($JAK_SETTING['showstwhat'] == "name") { ?> selected="selected"<?php } ?>><?php echo $tlt["st"]["d29"];?></option>
	<option value="time"<?php if ($JAK_SETTING['showstwhat'] == "time") { ?> selected="selected"<?php } ?>><?php echo $tlt["st"]["d30"];?></option>
	<option value="hits"<?php if ($JAK_SETTING['showstwhat'] == "hits") { ?> selected="selected"<?php } ?>><?php echo $tlt["st"]["d31"];?></option>
	</select>
	</div>
	<div class="col-md-6">
	<select name="jak_showstorder" class="form-control">
	<option value="ASC"<?php if ($JAK_SETTING['showstorder'] == "ASC") { ?> selected="selected"<?php } else { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g90"];?></option>
	<option value="DESC"<?php if ($JAK_SETTING['showstorder'] == "DESC") { ?> selected="selected"<?php } ?>><?php echo $tl["general"]["g91"];?></option>
	</select>
	</div>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tlt["st"]["d42"];?></td>
	<td><input type="text" name="jak_maxpost" class="form-control" value="<?php echo $jkv["ticketmaxpost"];?>" /></td>
</tr>
<tr>
	<td><?php echo $tl["setting"]["s4"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e3"])) echo " has-error";?>">
		<input type="text" name="jak_date" class="form-control" value="<?php echo $jkv["ticketdateformat"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["setting"]["s5"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e4"])) echo " has-error";?>">
		<input type="text" name="jak_time" class="form-control" value="<?php echo $jkv["tickettimeformat"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tlt["st"]["d32"];?></td>
	<td>
	<div class="radio"><label>
		<input type="radio" name="jak_ticketurl" value="0"<?php if ($jkv["ticketurl"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
	</label></div>
	<div class="radio"><label>
		<input type="radio" name="jak_ticketurl" value="1"<?php if ($jkv["ticketurl"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?>
	</label></div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["setting"]["s7"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e6"])) echo " has-error";?>">
		<input type="text" class="form-control" name="jak_path" value="<?php echo $jkv["ticketpath"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["general"]["g40"];?> / <?php echo $tl["general"]["g41"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e7"])) echo " has-error";?>">
		<input type="text" class="form-control" name="jak_rssitem" value="<?php echo $jkv["ticketrss"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["general"]["g85"];?></td>
	<td>
	<div class="radio"><label>
	<input type="radio" name="jak_vote" value="1"<?php if ($jkv["ticketgvote"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label>
	<input type="radio" name="jak_vote" value="0"<?php if ($jkv["ticketgvote"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
	</label></div></td>
</tr>
<tr>
	<td><?php echo $tl["page"]["p9"];?></td>
	<td>
	<div class="radio"><label>
	<input type="radio" name="jak_social" value="1"<?php if ($jkv["ticketgsocial"] == 1) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label>
	<input type="radio" name="jak_social" value="0"<?php if ($jkv["ticketgsocial"] == 0) { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?>
	</label></div></td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
	<div class="box box-primary">
	  <div class="box-header with-border">
	    <h3 class="box-title"><?php echo $tl["title"]["t47"];?></h3>
	  </div><!-- /.box-header -->
	  <div class="box-body">
<table class="table table-striped">
<tr>
	<td><input type="text" class="form-control" name="jak_shortmsg" value="<?php echo $jkv["ticketshortmsg"];?>" /></td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
	<div class="box box-primary">
	  <div class="box-header with-border">
	    <h3 class="box-title"><?php echo $tl["title"]["t29"];?></h3>
	  </div><!-- /.box-header -->
	  <div class="box-body">
<table class="table table-striped">
<thead>
<tr>
<th colspan="2"><?php echo $tl["title"]["t29"];?></th>
</tr>
</thead>
<tr>
	<td><?php echo $tl["setting"]["s11"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e5"])) echo " has-error";?>">
		<input type="text" name="jak_mid" class="form-control" value="<?php echo $jkv["ticketpagemid"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $tl["setting"]["s12"];?></td>
	<td>
	<div class="form-group<?php if (isset($errors["e5"])) echo " has-error";?>">
		<input type="text" name="jak_item" class="form-control" value="<?php echo $jkv["ticketpageitem"];?>" />
	</div>
	</td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
</div>
<div class="tab-pane" id="ticketSett2">
	<div class="box box-primary">
<div class="box-header with-border">
  <h3 class="box-title"><?php echo $tl["general"]["g89"];?></h3>
</div><!-- /.box-header -->
<div class="box-body">
	<?php include APP_PATH."admin/template/sidebar_widget.php";?>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>
</div>

</div>
</form>

<script type="text/javascript">
		$(document).ready(function()
		{	
			$('#cmsTab a').click(function (e) {
			  e.preventDefault();
			  $(this).tab('show');
			});
		});
</script>
		
<?php include_once APP_PATH.'admin/template/footer.php';?>