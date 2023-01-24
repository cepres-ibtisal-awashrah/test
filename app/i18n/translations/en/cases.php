<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$lang['cases_add'] = 'Add Test Case';
$lang['cases_add_and_next'] = 'Add & Next';
$lang['cases_edit'] = 'Edit Test Case';
$lang['cases_view'] = 'View Test Case';
$lang['cases_view_short'] = 'View Case';
$lang['cases_edit_short'] = 'Edit Case';

$lang['cases_actions'] = 'Actions';
$lang['cases_delete'] = 'Delete Test Case';
$lang['cases_delete_link'] = 'Delete this test case';
$lang['cases_delete_descr'] = 'Delete a test case to remove it from its test suite. This also deletes all related running tests.';
$lang['cases_save_qpane'] = 'Save';
$lang['cases_save'] = 'Save Test Case';
$lang['cases_save_many'] = 'Save Test Cases';

$lang['cases_edit_many_intro_title'] = 'Steps to update multiple cases';
$lang['cases_edit_many_intro_body_1'] = 'Review the cases to update or remove cases from the selection.';
$lang['cases_edit_many_intro_body_2'] = 'Enable the fields you want to update and select or enter their new values.';
$lang['cases_edit_many_intro_body_3'] = 'Save your changes (a dialog with a summary is shown before your changes are applied).';
$lang['cases_edit_all_intro_body_1'] = 'Select a filter if you want to apply the changes to a subset of cases only.';
$lang['cases_edit_all_intro_body_2'] = 'Enable the fields you want to update and select or enter their new values.';
$lang['cases_edit_all_intro_body_3'] = 'Save your changes (a dialog with a summary is shown before your changes are applied).';
$lang['cases_edit_many_filter_reset'] = 'Remove filter to apply the changes to all test cases.';
$lang['cases_edit_many_filter_empty'] = 'The selected filter does not match any test cases.';
$lang['cases_edit_many_cases_empty'] = 'You need to update at least one test case.';
$lang['cases_edit_many_diff_title'] = 'Review Changes';
$lang['cases_edit_many_diff_intro'] = 'The following changes are applied to all selected test cases.
This cannot be undone so please make sure to review the changes carefully.';
$lang['cases_edit_many_diff_confirm'] = 'Yes, update all {0} {0?{cases}:{case}}';
$lang['cases_edit_many_diff_confirm_dialog'] = 'Really update all included test cases? Note that this change cannot be undone and may affect a lot of test cases.';
$lang['cases_edit_many_nofields'] = 'You need to update at least one field (for example: Type, Priority, etc.).';
$lang['cases_edit_many_diff_empty'] = 'Empty';
$lang['cases_edit_many_scope'] = 'Edit Scope';
$lang['cases_edit_all_filter'] = 'Filter';
$lang['cases_edit_all_filter_cases'] = '<em>{0}</em> {0?{test cases}:{test case}} included.';
$lang['cases_edit_all_filter_cases_group'] = '<em>{0}</em> {0?{test cases}:{test case}} included (of group <em>{1}</em>).';
$lang['cases_edit_all_filter_cases_section'] = '<em>{0}</em> {0?{test cases}:{test case}} included (of section <em>{1}</em>).';
$lang['cases_edit_all_filter_cases_section_sub'] = '<em>{0}</em> {0?{test cases}:{test case}} included (of section <em>{1}</em>, incl. subsections).';

$lang['cases_selected_deleted_cases'] = 'You have selected test cases which are marked as deleted. In order to edit these cases, they must be restored. Press OK to restore these cases and continue to the edit screen.';
$lang['cases_delete_title'] = 'Really delete this test case forever? This also deletes all active tests and results for this case and cannot be undone.';
$lang['cases_delete_title'] = 'Really delete this test case?';
$lang['cases_bulk_delete_title'] = 'Really delete these test cases?';
$lang['cases_delete_description'] = '‘Mark as Deleted’ sets the Case Status to ‘Deleted’ and can later be restored from the test case history. ’Delete Permanently’ also deletes all active tests and results for this case and cannot be undone.';
$lang['cases_bulk_delete_description'] = '‘Mark as Deleted’ sets the Case Status to ‘Deleted’ and can later be restored from the test case history. ’Delete Permanently’ also deletes all active tests and results for these cases and cannot be undone.';
$lang['cases_delete_permanently_title'] = 'Delete this test case permanently?';
$lang['cases_bulk_delete_permanently_title'] = 'Delete these test cases permanently?';
$lang['cases_delete_permanently_description'] = 'This action deletes all active tests and results for this case and cannot be undone.';
$lang['cases_bulk_delete_permanently_description'] = 'This action deletes all active tests and results for these cases and cannot be undone.';

