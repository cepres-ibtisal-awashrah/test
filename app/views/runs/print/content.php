<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$temp = array();
$temp['run'] = $run;
$temp['milestone'] = $milestone;
$temp['show_dates'] = !isset($show_dates) || $show_dates;
$GI->load->view('runs/print/start', $temp);
$devCnt = $run_id ?? '';
?>
<div id="groupContainer<?php echo  $devCnt ?>">
    <h1><?php echo  lang('pages_cases') ?></h1>
    <div id="groupContent<?php echo  $devCnt ?>"></div>
</div>