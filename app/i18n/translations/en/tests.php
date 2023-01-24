<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$lang['tests_completed'] = '(completed)';
$lang['tests_completed_info'] = '<strong>This test is completed.</strong> You can no longer modify or add test results.';

$lang['tests_instructions'] = 'Instructions';
$lang['tests_results'] = 'Results';
$lang['tests_box'] = 'Test Result';
$lang['tests_test'] = 'Test';
$lang['tests_return_location'] = 'Return Location';
$lang['tests_tests'] = 'Test IDs';
$lang['tests_test_change'] = 'Test Change';
$lang['tests_no_group_name'] = 'Tests';
$lang['tests_set_next'] = 'Set Next';
$lang['tests_next'] = 'Next';
$lang['tests_set_timer'] = 'Set Timer';

$lang['tests_no_changes'] = 'No test results or comments yet.';
$lang['tests_na_run_case'] = 'No (active) test found for the run/case combination.';

$lang['tests_actions_result'] = 'Add Result';
$lang['tests_actions_pass'] = 'Pass &amp; Next';
$lang['tests_actions_results'] = 'Add Results';
$lang['tests_actions_result_edit'] = 'Edit Result';
$lang['tests_actions_next'] = 'Jump to next test: Yes';
$lang['tests_actions_next_no'] = 'Jump to next test: No';
$lang['tests_actions_comment'] = 'Add Comment or File';
$lang['tests_actions_comment_inline'] = 'Add Comment';
$lang['tests_actions_comment_edit'] = 'Edit Comment';
$lang['tests_actions_assignto'] = 'Assign To';
$lang['tests_actions_assignto_edit'] = 'Edit Assign To';
$lang['tests_actions_assignto_selected'] = 'Assign selected';
$lang['tests_actions_assignto_selected_hint'] = 'Assigns all selected tests to a user.';
$lang['tests_actions_assignto_view'] = 'Assign all in current view';
$lang['tests_actions_assignto_view_hint'] = 'Assigns all tests in the current view (section or group) to the selected user, respecting the current filter.';
$lang['tests_actions_assignto_all'] = 'Assign all in filter';
$lang['tests_actions_assignto_all_hint'] = 'Assigns all tests of the test run to the selected user, respecting the current filter.';
$lang['tests_actions_assignto_many_desc'] = 'Select a user to assign the tests.';

$lang['tests_headline_id'] = 'ID: {0}';
$lang['tests_headline_status'] = 'Status: {0}';

$lang['tests_success_subscribe'] = 'Successfully subscribed to the test.';
$lang['tests_success_unsubscribe'] = 'Successfully unsubscribed from the test.';
$lang['tests_error_subscribe'] = 'Subscribe not allowed because you are already subscribed to the test run.';
$lang['tests_error_exists'] = 'The specified test or test result does not exist or you do not have the permission to access it.';
$lang['tests_timer_error_exists'] = 'The specified test timer does not exist.';
$lang['tests_error_unsubscribe'] = 'Unsubscribe not allowed because you are already subscribed to the test run.';
$lang['tests_error_test_invalid'] = 'One or more of the selected tests no longer exist. Please refresh this page.';
$lang['tests_error_test_required'] = 'The test(s) or test result no longer exist. Please refresh this page.';
$lang['tests_error_parent_invalid'] = 'The tests are not from the same test run, test plan or project.';
$lang['tests_error_template_invalid'] = 'Please select one or more valid tests or a test result to edit.';
$lang['tests_error_run_invalid'] = 'The test run for the tests no longer exists.
Please refresh this page.';
$lang['tests_error_project_invalid'] = 'The project for the tests no longer exists.
Please refresh this page.';
$lang['tests_error_changes_invalid'] = 'No test results available for this test. The test may have been deleted. Please refresh this page.';

