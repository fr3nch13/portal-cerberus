<?php

$this->Html->setFull(true);

$page_options = array(
	$this->Html->link(__("View this %s", __('FISMA System')), array('controller' => 'fisma_systems', 'action' => 'view', $fisma_system['FismaSystem']['id'])),
);

$details_blocks = array();

$details_blocks[1][1] = array(
	'title' => __('Details'),
	'details' => array(
		array('name' => __('Fips Rating'), 'value' => $fisma_system['FismaSystemFipsRating']['name']),
		array('name' => __('FO Risk Assessment'), 'value' => $fisma_system['FismaSystemRiskAssessment']['name']),
		array('name' => __('FO Threat Assessment'), 'value' => $fisma_system['FismaSystemThreatAssessment']['name']),
		array('name' => __('AHE Hosting'), 'value' => $fisma_system['FismaSystemHosting']['name']),
		array('name' => __('Interconnection'), 'value' => $fisma_system['FismaSystemInterconnection']['name']),
		array('name' => __('GSS Status'), 'value' => $fisma_system['FismaSystemGssStatus']['name']),
		array('name' => __('ATO Expiration'), 'value' => $this->Wrap->niceTime($fisma_system['FismaSystem']['ato_expiration'])),
		array('name' => __('Created'), 'value' => $this->Wrap->niceTime($fisma_system['FismaSystem']['created'])),
		array('name' => __('Modified'), 'value' => $this->Wrap->niceTime($fisma_system['FismaSystem']['modified'])),
	),
);

$details_blocks[1][2] = array(
	'title' => __('Contacts'),
	'details' => array(
		array('name' => __('Owner Name'), 'value' => $fisma_system['FismaSystem']['owner_name']),
		array('name' => __('Owner Email'), 'value' => $this->Html->link($fisma_system['FismaSystem']['owner_email'], 'mailto:'. $fisma_system['FismaSystem']['owner_email'])),
		array('name' => __('Tech Contact Name'), 'value' => $fisma_system['FismaSystem']['tech_name']),
		array('name' => __('Tech Contact Email'), 'value' => $this->Html->link($fisma_system['FismaSystem']['tech_email'], 'mailto:'. $fisma_system['FismaSystem']['tech_email'])),
		array('name' => __('DAA Contact'), 'value' => $this->Html->link($fisma_system['FismaDaaUser']['name'], array('controller' => 'users', 'action' => 'view', $fisma_system['FismaDaaUser']['id']))),
		array('name' => __('DAA-R Contact'), 'value' => $this->Html->link($fisma_system['FismaDaarUser']['name'], array('controller' => 'users', 'action' => 'view', $fisma_system['FismaDaarUser']['id']))),
		array('name' => __('ISSO Contact'), 'value' => $this->Html->link($fisma_system['FismaIssoUser']['name'], array('controller' => 'users', 'action' => 'view', $fisma_system['FismaIssoUser']['id']))),
		array('name' => __('Alt-ISSO Contact'), 'value' => $this->Html->link($fisma_system['FismaAissoUser']['name'], array('controller' => 'users', 'action' => 'view', $fisma_system['FismaAissoUser']['id']))),
	),
);

echo $this->element('Utilities.email_html_view_columns', array(
	'page_title' => __('%s: %s', __('FISMA System'), $fisma_system['FismaSystem']['name']),
	'page_subtitle2' => __('Full Name: %s', $fisma_system['FismaSystem']['fullname'].' '),
	'details_blocks' => $details_blocks,
	'page_options' => $page_options,
));
