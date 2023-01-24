<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$temp = array();
$temp['filename'] = $filename;
$temp['columns'] = $columns;
$temp['fields_csv'] = $fields_csv;
$GI->load->view('runs/export/csv_header', $temp);
?>
<?php
$temp = array();
$temp['exporter'] = export::create(TP_EXPORTER_CSV);
$temp['run'] = $run;
$temp['plan'] = $plan;
$temp['sections'] = $sections;
$temp['section_lookup'] = isset($sections_all) && $sections_all ?
	obj::get_lookup($sections_all->result()) : array();
$temp['cases'] = $cases;
$temp['tests'] = $tests;
$temp['test_changes'] = $test_changes;
$temp['test_assocs'] = $test_assocs;
$temp['case_assocs'] = $case_assocs;
$temp['columns'] = $columns;
$temp['layout'] = $layout;
$temp['fields'] = $fields;
$temp['fields_csv'] = $fields_csv;
$temp['milestone_lookup'] = $milestone_lookup;
$temp['separator'] = ',';
$temp['separated_steps_new_lines'] = $separated_steps_new_lines;
$GI->load->view('runs/export/csv_sections', $temp);
?>
