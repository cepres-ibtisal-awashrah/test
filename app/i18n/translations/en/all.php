<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$lang['activities_chart_passed'] = '{0} Passed';
$lang['activities_chart_passed_desc'] = '{0}% were successful.';
$lang['activities_chart_blocked'] = '{0} Blocked';
$lang['activities_chart_blocked_desc'] = '{0}% marked as blocked.';
$lang['activities_chart_retest'] = '{0} Retest';
$lang['activities_chart_retest_desc'] = '{0}% marked as retest.';
$lang['activities_chart_failed'] = '{0} Failed';
$lang['activities_chart_failed_desc'] = '{0}% were unsuccessful.';
$lang['activities_chart_legend'] = 'In the past {0} days:';
$lang['activities_chart_legend_timeframe'] = 'In the past <a class="link link-tooltip" {1} tooltip-text="Change the time frame for the chart.">{0} days</a>:';
$lang['activities_chart_days'] = 'Days';
$lang['activities_chart_range'] = '{0} &ndash; {1}:';
$lang['activities_deleted'] = 'Deleted';

$lang['admin_sidebar_description'] = 'Manage projects, users and global settings.';

$lang['admin_overview_trial_title'] = 'Your TestRail trial';
$lang['admin_overview_trial_title_expired'] = 'Your TestRail trial expired on {0}';
$lang['admin_overview_trial_title_expires'] = 'Your TestRail trial expires on {0}';
$lang['admin_overview_trial_action_hosted'] = 'You can <a target="_blank" href="{0}">create a
subscription</a> to upgrade your trial to a full account. TestRail is billed based on the maximum number of users that you have marked active each month. Please adjust your user count as needed before creating a subscription. If you prefer an installation on your own server, you can order licenses in the <a target="_blank" href="http://www.gurock.com/order?product=testrail">Gurock Software online shop</a> instead.';

#You can upgrade your TestRail Enterprise trial to a full installation by contacting the Gurock Software support team for a quote.
$lang['admin_overview_trial_action_download_enterprise'] = 'You can upgrade your TestRail trial
to a full installation by contacting the
<a target="_blank" href="https://secure.gurock.com/customers/support/support/?subject=4">Gurock Software support team</a> for a quote.';

$lang['admin_overview_trial_action_download'] = 'You can upgrade your TestRail trial
to a full installation by purchasing TestRail licenses in the
<a target="_blank" href="http://www.gurock.com/order?product=testrail">Gurock Software online shop</a>
or contacting the <a target="_blank" href="http://www.gurock.com/testrail/support/">Gurock Software support</a> for a quote.';


$lang['admin_overview_trial_action_subscribe'] = 'Create Subscription';
$lang['admin_overview_trial_action_order'] = 'Order Licenses';
$lang['admin_overview_trial_links'] = 'You can:';
$lang['admin_overview_trial_links_subscribe'] = 'Create a subscription';
$lang['admin_overview_trial_links_purchase'] = 'Purchase licenses';
$lang['admin_overview_trial_links_quote'] = 'Get a quote or contact support';

$lang['admin_overview_full_title'] = 'Welcome to the administration area!';
$lang['admin_overview_full_intro'] =
'The administration area lets you configure projects, various customization and integration
settings as well as manage users, roles and permissions.';
$lang['admin_overview_full_links'] = 'Quick links:';
$lang['admin_overview_full_links_project'] = 'Add a new project';
$lang['admin_overview_full_links_users'] = 'Add or disable users';
$lang['admin_overview_full_links_license'] = 'Manage your license';
$lang['admin_overview_full_links_subscription'] = 'Manage your subscription';
$lang['admin_overview_legal_terms'] = 'Legal Terms & DPA';
$lang['admin_overview_subscription'] = 'https://secure.gurock.com/customers/auth/login';
$lang['admin_overview_legal'] = 'https://www.ideracorp.com/legal/Gurock';

$lang['admin_overview_about'] = 'About TestRail';
$lang['admin_overview_info'] = 'Info';
$lang['admin_overview_about_app'] = 'TestRail version';
$lang['admin_overview_about_app_new'] = '(<a class="link" target="_blank" href="{0}">update available</a>)';
$lang['admin_overview_about_app_check'] = '(<a class="link" target="_blank" href="{0}">check for update</a>)';
$lang['admin_overview_about_app_latest'] = '(up-to-date)';
$lang['admin_overview_about_built'] = 'Built on';
$lang['admin_overview_about_db'] = 'Database version';
$lang['admin_overview_debug'] = '<strong>Please note</strong>: Debug logging is enabled in your config.php file which can negatively impact the performance of your TestRail installation.';

$lang['admin_overview_boxes_projects'] = 'Projects';
$lang['admin_overview_boxes_projects_desc'] = 'Manage projects and project access &amp; permissions.';
$lang['admin_overview_boxes_projects_view'] = 'View projects';
$lang['admin_overview_boxes_projects_add'] = 'Add a new project';
$lang['admin_overview_boxes_users'] = 'Users &amp; Roles';
$lang['admin_overview_boxes_users_desc'] = 'Add or deactivate users and manage roles &amp; permissions.';
$lang['admin_overview_boxes_users_view'] = 'View users &amp; roles';
$lang['admin_overview_boxes_users_add'] = 'Add a new user';
$lang['admin_overview_boxes_custom'] = 'Customizations';
$lang['admin_overview_boxes_custom_desc'] = 'Manage custom or standard fields and customize TestRail\'s user interface.';
$lang['admin_overview_boxes_custom_manage'] = 'Manage customizations';
$lang['admin_overview_boxes_integration'] = 'Integration';
$lang['admin_overview_boxes_integration_desc'] = 'Manage your defect and requirement integrations (with JIRA and other tools).';
$lang['admin_overview_boxes_integration_manage'] = 'Manage integration';
$lang['admin_overview_boxes_license'] = 'License';
$lang['admin_overview_boxes_license_desc'] = 'View your license status, change your license key or add additional users.';
$lang['admin_overview_boxes_license_manage'] = 'Manage license';
$lang['admin_overview_boxes_subscription'] = 'Subscription';
$lang['admin_overview_boxes_subscription_desc'] = 'Manage your subscription, change your payment details or create backups.';
$lang['admin_overview_boxes_subscription_manage'] = 'Manage subscription';
$lang['admin_overview_boxes_log'] = 'System Log';
$lang['admin_overview_boxes_log_desc'] = 'View the system log to troubleshoot possible issues with your installation.';
$lang['admin_overview_boxes_log_view'] = 'View system log';
$lang['admin_overview_boxes_settings'] = 'Site Settings';
$lang['admin_overview_boxes_settings_desc'] = 'Configure your installation, email settings and more.';
$lang['admin_overview_boxes_settings_manage'] = 'Manage site settings';

$lang['admin_overview_clear_messages_hint'] = 'Clear Messages';
$lang['admin_overview_clear_messages_hint_desc'] = 'Deletes all messages and empties the message queue.';
$lang['admin_overview_clear_messages_confirm'] = 'Really delete all messages? This change cannot be undone.';
$lang['admin_overview_clear_messages_success'] = 'Successfully deleted all messages and cleared the message queue.';
$lang['admin_overview_clear_messages_error'] = 'An error occurred while emptying the message queue.
Please try again.';

$lang['admin_overview_administration'] = 'Administration';
$lang['admin_overview_task'] = 'Background Task';
$lang['admin_overview_task_installed'] = 'Installed';
$lang['admin_overview_task_installed_help'] = '(<a class="link" target="_blank" href="https://www.gurock.com/testrail/docs/admin/howto/background-task">activate</a>)';
$lang['admin_overview_task_status'] = 'Status';
$lang['admin_overview_task_status_running'] = 'Running ({0} {0?{messages}:{message}})';
$lang['admin_overview_task_status_idle_locked'] = 'Idle (locked, {0} {0?{messages}:{message}})';
$lang['admin_overview_task_status_idle_notlocked'] = 'Idle (not locked, {0} {0?{messages}:{message}})';
$lang['admin_overview_task_lastrun'] = 'Last run';

$lang['admin_overview_nutshell_professional_cloud'] = 'Professional Cloud';
$lang['admin_overview_nutshell_enterprise_cloud'] = 'Enterprise Cloud';
$lang['admin_overview_nutshell_your_subs'] = 'Your Subscription';
$lang['admin_overview_nutshell_at'] = 'at';
$lang['admin_overview_nutshell_your_storage'] = 'Your Storage';
$lang['admin_overview_nutshell_contact_us'] = 'Contact us';
$lang['admin_overview_nutshell_please_click_below'] = 'Please click below to contact us and manage your subscription. We will help you to change your payment & contact details, upgrade your account and other issues.';
$lang['admin_overview_nutshell_your_storage_details'] = 'Your Storage Details';
$lang['admin_overview_nutshell_database'] = 'DATABASE:';
$lang['admin_overview_nutshell_attachments'] = 'ATTACHMENTS:';

$lang['admin_license_extend'] = 'You can order additional licenses or extend your licenses in your <a target="_blank" href="https://secure.gurock.com/customers/auth/login/L3BvcnRhbC9saWNlbnNlcy8_">Gurock Software customer account</a>.';

#You can order additional licenses or extend your licenses/support plan by contacting the Gurock Software support team for a quote.
$lang['admin_license_extend_enterprise'] = 'You can order additional licenses or extend your
licenses by contacting the
<a target="_blank" href="https://secure.gurock.com/customers/support/">Gurock Software support team</a> for a quote.';

$lang['admin_license_update_to_full'] = 'To upgrade your TestRail installation to a full
license, please visit the
<a target="_blank" href="http://www.gurock.com/order?product=testrail">Gurock Software online shop</a>.';

# You can upgrade your TestRail Enterprise trial to a full installation by contacting the Gurock Software support team for a quote.
$lang['admin_license_update_to_full_enterprise'] = 'You can upgrade your TestRail Enterprise trial to a full installation by contacting the
<a target="_blank" href="https://secure.gurock.com/customers/support/">Gurock Software support team</a> for a quote.';


$lang['admin_license_trial'] = 'To purchase licenses for a local installation of TestRail,
please visit the
<a target="_blank" href="http://www.gurock.com/order?product=testrail">Gurock Software online shop</a>.';

$lang['admin_log_intro'] = 'The system log shows diagnostic and
informational messages and helps troubleshoot possible issues with
your TestRail installation. Please contact the Gurock Software <a href="http://www.gurock.com/testrail/support/" target="_blank">support staff</a> in case you have any questions.';
$lang['admin_log_empty'] = 'Your system log is currently empty.';

$lang['admin_custom_case_fields'] = 'Case Fields';
$lang['admin_custom_test_fields'] = 'Result Fields';
$lang['admin_custom_templates'] = 'Templates';
$lang['admin_custom_case_types'] = 'Case Types';
$lang['admin_custom_priorities'] = 'Priorities';
$lang['admin_custom_result_statuses'] = 'Result Statuses';
$lang['admin_custom_case_statuses'] = 'Case Statuses';
$lang['admin_custom_uiscripts'] = 'UI Scripts';

$lang['admin_overview_boxes_subscription_enterprise_desc'] = 'Manage your subscription or create backups.';
$lang['admin_overview_trial_links_subscribe_enterprise'] = 'Contact us to create a subscription';
$lang['admin_overview_trial_links_switch_classic'] = 'Switch back to Classic TestRail';

$lang['admin_overview_title_enterprise'] = 'Welcome to the administration area!';
$lang['admin_overview_desc_enterprise'] = 'You can contact us to convert your enterprise trial to a paid subscription plan. If you prefer an installation on your own server, or if you prefer to switch back to Classic TestRail instead, please contact us.';

$lang['administrator_access_denied'] = 'Access Denied. You are not a TestRail administrator. Field:project_id is a required field.';
$lang['admin_overview_trial_enterprise_title_expired'] = 'Your TestRail Enterprise Cloud trial expired on {0}';
$lang['admin_overview_trial_enterprise_title_expires'] = 'Your TestRail Enterprise Cloud trial expires on {0}';
$lang['admin_overview_trial_enterprise_title'] = 'Your TestRail Enterprise Cloud trial';

$lang['admin_overview_trial_enterprise_server_title_expired'] = 'Your TestRail Enterprise Server trial expired on {0}';
$lang['admin_overview_trial_enterprise_server_title_expires'] = 'Your TestRail Enterprise Server trial expires on {0}';
$lang['admin_overview_trial_enterprise_server_title'] = 'Your TestRail Enterprise Server trial';

$lang['administrator_user_data_access'] = 'Access Denied. You are not a TestRail administrator.';

$lang['audit_logs_action']      = 'Action';
$lang['audit_logs_author']      = 'Author';
$lang['audit_logs_entity_name'] = 'Entity Name';
$lang['audit_logs_entity_type'] = 'Entity Type';
$lang['audit_logs_date']        = 'Date';
$lang['audit_logs_mode']        = 'Mode';
$lang['audit_logs_project']     = 'Project Name';
$lang['user_not_administrator'] = 'Access Denied. You are not a TestRail administrator. Field:project_id is a required field.';
$lang['integration_invalid_integration_url'] = 'Invalid URL (Assembla Organization) address.';
$lang['manager_access_denied'] = 'The requested project does not exist or you do not have the permissions to access it.';
$lang['user_not_administrator'] = 'Access Denied. You are not a TestRail administrator. Field:project_id is a required field.';
$lang['admin_custom_add_field'] = '+ Add Fields';
$lang['admin_custom_add_selected'] = 'Add Selected';
$lang['admin_custom_case_fields_dialog_title'] = 'Add Case Fields to Template';
$lang['admin_custom_test_fields_dialog_title'] = 'Add Result Fields to Template';

$lang['apiv2_content_missing'] = 'Content-Type header missing (use Content-Type: application/json)';
$lang['apiv2_content_invalid'] = 'Content-Type header invalid (use Content-Type: application/json)';

$lang['apiv2_disabled'] = 'The API is disabled for your installation. It can be enabled in the administration area in TestRail under Administration > Site Settings > API.';
$lang['apiv2_denied'] = 'The API is disabled for your installation.';
$lang['apiv2_session_disabled'] = 'Session authentication is disabled for the API. It can be enabled in the administration area in TestRail under Administration > Site Settings > API.';
$lang['apiv2_unauthorized'] = 'Authentication failed: invalid or missing user/password or session cookie.';
$lang['apiv2_failed_to_enable_api'] = 'Failed to enable API.';

$lang['users_tabs_oauth'] = 'Auth';
$lang['asm_configure_sso'] = 'Configure OAuth';
$lang['asm_following_integrations'] = 'The following integrations can be used to sign into TestRail';
$lang['asm_available_integrations'] = 'Available integrations';
$lang['asm_assembla'] = 'Assembla';
$lang['asm_authenticator_app'] = 'Authenticator App';
$lang['asm_not_connected_yet'] = 'Not connected yet';
$lang['asm_connected_as'] = 'Connected as';
$lang['asm_connect_account'] = 'Connect Account';
$lang['asm_connect'] = 'Connect';
$lang['asm_disconnect_account'] = 'Disconnect Account';
$lang['asm_dialog_title'] = 'Configure Assembla';
$lang['asm_connect_account'] = 'Connect Account';
$lang['asm_connect_applications'] = 'Configure Connected Applications';
$lang['asm_integration_integrate_using_oauth_two'] = 'Integrate using Oauth 2...';
$lang['asm_integration_integrate_using_oauth_desc'] = 'Use the Connect Account button and we’ll handle the rest for you!';
$lang['asm_integration_integrate_desc'] = 'You can also Connect / Disconnect your Assembla account via your <a href="{0}">User Settings</a> console';
$lang['asm_integration_enter_assembla_details'] = '... or enter your Assembla details below';
$lang['asm_integration_enter_assembla_desc'] = 'We need your Assembla URL, API token and Secret, and Space details if you have them.';
$lang['asm_integration_url'] = 'Assembla URL';
$lang['asm_integration_organization'] = 'Assembla Organization';
$lang['asm_integration_assembla_url_desc'] = 'The full web address of your Assembla instance (as you access it with your web browser).';
$lang['asm_integration_token'] = 'Assembla Token';
$lang['asm_integration_token_desc'] = 'Constrain the integration to a specified Assembla Space by entering the Space name here.';
$lang['asm_integration_secret_key'] = 'Assembla Secret';
$lang['asm_integration_space'] = 'Assembla Space';
$lang['asm_integration_space_desc'] = 'Constrain the integration to a specified Assembla Space by entering the Space name here';
$lang['asm_integration_defect_desc'] = 'Defect integration (to link resuts to and push/lookup Assembla issues)';
$lang['asm_integration_int_desc'] = 'Reference integration (to link cases to Assembla requirements/user stories)';
$lang['asm_integration_assembla_title'] = 'Assembla';
$lang['asm_integration_assembla_sub_title'] = 'Use a defect management tool';
$lang['asm_integration_assembla_desc'] = 'Click the button below to set up the integration between Assembla and TestRail. The integration enables you to view Assembla tickets and add new tickets directly from TestRail.';
$lang['asm_integration_assembla_desc_note'] = 'The API must be enabled and any users created via SSO or LDAP integration must have TestRail API keys configured for the integration to be successul.';
$lang['asm_settings_integration_configure'] = 'Configure Integration';
$lang['asm_link_assembla_management'] = 'https://www.gurock.com/testrail/assembla-test-management';
$lang['asm_assembla_integration'] = 'Assembla Configuration';
$lang['asm_configure_title'] = 'Configure Assembla Integration';
$lang['asm_integration_enable'] = 'Enable Assembla Integration';
$lang['asm_integration_api_key'] = 'API Key';
$lang['asm_integration_api_secret'] = 'API Secret';
$lang['asm_integration_disconnect_confirm'] = 'Are you sure want to disconnect account?';
$lang['asm_integration_checkbox_empty'] = 'Please enable at least one integration option (test results and/or test cases).';
$lang['oauth_not_connected'] = 'Assembla instance must be configured by an administrator before connecting via OAuth.';
$lang['mfa_dialog_title'] = 'Connect Authenticator App';
$lang['continue_dialog'] = 'Continue';
$lang['cancel_dialog'] = 'Cancel';
$lang['mfa_dialog_sub_heading'] = 'Please, follow these 2 steps :';
$lang['qr_code_heading'] = '1. Scan the QR code with your two-factor Authenticator App in your phone or device.';
$lang['authentication_code_heading'] = '2. After scanning the code, enter the 6-digit authentication code displayed to verify that enrollment was successful.';
$lang['authentication_code_heading_error'] = 'Sorry, there was a problem';
$lang['authentication_code_sub_heading_error'] = 'Entered code is incorrect. Please try again:';
$lang['mfa_disconnect_confirmation'] = 'Confirmation';
$lang['mfa_disconnect_confirmation_message'] = 'Disconnect your Authenticator App?';
$lang['mfa_disconnect_confirmation_subheading'] = 'To enable this security feature again, you will need to reconfigure your app.';
$lang['mfa_disconnect'] = 'Disconnect';
$lang['mfa_connected'] = 'Connected';
$lang['secret_key'] = 'Secret key:';
$lang['asm_integration_webhook_webhook_name_exist'] = 'Webhook name already exist';
$lang['asm_integration_webhook_webhook_not_active'] = 'Webhook is not active';
$lang['asm_integration_webhook_webhook_name'] = 'Webhook Name';
$lang['asm_integration_webhook_payload_url'] = 'Payload URL';
$lang['asm_integration_webhook_method'] = 'Method';
$lang['asm_integration_webhook_content_type'] = 'Content Type';
$lang['asm_integration_webhook_request_headers'] = 'Headers';
$lang['asm_integration_webhook_request_payload'] = 'Payload';
$lang['asm_integration_webhook_response_headers'] = 'Headers';
$lang['asm_integration_webhook_response_payload'] = 'Payload';
$lang['asm_integration_webhook_state'] = 'State';
$lang['asm_integration_webhook_secret'] = 'Secret';
$lang['asm_integration_webhook_projects'] = 'Projects';
$lang['asm_integration_webhook_events'] = 'Events';
$lang['asm_integration_webhook_active'] = 'Active';
$lang['asm_integration_webhook_ids'] = 'Ids';
$lang['asm_webhook_page'] = 'Webhook Page';
$lang['asm_integration_webhook_id'] = 'Id';
$lang['asm_integration_webhook_hook_id'] = 'Hook Id';
$lang['asm_integration_webhook_headers_string'] = "Content-Type: %content_type%\ntestrail-hook-id: %hook_id%\nx-testrail-delivery: %testrail_delivery_id%";
$lang['asm_integration_webhook_payload_string'] = "{&quot;widget&quot;: { \n    &quot;text&quot;: { \n        &quot;data&quot;: &quot;Click Here&quot;, \n        &quot;size&quot;: 36, \n        &quot;style&quot;: &quot;bold&quot;, \n        &quot;name&quot;: &quot;text1&quot;, \n        &quot;hOffset&quot;: 250, \n        &quot;vOffset&quot;: 100, \n        &quot;alignment&quot;: &quot;center&quot;, \n        &quot;onMouseUp&quot;: &quot;sun1.opacity = (sun1.opacity / 100)&quot; \n    } \n}}";
$lang['asm_integration_webhook_variables'] = [
    "%assigned_to%",
    "%case_priority%",
    "%case_type%",
    "%completed_on%",
    "%config%",
    "%custom_x%",
    "%description%",
    "%due_on%",
    "%entity_created%",
    "%entity_creator%",
    "%estimate%",
    "%event_created%",
    "%event_creator%",
    "%event_type%",
    "%id%",
    "%is_deleted%",
    "%milestone_id%",
    "%more_info%",
    "%name%",
    "%project_id%",
    "%refs%",
    "%section_id%",
    "%stats%",
    "%suite_id%",
    "%template_name%",
    "%url%",
    "%secret%",
    "%custom_status1_count%",
    "%custom_status2_count%",
    "%custom_status3_count%",
    "%custom_status4_count%",
    "%custom_status5_count%",
    "%custom_status6_count%",
    "%custom_status7_count%",
    "%custom_automation_type%",
    "%custom_options_cases_groupby%",
    "%custom_options_changes_daterange%",
    "%custom_options_changes_daterange_from%",
    "%custom_options_changes_daterange_to%",
    "%custom_options_suites_include%",
    "%custom_options_suites_ids%",
    "%custom_options_sections_include%",
    "%custom_options_sections_ids%",
    "%custom_options_cases_columns%",
    "%custom_options_cases_filters%",
    "%custom_options_cases_limit%",
    "%custom_options_content_hide_links%",
    "%custom_options_cases_include_new%",
    "%custom_options_cases_include_updated%",
    "%is_completed%",
    "%type_id%"
];
$lang['asm_integration_webhook_name'] = 'Webhook Name';
$lang['asm_integration_webhook_description'] = 'Give your webhook a unique and descriptive name.';
$lang['asm_integration_webhook_payload_url'] = 'Payload URL';
$lang['asm_integration_webhook_payload_url_error'] = 'Webhooks cannot be sent to uncertified endpoints.
Please configure your consuming service so it uses HTTPS and re-enter the Payload URL accordingly.';
$lang['asm_integration_webhook_payload_url_description'] = 'We’ll send a request to the specified URL with details of any subscribed events.';
$lang['asm_integration_webhook_content_type'] = 'Content Type';
$lang['asm_integration_webhook_payload_json_error'] = 'Invalid JSON format';
$lang['asm_integration_webhook_method'] = 'Method';
$lang['asm_integration_webhook_headers'] = 'Headers';
$lang['asm_integration_webhook_header_description'] = 'Add headers as required by your integration.';
$lang['asm_integration_webhook_payload'] = 'Payload';
$lang['asm_integration_webhook_payload_description'] = 'Add payload as required by your integration.';
$lang['asm_integration_webhook_secret'] = 'Secret';
$lang['asm_integration_webhook_events'] = 'Events';
$lang['asm_integration_webhook_event_all'] = 'All';
$lang['asm_integration_webhook_event_plan_created'] = 'Plan created';
$lang['asm_integration_webhook_event_plan_updated'] = 'Plan updated';
$lang['asm_integration_webhook_event_plan_entry_created'] = 'Plan entry created';
$lang['asm_integration_webhook_event_plan_entry_updated'] = 'Plan entry updated';
$lang['asm_integration_webhook_event_plan_entries_created'] = 'Plan entries created';
$lang['asm_integration_webhook_event_plan_entries_updated'] = 'Plan entries updated';
$lang['asm_integration_webhook_event_run_created'] = 'Run created';
$lang['asm_integration_webhook_event_run_updated'] = 'Run updated';
$lang['asm_integration_webhook_event_case_created'] = 'Case created';
$lang['asm_integration_webhook_event_case_updated'] = 'Case updated';
$lang['asm_integration_webhook_event_cases_updated'] = 'Cases updated';
$lang['asm_integration_webhook_event_test_result_created'] = 'Test result created';
$lang['asm_integration_webhook_event_test_results_created'] = 'Test results created';
$lang['asm_integration_webhook_event_report_created'] = 'Report created';
$lang['asm_integration_webhook_event_reports_created'] = 'Reports created';
$lang['asm_integration_webhook_event_description'] = 'Select which TestRail events you wish to subscribe to.';
$lang['asm_integration_webhook_error_message_301'] = 'Please update your webhook to the new URL accordingly.';
$lang['asm_integration_webhook_error_message_429'] = 'Please take care to update your webhook to reduce the number of requests being generated.';
$lang['asm_integration_webhook_projects'] = 'Projects';
$lang['asm_integration_webhook_project_description'] = 'Select which TestRail projects you wish to subscribe to.';
$lang['asm_integration_webhook_active'] = 'Active';
$lang['asm_integration_webhook_active_description'] = 'We will deliver payloads when this webhook is triggered.';
$lang['asm_integration_webhook_delete_button'] = 'Delete';
$lang['asm_integration_webhook_test_title'] = 'Test your Webhook configuration';
$lang['asm_integration_webhook_test_button'] = 'Test';
$lang['asm_integration_webhook_recent_deliveries'] = 'Recent Deliveries';
$lang['asm_integration_webhook_method_post'] = 'POST';
$lang['asm_integration_webhook_method_get'] = 'GET';
$lang['asm_integration_webhook_method_put'] = 'PUT';
$lang['asm_integration_webhook_method_patch'] = 'PATCH';
$lang['asm_integration_webhook_method_delete'] = 'DELETE';
$lang['asm_integration_webhook_content_type_json'] = 'application/json';
$lang['asm_integration_webhook_content_type_url_encode'] = 'application/x-www-form-urlencoded';
$lang['asm_integration_webhook_content_type_xml'] = 'application/xml';
$lang['asm_integration_webhook_content_type_html'] = 'text/html';
$lang['asm_integration_webhook_content_type_plain'] = 'text/plain';
$lang['asm_integration_webhook_content_status_text'] = 'Status';
$lang['asm_integration_webhook_content_webhook_text'] = 'Webhook';
$lang['asm_integration_webhook_content_action_text'] = 'Actions';
$lang['asm_integration_webhook_content_request_text'] = 'REQUEST';
$lang['asm_integration_webhook_content_response_text'] = 'RESPONSE';
$lang['asm_integration_webhook_content_header_text'] = 'Headers';
$lang['asm_integration_webhook_content_header_text_description'] = 'Add headers as required by your integration.';
$lang['asm_integration_webhook_content_payload_text'] = 'Payload';
$lang['asm_integration_webhook_content_payload_text_description'] = 'Add payload as required by your integration.';
$lang['asm_integration_webhook_confirmation_text'] = 'Confirmation';
$lang['asm_integration_webhook_close_text'] = 'close';
$lang['asm_integration_webhook_delete_webhook_text'] = 'Delete Webhook?';
$lang['asm_integration_webhook_delete_webhooks_text'] = 'Delete Webhook(s)?';
$lang['asm_integration_webhook_delete_webhook_msg'] = 'This action cannot be undone. Future events will no longer be delivered to this webhook:';
$lang['asm_integration_webhook_delete_webhooks_msg'] = 'This action cannot be undone. Future events will no longer be delivered to the selected webhook(s):';
$lang['asm_integration_webhook_delete_text'] = 'Delete';
$lang['asm_integration_webhook_cancel_text'] = 'Cancel';
$lang['asm_integration_webhook_confirm_text'] = 'Confirm';
$lang['asm_integration_webhook_confirm_ok_text'] = 'OK';
$lang['asm_integration_webhook_confirm_error_text'] = 'Error';
$lang['asm_integration_webhook_project_warning'] = 'This change will affect the following projects:';
$lang['asm_integration_webhook_confirm_error_content'] = '<b>You don\'t have access to at least 1 of the projects this change will affect.</b> Please speak to an administrator instead.';
$lang['asm_integration_webhook_test_tool_message'] = "Click to test your webhook. We will list the last\n 10 requests and responses below, so you can see\n whether your configuration is working correctly.";
$lang['asm_integration_webhook_recent_deliveries_not_found'] = 'Webhook recent deliveries not found';
$lang['asm_integration_webhooks_not_found'] = 'Webhooks not found';
$lang['asm_integration_project_ids'] = 'Projects';
$lang['asm_integration_webhook_not_access'] = 'Not accessable';
$lang['asm_integration_delete_access_project_ids'] = 'Ids';
$lang['asm_integration_webhook_header_mandatory'] = "These Headers are mandatory. Editing and deleting\n are not allowed.";
$lang['asm_integration_webhook_project_id'] = "Project Id";
$lang['asm_integration_webhook_recent_header_mandatory'] = "These Headers are mandatory. Editing\n and deleting are not allowed.";
$lang['asm_integration_webhook_only_https'] = 'No webhooks can be sent until the instance is running under HTTPS.';
$lang['asm_integration_webhook_only_enterprise'] = 'Enterprise version requiered';
$lang['attachments_attachment'] = 'Attachment';
$lang['attachments_title'] = 'Attachments';
$lang['attachments_noattachments'] = 'No attachments.';
$lang['attachments_file'] = 'File';
$lang['attachments_file_desc'] = 'Choose the file to upload.';
$lang['attachments_image'] = 'Image';
$lang['attachments_image_desc'] = 'Choose the image to upload.';
$lang['attachments_add'] = 'Add Attachment';
$lang['attachments_attach_file'] = 'Attach file';
$lang['attachments_attach'] = 'Attach';
$lang['attachments_addimage'] = 'Add Images';
$lang['attachments_confirm_delete'] = 'This <strong>deletes selected instances of your attachments.</strong> The files will keep on being stored on your Library. Go to Attachments on Data Storage to delete permanently.';
$lang['attachments_confirm_delete_admin'] = 'This action <strong>deletes selected attachment/s and all their instances across your projects</strong> (except those on closed Test Runs & Plans) permanently. This cannot be undone. Do you wish to continue?';
$lang['attachments_error_exists'] = 'The attachment does not exist or you do not have the permission to access it.';
$lang['attachments_error_in_progress'] = 'The attachment migration process is in progress.';
$lang['attachments_error_required'] = 'The File field is required.';
$lang['attachments_error_partial'] = 'Attachment was only partially uploaded.';
$lang['attachments_error_nodir'] = 'No attachments directory configured.';
$lang['attachments_error_noaccess'] = 'Attachments directory is not writable.';
$lang['attachments_error_rename'] = 'An error occurred while renaming the attachment.';
$lang['attachments_error_in_use'] = 'Cannot delete an attachment that is still in use.';
$lang['attachments_denied_add'] = 'You are not allowed to add attachments (insufficient permissions).';
$lang['attachments_denied_add_storage_limit'] = 'Your TestRail instance is out of space. Case Fields can no longer be added, attachments cannot be uploaded and data exports will not be allowed until your instance is back inside the allowed limit for your subscription. Please refer to our https://www.ideracorp.com/Legal/Gurock/DataStoragePolicy.';
$lang['attachments_denied_edit'] = 'You are not allowed to edit attachments (insufficient permissions).';
$lang['attachments_denied_delete'] = 'You are not allowed to delete attachments (insufficient permissions).';
$lang['attachments_denied_replace'] = 'You are not allowed to repalce attachments (insufficient permissions).';
$lang['attachments_denied_rename'] = 'You are not allowed to rename attachments (insufficient permissions).';
$lang['attachments_element'] = 'Element';
$lang['attachments_error_malicious_file'] = 'It is restricted to upload malicious file';

$lang['attachments_drop'] = 'Drop files here to attach, or click to browse.';
$lang['attachments_drop_image'] = 'Drop images here to embed, or click to browse.';
$lang['attachments_drop_image_nobrowse'] = 'Drop images here to embed.';
$lang['attachments_drop_notype'] = 'You can only add images to this text field (example: PNG or JPG files).';
$lang['attachments_drop_notype_canattach'] = 'You can only add images to this text field (example: PNG or JPG files). You can attach other file types to a case or result from the sidebar or result dialogs.';
$lang['attachments_drop_notype_canattach_jira'] = 'You can only add images to this text field (example: PNG or JPG files).';

$lang['attachments_remove_image'] = 'Remove';
$lang['attachments_delete'] = 'Delete';
$lang['attachments_delete_dont_show_again'] = 'Don’t show me this again';

$lang['attachments_screenshot_take_mac'] = 'How to take a screenshot on your Mac:';
$lang['attachments_screenshot_take_win'] = 'How to take a screenshot on Windows:';
$lang['attachments_screenshot_paste'] = 'Then paste it:';

$lang['attachments_upload_idp_certificate'] = 'Upload IDP Certificate';
$lang['attachments_upload_file'] = 'Upload File';
$lang['attachments_file_here'] = 'Drop file here, or click to browse.';
$lang['attachments_file_desc'] = 'Choose the file to upload.';

$lang['attachments_not_found'] = 'Attachments were not found.';

$lang['attachments_overview_orderby'] = 'Order By';
$lang['attachments_overview_filter'] = 'Filter';

$lang['attachments_filter_type'] = 'Type';
$lang['attachments_filter_createdon'] = 'Upload date';
$lang['attachments_filter_owner'] = 'Created by';
$lang['attachments_filter_case'] = 'Case';
$lang['attachments_filter_run'] = 'Run';
$lang['attachments_filter_plan'] = 'Plan';
$lang['attachments_filter_milestone'] = 'Milestone';
$lang['attachments_filter_project'] = 'Project';
$lang['attachments_filter_orphaned'] = 'Orphaned';

