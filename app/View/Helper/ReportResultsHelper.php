<?php

// app/View/Helper/WrapHelper.php
App::uses('AppHelper', 'View/Helper');

/*
 * A helper used specifically for US/EOL/PT/HRV
 */
class ReportResultsHelper extends AppHelper 
{
	
	public function ticketLinks($tickets = false)
	{
		if(!$tickets)
			return false;
		
		$tickets = explode(';', $tickets);
		
		foreach($tickets as $i => $ticket)
		{
			$ticket = trim($ticket);
			$tickets[$i] = $ticket;
			if(stripos($ticket, 'INC') !== false)
				$tickets[$i] = $this->Html->link($ticket, 'https://ticket.example.com?id='. $ticket, array('class' => 'link-ticket link-ticket-ticket', 'target' => '_blank'));
		}
		
		return implode('; ', $tickets);
	}
	
	public function waiverLinks($tickets = false)
	{
		if(!$tickets)
			return false;
		
		$tickets = explode(';', $tickets);
		
		foreach($tickets as $i => $ticket)
		{
			$ticket = trim($ticket);
			$tickets[$i] = $this->Html->link($ticket, 'https://waiver.example.com?id='. $ticket, array('class' => 'link-ticket link-ticket-waiver', 'target' => '_blank'));
		}
		
		return implode('; ', $tickets);
	}
	
	public function crLinks($tickets = false)
	{
		if(!$tickets)
			return false;
		
		$tickets = explode(';', $tickets);
		
		foreach($tickets as $i => $ticket)
		{
			$ticket = trim($ticket);
			$tickets[$i] = $this->Html->link($ticket, 'https://cr.example.com?id='. $ticket, array('class' => 'link-ticket link-ticket-changerequest', 'target' => '_blank'));
		}
		
		return implode('; ', $tickets);
	}
	
	public function ajaxCountsLinks($result = [], $action = false, $urlMerge = [])
	{
		if(!$result)
			return false;
		if(!isset($result['id']))
			return false;
		if(!$action)
			return false;
		
		return array('.', array('ajax_count_urls' => array(
			array(
				'url' => array_merge(array('action' => 'view', $result['id'], 'tab' => 'us_results'), $urlMerge), 
				'ajax_count_url' => array_merge(array('controller' => 'us_results', 'action' => $action, $result['id']), $urlMerge)
			),
			array('url' => array_merge(array('action' => 'view', $result['id'], 'tab' => 'eol_results'), $urlMerge), 'ajax_count_url' => array_merge(array('controller' => 'eol_results', 'action' => $action, $result['id']), $urlMerge)),
			array('url' => array_merge(array('action' => 'view', $result['id'], 'tab' => 'pen_test_results'), $urlMerge), 'ajax_count_url' => array_merge(array('controller' => 'pen_test_results', 'action' => $action, $result['id']), $urlMerge)),
			array('url' => array_merge(array('action' => 'view', $result['id'], 'tab' => 'high_risk_results'), $urlMerge), 'ajax_count_url' => array_merge(array('controller' => 'high_risk_results', 'action' => $action, $result['id']), $urlMerge)),
		)));
	}
	
	public function getFismaSystemContact($fismaSystem = array(), $field = false)
	{
		if(!$fismaSystem)
			return false;
		
		if(!isset($fismaSystem['primaryContacts']))
			return false;
			
		if(!$field)
			return false;
		
		$out = array();
		
		foreach($fismaSystem['primaryContacts'] as $primaryContact)
		{
			if(!isset($primaryContact['FismaContactType']))
				continue;
			if(!isset($primaryContact['FismaContactType'][$field]))
				continue;
			if(!isset($primaryContact['AdAccount']['name']))
				continue;
			if($primaryContact['FismaContactType'][$field])
				$out[$primaryContact['AdAccount']['name']] = $primaryContact['AdAccount']['name'];
		}
		return implode(', ', $out);
	}
	
