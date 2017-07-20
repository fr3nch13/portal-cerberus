<?php

?>
	<li>
		<?php echo $this->Html->link(__('Admin'), '#', array('class' => 'top')); ?>
		<ul>
			<li>
				<?php echo $this->Html->link(__('Rule Attributes'), '#'); ?>
				<ul>
					<li><?php echo $this->Html->link(__('Review States'), array('controller' => 'review_states', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('Firewall Paths'), array('controller' => 'fw_ints', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('Firewalls'), array('controller' => 'firewalls', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('Interfaces'), array('controller' => 'fw_interfaces', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('Protocols'), array('controller' => 'protocols', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('Firewall Object Groups'), array('controller' => 'fogs', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('Port Object Groups'), array('controller' => 'pogs', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
				</ul>
			</li>
			<li>
				<?php echo $this->Html->link(__('FISMA Systems'), '#'); ?>
				<ul>
					<li><?php echo $this->Html->link(__('FISMA Systems'), array('controller' => 'fisma_systems', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('%s Import Updater', __('FISMA Systems')), array('controller' => 'fisma_systems', 'action' => 'import_updater', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('%s - %s', __('FISMA System'), __('Life Safety Options')), array('controller' => 'fisma_system_life_safeties', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('%s - %s', __('FISMA System'), __('Criticality Options')), array('controller' => 'fisma_system_criticalities', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('%s - %s', __('FISMA System'), __('Affected Parties Options')), array('controller' => 'fisma_system_affected_parties', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('%s - %s', __('FISMA System'), __('Fips Rating')), array('controller' => 'fisma_system_fips_ratings', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('%s - %s', __('FISMA System'), __('FO Risk Assessment')), array('controller' => 'fisma_system_risk_assessments', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('%s - %s', __('FISMA System'), __('FO Threat Assessment')), array('controller' => 'fisma_system_threat_assessments', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('%s - %s', __('FISMA System'), __('AHE Hosting')), array('controller' => 'fisma_system_hostings', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('%s - %s', __('FISMA System'), __('Interconnections')), array('controller' => 'fisma_system_interconnections', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('%s - %s', __('FISMA System'), __('GSS Statuses')), array('controller' => 'fisma_system_gss_statuses', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('%s - %s', __('FISMA System'), __('POAM Completion Statuses')), array('controller' => 'fisma_system_poam_completion_statuses', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('%s - %s', __('FISMA System'), __('NIH Logins')), array('controller' => 'fisma_system_nihlogins', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('%s - %s', __('FISMA System'), __('Amounts')), array('controller' => 'fisma_system_amounts', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('%s - %s', __('FISMA System'), __('Communication Totals')), array('controller' => 'fisma_system_com_totals', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('%s - %s', __('FISMA System'), __('Dependencies')), array('controller' => 'fisma_system_dependencies', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('%s - %s', __('FISMA System'), __('Impacts')), array('controller' => 'fisma_system_impacts', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('%s - %s', __('FISMA System'), __('Types')), array('controller' => 'fisma_system_types', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('%s - %s', __('FISMA System'), __('Uniquenesses')), array('controller' => 'fisma_system_uniquenesses', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('%s - %s', __('FISMA System'), __('Sensitivity Categories')), array('controller' => 'fisma_system_sensitivity_categories', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('%s - %s', __('FISMA System'), __('Sensitivity Ratings')), array('controller' => 'fisma_system_sensitivity_ratings', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('%s - %s', __('FISMA System'), __('NISTs')), array('controller' => 'fisma_system_nists', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('%s - %s', __('FISMA Contact'), __('Types')), array('controller' => 'fisma_contact_types', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
				</ul>
			</li>
			<li>
				<?php echo $this->Html->link(__('FISMA System Inventory'), '#'); ?>
				<ul>
					<li><?php echo $this->Html->link(__('%s - %s', __('FISMA Inventory'), __('Types')), array('controller' => 'fisma_types', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('%s - %s', __('FISMA Inventory'), __('Statuses')), array('controller' => 'fisma_statuses', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('%s - %s', __('FISMA Inventory'), __('Sources')), array('controller' => 'fisma_sources', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('%s - %s', __('FISMA Software'), __('Groups')), array('controller' => 'fisma_software_groups', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('%s - %s', __('FISMA Software'), __('Sources')), array('controller' => 'fisma_software_sources', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
				</ul>
			</li>
			<li>
				<?php echo $this->Html->link(__('Imported Reports'), '#'); ?>
				<ul>
					<li><?php echo $this->Html->link(__('US Reports'), array('controller' => 'us_reports', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('US Results'), array('controller' => 'us_results', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('EOL Reports'), array('controller' => 'eol_reports', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('EOL Results'), array('controller' => 'eol_results', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('Pen Test Reports'), array('controller' => 'pen_test_reports', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('Pen Test Results'), array('controller' => 'pen_test_results', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('High Risk Reports'), array('controller' => 'high_risk_reports', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('High Risk Results'), array('controller' => 'high_risk_results', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('Reports Events'), array('controller' => 'reports_events', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('Software/Vulnerabilities'), array('controller' => 'eol_softwares', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li>
						<?php echo $this->Html->link(__('Report Options'), '#'); ?>
						<ul>
							<li><?php echo $this->Html->link(__('Remediations'), array('controller' => 'reports_remediations', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
							<li><?php echo $this->Html->link(__('Verifications'), array('controller' => 'reports_verifications', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
							<li><?php echo $this->Html->link(__('Organizations'), array('controller' => 'reports_organizations', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
							<li><?php echo $this->Html->link(__('Severities'), array('controller' => 'reports_severities', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
							<li><?php echo $this->Html->link(__('Statuses'), array('controller' => 'reports_statuses', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
							<li><?php echo $this->Html->link(__('Assignable Parties'), array('controller' => 'reports_assignable_parties', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
							<li><?php echo $this->Html->link(__('System Types'), array('controller' => 'reports_system_types', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
							<li><?php echo $this->Html->link(__('Whitelisted Software'), array('controller' => 'fisma_softwares', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?></li>
						</ul>
					</li>
					<li>
						<?php echo $this->Html->link(__('POA&M Options'), '#'); ?>
						<ul>
							<li><?php echo $this->Html->link(__('Criticalities'), array('controller' => 'poam_criticalities', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
							<li><?php echo $this->Html->link(__('Risks'), array('controller' => 'poam_risks', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
							<li><?php echo $this->Html->link(__('Severities'), array('controller' => 'poam_severities', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
							<li><?php echo $this->Html->link(__('Statuses'), array('controller' => 'poam_statuses', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
						</ul>
					</li>
				</ul>
			</li>
			<li><?php echo $this->Html->link(__('Subnets'), array('controller' => 'subnets', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('Physical Locations'), array('controller' => 'physical_locations', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('Imports'), array('controller' => 'imports', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('DB Logs'), array('controller' => 'dblogs', 'action' => 'index', 'admin' => true, 'plugin' => 'dblogger')); ?></li>
			<li>
				<?php echo $this->Html->link(__('Users'), '#', array('class' => 'sub')); ?>
				<ul>
					<li><?php echo $this->Html->link(__('All %s', __('Users')), array('controller' => 'users', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('Login History'), array('controller' => 'login_histories', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
				</ul>
			</li>
			<li>
				<?php echo $this->Html->link(__('App Admin'), '#', array('class' => 'sub')); ?>
				<ul>
					<li><?php echo $this->Html->link(__('Config'), array('controller' => 'users', 'action' => 'config', 'admin' => true, 'plugin' => false)); ?></li>
					<li><?php echo $this->Html->link(__('Process Times'), array('controller' => 'proctimes', 'action' => 'index', 'admin' => true, 'plugin' => 'utilities')); ?></li> 
				</ul>
			</li>
			<?php echo $this->Common->loadPluginMenuItems('admin'); ?>
		</ul>
	</li>