$lang['attachments_add_file'] = 'Attach file';
$lang['attachments_confirm_replace'] = 'This action <strong>replaces current attachment with selected one. This will refresh all attachment’s instances across your projects</strong> (except those on closed Runs & Plans). This cannot be undone. Do you wish to continue?';
$lang['attachments_replace_title'] = 'Replace?';
$lang['attachments_loading_error_title'] = 'Loading error';
$lang['attachments_loading_error_generic'] = '<strong>An unexpected uploading error occurred.</strong><br><br>Try again!';

$lang['attachments_library_title'] = 'Files Library';
$lang['attachments_library_media_title'] = 'Media Library';
$lang['attachments_library_add_new'] = 'Add New';
$lang['attachments_library_delete'] = 'Delete';
$lang['attachments_library_replace'] = 'Replace';
$lang['attachments_library_sort'] = 'Sort:';
$lang['attachments_library_sort_date'] = 'Date';
$lang['attachments_library_sort_name'] = 'Name';
$lang['attachments_library_sort_size'] = 'Size';
$lang['attachments_library_filter'] = 'Filter:';
$lang['attachments_library_filter_none'] = 'None';
$lang['attachments_library_dropzone_text_drop'] = 'Drop files here to upload, or';
$lang['attachments_library_dropzone_text_select'] = 'Select Files';
$lang['attachments_library_dropzone_text_info'] = 'Maximum file size: 256 MB.';
$lang['attachments_library_size_info_1'] = 'Size of attachments: <strong><span id="filteredAttachmentsSize"></span></strong>.';
$lang['attachments_library_size_info_2'] = '<a target="_blank" href="https://www.gurock.com/testrail/docs/user-guide">Learn more about your storage limits.</a>';

$lang['attachments_dialog_info'] = 'Maximum file size: 256 MB.';

$lang['attachment_info_title'] = 'Attachment Details';
$lang['attachment_info_type'] = 'File Type';
$lang['attachment_info_size'] = 'Size';
$lang['attachment_info_uploaded_on'] = 'Uploaded on';
$lang['attachment_info_url'] = 'URL';
$lang['attachment_info_accessible_in'] = 'Accessible in';
$lang['attachment_info_full_image'] = 'Full Resolution';
$lang['attachment_info_download'] = 'Download';
$lang['attachment_info_done'] = 'Done';
$lang['attachment_info_all_projects'] = 'All Projects';

$lang['attachment_entity_list_dropzone'] = 'Drop files here to attach,<br />or click on &quot;+&quot; to browse';

$lang['attachment_delete_mode_info'] = '(Click and hold to enter delete mode)';

$lang['attachment_info_currently_being_upgraded'] = 'Your attachments are currently being upgraded.';
$lang['auth_return_url'] = 'Return Url';
$lang['auth_login_email'] = 'Email Address';
$lang['auth_login_name_email'] = 'Email/User';
$lang['auth_login_name'] = 'Login';
$lang['auth_reset_password'] = 'Reset Your Password';
$lang['auth_set_password'] = 'Set Your New Password';
$lang['auth_error'] = 'Sorry, there was a problem.';
$lang['auth_success'] = 'Success!';
$lang['auth_email'] = 'Email';
$lang['auth_password'] = 'Password';
$lang['auth_confirm_password'] = 'Confirm Password';
$lang['auth_not_valid_email'] = 'Email Address is not valid.';
$lang['auth_not_valid_password'] = 'Password is required.';
$lang['auth_required_password'] = 'Field Password is a required field.';

$lang['auth_short_password'] = 'Field Password is too short (5 characters required).';
$lang['auth_required_confirm_password'] = 'Field Confirm Password is a required field.';
$lang['auth_required_confirm_password_show'] = 'Confirm Password is required.';

$lang['auth_short_password_show'] = 'Password is too short (5 characters required).';
$lang['auth_short_confirm_password_show'] = 'Confirm Password is too short (5 characters required).';

$lang['auth_short_confirm_password'] = 'Field Confirm Password is too short (5 characters required).';
$lang['auth_short_email-login'] = 'Field Email/User is a required field.';
$lang['auth_required_email'] = 'Email Address is required.';
$lang['auth_Field_required_email'] = 'Field Email Address is a required field.';
$lang['auth_short_email-login_show'] = 'Email/Login is required.';
$lang['auth_notvalid_email'] = 'Field Email Address is not a valid email address.';
$lang['auth_login_name_desc'] = 'The login or user name you use to log in to TestRail.
This can be your domain or Windows account, for example.';
$lang['auth_login_rememberme'] = 'Keep me logged in on this computer';
$lang['auth_login_rememberme_name'] = 'Remember Me';
$lang['auth_login_password'] = 'Password';
$lang['auth_forgotpassword_intro'] = 'Please enter your email address below and you will receive an email with instructions on how to reset your password.';

$lang['auth_login_login'] = 'Log In';
$lang['auth_login_forgotpassword'] = 'I forgot my password';
$lang['auth_login_wrongpassword'] = 'Email/Login or Password is incorrect. Please try again.';
$lang['auth_login_fallback_disabled'] = 'This type of login is disabled for you. Please login using SSO.';
$lang['auth_login_sso'] = 'SSO Login';
$lang['auth_login_sso_disabled'] = 'SSO login is disabled for you. Please login using TestRail credentials.';
$lang['auth_login_max_attempts_reached'] = 'The maximum number of failed login attempts has been reached. Please try again in {0} {0?{minutes}:{minute}}.';
$lang['auth_poweredby'] = 'Powered by TestRail<br /><a href="http://www.gurock.com/testrail/" target="_blank">Test Management</a> Software';
$lang['auth_login_rememberme'] = 'Keep me logged in';
$lang['auth_forgot_password'] = 'Forgot your password?';
$lang['auth_or_login_with'] = 'or login with';
$lang['auth_single_sign_on'] = 'Single Sign On';
$lang['auth_log_in'] = 'Log into Your Account';
$lang['auth_impersonate_token_invalid'] = 'Please login below to access TestRail.';
$lang['auth_impersonate_params_missing'] = 'Please login below to access TestRail.';
$lang['auth_impersonate_token'] = 'Login Token';
$lang['auth_impersonate_user_id'] = 'User ID';
$lang['auth_impersonate_not_supported'] = 'Your TestRail installation does not support impersonation.
Please contact your TestRail administrator.';

$lang['auth_reset_password_token'] = 'Reset Token';
$lang['auth_reset_password_user_id'] = 'User ID';
$lang['auth_reset_password_token_invalid'] = 'The Reset Password link has expired or is invalid.
You can request a new password reset on the Forgot Password page (see the link below).';
$lang['auth_reset_password_params_missing'] = 'Please login below to access TestRail.';
$lang['auth_reset_password_success'] = 'Successfully set your password. Please login below to access TestRail.';
$lang['auth_reset_password_intro'] = 'You can set a new password below.
Please take the time to choose a secure and difficult to guess password.';
$lang['auth_reset_password_reset'] = 'Set New Password';
$lang['auth_reset_password_not_supported'] = 'Your TestRail installation does not support password resets.
Please contact your TestRail administrator.';

$lang['auth_login_custom_ext_error'] = 'External auth: {0}';
$lang['auth_login_custom_no_result'] = 'External auth: Empty result from custom auth script.';
$lang['auth_login_custom_no_role'] = 'External auth: Invalid result from custom auth (role is unknown; ID: "{0}").';
$lang['auth_login_custom_no_role_int'] = 'External auth: Invalid result from custom auth (role ID is not a number).';
$lang['auth_login_custom_no_group'] = 'External auth: Invalid result from custom auth (group is unknown; ID: "{0}").';
$lang['auth_login_custom_no_groups_array'] = 'External auth: Invalid result from custom auth (group IDs are not an array).';
$lang['auth_login_custom_no_groups_int'] = 'External auth: Invalid result from custom auth (group ID is not a number).';
$lang['auth_login_custom_no_email'] = 'External auth: Invalid result from custom auth script (email address is missing).';
$lang['auth_login_custom_invalid_email'] = 'External auth: Invalid result from custom auth script (email address has an invalid format).';
$lang['auth_login_custom_no_name'] = 'External auth: Invalid result from custom auth script (name is missing).';
$lang['auth_login_custom_no_user'] = 'External auth: Authenticated successfully, but no TestRail user was found for the given account.';

$lang['auth_login_custom_denied'] = 'External auth: Login or Password is incorrect.';
$lang['auth_login_custom_license'] = 'External auth: Authenticated successfully,
but cannot add a new user because the license limit has been reached ({0}/{1}).';

$lang['auth_forgotpassword_send'] = 'Reset Password';
$lang['auth_forgotpassword_disabled'] = 'Forgot Password is disabled for your TestRail installation. Please contact your administrator.';
$lang['auth_forgotpassword_disabled_sso'] = 'Forgot Password is disabled for your TestRail account. Please contact your administrator.';
$lang['auth_forgotpassword_success'] = 'Email sent successfully. Please check your email inbox for the reset password instructions.';
$lang['auth_forgotpassword_unknownemail'] = 'Unknown email address.';
$lang['auth_forgotpassword_emailfailed'] = 'Sending the password via email failed. Please contact your administrator (password was not changed).';
$lang['auth_forgotpassword_noemailserver'] = 'Sending the password failed: there is no email server configured (password was not changed). Please contact your administrator.';
$lang['auth_forgotpassword_not_supported'] = 'Your TestRail installation does not support password resets.
Please contact your TestRail administrator.
<br /><br />
If you are currently in the process of updating TestRail, please use the
<a href="https://www.gurock.com/testrail/docs/admin/installation/upgrading" target="_blank">command line updater</a>
to finish the update.';

$lang['auth_csrf_missing'] = 'The CSRF token is missing or invalid for this POST request.
This usually means that your session has expired. Please refresh this page.';
$lang['auth_ajax_error'] = 'You are not logged in or your session has timed out. Please refresh this page and log in again.';
$lang['auth_ip_check'] = 'Access denied from your location and/or IP address. Please contact your TestRail administrator.';
$lang['auth_admin_check'] = 'This operation requires administrator rights which are not enabled for your user account.';
$lang['auth_password_reset_required'] = 'The administrator has forced a password reset. Please check your email for further instructions.';

$lang['session_label_continue_working'] = 'Your session is about to expire due to inactivity';
$lang['session_ajax_continue_working'] = '  Continue working?';
$lang['auth_invalid_issuer'] = 'Your IDP is not configured with this testrail instance.';

$lang['auth_confirm'] = 'Confirm';
$lang['confirm_password_mismatch'] = 'The passwords did not match.';
$lang['auth_warning'] = 'Warning!';
$lang['layout_warning_js_login'] = 'Javascript is disabled in your web browser. Please enable Javascript, as Javascript is required to use TestRail.';
$lang['auth_login_user_inactive'] = 'Your TestRail account has been deactivated. Please contact your administrator.';
$lang['auth_login_sso_incorrect_attributes'] = 'SSO has not been configured correctly. Please contact your administrator.';
$lang['auth_login_locked_for_db_restoration'] = 'TestRail has been frozen pending a database restoration. Please try back later or contact an administrator.';
$lang['auth_oauth_login_with'] = 'or login with';

$lang['auth_login_exception_occured'] = 'Login: Exception occured. Code: {0}, Message: {1}';
$lang['auth_log_no_mail_attribute'] = 'SSO: Mail attribute not existant in samlUserData';
$lang['auth_log_sso_disabled'] = 'SSO: SSO disabled in instance. Existing...';
$lang['auth_log_sso_create_new_user_disabled'] = 'SSO: Creating new user for SSO disabled. Exiting...';
$lang['auth_log_saml_user_data_not_present'] = 'SSO: samlUserData not found in session. Exiting...';
$lang['auth_sso_exception_occured'] = 'SSO: Exception occured. Code: {0}, Message: {1}';
$lang['mfa_code_app'] = 'Enter the 6-digit code<br> available in your Authenticator app:';
$lang['mfa_code_email'] = 'Enter the 6-digit code<br> we\'ve just sent to your email:';
$lang['mfa_new_code_email'] = 'We\'ve sent you a NEW code. <br> Enter it below:';
$lang['send_new_code'] = 'Send me new code';
$lang['code_not_received'] = 'I didn\'t receive the code';
$lang['mfa_error_text'] = '<center>Entered code is incorrect.<br> Please try again.</center>';
$lang['mfa_code'] = 'Code';

$lang['whitelist_email_domain_error'] = 'Authenticated successfully, but cannot create user account. Please contact your TestRail administrator.';
$lang['tr_enterprise_banner_dialog_title'] = 'TestRail Enterprise Banner Settings';
$lang['tr_enterprise_banner_dialog_remove_for_this_session'] = 'Remove for this Session';
$lang['tr_enterprise_banner_dialog_remove_forever'] = 'Remove forever';
$lang['tr_enterprise_banner_setting_accepted'] = 'The TR Enterprise Banner setting was submitted successfully.';
$lang['tr_local_notification_learn_more'] = 'Learn more';
$lang['tr_local_notification_storage_exceeded'] = 'Your account exceeds allowed storage space! -';
$lang['tr_local_notification_storage_approaching'] = 'Your account is running out of storage space! -';

$lang['tr_enterprise_explore_button'] = 'Explore Enterprise';
$lang['tr_enterprise_discover_button'] = 'Discover Enterprise';
$lang['tr_enterprise_more_link'] = 'More on Enterprise';
$lang['tr_enterprise_quick_link'] = 'Quick Links:';

$lang['tr_enterprise_logo_title'] = '<span style="color: #979797;">Your edition:</span> 
    TestRail Professional';
$lang['tr_enterprise_sidebar_title'] = '<span style="color: #979797;">Your edition:</span> <br />
    TestRail Professional';
$lang['tr_enterprise_logo_desc'] = 'Enable enterprise-grade <strong>security</strong> 
    and <strong>performance.</strong>';

$lang['tr_enterprise_auditing_title'] = 'Strengthen security and enforce</br>compliance with advanced 
    <span style="color:#FCC200;">audit</br> logging</span>';
$lang['tr_enterprise_auditing_desc'] = 'Track every entity created, updated, or deleted in your TestRail instance. 
    Monitor changes from within TestRail or externally using your preferred monitoring solution. View and filter 
    audit logs, specify logging levels, and set log retention policies.';
$lang['tr_auditing_more_link'] = 'More on Auditing';

$lang['tr_enterprise_sso_title'] = 'Streamline user management with <span style="color:#FCC200;">
    Single Sign-On</span>';
$lang['tr_enterprise_sso_desc'] = 'Integrate TestRail with your preferred SSO identity provider (IDP) using
    the SAML 2.0 protocol. Automatically authenticate new users, eliminate the need for separate TestRail credentials,
    and secure access to your TestRail instance.';
$lang['tr_sso_more_link'] = 'More on SSO';

$lang['tr_enterprise_backup_title'] = 'Configure <span style="color:#FCC200;">backups</span> or launch a full 
    restore at the push of a button</span>';
$lang['tr_enterprise_backup_desc'] = 'Choose your preferred backup time window, see when the last backup
    was completed and, in an emergency, restore the last backup taken, overwriting any changes.';
$lang['tr_backup_more_link'] = 'More on Backups';

$lang['tr_enterprise_email_title'] = 'Go Enterprise to customize <span style="color:#FCC200;">email 
    </br>notifications</span> from TestRail';
$lang['tr_enterprise_email_desc'] = 'With TestRail Enterprise you have full control over email 
    notifications from TestRail. Choose which emails to send; then configure the text, subject lines, 
    and data to include.';

$lang['tr_enterprise_landing_title'] = 'Get enterprise-grade security, performance,</br>
    and support with TestRail <span style="color:#FCC200;">Enterprise Edition</span>';
$lang['tr_enterprise_landing_desc'] = '<li>SAML Single Sign-On (SSO) using your preferred identity provider</li>
                <li>Audit logs</li>
                <li>Configurable backup window and on-demand restore (for cloud instances)</li>
                <li>Customizable email notification templates</li>
                <li>Enhanced API performance (for cloud instances)</li>
                <li>Advanced project administration</li>
                <li>Enterprise-grade support </li>
                <li>1:1 Enterprise Expert training </li>';
$lang['tr_enterprise_get_button'] = 'Get Testrail Enterprise';

$lang['tr_enterprise_popup_title'] = 'Request a personalized quote';
$lang['tr_enterprise_popup_desc'] = '<strong>Simply click “Yes, send me a quote”</strong> to notify the TestRail 
    customer service team about your interest in TestRail Enterprise. We’ll prepare a personalized quote based on your 
    usage patterns and needs. You can expect a response within one business day.';
$lang['tr_enterprise_quote_button'] = 'Yes, send me a quote';
$lang['tr_enterprise_quote_cancel'] = 'Cancel';

$lang['tr_enterprise_confirm_title'] = 'Get ready to go <span class="text_focus">Enterprise!</span>';
$lang['tr_enterprise_confirm_desc'] = 'Our <strong>customer service team</strong> 
    has received your request and will respond<br /> within one business day.';

$lang['tr_enterprise_sso_more_link'] = 'https://www.gurock.com/testrail/docs/admin/enterprise/configure-sso';
$lang['tr_enterprise_auditing_more_link'] = 'https://www.gurock.com/testrail/docs/admin/server/audit-logging-testrail';
$lang['tr_enterprise_backup_more_link'] = 'https://www.gurock.com/testrail/docs/admin/enterprise/configurable-backup-time-restoration';
$lang['tr_enterprise_enterprise_more_link'] = 'https://www.gurock.com/testrail/tour/enterprise-edition';
$lang['bulk_update_save_changes'] = 'Apply Changes';
$lang['bulk_update_multiple_helper_steps'] = 'Steps to update multiple users';
$lang['bulk_update_multiple_helper_review_users'] = 'Review the users to update or remove them from the selection.';
$lang['bulk_update_multiple_helper_enable_fields'] = 'Enable the fields you want to update and select or enter their new values.';
$lang['bulk_update_multiple_helper_save_changes'] = 'Save your changes (a dialog with a summary is shown before your changes are applied).';
$lang['bulk_update_group_membership_description'] = 'Allows you to configure the groups of the users (group memberships).';
$lang['bulk_update_settings_on'] = 'On';
$lang['bulk_update_settings_off'] = 'Off';
$lang['bulk_update_settings_active'] = 'Active';
$lang['bulk_update_settings_inactive'] = 'Inactive';
$lang['bulk_update_settings_yes'] = 'Yes';
$lang['bulk_update_settings_no'] = 'No';
$lang['bulk_update_enable_sso'] = 'Enable SSO';
$lang['bulk_update_enable_mfa'] = 'Enable MFA';
$lang['bulk_update_role'] = 'Role';
$lang['bulk_update_active_status'] = 'Is Active Status';
$lang['bulk_update_is_admin'] = 'Is Administrator';
$lang['bulk_edit_none_selected'] = 'Please edit at least one field.';
$lang['bulk_edit_toolbar_edit_selected'] = 'Edit selected';
$lang['bulk_edit_toolbar_edit_all'] = 'Edit all in view';
$lang['bulk_edit_toolbar_edit_selected_tooltip'] = 'Edit all selected users.';
$lang['bulk_edit_toolbar_edit_all_tooltip'] = 'Edit all users in current view.';
$lang['bulk_edit_no_user_selected'] = 'Please select at least one user.';
$lang['bulk_edit_groups'] = 'Groups';
$lang['bulk_edit_various'] = '[various]';
$lang['bulk_edit_all'] = 'All';
$lang['bulk_edit_none'] = 'None';
$lang['bulk_edit_select'] = 'Select';
$lang['burndown_chart_effort'] = 'Remaining Effort';
$lang['burndown_chart_effort_desc'] = '{0}% of effort completed.';
$lang['burndown_chart_effort_na'] = 'Forecast not available.';
$lang['burndown_chart_tests'] = 'Remaining Tests';
$lang['burndown_chart_tests_desc'] = '{0}% of tests completed.';
$lang['burndown_chart_burndown'] = 'Ideal Progress';
$lang['burndown_chart_burndown_desc'] = '{0} {0?{days}:{day}} to go (forecast).';
$lang['burndown_chart_burndown_na'] = 'Forecast not available.';
$lang['burndown_chart_legend'] = 'Since {0}:';
$lang['burndown_chart_series_burndown'] = 'Burndown';
$lang['burndown_chart_series_burndown_hour'] = 'hour';
$lang['burndown_chart_series_burndown_hours'] = 'hours';
$lang['burndown_chart_series_forecasts'] = 'Forecasts';
$lang['burndown_chart_series_tests'] = 'Tests';

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

$lang['charts_timeframe_title'] = 'Select Time Frame';
$lang['charts_timeframe_field'] = 'Time Frame';
$lang['charts__drilldown_info'] = 'No drilldown capabilities for this chart';
$lang['charts_download_as_image'] = 'Download chart as an image';
$lang['charts_download_as_csv'] = 'Download chart as a CSV';
$lang['charts_timeframe_desc'] = 'Select a different time frame for the chart.';
$lang['charts_timeframe_days_7'] = '7 days';
$lang['charts_timeframe_days_14'] = '14 days';
$lang['charts_timeframe_days_30'] = '30 days';
$lang['charts_timeframe_days_60'] = '60 days';
$lang['charts_timeframe_days_90'] = '90 days';

$lang['columns_namespace'] = 'Column Namespace';
$lang['columns_key'] = 'Column Key';
$lang['columns_name'] = 'Column Name';
$lang['columns_config'] = 'Column Configuration';
$lang['columns_group_by'] = 'Group By';
$lang['columns_group_order'] = 'Group Order';
$lang['columns_group_id'] = 'Group ID';
$lang['columns_display_deleted_cases'] = 'Display Deleted Test Cases';
$lang['columns_group_only'] = 'Group Only';
$lang['columns_save'] = 'Save Columns';

$lang['columns_width_required'] = 'Field Width is a required field.';
$lang['columns_width_min_max'] = 'Field Width must be between 25 and 1000.';

$lang['columns_error_invalid'] = 'Invalid column definition submitted. Please refresh this page.';
$lang['columns_error_invalid_column'] = 'Invalid or unknown column definition submitted.';

$lang['columns_select_title'] = 'Select Columns';
$lang['columns_select_title_small'] = 'Select columns';
$lang['columns_select_title_short'] = 'Columns';
$lang['columns_select_update'] = 'Update Columns';
$lang['columns_select_add'] = 'Add Column';

$lang['columns_add_title'] = 'Add Column';
$lang['columns_add_button'] = 'Add Column';
$lang['columns_add_column'] = 'Column';
$lang['columns_add_column_variable'] = 'This column uses a dynamic width.';
$lang['columns_add_column_desc'] = 'Select the column to add to the tables.';

$lang['columns_group_null'] = 'None';
$lang['configs_select'] = 'Select Configurations';
$lang['configs_select_select'] = 'Select';
$lang['configs_select_configs'] = 'Configurations';
$lang['configs_select_desc'] = 'Select the configurations for your test suite.';

$lang['configs_error_exists'] = 'The specified configuration or configuration group does not exist or you do not have the permission to access it.';

$lang['configs_select_addgroup'] = 'Add Group';

$lang['configs_confirm_delete'] = 'Really delete this configuration? Note that this configuration will be deleted for the entire project.';
$lang['configs_confirm_deletegroup'] = 'Really delete these configurations? Note that this configuration group will be deleted for the entire project.';

$lang['configs_config'] = 'Configuration';
$lang['configs_group'] = 'Configuration Group';
$lang['configs_name'] = 'Name';
$lang['configs_name_desc'] = 'Ex: <em>Windows 10</em>, <em>iOS 8</em> or <em>Firefox</em>';
$lang['configs_name_desc_group'] = 'Ex: <em>Operating Systems</em> or <em>Web Browsers</em>';
$lang['configs_name_required'] = 'The Name field is required.';

$lang['configs_dialog_addconfig'] = 'Add Configuration';
$lang['configs_dialog_editconfig'] = 'Edit Configuration';
$lang['configs_dialog_addgroup'] = 'Add Configuration Group';
$lang['configs_dialog_editgroup'] = 'Edit Configuration Group';

$lang['configs_actions_addconfig'] = 'Add Configuration';
$lang['configs_actions_editconfig'] = 'Save Configuration';
$lang['configs_actions_addgroup'] = 'Add Group';
$lang['configs_actions_editgroup'] = 'Save Group';

$lang['configs_denied_add'] = 'You are not allowed to add configurations or configuration groups (insufficient permissions).';
$lang['configs_denied_edit'] = 'You are not allowed to edit configurations or configuration groups (insufficient permissions).';
$lang['configs_denied_delete'] = 'You are not allowed to delete configurations or configuration groups (insufficient permissions).';
$lang['dashboard_title'] = 'All Projects';
$lang['dashboard_projects'] = 'Projects';
$lang['dashboard_active'] = 'Active';
$lang['dashboard_completed'] = 'Completed';
$lang['dashboard_no_active'] = 'No active projects available. You can ask an administrator to create new projects.';
$lang['dashboard_no_active_ext'] = 'No active projects available.
<a href="{0}" target="_blank">Go to TestRail</a> to add a project.';
$lang['dashboard_no_active_admin'] = 'No active projects available. You can <a href="{0}">create new projects</a> in the admin area.';

$lang['dashboard_empty_user_title'] = 'There aren\'t any projects, yet.';
$lang['dashboard_empty_user_body'] = 'Welcome! This dashboard usually shows an overview of available projects and recent activity, 
but your TestRail administrator hasn\'t added any projects yet.';
$lang['dashboard_empty_ext_body'] = 'Welcome! This page usually shows an overview of available projects and recent activity, 
but no TestRail projects have been added so far.
<a href="{0}" target="_blank">Go to TestRail</a> to add your first project.';

$lang['dashboard_empty_admin_title'] = 'Add your first project to TestRail';
$lang['dashboard_empty_admin_body'] = 'Welcome!
This dashboard shows an overview of available projects and recent activity, but there aren\'t
any projects yet. This is a good time to add your first project to TestRail:';
$lang['dashboard_empty_admin_expl_title'] = 'New to TestRail?';
$lang['dashboard_empty_admin_expl_body'] = 'To get started, please have
a look at TestRail\'s User Guide.
Reading the <a target="_blank" href="https://www.gurock.com/testrail/docs/user-guide/getting-started">Getting Started</a> tutorial takes just a few minutes.';
$lang['dashboard_empty_user_expl_title'] = 'New to TestRail?';
$lang['dashboard_empty_user_expl_body'] = 'To get started, please have
a look at TestRail\'s User Guide.
Reading the <a target="_blank" href="https://www.gurock.com/testrail/docs/user-guide/getting-started">Getting Started</a> tutorial takes just a few minutes.';

$lang['dashboard_actions_legend'] = 'Most active ({0} days):';
$lang['dashboard_actions_legend_timeframe'] = 'Most active (<a {1} class="link link-tooltip" tooltip-text="Change the time frame for the chart.">{0} days</a>):';
$lang['dashboard_actions_description'] = '{0} recent test changes.';

$lang['dashboard_sidebar_todos'] = 'Todos';
$lang['dashboard_sidebar_todos_desc'] = 'Projects with open tests assigned to you:';
$lang['dashboard_sidebar_todos_empty'] = 'None.';
$lang['dashboard_sidebar_projects'] = 'Projects';
$lang['dashboard_sidebar_projects_stats'] = '<strong class="text-softer">{0}</strong> active and <strong class="text-softer">{1}</strong> completed projects.';

$lang['dashboard_description'] = 'Contains <strong>{0}</strong> {0?{test suites}:{test suite}},
	<strong>{1}</strong> active {1?{test runs}:{test run}} and
	<strong>{2}</strong> active {2?{milestones}:{milestone}}.';
$lang['dashboard_description_master'] = 'Contains <strong>{0}</strong> active {0?{test runs}:{test run}} and
	<strong>{1}</strong> active {1?{milestones}:{milestone}}.';
$lang['dashboard_description_short'] = '<strong>{0}</strong> <a class="link" href="{3}">{0?{suites}:{suite}}</a>,
	<strong>{1}</strong> <a class="link" href="{4}">{1?{runs}:{run}}</a> and <strong>{2}</strong> <a class="link" href="{5}">{2?{milestones}:{milestone}}</a>';
$lang['dashboard_description_short_ext'] = '<strong>{0}</strong> <a target="_blank" class="link" href="{3}">{0?{suites}:{suite}}</a>,
	<strong>{1}</strong> <a target="_blank" class="link" href="{4}">{1?{runs}:{run}}</a> and <strong>{2}</strong> <a target="_blank" class="link" href="{5}">{2?{milestones}:{milestone}}</a>';
$lang['dashboard_description_short_master'] = '<strong>{0}</strong> <a class="link" href="{2}">{0?{runs}:{run}}</a> and <strong>{1}</strong> <a class="link" href="{3}">{1?{milestones}:{milestone}}</a>';
$lang['dashboard_description_short_master_ext'] = '<strong>{0}</strong> <a target="_blank" class="link" href="{2}">{0?{runs}:{run}}</a> and <strong>{1}</strong> <a target="_blank" class="link" href="{3}">{1?{milestones}:{milestone}}</a>';
$lang['dashboard_description_empty'] = 'This project is empty. Add your first <a href="{0}">test suite</a>.';
$lang['dashboard_description_empty_short'] = 'Add your first <a href="{0}">test suite</a>';

$lang['dashboard_overview_display'] = 'Display';
$lang['dashboard_overview_display_large'] = 'Detail View';
$lang['dashboard_overview_display_large_desc'] = 'Displays the active projects with many details.';
$lang['dashboard_overview_display_small'] = 'Compact View';
$lang['dashboard_overview_display_small_desc'] = 'Displays the active projects as a compact list. Useful if you have many projects.';

$lang['dashboard_jira_title'] = 'Using JIRA?';
$lang['dashboard_jira_info'] = '<a class="link" href="{0}">Integrate TestRail with JIRA</a> and view &amp; push JIRA issues directly from TestRail.';
$lang['dashboard_jira_more'] = 'Learn more';

$lang['dashboard_dpa_success_accepted'] = 'The Data Processing Agreement was submitted successfully.';
$lang['dashboard_dpa_warning'] = '<strong>Your TestRail instance does not have a valid Data Processing Agreement. </strong><a tabindex="-1" target="_blank" href="http://www.gurock.com/about/gdpr/dpa">Read the DPA.</a>';
$lang['dashboard_dpa_confirm'] = '<strong>Data Processing Agreement</strong><p>If you have a business established in the territory of a member state of the European Economic Area or Switzerland or you are otherwise subject to the territorial scope of the General Data Protection Regulation (“GDPR”), then you are eligible to accept the Gurock Data Processing Agreement terms.</p><p>Please <a tabindex="-1" target="_blank" href="http://www.gurock.com/about/gdpr/dpa">read the DPA</a> if you have not already done so. When you enter your full name and click submit, we will keep on record that you have entered the Data Processing Agreement with us. By doing so, you confirm that you have the authority by your employer to sign this agreement and agree to the terms and conditions of this agreement.</p><p>You can download a copy of the Data Processing Agreement <a target="_blank" href="http://www.gurock.com/about/gdpr/signdpa">here</a>.</p>';
$lang['dashboard_dpa_checkbox'] = 'By checking this box you confirm that you agree to the terms of the Data Processing Agreement on behalf of the Data Controller, and confirm that you have read and understood the terms and that you have the full legal authority to agree to the Data Processing Agreement on behalf of the Data Controller.';
$lang['dashboard_dpa_title'] =  'Important';

$lang['defects_plugin'] = 'Defect Plugin';
$lang['defects_plugin_no_plugin'] = 'No defect plugin configured for this installation.';
$lang['defects_plugin_no_push'] = 'Push not supported for defect plugin "{0}".';
$lang['defects_plugin_no_lookup'] = 'Lookup not supported for defect plugin "{0}".';
$lang['defects_plugin_invalid_config'] = 'Invalid configuration for defect plugin "{0}": {1}.';
$lang['defects_plugin_tests_different_projects'] = 'The tests are from different projects which is not supported.';
$lang['defects_plugin_field_invalid_name'] = 'Form field "{0}" uses invalid characters
(only a-z (lower case) and underscore are supported).';
$lang['defects_plugin_field_no_type'] = 'Form field "{0}" does not specify a field type.';
$lang['defects_plugin_field_no_label'] = 'Form field "{0}" does not specify a field label.';
$lang['defects_plugin_error'] = 'Plugin "{0}" returned an error: {1}';

$lang['defects_dialog_title'] = 'Push Defect';
$lang['defects_dialog_field'] = 'Field';

$lang['defects_plugin_lookup_no_id'] = 'ID missing for defect result of defect plugin "{0}".';
$lang['defects_plugin_lookup_no_title'] = 'Title missing for defect result of defect plugin "{0}".';
$lang['defects_plugin_lookup_no_status_id'] = 'Status ID missing for defect result of defect plugin "{0}".';
$lang['defects_plugin_lookup_no_status'] = 'Status missing for defect result of defect plugin "{0}".';

$lang['defects_na'] = 'Defect not found or integration not configured';
$lang['defects_na_why'] = 'why?';
$lang['defects_notconfigured'] = 'Title not available (lookup not configured, 
<a href="https://www.gurock.com/testrail/docs/integrate/defects/plugins" target="_blank">learn more</a>)';
$lang['defects_chart_legend'] = 'Tests and defects:';
$lang['defects_chart_tests'] = 'Tests';
$lang['defects_chart_tests_desc'] = '{0} {0?{tests}:{test}} started.';
$lang['defects_chart_changes'] = 'Results';
$lang['defects_chart_changes_desc'] = '{0} test {0?{results}:{result}} added.';
$lang['defects_chart_defect'] = 'Defect';
$lang['defects_chart_defects'] = 'Defects';
$lang['defects_chart_defects_desc'] = '{0} {0?{defects}:{defect}} logged.';

$lang['defect_entity'] = 'Entity ID';
$lang['defects_id'] = 'Defect ID';
$lang['defects_ids'] = 'Defect IDs';

$lang['defects_menu_title'] = 'Defects';
$lang['defects_menu_push'] = 'Push New Defect';
$lang['defects_menu_add'] = 'Add Defect';
$lang['defects_menu_assembla'] = 'Assembla';

$lang['defects_page'] = 'Defect Page';
$lang['defects_push_success'] = 'You have pushed a new defect. Defect ID : <a target="_blank" href="{0}">{1}</a>';
$lang['defects_push_success_email'] = 'You have successfully pushed a new defect.';

$lang['integration_plugin_lookup_error'] = 'An Error Occurred';
$lang['integration_plugin_unknown'] = 'Unknown or invalid integration plugin "{0}".';
$lang['integration_plugin_no_class'] = 'Implementation class missing for integration plugin "{0}".';
$lang['integration_plugin_no_variable'] = 'User variable "{0}" has no value for the integration plugin configuration. Please enter a value under My Settings.';

