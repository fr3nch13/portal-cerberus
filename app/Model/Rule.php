<?php
App::uses('AppModel', 'Model');
/**
 * Rule Model
 *
 */
class Rule extends AppModel 
{

	public $validate = array(
		'fw_int_id' => array(
			'numeric' => array('rule' => array('numeric')),
		),
		'firewall_id' => array(
			'numeric' => array('rule' => array('numeric')),
		),
		'src_fisma_system_id' => array(
			'numeric' => array('rule' => array('numeric')),
		),
		'dst_fisma_system_id' => array(
			'numeric' => array('rule' => array('numeric')),
		),
		'src_fog_id' => array(
			'numeric' => array('rule' => array('numeric')),
		),
		'dst_fog_id' => array(
			'numeric' => array('rule' => array('numeric')),
		),
		'src_pog_id' => array(
			'numeric' => array('rule' => array('numeric')),
		),
		'dst_pog_id' => array(
			'numeric' => array('rule' => array('numeric')),
		),
		'review_state_id' => array(
			'numeric' => array('rule' => array('numeric')),
		),
		'fw_interface_id' => array(
			'numeric' => array('rule' => array('numeric')),
		),
		'protocol_id' => array(
			'numeric' => array('rule' => array('numeric')),
		),
	);
	
	public $hasMany = array(
		'ReviewStateLog' => array(
			'className' => 'ReviewStateLog',
			'foreignKey' => 'rule_id',
			'dependent' => true,
		),
	);
	
	public $belongsTo = array(
		'Import' => array(
			'className' => 'Import',
			'foreignKey' => 'import_id',
		),
		'Firewall' => array(
			'className' => 'Firewall',
			'foreignKey' => 'firewall_id',
			'plugin_filter' => true,
		),
		'FwInterface' => array(
			'className' => 'FwInterface',
			'foreignKey' => 'fw_interface_id',
		),
		'FwInt' => array(
			'className' => 'FwInt',
			'foreignKey' => 'fw_int_id',
			'dependent' => false,
		),
		'Protocol' => array(
			'className' => 'Protocol',
			'foreignKey' => 'protocol_id',
			'dependent' => false,
			'plugin_filter' => true,
		),
		'SrcFismaSystem' => array(
			'className' => 'FismaSystem',
			'foreignKey' => 'src_fisma_system_id',
		),
		'DstFismaSystem' => array(
			'className' => 'FismaSystem',
			'foreignKey' => 'dst_fisma_system_id',
		),
		'SrcFog' => array(
			'className' => 'Fog',
			'foreignKey' => 'src_fog_id',
		),
		'DstFog' => array(
			'className' => 'Fog',
			'foreignKey' => 'dst_fog_id',
		),
		'SrcPog' => array(
			'className' => 'Pog',
			'foreignKey' => 'src_pog_id',
		),
		'DstPog' => array(
			'className' => 'Pog',
			'foreignKey' => 'dst_pog_id',
		),
		'ReviewState' => array(
			'className' => 'ReviewState',
			'foreignKey' => 'review_state_id',
			'plugin_filter' => array(
				'name' => 'Review State',
			)
		),
		'RuleAddedUser' => array(
			'className' => 'User',
			'foreignKey' => 'added_user_id',
		),
		'RuleModifiedUser' => array(
			'className' => 'User',
			'foreignKey' => 'modified_user_id',
		),
		'RuleReviewedUser' => array(
			'className' => 'User',
			'foreignKey' => 'reviewed_user_id',
		),
	);
	
	public $actsAs = array(
		'Dblogger.Dblogger', // log all changes to the database
		'Utilities.Nslookup', 
		'Utilities.Email',
		'Utilities.Extractor',
		'Utilities.FwConfigParser', 
		'PhpExcel.PhpExcel',
		'Snapshot.Stat' => array(
			'entities' => array(
				'all' => array(),
				'created' => array(),
				'modified' => array(),
			),
		), 
	);
	
	// define the fields that can be searched
	public $searchFields = array(
		'Rule.id',
		'Rule.hash',
		'Rule.raw',
		'SrcFismaSystem.name',
		'SrcFog.name',
//		'SrcFog.slug',
		'SrcPog.name',
//		'SrcPog.slug',
		'Rule.src_ip',
		'Rule.src_port',
		'Rule.src_desc',
		'DstFismaSystem.name',
		'DstFog.name',
//		'DstFog.slug',
		'DstPog.name',
//		'DstPog.slug',
		'Rule.dst_ip',
		'Rule.dst_port',
		'Rule.dst_desc',
		'Rule.poc_email',
		'Rule.ticket',
		'FwInt.name',
		'Firewall.name',
		'FwInterface.name',
		'RuleAddedUser.name',
		'RuleAddedUser.email',
		'RuleModifiedUser.name',
		'RuleModifiedUser.email',
		'RuleReviewedUser.name',
		'RuleReviewedUser.email',
//		'RulePocUser.name',
//		'RulePocUser.email',
//		'ReviewState.name',
	);
	
