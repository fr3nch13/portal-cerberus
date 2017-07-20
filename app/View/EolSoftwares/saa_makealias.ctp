<?php 

?>
<div class="top">
	<h1><?php echo __('Make %s an Alias', __('Software/Vulnerability') ); ?></h1>
	<h2><?php echo $eolSoftware['EolSoftware']['name']; ?></h2>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create();?>
		    <fieldset>
		        <legend><?php echo __('Edit %s', __('Software/Vulnerability') ); ?></legend>
		    	<?php
				echo $this->Form->input('id');
				echo $this->Wrap->divClear();
				echo $this->Form->input('eol_software_id', array(
					'label' => __('Actual %s', __('Software/Vulnerability')),
					'options' => $eolSoftwares,
				));
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save %s as an Alias', __('Software/Vulnerability') )); ?>
	</div>
</div>