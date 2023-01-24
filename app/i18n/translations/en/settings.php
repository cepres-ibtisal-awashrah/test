<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$lang['settings_tabs_application'] = 'Application';
$lang['settings_tabs_email'] = 'Email';
$lang['settings_tabs_updates'] = 'Updates';
$lang['settings_tabs_sessions'] = 'Sessions';
$lang['settings_tabs_integration'] = 'Integration';
$lang['settings_tabs_interface'] = 'User Interface';
$lang['settings_tabs_auth'] = 'Login';
$lang['settings_tabs_security'] = 'Security';
$lang['settings_tabs_api'] = 'API';
$lang['settings_tabs_auditing'] = 'Auditing';
$lang['settings_tabs_index'] = 'Tab Index';
$lang['restore_date'] = 'Restore Date' ;
$lang['settings_tabs_sso'] = 'SSO';

$lang['settings_tabs_auditing_logs'] = 'Log';
$lang['settings_tabs_auditing_configurtion'] = 'Configuration';
$lang['settings_tabs_auditing_export'] = 'Export';
$lang['audit_export_intro'] = '<h1>Audit Log Export</h1>
                                <p>Export your TestRail audit logs below.
                                Audit log exports are downloadable for 10 days and removed afterwards</p>';

$lang['settings_tabs_email_settings'] = 'Settings';
$lang['settings_tabs_email_notification'] = 'Notifications';

$lang['settings_save'] = 'Save Settings';
$lang['settings_success_update'] = 'Successfully updated site settings.';
$lang['settings_error_update'] = 'An error occurred while updating site settings.';
$lang['settings_error_attachment_dir'] = 'Attachments Directory is not a valid (writable) directory.';
$lang['settings_error_log_dir'] = 'Log Directory is not a valid (writable) directory.';
$lang['settings_error_audit_dir'] = 'Audit Directory is not a valid (writable) directory.';
$lang['settings_error_defect_id_url'] = 'Defect View Url does not contain the %id% placeholder.';
$lang['settings_error_reference_id_url'] = 'Reference View Url does not contain the %id% placeholder.';
$lang['settings_error_edit_mode'] = 'The Editing Test Results field does not contain a valid value.';
$lang['settings_error_defect_plugin'] = 'The Defect Plugin field does not contain a valid value.';
$lang['settings_error_license_key'] = '<strong>{0}</strong>
Please enter/paste the complete license key or contact the
<a href="http://www.gurock.com/support/" target="_blank">Gurock Software support</a> if this problem persists.';
$lang['settings_error_audit_custom_number_of_days'] = 'Invalid retention period entered.';
$lang['settings_error_audit_custom_number_of_records'] = 'Invalid volume entered.';

$lang['settings_installation_name'] = 'Installation Name';
$lang['settings_installation_name_field'] = 'Installation Name';
$lang['settings_installation_name_desc'] = 'The name of this TestRail installation. The installation name is displayed on the login screen and the dashboard.';
$lang['settings_installation_url'] = 'Web Address';
$lang['settings_installation_url_field'] = 'Web Address';
$lang['settings_installation_url_desc'] = 'The web address of your TestRail installation.
Used, among other things, for links in email notifications.';
$lang['settings_attachment_dir'] = 'Attachment Directory';
$lang['settings_attachment_dir_field'] = 'Attachment Directory';
$lang['settings_attachment_dir_desc'] = 'The directory on the web server where uploaded attachments are stored.
Must be writable for TestRail and shouldn\'t be directly accessible with a web browser.';

$lang['settings_remove_attachments'] = 'Remove attachments';
$lang['settings_remove_attachments_desc'] = 'Automatic remove attachments that were uploaded but not used.';
$lang['settings_remove_attachments_time'] = 'Time interval to remove attachments';
$lang['settings_remove_attachments_time_never'] = 'Never';
$lang['settings_remove_attachments_time_10_min'] = '10 minutes';
$lang['settings_remove_attachments_time_1_hour'] = '1 hour';
$lang['settings_remove_attachments_time_4_hours'] = '4 hours';
$lang['settings_remove_attachments_time_12_hours'] = '12 hours';
$lang['settings_remove_attachments_time_24_hours'] = '24 hours';
$lang['settings_remove_attachments_time_4_days'] = '4 days';
$lang['settings_remove_attachments_time_7_days'] = '7 days';
$lang['settings_remove_attachments_time_10_days'] = '10 days';
$lang['settings_remove_attachments_time_desc'] = 'Select time interval after unused attachments will be removed';

$lang['settings_report_dir'] = 'Report Directory';
$lang['settings_report_dir_field'] = 'Report Directory';
$lang['settings_report_dir_desc'] = 'The directory on the web server where generated reports are stored.
Must be writable for TestRail and shouldn\'t be directly accessible with a web browser.';

$lang['settings_log_dir'] = 'Log Directory';
$lang['settings_log_dir_field'] = 'Log Directory';
$lang['settings_log_dir_desc'] = 'The directory on the web server where TestRail log files are stored.
Must be writable for TestRail. Please create this directory if it doesn\'t already exist.';

$lang['settings_audit_dir'] = 'Audit Directory';
$lang['settings_audit_dir_field'] = 'Audit Directory';
$lang['settings_audit_dir_desc'] = 'The directory on the web server where TestRail audit files are stored.
Must be writable for TestRail. Please create this directory if it doesn\'t already exist.';
$lang['settings_integration_jira_title'] = 'JIRA';
$lang['settings_integration_jira_sub_title'] = 'View your JIRA issues directly from TestRail';
$lang['settings_integration_jira_intro'] = 'Click the button below to set up the integration between JIRA and TestRail. The integration enables you to view JIRA issues and add new issues directly from TestRail.';
$lang['settings_integration_jira_quick'] = 'Quick links:';
$lang['settings_integration_jira_quick_overview'] = 'JIRA overview';
$lang['settings_integration_jira_quick_docs'] = 'JIRA configuration';
$lang['settings_integration_jira_configure'] = 'Configure Integration';
$lang['settings_integration_jira_hide'] = 'or hide this message';
$lang['settings_integration_jira_enable'] = 'Enable JIRA Integration';
$lang['settings_jira_title'] = 'Configure JIRA Integration';
$lang['settings_jira_address'] = 'JIRA Address';
$lang['settings_jira_address_hint'] = 'https://example.atlassian.net/';
$lang['settings_jira_address_desc'] = 'The full web address of your JIRA installation (as you access it with your web browser).';
$lang['settings_integration_jira_addon_title'] = 'Jira Server & Cloud Add-on';
$lang['settings_integration_jira_addon_subtitle'] = 'Also check out our add-on for Jira Server & Cloud for our best-in-class integration.';
$lang['settings_integration_jira_addon_button'] = 'Install Jira Add-on';



$lang['settings_integration_webhooks_note'] = 'Webhooks allow external services to be notified when certain events happen. When the specified events happen, we’ll send a POST request to each of the URLs you provide. Find out more in our';
$lang['settings_integration_webhooks_guide_link'] = 'Webhooks Guide.';
$lang['settings_integration_webhooks_add_button'] = 'Add Webhook';
$lang['settings_integration_webhooks_delete_selected_button'] = 'Delete Selected';


