<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$reference_width = 125;
$min_width = $reference_width; // For References column

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

if ($show_coverage)
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
		'js/fusioncharts.charts.js',
		'js/fusioncharts.theme.fusion.js',
	)
);

$GI->load->view('report_plugins/layout/header', $header);
?>

<?php $statuses = $GI->cache->get_objects('status') ?>
<?php $status_lookup = obj::get_lookup($statuses) ?>

<?php foreach ($runs as $run): ?>
	<?php foreach ($statuses as $status): ?>
		<?php $prop_count = $status->system_name . '_count' ?>
		<?php $run->$prop_count = 0 ?>
	<?php endforeach ?>
	<?php $results_run = arr::get($results, $run->id) ?>
	<?php if ($results_run): ?>
		<?php foreach ($results_run as $case_id => $result): ?>
			<?php $status = arr::get($status_lookup, $result->status_id) ?>
			<?php if ($status): ?>
				<?php $prop_count = $status->system_name . '_count' ?>
				<?php $run->$prop_count++ ?>
			<?php endif ?>
		<?php endforeach ?>
	<?php endif ?>
	<?php tests::set_status_percents($run) ?>
<?php endforeach ?>

<?php $coverage = obj::create() ?>
<?php if ($show_coverage): ?>
	<?php foreach ($statuses as $status): ?>
		<?php $prop_count = $status->system_name . '_count' ?>
		<?php $coverage->$prop_count = 0 ?>
	<?php endforeach ?>
	<?php foreach ($results_latest as $case_id => $result): ?>
		<?php $status = arr::get($status_lookup, $result->status_id) ?>
		<?php if ($status): ?>
			<?php $prop_count = $status->system_name . '_count' ?>
			<?php $coverage->$prop_count++ ?>
		<?php endif ?>
	<?php endforeach ?>
	<?php tests::set_status_percents($coverage) ?>
<?php endif ?>

<?php $runs_reversed = array_reverse($runs) ?>

<?php
$temp = [];
$temp['coverage'] = $coverage;
$temp['references'] = $references;
$temp['runs'] = $runs;
$temp['runs_reversed'] = $runs_reversed;
$temp['show_comparison'] = $show_comparison;
$temp['show_coverage'] = $show_coverage;
$temp['report'] = $report;
$report_obj->render_view('index/charts', $temp);
?>

<h1 class="top"><img class="right noPrint w16" src="%RESOURCE%:images/report-assets/help.svg" alt="" title="<?php echo  lang('reports_rrc_runs_header_info') ?>" /><?php echo  lang('reports_rrc_runs_header') ?></h1>

<?php if ($runs): ?>
<div class="help" style="margin-bottom: 1em">
	<img class="w16" src="%RESOURCE%:images/report-assets/help.svg" 
		alt="" />
	<p><?php echo  lang('reports_rrc_runs_help') ?></p>
	<div style="clear: both"></div>
</div>

<?php
$temp = [];
$temp['coverage'] = $coverage;
$temp['reference_width'] = $reference_width;
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
$temp['show_coverage'] = $show_coverage;
$report_obj->render_view('index/runs', $temp);
?>
<?php else: ?>
	<p><?php echo  lang('reports_rrc_runs_empty') ?></p>
<?php endif ?>

<h1><img class="right noPrint w16" src="%RESOURCE%:images/report-assets/help.svg" alt="" title="<?php echo  lang('reports_rrc_ref_header_info') ?>" /><?php echo  lang('reports_rrc_ref_header') ?></h1>

<?php if ($references && $references->reference_count > 0): ?>
	<?php
	$temp = [];
	$temp['project'] = $project;
	$temp['references'] = $references;
	$temp['reference_width'] = $reference_width;
	$temp['case_columns'] = $case_columns;
	$temp['case_columns_for_user'] = $case_columns_for_user;
	$temp['case_fields'] = $case_fields;
	$temp['case_limit'] = $case_limit;
	$temp['coverage'] = $coverage;
	$temp['runs'] = $runs;
	$temp['runs_reversed'] = $runs_reversed;
	$temp['run_width'] = $run_width;
	$temp['results'] = $results;
	$temp['results_latest'] = $results_latest;
	$temp['show_comparison'] = $show_comparison;
	$temp['show_coverage'] = $show_coverage;
	$temp['show_links'] = $show_links;
	$report_obj->render_view('index/references', $temp);
	?>
<?php else: ?>
	<p><?php echo  lang('reports_rrc_ref_empty') ?></p>
<?php endif ?>

<?php
$temp = [];
$temp['report'] = $report;
$temp['meta'] = $report_obj->get_meta();
$temp['show_options'] = true;
$temp['show_report'] = true;
$GI->load->view('report_plugins/layout/footer', $temp);
?>
