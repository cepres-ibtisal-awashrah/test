<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
// Execute the deferred queries and group the case/test assocs by the
// cases/tests for easy and fast lookup
$case_assocs = group::by_id($case_assocs->result(), 'case_id');
$test_assocs = group::by_id($test_assocs->result(), 'test_id');
?>
<run>
	<id><?php echo  entities::run_id($run->id) ?></id>
	<name><?php echo xml::encode( $run->name )?></name>
	<description><?php echo xml::encode( $run->description )?></description>
	<config><?php echo xml::encode( $run->config )?></config>
	<createdon><?php echo  xml::format_datetime($run->created_on) ?></createdon>
	<?php if ($run->is_completed): ?>
	<completed>true</completed>
	<completedon><?php echo  xml::format_datetime($run->completed_on) ?></completedon>
	<?php else: ?>
	<completed>false</completed>
	<?php endif ?>
	<milestone><?php echo xml::encode( $milestone ? $milestone->name : '' )?></milestone>
	<?php
	$temp = array();
	$temp['stats'] = $run;
	$GI->load->view('runs/export/xml_stats', $temp);
	?>
	<?php
	$temp = array();
	$temp['depth'] = 0;
	$temp['sections'] = $sections;
	$temp['tests'] = $tests;
	$temp['test_changes'] = $test_changes;
	$temp['test_assocs'] = $test_assocs;
	$temp['case_assocs'] = $case_assocs;
	$temp['case_fields'] = $case_fields;
	$temp['test_fields'] = $test_fields;
	$temp['milestone_lookup'] = $milestone_lookup;
	$temp['exporter'] = $exporter;
	$GI->load->view('runs/export/xml_sections', $temp);
	?>
</run>