<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

require_once APPPATH . 'plugins/defects/api/TrelloApi.php';

/**
 * Trello Defect Plugin for TestRail
 *
 * Copyright Gurock Software GmbH. All rights reserved.
 *
 * This is the TestRail defect plugin for Trello. Please see
 * http://docs.gurock.com/testrail-integration/defects-plugins for
 * more information about TestRail's defect plugins.
 *
 * http://www.gurock.com/testrail/
 */

class Trello_Defect_Plugin extends Defect_plugin
{
    const DASH = '&ndash;';

    private $_api;
    private $_address;
    private $_key;
    private $_token;
    private $_config;

    private $_pushDefaultFields = [
        'name' => 'on',
        'board' => 'on',
        'list' => 'on',
        'desc' => 'on',
        'checklists' => 'off',
        'pos' => 'off',
        'due' => 'off',
        'assignee' => 'off',
        'labels' => 'off',
        'attachments' => 'off',
    ];
    
    private $_fieldDefaults = [
        'name' => [
            'label' => 'Title',
            'required' => true,
            'type' => 'string',
            'remember' => false,
            'size' => 'full',
            'api_field' => 'name',
            'api_field_display' => 'name',
            'api_subfield_display' => null
        ],
        'board' => [
            'label' => 'Board',
            'required' => true,
            'type' => 'dropdown',
            'remember' => true,
            'size' => 'compact',
            'api_field' => 'idBoard',
            'api_field_display' => 'board',
            'api_subfield_display' => 'name',
            'cascading' => true,
        ],
        'list' => [
            'label' => 'List',
            'required' => true,
            'type' => 'dropdown',
            'remember' => true,
            'size' => 'compact',
            'api_field' => 'idList',
            'api_field_display' => 'list',
            'api_subfield_display' => 'name',
            'depends_on' => 'board',
        ],
        'desc' => [
            'type' => 'text',
            'label' => 'Description',
            'required' => false,
            'rows' => 8,
            'dropzone_enabled' => true,
            'api_field' => 'desc',
            'api_field_display' => 'desc',
            'api_subfield_display' => null,
        ],
        'assignee' => [
            'label' => 'Members',
            'required' => false,
            'type' => 'multiselect',
            'remember' => true,
            'size' => 'full',
            'api_field' => 'idMembers',
            'api_field_display' => 'members',
            'api_subfield_display' => 'fullName',
            'depends_on' => 'board',
        ],
        'members' => [
            'label' => 'Members',
            'required' => false,
            'type' => 'multiselect',
            'remember' => true,
            'size' => 'full',
            'api_field' => 'idMembers',
            'api_field_display' => 'members',
            'api_subfield_display' => 'fullName',
            'depends_on' => 'board',
        ],
        'labels' => [
            'label' => 'Labels',
            'required' => false,
            'type' => 'multiselect',
            'remember' => true,
            'size' => 'compact',
            'api_field' => 'idLabels',
            'api_field_display' => 'labels',
            'api_subfield_display' => 'name',
            'depends_on' => 'board',
        ],
        'attachments' => [
            'type' => 'dropbox',
            'label'=>'attachments',
            'required' => false,
            'size' => 'none',
            'remember' => false,
        ],
        'checklists' => [
            'label' => 'Checklists',
            'required' => false,
            'type' => 'dropdown',
            'remember' => true,
            'size' => 'compact',
            'api_field' => 'idChecklists',
            'api_field_display' => 'checklists',
            'api_subfield_display' => 'name',
            'depends_on' => 'board',
        ],
        'checkItems' => [
            'label' => 'Checkitems',
            'required' => false,
            'type' => 'text',
            'remember' => true,
            'size' => 'full',
            'api_field' => 'checkItems',
            'api_field_display' => 'checkItems',
            'api_subfield_display' => 'name',
        ],
        'pos' => [
            'label' => 'Position',
            'required' => false,
            'type' => 'dropdown',
            'remember' => true,
            'size' => 'compact',
            'api_field' => 'pos',
            'api_field_display' => 'pos',
            'api_subfield_display' => null,
        ],
        'due' => [
            'label' => 'Due Date',
            'required' => false,
            'type' => 'string',
            'remember' => false,
            'size' => 'compact',
            'api_field' => 'due',
            'api_field_display' => 'due',
            'api_subfield_display' => null,
        ],
        'dateLastActivity' => [
            'label' => 'Last Activity Date',
            'required' => false,
            'type' => 'string',
            'remember' => false,
            'size' => 'compact',
            'api_field' => 'dateLastActivity',
            'api_field_display' => 'dateLastActivity',
            'api_subfield_display' => null,
        ],
        'dueComplete' => [
            'label' => 'Due Complete',
            'required' => false,
            'type' => 'string',
            'remember' => false,
            'size' => 'compact',
            'api_field' => 'dueComplete',
            'api_field_display' => 'dueComplete',
            'api_subfield_display' => null,
        ],
        'shortUrl' => [
            'label' => 'Short Url',
            'required' => false,
            'type' => 'string',
            'remember' => false,
            'size' => 'compact',
            'api_field' => 'shortUrl',
            'api_field_display' => 'shortUrl',
            'api_subfield_display' => null,
        ],
        'shortLink' => [
            'label' => 'Short Link',
            'required' => false,
            'type' => 'string',
            'remember' => false,
            'size' => 'compact',
            'api_field' => 'shortLink',
            'api_field_display' => 'shortLink',
            'api_subfield_display' => null,
        ],
        'subscribed' => [
            'label' => 'Subscribed',
            'required' => false,
            'type' => 'string',
            'remember' => false,
            'size' => 'compact',
            'api_field' => 'subscribed',
            'api_field_display' => 'subscribed',
            'api_subfield_display' => null,
        ]
    ];

