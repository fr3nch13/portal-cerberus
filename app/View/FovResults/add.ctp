<?php 
?>
<div class="top">
	<h1><?php echo __('Add %s', __('FOV Result')); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create(); ?>
		    <fieldset>
		    	<h3><?php echo __('Host Information'); ?></h3>
		    	<?php
				echo $this->Form->input('reports_organization_id', array(
					'label' => __('Organization'),
					'div' => array('class' => 'forth'),
				));
				echo $this->Form->input('fisma_system_id', array(
					'label' => __('FISMA System'),
					'div' => array('class' => 'threeforths'),
					'empty' => __('* Dynamic *'),
				));
				echo $this->Wrap->divClear();
				echo $this->Form->input('hosts', array(
					'label' => __('Hosts'),
					'type' => 'textarea',
					'description' => __('CSV Format: host_description, hostname, ip address, asset tag, mac address, netbios'),
				));
		    	?>
		    	<h3><?php echo __('Result Details'); ?></h3>
		    	<?php
				echo $this->Form->input('eol_software_id', array(
					'label' => __('Software/Vulnerability'),
				));
				echo $this->Wrap->divClear();
				echo $this->Form->input('tickets', array(
					'label' => __('Related Tickets'),
					'div' => array('class' => 'third'),
					'description' => __('Seperate multiple with a semi-colon (;).'),
				));
				echo $this->Form->input('waiver', array(
					'label' => __('Waivers'),
					'div' => array('class' => 'third'),
					'description' => __('Seperate multiple with a semi-colon (;).'),
				));
				echo $this->Form->input('changerequest', array(
					'label' => __('Change Request IDs'),
					'div' => array('class' => 'third'),
					'description' => __('Seperate multiple with a semi-colon (;).'),
				));
				?>
		    	<h3><?php echo __('Dates'); ?></h3>
		        <?php
				echo $this->Form->input('reported_date', array(
					'label' => __('Reported'),
					'div' => array('class' => 'forth'),
					'type' => 'date',
				));
				echo $this->Form->input('resolved_by_date', array(
					'label' => __('Must be resolved by'),
					'div' => array('class' => 'forth'),
					'type' => 'date',
				));
		        ?>
		    	<h3><?php echo __('Attributes'); ?></h3>
		        <?php
				echo $this->Form->input('reports_assignable_party_id', array(
					'label' => __('Assignable Party'),
					'div' => array('class' => 'fifth'),
				));
				echo $this->Form->input('reports_remediation_id', array(
					'label' => __('Remediation'),
					'div' => array('class' => 'fifth'),
				));
				echo $this->Form->input('reports_severity_id', array(
					'label' => __('Severity'),
					'div' => array('class' => 'fifth'),
				));
				echo $this->Form->input('reports_status_id', array(
					'label' => __('Status'),
					'div' => array('class' => 'fifth'),
				));
				echo $this->Form->input('reports_verification_id', array(
					'label' => __('Verification'),
					'div' => array('class' => 'fifth'),
				));
		        ?>
		    	<h3><?php echo __('Extra Details'); ?></h3>
		        <?php
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
		<?php echo $this->Form->end(__('Save %s', __('FOV Result'))); ?>
	</div>
</div>