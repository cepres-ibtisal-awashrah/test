<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php $case_columns_for_user = validation::get_plain('custom_cases_columns') ?>
<?php if (!$case_columns_for_user): ?>
	<?php $case_columns_for_user = array() ?>
<?php endif ?>

<?php
$temp['columns'] = $case_columns;
$temp['columns_for_user'] = $case_columns_for_user;
$GI->load->view('report_plugins/controls/columns/select/add_dialog', $temp);
?>

<?php
$GI->load->view('report_plugins/controls/runs/select/add_dialog');
?>

<?php
$GI->load->view('report_plugins/controls/runs/select/filter_bubble');
?>
