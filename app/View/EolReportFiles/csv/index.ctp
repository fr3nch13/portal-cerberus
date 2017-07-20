<?php 
// File: app/View/EolReportFiles/csv/eol_report.ctp
$this->Html->setFull(true);

$data = array();
foreach ($eol_report_files as $i => $eol_report_file)
{
    $data[] = array(
		'EolReportFile.filename' => $eol_report_file['EolReportFile']['filename'],
		'EolReportFile.nicename' => $eol_report_file['EolReportFile']['nicename'],
		'EolReportFileState.name' => $eol_report_file['EolReportFileState']['name'],
		'EolReport.name' => $eol_report_file['EolReport']['name'],
		'EolReportFile.uri' => $this->Html->url(array('controller' => 'eol_report_files', 'action' => 'download', $eol_report_file['EolReportFile']['id'])),
    );
}

echo $this->Exporter->view($data, array('count' => count($data)), $this->request->params['ext'], Inflector::camelize(Inflector::singularize($this->request->params['controller'])), false, false);