<?php 
// File: app/View/FismaSoftwares/saa_add.ctp
?>
<div class="top">
	<h1><?php echo __('Add %s', __('Whitelisted Software')); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('FismaSoftware', array('type' => 'file'));?>
		    <fieldset>
		        <legend><?php echo __('Add %s', __('Whitelisted Software')); ?></legend>
		    	<?php
					
					echo $this->Form->input('name', array(
						'label' => __('Software Name'),
						'div' => array('class' => 'half'),
					));
					
					echo $this->Form->input('version', array(
						'label' => __('Version'),
						'div' => array('class' => 'forth'),
					));
					
					echo $this->Form->input('all', array(
						'label' => __('Apply to all %s?', __('FISMA Systems')),
						'div' => array('class' => 'forth'),
					));
					
					echo $this->Wrap->divClear();
					
					echo $this->Form->input('fisma_software_source_id', array(
						'label' => __('FISMA Software %s', __('Source')),
						'div' => array('class' => 'half'),
						'empty' => __('[ Select ]'),
					));
					
					echo $this->Form->input('fisma_software_group_id', array(
						'label' => __('FISMA Software %s', __('Group')),
						'div' => array('class' => 'half'),
						'empty' => __('[ Select ]'),
					));
					
					echo $this->Wrap->divClear();
					
					echo $this->Form->input('FismaSystem', array(
//						'type' => 'multiselect',
						'label' => __('FISMA Systems'),
					));
					
					echo $this->Wrap->divClear();

					echo $this->Form->input('file', array(
						'type' => 'file',
						'label' => __('Attachemnt'),
					));
					
					echo $this->Wrap->divClear();
					
					echo $this->Tag->autocomplete();
					
					echo $this->Form->input('notes', array(
						'label' => array(
							'text' => __('Notes'),
						),
					));
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save %s', __('Whitelisted Software'))); ?>
	</div>
</div>