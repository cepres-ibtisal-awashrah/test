<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php arr::alternator() ?>
<table class="grid">
	<colgroup>
		<col></col>
		<col style="width: 125px"></col>
		<col style="width: 125px"></col>
		<col style="width: 100px"></col>
	</colgroup>
	<tr class="header">
		<th><?php echo  lang('reports_uws_users_user') ?></th>
		<th><?php echo  lang('reports_uws_users_forecast') ?></th>
		<th><?php echo  lang('reports_uws_users_estimate') ?></th>
		<th><?php echo  lang('reports_uws_users_tests') ?></th>
	</tr>
	<?php arr::alternator() ?>
	<?php foreach ($users as $user): ?>
		<?php $estimate = arr::get($user_estimates, $user->id) ?>
		<?php if ($estimate && $estimate->test_count): ?>
		<?php $alt = arr::alternator('odd', 'even') ?>		
		<tr class="row <?php echo  $alt ?>">
			<td><?php echo h( $user->name )?></td>
			<td>
				<?php if ($estimate->total_forecast): ?>
					<?php echo  timespan::format_short($estimate->total_forecast) ?>
				<?php else: ?>
					0
				<?php endif ?>
			</td>
			<td>
				<?php if ($estimate->total_estimate): ?>
					<?php echo  timespan::format_short($estimate->total_estimate) ?>
				<?php else: ?>
					0
				<?php endif ?>
			</td>
			<td><?php echo  $estimate->test_count ?></td>
		</tr>
		<?php endif ?>
	<?php endforeach ?>
</table>
