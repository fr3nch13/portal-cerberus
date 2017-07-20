<?php
App::uses('AppModel', 'Model');
App::uses('UsResult', 'Model');

class UsResultLog extends UsResult 
{
	public $useTable = 'us_result_logs';
	
	public $order = array('UsResultLog.created' => 'DESC');
	
	public $_belongsTo = array(
		'UsResult' => array(
			'className' => 'UsResult',
			'foreignKey' => 'us_result_id',
		),
	);
	
	public $actsAs = array(
		'ReportsResults',
		'Tags.Taggable',
		'PhpRtf.PhpRtf',
		'Utilities.DomParser', 
		'Utilities.Extractor',
		'Usage.Usage' => array(
			'onCreate' => false,
			'onDelete' => false,
		),
	);
	
	function __construct($id = false, $table = null, $ds = null) 
	{
		$this->belongsTo = $this->belongsTo+$this->_belongsTo;
		return parent::__construct($id, $table, $ds);
	}
	
	/// overwrite some fuctions from host that we don't need here
	public function afterFind($results = array(), $primary = false)
	{
		return $results;
	}
	
	public function beforeSave($options = array()) 
	{
		return true;
	}
	
	public function afterSave($created = false, $options = array())
	{
		return true;
	}
	
	public function logChanges($us_result_id = false, $old = array(), $new = array())
	{
		if($us_result_id and isset($old[$this->UsResult->alias]) and is_array($old[$this->UsResult->alias]) and $old[$this->UsResult->alias])
		{
			// if we're given a new record result, check to see if anything has changed
			$old = $old[$this->UsResult->alias];
			
			if(isset($new[$this->UsResult->alias]) and is_array($new[$this->UsResult->alias]) and $new[$this->UsResult->alias])
			{
				$new = $new[$this->UsResult->alias];
				
				if(isset($new['modified_user_id']))
					$old['modified_user_id'] = $new['modified_user_id'];
				
				$update = array();
				foreach($new as $field => $value)
				{
					if(in_array($field, array('created', 'modified')))
						continue;
					
					if(isset($old[$field]) and $old[$field] != $value)
						$update[$field] = $value;
				}
				
				// nothing changed, no need to log it
				if(!$update)
					return true;
			}
			
			// Add usage stats here
			// This will track when any attribute that this object belongs to gets changed
			foreach($update as $update_k => $update_v)
			{
				if(preg_match('/_id$/', $update_k))
				{
					$this->Usage_updateCounts($update_k.'-'.$update_v, 'us_results');
				}
			}
			
			if(isset($old['id'])) unset($old['id']);
			$old['us_result_id'] = $us_result_id;
			
			$old['created'] = date('Y-m-d H:i:s');
			
			$this->create();
			$this->data = $old;
			return $this->save($this->data);
		}
	}
	
	public function scanPastUsage()
	{
		Configure::write('debug', 1);
		$logs = $this->find('all', array(
			'order' => array(
				$this->alias.'.us_result_id' => 'asc',
				$this->alias.'.created' => 'asc',
			),
			'conditions' => array(
				$this->alias.'.created <' => '2015-10-15 23:59:59',
			),
		));
		
		// reload the UsageCount
		App::uses('UsageEntity', 'Usage.Model');
		$this->UsageEntity = new UsageEntity();
		
		$time_periods = array(
			'year' => 'Y',
			'month' => 'Ym',
			'week' => 'YW',
			'day' => 'Ymd',
			'hour' => 'YmdH',
			'minute' => 'YmdHi',
		);
		
		$past = array();
		$updates = array();
		foreach($logs as $current)
		{
			// different result log
			if(isset($past[$this->alias]['us_result_id']) and $past[$this->alias]['us_result_id'] != $current[$this->alias]['us_result_id'])
				$past = array();
			
			// do everything here
			$updated = array();
			foreach($current[$this->alias] as $field => $value)
			{
				if(in_array($field, array('created', 'modified', 'id')))
					continue;
				
				if(preg_match('/(_user_id|_date)$/', $field))
					continue;
					
				if(isset($past[$this->alias][$field]) and $past[$this->alias][$field] != $value)
				{
					$updated['old'][$field] = $past[$this->alias][$field];
					$updated[$field] = $value;
				}
			}
			
			if($updated)
			{
				$updated['modified'] = $current[$this->alias]['modified'];
				$updates[] = $updated;
			}
			
			$past = $current;
		}
		
		foreach($updates as $update)
		{
			foreach($update as $update_k => $update_v)
			{
				if(preg_match('/_id$/', $update_k))
				{
					foreach($time_periods as $time_period => $time_format)
					{
			
						$this->UsageEntity->updateCount($update_k.'-'.$update_v, 'us_results', 1, $this->alias, $time_period, date($time_format, strtotime($update['modified'])));
						$this->UsageEntity->updateCount('modified', 'us_results', 1, $this->alias, $time_period, date($time_format, strtotime($update['modified'])));
						$this->UsageEntity->updateCount('us_results', 'modified', 1, $this->alias, $time_period, date($time_format, strtotime($update['modified'])));
					}
				}
			}
		}
	}
}
