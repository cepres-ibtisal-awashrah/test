<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php $case_ids = array_keys($items) ?>

<?php $case_lookup = obj::get_lookup(
	$report_helper->get_cases(
		$case_ids,
		$case_fields,
		$case_assocs,
		$case_rels
	)
) ?>

<table class="grid">
	<colgroup>
		<?php
		$temp = array();
		$temp['case_columns'] = $case_columns;
		$temp['case_columns_for_user'] = $case_columns_for_user;
		$GI->load->view('report_plugins/cases/grid/colgroups', $temp);
		?>
		<col style="width: 100px"></col>
		<col style="width: 100px"></col>
		<col style="width: 100px"></col>
	</colgroup>
	<tr class="header">
		<?php
		$temp = array();
		$temp['case_columns'] = $case_columns;
		$temp['case_columns_for_user'] = $case_columns_for_user;
		$GI->load->view('report_plugins/cases/grid/headers', $temp);
		?>
		<th class="w10"><?php echo  lang('reports_cst_tops_count') ?></th>
		<th class="w10"><?php echo  lang('reports_cst_tops_percent') ?></th>
		<th class="w10"><?php echo  lang('reports_cst_tops_total') ?></th>
	</tr>
	<?php arr::alternator() ?>
	<?php foreach ($items as $case_id => $status_count): ?>
		<?php $case = arr::get($case_lookup, $case_id) ?>
		<?php if ($case): ?>
			<?php $alt = arr::alternator('odd', 'even') ?>
			<tr class="row <?php echo  $alt ?>">
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
				<?php $total = arr::get($case_totals, $case_id, 0) ?>
				<td><?php echo  $status_count ?></td>
				<td>
				<?php if ($total > 0): ?>
					<?php echo  round(($status_count / $total) * 100) ?>%
				<?php endif ?>
				</td>
				<td><?php echo  $total ?></td>
			</tr>
		<?php endif ?>
	<?php endforeach ?>
</table>
