<?php
App::uses('AppModel', 'Model');

class HighRiskResult extends AppModel 
{
	public $order = array('HighRiskResult.id' => 'DESC');
	
	public $belongsTo = array(
		'HighRiskResultAddedUser' => array(
			'className' => 'User',
			'foreignKey' => 'added_user_id',
		),
		'HighRiskResultModifiedUser' => array(
			'className' => 'User',
			'foreignKey' => 'modified_user_id',
		),
		'HighRiskResultAssignablePartyUser' => array(
			'className' => 'User',
			'foreignKey' => 'assignable_party_user_id',
		),
		'HighRiskResultRemediationUser' => array(
			'className' => 'User',
			'foreignKey' => 'remediation_user_id',
		),
		'HighRiskResultStatusUser' => array(
			'className' => 'User',
			'foreignKey' => 'status_user_id',
		),
		'HighRiskResultSystemTypeUser' => array(
			'className' => 'User',
			'foreignKey' => 'system_type_user_id',
		),
		'HighRiskResultVerificationUser' => array(
			'className' => 'User',
			'foreignKey' => 'verification_user_id',
		),
		'EolSoftware' => array(
			'className' => 'EolSoftware',
			'foreignKey' => 'eol_software_id',
			'plugin_filter' => array(
				'name' => 'EOL Software',
			),
			'plugin_snapshot' => true,
			// used for the newer multiselect stuff
			// possibly used in other places as well
			'multiselect' => true,
			'nameSingle' => 'EOL Software',
		),
		'ReportsAssignableParty' => array(
			'className' => 'ReportsAssignableParty',
			'foreignKey' => 'reports_assignable_party_id',
			'plugin_filter' => array(
				'name' => 'Assignable Party',
			),
			'plugin_snapshot' => true,
			// used for the newer multiselect stuff
			// possibly used in other places as well
			'multiselect' => true,
			'nameSingle' => 'Assignable Party',
		),
		'ReportsRemediation' => array(
			'className' => 'ReportsRemediation',
			'foreignKey' => 'reports_remediation_id',
			'plugin_filter' => array(
				'name' => 'Remediation',
			),
			'plugin_snapshot' => true,
			// used for the newer multiselect stuff
			// possibly used in other places as well
			'multiselect' => true,
			'nameSingle' => 'Remediation',
		),
		'ReportsStatus' => array(
			'className' => 'ReportsStatus',
			'foreignKey' => 'reports_status_id',
			'plugin_filter' => array(
				'name' => 'Status',
			),
			'plugin_snapshot' => true,
			// used for the newer multiselect stuff
			// possibly used in other places as well
			'multiselect' => true,
			'nameSingle' => 'Status',
		),
		'ReportsSystemType' => array(
			'className' => 'ReportsSystemType',
			'foreignKey' => 'reports_system_type_id',
			'plugin_filter' => array(
				'name' => 'System Type',
			),
			'plugin_snapshot' => true,
			// used for the newer multiselect stuff
			// possibly used in other places as well
			'multiselect' => true,
			'nameSingle' => 'System Type',
		),
		'ReportsVerification' => array(
			'className' => 'ReportsVerification',
			'foreignKey' => 'reports_verification_id',
			'plugin_filter' => array(
				'name' => 'Verification',
			),
			'plugin_snapshot' => true,
			// used for the newer multiselect stuff
			// possibly used in other places as well
			'multiselect' => true,
			'nameSingle' => 'Verification',
		),
		'FismaSystem' => array(
			'className' => 'FismaSystem',
			'foreignKey' => 'fisma_system_id',
			'multiselect' => true,
		),
	);
	
	public $hasMany = array(
		'HighRiskResultLog' => array(
			'className' => 'HighRiskResultLog',
			'foreignKey' => 'high_risk_result_id',
			'dependent' => true,
		),
		'SubnetMember' => array(
			'className' => 'SubnetMember',
			'foreignKey' => 'high_risk_result_id',
			'dependent' => true,
		),
	);
	