	// fields that are boolean and can be toggled
	public $toggleFields = array('review_state');
	
	// used to map column names to readable states
	public $mappedFields = array(
		'review_state_id' => array('name' => 'Review State', 'value' => 'ReviewState.name'),
		'reviewed_user_id' => array('name' => 'Last Reviewed By', 'value' => 'RuleReviewedUser.email'),
		'added_user_id' => array('name' => 'Created By', 'value' => 'RuleAddedUser.email'),
		'modified_user_id' => array('name' => 'Last Updated By', 'value' => 'RuleModifiedUser.email'),
	);
	
	public $getLatestUpload = false;
	
	public $csv_field_map = array(
		'RuleDetail.mac_address' => 'MAC Address',
		'RuleDetail.ip_address' => 'IP Address',
		'RuleDetail.asset_tag' => 'Asset Tag', 
		'RuleDetail.ticket' => 'Primary Ticket',
		'RuleDetail.tickets' => 'Other Tickets',
		'RuleDetail.apo' => 'Associated Project Officer, COR or COTR', 
		'RuleDetail.tech_poc' => 'Technical POC', 
		'Rule.op_div_id' => 'OPDIV/IC',
	);
	
	public $batchSaved = 0;
	public $batchIssues = 0;
	public $batchDataToFix = array();
	
	public $multiselectOptions = array('review_state');
	
	public $CommonNetwork = false;
	
	public $invIpaddresses = [];
	
	
	public function beforeSave($options = array())
	{
		// a new one
		if(!isset($this->data[$this->alias]['id']))
		{
			$this->data['Rule']['review_state_id'] = $this->ReviewState->defaultId();
			$this->data['Rule']['modified'] = false;
		}
			
		// fill out the firewall and interface if they're using a firewall path
		if(isset($this->data['Rule']['fw_int_id']) and isset($this->data['Rule']['use_fw_int']) and $this->data['Rule']['use_fw_int'])
		{
			if($fw_int = $this->FwInt->read(null, $this->data['Rule']['fw_int_id']))
			{
				$this->data['Rule']['firewall_id'] = $fw_int['FwInt']['firewall_id'];
				$this->data['Rule']['fw_interface_id'] = $fw_int['FwInt']['fw_interface_id'];
			}
		}
		return parent::beforeSave($options);
	}
	
	public function afterSave($created = false, $options = array())
	{
		if($created)
		{
			// create the initial review log instance.
			$this->ReviewStateLog->create();
			$review_state_log_data = array(
				'rule_id' => $this->id,
				'review_state_id' => (isset($this->data[$this->alias]['review_state_id'])?$this->data[$this->alias]['review_state_id']:0),
			);
			$review_state_log_data['user_id'] = (isset($this->data[$this->alias]['added_user_id'])?$this->data[$this->alias]['added_user_id']:0);
			$review_state_log_data['comments'] = __('Initial Creation.');
			$this->ReviewStateLog->save($review_state_log_data);
		}	
		
		if($this->id)
		{
			// update the host aliases from the source
			if(isset($this->data[$this->alias]['src_ip']) and $this->data[$this->alias]['src_ip'] and isset($this->data[$this->alias]['src_desc']) and $this->data[$this->alias]['src_desc'])
			{
				App::uses('HostAlias', 'Model');
				$HostAlias = new HostAlias();
				$HostAlias->checkAdd($this->data[$this->alias]['src_ip'], $this->data[$this->alias]['src_desc']);
			}
			
			// update the host aliases from the destination
			if(isset($this->data[$this->alias]['dst_ip']) and $this->data[$this->alias]['dst_ip'] and isset($this->data[$this->alias]['dst_desc']) and $this->data[$this->alias]['dst_desc'])
			{
				App::uses('HostAlias', 'Model');
				$HostAlias = new HostAlias();
				$HostAlias->checkAdd($this->data[$this->alias]['dst_ip'], $this->data[$this->alias]['dst_desc']);
			}
			
			if(isset($this->data[$this->alias]['send_notification']) and $this->data[$this->alias]['send_notification'])
			{
				$this->saveRedirect = array('action' => 'notify', $this->id);
			}
		//
		}
		return parent::afterSave($created, $options);
	}
	
