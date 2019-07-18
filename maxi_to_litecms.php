<?php


if(file_get_contents('php://input'))
{
    //$maxiJson = '{"maxivox_address":"000010120130003", "DeviceType":"HUMMINGBIRD WAY","DeviceLabel":"2013", "acknowledge":"1"}';
    //$maxi_json = json_decode($maxiJson, true);
    $maxi_json = json_decode(file_get_contents('php://input'), true);

	if (!empty(substr($maxi_json["maxivox_address"], -4)) 
        && (substr($maxi_json["maxivox_address"], -4) == '0053' 
                || substr($maxi_json["maxivox_address"], -4) == '0003')
        )
	{
		$maxi_json["status"] = "Alarm";
	}
    elseif(substr($maxi_json["maxivox_address"], -4) == '0002')
    {
        $maxi_json["status"] = "Normal";
    }
	else
	{
		$maxi_json["status"] = "Normal";
	}

	$params = [
				"BaseName" =>  substr($maxi_json["maxivox_address"], 0, -8), // get last 4 char
				"DeviceID" => $maxi_json["DeviceLabel"],
				"DeviceType" => $maxi_json["DeviceType"] .' - '. $maxi_json["maxivox_address"],
			    "EventType" => $maxi_json["status"],
				"AntennaInt" => "0", 
				"PendantRxLevel" => "0",
				"LowBattery" => "false", 
				"TimeStamp" => date("YmdHis")
	        ];
    //var_dump($params);

    $url = "http://173.231.102.85:8000/index.php?p=device&sp=ajax&ssp=signalupdate&auth=123888";
    $url = "http://173.231.102.85:8000/index.php?p=device&sp=catch";
	//curlRequest($url, "POST", $params);
}

//******** Functions *********//
function curlRequest($url, $method, array $data)
{                                         
	$data_string = json_encode($data);                              
	$ch = curl_init($url);                                       
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array( 
	    'Content-Type: application/json',
	    'Content-Length: ' . strlen($data_string)) 
	);

	$result = curl_exec($ch);
}

// Insert New row
function insert($db, $params)
{
    $statement = $db->prepare("
                                INSERT INTO `cms_device` ( base_name, device_id, device_type, event_type, antenna_int, pendant_rx_level, low_battery, time_stamp )
                                VALUES (:BaseName, :DeviceID, :DeviceType, :EventType, :AntennaInt, :PendantRxLevel, :LowBattery, :TimeStamp)
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