$lang['cases_various'] = 'Various';
$lang['cases_box'] = 'Test Case';
$lang['cases_case'] = 'Test Case';
$lang['cases_cases'] = 'Test Cases';
$lang['cases_permanently_delete'] = 'Permanently delete';
$lang['cases_inline'] = 'Inline';
$lang['cases_ids'] = 'Case IDs';
$lang['cases_id'] = 'ID';
$lang['cases_id_nolink'] = 'ID (no link)';
$lang['cases_included'] = 'Included';
$lang['cases_title'] = 'Title';
$lang['cases_title_nolink'] = 'Title (no link)';
$lang['cases_title_desc'] = 'Ex: <em>Opening a simple log file</em>';
$lang['cases_suite'] = 'Suite';
$lang['cases_suite_id'] = 'Suite ID';
$lang['cases_section'] = 'Section';
$lang['cases_section_full'] = 'Section Hierarchy';
$lang['cases_section_depth'] = 'Section Depth';
$lang['cases_section_desc'] = 'Section Description';
$lang['cases_title_and_link'] = 'Case Details (ID, Title and Link)';
$lang['cases_link'] = 'Case Link';
$lang['cases_offset'] = 'Offset';
$lang['cases_case_change'] = 'Test Case Version';
$lang['cases_case_change_id'] = 'Test Case Version ID';
$lang['cases_case_change_comment'] = 'Test Case Version Comment';
$lang['cases_case_change_comment_id'] = 'Test Case Version Comment ID';

$lang['cases_template'] = 'Template';
$lang['cases_type'] = 'Type';
$lang['cases_created_by'] = 'Created By';
$lang['cases_created'] = 'Created';
$lang['cases_created_on'] = 'Created On';
$lang['cases_updated_by'] = 'Updated By';
$lang['cases_updated'] = 'Updated';
$lang['cases_updated_on'] = 'Updated On';
$lang['cases_deletion_status'] = 'Deletion Status';
$lang['cases_priority'] = 'Priority';
$lang['cases_status'] = 'Status';
$lang['cases_estimate'] = 'Estimate';
$lang['cases_forecast'] = 'Forecast';
$lang['cases_references'] = 'References';
$lang['cases_milestone'] = 'Milestone';
$lang['cases_assignedto'] = 'Assigned To';
$lang['cases_assignto_me'] = 'Me';
$lang['cases_in_section'] = 'In section <a id="navigation-cases-section" href="{0}">{1}</a>.';
$lang['cases_description'] = 'Description';
$lang['cases_description_empty'] = 'No additional details available.';
$lang['cases_not_from_same_suite'] = 'Some test cases no longer exist or are from different test suites.';
$lang['cases_columns'] = 'Columns';
$lang['cases_filter'] = 'Filter';
$lang['cases_filter_save'] = 'Save Filter';
$lang['cases_people_dates'] = 'People &amp; Dates';
$lang['cases_people_status'] = 'People &amp; Status';
$lang['cases_mark_as_deleted'] = 'Mark as Deleted';
$lang['cases_delete_forever'] = 'Delete Permanently';

$lang['cases_pending_approval_short'] = 'Pending Approval';
$lang['cases_pending_approval_long'] = 'Test Case Pending Approval';

$lang['cases_softlock'] = 'Not saved: this test case has been changed by other users';
$lang['cases_softlock_desc'] = 'This case has been modified since you opened it
(by <em>{0}</em> on <em>{1}</em>, and possibly others). You can <a target="_blank" href="{2}">review the changes</a>
and still save the case. Please note that this will override all changes made by other users.';
$lang['cases_softlock_force'] = 'Yes, override all made changes and save my version';

