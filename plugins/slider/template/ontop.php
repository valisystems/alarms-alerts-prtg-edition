<?php if (isset($loadslider)) {

	$loadsliderontop = true;

	if ($rowls["lsontop"]) {

		$loadsliderontop = false;

		include_once APP_PATH.'plugins/slider/template/pages_news.php';
		
	}
	
}
?>