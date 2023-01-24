<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

require_once APPPATH . 'plugins/defects/api/AsanaApi.php';

/**
 * Asana Defect Plugin for TestRail
 *
 * Copyright Gurock Software GmbH. All rights reserved.
 *
 * This is the TestRail defect plugin for Asana. Please see
 * http://docs.gurock.com/testrail-integration/defects-plugins for
 * more information about TestRail's defect plugins.
 *
 * http://www.gurock.com/testrail/
 */

class Asana_Defect_Plugin extends Defect_plugin
{
    const DASH = '&ndash;';

    private $_api;
    private $_address;
    private $_token;
    private $_workspaceId;
    private $_config;
    private $_form;

    private $_boolList = [ 'No', 'Yes'];

    private $_assigneeStatus = [
        'inbox' => 'inbox',
        'today' => 'today',
        'upcoming' => 'upcoming',
        'later' => 'later'
    ];

    private $_defaultPushFields = [
        'name' => 'on',
        'project' => 'on',
        'section' => 'off',
        'assignee' => 'on',
        'assignee_status' => 'off',
        'parent' => 'off',
        'due_on' => 'on',
        'due_at' => 'off',
        'description' => 'on',
        'tags' => 'off',
        'liked' => 'off',
        'attachments' => 'off'
    ];

    private $_defaultHoverFields = [
        'project' => 'on',
        'section' => 'off',
        'assignee' => 'on',
        'assignee_status' => 'off',
        'parent' => 'off',
        'due_on' => 'on',
        'due_at' => 'off',
        'description' => 'on',
        'tags' => 'off',
        'completed_at' => 'off',
        'followers' => 'off',
        'liked' => 'off',
        'workspace' => 'off'
    ];

    private $_fieldDefaults = [
        'name' => [
            'type' => 'string',
            'label' => 'Name',
            'required' => true,
            'size' => 'full',
            'api_field' => 'name',
            'api_sub_field' => null
        ],
        'workspace' => [
            'type' => 'string',
            'label' => 'Workspace',
            'api_field' => 'workspace',
            'api_sub_field' => 'name'
        ],
        'project' => [
            'type' => 'dropdown',
            'label' => 'Project',
            'size' => 'compact',
            'required' => false,
            'cascading' => true,
            'api_field' => 'projects',
            'api_sub_field' => 'name'
        ],
        'section' => [
            'type' => 'dropdown',
            'label' => 'Section',
            'required' => false,
            'remember' => true,
            'depends_on' => 'project',
            'size' => 'compact',
            'api_field' => 'section',
            'api_sub_field' => null
        ],
        'assignee' => [
            'type' => 'dropdown',
            'label' => 'Assignee',
            'required' => false,
            'remember' => true,
            'cascading' => true,
            'size' => 'compact',
            'api_field' => 'assignee',
            'api_sub_field' => 'name',
        ],
        'assignee_status' => [
            'type' => 'dropdown',
            'label' => 'Assignee Status',
            'required' => false,
            'remember' => true,
            'depends_on' => 'assignee',
            'size' => 'compact',
            'api_field' => 'assignee_status',
            'api_sub_field' => null,
        ],
        'parent' => [
            'type' => 'integer',
            'label' => 'Parent',
            'required' => false,
            'size' => 'compact',
            'api_field' => 'parent',
            'api_sub_field' => 'gid',
        ],
        'due_on' => [
            'type' => 'date',
            'label' => 'Due On',
            'size' => 'compact',
            'api_field' => 'due_on',
            'api_sub_field' => null
        ],
        'due_at' => [
            'type' => 'datetime',
            'label' => 'Due At',
            'size' => 'compact',
            'api_field' => 'due_at',
            'api_sub_field' => null
        ],
        'completed_at' => [
            'type' => 'datetime',
            'label' => 'Completed At',
            'size' => 'compact',
            'api_field' => 'completed_at',
            'api_sub_field' => null
        ],
        'description' => [
            'type' => 'text',
            'label' => 'Description',
            'required' => false,
            'rows' => 10,
            'api_field' => 'notes',
            'api_sub_field' => null
        ],
        'tags' => [
            'type' => 'multiselect',
            'label' => 'Tags',
            'size' => 'full',
            'required' => false,
            'api_field' => 'tags',
            'api_sub_field' => 'name'
        ],
        'followers' => [
            'type' => 'multiselect',
            'label' => 'Followers',
            'size' => 'full',
            'api_field' => 'followers',
            'api_sub_field' => 'name'
        ],        
        'liked' => [
            'type' => 'bool',
            'label' => 'Liked',
            'required' => false,
            'remember' => true,
            'size' => 'compact',
            'api_field' => 'liked',
            'api_sub_field' => null
        ],
        'attachments' => [
            'type' => 'dropbox',
            'label'=>'attachments',
            'required' => false,
            'size' => 'none'
        ],
    ];

