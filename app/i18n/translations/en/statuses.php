<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

$lang['statuses_status'] = 'Status';
$lang['statuses_label'] = 'Label';
$lang['statuses_label_desc'] = 'Ex: <em>Passed</em>, <em>Failed</em> or <em>Untested</em>';
$lang['statuses_name'] = 'System Name';
$lang['statuses_name_desc'] = 'The unique name of this status, used as identifier for the export, among other things. Should be all lower case, no spaces.';
$lang['statuses_isactive'] = 'This status is active';
$lang['statuses_isactive_desc'] = 'Only active statuses are selectable when adding a new test result.';
$lang['statuses_isfinal'] = 'This status is a final status';
$lang['statuses_isfinal_desc'] = 'Tests with a final status are considered completed and add to the overall progress of a test run on the Progress tabs (such as Passed, Failed or Blocked).';
$lang['statuses_color_dark'] = 'Color (Dark)';
$lang['statuses_color_dark_desc'] = 'The dark base color for this status in the UI, used for the status box (above), among other things. This field expects a full RGB color in hex notation (e.g. 00FF00 for green, FF0000 for red.';
$lang['statuses_color_medium'] = 'Color (Medium)';
$lang['statuses_color_medium_desc'] = 'The medium bright base color for this status in the UI, used mainly for the charts (pie, bar and line). Expects the same format as the dark base color.';
$lang['statuses_color_bright'] = 'Color (Bright)';
$lang['statuses_color_bright_desc'] = 'The bright base color for this status in the UI, used where the darker colors would be too intense. Expects the same format as the previous colors.';

$lang['statuses_save'] = 'Save Status';
$lang['statuses_howto_add'] = 'Please edit an existing, inactive status to add a new status to your installation.';
$lang['statuses_system'] = '<strong>Please note:</strong> You are editing a system status. Some properties cannot be changed.';
$lang['statuses_success_update'] = 'Successfully updated the status.';
$lang['statuses_no_status'] = 'The specified status does not exist.';

$lang['statuses_validation_unique'] = 'System Name already in use. Please choose another name for your status.';
$lang['statuses_validation_invalid_name'] = 'Invalid characters in System Name: please only use a-z (lower case), 0-9 and underscore characters.';
