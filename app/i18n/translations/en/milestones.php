<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$lang['milestones_sidebar_status'] = 'Status';
$lang['milestones_sidebar_activity'] = 'Activity';
$lang['milestones_sidebar_milestones'] = 'Milestones';
$lang['milestones_sidebar_milestones_empty'] = 'There are no milestones.';
$lang['milestones_sidebar_milestones_stats'] = '<strong class="text-softer">{0}</strong> open and <strong class="text-softer">{1}</strong> completed milestones in this project.';
$lang['milestones_sidebar_dueon'] = 'Due on {0}.';
$lang['milestones_sidebar_nodue'] = 'No due date set.';
$lang['milestones_sidebar_completedon'] = 'Completed on <strong class="text-softer">{0}</strong>.';
$lang['milestones_sidebar_belongsto'] = 'Belongs to milestone <a href="{0}">{1}</a>.';
$lang['milestones_sidebar_progress'] = 'Progress';
$lang['milestones_sidebar_defects'] = 'Defects';

$lang['milestones_overview_description_runs_short'] = '<strong>{0}</strong> {0?{test runs}:{test run}}';
$lang['milestones_overview_description_runs'] = 'Has <strong>{0}</strong> active {0?{test runs}:{test run}}.';
$lang['milestones_overview_description_subs'] = 'Has <strong>{0}</strong> {0?{sub-milestones}:{sub-milestone}} and no active test runs.';
$lang['milestones_overview_description_subs_runs'] = 'Has <strong>{0}</strong> {0?{sub-milestones}:{sub-milestone}} and <strong>{1}</strong> active {1?{test runs}:{test run}}.';
$lang['milestones_overview_description_subs_short'] = '<strong>{0}</strong> {0?{sub-milestones}:{sub-milestone}}';
$lang['milestones_overview_description_noruns'] = 'No active test runs.';
$lang['milestones_overview_open'] = 'Open';
$lang['milestones_overview_active'] = 'Active';
$lang['milestones_overview_active_empty'] = 'No active milestones in this project.';
$lang['milestones_overview_active_subs_empty'] = 'No active sub-milestones in this milestone.';
$lang['milestones_overview_completed'] = 'Completed';
$lang['milestones_overview_upcoming'] = 'Upcoming';
$lang['milestones_overview_activity'] = 'Activity';
$lang['milestones_overview_allupcoming'] = 'All Upcoming';
$lang['milestones_overview_runs'] = 'Test Runs';
$lang['milestones_overview_milestones'] = 'Milestones';
$lang['milestones_overview_empty_short'] = 'This project doesn\'t have any active milestones.
You can add a new milestone.';
$lang['milestones_overview_empty_noaccess_short'] = 'This project doesn\'t have any active milestones.
Unfortunately, you don\'t have the permissions to add one.';
$lang['milestones_completed'] = '<strong>This milestone is completed.</strong> You can also close test runs &amp; plans in this milestone to archive them permanently.';
$lang['milestones_upcoming'] = '<strong>This milestone hasn\'t been started yet.</strong> Starting this milestone will move it and its test runs from <em>upcoming</em> to <em>active</em>.';
$lang['milestones_overdue'] = 'The projected completion date is later than the milestone due date (<strong>{0}</strong> past end date).';

$lang['milestones_overview_display'] = 'Display';
$lang['milestones_overview_display_large'] = 'Detail View';
$lang['milestones_overview_display_large_desc'] = 'Displays the milestones with many details. Useful if you have just a few milestones.';
$lang['milestones_overview_display_medium'] = 'Medium View';
$lang['milestones_overview_display_medium_desc'] = 'Displays the milestones in a medium-sized way.';
$lang['milestones_overview_display_small'] = 'Compact View';
$lang['milestones_overview_display_small_desc'] = 'Displays the milestones as a compact list. Useful if you have many milestones.';

$lang['milestones_runreport'] = 'Reports';

$lang['milestones_reports_milestone'] = 'Milestone';
$lang['milestones_reports_milestone_summary'] = 'Summary';
$lang['milestones_reports_milestone_summary_hint'] = 'Shows a full summary &amp; overview of this milestone with statistics as well as activity and progress details.';

