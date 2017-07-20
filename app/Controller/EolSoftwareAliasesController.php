<?php
App::uses('AppController', 'Controller');

class EolSoftwareAliasesController extends AppController 
{
	public $allowAdminDelete = true;
	
	public function index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array();
		$conditions = array_merge($conditions, $this->conditions);
		
		if(isset($this->request->params['ext']) and $this->request->params['ext'] === 'csv')
		{
			$this->paginate['limit'] = $this->paginate['maxLimit'] = $this->EolSoftwareAlias->find('count', array('conditions' => $this->paginate['conditions']));
			if(!$this->paginate['limit'])
				$this->paginate['empty'] = true;
			$this->layout = 'Utilities.../ajax_nodebug';
		}
		
		$this->EolSoftwareAlias->recursive = 0;
		$this->paginate['order'] = array('EolSoftwareAlias.name' => 'asc');
		$this->paginate['conditions'] = $this->EolSoftwareAlias->conditions($conditions, $this->passedArgs); 
		$this->set('eolSoftwareAliases', $this->paginate());
	}
	
	public function eol_software($eol_software_id = false)
	{
		$this->EolSoftwareAlias->EolSoftware->id = $eol_software_id;
		if (!$eol_software = $this->EolSoftwareAlias->EolSoftware->read(null, $eol_software_id))
		{
			throw new NotFoundException(__('Invalid %s', __('EOL/US Software')));
		}
		
		$this->set('eol_software', $eol_software);
		
		$page_subtitle = __('All');
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
		
		$conditions = array(
			'EolSoftwareAlias.eol_software_id' => $eol_software_id,
		); 
		
		$this->conditions = $conditions;
		$this->index(); 
		
	}
}