<?php 

?>
<div class="top">
	<h1><?php echo __('Add %s', __('Software/Vulnerability') ); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create();?>
		    <fieldset>
		        <legend><?php echo __('Add %s', __('Software/Vulnerability') ); ?></legend>
		    	<?php
				echo $this->Form->input('key', array(
					'div' => array('class' => 'fifth'),
				));
				echo $this->Form->input('name', array(
					'div' => array('class' => 'twofifths'),
				));
				echo $this->Form->input('family', array(
					'div' => array('class' => 'fifth'),
				));
				echo $this->Form->input('severity', array(
					'div' => array('class' => 'fifth'),
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
				echo $this->Wrap->divClear();
				echo $this->Form->input('resolved_by_date', array(
					'label' => __('Must be Resolved by'),
					'div' => array('class' => 'third'),
					'type' => 'date',
				));
				echo $this->Form->input('hw_price', array(
					'label' => __('Hardware Price'),
					'div' => array('class' => 'third'),
					'type' => 'price'
				));
				echo $this->Form->input('sw_price', array(
					'label' => __('Software Price'),
					'div' => array('class' => 'third'),
					'type' => 'price'
				));
				echo $this->Wrap->divClear();
				echo $this->Form->input('reports_assignable_party_id', array(
					'label' => __('Assignable Party'),
					'div' => array('class' => 'third'),
				));
				echo $this->Form->input('reports_remediation_id', array(
					'label' => __('Remediation'),
					'div' => array('class' => 'third'),
				));
				echo $this->Form->input('reports_verification_id', array(
					'label' => __('Verification'),
					'div' => array('class' => 'third'),
				));
				echo $this->Wrap->divClear();
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
				echo $this->Wrap->divClear();
				echo $this->Form->input('notes');
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save %s', __('Software/Vulnerability') )); ?>
	</div>
</div>