$lang['tests_id'] = 'ID';
$lang['tests_test_id'] = 'Test ID';
$lang['tests_case_id'] = 'Case ID';
$lang['tests_case_na'] = 'The test case of this test is no longer available. Please refresh this page.';
$lang['tests_title_and_link'] = 'Test Details (ID, Title and Link)';
$lang['tests_link'] = 'Test Link';
$lang['tests_status'] = 'Status';
$lang['tests_status_short'] = 'St.';
$lang['tests_assignedto'] = 'Assigned To';
$lang['tests_comment'] = 'Comment';
$lang['tests_comment_hint'] = 'Add a comment ..';
$lang['tests_comment_how'] = 'Submit comment with Ctrl+Enter or Meta+Enter.';
$lang['tests_comment_empty'] = 'The Comment field is required.';
$lang['tests_elapsed'] = 'Elapsed';
$lang['tests_elapsed_all'] = 'Elapsed All';
$lang['tests_defects'] = 'Defects';
$lang['tests_defects_all'] = 'Defects All';
$lang['tests_version'] = 'Version';
$lang['tests_version_all'] = 'Version All';
$lang['tests_in_progress'] = 'In Progress';
$lang['tests_in_progress_more'] = '+{0} more';
$lang['tests_in_progress_users'] = '{0} users';
$lang['tests_in_progress_desc'] = 'Show the tests you are currently working on.';
$lang['tests_filter'] = 'Filter';
$lang['tests_tested_by'] = 'Tested By';
$lang['tests_tested_on'] = 'Tested On';
$lang['tests_case_status'] = 'Case Status';
$lang['tests_case_assignedto'] = 'Case Assigned To';
$lang['tests_tested_na'] = 'This field is not available for old test results.';
$lang['tests_milestone'] = 'Milestone';
$lang['tests_run'] = 'Run';
$lang['tests_run_id'] = 'Run ID';
$lang['tests_run_config'] = 'Run Configuration';
$lang['tests_plan'] = 'Plan';
$lang['tests_plan_id'] = 'Plan ID';
$lang['tests_stats_note'] = 'The statistics represent the visible tests of this group
only (including filters and page limits). The numbers may vary for the entire group.';

$lang['tests_progress_dialog'] = 'In Progress';
$lang['tests_progress_dialog_paused'] = 'Work on this test is currently paused.';
$lang['tests_progress_dialog_running'] = 'This test is currently being worked on.';
$lang['tests_progress_dialog_empty'] = 'There are no tests you are currently working on. You can use the <em>Progress</em> feature to indicate that you are working on a test.';
$lang['tests_progress_dialog_intro'] = 'You are currently working on the following tests:';
$lang['tests_progress_dialog_load'] = 'More tests available. <a {0}>Show all tests</a>';

$lang['tests_columns'] = 'Columns';
$lang['tests_column_suffix_all'] = ' All';

$lang['tests_assignedto_null'] = 'Unassigned';
$lang['tests_assignedto_unassigned'] = 'Unassigned';

$lang['tests_dialogs_type'] = 'Type';
$lang['tests_dialogs_is_result'] = 'Is Result';
$lang['tests_dialogs_status'] = 'Status';
$lang['tests_dialogs_status_desc'] = 'Set the test status (<em>passed</em>, <em>failed</em> etc.).';
$lang['tests_dialogs_assignto'] = 'Assign To';
$lang['tests_dialogs_assignto_desc'] = 'Assign to another team member.';
$lang['tests_dialogs_version'] = 'Version';
$lang['tests_dialogs_version_desc'] = 'The version you tested against.';
$lang['tests_dialogs_elapsed'] = 'Elapsed';
$lang['tests_dialogs_elapsed_desc'] = 'How long the test took.';
$lang['tests_dialogs_defects'] = 'Defects';
$lang['tests_dialogs_defects_desc'] = 'A list of IDs in your bug tracker.';
$lang['tests_dialogs_comment'] = 'Comment';
$lang['tests_dialogs_comment_desc_result'] = 'Describe your test result.';
$lang['tests_dialogs_comment_desc_comment'] = 'Add a new comment to this test.';
$lang['tests_dialogs_comment_desc_comment_edit'] = 'Edit your comment to this test.';
$lang['tests_dialogs_comment_desc_assign'] = 'Add a comment for the tester.';
$lang['tests_dialogs_comment_desc_assign_edit'] = 'Edit your comment for the tester.';
$lang['tests_dialogs_attachments'] = 'Attachments';
$lang['tests_dialogs_one_required'] = 'Specify at least one field or add an attachment.';
$lang['tests_dialogs_status_required'] = 'The Status field is required.';
$lang['tests_dialogs_assignto_required'] = 'The Assign To field is required.';
$lang['tests_dialogs_assignto_invalid'] = 'The Assign To field specifies an unknown or inactive user or has an invalid format.';
$lang['tests_dialogs_assignto_unassign'] = 'Nobody (Unassigned)';
$lang['tests_dialogs_assignto_me'] = 'Me';
$lang['tests_dialogs_width'] = 'Width';
$lang['tests_dialogs_height'] = 'Height';

