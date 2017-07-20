<?php 
// File: app/View/SubnetPoams/view.ctp

$page_options = array();

$page_options[] = $this->Html->link(__('Edit'), array('action' => 'edit', $subnet['Subnet']['id']));
$page_options[] = $this->Html->link(__('Rescan'), array('action' => 'rescan', $subnet['Subnet']['id']));
$page_options[] = $this->Html->link(__('Delete'), array('action' => 'delete', $subnet['Subnet']['id']), array('confirm' => 'Are you sure?'));

$details_blocks = array(
);

$details_blocks[1][1] = array(
	'title' => __('Network Details'),
	'details' => array(
		array('name' => __('CIDR'), 'value' => $subnet['Subnet']['cidr']),
		array('name' => __('Netmask'), 'value' => $subnet['Subnet']['netmask']),
		array('name' => __('IP Range'), 'value' => __('%s - %s', $subnet['Subnet']['ip_start'], $subnet['Subnet']['ip_end'])),
		array('name' => __('DHCP?'), 'value' => $this->Wrap->yesNo($subnet['Subnet']['dhcp'])),
		array('name' => __('DHCP Scope'), 'value' => $subnet['Subnet']['dhcp_scope']),
		array('name' => __('Saturation'), 'value' => __('%s%', $subnet['Subnet']['fisma_inventory_percent'])),
	),
);

$details_blocks[1][2] = array(
	'title' => __('Other Details'),
	'details' => array(
		array('name' => __('IC'), 'value' => $subnet['Subnet']['ic']),
		array('name' => __('Location'), 'value' => $subnet['Subnet']['location']),
		array('name' => __('Comments'), 'value' => $subnet['Subnet']['comments']),
		array('name' => __('Created'), 'value' => $this->Wrap->niceTime($subnet['Subnet']['created'])),
		array('name' => __('Modified'), 'value' => $this->Wrap->niceTime($subnet['Subnet']['modified'])),
	),
);
$stats = array();
$tabs = array();

$tabs['fisma_inventories'] = $stats['fisma_inventories'] = array(
	'id' => 'fisma_inventories',
	'name' => __('FISMA Inventories'), 
	'ajax_url' => array('controller' => 'subnet_members', 'action' => 'fisma_inventories', $subnet['Subnet']['id']),
);

$tabs['us_results'] = $stats['us_results'] = array(
	'id' => 'us_results',
	'name' => __('US Results'), 
	'ajax_url' => array('controller' => 'subnet_members', 'action' => 'us_results', $subnet['Subnet']['id']),
);

$tabs['eol_results'] = $stats['eol_results'] = array(
	'id' => 'eol_results',
	'name' => __('EOL Results'), 
	'ajax_url' => array('controller' => 'subnet_members', 'action' => 'eol_results', $subnet['Subnet']['id']),
);

$tabs['pen_test_results'] = $stats['pen_test_results'] = array(
	'id' => 'pen_test_results',
	'name' => __('Pen Test Results'), 
	'ajax_url' => array('controller' => 'subnet_members', 'action' => 'pen_test_results', $subnet['Subnet']['id']),
);

$tabs['high_risk_results'] = $stats['high_risk_results'] = array(
	'id' => 'high_risk_results',
	'name' => __('High Risk Results'), 
	'ajax_url' => array('controller' => 'subnet_members', 'action' => 'high_risk_results', $subnet['Subnet']['id']),
);
/*
$tabs['rules'] = $stats['rules'] = array(
	'id' => 'rules',
	'name' => __('Combined Rules'), 
	'ajax_url' => array('admin' => false, 'controller' => 'rules', 'action' => 'subnet', $subnet['Subnet']['id']),
);
$tabs['rules_src'] = $stats['rules_src'] = array(
	'id' => 'rules_src',
	'name' => __('SRC Rules'), 
	'ajax_url' => array('admin' => false, 'controller' => 'rules', 'action' => 'subnet', $subnet['Subnet']['id'], 'src'),
);
$tabs['rules_dst'] = $stats['rules_dst'] = array(
	'id' => 'rules_dst',
	'name' => __('DST Rules'), 
	'ajax_url' => array('admin' => false, 'controller' => 'rules', 'action' => 'subnet', $subnet['Subnet']['id'], 'dst'),
);
*/

echo $this->element('Utilities.page_view_columns', array(
	'page_title' => __('%s : %s : %s', $subnet['Subnet']['cidr'], $subnet['Subnet']['ic'], $subnet['Subnet']['location']),
	'page_options' => $page_options,
	'stats' => $stats,
	'details_blocks' => $details_blocks,
	'tabs_id' => 'tabs',
	'tabs' => $tabs,
));
?>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function () {
	$.ajax({
		dataType:"html", 
		url:"<?php echo $this->Html->url(array('controller' => 'subnet_members', 'action' => 'fisma_inventories_stats', $subnet['Subnet']['id'])); ?>",
		success:function (html, textStatus) {
			$( ".stats" ).parent().append( html );
		}, 
	});
});
//]]>
</script>