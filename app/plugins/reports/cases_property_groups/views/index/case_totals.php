<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php arr::alternator() ?>
<table class="grid">
	<colgroup>
		<col></col>
		<col style="width: 100px"></col>
		<col style="width: 100px"></col>
	</colgroup>
	<tr class="header">
		<th><?php echo h( $case_groupby_name )?></th>
		<th><?php echo  lang('reports_cpg_cases_count') ?></th>
		<th><?php echo  lang('reports_cpg_cases_percent') ?></th>
	</tr>
	<?php arr::alternator() ?>
	<?php foreach ($case_groups as $group): ?>
		<?php $alt = arr::alternator('odd', 'even') ?>
		<tr class="row <?php echo  $alt ?>">
			<td><?php echo h( $group->name )?></td>
			<td><?php echo  $group->case_count ?></td>
			<?php if ($case_count_total > 0): ?>
			<td><?php echo  (int) (($group->case_count / $case_count_total) * 100) ?>%</td>
			<?php else: ?>
			<td></td>
			<?php endif ?>
		</tr>
	<?php endforeach ?>
</table>
