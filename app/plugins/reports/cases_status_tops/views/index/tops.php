<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php if ($items): ?>
	<?php
	$temp = array();
	$temp['project'] = $project;
	$temp['items'] = $items;
	$temp['case_columns'] = $case_columns;
	$temp['case_columns_for_user'] = $case_columns_for_user;
	$temp['case_totals'] = $case_totals;
	$temp['case_fields'] = $case_fields;
	$temp['show_links'] = $show_links;
	$report_obj->render_view('index/grid', $temp);
	?>
	<?php if ($case_count > $case_count_partial): ?>
		<p class="partial">
			<?php echo  langf('reports_cst_tops_more_cases',
			$case_count - 
			$case_count_partial) ?>
		</p>
	<?php endif ?>
<?php else: ?>
	<p><?php echo  lang('reports_cst_tops_empty') ?></p>
<?php endif ?>