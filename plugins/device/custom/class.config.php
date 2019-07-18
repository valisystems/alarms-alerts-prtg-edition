<?php

use PFBC\Form;
use PFBC\Element;

/**
* 
*/
class JAK_DeviceConfig
{
	public $conn;

	public function __construct()
	{
		global $jakdb;
		$this->conn = $jakdb;
	}

	public function getDeviceConfig($filter)
	{
		$mysql_query = 'SELECT D.id AS id, D.device_type AS device_type, DC.config_data AS config_data, dc.version AS version ';
		$mysql_query .= ' FROM '.DB_PREFIX.'device as D ';
		$mysql_query .= 'LEFT JOIN '.DB_PREFIX.'device_config as DC ON DC.device_id = D.id ';

        if (!empty($filter) && is_array($filter))
        {
            $i=0;
            $mysql_query .= " WHERE ";
            foreach ($filter as $col => $val)
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

	public function createForm($data)
	{
		if(!empty($data))
		{
			switch ($data['device_type']) {
				case 'miDomelight':
					$forms_fields_filter = $this->domeLightKeys($data);
					break;
				case 'miSIP':
					$forms_fields_filter = $this->miSIP($data);
					break;
				default:
					$forms_fields_filter = '';
					break;
			}

			if ($forms_fields_filter && !empty($data))
			{
				include_once('PFBC/Form.php');
				$form = new Form('formoid');
				$form->configure([
						'action'=> '/admin/index.php?p=device&sp=ajax&ssp=createfile',
						'method' => 'POST',
						'prevent'=>['bootstrap']
				]);

				$form->addElement(new Element\Hidden('device_id', $data['id']));
				$form->addElement(new Element\Hidden('AutoConfigVersion', (!empty($data['version']) ? $data['version'] : 0) ));
				foreach ($forms_fields_filter as $legend => $fields) 
				{
					$form->addElement(new Element\HTML('<legend>' . $legend . '</legend>'));

					if(is_array($fields))
					{
						foreach ($fields as $type => $field) {

							switch ($type) {
								case 'input':
									foreach ($field as $value) {	
										$form->addElement(new Element\Textbox($value['label'], $value['name'], $value['options'] ));
									}			
									break;
								case 'select':
									foreach ($field as $value) {
										$form->addElement(new Element\Select($value['label'], $value['name'], $value['options']) );
									}
									break;
								case 'radio':
									foreach ($field as $value) {
										$form->addElement(new Element\Radio($value['label'], $value['name'], $value['options']) );
									}
									break;
								case 'textarea':
									foreach ($field as $value) {
										$form->addElement(new Element\Textarea($value['label'], $value['name'], $value['options'],$value['attr'] ));
									}
									break;
							}
						}
					}
					
				}
				$form->addElement(new Element\Button);
				$output = $form->render();
			}
			else
			{
				$output = "Device type config form not found.";
			}
		}
		else
		{
			$output = 'Not a valid device.';
		}
		return $output;
	}


	// Submit settings
	public function formSubmit($form_arr_data, $default_path=null)
	{
		$device_data = $this->getDeviceConfig(['D.id' => $form_arr_data['device_id'] ]);
		// first array will overwite key in second array
		$filename_mac_address = !empty($form_arr_data['mac']) ? $form_arr_data['mac'] : FULL_SITE_DOMAIN;
		unset($form_arr_data['Mac'], $form_arr_data['device_id']);

		if ($device_data)
		{
			// default config data should be in json format
			$config = $this->defaultConfig($device_data['device_type']);

			if ($config && !empty($config['default_config_data']) )
			{
				
				if ($config['config_file_type'] == 'json')
				{
					$default_config_values = json_decode($config['default_config_data'], true);
			
					$data = array_merge($default_config_values, $form_arr_data);
					$data['AutoConfigVersion'] = (string)((int)$data['AutoConfigVersion'] + 1);
					$config_data = json_encode($data, JSON_UNESCAPED_SLASHES);

					$this->db_process($device_data, $config_data, $data['AutoConfigVersion']);
				}
				elseif ($config['config_file_type'] == 'dat')
				{
					$form_arr_data['AutoConfigVersion'] = (string)((int)$data['AutoConfigVersion'] + 1);
					// long string and replace with values form the array like %AutoConfigVersion i equal to "AutoConfigVersion" => 0
					$config_data = $this->sprintf_assoc($config['default_config_data'], $form_arr_data);

					$this->db_process($device_data, $config_data, $form_arr_data['AutoConfigVersion']);
				}
				else
				{
					$config_data = implode(PHP_EOL, $data);
				}
				$this->createFile($default_path, md5($filename_mac_address), $config['config_file_type'], $config_data);
			}
				
		}		
	}

	// insert or update data in datbase
	public function db_process($device_data, $config_data, $version)
	{
		if($device_data['config_data'])
		{
			// update
			$this->update_deviceConfig([
				"device_id" => $device_data['id'],
				"config_data" => $config_data,
				"version" =>  $version
			]);
		}
		else
		{
			// Insert
			$this->insert_deviceConfig([
				"device_id" => $device_data['id'],
				"config_data" => $config_data,
				"version" =>  $version
			]);
		}
	}

	public function insert_deviceConfig($data)
	{
		$result = $this->conn->query('INSERT INTO '.DB_PREFIX.'device_config SET
                			device_id = "'.smartsql($data['device_id']).'",
                            config_data = "'.smartsql($data['config_data']).'",
                			version = "'.smartsql($data['version']).'"');
        if (!$result)
        {
			return false;
		}
		return $this->conn->jak_last_id();
	}

	public function update_deviceConfig($data)
	{
		$result = $this->conn->query('UPDATE '.DB_PREFIX.'device_config SET
            			config_data = "'.smartsql($data['config_data']).'",
						version = "'.smartsql($data['version']).'"
            			WHERE device_id = "'.smartsql($data['device_id']).'"
            	');

		if(!$result)
		{
			return false;
		}
		return true;
	}

	public function deviceConfigExist($data)
	{
		$stmt = $this->conn->query('SELECT * FROM '.DB_PREFIX.'device_config WHERE device_id = "' . $data["id"] . '"; ');
		$row = $stmt->fetch_assoc();
		if(!$row)
		{
			return false;
		}
		return true;
	}

	public function defaultConfig($type)
	{
		$stmt = $this->conn->query('SELECT * FROM '.DB_PREFIX.'device_default_config WHERE device_type = "' . $type . '"; ');
		$row = $stmt->fetch_assoc();
		if($row)
		{
			return $row;
		}
		return [];
	}

	public function selectedDevicesConfig($id, $default_path)
	{
		$device_data = $this->getDeviceConfig(['D.id' => $id ]);
		
		$config = $this->defaultConfig($device_data['device_type']);
		if ($config && !empty($config['default_config_data']))
		{
			if ($config['config_file_type'] == 'json')
			{	
				$data = json_decode($config['default_config_data'], true);
				$data['AutoConfigVersion'] = '0';
				$config_data = json_encode($data, JSON_UNESCAPED_SLASHES);
				$this->db_process($device_data, $config_data, $data['AutoConfigVersion']);
			}
			elseif ($config['config_file_type'] == 'dat')
			{	
				$data['AutoConfigVersion'] = '0';
				$config_data = $this->sprintf_assoc($config['default_config_data'], $data);
				$this->db_process($device_data, $config_data, $data['AutoConfigVersion']);
			}
			else
			{
				$config_data = implode(PHP_EOL, $data);
			}

			$this->createFile($default_path, md5(FULL_SITE_DOMAIN), $config['config_file_type'], $config_data);
		}
	}

	public function createFile($path, $filename, $file_ext ,$data)
	{
		if (file_exists($path . $filename . '.' . $file_ext))
			@unlink($path . $filename . '.' . $file_ext);
		
	    if (!$fp = fopen($path . $filename . '.' . $file_ext, 'x+'))
	        exit('Failed to create file:' . $filename);

	    fwrite($fp, $data);
	    fclose($fp);
	}

	public function domeLightKeys($data=null)
	{
		if (!empty($data) && !empty($data['config_data']) )
			$data = json_decode($data['config_data'], true);

		$num_select_options = ["0","1","2","3","4","5","6"];
		$field_settings = [
			"System Configuration"=>[
				"input" =>[
					["name" => "mac", "label"=> 'Mac Address', 'options'=> ["required" => 1 , 'value'=> (!empty($data['mac']) ? $data['mac'] : "") ] ],
					["name" => "DeviceName", "label"=> 'Device Name', 'options'=> ['value'=> (!empty($data['DeviceName']) ? $data['DeviceName'] : "") ] ],
					["name" => "Location", "label"=> 'Location Description', 'options'=> ['value'=> (!empty($data['Location']) ? $data['Location'] : "") ] ]
				]
			],

			"Setup E-mail/SMS/EMS"=>[

				"input" =>[

					["name" => "mailserver", "label"=> 'Mail Server:', 'options'=> ['value'=> (!empty($data['mailserver']) ? $data['mailserver'] : "") ] ],
					["name" => "mailport", "label"=> 'Mail Port:', 'options'=> ['value'=> (!empty($data['mailport']) ? $data['mailport'] : "") ] ],
					["name" => "username", "label"=> 'Username:', 'options'=> ['value'=> (!empty($data['username']) ? $data['username'] : "") ] ],
					["name" => "password", "label"=> 'Password:', 'options'=> ['value'=> (!empty($data['password']) ? $data['password'] : "") ] ],
					["name" => "mailsend", "label"=> 'Mail Send:', 'options'=> ['value'=> (!empty($data['mailsend']) ? $data['mailsend'] : "") ] ],
					["name" => "receiver1", "label"=> 'Receiver 1:', 'options'=> ['value'=> (!empty($data['receiver1']) ? $data['receiver1'] : "") ] ],
					["name" => "receiver2", "label"=> 'Receiver 2', 'options'=> ['value'=> (!empty($data['receiver2']) ? $data['receiver2'] : "") ] ],
					["name" => "receiver3", "label"=> 'Receiver 3:', 'options'=> ['value'=> (!empty($data['receiver3']) ? $data['receiver3'] : "") ] ],
					["name" => "subject", "label"=> 'Subject', 'options'=> ['value'=> (!empty($data['subject']) ? $data['subject'] : "") ] ],
					["name" => "server_name", "label"=> 'EMS Server', 'options'=> ['value'=> (!empty($data['server_name']) ? $data['server_name'] : "") ] ],
					["name" => "config_name", "label"=> 'Config Server', 'options'=> ['value'=> (!empty($data['config_name']) ? $data['config_name'] : "") ] ]
					
				],
				
				"textarea" =>[
					["name" => "mailbody", 
					  "label"=> 'MailBody: Use parameters {BaseName}, {DeviceType}, {EventType}, {DeviceID},{PendantRxLevel}, {LowBattery},{TimeStamp}', 
					  'options'=> [
					  		'value'=> (!empty($data['mailbody']) ? $data['mailbody'] : "")
					  		] 
					],

					[ "name" => "smstmplt",
					  "label"=> 'SMS Template: Use parameters {BaseName},, {DeviceType}, {EventType}, {DeviceID},{PendantRxLevel}, {LowBattery},{TimeStamp}', 
					   'options'=> [
					   		'value'=> (!empty($data['smstmplt']) ? $data['smstmplt'] : "") 
					   	]
					]
				]

			],

			"Dome Light Settings"=>[
				'select' => [
					["name" => "col1", "label"=> '(Top) col 1 ', 'options'=> $num_select_options, "attr" => ['value'=>"5"] ],
					["name" => "snd1", "label"=> 'snd1', 'options'=> $num_select_options, "attr" => ['value'=>"5"] ],
					["name" => "col2", "label"=> 'col2', 'options'=> $num_select_options, "attr" => ['value'=>"5"] ],
					["name" => "snd2", "label"=> 'snd2', 'options'=> $num_select_options, "attr" => ['value'=>"5"] ],
					["name" => "col3", "label"=> 'col3', 'options'=> $num_select_options, "attr" => ['value'=>"5"] ],
					["name" => "snd3", "label"=> 'snd3', 'options'=> $num_select_options, "attr" => ['value'=>"5"] ],
					["name" => "col4", "label"=> '(Bottom) col 4', 'options'=> $num_select_options, "attr" => ['value'=>"5"] ],
					["name" => "snd4", "label"=> 'snd4', 'options'=> $num_select_options, "attr" => ['value'=>"5"] ]
				]
			]
		];
		return $field_settings;		
	}

	public function miSIP($data)
	{
		if (!empty($data) && !empty($data['config_data']) )
			$data = json_decode($data['config_data'], true);

		$field_settings = [
			"System Configuration"=>[
				"input" =>[
					["name" => "mac", "label"=> 'Mac Address', 'options'=> ["required" => 1 , 'value'=> (!empty($data['mac']) ? $data['mac'] : "") ] ],
					["name" => "line1Name", "label"=> 'line 1 Name', 'options'=> ['value'=> (!empty($data['line1Name']) ? $data['line1Name'] : "") ] ],
					["name" => "line1Url", "label"=> 'line 1 Url', 'options'=> ['value'=> (!empty($data['line1Url']) ? $data['line1Url'] : "") ] ],
					["name" => "line1PostDial", "label"=> 'line1PostDial', 'options'=> ['value'=> (!empty($data['line1PostDial']) ? $data['line1PostDial'] : "") ] ],
					["name" => "line1CheckMark", "label"=> 'line1CheckMark', 'options'=> ['value'=> (!empty($data['line1CheckMark']) ? $data['line1CheckMark'] : "") ] ],
					["name" => "line2Name", "label"=> 'line2Name', 'options'=> ['value'=> (!empty($data['line2Name']) ? $data['line2Name'] : "") ] ],
					["name" => "line2Url", "label"=> 'line2Url', 'options'=> ['value'=> (!empty($data['line2Url']) ? $data['line2Url'] : "") ] ],
					["name" => "line2PostDial", "label"=> 'line2PostDial', 'options'=> ['value'=> (!empty($data['line2PostDial']) ? $data['line2PostDial'] : "") ] ],
					["name" => "line2CheckMark", "label"=> 'line2CheckMark', 'options'=> ['value'=> (!empty($data['line2CheckMark']) ? $data['line2CheckMark'] : "") ] ],

					["name" => "line0Name", "label"=> 'line0Name', 'options'=> ['value'=> (!empty($data['line0Name']) ? $data['line0Name'] : "") ] ],
					["name" => "line0Url", "label"=> 'line0Url', 'options'=> ['value'=> (!empty($data['line0Url']) ? $data['line0Url'] : "") ] ],
					["name" => "line0PostDial", "label"=> 'line0PostDial', 'options'=> ['value'=> (!empty($data['line0PostDial']) ? $data['line0PostDial'] : "") ] ],
					["name" => "line0CheckMark", "label"=> 'line0CheckMark', 'options'=> ['value'=> (!empty($data['line0CheckMark']) ? $data['line0CheckMark'] : "0") ] ],

					
					["name" => "ph1RealmPause", "label"=> 'ph1RealmPause', 'options'=> ['value'=> (!empty($data['ph1RealmPause']) ? $data['ph1RealmPause'] : "**7789**") ] ],
					["name" => "ph1RealmAutoAnswer", "label"=> 'ph1RealmAutoAnswer', 'options'=> ['value'=> (!empty($data['ph1RealmAutoAnswer']) ? $data['ph1RealmAutoAnswer'] : "1") ] ],
					["name" => "ph1RealmAuthKey", "label"=> 'ph1RealmAuthKey', 'options'=> ['value'=> (!empty($data['ph1RealmAuthKey']) ? $data['ph1RealmAuthKey'] : "567897y54") ] ],


				],
				"radio" => [
					["name"=>"AutoAnsEnable", "label" => "Auto answer", "options"=> [ "1"=>"On", "2"=>"Off" ] ],
					["name"=>"AutoAnsCounter", "label" => "Auto counter", "options"=> [ "1"=>"On", "2"=>"Off" ] ],
				]
			],
		];

		return $field_settings;

	}

	// ********************** HELPER FUNCTIONS **************************
	public function sprintf_assoc( $string = '', $replacement_vars = array(), $prefix_character = '%' )
	{
	    if ( ! $string ) return '';
	    if ( is_array( $replacement_vars ) && count( $replacement_vars ) > 0 ) {
	        foreach ( $replacement_vars as $key => $value ) {
	            $string = str_replace( $prefix_character . $key, $value, $string );
	        }
	    }
	    // replace if
	    $string =  preg_replace("/(%[A-Za-z0-9]*)/", "", $string);
	    return $string;
	}
	public function printf_assoc( $string = '', $replacement_vars = array(), $prefix_character = '%' ) {
	    echo sprintf_assoc( $string, $replacement_vars, $prefix_character );
	}

	public function isJson($string)
	{
		@json_decode($string);
		return (json_last_error() == JSON_ERROR_NONE);
	}

}
