<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

$lang['reports_cds_meta_label'] = 'Summary for Cases';
$lang['reports_cds_meta_group'] = 'Defects';
$lang['reports_cds_meta_summary'] = 'Shows the found defects for test cases in a coverage matrix.';
$lang['reports_cds_meta_description'] = 'Shows a summary of found defects for test cases in a coverage matrix. Please see the Report Options section below to configure the report specific options.';

$lang['reports_cds_form_cases'] = 'Test Cases';
$lang['reports_cds_form_cases_columns_extra'] = 'Also show:';
$lang['reports_cds_form_cases_columns_comparison'] = 'The defects for each selected test run / result <em>(comparison)</em>';
$lang['reports_cds_form_cases_columns_summary'] = 'The combined defect summary for the selected test runs <em>(summary)</em>';
$lang['reports_cds_form_cases_required'] = 'Please check at least one test case option (summary or comparison).';

$lang['reports_cds_form_runs'] = 'Test Suite &amp; Runs';
$lang['reports_cds_form_runs_single'] = 'Sections &amp; Test Runs';

$lang['reports_cds_runs_header'] = 'Test Runs';
$lang['reports_cds_runs_header_info'] = 'Shows the test runs used for the defect matrix for the requested project and test suite.';
$lang['reports_cds_runs_empty'] = 'No test runs found with defects.';
$lang['reports_cds_runs_more'] = 'There {0?{are}:{is}} {0} more {0?{test runs}:{test run}} for the test suite(s) that {0?{are}:{is}} not included.';
$lang['reports_cds_runs_help'] = 'The defect counts of this report only include the defects of the test cases that match the selected filters, if any.';

$lang['reports_cds_suite_header'] = 'Comparison &amp; Summary';
$lang['reports_cds_suite_header_info'] = 'Shows the test cases together with their defects as columns, for the requested project, test suite and test runs, grouped by section.';
$lang['reports_cds_suite_more_cases'] = 'There {0?{are}:{is}} {0} more {0?{test cases}:{test case}} in this test suite that {0?{are}:{is}} not displayed.';
$lang['reports_cds_suite_empty'] = 'No test cases found.';

$lang['reports_cds_defects'] = 'Defects';
$lang['reports_cds_defects_combined'] = 'Latest &amp; Combined';
$lang['reports_cds_defects_summary'] = 'Combined (Summary)';

$lang['reports_cds_charts_bar_title'] = 'Defects per Run';
$lang['reports_cds_charts_bar_title_summary'] = 'Defects';
$lang['reports_cds_charts_bar_title_full'] = 'Defects per Run &amp; Combined';
