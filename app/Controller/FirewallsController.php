<?php
App::uses('AppController', 'Controller');
/**
 * Firewalls Controller
 *
 * @property Firewalls $Firewall
 */
class FirewallsController extends AppController 
{

	public $allowAdminDelete = true;

//
	public function index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		// get the counts
		$this->Firewall->getCounts = array(
			'Rule' => array(
				'all' => array(),
			),
		);
		
		$this->Firewall->recursive = -1;
		$this->paginate['order'] = array('Firewall.name' => 'asc');
		$this->paginate['conditions'] = $this->Firewall->conditions($conditions, $this->passedArgs); 
		$this->set('firewalls', $this->paginate());
	}

//
	public function view($id = false)
	{
		
		$this->Firewall->id = $id;
		if (!$this->Firewall->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('Firewall')));
		}
		
		// get the counts
		$this->Firewall->getCounts = array(
			'Rule' => array(
				'all' => array(
					'conditions' => array(
						'Rule.firewall_id' => $id,
					),
				),
			),
		);
		
		$this->Firewall->recursive = 0;
		$firewall = $this->Firewall->read(null, $id);
		$compiled = array();
		
		if(isset($this->request->params['ext']) and $this->request->params['ext'] === 'txt')
		{	
			$this->Firewall->Rule->recursive = 0;
			$compiled = $this->Firewall->Rule->findAsa('all', array(
				'recursive' => 0,
				'conditions' => array('Rule.firewall_id' => $id),
			));
		}
		
		$this->set('firewall', $firewall);
		$this->set('compiled', $compiled);
	}

//
	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		$this->Firewall->recursive = -1;
		$this->paginate['order'] = array('Firewall.name' => 'asc');
		$this->paginate['conditions'] = $this->Firewall->conditions($conditions, $this->passedArgs); 
		$this->set('firewalls', $this->paginate());
	}

//
	public function admin_view($id = false)
	{
		
		$this->Firewall->id = $id;
		if (!$this->Firewall->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('Firewall')));
		}
		
		// get the counts
		$this->Firewall->getCounts = array(
			'Rule' => array(
				'all' => array(
					'conditions' => array(
						'Rule.firewall_id' => $id,
					),
				),
			),
		);
		$this->Firewall->recursive = 0;
		$this->set('firewall', $this->Firewall->read(null, $id));
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->Firewall->create();
			
			if ($this->Firewall->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved', __('Firewall')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('Firewall')));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		$this->Firewall->id = $id;
		if (!$this->Firewall->exists()) 
		{
			throw new NotFoundException(__('Invalid %s', __('Firewall')));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->Firewall->save($this->request->data)) 
			{
				$this->Session->setFlash(__('The %s has been saved', __('Firewall')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('Firewall')));
			}
		}
		else
		{
			$this->request->data = $this->Firewall->read(null, $id);
		}
	}
}
