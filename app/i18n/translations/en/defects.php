<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

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
