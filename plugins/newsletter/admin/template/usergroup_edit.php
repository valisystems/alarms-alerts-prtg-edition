<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $tlnl["nletter"]["d3"];?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
<table class="table table-striped">
<tr>
	<td>
	<div class="radio"><label><input type="radio" name="jak_newsletter" value="1"<?php if ($JAK_FORM_DATA["newsletter"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label></div>
	<div class="radio"><label><input type="radio" name="jak_newsletter" value="0"<?php if ($JAK_FORM_DATA["newsletter"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label></div></td>
</tr>
</table>
</div>
	<div class="box-footer">
		<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>