<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

$lang['reports_uws_meta_label'] = 'Workload Summary';
$lang['reports_uws_meta_group'] = 'Users';
$lang['reports_uws_meta_summary'] = 'Shows the current workload for users.';
$lang['reports_uws_meta_description'] = 'Shows the current workload for users for the entire project, a specific milestone or select test runs. Please see the Report Options section below to configure the report specific options.';

$lang['reports_uws_form_users'] = 'Users &amp; Details';
$lang['reports_uws_form_tests'] = 'Tests';
$lang['reports_uws_form_tests_limit'] = 'Maximum number of tests to display (per user):';
$lang['reports_uws_form_runs'] = 'Test Suites &amp; Runs';
$lang['reports_uws_form_runs_single'] = 'Sections &amp; Test Runs';
$lang['reports_uws_form_tests_details'] = 'Include the following details:';
$lang['reports_uws_form_tests_include_summary'] = 'An aggregated summary of estimates &amp; forecasts';
$lang['reports_uws_form_tests_include_tests'] = 'The test details per user';
$lang['reports_uws_form_tests_required'] = 'Please check at least one test option (summary or details).';
$lang['reports_uws_form_tests_statuses'] = 'Include the tests with the following statuses:';

$lang['reports_uws_runs_header'] = 'Test Runs';
$lang['reports_uws_runs_header_info'] = 'Shows the test runs used for computing the workload of the users.';
$lang['reports_uws_runs_more'] = 'There {0?{are}:{is}} {0} more {0?{test runs}:{test run}} that {0?{are}:{is}} not included.';
$lang['reports_uws_runs_empty'] = 'No test runs found.';

$lang['reports_uws_tests_more'] = 'There {0?{are}:{is}} {0} more {0?{tests}:{test}} that {0?{are}:{is}} not displayed.';

$lang['reports_uws_users_header'] = 'Users &amp; Todos';
$lang['reports_uws_users_header_info'] = 'Shows the users that are part of this report and their todos/assigned tests.';
$lang['reports_uws_users_user'] = 'User';
$lang['reports_uws_users_tests'] = 'Tests';
$lang['reports_uws_users_estimate'] = 'Estimate';
$lang['reports_uws_users_forecast'] = 'Forecast';
$lang['reports_uws_users_empty'] = 'No users found with todos.';

$lang['reports_uws_charts_bar_title'] = 'Workload per User';
$lang['reports_uws_charts_bar_hours'] = 'hours';
