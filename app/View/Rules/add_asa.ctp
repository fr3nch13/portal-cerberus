<?php
// File: app/View/Rule/add_asa.ctp
?>
<div class="top">
	<h1><?php echo __('Create New %s from ASA config %s', __('Rules'), __('Rules')); ?></h1>
	<h3><?php echo __('All fields are required.'); ?></h3>
	<h3><?php echo __('All fields are applied to every %s added from the ASA Config %s.', __('Rule'), __('Rules')); ?></h3>
	<div class="page_options">
		<ul>
			<li>
				<?php 
				$rule_id = 0;
				$firewall_id = false;
				if(isset($this->request->params['pass'][0]))
					$rule_id = $this->request->params['pass'][0];
				if(isset($this->request->params['pass'][1]))
					$firewall_id = $this->request->params['pass'][1];
				echo $this->Html->link(__('Simple Form'), array('action' => 'add', $rule_id, true, $firewall_id)); 
				echo $this->Html->link(__('Advanced Form'), array('action' => 'add_advanced', $rule_id, $firewall_id));
				?>
			</li>
		</ul>
	</div>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('Rule');?>
		    <fieldset>
				<h3><?php echo __('Details'); ?></h3>
		        <?php
					echo $this->Wrap->divClear();
					
					echo $this->Form->input('Rule.poc_email', array(
						'label' => array(
							'text' => __('Rule POC Email'),
						),
						'div' => array('class' => 'third'),
					));
					
					echo $this->Form->input('Rule.ticket', array(
						'label' => array(
							'text' => __('Related Tickets'),
						),
						'div' => array('class' => 'third'),
					));
					
					echo $this->Form->input('Rule.firewall_id', array(
						'label' => array(
							'text' => __('Firewall'),
						),
						'div' => array('class' => 'third'),
					));
					
					echo $this->Wrap->divClear();
					
					echo $this->Form->input('Rule.src_fisma_system_id', array(
						'label' => array(
							'text' => __('Source FISMA System'),
						),
						'div' => array('class' => 'half'),
						'options' => $fisma_systems,
					));
					
					echo $this->Form->input('Rule.dst_fisma_system_id', array(
						'label' => array(
							'text' => __('Destination FISMA System'),
						),
						'div' => array('class' => 'half'),
						'options' => $fisma_systems,
					));
					
					echo $this->Wrap->divClear();
					
					echo $this->Form->input('Rule.comments', array(
						'label' => array(
							'text' => __('Comments'),
						),
						'class' => 'short',
					));
					
					echo $this->Wrap->divClear();
					
					echo $this->Form->input('Rule.asa_rules', array(
						'type' => 'textarea',
						'label' => array(
							'text' => __('ASA Config %s', __('Rules')),
						),
						'class' => 'short',
					));
					
					echo $this->Wrap->divClear();
					
					echo $this->Form->input('Rule.send_notification', array(
						'label' => array(
							'text' => __('Notify Other Users'),
						),
						'type' => 'checkbox',
						'checked' => false,
						'class' => 'switch_holder',
					));
		        ?>
		    </fieldset>
		<?php echo $this->Form->end(__('Add %s', __('Rules'))); ?>
	</div>
</div>