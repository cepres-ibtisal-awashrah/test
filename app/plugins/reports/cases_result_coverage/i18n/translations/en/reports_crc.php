<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

$lang['reports_crc_meta_label'] = 'Comparison for Cases';
$lang['reports_crc_meta_group'] = 'Results';
$lang['reports_crc_meta_summary'] = 'Shows the results for test cases in a coverage & comparison matrix.';
$lang['reports_crc_meta_description'] = 'Shows the results for test cases in a coverage & comparison matrix. Please see the Report Options section below to configure the report specific options.';

$lang['reports_crc_form_cases'] = 'Test Cases';
$lang['reports_crc_form_cases_columns_extra'] = 'Also show:';
$lang['reports_crc_form_cases_columns_comparison'] = 'The test results for each selected test run / result <em>(comparison)</em>';
$lang['reports_crc_form_cases_columns_coverage'] = 'The latest/combined test result for the selected test runs <em>(status)</em>';
$lang['reports_crc_form_cases_required'] = 'Please check at least one test case option (status or comparison).';

$lang['reports_crc_form_runs'] = 'Test Suite &amp; Runs';
$lang['reports_crc_form_runs_single'] = 'Sections &amp; Test Runs';

$lang['reports_crc_runs_header'] = 'Test Runs';
$lang['reports_crc_runs_header_info'] = 'Shows the test runs used for the result comparison &amp; status for the requested project and test suite.';
$lang['reports_crc_runs_more'] = 'There {0?{are}:{is}} {0} more {0?{test runs}:{test run}} for the test suite that {0?{are}:{is}} not included.';
$lang['reports_crc_runs_empty'] = 'No test runs found.';
$lang['reports_crc_runs_help'] = 'The statistics and percent numbers of this report only include the test cases that match the selected filters, if any.';

$lang['reports_crc_results_latest'] = 'Latest (Coverage)';

$lang['reports_crc_suite_header'] = 'Comparison &amp; Coverage';
$lang['reports_crc_suite_header_info'] = 'Shows the test cases together with their test results as columns, for the requested project, test suite and test runs, grouped by section.';
$lang['reports_crc_suite_more_cases'] = 'There {0?{are}:{is}} {0} more {0?{test cases}:{test case}} in this test suite that {0?{are}:{is}} not displayed.';
$lang['reports_crc_suite_empty'] = 'No test cases found.';