	public function afterFind($results = array(), $primary = false)
	{
		foreach ($results as $key => $val) 
		{
			$results[$key][$this->alias]['compiled'] = false;
			if ($this->recursive >= 0 and isset($val[$this->alias])) 
			{
				$interface = '';
				if(isset($val['FwInterface']['name']))
				{
					$interface = $val['FwInterface']['name'];
				}
				
				$permit = 'permit';
				if(isset($val[$this->alias]['permit']))
				{
					$permit_key = $val[$this->alias]['permit'];
					$permit_map = Configure::read('Options.rule_permit_map');
					$permit = (isset($permit_map[$permit_key])?$permit_map[$permit_key]:'permit');
				}
				
				$protocol = '';
				if(isset($val['Protocol']['name']))
				{
					$protocol = $val['Protocol']['name'];
				}
				
				$source_ip = '';
				if(isset($val[$this->alias]['use_src_fog']))
				{
					$source_ip = __(' object-group %s', $val['SrcFog']['name']);
				}
				elseif(isset($val[$this->alias]['src_ip']))
				{
					$val[$this->alias]['src_ip'] = trim($val[$this->alias]['src_ip']);
					
					if(!in_array(strtoupper($val[$this->alias]['src_ip']), array('ANY', 'ALL')))
					{
						$source_ip = __(' host %s', $val[$this->alias]['src_ip']);
					}
				}
				
				$source_port = '';
				if(isset($results[$key][$this->alias]['use_src_pog']))
				{
					if(!preg_match('/^(any|all)$/i', trim($val['SrcPog']['name'])))
//					if(true)
					{
						$source_port = __(' object-group %s', $val['SrcPog']['name']);
					}
				}
				elseif(isset($val[$this->alias]['src_port']))
				{
					$val[$this->alias]['src_port'] = trim($val[$this->alias]['src_port']);
					
					if(!in_array(strtoupper($val[$this->alias]['src_port']), array('ANY', 'ALL')))
					{
						$source_port = __(' eq %s', $val[$this->alias]['src_port']);
					}
				}
				
				$destination_ip = __(' host %s', (isset($val[$this->alias]['dst_ip'])?$val[$this->alias]['dst_ip']:''));
				if(isset($val[$this->alias]['use_dst_fog']))
				{
					$destination_ip = __(' object-group %s', $val['DstFog']['name']);
				}
				
				$destination_ip = '';
				if(isset($val[$this->alias]['use_dst_fog']))
				{
					$destination_ip = __(' object-group %s', $val['DstFog']['name']);
				}
				elseif(isset($val[$this->alias]['dst_ip']))
				{
					$val[$this->alias]['dst_ip'] = trim($val[$this->alias]['dst_ip']);
					
					if(!in_array(strtoupper($val[$this->alias]['dst_ip']), array('ANY', 'ALL')))
					{
						$destination_ip = __(' host %s', $val[$this->alias]['dst_ip']);
					}
				}
				
				$destination_port = '';
				if(isset($results[$key][$this->alias]['use_dst_pog']))
				{
					if(!preg_match('/^(any|all)$/i', trim($val['DstPog']['name'])))
//					if(true)
					{
						$destination_port = __(' object-group %s', $val['DstPog']['name']);
					}
				}
				elseif(isset($val[$this->alias]['dst_port']))
				{
					$val[$this->alias]['dst_port'] = trim($val[$this->alias]['dst_port']);
					
					if(!in_array(strtoupper($val[$this->alias]['dst_port']), array('ANY', 'ALL')))
					{
						$destination_port = __(' eq %s', $val[$this->alias]['dst_port']);
					}
				}
				
				$log_notifications = '';
				if(isset($results[$key][$this->alias]['logging']))
				{
					$log_notifications = ' '. $results[$key][$this->alias]['logging'];
				}
				else
				{
				}
				
				$compiled = __('access-list %s extended %s %s%s%s %s%s%s', $interface, $permit, $protocol, $source_ip, $source_port, $destination_ip, $destination_port, $log_notifications);
				
				$compiled = preg_replace('/\s+/', ' ', $compiled);
				
				$results[$key][$this->alias]['compiled'] = $compiled;
				
			}
		}
		
		return parent::afterFind($results, $primary);
	}
	
