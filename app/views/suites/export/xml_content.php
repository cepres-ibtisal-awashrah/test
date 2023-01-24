<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
// Execute the deferred query and group the case assocs by the cases
// for easy and fast lookup
$case_assocs = group::by_id($case_assocs->result(), 'case_id');
?>
<suite>
	<id><?php echo  entities::suite_id($suite->id) ?></id>
	<name><?php echo xml::encode( $suite->name )?></name>
	<description><?php echo xml::encode( $suite->description )?></description>
	<?php
	$temp = array();
	$temp['depth'] = 0;
	$temp['suite'] = $suite;
	$temp['sections'] = $sections;
	$temp['cases'] = $cases;
	$temp['case_assocs'] = $case_assocs;
	$temp['case_fields'] = $case_fields;
	$temp['exporter'] = export::create(TP_EXPORTER_XML);
	$temp['milestone_lookup'] = $milestone_lookup;
	$temp['caseStatusesEnabled'] = $caseStatusesEnabled;
	$temp['isEnterprise'] = $isEnterprise;
	$GI->load->view('suites/export/xml_sections', $temp);
	?>
</suite>