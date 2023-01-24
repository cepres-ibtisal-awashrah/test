<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

if (defined('DEPLOY_OPTIMIZE_LANG') && DEPLOY_OPTIMIZE_LANG) {
	$config['files'] = [
		'all',
		'sys'
	];
} else {
	$config['files'] = [
		'activities',
		'apiv2',
		'admin',
		'attachments',
		'auth',
		'bulk_update',
		'burndown',
		'cases',
		'case_types',
		'columns',
		'configs',
		'charts',
		'dashboard',
		'defects',
		'dump',
		'email',
		'editor',
		'export_csv',
		'ext',
		'fields',
		'filters',
		'forms',
		'goals',
		'groups',
		'help',
		'layout',
		'import_csv',
		'install',
		'jira',
		'jira_auth',
		'assembla_auth',
		'jobs',
		'master',
		'milestones',
		'mysettings',
		'notification',
		'pages',
		'pagination',
		'plans',
		'priorities',
		'product',
		'projects',
		'references',
		'report_plugins',
		'reports',
		'roles',
		'runs',
		'search',
		'settings',
		'suites',
		'stats',
		'statuses',
		'system',
		'sys', // Gizmo system file
		'task',
		'templates',
		'tests',
		'todos',
		'uiscripts',
		'update',
		'users',
		'validate',
		'banner',
		'links',
		'oauth',
		'shared_steps',
		'case_statuses',
		'webhooks'
	];
}
