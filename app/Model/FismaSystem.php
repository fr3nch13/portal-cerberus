<?php
App::uses('AppModel', 'Model');
/**
 * FismaSystem Model
 *
 * @property Rule $Rule
 */
class FismaSystem extends AppModel 
{

	public $displayField = 'name';

	public $validate = array(
		'name' => array(
			'boolean' => array(
				'rule' => array('notBlank'),
			),
		),
		'pii_count' => array(
			'integer' => array(
				'rule' => '/^[0-9]+$/i',
				'message' => 'Must be an integer',
				'required' => false,
			),
		),
	);
	
	public $hasMany = array(
		'FismaInventory' => array(
			'className' => 'FismaInventory',
			'foreignKey' => 'fisma_system_id',
			'dependent' => true,
		),
		'FismaSystemFile' => array(
			'className' => 'FismaSystemFile',
			'foreignKey' => 'fisma_system_id',
			'dependent' => true,
		),
		/// here to help with the counts on the index page
		'FismaSoftwareFismaSystem' => array(
			'className' => 'FismaSoftwareFismaSystem',
			'foreignKey' => 'fisma_system_id',
			'dependent' => true,
		),
		'AdAccountFismaSystem' => array(
			'className' => 'AdAccountFismaSystem',
			'foreignKey' => 'fisma_system_id',
			'dependent' => true,
		),
		'SrcRule' => array(
			'className' => 'Rule',
			'foreignKey' => 'src_fisma_system_id',
			'dependent' => false,
		),
		'DstRule' => array(
			'className' => 'Rule',
			'foreignKey' => 'dst_fisma_system_id',
			'dependent' => false,
		),
		'UsResult' => array(
			'className' => 'UsResult',
			'foreignKey' => 'fisma_system_id',
			'dependent' => false,
		),
		'EolResult' => array(
			'className' => 'EolResult',
			'foreignKey' => 'fisma_system_id',
			'dependent' => false,
		),
		'PenTestResult' => array(
			'className' => 'PenTestResult',
			'foreignKey' => 'fisma_system_id',
			'dependent' => false,
		),
		'HighRiskResult' => array(
			'className' => 'HighRiskResult',
			'foreignKey' => 'fisma_system_id',
			'dependent' => false,
		),
		'FovResult' => array(
			'className' => 'FovResult',
			'foreignKey' => 'fisma_system_id',
			'dependent' => false,
		),
	);
	
	public $belongsTo = array(
		'FismaAddedUser' => array(
			'className' => 'User',
			'foreignKey' => 'added_user_id',
		),
		'FismaModifiedUser' => array(
			'className' => 'User',
			'foreignKey' => 'modified_user_id',
		),
		'OwnerContact' => array(
			'className' => 'AdAccount',
			'foreignKey' => 'owner_contact_id',
		),
		
		'FismaSystemFipsRating' => array(
			'className' => 'FismaSystemFipsRating',
			'foreignKey' => 'fisma_system_fips_rating_id',
			'plugin_filter' => array(
				'name' => 'FIPS Rating',
			),
			'plugin_snapshot' => true,
		),
		'FismaSystemRiskAssessment' => array(
			'className' => 'FismaSystemRiskAssessment',
			'foreignKey' => 'fisma_system_risk_assessment_id',
			'plugin_filter' => array(
				'name' => 'FO Risk Assessment',
			),
			'plugin_snapshot' => true,
		),
		'FismaSystemThreatAssessment' => array(
			'className' => 'FismaSystemThreatAssessment',
			'foreignKey' => 'fisma_system_threat_assessment_id',
			'plugin_filter' => array(
				'name' => 'FO Threat Assessment',
			),
			'plugin_snapshot' => true,
		),
		'FismaSystemHosting' => array(
			'className' => 'FismaSystemHosting',
			'foreignKey' => 'fisma_system_hosting_id',
			'plugin_filter' => array(
				'name' => 'AHE Hosting',
			),
			'plugin_snapshot' => true,
		),
		'FismaSystemInterconnection' => array(
			'className' => 'FismaSystemInterconnection',
			'foreignKey' => 'fisma_system_interconnection_id',
			'plugin_filter' => array(
				'name' => 'Interconnection',
			),
			'plugin_snapshot' => true,
		),
		'FismaSystemGssStatus' => array(
			'className' => 'FismaSystemGssStatus',
			'foreignKey' => 'fisma_system_gss_status_id',
			'plugin_filter' => array(
				'name' => 'GSS Status',
			),
			'plugin_snapshot' => true,
		),
		'FismaSystemNist' => array(
			'className' => 'FismaSystemNist',
			'foreignKey' => 'fisma_system_nist_id',
			'plugin_filter' => array(
				'name' => 'NIST',
			),
			'plugin_snapshot' => true,
		),
		'FismaSystemLifeSafety' => array(
			'className' => 'FismaSystemLifeSafety',
			'foreignKey' => 'fisma_system_life_safety_id',
			'plugin_batcher' => array(
				'label' => 'Life Safety',
			),
			'plugin_snapshot' => true,
		),
		'FismaSystemAffectedParty' => array(
			'className' => 'FismaSystemAffectedParty',
			'foreignKey' => 'fisma_system_affected_party_id',
			'plugin_batcher' => array(
				'label' => 'Affected Party',
			),
			'plugin_snapshot' => true,
		),
		'FismaSystemCriticality' => array(
			'className' => 'FismaSystemCriticality',
			'foreignKey' => 'fisma_system_criticality_id',
			'plugin_batcher' => array(
				'label' => 'Criticality',
			),
		),
		// from the import sheet
		
		'FismaSystemSensitivityCategory' => array(
			'className' => 'FismaSystemSensitivityCategory',
			'foreignKey' => 'fisma_system_sensitivity_category_id',
			'plugin_batcher' => array(
				'label' => 'Sensitivity Category', // viewable name of the field
			),
			'plugin_snapshot' => true,
		),
		'FismaSystemSensitivityRating' => array(
			'className' => 'FismaSystemSensitivityRating',
			'foreignKey' => 'fisma_system_sensitivity_rating_id',
			'plugin_batcher' => array(
				'label' => 'Sensitivity Rating', // viewable name of the field
			),
			'plugin_snapshot' => true,
		),
		'FismaSystemType' => array(
			'className' => 'FismaSystemType',
			'foreignKey' => 'fisma_system_type_id',
			'plugin_batcher' => array(
				'label' => 'FISMA System Type', // viewable name of the field
			),
			'plugin_snapshot' => true,
		),
		'FismaSystemComTotal' => array(
			'className' => 'FismaSystemComTotal',
			'foreignKey' => 'fisma_system_com_total_id',
			'plugin_batcher' => array(
				'label' => 'Communications Total', // viewable name of the field
			),
			'plugin_snapshot' => true,
		),
		'FismaSystemImpact' => array(
			'className' => 'FismaSystemImpact',
			'foreignKey' => 'fisma_system_impact_id',
			'plugin_batcher' => array(
				'label' => 'Impact', // viewable name of the field
			),
			'plugin_snapshot' => true,
		),
		'FismaSystemUniqueness' => array(
			'className' => 'FismaSystemUniqueness',
			'foreignKey' => 'fisma_system_uniqueness_id',
			'plugin_batcher' => array(
				'label' => 'Uniqueness', // viewable name of the field
			),
			'plugin_snapshot' => true,
		),
		'FismaSystemNihlogin' => array(
			'className' => 'FismaSystemNihlogin',
			'foreignKey' => 'fisma_system_nihlogin_id',
			'plugin_batcher' => array(
				'label' => 'NIH Login', // viewable name of the field
			),
			'plugin_snapshot' => true,
		),
		'FismaSystemAmount' => array(
			'className' => 'FismaSystemAmount',
			'foreignKey' => 'fisma_system_amount_id',
			'plugin_batcher' => array(
				'label' => 'Amount', // viewable name of the field
			),
			'plugin_snapshot' => true,
		),
		'FismaSystemDependency' => array(
			'className' => 'FismaSystemDependency',
			'foreignKey' => 'fisma_system_dependency_id',
			'plugin_batcher' => array(
				'label' => 'Dependency', // viewable name of the field
			),
			'plugin_snapshot' => true,
		),
	);
	
