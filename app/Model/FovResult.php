<?php
App::uses('AppModel', 'Model');

class FovResult extends AppModel 
{
	public $order = ['FovResult.id' => 'DESC'];
	
	public $belongsTo = [
		'FovResultAddedUser' => [
			'className' => 'User',
			'foreignKey' => 'added_user_id',
		],
		'FovResultModifiedUser' => [
			'className' => 'User',
			'foreignKey' => 'modified_user_id',
		],
		'FovResultRemediationUser' => [
			'className' => 'User',
			'foreignKey' => 'remediation_user_id',
		],
		'FovResultVerificationUser' => [
			'className' => 'User',
			'foreignKey' => 'verification_user_id',
		],
		'FovResultStatusUser' => [
			'className' => 'User',
			'foreignKey' => 'status_user_id',
		],
		'EolSoftware' => [
			'className' => 'EolSoftware',
			'foreignKey' => 'eol_software_id',
			'plugin_filter' => [
				'name' => 'EOL Software',
			],
			'plugin_snapshot' => true,
			'multiselect' => true,
			'nameSingle' => 'EOL Software',
		],
		'ReportsAssignableParty' => [
			'className' => 'ReportsAssignableParty',
			'foreignKey' => 'reports_assignable_party_id',
			'plugin_filter' => [
				'name' => 'Assignable Party',
			],
			'plugin_snapshot' => true,
			'multiselect' => true,
			'nameSingle' => 'Assignable Party',
		],
		'ReportsOrganization' => [
			'className' => 'ReportsOrganization',
			'foreignKey' => 'reports_organization_id',
			'plugin_filter' => true,
			'plugin_snapshot' => true,
			'multiselect' => true,
			'nameSingle' => 'Organization',
		],
		'ReportsRemediation' => [
			'className' => 'ReportsRemediation',
			'foreignKey' => 'reports_remediation_id',
			'plugin_filter' => [
				'name' => 'Remediation',
			],
			'plugin_snapshot' => true,
			'multiselect' => true,
			'nameSingle' => 'Remediation',
		],
		'ReportsSeverity' => [
			'className' => 'ReportsSeverity',
			'foreignKey' => 'reports_severity_id',
			'plugin_filter' => [
				'name' => 'Severity',
			],
			'plugin_snapshot' => true,
			'multiselect' => true,
			'nameSingle' => 'Severity',
		],
		'ReportsStatus' => [
			'className' => 'ReportsStatus',
			'foreignKey' => 'reports_status_id',
			'plugin_filter' => [
				'name' => 'Status',
			],
			'plugin_snapshot' => true,
			'multiselect' => true,
			'nameSingle' => 'Status',
		],
		'ReportsSystemType' => [
			'className' => 'ReportsSystemType',
			'foreignKey' => 'reports_system_type_id',
			'plugin_filter' => [
				'name' => 'System Type',
			],
			'plugin_snapshot' => true,
			'multiselect' => true,
			'nameSingle' => 'System Type',
		],
		'ReportsVerification' => [
			'className' => 'ReportsVerification',
			'foreignKey' => 'reports_verification_id',
			'plugin_filter' => [
				'name' => 'Verification',
			],
			'plugin_snapshot' => true,
			'multiselect' => true,
			'nameSingle' => 'Verification',
		],
		'FismaSystem' => [
			'className' => 'FismaSystem',
			'foreignKey' => 'fisma_system_id',
			'multiselect' => true,
		],
	];
	
	public $hasAndBelongsToMany = [
		'FovHost' => [
			'className' => 'FovHost',
			'joinTable' => 'fov_hosts_fov_results',
			'foreignKey' => 'fov_result_id',
			'associationForeignKey' => 'fov_host_id',
			'unique' => 'keepExisting',
			'with' => 'FovHostFovResult',
		],
	];
	
	public $actsAs = [
		'ReportsResults',
		'Tags.Taggable',
		'Utilities.Extractor',
		'Usage.Usage' => [
			'onCreate' => true,
			'onDelete' => true,
		],
		'Snapshot.Stat' => [
			'entities' => [
				'all' => [],
				'created' => [],
				'modified' => [],
			],
		],
	];
	
