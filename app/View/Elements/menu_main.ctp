<?php 
if(AuthComponent::user('id'))
{ 
	$dashboardUserRole = $this->Common->dashboardUserRole();
	
	$includeDefault = false;
?>
<ul class="sf-menu">
	<?php if(!$this->Common->roleCheck(array('division_director'))): ?>
	<li><?php echo $this->Html->link(__('Search'), array('controller' => 'main', 'action' => 'search', 'prefix' => false, 'plugin' => false), array('class' => 'top')); ?></li>
	<?php endif; ?>
	<?php 
	if($this->Common->roleCheck('admin'))
	{
		echo $this->element('menu_main_admin');
		$includeDefault = true;
	}
	if($dashboardUserRole)
	{
		echo $this->element('menu_main_db');
	}
	elseif($this->Common->roleCheck('daa'))
	{
		echo $this->element('menu_main_daa');
		$includeDefault = true;
	}
	elseif($this->Common->roleCheck('isso'))
	{
		echo $this->element('menu_main_isso');
		$includeDefault = true;
	}
	elseif($this->Common->roleCheck(array('regular', 'saa', 'reviewer')))
	{
		$includeDefault = true;
	}
	elseif($this->Common->roleCheck('director'))
	{
		echo $this->element('menu_main_director');
	}
	elseif($this->Common->roleCheck('crm'))
	{
		echo $this->element('menu_main_crm');
	}
	elseif($this->Common->roleCheck('lead'))
	{
		echo $this->element('menu_main_lead');
	}
	elseif($this->Common->roleCheck('owner'))
	{
		echo $this->element('menu_main_owner');
	}
	elseif($this->Common->roleCheck('techpoc'))
	{
		echo $this->element('menu_main_techpoc');
	}
	
	if($includeDefault)
	{
	?>
	<li>
		<?php echo $this->Html->link(__('Create New &hellip;'), '#', array('class' => 'top', 'escape' => false)); ?>
		<ul>
			<li><?php echo $this->Html->link(__('Rule'), array('controller' => 'rules', 'action' => 'add', 'admin' => false, 'plugin' => false, 'saa' => false)); ?></li>
			
			<?php if ($this->Common->roleCheck(array('admin', 'saa'))): ?>
			<li><?php echo $this->Html->link(__('FISMA System'), array('controller' => 'fisma_systems', 'action' => 'add', 'admin' => false, 'plugin' => false, 'saa' => true)); ?></li>
			<li><?php echo $this->Html->link(__('Import FISMA Systems from NSAT File'), array('controller' => 'fisma_systems', 'action' => 'batcher_step1', 'admin' => false, 'plugin' => false, 'saa' => true)); ?></li>
			<li><?php echo $this->Html->link(__('FISMA Inventory Item'), array('controller' => 'fisma_inventories', 'action' => 'add', 'admin' => false, 'plugin' => false, 'saa' => true)); ?></li>
			<li><?php echo $this->Html->link(__('Many FISMA Inventory Items'), array('controller' => 'fisma_inventories', 'action' => 'batch_add', 'admin' => false, 'plugin' => false, 'saa' => true)); ?></li>
			<?php endif; ?>			
			<li><?php echo $this->Html->link(__('AD Account'), array('controller' => 'ad_accounts', 'action' => 'add', 'admin' => false, 'plugin' => false, 'saa' => false)); ?></li>
		</ul>
	</li>
	<li>
		<?php echo $this->Html->link(__('Overviews'), '#', array('class' => 'top')); ?>
		<ul>
			<li><?php echo $this->Html->link(__('Overview'), array('controller' => 'main', 'action' => 'dashboard', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('My Overview'), array('controller' => 'main', 'action' => 'my_dashboard', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('My Subscriptions'), ['controller' => 'subscriptions', 'action' => 'index', 'admin' => false, 'plugin' => 'utilities']); ?></li> 
			<?php if ($this->Common->roleCheck(array('admin', 'saa', 'project_manager'))): ?>
			<li><?php echo $this->Html->link(__('CRM Unresolved Results (by system)'), array('controller' => 'fisma_systems', 'action' => 'actionable', 'crm' => true, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('CRM Dashboard'), array('controller' => 'main', 'action' => 'dashboard', 'crm' => true, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('System Owner Dashboard'), array('controller' => 'main', 'action' => 'dashboard', 'owner' => true, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('Project Manager Dashboard'), array('controller' => 'main', 'action' => 'dashboard', 'project_manager' => true, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('SA&A Dashboard'), array('controller' => 'main', 'action' => 'dashboard', 'saa' => true, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('ISSO Dashboard'), array('controller' => 'main', 'action' => 'dashboard', 'isso' => true, 'plugin' => false)); ?></li>
			
			<li><?php echo $this->Html->link(__('Division Director Dashboard'), array('controller' => 'main', 'action' => 'dashboard', 'division_director' => true, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('Tech POC Dashboard'), array('controller' => 'main', 'action' => 'dashboard', 'techpoc' => true, 'plugin' => false)); ?></li>
			<?php endif; ?>
		</ul>
	</li>
	<li>
		<?php echo $this->Html->link(__('Rules'), '#', array('class' => 'top')); ?>
		<ul>
<!--			<li><?php echo $this->Html->link(__('Dashboard'), array('controller' => 'rules', 'action' => 'dashboard', 'admin' => false, 'plugin' => false)); ?></li> -->
			<li>
				<?php echo $this->Html->link(__('Attributes'), '#'); ?>
				<ul>		
					<li><?php echo $this->Html->link(__('Firewall Paths'), array('controller' => 'fw_ints', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('Firewalls'), array('controller' => 'firewalls', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('Interfaces'), array('controller' => 'fw_interfaces', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('Protocols'), array('controller' => 'protocols', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('Firewall Object Groups'), array('controller' => 'fogs', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('Firewall Object Groups with IP'), array('controller' => 'fogs', 'action' => 'index_expanded', 'admin' => false, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('Port Object Groups'), array('controller' => 'pogs', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('Port Object Groups with Ports'), array('controller' => 'pogs', 'action' => 'index_expanded', 'admin' => false, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('Host Aliases'), array('controller' => 'host_aliases', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?></li>
				</ul>
			</li>
				<?php echo $this->element('Utilities.menu_items', array(
					'request_url' => array('controller' => 'review_states', 'action' => 'index', 'admin' => false, 'plugin' => false),
					'use_ul' => false,
				));?>
		</ul>
	</li>
	<li>
		<?php echo $this->Html->link(__('FISMA Systems'), array('controller' => 'fisma_systems', 'action' => 'index', 'admin' => false, 'plugin' => false), array('class' => 'top')); ?>
		<ul>		
			<li><?php echo $this->Html->link(__('Dashboard'), array('controller' => 'fisma_systems', 'action' => 'dashboard', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('All %s', __('FISMA Systems')), array('controller' => 'fisma_systems', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('OAM %s Dashboard', __('FISMA Systems')), array('controller' => 'fisma_systems', 'action' => 'db_tab_oam', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('%s Summary Dashboard', __('FISMA Systems')), array('controller' => 'fisma_systems', 'action' => 'db_tab_summary', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('%s - Parents', __('FISMA Systems')), array('controller' => 'fisma_systems', 'action' => 'parents', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('%s - Children', __('FISMA Systems')), array('controller' => 'fisma_systems', 'action' => 'all_children', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('%s - No Family', __('FISMA Systems')), array('controller' => 'fisma_systems', 'action' => 'no_family', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('%s - With Owners', __('FISMA System')), array('controller' => 'fisma_systems', 'action' => 'owners', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('%s - No Owners', __('FISMA System')), array('controller' => 'fisma_systems', 'action' => 'no_owner', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('%s by System', __('FISMA Systems')), array('controller' => 'fisma_systems', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?>
				<?php echo $this->element('Utilities.menu_items', array(
					'request_url' => array('controller' => 'fisma_systems', 'action' => 'index', 'admin' => false, 'plugin' => false, 'saa' => false),
				));?>
			</li>
			<li><?php echo $this->Html->link(__('All System Files'), array('controller' => 'fisma_system_files', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('All Risk Acceptance Forms'), array('controller' => 'fisma_system_files', 'action' => 'index', true, 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('All %s Owners', __('FISMA System')), array('controller' => 'ad_accounts', 'action' => 'fisma_system_owners', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('All %s', __('FISMA Contacts')), array('controller' => 'ad_accounts_fisma_systems', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('%s %s', __('FISMA Contact'), __('Types')), array('controller' => 'fisma_contact_types', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('All Inventory'), array('controller' => 'fisma_inventories', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('All Whitelisted Software'), array('controller' => 'fisma_softwares', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('Physical Locations'), array('controller' => 'physical_locations', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('Inventory/Software %s', __('Freeform Tags')), array('controller' => 'tags', 'action' => 'index', 'admin' => false, 'plugin' => 'tags')); ?></li>
		</ul>
	</li>
	<li>
		<?php echo $this->Html->link(__('POA&M'), '#', array('class' => 'top')); ?>
		<ul>
			<li><?php echo $this->Html->link(__('Dashboard'), array('controller' => 'poam_results', 'action' => 'dashboard', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('All Reports'), array('controller' => 'poam_reports', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('All Results'), array('controller' => 'poam_results', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('Results not in a %s', __('FISMA System')), array('controller' => 'poam_results', 'action' => 'orphans', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('Auto Closed: Yes'), array('controller' => 'poam_results', 'action' => 'auto_closed', 1, 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('Auto Closed: No'), array('controller' => 'poam_results', 'action' => 'auto_closed', 0, 'admin' => false, 'plugin' => false)); ?></li>
			
			<li>
				<?php echo $this->Html->link(__('Results by %s', __('Criticality')), '#'); ?>
				<?php echo $this->element('Utilities.menu_items', array(
					'request_url' => array('controller' => 'poam_results', 'action' => 'menu_criticalities', 'admin' => false, 'plugin' => false, 'saa' => false),
				)); ?>
			</li>
			<li>
				<?php echo $this->Html->link(__('Results by %s', __('Risks')), '#'); ?>
				<?php echo $this->element('Utilities.menu_items', array(
					'request_url' => array('controller' => 'poam_results', 'action' => 'menu_risks', 'admin' => false, 'plugin' => false, 'saa' => false),
				)); ?>
			</li>
			<li>
				<?php echo $this->Html->link(__('Results by %s', __('Severity')), '#'); ?>
				<?php echo $this->element('Utilities.menu_items', array(
					'request_url' => array('controller' => 'poam_results', 'action' => 'menu_severities', 'admin' => false, 'plugin' => false, 'saa' => false),
				)); ?>
			</li>
			<li>
				<?php echo $this->Html->link(__('Results by %s', __('Status')), '#'); ?>
				<?php echo $this->element('Utilities.menu_items', array(
					'request_url' => array('controller' => 'poam_results', 'action' => 'menu_statuses', 'admin' => false, 'plugin' => false, 'saa' => false),
				)); ?>
			</li>
		</ul>
	</li>
	<li>
		<?php echo $this->Html->link(__('FOV'), '#', array('class' => 'top')); ?>
		<ul>
			<li><?php echo $this->Html->link(__('Dashboard'), array('controller' => 'fov_results', 'action' => 'dashboard', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('All Results'), array('controller' => 'fov_results', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('All Hosts'), array('controller' => 'fov_hosts', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('Results not in a %s', __('FISMA System')), array('controller' => 'fov_results', 'action' => 'orphans', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('Results in multiple %s', __('FISMA Systems')), array('controller' => 'fov_results', 'action' => 'multiple_fisma_systems', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('%s overridden Results', __('FISMA System')), array('controller' => 'fov_results', 'action' => 'overridden', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('Software/Vulnerabilities'), array('controller' => 'eol_softwares', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?></li>
			<li>
				<?php echo $this->Html->link(__('Results by %s', __('Assignable Party')), '#'); ?>
				<?php echo $this->element('Utilities.menu_items', array(
					'request_url' => array('controller' => 'fov_results', 'action' => 'menu_assignable_parties', 'admin' => false, 'plugin' => false, 'saa' => false),
				)); ?>
			</li>
			<li>
				<?php echo $this->Html->link(__('Results by %s', __('Remediation')), '#'); ?>
				<?php echo $this->element('Utilities.menu_items', array(
					'request_url' => array('controller' => 'fov_results', 'action' => 'menu_remediations', 'admin' => false, 'plugin' => false, 'saa' => false),
				)); ?>
			</li>
			<li>
				<?php echo $this->Html->link(__('Results by %s', __('Severity')), '#'); ?>
				<?php echo $this->element('Utilities.menu_items', array(
					'request_url' => array('controller' => 'fov_results', 'action' => 'menu_severities', 'admin' => false, 'plugin' => false, 'saa' => false),
				)); ?>
			</li>
			<li>
				<?php echo $this->Html->link(__('Results by %s', __('Status')), '#'); ?>
				<?php echo $this->element('Utilities.menu_items', array(
					'request_url' => array('controller' => 'fov_results', 'action' => 'menu_statuses', 'admin' => false, 'plugin' => false, 'saa' => false),
				)); ?>
			</li>
			<li>
				<?php echo $this->Html->link(__('Results by %s', __('Verification')), '#'); ?>
				<?php echo $this->element('Utilities.menu_items', array(
					'request_url' => array('controller' => 'eol_softwares', 'action' => 'menu_verifications', 'admin' => false, 'plugin' => false, 'saa' => false),
				)); ?>
			</li>
		</ul>
	</li>
	<li>
		<?php echo $this->Html->link(__('US'), '#', array('class' => 'top')); ?>
		<ul>
			<li><?php echo $this->Html->link(__('Dashboard'), array('controller' => 'us_results', 'action' => 'dashboard', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('All Reports'), array('controller' => 'us_reports', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('All Results'), array('controller' => 'us_results', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('Results not in a %s', __('FISMA System')), array('controller' => 'us_results', 'action' => 'orphans', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('Results in multiple %s', __('FISMA Systems')), array('controller' => 'us_results', 'action' => 'multiple_fisma_systems', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('%s overridden Results', __('FISMA System')), array('controller' => 'us_results', 'action' => 'overridden', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('Software/Vulnerabilities'), array('controller' => 'eol_softwares', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?></li>
			<li>
				<?php echo $this->Html->link(__('Results by %s', __('Assignable Party')), '#'); ?>
				<?php echo $this->element('Utilities.menu_items', array(
					'request_url' => array('controller' => 'us_results', 'action' => 'menu_assignable_parties', 'admin' => false, 'plugin' => false, 'saa' => false),
				)); ?>
			</li>
			<li>
				<?php echo $this->Html->link(__('Results by %s', __('Remediation')), '#'); ?>
				<?php echo $this->element('Utilities.menu_items', array(
					'request_url' => array('controller' => 'us_results', 'action' => 'menu_remediations', 'admin' => false, 'plugin' => false, 'saa' => false),
				)); ?>
			</li>
			<li>
				<?php echo $this->Html->link(__('Results by %s', __('Verification')), '#'); ?>
				<?php echo $this->element('Utilities.menu_items', array(
					'request_url' => array('controller' => 'us_results', 'action' => 'menu_verifications', 'admin' => false, 'plugin' => false, 'saa' => false),
				)); ?>
			</li>
			<li>
				<?php echo $this->Html->link(__('Results by %s', __('Status')), '#'); ?>
				<?php echo $this->element('Utilities.menu_items', array(
					'request_url' => array('controller' => 'us_results', 'action' => 'menu_statuses', 'admin' => false, 'plugin' => false, 'saa' => false),
				)); ?>
			</li>
		</ul>
	</li>
	<li>
		<?php echo $this->Html->link(__('EOL'), '#', array('class' => 'top')); ?>
		<ul>
			<li><?php echo $this->Html->link(__('Dashboard'), array('controller' => 'eol_results', 'action' => 'dashboard', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('All Reports'), array('controller' => 'eol_reports', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('All Results'), array('controller' => 'eol_results', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('Results not in a %s', __('FISMA System')), array('controller' => 'eol_results', 'action' => 'orphans', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('Results in multiple %s', __('FISMA Systems')), array('controller' => 'eol_results', 'action' => 'multiple_fisma_systems', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('%s overridden Results', __('FISMA System')), array('controller' => 'eol_results', 'action' => 'overridden', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('Software/Vulnerabilities'), array('controller' => 'eol_softwares', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?></li>
			<li>
				<?php echo $this->Html->link(__('Results by %s', __('Assignable Party')), '#'); ?>
				<?php echo $this->element('Utilities.menu_items', array(
					'request_url' => array('controller' => 'eol_results', 'action' => 'menu_assignable_parties', 'admin' => false, 'plugin' => false, 'saa' => false),
				)); ?>
			</li>
			<li>
				<?php echo $this->Html->link(__('Results by %s', __('Remediation')), '#'); ?>
				<?php echo $this->element('Utilities.menu_items', array(
					'request_url' => array('controller' => 'eol_results', 'action' => 'menu_remediations', 'admin' => false, 'plugin' => false, 'saa' => false),
				)); ?>
			</li>
			<li>
				<?php echo $this->Html->link(__('Results by %s', __('Status')), '#'); ?>
				<?php echo $this->element('Utilities.menu_items', array(
					'request_url' => array('controller' => 'eol_results', 'action' => 'menu_statuses', 'admin' => false, 'plugin' => false, 'saa' => false),
				)); ?>
			</li>
			<li>
				<?php echo $this->Html->link(__('Results by %s', __('Verification')), '#'); ?>
				<?php echo $this->element('Utilities.menu_items', array(
					'request_url' => array('controller' => 'eol_results', 'action' => 'menu_verifications', 'admin' => false, 'plugin' => false, 'saa' => false),
				)); ?>
			</li>
		</ul>
	</li>
	<li>
		<?php echo $this->Html->link(__('Pen Tests'), '#', array('class' => 'top')); ?>
		<ul>
			<li><?php echo $this->Html->link(__('Dashboard'), array('controller' => 'pen_test_results', 'action' => 'dashboard', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('All Reports Events'), array('controller' => 'reports_events', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('All Reports'), array('controller' => 'pen_test_reports', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('All Results'), array('controller' => 'pen_test_results', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('All Results with FISMA Systems'), array('controller' => 'pen_test_results', 'action' => 'index_fisma_systems', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('Results not in a %s', __('FISMA System')), array('controller' => 'pen_test_results', 'action' => 'orphans', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('Results in multiple %s', __('FISMA Systems')), array('controller' => 'pen_test_results', 'action' => 'multiple_fisma_systems', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('%s overridden Results', __('FISMA System')), array('controller' => 'pen_test_results', 'action' => 'overridden', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('Software/Vulnerabilities'), array('controller' => 'eol_softwares', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?></li>
			<li>
				<?php echo $this->Html->link(__('Results by %s', __('Assignable Party')), '#'); ?>
				<?php echo $this->element('Utilities.menu_items', array(
					'request_url' => array('controller' => 'pen_test_results', 'action' => 'menu_assignable_parties', 'admin' => false, 'plugin' => false, 'saa' => false),
				)); ?>
			</li>
			<li>
				<?php echo $this->Html->link(__('Results by %s', __('Remediation')), '#'); ?>
				<?php echo $this->element('Utilities.menu_items', array(
					'request_url' => array('controller' => 'pen_test_results', 'action' => 'menu_remediations', 'admin' => false, 'plugin' => false, 'saa' => false),
				)); ?>
			</li>
			<li>
				<?php echo $this->Html->link(__('Results by %s', __('Status')), '#'); ?>
				<?php echo $this->element('Utilities.menu_items', array(
					'request_url' => array('controller' => 'pen_test_results', 'action' => 'menu_statuses', 'admin' => false, 'plugin' => false, 'saa' => false),
				)); ?>
			</li>
			<li>
				<?php echo $this->Html->link(__('Results by %s', __('Severity')), '#'); ?>
				<?php echo $this->element('Utilities.menu_items', array(
					'request_url' => array('controller' => 'pen_test_results', 'action' => 'menu_severities', 'admin' => false, 'plugin' => false, 'saa' => false),
				)); ?>
			</li>
			<li>
				<?php echo $this->Html->link(__('Results by %s', __('Verification')), '#'); ?>
				<?php echo $this->element('Utilities.menu_items', array(
					'request_url' => array('controller' => 'pen_test_results', 'action' => 'menu_verifications', 'admin' => false, 'plugin' => false, 'saa' => false),
				)); ?>
			</li>
		</ul>
	</li>
	<li>
		<?php echo $this->Html->link(__('High Risk'), '#', array('class' => 'top')); ?>
		<ul>
			<li><?php echo $this->Html->link(__('Dashboard'), array('controller' => 'high_risk_results', 'action' => 'dashboard', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('All Reports'), array('controller' => 'high_risk_reports', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('All Results'), array('controller' => 'high_risk_results', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('Results not in a %s', __('FISMA System')), array('controller' => 'high_risk_results', 'action' => 'orphans', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('Results in multiple %s', __('FISMA Systems')), array('controller' => 'high_risk_results', 'action' => 'multiple_fisma_systems', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('%s overridden Results', __('FISMA System')), array('controller' => 'high_risk_results', 'action' => 'overridden', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('Software/Vulnerabilities'), array('controller' => 'eol_softwares', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?></li>
			<li>
				<?php echo $this->Html->link(__('Results by %s', __('Assignable Party')), '#'); ?>
				<?php echo $this->element('Utilities.menu_items', array(
					'request_url' => array('controller' => 'high_risk_results', 'action' => 'menu_assignable_parties', 'admin' => false, 'plugin' => false, 'saa' => false),
				)); ?>
			</li>
			<li>
				<?php echo $this->Html->link(__('Results by %s', __('Remediation')), '#'); ?>
				<?php echo $this->element('Utilities.menu_items', array(
					'request_url' => array('controller' => 'high_risk_results', 'action' => 'menu_remediations', 'admin' => false, 'plugin' => false, 'saa' => false),
				)); ?>
			</li>
			<li>
				<?php echo $this->Html->link(__('Results by %s', __('Status')), '#'); ?>
				<?php echo $this->element('Utilities.menu_items', array(
					'request_url' => array('controller' => 'high_risk_results', 'action' => 'menu_statuses', 'admin' => false, 'plugin' => false, 'saa' => false),
				)); ?>
			</li>
			<li>
				<?php echo $this->Html->link(__('Results by %s', __('Verification')), '#'); ?>
				<?php echo $this->element('Utilities.menu_items', array(
					'request_url' => array('controller' => 'high_risk_results', 'action' => 'menu_verifications', 'admin' => false, 'plugin' => false, 'saa' => false),
				)); ?>
			</li>
		</ul>
	</li>
	<li>
		<?php echo $this->Html->link(__('Contacts'), '#', array('class' => 'top')); ?>
		<ul>
			<li><?php echo $this->Html->link(__('Directors'), array('controller' => 'sacs', 'action' => 'directors', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('%s Org Chart', __('Directors')), array('controller' => 'sacs', 'action' => 'orgchart_directors', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('CRMs'), array('controller' => 'sacs', 'action' => 'crms', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('%s Org Chart', __('CRMs')), array('controller' => 'sacs', 'action' => 'orgchart_crms', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('Associated Accounts'), array('controller' => 'assoc_accounts', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?>
				<ul>
					<li><?php echo $this->Html->link(__('All'), array('controller' => 'assoc_accounts', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('Duplicates'), array('controller' => 'assoc_accounts', 'action' => 'duplicates', 'admin' => false, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('Orphans'), array('controller' => 'assoc_accounts', 'action' => 'orphans', 'admin' => false, 'plugin' => false)); ?></li>
				</ul>
			</li>
			<li>
				<?php echo $this->Html->link(__('AD Accounts'), array('controller' => 'ad_accounts', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?>
				<ul>
					<li><?php echo $this->Html->link(__('All'), array('controller' => 'ad_accounts', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('Duplicates'), array('controller' => 'ad_accounts', 'action' => 'duplicates', 'admin' => false, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('Empty'), array('controller' => 'ad_accounts', 'action' => 'empties', 'admin' => false, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('Orphans'), array('controller' => 'ad_accounts', 'action' => 'orphans', 'admin' => false, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('Orginazional Chart'), array('controller' => 'ad_accounts', 'action' => 'orgchart', 'admin' => false, 'plugin' => false)); ?></li>
				</ul>
			</li>
			<li>
				<?php echo $this->Html->link(__('SACs'), array('controller' => 'sacs', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?>
				<ul>
					<li><?php echo $this->Html->link(__('All'), array('controller' => 'sacs', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('Duplicates'), array('controller' => 'sacs', 'action' => 'duplicates', 'admin' => false, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('Empty'), array('controller' => 'sacs', 'action' => 'empties', 'admin' => false, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('Orphans'), array('controller' => 'sacs', 'action' => 'orphans', 'admin' => false, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('Orginazional Chart'), array('controller' => 'sacs', 'action' => 'orgchart', 'admin' => false, 'plugin' => false)); ?></li>
				</ul>
			</li>
			<li>
				<?php echo $this->Html->link(__('Branches'), array('controller' => 'branches', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?>
				<ul>
					<li><?php echo $this->Html->link(__('All'), array('controller' => 'branches', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('Duplicates'), array('controller' => 'branches', 'action' => 'duplicates', 'admin' => false, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('Empty'), array('controller' => 'branches', 'action' => 'empties', 'admin' => false, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('Orphans'), array('controller' => 'branches', 'action' => 'orphans', 'admin' => false, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('Orginazional Chart'), array('controller' => 'branches', 'action' => 'orgchart', 'admin' => false, 'plugin' => false)); ?></li>
				</ul>
			</li>
			<li>
				<?php echo $this->Html->link(__('Divisions'), array('controller' => 'divisions', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?>
				<ul>
					<li><?php echo $this->Html->link(__('All'), array('controller' => 'divisions', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('Duplicates'), array('controller' => 'divisions', 'action' => 'duplicates', 'admin' => false, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('Empty'), array('controller' => 'divisions', 'action' => 'empties', 'admin' => false, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('Orphans'), array('controller' => 'divisions', 'action' => 'orphans', 'admin' => false, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('Orginazional Chart'), array('controller' => 'divisions', 'action' => 'orgchart', 'admin' => false, 'plugin' => false)); ?></li>
				</ul>
			</li>
			<li>
				<?php echo $this->Html->link(__('ORG/ICs'), array('controller' => 'orgs', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?>
				<ul>
					<li><?php echo $this->Html->link(__('All'), array('controller' => 'orgs', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('Duplicates'), array('controller' => 'orgs', 'action' => 'duplicates', 'admin' => false, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('Empty'), array('controller' => 'orgs', 'action' => 'empties', 'admin' => false, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('Orginazional Chart'), array('controller' => 'orgs', 'action' => 'orgchart', 'admin' => false, 'plugin' => false)); ?></li>
				</ul>
			</li>
		</ul>
	</li>
	<li><?php echo $this->Html->link(__('Users'), array('controller' => 'users', 'action' => 'index', 'admin' => false, 'plugin' => false), array('class' => 'top')); ?></li>
	<?php echo $this->Common->loadPluginMenuItems(); ?>
	<?php
	}
	?>
</ul>
<?php 
} // if(AuthComponent::user('id'))