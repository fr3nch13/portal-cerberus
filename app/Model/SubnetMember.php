<?php
App::uses('AppModel', 'Model');
/**
 * Subnet Model
 *
 */
class SubnetMember extends AppModel 
{
	
	public $belongsTo = array(
		'Subnet' => array(
			'className' => 'Subnet',
			'foreignKey' => 'subnet_id',
		),
		'FismaInventory' => array(
			'className' => 'FismaInventory',
			'foreignKey' => 'fisma_inventory_id',
		),
		'UsResult' => array(
			'className' => 'UsResult',
			'foreignKey' => 'us_result_id',
		),
		'EolResult' => array(
			'className' => 'EolResult',
			'foreignKey' => 'eol_result_id',
		),
		'PenTestResult' => array(
			'className' => 'PenTestResult',
			'foreignKey' => 'pen_test_result_id',
		),
		'HighRiskResult' => array(
			'className' => 'HighRiskResult',
			'foreignKey' => 'high_risk_result_id',
		),
		'FovHost' => array(
			'className' => 'FovHost',
			'foreignKey' => 'fov_host_id',
		),
	);
	
	public $CommonNetwork = false;
	
	public $subnetsCache = array();
	
	public function fismaInventoriesToSubnet($subnet_id = false)
	{
	/// scans all fisma inventories and associate new ones to this subnet
		$this->loadCommonNetwork();
		$this->shell_nolog = true;
		if(!isset($this->shell_input))
			$this->shell_input = 2;
		
		// get the subnet
		$subnet = $this->Subnet->read(null, $subnet_id);
		$this->shellOut(__('%s: %s - FISMA Inventory Scan', $subnet_id, $subnet['Subnet']['cidr']));
		
		// get the array of ip addresses in this subnet
		$subnet_ip_array = $this->CommonNetwork->cidrToIpArray($subnet['Subnet']['cidr']);
		
		// get all existing Fisma Inventory Members
		$existing_xref = $this->find('all', array(
			'recursive' => 0,
			'contain' => array('FismaInventory'),
			'conditions' => array('SubnetMember.subnet_id' => $subnet_id, 'SubnetMember.fisma_inventory_id >' => 0),
		));
		$this->shellOut(__('%s: %s - Existing count: %s', $subnet_id, $subnet['Subnet']['cidr'], count($existing_xref)));

		// find all inventory with an ip address that fits in this subnet
		$fisma_inventories_match = $this->FismaInventory->find('list', array(
			'conditions' => array('FismaInventory.ip_address' => $subnet_ip_array),
			'fields' => array('FismaInventory.id', 'FismaInventory.ip_address'),
		));
		$this->shellOut(__('%s: %s - Inventory matches: %s', $subnet_id, $subnet['Subnet']['cidr'], count($fisma_inventories_match)));
		
		// filter records for new ones, and ones that no longer belong
		$fisma_inventory_ids = array_keys($fisma_inventories_match);
		$remove_ids = array();
		foreach($existing_xref as $existing_record)
		{
			// filter out the existing records from the new ones being added
			if(in_array($existing_record['FismaInventory']['id'], $fisma_inventory_ids))
			{
				unset($fisma_inventories_match[$existing_record['FismaInventory']['id']]);
			}
			
			// find all of the existing records that no longer match this subnet, so we can remove them
			if(!in_array($existing_record['FismaInventory']['ip_address'], $subnet_ip_array))
			{
				$remove_ids[$existing_record['SubnetMember']['id']] = $existing_record['SubnetMember']['id'];
			}
		}
		
		$this->shellOut(__('%s: %s - To be removed: %s', $subnet_id, $subnet['Subnet']['cidr'], count($remove_ids)));
		if($remove_ids)
		{
			$this->deleteAll(array('SubnetMember.id' => $remove_ids));
		}
		
		//create a membership record of these fisma inventories that match and are new
		$data_saveMany = array();
		foreach($fisma_inventories_match as $fisma_inventory_id => $fisma_inventory_ip_address)
		{
			$data_saveMany[] = array('subnet_id' => $subnet_id, 'fisma_inventory_id' => $fisma_inventory_id);
		}
		
		$this->shellOut(__('%s: %s - To be added: %s', $subnet_id, $subnet['Subnet']['cidr'], count($data_saveMany)));
		
		$return = false;
		if($data_saveMany)
		{
			$return = $this->saveMany($data_saveMany);
		}
		// update the counter caches for this subnet
		$this->updateSubnetCounterCaches($subnet_id);
		return $return;
	}
	
