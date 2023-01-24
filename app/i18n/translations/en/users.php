<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

$lang['users_tabs_users'] = 'Users';
$lang['users_tabs_groups'] = 'Groups';
$lang['users_tabs_roles'] = 'Roles';

$lang['users_show'] = 'Show';
$lang['users_user'] = 'User';
$lang['users_name'] = 'Full Name';
$lang['users_country'] = 'Country';
$lang['users_name_desc'] = 'Ex: <em>John Doe</em> or <em>Jane Doe</em>';
$lang['users_progress'] = 'Working On';

$lang['users_email'] = 'Email Address';
$lang['users_last_active'] = 'Last Active';
$lang['last_active_tooltip'] = 'Gurock does not monitor this timestamp for billing purposes';
$lang['user_never_logged_in'] = 'Never logged in';
$lang['user_inactive_last_days'] = 'Inactive last 180 days';
$lang['users_notifications'] = 'Enable email notifications';
$lang['users_notifications_desc'] = 'Email notifications are sent for test changes and test results.
Note: global email notifications must also be enabled to use this feature.';

$lang['users_language'] = 'Language';
$lang['users_language_desc'] = 'Determines the language of the user interface.';
$lang['users_theme'] = 'Theme';
$lang['users_theme_desc'] = 'Determines the theme of the user interface.';
$lang['users_locale'] = 'Locale';
$lang['users_locale_desc'] = 'Determines how dates and numbers are formatted.';

$lang['users_timezone'] = 'Time Zone';
$lang['users_timezone_desc'] = 'Determines the time zone for dates and times.';
$lang['users_groups'] = 'Groups';
$lang['users_groups_desc'] = 'Allows you to configure the groups of the user (group memberships).';
$lang['users_groups_desc_many'] = 'Specifies the groups for the new users (group memberships).';

$lang['users_isactive'] = 'This user is active';
$lang['users_isactive_field'] = 'Active';
$lang['users_isactive_desc'] = 'Every active user needs a TestRail license.
You can disable users who no longer need access to reuse licenses.';
$lang['users_isadmin'] = 'This user is an administrator';
$lang['users_isadmin_desc'] = 'Administrators can add and delete projects, manage users and configure your TestRail installation.';
$lang['users_role'] = 'Role';
$lang['users_last_active'] = 'Last Active ';
$lang['users_last_active_date'] = 'Last Active Date: ';
$lang['users_role_desc'] = 'Specifies the global role and hence permissions of the user.
Can be overriden for each project on the individual
<a class="link" tabindex="-1" href="{0}">project settings</a>.
<a class="link" tabindex="-1" target="_blank" href="https://www.gurock.com/testrail/docs/user-guide/howto/permissions">Learn more</a>';
$lang['users_role_desc_many'] = 'Specifies the global role and hence permissions for the new users.
Can be overriden for each project on the individual
<a class="link" tabindex="-1" href="{0}">project settings</a>.
<a class="link" tabindex="-1" target="_blank" href="https://www.gurock.com/testrail/docs/user-guide/howto/permissions">Learn more</a>';

$lang['users_editing_own_account'] = '<strong>Please note:</strong> You are editing your own user account.';
$lang['users_password_external_auth'] = '<strong>Please note:</strong> Your TestRail installation uses external authentication. Changing your password here will not change the external password.
    Please contact your TestRail administrator in case you have any questions.';

$lang['users_login'] = 'Login';
$lang['users_password'] = 'Password';
$lang['users_password_desc_notrequired'] = 'Leave empty to keep the current password.';
$lang['users_password_desc_required'] = 'Please confirm this password in the next field.';
$lang['users_password_mismatch'] = 'Password and Confirm fields do not match.';
$lang['users_password_policy_mismatch'] = 'The given password does not match the configured password policy. Please try again or contact your TestRail administrator.';
$lang['users_password_policy_mismatch_admin'] = 'The given password does not match the configured password policy. Please try again or see Site Settings > Security for details.';
$lang['users_password_policy_mismatch_fmt'] = 'The given password does not match the configured password policy: {0}';
$lang['users_password_current_required'] = 'To change your email address or password, please enter your current password
for verification. Please enter your current password and try again.';
$lang['users_password_current_invalid'] = 'The password you entered to verify the email address or password change is incorrect.
Please enter your current password and try again.';
$lang['users_password_dialog'] = 'Enter Password';
$lang['users_password_dialog_intro'] = 'To change your email address or password, please enter your current password
for verification.';
$lang['users_edit_password_dialog_intro'] = 'To change the email address or password of the user, please enter your current password for verification.';

