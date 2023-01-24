<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$lang['plans_view_runs'] = 'Test Runs';
$lang['plans_view_runs_avail'] = 'Test runs in this test plan:';
$lang['plans_view_completed'] = 'Completed';
$lang['plans_view_noactive'] = 'No active test runs associated with this
test plan. <a href="{0}">Edit this test plan</a> to add additional test runs.';
$lang['plans_view_noactive_completed'] = 'No active test runs associated with this
test plan. Since this test plan is completed, you can no longer add new test runs.';
$lang['plans_view_empty'] = 'No active test runs in this test plan.';
$lang['plans_activity_empty'] = 'No activity yet.';

$lang['plans_box'] = 'Test Plan';
$lang['plans_case_ids'] = 'Case IDs';
$lang['plans_status_ids'] = 'Status IDs';
$lang['fetch_assignedto'] = 'Fetch Assigned To';

$lang['plans_runreport'] = 'Reports';

$lang['plans_reports_plan'] = 'Plan';
$lang['plans_reports_plan_summary'] = 'Summary';
$lang['plans_reports_plan_summary_hint'] = 'Shows a full summary &amp; overview of this test plan with statistics as well as activity and progress details.';

$lang['plans_reports_defects'] = 'Defects';
$lang['plans_reports_defects_summary'] = 'Summary';
$lang['plans_reports_defects_summary_hint'] = 'Shows a summary of found defects for this test plan.';
$lang['plans_reports_defects_cases_summary'] = 'Summary for Cases';
$lang['plans_reports_defects_cases_summary_hint'] = 'Shows a summary of found defects for this test plan per test case &amp; test.';
$lang['plans_reports_defects_references_summary'] = 'Summary for References';
$lang['plans_reports_defects_references_summary_hint'] = 'Shows a summary of found defects for the references (requirements, user stories, etc.) in this test plan.';

$lang['plans_reports_results'] = 'Results';
$lang['plans_reports_results_property_groups'] = 'Property Distribution';
$lang['plans_reports_results_property_groups_hint'] = 'Shows the distribution and groups for a specific test attribute (e.g. priority, type or status) for this test plan.';
$lang['plans_reports_results_case_coverage'] = 'Comparison for Cases';
$lang['plans_reports_results_case_coverage_hint'] = 'Shows the results in this test plan per test case (result coverage &amp; comparison).';
$lang['plans_reports_results_reference_coverage'] = 'Comparison for References';
$lang['plans_reports_results_reference_coverage_hint'] = 'Shows the results for the references (requirements, user stories, etc.) in this test plan (result coverage &amp; comparison).';

$lang['plans_invalid_javascript'] = 
'The JavaScript of your browser is not working properly and the test plan wasn\'t saved as a safety measure.
This can be caused by malfunctioning browser plugins or invalid UI scripts that were added to your TestRail installation.
Please contact your TestRail administrator to look into this.';

$lang['plans_reports_users'] = 'Users';
$lang['plans_reports_users_workload_summary'] = 'Workload Summary';
$lang['plans_reports_users_workload_summary_hint'] = 'Shows the workload summary, estimates and forecasts for users in this test plan.';

$lang['plans_new'] = 'Add Test Plan';
$lang['plans_add'] = 'Add Test Plan';
$lang['plans_save'] = 'Save Test Plan';
$lang['plans_completed'] = '<strong>This test plan is completed.</strong> You can no longer modify this test plan or add new test runs.';

$lang['plans_choose_suite'] = 'Add Test Suite';
$lang['plans_choose_suite_suite'] = 'Test Suite';
$lang['plans_choose_suite_desc'] = 'Select the test suite to add to this test plan.';
$lang['plans_choose_suite_required'] = 'Test Suite is a required field.';

$lang['plans_load'] = 'Rerun Test Plan';
$lang['plans_load_required'] = 'Please select a test plan.';
$lang['plans_load_active'] = 'Active';
$lang['plans_load_completed'] = 'Completed';
$lang['plans_load_empty'] = 'No previous test plans found.';