	public $hasAndBelongsToMany = array(
		'HighRiskReport' => array(
			'className' => 'HighRiskReport',
			'joinTable' => 'high_risk_reports_high_risk_results',
			'foreignKey' => 'high_risk_result_id',
			'associationForeignKey' => 'high_risk_report_id',
			'unique' => 'keepExisting',
			'with' => 'HighRiskReportHighRiskResult',
		),
	);
	
	public $actsAs = array(
		'ReportsResults',
		'Tags.Taggable',
		'PhpExcel.PhpExcel',
		'Utilities.Extractor',
		'Usage.Usage' => array(
			'onCreate' => true,
			'onDelete' => true,
		),
		'Snapshot.Stat' => array(
			'entities' => array(
				'all' => array(),
				'created' => array(),
				'modified' => array(),
			),
		),
	);
	
	// define the fields that can be searched
	public $searchFields = array(
		'HighRiskResult.id',
		'HighRiskResult.ip_address',
		'HighRiskResult.host_name',
		'HighRiskResult.mac_address',
		'HighRiskResult.asset_tag',
		'HighRiskResult.port',
		'HighRiskResult.ticket',
		'HighRiskResult.waiver',
		'HighRiskResult.example_id',
		'EolSoftware.name',
	);
	
	// used with Utilities.CommonHelper::Common_nslookup();
	public $hostLookupFields = array(
		'ipaddress' => 'ip_address',
		'hostname' => 'host_name',
	);
	
	public function multiselectItems($data = array(), $values = array())
	{
		// injector to get the notes appending working
		
		$ids = array();
		if(isset($data['multiple']))
		{
			$ids = $data['multiple'];
		}
		
		if(!$ids)
			return false;
		
		$results = $this->find('list', array(
			'recursive' => -1,
			'fields' => array('HighRiskResult.id', 'HighRiskResult.notes'),
			'conditions' => array(
				'HighRiskResult.id' => $ids,
			),
		));
		
		$notes_info = __("\n\n---- %s - %s - user_id:%s ----\n",
			date('Y-m-d H:i:s'),
			AuthComponent::user('name'),
			AuthComponent::user('id')
		);
		
		$saveMany_data = array();
		foreach($results as $result_id => $result_notes)
		{	
			$saveMany_data[$result_id] = array('id' => $result_id);
			
			if(isset($values['HighRiskResult']['notes']))
			{
				if(trim($values['HighRiskResult']['notes']))
					$saveMany_data[$result_id]['notes'] = $result_notes. $notes_info. $values['HighRiskResult']['notes'];
				else
					unset($values['HighRiskResult']['notes']);
			}
			
			$saveMany_data[$result_id] = array_merge($values['HighRiskResult'], $saveMany_data[$result_id]);
		}
		
		return $this->saveMany($saveMany_data);
	}
	
	public function rescan($id = false)
	{
		$this->SubnetMember->subnetsToHighRiskResult($id);
	}
	
	public function fixData($data = array())
	{
		$data[$this->alias] = $this->vulnerabilityFix($data[$this->alias]);
		return $data;
	}
	
	public function importToReport($high_risk_report_id = false, $data = array())
	{
		// scan the file
		if(!$results = $this->importItemsFromExcel($high_risk_report_id))
		{
			$error = __('Unable to Import %s from the Excel File.', __('High Risk Results'));
			if(!$this->modelError) $this->modelError = $error;
			if(!$this->HighRiskReport->modelError) $this->HighRiskReport->modelError = $error;
			$this->HighRiskReport->delete($high_risk_report_id);
			return false;
		}
		
		// save the new ids to the xref table
		if(count($results['new_ids']))
			$this->HighRiskReportHighRiskResult->saveAssociatedResults($high_risk_report_id, $results['new_ids']);
		
		return $results;
	}
	
