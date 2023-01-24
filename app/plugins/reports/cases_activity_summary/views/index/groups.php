<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php $show_suites = !isset($project->suite_mode) || 
	$project->suite_mode != TP_PROJECTS_SUITES_SINGLE ?>

<?php $is_created_limited = false ?>
<?php $is_updated_limited = false ?>
<?php foreach ($case_groups as $group_id => $group_name): ?>
	<?php $has_changes = false ?>
	<?php if (!$is_created_limited && $cases_created): ?>
		<?php $group = arr::get($cases_created->groups, $group_id) ?>
		<?php if ($group && $group->items): ?>
			<?php $has_changes = true ?>
		<?php endif ?>
	<?php endif ?>
	<?php if (!$is_updated_limited && $cases_updated): ?>
		<?php $group = arr::get($cases_updated->groups, $group_id) ?>
		<?php if ($group && $group->items): ?>
			<?php $has_changes = true ?>
		<?php endif ?>
	<?php endif ?>
	<?php if (!$has_changes): ?>
		<?php continue ?>
	<?php endif ?>
	<?php if ($case_groupby != 'suite' || $show_suites): ?>
	<h2><?php echo h( $group_name )?></h2>
	<?php endif ?>
	<?php
	$temp = array();
	$temp['project'] = $project;
	$temp['group_id'] = $group_id;
	$temp['case_groupby'] = $case_groupby;
	$temp['case_groups'] = $case_groups;
	$temp['case_fields'] = $case_fields;
	$temp['case_columns'] = $case_columns;
	$temp['case_columns_for_user'] = $case_columns_for_user;
	$temp['cases_created'] = $cases_created;
	$temp['cases_updated'] = $cases_updated;
	$temp['show_links'] = $show_links;
	?>
	<?php if ($case_groupby == 'day' || $case_groupby == 'month'): ?>
		<?php $report_obj->render_view('index/group_date', $temp) ?>
	<?php else: ?>
		<?php $report_obj->render_view('index/group_suite', $temp) ?>
	<?php endif ?>
	<?php if (!$is_created_limited && $cases_created): ?>
		<?php $group = arr::get($cases_created->groups, $group_id) ?>
		<?php if ($group && $group->is_limited): ?>
			<?php $is_created_limited = true ?>
			<?php if ($cases_created->case_count > $cases_created->case_count_partial): ?>
				<p class="partial">
					<?php echo  langf('reports_cas_cases_more_created',
					$cases_created->case_count - 
					$cases_created->case_count_partial) ?>
				</p>
			<?php endif ?>
		<?php endif ?>
	<?php endif ?>
	<?php if (!$is_updated_limited && $cases_updated): ?>
		<?php $group = arr::get($cases_updated->groups, $group_id) ?>
		<?php if ($group && $group->is_limited): ?>
			<?php $is_updated_limited = true ?>
			<?php if ($cases_updated->case_count > $cases_updated->case_count_partial): ?>
				<p class="partial">
					<?php echo  langf('reports_cas_cases_more_updated',
					$cases_updated->case_count - 
					$cases_updated->case_count_partial) ?>
				</p>
			<?php endif ?>
		<?php endif ?>
	<?php endif ?>
	<?php if ($is_created_limited && $is_updated_limited): ?>
		<?php break ?>
	<?php endif ?>
<?php endforeach ?>
