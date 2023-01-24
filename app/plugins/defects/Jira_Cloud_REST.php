<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

require_once APPPATH . 'plugins/defects/Jira_REST.php';

/**
 * @inheritdoc
 */
class Jira_Cloud_REST_defect_plugin extends Jira_REST_defect_plugin
{
	public $userKey = 'email';
	public $secretKey = 'token';

	protected static $_meta_defects = array(
		'author' => 'Gurock Software',
		'version' => '1.0',
		'description' => 'JIRA defect plugin for TestRail',
		'can_push' => true,
		'can_lookup' => true,
		'default_config' =>
			'; Please configure your JIRA connection below.
;
; Note: requires JIRA Cloud. You can use the \'JIRA REST\'
; for Server versions or \'JIRA SOAP\' defect plugin
; for older versions.
[connection]
address=https://<your-server>/
email=testrail
token=secret

[push.fields]
summary=on
project=on
issuetype=on
components=on
assignee=on
priority=on
affects_version=on
sprint=on
epic=on
fix_version=off
estimate=off
labels=off
environment=off
parent=off
linktype=off
links=off
description=on
attachments=on

[hover.fields]
summary=on
project=on
issuetype=on
status=on
components=on
assignee=on
priority=on
affects_version=on
sprint=on
epic=on
fix_version=off
estimate=off
labels=off
environment=off
parent=off
linktype=off
links=off
description=on
');

	protected static $_meta_references = array(
		'author' => 'Gurock Software',
		'version' => '1.0',
		'description' => 'JIRA reference plugin for TestRail',
		'can_push' => false, // Lookup only
		'can_lookup' => true,
		'default_config' =>
			'; Please configure your JIRA connection below.
;
; Note: requires JIRA Cloud. You can use the \'JIRA REST\'
; for Server versions or \'JIRA SOAP\' defect plugin
; for older versions.
[connection]
address=https://<your-server>/
email=testrail
token=secret

[hover.fields]
summary=on
project=on
issuetype=on
status=on
components=on
assignee=on
priority=on
affects_version=on
sprint=on
epic=on
fix_version=off
estimate=off
labels=off
environment=off
parent=off
linktype=off
links=off
description=on
');
}
