<?php

class UpdateShell extends AppShell
{
	// the models to use
	public $uses = array('AdAccount', 'Subnet', 'HighRiskResult', 'PenTestResult', 'Rule');
	
	public function startup() 
	{
		$this->clear();
		$this->out('Update Shell');
		$this->hr();
		return parent::startup();
	}
	
	public function getOptionParser()
	{
	/*
	 * Parses out the options/arguments.
	 * http://book.cakephp.org/2.0/en/console-and-shells.html#configuring-options-and-generating-help
	 */
	
		$parser = parent::getOptionParser();
		
		$parser->description(__d('cake_console', 'The Update Shell runs all needed jobs to update production\'s database.'));
		
		$parser->addSubcommand('rescan_subnets', array(
			'help' => __d('cake_console', 'Takes all of the subnets, and rescans them.'),
		));
		$parser->addSubcommand('fix_high_risk', array(
			'help' => __d('cake_console', 'Fixes High Risk Results'),
		));
		$parser->addSubcommand('update_results', array(
			'help' => __d('cake_console', 'Updated Software/Vulnerabilities for Pen Test and High Risk.'),
		));
		$parser->addSubcommand('update_pentest', array(
			'help' => __d('cake_console', 'Update PenTest to work like eol with many to many reports/results.'),
		));
		$parser->addSubcommand('update_rules', array(
			'help' => __d('cake_console', 'Update Rules with new hashing.'),
		));
		
		return $parser;
	}
	
	public function update_rules()
	{
		$this->Rule->rehashAll();
	}
	
	public function rescan_subnets()
	{
		$this->Subnet->rescanAll();
	}
	
	public function fix_high_risk()
	{
		$this->HighRiskResult->fixAll();
	}
	
	public function update_results()
	{
		$this->HighRiskResult->upsateExistingEolSoftware();
		$this->PenTestResult->upsateExistingEolSoftware();
	}
	
	public function update_pentest()
	{
		$this->PenTestResult->updateExisting();
	}
}