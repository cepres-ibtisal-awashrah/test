<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

$lang['shared_steps_shared_step'] = 'Shared step';

$lang['shared_steps_overview_empty_title'] = "This project doesn't contain any shared test steps, yet.";
$lang['shared_steps_overview_empty_body'] = 'No shared test steps have been added to this project yet. Use the following button to add the first shared test step.';
$lang['shared_steps_overview_empty_noaccess_body'] = "No shared test steps have been added to this project yet.
Unfortunately, you don't have the required permissions to add new shared test steps.
Please contact your administrator.";
$lang['shared_steps_overview_empty_expl_title'] = "What's a shared test step?";
$lang['shared_steps_overview_empty_expl_body'] = 'A shared test step is a test step which can be used in one or more test cases. This allows you to edit a single set of test steps and have these edits appear in any test cases using these steps.';

$lang['shared_steps_actions'] = 'Actions';
$lang['shared_steps_delete_link'] = 'Delete';
$lang['shared_steps_delete_descr'] = 'Delete this set of Shared Steps. This will also delete every instance of it across your Test Cases.';
$lang['shared_steps_delete_confirm'] = 'Choose your way to proceed:';
$lang['shared_steps_about'] = 'About';
$lang['shared_steps_created_on'] = 'Created on';
$lang['shared_steps_created_by'] = 'By';
$lang['shared_steps_used_in'] = 'Used In (Test Cases)';
$lang['shared_steps_already_used_in_one'] = 'Shared step set already used in';
$lang['shared_steps_already_used_in_two'] = 'test cases.';

$lang['shared_steps_new'] = 'Add Shared Test Step';
$lang['shared_steps_new_descr'] = 'Create a set of Shared Steps that you can use in as many Test Cases as you want.';
$lang['shared_steps_to_use'] = 'To use Shared Steps';
$lang['shared_steps_import'] = 'import them from desired Test Case.';
$lang['shared_steps_go_to_cases'] = 'Back to Test Cases';
$lang['shared_steps_title'] = 'Shared Steps set name:';
$lang['shared_steps_fields_title'] = 'Shared Steps set name';
$lang['shared_steps_success_insert'] = 'Successfully created Shared Steps';
$lang['shared_steps_success_update'] = 'Successfully updated Shared Steps';

$lang['shared_steps_filter_title'] = 'Title';
$lang['shared_steps_filter_used_in_suite'] = 'Used In (Test Suite)';
$lang['shared_steps_filter_used_in_case'] = 'Used In (Test Case)';
$lang['shared_steps_filter_empty'] = 'No shared steps found.';

$lang['shared_steps_denied_add'] = 'You are not allowed to add shared test steps (insufficient permissions).';
$lang['shared_steps_denied_edit'] = 'You are not allowed to edit shared test steps (insufficient permissions).';
$lang['shared_steps_denied_delete'] = 'You are not allowed to delete shared test steps (insufficient permissions).';
$lang['shared_steps_no_steps_field'] = 'Cannot find a separated steps field.';

$lang['shared_steps_steps_api'] = "'steps'";
$lang['shared_steps_title_api'] = "'title'";

$lang['import_shared_steps'] = 'Import shared steps';
$lang['import_shared_steps_dialog_title'] = 'Browse and select Shared Steps';
$lang['import_shared_steps_dialog_preview'] = 'Preview';
$lang['import_shared_steps_dialog_import_steps'] = 'Import steps';
$lang['import_shared_steps_dialog_cancel'] = 'Cancel';
$lang['import_shared_steps_dialog_after'] = 'after';
$lang['import_shared_steps_dialog_before'] = 'before';
$lang['import_shared_steps_dialog_insert'] = 'Insert';
$lang['import_shared_steps_dialog_thestep'] = 'the step';

$lang['shared_steps_changes_title'] = 'Title';
$lang['shared_steps_changes_content'] = 'Content';
$lang['shared_steps_changes_additional_info'] = 'Additional Info';
$lang['shared_steps_changes_expected'] = 'Expected';
$lang['shared_steps_changes_references'] = 'References';

$lang['shared_steps_step_cannot_be_empty'] = 'Shared test step cannot be empty.';

$lang['create_shared_steps_dialog_title'] = 'Create Shared Steps';
$lang['create_shared_steps_dialog_hint'] = 'Only consecutive steps can be declared as shared steps.';
$lang['create_shared_steps_dialog_create_steps'] = 'Create';
$lang['create_shared_steps_dialog_cancel'] = 'Cancel';
$lang['create_shared_steps_dialog_share_one_or_more'] = 'Share <strong>one</strong> or <strong>several</strong> steps to re-use them across your projects.';
$lang['create_shared_steps_dialog_share_name'] = 'Define a Name for the Shared Steps Set';
$lang['create_shared_steps_dialog_share_select_steps'] = 'Select Steps';

$lang['create_shared_steps_confirmation_dialog_title'] = 'Shared Steps Created';
$lang['create_shared_steps_confirmation_dialog_created_successfully'] = 'created successfully!';
$lang['create_shared_steps_confirmation_dialog_hint'] = 'You’ll find your new set of Shared Steps on the Shared Steps<br />Dashboard. Now, go back to editing your Test Case.';
$lang['create_shared_steps_confirmation_dialog_close'] = 'Back to Test Case editing';

$lang['delete_shared_steps_dialog_title'] = 'Delete?';
$lang['delete_shared_steps_dialog_delete'] = 'Delete';
$lang['delete_shared_steps_dialog_delete_forever'] = 'Delete Forever';
$lang['delete_shared_steps_dialog_choose'] = 'Choose your way to proceed:';
$lang['delete_shared_steps_dialog_convert'] = 'Remove sharing property, but retain test step(s)<br />contents in test cases';
$lang['delete_shared_steps_dialog_hint'] = 'This cannot be undone.';
$lang['delete_shared_steps_dialog_delete_from_tc_one'] = 'Delete Shared Step(s) from';
$lang['delete_shared_steps_dialog_delete_from_tc_two'] = 'Test Case(s)';
$lang['delete_shared_steps_dialog_simplified_header'] = 'Delete selected shared steps permanently?';
$lang['delete_shared_steps_dialog_simplified_info'] = 'This action deletes these shared steps and cannot be undone.';

$lang['restore_shared_steps_dialog'] = '<strong>Restore Version {0}?</strong><br />These changes will create a new Shared Steps version and affect any corresponding test cases using these steps.';
