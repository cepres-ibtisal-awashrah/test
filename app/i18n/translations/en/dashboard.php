<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
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
