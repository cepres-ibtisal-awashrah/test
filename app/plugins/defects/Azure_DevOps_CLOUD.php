<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

require_once APPPATH . 'plugins/defects/api/AzureDevOpsCloudApi.php';

/**
 * Azure DevOps Cloud Defect Plugin for TestRail
 *
 * Copyright Gurock Software GmbH. All rights reserved.
 *
 * This is the TestRail defect plugin for Azure DevOps. Please see
 * http://docs.gurock.com/testrail-integration/defects-plugins for
 * more information about TestRail's defect plugins.
 *
 * http://www.gurock.com/testrail/
 *
 */

class Azure_DevOps_CLOUD_defect_plugin extends Defect_plugin
{
    const DASH = '&ndash;';
    const DISABLED_FIELD_STRING = 'FIELD IS DISABLED FOR THIS ITEM TYPE';

    private $_api;
    private $_address;
    private $_project;
    private $_user;
    private $_password;

    private $_pushDefaultFields = [
        'title' => 'on',
        'item_type' => 'on',
        'assignee' => 'on',
        'priority' => 'on',
        'state' => 'on',
        'description' => 'on',
        'attachments' => 'on'
    ];

    private $_fieldDefaults = [
        'title' => [
            'label' => 'Title',
            'required' => true,
            'type' => 'string',
            'remember' => true,
            'size' => 'full',
            'api_field' => 'System.Title',
            'api_subfield_id' => null,
            'api_subfield_display' => null
        ],
        'item_type' => [
            'label' => 'Type',
            'required' => true,
            'type' => 'dropdown',
            'remember' => true,
            'size' => 'compact',
            'api_field' => 'System.WorkItemType',
            'api_subfield_id' => null,
            'api_subfield_display' => null,
            'cascading' => true
        ],
        'assignee' => [
            'label' => 'Assignee',
            'required' => false,
            'type' => 'dropdown',
            'remember' => true,
            'size' => 'compact',
            'api_field' => 'System.AssignedTo',
            'api_subfield_id' => 'principalName',
            'api_subfield_display' => 'displayName',
        ],
        'priority' => [
            'label' => 'Priority',
            'required' => false,
            'type' => 'dropdown',
            'remember' => false,
            'size' => 'compact',
            'api_field' => 'Microsoft.VSTS.Common.Priority',
            'api_subfield_id' => null,
            'api_subfield_display' => null
        ],
        'severity' => [
            'label' => 'Severity',
            'required' => false,
            'type' => 'dropdown',
            'remember' => false,
            'size' => 'compact',
            'api_field' => 'Microsoft.VSTS.Common.Severity',
            'api_subfield_id' => null,
            'api_subfield_display' => null
        ],
        'description' => [
            'label' => 'Description',
            'required' => false,
            'type' => 'text',
            'remember' => false,
            'rows' => 5,
            'api_field' => 'System.Description',
            'api_subfield_id' => null,
            'api_subfield_display' => null,
            'depends_on' => 'item_type'
        ],
        'repro_steps' => [
            'label' => 'Repro Steps',
            'required' => false,
            'type' => 'text',
            'remember' => false,
            'rows' => 5,
            'api_field' => 'Microsoft.VSTS.TCM.ReproSteps',
            'api_subfield_id' => null,
            'api_subfield_display' => null,
            'depends_on' => 'item_type'
        ],
        'system_info' => [
            'label' => 'System Info',
            'required' => false,
            'type' => 'text',
            'remember' => false,
            'rows' => 5,
            'api_field' => 'Microsoft.VSTS.TCM.SystemInfo',
            'api_subfield_id' => null,
            'api_subfield_display' => null,
            'depends_on' => 'item_type'
        ],
        'state' => [
            'label' => 'Status',
            'required' => false,
            'type' => 'dropdown',
            'remember' => false,
            'size' => 'compact',
            'api_field' => 'System.State',
            'api_subfield_id' => null,
            'api_subfield_display' => null,
            'depends_on' => 'item_type',
        ],
        'status' => [
            'label' => 'Status',
            'required' => false,
            'type' => 'dropdown',
            'remember' => false,
            'size' => 'compact',
            'api_field' => 'System.State',
            'api_subfield_id' => null,
            'api_subfield_display' => null,
            'depends_on' => 'item_type',
        ],
        'reason' => [
            'label' => 'Reason',
            'required' => false,
            'type' => 'dropdown',
            'remember' => false,
            'size' => 'compact',
            'api_field' => 'System.Reason',
            'api_subfield_id' => null,
            'api_subfield_display' => null
        ],
        'created_by' => [
            'label' => 'Created By',
            'required' => false,
            'type' => 'dropdown',
            'remember' => false,
            'size' => 'compact',
            'api_field' => 'System.CreatedBy',
            'api_subfield_id' => null,
            'api_subfield_display' => null
        ],
        'acceptance_criteria' => [
            'label' => 'Acceptance Criteria',
            'required' => false,
            'type' => 'text',
            'remember' => false,
            'size' => 'full',
            'api_field' => 'Microsoft.VSTS.Common.AcceptanceCriteria',
            'api_subfield_id' => null,
            'api_subfield_display' => null
        ],
        'attachments' => [
            'type' => 'dropbox',
            'label'=>'attachments',
            'required' => false,
            'size' => 'none',
            'remember' => false,
        ],
    ];

