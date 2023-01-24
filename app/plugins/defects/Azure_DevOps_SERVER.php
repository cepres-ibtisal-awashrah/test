<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

require_once APPPATH . 'plugins/defects/Azure_DevOps_CLOUD.php';
/**
 * Azure DevOps Server Defect Plugin for TestRail
 *
 * Copyright Gurock Software GmbH. All rights reserved.
 *
 * This is the TestRail defect plugin for Azure DevOps Server. Please see
 * http://docs.gurock.com/testrail-integration/defects-plugins for
 * more information about TestRail's defect plugins.
 *
 * http://www.gurock.com/testrail/
 *
 */
class Azure_DevOps_SERVER_defect_plugin extends Azure_DevOps_CLOUD_defect_plugin
{
	private $_pushDefaultFields = [
		'title' => 'on',
		'item_type' => 'on',
		'assignee' => 'off',
		'priority' => 'on',
		'description' => 'on'
	];

	protected static $_meta_defects = [
		'author' => 'Gurock Software',
		'version' => '1.0',
		'description' => 'Azure DevOps/TFS defect plugin for TestRail. REQUIRES TFS 2015 or later.',
		'can_push' => true,
		'can_lookup' => true,
		'default_config' =>
			'; Please configure your Azure DevOps connection below
; You may need to create a personal access token to use as your password
; https://docs.microsoft.com/en-us/azure/devops/organizations/accounts/use-personal-access-tokens-to-authenticate?view=azure-devops
[connection]
address=http://<server>/<collection>
project=<your-project>
user=testrail
password=secret

[push.types]
Bug=on
Epic=off
Issue=on
Task=on
UserStory=off

;Title and Item Type are required
;Assignee is not supported
[push.fields]
title=on
item_type=on
reason=off
created_by=off
priority=on
severity=on
description=on
repro_steps=on
system_info=on

;Define default field for summary details
[type.settings.Bug]
description=off
repro_steps=default
system_info=on

[type.settings.Issue]
description=default
repro_steps=off
system_info=off

[type.settings.Task]
description=default
repro_steps=off
system_info=off

;Title, Issue Type, and State will always be included
;Assignee is supported in hover
[hover.fields]
reason=off
assignee=on
created_by=off
priority=on
severity=on
description=on
repro_steps=on
system_info=on
acceptance_criteria=on
'];

protected static $_meta_references = [
	'author' => 'Gurock Software',
	'version' => '1.0',
	'description' => 'Azure DevOps defect plugin for TestRail',
	'can_lookup' => true,
	'default_config' =>
		'; Please configure your Azure DevOps connection below
; You may need to create a personal access token to use as your password
; https://docs.microsoft.com/en-us/azure/devops/organizations/accounts/use-personal-access-tokens-to-authenticate?view=azure-devops
[connection]
address=http://<server>/<collection>/
project=<your-project>
user=testrail
password=secret

;Title, Issue Type, and State will always be included
;Assignee is supported
[hover.fields]
reason=off
assignee=on
created_by=off
priority=on
severity=on
description=on
repro_steps=on
system_info=on
acceptance_criteria=on
'];

	/**
	 * Get Meta
	 *
	 * Expected to return meta data for this plugin such as Author,
	 * Version, Description and supported plugin capabilities.
	 *
	 * @return array
	 */
	public function get_meta(): array
	{
		return $this->get_type() === GI_INTEGRATION_TYPE_REFERENCES
            ? static::$_meta_references
            : static::$_meta_defects;
	}
}
