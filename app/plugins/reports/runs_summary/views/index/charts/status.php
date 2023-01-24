<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php $statuses = $GI->cache->get_objects('status') ?>

<?php
$temp = array();
$temp['stats'] = $stats;
$temp['statuses'] = $statuses;
$temp['report'] = $report;
$GI->load->view('report_plugins/charts/status', $temp);
?>
