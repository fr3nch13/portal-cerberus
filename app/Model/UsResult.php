<?php
App::uses('AppModel', 'Model');

class UsResult extends AppModel 
{
	public $order = array('UsResult.id' => 'DESC');
	
	public $belongsTo = array(
		'UsResultAddedUser' => array(
			'className' => 'User',
			'foreignKey' => 'added_user_id',
		),
		'UsResultModifiedUser' => array(
			'className' => 'User',
			'foreignKey' => 'modified_user_id',
		),
		'UsResultStatusUser' => array(
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
		'UsResultLog' => array(
			'className' => 'UsResultLog',
			'foreignKey' => 'us_result_id',
			'dependent' => true,
		),
		'SubnetMember' => array(
			'className' => 'SubnetMember',
			'foreignKey' => 'us_result_id',
			'dependent' => true,
		),
	);
	
	public $hasAndBelongsToMany = array(
		'UsReport' => array(
			'className' => 'UsReport',
			'joinTable' => 'us_reports_us_results',
			'foreignKey' => 'us_result_id',
			'associationForeignKey' => 'us_report_id',
			'unique' => 'keepExisting',
			'with' => 'UsReportUsResult',
		),
	);
	
	public $actsAs = array(
		'ReportsResults',
		'Tags.Taggable',
		'PhpRtf.PhpRtf',
		'Utilities.DomParser', 
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
		'UsResult.id',
		'UsResult.ip_address',
		'UsResult.host_name',
		'UsResult.mac_address',
		'UsResult.asset_tag',
		'UsResult.netbios',
		'UsResult.host_description',
		'ReportsOrganization.name',
		'EolSoftware.key',
		'EolSoftware.name',
		'EolSoftware.tickets',
		'EolSoftware.waiver',
	);
	
	// define the field that can be filtered
	// these would the be the belongsTo above
	public $filterOptions = array(
		'UsResult.ip_address',
		'UsResult.host_name',
		'UsResult.mac_address',
		'UsResult.netbios',
		'UsResult.example_id',
		'EolSoftware.name',
	);
	
	// used with Utilities.CommonHelper::Common_nslookup();
	public $hostLookupFields = array(
		'ipaddress' => 'ip_address',
		'hostname' => 'host_name',
	);
	
	public $containOverride = array(
		'ReportsOrganization', 'ReportsStatus',
		'EolSoftware', 'EolSoftware.ReportsAssignableParty', 
		'EolSoftware.ReportsRemediation', 
		'EolSoftware.ReportsVerification', 
	);
	
	public $containOverrideTab  = array(
		'ReportsOrganization', 'ReportsStatus',
		'EolSoftware'
	);
	
	public $dbReportId = false;
	
	public $queueId = false;
	
	public function setReportId($us_report_id = false)
	{
		if($us_report_id === false)
			return false;
		
		$usReport = $this->UsReport->read(null, $us_report_id);
		if($us_report_id > 0 and !$usReport)
		{
			return false;
		}
		
		$this->dbReportId = $us_report_id;
		
		// save it to the session
		CakeSession::write('UsResult.dbReportId', $us_report_id);
		
		return $us_report_id;
	}
	
	public function getReportId()
	{
		if($this->dbReportId)
			return $this->dbReportId;
		
		$this->dbReportId = CakeSession::read('UsResult.dbReportId');
		
		return $this->dbReportId;
	}
	
	public function getResultIdsForReport($us_report_id = false)
	{
		return $this->UsReportUsResult->getResultIdsForReport($us_report_id);
	}
	
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
			'fields' => array('UsResult.id', 'UsResult.notes'),
			'conditions' => array(
				'UsResult.id' => $ids,
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
			
			if(isset($values['UsResult']['notes']))
			{
				if(trim($values['UsResult']['notes']))
					$saveMany_data[$result_id]['notes'] = $result_notes. $notes_info. $values['UsResult']['notes'];
				else
					unset($values['UsResult']['notes']);
			}
			
			$saveMany_data[$result_id] = array_merge($values['UsResult'], $saveMany_data[$result_id]);
		}
		
		return $this->saveMany($saveMany_data);
	}
	
	public function rescan($id = false)
	{
		$this->SubnetMember->subnetsToUsResult($id);
	}
	