	public function isOwnedBy($id, $user_id) 
	{
		return $this->field('id', array('id' => $id, 'added_user_id' => $user_id)) === $id;
	}
	
	public function saveAsa($data = array(), $rules_string = false)
	{
		if(!trim($rules_string))
		{
			$this->modelError = __('No rules are available for parsing/adding.');
			return false;
		}
		
		$return = false;
		$data['id'] = 0;
		$data['firewall_id'] = (isset($data[$this->alias]['firewall_id'])?$data[$this->alias]['firewall_id']:0);
		$data['added_user_id'] = (isset($data[$this->alias]['added_user_id'])?$data[$this->alias]['added_user_id']:0);
		$data['modified_user_id'] = (isset($data[$this->alias]['modified_user_id'])?$data[$this->alias]['modified_user_id']:0);
		
		if($results = $this->Import->proccessImportString($data, $rules_string))
		{
			$return = array( __('The ASA Config rules have been saved. Results: '));
			foreach($this->Import->process_added as $key => $val)
			{
				$return[] = __('%s Added: %s', $key, $val);
			}
			$return = implode(' - ', $return);
		}
		
		return $return;
	}
	
	public function notifyUsers($data = array())
	{
		// id of the rule
		if(!isset($data[$this->alias]['id']))
		{
			$this->modelError = __('Unknown %s (1)', __('Rule'));
			return false;
		}
		
		// recipients
		if(!isset($data[$this->alias]['User']))
		{
			$this->modelError = __('Unknown Recipients for %s Notification.', __('Rule'));
			return false;
		}
		$this->Email_set('to', $data[$this->alias]['User']);
		
		// user sending the notification
		if(!isset($data['NotifyUser']))
		{
			$this->modelError = __('Unknown Sender for %s Notification.', __('Rule'));
			return false;
		}
		$this->Email_set('cc', array(
			$data['NotifyUser']['email'] => $data['NotifyUser']['name'],
		));
		
		$this->Email_set('replyTo', $data['NotifyUser']['email']);
		
		// rule details
		$this->recursive = 0;
		if(!$rule = $this->read(null, $data[$this->alias]['id']))
		{
			$this->modelError = __('Unknown %s (2)', __('Rule'));
			return false;
		}
		
		$this->Email_set('template', 'notify_rules_view');
		$this->Email_set('subject', __('Notification for %s # %s', __('Rule'), $data[$this->alias]['id']));
		$this->Email_set('viewVars', array(
			'instructions' => (isset($data[$this->alias]['notification_comments'])?$data[$this->alias]['notification_comments']:false),
			'rule' => $rule,
		));
		
		return $this->Email_executeFull();
	}
	
	public function notifyUsersMany($data = array(), $rule_ids = array())
	{
		// recipients
		if(!isset($data[$this->alias]['User']))
		{
			$this->modelError = __('Unknown Recipients for %s Notification.', __('Rule'));
			return false;
		}
		$this->Email_set('to', $data[$this->alias]['User']);
		
		// user sending the notification
		if(!isset($data['NotifyUser']))
		{
			$this->modelError = __('Unknown Sender for %s Notification.', __('Rule'));
			return false;
		}
		$this->Email_set('cc', array(
			$data['NotifyUser']['email'] => $data['NotifyUser']['name'],
		));
		
		$this->Email_set('replyTo', $data['NotifyUser']['email']);
		
		// rule details
		$this->recursive = 0;
		$rules = $this->find('all', array(
			'conditions' => array(
				$this->alias. '.id' => $rule_ids,
			),
		));
		
		if(!$rules)
		{
			$this->modelError = __('Unknown %s (1)', __('Rules'));
			return false;
		}
		
		$this->Email_set('template', 'notify_rules_index');
		$this->Email_set('subject', __('Notification for multiple %s', __('Rules')));
		$this->Email_set('viewVars', array(
			'instructions' => (isset($data[$this->alias]['notification_comments'])?$data[$this->alias]['notification_comments']:false),
			'rules' => $rules,
		));
		
		$results = $this->Email_executeFull();
		
		return $results;
	}
	
