<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php if (isset($case_assocs[$case->id])): ?>
	<?php $current_case_assocs = group::by_id_scalar(
		$case_assocs[$case->id]->items,
		'name',
		'value') ?>
	<?php foreach ($current_case_assocs as $key => $value): ?>
		<?php $case->$key = $value ?>
	<?php endforeach ?>
<?php endif ?>
<?php /* Don't override included fields variable (stays in scope) */ ?>
<?php $_fields = fields::filter_template($fields, $case->template_id) ?>
<?php $top = isset($top) && $top ?>
<div class="page">
	<h3 class="<?php echo  $top ? 'top' : '' ?>"><?php echo  entities::case_id($case->id) ?>: <?php echo h( $case->title )?></h3>
	<div class="io-container">
	<table class="io">
		<tr>
			<td style="width: 25%"> 
				<label><?php echo  lang('layout_grid_type') ?></label> 
				<?php $type = $GI->cache->get_object('case_type', $case->type_id) ?>
				<?php if ($type): ?>
					<?php echo h( $type->name )?> 
				<?php else: ?>
					<?php echo  lang('layout_none') ?>
				<?php endif ?>
			</td> 			
			<td style="width: 25%">
				<label><?php echo  lang('layout_grid_priority') ?></label>
				<?php $priority = $GI->cache->get_object('priority', $case->priority_id) ?>
				<?php if ($priority): ?>
					<?php echo h( $priority->name )?> 
				<?php else: ?>
					<?php echo  lang('layout_none') ?>
				<?php endif ?>
			</td>
			<?php $i = 2 ?>
			<?php if (fields::has_for_cases_and_template($project->id, $case->template_id, 'estimate')): ?>
			<td style="width: 25%">
				<label><?php echo  lang('layout_grid_estimate') ?></label>
				<?php $timespan = timespan::format_long($case->estimate) ?>
				<?php if ($timespan): ?>
					<?php echo  $timespan ?>
				<?php else: ?>
					<?php echo  lang('layout_none') ?>
				<?php endif ?>
			</td>
			<?php $i++ ?>
			<?php endif ?>
			<?php if (fields::has_for_cases_and_template($project->id, $case->template_id, 'milestone_id')): ?>
			<td style="width: 25%"> 
				<label><?php echo  lang('layout_grid_milestone') ?></label> 
				<?php $milestone = null ?>
				<?php if ($case->milestone_id): ?>
					<?php $milestone = arr::get($milestone_lookup, $case->milestone_id) ?>
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
			<?php if (fields::has_for_cases_and_template($project->id, $case->template_id, 'refs')): ?>
			<td style="width: 25%">
				<label><?php echo  lang('layout_grid_references') ?></label>
				<?php $references = null ?>
				<?php if ($case->refs): ?>
					<?php $references = references::format_nolinks(
						h($case->refs)
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
			<?php $infos = fields::print_values($_fields, $case, TP_LOCATION_TOP) ?>
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
	<?php $infos = fields::print_values($_fields, $case, TP_LOCATION_BOTTOM) ?>
	<?php if (count($infos) > 0): ?>
		<?php foreach ($infos as $info): ?>
			<h4><?php echo h( $info->label )?></h4>
			<?php echo  $info->value ?>
		<?php endforeach ?>
	<?php else: ?>
		<p><?php echo  lang('cases_description_empty') ?></p>
	<?php endif ?>
</div>
