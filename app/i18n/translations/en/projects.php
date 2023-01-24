<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

$lang['projects_project'] = 'Project';
$lang['projects_noaccess'] = 'The requested project does not exist or you do not have the permissions to access it.';
$lang['projects_empty'] = 'No projects.';

$lang['projects_denied_add'] = 'You are not allowed to add projects (requires administrator privileges).';
$lang['projects_denied_edit'] = 'You are not allowed to edit projects (requires administrator privileges).';
$lang['projects_denied_delete'] = 'You are not allowed to delete projects (requires administrator privileges).';

$lang['projects_overview_title'] = 'Project Overview';
$lang['projects_overview_activity'] = 'Activity';
$lang['projects_overview_results'] = 'Test Changes';
$lang['projects_overview_history'] = 'History';
$lang['projects_overview_milestones'] = 'Milestones';
$lang['projects_overview_runs'] = 'Test Runs';
$lang['projects_overview_todos'] = 'Todos';
$lang['projects_overview_cases'] = 'Test Cases';
$lang['projects_overview_suites'] = 'Test Suites';
$lang['projects_overview_reports'] = 'Reports';

$lang['projects_overview_tests_empty'] = 'No activity yet.';
$lang['projects_overview_history_empty'] = 'No entries yet.';

$lang['projects_overview_sidebar_actions'] = 'Actions';
$lang['projects_overview_sidebar_actions_desc'] = 'Create a new milestone, test suite or test run.';
$lang['projects_overview_sidebar_actions_desc_noruns'] = 'Create a new milestone or test suite.';
$lang['projects_overview_sidebar_todos'] = 'Todos';
$lang['projects_overview_sidebar_todos_desc'] = 'Test runs with open tests assigned to you.
<a href="{0}">See all todos</a>';
$lang['projects_overview_sidebar_todos_empty'] = 'None.';

$lang['projects_runreport'] = 'Reports';
$lang['projects_reports_defects'] = 'Defects';
$lang['projects_reports_defects_summary'] = 'Summary';
$lang['projects_reports_defects_summary_hint'] = 'Shows a summary of found defects for this project.';
$lang['projects_reports_defects_cases_summary'] = 'Summary for Cases';
$lang['projects_reports_defects_cases_summary_hint'] = 'Shows a summary of found defects per test case &amp; test.';
$lang['projects_reports_defects_references_summary'] = 'Summary for References';
$lang['projects_reports_defects_references_summary_hint'] = 'Shows a summary of found defects for the references (requirements, user stories, etc.) in this project.';

$lang['projects_reports_project'] = 'Project';
$lang['projects_reports_project_summary'] = 'Summary';
$lang['projects_reports_project_summary_hint'] = 'Shows a full summary &amp; overview of this project with milestones &amp; test runs as well as activity and history details.';

$lang['projects_reports_results'] = 'Results';
$lang['projects_reports_results_property_groups'] = 'Property Distribution';
$lang['projects_reports_results_property_groups_hint'] = 'Shows the distribution and groups for a specific test attribute (e.g. priority, type or status) for this project.';
$lang['projects_reports_results_case_coverage'] = 'Comparison for Cases';
$lang['projects_reports_results_case_coverage_hint'] = 'Shows the results for select test runs per test case (result coverage &amp; comparison).';
$lang['projects_reports_results_reference_coverage'] = 'Comparison for References';
$lang['projects_reports_results_reference_coverage_hint'] = 'Shows the results for the references (requirements, user stories, etc.) in this project (result coverage &amp; comparison).';

$lang['projects_reports_users'] = 'Users';
$lang['projects_reports_users_workload_summary'] = 'Workload Summary';
$lang['projects_reports_users_workload_summary_hint'] = 'Shows the workload summary, estimates and forecasts for users in this project.';

$lang['projects_history_milestone'] = 'Milestone';
$lang['projects_history_suite'] = 'Test Suite';
$lang['projects_history_run'] = 'Test Run';
$lang['projects_history_deleted'] = '(deleted)';
$lang['projects_history_completed'] = '(completed)';