	public $hasAndBelongsToMany = array(
		'FismaSoftware' => array(
			'className' => 'FismaSoftware',
			'joinTable' => 'fisma_softwares_fisma_systems',
			'foreignKey' => 'fisma_system_id',
			'associationForeignKey' => 'fisma_software_id',
			'unique' => 'keepExisting',
			'with' => 'FismaSoftwareFismaSystem',
		),
		'AdAccount' => array(
			'className' => 'AdAccount',
			'joinTable' => 'ad_accounts_fisma_systems',
			'foreignKey' => 'fisma_system_id',
			'associationForeignKey' => 'ad_account_id',
			'unique' => 'keepExisting',
			'with' => 'AdAccountFismaSystem',
		),
		'PhysicalLocation' => array(
			'className' => 'PhysicalLocation',
			'joinTable' => 'fisma_systems_physical_locations',
			'foreignKey' => 'fisma_system_id',
			'associationForeignKey' => 'physical_location_id',
			'unique' => 'keepExisting',
			'with' => 'FismaSystemPhysicalLocation',
		),
	);
	
	public $actsAs = array(
		'ReportsResults',
		'Tags.Taggable',
		'PhpExcel.PhpExcel',
		'Utilities.Family',
		'Batcher.Batcher' => array(
			'fieldMap' => array(
				'FismaSystem.uuid' => array('label' => 'UUID', 'unique' => true),
				'FismaSystem.name' => array('label' => 'Short Name', 'unique' => true),
				'FismaSystem.fullname' => array('label' => 'Name', 'unique' => true),
				// for the selectable field options, see the $belongsTo options for each one above
			),
		),
		'Snapshot.Stat' => array(
			'entities' => array(
				'all' => array(),
				'created' => array(),
				'modified' => array(),
			),
		),
		'Contacts.Contacts',
	);
	
	// define the fields that can be searched
	public $searchFields = array(
		'FismaSystem.uuid',
		'FismaSystem.name',
		'FismaSystem.fullname',
		'FismaSystemFipsRating.name',
		'FismaSystemRiskAssessment.name',
		'FismaSystemThreatAssessment.name',
		'FismaSystemHosting.name',
		'FismaSystemInterconnection.name',
		'FismaSystemGssStatus.name',
		'FismaSystemNist.name',
	);
	
	public $includePrimaryContacts = true;
	
	public function beforeValidate($options = array())
	{
		if(isset($this->data[$this->alias]['pii_count']) and !$this->data[$this->alias]['pii_count'])
			$this->data[$this->alias]['pii_count'] = 0;
		return parent::beforeValidate($options);
	}
	
	public function beforeSave($options = array()) 
	{
		if(AuthComponent::user('id') and !isset($this->data[$this->alias]['modified_user_id']))
			$this->data[$this->alias]['modified_user_id'] = AuthComponent::user('id');
		
		if(isset($this->data[$this->alias]['uuid']))
		{
			$this->data[$this->alias]['uuid'] = trim($this->data[$this->alias]['uuid']);
			$this->data[$this->alias]['uuid'] = strtoupper($this->data[$this->alias]['uuid']);
		}
		
		return parent::beforeSave($options);
	}
	
	public function afterSave($created = false, $options = array())
	{
		// make sure this fisma system is related to fisma software that is marked to be in all systems
		$fismaSoftwares = $this->FismaSoftwareFismaSystem->FismaSoftware->find('list', array(
			'conditions' => array('FismaSoftware.all' => true),
			'fields' => array('FismaSoftware.id', 'FismaSoftware.id'),
		));
		
		if(isset($this->data[$this->alias]['FismaSoftware']) and is_array($this->data[$this->alias]['FismaSoftware']))
		{
			foreach($this->data[$this->alias]['FismaSoftware'] as $fismaSoftwares_id)
			{
				$fismaSoftwares[$fismaSoftwares_id] = $fismaSoftwares_id;
			}
		}
		
		$this->FismaSoftwareFismaSystem->saveAssociatedSoftwares($this->id, $fismaSoftwares);
		
		if($created)
		{
			// for the snapshot plugin
			$this->Usage_updateCounts('fisma_system.created', 'snapshot');
		}
		else
		{
			// for the snapshot plugin
			$this->Usage_updateCounts('fisma_system.modified', 'snapshot');
		}
		
		return parent::afterSave($created, $options);
	}
	
