<?php

class ReportsResultsBehavior extends ModelBehavior 
{
	public $settings = [];
	
	private $_defaults = [];
	
	public $currentRecord = [];
	public $newRecord = [];
	
	public $includeCounts = true;
	
	
	public function setup(Model $Model, $config = []) 
	{
		$this->settings[$Model->alias] = array_merge($this->_defaults, $config);
		
		if(!isset($Model->includeCounts))
			$Model->includeCounts = $this->includeCounts;
	}
	
	public function beforeValidate(Model $Model, $options = [])
	{
		$Model->data = $this->fixData($Model, $Model->data);
		
		return parent::beforeValidate($Model, $options);
	}
	
	public function beforeSave(Model $Model, $options = [])
	{
		// see if we're updating this inventory. if so, get the current record from the db
		if(isset($Model->id))
		{
			$this->newRecord = $Model->data;
			$this->currentRecord = $Model->read(null, $Model->id);
			$Model->data = $this->newRecord;
		}
		
		$Model->data = $this->fixData($Model, $Model->data);
		
		if(isset($Model->data[$Model->alias]) and isset($this->currentRecord[$Model->alias]))
		{
			if(array_key_exists('reports_severity_id', $Model->data[$Model->alias]))
			{
				if($this->currentRecord[$Model->alias]['reports_severity_id'] != $Model->data[$Model->alias]['reports_severity_id'])
				{
					$Model->data[$Model->alias]['severity_user_id'] = AuthComponent::user('id');
					$Model->data[$Model->alias]['severity_date'] = date('Y-m-d H:i:s');
				}
			}
			if(array_key_exists('reports_organization_id', $Model->data[$Model->alias]))
			{
				if($this->currentRecord[$Model->alias]['reports_organization_id'] != $Model->data[$Model->alias]['reports_organization_id'])
				{
					$Model->data[$Model->alias]['organization_user_id'] = AuthComponent::user('id');
					$Model->data[$Model->alias]['organization_date'] = date('Y-m-d H:i:s');
				}
			}
			if(array_key_exists('reports_assignable_party_id', $Model->data[$Model->alias]))
			{
				if($this->currentRecord[$Model->alias]['reports_assignable_party_id'] != $Model->data[$Model->alias]['reports_assignable_party_id'])
				{
					$Model->data[$Model->alias]['assignable_party_user_id'] = AuthComponent::user('id');
					$Model->data[$Model->alias]['assignable_party_date'] = date('Y-m-d H:i:s');
				}
			}
			if(array_key_exists('reports_remediation_id', $Model->data[$Model->alias]))
			{
				if($this->currentRecord[$Model->alias]['reports_remediation_id'] != $Model->data[$Model->alias]['reports_remediation_id'])
				{
					$Model->data[$Model->alias]['remediation_user_id'] = AuthComponent::user('id');
					$Model->data[$Model->alias]['remediation_date'] = date('Y-m-d H:i:s');
				}
			}
			if(array_key_exists('reports_verification_id', $Model->data[$Model->alias]))
			{
				if($this->currentRecord[$Model->alias]['reports_verification_id'] != $Model->data[$Model->alias]['reports_verification_id'])
				{
					$Model->data[$Model->alias]['verification_user_id'] = AuthComponent::user('id');
					$Model->data[$Model->alias]['verification_date'] = date('Y-m-d H:i:s');
				}
			}
			if(array_key_exists('reports_status_id', $Model->data[$Model->alias]))
			{
				if($this->currentRecord[$Model->alias]['reports_status_id'] != $Model->data[$Model->alias]['reports_status_id'])
				{
					$Model->data[$Model->alias]['status_user_id'] = AuthComponent::user('id');
					$Model->data[$Model->alias]['status_date'] = date('Y-m-d H:i:s');
				}
			}
			if(array_key_exists('reports_system_type_id', $Model->data[$Model->alias]))
			{
				if($this->currentRecord[$Model->alias]['reports_system_type_id'] != $Model->data[$Model->alias]['reports_system_type_id'])
				{
					$Model->data[$Model->alias]['system_type_user_id'] = AuthComponent::user('id');
					$Model->data[$Model->alias]['system_type_date'] = date('Y-m-d H:i:s');
				}
			}
		}
		
		return parent::beforeSave($Model, $options);
	}
	
	public function afterSave(Model $Model, $created = false, $options = [])
	{
		/// log any changes
		$logModel = $Model->name.'Log';
		if(isset($Model->{$logModel}) and method_exists($Model->{$logModel}, 'logChanges'))
		{
			$Model->{$logModel}->logChanges($Model->id, $this->currentRecord, $this->newRecord);
		}
		
		$inf_plural = Inflector::tableize($Model->name);
		$inf_single = Inflector::singularize($inf_plural);
		
		$rescan = false; // if the ip address is changed, recheck the subnets
		if($created)
		{
			if ($Model->Behaviors->enabled('Usage.Usage'))
			{
				$Model->Usage_updateCounts('created', $inf_plural);
				$Model->Usage_updateCounts($inf_plural, 'created');
				$Model->Usage_updateCounts($inf_single.'.created', 'snapshot');
			}
			$rescan = true;
		}
		else
		{
			if ($Model->Behaviors->enabled('Usage.Usage'))
			{
				$Model->Usage_updateCounts('modified', $inf_plural);
				$Model->Usage_updateCounts($inf_plural, 'modified');
			}
			/// see if any of the ip address  changed
			if(isset($this->currentRecord[$Model->alias]['ip_address']) and isset($this->newRecord[$Model->alias]['ip_address']))
				if($this->currentRecord[$Model->alias]['ip_address'] != $this->newRecord[$Model->alias]['ip_address'])
					$rescan = true;
		}
		if($rescan)
		{
			$this->rescan($Model, $Model->id);
		}
		
		return parent::afterSave($Model, $created, $options);
	}
	
