<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php $project = projects::get_current() ?>
<?php $can_estimate = fields::has_for_cases($project->id, 'estimate') ?>
<?php $can_milestone = fields::has_for_cases($project->id, 'milestone_id') ?>
<?php $can_refs = fields::has_for_cases($project->id, 'refs') ?>
<?php $can_version = fields::has_for_tests($project->id, 'version') ?>
<?php $can_elapsed = fields::has_for_tests($project->id, 'elapsed') ?>
<?php $can_defects = fields::has_for_tests($project->id, 'defects') ?>
<sections>
<?php $section = $sections->peek() ?>
<?php while ($section && $section->depth >= $depth): ?>
	<?php $sections->next() ?>
	<section>
		<name><?php echo xml::encode( $section->name )?></name>
		<description><?php echo xml::encode( $section->description )?></description>
		<?php $test = $tests->peek() ?>
		<?php if ($test && $test->section_id == $section->id): ?>
		<tests>
			<?php while ($test && $test->section_id == $section->id): ?>
			<?php $tests->next() ?>
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
					'test_change_id') ?>
			<?php endif ?>
			<?php $current_test_changes = array() ?>
			<?php $change = $test_changes->peek() ?>
			<?php while ($change && $change->test_id == $test->id): ?>
				<?php $test_changes->next() ?>
				<?php $current_test_changes[] = $change ?>
				<?php $change = $test_changes->peek() ?>
			<?php endwhile ?>
			<test>
				<id><?php echo  entities::test_id($test->id) ?></id>
				<title><?php echo xml::encode( $test->title )?></title>
				<?php $template = $GI->cache->get_object('template', $test->template_id) ?>
				<?php if ($template): ?>
				<template><?php echo xml::encode( $template->name )?></template>
				<?php endif ?>
				<?php $type = $GI->cache->get_object('case_type', $test->type_id) ?>
				<?php if ($type): ?>
				<type><?php echo xml::encode( $type->name )?></type>
				<?php endif ?>
				<?php $priority = $GI->cache->get_object('priority', $test->priority_id) ?>
				<?php if ($priority): ?>
				<priority><?php echo xml::encode( $priority->name )?></priority>
				<?php endif ?>
				<?php if ($can_estimate): ?>
				<?php if (fields::has_for_cases_and_template($project->id, $test->template_id, 'estimate')): ?>
				<estimate><?php echo  $test->estimate ?></estimate>
				<?php endif ?>
				<?php endif ?>
				<?php if ($can_milestone): ?>
				<?php $milestone = null ?>
				<?php if (fields::has_for_cases_and_template($project->id, $test->template_id, 'milestone_id')): ?>
				<?php if ($test->milestone_id): ?>
					<?php $milestone = arr::get($milestone_lookup, $test->milestone_id) ?>
				<?php endif ?>
				<?php endif ?>
				<?php if ($milestone): ?>
				<milestone><?php echo xml::encode( $milestone->name )?></milestone>
				<?php endif ?>
				<?php endif ?>
				<?php if ($can_refs): ?>
				<?php if (fields::has_for_cases_and_template($project->id, $test->template_id, 'refs')): ?>
				<references><?php echo xml::encode( references::format_nolinks($test->refs) )?></references>
				<?php endif ?>
				<?php endif ?>
				<?php $infos = fields::export_values(
					fields::filter_template(
						$case_fields,
						$test->template_id
					),
					$test,
					$exporter
				) ?>
				<?php if (count($infos) > 0): ?>
				<custom>
					<?php foreach ($infos as $info): ?>
					<<?php echo  $info->name ?>><?php echo  $info->value ?></<?php echo  $info->name ?>>
					<?php endforeach ?>
				</custom>
				<?php endif ?>
				<?php if ($test->case_id): ?>
				<caseid><?php echo  entities::case_id($test->case_id) ?></caseid>
				<?php
					$case = $GI->load->model('case')->get($test->case_id);
					global $is_enterprise;
				?>
				<?php if ($case && $is_enterprise): ?>
					<?php if (cases::is_approval_enabled($project) && $case->status_id): ?>
						<?php
							$caseStatus = $GI->cache->get_object(
								'case_status',
								$case->status_id
							);
						?>
						<?php if ($caseStatus): ?>
							<casestatus><?php echo  $caseStatus->name ?></casestatus>
						<?php endif ?>
					<?php else: ?>
						<casestatus></casestatus>
					<?php endif ?>
					<?php if($case->assigned_to_id): ?>
						<?php
							$caseAssignee = $GI->cache->get_object(
								'user',
								$case->assigned_to_id
							);
						?>
						<?php if ($caseAssignee): ?>
							<caseassignedto><?php echo  $caseAssignee->name ?></caseassignedto>
						<?php endif ?>
					<?php else: ?>
						<caseassignedto></caseassignedto>
					<?php endif ?>
				<?php endif ?>
				<?php endif ?>
				<status><?php echo xml::encode( tests::get_status_name($test->status_id) )?></status>
				<?php if ($test->assignedto_id): ?>
				<?php $user = $GI->cache->get_object('user', $test->assignedto_id) ?>
				<?php if ($user): ?>
				<assignedto><?php echo xml::encode( $user->name )?></assignedto>
				<?php endif ?>
				<?php else: ?>
				<assignedto></assignedto>
				<?php endif ?>
				<?php if ($test->in_progress_by): ?>
				<inprogress>
					<?php $in_progress_by = $GI->cache->get_object('user', $test->in_progress_by) ?>
					<?php if ($in_progress_by): ?>
					<by><?php echo xml::encode( $in_progress_by->name )?></by>
					<?php if ($test->in_progress > 1): ?>
						<more><?php echo  $test->in_progress - 1 ?></more>
					<?php endif ?>
					<?php endif ?>
				</inprogress>
				<?php else: ?>
				<inprogress></inprogress>
				<?php endif ?>
				<?php if ($can_elapsed): ?>
				<?php $elapsed = null ?>
				<?php if (fields::has_for_tests_and_template($project->id, $test->template_id, 'elapsed')): ?>
					<?php if ($current_test_changes): ?>
						<?php $elapsed = tests::get_elapsed($current_test_changes) ?>
					<?php endif ?>
					<?php if ($elapsed): ?>
					<elapsed><?php echo  $elapsed ?></elapsed>
					<?php endif ?>
				<?php endif ?>
				<?php endif ?>
				<?php if ($can_defects): ?>
				<?php $defects = null ?>
				<?php if (fields::has_for_tests_and_template($project->id, $test->template_id, 'defects')): ?>
				<?php if ($current_test_changes): ?>
					<?php $defects = tests::get_defects($current_test_changes) ?>
				<?php endif ?>
				<?php if ($defects): ?>
				<defects><?php echo xml::encode( defects::format_nolinks($defects) )?></defects>
				<?php endif ?>
				<?php endif ?>
				<?php endif ?>
				<changes>
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
					<change>
						<createdon><?php echo  xml::format_datetime($change->created_on) ?></createdon>
						<?php $user = $GI->cache->get_object('user', $change->user_id) ?>
						<?php if ($user): ?>
						<createdby><?php echo xml::encode( $user->name )?></createdby>
						<?php endif ?>
						<status><?php echo xml::encode( tests::get_status_name($change->status_id) )?></status>
						<?php if ($change->assignedto_id): ?>
						<?php $user = $GI->cache->get_object('user', $change->assignedto_id) ?>
						<?php if ($user): ?>
						<assignedto><?php echo xml::encode( $user->name )?></assignedto>
						<?php endif ?>
						<?php else: ?>
						<assignedto></assignedto>
						<?php endif ?>
						<comment><?php echo xml::encode( $change->comment )?></comment>
						<?php if ($can_version) :?>
						<?php if (fields::has_for_tests_and_template($project->id, $test->template_id, 'version')): ?>
						<version><?php echo xml::encode( $change->version )?></version>
						<?php endif ?>
						<?php endif ?>
						<?php if ($can_elapsed) :?>
						<?php if (fields::has_for_tests_and_template($project->id, $test->template_id, 'elapsed')): ?>
						<elapsed><?php echo  $change->elapsed ?></elapsed>
						<?php endif ?>
						<?php endif ?>
						<?php if ($can_defects) :?>
						<?php if (fields::has_for_tests_and_template($project->id, $test->template_id, 'defects')): ?>
						<defects><?php echo xml::encode( defects::format_nolinks($change->defects) )?></defects>
						<?php endif ?>
						<?php endif ?>
						<?php $infos = fields::export_values(
							fields::filter_template(
								$test_fields,
								$test->template_id
							),
							$change,
							$exporter
						) ?>
						<?php if (count($infos) > 0): ?>
						<custom>
							<?php foreach ($infos as $info): ?>
							<<?php echo  $info->name ?>><?php echo  $info->value ?></<?php echo  $info->name ?>>
							<?php endforeach ?>
						</custom>
						<?php endif ?>
					</change>
					<?php endforeach ?>
				</changes>
			</test>
			<?php $test = $tests->peek() ?>
			<?php endwhile ?>
		</tests>
		<?php endif ?>
		<?php $next = $sections->peek() ?>
		<?php if ($next && $next->depth > $depth): ?>
		<?php
		$temp = array();
		$temp['depth'] = $depth + 1;
		$temp['sections'] = $sections;
		$temp['tests'] = $tests;
		$temp['test_changes'] = $test_changes;
		$temp['test_assocs'] = $test_assocs;
		$temp['case_assocs'] = $case_assocs;
		$temp['case_fields'] = $case_fields;
		$temp['test_fields'] = $test_fields;
		$temp['exporter'] = $exporter;
		$temp['milestone_lookup'] = $milestone_lookup;
		$GI->load->view('runs/export/xml_sections', $temp);
		?>
		<?php endif ?>
	</section>
<?php $section = $sections->peek() ?>
<?php endwhile ?>
</sections>