    private $_cardPositionList = [
        'top' => 'Top',
        'bottom' => 'Bottom'
    ];

    private $_checkboxList = [
        'true' => 'True',
        'false' => 'False',
    ];
    
    private $_hoverDefaultFields = [
        'board' => 'on',
        'list' => 'on',
        'desc' => 'on',
        'checklists' => 'off',
        'dateLastActivity' => 'off',
        'due' => 'off',
        'dueComplete' => 'off',
        'labels' => 'off',
        'members' => 'off',
        'pos' => 'off',
        'shortUrl' => 'off',
        'shortLink' => 'off',
        'subscribed' => 'off',
    ];

    protected static $_metaDefects = [
        'author' => 'Gurock Software',
        'version' => '1.0',
        'description' => 'Trello defect plugin for TestRail',
        'can_push' => true,
        'can_lookup' => true,
        'default_config' => 
            '; Please configure your Trello connection below.
; You may need to create a API access token to use as your key and token
; https://trello.com/app-key
[connection]
address=https://trello.com/
key=<your-key>
token=<your-token>

[push.fields]
labels=off
members=off
due=off
pos=off
desc=on
checklists=off

[hover.fields]
board=on
list=on
desc=on
checkItems=off
dateLastActivity=off
due=off
dueComplete=off
labels=off
members=off
pos=off
shortUrl=off
shortLink=off
subscribed=off
'];
    
    protected static $_metaReferences = [
        'author' => 'Gurock Software',
        'version' => '1.0',
        'description' => 'Trello defect plugin for TestRail',
        'can_lookup' => true,
        'default_config' => 
            '; Please configure your Trello connection below.
; You may need to create a API access token to use as your key and token
; https://trello.com/app-key
[connection]
address=https://trello.com/
key=<your-key>
token=<your-token>

[hover.fields]
board=on
list=on
desc=on
checklists=off
dateLastActivity=off
due=off
dueComplete=off
labels=off
members=off
pos=off
shortUrl=off
shortLink=off
subscribed=off
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
        $iniConnection = $ini['connection'];
        if (!isset($iniConnection)) {
            throw new ValidationException('Missing [connection] group');
        }
        // Check required values for existance
        foreach (['address', 'key', 'token'] as $key) {
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
        // Validate all push and hover fields which are set '=on'
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
     * Checks a field to ensure it has minimum settings configured
     * also verifies a field has a supported type.
     * 
     * @param object $ini   Configuration object passed as parameter.
     * @param string $field Individual field names.
     * 
     * @return void
     * 
     * @throws ValidationException
     */
    private function _validateField($ini, $field)
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
                        'Field "{0}" is enabled but configuration ' 
                           . 'section [field.settings.{0}] is missing ',
                        $field
                    )
                );
            }    
            foreach (['label', 'type', 'idCustomField', 'api_type'] as $key) {
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
        $this->_config = ini::parse($config);
        $this->_address = str::slash($this->_config['connection']['address']);
        $this->_key = $this->_config['connection']['key'];
        $this->_token = $this->_config['connection']['token'];
    }
    
