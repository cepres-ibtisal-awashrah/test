<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php $project = projects::get_current() ?>
<?php
// Execute the deferred queries and group the case/test assocs by the
// cases/tests for easy and fast lookup
$case_assocs = group::by_id($case_assocs->result(), 'case_id');
$test_assocs = group::by_id($test_assocs->result(), 'test_id');
?>
<?php $layout_results = $layout == TP_EXPORT_CSV_LAYOUT_RESULTS ?>
<?php $section_hierarchies = array() ?>
<?php $section = $sections->peek() ?>
<?php while ($section): ?>
<?php $section_lookup[$section->id] = $section ?>
<?php $sections->next() ?>
<?php $test = $tests->peek() ?>
<?php while ($test && $test->section_id == $section->id): ?>
<?php $tests->next() ?>
<?php $current_case_assocs = array() ?>
<?php if (isset($case_assocs[$test->content_id])): ?>
<?php $current_case_assocs = group::by_id_scalar(
	$case_assocs[$test->content_id]->items,
	'name',
	'value') ?>
<?php foreach ($current_case_assocs as $key => $value): ?>
<?php $test->$key = $value ?>
<?php endforeach ?>
<?php endif ?>
<?php $current_test_assocs = array() ?>
<?php if (isset($test_assocs[$test->id])): ?>
<?php $current_test_assocs = group::by_id(
	$test_assocs[$test->id]->items,
	'test_change_id'
) ?>
<?php endif ?>
<?php
$current_test_changes = array();

$change = $test_changes->peek();
while ($change && $change->test_id == $test->id)
{
	$test_changes->next();
	$current_test_changes[] = $change;
	$change = $test_changes->peek();
}

$case = $cases[$test->case_id]->items[0];
$status = null;
$assignee = null;
global $is_enterprise;
if ($is_enterprise) {
	if (
		$case->status_id &&
		cases::is_approval_enabled($project)
	) {
		$status = $GI->cache->get_object(
			'case_status',
			$case->status_id
		);
	}

	if ($case->assigned_to_id) {
		$assignee = $GI->cache->get_object(
			'user',
			$case->assigned_to_id
		);
	}
}

$milestone = null;
if ($test->milestone_id)
{
	$milestone = arr::get($milestone_lookup, $test->milestone_id);
}
?>
<?php $row_count = $layout_results ? max(1, count($current_test_changes)) : 1 ?>
<?php for ($i = 0; $i < $row_count; $i++): ?>
<?php $values = array() ?>
<?php $change = arr::get($current_test_changes, $i) ?>
<?php if ($change): ?>
<?php if (isset($current_test_assocs[$change->id])): ?>
<?php $current_test_assocs_for_change = group::by_id_scalar(
	$current_test_assocs[$change->id]->items,
	'name',
	'value') ?>
<?php foreach ($current_test_assocs_for_change as $key => $value): ?>
<?php $change->$key = $value ?>
<?php endforeach ?>
<?php endif ?>
<?php endif ?>
<?php
	$index = 0;
	$arrayValues = [];
?>
<?php foreach ($columns as $column): ?>
<?php if (!isset($fields_csv[$column])): ?>
<?php continue ?>
<?php endif ?>
<?php
$value = null;
$is_encoded = false;
$is_case_field = str::starts_with($column, 'cases:');

