<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$lang['update_title'] = 'TestRail Update Wizard';
$lang['update_intro'] = 'To complete the TestRail update, some database changes are required.
This wizard helps you to update your TestRail database to the new version. Please make a
backup of your TestRail installation and database, review the following settings and click
the Update button to proceed.';
$lang['update_cassandra_intro'] = 'To complete the TestRail update, some changes are required.
This release introduces Cassandra for storing attachments. This wizard helps you to set up your Cassandra database.
Please make a backup of your TestRail installation and database, fill the following fields and click
the Update button to proceed.';

$lang['update_attachment_migration_status'] = 'Migration status';
$lang['update_attachment_migrate_intro'] = 'We are migrating your attachments. Please wait until the process finishes.';
$lang['update_attachment_migrate_to_database_in_progress_intro'] = 'We are migrating your attachments from Cassandra to filesystem. Please wait until the process finishes.';
$lang['update_attachment_migrate_to_database_intro'] = 'We are going to migrate your attachments from Cassandra to filesystem.';
$lang['update_attachment_migration_status_scheduled'] = 'Scheduled';
$lang['update_attachment_migration_status_migrating_attachments'] = 'Migrating attachments';
$lang['update_attachment_migration_status_migrating_entities'] = 'Migrating entities';
$lang['update_attachment_migration_status_done'] = 'Done';

$lang['update_confirm'] = 'Confirm Update';
$lang['update_confirm_desc'] = 'This update requires major changes to your database. Please take
the time to create a backup of your installation and database.';
$lang['update_confirm_intro'] = 'This update requires major changes to your database.
Please <a href="https://www.gurock.com/testrail/docs/admin/server/backup" target="_blank">make a backup</a> of your current installation before proceeding and confirm it by writing <strong><em>Yes, I made a backup</em></strong> into the textbox.
You can also consider testing this update on a <a href="https://www.gurock.com/testrail/docs/admin/server/staging" target="_blank">staging server</a> first before applying it to your production installation.';
$lang['update_confirm_required'] = 'Please take the time to create a backup and confirm it.';

$lang['update_step'] = 'Update Step';
$lang['update_from'] = 'Update From';
$lang['update_to'] = 'Update To';
$lang['update_version_app'] = 'TestRail version';
$lang['update_version_cur_db'] = 'Your database version';
$lang['update_version_new_db'] = 'New database version';
$lang['update_version_cur_cassandra'] = 'Your Cassandra version';
$lang['update_version_new_cassandra'] = 'New Cassandra version';

$lang['update_filecheck'] = 'Checking installation files';

$lang['update_license'] = 'License Key';
$lang['update_license_error'] = '<strong>There is a problem with your current TestRail license:</strong> {0}
You are not eligible to update to the new version until you enter a new license key.
<br /><br />
<div class="button-group">
<a class="button button-left button-login" {1}>Update License Key</a>
</div>';
$lang['update_license_invalid'] = 'Invalid or missing license.';
$lang['update_license_nosupport'] = '<strong>Your current license key indicates that your support plan has expired on {0}</strong>.
You are not eligible to update to the new version and please <a href="https://secure.gurock.com/portal/" target="_blank">renew your support plan</a>.
If you\'ve already renewed the support plan, please make sure to apply the new license key.
<br /><br />
<div class="button-group">
<a class="button button-left button-login" {1}>Update License Key</a>
</div>';
$lang['update_license_dialog'] = 'Update License';
$lang['update_license_dialog_key'] = 'License Key';
$lang['update_license_dialog_key_desc'] = 'Your trial or full TestRail license key.';
$lang['update_license_dialog_save'] = 'Save License Key';

$lang['update_backup'] = '<strong>Please note:</strong> In order to complete the TestRail update,
this wizard needs to make changes to your database. It is strongly recommended to
<a href="https://www.gurock.com/testrail/docs/admin/server/backup" target="_blank">make a backup</a>
of your TestRail installation and database before proceeding.';
$lang['update_support'] = 'If you have any questions about this update, please contact the
<a href="http://www.gurock.com/support/" target="_blank">Gurock Software support</a>.';

$lang['update_result'] = 'Please see below for the result of the update and the next steps.';
$lang['update_success'] = 'Congratulations, all update steps were performed successfully and you
have fully updated your TestRail installation to the new database version. You can now return
to TestRail.';
$lang['update_success_back'] = 'Back to TestRail';

$lang['update_nosteps'] = 'Your TestRail installation and database were already up-to-date.
No updates were installed.';

$lang['update_result_step'] = 'Updating to database version {0}';
$lang['downgrade_result_step'] = 'Downgrading to database version {0}';
$lang['update_result_success'] = 'Success';
$lang['update_result_error'] = 'Error';
$lang['update_result_details'] = '(details below)';

$lang['update_result_error_desc'] = 'Please return to the previous wizard page to adjust your settings
and try the update again. If you are unsure on how to solve this problem, please contact
the <a href="http://www.gurock.com/support/" target="_blank">Gurock Software support</a>.
Please make sure to include the full error message in your support request.';

$lang['update_error_step_too_low'] = 'Update {0} was already applied. Your database version is {1}/{2}.';
$lang['update_error_step_too_high'] = 'Update {0} does not exist. Your database version is {1}/{2}.';
$lang['update_error_too_old_db'] = 'Database is too old for running migrations';
$lang['update_dbversion_migrations_missing'] = 'The instance does not have db/migrations folder needed for downgrade';
$lang['update_migration_failed'] = 'Migration failed with the error:
{0}';

$lang['update_error_updatefile'] = 'Couldn\'t open database update file "{0}".';
$lang['update_error_queryfailed'] = 'The following database query failed with the error
"{0}": {1}';

$lang['update_cli_db_newer'] = 'Your TestRail installation requires an older database version (version {0} or less required, but found {1}). Please make sure to use the TestRail version that matches your database version or contact the Gurock Software support in case you have any questions.';
$lang['update_cli_db_matches'] = 'Your TestRail database is up-to-date (version {0}).';
$lang['update_cli_db_older'] = 'Your TestRail installation requires a database update (from version {0} to {1}). Please take the time to create a backup of your database before running the update.
Continue? - Cancel with Ctrl+C, confirm with Enter .. ';
$lang['update_cli_db_upgraded'] = 'Successfully upgraded your TestRail database to the latest version ({0}).';
$lang['update_cli_db_updating'] = 'Applying update {0} .. ';
$lang['update_cli_db_upgraded'] = 'Successfully upgraded your TestRail database to the latest version ({0}).';
$lang['update_cli_license_error'] = 'There is a problem with your current TestRail license: {0} Please update the license key of your TestRail installation via the web interface to continue with the update.';
$lang['update_cli_license_invalid'] = 'Invalid or missing license.';
$lang['update_cli_license_nosupport'] = 'Your current license key indicates that your support plan has expired on {0}. You are not eligible to update to the new version and please renew your support plan. If you\'ve already renewed the support plan, please make sure to apply the new license key via TestRail\'s web interface.';
