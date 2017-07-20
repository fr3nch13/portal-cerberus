<?php
App::uses('AppModel', 'Model');

class EolSoftware extends AppModel 
{
	public $displayField = 'name';
	
	public $virtualFields = array(
		'key_name' => 'CONCAT(EolSoftware.key, "/", EolSoftware.name)',
	);
	
	public $belongsTo = array(
		'ReportsRemediationUser' => array(
			'className' => 'User',
			'foreignKey' => 'remediation_user_id',
		),
		'ReportsVerificationUser' => array(
			'className' => 'User',
			'foreignKey' => 'verification_user_id',
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
	);
	
	public $hasMany = array(
		'UsResultLog' => array(
			'className' => 'UsResultLog',
			'foreignKey' => 'eol_software_id',
			'dependent' => true,
		),
		'UsResult' => array(
			'className' => 'UsResult',
			'foreignKey' => 'eol_software_id',
			'dependent' => true,
		),
		'EolResultLog' => array(
			'className' => 'EolResultLog',
			'foreignKey' => 'eol_software_id',
			'dependent' => true,
		),
		'EolResult' => array(
			'className' => 'EolResult',
			'foreignKey' => 'eol_software_id',
			'dependent' => true,
		),
		'HighRiskResultLog' => array(
			'className' => 'HighRiskResultLog',
			'foreignKey' => 'eol_software_id',
			'dependent' => true,
		),
		'HighRiskResult' => array(
			'className' => 'HighRiskResult',
			'foreignKey' => 'eol_software_id',
			'dependent' => true,
		),
		'PenTestResultLog' => array(
			'className' => 'PenTestResultLog',
			'foreignKey' => 'eol_software_id',
			'dependent' => true,
		),
		'PenTestResult' => array(
			'className' => 'PenTestResult',
			'foreignKey' => 'eol_software_id',
			'dependent' => true,
		),
		'EolSoftwareAlias' => array(
			'className' => 'EolSoftwareAlias',
			'foreignKey' => 'eol_software_id',
			'dependent' => true,
		),
	);
	
	public $actsAs = array(
		'ReportsResults',
		'Tags.Taggable',
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
		'EolSoftware.id',
		'EolSoftware.key',
		'EolSoftware.name',
		'EolSoftware.tickets',
		'EolSoftware.waiver',
	);
	
	public $checkAddCache = array();
	
	public function afterSave($created = false, $options = array())
	{	
		$this->updateUsResultCounterCache($this->id, $this->data);
		
		return parent::afterSave($created, $options);
	}
	
	public function updateUsResultCounterCache($id = false, $data = array())
	{
		// update the caching on the us results
		// these 'counter-caches' are used to keep usage counts in line
		// and can also be used for the US Result Dashboard
		if($id and isset($data[$this->alias]))
		{
			$usResultData = array();
			if(isset($data[$this->alias]['reports_assignable_party_id']))
				$usResultData['reports_assignable_party_id'] = $data[$this->alias]['reports_assignable_party_id'];
			if(isset($data[$this->alias]['reports_remediation_id']))
				$usResultData['reports_remediation_id'] = $data[$this->alias]['reports_remediation_id'];
			if(isset($data[$this->alias]['reports_verification_id']))
				$usResultData['reports_verification_id'] = $data[$this->alias]['reports_verification_id'];
			
			if($usResultData)
			{
				$this->UsResult->updateAll(
					$usResultData,
					array('UsResult.eol_software_id' => $id)
				);
			}
		}
		// this should only run on an import, and we will update all of the counter caches for the software
		else
		{
			$softwares = $this->find('all', array('recursive' => -1));
			foreach($softwares as $data)
			{
				$id = $data[$this->alias]['id'];
				$usResultData = array();
				
				if(isset($data[$this->alias]['reports_assignable_party_id']))
					$usResultData['reports_assignable_party_id'] = $data[$this->alias]['reports_assignable_party_id'];
				if(isset($data[$this->alias]['reports_remediation_id']))
					$usResultData['reports_remediation_id'] = $data[$this->alias]['reports_remediation_id'];
				if(isset($data[$this->alias]['reports_verification_id']))
					$usResultData['reports_verification_id'] = $data[$this->alias]['reports_verification_id'];
				
				if($usResultData)
				{
					$this->UsResult->updateAll(
						$usResultData,
						array('UsResult.eol_software_id' => $id)
					);
				}
			}
		}
	}
	
	public function checkAdd($key = false, $extra = array())
	{
		if(!$key) return false;
		
		$key = trim($key);
		if(!$key) return false;
		
		if(isset($this->checkAddCache[$key]))
			return $this->checkAddCache[$key];
		
		$this->id = false;
		$eol_software_id = false;
		$create_alias = false;
		// check first to see if an alias exists with this key
		// if one does, use the eol_software_id
		$eol_software_id = $this->EolSoftwareAlias->field($this->EolSoftwareAlias->alias.'.eol_software_id', array($this->EolSoftwareAlias->alias.'.key' => $key));
		
		// if alias doesn't exist, see if we have a software with this key
		if(!$eol_software_id)
		{
			$create_alias = true;
			$eol_software_id = $this->field($this->primaryKey, array($this->alias.'.key' => $key));
		}
		
		// if we do, create an alias
		if($eol_software_id)
		{
			$this->id = $eol_software_id;
		}
		// if not, create a software, and an alias
		else
		{
			$this->create();
			$this->data = array_merge(array('key' => $key), $extra);
			$this->save($this->data, false);
		}
		
		if($this->id)
		{
			$this->checkAddCache[$key] = $this->id;
		}
		
		// if we need to create an alias as well
		if($create_alias and $this->id)
		{
			$this->EolSoftwareAlias->create();
			$this->EolSoftwareAlias->data = array_merge(array('key' => $key), $extra);
			$this->EolSoftwareAlias->data['eol_software_id'] = $this->id;
			$this->EolSoftwareAlias->save($this->EolSoftwareAlias->data);	
		}
		return $this->id;
	}
	
	public function makeAlias($data = array())
	{
		$this->modelError = false;
		if(!isset($data[$this->alias]['id']))
		{
			$this->modelError = __('Unknown %s to be made an Alias.', __('Software/Vulnerability'));
			return false;
		}
		
		if(!isset($data[$this->alias]['eol_software_id']))
		{
			$this->modelError = __('Unknown parent %s.', __('Software/Vulnerability'));
			return false;
		}
		
		$old_id = $data[$this->alias]['id'];
		$new_id = $data[$this->alias]['eol_software_id'];
		
		if($old_id == $new_id)
		{
			$this->modelError = __('The selected %s is the same one you are trying to make an alias.', __('Software/Vulnerability'));
			return false;
		}
		
		// move all of this one's aliases to the new one
		$this->EolSoftwareAlias->updateAll(array('EolSoftwareAlias.eol_software_id' => $new_id), array('EolSoftwareAlias.eol_software_id' => $old_id));
		
		// move all of the results to the new one as well
		$this->UsResult->updateAll(array('UsResult.eol_software_id' => $new_id), array('UsResult.eol_software_id' => $old_id));
		$this->UsResultLog->updateAll(array('UsResultLog.eol_software_id' => $new_id), array('UsResultLog.eol_software_id' => $old_id));
		$this->EolResult->updateAll(array('EolResult.eol_software_id' => $new_id), array('EolResult.eol_software_id' => $old_id));
		$this->EolResultLog->updateAll(array('EolResultLog.eol_software_id' => $new_id), array('EolResultLog.eol_software_id' => $old_id));
		$this->PenTestResult->updateAll(array('PenTestResult.eol_software_id' => $new_id), array('PenTestResult.eol_software_id' => $old_id));
		$this->PenTestResultLog->updateAll(array('PenTestResultLog.eol_software_id' => $new_id), array('PenTestResultLog.eol_software_id' => $old_id));
		$this->HighRiskResult->updateAll(array('HighRiskResult.eol_software_id' => $new_id), array('HighRiskResult.eol_software_id' => $old_id));
		$this->HighRiskResultLog->updateAll(array('HighRiskResultLog.eol_software_id' => $new_id), array('HighRiskResultLog.eol_software_id' => $old_id));
		
		// delete this one
		$this->delete($old_id);
		return true;
	}
}
