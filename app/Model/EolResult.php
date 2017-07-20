<?php
App::uses('AppModel', 'Model');

class EolResult extends AppModel 
{
	public $order = array('EolResult.id' => 'DESC');
	
	public $belongsTo = array(
		'EolResultAddedUser' => array(
			'className' => 'User',
			'foreignKey' => 'added_user_id',
		),
		'EolResultModifiedUser' => array(
			'className' => 'User',
			'foreignKey' => 'modified_user_id',
		),
		'EolResultRemediationUser' => array(
			'className' => 'User',
			'foreignKey' => 'remediation_user_id',
		),
		'EolResultVerificationUser' => array(
			'className' => 'User',
			'foreignKey' => 'verification_user_id',
		),
		'EolResultStatusUser' => array(
			'className' => 'User',
			'foreignKey' => 'status_user_id',
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
		'ReportsOrganization' => array(
			'className' => 'ReportsOrganization',
			'foreignKey' => 'reports_organization_id',
			'plugin_filter' => true,
			'plugin_snapshot' => true,
			// used for the newer multiselect stuff
			// possibly used in other places as well
			'multiselect' => true,
			'nameSingle' => 'Organization',
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
		'FismaSoftware' => array(
			'className' => 'FismaSoftware',
			'foreignKey' => 'fisma_software_id',
		),
		'FismaSystem' => array(
			'className' => 'FismaSystem',
			'foreignKey' => 'fisma_system_id',
			'multiselect' => true,
		),
	);
	
	public $hasMany = array(
		'EolResultLog' => array(
			'className' => 'EolResultLog',
			'foreignKey' => 'eol_result_id',
			'dependent' => true,
		),
		'SubnetMember' => array(
			'className' => 'SubnetMember',
			'foreignKey' => 'eol_result_id',
			'dependent' => true,
		),
	);
	
	public $hasAndBelongsToMany = array(
		'EolReport' => array(
			'className' => 'EolReport',
			'joinTable' => 'eol_reports_eol_results',
			'foreignKey' => 'eol_result_id',
			'associationForeignKey' => 'eol_report_id',
			'unique' => 'keepExisting',
			'with' => 'EolReportEolResult',
		),
	);
	
	public $actsAs = array(
		'ReportsResults',
		'Tags.Taggable',
		'PhpPdf.PhpPdf', 
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
		'EolResult.id',
		'EolResult.ip_address',
		'EolResult.host_name',
		'EolResult.mac_address',
		'EolResult.asset_tag',
		'EolResult.netbios',
		'EolResult.host_description',
		'EolResult.tickets',
		'EolResult.waiver',
		'EolResult.example_id',
		'ReportsOrganization.name',
		'EolSoftware.name',
	);
	
	// define the field that can be filtered
	// these would the be the belongsTo above
	public $filterOptions = array(
		'EolResult.ip_address',
		'EolResult.host_name',
		'EolResult.mac_address',
		'EolResult.netbios',
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
			'fields' => array('EolResult.id', 'EolResult.notes'),
			'conditions' => array(
				'EolResult.id' => $ids,
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
			
			if(isset($values['EolResult']['notes']))
			{
				if(trim($values['EolResult']['notes']))
					$saveMany_data[$result_id]['notes'] = $result_notes. $notes_info. $values['EolResult']['notes'];
				else
					unset($values['EolResult']['notes']);
			}
			
			$saveMany_data[$result_id] = array_merge($values['EolResult'], $saveMany_data[$result_id]);
		}
		
		return $this->saveMany($saveMany_data);
	}
	
	public function importToReport($eol_report_id = false, $data = array())
	{
		// scan the file
		if(!$results = $this->importItemsFromPdf($eol_report_id))
		{
			$error = __('Unable to Import %s from the PDF File.', __('EOL Results'));
			if(!$this->modelError) $this->modelError = $error;
			if(!$this->EolReport->modelError) $this->EolReport->modelError = $error;
			$this->EolReport->delete($eol_report_id);
			return false;
		}
		
		// save the new ids to the xref table
		if(count($results['new_ids']))
			$this->EolReportEolResult->saveAssociatedResults($eol_report_id, $results['new_ids']);
		
		// if we have duplicates, make sure the Controller knows.
		return $results;
	}
	
	public function importItemsFromPdf($id = false)
	{
		$this->modelError = false;
		$this->EolReport->modelError = false;
		
		if(!$id)
		{
			$id = $this->EolReport->id;
		}
		
		if(!$id)
		{
			$error = __('No ID given for the %s.', __('EOL Report'));
			if(!$this->modelError) $this->modelError = $error;
			if(!$this->EolReport->modelError) $this->EolReport->modelError = $error;
			return false;
		}
		
		$this->EolReport->recursive = 1;
		$this->EolReport->contain(array('Tag'));
		$report_data = $this->EolReport->read(null, $id);
		
		// scan the file
		$results = $this->scanPdfFile($id);
		if(!$results)
		{
			$error = __('No Results were found in the PDF File. (%s)', 1);
			if(!$this->modelError) $this->modelError = $error;
			if(!$this->EolReport->modelError) $this->EolReport->modelError = $error;
			return false;
		}
		
		extract($results);
		
		// see about adding the software if any are found
		foreach($eol_software as $i => $software)
		{
			// check/add the software
			if(isset($software['key']) and trim($software['key']))
				$eol_software[$i]['id'] = $this->EolSoftware->checkAdd($software['key'], $software);
		}
		
		$new_results = array();
		$ip_addresses = array(); // used for checking for duplicates
		
		foreach($results as $i => $result)
		{
			if(!isset($result['ip_address']) or !$result['ip_address'])
			{
				continue;
			}
			
			$new_result = array();
			
			$new_result['ip_address'] = $result['ip_address'];
			$ip_address = $ip_addresses[$result['ip_address']] = $result['ip_address'];
			
			if(isset($report_data['EolReport']['added_user_id']) and $report_data['EolReport']['added_user_id'])
				$new_result['added_user_id'] = $report_data['EolReport']['added_user_id'];
			
			if(isset($result['host_name']) and $result['host_name'])
				$new_result['host_name'] = $result['host_name'];
			
			if(isset($result['mac_address']) and $result['mac_address'])
			{
				$result['mac_address'] = strtoupper($result['mac_address']);
				$result['mac_address'] = str_replace(':', '', $result['mac_address']);
				$new_result['mac_address'] = $result['mac_address'];
			}
			
			if(isset($result['netbios']) and $result['netbios'])
				$new_result['netbios'] = $result['netbios'];
			
			// check the eol software
			$eol_software_id = 0;
			if(isset($result['eol_software_key']) and $result['eol_software_key'])
			{
				$eol_software_key = $result['eol_software_key'];
				if(isset($eol_software[$eol_software_key]['id']))
					$eol_software_id = $new_result['eol_software_id'] = $eol_software[$eol_software_key]['id'];
			}
			
			// if the report is tagged, tag the results as well
			if(!isset($new_result['tags']))
				$new_result['tags'] = '';
			
			if(isset($report_data['EolReport']['tags']))
				$new_result['tags'] .= ($new_result['tags']?', ':''). $report_data['EolReport']['tags'];
			
			// make sure the modified date isn't filled out
			$new_result['modified'] = false;
			
			// merge the rest with the new results
			$new_result = array_merge($result, $new_result);
			
			$nr_result_key = $ip_address.'-'.$eol_software_id;
			$new_results[$nr_result_key] = $new_result;
		}
		
		if(!$new_results)
		{
			$error = __('No Results were found in the PDF File. (%s)', 2);
			if(!$this->modelError) $this->modelError = $error;
			if(!$this->EolReport->modelError) $this->EolReport->modelError = $error;
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
				$nr_result_key = $record[$this->alias]['ip_address'].'-'.$record[$this->alias]['eol_software_id'];
				if(isset($new_results[$nr_result_key]))
				{
					// see if anything has changed, if not, then add it to the new_ids for later xref adding
					$changed = false;
					foreach($new_results[$nr_result_key] as $nr_key => $nr_value)
					{
						if(in_array($nr_key, array('tags', 'modified', 'eol_software_id', 'added_user_id')))
							continue;
						
						if(isset($record[$this->alias][$nr_key]))
						{
							if($record[$this->alias][$nr_key] != $new_results[$nr_result_key][$nr_key])
							{
								$changed = true;
								break;
							}
						}
					}
					
					if($changed)
					{
						$duplicates[$nr_result_key] = $new_results[$nr_result_key];
						$duplicates[$nr_result_key]['id'] = $record[$this->alias]['id'];
						$duplicates[$nr_result_key]['existing'] = $record[$this->alias];
					}
					
					// track it so we can have an xref record to this
					$new_ids[$record[$this->alias]['id']] = $record[$this->alias]['id'];
					
					// remove it from the records, as it is existing, not new
					// we don't want to add a new result record, just the new xref record
					unset($new_results[$nr_result_key]);
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
	
	public function scanPdfFile($id = null, $eol_report_filepath = array())
	{
		if(!$id)
		{
			$id = $this->EolReport->id;
		}
		if(!$id)
		{
			return false;
		}
		
		if(!$eol_report_filepath)
		{
			$eol_report = $this->EolReport->read(null, $id);
			$eol_report_filepath = $eol_report['EolReport']['paths']['sys'];
		}
		
		$this->modelError = false;
		if(!$results = $this->PhpPdf_getText($eol_report_filepath))
		{
			if($this->modelError)
			{
				$this->modelError = __('An issue occurred when trying to scan the PDF File.');
			}
			return false;
		}
		
		$pdf_text = explode("\n", $results);
		
		$results = array();
		$eol_software = array();
		
		$result_default = array(
			'ip_address' => false,
			'mac_address' => false,
			'host_name' => false,
			'netbios' => false,
			'eol_software_key' => false,
		);
		
		$eol_software_default = array(
			'key' => false,
			'name' => false,
		);
		
		$eol_software_search = 0;
		$eol_software_key = false;
		$eol_software_name = false;
		$eol_software_key_latest = false;
		
		foreach($pdf_text as $i => $line)
		{
			$line = trim($line);
			$line_slug = Inflector::slug(strtolower($line));
			
			// we're tracking a plugin.
			// the next line is the plugin key
			if($line_slug == 'plugin')
			{
				$eol_software_search = 1;
				unset($pdf_text[$i]); // garbage collection
				continue;
			}
			if($line_slug == 'plugin_name')
			{
				$eol_software_search = 2;
				unset($pdf_text[$i]); // garbage collection
				continue;
			}
			
			// we're on the next line looking for the plugin key
			if($eol_software_search)
			{
				// blank plugin jump out of plugin searching
				if(!$line)
				{
					$eol_software_search = 0;
					unset($pdf_text[$i]); // garbage collection
					continue;
				}
				
				if($eol_software_search == 1)
				{
					$eol_software_key = $line;
					unset($pdf_text[$i]); // garbage collection
					continue;
				}
				elseif($eol_software_search == 2)
				{
					$eol_software_name = $line;
					unset($pdf_text[$i]); // garbage collection
					continue;
				}
			}
			
			if($eol_software_key)
			{
				$eol_software_key_latest = $eol_software_key;
				
				if(!isset($eol_software[$eol_software_key]))
					$eol_software[$eol_software_key] = $eol_software_default;
				
				$eol_software[$eol_software_key]['key'] = $eol_software_key;
				
				if($eol_software_name)
					$eol_software[$eol_software_key]['name'] = $eol_software_name;

				$eol_software_key = false;
				$eol_software_name = false;
			}
			
			// now that we have a software, we can skip empty lines
			if(!$line)
			{
				unset($pdf_text[$i]); // garbage collection
				continue;
			}
			
			// try to find ip addresses/mac addresses/etc.
			$objects = $this->extractItems($line);
			foreach($objects as $j => $object)
				if(!$object)
					unset($objects[$j]);
			
			// if it finds a single ip address, we have a record to create
			if(isset($objects['ipaddress'][0]) and count($objects['ipaddress']) == 1)
			{
				$ip_address = $objects['ipaddress'][0];
				if(!isset($results[$ip_address]))
					$results[$ip_address] = $result_default;
				
				$results[$ip_address]['ip_address'] = $ip_address;
				
				if(isset($objects['hostname'][0]) and count($objects['hostname']) == 1)
					$results[$ip_address]['host_name'] = $objects['hostname'][0];
				
				if(isset($objects['mac'][0]) and count($objects['mac']) == 1)
					$results[$ip_address]['mac_address'] = $objects['mac'][0];
				
				if(isset($objects['netbios'][0]) and count($objects['netbios']) == 1)
					$results[$ip_address]['netbios'] = $objects['netbios'][0];
				
				$results[$ip_address]['eol_software_key'] = $eol_software_key_latest;
				
			}
		}
		
		if(!count($results))
			return false;
		return array('results' => $results, 'eol_software' => $eol_software);
	}
	
	public function dbHeatmapBySystem($by_division = false)
	{
		$conditions = array();
		
		$fismaSystems = $this->SubnetMember->FismaInventory->FismaSystem->find('all', array(
			'recursive' => 0,
			'contain' => array('OwnerContact', 'OwnerContact.Division'),
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
			$inventoryDnsNames = $this->SubnetMember->FismaInventory->find('list', array(
				'conditions' => array(
					'FismaInventory.fisma_system_id' => $fismaSystem['FismaSystem']['id'],
					'FismaInventory.dns_name !=' => '',
				),
				'fields' => array('FismaInventory.dns_name', 'FismaInventory.dns_name'),
			));
			$inventoryMacAddresses = $this->SubnetMember->FismaInventory->find('list', array(
				'conditions' => array(
					'FismaInventory.fisma_system_id' => $fismaSystem['FismaSystem']['id'],
					'FismaInventory.mac_address !=' => '',
				),
				'fields' => array('FismaInventory.mac_address', 'FismaInventory.mac_address'),
			));
			$inventoryAssetTags = $this->SubnetMember->FismaInventory->find('list', array(
				'conditions' => array(
					'FismaInventory.fisma_system_id' => $fismaSystem['FismaSystem']['id'],
					'FismaInventory.asset_tag !=' => '',
				),
				'fields' => array('FismaInventory.asset_tag', 'FismaInventory.asset_tag'),
			));
			
			if(!$inventoryIps and !$inventoryDnsNames and !$inventoryMacAddresses and !$inventoryAssetTags)
			{
				unset($fismaSystems[$i]);
				continue;
			}
			
			$conditions = array('OR' => array());
			
			if($inventoryIps)
				$conditions['OR'][] = array(
					'EolResult.ip_address !=' => '',
					'EolResult.ip_address' => $inventoryIps,
				);
			if($inventoryDnsNames)
				$conditions['OR'][] = array(
					'EolResult.host_name !=' => '',
					'EolResult.host_name' => $inventoryDnsNames,
				); 
			if($inventoryMacAddresses)
				$conditions['OR'][] = array(
					'EolResult.mac_address !=' => '',
					'EolResult.mac_address' => $inventoryMacAddresses,
				);
			if($inventoryAssetTags)
				$conditions['OR'][] = array(
					'EolResult.asset_tag !=' => '',
					'EolResult.asset_tag' => $inventoryAssetTags,
				);
			
			// find all of the pen test results
			$eolResults = $this->find('all', array(
				'conditions' => $conditions,
			));
			
			if(!count($eolResults))
			{
				unset($fismaSystems[$i]);
				continue;
			}
			
			foreach($eolResults as $eolResult)
			{
				$eolResult_id = $eolResult['EolResult']['id'];
				
				if(!isset($eolResultsCache[$eolResult_id]))
					$eolResultsCache[$eolResult_id] = array();
					
				if(!isset($eolResultsCache[$eolResult_id][$fismaSystem['FismaSystem']['id']]))
					$eolResultsCache[$eolResult_id][$fismaSystem['FismaSystem']['id']] = 0;
			}
			
			$fismaSystems[$i]['EolResults'] = $eolResults;
			
			$fismaSystems[$i]['resultCrossover'] = 0;
			
			$_fismaSystems[$fismaSystem_id] = $fismaSystems[$i];
			
		}
		
		$fismaSystems = $_fismaSystems;
		
		foreach($eolResultsCache as $_eolResult_id => $fimsaSystem_ids)
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
				$division_id = (isset($fismaSystem['OwnerContact']['Division']['id'])?$fismaSystem['OwnerContact']['Division']['id']:0);
				
				if(!isset($ptresult[$division_id]))
					$ptresult[$division_id] = array();
				
				if(!isset($resultCrossover[$division_id]))
					$resultCrossover[$division_id] = 0;
					
				if(!isset($resultCrossover[$division_id]))
					$ptcrossoverIds[$division_id] = array();
				
				
				foreach($fismaSystem['EolResults'] as $result_id => $eolResult)
				{
					
					if(isset($ptcrossoverIds[$division_id][$result_id]))
					{
						$resultCrossover[$division_id]++;
						$ptcrossoverIds[$division_id][$result_id]++;
					}
					else
					{
						$ptresult[$division_id][] = $eolResult;
						$ptcrossoverIds[$division_id][$result_id] = 0;
					}
				}
				
				$thisFismaSystems = array(
					'FismaSystem' => array(
						'name' => (isset($fismaSystem['OwnerContact']['Division']['shortname'])?$fismaSystem['OwnerContact']['Division']['shortname']:__('N/A')),
					),
					'OwnerContact' => $fismaSystem['OwnerContact'],
					'EolResults' => $ptresult[$division_id],
					'resultCrossover' => $resultCrossover[$division_id],
				);
				
				if(!isset($_fismaSystems[$division_id]))
				{
					$_fismaSystems[$division_id] = $thisFismaSystems;
				}
				else
				{
					$_fismaSystems[$division_id]['EolResults'] = array_merge($_fismaSystems[$division_id]['EolResults'], $thisFismaSystems['EolResults']);
					$_fismaSystems[$division_id]['resultCrossover'] = $_fismaSystems[$division_id]['resultCrossover'] + $thisFismaSystems['resultCrossover'];
				}
			}
			$fismaSystems = $_fismaSystems;
		}
		
		return $fismaSystems;
	}
	
	public function snapshotDashboardGetStats($snapshotKeyRegex = false, $start = false, $end = false)
	{
		return $this->Snapshot_dashboardStats($snapshotKeyRegex, $start, $end);
	}
	
	public function snapshotStats()
	{
		$entities = $this->Snapshot_dynamicEntities();
		return array();
	}
}
