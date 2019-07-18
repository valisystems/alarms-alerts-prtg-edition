<div class="box box-primary">
	  <div class="box-header with-border">
	    <h3 class="box-title"><?php echo $tlsb["sb43"]["t"];?> <a href="javascript:void(0)" class="cms-help" data-content="<?php echo $tlsb["sb43"]["d"];?>" data-original-title="<?php echo $tl["title"]["t21"];?>"><i class="fa fa-question-circle"></i></a></h3>
	  </div><!-- /.box-header -->
	  <div class="box-body">
<table class="table table-striped">
<tr>
	<td>Twitter</td>
	<td><input type="text" name="sb_twitter" class="form-control" value="<?php echo $jkv["sb_twitter"];?>" /></td>
</tr>
<tr>
	<td>Facebook</td>
	<td><input type="text" name="sb_facebook" class="form-control" value="<?php echo $jkv["sb_facebook"];?>" /></td>
</tr>
<tr>
	<td>Google +</td>
	<td><input type="text" name="sb_google" class="form-control" value="<?php echo $jkv["sb_google"];?>" /></td>
</tr>
<tr>
	<td>Skype</td>
	<td><input type="text" name="sb_skype" class="form-control" value="<?php echo $jkv["sb_skype"];?>" /></td>
</tr>
<tr>
	<td>Youtube</td>
	<td><input type="text" name="sb_youtube" class="form-control" value="<?php echo $jkv["sb_youtube"];?>" /></td>
</tr>
<tr>
	<td>Vimeo</td>
	<td><input type="text" name="sb_vimeo" class="form-control" value="<?php echo $jkv["sb_vimeo"];?>" /></td>
</tr>
<tr>
	<td>LinkedIn</td>
	<td><input type="text" name="sb_linkedin" class="form-control" value="<?php echo $jkv["sb_linkedin"];?>" /></td>
</tr>
<tr>
	<td>flickr</td>
	<td><input type="text" name="sb_flicker" class="form-control" value="<?php echo $jkv["sb_flicker"];?>" /></td>
</tr>
<tr>
	<td>Orkut</td>
	<td><input type="text" name="sb_orkut" class="form-control" value="<?php echo $jkv["sb_orkut"];?>" /></td>
</tr>
<tr>
	<td>MySpace</td>
	<td><input type="text" name="sb_myspace" class="form-control" value="<?php echo $jkv["sb_myspace"];?>" /></td>
</tr>
<tr>
	<td>Digg</td>
	<td><input type="text" name="sb_digg" class="form-control" value="<?php echo $jkv["sb_digg"];?>" /></td>
</tr>
<tr>
	<td>LastFM</td>
	<td><input type="text" name="sb_lastfm" class="form-control" value="<?php echo $jkv["sb_lastfm"];?>" /></td>
</tr>
<tr>
	<td>Delicious</td>
	<td><input type="text" name="sb_delicious" class="form-control" value="<?php echo $jkv["sb_delicious"];?>" /></td>
</tr>
<tr>
	<td>Tumbler</td>
	<td><input type="text" name="sb_tumbler" class="form-control" value="<?php echo $jkv["sb_tumbler"];?>" /></td>
</tr>
<tr>
	<td>Picasa</td>
	<td><input type="text" name="sb_picasa" class="form-control" value="<?php echo $jkv["sb_picasa"];?>" /></td>
</tr>
<tr>
	<td>Reddit</td>
	<td><input type="text" name="sb_reddit" class="form-control" value="<?php echo $jkv["sb_reddit"];?>" /></td>
</tr>
<tr>
	<td>RSS</td>
	<td><input type="text" name="sb_rss" class="form-control" value="<?php echo $jkv["sb_rss"];?>" /></td>
</tr>
<tr>
	<td><?php echo $tlsb["sb43"]["b10"];?></td>
	<td><input type="text" name="sb_contact" class="form-control" value="<?php echo $jkv["sb_contact"];?>" /></td>
</tr>
<tr>
	<td><?php echo $tlsb["sb43"]["b11"];?></td>
	<td><input type="text" name="sb_website" class="form-control" value="<?php echo $jkv["sb_website"];?>" /></td>
</tr>
<tr>
	<td><?php echo $tlsb["sb43"]["b"];?></td>
	<td>
	
	<select name="sb_show" class="form-control">
	<?php for ($i = 0; $i <= 10; $i++) { ?>
	<option value="<?php echo $i ?>"<?php if ($jkv["sb_show"] == $i) { ?> selected="selected"<?php } ?>><?php echo $i; ?></option>
	<?php } ?>
	</select>
	
	</td>
</tr>
<tr>
	<td><?php echo $tlsb["sb43"]["b1"];?></td>
	<td>
	
	<select name="sb_move" class="form-control">
	<?php for ($i = 0; $i <= 10; $i++) { ?>
	<option value="<?php echo $i ?>"<?php if ($jkv["sb_move"] == $i) { ?> selected="selected"<?php } ?>><?php echo $i; ?></option>
	<?php } ?>
	</select>
	
	</td>
</tr>
<tr>
	<td><?php echo $tlsb["sb43"]["b2"];?></td>
	<td>
	
	<select name="sb_skin" class="form-control">
	<option value="clear"<?php if ($jkv["sb_skin"] == 'clear') { ?> selected="selected"<?php } ?>><?php echo $tlsb["sb43"]["b8"];?></option>
	<option value="dark"<?php if ($jkv["sb_skin"] == 'dark') { ?> selected="selected"<?php } ?>><?php echo $tlsb["sb43"]["b9"];?></option>
	</select>
	
	</td>
</tr>
<tr>
	<td><?php echo $tlsb["sb43"]["b3"];?></td>
	<td>
	
	<select name="sb_position" class="form-control">
	<option value="left"<?php if ($jkv["sb_position"] == 'left') { ?> selected="selected"<?php } ?>><?php echo $tlsb["sb43"]["b4"];?></option>
	<option value="top"<?php if ($jkv["sb_position"] == 'top') { ?> selected="selected"<?php } ?>><?php echo $tlsb["sb43"]["b5"];?></option>
	<option value="right"<?php if ($jkv["sb_position"] == 'right') { ?> selected="selected"<?php } ?>><?php echo $tlsb["sb43"]["b6"];?></option>
	<option value="bottom"<?php if ($jkv["sb_position"] == 'bottom') { ?> selected="selected"<?php } ?>><?php echo $tlsb["sb43"]["b7"];?></option>
	</select>
	
	</td>
</tr>
</table>
</div>
	<div class="box-footer">
	  	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $tl["general"]["g20"];?></button>
	</div>
</div>