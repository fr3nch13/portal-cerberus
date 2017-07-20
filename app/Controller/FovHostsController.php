<?php
App::uses('AppController', 'Controller');

class FovHostsController extends AppController 
{
	public $helpers = [
		'ReportResults',
	];
	
	public function search_results()
	{
		return $this->index();
	}
	
	public function index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = [];
		$conditions = array_merge($conditions, $this->conditions);
		
		$page_subtitle = (isset($this->viewVars['page_subtitle'])?$this->viewVars['page_subtitle']:__('All'));
		$page_description = (isset($this->viewVars['page_description'])?$this->viewVars['page_description']:'');
		
		$this->paginate['conditions'] = $this->FovHost->conditions($conditions, $this->passedArgs);
		if(isset($this->request->params['ext']) and $this->request->params['ext'] === 'csv')
		{
			$this->paginate['limit'] = $this->paginate['maxLimit'] = $this->FovHost->getCachedCounts('count', ['conditions' => $this->paginate['conditions']]);
			if(!$this->paginate['limit'])
				$this->paginate['empty'] = true;
			$this->layout = 'Utilities.../ajax_nodebug';
		}
		
		if(!isset($this->paginateModel))
			$this->paginateModel = 'FovHostFovResult';
		
		if(!isset($this->paginate['contain']) or !$this->paginate['contain'])
			$this->paginate['contain'] = [
				'FovHost',
			];
		
		$fovHosts = $this->paginate($this->paginateModel);
		
		$this->set('fovHosts', $fovHosts);
		
		$this->set(compact(['page_subtitle', 'page_description']));
	}
	
	public function fov_result($id = null) 
	{
		if (!$fovResult = $this->FovHost->FovResult->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('FOV Result')));
		}
		$this->set('fovResult', $fovResult);
		
		$conditions = ['FovHostFovResult.fov_result_id' => $id];
		$result_name = $this->FovHost->FovResult->nameForResult('FovResult', $fovResult);
		
		$page_subtitle = __('%s: %s', __('FOV Result'), $result_name);
		$page_description = '';
		$this->set(compact(['page_subtitle', 'page_description']));
		
		$this->conditions = $conditions;
		$this->index(); 
	}
	
	public function view($id = false)
	{
		$this->FovHost->recursive = 0;
		if (!$fovHost = $this->FovHost->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('FOV Host')));
		}
			
		$this->set('fovHost', $fovHost);
	}
	
	public function add($fov_result_id = false)
	{
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			$this->FovHost->create();
			if ($this->FovHost->addMany($this->request->data, $fov_result_id)) 
			{
				$this->Flash->success(__('The %s have been saved', __('FOV Hosts')));
				return $this->redirect(['action' => 'view', $this->FovHost->id]);
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again. (Err: %s)', __('FOV Hosts'), $this->FovHost->modelError));
			}
		}
	}
	
	public function edit($id = null)
	{
		$this->FovHost->id = $id;
		if (!$fovHost = $this->FovHost->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('FOV Host')));
		}
		
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			$this->request->data['FovHost']['modified_user_id'] = AuthComponent::user('id');
			if ($this->FovHost->save($this->request->data)) 
			{
				$this->Flash->success(__('The %s has been saved', __('FOV Host')));
				return $this->redirect(['action' => 'view', $this->FovHost->id]);
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('FOV Host')));
			}
		}
		else
		{
			$this->request->data = $fovHost;
		}
	}
	
	public function admin_delete($id = null) 
	{
		$this->FovHost->id = $id;
		if (!$this->FovHost->exists()) {
			throw new NotFoundException(__('Invalid %s', __('FOV Host')));
		}
		if ($this->FovHost->delete()) {
			$this->Flash->success(__('%s deleted', __('FOV Host')));
			return $this->redirect(['action' => 'index', 'admin' => false]);
		}
		$this->Flash->error(__('%s was not deleted', __('FOV Host')));
		return $this->redirect(['action' => 'index', 'admin' => false]);
	}
}