	public function fixData($data = array())
	{
		if(isset($data[$this->alias]['mac_address']) and $data[$this->alias]['mac_address'])
		{
			$data[$this->alias]['mac_address'] = strtoupper($data[$this->alias]['mac_address']);
			$data[$this->alias]['mac_address'] = preg_replace('/[^a-zA-Z0-9]+/',"", $data[$this->alias]['mac_address']);
		}
		
		///// for fixing incoming data from a report RTF file
		if(isset($data['eol_software_key']) and $data['eol_software_key'])
		{
			$data['eol_software_key'] = trim($data['eol_software_key']);
		}
		if(isset($data['mac_address']) and $data['mac_address'])
		{
			$data['mac_address'] = strtoupper($data['mac_address']);
			$data['mac_address'] = preg_replace('/[^a-zA-Z0-9]+/',"", $data['mac_address']);
		}
		if(isset($data['netbios']) and $data['netbios'])
		{
			$data['netbios'] = preg_replace('/\\\+/',"\\", $data['netbios']);
			$data['netbios'] = preg_replace('/\\\+\s+/',"\\", $data['netbios']);
			
			if(isset($data['asset_tag']) and !$data['asset_tag'])
			{
				$asset_tag = $data['netbios'];
				if(strpos($asset_tag, "\\") !== false)
				{
					list($domain, $asset_tag) = explode("\\", $asset_tag);
				}
				$data['asset_tag'] = strtoupper($asset_tag);
			}
		}
		if(isset($data['organization']) and $data['organization'])
		{
			$data['organization'] = strtolower($data['organization']);
			if($data['organization'] == 'ors')
				$data['organization'] = 'orsnet';
			if($data['organization'] == 'ors-facnet')
				$data['organization'] = 'facnet';
		}
		
		return $data;
	}
	
	public function autoClose()
	{
		$this->modelError = false;
		
		$order = array('UsReport.report_date' => 'DESC');
		
		$rangeEnd = date('Y-m-d H:i:s');
		$rangeStart = Configure::read('USResult.auto_close_range');
		if(!$rangeStart)
			$rangeStart = '-2 weeks';
		$rangeStart = date('Y-m-d 00:00:00', strtotime($rangeStart));
		
		$conditions = array('UsReport.report_date <=' => $rangeEnd, 'UsReport.report_date >=' => $rangeStart);
		
		if(!$reportIds = $this->UsReport->find('list', array(
			'conditions' => $conditions,
			'order' => $order,
			'fields' => array('UsReport.id', 'UsReport.id'),
		)))
		{
			$this->modelError = __('Unable to find %s within the defined range. Start: %s End: %s', __('US Reports'),  $rangeStart, $rangeEnd);
			return false;
		}
		
		// get the open and closed status ids
		if(!$statusOpenId = $this->ReportsStatus->getOpenId())
		{
			$this->modelError = __('Unable to find the %s %s.', __('OPEN'), __('Status'));
			return false;
		}
		
		if(!$statusClosedId = $this->ReportsStatus->getClosedId())
		{
			$this->modelError = __('Unable to find the %s %s.', __('CLOSED'), __('Status'));
			return false;
		}
		
		// get all of the result ids that are related to the reports
		if(!$openResultIds = $this->UsReportUsResult->find('list', array(
			'conditions' => array(
				'UsReportUsResult.us_report_id' => $reportIds,
			),
			'fields' => array('UsReportUsResult.us_result_id', 'UsReportUsResult.us_result_id'),
		)))
		{
			$this->modelError = __('Unable to find the %s related to the latest and previous %s.', __('US Results'), __('US Reports'));
			return false;
		}
		
		
		// now get a list of all results that need to be auto closed.
		if(!$toCloseResultIds = $this->find('list', array(
			'conditions' => array(
				$this->alias.'.reports_status_id' => $statusOpenId,
				$this->alias.'.id !=' => $openResultIds,
			),
			'fields' => array($this->alias.'.id', $this->alias.'.id'),
		)))
		{
			return false;
		}
		
		if($this->updateAll(
			array($this->alias.'.reports_status_id' => $statusClosedId),
			array($this->alias.'.id' => $toCloseResultIds)
		))
		{
			return $toCloseResultIds;
		}
		
		return false;
	}
	
