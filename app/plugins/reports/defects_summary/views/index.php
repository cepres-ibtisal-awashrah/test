<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$min_width = 125; // For Defects column

foreach ($test_columns_for_user as $key => $width)
{
	$min_width += $width ? $width : 300;
}

$min_width = max($min_width, 960);

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
		'js/fusioncharts.charts.js',
		'js/fusioncharts.theme.fusion.js',
	)
);

$GI->load->view('report_plugins/layout/header', $header);
?>

<?php $statuses = $GI->cache->get_objects('status') ?>
<?php $status_lookup = obj::get_lookup($statuses) ?>

<?php $defects_for_runs = [] ?>
<?php if ($defects): ?>
	<?php foreach ($defects->content as $defect_id => $test_ids): ?>
		<?php foreach ($test_ids as $test_id): ?>
			<?php $run_id = arr::get($runs_for_tests, $test_id) ?>
			<?php if ($run_id): ?>
				<?php $defects_for_runs[$run_id][$defect_id][] = $test_id ?>
			<?php endif ?>
		<?php endforeach ?>
	<?php endforeach ?>
<?php endif ?>

<?php foreach ($runs as $run): ?>
	<?php $run->defect_count = 0 ?>
	<?php foreach ($statuses as $status): ?>
		<?php $prop_count = $status->system_name . '_count' ?>
		<?php $run->$prop_count = 0 ?>
	<?php endforeach ?>
	<?php $results_run = arr::get($results, $run->id) ?>
	<?php if ($results_run): ?>
		<?php foreach ($results_run as $test_id => $status_id): ?>
			<?php $status = arr::get($status_lookup, $status_id) ?>
			<?php if ($status): ?>
				<?php $prop_count = $status->system_name . '_count' ?>
				<?php $run->$prop_count++ ?>
			<?php endif ?>
		<?php endforeach ?>
	<?php endif ?>
	<?php $defects_run = arr::get($defects_for_runs, $run->id) ?>
	<?php if ($defects_run): ?>
		<?php $run->defect_count = count($defects_run) ?>
	<?php endif ?>
	<?php tests::set_status_percents($run) ?>
<?php endforeach ?>

<?php $runs_reversed = array_reverse($runs) ?>

<?php if ($runs): ?>
<?php
$temp = [];
$temp['runs'] = $runs;
$temp['runs_reversed'] = $runs_reversed;
$temp['show_links'] = $show_links;
$temp['report'] = $report;
$report_obj->render_view('index/charts', $temp);
?>
<?php endif ?>

<h1 class="top"><img class="right noPrint w16" src="%RESOURCE%:images/report-assets/help.svg" alt="" title="<?php echo  lang('reports_ds_runs_header_info') ?>" /><?php echo  lang('reports_ds_runs_header') ?></h1>
<?php if ($runs): ?>
	<div class="help" style="margin-bottom: 1em">
		<img class="w16" src="%RESOURCE%:images/report-assets/help.svg" 
			alt="" />
		<p><?php echo  lang('reports_ds_runs_help') ?></p>
		<div style="clear: both"></div>
	</div>
	<?php
	$temp = [];
	$temp['runs'] = $runs;
	$temp['run_rels'] = $run_rels;
	$temp['run_count'] = $run_count;
	$temp['show_links'] = $show_links;
	$report_obj->render_view('index/runs', $temp);
	?>
<?php else: ?>
	<p><?php echo  lang('reports_ds_runs_empty') ?></p>
<?php endif ?>

<h1><img class="right noPrint w16" src="%RESOURCE%:images/report-assets/help.svg" alt="" title="<?php echo  lang('reports_ds_defects_header_info') ?>" /><?php echo  lang('reports_ds_defects_header') ?></h1>

<?php if ($defects && $defects->content): ?>
	<?php
	$temp = [];
	$temp['project'] = $project;
	$temp['defects'] = $defects;
	$temp['test_columns'] = $test_columns;
	$temp['test_columns_for_user'] = $test_columns_for_user;
	$temp['test_fields'] = $test_fields;
	$temp['case_fields'] = $case_fields;
	$temp['limit'] = $test_limit;
	$temp['show_links'] = $show_links;
	$report_obj->render_view('index/defects', $temp);
	?>
<?php else: ?>
	<p><?php echo  lang('reports_ds_defects_empty') ?></p>
<?php endif ?>

<?php
$temp = [];
$temp['report'] = $report;
$temp['meta'] = $report_obj->get_meta();
$temp['show_options'] = true;
$temp['show_report'] = true;
$GI->load->view('report_plugins/layout/footer', $temp);
?>
