<?php
App::uses('AppController', 'Controller');
/**
 * FismaInventoryLogs Controller
 *
 * @property FismaInventoryLog $FismaInventoryLog
 * @property PaginatorComponent $Paginator
 */
class FismaInventoryLogsController extends AppController 
{

//
	public function fisma_inventory($id = null) 
	{
		$this->FismaInventoryLog->FismaInventory->id = $id;
		if (!$this->FismaInventoryLog->FismaInventory->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA Inventory')));
		}
		
		$this->Prg->commonProcess();
		
		$conditions = array(
			'FismaInventoryLog.fisma_inventory_id' => $id,
		);
		
		$this->FismaInventoryLog->recursive = 0;
		$this->paginate['order'] = array('FismaInventoryLog.created' => 'desc');
		$this->paginate['conditions'] = $this->FismaInventoryLog->conditions($conditions, $this->passedArgs); 
		$fisma_inventory_logs = $this->FismaInventoryLog->changeLog($this->paginate());
		$this->set('fisma_inventory_logs', $fisma_inventory_logs);
	}
}
