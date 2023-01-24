<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

$lang['uiscripts_invalid_header'] = 'Line {0} uses an invalid format ("name: value" expected).';
$lang['uiscripts_invalid_regex'] = 'Line "{0}" uses an invalid regular expression.';
$lang['uiscripts_invalid_code'] = 'No code section specified (use "js:" or "css:").';
$lang['uiscripts_duplicate_header'] = 'Duplicate name "{0}" in header.';
$lang['uiscripts_duplicate_language'] = 'Duplicate code section for language "{0}".';
$lang['uiscripts_no_name'] = 'Name missing ("name") in script description.';

$lang['uiscripts_success_add'] = 'Successfully added the new UI script.';
$lang['uiscripts_success_update'] = 'Successfully updated the UI script.';
$lang['uiscripts_success_delete'] = 'Successfully deleted the UI script.';

$lang['uiscripts_add'] = 'Add UI Script';
$lang['uiscripts_save'] = 'Save UI Script';
$lang['uiscripts_save_and_continue'] = 'Save &amp; Continue Editing';
$lang['uiscripts_delete_confirm'] = 'Really delete UI script <strong>{0}</strong>? Note that this cannot be undone.';

$lang['uiscripts_uiscript'] = 'UI Script';
$lang['uiscripts_empty'] = 'No UI scripts.';
$lang['uiscripts_config'] = 'Configuration';
$lang['uiscripts_config_desc'] = 'Enter or paste the configuration and source code for the UI script.
The script can contain JavaScript or CSS code to customize your TestRail installation.
<a class="link" target="_blank" href="https://www.gurock.com/testrail/docs/customization/ui-scripts/introduction">Learn more</a>';
$lang['uiscripts_isactive'] = 'This UI script is active';
$lang['uiscripts_status'] = 'Status';
$lang['uiscripts_status_active'] = 'Active';
$lang['uiscripts_status_inactive'] = 'Inactive';
$lang['uiscripts_isactive_desc'] = 'Only active UI scripts are included on the TestRail pages for your
installation.';
$lang['uiscripts_disabled'] = 'Your UI scripts were temporarily disabled';
$lang['uiscripts_disabled_desc'] =
'Your UI scripts were disabled as part of the update to TestRail 4.0 or later.
TestRail 4.0 comes with major changes to TestRail\'s user interface and HTML/CSS code.
Please make sure to review your UI scripts for possible compatibility issues and update
them as needed before enabling them again.';

$lang['uiscripts_template'] = "name: Hello world
description: Shows a 'Hello, world!' message on the dashboard
author: Gurock Software
version: 1.0
includes: ^dashboard
excludes:

js:
$(document).ready(
	function() {
		alert('Hello, world!');
	}
);

css:
div.some-class {
}";
