<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

$lang['reports_rcc_meta_label'] = 'Coverage for References';
$lang['reports_rcc_meta_group'] = 'Cases';
$lang['reports_rcc_meta_summary'] = 'Shows the test case coverage for references in a coverage matrix.';
$lang['reports_rcc_meta_description'] = 'Shows the test case coverage for references in a coverage matrix. Please see the Report Options section below to configure the report specific options.';

$lang['reports_rcc_form_references'] = 'References';

$lang['reports_rcc_form_cases'] = 'Test Cases';
$lang['reports_rcc_form_cases_intro'] = 'Include the following test cases:';
$lang['reports_rcc_form_cases_refs'] = 'Test cases with references';
$lang['reports_rcc_form_cases_norefs'] = 'Test cases without references';
$lang['reports_rcc_form_cases_required'] = 'Please check at least one test case option (with or without references).';

$lang['reports_rcc_form_suites'] = 'Test Suites';
$lang['reports_rcc_form_sections'] = 'Sections';

$lang['reports_rcc_ref_header'] = 'References';
$lang['reports_rcc_ref_header_info'] = 'Shows the references/requirements together with their test cases in a coverage matrix for the requested project and test suites.';
$lang['reports_rcc_ref_more_references'] = 'There {0?{are}:{is}} {0} more {0?{references}:{reference}} that {0?{are}:{is}} not displayed.';
$lang['reports_rcc_ref_more_cases'] = 'There {0?{are}:{is}} {0} more {0?{test cases}:{test case}} with references that {0?{are}:{is}} not displayed.';
$lang['reports_rcc_ref_no_cases'] = 'No test cases.';
$lang['reports_rcc_ref_empty'] = 'No references found.';
$lang['reports_rcc_ref_references'] = 'References';

$lang['reports_rcc_noref_header'] = 'Test cases without references';
$lang['reports_rcc_noref_header_info'] = 'Shows the test cases that don\'t have any references/requirements for the requested project and test suites, grouped by test suites and sections.';
$lang['reports_rcc_noref_more_suites'] = 'There {0?{are}:{is}} {0} more {0?{test suites}:{test suite}} that {0?{are}:{is}} not displayed.';
$lang['reports_rcc_noref_more_cases_and_suites'] = 'There {0?{are}:{is}} {0} more {0?{test cases}:{test case}} in this test suite that {0?{are}:{is}} not displayed (+{1} additional {1?{test suites}:{test suite}}).';
$lang['reports_rcc_noref_more_cases'] = 'There {0?{are}:{is}} {0} more {0?{test cases}:{test case}} in this test suite that {0?{are}:{is}} not displayed.';
$lang['reports_rcc_noref_more_cases_single'] = 'There {0?{are}:{is}} {0} more {0?{test cases}:{test case}} that {0?{are}:{is}} not displayed.';
$lang['reports_rcc_noref_empty'] = 'There are no test cases without references for the selected scope (project and test suites).';
$lang['reports_rcc_noref_suites_comment'] = '<strong>{0}</strong> {0?{test cases}:{test case}}';
$lang['reports_rcc_noref_suites_comment_na'] = 'Not displayed';

$lang['reports_rcc_charts_pie_title'] = 'Reference Coverage';
$lang['reports_rcc_charts_pie_covered'] = 'Covered';
$lang['reports_rcc_charts_pie_notcovered'] = 'Not Covered';
$lang['reports_rcc_charts_bar_title'] = 'References and Test Cases';
$lang['reports_rcc_charts_bar_references'] = 'References';
$lang['reports_rcc_charts_bar_cases_refs'] = 'Cases w/ References';
$lang['reports_rcc_charts_bar_cases_norefs'] = 'Cases w/o References';
