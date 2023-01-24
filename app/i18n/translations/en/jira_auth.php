<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

$lang['jira_auth_title'] = 'Confirm Integration';
$lang['jira_auth_intro'] = 'Please confirm the integration between TestRail and JIRA.
Continue with the integration and generate an integration key?';
$lang['jira_auth_intro_fineprint'] = 'Note that this will revoke any previous integration keys you have generated.';
$lang['jira_auth_generate'] = 'Generate Key';
$lang['jira_auth_token_before'] = 'Successfully generated the following integration key:';
$lang['jira_auth_token_after'] = 'Please enter this key in JIRA as part of the TestRail add-on configuration to finish the integration.';
$lang['jira_auth_noadmin'] = 'You need administrator access to TestRail to generate an integration key.
Please contact your IT or TestRail administrator to finish the integration between JIRA and TestRail.';