$lang['dump_file_open_error'] = 'Could not open dump file: {0}';
$lang['dump_schema_na'] = 'Schema file not found: {0}';
$lang['dump_schema_copy_error'] = 'Could not copy schema file: {0}';
$lang['editor_add_table'] = 'Add Table';
$lang['editor_add_table_intro'] = 'Design your table template below and configure your columns and rows.';
$lang['editor_add_table_left'] = 'Left';
$lang['editor_add_table_center'] = 'Center';
$lang['editor_add_table_right'] = 'Right';
$lang['email_data_storage_policy_hyperlink'] = '<a href="https://www.ideracorp.com/Legal/Gurock/DataStoragePolicy">Data Storage Policy</a>';
$lang['email_no_server'] = 'There is no SMTP server configured for sending email.';

$lang['email_forgotpassword_subject'] = '[%{installation_name}] Resetting your TestRail password';
$lang['email_forgotpassword_body'] = 'Dear %{name},

You (or somebody else) requested to reset the password for your TestRail
user account. If you don\'t want to reset the password, you can simply
ignore this email.

To reset your TestRail password, please use this link:

%{url}

Sincerely,
%{installation_name}
Powered by TestRail';
$lang['email_reset_password_subject'] = '[%{installation_name}] Resetting your TestRail password';
$lang['email_reset_password_body'] = 'Dear %{name},

The administrator has reset the password for this account. Please follow the link below to create a new one.

%{url}

Sincerely,
%{installation_name}
Powered by TestRail';

$lang['email_invite_user_subject'] = '[%{installation_name}] A new user account was created for you';
$lang['email_invite_user_body'] = 'Dear %{name},

A new TestRail (test management) user account was created for you.
You can set a new password for your user account on the following
page (and then log in):

%{url}

Enjoy,
%{installation_name}
Powered by TestRail';

$lang['email_notify_test_assignedto_subject'] = '[%{installation_name}] Test %{id} was assigned to you';
$lang['email_notify_test_assignedto_many_subject'] = '[%{installation_name}] %{test_count} tests were assigned to you';

$lang['email_notify_test_status_subject'] = '[%{installation_name}] Test %{id} was set to %{status}';
$lang['email_notify_test_status_many_subject'] = '[%{installation_name}] %{test_count} tests were set to %{status}';

$lang['email_notify_test_unassigned_subject'] = '[%{installation_name}] Test %{id} was unassigned';
$lang['email_notify_test_unassigned_many_subject'] = '[%{installation_name}] %{test_count} tests were unassigned';

$lang['email_notify_test_comment_subject'] = '[%{installation_name}] A comment was added to test %{id}';
$lang['email_notify_test_comment_many_subject'] = '[%{installation_name}] A comment was added to %{test_count} tests';

$lang['email_notify_test_assignedto_header'] = 'Dear %{name},

The test was assigned to you by %{user}.

Test Run:    %{run}
Project:     %{project}
Assigned To: You

';

$lang['email_notify_test_assignedto_many_header'] = 'Dear %{name},

The tests were assigned to you by %{user}.

Test Run:    %{run}
Project:     %{project}
Assigned To: You

';

$lang['email_notify_test_status_header'] = 'Dear %{name},

The test result was added by %{user}.

Test Run:    %{run}
Project:     %{project}
Status:      %{status}

';

$lang['email_notify_test_status_many_header'] = 'Dear %{name},

The test results were added by %{user}.

Test Run:    %{run}
Project:     %{project}
Status:      %{status}

';

$lang['email_notify_test_unassigned_header'] = 'Dear %{name},

The test was set to unassigned by %{user}.

Test Run:    %{run}
Project:     %{project}
Assigned To:

';

$lang['email_notify_test_unassigned_many_header'] = 'Dear %{name},

The tests were set to unassigned by %{user}.

Test Run:    %{run}
Project:     %{project}
Assigned To:

';

$lang['email_notify_test_comment_header'] = 'Dear %{name},

The following comment was added by %{user}:

"%{comment}"

Test Run:    %{run}
Project:     %{project}

';

$lang['email_notify_test_body_intro'] = "Please see below for the affected tests:\n\n";
$lang['email_notify_test_body'] = "%{id}: %{title}\n%{url}\n\n";
$lang['email_test_list'] = "%{test_body} \n";
$lang['email_notify_test_footer'] = 'You can disable email notifications for your account under My Settings:

%{unsubscribe}

Sincerely,
%{installation_name}
Powered by TestRail';

$lang['email_notify_case_assignedto_subject'] = '[%{installation_name}] Test Case(s) assigned to you';

$lang['email_notify_case_status_subject'] = '[%{installation_name}] A user changed the status of one or more Test Cases assigned to you';

$lang['email_notify_case_comment_subject'] = '[%{installation_name}] A user commented on one or more Test Cases assigned to you';

$lang['email_notify_case_comment_header'] = 'Dear %{name},

%{user} commented on one or more test cases assigned to you.

Project:     %{project}

';

$lang['email_notify_case_assignedto_header'] = 'Dear %{name},

One or more test case(s) were assigned to you by %{user}.

Project:     %{project}

';

$lang['email_notify_case_status_header'] = 'Dear %{name},

%{user} changed the status of one or more test cases assigned to you.

Project:     %{project}

';

$lang['email_notify_case_body'] = "%{id}: %{title}\n%{status}\n%{url}\n%{comment}\n\n";
$lang['email_case_list'] = "%{case_body} \n";
$lang['email_notify_case_footer'] = 'You can disable email notifications for your account under My Settings:

%{unsubscribe}

Sincerely,
%{installation_name}
Powered by TestRail';

$lang['email_notify_run_subject'] = '[%{installation_name}] Test run %{id} was assigned to you';
$lang['email_notify_run_body'] = 'Dear %{name},

The following test run was assigned to you by %{user}:

Test Run: %{run}
Project:  %{project}

The test run and its tests can be viewed at:

%{run_url}

Sincerely,
%{installation_name}
Powered by TestRail';

$lang['email_test_subject'] = '[%{installation_name}] Test Email';
$lang['email_test_body'] = 'Hello,

This is an email sent to your email address to test the email settings
of a TestRail installation. Since you are currently reading this email,
it seems everything is working fine with the email settings.

The TestRail installation is available at:

%{url}

Sincerely,
%{installation_name}
Powered by TestRail';

$lang['email_notify_report_link_subject'] = '[%{installation_name}] A new report is available: %{report_name}';
$lang['email_notify_report_link_body'] = 'Hello,

The following report is now available:

%{report_name}
%{report_url}

Sincerely,
%{installation_name}
Powered by TestRail';

$lang['email_notify_report_attachment_subject'] = '[%{installation_name}] A new report is available: %{report_name}';
$lang['email_notify_report_attachment_body'] = 'Hello,

The following TestRail report was sent to you:

%{report_name}

The report is attached to this email, either as a ZIP file, a PDF file, or both.
If the email contains a ZIP file, then after downloading and extracting it,
you can view the report in your web browser by opening the index.html file.

If the email contains a PDF, after downloading it you can open it in your preferred PDF viewer.

Sincerely,
%{installation_name}
Powered by TestRail';

$lang['email_export_completed_subject'] = '[%{installation_name}] scheduled export has been completed';
$lang['email_export_completed_body'] = 'Hello,

The following export is now available:
%{export_name}
%{url_get_export}

Sincerely,
%{installation_name}
Powered by TestRail';

$lang['email_storage_limit_approaching_soft_subject'] = 'TestRail Instance Approaching SOFT Storage Limit';
$lang['email_storage_limit_approaching_soft_body'] = 'Dear Customer,

The TestRail instance [%{hostname}] is approaching the available data storage limit for TestRail Cloud instances per our Data Storage policy of 50GB.
To avoid storage fees assessed on your TestRail Cloud subscription, please monitor the data storage activity for your TestRail instance under Administration > Data Management to ensure your data storage limits remain in compliance.

Refer to our %{email_data_storage_policy_hyperlink} for more information about our storage limits and how you can stay within them.

Please feel free to contact us if you have any questions or need assistance.

Thank you,
Gurock Customer Success
contact@gurock.com
';

$lang['email_storage_limit_approaching_hard_subject'] = 'TestRail Instance Approaching HARD Storage Limit';
$lang['email_storage_limit_approaching_hard_body'] = 'Dear Customer,

The TestRail instance [%{hostname}] is approaching the maximum data storage limit available for TestRail Cloud instances per our Data Storage policy.
If the maximum allowable storage limit is reached, case fields and export capabilities will be limited within TestRail.

Refer to our %{email_data_storage_policy_hyperlink} for more information about our storage limits and how you can stay within them.

Your urgent action is needed.

Thank you,
Gurock Customer Success
contact@gurock.com
';

$lang['email_storage_limit_exceeded_soft_subject'] = 'TestRail Instance Exceeded SOFT Storage Limit';
$lang['email_storage_limit_exceeded_soft_body'] = 'Dear Customer,

The TestRail instance [%{hostname}] has exceeded the available data storage limit for TestRail Cloud instances per our Data Storage policy of 50GB.
To avoid storage fees assessed on your TestRail Cloud subscription, please lower your storage limit as soon as possible within the current billing period. If action is not taken, storage limit fees will be assessed on the first day of the next calendar month.

Refer to our %{email_data_storage_policy_hyperlink} for more information about our storage limits and how you can stay within them.

Please feel free to contact us if you have any questions or need further assistance.

Thank you,
Gurock Customer Success
contact@gurock.com
';

$lang['email_storage_limit_exceeded_hard_enterprise_subject'] = 'TestRail Enterprise Instance Exceeded HARD Storage Limit';
$lang['email_storage_limit_exceeded_hard_enterprise_body'] = 'Dear Customer,

The TestRail instance [%{hostname}] has exceeded the allowable storage limit of 500GB per our Data Storage policy for TestRail Enterprise Cloud. Case fields cannot be added and exports will not be allowed until your instance is back inside the allowable limit for your subscription.

Refer to our %{email_data_storage_policy_hyperlink} for more information about our storage limits and how you can stay within them.

Your urgent action is needed. Please contact us if you have any questions.

Thank you,
Gurock Customer Success
contact@gurock.com
';

$lang['email_storage_limit_exceeded_hard_subject'] = 'TestRail Instance Exceeded HARD Storage Limit';
$lang['email_storage_limit_exceeded_hard_body'] = 'Dear Customer,

The TestRail instance [%{hostname}] has exceeded the maximum data storage limit available for TestRail Cloud instances per our  Data Storage policy.

Refer to our %{email_data_storage_policy_hyperlink} for more information about our storage limits and how you can stay within them.

To continue using TestRail Cloud, please make sure to lower your total data storage under 200gb. Case fields cannot be added and exports will not be allowed until your instance is back inside the allowable limit for your subscription.

Thank you,
Gurock Customer Success
contact@gurock.com
';

$lang['email_export_completed_failure_subject'] = '[%{installation_name}] Export Failed';
$lang['email_export_completed_failure_body'] = 'Hello,

The following export failed:
%{export_name}

The following error was reported: %{error_message}

Please try again or contact support via %{contact_email} if you need further assistance.

Sincerely,
%{installation_name}
Powered by TestRail';

$lang['email_export_completed_success_subject'] = '[%{installation_name}] Export Ready';
$lang['email_export_completed_success_body'] = 'Hello,

The following export is now available:
%{export_name}
%{url_get_export}

Sincerely,
%{installation_name}
Powered by TestRail';

$lang['email_send_quote_subject'] = 'New Enterprise information request';
$lang['email_send_quote_body'] = 'This customer has indicated that they are interested in learning more about TestRail Enterprise.

%{name}
%{email}
%{licence}

Please contact the customer.';

$lang['email_send_otp_subject'] = 'OTP request for Login to Testrail';
$lang['email_send_otp_body'] = 'Hello,

Please use the code below to complete your login to TestRail.

<span style="font-size: 35px;color: #2c952c"><b>%{otp}</b></span>

This code will expire in 30 minutes.

If you haven\'t asked for a verification code, change your password 
immediately from your TestRail account settings.

If you have any questions about the security of your account,
Please <a href="https://www.gurock.com/testrail/about/contact">contact us</a>

Thanks for using TestRail ';

$lang['email_error'] = "Sending the test email failed. Please see the following messages and server output for details: \n\n There is no SMTP server configured for sending email.";
$lang['email_notify_webhook_created_subject'] = 'A new webhook was created %{date}';
$lang['email_notify_webhook_created_body'] = 'Hello,

A new webhook has been created in your TestRail instance. Details are below:

Name: %{webhook_name}
Payload URL: %{webhook_payload_url}
Subscribed Events: %{webhook_events}
Subscribed Projects: %{webhook_projects}
Active: %{webhook_active}
More details: %{webhook_url}

Sincerely,
%{installation_name}
Powered by TestRail';
$lang['email_notify_webhook_updated_subject'] = 'A webhook was modified %{date}';
$lang['email_notify_webhook_updated_body'] = 'Hello,

A webhook has been modified in your TestRail instance. Details are below:

Name: %{webhook_name}
Changes: %{webhook_changes}
More details: %{webhook_url}

Sincerely,
%{installation_name}
Powered by TestRail';
$lang['email_notify_webhook_disabled_subject'] = 'A webhook was disabled %{date}';
$lang['email_notify_webhook_disabled_body'] = 'Hello,

A webhook has been disabled in your TestRail instance. Details are below:

Name: %{webhook_name}
Disabled Reason: %{webhook_disabled_reason}
More details: %{webhook_url}

Sincerely,
%{installation_name}
Powered by TestRail';
$lang['email_notify_webhook_deleted_subject'] = 'A webhook was deleted %{date}';
$lang['email_notify_webhook_deleted_body'] = 'Hello,

A webhook was deleted in your TestRail instance. Details are below:

Name: %{webhook_name}

Sincerely,
%{installation_name}
Powered by TestRail';
$lang['email_notify_webhook_response_received_subject'] = 'A %{webhook_response_code} response was received for your webhook %{date}';
$lang['email_notify_webhook_response_received_body'] = 'Hello,

A %{webhook_response_code} response was received for your webhook. Details are below:

Name: %{webhook_name}
Payload URL: %{webhook_payload_url}
Response Code: %{webhook_response_code}
Response Message: %{webhook_response_message}
More details: %{webhook_url}

%{webhook_response_email_body}

Sincerely,
%{installation_name}
Powered by TestRail';
$lang['email_notify_webhook_disabled_reason_too_many_attempts'] = 'Webhook did not respond successfully after 3 attempts. Response code: {0}. Response body: {1}';

$lang['error_headline'] = 'If you believe this is an error that shouldn\'t happen,
please send this error report to Gurock Software. You can optionally enter your
email address below and a Gurock Software support engineer will contact you
shortly.';

$lang['export_csv_column_steps_step'] = '{0} (Step)';
$lang['export_csv_column_steps_expected'] = '{0} (Expected Result)';
$lang['export_csv_column_steps_additional_info'] = '{0} (Additional Info)';
$lang['export_csv_column_steps_refs'] = '{0} (References)';
$lang['export_csv_column_steps_shared_step_id'] = '{0} (Shared step ID)';
$lang['export_csv_column_steps_actual'] = '{0} (Actual Result)';
$lang['export_csv_column_steps_status'] = '{0} (Status)';

$lang['export_csv_dialog_csv'] = 'Export to CSV';
$lang['export_csv_dialog_excel'] = 'Export to Excel';
$lang['export_csv_dialog_short'] = 'Export';
$lang['export_csv_dialog_sections'] = 'Sections';
$lang['export_csv_dialog_sections_empty'] = 'You need to select at least one section (or include all sections).';
$lang['export_csv_dialog_sections_include_all'] = 'Export all sections';
$lang['export_csv_dialog_sections_include_selected'] = 'Export the following sections only:';
$lang['export_csv_dialog_sections_include_selected_desc'] = 'You can select multiple sections by holding Ctrl/Cmd on your keyboard.';
$lang['export_csv_dialog_columns'] = 'Columns';
$lang['export_csv_dialog_columns_empty'] = 'You need to select at least one column to export.';
$lang['export_csv_dialog_layout'] = 'Layout';
$lang['export_csv_dialog_layout_tests'] = 'Export latest results only (one line per test)';
$lang['export_csv_dialog_layout_results'] = 'Export all results and comments (multiple lines per test)';
$lang['export_csv_dialog_separator'] = 'Include separator hint for maximum Excel compatibility';
$lang['export_csv_dialog_separated_steps_new_lines'] = 'Include separated steps on separate rows';

$lang['ext_padding'] = 'Padding';
$lang['ext_margin'] = 'Margin';
$lang['ext_border'] = 'Border';
$lang['ext_border_color'] = 'Border Color';
$lang['ext_border_radius'] = 'Border Radius';
$lang['ext_border_style'] = 'Border Style';

$lang['ext_project_goto'] = 'View in TestRail';
$lang['ext_project_dashboard'] = 'Go to Dashboard';
$lang['ext_project_milestones'] = 'Milestones';
$lang['ext_project_milestones_empty'] = 'No milestones in this project.';
$lang['ext_project_runs'] = 'Test Runs &amp; Plans';
$lang['ext_project_runs_empty'] = 'No test runs or plans in this project.';
$lang['ext_project_reports'] = 'Reports';
$lang['ext_project_reports_empty'] = 'No reports in this project.';
$lang['ext_project_history'] = 'History';

$lang['fields_intro'] = '<strong>Please note:</strong> Don\'t forget to assign this field to your projects below. <a href="https://www.gurock.com/testrail/docs/user-guide/howto/fields" target="_blank">Learn more</a>';
$lang['fields_no_field'] = 'The specified custom field does not exist.';
$lang['fields_no_projects'] = 'Please select at least one project or use the global option.';
$lang['fields_no_context'] = 'Missing custom field context (global or specific projects).';
$lang['fields_no_options'] = 'Missing custom field options (default value, required, etc.).';
$lang['fields_invalid_format'] = 'Invalid encoding format for custom field configuration(s).';
$lang['fields_invalid_options'] = 'Invalid or incomplete options.
Please enter all required fields and check the format of your options.';

$lang['fields_validation_unique'] = 'System Name already in use. Please choose another name for your custom field.';
$lang['fields_validation_invalid_name'] = 'Invalid characters in System Name: please only use a-z (lower case) and underscore characters.';
$lang['fields_validation_projects'] = 'At least one project was assigned more than one option set. Please correct the options and project assignments and try again.';
$lang['fields_validation_projects_invalid'] = 'Invalid project id is passed. Please correct the options and project assignments and try again.';
$lang['fields_validation_templates'] = 'Please select at least one template or use the global option.';
$lang['fields_validation_templates_invalid'] = 'Invalid template id is passed. Please correct the template_ids field and try again.';
$lang['fields_validation_no_type'] = 'Invalid or missing custom field type. Please check the Type field.';
$lang['fields_validation_no_empty_config'] = "Field 'configs' cannot be empty.";
$lang['fields_validation_singleton'] = 'This custom field type can only be added once and there is already a custom field for this type.';
$lang['fields_validation_steps_has_expected'] = 'Invalid has_expected option. Available options is (1, 0, true, false)';
$lang['fields_validation_dropdown_default'] = 'Invalid option value for default_value (available values {1}).';
$lang['fields_validation_checkbox_default'] = 'Invalid default_value option. Available options is (1, 0, true, false).';
$lang['fields_validation_no_default'] = 'Option default_value is not allowed for this type of field.';
$lang['fields_validation_no_empty_ids'] = 'Field \'ids\' cannot be empty.';

$lang['fields_empty'] = 'No fields.';
$lang['fields_entity_id'] = 'Entity';
$lang['fields_field'] = 'Custom Field';
$lang['fields_grid_case'] = 'Case Field';
$lang['fields_grid_test'] = 'Result Field';

$lang['fields_success_add'] = 'Successfully added the new custom field.';
$lang['fields_success_update'] = 'Successfully updated the field.';
$lang['fields_success_delete'] = 'Successfully deleted the custom field (or scheduled for deletion).';
$lang['fields_error_deleting'] = 'This operation is not allowed. This custom field is currently being deleted
or scheduled for deletion.';
$lang['fields_error_installing'] = 'This operation is not allowed. This field is currently being installed
or scheduled for installation.';
$lang['fields_error_not_installing'] = 'This operation is not allowed. This field is not scheduled for installation.';
$lang['fields_error_not_deleting'] = 'This operation is not allowed. This field is not scheduled for deletion.';
$lang['fields_error_system'] = 'This operation is not allowed. This field is a system field.';

$lang['fields_dialog_title'] = 'Configure Options';
$lang['fields_generic_required'] = 'Field :{0} is a required field';
$lang['fields_dialog_required'] = 'This field is a required field';
$lang['fields_dialog_required_desc'] = 'Whether users must enter this field or can leave it empty.';
$lang['fields_dialog_default'] = 'Default Value';
$lang['fields_dialog_default_desc'] = 'The pre-selected/pre-filled value of this field in forms.';
$lang['fields_dialog_global'] = 'These options apply to all projects';
$lang['fields_dialog_global_desc'] = 'The field appears in all projects and has the same options everywhere.';
$lang['fields_dialog_projects'] = 'These options apply to the following projects only';
$lang['fields_dialog_projects_desc'] = 'The field appears in the following projects only.
This allows you to add different field configurations per project.';
$lang['fields_dialog_items'] = 'Items';
$lang['fields_dialog_items_placeholder'] = '1, Option 1';
$lang['fields_dialog_items_desc'] = 'Enter one item per line. Items must have the following format:
<strong>id,name</strong> (id must be a unique number).';
$lang['fields_dialog_textformat'] = 'Text Format';
$lang['fields_dialog_textformat_desc'] = 'The text format of this field.
Choose between plain text or rich-text formats such as Markdown.';
$lang['fields_dialog_tabs_options'] = 'Options';
$lang['fields_dialog_tabs_context'] = 'Selected Projects';
$lang['fields_dialog_rows'] = 'Rows';
$lang['fields_dialog_rows_desc'] = 'This value specifies the initial size of the field when the user loads a form.
The field can be resized by the user as needed.';
$lang['fields_dialog_rows_text_desc'] = 'This value specifies the size of the texts fields (actual step content and expected result).';
$lang['fields_dialog_nooptions'] = 'This field does not have any type-specific options.';
$lang['fields_dialog_steps_expected'] = 'Use a separate Expected Result field for each step';
$lang['fields_dialog_steps_expected_desc'] = 'This adds a second field to each test step to enter your expected results in a more structured way.';
$lang['fields_dialog_results_expected'] = 'Use a separate Expected Result field for each step';
$lang['fields_dialog_results_expected_desc'] = 'This shows the separate expected result field for a step (also needs to be configured for the steps custom field for test cases).';
$lang['fields_dialog_additional_step_information'] = 'Use an extra field for additional step information';
$lang['fields_dialog_additional_step_information_desc'] = 'This adds a field to each test step for additional test step content.';
$lang['fields_dialog_results_additional_information_desc'] = 'Use an extra field for additional step information (also needs to be configured for the steps custom field for test cases).';
$lang['fields_dialog_reference'] = 'Use a References field for each step';
$lang['fields_dialog_reference_desc'] = 'This adds a References field to each test step in order to link to external requirements, user stories, etc. ';
$lang['fields_dialog_results_reference_desc'] = 'This adds a References field to each test step in order to link to external requirements, user stories, etc. (also needs to be configured for the steps custom field for test cases).';
$lang['fields_dialog_results_actual'] = 'Use a separate Actual Result field for each step';
$lang['fields_dialog_results_actual_desc'] = 'This shows a separate text box for each step to record the actual result.';

$lang['fields_checked'] = 'Checked';
$lang['fields_unchecked'] = 'Unchecked';

$lang['fields_add'] = 'Add Field';
$lang['fields_save'] = 'Save Field';
$lang['fields_set_options'] = 'Set options';
$lang['fields_save_options'] = 'Save Options';

$lang['fields_tabs_field'] = 'Custom Field';
$lang['fields_tabs_options'] = 'Project Assignments';

$lang['fields_context_global'] = 'All Projects';
$lang['fields_options_format_plain'] = 'Format: Plain Text';
$lang['fields_options_format_markdown'] = 'Format: Markdown';

$lang['fields_delete_confirm'] = 'Really delete custom field <strong>{0}</strong>? This also fully deletes the data behind this field and cannot be undone.';
$lang['fields_delete_confirm_checkbox'] = 'Yes, delete this custom field (cannot be undone)';
$lang['fields_delete_confirm_extra'] = 'Deleting a field is a high impact and irrevocable action. Please make sure to understand the consequences of this action. You can alternatively also just set the field to inactive instead.';
$lang['fields_delete_config_confirm'] = 'Really delete these options (cannot be undone)? This removes this field from the related projects.';
$lang['fields_change_type_confirm'] = 'You already added some options to this field. These options are removed when you change the field type (because each type has its own set of options). Continue?';

$lang['fields_label'] = 'Label';
$lang['fields_label_api'] = '\'label\'';
$lang['fields_label_desc'] = 'The label of the field as it appears in the user interface.';
$lang['fields_description'] = 'Description';
$lang['fields_description_api'] = '\'description\'';
$lang['fields_description_desc'] = 'The description is shown next to the field, if applicable.';
$lang['fields_include'] = 'Include All';
$lang['fields_include_api'] = '\'include_all\'';
$lang['fields_include_all'] = 'This field applies to all templates';
$lang['fields_include_all_desc'] = 'Select this option to use this field with all cases (of any kind and independently of the template).';
$lang['fields_include_specific'] = 'This field applies to the following templates only';
$lang['fields_include_specific_desc'] = 'You can alternatively select the templates this field should apply to.
This is useful to limit a field to cases of a certain template type.';
$lang['fields_templates'] = 'Templates';
$lang['fields_templates_api'] = '\'template_ids\'';
$lang['fields_name'] = 'System Name';
$lang['fields_name_api'] = '\'name\'';
$lang['fields_name_desc'] = 'The unique name of this field in the database. Should be all lower case, no spaces.
Please note: this name cannot be changed later.';
$lang['fields_type'] = 'Type';
$lang['fields_type_api'] = '\'type\'';
$lang['fields_type_desc'] = 'The type cannot be changed later.
Learn more about
<a class="link" tabindex="-1" target="_blank" href="https://www.gurock.com/testrail/docs/user-guide/howto/fields">field types</a>.';
$lang['fields_configs'] = 'Options';
$lang['fields_configs_api'] = '\'configs\'';
$lang['fields_active'] = 'Active';
$lang['fields_active_desc'] = 'This field is active';
$lang['fields_active_hint'] = 'Disabling a field can be useful to hide it from TestRail\'s
user interface without the need to delete the project assignments or the entire field (including data).';
$lang['fields_system'] = 'Is System';

$lang['fields_options_empty'] = 'No options assigned.';
$lang['fields_options_none'] = 'Not yet assigned to any projects.';
$lang['fields_options_add'] = 'Add Projects &amp; Options';

$lang['fields_options_various'] = '[various]';
$lang['fields_options_various_desc'] = 'The value for this field varies among the current selection.';
$lang['fields_options_notchanged'] = '[not changed]';
$lang['validation_session_timeout'] = 'Field {0} contains an invalid value. Please check for errors and try again.';
$lang['add_case_field_denied'] = 'You are not allowed to add a case field to one or more specified projects (requires administrator privileges).';
$lang['case_fields_templates_denied'] = 'You are not allowed to create test case fields (requires administrator privileges).';

$lang['fields_delete_from_template_confirm'] = 'Really delete custom field <strong>{0}</strong>? This field will be hidden from all test cases which use this template';
$lang['field_ids'] = 'Ids';
$lang['fields_validation_no_empty_config_for_manager'] = 'You must assign the field to at least one project.';
$lang['fields_validation_projects_configuration_failed'] = 'You can add or modify the configuration that contains only assigned projects.';

$lang['filters_values_all'] = 'Any';

$lang['filters_op_is'] = 'Is';
$lang['filters_op_is_not'] = 'Is Not';
$lang['filters_op_is_before'] = 'Is Before';
$lang['filters_op_is_after'] = 'Is After';
$lang['filters_op_is_like'] = 'Contains';
$lang['filters_op_is_not_like'] = 'Doesn\'t Contain';
$lang['filters_op_is_less'] = 'Is Less';
$lang['filters_op_is_more'] = 'Is More';

$lang['filters_daterange_all'] = 'All time';
$lang['filters_daterange_today'] = 'Today';
$lang['filters_daterange_yesterday'] = 'Yesterday';
$lang['filters_daterange_this_week'] = 'This week';
$lang['filters_daterange_7_days'] = 'Last 7 days';
$lang['filters_daterange_last_week'] = 'Last week';
$lang['filters_daterange_14_days'] = 'Last 14 days';
$lang['filters_daterange_this_month'] = 'This month';
$lang['filters_daterange_30_days'] = 'Last 30 days';
$lang['filters_daterange_last_month'] = 'Last month';
$lang['filters_daterange_60_days'] = 'Last 60 days';
$lang['filters_daterange_90_days'] = 'Last 90 days';
$lang['filters_daterange_24_hours'] = 'Last 24 hours';
$lang['filters_daterange_48_hours'] = 'Last 48 hours';
$lang['filters_daterange_custom'] = 'Custom';
$lang['filters_daterange_custom_from'] = 'From:';
$lang['filters_daterange_custom_to'] = 'To:';
$lang['filters_daterange_info_from'] = 'From {0}';
$lang['filters_daterange_info_to'] = 'Until {0}';

$lang['filters_mode_and_asc'] = 'Match only of the above';
$lang['filters_mode_and_desc'] = 'Match only of the following';
$lang['filters_mode_and'] = 'All';
$lang['filters_mode_or_asc'] = 'Match any of the above';
$lang['filters_mode_or_desc'] = 'Match any of the following';
$lang['filters_mode_or'] = 'Any';

$lang['filters_list_operations'] = 'Operations';
$lang['filters_list_datepicker'] = 'Datepicker';

$lang['filters_checkbox_unchecked'] = 'Unchecked';
$lang['filters_checkbox_checked'] = 'Checked';
$lang['filters_bool_true'] = 'Yes';
$lang['filters_bool_false'] = 'No';

$lang['filters_error_invalid'] = 'Invalid filter definition submitted. Please refresh this page.';

$lang['filters_validation_required'] = 'Filter "{0}" has one or more empty values.';
$lang['filters_validation_date'] = 'One or more values of filter "{0}" are not in a valid date format.';
$lang['filters_validation_timespan'] = 'One or more values of filter "{0}" are not in a valid time span format.';
$lang['filters_validation_int'] = 'One or more values of filter "{0}" are not a number.';
$lang['filters_validation_bool'] = 'One or more values of filter "{0}" are not a bool.';

$lang['filters_info_empty'] = '[No filter set]';

$lang['footer_copyright'] = 'Copyright 2008-{0}';
$lang['footer_company'] = 'Gurock Software GmbH';
$lang['footer_rights'] = 'All rights reserved.';

$lang['forms_yes'] = 'Yes';
$lang['forms_no'] = 'No';
$lang['forms_ok'] = 'OK';
$lang['forms_submit'] = 'Submit';
$lang['forms_save'] = 'Save';
$lang['forms_cancel'] = 'Cancel';
$lang['forms_close'] = 'Close';
$lang['forms_next'] = 'Next';
$lang['forms_prev'] = 'Previous';
$lang['forms_delete'] = 'Delete';
$lang['forms_use_default'] = 'Use application default';
$lang['forms_confirm_leave'] = 'You have changed one or more fields in this form. Are you sure you want to navigate away from this page? You would lose all changes you have made.';

$lang['goals_title'] = 'Getting Started with TestRail: 6 Easy Steps';
$lang['goals_project'] = 'Create a project';
$lang['goals_cases'] = 'Add cases';
$lang['goals_run'] = 'Start a run';
$lang['goals_results'] = 'Add results';
$lang['goals_users'] = 'Invite users';
$lang['goals_integration'] = 'Set up integration';

$lang['goals_help_project_title'] = 'Create a Project';
$lang['goals_help_project_intro'] = 'Welcome! Start by creating your first project. Projects in TestRail usually represent a product or software project and serve as organizational unit for cases, results and milestones. You can create as many projects as you like.';
$lang['goals_help_cases_title'] = 'Add Test Cases';
$lang['goals_help_cases_intro'] = 'Test cases represent a certain feature, behavior or functionality you wish to test. They often contain a description, a list of steps and expected results. Cases are organized in sections to make it easy to group related cases together.';
$lang['goals_help_run_title'] = 'Start a Test Run';
$lang['goals_help_run_intro'] = 'To execute tests and enter results for your cases, you start a test run. You can have multiple test runs over time and reuse your test cases across runs. A test run has a status and you can easily follow its progress and test activity.';
$lang['goals_help_results_title'] = 'Add Test Results';
$lang['goals_help_results_intro'] = 'Once you\'ve added a test run, you can start testing and record results. A result has a status such as <em>Passed</em> or <em>Failed</em> and the statuses are signaled by different colors. Adding results contributes to the overall status and progress of the test run.';
$lang['goals_help_users_title'] = 'Invite Team Members';
$lang['goals_help_users_intro'] = 'TestRail is especially useful when used with a team. Invite other team members and build your test case repository, assign test runs and record results together. Easily track the workload and progress from the Todo tab for your entire team.';
$lang['goals_help_users_disable'] = 'I don\'t plan to invite other users for now';
$lang['goals_help_integration_title'] = 'Set up Integration';
$lang['goals_help_integration_intro'] = 'Integrate TestRail with your existing tools such as issue or bug trackers (such as JIRA), requirement management tools, wiki software and many more. Collaborate with your dev team, run traceability reports and link cases &amp; results to issues and defects.';
$lang['goals_help_integration_intro'] = 'Integrate TestRail with your issue/bug tracker (such as JIRA, Redmine &amp; more), requirement tool and test automation. Start by configuring your issue integration to collaborate with your dev team, run coverage reports and link issues to results.';
$lang['goals_help_integration_disable'] = 'I don\'t plan to integrate TestRail with other tools for now';

$lang['groups_group'] = 'Group';
$lang['groups_name'] = 'Name';
$lang['groups_name_desc'] = 'Ex: <em>QA London</em>, <em>In-house</em> or <em>Client A</em>';
$lang['groups_users'] = 'Users';
$lang['groups_users_desc'] = 'Please select the users that should be part of this group.';
$lang['groups_empty'] = 'No user groups.';

