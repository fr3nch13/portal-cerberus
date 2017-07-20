<?php
App::uses('AppController', 'Controller');
/**
 * Imports Controller
 *
 * @property Imports $Import
 */
class ImportsController extends AppController 
{

//
	public function index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		$this->Import->recursive = -1;
		$this->paginate['order'] = array('Import.name' => 'asc');
		$this->paginate['conditions'] = $this->Import->conditions($conditions, $this->passedArgs); 
		$this->set('imports', $this->paginate());
	}

//
	public function view($id = false)
	{
		
		$this->Import->id = $id;
		if (!$this->Import->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('Import')));
		}
		
		// get the counts
		$this->Import->getCounts = array(
			'Rule' => array(
				'all' => array(
					'conditions' => array(
						'Rule.import_id' => $id,
					),
				),
			),
		);
		
		$this->Import->recursive = 0;
		$this->set('import', $this->Import->read(null, $id));
	}

//
	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		$this->Import->recursive = -1;
		$this->paginate['order'] = array('Import.name' => 'asc');
		$this->paginate['conditions'] = $this->Import->conditions($conditions, $this->passedArgs); 
		$this->set('imports', $this->paginate());
	}

//
	public function admin_view($id = false)
	{
		
		$this->Import->id = $id;
		if (!$this->Import->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('Import')));
		}
		
		// get the counts
		$this->Import->getCounts = array(
			'Rule' => array(
				'all' => array(
					'conditions' => array(
						'Rule.import_id' => $id,
					),
				),
			),
		);
		
		$this->Import->recursive = 0;
		$import = $this->Import->read(null, $id);
		$this->set('import', $import);
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post') || $this->request->is('put'))
		{
			$this->Import->create();
			
			$this->request->data['Import']['added_user_id'] = AuthComponent::user('id');
			if ($this->Import->save($this->request->data))
			{
				$this->Flash->success(__('The %s has been saved', __('Import')));
				return $this->redirect(array('action' => 'view', $this->Import->id));
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again. (Possilbe Error: %s)', __('Import'), $this->Import->modelError));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		$this->Import->id = $id;
		if (!$this->Import->exists()) 
		{
			throw new NotFoundException(__('Invalid %s', __('Import')));
		}
		
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			$this->request->data['Import']['modified_user_id'] = AuthComponent::user('id');
			if ($this->Import->save($this->request->data)) 
			{
				$this->Flash->success(__('The %s has been updated', __('Import')));
				return $this->redirect(array('action' => 'view', $this->Import->id));
			}
			else
			{
				$this->Flash->error(__('The %s could not be updated. Reason: %s', __('Import'), $this->Import->modelError));
			}
		}
		else
		{
			$this->request->data = $this->Import->read(null, $id);
		}
	}
	
	public function admin_rescan($id = null)
	{
		if (!$import = $this->Import->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('Import')));
		}
		
		if(!isset($import['Import']['paths']['sys']))
		{
			throw new NotFoundException(__('Invalid %s %s', __('Import'), __('File')));
		}
		
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			$start = time();
			$this->request->data['Import']['rescanned_user_id'] = AuthComponent::user('id');
			
			if ($this->Import->processImportFile($this->request->data['Import'], $import['Import']['paths']['sys'])) 
			{
				$diff = time() - $start;
				$this->bypassReferer = true;
				$this->Flash->success(__('%s rescanned on %s seconds', __('Import'), $diff));
				return $this->redirect(array('action' => 'view', $this->Import->id));
			}
			else
			{
				$error = __('The %s could not be rescanned. Please, try again.', __('Import'));
				if($this->Import->modelError)
				{
					$error = $this->Import->modelError;
				}
				
				$this->Flash->error($error);
			}
		}
		else
		{
			$this->request->data = $import;
		}
	}

//
	public function admin_delete($id = null) 
	{
		$this->Import->id = $id;
		if (!$this->Import->exists()) 
		{
			throw new NotFoundException(__('Invalid %s', __('Import')));
		}

		if ($this->Import->delete()) 
		{
			$this->Flash->success(__('%s deleted', __('Import')));
			return $this->redirect($this->referer());
		}
		
		$this->Flash->error(__('The %s could not be deleted. Please, try again.', __('Import')));
		return $this->redirect($this->referer());
	}
}