$lang['tests_results'] = 'Results';
$lang['tests_results_one_required'] = 'One of Status ID, Assigned To or Comment is required';
$lang['tests_results_empty'] = 'Field {0} cannot be empty (one result is required)';
$lang['tests_results_no_templates'] = 'Field {0} cannot be empty but no valid tests or cases found';
$lang['tests_results_no_test'] = 'Field {0} contains one or more invalid results (test {1} unknown or not part of the test run)';
$lang['tests_results_no_case'] = 'Field {0} contains one or more invalid results (case {1} unknown or not part of the test run)';
$lang['tests_results_no_status'] = 'Field {0} contains one or more invalid results (one of Status ID, Assigned To or Comment is required)';

$lang['tests_changes_title_comment'] = 'Comment';
$lang['tests_changes_title_assignment'] = 'Assigned';
$lang['tests_changes_title_attachment'] = 'File';
$lang['tests_changes_title_attachments'] = 'Files';
$lang['tests_changes_attachments'] = 'Attachments';
$lang['tests_changes_content_status'] = '*This test was marked as \'{0}\'.*';
$lang['tests_changes_content_assignment'] = '*This test was assigned to {0}.*';
$lang['tests_changes_content_unassigned'] = '*This test was unassigned.*';
$lang['tests_changes_content_attachments'] = '*The following files were attached to this test:*';
$lang['tests_changes_content_attachment'] = '*The following file was attached to this test:*';
$lang['tests_changes_meta_assignedto'] = 'Assigned To';
$lang['tests_changes_meta_assignedto_unassigned'] = 'Nobody';
$lang['tests_changes_meta_version'] = 'Version';
$lang['tests_changes_meta_elapsed'] = 'Elapsed';
$lang['tests_changes_meta_defects'] = 'Defects';
$lang['tests_changes_edit_hint'] = 'Editing this test result/comment is no longer allowed.';

$lang['tests_denied_add'] = 'You are not allowed to add test results (insufficient permissions).';
$lang['tests_denied_edit'] = 'You are not allowed to edit test results (insufficient permissions).';
$lang['tests_denied_edit_last'] = 'You are not allowed to edit test results (it is not most resent test result).';
$lang['tests_denied_completed'] = 'This operation is not allowed. The test is already completed.';
$lang['tests_denied_edit_expired'] = 'Editing this test result or comment is no longer allowed.';
$lang['tests_denied_delete_attachment'] = 'Deleting attachments of test results or comments is not allowed.';

$lang['tests_sidebar_case'] = 'Test Case';
$lang['tests_sidebar_case_desc'] = 'This is a test for the following test case:';
$lang['tests_sidebar_case_original_available'] = 'This test is completed. The original test case for this test is:';
$lang['tests_sidebar_case_original_deleted'] = 'This test is completed. The original test case for this test is no longer available.';
$lang['tests_sidebar_attachments'] = 'Attachments';
$lang['tests_sidebar_attachments_desc'] = 'The following files are attached to the test case:';
$lang['tests_sidebar_attachments_original'] = 'The following files were attached to the original test case:';
$lang['tests_sidebar_assignedto'] = 'Assigned To';

