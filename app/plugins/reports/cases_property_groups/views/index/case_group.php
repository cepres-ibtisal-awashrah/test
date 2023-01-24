<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php $case_ids_combined = array() ?>
<?php foreach ($cases as $suite_id => $case_ids): ?>
	<?php arr::append($case_ids_combined, $case_ids) ?>
<?php endforeach ?>

<?php $case_lookup = obj::get_lookup(
	$report_helper->get_cases(
		$case_ids_combined,
		$case_fields,
		$case_assocs,
		$case_rels
	)
) ?>

<?php $show_suites = !isset($project->suite_mode) || 
	$project->suite_mode != TP_PROJECTS_SUITES_SINGLE ?>

<h2><?php echo h( $group->name )?></h2>

<?php foreach ($cases as $suite_id => $case_ids): ?>
	<?php $suite = arr::get($suite_lookup, $suite_id) ?>
	<?php if ($suite): ?>
		<?php if ($show_suites): ?>
		<h3>
		<?php if ($show_links): ?>
		<a target="_top" href="<?php echo  "%LINK%:/suites/view/$suite->id" ?>"><?php echo h( $suite->name )?></a>
		<?php else: ?>
		<?php echo h( $suite->name )?>
		<?php endif ?>
		<span class="secondary">(<?php echo  count($case_ids) ?>)</span>
		</h3>
		<?php endif ?>
		<?php
		$temp = array();
		$temp['project'] = $project;
		$temp['case_ids'] = $case_ids;
		$temp['case_lookup'] = $case_lookup;
		$temp['case_columns'] = $case_columns;
		$temp['case_columns_for_user'] = $case_columns_for_user;
		$temp['case_fields'] = $case_fields;
		$temp['case_assocs'] = $case_assocs;
		$temp['case_rels'] = $case_rels;
		$temp['show_links'] = $show_links;
		$GI->load->view('report_plugins/cases/grid', $temp);
		?>
	<?php endif ?>
<?php endforeach ?>

<?php $case_count_partial = count($case_ids_combined) ?>
<?php if ($case_count > $case_count_partial): ?>
	<p class="partial">
		<?php echo  langf('reports_cpg_cases_more',
		$case_count - 
		$case_count_partial) ?>
	</p>
<?php endif ?>
