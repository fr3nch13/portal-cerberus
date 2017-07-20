<?php
App::uses('AppController', 'Controller');
/**
 * FismaInventoryFiles Controller
 *
 * @property FismaInventoryFile $FismaInventoryFile
 * @property PaginatorComponent $Paginator
 */
class FismaInventoryFilesController extends AppController 
{
	public function fisma_inventory($fisma_inventory_id = null) 
	{
		if (!$this->FismaInventoryFile->FismaInventory->exists($fisma_inventory_id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA Inventory')));
		}
		$this->set('fisma_inventory_id', $fisma_inventory_id);
		
		$this->Prg->commonProcess();
		
		$conditions = array(
			'FismaInventoryFile.fisma_inventory_id' => $fisma_inventory_id,
		); 
		
		$this->FismaInventoryFile->FismaInventory->recursive = -1;
		$this->set('FismaInventory', $this->FismaInventoryFile->FismaInventory->read(null, $fisma_inventory_id));
		
		$this->FismaInventoryFile->recursive = -1;
		$this->paginate['order'] = array('FismaInventoryFile.created' => 'desc');
		$this->paginate['conditions'] = $this->FismaInventoryFile->conditions($conditions, $this->passedArgs); 
		
		$this->set('fisma_inventory_files', $this->paginate());
	}
	
	public function saa_add($fisma_inventory_id = null) 
	{
		if (!$this->FismaInventoryFile->FismaInventory->exists($fisma_inventory_id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA Inventory')));
		}
		
		$this->request->data[$this->FismaInventoryFile->alias]['fisma_inventory_id'] = $fisma_inventory_id;
		
		if ($this->request->is('post')) 
		{
			$this->FismaInventoryFile->create();
			if ($this->FismaInventoryFile->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved.', __('FISMA Inventory %s', __('File'))));
				return $this->redirect(array('controller' => 'fisma_inventories', 'action' => 'view', $fisma_inventory_id, 'saa' => false));
			}
			else
			{
				$this->Session->setFlash(__('The %s file could not be saved. Please, try again.', __('FISMA Inventory %s', __('File'))));
			}
		}
	}
	
	public function saa_edit($id = null) 
	{
		$this->FismaInventoryFile->recursive = -1;
		if (!$fisma_inventory_file = $this->FismaInventoryFile->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA Inventory %s', __('File'))));
		}
		
		if ($this->request->is(array('post', 'put'))) 
		{
			if ($this->FismaInventoryFile->save($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved.', __('FISMA Inventory %s', __('File'))));
				return $this->redirect(array('controller' => 'fisma_inventories', 'action' => 'view', $fisma_inventory_file['FismaInventoryFile']['fisma_inventory_id'], 'saa' => false));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('FISMA Inventory %s', __('File'))));
			}
		}
		else
		{
			$this->request->data = $fisma_inventory_file;
		}
	}
	
	public function saa_delete($id = null)
	{
		$this->FismaInventoryFile->recursive = -1;
		if (!$fisma_inventory_file = $this->FismaInventoryFile->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA Inventory %s', __('File'))));
		}
		
		if ($this->FismaInventoryFile->delete())
		{
			$this->Session->setFlash(__('The %s has been deleted.', __('FISMA Inventory %s', __('File'))));
		}
		else
		{
			$this->Session->setFlash(__('The %s could not be deleted. Please, try again.', __('FISMA Inventory %s', __('File'))));
		}
		
		return $this->redirect(array('controller' => 'fisma_inventories', 'action' => 'view', $fisma_inventory_file['FismaInventoryFile']['fisma_inventory_id'], 'saa' => false));
	}
}