$lang['settings_jira_version'] = 'JIRA Version';
$lang['settings_jira_version_4x'] = 'JIRA Server 3.x, 4.x (legacy SOAP integration)';
$lang['settings_jira_version_5x'] = 'JIRA Server 5.x, 6.x, 7.x and later';
$lang['settings_jira_version_cloud'] = 'JIRA Cloud';
$lang['settings_jira_user'] = 'JIRA User';
$lang['settings_jira_user_desc'] = 'The default JIRA username used for the integration.
New issues will appear in the name of this user (reporter). Can be overridden per user in
TestRail under My Settings.';
$lang['settings_jira_email'] = 'JIRA Email address';
$lang['settings_jira_email_desc'] = 'The default JIRA email address used for the integration.
New issues will appear in the name of this user (reporter). Can be overridden per user in
TestRail under My Settings.';
$lang['settings_jira_password'] = 'JIRA Password';
$lang['settings_jira_password_desc'] = 'The matching password for the default JIRA integration user.';
$lang['settings_jira_token'] = 'JIRA API Token';
$lang['settings_jira_token_desc'] = 'The matching API Token for the default JIRA integration user.';
$lang['settings_jira_defects'] = 'Defect integration (to link results to and push/lookup JIRA issues)';
$lang['settings_jira_defects_field'] = 'Enable Defects';
$lang['settings_jira_refs'] = 'Reference integration (to link cases to JIRA requirements/user stories)';
$lang['settings_jira_refs_field'] = 'Enable References';
$lang['settings_jira_empty'] = 'Please enable at least one integration option (test results and/or test cases).';
$lang['settings_jira_variable_user'] = 'JIRA User';
$lang['settings_jira_variable_user_desc'] = 'Your JIRA username used for the TestRail and JIRA integration.';
$lang['settings_jira_variable_password'] = 'JIRA Password';
$lang['settings_jira_variable_password_desc'] = 'The matching password for your JIRA user account.';
$lang['settings_jira_variable_email'] = 'JIRA Email address';
$lang['settings_jira_variable_email_desc'] = 'Your JIRA email address used for the TestRail and JIRA integration.';
$lang['settings_jira_variable_token'] = 'JIRA API Token';
$lang['settings_jira_variable_token_desc'] = 'The matching API Token for your JIRA user account.';

$lang['settings_integration_update'] = 'Successfully updated integration settings.';
$lang['settings_integration_user_field'] = 'User Variable';
$lang['settings_integration_user_field_type'] = 'Type';
$lang['settings_integration_user_fields_none'] = 'No user variables configured.';
$lang['settings_integration_user_fields_add'] = 'Add User Variable';
$lang['settings_integration_tabs_integrations'] = 'Integrations';
$lang['settings_integration_tabs_defects'] = 'Defects';
$lang['settings_integration_tabs_references'] = 'References';
$lang['settings_integration_tabs_apps'] = 'Oauth';
$lang['settings_integration_tabs_fields'] = 'User Variables';
$lang['settings_integration_tabs_webhooks'] = 'Webhooks';

$lang['settings_default_language'] = 'Default Language';
$lang['settings_default_language_field'] = 'Default Language';
$lang['settings_default_language_desc'] = 'Determines the default language of the user interface.
Users can override their language under My Settings.';
$lang['settings_default_locale'] = 'Default Locale';
$lang['settings_default_locale_field'] = 'Default Locale';
$lang['settings_default_locale_desc'] = 'Determines how dates and numbers are formatted by default.
Users can override their locale under My Settings.';
$lang['settings_default_timezone'] = 'Default Time Zone';
$lang['settings_default_timezone_field'] = 'Default Time Zone';
$lang['settings_default_timezone_desc'] = 'Determines the default time zone for dates and times.
Users can override their time zone under My Settings.';
$lang['settings_default_timezone_empty'] = 'Use server time zone';

$lang['settings_no_task'] = 'The background task is not installed';
$lang['settings_no_task_desc'] = 'The background task is responsible for email
notifications, generating reports, adding custom fields and various other tasks.
Please enable the background task as follows:<br /><br />
<a target="_blank" href="https://www.gurock.com/testrail/docs/admin/howto/background-task">Activating the background task</a>';

$lang['settings_email_server'] = 'Server';
$lang['settings_email_server_field'] = 'Email Server';
$lang['settings_email_server_desc'] = 'The host name and port of the machine that is used for sending out
emails. If the port differs from 25, append it like this: \'mail.example.com:50\'.';
$lang['settings_email_from'] = 'From';
$lang['settings_email_from_field'] = 'Email From';
$lang['settings_email_from_desc'] = 'The email address that is used for sending out emails.';
$lang['settings_email_user'] = 'User';
$lang['settings_email_user_field'] = 'Email User';
$lang['settings_email_user_desc'] = 'Leave empty if the email server does not require authentication.';
$lang['settings_email_pass'] = 'Password';
$lang['settings_email_pass_field'] = 'Email Password';
$lang['settings_email_pass_desc'] = 'Leave empty if the email server does not require authentication.';
$lang['settings_email_notifications'] = 'Enable email notifications';
$lang['settings_email_notifications_short'] = 'Notifications';
$lang['settings_email_notifications_field'] = 'Email Notifications';
$lang['settings_email_notifications_desc'] = 'Email notifications are sent for test changes and test results.
Can also be disabled on a per-user basis via My Settings.';
$lang['settings_email_ssl'] = 'Use SSL';
$lang['settings_email_tls'] = 'Use TLS';
$lang['settings_email_none'] = 'No encryption';
$lang['settings_email_enc_field'] = 'Email encryption';
$lang['settings_email_enc_desc'] = 'Enable this option if your email SMTP server uses and requires a secure connection (SSL/TLS).';

$lang['settings_email_test'] = 'Send Test Email';
$lang['settings_email_test_link'] = 'You can <a tabindex="-1" {0}>send a test email</a> to check if your settings are working.';
$lang['settings_email_test_intro'] = 'Note that this test uses the stored email settings.
Please save your settings first in case you made any changes.';
$lang['settings_email_test_email'] = 'Email Address';
$lang['settings_email_test_email_descr'] = 'The email address of the person who should receive the test email.';
$lang['settings_email_test_email_required'] = 'The Email Address field is required.';
$lang['settings_email_test_email_invalid'] = 'Please specify a valid email address.';
$lang['settings_email_test_failure'] = 'Sending the test email failed. Please see the following messages and server output for details:';
$lang['settings_email_test_success'] = 'Successfully sent the email. Please check the inbox.';

$lang['settings_defect_id_url'] = 'Defect View Url';
$lang['settings_defect_id_url_field'] = 'Defect View Url';
$lang['settings_defect_id_url_desc'] = 'The web address of a case of your defect tracker.
Use %id% as the placeholder for the actual case ID.
<a class="link" tabindex="-1" target="_blank" href="https://www.gurock.com/testrail/docs/integrate/">Learn more</a>';
$lang['settings_defect_add_url'] = 'Defect Add Url';
$lang['settings_defect_add_url_field'] = 'Defect Add Url';
$lang['settings_defect_add_url_desc'] = 'The web address for adding a new case to your defect tracker.
<a class="link" tabindex="-1" target="_blank" href="https://www.gurock.com/testrail/docs/integrate/">Learn more</a>';

$lang['settings_defect_plugin'] = 'Defect Plugin';
$lang['settings_defect_plugin_field'] = 'Defect Plugin';
$lang['settings_defect_plugin_desc'] = 'The plugin for integrating TestRail with your defect tracker.
The plugin can be configured below. <a class="link" tabindex="-1" target="_blank" href="https://www.gurock.com/testrail/docs/integrate/">Learn more</a>';
$lang['settings_defect_config'] = 'Configuration';
$lang['settings_defect_config_field'] = 'Defect Plugin Configuration';
$lang['settings_defect_config_desc'] = 'Make sure to use HTTPS for a secure connection to your defect tracker.
User variables are recommended to store the user &amp; password securely
(can also be used to customize the login per user).
<a class="link" tabindex="-1" target="_blank" href="https://www.gurock.com/testrail/docs/integrate/">Learn more</a>';
$lang['settings_defect_template_field'] = 'Defect Plugin Template';
$lang['settings_defect_template_expand'] = '<a {0}>Enter a template</a> for the description field of the defect dialog.';
$lang['settings_defect_template_desc'] = 'The template for the description field of the defect dialog.
You can add various placeholder variables via the Add Field link below.';
$lang['settings_defect_template_add_field'] = 'Add Field';
$lang['settings_defect_template_placeholder'] = 'Status: %tests:status_id% .. ';
$lang['settings_defect_template_default'] =
'%tests:comment%

%tests:details%';

$lang['settings_defect_template_dialog_title'] = 'Add Field';
$lang['settings_defect_template_dialog_field'] = 'Field';
$lang['settings_defect_template_dialog_field_desc'] = 'The field to add to the description template.';
$lang['settings_defect_template_dialog_add'] = 'Add Field';

