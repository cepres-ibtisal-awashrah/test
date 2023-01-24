<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$min_width = 0;

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

<?php $is_single_run = !is_null($run) ?>

<?php if ($run): ?>
<h1 class="main">
	<span class="title">
		<?php echo  langf('reports_rs_title', h($run->name))?>
		<?php if ($run->config): ?>
			<span class="configuration" style="font-weight: normal; font-size: 14px">
			(<?php echo h( $run->config )?>)
			</span>
		<?php endif ?>
	</span>
</h1>
<?php endif ?>

<?php
$stats = obj::create();
$stats->passed_count = 0;
$stats->retest_count = 0;
$stats->failed_count = 0;
$stats->untested_count = 0;
$stats->blocked_count = 0;
$stats->custom_status1_count = 0;
$stats->custom_status2_count = 0;
$stats->custom_status3_count = 0;
$stats->custom_status4_count = 0;
$stats->custom_status5_count = 0;
$stats->custom_status6_count = 0;
$stats->custom_status7_count = 0;

foreach ($runs as $r)
{
	$stats->passed_count += $r->passed_count;
	$stats->retest_count += $r->retest_count;
	$stats->failed_count += $r->failed_count;
	$stats->untested_count += $r->untested_count;
	$stats->blocked_count += $r->blocked_count;
	$stats->custom_status1_count += $r->custom_status1_count;
	$stats->custom_status2_count += $r->custom_status2_count;
	$stats->custom_status3_count += $r->custom_status3_count;
	$stats->custom_status4_count += $r->custom_status4_count;
	$stats->custom_status5_count += $r->custom_status5_count;
	$stats->custom_status6_count += $r->custom_status6_count;
	$stats->custom_status7_count += $r->custom_status7_count;
	tests::set_status_percents($r);
}

tests::set_status_percents($stats);
?>

<?php if ($status_include): ?>
<?php
$temp = [];
$temp['stats'] = $stats;
$temp['report'] = $report;
$report_obj->render_view('index/charts/status', $temp);
?>
<?php endif ?>

<?php if ($run): ?>
	<?php if ($run->description): ?>
		<div class="markdown" style="<?php echo  !$status_include ? 'margin: 1.5em 0' : '' ?>">
			<?php if ($show_links): ?>
			<?php echo  markdown::to_html($run->description) ?>
			<?php else: ?>
			<?php echo  markdown::to_html_nolinks($run->description) ?>
			<?php endif ?>
		</div>
	<?php endif ?>
	<div style="margin: 1.5em 0">
	<?php
	$temp = [];
	$temp['run'] = $run;
	$temp['milestone'] = $milestone;
	$temp['show_links'] = $show_links;
	$report_obj->render_view('index/attributes', $temp);
	?>
	</div>
<?php endif ?>

<?php if (!$runs || count($runs) > 1): ?>
<h1 class="<?php echo  !$is_single_run ? 'top' : '' ?>"><img class="right noPrint w16" src="%RESOURCE%:images/report-assets/help.svg" alt="" title="<?php echo  lang('reports_rs_runs_info') ?>" /><?php echo  lang('reports_rs_runs') ?></h1>
	<?php if ($runs): ?>
		<?php
		$temp = [];
		$temp['runs'] = $runs;
		$temp['run_rels'] = $run_rels;
		$temp['show_links'] = $show_links;
		$GI->load->view('report_plugins/runs/groups', $temp);
		?>
	<?php else: ?>
		<p><?php echo  lang('reports_rs_runs_empty') ?></p>
	<?php endif ?>
<?php endif ?>

<?php if ($activities_include): ?>
	<h1><img class="right noPrint w16" src="%RESOURCE%:images/report-assets/help.svg" alt="" title="<?php echo  lang('reports_rs_activity_info') ?>" /><?php echo  lang('reports_rs_activity') ?></h1>
	<?php if ($activity): ?>
		<?php
		$temp = [];
		$temp['activity'] = $activity;
		$temp['from'] = $activities_from;
		$temp['to'] = $activities_to;
		$temp['report'] = $report;
		$GI->load->view('report_plugins/charts/activity', $temp);
		?>
	<?php endif ?>
	<?php if ($activities): ?>
		<?php
		$temp = [];
		$temp['activities'] = $activities;
		$temp['activities_rels'] = $activities_rels;
		$temp['show_links'] = $show_links;
		$GI->load->view('report_plugins/tests/activities', $temp);
		?>
		<?php if ($activities_limit == count($activities)): ?>
		<p class="partial">
		<?php echo  langf('reports_rs_activity_more', $activities_limit) ?>
		</p>
		<?php endif ?>
	<?php else: ?>
		<p class="top"><?php echo  lang('reports_rs_activity_empty') ?></p>
	<?php endif ?>
