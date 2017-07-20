<?php 
// File: app/View/FismaSystem/saa_add.ctp
?>
<div class="top">
	<h1><?php echo __('Add %s', __('FISMA System')); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('FismaSystem');?>
			<fieldset>
		        <legend><?php echo __('Basic Information'); ?></legend>
		        <h3><?php echo __('Basic Information'); ?></h3>
		    	<?php
					echo $this->Form->input('name', array(
						'label' => array(
							'text' => __('Short Name (shows up in the menu)'),
						),
						'div' => array('class' => 'forth'),
					));
					echo $this->Form->input('fullname', array(
						'label' => array(
							'text' => __('Full Name'),
						),
						'div' => array('class' => 'forth'),
					));
					echo $this->Form->input('uuid', array(
						'label' => array(
							'text' => __('UUID'),
						),
						'div' => array('class' => 'forth'),
					));
					echo $this->Form->input('owner_contact_id', array(
						'label' => array(
							'text' => __('System Owner'),
						),
						'div' => array('class' => 'forth'),
						'options' => $ownerContacts,
						'empty' => __('[Select]'),
						'searchable' => true,
					));
				?>
			</fieldset>
			<fieldset>
		        <legend><?php echo __('Attributes'); ?></legend>
		        <h3><?php echo __('Attributes'); ?></h3>
		    	<?php
		    		$parent_settings = array(
						'label' => array(
							'text' => __('Parent'),
						),
						'div' => array('class' => 'forth'),
						'type' => 'select',
						'empty' => __('[ No Parent ]'),
						'searchable' => true,
						'options' => $fismaSystemParents,
					);
					if(isset($fismaSystemChildrenCount) and $fismaSystemChildrenCount)
					{
						$parent_settings['empty'] = __('[Unavailable]');
						$parent_settings['disabled'] = true;
						$parent_settings['after'] = __('This %s already has children, and therefor is already a parent. It cannot be a child of another %s.', __('FISMA System'), __('FISMA System'));
					}
					echo $this->Form->input('parent_id', $parent_settings);
					echo $this->Form->input('fisma_system_hosting_id', array(
						'label' => array(
							'text' => __('AHE Hosting'),
						),
						'div' => array('class' => 'forth'),
						'options' => $fismaSystemHostings,
						'empty' => __('[Select]'),
					));
					echo $this->Form->input('fisma_system_interconnection_id', array(
						'label' => array(
							'text' => __('Interconnection'),
						),
						'div' => array('class' => 'forth'),
						'options' => $fismaSystemInterconnections,
						'empty' => __('[Select]'),
					));
					echo $this->Form->input('fisma_system_gss_status_id', array(
						'label' => array(
							'text' => __('GSS Status'),
						),
						'div' => array('class' => 'forth'),
						'options' => $fismaSystemGssStatuses,
						'empty' => __('[Select]'),
					));
					echo $this->Wrap->divClear();
					echo $this->Form->input('ato_expiration', array(
						'label' => array(
							'text' => __('ATO Expiration'),
						),
						'div' => array('class' => 'forth'),
						'type' => 'date',
					));
					echo $this->Form->input('pii_count', array(
						'label' => array(
							'text' => __('PII Count'),
						),
						'div' => array('class' => 'forth'),
						'default' => '0',
					));
					echo $this->Form->input('is_rogue', array(
						'label' => array(
							'text' => __('Rogue?'),
						),
						'div' => array('class' => 'forth'),
						'type' => 'boolean',
						'default' => 1,
					));
					echo $this->Wrap->divClear();
					echo $this->Form->input('fisma_reportable', array(
						'label' => array(
							'text' => __('FISMA Reportable'),
						),
						'div' => array('class' => 'forth'),
						'type' => 'boolean',
					));
					echo $this->Form->input('ongoing_auth', array(
						'label' => array(
							'text' => __('Under Ongoing Authorization'),
						),
						'div' => array('class' => 'forth'),
						'type' => 'boolean',
					));
					echo $this->Form->input('fisma_system_nist_id', array(
						'label' => array(
							'text' => __('NIST'),
						),
						'div' => array('class' => 'forth'),
						'empty' => __('[Select]'),
					));
					echo $this->Form->input('fisma_system_nihlogin_id', array(
						'label' => array(
							'text' => __('NIH Login'),
						),
						'div' => array('class' => 'forth'),
						'empty' => __('[Select]'),
					));
				?>
			</fieldset>
			<fieldset>
		        <legend><?php echo __('Assessments'); ?></legend>
		        <h3><?php echo __('Assessments'); ?></h3>
		    	<?php
					echo $this->Form->input('fisma_system_fips_rating_id', array(
						'label' => array(
							'text' => __('Fips Rating'),
						),
						'div' => array('class' => 'third'),
						'options' => $fismaSystemFipsRatings,
						'empty' => __('[Select]'),
					));
					echo $this->Form->input('fisma_system_life_safety_id', array(
						'label' => array(
							'text' => __('Life Safety'),
						),
						'div' => array('class' => 'third'),
						'options' => $fismaSystemLifeSafeties,
						'empty' => __('[Select]'),
					));
					echo $this->Form->input('fisma_system_criticality_id', array(
						'label' => array(
							'text' => __('Criticality'),
						),
						'div' => array('class' => 'third'),
						'options' => $fismaSystemCriticalities,
						'empty' => __('[Select]'),
					));
					echo $this->Form->input('fisma_system_affected_parties_id', array(
						'label' => array(
							'text' => __('Affected Party'),
						),
						'div' => array('class' => 'third'),
						'options' => $fismaSystemAffectedParties,
						'empty' => __('[Select]'),
					));
					echo $this->Form->input('fisma_system_risk_assessment_id', array(
						'label' => array(
							'text' => __('FO Risk Assessment'),
						'empty' => __('[Select]'),
						),
						'div' => array('class' => 'third'),
						'options' => $fismaSystemRiskAssessments,
						'empty' => __('[Select]'),
					));
					echo $this->Form->input('fisma_system_threat_assessment_id', array(
						'label' => array(
							'text' => __('FO Threat Assessment'),
						),
						'div' => array('class' => 'third'),
						'options' => $fismaSystemThreatAssessments,
						'empty' => __('[Select]'),
					));
					echo $this->Wrap->divClear();
					echo $this->Form->input('fisma_system_amount_id', array(
						'label' => array(
							'text' => __('Amount'),
						),
						'div' => array('class' => 'third'),
						'options' => $fismaSystemAmounts,
						'empty' => __('[Select]'),
					));
					echo $this->Form->input('fisma_system_com_total_id', array(
						'label' => array(
							'text' => __('Communications Total'),
						),
						'div' => array('class' => 'third'),
						'options' => $fismaSystemComTotals,
						'empty' => __('[Select]'),
					));
					echo $this->Form->input('fisma_system_dependencies_id', array(
						'label' => array(
							'text' => __('Dependency'),
						),
						'div' => array('class' => 'third'),
						'options' => $fismaSystemDependencies,
						'empty' => __('[Select]'),
					));
					echo $this->Form->input('fisma_system_impact_id', array(
						'label' => array(
							'text' => __('Impact'),
						),
						'div' => array('class' => 'third'),
						'options' => $fismaSystemImpacts,
						'empty' => __('[Select]'),
					));
					echo $this->Form->input('fisma_system_uniqueness_id', array(
						'label' => array(
							'text' => __('Uniqueness'),
						),
						'div' => array('class' => 'third'),
						'options' => $fismaSystemUniquenesses,
						'empty' => __('[Select]'),
					));
					echo $this->Form->input('fisma_system_sensitivity_category_id', array(
						'label' => array(
							'text' => __('Sensitivity Category'),
						),
						'div' => array('class' => 'third'),
						'options' => $fismaSystemSensitivityCategories,
						'empty' => __('[Select]'),
					));
					echo $this->Form->input('fisma_system_sensitivity_rating_id', array(
						'label' => array(
							'text' => __('Sensitivity Rating'),
						),
						'div' => array('class' => 'third'),
						'options' => $fismaSystemSensitivityRatings,
						'empty' => __('[Select]'),
					));
				?>
			</fieldset>
			<fieldset>
		        <legend><?php echo __('Physical Location'); ?></legend>
		        <h3><?php echo __('Physical Location'); ?></h3>
		    	<?php
					echo $this->Form->input('FismaSystem.PhysicalLocation', array(
						'multiple' => true,
						'searchable' => true,
						'label' => __('Select which %s are associated with this %s', __('Physical Locations'), __('FISMA System')),
					));
				?>
			</fieldset>
			<fieldset>
		        <legend><?php echo __('Whitelisted Software'); ?></legend>
		        <h3><?php echo __('Whitelisted Software'); ?></h3>
		    	<?php
					echo $this->Form->input('FismaSystem.FismaSoftware', array(
						'multiple' => true,
						'searchable' => true,
						'label' => __('Select which %s is associated with this %s', __('Whitelisted Software'), __('FISMA System')),
					));
				?>
			</fieldset>
			<fieldset>
		        <legend><?php echo __('Notes and/or Extra Details'); ?></legend>
		    	<?php
					echo $this->Form->input('description', array(
						'label' => array(
							'text' => __('Description'),
						),
					));
					echo $this->Form->input('impact', array(
						'label' => array(
							'text' => __('Impact Details'),
						),
					));
					echo $this->Form->input('notes', array(
						'label' => array(
							'text' => __('Notes and/or Extra Details'),
						),
					));
		    	?>
			</fieldset>
			
		<?php echo $this->Form->end(__('Save %s', __('FISMA System'))); ?>
	</div>
</div>