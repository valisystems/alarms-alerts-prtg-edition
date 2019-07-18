<?php

// Check if this comes in JSON form:
$data = [];
$data['session'] = !empty($_SESSION) ? print_r($_SESSION, true) : '';
$data['request'] = !empty($_REQUEST) ?  print_r($_REQUEST, true)  : '';// contents data of get, post, and cookie
$data['get'] = !empty($_GET) ?  print_r($_GET, true) : '';
$data['post'] = !empty($_POST) ?  print_r($_POST, true) : '';
$data['files'] = !empty($_FILES) ?  print_r($_FILES, true) : '';
$data['server'] = !empty($_SERVER) ?  print_r($_SERVER, true) : '';
$data['file_content'] = !empty(file_get_contents("php://input")) ?  print_r(file_get_contents("php://input"), true) : '';

$filename = date('Ymd-his') . '.txt';
if (!$fp = fopen('_files/catch/single_files/' . $filename, 'x+'))
{
    exit('Failed to create file:' . $filename);
}
fwrite($fp, print_r($data, true));
fclose($fp);