	public function afterFind($results = array(), $primary = false)
	{
		foreach($results as $i => $result)
		{
			if(isset($results[$i]['OwnerContact']) and isset($result[$this->alias]['id']) and !isset($results[$i]['AdAccount']))
			{
				// please keep this as a reference, not a copy
				$results[$i]['AdAccount'] = &$results[$i]['OwnerContact'];
			}
				
			// also include any primary priority contacts
			if($this->includePrimaryContacts and isset($result[$this->alias]['id']))
				$results[$i]['primaryContacts'] = $this->AdAccountFismaSystem->findPrimaryContacts($result[$this->alias]['id']);
			
			if(isset($results[$i][$this->alias]) and array_key_exists('ato_expiration', $results[$i][$this->alias]))
			{
				if($results[$i][$this->alias]['ato_expiration'] == '0000-00-00 00:00:00')
				{
					$results[$i][$this->alias]['ato_expiration'] = null;
				}
				else
				{
					$expTime = strtotime($results[$i][$this->alias]['ato_expiration']);
					if($expTime < 18000)
						$results[$i][$this->alias]['ato_expiration'] = null;
					elseif($expTime == 18000)
						$results[$i][$this->alias]['ato_expiration'] = false;
				}
			}
		}
		
		return parent::afterFind($results, $primary);
	}
	
	public function customTypeFormList()
	{
		$this->displayField = 'name';
		
		return $this->typeFormList();
	}
	
	public function importUpdateSystems($data = array())
	{
		if(!isset($data[$this->alias]['file']))
		{
			$this->modelError = __('Unknown Excel File (1).');
			return false;
		}
		if(!isset($data[$this->alias]['file']['error']))
		{
			$this->modelError = __('Unknown Excel File (2).');
			return false;
		}
		if(!isset($data[$this->alias]['file']['tmp_name']))
		{
			$this->modelError = __('Unknown Excel File (3).');
			return false;
		}
		if($data[$this->alias]['file']['error'] != '0')
		{
			$this->modelError = __('Error uploading the file.');
			return false;
		}
		
		// scan the file
		$results = $this->scanExcelFile($data[$this->alias]['file']['tmp_name']);
		if(!$results)
		{
			$error = __('No Results were found in the Excel File. (%s)', 1);
			if(!$this->modelError) $this->modelError = $error;
			return false;
		}
		
		$new_results = array();
		
		// clean up any empty rows
		// I didn't want to put it in the behavior incase the blank rows mean something somewhere else
		foreach($results as $i => $result)
		{
			$keep = false;
			foreach($result as $j => $cell)
				if($cell)
					$keep = true;
			if(!$keep)
			{
				unset($results[$i]);
				continue;
			}
			else
			{
				foreach($result as $j => $cell)
				{
					if(stripos($j, '_1_'))
					{
						$j_old = $j;
						$j = explode('_1_', $j);
						$j = array_shift($j);
						$results[$i][$j] = $cell;
						unset($results[$i][$j_old]);
					}
				}
			}
		}
		
		foreach($results as $i => $result)
		{
			$new_result = array();
			
			// see if this fisma system already exists
			if(isset($result['abv']) and $result['abv'])
			{
				if($id = $this->field('id', array('name' => $result['abv'])))
				{
					$new_result['id'] = $id;
				}
				else
				{
					$new_result['name'] = $result['abv'];
				}
			}
			
			if(isset($result['system_name']) and $result['system_name'])
			{
				if(isset($new_result['name']))
					$new_result['full_name'] = $result['system_name'];
			}
			
			// the new fields
			if(isset($result['opdiv']) and $result['opdiv'])
				$new_result['opdiv'] = $result['opdiv'];
			
			if(isset($result['uuid']) and $result['uuid'])
				$new_result['uuid'] = $result['uuid'];
			
			if(isset($result['comments']) and $result['comments'])
				$new_result['comments'] = $result['comments'];
			
			// the new tables
			if(isset($result['system_type']) and $result['system_type'])
				$new_result['fisma_system_type_id'] = $this->FismaSystemType->checkAdd($result['system_type']);
			
			// the new tables with ratings
			if(isset($result['sensitivity_category_type']) and $result['sensitivity_category_type'])
			{
				$extra = array();
				if($int = intval($result['sensitivity_category_type']))
				{
					$extra['rating'] = $int;
				}
				$new_result['fisma_system_sensitivity_category_id'] = $this->FismaSystemSensitivityCategory->checkAdd($result['sensitivity_category_type'], $extra);
			}
			
			if(isset($result['sensitivity_rating']) and $result['sensitivity_rating'])
			{
				$extra = array();
				if($int = intval($result['sensitivity_rating']))
				{
					$extra['rating'] = $int;
				}
				$new_result['fisma_system_sensitivity_rating_id'] = $this->FismaSystemSensitivityRating->checkAdd($result['sensitivity_rating'], $extra);
			}
			
			if(isset($result['amount']) and $result['amount'])
			{
				$extra = array();
				if($int = intval($result['amount']))
				{
					$extra['rating'] = $int;
				}
				$new_result['fisma_system_amount_id'] = $this->FismaSystemAmount->checkAdd($result['amount'], $extra);
			}
			
			if(isset($result['uniqueness']) and $result['uniqueness'])
			{
				$extra = array();
				if($int = intval($result['uniqueness']))
				{
					$extra['rating'] = $int;
				}
				$new_result['fisma_system_uniqueness_id'] = $this->FismaSystemUniqueness->checkAdd($result['uniqueness'], $extra);
			}
			
			if(isset($result['impact']) and $result['impact'])
			{
				$extra = array();
				if($int = intval($result['impact']))
				{
					$extra['rating'] = $int;
				}
				$new_result['fisma_system_impact_id'] = $this->FismaSystemImpact->checkAdd($result['impact'], $extra);
			}
			
			if(isset($result['dependencies']) and $result['dependencies'])
			{
				$extra = array();
				if($int = intval($result['dependencies']))
				{
					$extra['rating'] = $int;
				}
				$new_result['fisma_system_dependency_id'] = $this->FismaSystemDependency->checkAdd($result['dependencies'], $extra);
			}
			
			if(isset($result['communication_total_of']) and $result['communication_total_of'])
			{
				$extra = array();
				if($int = intval($result['communication_total_of']))
				{
					$extra['rating'] = $int;
				}
				$new_result['fisma_system_com_total_id'] = $this->FismaSystemComTotal->checkAdd($result['communication_total_of'], $extra);
			}
			
			if(isset($result['attractiveness']) and $result['attractiveness'])
			{
				$extra = array();
				if($int = intval($result['attractiveness']))
				{
					$extra['rating'] = $int;
				}
				$new_result['fisma_system_threat_assessment_id'] = $this->FismaSystemThreatAssessment->checkAdd($result['attractiveness'], $extra);
			}
			
			if($new_result)
				$new_results[] = $new_result;
		}
		
		$counts = array('added' => 0, 'updated' => 0);
		foreach($new_results as $new_result)
		{
			if(isset($new_result['id']))
			{
				$this->id = $new_result['id'];
				$new_result['modified_user_id'] = AuthComponent::user('id');
				$new_result['modified'] = date('Y-m-d H:i:s');
			}
			else
			{
				$this->create();
				$new_result['added_user_id'] = AuthComponent::user('id');
				$new_result['created'] = date('Y-m-d H:i:s');
			}
			if($this->save($new_result))
			{
				if(isset($new_result['id'])) 
					$counts['updated']++;
				else
					$counts['added']++;
			}
		}
		return $counts;
	}
	
