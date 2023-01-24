<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$lang['email_data_storage_policy_hyperlink'] = '<a href="https://www.ideracorp.com/Legal/Gurock/DataStoragePolicy">Data Storage Policy</a>';
$lang['email_no_server'] = 'There is no SMTP server configured for sending email.';

$lang['email_forgotpassword_subject'] = '[%{installation_name}] Resetting your TestRail password';
$lang['email_forgotpassword_body'] = 'Dear %{name},

You (or somebody else) requested to reset the password for your TestRail
user account. If you don\'t want to reset the password, you can simply
ignore this email.

To reset your TestRail password, please use this link:

%{url}

Sincerely,
%{installation_name}
Powered by TestRail';
$lang['email_reset_password_subject'] = '[%{installation_name}] Resetting your TestRail password';
$lang['email_reset_password_body'] = 'Dear %{name},

The administrator has reset the password for this account. Please follow the link below to create a new one.

%{url}

Sincerely,
%{installation_name}
Powered by TestRail';

$lang['email_invite_user_subject'] = '[%{installation_name}] A new user account was created for you';
$lang['email_invite_user_body'] = 'Dear %{name},

A new TestRail (test management) user account was created for you.
You can set a new password for your user account on the following
page (and then log in):

%{url}

Enjoy,
%{installation_name}
Powered by TestRail';

$lang['email_notify_test_assignedto_subject'] = '[%{installation_name}] Test %{id} was assigned to you';
$lang['email_notify_test_assignedto_many_subject'] = '[%{installation_name}] %{test_count} tests were assigned to you';

$lang['email_notify_test_status_subject'] = '[%{installation_name}] Test %{id} was set to %{status}';
$lang['email_notify_test_status_many_subject'] = '[%{installation_name}] %{test_count} tests were set to %{status}';

$lang['email_notify_test_unassigned_subject'] = '[%{installation_name}] Test %{id} was unassigned';
$lang['email_notify_test_unassigned_many_subject'] = '[%{installation_name}] %{test_count} tests were unassigned';

$lang['email_notify_test_comment_subject'] = '[%{installation_name}] A comment was added to test %{id}';
$lang['email_notify_test_comment_many_subject'] = '[%{installation_name}] A comment was added to %{test_count} tests';

$lang['email_notify_test_assignedto_header'] = 'Dear %{name},

The test was assigned to you by %{user}.

Test Run:    %{run}
Project:     %{project}
Assigned To: You

';

$lang['email_notify_test_assignedto_many_header'] = 'Dear %{name},

The tests were assigned to you by %{user}.

Test Run:    %{run}
Project:     %{project}
Assigned To: You

';

$lang['email_notify_test_status_header'] = 'Dear %{name},

The test result was added by %{user}.

Test Run:    %{run}
Project:     %{project}
Status:      %{status}

';

$lang['email_notify_test_status_many_header'] = 'Dear %{name},

The test results were added by %{user}.

Test Run:    %{run}
Project:     %{project}
Status:      %{status}

';

$lang['email_notify_test_unassigned_header'] = 'Dear %{name},

The test was set to unassigned by %{user}.

Test Run:    %{run}
Project:     %{project}
Assigned To:

';

$lang['email_notify_test_unassigned_many_header'] = 'Dear %{name},

The tests were set to unassigned by %{user}.

Test Run:    %{run}
Project:     %{project}
Assigned To:

';

$lang['email_notify_test_comment_header'] = 'Dear %{name},

The following comment was added by %{user}:

"%{comment}"

Test Run:    %{run}
Project:     %{project}

';

$lang['email_notify_test_body_intro'] = "Please see below for the affected tests:\n\n";
$lang['email_notify_test_body'] = "%{id}: %{title}\n%{url}\n\n";
$lang['email_test_list'] = "%{test_body} \n";
$lang['email_notify_test_footer'] = 'You can disable email notifications for your account under My Settings:

%{unsubscribe}

Sincerely,
%{installation_name}
Powered by TestRail';

$lang['email_notify_case_assignedto_subject'] = '[%{installation_name}] Test Case(s) assigned to you';

$lang['email_notify_case_status_subject'] = '[%{installation_name}] A user changed the status of one or more Test Cases assigned to you';

$lang['email_notify_case_comment_subject'] = '[%{installation_name}] A user commented on one or more Test Cases assigned to you';

$lang['email_notify_case_comment_header'] = 'Dear %{name},

%{user} commented on one or more test cases assigned to you.

Project:     %{project}

';

$lang['email_notify_case_assignedto_header'] = 'Dear %{name},

One or more test case(s) were assigned to you by %{user}.

Project:     %{project}

';

$lang['email_notify_case_status_header'] = 'Dear %{name},

%{user} changed the status of one or more test cases assigned to you.

Project:     %{project}

';

