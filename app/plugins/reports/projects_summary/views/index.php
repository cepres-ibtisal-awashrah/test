<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$min_width = 960;

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

<?php foreach ($runs_active as $run): ?>
	<?php tests::set_status_percents($run) ?>
<?php endforeach ?>
<?php foreach ($runs_completed as $run): ?>
	<?php tests::set_status_percents($run) ?>
<?php endforeach ?>

<?php $run_stats_active = obj::create() ?>
<?php if ($runs_active_include): ?>
	<?php foreach ($statuses as $status): ?>
		<?php $prop = $status->system_name . '_count' ?>
		<?php $run_stats_active->$prop = 0 ?>
		<?php foreach ($runs_active as $run): ?>
			<?php $run_stats_active->$prop += $run->$prop ?>
		<?php endforeach ?>
	<?php endforeach ?>
	<?php tests::set_status_percents($run_stats_active) ?>
<?php endif ?>

<?php foreach ($milestone_stats as $stats): ?>
	<?php tests::set_status_percents($stats) ?>
<?php endforeach ?>

<?php $milestone_stats_active = obj::create() ?>
<?php if ($milestones_active_include): ?>
	<?php foreach ($statuses as $status): ?>
		<?php $prop = $status->system_name . '_count' ?>
		<?php $milestone_stats_active->$prop = 0 ?>
		<?php foreach ($milestones_active as $milestone): ?>
			<?php $stats = arr::get($milestone_stats, $milestone->id) ?>
			<?php if ($stats): ?>
				<?php $milestone_stats_active->$prop += $stats->$prop ?>
			<?php endif ?>
		<?php endforeach ?>
	<?php endforeach ?>
	<?php tests::set_status_percents($milestone_stats_active) ?>
<?php endif ?>

<h1 class="main">
	<span><?php echo  langf('reports_ps_title', h($project->name))?></span>
</h1>

<?php if ($project->announcement && $project->show_announcement): ?>
	<div class="markdown" style="margin-top: 1.5em">
		<?php if ($show_links): ?>
		<?php echo  markdown::to_html($project->announcement) ?>
		<?php else: ?>
		<?php echo  markdown::to_html_nolinks($project->announcement) ?>
		<?php endif ?>
	</div>
<?php endif ?>

<?php if ($milestones_active_include || $milestones_completed_include): ?>
		
	<?php if ($milestones_active_include): ?>
		<h1><img class="right noPrint w16" src="%RESOURCE%:images/report-assets/help.svg" alt="" title="<?php echo  lang('reports_ps_milestones_info') ?>" /><?php echo  lang('reports_ps_milestones') ?></h1>
		<?php if ($milestones_active): ?>
			<?php
			$temp = [];
			$temp['stats'] = $milestone_stats_active;
			$temp['statuses'] = $statuses;
			$temp['chart_id'] = 'statusChart0';
			$temp['report'] = $report;
			$GI->load->view('report_plugins/charts/status', $temp);
			?>
			<div class="help top" style="margin-bottom: 1em">
				<img class="w16" src="%RESOURCE%:images/report-assets/help.svg" 
					alt="" />
				<p><?php echo  lang('reports_ps_milestones_stats') ?></p>
				<div style="clear: both"></div>
			</div>
			<h2><?php echo  lang('reports_ps_milestones_active') ?></h2>
			<?php
			$temp = [];
			$temp['milestones'] = $milestones_active;
			$temp['milestone_stats'] = $milestone_stats;
			$temp['group_by'] = 'due_on';
			$temp['show_percent'] = false;
			$temp['show_chart'] = true;
			$temp['show_links'] = $show_links;
			$GI->load->view('report_plugins/milestones/groups', $temp);
			?>
		<?php else: ?>
		<p><?php echo  lang('reports_ps_milestones_active_empty') ?></p>
		<?php endif ?>
	<?php endif ?>
	
	<?php if ($milestones_completed_include): ?>
		<h2><?php echo  lang('reports_ps_milestones_completed') ?></h2>
		<?php if ($milestones_completed): ?>
			<?php
			$temp = [];
			$temp['milestones'] = $milestones_completed;
			$temp['milestone_stats'] = $milestone_stats;
			$temp['group_by'] = 'completed_on';
			$temp['show_percent'] = false;
			$temp['show_chart'] = true;
			$temp['show_links'] = $show_links;
			$GI->load->view('report_plugins/milestones/groups', $temp);
			?>
			<?php $milestones_completed_count_partial = count($milestones_completed) ?>
			<?php if ($milestones_completed_count > $milestones_completed_count_partial): ?>
			<p class="partial">
				<?php echo  langf('reports_ps_milestones_more',
				$milestones_completed_count - 
				$milestones_completed_count_partial) ?>
			</p>
			<?php endif ?>
		<?php else: ?>
			<p><?php echo  lang('reports_ps_milestones_completed_empty') ?></p>
		<?php endif ?>
	<?php endif ?>	
