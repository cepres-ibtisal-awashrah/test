<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$lang['runs_overview_open'] = 'Open';
$lang['runs_overview_active'] = 'Active';
$lang['runs_overview_active_empty'] = 'No active test runs in this project.';
$lang['runs_overview_upcoming'] = 'Upcoming';
$lang['runs_overview_completion_pending'] = 'Completion Pending';
$lang['runs_overview_completed'] = 'Completed';
$lang['runs_overview_activity'] = 'Activity';
$lang['runs_overview_tests'] = 'Tests';
$lang['runs_overview_allactive'] = 'All Active';

$lang['runs_overview_display'] = 'Display';
$lang['runs_overview_display_large'] = 'Detail View';
$lang['runs_overview_display_large_desc'] = 'Displays the test runs and plans with many details. Useful if you have just a few runs/plans.';
$lang['runs_overview_display_medium'] = 'Medium View';
$lang['runs_overview_display_medium_desc'] = 'Displays the test runs and plans in a medium-sized way.';
$lang['runs_overview_display_small'] = 'Compact View';
$lang['runs_overview_display_small_desc'] = 'Displays the test runs and plans as a compact list. Useful if you have many runs/plans.';
$lang['runs_included'] = 'Included';
$lang['runs_references'] = 'References';
$lang['runs_refs_desc'] = 'Add reference ID\'s to external tickets here.' ;

$lang['runs_view_display'] = 'Display';
$lang['runs_view_display_tree'] = 'All groups and tests';
$lang['runs_view_display_tree_name'] = 'All';
$lang['runs_view_display_subtree'] = 'Selected group and subgroups';
$lang['runs_view_display_subtree_name'] = 'Subgroups';
$lang['runs_view_display_compact'] = 'Selected group only';
$lang['runs_view_display_compact_name'] = 'Selected';
$lang['runs_view_todos'] = 'Showing only the tests for the following users:';
$lang['runs_view_todos_plus'] = '(+{0} other {0?{users}:{user}})';
$lang['runs_view_todos_clear'] = '(<a href="{0}" class="link">show all again</a>)';

$lang['runs_is_plan'] = '(Plan)';
$lang['runs_namespace'] = 'Test Run Namespace';
$lang['runs_run'] = 'Test Run';
$lang['runs_config'] = 'Configuration';
$lang['runs_ids'] = 'Test Run IDs';
$lang['runs_user_ids'] = 'User IDs';
$lang['runs_return_location'] = 'Return Location';
$lang['runs_loadall'] = 'Load All';
$lang['runs_overview_groupby'] = 'Group By';
$lang['runs_overview_orderby'] = 'Order By';
$lang['runs_tabs_run'] = 'Run';
$lang['runs_tabs_cases'] = 'Cases';
$lang['runs_runreport'] = 'Reports';
$lang['runs_loading'] = 'Loading tests ..';
$lang['runs_offset'] = 'Offset';
$lang['runs_expands'] = 'Group Expands';

$lang['runs_reports_defects'] = 'Defects';
$lang['runs_reports_defects_summary'] = 'Summary';
$lang['runs_reports_defects_summary_hint'] = 'Shows a summary of found defects for this test run.';
$lang['runs_reports_defects_cases_summary'] = 'Summary for Cases';
$lang['runs_reports_defects_cases_summary_hint'] = 'Shows a summary of found defects for this test run per test case &amp; test.';
$lang['runs_reports_defects_references_summary'] = 'Summary for References';
$lang['runs_reports_defects_references_summary_hint'] = 'Shows a summary of found defects for the references (requirements, user stories, etc.) in this test run.';

$lang['runs_reports_run'] = 'Run';
$lang['runs_reports_run_summary'] = 'Summary';
$lang['runs_reports_run_summary_hint'] = 'Shows a full summary &amp; overview of this test run with statistics as well as activity and progress details.';

$lang['runs_reports_results'] = 'Results';
$lang['runs_reports_results_property_groups'] = 'Property Distribution';
$lang['runs_reports_results_property_groups_hint'] = 'Shows the distribution and groups for a specific test attribute (e.g. priority, type or status) for this test run.';
$lang['runs_reports_results_case_coverage'] = 'Comparison for Cases';
$lang['runs_reports_results_case_coverage_hint'] = 'Shows the results in this test run per test case (result coverage &amp; comparison).';
$lang['runs_reports_results_reference_coverage'] = 'Comparison for References';
$lang['runs_reports_results_reference_coverage_hint'] = 'Shows the results for the references (requirements, user stories, etc.) in this test run (result coverage &amp; comparison).';

