<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>

<?php if ($test_groupby == 'tests:status_id'): ?>
<?php $status = $GI->cache->get_object('status', $group->id) ?>
<h2>
<?php if ($status): ?>
<div style="margin-right: 5px; float: left; height: 16px; width: 16px; border-radius: 8px; <?php echo  tests::get_status_box_colors($status->color_dark) ?>"></div>
<?php endif ?>
<?php echo h( $group->label )?></h2>
<?php else: ?>
<h2><?php echo h( $group->name )?></h2>
<?php endif ?>

<?php $test_ids_combined = array() ?>
<?php foreach ($tests as $run_id => $test_ids): ?>
	<?php arr::append($test_ids_combined, $test_ids) ?>
<?php endforeach ?>

<?php $test_lookup = obj::get_lookup(
	$report_helper->get_tests(
		$test_ids_combined,
		$case_fields,
		$test_fields,
		$case_assocs,
		$case_rels,
		$test_assocs,
		$result_assocs
	)
) ?>

<?php foreach ($tests as $run_id => $test_ids): ?>
	<?php $run = arr::get($run_lookup, $run_id) ?>
	<?php if ($run): ?>
		<h3>
		<?php if ($show_links): ?>
		<a target="_top" href="<?php echo  "%LINK%:/runs/view/$run->id" ?>"><?php echo h( $run->name )?></a>
		<?php else: ?>
		<?php echo h( $run->name )?>
		<?php endif ?>
		<?php if ($run->is_completed): ?>
		<span class="secondary"><?php echo  lang('report_plugins_runs_completed') ?></span>
		<?php endif ?>
		<?php if ($run->config): ?>
		<span class="configuration">(<?php echo h( $run->config )?>)</span>
		<?php endif ?>
		<span class="secondary">(<?php echo  count($test_ids) ?>)</span>
		</h3>
		<?php
		$temp = array();
		$temp['project'] = $project;
		$temp['test_ids'] = $test_ids;
		$temp['test_lookup'] = $test_lookup;
		$temp['test_columns'] = $test_columns;
		$temp['test_columns_for_user'] = $test_columns_for_user;
		$temp['test_fields'] = $test_fields;
		$temp['test_assocs'] = $test_assocs;
		$temp['case_fields'] = $case_fields;
		$temp['case_assocs'] = $case_assocs;
		$temp['case_rels'] = $case_rels;
		$temp['result_assocs'] = $result_assocs;
		$temp['show_links'] = $show_links;
		$GI->load->view('report_plugins/tests/grid', $temp);
		?>
	<?php endif ?>
<?php endforeach ?>

<?php $test_count_partial = count($test_ids_combined) ?>
<?php if ($test_count > $test_count_partial): ?>
	<p class="partial">
		<?php echo  langf('reports_tpg_tests_more',
		$test_count - 
		$test_count_partial) ?>
	</p>
<?php endif ?>
