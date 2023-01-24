<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

$lang['priorities_priority'] = 'Priority';
$lang['priorities_name'] = 'Name';
$lang['priorities_name_desc'] = 'Ex: <em>High</em>, <em>4 - Must Test</em> or <em>Don\'t Test</em>';
$lang['priorities_short_name'] = 'Abbreviation';
$lang['priorities_short_name_desc'] = 'A shorter version of the full name.
Is used to display the priority in grids and tables. Leave empty to use the full name.';

$lang['priorities_isdefault'] = 'This priority is the default priority';
$lang['priorities_isdefault_desc'] = 'The default priority is the pre-selected type for new
cases and the fallback type when you delete other priorities. Only one priority can be selected
as the default.';

$lang['priorities_errors_no_default'] = 'No default priority found.';
$lang['priorities_errors_is_default'] = 'The priority is the default priority and cannot be deleted.';

$lang['priorities_add'] = 'Add Priority';
$lang['priorities_save'] = 'Save Priority';
$lang['priorities_delete_confirm'] = 'Really delete priority <strong>{0}</strong>? Cases with this priority will be assigned the default priority.';
$lang['priorities_delete_confirm_checkbox'] = 'Yes, delete this priority (cannot be undone)';

$lang['priorities_success_add'] = 'Successfully added the new priority.';
$lang['priorities_error_default'] = 'Deleting the default priority is not allowed.';
$lang['priorities_success_update'] = 'Successfully updated the priority.';
$lang['priorities_success_delete'] = 'Successfully deleted the priority.';
$lang['priorities_no_priority'] = 'The specified priority does not exist.';