$lang['runs_reports_users'] = 'Users';
$lang['runs_reports_users_workload_summary'] = 'Workload Summary';
$lang['runs_reports_users_workload_summary_hint'] = 'Shows the workload summary, estimates and forecasts for users in this test run.';

$lang['runs_group_by'] = 'Group By';
$lang['runs_group_by_none'] = 'Section';
$lang['runs_group_by_reset'] = 'Reset grouping to sections.';
$lang['runs_group_by_reset_menu'] = 'Reset to sections';
$lang['runs_group_order'] = 'Group Order';
$lang['runs_group_id'] = 'Group ID';

$lang['runs_status_ids'] = 'Status IDs';
$lang['runs_stats'] = 'Stats';
$lang['runs_case_ids'] = 'Case IDs';
$lang['runs_case_filter'] = 'Case Filter';
$lang['runs_filter'] = 'Filter';

$lang['runs_cases_select'] = 'Select';
$lang['runs_cases_select_all'] = 'All';
$lang['runs_cases_select_none'] = 'None';
$lang['runs_cases_select_filter'] = 'By Filter';
$lang['runs_delete_select_all'] = 'Select all';
$lang['runs_delete_selected'] = 'Delete selected';
$lang['runs_tooltip_text'] = 'Delete this run/plan';
$lang['runs_delete_confirm'] = 'Really delete this run/plan? This irrevocably deletes this run for all users and cannot be undone.';

$lang['runs_cases_select_title'] = 'Select Cases';
$lang['runs_cases_select_one'] = 'Please select at least one test case.';
$lang['runs_cases_select_info_all_short'] = 'All included (<a class="link" {0}>select</a>)';
$lang['runs_cases_select_info_specific'] = '<strong>{0}</strong> {0?{test cases}:{test case}} included (<a class="link" {1}>select cases</a> or <a class="link" {2}>include all</a>)';
$lang['runs_cases_select_info_specific_short'] = '<strong>{0}</strong> {0?{cases}:{case}} included (<a class="link" {1}>all</a>)';
$lang['runs_cases_select_assignedto'] = 'Assigned To: ';
$lang['runs_cases_select_assignedto_link'] = 'change';
$lang['runs_cases_select_description'] = 'Description';
$lang['runs_cases_select_data'] = 'Description & References';
$lang['runs_cases_select_description_set'] = '<a class="link" {0}>set</a>';
$lang['runs_cases_select_description_change'] = 'Change';
$lang['runs_cases_select_config_assignedto_select'] = '<a class="link" {0}>select</a>';
$lang['runs_cases_select_config_include_select_or_all'] = '<a class="link" {0}>select</a> or <a class="link" {1}>all</a>';
$lang['runs_cases_select_info_all_dynamic'] = 'All cases included (<a class="link" {0}>select cases</a> or <a class="link" {1}>dynamic filters</a>)';
$lang['runs_cases_select_info_specific_dynamic'] = '<strong>{0}</strong> {0?{test cases}:{test case}} included (<a class="link" {1}>select cases</a>, <a class="link" {2}>include all</a> or <a class="link" {3}>dynamic filters</a>)';
$lang['runs_cases_change_info_specific_dynamic'] = '<strong>{0}</strong> {0?{test cases}:{test case}} included (<a class="link" {1}>select cases</a>, <a class="link" {2}>include all</a> or <a class="link" {3}>change filters</a>)';
$lang['runs_cases_select_config_include_dynamic'] = '<a class="link" {0}>select</a>, <a class="link" {1}>all</a> or <a class="link" {2}>dynamic</a>';

$lang['runs_softlock'] = 'Not saved: this test run has been changed by other users';
$lang['runs_softlock_desc'] = 'This run has been modified since you opened it
(by <em>{0}</em> on <em>{1}</em>, and possibly others). You can <a target="_blank" href="{2}">review the changes</a>
and still save the run. Please note that this will override all changes made by other users.';
$lang['runs_softlock_force'] = 'Yes, override all made changes and save my version';

$lang['runs_dialogs_width'] = 'Width';
$lang['runs_dialogs_height'] = 'Height';

$lang['runs_columns'] = 'Columns';
$lang['runs_partial'] = 'Is Partial';
$lang['runs_include_sidebar'] = 'Include Sidebar';

$lang['runs_tests_toolbar_sorted'] = 'Sort:';
$lang['runs_tests_toolbar_filter'] = 'Filter:';

