<?php include "header.php";?>

<?php if ($page1 == "s") { ?>
<div class="alert alert-success fade in">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <?php echo $tl["general"]["g7"];?>
</div>
<?php } if ($page1 == "e") { ?>
<div class="alert alert-danger fade in">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <?php echo $tl["errorpage"]["sql"];?>
</div>
<?php } ?>

<?php if (isset($JAK_SEARCHLOG_ALL) && is_array($JAK_SEARCHLOG_ALL)) { ?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<div class="box">
<div class="box-body no-padding">
<div class="table-responsive">
<table class="table table-striped table-hover">
<thead>
<tr>
<th>#</th>
<th><input type="checkbox" id="jak_delete_all" /></th>
<th><?php echo $tl["general"]["g46"];?></th>
<th><?php echo $tl["page"]["p2"];?></th>
<th><?php echo $tl["general"]["g56"];?></th>
<th><a href="index.php?p=searchlog&amp;sp=truncate&amp;ssp=go" class="btn btn-warning btn-xs" onclick="if(!confirm('<?php echo $tl["error"]["e34"];?>'))return false;"><i class="fa fa-exclamation-triangle"></i></a></th>
<th><button type="submit" name="delete" id="button_delete" class="btn btn-danger btn-xs" onclick="if(!confirm('<?php echo $tl["error"]["e33"];?>'))return false;"><i class="fa fa-trash-o"></i></button></th>
</tr>
</thead>
<?php foreach($JAK_SEARCHLOG_ALL as $v) { ?>
<tr>
<td><?php echo $v["id"];?></td>
<td><input type="checkbox" name="jak_delete_search[]" class="highlight" value="<?php echo $v["id"];?>" /></td>
<td><?php echo $v["tag"];?></td>
<td><?php echo $v["time"]; ?></td>
<td><?php echo $v["count"];?></td>
<td></td>
<td><a href="index.php?p=searchlog&amp;sp=delete&amp;ssp=<?php echo $v["id"];?>" class="btn btn-default btn-xs" onclick="if(!confirm('<?php echo $tl["error"]["e33"];?>'))return false;"><i class="fa fa-trash-o"></i></a></td>
</tr>
<?php } ?>
</table>
</div>
</div>
</div>
</form>

<?php } else { ?>

<div class="alert alert-info">
 	<?php echo $tl["errorpage"]["data"];?>
</div>

<?php } ?>

<div class="icon_legend">
<h3><?php echo $tl["icons"]["i"];?></h3>
<i title="<?php echo $tl["icons"]["i15"];?>" class="fa fa-exclamation-triangle"></i>
<i title="<?php echo $tl["icons"]["i1"];?>" class="fa fa-trash-o"></i>
</div>

<?php if ($JAK_PAGINATE) { echo $JAK_PAGINATE; } ?>	

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