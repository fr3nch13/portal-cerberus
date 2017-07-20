<?php 
class AppSchema extends CakeSchema {

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $ad_account_details = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'ad_account_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'fisma_training_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'ad_account_id' => array('column' => 'ad_account_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $ad_accounts_fisma_systems = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'ad_account_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'fisma_system_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'fisma_contact_type_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'primary_priority' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 5, 'unsigned' => false, 'key' => 'index'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'ad_account_id' => array('column' => 'ad_account_id', 'unique' => 0),
			'fisma_system_id' => array('column' => 'fisma_system_id', 'unique' => 0),
			'fisma_contact_type_id' => array('column' => 'fisma_contact_type_id', 'unique' => 0),
			'primary_priority' => array('column' => 'primary_priority', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $eol_report_files = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'eol_report_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'unsigned' => false, 'key' => 'index'),
		'filename' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'nicename' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'notes' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'eol_report_id' => array('column' => 'eol_report_id', 'unique' => 0),
			'user_id' => array('column' => 'user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $eol_reports = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'added_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'notes' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'filename' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'report_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'added_user_id' => array('column' => 'added_user_id', 'unique' => 0),
			'modified_user_id' => array('column' => 'modified_user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $eol_reports_eol_results = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'eol_report_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'eol_result_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'eol_result_id' => array('column' => 'eol_result_id', 'unique' => 0),
			'eol_report_id' => array('column' => 'eol_report_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $eol_result_logs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'eol_result_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'added_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'severity_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'organization_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'assignable_party_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'verification_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'status_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'remediation_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'eol_software_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_severity_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_assignable_party_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_organization_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_remediation_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_verification_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_status_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'fisma_system_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'ticket_id' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'severity_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'organization_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'assignable_party_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'fisma_software_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'nessus' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'tickets' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'host_description' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'ip_address' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'host_name' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'mac_address' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'asset_tag' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'service' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'vulnerability' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'software' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'netbios' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'user_account_name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'remediation_poc' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'verified_by' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'waiver' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'changerequest' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'hw_price' => array('type' => 'decimal', 'null' => false, 'default' => '0.00', 'length' => '10,2', 'unsigned' => false),
		'sw_price' => array('type' => 'decimal', 'null' => false, 'default' => '0.00', 'length' => '10,2', 'unsigned' => false),
		'description' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'action_recommended' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'action_taken' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'comments' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'notes' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'reported_to_ic_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'resolved_by_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'action_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'remediation_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'verification_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'status_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'nslookup_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'added_user_id' => array('column' => 'added_user_id', 'unique' => 0),
			'modified_user_id' => array('column' => 'modified_user_id', 'unique' => 0),
			'eol_software_id' => array('column' => 'eol_software_id', 'unique' => 0),
			'reports_severity_id' => array('column' => 'reports_severity_id', 'unique' => 0),
			'verification_user_id' => array('column' => 'verification_user_id', 'unique' => 0),
			'remediation_user_id' => array('column' => 'remediation_user_id', 'unique' => 0),
			'reports_remediation_id' => array('column' => 'reports_remediation_id', 'unique' => 0),
			'reports_verification_id' => array('column' => 'reports_verification_id', 'unique' => 0),
			'status_user_id' => array('column' => 'status_user_id', 'unique' => 0),
			'reports_status_id' => array('column' => 'reports_status_id', 'unique' => 0),
			'reports_assignable_party_id' => array('column' => 'reports_assignable_party_id', 'unique' => 0),
			'fisma_software_id' => array('column' => 'fisma_software_id', 'unique' => 0),
			'reports_organization_id' => array('column' => 'reports_organization_id', 'unique' => 0),
			'fisma_system_id' => array('column' => 'fisma_system_id', 'unique' => 0),
			'ip_address' => array('column' => 'ip_address', 'unique' => 0),
			'host_name' => array('column' => 'host_name', 'unique' => 0),
			'mac_address' => array('column' => 'mac_address', 'unique' => 0),
			'asset_tag' => array('column' => 'asset_tag', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $eol_results = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'added_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'severity_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'organization_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'assignable_party_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'verification_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'status_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'remediation_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'eol_software_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_severity_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_assignable_party_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_organization_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_remediation_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_verification_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_status_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'fisma_system_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'ticket_id' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'severity_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'organization_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'assignable_party_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'fisma_software_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'nessus' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'tickets' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'host_description' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'ip_address' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'host_name' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'mac_address' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'asset_tag' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'service' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'vulnerability' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'software' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'netbios' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'user_account_name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'remediation_poc' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'verified_by' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'waiver' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'changerequest' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'hw_price' => array('type' => 'decimal', 'null' => false, 'default' => '0.00', 'length' => '10,2', 'unsigned' => false),
		'sw_price' => array('type' => 'decimal', 'null' => false, 'default' => '0.00', 'length' => '10,2', 'unsigned' => false),
		'description' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'action_recommended' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'action_taken' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'comments' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'notes' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'reported_to_ic_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'resolved_by_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'action_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'remediation_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'verification_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'status_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'nslookup_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'added_user_id' => array('column' => 'added_user_id', 'unique' => 0),
			'modified_user_id' => array('column' => 'modified_user_id', 'unique' => 0),
			'eol_software_id' => array('column' => 'eol_software_id', 'unique' => 0),
			'reports_severity_id' => array('column' => 'reports_severity_id', 'unique' => 0),
			'verification_user_id' => array('column' => 'verification_user_id', 'unique' => 0),
			'remediation_user_id' => array('column' => 'remediation_user_id', 'unique' => 0),
			'reports_remediation_id' => array('column' => 'reports_remediation_id', 'unique' => 0),
			'reports_verification_id' => array('column' => 'reports_verification_id', 'unique' => 0),
			'status_user_id' => array('column' => 'status_user_id', 'unique' => 0),
			'reports_status_id' => array('column' => 'reports_status_id', 'unique' => 0),
			'reports_assignable_party_id' => array('column' => 'reports_assignable_party_id', 'unique' => 0),
			'fisma_software_id' => array('column' => 'fisma_software_id', 'unique' => 0),
			'reports_organization_id' => array('column' => 'reports_organization_id', 'unique' => 0),
			'fisma_system_id' => array('column' => 'fisma_system_id', 'unique' => 0),
			'ip_address' => array('column' => 'ip_address', 'unique' => 0),
			'host_name' => array('column' => 'host_name', 'unique' => 0),
			'mac_address' => array('column' => 'mac_address', 'unique' => 0),
			'asset_tag' => array('column' => 'asset_tag', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $eol_software_aliases = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'eol_software_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'eol_software_id' => array('column' => 'eol_software_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $eol_softwares = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'is_us' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_vuln' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'family' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'severity' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'assignable_party_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'remediation_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'verification_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_assignable_party_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_remediation_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_verification_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'assignable_party_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'remediation_poc' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'verified_by' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'tickets' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'waiver' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'changerequest' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'hw_price' => array('type' => 'decimal', 'null' => false, 'default' => '0.00', 'length' => '10,2', 'unsigned' => false),
		'sw_price' => array('type' => 'decimal', 'null' => false, 'default' => '0.00', 'length' => '10,2', 'unsigned' => false),
		'action_recommended' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'action_taken' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'notes' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'resolved_by_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'action_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'remediation_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'verification_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'verification_user_id' => array('column' => 'verification_user_id', 'unique' => 0),
			'remediation_user_id' => array('column' => 'remediation_user_id', 'unique' => 0),
			'reports_assignable_party_id' => array('column' => 'reports_assignable_party_id', 'unique' => 0),
			'reports_remediation_id' => array('column' => 'reports_remediation_id', 'unique' => 0),
			'reports_verification_id' => array('column' => 'reports_verification_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $firewalls = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'import_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'added_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'slug' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'hostname' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'domain_name' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'motd' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'simple' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'import_id' => array('column' => 'import_id', 'unique' => 0),
			'added_user_id' => array('column' => 'added_user_id', 'unique' => 0),
			'modified_user_id' => array('column' => 'modified_user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fisma_contact_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'details' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'is_saa' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'key' => 'index'),
		'is_tech' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'key' => 'index'),
		'is_daa' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'key' => 'index'),
		'is_isso' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'key' => 'index'),
		'primary_priority' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 5, 'unsigned' => false, 'key' => 'index'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'is_saa' => array('column' => 'is_saa', 'unique' => 0),
			'primary_priority' => array('column' => 'primary_priority', 'unique' => 0),
			'is_tech' => array('column' => 'is_tech', 'unique' => 0),
			'is_daa' => array('column' => 'is_daa', 'unique' => 0),
			'is_isso' => array('column' => 'is_isso', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fisma_inventories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'fisma_system_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'added_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'fisma_type_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'fisma_status_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'fisma_source_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'name' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'contact_name' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'contact_email' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'mac_address' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'asset_tag' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'ip_address' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'nat_ip_address' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'dns_name' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'purpose' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'url' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'location' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'notes' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fisma_system_id' => array('column' => 'fisma_system_id', 'unique' => 0),
			'added_user_id' => array('column' => 'added_user_id', 'unique' => 0),
			'modified_user_id' => array('column' => 'modified_user_id', 'unique' => 0),
			'fisma_type_id' => array('column' => 'fisma_type_id', 'unique' => 0),
			'fisma_status_id' => array('column' => 'fisma_status_id', 'unique' => 0),
			'fisma_source_id' => array('column' => 'fisma_source_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fisma_inventory_files = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'fisma_inventory_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'unsigned' => false, 'key' => 'index'),
		'filename' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'nicename' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'notes' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fisma_inventory_id' => array('column' => 'fisma_inventory_id', 'unique' => 0),
			'user_id' => array('column' => 'user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fisma_inventory_logs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'fisma_inventory_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'unsigned' => false, 'key' => 'index'),
		'new_fisma_system_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'new_fisma_type_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'new_fisma_status_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'new_fisma_source_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'new_name' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'new_contact_name' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'new_contact_email' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'new_mac_address' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'new_asset_tag' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'new_host_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'new_ip_address' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'new_dns_name' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'new_purpose' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'new_notes' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'old_fisma_system_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'old_fisma_type_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'old_fisma_status_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'old_fisma_source_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'old_name' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'old_contact_name' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'old_contact_email' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'old_mac_address' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'old_asset_tag' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'old_host_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'old_ip_address' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'old_dns_name' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'old_purpose' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'old_notes' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fisma_inventory_id' => array('column' => 'fisma_inventory_id', 'unique' => 0),
			'new_fisma_system_id' => array('column' => 'new_fisma_system_id', 'unique' => 0),
			'new_fisma_type_id' => array('column' => 'new_fisma_type_id', 'unique' => 0),
			'new_fisma_status_id' => array('column' => 'new_fisma_status_id', 'unique' => 0),
			'old_fisma_system_id' => array('column' => 'old_fisma_system_id', 'unique' => 0),
			'old_fisma_type_id' => array('column' => 'old_fisma_type_id', 'unique' => 0),
			'old_fisma_status_id' => array('column' => 'old_fisma_status_id', 'unique' => 0),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'new_fisma_source_id' => array('column' => 'new_fisma_source_id', 'unique' => 0),
			'old_fisma_source_id' => array('column' => 'old_fisma_source_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fisma_software_groups = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'details' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fisma_software_sources = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'details' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fisma_softwares = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'fisma_software_group_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'fisma_software_source_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'added_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'all' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'key' => 'index'),
		'approved' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'key' => 'index'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'version' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'filename' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'notes' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fisma_software_group_id' => array('column' => 'fisma_software_group_id', 'unique' => 0),
			'fisma_software_source_id' => array('column' => 'fisma_software_source_id', 'unique' => 0),
			'added_user_id' => array('column' => 'added_user_id', 'unique' => 0),
			'modified_user_id' => array('column' => 'modified_user_id', 'unique' => 0),
			'all' => array('column' => 'all', 'unique' => 0),
			'approved' => array('column' => 'approved', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fisma_softwares_fisma_systems = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'fisma_software_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'fisma_system_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fisma_software_id' => array('column' => 'fisma_software_id', 'unique' => 0),
			'fisma_system_id' => array('column' => 'fisma_system_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fisma_sources = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'instructions' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'default' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'notify_email' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'notify_time' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false),
		'sendemail' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'mon' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'tue' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'wed' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'thu' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'fri' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'sat' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'sun' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fisma_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'instructions' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'default' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'notify_email' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'notify_time' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false),
		'sendemail' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'mon' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'tue' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'wed' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'thu' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'fri' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'sat' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'sun' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fisma_system_affected_parties = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'details' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fisma_system_amounts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'rating' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'details' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fisma_system_com_totals = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'rating' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'details' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fisma_system_criticalities = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'details' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fisma_system_dependencies = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'rating' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'details' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fisma_system_file_states = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fisma_system_files = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'fisma_system_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'unsigned' => false, 'key' => 'index'),
		'fisma_system_file_state_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'raf' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'key' => 'index'),
		'filename' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'nicename' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'notes' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'expiration_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fisma_system_id' => array('column' => 'fisma_system_id', 'unique' => 0),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'fisma_system_file_state_id' => array('column' => 'fisma_system_file_state_id', 'unique' => 0),
			'raf' => array('column' => 'raf', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fisma_system_fips_ratings = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'details' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'color_code_hex' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fisma_system_gss_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'details' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fisma_system_hostings = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'details' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fisma_system_impacts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'rating' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'details' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fisma_system_interconnections = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'details' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fisma_system_life_safeties = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'details' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fisma_system_nihlogins = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'rating' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'details' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fisma_system_nists = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'details' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fisma_system_poam_completion_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'details' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fisma_system_poam_status_logs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'fisma_system_poam_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'unsigned' => false, 'key' => 'index'),
		'status' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fisma_system_poam_id' => array('column' => 'fisma_system_poam_id', 'unique' => 0),
			'user_id' => array('column' => 'user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fisma_system_poams = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'fisma_system_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'fisma_system_poam_completion_status_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'added_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'closed' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'key' => 'index'),
		'weakness_id' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'controls' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'weakness' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'solution' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'scheduled_completion' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'closed_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fisma_system_id' => array('column' => 'fisma_system_id', 'unique' => 0),
			'fisma_system_poam_completion_status_id' => array('column' => 'fisma_system_poam_completion_status_id', 'unique' => 0),
			'added_user_id' => array('column' => 'added_user_id', 'unique' => 0),
			'modified_user_id' => array('column' => 'modified_user_id', 'unique' => 0),
			'closed' => array('column' => 'closed', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fisma_system_risk_assessments = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'details' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fisma_system_sensitivity_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'rating' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'details' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fisma_system_sensitivity_ratings = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'rating' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'details' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fisma_system_threat_assessments = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'rating' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'details' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fisma_system_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'details' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fisma_system_uniquenesses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'rating' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'details' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fisma_systems = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'unsigned' => false),
		'added_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'daa_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'daar_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'isso_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'aisso_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'fisma_system_fips_rating_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'fisma_system_risk_assessment_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'fisma_system_threat_assessment_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'fisma_system_hosting_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'fisma_system_interconnection_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'fisma_system_gss_status_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'fisma_system_type_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'fisma_system_com_total_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'fisma_system_impact_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'fisma_system_uniqueness_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'fisma_system_amount_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'fisma_system_nihlogin_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'fisma_system_sensitivity_category_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'fisma_system_sensitivity_rating_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'fisma_system_dependency_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'fisma_system_nist_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'fisma_system_life_safety_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'fisma_system_criticality_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'fisma_system_affected_party_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'name' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'fullname' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'owner_contact_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'owner_name' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'owner_email' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'business_contact_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'tech_contact_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'tech_name' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'tech_email' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'opdiv' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'uuid' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'notes' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'daar_notes' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'isso_notes' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'fo_notes' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'comments' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'impact' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'simple' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'is_rogue' => array('type' => 'integer', 'null' => false, 'default' => '1', 'unsigned' => false, 'key' => 'index'),
		'fisma_reportable' => array('type' => 'integer', 'null' => false, 'default' => '1', 'unsigned' => false, 'key' => 'index'),
		'ongoing_auth' => array('type' => 'integer', 'null' => false, 'default' => '1', 'unsigned' => false, 'key' => 'index'),
		'ato_expiration' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'pii_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'added_user_id' => array('column' => 'added_user_id', 'unique' => 0),
			'modified_user_id' => array('column' => 'modified_user_id', 'unique' => 0),
			'daa_user_id' => array('column' => 'daa_user_id', 'unique' => 0),
			'daar_user_id' => array('column' => 'daar_user_id', 'unique' => 0),
			'isso_user_id' => array('column' => 'isso_user_id', 'unique' => 0),
			'aisso_user_id' => array('column' => 'aisso_user_id', 'unique' => 0),
			'fisma_system_fips_rating_id' => array('column' => 'fisma_system_fips_rating_id', 'unique' => 0),
			'fisma_system_risk_assessment_id' => array('column' => 'fisma_system_risk_assessment_id', 'unique' => 0),
			'fisma_system_threat_assessment_id' => array('column' => 'fisma_system_threat_assessment_id', 'unique' => 0),
			'fisma_system_hosting_id' => array('column' => 'fisma_system_hosting_id', 'unique' => 0),
			'fisma_system_interconnection_id' => array('column' => 'fisma_system_interconnection_id', 'unique' => 0),
			'fisma_system_gss_status_id' => array('column' => 'fisma_system_gss_status_id', 'unique' => 0),
			'fisma_reportable' => array('column' => 'fisma_reportable', 'unique' => 0),
			'ongoing_auth' => array('column' => 'ongoing_auth', 'unique' => 0),
			'pii_count' => array('column' => 'pii_count', 'unique' => 0),
			'owner_contact_id' => array('column' => 'owner_contact_id', 'unique' => 0),
			'business_contact_id' => array('column' => 'business_contact_id', 'unique' => 0),
			'tech_contact_id' => array('column' => 'tech_contact_id', 'unique' => 0),
			'is_rogue' => array('column' => 'is_rogue', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fisma_systems_physical_locations = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'fisma_system_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'physical_location_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fisma_system_id' => array('column' => 'fisma_system_id', 'unique' => 0),
			'physical_location_id' => array('column' => 'physical_location_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fisma_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'export_type' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'instructions' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'default' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'notify_email' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'notify_time' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false),
		'sendemail' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'mon' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'tue' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'wed' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'thu' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'fri' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'sat' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'sun' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fog_logs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'fog_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'unsigned' => false, 'key' => 'index'),
		'name' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'ip_addresses' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'old_name' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'old_ip_addresses' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'comments' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fog_id' => array('column' => 'fog_id', 'unique' => 0),
			'user_id' => array('column' => 'user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fogs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'added_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'firewall_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'import_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'slug' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'type' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'ip_addresses' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'simple' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'firewall_id' => array('column' => 'firewall_id', 'unique' => 0),
			'import_id' => array('column' => 'import_id', 'unique' => 0),
			'added_user_id' => array('column' => 'added_user_id', 'unique' => 0),
			'modified_user_id' => array('column' => 'modified_user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fogs_fogs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'added_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'parent_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'child_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'firewall_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'import_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'parent_id' => array('column' => 'parent_id', 'unique' => 0),
			'child_id' => array('column' => 'child_id', 'unique' => 0),
			'firewall_id' => array('column' => 'firewall_id', 'unique' => 0),
			'import_id' => array('column' => 'import_id', 'unique' => 0),
			'added_user_id' => array('column' => 'added_user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fov_hosts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'host_description' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'ip_address' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'host_name' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'mac_address' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'asset_tag' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'netbios' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'ip_address' => array('column' => 'ip_address', 'unique' => 0),
			'host_name' => array('column' => 'host_name', 'unique' => 0),
			'mac_address' => array('column' => 'mac_address', 'unique' => 0),
			'asset_tag' => array('column' => 'asset_tag', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fov_hosts_fov_results = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'fov_host_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'fov_result_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fov_host_id' => array('column' => 'fov_host_id', 'unique' => 0),
			'fov_result_id' => array('column' => 'fov_result_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fov_results = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'added_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'assignable_party_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'remediation_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'status_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'system_type_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'verification_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_assignable_party_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_organization_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_remediation_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_severity_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_status_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_system_type_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_verification_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'fisma_system_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'eol_software_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'tickets' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'waiver' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'changerequest' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'comments' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'notes' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'assignable_party_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'remediation_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'status_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'system_type_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'verification_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'severity_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'reported_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'resolved_by_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'estimated_remediation_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'added_user_id' => array('column' => 'added_user_id', 'unique' => 0),
			'modified_user_id' => array('column' => 'modified_user_id', 'unique' => 0),
			'remediation_user_id' => array('column' => 'remediation_user_id', 'unique' => 0),
			'status_user_id' => array('column' => 'status_user_id', 'unique' => 0),
			'verification_user_id' => array('column' => 'verification_user_id', 'unique' => 0),
			'reports_assignable_party_id' => array('column' => 'reports_assignable_party_id', 'unique' => 0),
			'reports_organization_id' => array('column' => 'reports_organization_id', 'unique' => 0),
			'reports_remediation_id' => array('column' => 'reports_remediation_id', 'unique' => 0),
			'reports_severity_id' => array('column' => 'reports_severity_id', 'unique' => 0),
			'reports_status_id' => array('column' => 'reports_status_id', 'unique' => 0),
			'reports_system_type_id' => array('column' => 'reports_system_type_id', 'unique' => 0),
			'reports_verification_id' => array('column' => 'reports_verification_id', 'unique' => 0),
			'fisma_system_id' => array('column' => 'fisma_system_id', 'unique' => 0),
			'eol_software_id' => array('column' => 'eol_software_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fw_interfaces = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'added_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'firewall_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'import_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'slug' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'simple' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'firewall_id' => array('column' => 'firewall_id', 'unique' => 0),
			'import_id' => array('column' => 'import_id', 'unique' => 0),
			'added_user_id' => array('column' => 'added_user_id', 'unique' => 0),
			'modified_user_id' => array('column' => 'modified_user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $fw_ints = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'added_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'firewall_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'fw_interface_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'name' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'firewall_id' => array('column' => 'firewall_id', 'unique' => 0),
			'fw_interface_id' => array('column' => 'fw_interface_id', 'unique' => 0),
			'added_user_id' => array('column' => 'added_user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $high_risk_report_files = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'high_risk_report_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'unsigned' => false, 'key' => 'index'),
		'filename' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'nicename' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'notes' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'high_risk_report_id' => array('column' => 'high_risk_report_id', 'unique' => 0),
			'user_id' => array('column' => 'user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $high_risk_reports = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'added_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'notes' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'filename' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'report_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'added_user_id' => array('column' => 'added_user_id', 'unique' => 0),
			'modified_user_id' => array('column' => 'modified_user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $high_risk_reports_high_risk_results = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'high_risk_report_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'high_risk_result_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'high_risk_result_id' => array('column' => 'high_risk_result_id', 'unique' => 0),
			'high_risk_report_id' => array('column' => 'high_risk_report_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $high_risk_result_logs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'high_risk_result_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'added_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'assignable_party_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'remediation_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'status_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'system_type_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'verification_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_assignable_party_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_remediation_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_status_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_system_type_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'assignable_party_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'reports_verification_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'fisma_system_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'ticket_id' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'vulnerability' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'vulnerability_slug' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'ip_address' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'port' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'unsigned' => false),
		'host_name' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'mac_address' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'asset_tag' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'dhs' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'responsible' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'ticket' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'waiver' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'changerequest' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'hw_price' => array('type' => 'decimal', 'null' => false, 'default' => '0.00', 'length' => '10,2', 'unsigned' => false),
		'sw_price' => array('type' => 'decimal', 'null' => false, 'default' => '0.00', 'length' => '10,2', 'unsigned' => false),
		'comments' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'notes' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'remediation_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'verification_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'status_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'system_type_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'eol_software_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reported_to_ic_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'resolved_by_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'estimated_remediation_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'nslookup_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'added_user_id' => array('column' => 'added_user_id', 'unique' => 0),
			'modified_user_id' => array('column' => 'modified_user_id', 'unique' => 0),
			'verification_user_id' => array('column' => 'verification_user_id', 'unique' => 0),
			'remediation_user_id' => array('column' => 'remediation_user_id', 'unique' => 0),
			'reports_remediation_id' => array('column' => 'reports_remediation_id', 'unique' => 0),
			'reports_verification_id' => array('column' => 'reports_verification_id', 'unique' => 0),
			'reports_status_id' => array('column' => 'reports_status_id', 'unique' => 0),
			'reports_assignable_party_id' => array('column' => 'reports_assignable_party_id', 'unique' => 0),
			'reports_system_type_id' => array('column' => 'reports_system_type_id', 'unique' => 0),
			'status_user_id' => array('column' => 'status_user_id', 'unique' => 0),
			'eol_software_id' => array('column' => 'eol_software_id', 'unique' => 0),
			'fisma_system_id' => array('column' => 'fisma_system_id', 'unique' => 0),
			'ip_address' => array('column' => 'ip_address', 'unique' => 0),
			'host_name' => array('column' => 'host_name', 'unique' => 0),
			'mac_address' => array('column' => 'mac_address', 'unique' => 0),
			'asset_tag' => array('column' => 'asset_tag', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $high_risk_results = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'added_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'assignable_party_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'remediation_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'status_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'system_type_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'verification_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_assignable_party_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_remediation_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_status_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_system_type_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'assignable_party_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'reports_verification_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'fisma_system_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'ticket_id' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'vulnerability' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'vulnerability_slug' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'ip_address' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'port' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'unsigned' => false),
		'host_name' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'mac_address' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'asset_tag' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'dhs' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'responsible' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'ticket' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'waiver' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'changerequest' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'hw_price' => array('type' => 'decimal', 'null' => false, 'default' => '0.00', 'length' => '10,2', 'unsigned' => false),
		'sw_price' => array('type' => 'decimal', 'null' => false, 'default' => '0.00', 'length' => '10,2', 'unsigned' => false),
		'comments' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'notes' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'remediation_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'verification_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'status_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'system_type_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'eol_software_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reported_to_ic_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'resolved_by_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'estimated_remediation_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'nslookup_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'added_user_id' => array('column' => 'added_user_id', 'unique' => 0),
			'modified_user_id' => array('column' => 'modified_user_id', 'unique' => 0),
			'verification_user_id' => array('column' => 'verification_user_id', 'unique' => 0),
			'remediation_user_id' => array('column' => 'remediation_user_id', 'unique' => 0),
			'reports_remediation_id' => array('column' => 'reports_remediation_id', 'unique' => 0),
			'reports_verification_id' => array('column' => 'reports_verification_id', 'unique' => 0),
			'reports_status_id' => array('column' => 'reports_status_id', 'unique' => 0),
			'reports_assignable_party_id' => array('column' => 'reports_assignable_party_id', 'unique' => 0),
			'reports_system_type_id' => array('column' => 'reports_system_type_id', 'unique' => 0),
			'status_user_id' => array('column' => 'status_user_id', 'unique' => 0),
			'eol_software_id' => array('column' => 'eol_software_id', 'unique' => 0),
			'fisma_system_id' => array('column' => 'fisma_system_id', 'unique' => 0),
			'ip_address' => array('column' => 'ip_address', 'unique' => 0),
			'host_name' => array('column' => 'host_name', 'unique' => 0),
			'mac_address' => array('column' => 'mac_address', 'unique' => 0),
			'asset_tag' => array('column' => 'asset_tag', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $host_aliases = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'added_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'import_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'firewall_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'host_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'slug' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'ip_address' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'alias' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'import_id' => array('column' => 'import_id', 'unique' => 0),
			'firewall_id' => array('column' => 'firewall_id', 'unique' => 0),
			'added_user_id' => array('column' => 'added_user_id', 'unique' => 0),
			'modified_user_id' => array('column' => 'modified_user_id', 'unique' => 0),
			'host_id' => array('column' => 'host_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $host_logs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'host_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'ip_address' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'hostname' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'mac_address' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'asset_tag' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $hosts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'ip_address' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'hostname' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'mac_address' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'asset_tag' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $hosts_fogs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'host_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'fog_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'host_id' => array('column' => 'host_id', 'unique' => 0),
			'fog_id' => array('column' => 'fog_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $imports = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'added_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'rescanned_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'name' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'filename' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'rescanned' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'added_user_id' => array('column' => 'added_user_id', 'unique' => 0),
			'modified_user_id' => array('column' => 'modified_user_id', 'unique' => 0),
			'rescanned_user_id' => array('column' => 'rescanned_user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $login_histories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => false, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'unsigned' => false, 'key' => 'index'),
		'email' => array('type' => 'string', 'null' => false, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'ipaddress' => array('type' => 'string', 'null' => false, 'length' => 20, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'user_agent' => array('type' => 'string', 'null' => false, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'success' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'key' => 'index'),
		'timestamp' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'ipaddress' => array('column' => 'ipaddress', 'unique' => 0),
			'success' => array('column' => 'success', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $mains = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $pen_test_report_files = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'pen_test_report_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'unsigned' => false, 'key' => 'index'),
		'filename' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'nicename' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'notes' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'pen_test_report_id' => array('column' => 'pen_test_report_id', 'unique' => 0),
			'user_id' => array('column' => 'user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $pen_test_reports = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'added_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_event_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'notes' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'filename' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'report_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'added_user_id' => array('column' => 'added_user_id', 'unique' => 0),
			'modified_user_id' => array('column' => 'modified_user_id', 'unique' => 0),
			'reports_event_id' => array('column' => 'reports_event_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $pen_test_reports_pen_test_results = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'pen_test_report_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'pen_test_result_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'pen_test_result_id' => array('column' => 'pen_test_result_id', 'unique' => 0),
			'pen_test_report_id' => array('column' => 'pen_test_report_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $pen_test_result_logs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'pen_test_result_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'added_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'severity_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'organization_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'assignable_party_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'verification_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'status_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'remediation_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'pen_test_report_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_severity_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_assignable_party_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_organization_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_remediation_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_verification_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_status_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'fisma_system_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'ticket_id' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'severity_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'organization_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'assignable_party_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'fisma_software_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'nessus' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'tickets' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'host_description' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'ip_address' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'host_name' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'mac_address' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'asset_tag' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'port' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'unsigned' => false),
		'service' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'eol_software_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'vulnerability' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'software' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'cve' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'netbios' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'user_account_name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'remediation_poc' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'verified_by' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'waiver' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'changerequest' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'hw_price' => array('type' => 'decimal', 'null' => false, 'default' => '0.00', 'length' => '10,2', 'unsigned' => false),
		'sw_price' => array('type' => 'decimal', 'null' => false, 'default' => '0.00', 'length' => '10,2', 'unsigned' => false),
		'description' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'action_recommended' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'action_taken' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'comments' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'notes' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'reported_to_ic_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'resolved_by_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'action_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'remediation_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'verification_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'status_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'nslookup_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'added_user_id' => array('column' => 'added_user_id', 'unique' => 0),
			'modified_user_id' => array('column' => 'modified_user_id', 'unique' => 0),
			'pen_test_report_id' => array('column' => 'pen_test_report_id', 'unique' => 0),
			'verification_user_id' => array('column' => 'verification_user_id', 'unique' => 0),
			'remediation_user_id' => array('column' => 'remediation_user_id', 'unique' => 0),
			'fisma_software_id' => array('column' => 'fisma_software_id', 'unique' => 0),
			'reports_severity_id' => array('column' => 'reports_severity_id', 'unique' => 0),
			'reports_remediation_id' => array('column' => 'reports_remediation_id', 'unique' => 0),
			'reports_verification_id' => array('column' => 'reports_verification_id', 'unique' => 0),
			'reports_status_id' => array('column' => 'reports_status_id', 'unique' => 0),
			'reports_assignable_party_id' => array('column' => 'reports_assignable_party_id', 'unique' => 0),
			'status_user_id' => array('column' => 'status_user_id', 'unique' => 0),
			'reports_organization_id' => array('column' => 'reports_organization_id', 'unique' => 0),
			'pen_test_result_id' => array('column' => 'pen_test_result_id', 'unique' => 0),
			'eol_software_id' => array('column' => 'eol_software_id', 'unique' => 0),
			'fisma_system_id' => array('column' => 'fisma_system_id', 'unique' => 0),
			'ip_address' => array('column' => 'ip_address', 'unique' => 0),
			'host_name' => array('column' => 'host_name', 'unique' => 0),
			'mac_address' => array('column' => 'mac_address', 'unique' => 0),
			'asset_tag' => array('column' => 'asset_tag', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $pen_test_results = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'added_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'severity_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'organization_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'assignable_party_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'verification_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'status_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'remediation_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'pen_test_report_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_severity_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_assignable_party_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_organization_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_remediation_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_verification_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_status_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'fisma_system_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'ticket_id' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'severity_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'organization_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'assignable_party_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'fisma_software_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'nessus' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'tickets' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'host_description' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'ip_address' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'host_name' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'mac_address' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'asset_tag' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'port' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'unsigned' => false),
		'service' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'eol_software_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'vulnerability' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'software' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'cve' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'netbios' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'user_account_name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'remediation_poc' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'verified_by' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'waiver' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'changerequest' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'hw_price' => array('type' => 'decimal', 'null' => false, 'default' => '0.00', 'length' => '10,2', 'unsigned' => false),
		'sw_price' => array('type' => 'decimal', 'null' => false, 'default' => '0.00', 'length' => '10,2', 'unsigned' => false),
		'description' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'action_recommended' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'action_taken' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'comments' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'notes' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'reported_to_ic_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'resolved_by_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'action_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'remediation_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'verification_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'status_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'nslookup_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'added_user_id' => array('column' => 'added_user_id', 'unique' => 0),
			'modified_user_id' => array('column' => 'modified_user_id', 'unique' => 0),
			'pen_test_report_id' => array('column' => 'pen_test_report_id', 'unique' => 0),
			'verification_user_id' => array('column' => 'verification_user_id', 'unique' => 0),
			'remediation_user_id' => array('column' => 'remediation_user_id', 'unique' => 0),
			'fisma_software_id' => array('column' => 'fisma_software_id', 'unique' => 0),
			'reports_severity_id' => array('column' => 'reports_severity_id', 'unique' => 0),
			'reports_remediation_id' => array('column' => 'reports_remediation_id', 'unique' => 0),
			'reports_verification_id' => array('column' => 'reports_verification_id', 'unique' => 0),
			'reports_status_id' => array('column' => 'reports_status_id', 'unique' => 0),
			'reports_assignable_party_id' => array('column' => 'reports_assignable_party_id', 'unique' => 0),
			'status_user_id' => array('column' => 'status_user_id', 'unique' => 0),
			'reports_organization_id' => array('column' => 'reports_organization_id', 'unique' => 0),
			'eol_software_id' => array('column' => 'eol_software_id', 'unique' => 0),
			'fisma_system_id' => array('column' => 'fisma_system_id', 'unique' => 0),
			'ip_address' => array('column' => 'ip_address', 'unique' => 0),
			'host_name' => array('column' => 'host_name', 'unique' => 0),
			'mac_address' => array('column' => 'mac_address', 'unique' => 0),
			'asset_tag' => array('column' => 'asset_tag', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $physical_locations = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'fullname' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'details' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $poam_criticalities = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'color_code_hex' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'show' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'key' => 'index'),
		'details' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'show' => array('column' => 'show', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $poam_report_files = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'poam_report_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'unsigned' => false, 'key' => 'index'),
		'filename' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'nicename' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'notes' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'poam_report_id' => array('column' => 'poam_report_id', 'unique' => 0),
			'user_id' => array('column' => 'user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $poam_reports = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'added_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'notes' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'filename' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'report_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'added_user_id' => array('column' => 'added_user_id', 'unique' => 0),
			'modified_user_id' => array('column' => 'modified_user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $poam_reports_poam_results = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'poam_report_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'poam_result_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'poam_result_id' => array('column' => 'poam_result_id', 'unique' => 0),
			'poam_report_id' => array('column' => 'poam_report_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $poam_result_logs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'poam_result_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'added_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'fisma_system_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'fisma_system_uuid' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'fisma_system_name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'poam_criticality_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'poam_risk_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'poam_severity_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'poam_status_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'auto_closed' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'key' => 'index'),
		'weakness_id' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'comments' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'risk_accepted' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'tickets' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'waiver' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'reported_to_ic_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'identified_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'creation_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'scheduled_completion_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'estimated_completion_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'actual_completion_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'poam_result_id' => array('column' => 'poam_result_id', 'unique' => 0),
			'added_user_id' => array('column' => 'added_user_id', 'unique' => 0),
			'modified_user_id' => array('column' => 'modified_user_id', 'unique' => 0),
			'fisma_system_id' => array('column' => 'fisma_system_id', 'unique' => 0),
			'poam_criticality_id' => array('column' => 'poam_criticality_id', 'unique' => 0),
			'poam_risk_id' => array('column' => 'poam_risk_id', 'unique' => 0),
			'poam_severity_id' => array('column' => 'poam_severity_id', 'unique' => 0),
			'poam_status_id' => array('column' => 'poam_status_id', 'unique' => 0),
			'auto_closed' => array('column' => 'auto_closed', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $poam_results = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'added_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'fisma_system_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'fisma_system_uuid' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'fisma_system_name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'poam_criticality_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'poam_risk_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'poam_severity_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'poam_status_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'auto_closed' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'key' => 'index'),
		'weakness_id' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'comments' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'risk_accepted' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'tickets' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'waiver' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'reported_to_ic_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'identified_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'creation_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'scheduled_completion_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'estimated_completion_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'actual_completion_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'added_user_id' => array('column' => 'added_user_id', 'unique' => 0),
			'modified_user_id' => array('column' => 'modified_user_id', 'unique' => 0),
			'fisma_system_id' => array('column' => 'fisma_system_id', 'unique' => 0),
			'poam_criticality_id' => array('column' => 'poam_criticality_id', 'unique' => 0),
			'poam_risk_id' => array('column' => 'poam_risk_id', 'unique' => 0),
			'poam_severity_id' => array('column' => 'poam_severity_id', 'unique' => 0),
			'poam_status_id' => array('column' => 'poam_status_id', 'unique' => 0),
			'auto_closed' => array('column' => 'auto_closed', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $poam_risks = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'color_code_hex' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'show' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'key' => 'index'),
		'details' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'show' => array('column' => 'show', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $poam_severities = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'color_code_hex' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'show' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'key' => 'index'),
		'details' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'show' => array('column' => 'show', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $poam_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'color_code_hex' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'show' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'key' => 'index'),
		'in_db' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'details' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'show' => array('column' => 'show', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $pog_logs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'pog_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'unsigned' => false, 'key' => 'index'),
		'name' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'ports' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'old_name' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'old_ports' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'comments' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'pog_id' => array('column' => 'pog_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $pogs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'added_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'firewall_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'import_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'protocol_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'slug' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'ports' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'simple' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'firewall_id' => array('column' => 'firewall_id', 'unique' => 0),
			'import_id' => array('column' => 'import_id', 'unique' => 0),
			'protocol_id' => array('column' => 'protocol_id', 'unique' => 0),
			'added_user_id' => array('column' => 'added_user_id', 'unique' => 0),
			'modified_user_id' => array('column' => 'modified_user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $pogs_pogs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'added_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'parent_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'child_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'firewall_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'import_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'parent_id' => array('column' => 'parent_id', 'unique' => 0),
			'child_id' => array('column' => 'child_id', 'unique' => 0),
			'firewall_id' => array('column' => 'firewall_id', 'unique' => 0),
			'import_id' => array('column' => 'import_id', 'unique' => 0),
			'added_user_id' => array('column' => 'added_user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $port_aliases = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'added_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'import_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'firewall_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'slug' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'port' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'alias' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'import_id' => array('column' => 'import_id', 'unique' => 0),
			'firewall_id' => array('column' => 'firewall_id', 'unique' => 0),
			'added_user_id' => array('column' => 'added_user_id', 'unique' => 0),
			'modified_user_id' => array('column' => 'modified_user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $protocols = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'added_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'firewall_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'import_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'slug' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'protocols' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'simple' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'firewall_id' => array('column' => 'firewall_id', 'unique' => 0),
			'import_id' => array('column' => 'import_id', 'unique' => 0),
			'added_user_id' => array('column' => 'added_user_id', 'unique' => 0),
			'modified_user_id' => array('column' => 'modified_user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $reports_assignable_parties = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'charge_code' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'color_code_hex' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'show' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'key' => 'index'),
		'details' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'show' => array('column' => 'show', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $reports_events = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'shortname' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'charge_code' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'color_code_hex' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'details' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'event_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $reports_organizations = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'charge_code' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'color_code_hex' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'show' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'key' => 'index'),
		'details' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'show' => array('column' => 'show', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $reports_remediations = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'charge_code' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'color_code_hex' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'show' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'key' => 'index'),
		'details' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'show' => array('column' => 'show', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $reports_severities = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'charge_code' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'color_code_hex' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'show' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'key' => 'index'),
		'details' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'show' => array('column' => 'show', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $reports_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'charge_code' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'color_code_hex' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'show' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'key' => 'index'),
		'details' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'show' => array('column' => 'show', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $reports_system_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'charge_code' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'color_code_hex' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'show' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'key' => 'index'),
		'details' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'show' => array('column' => 'show', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $reports_verifications = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'charge_code' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'color_code_hex' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'show' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'key' => 'index'),
		'details' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'show' => array('column' => 'show', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $review_state_logs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'old_review_state_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'review_state_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'rule_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'unsigned' => false, 'key' => 'index'),
		'comments' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'review_state_id' => array('column' => 'review_state_id', 'unique' => 0),
			'rule_id' => array('column' => 'rule_id', 'unique' => 0),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'old_review_state_id' => array('column' => 'old_review_state_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $review_states = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'instructions' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'default' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'key' => 'index'),
		'notify_email' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'notify_time' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false, 'key' => 'index'),
		'sendemail' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'key' => 'index'),
		'mon' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'tue' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'wed' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'thu' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'fri' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'sat' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'sun' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'default' => array('column' => 'default', 'unique' => 0),
			'sendemail' => array('column' => 'sendemail', 'unique' => 0),
			'notify_time' => array('column' => 'notify_time', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $rules = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'hash' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'import_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'firewall_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'review_state_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'fw_interface_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'fw_int_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'permit' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'protocol_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'src_fisma_system_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'dst_fisma_system_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'src_fog_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'dst_fog_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'src_pog_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'dst_pog_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'added_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reviewed_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'src_ip' => array('type' => 'string', 'null' => false, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'src_port' => array('type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'src_desc' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'dst_ip' => array('type' => 'string', 'null' => false, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'dst_port' => array('type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'dst_desc' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'comments' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'raw' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'use_fw_int' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'poc_email' => array('type' => 'string', 'null' => false, 'length' => 200, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'ticket' => array('type' => 'string', 'null' => false, 'length' => 200, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'logging' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'remarks' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'use_src_fog' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'use_dst_fog' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'use_src_pog' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'use_dst_pog' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'reviewed' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'firewall_id' => array('column' => 'firewall_id', 'unique' => 0),
			'review_state_id' => array('column' => 'review_state_id', 'unique' => 0),
			'added_user_id' => array('column' => 'added_user_id', 'unique' => 0),
			'modified_user_id' => array('column' => 'modified_user_id', 'unique' => 0),
			'reviewed_user_id' => array('column' => 'reviewed_user_id', 'unique' => 0),
			'poc_email' => array('column' => 'poc_email', 'unique' => 0),
			'ticket' => array('column' => 'ticket', 'unique' => 0),
			'fw_interface_id' => array('column' => 'fw_interface_id', 'unique' => 0),
			'src_fisma_system_id' => array('column' => 'src_fisma_system_id', 'unique' => 0),
			'dst_fisma_system_id' => array('column' => 'dst_fisma_system_id', 'unique' => 0),
			'src_fog_id' => array('column' => 'src_fog_id', 'unique' => 0),
			'dst_fog_id' => array('column' => 'dst_fog_id', 'unique' => 0),
			'import_id' => array('column' => 'import_id', 'unique' => 0),
			'protocol_id' => array('column' => 'protocol_id', 'unique' => 0),
			'fw_int_id' => array('column' => 'fw_int_id', 'unique' => 0),
			'src_pog_id' => array('column' => 'src_fog_id', 'unique' => 0),
			'dst_pog_id' => array('column' => 'dst_fog_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $subnet_members = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'subnet_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'unsigned' => false, 'key' => 'index'),
		'fisma_inventory_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'unsigned' => false, 'key' => 'index'),
		'us_result_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'unsigned' => false, 'key' => 'index'),
		'pen_test_result_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'unsigned' => false, 'key' => 'index'),
		'eol_result_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'unsigned' => false, 'key' => 'index'),
		'high_risk_result_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'unsigned' => false, 'key' => 'index'),
		'fov_host_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'unsigned' => false, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'subnet_id' => array('column' => 'subnet_id', 'unique' => 0),
			'fisma_inventory_id' => array('column' => 'fisma_inventory_id', 'unique' => 0),
			'pen_test_result_id' => array('column' => 'pen_test_result_id', 'unique' => 0),
			'eol_result_id' => array('column' => 'eol_result_id', 'unique' => 0),
			'high_risk_result_id' => array('column' => 'high_risk_result_id', 'unique' => 0),
			'us_result_id' => array('column' => 'us_result_id', 'unique' => 0),
			'fov_host_id' => array('column' => 'fov_host_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $subnets = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'cidr' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'ip_start' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'ip_start_long' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'ip_end' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'ip_end_long' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'netmask' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'ic' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'location' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'comments' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'dhcp' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 2, 'unsigned' => false, 'key' => 'index'),
		'dhcp_scope' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'fisma_inventory_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'unsigned' => false, 'key' => 'index'),
		'fisma_inventory_percent' => array('type' => 'decimal', 'null' => false, 'default' => '0.00', 'length' => '10,2', 'unsigned' => false, 'key' => 'index'),
		'us_result_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'unsigned' => false, 'key' => 'index'),
		'pen_test_result_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'unsigned' => false, 'key' => 'index'),
		'eol_result_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'unsigned' => false, 'key' => 'index'),
		'high_risk_result_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'unsigned' => false, 'key' => 'index'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'dhcp' => array('column' => 'dhcp', 'unique' => 0),
			'fisma_inventory_count' => array('column' => 'fisma_inventory_count', 'unique' => 0),
			'pen_test_result_count' => array('column' => 'pen_test_result_count', 'unique' => 0),
			'eol_result_count' => array('column' => 'eol_result_count', 'unique' => 0),
			'high_risk_result_count' => array('column' => 'high_risk_result_count', 'unique' => 0),
			'fisma_inventory_percent' => array('column' => 'fisma_inventory_percent', 'unique' => 0),
			'us_result_count' => array('column' => 'us_result_count', 'unique' => 0),
			'ip_start_long' => array('column' => 'ip_start_long', 'unique' => 0),
			'ip_end_long' => array('column' => 'ip_end_long', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $us_report_files = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'us_report_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'unsigned' => false, 'key' => 'index'),
		'filename' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'nicename' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'notes' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'us_report_id' => array('column' => 'us_report_id', 'unique' => 0),
			'user_id' => array('column' => 'user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $us_reports = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'added_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'queued_task_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'notes' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'filename' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'report_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'added_user_id' => array('column' => 'added_user_id', 'unique' => 0),
			'modified_user_id' => array('column' => 'modified_user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $us_reports_us_results = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'us_report_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'us_result_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'us_result_id' => array('column' => 'us_result_id', 'unique' => 0),
			'us_report_id' => array('column' => 'us_report_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $us_result_logs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'us_result_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'added_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'status_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'eol_software_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'organization_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'assignable_party_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'remediation_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'verification_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'reports_assignable_party_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_organization_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_remediation_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_verification_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_status_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'fisma_system_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'ticket_id' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'organization_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'assignable_party_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'remediation_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'verification_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'is_dupe' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'key' => 'index'),
		'nessus' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'host_description' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'ip_address' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'host_name' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'mac_address' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'asset_tag' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'service' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'netbios' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'user_account_name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'comments' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'notes' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'reported_to_ic_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'status_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'added_user_id' => array('column' => 'added_user_id', 'unique' => 0),
			'modified_user_id' => array('column' => 'modified_user_id', 'unique' => 0),
			'eol_software_id' => array('column' => 'eol_software_id', 'unique' => 0),
			'reports_remediation_id' => array('column' => 'reports_remediation_id', 'unique' => 0),
			'reports_verification_id' => array('column' => 'reports_verification_id', 'unique' => 0),
			'status_user_id' => array('column' => 'status_user_id', 'unique' => 0),
			'reports_status_id' => array('column' => 'reports_status_id', 'unique' => 0),
			'reports_assignable_party_id' => array('column' => 'reports_assignable_party_id', 'unique' => 0),
			'reports_organization_id' => array('column' => 'reports_organization_id', 'unique' => 0),
			'is_dupe' => array('column' => 'is_dupe', 'unique' => 0),
			'fisma_system_id' => array('column' => 'fisma_system_id', 'unique' => 0),
			'ip_address' => array('column' => 'ip_address', 'unique' => 0),
			'host_name' => array('column' => 'host_name', 'unique' => 0),
			'mac_address' => array('column' => 'mac_address', 'unique' => 0),
			'asset_tag' => array('column' => 'asset_tag', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $us_results = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'added_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'status_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'eol_software_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'organization_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'assignable_party_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'remediation_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'verification_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'reports_assignable_party_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_organization_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_remediation_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_verification_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'reports_status_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'fisma_system_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'ticket_id' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'organization_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'assignable_party_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'remediation_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'verification_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'is_dupe' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'key' => 'index'),
		'nessus' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'host_description' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'ip_address' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'host_name' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'mac_address' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'asset_tag' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'netbios' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'user_account_name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'comments' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'notes' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'reported_to_ic_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'status_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'added_user_id' => array('column' => 'added_user_id', 'unique' => 0),
			'modified_user_id' => array('column' => 'modified_user_id', 'unique' => 0),
			'eol_software_id' => array('column' => 'eol_software_id', 'unique' => 0),
			'reports_remediation_id' => array('column' => 'reports_remediation_id', 'unique' => 0),
			'reports_verification_id' => array('column' => 'reports_verification_id', 'unique' => 0),
			'status_user_id' => array('column' => 'status_user_id', 'unique' => 0),
			'reports_status_id' => array('column' => 'reports_status_id', 'unique' => 0),
			'reports_assignable_party_id' => array('column' => 'reports_assignable_party_id', 'unique' => 0),
			'reports_organization_id' => array('column' => 'reports_organization_id', 'unique' => 0),
			'is_dupe' => array('column' => 'is_dupe', 'unique' => 0),
			'fisma_system_id' => array('column' => 'fisma_system_id', 'unique' => 0),
			'ip_address' => array('column' => 'ip_address', 'unique' => 0),
			'host_name' => array('column' => 'host_name', 'unique' => 0),
			'mac_address' => array('column' => 'mac_address', 'unique' => 0),
			'asset_tag' => array('column' => 'asset_tag', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $user_settings = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'email_new' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 2, 'unsigned' => false, 'key' => 'index'),
		'email_updated' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 2, 'unsigned' => false, 'key' => 'index'),
		'email_closed' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 2, 'unsigned' => false, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'email_new' => array('column' => 'email_new', 'unique' => 0),
			'email_updated' => array('column' => 'email_updated', 'unique' => 0),
			'email_closed' => array('column' => 'email_closed', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $users = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'old_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'email' => array('type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'password' => array('type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'division_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false, 'key' => 'index'),
		'ad_account_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'assoc_account_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'unsigned' => false),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'firstname' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'lastname' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'adaccount' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'userid' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'remote_user' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'role' => array('type' => 'string', 'null' => false, 'default' => 'regular', 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'api_key' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'key' => 'index'),
		'paginate_items' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 5, 'unsigned' => false),
		'signer' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'key' => 'index'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'lastlogin' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'lastlogin_api' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'photo' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'active' => array('column' => 'active', 'unique' => 0),
			'division_id' => array('column' => 'division_id', 'unique' => 0),
			'signer' => array('column' => 'signer', 'unique' => 0),
			'old_id' => array('column' => 'old_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

}
