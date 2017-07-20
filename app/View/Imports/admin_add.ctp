<?php ?>
<!-- File: app/View/Import/admin_add.ctp -->
<div class="top">
	<h1><?php echo __('Add %s', __('Import')); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('Import', array('type' => 'file'));?>
		    <fieldset>
		        <legend><?php echo __('Add %s', __('Import')); ?></legend>
		    	<?php
					echo $this->Form->input('name');
					
					echo $this->Form->input('file', array(
						'type' => 'file',
						'between' => __('(Max file size is %s).', $this->Wrap->maxFileSize()),
						'after' => $this->Html->tag('p', __('Please note, this %s file WILL NOT be scanned after you hit the save button. You have to %s/%s manually.', __('Import'), __('Scan'), __('Rescan'))),
					));
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save %s', __('Import'))); ?>
	</div>
</div>