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
$temp['suite'] = $suite;
$temp['sections'] = $sections;
$temp['cases'] = $cases;
$temp['case_assocs'] = $case_assocs;
$temp['case_fields'] = $case_fields;
$temp['exporter'] = export::create(TP_EXPORTER_XML);
$temp['milestone_lookup'] = $milestone_lookup;
$temp['caseStatusesEnabled'] = $caseStatusesEnabled;
$temp['isEnterprise'] = $isEnterprise;
$GI->load->view('suites/export/xml_content', $temp);
?>