	public function afterFind(Model $Model, $results = [], $primary = false)
	{
		if($results and isset($Model->ReportsStatus) and $Model->includeCounts)
		{
			$countCache = [];
			foreach($results as $i => $result)
			{
				if(!isset($results[$i][$Model->alias]))
					continue;
				if(!isset($results[$i][$Model->alias]['id']))
					continue;
				
				$results[$i][$Model->alias]['us_count'] = 0;
				$results[$i][$Model->alias]['eol_count'] = 0;
				$results[$i][$Model->alias]['pt_count'] = 0;
				$results[$i][$Model->alias]['hr_count'] = 0;
				
				$conditionsUS = $conditionsEOL = $conditionsPT = $conditionsHR = ['OR' => []];
				
				if(isset($results[$i][$Model->alias]['ip_address']) and $results[$i][$Model->alias]['ip_address'])
				{
					$conditionsUS['OR']['UsResult.ip_address'] = $results[$i][$Model->alias]['ip_address'];
					$conditionsEOL['OR']['EolResult.ip_address'] = $results[$i][$Model->alias]['ip_address'];
					$conditionsPT['OR']['PenTestResult.ip_address'] = $results[$i][$Model->alias]['ip_address'];
					$conditionsHR['OR']['HighRiskResult.ip_address'] = $results[$i][$Model->alias]['ip_address'];
				}
				if(isset($results[$i][$Model->alias]['host_name']) and $results[$i][$Model->alias]['host_name'])
				{
					$conditionsUS['OR']['UsResult.host_name'] = $results[$i][$Model->alias]['host_name'];
					$conditionsEOL['OR']['EolResult.host_name'] = $results[$i][$Model->alias]['host_name'];
					$conditionsPT['OR']['PenTestResult.host_name'] = $results[$i][$Model->alias]['host_name'];
					$conditionsHR['OR']['HighRiskResult.host_name'] = $results[$i][$Model->alias]['host_name'];
				}
				if(isset($results[$i][$Model->alias]['mac_address']) and $results[$i][$Model->alias]['mac_address'])
				{
					$conditionsUS['OR']['UsResult.mac_address'] = $results[$i][$Model->alias]['mac_address'];
					$conditionsEOL['OR']['EolResult.mac_address'] = $results[$i][$Model->alias]['mac_address'];
					$conditionsPT['OR']['PenTestResult.mac_address'] = $results[$i][$Model->alias]['mac_address'];
					$conditionsHR['OR']['HighRiskResult.mac_address'] = $results[$i][$Model->alias]['mac_address'];
				}
				if(isset($results[$i][$Model->alias]['asset_tag']) and $results[$i][$Model->alias]['asset_tag'])
				{
					$conditionsUS['OR']['UsResult.asset_tag'] = $results[$i][$Model->alias]['asset_tag'];
					$conditionsEOL['OR']['EolResult.asset_tag'] = $results[$i][$Model->alias]['asset_tag'];
					$conditionsPT['OR']['PenTestResult.asset_tag'] = $results[$i][$Model->alias]['asset_tag'];
					$conditionsHR['OR']['HighRiskResult.asset_tag'] = $results[$i][$Model->alias]['asset_tag'];
				}
				
				if($conditionsUS['OR'])
					$results[$i][$Model->alias]['us_count'] = $Model->ReportsStatus->UsResult->find('count', [
						'recursive' => -1,
						'conditions' => $conditionsUS,
					]);
				if($conditionsEOL['OR'])
					$results[$i][$Model->alias]['eol_count'] = $Model->ReportsStatus->EolResult->find('count', [
						'recursive' => -1,
						'conditions' => $conditionsEOL,
					]);
				if($conditionsPT['OR'])
					$results[$i][$Model->alias]['pt_count'] = $Model->ReportsStatus->PenTestResult->find('count', [
						'recursive' => -1,
						'conditions' => $conditionsPT,
					]);
				if($conditionsHR['OR'])
					$results[$i][$Model->alias]['hr_count'] = $Model->ReportsStatus->HighRiskResult->find('count', [
						'recursive' => -1,
						'conditions' => $conditionsHR,
					]);
			}
		}
		return $results;
	}
	
	public function rescan(Model $Model, $id = false)
	{
		$methodName = 'subnetsTo'.$Model->name;
		if(!isset($Model->SubnetMember))
		{
			$Model->SubnetMember = ClassRegistry::init('SubnetMember');
		}
		if(method_exists($Model->SubnetMember, $methodName))
		{
			$Model->SubnetMember->{$methodName}($id);
		}
	}
	
	public function fixData(Model $Model, $data = [])
	{
		if(isset($data[$Model->alias]['mac_address']) and $data[$Model->alias]['mac_address'])
		{
			$data[$Model->alias]['mac_address'] = strtoupper($data[$Model->alias]['mac_address']);
			$data[$Model->alias]['mac_address'] = preg_replace('/[^a-zA-Z0-9]+/',"", $data[$Model->alias]['mac_address']);
		}
		
		return $data;
	}
	
	public function orphanConditions(Model $Model)
	{
		if(!isset($Model->SubnetMember))
		{
			$Model->SubnetMember = ClassRegistry::init('SubnetMember');
		}
		$fisma_inventories = $Model->SubnetMember->FismaInventory->find('all');
		
		if(!$fisma_inventories)
			return [];
		
		$inventoryIps = [];
		$inventoryHostNames = [];
		$inventoryMacAddresses = [];
		$inventoryAssetTags = [];
		foreach($fisma_inventories as $fisma_inventory)
		{
			$ip_address = trim($fisma_inventory['FismaInventory']['ip_address']);
			if($ip_address)
				$inventoryIps[$ip_address] = $ip_address;
			
			$host_name = trim($fisma_inventory['FismaInventory']['dns_name']);
			if($host_name)
				$inventoryHostNames[$host_name] = $host_name;
			
			$mac_address = trim($fisma_inventory['FismaInventory']['mac_address']);
			if($mac_address)
				$inventoryMacAddresses[$mac_address] = $mac_address;
			
			$asset_tag = trim($fisma_inventory['FismaInventory']['asset_tag']);
			if($asset_tag)
				$inventoryAssetTags[$asset_tag] = $asset_tag;
		}
		
		
		$conditions = [];
		
		if($inventoryIps)
			$conditions[$Model->alias.'.ip_address NOT IN'] = $inventoryIps;
		if($inventoryHostNames)
			$conditions[$Model->alias.'.host_name NOT IN'] = $inventoryHostNames;
		if($inventoryMacAddresses)
			$conditions[$Model->alias.'.mac_address NOT IN'] = $inventoryMacAddresses;
		if($inventoryAssetTags)
			$conditions[$Model->alias.'.asset_tag NOT IN'] = $inventoryAssetTags;
		
		return $conditions;
	}
	
