<?php 
// File: app/View/HighRiskResult/edit.ctp
?>
<div class="top">
	<h1><?php echo __('Edit %s', __('High Risk Result')); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('HighRiskResult'); ?>
		<?php echo $this->Form->input('id'); ?>
		    <fieldset>
		        <legend><?php echo __('Host Information'); ?></legend>
		    	<h3><?php echo __('Host Information'); ?></h3>
		    	<?php
				echo $this->Form->input('fisma_system_id', array(
					'label' => __('FISMA System'),
					'div' => array('class' => 'forth'),
					'empty' => __('* Dynamic *'),
				));
				echo $this->Form->input('host_name', array(
					'div' => array('class' => 'forth'),
				));
		    	echo $this->Form->input('ip_address', array(
					'div' => array('class' => 'forth'),
				));
		    	echo $this->Form->input('port', array(
					'div' => array('class' => 'forth'),
				));
				echo $this->Form->input('mac_address', array(
					'label' => __('MAC Address'),
					'div' => array('class' => 'third'),
				));
		    	echo $this->Form->input('asset_tag', array(
					'div' => array('class' => 'third'),
				));
		    	?>
		    </fieldset>
		    <fieldset>
		    	<h3><?php echo __('High Risk Results'); ?></h3>
		        <legend><?php echo __('High Risk Results'); ?></legend>
		    	<?php
				echo $this->Form->input('eol_software_id', array(
					'label' => __('Software/Vulnerability'),
				));
				echo $this->Wrap->divClear();
				echo $this->Form->input('ticket', array(
					'div' => array('class' => 'forth'),
					'description' => __('Seperate multiple with a semi-colon (;).'),
				));
				echo $this->Form->input('waiver', array(
					'label' => __('Waivers'),
					'div' => array('class' => 'forth'),
					'description' => __('Seperate multiple with a semi-colon (;).'),
				));
				echo $this->Form->input('changerequest', array(
					'label' => __('Change Request IDs'),
					'div' => array('class' => 'forth'),
					'description' => __('Seperate multiple with a semi-colon (;).'),
				));
				echo $this->Form->input('ticket_id', array(
					'label' => __('Ticket ID'),
					'type' => 'text',
					'div' => array('class' => 'forth'),
				));
				echo $this->Wrap->divClear();
				echo $this->Form->input('dhs', array(
					'div' => array('class' => 'forth'),
				));
				echo $this->Form->input('reported_to_ic_date', array(
					'label' => __('Reported to ORG/IC'),
					'div' => array('class' => 'forth'),
				));
				echo $this->Form->input('resolved_by_date', array(
					'label' => __('Must be Resolved By'),
					'div' => array('class' => 'forth'),
				));
				echo $this->Form->input('estimated_remediation_date', array(
					'label' => __('Estimated Remediation Date'),
					'div' => array('class' => 'forth'),
				));
				echo $this->Wrap->divClear();
				echo $this->Form->input('reports_system_type_id', array(
					'label' => __('System Type'),
					'div' => array('class' => 'half'),
				));
				echo $this->Form->input('reports_status_id', array(
					'label' => __('Status'),
					'div' => array('class' => 'half'),
				));
				echo $this->Wrap->divClear();
				echo $this->Form->input('reports_remediation_id', array(
					'label' => __('Remediation'),
					'div' => array('class' => 'third'),
				));
				echo $this->Form->input('reports_verification_id', array(
					'label' => __('Verification'),
					'div' => array('class' => 'third'),
				));
				echo $this->Form->input('reports_assignable_party_id', array(
					'label' => __('Assignable Party'),
					'div' => array('class' => 'third'),
				));
				echo $this->Wrap->divClear();
				echo $this->Form->input('comments', array(
					'label' => __('Comments'),
					'div' => array('class' => 'half'),
					'after' => $this->Html->tag('p', __("(Please explain why it's False positive, Acceptable Risk or Action(s) taken) ")),
				));
				echo $this->Form->input('notes', array(
					'label' => __('Notes'),
					'div' => array('class' => 'half'),
				));
				echo $this->Tag->autocomplete();
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Update %s', __('High Risk Result'))); ?>
	</div>
</div>