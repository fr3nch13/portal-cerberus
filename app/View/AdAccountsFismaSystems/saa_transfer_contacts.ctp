<?php 
?>
<div class="top">
	<h1><?php echo __('Transfer %s from one %s to another %s', __('FISMA Contacts'), __('AD Account'), __('AD Account')); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('AdAccountFismaSystem');?>
		    <fieldset>
		        <legend><?php echo __('Transfer %s from one %s to another %s', __('FISMA Contacts'), __('AD Account'), __('AD Account')); ?></legend>
		    	<?php
					echo $this->Form->input('ad_account_from', array(
						'label' => __('From:'),
						'type' => 'select',
						'options' => $adAccounts,
						'div' => array('class' => 'third'),
					));
					echo $this->Form->input('fisma_contact_type_id', array(
						'label' => __('Contact Type'),
						'type' => 'select',
						'options' => $fismaContactTypes,
						'div' => array('class' => 'third'),
					));
					echo $this->Form->input('ad_account_to', array(
						'label' => __('To:'),
						'type' => 'select',
						'options' => $adAccounts,
						'div' => array('class' => 'third'),
					));
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Transfer %s', __('FISMA Contacts'))); ?>
	</div>
</div>