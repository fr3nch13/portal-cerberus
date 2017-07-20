<?php

App::uses('Hash', 'Core');
class PoamBehavior extends ModelBehavior 
{
	public $settings = [];
	
	private $_defaults = [];
	
	public $scopes = [];
	
	public function setup(Model $Model, $config = []) 
	{
		$this->settings[$Model->alias] = array_merge($this->_defaults, $config);
		
		$this->scopes = [
			'org' => __('ORG/IC'),
			'division' => __('Division'),
			'branch' => __('Branch'),
			'sac' => __('SAC'),
			'owner' => __('System Owner'),
			'system' => __('FISMA System'),
		];
	}
	
	public function beforeSave(Model $Model, $options = [])
	{
		if(isset($Model->data[$Model->alias]['name']) and !isset($Model->data[$Model->alias]['slug']))
		{
			$Model->data[$Model->alias]['slug'] = $Model->slugify($Model->data[$Model->alias]['name']);
		}
		
		return parent::beforeSave($Model, $options);
	}
	
	public function checkAdd(Model $Model, $name = false, $extra = [])
	{
		if(!$name) return false;
		
		$name = trim($name);
		if(!$name) return false;
		
		$slug = $Model->slugify($name);
		
		if($id = $Model->field($Model->primaryKey, [$Model->alias.'.slug' => $slug]))
		{
			return $id;
		}
		
		// not an existing one, create it
		$Model->create();
		$Model->data = array_merge(['name' => $name, 'slug' => $slug], $extra);
		if($Model->save($Model->data))
		{
			return $Model->id;
		}
		return false;
	}
	
	public function checkAdds(Model $Model, $names = [], $extra = [])
	{
		if(!is_array($names))
			return [];
		if(!$names)
			return [];
		$ids = [];
		
		$names = array_flip($names); 
		$names = array_flip($names);
		
		foreach($names as $name)
		{
			$slug = $Model->slugify($name);
			
			if(isset($ids[$slug]))
				continue;
			$id = $this->checkAdd($Model, $name, $extra);
			$ids[$slug] = $id;
		}
		return $ids;
	}
	
	public function orphanConditions(Model $Model)
	{
		$conditions = array(
			$Model->alias.'.fisma_system_id' => 0,
		);
		return $conditions;
	}
	
	public function conditionsforFismaSystem(Model $Model, $fisma_system_id = false)
	{
		if(!$fisma_system_id)
			return [];
		
		$conditions = [
			$Model->alias.'.fisma_system_id' => $fisma_system_id,
		];
		
		return $conditions;
	}
	