$lang['milestones_reports_defects'] = 'Defects';
$lang['milestones_reports_defects_summary'] = 'Summary';
$lang['milestones_reports_defects_summary_hint'] = 'Shows a summary of found defects for this milestone.';
$lang['milestones_reports_defects_cases_summary'] = 'Summary for Cases';
$lang['milestones_reports_defects_cases_summary_hint'] = 'Shows a summary of found defects for this milestone per test case &amp; test.';
$lang['milestones_reports_defects_references_summary'] = 'Summary for References';
$lang['milestones_reports_defects_references_summary_hint'] = 'Shows a summary of found defects for the references (requirements, user stories, etc.) in this milestone.';

$lang['milestones_reports_results'] = 'Results';
$lang['milestones_reports_results_property_groups'] = 'Property Distribution';
$lang['milestones_reports_results_property_groups_hint'] = 'Shows the distribution and groups for a specific test attribute (e.g. priority, type or status) for this milestone.';
$lang['milestones_reports_results_case_coverage'] = 'Comparison for Cases';
$lang['milestones_reports_results_case_coverage_hint'] = 'Shows the results in this milestone per test case (result coverage &amp; comparison).';
$lang['milestones_reports_results_reference_coverage'] = 'Comparison for References';
$lang['milestones_reports_results_reference_coverage_hint'] = 'Shows the results for the references (requirements, user stories, etc.) in this milestone (result coverage &amp; comparison).';

$lang['milestones_reports_users'] = 'Users';
$lang['milestones_reports_users_workload_summary'] = 'Workload Summary';
$lang['milestones_reports_users_workload_summary_hint'] = 'Shows the workload summary, estimates and forecasts for users in this milestone.';

$lang['milestones_denied_add'] = 'You are not allowed to add milestones (insufficient permissions).';
$lang['milestones_denied_edit'] = 'You are not allowed to edit milestones (insufficient permissions).';
$lang['milestones_denied_delete'] = 'You are not allowed to delete milestones (insufficient permissions).';

$lang['milestones_view_empty'] = 'No active test runs in this milestone.';
$lang['milestones_view_noactive'] = 'No active test runs associated with this
milestone. You can go to the <a href="{0}">test run overview</a> to add a new
test run for this milestone.';
$lang['milestones_view_noactive_completed'] = 'No active test runs associated with this
milestone. Since this milestone is completed, you can no longer add new test runs to
this milestone.';
$lang['milestones_activity_empty'] = 'No activity yet.';

$lang['milestones_runningtest'] = 'Running Test';
$lang['milestones_runningtests'] = 'Running Tests';

$lang['milestones_new'] = 'Add Milestone';
$lang['milestones_start'] = 'Start Milestone';
$lang['milestones_edit'] = 'Edit Milestone';
$lang['milestones_add'] = 'Add Milestone';
$lang['milestones_save'] = 'Save Milestone';

$lang['milestones_actions'] = 'Actions';
$lang['milestones_delete'] = 'Delete Milestone';
$lang['milestones_delete_selected'] = 'Delete selected';
$lang['milestones_delete_select_all'] = 'Select all';
$lang['milestones_delete_link'] = 'Delete this milestone';
$lang['milestones_delete_descr'] = 'Delete this milestone to remove it from your project. This also removes it from the related tests and cases.';
$lang['milestones_delete_confirm'] = 'Really delete this milestone? This also unlinks this milestone from all test runs &amp; plans and cannot be undone <em>(no test runs &amp; plans are deleted)</em>.';
$lang['milestones_delete_confirm_checkbox'] = 'Yes, delete this milestone (cannot be undone)';
$lang['milestones_print_confirm'] = 'This milestone contains {0} tests. The <em>Details</em> view will generate hundreds of pages and may be slow. Continue?';

