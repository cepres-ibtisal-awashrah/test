<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

$lang['reports_cpg_meta_label'] = 'Property Distribution';
$lang['reports_cpg_meta_group'] = 'Cases';
$lang['reports_cpg_meta_summary'] = 'Shows the test cases grouped by a selectable attribute.';
$lang['reports_cpg_meta_description'] = 'Shows a summary of test cases, grouped by a selectable attribute. Please see the Report Options section below to configure the report specific options.';

$lang['reports_cpg_form_grouping'] = 'Grouping';

$lang['reports_cpg_form_cases'] = 'Test Cases';
$lang['reports_cpg_form_cases_groupby'] = 'Group the test cases by:';
$lang['reports_cpg_form_suites'] = 'Test Suites';
$lang['reports_cpg_form_sections'] = 'Sections';

$lang['reports_cpg_form_cases_details'] = 'Include the following details:';
$lang['reports_cpg_form_cases_include_summary'] = 'An aggregated summary of groups';
$lang['reports_cpg_form_cases_include_cases'] = 'The test case details per group';
$lang['reports_cpg_form_cases_limit'] = 'Maximum number of test cases to display (per group):';
$lang['reports_cpg_form_cases_required'] = 'Please check at least one test case option (summary or details).';

$lang['reports_cpg_suites_header'] = 'Test Suites';
$lang['reports_cpg_suites_header_info'] = 'Shows the list of test suites that are used for this report.';
$lang['reports_cpg_suites_empty'] = 'No test suites found.';

$lang['reports_cpg_cases_header'] = 'Test Cases';
$lang['reports_cpg_cases_cases'] = 'Test Cases';
$lang['reports_cpg_cases_header_info'] = 'Shows the test cases for the configured project and test suites, grouped by the selected attribute.';
$lang['reports_cpg_cases_name'] = 'Name';
$lang['reports_cpg_cases_count'] = 'Count';
$lang['reports_cpg_cases_percent'] = 'Percent';
$lang['reports_cpg_cases_empty'] = 'No groups found.';
$lang['reports_cpg_cases_more'] = 'There {0?{are}:{is}} {0} more {0?{test cases}:{test case}} in this group that {0?{are}:{is}} not displayed.';

$lang['reports_cpg_cases_groupby_template'] = 'Template';
$lang['reports_cpg_cases_groupby_priority'] = 'Priority';
$lang['reports_cpg_cases_groupby_type'] = 'Type';
$lang['reports_cpg_cases_groupby_milestone'] = 'Milestone';
$lang['reports_cpg_cases_groupby_createdby'] = 'Created By';
$lang['reports_cpg_cases_groupby_unknown'] = 'Unknown';

$lang['reports_cpg_charts_bar_title'] = 'Test Cases by {0}';