	public function conditionsforMultipleFismaSystems(Model $Model, $conditions = [])
	{
		if(!isset($Model->SubnetMember))
		{
			$Model->SubnetMember = ClassRegistry::init('SubnetMember');
		}
		$includeCounts = $Model->includeCounts;
		$Model->includeCounts = false;
		$results = $Model->find('all', array(
			'fields' => array(
				$Model->alias.'.'.$Model->primaryKey, 
				$Model->alias.'.ip_address', 
				$Model->alias.'.host_name', 
				$Model->alias.'.mac_address', 
				$Model->alias.'.asset_tag', 
			),
			// override
			'conditions' => array($Model->alias.'.fisma_system_id' => 0),
		));
		$Model->includeCounts = $includeCounts;
		
		$resultIds = [];
		foreach($results as $i => $result)
		{
			$resultConditions = array('OR' => []);
		
			if(isset($result[$Model->alias]['ip_address']) and $result[$Model->alias]['ip_address'])
				$resultConditions['OR'][] = array(
					'FismaInventory.ip_address !=' => '',
					'FismaInventory.ip_address' => $result[$Model->alias]['ip_address'],
				);
			if(isset($result[$Model->alias]['host_name']) and $result[$Model->alias]['host_name'])
				$resultConditions['OR'][] = array(
					'FismaInventory.dns_name !=' => '',
					'FismaInventory.dns_name' => $result[$Model->alias]['host_name'],
				); 
			if(isset($result[$Model->alias]['mac_address']) and $result[$Model->alias]['mac_address'])
				$resultConditions['OR'][] = array(
					'FismaInventory.mac_address !=' => '',
					'FismaInventory.mac_address' => $result[$Model->alias]['mac_address'],
				);
			if(isset($result[$Model->alias]['asset_tag']) and $result[$Model->alias]['asset_tag'])
				$resultConditions['OR'][] = array(
					'FismaInventory.asset_tag !=' => '',
					'FismaInventory.asset_tag' => $result[$Model->alias]['asset_tag'],
				);
				
			$results[$i]['fisma_system_ids'] = [];
			if($resultConditions['OR'])
			{
				$results[$i]['fisma_system_ids'] = $Model->SubnetMember->FismaInventory->find('list', array(
					'recursive' => -1,
					'fields' => array('FismaInventory.fisma_system_id', 'FismaInventory.fisma_system_id'),
					'conditions' => $resultConditions,
				));
			}
			
			// not in multiple
			if(count($results[$i]['fisma_system_ids']) < 2)
			{
				continue;
			}
			$resultIds[$result[$Model->alias][$Model->primaryKey]] = $result[$Model->alias][$Model->primaryKey];
		}
		unset($results);
		
		$conditions = array_merge($conditions, array($Model->alias.'.'.$Model->primaryKey => $resultIds));
		
		return $conditions;
	}
	
	public function conditionsforFismaSystem(Model $Model, $fisma_system_id = false)
	{
		if(!$fisma_system_id)
			return [];
		
		if(!isset($Model->SubnetMember))
		{
			$Model->SubnetMember = ClassRegistry::init('SubnetMember');
		}
		$inventoryIps = $Model->SubnetMember->FismaInventory->FismaSystem->getRelatedIpAddresses($fisma_system_id);
		$inventoryHostNames = $Model->SubnetMember->FismaInventory->FismaSystem->getRelatedHostNames($fisma_system_id);
		$inventoryMacAddresses = $Model->SubnetMember->FismaInventory->FismaSystem->getRelatedMacAddresses($fisma_system_id);
		$inventoryAssetTags = $Model->SubnetMember->FismaInventory->FismaSystem->getRelatedAssetTags($fisma_system_id);
		if(!$inventoryIps and !$inventoryHostNames and !$inventoryMacAddresses and !$inventoryAssetTags)
		{
			return [];
		}
		
		$ResultObject = $Model;
		if($Model->name == 'FovResult')
			$ResultObject = $Model->FovHost;
		
		$conditions = [];
		
		$conditions['OR'] = array(
			$Model->alias.'.fisma_system_id' => $fisma_system_id,
			array($Model->alias.'.fisma_system_id' => 0)
		);
		
		
		if($inventoryIps)
			$conditions['OR'][0]['OR'][] = array(
				$ResultObject->alias.'.ip_address !=' => '',
				$ResultObject->alias.'.ip_address' => $inventoryIps,
			);
		if($inventoryHostNames)
			$conditions['OR'][0]['OR'][] = array(
				$ResultObject->alias.'.host_name !=' => '',
				$ResultObject->alias.'.host_name' => $inventoryHostNames,
			);
		if($inventoryMacAddresses)
			$conditions['OR'][0]['OR'][] = array(
				$ResultObject->alias.'.mac_address !=' => '',
				$ResultObject->alias.'.mac_address' => $inventoryMacAddresses,
			);
		if($inventoryAssetTags)
			$conditions['OR'][0]['OR'][] = array(
				$ResultObject->alias.'.asset_tag !=' => '',
				$ResultObject->alias.'.asset_tag' => $inventoryAssetTags,
			);
		return $conditions;
	}
	
	public function conditionsforInventory(Model $Model, $fisma_inventory_id = false)
	{
		if(!$fisma_inventory_id)
			return [];
		
		if(!isset($Model->SubnetMember))
		{
			$Model->SubnetMember = ClassRegistry::init('SubnetMember');
		}
		$fismaInventory = [];
		if(is_array($fisma_inventory_id))
		{
			if(isset($fisma_inventory_id['FismaInventory']['id']))
			{
				$fismaInventory = $fisma_inventory_id;
				$fisma_inventory_id = $fismaInventory['FismaInventory']['id'];
			}
		}
		else
		{
			$fismaInventory = $Model->SubnetMember->FismaInventory->read(null, $fisma_inventory_id);
		}
		
		if(!$fismaInventory)
			return [];
		
		$inventoryIp = trim($fismaInventory['FismaInventory']['ip_address']);
		if(in_array(strtoupper($inventoryIp), array('TBD', 'NA')))
			$inventoryIp = false;
		
		$inventoryHostName = trim($fismaInventory['FismaInventory']['dns_name']);
		if(in_array(strtoupper($inventoryHostName), array('TBD', 'NA')))
			$inventoryHostName = false;
		
		$inventoryMacAddress = trim($fismaInventory['FismaInventory']['mac_address']);
		if(in_array(strtoupper($inventoryMacAddress), array('TBD', 'NA')))
			$inventoryMacAddress = false;
		
		$inventoryAssetTag = trim($fismaInventory['FismaInventory']['asset_tag']);
		if(in_array(strtoupper($inventoryAssetTag), array('TBD', 'NA')))
			$inventoryAssetTag = false;
		
		if(!$inventoryIp and !$inventoryHostName and !$inventoryMacAddress and !$inventoryAssetTag)
		{
			return [];
		}
		
		$conditions = array('OR' => []);
		
		if($inventoryIp)
			$conditions['OR'][] = array(
				$Model->alias.'.ip_address !=' => '',
				$Model->alias.'.ip_address' => $inventoryIp,
			);
		if($inventoryHostName)
			$conditions['OR'][] = array(
				$Model->alias.'.host_name !=' => '',
				$Model->alias.'.host_name' => $inventoryHostName,
			); 
		if($inventoryMacAddress)
			$conditions['OR'][] = array(
				$Model->alias.'.mac_address !=' => '',
				$Model->alias.'.mac_address' => $inventoryMacAddress,
			);
		if($inventoryAssetTag)
			$conditions['OR'][] = array(
				$Model->alias.'.asset_tag !=' => '',
				$Model->alias.'.asset_tag' => $inventoryAssetTag,
			);
		return $conditions;
	}
	
