<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

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
