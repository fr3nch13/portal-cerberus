<?php
App::uses('AppModel', 'Model');

class PoamResult extends AppModel 
{
	public $order = array('PoamResult.id' => 'DESC');
	
	public $belongsTo = array(
		'PoamResultAddedUser' => array(
			'className' => 'User',
			'foreignKey' => 'added_user_id',
		),
		'PoamResultModifiedUser' => array(
			'className' => 'User',
			'foreignKey' => 'modified_user_id',
		),
		'PoamCriticality' => array(
			'className' => 'PoamCriticality',
			'foreignKey' => 'poam_criticality_id',
			'plugin_filter' => array(
				'name' => 'Criticality',
			),
			'plugin_snapshot' => true,
			// used for the newer multiselect stuff
			// possibly used in other places as well
			'multiselect' => true,
			'nameSingle' => 'Criticality',
		),
		'PoamRisk' => array(
			'className' => 'PoamRisk',
			'foreignKey' => 'poam_risk_id',
			'plugin_filter' => array(
				'name' => 'Risk',
			),
			'plugin_snapshot' => true,
			// used for the newer multiselect stuff
			// possibly used in other places as well
			'multiselect' => true,
			'nameSingle' => 'Risk',
		),
		'PoamSeverity' => array(
			'className' => 'PoamSeverity',
			'foreignKey' => 'poam_severity_id',
			'plugin_filter' => array(
				'name' => 'Severity',
			),
			'plugin_snapshot' => true,
			'multiselect' => true,
			'nameSingle' => 'Severity',
		),
		'PoamStatus' => array(
			'className' => 'PoamStatus',
			'foreignKey' => 'poam_status_id',
			'plugin_filter' => array(
				'name' => 'Status',
			),
			'plugin_snapshot' => true,
			// used for the newer multiselect stuff
			// possibly used in other places as well
			'multiselect' => true,
			'nameSingle' => 'Status',
		),
		'FismaSystem' => array(
			'className' => 'FismaSystem',
			'foreignKey' => 'fisma_system_id',
			'plugin_snapshot' => true,
			'multiselect' => true,
			'nameSingle' => 'FISMA System',
		),
	);
	
	public $hasMany = array(
		'PoamResultLog' => array(
			'className' => 'PoamResultLog',
			'foreignKey' => 'poam_result_id',
			'dependent' => true,
		),
	);
	
	public $hasAndBelongsToMany = array(
		'PoamReport' => array(
			'className' => 'PoamReport',
			'joinTable' => 'poam_reports_poam_results',
			'foreignKey' => 'poam_result_id',
			'associationForeignKey' => 'poam_report_id',
			'unique' => 'keepExisting',
			'with' => 'PoamReportPoamResult',
		),
	);
	