$lang['users_reset_password_link'] = 'Force Password Change';
$lang['users_reset_password_descr'] = 'Force this user to change their password.';
$lang['users_reset_password_confirm'] = 'Really force a password change for this user? The user will be logged out and redirected to the Login page upon their next action. This may result in lost work. If they have an API key, this will be deleted also.';
$lang['users_reset_password_checkbox'] = 'Yes, force this user to change their password.';
$lang['users_success_reset_password_forced'] = 'Successfully forced the user to reset their password.';

$lang['users_invite_field'] = 'Invite';
$lang['users_invite_disabled'] = 'The Invite feature is disabled for your TestRail installation. Please see Site Settings > Security for details.';
$lang['users_invite'] = 'Invite user via email';
$lang['users_invite_desc'] = 'Use this option to send an invitation email to the new user
with instructions on how to set the password (no password is sent).';
$lang['users_invite_many'] = 'Send invitation email to new users';
$lang['users_invite_many_desc'] = 'Use this option to send an invitation email to new users
with instructions on how to set their password (no password is sent).
Useful to disable if you use external authentication (e.g. LDAP/Active Directory).';
$lang['users_invite_no'] = 'Manually specify password (no invitation is sent)';
$lang['users_invite_no_desc'] = 'No invitation email is sent when you use this option and you can manually
specify the password.';
$lang['users_confirm'] = 'Confirm Password';

$lang['users_users'] = 'Users';
$lang['users_users_desc'] = 'Add one user per line in the following format: <strong>email, full name</strong>. Already existing users are ignored.';
$lang['users_users_state_exists'] = 'Exists';
$lang['users_users_state_new'] = 'New';
$lang['users_users_state_success'] = 'Success';
$lang['users_users_state_error'] = 'Error';
$lang['users_users_dialog_title'] = 'Adding Users ..';
$lang['users_users_dialog_return'] = 'Return to Users &amp; Roles';
$lang['users_users_dialog_success'] = 'Successfully added all users.';
$lang['users_users_dialog_license_generic'] = 'There is a problem with your current TestRail license: {0}';
$lang['users_users_dialog_license_nonewuser'] = 'Cannot add a new user ({0} of {1} allowed named users are already in use).
Please add additional named users to your TestRail license or deactivate another user.';
$lang['users_users_dialog_license_nonewuser_hosted'] = 'Cannot add a new user ({0} of {1} allowed active users are already in use).
Please upgrade your subscription or deactivate another user.';
$lang['users_users_extras_show'] = '<a {0}>Configure additional fields</a> such as the role or groups or keep the defaults.';
$lang['users_users_preview'] = 'Preview';
$lang['users_users_preview_desc'] = 'Shows a preview as you add new users to the text box on the left.';
$lang['users_users_invalid_empty'] = 'No users to add. Please add at least one new user to the user list.';
$lang['users_users_invalid_syntax'] = 'Invalid line format (use: full name, email)';
$lang['users_users_invalid_syntax_long'] = 'Invalid line format (use: full name, email). Please check the user list.';
$lang['users_users_preview_intro_title'] = 'Steps to add multiple users';
$lang['users_users_preview_intro_body_1'] =
'<p>Enter each user on a separate line in the text box below using the following format:</p>

<div style="margin: 1em; color: #505050">
<p class="top" style="font-style: italic">
Alice Doe, alice@example.com<br />
Bob Doe, bob@example.com<br />
</p>
</div>';

$lang['users_users_preview_intro_body_2'] = 'Optionally configure additional fields for the users such as the role and groups';
$lang['users_users_preview_intro_body_3'] = 'Use the Add button at the bottom of the page to add the users';

$lang['users_tabs_user'] = 'User';
$lang['users_tabs_regional'] = 'Regional';
$lang['users_tabs_access'] = 'Access';
$lang['users_tabs_settings'] = 'Settings';
$lang['users_tabs_api'] = 'API Keys';