$lang['cases_steps'] = 'Steps';
$lang['cases_steps_step_placeholder'] = 'Step Description';
$lang['cases_steps_id'] = 'Step ID';
$lang['cases_steps_name'] = 'Step Name';
$lang['cases_steps_loading'] = 'Loading steps ... ';
$lang['cases_steps_invalid'] = 'Steps field has an invalid format.';
$lang['cases_steps_add'] = 'Add Step';
$lang['cases_steps_content_image'] = 'Add an image to the Step field.';
$lang['cases_steps_expected'] = 'Expected Result';
$lang['cases_steps_expected_placeholder'] = 'Expected Result';
$lang['cases_steps_expected_image'] = 'Add an image to the Expected Result field.';
$lang['cases_steps_description'] = 'Step description';
$lang['cases_steps_additional'] = 'Additional step information';
$lang['cases_steps_additional_placeholder'] = 'Additional step information';
$lang['cases_steps_additional_image'] = 'Add an image to the additional step information.';
$lang['cases_steps_reference'] = 'Reference';
$lang['cases_steps_reference_placeholder'] = 'Reference';
$lang['cases_steps_add_reference_placeholder'] = 'Add a Reference';
$lang['cases_steps_shared_step_id'] = 'Shared step ID';
$lang['cases_steps_share_tooltip'] = 'Share this Step with other Test Cases';
$lang['cases_steps_import_tooltip'] = 'Import a Shared Step';
$lang['cases_steps_has_expected'] = 'Has Expected';
$lang['cases_steps_rows'] = 'Rows';
$lang['cases_steps_actual'] = 'Actual Result';
$lang['cases_steps_actual_enter'] = 'Enter actual result';
$lang['cases_steps_actual_image'] = 'Add an image to the Actual Result field.';
$lang['cases_steps_step'] = 'Step';
$lang['cases_steps_desc'] = 'The steps and expected results of this test case.';
$lang['cases_steps_empty_title'] = 'Add steps to this test case';
$lang['cases_steps_empty_title_many'] = 'Add steps to the test cases';
$lang['cases_steps_empty_body'] = 'For every test step, enter a short description and the
expected results. <a {0}>Add the first step</a>.';
$lang['cases_steps_explanation_title'] = 'What are steps?';
$lang['cases_steps_explanation_body'] = 'Enter all test steps needed to verify this test case.';
$lang['cases_steps_explanation_body_many'] = 'Enter all test steps needed to verify the test cases.';
$lang['cases_steps_confirm'] = 'Really delete this step? This operation cannot be undone.';
$lang['cases_shared_steps_confirm'] = 'Really remove the shared steps from this test case?';
$lang['cases_steps_shared_edit_disabled'] = 'Edit from the Shared Steps Dashboard';

$lang['cases_steps_field_invalid'] = 'Invalid custom field: the custom field may have been deleted.';
$lang['cases_steps_no'] = 'No test steps available.';
$lang['cases_steps_set_status'] = 'Set all steps to "{0}".';
$lang['cases_steps_step_status'] = 'This step is marked as "{0}".';
$lang['cases_steps_results'] = '{0} passed, {1} failed and {2} untested steps. <a {3}>Show details</a>.';
$lang['cases_steps_unavailable'] = 'No test steps available because you are adding multiple test results.';

$lang['cases_steps_hint_title'] = 'Did you know?';
$lang['cases_steps_hint_info'] = 'You can also configure TestRail to enter test steps separately:';
$lang['cases_steps_hint_more'] = 'Learn more';

$lang['cases_success_add'] = 'Successfully added the new test case. <a href="{0}">Add another</a>';
$lang['cases_success_view'] = 'Successfully added the new test case. <a href="{0}">View test case</a>';