$lang['plans_delete'] = 'Delete Test Plan';
$lang['plans_delete_link'] = 'Delete this test plan';
$lang['plans_delete_descr'] = 'Delete this test plan to remove it from your project.';
$lang['plans_delete_confirm'] = 'Really delete this test plan? This also deletes all related test runs and results in this plan and cannot be undone.';
$lang['plans_delete_confirm_checkbox'] = 'Yes, delete this test plan (cannot be undone)';
$lang['plans_delete_confirm_extra'] = 'You will irrevocably delete at least <strong>{0}</strong> {0?{test runs}:{test run}} and the related test &amp; results.';
$lang['plans_print_confirm'] = 'This test plan contains {0} tests. The <em>Details</em> view will generate hundreds of pages and may be slow. Continue?';

$lang['plans_success_add'] = 'Successfully added the new test plan.';
$lang['plans_success_close'] = 'Successfully closed the test plan and the related test runs.';
$lang['plans_success_update'] = 'Successfully updated the test plan and the related test runs.';
$lang['plans_success_delete'] = 'Successfully deleted the test plan and the related test runs.';
$lang['plans_error_add'] = 'An error occurred while adding the new test plan.';
$lang['plans_error_close'] = 'An error occurred while closing the test plan.';
$lang['plans_error_delete'] = 'An error occurred while deleting the test plan.';
$lang['plans_error_update'] = 'An error occurred while updating the test plan.';
$lang['plans_error_exists'] = 'The specified test plan does not exist or you do not have the permission to access it.';

$lang['plans_return_location'] = 'Return Location';
$lang['plans_plan'] = 'Test Plan';
$lang['plans_name'] = 'Name';
$lang['plans_name_desc'] = 'Ex: <em>All supported browsers</em> or <em>Operating system/database combinations</em>.';
$lang['plans_description'] = 'Description';
$lang['plans_description_desc'] = 'Use this description to describe the purpose of this test plan.';
$lang['plans_milestone'] = 'Milestone';
$lang['plans_milestone_desc'] = 'The milestone this test plan belongs to.';
$lang['plans_entry'] = 'Plan Entry';
$lang['plans_runs'] = 'Plan Runs';
$lang['plans_configs'] = 'Plan Configurations';
$lang['plans_entries'] = 'Plan Entries';
$lang['plans_entries_as_above'] = 'As above';
$lang['old_plan_id'] = 'Old Plan Id';
$lang['copy_assignedto'] = 'Copy Assigned To';

$lang['plans_sidebar_suites'] = 'Test Suites';
$lang['plans_sidebar_suites_desc'] = '{0} sections, {1} cases';
$lang['plans_sidebar_suites_desc_long'] = 'Contains {0} sections with a total of {1} test cases.';

$lang['plans_suites_add'] = 'Add Test Suite';
$lang['plans_runs_add'] = 'Add Test Run(s)';

$lang['plans_actions'] = 'Actions';
$lang['plans_close'] = 'Close Test Plan';
$lang['plans_close_link'] = 'Close this test plan';
$lang['plans_close_desc'] = 'Archive this test plan to prevent future modifications to its tests and results.';
$lang['plans_close_hint'] = 'Close Plan';
$lang['plans_close_hint_desc'] = 'Closes this test plan and archives its test runs and results. Prevents future modifications.';
$lang['plans_close_confirm'] = 'Really close this test plan? This operation cannot be undone.';
$lang['plans_close_confirm_long'] = 'Really close this test plan? Closing a test plan archives the related test runs and prevents future modifications. This change cannot be undone.';

$lang['plans_confirm_delete'] = 'Really delete this test plan entry? This change cannot be undone.';

$lang['plans_configs_select'] = 'Select configurations';
$lang['plans_configs_select_configs'] = 'Configurations';
$lang['plans_configs_select_desc'] = 'Select the configurations for your test suite.';

$lang['plans_invalid_milestone'] = 'The Milestone field is invalid (unknown format or milestone).';
$lang['plans_invalid_entry'] = 'One or more suites have errors, please see below for more information.';
$lang['plans_no_entries'] = 'Please add at least one suite to this test plan.';
$lang['plans_invalid_entry_name'] = 'The Name field is required.';
$lang['plans_no_cases'] = 'Please select at least one test case.';
$lang['plans_no_suite'] = 'The test suite no longer exists. Please remove this entry from the test plan.';
$lang['plans_no_config'] = 'One or more configurations no longer exist. The related test runs are no longer included.';

