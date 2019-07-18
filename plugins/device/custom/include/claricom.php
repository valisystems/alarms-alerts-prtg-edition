<?php

$database_info = [];
$database_info['host'] = 'localhost';
$database_info['name'] = 'miniprtg';
$database_info['user_name'] = 'claricom';
$database_info['user_password'] = 'claricom1234';

// Check if this comes in JSON form:
if(file_get_contents('php://input'))
{
    try
    {
        $dsn = "mysql:host=" . $database_info['host'] . ";dbname=" . $database_info['name'];
        $pdo_connection = new PDO($dsn, $database_info['user_name'], $database_info['user_password']);
    }
    catch(PDOException $e)
    {
        exit("Connect failed: " . $e->getMessage() );
    }
	//{"BaseName":"miPos_630114", "DeviceType":"pull", "AntennaInt":"0", "EventType":"alarm", "DeviceID":"AB00189", "PendantRxLevel": "0", "LowBattery":"false", "TimeStamp":"20160311130539"}
	$data = json_decode(file_get_contents('php://input'), true);

	// if device found update else create deviceExist
	if(deviceExist($pdo_connection, $data) )
	{
        update_status($pdo_connection, $data);
	}
	else
	{
		insert($pdo_connection, $data);
		generateQueryFile('C:/Program Files (x86)/PRTG Network Monitor/Custom Sensors/sql/mysql', $data['DeviceID']);
	}	
}

//******** Functions *********//
// Insert New row
function insert($db, $params)
{
    $statement = $db->prepare("
                                INSERT INTO `device_status` (BaseName, DeviceType, AntennaInt, EventType, DeviceID, PendantRxLevel, LowBattery, TimeStamp) 
                                VALUES (:BaseName, :DeviceType, :AntennaInt, :EventType, :DeviceID, :PendantRxLevel, :LowBattery, :TimeStamp )
                            ");
    try
    {
        $statement->execute($params);
        return $db->lastInsertId();
    }
    catch(PDOException $e)
    {
        exit("Failed to insert row: " . $e->getMessage() );
    }
}

// Update device status
function update_status($db, $vars)
{
    $statement = $db->prepare("
                    UPDATE `device_status` SET `EventType` = :event_type, `TimeStamp` = :time_stamp
					WHERE DeviceID = :device_id
					AND BaseName = :base_name
                ");
    $params = [
		'device_id' => $vars['DeviceID'],
		'base_name' => $vars['BaseName'],
		'event_type' => $vars['EventType'],
		'time_stamp' => $vars['TimeStamp']
    ];
    try
    {
        $statement->execute($params);
        return true;
    }
    catch(PDOException $e)
    {
        exit("Failed to update status: " . $e->getMessage() );
    }
}

function deviceExist($db, $data)
{
	$stmt = $db->prepare('SELECT * FROM device_status WHERE DeviceID = :deviceId AND BaseName = :baseName');
	$stmt->bindParam(":deviceId", $data['DeviceID']);
	$stmt->bindParam(":baseName", $data['BaseName']);
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	if(!$row)
	{
		return false;
	}
	return true;
}

// create mysql sensor query file to use in prtg
function generateQueryFile($path, $device_id = null)
{
	chmod($path, 0755);
	$customSensorPath = $path . '/single_device_' . $device_id . '.sql';
	$handle = fopen($customSensorPath, 'a') or die('Cannot open file:  '.$customSensorPath);
	$data = 'SELECT DeviceID,
			CASE
				WHEN EventType = "Normal" THEN 0
				WHEN EventType = "Alarm" THEN 1
				ELSE 0
			END as EventType
		FROM
			device_status 
		WHERE
			DeviceID = "' .$device_id . '";';
	fwrite($handle, $data);
	fclose($handle);
}

function createPrtgSensor()
{
	// sensor name
	// database_info
	// SQL Query File
	// Data Processing - process data table
		// Select Channel Value by - ColumnName
		// Sensor Channel #1 Name
		// Sensor Channel #1 Column Number
		// Sensor Channel #1 Unit - ValueLookup
			//Sensor Channel #1 Value  - oid.paessler.device_status.status.ovl|oid.paessler.device_status.status.ovl	
}



function buildCsvArray($file)
{
    $csv_array = [];
    
        if(($handle = fopen($file, 'r')) !== FALSE) {
            // necessary if a large csv file
            set_time_limit(0);
            $header = fgetcsv($handle, 1000);
            $header_colcount = count($header);
            $rowcount = 0;
            while(($row = fgetcsv($handle, 1000, ',')) !== FALSE)
            {
                $row_colcount = count($row);
                if ($row_colcount == $header_colcount)
                {
                    $entry = array_combine($header, $row);
                    $csv_array[] = $entry;
                }
               $rowcount++;
            }
            fclose($handle);
        }
    return $csv_array;
}

// curl calls
function _vodiapbx_curl_call($method, $url, $header=null, $params = null)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	if(!empty($header))
	{
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	}
    
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    //curl_setopt($ch, CURLOPT_COOKIESESSION, TRUE);
    if ($method == 'POST'){
        curl_setopt($ch, CURLOPT_POST, TRUE);
    }
    if (! empty($params))
    {
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $output = curl_exec($ch);
    if(curl_errno($ch))
    {
        var_dump(curl_getinfo($ch));
        echo curl_errno($ch) . "\n";
        echo 'error:' . curl_er;
    }
    else
    {
        //var_dump(curl_getinfo($ch));
        //print_r($output);
        curl_close($ch);
        return trim($output);
    }
}