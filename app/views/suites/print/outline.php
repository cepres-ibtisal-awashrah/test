<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php $case = $cases->peek() ?>
<?php if ($case && $case->section_id == $section->id): ?>
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
		</colgroup>
		<tr class="header">
			<?php foreach ($columns_for_user as $key => $width): ?>
				<?php $column_name = arr::get($columns, $key) ?>
				<?php if ($column_name): ?>
					<th><?php echo h( $column_name )?></th>
				<?php endif ?>
			<?php endforeach ?>
		</tr>
		<?php while ($case && $case->section_id == $section->id): ?>
			<?php $cases->next() ?>
			<?php $current_case_assocs = array() ?>
			<?php if (isset($case_assocs[$case->id])): ?>
				<?php $current_case_assocs = group::by_id_scalar(
					$case_assocs[$case->id]->items,
					'name',
					'value') ?>
			<?php endif ?>
			<tr>
			<?php foreach ($columns_for_user as $key => $width): ?>
				<?php if ($key == 'cases:id'): ?>
					<td class="id"><?php echo  entities::case_id($case->id) ?></td>
				<?php elseif ($key == 'cases:title'): ?>
					<td><?php echo h( $case->title )?></a></td>
				<?php elseif ($key == 'cases:template_id'): ?>
					<td class="sub">
						<?php $template = $GI->cache->get_object('template', $case->template_id) ?>
						<?php if ($template): ?>
							<?php echo h( $template->name )?>
						<?php endif ?>
					</td>
				<?php elseif ($key == 'cases:type_id'): ?>
					<td class="sub">
						<?php $type = $GI->cache->get_object('case_type', $case->type_id) ?>
						<?php if ($type): ?>
							<?php echo h( $type->name )?>
						<?php endif ?>
					</td>
				<?php elseif ($key == 'cases:priority_id'): ?>
					<td class="sub">
						<?php $priority = $GI->cache->get_object('priority', $case->priority_id) ?>
						<?php if ($priority): ?>
							<?php echo h( $priority->short_name )?>
						<?php endif ?>
					</td>
				<?php elseif ($key == 'cases:estimate'): ?>
					<td class="sub">
					<?php if (fields::has_for_cases_and_template($project->id, $case->template_id, 'estimate')): ?>	
						<?php $timespan = timespan::format_short($case->estimate) ?>
						<?php if ($timespan): ?>
							<?php echo  $timespan ?>
						<?php endif ?>
					<?php endif ?>
					</td>
				<?php elseif ($key == 'cases:estimate_forecast'): ?>
					<td class="sub">
					<?php if (fields::has_for_cases_and_template($project->id, $case->template_id, 'estimate')): ?>
						<?php $timespan = timespan::format_short($case->estimate_forecast) ?>
						<?php if ($timespan): ?>
							<?php echo  $timespan ?>
						<?php endif ?>
					<?php endif ?>
					</td>
				<?php elseif ($key == 'cases:section_id'): ?>
					<td class="sub">
						<?php if (isset($section->name)): ?>
							<?php echo h( $section->name )?>
						<?php endif ?>
					</td>
				<?php elseif ($key == 'cases:milestone_id'): ?>
					<td class="sub">
					<?php if (fields::has_for_cases_and_template($project->id, $case->template_id, 'milestone_id')): ?>	
						<?php $milestone = null ?>
						<?php if ($case->milestone_id): ?>
							<?php $milestone = arr::get($milestone_lookup, $case->milestone_id) ?>
						<?php endif ?>
						<?php if ($milestone): ?>
							<?php echo h( $milestone->name )?>
						<?php endif ?>
					<?php endif ?>
					</td>
				<?php elseif ($key == 'cases:refs'): ?>
					<td class="sub">
					<?php if (fields::has_for_cases_and_template($project->id, $case->template_id, 'refs')): ?>
						<?php if ($case->refs): ?>
							<?php echo h( references::format_nolinks($case->refs) )?>
						<?php endif ?>
					<?php endif ?>
					</td>
				<?php elseif ($key == 'cases:created_on'): ?>
					<td class="sub">
						<?php if ($case->created_on): ?>
							<?php echo  date::format_short_date($case->created_on) ?>
						<?php endif ?>
					</td>
				<?php elseif ($key == 'cases:created_by'): ?>
					<td class="sub">
						<?php if ($case->user_id): ?>
							<?php $created_by = $GI->cache->get_object('user', $case->user_id) ?>
							<?php if ($created_by): ?>
								<?php echo h( names::shorten($created_by->name) )?>
							<?php endif ?>
						<?php endif ?>
					</td>
				<?php elseif ($key == 'cases:updated_on'): ?>
					<td class="sub">
						<?php if ($case->updated_on): ?>
							<?php echo  date::format_short_date($case->updated_on) ?>
						<?php endif ?>
					</td>
				<?php elseif ($key == 'cases:updated_by'): ?>
					<td class="sub">
						<?php if ($case->updated_by): ?>
							<?php $updated_by = $GI->cache->get_object('user', $case->updated_by) ?>
							<?php if ($updated_by): ?>
								<?php echo h( names::shorten($updated_by->name) )?>
							<?php endif ?>
						<?php endif ?>
					</td>
				<?php else: ?>
					<?php $value = null ?>
					<?php $field = arr::get($fields, $key) ?>
					<?php if ($field && $field->can_template($case->template_id)): ?>
						<?php $field_prop = preg_replace('/^.*:/', '', $key) ?>
						<?php if ($field->is_multi()): ?>
							<?php $values = null ?>
							<?php if (str::starts_with($key, 'cases:')): ?>
								<?php $values = arr::get($current_case_assocs, $field_prop) ?>
							<?php endif ?>
							<?php if ($values): ?>
								<?php $value = fields::format_scalar($field, $values) ?>
							<?php endif ?>
						<?php else: ?>						
							<?php if (obj::has_field($case, $field_prop)): ?>
								<?php $value = fields::format_scalar($field, $case->$field_prop) ?>
							<?php endif ?>
						<?php endif ?>
					<?php endif ?>
					<?php if ($value !== null): ?>
						<td><?php echo  $value ?></td>
					<?php else: ?>
						<td></td>
					<?php endif ?>
				<?php endif ?>
			<?php endforeach ?>
			</tr>
			<?php $case = $cases->peek() ?>
		<?php endwhile ?>	
	</table>
<?php endif ?>