$lang['settings_reference_id_url'] = 'Reference View Url';
$lang['settings_reference_id_url_field'] = 'Reference View Url';
$lang['settings_reference_id_url_desc'] = 'The web address for your case references (requirements or
user stories, e.g.). Use %id% as the placeholder for the actual reference ID.
<a class="link" tabindex="-1" target="_blank" href="https://www.gurock.com/testrail/docs/integrate/">Learn more</a>';
$lang['settings_reference_add_url'] = 'Reference Add Url';
$lang['settings_reference_add_url_field'] = 'Reference Add Url';
$lang['settings_reference_add_url_desc'] = 'The web address for adding a new reference.
<a class="link" tabindex="-1" target="_blank" href="https://www.gurock.com/testrail/docs/integrate/">Learn more</a>';
$lang['settings_reference_plugin'] = 'Reference Plugin';
$lang['settings_reference_plugin_field'] = 'Reference Plugin';
$lang['settings_reference_plugin_desc'] = 'The plugin for integrating TestRail with your requirement, issue
or bug tracker. The plugin can be configured below.
<a class="link" tabindex="-1" target="_blank" href="https://www.gurock.com/testrail/docs/integrate/">Learn more</a>';
$lang['settings_reference_config_field'] = 'Defect Plugin Configuration';
$lang['settings_reference_config_desc'] = 'Make sure to use HTTPS for a secure connection.
User variables are recommended to store the user &amp; password securely and can be configured
on the <em>Defects</em> tab (can also be used to customize the login per user).
<a class="link" tabindex="-1" target="_blank" href="https://www.gurock.com/testrail/docs/integrate/">Learn more</a>';

$lang['settings_check_for_updates'] = 'Check for TestRail updates';
$lang['settings_check_for_updates_field'] = 'Check for Updates';
$lang['settings_check_for_updates_desc'] = 'Specifies if TestRail should check for new versions once a day and notifies you
when an update is available. Your current TestRail version, license key ID and a hash of the
server\'s hostname is transmitted during an update check.';

$lang['settings_apiv2_enabled'] = 'Enable API';
$lang['settings_apiv2_enabled_field'] = 'API Enabled';
$lang['settings_apiv2_enabled_desc'] = 'TestRail\'s API can be used to integrate with test automation tools, for UI customizations or for the initial import of projects, test cases, etc.
<a class="link" tabindex="-1" target="_blank" href="https://www.gurock.com/testrail/docs/api">Learn more</a>';
$lang['settings_apiv2_session_enabled'] = 'Enable session authentication for API';
$lang['settings_apiv2_session_enabled_field'] = 'API Session Auth';
$lang['settings_apiv2_session_enabled_desc'] = 'Session authentication works by using the session cookie for authenticating API requests.
This is useful when calling API methods from <a class="link" tabindex="-1" target="_blank" href="https://www.gurock.com/testrail/docs/customization/ui-scripts/introduction">UI scripts</a> (in the context of the current user).';

$lang['settings_require_api_key']='Require API Keys';
$lang['settings_require_api_key_desc']= 'Require API requests from external tools to authenticate using an API key and reject any requests which use a password.
<a class="link" tabindex="-1" target="_blank" href="https://www.gurock.com/testrail/docs/api/getting-started/accessing">Learn more</a>';
$lang['settings_require_api_key_field']='Require API enabled';

$lang['settings_require_api_key']='Require API Keys';
$lang['settings_require_api_key_desc']= 'Require API requests from external tools to authenticate using an API key and reject any requests which use a password.
<a class="link" tabindex="-1" target="_blank" href="https://www.gurock.com/testrail/docs/api/getting-started/accessing">Learn more</a>';
$lang['settings_require_api_key_field']='Require API enabled';

$lang['settings_apiv2_pagination_enabled'] = 'Enable pagination for bulk API endpoints';
$lang['settings_apiv2_pagination_enabled_field'] = 'Enable pagination';
$lang['settings_apiv2_pagination_enabled_desc'] = 'Controls whether bulk API endpoints return a paginated response or all data for the entity type. Use paginated endpoints for improved API response time performance.';

$lang['settings_edit_mode'] = 'Editing Test Results';
$lang['settings_edit_mode_field'] = 'Editing Test Results';
$lang['settings_edit_mode_desc'] = 'Choose whether users are allowed to edit their own test results.
You can specify the maximum time a user can do so after submitting the result. You can choose specific time frames,
allow unlimited editing or completely disable this feature.';

$lang['settings_name_format'] = 'Name Formatting';
$lang['settings_name_format_field'] = 'Name Formatting';
$lang['settings_name_format_desc'] = 'Specifies how (abbreviated) user names are formatted and displayed in the user interface.';
$lang['settings_name_format_last_name'] = 'Shorten Last Name';
$lang['settings_name_format_first_name'] = 'Shorten First Name';

$lang['settings_brand_logo'] = 'Brand your account with your organization\'s logo';
$lang['settings_brand_logo_button'] = 'Upload / update your logo';
$lang['settings_brand_logo_desc'] = 'Your logo will be used in your email notifications and in your reports. Have at hand an image with the following characteristics:';
$lang['settings_brand_logo_rules'] = '<li>- JPG, PNG or GIF format</li>
<li>- Horizontal proportions</li>
<li>- White or transparent background</li>
<li>- 250 kb maximum size</li>';
$lang['settings_brand_logo_dialog_title'] = 'Upload your logo';
$lang['settings_brand_logo_dialog_desc'] = "Remember that, for best results, your image should be on <strong>JPG, PNG</strong> or <strong>GIF</strong> format, have <strong>horizontal</strong>
proportions, <strong>white</strong> or <strong>transparent</strong> background and <strong>250 kb maximum</strong> size.";
$lang['settings_brand_logo_dialog_upload_button'] = 'Upload from your computer';
$lang['settings_brand_logo_dialog_update_title'] = 'Update your logo';
$lang['settings_brand_logo_dialog_update_desc'] = 'This is your current logo. Upload a new one or restore the default TestRail one. Your image should be on <strong>JPG, PNG</strong> or <strong>GIF</strong> format, have <strong>horizontal</strong> proportions, <strong>white</strong> or <strong>transparent</strong> background and <strong>250 kb maximum</strong> size.';
$lang['settings_brand_logo_dialog_restore_button'] = 'Restore TestRail default logo';
$lang['settings_brand_logo_dialog_failure_title'] = 'Image couldn\'t be uploaded / updated';
$lang['settings_brand_logo_dialog_failure_desc'] = 'We encountered some problem uploading your image. Please, make sure you comply with the following:  <strong>JPG, PNG</strong> or <strong>GIF</strong> format, have <strong>horizontal</strong> proportions, <strong>white</strong> or <strong>transparent</strong> background and <strong>250 kb</strong> maximum size.';
$lang['settings_brand_logo_dialog_ok'] = 'OK';
$lang['settings_brand_logo_dialog_cancel'] = 'Cancel';
$lang['settings_brand_logo_dialog_close'] = 'Close';
$lang['settings_brand_logo_dialog_tryagain'] = 'Try Again';

$lang['settings_permanent_cases_deletion_days'] = 'Permanent cases deletion (Days)';
$lang['settings_permanent_cases_deletion'] = 'Retain test cases marked as deleted';
$lang['settings_permanent_cases_deletion_field'] = 'Duration';
$lang['settings_permanent_cases_deletion_desc'] = 'Specifies the duration after which test cases marked as deleted will be permanently deleted.';
$lang['settings_permanent_cases_deletion_days'] = '{0} Days';

$lang['settings_partial_count'] = 'Test Case & Test Pagination Limit';
$lang['settings_partial_count_slow'] = '(may be slow)';
$lang['settings_partial_count_desc'] = 'Specifies how many items are displayed by default on Test & Test Case pages. Please note that it\'s recommended to use the compact view mode for larger test suites &amp; test runs for best performance.';

$lang['settings_pagination_limit'] = 'Suites, Runs, Plans, and Other Items Pagination Limit';
$lang['settings_pagination_limit_desc'] = 'Specifies how many items are displayed by default on Suite, Run, and Plan pages. This setting also applies to test results, test case versions, and test case comments.';

$lang['settings_sess_idle_policy'] = 'Idle Session Timeout Policy';
$lang['settings_sess_custom_idle'] = 'Custom Idle Session Timeout (mins)';
$lang['settings_sess_abs_timeout'] = 'Absolute Session Timeout Policy';
$lang['settings_sess_custom_abs_timeout'] = 'Custom Absolute Session Timeout (hours)';
$lang['settings_sess_disable_tpolicy'] = 'Disable Session Timeout Policy';
$lang['settings_sess_disable_rememberme'] = 'Disable Keep Me Logged In Checkbox';

