<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php $groups = array() ?>
<?php foreach ($runs as $run): ?>
	<?php $group = arr::get($groups, $run->entry_id) ?>
	<?php if (!$group): ?>
		<?php $group = obj::create() ?>
		<?php $group->name = $run->name ?>
		<?php $group->items = array() ?>
		<?php $groups[$run->entry_id] = $group ?>
	<?php endif ?>
	<?php $group->items[] = $run ?>
<?php endforeach ?>
<?php $top = isset($top) && $top ?>

<?php $is_first = true ?>
<?php $is_last = count($groups) == 1 ?>
<?php $i = 0 ?>
<?php foreach ($groups as $group): ?>
	<div class="dateSection <?php echo  $is_first && $top ? 'top' : '' ?>">
		<span class="title">
			<?php echo h( $group->name )?> (<?php echo  count($group->items) ?>) 
		</span>
	</div>
	<table class="grid" style="margin-bottom: 2em">
		<colgroup>
			<col class="icon"></col>
			<col></col>
			<col class="percent"></col>
		</colgroup>
		<?php arr::alternator() ?>
		<?php foreach ($group->items as $run): ?>
			<?php $alt = arr::alternator('odd', 'even') ?>
			<tr class="<?php echo  $alt ?>" id="run-<?php echo  $run->id ?>">
				<td class="icon">
					<img src="%RESOURCE%:images/report-assets/run16.svg"
						width="16" height="16" alt="" />
				</td>
				<td>
					<?php if ($show_links): ?>	
						<a target="_top" href="<?php echo  "%LINK%:/runs/view/$run->id" ?>"><?php echo h( $run->name )?></a>
					<?php else: ?>
						<?php echo h( $run->name )?>
					<?php endif ?>			
					<?php if ($run->config): ?>
						<span class="secondary configuration">(<?php echo h( $run->config )?>)</span>
					<?php endif ?>
					<?php if ($run->is_completed): ?>
						<span class="secondary"><?php echo  lang('report_plugins_runs_completed') ?></span>
					<?php endif ?>
				</td>
				<td class="secondary percent <?php echo  $run->passed_percent == 100 ? 'percentSmall' : '' ?>">
						<strong><?php echo  $run->passed_percent ?>%</strong>	
				</td>
			</tr>
		<?php endforeach ?>
	</table>
	<?php $is_first = false ?>
	<?php $i++ ?>
	<?php $is_last = $i + 1 == count($groups) ?>
<?php endforeach ?>
