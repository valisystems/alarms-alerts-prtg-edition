<?php

/**
* 
*/
class DefaultConfig
{
    public $conn;
    public function __construct()
    {
        global $jakdb;
        $this->conn = $jakdb;
    }

        // Get News out the database
    public function getAll()
    {
        $sql_query  = " SELECT * FROM ".DB_PREFIX."device_default_config ";

        $jakdata = [];
        $result = $this->conn->query($sql_query);
        while ($row = $result->fetch_assoc()) {
            $jakdata[] = $row;
        }
        if (!empty($jakdata)) return $jakdata;
    }


    public function get($data)
    {
        $mysql_query = 'SELECT * FROM '.DB_PREFIX.'device_default_config ';
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
    
    public function insert($data)
    {
        $result = $this->conn->query('INSERT INTO '.DB_PREFIX.'device_default_config SET
                            device_type = "'.smartsql($data['device_type']).'",
                            default_config_data = "'.smartsql($data['default_config_data']).'",
                            config_file_type = "'.smartsql($data['config_file_type']).'"');
        if (!$result)
        {
            return false;
        }
        return $this->conn->jak_last_id();
    }

    public function update($data)
    {
        $result = $this->conn->query('UPDATE '.DB_PREFIX.'device_default_config SET
                        default_config_data = "'.smartsql($data['default_config_data']).'",
                        config_file_type = "'.smartsql($data['config_file_type']).'"
                        WHERE id =  "'.smartsql($data['id']).'"
                        AND device_type =  "'.smartsql($data['device_type']).'"
                    ');

        if(!$result)
        {
            return false;
        }
        return true;
    }

    public function del($id)
    {
        $result = $this->conn->query('DELETE FROM '.DB_PREFIX.'device_default_config WHERE
                        id = "'.smartsql($id).'"
                    ');

        if(!$result)
        {
            return false;
        }
        return true;
    }


}
