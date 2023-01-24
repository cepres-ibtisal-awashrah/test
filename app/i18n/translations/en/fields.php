<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

$lang['fields_intro'] = '<strong>Please note:</strong> Don\'t forget to assign this field to your projects below. <a href="https://www.gurock.com/testrail/docs/user-guide/howto/fields" target="_blank">Learn more</a>';
$lang['fields_no_field'] = 'The specified custom field does not exist.';
$lang['fields_no_projects'] = 'Please select at least one project or use the global option.';
$lang['fields_no_context'] = 'Missing custom field context (global or specific projects).';
$lang['fields_no_options'] = 'Missing custom field options (default value, required, etc.).';
$lang['fields_invalid_format'] = 'Invalid encoding format for custom field configuration(s).';
$lang['fields_invalid_options'] = 'Invalid or incomplete options.
Please enter all required fields and check the format of your options.';

$lang['fields_validation_unique'] = 'System Name already in use. Please choose another name for your custom field.';
$lang['fields_validation_invalid_name'] = 'Invalid characters in System Name: please only use a-z (lower case) and underscore characters.';
$lang['fields_validation_projects'] = 'At least one project was assigned more than one option set. Please correct the options and project assignments and try again.';
$lang['fields_validation_projects_invalid'] = 'Invalid project id is passed. Please correct the options and project assignments and try again.';
$lang['fields_validation_templates'] = 'Please select at least one template or use the global option.';
$lang['fields_validation_templates_invalid'] = 'Invalid template id is passed. Please correct the template_ids field and try again.';
$lang['fields_validation_no_type'] = 'Invalid or missing custom field type. Please check the Type field.';
$lang['fields_validation_no_empty_config'] = "Field 'configs' cannot be empty.";
$lang['fields_validation_singleton'] = 'This custom field type can only be added once and there is already a custom field for this type.';
$lang['fields_validation_steps_has_expected'] = 'Invalid has_expected option. Available options is (1, 0, true, false)';
$lang['fields_validation_dropdown_default'] = 'Invalid option value for default_value (available values {1}).';
$lang['fields_validation_checkbox_default'] = 'Invalid default_value option. Available options is (1, 0, true, false).';
$lang['fields_validation_no_default'] = 'Option default_value is not allowed for this type of field.';
$lang['fields_validation_no_empty_ids'] = 'Field \'ids\' cannot be empty.';

$lang['fields_empty'] = 'No fields.';
$lang['fields_entity_id'] = 'Entity';
$lang['fields_field'] = 'Custom Field';
$lang['fields_grid_case'] = 'Case Field';
$lang['fields_grid_test'] = 'Result Field';

$lang['fields_success_add'] = 'Successfully added the new custom field.';
$lang['fields_success_update'] = 'Successfully updated the field.';
$lang['fields_success_delete'] = 'Successfully deleted the custom field (or scheduled for deletion).';
$lang['fields_error_deleting'] = 'This operation is not allowed. This custom field is currently being deleted
or scheduled for deletion.';
$lang['fields_error_installing'] = 'This operation is not allowed. This field is currently being installed
or scheduled for installation.';
$lang['fields_error_not_installing'] = 'This operation is not allowed. This field is not scheduled for installation.';
$lang['fields_error_not_deleting'] = 'This operation is not allowed. This field is not scheduled for deletion.';
$lang['fields_error_system'] = 'This operation is not allowed. This field is a system field.';

$lang['fields_dialog_title'] = 'Configure Options';
$lang['fields_generic_required'] = 'Field :{0} is a required field';
$lang['fields_dialog_required'] = 'This field is a required field';
$lang['fields_dialog_required_desc'] = 'Whether users must enter this field or can leave it empty.';
$lang['fields_dialog_default'] = 'Default Value';
$lang['fields_dialog_default_desc'] = 'The pre-selected/pre-filled value of this field in forms.';
$lang['fields_dialog_global'] = 'These options apply to all projects';
$lang['fields_dialog_global_desc'] = 'The field appears in all projects and has the same options everywhere.';
$lang['fields_dialog_projects'] = 'These options apply to the following projects only';
$lang['fields_dialog_projects_desc'] = 'The field appears in the following projects only.
This allows you to add different field configurations per project.';
$lang['fields_dialog_items'] = 'Items';
$lang['fields_dialog_items_placeholder'] = '1, Option 1';
$lang['fields_dialog_items_desc'] = 'Enter one item per line. Items must have the following format:
<strong>id,name</strong> (id must be a unique number).';
$lang['fields_dialog_textformat'] = 'Text Format';
$lang['fields_dialog_textformat_desc'] = 'The text format of this field.
Choose between plain text or rich-text formats such as Markdown.';
$lang['fields_dialog_tabs_options'] = 'Options';
$lang['fields_dialog_tabs_context'] = 'Selected Projects';
$lang['fields_dialog_rows'] = 'Rows';
$lang['fields_dialog_rows_desc'] = 'This value specifies the initial size of the field when the user loads a form.
The field can be resized by the user as needed.';
$lang['fields_dialog_rows_text_desc'] = 'This value specifies the size of the texts fields (actual step content and expected result).';
$lang['fields_dialog_nooptions'] = 'This field does not have any type-specific options.';
$lang['fields_dialog_steps_expected'] = 'Use a separate Expected Result field for each step';
$lang['fields_dialog_steps_expected_desc'] = 'This adds a second field to each test step to enter your expected results in a more structured way.';
$lang['fields_dialog_results_expected'] = 'Use a separate Expected Result field for each step';
$lang['fields_dialog_results_expected_desc'] = 'This shows the separate expected result field for a step (also needs to be configured for the steps custom field for test cases).';
$lang['fields_dialog_additional_step_information'] = 'Use an extra field for additional step information';
$lang['fields_dialog_additional_step_information_desc'] = 'This adds a field to each test step for additional test step content.';
$lang['fields_dialog_results_additional_information_desc'] = 'Use an extra field for additional step information (also needs to be configured for the steps custom field for test cases).';
$lang['fields_dialog_reference'] = 'Use a References field for each step';
$lang['fields_dialog_reference_desc'] = 'This adds a References field to each test step in order to link to external requirements, user stories, etc. ';
$lang['fields_dialog_results_reference_desc'] = 'This adds a References field to each test step in order to link to external requirements, user stories, etc. (also needs to be configured for the steps custom field for test cases).';
$lang['fields_dialog_results_actual'] = 'Use a separate Actual Result field for each step';
$lang['fields_dialog_results_actual_desc'] = 'This shows a separate text box for each step to record the actual result.';