$lang['email_notify_case_body'] = "%{id}: %{title}\n%{status}\n%{url}\n%{comment}\n\n";
$lang['email_case_list'] = "%{case_body} \n";
$lang['email_notify_case_footer'] = 'You can disable email notifications for your account under My Settings:

%{unsubscribe}

Sincerely,
%{installation_name}
Powered by TestRail';

$lang['email_notify_run_subject'] = '[%{installation_name}] Test run %{id} was assigned to you';
$lang['email_notify_run_body'] = 'Dear %{name},

The following test run was assigned to you by %{user}:

Test Run: %{run}
Project:  %{project}

The test run and its tests can be viewed at:

%{run_url}

Sincerely,
%{installation_name}
Powered by TestRail';

$lang['email_test_subject'] = '[%{installation_name}] Test Email';
$lang['email_test_body'] = 'Hello,

This is an email sent to your email address to test the email settings
of a TestRail installation. Since you are currently reading this email,
it seems everything is working fine with the email settings.

The TestRail installation is available at:

%{url}

Sincerely,
%{installation_name}
Powered by TestRail';

$lang['email_notify_report_link_subject'] = '[%{installation_name}] A new report is available: %{report_name}';
$lang['email_notify_report_link_body'] = 'Hello,

The following report is now available:

%{report_name}
%{report_url}

Sincerely,
%{installation_name}
Powered by TestRail';

$lang['email_notify_report_attachment_subject'] = '[%{installation_name}] A new report is available: %{report_name}';
$lang['email_notify_report_attachment_body'] = 'Hello,

The following TestRail report was sent to you:

%{report_name}

The report is attached to this email, either as a ZIP file, a PDF file, or both.
If the email contains a ZIP file, then after downloading and extracting it,
you can view the report in your web browser by opening the index.html file.

If the email contains a PDF, after downloading it you can open it in your preferred PDF viewer.

Sincerely,
%{installation_name}
Powered by TestRail';

$lang['email_export_completed_subject'] = '[%{installation_name}] scheduled export has been completed';
$lang['email_export_completed_body'] = 'Hello,

The following export is now available:
%{export_name}
%{url_get_export}

Sincerely,
%{installation_name}
Powered by TestRail';

$lang['email_storage_limit_approaching_soft_subject'] = 'TestRail Instance Approaching SOFT Storage Limit';
$lang['email_storage_limit_approaching_soft_body'] = 'Dear Customer,

The TestRail instance [%{hostname}] is approaching the available data storage limit for TestRail Cloud instances per our Data Storage policy of 50GB.
To avoid storage fees assessed on your TestRail Cloud subscription, please monitor the data storage activity for your TestRail instance under Administration > Data Management to ensure your data storage limits remain in compliance.

Refer to our %{email_data_storage_policy_hyperlink} for more information about our storage limits and how you can stay within them.

Please feel free to contact us if you have any questions or need assistance.

Thank you,
Gurock Customer Success
contact@gurock.com
';

$lang['email_storage_limit_approaching_hard_subject'] = 'TestRail Instance Approaching HARD Storage Limit';
$lang['email_storage_limit_approaching_hard_body'] = 'Dear Customer,

The TestRail instance [%{hostname}] is approaching the maximum data storage limit available for TestRail Cloud instances per our Data Storage policy.
If the maximum allowable storage limit is reached, case fields and export capabilities will be limited within TestRail.

Refer to our %{email_data_storage_policy_hyperlink} for more information about our storage limits and how you can stay within them.

Your urgent action is needed.

Thank you,
Gurock Customer Success
contact@gurock.com
';

$lang['email_storage_limit_exceeded_soft_subject'] = 'TestRail Instance Exceeded SOFT Storage Limit';
$lang['email_storage_limit_exceeded_soft_body'] = 'Dear Customer,

The TestRail instance [%{hostname}] has exceeded the available data storage limit for TestRail Cloud instances per our Data Storage policy of 50GB.
To avoid storage fees assessed on your TestRail Cloud subscription, please lower your storage limit as soon as possible within the current billing period. If action is not taken, storage limit fees will be assessed on the first day of the next calendar month.

Refer to our %{email_data_storage_policy_hyperlink} for more information about our storage limits and how you can stay within them.

Please feel free to contact us if you have any questions or need further assistance.

Thank you,
Gurock Customer Success
contact@gurock.com
';

$lang['email_storage_limit_exceeded_hard_enterprise_subject'] = 'TestRail Enterprise Instance Exceeded HARD Storage Limit';
$lang['email_storage_limit_exceeded_hard_enterprise_body'] = 'Dear Customer,

The TestRail instance [%{hostname}] has exceeded the allowable storage limit of 500GB per our Data Storage policy for TestRail Enterprise Cloud. Case fields cannot be added and exports will not be allowed until your instance is back inside the allowable limit for your subscription.