	public function importToReport($us_report_id = false, $data = array())
	{
		if($this->queueId)
		{
			$this->Q_setId($this->queueId);
			$this->Q_updateProgress(0, __('importToReport Initial'));
		}
		
		$this->shellOut(__('Importing %s for this %s.', __('US Results'), __('US Report')));
		
		// scan the file
		if(!$results = $this->importItemsFromRtf($us_report_id))
		{
			$error = __('Unable to Import %s from the RTF File.', __('US Results'));
			if(!$this->modelError) $this->modelError = $error;
			if(!$this->UsReport->modelError) $this->UsReport->modelError = $error;
			$this->shellOut($error);
			return false;
		}
		
		if($this->queueId)
		{
			$this->Q_setId($this->queueId);
			$this->Q_updateProgress(0.99, __('importToReport Results processed.'));
		}
		
		// save the new ids to the xref table
		if(count($results['new_ids']))
		{
			$this->shellOut(__('Saving Associated Results'));
			$this->UsReportUsResult->saveAssociatedResults($us_report_id, $results['new_ids']);
		}
		
		if($this->queueId)
		{
			$this->Q_setId($this->queueId);
			$this->Q_updateProgress(1, __('importToReport complete.'));
		}
		
		return $results;
	}
	
	public function importItemsFromRtf($id = false)
	{
		if($this->queueId)
		{
			$this->Q_setId($this->queueId);
			$this->Q_updateProgress(0.01, __('importItemsFromRtf Initial'));
		}
		
		$this->modelError = false;
		$this->UsReport->modelError = false;
		
		if(!$id)
		{
			$id = $this->UsReport->id;
		}
		
		$this->shellOut(__('Importing %s from the %s\'s RTF file.', __('US Results'), __('US Report')));
		
		if(!$id)
		{
			$error = __('No ID given for the %s.', __('US Report'));
			if(!$this->modelError) $this->modelError = $error;
			if(!$this->UsReport->modelError) $this->UsReport->modelError = $error;
			$this->shellOut($error);
			return false;
		}
		
		$this->UsReport->recursive = 1;
		$this->UsReport->contain(array('Tag'));
		$report_data = $this->UsReport->read(null, $id);
		
		// scan the file
		$results = $this->scanRtfFile($id);
		if(!$results)
		{
			$error = __('No Results were found in the RTF File. (%s)', 1);
			if(!$this->modelError) $this->modelError = $error;
			if(!$this->UsReport->modelError) $this->UsReport->modelError = $error;
			$this->shellOut($error);
			return false;
		}

		if($this->queueId)
		{
			$this->Q_setId($this->queueId);
			$this->Q_updateProgress(0.06, __('importItemsFromRtf processing results'));
		}
		
		extract($results);
		
		// add/update the software if any are found
		foreach($eol_software as $i => $software)
		{
			$software['is_us'] = true;
			// check/add the software
			if(isset($software['key']) and trim($software['key']))
				$eol_software[$i]['id'] = $this->EolSoftware->checkAdd($software['key'], $software);
		}
		
		//get the open status id
		$reports_status_id = $this->ReportsStatus->getOpenId();
		
		$new_results = array();
		// used for checking for duplicates
		$eol_software_ids = array();
		$mac_addresses = array();
		$netbioses = array();
		$asset_tags = array();
		$host_names = array();
		$ip_addresses = array();
		
		$i=0;
		$total = count($results);
		$percent = 0;
		$init_percent = 0;
		if($this->queueId)
		{
			$this->Q_setId($this->queueId);
			$init_percent = $this->Q_getProgressNum();
		}
		
		foreach($results as $cnt => $result)
		{
			$new_result = array();
			$nr_result_key = array();
			$new_result['reports_status_id'] = $reports_status_id;
			
			// when this was reported to cerberus, e.g. date of this report
			$new_result['reported_to_ic_date'] = $report_data['UsReport']['report_date'];
			
			// check the eol software
			$eol_software_id = 0;
			if(isset($result['eol_software_key']) and $result['eol_software_key'])
			{
				$eol_software_key = $result['eol_software_key'];
				if(isset($eol_software[$eol_software_key]['id']))
					$eol_software_id = $eol_software[$eol_software_key]['id'];
			}
			$new_result['eol_software_id'] = $eol_software_id;
			$nr_result_key[] = $eol_software_ids[$eol_software_id] = $eol_software_id;
			
			if(isset($report_data['UsReport']['added_user_id']) and $report_data['UsReport']['added_user_id'])
				$new_result['added_user_id'] = $report_data['UsReport']['added_user_id'];
			
			if(isset($result['mac_address']) and $result['mac_address'])
				$new_result['mac_address'] = $nr_result_key[] = $mac_addresses[$result['mac_address']] = $result['mac_address'];
			
			if(isset($result['netbios']) and $result['netbios'])
				$new_result['netbios'] = $nr_result_key[] = $netbioses[$result['netbios']] = $result['netbios'];
			
			if(isset($result['asset_tag']) and $result['asset_tag'])
				$new_result['asset_tag'] = $nr_result_key[] = $asset_tags[$result['asset_tag']] = $result['asset_tag'];
			
			if(isset($result['host_name']) and $result['host_name'])
				$new_result['host_name'] = $nr_result_key[] = $host_names[$result['host_name']] = $result['host_name'];
			
			if(isset($result['ip_address']) and $result['ip_address'])
				$new_result['ip_address'] = $nr_result_key[] = $ip_addresses[$result['ip_address']] = $result['ip_address'];
			
			// if the report is tagged, tag the results as well
			if(!isset($new_result['tags']))
				$new_result['tags'] = '';
			
			if(isset($report_data['UsReport']['tags']))
				$new_result['tags'] .= ($new_result['tags']?', ':''). $report_data['UsReport']['tags'];
			
			// make sure the modified date isn't filled out
			$new_result['modified'] = false;
			
			// merge the rest with the new results
			$new_result = array_merge($result, $new_result);
			
			$nr_result_key = implode('~~', $nr_result_key);
			$new_result['nr_result_key'] = $nr_result_key;
			$new_results[$nr_result_key] = $new_result;
			
			$i++;
				
			if($this->queueId)
			{
				$this_percentage = round(($i/$total)/4, 2) + $init_percent;
				if($this_percentage != $percent)
				{
					$percent = $this_percentage;
					$this->Q_setId($this->queueId);
					$this->Q_updateProgress($percent, __('importItemsFromRtf->new results: %s of %s', $i, $total));
				}
			}
		}
				
		if($this->queueId)
		{
			$percent = round(($i/$total)/4, 2) + $init_percent;
			$this->Q_setId($this->queueId);
			$this->Q_updateProgress($percent, __('importItemsFromRtf->new results: %s of %s', $i, $total));
		}
		
		if(!$new_results)
		{
			$error = __('No Results were found in the RTF File. (%s)', 2);
			if(!$this->modelError) $this->modelError = $error;
			if(!$this->UsReport->modelError) $this->UsReport->modelError = $error;
			$this->shellOut($error);
			return false;
		}
		ksort($new_results);
		
		$this->shellOut(__('Found %s processed results', count($new_results)));
		
		// check for duplicates by ip address
		$existingConditions = array('OR' => array());
		
		if($eol_software_ids)
		{
			$existingConditions['UsResult.eol_software_id'] = $eol_software_ids;
		}
		
		if($ip_addresses)
			$existingConditions['OR'][] = array(
				'UsResult.ip_address !=' => '',
				'UsResult.ip_address' => $ip_addresses,
			);
		if($host_names)
			$existingConditions['OR'][] = array(
				'UsResult.host_name !=' => '',
				'UsResult.host_name' => $host_names,
			); 
		if($mac_addresses)
			$existingConditions['OR'][] = array(
				'UsResult.mac_address !=' => '',
				'UsResult.mac_address' => $mac_addresses,
			);
		if($netbioses)
			$existingConditions['OR'][] = array(
				'UsResult.netbios !=' => '',
				'UsResult.netbios' => $netbioses,
			);
		if($asset_tags)
			$existingConditions['OR'][] = array(
				'UsResult.asset_tag !=' => '',
				'UsResult.asset_tag' => $asset_tags,
			);
		
		$existing = $this->find('all', array(
			'recursive' => -1,
			'conditions' => $existingConditions,
			'fields' => array('id', 'eol_software_id', 'ip_address', 'host_name', 'mac_address', 'netbios', 'asset_tag'),
		));
		
		$this->shellOut(__('Found %s existing results that match.', count($existing)));
		
		// instead of finding duplicates and reporting them, maybe we should just update them from the rtf?
		$existingUpdates = array();
		$duplicates_nochange = array();
		$new_ids = array();
		$compareKeys = array('mac_address', 'netbios', 'hostname', 'ip_address');
		if($existing)
		{
			$i=0;
			$total = count($existing);
			$percent = 0;
			$init_percent = 0;
			if($this->queueId)
			{
				$this->Q_setId($this->queueId);
				$init_percent = $this->Q_getProgressNum();
			}
			
			foreach($existing as $record)
			{
				// try to find the new record that matched this existing one
				if($record[$this->alias]['eol_software_id'])
				{
					foreach($new_results as $new_result_id => $new_result)
						if($record[$this->alias]['eol_software_id'] == $new_result['eol_software_id'])
							$matchedResults[$new_result_id] = $new_result;
					
					if($matchedResults)
					{
						if($record[$this->alias]['mac_address'])
						{
							foreach($matchedResults as $new_result_id => $new_result)
								if($record[$this->alias]['mac_address'] != $new_result['mac_address'])
									unset($matchedResults[$new_result_id]);
						}
						elseif($record[$this->alias]['netbios'])
						{
							foreach($matchedResults as $new_result_id => $new_result)
								if($record[$this->alias]['netbios'] != $new_result['netbios'])
									unset($matchedResults[$new_result_id]);
						}
						elseif($record[$this->alias]['host_name'])
						{
							foreach($matchedResults as $new_result_id => $new_result)
								if($record[$this->alias]['host_name'] != $new_result['host_name'])
									unset($matchedResults[$new_result_id]);
						}
						elseif($record[$this->alias]['ip_address'])
						{
							foreach($matchedResults as $new_result_id => $new_result)
								if($record[$this->alias]['ip_address'] != $new_result['ip_address'])
									unset($matchedResults[$new_result_id]);
						}
						
					}
					
					if($matchedResults)
					{
						// see if the 2 results are different
						foreach($matchedResults as $new_result_id => $matchedResult)
						{
							$changed = false;
							
							if(isset($new_results[$new_result_id]))
							{
								foreach($new_results[$new_result_id] as $nr_key => $nr_value)
								{
									if(!in_array($nr_key, $compareKeys))
										continue;
									if(isset($record[$this->alias][$nr_key]) and isset($matchedResult[$nr_key]))
									{
										if($record[$this->alias][$nr_key] != $matchedResult[$nr_key])
										{
											$changed = true;
											if(!isset($existingUpdates[$record[$this->alias]['id']][$this->alias]))
												$existingUpdates[$record[$this->alias]['id']][$this->alias] = array(
													'id' => $record[$this->alias]['id'],
												);
											$existingUpdates[$record[$this->alias]['id']][$this->alias][$nr_key] = $matchedResult[$nr_key];
										}
									}
								}
							}
							
							// track it so we can have an xref record to this
							$new_ids[$record[$this->alias]['id']] = $record[$this->alias]['id'];
							
							// remove it from the records, as it is existing, not new
							// we don't want to add a new result record, just the new xref record
							unset($new_results[$new_result_id]);
							
						}
					}
				}
				$i++;
				
				if($this->queueId)
				{
					$this_percentage = round(($i/$total)/4, 2) + $init_percent;
					if($this_percentage != $percent)
					{
						$percent = $this_percentage;
						$this->Q_setId($this->queueId);
						$this->Q_updateProgress($percent, __('importItemsFromRtf->existing: %s of %s', $i, $total));
					}
				}
			}
				
			if($this->queueId)
			{
				$percent = round(($i/$total)/4, 2) + $init_percent;
				$this->Q_setId($this->queueId);
				$this->Q_updateProgress($percent, __('importItemsFromRtf->existing: %s of %s', $i, $total));
			}
		}
		
		$this->shellOut(__('Found %s new results', count($new_results)));
		
		// add the new results;
		if($new_results)
		{
			$i=0;
			$total = count($existing);
			$percent = 0;
			$init_percent = 0;
			if($this->queueId)
			{
				$this->Q_setId($this->queueId);
				$init_percent = $this->Q_getProgressNum();
			}
			
			foreach($new_results as $new_result)
			{
				$this->create();
				$this->data = $new_result;
				if($this->save($this->data, false))
					$new_ids[$this->id] = $this->id;
				
				if($this->queueId)
				{
					$this_percentage = round(($i/$total)/4, 2) + $init_percent;
					if($this_percentage != $percent)
					{
						$percent = $this_percentage;
						$this->Q_setId($this->queueId);
						$this->Q_updateProgress($percent, __('importItemsFromRtf->save_new_results: %s of %s', $i, $total));
					}
				}
			}
			
			if($this->queueId)
			{
				$percent = round(($i/$total)/4, 2) + $init_percent;
				$this->Q_setId($this->queueId);
				$this->Q_updateProgress($percent, __('importItemsFromRtf->save_new_results: %s of %s', $i, $total));
			}
		}
		
		// update the existing ones so they match tenable report
		if($existingUpdates)
		{
			$this->saveMany($existingUpdates, array('validate' => false));
		}
		
		return array(
			'new_ids' => $new_ids,
			'updated_ids' => array_keys($existingUpdates),
		);
	}
	