$lang['users_tokens'] = 'API Keys';
$lang['users_tokens_api_na'] = 'TestRail\'s API is currently disabled and can be enabled
by a TestRail administrator under Administration &gt; Site Settings &gt; API.';
$lang['users_tokens_intro'] = 'This area lets you configure API keys
to authenticate API requests (in addition to your regular TestRail
password). This is useful to access TestRail\'s API without sharing your TestRail
password and is commonly used to integrate with other applications.
<a href="https://www.gurock.com/testrail/docs/api/getting-started/accessing" target="_blank">Learn more</a>';
$lang['users_tokens_name'] = 'Name';
$lang['users_tokens_name_desc'] = 'The name of the API key should describe the usage of the key
(e.g., the name of the application or tools that use the API key).';
$lang['users_tokens_created'] = 'Created On';
$lang['users_tokens_add'] = 'Add Key';
$lang['users_tokens_generate'] = 'Generate Key';
$lang['users_tokens_none'] = 'No API keys defined.';
$lang['users_tokens_dialog'] = 'Add API Key';
$lang['users_tokens_token_before'] = 'Successfully generated the following API key:';
$lang['users_tokens_token_after'] = 'Please store this key in a secure location. The key is only displayed once
and will no longer be accessible using TestRail\'s user interface.';
$lang['users_tokens_delete_confirm'] = 'Really delete this API key? This cannot be undone and disables access for the applications that use this key.';

$lang['users_sidebar_users'] = 'Users';
$lang['users_sidebar_users_stats'] = 'You have <strong class="text-softer">{0}</strong> active and <strong class="text-softer">{1}</strong> inactive users.';

$lang['users_add'] = 'Add User';
$lang['users_add_many'] = 'Add Multiple Users';
$lang['users_save'] = 'Save User';

$lang['users_error_admin_noadmin'] = 'Cannot remove the administrator status because there are no other admins left.
You always need at least one active TestRail administrator.';
$lang['users_error_active_noadmin'] = 'Cannot remove the active status because there are no other admins left.
You always need at least one active TestRail administrator.';

$lang['users_error_active_novalidlicense'] = 'Cannot activate the users because you do not have
a valid <a href="{0}">TestRail license</a> installed.';
$lang['users_error_active_toomanyusers'] = 'Cannot activate the user because you already
have {0} of {1} allowed named users. Please add additional named users to your TestRail license or deactivate another user.';
$lang['users_error_active_toomanyusers_hosted'] = 'Cannot activate the user because you already
have {0} of {1} allowed named users. Please upgrade your subscription or deactivate another user.';


$lang['users_error_emailinuse'] = 'The Email Address is already in use by another user.';
$lang['users_success_add'] = 'Successfully added the new user.';
$lang['users_success_add_invite'] = 'Successfully added the new user and sent an invitation email.';
$lang['users_error_add'] = 'An error occurred while adding the new user.';
$lang['users_error_add_invite'] = 'The user was added successfully but an error occurred while sending the invitation email.
The user can request a new password on the Forgot Password page if needed.
You can <a href="mailto:{0}">send a manual email</a> to the user.';
$lang['users_error_add_invite_nopass'] = 'The user was added successfully but an error occurred while sending the invitation email.
Please check your email settings (Site Settings).
The user can request a new password on the Forgot Password page if needed.';
$lang['users_error_exists'] = 'The specified user does not exist.';
$lang['users_success_update'] = 'Successfully updated the user.';
$lang['users_error_update'] = 'An error occurred while saving the user.';
$lang['users_error_email_reset_password'] = 'An error occurred while sending reset password email.';
$lang['users_error_only_active_reset_password'] = 'Sorry, you can\'t reset the password for an inactive user.';

$lang['users_show_desc'] = 'Show:';
$lang['users_show_active'] = 'Active Only';
$lang['users_show_all'] = 'All';

$lang['users_select_title'] = 'Select User';
$lang['users_select_label'] = 'User';

$lang['users_fields_dialog'] = 'Configure Variable';
$lang['users_fields_label'] = 'Label';
$lang['users_fields_label_desc'] = 'The label of the user variable as it appears in the user interface under My Settings.';
$lang['users_fields_desc'] = 'Description';
$lang['users_fields_desc_desc'] = 'The description is shown next to the user variable under My Settings.';
$lang['users_fields_name'] = 'System Name';
$lang['users_fields_name_invalid'] = 'Invalid characters in System Name: please only use a-z (lower case) and underscore characters.';
$lang['users_fields_name_desc'] = 'The unique name of the user variable in the database. Should be all lower case, no spaces. Please note: this name cannot be changed later.';