$lang['settings_sess_idle_policy_desc'] = 'Logs the user out after a certain period of inactivity.';
$lang['settings_sess_custom_idle_desc'] = 'You can specify the idle timeout threshold in minutes.';
$lang['settings_sess_abs_timeout_desc'] = 'Logs the user out after a certain period, irrespective of whether they are active or not';
$lang['settings_sess_custom_abs_timeout_desc'] = 'You can specify the absolute timeout threshold in hours.';
$lang['settings_sess_disable_tpolicy_desc'] = 'Completely disables the session timeout feature. Users will be able to set the Remember Me checkbox on the Login page, and remain logged in unless they clear their browser cookies or click the Logout button. This is the default behaviour.';
$lang['settings_sess_disable_rememberme_desc'] = 'Hides the Keep me logged in checkbox on the login page, so when users close their browser after using TestRail, their session is closed and they have to login again. Can be useful if you want to limit your user session lengths without enforcing an idle or absolute session. (Disabling the Keep me logged in checkbox is a prerequisite for implementing further session timeout policies.)';

$lang['settings_database_driver'] = 'Driver';
$lang['settings_database_driver_desc'] = 'The driver for your database.
Usually MS SQL Server if you install on Windows and MySQL if you install on Linux/Unix.';
$lang['settings_database_driver_field'] = 'Database Driver';
$lang['settings_database_server'] = 'Server';
$lang['settings_database_server_field'] = 'Database Server';
$lang['settings_database_server_desc'] = 'The host name of the database server.';
$lang['settings_database_database'] = 'Database';
$lang['settings_database_database_field'] = 'Database';
$lang['settings_database_database_desc'] = 'The name of the empty database you have created. This installation
wizard will automatically create all needed tables in this database.';
$lang['settings_database_user'] = 'User';
$lang['settings_database_user_field'] = 'Database User';
$lang['settings_database_user_desc'] = 'The TestRail database user. This user needs permissions to alter the
database schema (ex: to create or drop tables).';
$lang['settings_database_password'] = 'Password';
$lang['settings_database_password_field'] = 'Database Password';

$lang['settings_cassandra_server'] = 'Server';
$lang['settings_cassandra_server_field'] = 'Cassandra Server';
$lang['settings_cassandra_server_desc'] = 'The host name of the Cassandra server.';
$lang['settings_cassandra_port'] = 'Port';
$lang['settings_cassandra_port_field'] = 'Cassandra Port';
$lang['settings_cassandra_port_desc'] = 'The Cassandra port (9042 by default).';
$lang['settings_cassandra_keyspace'] = 'Keyspace';
$lang['settings_cassandra_keyspace_field'] = 'Cassandra Keyspace';
$lang['settings_cassandra_keyspace_desc'] = 'The name of the empty keyspace you have created. This installation
wizard will automatically create all needed tables in this keyspace.';
$lang['settings_cassandra_user'] = 'User';
$lang['settings_cassandra_user_field'] = 'Cassandra User';
$lang['settings_cassandra_user_desc'] = 'The TestRail Cassandra user. This user needs permissions to alter the
database schema (ex: to create or drop tables).';
$lang['settings_cassandra_password'] = 'Password';
$lang['settings_cassandra_password_field'] = 'Cassandra Password';
$lang['settings_cassandra_connection_error'] = 'Could not connect to the specified Cassandra keyspace.';
$lang['settings_cassandra_connection_error_hint'] = 'Create Cassandra keyspace or check your Cassandra connection settings. <a class="link" tabindex="-1" target="_blank" href="https://www.gurock.com/testrail/docs/admin/howto/cassandra-db">Learn more</a>';
$lang['settings_cassandra_install_error'] = 'The updrade wizard couldn\'t write the TestRail configuration file.
This is not unusual, as the web server often doesn\'t have the permissions
needed to create new files. However, to complete the installation, you
must create the TestRail config file manually.

Please copy the following
configuration settings to a file called config.php and place it
in the TestRail	installation directory (next to index.php).';

$lang['settings_rabbitmq_server'] = 'Message Queue Server';
$lang['settings_rabbitmq_server_field'] = 'RabbitMQ Server';
$lang['settings_rabbitmq_server_desc'] = 'The host name of the RabbitMQ server.';
$lang['settings_rabbitmq_port'] = 'Message Queue Port';
$lang['settings_rabbitmq_port_field'] = 'RabbitMQ Port';
$lang['settings_rabbitmq_port_desc'] = 'The RabbitMQ port (5672 by default).';
$lang['settings_rabbitmq_user'] = 'Message Queue User';
$lang['settings_rabbitmq_user_field'] = 'RabbitMQ User';
$lang['settings_rabbitmq_user_desc'] = 'The TestRail RabbitMQ user. This user needs permissions to manage queues (creation, deletion).';
$lang['settings_rabbitmq_password'] = 'Message Queue Password';
$lang['settings_rabbitmq_password_field'] = 'RabbitMQ Password';
$lang['settings_rabbitmq_password_desc'] = 'The TestRail RabbitMQ password. Leave it empty if you do not want to change it.';
$lang['settings_rabbitmq_password_is_required'] = 'Field Message Queue Password is a required field.';
$lang['settings_rabbitmq_use_ssl'] = 'Use TLS';
$lang['settings_rabbitmq_use_ssl_field_desc'] = 'Use TLS for connecting to message queue server.';
$lang['settings_rabbitmq_ca_cert'] = 'Message Queue CA Certificate';
$lang['settings_rabbitmq_ca_cert_field'] = 'RabbitMQ TLS CA Certificate';
$lang['settings_rabbitmq_ca_cert_desc'] = 'The CA certificate for connecting to the RabbitMQ server if using a TLS connection.';
$lang['settings_rabbitmq_client_cert'] = 'Message Queue Client Certificate';
$lang['settings_rabbitmq_client_cert_field'] = 'RabbitMQ TLS Client Certificate';
$lang['settings_rabbitmq_client_cert_desc'] = 'The client certificate for connecting to the RabbitMQ server if using a TLS connection.';
$lang['settings_rabbitmq_client_key'] = 'Message Queue Client Private Key';
$lang['settings_rabbitmq_client_key_field'] = 'RabbitMQ TLS Client Private Key';
$lang['settings_rabbitmq_client_key_desc'] = 'The client private key (PK) for connecting to the RabbitMQ server if using a TLS connection.';
$lang['settings_rabbitmq_connection_error'] = 'Could not connect to the specified RabbitMQ server: {0}';

$lang['settings_mq_title'] = 'Message Queue Integration';
$lang['settings_mq_desc'] = 'Fill out the required fields below to configure message queueing for TestRail webhooks functionality.';
$lang['settings_mq_toggle_desc'] = 'Message Queueing Off/On';
$lang['settings_mq_upload_cert'] = 'Upload an MQ certificate.';
$lang['settings_mq_cert_desc'] = 'Paste in or upload the Message Queue certificate from your MQ component.';

$lang['settings_database_driver_error'] = 'Unknown database driver selected.';
$lang['settings_database_connection_error'] = 'Could not connect to the specified database: {0}';

$lang['settings_database_driver_sqlsrv'] = 'MS SQL Server (2008, 2012, 2014 or 2016)';
$lang['settings_database_driver_mysql'] = 'MySQL (5.x and higher)';

$lang['settings_license_key'] = 'License Key';
$lang['settings_license_key_field'] = 'License Key';
$lang['settings_license_key_desc'] = 'Your trial or full TestRail license key.';
$lang['settings_license_key_type'] = 'License Type';
$lang['settings_license_key_to'] = 'Licensed To';
$lang['settings_license_key_expiration'] = 'Expiration Date';
$lang['settings_license_key_support'] = 'Support Until';
$lang['settings_license_key_support_expired'] = '(expired)';
$lang['settings_license_key_seats'] = 'Named Users';
$lang['settings_license_key_unlimited'] = 'Unlimited';

$lang['settings_license_update'] = 'Update License';
$lang['settings_license_updated'] = 'Successfully updated your TestRail license key.';

