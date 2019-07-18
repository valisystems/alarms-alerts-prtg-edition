<?php

/**
* []
*/
class CDR
{
	public $conn;

	public function __construct()
	{
		global $jakdb;
		$this->conn = $jakdb;
	}

	public function insert(array $var)
	{
		$result = $this->conn->query('INSERT INTO cms_cdr SET
						`timestart` = "'.smartsql($data['TimeStart']).'",
						`timeconnected` = "'.smartsql($data['TimeConnected']).'",
						`timeend`  = "'.smartsql($data['TimeEnd']).'",
						`domain` = "'.smartsql($data['Domain']).'",
						`durationhhmmss` = "'.smartsql($data['DurationHHMMSS']).'",
						`duration` = "'.smartsql($data['Duration']).'",
						`type` = "'.smartsql($data['Type']).'",
						`cost` = "'.smartsql($data['Cost']).'",
						`direction` = "'.smartsql($data['Direction']).'",
						`ltime` = "'.smartsql($data['LocalTime']).'",
						`remoteparty` = "'.smartsql($data['RemoteParty']).'",
						`localparty`  = "'.smartsql($data['LocalParty']).'",
						`cid_from`  = "'.smartsql($data['From']).'",
						`cid_to`  = "'.smartsql($data['To']).'",
						`extension`  = "'.smartsql($data['Extension']).'",
						`trunkname` = "'.smartsql($data['TrunkName']).'",
						`trunkid`  = "'.smartsql($data['TrunkID']).'",
						`cmc`  = "'.smartsql($data['CMC']).'",
						`recordlocation`  = "'.smartsql($data['RecordLocation']).'",
						`primarycallid`  = "'.smartsql($data['PrimaryCallID']).'",
						`idleduration`  = "'.smartsql($data['IdleDuration']).'",
						`ringduration`  = "'.smartsql($data['RingDuration']).'",
						`holdduration`  = "'.smartsql($data['HoldDuration']).'",
						`ivrduration`  = "'.smartsql($data['IvrDuration']).'",
						`accountnumber`  = "'.smartsql($data['AccountNumber']).'",
						`ipadr`  = "'.smartsql($data['IPAdr']).'",
						`sys`  = "'.smartsql($data['System']).'",
						`callid`  = "'.smartsql($data['CallID']).'",
						`intl_call`  = "'.smartsql($data['intl_call']).'"'
						);
        if (!$result)
        {
			return false;
		}
		return $this->conn->jak_last_id();
	}

	public function getAll()
	{
		$cdr = [];
	    $result = $this->conn->query('SELECT * FROM cms_cdr ORDER BY timestart DESC; ');
	    $rows = [];
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        if (!empty($rows))
            return $rows;
        else
            return false;
	}

	public function getCdrs($table, $sort, $order, $limit)
	{
		$sqlwhere = '';
		$jakdata = array();
	    $result = $this->conn->query('SELECT * FROM '.$table.' '.$sqlwhere.'ORDER BY ' . $sort .' '. $order . ' ' .$limit);
	    while ($row = $result->fetch_assoc()) {
	            // collect each record into $_data
	            $jakdata[] = $row;
	        }
	    return $jakdata;
	}

	
}