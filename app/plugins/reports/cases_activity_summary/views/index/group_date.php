<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php $case_ids = array() ?>
<?php if ($cases_created): ?>
	<?php $group = arr::get($cases_created->groups, $group_id) ?>
	<?php if ($group && $group->items): ?>
		<span class="statusBox" style="background: #2f7ed8"><?php echo  lang('reports_cas_cases_created') ?></span>
		<?php $case_ids = $group->items ?>
		<?php $case_lookup = obj::get_lookup(
			$report_helper->get_cases(
				$case_ids,
				$case_fields,
				$case_assocs,
				$case_rels
			)
		) ?>
		<div style="margin: 1.5em 0">
		<?php
		$temp = array();
		$temp['project'] = $project;
		$temp['case_ids'] = $case_ids;
		$temp['case_lookup'] = $case_lookup;
		$temp['case_assocs'] = $case_assocs;
		$temp['case_rels'] = $case_rels;
		$temp['case_fields'] = $case_fields;
		$temp['case_columns'] = $case_columns;
		$temp['case_columns_for_user'] = $case_columns_for_user;
		$temp['show_links'] = $show_links;
		$temp['show_change'] = false;
		$report_obj->render_view('index/grid', $temp);
		?>
		</div>
	<?php endif ?>
<?php endif ?>
<?php if ($cases_updated): ?>
	<?php $group = arr::get($cases_updated->groups, $group_id) ?>
	<?php if ($group && $group->items): ?>
		<span class="statusBox" style="background: #8bbc21"><?php echo  lang('reports_cas_cases_updated') ?></span>
		<?php $case_ids = $group->items ?>
		<?php $case_lookup = obj::get_lookup(
			$report_helper->get_cases(
				$case_ids,
				$case_fields,
				$case_assocs,
				$case_rels
			)
		) ?>
		<div style="margin-top: 1.5em">
		<?php
		$temp = array();
		$temp['project'] = $project;
		$temp['case_ids'] = $case_ids;
		$temp['case_lookup'] = $case_lookup;
		$temp['case_assocs'] = $case_assocs;
		$temp['case_rels'] = $case_rels;
		$temp['case_fields'] = $case_fields;
		$temp['case_columns'] = $case_columns;
		$temp['case_columns_for_user'] = $case_columns_for_user;
		$temp['show_links'] = $show_links;
		$temp['show_change'] = false;
		$report_obj->render_view('index/grid', $temp);
		?>
		</div>
	<?php endif ?>
<?php endif ?>