<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

require_once APPPATH . 'plugins/defects/api/MantisApi.php';

/**
 * Mantis Rest Defect Plugin for TestRail
 *
 * Copyright Gurock Software GmbH. All rights reserved.
 *
 * This is the TestRail defect plugin for Mantis REST. Please see
 * http://docs.gurock.com/testrail-integration/defects-plugins for
 * more information about TestRail's defect plugins.
 *
 * http://www.gurock.com/testrail/
 */

class Mantis_REST_Defect_Plugin extends Defect_plugin
{
    const DASH = '&ndash;';

    private $_api;
    private $_address;
    private $_token;
    private $_config;
    private $_form;

    private $_viewState = [ 
        'public' => 'public',
        'private' => 'private'
    ];

    private $_severities = [
        'feature' => 'feature',
        'trivial' => 'trivial',
        'text' => 'text',
        'tweak' => 'tweak',
        'minor' => 'minor',
        'major' => 'major',
        'crash' => 'crash',
        'block' => 'block'
    ];

    private $_priorities = [
        'none' => 'none',
        'low' => 'low',
        'normal' => 'normal',
        'high' => 'high',
        'urgent' => 'urgent',
        'immediate' => 'immediate'
    ];

    private $_defaultPushFields = [
        'summary' => 'on',
        'project' => 'on',
        'category' => 'on',
        'severity' => 'off',
        'priority' => 'off',
        'view_state' => 'off',
        'description' => 'on',
        'attachments' => 'off'
    ];

    private $_defaultHoverFields = [
        'project' => 'on',
        'category' => 'on',
        'severity' => 'off',
        'priority' => 'off',
        'view_state' => 'off',
        'description' => 'on',
        'tags' => 'off',
        'reporter' => 'off',
        'assigned_to' => 'off',
        'resolution' => 'off',
        'created_at' => 'off',
        'updated_at' => 'off',
    ];