    private static $_metaDefects = [
        'author' => 'Gurock Software',
        'version' => '1.0',
        'description' => 'Asana defect plugin for TestRail',
        'can_push' => true,
        'can_lookup' => true,
        'default_config' => 
            '; Please configure your Asana connection below.
; Note: requires Asana API version 1.0 or later.
[connection]
address=https://app.asana.com/
token=secret
workspace_id=<Asana-workspace-gid>

[push.fields]
project=on
section=off
assignee=on
assignee_status=off
parent=off
due_on=on
due_at=off
description=on
tags=off
liked=off
attachments=off

[hover.fields]
project=on
section=off
assignee=on
assignee_status=off
parent=off
due_on=on
due_at=off
description=on
tags=off
completed_at=off
followers=off
liked=off
workspace=off
'];

    private static $_metaReferences = [
        'author' => 'Gurock Software',
        'version' => '1.0',
        'description' => 'Asana reference plugin for TestRail',
        'can_lookup' => true,
        'default_config' => 
            '; Please configure your Asana connection below.
; Note: requires Asana API version 1.0 or later.
[connection]
address=https://app.asana.com/
token=secret
workspace_id=<Asana-workspace-gid>

[hover.fields]
project=on
section=off
assignee=on
assignee_status=off
parent=off
due_on=on
due_at=off
description=on
tags=off
completed_at=off
followers=off
liked=off
workspace=off
'];

    /**
     * Get Meta
     *
     * Expected to return meta data for this plugin such as Author,
     * Version, Description and supported plugin capabilities.
     * 
     * @return array
     */
    public function get_meta(): array
    {
        return $this->get_type() === GI_INTEGRATION_TYPE_REFERENCES
            ? static::$_metaReferences
            : static::$_metaDefects;
    }

    /**
     * Clears out the values when object destroys.
     */
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
     * or project settings.
     * 
     * @param string $config Configuration for the plugin as specified 
     *                       in the site/project settings.
     * 
     * @return void
     *
     * @throws ValidationException
     */
    public function validate_config($config)
    {
        $ini = ini::parse($config);
        if (!isset($ini['connection'])) {
            throw new ValidationException('Missing [connection] group');
        }
        $connection = $ini['connection'];
        foreach (['address', 'token', 'workspace_id'] as $key) {
            if (!isset($connection[$key]) || !$connection[$key]) {
                throw new ValidationException(
                    'Missing configuration for key ' . $key
                );
            }
        }
        if (!check::url($connection['address'])) {
            throw new ValidationException('Address is not a valid url');
        }
        foreach (['push.fields', 'hover.fields'] as $field) {
            foreach ($ini[$field] ?? [] as $field => $option) {
                if ($option === 'on') { 
                    $this->_validateField($ini, $field);
                }
            }
        }
    }

    /**
     * Validate Field
     * 
     * Validate default fields and if invalid 
     * field found then throw error.
     *
     * @param array  $ini   API configuration.
     * @param string $field Field name.
     *
     * @return void
     *
     * @throws ValidationException
     */
    private function _validateField(array $ini, string $field)
    {
        $valid_types = [
            'dropdown' => true,
            'multiselect' => true,
            'text' => true,
            'string' => true,
            'bool' => true,
            'date' => true,
            'datetime' => true,
            'integer' => true
        ];
        $category = arr::get($ini, "field.settings.$field");
        if (str::starts_with($field, 'customfield_')) { 
            if (!$category) {
                throw new ValidationException(
                    str::format(
                        'Field "{0}" is enabled but configuration ' .
                        'section [field.settings.{0}] is missing',
                        $field
                    )
                );
            }            
            foreach (['label', 'type'] as $key) {
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
        if ($type && !isset($valid_types[str::to_lower($type)])) {
            throw new ValidationException(
                str::format(
                    'Invalid field type specified in section ' 
                        . '[field.settings.{0}]',
                    $field
                )
            );
        }
    }

    /**
     * Configure
     * 
     * Parse and store configuration in respective fields. 
     *
     * @param string $config configuration for the plugin 
     *                       as specified in the site/project settings.
     *
     * @return void
     */
    public function configure($config)
    {
        $ini = ini::parse($config);
        $connection = $ini['connection'];
        $this->_address = str::slash($connection['address']);
        $this->_token = $connection['token'];
        $this->_workspaceId = $connection['workspace_id'];
        $this->_config = $ini;
    }
    
    /**
     * Get API
     * 
     * Return existing/new Asana_Api objects.
     * 
     * @return object
     */
    private function _getApi(): object
    {
        if ($this->_api) {
            return $this->_api;
        }
        $this->_api = new Asana_Api(
            $this->_address,
            $this->_token,
            $this->_workspaceId
        );

        return $this->_api;
    }

    /**
     * Prepare Push
     * 
     * Creates an array of objects of default fields
     * with default and user defined configuration.
     *
     * @param array $context Context information such as details
     *                       about the test case, the test and so on.
     * 
     * @return array
     */
    public function prepare_push($context): array
    {
        $fields = [];
        $fieldsConfig = isset($this->_config['push.fields'])
            ? ['name' => 'on'] + $this->_config['push.fields']
            : $this->_defaultPushFields;
        foreach ($fieldsConfig as $fieldName => $option) {
            if ($option !== 'on') {
                continue;
            }
            $field = $this->_fieldDefaults[$fieldName] ?? [];
            $category = arr::get(
                $this->_config,
                "field.settings.$fieldName"
            );
            if ($category) {
                foreach ($category as $prop => $val) {
                    $property = str::to_lower($prop);
                    if ($property === 'label') {
                        $field[$property] = $val;
                        continue;
                    }
                    $value = str::to_lower($val);
                    if (in_array($property, ['required', 'remember', 'cascading'])) {
                        $final_value = $value === 'true';
                    } elseif ($property === 'rows') {
                        $final_value = (int) $value;
                    } else {
                        $final_value = $value;
                    }
                    $field[$property] = $final_value;
                }
            }
            if (in_array($field['type'], ['date', 'datetime', 'integer'])) {
                $field['type'] = 'string';
            } elseif ($field['type'] === 'bool') {
                $field['type'] = 'dropdown';
            } elseif (str::starts_with($fieldName, 'customfield_') && $field['type'] = 'dropdown') {
                $field['depends_on'] = 'project';   
            } else {
                // NOP
            }
            $fields[$fieldName] = $field;
        }
        $result = ['fields' => $fields];
        $this->_form = $result;

        return $result;
    }

    /**
     * Get Name Default
     * 
     * Builds and return name using context.
     *
     * @param array $context Context information such as test case details.
     * 
     * @return string
     */
    private function _getNameDefault(array $context): string
    {
        return 'Failed test: ' 
            . current($context['tests'])->case->title 
            . ($context['test_count'] > 1 ? ' (+others)' : '');
    }

    /**
     * Get Description Default
     * 
     * Builds and return description using context.
     *
     * @param array $context Context information such as test case details. 
     * 
     * @return string
     */
    private function _getDescriptionDefault(array $context): string
    {
        return $context['test_change']->description;
    }

    /**
     * Get Assignee Status
     * 
     * Builds and returns assignee status list.
     *
     * @param string $assigneeId Id of the assignee.
     * 
     * @return array
     */
    private function _getAssigneeStatus(string $assigneeId): array
    {
        return empty($assigneeId) ? [] : $this->_assigneeStatus;
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
    private function _isRemembered(string $field_name): bool
    {
        $returnedValue = false;
        $rememberFieldName = 'remember';
        $isFieldExists = !empty($this->_config["field.settings.$field_name"]) ?? [];
        $isFieldExistsDefault = !empty(
            $this->_fieldDefaults[$field_name][$rememberFieldName]
        );
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
     * Get Option List
     * 
     * Builds and returns the option list for given array of object
     *
     * @param array $items Items' array.
     * 
     * @return array
     */
    private function _getOptionList(array $items): array
    {
        $result = [];
        foreach ($items ?? [] as $item) {
            $result[$item->gid] = $item->name;
        }

        return $result;
    }

    /**
     * Prepare Field
     * 
     * Call for each field of the push form to gather the field
     * data for the form.
     *
     * @param array  $context Context information such as details 
     *                        about the test case, the test and so on.
     * @param array  $input   Input data the user has entered in the
     *                        push dialog.
     * @param string $field   Field name 
     * 
     * @return array
     */
    public function prepare_field($context, $input, $field): array
    {
        $data = [];
        $api = $this->_getApi();
        $prefs = $context['event'] === 'prepare' 
            ? arr::get($context, 'preferences') 
            : null;
        if ($this->_isRemembered($field)) {
            $data['default'] = arr::get($prefs, $field);
        }
        switch ($field) {
            case 'name':
                $data['default'] = $this->_getNameDefault($context);
                break;
            case 'description':
                $data['default'] = $this->_getDescriptionDefault($context);
                break;
            case 'assignee_status':
                $data['options'] = $this->_getAssigneeStatus($input['assignee']);
                break;
            case 'liked':
                $data['options'] = $this->_boolList;
                break;
            case 'project':
                $data['options'] = $this->_getOptionList(
                    $api->getListFromWorkspace('projects')
                );
                break;
            case 'tags':
                $data['options'] = $this->_getOptionList(
                    $api->getListFromWorkspace($field)
                );
                break;
            case 'section':
                $data['options'] = $this->_getOptionList(
                    $api->getSections($input['project'])
                );
                break;
            case 'assignee':
                $data['options'] = $this->_getOptionList(
                    $api->getListFromWorkspace('users')
                );
                break;            
        }
        // Process Custom dropdown field.
        $dropdown = arr::get($this->_form, 'fields')[$field]['type'] === 'dropdown';
        if (str::starts_with($field, 'customfield_') && $dropdown) {
            $data['options'] = $this->_getOptionList(
                $api->getCustomFieldList($field, $input['project'])
            );
        }
        // Prevent an error message in case the field was a multi-
        // select and was changed back to dropdown.
        if ($dropdown && is_array(arr::get($data, 'default'))) {
            $data['default'] = '';
        }
        
        return $data;
    }
    
    /**
     * Push
     *
     * Executes the actual push request by adding a new task to the Asana.
     *
     * @param array $context Context information such as details 
     *                       about the test case, the test and so on.
     * @param array $input   Input data the user has entered in the push dialog.
     * @param array $paths   Attachments list.
     * 
     * @return string 
     */    
    public function push($context, $input, array $paths = []): string
    {
        return $this->_getApi()->addTask($input, $paths);
    }

    /**
     * Get Custom Attribute Value
     * 
     * Return field value for all custom.
     *
     * @param object $task      Current task details.
     * @param string $fieldName Field name.
     *
     * @return string
     */
    private function _getCustomAttributeValue(object $task, string $fieldName): string
    {
        foreach ($task->custom_fields ?? [] as $customField) {
            if (str::replace($fieldName, 'customfield_', '') === $customField->gid) {
                $attributeValue = $customField->{
                    $customField->resource_subtype 
                    . '_value'
                };

                return is_object($attributeValue)
                    ? $attributeValue->name
                    : $attributeValue ?? static::DASH;
            }
        }

        return static::DASH;
    }

    /**
     * Get System Attribute Value
     * 
     * Returns value for all system fields.
     *
     * @param object $task          Current task details.
     * @param array  $fieldSettings Field settings.
     *
     * @return string
     */
    private function _getSystemAttributeValue(object $task, array $fieldSettings): string
    {
        $apiField = $fieldSettings['api_field'];
        $apiSubField = $fieldSettings['api_sub_field'];
        switch ($apiField) {
            case 'projects':
            case 'followers':
            case 'tags':
                $value = $this->_getValues($task, $apiField, $apiSubField);
                break;
            case 'section':
                $value = $this->_getSections($task);
                break;
            case 'assignee':
            case 'workspace':
            case 'parent':
                $value = $this->_getValue($task, $apiField, $apiSubField);
                break;
            case 'liked':
                $value = $task->$apiField ? 'Yes' : 'No';
                break;
            case 'due_on':
                $value = empty($task->$apiField) 
                    ? static::DASH 
                    : date::format_short_date(strtotime($task->$apiField));
                break;
            case 'due_at':
            case 'completed_at':
                $value = empty($task->$apiField) 
                    ? static::DASH 
                    : date::format_short_datetime(strtotime($task->$apiField));
                break;
            default:
                $value = empty($task->$apiField) 
                    ? static::DASH 
                    : h($task->$apiField);
        }
        
        return $value;
    }
    
    /**
     * Get Values
     * 
     * Returns comma separated values for given api field.
     *
     * @param object $task        Current task details.
     * @param string $apiField    Name of the api field.
     * @param string $apiSubField Name of the api sub field.
     *
     * @return string
     */
    private function _getValues(object $task, string $apiField, string $apiSubField): string
    {
        return empty($task->$apiField) 
            ? static::DASH 
            : implode(', ', array_column($task->$apiField, $apiSubField));
    }

    /**
     * Get Value By Name
     * 
     * Returns  value for the given name.
     *
     * @param object      $task        Current task details.
     * @param string      $apiField    Name of the api field.
     * @param string|null $apiSubField Name of the api sub field.
     *
     * @return string
     */
    private function _getValue(object $task, string $apiField, $apiSubField): string
    {
        return empty($task->$apiField->$apiSubField)
            ? static::DASH 
            : h($task->$apiField->$apiSubField);
    }
    
    /**
     * Get Sections
     * 
     * Returns formatted value for projects and sections.
     *
     * @param object $task Current task details.
     *
     * @return string
     */
    private function _getSections(object $task): string
    {
        $sections = [];
        foreach ($task->memberships ?? [] as $member) { 
            $sections[] = $member->project->name
                . ':'
                . $member->section->name;
        }

        return empty($sections) 
            ? static::DASH
            : h(implode(', ', $sections));
    }
    
    /**
     * LOOKUP
     * 
     * Creates an array of objects of default fields with default and 
     * user defined configuration to display on hover popup.
     * 
     * @param int $taskId Task id of an task.
     * 
     * @return array
     */
    public function lookup($taskId)
    {
        $task = $this->_getApi()->getTask($taskId)->data;
        $description = null;
        $fieldsConfig = $this->_config['hover.fields'] ?? $this->_defaultHoverFields;
        $attributes = [];
        $status = $task->completed ? 'completed' : 'pending';
        $status_id = $task->completed 
            ? GI_DEFECTS_STATUS_RESOLVED
            : GI_DEFECTS_STATUS_OPEN;
        if (!empty($task->notes)) {
            $description = str::format(
                '<div class="monospace">{0}</div>',
                nl2br(
                    html::link_urls(
                        h($task->notes)
                    )
                )
            );
        }
        foreach ($fieldsConfig as $fieldName => $option) {
            if ($option !== 'on' || $fieldName === 'description') {
                continue;
            }
            if (isset($this->_fieldDefaults[$fieldName])) {
                $field = $this->_fieldDefaults[$fieldName];
                $value = $this->_getSystemAttributeValue($task, $field);
            } elseif (str::starts_with($fieldName, 'customfield_')) {
                $field =  arr::get($this->_config, "field.settings.$fieldName");
                $value = $this->_getCustomAttributeValue($task, $fieldName);
            }
            $attributes[$field['label']] = $value;
        }
        
        return [
            'id' => $taskId,
            'url' => str::format(
                '{0}0/0/{1}',
                $this->_address,
                $taskId
            ),
            'title' => $task->name,
            'status_id' => $status_id,
            'status' => $status,
            'description' => $description,
            'attributes' => $attributes
        ];
    }
}