$lang['projects_new_suite'] = 'Add Test Suite';
$lang['projects_test_suites'] = 'Test Suites';
$lang['projects_error_exists'] = 'The specified project does not exist or you do not have the permission to access it.';

$lang['project_overview_first_title'] = 'Congratulations! You have created your first project';
$lang['project_overview_first_body'] = 'Now that you have created your first project in TestRail,
you can add your project milestones and create your first test cases. If you are
new to TestRail, it is highly recommended to take a look at TestRail\'s
<a target="_blank" href="https://www.gurock.com/testrail/docs/user-guide/getting-started">user guide and manual</a>.';

$lang['projects_suite_mode'] = 'Suite Mode';
$lang['projects_suite_mode_intro'] = 'A project can use different ways to manage and organize test cases.
A single test suite (repository) is usually the recommended option.
Choose baseline support for complex projects that require multiple test case versions at the same time.';
$lang['projects_suite_mode_single'] = 'Use a single repository for all cases (recommended)';
$lang['projects_suite_mode_single_desc'] = 'A single test suite (repository) is easy to manage and flexible enough for most projects with no or few concurrent versions. You can use sections and subsections to further organize your test cases.';
$lang['projects_suite_mode_single_baseline'] = 'Use a single repository with baseline support';
$lang['projects_suite_mode_single_baseline_desc'] = 'Use a single test suite (repository) with the additional option to create baselines to manage multiple branches of your test cases at the same time. This is ideal if you need to test multiple project versions in parallel.';
$lang['projects_suite_mode_multi'] = 'Use multiple test suites to manage cases';
$lang['projects_suite_mode_multi_desc'] = 'Multiple test suites can be useful to organize your test cases by functional areas and application modules on the test suite level.
This is the traditional mode of TestRail and is automatically used for upgraded projects.';
$lang['projects_suite_mode_cannot_switch'] =
'You have more than one test suite in this project and in order to switch to the single (or single with baseline) suite mode, you can only have one test suite in this project.
<br /><br />
To switch the suite mode, please consolidate all test suites by moving the test cases into a single, combined test suite first.
<br /><br />
<strong>Important:</strong> make sure to consider closing currently active test runs and plans before doing so in order to preserve your current test results
(all active test runs and results will be deleted when you move or delete test cases and suites).';

$lang['project_overview_first_expl_title'] = 'Next recommended steps:';
$lang['project_overview_first_expl_body_started'] = 'Read <a target="_blank" href="https://www.gurock.com/testrail/docs/user-guide/getting-started">Getting Started</a>';
$lang['project_overview_first_expl_body_milestones'] = 'Add <a href="{0}">project milestones</a>';
$lang['project_overview_first_expl_body_suites'] = 'Add <a href="{0}">test suites</a>';
$lang['project_overview_first_expl_body_cases'] = 'Enter <a href="{0}">test cases</a>';
$lang['project_overview_first_expl_body_users'] = 'Add <a href="{0}">additional users</a>';

$lang['projects_goto_overview'] = 'View project overview';
$lang['projects_update_hide'] = 'Hide this message';
$lang['projects_update_version'] = 'Version';
$lang['projects_update_available'] = '<strong>A new version of TestRail is available ({0}).</strong>
You can <a target="_blank" href="{1}">download the new version</a> and update your installation.';
$lang['projects_support_hide'] = 'Hide this message';
$lang['projects_support_expired'] = '<strong>Your TestRail support plan expired on {0}.</strong>
You can <a target="_blank" href="https://secure.gurock.com/customers/portal/licenses/">renew your support plan</a> to receive future TestRail updates and technical support.';

$lang['projects_return_location'] = 'Return Location';
$lang['projects_sidebar_projects'] = 'Projects';
$lang['projects_sidebar_projects_stats'] = 'You are managing <strong class="text-softer">{0}</strong> {0?{projects}:{project}}.';

