<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

$lang['report_plugins_header_comment'] = 'Project: {0}<br />By {1}, {2}';
$lang['report_plugins_footer_comment'] = 'Generated with TestRail <a target="_top" href="http://www.gurock.com/testrail/">test management</a> software &ndash; {0}<br />
		Report: {1} ({2}), by {3} (Version {4})';
$lang['report_plugins_footer_comment_no_author'] = 'Unknown';
$lang['report_plugins_footer_comment_no_version'] = 'Unknown';

$lang['report_plugins_cases_limit'] = 'Maximum number of test cases to display:';
$lang['report_plugins_cases_filter'] = 'Apply the following filter for the test cases:';
$lang['report_plugins_cases_filter_change'] = 'change';
$lang['report_plugins_cases_filter_title'] = 'Filter';
$lang['report_plugins_cases_filter_active'] = 'Active';
$lang['report_plugins_cases_filter_upcoming'] = 'Upcoming';
$lang['report_plugins_cases_filter_completed'] = 'Completed';

$lang['report_plugins_tests_limit'] = 'Maximum number of tests to display:';
$lang['report_plugins_tests_filter'] = 'Apply the following filter for the tests:';
$lang['report_plugins_tests_filter_change'] = 'change';
$lang['report_plugins_tests_filter_title'] = 'Filter';
$lang['report_plugins_tests_filter_active'] = 'Active';
$lang['report_plugins_tests_filter_upcoming'] = 'Upcoming';
$lang['report_plugins_tests_filter_completed'] = 'Completed';
$lang['report_plugins_tests_details'] = 'Include the following test details:';
$lang['report_plugins_tests_details_none'] = 'None';
$lang['report_plugins_tests_details_outline'] = 'Only the outline (default table view)';
$lang['report_plugins_tests_details_full'] = 'All details';
$lang['report_plugins_tests_include'] = 'Include the tests and test results in this report';

$lang['report_plugins_limit_all'] = 'All (may be slow)';
$lang['report_plugins_grouping_select'] = 'Group by the following attribute:';

$lang['report_plugins_columns_select_add'] = 'Add Column';
$lang['report_plugins_columns_select_column'] = 'Column';
$lang['report_plugins_columns_select_width'] = 'Width';
$lang['report_plugins_columns_select_intro'] = 'Include the following columns:';
$lang['report_plugins_columns_select_desc'] = 'You can use 0 as width to specify a variable-width column.';
$lang['report_plugins_columns_select_required'] = 'Please select at least one column.';

$lang['report_plugins_suites_select'] = 'Include the following test suites:';
$lang['report_plugins_suites_select_required'] = 'Please select at least one test suite.';
$lang['report_plugins_suites_select_include_all'] = 'All test suites';
$lang['report_plugins_suites_select_include_selected'] = 'The following test suites only:';
$lang['report_plugins_suites_select_selected_desc'] = 'You can select multiple test suites by holding Ctrl/Cmd on your keyboard.';
$lang['report_plugins_suites_select_invalid'] = 'You have selected one or more invalid test suites.';

$lang['report_plugins_sections_select'] = 'Include the following sections:';
$lang['report_plugins_sections_select_required'] = 'Please select at least one section.';
$lang['report_plugins_sections_select_include_all'] = 'All sections';
$lang['report_plugins_sections_select_include_selected'] = 'The following sections only:';
$lang['report_plugins_sections_select_selected_desc'] = 'You can select multiple sections by holding Ctrl/Cmd on your keyboard.';

$lang['report_plugins_users_select'] = 'Include the following users:';
$lang['report_plugins_users_select_required'] = 'Please select at least one user.';
$lang['report_plugins_users_select_include_all'] = 'All users';
$lang['report_plugins_users_select_include_selected'] = 'The following users only:';
$lang['report_plugins_users_select_selected_desc'] = 'You can select multiple users by holding Ctrl/Cmd on your keyboard.';

$lang['report_plugins_runs_limit'] = 'Maximum number of test runs to include (latest first):';
$lang['report_plugins_runs_select_add'] = 'Add Test Runs';
$lang['report_plugins_runs_select_add_empty'] = 'You need to select a test suite before you can add test runs.';
$lang['report_plugins_runs_select_suite'] = 'Please select a test suite:';
$lang['report_plugins_runs_select_include'] = 'Include the test results of:';
$lang['report_plugins_runs_select_include_all'] = 'All test runs';
$lang['report_plugins_runs_select_include_filter'] = 'The test runs that match the following filter (now and in the future):';
$lang['report_plugins_runs_select_include_selected'] = 'Only the following test runs:';
$lang['report_plugins_runs_select_filter_change'] = 'change';
$lang['report_plugins_runs_select_filter'] = 'Filter';
$lang['report_plugins_runs_select_filter_required'] = 'Please configure a filter for the test runs.';
$lang['report_plugins_runs_select_filter_invalid'] = 'You have configured an invalid test run filter.';
$lang['report_plugins_runs_select_ids_required'] = 'Please select at least one test run.';
$lang['report_plugins_runs_select_ids_invalid'] = 'You have selected one or more invalid test runs.';
$lang['report_plugins_runs_select_filter_apply'] = 'Apply Filter';
$lang['report_plugins_runs_select_filter_open'] = 'Open';
$lang['report_plugins_runs_select_filter_active'] = 'Active';
$lang['report_plugins_runs_select_filter_upcoming'] = 'Upcoming';
$lang['report_plugins_runs_select_filter_completed'] = 'Completed';
$lang['report_plugins_runs_select_filter_matches'] = '<strong>{0}</strong> {0?{test runs}:{test run}} found.';
$lang['report_plugins_runs_select_filter_matches_limited'] = '<strong>{0}</strong> {0?{test runs}:{test run}} found ({1} not displayed).';
$lang['report_plugins_runs_select_run'] = 'Test Run';
$lang['report_plugins_runs_select_run_completed'] = '(completed)';
$lang['report_plugins_runs_select_plan'] = 'Test Plan';
$lang['report_plugins_runs_select_milestone'] = 'Milestone';
$lang['report_plugins_runs_select_run_one'] = 'Please select at least one test run.';
$lang['report_plugins_runs_select_run_empty'] = 'There are no (more) test runs for the selected test suite and filtering options.';

