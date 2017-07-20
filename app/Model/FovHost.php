<?php
App::uses('AppModel', 'Model');
App::uses('Hash', 'Utility');

class FovHost extends AppModel 
{
	public $displayField = 'host_name';
	
	public $order = ['FovHost.created' => 'DESC'];
	
	public $belongsTo = [
		'AddedUser' => [
			'className' => 'User',
			'foreignKey' => 'added_user_id',
		],
		'ModifiedUser' => [
			'className' => 'User',
			'foreignKey' => 'modified_user_id',
		],
	];
	
	public $hasMany = [
		'FovHostFovResult' => [
			'className' => 'FovHostFovResult',
			'foreignKey' => 'fov_host_id',
			'dependent' => true,
		],
		'SubnetMember' => [
			'className' => 'SubnetMember',
			'foreignKey' => 'eol_result_id',
			'dependent' => true,
		],
	];
	
	public $hasAndBelongsToMany = [
		'FovResult' => [
			'className' => 'FovResult',
			'joinTable' => 'fov_hosts_fov_results',
			'foreignKey' => 'fov_host_id',
			'associationForeignKey' => 'fov_result_id',
			'unique' => 'keepExisting',
			'with' => 'FovHostFovResult',
		],
	];
	
	public $actsAs = [
		'ReportsResults',
		'Tags.Taggable',
		'PhpExcel.PhpExcel',
	];
	
	public $manageUploads = true;
	
	public $checkAddCache = [];
	
	public function importToResult($resultId = false, $csvString = false)
	{
		if(!$resultId)
		{
			$this->modelError = __('Invalid Result ID');
			return false;
		}
		
		if(!$hosts = $this->parseHosts($csvString))
		{
			return false;
		}
		
		// see if each host already exists
		$hostIds = [];
		foreach($hosts as $host)
		{
			if($host_id = $this->checkAdd($host))
				$hostIds[$host_id] = $host_id;
		}
		
		return $hostIds;
	}
	
	public function checkAdd($data = [])
	{
		if(!$data)
			return false;
		
		if(!$data = $this->fixData(array($this->alias => $data)))
			return false;
		$data = $data[$this->alias];
		
		$host_id = false;
		
		$saveData = [];
		
		if(isset($data['host_description']) and $data['host_description'])
		{
			$saveData['host_description'] = $data['host_description'];
		}
		
		if(!$host_id and isset($data['asset_tag']) and $data['asset_tag'])
		{
			$saveData['asset_tag'] = $data['asset_tag'];
			if(strtoupper($data['asset_tag']) != 'TBD')
			{
				if(isset($this->checkAddCache['asset_tag'][$data['asset_tag']]))
				{
					$host_id = $this->checkAddCache['asset_tag'][$data['asset_tag']];
				}
				else
				{
					$host_id = $this->field($this->primaryKey, array($this->alias.'.asset_tag' => $data['asset_tag']));
					$this->checkAddCache['asset_tag'][$data['asset_tag']] = $host_id;
				}
			}
		}
		
		if(!$host_id and isset($data['mac_address']) and $data['mac_address'])
		{
			$saveData['mac_address'] = $data['mac_address'];
			if(strtoupper($data['mac_address']) != 'TBD')
			{
				if(isset($this->checkAddCache['mac_address'][$data['mac_address']]))
				{
					$host_id = $this->checkAddCache['mac_address'][$data['mac_address']];
				}
				else
				{
					$host_id = $this->field($this->primaryKey, array($this->alias.'.mac_address' => $data['mac_address']));
					$this->checkAddCache['mac_address'][$data['mac_address']] = $host_id;
				}
			}
		}
		
		if(!$host_id and isset($data['host_name']) and $data['host_name'])
		{
			$saveData['host_name'] = $data['host_name'];
			if(strtoupper($data['host_name']) != 'TBD')
			{
				if(isset($this->checkAddCache['host_name'][$data['host_name']]))
				{
					$host_id = $this->checkAddCache['host_name'][$data['host_name']];
				}
				else
				{
					$host_id = $this->field($this->primaryKey, array($this->alias.'.host_name' => $data['host_name']));
					$this->checkAddCache['host_name'][$data['host_name']] = $host_id;
				}
			}
		}
		
		if(!$host_id and isset($data['ip_address']) and $data['ip_address'])
		{
			$saveData['ip_address'] = $data['ip_address'];
			if(strtoupper($data['ip_address']) != 'TBD')
			{
				if(isset($this->checkAddCache['ip_address'][$data['ip_address']]))
				{
					$host_id = $this->checkAddCache['ip_address'][$data['ip_address']];
				}
				else
				{
					$host_id = $this->field($this->primaryKey, array($this->alias.'.ip_address' => $data['ip_address']));
					$this->checkAddCache['ip_address'][$data['ip_address']] = $host_id;
				}
			}
		}
		
		// avoid ones that only have tbd or blank in their fields
		$badCnt = 0;
		foreach($saveData as $k => $v)
		{
			if(strtoupper($v) == 'TBD' or !$v)
				$badCnt++;
		}
		
		if($badCnt >= count($saveData))
			return false;
		
		if($host_id)
			return $host_id;
		
		if(!$saveData)
			return false;
		
		$this->create();
		$this->data[$this->alias] = $saveData;
		if($this->save($this->data))
		{
			return $this->id;
		}
		return false;
	}
	
	public function addMany($data = array(), $fov_result_id = false)
	{
		if(!$data)
		{
			$this->modelError = __('No data is set.');
			return false;
		}
		
		$csvString = (isset($data[$this->alias]['hosts'])?trim($data[$this->alias]['hosts']):false);
		if(!$csvString)
		{
			$this->modelError = __('No hosts are found. (1)');
			return false;
		}
		
		$hosts = $this->parseHosts($csvString);
		
		if(!$hosts)
		{
			return false;
		}
		
		// see if each host already exists
		$hostIds = [];
		foreach($hosts as $host)
		{
			if($host_id = $this->checkAdd($host))
				$hostIds[$host_id] = $host_id;
		}
		if(!$hostIds)
		{
			$this->modelError = __('No hosts are found. (2)');
			return false;
		}
		
		// save the new ids to the xref table
		if(count($hostIds) and $fov_result_id)
			$this->FovHostFovResult->saveAssociatedHosts($fov_result_id, $hostIds);
		
		return $hostIds;
	}
	
	public function parseHosts($csvString = false)
	{
		$csvString = trim($csvString);
		if(!$csvString)
		{
			$this->modelError = __('Invalid CSV String');
			return false;
		}
		
		// this should be coming from the fov result add form, and should always be in the same order, with no header row
		$csvArray = $this->Excel_csvToArray($csvString);
		
		if(!$csvArray)
		{
			$this->modelError = __('Invalid CSV list');
			return false;
		}
		
		$hosts = [];
		$rowDefault = [0=>false,1=>false,2=>false,3=>false,4=>false,5=>false];
		foreach($csvArray as $row)
		{
			$row = $row+$rowDefault;
			$host = [];
			list($host['host_description'], $host['host_name'], $host['ip_address'], $host['asset_tag'], $host['mac_address'], $host['netbios']) = $row;
			$hosts[] = $host;
		}
		
		if(!$hosts)
		{
			$this->modelError = __('No valid hosts were found');
			return false;
		}
		return $hosts;
	}
}
