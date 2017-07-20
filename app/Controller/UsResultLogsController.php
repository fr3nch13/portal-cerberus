<?php
class UsResultLogsController extends AppController 
{
	public function us_result($id = null) 
	{
		if (!$us_result = $this->UsResultLog->UsResult->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('US Result')));
		}
		$this->set('us_result', $us_result);
		
		$this->Prg->commonProcess();
		
		$conditions = array(
			'UsResultLog.us_result_id' => $id,
		); 
		
		$this->paginate['conditions'] = $this->UsResultLog->conditions($conditions, $this->passedArgs); 
		if(isset($this->request->params['ext']) and $this->request->params['ext'] === 'csv')
		{
			$this->UsResultLog->recursive = -1;
			$this->paginate['limit'] = $this->paginate['maxLimit'] = $this->UsResultLog->find('count', array('conditions' => $this->paginate['conditions']));
			$this->layout = 'Utilities.../ajax_nodebug';
		}
		
		$this->UsResultLog->recursive = 0;
		$this->set('us_result_logs', $this->paginate());
	}
}