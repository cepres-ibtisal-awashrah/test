<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

$lang['roles_role'] = 'Role';
$lang['roles_name'] = 'Name';
$lang['roles_name_desc'] = 'Ex: <em>Lead</em>, <em>Tester</em> or <em>Guest</em>';

$lang['roles_isdefault'] = 'This role is the default role';
$lang['roles_isdefault_desc'] = 'The default role is the pre-selected role for new
users and the fallback role for users when you delete other roles. Only one role
can be selected as the default.';

$lang['roles_permissions'] = 'Permissions';
$lang['roles_additional_permissions'] = 'Additional Permissions';

$lang['roles_permissions_suites'] = 'Suites';
$lang['roles_permissions_cases'] = 'Cases &amp; Sections';
$lang['roles_permissions_milestones'] = 'Milestones';
$lang['roles_permissions_runs'] = 'Runs &amp; Plans';
$lang['roles_permissions_runs_closed'] = 'Runs &amp; Plans (Closed)';
$lang['roles_permissions_reports'] = 'Reports';
$lang['roles_permissions_report_jobs'] = 'Reports (Scheduled)';
$lang['roles_permissions_configs'] = 'Configurations';
$lang['roles_permissions_results'] = 'Test Results';
$lang['roles_permissions_attachments'] = 'Attachments';
$lang['roles_permissions_case_approval'] = 'Test Case Approval';
$lang['roles_permissions_workloads'] = 'ToDo Workloads for Other Users';

$lang['roles_no_role'] = 'The specified role does not exist.';
$lang['roles_errors_no_default'] = 'No default role found.';
$lang['roles_errors_is_default'] = 'The role is the default role and cannot be deleted.';

$lang['roles_add'] = 'Add Role';
$lang['roles_save'] = 'Save Role';
$lang['roles_success_add'] = 'Successfully added the new role.';
$lang['roles_error_add'] = 'An error occurred while adding the new role.';
$lang['roles_error_exists'] = 'The specified role does not exist.';
$lang['roles_success_update'] = 'Successfully updated the role.';
$lang['roles_error_update'] = 'An error occurred while saving the role.';
$lang['roles_success_delete'] = 'Successfully deleted the role.';
$lang['roles_error_delete'] = 'An error occurred while deleting the role.';
$lang['roles_error_default'] = 'Deleting the default role is not allowed.';

$lang['roles_delete'] = 'Delete Role';
$lang['roles_delete_link'] = 'Delete this role';
$lang['roles_delete_confirm'] = 'Really delete role <strong>{0}</strong>? Users with this role will be assigned the default role <em>(no users are deleted)</em>.';
$lang['roles_delete_confirm_checkbox'] = 'Yes, delete this role (cannot be undone)';

$lang['roles_enable_project_admin_title'] = 'Enable project administration for this role';
$lang['roles_enable_project_admin_desc'] = 'Project administration settings will only apply to users with this role set as their Global Role. Enabling this setting will provide access to a subset of the Administration area. Any additional permissions will apply only to projects which are assigned to each user.';
$lang['roles_permissions_pa_permissions'] = 'Project Administration Permissions';
$lang['roles_permissions_case_fileds'] = 'Case Fields & Templates';

$lang['roles_denied_access'] = 'You are not allowed to access user roles (requires administrator privileges).';