$lang['report_plugins_runs_completed'] = '(completed)';
$lang['report_plugins_runs_config'] = 'Configuration';
$lang['report_plugins_runs_milestone'] = 'Milestone';
$lang['report_plugins_runs_plan'] = 'Test Plan';
$lang['report_plugins_runs_tests'] = 'Tests';
$lang['report_plugins_runs_defects'] = 'Defects';
$lang['report_plugins_runs_defects_comment'] = '<strong>{0}</strong> {0?{defects}:{defect}}';
$lang['report_plugins_runs_defects_tests_comment'] = '<strong>{0}</strong> {0?{defects}:{defect}} (<strong>{1}</strong> {1?{tests}:{test}})';

$lang['report_plugins_results_latest'] = 'Latest (Coverage)';
$lang['report_plugins_defects_combined'] = 'Combined';

$lang['report_plugins_statuses_select'] = 'Include the following statuses:';
$lang['report_plugins_statuses_select_required'] = 'Please select at least one status.';
$lang['report_plugins_statuses_select_include_all'] = 'All statuses';
$lang['report_plugins_statuses_select_include_selected'] = 'The following statuses only:';
$lang['report_plugins_statuses_select_selected_desc'] = 'You can select multiple statuses by holding Ctrl/Cmd on your keyboard.';

$lang['report_plugins_results_select'] = 'Include the following results:';
$lang['report_plugins_results_select_include_all'] = 'All test results of the tests';
$lang['report_plugins_results_select_include_latest'] = 'The latest test results per test only (current status)';

$lang['report_plugins_references_select'] = 'Include the following references:';
$lang['report_plugins_references_select_include_all'] = 'All references';
$lang['report_plugins_references_select_include_selected'] = 'The following references only:';
$lang['report_plugins_references_select_selected_desc'] = 'Please enter one reference ID per line.';
$lang['report_plugins_references_select_required'] = 'Please enter at least one reference ID.';

$lang['report_plugins_defects_select'] = 'Include the following defects:';
$lang['report_plugins_defects_select_include_all'] = 'All defects';
$lang['report_plugins_defects_select_include_selected'] = 'The following defects only:';
$lang['report_plugins_defects_select_selected_desc'] = 'Please enter one defect ID per line.';
$lang['report_plugins_defects_select_required'] = 'Please enter at least one defect ID.';

$lang['report_plugins_content_hide_links'] = 'Do not include links in report (useful when sharing reports)';

$lang['report_plugins_charts_comparison_title'] = 'Results per Test Run';
$lang['report_plugins_charts_comparison_title_full'] = 'Latest Results &amp; per Test Run';
$lang['report_plugins_charts_comparison_results_latest'] = 'Latest (Coverage)';

$lang['report_plugins_groupby_others'] = 'Others';

$lang['report_plugins_milestones_select'] = 'Use the following milestone:';
$lang['report_plugins_milestones_select_required'] = 'Please select a milestone.';
$lang['report_plugins_milestones_select_active'] = 'Active';
$lang['report_plugins_milestones_select_upcoming'] = 'Upcoming';
$lang['report_plugins_milestones_select_completed'] = 'Completed';
$lang['report_plugins_milestones_select_invalid'] = 'You have selected an invalid or deleted milestone.';

$lang['report_plugins_plans_select'] = 'Use the following test plan:';
$lang['report_plugins_plans_select_required'] = 'Please select a test plan.';
$lang['report_plugins_plans_select_active'] = 'Open';
$lang['report_plugins_plans_select_completed'] = 'Completed';
$lang['report_plugins_plans_select_invalid'] = 'You have selected an invalid or deleted test plan.';

$lang['report_plugins_activities_limit'] = 'Maximum number of activities to display:';
$lang['report_plugins_activities_include'] = 'Include the activities in this report';
$lang['report_plugins_history_limit'] = 'Maximum number of history items to display:';
$lang['report_plugins_progress_include'] = 'Include the progress in this report';
$lang['report_plugins_dateranges_select'] = 'Use the following time frame:';