	public function subnetsToFismaInventory($fisma_inventory_id = false)
	{
	/// scans all fisma inventories and associate new ones to this subnet
		$this->loadCommonNetwork();
		
		// get the fisma inventory ip_address
		$fisma_inventory = $this->FismaInventory->read(null, $fisma_inventory_id);
		
		// get all existing Subnets that this is a member of
		$existing_xref = $this->find('all', array(
			'recursive' => 0,
			'contain' => array('Subnet'),
			'conditions' => array('SubnetMember.fisma_inventory_id' => $fisma_inventory_id),
		));
		
		// get all of the subnets
		$subnets = $this->Subnet->find('all');
		
		/// find all of the subnets that this fisma inventory can be a part of
		$subnet_ids = array();
		foreach($subnets as $subnet)
		{
			$subnet_ip_array = $this->CommonNetwork->cidrToIpArray($subnet['Subnet']['cidr']);
			if(in_array($fisma_inventory['FismaInventory']['ip_address'], $subnet_ip_array))
			{
				$subnet_ids[$subnet['Subnet']['id']] = $subnet['Subnet']['id'];
			}
		}
		
		// filter out the existing subnets that no longer match
		$remove_ids = array();
		foreach($existing_xref as $existing_record)
		{
			// find all of the existing records that no longer match this subnet, so we can remove them
			if(!in_array($existing_record['Subnet']['id'], $subnet_ids))
			{
				$remove_ids[$existing_record['SubnetMember']['id']] = $existing_record['SubnetMember']['id'];
			}	
		}
		
		if($remove_ids)
		{
			$this->deleteAll(array('SubnetMember.id' => $remove_ids));
		}
		
		// filter out existing records so we don't have duplicate records
		foreach($existing_xref as $existing_record)
		{
			
			// filter out the existing records from the new ones being added
			if(in_array($existing_record['Subnet']['id'], $subnet_ids))
			{
				unset($subnet_ids[$existing_record['Subnet']['id']]);
			}
		}
		
		//create a membership record of these fisma inventories that match and are new
		$data_saveMany = array();
		foreach($subnet_ids as $subnet_id)
		{
			$data_saveMany[] = array('subnet_id' => $subnet_id, 'fisma_inventory_id' => $fisma_inventory_id);
		}
		
		$return = false;
		if($data_saveMany)
		{
			$return = $this->saveMany($data_saveMany);
		}
		
		// update the counter caches for this subnet
		foreach($subnet_ids as $subnet_id)
		{
			$this->updateSubnetCounterCaches($subnet_id);
		}
		return $return;
	}
	
	public function getSubnetFismaInventoriesStats($subnet_id = false)
	{
		if(!$subnet_id) return array();
		
		$this->recursive = 0;
		$this->contain();
		$subnet_members = $this->find('all', array(
			'recursive' => 0,
			'contain' => array('FismaInventory', 'FismaInventory.FismaSystem', 'FismaInventory.FismaType', 'FismaInventory.FismaStatus', 'FismaInventory.FismaSource'),
			'conditions' => array(
				'SubnetMember.subnet_id' => $subnet_id,
				'SubnetMember.fisma_inventory_id !=' => 0,
			),
		));
		$total = count($subnet_members);
		
		$out = array(
			'FismaSystem' => array(),
			'FismaType' => array(),
		);
		
		foreach($subnet_members as $subnet_member)
		{
			$fisma_system_id = ($subnet_member['FismaInventory']['FismaSystem']['id']?$subnet_member['FismaInventory']['FismaSystem']['id']:0);
			if(!isset($out['FismaSystem'][$fisma_system_id]))
			{
				$out['FismaSystem'][$fisma_system_id] = array(
					'name' => ($subnet_member['FismaInventory']['FismaSystem']['name']?$subnet_member['FismaInventory']['FismaSystem']['name']:__('Unassigned')),
					'value' => 0,
					'percent' => 0,
				);
			}
			$out['FismaSystem'][$fisma_system_id]['value']++;
			
			$fisma_type_id = ($subnet_member['FismaInventory']['FismaType']['id']?$subnet_member['FismaInventory']['FismaType']['id']:0);
			if(!isset($out['FismaType'][$fisma_type_id]))
			{
				$out['FismaType'][$fisma_type_id] = array(
					'name' => ($subnet_member['FismaInventory']['FismaType']['name']?$subnet_member['FismaInventory']['FismaType']['name']:__('Unassigned')),
					'value' => 0,
					'percent' => 0,
				);
			}
			$out['FismaType'][$fisma_type_id]['value']++;
		}
		
		foreach($out['FismaSystem'] as $fisma_system_id => $data)
		{
			$out['FismaSystem'][$fisma_system_id]['percent'] = round((($data['value'] / $total) * 100), 1);
		}
		
		foreach($out['FismaType'] as $fisma_type_id => $data)
		{
			$out['FismaType'][$fisma_type_id]['percent'] = round((($data['value'] / $total) * 100), 1);
		}
		return $out;
	}
	
