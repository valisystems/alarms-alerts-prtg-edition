<?php include "header.php";?>

<?php if ($errors) { ?>
<div class="alert alert-danger fade in">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<?php if (isset($errors["e"])) echo $errors["e"];
		  if (isset($errors["e1"])) echo $errors["e1"];
		  if (isset($errors["e2"])) echo $errors["e2"];?>
</div>
<?php } ?>

<div class="row">
  <div class="col-md-6">

<form role="form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">

<div class="input-group">
	<span class="input-group-btn">
    	<button class="btn btn-info" name="search" type="submit"><?php echo $tl["title"]["t30"];?></button>
    </span>
    <input type="text" name="jakSH" class="form-control">
</div><!-- /input-group -->

</form>

</div>
<div class="col-md-6">

<div class="input-group">
	<select name="jak_group" class="form-control">
<?php if (isset($JAK_USERGROUP_ALL) && is_array($JAK_USERGROUP_ALL)) foreach($JAK_USERGROUP_ALL as $z) { if ($z["id"] != 1) { ?><option value="<?php echo $z["id"];?>"><?php echo $z["name"];?></option><?php } } ?>
	</select>
	<span class="input-group-btn">
		<button type="submit" name="move" class="btn btn-warning"><?php echo $tl["general"]["g35"];?></button>
	</span>
</div>

</div>
</div>

<hr>