<?php endif ?>

<?php if ($progress_include && $progress): ?>
	<h1><img class="right noPrint w16" src="%RESOURCE%:images/report-assets/help.svg" alt="" title="<?php echo  lang('reports_rs_progress_info') ?>" /><?php echo  lang('reports_rs_progress') ?></h1>
	<?php if ($burndown): ?>
		<?php
		$temp = [];
		$temp['progress'] = $progress;
		$temp['burndown'] = $burndown;
		$temp['report'] = $report;
		$GI->load->view('report_plugins/charts/burndown', $temp);
		?>
	<?php endif ?>
	<h2 class="top"><?php echo  lang('reports_rs_progress_forecasts') ?></h2>
	<?php
	$temp = [];
	$temp['run'] = $run;
	$temp['created_on'] = $runs_created_on;
	$temp['is_completed'] = $runs_is_completed;
	$temp['completed_on'] = $runs_completed_on;
	$temp['progress'] = $progress;
	$report_obj->render_view('index/progress', $temp);	
	?>
	<?php if (count($runs) > 1): ?>
		<h2><?php echo  lang('reports_rs_progress_runs') ?></h2>
		<?php
		$temp = [];
		$temp['runs'] = $runs;
		$temp['show_links'] = $show_links;
		$report_obj->render_view('index/progress_runs', $temp);
		?>
	<?php endif ?>		
<?php endif ?>

<?php $has_tests = false ?>
<?php if ($tests_include && $runs): ?>
	<?php $test_limit_current = $test_limit ?>
	<?php $test_limit_reached = false ?>
	<h1><img class="right noPrint w16" src="%RESOURCE%:images/report-assets/help.svg" alt="" title="<?php echo  lang('reports_rs_tests_info') ?>" /><?php echo  lang('reports_rs_tests') ?></h1>
	<?php foreach ($runs as $r): ?>
		<?php $run_outline = $report_helper->get_run_outline(
			$r->id,
			$r->content_id,
			null, // No ID filter
			$fields,
			$test_filters,
			$test_limit_current,
			$test_count,
			$test_count_partial,
			$test_ids
		) ?>
		<?php if ($run_outline): ?>
			<?php $has_tests = true ?>
			<?php if (!$is_single_run): ?>
			<h2>
				<?php echo h( $r->name )?>
				<?php if ($r->config): ?>
				<span class="secondary configuration">(<?php echo h( $r->config )?>)</span>
				<?php endif ?>
			</h2>
			<?php endif ?>
			<?php
			$temp = [];
			$temp['project'] = $project;
			$temp['test_ids'] = $test_ids;
			$temp['test_fields'] = $test_fields;
			$temp['test_columns'] = $test_columns;
			$temp['test_columns_for_user'] = $test_columns_for_user;
			$temp['case_fields'] = $case_fields;
			$temp['outline'] = $run_outline;
			$temp['show_links'] = $show_links;
			$report_obj->render_view('index/run', $temp);
			?>
			<?php if ($test_limit): ?>			
				<?php $test_limit_current -= $test_count_partial ?>
				<?php if ($test_limit_current <= 0): ?>
					<?php $test_limit_reached = true ?>
					<?php break ?>
				<?php endif ?>
			<?php endif ?>
		<?php endif ?>
	<?php endforeach ?>
	<?php if ($test_limit_reached): ?>
	<p class="partial">
		<?php echo  langf('reports_rs_tests_more', $test_limit) ?>
	</p>
	<?php endif ?>
	<?php if (!$has_tests): ?>
		<p class="top"><?php echo  lang('reports_rs_tests_empty') ?></p>
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