$lang['cases_success_delete'] = 'Successfully deleted the test case.';
$lang['cases_success_mark_as_deleted'] = 'Successfully flagged the test case as deleted.';
$lang['cases_success_restore'] = 'Successfully restored the test case.';
$lang['cases_success_update'] = 'Successfully updated the test case.';
$lang['cases_success_update_many'] = 'Successfully updated the test cases.';
$lang['cases_error_add'] = 'An error occurred while adding the new test case.';
$lang['cases_error_exists'] = 'The specified test case does not exist or you do not have the permission to access it.';
$lang['cases_error_delete'] = 'An error occurred while deleting the test case. Maybe the test case didn\'t exist anymore?';
$lang['cases_error_update'] = 'An error occurred while saving the test case.';
$lang['cases_error_case_invalid'] = 'One or more of the selected cases no longer exist. Please refresh this page.';
$lang['cases_error_parent_invalid'] = 'The cases are not from the same test suite.';
$lang['cases_error_suite_invalid'] = 'The test suite for the cases no longer exists. Please refresh this page.';
$lang['cases_error_project_invalid'] = 'The project for the tests no longer exists. Please refresh this page.';

$lang['cases_denied_add'] = 'You are not allowed to add test cases (insufficient permissions).';
$lang['cases_denied_edit'] = 'You are not allowed to edit test cases (insufficient permissions).';
$lang['cases_denied_restore'] = 'You are not allowed to restore test cases (insufficient permissions).';
$lang['cases_denied_copy'] = 'You are not allowed to copy test cases (insufficient permissions).';
$lang['cases_denied_move'] = 'You are not allowed to move test cases (insufficient permissions).';
$lang['cases_denied_delete'] = 'You are not allowed to mark test cases as deleted (insufficient permissions).';
$lang['cases_denied_permanently_delete'] = 'You are not allowed to permanently delete test cases (insufficient permissions).';
$lang['cases_denied_readonly'] = 'This operation is not allowed. The test case is read-only.';
$lang['cases_denied_deleted'] = 'This operation is not allowed. The test case is flagged as deleted.';
$lang['cases_denied_approve'] = 'You are not allowed to approve test cases (insufficient permissions).';

$lang['cases_dnd_copy'] = 'Copy here';
$lang['cases_dnd_copy_hint'] = '(shift)';
$lang['cases_dnd_move'] = 'Move here';
$lang['cases_dnd_move_hint'] = '(ctrl/cmd)';
$lang['cases_dnd_cancel'] = 'Cancel';

$lang['cases_auto_section'] = 'Test Cases';
$lang['cases_no_attachments'] = 'No attachments.';
$lang['cases_related'] = 'Related Test Cases';
$lang['cases_no_related'] = 'None';
$lang['cases_linking_here'] = 'Test cases linking here';
$lang['cases_links_to_others'] = 'Links to other test cases';

$lang['cases_grid_case'] = 'Test Case';
$lang['cases_grid_add'] = 'Add Test Case';
$lang['cases_grid_nocases'] = 'No test cases.';

$lang['cases_invalid_milestone'] = 'The specified milestone is invalid or belongs to a different project.';
$lang['cases_invalid_status'] = 'The specified status is invalid.';
$lang['cases_invalid_section'] = 'The specified section is invalid or belongs to a different suite/project.';
$lang['cases_invalid_javascript'] =
'The JavaScript of your browser is not working properly and the test case wasn\'t saved as a safety measure.
This can be caused by malfunctioning browser plugins or invalid UI scripts that were added to your TestRail installation.
Please contact your TestRail administrator to look into this.';
$lang['cases_error_move'] = 'Moving the case to the new section failed.';

$lang['cases_activity_empty'] = 'No activity yet.';
$lang['cases_tests'] = 'Tests &amp; Results';

$lang['cases_restore'] = 'Restore Test Case';
$lang['cases_print_hint'] = 'Print Case';
$lang['cases_print_hint_desc'] = 'Opens a print view of this test case.';
$lang['cases_edit_title'] = 'Edit Case Title';
$lang['cases_edit_title_save'] = 'Save Title';
$lang['cases_edit_title_required'] = 'The Case Title field is required.';
$lang['cases_edit_title_field'] = 'Case Title';
$lang['cases_edit_title_desc'] = 'Edit the title of the test case. ';