	public function conditionsforResult(Model $Model, $otherModel = false, $other_result_id = false)
	{
		if(!$otherModel)
			return [];
			
		if(!$other_result_id)
			return [];
		
		$ResultObject = $Model;
		if($Model->name == 'FovResult')
			$ResultObject = $Model->FovHost;
		
		if(!isset($ResultObject->SubnetMember))
		{
			$ResultObject->SubnetMember = ClassRegistry::init('SubnetMember');
		}
		
		if(!is_object($otherModel))
		{
			if($Model->name == $otherModel)
				$otherModel = $ResultObject;
			elseif(isset($ResultObject->SubnetMember->{$otherModel}))
				$otherModel = $ResultObject->SubnetMember->{$otherModel};
			elseif(isset($ResultObject->FismaSystem->{$otherModel}))
				$otherModel = $ResultObject->FismaSystem->{$otherModel};
			else
				$otherModel = false;
		}
		else
		{
			$otherModelName = $otherModel->alias;
		}
		
		if(!$otherModel)
			return [];
		
		$otherModelName = $otherModel->name;
		
		if(is_array($other_result_id) and isset($other_result_id[$otherModelName]))
		{
			$otherResult = $other_result_id;
			$other_result_id = (isset($otherResult[$otherModelName][$otherModel->primaryKey])?$otherResult[$otherModelName][$otherModel->primaryKey]:false);
		}
		
		$otherResult = false;
		$otherIds = $otherIps = $otherHostNames = $otherMacAddresses = $otherAssetTags = [];
		if(in_array($otherModel->name, ['FovHost', 'FovResult']))
		{
			$otherIds[$other_result_id] = $other_result_id;
			if(!$otherResults = $otherModel->FovHostFovResult->find('all', [
				'contain' => ['FovHost'],
				'conditions' => ['FovHostFovResult.fov_result_id' => $other_result_id],
			]))
				return [];
			foreach($otherResults as $otherResult)
			{
				if($otherResult['FovHost']['ip_address'])
					$otherIps[$otherResult['FovHost']['ip_address']] = $otherResult['FovHost']['ip_address'];
				if($otherResult['FovHost']['host_name'])
					$otherHostNames[$otherResult['FovHost']['host_name']] = $otherResult['FovHost']['host_name'];
				if($otherResult['FovHost']['mac_address'])
					$otherMacAddresses[$otherResult['FovHost']['mac_address']] = $otherResult['FovHost']['mac_address'];
				if($otherResult['FovHost']['asset_tag'])
					$otherAssetTags[$otherResult['FovHost']['asset_tag']] = $otherResult['FovHost']['asset_tag'];
			}
		}
		else
		{
			if(!$otherResult = $otherModel->read(null, $other_result_id))
				return [];
				
			$otherId = ((isset($otherResult[$otherModelName][$otherModel->primaryKey]) and $otherResult[$otherModelName][$otherModel->primaryKey])?$otherResult[$otherModelName][$otherModel->primaryKey]:false);
			if($otherId) $otherIds[$otherId] = $otherId;
			$otherIp = ((isset($otherResult[$otherModelName]['ip_address']) and $otherResult[$otherModelName]['ip_address'])?$otherResult[$otherModelName]['ip_address']:false);
			if($otherIp) $otherIps[$otherIp] = $otherIp;
			$otherHostName = ((isset($otherResult[$otherModelName]['host_name']) and $otherResult[$otherModelName]['host_name'])?$otherResult[$otherModelName]['host_name']:false);
			if($otherHostName) $otherHostNames[$otherHostName] = $otherHostName;
			$otherMacAddress = ((isset($otherResult[$otherModelName]['mac_address']) and $otherResult[$otherModelName]['mac_address'])?$otherResult[$otherModelName]['mac_address']:false);
			if($otherMacAddress) $otherMacAddresses[$otherMacAddress] = $otherMacAddress;
			$otherAssetTag = ((isset($otherResult[$otherModelName]['asset_tag']) and $otherResult[$otherModelName]['asset_tag'])?$otherResult[$otherModelName]['asset_tag']:false);
			if($otherAssetTag) $otherAssetTags[$otherAssetTag] = $otherAssetTag;
		}
		
		$conditions = [];
		
		if($otherModelName == $ResultObject->alias and $otherIds)
		{
			if(count($otherIds) == 1)
				$otherIds = array_pop($otherIds);
			$conditions[$Model->alias.'.'.$Model->primaryKey. ' !='] = $otherIds;
		}
		
		foreach($otherIps as $i => $otherIp)
			if(in_array(strtoupper($otherIp), array('TBD', 'NA')))
				unset($otherIps[$i]);
		
		foreach($otherHostNames as $i => $otherHostName)
			if(in_array(strtoupper($otherHostName), array('TBD', 'NA')))
				unset($otherHostNames[$i]);
		
		foreach($otherMacAddresses as $i => $otherMacAddress)
			if(in_array(strtoupper($otherMacAddress), array('TBD', 'NA')))
				unset($otherMacAddresses[$i]);
		
		foreach($otherAssetTags as $i => $otherAssetTag)
			if(in_array(strtoupper($otherAssetTag), array('TBD', 'NA')))
				unset($otherAssetTags[$i]);
		
		if(!$otherIps and !$otherHostNames and !$otherMacAddresses and !$otherAssetTags)	
			return $conditions;
		
		if(count($otherIps) == 1)
			$otherIps = array_pop($otherIps);
		if(count($otherHostNames) == 1)
			$otherHostNames = array_pop($otherHostNames);
		if(count($otherMacAddresses) == 1)
			$otherMacAddresses = array_pop($otherMacAddresses);
		if(count($otherAssetTags) == 1)
			$otherAssetTags = array_pop($otherAssetTags);
		
		$conditions['OR'] = [];
		
		if($otherIps)
			$conditions['OR'][0]['OR'][] = [
				$ResultObject->alias.'.ip_address !=' => '',
				$ResultObject->alias.'.ip_address' => $otherIps,
			];
		if($otherHostNames)
			$conditions['OR'][0]['OR'][] = [
				$ResultObject->alias.'.host_name !=' => '',
				$ResultObject->alias.'.host_name' => $otherHostNames,
			];
		if($otherMacAddresses)
			$conditions['OR'][0]['OR'][] = [
				$ResultObject->alias.'.mac_address !=' => '',
				$ResultObject->alias.'.mac_address' => $otherMacAddresses,
			];
		if($otherAssetTags)
			$conditions['OR'][0]['OR'][] = [
				$ResultObject->alias.'.asset_tag !=' => '',
				$ResultObject->alias.'.asset_tag' => $otherAssetTags,
			];
		
		return $conditions;
	}
	