	public function importItemsFromExcel($id = false)
	{
		$this->modelError = false;
		$this->HighRiskReport->modelError = false;
		
		if(!$id)
		{
			$id = $this->HighRiskReport->id;
		}
		
		if(!$id)
		{
			$error = __('No ID given for the %s.', __('High Risk Report'));
			if(!$this->modelError) $this->modelError = $error;
			if(!$this->HighRiskReport->modelError) $this->HighRiskReport->modelError = $error;
			return false;
		}
		
		$this->HighRiskReport->recursive = 1;
		$this->HighRiskReport->contain(array('Tag'));
		$report_data = $this->HighRiskReport->read(null, $id);
		
		// scan the file
		$results = $this->scanExcelFile($id);
		if(!$results)
		{
			$error = __('No Results were found in the Excel File. (%s)', 1);
			if(!$this->modelError) $this->modelError = $error;
			if(!$this->HighRiskReport->modelError) $this->HighRiskReport->modelError = $error;
			return false;
		}
		
		extract($results);
		
		// add/update the software if any are found
		foreach($eol_software as $i => $software)
		{
			$software['is_vuln'] = true;
			// check/add the software
			if(isset($software['key']) and trim($software['key']))
				$eol_software[$i]['id'] = $this->EolSoftware->checkAdd($software['key'], $software);
		}
		
		$new_results = array();
		$ip_addresses = array(); // used for checking for duplicates
		$vulns = array(); // used for checking for duplicates
		
		foreach($results as $i => $result)
		{
			if(!isset($result['vulnerability']) or !$result['vulnerability'])
			{
				continue;
			}
			
			$result['ip_address'] = (isset($result['ip_address'])?$result['ip_address']:false);
			$result['hostname'] = (isset($result['hostname'])?$result['hostname']:false);
			
			if(!$result['ip_address'] and !$result['hostname'])
			{
				continue;
			}
			
			$new_result = array();
			
			$new_result['ip_address'] = $result['ip_address'];
			$ip_address = $ip_addresses[$result['ip_address']] = $result['ip_address'];
			
			$new_result['vulnerability'] = $result['vulnerability'];
			$vulnerability = $new_result['vulnerability_slug'] = $result['vulnerability_slug'];
			
			// check the eol software
			$eol_software_id = 0;
			if(isset($result['eol_software_key']) and $result['eol_software_key'])
			{
				$eol_software_key = $result['eol_software_key'];
				if(isset($eol_software[$eol_software_key]['id']))
					$eol_software_id = $new_result['eol_software_id'] = $eol_software[$eol_software_key]['id'];
			}
			
			if(isset($report_data['HighRiskReport']['added_user_id']) and $report_data['HighRiskReport']['added_user_id'])
				$new_result['added_user_id'] = $report_data['HighRiskReport']['added_user_id'];
			
			////// check and map the fields
			$new_result['host_name'] = '';
			if(isset($result['hostname']) and $result['hostname'])
				$new_result['host_name'] = $result['hostname'];
			
			$new_result['ip_address'] = '';
			if(isset($result['ip_address']) and $result['ip_address'])
				$new_result['ip_address'] = $result['ip_address'];
			
			$new_result['port'] = '';
			if(isset($result['port']) and $result['port'])
				$new_result['port'] = $result['port'];
			
			$new_result['dhs'] = '';
			if(isset($result['discovered_by_dhs']) and $result['discovered_by_dhs'])
				$new_result['dhs'] = $result['discovered_by_dhs'];
			
			$new_result['ticket'] = '';
			if(isset($result['ticket']) and $result['ticket'])
				$new_result['ticket'] = $result['ticket'];
				
			$new_result['reports_system_type_id'] = 0;
			if(!isset($new_result['system_type_id']) and isset($result['system_type']) and $result['system_type'])
				$new_result['reports_system_type_id'] = $this->ReportsSystemType->checkAdd($result['system_type']);
			
			// status
			$new_result['reports_status_id'] = 0;
			$new_result['comments'] = '';
			if(isset($result['status']) and $result['status'])
			{
				$result['status'] = trim($result['status']);
				$matches = array();
				if(preg_match('/^(\w+)\s*\-\s*(.*)/', $result['status'], $matches))
				{
					$new_result['reports_status_id'] = $this->ReportsStatus->checkAdd($matches[1]);
					$new_result['comments'] = $matches[2];
				}
			}
			
			// get and possibly fix the dates
			$new_result['reported_to_ic_date'] = false;
			if(isset($result['reported_to_ic']) and $result['reported_to_ic'])
			{
				// have an excel date that needs to be fixed
				if(!strtotime($result['reported_to_ic']))
				{
					$result['reported_to_ic'] = $this->Excel_fixDate($result['reported_to_ic']);
				}
				// just to make sure it worked
				if(strtotime($result['reported_to_ic']))
					$new_result['reported_to_ic_date'] = date('Y-m-d 00:00:00', strtotime($result['reported_to_ic']));
			}
			
			$new_result['resolved_by_date'] = false;
			if(isset($result['must_be_resolved_by']) and $result['must_be_resolved_by'])
			{
				// have an excel date that needs to be fixed
				if(!strtotime($result['must_be_resolved_by']))
				{
					$result['must_be_resolved_by'] = $this->Excel_fixDate($result['must_be_resolved_by']);
				}
				
				// just to make sure it worked
				if(strtotime($result['must_be_resolved_by']))
					$new_result['resolved_by_date'] = date('Y-m-d 00:00:00', strtotime($result['must_be_resolved_by']));
			}
			
			// tags
			if(isset($result['tags']) and $result['tags'])
				$new_result['tags'] = $result['tags'];
			elseif(isset($result['tag']) and $result['tag'])
				$new_result['tags'] = $result['tag'];
				
			// if the report is tagged, tag the results as well
			if(!isset($new_result['tags']))
				$new_result['tags'] = '';
			
			if(isset($report_data['HighRiskReport']['tags']))
				$new_result['tags'] .= ($new_result['tags']?', ':''). $report_data['HighRiskReport']['tags'];
			
			// make sure the modified date isn't filled out
			$new_result['modified'] = false;
			
			// merge the rest with the new results
			$new_result = array_merge($result, $new_result);
			
			$new_results[$ip_address.$vulnerability] = $new_result;
		}
		
		if(!$new_results)
		{
			$error = __('No Results were found in the Excel File. (%s)', 2);
			if(!$this->modelError) $this->modelError = $error;
			if(!$this->HighRiskReport->modelError) $this->HighRiskReport->modelError = $error;
			return false;
		}
		
		// check for duplicates by ip address
		$existing = $this->find('all', array(
			'conditions' => array(
				$this->alias.'.ip_address' => $ip_addresses,
			),
		));
		
		$duplicates = array();
		$duplicates_nochange = array();
		$new_ids = array();
		if($existing)
		{
			foreach($existing as $record)
			{
				$ip_address = $record[$this->alias]['ip_address'];
				$vulnerability = $record[$this->alias]['vulnerability_slug'];
				if(isset($new_results[$ip_address.$vulnerability]))
				{
					// see if anything has changed, if not, then add it to the new_ids for later xref adding
					$changed = false;
					foreach($new_results[$ip_address.$vulnerability] as $nr_key => $nr_value)
					{
						if(in_array($nr_key, array('tags', 'modified', 'added_user_id', 'ticket')))
							continue;
						
						if(isset($record[$this->alias][$nr_key]))
						{
							if($record[$this->alias][$nr_key] != $new_results[$ip_address.$vulnerability][$nr_key])
							{
								$changed = true;
								break;
							}
						}
					}
					
					if($changed)
					{
						$duplicates[$ip_address.$vulnerability] = $new_results[$ip_address.$vulnerability];
						$duplicates[$ip_address.$vulnerability]['id'] = $record[$this->alias]['id'];
						$duplicates[$ip_address.$vulnerability]['existing'] = $record[$this->alias];
					}
					
					// track it so we can have an xref record to this
					$new_ids[$record[$this->alias]['id']] = $record[$this->alias]['id'];
					
					// remove it from the records, as it is existing, not new
					// we don't want to add a new result record, just the new xref record
					unset($new_results[$ip_address.$vulnerability]);
				}
			}
		}
		
		if($new_results)
		{
			foreach($new_results as $i => $new_result)
			{
				$this->create();
				$this->data = $new_result;
				if($this->save($this->data))
					$new_ids[$this->id] = $this->id;
			}
		}
		
		return array(
			'new_ids' => $new_ids,
			'duplicates' => $duplicates,
		);
	}
	