$lang['milestones_milestone'] = 'Milestone';
$lang['milestones_status'] = 'Milestone Status';
$lang['milestones_return_location'] = 'Return Location';
$lang['milestones_box'] = 'Milestone';
$lang['milestones_name'] = 'Name';
$lang['milestones_reference'] = 'References';
$lang['milestones_default_url'] = 'https://www.gurock.com/testrail/docs/integrate/references/introduction';
$lang['milestones_name_desc'] = 'Ex: <em>Version 1.0</em>, <em>Internal Beta 2</em> or <em>Sprint #4</em>';
$lang['milestones_description'] = 'Description';
$lang['milestones_description_desc'] = 'Use this description to describe the purpose and goals of this milestone.';
$lang['milestones_parent'] = 'Parent';
$lang['milestones_parent_desc'] = 'The parent milestone for this milestone (for sub-milestones in milestones).';

$lang['milestones_starton'] = 'Start Date';
$lang['milestones_starton_desc'] = 'The expected or scheduled start date of this milestone (for upcoming and not yet active milestones).';
$lang['milestones_starton_actual_desc'] = 'The actual start date of this milestone; can also be in the past. Leave empty to use <em>Today</em>.';
$lang['milestones_starton_required'] = 'Milestone marked as scheduled/upcoming but no start date given (start_on).';
$lang['milestones_dueon'] = 'End Date';
$lang['milestones_dueon_desc'] = 'The expected due or end date of this milestone.';
$lang['milestones_iscompleted'] = 'Is Completed';
$lang['milestones_iscompleted_name'] = 'This milestone is completed';
$lang['milestones_iscompleted_desc'] = 'Tests and test cases can only be assigned to active milestones.';
$lang['milestones_isstarted_required'] = 'Milestone start date given but not marked as scheduled/upcoming.';

$lang['milestones_start'] = 'Start Milestone';

$lang['milestones_success_add'] = 'Successfully added the new milestone.';
$lang['milestones_success_start'] = 'Successfully started the milestone.';
$lang['milestones_success_delete'] = 'Successfully deleted the milestone.';
$lang['milestones_error_add'] = 'An error occurred while adding the new milestone.';
$lang['milestones_error_delete'] = 'An error occurred while deleting the milestone.';
$lang['milestones_error_exists'] = 'The specified milestone does not exist or you do not have the permission to access it.';
$lang['milestones_success_update'] = 'Successfully updated the milestone.';
$lang['milestones_error_update'] = 'An error occurred while saving the milestone.';

$lang['milestones_empty_title'] = 'This project doesn\'t have any milestones, yet.';
$lang['milestones_empty_body'] = 'No milestones have been defined for this project yet. Use the following button to create the first milestone.';
$lang['milestones_empty_noaccess_body'] = 'No milestones have been defined for this project yet.
Unfortunately, you don\'t have the required permissions to add milestones. Please contact your administrator.';
$lang['milestones_empty_expl_title'] = 'What\'s a milestone?';
$lang['milestones_empty_expl_body'] = 'Add project milestones (such as software releases) to TestRail to manage and track multiple test runs for a single milestone.';

$lang['milestones_progress_details'] = 'Progress';
$lang['milestones_progress_estimate_desc'] = 'Based on the current activity and forecasts, the projected completion date for this milestone is:';
$lang['milestones_progress_estimate_no_accuracy'] = 'Forecast not possible, <a class="link" target="_blank" href="https://www.gurock.com/testrail/docs/user-guide/getting-started/tips">more data needed</a>';
$lang['milestones_progress_estimate_no_accuracy_nohelp'] = 'Forecast not possible';
$lang['milestones_progress_estimate_low_accuracy'] = 'Low accuracy, <a class="link" target="_blank" href="https://www.gurock.com/testrail/docs/user-guide/getting-started/tips">more data needed</a>';
$lang['milestones_progress_estimate_low_accuracy_nohelp'] = 'Low accuracy forecast';
$lang['milestones_progress_estimate_high_accuracy'] = 'High accuracy, <a class="link" target="_blank" href="https://www.gurock.com/testrail/docs/user-guide/getting-started/tips">learn more</a>';
$lang['milestones_progress_estimate_high_accuracy_nohelp'] = 'High accuracy forecast';
$lang['milestones_progress_estimate_unknown'] = 'Unknown';
$lang['milestones_progress_running_since'] = 'This milestone was started <strong class="text-softer">{0} ago</strong> ({1}).';
$lang['milestones_progress_running_since_completed'] = 'This milestone was active for <strong class="text-softer">{0}</strong> ({1} &ndash; {2}).';
$lang['milestones_progress_running_completed'] = 'Completed:';
$lang['milestones_progress_running_elapsed'] = 'Elapsed:';
$lang['milestones_progress_running_tests_day'] = 'Tests / day:';
$lang['milestones_progress_running_hours_day'] = 'Hours / day:';
$lang['milestones_progress_stats_metric'] = 'Metric';
$lang['milestones_progress_stats_by_estimate'] = 'By Estimate';
$lang['milestones_progress_stats_by_forecast'] = 'By Forecast';
$lang['milestones_progress_stats_completed'] = 'Completed';
$lang['milestones_progress_stats_notcompleted'] = 'Not Completed';
$lang['milestones_progress_stats_todo'] = 'Todo';
$lang['milestones_progress_stats_total'] = 'Total';
$lang['milestones_progress_completed'] = 'The progress is not available for a completed milestone.';
$lang['milestones_progress_unknown_forecast'] = 'Forecast n/a';
$lang['milestones_progress_no_runs'] = 'No test runs available for displaying the progress of this milestone.';

