<?php
/*===============================================*\
|| ############################################# ||
|| # Claricom.ca                               # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 Claricom All Rights Reserved ||
|| ############################################# ||
\*===============================================*/
define("DS", DIRECTORY_SEPARATOR);
// Check if the file is accessed only via index.php if not stop the script from running
if (!defined('JAK_ADMIN_PREVENT_ACCESS')) die('You cannot access this file directly.');

// Check if the user has access to this file
if (!JAK_USERID || !$jakuser->jakModuleaccess(JAK_USERID,JAK_ACCESSDEVICE)) jak_redirect(BASE_URL);

// All the tables we need for this plugin
$jaktable_accts = DB_PREFIX.'analytic_accounts';
// Include the functions
include_once("../plugins/analytic/functions.php");
include_once('/../classes/class.analytic.php');
include_once('/../classes/class.date.php');
$Analytic = new Analytic();

//JAK_PLUGIN_Analytic
// Now start with the plugin use a switch to access all pages
switch ($page1) {

	case 'sync':
		include '/../classes/class.vodia.php';
		$SECTION_TITLE = "Sync all accounts from PBX to CMS";
        // Download all account to database
    	if ($_SERVER['REQUEST_METHOD'] == 'POST')
    	{
    		if ($_POST["action"] == 'clear_all_accounts')
    		{
    			$Analytic->Acc_delAll($accts['accounts']);
				//jak_redirect(BASE_URL.'index.php?p=analytic&sp=sync&ssp=e');
			    jak_redirect(BASE_URL.'index.php?p=analytic&sp=sync&ssp=s');
    		}
    		if ($_POST["action"] == 'syn_accounts')
    		{
    			if (empty($jkv["analytic_pbxhost"]))
			        $errors['e2'] = $tlanalytic["analytic"]["sye1"];
			    if (empty($jkv["analytic_pbxusername"]))
			        $errors['e2'] = $tlanalytic["analytic"]["sye2"];
			    if (empty($jkv["analytic_pbxpassword"]))
			        $errors['e4'] = $tlanalytic["analytic"]["sye3"];
			    if (empty($_POST["domain"]))
			        $errors['e4'] = $tlanalytic["analytic"]["sye4"];
			    if (empty($_POST["type"]))
			        $errors['e5'] = $tlanalytic["analytic"]["sye5"];

    			if (count($errors) == 0)
    			{
    				$Vodia = new Vodia($jkv);
    				$accts = json_decode($Vodia->getUserList(trim($_POST["domain"]), $_POST["type"]), true);
    				if (!empty($accts['accounts'])) 
    				{
    					foreach ($accts['accounts'] as $acct) 
			            {
			            	$acct["domain"] = trim($_POST["domain"]);
			            	if ($Analytic->Acc_exist($acct))
			                	$Analytic->Acc_insert($acct);
			            }
			            jak_redirect(BASE_URL.'index.php?p=analytic&sp=accts&ssp=s');
    				}
    			}
    			else
    			{
    				$errors['e'] = $tl['error']['e'];
			    	$errors = $errors;
    			}
    		}
    		
    	}
        $plugin_template = 'plugins/analytic/admin/template/sync.php';
	break;

	case 'accts':

		switch ($page2) {
			
			case 'rep':
				$SECTION_TITLE = "Report";
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
				$plugin_template = 'plugins/analytic/admin/template/report.php';
			break;

			case'filter':
				$SECTION_TITLE = "Filter";
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

				$plugin_template = 'plugins/analytic/admin/template/filter.php';
			break;

			case 'add':
				$SECTION_TITLE = "Add Account";

				if ($_SERVER['REQUEST_METHOD'] == 'POST')
				{
					$JAK_FORM_DATA = $_POST;

					if (empty($JAK_FORM_DATA['domain']))
		        		$errors['e1'] = $tlanalytic["analytic"]['fe1'];
					if (empty($JAK_FORM_DATA["account"]))
				    	$errors['e2'] = $tlanalytic["analytic"]['fe2'];
				    if (empty($JAK_FORM_DATA['name']))
		        		$errors['e3'] = $tlanalytic["analytic"]['fe3'];
		        	if (empty($JAK_FORM_DATA['type']))
		        		$errors['e4'] = $tlanalytic["analytic"]['fe4'];

					if (count($errors) == 0)
				    {
				    	$result = $Analytic->Acc_insert($_POST);
				    	if (!$result)
							jak_redirect(BASE_URL.'index.php?p=analytic&sp=accts&ssp=e');
						else
					        jak_redirect(BASE_URL.'index.php?p=analytic&sp=accts&ssp=s');
				    }
				    else
					{
						$errors['e'] = $tl['error']['e'];
				    	$errors = $errors;
					}
				}
				$plugin_template = 'plugins/analytic/admin/template/acct_add.php';
			break;

			case 'edit':
				$SECTION_TITLE = "Edit Account";
				if ($page3 && $JAK_FORM_DATA = $Analytic->Acc_get(['id'=>$page3]) )
				{
					if ($_SERVER['REQUEST_METHOD'] == 'POST')
					{
						$result = $Analytic->Acc_update($_POST);
						if (!$result)
							jak_redirect(BASE_URL.'index.php?p=analytic&sp=accts&ssp=edit&sssp='.$JAK_FORM_DATA['id'].'&ssssp=e');
						else
					        jak_redirect(BASE_URL.'index.php?p=analytic&sp=accts&ssp=edit&sssp='.$JAK_FORM_DATA['id'].'&ssssp=s');
					}
				}
				else
					jak_redirect(BASE_URL.'index.php?p=analytic&sp=accts&ssp=e');
				// Call the template
				$plugin_template = 'plugins/analytic/admin/template/acct_edit.php';
			break;
			
			default:
				$SECTION_TITLE = "Accounts";
				if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['jak_delete_accts']))
				{
					$defaults = $_POST;
				    if (isset($defaults['delete'])) {
				    	$lockuser = $defaults['jak_delete_device'];
				        for ($i = 0; $i < count($lockuser); $i++) {
				            $locked = $lockuser[$i];
							$result = $jakdb->query('DELETE FROM '.$jaktable_accts.' WHERE id = "'.smartsql($locked).'"');
				        }
					 	if (!$result) {
							jak_redirect(BASE_URL.'index.php?p=analytic&ssp=accts&ssp=e');
						} else {
					        jak_redirect(BASE_URL.'index.php?p=analytic&ssp=accts&ssp=s');
					    }

				    }
				}

				$p = (isset($_GET['page']) ? $_GET['page'] : 0);
		        $sort = (isset($_GET['sort']) ? $_GET['sort'] : "id");
		        $order = (isset($_GET['order']) ? $_GET['order'] : "desc");

				// get all devices out
				$getTotal = count($Analytic->Acc_getAll());
				if ($getTotal != 0) {
					// Paginator
					$pages = new JAK_Paginator;
					$pages->items_total = $getTotal;
					$pages->mid_range = $jkv["adminpagemid"];
					$pages->items_per_page = $jkv["adminpageitem"];
					$pages->jak_get_page = $p;
					$pages->jak_where = 'index.php?p=analytic&sp=accts&sort='.$sort.'&order='.$order;
					$pages->paginate();
					$JAK_PAGINATE = $pages->display_pages();
				}
				$JAK_Account_All = $Analytic->Acc_getAll(null, ["sort"=>$sort, "order"=>$order], $pages->limit);

				// Title and Description
				$SECTION_TITLE = $tlanalytic["analytic"]["m1"];
				$SECTION_DESC = $tlanalytic["analytic"]["t"];

				// Call the template
				$plugin_template = 'plugins/analytic/admin/template/accts.php';
			break;
		}
	break;

	case 'dev_rep':
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
		$plugin_template = 'plugins/analytic/admin/template/dev_rep.php';
	break;

	case 'ajax':
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
        	// Delete single file
        	if ($_POST["action"] == 'del' && !empty($_POST["id"]))
        	{	
        		$acct = $Analytic->Acc_get(['id'=>$_POST["id"]]);
				$Analytic->Acc_del($acct["id"]);	
        	}
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
				"alerts" =>  !empty($device_count['alerts'])? $device_count['alerts'] : 0,
				"noalerts" => !empty($device_count['noalerts'])? $device_count['noalerts'] : 0,
				"devices" => !empty($device_count['devices'])? $device_count['devices'] : 0,
				"pbx_accounts"=>$total_num_accounts
			];
        }
        
		$plugin_template = 'plugins/analytic/admin/template/json.php';
	break;

	case 'settings':
		$SECTION_TITLE = "Settings";

		$JAK_SETTING = jak_get_setting('analytic');
		
		// Get the special vars for multi language support
		$JAK_FORM_DATA["title"] = $jkv["analytic_title"];
		$JAK_FORM_DATA["content"] = $jkv["analytic_desc"];

		// Title and Description
		$SECTION_TITLE = $tlanalytic["analytic"]["n"].' - '.$tl["menu"]["m2"];
		$SECTION_DESC = $tl["cmdesc"]["d2"];

		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$defaults = $_POST;
			$defaults['analytic_desc'] = $defaults['jak_lcontent'];
			if (empty($defaults['analytic_title']))
		        $errors['e1'] = $tl['error']['e2'];
		    if (empty($defaults['analytic_pbxhost']))
		        $errors['e2'] = $tlanalytic["analytic"]["se1"];
		    if (empty($defaults['analytic_pbxusername']))
		        $errors['e3'] = $tlanalytic["analytic"]["se2"];
		    if (empty($defaults['analytic_pbxpassword']))
		        $errors['e4'] = $tlanalytic["analytic"]["se3"];

		    if (count($errors) == 0)
		    {
			    $result = $Analytic->Settings($defaults);
			    if (!$result)
					jak_redirect(BASE_URL.'index.php?p=analytic&sp=settings&ssp=e');
				else
			    	jak_redirect(BASE_URL.'index.php?p=analytic&sp=settings&ssp=s');
			}
			else
			{
				$errors['e'] = $tl['error']['e'];
		    	$errors = $errors;
			}
		}
		$plugin_template = 'plugins/analytic/admin/template/setting.php';
	break;

	default:
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

		$plugin_template = 'plugins/analytic/admin/template/dashboard.php';
	break;
}