	public function scanExcelFile($id = null, $high_risk_report_filepath = array())
	{
		if(!$id)
		{
			$id = $this->HighRiskReport->id;
		}
		if(!$id)
		{
			return false;
		}
		
		if(!$high_risk_report_filepath)
		{
			$high_risk_report = $this->HighRiskReport->read(null, $id);
			$high_risk_report_filepath = $high_risk_report['HighRiskReport']['paths']['sys'];
		}
		
		$this->modelError = false;
		if(!$results = $this->Excel_fileToArray($high_risk_report_filepath))
		{
			if($this->modelError)
			{
				$this->modelError = __('An issue occurred when trying to scan the Excel file.');
			}
			return false;
		}
		
		// build the key cache
		$eol_software = array();
		foreach($results as $i => $result)
		{
			$result = $this->vulnerabilityFix($result);
			$results[$i] = $result;
			
			
			if(isset($result['vulnerability']))
			{
				if(!$result['vulnerability'])
				{
					unset($results[$i]);
					continue;
				}
				$softwareName = $result['vulnerability'];
				$softwareKey = $this->slugify($softwareName);
				$softwareAction = ((isset($result['recommended_action']) and $result['recommended_action'])?$result['recommended_action']:false);
				$softwareSeverity = ((isset($result['color']) and $result['color'])?$result['color']:false);
				
				if(!isset($eol_software[$softwareKey]))
					$eol_software[$softwareKey] = array('id' => false, 'key' => $softwareKey, 'name' => $softwareName, 'action_recommended' => $softwareAction, 'severity' => $softwareSeverity);
				
				if($softwareAction and (!isset($eol_software[$softwareKey]['action_recommended']) or !$eol_software[$softwareKey]['action_recommended']))
					$eol_software[$softwareKey]['action_recommended'] = $softwareAction;
					
				if($softwareSeverity and (!isset($eol_software[$softwareKey]['color']) or !$eol_software[$softwareKey]['color']))
					$eol_software[$softwareKey]['severity'] = $softwareSeverity;
				
				$results[$i]['eol_software_key'] = $softwareKey;
			}
		}
		
		return array('eol_software' => $eol_software, 'results' => $results);
	}
	
