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
include_once('classes/class.analytic.php');
include_once('classes/class.date.php');
$Analytic = new Analytic();

// p is $page and sp is page1
switch ($page1) {

	case 'ajax':
	
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
			if ($_POST["action"] == 'sensors' && !empty($_POST["basename"]))
        	{	
        		$sensors = $Analytic->ArrayDeviceSensors($_POST["basename"]);
        		$PAGE_TITLE = 'json';
        		$PAGE_CONTENT = $sensors;	
        	}
        }
		
        if ($page2 && $page2 == "get")
        {
        	$device_count = $Analytic->countDevice();
        	
			$total_num_accounts = count($Analytic->Acc_getAll());
			$PAGE_TITLE = 'json';
			$PAGE_CONTENT = [
				"alerts" => $device_count['alerts'],
				"noalerts" => $device_count['noalerts'],
				"devices" => $device_count['devices'],
				"pbx_accounts"=>$total_num_accounts
			];
        }
        $plugin_template = 'plugins/analytic/template/json.php';
	break;

    case 'dev_rep':
        $PAGE_TITLE = "Device Report";
        $SECTION_TITLE = "Device Report";
        $devices_arr = $Analytic->ArrayDevicesBasenames();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' )
        {
            $JAK_FORM_DATA = $dates = $_POST;

            if (empty($JAK_FORM_DATA['base_name']))
                $errors['e1'] = "Please select device.";

            if (!empty($dates['start_date']))
                $finalfrom = strtotime($dates['start_date']);
            
            if (!empty($dates['end_date']))
                $finalto = strtotime($dates['end_date']);
            
            if (isset($finalto) && isset($finalfrom) && $finalto < $finalfrom)
                $errors['e2'] = $tl['error']['e28'];

            if (count($errors) == 0)
            {
                $data["base_name"] = $JAK_FORM_DATA['base_name'];
		    	$data["device_id"] = $JAK_FORM_DATA['device_id'];
		    	$data["start_date"] = $JAK_FORM_DATA['start_date'];
		    	$data["end_date"] = $JAK_FORM_DATA['end_date'];

                if (!empty($JAK_FORM_DATA['graph_type']))
                {
                    if ($JAK_FORM_DATA['graph_type'] == "response")
                    $response_time_graph = $Analytic->DeviceResponseGraph($data);
                
                    if ($JAK_FORM_DATA['graph_type'] == "total")
                        $total_alarm_graph = $Analytic->DeviceAlarmTotalGraph($data);
                }
				if(!empty($data["base_name"]))
				{
					$sensors = $Analytic->ArrayDeviceSensors($data["base_name"]);
				}
                $report = $Analytic->DeviceAlaramReport($data);
            }
            else
            {
                $errors['e'] = $tl['error']['e'];
                $errors = $errors;
            }
        }
        $plugin_template = 'plugins/analytic/template/'.$jkv["sitestyle"].'/dev_rep.php';
    break;

    case'filter':
        $PAGE_TITLE = "CDR Call Filter";
        $SECTION_TITLE = "CDR Call Filter";
        //SECTION_DESC = $row['content'];
        
        $accounts = $Analytic->Acc_getAll();

        $dates['start_date'] = date('Y-m-d', strtotime(date('Y-m-d') . '-1 month'));
        $dates['end_date'] = date('Y-m-d');

        if ($page3 && $account = $Analytic->Acc_get(['id'=>$page3]) )
            $JAK_FORM_DATA=$account;
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $JAK_FORM_DATA = $_POST;
            $dates = $_POST;
            if (!empty($dates['start_date']))
                $finalfrom = strtotime($dates['start_date']);
            
            if (!empty($dates['end_date']))
                $finalto = strtotime($dates['end_date']);
            
            if (isset($finalto) && isset($finalfrom) && $finalto < $finalfrom)
                $errors['e2'] = $tl['error']['e28'];

            if (count($errors) == 0)
            {
                if (empty($account))
                    $account = $Analytic->Acc_get(['account'=>$_POST['account']]);

                $DateToUTC = new CastDate(null, $jkv["timezoneserver"], 'UTC');
                $JAK_FORM_DATA['start_date'] = $DateToUTC->cast($JAK_FORM_DATA['start_date'], 'F d, Y');
                $JAK_FORM_DATA['end_date'] = $DateToUTC->cast($JAK_FORM_DATA['end_date'], 'F d, Y');

                $table_data = $Analytic->cdrAccountdata($account['domain'], $JAK_FORM_DATA);
            }
        }

        $plugin_template = 'plugins/analytic/template/'.$jkv["sitestyle"].'/filter.php';

    break;

    case 'rep':
        $PAGE_TITLE = "CDR Report";
        $SECTION_TITLE = "CDR CallReport";
        $accounts = $Analytic->Acc_getAll();

        if ($page3 && $account = $Analytic->Acc_get(['id'=>$page3]) )
            $JAK_FORM_DATA=$account;

        $dates['start_date'] = date('Y-m-d', strtotime(date('Y-m-d') . '-1 month'));
        $dates['end_date'] = date('Y-m-d');

        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $JAK_FORM_DATA = $_POST;
            $dates = $_POST;
            if (!empty($dates['start_date']))
                $finalfrom = strtotime($dates['start_date']);
            
            if (!empty($dates['end_date']))
                $finalto = strtotime($dates['end_date']);
            
            if (isset($finalto) && isset($finalfrom) && $finalto < $finalfrom)
                $errors['e2'] = $tl['error']['e28'];
            
            if (count($errors) == 0)
            {
                if (empty($account))
                    $account = $Analytic->Acc_get(['account'=>$_POST['account']]);

                $DateToUTC = new CastDate(null, $jkv["timezoneserver"], 'UTC');
                $JAK_FORM_DATA['start_date'] = $DateToUTC->cast($JAK_FORM_DATA['start_date'], 'F d, Y');
                $JAK_FORM_DATA['end_date'] = $DateToUTC->cast($JAK_FORM_DATA['end_date'], 'F d, Y');

                $graphData = $Analytic->cdrAccountCalls($account['domain'], $JAK_FORM_DATA);
            }
        }
        $plugin_template = 'plugins/analytic/template/' . $jkv["sitestyle"] .'/report.php';
    break;

	default:
		// Check if we have a language and display the right stuff
		$PAGE_TITLE = $jkv["devicetitle"];
		$PAGE_CONTENT = $jkv["devicedesc"];

		$PAGE_PASSWORD = $jkv["analytic_frontpassword"];
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

		$device_count = $Analytic->countDevice();
		$total_num_accounts = count($Analytic->Acc_getAll());

		$start_date =date('Y-m-d', strtotime(date('Y-m-d') . '-1 month'));
		$end_date = date('Y-m-d');
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$JAK_FORM_DATA = $_POST;
			if (!empty($JAK_FORM_DATA['start_date']))
			    $start_date = strtotime($JAK_FORM_DATA['start_date']);
			    
		    if (!empty($JAK_FORM_DATA['end_date']))
		    	$end_date = strtotime($JAK_FORM_DATA['end_date']);
		    
		    if (isset($end_date) && isset($start_date) && $end_date < $start_date)
		    {
		    	$errors['e2'] = $tl['error']['e28'];
		    }
		    else
		    {
		    	$start_date=date('Y-m-d', $start_date);
				$end_date=date('Y-m-d', $end_date);
		    }

		    if (count($errors) == 0)
		    {

		    }
		}
		else
		{
			$JAK_FORM_DATA['start_date'] = $start_date;
			$JAK_FORM_DATA['end_date'] = $end_date;
		}
		$g_data=$Analytic->date_alarms($start_date, $end_date);

		$plugin_template = 'plugins/analytic/template/'.$jkv["sitestyle"].'/analytic.php';
	break;
	
}
