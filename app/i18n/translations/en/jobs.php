<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

$lang['jobs_unknown'] = 'Unknown job "{0}".';
$lang['jobs_no_class'] = 'Implementation class missing for job "{0}".';
$lang['jobs_no_meta'] = 'Meta function missing for job "{0}".';

$lang['jobs_check_for_update_invalid_version'] = 'Returned version uses invalid format: "{0}".';

$lang['jobs_export_mkdir_error'] = 'Could not create directory {0}: {1}';
$lang['jobs_export_chdir_error'] = 'Could not change to export directory {0}: {1}';
$lang['jobs_export_zip_error'] = 'Creating the ZIP failed: {0}';
$lang['jobs_export_tmpdir_invalid'] = 'Invalid temporary directory: {0}';

$lang['jobs_export_readme'] = 
'This is a full database export & backup archive for the TestRail
account at {0}. It contains the SQL files,
uploaded images, attachments and created reports needed to restore
the entire installation to a local server. You can learn more about
restoring the data and installing TestRail on the following website:

https://www.gurock.com/testrail/docs/admin/server/restoring';
$lang['jobs_export_readme_error'] = 'Creating the readme failed: {0}';

$lang['jobs_export_gc_unlink_error'] = 'Could not delete old export: {0}';

$lang['jobs_audit_log_unlink_error'] = 'Could not delete audit log file: {0}';