	public function usResultsToSubnet($subnet_id = false)
	{
	/// scans all fisma inventories and associate new ones to this subnet
		$this->loadCommonNetwork();
		$this->shell_nolog = true;
		if(!isset($this->shell_input))
			$this->shell_input = 2;
		
		// get the subnet
		$subnet = $this->Subnet->read(null, $subnet_id);
		$this->shellOut(__('%s: %s - US Results Scan', $subnet_id, $subnet['Subnet']['cidr']));
		
		// get the array of ip addresses in this subnet
		$subnet_ip_array = $this->CommonNetwork->cidrToIpArray($subnet['Subnet']['cidr']);
		
		// get all existing US Results Members
		$existing_xref = $this->find('all', array(
			'recursive' => 0,
			'contain' => array('UsResult'),
			'conditions' => array('SubnetMember.subnet_id' => $subnet_id, 'SubnetMember.us_result_id >' => 0 ),
		));
		$this->shellOut(__('%s: %s - Existing count: %s', $subnet_id, $subnet['Subnet']['cidr'], count($existing_xref)));

		// find all inventory with an ip address that fits in this subnet
		$us_results_match = $this->UsResult->find('list', array(
			'conditions' => array('UsResult.ip_address' => $subnet_ip_array),
			'fields' => array('UsResult.id', 'UsResult.ip_address'),
		));
		$this->shellOut(__('%s: %s - US matches: %s', $subnet_id, $subnet['Subnet']['cidr'], count($us_results_match)));
		
		// filter records for new ones, and ones that no longer belong
		$us_result_ids = array_keys($us_results_match);
		$remove_ids = array();
		foreach($existing_xref as $existing_record)
		{
			// filter out the existing records from the new ones being added
			if(in_array($existing_record['UsResult']['id'], $us_result_ids))
			{
				unset($us_results_match[$existing_record['UsResult']['id']]);
			}
			
			// find all of the existing records that no longer match this subnet, so we can remove them
			if(!in_array($existing_record['UsResult']['ip_address'], $subnet_ip_array))
			{
				$remove_ids[$existing_record['SubnetMember']['id']] = $existing_record['SubnetMember']['id'];
			}
		}
		
		$this->shellOut(__('%s: %s - To be removed: %s', $subnet_id, $subnet['Subnet']['cidr'], count($remove_ids)));
		if($remove_ids)
		{
			$this->deleteAll(array('SubnetMember.id' => $remove_ids));
		}
		
		//create a membership record of these fisma inventories that match and are new
		$data_saveMany = array();
		foreach($us_results_match as $us_result_id => $us_result_ip_address)
		{
			$data_saveMany[] = array('subnet_id' => $subnet_id, 'us_result_id' => $us_result_id);
		}
		
		$this->shellOut(__('%s: %s - To be added: %s', $subnet_id, $subnet['Subnet']['cidr'], count($data_saveMany)));
		
		$return = false;
		if($data_saveMany)
		{
			$return = $this->saveMany($data_saveMany);
		}
		
		// update the counter caches for this subnet
		$this->updateSubnetCounterCaches($subnet_id);
		
		return $return;
	}
	
	public function subnetsToUsResult($us_result_id = false)
	{
	/// scans all fisma inventories and associate new ones to this subnet
		$this->loadCommonNetwork();
		
		// get the fisma inventory ip_address
		$us_result_ip_address = $this->UsResult->field('ip_address', array('id' => $us_result_id));
		
		// get all existing Subnets that this is a member of
		$existing_xref = $this->find('all', array(
			'recursive' => 0,
			'contain' => array('Subnet'),
			'conditions' => array('SubnetMember.us_result_id' => $us_result_id),
		));
		
		// get all of the subnets
		if($this->subnetsCache)
			$subnets = $this->subnetsCache;
		else
			$this->subnetsCache = $subnets = $this->Subnet->find('all');
		
		/// find all of the subnets that this fisma inventory can be a part of
		$subnet_ids = array();
		foreach($subnets as $subnet)
		{
			$subnet_ip_array = $this->CommonNetwork->cidrToIpArray($subnet['Subnet']['cidr']);
			if(in_array($us_result_ip_address, $subnet_ip_array))
			{
				$subnet_ids[$subnet['Subnet']['id']] = $subnet['Subnet']['id'];
			}
		}
		
		// filter out the existing subnets that no longer match
		$remove_ids = array();
		foreach($existing_xref as $existing_record)
		{
			// find all of the existing records that no longer match this subnet, so we can remove them
			if(!in_array($existing_record['Subnet']['id'], $subnet_ids))
			{
				$remove_ids[$existing_record['SubnetMember']['id']] = $existing_record['SubnetMember']['id'];
			}	
		}
		
		if($remove_ids)
		{
			$this->deleteAll(array('SubnetMember.id' => $remove_ids));
		}
		
		// filter out existing records so we don't have duplicate records
		foreach($existing_xref as $existing_record)
		{
			// filter out the existing records from the new ones being added
			if(in_array($existing_record['Subnet']['id'], $subnet_ids))
			{
				unset($subnet_ids[$existing_record['Subnet']['id']]);
			}
		}
		
		//create a membership record of these members that match and are new
		$data_saveMany = array();
		foreach($subnet_ids as $subnet_id)
		{
			$data_saveMany[] = array('subnet_id' => $subnet_id, 'us_result_id' => $us_result_id);
		}
		
		$return = false;
		if($data_saveMany)
		{
			$return = $this->saveMany($data_saveMany);
		}
		
		// update the counter caches for this subnet
		foreach($subnet_ids as $subnet_id)
		{
			$this->updateSubnetCounterCaches($subnet_id);
		}
		
		return $return;
	}
	
	/// later when needed
	public function getSubnetUsResultsStats($subnet_id = false)
	{
		if(!$subnet_id) return array();
		
		return array();
	}
	
