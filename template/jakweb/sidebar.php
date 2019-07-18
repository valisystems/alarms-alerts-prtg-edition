<div class="col-md-3 sidebar">
<?php 
	if (isset($JAK_HOOK_SIDE_GRID) && is_array($JAK_HOOK_SIDE_GRID)) foreach($JAK_HOOK_SIDE_GRID as $sg) {
	if (isset($JAK_HOOK_SIDEBAR) && is_array($JAK_HOOK_SIDEBAR)) foreach($JAK_HOOK_SIDEBAR as $hs) {
	if ($hs["id"] == $sg["hookid"]) {
		include_once $hs["phpcode"];
} } } ?>
</div>