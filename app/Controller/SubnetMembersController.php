<?php
class SubnetMembersController extends AppController 
{
	
	public function admin_fisma_inventory($fisma_inventory_id = false) 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
			'SubnetMember.fisma_inventory_id' => $fisma_inventory_id,
		); 
		
		$this->paginate['contain'] = array('Subnet');
		$this->paginate['order'] = array('SubnetMember.created' => 'desc');
		$this->paginate['conditions'] = $this->SubnetMember->conditions($conditions, $this->passedArgs); 
		$this->set('subnet_members', $this->paginate());
		
		if($this->countChecked) return true;
		
		$this->SubnetMember->FismaInventory->recursive = -1;
		if (!$fisma_inventory = $this->SubnetMember->FismaInventory->read(null, $fisma_inventory_id))
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA Inventory')));
		}
		$this->set('fisma_inventory', $fisma_inventory);
	}
	
	public function admin_fisma_inventories($subnet_id = false) 
	{
		$this->Prg->commonProcess();
		
		$this->SubnetMember->Subnet->recursive = -1;
		if (!$subnet = $this->SubnetMember->Subnet->read(null, $subnet_id))
		{
			throw new NotFoundException(__('Invalid %s', __('Subnet')));
		}
		$this->set('subnet', $subnet);
		
		$conditions = array(
			'SubnetMember.subnet_id' => $subnet_id,
			'SubnetMember.fisma_inventory_id !=' => 0,
		);
		
		$this->paginate['contain'] = array('FismaInventory', 'FismaInventory.FismaSystem', 'FismaInventory.FismaType', 
			'FismaInventory.FismaStatus', 'FismaInventory.FismaSource', 'FismaInventory.Tag');
		$this->paginate['order'] = array('SubnetMember.created' => 'desc');
		$this->paginate['conditions'] = $this->SubnetMember->conditions($conditions, $this->passedArgs); 
		$this->set('subnet_members', $this->paginate());
	}
	
	public function admin_fisma_inventories_stats($subnet_id = false) 
	{
		$fisma_inventories_stats = $this->SubnetMember->getSubnetFismaInventoriesStats($subnet_id);
		
		$this->set(compact('fisma_inventories_stats'));
		$this->layout = 'ajax_nodebug';
	}
	
	public function us_result($us_result_id = false) 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
			'SubnetMember.us_result_id' => $us_result_id,
		); 
		
		$this->paginate['contain'] = array('Subnet');
		$this->paginate['order'] = array('SubnetMember.created' => 'desc');
		$this->paginate['conditions'] = $this->SubnetMember->conditions($conditions, $this->passedArgs); 
		$this->set('subnet_members', $this->paginate());
		
		if($this->countChecked) return true;
		
		$this->SubnetMember->UsResult->recursive = -1;
		if (!$us_result = $this->SubnetMember->UsResult->read(null, $us_result_id))
		{
			throw new NotFoundException(__('Invalid %s', __('US Result')));
		}
		$this->set('us_result', $us_result);
	}
	
	public function admin_us_result($us_result_id = false) 
	{
		return $this->us_result($us_result_id);
	}
	
	public function admin_us_results($subnet_id = false) 
	{
		$this->Prg->commonProcess();
		
		$this->SubnetMember->Subnet->recursive = -1;
		if (!$subnet = $this->SubnetMember->Subnet->read(null, $subnet_id))
		{
			throw new NotFoundException(__('Invalid %s', __('Subnet')));
		}
		$this->set('subnet', $subnet);
		
		$conditions = array(
			'SubnetMember.subnet_id' => $subnet_id,
			'SubnetMember.us_result_id !=' => 0,
		);
		
		$this->paginate['contain'] = array('UsResult', 'UsResult.EolSoftware', 'UsResult.ReportsOrganization', 
			'UsResult.ReportsRemediation', 'UsResult.ReportsVerification', 'UsResult.ReportsStatus', 
			'UsResult.ReportsAssignableParty');
		$this->paginate['order'] = array('SubnetMember.created' => 'desc');
		$this->paginate['conditions'] = $this->SubnetMember->conditions($conditions, $this->passedArgs); 
		$this->set('subnet_members', $this->paginate());
	}
	
	public function admin_us_results_stats($subnet_id = false) 
	{
		$us_results_stats = $this->SubnetMember->getSubnetUsResultsStats($subnet_id);
		
		$this->set(compact('us_results_stats'));
		$this->layout = 'ajax_nodebug';
	}
	
	public function eol_result($eol_result_id = false) 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
			'SubnetMember.eol_result_id' => $eol_result_id,
		); 
		
		$this->paginate['contain'] = array('Subnet');
		$this->paginate['order'] = array('SubnetMember.created' => 'desc');
		$this->paginate['conditions'] = $this->SubnetMember->conditions($conditions, $this->passedArgs); 
		$this->set('subnet_members', $this->paginate());
		
		if($this->countChecked) return true;
		
		$this->SubnetMember->EolResult->recursive = -1;
		if (!$eol_result = $this->SubnetMember->EolResult->read(null, $eol_result_id))
		{
			throw new NotFoundException(__('Invalid %s', __('EOL Result')));
		}
		$this->set('eol_result', $eol_result);
	}
	
	public function admin_eol_result($eol_result_id = false) 
	{
		return $this->eol_result($eol_result_id);
	}
	
	public function admin_eol_results($subnet_id = false) 
	{
		$this->Prg->commonProcess();
		
		$this->SubnetMember->Subnet->recursive = -1;
		if (!$subnet = $this->SubnetMember->Subnet->read(null, $subnet_id))
		{
			throw new NotFoundException(__('Invalid %s', __('Subnet')));
		}
		$this->set('subnet', $subnet);
		
		$conditions = array(
			'SubnetMember.subnet_id' => $subnet_id,
			'SubnetMember.eol_result_id !=' => 0,
		);
		
		$this->paginate['contain'] = array('EolResult', 'EolResult.EolSoftware', 'EolResult.ReportsOrganization', 
			'EolResult.ReportsRemediation', 'EolResult.ReportsVerification', 'EolResult.ReportsStatus', 
			'EolResult.ReportsAssignableParty');
		$this->paginate['order'] = array('SubnetMember.created' => 'desc');
		$this->paginate['conditions'] = $this->SubnetMember->conditions($conditions, $this->passedArgs); 
		$this->set('subnet_members', $this->paginate());
	}
	
	public function admin_eol_results_stats($subnet_id = false) 
	{
		$eol_results_stats = $this->SubnetMember->getSubnetEolResultsStats($subnet_id);
		
		$this->set(compact('eol_results_stats'));
		$this->layout = 'ajax_nodebug';
	}
	
	public function pen_test_result($pen_test_result_id = false) 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
			'SubnetMember.pen_test_result_id' => $pen_test_result_id,
		); 
		
		$this->paginate['contain'] = array('Subnet');
		$this->paginate['order'] = array('SubnetMember.created' => 'desc');
		$this->paginate['conditions'] = $this->SubnetMember->conditions($conditions, $this->passedArgs); 
		$this->set('subnet_members', $this->paginate());
		
		if($this->countChecked) return true;
		
		$this->SubnetMember->PenTestResult->recursive = -1;
		if (!$pen_test_result = $this->SubnetMember->PenTestResult->read(null, $pen_test_result_id))
		{
			throw new NotFoundException(__('Invalid %s', __('FISMA Inventory')));
		}
		$this->set('pen_test_result', $pen_test_result);
	}
	
	public function admin_pen_test_result($pen_test_result_id = false) 
	{
		return $this->pen_test_result($pen_test_result_id);
	}
	
	public function admin_pen_test_results($subnet_id = false) 
	{
		$this->Prg->commonProcess();
		
		$this->SubnetMember->Subnet->recursive = -1;
		if (!$subnet = $this->SubnetMember->Subnet->read(null, $subnet_id))
		{
			throw new NotFoundException(__('Invalid %s', __('Subnet')));
		}
		$this->set('subnet', $subnet);
		
		$conditions = array(
			'SubnetMember.subnet_id' => $subnet_id,
			'SubnetMember.pen_test_result_id !=' => 0,
		);
		
		$this->paginate['contain'] = array('PenTestResult', 'PenTestResult.PenTestReport', 'PenTestResult.ReportsOrganization', 
			'PenTestResult.ReportsRemediation', 'PenTestResult.ReportsVerification', 'PenTestResult.ReportsStatus', 
			'PenTestResult.ReportsAssignableParty', 'PenTestResult.ReportsSeverity');
		$this->paginate['order'] = array('SubnetMember.created' => 'desc');
		$this->paginate['conditions'] = $this->SubnetMember->conditions($conditions, $this->passedArgs); 
		$this->set('subnet_members', $this->paginate());
	}
	
	public function admin_pen_test_results_stats($subnet_id = false) 
	{
		$pen_test_results_stats = $this->SubnetMember->getSubnetPenTestResultsStats($subnet_id);
		
		$this->set(compact('pen_test_results_stats'));
		$this->layout = 'ajax_nodebug';
	}
	
	public function high_risk_result($high_risk_result_id = false) 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
			'SubnetMember.high_risk_result_id' => $high_risk_result_id,
		); 
		
		$this->paginate['contain'] = array('Subnet');
		$this->paginate['order'] = array('SubnetMember.created' => 'desc');
		$this->paginate['conditions'] = $this->SubnetMember->conditions($conditions, $this->passedArgs); 
		$this->set('subnet_members', $this->paginate());
		
		if($this->countChecked) return true;
		
		$this->SubnetMember->HighRiskResult->recursive = -1;
		if (!$high_risk_result = $this->SubnetMember->HighRiskResult->read(null, $high_risk_result_id))
		{
			throw new NotFoundException(__('Invalid %s', __('High Risk Result')));
		}
		$this->set('high_risk_result', $high_risk_result);
	}
	
	public function admin_high_risk_result($high_risk_result_id = false) 
	{
		return $this->high_risk_result($high_risk_result_id);
	}
	
	public function admin_high_risk_results($subnet_id = false) 
	{
		$this->Prg->commonProcess();
		
		$this->SubnetMember->Subnet->recursive = -1;
		if (!$subnet = $this->SubnetMember->Subnet->read(null, $subnet_id))
		{
			throw new NotFoundException(__('Invalid %s', __('Subnet')));
		}
		$this->set('subnet', $subnet);
		
		$conditions = array(
			'SubnetMember.subnet_id' => $subnet_id,
			'SubnetMember.high_risk_result_id !=' => 0,
		);
		
		$this->paginate['contain'] = array(
			'HighRiskResult',
			'HighRiskResult.ReportsRemediation', 'HighRiskResult.ReportsVerification', 'HighRiskResult.ReportsStatus', 
			'HighRiskResult.ReportsAssignableParty'
		);
		$this->paginate['order'] = array('SubnetMember.created' => 'desc');
		$this->paginate['conditions'] = $this->SubnetMember->conditions($conditions, $this->passedArgs); 
		$this->set('subnet_members', $this->paginate());
	}
	
	public function admin_high_risk_results_stats($subnet_id = false) 
	{
		$high_risk_results_stats = $this->SubnetMember->getSubnetHighRiskResultsStats($subnet_id);
		
		$this->set(compact('high_risk_results_stats'));
		$this->layout = 'ajax_nodebug';
	}
}