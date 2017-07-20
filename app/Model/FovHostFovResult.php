<?php

App::uses('AppModel', 'Model');
class FovHostFovResult extends AppModel 
{
	public $useTable = 'fov_hosts_fov_results';
	
	public $validate = [
		'fov_host_id' => ['numeric' => ['rule' => ['numeric']]],
		'fov_result_id' => ['numeric' => ['rule' => ['numeric']]],
	];
	
	public $belongsTo = [
		'FovHost' => [
			'className' => 'FovHost',
			'foreignKey' => 'fov_host_id',
			'multiselect' => true,
			'nameSingle' => 'FOV Host',
		],
		'FovResult' => [
			'className' => 'FovResult',
			'foreignKey' => 'fov_result_id',
			'multiselect' => true,
			'nameSingle' => 'FOV Result',
		],
	];
	
	// define the fields that can be searched
	public $searchFields = [
		'FovResult.name',
		'FovHost.asset_tag',
		'FovHost.host_name',
		'FovHost.ip_address',
		'FovHost.mac_address',
	];
	
	public function saveAssociatedHosts($fov_result_id = false, $fov_host_ids = [], $fov_result_xref_data = [])
	{
		if(!$fov_result_id) return false;
		if(!$fov_host_ids) $fov_host_ids = [];
		
		$existing = $this->find('list', [
			'recursive' => -1,
			'fields' => ['FovHostFovResult.fov_host_id', 'FovHostFovResult.fov_host_id'],
			'conditions' => [
				'FovHostFovResult.fov_result_id' => $fov_result_id,
			],
		]);
		
		$_fov_host_xref_data = $fov_result_xref_data;
		$fov_result_xref_data = [];
		foreach($_fov_host_xref_data as $fov_host_id => $xrefData)
		{
			$fov_result_xref_data[$fov_host_id] = $xrefData;
		}
		
		// get just the new ones
		foreach($existing as $fov_host_id)
		{
			if(isset($fov_host_ids[$fov_host_id]))
				unset($fov_host_ids[$fov_host_id]);
		}
		
		// build the proper save array
		$data = [];
		foreach($fov_host_ids as $fov_host_id)
		{
			$data[$fov_host_id] = ['fov_result_id' => $fov_result_id, 'fov_host_id' => $fov_host_id, 'active' => 1];
			
			if(isset($fov_result_xref_data[$fov_host_id]))
			{
				$data[$fov_host_id] = array_merge($fov_result_xref_data[$fov_host_id], $data[$fov_host_id]);
			}
		}
		
		if(!$data)
			return true;
		
		return $this->saveMany($data);
	}
	
	public function saveAssociatedResults($fov_host_id = false, $fov_result_ids = [], $fov_result_xref_data = [])
	{
		if(!$fov_host_id) return false;
		if(!$fov_result_ids) $fov_result_ids = [];
		
		$existing = $this->find('list', [
			'recursive' => -1,
			'fields' => ['FovHostFovResult.fov_result_id', 'FovHostFovResult.fov_result_id'],
			'conditions' => [
				'FovHostFovResult.fov_host_id' => $fov_host_id,
			],
		]);
		
		$_fov_host_xref_data = $fov_result_xref_data;
		$fov_result_xref_data = [];
		foreach($_fov_host_xref_data as $fov_result_id => $xrefData)
		{
			$fov_result_xref_data[$fov_result_id] = $xrefData;
		}
		
		// get just the new ones
		foreach($existing as $fov_result_id)
		{
			if(isset($fov_result_ids[$fov_result_id]))
				unset($fov_result_ids[$fov_result_id]);
		}
		
		// build the proper save array
		$data = [];
		foreach($fov_result_ids as $fov_result_id)
		{
			$data[$fov_result_id] = ['fov_host_id' => $fov_host_id, 'fov_result_id' => $fov_result_id, 'active' => 1];
			
			if(isset($fov_result_xref_data[$fov_result_id]))
			{
				$data[$fov_result_id] = array_merge($fov_result_xref_data[$fov_result_id], $data[$fov_result_id]);
			}
		}
		
		if(!$data)
			return true;
		
		return $this->saveMany($data);
	}
	
	public function checkAddUpdate($fov_result_id = false, $fov_host_id = false, $extra = [])
	{
		$conditions = [
			'fov_result_id' => $fov_result_id,
			'fov_host_id' => $fov_host_id,
		];
		
		if(!$fovHost_fovResult = $this->find('first', ['conditions' => $conditions]))
		{
			// not an existing one, create it
			$this->create();
			$this->data = array_merge(['fov_result_id' => $fov_result_id, 'fov_host_id' => $fov_host_id], $extra);
			if($this->save($this->data))
			{
				return $this->id;
			}
		}
		$this->id = $fovHost_fovResult[$this->alias]['id'];
		
		/// see if we need to update the record
		$update = [];
		
		// check the extras
		if($extra)
		{
			foreach($extra as $ex_field => $ex_value)
			{
				if(isset($fovHost_fovResult[$this->alias][$ex_field]) and $ex_value != $fovHost_fovResult[$this->alias][$ex_field])
					$update[$ex_field] = $ex_value;
			}
		}
		
		if($update)
		{
			$this->data = $update;
			$this->save($this->data);
		}
		return $this->id;
	}
}