$lang['plans_invalid_entry_config'] = 'Field {0} contains one or more invalid or duplicate configurations.';
$lang['plans_invalid_entry_combi'] = 'Field {0} uses an invalid combination of configurations (use one from each group).';
$lang['plans_invalid_entry_combi_duplicate'] = 'Field {0} specifies the same configuration combination more than once.';
$lang['plans_invalid_entry_runs_empty'] = 'Field {0} has configurations but no test runs.';
$lang['plans_invalid_entry_no_cases'] = 'Field {0} needs to include at least one test case.';
$lang['plans_duplicate_cases'] = 'One or more values in Field {0} is duplicate';

$lang['plans_entry_name'] = 'Name';
$lang['plans_entry_name_desc'] = 'The name for the test run(s).';
$lang['plans_entry_name_edit'] = 'Edit Name';
$lang['plans_entry_name_save'] = 'Save Name';
$lang['plans_entry_name_empty'] = 'The Name field is required.';
$lang['plans_entry_assignedto_desc'] = 'The user new test runs are assigned to.';
$lang['plans_entry_configs_desc'] = 'You can choose the configurations to include as well as override their case selections, assignees or descriptions.';
$lang['plans_entry_run_id_empty'] = 'Field {0} is required when changing existing run configuration.';

$lang['plans_empty_title'] = 'Please select the test suites for this plan from the sidebar';
$lang['plans_empty_title_master'] = 'Please add test runs to this plan from the sidebar';
$lang['plans_empty_body'] = 'For every test suite (and configuration) you add to
this test plan, TestRail automatically starts a corresponding test run.';
$lang['plans_empty_body_master'] = 'For every entry and/or configuration you add to
this test plan, TestRail automatically starts a corresponding test run.';

$lang['plans_diff_title'] = 'Review Changes';
$lang['plans_diff_adding'] = 'Adding';
$lang['plans_diff_deleting'] = 'Deleting';
$lang['plans_diff_deleting_desc'] = 'Deleting test runs <strong>cannot be undone</strong>. This also deletes all contained test results.';
$lang['plans_diff_updating'] = 'Updating';
$lang['plans_diff_updating_all'] = 'No test runs are added or deleted. All test runs are kept and updated if needed.';
$lang['plans_diff_updating_some'] = 'The remaining test runs are kept and will be updated if needed.';

$lang['plans_print_hint'] = 'Print Plan';
$lang['plans_print_hint_desc'] = 'Opens a print view of this test plan.';
$lang['plans_print_format'] = 'Print Format';
$lang['plans_export_hint'] = 'Export Plan';
$lang['plans_export_hint_desc'] = 'Exports this test plan into different formats (XML, Excel/CSV).';
$lang['plans_export_format'] = 'Format';
$lang['plans_export_columns'] = 'Columns';
$lang['plans_export_layout'] = 'Layout';
$lang['plans_export_separator_hint'] = 'Separator Hint';

$lang['plans_denied_add'] = 'You are not allowed to add test plans (insufficient permissions).';
$lang['plans_denied_edit'] = 'You are not allowed to edit test plans (insufficient permissions).';
$lang['plans_denied_delete'] = 'You are not allowed to delete test plans (insufficient permissions).';
$lang['plans_denied_delete_completed'] = 'You are not allowed to delete completed test plans (insufficient permissions).';
$lang['plans_denied_close'] = 'You are not allowed to close test plans (insufficient permissions).';
$lang['plans_denied_completed'] = 'This operation is not allowed. The test plan is already completed.';
$lang['plans_denied_editable'] = 'This operation is not allowed. The test plan can no longer be edited.';

$lang['plans_cases_select'] = 'Select';
$lang['plans_cases_select_all'] = 'All';
$lang['plans_cases_select_none'] = 'None';

