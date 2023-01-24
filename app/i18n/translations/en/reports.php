<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

$lang['reports_report'] = 'Report';
$lang['reports_loading'] = 'Loading report';
$lang['reports_printing'] = 'Printing report';
$lang['reports_nodir'] = 'No report directory configured.';
$lang['reports_unprocessed'] = 'This report is not yet generated. Please try again later.';
$lang['reports_noaccess'] = 'The requested report does not exist or you do not have the permissions to access it.';
$lang['reports_resource_na'] = 'Report file or resource not found';
$lang['reports_resource_path'] = 'Path';
$lang['reports_ajax_flag'] = 'Path';

$lang['reports_success_delete'] = 'Successfully deleted the reports.';

$lang['reports_run_noproject'] = 'The project for the report no longer exists and the report cannot be generated (project ID: {0}).';
$lang['reports_run_nopath'] = 'Could not create output directory for report: no report directory configured or insufficient permissions ({0}).';
$lang['reports_run_nohtml'] = 'No HTML returned from report: missing \'html\'/\'html_file\' property.';
$lang['reports_run_noindex'] = 'Could not save HTML into index.html file for report: {0}';
$lang['reports_run_nometa'] = 'Could not save meta description file for report: {0}';
$lang['reports_run_noresource'] = 'Resource file not found for report: {0}';
$lang['reports_run_noresource_copy'] = 'Resource file ({0}, format: {1}) could not be copied into output directory for report: {1}';
$lang['reports_run_noattachment'] = 'Attachment file not found for report: {0}';
$lang['reports_run_unknown_format'] = 'Unknown attachment file format';


$lang['reports_overview_shared'] = 'Shared';
$lang['reports_overview_personal'] = 'Private';
$lang['reports_overview_scheduled'] = 'Scheduled';
$lang['reports_overview_on_demand_via_api'] = 'API Templates';
$lang['reports_overview_empty_title'] = 'This project doesn\'t contain any reports, yet.';
$lang['reports_overview_empty_body'] = 'No reports have been added to this project yet. You can create or schedule reports for the templates in the sidebar.';
$lang['reports_overview_empty_title'] = 'This project doesn\'t contain any reports, yet.';
$lang['reports_overview_empty_body'] = 'No reports have been added to this project yet. You can create or schedule reports for the report templates in the sidebar.';
$lang['reports_overview_empty_expl_title'] = 'What\'s a report?';
$lang['reports_overview_empty_expl_body'] = 'A report lets you generate statistics and charts for the data in your TestRail installation.';

$lang['reports_share'] = 'Share Report';
$lang['reports_share_short'] = 'Share';
$lang['reports_share_intro'] = 'You can share this report with other users or external people (with no TestRail access). <br />For larger reports which may not display correctly in a PDF, you have the option of using HTML format instead,<br /> but please note that some email providers will block HTML reports from being sent. <br />As an alternative, please consider splitting the report scope into multiple, smaller, PDF reports.';
$lang['reports_share_success'] = 'Successfully shared the report via email.';
$lang['reports_share_nousers'] = 'Please select at least one user for sharing a link.';
$lang['reports_share_noemails'] = 'Please enter at least one email address.';
$lang['reports_share_noemail'] = 'You have entered an invalid email address as recipient: {0}.';
$lang['reports_share_noshare'] = 'Please select at least one option to share this report.';
$lang['reports_share_email_error'] = 'The following error occured while trying to share the report: {0}';

$lang['reports_status_success'] = 'Success';
$lang['reports_status_error'] = 'Error';

$lang['reports_no_task'] = 'The background task is not installed';
$lang['reports_no_task_desc'] = 'The background task is required to generate reports but the task is not installed. Please ask your TestRail administrator to activate it. <a target="_blank"
				href="https://www.gurock.com/testrail/docs/admin/howto/background-task">Learn more</a>';

$lang['reports_share_hint'] = 'Share Report';
$lang['reports_share_hint_desc'] = 'Opens a dialog to share this report via email.';
$lang['reports_share_hint_simple'] = 'Share this report via email.';
$lang['reports_copy_hint'] = 'Rerun Report';
$lang['reports_copy_hint_desc'] = 'Create or schedule a similar report.';
$lang['reports_delete_hint'] = 'Delete this report.';
$lang['reports_delete_confirm'] = 'Really delete this report? This irrevocably deletes this report for all users and cannot be undone.';
$lang['reports_copy_title'] = 'Create Similar';
$lang['reports_download_hint'] = 'Download Report';
$lang['reports_download_hint_desc'] = 'Download this report as HTML or PDF file.';
$lang['reports_print_title'] = 'Print';
$lang['reports_print_hint'] = 'Print Report';
$lang['reports_print_hint_desc'] = 'Opens a printer-friendly version of this report.';
$lang['reports_share_title'] = 'Share';