$lang['settings_license_error_decode'] = 'Invalid license key format.';
$lang['settings_license_error_expired'] = 'License has expired (only valid until {0}).';
$lang['settings_license_error_notfound'] = 'No license key found in the database.';
$lang['settings_license_error_toomanyusers'] = 'There are more active users than allowed by the license ({0}/{1}).';
$lang['settings_license_error_nonewuser'] = 'Cannot add a new user ({0} of {1} allowed named users are already in use).
Please add additional named users to your <a href="{2}">TestRail license</a>
or deactivate another user.';
$lang['settings_license_error_nonewuser_hosted'] = 'Cannot add a new user ({0} of {1} active users are already in use).
Please upgrade your <a href="{2}">subscription</a>
or deactivate another user.';
$lang['settings_license_error_user_suffix'] = '{0} Please contact your TestRail administrator to resolve this issue.';
$lang['settings_license_admin_warning'] = '<strong>There is a problem with your current TestRail license:</strong> {0}
Please update your license key below or contact the <a href="http://www.gurock.com/support/" target="_blank">Gurock Software support</a>.';

$lang['settings_subscription_error_user'] = 'Your TestRail Cloud account is disabled. Please contact your TestRail administrator to learn more.';
$lang['settings_subscription_error_expired'] = 'Your TestRail trial has expired (only valid until {0}).';
$lang['settings_subscription_error_admin'] = 'Your TestRail Cloud account is disabled. Please go to Administration, then Subscription to learn more.';
$lang['settings_subscription_manage'] = 'Manage Subscription';
$lang['settings_subscription_goto'] = 'Go to subscription page';
$lang['settings_subscription_admin_warning'] = '<strong>There is a problem with your TestRail subscription:</strong> {0}
Please upgrade your subscription below or contact the <a href="http://www.gurock.com/support/" target="_blank">Gurock Software support</a>.';
$lang['settings_subscription_account'] = 'Account';
$lang['settings_subscription_expiration'] = 'Expiration Date';
$lang['settings_subscription_intro_trial'] = 'Please click below to
create a subscription via the Gurock Software customer portal and upgrade
your trial account to the full edition. TestRail is billed based on the maximum number of users that you have marked active each month.
Please adjust your user count as needed before creating a subscription.';
$lang['settings_subscription_intro_trial_expires'] = 'Your TestRail trial account
expires on <strong style="color: #606060">{0}</strong>.
Please click below to create a subscription and upgrade
your trial to the full edition. TestRail is billed based on the maximum number of users that you have marked active each month.
Please adjust your user count as needed before creating a subscription.';
$lang['settings_subscription_intro_at'] = '(at <em>{0}</em>)';
$lang['settings_subscription_intro_trial_expired'] = 'Your TestRail trial account
expired on <strong style="color: #606060">{0}</strong>.
Please click below to create a subscription and upgrade
your trial account to the full edition. TestRail is billed based on the maximum number of users that you have marked active each month.
Please adjust your user count as needed before creating a subscription.';
$lang['settings_subscription_intro_full'] = 'Please click below to
manage your subscription via the Gurock Software customer portal.
Managing your subscription allows you to change your payment and
contact details. Please note that you must have a separate login for the customer portal to manage your subscription.
If you are not a customer portal contact, please <a href="https://secure.gurock.com/customers/support/" target="_blank">contact us</a>.';

$lang['settings_export'] = 'Export';
$lang['settings_exports'] = 'Export &amp; Backup';
$lang['settings_exports_empty'] = 'No exports available.';
$lang['settings_exports_intro'] = 'Export your TestRail database and uploaded files for a local installation or for backup purposes below. Created exports are downloadable for 10 days and are removed afterwards.';
$lang['settings_exports_scheduled'] = 'A new export is currently being created and will be available soon. You will receive an email once the export job has been completed. <br /><a href="{0}">Refresh this page</a>';
$lang['settings_exports_schedule'] = 'Schedule Export';
$lang['settings_exports_open_error'] = 'The export does not exist or you do not have the permission to access it.';
$lang['settings_no_export'] = 'Cannot schedule an export. Audit logs are empty.';
$lang['settings_exports_schedule_success'] = 'Successfully scheduled the export. The export will be available within the next few minutes.';

$lang['settings_hosted_trial'] = 'Please note that some settings cannot be modified in the hosted trial of TestRail and are disabled.';

$lang['settings_auth_login_text'] = 'Login Text';
$lang['settings_auth_login_text_desc'] = 'You can post a custom text to the login page.
This could include links to Wiki pages on how to get a TestRail user account, for example.';
$lang['settings_auth_external_auth'] = 'External Auth';
$lang['settings_auth_external_status'] = 'Status';
$lang['settings_auth_external_path'] = 'Path';
$lang['settings_auth_external_inactive'] = 'Inactive';
$lang['settings_auth_external_active'] = 'Active';
$lang['settings_auth_external_desc'] = 'You can use an external authentication script to authenticate users and integrate TestRail with Active Directory or LDAP servers.
<a class="link" tabindex="-1" target="_blank" href="http://code.gurock.com/p/testrail-auth/">Learn more</a>';
$lang['settings_auth_forgot_password'] = 'Disable Forgot Password functionality';
$lang['settings_auth_forgot_password_field'] = 'Forgot Password';
$lang['settings_auth_forgot_password_desc'] = 'The Forgot Password feature sends a password reset request to users via email (not the actual password).
It can be useful to disable this feature if you use external authentication or do not want to allow this functionality.';
$lang['settings_auth_invite_users'] = 'Disable Invite User functionality';
$lang['settings_auth_invite_users_field'] = 'Invite Users';
$lang['settings_auth_invite_users_desc'] = 'When adding new users via the Invite User feature, TestRail sends an email to the new user to set her/his password.
It can be useful to disable this feature if you do not want to allow this functionality.';
$lang['settings_auth_mfa'] = 'Enable Multi-Factor Authentication (MFA)';
$lang['settings_auth_mfa_desc'] = 'Checking this box enables users to configure authenticator app and perform MFA when logging into TestRail in any new session. To force MFA for users via email or app. set MFA as required under each user account. This setting will not affect users logging into TestRail through Single Sign-On';
$lang['settings_auth_mfa_field'] = 'Multi-Factor Authentication';

