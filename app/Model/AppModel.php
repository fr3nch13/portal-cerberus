<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Model', 'Model');

// load for all models
App::uses('AuthComponent', 'Controller/Component');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */

class AppModel extends Model 
{	
	// add plugins and other behaviors
	public $actsAs = array(
		'Containable', 
		'Utilities.Common', 
		'Utilities.Extractor', 
		'Utilities.Foapi', 
		'Utilities.Rules', 
		'Utilities.Email',
		'Utilities.Shell', 
		'Queue.Queue', 
		'Search.Searchable', 
		'Ssdeep.Ssdeep', 
		'OAuthClient.OAuthClient' => array(
			'redirectUrl' => array('plugin' => false, 'controller' => 'users', 'action' => 'login', 'admin' => false)
		),
		'Cacher.Cache' => array(
			'config' => 'slowQueries',
			'clearOnDelete' => false,
			'clearOnSave' => false,
			'gzip' => false,
		),
		// used for avatar management
		'Upload.Upload' => array(
			'photo' => array(
				'deleteOnUpdate' => true,
				'thumbnailSizes' => array(
					'big' => '200x200',
					'medium' => '120x120',
					'thumb' => '80x80',
					'small' => '40x40',
					'tiny' => '16x16',
				),
			),
		), 
		'Usage.Usage' => array(
			'onCreate' => true,
			'onDelete' => true,
			'useCache' => false,
		),
    );
    
    // for checkadd to also update if needed
    public $slugCheckAddUpdate = false;
    
    public $checkadded = 0;
    public $checkupdated = 0;
    
    public $containOverride = array();
    
    public $multiselectFields = array(
    	'reported_to_ic_date' => array(
			'nameSingle' => 'Reported to IC',
    	),
    	'resolved_by_date' => array(
			'nameSingle' => 'Resolved By Date',
    	),
    );
	
	public function stats()
	{
	/*
	 * Default placeholder if no stats function is available for a Model
	 */
		if ($this->Behaviors->loaded('Usage.Usage'))
			return $this->Usage_stats();
		
		return array();
	}
    
    public function save($data = null, $validate = true, $fieldList = array())
    {
		// auto create the slugs if it's not in the data
		// only do it on a new item that doesn't have it's slug set
		if(!$this->id and $this->hasField('slug'))
		{
			$slugField = $this->displayField;
			if(isset($this->slugField))
			{
				$slugField = $this->slugField;
			}
			if(isset($data[$this->alias][$slugField]) and !isset($data[$this->alias]['slug']))
			{
				$data[$this->alias]['slug'] = $this->slugify($data[$this->alias][$slugField]);
			}
		}
		
    	return parent::save($data, $validate, $fieldList);
    }
    
    function updateAll($fields, $conditions = true) 
    {
    	$_whitelist = $this->whitelist;
		$options = array();
		$event = new CakeEvent('Model.beforeSave', $this, array($options) );
		list($event->break, $event->breakOn) = array(true, array(false, null));
		$this->getEventManager()->dispatch($event);
		if (!$event->result) {
			$this->whitelist = $_whitelist;
			return false;
		}
		
		if(!$this->getDataSource()->update($this, $fields, null, $conditions)) {
			return false;
		}
		
		$created = false;
		$options = array();
		$event = new CakeEvent('Model.afterSave', $this, array($created, $options));
		list($event->break, $event->breakOn) = array(true, array(false, null));
		$this->getEventManager()->dispatch($event);
		if (!$event->result) {
			$this->whitelist = $_whitelist;
			return false;
		}
		
		return true;
	}
	
	// always returns the object's id
	public function slugCheckAdd($slug = false, $data = array(), $options = array())
	{
		// try to find it by it's slug
		$existing = $this->findBySlug($slug);
		$update = false;
		if(isset($options['update']))
		{
			$update = $options['update'];
			unset($options['update']);
		}
		
		// this is new, create it
		if(!$existing)
		{
			$this->create();
			$this->data = $data;
			if(!$this->save($this->data, $options)) return false;
			
			$this->checkadded++;
			
			return $this->id;
		}
		else
		{
			// get the first item
			if(!isset($existing[$this->alias]))
			{
				$existing = array_shift($existing);
			}
			$existing = $existing[$this->alias];
			$this->id = $existing[$this->primaryKey];
			
			// should we update it? YES
			if($this->slugCheckAddUpdate or $update )
			{
				// get only the things that have changed from the existing to the new
				$diff = array();
				foreach($data as $k => $v)
				{
					if(isset($existing[$k]) and $existing[$k] != $v) $diff[$k] = $v;
					elseif(!isset($existing[$k])) $diff[$k] = $v;
				}
				
				$data[$this->primaryKey] = $this->id;
				
				// dave the differences
				if($diff and $this->id)
				{
					$this->data = $diff;
					$this->save($this->data);
				}
			}
			
			// return it's id
			return $existing[$this->primaryKey];
		}
	}
	