$lang['reports_job'] = 'Report Job';
$lang['reports_jobs_create'] = 'Create Report';
$lang['reports_jobs_create_intro'] = 'You can create or schedule reports for the following report templates:';
$lang['reports_jobs_add_hint'] = 'Create or schedule a new report for this template.';
$lang['reports_jobs_edit_hint'] = 'Edit this scheduled report.';
$lang['reports_jobs_copy_hint'] = 'Create or schedule a similar report.';
$lang['reports_jobs_delete_hint'] = 'Delete this scheduled report.';
$lang['reports_jobs_delete_confirm'] = 'Really delete this scheduled report? This irrevocably deletes this scheduled report for all users and cannot be undone.';
$lang['reports_jobs_add'] = 'Add Report';
$lang['reports_jobs_add_and_view'] = 'Add and View Report';
$lang['reports_jobs_edit'] = 'Save Report';
$lang['reports_jobs_groups_fallback'] = 'Others';
$lang['reports_jobs_label_fallback'] = 'Unnamed';
$lang['reports_jobs_description_fallback'] = 'No description.';
$lang['reports_jobs_author_fallback'] = 'No author';
$lang['reports_jobs_version_fallback'] = 'No version';
$lang['reports_jobs_success_add'] = 'Successfully added the new report/scheduled report.';
$lang['reports_jobs_noaccess'] = 'The requested scheduled report does not exist or you do not have the permissions to access it.';
$lang['reports_jobs_noschedule'] = 'Please select at least one scheduling option.';

$lang['reports_template'] = 'Report API Template';
$lang['reports_templates_create'] = 'Create Report Template';
$lang['reports_templates_create_intro'] = 'You can create reports for the following report templates:';
$lang['reports_templates_add_hint'] = 'Create or schedule a new report for this template.';
$lang['reports_templates_edit_hint'] = 'Edit this report API template.';
$lang['reports_templates_copy_hint'] = 'Create or schedule a similar report API template.';
$lang['reports_templates_delete_hint'] = 'Delete this report API template.';
$lang['reports_templates_delete_confirm'] = 'Really delete this report API template? This irrevocably deletes this report API template for all users and cannot be undone.';
$lang['reports_templates_add'] = 'Add Report Template';
$lang['reports_templates_add_and_view'] = 'Add and View Report Template';
$lang['reports_templates_edit'] = 'Save Report';
$lang['reports_templates_groups_fallback'] = 'Others';
$lang['reports_templates_label_fallback'] = 'Unnamed';
$lang['reports_templates_description_fallback'] = 'No description.';
$lang['reports_templates_author_fallback'] = 'No author';
$lang['reports_templates_version_fallback'] = 'No version';
$lang['reports_templates_success_add'] = 'Successfully added the new report/API report template.';
$lang['reports_templates_noaccess'] = 'The requested report API template does not exist or you do not have the permissions to access it.';
$lang['reports_templates_noschedule'] = 'Please select at least one scheduling option.';

$lang['reports_jobs_success_update'] = 'Successfully updated the scheduled report.';
$lang['reports_jobs_success_delete'] = 'Successfully deleted the scheduled report.';
$lang['reports_templates_success_update'] = 'Successfully updated the API report template.';
$lang['reports_templates_success_delete'] = 'Successfully deleted the API report template.';
$lang['reports_plugin'] = 'Plugin';
$lang['reports_plugin_unknown'] = 'Unknown or invalid report plugin "{0}".';
$lang['reports_plugin_no_class'] = 'Implementation class missing for report plugin "{0}".';
$lang['reports_form_options_custom'] = 'Report Options';
$lang['reports_form_options_general'] = 'Access &amp; Scheduling';

$lang['reports_control_unknown'] = 'Unknown report control "{0}".';
$lang['reports_control_no_class'] = 'Implementation class missing for report control "{0}".';

$lang['reports_name'] = 'Name';
$lang['reports_name_desc'] = 'You can use the following variables in the report name: <a class="link" {0}>date</a>, <a class="link" {1}>date/time</a>.';
$lang['reports_description'] = 'Description';
$lang['reports_description_desc'] = 'Use the description to explain the content and purpose of this report or add links to additional resources.';

$lang['reports_form_author'] = 'Author:';
$lang['reports_form_version'] = 'Version:';
$lang['reports_form_group'] = 'Group:';

