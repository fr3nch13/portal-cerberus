<?php
App::uses('AppController', 'Controller');

class EolSoftwaresController extends AppController 
{
	public $allowAdminDelete = true;
	
	public function menu_assignable_parties() 
	{
		$this->Prg->commonProcess();
		
		if (!$this->request->is('requested')) 
		{
			throw new NotFoundException(__('Invalid %s', __('Request')));
		}
			
		// format for the menu_items
		$items = array();
		$this->EolSoftware->ReportsAssignableParty->typeFormListOrder = array('name' => 'ASC');
		$reportsAssignableParties = $this->EolSoftware->ReportsAssignableParty->typeFormList();
		
		foreach($reportsAssignableParties as $reportsAssignableParty_id => $reportsAssignableParty_name)
		{
			$title = $reportsAssignableParty_name;
			
			$items[] = array(
				'title' => $title,
				'url' => array('controller' => 'eol_softwares', 'action' => 'index', 'field' => 'reports_assignable_party_id', 'value' => $reportsAssignableParty_id, 'admin' => false, 'saa' => false, 'plugin' => false)
			);
		}
		return $items;
	}
	
	public function menu_remediations() 
	{
		$this->Prg->commonProcess();
		
		if (!$this->request->is('requested')) 
		{
			throw new NotFoundException(__('Invalid %s', __('Request')));
		}
			
		// format for the menu_items
		$items = array();
		$this->EolSoftware->ReportsRemediation->typeFormListOrder = array('name' => 'ASC');
		$reportsRemediations = $this->EolSoftware->ReportsRemediation->typeFormList();
		
		foreach($reportsRemediations as $reportsRemediation_id => $reportsRemediation_name)
		{
			$title = $reportsRemediation_name;
			
			$items[] = array(
				'title' => $title,
				'url' => array('controller' => 'eol_softwares', 'action' => 'index', 'field' => 'reports_remediation_id', 'value' => $reportsRemediation_id, 'admin' => false, 'saa' => false, 'plugin' => false)
			);
		}
		return $items;
	}
	
	public function menu_verifications() 
	{
		$this->Prg->commonProcess();
		
		if (!$this->request->is('requested')) 
		{
			throw new NotFoundException(__('Invalid %s', __('Request')));
		}
			
		// format for the menu_items
		$items = array();
		$this->EolSoftware->ReportsVerification->typeFormListOrder = array('name' => 'ASC');
		$reportsVerifications = $this->EolSoftware->ReportsVerification->typeFormList();
		
		foreach($reportsVerifications as $reportsVerification_id => $reportsVerification_name)
		{
			$title = $reportsVerification_name;
			
			$items[] = array(
				'title' => $title,
				'url' => array('controller' => 'eol_softwares', 'action' => 'index', 'field' => 'reports_verification_id', 'value' => $reportsVerification_id, 'admin' => false, 'saa' => false, 'plugin' => false)
			);
		}
		return $items;
	}
	
	public function index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array();
		
		$reportsAssignableParties = $this->EolSoftware->ReportsAssignableParty->typeFormList();
		$reportsRemediations = $this->EolSoftware->ReportsRemediation->typeFormList();
		$reportsVerifications = $this->EolSoftware->ReportsVerification->typeFormList();
		$this->set(compact(array( 'reportsAssignableParties', 'reportsRemediations', 'reportsVerifications')));
		
