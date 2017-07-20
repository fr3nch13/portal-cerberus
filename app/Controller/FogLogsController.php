<?php
App::uses('AppController', 'Controller');
/**
 * FogLogs Controller
 *
 * @property FogLogs $FogLog
 */
class FogLogsController extends AppController 
{
//
	public function fog($fog_id = false) 
	{
		$this->FogLog->Fog->id = $fog_id;
		if (!$this->FogLog->Fog->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('Firewall Object Group')));
		}
		
		$this->Prg->commonProcess();
		
		$conditions = array(
			'FogLog.fog_id' => $fog_id,
		);
		
		$this->FogLog->recursive = 0;
		$this->paginate['order'] = array('FogLog.created' => 'desc');
		$this->paginate['conditions'] = $this->FogLog->conditions($conditions, $this->passedArgs); 
		$this->set('fog_logs', $this->paginate());
	}

//
	public function view($id = false)
	{
		
		$this->FogLog->id = $id;
		if (!$this->FogLog->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('Firewall Object Group Log')));
		}
		
		$this->FogLog->recursive = 0;
		$this->set('fog_log', $this->FogLog->read(null, $id));
	}
//
	public function admin_fog($fog_id = false) 
	{
		$this->FogLog->Fog->id = $fog_id;
		if (!$this->FogLog->Fog->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('Firewall Object Group')));
		}
		
		$this->Prg->commonProcess();
		
		$conditions = array(
			'FogLog.fog_id' => $fog_id,
		);
		
		$this->FogLog->recursive = 0;
		$this->paginate['order'] = array('FogLog.created' => 'desc');
		$this->paginate['conditions'] = $this->FogLog->conditions($conditions, $this->passedArgs); 
		$this->set('fog_logs', $this->paginate());
	}

//
	public function admin_view($id = false)
	{
		
		$this->FogLog->id = $id;
		if (!$this->FogLog->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('Firewall Object Group Log')));
		}
		
		$this->FogLog->recursive = 0;
		$this->set('fog_log', $this->FogLog->read(null, $id));
	}
}
