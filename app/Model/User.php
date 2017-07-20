<?php
// app/Model/User.php

App::uses('AppModel', 'Model');

class User extends AppModel
{
	public $name = 'User';
	
	public $displayField = 'name';
	
	public $validate = array(
		'email' => array(
			'required' => array(
				'rule' => array('email'),
				'message' => 'A valid email adress is required',
			)
		),
		'role' => array(
			'valid' => array(
				'rule' => array('notBlank'),
				'message' => 'Please enter a valid role',
				'allowEmpty' => false,
			),
		),
	);
	
	public $hasOne = array(
		'UserSetting' => array(
			'className' => 'UserSetting',
			'foreignKey' => 'user_id',
		),
	);
	
	public $hasMany = array(
		'LoginHistory' => array(
			'className' => 'LoginHistory',
			'foreignKey' => 'user_id',
			'dependent' => true,
		),
		'RuleAddedUser' => array(
			'className' => 'Rule',
			'foreignKey' => 'added_user_id',
			'dependent' => false,
		),
		'RuleModifiedUser' => array(
			'className' => 'Rule',
			'foreignKey' => 'modified_user_id',
			'dependent' => false,
		),
		'RuleReviewedUser' => array(
			'className' => 'Rule',
			'foreignKey' => 'reviewed_user_id',
			'dependent' => false,
		),
		'ReviewStateLog' => array(
			'className' => 'ReviewStateLog',
			'foreignKey' => 'user_id',
			'dependent' => false,
		),
		'ImportAddedUser' => array(
			'className' => 'Import',
			'foreignKey' => 'added_user_id',
			'dependent' => false,
		),
		'ImportModifiedUser' => array(
			'className' => 'Import',
			'foreignKey' => 'modified_user_id',
			'dependent' => false,
		),
		'ImportRescannedUser' => array(
			'className' => 'Import',
			'foreignKey' => 'rescanned_user_id',
			'dependent' => false,
		),
		'FirewallAddedUser' => array(
			'className' => 'Firewall',
			'foreignKey' => 'added_user_id',
			'dependent' => false,
		),
		'FirewallModifiedUser' => array(
			'className' => 'Firewall',
			'foreignKey' => 'modified_user_id',
			'dependent' => false,
		),
		'ProtocolAddedUser' => array(
			'className' => 'Protocol',
			'foreignKey' => 'added_user_id',
			'dependent' => false,
		),
		'ProtocolAddedUser' => array(
			'className' => 'Protocol',
			'foreignKey' => 'added_user_id',
			'dependent' => false,
		),
		'FogAddedUser' => array(
			'className' => 'Fog',
			'foreignKey' => 'added_user_id',
			'dependent' => false,
		),
		'FogLog' => array(
			'className' => 'FogLog',
			'foreignKey' => 'user_id',
			'dependent' => false,
		),
		'PogAddedUser' => array(
			'className' => 'Pog',
			'foreignKey' => 'added_user_id',
			'dependent' => false,
		),
		'PogLog' => array(
			'className' => 'PogLog',
			'foreignKey' => 'user_id',
			'dependent' => false,
		),
		'HostAliasAddedUser' => array(
			'className' => 'HostAlias',
			'foreignKey' => 'added_user_id',
			'dependent' => false,
		),
		'FismaAddedUser' => array(
			'className' => 'FismaSystem',
			'foreignKey' => 'added_user_id',
		),
		'FismaModifiedUser' => array(
			'className' => 'FismaSystem',
			'foreignKey' => 'modified_user_id',
		),
		'FismaSoftwareAddedUser' => array(
			'className' => 'FismaSoftware',
			'foreignKey' => 'added_user_id',
		),
		'FismaSoftwareModifiedUser' => array(
			'className' => 'FismaSoftware',
			'foreignKey' => 'modified_user_id',
		),
		'PenTestResultAddedUser' => array(
			'className' => 'PenTestResult',
			'foreignKey' => 'added_user_id',
		),
		'PenTestResultModifiedUser' => array(
			'className' => 'PenTestResult',
			'foreignKey' => 'modified_user_id',
		),
		'ReportsRemediationUser' => array(
			'className' => 'PenTestResult',
			'foreignKey' => 'remediation_user_id',
		),
		'ReportsVerificationUser' => array(
			'className' => 'PenTestResult',
			'foreignKey' => 'verification_user_id',
		),
		'PoamResultAddedUser' => array(
			'className' => 'PoamResult',
			'foreignKey' => 'added_user_id',
		),
		'PoamResultModifiedUser' => array(
			'className' => 'PoamResult',
			'foreignKey' => 'modified_user_id',
		),
		'FovResultAddedUser' => array(
			'className' => 'FovResult',
			'foreignKey' => 'added_user_id',
		),
		'FovResultModifiedUser' => array(
			'className' => 'FovResult',
			'foreignKey' => 'modified_user_id',
		),
		'Subscription' => [
			'className' => 'Utilities.Subscription',
			'foreignKey' => 'user_id',
		]
	);
	
