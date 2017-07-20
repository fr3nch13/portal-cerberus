<?php 
// File: app/View/HighRiskReportFiles/csv/high_risk_report.ctp
$this->Html->setFull(true);

$data = array();
foreach ($high_risk_report_files as $i => $high_risk_report_file)
{
    $data[] = array(
		'HighRiskReportFile.filename' => $high_risk_report_file['HighRiskReportFile']['filename'],
		'HighRiskReportFile.nicename' => $high_risk_report_file['HighRiskReportFile']['nicename'],
		'HighRiskReportFileState.name' => $high_risk_report_file['HighRiskReportFileState']['name'],
		'HighRiskReport.name' => $high_risk_report_file['HighRiskReport']['name'],
		'HighRiskReportFile.uri' => $this->Html->url(array('controller' => 'high_risk_report_files', 'action' => 'download', $high_risk_report_file['HighRiskReportFile']['id'])),
    );
}

echo $this->Exporter->view($data, array('count' => count($data)), $this->request->params['ext'], Inflector::camelize(Inflector::singularize($this->request->params['controller'])), false, false);