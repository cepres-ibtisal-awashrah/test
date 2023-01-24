<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

$lang['reports_ps_meta_label'] = 'Project';
$lang['reports_ps_meta_group'] = 'Summary';
$lang['reports_ps_meta_summary'] = 'Shows a status summary and overview for the project.';
$lang['reports_ps_meta_description'] = 'Shows a summary and overview for the project. Please see the Report Options section below to configure the report specific options.';

$lang['reports_ps_form_details'] = 'Details';
$lang['reports_ps_form_history'] = 'History';
$lang['reports_ps_form_activity'] = 'Activity';

$lang['reports_ps_form_details_include'] = 'Include the following additional sections:';
$lang['reports_ps_form_details_include_activity'] = 'Activity (results over time)';
$lang['reports_ps_form_details_include_history'] = 'History and project events';

$lang['reports_ps_form_milestones'] = 'Include the following milestones:';
$lang['reports_ps_form_milestones_active'] = 'Open milestones';
$lang['reports_ps_form_milestones_completed'] = 'Completed milestones';
$lang['reports_ps_form_milestones_limit'] = 'Maximum number to display:';

$lang['reports_ps_form_runs'] = 'Include the following test runs &amp; plans:';
$lang['reports_ps_form_runs_active'] = 'Open runs &amp; plans';
$lang['reports_ps_form_runs_completed'] = 'Completed runs &amp; plans';
$lang['reports_ps_form_runs_limit'] = 'Maximum number to display:';

$lang['reports_ps_title'] = 'Project: {0}';

$lang['reports_ps_milestones'] = 'Milestones';
$lang['reports_ps_milestones_info'] = 'Shows the milestones of the project.';
$lang['reports_ps_milestones_active'] = 'Open';
$lang['reports_ps_milestones_active_empty'] = 'No open milestones found.';
$lang['reports_ps_milestones_completed'] = 'Completed';
$lang['reports_ps_milestones_completed_empty'] = 'No completed milestones found.';
$lang['reports_ps_milestones_more'] = 'There {0?{are}:{is}} {0} more completed {0?{milestones}:{milestone}} that {0?{are}:{is}} not included.';
$lang['reports_ps_milestones_stats'] = 'The chart displays the aggregated statistics for all open milestones.';

$lang['reports_ps_runs'] = 'Test Runs &amp; Plans';
$lang['reports_ps_runs_info'] = 'Shows the test runs and plans of the project.';
$lang['reports_ps_runs_active_empty'] = 'No open test runs found.';
$lang['reports_ps_runs_active'] = 'Open';
$lang['reports_ps_runs_completed_empty'] = 'No completed test runs found.';
$lang['reports_ps_runs_completed'] = 'Completed';
$lang['reports_ps_runs_more'] = 'There {0?{are}:{is}} {0} more completed {0?{test runs}:{test run}} that {0?{are}:{is}} not included.';
$lang['reports_ps_runs_stats'] = 'The chart displays the aggregated statistics for all open test runs &amp; plans.';

$lang['reports_ps_history'] = 'History';
$lang['reports_ps_history_info'] = 'Shows the history of the project such as events for creating, closing or deleting test runs.';
$lang['reports_ps_history_empty'] = 'No history found for the selected time frame.';
$lang['reports_ps_history_more'] = 'Only showing the latest {0} history events. There are more events that are not displayed.';

$lang['reports_ps_activity'] = 'Activity';
$lang['reports_ps_activity_info'] = 'Shows the activity (test results and comments) for the test runs of the project.';
$lang['reports_ps_activity_empty'] = 'No activity found for the time frame and statuses.';
$lang['reports_ps_activity_more'] = 'Only showing the latest {0} activities. There are more test results and comments that are not displayed.';