	public function findAsa($type = 'all', $query = array())
	{
		$this->SrcFog->compile = true;
		$this->DstFog->compile = true;
		$this->SrcPog->compile = true;
		$this->DstPog->compile = true;
		
		$out = array(
			'fogs' => array(),
			'pogs' => array(),
			'aliases' => array(),
			'rules' => array(),
		);
		
		$rules = $this->find($type, $query);
		if(!$rules) return $out;
		$out['rules'] = $rules;
		
		$ipaddresses = array();
		
		foreach($rules as $rule)
		{
			// compile the compiled rules together
//			$out['compiled'][$rule[$this->alias]['compiled']] = $rule[$this->alias]['compiled'];
		
			// compile the FOGS
			if(isset($rule['SrcFog']['id']) and $rule['SrcFog']['id'])
			{
				if(!isset($out['fogs'][$rule['SrcFog']['id']]))
				{
					$out['fogs'][$rule['SrcFog']['id']] = $rule['SrcFog'];
				}
				
				// track for the hostaliases
				if(isset($rule['SrcFog']['ip_addresses']) and $rule['SrcFog']['ip_addresses'])
				{
					$ip_addresses = explode("\n", $rule['SrcFog']['ip_addresses']);
					foreach($ip_addresses as $ip_address)
					{
						if($this->EX_discoverType($ip_address) == 'ipaddress')
						{
							$ipaddresses[$ip_address] = $ip_address;
						}
					}
				}
			}
			
			if(isset($rule['DstFog']['id']) and $rule['DstFog']['id'])
			{
				if(!isset($out['fogs'][$rule['DstFog']['id']]))
				{
					$out['fogs'][$rule['DstFog']['id']] = $rule['DstFog'];
				}
				
				// track for the hostaliases
				if(isset($rule['DstFog']['ip_addresses']) and $rule['DstFog']['ip_addresses'])
				{
					$ip_addresses = explode("\n", $rule['DstFog']['ip_addresses']);
					foreach($ip_addresses as $ip_address)
					{
						if($this->EX_discoverType($ip_address) == 'ipaddress')
						{
							$ipaddresses[$ip_address] = $ip_address;
						}
					}
				}
			}
			
			// compile the POGS
			if(isset($rule['SrcPog']['id']) and $rule['SrcPog']['id'])
			{
				if(!isset($out['pogs'][$rule['SrcPog']['id']]))
				{
					$out['pogs'][$rule['SrcPog']['id']] = $rule['SrcPog'];
				}
			}
			
			if(isset($rule['DstPog']['id']) and $rule['DstPog']['id'])
			{
				if(!isset($out['pogs'][$rule['DstPog']['id']]))
				{
					$out['pogs'][$rule['DstPog']['id']] = $rule['DstPog'];
				}
			}
			
			// compile for the aliases
			if(isset($rule[$this->alias]['src_ip']) and trim($rule[$this->alias]['src_ip']))
			{
				if($this->EX_discoverType($rule[$this->alias]['src_ip']) == 'ipaddress')
				{
					$ipaddresses[$rule[$this->alias]['src_ip']] = $rule[$this->alias]['src_ip'];
				}
			}
			if(isset($rule[$this->alias]['dst_ip']) and trim($rule[$this->alias]['dst_ip']))
			{
				if($this->EX_discoverType($rule[$this->alias]['dst_ip']) == 'ipaddress')
				{
					$ipaddresses[$rule[$this->alias]['dst_ip']] = $rule[$this->alias]['dst_ip'];
				}
			}
		}
		
		// get the aliases list
		$aliases = array();
		
		foreach($ipaddresses as $ipaddress)
		{
			if($aliases = $this->Import->HostAlias->IpLookup($ipaddress, array(), 'ipaddress', true))
			{
				foreach($aliases as $alias)
				{
					$out['aliases'][$ipaddress][$alias] = $alias;
				}
			}
		}
		ksort($out['aliases']);
		
		return $out;
	}
	
	public function rescan($rule = [])
	{
		$this->modelError = false;
		if(!isset($rule[$this->alias]['id']) or !$rule[$this->alias]['id'])
		{
			$this->modelError = __('Unknown %s', __('Rule'));
			return false;
		}
		if(!isset($rule[$this->alias]['raw']) or !$rule[$this->alias]['raw'])
		{
			$this->modelError = __('Unknown %s Original line', __('Rule'));
			return false;
		}
		
		$reprocessed = $this->FCP_processRuleLine($rule[$this->alias]['raw']);
pr($reprocessed);
exit;
	}
	
	public function rehashAll()
	{
		$rules = $this->find('all', ['recursive' => -1]);
		
		foreach($rules as $rule)
		{
			if($rule[$this->alias]['raw'])
			{
				$hash = sha1(trim($rule[$this->alias]['raw']));
				$this->id = $rule[$this->alias]['id'];
				$this->saveField('hash', $hash);
			}
		}
	}
	
