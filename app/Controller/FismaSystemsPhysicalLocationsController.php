<?php
App::uses('AppController', 'Controller');

class FismaSystemsPhysicalLocationsController extends AppController 
{
	public $uses = array('FismaSystemPhysicalLocation');
	
	public function physical_location($physical_location_id = false) 
	{
		$this->Prg->commonProcess();
		
		$this->FismaSystemPhysicalLocation->PhysicalLocation->recursive = -1;
		if(!$physicalLocation = $this->FismaSystemPhysicalLocation->PhysicalLocation->read(null, $physical_location_id))
		{
			throw new NotFoundException(__('Unknown %s', __('Physical Location')));
		}
		$this->set('physicalLocation', $physicalLocation);
		
		$conditions = array(
			'FismaSystemPhysicalLocation.physical_location_id' => $physical_location_id, 
		);
		
		$this->FismaSystemPhysicalLocation->recursive = 0;
		$this->paginate['order'] = array('FismaSystem.name' => 'asc');
		$this->paginate['conditions'] = $this->FismaSystemPhysicalLocation->conditions($conditions, $this->passedArgs);
		$this->set('fismaSystems', $this->paginate());
	}
	
	public function fisma_system($fisma_system_id = false) 
	{
		$this->Prg->commonProcess();
		
		$this->FismaSystemPhysicalLocation->FismaSystem->recursive = -1;
		if(!$fismaSystem = $this->FismaSystemPhysicalLocation->FismaSystem->read(null, $fisma_system_id))
		{
			throw new NotFoundException(__('Unknown %s', __('FISMA System')));
		}
		$this->set('fismaSystem', $fismaSystem);
		
		$conditions = array(
			'FismaSystemPhysicalLocation.fisma_system_id' => $fisma_system_id, 
		);
		
		$this->FismaSystemPhysicalLocation->recursive = 0;
		$this->paginate['order'] = array('PhysicalLocation.name' => 'asc');
		$this->paginate['conditions'] = $this->FismaSystemPhysicalLocation->conditions($conditions, $this->passedArgs);
		$this->set('physicalLocations', $this->paginate());
	}
	
	public function saa_edit_locations($fisma_system_id = false) 
	{
		$this->FismaSystemPhysicalLocation->FismaSystem->recursive = 1;
		if(!$fismaSystem = $this->FismaSystemPhysicalLocation->FismaSystem->read(null, $fisma_system_id))
		{
			throw new NotFoundException(__('Unknown %s', __('FISMA System')));
		}
		$this->set('fismaSystem', $fismaSystem);
		
		if ($this->request->is('post'))
		{
			if ($this->FismaSystemPhysicalLocation->saveAssociatedLocations($fisma_system_id, $this->request->data['PhysicalLocation']))
			{
				$this->Flash->success(__('The %s have been added to the %s', __('Physical Locations'), __('FISMA System')));
				$this->bypassReferer = true;
				return $this->redirect(array('saa' => false, 'controller' => 'fisma_systems', 'action' => 'view', $fisma_system_id, 'tab' => 'locations'));
			}
			else
			{
				$this->Flash->error(__('The %s could NOT be added to the %s. Please, try again.', __('Physical Locations'), __('FISMA System')));
			}
		}
		
		$physicalLocation_ids = $this->FismaSystemPhysicalLocation->getLocationIds($fisma_system_id);
		$physicalLocations = $this->FismaSystemPhysicalLocation->PhysicalLocation->find('all');
		$this->set(compact('physicalLocations', 'physicalLocation_ids'));

	}
	
	public function saa_edit_systems($physical_location_id = false) 
	{
		$this->FismaSystemPhysicalLocation->PhysicalLocation->recursive = 1;
		if(!$physicalLocation = $this->FismaSystemPhysicalLocation->PhysicalLocation->read(null, $physical_location_id))
		{
			throw new NotFoundException(__('Unknown %s', __('Physical Location')));
		}
		$this->set('physicalLocation', $physicalLocation);
		
		if ($this->request->is('post'))
		{
			if ($this->FismaSystemPhysicalLocation->saveAssociatedSystems($physical_location_id, $this->request->data['FismaSystem']))
			{
				$this->Flash->success(__('The %s have been added to the %s', __('FISMA Systems'), __('Physical Location')));
				$this->bypassReferer = true;
				return $this->redirect(array('saa' => false, 'controller' => 'physical_locations', 'action' => 'view', $physical_location_id, 'tab' => 'fisma_systems'));
			}
			else
			{
				$this->Flash->error(__('The %s could NOT be added to the %s. Please, try again.', __('FISMA Systems'), __('Physical Location')));
			}
		}
		
		$fismaSystem_ids = $this->FismaSystemPhysicalLocation->getSystemIds($physical_location_id);
		$fismaSystems = $this->FismaSystemPhysicalLocation->FismaSystem->find('all', array('order' => array('FismaSystem.name' => 'asc') ));
		$this->set(compact('fismaSystems', 'fismaSystem_ids'));

	}
	
	public function saa_delete($id = null) 
	{
		$this->FismaSystemPhysicalLocation->id = $id;
		if (!$this->FismaSystemPhysicalLocation->exists()) 
		{
			throw new NotFoundException(__('Invalid %s', __('Physical Location')));
		}
		
		if ($this->FismaSystemPhysicalLocation->delete()) 
		{
			$this->Flash->success(__('The %s/%s relationship has been removed.', __('FISMA System'), __('Physical Location')));
		} 
		else 
		{
			$this->Flash->error(__('The %s/%s relationship could not be deleted. Please, try again.', __('FISMA System'), __('Physical Location')));
		}
		return $this->redirect($this->referer());
	}
	
	public function admin_fisma_system($id = null) 
	{
		return $this->fisma_system($id);
	}
}
