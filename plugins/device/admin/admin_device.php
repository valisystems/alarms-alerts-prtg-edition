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
$jaktable = DB_PREFIX.'device';
$jaktable4 = DB_PREFIX.'pagesgrid';
$jaktable5 = DB_PREFIX.'pluginhooks';
// Include the functions
include_once("../plugins/device/admin/include/functions.php");


// Now start with the plugin use a switch to access all pages
switch ($page1) {

	// Create new device
	case 'new':

		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
		    $defaults = $_POST;
    		if (isset($defaults['save']))
    		{
    		    if (empty($defaults['jak_device_id'])) {
        		      $errors['e1'] = 'Please enter Device ID <br/>';
        		}

    		    if ($defaults['jak_base_name'] == '') {
    		        $errors['e2'] = 'Please enter Base Name <br/>';
    		    }

    		    if (empty($defaults['jak_device_type'])) {
    		    	$errors['e3'] = 'Please enter Device Type <br/>';
    		    }

    		    if (empty($defaults['jak_event_type'])) {
    		    	$errors['e4'] = 'Please enter Event Type <br/>';
    		    }

                if (empty($defaults['jak_time_stamp'])) {
                    $errors['e5'] = 'Please enter Time stamp <br/>';
                }

                if (jak_deviceExist($defaults))
                {
                    $errors['e6'] = 'Device and base name is already exists in database <br/>';
                }

        		if (count($errors) == 0) {

    		        if (empty($defaults['jak_password'])) {
                        $defaults['jak_password'] = '';
                    }
                    else{
                        $defaults['jak_password'] = $defaults['jak_password'];
                    }

                    if (empty($defaults['jak_sidebar'])) {
                        $defaults['jak_sidebar'] = 0;
                    }
                    else{
                        $defaults['jak_sidebar'] = $defaults['jak_sidebar'];
                    }

					$prtg_url = "/index.php?p=device&sp=prtg&action=query&basename=" . $defaults['jak_base_name'] . "&deviceid=" . $defaults['jak_device_id'];


        			$result = $jakdb->query('INSERT INTO '.$jaktable.' SET
                			device_id = "'.smartsql($defaults['jak_device_id']).'",
                            base_name = "'.smartsql($defaults['jak_base_name']).'",
                			device_type = "'.smartsql($defaults['jak_device_type']).'",
                            event_type = "'.smartsql($defaults['jak_event_type']).'",
                            antenna_int = "'.smartsql($defaults['jak_antenna_int']).'",
                            pendant_rx_level = "'.smartsql($defaults['jak_pendant_rx_level']).'",
                            low_battery = "'.smartsql($defaults['jak_low_battery']).'",
                            time_stamp = "'.smartsql($defaults['jak_time_stamp']).'",
                            prtg_url = "'.smartsql($prtg_url).'",
                			dev_css = "'.smartsql($defaults['jak_css']).'",
                			dev_javascript = "'.smartsql($defaults['jak_javascript']).'",
                            password = "'.smartsql($defaults['jak_password']).'",
                            sidebar = "'.smartsql($defaults['jak_sidebar']).'",
                			time = NOW()');
        			$rowid = $jakdb->jak_last_id();

            		// Save order for sidebar widget
            		if (isset($defaults['jak_hookshow']) && is_array($defaults['jak_hookshow'])) {
            			$exorder = $defaults['horder'];
            			$hookid = $defaults['real_hook_id'];
            			$plugind = $defaults['sreal_plugin_id'];
            			$doith = array_combine($hookid, $exorder);
            			$pdoith = array_combine($hookid, $plugind);

                		foreach ($doith as $key => $exorder) {
                			if (in_array($key, $defaults['jak_hookshow'])) {
                				// Get the real what id
                				$whatid = 0;
                				if (isset($defaults['whatid_'.$pdoith[$key]])) $whatid = $defaults['whatid_'.$pdoith[$key]];

                				$jakdb->query('INSERT INTO '.$jaktable4.' SET deviceid = "'.smartsql($rowid).'", hookid = "'.smartsql($key).'", orderid = "'.smartsql($exorder).'", pluginid = "'.smartsql($pdoith[$key]).'", whatid = "'.smartsql($whatid).'", plugin = "'.smartsql(JAK_PLUGIN_DEVICE).'"');

                			}

                		}

            		}

            		if (!$result) {
            			jak_redirect(BASE_URL.'index.php?p=device&sp=new');
            		} else {
            		    jak_redirect(BASE_URL.'index.php?p=device&sp=edit&ssp='.$rowid);
            		}

        		}
        		else {
        		   	$errors['e'] = $tl['error']['e'];
        		    $errors = $errors;
        		}
    		}
		}

		// Get the sidebar templates
		$result = $jakdb->query('SELECT id, name, widgetcode, exorder, pluginid FROM '.$jaktable5.' WHERE hook_name = "tpl_sidebar" AND active = 1 ORDER BY exorder ASC');
		while ($row = $result->fetch_assoc()) {
			$JAK_HOOKS[] = $row;
		}

		// Get active sidebar widgets
		$grid = $jakdb->query('SELECT hookid FROM '.$jaktable4.' WHERE plugin = '.JAK_PLUGIN_DEVICE.' ORDER BY orderid ASC');
		while ($grow = $grid->fetch_assoc()) {
			// collect each record into $_data
		    $JAK_ACTIVE_GRID[] = $grow;
		}

		// Title and Description
		$SECTION_TITLE = $tldev["device"]["m2"];
		$SECTION_DESC = $tldev["device"]["t1"];
		// Call the template
		$plugin_template = 'plugins/device/admin/template/newdevice.php';
	break;
	case 'setting':

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $defaults = $_POST;

		    if (empty($defaults['jak_title'])) {
		        $errors['e1'] = $tl['error']['e2'];
		    }

		    if (!empty($defaults['jak_email'])) {
    		    if (!filter_var($defaults['jak_email'], FILTER_VALIDATE_EMAIL)) {
    		        $errors['e2'] = $tl['error']['e3'];
    		    }
		    }

		    if (empty($defaults['jak_listpassword'])) {
		        $defaults['jak_listpassword'] = '';
		    }

            if (!is_numeric($defaults['jak_maxpost'])) {
                $errors['e5'] = $tl['error']['e15'];
            }

    		if (!is_numeric($defaults['jak_rss'])) {
               $errors['e6'] = $tl['error']['e15'];
    		}

            if (!is_numeric($defaults['jak_mid'])) {
               $errors['e7'] = $tl['error']['e15'];
            }

            if (!is_numeric($defaults['jak_item'])) {
               $errors['e8'] = $tl['error']['e15'];
            }

		    if (count($errors) == 0) {

		    	if (!empty($defaults['jak_camport'])) {
	               $defaults['jak_camport'] = ':'.$defaults['jak_camport'];
	            }

                $defaults['jak_devicediscover'] = !empty($defaults['jak_devicediscover']) ? $defaults['jak_devicediscover'] : 0;
                $defaults['jak_deviceurl'] = !empty($defaults['jak_deviceurl']) ? $defaults['jak_deviceurl'] : 0;

		    // Do the dirty work in mysql
		   $result = $jakdb->query('UPDATE '.DB_PREFIX.'setting SET value = CASE varname
		    	WHEN "devicetitle" THEN "'.smartsql($defaults['jak_title']).'"
		    	WHEN "devicedesc" THEN "'.smartsql($defaults['jak_lcontent']).'"

			    WHEN "devicediscover" THEN "'.smartsql($defaults['jak_devicediscover']).'"
		        WHEN "deviceftcancreate" THEN "'.smartsql($defaults['jak_ftcancreate']).'"
		        WHEN "deviceftcanedit" THEN "'.smartsql($defaults['jak_ftcanedit']).'"
		        WHEN "deviceftcandelete" THEN "'.smartsql($defaults['jak_ftcandelete']).'"
                WHEN "deviceauthkey" THEN "'.smartsql($defaults['jak_authkey']).'"
                WHEN "devicelistpassword" THEN "'.smartsql($defaults['jak_listpassword']).'"

			    WHEN "devicepbxhost" THEN "'.smartsql($defaults['jak_pbxhost']).'"
                WHEN "devicepbxusername" THEN "'.smartsql($defaults['jak_pbxusername']).'"
                WHEN "devicepbxpassword" THEN "'.smartsql($defaults['jak_pbxpassword']).'"

                WHEN "devicepbx_default_ext" THEN "'.smartsql($defaults['jak_default_ext']).'"
                WHEN "devicepbx_ext_pass" THEN "'.smartsql($defaults['jak_ext_pass']).'"

                WHEN "devicealertemail" THEN "'.smartsql($defaults['jak_alertemail']).'"
                WHEN "deviceemail" THEN "'.smartsql($defaults['jak_email']).'"

                WHEN "deviceemailhost" THEN "'.smartsql($defaults['jak_emailhost']).'"
                WHEN "deviceemailport" THEN "'.smartsql($defaults['jak_emailport']).'"
                WHEN "deviceemailserverprefix" THEN "'.smartsql($defaults['jak_emailserverprefix']).'"
                WHEN "deviceemailusername" THEN "'.smartsql($defaults['jak_emailusername']).'"
                WHEN "deviceemailpassword" THEN "'.smartsql($defaults['jak_emailpassword']).'"

                WHEN "devicesmshost" THEN "'.smartsql($defaults['jak_smshost']).'"
                WHEN "devicesmsnumber" THEN "'.smartsql($defaults['jak_smsnumber']).'"

				WHEN "devicecamhost" THEN "'.smartsql($defaults['jak_camhost']).'"
				WHEN "devicecamport" THEN "'.smartsql($defaults['jak_camport']).'"
                WHEN "devicecamusername" THEN "'.smartsql($defaults['jak_camusername']).'"
				WHEN "devicecampassword" THEN "'.smartsql($defaults['jak_campassword']).'"

				WHEN "devicecatchsinglefile" THEN "'.smartsql($defaults['jak_catchsinglefile']).'"

		        WHEN "devicedateformat" THEN "'.smartsql($defaults['jak_date']).'"
		        WHEN "devicetimeformat" THEN "'.smartsql($defaults['jak_time']).'"
		        WHEN "deviceurl" THEN "'.smartsql($defaults['jak_deviceurl']).'"
		        WHEN "devicemaxpost" THEN "'.smartsql($defaults['jak_maxpost']).'"
		        WHEN "devicerss" THEN "'.smartsql($defaults['jak_rss']).'"
		        WHEN "devicepagemid" THEN "'.smartsql($defaults['jak_mid']).'"
		        WHEN "devicepageitem" THEN "'.smartsql($defaults['jak_item']).'"
		        WHEN "device_css" THEN "'.smartsql($defaults['jak_css']).'"
		        WHEN "device_javascript" THEN "'.smartsql($defaults['jak_javascript']).'"
		    END
				WHERE varname IN (
					"devicetitle", "devicedesc",
				    "devicediscover", "deviceftcancreate", "deviceftcanedit", "deviceftcandelete",
				    "deviceauthkey", "devicelistpassword",
				    "devicepbxhost", "devicepbxusername", "devicepbxpassword", "devicepbx_default_ext", "devicepbx_ext_pass", "devicealertemail", "deviceemail",
				    "deviceemailhost", "deviceemailport", "deviceemailserverprefix", "deviceemailusername", "deviceemailpassword",
				    "devicesmshost", "devicesmsnumber", "devicecamhost", "devicecamport", "devicecamusername", "devicecampassword", "devicecatchsinglefile",
				    "devicedateformat","devicetimeformat","deviceurl","devicemaxpost","devicepagemid",
				    "devicepageitem","devicerss", "device_css", "device_javascript")');

			// Save order for sidebar widget
			if (isset($defaults['jak_hookshow_new']) && is_array($defaults['jak_hookshow_new'])) {

				$exorder = $defaults['horder_new'];
				$hookid = $defaults['real_hook_id_new'];
				$plugind = $defaults['sreal_plugin_id_new'];
				$doith = array_combine($hookid, $exorder);
				$pdoith = array_combine($hookid, $plugind);

				foreach ($doith as $key => $exorder) {

					if (in_array($key, $defaults['jak_hookshow_new'])) {

						// Get the real what id
						$whatid = 0;
						if (isset($defaults['whatid_'.$pdoith[$key]])) $whatid = $defaults['whatid_'.$pdoith[$key]];

						$jakdb->query('INSERT INTO '.$jaktable4.' SET plugin = "'.smartsql(JAK_PLUGIN_DEVICE).'", hookid = "'.smartsql($key).'", pluginid = "'.smartsql($pdoith[$key]).'", whatid = "'.smartsql($whatid).'", orderid = "'.smartsql($exorder).'"');

					}

				}

			}

			// Now check if all the sidebar a deselct and hooks exist, if so delete all associated to this page
			$result = $jakdb->query('SELECT id FROM '.$jaktable4.' WHERE plugin = "'.smartsql(JAK_PLUGIN_DEVICE).'" AND hookid != 0');
			$row = $result->fetch_assoc();

			if (isset($defaults['jak_hookshow_new']) && !is_array($defaults['jak_hookshow_new']) && $row['id'] && !is_array($defaults['jak_hookshow'])) {

				$jakdb->query('DELETE FROM '.$jaktable4.' WHERE plugin = "'.smartsql(JAK_PLUGIN_DEVICE).'" AND deviceid = 0 AND hookid != 0');

			}

			// Save order or delete for extra sidebar widget
			if (isset($defaults['jak_hookshow']) && is_array($defaults['jak_hookshow'])) {

				$exorder = $defaults['horder'];
				$hookid = $defaults['real_hook_id'];
				$hookrealid = implode(',', $defaults['real_hook_id']);
				$doith = array_combine($hookid, $exorder);

				// Reset update
				$updatesql = $updatesql1 = "";

				// Run the foreach for the hooks
				foreach ($doith as $key => $exorder) {

					// Get the real what id
					$result = $jakdb->query('SELECT pluginid FROM '.$jaktable4.' WHERE id = "'.smartsql($key).'" AND hookid != 0');
					$row = $result->fetch_assoc();

					// Get the whatid
					$whatid = 0;
					if (isset($defaults['whatid_'.$row["pluginid"]])) $whatid = $defaults['whatid_'.$row["pluginid"]];

						if (in_array($key, $defaults['jak_hookshow'])) {
							$updatesql .= sprintf("WHEN %d THEN %d ", $key, $exorder);
							$updatesql1 .= sprintf("WHEN %d THEN %d ", $key, $whatid);

						} else {
							$jakdb->query('DELETE FROM '.$jaktable4.' WHERE id = "'.smartsql($key).'"');
						}
					}

					$jakdb->query('UPDATE '.$jaktable4.' SET orderid = CASE id
					'.$updatesql.'
					END
					WHERE id IN ('.$hookrealid.')');

					$jakdb->query('UPDATE '.$jaktable4.' SET whatid = CASE id
					'.$updatesql1.'
					END
					WHERE id IN ('.$hookrealid.')');

			}

			if (!$result) {
				jak_redirect(BASE_URL.'index.php?p=device&sp=setting&ssp=e');
			} else {
			    jak_redirect(BASE_URL.'index.php?p=device&sp=setting&ssp=s');
			}
		    } else {
		    	$errors['e'] = $tl['error']['e'];
		    	$errors = $errors;
		    }
		}

		$JAK_SETTING = jak_get_setting('device');

		// Get the sort orders for the grid
		$JAK_PAGE_GRID = array();
		$grid = $jakdb->query('SELECT id, hookid, whatid, orderid FROM '.$jaktable4.' WHERE plugin = "'.smartsql(JAK_PLUGIN_DEVICE).'" AND deviceid = 0 ORDER BY orderid ASC');
		while ($grow = $grid->fetch_assoc()) {
		        // collect each record into $_data
		        $JAK_PAGE_GRID[] = $grow;
		}

		// Get the sidebar templates
		$JAK_HOOKS = array();
		$result = $jakdb->query('SELECT id, name, widgetcode, exorder, pluginid FROM '.$jaktable5.' WHERE hook_name = "tpl_sidebar" AND active = 1 ORDER BY exorder ASC');
		while ($row = $result->fetch_assoc()) {
			$JAK_HOOKS[] = $row;
		}

		// Now let's check how to display the order
		$showdevicearray = explode(" ", $jkv["deviceorder"]);

		if (is_array($showdevicearray) && in_array("ASC", $showdevicearray) || in_array("DESC", $showdevicearray)) {

				$JAK_SETTING['showdevicewhat'] = $showdevicearray[0];
				$JAK_SETTING['showdeviceorder'] = $showdevicearray[1];

		}

		// Get the special vars for multi language support
		$JAK_FORM_DATA["title"] = $jkv["devicetitle"];
		$JAK_FORM_DATA["content"] = $jkv["devicedesc"];

		// Title and Description
		$SECTION_TITLE = $tldev["device"]["n"].' - '.$tl["menu"]["m2"];
		$SECTION_DESC = $tl["cmdesc"]["d2"];

		// Call the template
		$plugin_template = 'plugins/device/admin/template/setting.php';

	break; // End of Setting Case
    case 'edit':
         if (is_numeric($page2) && jak_row_exist($page2,$jaktable))
         {
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $defaults = $_POST;
                if (empty($defaults['jak_device_type'])) {
                    $errors['e3'] = 'Please enter Device Type <br/>';
                }

                if (empty($defaults['jak_event_type'])) {
                    $errors['e4'] = 'Please enter Event Type <br/>';
                }

                if (empty($defaults['jak_time_stamp'])) {
                    $errors['e5'] = 'Please enter Time stamp <br/>';
                }

                if (count($errors) == 0) {
                    $insert .= 'time = NOW(),';
                    $result = $jakdb->query('UPDATE '.$jaktable.' SET
                            device_type = "'.smartsql($defaults['jak_device_type']).'",
                            event_type = "'.smartsql($defaults['jak_event_type']).'",
                            antenna_int = "'.smartsql($defaults['jak_antenna_int']).'",
                            pendant_rx_level = "'.smartsql($defaults['jak_pendant_rx_level']).'",
                            low_battery = "'.smartsql($defaults['jak_low_battery']).'",
                            time_stamp = "'.smartsql($defaults['jak_time_stamp']).'",
                            password = "'.smartsql($defaults['jak_password']).'",
                            dev_css = "'.smartsql($defaults['jak_css']).'",
                            dev_javascript = "'.smartsql($defaults['jak_javascript']).'",
                            '.$insert.'
                            sidebar = "'.smartsql($defaults['jak_sidebar']).'"
                            WHERE id = "'.smartsql($page2).'"');
                }
                else
                {
                    $errors['e'] = $tl['error']['e'];
                    $errors = $errors;
                }
                // Save order for sidebar widget
                if (isset($defaults['jak_hookshow_new']) && is_array($defaults['jak_hookshow_new'])) {

                    $exorder = $defaults['horder_new'];
                    $hookid = $defaults['real_hook_id_new'];
                    $plugind = $defaults['sreal_plugin_id_new'];
                    $doith = array_combine($hookid, $exorder);
                    $pdoith = array_combine($hookid, $plugind);

                    foreach ($doith as $key => $exorder) {

                        if (in_array($key, $defaults['jak_hookshow_new'])) {

                            // Get the real what id
                            $whatid = 0;
                            if (isset($defaults['whatid_'.$pdoith[$key]])) $whatid = $defaults['whatid_'.$pdoith[$key]];

                            $jakdb->query('INSERT INTO '.$jaktable4.' SET deviceid = "'.smartsql($page2).'", hookid = "'.smartsql($key).'", orderid = "'.smartsql($exorder).'", pluginid = "'.smartsql($pdoith[$key]).'", whatid = "'.smartsql($whatid).'", plugin = "'.smartsql(JAK_PLUGIN_DEVICE).'"');

                        }
                    }
                }

                // Now check if all the sidebar a deselct and hooks exist, if so delete all associated to this page
                $result = $jakdb->query('SELECT id FROM '.$jaktable4.' WHERE deviceid = "'.smartsql($page2).'" AND hookid != 0');
                $row = $result->fetch_assoc();

                if (isset($defaults['jak_hookshow_new']) && !is_array($defaults['jak_hookshow_new']) && $row['id'] && !is_array($defaults['jak_hookshow'])) {

                    $jakdb->query('DELETE FROM '.$jaktable4.' WHERE deviceid = "'.smartsql($page2).'" AND hookid != 0');

                }

                // Save order or delete for extra sidebar widget
                if (isset($defaults['jak_hookshow']) && is_array($defaults['jak_hookshow'])) {

                    $exorder = $defaults['horder'];
                    $hookid = $defaults['real_hook_id'];
                    $hookrealid = implode(',', $defaults['real_hook_id']);
                    $doith = array_combine($hookid, $exorder);

                    foreach ($doith as $key => $exorder) {

                        // Get the real what id
                        $result = $jakdb->query('SELECT pluginid FROM '.$jaktable4.' WHERE id = "'.smartsql($key).'" AND hookid != 0');
                        $row = $result->fetch_assoc();

                        $whatid = 0;
                        if (isset($defaults['whatid_'.$row["pluginid"]])) $whatid = $defaults['whatid_'.$row["pluginid"]];

                        if (in_array($key, $defaults['jak_hookshow'])) {
                            $updatesql .= sprintf("WHEN %d THEN %d ", $key, $exorder);
                            $updatesql1 .= sprintf("WHEN %d THEN %d ", $key, $whatid);
                        } else {
                            $jakdb->query('DELETE FROM '.$jaktable4.' WHERE id = "'.smartsql($key).'"');
                        }
                    }
                        $jakdb->query('UPDATE '.$jaktable4.' SET orderid = CASE id
                            '.$updatesql.'
                            END
                            WHERE id IN ('.$hookrealid.')');
                        $jakdb->query('UPDATE '.$jaktable4.' SET whatid = CASE id
                                '.$updatesql1.'
                                END
                                WHERE id IN ('.$hookrealid.')');
                }
                if (!$result) {
                    jak_redirect(BASE_URL.'index.php?p=device&sp=edit&ssp='.$page2.'&sssp=e');
                } else {
                    jak_redirect(BASE_URL.'index.php?p=device&sp=edit&ssp='.$page2.'&sssp=s');
                }

            }
        }
        else
        {
            jak_redirect(BASE_URL.'index.php?p=device&sp=ene');
        }// END of device row exist

            $JAK_FORM_DATA = jak_get_data($page2, $jaktable);
            // Get the sort orders for the grid
            $grid = $jakdb->query('SELECT id, pluginid, hookid, whatid, orderid FROM '.$jaktable4.' WHERE deviceid = "'.smartsql($page2).'" ORDER BY orderid ASC');
            while ($grow = $grid->fetch_assoc()) {
                    // collect each record into $_data
                    $JAK_PAGE_GRID[] = $grow;
            }

            // Get the sidebar templates
            $result = $jakdb->query('SELECT id, name, widgetcode, exorder, pluginid FROM '.$jaktable5.' WHERE hook_name = "tpl_sidebar" AND active = 1 ORDER BY exorder ASC');
            while ($row = $result->fetch_assoc()) {
                $JAK_HOOKS[] = $row;
            }
            // Title and Description
            $SECTION_TITLE = $tldev["device"]["m3"];
            $SECTION_DESC = $tldev["device"]["t3"];
            $plugin_template = 'plugins/device/admin/template/editdevice.php';
    break; // End of Edit Case
    case 'delete':
        if (is_numeric($page2) && jak_row_exist($page2,$jaktable)) {

            $result = $jakdb->query('DELETE FROM '.$jaktable.' WHERE id = "'.smartsql($page2).'"');

            if (!$result) {
                jak_redirect(BASE_URL.'index.php?p=device&sp=e');
            } else {

                jak_redirect(BASE_URL.'index.php?p=device&sp=s');
            }
        } else {
            jak_redirect(BASE_URL.'index.php?p=device&sp=ene');
        }

    break; // End of delete CASE

    case 'lfiles':
        include '/../custom/class.device.php';
        $deviceObj = new JAK_device();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($_POST['action'] == 'download')
            {
                if (file_exists($jkv["deviceprtgfilepath"] . $_POST['filename'])) {
                    readfile($jkv["deviceprtgfilepath"] . $_POST['filename']);
                    exit;
                }
            }
            if ($_POST['action'] == 'del') {
                @unlink($jkv["deviceprtgfilepath"] . $_POST['filename']);
            }

        }
        $JAK_QUERY_FILES = $deviceObj->getQueryFiles($jkv["deviceprtgfilepath"]);
        $plugin_template = 'plugins/device/admin/template/lfiles.php';

    break; // END of Local file CASE

	case 'files':
        $PAGE_TITLE = 'Device Files';
        switch ($page2) {
            case 'sfcatch':
                 $PAGE_CONTENT = 'Single File catch';
                 $JAK_CATCH_FILES = jak_get_device_files('../_files/catch/single_files/');
            break;
            case 'mfcatch':
                $PAGE_CONTENT = 'Folder catch';
                $JAK_CATCH_FILES = jak_get_catch_dirs('../_files/catch/');
            break;
            case 'sensorfiles':
                $PAGE_CONTENT = 'Sensor files';
                $JAK_CATCH_FILES = jak_get_device_files('../_files/sensors/');
            break;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST["action"] == 'del') {
            jak_delete_file_dir($_POST["filepath"]);
        }

		$plugin_template = 'plugins/device/admin/template/files.php';
	break; // END of catch file CASE

	case 'urls':
        $plugin_template = 'plugins/device/admin/template/urls.php';
    break; // END of url
    
    case '3cx_urls':
        $plugin_template = 'plugins/device/admin/template/3cx.php';
    break; // END of 3cx url

    case 'ajax':
        // Config ajax
        include '/../custom/class.config.php';
        $deviceConfigObj = new JAK_DeviceConfig();
        if (!empty($page2))
        {
            switch ($page2) {
                case 'cform':
                        $PAGE_TITLE = '';
                        $data = [];
                        if($_SERVER['REQUEST_METHOD'] == 'POST')
                        {
                            $data = $deviceConfigObj->getDeviceConfig(['D.id' => $_POST['id']]);
                        }
                        $PAGE_CONTENT = $deviceConfigObj->createForm($data);
                    break;
                case 'createfile':
                        $PAGE_TITLE = '';
                        $defualt_config_path = '..' . DS . '_files' . DS . 'device_config'.DS;
                        
                        if($_SERVER['REQUEST_METHOD'] == 'POST' && file_get_contents('php://input'))
                        {
                            $form_arr_data = json_decode(file_get_contents('php://input'), true);
                            $PAGE_CONTENT = $deviceConfigObj->formSubmit($form_arr_data, $defualt_config_path);
                        }
                    break;
                case 'configdevices':
                        $PAGE_TITLE = '';
                        if($_SERVER['REQUEST_METHOD'] == 'POST')
                        {
                            $defualt_config_path = '..' . DS . '_files' . DS . 'device_config'.DS;
                            foreach ($_POST['selecteddevices'] as $device_id) 
                            {
                                $deviceConfigObj->selectedDevicesConfig($device_id, $defualt_config_path);
                            }
                        }
                    break;
                default:
                        $PAGE_CONTENT = [
                            "data" => 'hello'
                        ];
                    break;
            }
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['action']))
        {
            $postData= $_POST;
            switch ($postData['action']) {
                case 'cancelAll':
                    $PAGE_CONTENT = jak_changeEventType('cancelAll', $postData); // Cancel all alarm
                break;
                case 'singleAlarm':
                    $PAGE_CONTENT = jak_changeEventType('singleAlarm', $postData); // Cancel single alarm
                break;
            }
        }
        $plugin_template = 'plugins/device/admin/template/json.php';
    break;

    case 'cust_cam':
        include_once("../plugins/device/custom/class.cam.php");
        $login_form = TRUE;
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'])
        {
            $login_form = FALSE;
            $credentials = $_POST;
            $camObj = new JAK_cam([
                "host" => $credentials["server"],
                'username' => $credentials["username"],
                "password" => $credentials["password"]
            ]);
            $cam_images=[];
            $apiResults = json_decode($camObj->getCameras());
            if ($apiResults)
            {
                foreach ($apiResults as $k => $cam)
                {
                    $cam_images[$k] = [
                        'id' => substr($cam->uri, -1),
                        'name' => $cam->name,
                        'uri' => $cam->uri,
                        'image' => $camObj->getSingleCamImage(substr($cam->uri, -1)),
                        'video' => $cam->{'video-uri'}
                    ];
                }
            }

        }
        $plugin_template = 'plugins/device/admin/template/custom_cam.php';
    break;

    // Default device config
    case 'default_config':
        include '/../custom/class.default.config.php';
        $defaultConfigObj = new DefaultConfig();

        switch ($page2) {
            case 'new':
                if ($_SERVER['REQUEST_METHOD'] == 'POST')
                {
                    $defaults = $_POST;
                    if (empty($defaults['device_type']))
                        $errors['e1'] = "Please select device type.";
                    if (empty($defaults['default_config_data']))
                        $errors['e2'] = "Please enter config data.";
                    if (empty($defaults['config_file_type']))
                        $errors['e3'] = "Please select file type.";

                    if (count($errors) == 0) {
                        $result =  $defaultConfigObj->insert($defaults);
                        if (!$result)
                            jak_redirect(BASE_URL.'index.php?p=device&sp=default_config&ssp=e');
                        else
                            jak_redirect(BASE_URL.'index.php?p=device&sp=default_config&ssp=s');
                    }
                    else
                    {
                        $errors['e'] = $tl['error']['e'];
                        $errors = $errors;
                    }
                }
                $plugin_template = 'plugins/device/admin/template/default_config_new.php';
                break;
            case 'edit':

                if (is_numeric($page3) && jak_row_exist($page3, DB_PREFIX.'device_default_config')) 
                {
                    $JAK_FORM_DATA = $defaultConfigObj->get(['id' =>$page3]);
                    if ($_SERVER['REQUEST_METHOD'] == 'POST')
                    {
                        $JAK_FORM_DATA = $_POST;
                        if (empty($JAK_FORM_DATA['device_type']))
                            $errors['e1'] = "Please select device type.<br/>";
                        if (empty($JAK_FORM_DATA['default_config_data']))
                            $errors['e2'] = "Please enter config data.<br/>";
                        if (empty($JAK_FORM_DATA['config_file_type']))
                            $errors['e3'] = "Please select file type.";

                        if (count($errors) == 0) {
                            $result = $defaultConfigObj->update($JAK_FORM_DATA);
                            if (!$result)
                                jak_redirect(BASE_URL.'index.php?p=device&sp=default_config&ssp=e');
                            else
                                jak_redirect(BASE_URL.'index.php?p=device&sp=default_config&ssp=s');
                        }
                        else
                        {
                            $errors['e'] = $tl['error']['e'];
                            $errors = $errors;
                        }
                    }
                    $plugin_template = 'plugins/device/admin/template/default_config_edit.php';
                    }
                else
                {
                    jak_redirect(BASE_URL.'index.php?p=device&sp=default_config&ssp=ene');
                }
                
                break;
            case 'del':
                if (is_numeric($page3) && jak_row_exist($page3, DB_PREFIX.'device_default_config')) 
                {
                    $result = $defaultConfigObj->del($page3);
                    if (!$result)
                        jak_redirect(BASE_URL.'index.php?p=device&sp=default_config&ssp=e');
                    else 
                        jak_redirect(BASE_URL.'index.php?p=device&sp=default_config&ssp=s');

                } else {
                    jak_redirect(BASE_URL.'index.php?p=device&sp=default_config&ssp=ene');
                }
                break;
            default:
                $configs = $defaultConfigObj->getAll();
                $plugin_template = 'plugins/device/admin/template/default_config.php';
                break;
        }
        if (empty($page2)) {
            $configs = $defaultConfigObj->getAll();
            $plugin_template = 'plugins/device/admin/template/default_config.php';
        }
        break;
    // End of device config

	default:
		switch ($page1) {
    		case 'sort':
    		 	// getNumber
    		 	$getTotal = jak_get_total($jaktable,'','','');

    		 	// Now if total run paginator
    		 	if ($getTotal != 0) {
    		 		// Paginator
    		 		$pages = new JAK_Paginator;
    		 		$pages->items_total = $getTotal;
    		 		$pages->mid_range = $jkv["devicepagemid"];
    		 		$pages->items_per_page = $jkv["devicepageitem"];
    		 		$pages->jak_get_page = $page4;
    		 		$pages->jak_where = 'index.php?p=device&sp=sort&ssp='.$page2.'&sssp='.$page3;
    		 		$pages->paginate();
    		 		$JAK_PAGINATE = $pages->display_pages();
    		 	}

    		 	$result = $jakdb->query('SELECT * FROM '.$jaktable.' ORDER BY '.$page2.' '.$page3.' '.$pages->limit);
    		 	while ($row = $result->fetch_assoc())
    		 	    $JAK_DEVICE_ALL[] = $row;


    		 	// Title and Description
    		 	$SECTION_TITLE = $tldev["device"]["m1"];
    		 	$SECTION_DESC = $tldev["device"]["t"];
    		 	// Call the template
    		 	$plugin_template = 'plugins/device/admin/template/device.php';
    		break;
    		default:
    			// Hello we have a post request
    			if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['jak_delete_device'])) {
    			    $defaults = $_POST;

    			    if (isset($defaults['lock'])) {

    			    	$lockuser = $defaults['jak_delete_device'];

    			        for ($i = 0; $i < count($lockuser); $i++) {
    			            $locked = $lockuser[$i];

    			            $result2 = $jakdb->query('SELECT catid, active FROM '.$jaktable.' WHERE id = "'.smartsql($locked).'"');
    						$row2 = $result2->fetch_assoc();

    			        	$result = $jakdb->query('UPDATE '.$jaktable.' SET active = IF (active = 1, 0, 1) WHERE id = "'.smartsql($locked).'"');

    			        }

    				 	if (!$result) {
    						jak_redirect(BASE_URL.'index.php?p=device&sp=e');
    					} else {
    				        jak_redirect(BASE_URL.'index.php?p=device&sp=s');
    				    }
    			    }

    			    if (isset($defaults['delete'])) {

    			    	$lockuser = $defaults['jak_delete_device'];

    			        for ($i = 0; $i < count($lockuser); $i++) {
    			            $locked = $lockuser[$i];

    						$result = $jakdb->query('DELETE FROM '.$jaktable.' WHERE id = "'.smartsql($locked).'"');

    			        }

    				 	if (!$result) {
    						jak_redirect(BASE_URL.'index.php?p=device&sp=e');
    					} else {
    				        jak_redirect(BASE_URL.'index.php?p=device&sp=s');
    				    }

    			    }

    			 }

    			// get all devices out
    			$getTotal = jak_get_total($jaktable,'','','');

    			if ($getTotal != 0) {
    				// Paginator
    				$pages = new JAK_Paginator;
    				$pages->items_total = $getTotal;
    				$pages->mid_range = $jkv["devicepagemid"];
    				$pages->items_per_page = $jkv["devicepageitem"];
    				$pages->jak_get_page = $page1;
    				$pages->jak_where = 'index.php?p=device';
    				$pages->paginate();
    				$JAK_PAGINATE = $pages->display_pages();
    			}
    			$JAK_DEVICE_ALL = jak_get_devices($pages->limit, '', $jaktable);

    			// Title and Description
    			$SECTION_TITLE = $tldev["device"]["m1"];
    			$SECTION_DESC = $tldev["device"]["t"];

    			// Call the template
    			$plugin_template = 'plugins/device/admin/template/device.php';
         	break;
		} // End of second level default CASE
    break;//end of top level default CASE
}
?>
