<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$status_width = 100;
$min_width = $status_width; // For Status column

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
		'js/fusioncharts.charts.js',
		'js/fusioncharts.theme.fusion.js',
	)
);

$GI->load->view('report_plugins/layout/header', $header);
?>

<?php $has_todos = false ?>
<?php foreach ($user_todos as $user_id => $todos): ?>
	<?php if ($todos->todo_count > 0): ?>
		<?php $has_todos = true ?>
	<?php endif ?>
<?php endforeach ?>

<?php foreach ($runs as $run): ?>
	<?php tests::set_status_percents($run) ?>
<?php endforeach ?>

<?php $run_lookup = obj::get_lookup($runs) ?>

<?php if ($show_summary): ?>
	<?php if ($has_todos): ?>
		<?php
		$temp = [];
		$temp['users'] = $users;
		$temp['user_todos'] = $user_todos;
		$temp['user_estimates'] = $user_estimates;
		$temp['has_todos'] = $has_todos;
		$temp['report'] = $report;
		$report_obj->render_view('index/charts', $temp);
		?>
	<?php endif ?>
	<?php
	$temp = [];
	$temp['users'] = $users;
	$temp['user_todos'] = $user_todos;
	$temp['user_estimates'] = $user_estimates;
	$report_obj->render_view('index/user_totals', $temp);
	?>
<?php endif ?>

<h1 class="<?php !$show_summary ? 'top' : '' ?>"><img class="right noPrint w16" src="%RESOURCE%:images/report-assets/help.svg" alt="" title="<?php echo  lang('reports_uws_runs_header_info') ?>" /><?php echo  lang('reports_uws_runs_header') ?></h1>

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
	<p><?php echo  lang('reports_uws_runs_empty') ?></p>
<?php endif ?>

<?php if ($show_details): ?>
<h1><img class="right noPrint w16" src="%RESOURCE%:images/report-assets/help.svg" alt="" title="<?php echo  lang('reports_uws_users_header_info') ?>" /><?php echo  lang('reports_uws_users_header') ?></h1>

<?php if ($has_todos): ?>
	<?php
	$temp = [];
	$temp['project'] = $project;
	$temp['runs'] = $runs;
	$temp['run_lookup'] = $run_lookup;
	$temp['users'] = $users;
	$temp['user_todos'] = $user_todos;
	$temp['user_estimates'] = $user_estimates;
	$temp['test_columns'] = $test_columns;
	$temp['test_columns_for_user'] = $test_columns_for_user;
	$temp['test_fields'] = $test_fields;
	$temp['case_fields'] = $case_fields;
	$temp['show_links'] = $show_links;
	$report_obj->render_view('index/user_todos', $temp);
	?>
<?php else: ?>
	<p><?php echo  lang('reports_uws_users_empty') ?></p>
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
