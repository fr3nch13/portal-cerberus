<?php

$this->set('page_subtitle', __('US Results For %s: %s that are new from the previous report.', __('US Report'), $us_report['UsReport']['name']));
$this->extend('index');