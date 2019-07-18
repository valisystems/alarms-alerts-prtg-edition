<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

if (!file_exists('../../config.php')) die('[index.php] config.php not found');
require_once '../../config.php';

// Include the thumbnail script
include_once '../../include/functions_thumb.php';

if (!JAK_USERID || !$jakuser->jakModuleaccess(JAK_USERID,JAK_ACCESSGALLERY)) die();

// Get the upload path
$JAK_UPLOAD_PATH_BASE = APP_PATH.'plugins/gallery/upload';

$latitude = NULL;
$longitude = NULL;

if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$origName = substr($_FILES['Filedata']['name'], 0, -4);
	$name_space = strtolower($_FILES['Filedata']['name']);
    $middle_name = str_replace(" ", "_", $name_space);
    $middle_name = str_replace(".jpeg", ".jpg", $name_space);
    $glnrrand = rand(100000, 999999);
    $origPhoto = str_replace(".", "_o_" . $glnrrand . ".", $middle_name);
    $bigPhoto = str_replace(".", "_" . $glnrrand . ".", $middle_name);
    $smallPhoto = str_replace(".", "_t.", $bigPhoto);
	    
 	$targetPath = $JAK_UPLOAD_PATH_BASE.'/'.$_REQUEST['jak_catid_new'].'/';
 	$targetPathWdouble = $JAK_UPLOAD_PATH_BASE.'/watermark/';
 	$targetPathW =  str_replace("//","/",$targetPathWdouble);
	$targetFile =  str_replace("//","/",$targetPath).$origPhoto;
	$origPath = '/'.$_REQUEST['jak_catid_new'].'/';
	$origPathW = '/watermark/';
	$dbSmall = $origPath.$smallPhoto;
	if (!$jkv["gallerywatermark"]) {
		$dbBig = $origPath.$bigPhoto;
	} else {
		$dbBig = $origPathW.$bigPhoto;
	}
	$dbOrig = $origPath.$origPhoto;

	// Create Directory in the gallery folder
	if (!is_dir($targetPath)) {
    	mkdir($targetPath);
        copy("index.html", $targetPath . "/index.html");
    }

	// Move file and create thumb     
    move_uploaded_file($tempFile, $targetFile);
     
    // Now check if we have to rotate
    switch (strtolower(substr($targetFile, -3))) {
        case "jpg":
        
        	// We have a jpg, read the exif if possible
        	$image = imagecreatefromjpeg($targetFile);  
        	
        	$exif = exif_read_data($targetFile);
        	if (!empty($exif['Orientation'])) {
        	    switch($exif['Orientation']) {
        	        case 8:
        	            $rotate = imagerotate($image,90,0);
        	            break;
        	        case 3:
        	            $rotate = imagerotate($image,180,0);
        	            break;
        	        case 6:
        	            $rotate = imagerotate($image,-90,0);
        	            break;
        	    }
        	    
        	    if ($rotate) {
            	    imagejpeg($rotate, $targetFile);
            	    imagedestroy($rotate);
            	}
            	imagedestroy($image);
        	}
        	
        	// Save the GPS Cordinate
        	if ($exif["GPSLatitude"]) {
        		$latitude = jak_create_gps($exif["GPSLatitude"], $exif['GPSLatitudeRef']);
        		$longitude = jak_create_gps($exif["GPSLongitude"], $exif['GPSLongitudeRef']);
        	}
        	
        break;
    }
     
	// Check if watermark exist
	if ($jkv["gallerywatermark"]) {
		create_thumbnail($targetPath, $targetFile, $smallPhoto, $jkv["gallerythumbw"], $jkv["gallerythumbh"], $jkv["galleryimgquality"]);
     	create_thumbnail_watermark($targetPathW, $targetFile, $bigPhoto, $jkv["galleryw"], $jkv["galleryh"], $jkv["galleryimgquality"], $jkv["gallerywmposition"], $jkv["gallerywatermark"]);	
	} else {
     	create_thumbnail($targetPath, $targetFile, $smallPhoto, $jkv["gallerythumbw"], $jkv["gallerythumbh"], $jkv["galleryimgquality"]);
     	create_thumbnail($targetPath, $targetFile, $bigPhoto, $jkv["galleryw"], $jkv["galleryh"], $jkv["galleryimgquality"]);
    }
     
// SQL insert
    global $jakdb;
    $jakdb->query('INSERT INTO '.DB_PREFIX.'gallery VALUES (NULL, "'.smartsql($_REQUEST['jak_catid_new']).'", "'.$dbSmall.'", "'.$dbBig.'", "'.$dbOrig.'", "'.JAK_USERID.'", "'.$origName.'", "", "", 2, 1, "'.$longitude.'", "'.$latitude.'", NOW())');
	
	if ($_REQUEST['jak_catid_new'] != 0) {
		$result1 = $jakdb->query('UPDATE '.DB_PREFIX.'gallerycategories SET count = count + 1 WHERE id = "'.smartsql($_REQUEST['jak_catid_new']).'"');
	}
	
switch ($_FILES['Filedata']['error'])
{
     case 0:
     //$msg = "No Error"; // comment this out if you don't want a message to appear on success.
     break;
     case 1:
     $msg = "The file is bigger than this PHP installation allows";
     break;
     case 2:
     $msg = "The file is bigger than this form allows";
     break;
     case 3:
     $msg = "Only part of the file was uploaded";
     break;
     case 4:
     $msg = "No file was uploaded";
     break;
     case 6:
     $msg = "Missing a temporary folder";
     break;
     case 7:
     $msg = "Failed to write file to disk";
     break;
     case 8:
     $msg = "File upload stopped by extension";
     break;
     default:
     $msg = "unknown error ".$_FILES['Filedata']['error'];
     break;
}

if ($msg) {
    $stringData = "Error Info: ".$msg;
} else { 
	$stringData = "1"; // This is required for onComplete to fire on Mac OSX
}
echo $stringData;
}
?>