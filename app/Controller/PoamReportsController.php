<?php
class PoamReportsController extends AppController 
{
	public function db_tab_trend()
	{
		$stats = $this->PoamReport->findForTrend();
		
		$this->set(compact('stats'));
	}

	public function index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array();
		
		$this->paginate['conditions'] = $this->PoamReport->conditions($conditions, $this->passedArgs); 
		$this->set('poamReports', $this->paginate());
	}
	
	public function poam_result($id = null) 
	{
		$this->Prg->commonProcess();
		
		if (!$poamResult = $this->PoamReport->PoamResult->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('POA&M Result')));
		}
		$this->set('poamResult', $poamResult);
		
		$conditions = array(
			'PoamReportPoamResult.poam_result_id' => $id,
		);
		
		$this->paginate['conditions'] = $this->PoamReport->PoamReportPoamResult->conditions($conditions, $this->passedArgs); 
		if(isset($this->request->params['ext']) and $this->request->params['ext'] === 'csv')
		{
			$this->PoamReport->PoamReportPoamResult->recursive = -1;
			$this->paginate['limit'] = $this->paginate['maxLimit'] = $this->PoamReport->PoamReportPoamResult->find('count', array('conditions' => $this->paginate['conditions']));
			$this->layout = 'Utilities.../ajax_nodebug';
		}
		
		$this->paginate['order'] = array('PoamReportPoamResult.created' => 'desc');
		$this->paginate['contain'] = array('PoamReport', 'PoamResult');
		$this->set('poamReports', $this->paginate('PoamReportPoamResult'));
		
		$page_subtitle = __('All');
		$page_description = '';
		$this->set(compact(array('page_subtitle', 'page_description')));
	}
	
	public function tag($tag_id = null) 
	{
		$this->Prg->commonProcess();
		
		if(!$tag_id) 
		{
			throw new NotFoundException(__('Invalid %s', __('Tag')));
		}
		
		$tag = $this->PoamReport->Tag->read(null, $tag_id);
		if(!$tag) 
		{
			throw new NotFoundException(__('Invalid %s', __('Tag')));
		}
		$this->set('tag', $tag);
		
		$conditions = array();
		
		$conditions[] = $this->PoamReport->Tag->Tagged->taggedSql($tag['Tag']['keyname'], 'PoamReport');
		
		$order = array('PoamReport.name' => 'asc');
		
		$this->paginate['order'] = $order;
		$this->paginate['conditions'] = $this->PoamReport->conditions($conditions, $this->passedArgs); 
		$this->set('poamReports', $this->paginate());
	}
	
	public function view($id = false)
	{
		$this->PoamReport->id = $id;
		$this->PoamReport->recursive = 0;
		if (!$poamReport = $this->PoamReport->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('POA&M Report')));
		}
		
		$this->set('poamReport', $poamReport);
	}
	
	public function view_excel($id)
	{
		if (!$poamReport = $this->PoamReport->read(null, $id))
		{
			throw new NotFoundException(__('Invalid %s', __('POA&M Report')));
		}
		
		$this->set('poamReport', $poamReport);
		$this->set('excel_html', $this->PoamReport->viewExcelFile($id));
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
	
	public function saa_add() 
	{
		if ($this->request->is('post'))
		{
			$this->PoamReport->create();
			
			$this->request->data['PoamReport']['added_user_id'] = AuthComponent::user('id');
			if ($results = $this->PoamReport->addReport($this->request->data))
			{
				$this->Flash->success(__('The %s has been saved. %s found. %s updated. %s auto closed.', __('POA&M Report'), count($results['new_ids']), count($results['updated_ids']), count($results['auto_closed_ids'])));
				$this->bypassReferer = true;
				return $this->redirect(array('action' => 'view', $this->PoamReport->id, 'saa' => false));
			}
			else
			{
				$this->Flash->error($this->PoamReport->modelError);
			}
		}
	}
	
	public function saa_edit($id = null) 
	{
		$this->PoamReport->id = $id;
		$this->PoamReport->recursive = 1;
		$this->PoamReport->contain(array('Tag'));
		if (!$poamReport = $this->PoamReport->read(null, $id)) 
		{
			throw new NotFoundException(__('Invalid %s', __('POA&M Report')));
		}
		
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->PoamReport->save($this->request->data)) 
			{
				$this->Flash->success(__('The %s has been saved', __('POA&M Report')));
				return $this->redirect(array('action' => 'view', $this->PoamReport->id, 'saa' => false));
			}
			else
			{
				$this->Flash->error(__('The %s could not be saved. Please, try again.', __('POA&M Report')));
			}
		}
		else
		{
			$this->request->data = $poamReport;
		}
	}
	
	public function admin_delete($id = null) 
	{
		$this->PoamReport->id = $id;
		if (!$this->PoamReport->exists()) {
			throw new NotFoundException(__('Invalid %s', __('POA&M Report')));
		}
		if ($this->PoamReport->delete()) {
			$this->Flash->success(__('%s deleted', __('POA&M Report')));
			return $this->redirect(array('action' => 'index', 'admin' => false));
		}
		$this->Flash->error(__('%s was not deleted', __('POA&M Report')));
		return $this->redirect(array('action' => 'index', 'admin' => false));
	}
}