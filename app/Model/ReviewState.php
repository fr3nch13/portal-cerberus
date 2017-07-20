<?php
App::uses('AppModel', 'Model');
/**
 * ReviewState Model
 *
 * @property Rule $Rule
 */
class ReviewState extends AppModel 
{
	public $displayField = 'name';
	
	public $validate = array(
		'default' => array(
			'boolean' => array(
				'rule' => array('boolean'),
			),
		),
	);
	
	public $hasMany = array(
		'Rule' => array(
			'className' => 'Rule',
			'foreignKey' => 'review_state_id',
			'dependent' => false,
		),
		'ReviewStateLog' => array(
			'className' => 'ReviewStateLog',
			'foreignKey' => 'review_state_id',
			'dependent' => true,
		),
		'OldReviewStateLog' => array(
			'className' => 'ReviewStateLog',
			'foreignKey' => 'old_review_state_id',
			'dependent' => true,
		),
	);
	
	// define the fields that can be searched
	public $searchFields = array(
		'ReviewState.name',
	);
	
	public function defaultId()
	{
		return $this->field('id', array('default' => true));
	}
}