$lang['cases_sidebar_case'] = 'Details';
$lang['cases_sidebar_results'] = 'Tests &amp; Results';
$lang['cases_sidebar_history'] = 'History';
$lang['cases_sidebar_defects'] = 'Defects';

$lang['cases_results_runs'] = 'Runs';
$lang['cases_results_changes'] = 'Results &amp; Comments';
$lang['cases_results_empty'] = 'No test results so far.';
$lang['cases_results_empty_desc'] = 'Results can be added in test runs on the Test Runs &amp; Results tab.';

$lang['cases_history_created'] = 'Created';
$lang['cases_history_created_desc'] = 'This test case was created.
Changes to this test case are displayed above, separately for each update.';
$lang['cases_history_restored_desc'] = 'This test case was restored.';
$lang['cases_history_deleted_desc'] = 'This test case was deleted.';
$lang['cases_history_updated'] = 'Updated';
$lang['cases_history_deleted'] = 'Deleted';
$lang['cases_history_current'] = 'Current';
$lang['cases_history_unknown'] = 'Unknown Date';
$lang['cases_history_version'] = 'Version:';
$lang['cases_history_restore'] = 'Restore';
$lang['cases_history_restore_selected'] = 'Restore Selected';
$lang['cases_history_compare_to'] = 'Compare to...';
$lang['cases_history_show_current'] = 'Show Current Version';
$lang['cases_history_compare_placeholder'] = 'Enter a date, version number...';
$lang['cases_history_back_button'] = 'Back to Version History';
$lang['cases_history_restore_description'] = '<strong>Restoring</strong> this version. This will replace latest version. Current version will be saved as the most recent historic version. Click on the “Restore” button to perform this action. You can also restore selected sections only.';
$lang['cases_history_restore_success'] = 'Successfully restored selected version of this test case.';
$lang['cases_history_restore_confirm_title'] = '<strong>Restore Version {0}?</strong><br />';
$lang['cases_history_restore_confirm_title_partial'] = '<strong>Restore selected sections of Version {0}?</strong><br />';
$lang['cases_history_restore_confirm'] = 'These changes will create a new test case version and affect any corresponding tests in open test runs.';
$lang['cases_history_restore_template_warning'] = '<br /><strong>Warning!</strong> Some selected fields are not present in the current template. Proceeding with the restore will change the test case template and may change other available fields.';
$lang['cases_history_compare_description'] = 'You can <strong>compare</strong> two different historical versions of the test case. When comparing a previous test case version to the current version, you can restore all previous data from the version on the right, or select individual fields.';
$lang['cases_history_compare_disabled'] = 'Please select the current version on the left before restoring data';
$lang['cases_history_comment_description'] = '<strong>All comments</strong> from all versions. Comments entered here will be added to the latest version.';
$lang['cases_history_all_comments'] = 'ALL ({0})';
$lang['cases_history_comments_close'] = 'Close';
$lang['cases_history_comments_header'] = 'Showing {0} of {1} comments';
$lang['cases_history_comments_show_more'] = 'View {0} older comments';
$lang['cases_history_comments_header_single'] = '{0} Comment(s)';
$lang['cases_history_comments_header_all'] = '(All)';
$lang['cases_history_comments_tooltip'] = 'Click to add and read comments';
$lang['cases_history_comments_all_tooltip'] = 'View all comments';
$lang['cases_history_comment_placeholder'] = 'Enter your comment...';
$lang['cases_history_comment_save'] = 'Save';
$lang['cases_history_comment_cancel'] = 'Cancel';
$lang['cases_history_comment_edit_button'] = 'Edit';
$lang['cases_history_comment_delete_button'] = 'Delete';
$lang['cases_history_comment_delete'] = '<strong>Delete this comment?</strong><br />This action deletes the comment and cannot be undone.';
$lang['cases_history_comment_version'] = 'Version {0}';
$lang['cases_history_restore_field_missing'] = 'This field is not present in the current template. Restoring this field will restore the test case template also.';