$lang['fields_checked'] = 'Checked';
$lang['fields_unchecked'] = 'Unchecked';

$lang['fields_add'] = 'Add Field';
$lang['fields_save'] = 'Save Field';
$lang['fields_set_options'] = 'Set options';
$lang['fields_save_options'] = 'Save Options';

$lang['fields_tabs_field'] = 'Custom Field';
$lang['fields_tabs_options'] = 'Project Assignments';

$lang['fields_context_global'] = 'All Projects';
$lang['fields_options_format_plain'] = 'Format: Plain Text';
$lang['fields_options_format_markdown'] = 'Format: Markdown';

$lang['fields_delete_confirm'] = 'Really delete custom field <strong>{0}</strong>? This also fully deletes the data behind this field and cannot be undone.';
$lang['fields_delete_confirm_checkbox'] = 'Yes, delete this custom field (cannot be undone)';
$lang['fields_delete_confirm_extra'] = 'Deleting a field is a high impact and irrevocable action. Please make sure to understand the consequences of this action. You can alternatively also just set the field to inactive instead.';
$lang['fields_delete_config_confirm'] = 'Really delete these options (cannot be undone)? This removes this field from the related projects.';
$lang['fields_change_type_confirm'] = 'You already added some options to this field. These options are removed when you change the field type (because each type has its own set of options). Continue?';

$lang['fields_label'] = 'Label';
$lang['fields_label_api'] = '\'label\'';
$lang['fields_label_desc'] = 'The label of the field as it appears in the user interface.';
$lang['fields_description'] = 'Description';
$lang['fields_description_api'] = '\'description\'';
$lang['fields_description_desc'] = 'The description is shown next to the field, if applicable.';
$lang['fields_include'] = 'Include All';
$lang['fields_include_api'] = '\'include_all\'';
$lang['fields_include_all'] = 'This field applies to all templates';
$lang['fields_include_all_desc'] = 'Select this option to use this field with all cases (of any kind and independently of the template).';
$lang['fields_include_specific'] = 'This field applies to the following templates only';
$lang['fields_include_specific_desc'] = 'You can alternatively select the templates this field should apply to.
This is useful to limit a field to cases of a certain template type.';
$lang['fields_templates'] = 'Templates';
$lang['fields_templates_api'] = '\'template_ids\'';
$lang['fields_name'] = 'System Name';
$lang['fields_name_api'] = '\'name\'';
$lang['fields_name_desc'] = 'The unique name of this field in the database. Should be all lower case, no spaces.
Please note: this name cannot be changed later.';
$lang['fields_type'] = 'Type';
$lang['fields_type_api'] = '\'type\'';
$lang['fields_type_desc'] = 'The type cannot be changed later.
Learn more about
<a class="link" tabindex="-1" target="_blank" href="https://www.gurock.com/testrail/docs/user-guide/howto/fields">field types</a>.';
$lang['fields_configs'] = 'Options';
$lang['fields_configs_api'] = '\'configs\'';
$lang['fields_active'] = 'Active';
$lang['fields_active_desc'] = 'This field is active';
$lang['fields_active_hint'] = 'Disabling a field can be useful to hide it from TestRail\'s
user interface without the need to delete the project assignments or the entire field (including data).';
$lang['fields_system'] = 'Is System';

$lang['fields_options_empty'] = 'No options assigned.';
$lang['fields_options_none'] = 'Not yet assigned to any projects.';
$lang['fields_options_add'] = 'Add Projects &amp; Options';

$lang['fields_options_various'] = '[various]';
$lang['fields_options_various_desc'] = 'The value for this field varies among the current selection.';
$lang['fields_options_notchanged'] = '[not changed]';
$lang['validation_session_timeout'] = 'Field {0} contains an invalid value. Please check for errors and try again.';
$lang['add_case_field_denied'] = 'You are not allowed to add a case field to one or more specified projects (requires administrator privileges).';
$lang['case_fields_templates_denied'] = 'You are not allowed to create test case fields (requires administrator privileges).';

$lang['fields_delete_from_template_confirm'] = 'Really delete custom field <strong>{0}</strong>? This field will be hidden from all test cases which use this template';
$lang['field_ids'] = 'Ids';
$lang['fields_validation_no_empty_config_for_manager'] = 'You must assign the field to at least one project.';
$lang['fields_validation_projects_configuration_failed'] = 'You can add or modify the configuration that contains only assigned projects.';
