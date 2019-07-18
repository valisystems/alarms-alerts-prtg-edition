<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Analytic plugin Permissions</h3>
  </div><!-- /.box-header -->
  <div class="box-body">

		<table class="table table-striped">
			<tr>
				<td>View Analytic</td>
				<td><div class="radio">
					<label>
					<input type="radio" name="jak_analytic" value="1"<?php if ($JAK_FORM_DATA["analytic"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label>
					</div>
					<div class="radio">
					<label><input type="radio" name="jak_analytic" value="0"<?php if ($JAK_FORM_DATA["analytic"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label>
					</div>
				</td>
			</tr>
			<tr>
				<td>Change Analytic</td>
				<td>
					<div class="radio">
					<label>
					<input type="radio" name="jak_analyticpost" value="1"<?php if ($JAK_FORM_DATA["analyticpost"] == '1') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g18"];?></label>
					</div>
					<div class="radio">
					<label><input type="radio" name="jak_analyticpost" value="0"<?php if ($JAK_FORM_DATA["analyticpost"] == '0') { ?> checked="checked"<?php } ?> /> <?php echo $tl["general"]["g19"];?></label>
					</div>
				</td>
			</tr>
		</table>
	</div>
	<div class="box-footer">
		<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>