	public function unfilteredScopedResults(Model $Model, $scope = 'org', $scopeArgs = [], $fismaSystemConditions = [])
	{
		$modelClassPlural = Inflector::pluralize($Model->alias);
		
		$resultDefault = [
			'id' => false,
			'name' => false,
			'url' => ['controller' => false, 'action' => 'view', 0 => false],
			'fismaSystemIds' => [],
			'inventory' => [
				'ip_addresses' => [],
				'host_names' => [],
				'mac_addresses' => [],
				'asset_tags' => [],
			],
			$modelClassPlural => [],
		];
		
		$results = [];
		
		$FismaSystem = false;
		if($Model->alias == 'FismaSystem')
		{
			$FismaSystem = &$Model;
		}
		else
		{
			$FismaSystem = &$Model->FismaSystem;
		}
		
		if($scope == 'org')
		{
			$orgs = $FismaSystem->OwnerContact->Sac->Branch->Division->Org->find('all', $scopeArgs);
			
			foreach($orgs as $org)
			{
				$i = $org['Org']['id'];
				// no fisma systems
				if(!$fismaSystemIds = $FismaSystem->idsForOrg($org['Org']['id'], $fismaSystemConditions))
				{
					continue;
				}
				$results[$i] = $resultDefault;
				$results[$i]['id'] = $org['Org']['id'];
				$results[$i]['name'] = $org['Org']['name'];
				$results[$i]['object'] = $org;
				$results[$i]['url']['controller'] = 'orgs';
				$results[$i]['url'][0] = $org['Org']['id'];
				$results[$i]['fismaSystemIds'] = $fismaSystemIds;
			}
		}
		elseif($scope == 'division')
		{
			$scopeArgs = array_merge($scopeArgs, [
				'contain' => ['Org'],
			]);
			$divisions = $FismaSystem->OwnerContact->Sac->Branch->Division->find('all', $scopeArgs);
			foreach($divisions as $division)
			{
				$i = $division['Division']['id'];
				// no fisma systems
				if(!$fismaSystemIds = $FismaSystem->idsForDivision($division['Division']['id'], $fismaSystemConditions))
				{
					continue;
				}
				
				$results[$i] = $resultDefault;
				$results[$i]['id'] = $division['Division']['id'];
				$results[$i]['name'] = $division['Division']['name'];
				$results[$i]['object'] = $division;
				$results[$i]['url']['controller'] = 'divisions';
				$results[$i]['url'][0] = $division['Division']['id'];
				$results[$i]['fismaSystemIds'] = $fismaSystemIds;
			}
		}
		elseif($scope == 'branch')
		{
			$scopeArgs = array_merge($scopeArgs, [
				'contain' => ['Division', 'Division.Org'],
			]);
			$branches = $FismaSystem->OwnerContact->Sac->Branch->find('all', $scopeArgs);
			foreach($branches as $branch)
			{
				$i = $branch['Branch']['id'];
				// no fisma systems
				if(!$fismaSystemIds = $FismaSystem->idsForBranch($branch['Branch']['id'], $fismaSystemConditions))
				{
					continue;
				}
				$results[$i] = $resultDefault;
				$results[$i]['id'] = $branch['Branch']['id'];
				$results[$i]['name'] = $branch['Branch']['name'];
				$results[$i]['object'] = $branch;
				$results[$i]['url']['controller'] = 'branches';
				$results[$i]['url'][0] = $branch['Branch']['id'];
				$results[$i]['fismaSystemIds'] = $fismaSystemIds;
			}
		}
		elseif($scope == 'sac')
		{
			$scopeArgs = array_merge($scopeArgs, [
				'contain' => ['Branch', 'Branch.Division', 'Branch.Division.Org'],
			]);
			$sacs = $FismaSystem->OwnerContact->Sac->find('all', $scopeArgs);
			foreach($sacs as $i => $sac)
			{
				$i = $sac['Sac']['id'];
				// no fisma systems
				if(!$fismaSystemIds = $FismaSystem->idsForSac($sac['Sac']['id'], $fismaSystemConditions))
				{
					continue;
				}
				$results[$i] = $resultDefault;
				$results[$i]['id'] = $sac['Sac']['id'];
				$results[$i]['name'] = $sac['Sac']['shortname'];
				$results[$i]['object'] = $sac;
				$results[$i]['url']['controller'] = 'sacs';
				$results[$i]['url'][0] = $sac['Sac']['id'];
				$results[$i]['fismaSystemIds'] = $fismaSystemIds;
			}
		}
		elseif(in_array($scope, array('owner', 'ad_account')))
		{
			$scopeArgs = array_merge($scopeArgs, [
				'contain' => ['Sac', 'Sac.Branch', 'Sac.Branch.Division', 'Sac.Branch.Division.Org'],
			]);
			$owners = $FismaSystem->OwnerContact->find('all', $scopeArgs);
			foreach($owners as $owner)
			{
				$i = $owner['OwnerContact']['id'];
				$owner['AdAccount'] = $owner['OwnerContact'];
				
				// no fisma systems
				if(!$fismaSystemIds = $FismaSystem->idsForOwnerContact($owner['OwnerContact']['id'], $fismaSystemConditions))
				{
					continue;
				}
				$results[$i] = $resultDefault;
				$results[$i]['id'] = $owner['OwnerContact']['id'];
				$results[$i]['name'] = $owner['OwnerContact']['name'];
				$results[$i]['object'] = $owner;
				$results[$i]['url']['controller'] = 'ad_accounts';
				$results[$i]['url'][0] = $owner['OwnerContact']['id'];
				$results[$i]['fismaSystemIds'] = $fismaSystemIds;
			}
		}
		elseif(in_array($scope, array('system', 'fisma_system')))
		{
			$scopeArgs = array_merge($scopeArgs, [
				'contain' => ['OwnerContact', 'OwnerContact.Sac', 'OwnerContact.Sac.Branch', 'OwnerContact.Sac.Branch.Division', 'OwnerContact.Sac.Branch.Division.Org'],
			]);
			$fismaSystems = $FismaSystem->find('all', $scopeArgs);
			foreach($fismaSystems as $fismaSystem)
			{
				$i = $fismaSystem['FismaSystem']['id'];
				$fismaSystem['AdAccount'] = $fismaSystem['OwnerContact'];
				
				$results[$i] = $resultDefault;
				$results[$i]['id'] = $fismaSystem['FismaSystem']['id'];
				$results[$i]['name'] = $fismaSystem['FismaSystem']['name'];
				$results[$i]['object'] = $fismaSystem;
				$results[$i]['url']['controller'] = 'fisma_systems';
				$results[$i]['url'][0] = $fismaSystem['FismaSystem']['id'];
				$results[$i]['fismaSystemIds'] = [$fismaSystem['FismaSystem']['id'] => $fismaSystem['FismaSystem']['id']];
			}
		}
		elseif($scope == 'crm')
		{
			$scopeArgs = array_merge($scopeArgs, [
				'contain' => ['OwnerContact', 'OwnerContact.Sac', 'OwnerContact.Sac.Branch', 'OwnerContact.Sac.Branch.Division', 'OwnerContact.Sac.Branch.Division.Org'],
			]);
			$fismaSystems = $FismaSystem->find('all', $scopeArgs);
			foreach($fismaSystems as $fismaSystem)
			{
				$i = $fismaSystem['FismaSystem']['id'];
				$fismaSystem['AdAccount'] = $fismaSystem['OwnerContact'];
				
				$results[$i] = $resultDefault;
				$results[$i]['id'] = $fismaSystem['FismaSystem']['id'];
				$results[$i]['name'] = $fismaSystem['FismaSystem']['name'];
				$results[$i]['object'] = $fismaSystem;
				$results[$i]['url']['controller'] = 'fisma_systems';
				$results[$i]['url'][0] = $fismaSystem['FismaSystem']['id'];
				$results[$i]['fismaSystemIds'] = [$fismaSystem['FismaSystem']['id'] => $fismaSystem['FismaSystem']['id']];
			}
		}
		return $results;
	}
	
