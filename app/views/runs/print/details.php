<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php $test = $tests->peek() ?>
<?php if ($test && $test->section_id == $section->id): ?>
	<?php
	$temp = array();
	$temp['section'] = $section;
	$GI->load->view('runs/print/section_backlog', $temp);
	?>
	<?php while ($test && $test->section_id == $section->id): ?>
		<?php $tests->next() ?>
		<?php if (DEPLOY_DEVELOP): ?>
			<?php
			$temp = array();
			$temp['project'] = $project;
			$temp['tests'] = [$test];
			$temp['test_changes'] = $test_changes;
			$temp['test_assocs'] = $test_assocs;
			$temp['case_assocs'] = $case_assocs;
			$temp['case_fields'] = $case_fields;
			$temp['test_fields'] = $test_fields;
			$temp['milestone_lookup'] = $milestone_lookup;
			$GI->load->view('tests/print/content', $temp);
			?>
		<?php else: ?>
<?php if (isset($case_assocs)): ?>
	<?php if (isset($case_assocs[$test->content_id])): ?>
		<?php $current_case_assocs = group::by_id_scalar(
			$case_assocs[$test->content_id]->items,
			'name',
			'value') ?>
		<?php foreach ($current_case_assocs as $key => $value): ?>
			<?php $test->$key = $value ?>
		<?php endforeach ?>
	<?php endif ?>
<?php endif ?>
<?php /* Don't override included field variables (stay in scope) */ ?>
<?php $_case_fields = fields::filter_template($case_fields, $test->template_id) ?>
<?php $_test_fields = fields::filter_template($test_fields, $test->template_id) ?>
<?php $top = isset($top) && $top ?>
<div class="page">
	<h3 class="<?php echo  $top ? 'top' : '' ?>"><?php echo  entities::test_id($test->id) ?>: <?php echo h( $test->title )?></h3>
	<div class="io-container">
	<table class="io">
		<tr>
			<td style="width: 25%">
				<label><?php echo  lang('layout_grid_status') ?></label>
				<?php $status = $GI->cache->get_object('status', $test->status_id) ?>
				<?php if ($status): ?>
				<span class="statusBox" style="<?php echo  tests::get_status_box_colors($status->color_dark) ?>"><?php echo h( str::shorten($status->label, 20) )?></span>
				<?php endif ?>
			</td>
			<td style="width: 25%"> 
				<label><?php echo  lang('layout_grid_type') ?></label> 
				<?php $type = $GI->cache->get_object('case_type', $test->type_id) ?>
				<?php if ($type): ?>
					<?php echo h( $type->name )?> 
				<?php else: ?>
					<?php echo  lang('layout_none') ?>
				<?php endif ?>			
			</td> 
			<td style="width: 25%">
				<label><?php echo  lang('layout_grid_priority') ?></label>
				<?php $priority = $GI->cache->get_object('priority', $test->priority_id) ?>
				<?php if ($priority): ?>
					<?php echo h( $priority->name )?> 
				<?php else: ?>
					<?php echo  lang('layout_none') ?>
				<?php endif ?>
			</td>
			<?php $i = 3 ?>
			<?php if (fields::has_for_cases_and_template($project->id, $test->template_id, 'estimate')): ?>
			<td style="width: 25%">
				<label><?php echo  lang('layout_grid_estimate') ?></label>
				<?php $timespan = timespan::format_long($test->estimate) ?>
				<?php if ($timespan): ?>
					<?php echo  $timespan ?>
				<?php else: ?>
					<?php echo  lang('layout_none') ?>
				<?php endif ?>
			</td>
			<?php $i++ ?>
			<?php endif ?>
		<?php if ($i == 4): ?>
			<?php $i = 0 ?>
			</tr>
			<tr>
		<?php endif ?>
			<?php if (fields::has_for_cases_and_template($project->id, $test->template_id, 'milestone_id')): ?>
			<td style="width: 25%"> 
				<label><?php echo  lang('layout_grid_milestone') ?></label> 
				<?php $milestone = null ?>
				<?php if ($test->milestone_id): ?>
					<?php $milestone = arr::get($milestone_lookup, $test->milestone_id) ?>
				<?php endif ?>
				<?php if ($milestone): ?>
					<?php echo h( $milestone->name )?>
				<?php else: ?>
					<?php echo  lang('layout_none') ?>
				<?php endif ?>
			</td>
			<?php $i++ ?>
			<?php endif ?>
		<?php if ($i == 4): ?>
			<?php $i = 0 ?>
			</tr>
			<tr>
		<?php endif ?>
			<?php if (fields::has_for_cases_and_template($project->id, $test->template_id, 'refs')): ?>
				<td style="width: 25%">
					<label><?php echo  lang('layout_grid_references') ?></label>
					<?php $references = null ?>
					<?php if ($test->refs): ?>
						<?php $references = references::format_nolinks(
							h($test->refs)
						) ?>
					<?php endif ?>
					<?php if ($references): ?>
						<?php echo  $references ?>
					<?php else: ?>
						<?php echo  lang('layout_none') ?>
					<?php endif ?>
				</td>
			<?php $i++ ?>
			<?php endif ?>
		<?php if ($i == 4): ?>
			<?php $i = 0 ?>
			</tr>
			<tr>
		<?php endif ?>
			<?php $infos = fields::print_values($_case_fields, $test, TP_LOCATION_TOP) ?>
			<?php if (count($infos) > 0): ?>
				<?php foreach ($infos as $info): ?>
					<?php if ($i == 4): ?>
						<?php $i = 0 ?>
						</tr>
						<tr>
					<?php endif ?>
					<td style="width: 25%">
						<label><?php echo h( $info->label )?></label>
						<?php echo  $info->value ?>
					</td>
					<?php $i++ ?>
				<?php endforeach ?>
			<?php endif ?>
			<?php while ($i > 0 && $i < 4): ?>
				<td style="width: 25%"></td>
				<?php $i++ ?>
			<?php endwhile ?>
		</tr>
	</table>