$lang['runs_filter_reset'] = 'Remove filter and show all tests.';
$lang['runs_filter_none'] = 'None';
$lang['runs_filter_group_active'] = 'Active';
$lang['runs_filter_group_upcoming'] = 'Upcoming';
$lang['runs_filter_group_completed'] = 'Completed';
$lang['runs_filter_empty'] = 'No tests found.';

$lang['runs_success_add'] = 'Successfully added the new test run.';
$lang['runs_success_delete'] = 'Successfully deleted the test run.';
$lang['runs_success_close'] = 'Successfully closed the test run.';
$lang['runs_success_subscribe'] = 'Successfully subscribed to the test run.';
$lang['runs_success_unsubscribe'] = 'Successfully unsubscribed from the test run.';
$lang['runs_error_subscribe'] = 'An error occurred while subscribing to the test run.';
$lang['runs_error_unsubscribe'] = 'An error occurred while unsubscribing from the test run.';
$lang['runs_error_add'] = 'An error occurred while adding the new test run.';
$lang['runs_error_delete'] = 'An error occurred while deleting the test run. Maybe the test run didn\'t exist anymore?';
$lang['runs_error_close'] = 'An error occurred while closing the test run. Maybe the test run didn\'t exist anymore?';
$lang['runs_error_exists'] = 'The specified test run does not exist or you do not have the permission to access it.';
$lang['runs_success_update'] = 'Successfully updated the test run.';
$lang['runs_error_update'] = 'An error occurred while saving the test run.';
$lang['runs_error_no_tests'] = 'include_all is false but no tests were provided.';
$lang['runs_completed'] = '<strong>This test run is completed.</strong> You can no longer modify this test run or add new test results.';
$lang['runs_completed_short'] = '(completed)';

$lang['runs_summary_and'] = ' and ';
$lang['runs_invalid_milestone'] = 'The Milestone field is invalid (unknown format or milestone).';
$lang['runs_invalid_user'] = 'The Assign To field is invalid (unknown format or user).';
$lang['runs_invalid_assignedto_id'] = 'Field :assignedto_id is not a valid ID.';
$lang['runs_empty_run_id'] = 'Field :run_id is a test plan entry. Please use update_plan_entry instead.';
$lang['runs_denied_edit_without_plan']= 'Field :run_id does not belong to a test plan entry.';
$lang['runs_no_case_selected'] = 'Please select at least one test case.';
$lang['runs_box'] = 'Test Run';
$lang['runs_name'] = 'Name';
$lang['runs_name_default'] = 'Test Run {0}';
$lang['runs_name_desc'] = 'Either reuse the test suite name or specify a new one.';
$lang['runs_name_desc_master'] = 'Ex: <em>Test Run 2014-08-01</em>, <em>Build 240</em> or <em>Version 3.0</em>';
$lang['runs_assignto'] = 'Assign To';
$lang['runs_assignto_me'] = 'Me';
$lang['runs_assignto_desc'] = 'The user to whom the tests of the new test run should initially be assigned.
An email is sent to the user if email notifications are enabled.';
$lang['runs_created_by'] = 'Created By';
$lang['runs_created_on'] = 'Created On';
$lang['runs_assignedto'] = 'Assigned To';
$lang['runs_plan'] = 'Test Plan';
$lang['runs_milestone'] = 'Milestone';
$lang['runs_milestone_desc'] = 'The milestone this test run belongs to.';
$lang['runs_description'] = 'Description';
$lang['runs_description_edit'] = 'Edit Description';
$lang['runs_description_desc'] = 'Use this description to describe the purpose of this test run.';
$lang['runs_description_desc_reuse'] = 'Use this description to describe the purpose of this test run.
You can also <a class="link" {0}>reuse the description</a> of the test suite.';
$lang['runs_is_completed'] = 'Is Completed';
$lang['runs_completed_on'] = 'Completed On';

$lang['runs_actions'] = 'Actions';
$lang['runs_delete'] = 'Delete Test Run';
$lang['runs_delete_link'] = 'Delete this test run';
$lang['runs_delete_descr'] = 'Delete this test run to remove it from your project.';
$lang['runs_delete_confirm'] = 'Really delete this test run? This also deletes all tests and results in this run and cannot be undone.';
$lang['runs_delete_confirm_checkbox'] = 'Yes, delete this test run (cannot be undone)';
$lang['runs_delete_confirm_extra'] = 'You will irrevocably delete at least <strong>{0}</strong> {0?{tests}:{test}} and the related test results &amp; comments.';
$lang['runs_print_confirm'] = 'This test run contains {0} tests. The <em>Details</em> view will generate hundreds of pages and may be slow. Continue?';

