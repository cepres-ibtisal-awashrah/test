<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$min_width = 0;

foreach ($case_columns_for_user as $key => $width)
{
	$min_width += $width ? $width : 300;
}

$run_width = 150;

if ($show_comparison)
{
	foreach ($runs as $run)
	{
		$min_width += $run_width;
	}
}

if ($show_summary)
{
	$min_width += $run_width;
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
		'js/fusioncharts.theme.fusion.js'
	)
);

$GI->load->view('report_plugins/layout/header', $header);
?>

<?php $statuses = $GI->cache->get_objects('status') ?>
<?php $status_lookup = obj::get_lookup($statuses) ?>

<?php foreach ($runs as $run): ?>
	<?php $run->defect_count = 0 ?>
	<?php $defects_run = arr::get($defects, $run->id) ?>
	<?php if ($defects_run): ?>
		<?php foreach ($defects_run as $case_id => $items): ?>
			<?php $run->defect_count += count($items) ?>
		<?php endforeach ?>
	<?php endif ?>
	<?php tests::set_status_percents($run) ?>
<?php endforeach ?>

<?php $summary = obj::create() ?>
<?php if ($show_summary): ?>
	<?php $summary->defect_count = 0 ?>
	<?php foreach ($defects_summary as $case_id => $items): ?>
		<?php $summary->defect_count += count($items) ?>
	<?php endforeach ?>
<?php endif ?>

<?php $runs_reversed = array_reverse($runs) ?>

<?php if ($runs): ?>
	<?php
	$temp = [];
	$temp['summary'] = $summary;
	$temp['runs'] = $runs;
	$temp['runs_reversed'] = $runs_reversed;
	$temp['show_comparison'] = $show_comparison;
	$temp['show_summary'] = $show_summary;
	$temp['report'] = $report;
	$report_obj->render_view('index/charts', $temp);
	?>
<?php endif ?>

<h1 class="top"><img class="right noPrint w16" src="%RESOURCE%:images/report-assets/help.svg" alt="" title="<?php echo  lang('reports_cds_runs_header_info') ?>" /><?php echo  lang('reports_cds_runs_header') ?></h1>
<?php if ($runs): ?>
<div class="help" style="margin-bottom: 1em">
	<img class="w16" src="%RESOURCE%:images/report-assets/help.svg" 
		alt="" />
	<p><?php echo  lang('reports_cds_runs_help') ?></p>
	<div style="clear: both"></div>
</div>
<?php
$temp = [];
$temp['summary'] = $summary;
$temp['runs'] = $runs;
$temp['runs_reversed'] = $runs_reversed;
$temp['run_rels'] = $run_rels;
$temp['run_count'] = $run_count;
$temp['run_width'] = $run_width;
$temp['case_columns'] = $case_columns;
$temp['case_columns_for_user'] = $case_columns_for_user;
$temp['limit'] = $run_limit;
$temp['show_links'] = $show_links;
$temp['show_comparison'] = $show_comparison;
$temp['show_summary'] = $show_summary;
$report_obj->render_view('index/runs', $temp);
?>
<?php else: ?>
	<p><?php echo  lang('reports_cds_runs_empty') ?></p>
<?php endif ?>

<h1><img class="right noPrint w16" src="%RESOURCE%:images/report-assets/help.svg" alt="" title="<?php echo  lang('reports_cds_suite_header_info') ?>" /><?php echo  lang('reports_cds_suite_header') ?></h1>

<?php if ($suite && $suite_outline && $case_ids): ?>
<?php
$temp = [];
$temp['project'] = $project;
$temp['suite'] = $suite;
$temp['groups'] = $suite_outline;
$temp['case_ids'] = $case_ids;
$temp['case_fields'] = $case_fields;
$temp['case_columns'] = $case_columns;
$temp['case_columns_for_user'] = $case_columns_for_user;
$temp['case_count'] = $case_count;
$temp['case_count_partial'] = $case_count_partial;
$temp['runs'] = $runs;
$temp['run_rels'] = $run_rels;
$temp['run_width'] = $run_width;
$temp['runs_reversed'] = $runs_reversed;
$temp['defects'] = $defects;
$temp['defects_summary'] = $defects_summary;
$temp['results'] = $results;
$temp['results_latest'] = $results_latest;
$temp['limit'] = $case_limit;
$temp['show_links'] = $show_links;
$temp['show_comparison'] = $show_comparison;
$temp['show_summary'] = $show_summary;
$report_obj->render_view('index/suite', $temp);
?>
<?php else: ?>
	<p><?php echo  lang('reports_cds_suite_empty') ?></p>
<?php endif ?>

<?php
$temp = [];
$temp['report'] = $report;
$temp['meta'] = $report_obj->get_meta();
$temp['show_options'] = true;
$temp['show_report'] = true;
$GI->load->view('report_plugins/layout/footer', $temp);
?>