$lang['groups_add'] = 'Add Group';
$lang['groups_save'] = 'Save Group';
$lang['groups_success_add'] = 'Successfully added the new user group.';
$lang['groups_success_update'] = 'Successfully updated the user group.';
$lang['groups_success_delete'] = 'Successfully deleted the user group.';

$lang['groups_delete_confirm'] = 'Really delete user group <strong>{0}</strong>? This also unlinks this group from all group members and cannot be undone <em>(no users are deleted)</em>.';
$lang['groups_delete_confirm_checkbox'] = 'Yes, delete this group (cannot be undone)';

$lang['groups_denied_access'] = 'You are not allowed to access user groups (requires administrator privileges).';

$lang['groupd_add_denied_access'] = 'You are not allowed to add user groups (requires administrator privileges).';
$lang['help_menu_guide'] = 'TestRail User Guide';
$lang['help_menu_forums'] = 'Community Forum';
$lang['help_menu_newsletter'] = 'Subscribe to Newsletter';
$lang['help_menu_newsletter_desc'] = 'Subscribe to Gurock\'s newsletter to receive TestRail updates in your inbox.';
$lang['help_menu_twitter'] = 'TestRail on Twitter';
$lang['help_menu_twitter_desc'] = 'Follow TestRail on Twitter for relevant TestRail updates.';
$lang['help_menu_blog'] = 'Gurock Blog';
$lang['help_menu_blog_desc'] = 'Learn more about new TestRail versions and features on the Gurock blog.';
$lang['help_menu_support'] = 'Support &amp; Videos';
$lang['help_menu_web'] = 'TestRail on the Web';
$lang['help_menu_about'] = 'About TestRail';
$lang['help_menu_hotkeys'] = 'Keyboard Shortcuts';

$lang['help_about_title'] = 'About TestRail';
$lang['help_about_tagline'] = 'Modern web-based test case<br />management software.';

$lang['help_survey_title'] = 'TestRail Survey';

$lang['help_pages_link'] = 'TestRail Online Help';
$lang['help_pages_title'] = ' - Help';

$lang['help_any_questions'] = 'Got any questions or need help?';
$lang['help_contact_support'] = 'Contact Gurock Software support';

$lang['import_csv_options_import'] = 'Format';
$lang['import_csv_options_file'] = 'File';
$lang['import_csv_options_layout'] = 'Layout';
$lang['import_csv_options_columns'] = 'Columns';
$lang['import_csv_options_values'] = 'Values';

$lang['import_csv_csvfile'] = 'CSV File';
$lang['import_csv_csvfile_required'] = 'Please upload your CSV file you wish to import.';
$lang['import_csv_csvfile_na'] = 'The uploaded CSV file could not be found. Please try to upload the CSV file again.';
$lang['import_csv_csvfile_size'] = 'CSV file exceeds the size limit. Please split your CSV file into multiple smaller files.';
$lang['import_csv_format'] = 'Format';
$lang['import_csv_mapfile'] = 'Configuration File';
$lang['import_csv_mapfile_required'] = 'Please upload a valid import configuration file (.cfg).';
$lang['import_csv_mapfile_na'] = 'The uploaded configuration file could not be found.';
$lang['import_csv_mapfile_size'] = 'Configuration file exceeds the size limit and is ignored.';
$lang['import_csv_mapfile_json'] = 'Configuration file is not a valid TestRail import configuration file.';
$lang['import_csv_mapfile_invalid'] = 'Configuration file invalid: {0}';

$lang['import_csv_importto'] = 'Import To';
$lang['import_csv_importto_na'] = 'Field Import To is not a valid section or may have been deleted.';
$lang['import_csv_encoding'] = 'Encoding';
$lang['import_csv_delimiter'] = 'CSV Delimiter';
$lang['import_csv_start_row'] = 'Start Row';
$lang['import_csv_has_header'] = 'Has Header';
$lang['import_csv_template'] = 'Template';
$lang['import_csv_skip_empty'] = 'Skip Empty';
$lang['import_csv_layout_format'] = 'Layout';
$lang['import_csv_layout_break'] = 'Layout Column';
$lang['import_csv_layout_break_na'] = 'You selected a multi-row layout.
Please also select the column to detect new test cases.';
$lang['import_csv_layout_break_novalue'] = 'You selected a multi-row layout but the column to detect new test cases
is empty for one or more CSV rows (column {0}). Please make sure that this column has a value for the first row
of each test case.';
$lang['import_csv_columns'] = 'Columns';
$lang['import_csv_columns_na'] = 'You need to select at least one TestRail field.';
$lang['import_csv_columns_notitle'] =
	'The Title field is a required field in TestRail and must be mapped to a CSV column.';
$lang['import_csv_columns_maxone'] = 'You can only assign a single CSV column to the TestRail field "{0}".';
$lang['import_csv_values'] = 'Values';
$lang['import_csv_values_removehtml'] = 'Remove HTML';
$lang['import_csv_values_dateformat'] = 'Date Format';
$lang['import_csv_values_dateformat_missing'] = 'Field Date Format is a required field (column {0}).';
$lang['import_csv_values_dateformat_invalid'] = 'Field Date Format is not a valid date format (column {0}).';
$lang['import_csv_values_date_invalid'] = 'A date value does not match the specified date format (column {0}: "{1}").';
$lang['import_csv_values_timespan_invalid'] = 'A timespan value does not match the supported timespan format (column {0}: "{1}").
You can specify hours, minutes and seconds using the following formats: "10h 30m", "5 minutes and 30 seconds" or simply "45s".';
$lang['import_csv_values_mapping'] = 'Mapping';
$lang['import_csv_values_title_missing'] = 'Field Title is a required field for test cases
but a test case in the CSV file (ending at record {0}) does not specify a title.';
$lang['import_csv_values_section_invalid'] = 'Section "{0}" is invalid and could not be imported: {1}';
$lang['import_csv_values_case_invalid'] = 'Test case "{0}" is invalid and could not be imported: {1}';

$lang['import_csv_column_steps_step'] = '{0} (Step)';
$lang['import_csv_column_steps_expected'] = '{0} (Expected Result)';
$lang['import_csv_column_steps_additional_info'] = '{0} (Additional Info)';
$lang['import_csv_column_steps_refs'] = '{0} (References)';
$lang['import_csv_column_steps_shared_step_id'] = '{0} (Shared Step ID)';
$lang['install_page_title'] = 'TestRail Installation Wizard: Step {0}';
$lang['install_title'] = 'TestRail Installation Wizard';
$lang['install_step'] = 'Step {0}/{1}';
$lang['install_button_previous'] = 'Previous';
$lang['install_button_next'] = 'Next';
$lang['install_button_install'] = 'Install';

$lang['install_wizard_step'] = 'Wizard Step';
$lang['install_wizard_direction'] = 'Wizard Direction';

// Welcome page
$lang['install_welcome'] = 'Welcome to the TestRail installation wizard. This wizard will guide you through the installation
and configuration of TestRail. It will help you prepare the TestRail database, configure all required
settings and create your first user account. If any questions come up during the installation, do not
hesitate to contact the <a href="http://www.gurock.com/support/" target="_blank">Gurock Software support</a>.';
$lang['install_license_title'] = 'TestRail License Terms';
$lang['install_license_description'] = 'Please read and accept the TestRail license terms before continuing with the installation.';
$lang['install_accept_license_checkbox'] = 'I accept the TestRail license terms';
$lang['install_accept_license'] = 'Accept TestRail License Terms';
$lang['install_accept_license_error'] = 'Please accept the TestRail license terms.';

$lang['install_version_app'] = 'TestRail version';
$lang['install_filecheck'] = 'Checking installation files';

// Database Settings
$lang['install_database_introduction'] = 'Please create a
<a target="_blank" href="https://www.gurock.com/testrail/docs/admin/">new empty database</a> and
database account for TestRail and enter the connection details below.';
$lang['install_database_title'] = 'Database Settings';
$lang['install_database_title_result'] = 'Creating Database Schema';

$lang['install_database_exists_error'] = 'A TestRail installation was already found in the
specified database. In case you want to override the TestRail installation, please manually
delete the database tables before you can proceed.<br />
<br />
If you just want to update your TestRail installation to a new version instead, please see
the <a target="_blank" href="https://www.gurock.com/testrail/docs/admin/installation/upgrading">update instructions</a> for details.<br />
<br />
In case you want to switch your trial
installation to a full installation, please just navigate your browser to your trial installation
and enter the license key under Administration &gt; License.';
$lang['install_database_create_table_error'] = 'Could not create a temporary database table.
Please check the database permissions for the specified user: {0}';
$lang['install_database_delete_table_error'] = 'Could not delete a temporary database table.
Please check the database permissions for the specified user: {0}';
$lang['install_database_sqlsrvwarning'] = 'You are installing TestRail on Windows, but the SQL Server PHP extension is not available. Please
<a href="https://www.gurock.com/testrail/docs/admin/howto/installing-sqlsrv" target="_blank">install the extension</a> if you want to connect
to a SQL Server database.';
$lang['install_database_nodriver'] = 'TestRail requires a MySQL or SQL Server database to operate but your
PHP installation does not provide a supported driver (<code>mysql</code> or <code>sqlsrv</code>). Please see the TestRail
<a href="https://www.gurock.com/testrail/docs/admin/installation/windows" target="_blank">installation guide for Windows</a>
or the
<a href="https://www.gurock.com/testrail/docs/admin/installation/unix" target="_blank">installation guide for Unix/Linux</a>
for more information.';
$lang['install_database_mysql_no_innodb'] = 'InnoDB storage engine not supported or enabled';

// Cassandra Settings
$lang['install_cassandra_introduction'] = 'Please create a
<a target="_blank" href="https://www.gurock.com/testrail/docs/admin/">new empty keyspace</a>
for TestRail and enter the connection details below.';
$lang['install_cassandra_title'] = 'Cassandra Settings';
$lang['install_cassandra_title_result'] = 'Creating Cassandra Schema';

$lang['install_cassandra_exists_error'] = 'A TestRail installation was already found in the
specified keyspace. In case you want to override the TestRail installation, please manually
delete the keyspace tables before you can proceed.<br />
<br />
If you just want to update your TestRail installation to a new version instead, please see
the <a target="_blank" href="https://www.gurock.com/testrail/docs/admin/installation/upgrading">update instructions</a> for details.<br />
<br />
In case you want to switch your trial
installation to a full installation, please just navigate your browser to your trial installation
and enter the license key under Administration &gt; License.';
$lang['install_cassandra_nodriver'] = 'TestRail requires a Cassandra database to operate but your
PHP installation does not provide a supported driver (<code>cassandra</code>). Please see the TestRail
<a href="https://www.gurock.com/testrail/docs/admin/installation/windows" target="_blank">installation guide for Windows</a>
or the
<a href="https://www.gurock.com/testrail/docs/admin/installation/unix" target="_blank">installation guide for Unix/Linux</a>
for more information.';

// RabbitMQ Settings
$lang['install_rabbitmq_introduction'] = 'Please enter the RabbitMQ connection details below.';
$lang['install_rabbitmq_title'] = 'RabbitMQ Settings';
$lang['install_rabbitmq_title_result'] = 'Saving RabbitMQ Settings';

// Application Settings
$lang['install_application_introduction'] = 'Please enter all required TestRail application settings below.
Where possible, this installation wizard tried to determine default settings.';
$lang['install_application_title'] = 'Application Settings';
$lang['install_application_title_result'] = 'Saving Application Settings';

// Email Settings
$lang['install_email_introduction'] = 'Please enter your email server details below. The server settings are used for
email notifications and for the Forgot Password functionality.';
$lang['install_email_title'] = 'Email Settings';
$lang['install_email_title_result'] = 'Saving Email Settings';

// Administrator User Account
$lang['install_account_introduction'] = 'Create your first user account and enter your TestRail license key below.
You will have the chance to review all your settings on the next wizard page.';
$lang['install_account_title'] = 'Administrator Account';
$lang['install_account_title_result'] = 'Creating Administrator User Account';

// License Key
$lang['install_key_introduction'] = 'Paste your trial or full license key below. If you
haven\'t received a license key when you downloaded the software, please contact the
<a href="http://www.gurock.com/support/" target="_blank">Gurock Software support</a>.';
$lang['install_key_title'] = 'License Key';
$lang['install_key_title_result'] = 'Activating TestRail License Key';

// Review Settings
$lang['install_review_introduction'] = 'Review your settings below and press the Install button
to install TestRail. Please also review the notes on the next wizard page to finalize the installation.';

// Result
$lang['install_dbversion_title_result'] = 'Writing Database Version';
$lang['install_config_title_result'] = 'Writing Configuration File';
$lang['install_config_error'] = 'Couldn\'t write the configuration file';
$lang['install_config_error_template'] = 'Could not open the configuration template: {0}.';
$lang['install_result_introduction'] = 'Please see below for the result of the installation and the required next steps.';
$lang['install_result_install_title'] = 'Installation Result';
$lang['install_result_success'] = 'Success';
$lang['install_result_warning'] = 'Warning';
$lang['install_result_error'] = 'Error';
$lang['install_result_details'] = '(details below)';
$lang['install_result_task_title'] = 'Install TestRail Background Task';
$lang['install_result_task_desc'] = '<p>Some TestRail features such as the email notifications rely
on a background task. You need to activate the TestRail background
task to finalize the installation. To setup the background task,
you need to configure it in the Task Scheduler (Windows) or Cron (Unix/Linux).
Learn more:</p>

<p><strong>&raquo; <a target="_blank" href="https://www.gurock.com/testrail/docs/admin/howto/background-task">Activating the TestRail background task</a></strong></p>';
$lang['install_result_error_desc'] = 'Please return to the previous wizard page to adjust your settings and try the
installation again. If you are unsure on how to solve this problem, please contact
the <a href="http://www.gurock.com/support/" target="_blank">Gurock Software support</a>.
Please make sure to include the full error message in
your support request.';

$lang['install_result_config_warning'] =
'<p class="top">The installation wizard couldn\'t write the TestRail configuration file.
This is not unusual, as the web server often doesn\'t have the permissions
needed to create new files. However, to complete the installation, <strong>you
must create the TestRail config file manually</strong>.</p>

<p>Please copy the following
configuration settings to a file called <strong>config.php</strong> and place it
in the TestRail	installation directory (next to index.php).</p>';
$lang['install_result_config_saveto'] = 'Save this file to: <strong>{0}</strong>';
$lang['install_result_config_na'] = 'Please make sure to create the config.php
file in TestRail\'s installation directory to complete the installation (and ensure that
the web server has read permissions for this file).';

$lang['install_result_login_title'] = 'Log in to TestRail';
$lang['install_result_login_desc'] = 'Congratulations! You have successfully installed and configured TestRail.
You can now log in to TestRail and create your first project, add additional
user accounts and start organizing your software testing efforts.';
$lang['install_result_login_button'] = 'Log in to TestRail';

// Controller
$lang['install_error'] = 'An error occurred ({0}): {1}';
$lang['install_warning'] = 'Warning ({0}): {1}';
$lang['install_error_updatefile'] = 'Couldn\'t open database update file "{0}".';
$lang['install_error_cqlfile'] = 'Couldn\'t open Cassandra update file "{0}".';
$lang['install_error_noqueries'] = 'Update file "{0}" is invalid (no queries defined).';
$lang['install_error_nocqlqueries'] = 'Update file "{0}" is invalid (no CQL queries defined).';
$lang['install_error_queryfailed'] = 'The following database query
failed with the error "{0}": {1}';
$lang['install_error_appsetting'] = 'Couldn\'t write database setting "{0}": {1}';
$lang['jira_addon_edition_na'] = 'Your add-on edition (sdk/connect) is missing from this request.';
$lang['jira_version_addon_na'] = 'Your add-on version token is missing from this request.';
$lang['jira_version_addon_mismatch'] = 'The add-on version ({0}) requested is not supported by your TestRail version.';
$lang['jira_version_jira_na'] = 'Your JIRA version token is missing from this request.';
$lang['jira_version_jira_mismatch'] = 'Your JIRA version ({0}) is not supported by the TestRail integration. Please update to a newer version of JIRA.';

$lang['jira_issue'] = 'Issue Key';
$lang['jira_offset'] = 'Offset';
$lang['jira_panel'] = 'Panel';
$lang['jira_page'] = 'Page';
$lang['jira_tab'] = 'Tab';
$lang['jira_display'] = 'Display Mode';

$lang['jira_issues_addcase'] = 'Add Test Case';
$lang['jira_issues_addcase_intro'] = 'Please choose the TestRail project and suite for the new test case:';
$lang['jira_issues_addcase_empty'] = 'Your TestRail installation doesn\'t have any projects or suites so far
(needed to add test cases). <a href="{0}" target="_blank">Go to TestRail</a> to add a project.';

$lang['jira_issues_references_project'] = 'Project:';
$lang['jira_issues_references_related'] = 'Related:';
$lang['jira_issues_references_empty'] = 'No test cases in TestRail are linked to this issue.';
$lang['jira_issues_runs_empty'] = 'No test runs in TestRail are linked to this issue.';
$lang['jira_issues_add_run'] = 'Add Run';
$lang['jira_runs_intro'] = 'Please choose the TestRail project and suite for the new run';
$lang['jira_issues_addrun_empty'] = 'Your TestRail installation doesn\'t have any projects or suites so far
(needed to add test runs). <a href="{0}" target="_blank">Go to TestRail</a> to add a project.';

$lang['jira_issues_results_by'] = 'By';
$lang['jira_issues_results_project'] = 'Project:';
$lang['jira_issues_results_milestone'] = 'Milestone:';
$lang['jira_issues_results_run'] = 'Test Run:';
$lang['jira_issues_results_completed'] = 'completed';
$lang['jira_issues_results_assignedto'] = 'Assigned To';
$lang['jira_issues_results_assignedto_unassigned'] = 'Nobody';
$lang['jira_issues_results_version'] = 'Version';
$lang['jira_issues_results_elapsed'] = 'Elapsed';
$lang['jira_issues_results_defects'] = 'Defects';
$lang['jira_issues_results_empty'] = 'No test results in TestRail are linked to this issue.';
$lang['jira_issues_results_attachments'] = 'Attachments';
$lang['jira_issues_results_related'] = 'Related Results';
$lang['jira_issues_results_latest'] = '(Latest)';
$lang['jira_issues_results_mode_all'] = 'All Results';
$lang['jira_issues_results_mode_defects'] = 'For Tests';
$lang['jira_issues_results_mode_runs'] = 'For Runs';
$lang['jira_issues_results_mode_references'] = 'For Cases';
$lang['jira_issues_runs_desc_empty'] = 'No Runs are linked to this issue';
$lang['jira_issues_cases_empty'] = 'No cases are linked to this issue';

$lang['jira_auth_title'] = 'Confirm Integration';
$lang['jira_auth_intro'] = 'Please confirm the integration between TestRail and JIRA.
Continue with the integration and generate an integration key?';
$lang['jira_auth_intro_fineprint'] = 'Note that this will revoke any previous integration keys you have generated.';
$lang['jira_auth_generate'] = 'Generate Key';
$lang['jira_auth_token_before'] = 'Successfully generated the following integration key:';
$lang['jira_auth_token_after'] = 'Please enter this key in JIRA as part of the TestRail add-on configuration to finish the integration.';
$lang['jira_auth_noadmin'] = 'You need administrator access to TestRail to generate an integration key.
Please contact your IT or TestRail administrator to finish the integration between JIRA and TestRail.';

$lang['jobs_unknown'] = 'Unknown job "{0}".';
$lang['jobs_no_class'] = 'Implementation class missing for job "{0}".';
$lang['jobs_no_meta'] = 'Meta function missing for job "{0}".';

$lang['jobs_check_for_update_invalid_version'] = 'Returned version uses invalid format: "{0}".';

$lang['jobs_export_mkdir_error'] = 'Could not create directory {0}: {1}';
$lang['jobs_export_chdir_error'] = 'Could not change to export directory {0}: {1}';
$lang['jobs_export_zip_error'] = 'Creating the ZIP failed: {0}';
$lang['jobs_export_tmpdir_invalid'] = 'Invalid temporary directory: {0}';

$lang['jobs_export_readme'] = 
'This is a full database export & backup archive for the TestRail
account at {0}. It contains the SQL files,
uploaded images, attachments and created reports needed to restore
the entire installation to a local server. You can learn more about
restoring the data and installing TestRail on the following website:

https://www.gurock.com/testrail/docs/admin/server/restoring';
$lang['jobs_export_readme_error'] = 'Creating the readme failed: {0}';

$lang['jobs_export_gc_unlink_error'] = 'Could not delete old export: {0}';

$lang['jobs_audit_log_unlink_error'] = 'Could not delete audit log file: {0}';
$lang['layout_warning_js'] = '<strong>Please note</strong>: Javascript is disabled in your web browser. Please enable Javascript, as Javascript is required to use TestRail.';

$lang['layout_admin'] = '(Admin)';
$lang['layout_return'] = '&larr; Return to Dashboard';
$lang['layout_none'] = 'None';
$lang['layout_yes'] = 'Yes';
$lang['layout_no'] = 'No';
$lang['layout_empty'] = 'Empty';
$lang['layout_not_avail'] = 'n/a';

$lang['layout_title_show'] = 'Show: ';
$lang['layout_actions_edit'] = 'Edit';
$lang['layout_actions_start'] = 'Start';
$lang['layout_actions_cancel'] = 'Cancel';
$lang['layout_actions_close'] = 'Close';
$lang['layout_actions_modify'] = 'Modify';
$lang['layout_actions_share'] = 'Share';
$lang['layout_actions_hide'] = 'Hide';
$lang['layout_actions_expand'] = 'Expand';
$lang['layout_actions_collapse'] = 'Collapse';
$lang['layout_actions_add'] = 'Add';
$lang['layout_actions_addedit'] = 'Add/Edit';
$lang['layout_actions_push'] = 'Push';
$lang['layout_actions_rerun'] = 'Rerun';
$lang['layout_actions_next'] = 'Next';
$lang['layout_actions_previous'] = 'Previous';
$lang['layout_actions_update'] = 'Update';
$lang['layout_actions_addimage'] = 'Add Image';
$lang['layout_actions_show'] = 'Show';
$lang['layout_actions_showall'] = 'Show All';
$lang['layout_actions_showprevious'] = 'Show Previous';
$lang['layout_actions_view'] = 'View';
$lang['layout_actions_viewall'] = 'View All';
$lang['layout_actions_showmore'] = 'Show More';
$lang['layout_actions_viewmore'] = 'View More';
$lang['layout_actions_delete'] = 'Delete';
$lang['layout_actions_permanently_delete'] = 'Permanently Delete';
$lang['layout_actions_change'] = 'Change';
$lang['layout_actions_view_runs'] = 'View Tests';
$lang['layout_actions_move'] = 'Move';
$lang['layout_actions_copy'] = 'Copy';
$lang['layout_actions_mass_assignto'] = 'Assign To';
$lang['layout_actions_mass_passed'] = 'Passed';
$lang['layout_actions_mass_failed'] = 'Failed';
$lang['layout_actions_mass_retest'] = 'Retest';
$lang['layout_actions_activity'] = 'Activity';
$lang['layout_actions_print'] = 'Print';
$lang['layout_actions_start_migration'] = 'Start migration';
$lang['layout_actions_check_to_enable'] = 'Check to Enable';
$lang['layout_actions_history'] = 'History';

$lang['layout_toolbar_sortedby'] = 'Sorted by:';
$lang['layout_toolbar_groupedby'] = 'Grouped by:';
$lang['layout_toolbar_filter'] = 'Filter:';

$lang['layout_format'] = 'Format';
$lang['layout_print_outline'] = 'Outline';
$lang['layout_print_details'] = 'Details';
$lang['layout_print_form'] = 'Form';

$lang['layout_grid_active'] = 'Active';
$lang['layout_grid_inactive'] = 'Inactive';
$lang['layout_grid_column'] = 'Column';
$lang['layout_grid_width'] = 'Width';
$lang['layout_grid_default'] = 'Default';
$lang['layout_grid_system'] = 'System';
$lang['layout_grid_custom'] = 'Custom';
$lang['layout_grid_detail'] = 'Detail';
$lang['layout_grid_value'] = 'Value';
$lang['layout_grid_milestone'] = 'Milestone';
$lang['layout_grid_report'] = 'Report';
$lang['layout_grid_dueon'] = 'Due On';
$lang['layout_grid_file'] = 'File';
$lang['layout_grid_size'] = 'Size';
$lang['layout_grid_createdon'] = 'Created On';
$lang['layout_grid_createdby'] = 'Created By';
$lang['layout_grid_creator'] = 'Creator';
$lang['layout_grid_assignee'] = 'Assignee';
$lang['layout_grid_completed'] = 'Completed';
$lang['layout_grid_completedon'] = 'Completed On';
$lang['layout_grid_active'] = 'Active';
$lang['layout_grid_inactive'] = 'Inactive';
$lang['layout_grid_id'] = 'ID';
$lang['layout_grid_test'] = 'Test';
$lang['layout_grid_section'] = 'Section';
$lang['layout_grid_priority'] = 'Priority';
$lang['layout_grid_minimum_priority'] = 'Minimum Priority';
$lang['layout_grid_status'] = 'Status';
$lang['layout_grid_assignedto'] = 'Assigned To';
$lang['layout_grid_configuration'] = 'Configuration';
$lang['layout_grid_cases'] = 'Test Cases';
$lang['layout_grid_execute'] = 'Execute';
$lang['layout_grid_run'] = 'Test Run';
$lang['layout_grid_project'] = 'Project';
$lang['layout_grid_project_and_run'] = 'Project &amp; Test Run';
$lang['layout_grid_role'] = 'Role';
$lang['layout_grid_group'] = 'Group';
$lang['layout_grid_title'] = 'Title';
$lang['layout_grid_estimate'] = 'Estimate';
$lang['layout_grid_type'] = 'Type';
$lang['layout_grid_undecided'] = 'Undecided';
$lang['layout_grid_unassigned'] = 'Unassigned';
$lang['layout_grid_field'] = 'Field';
$lang['layout_grid_label'] = 'Label';
$lang['layout_grid_location'] = 'Location';
$lang['layout_grid_order'] = 'Order';
$lang['layout_grid_projects'] = 'Projects';
$lang['layout_grid_required'] = 'Required';
$lang['layout_grid_options'] = 'Options';
$lang['layout_grid_references'] = 'References';
$lang['layout_grid_plan'] = 'Test Plan';
$lang['layout_grid_user'] = 'User';
$lang['layout_grid_day'] = 'Day';
$lang['layout_grid_month'] = 'Month';
$lang['layout_grid_date'] = 'Date';
$lang['layout_grid_name'] = 'Name';
$lang['layout_grid_abbreviation'] = 'Abbreviation';
$lang['layout_grid_description'] = 'Description';
$lang['layout_grid_run_data'] = 'Description & References';
$lang['layout_grid_suite'] = 'Suite';
$lang['layout_grid_priority'] = 'Priority';

$lang['layout_grid_column_select_hint'] = 'Select and configure table columns.';

$lang['layout_roles_admin'] = 'Admin';
$lang['layout_roles_user'] = 'User';

$lang['layout_general_error'] = 'An error occurred. Please try again.';
$lang['layout_general_ajax_error'] = 'An error occurred during the last operation. Please try again or refresh the current page.';
$lang['layout_general_ajax_error_hosted'] = 'An error occurred during the last operation or your installation is currently in maintenance mode. Please try again or refresh the current page.';
$lang['layout_dialog_error'] = 'Error';
$lang['layout_dialog_confirmation'] = 'Confirmation';

$lang['layout_qpane_na'] = 'No test case selected.';
$lang['layout_qpane_na_desc'] = 'You can select a different group or change the filters.';
$lang['layout_qpane_close'] = 'Close this pane and switch back to the standard view.';
$lang['layout_qpane_cancel'] = 'Cancel editing.';
$lang['layout_qpane_edit'] = 'Edit fields of visible test case.';

$lang['layout_messages_nodue'] = 'No due date';
$lang['layout_messages_starton'] = 'Starts on {0}';
$lang['layout_messages_dueon'] = 'Due on {0}';
$lang['layout_messages_completedon'] = 'Completed on <strong>{0}</strong>';
$lang['layout_messages_createdon'] = 'Created on <strong>{0}</strong>';
$lang['layout_messages_byon'] = 'By {0} on {1}';
$lang['layout_messages_onby'] = '{0} {1}';
$lang['layout_messages_addedby'] = 'Added by {0}';
$lang['layout_messages_testedby'] = 'Tested by {0}';
$lang['layout_messages_markedby'] = 'Marked by {0}';
$lang['layout_messages_assignedto'] = 'Assigned to {0}';
$lang['layout_messages_createdby'] = 'Created by {0}';
$lang['layout_messages_completedby'] = 'Completed by {0}';
$lang['layout_messages_reopenedby'] = 'Reopened by {0}';
$lang['layout_messages_deletedby'] = 'Deleted by {0}';
$lang['layout_messages_closedby'] = 'Closed by {0}';
$lang['layout_messages_forecastedon'] = 'Forecast for {0}';

$lang['layout_tooltips_addimage'] = 'Add an image to this text field.';
$lang['layout_tooltips_addtable'] = 'Add a table to this text field.';
$lang['layout_tooltips_markdownhelp'] = 'Open the editor formatting reference.';

$lang['layout_mime_plain'] = 'Text Document';
$lang['layout_mime_pdf'] = 'PDF Document';
$lang['layout_mime_application'] = 'Application';
$lang['layout_mime_presenter'] = 'Open Office Impress';
$lang['layout_mime_spreadsheet'] = 'Open Office Calc';
$lang['layout_mime_writer'] = 'Open Office Writer';
$lang['layout_mime_word'] = 'Word Document';
$lang['layout_mime_excel'] = 'Excel Document';
$lang['layout_mime_powerpoint'] = 'PowerPoint Document';
$lang['layout_mime_png'] = 'Png Image';
$lang['layout_mime_jpeg'] = 'Jpeg Image';
$lang['layout_mime_gif'] = 'Gif Image';
$lang['layout_mime_tiff'] = 'Tiff Image';
$lang['layout_mime_bmp'] = 'Bitmap Image';
$lang['layout_mime_xml'] = 'Xml Document';
$lang['layout_mime_zip'] = 'Zip Document';
$lang['layout_mime_html'] = 'Html Document';
$lang['layout_mime_smartinspect'] = 'SmartInspect Log File';
$lang['layout_mime_default'] = 'Other File';

$lang['layout_download_pdf'] = 'Download  PDF';
$lang['layout_download_html'] = 'Download HTML';

$lang['layout_export_xml'] = 'Export to XML';
$lang['layout_export_csv'] = 'Export to CSV';
$lang['layout_export_excel'] = 'Export to Excel';
$lang['layout_import_xml'] = 'Import from XML';
$lang['layout_import_csv'] = 'Import from CSV';

$lang['layout_controls_select'] = 'Select';
$lang['layout_controls_select_all'] = 'All';
$lang['layout_controls_select_none'] = 'None';

$lang['link_blog'] = 'http://blog.gurock.com/';
$lang['link_admin_ioncube'] = 'https://www.gurock.com/testrail/docs/admin/howto/installing-ioncube';
$lang['link_integration_defects'] = 'https://www.gurock.com/testrail/docs/integrate/defects/introduction';
$lang['link_integration_defects_plugins'] = 'https://www.gurock.com/testrail/docs/integrate/defects/plugins';
$lang['link_integration_references'] = 'https://www.gurock.com/testrail/docs/integrate/references/introduction';
$lang['link_integration_jira'] = 'https://www.gurock.com/testrail/docs/integrate/tools/jira/introduction';
$lang['link_userguide_start'] = 'https://www.gurock.com/testrail/docs/user-guide/getting-started';
$lang['link_userguide_editor'] = 'https://www.gurock.com/testrail/docs/user-guide/getting-started/editor';
$lang['link_userguide_shortcuts'] = 'https://www.gurock.com/testrail/docs/user-guide/howto/keyboard-shortcuts-hotkeys';
$lang['link_userguide_scheduling_and_forecasting'] = 'https://www.gurock.com/testrail/docs/user-guide/getting-started/tips';
$lang['link_forum'] = 'http://forum.gurock.com/';
$lang['link_start_with_jira'] = 'http://on.gurock.com/startjiraaddon';
$lang['link_twitter_testrail'] = 'http://twitter.com/testrail';
$lang['link_homepage'] = 'http://www.gurock.com/';
$lang['link_version_check'] = 'http://www.gurock.com/customers/testrail/version/check/%version%';
$lang['link_order'] = 'http://www.gurock.com/order?product=testrail';
$lang['link_testrail'] = 'http://www.gurock.com/testrail/';
$lang['link_jira_management'] = 'http://www.gurock.com/testrail/jira-test-management.i.html';
$lang['link_projects'] = 'http://www.gurock.com/testrail/videos/introduction-projects/';
$lang['link_newsletter'] = 'https://secure.gurock.com/customers/testrail/newsletter?email=';
$lang['link_version'] = 'https://secure.gurock.com/customers/testrail/version/get';
$lang['link_help'] = 'http://www.gurock.com/testrail/support';

$lang['link_support'] = 'http://www.gurock.com/support/';
$lang['link_secure_support'] = 'https://secure.gurock.com/customers/support';

$lang['link_support_email'] = 'testrail@gurock.com';
$lang['link_terms_testrail_cloud'] = 'https://www.gurock.com/testrail/terms/testrail-cloud';

$lang['link_enterprise_edition'] = 'https://www.gurock.com/testrail/tour/enterprise-edition';
$lang['link_sales_email'] = 'contact@gurock.com';
$lang['link_gurock_data_storage_policy'] = 'https://www.ideracorp.com/Legal/Gurock/DataStoragePolicy';

$lang['master_priority_donttest'] = 'Don\'t Test';
$lang['master_priority_dont'] = 'Don\'t';
$lang['master_priority_testiftime'] = 'Test If Time';
$lang['master_priority_iftime'] = 'If Time';
$lang['master_priority_musttest'] = 'Must Test';
$lang['master_priority_must'] = 'Must';

$lang['master_test_status_failed'] = 'Failed';
$lang['master_test_status_retest'] = 'Retest';
$lang['master_test_status_blocked'] = 'Blocked';
$lang['master_test_status_untested'] = 'Untested';
$lang['master_test_status_passed'] = 'Passed';