$lang['runs_close'] = 'Close Test Run';
$lang['runs_close_link'] = 'Close this test run';
$lang['runs_close_descr'] = 'Archive this test run to prevent future modifications to its tests and results.';
$lang['runs_close_hint'] = 'Close Run';
$lang['runs_close_hint_desc'] = 'Closes this test run to archive its tests and results. Prevents future modifications.';
$lang['runs_close_confirm'] = 'Really close this test run? This operation cannot be undone.';
$lang['runs_close_confirm_long'] = 'Really close this test run? Closing a test run archives the related tests and prevents future modifications. This change cannot be undone.';

$lang['runs_new'] = 'Add Test Run';
$lang['runs_add'] = 'Add Test Run';
$lang['runs_save'] = 'Save Test Run';

$lang['runs_case_selection'] = 'Case Selection';
$lang['runs_case_selection_short'] = 'Cases';
$lang['runs_include_all'] = 'Include all test cases';
$lang['runs_include_all_short'] = 'Include all';
$lang['runs_include_all_desc'] = 'Select this option to include all test cases in this test run. If new test cases are added to the test suite, they are also automatically included in this run.';
$lang['runs_include_all_desc_master'] = 'Select this option to include all test cases in this test run. If new test cases are added to the repository, they are also automatically included in this run.';
$lang['runs_include_specific'] = 'Select specific test cases';
$lang['runs_include_specific_short'] = 'Select cases';
$lang['runs_include_specific_info'] = '<strong>{0}</strong> {0?{test cases}:{test case}} included (<a class="" {1}>change selection</a>)';
$lang['runs_include_specific_desc'] = 'You can alternatively select the test cases to include in this test run.
New test cases are not automatically added to this run in this case.';
$lang['runs_dynamic_filters'] = 'Dynamic Filters';
$lang['runs_include_dynamic'] = 'Dynamic Filtering';
$lang['runs_include_dynamic_help'] = 'Read more about Dynamic Filtering in our User Guide.';
$lang['runs_include_dynamic_info'] = '<strong>{0}</strong> {0?{test cases}:{test case}} included (<a class="" {1}>change filter</a>)';
$lang['runs_include_dynamic_desc'] = 'Automatically add test cases based on filter selection. New test cases are automatically added to the run if they match the filter (unless the run is closed).';

$lang['runs_sidebar_query'] = 'Query';
$lang['runs_sidebar_query_desc'] = 'Group your tests by:';
$lang['runs_sidebar_groups'] = 'Groups';
$lang['runs_sidebar_groups_desc'] = 'The following groups are available:';
$lang['runs_sidebar_groupby'] = 'Group By';
$lang['runs_sidebar_runs_grouping'] = 'Group By';
$lang['runs_sidebar_runs_ordering'] = 'Order By';

$lang['runs_sidebar_tests'] = 'Tests &amp; Results';
$lang['runs_sidebar_activity'] = 'Activity';
$lang['runs_sidebar_createdbyon'] = 'Created by {0} on {1}.';
$lang['runs_sidebar_createdbyon_milestone'] = 'Created by {0}. Belongs to milestone <a href="{1}">{2}</a>.';
$lang['runs_sidebar_completedon'] = 'Completed on {0}.';
$lang['runs_sidebar_completedon_milestone'] = 'Completed on {0}. Belongs to milestone <a href="{1}">{2}</a>.';
$lang['runs_sidebar_runs'] = 'Test Runs';
$lang['runs_sidebar_runs_empty'] = 'There are no test runs.';
$lang['runs_sidebar_runs_stats'] = '<strong class="text-softer">{0}</strong> open and <strong class="text-softer">{1}</strong> completed test runs in this project.';
$lang['runs_sidebar_suite'] = 'Test Suite';
$lang['runs_sidebar_suite_desc'] = 'This is a test run for the following test suite:';
$lang['runs_sidebar_viewsuite'] = 'view suite';
$lang['runs_sidebar_progress'] = 'Progress';
$lang['runs_sidebar_defects'] = 'Defects';