$lang['milestones_defects_no_runs'] = 'No test runs available for displaying the defects of this milestone.';
$lang['milestones_defects'] = 'Defects';
$lang['milestones_defects_empty'] = 'No defects so far.';
$lang['milestones_defects_empty_desc'] = 'Defects can be linked on the Add Result dialog when adding results.';
$lang['milestones_defects_run_count'] = '{0?{defects}:{defect}}';
$lang['milestones_defects_runs'] = 'Test Runs';

$lang['milestones_print_hint'] = 'Print Milestone';
$lang['milestones_print_hint_desc'] = 'Opens a print view of this milestone.';
$lang['milestones_print_format'] = 'Print Format';
$lang['milestones_export_hint'] = 'Export Milestone';
$lang['milestones_export_hint_desc'] = 'Exports this milestone into different formats (XML, Excel/CSV).';
$lang['milestones_export_format'] = 'Format';
$lang['milestones_export_columns'] = 'Columns';
$lang['milestones_export_layout'] = 'Layout';
$lang['milestones_export_separator_hint'] = 'Separator Hint';
$lang['milestones_tooltip_text'] = 'Delete this milestone';
$lang['milestones_delete_confirm'] = 'Really delete this milestone? This irrevocably deletes this milestone for all users and cannot be undone.';
$lang['milestones_bulk_delete_message'] = '<strong>Delete these test milestones?</strong> This also unlinks the <br /> milestones from all test runs and plans and cannot be <br />undone (no test runs and plans are deleted).';
$lang['milestones_bulk_delete_confirmation'] = '<span style="color:red">Yes, delete the selected milestones (cannot be <br />undone)</span>';
$lang['milestones_bulk_delete_success'] = 'Successfully deleted the milestone (s).<br />';
$lang['milestones_bulk_delete_error'] = 'No milestones selected.';

$lang['milestones_help_upcoming'] = 'Milestones with a start date (in the future or past) are shown in this <em>Upcoming</em> section.
Starting a milestone will move it from <em>upcoming</em> to <em>active</em>.';

$lang['milestones_timeline_hint_past'] = 'Milestone start date is in the past.';
$lang['milestones_timeline_hint_future'] = 'Milestone start date is in the future.';
$lang['milestones_invalid_parent'] = 'The Parent field is invalid (unknown format or milestone).';
$lang['milestones_invalid_parent_same'] = 'Milestone and milestone parent must be two different milestones.';
$lang['milestones_invalid_parent_parent'] = 'You cannot add a sub-milestone to a sub-milestone (only one sub-milestone level is supported).';
$lang['milestones_invalid_parent_sub'] = 'You cannot change a milestone with sub-milestones into a sub-milestone (only one sub-milestone level is supported).';
$lang['estimate_unknown'] = '<a class="link" target="_blank" href="http://docs.gurock.com/testrail-userguide/userguide-tips?&amp;#scheduling_and_forecasting">?</a>';
$lang['plan_filters_required'] = 'Plan Filters Required';
$lang['plan_id_required'] = 'Plan Id Required';
$lang['milestones_error_invaliddate'] = 'End date is invalid! End date should be greater then start date.';

