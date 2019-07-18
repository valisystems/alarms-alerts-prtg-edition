<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

class JAK_plugins
{
	private $data = array();
	private $case = array();
	private $sqlwhere = '';
	private $sqlwhere1 = '';
	
	public function __construct($active)
	{
		/*
		/	The constructor
		*/
		
		if ($active == 1) {
			$sqlwhere = ' WHERE active = 1';
			$sqlfrom = 'id, name, active, phpcode, sidenavhtml, usergroup';
		}
		if ($active == 2) {
			$sqlwhere = ' WHERE FIND_IN_SET('.JAK_USERID.', access)';
			$sqlfrom = 'id, name, description, active, access, pluginorder, pluginpath, phpcode, phpcodeadmin, sidenavhtml, managenavhtml, usergroup, uninstallfile, pluginversion, time';
		}
		
		$jakplugins = array();
		global $jakdb;
		$result = $jakdb->query('SELECT '.$sqlfrom .' FROM '.DB_PREFIX.'plugins'.$sqlwhere.' ORDER BY pluginorder ASC');
		while ($row = $result->fetch_assoc()) {
			
			// Check if user has access to one of them
		    $jakplugins[] = $row;
		}
		
		$this->data = $jakplugins;
	}
	
	public function jakGetarray()
	{
		// Setting up an alias, so we don't have to write $this->data every time:
		$d = $this->data;
		
		return $d;
		
	}
	
	public function jakAdmintopnav()
	{
		// Setting up an alias, so we don't have to write $this->data every time:
		$d = $this->data;
		
		foreach($d as $c)
		{
			if ($c['active'] == 1 && !empty($c['sidenavhtml']))
			$case[] = $c['sidenavhtml'];
		}
		
		return $case;
		
	}
	
	public function jakAdminmanagenav()
	{
		// Setting up an alias, so we don't have to write $this->data every time:
		$d = $this->data;
		
		foreach($d as $c)
		{
			if ($c['active'] == 1 && !empty($c['managenavhtml']))
			$case[] = $c['managenavhtml'];
		}
		
		if (!empty($case)) return $case;
		
	}
	
	public function jakAdminindex()
	{
		// Setting up an alias, so we don't have to write $this->data every time:
		$d = $this->data;
		
		foreach($d as $c)
		{
			if ($c['active'] == 1 && !empty($c['phpcodeadmin'])) {
				$case[] = array('id' => $c['id'], 'name' => $c['name'], 'access' => $c['access'], 'phpcode' => $c['phpcodeadmin']);
			}
		}
		
		return $case;
	}
	
	public function jakSiteindex()
	{
		// Setting up an alias, so we don't have to write $this->data every time:
		$d = $this->data;
		
		foreach($d as $c)
		{
			if (!empty($c['phpcode']))
			$case[] = $c['phpcode'];
		}
		
		return $case;
	}
	
	public function jakAdmintag()
	{
		// Setting up an alias, so we don't have to write $this->data every time:
		$d = $this->data;
		
		foreach($d as $c)
		{
			if ($c['active'] == 1) {
				$case[] = array('id' => $c['id'], 'name' => $c['name']);
			}
		}
		
		return $case;
	}
	
	public function getPHPcodeid($id, $field)
	{
		// Setting up an alias, so we don't have to write $this->data every time:
		$d = $this->data;
		
			foreach($d as $c)
			{
				if ($c['id'] == $id) {
					$case = $c[$field];
				}
			}
		
		if (!empty($case)) return $case;
		
	}
	
	public function getIDfromName($name)
	{
		// Setting up an alias, so we don't have to write $this->data every time:
		$d = $this->data;
		
			foreach($d as $c)
			{
				if ($c['name'] == $name) {
					$case = $c['id'];
				}
			}
		
		return $case;
		
	}

}
?>