<?php
// File: app/View/Equipment/batch_add.ctp
?>
<div class="top">
	<h1><?php echo __('Create Many New NAC Exceptions/Tracking'); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('Equipment', array('id' => 'AddEquipmentForm'));?>
		    <fieldset>
		        <legend class="section"><?php echo __('Details for new Records'); ?></legend>
		        <?php
					
					$between = array();
					$between[] = $this->Html->tag('p', __('Paste your CSV (Comma Separated Value) data in the blank form field below. The first row must include column headers that map to each row of data.'), array('class' => 'info'));
					$between[] = $this->Html->tag('p', __('The next page will allow you to map your CSV Column Headers to the NACCESS input fields for a bulk import, allowing you to have your CSV columns in any order.'), array('class' => 'info'));
					$between[] = $this->Html->tag('p', __('Here is an example of pasted data:'), array('class' => 'info'));
					$between[] = $this->Html->tag('p', __('Asset Tag,Pri MAC,Pri IP,Ticket,TEM List,OPDIV'), array('class' => 'info'));
					$between[] = $this->Html->tag('p', __('ORF-01545669,00-1e-4f-f4-ab-96,128.231.101.8,INC1122313,4-28 XP TEM List,ORS'), array('class' => 'info'));
					$between[] = $this->Html->tag('p', __('ORF-01768076,00-21-9b-2f-97-57,128.231.101.99,INC1122313,4-28 XP TEM List,ORS'), array('class' => 'info'));
					
					echo $this->Form->input('Equipment.csv', array(
						'label' => array(
							'text' => __('The CSV Data Set.'),
						),
						'between' => implode("\n", $between),
						'rows' => '8',
						'style' => 'height:8em;',
					));
					
					echo $this->Wrap->divClear();
		        ?>
		    </fieldset>
		<?php echo $this->Form->end(__('Map the Fields')); ?>
	</div>
</div>
