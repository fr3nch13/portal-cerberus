<?php

class MetricsShell extends AppShell
{
	// the models to use
//	public $uses = array('Rule', 'FismaInventory', 'Firewall', 'FismaSystem');
	public $uses = array('Rule', 'FismaInventory');
	
	public function startup() 
	{
//		$this->clear();
		$this->Rule->shellOut('Metrics Shell');
		$this->hr();
		return parent::startup();
	}
	
	public function getOptionParser()
	{
	/*
	 * Parses out the options/arguments.
	 * http://book.cakephp.org/2.0/en/console-and-shells.html#configuring-options-and-generating-help
	 */
	
		$parser = parent::getOptionParser();
		
		$parser->description(__d('cake_console', 'The Metrics Shell runs metrics on the different objects.'));
		
		$parser->addSubcommand('yearly', array(
			'help' => __d('cake_console', 'Metrics Reports for object from the beginning of this year, to today.'),
		));
		
		return $parser;
	}
	
	public function yearly()
	{
		$created = date('Y'). '-01-01 00:00:00';
		//$created = '2013-01-01 00:00:00';
		
		
		$this->Rule->shellOut(__('Metrics Counts since %s', $created), 'metrics');
		
		$counts = array();
		
		
		$review_states = $this->Rule->ReviewState->find('list', array(
			'recursive' => -1,
			'fields' => array('ReviewState.id', 'ReviewState.name'),
			'order' => array('ReviewState.name'),
		));
		$this->Rule->shellOut(__('Found %s Review States.', count($review_states)), 'metrics');
		
		$rules = $this->Rule->find('all', array(
			'recursive' => 0,
			'contain' => array('Firewall', 'FwInt', 'Protocol'),
			'order' => array('Rule.created DESC'),
			'conditions' => array(
				'Rule.created >' => $created,
			),
		));
		
		$counts['Rules Added'] = count($rules);
		$this->Rule->shellOut(__('Found %s Rules.', $counts['Rules Added']), 'metrics');
		
		$firewalls = array();
		$fw_ints = array();
		$protocols = array();
		$_review_states = array();
		foreach($rules as $rule)
		{
			if($rule['Rule']['use_fw_int'])
			{
				$fw_int_name = $rule['FwInt']['name'];
				if(!$fw_int_name) $fw_ints['Unassigned'] = (isset($fw_ints['Unassigned'])?++$fw_ints['Unassigned']:1);
				else $fw_ints[$fw_int_name] = (isset($fw_ints[$fw_int_name])?++$fw_ints[$fw_int_name]:1);
			}
			else
			{
				$firewall_name = $rule['Firewall']['name'];
				if(!$firewall_name) $firewalls['Unassigned'] = (isset($firewalls['Unassigned'])?++$firewalls['Unassigned']:1);
				else $firewalls[$firewall_name] = (isset($firewalls[$firewall_name])?++$firewalls[$firewall_name]:1);
			}
			
			$review_state_id = $rule['Rule']['review_state_id'];
			if(!$review_state_id) $_review_states['Unassigned'] = (isset($_review_states['Unassigned'])?++$_review_states['Unassigned']:1);
			else $_review_states[$review_state_id] = (isset($_review_states[$review_state_id])?++$_review_states[$review_state_id]:1);
			
			$protocol_name = $rule['Protocol']['name'];
			if(!$protocol_name) $protocols['Unassigned'] = (isset($protocols['Unassigned'])?++$protocols['Unassigned']:1);
			else $protocols[$protocol_name] = (isset($protocols[$protocol_name])?++$protocols[$protocol_name]:1);
		}
		
		arsort($firewalls);
		$counts['Rule Counts by Firewalls'] = $firewalls;
		
		arsort($fw_ints);
		$counts['Rule Counts by Firewall Paths'] = $fw_ints;
		
		arsort($protocols);
		$counts['Rule Counts by Protocols'] = $protocols;
		
		// replace the review_state_id with the review_state name
		$review_state_counts = array();
		foreach($_review_states as $review_state_id => $count)
		{
			$name = (isset($review_states[$review_state_id])?$review_states[$review_state_id]:$review_state_id);
			
			$review_state_counts[$name] = $count;
		}
		
		arsort($review_state_counts);
		$counts['Rule Counts by Review States'] = $review_state_counts;
		
		unset($rules);
		unset($firewalls);
		unset($review_states);
		unset($_review_states);
		unset($review_state_counts);
		
////////////////////////////
		
		$fisma_inventories = $this->FismaInventory->find('all', array(
			'recursive' => 0,
			'contain' => array('FismaSystem', 'FismaType', 'FismaStatus', 'FismaSource'),
			'order' => array('FismaInventory.created DESC'),
			'conditions' => array(
				'FismaInventory.created >' => $created,
			),
		));
		
		$counts['Fisma Inventory Items Added'] = count($fisma_inventories);
		$this->Rule->shellOut(__('Found %s Fisma Inventory Items.', $counts['Fisma Inventory Items Added']), 'metrics');
		
		$fisma_systems = array();
		$fisma_types = array();
		$fisma_statuses = array();
		$fisma_sources = array();
		foreach($fisma_inventories as $fisma_inventory)
		{
			$fisma_system_name = $fisma_inventory['FismaSystem']['name'];
			if(!$fisma_system_name) $fisma_systems['Unassigned'] = (isset($fisma_systems['Unassigned'])?++$fisma_systems['Unassigned']:1);
			else $fisma_systems[$fisma_system_name] = (isset($fisma_systems[$fisma_system_name])?++$fisma_systems[$fisma_system_name]:1);
			
			$fisma_type_name = $fisma_inventory['FismaType']['name'];
			if(!$fisma_type_name) $fisma_types['Unassigned'] = (isset($fisma_types['Unassigned'])?++$fisma_types['Unassigned']:1);
			else $fisma_types[$fisma_type_name] = (isset($fisma_types[$fisma_type_name])?++$fisma_types[$fisma_type_name]:1);
			
			$fisma_status_name = $fisma_inventory['FismaStatus']['name'];
			if(!$fisma_status_name) $fisma_statuses['Unassigned'] = (isset($fisma_statuses['Unassigned'])?++$fisma_statuses['Unassigned']:1);
			else $fisma_statuses[$fisma_status_name] = (isset($fisma_statuses[$fisma_status_name])?++$fisma_statuses[$fisma_status_name]:1);
			
			$fisma_source_name = $fisma_inventory['FismaSource']['name'];
			if(!$fisma_source_name) $fisma_sources['Unassigned'] = (isset($fisma_sources['Unassigned'])?++$fisma_sources['Unassigned']:1);
			else $fisma_sources[$fisma_source_name] = (isset($fisma_sources[$fisma_source_name])?++$fisma_sources[$fisma_source_name]:1);
		}
		
		arsort($fisma_systems);
		$counts['Inventory Counts by Fisma Systems'] = $fisma_systems;
		
		arsort($fisma_types);
		$counts['Inventory Counts by Fisma Types'] = $fisma_types;
		
		arsort($fisma_statuses);
		$counts['Inventory Counts by Fisma Statuses'] = $fisma_statuses;
		
		arsort($fisma_sources);
		$counts['Inventory Counts by Fisma Sources'] = $fisma_sources;
		
		unset($rules);
		unset($fisma_systems);
		unset($fisma_types);
		unset($fisma_statuses);
		unset($fisma_sources);
		
		
pr($counts);
	}
}