	// always returns the object's id
	public function hashCheckAdd($hash = false, $data = array(), $options = array())
	{
		// try to find it by it's slug
		$existing = $this->findByHash($hash);
		$update = false;
		if(isset($options['update']))
		{
			$update = $options['update'];
			unset($options['update']);
		}
		
		// this is new, create it
		if(!$existing)
		{
			$this->create();
			$this->data = $data;
			if(!$this->save($this->data, $options)) return false;
			
			$this->checkadded++;
			
			return $this->id;
		}
		else
		{
			// get the first item
			if(!isset($existing[$this->alias]))
			{
				$existing = array_shift($existing);
			}
			$existing = $existing[$this->alias];
			$this->id = $existing[$this->primaryKey];
			
			// should we update it? YES
			if($update)
			{
				// get only the things that have changed from the existing to the new
				$diff = array();
				foreach($data as $k => $v)
				{
					if(isset($existing[$k]) and $existing[$k] != $v) $diff[$k] = $v;
					elseif(!isset($existing[$k])) $diff[$k] = $v;
				}
				
				$data[$this->primaryKey] = $this->id;
				
				// dave the differences
				if($diff and $this->id)
				{
					$this->data = $diff;
					$this->save($this->data);
				}
			}
			
			// return it's id
			return $existing[$this->primaryKey];
		}
	}
	
	public function multiselectOptions($option = false, $select_format = false)
	{
		$belongsTo = array();
		
		foreach($this->belongsTo as $model_alias => $model_settings)
		{
			if(!isset($model_settings['multiselect']) or !$model_settings['multiselect'])
				continue;
			
			$slug = Inflector::underscore($model_alias);
			if(!isset($model_settings['nameSingle']))
				$model_settings['nameSingle'] = Inflector::humanize($slug);
			if(!isset($model_settings['namePlural']))
				$model_settings['namePlural'] = Inflector::pluralize($model_settings['nameSingle']);
			if(!isset($model_settings['variableSingle']))
				$model_settings['variableSingle'] = Inflector::variable($slug);
			if(!isset($model_settings['variablePlural']))
				$model_settings['variablePlural'] = Inflector::pluralize($model_settings['variableSingle']);
			
			$belongsTo[$model_alias] = $model_settings;
		}
		
		foreach($this->multiselectFields as $field => $field_settings)
		{
			if(!isset($field_settings['field']))
				$field_settings['field'] = $field;
			if(!isset($field_settings['nameSingle']))
				$field_settings['nameSingle'] = Inflector::humanize($field);
			if(!isset($field_settings['namePlural']))
				$field_settings['namePlural'] = Inflector::pluralize($field_settings['nameSingle']);
			if(!isset($field_settings['variableSingle']))
				$field_settings['variableSingle'] = Inflector::variable($field);
			if(!isset($model_settings['variablePlural']))
				$field_settings['variablePlural'] = Inflector::pluralize($field_settings['variableSingle']);
			$belongsTo[$field] = $field_settings;
		}
		
		if($select_format)
		{
			foreach($belongsTo as $model_alias => $model_settings)
			{
				$belongsTo[$model_alias] = __('%s', $model_settings['nameSingle']);
			}
		}
		
		if($option)
			return (isset($belongsTo[$option])?$belongsTo[$option]:false);
		
		return $belongsTo;
	}
	
	public function multiselectItems($data = array(), $values = array())
	{
		$this->multiselectReferer = array();
		if(isset($data[$this->alias]['multiselect_referer']))
		{
			$this->multiselectReferer = unserialize($data[$this->alias]['multiselect_referer']);
		}
		
		if(isset($values[$this->alias]))
			$values = $values[$this->alias];
		
		$ids = array();
		if(isset($data['multiple']))
		{
			$ids = $data['multiple'];
		}
		
		$saveMany_data = array();
		foreach($ids as $id)
		{
			$saveMany_data[$id] = array('id' => $id);
			$saveMany_data[$id] = array_merge($saveMany_data[$id], $values);
		}
		
		return $this->saveMany($saveMany_data);
	}
	
	public function resultIdsForCrm($crm_id = false, $reports_status_id = false)
	{
		if(!$crm_id)
			return array();
		
		$FismaSystem = false;
		if($this->alias == 'FismaSystem')
		{
			$FismaSystem = $this;
		}
		else
		{
			$FismaSystem = $this->SubnetMember->FismaInventory->FismaSystem;
		}
		
		$fismaSystemIds = $FismaSystem->idsForCrm($crm_id);
		
		$ids = array();
		
		foreach($fismaSystemIds as $fismaSystemId)
		{
			$inventoryIps = $FismaSystem->getRelatedIpAddresses($fismaSystemId);
			$inventoryHostNames = $FismaSystem->getRelatedHostNames($fismaSystemId);
			
			if(!$inventoryIps and !$inventoryHostNames)
			{
				continue;
			}
			
			$conditions = array('OR' => array());
			
			if($inventoryIps)
				$conditions['OR'][] = array(
					$this->alias.'.ip_address !=' => '',
					$this->alias.'.ip_address' => $inventoryIps,
				);
			if($inventoryHostNames)
				$conditions['OR'][] = array(
					$this->alias.'.host_name !=' => '',
					$this->alias.'.host_name' => $inventoryHostNames,
				); 
			if($reports_status_id)
			{
				$conditions[$this->alias.'.reports_status_id'] = $reports_status_id;
			}
			if($thisIds = $this->find('list', array(
				'recursive' => -1,
				'conditions' => $conditions,
				'fields' => array($this->alias.'.'.$this->primaryKey, $this->alias.'.'.$this->primaryKey)
			)))
			{
				$ids = $ids + $thisIds;
			}
		}
		return $ids;
	}
}
