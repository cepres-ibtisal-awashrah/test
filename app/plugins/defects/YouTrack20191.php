<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

require_once APPPATH . 'plugins/defects/api/YouTrack20191Api.php';
require_once APPPATH . 'plugins/defects/exceptions/YouTrackException.php';

/**
 * YouTrack Defect Plugin for TestRail
 *
 * Copyright Gurock Software GmbH. All rights reserved.
 *
 * This is the TestRail defect plugin for JetBrains YouTrack. Please
 * see http://docs.gurock.com/testrail-integration/defects-plugins
 * for more information about TestRail's defect plugins.
 *
 * http://www.gurock.com/testrail/
 */

class YouTrack20191_Defect_Plugin extends Defect_plugin
{
    const DASH = '&nbsp;';

    private $_api;
    private $_address;
    private $_user;
    private $_password;
    private $_login;
    private $_config;
    private $_customFields = [];

    private $_defaultFields = [
        'summary' => 'on',
        'type' => 'on',
        'project' => 'on',
        'subsystem' => 'on',
        'description' => 'on',
        'attachments' => 'on'
    ];
    private $_fieldDefaults = [
        'summary' => [
            'type' => 'string',
            'label' => 'Summary',
            'required' => true,
            'size' => 'full',
            'api_field' => 'summary'
        ],
        'type' => [
            'type' => 'dropdown',
            'label' => 'Type',
            'required' => true,
            'remember' => true,
            'size' => 'compact',
            'api_field' => 'type'
        ],
        'project' => [
            'type' => 'dropdown',
            'label' => 'Project',
            'required' => true,
            'remember' => true,
            'cascading' => true,
            'size' => 'compact',
            'api_field' => 'project'
        ],
        'subsystem' => [
            'type' => 'dropdown',
            'label' => 'Subsystem',
            'required' => false,
            'remember' => true,
            'depends_on' => 'project',
            'size' => 'compact',
            'api_field' => 'subsystem'
        ],
        'description' => [
            'type' => 'text',
            'label' => 'Description',
            'required' => false,
            'rows' => 10,
            'api_field' => 'description',
        ],
        'attachments' => [
            'type' => 'dropbox',
            'label' => 'attachments',
            'required' => false,
            'size' => 'none',
            'api_field' => 'attachments'
        ]
    ];
    private $_hoverDefaultFields = [
        'summary' => 'on',
        'type' => 'on',
        'project' => 'on',
        'subsystem' => 'on',
        'description' => 'on'
    ];