	public function updateFlowReport($data = array())
	{
		$inputFileName = $data[$this->alias]['file']['tmp_name'];
		$saveFileName = $data[$this->alias]['file']['name'];
		
		$fog_cache = array();
		$pog_cache = array();
		
		App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel/Classes/PHPExcel/IOFactory.php'));
//		App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel/Classes/PHPExcel/IOFactory.php'));
		
		$baseDate = PHPExcel_Shared_Date::getExcelCalendar();
		
		// find out which type of 
		$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
		
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objReader->setReadDataOnly(false);
		
		$objPHPExcel = $objReader->load($inputFileName);
		
		$letters = range('A', 'Z');
		
		$sheet_index = 0;
		foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) 
		{
			$sheet_index = $objPHPExcel->getIndex($worksheet);
			$objPHPExcel->setActiveSheetIndex($sheet_index);
			
			$objWorksheet = $objPHPExcel->getActiveSheet();
			$highestColumm = $objWorksheet->getHighestColumn();
			$colNumber = PHPExcel_Cell::columnIndexFromString($highestColumm);
			
			//$colNumber++; // not needed as it seems to have auto-iterated somewhere
			$src_fog_column = PHPExcel_Cell::stringFromColumnIndex($colNumber);
			$colNumber++;
			$dst_fog_column = PHPExcel_Cell::stringFromColumnIndex($colNumber);
			$colNumber++;
			$dst_pog_column = PHPExcel_Cell::stringFromColumnIndex($colNumber);
			$row_index=0;
			
			$headers = array();
			$first = true;
			
			foreach ($objWorksheet->getRowIterator() as $row_num => $row)
			{
				$cellIterator = $row->getCellIterator();
				$cellIterator->setIterateOnlyExistingCells(false);
				$objWorksheet->getRowDimension($row_num)->setVisible(true);
				
				// track the headers
				if($first)
				{
					$objWorksheet->setCellValue($src_fog_column.$row_num,'SRC_FOG');
					$objWorksheet->setCellValue($dst_fog_column.$row_num,'DST_FOG');
					$objWorksheet->setCellValue($dst_pog_column.$row_num,'DST_POG');
					$first = false;
					
					// track the header names
					foreach ($cellIterator as $cell_num => $cell)
					{
						$headers[$cell_num] = $cell->getFormattedValue();
					}
					
					continue;
				}
				
				$cell_index=0;
				$filled_src_fog = false;
				$filled_dst_fog = false;
				$filled_dst_pog = false;
				foreach ($cellIterator as $cell_num => $cell)
				{
					$cell_value = $cell->getFormattedValue();
					$cell_value = trim($cell_value);
					if($this->EX_discoverType($cell_value) === 'ipaddress')
					{	
						// look up the ip address in the db for the Fogs
						$fogs = array();
						if(isset($fog_cache[$cell_value]))
						{
							$fogs = $fog_cache[$cell_value];
						}
						else
						{
							$fogs = $this->SrcFog->find('list', array(
								'fields' => array('SrcFog.id', 'SrcFog.name'),
								'conditions' => array('SrcFog.ip_addresses  LIKE' => '%'.$cell_value.'%'),
							));
							$fog_cache[$cell_value] = $fogs;
						}
						
						// update the cell
						$header = strtolower(trim($headers[$cell_num]));
						if($header == 'src_ip')
						{
							$objWorksheet->setCellValue($src_fog_column.$row_num, implode(', ', $fogs));
						}
						elseif($header == 'dst_ip')
						{
							$objWorksheet->setCellValue($dst_fog_column.$row_num, implode(', ', $fogs));
						}
					}
					elseif(preg_match('/^\d+$/', $cell_value))
					{
						$pogs = array();
						if(isset($pogs_cache[$cell_value]))
						{
							$pogs = $pogs_cache[$cell_value];
						}
						else
						{
							$pogs = $this->SrcPog->find('list', array(
								'fields' => array('SrcPog.id', 'SrcPog.name'),
								'conditions' => array('SrcPog.ports  LIKE' => '%'.$cell_value.'%'),
							));
							$pogs_cache[$cell_value] = $pogs;
						}
						
						// update the cell
						$header = strtolower(trim($headers[$cell_num]));
						if($header == 'dst_prt')
						{
							$objWorksheet->setCellValue($dst_pog_column.$row_num, implode(', ', $pogs));
						}
					}
					$cell_index++;
				}
				
				$first = false;
				$row_index++;
			}
			
			$sheet_index++;
		}
		
