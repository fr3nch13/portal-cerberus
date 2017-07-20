<?php
App::uses('AppController', 'Controller');
/**
 * ReviewStateLogs Controller
 *
 * @property ReviewStateLogs $ReviewStateLog
 */
class ReviewStateLogsController extends AppController 
{
//
	public function rule($rule_id = false) 
	{
		$this->ReviewStateLog->Rule->id = $rule_id;
		if (!$this->ReviewStateLog->Rule->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('Rule')));
		}
		
		$this->Prg->commonProcess();
		
		$conditions = array(
			'ReviewStateLog.rule_id' => $rule_id,
		);
		
		$this->ReviewStateLog->recursive = 0;
		$this->paginate['order'] = array('ReviewStateLog.created' => 'desc');
		$this->paginate['conditions'] = $this->ReviewStateLog->conditions($conditions, $this->passedArgs); 
		$this->set('review_state_logs', $this->paginate());
	}
}
