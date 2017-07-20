<?php

$th = [];
$th['AdAccountDetail.fisma_training_date'] = ['content' => __('%s Training', __('FISMA System')), 'options' => ['editable' => ['type' => 'date']]];

$trainingThresholdYellow = strtotime('-300 days');
$trainingThresholdRed = strtotime('-365 days');
$td = [];
foreach ($adAccounts as $i => $adAccount)
{
	$td[$i] = [];
	
	$training_day = false;
	if(isset($adAccount['AdAccountDetail']['fisma_training_date']))
		$training_day = $adAccount['AdAccountDetail']['fisma_training_date'];
		
	$trainingClass = 'highlight-green';
	$trainingTime = strtotime($training_day);
	if(!$trainingTime)
		$trainingClass = 'highlight-red';
	elseif($trainingTime < $trainingThresholdYellow)
		$trainingClass = 'highlight-yellow';
	elseif($trainingTime < $trainingThresholdRed)
		$trainingClass = 'highlight-red';
	
	$td[$i]['AdAccountDetail.fisma_training_date'] = [
		$this->Wrap->niceDay($training_day),
		['class' => $trainingClass, 'value' => $training_day]
	];
}

$this->set('no_counts', true);

$this->set(compact(['th', 'td']));

$this->extend('index');