	public function eolResultsToSubnet($subnet_id = false)
	{
	/// scans all fisma inventories and associate new ones to this subnet
		$this->loadCommonNetwork();
		$this->shell_nolog = true;
		if(!isset($this->shell_input))
			$this->shell_input = 2;
		
		// get the subnet
		$subnet = $this->Subnet->read(null, $subnet_id);
		$this->shellOut(__('%s: %s - EOL Results Scan', $subnet_id, $subnet['Subnet']['cidr']));
		
		// get the array of ip addresses in this subnet
		$subnet_ip_array = $this->CommonNetwork->cidrToIpArray($subnet['Subnet']['cidr']);
		
		// get all existing EOL Results Members
		$existing_xref = $this->find('all', array(
			'recursive' => 0,
			'contain' => array('EolResult'),
			'conditions' => array('SubnetMember.subnet_id' => $subnet_id, 'SubnetMember.eol_result_id >' => 0 ),
		));
		$this->shellOut(__('%s: %s - Existing count: %s', $subnet_id, $subnet['Subnet']['cidr'], count($existing_xref)));

		// find all inventory with an ip address that fits in this subnet
		$eol_results_match = $this->EolResult->find('list', array(
			'conditions' => array('EolResult.ip_address' => $subnet_ip_array),
			'fields' => array('EolResult.id', 'EolResult.ip_address'),
		));
		$this->shellOut(__('%s: %s - EOL matches: %s', $subnet_id, $subnet['Subnet']['cidr'], count($eol_results_match)));
		
		// filter records for new ones, and ones that no longer belong
		$eol_result_ids = array_keys($eol_results_match);
		$remove_ids = array();
		foreach($existing_xref as $existing_record)
		{
			// filter out the existing records from the new ones being added
			if(in_array($existing_record['EolResult']['id'], $eol_result_ids))
			{
				unset($eol_results_match[$existing_record['EolResult']['id']]);
			}
			
			// find all of the existing records that no longer match this subnet, so we can remove them
			if(!in_array($existing_record['EolResult']['ip_address'], $subnet_ip_array))
			{
				$remove_ids[$existing_record['SubnetMember']['id']] = $existing_record['SubnetMember']['id'];
			}
		}
		
		$this->shellOut(__('%s: %s - To be removed: %s', $subnet_id, $subnet['Subnet']['cidr'], count($remove_ids)));
		if($remove_ids)
		{
			$this->deleteAll(array('SubnetMember.id' => $remove_ids));
		}
		
		//create a membership record of these fisma inventories that match and are new
		$data_saveMany = array();
		foreach($eol_results_match as $eol_result_id => $eol_result_ip_address)
		{
			$data_saveMany[] = array('subnet_id' => $subnet_id, 'eol_result_id' => $eol_result_id);
		}
		
		$this->shellOut(__('%s: %s - To be added: %s', $subnet_id, $subnet['Subnet']['cidr'], count($data_saveMany)));
		
		$return = false;
		if($data_saveMany)
		{
			$return = $this->saveMany($data_saveMany);
		}
		
		// update the counter caches for this subnet
		$this->updateSubnetCounterCaches($subnet_id);
		
		return $return;
	}
	
	public function subnetsToEolResult($eol_result_id = false)
	{
	/// scans all fisma inventories and associate new ones to this subnet
		$this->loadCommonNetwork();
		
		// get the fisma inventory ip_address
		$eol_result = $this->EolResult->read(null, $eol_result_id);
		
		// get all existing Subnets that this is a member of
		$existing_xref = $this->find('all', array(
			'recursive' => 0,
			'contain' => array('Subnet'),
			'conditions' => array('SubnetMember.eol_result_id' => $eol_result_id),
		));
		
		// get all of the subnets
		$subnets = $this->Subnet->find('all');
		
		/// find all of the subnets that this fisma inventory can be a part of
		$subnet_ids = array();
		foreach($subnets as $subnet)
		{
			$subnet_ip_array = $this->CommonNetwork->cidrToIpArray($subnet['Subnet']['cidr']);
			if(in_array($eol_result['EolResult']['ip_address'], $subnet_ip_array))
			{
				$subnet_ids[$subnet['Subnet']['id']] = $subnet['Subnet']['id'];
			}
		}
		
		// filter out the existing subnets that no longer match
		$remove_ids = array();
		foreach($existing_xref as $existing_record)
		{
			// find all of the existing records that no longer match this subnet, so we can remove them
			if(!in_array($existing_record['Subnet']['id'], $subnet_ids))
			{
				$remove_ids[$existing_record['SubnetMember']['id']] = $existing_record['SubnetMember']['id'];
			}	
		}
		
		if($remove_ids)
		{
			$this->deleteAll(array('SubnetMember.id' => $remove_ids));
		}
		
		// filter out existing records so we don't have duplicate records
		foreach($existing_xref as $existing_record)
		{
			
			// filter out the existing records from the new ones being added
			if(in_array($existing_record['Subnet']['id'], $subnet_ids))
			{
				unset($subnet_ids[$existing_record['Subnet']['id']]);
			}
		}
		
		//create a membership record of these fisma inventories that match and are new
		$data_saveMany = array();
		foreach($subnet_ids as $subnet_id)
		{
			$data_saveMany[] = array('subnet_id' => $subnet_id, 'eol_result_id' => $eol_result_id);
		}
		
		$return = false;
		if($data_saveMany)
		{
			$return = $this->saveMany($data_saveMany);
		}
		
		// update the counter caches for this subnet
		foreach($subnet_ids as $subnet_id)
		{
			$this->updateSubnetCounterCaches($subnet_id);
		}
		
		return $return;
	}
	
