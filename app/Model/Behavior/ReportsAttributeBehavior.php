<?php

class ReportsAttributeBehavior extends ModelBehavior 
{
	public $settings = [];
	
	private $_defaults = [];
	
	public $checkAddCache = [];
	
	public function setup(Model $Model, $config = []) 
	{
		$this->settings[$Model->alias] = array_merge($this->_defaults, $config);
	}
	
	public function beforeSave(Model $Model, $options = []) 
	{
		
		if(isset($Model->data[$Model->alias]['name']) and !isset($Model->data[$Model->alias]['slug']))
		{
			$Model->data[$Model->alias]['slug'] = $Model->slugify($Model->data[$Model->alias]['name']);
		}
		
		return parent::beforeSave($Model, $options);
	}
	
	public function checkAdd(Model $Model, $name = false, $extra = [])
	{
		if(!$name) return false;
		
		$name = trim($name);
		if(!$name) return false;
		
		$slug = $Model->slugify($name);
		
		if(isset($this->checkAddCache[$slug]))
			return $this->checkAddCache[$slug];
		
		if($id = $Model->field($Model->primaryKey, [$Model->alias.'.slug' => $slug]))
		{
			$this->checkAddCache[$slug] = $id;
			return $id;
		}
		
		// not an existing one, create it
		$Model->create();
		$Model->data = array_merge(['name' => $name, 'slug' => $slug], $extra);
		if($Model->save($Model->data))
		{
			$this->checkAddCache[$slug] = $Model->id;
			return $Model->id;
		}
		return false;
	}
	
	public function findforTable(Model $Model, $onlyOpen = false)
	{
		$conditions = [
			$Model->alias.'.show' => true,
		];
		
		if($onlyOpen)
			$conditions[$Model->alias.'.slug'] = 'open';
		
		$results = $Model->find('all', [
			'conditions' => $conditions,
		]);
		return $results;
	}
	
	public function resultsChangeEmail(Model $Model)
	{
		if(Configure::read('debug') > 1)
			Configure::write('debug', 1);
		
		$modelKey = $Model->alias;
		$modelKey = str_replace('Reports', '', $modelKey);
		$modelKey = strtolower($modelKey);
		
		$timeAgoWord = '-11 minutes';
		$timeAgo = date('Y-m-d H:i:s', strtotime($timeAgoWord));
		
		$countEol = $Model->EolResult->find('count', ['conditions' => [$Model->EolResult->alias.'.'.$modelKey.'_date > ' => $timeAgo]]);
		$countPt = $Model->PenTestResult->find('count', ['conditions' => [$Model->PenTestResult->alias.'.'.$modelKey.'_date > ' => $timeAgo]]);
		$countHr = $Model->HighRiskResult->find('count', ['conditions' => [$Model->HighRiskResult->alias.'.'.$modelKey.'_date > ' => $timeAgo]]);
		
		$toSendEmail = false;
		if($countEol or $countPt or $countHr)
			$toSendEmail = true;
		
		if(!$toSendEmail) // no further action required
		{
			$Model->shellOut(__('No results Found with %s changed - Threshold > %s', $modelKey, $timeAgo));
			return true;
		}
		
		$Model->shellOut(__('Found results with %s changed - EOL:%s - PT:%s - HR:%s', $modelKey, $countEol, $countPt, $countHr));
		
		$config = Configure::read('ReportsResult');
		
		$Model->Email_reset();
		$Model->Email_set('from', $config['from_email']);
		$Model->Email_set('to', $config['to_email']);
		$Model->Email_set('emailFormat', 'html');
		$Model->Email_set('template', 'results_change_email');
		$Model->Email_set('debug', false);
		
		
		$subject = __('Imported Results %s Changed - EOL:%s/PT:%s/HR:%s - Threshold > %s', $modelKey, $countEol, $countPt, $countHr, $timeAgo);
		$Model->shellOut(__('Subject: %s', $subject));
		$Model->Email_set('subject', $subject);
		
		$Model->Email_set('viewVars', [
			'instructions' => $config['description'],
			'timeAgo' => $timeAgo,
			'timeAgoWord' => $timeAgoWord,
			'countEol' => $countEol,
			'countPt' => $countPt,
			'countHr' => $countHr,
			'subject' => $subject,
			'modelKey' => $modelKey,
		]);
		
		$result = $Model->Email_executeFull();
		if($result)
		{
			$Model->shellOut(__('Email Sent'));
		}
		else
		{
		
			$Model->shellOut(__('Email NOT Sent'));
		}
		
		return $result;
	}
}