$lang['master_edit_disabled'] = 'Disabled';
$lang['master_edit_value1'] = '1 Minute';
$lang['master_edit_value2'] = '5 Minutes';
$lang['master_edit_value3'] = '15 Minutes';
$lang['master_edit_value4'] = '30 Minutes';
$lang['master_edit_value5'] = '2 Hours';
$lang['master_edit_value6'] = '1 Day';
$lang['master_edit_value7'] = '3 Days';
$lang['master_edit_unlimited'] = 'Unlimited';

$lang['master_field_type_string'] = 'String';
$lang['master_field_type_int'] = 'Integer';
$lang['master_field_type_text'] = 'Text';
$lang['master_field_type_url'] = 'Url (Link)';
$lang['master_field_type_checkbox'] = 'Checkbox';
$lang['master_field_type_dropdown'] = 'Dropdown';
$lang['master_field_type_user'] = 'User';
$lang['master_field_type_date'] = 'Date';
$lang['master_field_type_milestone'] = 'Milestone';
$lang['master_field_type_steps'] = 'Steps';
$lang['master_field_type_results'] = 'Step Results';
$lang['master_field_type_multiselect'] = 'Multi-select';

$lang['master_field_status_ready'] = 'Ready';
$lang['master_field_status_ready_desc'] = 'This custom is ready to use.';
$lang['master_field_status_install_scheduled'] = 'Install Scheduled';
$lang['master_field_status_install_scheduled_desc'] = 'This custom field is scheduled for installation.';
$lang['master_field_status_installing'] = 'Installing';
$lang['master_field_status_installing_desc'] = 'This custom field is currently being installed.';
$lang['master_field_status_delete_scheduled'] = 'Delete Scheduled';
$lang['master_field_status_delete_scheduled_desc'] = 'This custom field is scheduled for deletion.';
$lang['master_field_status_deleting'] = 'Deleting';
$lang['master_field_status_deleting_desc'] = 'This custom field is currently being deleted.';

$lang['master_location_top'] = 'Top';
$lang['master_location_bottom'] = 'Bottom';
$lang['master_location_left'] = 'Left';
$lang['master_location_right'] = 'Right';
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

$lang['mysettings_save'] = 'Save Settings';
$lang['mysettings_error_emailinuse'] = 'The Email Address is already in use by another user.';
$lang['mysettings_success_update'] = 'Successfully saved your settings.';

$lang['mysettings_sidebar_width'] = 'Sidebar Width';
$lang['mysettings_qpane_context'] = 'Quick Pane Context';
$lang['mysettings_qpane_active'] = 'Quick Pane Active';
$lang['mysettings_qpane_width'] = 'Quick Pane Width';
$lang['mysettings_goal'] = 'Goal';
$lang['mysettings_goal_checked'] = 'Checked';

$lang['mysettings_invalid_javascript'] =
'The JavaScript of your browser is not working properly and the settings weren\'t saved as a safety measure.
This can be caused by malfunctioning browser plugins or invalid UI scripts that were added to your TestRail installation.
Please contact your TestRail administrator to look into this.';
$lang['mysettings_label_user_access_token'] = 'User Access Token';
$referrerAssemblaIntegrationLink = '<a href="https://www.gurock.com/testrail/docs/integrate/tools/assembla/" target="_blank">Assembla Integration docs page</a>';
$lang['mysettings_description_user_access_token'] = 'This token can be used to configure project level Assembla integration, by calling the token from the integration settings area. Refer to the ' . $referrerAssemblaIntegrationLink . ' for more information.';
$lang['mysettings_label_key'] = 'Key';
$lang['mysettings_description_key'] = 'The key can be used to configure Assembla integration, by calling the key from the integration settings area. Refer to the ' . $referrerAssemblaIntegrationLink . ' for more information.';
$lang['mysettings_label_secret'] = 'Secret';
$lang['mysettings_description_secret'] = 'The secret can be used to configure Assembla integration, by calling the secret from the integration settings area. Refer to the ' . $referrerAssemblaIntegrationLink . ' for more information.';
$lang['notification_invalid_mails'] = 'One or more Email(s) are Invalid.';
$lang['notification_active_template_label'] = 'Active Template';
$lang['notification_inactive_template_label'] = 'Inactive Template';
$lang['notification_email_subject_label'] = 'Subject';
$lang['notification_email_body_label'] = 'Body';
$lang['notification_email_template_label'] = 'Template';
$lang['notification_email_label'] = 'Email';
$lang['notification_message_body_label'] = 'Message Body';
$lang['notification_reset_title'] = 'Email template restoration';
$lang['notification_reset_prompt_title'] = 'Restoring:';
$lang['notification_reset_prompt_desc'] = '<p>You are about to restore this email template to its default configuration. 
            Remember this cannot be undone!</p>
            <p>You’ll be able to <strong>edit it again</strong> anytime you need to.</p>';
$lang['notification_reset_confirm_desc'] = '<p>Done!</p>
            <p>This email template has been restored</br>
                to its default configuration. </p>';
$lang['notification_reset_prompt_button'] = 'Yes, Restore';
$lang['notification_reset_cancel_button'] = 'Cancel';
$lang['notification_reset_close_button'] = 'Close';
$lang['notification_edit_button'] = 'Edit';
$lang['notification_view_button'] = 'View & edit';
$lang['notification_restore_button'] = 'Restore Default';
$lang['notification_send_email_button'] = 'Send Sample Email';
$lang['notification_edit_drag_text'] = 'Drag and drop left or right <strong>dynamic data</strong> to set up your template.';
$lang['notification_template_title'] = 'Activate & deactivate email notifications';
$lang['notification_template_desc'] = 'Drag and drop left and right to set up the email notifications you want recipients to get.';
$lang['notification_template_active_desc'] = 'Drag here the emails you want to be <strong>active</strong>';
$lang['notification_template_inactive_desc'] = 'Drag here the emails you want to be <strong>inactive</strong>';
$lang['notification_template_edit_title'] = 'Edit your email templates';
$lang['notification_template_edit_desc'] = 'Choose the email template you want to customize. Leave it as it is for a default set up. You\'ll be able to recover default version anytime.';
$lang['notification_email_customize_text'] = '<strong>About email customization</strong></br>
            <p>A plain text option will be included in your sending.</p>
            <p>This customization feature is available only for Administrators. Changes here will affect mails sent thorughout this instance.</p>';
$lang['notification_send_mail_title'] = 'Send sample email';
$lang['notification_send_mail_button'] = 'Send';
$lang['notification_sent_confirm_desc'] = 'Sample email sent</br> to specified email(s)!';
$lang['notification_send_mail_desc'] = 'You can test your email customization by sending a sample to one or more users. Just enter email addresses below, <strong>separated by commas.</strong>';
$lang['notification_template_save_title'] = 'Edit Saved!';
$lang['notification_template_save_desc'] = 'Choose another template above to keep on </br>customizing your email alerts.';
$lang['notification_invalid_template_error'] = 'The email template is invalid or does not exist.';
$lang['notification_invalid_email_error'] = 'The email is invalid.';
$lang['notification_template_error'] = 'Subject or Body should not be left blank. Template not saved.';
$lang['notification_template_validation'] = 'Template Subject / Body cannot be blank';

$lang['oauth_instance_title'] = 'Connect to TestRail instance';
$lang['oauth_invalid_instance_url'] = 'Sorry but we can’t find that TestRail instance. Please enter a valid instance name.';
$lang['oauth_invalid_redirect_url'] = 'Invalid Redirect URL';
$lang['oauth_invalid_token'] = 'Your token has been invalid or expired.';
$lang['oauth_expired_token'] = 'Your token has been expired.';
$lang['oauth_invalid_credentials'] = 'Invalid oauth credentials.';
$lang['oauth_invalid_token'] = 'Invalid token.';
$lang['oauth_delete_confirm'] = 'Really want to delete oauth user?';
$lang['oauth_all_delete_confirm'] = 'Really want to delete all oauth users?';
$lang['oauth_success_delete'] = 'Successfully deleted oauth user.';
$lang['oauth_failure_delete'] = 'Invalid parameter.';
$lang['oauth_invalid_client_id'] = 'Invalid oauth client id.';
$lang['oauth_authorize_title'] = 'Assembla wants to use<br>';
$lang['oauth_authorize_tr_account'] = ' TestRail account';
$lang['oauth_authorize_allow_assembla'] = 'This will allow Assembla to';
$lang['oauth_authorize_testing_information'] = '&#9679  &nbsp Read your testing information';
$lang['oauth_authorize_user_information'] = '&#9679  &nbsp Read your user information';
$lang['oauth_btn_authorize_assembla'] = 'Authorize Assembla';
$lang['oauth_btn_cancel'] = 'Cancel';
$lang['oauth_log_in'] = 'Log In';
$lang['oauth_to_your'] = 'to your ';
$lang['oauth_to_auth_your'] = 'your ';
$lang['pages_settings'] = 'My Settings';
$lang['pages_help'] = 'Help';
$lang['pages_feedback_help'] = 'Help &amp; Feedback';
$lang['pages_logout'] = 'Logout';
$lang['pages_login'] = 'Login';
$lang['pages_forgotpassword'] = 'Forgot Password';
$lang['pages_resetpassword'] = 'Reset Password';

$lang['pages_dashboard'] = 'Dashboard';
$lang['pages_dashboard_todos'] = 'Todo';
$lang['pages_dashboard_reports'] = 'Reports';

$lang['pages_projectoverview'] = 'Overview';
$lang['pages_milestones'] = 'Milestones';
$lang['pages_suites'] = 'Test Suites & Cases';
$lang['pages_cases'] = 'Test Cases';
$lang['pages_runs'] = 'Test Runs & Results';
$lang['pages_runs_new'] = 'Add Test Run';
$lang['pages_runs_edit'] = 'Edit Test Run';
$lang['pages_plans_new'] = 'Add Test Plan';
$lang['pages_plans_edit'] = 'Edit Test Plan';
$lang['pages_todos'] = 'Todo';
$lang['pages_search'] = 'Search';
$lang['pages_shared_steps'] = 'Shared Test Steps';

$lang['pages_reports'] = 'Reports';
$lang['pages_reports_new'] = 'Add Report';
$lang['pages_reports_edit'] = 'Edit Report';
$lang['pages_reports_view'] = 'View Report';

$lang['pages_milestones_new'] = 'Add Milestone';
$lang['pages_milestones_edit'] = 'Edit Milestone';
$lang['pages_suites_new'] = 'Add Test Suite';
$lang['pages_suites_edit'] = 'Edit Test Suite';
$lang['pages_cases_new'] = 'Add Test Case';
$lang['pages_cases_edit'] = 'Edit Test Case';
$lang['pages_cases_edit_many'] = 'Edit Test Cases (Selected)';
$lang['pages_cases_edit_all'] = 'Edit Test Cases (All)';
$lang['pages_cases_edit_view'] = 'Edit Test Cases (Current View)';
$lang['pages_cases_view'] = 'View Test Case';
$lang['pages_shared_steps_new'] = 'Add Shared Test Steps';

$lang['pages_admin'] = 'Administration';
$lang['pages_admin_overview'] = 'Overview';
$lang['pages_admin_projects'] = 'Projects';
$lang['pages_admin_projects_new'] = 'Add Project';
$lang['pages_admin_projects_edit'] = 'Edit Project';
$lang['pages_admin_users'] = 'Users & Roles';
$lang['pages_admin_users_new'] = 'Add User';
$lang['pages_admin_users_new_bulk'] = 'Add Multiple Users';
$lang['pages_admin_users_edit'] = 'Edit User';
$lang['pages_admin_users_edit_bulk'] = 'Edit Users';
$lang['pages_admin_groups'] = 'Groups';
$lang['pages_admin_groups_new'] = 'Add Group';
$lang['pages_admin_groups_edit'] = 'Edit Group';
$lang['pages_admin_custom'] = 'Customizations';
$lang['pages_admin_audit'] = 'Auditing';
$lang['pages_admin_fields'] = 'Custom Fields';
$lang['pages_admin_fields_new'] = 'Add Custom Field';
$lang['pages_admin_fields_edit'] = 'Edit Field';
$lang['pages_admin_roles_new'] = 'Add Role';
$lang['pages_admin_roles_edit'] = 'Edit Role';
$lang['pages_admin_templates'] = 'Templates';
$lang['pages_admin_templates_new'] = 'Add Template';
$lang['pages_admin_templates_edit'] = 'Edit Template';
$lang['pages_admin_case_types'] = 'Case Types';
$lang['pages_admin_case_types_new'] = 'Add Case Type';
$lang['pages_admin_case_types_edit'] = 'Edit Case Type';
$lang['pages_admin_priorities'] = 'Priorities';
$lang['pages_admin_priorities_new'] = 'Add Priority';
$lang['pages_admin_priorities_edit'] = 'Edit Priority';
$lang['pages_admin_case_statuses_new'] = 'Add Test Case Status';
$lang['pages_admin_case_statuses_edit'] = 'Edit Test Case Status';
$lang['pages_admin_uiscripts'] = 'UI Scripts';
$lang['pages_admin_uiscripts_new'] = 'Add UI Script';
$lang['pages_admin_uiscripts_edit'] = 'Edit UI Script';
$lang['pages_admin_license'] = 'License';
$lang['pages_admin_subscription'] = 'Subscription';
$lang['pages_admin_data_management'] = 'Data Management';
$lang['pages_admin_settings'] = 'Site Settings';
$lang['pages_admin_log'] = 'System Log';
$lang['pages_admin_integration'] = 'Integration';
$lang['pages_admin_statuses_edit'] = 'Edit Status';

$lang['pages_ext_jira_auth'] = 'JIRA Integration';

$lang['pagination_offset'] = 'Offset';
$lang['pagination_limit'] = 'Limit';
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

$lang['priorities_priority'] = 'Priority';
$lang['priorities_name'] = 'Name';
$lang['priorities_name_desc'] = 'Ex: <em>High</em>, <em>4 - Must Test</em> or <em>Don\'t Test</em>';
$lang['priorities_short_name'] = 'Abbreviation';
$lang['priorities_short_name_desc'] = 'A shorter version of the full name.
Is used to display the priority in grids and tables. Leave empty to use the full name.';

$lang['priorities_isdefault'] = 'This priority is the default priority';
$lang['priorities_isdefault_desc'] = 'The default priority is the pre-selected type for new
cases and the fallback type when you delete other priorities. Only one priority can be selected
as the default.';

$lang['priorities_errors_no_default'] = 'No default priority found.';
$lang['priorities_errors_is_default'] = 'The priority is the default priority and cannot be deleted.';

$lang['priorities_add'] = 'Add Priority';
$lang['priorities_save'] = 'Save Priority';
$lang['priorities_delete_confirm'] = 'Really delete priority <strong>{0}</strong>? Cases with this priority will be assigned the default priority.';
$lang['priorities_delete_confirm_checkbox'] = 'Yes, delete this priority (cannot be undone)';

$lang['priorities_success_add'] = 'Successfully added the new priority.';
$lang['priorities_error_default'] = 'Deleting the default priority is not allowed.';
$lang['priorities_success_update'] = 'Successfully updated the priority.';
$lang['priorities_success_delete'] = 'Successfully deleted the priority.';
$lang['priorities_no_priority'] = 'The specified priority does not exist.';
$lang['product_name'] = 'TestRail';
$lang['product_installation_name'] = 'TestRail QA';

$lang['projects_project'] = 'Project';
$lang['projects_noaccess'] = 'The requested project does not exist or you do not have the permissions to access it.';
$lang['projects_empty'] = 'No projects.';

$lang['projects_denied_add'] = 'You are not allowed to add projects (requires administrator privileges).';
$lang['projects_denied_edit'] = 'You are not allowed to edit projects (requires administrator privileges).';
$lang['projects_denied_delete'] = 'You are not allowed to delete projects (requires administrator privileges).';

$lang['projects_overview_title'] = 'Project Overview';
$lang['projects_overview_activity'] = 'Activity';
$lang['projects_overview_results'] = 'Test Changes';
$lang['projects_overview_history'] = 'History';
$lang['projects_overview_milestones'] = 'Milestones';
$lang['projects_overview_runs'] = 'Test Runs';
$lang['projects_overview_todos'] = 'Todos';
$lang['projects_overview_cases'] = 'Test Cases';
$lang['projects_overview_suites'] = 'Test Suites';
$lang['projects_overview_reports'] = 'Reports';

$lang['projects_overview_tests_empty'] = 'No activity yet.';
$lang['projects_overview_history_empty'] = 'No entries yet.';

$lang['projects_overview_sidebar_actions'] = 'Actions';
$lang['projects_overview_sidebar_actions_desc'] = 'Create a new milestone, test suite or test run.';
$lang['projects_overview_sidebar_actions_desc_noruns'] = 'Create a new milestone or test suite.';
$lang['projects_overview_sidebar_todos'] = 'Todos';
$lang['projects_overview_sidebar_todos_desc'] = 'Test runs with open tests assigned to you.
<a href="{0}">See all todos</a>';
$lang['projects_overview_sidebar_todos_empty'] = 'None.';

$lang['projects_runreport'] = 'Reports';
$lang['projects_reports_defects'] = 'Defects';
$lang['projects_reports_defects_summary'] = 'Summary';
$lang['projects_reports_defects_summary_hint'] = 'Shows a summary of found defects for this project.';
$lang['projects_reports_defects_cases_summary'] = 'Summary for Cases';
$lang['projects_reports_defects_cases_summary_hint'] = 'Shows a summary of found defects per test case &amp; test.';
$lang['projects_reports_defects_references_summary'] = 'Summary for References';
$lang['projects_reports_defects_references_summary_hint'] = 'Shows a summary of found defects for the references (requirements, user stories, etc.) in this project.';

$lang['projects_reports_project'] = 'Project';
$lang['projects_reports_project_summary'] = 'Summary';
$lang['projects_reports_project_summary_hint'] = 'Shows a full summary &amp; overview of this project with milestones &amp; test runs as well as activity and history details.';

$lang['projects_reports_results'] = 'Results';
$lang['projects_reports_results_property_groups'] = 'Property Distribution';
$lang['projects_reports_results_property_groups_hint'] = 'Shows the distribution and groups for a specific test attribute (e.g. priority, type or status) for this project.';
$lang['projects_reports_results_case_coverage'] = 'Comparison for Cases';
$lang['projects_reports_results_case_coverage_hint'] = 'Shows the results for select test runs per test case (result coverage &amp; comparison).';
$lang['projects_reports_results_reference_coverage'] = 'Comparison for References';
$lang['projects_reports_results_reference_coverage_hint'] = 'Shows the results for the references (requirements, user stories, etc.) in this project (result coverage &amp; comparison).';

$lang['projects_reports_users'] = 'Users';
$lang['projects_reports_users_workload_summary'] = 'Workload Summary';
$lang['projects_reports_users_workload_summary_hint'] = 'Shows the workload summary, estimates and forecasts for users in this project.';

$lang['projects_history_milestone'] = 'Milestone';
$lang['projects_history_suite'] = 'Test Suite';
$lang['projects_history_run'] = 'Test Run';
$lang['projects_history_deleted'] = '(deleted)';
$lang['projects_history_completed'] = '(completed)';

$lang['projects_new_suite'] = 'Add Test Suite';
$lang['projects_test_suites'] = 'Test Suites';
$lang['projects_error_exists'] = 'The specified project does not exist or you do not have the permission to access it.';

$lang['project_overview_first_title'] = 'Congratulations! You have created your first project';
$lang['project_overview_first_body'] = 'Now that you have created your first project in TestRail,
you can add your project milestones and create your first test cases. If you are
new to TestRail, it is highly recommended to take a look at TestRail\'s
<a target="_blank" href="https://www.gurock.com/testrail/docs/user-guide/getting-started">user guide and manual</a>.';

$lang['projects_suite_mode'] = 'Suite Mode';
$lang['projects_suite_mode_intro'] = 'A project can use different ways to manage and organize test cases.
A single test suite (repository) is usually the recommended option.
Choose baseline support for complex projects that require multiple test case versions at the same time.';
$lang['projects_suite_mode_single'] = 'Use a single repository for all cases (recommended)';
$lang['projects_suite_mode_single_desc'] = 'A single test suite (repository) is easy to manage and flexible enough for most projects with no or few concurrent versions. You can use sections and subsections to further organize your test cases.';
$lang['projects_suite_mode_single_baseline'] = 'Use a single repository with baseline support';
$lang['projects_suite_mode_single_baseline_desc'] = 'Use a single test suite (repository) with the additional option to create baselines to manage multiple branches of your test cases at the same time. This is ideal if you need to test multiple project versions in parallel.';
$lang['projects_suite_mode_multi'] = 'Use multiple test suites to manage cases';
$lang['projects_suite_mode_multi_desc'] = 'Multiple test suites can be useful to organize your test cases by functional areas and application modules on the test suite level.
This is the traditional mode of TestRail and is automatically used for upgraded projects.';
$lang['projects_suite_mode_cannot_switch'] =
'You have more than one test suite in this project and in order to switch to the single (or single with baseline) suite mode, you can only have one test suite in this project.
<br /><br />
To switch the suite mode, please consolidate all test suites by moving the test cases into a single, combined test suite first.
<br /><br />
<strong>Important:</strong> make sure to consider closing currently active test runs and plans before doing so in order to preserve your current test results
(all active test runs and results will be deleted when you move or delete test cases and suites).';

$lang['project_overview_first_expl_title'] = 'Next recommended steps:';
$lang['project_overview_first_expl_body_started'] = 'Read <a target="_blank" href="https://www.gurock.com/testrail/docs/user-guide/getting-started">Getting Started</a>';
$lang['project_overview_first_expl_body_milestones'] = 'Add <a href="{0}">project milestones</a>';
$lang['project_overview_first_expl_body_suites'] = 'Add <a href="{0}">test suites</a>';
$lang['project_overview_first_expl_body_cases'] = 'Enter <a href="{0}">test cases</a>';
$lang['project_overview_first_expl_body_users'] = 'Add <a href="{0}">additional users</a>';

$lang['projects_goto_overview'] = 'View project overview';
$lang['projects_update_hide'] = 'Hide this message';
$lang['projects_update_version'] = 'Version';
$lang['projects_update_available'] = '<strong>A new version of TestRail is available ({0}).</strong>
You can <a target="_blank" href="{1}">download the new version</a> and update your installation.';
$lang['projects_support_hide'] = 'Hide this message';
$lang['projects_support_expired'] = '<strong>Your TestRail support plan expired on {0}.</strong>
You can <a target="_blank" href="https://secure.gurock.com/customers/portal/licenses/">renew your support plan</a> to receive future TestRail updates and technical support.';

$lang['projects_return_location'] = 'Return Location';
$lang['projects_sidebar_projects'] = 'Projects';
$lang['projects_sidebar_projects_stats'] = 'You are managing <strong class="text-softer">{0}</strong> {0?{projects}:{project}}.';

$lang['projects_new'] = 'Add Project';
$lang['projects_new_example'] = 'Add Example Project';
$lang['projects_add'] = 'Add Project';
$lang['projects_save'] = 'Save Project';

$lang['projects_name'] = 'Name';
$lang['projects_name_desc'] = 'Ex: <em>New Widget</em>, <em>Intranet</em> or <em>Payroll Software</em>';
$lang['projects_example_intro'] = 'Example projects are generated by TestRail and contain sample data
such as test cases, results and milestones. They are a good way to see and use many of
TestRail\'s features and are perfect for evaluation or demonstration purposes.';
$lang['projects_example_placeholder'] = 'Example Project';
$lang['projects_example_na'] = 'Support for example projects is not enabled for this installation.';

$lang['projects_announcement'] = 'Announcement';
$lang['projects_announcement_desc'] = 'You can post an announcement to the project overview page.
This could include links to the project\'s issue tracker or knowledge base, for example.';

$lang['projects_show_announcement'] = 'Show the announcement on the overview page';
$lang['projects_post_announcement'] = 'Show Announcement';
$lang['projects_completed_field'] = 'Is Completed';
$lang['projects_completed'] = 'This project is completed';
$lang['projects_completed_hint'] = '(completed)';
$lang['projects_completed_desc'] = 'Shows the project in the completed project list on the dashboard. This doesn\'t make the project read-only (you can use the Access tab for this). ';
$lang['projects_test_case_approval_enabled'] = 'Enable Test Case Approvals';
$lang['projects_test_case_approval_enabled_desc'] = 'Enables test case statuses and approvals for the project. Test runs which use all test cases will only use test cases with approved statuses. Additional test case status filters will be available when setting test run filters.';

$lang['projects_delete'] = 'Delete Project';
$lang['projects_delete_link'] = 'Delete this project';
$lang['projects_delete_descr'] = 'Deleting a project <strong>cannot be undone</strong>. This also deletes all related test cases and test results.';
$lang['projects_delete_confirm'] = 'Really delete project <strong>{0}</strong>? This also deletes all test cases and results and everything else that is part of this project. This cannot be undone.';
$lang['projects_delete_confirm_extra'] = 'Deleting a project is a high impact and irrevocable action. You can alternatively also just set the project to completed or hide it from the dashboard via project permissions instead.';
$lang['projects_delete_confirm_checkbox'] = 'Yes, delete this project (cannot be undone)';

$lang['projects_success_add'] = 'Successfully added the new project.';
$lang['projects_error_add'] = 'An error occurred while adding the new project.';
$lang['projects_success_update'] = 'Successfully updated the project.';
$lang['projects_error_update'] = 'An error occurred while saving the project.';
$lang['projects_success_delete'] = 'Successfully deleted the project.';
$lang['projects_error_delete'] = 'An error occurred while deleting the project.';
$lang['projects_error_defect_id_url'] = 'The Defect View Url field does not contain the %id% placeholder.';
$lang['projects_error_reference_id_url'] = 'The References View Url field does not contain the %id% placeholder.';

$lang['projects_tabs_project'] = 'Project';
$lang['projects_tabs_access'] = 'Access';
$lang['projects_tabs_suites'] = 'Suites';
$lang['projects_tabs_integration'] = 'Integration';
$lang['projects_tabs_defects'] = 'Defects';
$lang['projects_tabs_references'] = 'References';
$lang['projects_tabs_index'] = 'Tab Index';

$lang['projects_fav_star_hint'] = 'Mark as project favorite.';
$lang['projects_fav_unstar_hint'] = 'Remove from project favorites.';

$lang['projects_defect_id_url'] = 'Defect View Url';
$lang['projects_defect_id_url_desc'] = 'The web address of a case in your defect tracker.
Use %id% as the placeholder for the actual case ID. Leave empty to use the global setting.
<a class="link" target="_blank" tabindex="-1" href="https://www.gurock.com/testrail/docs/integrate/">Learn more</a>';
$lang['projects_defect_add_url'] = 'Defect Add Url';
$lang['projects_defect_add_url_desc'] = 'The web address for adding a new case to your defect tracker.
Leave empty to use the global setting. <a class="link" target="_blank" tabindex="-1"
href="https://www.gurock.com/testrail/docs/integrate/">Learn more</a>';

$lang['projects_defect_plugin'] = 'Defect Plugin';
$lang['projects_defect_plugin_desc'] = 'The plugin for integrating TestRail with your defect tracker.
Leave empty to use the global setting. The plugin can be configured below.
<a class="link" target="_blank" tabindex="-1" href="https://www.gurock.com/testrail/docs/integrate/">Learn more</a>';
$lang['projects_defect_config'] = 'Defect Plugin Configuration';
$lang['projects_defect_config_desc'] = 'Make sure to use HTTPS for a secure connection to your defect tracker.
User variables are recommended to store the user &amp; password securely
(can also be used to customize the login per user).
<a class="link" tabindex="-1" target="_blank" href="https://www.gurock.com/testrail/docs/integrate/">Learn more</a>';
$lang['projects_defect_template'] = 'Defect Plugin Template';
$lang['projects_defect_template_expand'] = '<a {0}>Enter a template</a> for the description field of the defect dialog.';
$lang['projects_defect_template_desc'] = 'The template for the description field of the defect dialog.
You can add various placeholder variables via the Add Field link below.';
$lang['projects_defect_template_add_field'] = 'Add Field';
$lang['projects_defect_template_placeholder'] = 'Status: %tests:status_id% ..';

$lang['projects_reference_id_url'] = 'Reference View Url';
$lang['projects_reference_id_url_desc'] = 'The web address for your case references (requirements or user stories, e.g.).
Use %id% as the placeholder for the actual reference ID. Leave empty to use the global setting.
<a class="link" target="_blank" tabindex="-1" href="https://www.gurock.com/testrail/docs/integrate/">Learn more</a>';
$lang['projects_reference_add_url'] = 'Reference Add Url';
$lang['projects_reference_add_url_desc'] = 'The web address for adding a new reference.
Leave empty to use the global setting. <a class="link" target="_blank" tabindex="-1"
href="https://www.gurock.com/testrail/docs/integrate/">Learn more</a>';
$lang['projects_reference_plugin'] = 'Reference Plugin';
$lang['projects_reference_plugin_desc'] = 'The plugin for integrating TestRail with your requirement, issue
or bug tracker. The plugin can be configured below.
<a class="link" tabindex="-1" target="_blank" href="https://www.gurock.com/testrail/docs/integrate/">Learn more</a>';
$lang['projects_reference_config'] = 'Reference Plugin Configuration';
$lang['projects_reference_config_desc'] = 'Make sure to use HTTPS for a secure connection to your issue or requirement tracker.
User variables are recommended to store the user &amp; password securely
(can also be used to customize the login per user).
<a class="link" tabindex="-1" target="_blank" href="https://www.gurock.com/testrail/docs/integrate/">Learn more</a>';

$lang['projects_user_access'] = 'User Access';
$lang['projects_group_access'] = 'Group Access';
$lang['projects_access'] = 'Default Access';
$lang['projects_access_global'] = 'Global Role';
$lang['projects_access_noaccess'] = 'No Access';
$lang['projects_access_project'] = 'Project Access';
$lang['projects_access_desc'] = 'Specifies the default access for this project.
The default access can be overridden for each user and group below.
<a class="link" tabindex="-1" target="_blank" href="https://www.gurock.com/testrail/docs/user-guide/howto/permissions">Learn more</a>';

$lang['projects_push_defect'] = 'Submit a new defect to your external tool.';
$lang['projects_add_defect'] = 'Go to your external tool to create a new defect.';
$lang['projects_assigned'] = 'Assigned Project';
$lang['manager_not_assigned_projects_edit'] = 'You are not allowed to edit this project.';
$lang['manager_not_assigned_projects_delete'] = 'You are not allowed to delete this project.';

$lang['references_id'] = 'Reference ID';

$lang['references_plugin_no_plugin'] = 'No references plugin configured for this installation.';
$lang['references_plugin_no_lookup'] = 'Lookup not supported for reference plugin "{0}".';
$lang['references_plugin_error'] = 'Plugin "{0}" returned an error: {1}';
$lang['references_plugin_invalid_config'] = 'Invalid configuration for reference plugin "{0}": {1}.';

$lang['references_plugin_lookup_no_id'] = 'ID missing for reference result of reference plugin "{0}".';
$lang['references_plugin_lookup_no_title'] = 'Title missing for reference result of reference plugin "{0}".';
$lang['references_plugin_lookup_no_status_id'] = 'Status ID missing for reference result of reference plugin "{0}".';
$lang['references_plugin_lookup_no_status'] = 'Status missing for reference result of reference plugin "{0}".';

$lang['references_missing_user_token'] = 'User does not have a valid OAuth connection. Please create one under in your My Settings area.';

$lang['report_plugins_header_comment'] = 'Project: {0}<br />By {1}, {2}';
$lang['report_plugins_footer_comment'] = 'Generated with TestRail <a target="_top" href="http://www.gurock.com/testrail/">test management</a> software &ndash; {0}<br />
		Report: {1} ({2}), by {3} (Version {4})';
$lang['report_plugins_footer_comment_no_author'] = 'Unknown';
$lang['report_plugins_footer_comment_no_version'] = 'Unknown';

$lang['report_plugins_cases_limit'] = 'Maximum number of test cases to display:';
$lang['report_plugins_cases_filter'] = 'Apply the following filter for the test cases:';
$lang['report_plugins_cases_filter_change'] = 'change';
$lang['report_plugins_cases_filter_title'] = 'Filter';
$lang['report_plugins_cases_filter_active'] = 'Active';
$lang['report_plugins_cases_filter_upcoming'] = 'Upcoming';
$lang['report_plugins_cases_filter_completed'] = 'Completed';

$lang['report_plugins_tests_limit'] = 'Maximum number of tests to display:';
$lang['report_plugins_tests_filter'] = 'Apply the following filter for the tests:';
$lang['report_plugins_tests_filter_change'] = 'change';
$lang['report_plugins_tests_filter_title'] = 'Filter';
$lang['report_plugins_tests_filter_active'] = 'Active';
$lang['report_plugins_tests_filter_upcoming'] = 'Upcoming';
$lang['report_plugins_tests_filter_completed'] = 'Completed';
$lang['report_plugins_tests_details'] = 'Include the following test details:';
$lang['report_plugins_tests_details_none'] = 'None';
$lang['report_plugins_tests_details_outline'] = 'Only the outline (default table view)';
$lang['report_plugins_tests_details_full'] = 'All details';
$lang['report_plugins_tests_include'] = 'Include the tests and test results in this report';

$lang['report_plugins_limit_all'] = 'All (may be slow)';
$lang['report_plugins_grouping_select'] = 'Group by the following attribute:';

$lang['report_plugins_columns_select_add'] = 'Add Column';
$lang['report_plugins_columns_select_column'] = 'Column';
$lang['report_plugins_columns_select_width'] = 'Width';
$lang['report_plugins_columns_select_intro'] = 'Include the following columns:';
$lang['report_plugins_columns_select_desc'] = 'You can use 0 as width to specify a variable-width column.';
$lang['report_plugins_columns_select_required'] = 'Please select at least one column.';

$lang['report_plugins_suites_select'] = 'Include the following test suites:';
$lang['report_plugins_suites_select_required'] = 'Please select at least one test suite.';
$lang['report_plugins_suites_select_include_all'] = 'All test suites';
$lang['report_plugins_suites_select_include_selected'] = 'The following test suites only:';
$lang['report_plugins_suites_select_selected_desc'] = 'You can select multiple test suites by holding Ctrl/Cmd on your keyboard.';
$lang['report_plugins_suites_select_invalid'] = 'You have selected one or more invalid test suites.';

