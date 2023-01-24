<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php $case_lookup = obj::get_lookup(
	$report_helper->get_cases(
		$case_ids,
		$case_fields,
		$case_assocs,
		$case_rels
	)
) ?>

<?php $show_suites = !isset($project->suite_mode) || 
	$project->suite_mode != TP_PROJECTS_SUITES_SINGLE ?>

<?php if ($show_suites): ?>
<h2><?php echo h( $suite->name )?></h2>
<?php endif ?>

<?php
$temp = array();
$temp['project'] = $project;
$temp['case_lookup'] = $case_lookup;
$temp['case_assocs'] = $case_assocs;
$temp['case_rels'] = $case_rels;
$temp['case_fields'] = $case_fields;
$temp['case_columns'] = $case_columns;
$temp['case_columns_for_user'] = $case_columns_for_user;
$temp['runs'] = $runs;
$temp['runs_reversed'] = $runs_reversed;
$temp['run_width'] = $run_width;
$temp['defects'] = $defects;
$temp['defects_summary'] = $defects_summary;
$temp['results'] = $results;
$temp['results_latest'] = $results_latest;
$temp['groups'] = $groups;
$temp['index'] = 1;
$temp['chapter'] = '';
$temp['show_links'] = $show_links;
$temp['show_comparison'] = $show_comparison;
$temp['show_summary'] = $show_summary;
$report_obj->render_view('index/groups', $temp);
?>

<?php if ($case_count > $case_count_partial): ?>
	<p class="partial">
		<?php echo  langf('reports_cds_suite_more_cases',
		$case_count - 
		$case_count_partial) ?>
	</p>
<?php endif ?>
