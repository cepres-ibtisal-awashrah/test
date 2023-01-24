<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$section->_parent = $parent;
$section->_shown = false;
$section->_index = 1;
?>
<?php $next = $sections->peek() ?>
<?php
$temp = array();
$temp['project'] = $project;
$temp['section'] = $section;
$temp['tests'] = $tests;
$temp['test_changes'] = $test_changes;
$temp['test_assocs'] = $test_assocs;
$temp['case_assocs'] = $case_assocs;
$temp['format'] = $format;
$temp['case_fields'] = $case_fields;
$temp['test_fields'] = $test_fields;
$temp['fields'] = $fields;
$temp['columns'] = $columns;
$temp['columns_for_user'] = $columns_for_user;
$temp['milestone_lookup'] = $milestone_lookup;
$GI->load->view('runs/print/' . $format, $temp);
?>
<?php while ($next && $next->depth > $section->depth): ?>
	<?php $sections->next() ?>
	<?php
	$temp = array();
	$temp['project'] = $project;
	$temp['parent'] = $section;
	$temp['section'] = $next;
	$temp['sections'] = $sections;
	$temp['tests'] = $tests;
	$temp['test_changes'] = $test_changes;
	$temp['test_assocs'] = $test_assocs;
	$temp['case_assocs'] = $case_assocs;
	$temp['format'] = $format;
	$temp['case_fields'] = $case_fields;
	$temp['test_fields'] = $test_fields;
	$temp['fields'] = $fields;
	$temp['columns'] = $columns;
	$temp['columns_for_user'] = $columns_for_user;
	$temp['milestone_lookup'] = $milestone_lookup;
	$GI->load->view('runs/print/section', $temp);
	?>	
	<?php $next = $sections->peek() ?>
<?php endwhile ?>