$lang['report_plugins_sections_select'] = 'Include the following sections:';
$lang['report_plugins_sections_select_required'] = 'Please select at least one section.';
$lang['report_plugins_sections_select_include_all'] = 'All sections';
$lang['report_plugins_sections_select_include_selected'] = 'The following sections only:';
$lang['report_plugins_sections_select_selected_desc'] = 'You can select multiple sections by holding Ctrl/Cmd on your keyboard.';

$lang['report_plugins_users_select'] = 'Include the following users:';
$lang['report_plugins_users_select_required'] = 'Please select at least one user.';
$lang['report_plugins_users_select_include_all'] = 'All users';
$lang['report_plugins_users_select_include_selected'] = 'The following users only:';
$lang['report_plugins_users_select_selected_desc'] = 'You can select multiple users by holding Ctrl/Cmd on your keyboard.';

$lang['report_plugins_runs_limit'] = 'Maximum number of test runs to include (latest first):';
$lang['report_plugins_runs_select_add'] = 'Add Test Runs';
$lang['report_plugins_runs_select_add_empty'] = 'You need to select a test suite before you can add test runs.';
$lang['report_plugins_runs_select_suite'] = 'Please select a test suite:';
$lang['report_plugins_runs_select_include'] = 'Include the test results of:';
$lang['report_plugins_runs_select_include_all'] = 'All test runs';
$lang['report_plugins_runs_select_include_filter'] = 'The test runs that match the following filter (now and in the future):';
$lang['report_plugins_runs_select_include_selected'] = 'Only the following test runs:';
$lang['report_plugins_runs_select_filter_change'] = 'change';
$lang['report_plugins_runs_select_filter'] = 'Filter';
$lang['report_plugins_runs_select_filter_required'] = 'Please configure a filter for the test runs.';
$lang['report_plugins_runs_select_filter_invalid'] = 'You have configured an invalid test run filter.';
$lang['report_plugins_runs_select_ids_required'] = 'Please select at least one test run.';
$lang['report_plugins_runs_select_ids_invalid'] = 'You have selected one or more invalid test runs.';
$lang['report_plugins_runs_select_filter_apply'] = 'Apply Filter';
$lang['report_plugins_runs_select_filter_open'] = 'Open';
$lang['report_plugins_runs_select_filter_active'] = 'Active';
$lang['report_plugins_runs_select_filter_upcoming'] = 'Upcoming';
$lang['report_plugins_runs_select_filter_completed'] = 'Completed';
$lang['report_plugins_runs_select_filter_matches'] = '<strong>{0}</strong> {0?{test runs}:{test run}} found.';
$lang['report_plugins_runs_select_filter_matches_limited'] = '<strong>{0}</strong> {0?{test runs}:{test run}} found ({1} not displayed).';
$lang['report_plugins_runs_select_run'] = 'Test Run';
$lang['report_plugins_runs_select_run_completed'] = '(completed)';
$lang['report_plugins_runs_select_plan'] = 'Test Plan';
$lang['report_plugins_runs_select_milestone'] = 'Milestone';
$lang['report_plugins_runs_select_run_one'] = 'Please select at least one test run.';
$lang['report_plugins_runs_select_run_empty'] = 'There are no (more) test runs for the selected test suite and filtering options.';

$lang['report_plugins_runs_completed'] = '(completed)';
$lang['report_plugins_runs_config'] = 'Configuration';
$lang['report_plugins_runs_milestone'] = 'Milestone';
$lang['report_plugins_runs_plan'] = 'Test Plan';
$lang['report_plugins_runs_tests'] = 'Tests';
$lang['report_plugins_runs_defects'] = 'Defects';
$lang['report_plugins_runs_defects_comment'] = '<strong>{0}</strong> {0?{defects}:{defect}}';
$lang['report_plugins_runs_defects_tests_comment'] = '<strong>{0}</strong> {0?{defects}:{defect}} (<strong>{1}</strong> {1?{tests}:{test}})';

$lang['report_plugins_results_latest'] = 'Latest (Coverage)';
$lang['report_plugins_defects_combined'] = 'Combined';

$lang['report_plugins_statuses_select'] = 'Include the following statuses:';
$lang['report_plugins_statuses_select_required'] = 'Please select at least one status.';
$lang['report_plugins_statuses_select_include_all'] = 'All statuses';
$lang['report_plugins_statuses_select_include_selected'] = 'The following statuses only:';
$lang['report_plugins_statuses_select_selected_desc'] = 'You can select multiple statuses by holding Ctrl/Cmd on your keyboard.';

$lang['report_plugins_results_select'] = 'Include the following results:';
$lang['report_plugins_results_select_include_all'] = 'All test results of the tests';
$lang['report_plugins_results_select_include_latest'] = 'The latest test results per test only (current status)';

$lang['report_plugins_references_select'] = 'Include the following references:';
$lang['report_plugins_references_select_include_all'] = 'All references';
$lang['report_plugins_references_select_include_selected'] = 'The following references only:';
$lang['report_plugins_references_select_selected_desc'] = 'Please enter one reference ID per line.';
$lang['report_plugins_references_select_required'] = 'Please enter at least one reference ID.';

$lang['report_plugins_defects_select'] = 'Include the following defects:';
$lang['report_plugins_defects_select_include_all'] = 'All defects';
$lang['report_plugins_defects_select_include_selected'] = 'The following defects only:';
$lang['report_plugins_defects_select_selected_desc'] = 'Please enter one defect ID per line.';
$lang['report_plugins_defects_select_required'] = 'Please enter at least one defect ID.';

$lang['report_plugins_content_hide_links'] = 'Do not include links in report (useful when sharing reports)';

$lang['report_plugins_charts_comparison_title'] = 'Results per Test Run';
$lang['report_plugins_charts_comparison_title_full'] = 'Latest Results &amp; per Test Run';
$lang['report_plugins_charts_comparison_results_latest'] = 'Latest (Coverage)';

$lang['report_plugins_groupby_others'] = 'Others';

$lang['report_plugins_milestones_select'] = 'Use the following milestone:';
$lang['report_plugins_milestones_select_required'] = 'Please select a milestone.';
$lang['report_plugins_milestones_select_active'] = 'Active';
$lang['report_plugins_milestones_select_upcoming'] = 'Upcoming';
$lang['report_plugins_milestones_select_completed'] = 'Completed';
$lang['report_plugins_milestones_select_invalid'] = 'You have selected an invalid or deleted milestone.';

$lang['report_plugins_plans_select'] = 'Use the following test plan:';
$lang['report_plugins_plans_select_required'] = 'Please select a test plan.';
$lang['report_plugins_plans_select_active'] = 'Open';
$lang['report_plugins_plans_select_completed'] = 'Completed';
$lang['report_plugins_plans_select_invalid'] = 'You have selected an invalid or deleted test plan.';

$lang['report_plugins_activities_limit'] = 'Maximum number of activities to display:';
$lang['report_plugins_activities_include'] = 'Include the activities in this report';
$lang['report_plugins_history_limit'] = 'Maximum number of history items to display:';
$lang['report_plugins_progress_include'] = 'Include the progress in this report';
$lang['report_plugins_dateranges_select'] = 'Use the following time frame:';

$lang['reports_report'] = 'Report';
$lang['reports_loading'] = 'Loading report';
$lang['reports_printing'] = 'Printing report';
$lang['reports_nodir'] = 'No report directory configured.';
$lang['reports_unprocessed'] = 'This report is not yet generated. Please try again later.';
$lang['reports_noaccess'] = 'The requested report does not exist or you do not have the permissions to access it.';
$lang['reports_resource_na'] = 'Report file or resource not found';
$lang['reports_resource_path'] = 'Path';
$lang['reports_ajax_flag'] = 'Path';

$lang['reports_success_delete'] = 'Successfully deleted the reports.';

$lang['reports_run_noproject'] = 'The project for the report no longer exists and the report cannot be generated (project ID: {0}).';
$lang['reports_run_nopath'] = 'Could not create output directory for report: no report directory configured or insufficient permissions ({0}).';
$lang['reports_run_nohtml'] = 'No HTML returned from report: missing \'html\'/\'html_file\' property.';
$lang['reports_run_noindex'] = 'Could not save HTML into index.html file for report: {0}';
$lang['reports_run_nometa'] = 'Could not save meta description file for report: {0}';
$lang['reports_run_noresource'] = 'Resource file not found for report: {0}';
$lang['reports_run_noresource_copy'] = 'Resource file ({0}, format: {1}) could not be copied into output directory for report: {1}';
$lang['reports_run_noattachment'] = 'Attachment file not found for report: {0}';
$lang['reports_run_unknown_format'] = 'Unknown attachment file format';


$lang['reports_overview_shared'] = 'Shared';
$lang['reports_overview_personal'] = 'Private';
$lang['reports_overview_scheduled'] = 'Scheduled';
$lang['reports_overview_on_demand_via_api'] = 'API Templates';
$lang['reports_overview_empty_title'] = 'This project doesn\'t contain any reports, yet.';
$lang['reports_overview_empty_body'] = 'No reports have been added to this project yet. You can create or schedule reports for the templates in the sidebar.';
$lang['reports_overview_empty_title'] = 'This project doesn\'t contain any reports, yet.';
$lang['reports_overview_empty_body'] = 'No reports have been added to this project yet. You can create or schedule reports for the report templates in the sidebar.';
$lang['reports_overview_empty_expl_title'] = 'What\'s a report?';
$lang['reports_overview_empty_expl_body'] = 'A report lets you generate statistics and charts for the data in your TestRail installation.';

$lang['reports_share'] = 'Share Report';
$lang['reports_share_short'] = 'Share';
$lang['reports_share_intro'] = 'You can share this report with other users or external people (with no TestRail access). <br />For larger reports which may not display correctly in a PDF, you have the option of using HTML format instead,<br /> but please note that some email providers will block HTML reports from being sent. <br />As an alternative, please consider splitting the report scope into multiple, smaller, PDF reports.';
$lang['reports_share_success'] = 'Successfully shared the report via email.';
$lang['reports_share_nousers'] = 'Please select at least one user for sharing a link.';
$lang['reports_share_noemails'] = 'Please enter at least one email address.';
$lang['reports_share_noemail'] = 'You have entered an invalid email address as recipient: {0}.';
$lang['reports_share_noshare'] = 'Please select at least one option to share this report.';
$lang['reports_share_email_error'] = 'The following error occured while trying to share the report: {0}';

$lang['reports_status_success'] = 'Success';
$lang['reports_status_error'] = 'Error';

$lang['reports_no_task'] = 'The background task is not installed';
$lang['reports_no_task_desc'] = 'The background task is required to generate reports but the task is not installed. Please ask your TestRail administrator to activate it. <a target="_blank"
				href="https://www.gurock.com/testrail/docs/admin/howto/background-task">Learn more</a>';

$lang['reports_share_hint'] = 'Share Report';
$lang['reports_share_hint_desc'] = 'Opens a dialog to share this report via email.';
$lang['reports_share_hint_simple'] = 'Share this report via email.';
$lang['reports_copy_hint'] = 'Rerun Report';
$lang['reports_copy_hint_desc'] = 'Create or schedule a similar report.';
$lang['reports_delete_hint'] = 'Delete this report.';
$lang['reports_delete_confirm'] = 'Really delete this report? This irrevocably deletes this report for all users and cannot be undone.';
$lang['reports_copy_title'] = 'Create Similar';
$lang['reports_download_hint'] = 'Download Report';
$lang['reports_download_hint_desc'] = 'Download this report as HTML or PDF file.';
$lang['reports_print_title'] = 'Print';
$lang['reports_print_hint'] = 'Print Report';
$lang['reports_print_hint_desc'] = 'Opens a printer-friendly version of this report.';
$lang['reports_share_title'] = 'Share';

$lang['reports_job'] = 'Report Job';
$lang['reports_jobs_create'] = 'Create Report';
$lang['reports_jobs_create_intro'] = 'You can create or schedule reports for the following report templates:';
$lang['reports_jobs_add_hint'] = 'Create or schedule a new report for this template.';
$lang['reports_jobs_edit_hint'] = 'Edit this scheduled report.';
$lang['reports_jobs_copy_hint'] = 'Create or schedule a similar report.';
$lang['reports_jobs_delete_hint'] = 'Delete this scheduled report.';
$lang['reports_jobs_delete_confirm'] = 'Really delete this scheduled report? This irrevocably deletes this scheduled report for all users and cannot be undone.';
$lang['reports_jobs_add'] = 'Add Report';
$lang['reports_jobs_add_and_view'] = 'Add and View Report';
$lang['reports_jobs_edit'] = 'Save Report';
$lang['reports_jobs_groups_fallback'] = 'Others';
$lang['reports_jobs_label_fallback'] = 'Unnamed';
$lang['reports_jobs_description_fallback'] = 'No description.';
$lang['reports_jobs_author_fallback'] = 'No author';
$lang['reports_jobs_version_fallback'] = 'No version';
$lang['reports_jobs_success_add'] = 'Successfully added the new report/scheduled report.';
$lang['reports_jobs_noaccess'] = 'The requested scheduled report does not exist or you do not have the permissions to access it.';
$lang['reports_jobs_noschedule'] = 'Please select at least one scheduling option.';

$lang['reports_template'] = 'Report API Template';
$lang['reports_templates_create'] = 'Create Report Template';
$lang['reports_templates_create_intro'] = 'You can create reports for the following report templates:';
$lang['reports_templates_add_hint'] = 'Create or schedule a new report for this template.';
$lang['reports_templates_edit_hint'] = 'Edit this report API template.';
$lang['reports_templates_copy_hint'] = 'Create or schedule a similar report API template.';
$lang['reports_templates_delete_hint'] = 'Delete this report API template.';
$lang['reports_templates_delete_confirm'] = 'Really delete this report API template? This irrevocably deletes this report API template for all users and cannot be undone.';
$lang['reports_templates_add'] = 'Add Report Template';
$lang['reports_templates_add_and_view'] = 'Add and View Report Template';
$lang['reports_templates_edit'] = 'Save Report';
$lang['reports_templates_groups_fallback'] = 'Others';
$lang['reports_templates_label_fallback'] = 'Unnamed';
$lang['reports_templates_description_fallback'] = 'No description.';
$lang['reports_templates_author_fallback'] = 'No author';
$lang['reports_templates_version_fallback'] = 'No version';
$lang['reports_templates_success_add'] = 'Successfully added the new report/API report template.';
$lang['reports_templates_noaccess'] = 'The requested report API template does not exist or you do not have the permissions to access it.';
$lang['reports_templates_noschedule'] = 'Please select at least one scheduling option.';

$lang['reports_jobs_success_update'] = 'Successfully updated the scheduled report.';
$lang['reports_jobs_success_delete'] = 'Successfully deleted the scheduled report.';
$lang['reports_templates_success_update'] = 'Successfully updated the API report template.';
$lang['reports_templates_success_delete'] = 'Successfully deleted the API report template.';
$lang['reports_plugin'] = 'Plugin';
$lang['reports_plugin_unknown'] = 'Unknown or invalid report plugin "{0}".';
$lang['reports_plugin_no_class'] = 'Implementation class missing for report plugin "{0}".';
$lang['reports_form_options_custom'] = 'Report Options';
$lang['reports_form_options_general'] = 'Access &amp; Scheduling';

$lang['reports_control_unknown'] = 'Unknown report control "{0}".';
$lang['reports_control_no_class'] = 'Implementation class missing for report control "{0}".';

$lang['reports_name'] = 'Name';
$lang['reports_name_desc'] = 'You can use the following variables in the report name: <a class="link" {0}>date</a>, <a class="link" {1}>date/time</a>.';
$lang['reports_description'] = 'Description';
$lang['reports_description_desc'] = 'Use the description to explain the content and purpose of this report or add links to additional resources.';

$lang['reports_form_author'] = 'Author:';
$lang['reports_form_version'] = 'Version:';
$lang['reports_form_group'] = 'Group:';

$lang['reports_access_private'] = 'Private';
$lang['reports_access_shared_by'] = 'Shared, by <strong>{0}</strong>';
$lang['reports_access_inactive_by'] = 'Disabled; owner deactivated: <strong>{0}</strong>';
$lang['reports_access_field'] = 'Access';
$lang['reports_access_intro'] = 'This report can be accessed by:';
$lang['reports_access_user'] = 'Myself only (and administrators)';
$lang['reports_access_shared'] = 'Everyone (with project access)';
$lang['reports_schedule_intro'] = 'Create this report:';
$lang['reports_schedule_now'] = 'Right now';
$lang['reports_generate_now_field'] = 'Generate Now';
$lang['reports_schedule_now_field'] = 'Create Now';
$lang['reports_schedule_on_demand_via_api'] = 'On demand via the API';
$lang['reports_schedule_later'] = 'Schedule this report:';
$lang['reports_schedule_later_field'] = 'Schedule';
$lang['reports_schedule_interval'] = 'Schedule Interval';
$lang['reports_schedule_interval_daily'] = 'Every day';
$lang['reports_schedule_interval_daily_at'] = 'Every day at {0} {1}';
$lang['reports_schedule_interval_weekly'] = 'Every week';
$lang['reports_schedule_interval_weekly_at'] = 'Every {0} at {1} {2}';
$lang['reports_schedule_interval_monthly'] = 'Every month';
$lang['reports_schedule_interval_monthly_at'] = 'Every month, {0}. at {1} {2}';
$lang['reports_schedule_interval_until'] = 'until {0}';
$lang['reports_schedule_weekday'] = 'Schedule Weekday';
$lang['reports_schedule_weekday_monday'] = 'Monday';
$lang['reports_schedule_weekday_tuesday'] = 'Tuesday';
$lang['reports_schedule_weekday_wednesday'] = 'Wednesday';
$lang['reports_schedule_weekday_thursday'] = 'Thursday';
$lang['reports_schedule_weekday_friday'] = 'Friday';
$lang['reports_schedule_weekday_saturday'] = 'Saturday';
$lang['reports_schedule_weekday_sunday'] = 'Sunday';
$lang['reports_schedule_day'] = 'Schedule Day';
$lang['reports_schedule_hour'] = 'Schedule Hour';
$lang['reports_schedule_until'] = 'Schedule Until';
$lang['reports_schedule_until'] = 'Until : ';
$lang['reports_schedule_until_link'] = 'Select a date';
$lang['reports_notify_intro'] = 'Once the report is ready:';
$lang['reports_notify_user'] = 'Notify me by email';
$lang['reports_notify_user_field'] = 'Notify (User)';
$lang['reports_notify_others_link'] = 'Email a link to the report (requires TestRail access):';
$lang['reports_notify_others_link_field'] = 'Notify (Link)';
$lang['reports_notify_others_link_recipients'] = 'Link Recipients';
$lang['reports_notify_others_link_desc'] = 'You can select multiple users by holding Ctrl/Cmd on your keyboard.';
$lang['reports_notify_others_attachment'] = 'Email the report as attachment (no TestRail access required):';
$lang['reports_notify_others_attachment_html'] = 'Email the report as HTML attachment';
$lang['reports_notify_others_attachment_pdf'] = 'Email the report as PDF attachment';

$lang['reports_notify_others_attachment_field'] = 'Notify (Attachment)';
$lang['reports_notify_others_attachment_recipients'] = 'Attachment Recipients';
$lang['reports_notify_others_attachment_default'] = 'person1@example.com
person2@example.com';
$lang['reports_notify_others_attachment_desc'] = 'Please enter one email address per line.';
$lang['reports_notify_others_attachment_invalid'] = 'Field Attachment Recipients contains one or more invalid email addresses.';

$lang['reports_denied_add'] = 'You are not allowed to add reports (insufficient permissions).';
$lang['reports_denied_edit'] = 'You are not allowed to edit reports (insufficient permissions).';
$lang['reports_denied_delete'] = 'You are not allowed to delete reports (insufficient permissions).';
$lang['reports_denied_schedule'] = 'You are not allowed to schedule reports (insufficient permissions).';
$lang['reports_denied_run'] = 'You don’t have access to this report.';

$lang['reports_view_error_intro'] = 'An error occurred while generating the report. Please contact your TestRail administrator or the person who built this report to resolve this issue. The following error message and details were recorded:';
$lang['reports_view_error_send_intro'] = 'If you believe this is an error that shouldn\'t happen, please send this error report to Gurock Software. You can optionally enter your
email address below and a Gurock Software support engineer will contact you
shortly.';
$lang['reports_view_error_send_email'] = 'Email Address (optional):';
$lang['reports_view_error_send_button'] = 'Send Error Report';
$lang['reports_custom_validation'] = 'Please select at least one test run (apply a filter or choose specific runs).';

$lang['report_bulk_delete'] = 'Delete Selected';
$lang['report_bulk_delete_message'] = '<strong>Delete all selected reports?</strong> This action cannnot be <br />undone.';
$lang['report_bulk_delete_confirmation'] = '<span style="color:red">Yes, delete all selected Reports (cannot be undone)</span>';

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

$lang['runs_overview_open'] = 'Open';
$lang['runs_overview_active'] = 'Active';
$lang['runs_overview_active_empty'] = 'No active test runs in this project.';
$lang['runs_overview_upcoming'] = 'Upcoming';
$lang['runs_overview_completion_pending'] = 'Completion Pending';
$lang['runs_overview_completed'] = 'Completed';
$lang['runs_overview_activity'] = 'Activity';
$lang['runs_overview_tests'] = 'Tests';
$lang['runs_overview_allactive'] = 'All Active';

$lang['runs_overview_display'] = 'Display';
$lang['runs_overview_display_large'] = 'Detail View';
$lang['runs_overview_display_large_desc'] = 'Displays the test runs and plans with many details. Useful if you have just a few runs/plans.';
$lang['runs_overview_display_medium'] = 'Medium View';
$lang['runs_overview_display_medium_desc'] = 'Displays the test runs and plans in a medium-sized way.';
$lang['runs_overview_display_small'] = 'Compact View';
$lang['runs_overview_display_small_desc'] = 'Displays the test runs and plans as a compact list. Useful if you have many runs/plans.';
$lang['runs_included'] = 'Included';
$lang['runs_references'] = 'References';
$lang['runs_refs_desc'] = 'Add reference ID\'s to external tickets here.' ;

$lang['runs_view_display'] = 'Display';
$lang['runs_view_display_tree'] = 'All groups and tests';
$lang['runs_view_display_tree_name'] = 'All';
$lang['runs_view_display_subtree'] = 'Selected group and subgroups';
$lang['runs_view_display_subtree_name'] = 'Subgroups';
$lang['runs_view_display_compact'] = 'Selected group only';
$lang['runs_view_display_compact_name'] = 'Selected';
$lang['runs_view_todos'] = 'Showing only the tests for the following users:';
$lang['runs_view_todos_plus'] = '(+{0} other {0?{users}:{user}})';
$lang['runs_view_todos_clear'] = '(<a href="{0}" class="link">show all again</a>)';

$lang['runs_is_plan'] = '(Plan)';
$lang['runs_namespace'] = 'Test Run Namespace';
$lang['runs_run'] = 'Test Run';
$lang['runs_config'] = 'Configuration';
$lang['runs_ids'] = 'Test Run IDs';
$lang['runs_user_ids'] = 'User IDs';
$lang['runs_return_location'] = 'Return Location';
$lang['runs_loadall'] = 'Load All';
$lang['runs_overview_groupby'] = 'Group By';
$lang['runs_overview_orderby'] = 'Order By';
$lang['runs_tabs_run'] = 'Run';
$lang['runs_tabs_cases'] = 'Cases';
$lang['runs_runreport'] = 'Reports';
$lang['runs_loading'] = 'Loading tests ..';
$lang['runs_offset'] = 'Offset';
$lang['runs_expands'] = 'Group Expands';

$lang['runs_reports_defects'] = 'Defects';
$lang['runs_reports_defects_summary'] = 'Summary';
$lang['runs_reports_defects_summary_hint'] = 'Shows a summary of found defects for this test run.';
$lang['runs_reports_defects_cases_summary'] = 'Summary for Cases';
$lang['runs_reports_defects_cases_summary_hint'] = 'Shows a summary of found defects for this test run per test case &amp; test.';
$lang['runs_reports_defects_references_summary'] = 'Summary for References';
$lang['runs_reports_defects_references_summary_hint'] = 'Shows a summary of found defects for the references (requirements, user stories, etc.) in this test run.';

$lang['runs_reports_run'] = 'Run';
$lang['runs_reports_run_summary'] = 'Summary';
$lang['runs_reports_run_summary_hint'] = 'Shows a full summary &amp; overview of this test run with statistics as well as activity and progress details.';

$lang['runs_reports_results'] = 'Results';
$lang['runs_reports_results_property_groups'] = 'Property Distribution';
$lang['runs_reports_results_property_groups_hint'] = 'Shows the distribution and groups for a specific test attribute (e.g. priority, type or status) for this test run.';
$lang['runs_reports_results_case_coverage'] = 'Comparison for Cases';
$lang['runs_reports_results_case_coverage_hint'] = 'Shows the results in this test run per test case (result coverage &amp; comparison).';
$lang['runs_reports_results_reference_coverage'] = 'Comparison for References';
$lang['runs_reports_results_reference_coverage_hint'] = 'Shows the results for the references (requirements, user stories, etc.) in this test run (result coverage &amp; comparison).';

$lang['runs_reports_users'] = 'Users';
$lang['runs_reports_users_workload_summary'] = 'Workload Summary';
$lang['runs_reports_users_workload_summary_hint'] = 'Shows the workload summary, estimates and forecasts for users in this test run.';

$lang['runs_group_by'] = 'Group By';
$lang['runs_group_by_none'] = 'Section';
$lang['runs_group_by_reset'] = 'Reset grouping to sections.';
$lang['runs_group_by_reset_menu'] = 'Reset to sections';
$lang['runs_group_order'] = 'Group Order';
$lang['runs_group_id'] = 'Group ID';

$lang['runs_status_ids'] = 'Status IDs';
$lang['runs_stats'] = 'Stats';
$lang['runs_case_ids'] = 'Case IDs';
$lang['runs_case_filter'] = 'Case Filter';
$lang['runs_filter'] = 'Filter';

$lang['runs_cases_select'] = 'Select';
$lang['runs_cases_select_all'] = 'All';
$lang['runs_cases_select_none'] = 'None';
$lang['runs_cases_select_filter'] = 'By Filter';
$lang['runs_delete_select_all'] = 'Select all';
$lang['runs_delete_selected'] = 'Delete selected';
$lang['runs_tooltip_text'] = 'Delete this run/plan';
$lang['runs_delete_confirm'] = 'Really delete this run/plan? This irrevocably deletes this run for all users and cannot be undone.';

$lang['runs_cases_select_title'] = 'Select Cases';
$lang['runs_cases_select_one'] = 'Please select at least one test case.';
$lang['runs_cases_select_info_all_short'] = 'All included (<a class="link" {0}>select</a>)';
$lang['runs_cases_select_info_specific'] = '<strong>{0}</strong> {0?{test cases}:{test case}} included (<a class="link" {1}>select cases</a> or <a class="link" {2}>include all</a>)';
$lang['runs_cases_select_info_specific_short'] = '<strong>{0}</strong> {0?{cases}:{case}} included (<a class="link" {1}>all</a>)';
$lang['runs_cases_select_assignedto'] = 'Assigned To: ';
$lang['runs_cases_select_assignedto_link'] = 'change';
$lang['runs_cases_select_description'] = 'Description';
$lang['runs_cases_select_data'] = 'Description & References';
$lang['runs_cases_select_description_set'] = '<a class="link" {0}>set</a>';
$lang['runs_cases_select_description_change'] = 'Change';
$lang['runs_cases_select_config_assignedto_select'] = '<a class="link" {0}>select</a>';
$lang['runs_cases_select_config_include_select_or_all'] = '<a class="link" {0}>select</a> or <a class="link" {1}>all</a>';
$lang['runs_cases_select_info_all_dynamic'] = 'All cases included (<a class="link" {0}>select cases</a> or <a class="link" {1}>dynamic filters</a>)';
$lang['runs_cases_select_info_specific_dynamic'] = '<strong>{0}</strong> {0?{test cases}:{test case}} included (<a class="link" {1}>select cases</a>, <a class="link" {2}>include all</a> or <a class="link" {3}>dynamic filters</a>)';
$lang['runs_cases_change_info_specific_dynamic'] = '<strong>{0}</strong> {0?{test cases}:{test case}} included (<a class="link" {1}>select cases</a>, <a class="link" {2}>include all</a> or <a class="link" {3}>change filters</a>)';
$lang['runs_cases_select_config_include_dynamic'] = '<a class="link" {0}>select</a>, <a class="link" {1}>all</a> or <a class="link" {2}>dynamic</a>';

$lang['runs_softlock'] = 'Not saved: this test run has been changed by other users';
$lang['runs_softlock_desc'] = 'This run has been modified since you opened it
(by <em>{0}</em> on <em>{1}</em>, and possibly others). You can <a target="_blank" href="{2}">review the changes</a>
and still save the run. Please note that this will override all changes made by other users.';
$lang['runs_softlock_force'] = 'Yes, override all made changes and save my version';

$lang['runs_dialogs_width'] = 'Width';
$lang['runs_dialogs_height'] = 'Height';

$lang['runs_columns'] = 'Columns';
$lang['runs_partial'] = 'Is Partial';
$lang['runs_include_sidebar'] = 'Include Sidebar';

$lang['runs_tests_toolbar_sorted'] = 'Sort:';
$lang['runs_tests_toolbar_filter'] = 'Filter:';

$lang['runs_filter_reset'] = 'Remove filter and show all tests.';
$lang['runs_filter_none'] = 'None';
$lang['runs_filter_group_active'] = 'Active';
$lang['runs_filter_group_upcoming'] = 'Upcoming';
$lang['runs_filter_group_completed'] = 'Completed';
$lang['runs_filter_empty'] = 'No tests found.';

$lang['runs_success_add'] = 'Successfully added the new test run.';
$lang['runs_success_delete'] = 'Successfully deleted the test run.';
$lang['runs_success_close'] = 'Successfully closed the test run.';
$lang['runs_success_subscribe'] = 'Successfully subscribed to the test run.';
$lang['runs_success_unsubscribe'] = 'Successfully unsubscribed from the test run.';
$lang['runs_error_subscribe'] = 'An error occurred while subscribing to the test run.';
$lang['runs_error_unsubscribe'] = 'An error occurred while unsubscribing from the test run.';
$lang['runs_error_add'] = 'An error occurred while adding the new test run.';
$lang['runs_error_delete'] = 'An error occurred while deleting the test run. Maybe the test run didn\'t exist anymore?';
$lang['runs_error_close'] = 'An error occurred while closing the test run. Maybe the test run didn\'t exist anymore?';
$lang['runs_error_exists'] = 'The specified test run does not exist or you do not have the permission to access it.';
$lang['runs_success_update'] = 'Successfully updated the test run.';
$lang['runs_error_update'] = 'An error occurred while saving the test run.';
$lang['runs_error_no_tests'] = 'include_all is false but no tests were provided.';
$lang['runs_completed'] = '<strong>This test run is completed.</strong> You can no longer modify this test run or add new test results.';
$lang['runs_completed_short'] = '(completed)';

$lang['runs_summary_and'] = ' and ';
$lang['runs_invalid_milestone'] = 'The Milestone field is invalid (unknown format or milestone).';
$lang['runs_invalid_user'] = 'The Assign To field is invalid (unknown format or user).';
$lang['runs_invalid_assignedto_id'] = 'Field :assignedto_id is not a valid ID.';
$lang['runs_empty_run_id'] = 'Field :run_id is a test plan entry. Please use update_plan_entry instead.';
$lang['runs_denied_edit_without_plan']= 'Field :run_id does not belong to a test plan entry.';
$lang['runs_no_case_selected'] = 'Please select at least one test case.';
$lang['runs_box'] = 'Test Run';
$lang['runs_name'] = 'Name';
$lang['runs_name_default'] = 'Test Run {0}';
$lang['runs_name_desc'] = 'Either reuse the test suite name or specify a new one.';
$lang['runs_name_desc_master'] = 'Ex: <em>Test Run 2014-08-01</em>, <em>Build 240</em> or <em>Version 3.0</em>';
$lang['runs_assignto'] = 'Assign To';
$lang['runs_assignto_me'] = 'Me';
$lang['runs_assignto_desc'] = 'The user to whom the tests of the new test run should initially be assigned.
An email is sent to the user if email notifications are enabled.';
$lang['runs_created_by'] = 'Created By';
$lang['runs_created_on'] = 'Created On';
$lang['runs_assignedto'] = 'Assigned To';
$lang['runs_plan'] = 'Test Plan';
$lang['runs_milestone'] = 'Milestone';
$lang['runs_milestone_desc'] = 'The milestone this test run belongs to.';
$lang['runs_description'] = 'Description';
$lang['runs_description_edit'] = 'Edit Description';
$lang['runs_description_desc'] = 'Use this description to describe the purpose of this test run.';
$lang['runs_description_desc_reuse'] = 'Use this description to describe the purpose of this test run.
You can also <a class="link" {0}>reuse the description</a> of the test suite.';
$lang['runs_is_completed'] = 'Is Completed';
$lang['runs_completed_on'] = 'Completed On';

$lang['runs_actions'] = 'Actions';
$lang['runs_delete'] = 'Delete Test Run';
$lang['runs_delete_link'] = 'Delete this test run';
$lang['runs_delete_descr'] = 'Delete this test run to remove it from your project.';
$lang['runs_delete_confirm'] = 'Really delete this test run? This also deletes all tests and results in this run and cannot be undone.';
$lang['runs_delete_confirm_checkbox'] = 'Yes, delete this test run (cannot be undone)';
$lang['runs_delete_confirm_extra'] = 'You will irrevocably delete at least <strong>{0}</strong> {0?{tests}:{test}} and the related test results &amp; comments.';
$lang['runs_print_confirm'] = 'This test run contains {0} tests. The <em>Details</em> view will generate hundreds of pages and may be slow. Continue?';

$lang['runs_close'] = 'Close Test Run';
$lang['runs_close_link'] = 'Close this test run';
$lang['runs_close_descr'] = 'Archive this test run to prevent future modifications to its tests and results.';
$lang['runs_close_hint'] = 'Close Run';
$lang['runs_close_hint_desc'] = 'Closes this test run to archive its tests and results. Prevents future modifications.';
$lang['runs_close_confirm'] = 'Really close this test run? This operation cannot be undone.';
$lang['runs_close_confirm_long'] = 'Really close this test run? Closing a test run archives the related tests and prevents future modifications. This change cannot be undone.';

$lang['runs_new'] = 'Add Test Run';
$lang['runs_add'] = 'Add Test Run';
$lang['runs_save'] = 'Save Test Run';

