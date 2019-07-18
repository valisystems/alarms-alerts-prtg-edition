<?php

$datetime = date('Ymd-his'); //

// Check if this comes in JSON form:
$data = [];

$data['session'] = !empty($_SESSION) ? print_r($_SESSION, true) : '';
$data['request'] = !empty($_REQUEST) ?  print_r($_REQUEST, true)  : '';// contents data of get, post, and cookie
$data['get'] = !empty($_GET) ?  print_r($_GET, true) : '';
$data['post'] = !empty($_POST) ?  print_r($_POST, true) : '';
$data['files'] = !empty($_FILES) ?  print_r($_FILES, true) : '';
$data['server'] = !empty($_SERVER) ?  print_r($_SERVER, true) : '';
$data['file_content'] = !empty(file_get_contents("php://input")) ?  print_r(file_get_contents("php://input"), true) : '';

$dir = create_dir('catch/', $datetime);
$file_ext = 'txt';
foreach ($data as $filename => $content)
{
    if (!empty($content))
    {
        create_file($dir, $filename, $file_ext, $content);
    }
}


function create_dir($path, $dir_name)
{
    if (!mkdir($path.$dir_name, 0777, true))
    {
        exit('Failed to create DIR:' . $dir_name);
    }
    return $path . $dir_name . '/';
}

function create_file($path, $filename, $file_ext ,$data)
{
    if (!$fp = fopen($path . $filename . '.' . $file_ext, 'x+'))
    {
        exit('Failed to create file:' . $filename);
    }
    fwrite($fp, $data);
    fclose($fp);
}