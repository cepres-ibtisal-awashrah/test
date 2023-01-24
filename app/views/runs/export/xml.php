<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$filename = $filename . '.xml';
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Content-Type: ' . mime::get_type($filename));
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
?>
<?php echo  '<?xml version="1.0" encoding="UTF-8"?>' ?>

<?php
$temp = array();
$temp['run'] = $run;
$temp['sections'] = $sections;
$temp['tests'] = $tests;
$temp['test_changes'] = $test_changes;
$temp['test_assocs'] = $test_assocs;
$temp['case_assocs'] = $case_assocs;
$temp['milestone'] = $milestone;
$temp['milestone_lookup'] = $milestone_lookup;
$temp['case_fields'] = $case_fields;
$temp['test_fields'] = $test_fields;
$temp['exporter'] = export::create(TP_EXPORTER_XML);
$GI->load->view('runs/export/xml_content', $temp);
?>