<?php 
// File: app/View/Pogs/csv/index_expanded.ctp

$data = array();
foreach ($pogs as $i => $pog)
{
    $data[] = array(
		'Pog.name' => $pog['Pog']['name'],
		'Pog.port' => $pog['Pog']['port'],
    );
}

echo $this->Exporter->view($data, array(), $this->request->params['ext'], Inflector::camelize(Inflector::singularize($this->request->params['controller'])), false, false);