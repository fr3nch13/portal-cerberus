<?php

$pivot_id = (isset($pivot_id)?$pivot_id:'pivot_list_'. rand(1,1000));

$page_options = array();

$divisionHtml = '';
foreach($pivotList as $i => $division)
{
	if($division['FismaSystems'])
	{
		$parentHtml = '';
		foreach($division['FismaSystems'] as $j => $fismaSystemParent)
		{
			$childHtml = '';
			if($fismaSystemParent['children'])
			{
				foreach($fismaSystemParent['children'] as $x => $fismaSystemChild)
				{
					$name = $this->Html->tag('span', $fismaSystemChild['FismaSystem']['name'], array('class' => 'pivot-name'));
					$desc = $this->Html->tag('span', $fismaSystemChild['FismaSystem']['fullname'], array('class' => 'pivot-desc'));
					$childLink = $this->Html->link($name.$desc, array('action' => 'view', $fismaSystemChild['FismaSystem']['id']), array('escape' => false));
					$childHtml .= $this->Html->tag('li', $childLink);
				}
				$childHtml = $this->Html->tag('ul', $childHtml);
			}
			$name = $this->Html->tag('span', $fismaSystemParent['FismaSystem']['name'], array('class' => 'pivot-name'));
			$desc = $this->Html->tag('span', $fismaSystemParent['FismaSystem']['fullname'], array('class' => 'pivot-desc'));
			$parentLink = $name.$desc;
			$parentLink = $this->Html->tag('span', $parentLink, array('class' => 'level-1'));
			$parentLink = $this->Html->link($parentLink, array('action' => 'view', $fismaSystemParent['FismaSystem']['id']), array('escape' => false));
			$parentHtml .= $this->Html->tag('li', $parentLink. $childHtml);
		}
		$parentHtml = $this->Html->tag('ul', $parentHtml);
	}
	
	$name = $this->Html->tag('span', $division['Division']['shortname'], array('class' => 'pivot-name'));
	$desc = $this->Html->tag('span', $division['Division']['name'], array('class' => 'pivot-desc'));
	$divisionLink = $name.$desc;
	$divisionLink = $this->Html->tag('span', $divisionLink, array('class' => 'level-0'));
	
	if($division['Division']['id'])
		$divisionLink = $this->Html->link($divisionLink, array('controller' => 'divisions', 'action' => 'view', $division['Division']['id']), array('escape' => false));
	
	$divisionHtml .= $this->Html->tag('li', $divisionLink. $parentHtml);
}
$divisionHtml = $this->Html->tag('ul', $divisionHtml);
$pivotTitle = $this->Html->tag('span', __('Divisions'), array('class' => 'pivot-title'));
$divisionHtml = $this->Html->tag('li', $pivotTitle. $divisionHtml);
$divisionHtml = $this->Html->tag('ul', $divisionHtml, array('class' => 'pivot-root'));
$divisionHtml = $this->Html->tag('div', $divisionHtml, array('id' => 'object-pivot-'. $pivot_id));

$this->start('page_content');

echo $divisionHtml;
?>

	
<script type="text/javascript">
//<![CDATA[
$(document).ready(function ()
{
	var pivotOptions = {
	};
	
	$('div#object-pivot-<?php echo $pivot_id; ?>').objectPivot(pivotOptions);
});
//]]>
</script>
<?php

$this->end();

echo $this->element('Utilities.page_generic', array(
	'page_title' => __('%s Heirarchy List', __('FISMA Systems')),
	'page_options' => $page_options,
	'page_content' => $this->fetch('page_content'),
));