<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

$lang['templates_template'] = 'Template';
$lang['templates_name'] = 'Name';
$lang['templates_name_desc'] = 'Ex: <em>Test Case (Steps)</em>, <em>Exploratory Session</em> or <em>Automated</em>';

$lang['templates_isdefault'] = 'This template is the default template';
$lang['templates_isdefault_desc'] = 'The default template is the pre-selected template for new
cases and the fallback when you delete other templates. Only one template can be selected
as the default.';

$lang['templates_include'] = 'Include All';
$lang['templates_include_all'] = 'This template applies to all projects';
$lang['templates_include_all_desc'] = 'Select this option to use this template with all projects (including future projects).';
$lang['templates_include_specific'] = 'This template applies to the following projects only';
$lang['templates_include_specific_desc'] = 'You can alternatively select the projects this template should apply to.
This is useful to limit a template to select projects.';
$lang['templates_projects'] = 'Projects';

$lang['templates_validation_projects'] = 'Please select at least one project or use the global option.';
$lang['templates_validation_projects_default'] = 'The default template needs to apply to all projects.';

$lang['templates_errors_no_default'] = 'No default template found.';
$lang['templates_errors_is_default'] = 'The template is the default template and cannot be deleted.';

$lang['templates_add'] = 'Add Template';
$lang['templates_save'] = 'Save Template';
$lang['templates_delete_confirm'] = 'Really delete template <strong>{0}</strong>? Cases with this template will be assigned the default template.';
$lang['templates_delete_confirm_checkbox'] = 'Yes, delete this template (cannot be undone)';

$lang['templates_success_add'] = 'Successfully added the new template.';
$lang['templates_error_default'] = 'Deleting the default template is not allowed.';
$lang['templates_success_update'] = 'Successfully updated the template.';
$lang['templates_success_delete'] = 'Successfully deleted the template.';

$lang['templates_fields'] = 'Show fields that apply to this template';
$lang['template_id'] = 'Template Id';
