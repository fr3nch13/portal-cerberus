<?php 
// File: app/View/EolResult/edit.ctp
?>
<div class="top">
	<h1><?php echo __('Edit %s', __('EOL Result')); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('EolResult'); ?>
		<?php echo $this->Form->input('id'); ?>
		    <fieldset>
		        <legend><?php echo __('Host Information'); ?></legend>
		    	<h3><?php echo __('Host Information'); ?></h3>
		    	<?php
				echo $this->Form->input('reports_organization_id', array(
					'label' => __('Organization'),
					'div' => array('class' => 'forth'),
				));
				echo $this->Form->input('fisma_system_id', array(
					'label' => __('FISMA System'),
					'div' => array('class' => 'forth'),
					'empty' => __('* Dynamic *'),
				));
				echo $this->Form->input('host_description', array(
					'label' => __('Host Description'),
					'div' => array('class' => 'half'),
				));
				echo $this->Wrap->divClear();
		    	echo $this->Form->input('host_name', array(
					'div' => array('class' => 'third'),
				));
		    	echo $this->Form->input('ip_address', array(
					'div' => array('class' => 'third'),
				));
		    	echo $this->Form->input('mac_address', array(
					'div' => array('class' => 'third'),
				));
		    	echo $this->Form->input('asset_tag', array(
					'div' => array('class' => 'third'),
				));
				echo $this->Form->input('netbios', array(
					'label' => __('NetBIOS'),
					'div' => array('class' => 'third'),
				));
		    	echo $this->Form->input('service', array(
					'div' => array('class' => 'third'),
				));
		    	?>
		    </fieldset>
		    <fieldset>
		    	<h3><?php echo __('Result Details'); ?></h3>
		        <legend><?php echo __('Result Details'); ?></legend>
		    	<?php
				echo $this->Form->input('eol_software_id', array(
					'label' => __('Software/Vulnerability'),
				));
				echo $this->Wrap->divClear();
				echo $this->Form->input('tickets', array(
					'label' => __('Related Tickets'),
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
				echo $this->Form->input('resolved_by_date', array(
					'label' => __('Must be resolved by'),
					'div' => array('class' => 'forth'),
					'type' => 'date',
				));
				echo $this->Form->input('hw_price', array(
					'label' => __('Hardware Price'),
					'div' => array('class' => 'forth'),
					'type' => 'price'
				));
				echo $this->Form->input('sw_price', array(
					'label' => __('Software Price'),
					'div' => array('class' => 'forth'),
					'type' => 'price'
				));
				echo $this->Form->input('nessus', array(
					'label' => __('Nessus?'),
					'div' => array('class' => 'forth'),
				));
				echo $this->Wrap->divClear();
				echo $this->Form->input('reports_status_id', array(
					'label' => __('Status'),
					'div' => array('class' => 'forth'),
				));
				echo $this->Form->input('reports_remediation_id', array(
					'label' => __('Remediation'),
					'div' => array('class' => 'forth'),
				));
				echo $this->Form->input('reports_verification_id', array(
					'label' => __('Verification'),
					'div' => array('class' => 'forth'),
				));
				echo $this->Form->input('reports_assignable_party_id', array(
					'label' => __('Assignable Party'),
					'div' => array('class' => 'forth'),
				));
				echo $this->Wrap->divClear();
				echo $this->Form->input('description', array(
					'label' => __('Detailed Description'),
				));
				echo $this->Form->input('action_recommended', array(
					'label' => __('Recommended Action'),
					'div' => array('class' => 'third'),
				));
				echo $this->Form->input('action_taken', array(
					'label' => __('Action Taken'),
					'div' => array('class' => 'third'),
				));
				echo $this->Form->input('action_date', array(
					'label' => __('Date Action was Taken'),
					'div' => array('class' => 'third'),
					'type' => 'date',
				));
				echo $this->Form->input('comments', array(
					'label' => __('Comments'),
					'div' => array('class' => 'half'),
					'description' => __("(Please explain why it's False positive, Acceptable Risk or Action(s) taken)"),
				));
				echo $this->Form->input('notes', array(
					'label' => __('Notes'),
					'div' => array('class' => 'half'),
				));
				echo $this->Tag->autocomplete();
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Update %s', __('EOL Result'))); ?>
	</div>
</div>