<?php

echo $this->element('Utilities.page_index', array(
	'page_title' => __('Search'),
	'use_search' => false,
	'no_records' => __('Please enter a search term in the form above.'),
));