    private $_fieldDefaults = [
        'summary' => [
            'type' => 'string',
            'label' => 'Summary',
            'required' => true,
            'size' => 'full',
            'api_field' => 'summary',
            'api_sub_field' => null
        ],
        'category' => [
            'type' => 'dropdown',
            'label' => 'Category',
            'depends_on' => 'project',
            'required' => true,
            'remember' => true,
            'size' => 'compact',
            'api_field' => 'category',
            'api_sub_field' => 'name'
        ],
        'severity' => [
            'type' => 'dropdown',
            'label' => 'Severity',
            'size' => 'compact',
            'api_field' => 'severity',
            'api_sub_field' => 'name'
        ],
        'priority' => [
            'type' => 'dropdown',
            'label' => 'Priority',
            'size' => 'compact',
            'api_field' => 'priority',
            'api_sub_field' => 'name'
        ],
        'view_state' => [
            'type' => 'dropdown',
            'label' => 'View Status',
            'size' => 'compact',
            'api_field' => 'view_state',
            'api_sub_field' => 'name'
        ],
        'resolution' => [
            'type' => 'dropdown',
            'label' => 'Resolution',
            'size' => 'compact',
            'api_field' => 'resolution',
            'api_sub_field' => 'name'
        ],
        'project' => [
            'type' => 'dropdown',
            'label' => 'Project',
            'size' => 'compact',
            'required' => true,
            'remember' => true,
            'cascading' => true,
            'api_field' => 'project',
            'api_sub_field' => 'name'
        ],
        'reporter' => [
            'type' => 'dropdown',
            'label' => 'Reporter',
            'size' => 'compact',
            'required' => true,
            'cascading' => true,
            'api_field' => 'reporter',
            'api_sub_field' => 'name'
        ],
        'assigned_to' => [
            'type' => 'dropdown',
            'label' => 'Assigned To',
            'size' => 'compact',
            'required' => true,
            'cascading' => true,
            'api_field' => 'handler',
            'api_sub_field' => 'name'
        ],
        'created_at' => [
            'type' => 'datetime',
            'label' => 'Created At',
            'size' => 'compact',
            'api_field' => 'created_at',
            'api_sub_field' => null
        ],
        'updated_at' => [
            'type' => 'datetime',
            'label' => 'Updated At',
            'size' => 'compact',
            'api_field' => 'updated_at',
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
        'description' => 'Mantis REST defect plugin for TestRail',
        'can_push' => true,
        'can_lookup' => true,
        'default_config' => 
            '; Please configure your Mantis connection below.
[connection]
address=http://<your-server>/
token=secret

[push.fields]
project=on
category=on
severity=off
priority=off
view_state=off
description=on
attachments=off

[hover.fields]
project=on
category=on
severity=off
priority=off
view_state=off
description=on
tags=off
reporter=off
assigned_to=off
resolution=off
created_at=off
updated_at=off
'];

    private static $_metaReferences = [
        'author' => 'Gurock Software',
        'version' => '1.0',
        'description' => 'Mantis reference plugin for TestRail',
        'can_lookup' => true,
        'default_config' => 
            '; Please configure your Mantis connection below.
[connection]
address=http://<your-server>/
token=secret

[hover.fields]
project=on
category=on
severity=off
priority=off
view_state=off
description=on
tags=off
reporter=off
assigned_to=off
resolution=off
created_at=off
updated_at=off
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
        foreach (['address', 'token'] as $key) {
            if (!isset($connection[$key]) || !$connection[$key]) {
                throw new ValidationException(
                    'Missing configuration for key ' . $key
                );
            }
        }
        if (!check::url($connection['address'])) {
            throw new ValidationException('Address is not a valid url');
        }
        foreach (['push.fields', 'hover.fields'] as $fieldSection) {
            $fieldList = $ini[$fieldSection] ?? [];
            foreach ($fieldList as $field => $option) {
                if ($option === 'on') { 
                    $this->_validateField($ini, $field);
                }
            }
            if ($fieldSection === 'push.fields' && !empty($fieldList)) {
                foreach (['project', 'category', 'description'] as $requiredField) {
                    if (!$this->_isConfigFieldOn($fieldList, $requiredField)) {
                        throw new ValidationException(
                            'In [push.fields], ' . $requiredField . '=on is required.'
                        );
                    }
                }
            }
        }
    }
        
    /**
     * Is Config Field On
     * 
     * Checks if given field is on. 
     * 
     * @param array  $fieldList Configured field list.
     * @param string $target    Target field to check.
     * 
     * @return bool
     */ 
    private function _isConfigFieldOn(array $fieldList, string $target): bool
    {
        return isset($fieldList[$target]) && $fieldList[$target] === 'on';
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
            'date' => true,
            'datetime' => true
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
        $this->_config = $ini;
    }
    
    /**
     * Get API
     * 
     * Return existing/new Mantis_Api objects.
     * 
     * @return object
     */
    private function _getApi(): object
    {
        if ($this->_api) {
            return $this->_api;
        }
        $this->_api = new Mantis_Api(
            $this->_address,
            $this->_token
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
            ? ['summary' => 'on'] + $this->_config['push.fields']
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
            if ($category && $fieldName !== 'summary') {
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
                if (in_array($category['type'], ['text', 'string']) 
                    && !isset($field['size'])
                ) {
                        $field['size'] = 'full';
                }
            }
            if (in_array($field['type'], ['date', 'datetime'])) {
                $field['type'] = 'string';
                $field['description'] = 'Example: 2020-05-20';
            } elseif (str::starts_with($fieldName, 'customfield_') 
                && in_array($field['type'], ['dropdown', 'multiselect'])) {
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
    private function _getSummaryDefault(array $context): string
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
     * Is Remembered
     * 
     * Determine if a field is configured with remember=true.
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
            $result[$item->name] = $item->name;
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
            case 'summary':
                $data['default'] = $this->_getSummaryDefault($context);
                break;
            case 'description':
                $data['default'] = $this->_getDescriptionDefault($context);
                break;
            case 'view_state':
                $data['options'] = $this->_viewState;
                break;
            case 'priority':
                $data['options'] = $this->_priorities;
                break;
            case 'severity':
                $data['options'] = $this->_severities;
                break;
            case 'project':
                $data['options'] = $api->getProjects();
                break;
            case 'category':
                $data['options'] = $this->_getOptionList(
                    $api->getCategories($input['project'] ?? null)
                );
                break;           
        }
        // Process Custom multiselect/dropdown field.
        $isList = in_array(arr::get($this->_form, 'fields')[$field]['type'], ['dropdown', 'multiselect']);
        if (str::starts_with($field, 'customfield_') && $isList) {
            $data['options'] = $api->getCustomFieldList($field, $input['project'] ?? null);
        }

        return $data;
    }
    
    /**
     * Push
     *
     * Executes the actual push request by adding a new issue to the Mantis.
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
        return $this->_getApi()->addIssue($input, $paths, $this->_config);
    }

    /**
     * Get Custom Attribute Value
     * 
     * Return field value for all custom.
     *
     * @param object $issue     Current issue details.
     * @param string $fieldName Field name.
     * @param array $settings   Field settings.
     *
     * @return string
     */
    private function _getCustomAttributeValue(object $issue, string $fieldName, array $settings): string
    {
        foreach ($issue->custom_fields ?? [] as $customField) {
            if (str::replace($fieldName, 'customfield_', '') === (string) $customField->field->id) {
                $value = empty($customField->value)
                    ? static::DASH
                    : str::replace($customField->value, '|', ',');
                
                return $settings['type'] === 'date' && $value !== static::DASH
                    ? date::format_short_date($value)
                    : $value;
            }
        }

        return static::DASH;
    }

    /**
     * Get System Attribute Value
     * 
     * Returns value for all system fields.
     *
     * @param object $issue     Current issue details.
     * @param string $fieldName Field name.
     *
     * @return string
     */
    private function _getSystemAttributeValue(object $issue, string $fieldName): string
    {
        $fieldSettings = $this->_fieldDefaults[$fieldName];
        $apiField = $fieldSettings['api_field'];
        $apiSubField = $fieldSettings['api_sub_field'];
        switch ($apiField) {
            case 'tags':
                $value = $this->_getValues($issue, $apiField, $apiSubField);
                break;
            case 'created_at':
            case 'updated_at':
                $value = empty($issue->$apiField) 
                    ? static::DASH 
                    : date::format_short_datetime(strtotime($issue->$apiField));
                break;
            default:
                $value = $this->_getValue($issue, $apiField, $apiSubField);
        }
        
        return $value;
    }
    
    /**
     * Get Values
     * 
     * Returns comma separated values for given api field.
     *
     * @param object $issue       Current issue details.
     * @param string $apiField    Name of the api field.
     * @param string $apiSubField Name of the api sub field.
     *
     * @return string
     */
    private function _getValues(object $issue, string $apiField, string $apiSubField): string
    {
        return empty($issue->$apiField) 
            ? static::DASH 
            : implode(', ', array_column($issue->$apiField, $apiSubField));
    }

    /**
     * Get Value By Name
     * 
     * Returns  value for the given name.
     *
     * @param object      $issue       Current issue details.
     * @param string      $apiField    Name of the api field.
     * @param string|null $apiSubField Name of the api sub field.
     *
     * @return string
     */
    private function _getValue(object $issue, string $apiField, $apiSubField): string
    {
        return empty($issue->$apiField->$apiSubField)
            ? static::DASH 
            : h($issue->$apiField->$apiSubField);
    }
    
    /**
     * LOOKUP
     * 
     * Creates an array of objects of default fields with default and 
     * user defined configuration to display on hover popup.
     * 
     * @param int $issueId Id of an issue.
     * 
     * @return array
     */
    public function lookup($issueId)
    {
        $issue = $this->_getApi()->getIssue($issueId)->issues[0];
        $description = null;
        $fieldsConfig = $this->_config['hover.fields'] ?? $this->_defaultHoverFields;
        $attributes = [];
        $fullAttributes = [];
        $status = $issue->status->name;
        $status_id = $status === 'resolved' 
            ? GI_DEFECTS_STATUS_RESOLVED
            : GI_DEFECTS_STATUS_OPEN;
        if (!empty($issue->description)) {
            $description = str::format(
                '<div class="monospace">{0}</div>',
                nl2br(
                    html::link_urls(
                        h($issue->description)
                    )
                )
            );
        }
        foreach ($fieldsConfig as $fieldName => $option) {
            if ($option !== 'on' || in_array($fieldName, ['summary', 'description', 'attachments'])) {
                continue;
            }
            $field = arr::get($this->_config, "field.settings.$fieldName") 
                ?? $this->_fieldDefaults[$fieldName];
            if (str::starts_with($fieldName, 'customfield_')) {
                $value = $this->_getCustomAttributeValue($issue, $fieldName, $field);
            } else {
                $value = $this->_getSystemAttributeValue($issue, $fieldName);
            }
            if (in_array($field['type'], ['text', 'string']) 
                && (!isset($field['size']) || $field['size'] === 'full')
                && isset($value)
            ) {
                $fullAttributes[$field['label']] = str::format(
                    '<div class="monospace">{0}</div>',
                    strip_tags(html_entity_decode($value))
                );
            } else {
                $attributes[$field['label']] = $value;
            }    
        }
        
        return [
            'id' => $issueId,
            'url' => str::format(
                '{0}view.php?id={1}',
                $this->_address,
                $issueId
            ),
            'title' => $issue->summary,
            'status_id' => $status_id,
            'status' => $status,
            'description' => $description,
            'attributes' => $attributes,
            'fullAttributes' => $fullAttributes
        ];
    }
}
