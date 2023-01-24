<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php $test_lookup = obj::get_lookup(
	$report_helper->get_tests(
		$test_ids,
		$case_fields,
		$test_fields,
		$case_assocs,
		$case_rels,
		$test_assocs,
		$result_assocs
	)
) ?>

<h3>
<?php if ($show_links): ?>
<a target="_top" href="<?php echo  "%LINK%:/runs/view/$run->id" ?>"><?php echo h( $run->name )?></a>
<?php else: ?>
<?php echo h( $run->name )?>
<?php endif ?>
<?php if ($run->config): ?>
 <span class="configuration">(<?php echo h( $run->config )?>)</span>
<?php endif ?>
<span class="secondary">(<?php echo  count($test_ids) ?>)</span>
</h3>
<?php
$temp = array();
$temp['project'] = $project;
$temp['test_ids'] = $test_ids;
$temp['test_lookup'] = $test_lookup;
$temp['test_columns'] = $test_columns;
$temp['test_columns_for_user'] = $test_columns_for_user;
$temp['test_fields'] = $test_fields;
$temp['case_fields'] = $case_fields;
$temp['test_assocs'] = $test_assocs;
$temp['case_assocs'] = $case_assocs;
$temp['case_rels'] = $case_rels;
$temp['result_assocs'] = $result_assocs;
$temp['show_links'] = $show_links;
$GI->load->view('report_plugins/tests/grid', $temp);
?>
