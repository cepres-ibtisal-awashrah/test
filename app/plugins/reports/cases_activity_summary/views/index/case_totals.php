<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php $total_created = 0 ?>
<?php $total_updated = 0 ?>
<?php foreach ($case_groups as $group_id => $group_name): ?>
	<?php if ($cases_created): ?>
		<?php $total_created += arr::get($cases_created->case_counts, $group_id, 0) ?>
	<?php endif ?>
	<?php if ($cases_updated): ?>
		<?php $total_updated += arr::get($cases_updated->case_counts, $group_id, 0) ?>
	<?php endif ?>
<?php endforeach ?>
<?php $total_all = $total_created + $total_updated ?>
<?php arr::alternator() ?>
<table class="grid">
	<colgroup>
		<col></col>
		<?php if ($show_new): ?>
		<col style="width: 100px"></col>
		<?php endif ?>
		<?php if ($show_updated): ?>
		<col style="width: 100px"></col>
		<?php endif ?>
		<col style="width: 100px"></col>
	</colgroup>
	<tr class="header">
		<th><?php echo h( $case_groupby_name )?></th>
		<?php if ($show_new): ?>
		<th><?php echo  lang('reports_cas_cases_created') ?></th>
		<?php endif ?>
		<?php if ($show_updated): ?>
		<th><?php echo  lang('reports_cas_cases_updated') ?></th>
		<?php endif ?>
		<th><?php echo  lang('reports_cas_cases_percent') ?></th>
	</tr>
	<?php arr::alternator() ?>
	<?php foreach ($case_groups as $group_id => $group_name): ?>
		<?php $alt = arr::alternator('odd', 'even') ?>
		<tr class="row <?php echo  $alt ?>">
			<td><?php echo h( $group_name )?></td>
			<?php $total_group = 0 ?>
			<?php if ($show_new): ?>
				<?php $created = 0 ?>
				<?php if ($cases_created): ?>
					<?php $created = arr::get($cases_created->case_counts, $group_id, 0) ?>
				<?php endif ?>
				<td><?php echo  $created ?></td>
				<?php $total_group += $created ?>
			<?php endif ?>
			<?php if ($show_updated): ?>
				<?php $updated = 0 ?>
				<?php if ($cases_updated): ?>
					<?php $updated = arr::get($cases_updated->case_counts, $group_id, 0) ?>
				<?php endif ?>
				<td><?php echo  $updated ?></td>
				<?php $total_group += $updated ?>
			<?php endif ?>
			<td>
				<?php if ($total_all): ?>
					<?php $percent = (int) (($total_group * 100) / $total_all) ?>
					<?php echo  $percent ?>%
				<?php endif ?>
			</td>
		</tr>
	<?php endforeach ?>
</table>
