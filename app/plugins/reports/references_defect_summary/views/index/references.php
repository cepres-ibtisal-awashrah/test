<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php $limit_reached = false ?>

<?php $colspan_no_case = count($case_columns_for_user) ?>
<?php if ($show_comparison): ?>
	<?php $colspan_no_case += count($runs) ?>
<?php endif ?>
<?php if ($show_summary): ?>
	<?php $colspan_no_case++ ?>
<?php endif ?>

<?php $statuses = $GI->cache->get_objects('status') ?>

<table class="grid">
	<colgroup>
		<col style="width: 125px"></col>
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
		<th class="references"><?php echo  lang('reports_rds_ref_references') ?></th>
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
			<th class="w30"><?php echo  lang('reports_rds_defects_combined') ?></th>
		<?php endif ?>
	</tr>
	<?php $case_chunk_size = 250 ?>
	<?php $case_chunk_ix = 0 ?>
	<?php arr::alternator() ?>
	<?php foreach ($references->content as $reference_id => $case_ids): ?>
		<?php $i = 0 ?>
		<?php $alt = arr::alternator('odd', 'even') ?>
		<?php if ($case_ids): ?>
		<?php foreach ($case_ids as $case_id): ?>
			<?php if (!isset($case_chunk)): ?>
				<?php $case_chunk_ids = array_slice(
					$references->case_ids,
					$case_chunk_ix,
					$case_chunk_size
				) ?>
				<?php if (!$case_chunk_ids): ?>
					<?php break ?>
				<?php endif ?>
				<?php $case_chunk = $report_helper->get_cases(
					$case_chunk_ids,
					$case_fields,
					$case_assocs,
					$case_rels
				) ?>
				<?php $case_lookup = obj::get_lookup($case_chunk) ?>
			<?php endif ?>
			<tr class="<?php echo  $alt ?>">
				<?php $case = arr::get($case_lookup, $case_id) ?>
				<td>
				<?php if ($i == 0): ?>
					<?php if ($show_links): ?>
						<?php $refs = references::format(
							h($reference_id), 
							$project) ?>
					<?php else: ?>
						<?php $refs = references::format_nolinks(
							h($reference_id)
						) ?>
					<?php endif ?>
					<?php if ($refs): ?>
						<?php echo  $refs ?>
					<?php endif ?>
				<?php endif ?>
				</td>
				<?php if ($case): ?>
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
				<?php else: ?>
					<td colspan="<?php echo  $colspan_no_case ?>"></td>
				<?php endif ?>
			</tr>
			<?php $i++ ?>
			<?php $case_chunk_ix++ ?>
			<?php if ($case_limit): ?>
				<?php if ($case_chunk_ix >= $case_limit): ?>
					<?php $limit_reached = true ?>
					<?php break ?>
				<?php endif ?>
			<?php endif ?>
			<?php if (($case_chunk_ix % $case_chunk_size) == 0): ?>
				<?php unset($case_chunk) ?>
				<?php unset($case_assocs) ?>
				<?php unset($case_rels) ?>
				<?php unset($case_lookup) ?>
			<?php endif ?>
		<?php endforeach ?>
		<?php else: ?>
			<tr class="<?php echo  $alt ?>">
				<td>
					<?php if ($show_links): ?>
						<?php $refs = references::format(
							h($reference_id),
							$project) ?>
					<?php else: ?>
						<?php $refs = references::format_nolinks(
							h($reference_id)
						) ?>
					<?php endif ?>
					<?php if ($refs): ?>
						<?php echo  $refs ?>
					<?php endif ?>				
				</td>
				<td colspan="<?php echo  $colspan_no_case ?>"><em><?php echo  lang('reports_rds_ref_no_cases') ?></em></td>
			</tr>
		<?php endif ?>
	<?php endforeach ?>
</table>

<?php if ($limit_reached): ?>
	<?php if ($references->reference_count == $references->reference_count_partial): ?>
		<?php if ($references->case_count > $references->case_count_partial): ?>
			<p class="partial">
				<?php echo  langf('reports_rds_ref_more_cases',
				$references->case_count - 
				$references->case_count_partial) ?>
			</p>
		<?php endif ?>
	<?php else: ?>
		<p class="partial">
			<?php echo  langf('reports_rds_ref_more_references',
				$references->reference_count - 
				$references->reference_count_partial) ?>
		</p>
	<?php endif ?>
<?php endif ?>