	public function scanExcelFile($file_path = false)
	{
		if(!$file_path)
		{
			return false;
		}
		
		$this->modelError = false;
		if(!$results = $this->Excel_fileToArray($file_path))
		{
			if($this->modelError)
			{
				$this->modelError = __('An issue occurred when trying to scan the Excel file.');
			}
			return false;
		}
		return $results;
	}
	
	public function getIdsFromUuids($uuids = array(), $field = 'id')
	{
		if(!is_array($uuids))
			return array();
		if(!$uuids)
			return array();
		
		$uuids = array_flip($uuids);
		$uuids = array_flip($uuids);
		$uuids = array_map("strtoupper", $uuids);
		
		return $this->find('list', array(
			'conditions' => array($this->alias.'.uuid' => $uuids),
			'fields' => array($this->alias.'.uuid', $this->alias.'.'.$field)
		));
	}
	
	public function idsForOrg($org_id = false, $fismaSystemConditions = array())
	{
		if(!$divisionIds = $this->OwnerContact->Sac->Branch->Division->idsForOrg($org_id)) { return array(); }
		
		return $this->idsForDivision($divisionIds, $fismaSystemConditions);
	}
	
	public function idsForDivision($division_id = false, $fismaSystemConditions = array())
	{
		if(!$branchIds = $this->OwnerContact->Sac->Branch->idsForDivision($division_id)) { return array(); }
		
		return $this->idsForBranch($branchIds, $fismaSystemConditions);
	}
	
	public function idsForBranch($branch_id = false, $fismaSystemConditions = array())
	{
		if(!$sacIds = $this->OwnerContact->Sac->idsForBranch($branch_id)) { return array(); }
		
		return $this->idsForSac($sacIds, $fismaSystemConditions);
	}
	
	public function idsForSac($sac_id = false, $fismaSystemConditions = array())
	{
		if(!$adAccountIds = $this->OwnerContact->idsForSac($sac_id)) { return array(); }
		
		return $this->idsForOwnerContact($adAccountIds, $fismaSystemConditions);
	}
	
	public function idsForOwnerContact($owner_contact_id = false, $fismaSystemConditions = array())
	{
		if(!$fismaSystemConditions)
			$fismaSystemConditions = array();
		$conditions = array_merge($fismaSystemConditions, array(
			$this->alias.'.owner_contact_id' => $owner_contact_id,
		));
		if(!$contactIds = $this->find('list', array(
			'conditions' => $conditions,
			'fields' => array($this->alias.'.id', $this->alias.'.id'),
		))) { return array(); }
		
		return $contactIds;
	}
	
	public function idsForCrm($crm_id = false)
	{
		$fisma_system_ids = array();
		
		// org ids for this crm
		$org_ids = $this->OwnerContact->Sac->Branch->Division->Org->idsForCrm($crm_id);
		if($org_ids)
		{
			$new_ids = $this->idsForOrg($org_ids);
			$fisma_system_ids = $fisma_system_ids + $new_ids;
		}
		
		$division_ids = $this->OwnerContact->Sac->Branch->Division->idsForCrm($crm_id);
		if($division_ids)
		{
			$new_ids = $this->idsForDivision($division_ids);
			$fisma_system_ids = $fisma_system_ids + $new_ids;
		}
		$branch_ids = $this->OwnerContact->Sac->Branch->idsForCrm($crm_id);
		if($branch_ids)
		{
			$new_ids = $this->idsForBranch($branch_ids);
			$fisma_system_ids = $fisma_system_ids + $new_ids;
		}
		$sac_ids = $this->OwnerContact->Sac->idsForCrm($crm_id);
		if($sac_ids)
		{
			$new_ids = $this->idsForSac($sac_ids);
			$fisma_system_ids = $fisma_system_ids + $new_ids;
		}
		
		return $fisma_system_ids;
	}
	
