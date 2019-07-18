<?php

/*===============================================*\
|| ############################################# ||
|| # claricom.ca                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 claricom All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

class JAK_device {

	public $conn;

	public function __construct()
	{
		global $jakdb;
		$this->conn = $jakdb;
        include_once('SFTP/SFTP.php');
	}
	
	// Get News out the database
	public function jak_get_device($where) {
	
		$sql_query  = " SELECT * FROM ".DB_PREFIX."device ";
		
		if(!empty($where) && !empty($where['q']))
		{
			$sql_query .= "WHERE ( ";
			$sql_query .= " base_name LIKE '%".smartsql($where['q'])."%'  OR";
			$sql_query .= " device_id LIKE'%".smartsql($where['q'])."%' ";
			$sql_query .= ") ";
		}
		
		$sql_query .=  ' ORDER BY event_type ASC ' ; 

		$jakdata = [];
		$result = $this->conn->query($sql_query);
		$rows = [];
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        if (!empty($rows))
            return $rows;
        else
            return false;
	}

	// Get total from a table
	public function jak_get_device_total($query)
	{
		$sql_query  = " SELECT COUNT(*) as totalAll FROM ".DB_PREFIX."device ";
		if(!empty($where)&& !empty($where['q']))
		{
			$sql_query .= "WHERE ( ";
			$sql_query .= " base_name LIKE '%".smartsql($where['q'])."%'  OR";
			$sql_query .= " device_id LIKE'%".smartsql($where['q'])."%' ";
			$sql_query .= ") ";
		}
		$row = $this->conn->query($sql_query);
		$result = $row->fetch_assoc();
		return $result['totalAll'];
	}
	
	public function insert($data)
	{
		$result = $this->conn->query('INSERT INTO '.DB_PREFIX.'device SET
                			device_id = "'.smartsql($data['DeviceID']).'",
                            base_name = "'.smartsql($data['BaseName']).'",
                			device_type = "'.smartsql($data['DeviceType']).'",
                            event_type = "'.smartsql($data['EventType']).'",
                            antenna_int = "'.smartsql($data['AntennaInt']).'",
                            pendant_rx_level = "'.smartsql($data['PendantRxLevel']).'",
                            low_battery = "'.smartsql($data['LowBattery']).'",
                            time_stamp = "'.smartsql($data['TimeStamp']).'",
                            prtg_url = "'.smartsql($data['prtg_url']).'",
							last_prompted = "'.date('Y-m-d H:i:s').'",
                			time = "'.date('Y-m-d H:i:s').'"');
        if (!$result)
        {
			return false;
		}
		return $this->conn->jak_last_id();
	}

	public function update($data)
	{
		$result = $this->conn->query('UPDATE '.DB_PREFIX.'device SET
            			device_type = "'.smartsql($data['DeviceType']).'",
						event_type = "'.smartsql($data['EventType']).'",
						antenna_int = "'.smartsql($data['AntennaInt']).'",
						pendant_rx_level = "'.smartsql($data['PendantRxLevel']).'",
						low_battery = "'.smartsql($data['LowBattery']).'",
						last_prompted = "'.date('Y-m-d H:i:s').'",
						time_stamp = "'.smartsql($data['TimeStamp']).'"
            			WHERE device_id = "'.smartsql($data['DeviceID']).'"
            			AND base_name =  "'.smartsql($data['BaseName']).'"
            			');

		if(!$result)
		{
			return false;
		}
		return true;
	}

	public function signalupdate($data)
	{
		$result = $this->conn->query('UPDATE '.DB_PREFIX.'device SET
            			device_type = "'.smartsql($data['DeviceType']).'",
						event_type = "'.smartsql($data['EventType']).'",
						antenna_int = "'.smartsql($data['AntennaInt']).'",
						pendant_rx_level = "'.smartsql($data['PendantRxLevel']).'",
						low_battery = "'.smartsql($data['LowBattery']).'",
						last_prompted = "'.date('Y-m-d H:i:s').'",
						time_stamp = "'.smartsql($data['TimeStamp']).'"
            			WHERE device_id = "'.smartsql($data['DeviceID']).'"
            			AND base_name =  "'.smartsql($data['BaseName']).'"
            			');

		if(!$result)
		{
			return false;
		}
		return true;
	}

	public function getList()
	{
		$deviceList = [];
	    $result = $this->conn->query('SELECT * FROM '.DB_PREFIX.'device');
	    while ($row = $result->fetch_assoc()) {
			$deviceList[] = $row;
	    }
	    if (!empty($deviceList)) return $deviceList;
	}

    public function editFormDevice($data)
    {
        $stmt = $this->conn->query('SELECT * FROM '.DB_PREFIX.'device WHERE device_id = "' . $data["DeviceID"] . '" AND base_name = "' . $data["BaseName"] . '" ;');
        $row = $stmt->fetch_assoc();
        if ($row) {
            return $this->editForm($row);
        }
        return false;
    }

	public function deleteByDeviceId($data)
	{
		$result = $this->conn->query('DELETE FROM '.DB_PREFIX.'device WHERE device_id = "' . $data["DeviceID"] . '" AND base_name = "' . $data["BaseName"] . '" ;');
		if(!$result)
		{
			return false;
		}
		return true;
	}

	public function deviceExist($data)
	{
		$stmt = $this->conn->query('SELECT * FROM '.DB_PREFIX.'device WHERE device_id = "' . $data["DeviceID"] . '" AND base_name = "' . $data["BaseName"].'"; ');
		$row = $stmt->fetch_assoc();
		if(!$row)
		{
			return false;
		}
		return true;
	}

	public function changeEventType($action, $data)
	{
		$query ='';
	    if ($action == 'single_alarm' && !empty($data['DeviceID']) && !empty($data['BaseName']) )
	    {
	        $query = "UPDATE " . DB_PREFIX . "device SET event_type='".smartsql($data['EventType'])."' WHERE base_name = '" .$data['BaseName']. "' AND device_id = '" . $data['DeviceID'] . "';" ;
	    }
	    elseif ($action == 'cancel_all') {
	        $query = "UPDATE " . DB_PREFIX . "device SET event_type='".smartsql($data['EventType']). "';" ;
	    }
	    $result = $this->conn->query($query);
	    if($result)
	    {
	        return $result;
	    }
	    return false;
	}

	public function prtg_query($action, $data)
    {
        $stmt = $this->conn->query('SELECT * FROM '.DB_PREFIX.'device WHERE device_id = "' . $data["deviceid"] . '" AND base_name = "' . $data["basename"].'"; ');
        $row = $stmt->fetch_assoc();
        if(!$row)
        {
            return false;
        }
        return $row;
    }
	
	public function prtg_status_all_devices()
    {
		$deviceList = [];
	    $result = $this->conn->query('SELECT base_name, device_id, event_type AS status FROM '.DB_PREFIX.'device; ');
	    while ($row = $result->fetch_assoc()) {
			$deviceList[] = $row;
	    }
	    if (!empty($deviceList)) return $deviceList;
    }

    // Get list of files
    public function getQueryFiles($directory,$exempt = array('.','..','.ds_store','.svn','preview.jpg','index.html','js','css','img','_cache'),&$files = array())
    {
        if (empty($directory) || !file_exists($directory)) {
            return [];
        }
        $handle = opendir($directory);
        while(false !== ($resource = readdir($handle))) {
            if(!in_array(strtolower($resource),$exempt)) {
                if(is_dir($directory.$resource)) {
                    array_merge($files, getFiles($directory.$resource,$exempt,$files));
                } else {
                    if (is_writable($directory.$resource)) {
                        $files[] = array('path' => $directory . $resource,'name' => $resource);
                    }
                }
            }
        }
        closedir($handle);
        return $files;
    }

    // create mysql sensor query file to use in prtg
    public function generateQueryFile($path, $data)
    {
        chmod($path, 0755);
        $filename = 'single_device_' . $data["BaseName"] . '_' . $data["DeviceID"] . '.sql';

		if (!file_exists($path . $filename))
	    {

	        $handle = fopen($path . $filename, 'a') or die('Cannot open file:  ' . $path . $filename);
	        $data = 'SELECT device_id,
	                CASE
	                    WHEN event_type = "Normal" THEN 0
	                    WHEN event_type = "Alarm" THEN 1
	                    ELSE 0
	                END as event_type
	            FROM
	                device
	            WHERE
	                device_id = "' . $data['DeviceID'] . '"
	                AND base_name = "'. $data['BaseName'] . '";';
	        @fwrite($handle, $data);
	        fclose($handle);
		}
        return $path.$filename;
    }

    public function deleteQueryFile($path, $filename)
    {
        @unlink($path . $filename);
    }

	public function createForm()
	{
		$output ='
			<form id="formoid" action="/index.php?p=device&sp=ajax&ssp=insert"  method="POST">
					<div class="form-group">
						<div class="row">
							<div class="col-sm-5">
								<label class="title control-label" >BaseName</label>
								<input type="text" id="BaseName" class="form-control" value="miPos_630114" name="BaseName" />
							</div>
							<div class="col-sm-5">
								<label class="title control-label">DeviceID</label>
								<input type="text" id="DeviceID" class="form-control"  value="AB00189" name="DeviceID" />
							</div>
						</div>
						<div class="row">
							<div class="col-sm-5">
								<label class="title control-label">DeviceType</label>
								<input type="text" id="DeviceType" class="form-control" value="pull" name="DeviceType" />
							</div>
							<div class="col-sm-5">
								<label class="title control-label">EventType</label>
								<input type="text" id="EventType" class="form-control" value="Alarm" name="EventType" >
							</div>
						</div>
						<div class="row">
							<div class="col-sm-5">
								<label class="title control-label">LowBattery</label>
								<input type="text" id="LowBattery" class="form-control" value="false" name="LowBattery" >
							</div>
							<div class="col-sm-5">
								<label class="title control-label">TimeStamp</label>
								<input type="text" id="TimeStamp" class="form-control" value="2016031113053" name="TimeStamp" >
							</div>
						</div>
						<div class="row">
							<div class="col-sm-5">
								<label class="title control-label">AntennaInt</label>
								<input type="text" id="AntennaInt" class="form-control" value="0" name="AntennaInt" >
							</div>
							<div class="col-sm-5">
								<label class="title control-label">PendantRxLevel</label>
								<input type="text" id="PendantRxLevel" class="form-control" value="0" name="PendantRxLevel" >
							</div>
						</div>
					</div>

					<div class="form-group">
						<input type="submit" id="submitButton" class="btn btn-primary"  name="submitButton" value="Submit">
					</div>
			 </form>
		';

		return $output;
	}

	public function editForm($data)
	{
		$output ='
			<form id="formoid" action="/index.php?p=device&sp=ajax&ssp=update"  method="POST">
				<input type="hidden" id="id" name="id" value=' . $data["id"] . ' />
					<div class="form-group">
						<div class="row">
							<div class="col-sm-5">
								<label class="title control-label" >DeviceID</label>
								<input type="text" id="DeviceID" readonly="readonly" class="form-control" value=' . $data["device_id"] . ' name="BaseName" />
							</div>
							<div class="col-sm-5">
								<label class="title control-label" >BaseName</label>
								<input type="text" id="BaseName" readonly="readonly" class="form-control" value=' . $data["base_name"] . ' name="BaseName" />
							</div>
						</div>
						<div class="row">
							<div class="col-sm-5">
								<label class="title control-label">DeviceType</label>
								<input type="text" id="DeviceType" class="form-control" name="DeviceType" value=' .   $data["device_type"] . ' />
							</div>
							<div class="col-sm-5">
								<label class="title control-label">EventType</label>
								<input type="text" id="EventType" class="form-control" name="EventType" value=' .   $data["event_type"] . ' />
							</div>
						</div>
						<div class="row">
							<div class="col-sm-5">
								<label class="title control-label">LowBattery</label>
								<input type="text" id="LowBattery" class="form-control"  name="LowBattery" value=' . $data["low_battery"]. ' />
							</div>
							<div class="col-sm-5">
								<label class="title control-label">TimeStamp</label>
								<input type="text" id="TimeStamp" class="form-control"  name="TimeStamp" value=' .   $data["time_stamp"] . ' />
							</div>
						</div>
						<div class="row">
							<div class="col-sm-5">
								<label class="title control-label">AntennaInt</label>
								<input type="text" id="AntennaInt" class="form-control" name="AntennaInt" value=' .   $data["antenna_int"] . ' />
							</div>
							<div class="col-sm-5">
								<label class="title control-label">PendantRxLevel</label>
								<input type="text" id="PendantRxLevel" class="form-control" name="PendantRxLevel" value=' .   $data["pendant_rx_level"] . ' />
							</div>
						</div>
					</div>

					<div class="form-group">
						<input type="submit" id="submitButton" class="btn btn-primary"  name="submitButton" value="Submit">
					</div>
			 </form>
		';
		return $output;
	}

	public function ftpFilework($settings, $file = null, $data, $action)
    {
        // set SFTP object, use host, username and password
        $ftp = new SFTP($settings["deviceprtgftphost"], $settings["deviceprtgftpuser"], $settings["deviceprtgftppassword"]);
        if($ftp->connect())
        {
            if ($action == 'put' && !empty($file))
            {
                $filename = 'single_device_' . $data['BaseName'] . '_' . $data['DeviceID'] . '.sql';
                if($ftp->put($file, $filename))
                {
                    print "Filed uploaded";
                }
            }
            if ($action == 'del')
            {
                $filename = 'single_device_' . $data['BaseName'] . '_' . $data['DeviceID'] . '.sql';
                // delete file "remote.php"
                $ftp->delete($filename);
            }

        }
    }


}