$lang['tests_sidebar_timer_button_start_timer'] = 'Start Progress';
$lang['tests_sidebar_timer_button_start'] = 'Start';
$lang['tests_sidebar_timer_button_start_hint'] = 'Track test times and show other users that you are working on this test.';
$lang['tests_sidebar_timer_button_resume'] = 'Resume';
$lang['tests_sidebar_timer_button_stop'] = 'Stop';
$lang['tests_sidebar_timer_button_pause'] = 'Pause';
$lang['tests_sidebar_timer'] = 'Progress';
$lang['tests_sidebar_timer_minutes'] = 'You\'ve been working on this test for <strong>{0} {0?{minutes}:{minute}}</strong>.';
$lang['tests_sidebar_timer_other_testers'] = 'Also working on this test: {0}.';

$lang['tests_sidebar_timer_tester'] = '<strong>{0}</strong>';
$lang['tests_sidebar_tester_unassigned'] = 'This test is unassigned. <a {0}>Assign test</a>';
$lang['tests_sidebar_tester_assigned'] = 'Assigned to <strong class="text-softer">{0}</strong>. <a {1}>Change</a>';
$lang['tests_sidebar_tester_assigned_to_user'] = 'Assigned to <strong class="text-softer">you</strong>. <a {0}>Change</a>';

$lang['tests_subscription_subscribe_desc'] = 'Subscribe to receive emails on changes for this test.';
$lang['tests_subscription_unsubscribe_desc'] = 'Unsubscribe from email updates on changes for this test.';
$lang['tests_subscription_subscribed_to_run'] = 'You are subscribed to the entire test run and cannot unsubscribe from this specific test.';

$lang['tests_in_run'] = 'in';

$lang['tests_print_hint'] = 'Print Test';
$lang['tests_print_hint_desc'] = 'Opens a print view of this test and its results.';
$lang['tests_results_title'] = 'Jump to the results of this test.';

$lang['tests_directions_mode'] = 'Direction Mode';
$lang['tests_directions_run'] = 'All tests in this run';
$lang['tests_directions_run_title'] = 'Go the previous or next test in this test run.';
$lang['tests_directions_run_assigned'] = 'My tests in this run';
$lang['tests_directions_run_assigned_title'] = 'Go the previous or next test in this test run that is assigned to you.';
$lang['tests_directions_todo'] = 'My current todos';
$lang['tests_directions_todo_title'] = 'Go the previous or next test in your todo list.';
$lang['tests_directions_prev_title'] = 'Go to the previous test in this test run.';
$lang['tests_directions_next_title'] = 'Go to the next test in this test run.';
$lang['tests_directions_no_next'] = 'There are no more tests after the current test.';
$lang['tests_directions_no_prev'] = 'There are no more tests before the current test.';

$lang['tests_tabs_results'] = 'Results &amp; Comments';
$lang['tests_tabs_results_related'] = 'History &amp; Context';
$lang['tests_tabs_defects_related'] = 'Defects';

$lang['tests_history_empty'] = 'No tests or results have been added so far.';
$lang['tests_defects_empty'] = 'No defects are linked to the test or test case.';
$lang['tests_changes_empty'] = 'No test results or comments so far.';

$lang['tests_help_results'] = 'The <strong>Results &amp; Comments</strong> tab shows the results, comments and
assignments for the current test in this run in chronological order.';
$lang['tests_help_history'] = 'The <strong>History &amp; Context</strong> tab shows all related tests over time
(all tests of the same <em>test case</em>). This can include related tests of other configurations in the same
test plan or past test runs. The current test in this run is highlighted.
<br /><br />
A line chart at the top displays recent and related test results with the recorded statuses.';
$lang['tests_help_defects'] = 'The <strong>Defects</strong> tab shows all logged defects for related tests over time
(all defects of the same <em>test case</em>). Defects of the current test in this run are highlighted.';
$lang['tests_no_longer_exists'] = 'Test case no longer exists.';
