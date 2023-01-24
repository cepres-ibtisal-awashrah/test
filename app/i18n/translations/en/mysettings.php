<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
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
