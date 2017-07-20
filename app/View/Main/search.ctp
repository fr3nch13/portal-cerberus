<?php

$search_options = array(
	'fisma_inventories' => __('FISMA Inventory'),
	'us_results' => __('US Results'),
	'eol_results' => __('EOL Results'),
	'pen_test_results' => __('PT Results'),
	'high_risk_results' => __('HRV Results'),
	'ad_accounts' => __('AD Accounts'),
);

echo $this->element('Utilities.page_global_search', array(
	'page_title' => __('Search'),
	'search_options' => $search_options,
));