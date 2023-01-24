<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

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