<?php endif ?>

<?php if ($runs_active_include || $runs_completed_include): ?>
	<h1><img class="right noPrint w16" src="%RESOURCE%:images/report-assets/help.svg" alt="" title="<?php echo  lang('reports_ps_runs_info') ?>" /><?php echo  lang('reports_ps_runs') ?></h1>
	<?php if ($runs_active_include): ?>
		<?php if ($runs_active): ?>
			<?php
			$temp = [];
			$temp['stats'] = $run_stats_active;
			$temp['statuses'] = $statuses;
			$temp['chart_id'] = 'statusChart1';
			$temp['report'] = $report;
			$GI->load->view('report_plugins/charts/status', $temp);
			?>
			<div class="help top" style="margin-bottom: 1em">
				<img class="w16" src="%RESOURCE%:images/report-assets/help.svg" 
					alt="" />
				<p><?php echo  lang('reports_ps_runs_stats') ?></p>
				<div style="clear: both"></div>
			</div>
			<h2><?php echo  lang('reports_ps_runs_active') ?></h2>
			<?php
			$temp = [];
			$temp['runs'] = $runs_active;
			$temp['run_rels'] = $runs_active_rels;
			$temp['show_percent'] = false;
			$temp['show_chart'] = true;
			$temp['show_links'] = $show_links;
			$GI->load->view('report_plugins/runs/groups', $temp);
			?>
		<?php else: ?>
			<p><?php echo  lang('reports_ps_runs_active_empty') ?></p>
		<?php endif ?>
	<?php endif ?>
	<?php if ($runs_completed_include): ?>
		<h2><?php echo  lang('reports_ps_runs_completed') ?></h2>
		<?php if ($runs_completed): ?>
			<?php
			$temp = [];
			$temp['runs'] = $runs_completed;
			$temp['run_rels'] = $runs_completed_rels;
			$temp['show_percent'] = false;
			$temp['show_chart'] = true;
			$temp['show_links'] = $show_links;
			$GI->load->view('report_plugins/runs/groups', $temp);
			?>
			<?php $runs_completed_count_partial = count($runs_completed) ?>
			<?php if ($runs_completed_count > $runs_completed_count_partial): ?>
			<p class="partial">
				<?php echo  langf('reports_ps_runs_more',
				$runs_completed_count - 
				$runs_completed_count_partial) ?>
			</p>
			<?php endif ?>
		<?php else: ?>
			<p><?php echo  lang('reports_ps_runs_completed_empty') ?></p>
		<?php endif ?>
	<?php endif ?>
<?php endif ?>

<?php if ($history_include): ?>
	<h1><img class="right noPrint w16" src="%RESOURCE%:images/report-assets/help.svg" alt="" title="<?php echo  lang('reports_ps_history_info') ?>" /><?php echo  lang('reports_ps_history') ?></h1>
	<?php if ($history): ?>
		<?php
		$temp = [];
		$temp['history'] = $history;
		$temp['history_rels'] = $history_rels;
		$temp['show_links'] = $show_links;
		$report_obj->render_view('index/history', $temp);
		?>
		<?php if ($history_limit == count($history)): ?>
		<p class="partial">
		<?php echo  langf('reports_ps_history_more', $history_limit) ?>
		</p>
		<?php endif ?>
	<?php else: ?>
		<p><?php echo  lang('reports_ps_history_empty') ?></p>
	<?php endif ?>
<?php endif ?>

<?php if ($activities_include): ?>
	<h1><img class="right noPrint w16" src="%RESOURCE%:images/report-assets/help.svg" alt="" title="<?php echo  lang('reports_ps_activity_info') ?>" /><?php echo  lang('reports_ps_activity') ?></h1>
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
		<?php echo  langf('reports_ps_activity_more', $activities_limit) ?>
		</p>
		<?php endif ?>
	<?php else: ?>
	<p><?php echo  lang('reports_ps_activity_empty') ?></p>
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
