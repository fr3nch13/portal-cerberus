<?php
class EolResultLogsController extends AppController 
{
	public function eol_result($id = null) 
	{
		if (!$eol_result = $this->EolResultLog->EolResult->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('EOL Result')));
		}
		$this->set('eol_result', $eol_result);
		
		$this->Prg->commonProcess();
		
		$conditions = array(
			'EolResultLog.eol_result_id' => $id,
		); 
		
		$this->paginate['conditions'] = $this->EolResultLog->conditions($conditions, $this->passedArgs); 
		if(isset($this->request->params['ext']) and $this->request->params['ext'] === 'csv')
		{
			$this->EolResultLog->recursive = -1;
			$this->paginate['limit'] = $this->EolResultLog->find('count', array('conditions' => $this->paginate['conditions']));
			$this->layout = 'Utilities.../ajax_nodebug';
		}
		
		$this->EolResultLog->recursive = 0;
		$this->set('eol_result_logs', $this->paginate());
	}
}