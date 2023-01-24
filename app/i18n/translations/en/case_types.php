<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

$lang['case_types_type'] = 'Case Type';
$lang['case_types_name'] = 'Name';
$lang['case_types_name_desc'] = 'Ex: <em>Automated</em>, <em>Usability</em> or <em>Other</em>';

$lang['case_types_isdefault'] = 'This case type is the default type';
$lang['case_types_isdefault_desc'] = 'The default case type is the pre-selected type for new
cases and the fallback type when you delete other case types. Only one type can be selected
as the default.';

$lang['case_types_no_type'] = 'The specified case type does not exist.';
$lang['case_types_errors_no_default'] = 'No default case type found.';
$lang['case_types_errors_is_default'] = 'The case type is the default case type and cannot be deleted.';

$lang['case_types_add'] = 'Add Type';
$lang['case_types_save'] = 'Save Type';
$lang['case_types_delete_confirm'] = 'Really delete case type <strong>{0}</strong>? Cases with this type will be assigned the default case type.';
$lang['case_types_delete_confirm_checkbox'] = 'Yes, delete this case type (cannot be undone)';

$lang['case_types_success_add'] = 'Successfully added the new case type.';
$lang['case_types_error_default'] = 'Deleting the default case type is not allowed.';
$lang['case_types_success_update'] = 'Successfully updated the case type.';
$lang['case_types_success_delete'] = 'Successfully deleted the case type.';
