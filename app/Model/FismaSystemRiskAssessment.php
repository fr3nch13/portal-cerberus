<?php
App::uses('AppModel', 'Model');

class FismaSystemRiskAssessment extends AppModel
{
	public $displayField = 'name';
	
	public $hasMany = array(
		'FismaSystem' => array(
			'className' => 'FismaSystem',
			'foreignKey' => 'fisma_system_risk_assessment_id',
			'dependent' => false,
		)
	);
	
	// define the fields that can be searched
	public $searchFields = array(
		'FismaSystemRiskAssessment.name',
	);
}
