<?php
// File: app/View/FismaInventory/saa_batch_add.ctp
?>
<div class="top">
	<h1><?php echo __('Add Many %s', __('FISMA Inventory Items')); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('FismaInventory', array('id' => 'AddFismaInventoryForm'));?>
		    <fieldset>
		        <legend class="section"><?php echo __('Details for new Records'); ?></legend>
		        <?php
					
					$between = array();
					$between[] = $this->Html->tag('p', __('Paste your CSV (Comma Separated Value) data in the blank form field below. The first row must include column headers that map to each row of data.'), array('class' => 'info'));
					$between[] = $this->Html->tag('p', __('The next page will allow you to map your CSV Column Headers to the Cerberus input fields for a bulk import, allowing you to have your CSV columns in any order.'), array('class' => 'info'));
					$between[] = $this->Html->tag('p', __('Here is an example of pasted data:'), array('class' => 'info'));
					$between[] = $this->Html->tag('p', __('Asset Tag,Pri MAC,Pri IP,Ticket,DNS Name'), array('class' => 'info'));
					
					echo $this->Form->input('FismaInventory.csv', array(
						'label' => array(
							'text' => __('The CSV Data Set.'),
						),
						'between' => implode("\n", $between),
						'rows' => '8',
						'style' => 'height:8em;',
					));
					
					echo $this->Tag->autocomplete();
					
					echo $this->Wrap->divClear();
		        ?>
		    </fieldset>
		<?php echo $this->Form->end(__('Map the Fields')); ?>
	</div>
</div>
