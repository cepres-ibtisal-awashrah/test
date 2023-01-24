<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$temp = array();
$temp['filename'] = $filename;
$temp['columns'] = $columns;
$temp['fields_csv'] = $fields_csv;
$temp['separator_hint'] = $separator_hint;
$GI->load->view('runs/export/excel_header', $temp);
?>
<?php
$temp = array();
$temp['exporter'] = export::create(TP_EXPORTER_CSV);
$temp['run'] = $run;
$temp['plan'] = $plan;
$temp['sections'] = $sections;
$temp['section_lookup'] = isset($sections_all) && $sections_all ?
	obj::get_lookup($sections_all->result()) : array();
$temp['tests'] = $tests;
$temp['cases'] = $cases;
$temp['test_changes'] = $test_changes;
$temp['test_assocs'] = $test_assocs;
$temp['case_assocs'] = $case_assocs;
$temp['columns'] = $columns;
$temp['layout'] = $layout;
$temp['fields'] = $fields;
$temp['fields_csv'] = $fields_csv;
$temp['milestone_lookup'] = $milestone_lookup;
$temp['separator'] = $GI->i18n->get_locale_value('list_separator');
$temp['separated_steps_new_lines'] = $separated_steps_new_lines;
$GI->load->view('runs/export/csv_sections', $temp);
?>
