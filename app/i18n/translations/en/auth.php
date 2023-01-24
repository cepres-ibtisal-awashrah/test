<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$lang['auth_return_url'] = 'Return Url';
$lang['auth_login_email'] = 'Email Address';
$lang['auth_login_name_email'] = 'Email/User';
$lang['auth_login_name'] = 'Login';
$lang['auth_reset_password'] = 'Reset Your Password';
$lang['auth_set_password'] = 'Set Your New Password';
$lang['auth_error'] = 'Sorry, there was a problem.';
$lang['auth_success'] = 'Success!';
$lang['auth_email'] = 'Email';
$lang['auth_password'] = 'Password';
$lang['auth_confirm_password'] = 'Confirm Password';
$lang['auth_not_valid_email'] = 'Email Address is not valid.';
$lang['auth_not_valid_password'] = 'Password is required.';
$lang['auth_required_password'] = 'Field Password is a required field.';

$lang['auth_short_password'] = 'Field Password is too short (5 characters required).';
$lang['auth_required_confirm_password'] = 'Field Confirm Password is a required field.';
$lang['auth_required_confirm_password_show'] = 'Confirm Password is required.';

$lang['auth_short_password_show'] = 'Password is too short (5 characters required).';
$lang['auth_short_confirm_password_show'] = 'Confirm Password is too short (5 characters required).';

$lang['auth_short_confirm_password'] = 'Field Confirm Password is too short (5 characters required).';
$lang['auth_short_email-login'] = 'Field Email/User is a required field.';
$lang['auth_required_email'] = 'Email Address is required.';
$lang['auth_Field_required_email'] = 'Field Email Address is a required field.';
$lang['auth_short_email-login_show'] = 'Email/Login is required.';
$lang['auth_notvalid_email'] = 'Field Email Address is not a valid email address.';
$lang['auth_login_name_desc'] = 'The login or user name you use to log in to TestRail.
This can be your domain or Windows account, for example.';
$lang['auth_login_rememberme'] = 'Keep me logged in on this computer';
$lang['auth_login_rememberme_name'] = 'Remember Me';
$lang['auth_login_password'] = 'Password';
$lang['auth_forgotpassword_intro'] = 'Please enter your email address below and you will receive an email with instructions on how to reset your password.';

$lang['auth_login_login'] = 'Log In';
$lang['auth_login_forgotpassword'] = 'I forgot my password';
$lang['auth_login_wrongpassword'] = 'Email/Login or Password is incorrect. Please try again.';
$lang['auth_login_fallback_disabled'] = 'This type of login is disabled for you. Please login using SSO.';
$lang['auth_login_sso'] = 'SSO Login';
$lang['auth_login_sso_disabled'] = 'SSO login is disabled for you. Please login using TestRail credentials.';
$lang['auth_login_max_attempts_reached'] = 'The maximum number of failed login attempts has been reached. Please try again in {0} {0?{minutes}:{minute}}.';
$lang['auth_poweredby'] = 'Powered by TestRail<br /><a href="http://www.gurock.com/testrail/" target="_blank">Test Management</a> Software';
$lang['auth_login_rememberme'] = 'Keep me logged in';
$lang['auth_forgot_password'] = 'Forgot your password?';
$lang['auth_or_login_with'] = 'or login with';
$lang['auth_single_sign_on'] = 'Single Sign On';
$lang['auth_log_in'] = 'Log into Your Account';
$lang['auth_impersonate_token_invalid'] = 'Please login below to access TestRail.';
$lang['auth_impersonate_params_missing'] = 'Please login below to access TestRail.';
$lang['auth_impersonate_token'] = 'Login Token';
$lang['auth_impersonate_user_id'] = 'User ID';
$lang['auth_impersonate_not_supported'] = 'Your TestRail installation does not support impersonation.
Please contact your TestRail administrator.';

$lang['auth_reset_password_token'] = 'Reset Token';
$lang['auth_reset_password_user_id'] = 'User ID';
$lang['auth_reset_password_token_invalid'] = 'The Reset Password link has expired or is invalid.
You can request a new password reset on the Forgot Password page (see the link below).';
$lang['auth_reset_password_params_missing'] = 'Please login below to access TestRail.';
$lang['auth_reset_password_success'] = 'Successfully set your password. Please login below to access TestRail.';
$lang['auth_reset_password_intro'] = 'You can set a new password below.
Please take the time to choose a secure and difficult to guess password.';
$lang['auth_reset_password_reset'] = 'Set New Password';
$lang['auth_reset_password_not_supported'] = 'Your TestRail installation does not support password resets.
Please contact your TestRail administrator.';

