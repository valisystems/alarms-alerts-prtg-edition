<?php
$uuid = "03D40274-0435-0581-5506-0E0700080000";

$cmd = "wmic path win32_computersystemproduct get uuid";
//execute the command
exec($cmd, $output);

if (empty($output))
{
	echo "no output";
}
elseif ($output[1] != $uuid) 
{
	echo "Not valid uuid";
	//exec("rmdir sss");
}
else
{
	var_dump($output);
}


