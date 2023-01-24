<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php $test = $tests->peek() ?>
<?php if ($test && $test->section_id == $section->id): ?>
	<?php
	$temp = array();
	$temp['section'] = $section;
	$GI->load->view('runs/print/section_backlog', $temp);
	?>
	<table class="grid">
		<colgroup>
		<?php foreach ($columns_for_user as $key => $width): ?>
			<?php $column_name = arr::get($columns, $key) ?>
			<?php if ($column_name): ?>
				<?php if ($width): ?>
					<?php $style = 'width: ' . $width . 'px'?>
				<?php else: ?>
					<?php $style = '' ?>
				<?php endif ?>
				<col style="<?php echo  $style ?>"></col>
			<?php endif ?>
		<?php endforeach ?>
			<?php $status_min_width = 90 ?>
			<?php $statuses = $GI->cache->get_objects('status') ?>
			<?php if ($statuses): ?>
				<?php foreach ($statuses as $status): ?>
					<?php $status_len = str::len($status->label) ?>
					<?php if ($status_len >= 14): ?>
						<?php $status_min_width = max(120, $status_min_width) ?>
					<?php elseif ($status_len >= 12): ?>
						<?php $status_min_width = max(110, $status_min_width) ?>
					<?php elseif ($status_len >= 10): ?>
						<?php $status_min_width = max(100, $status_min_width) ?>
					<?php endif ?>
				<?php endforeach ?>
			<?php endif ?>
			<col style="width: <?php echo  $status_min_width ?>px"></col>
		</colgroup>
		<tr class="header">
			<?php foreach ($columns_for_user as $key => $width): ?>
				<?php $column_name = arr::get($columns, $key) ?>
				<?php if ($column_name): ?>
					<th><?php echo h( $column_name )?></th>
				<?php endif ?>
			<?php endforeach ?>
			<th><?php echo  lang('layout_grid_status') ?></th>
		</tr>
		<?php while ($test && $test->section_id == $section->id): ?>
			<?php $tests->next() ?>

			<?php $current_test_changes = array() ?>
			<?php $current_last_status_change = null ?>
			<?php $change = $test_changes->peek() ?>
			<?php while ($change && $change->test_id == $test->id): ?>
				<?php array_unshift($current_test_changes, $change) // Reverse order ?>
				<?php if ($change->status_id): ?>
					<?php if (!$current_last_status_change): ?>
						<?php $current_last_status_change = $change ?>
					<?php endif ?>
				<?php endif ?>
				<?php $test_changes->next() ?>
				<?php $change = $test_changes->peek() ?>
			<?php endwhile ?>

			<?php $current_case_assocs = array() ?>
			<?php if (isset($case_assocs[$test->content_id])): ?>
				<?php $current_case_assocs = group::by_id_scalar(
					$case_assocs[$test->content_id]->items,
					'name',
					'value') ?>
			<?php endif ?>

			<?php $current_test_assocs = array() ?>
			<?php $current_test_assocs_latest = array() ?>

			<?php if (isset($test_assocs[$test->id])): ?>
				<?php $items = $test_assocs[$test->id]->items ?>
				<?php foreach ($items as $test_assoc): ?>
					<?php $key = $test_assoc->name ?>
					<?php if (!isset($current_test_assocs[$key])): ?>
						<?php $current_test_assocs[$key] = array() ?>
					<?php endif ?>
					<?php $current_test_assocs[$key][] = $test_assoc->value ?>
					<?php if ($current_last_status_change &&
						$current_last_status_change->id == $test_assoc->test_change_id): ?>
						<?php if (!isset($current_test_assocs_latest[$key])): ?>
							<?php $current_test_assocs_latest[$key] = array() ?>
						<?php endif ?>
						<?php $current_test_assocs_latest[$key][] = $test_assoc->value ?>
					<?php endif ?>
				<?php endforeach ?>
			<?php endif ?>

			<tr>
			<?php foreach ($columns_for_user as $key => $width): ?>
				<?php if ($key == 'tests:id'): ?>
					<td class="id"><?php echo  entities::test_id($test->id) ?></td>
				<?php elseif ($key == 'tests:original_case_id'): ?>
					<?php if ($test->case_id): ?>
						<td class="id"><?php echo  entities::case_id($test->case_id) ?></td>
					<?php else: ?>
						<td class="id"></td>
					<?php endif ?>
				<?php elseif ($key == 'cases:title'): ?>
					<td><?php echo h( $test->title )?></td>
				<?php elseif ($key == 'cases:template_id'): ?>
					<td class="sub">
						<?php $template = $GI->cache->get_object('template', $test->template_id) ?>
						<?php if ($template): ?>
							<?php echo h( $template->name )?>
						<?php endif ?>
					</td>
				<?php elseif ($key == 'cases:type_id'): ?>
					<td class="sub">
						<?php $type = $GI->cache->get_object('case_type', $test->type_id) ?>
						<?php if ($type): ?>
							<?php echo h( $type->name )?>
						<?php endif ?>
					</td>
				<?php elseif ($key == 'cases:priority_id'): ?>
					<td class="sub">
						<?php $priority = $GI->cache->get_object('priority', $test->priority_id) ?>
						<?php if ($priority): ?>
							<?php echo h( $priority->short_name )?>
						<?php endif ?>
					</td>
				<?php elseif ($key == 'cases:estimate'): ?>
					<td class="sub">
					<?php if (fields::has_for_cases_and_template($project->id, $test->template_id, 'estimate')): ?>
						<?php $timespan = timespan::format_short($test->estimate) ?>
						<?php if ($timespan): ?>
							<?php echo  $timespan ?>
						<?php endif ?>
					<?php endif ?>
					</td>
				<?php elseif ($key == 'cases:estimate_forecast'): ?>
					<td class="sub">
					<?php if (fields::has_for_cases_and_template($project->id, $test->template_id, 'estimate')): ?>	
						<?php $timespan = timespan::format_short($test->estimate_forecast) ?>
						<?php if ($timespan): ?>
							<?php echo  $timespan ?>
						<?php endif ?>
					<?php endif ?>
					</td>
				<?php elseif ($key == 'cases:section_id'): ?>
					<td class="sub">
						<?php echo h( $section->name )?>
					</td>
				<?php elseif ($key == 'cases:milestone_id'): ?>
					<td class="sub">
					<?php if (fields::has_for_cases_and_template($project->id, $test->template_id, 'milestone_id')): ?>	
						<?php $milestone = null ?>
						<?php if ($test->milestone_id): ?>
							<?php $milestone = arr::get($milestone_lookup, $test->milestone_id) ?>							
						<?php endif ?>
						<?php if ($milestone): ?>
							<?php echo h( $milestone->name )?>
						<?php endif ?>
					<?php endif ?>
					</td>
				<?php elseif ($key == 'cases:refs'): ?>
					<td class="sub">
					<?php if (fields::has_for_cases_and_template($project->id, $test->template_id, 'refs')): ?>
						<?php if ($test->refs): ?>
							<?php echo h( references::format_nolinks($test->refs) )?>
						<?php endif ?>
					<?php endif ?>
					</td>
				<?php elseif ($key == 'tests:in_progress_by'): ?>
					<td class="sub">					
						<?php if ($test->in_progress > 0 && $test->in_progress_by): ?>
							<?php $in_progress_by = $GI->cache->get_object('user', 
								$test->in_progress_by) ?>
							<?php if ($test->in_progress == 1): ?>
								<?php if ($in_progress_by): ?>
									<?php echo h( names::shorten($in_progress_by->name) )?>
								<?php endif ?>
							<?php else: ?>
								<?php if ($in_progress_by): ?>
									<?php echo h( names::shorten($in_progress_by->name) )?>
									(<?php echo  langf('tests_in_progress_more', 
										$test->in_progress - 1) ?>)
								<?php else: ?>
									<?php echo  langf('tests_in_progress_users', 
										$test->in_progress) ?>
								<?php endif ?>
							<?php endif ?>
						<?php endif ?>
					</td>
				<?php elseif ($key == 'tests:assignedto_id'): ?>
					<?php if ($test->assignedto_id): ?>
						<?php $user = $GI->cache->get_object('user', $test->assignedto_id) ?>
						<?php if ($user): ?>
							<td class="assigned sub"><?php echo h( names::shorten($user->name) )?></td>
						<?php endif ?>
					<?php else: ?>
					<td class="assigned"></td>
					<?php endif ?>
				<?php elseif ($key == 'tests:elapsed' || $key == 'tests:elapsed_all'): ?>
					<?php $value = null ?>
					<?php if (fields::has_for_tests_and_template($project->id, $test->template_id, 'elapsed')): ?>
						<?php if ($key == 'tests:elapsed'): ?>
							<?php if ($current_last_status_change): ?>
								<?php $value = $current_last_status_change->elapsed ?>
							<?php endif ?>
						<?php else: ?>
							<?php $value = tests::get_elapsed($current_test_changes) ?>
						<?php endif ?>
					<?php endif ?>
					<td class="sub">
						<?php if ($value): ?>
							<?php $timespan = timespan::format_short($value) ?>
							<?php if ($timespan): ?>
								<?php echo  $timespan ?>
							<?php endif ?>
						<?php endif ?>
					</td>
				<?php elseif ($key == 'tests:defects' || $key == 'tests:defects_all'): ?>
					<?php $value = null ?>
					<?php if (fields::has_for_tests_and_template($project->id, $test->template_id, 'defects')): ?>	
						<?php if ($key == 'tests:defects'): ?>
							<?php if ($current_last_status_change): ?>
								<?php $value = $current_last_status_change->defects ?>
							<?php endif ?>
						<?php else: ?>
							<?php $value = tests::get_defects($current_test_changes) ?>
						<?php endif ?>
					<?php endif ?>
					<td class="sub">
						<?php if ($value): ?>
							<?php echo h( defects::format_nolinks($value) )?>
						<?php endif ?>
					</td>
				<?php elseif ($key == 'tests:version' || $key == 'tests:version_all'): ?>
					<?php $value = null ?>
					<?php if (fields::has_for_tests_and_template($project->id, $test->template_id, 'version')): ?>
						<?php if ($key == 'tests:version'): ?>
							<?php if ($current_last_status_change): ?>
								<?php $value = $current_last_status_change->version ?>
							<?php endif ?>
						<?php else: ?>
							<?php $value = tests::get_versions($current_test_changes) ?>
						<?php endif ?>
					<?php endif ?>
					<td class="sub">
						<?php if ($value): ?>
							<?php echo h( $value )?>
						<?php endif ?>
					</td>
				<?php elseif ($key == 'tests:tested_by'): ?>
					<?php if ($test->tested_by): ?>
						<?php $tested_by = $GI->cache->get_object('user', $test->tested_by) ?>
					<?php else: ?>
						<?php $tested_by = null ?>
					<?php endif ?>
					<?php $feature_na = !$test->tested_by && 
						$test->status_id != TP_TEST_STATUS_UNTESTED ?>
					<td class="sub <?php echo  $feature_na ? 'feature-na' : '' ?>">
						<?php if ($tested_by): ?>
							<?php echo h( names::shorten($tested_by->name) )?>
						<?php else: ?>
							<?php if ($test->status_id != TP_TEST_STATUS_UNTESTED): ?>
							x
							<?php endif ?>
						<?php endif ?>
					</td>
				<?php elseif ($key == 'tests:tested_on'): ?>
					<?php $feature_na = !$test->tested_on && 
						$test->status_id != TP_TEST_STATUS_UNTESTED ?>
					<td class="sub <?php echo  $feature_na ? 'feature-na' : '' ?>">
						<?php if ($test->tested_on): ?>
							<?php echo  date::format_short_date($test->tested_on) ?>
						<?php else: ?>
							<?php if ($test->status_id != TP_TEST_STATUS_UNTESTED): ?>
							x
							<?php endif ?>
						<?php endif ?>
					</td>	
				<?php else: ?>
					<?php if (str::ends_with($key, ':all')): ?>
						<?php $key_no_all = str::sub($key, 0, str::len($key) - 4) ?>
						<?php $field = arr::get($fields, $key_no_all) ?>
						<?php if ($field && $field->can_template($test->template_id)): ?>
							<?php $field_prop = preg_replace('/^.*:/', '', $key_no_all) ?>
							<td>
							<?php if ($field->is_multi()): ?>
								<?php $values = arr::get($current_test_assocs, $field_prop) ?>
								<?php if ($values): ?>
									<?php $value = fields::format_scalar($field, $values) ?>
									<?php echo  $value ?>
								<?php endif ?>
							<?php else: ?>
								<?php $next_value = null ?>
								<?php foreach ($current_test_changes as $change): ?>
									<?php if (obj::has_field($change, $field_prop)): ?>
										<?php $value = $next_value ?>
										<?php $next_value = fields::format_scalar($field, $change->$field_prop) ?>
										<?php if ($value !== null): ?>
											<?php echo  $value ?><?php if ($next_value): ?>, <?php endif ?>
										<?php endif ?>
									<?php endif ?>
								<?php endforeach ?>
								<?php if ($next_value): ?><?php echo  $next_value ?><?php endif ?>
							<?php endif ?>
							</td>
						<?php else: ?>
							<td></td>
						<?php endif ?>
					<?php else: ?>
						<?php $value = null ?>
						<?php $field = arr::get($fields, $key) ?>
						<?php if ($field && $field->can_template($test->template_id)): ?>
							<?php $field_prop = preg_replace('/^.*:/', '', $key) ?>
							<?php if ($field->is_multi()): ?>
								<?php $values = null ?>
								<?php if (str::starts_with($key, 'cases:')): ?>
									<?php $values = arr::get($current_case_assocs, $field_prop) ?>
								<?php elseif (str::starts_with($key, 'tests:')): ?>
									<?php $values = arr::get($current_test_assocs_latest, $field_prop) ?>
								<?php endif ?>
								<?php if ($values): ?>
									<?php $value = fields::format_scalar($field, $values) ?>
								<?php endif ?>
							<?php else: ?>
								<?php if (str::starts_with($key, 'cases:')): ?>
									<?php if (obj::has_field($test, $field_prop)): ?>
										<?php $value = fields::format_scalar($field, $test->$field_prop) ?>
									<?php endif ?>
								<?php else: ?>
									<?php if ($current_last_status_change &&
										obj::has_field($current_last_status_change, $field_prop)): ?>
										<?php $value = fields::format_scalar(
											$field, 
											$current_last_status_change->$field_prop
										) ?>
									<?php endif ?>
								<?php endif ?>
							<?php endif ?>
						<?php endif ?>
						<?php if ($value !== null): ?>
							<td><?php echo  $value ?></td>
						<?php else: ?>
							<td></td>
						<?php endif ?>
					<?php endif ?>
				<?php endif ?>
			<?php endforeach ?>
				<td class="status">
					<?php $status = $GI->cache->get_object('status', $test->status_id) ?>
					<?php if ($status): ?>
					<span class="statusBox" style="<?php echo  tests::get_status_box_colors($status->color_dark) ?>"><?php echo h( str::shorten($status->label, 13) )?></span>
					<?php endif ?>
				</td>
			</tr>
			<?php $test = $tests->peek() ?>
		<?php endwhile ?>
	</table>
<?php endif ?>
