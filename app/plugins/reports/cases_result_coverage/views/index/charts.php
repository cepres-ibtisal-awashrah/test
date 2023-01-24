<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php $statuses = $GI->cache->get_objects('status') ?>
<?php $statuses_reversed = array_reverse($statuses) ?>

<?php if ($show_comparison): ?>
<?php
$temp = array();
$temp['chart_id'] = 'chart0';
$temp['statuses'] = $statuses;
$temp['statuses_reversed'] = $statuses_reversed;
$temp['runs'] = $runs;
$temp['runs_reversed'] = $runs_reversed;
$temp['coverage'] = $coverage;
$temp['show_coverage'] = $show_coverage;
$temp['report'] = $report;
$GI->load->view('report_plugins/charts/comparison', $temp);
?>
<?php elseif ($show_coverage): ?>
<?php
$temp = array();
$temp['stats'] = $coverage;
$temp['statuses'] = $statuses;
$temp['report'] = $report;
$GI->load->view('report_plugins/charts/status', $temp);
?>
<?php endif ?>
