<?php ?>
	<li><?php echo $this->Html->link(__('Portal Overview'), array('controller' => 'main', 'action' => 'dashboard', 'admin' => false, 'plugin' => false), array('class' => 'top')); ?></li>
	<li><?php echo $this->Html->link(__('My Overview'), array('controller' => 'main', 'action' => 'my_dashboard', 'admin' => false, 'plugin' => false), array('class' => 'top')); ?></li>
<!--	<li><?php echo $this->Html->link(__('Rules'), array('controller' => 'rules', 'action' => 'dashboard', 'admin' => false, 'plugin' => false), array('class' => 'top')); ?></li> -->
	<li>
		<?php echo $this->Html->link(__('FISMA Systems'), array('controller' => 'fisma_systems', 'action' => 'dashboard', 'admin' => false, 'plugin' => false), array('class' => 'top')); ?>
		<ul>
			<li><?php echo $this->Html->link(__('Dashboard'), array('controller' => 'fisma_systems', 'action' => 'dashboard', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('OAM %s Dashboard', __('FISMA Systems')), array('controller' => 'fisma_systems', 'action' => 'db_tab_oam', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('%s Summary Dashboard', __('FISMA Systems')), array('controller' => 'fisma_systems', 'action' => 'db_tab_summary', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('Orginazional Chart'), array('controller' => 'fisma_systems', 'action' => 'db_tab_orgchart', 'admin' => false, 'plugin' => false)); ?></li>
		</ul>
		</li>
	<li><?php echo $this->Html->link(__('US'), array('controller' => 'us_results', 'action' => 'dashboard', 'admin' => false, 'plugin' => false), array('class' => 'top')); ?></li>
	<li><?php echo $this->Html->link(__('EOL'), array('controller' => 'eol_results', 'action' => 'dashboard', 'admin' => false, 'plugin' => false), array('class' => 'top')); ?></li>
	<li><?php echo $this->Html->link(__('Pen Tests'), array('controller' => 'pen_test_results', 'action' => 'dashboard', 'admin' => false, 'plugin' => false), array('class' => 'top')); ?></li>
	<li><?php echo $this->Html->link(__('High Risk'), array('controller' => 'high_risk_results', 'action' => 'dashboard', 'admin' => false, 'plugin' => false), array('class' => 'top')); ?></li>
	