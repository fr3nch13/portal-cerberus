<?php
class UsReportsController extends AppController 
{
	public function db_tab_trend()
	{
		$stats = $this->UsReport->findForTrend();
		
		$this->set(compact('stats'));
	}

	public function index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = [];
		
		$this->UsReport->taskCheck = true;
		$this->paginate['conditions'] = $this->UsReport->conditions($conditions, $this->passedArgs); 
		$this->set('us_reports', $this->paginate());
	}
	
	public function us_result($id = null) 
	{
		$this->Prg->commonProcess();
		
		if (!$us_result = $this->UsReport->UsResult->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('US Result')));
		}
		$this->set('us_result', $us_result);
		
		
		$conditions = array(
			'UsReportUsResult.us_result_id' => $id,
		);
		
		$this->paginate['conditions'] = $this->UsReport->UsReportUsResult->conditions($conditions, $this->passedArgs); 
		if(isset($this->request->params['ext']) and $this->request->params['ext'] === 'csv')
		{
			$this->UsReport->UsReportUsResult->recursive = -1;
			$this->paginate['limit'] = $this->paginate['maxLimit'] = $this->UsReport->UsReportUsResult->find('count', array('conditions' => $this->paginate['conditions']));
			$this->layout = 'Utilities.../ajax_nodebug';
		}
		
		$this->paginate['order'] = array('UsReportUsResult.created' => 'desc');
		$this->paginate['contain'] = array('UsReport', 'UsResult', 'UsResult.ReportsOrganization'
		);
		$this->set('us_reports', $this->paginate('UsReportUsResult'));
		
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
		
		$tag = $this->UsReport->Tag->read(null, $tag_id);
		if(!$tag) 
		{
			throw new NotFoundException(__('Invalid %s', __('Tag')));
		}
		$this->set('tag', $tag);
		
		$this->Prg->commonProcess();
		
		$conditions = array();
		
		// include all if they're an admin
		if(AuthComponent::user('role') != 'admin')
			$conditions['UsReport.approved'] = true;
		
		$conditions[] = $this->UsReport->Tag->Tagged->taggedSql($tag['Tag']['keyname'], 'UsReport');
		
		$order = array('UsReport.name' => 'asc');
		
		
		$this->UsReport->recursive = 0;
		$this->paginate['order'] = $order;
		$this->paginate['conditions'] = $this->UsReport->conditions($conditions, $this->passedArgs); 
		$this->set('us_reports', $this->paginate());
	}
	
	public function view($id = false)
	{
		
		$this->UsReport->id = $id;
		$this->UsReport->recursive = 0;
		if (!$us_report = $this->UsReport->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('US Report')));
		}
		
		$this->set('us_report', $us_report);
	}
	
	public function view_excel($id)
	{
		if (!$us_report = $this->UsReport->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('US Report')));
		}
		
		$this->set('us_report', $us_report);
		$this->set('excel_html', $this->UsReport->viewExcelFile($id));
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
			$this->UsReport->create();
			
			$this->request->data['UsReport']['added_user_id'] = AuthComponent::user('id');
			if ($results = $this->UsReport->addReport($this->request->data))
			{
				$this->Flash->success(__('The %s is queued for processing', __('US Report')));
				$this->bypassReferer = true;
				return $this->redirect(['action' => 'index']);
			}
			else
			{
				$this->Flash->error($this->UsReport->modelError);
			}
		}
	}
	
	public function admin_edit_duplicates($us_report_id = false)
	{
		$this->UsReport->id = $us_report_id;
		$this->UsReport->recursive = 1;
		$this->UsReport->contain(array('Tag'));
		if (!$us_report = $this->UsReport->read(null, $us_report_id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('US Report')));
		}
		
		if ($this->request->is('post'))
		{
			$this->bypassReferer = true;
			if(!$this->request->data or !isset($this->request->data['UsReport']))
			{
				Cache::delete('us_duplicates_'. $this->UsReport->id);
				$this->Flash->success(__('None of the %s needed to be updated.', __('US Results')));
				return $this->redirect(array('action' => 'view', $this->UsReport->id, 'admin' => false));
			}
			
			if ($this->UsReport->UsReportUsResult->updateNewDuplicates($this->UsReport->id, $this->request->data, AuthComponent::user('id')))
			{
				Cache::delete('us_duplicates_'. $this->UsReport->id);
				$this->Flash->success(__('The %s were updated.', __('US Results')));
				return $this->redirect(array('action' => 'view', $this->UsReport->id, 'admin' => false));
			}
		}
		
		$duplicates = Cache::read('us_duplicates_'. $us_report_id);
		if(!$duplicates)
			$duplicates = array();
			
		$this->set('duplicates', $duplicates);
		$this->set('us_report', $us_report);
		
		
		$reportsOrganizations = $this->UsReport->UsResult->ReportsOrganization->typeFormListBlank();
		$reportsRemediations = $this->UsReport->UsResult->ReportsRemediation->typeFormListBlank();
		$reportsVerifications = $this->UsReport->UsResult->ReportsVerification->typeFormListBlank();
		$reportsStatuses = $this->UsReport->UsResult->ReportsStatus->typeFormListBlank();
		$reportsAssignableParties = $this->UsReport->UsResult->ReportsAssignableParty->typeFormListBlank();
		$eolSoftwares = $this->UsReport->UsResult->EolSoftware->typeFormListBlank();
		$this->set(compact(array('reportsOrganizations', 'reportsVerifications', 
			'reportsRemediations', 'reportsStatuses', 'reportsAssignableParties',
			'eolSoftwares')));
	}
	
	public function admin_edit($id = null) 
	{
		$this->UsReport->id = $id;
		$this->UsReport->recursive = 1;
		$this->UsReport->contain(array('Tag'));
		if (!$us_report = $this->UsReport->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('US Report')));
		}
		
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->UsReport->save($this->request->data)) 
			{
				$this->Flash->success(__('The %s has been saved', __('US Report')));
				return $this->redirect(array('action' => 'view', $this->UsReport->id, 'admin' => false));
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('US Report')));
			}
		}
		else
		{
			$this->request->data = $us_report;
		}
	}
	
	public function admin_delete($id = null) 
	{
		$this->UsReport->id = $id;
		if (!$this->UsReport->exists()) {
			throw new NotFoundException(__('Invalid %s', __('US Report')));
		}
		if ($this->UsReport->delete()) {
			$this->Flash->success(__('%s deleted', __('US Report')));
			return $this->redirect(array('action' => 'index', 'admin' => false));
		}
		$this->Flash->error(__('%s was not deleted', __('US Report')));
		return $this->redirect(array('action' => 'index', 'admin' => false));
	}
}