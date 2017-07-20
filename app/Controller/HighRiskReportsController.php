<?php
class HighRiskReportsController extends AppController 
{
	public function db_tab_trend()
	{
		$stats = $this->HighRiskReport->findForTrend();
		
		$this->set(compact('stats'));
	}
	
	public function index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array();

		$this->HighRiskReport->recursive = 0;
		$this->paginate['conditions'] = $this->HighRiskReport->conditions($conditions, $this->passedArgs); 
		$this->set('high_risk_reports', $this->paginate());
	}
	
	public function tag($tag_id = null) 
	{
		if(!$tag_id) 
		{
			throw new NotFoundException(__('Invalid %s', __('Tag')));
		}
		
		$tag = $this->HighRiskReport->Tag->read(null, $tag_id);
		if(!$tag) 
		{
			throw new NotFoundException(__('Invalid %s', __('Tag')));
		}
		$this->set('tag', $tag);
		
		$this->Prg->commonProcess();
		
		$conditions = array();
		
		$conditions[] = $this->HighRiskReport->Tag->Tagged->taggedSql($tag['Tag']['keyname'], 'HighRiskReport');
		
		
		$this->HighRiskReport->recursive = 0;
		$this->paginate['conditions'] = $this->HighRiskReport->conditions($conditions, $this->passedArgs); 
		$this->set('high_risk_reports', $this->paginate());
	}
	
	public function view($id = false)
	{
		
		$this->HighRiskReport->id = $id;
		$this->HighRiskReport->recursive = 0;
		if (!$high_risk_report = $this->HighRiskReport->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('High Risk Report')));
		}
		
		$this->set('high_risk_report', $high_risk_report);
	}
	
	public function view_excel($id)
	{
		if (!$high_risk_report = $this->HighRiskReport->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('High Risk Report')));
		}
		
		$this->set('high_risk_report', $high_risk_report);
		$this->set('excel_html', $this->HighRiskReport->viewExcelFile($id));
	}
	
	public function high_risk_result($id = null) 
	{
		$this->Prg->commonProcess();
		
		if (!$high_risk_result = $this->HighRiskReport->HighRiskResult->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('High Risk Result')));
		}
		$this->set('high_risk_result', $high_risk_result);
		
		
		$conditions = array(
			'HighRiskReportHighRiskResult.high_risk_result_id' => $id,
		);
		
		$this->paginate['conditions'] = $this->HighRiskReport->HighRiskReportHighRiskResult->conditions($conditions, $this->passedArgs); 
		if(isset($this->request->params['ext']) and $this->request->params['ext'] === 'csv')
		{
			$this->HighRiskReport->HighRiskReportHighRiskResult->recursive = -1;
			$this->paginate['limit'] = $this->HighRiskReport->HighRiskReportHighRiskResult->find('count', array('conditions' => $this->paginate['conditions']));
			$this->layout = 'Utilities.../ajax_nodebug';
		}
		
		$this->HighRiskReport->HighRiskReportHighRiskResult->recursive = 0;
		$this->paginate['contain'] = array(	
			'HighRiskReport', 'HighRiskResult',
		);
		$this->set('high_risk_reports', $this->paginate('HighRiskReportHighRiskResult'));
		
		$page_subtitle = __('All');
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
	}

	public function admin_index() 
	{
		$this->bypassReferer = true;
		return $this->redirect(array('action' => 'index', 'admin' => false));
	}
	
	public function admin_view($id = false)
	{
		$this->bypassReferer = true;
		return $this->redirect(array('action' => 'view', $id, 'admin' => false));
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->HighRiskReport->create();
			
			$this->request->data['HighRiskReport']['added_user_id'] = AuthComponent::user('id');
			if ($results = $this->HighRiskReport->addReport($this->request->data))
			{
				$this->bypassReferer = true;
				
				// we have duplicates, have the user review the dupes
				if(count($results['duplicates']))
				{
					$this->Flash->success(__('The %s has been saved. %s new Results were added. %s changed duplicates found.', __('High Risk Report'), count($results['new_ids']), count($results['duplicates'])));
					Cache::write('high_risk_duplicates_'. $this->HighRiskReport->id, $results['duplicates']);
					return $this->redirect(array('action' => 'edit_duplicates', $this->HighRiskReport->id));
				}
				
				$this->Flash->success(__('The %s has been saved. %s new Results were added.', __('High Risk Report'), count($results['new_ids'])));
				return $this->redirect(array('action' => 'view', $this->HighRiskReport->id, 'admin' => false));
				
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('High Risk Report')));
			}
		}
	}
	
	public function admin_edit_duplicates($high_risk_report_id = false)
	{
		$this->HighRiskReport->id = $high_risk_report_id;
		$this->HighRiskReport->recursive = 1;
		$this->HighRiskReport->contain(array('Tag'));
		if (!$high_risk_report = $this->HighRiskReport->read(null, $high_risk_report_id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('High Risk Report')));
		}
		
		if ($this->request->is('post'))
		{
			$this->bypassReferer = true;
			if(!$this->request->data or !isset($this->request->data['HighRiskReport']))
			{
				Cache::delete('high_risk_duplicates_'. $this->HighRiskReport->id);
				$this->Flash->warning(__('None of the %s were updated.', __('High Risk Results')));
				return $this->redirect(array('action' => 'view', $this->HighRiskReport->id, 'admin' => false));
			}
			
			if ($this->HighRiskReport->HighRiskReportHighRiskResult->updateNewDuplicates($this->HighRiskReport->id, $this->request->data, AuthComponent::user('id')))
			{
				Cache::delete('high_risk_duplicates_'. $this->HighRiskReport->id);
				$this->Flash->success(__('The %s were updated.', __('High Risk Results')));
				return $this->redirect(array('action' => 'view', $this->HighRiskReport->id, 'admin' => false));
			}
			else
			{
				$this->Flash->error(__('Unable to save any of the %s.', __('High Risk Results')));
			}
		}
		
		$duplicates = Cache::read('high_risk_duplicates_'. $high_risk_report_id);
		if(!$duplicates)
			$duplicates = array();
			
		$this->set('duplicates', $duplicates);
		$this->set('high_risk_report', $high_risk_report);
		
		$reportsAssignableParties = $this->HighRiskReport->HighRiskResult->ReportsAssignableParty->typeFormListBlank();
		$reportsRemediations = $this->HighRiskReport->HighRiskResult->ReportsRemediation->typeFormListBlank();
		$reportsStatuses = $this->HighRiskReport->HighRiskResult->ReportsStatus->typeFormListBlank();
		$reportsSystemTypes = $this->HighRiskReport->HighRiskResult->ReportsSystemType->typeFormListBlank();
		$reportsVerifications = $this->HighRiskReport->HighRiskResult->ReportsVerification->typeFormListBlank();
		$this->set(compact(array('reportsSystemTypes', 'reportsVerifications', 
			'reportsRemediations', 'reportsStatuses', 'reportsAssignableParties',
		)));
	}
	
	public function admin_edit($id = null) 
	{
		$this->HighRiskReport->id = $id;
		$this->HighRiskReport->recursive = 1;
		$this->HighRiskReport->contain(array('Tag'));
		if (!$high_risk_report = $this->HighRiskReport->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('High Risk Report')));
		}
		
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->HighRiskReport->save($this->request->data)) 
			{
				$this->Flash->success(__('The %s has been saved', __('High Risk Report')));
				$this->bypassReferer = true;
				return $this->redirect(array('action' => 'view', $this->HighRiskReport->id, 'admin' => false));
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('High Risk Report')));
			}
		}
		else
		{
			$this->request->data = $high_risk_report;
		}
	}
	
	public function admin_delete($id = null) 
	{
		$this->HighRiskReport->id = $id;
		if (!$this->HighRiskReport->exists()) {
			throw new NotFoundException(__('Invalid %s', __('High Risk Report')));
		}
		if ($this->HighRiskReport->delete()) {
			$this->Flash->success(__('%s deleted', __('High Risk Report')));
			return $this->redirect(array('action' => 'index', 'admin' => false));
		}
		$this->Flash->error(__('%s was not deleted', __('High Risk Report')));
		return $this->redirect(array('action' => 'index', 'admin' => false));
	}
}