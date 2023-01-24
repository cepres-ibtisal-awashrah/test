<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

$lang['case_statuses_add'] = 'Add Case Status';
$lang['case_statuses_save'] = 'Save Case Status';
$lang['case_statuses_delete_confirm'] = 'Really delete case status <strong>{0}</strong>? Cases with this status will be assigned the default status.';
$lang['case_statuses_delete_confirm_checkbox'] = 'Yes, delete this case status (cannot be undone)';

$lang['case_statuses_name'] = 'Name';
$lang['case_statuses_status'] = 'Case Status';
$lang['case_statuses_short_name'] = 'Abbreviation';
$lang['case_statuses_isapproved'] = 'This case status is an approved status';
$lang['case_statuses_isdefault'] = 'Default?';
$lang['case_statuses_default'] = 'Default';
$lang['case_statuses_short_name_desc'] = 'A shorter version of the full name. It is used to display the case status in grids and tables. Leave empty to use the full name.';
$lang['case_statuses_isapproved_desc'] = 'A Test Case with a version in an Approved Status will appear in test runs if the case meets test run filter criteria.';
$lang['case_statuses_isdefault_desc'] = 'This will mark this Case Status as default. The Default Case Status cannot be deleted.';

$lang['case_statuses_validation_invalid_name'] = 'Invalid characters in System Name: please only use a-z (lower case), 0-9 and underscore characters.';
$lang['case_statuses_validation_unique'] = 'System Name already in use. Please choose another name for your case status.';

$lang['case_statuses_success_add'] = 'Successfully added the case status.';
$lang['case_statuses_success_update'] = 'Successfully updated the case status.';
$lang['case_statuses_success_delete'] = 'Successfully deleted the case status.';
$lang['case_statuses_error_default'] = 'Deleting the default case status is not allowed.';

$lang['case_statuses_no_status'] = 'The specified case status does not exist.';
$lang['case_statuses_denied'] = 'Denied.';
$lang['case_statuses_license_required'] = 'You do not have permission to access this endpoint (Requires Enterprise license or subscription).';