$lang['runs_case_selection'] = 'Case Selection';
$lang['runs_case_selection_short'] = 'Cases';
$lang['runs_include_all'] = 'Include all test cases';
$lang['runs_include_all_short'] = 'Include all';
$lang['runs_include_all_desc'] = 'Select this option to include all test cases in this test run. If new test cases are added to the test suite, they are also automatically included in this run.';
$lang['runs_include_all_desc_master'] = 'Select this option to include all test cases in this test run. If new test cases are added to the repository, they are also automatically included in this run.';
$lang['runs_include_specific'] = 'Select specific test cases';
$lang['runs_include_specific_short'] = 'Select cases';
$lang['runs_include_specific_info'] = '<strong>{0}</strong> {0?{test cases}:{test case}} included (<a class="" {1}>change selection</a>)';
$lang['runs_include_specific_desc'] = 'You can alternatively select the test cases to include in this test run.
New test cases are not automatically added to this run in this case.';
$lang['runs_dynamic_filters'] = 'Dynamic Filters';
$lang['runs_include_dynamic'] = 'Dynamic Filtering';
$lang['runs_include_dynamic_help'] = 'Read more about Dynamic Filtering in our User Guide.';
$lang['runs_include_dynamic_info'] = '<strong>{0}</strong> {0?{test cases}:{test case}} included (<a class="" {1}>change filter</a>)';
$lang['runs_include_dynamic_desc'] = 'Automatically add test cases based on filter selection. New test cases are automatically added to the run if they match the filter (unless the run is closed).';

$lang['runs_sidebar_query'] = 'Query';
$lang['runs_sidebar_query_desc'] = 'Group your tests by:';
$lang['runs_sidebar_groups'] = 'Groups';
$lang['runs_sidebar_groups_desc'] = 'The following groups are available:';
$lang['runs_sidebar_groupby'] = 'Group By';
$lang['runs_sidebar_runs_grouping'] = 'Group By';
$lang['runs_sidebar_runs_ordering'] = 'Order By';

$lang['runs_sidebar_tests'] = 'Tests &amp; Results';
$lang['runs_sidebar_activity'] = 'Activity';
$lang['runs_sidebar_createdbyon'] = 'Created by {0} on {1}.';
$lang['runs_sidebar_createdbyon_milestone'] = 'Created by {0}. Belongs to milestone <a href="{1}">{2}</a>.';
$lang['runs_sidebar_completedon'] = 'Completed on {0}.';
$lang['runs_sidebar_completedon_milestone'] = 'Completed on {0}. Belongs to milestone <a href="{1}">{2}</a>.';
$lang['runs_sidebar_runs'] = 'Test Runs';
$lang['runs_sidebar_runs_empty'] = 'There are no test runs.';
$lang['runs_sidebar_runs_stats'] = '<strong class="text-softer">{0}</strong> open and <strong class="text-softer">{1}</strong> completed test runs in this project.';
$lang['runs_sidebar_suite'] = 'Test Suite';
$lang['runs_sidebar_suite_desc'] = 'This is a test run for the following test suite:';
$lang['runs_sidebar_viewsuite'] = 'view suite';
$lang['runs_sidebar_progress'] = 'Progress';
$lang['runs_sidebar_defects'] = 'Defects';

$lang['runs_subscription_subscribe'] = 'Subscribe';
$lang['runs_subscription_subscribe_desc'] = 'Subscribe to receive emails on test changes for this test run.';
$lang['runs_subscription_unsubscribe'] = 'Unsubscribe';
$lang['runs_subscription_unsubscribe_desc'] = 'Unsubscribe from email updates on test changes for this test run.';

$lang['runs_activity_empty'] = 'No activity yet.';
$lang['runs_tests_empty'] = 'There aren\'t any tests in this test run.';

$lang['runs_choose_suite'] = 'Select Test Suite';
$lang['runs_choose_suite_suite'] = 'Test Suite';
$lang['runs_choose_suite_desc'] = 'Select the test suite for the new test run.';
$lang['runs_choose_suite_required'] = 'Test Suite is a required field.';

$lang['runs_overview_description'] = 'Description';
$lang['runs_overview_empty_title'] = 'This project doesn\'t have any test runs, yet.';
$lang['runs_overview_empty_body'] = 'No test runs have been defined for this project, yet. Use the following button to add your first test run.';
$lang['runs_overview_empty_noaccess_body'] = 'No test runs have been defined for this project, yet.
Unfortunately, you don\'t have the required permissions to add new test runs. Please contact your administrator.';
$lang['runs_overview_empty_short'] = 'This project doesn\'t have any active test
runs. You can add a new test run.';
$lang['runs_overview_empty_noaccess_short'] = 'This project doesn\'t have any active test runs.
Unfortunately, you don\'t have the permissions to add one.';

$lang['runs_overview_empty_nosuites_title'] = 'This project doesn\'t contain any test runs or suites, yet.';
$lang['runs_overview_empty_nosuites_body'] = 'Before you can execute your first test run, 
you need to add a new test suite and test cases first.';
$lang['runs_overview_empty_nosuites_noaccess_body'] = 'Before you can execute your first test run, 
you need to add a new test suite and test cases first. Unfortunately, you don\'t have the required
permissions to do so. Please contact your administrator.';
$lang['runs_overview_empty_nosuites_short'] = 'This project doesn\'t contain any active
test runs or test suites. You can add a new test suite.';
$lang['runs_overview_empty_nosuites_noaccess_short'] = 'This project doesn\'t contain any active test runs or test suites.
Unfortunately, you are not allowed to add one.';

$lang['runs_overview_empty_expl_title'] = 'What\'s a test run?';
$lang['runs_overview_empty_expl_body'] = 'Once you have started adding test cases, you can start a test run to execute your tests and track results.';

$lang['runs_print_hint'] = 'Print Run';
$lang['runs_print_hint_desc'] = 'Opens a print view of this test run.';
$lang['runs_print_format'] = 'Print Format';
$lang['runs_export_hint'] = 'Export Run';
$lang['runs_export_hint_desc'] = 'Exports this test run into different formats (XML, Excel/CSV).';
$lang['runs_export_format'] = 'Format';
$lang['runs_export_section_include'] = 'Section Include';
$lang['runs_export_section_ids'] = 'Section IDs';
$lang['runs_export_columns'] = 'Columns';
$lang['runs_export_layout'] = 'Layout';
$lang['runs_export_separator_hint'] = 'Separator Hint';
$lang['runs_section_show_empty'] = 'Show Empty';

$lang['runs_rerun_title'] = 'Select Tests';
$lang['runs_rerun_desc'] = 'Include tests of the following previous status:';

$lang['runs_denied_add'] = 'You are not allowed to add test runs (insufficient permissions).';
$lang['runs_denied_edit'] = 'You are not allowed to edit test runs (insufficient permissions).';
$lang['runs_denied_edit_plan'] = 'Field :run_id is part of a test run. Please use API endpoints for test plan entries.';
$lang['runs_denied_delete'] = 'You are not allowed to delete test runs (insufficient permissions).';
$lang['runs_denied_delete_completed'] = 'You are not allowed to delete completed test runs (insufficient permissions).';
$lang['runs_denied_delete_plan'] = 'Field :run_id is part of a test run. Please use API endpoints for test plan entries.';
$lang['runs_denied_close'] = 'You are not allowed to close test runs (insufficient permissions).';
$lang['runs_denied_close_plan'] = 'This operation is not allowed. The test run belongs to a test plan and cannot be closed independently.';
$lang['runs_denied_completed'] = 'This operation is not allowed. The test run is already completed.';

$lang['runs_progress_details'] = 'Progress';
$lang['runs_progress_estimate_desc'] = 'Based on the current activity and forecasts, the projected completion date for this test run is:';
$lang['runs_progress_estimate_desc_many'] = 'Based on the current activity and forecasts, the projected completion date for the test run(s) is:';
$lang['runs_progress_estimate_no_accuracy'] = 'Forecast not possible, <a class="link" target="_blank" href="https://www.gurock.com/testrail/docs/user-guide/getting-started/tips">more data needed</a>';
$lang['runs_progress_estimate_no_accuracy_nohelp'] = 'Forecast not possible';
$lang['runs_progress_estimate_low_accuracy'] = 'Low accuracy, <a class="link" target="_blank" href="https://www.gurock.com/testrail/docs/user-guide/getting-started/tips">more data needed</a>';
$lang['runs_progress_estimate_low_accuracy_nohelp'] = 'Low accuracy forecast';
$lang['runs_progress_estimate_high_accuracy'] = 'High accuracy, <a class="link" target="_blank" href="https://www.gurock.com/testrail/docs/user-guide/getting-started/tips">learn more</a>';
$lang['runs_progress_estimate_high_accuracy_nohelp'] = 'High accuracy forecast';
$lang['runs_progress_estimate_unknown'] = 'Unknown';
$lang['runs_progress_running_since'] = 'This test run was started <strong class="text-softer">{0} ago</strong> ({1}).';
$lang['runs_progress_running_since_many'] = 'The test run(s) were started <strong class="text-softer">{0} ago</strong> ({1}).';
$lang['runs_progress_running_since_completed'] = 'This test run was active for <strong class="text-softer">{0}</strong> ({1} &ndash; {2}).';
$lang['runs_progress_running_since_completed_many'] = 'The test run(s) were active for <strong class="text-softer">{0}</strong> ({1} &ndash; {2}).';
$lang['runs_progress_running_completed'] = 'Completed:';
$lang['runs_progress_running_elapsed'] = 'Elapsed:';
$lang['runs_progress_running_tests_day'] = 'Tests / day:';
$lang['runs_progress_running_hours_day'] = 'Hours / day:';
$lang['runs_progress_stats_metric'] = 'Metric';
$lang['runs_progress_stats_by_estimate'] = 'By Estimate';
$lang['runs_progress_stats_by_forecast'] = 'By Forecast';
$lang['runs_progress_stats_completed'] = 'Completed';
$lang['runs_progress_stats_notcompleted'] = 'Not Completed';
$lang['runs_progress_stats_todo'] = 'Todo';
$lang['runs_progress_stats_total'] = 'Total';
$lang['runs_progress_completed'] = 'The progress is not available for a completed test run.';
$lang['runs_progress_no_task'] = 'Background Task';
$lang['runs_progress_no_task_desc'] = 'The background task is required for computing the forecasts, but the task is not installed.';
$lang['runs_progress_no_task_more'] = 'Learn more';
$lang['runs_progress_unknown_forecast'] = 'Forecast n/a';

$lang['runs_defects'] = 'Defects';
$lang['runs_defects_empty'] = 'No defects so far.';
$lang['runs_defects_empty_desc'] = 'Defects can be linked on the Add Result dialog when adding results.';

$lang['runs_tree_tests_not_displayed'] = '{0} more {0?{tests}:{test}} available.
Switch to <a href="{1}">compact view</a> to see all tests.';

$lang['runs_help_upcoming'] = 'Test runs &amp; plans of upcoming milestones are shown in this <em>Upcoming</em> section.
Starting the related milestone will move the runs &amp; plans from <em>upcoming</em> to <em>active</em>.';
$lang['runs_help_completion_pending'] = 'Test runs &amp; plans of completed milestones are shown in this <em>Completion Pending</em> section.
You can close the runs &amp; plans to mark them as completed and archive them.';

$lang['runs_timeline_hint_past'] = 'Milestone start date is in the past.';
$lang['runs_timeline_hint_future'] = 'Milestone start date is in the future.';
$lang['runs_page_type'] = 'Page Type';
$lang['runs_bulk_delete_message'] = '<strong>Really delete these test {0}?</strong> This also deletes all tests &amp; <br /> results in these {0} and cannot be undone.';
$lang['runs_bulk_delete_confirmation'] = '<span style="color:red">Yes, I want to <strong>irrevocably delete at least {0} tests <br />and the related test results &amp; comments.</strong></span>';
$lang['runs_bulk_delete_success'] = 'Successfully deleted the test {0}.';
$lang['runs_bulk_delete_error'] = 'No run selected.';
$lang['runs_bulk_delete_message_label'] = 'Message';


$lang['search_query'] = 'Query';
$lang['search_query_desc'] = 'Enter a search term or specific ID.';
$lang['search_find'] = 'Find';
$lang['search_more'] = 'More results available, please narrow down your search results.';

$lang['search_invalid_test'] = 'The specified test was not found.';
$lang['search_invalid_case'] = 'The specified test case was not found.';
$lang['search_invalid_run'] = 'The specified test run was not found.';
$lang['search_invalid_milestone'] = 'The specified milestone was not found.';
$lang['search_invalid_project'] = 'The specified project was not found.';
$lang['search_invalid_suite'] = 'The specified test suite was not found.';
$lang['search_invalid_length'] = 'The specified term(s) are too short: minimum length is 2.';

$lang['search_sidebar_help'] = 'Help';
$lang['search_sidebar_help_desc1'] = 'You can enter a generic search term or jump directly to
a specific ID (entity symbol followed by the actual number).';
$lang['search_sidebar_help_desc2'] = 'The following entity symbols are supported:';
$lang['search_sidebar_help_desc3'] = 'So, to go to the test with ID 17, just enter T17.';
$lang['search_sidebar_help_forcase'] = 'for Test Cases';
$lang['search_sidebar_help_formilestone'] = 'for Milestones';
$lang['search_sidebar_help_forproject'] = 'for Projects';
$lang['search_sidebar_help_forrun'] = 'for Test Runs';
$lang['search_sidebar_help_fortest'] = 'for Tests';
$lang['search_sidebar_help_forsuite'] = 'for Test Suites';

$lang['search_results'] = 'Results';
$lang['search_results_empty'] = 'No results found.';
$lang['search_results_case'] = 'Test Case';
$lang['search_results_cases'] = 'Test Cases';
$lang['search_results_milestone'] = 'Milestone';
$lang['search_results_milestones'] = 'Milestones';
$lang['search_results_run'] = 'Test Run';
$lang['search_results_runs'] = 'Test Runs';
$lang['search_results_suite'] = 'Test Suite';
$lang['search_results_suites'] = 'Test Suites';
$lang['search_results_test'] = 'Test';
$lang['search_results_tests'] = 'Tests';
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
$lang['stats_chart_passed'] = '{0} Passed';
$lang['stats_chart_passed_desc'] = '{0}% were successful.';
$lang['stats_chart_retest'] = '{0} Retest';
$lang['stats_chart_retest_desc'] = '{0}% marked as retest.';
$lang['stats_chart_failed'] = '{0} Failed';
$lang['stats_chart_failed_desc'] = '{0}% were unsuccessful.';
$lang['stats_chart_untested'] = '{0} Untested';
$lang['stats_chart_untested_desc'] = '{0}% are untested.';
$lang['stats_chart_untested_note'] = '{0} / {1} untested ({2}%).';
$lang['stats_chart_blocked'] = '{0} Blocked';
$lang['stats_chart_blocked_desc'] = '{0}% marked as blocked.';
$lang['stats_chart_done'] = '{0}%';
$lang['stats_chart_done_desc'] = 'passed';
$lang['stats_chart_done_desc_upper'] = 'Passed';
$lang['stats_chart_status'] = '{0} {1}';
$lang['stats_chart_status_desc'] = '{0}% set to {1}';

$lang['stats_chart_tooltip_passed'] = '{0}% passed ({1}/{2} {2?{tests}:{test}})';
$lang['stats_chart_tooltip_retest'] = '{0}% retest ({1}/{2} {2?{tests}:{test}})';
$lang['stats_chart_tooltip_blocked'] = '{0}% blocked ({1}/{2} {2?{tests}:{test}})';
$lang['stats_chart_tooltip_failed'] = '{0}% failed ({1}/{2} {2?{tests}:{test}})';
$lang['stats_chart_tooltip_untested'] = '{0}% untested ({1}/{2} {2?{tests}:{test}})';
$lang['stats_chart_tooltip_status'] = '{1}% {0} ({2}/{3} {3?{tests}:{test}})';
$lang['stats_chart_tooltip_empty'] = '100% untested';

$lang['stats_chart_missing_flash'] = 'The charts require Adobe flash.
<a href="http://www.adobe.com/go/getflashplayer">Download flash here.</a>';

$lang['statuses_status'] = 'Status';
$lang['statuses_label'] = 'Label';
$lang['statuses_label_desc'] = 'Ex: <em>Passed</em>, <em>Failed</em> or <em>Untested</em>';
$lang['statuses_name'] = 'System Name';
$lang['statuses_name_desc'] = 'The unique name of this status, used as identifier for the export, among other things. Should be all lower case, no spaces.';
$lang['statuses_isactive'] = 'This status is active';
$lang['statuses_isactive_desc'] = 'Only active statuses are selectable when adding a new test result.';
$lang['statuses_isfinal'] = 'This status is a final status';
$lang['statuses_isfinal_desc'] = 'Tests with a final status are considered completed and add to the overall progress of a test run on the Progress tabs (such as Passed, Failed or Blocked).';
$lang['statuses_color_dark'] = 'Color (Dark)';
$lang['statuses_color_dark_desc'] = 'The dark base color for this status in the UI, used for the status box (above), among other things. This field expects a full RGB color in hex notation (e.g. 00FF00 for green, FF0000 for red.';
$lang['statuses_color_medium'] = 'Color (Medium)';
$lang['statuses_color_medium_desc'] = 'The medium bright base color for this status in the UI, used mainly for the charts (pie, bar and line). Expects the same format as the dark base color.';
$lang['statuses_color_bright'] = 'Color (Bright)';
$lang['statuses_color_bright_desc'] = 'The bright base color for this status in the UI, used where the darker colors would be too intense. Expects the same format as the previous colors.';

$lang['statuses_save'] = 'Save Status';
$lang['statuses_howto_add'] = 'Please edit an existing, inactive status to add a new status to your installation.';
$lang['statuses_system'] = '<strong>Please note:</strong> You are editing a system status. Some properties cannot be changed.';
$lang['statuses_success_update'] = 'Successfully updated the status.';
$lang['statuses_no_status'] = 'The specified status does not exist.';

$lang['statuses_validation_unique'] = 'System Name already in use. Please choose another name for your status.';
$lang['statuses_validation_invalid_name'] = 'Invalid characters in System Name: please only use a-z (lower case), 0-9 and underscore characters.';
$lang['suites_runtest'] = 'Run Test';
$lang['suites_runreport'] = 'Reports';
$lang['suites_view_runs'] = 'Test Runs';
$lang['suites_runtest_desc'] = 'Create a new test run for this test suite.';
$lang['suites_addtestrun'] = 'Add Test Run';
$lang['suites_shared_steps'] = 'Shared Test Steps';

$lang['suites_addcase'] = 'Add Case';
$lang['suites_runningtest'] = 'Running Test';
$lang['suites_runningtests'] = 'Running Tests';
$lang['suites_completed'] = '<strong>This test suite is completed.</strong> You can no longer modify its sections or test cases.';

$lang['suites_reports_cases'] = 'Cases';
$lang['suites_reports_cases_activity_summary'] = 'Activity Summary';
$lang['suites_reports_cases_activity_summary_hint'] = 'Shows a summary of new and updated test cases.';
$lang['suites_reports_cases_reference_coverage'] = 'Coverage for References';
$lang['suites_reports_cases_reference_coverage_hint'] = 'Shows the test case coverage for references (requirements, user stories, etc.) in a coverage matrix.';
$lang['suites_reports_cases_property_groups'] = 'Property Distribution';
$lang['suites_reports_cases_property_groups_hint'] = 'Shows the distribution and groups for a specific test case attribute (e.g. priority or type).';
$lang['suites_reports_cases_status_tops'] = 'Status Tops';
$lang['suites_reports_cases_status_tops_hint'] = 'Shows the test cases with the highest number of failed, blocked etc. results.';

$lang['suites_reports_defects'] = 'Defects';
$lang['suites_reports_defects_summary'] = 'Summary';
$lang['suites_reports_defects_summary_hint'] = 'Shows a summary of found defects for the test cases and select test runs.';
$lang['suites_reports_defects_cases_summary'] = 'Summary for Cases';
$lang['suites_reports_defects_cases_summary_hint'] = 'Shows a summary and comparison of found defects per test case and select test runs.';
$lang['suites_reports_defects_references_summary'] = 'Summary for References';
$lang['suites_reports_defects_references_summary_hint'] = 'Shows a summary and comparison of found defects for the references (requirements, user stories, etc.).';

$lang['suites_reports_results'] = 'Results';
$lang['suites_reports_results_case_coverage'] = 'Comparison for Cases';
$lang['suites_reports_results_case_coverage_hint'] = 'Compares the results for the test cases over multiple test runs (result coverage).';
$lang['suites_reports_results_reference_coverage'] = 'Comparison for References';
$lang['suites_reports_results_reference_coverage_hint'] = 'Compares the results for the references (requirements, user stories, etc.) over multiple test runs (result coverage).';

$lang['suites_overview_description'] = 'Has {0} {0?{sections}:{section}} with {1} {1?{test cases}:{test case}}.';
$lang['suites_overview_description_short'] = '{0} {0?{sections}:{section}} with <strong>{1} {1?{cases}:{case}}</strong>';
$lang['suites_overview_description_runs'] = '<strong>{0}</strong> active {0?{test runs}:{test run}}.';
$lang['suites_overview_description_runs_short'] = '{1} {0?{Runs}:{Run}}';
$lang['suites_overview_description_noruns'] = 'No active test runs.';

$lang['suites_overview_display'] = 'Display';
$lang['suites_overview_display_large'] = 'Detail View';
$lang['suites_overview_display_large_desc'] = 'Displays the test suites with many details. Useful if you have just a few suites.';
$lang['suites_overview_display_medium'] = 'Medium View';
$lang['suites_overview_display_medium_desc'] = 'Displays the test suites in a medium-sized way.';
$lang['suites_overview_display_small'] = 'Compact View';
$lang['suites_overview_display_small_desc'] = 'Displays the test suites as a compact list. Useful if you have many suites.';

$lang['suites_overview_baselines'] = 'Baselines';
$lang['suites_overview_baselines_noactive'] = 'No active baselines.';
$lang['suites_overview_baselines_completed'] = 'Completed';

$lang['suites_view_display'] = 'Display';
$lang['suites_view_display_tree'] = 'All groups and tests';
$lang['suites_view_display_tree_name'] = 'All';
$lang['suites_view_display_subtree'] = 'Selected group and subgroups';
$lang['suites_view_display_subtree_name'] = 'Subgroups';
$lang['suites_view_display_compact'] = 'Selected group only';
$lang['suites_view_display_compact_name'] = 'Selected';

$lang['suites_group_by'] = 'Group By';
$lang['suites_group_by_none'] = 'Section';
$lang['suites_group_by_reset'] = 'Reset grouping to sections.';
$lang['suites_group_by_reset_menu'] = 'Reset to sections';
$lang['suites_group_order'] = 'Group Order';
$lang['suites_group_id'] = 'Group ID';

$lang['suites_filter_reset'] = 'Remove filter and show all test cases.';
$lang['suites_filter_none'] = 'None';
$lang['suites_filter_group_active'] = 'Active';
$lang['suites_filter_group_upcoming'] = 'Upcoming';
$lang['suites_filter_group_completed'] = 'Completed';
$lang['suites_filter_empty'] = 'No test cases found.';

$lang['suites_sidebar_suites_stats'] = '<strong class="text-softer">{0}</strong> {0?{test suites}:{test suite}} and <strong class="text-softer">{1}</strong> {1?{cases}:{case}} in this project.';
$lang['suites_sidebar_suites_stats_baselines'] =
'<strong class="text-softer">{0}</strong> master {0?{suites}:{suite}},
<strong class="text-softer">{1}</strong> {1?{baselines}:{baseline}} and a total of <strong class="text-softer">{2}</strong> active {2?{cases}:{case}}.';
$lang['suites_sidebar_sections'] = 'Groups';
$lang['suites_sidebar_cases'] = 'Test Cases';

$lang['suites_case_ids'] = 'Case IDs';

$lang['suites_mode_single_not_allowed'] = 'This operation is not permitted because this project only supports a single test suite.';

$lang['suites_new'] = 'Add Test Suite';
$lang['suites_edit'] = 'Edit Test Suite';
$lang['suites_add'] = 'Add Test Suite';
$lang['suites_save'] = 'Save Test Suite';
$lang['suites_view'] = 'View Test Suite';
$lang['suites_view_short'] = 'Test Suite';
$lang['suites_view_veryshort'] = 'Suite';
$lang['suites_actions'] = 'Actions';
$lang['suites_delete'] = 'Delete Test Suite';
$lang['suites_delete_link'] = 'Delete this test suite';
$lang['suites_delete_descr'] = 'Delete this test suite to remove it from your project. This also deletes all related test cases and running tests.';
$lang['suites_delete_confirm'] = 'Really delete this test suite and all <strong>related active test runs and results</strong>? This cannot be undone. You can close active test runs to archive them and prevent them from being deleted.';
$lang['suites_delete_confirm_checkbox'] = 'Yes, delete this test suite (cannot be undone)';
$lang['suites_delete_confirm_extra'] = 'You will irrevocably delete at least <strong>{0}</strong> {0?{test cases}:{test case}} and <strong>{1}</strong> active {1?{test runs}:{test run}} (including tests and results).';
$lang['suites_print_confirm'] = 'This test suite contains {0} test cases. The <em>Details</em> view will generate hundreds of pages and may be slow. Continue?';

$lang['suites_baselines_new'] = 'Add Baseline';
$lang['suites_baselines_name'] = 'Name';
$lang['suites_baselines_name_desc'] = 'The name of the new baseline, e.g. <em>Version 2.0</em>.';
$lang['suites_baselines_parent'] = 'Copy From';
$lang['suites_baselines_parent_desc'] = 'Choose a project and the test suite to use as the basis for the new baseline.';

$lang['suites_denied_add'] = 'You are not allowed to add test suites (insufficient permissions).';
$lang['suites_denied_add_baseline'] = 'You are not allowed to add baselines (insufficient permissions).';
$lang['suites_denied_edit'] = 'You are not allowed to edit test suites (insufficient permissions).';
$lang['suites_denied_delete'] = 'You are not allowed to delete test suites (insufficient permissions).';
$lang['suites_denied_delete_master'] = 'This test suite is a master suite and cannot be deleted.';
$lang['suites_denied_completed'] = 'This operation is not allowed. The test suite is marked as completed.';

$lang['suites_return_location'] = 'Return Location';
$lang['suites_suite'] = 'Test Suite';
$lang['suites_suite_short'] = 'Suite';
$lang['suites_ids'] = 'Test Suite IDs';
$lang['suites_cases'] = 'Test Cases';
$lang['suites_case_count'] = 'Case Count';
$lang['suites_section_count'] = 'Section Count';
$lang['suites_sections'] = 'Sections';
$lang['suites_box'] = 'Test Suite';
$lang['suites_name'] = 'Name';
$lang['suites_name_desc'] = 'Ex: <em>User Interface Test</em> or <em>Release Protocol</em>';
$lang['suites_iscompleted'] = 'Is Completed';
$lang['suites_iscompleted_name'] = 'This test suite is completed';
$lang['suites_iscompleted_desc'] = 'The test cases of a completed test suite are freezed and can no longer be modified.
This is useful for finished versions or releases with a final set of test cases.';
$lang['suites_include_sidebar'] = 'Include Sidebar';
$lang['suites_partial'] = 'Is Partial';
$lang['suites_offset'] = 'Offset';
$lang['suites_expands'] = 'Group Expands';
$lang['suites_description'] = 'Description';
$lang['suites_description_edit'] = 'Edit Description';
$lang['suites_description_save'] = 'Save Description';
$lang['suites_description_desc'] = 'Use this description to explain the content and purpose of this test suite.';
$lang['suites_description_desc_single'] = 'Use this description to explain the content and purpose of the test cases.';

$lang['suites_columns'] = 'Columns';

$lang['suites_sections_confirm_delete'] = 'Really delete this section and all related test cases and running tests? This also deletes <strong>all subsections and cases of this section</strong> and cannot be undone.';
$lang['suites_sections_confirm_delete_checkbox'] = 'Yes, delete this section (cannot be undone)';
$lang['suites_sections_confirm_delete_extra'] = 'You will irrevocably delete at least <strong>{0}</strong> {0?{sections}:{section}} and <strong>{1}</strong> {1?{test cases}:{test case}}.';

$lang['suites_success_add'] = 'Successfully added the new test suite.
<a href="{0}">Add another</a>';
$lang['suites_success_delete'] = 'Successfully deleted the test suite.';
$lang['suites_error_add'] = 'An error occurred while adding the new test suite.';
$lang['suites_error_delete'] = 'An error occurred while deleting the test suite. Maybe the test suite didn\'t exist anymore?';
$lang['suites_error_exists'] = 'The specified test suite does not exist or you do not have the permission to access it.';
$lang['suites_success_update'] = 'Successfully updated the test suite.';
$lang['suites_error_update'] = 'An error occurred while saving the test suite.';

$lang['suites_sections_new'] = 'Add Section';
$lang['suites_sections_edit'] = 'Edit Section';
$lang['suites_sections_error_exists'] = 'The specified section does not exist or you do not have the permission to access it.';
$lang['suites_sections_add'] = 'Add Section';
$lang['suites_sections_save'] = 'Save Section';

$lang['suites_sections_copy_move_invalid'] = 'Invalid arguments for copy/move section (e.g., some sections no longer exist). Please refresh this page and try again.';
$lang['suites_sections_denied_add'] = 'You are not allowed to add sections (insufficient permissions).';
$lang['suites_sections_denied_edit'] = 'You are not allowed to edit sections (insufficient permissions).';
$lang['suites_sections_denied_copy'] = 'You are not allowed to copy sections (insufficient permissions).';
$lang['suites_sections_denied_move'] = 'You are not allowed to move sections (insufficient permissions).';
$lang['suites_sections_denied_delete'] = 'You are not allowed to delete sections (insufficient permissions).';

$lang['suites_subsection_new'] = 'Add Subsection';

$lang['suites_section'] = 'Section';
$lang['suites_section_show_empty'] = 'Show Empty';
$lang['suites_section_ids'] = 'Section IDs';
$lang['suites_section_parent'] = 'Section Parent';
$lang['suites_section_mode'] = 'Section Mode';
$lang['suites_sections_name_error'] = 'The Name field is required.';
$lang['suites_sections_name'] = 'Name';
$lang['suites_sections_parent'] = 'Parent';
$lang['suites_sections_no_parent'] = 'The specified parent section does not exist.';
$lang['suites_sections_desc'] = 'Ex: <em>Save Dialog Tests</em>, <em>Contact Form</em> or <em>Performance Tests</em>';
$lang['suites_sections_description'] = 'Description';
$lang['suites_sections_description_desc'] = 'An optional description for this section (e.g. to explain its content or purpose).';

$lang['suites_sections_columns'] = 'Columns';
$lang['suites_sections_dnd_copy'] = 'Copy here';
$lang['suites_sections_dnd_copy_hint'] = '(shift)';
$lang['suites_sections_dnd_move'] = 'Move here';
$lang['suites_sections_dnd_move_hint'] = '(ctrl/cmd)';
$lang['suites_sections_dnd_cancel'] = 'Cancel';

$lang['suites_runs_active'] = 'Active';
$lang['suites_runs_completed'] = 'Completed';
$lang['suites_loading'] = 'Loading cases ..';

$lang['suites_sidebar_menu_suite'] = 'Sections &amp; Cases';
$lang['suites_sidebar_menu_runs'] = 'Test Runs';

$lang['suites_sidebar_info'] = 'Contains <strong class="text-softer">{0}</strong> {0?{sections}:{section}}
and <a class="link link-dashed" id="estimatesLink" href="javascript:void(0)"><strong class="text-softer">{1}</strong>
<span>{1?{cases}:{case}}</span></a>.';
$lang['suites_sidebar_info_simple'] = 'Contains <strong class="text-softer">{0}</strong> {0?{sections}:{section}}
and <strong class="text-softer">{1}</strong> {1?{cases}:{case}}.';
$lang['suites_sidebar_info_edit_description'] = 'Edit description';

$lang['suites_sidebar_suites'] = 'Test Suites';
$lang['suites_sidebar_suites_sections'] = 'Sections in this test suite:';
$lang['suites_sidebar_suites_empty'] = 'No sections or groups.';

$lang['suites_estimates_title'] = 'Show the estimates and forecasts for this test suite.';
$lang['suites_estimates_cases'] = 'Total cases';
$lang['suites_estimates_without'] = 'No estimates';
$lang['suites_estimates_estimate'] = 'Total estimate';
$lang['suites_estimates_forecast'] = 'Total forecast';

$lang['suites_cases_new'] = 'Add Test Case';
$lang['suites_cases_new_short'] = 'Add Case';
$lang['suites_cases_title_error'] = 'The Case Title field is required.';
$lang['suites_cases_title'] = 'Case Title: ';
$lang['suites_cases_toolbar_sorted'] = 'Sort:';
$lang['suites_cases_toolbar_display_deleted_cases'] = 'Display Deleted Test Cases';
$lang['suites_cases_toolbar_add_case'] = 'Add Case';
$lang['suites_cases_toolbar_add_section'] = 'Add Section';
$lang['suites_cases_toolbar_add_section_disabled_hint'] = 'Adding sections is only supported if the cases are grouped by sections.';
$lang['suites_cases_toolbar_delete_cases'] = 'Delete';
$lang['suites_cases_toolbar_delete_cases_desc'] = 'Delete the selected test cases.';
$lang['suites_cases_toolbar_delete_cases_confirm'] = 'Really mark all selected test cases as deleted?';
$lang['suites_cases_toolbar_edit_cases'] = 'Edit';
$lang['suites_cases_toolbar_edit_cases_selected'] = 'Edit selected';
$lang['suites_cases_toolbar_edit_cases_selected_hint'] = 'Edits all selected test cases.';
$lang['suites_cases_toolbar_edit_cases_group'] = 'Edit all in current view';
$lang['suites_cases_toolbar_edit_cases_group_hint'] = 'Edits the cases of the current section or group, respecting the current filter.';
$lang['suites_cases_toolbar_edit_cases_subtree_hint'] = 'Edits the cases of the current section or group (including subsections), respecting the current filter.';
$lang['suites_cases_toolbar_edit_cases_all'] = 'Edit all in filter';
$lang['suites_cases_toolbar_edit_cases_all_hint'] = 'Edits all cases of this test suite, respecting the current filter.';
$lang['suites_cases_toolbar_filter'] = 'Filter:';

