<?php 
// File: app/View/Fogs/csv/index_expanded.ctp

$data = array();
foreach ($fogs as $i => $fog)
{
    $data[] = array(
		'Fog.name' => $fog['Fog']['name'],
		'Fog.ip_address' => $fog['Fog']['ip_address'],
    );
}

echo $this->Exporter->view($data, array(), $this->request->params['ext'], Inflector::camelize(Inflector::singularize($this->request->params['controller'])), false, false);