		$objPHPExcel->setActiveSheetIndex(0);
			
		// now save the file
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $inputFileType);
		$objWriter->save(DS.'tmp'.DS.$saveFileName);
		
		$filename_parts = explode('.', $saveFileName);
		$ext = array_pop($filename_parts);
		$filename = implode('.', $filename_parts);
		
		$params = array(
			'id' => $saveFileName,
			'name'      => $filename,
			'download'  => true,
			'extension' => $ext,
			'path'      => DS.'tmp'.DS,
		);
		
		return $params;
	}
	
	public function fismaBreakout($criteria = [])
	{
		$rules = $this->find('all', $criteria);
		$rules = $this->attachFismaSystems($rules);
		
		$_rules = [];
		$_i=0;
		foreach($rules as $i => $rule)
		{
			$_i++;
			$_rules[$_i] = $rule;
			
			if(count($rule['SrcFismaSystems']))
			{
				foreach($rule['SrcFismaSystems'] as $j => $fismaSystem)
				{
					$_rules[$_i] = $rule;
					$_rules[$_i]['SrcFismaSystems'] = [0 => $fismaSystem];
					$_i++;
				}
			}
		}
		
		$rules = $_rules;
		$_rules = [];
		$_i=0;
		foreach($rules as $i => $rule)
		{
			$_i++;
			$_rules[$_i] = $rule;
			
			if(count($rule['DstFismaSystems']))
			{
				foreach($rule['DstFismaSystems'] as $j => $fismaSystem)
				{
					$_rules[$_i] = $rule;
					$_rules[$_i]['DstFismaSystems'] = [0 => $fismaSystem];
					$_i++;
				}
			}
		}
		
		$rules = $_rules;
		$_rules = [];
		
		return $rules;
	}
	
	public function attachFismaSystems($rules = [])
	{
		$fismaCache = [];
		
		foreach($rules as $i => $rule)
		{
			$rules[$i]['SrcFismaSystems'] = [];
			$rules[$i]['DstFismaSystems'] = [];
			
			// Temp hack for all of NIH
			if(isset($rule['Rule']['src_fog_id']) and in_array($rule['Rule']['src_fog_id'], [430, 156]))
			{
				$rules[$i]['SrcFismaSystems'] = [0 => [
					'SrcFismaSystem' => ['id' => 0, 'name' => __('Any NIHnet System')],
					'OwnerContact' => [
						'Sac' => [
							'id' => 999,
							'shortname' => __('Any NIH'),
							'Branch' => [
								'id' => 999,
								'shortname' => __('Any NIH'),
								'Division' => [
									'id' => 999,
									'shortname' => __('Any NIH'),
									'Org' => [
										'id' => 999,
										'shortname' => __('Any NIH'),
									]
								]
							]
						]
					]
				]];
			}
			
			if(isset($rule['Rule']['dst_fog_id']) and in_array($rule['Rule']['dst_fog_id'], [430, 156]))
			{
				$rules[$i]['DstFismaSystems'] = [0 => [
					'DstFismaSystem' => ['id' => 0, 'name' => __('Any NIHnet System')],
					'OwnerContact' => [
						'Sac' => [
							'id' => 999,
							'shortname' => __('Any NIH'),
							'Branch' => [
								'id' => 999,
								'shortname' => __('Any NIH'),
								'Division' => [
									'id' => 999,
									'shortname' => __('Any NIH'),
									'Org' => [
										'id' => 999,
										'shortname' => __('Any NIH'),
									]
								]
							]
						]
					]
				]];
			}
			
			// only try to map the rules with their actual source and/or destination ips are set
			// Source
			if(!$rules[$i]['SrcFismaSystems']
				and isset($rule[$this->alias]['src_fisma_system_id']) 
				and !$rule[$this->alias]['src_fisma_system_id']
			)
			{
				if($ipAddresses = $this->getIpAddresses($rule))
				{
					$rules[$i]['SrcFismaSystems'] = $this->SrcFismaSystem->getSystemsFromIps($ipAddresses, ['contain' => ['OwnerContact.Sac.Branch.Division.Org'], 'recursive' => 0]);
				}
				
			}
			
			// Destination
			if(!$rules[$i]['DstFismaSystems']
				and isset($rule[$this->alias]['dst_fisma_system_id']) 
				and !$rule[$this->alias]['dst_fisma_system_id']
			)
			{
				if($ipAddresses = $this->getIpAddresses($rule, false))
				{
					$rules[$i]['DstFismaSystems'] = $this->DstFismaSystem->getSystemsFromIps($ipAddresses, ['contain' => ['OwnerContact.Sac.Branch.Division.Org'], 'recursive' => 0]);
				}
				
			}
		}
		
		return $rules;
	}
	
	public function getIpAddresses($rule = [], $src = true)
	{
		$this->loadCommonNetwork();
		
		// get a list of all inventory with ip addresses
		if(!$this->invIpaddresses)
		{
			$this->invIpaddresses = $this->SrcFismaSystem->FismaInventory->find('list', [
				'recursive' => -1,
				'conditions' => ['FismaInventory.ip_address !=' => ''],
				'fields' => ['FismaInventory.ip_address', 'FismaInventory.ip_address'],
			]);
			
			foreach($this->invIpaddresses as $invIpaddress => $invIpaddress2)
			{
				if(!$ipLong = $this->CommonNetwork->convertIpToLong($invIpaddress))
				{
					unset($this->invIpaddresses[$invIpaddress]);
					continue;
				}
				$this->invIpaddresses[$invIpaddress] = $ipLong;
			}
		}
		
		$ipAddresses = [];
		$_ipAddresses = [];
		
		// source
		if($src)
		{
			// fog is a priority
			if(isset($rule[$this->alias]['use_src_fog']) and $rule[$this->alias]['use_src_fog'])
			{
				if(isset($rule['SrcFog']['ip_addresses']))
				{
					$_ipAddresses = strtolower($rule['SrcFog']['ip_addresses']);
					$_ipAddresses = trim($_ipAddresses);
					$_ipAddresses = preg_split('/(\n+|,)/', $_ipAddresses);
				}
			}
			// use the set ip address
			elseif(isset($rule[$this->alias]['src_ip']) and $rule[$this->alias]['src_ip'])
			{
				$_ipAddresses = strtolower($rule[$this->alias]['src_ip']);
				$_ipAddresses = trim($_ipAddresses);
				$_ipAddresses = preg_split('/(\n+|,)/', $_ipAddresses);
			}
		}
		// destination
		else
		{
			// fog is a priority
			if(isset($rule[$this->alias]['use_dst_fog']) and $rule[$this->alias]['use_dst_fog'])
			{
				if(isset($rule['DstFog']['ip_addresses']))
				{
					$_ipAddresses = strtolower($rule['DstFog']['ip_addresses']);
					$_ipAddresses = trim($_ipAddresses);
					$_ipAddresses = preg_split('/(\n+|,)/', $_ipAddresses);
				}
			}
			// use the set ip address
			elseif(isset($rule[$this->alias]['dst_ip']) and $rule[$this->alias]['dst_ip'])
			{
				$_ipAddresses = strtolower($rule[$this->alias]['dst_ip']);
				$_ipAddresses = trim($_ipAddresses);
				$_ipAddresses = preg_split('/(\n+|,)/', $_ipAddresses);
			}
		}
		
		if(!$ipAddresses)
		{
			$_ipAddresses = array_flip($_ipAddresses);
			$_ipAddresses = array_flip($_ipAddresses);
			
			foreach($_ipAddresses as $ipAddress)
			{
				$ipAddress = strtolower($ipAddress);
				$ipAddress = trim($ipAddress);
				
				// netmask range
				if(preg_match('/\s+/', $ipAddress))
				{
					$parts = preg_split('/\s+/', $ipAddress);
					if(substr($parts[1], 0, 4) != '255.') // not a netmask
						continue;
					$network = $parts[0];
					$networkLong = $this->CommonNetwork->convertIpToLong($network);
					$netmask = $parts[1];
					$cidr = $this->CommonNetwork->netmaskToCidr($netmask);
					
					// check all of the inventroy and see if the ip address falls withing this network
					foreach($this->invIpaddresses as $invIpaddress => $invLong)
					{
						if(($invLong & ~((1 << (32 - $cidr)) - 1) ) == $networkLong)
						{
							$ipAddresses[$invIpaddress] = $invIpaddress;
						}
					}
					continue;
				}
				
				if(!in_array($this->EX_discoverType($ipAddress), ['hostname', 'ipaddress']))
					continue;
				$ipAddresses[$ipAddress] = $ipAddress;
			}
		}
		$_ipAddresses = [];
		
		return $ipAddresses;
	}
	
	public function loadCommonNetwork()
	{
		if(!$this->CommonNetwork)
		{
			App::uses('CommonNetwork', 'Utilities.Lib');
			$this->CommonNetwork = new CommonNetwork();
		}
	}
}