$lang['runs_subscription_subscribe'] = 'Subscribe';
$lang['runs_subscription_subscribe_desc'] = 'Subscribe to receive emails on test changes for this test run.';
$lang['runs_subscription_unsubscribe'] = 'Unsubscribe';
$lang['runs_subscription_unsubscribe_desc'] = 'Unsubscribe from email updates on test changes for this test run.';

$lang['runs_activity_empty'] = 'No activity yet.';
$lang['runs_tests_empty'] = 'There aren\'t any tests in this test run.';

$lang['runs_choose_suite'] = 'Select Test Suite';
$lang['runs_choose_suite_suite'] = 'Test Suite';
$lang['runs_choose_suite_desc'] = 'Select the test suite for the new test run.';
$lang['runs_choose_suite_required'] = 'Test Suite is a required field.';

$lang['runs_overview_description'] = 'Description';
$lang['runs_overview_empty_title'] = 'This project doesn\'t have any test runs, yet.';
$lang['runs_overview_empty_body'] = 'No test runs have been defined for this project, yet. Use the following button to add your first test run.';
$lang['runs_overview_empty_noaccess_body'] = 'No test runs have been defined for this project, yet.
Unfortunately, you don\'t have the required permissions to add new test runs. Please contact your administrator.';
$lang['runs_overview_empty_short'] = 'This project doesn\'t have any active test
runs. You can add a new test run.';
$lang['runs_overview_empty_noaccess_short'] = 'This project doesn\'t have any active test runs.
Unfortunately, you don\'t have the permissions to add one.';

$lang['runs_overview_empty_nosuites_title'] = 'This project doesn\'t contain any test runs or suites, yet.';
$lang['runs_overview_empty_nosuites_body'] = 'Before you can execute your first test run, 
you need to add a new test suite and test cases first.';
$lang['runs_overview_empty_nosuites_noaccess_body'] = 'Before you can execute your first test run, 
you need to add a new test suite and test cases first. Unfortunately, you don\'t have the required
permissions to do so. Please contact your administrator.';
$lang['runs_overview_empty_nosuites_short'] = 'This project doesn\'t contain any active
test runs or test suites. You can add a new test suite.';
$lang['runs_overview_empty_nosuites_noaccess_short'] = 'This project doesn\'t contain any active test runs or test suites.
Unfortunately, you are not allowed to add one.';

$lang['runs_overview_empty_expl_title'] = 'What\'s a test run?';
$lang['runs_overview_empty_expl_body'] = 'Once you have started adding test cases, you can start a test run to execute your tests and track results.';

$lang['runs_print_hint'] = 'Print Run';
$lang['runs_print_hint_desc'] = 'Opens a print view of this test run.';
$lang['runs_print_format'] = 'Print Format';
$lang['runs_export_hint'] = 'Export Run';
$lang['runs_export_hint_desc'] = 'Exports this test run into different formats (XML, Excel/CSV).';
$lang['runs_export_format'] = 'Format';
$lang['runs_export_section_include'] = 'Section Include';
$lang['runs_export_section_ids'] = 'Section IDs';
$lang['runs_export_columns'] = 'Columns';
$lang['runs_export_layout'] = 'Layout';
$lang['runs_export_separator_hint'] = 'Separator Hint';
$lang['runs_section_show_empty'] = 'Show Empty';

$lang['runs_rerun_title'] = 'Select Tests';
$lang['runs_rerun_desc'] = 'Include tests of the following previous status:';

$lang['runs_denied_add'] = 'You are not allowed to add test runs (insufficient permissions).';
$lang['runs_denied_edit'] = 'You are not allowed to edit test runs (insufficient permissions).';
$lang['runs_denied_edit_plan'] = 'Field :run_id is part of a test run. Please use API endpoints for test plan entries.';
$lang['runs_denied_delete'] = 'You are not allowed to delete test runs (insufficient permissions).';
$lang['runs_denied_delete_completed'] = 'You are not allowed to delete completed test runs (insufficient permissions).';
$lang['runs_denied_delete_plan'] = 'Field :run_id is part of a test run. Please use API endpoints for test plan entries.';
$lang['runs_denied_close'] = 'You are not allowed to close test runs (insufficient permissions).';
$lang['runs_denied_close_plan'] = 'This operation is not allowed. The test run belongs to a test plan and cannot be closed independently.';
$lang['runs_denied_completed'] = 'This operation is not allowed. The test run is already completed.';