$lang['users_fields_field'] = 'User Variable';
$lang['users_fields_fields'] = 'User Variables';
$lang['users_fields_invalid'] = 'The User Variables field uses an invalid format.';
$lang['users_fields_delete_confirm'] = 'Really delete this user variable? Note that this also deletes the values your users have entered for this field and cannot be undone.';
$lang['users_fields_type'] = 'Type';
$lang['users_fields_type_string'] = 'String';
$lang['users_fields_type_hidden'] = '&#9679;&#9679;&#9679;&#9679;&#9679;';
$lang['users_fields_type_password'] = 'Password';
$lang['users_fields_type_desc'] = 'The type cannot be changed later.';
$lang['users_fields_fallback'] = 'Fallback';
$lang['users_fields_fallback_desc'] = 'Used when a user has not entered a value for the user variable. Useful for specifying a default login/password for a defect plugin, for example.';

$lang['users_overview_intro'] = 'Learn more about <a href="https://www.gurock.com/testrail/docs/user-guide/howto/permissions" target="_blank">managing users, groups and permissions</a> and controlling project access.';
$lang['users_export_hint'] = 'Export Users';
$lang['users_export_hint_desc'] = 'Exports the Users into Excel/CSV format.';

$lang['users_actions'] = 'Actions';
$lang['users_forget_descr'] = 'Erase this users identity from TestRail.';
$lang['users_forget_link'] = 'Forget this user';
$lang['users_forget_confirm'] = 'Really forget this user? In addition to being marked inactive, the user name and email address will be removed from the database and replaced with a sequence of letters and numbers instead.<p>If you wish to simply deactivate this user, click on this user&#39;s &#39;Access&#39; tab then deselect the &#39;This user is active&#39; box.</p>';
$lang['users_forget_confirm_checkbox'] = 'Yes, I really want to remove this user.';
$lang['users_success_forget'] = 'Successfully forgot the user. All records associated with the original username will use obfuscated version instead.';
$lang['users_error_forget'] = 'The user has not been forgotten. There was an error. Please check the logs for further information.'; 

$lang['review_changes_title'] = 'Review Changes';
$lang['review_changes_agree'] = 'Yes, update the User';
$lang['review_changes'] = 'The following changes are applied to all selected users. This cannot be undone so please make sure to review the changes carefully.';
$lang['user_inactive_message'] = 'You cannot set all administrators to inactive. TestRail must have at least one active administrator.';
$lang['user_bulk_update'] = 'Successfully updated the users.';
$lang['wrong_input'] = 'Illegal URL content not found.';
$lang['user_login_type'] = 'Login Type';
$lang['user_login_type_local'] = 'Local';
$lang['user_login_type_sso'] = 'SSO';

$lang['users_sso_setting'] = 'Enable Single Sign-On (SSO) authentication';
$lang['users_sso_setting_desc'] = 'Checking this box will disable the standard login for this user and use the authentication integration (under Site Settings) instead.';

$lang['users_mfa_setting'] = 'Require Multi-Factor Authentication';
$lang['users_mfa_setting_desc'] = 'Checking this box will require the user to enter an emailed code or a code from an authenticator app for any TestRail login. This will also require the use of an API key for all API requests.';


$lang['users_editing_bulk_groups'] = 'Groups';
$lang['users_editing_bulk_removefromallgroups'] = 'Remove from all groups';
$lang['users_editing_bulk_updateuser'] = 'Yes, update the User';
$lang['users_editing_bulk_updateall'] = 'Yes, update all';
$lang['users_editing_bulk_users'] = 'Users';

$lang['users_filter_status'] = 'Status';
$lang['users_filter_groups'] = 'Groups';
$lang['users_filter_admin'] = 'Admin';
$lang['users_filter_role'] = 'Role';
$lang['users_active'] = 'Active';
$lang['users_inactive'] = 'Inactive';
$lang['users_filter_none'] = 'None';
$lang['users_filter_administrator'] = 'Administrator';
$lang['user_filter_reset'] = 'Remove filter and show all users.';

$lang['users_oauth_user_not_found'] = 'OAuth User does not exists';
$lang['users_search_text'] = 'Search name or email address';
$lang['users_failed_bulk_update'] = 'Failed to update the selected users. Please check the log for details';
$lang['user_mfa_error'] = 'Unable to Enable MFA for the user';
$lang['users_webhooks'] = 'Webhooks';