	public function idsForContactType($ad_account_id = false, $fismaContactType_id = false)
	{
		$conditions = array(
			'AdAccountFismaSystem.ad_account_id' => $ad_account_id,
		);
		
		if($fismaContactType_id)
		{
			$conditions['AdAccountFismaSystem.fisma_contact_type_id'] = $fismaContactType_id;
		}
		
		$fismaSystem_ids = $this->AdAccountFismaSystem->find('list', array(
			'conditions' => $conditions,
			'fields' => array('AdAccountFismaSystem.fisma_system_id', 'AdAccountFismaSystem.fisma_system_id'),
		));
		return $fismaSystem_ids;
	}
	
	public function getCrm($crm_id = false)
	{
		if(!$crm_id)
			$crm_id = AuthComponent::user('ad_account_id');
		
		if (!$crm_id) 
		{
			throw new NotFoundException(__('Invalid %s', __('CRM')));
		}
		
		$crm = $this->OwnerContact->find('first', array(
			'conditions' => array('OwnerContact.id' => $crm_id),
			'contain' => array('Sac', 'Sac.Branch', 'Sac.Branch.Division', 'Sac.Branch.Division.Org'),
		));
		if (!$crm) 
		{
			throw new NotFoundException(__('Invalid %s', __('CRM')));
		}
		$crm['AdAccount'] = $crm['OwnerContact'];
		return $crm;
	}
	
	public function getCrms()
	{
		$crms = array();
		
		$thisCrms = $this->OwnerContact->Sac->Branch->Division->Org->find('list', array(
			'conditions' => array('Org.crm_id >' => 0),
			'contain' => array('OrgCrm'),
			'fields' => array('OrgCrm.id', 'OrgCrm.name'),
		));
		$crms = $crms + $thisCrms;
		
		$thisCrms = $this->OwnerContact->Sac->Branch->Division->find('list', array(
			'conditions' => array('Division.crm_id >' => 0),
			'contain' => array('DivisionCrm'),
			'fields' => array('DivisionCrm.id', 'DivisionCrm.name'),
		));
		$crms = $crms + $thisCrms;
		
		$thisCrms = $this->OwnerContact->Sac->Branch->find('list', array(
			'conditions' => array('Branch.crm_id >' => 0),
			'contain' => array('BranchCrm'),
			'fields' => array('BranchCrm.id', 'BranchCrm.name'),
		));
		$crms = $crms + $thisCrms;
		
		$thisCrms = $this->OwnerContact->Sac->find('list', array(
			'conditions' => array('Sac.crm_id >' => 0),
			'contain' => array('SacCrm'),
			'fields' => array('SacCrm.id', 'SacCrm.name'),
		));
		$crms = $crms + $thisCrms;
		
		return $crms;
	}
	
	public function idsForDirector($director_id = false)
	{
		$fisma_system_ids = array();
		
		// org ids for this director
		$org_ids = $this->OwnerContact->Sac->Branch->Division->Org->idsForDirector($director_id);
		if($org_ids)
		{
			$new_ids = $this->idsForOrg($org_ids);
			$fisma_system_ids = $fisma_system_ids + $new_ids;
		}
		
		$division_ids = $this->OwnerContact->Sac->Branch->Division->idsForDirector($director_id);
		if($division_ids)
		{
			$new_ids = $this->idsForDivision($division_ids);
			$fisma_system_ids = $fisma_system_ids + $new_ids;
		}
		$branch_ids = $this->OwnerContact->Sac->Branch->idsForDirector($director_id);
		if($branch_ids)
		{
			$new_ids = $this->idsForBranch($branch_ids);
			$fisma_system_ids = $fisma_system_ids + $new_ids;
		}
		$sac_ids = $this->OwnerContact->Sac->idsForDirector($director_id);
		if($sac_ids)
		{
			$new_ids = $this->idsForSac($sac_ids);
			$fisma_system_ids = $fisma_system_ids + $new_ids;
		}
		
		return $fisma_system_ids;
	}
	
	public function getDirector($director_id = false)
	{
		if(!$director_id)
			$director_id = AuthComponent::user('ad_account_id');
		
		if (!$director_id) 
		{
			throw new NotFoundException(__('Invalid %s', __('CRM')));
		}
		
		$director = $this->OwnerContact->find('first', array(
			'conditions' => array('OwnerContact.id' => $director_id),
			'contain' => array('Sac', 'Sac.Branch', 'Sac.Branch.Division', 'Sac.Branch.Division.Org'),
		));
		if (!$director) 
		{
			throw new NotFoundException(__('Invalid %s', __('CRM')));
		}
		$director['AdAccount'] = $director['OwnerContact'];
		return $director;
	}
	
	public function getDirectors($type = false, $fismaSystem_ids = false)
	{
		$directors = array();
		
		if(!$type or $type == 'Org')
		{
			$conditions = array('Org.director_id >' => 0);
			$orgDirectors = $this->OwnerContact->Sac->Branch->Division->Org->find('list', array(
				'conditions' => array('Org.director_id >' => 0),
				'contain' => array('OrgDirector'),
				'fields' => array('OrgDirector.id', 'OrgDirector.name'),
			));
			$directors = $directors + $orgDirectors;
		}
		if(!$type or $type == 'Division')
		{
			$divisionDirectors = $this->OwnerContact->Sac->Branch->Division->find('list', array(
				'conditions' => array('Division.director_id >' => 0),
				'contain' => array('DivisionDirector'),
				'fields' => array('DivisionDirector.id', 'DivisionDirector.name'),
			));
			$directors = $directors + $divisionDirectors;
		}
		if(!$type or $type == 'Branch')
		{
			$branchDirectors = $this->OwnerContact->Sac->Branch->find('list', array(
				'conditions' => array('Branch.director_id >' => 0),
				'contain' => array('BranchDirector'),
				'fields' => array('BranchDirector.id', 'BranchDirector.name'),
			));
			$directors = $directors + $branchDirectors;
		}
		if(!$type or $type == 'Sac')
		{
			$sacDirectors = $this->OwnerContact->Sac->find('list', array(
				'conditions' => array('Sac.director_id >' => 0),
				'contain' => array('SacDirector'),
				'fields' => array('SacDirector.id', 'SacDirector.name'),
			));
			$directors = $directors + $sacDirectors;
		}
		
		return $directors;
	}
	