	public function vulnerabilityFix($object = array(), $id = false)
	{
		if(!isset($object['vulnerability']))
			return $object;
		// fix the vulnerability
		$vulnerability = $object['vulnerability'];
		$vulnerability = preg_replace("/&amp;/", "&", $vulnerability);
		$vulnerability = preg_replace("/amp;/", "", $vulnerability);
		$vulnerability = preg_replace("/&#039;/", "'", $vulnerability);
		$vulnerability = preg_replace("/&lt;/", "<", $vulnerability);
		$vulnerability = preg_replace("/&gt;/", ">", $vulnerability);
		$vulnerability = preg_replace("/S{3,20}/", "SS", $vulnerability);
		
		$vulnerability_slug = $this->slugify($vulnerability);
		
		$data = array(
			'vulnerability' => $vulnerability,
			'vulnerability_slug' => $vulnerability_slug,
		);
		
		if($id)
		{
			$this->id = $id;
			$this->data = $data;
			$this->save($this->data);
		}
		return array_merge($object, $data);
	}
	
	public function dbHeatmapBySystem($by_division = false)
	{
		$conditions = array();
		
		$fismaSystems = $this->SubnetMember->FismaInventory->FismaSystem->find('all', array(
			'recursive' => 0,
			'contain' => array('OwnerContact', 'OwnerContact.Sac', 'OwnerContact.Sac.Branch', 'OwnerContact.Sac.Branch.Division', 'OwnerContact.Sac.Branch.Division.Org'),
			'conditions' => $conditions,
		));
		
		$_fismaSystems = array();
		foreach($fismaSystems as $i => $fismaSystem)
		{
			$fismaSystem_id = $fismaSystem['FismaSystem']['id'];
			$inventoryIps = $this->SubnetMember->FismaInventory->find('list', array(
				'conditions' => array(
					'FismaInventory.fisma_system_id' => $fismaSystem['FismaSystem']['id'],
					'FismaInventory.ip_address !=' => '',
				),
				'fields' => array('FismaInventory.ip_address', 'FismaInventory.ip_address'),
			));
			$inventoryHostNames = $this->SubnetMember->FismaInventory->find('list', array(
				'conditions' => array(
					'FismaInventory.fisma_system_id' => $fismaSystem['FismaSystem']['id'],
					'FismaInventory.dns_name !=' => '',
				),
				'fields' => array('FismaInventory.dns_name', 'FismaInventory.dns_name'),
			));
			
			if(!$inventoryIps and !$inventoryHostNames)
			{
				unset($fismaSystems[$i]);
				continue;
			}
			
			$conditions = array('OR' => array());
			
			if($inventoryIps)
				$conditions['OR'][] = array(
					'HighRiskResult.ip_address !=' => '',
					'HighRiskResult.ip_address' => $inventoryIps,
				);
			if($inventoryHostNames)
				$conditions['OR'][] = array(
					'HighRiskResult.host_name !=' => '',
					'HighRiskResult.host_name' => $inventoryHostNames,
				); 
			
			// find all of the pen test results
			$high_riskResults = $this->find('all', array(
				'conditions' => $conditions,
			));
			
			if(!count($high_riskResults))
			{
				unset($fismaSystems[$i]);
				continue;
			}
			
			foreach($high_riskResults as $high_riskResult)
			{
				$high_riskResult_id = $high_riskResult['HighRiskResult']['id'];
				
				if(!isset($high_riskResultsCache[$high_riskResult_id]))
					$high_riskResultsCache[$high_riskResult_id] = array();
					
				if(!isset($high_riskResultsCache[$high_riskResult_id][$fismaSystem['FismaSystem']['id']]))
					$high_riskResultsCache[$high_riskResult_id][$fismaSystem['FismaSystem']['id']] = 0;
			}
			
			$fismaSystems[$i]['HighRiskResults'] = $high_riskResults;
			
			$fismaSystems[$i]['resultCrossover'] = 0;
			
			$_fismaSystems[$fismaSystem_id] = $fismaSystems[$i];
			
		}
		
		$fismaSystems = $_fismaSystems;
		
		foreach($high_riskResultsCache as $_high_riskResult_id => $fimsaSystem_ids)
		{
			if(count($fimsaSystem_ids) < 2)
				continue;
			
			foreach($fimsaSystem_ids as $fimsaSystem_id => $blah)
			{
				if(!isset($fismaSystems[$fimsaSystem_id]['resultCrossover']))
					$fismaSystems[$fimsaSystem_id]['resultCrossover'] = 0;
				
				if(!isset($fismaSystems[$fimsaSystem_id]['resultCrossoverIds']))
					$fismaSystems[$fimsaSystem_id]['resultCrossoverIds'] = array();
					
				if(count($fimsaSystem_ids) > 1)
				{
					$fismaSystems[$fimsaSystem_id]['resultCrossover'] = count($fimsaSystem_ids);
					
					$fismaSystems[$fimsaSystem_id]['resultCrossoverIds'] = array_merge(array_keys($fimsaSystem_ids), $fismaSystems[$fimsaSystem_id]['resultCrossoverIds']);
				}
			}
		}
		
		foreach($fismaSystems as $i => $fismaSystem)
		{
			if(isset($fismaSystems[$i]['resultCrossoverIds']))
			{
				$fismaSystems[$i]['resultCrossoverIds'] = array_flip($fismaSystems[$i]['resultCrossoverIds']);
				$fismaSystems[$i]['resultCrossoverIds'] = array_flip($fismaSystems[$i]['resultCrossoverIds']);
			}
		}
		
		if($by_division)
		{
			$_fismaSystems = array();
			$ptresult = array();
			$resultCrossover = array();
			$ptcrossoverIds = array();
			foreach($fismaSystems as $i => $fismaSystem)
			{
				$division_id = (isset($fismaSystem['OwnerContact']['Sac']['Branch']['Division']['id'])?$fismaSystem['OwnerContact']['Sac']['Branch']['Division']['id']:0);
				
				if(!isset($ptresult[$division_id]))
					$ptresult[$division_id] = array();
				
				if(!isset($resultCrossover[$division_id]))
					$resultCrossover[$division_id] = 0;
					
				if(!isset($resultCrossover[$division_id]))
					$ptcrossoverIds[$division_id] = array();
				
				
				foreach($fismaSystem['HighRiskResults'] as $result_id => $high_riskResult)
				{
					
					if(isset($ptcrossoverIds[$division_id][$result_id]))
					{
						$resultCrossover[$division_id]++;
						$ptcrossoverIds[$division_id][$result_id]++;
					}
					else
					{
						$ptresult[$division_id][] = $high_riskResult;
						$ptcrossoverIds[$division_id][$result_id] = 0;
					}
				}
				
				$thisFismaSystems = array(
					'FismaSystem' => array(
						'name' => (isset($fismaSystem['OwnerContact']['Sac']['Branch']['Division']['shortname'])?$fismaSystem['OwnerContact']['Sac']['Branch']['Division']['shortname']:__('N/A')),
					),
					'OwnerContact' => $fismaSystem['OwnerContact'],
					'AdAccount' => $fismaSystem['OwnerContact'],
					'HighRiskResults' => $ptresult[$division_id],
					'resultCrossover' => $resultCrossover[$division_id],
				);
				
				if(!isset($_fismaSystems[$division_id]))
				{
					$_fismaSystems[$division_id] = $thisFismaSystems;
				}
				else
				{
					$_fismaSystems[$division_id]['HighRiskResults'] = array_merge($_fismaSystems[$division_id]['HighRiskResults'], $thisFismaSystems['HighRiskResults']);
					$_fismaSystems[$division_id]['resultCrossover'] = $_fismaSystems[$division_id]['resultCrossover'] + $thisFismaSystems['resultCrossover'];
				}
			}
			$fismaSystems = $_fismaSystems;
		}
		
		return $fismaSystems;
	}
	
