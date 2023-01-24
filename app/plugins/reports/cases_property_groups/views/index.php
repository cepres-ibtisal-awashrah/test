<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$min_width = 0;

foreach ($case_columns_for_user as $key => $width)
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

<?php $case_groupby_name = lang('reports_cpg_cases_groupby_unknown') ?>

<?php if ($case_groupby == 'cases:priority_id'): ?>
	<?php $case_groupby_name = lang('reports_cpg_cases_groupby_priority') ?>
<?php elseif ($case_groupby == 'cases:created_by'): ?>
	<?php $case_groupby_name = lang('reports_cpg_cases_groupby_createdby') ?>
<?php elseif ($case_groupby == 'cases:milestone_id'): ?>
	<?php $case_groupby_name = lang('reports_cpg_cases_groupby_milestone') ?>
<?php elseif ($case_groupby == 'cases:template_id'): ?>
	<?php $case_groupby_name = lang('reports_cpg_cases_groupby_template') ?>	
<?php elseif ($case_groupby == 'cases:type_id'): ?>
	<?php $case_groupby_name = lang('reports_cpg_cases_groupby_type') ?>	
<?php elseif (str::starts_with($case_groupby, 'cases:custom')): ?>
	<?php $case_groupby_column = str::sub($case_groupby, 6) ?>
	<?php $case_field = arr::get($case_fields, $case_groupby_column) ?>
	<?php if ($case_field): ?>
		<?php $case_groupby_name = $case_field->label ?>
	<?php endif ?>
<?php endif ?>

<?php if ($show_summary): ?>
	<?php if ($case_groups): ?>
	<?php
	$temp = [];
	$temp['case_groups'] = $case_groups;
	$temp['case_groupby_name'] = $case_groupby_name;
	$temp['report'] = $report;
	$report_obj->render_view('index/charts', $temp);
	?>

	<?php $case_count_total = 0 ?>
	<?php foreach ($case_groups as $group): ?>
		<?php $case_count_total += $group->case_count ?>
	<?php endforeach ?>

	<?php
	$temp = [];
	$temp['case_groups'] = $case_groups;
	$temp['case_count_total'] = $case_count_total;
	$temp['case_groupby_name'] = $case_groupby_name;
	$report_obj->render_view('index/case_totals', $temp);
	?>
	<?php endif ?>
<?php endif ?>

<?php $show_suites = !isset($project->suite_mode) || 
	$project->suite_mode != TP_PROJECTS_SUITES_SINGLE ?>

<?php if ($show_suites): ?>
	<h1 class="<?php !$show_summary ? 'top' : '' ?>"><img class="right noPrint w16" src="%RESOURCE%:images/report-assets/help.svg" alt="" title="<?php echo  lang('reports_cpg_suites_header_info') ?>" /><?php echo  lang('reports_cpg_suites_header') ?></h1>
	<?php if ($suites): ?>
		<?php
		$temp = [];
		$temp['suites'] = $suites;
		$temp['show_links'] = $show_links;
		$GI->load->view('report_plugins/suites/list', $temp);
		?>
	<?php else: ?>
		<p><?php echo  lang('reports_cpg_suites_empty') ?></p>
	<?php endif ?>
<?php endif ?>

<?php if ($show_details): ?>
<h1><img class="right noPrint w16" src="%RESOURCE%:images/report-assets/help.svg" alt="" title="<?php echo  lang('reports_cpg_cases_header_info') ?>" /><?php echo  lang('reports_cpg_cases_header') ?></h1>

<?php if ($case_groups): ?>
	<?php $suite_lookup = obj::get_lookup($suites) ?>
	<?php foreach ($case_groups as $group): ?>
		<?php $cases_for_suite = arr::get($cases, $group->id) ?>
		<?php if ($cases_for_suite): ?>
			<?php
			$temp = [];
			$temp['project'] = $project;
			$temp['group'] = $group;
			$temp['suite_lookup'] = $suite_lookup;
			$temp['cases'] = $cases_for_suite;
			$temp['case_limit'] = $case_limit;
			$temp['case_fields'] = $case_fields;
			$temp['case_columns'] = $case_columns;
			$temp['case_columns_for_user'] = $case_columns_for_user;
			$temp['case_count'] = $group->case_count;
			$temp['show_links'] = $show_links;
			$report_obj->render_view('index/case_group', $temp);
			?>
		<?php endif ?>
	<?php endforeach ?>
<?php else: ?>
	<p><?php echo  lang('reports_cpg_cases_empty') ?></p>
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

