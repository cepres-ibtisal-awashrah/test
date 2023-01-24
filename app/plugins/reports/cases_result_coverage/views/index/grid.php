<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php arr::alternator() ?>
<table class="grid">
	<colgroup>
		<?php
		$temp = array();
		$temp['case_columns'] = $case_columns;
		$temp['case_columns_for_user'] = $case_columns_for_user;
		$GI->load->view('report_plugins/cases/grid/colgroups', $temp);
		?>
		<?php if ($show_comparison): ?>
			<?php foreach ($runs_reversed as $run): ?>
				<col style="width: <?php echo  $run_width ?>px"></col>
			<?php endforeach ?>
		<?php endif ?>
		<?php if ($show_coverage): ?>
			<col style="width: <?php echo  $run_width ?>px"></col>
		<?php endif ?>
	</colgroup>
	<tr class="header">
		<?php
		$temp = array();
		$temp['case_columns'] = $case_columns;
		$temp['case_columns_for_user'] = $case_columns_for_user;
		$GI->load->view('report_plugins/cases/grid/headers', $temp);
		?>
		<?php if ($show_comparison): ?>
			<?php foreach ($runs_reversed as $run): ?>
				<th class="w30">
					<?php echo h( $run->name )?>
					<?php if ($run->config): ?>
					<br />
					<span class="secondary configuration">
						(<?php echo h( $run->config )?>)
					</span>
					<?php endif ?>
				</th>
			<?php endforeach ?>
		<?php endif ?>
		<?php if ($show_coverage): ?>
			<th class="w30"><?php echo  lang('reports_crc_results_latest') ?></th>
		<?php endif ?>
	</tr>
	<?php foreach ($items as $item_id): ?>
		<?php $case = arr::get($case_lookup, $item_id) ?>
		<?php if ($case): ?>
			<?php $alt = arr::alternator('odd', 'even') ?>
			<tr class="<?php echo  $alt ?>">
				<?php
				$temp = array();
				$temp['project'] = $project;
				$temp['case'] = $case;
				$temp['case_assocs'] = $case_assocs;
				$temp['case_fields'] = $case_fields;
				$temp['case_rels'] = $case_rels;
				$temp['case_columns'] = $case_columns;
				$temp['case_columns_for_user'] = $case_columns_for_user;
				$temp['show_links'] = $show_links;
				$GI->load->view('report_plugins/cases/grid/columns', $temp);
				?>
				<?php if ($show_comparison): ?>
					<?php foreach ($runs_reversed as $run): ?>
						<?php if (isset($results[$run->id][$case->id])): ?>
							<?php $result = $results[$run->id][$case->id] ?>
							<?php $status = $GI->cache->get_object('status', $result->status_id) ?>
						<?php else: ?>
							<?php $result = null ?>
							<?php $status = null ?>
						<?php endif ?>
						<?php if ($status && $result): ?>
							<?php if ($show_links): ?>
							<td><a target="_top" class="statusBoxLink" href="<?php echo  "%LINK%:/tests/view/$result->test_id" ?>"><span class="statusBox" style="<?php echo  tests::get_status_box_colors($status->color_dark) ?>"><?php echo h( $status->label )?></span></a></td>
							<?php else: ?>
							<td><span class="statusBox" style="<?php echo  tests::get_status_box_colors($status->color_dark) ?>"><?php echo h( $status->label )?></span></td>
							<?php endif ?>
						<?php else: ?>
							<td></td>
						<?php endif ?>
					<?php endforeach ?>
				<?php endif ?>
				<?php if ($show_coverage): ?>
					<?php if (isset($results_latest[$case->id])): ?>
						<?php $result = $results_latest[$case->id] ?>
						<?php $status = $GI->cache->get_object('status', $result->status_id) ?>
					<?php else: ?>
						<?php $result = null ?>
						<?php $status = null ?>
					<?php endif ?>
					<?php if ($status && $result): ?>
						<?php if ($show_links): ?>
						<td><a target="_top" class="statusBoxLink" href="<?php echo  "%LINK%:/tests/view/$result->test_id" ?>"><span class="statusBox" style="<?php echo  tests::get_status_box_colors($status->color_dark) ?>"><?php echo h( $status->label )?></span></a></td>
						<?php else: ?>
						<td><span class="statusBox" style="<?php echo  tests::get_status_box_colors($status->color_dark) ?>"><?php echo h( $status->label )?></span></td>
						<?php endif ?>
					<?php else: ?>
						<td></td>
					<?php endif ?>
				<?php endif ?>
			</tr>
		<?php endif ?>
	<?php endforeach ?>
</table>