	public function scopedResults(Model $Model, $scope = 'org', $conditions = [], $scopeArgs = [], $fismaSystemConditions = [])
	{
		$FismaSystem = false;
		if($Model->alias == 'FismaSystem')
		{
			$FismaSystem = &$Model;
		}
		else
		{
			$FismaSystem = &$Model->FismaSystem;
		}
		$modelClassPlural = Inflector::pluralize($Model->alias);
		
		$results = $this->unfilteredScopedResults($Model, $scope, $scopeArgs, $fismaSystemConditions);
		
		$returningConditions = array('OR' => []);
		foreach($results as $resultId => $result)
		{
			$resultConditions = array_merge($conditions, [
				$Model->alias.'.fisma_system_id' => $result['fismaSystemIds'],
			]);
			
			$myResults = $Model->find('all', [
				'conditions' => $resultConditions,
			]);
			
			if(!$myResults)
			{
				unset($results[$resultId]);
				continue;
			}
			
			$results[$resultId][$modelClassPlural] = $myResults;
		}
		
		return $results;
	}
	
	public function findforTable(Model $Model)
	{
		$conditions = [];
		
		$results = $Model->find('all', [
			'conditions' => $conditions,
		]);
		return $results;
	}
	
	public function scopes(Model $Model)
	{
		return $this->scopes;
	}
	
	public function scopeName(Model $Model, $scope = false)
	{
		if(!$scope)
			return false;
			
		if(isset($this->scopes[$scope]))
			return $this->scopes[$scope];
		
		return false;
	}
}