$lang['suites_empty_title'] = 'This test suite doesn\'t contain any test cases, yet.';
$lang['suites_empty_title_master'] = 'There aren\'t any test cases, yet.';
$lang['suites_empty_body'] = 'There aren\'t any sections or test cases in this suite yet. Use the following buttons to create the first test case and section.';
$lang['suites_empty_body_master'] = 'There aren\'t any sections or test cases. Use the following buttons to create the first test case and section.';
$lang['suites_empty_nogrouping_body'] = 'There aren\'t any sections or test cases in this suite yet. Use the following button to create the first section.';
$lang['suites_empty_noaccess_body'] = 'There aren\'t any sections or test cases in this suite yet.
Unfortunately, you don\'t have the required permissions to add test cases or sections.
Please contact your administrator.';
$lang['suites_empty_expl_title'] = 'Test cases and sections?';
$lang['suites_empty_expl_body'] = 'A test case verifies a certain feature, functionality or requirement. Sections are used to organize related test cases into groups.';

$lang['suites_select_title'] = 'Select Cases';
$lang['suites_select_filter'] = 'Selection Filter';
$lang['suites_select_filter_set'] = 'Set Selection';
$lang['suites_select_filter_add'] = 'Add To Selection';
$lang['suites_select_filter_remove'] = 'Remove From Selection';
$lang['suites_select_filter_matches'] = '<strong>{0}</strong> {0?{test cases}:{test case}} matched.';
$lang['suites_select_empty'] = 'No test cases found.';

$lang['suites_overview_empty_title'] = 'This project doesn\'t contain any test suites, yet.';
$lang['suites_overview_empty_body'] = 'No test suites have been added to this project yet. Use the following button to add the first test suite.';
$lang['suites_overview_empty_noaccess_body'] = 'No test suites have been added to this project yet.
Unfortunately, you don\'t have the required permissions to add new test suites.
Please contact your administrator.';
$lang['suites_overview_empty_expl_title'] = 'What\'s a test suite?';
$lang['suites_overview_empty_expl_body'] = 'A test suite is a collection of test cases. Test suites are used to organize related test cases into groups and execute them at once.';

$lang['suites_dialogs_width'] = 'Width';
$lang['suites_dialogs_height'] = 'Height';
$lang['suites_dialogs_splitter'] = 'Splitter';

$lang['suites_runs_new'] = 'Add Test Run';

$lang['suites_runs_empty_title'] = 'There aren\'t any test runs for this suite, yet.';
$lang['suites_runs_empty_body'] = 'No test runs have been defined for this suite, yet. Use the following button to add your first test run.';
$lang['suites_runs_empty_noaccess_body'] = 'No test runs have been defined for this suite, yet.
Unfortunately, you don\'t have the required permissions to add test runs.
Please contact your administrator.';
$lang['suites_runs_empty_expl_title'] = 'What\'s a test run?';
$lang['suites_runs_empty_expl_body'] = 'Test runs let you execute the test cases of a test suite, enter test results and aggregate statistics about the tests.';

$lang['suites_print_hint'] = 'Print Suite';
$lang['suites_print_hint_single'] = 'Print Cases';
$lang['suites_print_hint_desc'] = 'Opens a print view of this test suite.';
$lang['suites_print_hint_desc_single'] = 'Opens a print view of this test case repository.';
$lang['suites_print_format'] = 'Print Format';
$lang['suites_export_hint'] = 'Export Suite';
$lang['suites_export_hint_single'] = 'Export Cases';
$lang['suites_export_hint_desc'] = 'Exports this test suite into different formats (XML, Excel/CSV).';
$lang['suites_export_hint_desc_single'] = 'Exports the sections and test cases into different formats (XML, Excel/CSV).';
$lang['suites_export_format'] = 'Format';
$lang['suites_export_section_include'] = 'Section Include';
$lang['suites_export_section_ids'] = 'Section IDs';
$lang['suites_export_columns'] = 'Columns';
$lang['suites_export_separator_hint'] = 'Separator Hint';
$lang['suites_export_separated_rows'] = 'Separated rows for separated steps';
$lang['suites_suite_not_empty'] = 'You are not allowed to delete suites with test cases (insufficient permissions).';
$lang['suites_section_not_empty'] = 'You are not allowed to delete sections with test cases (insufficient permissions).';

$lang['suites_import_hint'] = 'Import Cases';
$lang['suites_import_hint_desc'] = 'Imports sections and test cases from a TestRail XML or CSV file.';
$lang['suites_import'] = 'Import from XML';
$lang['suites_import_file'] = 'File';
$lang['suites_import_short'] = 'Import';
$lang['suites_import_file_desc'] = 'Choose the file to import. Must be a valid TestRail XML import file.
<a class="link" target="_blank" href="https://www.gurock.com/testrail/docs/user-guide/howto/import-xml">Learn more</a>';
$lang['suites_import_insert'] = 'Add new test cases';
$lang['suites_import_insert_desc'] = 'Test cases and sections from the XML file are imported as new test cases &amp; sections and are appended to this test suite.';
$lang['suites_import_update'] = 'Update existing test cases';
$lang['suites_import_update_desc'] = 'Existing test cases are updated. All test cases in the XML import file must reference valid test case IDs (via a &lt;id&gt; field).';
$lang['suites_import_error_db'] = 'A database error occurred while importing';
$lang['suites_import_error_required'] = 'The File field is required.';
$lang['suites_import_error_val'] = 'The file is not a valid TestRail XML import file';

$lang['suites_import_csv'] = 'Import from CSV';
$lang['suites_import_csv_submit'] = 'Import';
$lang['suites_import_csv_step1'] = 'Load File and Settings';
$lang['suites_import_csv_step1_file'] = 'File';
$lang['suites_import_csv_step1_file_desc'] = 'Choose the file to import. Must be a valid CSV file.
<a class="link" target="_blank" href="https://www.gurock.com/testrail/docs/user-guide/howto/import-csv">Learn more</a>';
$lang['suites_import_csv_step1_file_upload_success'] = 'CSV file uploaded successfully.';
$lang['suites_import_csv_step1_format'] = 'Format &amp; Mapping';
$lang['suites_import_csv_step1_format_create'] = 'Configure new mapping';
$lang['suites_import_csv_step1_format_load'] = 'Load mapping from configuration file';
$lang['suites_import_csv_step1_format_upload_success'] = 'Configuration file uploaded successfully.';
$lang['suites_import_csv_step1_advanced'] = 'Advanced Options';
$lang['suites_import_csv_step1_section'] = 'Import To';
$lang['suites_import_csv_step1_encoding'] = 'File Encoding';
$lang['suites_import_csv_step1_encoding_excel'] = ' &ndash; Excel default';
$lang['suites_import_csv_step1_encoding_googledocs'] = ' &ndash; Google Docs default';
$lang['suites_import_csv_step1_delimiter'] = 'CSV Delimiter';
$lang['suites_import_csv_step1_delimiter_desc'] = 'Usually , or ; or \\t (for tab)';
$lang['suites_import_csv_step1_rows_start'] = 'Start Row';
$lang['suites_import_csv_step1_rows_header'] = 'Is header row';
$lang['suites_import_csv_step1_no_columns'] = 'No columns found in the CSV file. Please check the start row and CSV delimiter.';
$lang['suites_import_csv_step2'] = 'Map Columns &amp; Row Layout';
$lang['suites_import_csv_step2_intro'] = 'TestRail analyzed the CSV file and found the following CSV columns.
Please configure the row layout (single row/multiple rows) and map the CSV columns to TestRail\'s fields.';
$lang['suites_import_csv_step1_template'] = 'Template';
$lang['suites_import_csv_step1_template_desc'] = 'Template for imported cases';
$lang['suites_import_csv_step2_rows'] = 'Row Layout';
$lang['suites_import_csv_step2_rows_single'] = 'Test cases use a single row';
$lang['suites_import_csv_step2_rows_multi'] = 'Test cases use multiple rows.
<a class="link" target="_blank" href="https://www.gurock.com/testrail/docs/user-guide/howto/import-csv">Learn more</a>';
$lang['suites_import_csv_step2_rows_multi_column'] = 'Column to detect new test cases:';
$lang['suites_import_csv_step2_mapping_column'] = 'CSV Column';
$lang['suites_import_csv_step2_mapping_field'] = 'TestRail Field';
$lang['suites_import_csv_step2_column'] = 'Column';
$lang['suites_import_csv_step2_rows_skip_notitle'] = 'Ignore test cases/records without a title (example: empty records at file end)';
$lang['suites_import_csv_step3'] = 'Map Values';
$lang['suites_import_csv_step3_intro'] = 'The next step is to map the CSV values to TestRail.
For example, if you have a priority value of <em>Medium</em> in your CSV file,
this step allows you to map this to a priority of <em>Low</em> or <em>Normal</em> in
TestRail.';
$lang['suites_import_csv_step3_values_removehtml'] = 'Remove HTML tags from CSV values';
$lang['suites_import_csv_step3_values_dateformat'] = 'Date Format';
$lang['suites_import_csv_step3_values_dateformat_sample'] = 'M/d/yyyy';
$lang['suites_import_csv_step3_values_dateformat_more'] =
	'<a class="link" target="_blank" href="https://www.gurock.com/testrail/docs/user-guide/howto/import-csv">Learn more</a>';
$lang['suites_import_csv_step3_values_empty'] = 'No values found for this column.';
$lang['suites_import_csv_step4'] = 'Preview Import';
$lang['suites_import_csv_step4_intro'] = 'TestRail found <strong class="text-softer">{0}</strong>
{0?{test cases}:{test case}} in the CSV file. Please review the first few cases before importing the CSV file.
You can go back with the <em>Previous</em> button to make changes to your
file settings and column or value mapping.';
$lang['suites_import_csv_step4_preview_empty'] = 'Empty';
$lang['suites_import_csv_step4_preview_case'] = 'Case {0}:';
$lang['suites_import_csv_step4_preview_default'] = 'Case {0}:';
$lang['suites_import_csv_step4_preview_more'] = 'And <strong class="text-softer">{0}</strong> more
{0?{test cases}:{test case}} test cases will be imported.';
$lang['suites_import_csv_step5'] = 'Imported Successfully';
$lang['suites_import_csv_step5_intro'] = 'Your CSV file was imported successfully!
TestRail added <strong class="text-softer">{0}</strong> {0?{sections}:{section}} and <strong class="text-softer">{1}</strong>
{1?{cases}:{case}}.';
$lang['suites_import_csv_step5_configuration'] =
'Download the <a id="{0}" href="javascript:void(0)">configuration file</a> of this
import for future imports.';

$lang['suites_import_sections_missing'] = 'No <sections> tag found.';
$lang['suites_import_sections_empty'] = 'No <section> tag found in <sections>.';
$lang['suites_import_sections_no_array'] = 'Invalid <section> tag found in <sections>.';
$lang['suites_import_section_no_name'] = 'No <name> tag found in <section>.';
$lang['suites_import_section_no_object'] = 'Section type in <sections> tag is not an object.';
$lang['suites_import_section_invalid'] = 'Found invalid section during import ("{0}"): {1}';
$lang['suites_import_cases_empty'] = 'No <case> tag found in <cases>.';
$lang['suites_import_case_no_title'] = 'No <title> tag found in <case>.';
$lang['suites_import_case_invalid'] = 'Found invalid test case during import ("{0}"): {1}';
$lang['suites_import_cases_no_object'] = 'Cases type in <section> tag is not an object.';
$lang['suites_import_cases_no_array'] = 'Invalid <cases> tag found in <section>.';
$lang['suites_import_case_update_no_id'] = 'Test case does not have an ID (<id> tag missing): "{0}".';
$lang['suites_import_case_update_id_invalid'] = 'Test case ID uses an invalid format ({0}).';
$lang['suites_import_case_update_no_case'] = 'Test case {0} does not exist.';
$lang['suites_import_case_update_different_suite'] = 'Test case {0} is from a different test suite and cannot be updated.';

$lang['suites_copycases'] = 'Copy or Move Cases';
$lang['suites_copycases_hint'] = 'Copy or Move Cases';
$lang['suites_copycases_hint_desc'] = 'Copies or moves sections and test cases from another test suite or project.';
$lang['suites_copycases_source'] = 'Source';
$lang['suites_copycases_source_required'] = 'The Source field is required.';
$lang['suites_copycases_sections_cases'] = 'Copy/move cases only';
$lang['suites_copycases_sections_sections'] = 'Also copy/move sections';
$lang['suites_copycases_sections_sections_all'] = 'Also copy/move sections + all parents';
$lang['suites_copycases_appendto'] = 'Append To:';
$lang['suites_copycases_intro'] = 'Please select a test suite.';
$lang['suites_copycases_cases_required'] = 'Please select at least one test case.';
$lang['suites_copycases_select'] = 'Select';
$lang['suites_copycases_select_all'] = 'All';
$lang['suites_copycases_select_none'] = 'None';
$lang['suites_copycases_invalid'] = 'Invalid arguments for copy/move cases (e.g., some cases no longer exist). Please refresh this page and try again.';
$lang['suites_copycases_self_doc'] = 'Copy or move test cases within the same suite via drag&amp;drop:';
$lang['suites_copycases_self_doc_1'] = 'Move test cases via drag&amp;drop';
$lang['suites_copycases_self_doc_2'] = 'Hold the shift key to copy test cases instead';
$lang['suites_copycases_self_doc_3'] = 'Copy or move sections in the sidebar';
$lang['suites_copycases_move_confirm'] = 'Moving the test cases will remove all their test results in active test runs (test results are not moved). This cannot be undone. Continue?';
$lang['suites_copycases_move_confirm_checkbox'] = 'Yes, move all selected cases (cannot be undone)';

$lang['suites_fallback_copy_section'] = 'Copied Test Cases';
$lang['suites_fallback_move_section'] = 'Moved Test Cases';

$lang['suites_tree_tests_not_displayed'] = '{0} more {0?{cases}:{case}} available.
Switch to <a href="{1}">compact view</a> to see all cases.';

$lang['suites_view_page_type'] = 'Page Type';
$lang['suites_view_print_format'] = 'Print View Type';

$lang['system_version_mismatch'] = 'Your installation was updated to TestRail {0} but this page still runs the previous version. Please refresh this page.';

$lang['system_install_required'] = 'The installation of your TestRail installation has not been finished. Please contact a TestRail administrator to finish the installation process.';

$lang['system_update_required'] = 'A TestRail update has been installed but the database hasn\'t been updated yet. Please contact a TestRail administrator to run the database update.';
$lang['system_update_hosted'] = 'The database of your hosted TestRail installation is too old but cannot be updated manually.';
$lang['system_db_newer'] = 'Your TestRail installation requires an older database version (version {0} or less required, but found {1}). Please install the TestRail version that matches your database version or contact the Gurock Software support in case you have any questions.';

$lang['system_js_test'] = 'JavaScript Test';
$lang['system_page_initial'] = 'Initial Load';
$lang['system_env_na_hosted'] = 'This endpoint or API function is not supported on this TestRail platform (Hosted/Cloud).';
$lang['system_env_na_server'] = 'This endpoint or API function is not supported on this TestRail platform (Server).';

$lang['system_updated_by'] = 'Updated By';
$lang['system_updated_on'] = 'Updated On';
$lang['system_force_update'] = 'Force Update';

$lang['system_browser_title'] = 'Your browser is not supported';
$lang['system_browser_header'] = 'Sorry, your browser is not supported.';
$lang['system_browser_intro'] = 'TestRail is a modern web application and uses the latest technology.
Unfortunately, your browser is a bit outdated and not supported by TestRail.
Please upgrade to a modern web browser such as Chrome, Firefox, Safari or newer versions of
Internet Explorer (10 or later).';
$lang['system_browser_show_ua'] = 'Show my browser information';

#Your TestRail license will expire on <date>. Please contact a TestRail administrator or extend your license by contacting the Gurock Software support team for a quote.
$lang['system_license_expires_enterprise'] = 'Your TestRail license will expire on <strong class="text-softer">{0}</strong>.
Please contact a TestRail administrator or extend your license by contacting the 
<a target="_blank" href="https://secure.gurock.com/customers/support/">Gurock Software support team</a> for a quote.';

$lang['system_license_expires'] = 'Your TestRail license will expire on <strong class="text-softer">{0}</strong>.
Please contact a TestRail administrator or extend your license with your
<a target="_blank" href="https://secure.gurock.com/customers/portal/licenses/">Gurock Software customer account</a>.';
$lang['system_license_nosupport'] = '<strong>Your current license key indicates that your support plan has expired on {0}</strong>.
You are not eligible to install new version or update to the new version and please <a href="https://secure.gurock.com/portal/" target="_blank">renew your support plan</a>.
If you\'ve already renewed the support plan, please make sure to apply the new license key.';
$lang['system_lock_page_title'] = 'TestRail instance is locked';
$lang['system_lock_page_description'] = '<strong>Your current license key indicates that your support plan has expired on {0}</strong>.
Please <a href="https://secure.gurock.com/portal/" target="_blank">renew your support plan</a>.
If you\'ve already renewed the support plan, please make sure to apply the new license key.';

$lang['task_another_instance'] = 'Another task instance is still running.';

$lang['templates_template'] = 'Template';
$lang['templates_name'] = 'Name';
$lang['templates_name_desc'] = 'Ex: <em>Test Case (Steps)</em>, <em>Exploratory Session</em> or <em>Automated</em>';

$lang['templates_isdefault'] = 'This template is the default template';
$lang['templates_isdefault_desc'] = 'The default template is the pre-selected template for new
cases and the fallback when you delete other templates. Only one template can be selected
as the default.';

$lang['templates_include'] = 'Include All';
$lang['templates_include_all'] = 'This template applies to all projects';
$lang['templates_include_all_desc'] = 'Select this option to use this template with all projects (including future projects).';
$lang['templates_include_specific'] = 'This template applies to the following projects only';
$lang['templates_include_specific_desc'] = 'You can alternatively select the projects this template should apply to.
This is useful to limit a template to select projects.';
$lang['templates_projects'] = 'Projects';

$lang['templates_validation_projects'] = 'Please select at least one project or use the global option.';
$lang['templates_validation_projects_default'] = 'The default template needs to apply to all projects.';

$lang['templates_errors_no_default'] = 'No default template found.';
$lang['templates_errors_is_default'] = 'The template is the default template and cannot be deleted.';

$lang['templates_add'] = 'Add Template';
$lang['templates_save'] = 'Save Template';
$lang['templates_delete_confirm'] = 'Really delete template <strong>{0}</strong>? Cases with this template will be assigned the default template.';
$lang['templates_delete_confirm_checkbox'] = 'Yes, delete this template (cannot be undone)';

$lang['templates_success_add'] = 'Successfully added the new template.';
$lang['templates_error_default'] = 'Deleting the default template is not allowed.';
$lang['templates_success_update'] = 'Successfully updated the template.';
$lang['templates_success_delete'] = 'Successfully deleted the template.';

$lang['templates_fields'] = 'Show fields that apply to this template';
$lang['template_id'] = 'Template Id';
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

$lang['todos_overview_runs'] = 'Test Runs';
$lang['todos_overview_tests'] = 'Tests';
$lang['todos_overview_cases'] = 'Test Cases';
$lang['todos_overview_runs_unassigned'] = '{0} unassigned';
$lang['todos_overview_runs_no_milestone'] = 'No Milestone';
$lang['todos_overview_runs_no_plan'] = 'No Test Plan';

$lang['todos_overview_display'] = 'Display';
$lang['todos_overview_display_tree'] = 'Show all todos.';
$lang['todos_overview_display_compact'] = 'Show a single group only.';

$lang['todos_overview_filter'] = 'User Filter';
$lang['todos_overview_filter_me'] = 'Me';
$lang['todos_overview_filter_all'] = 'All';
$lang['todos_overview_filter_none'] = 'None';
$lang['todos_overview_filter_ok'] = 'Apply Filter';
$lang['todos_overview_filter_user_ok'] = 'User Filter';
$lang['todos_overview_filter_runsby'] = 'Runs By';
$lang['todos_overview_filter_users'] = 'Users';
$lang['todos_overview_filter_statuses'] = 'Statuses';
$lang['todos_overview_filter_milestone'] = 'Milestone';
$lang['todos_overview_filter_unassigned'] = 'Show unassigned tests in chart';
$lang['todos_overview_filter_unassigned_field'] = 'Show Unassigned';

$lang['todos_overview_toolbar_grouped'] = 'Group by:';
$lang['todos_overview_toolbar_filter'] = 'Filter:';
$lang['todos_overview_toolbar_grouped_reset'] = 'Reset grouping';
$lang['todos_overview_toolbar_filter_reset'] = 'Reset filter to default.';
$lang['todos_overview_chart_todos_active'] = 'Active';
$lang['todos_overview_chart_todos_upcoming'] = 'Upcoming';
$lang['todos_overview_chart_todos_completion_pending'] = 'Completion Pending';
$lang['todos_overview_chart_todos_test_cases'] = 'Test Cases';
$lang['todos_overview_chart_notodos'] = 'The following users have no todos:';
$lang['todos_overview_chart_notodos_plus'] = '(+{0} other {0?{users}:{user}})';

$lang['todos_overview_empty_title'] = 'There aren\'t any todos for the current filter';
$lang['todos_overview_empty_body'] = 'No test runs found with todos for the current filter. You can try to <a {0}>reset the filter</a>.';

$lang['uiscripts_invalid_header'] = 'Line {0} uses an invalid format ("name: value" expected).';
$lang['uiscripts_invalid_regex'] = 'Line "{0}" uses an invalid regular expression.';
$lang['uiscripts_invalid_code'] = 'No code section specified (use "js:" or "css:").';
$lang['uiscripts_duplicate_header'] = 'Duplicate name "{0}" in header.';
$lang['uiscripts_duplicate_language'] = 'Duplicate code section for language "{0}".';
$lang['uiscripts_no_name'] = 'Name missing ("name") in script description.';

$lang['uiscripts_success_add'] = 'Successfully added the new UI script.';
$lang['uiscripts_success_update'] = 'Successfully updated the UI script.';
$lang['uiscripts_success_delete'] = 'Successfully deleted the UI script.';

$lang['uiscripts_add'] = 'Add UI Script';
$lang['uiscripts_save'] = 'Save UI Script';
$lang['uiscripts_save_and_continue'] = 'Save &amp; Continue Editing';
$lang['uiscripts_delete_confirm'] = 'Really delete UI script <strong>{0}</strong>? Note that this cannot be undone.';

$lang['uiscripts_uiscript'] = 'UI Script';
$lang['uiscripts_empty'] = 'No UI scripts.';
$lang['uiscripts_config'] = 'Configuration';
$lang['uiscripts_config_desc'] = 'Enter or paste the configuration and source code for the UI script.
The script can contain JavaScript or CSS code to customize your TestRail installation.
<a class="link" target="_blank" href="https://www.gurock.com/testrail/docs/customization/ui-scripts/introduction">Learn more</a>';
$lang['uiscripts_isactive'] = 'This UI script is active';
$lang['uiscripts_status'] = 'Status';
$lang['uiscripts_status_active'] = 'Active';
$lang['uiscripts_status_inactive'] = 'Inactive';
$lang['uiscripts_isactive_desc'] = 'Only active UI scripts are included on the TestRail pages for your
installation.';
$lang['uiscripts_disabled'] = 'Your UI scripts were temporarily disabled';
$lang['uiscripts_disabled_desc'] =
'Your UI scripts were disabled as part of the update to TestRail 4.0 or later.
TestRail 4.0 comes with major changes to TestRail\'s user interface and HTML/CSS code.
Please make sure to review your UI scripts for possible compatibility issues and update
them as needed before enabling them again.';

$lang['uiscripts_template'] = "name: Hello world
description: Shows a 'Hello, world!' message on the dashboard
author: Gurock Software
version: 1.0
includes: ^dashboard
excludes:

js:
$(document).ready(
	function() {
		alert('Hello, world!');
	}
);

css:
div.some-class {
}";
$lang['update_title'] = 'TestRail Update Wizard';
$lang['update_intro'] = 'To complete the TestRail update, some database changes are required.
This wizard helps you to update your TestRail database to the new version. Please make a
backup of your TestRail installation and database, review the following settings and click
the Update button to proceed.';
$lang['update_cassandra_intro'] = 'To complete the TestRail update, some changes are required.
This release introduces Cassandra for storing attachments. This wizard helps you to set up your Cassandra database.
Please make a backup of your TestRail installation and database, fill the following fields and click
the Update button to proceed.';

$lang['update_attachment_migration_status'] = 'Migration status';
$lang['update_attachment_migrate_intro'] = 'We are migrating your attachments. Please wait until the process finishes.';
$lang['update_attachment_migrate_to_database_in_progress_intro'] = 'We are migrating your attachments from Cassandra to filesystem. Please wait until the process finishes.';
$lang['update_attachment_migrate_to_database_intro'] = 'We are going to migrate your attachments from Cassandra to filesystem.';
$lang['update_attachment_migration_status_scheduled'] = 'Scheduled';
$lang['update_attachment_migration_status_migrating_attachments'] = 'Migrating attachments';
$lang['update_attachment_migration_status_migrating_entities'] = 'Migrating entities';
$lang['update_attachment_migration_status_done'] = 'Done';

$lang['update_confirm'] = 'Confirm Update';
$lang['update_confirm_desc'] = 'This update requires major changes to your database. Please take
the time to create a backup of your installation and database.';
$lang['update_confirm_intro'] = 'This update requires major changes to your database.
Please <a href="https://www.gurock.com/testrail/docs/admin/server/backup" target="_blank">make a backup</a> of your current installation before proceeding and confirm it by writing <strong><em>Yes, I made a backup</em></strong> into the textbox.
You can also consider testing this update on a <a href="https://www.gurock.com/testrail/docs/admin/server/staging" target="_blank">staging server</a> first before applying it to your production installation.';
$lang['update_confirm_required'] = 'Please take the time to create a backup and confirm it.';

$lang['update_step'] = 'Update Step';
$lang['update_from'] = 'Update From';
$lang['update_to'] = 'Update To';
$lang['update_version_app'] = 'TestRail version';
$lang['update_version_cur_db'] = 'Your database version';
$lang['update_version_new_db'] = 'New database version';
$lang['update_version_cur_cassandra'] = 'Your Cassandra version';
$lang['update_version_new_cassandra'] = 'New Cassandra version';

$lang['update_filecheck'] = 'Checking installation files';

$lang['update_license'] = 'License Key';
$lang['update_license_error'] = '<strong>There is a problem with your current TestRail license:</strong> {0}
You are not eligible to update to the new version until you enter a new license key.
<br /><br />
<div class="button-group">
<a class="button button-left button-login" {1}>Update License Key</a>
</div>';
$lang['update_license_invalid'] = 'Invalid or missing license.';
$lang['update_license_nosupport'] = '<strong>Your current license key indicates that your support plan has expired on {0}</strong>.
You are not eligible to update to the new version and please <a href="https://secure.gurock.com/portal/" target="_blank">renew your support plan</a>.
If you\'ve already renewed the support plan, please make sure to apply the new license key.
<br /><br />
<div class="button-group">
<a class="button button-left button-login" {1}>Update License Key</a>
</div>';
$lang['update_license_dialog'] = 'Update License';
$lang['update_license_dialog_key'] = 'License Key';
$lang['update_license_dialog_key_desc'] = 'Your trial or full TestRail license key.';
$lang['update_license_dialog_save'] = 'Save License Key';

$lang['update_backup'] = '<strong>Please note:</strong> In order to complete the TestRail update,
this wizard needs to make changes to your database. It is strongly recommended to
<a href="https://www.gurock.com/testrail/docs/admin/server/backup" target="_blank">make a backup</a>
of your TestRail installation and database before proceeding.';
$lang['update_support'] = 'If you have any questions about this update, please contact the
<a href="http://www.gurock.com/support/" target="_blank">Gurock Software support</a>.';

$lang['update_result'] = 'Please see below for the result of the update and the next steps.';
$lang['update_success'] = 'Congratulations, all update steps were performed successfully and you
have fully updated your TestRail installation to the new database version. You can now return
to TestRail.';
$lang['update_success_back'] = 'Back to TestRail';

$lang['update_nosteps'] = 'Your TestRail installation and database were already up-to-date.
No updates were installed.';

$lang['update_result_step'] = 'Updating to database version {0}';
$lang['downgrade_result_step'] = 'Downgrading to database version {0}';
$lang['update_result_success'] = 'Success';
$lang['update_result_error'] = 'Error';
$lang['update_result_details'] = '(details below)';

$lang['update_result_error_desc'] = 'Please return to the previous wizard page to adjust your settings
and try the update again. If you are unsure on how to solve this problem, please contact
the <a href="http://www.gurock.com/support/" target="_blank">Gurock Software support</a>.
Please make sure to include the full error message in your support request.';

$lang['update_error_step_too_low'] = 'Update {0} was already applied. Your database version is {1}/{2}.';
$lang['update_error_step_too_high'] = 'Update {0} does not exist. Your database version is {1}/{2}.';
$lang['update_error_too_old_db'] = 'Database is too old for running migrations';
$lang['update_dbversion_migrations_missing'] = 'The instance does not have db/migrations folder needed for downgrade';
$lang['update_migration_failed'] = 'Migration failed with the error:
{0}';

$lang['update_error_updatefile'] = 'Couldn\'t open database update file "{0}".';
$lang['update_error_queryfailed'] = 'The following database query failed with the error
"{0}": {1}';

$lang['update_cli_db_newer'] = 'Your TestRail installation requires an older database version (version {0} or less required, but found {1}). Please make sure to use the TestRail version that matches your database version or contact the Gurock Software support in case you have any questions.';
$lang['update_cli_db_matches'] = 'Your TestRail database is up-to-date (version {0}).';
$lang['update_cli_db_older'] = 'Your TestRail installation requires a database update (from version {0} to {1}). Please take the time to create a backup of your database before running the update.
Continue? - Cancel with Ctrl+C, confirm with Enter .. ';
$lang['update_cli_db_upgraded'] = 'Successfully upgraded your TestRail database to the latest version ({0}).';
$lang['update_cli_db_updating'] = 'Applying update {0} .. ';
$lang['update_cli_db_upgraded'] = 'Successfully upgraded your TestRail database to the latest version ({0}).';
$lang['update_cli_license_error'] = 'There is a problem with your current TestRail license: {0} Please update the license key of your TestRail installation via the web interface to continue with the update.';
$lang['update_cli_license_invalid'] = 'Invalid or missing license.';
$lang['update_cli_license_nosupport'] = 'Your current license key indicates that your support plan has expired on {0}. You are not eligible to update to the new version and please renew your support plan. If you\'ve already renewed the support plan, please make sure to apply the new license key via TestRail\'s web interface.';

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

$lang['validate_id'] = 'Field {0} is not a valid ID.';
$lang['validate_role'] = 'Field {0} is not a valid role.';
$lang['validate_user'] = 'Field {0} is not a valid user.';
$lang['validate_users'] = 'Field {0} contains one or more invalid user IDs.';
$lang['validate_user_active'] = 'Field {0} is not a valid active user.';
$lang['validate_user_admin'] = 'Field {0} is not a valid administrator.';
$lang['validate_group'] = 'Field {0} is not a valid user group.';
$lang['validate_no_parent'] = 'Missing parent ID in object hierarchy for field {0}.';
$lang['validate_milestone'] = 'Field {0} is not a valid milestone.';
$lang['validate_project'] = 'Field {0} is not a valid or accessible project.';
$lang['validate_project_parent'] = 'Field {0} does not have a valid or accessible parent project.';
$lang['validate_field'] = 'Field {0} is not a valid custom field.';
$lang['validate_suite'] = 'Field {0} is not a valid test suite.';
$lang['validate_suite_parent'] = 'Field {0} does not have a valid parent test suite.';
$lang['validate_section'] = 'Field {0} is not a valid section.';
$lang['validate_section_parent'] = 'Field {0} does not have a valid parent section.';
$lang['validate_status'] = 'Field {0} is not a valid status.';
$lang['validate_status_no_untested'] = 'Field {0} uses an invalid status (Untested).';
$lang['validate_status_no_active'] = 'Field {0} uses an inactive status.';
$lang['validate_case'] = 'Field {0} is not a valid test case.';
$lang['validate_case_ids'] = 'Field {0} contains unrecognized case IDs.';
$lang['validate_case_type'] = 'Field {0} is not a valid case type.';
$lang['validate_priority'] = 'Field {0} is not a valid priority.';
$lang['validate_case_status'] = 'Field {0} is not a valid case status.';
$lang['validate_uiscript'] = 'Field {0} is not a valid UI script.';
$lang['validate_export'] = 'Field {0} is not a valid export.';
$lang['validate_test'] = 'Field {0} is not a valid test.';
$lang['validate_test_change'] = 'Field {0} is not a valid test result or comment.';
$lang['validate_attachment'] = 'Field {0} is not a valid attachment.';
$lang['validate_report'] = 'Field {0} is not a valid report.';
$lang['validate_run'] = 'Field {0} is not a valid test run.';
$lang['validate_run_parent'] = 'Field {0} does not have a valid parent test run.';
$lang['validate_plan'] = 'Field {0} is not a valid test plan.';
$lang['validate_plan_entry'] = 'Field {0} is not a valid test plan entry.';
$lang['validate_config'] = 'Field {0} is not a valid configuration.';
$lang['validate_config_group'] = 'Field {0} is not a valid configuration group.';
$lang['validate_config_group_parent'] = 'Field {0} does not have a valid parent configuration group.';
$lang['validate_template'] = 'Field {0} is not a valid template.';
$lang['validate_template_project'] = 'Field {0} is not a valid template for the project.';
$lang['validate_shared_step'] = 'Field {0} is not a valid shared test step.';
$lang['delete_run_plan_denied'] = 'Field: run_id is not part of a test run. Please use delete_run instead.';
$lang['delete_run_plan_entry_denied'] = 'Field :run_id is not part of a test run. Please use delete_plan_entry instead.';
$lang['validate_section_move'] = 'Invalid parent_id or after_id. All section IDs must exist and be in the same project and suite. The parent_id may not be a child section of the section being moved.';

$lang['webhooks_more'] = 'More on Webhooks';
$lang['webhook_enterprise_title'] = 'Connect real-time with you favourite apps with <span style="color:#fcc200">Webhooks</span>';
$lang['webhook_enterprise_text'] = 'Implementing a webhooks capbility for our Enterprise customers means that they will be able to integrate with many more tools and much more flexibility that is currently the case and will move us towards a more hub-like test case management solution.';