	public function attachFismaSystem(Model $Model, $result = [], $attachTechPoc = false)
	{
		if(!isset($result[$Model->alias]))
			return $result;
		
		if(!isset($Model->SubnetMember))
		{
			$Model->SubnetMember = ClassRegistry::init('SubnetMember');
		}
		
		$result['FismaInventories'] = [];
		$result['overridden'] = false;
		$resultConditions = array('OR' => []);
		if(isset($result[$Model->alias]['fisma_system_id']) and $result[$Model->alias]['fisma_system_id'])
		{
			$resultConditions['FismaInventory.fisma_system_id'] = $result[$Model->alias]['fisma_system_id'];
			$result['overridden'] = true;
		}
		
		if(isset($result[$Model->alias]['ip_address']) and $result[$Model->alias]['ip_address'])
			$resultConditions['OR'][] = array(
				'FismaInventory.ip_address !=' => '',
				'FismaInventory.ip_address' => $result[$Model->alias]['ip_address'],
			);
		if(isset($result[$Model->alias]['host_name']) and $result[$Model->alias]['host_name'])
			$resultConditions['OR'][] = array(
				'FismaInventory.dns_name !=' => '',
				'FismaInventory.dns_name' => $result[$Model->alias]['host_name'],
			); 
		if(isset($result[$Model->alias]['mac_address']) and $result[$Model->alias]['mac_address'])
			$resultConditions['OR'][] = array(
				'FismaInventory.mac_address !=' => '',
				'FismaInventory.mac_address' => $result[$Model->alias]['mac_address'],
			);
		if(isset($result[$Model->alias]['asset_tag']) and $result[$Model->alias]['asset_tag'])
			$resultConditions['OR'][] = array(
				'FismaInventory.asset_tag !=' => '',
				'FismaInventory.asset_tag' => $result[$Model->alias]['asset_tag'],
			);
				
		if($resultConditions['OR'])
		{
			$result['FismaInventories'] = $Model->SubnetMember->FismaInventory->find('all', array(
				'contain' => array(
					'FismaSystem', 'FismaSystem.OwnerContact', 'FismaSystem.OwnerContact.AdAccountDetail', 
					'FismaSystem.OwnerContact.Sac', 'FismaSystem.OwnerContact.Sac.Branch', 
					'FismaSystem.OwnerContact.Sac.Branch.Division', 'FismaSystem.OwnerContact.Sac.Branch.Division.Org'
				),
				'conditions' => $resultConditions,
			));
			
			if($attachTechPoc and count($result['FismaInventories']))
			{
				foreach($result['FismaInventories'] as $i => $fismaInventory)
				{
					$result['FismaInventories'][$i]['FismaSystem']['techPocs'] = $Model->SubnetMember->FismaInventory->FismaSystem->AdAccountFismaSystem->getTechs($result['FismaInventories'][$i]['FismaSystem']['id']);
				}
			}
		}
		return $result;
	}
	
	public function attachResultsToFismaSystem(Model $Model, $fismaSystem = [], $reportsStatus_ids = [])
	{
		if($Model->name != 'FismaSystem')
			return $fismaSystem;
		if(!isset($fismaSystem['FismaSystem']['id']))
			return $fismaSystem;
		
		$fismaSystemId = $fismaSystem['FismaSystem']['id'];
		
		$inventoryIps = $Model->getRelatedIpAddresses($fismaSystemId);
		$inventoryHostNames = $Model->getRelatedHostNames($fismaSystemId);
		$inventoryMacAddresses = $Model->getRelatedMacAddresses($fismaSystemId);
		$inventoryAssetTags = $Model->getRelatedAssetTags($fismaSystemId);
		
		$fismaSystem['UsResults'] = [];
		$fismaSystem['EolResults'] = [];
		$fismaSystem['PenTestResults'] = [];
		$fismaSystem['HighRiskResults'] = [];
		
		if($inventoryIps or $inventoryHostNames or $inventoryMacAddresses or $inventoryAssetTags)
		{
			$conditionsUsResult = array('OR' => array(
				'UsResult.fisma_system_id' => $fismaSystemId,
				array('UsResult.fisma_system_id' => 0)
			));
			$conditionsEolResult = array('OR' => array(
				'EolResult.fisma_system_id' => $fismaSystemId,
				array('EolResult.fisma_system_id' => 0)
			));
			$conditionsPenTestResult = array('OR' => array(
				'PenTestResult.fisma_system_id' => $fismaSystemId,
				array('PenTestResult.fisma_system_id' => 0)
			));
			$conditionsHighRiskResult = array('OR' => array(
				'HighRiskResult.fisma_system_id' => $fismaSystemId,
				array('HighRiskResult.fisma_system_id' => 0)
			));
			
			
			if($reportsStatus_ids)
			{
				$conditionsUsResult['UsResult.reports_status_id'] = $reportsStatus_ids;
				$conditionsEolResult['EolResult.reports_status_id'] = $reportsStatus_ids;
				$conditionsPenTestResult['PenTestResult.reports_status_id'] = $reportsStatus_ids;
				$conditionsHighRiskResult['HighRiskResult.reports_status_id'] = $reportsStatus_ids;
			}
			
			if($inventoryIps)
			{
				$conditionsUsResult['OR'][0]['OR'][] = array(
					'UsResult.ip_address !=' => '',
					'UsResult.ip_address' => $inventoryIps,
				);
				$conditionsEolResult['OR'][0]['OR'][] = array(
					'EolResult.ip_address !=' => '',
					'EolResult.ip_address' => $inventoryIps,
				);
				$conditionsPenTestResult['OR'][0]['OR'][] = array(
					'PenTestResult.ip_address !=' => '',
					'PenTestResult.ip_address' => $inventoryIps,
				);
				$conditionsHighRiskResult['OR'][0]['OR'][] = array(
					'HighRiskResult.ip_address !=' => '',
					'HighRiskResult.ip_address' => $inventoryIps,
				);
			}
			if($inventoryHostNames)
			{
				$conditionsUsResult['OR'][0]['OR'][] = array(
					'UsResult.host_name !=' => '',
					'UsResult.host_name' => $inventoryHostNames,
				); 
				$conditionsEolResult['OR'][0]['OR'][] = array(
					'EolResult.host_name !=' => '',
					'EolResult.host_name' => $inventoryHostNames,
				); 
				$conditionsPenTestResult['OR'][0]['OR'][] = array(
					'PenTestResult.host_name !=' => '',
					'PenTestResult.host_name' => $inventoryHostNames,
				); 
				$conditionsHighRiskResult['OR'][0]['OR'][] = array(
					'HighRiskResult.host_name !=' => '',
					'HighRiskResult.host_name' => $inventoryHostNames,
				); 
			}
			if($inventoryMacAddresses)
			{
				$conditionsUsResult['OR'][0]['OR'][] = array(
					'UsResult.mac_address !=' => '',
					'UsResult.mac_address' => $inventoryMacAddresses,
				);
				$conditionsEolResult['OR'][0]['OR'][] = array(
					'EolResult.mac_address !=' => '',
					'EolResult.mac_address' => $inventoryMacAddresses,
				);
				$conditionsPenTestResult['OR'][0]['OR'][] = array(
					'PenTestResult.mac_address !=' => '',
					'PenTestResult.mac_address' => $inventoryMacAddresses,
				);
				$conditionsHighRiskResult['OR'][0]['OR'][] = array(
					'HighRiskResult.mac_address !=' => '',
					'HighRiskResult.mac_address' => $inventoryMacAddresses,
				);
			}
			if($inventoryAssetTags)
			{
				$conditionsUsResult['OR'][0]['OR'][] = array(
					'UsResult.asset_tag !=' => '',
					'UsResult.asset_tag' => $inventoryAssetTags,
				);
				$conditionsEolResult['OR'][0]['OR'][] = array(
					'EolResult.asset_tag !=' => '',
					'EolResult.asset_tag' => $inventoryAssetTags,
				);
				$conditionsPenTestResult['OR'][0]['OR'][] = array(
					'PenTestResult.asset_tag !=' => '',
					'PenTestResult.asset_tag' => $inventoryAssetTags,
				);
				$conditionsHighRiskResult['OR'][0]['OR'][] = array(
					'HighRiskResult.asset_tag !=' => '',
					'HighRiskResult.asset_tag' => $inventoryAssetTags,
				);
			}
			
			$fismaSystem['UsResult'] = [];
			if($conditionsUsResult['OR'])
				$fismaSystem['UsResult'] = $Model->FismaInventory->SubnetMember->UsResult->find('all', array(
					'conditions' => $conditionsUsResult,
				));
			
			$fismaSystem['EolResults'] = [];
			if($conditionsEolResult['OR'])
				$fismaSystem['EolResults'] = $Model->FismaInventory->SubnetMember->EolResult->find('all', array(
					'contain' => array('ReportsStatus'),
					'conditions' => $conditionsEolResult,
				));
			
			$fismaSystem['PenTestResults'] = [];
			if($conditionsPenTestResult['OR'])
				$fismaSystem['PenTestResults'] = $Model->FismaInventory->SubnetMember->PenTestResult->find('all', array(
					'conditions' => $conditionsPenTestResult,
				));
			
			$fismaSystem['HighRiskResults'] = [];
			if($conditionsHighRiskResult['OR'])
				$fismaSystem['HighRiskResults'] = $Model->FismaInventory->SubnetMember->HighRiskResult->find('all', array(
					'conditions' => $conditionsHighRiskResult,
				));
		}
		return $fismaSystem;
	}
	
