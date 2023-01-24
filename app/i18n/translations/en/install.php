<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$lang['install_page_title'] = 'TestRail Installation Wizard: Step {0}';
$lang['install_title'] = 'TestRail Installation Wizard';
$lang['install_step'] = 'Step {0}/{1}';
$lang['install_button_previous'] = 'Previous';
$lang['install_button_next'] = 'Next';
$lang['install_button_install'] = 'Install';

$lang['install_wizard_step'] = 'Wizard Step';
$lang['install_wizard_direction'] = 'Wizard Direction';

// Welcome page
$lang['install_welcome'] = 'Welcome to the TestRail installation wizard. This wizard will guide you through the installation
and configuration of TestRail. It will help you prepare the TestRail database, configure all required
settings and create your first user account. If any questions come up during the installation, do not
hesitate to contact the <a href="http://www.gurock.com/support/" target="_blank">Gurock Software support</a>.';
$lang['install_license_title'] = 'TestRail License Terms';
$lang['install_license_description'] = 'Please read and accept the TestRail license terms before continuing with the installation.';
$lang['install_accept_license_checkbox'] = 'I accept the TestRail license terms';
$lang['install_accept_license'] = 'Accept TestRail License Terms';
$lang['install_accept_license_error'] = 'Please accept the TestRail license terms.';

$lang['install_version_app'] = 'TestRail version';
$lang['install_filecheck'] = 'Checking installation files';

// Database Settings
$lang['install_database_introduction'] = 'Please create a
<a target="_blank" href="https://www.gurock.com/testrail/docs/admin/">new empty database</a> and
database account for TestRail and enter the connection details below.';
$lang['install_database_title'] = 'Database Settings';
$lang['install_database_title_result'] = 'Creating Database Schema';

$lang['install_database_exists_error'] = 'A TestRail installation was already found in the
specified database. In case you want to override the TestRail installation, please manually
delete the database tables before you can proceed.<br />
<br />
If you just want to update your TestRail installation to a new version instead, please see
the <a target="_blank" href="https://www.gurock.com/testrail/docs/admin/installation/upgrading">update instructions</a> for details.<br />
<br />
In case you want to switch your trial
installation to a full installation, please just navigate your browser to your trial installation
and enter the license key under Administration &gt; License.';
$lang['install_database_create_table_error'] = 'Could not create a temporary database table.
Please check the database permissions for the specified user: {0}';
$lang['install_database_delete_table_error'] = 'Could not delete a temporary database table.
Please check the database permissions for the specified user: {0}';
$lang['install_database_sqlsrvwarning'] = 'You are installing TestRail on Windows, but the SQL Server PHP extension is not available. Please
<a href="https://www.gurock.com/testrail/docs/admin/howto/installing-sqlsrv" target="_blank">install the extension</a> if you want to connect
to a SQL Server database.';
$lang['install_database_nodriver'] = 'TestRail requires a MySQL or SQL Server database to operate but your
PHP installation does not provide a supported driver (<code>mysql</code> or <code>sqlsrv</code>). Please see the TestRail
<a href="https://www.gurock.com/testrail/docs/admin/installation/windows" target="_blank">installation guide for Windows</a>
or the
<a href="https://www.gurock.com/testrail/docs/admin/installation/unix" target="_blank">installation guide for Unix/Linux</a>
for more information.';
$lang['install_database_mysql_no_innodb'] = 'InnoDB storage engine not supported or enabled';

// Cassandra Settings
$lang['install_cassandra_introduction'] = 'Please create a
<a target="_blank" href="https://www.gurock.com/testrail/docs/admin/">new empty keyspace</a>
for TestRail and enter the connection details below.';
$lang['install_cassandra_title'] = 'Cassandra Settings';
$lang['install_cassandra_title_result'] = 'Creating Cassandra Schema';

$lang['install_cassandra_exists_error'] = 'A TestRail installation was already found in the
specified keyspace. In case you want to override the TestRail installation, please manually
delete the keyspace tables before you can proceed.<br />
<br />
If you just want to update your TestRail installation to a new version instead, please see
the <a target="_blank" href="https://www.gurock.com/testrail/docs/admin/installation/upgrading">update instructions</a> for details.<br />
<br />
In case you want to switch your trial
installation to a full installation, please just navigate your browser to your trial installation
and enter the license key under Administration &gt; License.';
$lang['install_cassandra_nodriver'] = 'TestRail requires a Cassandra database to operate but your
PHP installation does not provide a supported driver (<code>cassandra</code>). Please see the TestRail
<a href="https://www.gurock.com/testrail/docs/admin/installation/windows" target="_blank">installation guide for Windows</a>
or the
<a href="https://www.gurock.com/testrail/docs/admin/installation/unix" target="_blank">installation guide for Unix/Linux</a>
for more information.';