	public function getDirectorOwners($director_id = false)
	{
		if(!$director_id)
			$director_id = AuthComponent::user('ad_account_id');
		
		if (!$director_id) 
		{
			throw new NotFoundException(__('Invalid %s', __('Director')));
		}
		
		$this->includePrimaryContacts = false;
		$owner_ids = $this->find('list', array(
			'conditions' => array(
				'FismaSystem.id' => $this->idsForDirector($director_id),
			),
			'fields' => array('FismaSystem.owner_contact_id', 'FismaSystem.owner_contact_id'),
			
		));
		
		$owners = $this->OwnerContact->find('list', array(
			'conditions' => array('OwnerContact.id' => $owner_ids),
			'fields' => array('OwnerContact.id', 'OwnerContact.name'),
			'order' => array('OwnerContact.username' => 'ASC'),
		));
		return $owners;
	}
	
	public function getOwner($owner_id = false)
	{
		if(!$owner_id)
			$owner_id = AuthComponent::user('ad_account_id');
		
		if (!$owner_id) 
		{
			throw new NotFoundException(__('Invalid %s', __('System Owner')));
		}
		
		$owner = $this->OwnerContact->find('first', array(
			'conditions' => array('OwnerContact.id' => $owner_id),
			'contain' => array('AdAccountDetail', 'Sac', 'Sac.Branch', 'Sac.Branch.Division', 'Sac.Branch.Division.Org'),
		));
		if (!$owner) 
		{
			throw new NotFoundException(__('Invalid %s', __('System Owner')));
		}
		$owner['AdAccount'] = $owner['OwnerContact'];
		return $owner;
	}
	
	public function getOwners($onlyResolved = false)
	{
		$this->recursive = -1;
		$owner_ids = $this->find('list', array(
			'recursive' => -1,
			'contain' => array('OwnerContact'),
			'conditions' => array(
				$this->alias.'.owner_contact_id > ' => 0,
			),
			'fields' => array($this->alias.'.id', $this->alias.'.owner_contact_id'),
			'order' => array($this->alias.'.owner_contact_id' => 'ASC'),
			'callbacks' => false
		));
		
		if($onlyResolved)
		{
			foreach($owner_ids as $fismaSystem_id => $ownerContact_id)
			{
				$eolCount = $this->requestAction(array('controller' => 'eol_results', 'action' => 'actionable', $fismaSystem_id, $ownerContact_id, 'getcount' => true, 'owner' => true));
				if(is_array($eolCount)) $eolCount = count($eolCount);
				$ptCount = $this->requestAction(array('controller' => 'pen_test_results', 'action' => 'actionable', $fismaSystem_id, $ownerContact_id, 'getcount' => true, 'owner' => true));
				if(is_array($ptCount)) $ptCount = count($ptCount);
				$hrCount = $this->requestAction(array('controller' => 'high_risk_results', 'action' => 'actionable', $fismaSystem_id, $ownerContact_id, 'getcount' => true, 'owner' => true));
				if(is_array($hrCount)) $hrCount = count($hrCount);
				
				if(!$eolCount and !$ptCount and !$hrCount)
					unset($owner_ids[$fismaSystem_id]);
			}
		}
		
		$owners = $this->OwnerContact->find('list', array(
			'conditions' => array('OwnerContact.id' => $owner_ids),
			'fields' => array('OwnerContact.id', 'OwnerContact.name'),
			'order' => array('OwnerContact.username' => 'ASC'),
		));
		
		return $owners;
	}
	
	public function getCrmOwners($crm_id = false)
	{
		if(!$crm_id)
			$crm_id = AuthComponent::user('ad_account_id');
		
		if (!$crm_id) 
		{
			throw new NotFoundException(__('Invalid %s', __('CRM')));
		}
		
		$this->includePrimaryContacts = false;
		$owner_ids = $this->find('list', array(
			'conditions' => array(
				'FismaSystem.id' => $this->idsForCrm($crm_id),
			),
			'fields' => array('FismaSystem.owner_contact_id', 'FismaSystem.owner_contact_id'),
			
		));
		
		$owners = $this->OwnerContact->find('list', array(
			'conditions' => array('OwnerContact.id' => $owner_ids),
			'fields' => array('OwnerContact.id', 'OwnerContact.name'),
			'order' => array('OwnerContact.username' => 'ASC'),
		));
		return $owners;
	}
	
	public function getPocs($fismaContactType_id = false)
	{
		$conditions = array();
		
		if($fismaContactType_id)
		{
			$conditions['AdAccountFismaSystem.fisma_contact_type_id'] = $fismaContactType_id;
		}
		
		$adAccounts = array();
		if($adAccount_ids = $this->AdAccountFismaSystem->find('list', array(
			'conditions' => $conditions,
			'fields' => array('AdAccountFismaSystem.ad_account_id', 'AdAccountFismaSystem.ad_account_id'),
		)))
		{
			$adAccounts = $this->AdAccountFismaSystem->AdAccount->find('list', array(
				'conditions' => array('AdAccount.id' => $adAccount_ids),
				'fields' => array('AdAccount.id', 'AdAccount.name'),
				'order' => array('AdAccount.username' => 'ASC'),
			));
		}
		return $adAccounts;
	}
	
	public function getRelatedIpAddresses($fismaSystemId = false)
	{
		if(is_array($fismaSystemId) and count($fismaSystemId) == 1)
			$fismaSystemId = array_pop($fismaSystemId);
		
		$results = $this->FismaInventory->getCachedCounts('list', array(
			'conditions' => array(
				'FismaInventory.fisma_system_id' => $fismaSystemId,
				'FismaInventory.ip_address !=' => '',
				'FismaInventory.ip_address NOT IN' => array('TBD', 'NA', 'N/A'),
			),
			'fields' => array('FismaInventory.ip_address', 'FismaInventory.ip_address'),
		));
		if(!$results)
			$results = array();
		return $results;
	}
	