	public function nameForResult(Model $Model, $otherModel = false, $other_result_id = false)
	{
		if(!$otherModel)
			return false;
			
		if(!$other_result_id)
			return false;
		
		if(!isset($Model->SubnetMember))
		{
			$Model->SubnetMember = ClassRegistry::init('SubnetMember');
		}
		
		$otherModelName = false;
		if(!is_object($otherModel))
		{
			$otherModelName = $otherModel;
			if($Model->name == $otherModel)
				$otherModel = $Model;
			elseif(isset($Model->SubnetMember->{$otherModel}))
				$otherModel = $Model->SubnetMember->{$otherModel};
			elseif(isset($Model->FismaSystem->{$otherModel}))
				$otherModel = $Model->FismaSystem->{$otherModel};
			else
				$otherModel = false;
		}
		else
		{
			$otherModelName = $otherModel->alias;
		}
		
		if(!$otherModel)
			return false;
		
		if(!$otherModelName)
			return false;
		
		$otherResult = false;
		if(is_array($other_result_id) and isset($other_result_id[$otherModelName]))
		{
			$otherResult = $other_result_id;
			$other_result_id = (isset($otherResult[$otherModelName][$otherModel->primaryKey])?:false);
		}
		else
		{
			$otherResult = $otherModel->read(null, $other_result_id);
		}
		
		if(!$otherResult)
			return false;
		
		$result_name = false;
		
		if(!$result_name and isset($otherResult[$otherModelName]['host_description']) and $otherResult[$otherModelName]['host_description'])
			$result_name = $otherResult[$otherModelName]['host_description'];
		
		if(!$result_name and isset($otherResult[$otherModelName]['asset_tag']) and $otherResult[$otherModelName]['asset_tag'])
			$result_name = $otherResult[$otherModelName]['asset_tag'];
		
		if(!$result_name and isset($otherResult[$otherModelName]['mac_address']) and $otherResult[$otherModelName]['mac_address'])
			$result_name = $otherResult[$otherModelName]['mac_address'];
		
		if(!$result_name and isset($otherResult[$otherModelName]['host_name']) and $otherResult[$otherModelName]['host_name'])
			$result_name = $otherResult[$otherModelName]['host_name'];
		
		if(!$result_name and isset($otherResult[$otherModelName]['ip_address']) and $otherResult[$otherModelName]['ip_address'])
			$result_name = $otherResult[$otherModelName]['ip_address'];
		
		if(!$result_name)
			$result_name = $otherResult[$otherModelName][$otherModel->primaryKey];
		
		return $result_name;
	}
	
/** Mainly used by the dashboards, and more specificaly for the dashboards scoped by user roles/prefixes **/
	
