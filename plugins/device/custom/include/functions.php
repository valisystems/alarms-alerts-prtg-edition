<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Get gallery(s) out the database
function jak_get_device($limit, $order, $where, $table_row, $ext_seo, $timeago)
{
	global $jakdb;
	global $jkv;

	if (empty($order)) {
		$order = 'timestamp ASC';
	}

	$jakdata = array();
    $result = $jakdb->query('SELECT * FROM '.DB_PREFIX.'device ORDER BY '.$order.' '.$limit);
    while ($row = $result->fetch_assoc()) {

    		$getTime = JAK_Base::jakTimesince($row['time'], $jkv["gallerydateformat"], $jkv["gallerytimeformat"], $timeago);

    		// There should be always a varname in categories and check if seo is valid
    		$seo = "";
    		if ($ext_seo) $seo = JAK_base::jakCleanurl($row['title']);

    		// Get the url
    		$parseurl = JAK_rewrite::jakParseurl(JAK_PLUGIN_VAR_GALLERY, 'p', $row['id'], $seo);

            // collect each record into $jakdata
            $jakdata[] = array('id' => $row['id'], 'catid' => $row['catid'], 'title' => $row['title'], 'paththumb' => $row['paththumb'], 'pathbig' => $row["pathbig"], 'created' => $getTime, 'hits' => $row['hits'], 'parseurl' => $parseurl);
           }

    return $jakdata;
}

// Get total from a table limited to permission
function jak_get_total_permission_device() {

	global $jakdb;
	$jaktotal = 0;
	$row = $jakdb->queryRow('SELECT COUNT(id) AS total FROM '.DB_PREFIX.'device');

	if ($row['total']) $jaktotal = $row['total'];
	return $jaktotal;
}


// create mysql sensor query file to use in prtg
 function jak_generate_query_file($path, $base_name, $device_id = null)
    {
        chmod($path, 0755);
        $filename = 'single_device_' . $base_name . '_' . $device_id . '.sql';
        $handle = fopen($path . $filename, 'a') or die('Cannot open file:  ' . $path . $filename);
        $data = '
        SELECT DeviceID,
                CASE
                    WHEN event_type = "Normal" THEN 0
                    WHEN event_type = "Alarm" THEN 1
                    ELSE 0
                END as event_type
            FROM
                device
            WHERE
                device_id = "' . $device_id . ' AND
                base_name = "' . $base_name . '";';
        @fwrite($handle, $data);
        fclose($handle);

        return $filename;
    }


?>