<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php $case_ids = array() ?>
<?php $case_ids_created_lookup = array() ?>
<?php $case_ids_updated_lookup = array() ?>
<?php if ($cases_created): ?>
	<?php $group = arr::get($cases_created->groups, $group_id) ?>
	<?php if ($group): ?>
		<?php $case_ids_created_lookup = arr::get_lookup($group->items) ?>
		<?php $case_ids = $group->items ?>
	<?php endif ?>
<?php endif ?>
<?php if ($cases_updated): ?>
	<?php $group = arr::get($cases_updated->groups, $group_id) ?>
	<?php if ($group): ?>
		<?php $case_ids_updated_lookup = arr::get_lookup($group->items) ?>
		<?php $case_ids = array_merge($case_ids, $group->items) ?>
	<?php endif ?>
<?php endif ?>
<?php if ($case_ids): ?>
	<?php $suite_outline = $report_helper->get_suite_outline(
		$group_id,
		$case_ids,
		null, // Fields not needed
		null, // Filters not needed,
		null, // No limit
		$case_count,
		$case_count_partial,
		$case_ids_out
	) ?>
	<?php $case_lookup = obj::get_lookup(
		$report_helper->get_cases(
			$case_ids_out,
			$case_fields,
			$case_assocs,
			$case_rels
		)
	) ?>	
	<?php
	$temp = array();
	$temp['project'] = $project;
	$temp['case_lookup'] = $case_lookup;
	$temp['case_assocs'] = $case_assocs;
	$temp['case_rels'] = $case_rels;
	$temp['case_fields'] = $case_fields;
	$temp['case_columns'] = $case_columns;
	$temp['case_columns_for_user'] = $case_columns_for_user;
	$temp['case_ids_created_lookup'] = $case_ids_created_lookup;
	$temp['case_ids_updated_lookup'] = $case_ids_updated_lookup;
	$temp['groups'] = $suite_outline;
	$temp['index'] = 1;
	$temp['chapter'] = '';
	$temp['show_links'] = $show_links;
	$report_obj->render_view('index/grids', $temp);
	?>
<?php endif ?>