	/// later when needed
	public function getSubnetEolResultsStats($subnet_id = false)
	{
		if(!$subnet_id) return array();
		
		return array();
	}
	
	public function penTestResultsToSubnet($subnet_id = false)
	{
	/// scans all fisma inventories and associate new ones to this subnet
		$this->loadCommonNetwork();
		$this->shell_nolog = true;
		if(!isset($this->shell_input))
			$this->shell_input = 2;
		
		// get the subnet
		$subnet = $this->Subnet->read(null, $subnet_id);
		$this->shellOut(__('%s: %s - Pen Test Results Scan', $subnet_id, $subnet['Subnet']['cidr']));
		
		// get the array of ip addresses in this subnet
		$subnet_ip_array = $this->CommonNetwork->cidrToIpArray($subnet['Subnet']['cidr']);
		
		// get all existing Pen Test Results Members
		$existing_xref = $this->find('all', array(
			'recursive' => 0,
			'contain' => array('PenTestResult'),
			'conditions' => array('SubnetMember.subnet_id' => $subnet_id, 'SubnetMember.pen_test_result_id >' => 0 ),
		));
		$this->shellOut(__('%s: %s - Existing count: %s', $subnet_id, $subnet['Subnet']['cidr'], count($existing_xref)));

		// find all inventory with an ip address that fits in this subnet
		$pen_test_results_match = $this->PenTestResult->find('list', array(
			'conditions' => array('PenTestResult.ip_address' => $subnet_ip_array),
			'fields' => array('PenTestResult.id', 'PenTestResult.ip_address'),
		));
		$this->shellOut(__('%s: %s - Pen Test matches: %s', $subnet_id, $subnet['Subnet']['cidr'], count($pen_test_results_match)));
		
		// filter records for new ones, and ones that no longer belong
		$pen_test_result_ids = array_keys($pen_test_results_match);
		$remove_ids = array();
		foreach($existing_xref as $existing_record)
		{
			// filter out the existing records from the new ones being added
			if(in_array($existing_record['PenTestResult']['id'], $pen_test_result_ids))
			{
				unset($pen_test_results_match[$existing_record['PenTestResult']['id']]);
			}
			
			// find all of the existing records that no longer match this subnet, so we can remove them
			if(!in_array($existing_record['PenTestResult']['ip_address'], $subnet_ip_array))
			{
				$remove_ids[$existing_record['SubnetMember']['id']] = $existing_record['SubnetMember']['id'];
			}
		}
		
		$this->shellOut(__('%s: %s - To be removed: %s', $subnet_id, $subnet['Subnet']['cidr'], count($remove_ids)));
		if($remove_ids)
		{
			$this->deleteAll(array('SubnetMember.id' => $remove_ids));
		}
		
		//create a membership record of these fisma inventories that match and are new
		$data_saveMany = array();
		foreach($pen_test_results_match as $pen_test_result_id => $pen_test_result_ip_address)
		{
			$data_saveMany[] = array('subnet_id' => $subnet_id, 'pen_test_result_id' => $pen_test_result_id);
		}
		
		$this->shellOut(__('%s: %s - To be added: %s', $subnet_id, $subnet['Subnet']['cidr'], count($data_saveMany)));
		
		$return = false;
		if($data_saveMany)
		{
			$return = $this->saveMany($data_saveMany);
		}
		
		// update the counter caches for this subnet
		$this->updateSubnetCounterCaches($subnet_id);
		
		return $return;
	}
	