    /**
     * Get API
     * 
     * Validate API Connection with proper credentials.
     * 
     * @return object
     */	
    private function _getApi()
    {
        if ($this->_api) {
            return $this->_api;
        }
        $this->_api = new Trello_API(
            $this->_address,
            $this->_key,
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
     * @param array|object $context Default configuration.
     * 
     * @return array
     */	
    public function prepare_push($context)
    {
        $fields = [];
        $fieldsConfig = ['name' => 'on', 'board' => 'on', 'list' => 'on'] 
            + ($this->_config['push.fields'] ?? $this->_pushDefaultFields);
        foreach ($fieldsConfig as $fieldName => $option) {
            if ($option !== 'on' || in_array($fieldName, ['checkItems'])) {
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
                    $field['depends_on'] = 'board';
                }
                if (in_array($configGroup['type'], ['text', 'string']) && !isset($field['size'])) {
                    $field['size'] = 'full';
                }
            }
            if ($fieldName === 'due') {
                $field['description'] = 'Example: 2020-01-30 12:00 All dates and times are UTC.';
            }
            $fields[$fieldName] = $field;
        }
        $result = ['fields' => $fields];

        return $result;
    }
    
    /**
     * Get Title Default
     * 
     * Fetch only title from an card details.
     * 
     * @param array|object $context Default configuration.
     * 
     * @return string
     */	
    private function _getTitleDefault($context): string
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
     * Get Options List
     * 
     * Builds and returns the option list for given array of object
     *
     * @param array $items Items array.
     * 
     * @return array
     */
    private function _getOptionsList(array $items): array
    {
        $result = [];
        foreach ($items ?? [] as $item) {
            $result[$item->id] = $item->name;
        }

        return $result;
    }
    
    /**
     * Prepare Field
     * 
     * Fetech possible values for default and custom fields.
     * 
     * @param array|object $context Default configuration.
     * @param array        $input   All field defaults passed as array.
     * @param string       $field   All field names default and custom fields. 
     * 
     * @return array
     */	
    public function prepare_field($context, $input, $field)
    {
        $data = [];
        $api = $this->_getApi();
        $prefs = $context['event'] === 'prepare' 
            ? arr::get($context, 'preferences') 
            : null;

        switch ($field) {
            case 'name':
                $data['default'] = $this->_getTitleDefault(
                    $context
                );
                break;
            case 'desc':
                $data['default'] = $this->_getDescriptionDefault(
                    $context
                );
                break;
            case 'board':
                $data['default'] = arr::get($prefs, 'board');
                $data['options'] = $this->_getOptionsList(
                    $api->getBoards()
                );
                break;
            case 'list':
                if (isset($input['board'])) {
                    $data['default'] = arr::get($prefs, 'list');
                    $data['options'] = $this->_getOptionsList(
                        $api->getLists($input['board'])
                    );
                }
                break;
            case 'assignee':
            case 'members':
                if (isset($input['board'])) {
                    $data['default'] = arr::get($prefs, 'assignee');
                    $data['options'] = $this->_getOptionsList(
                        $api->getAssignees($input['board'])
                    );
                }
                break;
            case 'labels':
                if (isset($input['board'])) {
                    $data['default'] = arr::get($prefs, 'labels');
                    $data['options'] = $this->_getOptionsList(
                        $api->getLabels($input['board'])
                    );
                }
                break;
            case 'checklists':
                if (isset($input['board'])) {
                    $data['default'] = arr::get($prefs, 'checklists');
                    $data['options'] = $this->_getOptionsList(
                        $api->getCheckLists($input['board'])
                    );
                }
                break;
            case 'pos':
                $data['default'] = arr::get($prefs, 'pos');
                $data['options'] = $this->_cardPositionList;
                break;
        }
        $field_settings = arr::get($this->_config, "field.settings.$field");
        if (isset($field_settings)) {
            if (isset($field_settings['idCustomField']) 
                && $field_settings['type'] === 'dropdown' 
                && $field_settings['api_type'] === 'dropdown') {
                $data['default'] = arr::get($prefs, $field);
                $data['options'] = $this->_getOptionsList(
                    $api->getCustomFieldList($field_settings['idCustomField'])
                );
            } elseif ($field_settings['type'] === 'dropdown' 
                && $field_settings['api_type'] === 'checked') {
                $data['default'] = arr::get($prefs, $field);
                $data['options'] = $this->_checkboxList;
            } else {
                // NOP
            }
        }

        return $data;
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
        return $this->_getApi()->addCard(   
            $input,
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
     * @param object $card  Current card details.
     * @param string $field Array of default field values.
     *
     * @return string|null
     */
    private function _getAttributeValue(object $card, array $field)
    {
        $api = $this->_getApi();
        $apiFieldDisplay = $field['api_field_display'] ?? '';
        $apiSubFieldDisplay = $field['api_subfield_display'] ?? '';
        if (property_exists($card, $apiFieldDisplay) && $apiFieldDisplay !== 'desc') {
            if (!is_object($card->$apiFieldDisplay)) {
                if (is_array($card->$apiFieldDisplay)) {
                    return implode(', ', array_column($card->$apiFieldDisplay, $apiSubFieldDisplay));
                } else {
                    if (in_array($apiFieldDisplay, ['shortUrl', 'shortLink'])) {
                        return str::format(
                            '<a target="_blank" href="{0}{1}">{1}</a>',
                            $apiFieldDisplay === 'shortLink' 
                                ? a($this->_address) : '',
                            a($card->$apiFieldDisplay)
                        );
                    }
                    if (in_array($apiFieldDisplay, ['due', 'dateLastActivity'])) {
                        return date::format_short_datetime(strtotime($card->$apiFieldDisplay));
                    }
                    if (is_string($card->$apiFieldDisplay) || is_integer($card->$apiFieldDisplay)) {
                        return $card->$apiFieldDisplay;
                    } else {
                        return $card->$apiFieldDisplay ? 'Yes' : static::DASH;
                    }
                }
            }
            if (is_object($card->$apiFieldDisplay)) {
                return $card->$apiFieldDisplay->$apiSubFieldDisplay;
            }
        } else {
            if ($apiFieldDisplay === 'checkItems') {
                $htmlData = '';
                foreach ($card->checklists ?? [] as $key => $eachCheckItems) {
                    $htmlData .= '<br><label><strong>'
                        . $card->checklists[$key]->name
                        . '</strong></label>';
                    $htmlData .= '<ul>';
                    foreach ($eachCheckItems->checkItems as $value) {
                        $htmlData .= '<li> &nbsp;'
                            . $value->name 
                            . ' - ' 
                            . $value->state
                            . '</li>';
                    }
                    $htmlData .= '</ul>';
                }

                return $htmlData;
            }
        }
        //Custom field section
        $idCustomField = $field['idCustomField'] ?? '';
        $apiTypeCustomField = $field['api_type'] ?? '';
        if (isset($idCustomField) && isset($apiTypeCustomField)) {
            foreach ($card->customFieldItems ?? [] as $customFields) {
                if ($customFields->idCustomField === $idCustomField) {
                    if ($apiTypeCustomField === 'dropdown') {
                        return $api->getCustomFieldDropDownValue(
                            $idCustomField, 
                            $customFields->idValue
                        );
                    }
                    if ($apiTypeCustomField === 'date') {
                        return date::format_short_datetime(
                            strtotime($customFields->value->$apiTypeCustomField)
                        );
                    }
                    return $customFields->value->$apiTypeCustomField;
                }
            }
        }
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
     * Lookup
     * 
     * Creates an array of objects of default and custom field with default and 
     * user defined configuration to display on hover popup.
     * 
     * @param int $cardId Id of a card.
     * 
     * @return array
     * 
     * @throws ValidationException
     */
    public function lookup($cardId): array
    {
        $card = $this->_getApi()->getCardDetails($cardId);
        $attributes = [];
        $fullAttributes = [];
        $description = null;
        $projectUrl = null;
        $fieldsConfig = $this->_config['hover.fields'] ?? $this->_hoverDefaultFields;
        foreach ($fieldsConfig as $fieldName => $option) {
            if ($option !== 'on' || in_array($fieldName, ['name', 'desc', 'attachments'])) {
                continue;
            }
            if (isset($this->_fieldDefaults[$fieldName])) {
                $field = $this->_fieldDefaults[$fieldName];
            } else {
                $field = str::starts_with($fieldName, 'customfield_')
                    ? $this->_getCategoryConfiguration($fieldName, $this->_config) 
                    : [];
            }
            if ($fieldName === 'board' && $option === 'on') {
                $projectUrl = a($card->board->url);
            }
            if (in_array($field['type'], ['text', 'string']) 
                && (!isset($field['size']) || $field['size'] === 'full')) {
                $multiLineTxt = $this->_getAttributeValue($card, $field);
                if (isset($field['api_field_display']) && $field['api_field_display'] === 'checkItems') {
                    $fullAttributes[$field['label']] = str::format(
                        '<div class="monospace">{0}</div>',
                        $multiLineTxt
                    ); 
                } else {
                    if (isset($multiLineTxt)) {
                        $fullAttributes[$field['label']] = str::format(
                            '<div class="monospace">{0}</div>',
                            strip_tags(html_entity_decode($multiLineTxt))
                        );
                    } else {
                        $fullAttributes[$field['label']] = '&ndash;';
                    }
                }
            } else {
                $attributes[$field['label']] = $this->_getAttributeValue($card, $field);
            }
        }
        $project_link = str::format(
            '<a target="_blank" href="{0}{1}">{1}</a>',
            a($this->_address),
            a($projectUrl ? $projectUrl : $card->url)
        );
        $status_id = $card->closed
            ? GI_DEFECTS_STATUS_RESOLVED
            : GI_DEFECTS_STATUS_OPEN;
        $status = $card->closed
            ? 'Archived'
            : 'Open';
        if (!empty($card->desc)) {
            $description = str::format(
                '<div class="monospace">{0}</div>',
                nl2br(
                    $card->desc
                )
            );
        }

        return [
            'id' => $cardId,
            'url' => str::format(
                '{0}',
                $projectUrl ? $projectUrl : $card->url
            ),
            'title' => $card->name,
            'status_id' => $status_id,
            'status' => $status,
            'description' => $description,
            'attributes' => $attributes,
            'fullAttributes' => $fullAttributes
        ];
    }
}