	// define the fields that can be searched
	public $searchFields = [
		'FovResult.id',
		'FovResult.tickets',
		'FovResult.waiver',
		'FovResult.example_id',
		'EolSoftware.name',
		'ReportsAssignableParty.name',
		'ReportsOrganization.name',
		'ReportsRemediation.name',
		'ReportsStatus.name',
		'ReportsVerification.name',
		'FismaSystem.name',
	];
	
	public $includeCounts = false;
	
	public $includeHosts = false;
	
	public function afterFind($results = [], $primary = false)
	{
		if($this->includeHosts)
			foreach($results as $i => $result)
				$results[$i] = $this->includeHosts($result);
		
		return parent::afterFind($results, $primary);
	}
	
	public function addResult($data = [])
	{
		if(!$this->save($data))
		{
			$this->modelError = __('Unable to save the Result');
			return false;
		}
		
		$resultId = $this->id;
		
		$hostIds = [];
		if(isset($data[$this->alias]['hosts']))
		{
			$hostIds = $this->FovHost->importToResult($resultId, $data[$this->alias]['hosts']);
		}
		
		// save the new ids to the xref table
		if(count($hostIds))
			$this->FovHostFovResult->saveAssociatedHosts($resultId, $hostIds);
			
		return $resultId;
	}
	
	public function multiselectItems($data = [], $values = [])
	{
		$ids = [];
		if(isset($data['multiple']))
		{
			$ids = $data['multiple'];
		}
		
		if(!$ids)
			return false;
		
		$results = $this->find('list', [
			'recursive' => -1,
			'fields' => ['FovResult.id', 'FovResult.notes'],
			'conditions' => [
				'FovResult.id' => $ids,
			],
		]);
		
		$notes_info = __("\n\n---- %s - %s - user_id:%s ----\n",
			date('Y-m-d H:i:s'),
			AuthComponent::user('name'),
			AuthComponent::user('id')
		);
		
		$saveMany_data = [];
		foreach($results as $result_id => $result_notes)
		{	
			$saveMany_data[$result_id] = ['id' => $result_id];
			
			if(isset($values['FovResult']['notes']))
			{
				if(trim($values['FovResult']['notes']))
					$saveMany_data[$result_id]['notes'] = $result_notes. $notes_info. $values['FovResult']['notes'];
				else
					unset($values['FovResult']['notes']);
			}
			
			$saveMany_data[$result_id] = array_merge($values['FovResult'], $saveMany_data[$result_id]);
		}
		
		return $this->saveMany($saveMany_data);
	}
	
	public function includeHosts($result = [])
	{
	/* adds compatibility to the ReportsResults Behavior*/ 
		if(!isset($result[$this->alias]))
			return $result;
		if(!isset($result[$this->alias][$this->primaryKey]))
			return $result;
		
		$result[$this->alias]['ip_address'] = [];
		$result[$this->alias]['host_name'] = [];
		$result[$this->alias]['mac_address'] = [];
		$result[$this->alias]['asset_tag'] = [];
		
		// get all of the hosts that are associated with this result
		$hosts = $this->FovHostFovResult->find('all', [
			'conditions' => [
				'FovHostFovResult.fov_result_id' => $result[$this->alias][$this->primaryKey],
			],
			'contain' => ['FovHost']
		]);
		
		foreach($hosts as $host)
		{
			if($host['FovHost']['ip_address'])
				$result[$this->alias]['ip_address'][$host['FovHost']['ip_address']] = $host['FovHost']['ip_address'];
			if($host['FovHost']['host_name'])
				$result[$this->alias]['host_name'][$host['FovHost']['host_name']] = $host['FovHost']['host_name'];
			if($host['FovHost']['mac_address'])
				$result[$this->alias]['mac_address'][$host['FovHost']['mac_address']] = $host['FovHost']['mac_address'];
			if($host['FovHost']['asset_tag'])
				$result[$this->alias]['asset_tag'][$host['FovHost']['asset_tag']] = $host['FovHost']['asset_tag'];
		}
		
		return $result;
	}
	
	public function snapshotDashboardGetStats($snapshotKeyRegex = false, $start = false, $end = false)
	{
		return $this->Snapshot_dashboardStats($snapshotKeyRegex, $start, $end);
	}
	
	public function snapshotStats()
	{
		$entities = $this->Snapshot_dynamicEntities();
		return [];
	}
}