	public function getRelatedHostNames($fismaSystemId = false)
	{
		if(is_array($fismaSystemId) and count($fismaSystemId) == 1)
			$fismaSystemId = array_pop($fismaSystemId);
		
		$results = $this->FismaInventory->getCachedCounts('list', array(
			'conditions' => array(
				'FismaInventory.fisma_system_id' => $fismaSystemId,
				'FismaInventory.dns_name !=' => '',
				'FismaInventory.dns_name NOT IN' => array('TBD', 'NA', 'N/A'),
			),
			'fields' => array('FismaInventory.dns_name', 'FismaInventory.dns_name'),
		));
		if(!$results)
			$results = array();
		return $results;
	}
	
	public function getRelatedMacAddresses($fismaSystemId = false)
	{
		if(is_array($fismaSystemId) and count($fismaSystemId) == 1)
			$fismaSystemId = array_pop($fismaSystemId);
		
		$results = $this->FismaInventory->getCachedCounts('list', array(
			'conditions' => array(
				'FismaInventory.fisma_system_id' => $fismaSystemId,
				'FismaInventory.mac_address !=' => '',
				'FismaInventory.mac_address NOT IN' => array('TBD', 'NA', 'N/A'),
			),
			'fields' => array('FismaInventory.mac_address', 'FismaInventory.mac_address'),
		));
		if(!$results)
			$results = array();
		return $results;
	}
	
	public function getRelatedAssetTags($fismaSystemId = false)
	{
		if(is_array($fismaSystemId) and count($fismaSystemId) == 1)
			$fismaSystemId = array_pop($fismaSystemId);
		
		$results = $this->FismaInventory->getCachedCounts('list', array(
			'conditions' => array(
				'FismaInventory.fisma_system_id' => $fismaSystemId,
				'FismaInventory.asset_tag !=' => '',
				'FismaInventory.asset_tag NOT IN' => array('TBD', 'NA', 'N/A'),
			),
			'fields' => array('FismaInventory.asset_tag', 'FismaInventory.asset_tag'),
		));
		if(!$results)
			$results = array();
		return $results;
	}
	
	public function getSystemsFromIps($ip_addresses = [], $criteria = [])
	{
		if(!$ip_addresses)
			return [];
		
		$fismaSystemIds = $this->FismaInventory->find('list', [
			'recursive' => -1,
			'fields' => ['FismaInventory.fisma_system_id', 'FismaInventory.fisma_system_id'],
			'conditions' => ['FismaInventory.ip_address' => $ip_addresses]
		]);
		
		if(!$fismaSystemIds)
			return [];
		
		$includePrimaryContacts = $this->includePrimaryContacts;
		$this->includePrimaryContacts = false;
		
		$defaultCriteria = [
			'recursive' => -1,
			'conditions' => [$this->alias.'.id' => $fismaSystemIds]
		];
		
		$criteria = array_merge($defaultCriteria, $criteria);
		
		$fismaSystems = $this->find('all', $criteria);
		
		$this->includePrimaryContacts = $includePrimaryContacts;
		return $fismaSystems;
	}
	
	public function getPiiCount($fismaSystemId = false)
	{
		if($piiCount = $this->field('pii_count', array($this->alias.'.'.$this->primaryKey => $fismaSystemId)))
		{
			return $piiCount;
		}
		return 0;
	}
	
	public function getInventoryCount($fismaSystemId = false)
	{
		if($count = $this->FismaInventory->getCachedCounts('count', array('conditions' => array('FismaInventory.fisma_system_id' => $fismaSystemId))))
		{
			return $count;
		}
		return 0;
	}
	
	public function getSoftwareCount($fismaSystemId = false)
	{
		if($count = $this->FismaSoftwareFismaSystem->getCachedCounts('count', array('conditions' => array('FismaSoftwareFismaSystem.fisma_system_id' => $fismaSystemId))))
		{
			return $count;
		}
		return 0;
	}
	
	public function getSrcRuleCount($fismaSystemId = false)
	{
		if($count = $this->SrcRule->getCachedCounts('count', array('conditions' => array('SrcRule.src_fisma_system_id' => $fismaSystemId))))
		{
			return $count;
		}
		return 0;
	}
	
	public function _buildIndexConditions($contact_ids = array(), $contact_type = false)
	{
		$conditions = array();
		$conditions[$this->alias.'.owner_contact_id'] = $contact_ids;
		return $conditions;
	}
	
	public function snapshotStats()
	{
		$entities = $this->Snapshot_dynamicEntities();
		return array();
	}
	
	public function cron_copyToContacts()
	{
	/* Full copying of Systems and Inventory to the Contacts database */
		$this->shellOut(__('Copying %s and %s to the Contacts database.', __('FISMA Systems'), __('FISMA Inventories')));
		
		$this->instanceCheck();
		
		$fismaSystems = $this->find('all', ['recursive' => -1]);
		
		$this->shellOut(__('Found %s %s to add/update.', count($fismaSystems), __('FISMA Systems')));
		foreach($fismaSystems as $fismaSystem)
		{
			$this->OwnerContact->ContactsFismaSystem->updateRecord($fismaSystem[$this->alias]);
		}
		$this->shellOut(__('Finished adding/updating %s.', __('FISMA Systems')));
		
		$fismaInventories = $this->FismaInventory->find('all', ['recursive' => -1]);
		
		$this->shellOut(__('Found %s %s to add/update.', count($fismaInventories), __('FISMA Inventories')));
		foreach($fismaInventories as $fismaInventory)
		{
			$this->OwnerContact->ContactsFismaSystem->ContactsFismaInventory->updateRecord($fismaInventory[$this->FismaInventory->alias]);
		}
		$this->shellOut(__('Finished adding/updating %s.', __('FISMA Inventories')));
	}
	