</div>
	<?php $infos = fields::print_values($_case_fields, $test, TP_LOCATION_BOTTOM) ?>
	<?php if (count($infos) > 0): ?>
		<?php foreach ($infos as $info): ?>
			<h4><?php echo h( $info->label )?></h4>
			<?php echo  $info->value ?>
		<?php endforeach ?>
	<?php else: ?>
		<p><?php echo  lang('cases_description_empty') ?></p>
	<?php endif ?>

	<?php $current_test_changes = array() ?>
	<?php if (is_array($test_changes)): ?>
		<?php $current_test_changes = $test_changes ?>
	<?php else: ?>
		<?php $change = $test_changes->peek() ?>
		<?php while ($change && $change->test_id == $test->id): ?>
			<?php $current_test_changes[] = $change ?>
			<?php $test_changes->next() ?>
			<?php $change = $test_changes->peek() ?>
		<?php endwhile ?>
	<?php endif ?>

	<?php $current_test_assocs = array() ?>
	<?php if (isset($test_assocs)): ?>
		<?php if (isset($test_assocs[$test->id])): ?>
			<?php $current_test_assocs = group::by_id(
				$test_assocs[$test->id]->items,
				'test_change_id') ?>
		<?php endif ?>
	<?php endif ?>

	<h4 style="margin-bottom: 0.5em"><?php echo  lang('tests_results') ?></h4>
	<?php if ($current_test_changes): ?>
		<div class="changes">
			<?php foreach ($current_test_changes as $change): ?>
			<?php if (isset($current_test_assocs[$change->id])): ?>
				<?php $current_test_assocs_for_change = group::by_id_scalar(
					$current_test_assocs[$change->id]->items,
					'name',
					'value') ?>
				<?php foreach ($current_test_assocs_for_change as $key => $value): ?>
					<?php $change->$key = $value ?>
				<?php endforeach ?>
			<?php endif ?>
			<div class="change">
				<div class="changeType">
					<?php if ($change->status_id): ?>
						<?php $status = $GI->cache->get_object('status', $change->status_id) ?>
						<?php if ($status): ?>
							<div class="statusBox" style="<?php echo  tests::get_status_box_colors($status->color_dark) ?>"><?php echo h( str::shorten($status->label, 25) )?></div>
						<?php endif ?>
					<?php else: ?>
						<?php $title = tests::get_change_title($change) ?>
						<div class="statusBox defaultBox"><?php echo h( $title )?></div>
					<?php endif ?>

					<p style="margin-bottom: 5px">
						<?php $user = $GI->cache->get_object('user', $change->user_id) ?>
						<?php if ($user): ?>
							<?php echo h( names::shorten($user->name) )?>
							<br />
						<?php endif ?>
						<?php echo  date::format_short_datetime($change->created_on) ?>
					</p>

					<?php $infos = fields::print_values($_test_fields, $change, TP_LOCATION_RIGHT) ?>

					<?php 
					$has_fields = count($infos) > 0;
					$has_assigned = false;
					$has_unassigned = false;
	
					if ($change->comment || $change->status_id)
					{
						$has_assigned = !is_null($change->assignedto_id);
						$has_unassigned = (bool) $change->unassigned;
					}

					$has_version = false;
					if (fields::has_for_tests_and_template($project->id, $test->template_id, 'version'))
					{
						$has_version = !str::is_empty($change->version);
					}

					$has_elapsed = false;
					if (fields::has_for_tests_and_template($project->id, $test->template_id, 'elapsed'))
					{
						$has_elapsed = (bool) ($change->elapsed);
					}
					
					$has_defects = false;
					if (fields::has_for_tests_and_template($project->id, $test->template_id, 'defects'))
					{
						$has_defects = !str::is_empty($change->defects);
					}
					?>
					
					<?php if ($has_version || $has_elapsed || $has_defects || $has_assigned ||
						$has_unassigned || $has_fields) : ?>
						<div style="margin: 1em 0">
							<?php if ($has_assigned): ?>
								<div class="meta">
									<label><?php echo  lang('tests_changes_meta_assignedto') ?></label>
									<?php $assignedto = $GI->cache->get_object('user', $change->assignedto_id) ?>
									<?php if ($assignedto): ?>							
										<?php echo h( names::shorten($assignedto->name) )?>
									<?php endif ?>
								</div>
							<?php elseif ($has_unassigned): ?>
								<div class="meta">
									<label><?php echo  lang('tests_changes_meta_assignedto') ?></label>
									<?php echo  lang('tests_changes_meta_assignedto_unassigned') ?>
								</div>
							<?php endif ?>
							<?php if ($has_version): ?>
								<div class="meta">
									<label><?php echo  lang('tests_changes_meta_version') ?></label>
									<?php echo h( $change->version )?>
								</div>
							<?php endif ?>
							<?php if ($has_elapsed): ?>
								<div class="meta">
									<label><?php echo  lang('tests_changes_meta_elapsed') ?></label>
									<?php echo  timespan::format_short($change->elapsed) ?>
								</div>
							<?php endif ?>
							<?php if ($has_defects): ?>
								<div class="meta">
									<label><?php echo  lang('tests_changes_meta_defects') ?></label>
									<?php echo h( defects::format_nolinks($change->defects) )?>
								</div>
							<?php endif ?>
							<?php if ($has_fields): ?>
								<?php foreach ($infos as $info): ?>
									<div class="meta">
										<label><?php echo h( $info->label )?></label>
										<?php echo  $info->value ?>
									</div>
								<?php endforeach ?>
							<?php endif ?>
						</div>
					<?php endif ?>
				</div>
				<div class="changeContent">
					<div class="markdown">
						<?php echo  tests::get_change_content($change) ?>
					</div>
					<?php $infos = fields::print_values($_test_fields, $change, TP_LOCATION_LEFT) ?>
					<?php if (count($infos) > 0): ?>
						<?php foreach ($infos as $info): ?>
							<label><?php echo h( $info->label )?></label>
							<?php echo  $info->value ?>
						<?php endforeach ?>
					<?php endif ?>
				</div>
			</div>
			<?php endforeach ?>
		</div>	
	<?php else: ?>
	<p><?php echo  lang('tests_no_changes') ?></p>
	<?php endif ?>
</div>		<?php endif ?>
		<?php $test = $tests->peek() ?>
	<?php endwhile ?>
<?php endif ?>