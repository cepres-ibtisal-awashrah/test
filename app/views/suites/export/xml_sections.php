<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php $project = projects::get_current() ?>
<?php $can_estimate = fields::has_for_cases($project->id, 'estimate') ?>
<?php $can_milestone = fields::has_for_cases($project->id, 'milestone_id') ?>
<?php $can_refs = fields::has_for_cases($project->id, 'refs') ?>
<sections>
<?php $section = $sections->peek() ?>
<?php while ($section && $section->depth >= $depth): ?>
	<?php $sections->next() ?>
	<section>
		<name><?php echo xml::encode( $section->name )?></name>
		<description><?php echo xml::encode( $section->description )?></description>
		<?php $case = $cases->peek() ?>
		<?php if ($case && $case->section_id == $section->id): ?>
		<cases>
			<?php while ($case && $case->section_id == $section->id): ?>
			<?php $cases->next() ?>
			<?php if (isset($case_assocs[$case->id])): ?>
				<?php $current_case_assocs = group::by_id_scalar(
					$case_assocs[$case->id]->items,
					'name',
					'value') ?>
				<?php foreach ($current_case_assocs as $key => $value): ?>
					<?php $case->$key = $value ?>
				<?php endforeach ?>
			<?php endif ?>
			<case>
				<id><?php echo  entities::case_id($case->id) ?></id>
				<title><?php echo xml::encode( $case->title )?></title>
				<?php $template = $GI->cache->get_object('template', $case->template_id) ?>
				<?php if ($template): ?>
				<template><?php echo xml::encode( $template->name )?></template>
				<?php endif ?>
				<?php $type = $GI->cache->get_object('case_type', $case->type_id) ?>
				<?php if ($type): ?>
				<type><?php echo xml::encode( $type->name )?></type>
				<?php endif ?>
				<?php $priority = $GI->cache->get_object('priority', $case->priority_id) ?>
				<?php if ($priority): ?>
				<priority><?php echo xml::encode( $priority->name )?></priority>
				<?php endif ?>
				<?php
				if ($caseStatusesEnabled && !empty($case->status_id)) {
					$status = $GI->cache->get_object(
						'case_status',
						$case->status_id
					);
					if ($status) {
						echo '<status>' . xml::encode($status->name) . "</status>\n";
					}
				}

				if ($isEnterprise && !empty($case->assigned_to_id)) {
					$assignee = $GI->cache->get_object(
						'user',
						$case->assigned_to_id
					);
					if ($assignee) {
						echo '<assignedto>' . xml::encode($assignee->name) . "</assignedto>\n";
					}
				}
				?>
				<?php if ($can_estimate): ?>
				<?php if (fields::has_for_cases_and_template($project->id, $case->template_id, 'estimate')): ?>
				<estimate><?php echo  $case->estimate ?></estimate>
				<?php endif ?>
				<?php endif ?>
				<?php if ($can_milestone): ?>
				<?php $milestone = null ?>
				<?php if (fields::has_for_cases_and_template($project->id, $case->template_id, 'milestone_id')): ?>
				<?php if ($case->milestone_id): ?>
					<?php $milestone = arr::get($milestone_lookup, $case->milestone_id) ?>
				<?php endif ?>
				<?php endif ?>
				<?php if ($milestone): ?>
				<milestone><?php echo xml::encode( $milestone->name )?></milestone>
				<?php endif ?>
				<?php endif ?>
				<?php if ($can_refs): ?>
				<?php if (fields::has_for_cases_and_template($project->id, $case->template_id, 'refs')): ?>
				<references><?php echo xml::encode( references::format_nolinks($case->refs) )?></references>
				<?php endif ?>
				<?php endif ?>
				<?php $infos = fields::export_values(
					fields::filter_template(
						$case_fields,
						$case->template_id
					),
					$case,
					$exporter
				) ?>
				<?php if (count($infos) > 0): ?>
				<custom>
					<?php foreach ($infos as $info): ?>
					<<?php echo  $info->name ?>><?php echo  $info->value ?></<?php echo  $info->name ?>>
					<?php endforeach ?>
				</custom>
				<?php endif ?>
			</case>
			<?php $case = $cases->peek() ?>
			<?php endwhile ?>
		</cases>
		<?php endif ?>
		<?php $next = $sections->peek() ?>
		<?php if ($next && $next->depth > $depth): ?>
		<?php
		$temp = array();
		$temp['depth'] = $depth + 1;
		$temp['sections'] = $sections;
		$temp['cases'] = $cases;
		$temp['case_assocs'] = $case_assocs;
		$temp['case_fields'] = $case_fields;
		$temp['exporter'] = $exporter;
		$temp['milestone_lookup'] = $milestone_lookup;
		$GI->load->view('suites/export/xml_sections', $temp);
		?>
		<?php endif ?>
	</section>
	<?php $section = $sections->peek() ?>
<?php endwhile ?>
</sections>
