<?php

App::uses('QueueTask', 'Queue.Console/Command/Task');

class QueueProcessUsReportTask extends QueueTask 
{
	public $uses = [
		'UsReport'
	];
	
	public $QueuedTask;
	
	public $timeout = 6000;
	
	public $retries = 1;
	
	public $failureMessage = '';
	
	public function run($data, $id = null) 
	{
		if(!$this->UsReport->proccessReportTask($data, $id))
		{
			$this->failureMessage = $this->UsReport->modelError;
			return false;
		}
		return true;
	}
}