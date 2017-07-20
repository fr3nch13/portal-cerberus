<?php
App::uses('AppModel', 'Model');
/**
 * ReviewStateLog Model
 *
 * @property ReviewState $ReviewState
 * @property Rule $Rule
 */
class ReviewStateLog extends AppModel
{
	public $validate = array(
		'review_state_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'rule_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'comments' => array(
			'numeric' => array(
				'rule' => array('notBlank'),
			),
		),
	);
	
	public $belongsTo = array(
		'ReviewState' => array(
			'className' => 'ReviewState',
			'foreignKey' => 'review_state_id',
		),
		'OldReviewState' => array(
			'className' => 'ReviewState',
			'foreignKey' => 'old_review_state_id',
		),
		'Rule' => array(
			'className' => 'Rule',
			'foreignKey' => 'rule_id',
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
		)
	);
	
	public $order = array("ReviewStateLog.created" => "asc");
	
	// define the fields that can be searched
	public $searchFields = array(
		'ReviewStateLog.comments',
		'OldReviewState.name',
		'ReviewState.name',
		'User.name',
		// don't need any of the rule fields yet, since the only view is for a particular rule
	);
}
