<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
require_once APPPATH . 'plugins/defects/api/VersionOneApi.php';

/**
 * VersionOne Defect Plugin for TestRail
 *
 * Copyright Gurock Software GmbH. All rights reserved.
 *
 * This is the TestRail defect plugin for VersionOne. Please see
 * http://docs.gurock.com/testrail-integration/defects-plugins for
 * more information about TestRail's defect plugins.
 *
 * http://www.gurock.com/testrail/
 */
class VersionOne_Defect_Plugin extends Defect_plugin
{
    private $_api;
    private $_address;
    private $_user;
    private $_password;
    private $_token;
    private $_config;
    private $_customFields = [];
    private $_defaultPushFields = [
        'asset' => 'on',
        'title' => 'on',
        'project' => 'on',
        'type' => 'off',
        'status' => 'off',
        'priority' => 'off',
        'sprint' => 'off',
        'team' => 'off',
        'tags' => 'off',
        'owner' => 'off',
        'source' => 'off',
        'reference' => 'off',
        'description' => 'on',
        'attachments' => 'on'
    ];
    private $_defaultHoverFields = [
        'project' => 'on',
        'type' => 'on',
        'status' => 'off',
        'priority' => 'off',
        'sprint' => 'off',
        'team' => 'off',
        'tags' => 'off',
        'owner' => 'off',
        'source' => 'off',
        'reference' => 'off',
        'description' => 'on',
        'resolution' => 'off',
        'resolution_details' => 'off'
    ];
    private $_fieldDefaults = [
        'asset' => [
            'type' => 'dropdown',
            'label' => 'Asset',
            'required' => true,
            'remember' => true,
            'cascading' => true,
            'size' => 'compact'
        ],
        'title' => [
            'type' => 'string',
            'label' => 'Title',
            'size' => 'full',
            'required' => true
        ],
        'project' => [
            'type' => 'dropdown',
            'label' => 'Project',
            'required' => true,
            'remember' => true,
            'cascading' => true,
            'size' => 'compact'
        ],
        'type' => [
            'type' => 'dropdown',
            'label' => 'Type',
            'required' => false,
            'remember' => true,
            'depends_on' => 'asset',
            'size' => 'compact'
        ],
        'status' => [
            'type' => 'dropdown',
            'label' => 'Status',
            'required' => false,
            'remember' => true,
            'depends_on' => 'asset',
            'size' => 'compact'
        ],
        'priority' => [
            'type' => 'dropdown',
            'label' => 'Priority',
            'required' => false,
            'remember' => true,
            'depends_on' => 'asset',
            'size' => 'compact'
        ],
        'sprint' => [
            'type' => 'dropdown',
            'label' => 'Sprint',
            'required' => false,
            'remember' => true,
            'depends_on' => 'asset',
            'size' => 'compact'
        ],
        'team' => [
            'type' => 'dropdown',
            'label' => 'Team',
            'required' => false,
            'remember' => true,
            'depends_on' => 'asset',
            'size' => 'compact'
        ],
        'tags' => [
            'type' => 'multiselect',
            'label' => 'Tags',
            'required' => false,
            'size' => 'full'
        ],
        'owner' => [
            'type' => 'dropdown',
            'label' => 'Owner',
            'required' => false,
            'remember' => true,
            'size' => 'compact'
        ],
        'source' => [
            'type' => 'dropdown',
            'label' => 'Source',
            'required' => false,
            'remember' => true,
            'depends_on' => 'asset',
            'size' => 'compact'
        ],
        'reference' => [
            'type' => 'string',
            'label' => 'Reference',
            'size' => 'full',
            'required' => false
        ],
        'description' => [
            'type' => 'text',
            'label' => 'Description',
            'required' => false,
            'rows' => 10
        ],
        'attachments' => [
            'type' => 'dropbox',
            'label'=>'attachments',
            'required' => false,
            'size' => 'none'
        ],
        'resolution' => [
            'type' => 'dropdown',
            'label' => 'Resolution',
            'size' => 'compact'
        ],
        'resolution_details' => [
            'type' => 'text',
            'label' => 'Resolution Details',
            'required' => false,
            'rows' => 10
        ]
    ];
    private static $_meta_defects = [
        'author' => 'Gurock Software',
        'version' => '1.0',
        'description' => 'VersionOne defect plugin for TestRail',
        'can_push' => true,
        'can_lookup' => true,
        'default_config' => 
            '; Please configure your VersionOne connection below.
[connection]
address=https://<your-server>/<work-space>
user=testrail
password=secret
token=secret

[push.fields]
asset=on
project=on
type=off
status=off
priority=off
sprint=off
team=off
tags=off
owner=off
source=off
reference=off
description=on
attachments=on

[hover.fields]
project=on
type=on
status=off
priority=off
sprint=off
team=off
tags=off
owner=off
source=off
reference=off
description=on
resolution=off
resolution_details=off'
];
    private static $_meta_references = [
        'author' => 'Gurock Software',
        'version' => '1.0',
        'description' => 'VersionOne reference plugin for TestRail',
        'can_push' => false,
        'can_lookup' => true,
        'default_config' => 
            '; Please configure your VersionOne connection below.
[connection]
address=https://<your-server>/
user=testrail
password=secret
token=secret

[push.fields]
asset=on
project=on
type=off
status=off
priority=off
sprint=off
team=off
tags=off
owner=off
source=off
reference=off
description=on

[hover.fields]
project=on
type=on
status=off
priority=off
sprint=off
team=off
tags=off
owner=off
source=off
reference=off
description=on
resolution=off
resolution_details=off'
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
            ? static::$_meta_references
            : static::$_meta_defects;
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
     * or project settings. Expected to throw a ValidationException
     * in case the passed configuration does not validate.
     * 
     * @param string $config Configuration for the plugin as specified in the 
     *                       site/project settings.
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
        foreach (['address', 'user', 'password', 'token'] as $key) {
            if (!isset($connection[$key]) || !$connection[$key]) {
                throw new ValidationException(
                    "Missing configuration for key '$key'"
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
                foreach (['asset', 'project'] as $requiredField) {
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
     * Validate field
     * Validate default fields and if invalid 
     * field found then throws error.
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
        $validTypes = [
            'dropdown' => true,
            'multiselect' => true,
            'text' => true,
            'string' => true,
            'bool' => true,
            'date' => true,
            'datetime' => true
        ];
        $category = arr::get($ini, "field.settings.$field");
        if (str::starts_with($field, 'custom_')) { 
            if (!$category) {
                throw new ValidationException(
                    str::format(
                        'Field "{0}" is enabled but configuration ' .
                        'section [field.settings.{0}] is missing',
                        $field
                    )
                );
            }
            foreach (['label', 'type', 'field_name', 'asset_type'] as $key) {
                if (!isset($category[$key])) {
                    throw new ValidationException(
                        str::format(
                            'Missing configuration for key "{0}" in ' 
                                . 'section [field.settings.{1}]',
                            $key,
                            $field
                        )
                    );
                } elseif (!isset($category['list_type'])
                && isset($category['type'])
                && in_array($category['type'], ['dropdown','multiselect'])
                ) {
                    throw new ValidationException(
                        str::format(
                            'Missing "{0}" key configuration for ' 
                                . 'section [field.settings.{1}]',
                            'list_type',
                            $field
                        )
                    );
                } else {
                    // NOP
                }
            }
        }
        $type = arr::get($category, 'type');        
        if ($type && !isset($validTypes[str::to_lower($type)])) {
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
     * Parse and store configuration in respective fields. 
     *
     * @param string $config configuration for the plugin as specified in the
     *                       site/project settings.
     *
     * @return void
     */
    public function configure($config)
    {
        $this->_config = ini::parse($config);
        $this->_address = str::slash($this->_config['connection']['address']);
        $this->_user = $this->_config['connection']['user'];
        $this->_password = $this->_config['connection']['password'];
        $this->_token = $this->_config['connection']['token'];
    }

    /**
     * Get API
     * Return existing/new VersionOne_Api objects.
     * 
     * @return object
     */
    private function _getApi(): object
    {
        return $this->_api ?? new VersionOne_Api(
            $this->_address,
            $this->_user,
            $this->_password,
            $this->_token,
            $this->_config
        );
    }

    /**
     * Prepare Push
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
        $fieldsConfig = [
            'title' => 'on',
            'asset' => 'on',
            'project' => 'on'
        ] + ($this->_config['push.fields'] ??  $this->_defaultPushFields);
        // based on the configuration of the defect plugin.
        foreach ($fieldsConfig as $fieldName => $option) {
            if ($option !== 'on') {
                continue;
            }
            $field = $this->_fieldDefaults[$fieldName] ?? [];
            $category = arr::get(
                $this->_config,
                "field.settings.$fieldName"
            );
            if (empty($category['size']) && in_array($category['type'], ['string', 'text'])) {
                $category['size'] = 'full';
            }
            if ($category && $fieldName !== 'title') {
                foreach ($category as $prop => $val) {
                    $property = str::to_lower($prop);
                    if ($property === 'label') {
                        $field[$property] = $val;
                        continue;
                    }
                    $property = str::to_lower($prop);
                    $value = str::to_lower($val);
                    if (in_array($property, ['required', 'remember', 'cascading'])) {
                        $value = $value === 'true';
                    } elseif ($property === 'rows') {
                        $value = (int) $value;
                    } else {
                        // NOP
                    }
                    $field[$property] = $value;
                }
            }
            if ($field['type'] === 'date') {
                $field['type'] = 'string';
                $field['description'] = 'Example: 2020-01-30';
            }
            $fields[$fieldName] = $field;
        }
        $result = ['fields' => $fields];
        $this->_form = $result;

        return $result;
    }

    /**
     * Get Title Default
     * Builds and return title using context.
     *
     * @param array $context Context information such as details about the the test
     *                       and so on.
     * 
     * @return string
     */
    private function _getTitleDefault(array $context): string
    {
        return 'Failed test: '
        . current($context['tests'])->case->title
        . (
            $context['test_count'] > 1 ? ' (+others)' : ''
        );
    }

    /**
     * Get Description Default
     * Builds and return description using context.
     *
     * @param array $context Context information such as details about the test case,
     *                       the test and so on.
     * 
     * @return string
     */
    private function _getDescriptionDefault(array $context): string
    {
        return $context['test_change']->description;
    }
    
    /**
     * Get Asset List
     * Builds and returns the assets list.
     *
     * @return array
     */
    private function _getAssets(): array
    {
        return [
            'Story' => 'Backlog Item',
            'Defect' => 'Defect',
            'Issue' => 'Issue',
            'RegressionTest' => 'Regression Test',
            'Request' => 'Request'
        ];
    }

    /**
     * Get Option List
     * Builds and returns the option list for given array of object
     *
     * @param array $items Items array.
     * 
     * @return array
     */
    private function _getOptionList(array $items): array
    {
        $result = [];
        foreach ($items as $item) {
            $result[$item->id] = $item->name;
        }

        return $result;
    }

    /**
     * Prepare Field
     * Called for each field of the push form to gather the field
     * data for the form. The plugin can return default values or
     * available options for the field (in case of a dropdown box,
     * for example), among other values.
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
        switch ($field) {
            case 'asset':
                $data['default'] = arr::get($prefs, 'asset');
                $data['options'] = $this->_getAssets();
                break;
            case 'title':
                $data['default'] = $this->_getTitleDefault($context);
                break;
            case 'description':
                $data['default'] = $this->_getDescriptionDefault($context);
                break;
            case 'project':
                $data['default'] = arr::get($prefs, 'project');
                $data['options'] = $this->_getOptionList(
                    $api->getOptions('Scope')
                );
                break;
            case 'owner':
                $data['options'] = $this->_getOptionList(
                    $api->getOptions('Member')
                );
                break;
            case 'team':
                if (isset($input['asset'])) {
                    $data['options'] = $this->_getOptionList(
                        $api->getTeams($input['asset'])
                    );
                }
                break;
            case 'tags':
                $data['options'] = $this->_getOptionList(
                    $api->getTags()
                );
                break;
            case 'sprint':
                if (isset($input['asset'])) {
                    $data['options'] = $this->_getOptionList(
                        $api->getSprints($input['asset'])
                    );
                }
                break;
            case 'source':
                if (isset($input['asset'])) {
                    $data['options'] = $this->_getOptionList(
                        $api->getSource($input['asset'])
                    );
                }
                break;
            case 'priority':
                if (isset($input['asset'])) {
                    $data['options'] = $this->_getOptionList(
                        $api->getPriority($input['asset'])
                    );
                }
                break;
            case 'type':
                if (isset($input['asset'])) {
                    $data['options'] = $this->_getOptionList(
                        $api->getType($input['asset'])
                    );
                }
                break;
            case 'status':
                if (isset($input['asset'])) {
                    $data['options'] = $this->_getOptionList(
                        $api->getStatus($input['asset'])
                    );
                }
                break;
        }
        if (str::starts_with($field, 'custom_')) {
            $data['default'] = arr::get($prefs, $field);
            $category = arr::get($this->_config, "field.settings.$field");
            if (isset($category['list_type'])
                && in_array($category['type'], ['dropdown','multiselect'])
            ) {
                $data['options'] = $category['list_type'] === 'checkbox'
                ?  ['False', 'True']
                : $this->_getOptionList(
                    $api->getCustomFields($category['list_type'])
                );
            }
        }
        if (arr::get($this->_form, 'fields')[$field]['type'] === 'dropdown'
            && is_array(arr::get($data, 'default'))
        ) {
            $data['default'] = '';
        }

        return $data;
    }

    /**
     * Push
     * Push an array of objects of default field
     * with default and user defined configuration.
     *
     * @param array|object $context Default configuration.
     * @param array|object $input   Default plugin configuration.
     * @param array        $paths   Attachments.
     * 
     * @return string
     */
    public function push($context, $input, array $paths = []): string
    {
        return $this->_getApi()->addIssue($input, $paths);
    }

    /**
     * LOOKUP
     * 
     * Creates an array of objects of default fields with default and 
     * user defined configuration to display on hover popup.
     * 
     * @param string|int $issueId Issue id of an issue.
     * 
     * @return array
     */
    public function lookup($issueId): array
    {
        $attributes = [];
        $fullAttributes = [];
        $description = null;
        $api = $this->_getApi();
        $asset = explode(':', $issueId);
        $issue = $api->getIssue(end($asset), $asset[0]);
        $issueData = $issue->Attributes;
        $fieldsConfig = $this->_config['hover.fields'] ?? $this->_defaultHoverFields;
        foreach ($fieldsConfig as $fieldName => $option) {
            if ($option !== 'on' || in_array($fieldName, ['title', 'attachments'])) {
                continue;
            }
            $field = arr::get($this->_config, "field.settings.$fieldName") 
                ?? $this->_fieldDefaults[$fieldName];
            $assetType = $issueData->AssetType->value;
            if (isset($fieldName)) {
                switch($fieldName) {
                    case 'project' :
                        $value = isset($issueData->{'Scope.Name'}->value)
                            ? $issueData->{'Scope.Name'}->value
                            : '';
                        break;
                    case 'type' : 
                        if ($assetType === 'Defect' && isset($issueData->{'Type.Name'}->value)) {
                            $value = $issueData->{'Type.Name'}->value;
                        } elseif (isset($issueData->{'Category.Name'}->value)) {
                            $value = $issueData->{'Category.Name'}->value;
                        } else {
                            $value = '';
                        }
                        break;
                    case 'status' :
                        $value = isset($issueData->{'Status.Name'}->value)
                            ? $issueData->{'Status.Name'}->value
                            : '';
                        break;
                    case 'priority' :
                        $value = isset($issueData->{'Priority.Name'}->value)
                            ? $issueData->{'Priority.Name'}->value
                            : '';
                        break;
                    case 'sprint' :
                        $value = isset($issueData->{'Timebox.Name'}->value)
                            ? $issueData->{'Timebox.Name'}->value
                            : '';
                        break;
                    case 'team' :
                        $value = isset($issueData->{'Team.Name'}->value)
                            ? $issueData->{'Team.Name'}->value
                            : '';
                        break;
                    case 'tags' :
                        $value = isset($issueData->TaggedWith->value)
                            ? implode(',', $issueData->TaggedWith->value)
                            : '';
                        break;
                    case 'owner' :
                        if (in_array($assetType, ['Story','Defect','RegressionTest'])
                        && isset($issueData->{'Owners.Name'}->value[0])) {
                            $value = $issueData->{'Owners.Name'}->value[0];
                        } elseif (isset($issueData->{'Owner.Name'}->value)) {
                            $value = $issueData->{'Owner.Name'}->value;
                        } else {
                            $value = '';
                        }
                        break;
                    case 'source' :
                        $value = isset($issueData->{'Source.Name'}->value)
                            ? $issueData->{'Source.Name'}->value
                            : '';
                        break;
                    case 'reference' :
                        $value = isset($issueData->Reference->value)
                            ? $issueData->Reference->value
                            : '';
                        break;
                    case 'resolution' :
                        $value = isset($issueData->{'ResolutionReason.Name'}->value)
                            ? $issueData->{'ResolutionReason.Name'}->value
                            : '';
                        break;
                    case 'resolution_details' :
                        $value = isset($issueData->Resolution->value)
                            ? $issueData->Resolution->value
                            : '';
                        break;
                }
            }
            if (str::starts_with($fieldName, 'custom_')) {
                $category = arr::get(
                    $this->_config,
                    "field.settings.$fieldName"
                );
                if ($category['asset_type'] === $asset[0]) {
                    $apiResult = $api->getCustomFieldValue(
                        end($asset),
                        $asset[0],
                        $category['field_name']
                    );
                    $customField = $apiResult->Attributes;
                    $fieldName = $category['field_name'];
                    if (isset($category['list_type'])
                        && in_array($category['type'], ['dropdown', 'multiselect'])
                    ) {
                        if ($category['list_type'] === 'checkbox') {
                            $value = $customField->$fieldName->value
                            ? 'True' : 'False';
                        } else {
                            $value = is_array(
                                $customField->{"$fieldName.Name"}->value
                            )
                            ? implode(',', $customField->{"$fieldName.Name"}->value)
                            : $customField->{"$fieldName.Name"}->value;
                        }
                    } else {
                        $value = $customField->$fieldName->value;
                    }
                    if (isset($category['list_type'])
                        && $category['list_type'] === 'date'
                        && isset($customField->$fieldName->value)
                    ) {
                        $formatedDate = date::format_short_date(
                            strtotime($customField->$fieldName->value)
                        );
                        $value = $formatedDate;
                    }
                }
            }
            if ($fieldName === 'description' && isset($issueData->Description->value)) {
                $description = str::format(
                    '<div class="monospace">{0}</div>',
                    nl2br(
                        html::link_urls(
                            h($issueData->Description->value)
                        )
                    )
                );
            } elseif (in_array($field['type'], ['text', 'string']) 
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
        $status = $issueData->{'Status.Name'}->value ?? ' ';
        $statusId = isset($issueData->{'Status.Name'}->value) 
            ? GI_DEFECTS_STATUS_RESOLVED
            : GI_DEFECTS_STATUS_OPEN;

        return [
            'id' => $issueId,
            'url' => str::format(
                    a(
                        $this->_address
                        . $asset[0]
                        . '.mvc/Summary?oidToken='
                        . $asset[0]
                        . '%3A'
                        . $asset[1]
                    )
                ),
            'title' => $issueData->Name->value,
            'status_id' => $statusId,
            'status' => $status,
            'description' => $description,
            'attributes' => $attributes,
            'fullAttributes' => $fullAttributes
        ];
    }
}
