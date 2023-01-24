<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php $show_change = !isset($show_change) || $show_change ?>
<?php arr::alternator() ?>
<table class="grid">
	<colgroup>
		<?php if ($show_change): ?>
		<col style="width: 75px"></col>
		<?php endif ?>
		<?php
		$temp = array();
		$temp['case_columns'] = $case_columns;
		$temp['case_columns_for_user'] = $case_columns_for_user;
		$GI->load->view('report_plugins/cases/grid/colgroups', $temp);
		?>
	</colgroup>
	<tr class="header">
		<?php if ($show_change): ?>
		<th><?php echo  lang('reports_cas_cases_change') ?></th>
		<?php endif ?>
		<?php
		$temp = array();
		$temp['case_columns'] = $case_columns;
		$temp['case_columns_for_user'] = $case_columns_for_user;
		$GI->load->view('report_plugins/cases/grid/headers', $temp);
		?>
	</tr>
	<?php foreach ($case_ids as $case_id): ?>
		<?php $case = arr::get($case_lookup, $case_id) ?>
		<?php if ($case): ?>
			<?php $alt = arr::alternator('odd', 'even') ?>
			<tr class="<?php echo  $alt ?>">
				<?php if ($show_change): ?>
				<?php $is_created = isset($case_ids_created_lookup[$case_id]) ?>
				<?php $is_updated = isset($case_ids_updated_lookup[$case_id]) ?>
				<td>
					<?php if ($is_created && $is_updated): ?>
					<span class="statusBox" style="background: #2f7ed8"><?php echo  lang('reports_cas_cases_created_short') ?></span>
					<span class="statusBox" style="background: #8bbc21"><?php echo  lang('reports_cas_cases_updated_short') ?></span>
					<?php elseif ($is_created): ?>
					<span class="statusBox" style="background: #2f7ed8"><?php echo  lang('reports_cas_cases_created') ?></span>
					<?php elseif ($is_updated): ?>
					<span class="statusBox" style="background: #8bbc21"><?php echo  lang('reports_cas_cases_updated') ?></span>
					<?php endif ?>
				</td>
				<?php endif ?>
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
			</tr>
		<?php endif ?>
	<?php endforeach ?>
</table>