	public $actsAs = array(
		// log all changes to the database
		'Snapshot.Stat' => array(
			'entities' => array(
				'all' => array(),
				'created' => array(),
				'modified' => array(),
				'active' => array(
					'conditions' => array(
						'User.active' => true,
					),
				),
			),
		),
    );
	
	// define the fields that can be searched
	public $searchFields = array(
		'User.name',
		'User.email',
	);
	
	// fields that are boolean and can be toggled
	public $toggleFields = array('active');
	
	// the path to the config file.
	public $configPath = false;
	
	// Any error relating to the config
	public $configError = false;
	
	// used to store info, because the photo name is changed.
	public $afterdata = false;
	
	public $includeOrgName = true;
	
	public function beforeFind($queryData = array())
	{
		// add the org group with the name to make the total name
		if($this->recursive == -1)
		{
			$this->recursive = 0;
		}
		
		return parent::beforeFind($queryData);
	}
	
	public function afterFind($results = array(), $primary = false)
	{
		if($results and $this->includeOrgName)
		{
			foreach($results as $i => $result)
			{
				if(isset($this->OrgGroup) and isset($result[$this->OrgGroup->alias]['name']) and isset($result[$this->alias]['name']))
				{
					$results[$i][$this->alias]['name'] = '['. $results[$i][$this->OrgGroup->alias]['name']. '] '. $results[$i][$this->alias]['name'];
				}
			}
		}
		return parent::afterFind($results, $primary);
	}
	
	public function beforeSave($options = array())
	{
		// hash the password before saving it to the database
		if (isset($this->data[$this->alias]['password']))
		{
			$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
		}
		
		return parent::beforeSave($options);
	}
	
	public function loginAttempt($input = false, $success = false, $user_id = false)
	{
	/*
	 * Once a user is logged in, tack it in the database
	 */
		$email = false;
		if(isset($input['User']['email'])) 
		{
			$email = $input['User']['email'];
			if(!$user_id)
			{
				$user_id = $this->field('id', array('email' => $email));
			}
		}
		
		$data = array(
			'email' => $email,
			'user_agent' => env('HTTP_USER_AGENT'),
			'ipaddress' => env('REMOTE_ADDR'),
			'success' => $success,
			'user_id' => $user_id,
			'timestamp' => date('Y-m-d H:i:s'),
		);
		
		$this->LoginHistory->create();
		return $this->LoginHistory->save($data);
	}
	
	public function lastLogin($user_id = null)
	{
		if($user_id)
		{
			$this->id = $user_id;
			return $this->saveField('lastlogin', date('Y-m-d H:i:s'));
		}
		return false;
	}
	
	public function adminEmails()
	{
	/*
	 * Returns a list of emails address for admin users
	 */
		
		return $this->find('list', array(
			'conditions' => array(
				$this->alias. '.active' => true,
				$this->alias. '.role' => 'admin',
			),
			'fields' => array(
				$this->alias. '.email',
			),
		));
	}
	
	public function activeEmails()
	{
	/*
	 * Returns a list of emails address for active users
	 */
		
		return $this->find('list', array(
			'conditions' => array(
				$this->alias. '.active' => true,
			),
			'fields' => array(
				$this->alias. '.email',
				$this->alias. '.name',
			),
		));
	}
	
	public function userList($user_ids = array(), $recursive = 0)
	{
	/*
	 * Lists users out with the keys being the user_id
	 */
		// fill the user cache
		$_users = $this->find('all', array(
			'recursive' => $recursive,
			'conditions' => array(
				'User.id' => $user_ids,
			),
		));
		
		$users = array();
		
		foreach($_users as $user)
		{
			$user_id = $user['User']['id'];
			$users[$user_id] = $user; 
		}
		unset($_users);
		return $users;
	}
	
	public function changeLogList($user_ids = array(), $recursive = 0)
	{
	/*
	 * Lists users out with the keys being the user_id, and user email settings set to 2, for the change_log cron job
	 */
		// fill the user cache
		$_users = $this->find('all', array(
			'recursive' => $recursive,
			'conditions' => array(
				'or' => array(
					'User.id' => $user_ids,
					'UserSetting.email_new' => 2,
					'UserSetting.email_updated' => 2,
					'UserSetting.email_closed' => 2,
				),
			),
		));

			$users = array();

			foreach($_users as $user)
			{
				$user_id = $user['User']['id'];
				$users[$user_id] = $user;
			}
			unset($_users);
			return $users;
	}
	
	public function availableRoles($user_id = false)
	{
		$this->id = $user_id;
		$originalRole = $this->field('role');
		$roles = $this->userRoles(); // returns a list of roles from hightest to lowest
		
		// automatically take out some roles that aren't available to any users
		if(isset($roles['api']))
			unset($roles['api']);
		
		// filter out the roles;
		foreach($roles as $role => $roleNice)
		{
			// the admin
			if($originalRole != $role)
			{
				unset($roles[$role]);
				continue;
			}
			return $roles;
		}
		
		return $roles;
	}
}