$lang['runs_progress_details'] = 'Progress';
$lang['runs_progress_estimate_desc'] = 'Based on the current activity and forecasts, the projected completion date for this test run is:';
$lang['runs_progress_estimate_desc_many'] = 'Based on the current activity and forecasts, the projected completion date for the test run(s) is:';
$lang['runs_progress_estimate_no_accuracy'] = 'Forecast not possible, <a class="link" target="_blank" href="https://www.gurock.com/testrail/docs/user-guide/getting-started/tips">more data needed</a>';
$lang['runs_progress_estimate_no_accuracy_nohelp'] = 'Forecast not possible';
$lang['runs_progress_estimate_low_accuracy'] = 'Low accuracy, <a class="link" target="_blank" href="https://www.gurock.com/testrail/docs/user-guide/getting-started/tips">more data needed</a>';
$lang['runs_progress_estimate_low_accuracy_nohelp'] = 'Low accuracy forecast';
$lang['runs_progress_estimate_high_accuracy'] = 'High accuracy, <a class="link" target="_blank" href="https://www.gurock.com/testrail/docs/user-guide/getting-started/tips">learn more</a>';
$lang['runs_progress_estimate_high_accuracy_nohelp'] = 'High accuracy forecast';
$lang['runs_progress_estimate_unknown'] = 'Unknown';
$lang['runs_progress_running_since'] = 'This test run was started <strong class="text-softer">{0} ago</strong> ({1}).';
$lang['runs_progress_running_since_many'] = 'The test run(s) were started <strong class="text-softer">{0} ago</strong> ({1}).';
$lang['runs_progress_running_since_completed'] = 'This test run was active for <strong class="text-softer">{0}</strong> ({1} &ndash; {2}).';
$lang['runs_progress_running_since_completed_many'] = 'The test run(s) were active for <strong class="text-softer">{0}</strong> ({1} &ndash; {2}).';
$lang['runs_progress_running_completed'] = 'Completed:';
$lang['runs_progress_running_elapsed'] = 'Elapsed:';
$lang['runs_progress_running_tests_day'] = 'Tests / day:';
$lang['runs_progress_running_hours_day'] = 'Hours / day:';
$lang['runs_progress_stats_metric'] = 'Metric';
$lang['runs_progress_stats_by_estimate'] = 'By Estimate';
$lang['runs_progress_stats_by_forecast'] = 'By Forecast';
$lang['runs_progress_stats_completed'] = 'Completed';
$lang['runs_progress_stats_notcompleted'] = 'Not Completed';
$lang['runs_progress_stats_todo'] = 'Todo';
$lang['runs_progress_stats_total'] = 'Total';
$lang['runs_progress_completed'] = 'The progress is not available for a completed test run.';
$lang['runs_progress_no_task'] = 'Background Task';
$lang['runs_progress_no_task_desc'] = 'The background task is required for computing the forecasts, but the task is not installed.';
$lang['runs_progress_no_task_more'] = 'Learn more';
$lang['runs_progress_unknown_forecast'] = 'Forecast n/a';

$lang['runs_defects'] = 'Defects';
$lang['runs_defects_empty'] = 'No defects so far.';
$lang['runs_defects_empty_desc'] = 'Defects can be linked on the Add Result dialog when adding results.';

$lang['runs_tree_tests_not_displayed'] = '{0} more {0?{tests}:{test}} available.
Switch to <a href="{1}">compact view</a> to see all tests.';

$lang['runs_help_upcoming'] = 'Test runs &amp; plans of upcoming milestones are shown in this <em>Upcoming</em> section.
Starting the related milestone will move the runs &amp; plans from <em>upcoming</em> to <em>active</em>.';
$lang['runs_help_completion_pending'] = 'Test runs &amp; plans of completed milestones are shown in this <em>Completion Pending</em> section.
You can close the runs &amp; plans to mark them as completed and archive them.';

$lang['runs_timeline_hint_past'] = 'Milestone start date is in the past.';
$lang['runs_timeline_hint_future'] = 'Milestone start date is in the future.';
$lang['runs_page_type'] = 'Page Type';
$lang['runs_bulk_delete_message'] = '<strong>Really delete these test {0}?</strong> This also deletes all tests &amp; <br /> results in these {0} and cannot be undone.';
$lang['runs_bulk_delete_confirmation'] = '<span style="color:red">Yes, I want to <strong>irrevocably delete at least {0} tests <br />and the related test results &amp; comments.</strong></span>';
$lang['runs_bulk_delete_success'] = 'Successfully deleted the test {0}.';
$lang['runs_bulk_delete_error'] = 'No run selected.';
$lang['runs_bulk_delete_message_label'] = 'Message';