$lang['projects_new'] = 'Add Project';
$lang['projects_new_example'] = 'Add Example Project';
$lang['projects_add'] = 'Add Project';
$lang['projects_save'] = 'Save Project';

$lang['projects_name'] = 'Name';
$lang['projects_name_desc'] = 'Ex: <em>New Widget</em>, <em>Intranet</em> or <em>Payroll Software</em>';
$lang['projects_example_intro'] = 'Example projects are generated by TestRail and contain sample data
such as test cases, results and milestones. They are a good way to see and use many of
TestRail\'s features and are perfect for evaluation or demonstration purposes.';
$lang['projects_example_placeholder'] = 'Example Project';
$lang['projects_example_na'] = 'Support for example projects is not enabled for this installation.';

$lang['projects_announcement'] = 'Announcement';
$lang['projects_announcement_desc'] = 'You can post an announcement to the project overview page.
This could include links to the project\'s issue tracker or knowledge base, for example.';

$lang['projects_show_announcement'] = 'Show the announcement on the overview page';
$lang['projects_post_announcement'] = 'Show Announcement';
$lang['projects_completed_field'] = 'Is Completed';
$lang['projects_completed'] = 'This project is completed';
$lang['projects_completed_hint'] = '(completed)';
$lang['projects_completed_desc'] = 'Shows the project in the completed project list on the dashboard. This doesn\'t make the project read-only (you can use the Access tab for this). ';
$lang['projects_test_case_approval_enabled'] = 'Enable Test Case Approvals';
$lang['projects_test_case_approval_enabled_desc'] = 'Enables test case statuses and approvals for the project. Test runs which use all test cases will only use test cases with approved statuses. Additional test case status filters will be available when setting test run filters.';

$lang['projects_delete'] = 'Delete Project';
$lang['projects_delete_link'] = 'Delete this project';
$lang['projects_delete_descr'] = 'Deleting a project <strong>cannot be undone</strong>. This also deletes all related test cases and test results.';
$lang['projects_delete_confirm'] = 'Really delete project <strong>{0}</strong>? This also deletes all test cases and results and everything else that is part of this project. This cannot be undone.';
$lang['projects_delete_confirm_extra'] = 'Deleting a project is a high impact and irrevocable action. You can alternatively also just set the project to completed or hide it from the dashboard via project permissions instead.';
$lang['projects_delete_confirm_checkbox'] = 'Yes, delete this project (cannot be undone)';

$lang['projects_success_add'] = 'Successfully added the new project.';
$lang['projects_error_add'] = 'An error occurred while adding the new project.';
$lang['projects_success_update'] = 'Successfully updated the project.';
$lang['projects_error_update'] = 'An error occurred while saving the project.';
$lang['projects_success_delete'] = 'Successfully deleted the project.';
$lang['projects_error_delete'] = 'An error occurred while deleting the project.';
$lang['projects_error_defect_id_url'] = 'The Defect View Url field does not contain the %id% placeholder.';
$lang['projects_error_reference_id_url'] = 'The References View Url field does not contain the %id% placeholder.';

$lang['projects_tabs_project'] = 'Project';
$lang['projects_tabs_access'] = 'Access';
$lang['projects_tabs_suites'] = 'Suites';
$lang['projects_tabs_integration'] = 'Integration';
$lang['projects_tabs_defects'] = 'Defects';
$lang['projects_tabs_references'] = 'References';
$lang['projects_tabs_index'] = 'Tab Index';

$lang['projects_fav_star_hint'] = 'Mark as project favorite.';
$lang['projects_fav_unstar_hint'] = 'Remove from project favorites.';

$lang['projects_defect_id_url'] = 'Defect View Url';
$lang['projects_defect_id_url_desc'] = 'The web address of a case in your defect tracker.
Use %id% as the placeholder for the actual case ID. Leave empty to use the global setting.
<a class="link" target="_blank" tabindex="-1" href="https://www.gurock.com/testrail/docs/integrate/">Learn more</a>';
$lang['projects_defect_add_url'] = 'Defect Add Url';
$lang['projects_defect_add_url_desc'] = 'The web address for adding a new case to your defect tracker.
Leave empty to use the global setting. <a class="link" target="_blank" tabindex="-1"
href="https://www.gurock.com/testrail/docs/integrate/">Learn more</a>';