	public function addFismaSystemInfo($result = array(), $asText = false, $fullName = false)
	{
		if(!$result)
			return array();
		
		$model = $this->model();
		
		$match_tracking = array('ip_address' => false, 'host_name' => false, 'mac_address' => false, 'asset_tag' => false);
		$fisma_inventory = array();
		$fisma_system = array();
		$owner = array();
		$techs = array();
		$branch = array();
		$division = array();
		
		$ip_address = (isset($result[$this->defaultModel]['ip_address'])?$result[$this->defaultModel]['ip_address']:false);
		$host_name = (isset($result[$this->defaultModel]['host_name'])?$result[$this->defaultModel]['host_name']:false);
		$mac_address = (isset($result[$this->defaultModel]['mac_address'])?$result[$this->defaultModel]['mac_address']:false);
		$asset_tag = (isset($result[$this->defaultModel]['asset_tag'])?$result[$this->defaultModel]['asset_tag']:false);
			
		if(isset($result['FismaInventories']) and $result['FismaInventories'])
		{
			foreach($result['FismaInventories'] as $fismaInventory)
			{
				if(isset($fismaInventory['FismaInventory']))
				{
					$fisma_InventoryId = $fismaInventory['FismaInventory']['id'];
					$fisma_inventory_name = $fismaInventory['FismaInventory']['name'];
					if(!$fisma_inventory_name)
						$fisma_inventory_name = $fismaInventory['FismaInventory']['asset_tag'];
					if(!$fisma_inventory_name)
						$fisma_inventory_name = $fismaInventory['FismaInventory']['dns_name'];
					if(!$fisma_inventory_name)
						$fisma_inventory_name = $fismaInventory['FismaInventory']['ip_address'];
					if(!$fisma_inventory_name)
						$fisma_inventory_name = $fismaInventory['FismaInventory']['mac_address'];
			
					$fisma_inventory[$fisma_InventoryId] = $fisma_inventory_name;
					
					if(!$asText)
						$fisma_inventory[$fisma_InventoryId] = $this->Html->link($fisma_inventory[$fisma_InventoryId], array('controller' => 'fisma_inventories', 'action' => 'view', $fisma_InventoryId));
				}
				if(isset($fismaInventory['FismaSystem']))
				{
					$fisma_systemId = $fismaInventory['FismaSystem']['id'];
					$fisma_system[$fisma_systemId] = $fismaInventory['FismaSystem']['name'];
					if($fullName)
						$fisma_system[$fisma_systemId] = $fismaInventory['FismaSystem']['fullname'];
					if(isset($result['overridden']) and $result['overridden'])
						$fisma_system[$fisma_systemId] .= ' &dagger;';
						
					if(!$asText)
						$fisma_system[$fisma_systemId] = $this->Html->link($fisma_system[$fisma_systemId], array('controller' => 'fisma_systems', 'action' => 'view', $fisma_systemId), array('escape' => false));
				}
				if(isset($fismaInventory['FismaSystem']['OwnerContact']['id']))
				{
					$ownerId = $fismaInventory['FismaSystem']['OwnerContact']['id'];
					$owner[$ownerId] = $fismaInventory['FismaSystem']['OwnerContact']['name'];
					if(!$asText)
						$owner[$ownerId] = $this->Html->link($owner[$ownerId], array('controller' => 'ad_accounts', 'action' => 'view', $ownerId));
				}
				if(isset($fismaInventory['FismaSystem']['techPocs']))
				{
					foreach($fismaInventory['FismaSystem']['techPocs'] as $techPoc)
					{
						$techId = $techPoc['AdAccount']['id'];
						$techs[$techId] = $techPoc['AdAccount']['name'];
						if(!$asText)
							$techs[$techId] = $this->Html->link($techs[$techId], array('controller' => 'ad_accounts', 'action' => 'view', $techId));
					}
				}
				if(isset($fismaInventory['FismaSystem']['OwnerContact']['Sac']['Branch']['id']))
				{
					$branchId = $fismaInventory['FismaSystem']['OwnerContact']['Sac']['Branch']['id'];
					$branch[$branchId] = $fismaInventory['FismaSystem']['OwnerContact']['Sac']['Branch']['shortname'];
					if(!$asText)
						$branch[$branchId] = $this->Html->link($branch[$branchId], array('controller' => 'branches', 'action' => 'view', $branchId));
				}
				if(isset($fismaInventory['FismaSystem']['OwnerContact']['Sac']['Branch']['Division']['id']))
				{
					$divisionId = $fismaInventory['FismaSystem']['OwnerContact']['Sac']['Branch']['Division']['id'];
					$division[$divisionId] = $fismaInventory['FismaSystem']['OwnerContact']['Sac']['Branch']['Division']['shortname'];
					if(!$asText)
						$division[$divisionId] = $this->Html->link($division[$divisionId], array('controller' => 'divisions', 'action' => 'view', $divisionId));
				}
				
				if($fismaInventory['FismaInventory']['ip_address'] and $ip_address and $fismaInventory['FismaInventory']['ip_address'] == $ip_address) 
					$match_tracking['ip_address'] = true;
				if($fismaInventory['FismaInventory']['dns_name'] and $host_name and $fismaInventory['FismaInventory']['dns_name'] == $host_name) 
					$match_tracking['host_name'] = true;
				if($fismaInventory['FismaInventory']['mac_address'] and $mac_address and $fismaInventory['FismaInventory']['mac_address'] == $mac_address) 
					$match_tracking['mac_address'] = true;
				if($fismaInventory['FismaInventory']['asset_tag'] and $asset_tag and $fismaInventory['FismaInventory']['asset_tag'] == $asset_tag) 
					$match_tracking['asset_tag'] = true;
					
			}
		}
		elseif(isset($result['FismaSystem']) and $result['FismaSystem'])
		{
			if(isset($result['FismaSystem']))
			{
				$fisma_systemId = $result['FismaSystem']['id'];
				$fisma_system[$fisma_systemId] = $result['FismaSystem']['name'];
				if($fullName)
					$fisma_system[$fisma_systemId] = $result['FismaSystem']['fullname'];
				if(isset($result['overridden']) and $result['overridden'])
					$fisma_system[$fisma_systemId] .= ' &dagger;';
					
				if(!$asText)
					$fisma_system[$fisma_systemId] = $this->Html->link($fisma_system[$fisma_systemId], array('controller' => 'fisma_systems', 'action' => 'view', $fisma_systemId), array('escape' => false));
			}
			if(isset($result['FismaSystem']['OwnerContact']['id']))
			{
				$ownerId = $result['FismaSystem']['OwnerContact']['id'];
				$owner[$ownerId] = $result['FismaSystem']['OwnerContact']['name'];
				if(!$asText)
					$owner[$ownerId] = $this->Html->link($owner[$ownerId], array('controller' => 'ad_accounts', 'action' => 'view', $ownerId));
			}
			if(isset($result['FismaSystem']['techPocs']))
			{
				foreach($result['FismaSystem']['techPocs'] as $techPoc)
				{
					$techId = $techPoc['AdAccount']['id'];
					$techs[$techId] = $techPoc['AdAccount']['name'];
					if(!$asText)
						$techs[$techId] = $this->Html->link($techs[$techId], array('controller' => 'ad_accounts', 'action' => 'view', $techId));
				}
			}
			if(isset($result['FismaSystem']['OwnerContact']['Sac']['Branch']['id']))
			{
				$branchId = $result['FismaSystem']['OwnerContact']['Sac']['Branch']['id'];
				$branch[$branchId] = $result['FismaSystem']['OwnerContact']['Sac']['Branch']['shortname'];
				if(!$asText)
					$branch[$branchId] = $this->Html->link($branch[$branchId], array('controller' => 'branches', 'action' => 'view', $branchId));
			}
			if(isset($result['FismaSystem']['OwnerContact']['Sac']['Branch']['Division']['id']))
			{
				$divisionId = $result['FismaSystem']['OwnerContact']['Sac']['Branch']['Division']['id'];
				$division[$divisionId] = $result['FismaSystem']['OwnerContact']['Sac']['Branch']['Division']['shortname'];
				if(!$asText)
					$division[$divisionId] = $this->Html->link($division[$divisionId], array('controller' => 'divisions', 'action' => 'view', $divisionId));
			}
		}
		
		$fisma_inventory = implode(', ', $fisma_inventory);
		$fisma_system = implode(', ', $fisma_system);
		$owner = implode('; ', $owner);
		$techs = implode('; ', $techs);
		$branch = implode('; ', $branch);
		$division = implode('; ', $division);
		
		$result['match_tracking'] = $match_tracking;
		$result['fisma_inventory_links'] = $fisma_inventory;
		$result['fisma_system_links'] = $fisma_system;
		$result['owner_links'] = $owner;
		$result['techs_links'] = $techs;
		$result['branch_links'] = $branch;
		$result['division_links'] = $division;
		
		return $result;
	}
}