	public function scanRtfFile($id = null, $us_report_filepath = array())
	{
		if(!$id)
		{
			$id = $this->UsReport->id;
		}
		if(!$id)
		{
			return false;
		}

		if($this->queueId)
		{
			$this->Q_setId($this->queueId);
			$this->Q_updateProgress(0.04, __('scanRtfFile Initial'));
		}
		
		if(!$us_report_filepath)
		{
			$us_report = $this->UsReport->read(null, $id);
			$us_report_filepath = $us_report['UsReport']['paths']['sys'];
		}
		$this->shellOut(__('Scanning RTF file at: %s', $us_report_filepath));
		
		$this->modelError = false;
		if(!$resultTables = $this->PhpRtf_getTables($us_report_filepath))
		{
			$error = __('An issue occurred when trying to scan the RTF File.');
			if(!$this->modelError) $this->modelError = $error;
			if(!$this->UsReport->modelError) $this->UsReport->modelError = $error;
			$this->shellOut($error);
			return false;
		}
		$this->shellOut(__('Found %s tables from RTF file: %s', count($resultTables), $us_report_filepath));

		if($this->queueId)
		{
			$this->Q_setId($this->queueId);
			$this->Q_updateProgress(0.05, __('scanRtfFile %s result tables', count($resultTables)));
		}
		
		// build the key cache
		$eol_software = array();
		$pluginIds = Hash::extract($resultTables, '{n}.{n}.plugin');
		foreach($pluginIds as $i => $pluginId)
		{
			$eol_software[$pluginId] = array('id' => false, 'key' => trim($pluginId));
		}
		
		$result_default = array(
			'ip_address' => false,
			'mac_address' => false,
			'host_name' => false,
			'netbios' => false,
			'asset_tag' => false,
			'organization' => false,
			'eol_software_key' => false,
			'plugin_name' => false,
			'family' => false,
			'severity' => false,
		);
		
		$results = array();
		$i=0;
		$total = 0;
		$percent = 0;
		$init_percent = 0;
		if($this->queueId)
		{
			$this->Q_setId($this->queueId);
			$init_percent = $this->Q_getProgressNum();
		}
		foreach($resultTables as $resultTable)
		{
			foreach($resultTable as $result)
			{
				$total++;
			}
		}
		
		$this->shellOut(__('Processing %s results.', $total));
		
		foreach($resultTables as $resultTable)
		{
			foreach($resultTable as $result)
			{
				$result = array_merge($result_default, $result);
				
				$result['host_name'] = (isset($result['dns_name'])?$result['dns_name']:false);
				$result['netbios'] = (isset($result['netbios_name'])?$result['netbios_name']:false);
				$result['eol_software_key'] = (isset($result['plugin'])?$result['plugin']:false);
				$result['plugin_name'] = (isset($result['plugin_name'])?$result['plugin_name']:false);
				$result['organization'] = (isset($result['repository'])?$result['repository']:false);
				
				$result = $this->fixData($result);
				
				// pull information for this software
				if($result['eol_software_key'])
				{
					if($result['plugin_name'])
					{
						$result['plugin_name'] = trim($result['plugin_name']);
						$eol_software[$result['eol_software_key']]['name'] = $result['plugin_name'];
					}
					if(isset($result['family']) and $result['family'])
					{
						$result['family'] = trim($result['family']);
						$result['family'] = strtolower($result['family']);
						$eol_software[$result['eol_software_key']]['family'] = $result['family'];
					}
					if(isset($result['severity']) and $result['severity'])
					{
						$result['severity'] = trim($result['severity']);
						$result['severity'] = strtolower($result['severity']);
						$eol_software[$result['eol_software_key']]['severity'] = $result['severity'];
					}
				}

				$i++;
				$results[$i] = $result;
				
				if($this->queueId)
				{
					$this_percentage = round(($i/$total)/4, 2) + $init_percent;
					if($this_percentage != $percent)
					{
						$percent = $this_percentage;
						$this->Q_setId($this->queueId);
						$this->Q_updateProgress($percent, __('scanRtfFile processing results: %s of %s', $i, $total));
					}
				}
			}
		}
		
		if($this->queueId)
		{
			$percent = round(($i/$total)/4, 2) + $init_percent;
			$this->Q_setId($this->queueId);
			$this->Q_updateProgress($percent, __('scanRtfFile processed results: %s of %s', $i, $total));
		}
		
		$this->shellOut(__('Found %s total results.', $i));
		
		if(!count($results))
		{
			$error = __('No valid results were found in the RTF file.');
			if(!$this->modelError) $this->modelError = $error;
			if(!$this->UsReport->modelError) $this->UsReport->modelError = $error;
			$this->shellOut($error);
			return false;
		}
		
		return array('eol_software' => $eol_software, 'results' => $results);
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
					'UsResult.ip_address !=' => '',
					'UsResult.ip_address' => $inventoryIps,
				);
			if($inventoryDnsNames)
				$conditions['OR'][] = array(
					'UsResult.host_name !=' => '',
					'UsResult.host_name' => $inventoryDnsNames,
				); 
			if($inventoryMacAddresses)
				$conditions['OR'][] = array(
					'UsResult.mac_address !=' => '',
					'UsResult.mac_address' => $inventoryMacAddresses,
				);
			if($inventoryAssetTags)
				$conditions['OR'][] = array(
					'UsResult.asset_tag !=' => '',
					'UsResult.asset_tag' => $inventoryAssetTags,
				);
			
