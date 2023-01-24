<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$temp = array();
$temp['project'] = $project;
$temp['case_ids'] = $items;
$temp['case_lookup'] = $case_lookup;
$temp['case_assocs'] = $case_assocs;
$temp['case_fields'] = $case_fields;
$temp['case_rels'] = $case_rels;
$temp['case_columns'] = $case_columns;
$temp['case_columns_for_user'] = $case_columns_for_user;
$temp['show_links'] = $show_links;
$GI->load->view('report_plugins/cases/grid', $temp);
?>