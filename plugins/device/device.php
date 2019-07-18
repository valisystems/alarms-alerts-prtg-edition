<?php

/*===============================================*\
|| ############################################# ||
|| # Claricom.ca                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Check if the file is accessed only via index.php if not stop the script from running
if(!defined('JAK_PREVENT_ACCESS')) die('No direct access!');

// Functions we need for this plugin
include_once 'functions.php';

// Get the database table
$jaktable = DB_PREFIX.'device';

// parse url
$backtodevice = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_DEVICE, '', '', '', '');

// The new parsing method for url and passing it to template
$P_DEVICE_URL = $backtodevice;

// Get the CSS and Javascript into the page
$JAK_HEADER_CSS = $jkv["dev_css"];
$JAK_FOOTER_JAVASCRIPT = $jkv["dev_javascript"];

// p is $page and sp is page1
switch ($page1) {

	// For Ajax Calls
	case 'ajax':
		include 'custom/class.device.php';
		$deviceObj = new JAK_device();
		$VISITOR_PERMISSIONS = [
			"create" => $jkv["deviceftcancreate"],
			"edit" => $jkv["deviceftcanedit"],
			"delete" => $jkv["deviceftcandelete"]
		];
		switch ($page2) {
			case 'cform':
					$PAGE_TITLE = '';
					$PAGE_CONTENT = $deviceObj->createForm();
				break;
			case 'insert':
					$PAGE_TITLE = '';
					if(file_get_contents('php://input'))
					{
						$data = json_decode(file_get_contents('php://input'), true);
						if(!$deviceObj->deviceExist($data) )
						{
                            // create query file insert url
                            $data['prtg_url'] = "/index.php?p=device&sp=prtg&action=query&basename=" . $data['BaseName'] . "&deviceid=" . $data['DeviceID'];

					        $deviceObj->insert($data);
							$PAGE_CONTENT = 'Device created successfully';
						}
						else
						{
							$PAGE_CONTENT = 'Device with BaseName alreday Exist';
						}

					}
					else {
						$PAGE_CONTENT = 'error';
					}
				break;
			case 'eform':
					$PAGE_TITLE = '';
					if ($_SERVER['REQUEST_METHOD'] == 'POST') {
						$PAGE_CONTENT = $deviceObj->editFormDevice($_POST);
					}
					else {
						$PAGE_CONTENT = 'Please Select Device Data';
					}
				break;
			case 'update':
					$PAGE_TITLE = '';
					if(file_get_contents('php://input'))
					{
						$data = json_decode(file_get_contents('php://input'), true);
						$deviceObj->update($data);
						$PAGE_CONTENT = 'Device updated successfully';
					}
					else {
						$PAGE_CONTENT = 'error';
					}
				break;
			case "del":
					$PAGE_TITLE = '';
					if(file_get_contents('php://input'))
					{
						$data = json_decode(file_get_contents('php://input'), true);
						$deviceObj->deleteByDeviceId($data);

                        // set SFTP object, use host, username and password
                        //$deviceObj->ftpFilework($jkv, null, $data, 'del');

						$PAGE_CONTENT = 'Device deleted successfully';
					}
					else {
						$PAGE_CONTENT = 'error';
					}
				break;
			case "eventChange":
				$PAGE_TITLE = '';
				if (file_get_contents('php://input'))
				{
					$data = json_decode(file_get_contents('php://input'), true);
					$deviceObj->changeEventType($data['action'], $data);
					$PAGE_CONTENT = 'EventType type changed';
				}
				break;
			case 'signalupdate':
                    $PAGE_TITLE = 'json';
                    if ($_GET['auth'] && $_GET['auth'] === $jkv["deviceauthkey"])
                    {
                        if(file_get_contents('php://input'))
                        {
                            $data = json_decode(file_get_contents('php://input'), true);
                            if($deviceObj->deviceExist($data) )
                            {
                                $deviceObj->signalupdate($data);
                                $PAGE_CONTENT = ['status' => 'emsconfirmed'];
                            }
                            else
                            {
                                if ($jkv["devicediscover"])
                                {
                                	// create query file insert url
                                    $data['prtg_url'] = "/index.php?p=device&sp=prtg&action=query&basename=" . $data['BaseName'] . "&deviceid=" . $data['DeviceID'];
                                    
                                    $deviceObj->insert($data);
                                    $PAGE_CONTENT = ['status' => 'emsconfirmed'];
                                }
                                else
                                {
                                    $PAGE_CONTENT = ['status' => 'emsconfirmed'];
                                }
                            }
                        }
                        else {
                            $PAGE_CONTENT = ['status' => 'emsconfirmed'];
                        }
                    }
                    else {
                        $PAGE_CONTENT = ['status' => 'emsconfirmed'];
                    }
				break;
			default:
					$PAGE_CONTENT = [
						"data" => 'hello'
					];
				break;
		}
		$plugin_template = 'plugins/device/template/'.$jkv["sitestyle"].'/json.php';

	break;// END of ajax case

	case "upd_event":
		include 'custom/class.device.php';
		$deviceObj = new JAK_device();
		$PAGE_TITLE = '';
		if (!empty($_GET) && !empty($_GET['action']))
		{
			$data = [
				'action' => $_GET['action'],
				'DeviceID' => !empty($_GET['device']) ? $_GET['device'] : '',
				'BaseName' => !empty($_GET['basename']) ? $_GET['basename'] : '',
				'EventType' => empty($_GET['EventType']) ? 'Normal' : $_GET['EventType']
			];
			$deviceObj->changeEventType($data['action'], $data);
			$PAGE_CONTENT = 'Device Event type changed.';
		}
		$plugin_template = 'plugins/device/template/'.$jkv["sitestyle"].'/json.php';
	break;

	case "prtg":
        include 'custom/class.device.php';
        $deviceObj = new JAK_device();
        $PAGE_TITLE = 'json';
        if (!empty($_GET) && !empty($_GET['action']))
        {
			$selected_device='';
			if($_GET['action'] == 'all')
			{
				$selected_device = $deviceObj->prtg_status_all_devices();
				if($selected_device)
				{
					$PAGE_CONTENT = $selected_device;
				}
				else
				{
					$PAGE_CONTENT = ['error' => 'No device Found'];
				}
			}
			elseif($_GET['action'] == 'query')
			{
				$data = [
					'action' => $_GET['action'],
					'deviceid' => $_GET['deviceid'],
					'basename' => $_GET['basename']
				];
				$selected_device = $deviceObj->prtg_query($data['action'], $data);
				if($selected_device)
				{
					$PAGE_CONTENT = [
						"base_name" => $selected_device['base_name'],
						"device" => $selected_device['device_id'],
						"status" => $selected_device['event_type']
					];
				}
				else
				{
					$PAGE_CONTENT = ['error' => 'No device Found'];
				}
			}
			else
			{
				$PAGE_CONTENT = ['error' => 'Please provide valid query;'];
			}
			
            
        }
        else
        {
            $PAGE_CONTENT = ['error' => 'No device Selected'];
        }
        $plugin_template = 'plugins/device/template/'.$jkv["sitestyle"].'/json.php';
    break;

	case 'alert':
		include 'custom/class.alert.php';
		$errors = [];
		if ($_SERVER["REQUEST_METHOD"] == 'GET' && !empty($_GET))
		{
			if (empty($jkv["devicepbxhost"])) {
				$errors['ae1'] = "Please provide PBX host name. <br/>";
			}
			if (empty($jkv["devicepbxusername"])) {
				$errors['ae2'] = "Please provide PBX admin username. <br/>";
			}
			if (empty($jkv["devicepbxpassword"])) {
				$errors['ae3'] = "Please provide PBX admin password. <br/>";
			}
			if (empty($_GET["acc"])) {
				$errors['ae4'] = "Please provide account name e.g 100@localhost. <br/>";
			}
			if (empty($_GET["dest"])) {
				$errors['ae5'] = "Please provide PBX destination. <br/>";
			}

			if (count($errors) == 0) {
				$alertObj = new JAK_alert([
					'host' => $jkv["devicepbxhost"],
					'username' => $jkv["devicepbxusername"],
					'password' => $jkv["devicepbxpassword"]
				]);

				$PAGE_CONTENT = $alertObj->getVodiaPBXDids($_GET['acc'], $_GET['dest']);
                // Send Email too
				/*if (!empty($_GET["email"]) && $jkv["devicealertemail"]) {
					if (filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) {
    		        	include '../class/class.phpmailer.php';

					    // start the mail client
					    $mail = new PHPMailer();
						 // Send email the smpt way or else the mail way
						if ($jkv["deviceemailhost"] || $jkv["deviceemailusername"] || $jkv["deviceemailpassword"] ) {

							$mail->IsSMTP(); // telling the class to use SMTP
							$mail->Host = $jkv["deviceemailhost"];
							$mail->SMTPAuth =  true; // enable SMTP authentication
							$mail->SMTPSecure = $jkv["deviceemailserverprefix"]; // sets the prefix to the server
							$mail->SMTPKeepAlive = true : false; // SMTP connection will not close after each email sent
							$mail->Port = $jkv["deviceemailport"]; // set the SMTP port for the GMAIL server
							$mail->Username = $jkv["deviceemailusername"]; // SMTP account username
							$mail->Password = $jkv["deviceemailpassword"];        // SMTP account password
							$mail->SetFrom($jkv["nlemail"], $jkv["title"]);
							$mail->AddReplyTo($jkv["nlemail"], $jkv["title"]);
							$mail->AltBody = $tlnl["nletter"]["d40"]; // optional, comment out and test
							$mail->Subject = $subject;

						} else {
							$error[ae6] = 'Please set email STMP settings'
						}
						// Get the body into the right format
				     	$body = str_ireplace("[\]", '', $nlcontent);

					    $mail->MsgHTML($body);
					    $mail->AddAddress($_GET["email"], $row1["name"]);

						if(!$mail->Send()) {
						}
						else {
						}
    		    	}
					else {
						$errors['ae6'] = "Please enter valid email. <br/>";
					}
				}// end of EMAIL */
			}
		}
		$plugin_template = 'plugins/device/template/'.$jkv["sitestyle"].'/alert.php';
	break; // END of alert case

	case 'catch':
		include 'custom/class.catch.php';

			$catchObj = new JAK_catch([
				'pdir' => !empty($jkv["devicecatchsinglefile"]) ? '_files/catch/single_files/' : '_files/catch/',
				'sfile' => !empty($jkv["devicecatchsinglefile"]) ? true : false,
				'file_ext' => 'txt'
			]);
			$catchObj->writeContent();
			$PAGE_TITLE = 'Catch Files';
            if ($jkv["devicecatchsinglefile"])
            {
               $PAGE_CONTENT = 'Single File catch';
               $JAK_CATCH_FILES = jak_get_device_files('_files/catch/single_files/');
            }
            else {
                $PAGE_CONTENT = 'Folder catch';
                $JAK_CATCH_FILES = jak_get_catch_dirs('_files/catch/');
            }
		$plugin_template = 'plugins/device/template/'.$jkv["sitestyle"].'/catch.php';
	break;

	case 'cam':
		include 'custom/class.cam.php';

		if ($jkv["devicecamhost"] && $jkv["devicecamusername"] && $jkv["devicecampassword"]) {
			$camObj = new JAK_cam([
				"host" => $jkv["devicecamhost"],
				'username' => $jkv["devicecamusername"],
				"password" => $jkv["devicecampassword"]
			]);
		}
		else{
			$error['e1'] = "Please check Camera settings.";
		}

		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$PAGE_CONTENT = '<img src="'.$camObj->getSingleCamVideo($_POST['video_url'], $_POST['size'] ).'" /> ';
			$plugin_template = 'plugins/device/template/'.$jkv["sitestyle"].'/json.php';
		}
        elseif ($page2 || !(int)$page2 < 0 || $_GET['ssp'] == '0')
        {
            $PAGE_TITLE = "Camera Slider";
            if (!$camImage = $camObj->getSingleCamImage((int)$page2, '900x500'))
            {
                $content = '<h3> No camera found.</h3>';
            }

            $plugin_template = 'plugins/device/template/'.$jkv["sitestyle"].'/camslider.php';
        }
        else
		{
		    $cams = [];
		    $PAGE_TITLE = "Camera Images";
            $apiResults = json_decode($camObj->getCameras());
            if ($apiResults)
            {
                foreach ($apiResults as $k => $cam)
                {
                    $cams[$k] =[
                        'id' => substr($cam->uri, -1),
                        'name' => $cam->name,
                        'uri' => $cam->uri,
                        'image' => $camObj->getSingleCamImage(substr($cam->uri, -1)),
                        'video' => $cam->{'video-uri'}
                    ];
                }
            }
			$plugin_template = 'plugins/device/template/'.$jkv["sitestyle"].'/camimages.php';
		}
	break; // END of CAM

	case "call":
		if ($_GET['dest'])
		{
			if ($jkv["devicepbxhost"] && $jkv["devicepbx_default_ext"] && $jkv["devicepbx_ext_pass"])
			{
				$src = !empty($_GET["src"]) ? '&src='.$_GET["src"] : '';
				$url = $jkv["devicepbxhost"] . "/remote_call.htm?user=" . $jkv["devicepbx_default_ext"] ."&dest=" . $_GET['dest'] . "&auth=" . $jkv["devicepbx_default_ext"] . ":" . $jkv["devicepbx_ext_pass"] . "&connect=true".$src;
				header('Location: '. $url);
				exit();
			}
		}

		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			if ($_POST["pbx_url"] && $_POST["user"] && $_POST["password"] && $_POST["dest"])
			{
				$url = $_POST["pbx_url"] . "/remote_call.htm?user=" . $_POST["user"] ."&dest=" . $_POST["dest"] . "&auth=" .$_POST["user"].":". $_POST["password"]."&connect=true";
				header('Location: '. $url);
				exit();
			}
			else {
				$error = 'Please fill all the fields.';
			}
		}

		$plugin_template = 'plugins/device/template/'.$jkv["sitestyle"].'/remote_call.php';
	break;
	// END of Call
	default:
		include 'custom/class.device.php';
        $deviceObj = new JAK_device();
	
		$VISITOR_PERMISSIONS = [
			"create" => $jkv["deviceftcancreate"],
			"edit" => $jkv["deviceftcanedit"],
			"delete" => $jkv["deviceftcandelete"]
		];
		$PAGE_PASSWORD = $jkv["devicelistpassword"];

		if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST["action"] == "passwordProtected") {
            if($_POST["pagepass"]  == $PAGE_PASSWORD)
            {
                $_SESSION['pagesecurehash'.$_POST['action']] = $_POST["pagepass"];
                jak_redirect($_SERVER['HTTP_REFERER']);
            }
            else {
                $errorpp["e"] = "Please enter valid password.";
            }
        }
		
		$query = [];
		
		$deviceloadonce = false;
		$getTotal = $deviceObj->jak_get_device_total($query);
		if ($getTotal != 0) {
			// Paginator
			$device = new JAK_Paginator;
			$device->items_total = $getTotal;
			$device->mid_range = $jkv["devicepagemid"];
			$device->items_per_page = $jkv["devicepageitem"];
			$device->jak_get_page = $page1;
			$device->jak_where = $backtodevice;
			$device->jak_prevtext = $tl["general"]["g171"];
			$device->jak_nexttext = $tl["general"]["g172"];
			$device->paginate();

			$JAK_PAGINATE = $device->display_pages();

			// Display the device
			$JAK_DEVICE_ALL = $deviceObj->jak_get_device($query);
		}
		// Check if we have a language and display the right stuff
		$PAGE_TITLE = $jkv["devicetitle"];
		$PAGE_CONTENT = $jkv["devicedesc"];
		$JAK_HEATMAPLOC = JAK_PLUGIN_VAR_DEVICE;

		$PAGE_SHOWTITLE = 1;

		// Get the url session
		$_SESSION['jak_lastURL'] = $backtodevice;

		$keylist = "";
		if (!empty($seokeywords)) $keylist = join(",", $seokeywords);

		$PAGE_KEYWORDS = str_replace(" ", "", JAK_Base::jakCleanurl($PAGE_TITLE).($keylist ? ",".$keylist : "").($jkv["metakey"] ? ",".$jkv["metakey"] : ""));
		$PAGE_DESCRIPTION = jak_cut_text($PAGE_CONTENT, 155, '');

		// get the standard template
		$plugin_template = 'plugins/device/template/'.$jkv["sitestyle"].'/device.php';
	break;
}
?>