	public $actsAs = array(
		'Poam',
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
/*
			'countCriteria' => array(
				'conditions' => array(
					'PoamResult.auto_closed' => false,
				),
			),
*/
		),
	);
	
	// define the fields that can be searched
	public $searchFields = array(
		'PoamResult.id',
		'PoamResult.weakness_id',
		'PoamResult.description',
		'PoamResult.tickets',
		'PoamResult.waiver',
		'FismaSystem.name',
		'PoamCriticality.name',
		'PoamRisk.name',
		'PoamSeverity.name',
		'PoamStatus.name'
	);
	
	public $containOverride = array(
		'PoamCriticality', 'PoamRisk', 'PoamSeverity', 'PoamStatus', 
		'FismaSystem', 'FismaSystem.OwnerContact', 
		'FismaSystem.OwnerContact.Sac', 'FismaSystem.OwnerContact.Sac.Branch', 
		'FismaSystem.OwnerContact.Sac.Branch.Division', 'FismaSystem.OwnerContact.Sac.Branch.Division.Org'
	);
	
	public $importMap = array(
		'uuid' => 'fisma_system_uuid',
		'system_site_program' => 'fisma_system_name',
		'weakness_description' => 'description',
		'weakness_id' => 'weakness_id',
		'identified_in' => 'identified_date',
		'creation_date' => 'creation_date',
		'scheduled_completion_date' => 'scheduled_completion_date',
		'estimated_completion_date' => 'estimated_completion_date',
		'actual_completion_date' => 'actual_completion_date',
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
			'fields' => array('PoamResult.id', 'PoamResult.notes'),
			'conditions' => array(
				'PoamResult.id' => $ids,
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
			
			if(isset($values['PoamResult']['notes']))
			{
				if(trim($values['PoamResult']['notes']))
					$saveMany_data[$result_id]['notes'] = $result_notes. $notes_info. $values['PoamResult']['notes'];
				else
					unset($values['PoamResult']['notes']);
			}
			
			$saveMany_data[$result_id] = array_merge($values['PoamResult'], $saveMany_data[$result_id]);
		}
		
		return $this->saveMany($saveMany_data);
	}
	
	public function importToReport($poam_report_id = false, $data = array())
	{
		// scan the file
		if(!$results = $this->importItemsFromExcel($poam_report_id))
		{
			$error = __('Unable to Import %s from the Excel File.', __('POA&M Results'));
			if(!$this->modelError) $this->modelError = $error;
			if(!$this->PoamReport->modelError) $this->PoamReport->modelError = $error;
			$this->PoamReport->delete($poam_report_id);
			return false;
		}
		
		// save the new ids to the xref table
		if(count($results['new_ids']))
			$this->PoamReportPoamResult->saveAssociatedResults($poam_report_id, $results['new_ids']);
		
		return $results;
	}
	
	public function importItemsFromExcel($id = false)
	{
		$this->modelError = false;
		$this->PoamReport->modelError = false;
		
		if(!$id)
		{
			$id = $this->PoamReport->id;
		}
		
		if(!$id)
		{
			$error = __('No ID given for the %s.', __('POA&M Report'));
			if(!$this->modelError) $this->modelError = $error;
			if(!$this->PoamReport->modelError) $this->PoamReport->modelError = $error;
			return false;
		}
		
		$this->PoamReport->recursive = 1;
		$this->PoamReport->contain(array('Tag'));
		$report_data = $this->PoamReport->read(null, $id);
		
		// scan the file
		$results = $this->scanExcelFile($id);
		if(!$results)
		{
			$error = __('No Results were found in the Excel File. (%s)', 1);
			if(!$this->modelError) $this->modelError = $error;
			if(!$this->PoamReport->modelError) $this->PoamReport->modelError = $error;
			return false;
		}
		
		// extract the attributes like status, severity, etc
		$poamStatuses = Hash::extract($results, '{n}.status'); $poamStatuses = $this->PoamStatus->checkAdds($poamStatuses);
		$poamCriticalities = Hash::extract($results, '{n}.criticality_priority'); $poamCriticalities = $this->PoamCriticality->checkAdds($poamCriticalities);
		$poamRisks = Hash::extract($results, '{n}.risk_category'); $poamRisks = $this->PoamRisk->checkAdds($poamRisks);
		$poamSeverities = Hash::extract($results, '{n}.severity'); $poamSeverities = $this->PoamSeverity->checkAdds($poamSeverities); 
		$fismaSystemUuids = Hash::extract($results, '{n}.uuid'); $fismaSystemUuids = $this->FismaSystem->getIdsFromUuids($fismaSystemUuids);
		
		$new_results = array();
		$weakness_id = array();
		
		foreach($results as $i => $result)
		{
			$new_result = array();
			
			// when this was reported to cerberus, e.g. date of this report
			$new_result['reported_to_ic_date'] = $report_data['PoamReport']['report_date'];
			
			if(isset($report_data['PoamReport']['added_user_id']) and $report_data['PoamReport']['added_user_id'])
				$new_result['added_user_id'] = $report_data['PoamReport']['added_user_id'];
			
			// if the report is tagged, tag the results as well
			if(!isset($new_result['tags']))
				$new_result['tags'] = '';
			
			if(isset($report_data['PoamReport']['tags']))
				$new_result['tags'] .= ($new_result['tags']?', ':''). $report_data['PoamReport']['tags'];
			
			// make sure the modified date isn't filled out
			$new_result['modified'] = false;
			
			// the attributes
			if(isset($result['status']))
			{
				$slug = $this->slugify($result['status']);
				$new_result['poam_status_id'] = (isset($poamStatuses[$slug])?$poamStatuses[$slug]:0);
			}
			if(isset($result['criticality_priority']))
			{
				$slug = $this->slugify($result['criticality_priority']);
				$new_result['poam_criticality_id'] = (isset($poamCriticalities[$slug])?$poamCriticalities[$slug]:0);
			}
			if(isset($result['risk_category']))
			{
				$slug = $this->slugify($result['risk_category']);
				$new_result['poam_risk_id'] = (isset($poamRisks[$slug])?$poamRisks[$slug]:0);
			}
			if(isset($result['severity']))
			{
				$slug = $this->slugify($result['severity']);
				$new_result['poam_severity_id'] = (isset($poamSeverities[$slug])?$poamSeverities[$slug]:0);
			}
			if(isset($result['uuid']))
			{
				$slug = strtoupper($result['uuid']);
				$new_result['fisma_system_id'] = (isset($fismaSystemUuids[$slug])?$fismaSystemUuids[$slug]:0);
			}
			
			foreach($this->importMap as $excelField => $databaseField)
			{
				if(isset($result[$excelField]))
					$new_result[$databaseField] = $result[$excelField];
			}
			
			$nr_result_key = $new_result['weakness_id'];
			$new_result['nr_result_key'] = $nr_result_key;
			$new_results[$nr_result_key] = $new_result;
		}
		
		
		$existing = $this->find('all', array(
			'recursive' => -1,
			'conditions' => array($this->alias.'.weakness_id' => array_keys($new_results)),
		));
		
		if(!$new_results)
		{
			$error = __('No Results were found in the Excel File. (%s)', 2);
			if(!$this->modelError) $this->modelError = $error;
			if(!$this->PoamReport->modelError) $this->PoamReport->modelError = $error;
			return false;
		}
		ksort($new_results);
		
		$new_ids = array();
		$existingUpdates = array();
		
		if($existing)
		{
			foreach($existing as $record)
			{
				$weakness_id = $record[$this->alias]['weakness_id'];
				
				// track this record for the xref table to this report
				$new_ids[$record[$this->alias]['id']] = $record[$this->alias]['id'];
				
				// update the record in the database and overrite the database record form the excel file
				$existingUpdates[$record[$this->alias]['id']][$this->alias] = array_merge($record[$this->alias], $new_results[$weakness_id]);
				
				// remove it from the records, as it is existing, not new
				// we don't want to add a new result record, just the new xref record
				unset($new_results[$weakness_id]);
			}
		}
		
		// add the new results;
		if($new_results)
		{
			foreach($new_results as $i => $new_result)
			{
				$this->create();
				$this->data = $new_result;
				if($this->save($this->data, false))
					$new_ids[$this->id] = $this->id; // track for xref table
			}
		}
		
		// update the existing ones so they match tenable report
		if($existingUpdates)
		{
			$this->saveMany($existingUpdates, array('validate' => false));
		}
		
		// auto close all of the results that aren't in this report
		$allIds = array_merge($new_ids, array_keys($existingUpdates));
		$auto_closed_ids = $this->find('list', array(
			'conditions' => array($this->alias.'.id NOT IN' => $allIds),
		));
		
		$this->updateAll(
			array($this->alias.'.auto_closed' => true),
			array($this->alias.'.id' => $auto_closed_ids)
		);
		
		
		$this->updateAll(
			array($this->alias.'.auto_closed' => false),
			array($this->alias.'.id' => $allIds)
		);
		
		return array(
			'new_ids' => $new_ids,
			'updated_ids' => array_keys($existingUpdates),
			'auto_closed_ids' => $auto_closed_ids,
		);
	}
	
	public function scanExcelFile($id = null, $poam_report_filepath = array())
	{
		if(!$id)
		{
			$id = $this->PoamReport->id;
		}
		if(!$id)
		{
			return false;
		}
		
		if(!$poam_report_filepath)
		{
			$poam_report = $this->PoamReport->read(null, $id);
			$poam_report_filepath = $poam_report['PoamReport']['paths']['sys'];
		}
		
		$this->modelError = false;
		if(!$results = $this->Excel_fileToArray($poam_report_filepath))
		{
			if(!$this->modelError)
			{
				$this->modelError = __('An issue occurred when trying to scan the Excel File.');
			}
			return false;
		}
		
		if(!count($results))
			return false;
		
		// fix the dates
		$dateFields = array(
			'identified_in',
			'creation_date',
			'scheduled_completion_date',
			'estimated_completion_date',
			'actual_completion_date',
		);
		
		foreach($results as $i => $result)
		{
			foreach($result as $field => $value)
			{
				// excel date
				if(in_array($field, $dateFields))
				{
					if(strlen($value) == 5)
						$value = $this->Excel_fixDate($value);
					if($value)
						$value = date('Y-m-d 00:00:00', strtotime($value));
					else
						$value = false;
					$results[$i][$field] = $value;
				}
			}
		}
		
		return $results;
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
