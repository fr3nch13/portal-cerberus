<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */


App::uses('CommonAppController', 'Utilities.Controller');
class AppController extends CommonAppController
{
	public $components = array(
		'Auth' => array(
			'loginRedirect' => array('controller' => 'main', 'action' => 'index'),
		),
	);
	
	public $helpers = array(
		'Local',
		'Contacts.Contacts',
		'Queue.Queue',
	);
	
	public $conditions = array();
	
	public function beforeFilter() 
	{
		$this->Auth->allow(
			'db_tab_change'
		);
		return parent::beforeFilter();
	}
	
	public function multiselect()
	{
		if (!$this->request->is('post') and !$this->request->is('put')) 
		{
			throw new MethodNotAllowedException(__('Request must be a POST or PUT, this request was a %s', $this->request->method()));
		}
		
		$multiselect_option = false;
		if(isset($this->request->data[$this->modelClass]['multiselect_option']))
			$multiselect_option = $this->request->data[$this->modelClass]['multiselect_option'];
		elseif(isset($this->request->data['Multiselect']['multiselect_option']))
			$multiselect_option = $this->request->data['Multiselect']['multiselect_option'];
		
		if(!$multiselect_option)
		{
			$this->Flash->error(__('Please select a valid Multiselect option. -1'));
			$this->bypassReferer;
			$this->redirect($this->referer());
		}
		
		if(!$multiselectOption = $this->{$this->modelClass}->multiselectOptions($multiselect_option))
		{
			$this->Flash->error(__('Please select a valid Multiselect option. -2'));
			$this->bypassReferer;
			$this->redirect($this->referer());
		}
		
		// forward to a page where the user can choose a value
		$redirect = $multiselectOption;
		
		if(isset($this->request->data['multiple']))
		{
			$ids = array();
			foreach($this->request->data['multiple'] as $id => $selected) { if($selected) $ids[] = $id; }
			$this->request->data['multiple'] = $this->{$this->modelClass}->find('list', array(
				'fields' => array($this->modelClass.'.'.$this->{$this->modelClass}->primaryKey, $this->modelClass.'.'.$this->{$this->modelClass}->primaryKey),
				'conditions' => array($this->modelClass.'.'.$this->{$this->modelClass}->primaryKey => $ids),
				'recursive' => -1,
			));
		}
		
		Cache::write('Multiselect_'.$this->{$this->modelClass}->alias.'_'. AuthComponent::user('id'), $this->request->data, 'sessions');
		$this->bypassReferer = true;
		
		if(in_array($multiselect_option, array('reported_to_ic_date', 'resolved_by_date')))
		{
			return $this->redirect(array('action' => 'multiselect_date', $multiselect_option));
		}
		
		return $this->redirect(array('action' => 'multiselect_items', $multiselect_option));
	}
	
	public function multiselect_items($option = false)
	{
		if(!$multiselectOption = $this->{$this->modelClass}->multiselectOptions($option))
		{
			$this->Flash->error(__('Please select a valid Multiselect option.'));
			$this->bypassReferer;
			$this->redirect($this->referer());
		}
		$this->set('multiselectOption', $multiselectOption);
		
		$this->set('options', $this->{$this->modelClass}->{$option}->typeFormList());
		
		$sessionData = Cache::read('Multiselect_'.$this->{$this->modelClass}->alias.'_'. AuthComponent::user('id'), 'sessions');
		if($this->request->is('post') || $this->request->is('put')) 
		{
			$multiselect_value = (isset($this->request->data[$this->modelClass][$multiselectOption['foreignKey']])?$this->request->data[$this->modelClass][$multiselectOption['foreignKey']]:0);
			if($multiselect_value)
			{
				if($this->{$this->modelClass}->multiselectItems($sessionData, $this->request->data)) 
				{
					Cache::delete('Multiselect_'.$this->alias.'_'. AuthComponent::user('id'), 'sessions');
					$this->Flash->success(__('The %s were updated.', Inflector::pluralize(Inflector::humanize(Inflector::underscore($this->modelClass))) ));
					return $this->redirect($this->{$this->modelClass}->multiselectReferer());
				}
				else
				{
					$this->Flash->error(__('The %s were NOT updated.', Inflector::pluralize(Inflector::humanize(Inflector::unserscore($this->modelClass))) ));
				}
			}
			else
			{
				$this->Flash->error(__('Please select one %s', $multiselectOption['nameSingle']));
			}
		}
		
		$selected_items = array();
		if(isset($sessionData['multiple']))
		{
			$selected_items = $this->{$this->modelClass}->find('list', array(
				'conditions' => array(
					$this->modelClass.'.'.$this->{$this->modelClass}->primaryKey => $sessionData['multiple'],
				),
				'fields' => array($this->modelClass.'.'.$this->{$this->modelClass}->primaryKey, $this->modelClass.'.'.$this->{$this->modelClass}->primaryKey),
			));
		}
		
		$this->set('selected_items', $selected_items);
		
		return $this->render('/Elements/multiselect_items');
	}
	