	public function subnetsToPenTestResult($pen_test_result_id = false)
	{
	/// scans all fisma inventories and associate new ones to this subnet
		$this->loadCommonNetwork();
		
		// get the fisma inventory ip_address
		$pen_test_result = $this->PenTestResult->read(null, $pen_test_result_id);
		
		// get all existing Subnets that this is a member of
		$existing_xref = $this->find('all', array(
			'recursive' => 0,
			'contain' => array('Subnet'),
			'conditions' => array('SubnetMember.pen_test_result_id' => $pen_test_result_id),
		));
		
		// get all of the subnets
		$subnets = $this->Subnet->find('all');
		
		/// find all of the subnets that this fisma inventory can be a part of
		$subnet_ids = array();
		foreach($subnets as $subnet)
		{
			$subnet_ip_array = $this->CommonNetwork->cidrToIpArray($subnet['Subnet']['cidr']);
			if(in_array($pen_test_result['PenTestResult']['ip_address'], $subnet_ip_array))
			{
				$subnet_ids[$subnet['Subnet']['id']] = $subnet['Subnet']['id'];
			}
		}
		
		// filter out the existing subnets that no longer match
		$remove_ids = array();
		foreach($existing_xref as $existing_record)
		{
			// find all of the existing records that no longer match this subnet, so we can remove them
			if(!in_array($existing_record['Subnet']['id'], $subnet_ids))
			{
				$remove_ids[$existing_record['SubnetMember']['id']] = $existing_record['SubnetMember']['id'];
			}	
		}
		
		if($remove_ids)
		{
			$this->deleteAll(array('SubnetMember.id' => $remove_ids));
		}
		
		// filter out existing records so we don't have duplicate records
		foreach($existing_xref as $existing_record)
		{
			
			// filter out the existing records from the new ones being added
			if(in_array($existing_record['Subnet']['id'], $subnet_ids))
			{
				unset($subnet_ids[$existing_record['Subnet']['id']]);
			}
		}
		
		//create a membership record of these fisma inventories that match and are new
		$data_saveMany = array();
		foreach($subnet_ids as $subnet_id)
		{
			$data_saveMany[] = array('subnet_id' => $subnet_id, 'pen_test_result_id' => $pen_test_result_id);
		}
		
		$return = false;
		if($data_saveMany)
		{
			$return = $this->saveMany($data_saveMany);
		}
		
		// update the counter caches for this subnet
		foreach($subnet_ids as $subnet_id)
		{
			$this->updateSubnetCounterCaches($subnet_id);
		}
		
		return $return;
	}
	
	/// later when needed
	public function getSubnetPenTestResultsStats($subnet_id = false)
	{
		if(!$subnet_id) return array();
		
		return array();
	}
	
	public function highRiskResultsToSubnet($subnet_id = false)
	{
	/// scans all fisma inventories and associate new ones to this subnet
		$this->loadCommonNetwork();
		$this->shell_nolog = true;
		if(!isset($this->shell_input))
			$this->shell_input = 2;
		
		// get the subnet
		$subnet = $this->Subnet->read(null, $subnet_id);
		$this->shellOut(__('%s: %s - HighRisk Results Scan', $subnet_id, $subnet['Subnet']['cidr']));
		
		// get the array of ip addresses in this subnet
		$subnet_ip_array = $this->CommonNetwork->cidrToIpArray($subnet['Subnet']['cidr']);
		
		// get all existing HighRisk Results Members
		$existing_xref = $this->find('all', array(
			'recursive' => 0,
			'contain' => array('HighRiskResult'),
			'conditions' => array('SubnetMember.subnet_id' => $subnet_id, 'SubnetMember.high_risk_result_id >' => 0 ),
		));
		$this->shellOut(__('%s: %s - Existing count: %s', $subnet_id, $subnet['Subnet']['cidr'], count($existing_xref)));

		// find all inventory with an ip address that fits in this subnet
		$high_risk_results_match = $this->HighRiskResult->find('list', array(
			'conditions' => array('HighRiskResult.ip_address' => $subnet_ip_array),
			'fields' => array('HighRiskResult.id', 'HighRiskResult.ip_address'),
		));
		$this->shellOut(__('%s: %s - HighRisk matches: %s', $subnet_id, $subnet['Subnet']['cidr'], count($high_risk_results_match)));
		
		// filter records for new ones, and ones that no longer belong
		$high_risk_result_ids = array_keys($high_risk_results_match);
		$remove_ids = array();
		foreach($existing_xref as $existing_record)
		{
			// filter out the existing records from the new ones being added
			if(in_array($existing_record['HighRiskResult']['id'], $high_risk_result_ids))
			{
				unset($high_risk_results_match[$existing_record['HighRiskResult']['id']]);
			}
			
			// find all of the existing records that no longer match this subnet, so we can remove them
			if(!in_array($existing_record['HighRiskResult']['ip_address'], $subnet_ip_array))
			{
				$remove_ids[$existing_record['SubnetMember']['id']] = $existing_record['SubnetMember']['id'];
			}
		}
		
		$this->shellOut(__('%s: %s - To be removed: %s', $subnet_id, $subnet['Subnet']['cidr'], count($remove_ids)));
		if($remove_ids)
		{
			$this->deleteAll(array('SubnetMember.id' => $remove_ids));
		}
		
		//create a membership record of these fisma inventories that match and are new
		$data_saveMany = array();
		foreach($high_risk_results_match as $high_risk_result_id => $high_risk_result_ip_address)
		{
			$data_saveMany[] = array('subnet_id' => $subnet_id, 'high_risk_result_id' => $high_risk_result_id);
		}
		
		$this->shellOut(__('%s: %s - To be added: %s', $subnet_id, $subnet['Subnet']['cidr'], count($data_saveMany)));
		
		$return = false;
		if($data_saveMany)
		{
			$return = $this->saveMany($data_saveMany);
		}
		
		// update the counter caches for this subnet
		$this->updateSubnetCounterCaches($subnet_id);
		
		return $return;
	}
	
