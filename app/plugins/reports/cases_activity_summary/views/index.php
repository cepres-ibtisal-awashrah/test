<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$min_width = 0;

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
		'js/fusioncharts.theme.fusion.js'
	)
);

$GI->load->view('report_plugins/layout/header', $header);
?>

<?php $has_changes = false ?>
<?php if ($cases_created && $cases_created->case_count > 0): ?>
	<?php $has_changes = true ?>
<?php else: ?>
	<?php if ($cases_updated && $cases_updated->case_count > 0): ?>
		<?php $has_changes = true ?>
	<?php endif ?>
<?php endif ?>

<?php $case_groupby_name = lang('reports_cas_cases_groupby_unknown') ?>

<?php if ($case_groupby == 'day'): ?>
	<?php $case_groupby_name = lang('reports_cas_cases_groupby_day') ?>
<?php elseif ($case_groupby == 'month'): ?>
	<?php $case_groupby_name = lang('reports_cas_cases_groupby_month') ?>
<?php elseif ($case_groupby == 'suite'): ?>
	<?php if ($project->suite_mode == TP_PROJECTS_SUITES_SINGLE): ?>
		<?php $case_groupby_name = lang('reports_cas_cases_groupby_cases') ?>
	<?php else: ?>
		<?php $case_groupby_name = lang('reports_cas_cases_groupby_suite') ?>
	<?php endif ?>
<?php endif ?>

<?php $case_groups = [] ?>
<?php if ($cases_created): ?>
	<?php foreach ($cases_created->groups as $group): ?>
		<?php $case_groups[$group->id] = $group->name ?>
	<?php endforeach ?>
<?php endif ?>
<?php if ($cases_updated): ?>
	<?php foreach ($cases_updated->groups as $group): ?>
		<?php $case_groups[$group->id] = $group->name ?>
	<?php endforeach ?>
<?php endif ?>

<?php if ($case_groupby == 'day' || $case_groupby == 'month'): ?>
	<?php krsort($case_groups) ?>
<?php else: ?>
	<?php asort($case_groups) ?>
<?php endif ?>

<?php $show_suites = !isset($project->suite_mode) || 
	$project->suite_mode != TP_PROJECTS_SUITES_SINGLE ?>

<?php if ($case_groupby == 'suite' && !$show_suites): ?>
	<?php if (isset($case_groups[$project->master_id])): ?>
		<?php $case_groups[$project->master_id] = 
			lang('reports_cas_cases_changes') ?>
	<?php endif ?>
<?php endif ?>

<?php if ($has_changes): ?>
	<?php
	$temp = [];
	$temp['case_groupby'] = $case_groupby;
	$temp['case_groupby_name'] = $case_groupby_name;
	$temp['case_groups'] = $case_groups;
	$temp['cases_created'] = $cases_created;
	$temp['cases_updated'] = $cases_updated;
	$temp['changes_from'] = $changes_from;
	$temp['changes_to'] = $changes_to;
	$temp['show_new'] = $show_new;
	$temp['show_updated'] = $show_updated;
	$temp['report'] = $report;
	$report_obj->render_view('index/charts', $temp);
	?>
	<?php if ($case_groupby != 'suite' || $show_suites): ?>
		<?php
		$temp = [];
		$temp['case_groupby'] = $case_groupby;
		$temp['case_groupby_name'] = $case_groupby_name;
		$temp['case_groups'] = $case_groups;
		$temp['cases_created'] = $cases_created;
		$temp['cases_updated'] = $cases_updated;
		$temp['show_new'] = $show_new;
		$temp['show_updated'] = $show_updated;
		$report_obj->render_view('index/case_totals', $temp);
		?>
	<?php endif ?>
<?php endif ?>

<?php if ($show_suites): ?>
	<h1 class=""><img class="right noPrint w16" src="%RESOURCE%:images/report-assets/help.svg"  
		alt="" title="<?php echo  lang('reports_cas_suites_header_info') ?>" /><?php echo  lang('reports_cas_suites_header') ?></h1>
	<?php if ($suites): ?>
		<?php
		$temp = [];
		$temp['suites'] = $suites;
		$temp['show_links'] = $show_links;
		$GI->load->view('report_plugins/suites/list', $temp);
		?>
	<?php else: ?>
		<p><?php echo  lang('reports_cas_suites_empty') ?></p>
	<?php endif ?>
<?php endif ?>

<?php $show_totals = $case_groupby != 'suite' || $show_suites ?>
<?php $top = false ?>
<?php if ($has_changes && !$show_totals): ?>
	<?php $top = true ?>
<?php endif ?>

<h1 class="<?php echo  $top ? 'top' : '' ?>"><img class="right noPrint w16" src="%RESOURCE%:images/report-assets/help.svg" 
	alt="" title="<?php echo  lang('reports_cas_changes_header_info') ?>" /><?php echo  lang('reports_cas_changes_header') ?></h1>

<?php if ($has_changes): ?>
	<?php
	$temp = [];
	$temp['project'] = $project;
	$temp['case_columns'] = $case_columns;
	$temp['case_columns_for_user'] = $case_columns_for_user;
	$temp['case_fields'] = $case_fields;
	$temp['case_groupby'] = $case_groupby;
	$temp['case_groups'] = $case_groups;
	$temp['cases_created'] = $cases_created;
	$temp['cases_updated'] = $cases_updated;
	$temp['show_links'] = $show_links;
	$report_obj->render_view('index/groups', $temp);
	?>
<?php else: ?>
	<p><?php echo  lang('reports_cas_cases_empty') ?></p>
<?php endif ?>

<?php
$temp = [];
$temp['report'] = $report;
$temp['meta'] = $report_obj->get_meta();
$temp['show_options'] = true;
$temp['show_report'] = true;
$GI->load->view('report_plugins/layout/footer', $temp);
?>
