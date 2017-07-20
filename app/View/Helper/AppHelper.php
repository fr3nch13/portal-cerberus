<?php
/**
 * Application level View Helper
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
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
 * @package       app.View.Helper
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Helper', 'View');
App::uses('Inflector', 'Utility');

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       app.View.Helper
 */
class AppHelper extends Helper 
{
	public $helpers = array(
		'Ajax', 'Time', 'Js' => array('JqueryUi'),
		'Html' => array('className' => 'Utilities.HtmlExt' ),
		'Form' => array('className' => 'Utilities.FormExt' ),
	);
	
	public $defaultModel = null;
	
	public function __construct(View $View, $settings = array()) 
	{
		parent::__construct($View, $settings);
		
		//figure out the default model
		if(isset($this->request->params['models']) and is_array($this->request->params['models']) and count($this->request->params['models']))
		{
			// the first one is the one that matches the controller
			$models = array_keys($this->request->params['models']);
			$this->defaultModel = $models[0];
			unset($models);
		}
		// pull from the controller settings
		if(!$this->defaultModel and $this->request->params['controller'])
		{
			$this->defaultModel = Inflector::classify($this->request->params['controller']);
		}
	}
}
