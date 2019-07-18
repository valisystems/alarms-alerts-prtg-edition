<?php

class Analytic 
{
    public $conn;
    public $settings;
    public function __construct()
    {
        global $jkv;
        global $jakdb;
        $this->conn = $jakdb;
        $this->settings = $jkv;
    }

    public function Settings($data)
    {
        $fields = [ "analytic_title", "analytic_desc", "analytic_dateformat", "analytic_timeformat", 
                    "analytic_pbxhost", "analytic_pbxport", "analytic_pbxusername", "analytic_pbxpassword", "analytic_frontpassword" ];
        
        $mysql_query = 'UPDATE '.DB_PREFIX.'setting SET value = CASE varname ';

        foreach ($data as $k => $value)
        {
            if (in_array($k, $fields))
                $mysql_query .= 'WHEN "'.$k.'" THEN "'.smartsql($value).'" ';
        }

        $mysql_query .= "END WHERE varname IN ( ";
        $last_field = end($fields);
        foreach ($fields as $field)
        {
            if ($last_field == $field) 
                $mysql_query .=  '"'. $field . '" ';
            else
                $mysql_query .=  '"'. $field . '", ';
        }
        $mysql_query .= " ) ";

        $result = $this->conn->query($mysql_query);
        return $result;
    }

    // get all accounts
    public function Acc_getAll($data=null, $order=null, $limit=null)
    {
        $mysql_query = 'SELECT * FROM '.DB_PREFIX.'analytic_account ';
        if (!empty($data) && is_array($data)) 
        {
            $i=0;
            $mysql_query .= " WHERE ";
            foreach ($data as $col => $val)
            {
                if ($i==0)
                    $mysql_query .= $col . " = '" . $val ."'";
                else
                    $mysql_query .= " AND ".$col . " = '" . $val ."'";
                $i++;
            }
        }
        if (!empty($order))  $mysql_query .= " ORDER BY " . $order["sort"] . " " . $order["order"]; 
        if (!empty($limit))  $mysql_query .= " ".$limit;

        $mysql_query .= " ;";

        $rows=[];
        $result = $this->conn->query($mysql_query);
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function Acc_get($data)
    {
        $mysql_query = 'SELECT * FROM '.DB_PREFIX.'analytic_account ';
        if (!empty($data) && is_array($data)) 
        {
            $i=0;
            $mysql_query .= " WHERE ";
            foreach ($data as $col => $val)
            {
                if ($i==0)
                    $mysql_query .= $col . " = '" . $val ."'";
                else
                    $mysql_query .= " AND ".$col . " = '" . $val ."'";
                $i++;
            }
            $mysql_query .= " ;";

            $stmt = $this->conn->query($mysql_query);
            $row = $stmt->fetch_assoc();
            if ($row)
                return $row;
        }
        return [];
    }

    public function Acc_insert($data)
    {
        $id_line="";
        if (!empty($data["id"])) 
            $id_line = ' id = "'.smartsql($data['id']).'", ';
        $description_line="";
        if (!empty($data["description"])) 
            $description_line = ' description = "'.smartsql($data['description']).'", ';

        $result = $this->conn->query('INSERT INTO '.DB_PREFIX.'analytic_account SET
                            '.$id_line.$description_line.'
                            domain = "'.smartsql($data['domain']).'",
                            account = "'.smartsql($data['account']).'",
                            name = "'.smartsql($data['name']).'",
                            type = "'.smartsql($data['type']).'",
                            created_date = "'.date('Y-m-d H:i:s').'"');
        if (!$result)
            return false;
        return $this->conn->jak_last_id();
    }

    public function Acc_update($data)
    {
        $result =   $this->conn->query('UPDATE '.DB_PREFIX.'analytic_account SET
                        account = "'.smartsql($data['account']).'",
                        name = "'.smartsql($data['name']).'",
                        description = "'.smartsql($data['description']).'",
                        type = "'.smartsql($data['type']).'",
                        updated_date = "'.date('Y-m-d H:i:s').'"
                        WHERE id = "'.smartsql($data['id']).'"
                        AND domain =  "'.smartsql($data['domain']).'"
                    ');
        if(!$result)
            return false;
        return true;
    }

    public function Acc_del($id)
    {
        $mysql_query = 'DELETE FROM '.DB_PREFIX.'analytic_account ';
        $mysql_query .= " WHERE id=" . (int)$id ;    
        $mysql_query .= " ;";
        $result = $this->conn->query($mysql_query);
        if ($result)
            return true;
        
        return false;
    }

    public function Acc_delAll()
    {
        $mysql_query = 'DELETE FROM '.DB_PREFIX.'analytic_account;';
        $result = $this->conn->query($mysql_query);
        if ($result)
            return true;
        return false;
    }

    public function Acc_exist($data)
    {
        $fields = ["domain", "account"];
        $mysql_query = 'SELECT * FROM '.DB_PREFIX.'analytic_account ';
        if (!empty($data) && is_array($data)) 
        {
            $i=0;
            $mysql_query .= " WHERE ";
            foreach ($data as $col => $val)
            {
                if (in_array($col, $fields))
                {
                    if ($i==0)
                        $mysql_query .= $col . " = '" . $val ."'";
                    else
                        $mysql_query .= " AND " . $col . " = '" . $val ."'";
                    $i++;
                }
                
            }
            $mysql_query .= " ;";

            $stmt = $this->conn->query($mysql_query);
            $result = $stmt->fetch_assoc();
            if ($result)
                return false;
        }
        return true;
    }

    public function countDevice($data = null)
    {
        $mysql_query = 'SELECT count(`id`) AS `devices`, ';
        $mysql_query .= '(sum( case WHEN `event_type` = "Alarm" then 1 else 0 end))  AS `alerts`, ';
        $mysql_query .= '(sum( case WHEN `event_type` = "Normal" then 1 else 0 end))  AS `noalerts` ';
        $mysql_query .= ' FROM '.DB_PREFIX.'device ';

        if (!empty($data) && is_array($data)) 
        {
            $i=0;
            $mysql_query .= " WHERE ";
            foreach ($data as $col => $val)
            {
                if ($i==0)
                    $mysql_query .= $col . " = '" . $val ."'";
                else
                    $mysql_query .= " AND ".$col . " = '" . $val ."'";
                $i++;
            }
            $mysql_query .= " ;";
        }
        $stmt = $this->conn->query($mysql_query);
        $row = $stmt->fetch_assoc();
        if ($row)
            return $row;
        return [];

    }

    public function date_alarms($start_date, $end_date)
    {
        if (!empty($start_date) || !empty($end_date) ) 
        {
            $start_date = date('Y-m-d', strtotime($start_date));
            $end_date = date('Y-m-d', strtotime($end_date));
        }
        else
        {
            $start_date =date('Y-m-d', strtotime(date('Y-m-d') . '-1 month'));
            $end_date = date('Y-m-d');
        }

        $mysql_query = 'SELECT count(`id`) AS `count`, ';
        $mysql_query .= ' Date(`starttime`) AS `time_start` ';
        $mysql_query .= ' FROM '.DB_PREFIX.'alarm_trigger ';

        if (!empty($start_date) && !empty($end_date))
        {
            $mysql_query .= ' WHERE  (Date(`starttime`) BETWEEN "'.$start_date.'" AND "' . $end_date .'" )';
        }
        $mysql_query .=" GROUP BY CAST(`starttime` AS DATE) ;";

        $rows=[];
        $result = $this->conn->query($mysql_query);

        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        if ($rows)
        {
            $number_of_alerts = [];
            foreach ($rows as $k => $row)
            {
                $dateformat = '';
                $year = '';
                $month = '';
                $day = '';
                // In javascript - January is 0, February is 1. Subtracting one month
                //http://stackoverflow.com/questions/8058136/highcharts-data-series-issue-with-ajax-json-and-php
                $dateformat = strtotime($row["time_start"]);

                $year = date('Y', $dateformat);
                $month = date('m', $dateformat) - 1;
                $day = date('d', $dateformat);

                $number_of_alerts[] = [$dateformat*1000, (int)$row["count"]];
            }
            $data = [
                ['name' => 'Alerts', 'data' => $number_of_alerts ]
            ];
            return $data;
        }
        return [];
    }

    public function deviceStatic($data)
    {
        // SELECT *,
        // TIMESTAMPDIFF(HOUR, starttime, endtime) AS different
        // from cms_alarm_trigger
        // where base_name="miPos_630110"
        // AND device_id ="AB00180"
        // AND endtime != "0000-00-00 00:00:00"
        // AND ( starttime BETWEEN "2016-07-01" AND "2016-07-30")
        // group by CAST(starttime AS Date)
    }

    // Count missed and answered calls 
    // Note:
        // If caller cut before reciever cut it -  there is not ring duration
        // If reciever cut it there will be ring duration
    public function cdrAccountCalls($domain, $filter)
    {
        if (!empty($filter['start_date']) && !empty($filter['end_date'])) {
            $filter['start_date'] = date('Y-m-d', strtotime($filter['start_date']));
            $filter['end_date'] = date('Y-m-d', strtotime($filter['end_date']));
        }
        else
            return;

        $mysql_query = [];
        $mysql_query[] = "SELECT";
        $mysql_query[] = " Date(`timestart`) AS time_start, ";
        $mysql_query[] = " (sum( case WHEN `timeconnected` = '' then 1 else 0 end))  AS `missed`,";
        $mysql_query[] = " (sum( case WHEN `timeconnected` = '' then `ringduration` else 0 end))  AS `missed_ring`,";

        $mysql_query[] = " (sum( case WHEN `timeconnected` != '' then 1 else 0 end))  AS `answered`,";
        $mysql_query[] = " (sum( case WHEN `timeconnected` != '' then `ringduration` else 0 end))  AS `answered_ring`,";
        $mysql_query[] = " count(timestart) AS total_calls";
        $mysql_query[] = " FROM ".DB_PREFIX."cdr ";
        $mysql_query[] = " WHERE `domain` = '" . $domain . "' ";
        $mysql_query[] = " AND `localparty` = '" . $filter["account"] . "' ";
        $mysql_query[] = " AND ( Date(`timestart`) BETWEEN '" . $filter['start_date'] . "' AND '" . $filter['end_date'] . "' )";

        $mysql_query[] =" GROUP BY CAST(`timestart` AS DATE) ;";
        $mysql_query = implode("\n", $mysql_query);
        //var_dump($mysql_query);
        $rows=[];
        $result = $this->conn->query($mysql_query);
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        if (!empty($rows))
        {
            $missed = [];
            $answered = [];
            $total_calls = [];
            $per_day_answered_rings=[];
            $per_day_missed_rings=[];
            $sum_calls=[];
            foreach ($rows as $k => $row)
            {
                $dateformat = '';
                // In javascript - January is 0, February is 1. Subtracting one month
                //http://stackoverflow.com/questions/8058136/highcharts-data-series-issue-with-ajax-json-and-php
                $dateformat = strtotime($row["time_start"]);

                // Max per_day
                $per_day_missed_rings[] = (int)$row["missed_ring"];
                // Min calls per day
                $per_day_answered_rings[] = (int)$row["answered_ring"];
                // sum all the calls per day
                $sum_calls[] = (int)$row["total_calls"];

                $missed[] = [ $dateformat*1000, (int)$row["missed"]];
                $answered[] = [$dateformat*1000, (int)$row["answered"]];
                $total_calls[] = [$dateformat*1000, (int)$row["total_calls"]];
            }

            $data["per_day"]['max_missed_rings'] = ! empty($per_day_missed_rings) ? max($per_day_missed_rings) : 0;
            $data["per_day"]['min_missed_rings'] = ! empty($per_day_missed_rings) ? min($per_day_missed_rings) : 0;
            $data["per_day"]['max_answered_rings'] = ! empty($per_day_answered_rings) ? max($per_day_answered_rings) : 0;
            $data["per_day"]['min_answered_rings'] = ! empty($per_day_answered_rings) ? min($per_day_answered_rings) : 0;
            $data["sum_of_call_each_day"] = ! empty($sum_calls) ? array_sum($sum_calls) : 0;

            $data["graph_data"] = [
                ['name' => 'Missed', 'data' => $missed ],
                ['name' => 'Answered', 'data' => $answered ],
                ['name' => 'Total calls', 'data' => $total_calls ],
            ];
            return $data;
        }
        return [];
    }

    public function cdrAccountdata($domain, $filter)
    {
        if (!empty($filter['start_date']) && !empty($filter['end_date'])) {
            $filter['start_date'] = date('Y-m-d', strtotime($filter['start_date']));
            $filter['end_date'] = date('Y-m-d', strtotime($filter['end_date']));
        }
        else
            return;

        $mysql_query = [];
        $mysql_query[] = "SELECT * ";
        $mysql_query[] = " FROM ".DB_PREFIX."cdr ";
        $mysql_query[] = " WHERE `domain` = '" . $domain . "' ";
        $mysql_query[] = " AND `localparty` = '" . $filter["account"] . "' ";
        if (!empty($filter["call_type"]) && $filter["call_type"] == "missed") 
            $mysql_query[] = " AND `timeconnected` = '' ";

        if (!empty($filter["call_type"]) && $filter["call_type"] == "answered") 
            $mysql_query[] = " AND `timeconnected` != '' ";

        $mysql_query[] = " AND (Date(`timestart`) BETWEEN '" . $filter['start_date'] . "' AND '" . $filter['end_date'] . "')";

        $mysql_query = implode("\n", $mysql_query);

        $result = $this->conn->query($mysql_query);
        $rows = [];
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        if (!empty($rows))
            return $rows;
        else
            return false;
    }

    // *********************** Device analytic ***********************
    public function ArrayDevicesBasenames()
    {
        $mysql_query = [];
        $mysql_query[] = "SELECT * ";
        $mysql_query[] = " FROM ".DB_PREFIX."device ;";
        $mysql_query = implode("\n", $mysql_query);

        $result = $this->conn->query($mysql_query);

        $rows=[];
        $result = $this->conn->query($mysql_query);
        while ($row = $result->fetch_assoc()) {
            $rows[$row["base_name"]] = $row["base_name"];
        }
        return $rows;
    }
	
	public function ArrayDeviceSensors($basename)
    {
        $mysql_query = [];
        $mysql_query[] = "SELECT * ";
        $mysql_query[] = " FROM ".DB_PREFIX."device ";
        $mysql_query[] = " WHERE base_name='" . trim($basename). "' ;";
        $mysql_query = implode("\n", $mysql_query);

        $result = $this->conn->query($mysql_query);

        $rows=[];
        $result = $this->conn->query($mysql_query);
        while ($row = $result->fetch_assoc()) {
            $rows[$row["device_id"]] = $row["device_id"];
        }
        return $rows;
    }

    public function ArrayDevicesIds($basename)
    {
        $mysql_query = [];
        $mysql_query[] = "SELECT * ";
        $mysql_query[] = " FROM ".DB_PREFIX."device ";
        if (!empty($basename))
        {
            $mysql_query[] = " WHERE base_name='" . $basename. "' ;";
        }
        $mysql_query = implode("\n", $mysql_query);

        $result = $this->conn->query($mysql_query);

        $rows=[];
        $result = $this->conn->query($mysql_query);
        while ($row = $result->fetch_assoc()) {
            $rows[$row["base_name"] . "~" . $row["device_id"]] = $row["base_name"] . " - " . $row["device_id"];
        }
        return $rows;
    }


    public function DeviceAlaramReport($data)
    {
        if (!empty($data['start_date']) && !empty($data['end_date'])) {
            $data['start_date'] = date('Y-m-d', strtotime($data['start_date']));
            $data['end_date'] = date('Y-m-d', strtotime($data['end_date']));
        }
        else
            return;

        $mysql_query = [];
        $mysql_query[] = "SELECT * ";
        //$mysql_query[] = " TIMESTAMPDIFF(SECOND, `starttime`, `endtime`) AS response_time ";
        $mysql_query[] = " FROM ".DB_PREFIX."alarm_trigger ";

        $mysql_query[] = "WHERE endtime != '0000-00-00 00:00:00'";
        $mysql_query[] = " AND (`starttime` BETWEEN '" . $data["start_date"] . "' AND '" . $data["end_date"] . "')";
        
        if (!empty($data["base_name"]))
        {
            $mysql_query[] = " AND base_name='" . trim($data["base_name"]). "' ";
        }
        if (!empty($data["device_id"]))
        {
            $mysql_query[] = " AND device_id='" . trim($data["device_id"]). "' ";
        }
		$mysql_query[] = " ORDER BY starttime DESC";
        $mysql_query = implode("\n", $mysql_query);

        $result = $this->conn->query($mysql_query);
        $rows = [];
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        if (!empty($rows))
            return $rows;
        else
            return false;
    }

    // Avarage response time - Graph data
    public function DeviceResponseGraph($data)
    {
        if (!empty($data['start_date']) && !empty($data['end_date'])) {
            $data['start_date'] = date('Y-m-d', strtotime($data['start_date']));
            $data['end_date'] = date('Y-m-d', strtotime($data['end_date']));
        }
        else
            return [];

        $mysql_query[] = "SELECT Date(`starttime`) AS start_time, ";
        $mysql_query[] = " SUM(TIMESTAMPDIFF(SECOND, `starttime`, `endtime`)) AS response_time ";
        $mysql_query[] = ' FROM '.DB_PREFIX.'alarm_trigger ';
        $mysql_query[] = " WHERE endtime != '0000-00-00 00:00:00'";
        $mysql_query[] = " AND (`starttime` BETWEEN '" . $data["start_date"] . "' AND '" . $data["end_date"] . "')";
        if (!empty($data["base_name"]))
        {
            $mysql_query[] = " AND base_name='" . trim($data["base_name"]). "' ";
        }
        if (!empty($data["device_id"]))
        {
            $mysql_query[] = " AND device_id='" . trim($data["device_id"]). "' ";
        }

        $mysql_query[] =" GROUP BY CAST(`starttime` AS DATE) ;";
        $mysql_query = implode("\n", $mysql_query);

        $rows=[];
        $result = $this->conn->query($mysql_query);
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        if ($rows)
        {
            $response_time = [];
            foreach ($rows as $k => $row)
            {
                $dateformat = '';
                $year = '';
                $month = '';
                $day = '';
                // In javascript - January is 0, February is 1. Subtracting one month
                //http://stackoverflow.com/questions/8058136/highcharts-data-series-issue-with-ajax-json-and-php
                $dateformat = strtotime($row["start_time"]);

                $year = date('Y', $dateformat);
                $month = date('m', $dateformat) - 1;
                $day = date('d', $dateformat);

                $response_time[] = [$dateformat*1000, $row["response_time"]*1000];
            }
            $data = [
                ['name' => 'Response Time', 'data' => $response_time ]
            ];
            return $data;
        }
        return [];
    }

    public function DeviceAlarmTotalGraph($data)
    {
        if (!empty($data['start_date']) && !empty($data['end_date'])) {
            $data['start_date'] = date('Y-m-d', strtotime($data['start_date']));
            $data['end_date'] = date('Y-m-d', strtotime($data['end_date']));
        }
        else
            return [];

        $mysql_query[] = 'SELECT count(`id`) AS `count`, ';
        $mysql_query[] = ' Date(`starttime`) AS `time_start` ';
        $mysql_query[] = ' FROM '.DB_PREFIX.'alarm_trigger ';
        $mysql_query[] = " WHERE endtime != '0000-00-00 00:00:00'";
        $mysql_query[] = " AND (`starttime` BETWEEN '" . $data["start_date"] . "' AND '" . $data["end_date"] . "')";
        if (!empty($data["base_name"]))
        {
            $mysql_query[] = " AND base_name='" . trim($data["base_name"]). "' ";
        }
        if (!empty($data["device_id"]))
        {
            $mysql_query[] = " AND device_id='" . trim($data["device_id"]). "' ";
        }
        $mysql_query[] =" GROUP BY CAST(`starttime` AS DATE) ;";
        $mysql_query = implode("\n", $mysql_query);

        $rows=[];
        $result = $this->conn->query($mysql_query);
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        if ($rows)
        {
            $number_of_alerts = [];
            foreach ($rows as $k => $row)
            {
                $dateformat = '';
                $year = '';
                $month = '';
                $day = '';
                // In javascript - January is 0, February is 1. Subtracting one month
                //http://stackoverflow.com/questions/8058136/highcharts-data-series-issue-with-ajax-json-and-php
                $dateformat = strtotime($row["time_start"]);

                $year = date('Y', $dateformat);
                $month = date('m', $dateformat) - 1;
                $day = date('d', $dateformat);

                $number_of_alerts[] = [$dateformat*1000, (int)$row["count"]];
            }
            $data = [
                ['name' => 'Total Alarm', 'data' => $number_of_alerts ]
            ];
            return $data;
        }
        return [];
    }


}

?>