<?php if ($JAK_SEARCH || $JAK_LIST_USER) { ?>

<div class="box">
<div class="box-body no-padding">
<div class="table-responsive">
<table class="table table-striped">
<thead>
<tr>
<th>#</th>
<th><input type="checkbox" id="jak_delete_all" /></th>
<th><?php echo $tl["user"]["u"];?></th>
<th><?php echo $tl["user"]["u1"];?></th>
<th><?php echo $tl["user"]["u2"];?></th>
<th><?php echo $tl["menu"]["m9"];?></th>
<th><button type="submit" name="lock" id="button_lock" class="btn btn-default btn-xs"><i class="fa fa-lock"></i></button></th>
<th><button type="submit" name="password" id="button_key" class="btn btn-default btn-xs" onclick="if(!confirm('<?php echo $tl["user"]["pass"];?>'))return false;"><i class="fa fa-key"></i></button></th>
<th></th>
<th><button type="submit" name="delete" id="button_delete" class="btn btn-danger btn-xs" onclick="if(!confirm('<?php echo $tl["user"]["al"];?>'))return false;"><i class="fa fa-trash-o"></i></button></th>
</tr>
</thead>
<?php if ($JAK_SEARCH) { ?>
<?php if (isset($JAK_SEARCH) && is_array($JAK_SEARCH)) foreach($JAK_SEARCH as $v) { ?>
<tr>
<td><?php echo $v["id"];?></td>
<td><input type="checkbox" name="jak_delete_user[]" class="highlight" value="<?php echo $v["id"];?>" /></td>
<td><a href="index.php?p=user&amp;sp=edit&amp;ssp=<?php echo $v["id"];?>"><?php echo $v["name"];?></a></td>
<td><?php echo $v["email"];?></td>
<td><?php echo $v["username"];?></td>
<td><?php if (isset($JAK_USERGROUP_ALL) && is_array($JAK_USERGROUP_ALL)) foreach($JAK_USERGROUP_ALL as $y) { if ($v["usergroupid"] == $y["id"]) { ?><a href="index.php?p=usergroup&amp;sp=user&amp;ssp=<?php echo $y["id"];?>"><?php echo $y["name"];?></a><?php } } ?></td>
<td><a class="btn btn-default btn-xs" href="index.php?p=user&amp;sp=lock&amp;ssp=<?php echo $v["id"];?>"><i class="fa fa-<?php if ($v["access"] == '1') { ?>check<?php } else { ?>lock<?php } ?>"></i></a></td>
<td><a class="btn btn-default btn-xs" href="index.php?p=user&amp;sp=password&amp;ssp=<?php echo $v["id"];?>" onclick="if(!confirm('<?php echo $tl["user"]["pass"];?>'))return false;"><i class="fa fa-key"></i></a></td>
<td><a class="btn btn-default btn-xs" href="index.php?p=user&amp;sp=edit&amp;ssp=<?php echo $v["id"];?>"><i class="fa fa-edit"></i></a></td>
<td><a class="btn btn-default btn-xs" href="index.php?p=user&amp;sp=delete&amp;ssp=<?php echo $v["id"];?>" onclick="if(!confirm('<?php echo $tl["user"]["al"];?>'))return false;"><i class="fa fa-trash-o"></i></a></td>
</tr>
<?php } } ?>
<?php if ($JAK_LIST_USER) { ?>
<?php if (isset($JAK_LIST_USER) && is_array($JAK_LIST_USER)) foreach($JAK_LIST_USER as $v) { ?>
<tr>
<td><?php echo $v["id"];?></td>
<td><input type="checkbox" name="jak_delete_user[]" class="highlight" value="<?php echo $v["id"];?>" /></td>
<td><a href="index.php?p=user&amp;sp=edit&amp;ssp=<?php echo $v["id"];?>"><?php echo $v["name"];?></a></td>
<td><?php echo $v["email"];?></td>
<td><?php echo $v["username"];?></td>
<td><?php if (isset($JAK_USERGROUP_ALL) && is_array($JAK_USERGROUP_ALL)) foreach($JAK_USERGROUP_ALL as $y) { if ($v["usergroupid"] == $y["id"]) { ?><a href="index.php?p=usergroup&amp;sp=user&amp;ssp=<?php echo $y["id"];?>"><?php echo $y["name"];?></a><?php } } ?></td>
<td><a class="btn btn-default btn-xs" href="index.php?p=user&amp;sp=lock&amp;ssp=<?php echo $v["id"];?>"><i class="fa fa-<?php if ($v["access"] == '1') { ?>check<?php } else { ?>lock<?php } ?>"></i></a></td>
<td><a class="btn btn-default btn-xs" href="index.php?p=user&amp;sp=password&amp;ssp=<?php echo $v["id"];?>" onclick="if(!confirm('<?php echo $tl["user"]["pass"];?>'))return false;"><i class="fa fa-key"></i></a></td>
<td><a class="btn btn-default btn-xs" href="index.php?p=user&amp;sp=edit&amp;ssp=<?php echo $v["id"];?>"><i class="fa fa-edit"></i></a></td>
<td><a class="btn btn-default btn-xs" href="index.php?p=user&amp;sp=delete&amp;ssp=<?php echo $v["id"];?>" onclick="if(!confirm('<?php echo $tl["user"]["al"];?>'))return false;"><i class="fa fa-trash-o"></i></a></td>
</tr>
<?php } } ?>
</table>
</div>
</div>
</div>
</form>

<?php } else if ($SEARCH_WORD) { ?>
<hr>
<div class="alert alert-danger fade in">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<?php echo $tl["search"]["s6"];?> <strong><?php echo $SEARCH_WORD;?></strong>
</div>
<?php } ?>


<div class="icon_legend">
<h3><?php echo $tl["icons"]["i"];?></h3>
<i title="<?php echo $tl["icons"]["i6"];?>" class="fa fa-check"></i>
<i title="<?php echo $tl["icons"]["i5"];?>" class="fa fa-lock"></i>
<i title="<?php echo $tl["icons"]["i14"];?>" class="fa fa-key"></i>
<i title="<?php echo $tl["icons"]["i2"];?>" class="fa fa-edit"></i>
<i title="<?php echo $tl["icons"]["i1"];?>" class="fa fa-trash-o"></i>
</div>

<!-- JavaScript for select all -->

<script type="text/javascript">
		$(document).ready(function()
		{
			$("#jak_delete_all").click(function() {
				var checked_status = this.checked;
				$(".highlight").each(function()
				{
					this.checked = checked_status;
				});
			});				
		});
</script>

		
<?php include "footer.php";?>