$lang['plans_softlock'] = 'Not saved: this test plan has been changed by other users';
$lang['plans_softlock_desc'] = 'This plan has been modified since you opened it
(by <em>{0}</em> on <em>{1}</em>, and possibly others). You can <a target="_blank" href="{2}">review the changes</a>
and still save the plan. Please note that this will override all changes made by other users.';
$lang['plans_softlock_force'] = 'Yes, override all made changes and save my version';

$lang['plans_sidebar_status'] = 'Status';
$lang['plans_sidebar_activity'] = 'Activity';
$lang['plans_sidebar_progress'] = 'Progress';
$lang['plans_sidebar_defects'] = 'Defects';
$lang['plans_overview_activity'] = 'Activity';

$lang['plans_progress_details'] = 'Progress';
$lang['plans_progress_estimate_desc'] = 'Based on the current activity and forecasts, the projected completion date for this test plan is:';
$lang['plans_progress_estimate_no_accuracy'] = 'Forecast not possible, <a class="link" target="_blank" href="https://www.gurock.com/testrail/docs/user-guide/getting-started/tips">more data needed</a>';
$lang['plans_progress_estimate_no_accuracy_nohelp'] = 'Forecast not possible';
$lang['plans_progress_estimate_low_accuracy'] = 'Low accuracy, <a class="link" target="_blank" href="https://www.gurock.com/testrail/docs/user-guide/getting-started/tips">more data needed</a>';
$lang['plans_progress_estimate_low_accuracy_nohelp'] = 'Low accuracy forecast';
$lang['plans_progress_estimate_high_accuracy'] = 'High accuracy, <a class="link" target="_blank" href="https://www.gurock.com/testrail/docs/user-guide/getting-started/tips">learn more</a>';
$lang['plans_progress_estimate_high_accuracy_nohelp'] = 'High accuracy forecast';
$lang['plans_progress_estimate_unknown'] = 'Unknown';
$lang['plans_progress_running_since'] = 'This test plan was started <strong class="text-softer">{0} ago</strong> ({1}).';
$lang['plans_progress_running_since_completed'] = 'This test plan was active for <strong class="text-softer">{0}</strong> ({1} &ndash; {2}).';
$lang['plans_progress_running_completed'] = 'Completed:';
$lang['plans_progress_running_elapsed'] = 'Elapsed:';
$lang['plans_progress_running_tests_day'] = 'Tests / day:';
$lang['plans_progress_running_hours_day'] = 'Hours / day:';
$lang['plans_progress_stats_metric'] = 'Metric';
$lang['plans_progress_stats_by_estimate'] = 'By Estimate';
$lang['plans_progress_stats_by_forecast'] = 'By Forecast';
$lang['plans_progress_stats_completed'] = 'Completed';
$lang['plans_progress_stats_todo'] = 'Todo';
$lang['plans_progress_stats_notcompleted'] = 'Not Completed';
$lang['plans_progress_stats_total'] = 'Total';
$lang['plans_progress_completed'] = 'The progress is not available for a completed test plan.';
$lang['plans_progress_unknown_forecast'] = 'Forecast n/a';
$lang['plans_progress_empty'] = 'No test runs yet.';

$lang['plans_defects'] = 'Defects';
$lang['plans_defects_empty'] = 'No defects so far.';
$lang['plans_defects_empty_desc'] = 'Defects can be linked on the Add Result dialog when adding results.';
$lang['plans_defects_run_count'] = '{0?{defects}:{defect}}';
$lang['plans_defects_runs'] = 'Test Runs';

$lang['plans_overview_display'] = 'Display';
$lang['plans_overview_display_medium'] = 'Medium View';
$lang['plans_overview_display_medium_desc'] = 'Displays the test runs and configurations in a medium-sized way.';
$lang['plans_overview_display_small'] = 'Compact View';
$lang['plans_overview_display_small_desc'] = 'Displays the test runs in a more compact way. Useful if you have many test runs.';
$lang['created_on'] = 'Created On';
$lang['completed_on'] = 'Completed On';
$lang['plans_filter_none'] = 'Any';
$lang['plans_loading'] = 'Loading Runs';
