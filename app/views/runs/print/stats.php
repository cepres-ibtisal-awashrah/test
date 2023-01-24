<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php $statuses = $GI->cache->get_objects('status') ?>
<div class="gridContainer" style="margin-bottom: 1.5em">
	<table class="grid">
		<colgroup>
			<col style="width: 20%"></col>
			<col style="width: 20%"></col>
			<col style="width: 20%"></col>
			<col style="width: 20%"></col>
			<col style="width: 20%"></col>
		</colgroup>
		<?php $statuses_to_include = array() ?>
		<?php foreach ($statuses as $status): ?>
			<?php $prop_count = $status->system_name . '_count' ?>
			<?php if ($status->is_active || $stats->$prop_count > 0): ?>
				<?php $statuses_to_include[] = $status ?>
			<?php endif ?>			
		<?php endforeach ?>
		<?php $status_chunks = array_chunk($statuses_to_include, 5) ?>
		<?php foreach ($status_chunks as $status_chunk): ?>
		<tr class="header">
			<?php foreach ($status_chunk as $status): ?>
			<th><?php echo h( $status->label) ?></th>
			<?php endforeach ?>
			<?php $i = count($status_chunk) ?>
			<?php while ($i < 5): ?>
				<th></th>
				<?php $i++ ?>
			<?php endwhile ?>
		</tr>
		<tr>
			<?php foreach ($status_chunk as $status): ?>
			<?php $prop_count = $status->system_name . '_count' ?>
			<?php $prop_percent = $status->system_name . '_percent' ?>
			<td><?php echo  $stats->$prop_percent?>% (<?php echo  $stats->$prop_count ?>/<?php echo  $stats->total_count ?>)</td>
			<?php endforeach ?>
			<?php $i = count($status_chunk) ?>
			<?php while ($i < 5): ?>
				<td></td>
				<?php $i++ ?>
			<?php endwhile ?>
		</tr>
		<?php endforeach ?>
	</table>
</div>