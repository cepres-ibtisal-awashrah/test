<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$min_width = 300; // For Count columns

foreach ($case_columns_for_user as $key => $width)
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

<?php foreach ($runs as $run): ?>
	<?php tests::set_status_percents($run) ?>
<?php endforeach ?>

<?php
$temp = [];
$temp['statuses'] = $statuses;
$temp['status_totals'] = $status_totals;
$temp['report'] = $report;
$report_obj->render_view('index/charts', $temp);
?>

<h1 class="top"><img class="right noPrint w16" src="%RESOURCE%:images/report-assets/help.svg" alt="" title="<?php echo  lang('reports_cst_runs_header_info') ?>" /><?php echo  lang('reports_cst_runs_header') ?></h1>

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
	<p><?php echo  lang('reports_cst_runs_empty') ?></p>
<?php endif ?>

<h1><img class="right noPrint w16" src="%RESOURCE%:images/report-assets/help.svg" alt="" title="<?php echo  lang('reports_cst_statuses_header_info') ?>" /><?php echo  $results_include == TP_REPORT_PLUGINS_RESULTS_ALL ? lang('reports_cst_statuses_header') : lang('reports_cst_statuses_latest_header') ?></h1>

<?php foreach ($statuses as $status): ?>
<?php $top = arr::get($tops, $status->id) ?>
<?php if ($top): ?>
	<?php $items = $top['items'] ?>
	<h2><div style="margin-right: 5px; float: left; height: 16px; width: 16px; border-radius: 8px; <?php echo  tests::get_status_box_colors($status->color_dark) ?>"></div>
		<?php echo h( $status->label )?>
		<span class="secondary">(<?php echo  $top['case_count_partial'] ?>)</span>
	</h2>
	<?php
	$temp = [];
	$temp['project'] = $project;
	$temp['items'] = $items;
	$temp['case_fields'] = $case_fields;
	$temp['case_count'] = $top['case_count'];
	$temp['case_count_partial'] = $top['case_count_partial'];
	$temp['case_totals'] = $case_totals;
	$temp['case_columns'] = $case_columns;
	$temp['case_columns_for_user'] = $case_columns_for_user;
	$temp['status'] = $status;
	$temp['show_links'] = $show_links;
	$report_obj->render_view('index/tops', $temp);
	?>
<?php endif ?>
<?php endforeach ?>

<?php
$temp = [];
$temp['report'] = $report;
$temp['meta'] = $report_obj->get_meta();
$temp['show_options'] = true;
$temp['show_report'] = true;
$GI->load->view('report_plugins/layout/footer', $temp);
?>