    private $_priorityList = [
        1 => 1,
        2 => 2,
        3 => 3,
        4 => 4
    ];

    private $_boolList = [
       0 => 'False',
       1 => 'True'
    ];

    private $_severityList = [
        '1 - Critical' => '1 - Critical',
        '2 - High' => '2 - High',
        '3 - Medium' => '3 - Medium',
        '4 - Low' => '4 - Low'
    ];

    private $_stateList = [
        'To Do' => 'To Do'
    ];

    private $_pushDefaultTypes = [
        'Bug' => 'on',
        'Issue' => 'on',
        'Task' => 'on'
    ];

    private $_hoverDefaultFields = [
        'item_type' =>'on',
        'state' =>'on',
        'reason' =>'on',
        'assignee' =>'on',
        'created_by' =>'on',
        'priority' =>'on',
        'severity' =>'on',
        'system_info' => 'on'
    ];

    protected static $_meta_defects = [
        'author' => 'Gurock Software',
        'version' => '1.0',
        'description' => 'Azure DevOps defect plugin for TestRail',
        'can_push' => true,
        'can_lookup' => true,
        'default_config' =>
            '; Please configure your Azure DevOps connection below
; You may need to create a personal access token to use as your password
; https://docs.microsoft.com/en-us/azure/devops/organizations/accounts/use-personal-access-tokens-to-authenticate?view=azure-devops
[connection]
address=https://dev.azure.com/organization
project=<your-project>
user=testrail
password=secret

[push.types]
Bug=on
Epic=off
Issue=on
Task=on
UserStory=off

;Title and Item Type are required
[push.fields]
item_type=on
reason=off
status=on
assignee=on
priority=on
severity=off
description=on
repro_steps=on
system_info=on
attachments=on

[type.settings.Bug]
description=off
repro_steps=default
system_info=on

[type.settings.Issue]
description=default
repro_steps=off
system_info=off

[type.settings.Task]
description=default
repro_steps=off
system_info=off

;Title, Issue Type, and State will always be included
[hover.fields]
item_type=on
reason=off
status=on
assignee=on
priority=on
severity=off
description=on
repro_steps=on
system_info=on
'];

    protected static $_meta_references = [
        'author' => 'Gurock Software',
        'version' => '1.0',
        'description' => 'Azure DevOps reference plugin for TestRail',
        'can_lookup' => true,
        'default_config' =>
            '; Please configure your Azure DevOps connection below
; You may need to create a personal access token to use as your password
; https://docs.microsoft.com/en-us/azure/devops/organizations/accounts/use-personal-access-tokens-to-authenticate?view=azure-devops
[connection]
address=https://dev.azure.com/organization
project=<your-project>
user=testrail
password=secret

;Title, Issue Type, and State will always be included
[hover.fields]
item_type=on
reason=off
status=on
assignee=on
priority=on
severity=off
description=on
repro_steps=on
system_info=on
'];

    /**
     * Get Meta
     *
     * Expected to return meta data for this plugin such as Author,
     * Version, Description and supported plugin capabilities.
     *
     * @return array
     */
    public function get_meta()
    {
        return $this->get_type() === GI_INTEGRATION_TYPE_REFERENCES
            ? static::$_meta_references
            : static::$_meta_defects;
    }

    public function __destruct()
    {
        if ($this->_api) {
            $this->_api = null;
        }
    }

    /**
     * Validate Config
     *
     * Validates the plugin configuration that is entered in the site
     * or project settings. Expected to throw a ValidationException
     * in case the passed configuration does not validate.
     *
     * @param object $config configuration object passed as parameter.
     *
     * @return void
     *
     * @throws ValidationException
     */
    public function validate_config($config)
    {
        $ini = ini::parse($config);
        $iniConnection = $ini['connection'];
        if (!isset($iniConnection)) {
            throw new ValidationException('Missing [connection] group');
        }
        // Check required values for existance
        foreach (['address', 'project', 'user', 'password'] as $key) {
            if (!isset($iniConnection[$key]) || !$iniConnection[$key]) {
                throw new ValidationException(
                    "Missing configuration for '$key' inside [connection] group"
                );
            }
        }
        // Check whether the address is a valid url (syntax only)
        if (!check::url($iniConnection['address'])) {
            throw new ValidationException(
                'Address configured inside [connection] is not a valid url'
            );
        }
        //Check that push.fields exist inside _fieldDefaults
        foreach ($ini['push.types'] ?? [] as $type => $option) {
            if ($this->is_on($option)) {
                $this->_validate_issue_type($ini, $type);
            }
        }
        foreach (['push.fields', 'hover.fields'] as $fieldSection) {
            $fieldList = $ini[$fieldSection] ?? [];
            foreach ($fieldList as $field => $option) {
                if ($option === 'on') {
                    $this->_validate_field($ini, $field, true);
                }
            }
            if ($fieldSection === 'push.fields' && !empty($fieldList)) {
                if (!$this->is_config_field_on($fieldList, 'item_type')) {
                    throw new ValidationException(
                        'In [push.fields], item_type=on is required.'
                    );
                }
            }
        }
    }

    /**
     * Validate Issue Type
     *
     * Validates the configured values for an issue type
     * Each issue type must have a description, system_info, and repro_steps field configured.
     *
     * @param object $ini  configuration object passed as parameter.
     * @param string $type field name defined in configuration block.
     *
     * @return void
     *
     * @throws ValidationException
     */
    private function _validate_issue_type($ini, $type)
    {
        $config_group_name = "type.settings.$type";
        if (!isset($ini[$config_group_name])) {
            throw new ValidationException(
                str::format(
                    'Issue Type "{0}" is enabled but configuration ' .
                    'section [type.settings.{0}] is missing',
                    $type
                )
            );
        } else {
            foreach (['description', 'repro_steps', 'system_info'] as $key) {
                if (!isset($ini[$config_group_name][$key])) {
                    throw new ValidationException(
                        str::format(
                            'In section [type.settings.{0}], ' .
                            '"{1}" is not specified',
                            $type,
                            $key
                        )
                    );
                }
            }
        }
    }

    /**
     * Validate Field
     *
     * Checks a field to ensure it has minimum settings configured
     * Also verifies a field has a supported type.
     *
     * @param object $ini           configuration object passed as parameter.
     * @param string $field         individual field names.
     * @param bool   $validate_push By default its set as false.
     *
     * @return void
     *
     * @throws ValidationException
     */
    private function _validate_field($ini, $field, $validate_push)
    {
        static $valid_field_types = [
            'dropdown' => true,
            'text' => true,
            'string' => true,
            'date' => true,
            'datetime' => true,
            'bool' => true
        ];
        $category = arr::get($ini, "field.settings.$field");
        if (str::starts_with($field, 'customfield_')) {
            if (!$category) {
                throw new ValidationException(
                    str::format(
                        'Field "{0}" is enabled but configuration '
                           . 'section [field.settings.{0}] is missing',
                        $field
                    )
                );
            }
            foreach (['label', 'type', 'api_field'] as $key) {
                if (!isset($category[$key])) {
                    throw new ValidationException(
                        str::format(
                            'Missing configuration for key "{0}" in '
                                . 'section [field.settings.{1}]',
                            $key,
                            $field
                        )
                    );
                }
            }
        }
        $type = arr::get($category, 'type');
        if ($type && !isset($valid_field_types[str::to_lower($type)])) {
            throw new ValidationException(
                str::format(
                    'Invalid field type specified in section '
                        . '[filed.settings.{0}]',
                    $field
                )
            );
        }
        if ($validate_push && isset($ini['push.fields'])
            && !$this->is_config_field_on($ini['push.fields'], 'item_type')) {
            throw new ValidationException(
                'In [push.fields], item_type=on is required.'
            );
        }
        if ($validate_push && isset($category['type']) && $category['type'] === 'dropdown') {
            if (isset($category['api_list_id'])) {
                // Assume the field ID is valid
                return;
            } else {
                if (!arr::get($ini, "dropdown.$field")) {
                    throw new ValidationException(
                        str::format(
                            'Custom dropdown field "{0}" set, '
                                . 'but "api_list_id" not specified',
                            $field
                        )
                    );
                }
            }
        }
    }

    /**
     * Configure
     *
     * Setting up login credentials, project and config details in private variable for easy access.
     *
     * @param object $config configuration object passed as parameter.
     *
     * @return void
     */
    public function configure($config)
    {
        $ini = ini::parse($config);
        $connection = $ini['connection'];
        $this->_address = str::slash($connection['address']);
        $this->_project = $connection['project'];
        $this->_user = $connection['user'];
        $this->_password = $connection['password'];
        $this->_config = $ini;
    }

    /**
     * Get API
     *
     * Validate API Connection with proper credentials.
     *
     * @return object
     */
    private function _get_api()
    {
        return new DevOps_Cloud_api(
            $this->_address,
            $this->_user,
            $this->_password
        );
    }

    /**
     * Prepare Push
     *
     * Creates an array of objects of default fields
     * with default and user defined configuration.
     *
     * @param array|object $context default configuration.
     *
     * @return array
     */
    public function prepare_push($context)
    {
        $fields = [];
        $fieldsConfig = isset($this->_config['push.fields'])
            ? ['title' => 'on'] + $this->_config['push.fields']
            : $this->_pushDefaultFields;
        foreach ($fieldsConfig as $fieldName => $option) {
            if ($option !== 'on') {
                continue;
            }
            $field = $this->_fieldDefaults[$fieldName] ?? [];
            $configGroup = arr::get($this->_config, "field.settings.$fieldName");
            if ($configGroup) {
                foreach ($configGroup as $property => $value) {
                    $property = str::to_lower($property);
                    $val = str::to_lower($value);
                    if ($property === 'label') {
                        $field[$property] = $value;
                        continue;
                    }

                    if (in_array($property, ['required', 'remember', 'cascading'])) {
                        $value = $val === 'true';
                    } else if ($property === 'rows') {
                        $value = (int) $val;
                    } else if (in_array($val, ['date', 'datetime'])) {
                        // Override the type to String so dialog can process
                        $value = 'string';
                        // Add notice to label
                        $field['label'] = $field['label'];
                        $field['description'] = 'Example: 2020-01-30 12:00 All dates and times are UTC.';
                    } else if ($val === 'bool') {
                        $value = 'dropdown';
                    } else {
                        $value = $val;
                    }
                    // This may override the default value from above.
                    $field[$property] = $value;
                }
            }
            $fields[$fieldName] = $field;
        }
        $result = ['fields' => $fields];
        // Save the form for later use in prepare_field().
        $this->_form = $result;

        return $result;
    }

    /**
     * Get Title Default
     *
     * Fetch only title from an issue details.
     *
     * @param array|object $context default configuration.
     *
     * @return string
     */
    private function _get_title_default($context)
    {
        return 'Failed test: ' . current($context['tests'])->case->title . ($context['test_count'] > 1 ? ' (+others)' : '');
    }

    /**
     * Get Description Default
     *
     * Fetch only description from an issue details.
     *
     * @param array|object $context default configuration.
     *
     * @return string
     */
    private function _get_description_default($context)
    {
        return $context['test_change']->description;
    }

    /**
     * Build Assignee List
     *
     * Fetch all assignee list from an issue details.
     *
     * @param array $items default fields added in config block.
     *
     * @return array
     */
    private function _build_assignee_list(array $items): array
    {
        $result = [];
        foreach ($items as $item) {
            $result[
                $this->is_enabled($item)
                    ? substr(strrchr($item->referenceName, '.'), 1)
                    : $item->id
            ] = $item->name;
        }

        return $result;
    }

    /**
     * Build Type Menu
     *
     * Populate item types based on [push.types] settings and project settings provided by API
     *
     * @param array $api_types various types of work items like issue or task etc.
     *
     * @return array
     */
    private function _build_type_menu(array $api_types): array
    {
        $result = [];
        $fieldsConfig = $this->_config['push.types'] ?? $this->_pushDefaultTypes;
        foreach ($api_types as $type) {
            // Enabled in DevOps project and enabled in [push.types]
            if ($this->is_enabled($type) && $this->is_config_field_on($fieldsConfig, $type->name)) {
                $result[$type->name] = $type->name;
            }
        }

        return $result;
    }

    /**
     * Build Status Menu
     *
     * Populate status based on project and issue type settings by API
     *
     * @param array $api_states various types of states like New, To Do etc.
     *
     * @return array
     */
    private function _build_status(array $api_states = []): array
    {
        $result = [];
        foreach ($api_states as $state) {
            $result[$state->name] = $state->name;
        }

        return $result;
    }

    /**
     * Is Remembered
     *
     * Determine if a field is configured with remember=true
     *
     * @param string $field_name passing field names defined in configuration.
     *
     * @return bool
     */
    private function _is_remembered(string $field_name): bool
    {
        $returnedValue = false;
        $rememberFieldName = 'remember';
        $isFieldExists = !empty($this->_config["field.settings.$field_name"]) ?? [];
        $isFieldExistsDefault = !empty($this->_fieldDefaults[$field_name][$rememberFieldName]);
        if ($isFieldExists) {
            $returnedValue = $isFieldExists;
        } elseif ($isFieldExistsDefault) {
            $returnedValue = $isFieldExistsDefault;
        } else {
            // NOP
        }

        return $returnedValue;
    }

    /**
     * Prepare Field
     *
     * Fetech possible values for default and custom fields.
     *
     * @param array|object $context default configuration.
     * @param array        $input all field defaults passed as array.
     * @param string       $field all field names default and custom fields.
     *
     * @return array
     */
    public function prepare_field($context, $input, $field)
    {
        $data = [];
        $type = $this->_get_config_value($field, 'type');
        // Take into account the preferences of the user, but only
        // for the initial form rendering (not for dynamic loads).
        $prefs = $context['event'] === 'prepare'
            ? arr::get($context, 'preferences')
            : null;
        if ($this->_is_remembered($field)) {
            $data['default'] = arr::get($prefs, $field);
        }

        // Process those fields that do not need a connection to the DevOps installation.
        if (in_array($field, ['title', 'description', 'priority', 'repro_steps', 'system_info', 'severity', 'reason', 'state', 'status' ])) {
            switch ($field) {
                case 'title':
                    $data['default'] = $this->_get_title_default($context);
                    break;

                case 'description':
                case 'repro_steps':
                case 'system_info':
                    $api = $this->_get_api();
                    $api_types = $api->get_types($this->_project);
                    $fieldsConfig = $this->_config['push.types'] ?? $this->_pushDefaultTypes;
                    foreach ($api_types as $type) {
                        if ($this->is_enabled($type) && $this->is_config_field_on($fieldsConfig, $type->name)) {
                            $result = $type->name;
                            break;
                        }
                    }
                    $issue_type = $input['item_type'] ?? $prefs['item_type'] ?? $result;
                    if (empty($issue_type)) {
                        $data['default'] = 'DISABLED';
                        $data['disabled'] = true;
                    }
                    if (!empty($issue_type)) {
                        $type_settings = arr::get($this->_config, "type.settings.$issue_type");
                        $push_fields = arr:: get($this->_config, "push.fields");
                        $data['default'] = '';
                        if ($type_settings) {
                            $field_setting = str::to_lower(arr::get($type_settings, $field));
                            if (!$field_setting) {
                                $field_setting = arr::get($push_fields, $field);
                            }
                            if (str::to_lower($field_setting) === 'default') {
                                $data['default'] = $this->_get_description_default($context);
                            } else if (!($this->is_on($field_setting))) {
                                $data['default'] = 'DISABLED';
                                $data['disabled'] = true;
                            } else {
                                $data['default'] = '';
                                $data['disabled'] = false;
                                if ($field === 'description') {
                                    $data['default'] = $this->_get_description_default($context);
                                }
                            }
                        } else if ($field === 'description') {
                            $data['default'] = $this->_get_description_default($context);
                        } else {
                           //NOP
                        }
                    }
                    break;
                case 'priority':
                    $data['options'] = $this->_priorityList;
                    break;
                case 'severity':
                    $data['options'] = $this->_severityList;
                    break;
                case 'reason':
                    $data['options'] = $this->_reasonsList;
                    break;
                case 'state':
                case 'status':
                    $data['options'] = $this->_stateList;
                    break;
            }

            return $data;
        }

        if ($type === 'bool') {
            $data['options'] = $this->_boolList;
            return $data;
        }

        // And then try to connect/login (in case we haven't set up a
        // working connection previously in this request) and process the remaining fields.
        $api = $this->_get_api();
        switch ($field) {
            case 'assignee':
                $data['options'] = $this->_build_assignee_list($api->get_assignees());
                return $data;
            case 'item_type':
                $api_response = $api->get_types($this->_project);
                $data['options'] = $this->_build_type_menu($api_response);
                return $data;
            default:
                break;
        }

        // Process Custom dropdown field. Severity, Priority, Assignee, and Issue Type already handled
        if ($type === 'dropdown') {
            $field_settings = arr::get($this->_config, "field.settings.$field");
            if (isset($field_settings['api_list_id'])) {
                $data['options'] = $api->get_list($field_settings['api_list_id']);
            } else {
                // NOP
            }

            return $data;
        }

        // Can still return a remembered value to a string or text field
        return $data;
    }

    /**
     * Push
     *
     * Push defect form fields to defect API to create a new issue/bug/task.
     *
     * @param array|object $context default configuration.
     * @param array        $input all field defaults passed as array.
     *
     * @return object
     */
    public function push($context, $input, array $paths = [])
    {
        return $this->_get_api()->add_issue(
            $input,
            $this->_project,
            $this->_config,
            $this->_fieldDefaults,
            $paths
        );
    }

    /**
     * Get Attribute Value
     *
     * Return field value for all default and custom.
     *
     * @param object $issue        Current issue details.
     * @param string $apiFieldName Configuration field names in the REST API.
     * @param string $apiFieldType Configuration field type in the REST API.
     *
     * @return string
     */
    private function _getAttributeValue(object $issue, string $apiFieldName, string $apiFieldType)
    {
        if (property_exists($issue, $apiFieldName) && $apiFieldName !== 'System.Description') {
            if (!is_object($issue->$apiFieldName)) {
                $apiValue = $issue->$apiFieldName;
            }

            if (is_object($issue->$apiFieldName)) {
                $apiValue = $issue->$apiFieldName->displayName;
            }

            if ($apiFieldType === 'datetime') {
                return date::format_short_datetime(strtotime($apiValue));
            } else if ($apiFieldType === 'date') {
                return date::format_short_date(strtotime($apiValue));
            } else if ($apiFieldType === 'bool') {
                return h($apiValue) ? 'Yes' : static::DASH;
            } else {
                return h($apiValue) ?? static::DASH;
            }
        }
    }

    /**
     * Get Category Configuration
     *
     * Checks if "field.settings" and "push.fields" categories are available.
     * If available it will fetch respective property and values from configuration box.
     *
     * @param string $fieldName field name defined in config.
     * @param array  $config    configuration array
     *
     * @return array|null
     */
    private function _get_category_configuration(string $fieldName, array $config): array
    {
        return arr::get($config, "field.settings.$fieldName")
            ?? arr::get($config, "push.field.$fieldName");
    }

    /**
     * Lookup
     *
     * Creates an array of objects of default and custom field with default and
     * user defined configuration to display on hover popup.
     *
     * @param int $defectId Defect id of an issue.
     *
     * @return array
     *
     * @throws ValidationException
     */
    public function lookup($defectId): array
    {
        $issue = $this->_get_api()->get_issue($defectId, $this->_project);
        $compactAttributes = [];
        $fullAttributes = [];
        $description = null;
        $fieldsConfig = isset($this->_config['hover.fields'])
            ? ['item_type' => 'on', 'status' => 'on'] + $this->_config['hover.fields']
            : $this->_hoverDefaultFields;
        foreach ($fieldsConfig as $fieldName => $option) {
            if ($option !== 'on' || in_array($fieldName, ['title', 'attachments'])) {
                continue;
            }
            if (isset($this->_fieldDefaults[$fieldName])) {
                $field = $this->_fieldDefaults[$fieldName];
            } else {
                $field = str::starts_with($fieldName, 'customfield_')
                    ? $this->_get_category_configuration($fieldName, $this->_config)
                    : [];
            }
            if ($fieldName === 'description' && !empty($issue->{'System.Description'})) {
                $description = str::format(
                    '<div class="monospace">{0}</div>',
                    nl2br(
                        $issue->{'System.Description'}
                    )
                );
            }
            if (in_array($field['type'], ['text', 'string'])
                && (!isset($field['size']) || $field['size'] === 'full')) {
                $multiLineTxt = $this->_getAttributeValue($issue, $field['api_field'], $field['type']);
                if (isset($multiLineTxt)) {
                    $fullAttributes[$field['label']] = str::format(
                        '<div class="monospace">{0}</div>',
                        strip_tags(html_entity_decode($multiLineTxt))
                    );
                }
            } else {
                $compactAttributes[$field['label']] = $this->_getAttributeValue($issue, $field['api_field'], $field['type']);
            }
        }
        $project_link = str::format(
            '<a target="_blank" href="{0}{1}">{1}</a>',
            a($this->_address),
            a($issue->{'System.TeamProject'})
        );
        $compactAttributes['Project'] = $project_link;
        $status = $issue->{'System.State'} ?? '';
        $status_id = empty($issue->{'System.State'})
            ? GI_DEFECTS_STATUS_OPEN
            : GI_DEFECTS_STATUS_RESOLVED;

        return [
            'id' => $defectId,
            'url' => str::format(
                '{0}{1}/_workitems/edit/{2}',
                $this->_address,
                $this->_project,
                $defectId
            ),
            'title' => $issue->{'System.Title'},
            'status_id' => $status_id,
            'status' => $status,
            'description' => $description,
            'attributes' => $compactAttributes,
            'fullAttributes' => $fullAttributes
        ];
    }

    /**
     * Get Config Value
     *
     * Creates an array of objects of default and custom field with default and
     * user defined configuration to display on hover popup.
     *
     * @param string $field_name   field name defined in configuration block.
     * @param string $target_field field type defined in configuration block.
     *
     * @return string
     *
     * @throws ValidationException
     */
    private function _get_config_value($field_name, $target_field)
    {
        $config_group = "field.settings.$field_name";
        $value = null;
        if (isset($this->_config[$config_group])) {
            if (isset($this->_config[$config_group][$target_field])) {
                $value = $this->_config[$config_group][$target_field];
            } else if (isset($this->_fieldDefaults[$field_name][$target_field])) {
                $value = $this->_fieldDefaults[$field_name][$target_field];
            } else {
                //NOP
            }
        } else if (isset($this->_fieldDefaults[$field_name][$target_field])) {
            $value = $this->_fieldDefaults[$field_name][$target_field];
        } else {
            //NOP
        }

        return $value;
    }

    /**
     * Is On
     *
     * Check if the defined fieldname in configuration block is on or off.
     *
     * @param string $value field name defined in configuration block.
     *
     * @return bool
     */
    private function is_on(string $value): bool
    {
        return (str::to_lower($value) === 'on') || (str::to_lower($value) === 'default');
    }

    /**
     * Get Config Value
     *
     * Checks if the JSON field 'isDisabled' exists, and if so, is it set to false
     * This helps process the data received from the DevOps API.
     *
     * @param string|object $value fieldname defined in configuration block.
     *
     * @return bool
     */
    private function is_enabled($value): bool
    {
        return (isset($value->isDisabled) && $value->isDisabled == false);
    }

    /**
     * Get Config Value
     *
     * Checks if $field[$target] exists, and if it exists, if it is set '=on'
     *
     * @param array  $field  Default fields list.
     * @param string $target Item type defined in configuration block.
     *
     * @return bool
     */
    private function is_config_field_on(array $field, string $target): bool
    {
        return isset($field[$target]) && $this->is_on($field[$target]);
    }
}