			// find all of the pen test results
			$usResults = $this->find('all', array(
				'conditions' => $conditions,
			));
			
			if(!count($usResults))
			{
				unset($fismaSystems[$i]);
				continue;
			}
			
			foreach($usResults as $usResult)
			{
				$usResult_id = $usResult['UsResult']['id'];
				
				if(!isset($usResultsCache[$usResult_id]))
					$usResultsCache[$usResult_id] = array();
					
				if(!isset($usResultsCache[$usResult_id][$fismaSystem['FismaSystem']['id']]))
					$usResultsCache[$usResult_id][$fismaSystem['FismaSystem']['id']] = 0;
			}
			
			$fismaSystems[$i]['UsResults'] = $usResults;
			
			$fismaSystems[$i]['resultCrossover'] = 0;
			
			$_fismaSystems[$fismaSystem_id] = $fismaSystems[$i];
			
		}
		
		$fismaSystems = $_fismaSystems;
		
		foreach($usResultsCache as $_usResult_id => $fimsaSystem_ids)
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
				
				
				foreach($fismaSystem['UsResults'] as $result_id => $usResult)
				{
					
					if(isset($ptcrossoverIds[$division_id][$result_id]))
					{
						$resultCrossover[$division_id]++;
						$ptcrossoverIds[$division_id][$result_id]++;
					}
					else
					{
						$ptresult[$division_id][] = $usResult;
						$ptcrossoverIds[$division_id][$result_id] = 0;
					}
				}
				
				$thisFismaSystems = array(
					'FismaSystem' => array(
						'name' => (isset($fismaSystem['OwnerContact']['Division']['shortname'])?$fismaSystem['OwnerContact']['Division']['shortname']:__('N/A')),
					),
					'OwnerContact' => $fismaSystem['OwnerContact'],
					'UsResults' => $ptresult[$division_id],
					'resultCrossover' => $resultCrossover[$division_id],
				);
				
				if(!isset($_fismaSystems[$division_id]))
				{
					$_fismaSystems[$division_id] = $thisFismaSystems;
				}
				else
				{
					$_fismaSystems[$division_id]['UsResults'] = array_merge($_fismaSystems[$division_id]['UsResults'], $thisFismaSystems['UsResults']);
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