$lang['cases_defects'] = 'Defects';
$lang['cases_defects_empty'] = 'No defects so far.';
$lang['cases_defects_empty_desc'] = 'Defects can be linked on the Add Result dialog when adding results for this case (on the Test Runs &amp; Results tab).';

$lang['cases_no_default_priority'] = 'There is no default value for the test case priority.';
$lang['cases_no_default_status'] = 'There is no default value for the test case status.';
$lang['cases_no_default_case_type'] = 'There is no default value for the test case type.';
$lang['cases_no_default_template'] = 'There is no default value for the test case template.';

$lang['cases_directions_prev_title'] = 'Go to the previous test case in this suite.';
$lang['cases_directions_next_title'] = 'Go to the next test case in this suite.';
$lang['cases_directions_no_next'] = 'There are no more test cases after the current case.';
$lang['cases_directions_no_prev'] = 'There are no more test cases before the current case.';
$lang['cases_warning_is_added_using_dynamic_filter'] = 'These changes will remove the test case from {0} {0?{test runs}:{test run}}.';
$lang['cases_is_dynamic_icon'] = 'Test Case Added by Dynamic Filtering';
$lang['cases_warning_is_removed_using_dynamic_filter'] = 'These changes will remove tests from <b id="testRunsCount"></b> test runs.';
$lang['cases_warning_for_move_across_sections'] = 'These changes will remove the tests from {0} {0?{test runs}:{test run}}.';

$lang['cases_reuse_this_step_message'] = 'Want to reuse this Step?';
$lang['cases_reuse_this_step_button'] = 'Share';
$lang['cases_similar_step_message'] = 'Similar Shared Step found';
$lang['cases_similar_step_button'] = 'Import?';
$lang['cases_step_add_new_ref'] = 'Add new';

$lang['cases_share'] = 'Share';
$lang['cases_import'] = 'Import';

$lang['cases_dialogs_status'] = 'Status';
$lang['cases_dialogs_status_desc'] = 'Set the case status.';
$lang['cases_dialogs_assignto'] = 'Assign To';
$lang['cases_dialogs_assignto_desc'] = 'Assign to another team member.';
$lang['cases_dialogs_comment'] = 'Comment';
$lang['cases_dialogs_comment_desc_assign'] = 'Add a comment for the assignee.';
$lang['cases_dialogs_comment_desc_assign_edit'] = 'Edit your comment for the assignee.';
$lang['cases_dialogs_attachments'] = 'Attachments';
$lang['cases_dialogs_one_required'] = 'Specify at least one field or add an attachment.';
$lang['cases_dialogs_status_required'] = 'The Status field is required.';
$lang['cases_dialogs_assignto_required'] = 'The Assign To field is required.';
$lang['cases_dialogs_assignto_invalid'] = 'The Assign To field specifies an unknown or inactive user or has an invalid format.';
$lang['cases_dialogs_assignto_unassign'] = 'Nobody (Unassigned)';
$lang['cases_dialogs_assignto_me'] = 'Me';

$lang['cases_actions_comment'] = 'Add Comment or File';
$lang['cases_actions_comment_edit'] = 'Edit Comment';
$lang['cases_actions_assignto'] = 'Assign To';
$lang['cases_actions_assignto_edit'] = 'Edit Assign To';
$lang['cases_actions_assignto_selected'] = 'Assign selected';
$lang['cases_actions_assignto_selected_hint'] = 'Assigns all selected cases to a user.';
$lang['cases_actions_assignto_view'] = 'Assign all in current view';
$lang['cases_actions_assignto_view_hint'] = 'Assigns all cases in the current view (section or group) to the selected user, respecting the current filter.';
$lang['cases_actions_assignto_all'] = 'Assign all in filter';
$lang['cases_actions_assignto_all_hint'] = 'Assigns all cases of the suite to the selected user, respecting the current filter.';

$lang['cases_invalid_status_id'] = 'Invalid Status value.';
$lang['cases_invalid_assignedto'] = 'Invalid Assigned To field value.';

$lang['cases_normal_delete_description'] = 'Really mark the test case as deleted? This will remove the test case from any open test runs and set the status to `Deleted`. This can later be restored from the test case`s history.';
