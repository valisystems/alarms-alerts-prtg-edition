<?php
include 'include/db.php';

// Check if this comes in JSON form:
if(isset($_SERVER["CONTENT_TYPE"]) && $_SERVER["CONTENT_TYPE"] == "application/json")
{
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

    if($mysqli->connect_errno)
        exit("Connect failed: " . $mysqli->connect_error);

    $json = json_decode(file_get_contents("php://input"));
    //$fp = fopen('data.txt', 'w');
    //fwrite($fp, print_r($json, true));

    if($json->action == "call-data-record")
    {
        // Check if the request comes from the expected IP address:
        /*
         * $system = $mysqli->real_escape_string($json->System);
         * $remote = $_SERVER["REMOTE_ADDR"];
         * $result = $mysqli->query("SELECT * FROM system WHERE code='$system' AND adr='$remote'");
         * if($result == FALSE || $result->num_rows != 1) exit("System not found or request from wrong IP address");
         */
        $json->intl_call = 'Not a international call';
        // Add rates to call outbound calls
        if ($json->Direction === 'O')
        {}

        $query = sprintf("INSERT INTO ".DB_PREFIX."cdr (sys, primarycallid, callid, cid_from, cid_to, direction, remoteparty, localparty, trunkname, trunkid, cost, cmc, domain, timestart, timeconnected, timeend, ltime, durationhhmmss, duration, recordlocation, type, extension, idleduration, ringduration, holdduration, ivrduration, accountnumber, ipadr, intl_call)
                    values ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s', '%s')",
            $mysqli->real_escape_string($json->System),
            $mysqli->real_escape_string($json->PrimaryCallID),
            $mysqli->real_escape_string($json->CallID),
            $mysqli->real_escape_string($json->From),
            $mysqli->real_escape_string($json->To),
            $mysqli->real_escape_string($json->Direction),
            $mysqli->real_escape_string($json->RemoteParty),
            $mysqli->real_escape_string($json->LocalParty),
            $mysqli->real_escape_string($json->TrunkName),
            (int)$mysqli->real_escape_string($json->TrunkID),
            $mysqli->real_escape_string($json->Cost),
            $mysqli->real_escape_string($json->CMC),
            $mysqli->real_escape_string($json->Domain),
            $mysqli->real_escape_string($json->TimeStart),
            $mysqli->real_escape_string($json->TimeConnected),
            $mysqli->real_escape_string($json->TimeEnd),
            $mysqli->real_escape_string($json->LocalTime),
            $mysqli->real_escape_string($json->DurationHHMMSS),
            $mysqli->real_escape_string($json->Duration),
            $mysqli->real_escape_string($json->RecordLocation),
            $mysqli->real_escape_string($json->Type),
            $mysqli->real_escape_string($json->Extension),
            (int)$mysqli->real_escape_string($json->IdleDuration),
            (int)$mysqli->real_escape_string($json->RingDuration),
            (int) $mysqli->real_escape_string($json->HoldDuration),
            (int)$mysqli->real_escape_string($json->IvrDuration),
            $mysqli->real_escape_string($json->AccountNumber),
            $mysqli->real_escape_string($json->IPAdr),
            $mysqli->real_escape_string($json->intl_call));
        $mysqli->query($query);
    }
  //fwrite($fp, $query);
  //fclose($fp);
}




?>
