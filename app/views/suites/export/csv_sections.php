<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$project = projects::get_current();
// Execute the deferred query and group the case assocs by the cases
// for easy and fast lookup
$case_assocs = group::by_id($case_assocs->result(), 'case_id');
$section_hierarchies = [];
$section = $sections->peek();
while ($section) {
	$section_lookup[$section->id] = $section;
	$sections->next();
	$case = $cases->peek();
	while ($case && $case->section_id == $section->id) {
		$cases->next();
		if (isset($case_assocs[$case->id])) {
			$current_case_assocs = group::by_id_scalar(
				$case_assocs[$case->id]->items,
				'name',
				'value'
			);
			foreach ($current_case_assocs as $key => $value) {
				$case->$key = $value;
			}
		}

		$milestone = null;
		if ($case->milestone_id) {
			$milestone = arr::get($milestone_lookup, $case->milestone_id);
		}

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

		$values = [];
		$index = 0;
		$arrayValues = [];
		$arrayValuesCount = 0;
		foreach ($columns as $column) {
			if (!isset($fields_csv[$column])) {
				continue;
			}

			$value = null;
			$is_encoded = false;

			switch ($column) {
				case 'cases:id':
					$value = entities::case_id($case->id);
					break;

				case 'cases:title':
					$value = $case->title;
					break;

				case 'cases:template_id':
					$value = $GI->cache->get_scalar(
						'template',
						$case->template_id,
						'name',
						''
					);
					break;

				case 'cases:type_id':
					$value = $GI->cache->get_scalar(
						'case_type',
						$case->type_id,
						'name',
						''
					);
					break;

				case 'cases:priority_id':
					$value = $GI->cache->get_scalar(
						'priority',
						$case->priority_id,
						'name',
						''
					);
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
				case 'cases:milestone_id':
					if (fields::has_for_cases_and_template($project->id, $case->template_id, 'milestone_id') && $milestone) {
						$value = $milestone->name;
					}

					break;

				case 'cases:estimate':
					if (fields::has_for_cases_and_template($project->id, $case->template_id, 'estimate') && $case->estimate) {
						$value = $case->estimate . 's';
					}

					break;

				case 'cases:estimate_forecast':
					if (fields::has_for_cases_and_template($project->id, $case->template_id, 'estimate') && $case->estimate_forecast) {
						$value = $case->estimate_forecast . 's';
					}

					break;

				case 'cases:refs':
					if (fields::has_for_cases_and_template($project->id, $case->template_id, 'refs') && $case->refs) {
						$value = references::format_nolinks($case->refs);
					}

					break;

				case 'cases:section_id':
					$value = $section->name;
					break;

				case 'cases:section_full':
					// Compute the full section name (as in Section1 > Section 2)
					// on demand and cache the result afterwards.
					$value = arr::get($section_hierarchies, $section->id);
					if (!$value) {
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

				case 'cases:suite_id':
					$value = entities::suite_id($suite->id);
					break;

				case 'cases:suite_name':
					$value = $suite->name;
					break;

				case 'cases:created_by':
					$value = $GI->cache->get_scalar(
						'user',
						$case->user_id,
						'name',
						''
					);
					break;

				case 'cases:created_on':
					$value = date::format_short_datetime($case->created_on);
					break;

				case 'cases:updated_by':
					$value = $GI->cache->get_scalar(
						'user',
						$case->updated_by,
						'name',
						''
					);
					break;

				case 'cases:updated_on':
					$value = date::format_short_datetime($case->updated_on);
					break;

				default:
					// We deal with a custom field (or unknown/unsupported column) if
					// we reach this point. We first check if we deal with a sub-field
					// of a custom field (such as cases:custom_steps_separated.step).
					// We split the column into the system name and sub-property in
					// this case (and format the value differently, see below).
					$sub = null;

					$ix = str::pos($column, '.');
					if ($ix !== false) {
						$sub = str::sub($column, $ix + 1);
						$column = str::sub($column, 0, $ix);
					}

					$field = arr::get($fields, $column);
					if ($field && $field->can_template($case->template_id)) {
						if ($sub) {
							$value = fields::export_value_partial(
								$field,
								$case,
								$sub,
								$exporter,
								$separatedStepsNewLines
							);

							if (is_array($value)) {
								$arrayValues[(string) $index] = array_slice($value, 1);
								$arrayValuesCount = count($arrayValues[(string) $index]);
								$value = $value[0];
							}
						} else {
							$exportData = fields::export_value(
								$field,
								$case,
								$exporter
							);
                                                        $arrayImp = [];
                                                        $StepIds = [];
                                                        $StepData = [];
                                                        if ($exportData) {

                                                            foreach (explode(PHP_EOL,$exportData) as $data) {
                                                                if (!empty($data) && is_numeric(trim($data))) {
                                                                    $StepIds[] = trim($data);
                                                                } else {
                                                                    $StepData[] = $data;
                                                                }
                                                            }
                                                        }
                                                        if (!empty($StepData)) {
                                                            $arrayImp[] = implode("\n", $StepData);
                                                        }

                                                        if (!empty($StepIds)) {
                                                            $arrayImp[] = $shared_step_model->sharedStepContent($StepIds);
                                                        }

                                                        $value = implode("\n", $arrayImp);
                                                }

						$is_encoded = true; // Custom fields do their own encoding
					}

					break;
			}

			if ($value !== null) {
				if (!$is_encoded) {
					// System fields are encoded/escaped here (replace " with "")
					$value = csv::encode($value);
				}
			} else {
				$value = '';
			}

			$values[] = $value;
			$index++;
		}

		echo csv::join($values, $separator);
		if (!empty($arrayValues)) {
			for ($arrayValuesIndex = 0; $arrayValuesIndex < $arrayValuesCount; $arrayValuesIndex++) {
				$values = [];
				for ($index = 0; $index < count($columns); $index++) {
					$values[] = array_key_exists((string) $index, $arrayValues) ? $arrayValues[(string) $index][$arrayValuesIndex] : '';
				}

				echo csv::join($values, $separator);
			}
		}

		$case = $cases->peek();
	}

	$section = $sections->peek();
}
?>