$lang['settings_authentication_integration'] = 'SAML 2.0 Authentication Integration';
$lang['settings_authentication_integration_field'] = 'SSO Configuration Off/On';
$lang['settings_current_sso_integration'] = 'Select Your Authentication Protocol';
$lang['settings_current_sso_integration_desc'] = 'Choose the protocol used by your Identity Provider (IDP). <a href="https://www.gurock.com/testrail/docs/admin/enterprise/configure-sso" target="_blank">Learn More</a>';
$lang['settings_current_sso_none'] = 'None';
$lang['settings_current_sso_saml'] = 'SAML 2.0';
$lang['settings_current_sso_oauth'] = 'OAuth 2.0';
$lang['settings_current_sso_openid'] = 'OpenID Connect';
$lang['settings_authentication_integration_desc'] ='Fill out the required fields below to configure SSO authentication integration with your preferred identity provider. Activate SSO by clicking the Save button with SSO Configuration toggled to On. Toggling SSO Configuration to Off will deactivate SSO while preserving your configuration settings.';
$lang['settings_entity_id'] = 'TestRail Entity ID';
$lang['settings_entity_id_field'] = 'Entity ID';
$lang['settings_entity_id_static_field'] = 'The TestRail Entity ID is the URL via which your users access TestRail,e.g.https://mydomain.testrail.com.';
$lang['settings_single_sign_on_url'] = 'Single Sign On URL';
$lang['settings_single_sign_on_url_field'] = 'Single Sign On URL';
$lang['settings_single_sign_on_url_static_field'] = 'The SSO URL is the URL to which the IDP will send its authentication response.
you can construct it by appending /saml/sso to your TestRail entity ID, e.g.https://mydomain.testrail.com/saml/sso.';
$lang['settings_single_sign_on_url_desc'] = 'You will need to provide the TestRail Entity ID and Single Sign On URL
to your Identity Provider (IDP).';
$lang['settings_default_locale'] = 'Default Locale';
$lang['settings_default_locale_field'] = 'Default Locale';
$lang['settings_default_locale_desc'] = 'Determines how dates and numbers are formatted by default.
Users can override their locale under My Settings.';
$lang['settings_default_timezone'] = 'Default Time Zone';
$lang['settings_default_timezone_field'] = 'Default Time Zone';
$lang['settings_default_timezone_desc'] = 'Determines the default time zone for dates and times.';
$lang['settings_idp_issuer_url'] = 'IDP Issuer URL';
$lang['settings_idp_issuer_url_field'] = 'IDP Issuer URL';
$lang['settings_idp_issuer_url_desc'] = "Obtain the SSO and Issuer URLs from your IDP.";
$lang['settings_authentication_fallback'] = 'Authentication Fallback';
$lang['settings_authentication_fallback_field'] = 'Authentication Fallback';
$lang['settings_authentication_fallback_desc'] = 'Allow users to continue to login with their TestRail credentials in addition to the SSO login. If enabled, TestRail tries to authenticate the user with their TestRail credentials if an email address is entered. If the SSO login button is clicked, TestRail tries to authenticate the user from the Identity Provider. (Fallback is enabled by default for administrator users).';
$lang['settings_create_account_on_first_login'] = 'Create Account on First Login';
$lang['settings_create_account_on_first_login_field'] = 'Create Account on First Login';
$lang['settings_create_account_on_first_login_desc'] = 'This configuration setting specifies if TestRail should automatically
create new user accounts in TestRail if a user could be successfully authenticated.';
$lang['settings_is_saml_encryption_enabled'] = 'Encrypted Assertion Enabled';
$lang['settings_is_saml_encryption_enabled_field'] = 'Encrypted Assertion Enabled';
$lang['settings_saml_encryption_private_key'] = 'Private Key';
$lang['settings_saml_encryption_private_key_field'] = 'Private Key';
$lang['settings_saml_encryption_private_key_desc'] = 'Paste in or upload the Private Key generated.';
$lang['settings_idp_certificate'] = 'IDP Certificate ';
$lang['settings_idp_certificate_field'] = 'IDP Certificate';
$lang['settings_idp_certificate_desc'] = 'Paste in or upload the SSO certificate from your identity provider.';
$lang['settings_ssl_certificate'] = 'SSL Certificate';
$lang['settings_ssl_certificate_field'] = 'SSL Certificate';
$lang['settings_ssl_certificate_desc'] = 'Paste in or upload the SSL certificate from your identity provider.';
$lang['settings_idp_sso_url'] = 'IDP SSO URL';
$lang['settings_idp_sso_url_field'] = 'IDP SSO URL';
$lang['settings_auth_password_policy'] = 'Password Policy';
$lang['settings_auth_password_policy_unknown'] = 'Field Password Policy uses an unknown password policy.';
$lang['settings_auth_password_policy_invalid'] = 'Field Password Policy uses an invalid custom password policy. Please check your regular expressions for errors and try again.';
$lang['settings_auth_password_policy_desc'] = 'Enforces the selected password policy (not used for existing passwords or passwords automatically generated by TestRail).';
$lang['settings_auth_password_policy_custom'] = 'Custom';
$lang['settings_auth_password_policy_custom_default'] = '
.{15,}
[a-z]
[A-Z]
[0-9]
[`~!@#$%^&*()\-_=+[\]{}|;:\'",<>./?]';
$lang['settings_auth_password_policy_custom_field'] = 'Password Policy Custom';
$lang['settings_auth_password_policy_custom_desc'] = 'You can create a custom password policy with regular expressions. Simply enter one regular expression per line and all expressions must match in order to accept a password.';
$lang['settings_auth_password_policy_description'] = 'Description';
$lang['settings_auth_password_policy_description_default'] =
'Minimum of 15 characters, at least one lower & upper case character, a number and a special character.';
$lang['settings_auth_password_policy_description_field'] = 'Password Policy Description';
$lang['settings_auth_password_policy_description_desc'] = 'You can optionally enter a short description that is shown to users who enter a password that does not match your password policy.';

$lang['settings_auth_ip_restrictions'] = 'Allow access to TestRail from the following IPs only';
$lang['settings_auth_ip_restrictions_doc'] =
'; You can use simple IP addresses:
; 192.168.1.1
; Or entire networks:
; 192.168.1.0/24';
$lang['settings_auth_ip_check_nomatch'] = 'Your IP address ({0}) does not match the given IP/network address list. This would lock you out of the account and prevent you from making any further changes. Please allow your current IP address and try again.';
$lang['settings_auth_ip_check_invalid'] = 'Your list of IP/network addresses is empty or uses an invalid format. Please check the addresses for errors and try again.';
$lang['settings_auth_ip_restrictions_current'] = '<a {0}>Add my IP address</a>';
$lang['settings_auth_ip_restrictions_desc'] = 'Restricting access to certain IPs can be used to prevent requests from unauthorized locations. Simply enter one IP or network address per line.';

$lang['settings_projects_with_integration_title'] = 'Some projects override the global integration settings';
$lang['settings_projects_with_integration'] = 'The following projects have their own integration options configured and override some of the global settings defined on this page:';
$lang['settings_projects_with_integration_hint'] = 'Some projects override the global integration settings. See the box at the top of the page for details.';
$lang['settings_projects_override_integration'] = '<strong>Please note:</strong> Any integration settings defined for this project will override the <a href="{0}">global integration settings</a>.';

$lang['settings_external_auth_enabled'] = '<strong>Please note:</strong> Your TestRail installation uses a custom authentication script. If you wish to use the in-built sso integration feature please remove custom authentication script and update the sso details under login tab';

$lang['test_connection'] = 'Test Connection';
$lang['settings_success_test_connection'] = 'Successfully tested SSO settings.';
$lang['settings_error_test_connection'] = 'An error occurred while testing SSO settings.';
$lang['settings_error_test_connection_cert'] = 'The certificate or private key could not be validated.';
$lang['settings_error_test_connection_attributes'] = 'An error occurred while testing SSO settings. Please check the attributes in your IDP settings.';
$lang['settings_copy_text'] = 'Copy URL to clipboard.';

$lang['settings_sso_config'] = 'Select SSO configuration';
$lang['settings_sso_config_desc'] = 'Fill out the required fields below to configure SSO authentication integration with your preferred identity provider. Activate SSO by clicking the Save button with SSO Configuration toggled to On. Toggling SSO Configuration to Off will deactivate SSO while preserving your configuration settings.';


$lang['settings_oauth_client_id'] = 'Client ID';
$lang['settings_oauth_client_secret'] = 'Client Secret';
$lang['settings_oauth_access_token_uri'] = 'Access Token URI';
$lang['settings_oauth_user_auth_uri'] = 'Access Token URI';
$lang['settings_oauth_user_info_uri'] = 'User Info URI';
$lang['settings_client_id'] = 'Client ID';
$lang['settings_client_secret'] = 'Client Secret';
$lang['settings_access_token_uri'] = 'Access Token URI';
$lang['settings_user_auth_uri'] = 'Access Token URI';
$lang['settings_user_info_uri'] = 'Access Token URI';
$lang['settings_oauth_client_id_desc'] = 'Please Enter the Client ID of your IDP';
$lang['settings_oauth_client_secret_desc'] = 'Please enter the Client Secret of your IDP';
$lang['settings_oauth_user_auth_uri_desc'] = 'Please enter the Access Token URI of your IDP';
$lang['settings_oauth_user_info_uri_desc'] = 'Please enter the User Info URI of your IDP';
$lang['settings_client_id_desc'] = 'Please Enter the Client ID of your IDP';
$lang['settings_client_secret_desc'] = 'Please enter the Client Secret of your IDP';
$lang['settings_access_token_uri_desc'] = 'Please Enter your Access Token URI of the third party';
$lang['settings_user_auth_uri_desc'] = 'Please Enter your User Authorization URI of the third party';
$lang['settings_user_info_uri_desc'] = 'Please Enter your User Info URI of the third party';
$lang['settings_oauth_name'] = "Name";
$lang['settings_oauth_name_description'] = 'This name will be displayed on the Auth tab of user account settings';
$lang['oauth_issuer_uri'] = 'User Authorization URI';
$lang['oauth_issuer_uri_description'] = 'Please enter the User Authorization URI of your IDP';
$lang['settings_oauth_whitelist_domains'] = 'Whitelist Domains';
$lang['settings_oauth_create_account_on_first_login'] = 'Create Account on First Login';


$lang['settings_subscription_enterprise_trial'] = 'TestRail Enterprise Cloud Trial';
$lang['settings_subscription_enterprise'] = 'TestRail Enterprise Cloud';
$lang['settings_subscription_intro_enerprise_trial'] = 'Please contact us to convert from a trial to a paid subscription plan,
or if you would like to switch from Enterprise to Classic TestRail.';
$lang['settings_subscription_intro_enerprise'] = '​ Please contact us to manage your subscription.​';
$lang['settings_subscription_intro_enterprise_trial_expires'] = 'Your TestRail Enterprise trial account
expires on <strong style="color: #606060">{0}</strong>.
Please click below to create a subscription and upgrade
your trial account to the full edition.';
$lang['settings_subscription_contact_us'] = 'Contact Us';

$lang['settings_data_management_tabs_storage'] = 'Storage';
$lang['settings_data_management_tabs_exports'] = 'Exports';
$lang['settings_data_management_tabs_attachments'] = 'Attachments';
$lang['settings_data_management_welcome_title'] = 'Welcome to the Data Management area!';
$lang['settings_data_management_welcome_message'] = 'Find here details about your Storage status and account limits. Export your Data Base and manage everything related.';
$lang['settings_data_management_your_storage'] = 'Your Storage';
$lang['settings_data_management_your_storage_status'] = 'Your Storage status';
$lang['settings_data_management_allowed'] = 'ALLOWED';
$lang['settings_data_management_used'] = 'USED';
$lang['settings_data_management_gb'] = 'GB';
$lang['settings_data_management_database_size'] = 'Database size:';
$lang['settings_data_management_attachments_size'] = 'Attachments size:';
$lang['settings_data_management_you_can_use_attach_tab'] = 'You can use the Attachments tab ';
$lang['settings_data_management_tp_manage_unwanted'] = 'to manage unwanted items.';
$lang['settings_data_management_what_you_need_to_know'] = 'What you need to know';
$lang['settings_data_management_you_limit_message'] = 'Your TestRail instance is out of space. Case Fields can no longer be added, attachments cannot be uploaded and data exports will not be allowed until your instance is back inside the allowed limit for your
subscription. Please refer to our';
$lang['settings_data_management_standard_limit_pro'] = 'Your <b>Professional Cloud</b> account has a standard limit of <b>50 GB</b>.';
$lang['settings_data_management_standard_limit_enterprise'] = 'Your <b>Enterprise Cloud</b> account has a standard limit of <b>500 GB</b>.';
$lang['settings_data_management_includes'] = 'This includes your Database and Attachments.';
$lang['settings_data_management_if_you_reach_limit'] = 'If you reach the limit you’ll be automatically upgraded with billable <b>25 GB increments</b>, up to
                    a maximum limit of <b>200 GB</b>.';
$lang['settings_data_management_read_our_data_storage_limit'] = 'Read our Data Storage policy';
$lang['settings_data_management_need_more_space_pro'] = 'Need more space? Go Server or <b>get 500 GB with Cloud Enterprise</b>. ';
$lang['settings_data_management_need_more_space_enterprise'] = 'Need more space? Manage unwanted items or <b>Go Server</b>. ';
$lang['settings_data_management_still_have_questions'] = 'Still have questions? ';
$lang['settings_data_management_learn_about_server'] = 'Learn about Enterprise Server';
$lang['settings_data_management_learn_about'] = 'Learn about Enterprise';
$lang['settings_data_management_contact_us'] = 'Contact us';
$lang['settings_data_management_read_our_storage_policy'] = 'Read our Data Storage policy';
$lang['settings_data_management_get_500_gb'] = 'Get 500 GB with Enterprise';
$lang['settings_data_management_gb_included'] = 'GB included';
$lang['settings_data_management_gb_purchased'] = 'GB purchased';
$lang['settings_subscription_status'] = 'Your Subscription Status';
$lang['settings_subscription_professional'] = 'a <strong>Professional Cloud</strong>';
$lang['settings_subscription_enterprise'] = 'an <strong>Enterprise Cloud</strong>';
$lang['settings_subscription_you_are_enjoying'] = 'You are enjoying {0} account.';
$lang['settings_subscription_renewal_period'] = 'The renewal period is <strong>{0}</strong>.';
$lang['settings_subscription_end_period'] = 'Your current subscription ends on <strong>{0}</strong>.';
$lang['settings_subscription_annual'] = 'annual';
$lang['settings_subscription_monthly'] = 'monthly';
$lang['settings_subscription_you_can_renew'] = "You can <strong>easily renew online</strong> by clicking on the button below. You will be redirected to Gurock's Customer Portal.";
$lang['settings_subscription_forgot_credentials'] = 'Did you forget your Gurock credentials? Learn how to recover them.';
$lang['settings_subscription_contact_us'] = 'If you have additional questions, just <a href="{0}">contact us</a> today.';
$lang['settings_subscription_gurock_title'] = 'Gurock credentials';
$lang['settings_subscription_gurock_forgot_credentials'] = "Don’t you remember your Gurock Customer Portal credentials? Not a big issue. Find them back by following one of these two steps:";
$lang['settings_subscription_check_welcome_email'] = 'Check your Gurock Welcome mail';
$lang['settings_subscription_when_you_joined'] = 'When you joined TestRail you received a mail with your Gurock Portal access credentials. Its subject was "Your Gurock Software customer portal account".';
$lang['settings_subscription_start_renewal'] = 'Start the renewal process and click on Forgot my password';
$lang['settings_subscription_get_into_portal'] = 'Get into the Gurock’s Customer Portal and click on the password reminder link you’ll find below the form. Or <a href="{0}">click here right away</a>.';
$lang['settings_subscription_got_it'] = 'Got it';
$lang['settings_subscription_renew_online_now'] = 'Renew online now!';
$lang['settings_subscription_renew_to_preserve'] = 'Renew to preserve your data!';
$lang['settings_subscription_due_for_renewal'] = 'is due for renewal. Renew now to prevent the loss of your data!';
$lang['settings_subscription_your_team_subscription'] = "Your Team's Prepaid TestRail Cloud subscription";
$lang['settings_subscription_will_be_due'] = 'will be due for renewal soon';
$lang['settings_exports_fine_tune'] = 'Fine tune your export:';
$lang['settings_exports_include_reports'] = 'Include Reports';
$lang['settings_exports_include_reports_descr'] = 'Controls whether reports are included in the export or not. Including reports can result in a much larger and slower export.';
$lang['settings_exports_include_attachments'] = 'Include Attachments & Attachment Data';
$lang['settings_exports_include_attachments_descr'] = 'Controls whether attachments and attachment records are included in the export or not. Including attachments will result in an additional Cassandra DB export and may take longer as a result.';
$lang['settings_exports_select_which_sql'] = 'Select which SQL version you wish to export';
$lang['settings_exports_mysql_export'] = 'MySQL Export';
$lang['settings_exports_mssql_export'] = 'MS SQL Export';
$lang['settings_exports_fair_use'] = 'Data Storage Policy';
$lang['settings_exports_your_testRail_instance_is_out'] = '<strong>Your TestRail instance is out of space.</strong> Case Fields can no
                        longer be added, attachments cannot be uploaded and Data Exports will not be allowed until your instance is back inside the allowed limit for your subscription.
                        Please refer to our ';

$lang['settings_restore_backup_requested'] = 'Restore requested.';
$lang['settings_cancel_restoration'] = 'Cancel restoration?';
$lang['settings_tabs_backup'] = 'Backups';
$lang['settings_backup_no_backups'] = 'There are no backups';
$lang['settings_restore_backup'] = 'Restore Backup';
$lang['no_backups'] = 'There are no backups to restore';
$lang['settings_restore_backup_desc'] = 'Select & restore backup from the list of available snapshots above. Restoring your last backup will overwrite any changes made since the backup was taken and is not reversible.';
$lang['settings_want_to_restore_backup_confirm'] = 'Do you really want to restore this backup of your TestRail instance?';
$lang['settings_want_to_restore_backup_confirm_red'] = 'Your TestRail instance will be frozen once you click OK. Only administrators will be able to login. Other users may lose their work. Once the restoration gets under way, the site will go into maintenance mode for the duration of the restore. Once the restoration is completed (which may take some time depending on the size of your database), the administrators will receive a confirmation email and users will be able to access the site as normal.<p class=&quot;dialog-extra text-delete&quot;>Please note that you will lose any changes made in TestRail since the last backup was taken.</p>';
$lang['settings_want_to_restore_backup_confirm_checkbox'] = 'Yes, restore my TestRail backup now. (Enter &quot;restore backup&quot; in the test field below).';
$lang['settings_want_to_restore_backup_confirm_desc'] = 'You will receive an email once the restoration is completed.';
$lang['settings_preferred_backup_time'] = 'Preferred Backup Time (UTC)';
$lang['settings_preferred_backup_time_desc'] = 'The approximate time at which you would prefer your instance backup to be taken in order to minimise any disruption to user activities.';
$lang['settings_last_backup_time'] = 'Last Backup Time (UTC)';

$lang['settings_audit_level'] = 'Audit Level';
$lang['settings_audit_level_desc'] = 'The level of auditing required for your TestRail instance. High includes all entity creations, updates and deletions. Medium captures just updates and
deletions. Low records only deletions.';
$lang['settings_number_of_rows'] = 'Number of Rows';
$lang['settings_number_of_rows_desc'] = 'The number of audit rows displayed per page in the log.';
$lang['settings_max_number_of_audit_records'] = 'Maximum Number of Audit Records Stored';
$lang['settings_max_number_of_audit_records_desc'] = 'The maximum number of records stored for your instance.';
$lang['settings_custom_audit_record_volume'] = 'Custom Audit Record Volume (Millions)';
$lang['settings_custom_audit_record_volume_desc'] = 'You can specify the number of audit records in millions.';
$lang['settings_audit_number_of_days'] = 'Maximum Number of Days Audit Records';
$lang['settings_audit_number_of_days_desc'] = 'The number of days for which audit logs are stored. Note that storage duration is subject to the maximum record count above. Once the maximum is exceeded, excess audit records will be removed.';
$lang['settings_custom_number_of_days'] = 'Custom Audit Record Storage (Days)';
$lang['settings_custom_number_of_days_desc'] = 'You can specify the storage time of audit records in days.';
$lang['settings_auditing_configuration_checkbox'] = 'Write audit logs to an external file (Server edition only)';
$lang['settings_auditing_configuration_checkbox_desc'] = 'Check this box to write logs to an external file which you can connect to using a log reader.';
$lang['settings_auditing_custom'] = 'Custom';
$lang['settings_auditing_days'] = 'Days';
$lang['settings_auditing_million'] = 'Million';
$lang['settings_auditing_low'] = 'Low';
$lang['settings_auditing_medium'] = 'Medium';
$lang['settings_auditing_high'] = 'High';
$lang['settings_auditing_off'] = 'Off';
$lang['settings_installation_type'] = 'Installation Type';
$lang['settings_force_secure_cookies'] = 'Force Secure Cookies';
$lang['settings_force_secure_cookies_desc'] = 'Forces the installation to use secure cookies. This setting will only work if your TestRail installation is secured with HTTPS. Forcing secure cookies while on HTTP will break any session based browser activity.';

$lang['refresh_button']='Refresh';
$lang['refresh_button_desc']='Refresh the Audit Log Table';

$lang['settings_auditing_export_hint'] = 'Export Audit Log';
$lang['settings_auditing_export_hint_desc'] = 'Exports the Audit Log into Excel or CSV format';

$lang['export_yesterday'] = 'Yesterday';
$lang['as_filtered'] = 'As filtered';
$lang['export_today'] = 'Today';
$lang['export_last_three'] = 'Last 3 Days';
$lang['export_week'] = 'Last 7 Days';
$lang['export_filtered'] = 'As filtered';

$lang['audit_col_date'] = 'Date';
$lang['audit_col_project_name'] = 'Project Name';
$lang['audit_col_entity_type'] = 'Entity Type';
$lang['audit_export_col_entity_id'] = 'Entity Id';
$lang['audit_col_entity_name'] = 'Entity Name';
$lang['audit_col_action_type'] = 'Action Type';
$lang['audit_col_action'] = 'Action';
$lang['audit_col_user_id'] = 'Author ID';
$lang['audit_col_user'] = 'Author';
$lang['audit_col_mode'] = 'Mode';

$lang['audit_low'] = 'Low';
$lang['audit_medium'] = 'Medium';
$lang['audit_high'] = 'High';
$lang['audit_delete'] = 'Delete';
$lang['audit_mark_as_deleted'] = 'Mark as Deleted (Test Cases)';
$lang['audit_update'] = 'Update';
$lang['audit_create'] = 'Create';
$lang['audit_restore'] = 'Restore';
$lang['audit_permanently_delete'] = 'Permanently Delete';
$lang['audit_comment'] = 'Comment';
$lang['audit_assignment'] = 'Assignment';
$lang['audit_users'] = 'User';
$lang['audit_groups'] = 'Group';
$lang['audit_roles'] = 'Role';
$lang['audit_projects'] = 'Project';
$lang['audit_suites'] = 'Suite';
$lang['audit_sections'] = 'Section';
$lang['audit_cases'] = 'Case';
$lang['audit_shared_steps'] = 'Shared Test Step';
$lang['audit_tests'] = 'Test';
$lang['audit_webhooks'] = 'Webhooks';
$lang['audit_test_results'] = 'Test Result';
$lang['audit_milestones'] = 'Milestone';
$lang['audit_test_plans'] = 'Test Plan';
$lang['audit_test_runs'] = 'Test Run';
$lang['audit_report'] = 'Report';
$lang['audit_scheduled_report'] = 'Scheduled Report';
$lang['audit_report_template'] = 'API Template Report';
$lang['audit_attachments'] = 'Attachment';
$lang['audit_defects'] = 'Defect';
    //Only Admin Section
$lang['audit_case_fields'] = 'Case Field';
$lang['audit_result_fields'] = 'Result Field';
$lang['audit_priorities'] = 'Priority';
$lang['audit_templates'] = 'Template';
$lang['audit_statuses'] = 'Status';
$lang['audit_ui_scripts'] = 'UI Script';
$lang['audit_case_types'] = 'Case Type';
$lang['audit_ui'] = 'UI';
$lang['audit_api'] = 'API';
$lang['audit_settings'] = 'Settings';
$lang['audit_user_fields'] = 'Field';
$lang['audit_config_groups'] = 'Config Group';
$lang['audit_configs'] = 'Config';
$lang['audit_backup'] = 'Preferred Backup Time';
$lang['audit_restore'] = 'Restore';
$lang['audit_email_templates'] = 'Email Template';
$lang['audit_filter_reset'] = 'Remove filter and show all audit logs.';

// Integration
$lang['apps_tabs_head'] = 'Apps';
$lang['apps_tabs_information'] = 'The following integrations can be used to sign into TestRail.';
$lang['apps_tabs_integration'] = 'Integration';
$lang['apps_tabs_tbl_header_name'] = 'Name';
$lang['apps_tabs_tbl_header_date'] = 'Date added';
$lang['apps_tabs_tbl_header_permission'] = 'Permissions';
$lang['apps_tabs_assembla_can'] = 'Assembla can:';
$lang['apps_tabs_read_info'] = '• Read your user information </br> • Read your testing information';
$lang['apps_tabs_quick_links'] = 'Quick Links:';
$lang['apps_tabs_revoke_all'] = 'Revoke all permissions and authorizations for this app';
$lang['apps_tabs_btn_remove_app'] = 'Remove App';
$lang['settings_oidc_single_sign_on_url_desc'] = 'You will need to provide the Single Sign On URL to your Identity Provider (IDP).';

$lang['settings_name'] = "Name";
$lang['settings_name_description'] = 'This name will be displayed on the Auth tab of user account settings';
$lang['issuer_uri'] = 'IDP Issuer URL';
$lang['issuer_uri_description'] = 'Please enter the Issuer URL of your IDP';
$lang['settings_whitelist_domains'] = 'Whitelist Domains';
$lang['settings_whitelist_domains_description'] = 'Restricting new account creation to certain email domains can be used to prevent requests 
from unauthorized organizations. Simply enter one domain per line.';
$lang['settings_whitelist_domains_placeholder'] = '; Please enter one email domain per line:
; gmail.com
; yahoo.com';
