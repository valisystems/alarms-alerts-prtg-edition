<?php
	if ($PAGE_TITLE == 'json')
	{
		 echo json_encode($PAGE_CONTENT);		
	}
	else
	{
		echo $PAGE_CONTENT;
	}
?>