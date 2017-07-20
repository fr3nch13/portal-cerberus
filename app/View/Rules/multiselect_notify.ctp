<?php
// File: app/View/Rule/edit.ctp
?>
<div class="top">
	<h1><?php echo __('Send Email Notification for multiple %s', __('Rules')); ?></h1>
	<h3><?php echo __('All fields are required.'); ?></h3>
	
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('Rule');?>
		    <fieldset>
				<h3><?php echo __('Details'); ?></h3>
		        <?php
					echo $this->Form->input('User', array(
						'label' => array(
							'text' => __('Users to Notify by Email'),
						),
						'multiple' => true,
					));
					
					echo $this->Form->input('Rule.notification_comments', array(
						'label' => array(
							'text' => __('Email Comments'),
						),
						'type' => 'textarea',
						'class' => 'short',
					));
		        ?>
		    </fieldset>
		<?php echo $this->Form->end(__('Send Email Notification for %s', __('Rules'))); ?>
	</div>
</div>