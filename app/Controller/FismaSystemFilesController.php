<?php
App::uses('AppController', 'Controller');
/**
 * FismaSystemFiles Controller
 *
 * @property FismaSystemFile $FismaSystemFile
 * @property PaginatorComponent $Paginator
 */
class FismaSystemFilesController extends AppController 
{
	public function index($raf = null) 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(); 
		
		if($raf !== null) 
		{
			$conditions['FismaSystemFile.raf'] = $raf;
		}
		
		$this->FismaSystemFile->recursive = 0;
		$this->paginate['contain'] = array('FismaSystemFileState', 'FismaSystem');
		$this->paginate['conditions'] = $this->FismaSystemFile->conditions($conditions, $this->passedArgs); 
		
		$this->paginate['order'] = array('FismaSystemFile.created' => 'desc');
		$this->set('fisma_system_files', $this->paginate());
		$this->set('raf', $raf);
	}
	
	public function fisma_system($fisma_system_id = null, $raf = null) 
	{
		if (!$this->FismaSystemFile->FismaSystem->exists($fisma_system_id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA System')));
		}
		$this->set('fisma_system_id', $fisma_system_id);
		
		$this->Prg->commonProcess();
		
		$conditions = array(
			'FismaSystemFile.fisma_system_id' => $fisma_system_id,
		);
		
		if($raf !== null) 
		{
			$conditions['FismaSystemFile.raf'] = $raf;
		}
		
		$this->FismaSystemFile->FismaSystem->recursive = -1;
		$this->set('FismaSystem', $this->FismaSystemFile->FismaSystem->read(null, $fisma_system_id));
		
		$this->FismaSystemFile->recursive = 0;
		$this->paginate['contain'] = array('FismaSystemFileState');
		$this->paginate['conditions'] = $this->FismaSystemFile->conditions($conditions, $this->passedArgs); 
		if(isset($this->request->params['ext']) and $this->request->params['ext'] === 'csv')
		{
			$this->paginate['limit'] = $this->FismaSystemFile->find('count', array('conditions' => $this->paginate['conditions']));
			$this->layout = 'Utilities.../ajax_nodebug';
		}
		
		$this->paginate['order'] = array('FismaSystemFile.created' => 'desc');
		$this->set('fisma_system_files', $this->paginate());
		$this->set('raf', $raf);
	}
	
	public function saa_add($fisma_system_id = null, $raf = null) 
	{
		if (!$this->FismaSystemFile->FismaSystem->exists($fisma_system_id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA System')));
		}
		
		$file_type = __('File');
		if($raf)
			$file_type = __('Risk Acceptance Form');
		
		$this->FismaSystemFile->validator()->add('file', 'required', array(
			'existing' => array(
				'rule' => array('fileSize', '>', '0'),
				'message' => __('A non-empty file is required.'),
			),
			'fileSize' => array(
				'rule' => array('fileSize', '<=', $this->Common->maxFileSize()),
				'message' => __('The file must be less then 2MB.'),
			),
		));
		
		$this->request->data[$this->FismaSystemFile->alias]['fisma_system_id'] = $fisma_system_id;
		
		if($raf !== null)
			$this->request->data[$this->FismaSystemFile->alias]['raf'] = $raf;
		
		if ($this->request->is('post')) 
		{
			$this->FismaSystemFile->create();
			if ($this->FismaSystemFile->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved.', __('FISMA System %s', $file_type)));
				return $this->redirect(array('controller' => 'fisma_systems', 'action' => 'view', $fisma_system_id, 'hash' => 'ui-tabs-2', 'saa' => false));
			}
			else
			{
				$this->Session->setFlash(__('The %s file could not be saved. Please, try again.', __('FISMA System %s', $file_type)));
			}
		}
		$this->set('fisma_system_file_states', $this->FismaSystemFile->FismaSystemFileState->find('list') );
		$this->set('raf', $raf);
	}
	
	public function saa_edit($id = null) 
	{
		$this->FismaSystemFile->recursive = -1;
		if (!$fisma_system_file = $this->FismaSystemFile->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA System %s', __('File'))));
		}
		
		$file_type = __('File');
		$raf = false;
		if($fisma_system_file['FismaSystemFile']['raf'])
		{
			$file_type = __('Risk Acceptance Form');
			$raf = true;
		}
		
		if ($this->request->is(array('post', 'put'))) 
		{
			if ($this->FismaSystemFile->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved.', __('FISMA System %s', $file_type)));
				return $this->redirect(array('controller' => 'fisma_systems', 'action' => 'view', $fisma_system_file['FismaSystemFile']['fisma_system_id'], 'hash' => 'ui-tabs-2', 'saa' => false));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('FISMA System %s', $file_type)));
			}
		}
		else
		{
			$this->request->data = $fisma_system_file;
		}
		$this->set('fisma_system_file_states', $this->FismaSystemFile->FismaSystemFileState->find('list') );
		$this->set('raf', $raf);
	}
	
	public function saa_delete($id = null)
	{
		$this->FismaSystemFile->recursive = -1;
		if (!$fisma_system_file = $this->FismaSystemFile->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA System %s', __('File'))));
		}
		
		$file_type = __('File');
		if($fisma_system_file['FismaSystemFile']['ras'])
			$file_type = __('Risk Acceptance Form');
		
		if ($this->FismaSystemFile->delete())
		{
			$this->Session->setFlash(__('The %s has been deleted.', __('FISMA System %s', $file_type)));
		}
		else
		{
			$this->Session->setFlash(__('The %s could not be deleted. Please, try again.', __('FISMA System %s', $file_type)));
		}
		
		return $this->redirect(array('controller' => 'fisma_systems', 'action' => 'view', $fisma_system_file['FismaSystemFile']['fisma_system_id'], 'hash' => 'ui-tabs-2', 'saa' => false));
	}
	
	public function admin_fisma_system($id = null, $ras = null) 
	{
		return $this->fisma_system($id, $ras);
	}
}