$lang['reports_access_private'] = 'Private';
$lang['reports_access_shared_by'] = 'Shared, by <strong>{0}</strong>';
$lang['reports_access_inactive_by'] = 'Disabled; owner deactivated: <strong>{0}</strong>';
$lang['reports_access_field'] = 'Access';
$lang['reports_access_intro'] = 'This report can be accessed by:';
$lang['reports_access_user'] = 'Myself only (and administrators)';
$lang['reports_access_shared'] = 'Everyone (with project access)';
$lang['reports_schedule_intro'] = 'Create this report:';
$lang['reports_schedule_now'] = 'Right now';
$lang['reports_generate_now_field'] = 'Generate Now';
$lang['reports_schedule_now_field'] = 'Create Now';
$lang['reports_schedule_on_demand_via_api'] = 'On demand via the API';
$lang['reports_schedule_later'] = 'Schedule this report:';
$lang['reports_schedule_later_field'] = 'Schedule';
$lang['reports_schedule_interval'] = 'Schedule Interval';
$lang['reports_schedule_interval_daily'] = 'Every day';
$lang['reports_schedule_interval_daily_at'] = 'Every day at {0} {1}';
$lang['reports_schedule_interval_weekly'] = 'Every week';
$lang['reports_schedule_interval_weekly_at'] = 'Every {0} at {1} {2}';
$lang['reports_schedule_interval_monthly'] = 'Every month';
$lang['reports_schedule_interval_monthly_at'] = 'Every month, {0}. at {1} {2}';
$lang['reports_schedule_interval_until'] = 'until {0}';
$lang['reports_schedule_weekday'] = 'Schedule Weekday';
$lang['reports_schedule_weekday_monday'] = 'Monday';
$lang['reports_schedule_weekday_tuesday'] = 'Tuesday';
$lang['reports_schedule_weekday_wednesday'] = 'Wednesday';
$lang['reports_schedule_weekday_thursday'] = 'Thursday';
$lang['reports_schedule_weekday_friday'] = 'Friday';
$lang['reports_schedule_weekday_saturday'] = 'Saturday';
$lang['reports_schedule_weekday_sunday'] = 'Sunday';
$lang['reports_schedule_day'] = 'Schedule Day';
$lang['reports_schedule_hour'] = 'Schedule Hour';
$lang['reports_schedule_until'] = 'Schedule Until';
$lang['reports_schedule_until'] = 'Until : ';
$lang['reports_schedule_until_link'] = 'Select a date';
$lang['reports_notify_intro'] = 'Once the report is ready:';
$lang['reports_notify_user'] = 'Notify me by email';
$lang['reports_notify_user_field'] = 'Notify (User)';
$lang['reports_notify_others_link'] = 'Email a link to the report (requires TestRail access):';
$lang['reports_notify_others_link_field'] = 'Notify (Link)';
$lang['reports_notify_others_link_recipients'] = 'Link Recipients';
$lang['reports_notify_others_link_desc'] = 'You can select multiple users by holding Ctrl/Cmd on your keyboard.';
$lang['reports_notify_others_attachment'] = 'Email the report as attachment (no TestRail access required):';
$lang['reports_notify_others_attachment_html'] = 'Email the report as HTML attachment';
$lang['reports_notify_others_attachment_pdf'] = 'Email the report as PDF attachment';

$lang['reports_notify_others_attachment_field'] = 'Notify (Attachment)';
$lang['reports_notify_others_attachment_recipients'] = 'Attachment Recipients';
$lang['reports_notify_others_attachment_default'] = 'person1@example.com
person2@example.com';
$lang['reports_notify_others_attachment_desc'] = 'Please enter one email address per line.';
$lang['reports_notify_others_attachment_invalid'] = 'Field Attachment Recipients contains one or more invalid email addresses.';

$lang['reports_denied_add'] = 'You are not allowed to add reports (insufficient permissions).';
$lang['reports_denied_edit'] = 'You are not allowed to edit reports (insufficient permissions).';
$lang['reports_denied_delete'] = 'You are not allowed to delete reports (insufficient permissions).';
$lang['reports_denied_schedule'] = 'You are not allowed to schedule reports (insufficient permissions).';
$lang['reports_denied_run'] = 'You don’t have access to this report.';

$lang['reports_view_error_intro'] = 'An error occurred while generating the report. Please contact your TestRail administrator or the person who built this report to resolve this issue. The following error message and details were recorded:';
$lang['reports_view_error_send_intro'] = 'If you believe this is an error that shouldn\'t happen, please send this error report to Gurock Software. You can optionally enter your
email address below and a Gurock Software support engineer will contact you
shortly.';
$lang['reports_view_error_send_email'] = 'Email Address (optional):';
$lang['reports_view_error_send_button'] = 'Send Error Report';
$lang['reports_custom_validation'] = 'Please select at least one test run (apply a filter or choose specific runs).';

$lang['report_bulk_delete'] = 'Delete Selected';
$lang['report_bulk_delete_message'] = '<strong>Delete all selected reports?</strong> This action cannnot be <br />undone.';
$lang['report_bulk_delete_confirmation'] = '<span style="color:red">Yes, delete all selected Reports (cannot be undone)</span>';