	public function subnetsToHighRiskResult($high_risk_result_id = false)
	{
	/// scans all fisma inventories and associate new ones to this subnet
		$this->loadCommonNetwork();
		
		// get the fisma inventory ip_address
		$high_risk_result = $this->HighRiskResult->read(null, $high_risk_result_id);
		
		// get all existing Subnets that this is a member of
		$existing_xref = $this->find('all', array(
			'recursive' => 0,
			'contain' => array('Subnet'),
			'conditions' => array('SubnetMember.high_risk_result_id' => $high_risk_result_id),
		));
		
		// get all of the subnets
		$subnets = $this->Subnet->find('all');
		
		/// find all of the subnets that this fisma inventory can be a part of
		$subnet_ids = array();
		foreach($subnets as $subnet)
		{
			$subnet_ip_array = $this->CommonNetwork->cidrToIpArray($subnet['Subnet']['cidr']);
			if(in_array($high_risk_result['HighRiskResult']['ip_address'], $subnet_ip_array))
			{
				$subnet_ids[$subnet['Subnet']['id']] = $subnet['Subnet']['id'];
			}
		}
		
		// filter out the existing subnets that no longer match
		$remove_ids = array();
		foreach($existing_xref as $existing_record)
		{
			// find all of the existing records that no longer match this subnet, so we can remove them
			if(!in_array($existing_record['Subnet']['id'], $subnet_ids))
			{
				$remove_ids[$existing_record['SubnetMember']['id']] = $existing_record['SubnetMember']['id'];
			}	
		}
		
		if($remove_ids)
		{
			$this->deleteAll(array('SubnetMember.id' => $remove_ids));
		}
		
		// filter out existing records so we don't have duplicate records
		foreach($existing_xref as $existing_record)
		{
			
			// filter out the existing records from the new ones being added
			if(in_array($existing_record['Subnet']['id'], $subnet_ids))
			{
				unset($subnet_ids[$existing_record['Subnet']['id']]);
			}
		}
		
		//create a membership record of these fisma inventories that match and are new
		$data_saveMany = array();
		foreach($subnet_ids as $subnet_id)
		{
			$data_saveMany[] = array('subnet_id' => $subnet_id, 'high_risk_result_id' => $high_risk_result_id);
		}
		
		$return = false;
		if($data_saveMany)
		{
			$return = $this->saveMany($data_saveMany);
		}
		
		// update the counter caches for this subnet
		foreach($subnet_ids as $subnet_id)
		{
			$this->updateSubnetCounterCaches($subnet_id);
		}
		
		return $return;
	}
	
	/// later when needed
	public function getSubnetHighRiskResultsStats($subnet_id = false)
	{
		if(!$subnet_id) return array();
		
		return array();
	}
	
	public function fovResultsToSubnet($subnet_id = false)
	{
	/// scans all fisma inventories and associate new ones to this subnet
		$this->loadCommonNetwork();
		$this->shell_nolog = true;
		if(!isset($this->shell_input))
			$this->shell_input = 2;
		
		// get the subnet
		$subnet = $this->Subnet->read(null, $subnet_id);
		$this->shellOut(__('%s: %s - FOV Results Scan', $subnet_id, $subnet['Subnet']['cidr']));
		
		// get the array of ip addresses in this subnet
		$subnet_ip_array = $this->CommonNetwork->cidrToIpArray($subnet['Subnet']['cidr']);
		
		// get all existing FOV Results Members
		$existing_xref = $this->find('all', array(
			'recursive' => 0,
			'contain' => array('FovHost'),
			'conditions' => array('SubnetMember.subnet_id' => $subnet_id, 'SubnetMember.fov_host_id >' => 0 ),
		));
		$this->shellOut(__('%s: %s - Existing count: %s', $subnet_id, $subnet['Subnet']['cidr'], count($existing_xref)));

		// find all inventory with an ip address that fits in this subnet
		$fov_hosts_match = $this->FovHost->find('list', array(
			'conditions' => array('FovHost.ip_address' => $subnet_ip_array),
			'fields' => array('FovHost.id', 'FovHost.ip_address'),
		));
		$this->shellOut(__('%s: %s - FOV matches: %s', $subnet_id, $subnet['Subnet']['cidr'], count($fov_hosts_match)));
		
		// filter records for new ones, and ones that no longer belong
		$fov_host_ids = array_keys($fov_hosts_match);
		$remove_ids = array();
		foreach($existing_xref as $existing_record)
		{
			// filter out the existing records from the new ones being added
			if(in_array($existing_record['FovHost']['id'], $fov_host_ids))
			{
				unset($fov_hosts_match[$existing_record['FovHost']['id']]);
			}
			
			// find all of the existing records that no longer match this subnet, so we can remove them
			if(!in_array($existing_record['FovHost']['ip_address'], $subnet_ip_array))
			{
				$remove_ids[$existing_record['SubnetMember']['id']] = $existing_record['SubnetMember']['id'];
			}
		}
		
		$this->shellOut(__('%s: %s - To be removed: %s', $subnet_id, $subnet['Subnet']['cidr'], count($remove_ids)));
		if($remove_ids)
		{
			$this->deleteAll(array('SubnetMember.id' => $remove_ids));
		}
		
		//create a membership record of these fisma inventories that match and are new
		$data_saveMany = array();
		foreach($fov_hosts_match as $fov_host_id => $fov_host_ip_address)
		{
			$data_saveMany[] = array('subnet_id' => $subnet_id, 'fov_host_id' => $fov_host_id);
		}
		
		$this->shellOut(__('%s: %s - To be added: %s', $subnet_id, $subnet['Subnet']['cidr'], count($data_saveMany)));
		
		$return = false;
		if($data_saveMany)
		{
			$return = $this->saveMany($data_saveMany);
		}
		
		// update the counter caches for this subnet
		$this->updateSubnetCounterCaches($subnet_id);
		
		return $return;
	}
	