	public function snapshotDashboardGetStats($snapshotKeyRegex = false, $start = false, $end = false, $step = 'day')
	{
		return $this->Snapshot_dashboardStats($snapshotKeyRegex, $start, $end, $step);
	}
	
	public function snapshotStats()
	{
		$entities = $this->Snapshot_dynamicEntities();
		return array();
	}
	
	public function fixAll()
	{
		Configure::write('debug', 1);
		$highRiskResults = $this->find('list', array(
			'fields' => array($this->alias.'.id', $this->alias.'.vulnerability'),
			'conditions' => array(
				
			)
		));
		
		foreach($highRiskResults as $highRiskResult_id => $highRiskResult_vulnerability)
		{
			$saveme = false;
			if(strpos($highRiskResult_vulnerability, 'Acount') !== false)
			{
				$saveme = true;
				$highRiskResult_vulnerability = str_replace('Acount', 'Account', $highRiskResult_vulnerability);
			}
			if(strpos($highRiskResult_vulnerability, 'Se ') !== false)
			{
				$saveme = true;
				$highRiskResult_vulnerability = str_replace('Se ', 'See ', $highRiskResult_vulnerability);
			}
			if(strpos($highRiskResult_vulnerability, 'Spreadshet') !== false)
			{
				$saveme = true;
				$highRiskResult_vulnerability = str_replace('Spreadshet', 'Spreadsheet', $highRiskResult_vulnerability);
			}
			if(strpos($highRiskResult_vulnerability, 'OpenSH') !== false)
			{
				$saveme = true;
				$highRiskResult_vulnerability = str_replace('OpenSH', 'OpenSSH', $highRiskResult_vulnerability);
			}
			if(preg_match('/(^SL|\W+SL)/i', $highRiskResult_vulnerability))
			{
				$saveme = true;
				$highRiskResult_vulnerability = str_replace('SL ', 'SSL ', $highRiskResult_vulnerability);
			}
			if(strpos($highRiskResult_vulnerability, 'OpenSL') !== false)
			{
				$saveme = true;
				$highRiskResult_vulnerability = str_replace('OpenSL', 'OpenSSL', $highRiskResult_vulnerability);
			}
			if(strpos($highRiskResult_vulnerability, 'Weaknes') !== false)
			{
				$saveme = true;
				$highRiskResult_vulnerability = str_replace('Weaknes', 'Weakness', $highRiskResult_vulnerability);
				$highRiskResult_vulnerability = str_replace('Weaknesss', 'Weakness', $highRiskResult_vulnerability);
				
			}
			if(strpos($highRiskResult_vulnerability, 'Guesable') !== false)
			{
				$saveme = true;
				$highRiskResult_vulnerability = str_replace('Guesable', 'Guessable', $highRiskResult_vulnerability);
			}
			if(strpos($highRiskResult_vulnerability, 'Comunity') !== false)
			{
				$saveme = true;
				$highRiskResult_vulnerability = str_replace('Comunity', 'Community', $highRiskResult_vulnerability);
			}
			if(strpos($highRiskResult_vulnerability, 'Alow') !== false)
			{
				$saveme = true;
				$highRiskResult_vulnerability = str_replace('Alow', 'Allow', $highRiskResult_vulnerability);
			}
			if(strpos($highRiskResult_vulnerability, 'Comon') !== false)
			{
				$saveme = true;
				$highRiskResult_vulnerability = str_replace('Comon', 'Common', $highRiskResult_vulnerability);
			}
			if(strpos($highRiskResult_vulnerability, 'Pasword') !== false)
			{
				$saveme = true;
				$highRiskResult_vulnerability = str_replace('Pasword', 'Password', $highRiskResult_vulnerability);
			}
			if(strpos($highRiskResult_vulnerability, 'Aces') !== false)
			{
				$saveme = true;
				$highRiskResult_vulnerability = str_replace('Aces', 'Access', $highRiskResult_vulnerability);
			}
			if(strpos($highRiskResult_vulnerability, 'Unsuported') !== false)
			{
				$saveme = true;
				$highRiskResult_vulnerability = str_replace('Unsuported', 'Unsupported', $highRiskResult_vulnerability);
			}
			
			if($saveme)	
			{
				$this->id = $highRiskResult_id;
				$this->saveField('vulnerability', $highRiskResult_vulnerability);
			}
		}
	}
	
	public function upsateExistingEolSoftware()
	{
		Configure::write('debug', 1);
		
		$results = $this->find('list', array(
			'conditions' => array(
				$this->alias.'.eol_software_id <' => 1
			),
			'fields' => array(
				$this->alias.'.id',
				$this->alias.'.vulnerability',
			), 
		));
		
		$vulnCache = array();
		
		foreach($results as $result_id => $vulnerability)
		{
			$slug = $this->slugify($vulnerability);
			
			$eol_software_id = 0;
			if(isset($vulnCache[$slug]))
			{
				$eol_software_id = $vulnCache[$slug];
			}
			else
			{
				$eol_software_id = $this->EolSoftware->checkAdd($slug, array('name' => $vulnerability));
			}
			
			$this->id = $result_id;
			$this->saveField('eol_software_id', $eol_software_id);
		}
		
	}
}
