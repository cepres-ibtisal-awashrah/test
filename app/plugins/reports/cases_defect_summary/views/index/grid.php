<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php $statuses = $GI->cache->get_objects('status') ?>

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
		<?php if ($show_summary): ?>
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
		<?php if ($show_summary): ?>
			<th class="w30"><?php echo  lang('reports_cds_defects_combined') ?></th>
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
							<?php $status = arr::get($statuses, $result->status_id) ?>
						<?php else: ?>
							<?php $result = null ?>
							<?php $status = null ?>
						<?php endif ?>
						<?php $defects_for_case = null ?>
						<?php if (isset($defects[$run->id][$case->id])): ?>
							<?php $defects_for_case = $defects[$run->id][$case->id] ?>
						<?php endif ?>
						<td class="sub">
							<?php if ($defects_for_case): ?>
								<?php if ($status && $result): ?>
									<?php if ($show_links): ?>
									<a target="_top" class="statusBoxLink" href="<?php echo  "%LINK%:/tests/view/$result->test_id" ?>"><span class="statusBox" style="<?php echo  tests::get_status_box_colors($status->color_dark) ?>">&nbsp;&nbsp;</span></a>
									<?php else: ?>
									<span class="statusBox" style="<?php echo  tests::get_status_box_colors($status->color_dark) ?>">&nbsp;&nbsp;</span>
									<?php endif ?>
								<?php endif ?>
								<?php $defects_for_case_str = str::join($defects_for_case, ', ') ?>
								<?php if ($show_links): ?>
									<?php $defects_str = defects::format(
										h($defects_for_case_str),
										$project
									) ?>
								<?php else: ?>
									<?php $defects_str = defects::format_nolinks(
										h($defects_for_case_str)
									) ?>
								<?php endif ?>
								<?php echo  $defects_str ?>
							<?php endif ?>
						</td>
					<?php endforeach ?>
				<?php endif ?>
				<?php if ($show_summary): ?>
					<?php if (isset($results_latest[$case->id])): ?>
						<?php $result = $results_latest[$case->id] ?>
						<?php $status = arr::get($statuses, $result->status_id) ?>
					<?php else: ?>
						<?php $result = null ?>
						<?php $status = null ?>
					<?php endif ?>
					<?php $defects_for_case = null ?>
					<?php if (isset($defects_summary[$case->id])): ?>
						<?php $defects_for_case = $defects_summary[$case->id] ?>
					<?php endif ?>
					<td class="sub">
						<?php if ($defects_for_case): ?>
							<?php if ($status && $result): ?>
								<?php if ($show_links): ?>
								<a target="_top" class="statusBoxLink" href="<?php echo  "%LINK%:/tests/view/$result->test_id" ?>"><span class="statusBox" style="<?php echo  tests::get_status_box_colors($status->color_dark) ?>">&nbsp;&nbsp;</span></a>
								<?php else: ?>
								<span class="statusBox" style="<?php echo  tests::get_status_box_colors($status->color_dark) ?>">&nbsp;&nbsp;</span>
								<?php endif ?>
							<?php endif ?>
							<?php $defects_for_case_str = str::join($defects_for_case, ', ') ?>
							<?php if ($show_links): ?>
								<?php $defects_str = defects::format(
									h($defects_for_case_str),
									$project
								) ?>
							<?php else: ?>
								<?php $defects_str = defects::format_nolinks(
									h($defects_for_case_str)
								) ?>
							<?php endif ?>
							<?php echo  $defects_str ?>
						<?php endif ?>
					</td>
				<?php endif ?>
			</tr>
		<?php endif ?>
	<?php endforeach ?>
</table>