		if(isset($this->passedArgs['field']) and isset($this->passedArgs['value'])) 
		{
			$field = $this->passedArgs['field'];
			if(strpos($field, '.') === false)
				$field = 'EolSoftware.'. $field;
			$conditions[$field] = $this->passedArgs['value'];
			
			if($this->passedArgs['field'] == 'reports_assignable_party_id' and isset($reportsAssignableParties[$this->passedArgs['value']]))
			{
				$reportsAssignableParty = $this->EolSoftware->ReportsAssignableParty->read(null, $this->passedArgs['value']);
				$page_subtitle = __('By %s: %s', __('Assignable Party'), $reportsAssignableParty['ReportsAssignableParty']['name']);
				$page_description = $reportsAssignableParty['ReportsAssignableParty']['details'];
			}
			
			if($this->passedArgs['field'] == 'reports_remediation_id' and isset($reportsRemediations[$this->passedArgs['value']]))
			{
				$reportsRemediation = $this->EolSoftware->ReportsRemediation->read(null, $this->passedArgs['value']);
				$page_subtitle = __('By %s: %s', __('Remediation'), $reportsRemediation['ReportsRemediation']['name']);
				$page_description = $reportsRemediation['ReportsRemediation']['details'];
			}
			
			if($this->passedArgs['field'] == 'reports_verification_id' and isset($reportsVerifications[$this->passedArgs['value']]))
			{
				$reportsVerification = $this->EolSoftware->ReportsVerification->read(null, $this->passedArgs['value']);
				$page_subtitle = __('By %s: %s', __('Verification'), $reportsVerification['ReportsVerification']['name']);
				$page_description = $reportsVerification['ReportsVerification']['details'];
			}
		}
		if(isset($this->request->params['ext']) and $this->request->params['ext'] === 'csv')
		{
			$this->paginate['limit'] = $this->paginate['maxLimit'] = $this->EolSoftware->find('count', array('conditions' => $this->paginate['conditions']));
			if(!$this->paginate['limit'])
				$this->paginate['empty'] = true;
			$this->layout = 'Utilities.../ajax_nodebug';
		}
		
		$this->EolSoftware->recursive = 0;
		$this->paginate['order'] = array('EolSoftware.name' => 'asc');
		$this->paginate['conditions'] = $this->EolSoftware->conditions($conditions, $this->passedArgs); 
		$this->set('eolSoftwares', $this->paginate());
	}
	
	public function view($id = false)
	{
		$this->EolSoftware->id = $id;
		if (!$eol_software = $this->EolSoftware->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('Software/Vulnerability')));
		}
		
		$this->set('eol_software', $eol_software);
	}
	
	public function saa_add() 
	{
		if ($this->request->is('post'))
		{
			$this->EolSoftware->create();
			
			if ($this->EolSoftware->save($this->request->data))
			{
				$this->Flash->success(__('The %s has been saved.', __('Software/Vulnerability')));
				return $this->redirect(array('action' => 'index', 'saa' => false));
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again. %s', __('Software/Vulnerability'), $this->EolSoftware->modelError));
			}
		}
		
		$reportsAssignableParties = $this->EolSoftware->ReportsAssignableParty->typeFormListBlank();
		$reportsRemediations = $this->EolSoftware->ReportsRemediation->typeFormListBlank();
		$reportsVerifications = $this->EolSoftware->ReportsVerification->typeFormListBlank();
		$this->set(compact(array('reportsAssignableParties', 'reportsRemediations', 'reportsVerifications')));
	}
	
	public function saa_edit($id = null) 
	{
		if (!$eolSoftware = $this->EolSoftware->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('Software/Vulnerability') ));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->EolSoftware->save($this->request->data)) 
			{
				$this->Flash->success(__('The %s has been saved', __('Software/Vulnerability')));
				return $this->redirect(array('action' => 'index', 'saa' => false));
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again. %s', __('Software/Vulnerability'), $this->EolSoftware->modelError));
			}
		}
		else
		{
			$this->request->data = $eolSoftware;
		}
		
		$reportsAssignableParties = $this->EolSoftware->ReportsAssignableParty->typeFormListBlank();
		$reportsRemediations = $this->EolSoftware->ReportsRemediation->typeFormListBlank();
		$reportsVerifications = $this->EolSoftware->ReportsVerification->typeFormListBlank();
		$this->set(compact(array('reportsAssignableParties', 'reportsRemediations', 'reportsVerifications')));
	}
	
	public function saa_makealias($id = null)
	{
		if (!$eolSoftware = $this->EolSoftware->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('Software/Vulnerability') ));
		}
		
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->EolSoftware->makeAlias($this->request->data)) 
			{
				$this->Flash->success(__('The %s has been moved to an alias.', __('Software/Vulnerability')));
				$this->bypassReferer = true;
				return $this->redirect(array('action' => 'index', 'saa' => false));
			}
			else
			{
				$this->Flash->error($this->EolSoftware->modelError);
			}
		}
		else
		{
			$this->request->data = $eolSoftware;
		}
		
		$eolSoftwares = $this->EolSoftware->typeFormList();
		$this->set(compact(array('eolSoftware', 'eolSoftwares')));
	}
	
	public function admin_index() 
	{
		return $this->index();
	}
}