$lang['auth_login_custom_ext_error'] = 'External auth: {0}';
$lang['auth_login_custom_no_result'] = 'External auth: Empty result from custom auth script.';
$lang['auth_login_custom_no_role'] = 'External auth: Invalid result from custom auth (role is unknown; ID: "{0}").';
$lang['auth_login_custom_no_role_int'] = 'External auth: Invalid result from custom auth (role ID is not a number).';
$lang['auth_login_custom_no_group'] = 'External auth: Invalid result from custom auth (group is unknown; ID: "{0}").';
$lang['auth_login_custom_no_groups_array'] = 'External auth: Invalid result from custom auth (group IDs are not an array).';
$lang['auth_login_custom_no_groups_int'] = 'External auth: Invalid result from custom auth (group ID is not a number).';
$lang['auth_login_custom_no_email'] = 'External auth: Invalid result from custom auth script (email address is missing).';
$lang['auth_login_custom_invalid_email'] = 'External auth: Invalid result from custom auth script (email address has an invalid format).';
$lang['auth_login_custom_no_name'] = 'External auth: Invalid result from custom auth script (name is missing).';
$lang['auth_login_custom_no_user'] = 'External auth: Authenticated successfully, but no TestRail user was found for the given account.';

$lang['auth_login_custom_denied'] = 'External auth: Login or Password is incorrect.';
$lang['auth_login_custom_license'] = 'External auth: Authenticated successfully,
but cannot add a new user because the license limit has been reached ({0}/{1}).';

$lang['auth_forgotpassword_send'] = 'Reset Password';
$lang['auth_forgotpassword_disabled'] = 'Forgot Password is disabled for your TestRail installation. Please contact your administrator.';
$lang['auth_forgotpassword_disabled_sso'] = 'Forgot Password is disabled for your TestRail account. Please contact your administrator.';
$lang['auth_forgotpassword_success'] = 'Email sent successfully. Please check your email inbox for the reset password instructions.';
$lang['auth_forgotpassword_unknownemail'] = 'Unknown email address.';
$lang['auth_forgotpassword_emailfailed'] = 'Sending the password via email failed. Please contact your administrator (password was not changed).';
$lang['auth_forgotpassword_noemailserver'] = 'Sending the password failed: there is no email server configured (password was not changed). Please contact your administrator.';
$lang['auth_forgotpassword_not_supported'] = 'Your TestRail installation does not support password resets.
Please contact your TestRail administrator.
<br /><br />
If you are currently in the process of updating TestRail, please use the
<a href="https://www.gurock.com/testrail/docs/admin/installation/upgrading" target="_blank">command line updater</a>
to finish the update.';

$lang['auth_csrf_missing'] = 'The CSRF token is missing or invalid for this POST request.
This usually means that your session has expired. Please refresh this page.';
$lang['auth_ajax_error'] = 'You are not logged in or your session has timed out. Please refresh this page and log in again.';
$lang['auth_ip_check'] = 'Access denied from your location and/or IP address. Please contact your TestRail administrator.';
$lang['auth_admin_check'] = 'This operation requires administrator rights which are not enabled for your user account.';
$lang['auth_password_reset_required'] = 'The administrator has forced a password reset. Please check your email for further instructions.';

$lang['session_label_continue_working'] = 'Your session is about to expire due to inactivity';
$lang['session_ajax_continue_working'] = '  Continue working?';
$lang['auth_invalid_issuer'] = 'Your IDP is not configured with this testrail instance.';

$lang['auth_confirm'] = 'Confirm';
$lang['confirm_password_mismatch'] = 'The passwords did not match.';
$lang['auth_warning'] = 'Warning!';
$lang['layout_warning_js_login'] = 'Javascript is disabled in your web browser. Please enable Javascript, as Javascript is required to use TestRail.';
$lang['auth_login_user_inactive'] = 'Your TestRail account has been deactivated. Please contact your administrator.';
$lang['auth_login_sso_incorrect_attributes'] = 'SSO has not been configured correctly. Please contact your administrator.';
$lang['auth_login_locked_for_db_restoration'] = 'TestRail has been frozen pending a database restoration. Please try back later or contact an administrator.';
$lang['auth_oauth_login_with'] = 'or login with';

$lang['auth_login_exception_occured'] = 'Login: Exception occured. Code: {0}, Message: {1}';
$lang['auth_log_no_mail_attribute'] = 'SSO: Mail attribute not existant in samlUserData';
$lang['auth_log_sso_disabled'] = 'SSO: SSO disabled in instance. Existing...';
$lang['auth_log_sso_create_new_user_disabled'] = 'SSO: Creating new user for SSO disabled. Exiting...';
$lang['auth_log_saml_user_data_not_present'] = 'SSO: samlUserData not found in session. Exiting...';
$lang['auth_sso_exception_occured'] = 'SSO: Exception occured. Code: {0}, Message: {1}';
$lang['mfa_code_app'] = 'Enter the 6-digit code<br> available in your Authenticator app:';
$lang['mfa_code_email'] = 'Enter the 6-digit code<br> we\'ve just sent to your email:';
$lang['mfa_new_code_email'] = 'We\'ve sent you a NEW code. <br> Enter it below:';
$lang['send_new_code'] = 'Send me new code';
$lang['code_not_received'] = 'I didn\'t receive the code';
$lang['mfa_error_text'] = '<center>Entered code is incorrect.<br> Please try again.</center>';
$lang['mfa_code'] = 'Code';

$lang['whitelist_email_domain_error'] = 'Authenticated successfully, but cannot create user account. Please contact your TestRail administrator.';