	public function cron_updateToContacts()
	{
	/* Incremental copying of Systems and Inventory to the Contacts database */
		$this->shellOut(__('Updating %s and %s to the Contacts database.', __('FISMA Systems'), __('FISMA Inventories')));
		
		$this->instanceCheck();
		
		$fismaSystems = $this->find('all', ['recursive' => -1]);
		
		$this->shellOut(__('Found %s %s to check/add/update.', count($fismaSystems), __('FISMA Systems')));
		$updated = 0;
		foreach($fismaSystems as $fismaSystem)
		{
			if($this->OwnerContact->ContactsFismaSystem->updateRecord($fismaSystem[$this->alias], true))
			{
				$updated++;
			}
		}
		$this->shellOut(__('Finished adding/updating %s. %s were added/updated.', __('FISMA Systems'), $updated));
		
		$fismaInventories = $this->FismaInventory->find('all', ['recursive' => -1]);
		
		$this->shellOut(__('Found %s %s to check/add/update.', count($fismaInventories), __('FISMA Inventories')));
		$updated = 0;
		foreach($fismaInventories as $fismaInventory)
		{
			if($this->OwnerContact->ContactsFismaSystem->ContactsFismaInventory->updateRecord($fismaInventory[$this->FismaInventory->alias], true))
			{
				$updated++;
			}
		}
		$this->shellOut(__('Finished adding/updating %s. %s were added/updated.', __('FISMA Inventories'), $updated));
	}
	
	public function cron_removefromContacts()
	{
	/* finds all systems/inventory in contacts that are no longer in cerberus, and removes them*/
		
		$this->shellOut(__('Removing deleted %s and %s from the Contacts database.', __('FISMA Systems'), __('FISMA Inventories')));
		
		$this->instanceCheck();
		
		$fismaSystem_ids = $this->find('list', [
			'fields' => [$this->alias.'.'.$this->primaryKey, $this->alias.'.'.$this->primaryKey],
			'order' => [$this->alias.'.'.$this->primaryKey => 'ASC'],
		]);
		
		$contactsFismaSystem_ids = $this->OwnerContact->ContactsFismaSystem->find('list', [
			'fields' => [$this->OwnerContact->ContactsFismaSystem->alias.'.'.$this->OwnerContact->ContactsFismaSystem->primaryKey, $this->OwnerContact->ContactsFismaSystem->alias.'.'.$this->OwnerContact->ContactsFismaSystem->primaryKey],
			'order' => [$this->OwnerContact->ContactsFismaSystem->alias.'.'.$this->OwnerContact->ContactsFismaSystem->primaryKey => 'ASC'],
		]);
		
		$removeIds = [];
		foreach($contactsFismaSystem_ids as $contactsFismaSystem_id)
		{
			if(!isset($fismaSystem_ids[$contactsFismaSystem_id]))
				$removeIds[$contactsFismaSystem_id] = $contactsFismaSystem_id;
		}
		
		if($removeIds)
		{
			$this->shellOut(__('Found %s %s to be deleted', count($removeIds), __('FISMA Systems')));
			$this->OwnerContact->ContactsFismaSystem->deleteAll([
				$this->OwnerContact->ContactsFismaSystem->alias.'.'.$this->OwnerContact->ContactsFismaSystem->primaryKey => $removeIds
			], false);
		}
		else
		{
			$this->shellOut(__('No %s need to be deleted.', __('FISMA Systems')));
		}
		
		$fismaInventory_ids = $this->FismaInventory->find('list', [
			'fields' => [$this->FismaInventory->alias.'.'.$this->FismaInventory->primaryKey, $this->FismaInventory->alias.'.'.$this->FismaInventory->primaryKey],
			'order' => [$this->FismaInventory->alias.'.'.$this->FismaInventory->primaryKey => 'ASC'],
		]);
		
		$contactsFismaInventory_ids = $this->OwnerContact->ContactsFismaSystem->ContactsFismaInventory->find('list', [
			'fields' => [$this->OwnerContact->ContactsFismaSystem->ContactsFismaInventory->alias.'.'.$this->OwnerContact->ContactsFismaSystem->ContactsFismaInventory->primaryKey, $this->OwnerContact->ContactsFismaSystem->ContactsFismaInventory->alias.'.'.$this->OwnerContact->ContactsFismaSystem->ContactsFismaInventory->primaryKey],
			'order' => [$this->OwnerContact->ContactsFismaSystem->ContactsFismaInventory->alias.'.'.$this->OwnerContact->ContactsFismaSystem->ContactsFismaInventory->primaryKey => 'ASC'],
		]);
		
		$removeIds = [];
		foreach($contactsFismaInventory_ids as $contactsFismaInventory_id)
		{
			if(!isset($fismaInventory_ids[$contactsFismaInventory_id]))
				$removeIds[$contactsFismaInventory_id] = $contactsFismaInventory_id;
		}
		
		if($removeIds)
		{
			$this->shellOut(__('Found %s %s to be deleted', count($removeIds), __('FISMA Inventories')));
			$this->OwnerContact->ContactsFismaSystem->ContactsFismaInventory->deleteAll([
				$this->OwnerContact->ContactsFismaSystem->ContactsFismaInventory->alias.'.'.$this->OwnerContact->ContactsFismaSystem->ContactsFismaInventory->primaryKey => $removeIds
			], false);
		}
		else
		{
			$this->shellOut(__('No %s need to be deleted.', __('FISMA Inventories')));
		}
	}
	
	public function instanceCheck()
	{
		// check the ContactsFismaSystem
		if($this->OwnerContact->ContactsFismaSystem instanceof AppModel)
		{
			App::uses('ContactsFismaSystem', 'Contacts.Model');
			$this->OwnerContact->ContactsFismaSystem = new ContactsFismaSystem();
		}
		// check the ContactsFismaSystem
		if($this->OwnerContact->ContactsFismaSystem->ContactsFismaInventory instanceof AppModel)
		{
			App::uses('ContactsFismaInventory', 'Contacts.Model');
			$this->OwnerContact->ContactsFismaSystem->ContactsFismaInventory = new ContactsFismaInventory();
		}
	}
}
