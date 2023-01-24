<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

$lang['reports_cst_meta_label'] = 'Status Tops';
$lang['reports_cst_meta_group'] = 'Cases';
$lang['reports_cst_meta_summary'] = 'Shows the test cases with the highest amount of results, grouped by status.';
$lang['reports_cst_meta_description'] = 'Shows the test cases with the highest amount of results for the selected statuses, grouped by status. Please see the Report Options section below to configure the report specific options.';

$lang['reports_cst_form_statuses'] = 'Statuses &amp; Results';
$lang['reports_cst_form_statuses_required'] = 'Please select at least one status.';

$lang['reports_cst_form_cases'] = 'Test Cases';
$lang['reports_cst_form_cases_limit'] = 'Maximum number of test cases to display (per status):';
$lang['reports_cst_form_runs'] = 'Test Suites &amp; Runs';
$lang['reports_cst_form_runs_single'] = 'Sections &amp; Test Runs';

$lang['reports_cst_tops_empty'] = 'No test cases found with this status.';
$lang['reports_cst_tops_more_cases'] = 'Found {0} more {0?{test cases}:{test case}} for this status that {0?{are}:{is}} not displayed.';
$lang['reports_cst_tops_count'] = 'Count';
$lang['reports_cst_tops_percent'] = 'Percent';
$lang['reports_cst_tops_total'] = 'Total';

$lang['reports_cst_charts_bar_title'] = 'Status Counts';

$lang['reports_cst_runs_header'] = 'Test Runs';
$lang['reports_cst_runs_header_info'] = 'Shows the test runs used for collecting the status counts for the requested project and test suites.';
$lang['reports_cst_runs_more'] = 'There {0?{are}:{is}} {0} more {0?{test runs}:{test run}} that {0?{are}:{is}} not included.';
$lang['reports_cst_runs_empty'] = 'No test runs found.';

$lang['reports_cst_statuses_header'] = 'Statuses';
$lang['reports_cst_statuses_header_info'] = 'Shows the test cases with the highest status counts for each status, for the requested project, test suites and test runs.';
$lang['reports_cst_statuses_latest_header'] = 'Statuses (latest results only)';
