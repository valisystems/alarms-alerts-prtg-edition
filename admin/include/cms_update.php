<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Found on http://maxmorgandesign.com/simple_php_auto_update_system/ modified for CMS

// If not super admin...
if (!JAK_SUPERADMINACCESS) die();

if (isset($_GET['check']) && $_GET['check'] == true) {

ini_set('max_execution_time',60);

$updated = $found = false;

// Check For An Update
$getVersions = @file_get_contents('http://repo.claricom.ca/emslite/checkupdates/release.php') or die('<div class="alert alert-danger">Cannot access the release file.</div>');

if ($getVersions != '') {
	echo '<p>Reading Current Releases List</p>';
	$versionList = explode("\n", $getVersions);	
	
	foreach ($versionList as $aV) {
	
		if ($aV > $jkv["version"]) {
			echo '<p>Found new update: '.$aV.'</p>';
			$found = true;
			
			$dlpackage = str_replace(".", "_", $aV);
			
			// Download the file if we have to
			if (!is_file(APP_PATH.JAK_FILES_DIRECTORY.'/updates/part_cms_'.$dlpackage.'.zip' )) {
				echo '<p>Downloading New Update</p>';
				$newUpdate = @file_get_contents('http://repo.claricom.ca/emslite/checkupdates/part_cms_'.$dlpackage.'.zip') or die('<div class="alert alert-danger">Cannot access the latest update.</div>');
				if (!is_dir(APP_PATH.JAK_FILES_DIRECTORY.'/updates/')) mkdir(APP_PATH.JAK_FILES_DIRECTORY.'/updates/');
				$dlHandler = fopen(APP_PATH.JAK_FILES_DIRECTORY.'/updates/part_cms_'.$dlpackage.'.zip', 'w');
				if (!fwrite($dlHandler, $newUpdate)) { echo '<p>Could not save new update. Operation aborted.</p>'; exit(); }
				fclose($dlHandler);
				echo '<p>Update downloaded and saved</p>';
			} else {
				echo '<p>Update already downloaded.</p>';
			}
			
			if ($_GET['run'] == true) {
				// Open The File And Do Stuff
				$zipHandle = zip_open(APP_PATH.JAK_FILES_DIRECTORY.'/updates/part_cms_'.$dlpackage.'.zip');
				echo '<ul>';
				while ($aF = zip_read($zipHandle)) {
				
					$thisFileName = zip_entry_name($aF);
					$thisFileDir = dirname($thisFileName);
					
					// Continue if its not a file
					if (substr($thisFileName,-1,1) == '/') continue;
	
					// Make the directory if we need to...
					if (!is_dir(APP_PATH.$thisFileDir)) {
						 mkdir(APP_PATH.$thisFileDir, 0775);
						 echo '<li>Created Directory '.$thisFileDir.'</li>';
					}
					
					// Overwrite the file
					if (!is_dir(APP_PATH.$thisFileName)) {
						echo '<li>'.$thisFileName.'...........';
						$contents = zip_entry_read($aF, zip_entry_filesize($aF));
						$contents = str_replace("\r\n", "\n", $contents);
						$updateThis = '';
						
						// If we need to run commands, then do it.
						if ($thisFileName == 'update.php') {
							$upgradeExec = fopen('update.php','w');
							fwrite($upgradeExec, $contents);
							fclose($upgradeExec);
							include('update.php');
							unlink('update.php');
							echo ' Database updated</li>';
						} else {
							$updateThis = fopen(APP_PATH.$thisFileName, 'w');
							fwrite($updateThis, $contents);
							fclose($updateThis);
							unset($contents);
							echo ' Updated</li>';
						}
					}
				}
				echo '</ul>';
				$updated = true;
				unlink(APP_PATH.JAK_FILES_DIRECTORY.'/updates/part_cms_'.$dlpackage.'.zip');
			} else {
				echo '<p>Update ready. <a href="index.php?p=maintenance&amp;check=true&amp;run=true">&raquo; Install Now?</a></p>';
			}
			break;
		}
	}
	
	if ($updated == true) {
		echo '<p class="success">&raquo; CMS updated to '.$aV.'</p>';
	} elseif ($found != true) {
		echo '<p>&raquo; There is no update available at this moment.</p>';
	}
	
} else {
	echo '<p>Could not find latest realeases.</p>';
}

} else {
	echo '<a href="index.php?p=maintenance&amp;check=true" class="btn btn-default">'.$tl["general"]["g122"].'</a>';
}
?>