<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$min_width = 0;

foreach ($test_columns_for_user as $key => $width)
{
	$min_width += $width ? $width : 300;
}

$header = array(
	'project' => $project,
	'report' => $report,
	'meta' => $report_obj->get_meta(),
	'min_width' => $min_width,
	'show_links' => $show_links,
	'css' => array(
		'styles/reset.css' => 'all',
		'styles/view.css' => 'all',
		'styles/print.css' => 'print'
	),
	'js' => array(
		'js/jquery.js',
		'js/fusioncharts.js',
		'js/fusioncharts.theme.fusion.js'
	)
);

$GI->load->view('report_plugins/layout/header', $header);
?>

<?php foreach ($runs as $run): ?>
	<?php tests::set_status_percents($run) ?>
<?php endforeach ?>

<?php $test_groupby_name = lang('reports_tpg_tests_groupby_unknown') ?>

<?php if ($test_groupby == 'cases:priority_id'): ?>
	<?php $test_groupby_name = lang('reports_tpg_tests_groupby_priority') ?>
<?php elseif ($test_groupby == 'cases:created_by'): ?>
	<?php $test_groupby_name = lang('reports_tpg_tests_groupby_createdby') ?>
<?php elseif ($test_groupby == 'cases:milestone_id'): ?>
	<?php $test_groupby_name = lang('reports_tpg_tests_groupby_milestone') ?>
<?php elseif ($test_groupby == 'cases:template_id'): ?>
	<?php $test_groupby_name = lang('reports_tpg_tests_groupby_template') ?>	
<?php elseif ($test_groupby == 'cases:type_id'): ?>
	<?php $test_groupby_name = lang('reports_tpg_tests_groupby_type') ?>	
<?php elseif ($test_groupby == 'tests:assignedto_id'): ?>
	<?php $test_groupby_name = lang('reports_tpg_tests_groupby_assignedto') ?>	
<?php elseif ($test_groupby == 'tests:tested_by'): ?>
	<?php $test_groupby_name = lang('reports_tpg_tests_groupby_testedby') ?>
<?php elseif ($test_groupby == 'tests:status_id'): ?>
	<?php $test_groupby_name = lang('reports_tpg_tests_groupby_status') ?>	
<?php elseif (str::starts_with($test_groupby, 'cases:custom')): ?>
	<?php $test_groupby_column = str::sub($test_groupby, 6) ?>
	<?php $case_field = arr::get($case_fields, $test_groupby_column) ?>
	<?php if ($case_field): ?>
		<?php $test_groupby_name = $case_field->label ?>
	<?php endif ?>
<?php endif ?>

<?php if ($show_summary): ?>
	<?php if ($test_groups): ?>
	<?php
	$temp = [];
	$temp['test_groups'] = $test_groups;
	$temp['test_groupby'] = $test_groupby;
	$temp['test_groupby_name'] = $test_groupby_name;
	$temp['report'] = $report;
	$report_obj->render_view('index/charts', $temp);
	?>

	<?php $test_count_total = 0 ?>
	<?php foreach ($test_groups as $group): ?>
		<?php $test_count_total += $group->test_count ?>
	<?php endforeach ?>

	<?php
	$temp = [];
	$temp['test_groups'] = $test_groups;
	$temp['test_count_total'] = $test_count_total;
	$temp['test_groupby'] = $test_groupby;
	$temp['test_groupby_name'] = $test_groupby_name;
	$report_obj->render_view('index/test_totals', $temp);
	?>
	<?php endif ?>
<?php endif ?>

<h1 class="<?php !$show_summary ? 'top' : '' ?>"><img class="right noPrint w16" src="%RESOURCE%:images/report-assets/help.svg" alt="" title="<?php echo  lang('reports_tpg_runs_header_info') ?>" /><?php echo  lang('reports_tpg_runs_header') ?></h1>

<?php if ($runs): ?>
	<?php
	$temp = [];
	$temp['runs'] = $runs;
	$temp['run_rels'] = $run_rels;
	$temp['run_count'] = $run_count;
	$temp['show_links'] = $show_links;
	$report_obj->render_view('index/runs', $temp);
	?>
<?php else: ?>
	<p><?php echo  lang('reports_tpg_runs_empty') ?></p>
<?php endif ?>

<?php if ($show_details): ?>
<h1><img class="right noPrint w16" src="%RESOURCE%:images/report-assets/help.svg" alt="" title="<?php echo  lang('reports_tpg_tests_header_info') ?>" /><?php echo  lang('reports_tpg_tests_header') ?></h1>

<?php if ($test_groups): ?>
	<?php $run_lookup = obj::get_lookup($runs) ?>
	<?php foreach ($test_groups as $group): ?>
		<?php $tests_for_runs = arr::get($tests, $group->id) ?>
		<?php if ($tests_for_runs): ?>
			<?php
			$temp = [];
			$temp['project'] = $project;
			$temp['group'] = $group;
			$temp['run_lookup'] = $run_lookup;
			$temp['tests'] = $tests_for_runs;
			$temp['test_groupby'] = $test_groupby;
			$temp['test_limit'] = $test_limit;
			$temp['test_fields'] = $test_fields;
			$temp['case_fields'] = $case_fields;
			$temp['test_columns'] = $test_columns;
			$temp['test_columns_for_user'] = $test_columns_for_user;
			$temp['test_count'] = $group->test_count;
			$temp['show_links'] = $show_links;
			$report_obj->render_view('index/test_group', $temp);
			?>
		<?php endif ?>
	<?php endforeach ?>
<?php else: ?>
	<p><?php echo  lang('reports_tpg_tests_empty') ?></p>
<?php endif ?>

<?php endif ?>

<?php
$temp = [];
$temp['report'] = $report;
$temp['meta'] = $report_obj->get_meta();
$temp['show_options'] = true;
$temp['show_report'] = true;
$GI->load->view('report_plugins/layout/footer', $temp);
?>
