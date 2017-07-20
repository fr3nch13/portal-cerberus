<?php
App::uses('AppModel', 'Model');
/**
 * FismaSoftware Model
 *
 * @property Rule $Rule
 */
class FismaSoftware extends AppModel 
{
	public $useTable = 'fisma_softwares';
	public $displayField = 'name';

	public $validate = array(
		'name' => array(
			'boolean' => array(
				'rule' => array('notBlank'),
			),
		),
	);
	
	public $belongsTo = array(
		'FismaSoftwareAddedUser' => array(
			'className' => 'User',
			'foreignKey' => 'added_user_id',
		),
		'FismaSoftwareModifiedUser' => array(
			'className' => 'User',
			'foreignKey' => 'modified_user_id',
		),
		'FismaSoftwareGroup' => array(
			'className' => 'FismaSoftwareGroup',
			'foreignKey' => 'fisma_software_group_id',
		),
		'FismaSoftwareSource' => array(
			'className' => 'FismaSoftwareSource',
			'foreignKey' => 'fisma_software_source_id',
		),
	);
	
	public $hasMany = array(
		'PenTestResultLog' => array(
			'className' => 'PenTestResultLog',
			'foreignKey' => 'fisma_software_id',
			'dependent' => true,
		),
		'PenTestResult' => array(
			'className' => 'PenTestResult',
			'foreignKey' => 'fisma_software_id',
			'dependent' => true,
		)
	);
	
	public $hasAndBelongsToMany = array(
		'FismaSystem' => array(
			'className' => 'FismaSystem',
			'joinTable' => 'fisma_softwares_fisma_systems',
			'foreignKey' => 'fisma_software_id',
			'associationForeignKey' => 'fisma_system_id',
			'unique' => 'keepExisting',
			'with' => 'FismaSoftwareFismaSystem',
		),
	);
	
	public $actsAs = array(
		'Tags.Taggable',
		//'Cacher.Cache' => array('auto' => false),
	);
	
	// define the fields that can be searched
	public $searchFields = array(
		'FismaSoftware.name',
		'FismaSoftware.version',
		'FismaSoftwareGroup.name',
		'FismaSoftwareSource.name',
	);
	
	// fields that are boolean and can be toggled
	public $toggleFields = array('approved');
	
	public $manageUploads = true;
	
	///// variables specific to this Model
	public $includeSystems = false;
	
	public function afterSave($created = false, $options = array())
	{
		if(isset($this->data[$this->alias]['all']) and $this->data[$this->alias]['all'])
		{
			// if all is selected, add all fisma systems to this software
			$fismaSystems = $this->FismaSystem->find('list');
			$this->FismaSoftwareFismaSystem->saveAssociatedSystems($this->id, array_keys($fismaSystems));
		}
		
		return parent::afterSave($created, $options);
	}
	
	public function afterFind($results = array(), $primary = false)
	{
		if($this->includeSystems and !in_array($this->findQueryType, array('list', 'count')))
		{
			$fisma_software_ids = array();
			foreach ($results as $i => $result) 
			{
				if(!isset($result[$this->alias]))
					continue;
					
				if(isset($result[$this->alias]['all']) and $result[$this->alias]['all'])
					continue;
				
				$fisma_software_id = $result[$this->alias]['id'];
				$fisma_software_ids[$fisma_software_id] = $fisma_software_id;
			}
			
			if($fisma_software_ids)
			{
				$fisma_systems = $this->FismaSoftwareFismaSystem->find('all', array(
					'recursive' => 0,
					'contain' => array('FismaSystem'),
					'conditions' => array(
						'FismaSoftwareFismaSystem.fisma_software_id' => $fisma_software_ids,
					),
				));
				
				// attach the fisma systems
				foreach ($results as $i => $result)
				{
					if(!isset($result[$this->alias]))
						continue;
					
					$results[$i]['FismaSystem'] = array();
					foreach ($fisma_systems as $j => $fisma_system)
					{
						if($result[$this->alias]['id'] == $fisma_system['FismaSoftwareFismaSystem']['fisma_software_id'])
						{
							$results[$i]['FismaSystem'][] = $fisma_system['FismaSystem'];
							// remove it from the list, it's taken
							unset($fisma_systems[$j]);
						}
					}
				}
			}
		}
		
		return parent::afterFind($results, $primary);
	}
	
	public function listByGroup()
	{
	// used to create a multiselect list with groups
		$_fismaSoftwares = $this->find('all', array(
			'conditions' => array(
				$this->alias.'.approved' => true,
			),
		));
		
		$fisma_software_groups = $this->FismaSoftwareGroup->find('list');
		
		$fismaSoftwares = array();
		foreach($fisma_software_groups as $fisma_software_group_id => $fisma_software_group_name)
		{
			foreach($_fismaSoftwares as $fismaSoftware)
			{
				if($fismaSoftware['FismaSoftware']['fisma_software_group_id'] == $fisma_software_group_id)
				{
					$fismaSoftwares[$fisma_software_group_name][$fismaSoftware['FismaSoftware']['id']] = $fismaSoftware['FismaSoftware']['name'];
				}
			}
		}
		foreach($_fismaSoftwares as $fismaSoftware)
		{
			if(!$fismaSoftware['FismaSoftware']['fisma_software_group_id'])
			{
				$fismaSoftwares[$fismaSoftware['FismaSoftware']['id']] = $fismaSoftware['FismaSoftware']['name'];
			}
		}
		return $fismaSoftwares;
	}
	
	public function checkAdd($name = false, $extra = array())
	{
		if(!$name) return false;
		
		$name = trim($name);
		if(!$name) return false;
		
		$slug = Inflector::slug(strtolower($name));
		
		if($id = $this->field($this->primaryKey, array($this->alias.'.slug' => $slug)))
		{
			return $id;
		}
		
		if(isset($extra['software_source']))
		{
			$source_extra = array();
			if(isset($extra['software_source_id']))
			{
				$model_id = $extra['software_source_id'];
				$model = 'Unknown';
				if(isset($extra['software_source_model']))
				{
					$model = $extra['software_source_model'];
					unset($extra['software_source_model']);
				}
				$source_extra['details'] = __('Originated from %s with id of %s.', Inflector::humanize($model), $model_id);
				unset($extra['software_source_id']);
			}
			
			$extra['fisma_software_source_id'] = $this->FismaSoftwareSource->checkAdd($extra['software_source'], $source_extra);
			unset($extra['software_source']);
		}
		
		// not an existing one, create it
		$this->create();
		$this->data = array_merge(array('name' => $name, 'slug' => $slug, 'approved' => false), $extra);
		if($this->save($this->data))
		{
			return $this->id;
		}
		return false;
	}
	
	public function typeFormListBlank()
	{
		$softwares = $this->find('all', array(
			'order' => array($this->alias.'.name' => 'ASC'),
		));
		
		$out = array();
		foreach($softwares as $software)
		{
			$key = $software[$this->alias]['id'];
			$value = array($software[$this->alias]['name']);
			if($software[$this->alias]['version'])
				$value[] = $software[$this->alias]['version'];
			$value = implode('/', $value);
			$out[$key] = $value;
		}
		return array('[ Select ]')+$out;
	}
	
	
}