<?php
require_once "include/db.php";

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if($mysqli->connect_errno)
    exit("Connect failed: " . $mysqli->connect_error);

if (file_get_contents("php://input"))
{
	$data = json_decode(file_get_contents("php://input"), true);

//$data =json_decode('{"BaseName":"miDome_632071", "DeviceType":"DomeBase", "EventType":"Contact", "DeviceID":"632071A1", "AntennaInt":"0", "PendantRxLevel":"0", "LowBattery":"false", "TimeStamp":"20160526080325"}', true);

	$cms_settings = jak_get_setting($mysqli);

	if (!empty($_GET["auth"]) && $_GET["auth"] == $cms_settings["deviceauthkey"])
	{
		if (deviceExist($mysqli, $data))
		{
			signalupdate($mysqli, $data);
		}
		else
		{
			if ($cms_settings["devicediscover"])
			{
				$data['prtg_url'] = "/index.php?p=device&sp=prtg&action=query&basename=" . $data['BaseName'] . "&deviceid=" . $data['DeviceID'];
				$query = sprintf("INSERT INTO cms_device (`device_id`, `base_name`, `device_type`, `event_type`, `antenna_int`, `pendant_rx_level`, `low_battery`, `time_stamp`, `prtg_url`, `time`)
			                    values ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')",
			        $mysqli->real_escape_string($data['DeviceID']),
			        $mysqli->real_escape_string($data['BaseName']),
			        $mysqli->real_escape_string($data['DeviceType']),
			        $mysqli->real_escape_string($data['EventType']),
			        $mysqli->real_escape_string($data['AntennaInt']),
			        $mysqli->real_escape_string($data['PendantRxLevel']),
			        $mysqli->real_escape_string($data['LowBattery']),
			        $mysqli->real_escape_string($data['TimeStamp']),
			        $mysqli->real_escape_string($data['prtg_url']),
			        $mysqli->real_escape_string(date('Y-m-d H:i:s') ) );
			    $mysqli->query($query);
			}
			else
			{
				echo "Device Discover mode is off";
			}
		}
	}
	else
	{
		echo "You are missing auth";
	}

}
else
{
	echo "Post json content";
}


//********************* functions ***************
function deviceExist($db, $data)
{
	$stmt = $db->query('SELECT * FROM cms_device WHERE device_id = "' . $data["DeviceID"] . '" AND base_name = "' . $data["BaseName"].'"; ');
	$row = $stmt->fetch_assoc();
	if(!$row)
	{
		return false;
	}
	return true;
}

function signalupdate($db, $data)
{
	$result = $db->query('UPDATE cms_device SET
        			device_type = "'.$data['DeviceType'].'",
					event_type = "'.$data['EventType'].'",
					antenna_int = "'.$data['AntennaInt'].'",
					pendant_rx_level = "'.$data['PendantRxLevel'].'",
					low_battery = "'.$data['LowBattery'].'",
					time_stamp = "'.$data['TimeStamp'].'"
        			WHERE device_id = "'.$data['DeviceID'].'"
        			AND base_name =  "'.$data['BaseName'].'"
        			');
	if(!$result)
	{
		return false;
	}
	return true;
}

// Get the setting variable as well the default variable as array
function jak_get_setting($db)
{
    $result = $db->query('SELECT varname, value, defaultvalue FROM cms_setting WHERE groupname = "device"');
    while ($row = $result->fetch_assoc()) {
       $setting[$row['varname']] = $row['value'];
    }
    return $setting;
}

function catch_file($url, $data)
{
	$fp = fopen($url, 'wb');
    fwrite($fp, $data);
    fclose($fp);
}