$lang['projects_defect_plugin'] = 'Defect Plugin';
$lang['projects_defect_plugin_desc'] = 'The plugin for integrating TestRail with your defect tracker.
Leave empty to use the global setting. The plugin can be configured below.
<a class="link" target="_blank" tabindex="-1" href="https://www.gurock.com/testrail/docs/integrate/">Learn more</a>';
$lang['projects_defect_config'] = 'Defect Plugin Configuration';
$lang['projects_defect_config_desc'] = 'Make sure to use HTTPS for a secure connection to your defect tracker.
User variables are recommended to store the user &amp; password securely
(can also be used to customize the login per user).
<a class="link" tabindex="-1" target="_blank" href="https://www.gurock.com/testrail/docs/integrate/">Learn more</a>';
$lang['projects_defect_template'] = 'Defect Plugin Template';
$lang['projects_defect_template_expand'] = '<a {0}>Enter a template</a> for the description field of the defect dialog.';
$lang['projects_defect_template_desc'] = 'The template for the description field of the defect dialog.
You can add various placeholder variables via the Add Field link below.';
$lang['projects_defect_template_add_field'] = 'Add Field';
$lang['projects_defect_template_placeholder'] = 'Status: %tests:status_id% ..';

$lang['projects_reference_id_url'] = 'Reference View Url';
$lang['projects_reference_id_url_desc'] = 'The web address for your case references (requirements or user stories, e.g.).
Use %id% as the placeholder for the actual reference ID. Leave empty to use the global setting.
<a class="link" target="_blank" tabindex="-1" href="https://www.gurock.com/testrail/docs/integrate/">Learn more</a>';
$lang['projects_reference_add_url'] = 'Reference Add Url';
$lang['projects_reference_add_url_desc'] = 'The web address for adding a new reference.
Leave empty to use the global setting. <a class="link" target="_blank" tabindex="-1"
href="https://www.gurock.com/testrail/docs/integrate/">Learn more</a>';
$lang['projects_reference_plugin'] = 'Reference Plugin';
$lang['projects_reference_plugin_desc'] = 'The plugin for integrating TestRail with your requirement, issue
or bug tracker. The plugin can be configured below.
<a class="link" tabindex="-1" target="_blank" href="https://www.gurock.com/testrail/docs/integrate/">Learn more</a>';
$lang['projects_reference_config'] = 'Reference Plugin Configuration';
$lang['projects_reference_config_desc'] = 'Make sure to use HTTPS for a secure connection to your issue or requirement tracker.
User variables are recommended to store the user &amp; password securely
(can also be used to customize the login per user).
<a class="link" tabindex="-1" target="_blank" href="https://www.gurock.com/testrail/docs/integrate/">Learn more</a>';

$lang['projects_user_access'] = 'User Access';
$lang['projects_group_access'] = 'Group Access';
$lang['projects_access'] = 'Default Access';
$lang['projects_access_global'] = 'Global Role';
$lang['projects_access_noaccess'] = 'No Access';
$lang['projects_access_project'] = 'Project Access';
$lang['projects_access_desc'] = 'Specifies the default access for this project.
The default access can be overridden for each user and group below.
<a class="link" tabindex="-1" target="_blank" href="https://www.gurock.com/testrail/docs/user-guide/howto/permissions">Learn more</a>';

$lang['projects_push_defect'] = 'Submit a new defect to your external tool.';
$lang['projects_add_defect'] = 'Go to your external tool to create a new defect.';
$lang['projects_assigned'] = 'Assigned Project';
$lang['manager_not_assigned_projects_edit'] = 'You are not allowed to edit this project.';
$lang['manager_not_assigned_projects_delete'] = 'You are not allowed to delete this project.';