switch ($column)
{
	case 'tests:id':
		$value = entities::test_id($test->id);
		break;

	case 'cases:title':
		$value = $test->title;
		break;

	case 'cases:template_id':
		$value = $GI->cache->get_scalar(
			'template',
			$test->template_id,
			'name',
			''
		);
		break;

	case 'cases:type_id':
		$value = $GI->cache->get_scalar(
			'case_type',
			$test->type_id,
			'name',
			''
		);
		break;

	case 'cases:priority_id':
		$value = $GI->cache->get_scalar(
			'priority',
			$test->priority_id,
			'name',
			''
		);
		break;

	case 'cases:milestone_id':
		if (fields::has_for_cases_and_template($project->id, $test->template_id, 'milestone_id'))
		{
			if ($milestone)
			{
				$value = $milestone->name;
			}
		}
		break;

	case 'cases:estimate':
		if (fields::has_for_cases_and_template($project->id, $test->template_id, 'estimate'))
		{
			if ($test->estimate)
			{
				$value = $test->estimate . 's';
			}
		}
		break;

	case 'cases:estimate_forecast':
		if (fields::has_for_cases_and_template($project->id, $test->template_id, 'estimate'))
		{
			if ($test->estimate_forecast)
			{
				$value = $test->estimate_forecast . 's';
			}
		}
		break;

	case 'cases:refs':
		if (fields::has_for_cases_and_template($project->id, $test->template_id, 'refs'))
		{
			if ($test->refs)
			{
				$value = references::format_nolinks($test->refs);
			}
		}
		break;

	case 'cases:section_id':
		$value = $section->name;
		break;

	case 'cases:section_full':
		// Compute the full section name (as in Section1 > Section 2)
		// on demand and cache the result afterwards.
		$value = arr::get($section_hierarchies, $section->id);
		if (!$value)
		{
			$value = sections::get_name_hierarchy(
				$section,
				$section_lookup,
				$section_hierarchies
			);
		}
		break;

	case 'cases:section_depth':
		$value = $section->depth;
		break;

	case 'cases:section_desc':
		$value = $section->description;
		break;

	case 'cases:status_id':
		if ($status) {
			$value = $status->name;
		}

		break;
	case 'cases:assigned_to_id':
		if ($assignee) {
			$value = $assignee->name;
		}

		break;

	case 'tests:assignedto_id':
		if ($test->assignedto_id)
		{
			$value = $GI->cache->get_scalar(
				'user',
				$test->assignedto_id,
				'name',
				''
			);
		}
		break;

	case 'tests:status_id':
		$status_id = null;
		if ($layout_results && $change)
		{
			$status_id = $change->status_id;
		}
		else
		{
			$status_id = $test->status_id;
		}

		if ($status_id)
		{
			$value = $GI->cache->get_scalar(
				'status',
				$status_id,
				'label',
				''
			);
		}
		break;

	case 'tests:defects':
		if (fields::has_for_tests_and_template($project->id, $test->template_id, 'defects'))
		{
			if ($change && $change->defects)
			{
				$value = defects::format_nolinks($change->defects);
			}
		}
		break;

	case 'tests:elapsed':
		if (fields::has_for_tests_and_template($project->id, $test->template_id, 'elapsed'))
		{
			if ($change && $change->elapsed)
			{
				$value = $change->elapsed . 's';
			}
		}
		break;

	case 'tests:version':
		if (fields::has_for_tests_and_template($project->id, $test->template_id, 'version'))
		{
			if ($change)
			{
				$value = $change->version;
			}
		}
		break;

	case 'tests:comment':
		if ($change)
		{
			$value = $change->comment;
		}
		break;

	case 'tests:original_case_id':
		$value = entities::case_id($test->case_id);
		break;

	case 'tests:in_progress_by':
		if ($test->in_progress_by)
		{
			$value = $GI->cache->get_scalar(
				'user',
				$test->in_progress_by,
				'name',
				''
			);
		}
		break;

	case 'tests:run_id':
		$value = entities::run_id($run->id);
		break;

	case 'tests:run_name':
		$value = $run->name;
		break;

	case 'tests:run_config':
		$value = $run->config;
		break;

	case 'tests:plan_id':
		if ($plan)
		{
			$value = entities::run_id($plan->id);
		}
		break;

	case 'tests:plan_name':
		if ($plan)
		{
			$value = $plan->name;
		}
		break;

	case 'tests:tested_by':
		$tested_by = null;
		if ($layout_results && $change)
		{
			$tested_by = $change->user_id;
		}
		else
		{
			$tested_by = $test->tested_by;
		}

		if ($tested_by)
		{
			$value = $GI->cache->get_scalar(
				'user',
				$tested_by,
				'name',
				''
			);
		}
		break;

	case 'tests:tested_on':
		$tested_on = null;
		if ($layout_results && $change)
		{
			$tested_on = $change->created_on;
		}
		else
		{
			$tested_on = $test->tested_on;
		}

		if ($tested_on)
		{
			$value = date::format_short_datetime($tested_on);
		}
		break;

	default:
		// We deal with a custom field (or unknown/unsupported column) if
		// we reach this point. We first check if we deal with a sub-field
		// of a custom field (such as tests:custom_step_results.step).
		// We split the column into the system name and sub-property in
		// this case (and format the value differently, see below).
		$sub = null;

		$ix = str::pos($column, '.');
		if ($ix !== false)
		{
			$sub = str::sub($column, $ix + 1);
			$column = str::sub($column, 0, $ix);
		}

		$obj = $is_case_field ? $test : $change;

		$field = arr::get($fields, $column);
		if ($field && $field->can_template($test->template_id) && $obj)
		{
			if ($sub)
			{
				$value = fields::export_value_partial(
					$field,
					$obj,
					$sub,
					$exporter,
					$separated_steps_new_lines ?? null
				);
				if (is_array($value)) {
					$arrayValues[(string) $index] = array_slice($value, 1);
					$arrayValuesCount = count($arrayValues[(string) $index]);
					$value = $value[0];
				}
			}
			else
			{
				$value = fields::export_value(
					$field,
					$obj,
					$exporter
				);
			}

			$is_encoded = true; // Custom fields do their own encoding
		}
		break;
}

if ($value !== null)
{
	if (!$is_encoded)
	{
		// System fields are encoded/escaped here (replace " with "")
		$value = csv::encode($value);
	}
}
else
{
	$value = '';
}

$values[] = $value;
$index++;
?>
<?php endforeach ?>
<?php echo  csv::join($values, $separator) ?>
<?php
			if (!empty($arrayValues)) {
				for ($arrayValuesIndex = 0; $arrayValuesIndex < $arrayValuesCount; $arrayValuesIndex++) {
					$values = [];
					for ($index = 0; $index < count($columns); $index++) {
						$values[] = array_key_exists((string) $index, $arrayValues)
							? $arrayValues[$index][$arrayValuesIndex]
							: '';
					}

					echo csv::join($values, $separator);
				}
			}
?>
<?php endfor ?>
<?php $test = $tests->peek() ?>
<?php endwhile ?>
<?php $section = $sections->peek() ?>
<?php endwhile ?>