	public function subnetsToFovHost($fov_host_id = false)
	{
		$this->loadCommonNetwork();
		
		$fov_host = $this->FovHost->read(null, $fov_host_id);
		
		$existing_xref = $this->find('all', array(
			'recursive' => 0,
			'contain' => array('Subnet'),
			'conditions' => array('SubnetMember.fov_host_id' => $fov_host_id),
		));
		
		$subnets = $this->Subnet->find('all');
		
		$subnet_ids = array();
		foreach($subnets as $subnet)
		{
			$subnet_ip_array = $this->CommonNetwork->cidrToIpArray($subnet['Subnet']['cidr']);
			if(in_array($fov_host['FovHost']['ip_address'], $subnet_ip_array))
			{
				$subnet_ids[$subnet['Subnet']['id']] = $subnet['Subnet']['id'];
			}
		}
		
		$remove_ids = array();
		foreach($existing_xref as $existing_record)
		{
			if(!in_array($existing_record['Subnet']['id'], $subnet_ids))
			{
				$remove_ids[$existing_record['SubnetMember']['id']] = $existing_record['SubnetMember']['id'];
			}	
		}
		
		if($remove_ids)
		{
			$this->deleteAll(array('SubnetMember.id' => $remove_ids));
		}
		
		foreach($existing_xref as $existing_record)
		{
			if(in_array($existing_record['Subnet']['id'], $subnet_ids))
			{
				unset($subnet_ids[$existing_record['Subnet']['id']]);
			}
		}
		
		$data_saveMany = array();
		foreach($subnet_ids as $subnet_id)
		{
			$data_saveMany[] = array('subnet_id' => $subnet_id, 'fov_host_id' => $fov_host_id);
		}
		
		$return = false;
		if($data_saveMany)
		{
			$return = $this->saveMany($data_saveMany);
		}
		
		foreach($subnet_ids as $subnet_id)
		{
			$this->updateSubnetCounterCaches($subnet_id);
		}
		
		return $return;
	}
	
	/// later when needed
	public function getSubnetFovHostsStats($subnet_id = false)
	{
		if(!$subnet_id) return array();
		
		return array();
	}
	
	public function updateSubnetCounterCaches($subnet_id)
	{
		if(!$subnet_id) return false;
		$this->loadCommonNetwork();
		
		$this->Subnet->id = $subnet_id;
		$cidr = $this->Subnet->field('cidr');
		$subnet_ip_array = $this->CommonNetwork->cidrToIpArray($cidr);
		
		$existing_counts = array();
		
		// update the fisma inventory counter cache
		$fisma_inventories = $this->find('list', array(
			'contain' => array('FismaInventory'),
			'conditions' => array('SubnetMember.subnet_id' => $subnet_id, 'SubnetMember.fisma_inventory_id !=' => 0 ),
			'fields' => array('FismaInventory.ip_address', 'FismaInventory.ip_address'),
		));
		$existing_counts['fisma_inventory_count'] = count($fisma_inventories);
		
		$percent_count = 0;
		foreach($fisma_inventories as $fisma_inventory_id => $ip_address)
		{
			if(in_array($ip_address, $subnet_ip_array))
			{
				$percent_count++;
			}
		}
		$existing_counts['ip_count'] = count($subnet_ip_array);
		$existing_counts['fisma_inventory_percent'] = round((($percent_count / $existing_counts['ip_count']) * 100), 2);
		
		// update the us results counter cache
		$existing_counts['us_result_count'] = $this->find('count', array(
			'conditions' => array('SubnetMember.subnet_id' => $subnet_id, 'SubnetMember.us_result_id !=' => 0 ),
		));
		
		// update the eol results counter cache
		$existing_counts['eol_result_count'] = $this->find('count', array(
			'conditions' => array('SubnetMember.subnet_id' => $subnet_id, 'SubnetMember.eol_result_id !=' => 0 ),
		));
		
		// update the pen test counter cache
		$existing_counts['pen_test_result_count'] = $this->find('count', array(
			'conditions' => array('SubnetMember.subnet_id' => $subnet_id, 'SubnetMember.pen_test_result_id !=' => 0 ),
		));
		
		// update the high risk results counter cache
		$existing_counts['high_risk_result_count'] = $this->find('count', array(
			'conditions' => array('SubnetMember.subnet_id' => $subnet_id, 'SubnetMember.high_risk_result_id !=' => 0 ),
		));
		
		$this->Subnet->id = $subnet_id;
		return $this->Subnet->save(array('Subnet' => $existing_counts));
	}
	
	public function loadCommonNetwork()
	{
		if(!$this->CommonNetwork)
		{
			App::uses('CommonNetwork', 'Utilities.Lib');
			$this->CommonNetwork = new CommonNetwork();
		}
	}
}