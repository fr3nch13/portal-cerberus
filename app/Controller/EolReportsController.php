<?php
class EolReportsController extends AppController 
{
	public function db_tab_trend()
	{
		$stats = $this->EolReport->findForTrend();
		
		$this->set(compact('stats'));
	}

	public function index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array();
		
		$this->paginate['conditions'] = $this->EolReport->conditions($conditions, $this->passedArgs); 
		$this->set('eol_reports', $this->paginate());
	}
	
	public function eol_result($id = null) 
	{
		$this->Prg->commonProcess();
		
		if (!$eol_result = $this->EolReport->EolResult->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('EOL Result')));
		}
		$this->set('eol_result', $eol_result);
		
		
		$conditions = array(
			'EolReportEolResult.eol_result_id' => $id,
		);
		
		$this->paginate['conditions'] = $this->EolReport->EolReportEolResult->conditions($conditions, $this->passedArgs); 
		if(isset($this->request->params['ext']) and $this->request->params['ext'] === 'csv')
		{
			$this->EolReport->EolReportEolResult->recursive = -1;
			$this->paginate['limit'] = $this->EolReport->EolReportEolResult->find('count', array('conditions' => $this->paginate['conditions']));
			$this->layout = 'Utilities.../ajax_nodebug';
		}
		
		$this->paginate['order'] = array('EolReportEolResult.created' => 'desc');
		$this->paginate['contain'] = array('EolReport', 'EolResult', 'EolResult.ReportsOrganization');
		$this->set('eol_reports', $this->paginate('EolReportEolResult'));
		
		$page_subtitle = __('All');
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
	}
	
	public function tag($tag_id = null) 
	{
		if(!$tag_id) 
		{
			throw new NotFoundException(__('Invalid %s', __('Tag')));
		}
		
		$tag = $this->EolReport->Tag->read(null, $tag_id);
		if(!$tag) 
		{
			throw new NotFoundException(__('Invalid %s', __('Tag')));
		}
		$this->set('tag', $tag);
		
		$this->Prg->commonProcess();
		
		$conditions = array();
		
		// include all if they're an admin
		if(AuthComponent::user('role') != 'admin')
			$conditions['EolReport.approved'] = true;
		
		$conditions[] = $this->EolReport->Tag->Tagged->taggedSql($tag['Tag']['keyname'], 'EolReport');
		
		$order = array('EolReport.name' => 'asc');
		
		
		$this->paginate['order'] = $order;
		$this->paginate['conditions'] = $this->EolReport->conditions($conditions, $this->passedArgs); 
		$this->set('eol_reports', $this->paginate());
	}
	
	public function view($id = false)
	{
		
		$this->EolReport->id = $id;
		$this->EolReport->recursive = 0;
		if (!$eol_report = $this->EolReport->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('EOL Report')));
		}
		
		$this->set('eol_report', $eol_report);
	}
	
	public function view_excel($id)
	{
		if (!$eol_report = $this->EolReport->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('EOL Report')));
		}
		
		$this->set('eol_report', $eol_report);
		$this->set('excel_html', $this->EolReport->viewExcelFile($id));
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
			$this->EolReport->create();
			
			$this->request->data['EolReport']['added_user_id'] = AuthComponent::user('id');
			if ($results = $this->EolReport->addReport($this->request->data))
			{
				$this->bypassReferer = true;
				$this->Flash->success(__('The %s has been saved. %s new Results were added.', __('EOL Report'), count($results['new_ids'])));
				
				// we have duplicates, have the user review the dupes
				if(count($results['duplicates']))
				{
					$this->Flash->success(__('The %s has been saved. %s new Results were added. %s changed duplicates found.', __('EOL Report'), count($results['new_ids']), count($results['duplicates'])));
					Cache::write('eol_duplicates_'. $this->EolReport->id, $results['duplicates']);
					return $this->redirect(array('action' => 'edit_duplicates', $this->EolReport->id));
				}
				
				return $this->redirect(array('action' => 'view', $this->EolReport->id, 'admin' => false));
				
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('EOL Report')));
			}
		}
	}
	
	public function admin_edit_duplicates($eol_report_id = false)
	{
		$this->EolReport->id = $eol_report_id;
		$this->EolReport->recursive = 1;
		$this->EolReport->contain(array('Tag'));
		if (!$eol_report = $this->EolReport->read(null, $eol_report_id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('EOL Report')));
		}
		
		if ($this->request->is('post'))
		{
			$this->bypassReferer = true;
			if(!$this->request->data or !isset($this->request->data['EolReport']))
			{
				Cache::delete('eol_duplicates_'. $this->EolReport->id);
				$this->Flash->error(__('None of the %s were updated.', __('EOL Results')));
				return $this->redirect(array('action' => 'view', $this->EolReport->id, 'admin' => false));
			}
			
			if ($this->EolReport->EolReportEolResult->updateNewDuplicates($this->EolReport->id, $this->request->data, AuthComponent::user('id')))
			{
				Cache::delete('eol_duplicates_'. $this->EolReport->id);
				$this->Flash->success(__('The %s were updated.', __('EOL Results')));
				return $this->redirect(array('action' => 'view', $this->EolReport->id, 'admin' => false));
			}
		}
		
		$duplicates = Cache::read('eol_duplicates_'. $eol_report_id);
		if(!$duplicates)
			$duplicates = array();
			
		$this->set('duplicates', $duplicates);
		$this->set('eol_report', $eol_report);
		
		
		$reportsOrganizations = $this->EolReport->EolResult->ReportsOrganization->typeFormListBlank();
		$reportsRemediations = $this->EolReport->EolResult->ReportsRemediation->typeFormListBlank();
		$reportsVerifications = $this->EolReport->EolResult->ReportsVerification->typeFormListBlank();
		$reportsStatuses = $this->EolReport->EolResult->ReportsStatus->typeFormListBlank();
		$reportsAssignableParties = $this->EolReport->EolResult->ReportsAssignableParty->typeFormListBlank();
		$eolSoftwares = $this->EolReport->EolResult->EolSoftware->typeFormListBlank();
		$this->set(compact(array('reportsOrganizations', 'reportsVerifications', 
			'reportsRemediations', 'reportsStatuses', 'reportsAssignableParties',
			'eolSoftwares')));
	}
	
	public function admin_edit($id = null) 
	{
		$this->EolReport->id = $id;
		$this->EolReport->recursive = 1;
		$this->EolReport->contain(array('Tag'));
		if (!$eol_report = $this->EolReport->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('EOL Report')));
		}
		
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->EolReport->save($this->request->data)) 
			{
				$this->Flash->success(__('The %s has been saved', __('EOL Report')));
				return $this->redirect(array('action' => 'view', $this->EolReport->id, 'admin' => false));
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('EOL Report')));
			}
		}
		else
		{
			$this->request->data = $eol_report;
		}
	}
	
	public function admin_delete($id = null) 
	{
		$this->EolReport->id = $id;
		if (!$this->EolReport->exists()) {
			throw new NotFoundException(__('Invalid %s', __('EOL Report')));
		}
		if ($this->EolReport->delete()) {
			$this->Flash->success(__('%s deleted', __('EOL Report')));
			return $this->redirect(array('action' => 'index', 'admin' => false));
		}
		$this->Flash->error(__('%s was not deleted', __('EOL Report')));
		return $this->redirect(array('action' => 'index', 'admin' => false));
	}
}