	public function unfilteredScopedResults(Model $Model, $scope = 'org', $scopeArgs = [], $fismaSystemConditions = [])
	{
		$modelClassPlural = Inflector::pluralize($Model->alias);
		
		$resultDefault = array(
			'id' => false,
			'name' => false,
			'url' => array('controller' => false, 'action' => 'view', 0 => false),
			'fismaSystemIds' => [],
			'inventory' => array(
				'ip_addresses' => [],
				'host_names' => [],
				'mac_addresses' => [],
				'asset_tags' => [],
			),
			$modelClassPlural => [],
		);
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
			$scopeArgs = array_merge($scopeArgs, array(
				'contain' => array('Org'),
			));
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
			$scopeArgs = array_merge($scopeArgs, array(
				'contain' => array('Division', 'Division.Org'),
			));
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
			$scopeArgs = array_merge($scopeArgs, array(
				'contain' => array('Branch', 'Branch.Division', 'Branch.Division.Org'),
			));
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
			$scopeArgs = array_merge($scopeArgs, array(
				'contain' => array('Sac', 'Sac.Branch', 'Sac.Branch.Division', 'Sac.Branch.Division.Org'),
			));
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
			$scopeArgs = array_merge($scopeArgs, array(
				'contain' => array('OwnerContact', 'OwnerContact.Sac', 'OwnerContact.Sac.Branch', 'OwnerContact.Sac.Branch.Division', 'OwnerContact.Sac.Branch.Division.Org'),
			));
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
				$results[$i]['fismaSystemIds'] = array($fismaSystem['FismaSystem']['id'] => $fismaSystem['FismaSystem']['id']);
			}
		}
		elseif($scope == 'crm')
		{
			$scopeArgs = array_merge($scopeArgs, array(
				'contain' => array('OwnerContact', 'OwnerContact.Sac', 'OwnerContact.Sac.Branch', 'OwnerContact.Sac.Branch.Division', 'OwnerContact.Sac.Branch.Division.Org'),
			));
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
				$results[$i]['fismaSystemIds'] = array($fismaSystem['FismaSystem']['id'] => $fismaSystem['FismaSystem']['id']);
			}
		}
		return $results;
	}
	
	public function scopedResults(Model $Model, $scope = 'org', $conditions = [], $scopeArgs = [], $returnConditions = false, $fismaSystemConditions = [])
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
		
		$ResultObject = $Model;
		if($Model->name == 'FovResult')
			$ResultObject = $Model->FovHost;
		
		foreach($results as $resultId => $result)
		{
			// get the fisma Inventory to find the related pen test results
			$myResultsCache = [];
			
			$results[$resultId]['inventory']['ip_addresses'] = $FismaSystem->getRelatedIpAddresses($result['fismaSystemIds']);
			$results[$resultId]['inventory']['host_names'] = $FismaSystem->getRelatedHostNames($result['fismaSystemIds']);
			$results[$resultId]['inventory']['mac_addresses'] = $FismaSystem->getRelatedMacAddresses($result['fismaSystemIds']);
			$results[$resultId]['inventory']['asset_tags'] = $FismaSystem->getRelatedAssetTags($result['fismaSystemIds']);
				
			if(!$results[$resultId]['inventory']['ip_addresses'] and !$results[$resultId]['inventory']['host_names'] and !$results[$resultId]['inventory']['mac_addresses'] and !$results[$resultId]['inventory']['asset_tags'])
			{
				unset($results[$resultId]);
				continue;
			}
			
			$resultConditions = $conditions;
			if(!isset($resultConditions['OR']))
				$resultConditions['OR'] = [];
			
			$resultConditions['OR'] = [
				$Model->alias.'.fisma_system_id' => $result['fismaSystemIds'],
				array($Model->alias.'.fisma_system_id' => 0)
			];
			
			if(!isset($returningConditions['OR'][$Model->alias.'.fisma_system_id']))
				$returningConditions['OR'][$Model->alias.'.fisma_system_id'] = [];
			$returningConditions['OR'][$Model->alias.'.fisma_system_id'] = array_merge($returningConditions['OR'][$Model->alias.'.fisma_system_id'], $result['fismaSystemIds']);
			
			
			if(!isset($returningConditions['OR'][0][$Model->alias.'.fisma_system_id']))
				$returningConditions['OR'][0][$Model->alias.'.fisma_system_id'] = 0;
			
			if($results[$resultId]['inventory']['ip_addresses'])
			{
				$resultConditions['OR'][0]['OR'][] = array(
					$ResultObject->alias.'.ip_address !=' => '',
					$ResultObject->alias.'.ip_address' => $results[$resultId]['inventory']['ip_addresses'],
				);
				if($returnConditions)
				{
					if(!isset($returningConditions['OR'][0]['OR'][$ResultObject->alias.'.ip_address']))
						$returningConditions['OR'][0]['OR'][$ResultObject->alias.'.ip_address'] = [];
					$returningConditions['OR'][0]['OR'][$ResultObject->alias.'.ip_address'] = array_merge($returningConditions['OR'][0]['OR'][$ResultObject->alias.'.ip_address'], $results[$resultId]['inventory']['ip_addresses']);
				}
			}
			if($results[$resultId]['inventory']['host_names'])
			{
				$resultConditions['OR'][0]['OR'][] = array(
					$ResultObject->alias.'.host_name !=' => '',
					$ResultObject->alias.'.host_name' => $results[$resultId]['inventory']['host_names'],
				); 
				if($returnConditions)
				{
					if(!isset($returningConditions['OR'][0]['OR'][$ResultObject->alias.'.host_name']))
						$returningConditions['OR'][0]['OR'][$ResultObject->alias.'.host_name'] = [];
					$returningConditions['OR'][0]['OR'][$ResultObject->alias.'.host_name'] = array_merge($returningConditions['OR'][0]['OR'][$ResultObject->alias.'.host_name'], $results[$resultId]['inventory']['host_names']);
				}
			}
			if($results[$resultId]['inventory']['mac_addresses'])
			{
				$resultConditions['OR'][0]['OR'][] = array(
					$ResultObject->alias.'.mac_address !=' => '',
					$ResultObject->alias.'.mac_address' => $results[$resultId]['inventory']['mac_addresses'],
				);
				if($returnConditions)
				{
					if(!isset($returningConditions['OR'][0]['OR'][$ResultObject->alias.'.mac_address']))
						$returningConditions['OR'][0]['OR'][$ResultObject->alias.'.mac_address'] = [];
					$returningConditions['OR'][0]['OR'][$ResultObject->alias.'.mac_address'] = array_merge($returningConditions['OR'][0]['OR'][$ResultObject->alias.'.mac_address'], $results[$resultId]['inventory']['mac_addresses']);
				}
			}
			if($results[$resultId]['inventory']['asset_tags'])
			{
				$resultConditions['OR'][0]['OR'][] = array(
					$ResultObject->alias.'.asset_tag !=' => '',
					$ResultObject->alias.'.asset_tag' => $results[$resultId]['inventory']['asset_tags'],
				);
				if($returnConditions)
				{
					if(!isset($returningConditions['OR'][0]['OR'][$ResultObject->alias.'.asset_tag']))
						$returningConditions['OR'][0]['OR'][$ResultObject->alias.'.asset_tag'] = [];
					$returningConditions['OR'][0]['OR'][$ResultObject->alias.'.asset_tag'] = array_merge($returningConditions['OR'][0]['OR'][$ResultObject->alias.'.asset_tag'], $results[$resultId]['inventory']['asset_tags']);
				}
			}
			
			if($returnConditions)
			{
				continue;
			}
			
			if($Model->name == 'FovResult')
			{
				$xrefResults = $Model->FovHostFovResult->find('list', [
					'recursive' => 0,
					'conditions' => $resultConditions,
					'fields' => ['FovResult.id', 'FovHostFovResult.fov_result_id']
				]);
				$Model->includeHosts = true;
				
				$myConditions = $conditions;
				$myConditions[$Model->alias.'.fisma_system_id'] = $result['fismaSystemIds'];
				
				if($xrefResults)
					$myConditions[$Model->alias.'.'.$Model->primaryKey] = $xrefResults;
				
				$myResults = $Model->find('all', [
					'conditions' => [
						'OR' => $myConditions,
					],
				]);
			}
			else
			{
				$myResults = $Model->find('all', array(
					'conditions' => $resultConditions,
				));
			}
			
			if(!$myResults)
			{
				unset($results[$resultId]);
				continue;
			}
			
			$correlated = array(
				'ip_addresses' => [],
				'host_names' => [],
				'mac_addresses' => [],
				'asset_tags' => [],
			);
			$_myResults = [];
			foreach($myResults as $myI => $myResult)
			{
				$myResult_id = $myResult[$Model->alias]['id'];
				
				$_myResults[$myResult_id] = $myResult;
				
				if(isset($myResult[$Model->alias]['fisma_system_id']) and $myResult[$Model->alias]['fisma_system_id'])
				{
					// make sure it's only in here
					if(!in_array($myResult[$Model->alias]['fisma_system_id'], $result['fismaSystemIds']))
					{
						unset($myResults[$myI]);
						continue;
					}
				}
				
				if($Model->name != 'FovResult')
				{
					// try to find where it is associated
					if($myResult[$ResultObject->alias]['ip_address'])
					{
						if(isset($results[$resultId]['inventory']['ip_addresses'][$myResult[$ResultObject->alias]['ip_address']]))
							$correlated['ip_addresses'][$myResult[$ResultObject->alias]['ip_address']] = $myResult[$ResultObject->alias]['ip_address'];
					}
					if($myResult[$ResultObject->alias]['host_name'])
					{
						if(isset($results[$resultId]['inventory']['host_names'][$myResult[$ResultObject->alias]['host_name']]))
							$correlated['host_names'][$myResult[$ResultObject->alias]['host_name']] = $myResult[$ResultObject->alias]['host_name'];
					}
					if($myResult[$ResultObject->alias]['mac_address'])
					{
						if(isset($results[$resultId]['inventory']['mac_addresses'][$myResult[$ResultObject->alias]['mac_address']]))
							$correlated['mac_addresses'][$myResult[$ResultObject->alias]['mac_address']] = $myResult[$ResultObject->alias]['mac_address'];
					}
					if($myResult[$ResultObject->alias]['asset_tag'])
					{
						if(isset($results[$resultId]['inventory']['asset_tags'][$myResult[$ResultObject->alias]['asset_tag']]))
							$correlated['asset_tags'][$myResult[$ResultObject->alias]['asset_tag']] = $myResult[$ResultObject->alias]['asset_tag'];
					}
				}
			}
			$myResults = $_myResults;
			$results[$resultId][$modelClassPlural] = $myResults;
			$results[$resultId]['inventory'] = $correlated;
		}
		
		if($returnConditions)
		{
			return $returningConditions;
		}
		
		return $results;
	}
	
	public function dbOverviewUpdate(Model $Model, $results = [])
	{
	// see UsResultsController::db_block_overview();
		
		if(!isset($Model->SubnetMember))
		{
			$Model->SubnetMember = ClassRegistry::init('SubnetMember');
		}
		
		foreach($results as $i => $result)
		{
			$conditions = array('OR' => []);
			
			if($result[$Model->alias]['ip_address'])
				$conditions['OR'][] = array(
					'FismaInventory.ip_address !=' => '',
					'FismaInventory.ip_address' => $result[$Model->alias]['ip_address'],
				);
			if($result[$Model->alias]['host_name'])
				$conditions['OR'][] = array(
					'FismaInventory.dns_name !=' => '',
					'FismaInventory.dns_name' => $result[$Model->alias]['host_name'],
				);
			if($result[$Model->alias]['mac_address'])
				$conditions['OR'][] = array(
					'FismaInventory.mac_address !=' => '',
					'FismaInventory.mac_address' => $result[$Model->alias]['mac_address'],
				);
			if($result[$Model->alias]['asset_tag'])
				$conditions['OR'][] = array(
					'FismaInventory.asset_tag !=' => '',
					'FismaInventory.asset_tag' => $result[$Model->alias]['asset_tag'],
				);
			
			$results[$i]['FismaSystems'] = $Model->SubnetMember->FismaInventory->find('list', array(
				'recursive' => 0,
				'conditions' => $conditions + array('FismaSystem.is_rogue <' => 2),
				'fields' => array('FismaSystem.id', 'FismaSystem.name'),
			));
			$results[$i]['FismaSystemsRogue'] = $Model->SubnetMember->FismaInventory->find('list', array(
				'recursive' => 0,
				'conditions' => $conditions + array('FismaSystem.is_rogue' => 2),
				'fields' => array('FismaSystem.id', 'FismaSystem.name'),
			));
		}
		return $results;
	}
	
	public function listforDirector(Model $Model, $ad_account_id = false, $findType = 'all', $criteria = [])
	{
		if(!isset($Model->SubnetMember))
		{
			$Model->SubnetMember = ClassRegistry::init('SubnetMember');
		}
		
		// get all of the inventory for these fisma systems
		if(!$fisma_inventories = $Model->SubnetMember->FismaInventory->listforDirector($ad_account_id))
		{
			return [];
		}
		$ip_addresses = [];
		$dns_names = [];
		$mac_addresses = [];
		$asset_tags = [];
		
		foreach($fisma_inventories as $fisma_inventory)
		{
			$ip_address = trim($fisma_inventory['FismaInventory']['ip_address']);
			if($ip_address and !in_array(strtoupper($ip_address), array('TBD', 'NA')))
				$ip_addresses[$ip_address] = $ip_address;
			
			$dns_name = trim($fisma_inventory['FismaInventory']['dns_name']);
			if($dns_name and !in_array(strtoupper($dns_name), array('TBD', 'NA')))
				$dns_names[$dns_name] = $dns_name;
			
			$mac_address = trim($fisma_inventory['FismaInventory']['mac_address']);
			if($mac_address and !in_array(strtoupper($mac_address), array('TBD', 'NA')))
				$mac_addresses[$mac_address] = $mac_address;
			
			$asset_tag = trim($fisma_inventory['FismaInventory']['asset_tag']);
			if($asset_tag and !in_array(strtoupper($asset_tag), array('TBD', 'NA')))
				$asset_tags[$asset_tag] = $asset_tag;
		}
		
		$conditions = array('   OR' => []);
		
		if($ip_addresses)
			$conditions['   OR'][$Model->alias.'.ip_address'] = $ip_addresses;
		if($dns_names)
			$conditions['   OR'][$Model->alias.'.host_name'] = $dns_names;
		if($mac_addresses)
			$conditions['   OR'][$Model->alias.'.mac_address'] = $mac_addresses;
		if($asset_tags)
			$conditions['   OR'][$Model->alias.'.asset_tag'] = $asset_tags;
		
		if(!$conditions['   OR'])
			return [];
		
		if(isset($criteria['conditions']))
			$conditions = array_merge($criteria['conditions'], $conditions);
		
		if($findType == 'conditions')
			return $conditions;
		
		$criteria['conditions'] = $conditions;
		
		return $Model->find($findType, $criteria);
	}
}