	public function multiselect_date($field = false)
	{
		if(!$multiselectOption = $this->{$this->modelClass}->multiselectOptions($field))
		{
			$this->Flash->error(__('Please select a valid Multiselect option.'));
			$this->bypassReferer;
			$this->redirect($this->referer());
		}
		$this->set('field', $field);
		$this->set('multiselectOption', $multiselectOption);
		
		$sessionData = Cache::read('Multiselect_'.$this->{$this->modelClass}->alias.'_'. AuthComponent::user('id'), 'sessions');
		if($this->request->is('post') || $this->request->is('put')) 
		{
			$multiselect_value = (isset($this->request->data[$this->modelClass][$multiselectOption['field']])?$this->request->data[$this->modelClass][$multiselectOption['field']]:false);
			
			if($multiselect_value)
			{
				if($this->{$this->modelClass}->multiselectItems($sessionData, $this->request->data)) 
				{
					Cache::delete('Multiselect_'.$this->alias.'_'. AuthComponent::user('id'), 'sessions');
					$this->Flash->success(__('The %s were updated.', Inflector::pluralize(Inflector::humanize(Inflector::underscore($this->modelClass))) ));
					return $this->redirect($this->{$this->modelClass}->multiselectReferer());
				}
				else
				{
					$this->Flash->error(__('The %s were NOT updated.', Inflector::pluralize(Inflector::humanize(Inflector::unserscore($this->modelClass))) ));
				}
			}
			else
			{
				$this->Flash->error(__('Please select the %s', $multiselectOption['nameSingle']));
			}
		}
		
		$selected_items = array();
		if(isset($sessionData['multiple']))
		{
			$selected_items = $this->{$this->modelClass}->find('list', array(
				'conditions' => array(
					$this->modelClass.'.'.$this->{$this->modelClass}->primaryKey => $sessionData['multiple'],
				),
				'fields' => array($this->modelClass.'.'.$this->{$this->modelClass}->primaryKey, $this->modelClass.'.'.$this->{$this->modelClass}->primaryKey),
			));
		}
		
		$this->set('selected_items', $selected_items);
		
		return $this->render('/Elements/multiselect_date');
	}
	
	public function scopedResults($scope = 'org', $conditions = array(), $fismaSystemConditions = array())
	{
		$scopeName = '';
		if($scope == 'org')
		{
			$scopeName = __('ORG/IC');
		}
		elseif($scope == 'division')
		{
			$scopeName = __('Division');
		}
		elseif($scope == 'branch')
		{
			$scopeName = __('Branch');
		}
		elseif($scope == 'sac')
		{
			$scopeName = __('SAC');
		}
		elseif($scope == 'owner')
		{
			$scopeName = __('System Owner');
		}
		elseif(in_array($scope, array('system', 'fisma_system')))
		{
			$scopeName = __('FISMA System');
		}
		
		$results = $this->{$this->modelClass}->scopedResults($scope, $conditions, array(), false, $fismaSystemConditions);
		
		$this->set(compact(array(
			'scope', 'scopeName', 'results',
		)));
		
		return $results;
	}
}