    private static $_metaDefects = [
        'author' => 'Gurock Software',
        'version' => '1.0',
        'description' => 'YouTrack20191 defect plugin for TestRail',
        'can_push' => true,
        'can_lookup' => true,
        'default_config' =>
            '; Please configure your YouTrack connection below
[connection]
address=https://<your-server>/
permanent_token=secret
user=<youtrack-user>
login=<youtrack-login>

[push.fields]
summary=on
type=on
project=on
subsystem=on
description=on
attachments=on

[hover.fields]
summary=on
type=on
project=on
subsystem=on
description=on'
];

private static $_metaReferences = [
    'author' => 'Gurock Software',
    'version' => '1.0',
    'description' => 'YouTrack20191 defect plugin for TestRail',
    'can_lookup' => true,
    'default_config' =>
        '; Please configure your YouTrack connection below
[connection]
address=https://<your-server>/
permanent_token=secret
user=<youtrack-user>
login=<youtrack-login>

[hover.fields]
summary=on
type=on
project=on
subsystem=on
description=on'
];

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
     * Validate Config
     *
     * Validates the plugin configuration that is entered in the site
     * or project settings. Expected to throw a ValidationException
     * in case the passed configuration does not validate.
     *
     * @param object $config Configuration for the plugin as specified
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
        foreach (['address', 'permanent_token', 'login', 'user'] as $key) {
            if (!isset($ini['connection'][$key]) || !$ini['connection'][$key]) {
                throw new ValidationException(
                    "Missing configuration for key '$key'"
                );
            }
        }
        $address = $ini['connection']['address'];
        if (!check::url($address)) {
            throw new ValidationException('Address is not a valid url');
        }
        $this->_ensureValidFields('push.fields', $ini);
        $this->_ensureValidFields('hover.fields', $ini);
    }

    /**
     * Ensure Valid fields.
     *
     * Validate all push and hover fields which are set '=on'
     *
     * @param string $fieldList Field name.
     * @param array  $ini       API configration.
     *
     * @return void
     */
    private function _ensureValidFields(string $fieldList, array $ini)
    {
        if (array_key_exists($fieldList, $ini)) {
            $this->requiredFieldsConfigured($ini[$fieldList]);
        }
        foreach ($ini[$fieldList] ?? [] as $field => $option) {
            if ($fieldList === 'push.fields' && in_array($field, ['type', 'project']) && $option === 'off') {
                throw new ValidationException(
                    'In [push.fields], ' . $field . '=on is required.'
                );
            }
            if ($option === 'on') {
                $this->_validateField($ini, $field);
            }
        }
    }

    /**
     * Required Fields Configured
     *
     * Checks if required fields are configured .
     *
     * @param array $configuredFields API configration.
     *
     * @return void
     *
     * @throws ValidationException
     */
    private function requiredFieldsConfigured(array $configuredFields)
    {
        foreach ($this->_fieldDefaults as $fieldkey => $fieldval) {
            if (!empty($fieldval['required']) && $fieldval['required'] === true
                && empty($configuredFields[$fieldkey])
            ) {
                throw new ValidationException(
                    $fieldval['label'] .
                    ' is missing and it is required.'
                );
            }
        }
    }

    /**
     * Validate field.
     *
     * Validate custom and default fields and if invalid
     * field found then thows error.
     *
     * @param array  $ini   API configration.
     * @param string $field Name of field defined in configuration.
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
            'integer' => true,
            'float' => true,
            'date' => true,
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
            foreach (['label', 'type', 'api_type'] as $key) {
                if (isset($category['type']) && in_array($category['type'], ['dropdown', 'multiselect'])) {
                    if ($key !== 'api_type') {
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
                } elseif (!isset($category[$key])) {
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
                        . '[filed.settings.{0}]',
                    $field
                )
            );
        }
    }

    /**
     * Configure
     *
     * Setting up login credentials, project and config details in
     * private variable for easy access.
     *
     * @param object $config Configuration object passed as parameter.
     *
     * @return void
     */
    public function configure($config)
    {
        $ini = ini::parse($config);
        $connection = $ini['connection'];
        $this->_address = str::slash($connection['address']);
        $this->_user = $connection['user'];
        $this->_password = $connection['permanent_token'];
        $this->_login = $connection['login'];
        $this->_config = $ini;
    }

    /**
     * Get API
     *
     * Validate API Connection with proper credentials.
     *
     * @return object
     */
    private function _getApi(): object
    {
        if ($this->_api) {
            return $this->_api;
        }
        $this->_api = new YouTrack20191_Api(
            $this->_address,
            $this->_password,
            $this->_user,
            $this->_login
        );

        return $this->_api;
    }

    /**
     * Prepare Push
     *
     * Creates an array of objects of default fields
     * with default and user defined configuration.
     *
     * @param array|object $context Default configuration.
     *
     * @return array
     */
    public function prepare_push($context): array
    {
        $fields = [];
        $fieldsConfig = isset($this->_config['push.fields'])
            ? ['summary' => 'on', 'project' => 'on', 'type' => 'on'] + $this->_config['push.fields']
            : $this->_defaultFields;
        foreach ($fieldsConfig as $fieldName => $option) {
            if ($option !== 'on') {
                continue;
            }
            $field = $this->_fieldDefaults[$fieldName] ?? [];
            $category = [];
            if ($fieldName !== 'summary') {
                $category = arr::get(
                    $this->_config,
                    "field.settings.$fieldName"
                );
            }
            if ($category) {
                foreach ($category as $prop => $val) {
                    $property = str::to_lower($prop);
                    $value = str::to_lower($val);
                    if ($property === 'label') {
                        $field[$property] = $val;
                        continue;
                    }
                    if ((!isset($category['size']) || $category['size'] === 'full'
                    && in_array($category['type'], ['text', 'string']))
                    ) {
                        $field['size'] = 'full';
                    }
                    if (in_array($property, ['required', 'remember', 'cascading'])) {
                        $final_value = $value === 'true';
                    } elseif ($property === 'rows') {
                        $final_value = (int) $value;
                    } else {
                        $final_value = $value;
                    }
                    $field[$property] = $final_value;
                }
                $field['depends_on'] = 'project';
            }

            if (in_array($field['type'], ['date', 'datetime', 'integer'])) {
                $field['type'] = 'string';
            } elseif ($field['type'] === 'bool') {
                $field['type'] = 'dropdown';
            } else {
                // NOP
            }
            $fields[$fieldName] = $field;
        }

        return ['fields' => $fields];
    }

    /**
     * Get Summary Default
     *
     * Fetch only title from an card details.
     *
     * @param array|object $context Default configuration.
     *
     * @return string
     */
    private function _getSummaryDefault($context): string
    {
        return 'Failed test: '
            . current($context['tests'])->case->title
            . ($context['test_count'] > 1 ? ' (+others)' : '');
    }

    /**
     * Get Description Default
     *
     * Fetch only description from an card details.
     *
     * @param array|object $context Default configuration.
     *
     * @return string
     */
    private function _getDescriptionDefault($context): string
    {
        return $context['test_change']->description;
    }

    /**
     * To Id Name Lookup
     *
     * Builds and returns the option list for given array of object.
     *
     * @param array $items API's response array passed as items.
     *
     * @return array
     */
    private function _toIdNameLookup(array $items): array
    {
        $result = [];
        foreach ($items ?? [] as $item) {
            $result[$item->id] = $item->name;
        }

        return $result;
    }

    /**
     * Get Default Customfield Values.
     *
     * Get all default possible values of custom fields.
     *
     * @param object $api       Youtrac API object.
     * @param string $fieldName Defect field name.
     * @param string $projectId Id of selected project.
     *
     * @return array|string
     */
    private function _getDefaultCustomfieldValues(object $api, string $fieldName, string $projectId)
    {
        $customField = $this->_getCustomfieldValues(
            $api,
            str::replace(
                $fieldName,
                'customfield_',
                ''
            ),
            $projectId
        );
        $returnedValue = [];
        if (isset($customField)) {
            if (in_array($customField->type, ['StateProjectCustomField', 'EnumProjectCustomField', 'OwnedProjectCustomField'])) {
                $returnedValue = $api->getCustomFieldValues($projectId, $customField->id);
                $returnedValue = obj::get_lookup_scalar(
                    $returnedValue,
                    'name',
                    'name'
                );
            }
        }

        return $returnedValue;
    }

    /**
     * Get customfield values.
     *
     * Find custom field details using ID.
     *
     * @param object $api       Youtrac API response.
     * @param string $id        Custom field id.
     * @param string $projectId Selected project Id.
     *
     * @return object|null.
     */
    private function _getCustomfieldValues(object $api, string $id, string $projectId)
    {
        $customField = $this->_findCustomFieldById($id, $this->_customFields);
        if (!isset($customField)) {
            $this->_customFields = $api->get_customfields($projectId);
            $customField = $this->_findCustomFieldById($id, $this->_customFields);
        }

        return $customField;
    }

    /**
     * Find Custom Field by Id
     *
     * Find custom field object in array of objects using ID.
     *
     * @param string $id           Custom field ID
     * @param array  $customFields Array of custom fields
     *
     * @return object|null
     */
    private function _findCustomFieldById(string $id, array $customFields)
    {
        $returnedValue = null;
        foreach ($customFields as $element) {
            if (str::to_lower($id) === str::to_lower(preg_replace('/\s+/', '', $element->name))) {
                $returnedValue = $element;
                break;
            }
        }

        return $returnedValue;
    }

    /**
     * Prepare Field
     *
     * Fetech possible values for default and custom fields.
     *
     * @param array|object $context Default configuration.
     * @param array        $input   Form elements passed as an array.
     * @param string       $field   All field names default and custom fields.
     *
     * @return array
     */
    public function prepare_field($context, $input, $field)
    {
        $data = [];
        switch ($field) {
        case 'summary':
            $data['default'] = $this->_getSummaryDefault($context);
            return $data;
            break;
        case 'description':
            $data['default'] = $this->_getDescriptionDefault($context);
            return $data;
            break;
        }
        $prefs = $context['event'] === 'prepare'
            ? arr::get($context, 'preferences')
            : null;

        $api = $this->_getApi();
        $bundles = $api->getBundles();
        switch ($field) {
        case 'type':
            $types = [];
            foreach ($bundles as $bundle) {
                if ($bundle->name === 'Types') {
                    foreach ($bundle->values as $value) {
                        $typeObj = obj::create();
                        $typeObj->name = (string) $value->name;
                        $typeObj->id = $value->name;
                        $types[] = $typeObj;
                    }
                    continue;
                }
            }
            $data['options'] = $this->_toIdNameLookup($types);
            $default = arr::get($prefs, 'type');
            if ($default) {
                $data['default'] = $default;
            } else {
                if ($data['options']) {
                    $data['default'] = key($data['options']);
                }
            }
            break;
        case 'project':
            $data['default'] = arr::get($prefs, 'project');
            $data['options'] = $this->_toIdNameLookup(
                $api->getProjects()
            );
            break;
        case 'subsystem':
        case 'customfield_subsystem':
            if (isset($input['project'])) {
                $data['default'] = arr::get($prefs, 'subsystem');
                $data['options']  = $this->_getDefaultCustomfieldValues(
                    $api,
                    'customfield_subsystem',
                    $input['project']
                );
            }
            break;
        }
        if (str::starts_with($field, 'customfield_') && isset($input['project'])) {
            $data['default'] = arr::get($prefs, $field);
            if (isset($input['project'])) {
                $data['options'] = $this->_getDefaultCustomfieldValues(
                    $api,
                    $field,
                    $input['project']
                );
            }
        }

        return $data;
    }

    /**
     * Get Custom Attribute Value
     *
     * Return field value for all custom.
     *
     * @param object $task      Current task details.
     * @param array  $fieldName Field name.
     *
     * @return string
     */
    private function _getCustomAttributeValue($task, string $fieldName): string
    {
        foreach ($task->custom_fields ?? [] as $customField) {
            if (str::replace($fieldName, 'customfield_', '') === $customField->id) {
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
     * Prepare Input
     *
     * Formats the contents of $input into structure needed by YouTrack API
     *
     * @param object $input User filled form data.
     *
     * @return object
     */
    private function _prepareInput($input)
    {
        $newInput = obj::create();
        $fieldsType = $this->_getApi()->get_customfields($input['project']);
        foreach ($input as $key => $val) {
            switch ($key) {
            case 'summary':
                $newInput->summary = $val;
                break;
            case 'description':
                $newInput->description = $val;
                break;
            case 'project':
                $proj = obj::create();
                $proj->id = $val;
                $newInput->project = $proj;
                break;
            case 'subsystem':
            case 'customfield_subsystem':
                if (!property_exists($newInput, 'customFields')) {
                    $newInput->customFields = [];
                }
                $cfSubSystemObj = obj::create();
                $cfSubSystemObj->name = 'Subsystem';
                if (is_array($val)) {
                    $cfSubSystemObj->{'$type'} = 'MultiEnumIssueCustomField';
                    $cfSubSystemObj->value = [];
                    foreach ($val ?? [] as $value) {
                        $temp = obj::create();
                        $temp->name =  $value;
                        $cfSubSystemObj->value[] = $temp;
                    }
                } else {
                    $cfSubSystemObj->{'$type'} = 'SingleOwnedIssueCustomField';
                    $cfSubSystemObj->value = obj::create();
                    $cfSubSystemObj->value->name = $val;
                }
                if (isset($val)) {
                    $newInput->customFields[] = $cfSubSystemObj;
                }
                break;
            case 'type':
                if (!property_exists($newInput, 'customFields')) {
                    $newInput->customFields = [];
                }
                $cfTypeObj = obj::create();
                $cfTypeObj->{'$type'} = 'SingleEnumIssueCustomField';
                $cfTypeObj->name = 'Type';
                $cfTypeObj->value = obj::create();
                $cfTypeObj->value->name = $val;
                $newInput->customFields[] = $cfTypeObj;
                break;
            default:
                if (str::starts_with($key, 'customfield_')) {
                    $fieldName = str::replace(
                        $key,
                        'customfield_',
                        ''
                    );
                    if (!empty($val)) {
                        $category = arr::get($this->_config, "field.settings.$key");
                        if (isset($category['api_type'])) {
                            if ($category['api_type'] === 'date') {
                                $val = strtotime($val)*1000;
                            }
                            if (in_array($category['api_type'], ['integer', 'float'])) {
                                if (isset($val) && is_numeric($val)) {
                                    $val = (int) $val;
                                } else {
                                    throw new ValidationException("Please enter valid numeric value for '$key' ");
                                }
                            }
                        }
                        $cfCustomFieldsObj = $this->_formatCustomField($fieldName, $val, $fieldsType);
                        if (isset($cfCustomFieldsObj)) {
                            if (!property_exists($newInput, 'customFields')) {
                                $newInput->customFields = [];
                            }
                            $newInput->customFields[] = $cfCustomFieldsObj;
                        }
                    }
                }
                break;
            }
        }

        return $newInput;
    }

    /**
     * Format custom field as per youtrac API.
     * key is ID of custom field and values is value
     * which user select in push popup.
     *
     * @param string       $fieldName  User defined field name.
     * @param string|array $fieldValue User select value in push popup.
     * @param string       $fieldsType Custom field type of project defined in API.
     *
     * @return array
     */
    private function _formatCustomField(string $fieldName, $fieldValue, $fieldsType)
    {
        if (!empty($fieldValue)) {
            $customField = $this->_findCustomFieldById($fieldName, $fieldsType);
            if (isset($customField->type)) {
                $type = $customField->type;
                switch ($type) {
                case 'StateProjectCustomField':
                case 'EnumProjectCustomField':
                    $cFieldObj = obj::create();
                    $cFieldObj->name = $customField->name;
                    if (is_array($fieldValue)) {
                        $cFieldObj->{'$type'} = 'MultiEnumIssueCustomField';
                        $cFieldObj->value = [];
                        foreach ($fieldValue ?? [] as $value) {
                            $temp = obj::create();
                            $temp->name =  $value;
                            $cFieldObj->value[] = $temp;
                        }
                    } else {
                        $cFieldObj->{'$type'} = 'SingleEnumIssueCustomField';
                        $cFieldObj->value = obj::create();
                        $cFieldObj->value->name = $fieldValue;
                    }
                    return $cFieldObj;
                case 'SimpleProjectCustomField':
                    $cFieldObj = obj::create();
                    $cFieldObj->{'$type'} = 'SimpleIssueCustomField';
                    $cFieldObj->name = $customField->name;
                    $cFieldObj->value= $fieldValue;
                    return $cFieldObj;
                case 'TextProjectCustomField':
                    $cFieldObj = obj::create();
                    $cFieldObj->{'$type'} = 'TextIssueCustomField';
                    $cFieldObj->name = $customField->name;
                    $cFieldObj->value = obj::create();
                    $cFieldObj->value->text = $fieldValue;
                    $cFieldObj->value->{'$type'} = 'TextFieldValue';
                    return $cFieldObj;
                }
            }
        }
    }

    /**
     * Push
     *
     * Push defect form fields to defect API to create a new card/bug/task.
     *
     * @param array|object $context Default configuration.
     * @param array        $input   All field defaults passed as array.
     * @param array        $paths   User uploaded file path.
     *
     * @return object
     */
    public function push($context, $input, array $paths = [])
    {
        $data = $this->_prepareInput($input);
        if (logger::is_on(GI_LOG_LEVEL_DEBUG)) {
            logger::debugr('old_input', $input);
        }
        if (logger::is_on(GI_LOG_LEVEL_DEBUG)) {
            logger::debugr('new_input', $data);
        }

        return $this->_getApi()->add_issue($data, $paths);
    }

    /**
     * Lookup
     *
     * Creates an array of objects of default and custom field with default and
     * user defined configuration to display on hover popup.
     *
     * @param int $defectId Id of a ticket.
     *
     * @return array
     */
    public function lookup($defectId): array
    {
        $issue = $this->_getApi()->getIssueDetails($defectId);
        $attributes = [];
        $fullAttributes = [];
        $description = null;
        $status = 'New';
        $status_id = GI_DEFECTS_STATUS_OPEN;
        if (isset($attributes['State'])) {
            $status = $attributes['State'];
            $status_id =  isset($issue->isResolved)
                ? GI_DEFECTS_STATUS_RESOLVED
                : GI_DEFECTS_STATUS_OPEN;
        }
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
        $fieldsConfig = $this->_config['hover.fields'] ?? $this->_hoverDefaultFields;
        foreach ($fieldsConfig as $fieldName => $option) {
            if ($option !== 'on' || in_array($fieldName, ['summary', 'description', 'attachments'])) {
                if ($fieldName === 'description' && $option !== 'on') {
                    $description = null;
                }
                continue;
            }
            if (isset($this->_fieldDefaults[$fieldName])) {
                $field = $this->_fieldDefaults[$fieldName];
            } else {
                $field = str::starts_with($fieldName, 'customfield_')
                    ? $this->_getCategoryConfiguration($fieldName, $this->_config)
                    : [];
            }
            if ((!isset($field['size']) || $field['size'] === 'full'
                && in_array($field['type'], ['text', 'string']))
            ) {
                $multiLineTxt = $this->_getAttributeValue($issue, $field, $fieldName);
                if (isset($multiLineTxt)) {
                    $fullAttributes[$field['label']] = str::format(
                        '<div class="monospace">{0}</div>',
                        strip_tags(html_entity_decode($multiLineTxt))
                    );
                }
            } else {
                $attributes[$field['label']] = $this->_getAttributeValue($issue, $field, $fieldName);
            }
        }

        return [
            'id' => $defectId,
            'url' => str::format(
                '{0}issue/{1}',
                $this->_address,
                $defectId
            ),
            'title' => $issue->summary,
            'status_id' => $status_id,
            'status' => $status,
            'description' => $description,
            'attributes' => $attributes,
            'fullAttributes' => $fullAttributes
        ];
    }

    /**
     * Get Category Configuration
     *
     * Checks if "field.settings" and "push.fields" categories are available.
     * If available it will fetch respective property and
     * values from configuration box.
     *
     * @param string $fieldName Field name defined in config.
     * @param array  $config    Configuration array
     *
     * @return array|null
     */
    private function _getCategoryConfiguration(string $fieldName, array $config): array
    {
        return arr::get($config, "field.settings.$fieldName")
            ?? arr::get($config, "push.field.$fieldName");
    }

    /**
     * Get Attribute Value
     *
     * Return field value for all default and custom.
     *
     * @param object $issueObj  Current card details.
     * @param array  $field     Array of default field values.
     * @param string $fieldName Field name defined in config block.
     *
     * @return string|null
     */
    private function _getAttributeValue(object $issueObj, array $field, string $fieldName)
    {
        $extractField = '';
        $propField = $field['api_field'] ?? str::to_lower($fieldName);
        if (property_exists($issueObj, $propField)) {
            if (is_string($issueObj->$propField)) {
                return h($issueObj->$propField);
            }
            if (is_object($issueObj->$propField)) {
                return h($issueObj->$propField->name);
            }
        }
        if (is_array($issueObj->customFields)) {
            if (str::starts_with($propField, 'customfield_')) {
                $extractField = str_replace('customfield_', '', $propField);
            }
            foreach ($issueObj->customFields as $cfFields) {
                $cfFields->name = str::to_lower(preg_replace('/\s+/', '',$cfFields->name));
                if ($cfFields->name === $extractField || $cfFields->name === $propField) {
                    if (is_array($cfFields->value)) {
                        return implode(', ', array_column($cfFields->value, 'name'));
                    }
                    if (is_object($cfFields->value)) {
                        if (isset($cfFields->value->name)) {
                            return $cfFields->value->name;
                        } else {
                            return $cfFields->value->text;
                        }
                    }
                    if (is_string($cfFields->value)) {
                        return $cfFields->value;
                    } elseif (is_numeric($cfFields->value)) {
                        if (isset($field['api_type']) && $field['api_type'] === 'date') {
                            $cfFields->value = $cfFields->value/1000;
                            return date::format_short_date($cfFields->value);
                        }
                        return $cfFields->value;
                    }
                }
            }
        }
    }
}