Refer to our %{email_data_storage_policy_hyperlink} for more information about our storage limits and how you can stay within them.

Your urgent action is needed. Please contact us if you have any questions.

Thank you,
Gurock Customer Success
contact@gurock.com
';

$lang['email_storage_limit_exceeded_hard_subject'] = 'TestRail Instance Exceeded HARD Storage Limit';
$lang['email_storage_limit_exceeded_hard_body'] = 'Dear Customer,

The TestRail instance [%{hostname}] has exceeded the maximum data storage limit available for TestRail Cloud instances per our  Data Storage policy.

Refer to our %{email_data_storage_policy_hyperlink} for more information about our storage limits and how you can stay within them.

To continue using TestRail Cloud, please make sure to lower your total data storage under 200gb. Case fields cannot be added and exports will not be allowed until your instance is back inside the allowable limit for your subscription.

Thank you,
Gurock Customer Success
contact@gurock.com
';

$lang['email_export_completed_failure_subject'] = '[%{installation_name}] Export Failed';
$lang['email_export_completed_failure_body'] = 'Hello,

The following export failed:
%{export_name}

The following error was reported: %{error_message}

Please try again or contact support via %{contact_email} if you need further assistance.

Sincerely,
%{installation_name}
Powered by TestRail';

$lang['email_export_completed_success_subject'] = '[%{installation_name}] Export Ready';
$lang['email_export_completed_success_body'] = 'Hello,

The following export is now available:
%{export_name}
%{url_get_export}

Sincerely,
%{installation_name}
Powered by TestRail';

$lang['email_send_quote_subject'] = 'New Enterprise information request';
$lang['email_send_quote_body'] = 'This customer has indicated that they are interested in learning more about TestRail Enterprise.

%{name}
%{email}
%{licence}

Please contact the customer.';

$lang['email_send_otp_subject'] = 'OTP request for Login to Testrail';
$lang['email_send_otp_body'] = 'Hello,

Please use the code below to complete your login to TestRail.

<span style="font-size: 35px;color: #2c952c"><b>%{otp}</b></span>

This code will expire in 30 minutes.

If you haven\'t asked for a verification code, change your password 
immediately from your TestRail account settings.

If you have any questions about the security of your account,
Please <a href="https://www.gurock.com/testrail/about/contact">contact us</a>

Thanks for using TestRail ';

$lang['email_error'] = "Sending the test email failed. Please see the following messages and server output for details: \n\n There is no SMTP server configured for sending email.";
$lang['email_notify_webhook_created_subject'] = 'A new webhook was created %{date}';
$lang['email_notify_webhook_created_body'] = 'Hello,

A new webhook has been created in your TestRail instance. Details are below:

Name: %{webhook_name}
Payload URL: %{webhook_payload_url}
Subscribed Events: %{webhook_events}
Subscribed Projects: %{webhook_projects}
Active: %{webhook_active}
More details: %{webhook_url}

Sincerely,
%{installation_name}
Powered by TestRail';
$lang['email_notify_webhook_updated_subject'] = 'A webhook was modified %{date}';
$lang['email_notify_webhook_updated_body'] = 'Hello,

A webhook has been modified in your TestRail instance. Details are below:

Name: %{webhook_name}
Changes: %{webhook_changes}
More details: %{webhook_url}

Sincerely,
%{installation_name}
Powered by TestRail';
$lang['email_notify_webhook_disabled_subject'] = 'A webhook was disabled %{date}';
$lang['email_notify_webhook_disabled_body'] = 'Hello,

A webhook has been disabled in your TestRail instance. Details are below:

Name: %{webhook_name}
Disabled Reason: %{webhook_disabled_reason}
More details: %{webhook_url}

Sincerely,
%{installation_name}
Powered by TestRail';
$lang['email_notify_webhook_deleted_subject'] = 'A webhook was deleted %{date}';
$lang['email_notify_webhook_deleted_body'] = 'Hello,

A webhook was deleted in your TestRail instance. Details are below:

Name: %{webhook_name}

Sincerely,
%{installation_name}
Powered by TestRail';
$lang['email_notify_webhook_response_received_subject'] = 'A %{webhook_response_code} response was received for your webhook %{date}';
$lang['email_notify_webhook_response_received_body'] = 'Hello,

A %{webhook_response_code} response was received for your webhook. Details are below:

Name: %{webhook_name}
Payload URL: %{webhook_payload_url}
Response Code: %{webhook_response_code}
Response Message: %{webhook_response_message}
More details: %{webhook_url}

%{webhook_response_email_body}

Sincerely,
%{installation_name}
Powered by TestRail';
$lang['email_notify_webhook_disabled_reason_too_many_attempts'] = 'Webhook did not respond successfully after 3 attempts. Response code: {0}. Response body: {1}';
