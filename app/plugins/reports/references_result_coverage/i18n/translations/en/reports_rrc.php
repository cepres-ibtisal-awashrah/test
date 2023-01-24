<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

$lang['reports_rrc_meta_label'] = 'Comparison for References';
$lang['reports_rrc_meta_group'] = 'Results';
$lang['reports_rrc_meta_summary'] = 'Shows the results for references in a coverage & comparison matrix.';
$lang['reports_rrc_meta_description'] = 'Shows the results for references in a coverage & comparison matrix. Please see the Report Options section below to configure the report specific options.';

$lang['reports_rrc_form_references'] = 'References';
$lang['reports_rrc_form_runs'] = 'Test Suites &amp; Runs';
$lang['reports_rrc_form_runs_single'] = 'Sections &amp; Test Runs';

$lang['reports_rrc_form_cases'] = 'Test Cases';
$lang['reports_rrc_form_cases_columns_extra'] = 'Also show:';
$lang['reports_rrc_form_cases_columns_comparison'] = 'The test results for each selected test run / result <em>(comparison)</em>';
$lang['reports_rrc_form_cases_columns_coverage'] = 'The latest/combined test result for the selected test runs <em>(status)</em>';
$lang['reports_rrc_form_cases_required'] = 'Please check at least one test case option (status or comparison).';

$lang['reports_rrc_ref_header'] = 'References &amp; Results';
$lang['reports_rrc_ref_header_info'] = 'Shows the references/requirements together with their test cases and results in a coverage matrix for the requested project, test suites and test runs.';
$lang['reports_rrc_ref_more_references'] = 'There {0?{are}:{is}} {0} more {0?{references}:{reference}} that {0?{are}:{is}} not displayed.';
$lang['reports_rrc_ref_more_cases'] = 'There {0?{are}:{is}} {0} more {0?{test cases}:{test case}} with references that {0?{are}:{is}} not displayed.';
$lang['reports_rrc_ref_no_cases'] = 'No test cases.';
$lang['reports_rrc_ref_empty'] = 'No references found.';
$lang['reports_rrc_ref_references'] = 'References';

$lang['reports_rrc_results_latest'] = 'Latest (Coverage)';

$lang['reports_rrc_runs_header'] = 'Test Runs';
$lang['reports_rrc_runs_header_info'] = 'Shows the test runs used for the result comparison &amp; status for the requested project and test suites.';
$lang['reports_rrc_runs_more'] = 'There {0?{are}:{is}} {0} more {0?{test runs}:{test run}} for the test suite(s) that {0?{are}:{is}} not included.';
$lang['reports_rrc_runs_empty'] = 'No test runs found.';
$lang['reports_rrc_runs_help'] = 'The statistics and percent numbers of this report only include results for tests linked to the selected references and test cases.';
