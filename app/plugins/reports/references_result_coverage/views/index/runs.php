<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$temp = array();
$temp['runs'] = $runs;
$temp['run_rels'] = $run_rels;
$temp['show_links'] = $show_links;
$GI->load->view('report_plugins/runs/groups', $temp);
?>

<?php if ($show_comparison): ?>
	<?php $colgroups = array_merge(
		array(
			lang('reports_rrc_ref_references') => $reference_width
		),
		$case_columns_for_user
	) ?>
	<?php
	$temp = array();
	$temp['runs'] = $runs;
	$temp['runs_reversed'] = $runs_reversed;
	$temp['run_rels'] = $run_rels;
	$temp['run_width'] = $run_width;
	$temp['coverage'] = $coverage;
	$temp['colgroups'] = $colgroups;
	$temp['show_coverage'] = $show_coverage;
	$temp['show_links'] = $show_links;
	$GI->load->view('report_plugins/runs/comparison', $temp);
	?>
<?php endif ?>

<?php $run_count_partial = count($runs) ?>
<?php if ($run_count > $run_count_partial): ?>
	<p class="partial">
		<?php echo  langf('reports_rrc_runs_more',
		$run_count - 
		$run_count_partial) ?>
	</p>
<?php endif ?>
