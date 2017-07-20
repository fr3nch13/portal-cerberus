<?php
App::uses('AppController', 'Controller');
/**
 * FismaSoftwareFismaSystems Controller
 *
 * @property FismaSoftwareFismaSystem $FismaSoftwareFismaSystem
 */
class FismaSoftwaresFismaSystemsController extends AppController 
{
	public $uses = array('FismaSoftwareFismaSystem');
	
	public function fisma_software($fisma_software_id = false) 
	{
		$this->Prg->commonProcess();
		
		$this->FismaSoftwareFismaSystem->FismaSoftware->recursive = -1;
		if(!$fisma_software = $this->FismaSoftwareFismaSystem->FismaSoftware->read(null, $fisma_software_id))
		{
			throw new NotFoundException(__('Unknown %s', __('FISMA Software')));
		}
		$this->set('fisma_software', $fisma_software);
		
		$conditions = array(
			'FismaSoftwareFismaSystem.fisma_software_id' => $fisma_software_id, 
		);
		
		$this->FismaSoftwareFismaSystem->recursive = 1;
		$this->paginate['conditions'] = $this->FismaSoftwareFismaSystem->conditions($conditions, $this->passedArgs);
		$this->set('fisma_softwares_fisma_systems', $this->paginate(''));
	}
	
	public function fisma_system($fisma_system_id = false) 
	{
		$this->Prg->commonProcess();
		
		$this->FismaSoftwareFismaSystem->FismaSystem->recursive = -1;
		if(!$fisma_system = $this->FismaSoftwareFismaSystem->FismaSystem->read(null, $fisma_system_id))
		{
			throw new NotFoundException(__('Unknown %s', __('FISMA System')));
		}
		$this->set('fisma_system', $fisma_system);
		
		$conditions = array(
			'FismaSoftwareFismaSystem.fisma_system_id' => $fisma_system_id, 
			'FismaSoftware.approved' => true, 
		);
		
		$this->FismaSoftwareFismaSystem->recursive = 2;
		$this->paginate['contain'] = array('FismaSoftware.Tag', 'FismaSoftware.FismaSoftwareGroup', 'FismaSoftware.FismaSoftwareSource');
		$this->paginate['conditions'] = $this->FismaSoftwareFismaSystem->conditions($conditions, $this->passedArgs);
		$this->set('fisma_softwares_fisma_systems', $this->paginate());
	}
	
	public function saa_add_softwares($fisma_system_id = false) 
	{
		$this->FismaSoftwareFismaSystem->FismaSystem->recursive = 1;
		if(!$fisma_system = $this->FismaSoftwareFismaSystem->FismaSystem->read(null, $fisma_system_id))
		{
			throw new NotFoundException(__('Unknown %s', __('FISMA System')));
		}
		$this->set('fisma_system', $fisma_system);
		
		if ($this->request->is('post'))
		{
			if ($this->FismaSoftwareFismaSystem->saveAssociatedSoftwares($fisma_system_id, $this->request->data['FismaSoftwareFismaSystem']['FismaSoftware']))
			{
				$this->Session->setFlash(__('The %s have been added to the %s', __('FISMA Software'), __('FISMA System')));
				return $this->redirect(array('controller' => 'fisma_systems', 'action' => 'view', $fisma_system_id, 'saa' => false));
			}
			else
			{
				$this->Session->setFlash(__('The %s could NOT be added to the %s. Please, try again.', __('FISMA Software'), __('FISMA System')));
			}
		}
		
		
		$fismaSoftwares = $this->FismaSoftwareFismaSystem->FismaSoftware->listByGroup();
		$this->set(compact('fismaSoftwares'));

	}
	
	public function saa_add_systems($fisma_software_id = false) 
	{
		$this->FismaSoftwareFismaSystem->FismaSoftware->recursive = 1;
		if(!$fisma_software = $this->FismaSoftwareFismaSystem->FismaSoftware->read(null, $fisma_software_id))
		{
			throw new NotFoundException(__('Unknown %s', __('FISMA Software')));
		}
		$this->set('fisma_software', $fisma_software);
		
		if ($this->request->is('post'))
		{
			if ($this->FismaSoftwareFismaSystem->saveAssociatedSystems($fisma_software_id, $this->request->data['FismaSoftwareFismaSystem']['FismaSystem']))
			{
				$this->Session->setFlash(__('The %s have been added to the %s', __('FISMA Systems'), __('FISMA Software')));
				return $this->redirect(array('controller' => 'fisma_softwares', 'action' => 'view', $fisma_software_id, 'saa' => false));
			}
			else
			{
				$this->Session->setFlash(__('The %s could NOT be added to the %s. Please, try again.', __('FISMA Systems'), __('FISMA Software')));
			}
		}
		
		
		$fismaSystems = $this->FismaSoftwareFismaSystem->FismaSystem->find('list');
		$this->set(compact('fismaSystems'));

	}
	
	public function saa_delete($id = null) 
	{
		$this->FismaSoftwareFismaSystem->id = $id;
		if (!$this->FismaSoftwareFismaSystem->exists()) 
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA Software')));
		}
		
		if ($this->FismaSoftwareFismaSystem->delete()) 
		{
			$this->Session->setFlash(__('The %s/%s relation has been removed.', __('FISMA System'), __('FISMA Software')));
		} 
		else 
		{
			$this->Session->setFlash(__('The %s/%s could not be deleted. Please, try again.', __('FISMA System'), __('FISMA Software')));
		}
		return $this->redirect($this->referer());
	}
	
	public function admin_fisma_system($id = null) 
	{
		return $this->fisma_system($id);
	}
}
