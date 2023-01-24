<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

$lang['reports_rds_meta_label'] = 'Summary for References';
$lang['reports_rds_meta_group'] = 'Defects';
$lang['reports_rds_meta_summary'] = 'Shows the found defects for references in a coverage matrix.';
$lang['reports_rds_meta_description'] = 'Shows a summary of found defects for references and their test cases in a coverage matrix. Please see the Report Options section below to configure the report specific options.';

$lang['reports_rds_form_references'] = 'References';
$lang['reports_rds_form_runs'] = 'Test Suites &amp; Runs';
$lang['reports_rds_form_runs_single'] = 'Sections &amp; Test Runs';

$lang['reports_rds_form_cases'] = 'Test Cases';
$lang['reports_rds_form_cases_columns_extra'] = 'Also show:';
$lang['reports_rds_form_cases_columns_comparison'] = 'The defects for each selected test run / result <em>(comparison)</em>';
$lang['reports_rds_form_cases_columns_summary'] = 'The combined defect summary for the selected test runs <em>(summary)</em>';
$lang['reports_rds_form_cases_required'] = 'Please check at least one test case option (summary or comparison).';

$lang['reports_rds_ref_header'] = 'References &amp; Defects';
$lang['reports_rds_ref_header_info'] = 'Shows the references/requirements together with their test cases and defects in a coverage matrix for the requested project, test suites and test runs.';
$lang['reports_rds_ref_empty'] = 'No references found.';
$lang['reports_rds_ref_no_cases'] = 'No test cases.';
$lang['reports_rds_ref_more_references'] = 'There {0?{are}:{is}} {0} more {0?{references}:{reference}} that {0?{are}:{is}} not displayed.';
$lang['reports_rds_ref_more_cases'] = 'There {0?{are}:{is}} {0} more {0?{test cases}:{test case}} with references that {0?{are}:{is}} not displayed.';
$lang['reports_rds_ref_references'] = 'References';

$lang['reports_rds_runs_header'] = 'Test Runs';
$lang['reports_rds_runs_header_info'] = 'Shows the test runs used for the reference &amp; defect matrix for the requested project and test suites.';
$lang['reports_rds_runs_empty'] = 'No test runs found with defects.';
$lang['reports_rds_runs_more'] = 'There {0?{are}:{is}} {0} more {0?{test runs}:{test run}} for the test suite(s) that {0?{are}:{is}} not included.';
$lang['reports_rds_runs_help'] = 'The defect counts of the test runs only include the defects linked to the selected references and test cases.';

$lang['reports_rds_charts_bar_title_comparison'] = 'Defects per Run';
$lang['reports_rds_charts_bar_title_summary'] = 'References &amp; Defects';
$lang['reports_rds_charts_bar_title_full'] = 'Defects per Run &amp; Combined';

$lang['reports_rds_defects_combined'] = 'Latest &amp; Combined';
$lang['reports_rds_defects_summary'] = 'Combined (Summary)';
$lang['reports_rds_defects'] = 'Defects';
