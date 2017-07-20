<?php
App::uses('AppController', 'Controller');
/**
 * PogLogs Controller
 *
 * @property PogLogs $PogLog
 */
class PogLogsController extends AppController 
{
//
	public function pog($pog_id = false) 
	{
		$this->PogLog->Pog->id = $pog_id;
		if (!$this->PogLog->Pog->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('Port Object Group')));
		}
		
		$this->Prg->commonProcess();
		
		$conditions = array(
			'PogLog.pog_id' => $pog_id,
		);
		
		$this->PogLog->recursive = 0;
		$this->paginate['order'] = array('PogLog.created' => 'desc');
		$this->paginate['conditions'] = $this->PogLog->conditions($conditions, $this->passedArgs); 
		$this->set('pog_logs', $this->paginate());
	}

//
	public function view($id = false)
	{
		
		$this->PogLog->id = $id;
		if (!$this->PogLog->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('Port Object Group Log')));
		}
		
		$this->PogLog->recursive = 0;
		$this->set('pog_log', $this->PogLog->read(null, $id));
	}
//
	public function admin_pog($pog_id = false) 
	{
		$this->PogLog->Pog->id = $pog_id;
		if (!$this->PogLog->Pog->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('Port Object Group')));
		}
		
		$this->Prg->commonProcess();
		
		$conditions = array(
			'PogLog.pog_id' => $pog_id,
		);
		
		$this->PogLog->recursive = 0;
		$this->paginate['order'] = array('PogLog.created' => 'desc');
		$this->paginate['conditions'] = $this->PogLog->conditions($conditions, $this->passedArgs); 
		$this->set('pog_logs', $this->paginate());
	}

//
	public function admin_view($id = false)
	{
		
		$this->PogLog->id = $id;
		if (!$this->PogLog->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('Port Object Group Log')));
		}
		
		$this->PogLog->recursive = 0;
		$this->set('pog_log', $this->PogLog->read(null, $id));
	}
}