// RabbitMQ Settings
$lang['install_rabbitmq_introduction'] = 'Please enter the RabbitMQ connection details below.';
$lang['install_rabbitmq_title'] = 'RabbitMQ Settings';
$lang['install_rabbitmq_title_result'] = 'Saving RabbitMQ Settings';

// Application Settings
$lang['install_application_introduction'] = 'Please enter all required TestRail application settings below.
Where possible, this installation wizard tried to determine default settings.';
$lang['install_application_title'] = 'Application Settings';
$lang['install_application_title_result'] = 'Saving Application Settings';

// Email Settings
$lang['install_email_introduction'] = 'Please enter your email server details below. The server settings are used for
email notifications and for the Forgot Password functionality.';
$lang['install_email_title'] = 'Email Settings';
$lang['install_email_title_result'] = 'Saving Email Settings';

// Administrator User Account
$lang['install_account_introduction'] = 'Create your first user account and enter your TestRail license key below.
You will have the chance to review all your settings on the next wizard page.';
$lang['install_account_title'] = 'Administrator Account';
$lang['install_account_title_result'] = 'Creating Administrator User Account';

// License Key
$lang['install_key_introduction'] = 'Paste your trial or full license key below. If you
haven\'t received a license key when you downloaded the software, please contact the
<a href="http://www.gurock.com/support/" target="_blank">Gurock Software support</a>.';
$lang['install_key_title'] = 'License Key';
$lang['install_key_title_result'] = 'Activating TestRail License Key';

// Review Settings
$lang['install_review_introduction'] = 'Review your settings below and press the Install button
to install TestRail. Please also review the notes on the next wizard page to finalize the installation.';

// Result
$lang['install_dbversion_title_result'] = 'Writing Database Version';
$lang['install_config_title_result'] = 'Writing Configuration File';
$lang['install_config_error'] = 'Couldn\'t write the configuration file';
$lang['install_config_error_template'] = 'Could not open the configuration template: {0}.';
$lang['install_result_introduction'] = 'Please see below for the result of the installation and the required next steps.';
$lang['install_result_install_title'] = 'Installation Result';
$lang['install_result_success'] = 'Success';
$lang['install_result_warning'] = 'Warning';
$lang['install_result_error'] = 'Error';
$lang['install_result_details'] = '(details below)';
$lang['install_result_task_title'] = 'Install TestRail Background Task';
$lang['install_result_task_desc'] = '<p>Some TestRail features such as the email notifications rely
on a background task. You need to activate the TestRail background
task to finalize the installation. To setup the background task,
you need to configure it in the Task Scheduler (Windows) or Cron (Unix/Linux).
Learn more:</p>

<p><strong>&raquo; <a target="_blank" href="https://www.gurock.com/testrail/docs/admin/howto/background-task">Activating the TestRail background task</a></strong></p>';
$lang['install_result_error_desc'] = 'Please return to the previous wizard page to adjust your settings and try the
installation again. If you are unsure on how to solve this problem, please contact
the <a href="http://www.gurock.com/support/" target="_blank">Gurock Software support</a>.
Please make sure to include the full error message in
your support request.';

$lang['install_result_config_warning'] =
'<p class="top">The installation wizard couldn\'t write the TestRail configuration file.
This is not unusual, as the web server often doesn\'t have the permissions
needed to create new files. However, to complete the installation, <strong>you
must create the TestRail config file manually</strong>.</p>

<p>Please copy the following
configuration settings to a file called <strong>config.php</strong> and place it
in the TestRail	installation directory (next to index.php).</p>';
$lang['install_result_config_saveto'] = 'Save this file to: <strong>{0}</strong>';
$lang['install_result_config_na'] = 'Please make sure to create the config.php
file in TestRail\'s installation directory to complete the installation (and ensure that
the web server has read permissions for this file).';

$lang['install_result_login_title'] = 'Log in to TestRail';
$lang['install_result_login_desc'] = 'Congratulations! You have successfully installed and configured TestRail.
You can now log in to TestRail and create your first project, add additional
user accounts and start organizing your software testing efforts.';
$lang['install_result_login_button'] = 'Log in to TestRail';

// Controller
$lang['install_error'] = 'An error occurred ({0}): {1}';
$lang['install_warning'] = 'Warning ({0}): {1}';
$lang['install_error_updatefile'] = 'Couldn\'t open database update file "{0}".';
$lang['install_error_cqlfile'] = 'Couldn\'t open Cassandra update file "{0}".';
$lang['install_error_noqueries'] = 'Update file "{0}" is invalid (no queries defined).';
$lang['install_error_nocqlqueries'] = 'Update file "{0}" is invalid (no CQL queries defined).';
$lang['install_error_queryfailed'] = 'The following database query
failed with the error "{0}": {1}';
$lang['install_error_appsetting'] = 'Couldn\'t write database setting "{0}": {1}';
